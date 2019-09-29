<?php
error_reporting(0);
 // a new connection
    require_once 'include/conn.php';
	
	$imei = $_REQUEST['txtimei'];	
	$id = $_REQUEST['txtid'];	
	
	if (!empty($id)) {
		$imeidb = $mysqli->query("SELECT imei from purchase where imei=$imei AND id != $id")->fetch_object()->imei;
	} else {
		$imeidb = $mysqli->query("SELECT imei from purchase where imei=$imei")->fetch_object()->imei;
	}
	
	//$imeidb = $mysqli->query("SELECT imei from unlocks where imei=".$imei)->fetch_object()->imei;
	//$checktype = $mysqli->query("SELECT MAX(check_type) as check_type from attendance")->fetch_object()->check_type;
	//echo $checktype;
	if (!empty($imeidb)) {
		echo 1;
	} else {
		echo 0;
	}	
		
?>	