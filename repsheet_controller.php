<?php 
error_reporting(0);
//ini_set('display_errors', 1);

include_once 'include/global.inc.php';
require_once 'classes/signature-to-image.php';
require_once 'classes/ConvertToPng.php';
require_once 'classes/SaveAsPDF.php';
require_once 'include/conn.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
	$rsid = $_REQUEST['txtrepshid'];
	
	//retrieve the $_POST variables	
		$shop_id = $_REQUEST['txtshop'];		
		//$invoice = trim($_REQUEST['txtinvoice']);	
		$invoice = $_REQUEST['txtrepinvid'];		
		$make = trim($_REQUEST['txtmake']);			
		//$model = trim($_REQUEST['txtmodel']);				
		$imei = trim($_REQUEST['txtimei']);		
		$customername = trim($_REQUEST['txtcsname']);		
		$password = trim($_REQUEST['txtcpwd']);		
		$contact = trim($_REQUEST['txtcsno']);		
		$defects = trim($_REQUEST['txtdefects']);		
		$sparephone = trim($_REQUEST['txtsphone']);		
		$network = trim($_REQUEST['txtnetwork']);		
		//$price = trim($_REQUEST['txtcharges']);		
		$signature = trim($_REQUEST['txtcsig']);	
		//$signature = null;
		$lab_id = trim($_REQUEST['txtlab']);
		$enteredby = trim($_REQUEST['txtrecby']);;		
		$created_by = trim($_REQUEST['txtcreatedby']);	
		$shopname = $_REQUEST['txtshopname'];
		$return = trim($_REQUEST['txtexreturn']);	
		$access = $_REQUEST['txtaccess'];
		$checks = $_REQUEST['txtchecks'];
		$achecks = $_REQUEST['txtachecks'];
		$other = $_REQUEST['txtother'];
		$notes = trim($_REQUEST['txtnotes']);
		$labsend = trim($_REQUEST['txtlabsend']);	
		$refix = trim($_REQUEST['txtrfix']);
	
	if (!empty($rsid) && trim($rsid) != '')
	{
		$id = $_REQUEST['txtrepshid'];
				
		$signame = null;
		
		if (!empty($_REQUEST['txtprice'])) 
			$price = $_REQUEST['txtprice'];	
		else
			$price = "0.00";
			
		if (!empty($_REQUEST['txtdeposit'])) 
			$deposit = $_REQUEST['txtdeposit'];	
		else
			$deposit = "0.00";
			
		if (!empty($signature)) {
			//$img = sigJsonToImage($signature);
			$img = sigJsonToImage($signature, array('imageSize'=>array(340, 105)));
			$sigdate = new DateTime();
			$sigtime = $sigdate->getTimestamp(); 
			$csigname = preg_replace('/\s+/', '', $sigtime);
			$signame = $csigname . "_S.png"; 		
			imagepng($img, "documents/".$signame);
		}	
				
		$data = array(	
			"price" => "'$price'",	
			"deposit" => "'$deposit'",	
			"signature" => "'$signature'",
			"signimage" => "'$signame'",
			"notes" => "'$notes'",
			"refix" => "'$refix'",
			"modified_by" => "'$created_by'",
			"modified_at" => "'".date("Y-m-d H:i:s",time())."'"
		);
		
		$id = $db->update($data, 'repsheet', 'id = '.$id);
		
		//Inserting phone checklist info to Misc table
		if (!empty($achecks)) {
		
			$dvalue = $mysqli->query("DELETE FROM misc where itemid=$invoice AND type='After'");
			
			$arrayachk = explode(',', $achecks);
			
			foreach($arrayachk as $achecks_name){
			   //modify below to add $id along with $tag_name
			  $achecksval = $achecks_name;
			  $acheckstype = 'After';
			  
			  $achecksdata = array(
				"itemid" => "'$invoice'",	
				"value" => "'$achecksval'",	
				"type" => 	"'$acheckstype'",
			  );
			  
			  $ida = $db->insert($achecksdata, 'misc');	
			}
		}
		
		//For Entering Repairs Data if senttolab = yes
		if (!empty($labsend) == 'yes') {
			$status = 'Inprogress';	
			//saving data to db
			$redata = array(			
				"shop_id" => "'$shop_id'",					
				"lab_id" => "'$lab_id'",					
				"date_entered" => "'$edate'",
				"invoice" => "'$invoice'",
				"make" => "'$make'",
				"model" => "'$model'",
				"imei" => "'$imei'",	
				"password" => "'$password'",
				"charges" => "'$price'",	
				"status" => "'$status'",
				"notes" => "'$notes'",
				"created_by" => "'$created_by'",				
				"created_at" => "'".date("Y-m-d H:i:s",time())."'"
			);
			$idre = $db->insert($redata, 'repairs');
			
			//save faults
			
			$faults = array(	
					"repair_id" => "$idre",
					"fault" => "'$defects'",
					"charges" => "'$price'"
				);
				
			$idf = $db->insert($faults, 'repair_faults');
		}
		
		
		if (!empty($id))
			echo $id;
		else
			echo 0;
		
	} 
	else 
	{
	
		
		$status = null;		
		$ref = null;
		$refid = null;	
		$signame = null;
		
		$dt = new DateTime("now", new DateTimeZone('Europe/London'));	
		$edate = $dt->format('Y-m-d H:i:s');	
		$shemail  = "";
		
		if (!empty($_REQUEST['txtprice'])) 
			$price = $_REQUEST['txtprice'];	
		else
			$price = "0.00";
			
		if (!empty($_REQUEST['txtdeposit'])) 
			$deposit = $_REQUEST['txtdeposit'];	
		else
			$deposit = "0.00";
		
		$invoice = $db->updateInvoiceNo('Repsheet');
		
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
		
		//$signame = "201801141231_S.png";
		
		//saving data to db
		$data = array(	
			"shop_id" => "'$shop_id'",	
			"date_entered" => 	"'$edate'",
			"invoice" => "'$invoice'",	
			"make" => "'$make'",		
			"imei" => "'$imei'",
			"customer_name" => "'$customername'",
			"password" => "'$password'",
			"contact_number" => "'$contact'",
			"defects" => "'$defects'",
			"sparephone" => "'$sparephone'",
			"network" => "'$network'",		
			"price" => "'$price'",	
			"deposit" => "'$deposit'",		
			"signature" => "'$signature'",
			"signimage" => "'$signame'",			
			"exreturn" => "'$return'",	
			"entered_by" => "'$enteredby'",
			"notes" => "'$notes'",
			"refix" => "'$refix'",
			"created_by" => "'$created_by'",
			"created_at" => "'".date("Y-m-d H:i:s",time())."'"
			
		);
		//print_r ($data);
		//saving data to db
		$id = $db->insert($data, 'repsheet');	
				
		//Inserting phone accessories info to Misc table
		
		if (!empty($access)) {
			$arrayacc = explode(',', $access);
			foreach($arrayacc as $tag_name){
			   //modify below to add $id along with $tag_name
			  $accessval = $tag_name;
			  $accesstype = 'accessories';
			  
			  $accessdata = array(
				"itemid" => "'$invoice'",	
				"value" => "'$accessval'",	
				"type" => 	"'$accesstype'",
			  );
			  $ids = $db->insert($accessdata, 'misc');	
			}
		}
		
		//Inserting phone checklist info to Misc table
		
		if (!empty($checks)) {
			$arraychk = explode(',', $checks);
			
			foreach($arraychk as $checks_name){
			   //modify below to add $id along with $tag_name
			  $checksval = $checks_name;
			  $checkstype = 'Before';
			  
			  $checksdata = array(
				"itemid" => "'$invoice'",	
				"value" => "'$checksval'",	
				"type" => 	"'$checkstype'",
			  );
			  
			  $idc = $db->insert($checksdata, 'misc');	
			}
		}
		
		//Inserting phone checklist info to Misc table
		/* Moved in Update section by IA
		if (isset($achecks)) {
			$arrayachk = explode(',', $achecks);
			
			foreach($arrayachk as $achecks_name){
			   //modify below to add $id along with $tag_name
			  $achecksval = $achecks_name;
			  $acheckstype = 'After';
			  
			  $achecksdata = array(
				"itemid" => "'$invoice'",	
				"value" => "'$achecksval'",	
				"type" => 	"'$acheckstype'",
			  );
			  $ida = $db->insert($achecksdata, 'misc');	
			}
		}
		*/
		if (!empty($other)) {
			$othdata = array(
				"itemid" => "'$invoice'",	
				"value" => "'$other'",	
				"type" => 	"'other'",
			  );
			  $ido = $db->insert($othdata, 'misc');		
		}
		
		//For Entering Repairs Data if senttolab = yes
		if (!empty($labsend) == 'yes') {
			$status = 'Inprogress';	
			//saving data to db
			$redata = array(			
				"shop_id" => "'$shop_id'",					
				"lab_id" => "'$lab_id'",					
				"date_entered" => "'$edate'",
				"invoice" => "'$invoice'",
				"make" => "'$make'",
				"model" => "'$model'",
				"imei" => "'$imei'",	
				"password" => "'$password'",
				"charges" => "'$price'",
				"status" => "'$status'",
				"notes" => "'$notes'",
				"created_by" => "'$created_by'",				
				"created_at" => "'".date("Y-m-d H:i:s",time())."'"
			);
			$idre = $db->insert($redata, 'repairs');
			
			//save faults
			
			$faults = array(	
					"repair_id" => "$idre",
					"fault" => "'$defects'",
					"charges" => "'$price'"
				);
				
			$idf = $db->insert($faults, 'repair_faults');
		}
		
		// For Genrating and Saving PDF File
		/*Remarked by IA as printing wil resolve this PDF saving
		$savPdf = RepairPDF($id); */
		//echo $savPdf;	
		//For sending email to SuperAdmin
		
		$sub = "New Phone $make is purchased by $shopname";
		$mess = "Dear Sir,\n Please see below specs of the phone purchased by $shopname on $edate.\n";
		$mess = $mess."Customer Informaton: Customer Name : $customername; Contact: $contact.\n";
		$mess = $mess."Phone Specifications: Make : $make;  IMEI: $imei.\n";
		$mess = $mess."Network : $network; Defects: $defects Price: &pound $price.\n";
		
		$from = "From: fone-worlduk.com" . "\r\n";	
		//$to = "admin@foneworlduk.com";
		$to = "fonebuying@gmail.com";
		/*IA
		if (isset($to)) {
				
				//sendMail($to,$sub,$mess,$uname);
				//if (mail ($to, $sub, $mess, $from)) {
				//	echo 1;
				//} else {
				//	echo 0;
				//}
				
				require_once('classes/class.phpmailer.php');
				include("classes/class.smtp.php");
				$mail = new PHPMailer();
				$mail->IsSMTP();			
				
				//$mail->Host =  "relay-hosting.secureserver.net"; //"smtpout.secureserver.net"; // //"smtp.aol.com";
				//$mail->SMTPSecure = 'tls'; 
				//For Local
				
				//$mail->SMTPDebug  = 0;			
				//$mail->SMTPAuth = true;
				//$mail->Host = "smtp.aol.com";
				//$mail->Port = 587;			
				
				//For Production on fone-worlduk.com
				
				//$mail->SMTPDebug  = 0;			
				//$mail->SMTPAuth = false;
				//$mail->Host = "relay-hosting.secureserver.net";
				////$mail->Port = 25;			
				
				//$mail->Username = "foneworlduk@aol.co.uk";
				//$mail->Password = "b7948456305m";
				
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
			
			$mail->Send();
		}
		*/
		if (!empty($id))
			echo $id;
		else
			echo 0;
	}
	
	
}

?>
