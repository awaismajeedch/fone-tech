<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	$make = $_REQUEST['txtmake'];
	$model = $_REQUEST['txtmodel'];	
	$part = $_REQUEST['txtpart'];			
	$price = $_REQUEST['txtprice'];				
	$viewed = $_REQUEST['txtviewed'];	
	$comments = $_REQUEST['txtcomments'];
	
	
	$fname = $_FILES['txtfile']['name'];
	//http://codular.com/php-file-uploads
	if ((isset($fname)) && (!empty($fname))) {
		//$name = $_FILES['txtfile']['name'];
		$now = new DateTime();
		$name = $now->getTimestamp(); 
		$ext = pathinfo($fname, PATHINFO_EXTENSION);
		$uname = preg_replace('/\s+/', '', $name);
		$filename = $uname.".".$ext;
		$path = "documents/".$filename;
		
		/*
		if($_FILES['txtfile']['error'] > 0) {
			echo "An error ocurred when uploading!";			
			exit();	
		}
		*/
		if(!getimagesize($_FILES['txtfile']['tmp_name'])){
			echo "Please ensure you are uploading an image!";						
			exit();	
		}
		// Check filetype
		/*
		if($_FILES['txtfile']['type'] != 'IMAGE/image/PNG/png/JPG/jpg/JPEG/jpeg/GIF/gif/ICO/ico'){
			echo "Unsupported filetype uploaded!";						
			exit();
		}
		*/
		if(file_exists('documents/' . $filename)){
			unlink($path);							
			if (move_uploaded_file($_FILES['txtfile']['tmp_name'], $path) === false){
				echo "Error uploading image!";				
				exit();	
			}
		} else {
			if (move_uploaded_file($_FILES['txtfile']['tmp_name'], $path) === false){
				echo "Error uploading image!";				
				exit();	
			}
		}			
		
	}
	else {
		$filename = $_REQUEST['userdbimage'];
	}
	
	//saving data to db
	$data = array(	
		"make" => "'$make'",	
		"model" => 	"'$model'",
		"part" => "'$part'",
		"price" => "'$price'",
		"image_name" => "'$filename'",		
		"viewed" => "'$viewed'",
		"comments" => "'$comments'",
		"created_by" => "1",
		"created_at" => "'".date("Y-m-d H:i:s",time())."'"
	);
	
	//saving data to db
		
	if (!empty($_REQUEST['txtid'])) {		
		
		$id = $_REQUEST['txtid'] ;			   	    
		$id = $db->update($data, 'prices', 'id = '.$id);	    

	} else {
		
	  $id = $db->insert($data, 'prices');		
      
	}
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
