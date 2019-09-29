<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	$labcharges = $_REQUEST['txtlabcharges'];		
	$paid = $_REQUEST['txtpaid'];		
	$ppaid = $_REQUEST['txtppaid'];		
	$totalp = $paid + $ppaid ;
	$id = $_REQUEST['txtrepid'];			
		
	//saving data to db
	$data = array(			
		"labcharges" => "'$labcharges'",
		"paid" => "'$totalp'"		
	);
	
	//saving data to db
		
	
	$id = $db->update($data, 'repairs', 'id = '.$id);
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
