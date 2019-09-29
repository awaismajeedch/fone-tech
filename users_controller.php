<?php 
error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	//retrieve the $_POST variables		
	$lastname = $_REQUEST['txtlname'];	
	$firstname = $_REQUEST['txtfname'];	
	$username = $_REQUEST['txtuname'];	
	$password = $_REQUEST['txtpword'];		
	$usertype = $_REQUEST['cmbusertype'];		
	$shopid = $_REQUEST['cmbshop'];
	$userip1 = trim($_REQUEST['txtipadd']);
	$role = $_REQUEST['txtrole'];	
		
		
	if (!empty($_REQUEST['txtsdate'])) 
		$sdate = $_REQUEST['txtsdate'];	
	else
		$sdate = "0000-00-00";	
	
	if (!empty($_REQUEST['txtedate'])) 
		$edate = $_REQUEST['txtedate'];	
	else
		$edate = "0000-00-00";		
		
	if (!empty($userip1) && ($userip1) != "") 
		$userip = ip2long($userip1);	
	else 	
		$userip = "0";
		
	if (!empty($password)) {
		$password = md5($password);
	}	
	
	if (!empty($_REQUEST['txtuid'])) {
		$id = $_REQUEST['txtuid'] ;
		if (!empty($password)) {			
			//saving data to db
			$data = array(				
				"shop_id" => "$shopid",	
				"lastname" => "'$lastname'",
				"firstname" => "'$firstname'",
				"user_name" => "'$username'",				
				"password" => "'$password'",						
				"user_type" => "'$usertype'",
				"user_ip" => "$userip",
				"role" => "'$role'",
				"start_date" => "'$sdate'",
				"end_date" => "'$edate'",
				"created_at" => "'".date("Y-m-d H:i:s",time())."'"
			);
		} else {
			$data = array(				
				"shop_id" => "$shopid",	
				"lastname" => "'$lastname'",
				"firstname" => "'$firstname'",
				"user_name" => "'$username'",								
				"user_type" => "'$usertype'",	
				"user_ip" => "$userip",
				"role" => "'$role'",
				"start_date" => "'$sdate'",
				"end_date" => "'$edate'",	
				"created_at" => "'".date("Y-m-d H:i:s",time())."'"
			);
		}
		//Verify username does not exist already
		$chkid = $db->verifyName($username,$id);
		if ($chkid == 0 ) {
			$id = $db->update($data, 'users', 'id = '.$id);
		} else {
			echo 2;
			exit();
		}	
		
		
	} else {
		//saving data to db
		$udata = array(	
			"shop_id" => "$shopid",	
			"lastname" => "'$lastname'",
			"firstname" => "'$firstname'",
			"user_name" => "'$username'",				
			"password" => "'$password'",						
			"user_type" => "'$usertype'",
			"user_ip" => "'$userip'",
			"role" => "'$role'",
			"start_date" => "'$sdate'",
			"end_date" => "'$edate'",
			"created_by" => "1",				
			"created_at" => "'".date("Y-m-d H:i:s",time())."'"
			);		
		
		//Verify username does not exist already
		$chkid = $db->verifyName($username);
		if ($chkid == 0 ) {
			$id = $db->insert($udata, 'users');
		} else {
			echo 2;
			exit();
		}	
		
	}	
		
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
