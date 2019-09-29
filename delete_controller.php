<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	$id = $_POST['id'];	
	$type = $_POST['type'];	
		
	//saving data to db
		
	if (!empty($_POST['id'])) {				
		
	    if ($type == 'price' ) {
			$ids = $db->delete($id,'prices');								   
		} 
		if ($type == 'user' ) {
			$ids = $db->deleteUser($id);								   
		}  
		if ($type == 'repair' ) {
			$ids = $db->deleteRepair($id);								   
		}  		
		if ($type == 'lab' ) {
			$ids = $db->deleteLab($id);								   
		}  
		if ($type == 'unlockdata' ) {
			$ids = $db->deleteUnlockdata($id);								   
		} 
		if ($type == 'unlock' ) {
			$ids = $db->deleteUnlock($id);								   
		}
		if ($type == 'purchase' ) {
			$ids = $db->deletePurchase($id);								   
		}
		if ($type == 'sale' ) {
			$ids = $db->deleteSale($id);								   
		}
	}
	
	if (!empty($ids))
		echo 1;
	else
		echo 0;
}

?>
