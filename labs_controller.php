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
	$lab_type = $_REQUEST['cmblabtype'];	
		
	//saving data to db
	$data = array(			
		"name" => "'$name'",					
		"address" => "'$address'",
		"city" => "'$city'",
		"contact_person" => "'$cname'",
		"contact" => "'$contact'",					
		"cellno" => "'$cell'",					
		"email" => "'$email'",
		"lab_type" => "'$lab_type'",
		"created_at" => "'".date("Y-m-d H:i:s",time())."'"
	);
	
	//saving data to db
		
	if (!empty($_REQUEST['txtid'])) {		
		
		$id = $_REQUEST['txtid'] ;			   	    	    
		$id = $db->update($data, 'labs', 'id = '.$id);
	} else {
		
	  $id = $db->insert($data, 'labs');		
      
	}
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
