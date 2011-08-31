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

if($_POST['ans'] == 'Yes')
{
	if($auth->deleteaccount($session['username'], $_POST['password']))
	{
		header("Location: ?page=login&m=5");
		exit();
	}
}

$title = 'Delete Account';

$content = '<form action="?page=deleteaccount" method="post">
<table class="center" border="0" cellspacing="5" cellpadding="5">
<tr>
<td>Password :</td>
<td><input type="password" name="password" maxlength="30" /></td>
</tr>
<tr>
<td colspan="2"><br/>Are you sure you want to delete your account ?<br/><br/><input type="submit" name="ans" value="Yes" />     <input type="submit" name="ans" value="No" /></td>
</tr>
</table></form><br/><span class="small"><a href="?page=members">Return to Members Area ></a><br/><br/><a href="?page=logout">Logout ></a></span>';

?>

