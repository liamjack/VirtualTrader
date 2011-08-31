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

if(isset($_GET['m']))
{
	$m = $_GET['m'];
	
	switch($m)
	{
		case '1' :
			$auth->successmsg[] = "You are now logged in !";
			break;
			
		case '2' :
			$auth->errormsg[] = "You are already logged in !";
			break;
			
		case '3' :
			$auth->errormsg[] = "You are already registered !";
			break;
			
		case '4' :
			$auth->errormsg[] = "Your account is already activated !";
			break;
	}
}

$session = $auth->sessioninfo($_COOKIE['auth_session']);

$title = 'Members Area';

$content = 'Welcome <b>' . $session['username'] . '</b> !<br/><br/>Your UID : ' . $session['uid'] . '<br/>Session expiry date : ' . $session['expiredate'] . '<br/>Your IP : ' . $session['ip']
. '<br/><br/><span class="small"><a href="?page=changepass">Change Password ></a><br/><a href="?page=changeemail">Change Email ></a><br/><a href="?page=deleteaccount">Delete Account ></a><br/><br/><a href="?page=logout">Logout ></a></span>';

?>

