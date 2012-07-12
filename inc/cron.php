<?php

include("auth.class.php");
include("virtualtrader.class.php");

$auth = new Auth;
$virtualtrader = new VirtualTrader;

$auth->expireattempt();

$virtualtrader->UpdateStockDB();

?>