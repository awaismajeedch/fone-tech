<?php 

//error_reporting(0);
require_once 'include/conn.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	//retrieve the $_POST variables
	$username = $_REQUEST['txtempname'];
	$pass_word = $_REQUEST['txtemppass'];	
	$shid = $_REQUEST['txtshpid'];	
	$password = md5($pass_word);
	$query = "";
	
	//$query = "SELECT * FROM users WHERE user_name='$username' AND password = '$password' AND shop_id = $shid";		
	$query = "SELECT * FROM users WHERE user_name='$username' AND password = '$password'";		
	
	//echo $query;
	
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
		
	if($result->num_rows > 0) {
		session_start();
		while($row = $result->fetch_assoc()) {
			$_SESSION["attendee"] = $row['user_name'];
			$_SESSION["attendeeid"] = $row['id'];
			$_SESSION["attendeename"] = $row['lastname'] .", ".$row['firstname'];
		}	
		
		echo 'markattendance.php';									
	}
	else {
		echo 0;			
	}
	exit();
}	

?>
