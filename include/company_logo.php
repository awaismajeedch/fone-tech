<!DOCTYPE html>


<?php
	session_start();
	include_once 'global.inc.php';
	$compid  = $_SESSION['company_id'];
	
	$tablename="companies";
	$orderby = " ORDER BY created_at DESC";
	$where= "id=$compid";
		
	$data = $db->totalRecords($tablename, $where);
	$totalRecords = $data;	
	
	if ($totalRecords > 0) {
		$datar = $db->select($tablename, $orderby, $where);
		foreach ($datar as $row) { 
			$title = $row['company_name']; 
			$logo = $row['logo']; 			
		}
	}
	
?>	

