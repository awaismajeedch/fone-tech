<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	$sprice = $_REQUEST['txtsprice'];			
	$id = $_REQUEST['txtrepid'];
	$status = 'sold';
		
	//saving data to db
	$data = array(			
		"status" => "'$status'",		
		"sprice" => "'$sprice'"
	);
	
	//saving data to db
		
	
	$id = $db->update($data, 'purchase', 'id = '.$id);
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
