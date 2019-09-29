<!DOCTYPE html>

<?php
	$mainCat = "Purchase";	
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
	
	include_once 'include/global.inc.php';
	$shopid = $_SESSION['shop_id'];
	$tablename="shops";
	$orderby = " ORDER BY created_at ASC";
	$where= " id=$shopid";
	$datar = $db->select($tablename,$orderby, $where);
	
	foreach ($datar as $row) {
		$shopname = $row['name'];
		$lbid = $row['labid'];
	}

	if (!empty($lbid)) {
		$tablename="labs";
		$orderby = " ORDER BY created_at ASC";
		$where= " id=$lbid";
		$datal = $db->select($tablename,$orderby, $where);
		
		foreach ($datal as $rowl) {
			$labname = $rowl['name'];			
		}
	
	}
	
	
	$table="repairs";
	$wherein = " shop_id=$shopid AND status='Inprogress'";
	$inTot = $db->totalRecords($table, $wherein);	
	$wherepe = " shop_id=$shopid AND status='Pending'";
	$peTot = $db->totalRecords($table, $wherepe);
	//echo "pe" . $peTot;
	$wherecom = " shop_id=$shopid AND status='Fixed'";
	$coTot = $db->totalRecords($table, $wherecom);
	//echo "Fi" . $coTot;
	$wherenf = " shop_id=$shopid AND status='NotFixed'";
	$nfTot = $db->totalRecords($table, $wherenf);

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
						<form class="form-horizontal" id="purchaseform"  name="purchaseform" method="post" enctype="multipart/form-data" >											
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
								<label class="control-label" >*Model: </label>
								<div class="controls">
									<input  type="text" name="txtmodel" id="txtmodel" class="input-large" >
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >*Customer Name: </label>
								<div class="controls">
									<input  type="text" name="txtcsname" id="txtcsname" class="input-large" >
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Contact Number: </label>
								<div class="controls">
									<input  type="text" name="txtcsno" id="txtcsno" class="input-large" >
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Address: </label>
								<div class="controls">
									<textarea  name="txtcaddress" id="txtcaddress" class="input-large" style="height:70px;" ></textarea>
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Price: </label>
								<div class="controls">
									<input  type="text" name="txtprice" id="txtprice" class="input-large" >
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Reference: </label>
								<div class="controls">
									<input type="text" name="txtrefby" id="txtrefby" class="input-large" >
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
								<label class="control-label" >*Make: </label>
								<div class="controls">													
									<!--<input  type="text" name="txtmake" id="txtmake" class="input-large" >-->
									<select id="txtmake" name="txtmake">
										<option value="">Select...</option>	
										<option value="Alcatel">Alcatel</option>
										<option value="Apple">Apple</option>
										<option value="Blackberry">Blackberry</option>
										<option value="Huawei">Huawei</option>
										<option value="Htc">HTC</option>
										<option value="LG">LG</option>
										<option value="Motorolla">Motorolla</option>
										<option value="Nexus">Nexus</option>
										<option value="Nokia">Nokia</option>
										<option value="Samsung">Samsung</option>										
										<option value="Sony">Sony</option>
										<option value="Tab">Tab</option>
									</select> 
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label" >*IMEI#: </label>
								<div class="controls">													
									<input  type="text" name="txtimei" id="txtimei" class="input-large" onkeyup="checkInput(this)" placeholder="Please use Numerics only" onchange="validateImei()">
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Password: </label>
								<div class="controls">
									<input  type="text" name="txtcpwd" id="txtcpwd" class="input-large" >
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Notable Defects: </label>
								<div class="controls">
									<input  type="text" name="txtdefects" id="txtdefects" class="input-large" >
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Network: </label>
								<div class="controls">
									<input  type="text" name="txtnetwork" id="txtnetwork" class="input-large" >
								</div>
							</div>		
							<div class="control-group">							
								<label class="control-label" >Identification: </label>
								<div class="controls">
									<input type="file"  name="txtfile" id="txtfile" class="input-large" />	
									<input type="hidden" name="userdbimage" id="userdbimage" value="" >	
									<!--<span >(Image Size w:380px, h:88px)</span>-->
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Retailer: </label>
								<div class="controls">
									<input type="text" name="txtrecby" id="txtrecby" class="input-large" >
								</div>
							</div>
							<!--
							<div class="control-group">							
								<label class="control-label" >Ref Id: </label>
								<div class="controls">
									<input type="text" name="txtrefid" id="txtrefid" class="input-large" >
								</div>
							</div>
							-->
							<!--
							<div class="control-group">							
								<label class="control-label" >Notes: </label>
								<div class="controls">
									<textarea  name="txtnotes" id="txtnotes" class="input-large" style="height:70px;" placeholder="Please dont use slashes or quotes while entring notes"></textarea>
								</div>
							</div>												
							-->
						</div>						
						<div class="span12">	
							<div class="span2">
								<div class="control-group">		
									<label class="control-label" >Accessories:&nbsp;&nbsp;&nbsp; </label>
								</div>	
							</div>
							<div class="span7">										
								<label class="checkbox inline">
								  <input type="checkbox" name="access" id="chkbox" value="Box" > Box
								</label>
								<label class="checkbox inline">
								  <input type="checkbox" name="access" id="chkcharger" value="Charger"> Charger
								</label>
								<label class="checkbox inline">
								  <input type="checkbox" name="access" id="chkhphone" value="Headphone"> Headphone
								</label>
								<label class="checkbox inline">
								  <input type="checkbox" name="access" id="chkhother" value="Other"> Other	&nbsp;&nbsp;&nbsp;								 									  								
								</label>
								  <span><input type="text" name="txtother" id="txtother" class="input-medium" ></span>	
							</div>
							<input type="hidden" name="txtaccess"	id="txtaccess" />	
						</div>	
						<div class="row-fluid">
							<div class="span12 page_top_header line-divider" style="margin-bottom:5px;"></div>
						</div>	
						<div class="row-fluid">
							<div class="span12" >
								<div class="span2 offset1">
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chkapple" value="Apple ID Removed"> Apple ID Removed
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chkcameras" value="Back and Front Camera"> Back and Front Camera
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chkear" value="Ear Piece"> Ear Piece
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chkbuttons" value="Buttons"> Buttons
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chkcport" value=" Charging Port"> Charging Port
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chkmic" value="Mic"> Mic
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chkwifi" value="Wifi"> Wifi
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chksignal" value="Signals & Calling"> Signals & Calling
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chkringer" value="Ringer & Music"> Ringer & Music
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chktouch" value="Touch"> Touch
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chklcd" value="Lcd"> Lcd
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chksensor" value="Sensor"> Sensor
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chkhphone" value="Headphones"> Headphones
									</div>	
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chklspeak" value="Loudspeaker"> Loudspeaker
									</div>											
									<div class="control-group checkbox">		
										<input type="checkbox" name="checks" id="chkrepair" value="Repaired Before"> Repaired Before
									</div>	
									<input type="hidden" name="txtchecks"	id="txtchecks" />
								</div>
								<div class="span8" style="font-size:12px;">
									<p>1. The trade-in services are operated by Fone World ('US', 'WE'). Nothing in these terms and conditions shall affect your statutory rights. These Conditions are governed by English Law and the courts of England shall have exclusive jurisdiction to settle any dispute or claim arising out of or in connection with these Conditions. By signing this agreement 'YOU', the customer, agree to the following conditions:<br/></p>
									<p> <b>1. Your Information</b></p>
									<p>1.1 You consent to us passing your information (including name, address, telephone number, email address, Device make/model/IMEI/network) in order for us to process your trade in and contact you and the network in relation to unlocking of the Device only.</p>
									<p>1.2 Data stored on the Device that you wish to retain must be saved elsewhere and you must remove any memory card and/ or all data that has been put onto the Device prior to trade in. We will not be liable for any damage, loss or erasure of any such data or for any consequences of you not removing your data or memory card, including use or disclosure of such data.</p>
									<p>1.3 If the Device contains a SIM card, you must remove this along with any accessories prior to trade in. We will not be liable for any consequences of you not removing the SIM card or accessories, including any payments associated with the Device or the SIM card.</p>
									<p><b>2. Change of Ownership</b></p>
									<p>2.2 By signing and agreeing to the terms of this agreement and; accepting our pre-agreed trade-in payout sum and; by handing us your goods, the goods will be deemed to be property of Fone World and all rights over the goods will be transferred to us.</p>
									<p><b>3. The Goods or Device</b></p>
									<p>3.1 You confirm that you are either the owner of the Device or Goods or you have obtained express permission from the rightful owner to trade in The Goods.</p>
									<p>3.2 The Goods must not be stolen or listed with us or a third party as stolen. If The Goods fail any due diligence check we may notify the relevant police authority and we may pass The Goods and your details to them and the Quoted Value will not be paid to you.</p>
									<p>3.3 Fone World may seek compensation in full against you for any loss, damage or expense incurred by you for inaccurate information regarding the goods you have sold to us.</p>
									<p>3.4 The Goods are not subject to hire purchase, rental agreement or any other loan/charge that may result in the loss of these goods from us.</p>
									<p>3.5 The Goods are in fully working order and are free from any defects or damage (unless we are accepting your goods in a faulty condition)</p>
									<p><b>4. Returns</b></p>
									<p>4.1 Once you have traded in The Goods, it will not be returned to you under any circumstances.</p>
									<div class="span12 page_top_header line-divider" style="margin-bottom:5px;"></div>
									<h4>Customer's Declaration</h4>
									<div class="control-group checkbox">		
										<input type="checkbox" name="chkterms" id="chkterms" value="chkterms"> I confirm that I have read and understood the terms and conditions of Fone World Trade-In Agreement set out above points 1, 2, 3 and 4.
									</div>
									<div class="control-group checkbox">		
										<input type="checkbox" name="chkstatments" id="chkstatments" value="chkstatments"> I confirm that all statements and information provided are accurate and true.
									</div>
									<div class="control-group checkbox">		
										<input type="checkbox" name="chkage" id="chkage" value="chkage"> I confirm that I am over 18 years old.
									</div>
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
						</div>
						<div class="row-fluid">
							<div class="span12 page_top_header line-divider" style="margin:5px;"></div>
						</div>
						<input type="hidden"  name="txtid" id="txtid" value="" >					
						<input type="hidden"  name="txtshop" id="txtshop" value="<?php echo $shopid; ?>" >					
						<input type="hidden"  name="txtcreatedby" id="txtcreatedby" value="<?php echo $_SESSION['user_name']; ?>" >	
						<div class="row-fluid">
							<div class="control-group">							
								<a href="javascript:validatepurchaseForm();"  class="button_bar" name="btnsave" id="btnsave" style="margin-top:10px;margin-left:45%;">Save</a>
								
								<a href="javascript:printForm();"  class="button_bar" name="btnprint" id="btnprint" style="visibility:hidden;margin-top:10px;margin-left:5%;">Print</a>																			
								<!--<a href="javascript:emailForm();"  class="button_bar" name="btnmail" id="btnmail" style="margin-left:5px;visibility:hidden;" >Email</a>-->
								<!--<a data-toggle='modal' href='#modal-semail' class="button_bar" name="btnmail" id="btnmail" onclick="javascript:setId();" style="visibility:hidden;margin-top:10px;margin-left:5%">Email</a>-->
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
	<script type='text/javascript' src='assets/js/spinner.js'></script>
</footer>

</body>
</html>
<script>
$(document).ready(function () {
  $('.sigPad').signaturePad({drawOnly:true});
});

</script>


<script type="text/javascript">	
	function remove_not_digits(imei) {
		return imei.replace(/[^0-9]/, '');
	}
	function validateImei()
	{
		if (document.getElementById("txtmake").value !== "Tab" ) {
			var imei = $('#txtimei').val();
			var bad_words = imei.length - imei.replace(/[^0-9]/g,"").length;
			for (var i=0; i<bad_words; i++)
			{
				imei = remove_not_digits(imei);
			}
			$('#txtimei').val(imei);
			correct_cd = gen_cd(imei);
			insert_cd = imei.charAt(imei.length - 1)
			if ((imei.length > 0 && imei.length < 15 || imei.length > 15) || correct_cd != insert_cd )
			{
				alert('Invalid IMEI Number!');
				$('#txtimei').focus();
				return false;
				
			} else {
				var imei = $('#txtimei').val();
				$.post("validateimeipurchase_controller.php",{txtimei:imei},function(data){
				   //alert(data);
				   if (data !=0 ) {		
						alert ("IMEI# already exists!");
						return false;
						$('#txtimei').focus();
					}
				  
				});
			}
		}	
			
	}
	
	
	function gen_cd(imei) {
		var step2 = 0;
		var step2a = 0;
		var step2b = 0;
		var step3 = 0;
		// add zero's till the length is 14
		for(var i=imei.length; i < 14; i++)
			imei = imei + "0";
		for(var i=1; i<14; i=i+2) {
			var step1 = (imei.charAt(i))*2 + "0";
			// add the individual digits of the numbers calculates in step 1
			step2a = step2a + parseInt(step1.charAt(0)) + parseInt(step1.charAt(1));
		}
		// add together all the digits on an even position
		for(var i=0;i<14;i=i+2)
			step2b = step2b + parseInt(imei.charAt(i));
		
		step2 = step2a + step2b;
		// if the last digit of step2 is zero then the Luhn digit is zero
		if ( step2 % 10 == 0) step3 = 0;
			// otherwise find the nearest higher number ending with a zero
		else
			step3 = 10 - step2 % 10;
		return step3;
	}

		
	function checkInput(ob) {
		var invalidChars = /[^0-9]/gi
		if(invalidChars.test(ob.value)) {
            ob.value = ob.value.replace(invalidChars,"");
		}
	}
	/*
	function validateImei()
	{
		var imei = $('#txtimei').val();
		var serializedData = $('#unlockform').serialize();		
		$.post("validateimeipurchase_controller.php",{txtimei:imei},function(data){
		   //alert(data);
			if (data !=0 ) {		
				alert ("IMEI# already exists!");				
				$('#txtimei').focus();
				return false;
			}
		  
		});
			
	}
	*/
    function validatepurchaseForm () {
		var success = 1;			
  
	/*
	if (document.getElementById("txtinvoice").value == "" ) {
            alert("Please enter Invoice#!");
			document.getElementById("txtinvoice").focus();
			success = 0;
            return;
			
    }
	*/	
	
	if (validateImei() == false) {
		success = 0;		
        return;
	}
	
	if (document.getElementById("txtmake").value == "" ) {
            alert("Please enter Make!");
			document.getElementById("txtmake").focus();
			success = 0;
            return;
			
    }	
	
	if (document.getElementById("txtmodel").value == "" ) {
            alert("Please enter Model!");
			document.getElementById("txtmodel").focus();
			success = 0;
            return;
			
    }		
	
	if (document.getElementById("txtimei").value == "" ) {
            alert("Please enter IMEI#!");
			document.getElementById("txtimei").focus();
			success = 0;
            return;
			
    }	
	if (document.getElementById("txtcsname").value == "" ) {
            alert("Please enter Customer Name#!");
			document.getElementById("txtcsname").focus();
			success = 0;
            return;
			
    }	
	
	
	if (document.getElementById("txtcaddress").value != "" )	{
		var mystring = document.getElementById("txtcaddress").value;
		var parsed = mystring.replace(/\'/g,"");
		document.getElementById("txtcaddress").value = parsed;
	}	
	
	var terms = document.getElementById('chkterms');
	var stmt = document.getElementById('chkstatments');
	var age = document.getElementById('chkage');
	
	if  (!(terms.checked)) {
           alert("Please accept Customer's Declaration!");
			success = 0;
            return;			
    }	
	if  (!(stmt.checked)) {
           alert("Please accept Customer's Declaration!");
			success = 0;
            return;			
    }	
	if  (!(age.checked)) {
           alert("Please accept Customer's Declaration!");
			success = 0;
            return;			
    }	

	
	
	if (success == 1) {
		
		// To get all Accessories list
		var accessVal="";
		$('input[name=access]:checked').each(function(i) {
			 accessVal = accessVal + "," + this.value; 		 
			while(accessVal.charAt(0) === ',')
				accessVal = accessVal.substr(1);		
			//alert (catVal);
			document.getElementById("txtaccess").value = accessVal;		        
			}); 
		
		// To get all Phone Verification list
		var checkVal="";
		$('input[name=checks]:checked').each(function(i) {
			 checkVal = checkVal + "," + this.value; 		 
			while(checkVal.charAt(0) === ',')
				checkVal = checkVal.substr(1);		
			//alert (checkVal);
			document.getElementById("txtchecks").value = checkVal;		        
			});
		
		//Showing Message
		waitingDialog.show('Please wait.....');
		var docForm = document.getElementById('purchaseform');  
		var serializedData = new FormData(docForm);  		
		
		$.ajax({
			type:'POST',
			url: "purchase_controller.php",
			data:serializedData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(data){
			if (data > 0 )	{		
				alert ("Data is saved successfully!");
				document.getElementById("txtid").value = data;				
				document.getElementById("btnsave").style.visibility = "hidden";
				waitingDialog.hide();
				document.getElementById("btnprint").style.visibility = "visible";
				//document.getElementById("btnmail").style.visibility = "visible";
				document.getElementById("btnprint").focus();
				//document.getElementById('purchaseform').reset();
				//location.reload(); 
			}
		   else				
				alert ("Data could not be saved!");	
				waitingDialog.hide();
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
	var url = "pinvoice.php?pid="+id;
	window.open(url, '_blank');
	/*
	$.ajax({
        url: "pinvoice.php?pid="+id,
        type: "GET",
        //data: dataToPassToAjax,     
        cache: false,
        success: function (resultHtml ) {
		
            // add the returned data to the .done element
            //var headstr = "<html><head><title></title></head><body>";
			//var footstr = "</body>";
			var newstr = (resultHtml).innerHTML;
			//var oldstr = document.body.innerHTML;
			//document.body.innerHTML = headstr+newstr+footstr;
			document.body.innerHTML = newstr;
			window.print();
		
          }
    });
	*/
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
						
			$.post("invoicemail_controller.php",serializedData,function(data){
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
