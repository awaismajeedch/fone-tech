
<?php
error_reporting(0);
session_start();
 // a new connection
    require_once 'include/conn.php';
	$shopid = $_SESSION['shop_id'];
	$unlocked = $mysqli->query("SELECT count(id) as cntCheck from unlocks where checked='no' AND status = 'Success' AND shop_id = $shopid")->fetch_object()->cntCheck;
	echo $unlocked;	
?>	
