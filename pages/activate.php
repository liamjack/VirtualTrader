<?php

if(isset($_COOKIE['auth_session']))
{
	if($auth->checksession($_COOKIE['auth_session']))
	{
		header("Location: ?page=home");
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
	else
	{
		if(isset($auth->errormsg)) { echo "Error :"; foreach ($auth->errormsg as $emsg) { echo "$emsg<br/>"; } }
	}
}
else
{
	echo "No parameters provided.";
}

?>