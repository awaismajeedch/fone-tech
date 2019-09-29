<!DOCTYPE html>

<?php
	$mainCat = "Unlcok";	
	include_once 'path.php';	
?>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  

<head>
    <html dir="ltr" lang="en-US">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<title>FoneWorld</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">    
    <link rel="shortcut icon" href="favicon.ico">  
    <?php
		include_once($path ."head.php"); 
	?> 

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
		$lbid = $row['ulabid'];
	}
	/*
	if (!empty($lbid)) {
		$tablename="labs";
		$orderby = " ORDER BY created_at ASC";
		$where= " id=$lbid";
		$datal = $db->select($tablename,$orderby, $where);
		
		foreach ($datal as $rowl) {
			$labname = $rowl['name'];			
		}
	
	}
	$tablename="unlock_data";
	$orderby = " ORDER BY network ASC";
	$where= " 1=1";
	$datau = $db->select($tablename,$orderby, $where);
	*/
	$sqln = "SELECT distinct(network) FROM unlock_data ORDER BY network ASC";	
	$datau = $db->selectQuery($sqln);	
	$table="unlocks";
	$wherein = " shop_id=$shopid AND status='Inprogress'";
	$inTot = $db->totalRecords($table, $wherein);		
	//echo "pe" . $peTot;
	$wherefx = " shop_id=$shopid AND status='Success'";
	$fxTot = $db->totalRecords($table, $wherefx);
	//echo "Fi" . $coTot;
	$whereco = " shop_id=$shopid AND status='Rejected'";
	$coTot = $db->totalRecords($table, $whereco);

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
					<div class="accordion" id="accordion">													
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									<h4>Add Phone Specifications</h4>
								</a>
							</div>
							<div id="collapseOne" class="accordion-body collapse  in">
								<div class="accordion-inner">
									<div class="span12">		
										<form class="form-horizontal" id="unlockform"  name="unlockform" method="post" >											
											<div class="row-fluid">
												<div class="span10">												
													<div class="control-group">
														<label class="control-label" >Service </label>
														<div class="controls">		
															<select name="cmbservice" id="cmbservice" style="width:100%; font-size:16px;" onchange="javascript:showDivs(this.value);">
																<option value="">-- Please Select Service --</option>
																<?php foreach ($datau as $rowu) {																		
																	$strnw = trim($rowu['network']);																	
																	//echo $strnw;
																	$sql = "SELECT * FROM unlock_data WHERE network = '$strnw'";	
																	$udatar = $db->selectQuery($sql);										
																	echo "<optgroup label='$strnw'>";
																	foreach ($udatar as $urow) {
																		$strid = $urow['id'];
																		$strsumm = $urow['summary'];
																		$strpr = $urow['price'];
																		$strdu = $urow['duration'];																	
																		echo "<option value=$strid>$strsumm - &pound $strpr - $strdu Hours</option>";
																	}
																	echo "</optgroup>";	
																 } ?>
																	
															</select>
														</div>
													</div>	
												</div>
											</div>
											<div name="showdiv" id="showdiv" style="visibility:hidden;">
												<div class="row-fluid">	
													<div class="span5">												
														<div class="control-group">							
															<label class="control-label" >Date: </label>
															<div class="controls">												
																<input  type="text"  name="txtdate" id="txtdate" class="input-large" value="<?php echo $edate;?>" disabled />																								
															</div>
														</div>	
														<div class="control-group">
															<label class="control-label" >*Invoice: </label>
															<div class="controls">													
																<input  type="text" name="txtinvoice" id="txtinvoice" class="input-large" onkeyup="checkInput(this)" value="<?php echo $invno; ?>" readonly>
															</div>
														</div>													
														<div class="control-group">
															<label class="control-label" >*IMEI#: </label>
															<div class="controls">													
																<!--<input  type="text" name="txtimei" id="txtimei" class="input-large" onkeyup="checkInput(this)" >-->
																<input  type="text" name="txtimei" id="txtimei" class="input-large" onkeyup="checkInput(this)" onchange="validateImei()" >
															</div>
														</div>	
														<div class="control-group">
															<label class="control-label" >Model: </label>
															<div class="controls">													
																<input  type="text" name="txtmodel" id="txtmodel" class="input-large">
															</div>
														</div>
														<div class="control-group">
															<label class="control-label" >Network: </label>
															<div class="controls">													
																<input  type="text" name="txtnetwork" id="txtnetwork" class="input-large">
															</div>
														</div>
														<div class="control-group">
															<label class="control-label" >Customer Name: </label>
															<div class="controls">													
																<input  type="text" name="txtcsname" id="txtcsname" class="input-large">
															</div>
														</div>
														<div class="control-group">
															<label class="control-label" >Customer Email: </label>
															<div class="controls">													
																<input  type="text" name="txtemail" id="txtemail" class="input-large">
															</div>
														</div>
														<div class="control-group">
															<label class="control-label" >Customer Contact: </label>
															<div class="controls">													
																<input  type="text" name="txtcontact" id="txtcontact" class="input-large">
															</div>
														</div>	
														<div class="control-group">
															<label class="control-label" >*Charges (<?php echo "&pound"; ?>): </label>
															<div class="controls">													
																<input  type="text" name="txtcharges" id="txtcharges" class="input-large" onkeyup="checkInput(this)">
															</div>
														</div>	
														<!--
														<div class="control-group">
															<label class="control-label" >Duration (Hours): </label>
															<div class="controls">													
																<input  type="text" name="txtduration" id="txtduration" class="input-large" onkeyup="checkInput(this)">
															</div>
														</div>	
														-->
														<div class="control-group">							
															<label class="control-label" >Notes: </label>
															<div class="controls">
																<textarea  name="txtnotes" id="txtnotes" class="input-large" style="height:70px;" placeholder="Please dont use slashes or quotes while entring notes"></textarea>
															</div>
														</div>	
														<div class="control-group">							
															<a href="javascript:validateshopsForm();" name="btnusave" id="btnusave" class="button_bar" style="float:right;">Save</a>											
														</div>		
													</div>
													
													<div class="span4 offset1">											
														<div style="background-color:#efb900; font-size:16px;color:#000;">
															<div class="control-group" name="seldata" id="seldata" style="margin-left:10px;">
																<!--
																<b>Summary</b><br/>		
																<p>Iphone 5S Unlocking</p>
																<b>Charges: 5.00</b><b>Time Required: 24 Hours</b>																
																<b>Description: </b><br/>
																<p>This is testing being performed by abc company </p>
																-->
															</div>																											
														</div>	
													</div>														
													<input type="hidden"  name="txtid" id="txtid" value="" >
													<input type="hidden"  name="txtsummary" id="txtsummary" value="" >
													<input type="hidden"  name="txtshop" id="txtshop" value="<?php echo $shopid; ?>" >
													<input type="hidden"  name="txtlab" id="txtlab" value="<?php echo $lbid; ?>" >
													<input type="hidden"  name="txtcreatedby" id="txtcreatedby" value="<?php echo $_SESSION['user_name']; ?>" >
													<!--<input  type="hidden" name="txtcharges" id="txtcharges" value="">-->
													<input  type="hidden" name="txtduration" id="txtduration" value="">
												</div>	
											</div>	
										</form>	
									</div>									
								</div>
							</div>
						</div>
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									<h4>Inprogress List<span> ( Total Count = <?php echo $inTot; ?> )</span></h4> 									
								</a>
							</div>
							<div id="collapseTwo" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="text-block-1">									  
										<div>	
											<div id="unlockshoplist">
											<?php
												include_once($pathaj."unlockshop_list.php");
											?>	
											</div>		
										</div>
									</div> 								
								</div>
							</div>
						</div>	
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
									<h4>Success List <span> ( Total Count = <?php echo $fxTot; ?> )</span> </h4>									
								</a>
							</div>
							<div id="collapseThree" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="text-block-1">									  
										<div>	
											<div id="unlockfixedlist">
											<?php
												include_once($pathaj."unlockfixed_list.php");
											?>	
											</div>		
										</div>
									</div> 								
								</div>
							</div>
						</div>		
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
									<h4>Rejected List <span> ( Total Count = <?php echo $coTot; ?> )</span></h4>									
								</a>
							</div>
							<div id="collapseFour" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="text-block-1">									  
										<div>	
											<div id="unlockcompletedlist">
											<?php
												include_once($pathaj."unlockcompleted_list.php");
											?>	
											</div>		
										</div>
									</div> 								
								</div>
							</div>
						</div>
						<!--	
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
									<h4>Not Fixed List <span> ( Total Count = <?php echo $nfTot; ?> )</span></h4>									
								</a>
							</div>
							<div id="collapseFive" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="text-block-1">									  
										<div>	
											<div id="notfixedlist">
											<?php
												//include_once($pathaj."notfixed_list.php");
											?>	
											</div>		
										</div>
									</div> 								
								</div>
							</div>
						</div>	
						-->
					</div>						
				 
			</div>    				
		</div>
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
$(document).ready(function() {
  $("#cmbservice").select2();
});
</script>
<script type="text/javascript">	
//351451208401216

	function remove_not_digits(imei) {
		return imei.replace(/[^0-9]/, '');
	}
	function validateImei()
	{
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
			var serializedData = $('#unlockform').serialize();		
			$.post("validateimei_controller.php",serializedData,function(data){
			   //alert(data);
			   if (data !=0 ) {		
					alert ("IMEI# already exists!");
					return false;
					$('#txtimei').focus();
				}
			  
			});
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

</script>

<script type="text/javascript">		
	function showDivs(id) {	
		//alert(id);
		if ( id != "" ) {
			$.post("unlockdata.php",{uid:id},function(data){
			   //alert(data);
			   $('#seldata').html(data);
			});
		}
		var p ="\u00A3" ;
		var t = document.getElementById("cmbservice");
		var selectedText = t.options[t.selectedIndex].text;			
		var partsArray = selectedText.split(p);		
		var partsArray2 = partsArray[1].split("-");		
		var chg = partsArray2[0];								
		var dur = partsArray2[1];
		var duration = dur.split(" ");		
		
		document.getElementById("txtsummary").value = partsArray[0];
		document.getElementById("txtcharges").value = chg;		
		document.getElementById("txtduration").value = duration[1];
		
		if (document.getElementById("cmbservice").value != "") 
			document.getElementById("showdiv").style.visibility = 'visible';
		else 
			document.getElementById("showdiv").style.visibility = 'hidden';
	}
	
	function checkInput(ob) {
		var invalidChars = /[^0-9]/gi
		if(invalidChars.test(ob.value)) {
            ob.value = ob.value.replace(invalidChars,"");
		}
	}
	
   function validateshopsForm () {
		var success = 1;			
  	
	if (document.getElementById("txtnotes").value != "" )	{
		var mystring = document.getElementById("txtnotes").value;
		//var parsed = mystring.replace(/\'/g,"");
		var parsed = mystring.replace(/["'&$@#%^!()*\\]/g, "");		
		//document.getElementById("txtnotes").value = parsed;
		var xparsed = parsed.replace(/\//g,'-');				
		document.getElementById("txtnotes").value = xparsed;
	}	
	
	if (document.getElementById("txtinvoice").value == "" ) {
            alert("Please enter Invoice!");
			success = 0;
            return;
			
    }	
	
	if (document.getElementById("txtimei").value == "" ) {
            alert("Please enter IMEI#!");
			success = 0;
            return;
			
    }	
		
	
	if (document.getElementById("txtcharges").value == "" ) {
            alert("Please enter Charges!");
			success = 0;
            return;
			
    }
	
	if (validateImei() == false) {
		success = 0;		
        return;
	}
	
	if (document.getElementById('txtemail').value != "" ) {
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var address = document.getElementById('txtemail').value;
		if(reg.test(address) == false) {
		  alert("Please enter valid Email!");		  
		  success = 0;
		  return;
		}
	}
	
		
	if (success == 1) {
		waitingDialog.show('Please wait.....');
		document.getElementById("btnusave").style.visibility = 'hidden'; 	
		
		var serializedData = $('#unlockform').serialize();		
		
		$.post("unlockshop_controller.php",serializedData,function(data){
           //alert(data);
		   if (data > 0 )	{		
				alert ("Data is saved successfully!");
				document.getElementById('unlockform').reset();
				location.reload(); 
			}
		   else				
				alert ("Data could not be saved!");	
				waitingDialog.hide();	
          
		});
		
		document.getElementById("btnusave").style.visibility = 'visible'; 
	}	
	
	
}	
</script>
