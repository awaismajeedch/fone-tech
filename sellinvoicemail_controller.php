<?php 
error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	//$status = $_REQUEST['txtpstatus'];		
	
	$id = $_REQUEST['txtrepid'];
	$to = $_REQUEST['txtsemail'];
	//$labcharges = $_REQUEST['txtlabcharges'];
	
	
		$sql = "SELECT *  
				FROM sale where id=$id";
				
		$datar = $db->selectQuery($sql);	
	
		foreach ($datar as $row) {
			$edate  = $row['date_entered'];			
			$shid  = $row['shop_id'];			
			$make  = $row['make'];
			$model  = $row['model'];
			$imei  = $row['imei'];
			$access  = $row['accessories'];
			$customername  = $row['customer_name'];			
			$price  = $row['price'];
			$grade  = $row['grade'];
			$mode  = $row['payment_mode'];
			$sigimage  = $row['signimage'];
			$sellby  = $row['entered_by'];
			$invoice = $row['invoice'];
		}	
		
		$path = "pdfs/".$invoice."_S.pdf";
		
		$sqlshop = "SELECT email  
				FROM shops where id=$shid";
				
		$datash = $db->selectQuery($sqlshop);	
		
		foreach ($datash as $srow) {
			$shemail  = $srow['email'];	
		}	
		
		$sub = "Sale Agreement for $make-$model";
		$mess = "Dear $customername,\n Please see attached Sale agreement between 'You' and 'Fone World' dated $edate.\n";
		
		//$from = 'From: FoneWorld';
		$from = "From: fone-worlduk.com" . "\r\n";
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
			$mail->SMTPDebug  = 2;			
			$mail->SMTPAuth = true;
			$mail->Host = "smtp.aol.com";
			$mail->Port = 587;			
			*/
			//For Production on fone-worlduk.com
			/*
			$mail->SMTPDebug  =0;			
			$mail->SMTPAuth = false;
			$mail->Host = "relay-hosting.secureserver.net";
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;			
			
			$mail->Username = "foneworlduk@aol.co.uk";
			$mail->Password = "b7948456305m";
			*/
			//For Production on foneworld-phoneparts.biz
			/* BY IA 16-10-2016
			$mail->SMTPDebug  = 2;			
			$mail->SMTPAuth = false;			
			$mail->Host ="smtp.mandrillapp.com"; 
			//$mail->SMTPSecure = 'tls';
			$mail->Port = 587;
			$mail->Username =  "alert@powerbank.com.my"; 
			$mail->Password = "JVj3PuwOJJQqmAMFNFLoJQ";
			//$mail->Username = "foneworlduk@aol.co.uk";
			//$mail->Password = "b7948456305m";
			*/

			$mail->SMTPAuth   = true;                  // enable SMTP authentication

			$mail->SMTPSecure = "tls";                 // sets the prefix to the servier

			$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server

			$mail->Port       = 587;                   // set the SMTP port for the GMAIL server

			$mail->Username   = "contact.foneworld@gmail.com";  // GMAIL username

			$mail->Password   = "2contact";  

			$from = "foneworlduk@aol.co.uk";
			//$from = "alert@powerbank.com.my";		
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
			$mail->AddAttachment($path); 	
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
