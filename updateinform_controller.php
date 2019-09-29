<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	//$inform = $_REQUEST['chkinformed'];			
	$id = $_REQUEST['txtrepid'];			
	if (isset($_REQUEST['chkinformed'])) {
		$inform = "yes";
	}
	else{
		$inform = "";
	}
	//saving data to db
	$data = array(			
		"informed" => "'$inform'"		
	);
	
	//saving data to db
		
	
	$id = $db->update($data, 'unlocks', 'id = '.$id);
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
