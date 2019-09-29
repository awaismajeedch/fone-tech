<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	$status = $_REQUEST['txtpstatus'];		
	$lnotes = $_REQUEST['txtlnotes'];			
	$id = $_REQUEST['txtrepid'];
	$labcharges = $_REQUEST['txtlabcharges'];
		
	//saving data to db
	$data = array(			
		"status" => "'$status'",
		"labnotes" => "'$lnotes'",
		"labcharges" => "'$labcharges'"
	);
	
	//saving data to db
		
	
	$id = $db->update($data, 'repairs', 'id = '.$id);
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
