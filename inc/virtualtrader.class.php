<?php

class VirtualTrader
{
	private $mysqli;
	public $errormsg;
	public $successmsg;
	
	private $db_host = "localhost";
	private $db_user = "root";
	private $db_pass = "";
	private $db_name = "virtualtrader";
	
	function __construct()
	{
		// Start a new MySQLi Connection
	
		$this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
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
		$stockinfo['price'] = $finance[0]->last['data']; // Stock price
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
}

?>