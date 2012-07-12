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
<h1>Welcome</h1>
<?php
if(isset($auth->errormsg)) { echo "<span class=\"errormsg\">"; foreach ($auth->errormsg as $emsg) { echo "$emsg<br/>"; } echo "</span><br/>"; }
if(isset($auth->successmsg)) { echo "<span class=\"successmsg\">"; foreach ($auth->successmsg as $smsg) { echo "$smsg<br/>"; } echo "</span><br/>"; }  
if(isset($virtualtrader->errormsg)) { echo "<span class=\"errormsg\">"; foreach ($virtualtrader->errormsg as $vemsg) { echo "$vemsg<br/>"; } echo "</span><br/>"; }
if(isset($virtualtrader->successmsg)) { echo "<span class=\"successmsg\">"; foreach ($virtualtrader->successmsg as $vsmsg) { echo "$vsmsg<br/>"; } echo "</span><br/>"; }  
?>
VirtualTrader is a free virtual stock trading game, where users trade virtual shares of actual companies, at the actual live price !<br/><br/>Users
are started off with 200 $, and the aim of the game is to make as much money as you possibly can buying and selling shares.<br/><br/>
Users can easily track their progress and that of their friend's thanks to the leaderboard and the detailed user profile pages.<br/><br/>
<a href="?page=login">&gt; Login</a><br />
<a href="?page=register">&gt; Register</a>
</div>
</div>
</body>
</html>