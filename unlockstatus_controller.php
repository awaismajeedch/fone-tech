<?php 
error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables		
	$id = $_POST['rid'];			
		
	//saving data to db
	$data = array(					
		"checked" => "'yes'"		
	);
	
	//saving data to db
		
	
	$ids = $db->update($data, 'unlocks', 'id = '.$id);
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
