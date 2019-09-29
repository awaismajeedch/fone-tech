<?php
function SavePDF($pid) 
{ 
	include_once 'html2pdf/html2pdf.class.php';
	require_once 'classes/DB.class.php';
	$cdate = date('Y-m-d H:i:s');
	//connect to the database
	$db = new DB();
	$db->connect();
	
	$tablename="purchase";
	$orderby = " ORDER BY created_at DESC";
	$where= "id=$pid";
	
	$datar = $db->select($tablename,$orderby, $where);
	
	foreach ($datar as $row) {
		$shopid = $row['shop_id'];
		$edate  = $row['date_entered'];
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
	$sql = "SELECT * FROM shops WHERE id = $shopid";	
	$shdata = $db->selectQuery($sql);	
	foreach ($shdata as $shrow) {
		$shopname = $shrow['name'];
		$shaddress = $shrow['address'];
		$shcity = $shrow['city'];
		$shcontact = $shrow['contact'];
		$shemail = $shrow['email'];	
		//$comadd = $shaddress . "," . $shcity . ",". "Tel: ".$shcontact ;
		$comadd = $shaddress . ", " . $shcity;
    }	
	$access ="";
	$missql = "SELECT * FROM misc WHERE itemid = $pid AND (type='accessories' OR type='other')";	
	$misdata = $db->selectQuery($missql);	
	foreach ($misdata as $msrow) {
		$access = $msrow['value']. "," .$access;
	}
	$access = trim ($access,",");
	
	try
    {	
	//retrieve the $_POST variables	
	$content = "
		<page>
		<div style='text-align: center;'>
			<h1 style='line-height:5px;'>PURCHASE AGREEMENT</h1>				
		</div>			
		<div style='text-align: center;'>			
			$comadd
		</div>			
		<hr>
		<table 	width='100%'>
			<tr>
				<td style='width:30%'>
					<b>Invoice #:  $invoice</b>
				</td>
				<td colspan='2' style='width:70%; align:right;' >
					<b>Purchase Date : $edate </b>
				</td>
			</tr>
			<tr>
				<td style='width:30%;'>
					<b>Customer Name : $customername</b>
				</td>
				<td style='width:30%;'>
					<b>Contact : $contact</b>
				</td>
				<td style='width:40%;'>
					<b>Address: $address;</b>
				</td>
			</tr>	
			<tr>
				<td style='width:30%;'>
					<b>Make : $make</b>
				</td>
				<td style='width:30%;'>
					<b>Model :  $model</b>
				</td>
				<td style='width:40%;'>
					<b>IMEI:  $imei</b>  -  <b>Price : $price</b>
				</td>
			</tr>	
			<tr>
				<td style='width:30%;'>
					<b>Network : $network</b>
				</td>
				<td style='width:30%;'>
					<b>Defects: $defects</b>
				</td>
				<td style='width:40%;'>
					<b>Accessories : $access</b>
				</td>
			</tr>	
		</table>				
		<hr>
		<div>
			<p>1. The trade-in services are operated by Company ('US', 'WE'). Nothing in these terms and conditions shall affect your statutory rights. These Conditions are governed by English Law and the courts of England shall have exclusive jurisdiction to settle any dispute or claim arising out of or in connection with these Conditions. By signing this agreement 'YOU', the customer, agree to the following conditions:<br/></p>
			<p><b>1. Your Information</b></p>
			<p>1.1 You consent to us passing your information (including name, address, telephone number, email address, Device make/model/IMEI/network) in order for us to process your trade in and contact you and the network in relation to unlocking of the Device only.</p>
			<p>1.2 Data stored on the Device that you wish to retain must be saved elsewhere and you must remove any memory card and/ or all data that has been put onto the Device prior to trade in. We will not be liable for any damage, loss or erasure of any such data or for any consequences of you not removing your data or memory card, including use or disclosure of such data.</p>
			<p>1.3 If the Device contains a SIM card, you must remove this along with any accessories prior to trade in. We will not be liable for any consequences of you not removing the SIM card or accessories, including any payments associated with the Device or the SIM card.</p>
			<p><b>2. Change of Ownership</b></p>
			<p>2.2 By signing and agreeing to the terms of this agreement and; accepting our pre-agreed trade-in payout sum and; by handing us your goods, the goods will be deemed to be property of Company and all rights over the goods will be transferred to us.</p>
			<p><b>3. The Goods or Device</b></p>
			<p>3.1 You confirm that you are either the owner of the Device or Goods or you have obtained express permission from the rightful owner to trade in The Goods.</p>
			<p>3.2 The Goods must not be stolen or listed with us or a third party as stolen. If The Goods fail any due diligence check we may notify the relevant police authority and we may pass The Goods and your details to them and the Quoted Value will not be paid to you.</p>
			<p>3.3 Company may seek compensation in full against you for any loss, damage or expense incurred by you for inaccurate information regarding the goods you have sold to us.</p>
			<p>3.4 The Goods are not subject to hire purchase, rental agreement or any other loan/charge that may result in the loss of these goods from us.</p>
			<p>3.5 The Goods are in fully working order and are free from any defects or damage (unless we are accepting your goods in a faulty condition)</p>
			<p><b>4. Returns</b></p>
			<p>4.1 Once you have traded in The Goods, it will not be returned to you under any circumstances.</p>			
			<hr>
			<p><b>Customer s Declaration</b></p>
			<p> I confirm that I have read and understood the terms and conditions of Company Trade-In Agreement set out above points 1, 2, 3 and 4.</p>						
			<p> I confirm that all statements and information provided are accurate and true.</p>
			<p> I confirm that I am over 18 years old.</p>			
			<p>Customer Signatures: <img src='documents/$sigimage' style='width:200px;height:55px;'> &nbsp;&nbsp;&nbsp;<b>Received By : $recby</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Printed On : $edate</b></p>						
		</div>	
</page>
	";			
	
	//$content= stripslashes($content);
	//echo $content;
    $html2pdf = new HTML2PDF('P','A4','en');
    $html2pdf->WriteHTML($content);
    $path = "pdfs/".$invoice.".pdf";
	$html2pdf->Output($path,'F');
	return 0;
	exit;
	}
    catch(HTML2PDF_exception $e) {
        return $e;
        exit;
    }
		
}	

function SalePDF($sid) 
{ 
	include_once 'html2pdf/html2pdf.class.php';
	require_once 'classes/DB.class.php';

	//connect to the database
	$db = new DB();
	$db->connect();
	
	$cdate = date('Y-m-d H:i:s');
	
	$tablename="sale";
	$orderby = " ORDER BY created_at DESC";
	$where= "id=$sid";
	
	$datar = $db->select($tablename,$orderby, $where);
	
	foreach ($datar as $row) {
		$shosid = $row['shop_id'];
		$edate  = $row['date_entered'];	
		$invoice  = $row['invoice'];		
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
	}	
	$sql = "SELECT * FROM shops WHERE id = $shosid";	
	$shdata = $db->selectQuery($sql);	
	foreach ($shdata as $shrow) {
		$shopname = $shrow['name'];
		$shaddress = $shrow['address'];
		$shcity = $shrow['city'];
		$shcontact = $shrow['contact'];
		$shemail = $shrow['email'];	
		//$comadd = $shaddress . "," . $shcity . "," ."Tel: ".$shcontact ;
		$comadd = $shaddress . ", " . $shcity;
    }		
	
	try
    {	
	//retrieve the $_POST variables	
	$content = "
		<page>
		<div style='text-align: center;'>
			<h1 style='line-height:5px;'>SALES AGREEMENT</h1>				
		</div>			
		<div style='text-align: center;'>			
			$comadd
		</div>			
		<hr>
		<table 	width='100%'>
			<tr>
				<td style='width:30%'>
					<b>Invoice #:  $invoice</b>
				</td>
				<td colspan='2' style='width:70%; align:right;' >
					<b>Selling Date : $edate </b>
				</td>
			</tr>
			<tr>
				<td style='width:30%;'>
					<b>Customer Name : $customername</b>
				</td>
				<td style='width:30%;'>
					<b>Contact : $contact</b>
				</td>
				<td style='width:40%;'>
					<b>Address: $address;</b>
				</td>
			</tr>	
			<tr>
				<td style='width:30%;'>
					<b>Make : $make</b>
				</td>
				<td style='width:30%;'>
					<b>Model :  $model</b>
				</td>
				<td style='width:40%;'>
					<b>IMEI:  $imei</b>  -  <b>Price : $price</b>
				</td>
			</tr>	
			<tr>
				<td style='width:30%;'>
					<b>Network : $network</b>
				</td>
				<td style='width:30%;'>
					<b>Defects: $defects</b>
				</td>
				<td style='width:40%;'>
					<b>Accessories : $access</b>
				</td>
			</tr>	
		</table>				
		<hr>
		<div>
			<p>The following Sales Terms and Conditions relate to the sale of Refurbished Phone Products ('Product/s') purchased by Company ('Us', 'We', 'Our'). These said Terms and Conditions are activated from once the product/s accepted and are paid for in full.</p>
			<p><b>1. Understanding your Refurbished Product</b></p>
			<p>Your product has met Company's high quality-control standards. While all our phones are refurbished, they have been thoroughly tested and graded.</p>									
			<p><b>2.	Understanding the Grade of your Refurbished Product</b></p>
			<p><b>Grade A</b></p>
			<p>- The phone is used but in excellent condition.</p>
			<p>- Cosmetically the phone will show no signs of use, there will be no scratches, cracks or scuffs to the screen or casing.</p>
			<p>- It's been fully tested*, is in full working order and has been restored to the latest operating system.</p>												
			<p><b>Grade B</b></p>
			<p>- The phone is used and in good condition.</p>
			<p>- Cosmetically the phone will show signs of slight use, including two or three minor scratches to the screen and casing. It won't have cracks on the screen or casing.</p>
			<p>- It's been fully tested*, is in full working order and has been restored to the latest operating system.</p>			
			<p><b>Grade C</b></p>
			<p>- The phone is used and in average condition.</p>
			<p>- Cosmetically the phone will show signs of use, including some scratches and scuffs to the screen and casing. It won't have cracks on the screen or casing.</p>
			<p>- It's been fully tested*, is in full working order and has been restored to the latest operating system.</p>
			<p><b>3.	Acceptance of Sale</b></p>
			<p>You will be offered the opportunity to inspect your product in-store and you will be made aware of the Grade of your product in accordance with the terms of Conditions (1) and (2). Once you have tested the product and completed the sale by paying for the product, you are deemed to have accepted the product in its current condition and grading.</p>
			<p><b>4.	Returns, Repairs and Replacements</b></p>
			<p>4.1	We only entertain genuine claims and reserve right to decline any false claims.</p>
			<p>4.2	All guarantees to replace, repair or return are void if the returned the product is found to be damaged, scratched, modified, physically altered or manipulated in anyway. This includes attempts to repair the product at another outlet.</p>
			<p>4.3	Company will either choose to repair the product in-house or replace as necessary. </p>
			<p>4.4	Any product returned to us may be charged an additional fee of '&pound'25 to cover the cost of testing and return if products are found to be fully working.</p>
			<p>4.5	You will be offered the opportunity to inspect and accept the product before purchasing, therefor we will not refund purchases if you:</p>
			<p>4.5.1	Made a mistake when purchasing the product; or</p>
			<p>4.5.2	Have  changed your mind about the product; or</p>
			<p>4.5.3	Are returning the product based on facts which you were aware of at the time of the sale.</p>
			<p>4.6	In addition to condition 7;  any returns, repairs or replacement requests will be rejected unless the following conditions are met:</p>
			<p>4.6.1	The product will only be accepted within 28 days of purchase</p>
			<p>4.6.2	Returns will only be accepted from the person who bought the item</p>
			<p>4.6.3	The original purchase receipt is made available at the time of the request</p>
			<p>The above conditions are part of our commitment to high quality service and do not affect your statutory rights as a consumer. These terms and conditions of sale are governed by the law of England and Wales, and are subject to the jurisdiction of the courts of England and Wales.</p>
			<hr>
			<p><b>By signing this contract you are confirming your acceptance and understanding of the Grade of your product and agree to the terms and conditions herein.</b></p>
			<p>Customer Signatures: <img src='documents/$sigimage' style='width:200px;height:55px;'> &nbsp;&nbsp;&nbsp;<b>Sold By : $sellby</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Printed On : $edate</b></p>						
		</div>					
</page>
	";			
	
	//$content= stripslashes($content);
	//echo $content;
    $html2pdf = new HTML2PDF('P','A4','en');
    $html2pdf->WriteHTML($content);
    $path = "pdfs/".$invoice."_S.pdf";
	$html2pdf->Output($path,'F');
	return 0;
	exit;
	}
    catch(HTML2PDF_exception $e) {
        return $e;
        exit;
    }
		
}	

function RepairPDF($pid) 
{ 
	include_once 'html2pdf/html2pdf.class.php';
	require_once 'classes/DB.class.php';
	$cdate = date('Y-m-d H:i:s');
	//connect to the database
	$db = new DB();
	$db->connect();
	
	$tablename="repsheet";
	$orderby = " ORDER BY created_at DESC";
	$where= "id=$pid";
	
	$datar = $db->select($tablename,$orderby, $where);
	
	foreach ($datar as $row) {
		$shopid = $row['shop_id'];
		$edate  = $row['date_entered'];
		$invoice  = $row['invoice'];
		$make  = $row['make'];
		$model  = $row['model'];
		$imei  = $row['imei'];
		$customername  = $row['customer_name'];
		$contact  = $row['contact_number'];
		$password  = $row['password'];
		$defects  = $row['defects'];
		$address  = $row['exreturn'];
		$network  = $row['network'];
		$charges  = $row['price'];
		$sigimage  = $row['signimage'];
		$recby  = $row['entered_by'];
	}	
	$sql = "SELECT * FROM shops WHERE id = $shopid";	
	$shdata = $db->selectQuery($sql);	
	foreach ($shdata as $shrow) {
		$shopname = $shrow['name'];
		$shaddress = $shrow['address'];
		$shcity = $shrow['city'];
		$shcontact = $shrow['contact'];
		$shemail = $shrow['email'];	
		//$comadd = $shaddress . "," . $shcity . ",". "Tel: ".$shcontact ;
		$comadd = $shaddress . ", " . $shcity;
    }	
	$access ="";
	$missql = "SELECT * FROM misc WHERE itemid = $pid AND (type='accessories' OR type='other')";	
	$misdata = $db->selectQuery($missql);	
	foreach ($misdata as $msrow) {
		$access = $msrow['value']. "," .$access;
	}
	$access = trim ($access,",");
	
	try
    {	
		
	$content = "
		<page>
		<div style='text-align: center;'>
			<h1 style='line-height:5px;'>REPAIR INVOICE</h1>				
		</div>			
		<div style='text-align: center;'>			
			$comadd
		</div>			
		<hr>
		<table 	width='100%'>
			<tr>
				<td style='width:30%'>
					<b>Invoice #:  $invoice</b>
				</td>
				<td colspan='2' style='width:70%; align:right;' >
					<b>Invoice Date : $edate </b>
				</td>
			</tr>
			<tr>
				<td style='width:30%;'>
					<b>Customer Name : $customername</b>
				</td>
				<td style='width:30%;'>
					<b>Contact : $contact</b>
				</td>
				<td style='width:40%;'>
					<b>Exp. Return: $address;</b>
				</td>
			</tr>	
			<tr>
				<td style='width:30%;'>
					<b>Make : $make</b>
				</td>
				<td style='width:30%;'>
					<b>Model :  $model</b>
				</td>
				<td style='width:40%;'>
					<b>IMEI:  $imei</b>  -  <b>Charges : $charges</b>
				</td>
			</tr>	
			<tr>
				<td style='width:30%;'>
					<b>Network : $network</b>
				</td>
				<td style='width:30%;'>
					<b>Defects: $defects</b>
				</td>
				<td style='width:40%;'>
					<b>Accessories : $access</b>
				</td>
			</tr>	
		</table>				
		<hr>
		<div>
			<p><b>
			1) All parts used during repair will be replacement parts not from original brand.
			</b></p><p><b>
			2) Please take out any SIM and memory cards. We cannot accept any responsibility or liability for these.
			</b></p><p><b>
			3) We do not do any refund at all for any kind of repairs. If after repairing issue still exist. We will try to re fix it or offer only credit note which will be valid for six months these rules will not affect your statutory rights. 
			</b></p><p><b>
			4) In Touch & LCD repair company only guarantee for colour pixels or if touch not working, There is no refund or exchange for broken LCD or Touch screens. 
			</b></p><p><b>
			5) Any repair done by us will be covered by our 30 days warranty if the same fault occurs. But this warranty will not cover any accident damage of Touch & LCD screens. 
			</b></p><p><b>
			6) We only repair the fault that your phone came in for, if we repair the phone & on testing we notice it has additional faults, you will be quoted separately for those faults. 
			</b></p><p><b>
			7) Any phone which is coming back for refix, during refix if we found an additional fault with your phone, you will be quoted separately for those faults. 
			</b></p><p><b>
			8) If we successfully unlock or repair your phone & phone turns out to be barred the quoted repair price will still stand. 
			</b></p><p><b>
			9) Please indicate if the data on your phone is important & you would like us to try our best to save it. However we cannot guarantee your data or settings on the phone will be saved during our repairs or unlocking. 
			</b></p><p><b>
			10)Our repairs will void your phone warranty. Please check you are happy with this before you hand over your phone. 
			</b></p>		
			<p>Customer Signatures: <img src='documents/$sigimage' style='width:200px;height:55px;'> &nbsp;&nbsp;&nbsp;<b>Received By : $recby</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Printed On : $edate</b></p>						
		</div>	
</page>
	";			
	
	//$content= stripslashes($content);
	//echo $content;
    $html2pdf = new HTML2PDF('P','A4','en');
    $html2pdf->WriteHTML($content);
    $path = "pdfs/".$invoice."_R.pdf";
	$html2pdf->Output($path,'F');
	return 0;
	exit;
	}
    catch(HTML2PDF_exception $e) {
        return $e;
        exit;
    }
		
}	

?>
