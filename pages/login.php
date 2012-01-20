<?php

if(isset($_COOKIE['auth_session']))
{
	if($auth->checksession($_COOKIE['auth_session']))
	{
		header("Location: ?page=members&m=2");
		exit();
	}
}

if(isset($_GET['m']))
{
	$m = $_GET['m'];
	
	switch($m)
	{
		case '1' :
			$auth->errormsg[] = "You are not logged in !";
			break;
			
		case '2' :
			$auth->successmsg[] = "Account activated ! You can now login.";
			break;
			
		case '3' :
			$auth->successmsg[] = "Logged out successfully !";
			break;
			
		case '4' :
			$auth->errormsg[] = "Error encountered while logging out !";
			break;
			
		case '5' :
			$auth->successmsg[] = "Account successfully deleted !";
			break;
	}
}

if($_POST)
{
	if($_POST['rememberme'] == "1")
	{
		if($auth->login($_POST['username'], $_POST['password'], 1)) { header("Location: ?page=members&m=1"); exit(); }
	}
	else
	{
		if($auth->login($_POST['username'], $_POST['password'], 0)) { header("Location: ?page=members&m=1"); exit(); }
	}
}

$title = 'Login';

$content = '<form method="post" action="?page=login">
<table class="center" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>Username :</td>
    <td><input name="username" type="text" maxlength="30" /></td>
  </tr>
  <tr>
    <td>Password :</td>
    <td><input name="password" type="password" maxlength="30" /></td>
  </tr>
  <tr>
    <td colspan="2"><input name="rememberme" type="checkbox" value="1"> Remember Me</td>
    </tr>
  <tr>
    <td colspan="2"><br/><input type="submit" value="Login >" /></td>
    </tr>
</table>
</form><br/><span class="small"><a href="?page=forgot">Reset Password ></a><br/><a href="?page=register">Create a new account ></a></span>';
