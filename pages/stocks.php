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

    if($_GET['pn']) { $page = (int) $_GET['pn']; }

$table = $virtualtrader->ListStocks($page, $amount = 10, $exchange = 1);

$session = $auth->sessioninfo($_COOKIE['auth_session']);


$title = 'Stock List';

$content = $table;

?>

