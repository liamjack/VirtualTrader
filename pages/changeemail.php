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

if($_POST['email'])
{
	$auth->changeemail($session['username'], $_POST['email']);
}

$title = 'Change Email';

$content = '<form action="?page=changeemail" method="post">
<table class="center" border="0" cellspacing="5" cellpadding="5">
<tr>
<td>New Email :</td>
<td><input type="text" name="email" maxlength="100" /></td>
</tr>
<tr>
<td colspan="2"><br/><input type="submit" value="Change Email >" /></td>
</tr>
</table></form><br/><span class="small"><a href="?page=members">Return to Members Area ></a><br/><br/><a href="?page=logout">Logout ></a></span>';

?>

