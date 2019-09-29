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
				FROM purchase where id=$id";
				
		$datar = $db->selectQuery($sql);	
	
		foreach ($datar as $row) {
			$edate  = $row['date_entered'];
			$shid  = $row['shop_id'];	
			$invoice  = $row['invoice'];
			$make  = $row['make'];
			$model  = $row['model'];
			$imei  = $row['imei'];
			$customername  = $row['customer_name'];
			$contact  = $row['contact_number'];
			$password  = $row['password'];
			$defects  = $row['defects'];
			$address  = $row['address'];
			$network  = $row['network'];
			$price  = $row['price'];
			$sigimage  = $row['signimage'];
			$recby  = $row['entered_by'];
		}	
		
		$sqlshop = "SELECT email  
				FROM shops where id=$shid";
				
		$datash = $db->selectQuery($sqlshop);	
		
		foreach ($datash as $srow) {
			$shemail  = $srow['email'];	
		}		
		
		$sub = "Purchase Agreement for $make-$model";
		$mess = "Dear $customername,\n Please see below purchase agreement between 'You' and 'Fone World' dated $edate.\n";
		$mess = $mess."Customer Informaton: Customer Name : $customername; Contact: $contact Address: $address.\n";
		$mess = $mess."Phone Specifications: Make : $make; Model: $model IMEI: $imei.\n";
		$mess = $mess."Network : $network; Defects: $defects Price: &pound $price.\n";
		$mess = $mess."1. The trade-in services are operated by Fone World ('US', 'WE'). Nothing in these terms and conditions shall affect your statutory rights. These Conditions are governed by English Law and the courts of England shall have exclusive jurisdiction to settle any dispute or claim arising out of or in connection with these Conditions. By signing this agreement 'YOU', the customer, agree to the following conditions:\n";
   		$mess = $mess."1. Your Information\n";
		$mess = $mess."1.1 You consent to us passing your information (including name, address, telephone number, email address, Device make/model/IMEI/network) in order for us to process your trade in and contact you and the network in relation to unlocking of the Device only.\n";
		$mess = $mess."1.2 Data stored on the Device that you wish to retain must be saved elsewhere and you must remove any memory card and/ or all data that has been put onto the Device prior to trade in. We will not be liable for any damage, loss or erasure of any such data or for any consequences of you not removing your data or memory card, including use or disclosure of such data.\n";
        $mess = $mess."1.3 If the Device contains a SIM card, you must remove this along with any accessories prior to trade in. We will not be liable for any consequences of you not removing the SIM card or accessories, including any payments associated with the Device or the SIM card.\n";
		$mess = $mess."2. Change of Ownership\n";
		$mess = $mess."2.2 By signing and agreeing to the terms of this agreement and; accepting our pre-agreed trade-in payout sum and; by handing us your goods, the goods will be deemed to be property of Fone World and all rights over the goods will be transferred to us.\n";
		$mess = $mess."3. The Goods or Device\n";
		$mess = $mess."3.1 You confirm that you are either the owner of the Device or Goods or you have obtained express permission from the rightful owner to trade in The Goods.\n";
		$mess = $mess."3.2 The Goods must not be stolen or listed with us or a third party as stolen. If The Goods fail any due diligence check we may notify the relevant police authority and we may pass The Goods and your details to them and the Quoted Value will not be paid to you.\n";
		$mess = $mess."3.3 Fone World may seek compensation in full against you for any loss, damage or expense incurred by you for inaccurate information regarding the goods you have sold to us.\n";
		$mess = $mess."3.4 The Goods are not subject to hire purchase, rental agreement or any other loan/charge that may result in the loss of these goods from us.\n";
		$mess = $mess."3.5 The Goods are in fully working order and are free from any defects or damage (unless we are accepting your goods in a faulty condition)\n";
		$mess = $mess."4. Returns\n";
		$mess = $mess."4.1 Once you have traded in The Goods, it will not be returned to you under any circumstances.\n";				 
		$mess = $mess."Customer's Declaration\n";
		$mess = $mess."I confirm that I have read and understood the terms and conditions of Fone World Trade-In Agreement set out above points 1, 2, 3 and 4.\n";
		$mess = $mess."I confirm that all statements and information provided are accurate and true.\n";
		$mess = $mess."I confirm that I am over 18 years old.\n";
		$mess = $mess."Recived By : $recby	\n";
		
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
			/* by IA 16 Oct 2016
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
			if(!$mail->Send()) {
				echo 0; //"Mailer Error: " . $mail->ErrorInfo;
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
