<!DOCTYPE html>

<?php
	//error_reporting(0);
	$mainCat = "Purchase";	
	include_once 'path.php';	
?>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  

<head>
    <html dir="ltr" lang="en-US">
	<meta charset="UTF-8" /> 
	<title>fone-tech</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">    
    <link rel="shortcut icon" href="favicon.ico">  
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,300italic' rel='stylesheet' type='text/css' />    
	<!--  Styles --> 
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" type="text/css" media="all"/>    		
	<link rel="stylesheet" type="text/css" media="all" href="assets/css/style.css" />   
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-responsive.css" type="text/css" media="all"/>    		
	<?php
		include_once($path ."head.php"); 
	?>   
	<style>
    body {
        height: 99%; 
		width: 210mm;
        /* to centre page on screen*/
        margin-left: auto;
        margin-right: auto;
    }
	.borderless td, .borderless th {
    border: none;	
	}
	hr{
    display: block;
    height: 1px;
    background: transparent;
    width: 100%;
    border: none;
    border-top: solid 1px #000;
	margin: 5px 0;
	}	
	p {
		font-size:10px;
	}
    </style>	
</head> 
<?php
	include_once 'include/global.inc.php';
	$pid = $_GET['pid'];

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
		$shopname = $shrow['display_name'];
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
	
	$imgpath = $_SERVER['DOCUMENT_ROOT']."/fone-worlduk.com/documents/".$sigimage; 
		
?>   
<body>
<div id="printdiv">
<page>
		<div style="text-align: center;">
			<h1 style="line-height:5px;">PURCHASE AGREEMENT</h1>				
		</div>			
		<div style="text-align: center;">			
			<?php echo $comadd;?>
		</div>	
		<!--<div style="text-align: center;">			
			<?php //echo $shemail;?>
		</div>-->
		<hr>
		<div style="width: 100%;">
			<div style="float: left; width: 30%;font-size:14px;">
				<b>Invoice #: <?php echo $invoice;?></b>
			</div>	
			<div style="float: left; width: 20%;">&nbsp;</div>
			<div style="float: right; width: 40%;"><b>Purchase Date : <?php echo $edate;?></b></div>
			<br style="clear: left;" />
		</div>	
		<div style="width: 100%;">
			<div style="float: left; width: 30%;">
				<b>Customer Name : <?php echo $customername;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>Contact : <?php echo $contact;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>Address: <?php echo $address;?></b>
			</div>
			<br style="clear: left;" />
		</div>	
		<div style="width: 100%;">
			<div style="float: left; width: 30%;">
				<b>Make : <?php echo $make;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>Model : <?php echo $model;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>IMEI: <?php echo $imei;?></b> -&nbsp;&nbsp;<b>Price : <?php echo $price;?></b>
			</div>			
		</div>	
		<div style="width: 100%;">
			<div style="float: left; width: 30%;">
				<b>Network : <?php echo $network;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>Defects: <?php echo $defects;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>Accessories : <?php echo $access;?></b>
			</div>
			<br style="clear: left;" />
		</div>
		<!--	
		<div style="width: 100%;">
			<label class="checkbox inline">
			   Accessories:&nbsp;&nbsp;
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" name="chkbox" id="chkbox"> Box
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" name="chkcharger" id="chkcharger"> Charger
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" name="chkhphone" id="chkhphone"> Headphone
			</label>
			<label class="checkbox inline">
			  <input type="checkbox" name="chkother" id="chkhother"> Other	&nbsp;&nbsp;&nbsp;								 									  								
			</label>
		</div>
		-->
		<hr>
		<div >
			<p>1. The trade-in services are operated by Company ('US', 'WE'). Nothing in these terms and conditions shall affect your statutory rights. These Conditions are governed by English Law and the courts of England shall have exclusive jurisdiction to settle any dispute or claim arising out of or in connection with these Conditions. By signing this agreement 'YOU', the customer, agree to the following conditions:<br/></p>
			<p><b>1. Your Information</b></p>
			<p>1.1 You consent to us passing your information (including name, address, telephone number, email address, Device make/model/IMEI/network) in order for us to process your trade in and contact you and the network in relation to unlocking of the Device only.</p>
			<p>1.2 Data stored on the Device that you wish to retain must be saved elsewhere and you must remove any memory card and/ or all data that has been put onto the Device prior to trade in. We will not be liable for any damage, loss or erasure of any such data or for any consequences of you not removing your data or memory card, including use or disclosure of such data.</p>
			<p>1.3 If the Device contains a SIM card, you must remove this along with any accessories prior to trade in. We will not be liable for any consequences of you not removing the SIM card or accessories, including any payments associated with the Device or the SIM card.</p>
			<p><b>2. Change of Ownership</b></p>
			<p>2.2 By signing and agreeing to the terms of this agreement and; accepting our pre-agreed trade-in payout sum and; by handing us your goods, the goods will be deemed to be property of the Company and all rights over the goods will be transferred to us.</p>
			<p><b>3. The Goods or Device</b></p>
			<p>3.1 You confirm that you are either the owner of the Device or Goods or you have obtained express permission from the rightful owner to trade in The Goods.</p>
			<p>3.2 The Goods must not be stolen or listed with us or a third party as stolen. If The Goods fail any due diligence check we may notify the relevant police authority and we may pass The Goods and your details to them and the Quoted Value will not be paid to you.</p>
			<p>3.3 Company may seek compensation in full against you for any loss, damage or expense incurred by you for inaccurate information regarding the goods you have sold to us.</p>
			<p>3.4 The Goods are not subject to hire purchase, rental agreement or any other loan/charge that may result in the loss of these goods from us.</p>
			<p>3.5 The Goods are in fully working order and are free from any defects or damage (unless we are accepting your goods in a faulty condition)</p>
			<p><b>4. Returns</b></p>
			<p>4.1 Once you have traded in The Goods, it will not be returned to you under any circumstances.</p>			
			<hr>
			<p><b>Customer's Declaration</b></p>
			<p> I confirm that I have read and understood the terms and conditions of the Company Trade-In Agreement set out above points 1, 2, 3 and 4.</p>						
			<p> I confirm that all statements and information provided are accurate and true.</p>
			<p> I confirm that I am over 18 years old.</p>			
			<p>Customer Signatures: <img src="documents/<?php echo $sigimage;?>" style="width:200px;height:55px;"> &nbsp;&nbsp;&nbsp;<b>Received By : <?php echo $recby;?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Printed On : <?php echo $edate;?></b></p>						
		</div>	
</page>		
</div>		

	<!--<a href="javascript:savePDF('printdiv','<?php echo $invoice;?>');"  class="button_bar" >Save as PDF</a>-->
	<a href="javascript:printdiv('printdiv');"  class="button_bar" >Print</a>	
	<!--<a href="javascript:sendMail();"  class="button_bar" style="margin-left:5px;">Email</a>-->
	<a data-toggle='modal' href='#modal-semail' class="button_bar" style="margin-left:5px;">Email</a>

<div class='modal hide fade' id='modal-semail' role='dialog' tabindex='-1' style="width: 700px;">
	<div class='modal-header'>
		<button class='close' data-dismiss='modal' type='button'>&times;</button>
		<h3>Enter Email</h3>
	</div>
	<div class='modal-body' >		
		<div class='controls text-center'>			
			<div class='form-wrapper'>
				<form name="mail_form" id="mail_form" class="form-horizontal" action="" method="post" >										
					<div class="row-fluid" >	
						<div class="span8" >										
							<div class="control-group">							
								<label class="control-label" >Email Address: </label>
								<div class="controls">
									<input type="text"  name="txtsemail" id="txtsemail" class="input-large" />
								</div>
							</div>							
							<input type="hidden"  name="txtinv" id="txtinv" value="<?php echo $invoice;?>" >																						
							<input type="hidden"  name="txtmke" id="txtmke" value="<?php echo $make;?>" >																						
							<input type="hidden"  name="txtmdl" id="txtmdl" value="<?php echo $model;?>" >																						
							<input type="hidden"  name="txtcust" id="txtcust" value="<?php echo $customername;?>" >																				
							<input type="hidden"  name="txtdispname" id="txtdispname" value="<?php echo $shopname;?>" >	
						</div>						
					</div>	
				</form>
			</div>
		</div>
	</div>
	<div class='modal-footer'>		
		<a href="javascript:sendMail();" class="button_bar">Send Email</a>
	</div>
</div>
	
</body>
</html>
<script type="text/javascript">	
	function savePDF(printpage, inv)
	{
		//var headstr = "<html><head><title></title></head><body>";
		//var footstr = "</body>";
		var str = document.all.item(printpage).innerHTML;
		//var oldstr = document.body.innerHTML;
		$.post("savepdf_controller.php",{content:str, invoice:inv},function(data){
			   //alert(data);
			   if (data == 0 ) {							
					alert ("Saved successfully!");			
					//location.reload(); 
				} 		
				else {
					alert ("Could not convert to PDF! Please try later");				
				}	
			  
			});
	}
	
	
	function printdiv(printpage)
	{
		var headstr = "<html><head><title></title></head><body>";
		var footstr = "</body>";
		var newstr = document.all.item(printpage).innerHTML;
		var oldstr = document.body.innerHTML;
		document.body.innerHTML = headstr+newstr+footstr;
		window.print();
		//document.body.innerHTML = oldstr;
		//return false;
	}
	
	function sendMail() {
		var success = 1;			
    	
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var address = document.getElementById('txtsemail').value;
		if(reg.test(address) == false) {
		  alert("Please enter valid Email!");		  
		  success = 0;
		  return;
		}
		
		if (success == 1) {
			
			var serializedData = $('#mail_form').serialize();		
						
			$.post("emailinvoice_controller.php",serializedData,function(data){
			   //alert(data);
			   if (data > 0 ) {							
					alert ("Email is sent successfully!");					
				} else {
					alert ("Email could not be sent!");			
				}		
			  
			});
			
		}	
	}	
	
</script>	
