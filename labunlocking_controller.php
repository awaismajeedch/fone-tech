<?php 
//error_reporting(0);

include_once 'include/global.inc.php';
//include_once 'classes/Contact.php';

//check to see that the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		
	//retrieve the $_POST variables	
	$status = $_REQUEST['txtpstatus'];		
	$code = $_REQUEST['txtcode'];			
	$lnotes = $_REQUEST['txtlnotes'];			
	
	$id = $_REQUEST['txtrepid'];
	$shid = $_REQUEST['txtshid'];
	$ref = $_REQUEST['txtref'];
	$totalp = $_REQUEST['txtpaid'];		
	$ppaid = $_REQUEST['txtppaid'];			
	
	if (!empty($code)) {
		$checked = 'no';			
	} else {
		$checked = "";
	}	
	//$totalp = $paid + $ppaid ;
	
	//$labcharges = $_REQUEST['txtlabcharges'];
	/*	
	if (isset($_POST['chkpaid'])) {
		$paid = $_REQUEST['txtchg'];					
	} else {
		$paid = "0.00";
	}
	*/
	//saving data to db
	$data = array(			
		"status" => "'$status'",
		"labnotes" => "'$lnotes'",
		"code" => "'$code'"	,	
		"paid" => "'$totalp'",
		"siteref" => "'$ref'",
		"checked" => "'$checked'"
	);
	
	//saving data to db
		
	$id = $db->update($data, 'unlocks', 'id = '.$id);
	
	if (!empty($code)) {
		$sql = "SELECT invoice, summary, code, user_name, shops.email 
				FROM unlocks , users,shops where unlocks.shop_id = shops.id 
				AND shops.id = users.shop_id and users.user_type = 'admin' 
				AND unlocks.id=$id";
				
		$datar = $db->selectQuery($sql);	
	
		foreach ($datar as $row) {
			$inv = $row['invoice'];
			$summ = $row['summary'];
			$uname = $row['user_name'];	
			$to = $row['email'];	
		}		
		$sub = "Invoice# $inv is fixed";
		$mess = "Dear $uname,\n The Invoice# $inv, Summary: $summ has been fixed with code: $code";		
		//$from = "From: fone-worlduk.com" . "\r\n";				
		if (isset($to)) {
			require_once('classes/class.phpmailer.php');
			include("classes/class.smtp.php");
			$mail = new PHPMailer();
			$mail->IsSMTP();			
			/*For Local
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
			$mail->SetFrom($from, 'fone-worlduk');			
			if (!empty($shemail)) {
				$mail->AddReplyTo($shemail);
			} else {			
				$mail->AddReplyTo("foneworlduk@aol.co.uk");
			}	
			//$address = $email;
			$mail->AddAddress($to);
			$mail->Subject = $sub;   			
            $mail->Body = $mess;										
			$mail->Send();
			/*
			if(!$mail->Send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				echo "Message sent!";
			}
			*/
		}	
	}
		
	if (!empty($id))
		echo 1;
	else
		echo 0;
}

?>
