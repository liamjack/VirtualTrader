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

if(isset($_GET['username']))
{
	if($balance = $virtualtrader->GetUserBalance($_GET['username']))
	{
		$username = $_GET['username'];
		
		include("userinfo-1.php");
	}
	else
	{
		include("userinfo-2.php");
	}
}
else
{
	include("userinfo-3.php");
}

?>