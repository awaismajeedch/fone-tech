<!DOCTYPE html>

<?php
	$mainCat = "Purchase";	
	include_once 'path.php';	
	error_reporting(E_ERROR | E_PARSE);
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
	include_once($path ."sadminheader.php"); 
	if (empty($_SESSION['user_id']))
    {
         /*** redirect ***/
        header("Location: index.php");
        exit;
    }
	
	include_once 'include/global.inc.php';
	$purchaseid = $_GET['pid'];
	
	$tablename="purchase";
	$orderby = " ORDER BY created_at ASC";
	$where= " id=$purchaseid";
	$datar = $db->select($tablename,$orderby, $where);	
	
	foreach ($datar as $row) {		
		$invoice  = $row['invoice'];
		$timestamp = strtotime($row['date_entered']);							
		$edate =  date("d/m/Y h:i", $timestamp);		
		$make  = $row['make'];
		$model  = $row['model'];
		$imei  = $row['imei'];
		$customername =  $row['customer_name'];
		$password = $row['password'];
		$contact = $row['contact_number'];		
		$defects = $row['defects'];
		$address = $row['address'];
		$network = $row['network'];
		$price = $row['price'];
		$sprice = $row['sprice'];
		$filename = $row['identification'];		
		$signame = $row['signimage'];
		$enteredby = $row['entered_by'];		
		$shop_id = $row['shop_id'];	
		$ref = $row['referrence'];
		$refid = $row['referrenceid'];
	}
	
	
	
	$tablename="shops";
	$orderby = " ORDER BY created_at ASC";
	$where= " id=$shop_id";
	$datas = $db->select($tablename,$orderby, $where);
	
	foreach ($datas as $srow) {
		$shopname = $srow['name'];		
	}

	$access ="";
	$missql = "SELECT * FROM misc WHERE itemid = $purchaseid AND (type='accessories' OR type='other')";	
	$misdata = $db->selectQuery($missql);	
	foreach ($misdata as $msrow) {
		$access = $access. ", " . $msrow['value'];
		$access = ltrim ($access," ,");
	}
	$cbchecks[] ="";
	$cksql = "SELECT * FROM misc WHERE itemid = $purchaseid AND type='check'";	
	$ckdata = $db->selectQuery($cksql);	
	if (!empty($ckdata)) {
		foreach ($ckdata as $ckrow) {
			$cbchecks[] = $ckrow['value'];		
		}
	}	
	//$dbchecksArray = explode(',',$cbchecks);
	
	
	$checks = array(
		"Apple ID Removed",
		"Back and Front Camera",
		"Ear Piece",
		"Buttons",
		"Charging Port",
		"Mic",
		"Wifi",
		"Signals & Calling",
		"Ringer & Music",
		"Touch",
		"Lcd",
		"Sensor",
		"Headphones",
		"Loudspeaker",
		"Repaired Before"
	);
	
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
						<form class="form-horizontal" id="upurchaseform"  name="upurchaseform" method="post" enctype="multipart/form-data" >											
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
									<input  type="text" name="txtinvoice" id="txtinvoice" class="input-large" onkeyup="checkInput(this)"  value="<?php echo $invoice; ?>" readonly>
								</div>
							</div>		
							<div class="control-group">							
								<label class="control-label" >*Model: </label>
								<div class="controls">
									<input  type="text" name="txtmodel" id="txtmodel" class="input-large" value="<?php echo $model; ?>">
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >*Customer Name: </label>
								<div class="controls">
									<input  type="text" name="txtcsname" id="txtcsname" class="input-large" value="<?php echo $customername; ?>">
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Contact Number: </label>
								<div class="controls">
									<input  type="text" name="txtcsno" id="txtcsno" class="input-large" value="<?php echo $contact; ?>">
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Address: </label>
								<div class="controls">
									<textarea  name="txtcaddress" id="txtcaddress" class="input-large" style="height:70px;" ><?php echo $address; ?></textarea>
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Purchase Price (<?php echo "&pound";?>): </label>
								<div class="controls">
									<input  type="text" name="txtprice" id="txtprice" class="input-large" value="<?php echo $price; ?>">
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Selling Price (<?php echo "&pound";?>): </label>
								<div class="controls">
									<input  type="text" name="txtsprice" id="txtsprice" class="input-large" value="<?php echo $sprice; ?>">
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Reference: </label>
								<div class="controls">
									<input type="text" name="txtrefby" id="txtrefby" class="input-large" value="<?php echo $ref; ?>">
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
									<input  type="text" name="txtmake" id="txtmake" class="input-large" value="<?php echo $make; ?>">
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label" >*IMEI#: </label>
								<div class="controls">													
									<input  type="text" name="txtimei" id="txtimei" class="input-large" onkeyup="checkInput(this)" placeholder="Please use Numerics only" value="<?php echo $imei; ?>">
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Password: </label>
								<div class="controls">
									<input  type="text" name="txtcpwd" id="txtcpwd" class="input-large" value="<?php echo $password; ?>">
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Notable Defects: </label>
								<div class="controls">
									<input  type="text" name="txtdefects" id="txtdefects" class="input-large" value="<?php echo $defects; ?>" >
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Network: </label>
								<div class="controls">
									<input  type="text" name="txtnetwork" id="txtnetwork" class="input-large" value="<?php echo $network; ?>">
								</div>
							</div>									
							<div class="control-group">							
								<label class="control-label" >Retailer: </label>
								<div class="controls">
									<input type="text" name="txtrecby" id="txtrecby" class="input-large" value="<?php echo $enteredby; ?>">
								</div>
							</div>	
							<div class="control-group">		
								<label class="control-label" >Accessories:&nbsp;&nbsp;&nbsp;</label>
								<div class="controls">
									<textarea name="txtaccess" id="txtaccess" class="input-large" style="height:70px;"><?php echo $access; ?></textarea>									
								</div>
							</div>
							<!--<div class="control-group">							
								<label class="control-label" >Ref Id: </label>
								<div class="controls">
									<input type="text" name="txtrefid" id="txtrefid" class="input-large" value="<?php echo $refid; ?>">
								</div>
							</div>-->
							<input type="hidden"  name="txtpid" id="txtpid" value="<?php echo $purchaseid; ?>" >																		
						</form>		
							<!--
							<div class="control-group">							
								<label class="control-label" >Notes: </label>
								<div class="controls">
									<textarea  name="txtnotes" id="txtnotes" class="input-large" style="height:70px;" placeholder="Please dont use slashes or quotes while entring notes"></textarea>
								</div>
							</div>												
							-->							
						</div>
						<div class="span12 offset1">
							<div class="control-group">	
								<?php if (isset($filename)) { ?>
									Identification:&nbsp;&nbsp;<img src="documents/<?php echo $filename;?>" style="width:200px;height:55px;">								
								<?php } else {  ?>	
									Identification:&nbsp;&nbsp;<img src="images/noimage.jpg" style="width:200px;height:55px;">								
								<?php } ?>		
							</div>	
						</div>		
						<div class="row-fluid">
							<div class="span12 page_top_header line-divider" style="margin-bottom:5px;"></div>
						</div>	
						<div class="row-fluid">
									<p><b>Phone Verification</b></p>
									<?php $i = 1;
										if (!empty($cbchecks)) {
											foreach($checks as $check) { 
												if ($i % 4 == 0)  
													echo '</div><div class="row">';	
												else	
													echo '</div><div class="span3">';
												if (in_array($check,$cbchecks)) { ?>													
													<div class="control-group checkbox">
														<input name="checks" type="checkbox" value="<?php echo $check; ?>" checked="checked"> <?php echo $check; ?>
													</div>	
												<?php } else { ?>
													<div class="control-group checkbox">
														<input name="checks" type="checkbox" value="<?php echo $check; ?>"> <?php echo $check; ?>
													</div>	
												
											<?php } 
										$i++; } 
										} else { 
											echo "No verification is done";
										} ?>	
										</div>
								</div>								
								<div class="span8" style="font-size:12px;">									
									<p><b>Customer Signatures: <img src="documents/<?php echo $signame;?>" ></b> </p>
								</div>								
							</div>	
						</div>
						<div class="row-fluid">
							<div class="span12 page_top_header line-divider" style="margin:5px;"></div>
						</div>
						
						<div class="row-fluid">
							<div class="control-group">							
								<a href="javascript:validatepurchaseForm();"  class="button_bar" name="btnsave" id="btnsave" style="margin-top:10px;margin-left:45%;">Save</a>								
							</div>
						</div>	
						
					</div>							
				</div>  
			</div>    				
		</div>
	</div>
</div>		
<footer>
   <?php
		include_once($path."footer.php");                
	?>
</footer>

</body>
</html>

<script type="text/javascript">	
	
	function checkInput(ob) {
		var invalidChars = /[^0-9]/gi
		if(invalidChars.test(ob.value)) {
            ob.value = ob.value.replace(invalidChars,"");
		}
	}
	
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
	
		
	if (success == 1) {	
		var docForm = document.getElementById('upurchaseform');  
		var serializedData = new FormData(docForm);  	
		
		$.ajax({
			type:'POST',
			url: "updatepurchase_controller.php",
			data:serializedData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(data){
			if (data > 0 )	{		
				alert ("Data is saved successfully!");
				window.location = 'inventory.php';
				//location.reload(); 
			}
		   else				
				alert ("Data could not be saved!");	
			}
		});
			
	}
	
	
	
}	
</script>
