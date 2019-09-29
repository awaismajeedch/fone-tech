
<?php
error_reporting(0);
/*
define('DEBUG',true);   
if(DEBUG){          
error_reporting(E_ALL);  
ini_set('display_errors', '1');  
}  
*/
 // a new connection
    include_once 'include/global.inc.php';
	
	$q = $_REQUEST['query'];	
	$u = $_REQUEST['users'];	
	if (!empty($q)) {
		if (!empty($u)) {
			$sql = "SELECT id,user_name FROM users WHERE shop_id = $q AND username like '%$u%'";
		} else {
			$sql = "SELECT id,user_name FROM users WHERE shop_id = $q";
		}	
			
		$data = $db->selectQuery($sql);	
		
		foreach ($data as $row) {
			$array[] = $row['user_name'];
		}
		//echo $data;
		//print_r ($array);
		echo json_encode($array); //Return the JSON Array
	}	
?>	
