<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
			
	//retrieve the $_POST variables	
	$invoice = $_REQUEST['txtinv'];
	$make = $_REQUEST['txtmke'];		
	$model = $_REQUEST['txtmdl'];		
	$customer = $_REQUEST['txtcust'];
	$dispname = $_REQUEST['txtdispname'];
	$path = "pdfs/".$invoice.".pdf";
	$to = $_REQUEST['txtsemail'];
	//$labcharges = $_REQUEST['txtlabcharges'];
		
		$sub = "Purchase Agreement for $make-$model";
		$mess = "Dear Sir,\n Please find attached purchase agreement between 'You' and 'Fone World'.\n";
		$mess = "Best Regards,\n";
		$mess = "Team Fone World,\n\n";
		$mess = "If you have any queries please write us at fonebuying@gmail.com";
		
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
			/* By IA 16 Oct 2016
			$mail->SMTPDebug  = 0;			
			$mail->SMTPAuth = false;			
			$mail->Host ="smtp.mandrillapp.com"; 
			$mail->Port = 587;
			//$mail->Username =  "alert@powerbank.com.my"; 
			//$mail->Password = "JVj3PuwOJJQqmAMFNFLoJQ";
			$mail->Username = "foneworlduk@aol.co.uk";
			$mail->Password = "b7948456305m";
			*/

			$mail->SMTPAuth   = true;                  // enable SMTP authentication

			$mail->SMTPSecure = "tls";                 // sets the prefix to the servier

			$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server

			$mail->Port       = 587;                   // set the SMTP port for the GMAIL server

			$mail->Username   = "contact.foneworld@gmail.com";  // GMAIL username

			$mail->Password   = "2contact";  
			
			$from = "foneworlduk@aol.co.uk";			
			//$mail->SetFrom($from, 'fone-worlduk');
			$mail->SetFrom($dispname);
			
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
			
			if(!$mail->Send()) {
				echo 0; //"Mailer Error: " . $mail->ErrorInfo;
			} else {
				echo 1; //"Message sent!";
			}
			
		}	
	
}

?>
