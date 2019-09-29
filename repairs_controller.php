<?php 
error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	$shop_id = $_REQUEST['txtshop'];		
	$invoice = trim($_REQUEST['txtinvoice']);			
	$make = trim($_REQUEST['txtmake']);			
	$model = trim($_REQUEST['txtmodel']);				
	$imei = trim($_REQUEST['txtimei']);	
	$password = trim($_REQUEST['txtpass']);	
    $status = 'Inprogress';	
	$notes = trim($_REQUEST['txtnotes']);
	$lab_id = trim($_REQUEST['txtlab']);
	$created_by = trim($_REQUEST['txtcreatedby']);	
	
	$dt = new DateTime("now", new DateTimeZone('Europe/London'));
	//print_r ($dt);
	$edate = $dt->format('Y-m-d H:i:s');	
	
	if (!empty($_REQUEST['txtinvoice'])) 
		$invoice = $_REQUEST['txtinvoice'];	
	else
		$invoice = "0.00";	
		
	//saving data to db
	$data = array(			
		"shop_id" => "'$shop_id'",					
		"lab_id" => "'$lab_id'",					
		"date_entered" => "'$edate'",
		"invoice" => "'$invoice'",
		"make" => "'$make'",
		"model" => "'$model'",
		"imei" => "'$imei'",	
		"password" => "'$password'",		
		"status" => "'$status'",
		"notes" => "'$notes'",
		"created_by" => "'$created_by'",				
		"created_at" => "'$edate'"
	);
	
	//saving data to db
		
	if (!empty($_REQUEST['txtid'])) {	
		
		$id = $_REQUEST['txtid'] ;			   	    	    
		$id = $db->update($data, 'repairs', 'id = '.$id);
	} else {
		
	  $id = $db->insert($data, 'repairs');		
      
	}
	if (!empty($id)) {	
		foreach ($_REQUEST['txtfault'] as $row=>$name) {
			//echo $_REQUEST['txtactivity'][$row] ;
			if ($_REQUEST['txtfault'][$row] != "") {
				$fault = trim($_REQUEST['txtfault'][$row]);
				$charges = trim($_REQUEST['txtprice'][$row]);			
				
				$faults = array(	
					"repair_id" => "$id",
					"fault" => "'$fault'",
					"charges" => "'$charges'"
				);
				
				$ids = $db->insert($faults, 'repair_faults');
			}
		}
		$sid = $db->updateCharges($id);
	}	
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
