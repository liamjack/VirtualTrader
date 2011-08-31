<?php

if(isset($_COOKIE['auth_session']))
{
	if($auth->checksession($_COOKIE['auth_session']))
	{
		header("Location: ?page=members");
		exit();
	}
}

$title = 'Welcome';

$content = 'VirtualTrader is a free virtual stock trading game, where users trade virtual shares of actual companies, at the actual live price !<br/><br/>Users
are started off with 200 $, and the aim of the game is to make as much money as you possibly can buy buying and selling shares.<br/><br/>
Users can easily track their progress and that of their friend\'s thanks to the leaderboard and the detailed user profile pages.<br/><br/>
<ul><li><a href="?page=login">Login</a></li><li><a href="?page=register">Register</a></li>';

?>