<?php 
//error_reporting(0);

include_once 'include/global.inc.php';
//https://sendy.co/forum/discussion/918/smtp-on-godaddy-shared-hosting/p1
//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	//$status = $_REQUEST['txtpstatus'];		
	
	$id = $_REQUEST['txtrejid'];
	$to = $_REQUEST['txtrejmail'];
	//$labcharges = $_REQUEST['txtlabcharges'];
	
	
		$sql = "SELECT invoice, summary, imei, email,shop_id  
				FROM unlocks where id=$id";
				
		$datar = $db->selectQuery($sql);	
	
		foreach ($datar as $row) {
			$inv = $row['invoice'];
			$shid  = $row['shop_id'];			
			$summ = $row['summary'];
			$imi = $row['imei'];				
		}	
		
		$sqlshop = "SELECT email,display_name  
				FROM shops where id=$shid";
				
		$datash = $db->selectQuery($sqlshop);	
		
		foreach ($datash as $srow) {
			$shemail  = $srow['email'];	
			$fromn = $srow['display_name'];	
		}	
		
		$sub = "Invoice# $inv could not be fixed";
		$mess = "Dear Customer,\n The Invoice# $inv, Summary: $summ could not be fixed. Please get your phone at your earliest\n Thanks \n fone-worlduk.com";
		//$from = 'From: FoneWorld';
		//$from = "From: fone-worlduk.com" . "\r\n";
		if (isset($to)) {
			//sendMail($to,$sub,$mess,$uname);
			/*
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
			
			/*For Local*/
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
			$mail->SetFrom($from,$fromn);			
			
			if (!empty($shemail)) {
				$mail->AddReplyTo($shemail);
			} else {			
				$mail->AddReplyTo("foneworlduk@aol.co.uk");
			}	
			//$address = $email;
			$mail->AddAddress($to);
			$mail->Subject = $sub;   			
            $mail->Body = $mess;									
			if(!$mail->Send()) {
				//echo 0; //
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				echo 1; //"Message sent!";
			}
			
		}	
	
	/* By IA 
	//saving data to db
	$data = array(			
		"status" => "'$status'",		
	);
	
	//saving data to db
		
	
	$id = $db->update($data, 'unlocks', 'id = '.$id);
	
	if (!empty($id))
		echo 1;
	else
		echo 0;
	*/	
}

?>
