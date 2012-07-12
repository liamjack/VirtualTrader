<?php

if(isset($_COOKIE['auth_session']))
{
	if($auth->checksession($_COOKIE['auth_session']))
	{
		header("Location: ?page=home");
		exit();
	}
}

if(isset($_POST['email']))
{
	$auth->resetpass('0', $_POST['email']);
}

if(isset($_POST['username']))
{
	$auth->resetpass($_POST['username'], '0', $_POST['key'], $_POST['newpass'], $_POST['verifynewpass']);
}

if(!isset($_GET['username']))
{
	include("resetpass-1.php");
}
else
{
	$username = $_GET['username'];
	$key = $_GET['key'];

	if($auth->checkresetkey($username, $key))
	{
		include("resetpass-2.php");
	}
	else
	{
		include("resetpass-3.php");
	}
}

?>