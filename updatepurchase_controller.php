<?php 
error_reporting(0);

include_once 'include/global.inc.php';
//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	//retrieve the $_POST variables		
	//$invoice = trim($_REQUEST['txtinvoice']);			
	$make = trim($_REQUEST['txtmake']);			
	$model = trim($_REQUEST['txtmodel']);				
	$imei = trim($_REQUEST['txtimei']);		
	$customername = trim($_REQUEST['txtcsname']);		
	$password = trim($_REQUEST['txtcpwd']);		
	$contact = trim($_REQUEST['txtcsno']);		
	$defects = trim($_REQUEST['txtdefects']);		
	$address = trim($_REQUEST['txtcaddress']);		
	$network = trim($_REQUEST['txtnetwork']);		
	$price = trim($_REQUEST['txtprice']);		
	$sprice = trim($_REQUEST['txtsprice']);		
	$enteredby = trim($_REQUEST['txtrecby']);		
	$id = trim($_REQUEST['txtpid']);
	$ref = $_REQUEST['txtrefby'];
	$refid = $_REQUEST['txtrefid'];	
	
	//saving data to db
	$data = array(				
		"make" => "'$make'",
		"model" => "'$model'",
		"imei" => "'$imei'",
		"customer_name" => "'$customername'",
		"password" => "'$password'",
		"contact_number" => "'$contact'",
		"defects" => "'$defects'",
		"address" => "'$address'",
		"network" => "'$network'",		
		"price" => "'$price'",				
		"entered_by" => "'$enteredby'",
		"sprice" => "'$sprice'",
		"referrenceid" => "'$refid'",
		"referrence" => "'$ref'",
	);
	
	//saving data to db
	$id = $db->update($data, 'purchase', 'id = '.$id);
	
	if (!empty($id))
		echo $id;
	else
		echo 0;
}

?>
