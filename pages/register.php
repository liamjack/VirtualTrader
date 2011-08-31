<?php

if(isset($_COOKIE['auth_session']))
{
	if($auth->checksession($_COOKIE['auth_session']))
	{
		header("Location: ?page=members&m=3");
		exit();
	}
}

if($_POST)
{
	$auth->register($_POST['username'], $_POST['password'], $_POST['verifypassword'], $_POST['email']);
}

$title = 'Register';

$content = '<form method="post" action="?page=register">
<table class="center" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>Username :</td>
    <td><label for="username"></label>
    <input name="username" type="text" id="username" maxlength="30" /></td>
  </tr>
  <tr>
    <td>Password :</td>
    <td><label for="password"></label>
    <input name="password" type="password" id="password" maxlength="30" /></td>
  </tr>
  <tr>
    <td>Verify Password :</td>
    <td><label for="verifypassword"></label>
    <input name="verifypassword" type="password" id="verifypassword" maxlength="30" /></td>
  </tr>
  <tr>
    <td>Email :</td>
    <td><label for="email"></label>
    <input name="email" type="text" id="email" maxlength="100" /></td>
  </tr>
  <tr>
    <td colspan="2"><br /><input type="submit" value="Register &gt;" /></td>
  </tr>
</table>
</form><br/><span class="small"><a href="?page=login">I already have an account ></a></span>';

?>