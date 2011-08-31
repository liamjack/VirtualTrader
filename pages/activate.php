<?php

if(isset($_COOKIE['auth_session']))
{
	if($auth->checksession($_COOKIE['auth_session']))
	{
		header("Location: ?page=members&m=4");
		exit();
	}
}

if(isset($_GET['username']))
{
	if($auth->activate($_GET['username'], $_GET['key']))
	{
		header("Location: ?page=login&m=2");
		exit();
	}
}

$title = 'Activate Account';

$content = '';

?>