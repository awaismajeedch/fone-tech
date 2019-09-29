<?php 
//error_reporting(0);

include_once 'include/global.inc.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	//$status = $_REQUEST['txtpstatus'];		
	
	$id = $_REQUEST['txtrepid'];
	$to = $_REQUEST['txtsemail'];
	//$labcharges = $_REQUEST['txtlabcharges'];
	
	
		$sql = "SELECT *  
				FROM repsheet where id=$id";
				
		$datar = $db->selectQuery($sql);	
	
		foreach ($datar as $row) {
			$edate  = $row['date_entered'];
			$shid  = $row['shop_id'];	
			$invoice  = $row['invoice'];
			$make  = $row['make'];
			$model  = $row['model'];
			$imei  = $row['imei'];
			$defects  = $row['defects'];
			$customername  = $row['customer_name'];
			$contact  = $row['contact_number'];
			$sigimage  = $row['signimage'];
			$recby  = $row['entered_by'];
			$network = $row['network'];
			$price = $row['price'];
		}	
			
			$path = "pdfs/".$invoice."_R.pdf";
			
		$sqlshop = "SELECT email  
				FROM shops where id=$shid";
				
		$datash = $db->selectQuery($sqlshop);	
		
		foreach ($datash as $srow) {
			$shemail  = $srow['email'];	
		}		
		
		$sub = "Repair Invoice for $make-$model";
		$mess = "Dear $customername,\n Please find below Terms and Conditions\n";
		$mess = $mess."Customer Information: Customer Name : $customername; Contact: $contact.\n";
		$mess = $mess."Phone Specifications: Make : $make; Model: $model IMEI: $imei.\n";
		$mess = $mess."Network : $network; Defects: $defects Price: &pound $price.\n";
		$mess = $mess."1) All parts used during repair will be replacement parts not from original brand.:\n";
   		$mess = $mess."2) Please take out any SIM and memory cards. We cannot accept any responsibility or liability for these. \n";
		$mess = $mess."3) We don't do any refund at all for any kind of repairs. If after repairing issue still exist. We will try to re fix it or offer only credit note which will be valid for six months these rules will not affect your statutory rights.\n";
		$mess = $mess."4) In Touch & LCD repair company only guarantee for colour pixels or if touch not working, There is no refund or exchange for broken LCD or Touch screens. \n";
        $mess = $mess."5) Any repair done by us will be covered by our 30 days warranty if the same fault occurs. But this warranty will not cover any accident damage of Touch & LCD screens.\n";
		$mess = $mess."6) We only repair the fault that your phone came in for, if we repair the phone & on testing we notice it has additional faults, you will be quoted separately for those faults. \n";
		$mess = $mess."7) Any phone which is coming back for refix, during refix if we found an additional fault with your phone, you will be quoted separately for those faults. \n";
		$mess = $mess."8) If we successfully unlock or repair your phone & phone turns out to be barred the quoted repair price will still stand. \n";
		$mess = $mess."9) Please indicate if the data on your phone is important & you would like us to try our best to save it. However we cannot guarantee your data or settings on the phone will be saved during our repairs or unlocking. \n";
		$mess = $mess."10)Our repairs will void your phone warranty. Please check you are happy with this before you hand over your phone. \n";
		$mess = $mess."Received By : $recby	\n";
		
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
			//For Production
			//https://stackoverflow.com/questions/21841834/phpmailer-godaddy-server-smtp-connection-refused
			/*
			$mail->SMTPDebug  = 2;			
			$mail->SMTPAuth = true;
			$mail->Host = "n1plcpnl0002.prod.ams1.secureserver.net";//"relay-hosting.secureserver.net"; //"localhost";
			$mail->Port = 587;//465;
			$mail->SMTPSecure = 'tsl';			
			$mail->Username = "customercare@fonesolution.co.uk";
			$mail->Password = "2contact";
			//$mail->Username = "foneworlduk@aol.co.uk";
			//$mail->Password = "b7948456305m";
			//$mail->SMTPAuth   = true;                  // enable SMTP authentication
			*/
			$mail->SMTPAuth   = true;                  // enable SMTP authentication

			$mail->SMTPSecure = "tls";                 // sets the prefix to the servier

			$mail->Host       = "n3plcpnl0285.prod.ams3.secureserver.net";      //smtp.gmail.com sets GMAIL as the SMTP server

			$mail->Port       = 587;                   // set the SMTP port for the GMAIL server

			$mail->Username   = "wupquzwy6nxz";  // contact.foneworld@gmail.com GMAIL username

			$mail->Password   = "Shaz1l@62@15";  //2contact
			
			$from = "invoice@fone-tech.com";			
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
			/* Comment by IA
			if (file_exists($path)) {
				$mail->AddAttachment($path);
				}
			*/
			/*
			if(!$mail->Send()) {
				echo 0;
			} else {
				echo 1;
			}
			*/
			if(!$mail->Send()) {
				echo 0;
				//echo "Mailer Error: " . $mail->ErrorInfo;
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
