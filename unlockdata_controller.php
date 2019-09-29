<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	$summary = $_REQUEST['txtsummary'];	
	$description = $_REQUEST['txtdescription'];	
	$price = $_REQUEST['txtprice'];			
	$duration = $_REQUEST['txtdurations'];					
	$network = $_REQUEST['txtnetwork'];					
		
	//saving data to db
	$data = array(			
		"summary" => "'$summary'",					
		"description" => "'$description'",
		"price" => "'$price'",
		"duration" => "'$duration'",
		"network" => "'$network'",
		"created_by" => "1",
		"created_at" => "'".date("Y-m-d H:i:s",time())."'"
	);
	
	//saving data to db
		
	if (!empty($_REQUEST['txtid'])) {		
		
		$id = $_REQUEST['txtid'] ;			   	    	    
		$id = $db->update($data, 'unlock_data', 'id = '.$id);
	} else {
		
	  $id = $db->insert($data, 'unlock_data');		
      
	}
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
