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

$session = $auth->sessioninfo($_COOKIE['auth_session']);

$table = $virtualtrader->ListUserStocks($session['username'], $page, $amount = 10);

$title = 'My Stock List';

$content = $table;

?>

