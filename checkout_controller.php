<?php 
//error_reporting(0);
//ini_set('display_errors', 1);

include_once 'include/global.inc.php';


//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	//retrieve the $_POST variables			
	
	$dt = new DateTime("now", new DateTimeZone('Europe/London'));	
	$edate = $dt->format('Y-m-d H:i:s');	
	$id = trim($_REQUEST['attendanceid']);				
	
	
	//saving data to db
	$data = array(			
		"checkout" => "'$edate'",
		"verified" => "'NULL'"	
	);
	
	//saving data to db
	$ids = $db->update($data, 'attendance', 'id = '.$id);		
	
	if (!empty($id))
		echo $edate;
	else
		echo 0;
}

?>
