<?php

include("inc/virtualtrader.class.php");

$virtualtrader = new VirtualTrader;

if($virtualtrader->UpdateStockDB())
{
	echo "Success !";
}
else 
{
	echo "Fail !";
}

?>
