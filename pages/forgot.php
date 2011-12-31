<?php

if(isset($_POST['email']))
{
	$auth->resetpass('0', $_POST['email']);
}

if(isset($_POST['username']))
{
	$auth->resetpass($_POST['username'], '0', $_POST['key'], $_POST['newpass'], $_POST['verifynewpass']);
}

if(!isset($_GET['username']))
{
	$title = 'Reset Password';
	
	$content = '<form method="post" action="?page=forgot">
Email : <input name="email" type="text" id="email" maxlength="100">
<br>
<br>
<input type="submit" value="Reset Password &gt;">
</form><br/><span class="small"><a href="?page=home">Return to the homepage ></a></span>';

}
else
{
	if($auth->checkresetkey($_GET['username'], $_GET['key']))
	{
		$title = 'Reset Password';
	
		$content = '<form method="post" action="?page=forgot">
		<input type="hidden" name="username" value="' . $_GET['username'] . '"><input type="hidden" name="key" value="' . $_GET['key'] . '">
  <table class="center" width="356" border="0" cellspacing="3" cellpadding="3">
    <tr>
      <td width="163">
      New Password :</td>
      <td width="172"><input name="newpass" type="password" maxlength="30"></td>
    </tr>
    <tr>
      <td>Verify New Password :</td>
      <td><input name="verifynewpass" type="password" maxlength="30"></td>
    </tr>
    <tr>
      <td colspan="2"><br><input type="submit" value="Reset Password &gt;"></td>
    </tr>
  </table>
</form><br/><span class="small"><a href="?page=home">Return to the homepage ></a></span>';
	}
	else
	{
		$title = "";
		$content = "";
	}
}

?>