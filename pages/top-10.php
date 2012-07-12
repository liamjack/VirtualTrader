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
    <div class="member-content">Welcome <b><?php echo $session['username']; ?></b><br>
    <br>
    <a href="?page=home">Home &gt;</a><br>
    <a href="?page=logout">Logout &gt;</a>
    </div>
</div>
<div class="content">
<h1>Top 10</h1>
<?php
if(isset($auth->errormsg)) { echo "<span class=\"errormsg\">"; foreach ($auth->errormsg as $emsg) { echo "$emsg<br/>"; } echo "</span><br/>"; }
if(isset($auth->successmsg)) { echo "<span class=\"successmsg\">"; foreach ($auth->successmsg as $smsg) { echo "$smsg<br/>"; } echo "</span><br/>"; }  
if(isset($virtualtrader->errormsg)) { echo "<span class=\"errormsg\">"; foreach ($virtualtrader->errormsg as $vemsg) { echo "$vemsg<br/>"; } echo "</span><br/>"; }
if(isset($virtualtrader->successmsg)) { echo "<span class=\"successmsg\">"; foreach ($virtualtrader->successmsg as $vsmsg) { echo "$vsmsg<br/>"; } echo "</span><br/>"; }  
?>
<?php if($data = $virtualtrader->GetTopUsers())
{
?>
<table width="95%" border="0" cellspacing="3" cellpadding="3">
<tr>
	<td width="20%" height="50"><b>Position :</b></td>
	<td width="50%"><b>Username :</b></td>
	<td width="20%"><b>Balance :</b></td>
	<td width="4%">&nbsp;</td>
</tr>
<?php 
$i = 1;

foreach($data as $table)
{ ?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $table['username']; ?></td>
	<td><?php echo $table['balance']; ?> $</td>
	<td><a href="?page=userinfo&username=<?php echo $table['username']; ?>"><img src="img/info.png" /></a></td>
</tr>
<?php $i++; } ?>
</table>
<?php } else { ?>
0 users in database !
<?php } ?>
</div>
</div>
</body>
</html>