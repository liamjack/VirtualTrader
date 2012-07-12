<?php

if(isset($_COOKIE['auth_session']))
{
	if($auth->checksession($_COOKIE['auth_session']))
	{
		header("Location: ?page=home");
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
	if($auth->login($_POST['username'], $_POST['password'])) { header("Location: ?page=home"); exit(); }
}

?>
<!DOCTYPE html>
<html>
<head>
<title>VirtualTrader</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<div class="reminder">Reminder : This layout is not final and is only used to display site functionality</div>
<div class="box">
<div class="logo"></div>
<div class="content">
<h1>Login</h1>
<?php
if(isset($auth->errormsg)) { echo "<span class=\"errormsg\">"; foreach ($auth->errormsg as $emsg) { echo "$emsg<br/>"; } echo "</span><br/>"; }
if(isset($auth->successmsg)) { echo "<span class=\"successmsg\">"; foreach ($auth->successmsg as $smsg) { echo "$smsg<br/>"; } echo "</span><br/>"; }  
if(isset($virtualtrader->errormsg)) { echo "<span class=\"errormsg\">"; foreach ($virtualtrader->errormsg as $vemsg) { echo "$vemsg<br/>"; } echo "</span><br/>"; }
if(isset($virtualtrader->successmsg)) { echo "<span class=\"successmsg\">"; foreach ($virtualtrader->successmsg as $vsmsg) { echo "$vsmsg<br/>"; } echo "</span><br/>"; }  
?>
<form method="post" action="?page=login">
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
    <td colspan="2"><br/><input type="submit" value="Login >" /></td>
    </tr>
</table>
</form><br/><span class="small"><a href="?page=resetpass">Reset Password ></a><br/><a href="?page=register">Create a new account ></a></span>
</div>
</div>
</body>
</html>