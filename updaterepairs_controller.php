<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
			
	//retrieve the $_POST variables	
	$shop_id = $_REQUEST['txtshop'];		
	$invoice = $_REQUEST['txtinvoice'];
	$make = $_REQUEST['txtmake'];			
	$model = $_REQUEST['txtmodel'];				
	$imei = $_REQUEST['txtimei'];
	$password = trim($_REQUEST['txtpass']);	
    $status = 'Inprogress';	
	$created_by = $_REQUEST['txtcreatedby'];	
	$notes = $_REQUEST['txtnotes'];	
	$id = $_REQUEST['txtid'] ;
	
	$dt = new DateTime("now", new DateTimeZone('Europe/London'));
	//print_r ($dt);
	$edate = $dt->format('Y-m-d H:i:s');
	
	//saving data to db
	$data = array(							
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
	$pkid = $db->update($data, 'repairs', 'id = '.$id);	      	
	
	if (!empty($id)) {
		$kid = $db->deletefaults($id);	      	
		
		foreach ($_REQUEST['txtfault'] as $row=>$name) {
			//echo $_REQUEST['txtactivity'][$row] ;
			if ($_REQUEST['txtfault'][$row] != "") {
				$fault = $_REQUEST['txtfault'][$row];
				$charges = $_REQUEST['txtprice'][$row];			
				
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
