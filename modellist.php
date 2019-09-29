
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
	$m = $_REQUEST['make'];
	if (!empty($m)) {
		$sql = "SELECT DISTINCT(model) FROM prices WHERE make = '$m' AND model like '%$q%'";
	} else {
		$sql = "SELECT DISTINCT(model) FROM prices WHERE model like '%$q%'";
	}	
	
	$data = $db->selectQuery($sql);	
	
	foreach ($data as $row) {
		$array[] = $row['model'];
	}
	//echo $data;
	//print_r ($array);
	echo json_encode($array); //Return the JSON Array
?>	
