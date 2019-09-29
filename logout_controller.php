<?php 
session_start();
error_reporting(0);

//check to see that the form has been submitted
//if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	unset($_SESSION["user_id"]);
	unset($_SESSION["user_name"]);	
	unset($_SESSION["user_type"]);	
	unset($_SESSION["shop_id"]);	
	
//	session_destroy();
	
//}
		
?>
