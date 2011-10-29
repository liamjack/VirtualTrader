<?php

class VirtualTrader
{
    private $mysqli;
    public $errormsg;
    public $successmsg;
    
    function __construct()
    {
        include("config.php");
        
        $this->mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
    }
    
    function GetStockInfo($stockcode)
    {
        $url = "http://www.google.com/ig/api?stock=" . $stockcode;
        
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        
        $xml = simplexml_load_string($data);
        $finance = $xml->xpath("/xml_api_reply/finance");
        
        $stockinfo['code'] = $finance[0]->symbol['data']; // Stock code name (ex: GOOG)
        $stockinfo['name'] = $finance[0]->company['data']; // Stock Company Name (ex: Google Inc.)
        $stockinfo['exchange'] = $finance[0]->exchange['data']; // Stock Exchange name (ex: Nasdaq)
        $stockinfo['price'] = round($finance[0]->last['data'], 2); // Stock price
        $stockinfo['diff'] = $finance[0]->change['data']; // Stock Difference
        $stockinfo['diff_perc'] = $finance[0]->perc_change['data']; // Stock difference in percent
        
        return $stockinfo;
    }
    
    /*
    * Updates the entire stock database based on Stockcode
    * @return boolean
    */    
    
    function UpdateStockDB()
    {
        $query = $this->mysqli->prepare("SELECT code FROM stocks");
        $query->bind_result($stockcode);
        $query->execute();
        $query->store_result();
        $count = $query->num_rows;
        
        if($count == 0)
        {
            return false;
        }
        else 
        {
            while($query->fetch())
            {
                $stockinfo = $this->GetStockInfo($stockcode);
                
                $query2 = $this->mysqli->prepare("UPDATE stocks SET name=?, exchange=?, price=?, diff=?, diff_perc=? WHERE code=?");
                $query2->bind_param("ssddds", $stockinfo['name'], $stockinfo['exchange'], $stockinfo['price'], $stockinfo['diff'], $stockinfo['diff_perc'], $stockcode);
                $query2->execute();
                $query2->close();
            }
            
            return true;
        }
    }
	
	/*
    * Function to check if stock exists in Database based on Stock Code
    * @param string $stockcode
    * @return boolean
    */
    
    function CheckStock($stockcode)
    {
        $query = $this->mysqli->prepare("SELECT * FROM stocks WHERE code=?");
        $query->bind_param("s", $stockcode);
        $query->execute();
        $query->store_result();
        $count = $query->num_rows;
        $query->close();
        
        if($count == 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    /*
    * Adds x amount of shares to a user's account, and deducts the appropriate sum
    * @param string $stockcode
    * @param int $quantity
    * @param string $username
    * @return boolean
    */
    
    function BuyShare($stockcode, $quantity, $username)
    {
        if(strlen($stockcode) == 0) { $this->errormsg[] = "Error encountered !"; return false; }
        elseif(strlen($stockcode) > 10) { $this->errormsg[] = "Error encountered !"; return false; }
        if(!is_int($quantity)) { $this->errormsg[] = "Quantity is invalid ! ECODE : 1"; return false; }
        elseif($quantity < 0) { $this->errormsg[] = "Quantity is invalid ! ECODE : 2"; return false; }
        if(strlen($username) == 0) { $this->errormsg[] = "Error encountered !"; return false; }
        elseif(strlen($username) < 3) { $this->errormsg[] = "Error encountered !"; return false; }
        elseif(strlen($username) > 30) { $this->errormsg[] = "Error encountered !"; return false; }
        
        $quantity = round($quantity);
        
        if(count($this->errormsg) == 0)
        {
            $query = $this->mysqli->prepare("SELECT quantity FROM userstocks WHERE code=? AND username=?");
            $query->bind_param("ss", $stockcode, $username);
            $query->bind_result($db_quantity);
            $query->execute();
            $query->store_result();
            $count = $query->num_rows;
            $query->fetch();
            $query->close();
            
            if($count == 0)
            {
                // User has 0 shares for the provided stock code
                
                $stockinfo = $this->GetStockInfo($stockcode);
                
                $totalprice = round($quantity * $stockinfo['price'], 2);
                
                $query = $this->mysqli->prepare("SELECT balance FROM users WHERE username=?");
                $query->bind_param("s", $username);
                $query->bind_result($balance);
                $query->execute();
                $query->fetch();
                $query->close();
                
                if($totalprice <= $balance)
                {
                    // User has sufficient funds to purchase x quantity of shares
                    
                    $newbalance = $balance - $totalprice;
                    $newquantity = $quantity;
                    
                    $query = $this->mysqli->prepare("UPDATE users SET balance=? WHERE username=?");
                    $query->bind_param("ds", $newbalance, $username);
                    $query->execute();
                    $query->close();
                    
                    $query = $this->mysqli->prepare("INSERT INTO userstocks (code, username, quantity, p_price) VALUES (?, ?, ?, ?)");
                    $query->bind_param("ssdd", $stockcode, $username, $newquantity, $stockinfo['price']);
                    $query->execute();
                    $query->close();
                    
                    $this->LogActivity($username, "STOCK_BUY", "Purchased {$quantity} {$stockcode} shares for {$totalprice} $ - New Quantity : {$quantity} - Old Balance : {$balance} $ - New Balance : {$newbalance} $");
                    
                    $this->successmsg[] = "You have purchased $quantity $stockcode shares for {$totalprice} $ !";
                    return true;
                }
                else
                {
                    $this->errormsg[] = "You do not have sufficient funds !";
                    return false;
                }
                
            }
            else
            {
                // User already has existing shares for the provided stock code
            
                $stockinfo = $this->GetStockInfo($stockcode);
                
                $totalprice = round($quantity * $stockinfo['price'], 2);
                
                $query = $this->mysqli->prepare("SELECT balance FROM users WHERE username=?");
                $query->bind_param("s", $username);
                $query->bind_result($balance);
                $query->execute();
                $query->fetch();
                $query->close();
                
                if($totalprice <= $balance)
                {
                    // User has sufficient funds to purchase x quantity of shares
                    
                    $newbalance = $balance - $totalprice;
                    $newquantity = $db_quantity + $quantity;
                    
                    $query = $this->mysqli->prepare("UPDATE users SET balance=? WHERE username=?");
                    $query->bind_param("ds", $newbalance, $username);
                    $query->execute();
                    $query->close();
                    
                    $query = $this->mysqli->prepare("UPDATE userstocks SET quantity=?, p_price=? WHERE code=? AND username=?");
                    $query->bind_param("idss", $newquantity, $stockinfo['price'], $stockcode, $username);
                    $query->execute();
                    $query->close();
                    
                    $this->LogActivity($username, "STOCK_BUY", "Purchased {$quantity} {$stockcode} shares for {$totalprice} $ - New Quantity : {$newquantity} - Old Balance : {$balance} $ - New Balance : {$newbalance} $");
                    
                    $this->successmsg[] = "You have purchased {$quantity} {$stockcode} shares for {$totalprice} $ !";
                    $this->successmsg[] = "You now have {$newquantity} {$stockcode} shares.";
                    return true;
                }
                else
                {
                    $this->errormsg[] = "You do not have sufficient funds !";
                    return false;
                }
            }
            
        }
        else
        {
            return false;
        }          
    }
    
    /*
    * Removes x amount of shares from user's account, and pays user with the appropriate funds
    * @param string $stockcode
    * @param int $quantity
    * @param string $username
    * @return boolean
    */
    
    function SellShare($stockcode, $quantity, $username)
    {
        if(strlen($stockcode) == 0) { $this->errormsg[] = "Error encountered !"; return false; }
        elseif(strlen($stockcode) > 10) { $this->errormsg[] = "Error encountered !"; return false; }
        if(!is_int($quantity)) { $this->errormsg[] = "Quantity is invalid ! ECODE : 1"; return false; }
        elseif($quantity < 0) { $this->errormsg[] = "Quantity is invalid ! ECODE : 2"; return false; }
        if(strlen($username) == 0) { $this->errormsg[] = "Error encountered !"; return false; }
        elseif(strlen($username) < 3) { $this->errormsg[] = "Error encountered !"; return false; }
        elseif(strlen($username) > 30) { $this->errormsg[] = "Error encountered !"; return false; }
        
        $quantity = round($quantity);
        
        if(count($this->errormsg) == 0)
        {
            $query = $this->mysqli->prepare("SELECT quantity FROM userstocks WHERE code=? AND username=?");
            $query->bind_param("ss", $stockcode, $username);
            $query->bind_result($db_quantity);
            $query->execute();
            $query->store_result();
            $count = $query->num_rows;
            $query->fetch();
            $query->close();
            
            if($count == 0)
            {
                // User does not have any shares for the provided stockcode
                
                $this->errormsg[] = "You do not have any {$stockcode} shares to sell !";
                return false;
            }
            else
            {
                if($quantity > $db_quantity)
                {
                    // User is attempting to sell more shares than they have
                    
                    $this->errormsg[] = "You do not have that many {$stockcode} shares to sell !";
                    return false;
                }
                else
                {
                    // User has enough shares to complete transaction
                    
                    $newquantity = $db_quantity - $quantity;
                    
                    $stockinfo = $this->GetStockInfo($stockcode);
                
                    $totalprice = round($quantity * $stockinfo['price'], 2);
                    
                    $query = $this->mysqli->prepare("SELECT balance FROM users WHERE username=?");
                    $query->bind_param("s", $username);
                    $query->bind_result($db_balance);
                    $query->execute();
                    $query->fetch();
                    $query->close();
                    
                    $newbalance = $db_balance + $totalprice;
                    
                    if($newquantity == 0)
                    {
                        // User is selling all shares for provided stockcode => Delete the row
                        
                        $query = $this->mysqli->prepare("DELETE FROM userstocks WHERE code=? AND username=?");
                        $query->bind_param("ss", $stockcode, $username);
                        $query->execute();
                        $query->close();
    
                        $query = $this->mysqli->prepare("UPDATE users SET balance=? WHERE username=?");
                        $query->bind_param("ds", $newbalance, $username);
                        $query->execute();
                        $query->close();
                        
                        $this->LogActivity($username, "STOCK_SELL", "Sold  {$quantity} {$stockcode} shares for {$totalprice} $ - New Quantity :  0 - Old Balance : {$db_balance} $ - New Balance : {$newbalance} $");
                        
                        $this->successmsg[] = "You have sold {$quantity} {$stockcode} shares for {$totalprice} $ !";
                        $this->successmsg[] = "You have 0 {$stockcode} shares remaining.";
                        
                        return true;
                    }
                    else
                    {
                        // User will have shares left over after the transaction
                        
                        $query = $this->mysqli->prepare("UPDATE userstocks SET quantity=? WHERE code=? AND username=?");
                        $query->bind_param("iss", $newquantity, $stockcode, $username);
                        $query->execute();
                        $query->close();
                        
                        $query = $this->mysqli->prepare("UPDATE users SET balance=? WHERE username=?");
                        $query->bind_param("ds", $newbalance, $username);
                        $query->execute();
                        $query->close();
                        
                        $this->LogActivity($username, "STOCK_SELL", "Sold {$quantity} {$stockcode} shares for {$totalprice} $ - New Quantity : {$newquantity} - Old Balance : {$db_balance} $ - New Balance : {$newbalance} $");
                        
                        $this->successmsg[] = "You have sold {$quantity} {$stockcode} shares for {$totalprice} $ !";
                        $this->successmsg[] = "You have {$newquantity} {$stockcode} shares remaining.";
                        
                        return true;
                    }
                }
            }
        }
        else
        {
            return false;
        }
    }
    
    /*
    * Logs users actions on the site to database for future viewing
    * @param string $username
    * @param string $action
    * @param string $additionalinfo
    * @return boolean
    */
    
    function LogActivity($username, $action, $additionalinfo = "none")
    {
        if(strlen($username) == 0) { $this->errormsg[] = "Error encountered !"; return false; }
        elseif(strlen($username) < 3) { $this->errormsg[] = "Error encountered !"; return false; }
        elseif(strlen($username) > 30) { $this->errormsg[] = "Error encountered !"; return false; }
        
        if(strlen($action) == 0) { $this->errormsg[] = "Error encountered !"; return false; }
        elseif(strlen($action) < 3) { $this->errormsg[] = "Error encountered !"; return false; }
        elseif(strlen($action) > 100) { $this->errormsg[] = "Error encountered !"; return false; }
        
        if(strlen($additionalinfo) == 0) { $additionalinfo = "none"; }
        elseif(strlen($additionalinfo) > 500) { $this->errormsg[] = "Error encountered !"; return false; }
        
        if(count($this->errormsg) == 0)
        {
            $ip = $_SERVER['REMOTE_ADDR'];
            $date = date("Y-m-d H:i:s");
            
            $query = $this->mysqli->prepare("INSERT INTO activitylog (date, username, action, additionalinfo, ip) VALUES (?, ?, ?, ?, ?)");
            $query->bind_param("sssss", $date, $username, $action, $additionalinfo, $ip);
            $query->execute();
            $query->close();
            
            return true;
        }
    }
	
	/*
	* Fetch quantity of Shares for a user based on stock code
	* @param string $username
	* @param string $stockcode
	* @return int $quantity
	*/
	
	function ShareQty($username, $stockcode)
	{
		$query = $this->mysqli->prepare("SELECT quantity FROM userstocks WHERE username=? AND code=?");
		$query->bind_param("ss", $username, $stockcode);
		$query->bind_result($quantity);
		$query->execute();
		$query->store_result();
		$count = $query->num_rows;
		$query->fetch();
		$query->close();
		
		if($count == 0)
		{
			$quantity = 0;
			return $quantity;
		}
		else
		{
			return $quantity;
		}
	}
	
	/*
    * Returns a list of stocks available for trading (in table) based on page number
    * @param int $page
    * @param int $amount (Amount of results to display per page)
    * @param int $exchange (INT code of exchange)
    * @return string $table
    */
    
    function ListStocks($page = 1, $amount = 10, $exchange = 1)
    {
        if(!is_int($page)) { $page = 1; $mysqlpage = 0; } else { $mysqlpage = $page * 10 - 10; }
        if(!is_int($amount)) { $amount = 10; }
        if(!is_int($exchange)) { $exchange = 1; }
        
        if($exchange == 1) { $exchange_name = "Nasdaq"; }
        elseif($exchange == 2) { $exchange_name = "Potato"; }
        
        
        $query = $this->mysqli->prepare("SELECT * FROM stocks WHERE exchange=?");
        $query->bind_param("s", $exchange_name);
        $query->execute();
        $query->store_result();
        $count = $query->num_rows;
        $query->close();
        
        $totalpage = ceil($count / $amount);
        
        $i = 1;
        $numbering = "";

        while($i <= $totalpage)
        {
            if($i == $page) { $numbering .= " <a href=\"?page=stocks&pn=$i\">[$i]</a> "; }
            else { $numbering .= " <a href=\"?page=stocks&pn=$i\">$i</a> "; }
            $i++;
        }
        
        $query = $this->mysqli->prepare("SELECT name, code, price, diff, diff_perc FROM stocks WHERE exchange=? ORDER BY name ASC LIMIT ?,?");
        $query->bind_param("sii", $exchange_name, $mysqlpage, $amount);
        $query->bind_result($stockname, $stockcode, $stockprice, $stockdiff, $stockdiff_perc);
        $query->execute();
        $query->store_result();
        $count = $query->num_rows;
        
        if($count > 0)
        {
            $table = '<table width="95%" border="0" cellspacing="3" cellpadding="3"><tr>
                        <td width="40%" height="50"><b>Stock Name :</b></td>
                        <td width="15%"><b>Stock Code :</b></td>
                        <td width="13%"><b>Price :</b></td>
                <td width="20%"><b>Difference :</b></td>
                        <td width="4%">&nbsp;</td>
                      </tr>';
        
            while($query->fetch())
            {
                $stockprice = round($stockprice, 2);
                $stockdiff = round($stockdiff, 2);
                $stockdiff_perc = round($stockdiff_perc, 2);
            
                $table .= "<tr>
                            <td>{$stockname}</td>
                            <td>{$stockcode}</td>
                            <td>{$stockprice} $</td>
                            <td>{$stockdiff} ({$stockdiff_perc} %)</td>
                            <td><a href=\"?page=stockinfo&code={$stockcode}\"><img src=\"images/info.png\" /></a></td>
                            </tr>";
            }
            
            $table .= "</table>";
        }
        else
        {
            $table = "0 stocks found !";
        }
        
        $table .= "<br/><br/>";
        $table .= $numbering;
        
        return $table;
    }
}

?>