<?php 
error_reporting(0);
//ini_set('display_errors', 1);

include_once 'include/global.inc.php';
require_once 'classes/signature-to-image.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	//retrieve the $_POST variables	
	$shop_id = $_REQUEST['txtshop'];		
	//$invoice = trim($_REQUEST['txtinvoice']);			
	$make = trim($_REQUEST['txtmake']);			
	$model = trim($_REQUEST['txtmodel']);				
	$imei = trim($_REQUEST['txtimei']);		
	$customername = trim($_REQUEST['txtcsname']);		
	$password = trim($_REQUEST['txtcpwd']);		
	$contact = trim($_REQUEST['txtcsno']);		
	$defects = trim($_REQUEST['txtdefects']);		
	$address = trim($_REQUEST['txtcaddress']);		
	$network = trim($_REQUEST['txtnetwork']);		
	$price = trim($_REQUEST['txtprice']);		
	$signature = trim($_REQUEST['txtcsig']);		
	$enteredby = trim($_REQUEST['txtrecby']);		
	$created_by = trim($_REQUEST['txtcreatedby']);	
	$shopname = $_REQUEST['txtshopname'];
	$access = $_REQUEST['txtaccess'];
	$checks = $_REQUEST['txtchecks'];
	$other = $_REQUEST['txtother'];
	$status = 'instock';		
	$dt = new DateTime("now", new DateTimeZone('Europe/London'));	
	$edate = $dt->format('Y-m-d H:i:s');	
	$shemail  = "";
	
	$invoice = $db->updateInvoiceNo('purchase');
	
	// Converting Signatures to Image
	if (!empty($signature)) {
		//$img = sigJsonToImage($signature);
		$img = sigJsonToImage($signature, array('imageSize'=>array(340, 105)));
		$sigdate = new DateTime();
		$sigtime = $sigdate->getTimestamp(); 
		$csigname = preg_replace('/\s+/', '', $sigtime);
		$signame = $csigname . "_S.png"; 		
		imagepng($img, "documents/".$signame);
	}			
	
	$fname = $_FILES['txtfile']['name'];
	//http://codular.com/php-file-uploads
	
	if ((isset($fname)) && (!empty($fname))) {
		//$name = $_FILES['txtfile']['name'];
		$now = new DateTime();
		$name = $now->getTimestamp(); 		
		$ext = pathinfo($fname, PATHINFO_EXTENSION);
		//$ext = 'png';
		$uname = preg_replace('/\s+/', '', $name);
		$filename = $uname . "_I.png";			
		$path = "documents/".$filename;
		$tmpFilename = $_FILES['txtfile']['tmp_name'] ;
		imagepng(imagecreatefromstring(file_get_contents($tmpFilename)), $path, 9);
		
		/*
		if(!getimagesize($_FILES['txtfile']['tmp_name'])){
			echo "Please ensure you are uploading an image!";						
			exit();	
		}
		// Check filetype
		
		//if($_FILES['txtfile']['type'] != 'IMAGE/image/PNG/png/JPG/jpg/JPEG/jpeg/GIF/gif/ICO/ico'){
			//echo "Unsupported filetype uploaded!";						
			//exit();
		//}
		
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
		*/	
		
	}
	else {
		$filename = $_REQUEST['userdbimage'];
	}
	
	//saving data to db
	$data = array(	
		"shop_id" => "'$shop_id'",	
		"date_entered" => 	"'$edate'",
		"invoice" => "'$invoice'",	
		"make" => "'$make'",
		"model" => "'$model'",
		"imei" => "'$imei'",
		"customer_name" => "'$customername'",
		"password" => "'$password'",
		"contact_number" => "'$contact'",
		"defects" => "'$defects'",
		"address" => "'$address'",
		"network" => "'$network'",		
		"price" => "'$price'",
		"identification" => "'$filename'",		
		"signature" => "'$signature'",
		"signimage" => "'$signame'",
		"entered_by" => "'$enteredby'",
		"status" => "'$status'",
		"created_by" => "'$created_by'",
		"created_at" => "'".date("Y-m-d H:i:s",time())."'"
	);
	
	//saving data to db
	$id = $db->insert($data, 'purchase');		
	
	//Inserting phone accessories info to Misc table
	if (isset($access)) {
		$arrayacc = explode(',', $access);
		foreach($arrayacc as $tag_name){
		   //modify below to add $id along with $tag_name
		  $accessval = $tag_name;
		  $accesstype = 'accessories';
		  
		  $accessdata = array(
			"itemid" => "'$id'",	
			"value" => "'$accessval'",	
			"type" => 	"'$accesstype'",
		  );
		  $ids = $db->insert($accessdata, 'misc');	
		}
	}
	
	//Inserting phone checklist info to Misc table
	if (isset($checks)) {
		$arraychk = explode(',', $checks);
		
		foreach($arraychk as $checks_name){
		   //modify below to add $id along with $tag_name
		  $checksval = $checks_name;
		  $checkstype = 'check';
		  
		  $checksdata = array(
			"itemid" => "'$id'",	
			"value" => "'$checksval'",	
			"type" => 	"'$checkstype'",
		  );
		  $idc = $db->insert($checksdata, 'misc');	
		}
	}
	
	if (isset($other)) {
		$othdata = array(
			"itemid" => "'$id'",	
			"value" => "'$other'",	
			"type" => 	"'other'",
		  );
		  $ido = $db->insert($othdata, 'misc');		
	}
	
	//For sending email to SuperAdmin
	$sub = "New Phone $make-$model is purchased by $shopname";
	$mess = "Dear Sir,\n Please see below specs of the phone purchased by $shopname on $edate.\n";
	$mess = $mess."Customer Informaton: Customer Name : $customername; Contact: $contact, Address: $address.\n";
	$mess = $mess."Phone Specifications: Make : $make; Model: $model IMEI: $imei.\n";
	$mess = $mess."Network : $network; Defects: $defects Price: &pound $price.\n";
	
	$from = "From: fone-worlduk.com" . "\r\n";	
	//$to = "admin@foneworlduk.com";
	$to = "fonebuying@gmail.com";
	if (isset($to)) {
			/*
			//sendMail($to,$sub,$mess,$uname);
			if (mail ($to, $sub, $mess, $from)) {
				echo 1;
			} else {
				echo 0;
			}
			*/
			require_once('classes/class.phpmailer.php');
			include("classes/class.smtp.php");
			$mail = new PHPMailer();
			$mail->IsSMTP();			
			
			//$mail->Host =  "relay-hosting.secureserver.net"; //"smtpout.secureserver.net"; // //"smtp.aol.com";
			//$mail->SMTPSecure = 'tls'; 
			//For Local
			/*
			$mail->SMTPDebug  = 0;			
			$mail->SMTPAuth = true;
			$mail->Host = "smtp.aol.com";
			$mail->Port = 587;			
			*/
			//For Production
			$mail->SMTPDebug  = 0;			
			$mail->SMTPAuth = false;
			$mail->Host = "relay-hosting.secureserver.net";
			//$mail->Port = 25;			
			
			$mail->Username = "foneworlduk@aol.co.uk";
			$mail->Password = "b7948456305m";
			
			$from = "foneworlduk@aol.co.uk";
			//$mail->From = TO_EMAIL_ADDRESS;
			//$mail->From = FROM_NAME;
			$mail->SetFrom($from, 'fone-worlduk');			
			if (!empty($shemail)) {
				$mail->AddReplyTo($shemail);
			} else {			
				$mail->AddReplyTo("fonebuying@gmail.com");
			}	
			//$address = $email;
			$mail->AddAddress($to);
			$mail->Subject = $sub;   			
       		$mail->Body = $mess;									
		/*
		if(!$mail->Send()) {
			echo 0;
		} else {
			echo 1;
		}
		*/
		$mail->Send();
	}
	
	if (!empty($id))
		echo $id;
	else
		echo 0;
}

?>
