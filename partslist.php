

<?php
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
	
	
	$sql = "SELECT DISTINCT(part) FROM prices WHERE part like '%$q%'";
	
	$data = $db->selectQuery($sql);	
	
	foreach ($data as $row) {
		$array[] = $row['part'];
	}
	//echo $data;
	//print_r ($array);
	echo json_encode($array); //Return the JSON Array
?>	
