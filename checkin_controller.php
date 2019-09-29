<?php 
//error_reporting(0);
//ini_set('display_errors', 1);

include_once 'include/global.inc.php';
require_once 'classes/signature-to-image.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	//retrieve the $_POST variables			
	$signature = trim($_REQUEST['output']);			
	$shpid = trim($_REQUEST['txtshpid']);	
	$dt = new DateTime("now", new DateTimeZone('Europe/London'));	
		
	$attendee = trim($_REQUEST['attendee']);				
	$attendeeid = trim($_REQUEST['attendeeid']);				
		
	$tedate = $dt->format('H:i');
	$tsdate = '09:00';
	
	if ($tedate < $tsdate ) {
		$edate = $dt->format('Y-m-d');
		$edate = $edate ." 09:00:00";
	}	
	else
		$edate = $dt->format('Y-m-d H:i:s');
	
	// Converting Signatures to Image
	if (!empty($signature)) {
		//$img = sigJsonToImage($signature);
		$img = sigJsonToImage($signature, array('imageSize'=>array(340, 105)));
		$sigdate = new DateTime();
		$sigtime = $sigdate->getTimestamp(); 
		$csigname = preg_replace('/\s+/', '', $sigtime);
		$signame = $csigname . "_A.png"; 		
		imagepng($img, "documents/".$signame);
	}
	
	if (!empty($attendee)) {
		//saving data to db
		$data = array(	
			"shop_id" => "'$shpid'",	
			"user_id" => "'$attendeeid'",	
			"user_name" => 	"'$attendee'",
			"checkin" => "'$edate'",			
			"signature" => "'$signature'",
			"signature_path" => "'$signame'"						
		);
		
		//saving data to db
		
		$id = $db->insert($data, 'attendance');		
	} 
	else 
		$id ="";
	
	if (!empty($id))
		echo $edate;
	else
		echo 0;
}

?>
