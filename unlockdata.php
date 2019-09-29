<?php 

//error_reporting(0);
require_once 'include/conn.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	//retrieve the $_POST variables
	$recid = $_REQUEST['uid'];
		
	$query = "";
	$str = "";
		
	$query = "SELECT * FROM unlock_data WHERE id=$recid";		
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
	// GOING THROUGH THE DATA
	if($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
			
		$str = 	"<b>Summary</b><br/><p style='color:#000;font-size:14px'>".$row['summary']."</p><b>Charges: &pound ".$row['price']."</b>,&nbsp;&nbsp;<b>Time: ".$row['duration']." Hours</b><br/><br/><b>Description: </b><br/><p style='color:#000;font-size:14px'>".$row['description']."</p>";									
			
			
		}		
	}
	
	echo $str;	
	
}	

?>
