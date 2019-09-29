<?php 
error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	$shop_id = $_REQUEST['txtshop'];		
	$unlocks_id = $_REQUEST['cmbservice'];		
	$summary = trim($_REQUEST['txtsummary']);						
	$csname = trim($_REQUEST['txtcsname']);						
	$imei = trim($_REQUEST['txtimei']);	
	$model = trim($_REQUEST['txtmodel']);	
	$network = trim($_REQUEST['txtnetwork']);	
    $email = trim($_REQUEST['txtemail']);	
	$contact = trim($_REQUEST['txtcontact']);
	$charges = trim($_REQUEST['txtcharges']);	
	$duration = trim($_REQUEST['txtduration']);	
	$status = 'Inprogress';	
	$notes = trim($_REQUEST['txtnotes']);
	$lab_id = trim($_REQUEST['txtlab']);
	$created_by = trim($_REQUEST['txtcreatedby']);	
	
	$dt = new DateTime("now", new DateTimeZone('Europe/London'));
	//print_r ($dt);
	$edate = $dt->format('Y-m-d H:i:s');	
	
	//if (!empty($_REQUEST['txtinvoice'])) 
	//	$invoice = $_REQUEST['txtinvoice'];	
	//else
	//	$invoice = "0.00";	
	$invoice = $db->updateInvoiceNo('unlock');
	//saving data to db
	$data = array(			
		"shop_id" => "'$shop_id'",					
		"lab_id" => "'$lab_id'",					
		"date_entered" => "'$edate'",
		"invoice" => "'$invoice'",
		"unlocks_id" => "'$unlocks_id'",					
		"summary" => "'$summary'",		
		"imei" => "'$imei'",
		"model" => "'$model'",
		"network" => "'$network'",
		"charges" => "'$charges'",
		"duration" => "$duration",
		"status" => "'$status'",
		"notes" => "'$notes'",
		"name" => "'$csname'",
		"email" => "'$email'",
		"contact" => "'$contact'",
		"created_by" => "'$created_by'",				
		"created_at" => "'$edate'"
	);
	
	//saving data to db
		
	if (!empty($_REQUEST['txtid'])) {	
		
		$id = $_REQUEST['txtid'] ;
		$data = array(						
			"invoice" => "'$invoice'",
			"unlocks_id" => "'$unlocks_id'",					
			"summary" => "'$summary'",		
			"imei" => "'$imei'",
			"model" => "'$model'",
			"network" => "'$network'",
			"charges" => "'$charges'",
			"duration" => "$duration",			
			"notes" => "'$notes'",
			"name" => "'$csname'",
			"email" => "'$email'",
			"contact" => "'$contact'"
		);
			
		$id = $db->update($data, 'unlocks', 'id = '.$id);
	} else {
		
	  $id = $db->insert($data, 'unlocks');		
      
	}	
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
