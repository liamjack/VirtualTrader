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

if($_GET['code']) { $stockcode = $_GET['code']; } else { $virtualtrader->errormsg[] = "Stock code is invalid ! 1"; }

if($stockcode) { if(!$virtualtrader->CheckStock($stockcode)) { $virtualtrader->errormsg[] = "Stock code is invalid !"; } }

if(count($virtualtrader->errormsg) == 0) { $stockinfo = $virtualtrader->GetStockInfoDB($stockcode);	}

if(isset($_POST['action']))
{
	if($_POST['action'] == '1')
	{
		$quantity = (int) $_POST['quantity'];
		$virtualtrader->BuyShare($stockcode, $quantity, $session['username']);
	}
	elseif($_POST['action'] == '2')
	{
		$quantity = (int) $_POST['quantity'];
		$virtualtrader->SellShare($stockcode, $quantity, $session['username']);
	}
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
<h1>Stock Info <?php  if(isset($stockinfo)) { echo " - " . $stockinfo['name']; } ?></h1>
<?php
if(isset($auth->errormsg)) { echo "<span class=\"errormsg\">"; foreach ($auth->errormsg as $emsg) { echo "$emsg<br/>"; } echo "</span><br/>"; }
if(isset($auth->successmsg)) { echo "<span class=\"successmsg\">"; foreach ($auth->successmsg as $smsg) { echo "$smsg<br/>"; } echo "</span><br/>"; }  
if(isset($virtualtrader->errormsg)) { echo "<span class=\"errormsg\">"; foreach ($virtualtrader->errormsg as $vemsg) { echo "$vemsg<br/>"; } echo "</span><br/>"; }
if(isset($virtualtrader->successmsg)) { echo "<span class=\"successmsg\">"; foreach ($virtualtrader->successmsg as $vsmsg) { echo "$vsmsg<br/>"; } echo "</span><br/>"; }  
?>
<?php if(isset($stockinfo))
{
?>
<center><img src="http://chart.finance.yahoo.com/z?s=<?php echo $stockinfo['code']; ?>&t=5d&q=&l=&z=m&a=v&p=s" /></center>
<br/><br/>
Company Name : <?php echo $stockinfo['name']; ?>  <br/><br/>
Share Price : <?php echo $stockinfo['price']; ?>  $<br/>
Price Difference : <?php echo $stockinfo['diff']; ?> $ (<?php echo $stockinfo['diff_perc']; ?> %)<br/><br/>
<?php if($quantity = $virtualtrader->ShareQty($session['username'], $stockinfo['code']))
{
	$total = $quantity * $stockinfo['price'];

	if($quantity == 1) { echo "You have 1 " . $stockinfo['code'] . " share, which is currently worth {$total} $<br/><br/>"; }
	else { echo "You have {$quantity} " . $stockinfo['code'] . " shares, which are currently worth {$total} $<br/><br/>"; }
}
else
{
	echo "You have 0 " . $stockinfo['code'] . " shares<br/><br/>";
}

?>
Buy : <form method="post" action="?page=stockinfo&code=<?php echo $stockinfo['code']; ?>">
<input name="action" type="hidden" value="1">
<input name="quantity" type="text" maxlength="5" placeholder="Quantity">
<input type="submit" value="Buy &gt;">
</form><br/>
Sell : <form method="post" action="?page=stockinfo&code=<?php echo $stockinfo['code']; ?>">
<input name="action" type="hidden" value="2">
<input name="quantity" type="text" maxlength="5" placeholder="Quantity">
<input type="submit" value="Sell &gt;">
</form><br/>
<?php } else { ?>
0 users in database !
<?php } ?>
</div>
</div>
</body>
</html>