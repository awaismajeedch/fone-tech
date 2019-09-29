<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
				
	$id = $_REQUEST['txtrejid'];
	$inform = $_REQUEST['chkrejinformed'];
	/*if (isset($_REQUEST['chkrejinformed'])) {
		$inform = "yes";
	}
	else{
		$inform = "no";
	}*/
	//saving data to db
	$data = array(			
		"payment_received" => "'$inform'"		
	);
	
	//saving data to db
		
	
	$ids = $db->update($data, 'sale', 'id = '.$id);
	//echo $id;
	if (!empty($ids))
		echo 1;
	else
		echo 0;
}

?>
