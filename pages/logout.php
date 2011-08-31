<?php

if(isset($_COOKIE['auth_session']))
{
	$auth->deletesession($_COOKIE['auth_session']);
	
	header("Location: ?page=login&m=3");
	exit();
}
else
{
	header("Location: ?page=login&m=4");
	exit();
}

?>