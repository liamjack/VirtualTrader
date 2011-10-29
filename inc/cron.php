<?php

include("auth.class.php");
include("virtualtrader.class.php");

$auth = new auth;
$virtualtrader = new VirtualTrader;

$auth->expireattempt();
$virtualtrader->UpdateStockDB();

?>