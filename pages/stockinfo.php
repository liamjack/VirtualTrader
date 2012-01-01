<?php

if(isset($_COOKIE['auth_session']))
{
    if(!$auth->checksession($_COOKIE['auth_session']))
    {
        header("Location: ?page=login&m=1");
        exit();
    }
}
else
{
    header("Location: ?page=login&m=1");
    exit();
}
	$session = $auth->sessioninfo($_COOKIE['auth_session']);

    if($_GET['code']) { $stockcode = $_GET['code']; } else { $content = "Stock code is invalid ! 1"; }

    if($stockcode) { if(!$virtualtrader->CheckStock($stockcode)) { $virtualtrader->errormsg[] = "Stock code is invalid !"; } }
	
	if($_POST['action'] == '1')
	{
		$quantity = (int) $_POST['quantity'];
		$virtualtrader->BuyShare($stockcode, $quantity, $session['username']);
	}
	elseif($_POST['action'] == '2')
	{
		$quantity = (int) $_POST['quantity'];
		$virtualtrader->SellShare($stockcode, $quantity, $session['username']);
	}
    
    $stockinfo = $virtualtrader->GetStockInfo($stockcode);
       
        $content = "<center><img src=\"http://chart.finance.yahoo.com/z?s={$stockcode}&t=5d&q=&l=&z=m&a=v&p=s\" /></center>";
        $content .= "<br/><br/>";
        $content .= "Company Name : " . $stockinfo['name'] . "<br/>";
        $content .= "Exchange : " . $stockinfo['exchange'] . "<br/><br/>";
        $content .= "Share Price : " . $stockinfo['price'] . " $<br/>";
        $content .= "Price Difference : " . $stockinfo['diff'] . " $ (" . $stockinfo['diff_perc'] . " %)<br/><br/>";
		
		if($virtualtrader->ShareQty($session['username'], $stockcode) > 0)
		{		
			$qty = $virtualtrader->ShareQty($session['username'], $stockcode);
			$ttlvalue = $qty * $stockinfo['price'];
			
			if($qty == 1)
			{
				$content .= "<br/>You have {$qty} {$stockcode} share, which is currently worth {$ttlvalue} $ .<br/><br/>";
			}
			else
			{
				$content .= "<br/>You have {$qty} {$stockcode} shares, which are currently worth {$ttlvalue} $ .<br/><br/>";
			}
		}
		else
		{
			$content .= "<br/>You have 0 {$stockcode} shares.<br/><br/>";
		}
		
        $content .= 'Buy : <form method="post" action="?page=stockinfo&code=' . $stockcode . '">
					 <input name="action" type="hidden" value="1">
					 <input name="quantity" type="text" maxlength="5" value="Quantity">
					 <input type="submit" value="Buy &gt;">
					 </form><br/>';
        $content .= 'Sell : <form method="post" action="?page=stockinfo&code=' . $stockcode . '">
					 <input name="action" type="hidden" value="2">
					 <input name="quantity" type="text" maxlength="5" value="Quantity">
					 <input type="submit" value="Sell &gt;">
					 </form><br/>';
        
    $title = "Stock Info : " . htmlentities(addslashes($stockcode));

?>