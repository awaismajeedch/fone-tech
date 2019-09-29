<!DOCTYPE html>

<?php
	error_reporting(0);
	$mainCat = "Repsheet";	
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
	@media print 
    {
    	@page
    	{
    		size: 8.27in 11.69in;
    		size: portrait;
    	}
    }
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
		$pwd  = $row['password'];
		$customername  = $row['customer_name'];
		$contact  = $row['contact_number'];
		$exreturn  = $row['exreturn'];
		$defects  = $row['defects'];
		$address  = $row['sparephone'];
		$network  = $row['network'];
		$price  = $row['price'];
		$deposit  = $row['deposit'];
		$sigimage  = $row['signimage'];
		$recby  = $row['entered_by'];
		$modiby  = $row['modified_by'];
		$modiat  = $row['modified_at'];
		$notes  = $row['notes'];
		$balance = $price - $deposit;
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
	$missql = "SELECT * FROM misc WHERE itemid = $invoice AND (type='accessories' OR type='other')";	
	$misdata = $db->selectQuery($missql);	
	foreach ((array)$misdata as $msrow) {
		$access = $msrow['value']. "," .$access;
	}
	$access = trim ($access,",");
	
	$imgpath = $_SERVER['DOCUMENT_ROOT']."/fone-worlduk.com/documents/".$sigimage; 
	
	//Before
		$tablename="misc";
		$orderby = "";
		$where= "itemid=$invoice AND type='Before'";
		$datab = $db->select($tablename,$orderby, $where);
		if (!empty($datab)) {
			foreach ($datab as $bcrow) {	
				if ($bcrow['value'] == 'bedata')
					$bdata = $bcrow['value'];
				if ($bcrow['value'] == 'bbackcamera')
					$bbackcamera = $bcrow['value'];
				if ($bcrow['value'] == 'bfrontcamera')
					$bfrontcamera = 	$bcrow['value'];
				if ($bcrow['value'] == 'bearpiece')
					$bearpiece =  $bcrow['value'];		
				if ($bcrow['value'] == 'bbuttons')
					$bbuttons =  $bcrow['value'];	
				if ($bcrow['value'] == 'bchargingport')
					$bchargingport =  $bcrow['value'];		
				if ($bcrow['value'] == 'bmic')
					$bmic =  $bcrow['value'];		 		
				if ($bcrow['value'] == 'bwifi')
					$bwifi =  $bcrow['value'];		 		
				if ($bcrow['value'] == 'bsignal')
					$bsignal =  $bcrow['value'];	 		
				if ($bcrow['value'] == 'bringer')
					$bringer =  $bcrow['value'];			
				if ($bcrow['value'] == 'btouch')
					$btouch =  $bcrow['value'];			
				if ($bcrow['value'] == 'blcd')
					$blcd =  $bcrow['value'];				
				if ($bcrow['value'] == 'bsensor')
					$bsensor =  $bcrow['value'];		
				if ($bcrow['value'] == 'bheadphones')
					$bheadphones =  $bcrow['value'];	 		
				if ($bcrow['value'] == 'bloudspeakers')
					$bloudspeakers =  $bcrow['value'];	 		
				if ($bcrow['value'] == 'brepairedbefore')
					$brepairedbefore =  $bcrow['value'];
				
			}
		}
		
		//After
		$tablename="misc";
		$orderby = "";
		$where= "itemid=$invoice AND type='After'";
		$dataf = $db->select($tablename,$orderby, $where);
		if (!empty($dataf)) {
			foreach ($dataf as $fcrow) {	
				if ($fcrow['value'] == 'adata')
					$adata = $fcrow['value'];
				if ($fcrow['value'] == 'abackcamera')
					$abackcamera = $fcrow['value'];
				if ($fcrow['value'] == 'afrontcamera')
					$afrontcamera = 	$fcrow['value'];
				if ($fcrow['value'] == 'aearpiece')
					$aearpiece =  $fcrow['value'];		
				if ($fcrow['value'] == 'abuttons')
					$abuttons =  $fcrow['value'];	
				if ($fcrow['value'] == 'achargingport')
					$achargingport =  $fcrow['value'];		
				if ($fcrow['value'] == 'amic')
					$amic =  $fcrow['value'];		 		
				if ($fcrow['value'] == 'awifi')
					$awifi =  $fcrow['value'];		 		
				if ($fcrow['value'] == 'asignal')
					$asignal =  $fcrow['value'];	 		
				if ($fcrow['value'] == 'aringer')
					$aringer =  $fcrow['value'];			
				if ($fcrow['value'] == 'atouch')
					$atouch =  $fcrow['value'];			
				if ($fcrow['value'] == 'alcd')
					$alcd =  $fcrow['value'];				
				if ($fcrow['value'] == 'asensor')
					$asensor =  $fcrow['value'];		
				if ($fcrow['value'] == 'aheadphones')
					$aheadphones =  $fcrow['value'];	 		
				if ($fcrow['value'] == 'aloudspeakers')
					$aloudspeakers =  $fcrow['value'];	 		
				if ($fcrow['value'] == 'arepairedbefore')
					$arepairedbefore =  $fcrow['value'];
				
			}
		}

	
?>   
<body>
<div id="printdiv">
<page>
		<div style="text-align: center;">
			<h1 style="line-height:5px;">Repair Invoice</h1>				
		</div>			
		<div style="text-align: center;">			
			<?php echo $comadd;?>
		</div>	
		<div style="text-align: center;">			
			Contact#: <?php echo $shcontact;?>,  Email: <?php echo $shemail;?>
		</div>
		<hr>
		<div style="width: 100%;">
			<div style="float: left; width: 30%;font-size:14px;">
				<b>Invoice #: <?php echo $invoice;?></b>
			</div>	
			<div style="float: left; width: 20%;"><b>Exp. Return: <?php echo $exreturn;?></b></div>
			<div style="float: right; width: 40%;"><b>Date : <?php echo $edate;?></b></div>
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
				<b>Sparephone: <?php echo $address;?></b>
			</div>
			<br style="clear: left;" />
		</div>	
		<div style="width: 100%;">
			<div style="float: left; width: 30%;">
				<b>Password : <?php echo $pwd;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>Make : <?php echo $make;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>IMEI: <?php echo $imei;?></b> 
			</div>			
		</div>	
		<div style="width: 100%;">
			<div style="float: left; width: 30%;">
				<b>Charges : <?php echo $price;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>Deposit: <?php echo $deposit;?></b>
			</div>
			
			<div style="float: left; width: 30%;">
				<b>Balance: <?php echo $balance;?></b>
			</div>
			<br style="clear: left;" />
		</div>
		<div style="width: 100%;">
			<div style="float: left; width: 30%;">
				<b>Network : <?php echo $network;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>Defects: <?php echo $defects;?></b>
			</div>
			
			<div style="float: left; width: 30%;">
				<b>Notes: <?php echo $notes;?></b>
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
		<div style="width: 100%;">
			<div style="float: left;width: 30%;">
			<table class="table table-striped table-hover table-bordered" id="data-table">										
					<thead>
						<tr>						
							<th>Fault CheckList</th>
							<th>&nbsp; Before</th>
							<th>&nbsp; After</th>	
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								Data:
							</td>
							<td>														
								<input type="checkbox" name="checks" id="chkbdata" <?php if (isset($bdata)) echo "checked='checked'";?> disabled value="bedata">
							</td>
							<td>														
								<input type="checkbox" name="achecks" id="chkadata" <?php if (isset($adata)) echo "checked='checked'";?> disabled value="adata">
							</td>
						</tr>
						<tr>
							<td>
								Back Camera:
							</td>
							<td>
								<input type="checkbox" name="checks" id="chkbbackcamera" <?php if (isset($bbackcamera)) echo "checked='checked'";?> disabled value="bbackcamera">
							</td>
							<td>
								<input type="checkbox" name="achecks" id="chkabackcamera" <?php if (isset($abackcamera)) echo "checked='checked'";?> disabled value="abackcamera">
							</td>
						</tr>
						<tr>
							<td>
								Front Camera:
							</td>
							<td>		
								<input type="checkbox" name="checks" id="chkbfrontcamera" <?php if (isset($bfrontcamera)) echo "checked='checked'";?> disabled value="bfrontcamera">
							</td>
							<td>		
								<input type="checkbox" name="achecks" id="chkafrontcamera" <?php if (isset($afrontcamera)) echo "checked='checked'";?> disabled value="afrontcamera">
							</td>
						</tr>
						<tr>
							<td>
								Ear Piece:
							</td>
							<td>	
								<input type="checkbox" name="checks" id="chkbearpiece" <?php if (isset($bearpiece)) echo "checked='checked'";?> disabled value="bearpiece">													
							</td>
							<td>	
								<input type="checkbox" name="achecks" id="chkaearpiece" <?php if (isset($aearpiece)) echo "checked='checked'"?> disabled value="aearpiece">													
							</td>
						</tr>
						<tr>
							<td>
								Buttons:
							</td>
							<td>
								<input type="checkbox" name="checks" id="chkbbuttons" <?php if (isset($bbuttons)) echo "checked='checked'";?> disabled value="bbuttons">													
							</td>
							<td>
								<input type="checkbox" name="achecks" id="chkabuttons" <?php if (isset($abuttons)) echo "checked='checked'"?> disabled value="abuttons">													
							</td>
						</tr>
						<tr>
							<td>
								Charging Port:
							</td>
							<td>														
								<input type="checkbox" name="checks" id="chkbchargingport" <?php if (isset($bchargingport)) echo "checked='checked'";?> disabled value="bchargingport">													
							</td>
							<td>	
								<input type="checkbox" name="achecks" id="chkachargingport" <?php if (isset($achargingport)) echo "checked='checked'"?> disabled value="achargingport">													
							</td>
						</tr>
						<tr>
							<td>
								Mic:
							</td>
							<td>
								<input type="checkbox" name="checks" id="chkbmic" <?php if (isset($bmic)) echo "checked='checked'";?> disabled value="bmic">													
							</td>
							<td>
								<input type="checkbox" name="achecks" id="chkamic" <?php if (isset($amic)) echo "checked='checked'"?> disabled value="amic">													
							</td>
						</tr>
						<tr>
							<td>
								Wifi:
							</td>
							<td>
								<input type="checkbox" name="checks" id="chkbwifi" <?php if (isset($bwifi)) echo "checked='checked'";?> disabled value="bwifi">													
							</td>
							<td>	
								<input type="checkbox" name="achecks" id="chkawifi" <?php if (isset($awifi)) echo "checked='checked'"?> disabled value="awifi">													
							</td>
						</tr>
						<tr>
							<td>
								Signals & Calling:
							</td>
							<td>	
								<input type="checkbox" name="checks" id="chkbsignal" <?php if (isset($bsignal)) echo "checked='checked'";?> disabled value="bsignal">
							</td>
							<td>		
								<input type="checkbox" name="achecks" id="chkasignal" <?php if (isset($asignal)) echo "checked='checked'"?> disabled value="asignal">
							</td>
						</tr>
						<tr>
							<td>
								Ringer & Music:
							</td>
							<td>
								<input type="checkbox" name="checks" id="chkbringer" <?php if (isset($bringer)) echo "checked='checked'";?> disabled value="bringer">													
							</td>
							<td>
								<input type="checkbox" name="achecks" id="chkaringer" <?php if (isset($aringer)) echo "checked='checked'"?> disabled value="aringer">													
							</td>
						</tr>
						<tr>
							<td>
								Touch:
							</td>
							<td>
								<input type="checkbox" name="checks" id="chkbtouch" <?php if (isset($btouch)) echo "checked='checked'";?> disabled value="btouch">													
							</td>
							<td>
								<input type="checkbox" name="achecks" id="chkatouch" <?php if (isset($atouch)) echo "checked='checked'"?> disabled value="atouch">													
							</td>
						</tr>
						<tr>
							<td>
								LCD:
							</td>
							<td>
								<input type="checkbox" name="checks" id="chkblcd" <?php if (isset($blcd)) echo "checked='checked'";?> disabled value="blcd">													
							</td>
							<td>
								<input type="checkbox" name="achecks" id="chkalcd" <?php if (isset($alcd)) echo "checked='checked'"?> disabled value="alcd">													
							</td>
						</tr>
						<tr>
							<td>
								Sensor:
							</td>
							<td>
								<input type="checkbox" name="checks" id="chkbsensor" <?php if (isset($bsensor)) echo "checked='checked'";?> disabled value="bsensor">													
							</td>
							<td>
								<input type="checkbox" name="achecks" id="chkasensor" <?php if (isset($asensor)) echo "checked='checked'"?> disabled value="asensor">
							</td>
						</tr>
						<tr>
							<td>
								HeadPhones:
							</td>
							<td>
								<input type="checkbox" name="checks" id="chkbheadphones" <?php if (isset($bheadphones)) echo "checked='checked'";?> disabled value="bheadphones">													
							</td>
							<td>
								<input type="checkbox" name="achecks" id="chkaheadphones" <?php if (isset($aheadphones)) echo "checked='checked'"?> disabled value="aheadphones">
							</td>
						</tr>
						<tr>
							<td>
								Loud Speakers:
							</td>
							<td>
								<input type="checkbox" name="checks" id="chkbloudspeakers" <?php if (isset($bloudspeakers)) echo "checked='checked'";?> disabled value="bloudspeakers">												
							</td>
							<td>
								<input type="checkbox" name="achecks" id="chkaloudspeakers" <?php if (isset($aloudspeakers)) echo "checked='checked'"?> disabled value="aloudspeakers">													
							</td>
						</tr>
						<tr>
							<td>
								Repaired Before:
							</td>
							<td>
								<input type="checkbox" name="checks" id="chkbrepairedbefore" <?php if (isset($brepairedbefore)) echo "checked='checked'";?> disabled value="brepairedbefore">													
							</td>
							<td>
								<input type="checkbox" name="achecks" id="chkarepairedbefore" <?php if (isset($arepairedbefore)) echo "checked='checked'"?> disabled value="arepairedbefore">													
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="float: left;width: 70%;">
				<table class="table table-striped table-hover table-bordered" id="data-table">
				<tbody>
						<tr><td>1) All parts used during repair will be replacement parts not from original brand.</td></tr>
						<tr><td>2) Please take out any SIM and memory cards. We cannot accept any responsibility or liability for these.</td></tr>
						<tr><td>3) We don't do any refund at all for any kind of repairs. If after repairing issue still exist. We will try to re fix it or offer only credit note which will be valid for six months these rules will not affect your statutory rights. </td></tr>
						<tr><td>4) In Touch & LCD repair company only guarantee for colour pixels or if touch not working, There is no refund or exchange for broken LCD or Touch screens. </td></tr>
						<tr><td>5) Any repair done by us will be covered by our 30 days warranty if the same fault occurs. But this warranty will not cover any accident damage of Touch & LCD screens.</td></tr>
						<tr><td>6) We only repair the fault that your phone came in for, if we repair the phone & on testing we notice it has additional faults, you will be quoted separately for those faults. </td></tr>
						<tr><td>7) Any phone which is coming back for refix, during refix if we found an additional fault with your phone, you will be quoted separately for those faults. </td></tr>
						<tr><td>8) If we successfully unlock or repair your phone & phone turns out to be barred the quoted repair price will still stand. </td></tr>
						<tr><td>9) Please indicate if the data on your phone is important & you would like us to try our best to save it. However we cannot guarantee your data or settings on the phone will be saved during our repairs or unlocking. </td></tr>
						<tr><td>10) Our repairs will void your phone warranty. Please check you are happy with this before you hand over your phone. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</tr></td>
				</tbody>
				</table>
				<!--
				<p><b>
				1) All parts used during repair will be replacement parts not from original brand.
				</b></p><p><b>
				2) Please take out any SIM and memory cards. We cannot accept any responsibility or liability for these.
				</p><p><b>
				3) We don't do any refund at all for any kind of repairs. If after repairing issue still exist. We will try to re fix it or offer only credit note which will be valid for six months these rules will not affect your statutory rights. 
				</b></p><p><b>
				4) In Touch & LCD repair company only guarantee for colour pixels or if touch not working, There is no refund or exchange for broken LCD or Touch screens. 
				</b></p><p><b>
				5) Any repair done by us will be covered by our 30 days warranty if the same fault occurs. But this warranty will not cover any accident damage of Touch & LCD screens. 
				</p><p><b>
				6) We only repair the fault that your phone came in for, if we repair the phone & on testing we notice it has additional faults, you will be quoted separately for those faults. 
				</b></p><p><b>
				7) Any phone which is coming back for refix, during refix if we found an additional fault with your phone, you will be quoted separately for those faults. 
				</b></p><p><b>
				8) If we successfully unlock or repair your phone & phone turns out to be barred the quoted repair price will still stand. 
				</b></p><p><b>
				9) Please indicate if the data on your phone is important & you would like us to try our best to save it. However we cannot guarantee your data or settings on the phone will be saved during our repairs or unlocking. 
				</b></p><p><b>
				10) Our repairs will void your phone warranty. Please check you are happy with this before you hand over your phone. 
				</b></p>-->	
			</div>	
		</div>
		<div style="float: left; width: 100%;">
			<div style="float: left;width: 100%;">
				<p>Signatures: <img src="documents/<?php echo $sigimage;?>" style="width:200px;height:55px;"> &nbsp;
				<b>Received By : <?php echo $recby;?></b> &nbsp;&nbsp;&nbsp;&nbsp;<b>Printed On : <?php echo $edate;?></b>
				<?php if (!empty($modiby)) {?>
				<b>Modified on : <?php echo $modiat;?></b> &nbsp;&nbsp;<b>Modified by : <?php echo $modiby;?></b></p>
				<?php } ?></p>
			</div>	
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
							<input type="hidden"  name="txtrepid" id="txtrepid" value="<?php echo $pid;?>" >
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
						
			$.post("repsheetmail.php",serializedData,function(data){
			   //alert(data);
			   if (data > 0 ) {							
					alert ("Email is sent successfully!");
					$('#modal-semail').modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();					
				} else {
					//alert(data);
					alert ("Email could not be sent!");			
				}		
			  
			});
			
		}	
	}	
	
</script>	
