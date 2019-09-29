<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	$name = $_REQUEST['txtname'];	
	$cname = $_REQUEST['txtcname'];	
	$address = $_REQUEST['txtaddress'];			
	$city = $_REQUEST['txtcity'];				
	$contact = $_REQUEST['txtcontact'];
	$cell = $_REQUEST['txtcell'];	
	$email = $_REQUEST['txtemail'];	
	$labid = $_REQUEST['cmblab'];
	$ulabid = $_REQUEST['cmbulab'];
	$dispname = $_REQUEST['txtdispname'];
	$status = $_REQUEST['cmbstatus'];	
	//saving data to db
	$data = array(			
		"name" => "'$name'",					
		"display_name" => "'$dispname'",					
		"address" => "'$address'",
		"city" => "'$city'",
		"contact_person" => "'$cname'",
		"contact" => "'$contact'",					
		"cellno" => "'$cell'",					
		"email" => "'$email'",	
		"labid" => "$labid",	
		"ulabid" => "$ulabid",
		"status" => "'$status'",
		"created_at" => "'".date("Y-m-d H:i:s",time())."'"
	);
	
	//saving data to db
		
	if (!empty($_REQUEST['txtid'])) {		
		
		$id = $_REQUEST['txtid'] ;			   	    	    
		$id = $db->update($data, 'shops', 'id = '.$id);
	} else {
		
	  $id = $db->insert($data, 'shops');		
      
	}
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
