<?php

if(isset($_COOKIE['auth_session']))
{
	if($auth->checksession($_COOKIE['auth_session']))
	{
		include("home-members.php");
	}
	else
	{
		include("home-guests.php");
	}
}
else
{
	include("home-guests.php");
}

?>