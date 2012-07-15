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

if(isset($_POST['currpass']))
{
	$auth->changepass($session['username'], $_POST['currpass'], $_POST['newpass'], $_POST['verifynewpass']);
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
<div class="member">
    <div class="member-content">Welcome <b><?php echo $session['username']; ?></b> (<?php echo $userbalance; ?> $)<br>
    <br>
    <a href="?page=home">Home &gt;</a><br>
    <a href="?page=logout">Logout &gt;</a>
    </div>
</div>
<div class="content">
<h1>Change Password</h1>
<?php
if(isset($auth->errormsg)) { echo "<span class=\"errormsg\">"; foreach ($auth->errormsg as $emsg) { echo "$emsg<br/>"; } echo "</span><br/>"; }
if(isset($auth->successmsg)) { echo "<span class=\"successmsg\">"; foreach ($auth->successmsg as $smsg) { echo "$smsg<br/>"; } echo "</span><br/>"; }  
if(isset($virtualtrader->errormsg)) { echo "<span class=\"errormsg\">"; foreach ($virtualtrader->errormsg as $vemsg) { echo "$vemsg<br/>"; } echo "</span><br/>"; }
if(isset($virtualtrader->successmsg)) { echo "<span class=\"successmsg\">"; foreach ($virtualtrader->successmsg as $vsmsg) { echo "$vsmsg<br/>"; } echo "</span><br/>"; }  
?>
<form action="?page=change-pass" method="post">
<table class="center" border="0" cellspacing="5" cellpadding="5">
<tr>
<td>Current Password :</td>
<td><input type="password" name="currpass" maxlength="30" /></td>
</tr>
<tr>
<td>New Password :</td>
<td><input type="password" name="newpass" maxlength="30" /></td>
</tr>
<tr>
<td>Verify New Password :</td>
<td><input type="password" name="verifynewpass" maxlength="30" /></td>
</tr>
<tr>
<td colspan="2"><br/><input type="submit" value="Change Password >" /></td>
</tr>
</table></form><br/><span class="small"><a href="?page=home">Return to the Homepage ></a></span>
</div>
</div>
</body>
</html>