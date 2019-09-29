<?php 
error_reporting(0);

include_once 'include/global.inc.php';
require_once 'classes/signature-to-image.php';
require_once 'classes/SaveAsPDF.php';
//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	//retrieve the $_POST variables	
	$shop_id = $_REQUEST['txtshop'];			
	$pid = $_REQUEST['txtpid'];			
	$make = trim($_REQUEST['txtmake']);			
	$model = trim($_REQUEST['txtmodel']);				
	$imei = trim($_REQUEST['txtimei']);				
	$access = trim($_REQUEST['txtaccess']);	
	$price = trim($_REQUEST['txtsprice']);		
	$grade = trim($_REQUEST['txtgrade']);		
	$customername = trim($_REQUEST['txtcsname']);					
	$sellby = trim($_REQUEST['txtsellby']);		
	$pmode = trim($_REQUEST['txtmode']);		
	$signature = trim($_REQUEST['txtcsig']);	
	$created_by = trim($_REQUEST['txtcreatedby']);	
	$shopname = $_REQUEST['txtdispname'];
	$ref = $_REQUEST['txtrefby'];
	$refid = $_REQUEST['txtrefid'];

	if (!empty($_REQUEST['txtsprice'])) 
		$price = $_REQUEST['txtsprice'];	
	else
		$price = "0.00";	
	
	$shemail = "";
	$dt = new DateTime("now", new DateTimeZone('Europe/London'));
	//print_r ($dt);
	$edate = $dt->format('Y-m-d H:i:s');	
	$invoice = $db->updateInvoiceNo('sale');
	// Converting Signatures to Image
	if (isset($signature)) {
		//$img = sigJsonToImage($signature);
		$img = sigJsonToImage($signature, array('imageSize'=>array(340, 105)));
		$sigdate = new DateTime();
		$sigtime = $sigdate->getTimestamp(); 
		$csigname = preg_replace('/\s+/', '', $sigtime);
		$signame = $csigname.'.png';
		
		imagepng($img, "documents/".$signame);
	}			
	
	
	//saving data to db
	$data = array(	
		"shop_id" => "'$shop_id'",	
		"purchaseid" => "'$pid'",	
		"date_entered" => 	"'$edate'",	
		"invoice" => "'$invoice'",	
		"make" => "'$make'",
		"model" => "'$model'",
		"imei" => "'$imei'",
		"accessories" => "'$access'",
		"customer_name" => "'$customername'",		
		"price" => "'$price'",		
		"grade" => "'$grade'",
		"signature" => "'$signature'",
		"signimage" => "'$signame'",
		"entered_by" => "'$sellby'",
		"payment_mode" => "'$pmode'",
		"referrenceid" => "'$refid'",
		"referrence" => "'$ref'",
		"created_by" => "'$created_by'",
		"created_at" => "'".date("Y-m-d H:i:s",time())."'"
	);
	
	//saving data to db
	$id = null;
	// if($db->selectQuery("select * from sale where imei like '$imei'") == 0){
		$id = $db->insert($data, 'sale');		
		//Updating Purchase Table for sold records
		$status = 'sold';
			
		//saving data to db
		$pdata = array(			
			"status" => "'$status'",				
		);
		
		$ids = $db->update($pdata, 'purchase', 'id = '.$pid);
		
		// For Genrating and Saving PDF File
		$savPdf = SalePDF($id); 	
		
		//For sending email to SuperAdmin
		$sub = "Phone $make-$model is sold by $shopname";
		$mess = "Dear Sir,\n Please see below specs of the phone sold by $shopname on $edate.\n";
		$mess = $mess."Customer Informaton: Customer Name : $customername; \n";
		$mess = $mess."Phone Specifications: Make : $make; Model: $model IMEI: $imei.\n";
		$mess = $mess."Price: &pound $price.\n";
		
		$from = "From: fone-worlduk.com" . "\r\n";
		//$to = "imran@broadstonetech.com";
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
			//For Production on fone-worlduk.com
			/*
			$mail->SMTPDebug  = 0;			
			$mail->SMTPAuth = false;
			$mail->Host = "relay-hosting.secureserver.net";
			//$mail->Port = 25;			
			
			$mail->Username = "foneworlduk@aol.co.uk";
			$mail->Password = "b7948456305m";
			*/
			//For Production on foneworld-phoneparts.biz
			$mail->SMTPDebug  = 0;			
			$mail->SMTPAuth = false;			
			$mail->Host ="smtp.mandrillapp.com"; 
			$mail->Port = 587;
			//$mail->Username =  "alert@powerbank.com.my"; 
			//$mail->Password = "JVj3PuwOJJQqmAMFNFLoJQ";
			$mail->Username = "foneworlduk@aol.co.uk";
			$mail->Password = "b7948456305m";
			
			$from = "foneworlduk@aol.co.uk";			
			//$mail->SetFrom($from, 'fone-worlduk');		
			$mail->SetFrom($shopname);		
			
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
	// }
	
	if (!empty($id))
		echo $id;
	else
		echo 0;
}

?>
