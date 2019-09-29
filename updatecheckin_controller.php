<?php 
//error_reporting(0);
ini_set('display_errors', 1);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	//retrieve the $_POST variables				
	$dt = trim($_REQUEST['txtdate']);
	$stime = trim($_REQUEST['txtstime']);
	$etime = trim($_REQUEST['txtetime']);
	$checkin = $dt." ".$stime.":00";
	$checkout = $dt." ".$etime.":00";
	$attendee = trim($_REQUEST['attendee']);	
	$status = trim($_REQUEST['txtastatus']);	
	$notes = trim($_REQUEST['txtnotes']);	
	$verified = trim($_REQUEST['txtverified']);	
	$shid = trim($_REQUEST['shid']);
	$usid = trim($_REQUEST['usid']);
	
		//saving data to db
		$data = array(		
			"shop_id" => "'$shid'",	
			"user_id" => "'$usid'",
			"user_name" => 	"'$attendee'",
			"checkin" => "'$checkin'",			
			"checkout" => "'$checkout'",
			"status" => "'$status'",	
			"notes" => "'$notes'",	
			"verified" => "'$verified'",	
		);
		
		//saving data to db
		if ((!empty($_REQUEST['txtattid'])) && ($_REQUEST['txtattid'] > 0 )) {		
		
			$id = $_REQUEST['txtattid'];			   	    	    
			
			$id = $db->update($data, 'attendance', 'id = '.$id);
		} else {
			
			$id = $db->insert($data, 'attendance');		
		  
		}
		
	
	if (!empty($id))
		echo $id;
	else
		echo 0;
}

?>
