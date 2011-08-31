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

$session = $auth->sessioninfo($_COOKIE['auth_session']);

if($_POST['currpass'])
{
	$auth->changepass($session['username'], $_POST['currpass'], $_POST['newpass'], $_POST['verifynewpass']);
}

$title = 'Change Password';

$content = '<form action="?page=changepass" method="post">
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
</table></form><br/><span class="small"><a href="?page=members">Return to Members Area ></a><br/><br/><a href="?page=logout">Logout ></a></span>';

?>

