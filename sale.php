<!DOCTYPE html>

<?php
	
	$mainCat = "Sell";	
	include_once 'path.php';	
?>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  

<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <html dir="ltr" lang="en-US">
	 
	<title>fone-tech</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">    
    <link rel="shortcut icon" href="favicon.ico">  
    <?php
		include_once($path ."head.php"); 
	?> 	
	<link rel="stylesheet" href="assets/css/jquery.signaturepad.css" type="text/css" media="screen"/>    		
	<script type='text/javascript' src='assets/js/jquery.signaturepad.min.js'></script>	
	<script type='text/javascript' src='assets/js/json2.min.js'></script>	
</head> 

<body >
<!-- Include Header  -->
<?php
	include_once($path ."adminheader.php"); 
	if (empty($_SESSION['user_id']))
    {
         /*** redirect ***/
        header("Location: index.php");
        exit;
    }
	//error_reporting(0);
	include_once 'include/global.inc.php';
	$purchaseid = $_GET['pid'];
	
	$tablename="purchase";
	$orderby = " ORDER BY created_at ASC";
	$where= " id=$purchaseid";
	$datar = $db->select($tablename,$orderby, $where);	
	
	foreach ($datar as $row) {		
		$invoice  = $row['invoice'];										
		$make  = $row['make'];
		$model  = $row['model'];
		$imei  = $row['imei'];		
		$pprice = $row['price'];		
		$sprice = $row['sprice'];		
		$shop_id = $row['shop_id'];	
		$ref     = $row['referrence'];
		$refid    = $row['referrenceid'];
	}
	
	$tablename="shops";
	$orderby = " ORDER BY created_at ASC";
	$where= " id=$shop_id";
	$datas = $db->select($tablename,$orderby, $where);
	
	foreach ($datas as $srow) {
		$shopid = $srow['id'];		
		$shopname = $srow['name'];
		$dispname = $srow['display_name'];
	}

	$access ="";
	$missql = "SELECT * FROM misc WHERE itemid = $purchaseid AND (type='accessories' OR type='other')";	
	$misdata = $db->selectQuery($missql);	
	foreach ($misdata as $msrow) {
		$access = $msrow['value'] . "," . $access;		
	}
	$access = trim ($access,",");
	
	$dt = new DateTime("now", new DateTimeZone('Europe/London'));
	//print_r ($dt);
	$edate = $dt->format('d/m/Y H:i');	
	$invno = $db->getInvoiceNo();
	
?>   
<div class="row-fluid ">
	<div class="span12">		
		<!-- LayerSlider Content End -->
		<div class="row-fluid divider slide_divider base_color_background">
			<div class="container">                       
			</div>
		</div>
		<div class="container">					
			<div class="row-fluid distance_1">								
				<div class="row-fluid">
					<div class="span12">		
						<form class="form-horizontal" id="saleform"  name="saleform" method="post" enctype="multipart/form-data" >											
						<div class="span5">	
							<div class="control-group">
								<label class="control-label" >Shop Name: </label>
								<div class="controls">													
									<input  type="text" name="txtshopname" id="txtshopname" class="input-large" value="<?php echo $shopname; ?>" readonly />
								</div>
							</div>															
							<div class="control-group">
								<label class="control-label" >Invoice: </label>
								<div class="controls">													
									<input  type="text" name="txtinvoice" id="txtinvoice" class="input-large" onkeyup="checkInput(this)" value="<?php echo $invno; ?>" readonly>
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Model: </label>
								<div class="controls">
									<input  type="text" name="txtmodel" id="txtmodel" class="input-large" value="<?php echo $model;?>" readonly>
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label" >IMEI#: </label>
								<div class="controls">													
									<input  type="text" name="txtimei" id="txtimei" class="input-large" onkeyup="checkInput(this)" value="<?php echo $imei; ?>" readonly>
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Reference: </label>
								<div class="controls">
									<input type="text" name="txtrefby" id="txtrefby" class="input-large"  value="<?php echo $ref; ?>" readonly>
								</div>
							</div>							
							<!--
							<div class="control-group">							
								<label class="control-label" >Purchased Price (<?php echo "&pound";?>): </label>
								<div class="controls">
									<input  type="text" name="txtpprice" id="txtpprice" class="input-large" value="<?php echo $pprice; ?>" readonly>
								</div>
							</div>	
							-->
							<div class="control-group">							
								<label class="control-label" >Price (<?php echo "&pound";?>): </label>
								<div class="controls">
									<input  type="text" name="txtsprice" id="txtsprice" class="input-large" value="<?php echo $sprice; ?>">
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Grade: </label>
								<div class="controls">
									<input  type="text" name="txtgrade" id="txtgrade" class="input-large" >
								</div>
							</div>								
						</div>
						<div class="span5">	
							<div class="control-group">							
								<label class="control-label" >Date: </label>
								<div class="controls">												
									<input  type="text"  name="txtdate" id="txtdate" class="input-large" value="<?php echo $edate;?>" disabled />																								
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label" >Make: </label>
								<div class="controls">													
									<input  type="text" name="txtmake" id="txtmake" class="input-large" value="<?php echo $make; ?>" readonly>
								</div>
							</div>
							<div class="control-group">		
								<label class="control-label" >Accessories:&nbsp;&nbsp;&nbsp;</label>
								<div class="controls">
									<textarea name="txtaccess" id="txtaccess" class="input-large" style="height:37px;" readonly><?php echo $access; ?></textarea>									
								</div>
							</div>	
							<!--<div class="control-group">							
								<label class="control-label" >Ref Id: </label>
								<div class="controls">
									<input type="text" name="txtrefid" id="txtrefid" class="input-large" value="<?php echo $refid; ?>" readonly>
								</div>
							</div>-->
							<div class="control-group">							
								<label class="control-label" >Seller: </label>
								<div class="controls">
									<input type="text" name="txtsellby" id="txtsellby" class="input-large" >
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Customer Name: </label>
								<div class="controls">
									<input type="text" name="txtcsname" id="txtcsname" class="input-large" >
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Payment Mode: </label>
								<div class="controls">									
									<select id="txtmode" name="txtmode">										
										<option value="Cash">Cash</option>
										<option value="Card">Card</option>										
									</select>	
								</div>
							</div>								
						</div>												
						<div class="row-fluid">
							<div class="span12 page_top_header line-divider" style="margin-bottom:5px;"></div>
						</div>	
						<div class="row-fluid">
							<div class="span12" style="font-size:12px;">
									<p>The following Sales Terms and Conditions relate to the sale of Refurbished Phone Products ('Product/s') purchased by Fone World ('Us', 'We', 'Our'). These said Terms and Conditions are activated from once the product/s accepted and are paid for in full.<br/></p>
									<p> <b>1. Understanding your Refurbished Product</b></p>
									<p>Your product has met Fone World's high quality-control standards. While all our phones are refurbished, they have been thoroughly tested and graded.</p>									
									<p><b>2.	Understanding the Grade of your Refurbished Product</b></p>
									<p><b>Grade A</b></p>
									<p>- The phone is used but in excellent condition.<br/>
									- Cosmetically the phone will show no signs of use, there will be no scratches, cracks or scuffs to the screen or casing.<br/>
									- It's been fully tested*, is in full working order and has been restored to the latest operating system.<br/>									
									</p>
									<p><b>Grade B</b></p>
									<p>- The phone is used and in good condition.
									- Cosmetically the phone will show signs of slight use, including two or three minor scratches to the screen and casing. It won't have cracks on the screen or casing.
									- It's been fully tested*, is in full working order and has been restored to the latest operating system.
									</p>
									<p><b>Grade C</b></p>
									<p>- The phone is used and in average condition.
									- Cosmetically the phone will show signs of use, including some scratches and scuffs to the screen and casing. It won't have cracks on the screen or casing.
									- It's been fully tested*, is in full working order and has been restored to the latest operating system.
									</p>
									<p><b>3.	Acceptance of Sale</b></p>
									<p>You will be offered the opportunity to inspect your product in-store and you will be made aware of the Grade of your product in accordance with the terms of Conditions (1) and (2). Once you have tested the product and completed the sale by paying for the product, you are deemed to have accepted the product in its current condition and grading.</p>
									<p><b>4.	Returns, Repairs and Replacements</b></p>
									<p>4.1	We only entertain genuine claims and reserve right to decline any false claims.</p> 
									<p>4.2	All guarantees to replace, repair or return are void if the returned the product is found to be damaged, scratched, modified, physically altered or manipulated in anyway. This includes attempts to repair the product at another outlet.</p>
									<p>4.3	Fone World will either choose to repair the product in-house or replace as necessary. </p>
									<p>4.4	Any product returned to us may be charged an additional fee of <?php echo "&pound";?>25 to cover the cost of testing and return if products are found to be fully working.</p>

									<p>4.5	You will be offered the opportunity to inspect and accept the product before purchasing, therefor we will not refund purchases if you:</p>
									<p>4.5.1	Made a mistake when purchasing the product; or</p>
									<p>4.5.2	Have  changed your mind about the product; or</p>
									<p>4.5.3	Are returning the product based on facts which you were aware of at the time of the sale.</p>
									<p>4.6	In addition to condition 7;  any returns, repairs or replacement requests will be rejected unless the following conditions are met:</p>
									<p>4.6.1	The product warranty cover only manufacturing fault/software problem within 1 year from date of purchase</p>
									<p>4.6.2	Returns will only be accepted from the person who bought the item, with original receipt within 14 days of item not used/damage</p>
									<p>4.6.3	The original purchase receipt is made available at the time of the request</p>
									<p>The above conditions are part of our commitment to high quality service and do not affect your statutory rights as a consumer. These terms and conditions of sale are governed by the law of England and Wales, and are subject to the jurisdiction of the courts of England and Wales.</p>
									<div class="span12 page_top_header line-divider" style="margin-bottom:5px;"></div>
									<h4>Customer's Declaration</h4>
									<p><b>By signing this contract you are confirming your acceptance and understanding of the Grade of your product and agree to the terms and conditions herein.</b></p>
									<a data-toggle='modal' href='#modal-signin' style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' >
										Customer's Signature:
										<div class="sigPad1 signed"> 
											<div class="sigWrapper" style="width:340px;height:105px;"> 
												<div style="display: none;" class="typed"></div> 
													<canvas class="pad" width="340" height="105"></canvas> 
											</div> 
										</div>		
									</a>
									<input type="hidden" id="txtcsig"  name="txtcsig" >								
							</div>	
						</div>
						<div class="row-fluid">
							<div class="span12 page_top_header line-divider" style="margin:5px;"></div>
						</div>
						<input type="hidden"  name="txtpid" id="txtpid" value="<?php echo $purchaseid; ?>" >					
						<input type="hidden"  name="txtid" id="txtid" value="" >					
						<input type="hidden"  name="txtshop" id="txtshop" value="<?php echo $shopid; ?>" >					
						<input type="hidden"  name="txtcreatedby" id="txtcreatedby" value="<?php echo $_SESSION['user_name']; ?>" >	
						<input type="hidden"  name="txtdispname" id="txtdispname" value="<?php echo $dispname; ?>" >					
						<div class="row-fluid">
							<div class="control-group">							
								<a href="javascript:validatepurchaseForm();"  class="button_bar" name="btnsave" id="btnsave" style="margin-top:10px;margin-left:45%;">Save</a>
								
								<a href="javascript:printForm();"  class="button_bar" name="btnprint" id="btnprint" style="visibility:hidden;margin-top:10px;margin-left:5%;">Print</a>																			
								<!--<a href="javascript:emailForm();"  class="button_bar" name="btnmail" id="btnmail" style="margin-left:5px;visibility:hidden;" >Email</a>-->
								<a data-toggle='modal' href='#modal-semail' class="button_bar" name="btnmail" id="btnmail" onclick="javascript:setId();" style="visibility:hidden;margin-top:10px;margin-left:5%">Email</a>
							</div>
						</div>	
						</form>
					</div>							
				</div>  
			</div>    				
		</div>
	</div>
</div>		
<div class='modal hide fade' id='modal-signin' role='dialog' tabindex='-1' style="width: 700px;">
	<div class='modal-header'>
		<button class='close' data-dismiss='modal' type='button'>&times;</button>
		<h3>Add Signature</h3>
	</div>
	<div class='modal-body' >		
		<div class='controls text-center'>			
			<div class='form-wrapper' >
				<form name="bal_form" id="bal_form" class="sigPad" action="" method="post" >										
																	
							<!--<label for="name">Print your name</label>
							<input type="text" name="name" id="name" class="name">
							<p class="typeItDesc">Review your signature</p>-->
							<p class="drawItDesc" style="width:340px;">Draw your signature</p>
							<ul class="sigNav">
								<!--<li class="typeIt"><a href="#type-it" class="current">Type It</a></li>-->
								<li class="drawIt"><a href="#draw-it">Draw It</a></li>
								<li class="clearButton"><a href="#clear">Clear</a></li>
							</ul>
							<div class="sig sigWrapper" style="width:340px;height:105px;">
								<div class="typed"></div>
								<canvas class="pad" width="340" height="105"></canvas>
								<input type="hidden" id="output"  name="output" class="output">
							</div>							 
							<!--<a href class="button_bar" onlick="javascript:Setsign();" >Save</a>-->
						
				</form>
			</div>
		</div>
	</div>
	<div class='modal-footer'>	
		<a href="javascript:Setsign();" class="button_bar">Save</a>
	</div>
</div>
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
							<input type="hidden"  name="txtrepid" id="txtrepid" value="" >																						
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
	
<footer>
   <?php
		include_once($path."footer.php");                
	?>
</footer>

</body>
</html>
<script>
$(document).ready(function () {
  $('.sigPad').signaturePad({drawOnly:true});
});
</script>


<script type="text/javascript">	
	
	function checkInput(ob) {
		var invalidChars = /[^0-9]/gi
		if(invalidChars.test(ob.value)) {
            ob.value = ob.value.replace(invalidChars,"");
		}
	}
	
   function validatepurchaseForm () {
		var success = 1;			
  
	
	
	if (document.getElementById("txtsprice").value == "" ) {
            alert("Please enter Price!");
			document.getElementById("txtsprice").focus();
			success = 0;
            return;
    }	
	
	
	if (document.getElementById("txtcsname").value == "" ) {
            alert("Please enter Customer Name#!");
			document.getElementById("txtcsname").focus();
			success = 0;
            return;
    }	
	
		
	if (success == 1) {
		
		var docForm = document.getElementById('saleform');  
		var serializedData = new FormData(docForm);  		
		
		$.ajax({
			type:'POST',
			url: "sale_controller.php",
			data:serializedData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(data){
			//alert(data);
			if (data > 0 )	{		
				alert ("Data is saved successfully!");
				document.getElementById("txtid").value = data;				
				document.getElementById("btnsave").style.visibility = "hidden";
				document.getElementById("btnprint").style.visibility = "visible";
				document.getElementById("btnmail").style.visibility = "visible";
				
				//document.getElementById('purchaseform').reset();
				//location.reload(); 
			}
		   else				
				alert ("Data could not be saved!");	
			}
		});
			
	}
	
	
	
}	

function Setsign () 
{
	
	//var sig = [{lx:20,ly:34,mx:20,my:34},{lx:21,ly:33,mx:20,my:34},…];
			
	if (document.getElementById("output").value == "" ) {
            alert("Please Draw Signature!");
			//success = 0;
            return;
			
    } else {	
		var sig = document.getElementById("output").value
		//alert (sig);
		$('.sigPad1').signaturePad({displayOnly:true}).regenerate(sig);
		document.getElementById("txtcsig").value = sig
		$('#modal-signin').modal('hide');
	}	
	
	
}

function setId() {
		var repid = document.getElementById("txtid").value;
		document.getElementById("txtrepid").value = repid;	
}

function  printForm () {
	var id = document.getElementById("txtid").value; 
	var url = "sinvoice.php?sid="+id;
	window.open(url, '_blank');	
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
						
			$.post("sellinvoicemail_controller.php",serializedData,function(data){
			   alert(data);
			   if (data > 0 ) {							
					alert ("Email is sent successfully!");					
				} else {
					alert ("Email could not be sent!");			
				}		
			  
			});
			
		}	
	}	
</script>
