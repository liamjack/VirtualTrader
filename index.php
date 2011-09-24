<?php

include("inc/auth.class.php");

$auth = new auth;

if(isset($_GET['page'])) { $page = $_GET['page']; } else { $page = 'home'; }

switch ($page)
{
    case 'home' :
        include("pages/home.php");
        break;
    
    case 'login' :
        include("pages/login.php");
        break;
        
    case 'register' :
        include("pages/register.php");
        break;
        
    case 'members' :
        include("pages/members.php");
        break;
        
    case 'logout' :
        include("pages/logout.php");
        break;
        
    case 'activate' :
        include("pages/activate.php");
        break;
        
    case 'forgot' :
        include("pages/forgot.php");
        break;
        
    case 'changepass' :
        include("pages/changepass.php");
        break;
        
    case 'changeemail' :
        include("pages/changeemail.php");
        break;
        
    case 'deleteaccount' :
        include("pages/deleteaccount.php");
        break;
        
    default :
        include("pages/home.php");
        break;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>VirtualTrader</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div class="reminder">Reminder : This layout is not final and is only used to display site functionality</div>
<div class="box">
<div class="logo"></div>
<?php

if(isset($_COOKIE['auth_session']))
{
    if($auth->checksession($_COOKIE['auth_session']))
    {
        $session = $auth->sessioninfo($_COOKIE['auth_session']); ?>
<div class="member">
    <div class="member-content">Welcome <b><?php echo $session['username']; ?></b><br>
    <br>
    <a href="?page=members">My Profile &gt;</a><br>
    <a href="?page=logout">Logout &gt;</a>
    </div>
</div>
<?php    }
}
?>
<div class="content">
<h1><?php echo $title; ?></h1>
<?php 
if(isset($auth->errormsg)) { echo "<span class=\"errormsg\">"; foreach ($auth->errormsg as $emsg) { echo "$emsg<br/>"; } echo "</span><br/>"; }
if(isset($auth->successmsg)) { echo "<span class=\"successmsg\">"; foreach ($auth->successmsg as $smsg) { echo "$smsg<br/>"; } echo "</span><br/>"; }  
?>
<?php echo $content; ?>
</div>
</div>
</body>
</html>