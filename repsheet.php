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
	<title>FoneWorld</title>
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
	require_once 'include/conn.php';
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

	$dt = new DateTime("now", new DateTimeZone('Europe/London'));
	//print_r ($dt);
	$edate = $dt->format('d/m/Y H:i');	
	$invnos = $db->getInvoiceNo();
	
	$repinvid = $_GET['invno'];
	if (!empty($repinvid)) {
	
		$tablename="repsheet";
		$orderby = " ORDER BY created_at ASC";
		$where= "Invoice=$repinvid";
		$datas = $db->select($tablename,$orderby, $where);	
	
		foreach ($datas as $srow) {	
			$repshid = $srow['id'];
			$make  = $srow['make'];
			$imei  = $srow['imei'];
			$cstname  = $srow['customer_name'];
			$pass  = $srow['password'];
			$cnum =  $srow['contact_number'];
			$defects  =  $srow['defects'];
			$spare  =  $srow['sparephone'];
			$network  = $srow['network'];
			$price  = $srow['price'];
			$deposit  = $srow['deposit'];
			$exreturn  = $srow['exreturn']; 
			$recby  =  $srow['entered_by'];
			$endate  =  $srow['date_entered'];	
			$notes   = $srow['notes'];
			$refix   = $srow['refix'];
			$sigimage  =  $srow['signimage'];
			$balance = $price - $deposit;
		}
		//Accessories
		$tablename="misc";
		$orderby = "";
		$where= "itemid=$repinvid AND type='accessories'";
		$datac = $db->select($tablename,$orderby, $where);
		if (!empty($datac)) {
			foreach ($datac as $acrow) {	
				if ($acrow['value'] == 'Battery')
					$battery = $acrow['value'];
				if ($acrow['value'] == 'Sim')
					$sim = $acrow['value'];
				if ($acrow['value'] == 'Memory')
					$memory = $acrow['value'];
				if ($acrow['value'] == 'Cover')
					$cover = $acrow['value'];
				if ($acrow['value'] == 'Other')
					$other = $acrow['value'];
			}
			$othervalue = $mysqli->query("SELECT value AS othervalue from misc where itemid=$repinvid AND type='other'")->fetch_object()->othervalue;
		}
		
		//Before
		$tablename="misc";
		$orderby = "";
		$where= "itemid=$repinvid AND type='Before'";
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
		$where= "itemid=$repinvid AND type='After'";
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
		
		$repairsid = $mysqli->query("SELECT id AS reprid from repairs where invoice=$repinvid")->fetch_object()->reprid;
		
	}
	
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
				<ul class="nav nav-tabs">									
					<li class="active">
						<a href="#tab_rdesc" data-toggle="tab">
						Repair Sheet </a>
					</li>
					<li >
						<a href="#tab_rlist" onclick="javascript:refreshMe();" data-toggle="tab">
						Repairs Listing</a>
					</li>	
				</ul>
				<div class="tab-content">					
					<div class="tab-pane active" id="tab_rdesc">	
						<div class="row-fluid">
							<form class="form-horizontal" id="RepSheetform"  name="RepSheetform" method="post" enctype="multipart/form-data" >	
							<div class="span12 discover">																			
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
											
											<?php if (isset($repinvid)) {?>
											<input  type="text" name="txtinvoice" id="txtinvoice" class="input-large" value="<?php echo $repinvid; ?>" readonly>
										<?php } else {?>
											<input  type="text" name="txtinvoice" id="txtinvoice" class="input-large" value="<?php echo $invnos; ?>" readonly>
										<?php } ?>
										</div>
									</div>		
									<!--<div class="control-group">							
										<label class="control-label" >*Model: </label>
										<div class="controls">
											<input  type="text" name="txtmodel" id="txtmodel" class="input-large" >
										</div>
									</div>-->
									<div class="control-group">							
										<label class="control-label" >Network: </label>
										<div class="controls">
										<?php if (isset($repinvid)) {?>
											<input  type="text" name="txtnetwork" id="txtnetwork" class="input-large" value="<?php echo $network; ?>" readonly>
										<?php } else {?>
											<input  type="text" name="txtnetwork" id="txtnetwork" class="input-large" >
										<?php } ?>
										</div>
									</div>
									<div class="control-group">							
										<label class="control-label" >*Customer Name: </label>
										<div class="controls">											
										<?php if (isset($repinvid)) {?>
											<input  type="text" name="txtcsname" id="txtcsname" class="input-large" value="<?php echo $cstname; ?>" readonly>
										<?php } else {?>
											<input  type="text" name="txtcsname" id="txtcsname" class="input-large" >
										<?php } ?>
										</div>
									</div>	
									
									<!--
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
									</div>	-->
									<div class="control-group">							
										<label class="control-label" >Spare Phone: </label>
										<div class="controls">											
											<?php if (isset($repinvid)) {?>
												<input  type="text" name="txtsphone" id="txtsphone" class="input-large" value="<?php echo $spare; ?>" readonly>
											<?php } else { ?>
												<input  type="text" name="txtsphone" id="txtsphone" class="input-large" >
											<?php } ?>
										</div>
									</div>	
									<div class="control-group">							
										<label class="control-label" >*Entered By: </label>
										<div class="controls">
											<?php if (isset($repinvid)) {?>
												<input  type="text" name="txtrecby" id="txtrecby" class="input-large" value="<?php echo $recby; ?>" readonly>
											<?php } else { ?>
												<input  type="text" name="txtrecby" id="txtrecby" class="input-large" >
											<?php } ?>
										</div>
									</div>
									<div class="control-group">							
										<label class="control-label" >Notes: </label>
										<div class="controls">
										<textarea  name="txtnotes" id="txtnotes" class="input-large"  style="height:45px;"><?php echo $notes;?></textarea>
										<!--// if (isset($repinvid)) {?>
											<textarea  name="txtnotes" id="txtnotes" class="input-large" disabled style="height:45px;"><?php echo $notes;?></textarea>
										 //} else { ?>
											<textarea  name="txtnotes" id="txtnotes" class="input-large" style="height:45px;"></textarea>
										//} ?>-->
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label" >Send to Lab: </label>
										<div class="controls" style="margin-top:3px; font-size:20px;">													
											<input type="radio" value="yes" id="radmake" name="radmake" 
											<?php if (isset($repairsid)) echo "checked='checked'"; if (isset($repairsid)) echo "disabled='disabled'";?>
											onclick ="javascript:setrad('yes');"> Yes
											<!--<input  type="text" name="txtmake" id="txtmake" class="input-large" >-->
											&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="no" id="radmake" name="radmake" 
											<?php if (isset($repairsid)) {echo "disabled='disabled'";} else {echo "checked='checked'";}?>
											onclick ="javascript:setradn('no');"> No
											<input type="hidden" id="txtlabsend" name="txtlabsend" value="">
										</div>
									</div>	
									
								</div>
								<div class="span5">	
									<div class="control-group">							
										<label class="control-label" >Date: </label>
										<div class="controls">												
											<?php if (isset($repinvid)) {?>
												<input  type="text" name="txtdate" id="txtdate" class="input-large" value="<?php echo $endate; ?>" readonly>
											<?php } else { ?>
												<input  type="text"  name="txtdate" id="txtdate" class="input-large" value="<?php echo $edate;?>" disabled />
											<?php } ?>
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label" >*Make & Model: </label>
										<div class="controls">													
											<?php if (isset($repinvid)) {?>
												<input  type="text" name="txtmake" id="txtmake" class="input-large" value="<?php echo $make; ?>" readonly>
											<?php } else { ?>
												<input  type="text"  name="txtmake" id="txtmake" class="input-large" />
											<?php } ?>
										</div>
									</div>	
									<div class="control-group">							
										<label class="control-label" >Faults: </label>
										<div class="controls">
											
											<?php if (isset($repinvid)) {?>
												<input  type="text" name="txtdefects" id="txtdefects" class="input-large" value="<?php echo $defects; ?>" readonly>
											<?php } else { ?>
												<input  type="text"  name="txtdefects" id="txtdefects" class="input-large" />
											<?php } ?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" >IMEI#: </label>
										<div class="controls">													
											<?php if (isset($repinvid)) {?>
												<input  type="text" name="txtimei" id="txtimei" class="input-large" value="<?php echo $imei; ?>" readonly>
											<?php } else { ?>
												<input  type="text"  name="txtimei" id="txtimei" class="input-large" onkeyup="checkInput(this)" placeholder="Please use Numerics only" >
											<?php } ?>
										</div>
									</div>
									<div class="control-group">							
										<label class="control-label" >*Password: </label>
										<div class="controls">
											
											<?php if (isset($repinvid)) {?>
												<input  type="text" name="txtcpwd" id="txtcpwd" class="input-large" value="<?php echo $pass; ?>" readonly>
											<?php } else { ?>
												<input  type="text"  name="txtcpwd" id="txtcpwd" class="input-large" />
											<?php } ?>
										</div>
									</div>	
									<div class="control-group">							
										<label class="control-label" >Contact Number: </label>
										<div class="controls">
											<?php if (isset($repinvid)) {?>
												<input  type="text" name="txtcsno" id="txtcsno" class="input-large" value="<?php echo $cnum; ?>" readonly>
											<?php } else { ?>
												<input  type="text"  name="txtcsno" id="txtcsno" class="input-large" />
											<?php } ?>
										</div>
									</div>	
										
									<div class="control-group">							
										<label class="control-label" >Exp. Return: </label>
										<div class="controls">
											<?php if (isset($repinvid)) { ?>
												<input  type="text" name="txtexreturn" id="txtexreturn" class="input-large" value="<?php echo $exreturn; ?>" readonly>
											<?php } else { ?>
												<div class="input-append date" name="edate" id="edate" data-date="" data-date-format="dd/mm/yyyy" >
												<input  size="10" type="text" name="txtexreturn" id="txtexreturn" value="" >
												<span class="add-on"><i class="icon-calendar"></i></span>											
												</div>
											<?php } ?>
																									
										</div>
									</div>	
									<div class="control-group" id= "divlab" style="display:none;">
										<label class="control-label" >Lab Name: </label>
										<div class="controls">													
											<input  type="text" name="txtlabname" id="txtlabname" class="input-large" value="<?php echo $labname; ?>" disabled />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" >Refix: </label>
										<div class="controls" style="margin-top:3px; font-size:20px;">													
											<input type="radio" value="yes" id="remake" name="remake" 
											<?php if ((isset($refix)) && $refix == 'yes' ) echo "checked='checked'";?>
											onclick ="javascript:setrfix('yes');"> Yes
											<!--<input  type="text" name="txtmake" id="txtmake" class="input-large" >-->
											&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="no" id="remake" name="remake" 
											<?php if ((isset($refix)) && $refix == 'no' ) echo "checked='checked'";?>
											onclick ="javascript:setrfix('no');"> No
											<input type="hidden" id="txtrfix" name="txtrfix" value="">
										</div>
									</div>	
								</div>						
								<div class="span11">	
									<div class="span2">
										<div class="control-group">		
											<label class="control-label" >Accessories:&nbsp;&nbsp;&nbsp; </label>
										</div>	
									</div>
									<div class="span9">										
										<label class="checkbox inline">
										
										  <input type="checkbox" name="access" id="chkbattery" 
											<?php if (isset($battery)) echo "checked='checked'"; if (isset($repinvid)) echo "disabled='disabled'";?>
										  value="Battery" > Battery
										</label>
										<label class="checkbox inline">
										  <input type="checkbox" name="access" id="chksim" 
											<?php if (isset($sim)) echo "checked='checked'"; if (isset($repinvid)) echo "disabled='disabled'";?>
										  value="Sim"> Sim Card
										</label>
										<label class="checkbox inline">
										  <input type="checkbox" name="access" id="chkmemory" 
											<?php if (isset($memory)) echo "checked='checked'"; if (isset($repinvid)) echo "disabled='disabled'";?>
										  value="Memory"> Memory Card
										</label>
										<label class="checkbox inline">
										  <input type="checkbox" name="access" id="chkcover" 
											<?php if (isset($cover)) echo "checked='checked'"; if (isset($repinvid)) echo "disabled='disabled'";?>
										  value="Cover"> Cover
										</label>
										<label class="checkbox inline">
										  <input type="checkbox" name="access" id="chkhother" 
											<?php if (isset($other)) echo "checked='checked'"; if (isset($repinvid)) echo "disabled='disabled'";?>
										  value="Other"> Other	&nbsp;&nbsp;&nbsp;								 									  								
										</label>
										  <span>
											
											<?php if (isset($repinvid)) {?>
												<input  type="text" name="txtother" id="txtother" class="input-medium" value="<?php echo $othervalue; ?>" readonly>
											<?php } else { ?>
												<input  type="text"  name="txtother" id="txtother" class="input-medium" />
											<?php } ?>
										  </span>	
										  <input type="hidden" name="txtaccess"	id="txtaccess" />	
									</div>
								</div>
								<div class="span10">	
									<div class="span3">
										<div class="control-group">
											<label class="control-label" >Charges: </label>
											<div class="controls">													
												<input  type="text" name="txtprice" id="txtprice" class="input-small"  value="<?php echo $price;?>" onblur="CalculateBal();">
											</div>
										</div>
									</div>
									<div class="span3 offset1">
										<div class="control-group">
											<label class="control-label" >Deposit: </label>
											<div class="controls">													
												<input  type="text" name="txtdeposit" id="txtdeposit" class="input-small" value="<?php echo $deposit;?>" onblur="CalculateBal();">
											</div>
										</div>
									</div>
									<div class="span2 offset1">
										<div class="control-group">
											<label class="control-label" >Balance: </label>
											<div class="controls">													
												<input  type="text" name="txtbalance" id="txtbalance" value="<?php echo $balance;?>" class="input-small" readonly>
											</div>
										</div>
									</div>
								</div>					
									
								<div class="row-fluid">
									<div class="span12 page_top_header line-divider" style="margin-bottom:5px;"></div>
								</div>
								<div class="row-fluid">
									<div class="span4" >
										<table class="table table-striped table-hover table-bordered" id="data-table">										
											<thead>
												<tr>						
													<th>Fault CheckList</th>
													<th>
														<?php if (isset($repinvid)) {?>
														<input type="checkbox" name="chkbefore" id="chkbefore" disabled >
														<?php } else {?>
														<input type="checkbox" name="chkbefore" id="chkbefore" onClick="selectAllBefore(this,'checks')" >
														<?php } ?>
														
														&nbsp; Before</th>
													<th><input type="checkbox" name="chkafter" id="chkafter" onClick="selectAllAfter(this,'achecks')">&nbsp; After</th>	
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<b>Data:</b>
													</td>
													<td>														
														<input type="checkbox" name="checks" id="chkbdata" <?php if (isset($bdata)) echo "checked='checked' disabled='disabled'";?> value="bedata">
													</td>
													<td>														
														<input type="checkbox" name="achecks" id="chkadata" <?php if (isset($adata)) echo "checked='checked'";?> value="adata">
													</td>
												</tr>
												<tr>
													<td>
														<b>Back Camera:</b>
													</td>
													<td>
														<input type="checkbox" name="checks" id="chkbbackcamera" <?php if (isset($bbackcamera)) echo "checked='checked' disabled='disabled'";?> value="bbackcamera">
													</td>
													<td>
														<input type="checkbox" name="achecks" id="chkabackcamera" <?php if (isset($abackcamera)) echo "checked='checked'";?> value="abackcamera">
													</td>
												</tr>
												<tr>
													<td>
														<b>Front Camera:</b>
													</td>
													<td>		
														<input type="checkbox" name="checks" id="chkbfrontcamera" <?php if (isset($bfrontcamera)) echo "checked='checked' disabled='disabled'";?> value="bfrontcamera">
													</td>
													<td>		
														<input type="checkbox" name="achecks" id="chkafrontcamera" <?php if (isset($afrontcamera)) echo "checked='checked'";?> value="afrontcamera">
													</td>
												</tr>
												<tr>
													<td>
														<b>Ear Piece:</b>
													</td>
													<td>	
														<input type="checkbox" name="checks" id="chkbearpiece" <?php if (isset($bearpiece)) echo "checked='checked' disabled='disabled'";?> value="bearpiece">													
													</td>
													<td>	
														<input type="checkbox" name="achecks" id="chkaearpiece" <?php if (isset($aearpiece)) echo "checked='checked'"?> value="aearpiece">													
													</td>
												</tr>
												<tr>
													<td>
														<b>Buttons:</b>
													</td>
													<td>
														<input type="checkbox" name="checks" id="chkbbuttons" <?php if (isset($bbuttons)) echo "checked='checked' disabled='disabled'";?> value="bbuttons">													
													</td>
													<td>
														<input type="checkbox" name="achecks" id="chkabuttons" <?php if (isset($abuttons)) echo "checked='checked'"?> value="abuttons">													
													</td>
												</tr>
												<tr>
													<td>
														<b>Charging Port:</b>
													</td>
													<td>														
														<input type="checkbox" name="checks" id="chkbchargingport" <?php if (isset($bchargingport)) echo "checked='checked' disabled='disabled'";?> value="bchargingport">													
													</td>
													<td>	
														<input type="checkbox" name="achecks" id="chkachargingport" <?php if (isset($achargingport)) echo "checked='checked'"?> value="achargingport">													
													</td>
												</tr>
												<tr>
													<td>
														<b>Mic:</b>
													</td>
													<td>
														<input type="checkbox" name="checks" id="chkbmic" <?php if (isset($bmic)) echo "checked='checked' disabled='disabled'";?> value="bmic">													
													</td>
													<td>
														<input type="checkbox" name="achecks" id="chkamic" <?php if (isset($amic)) echo "checked='checked'"?> value="amic">													
													</td>
												</tr>
												<tr>
													<td>
														<b>Wifi:</b>
													</td>
													<td>
														<input type="checkbox" name="checks" id="chkbwifi" <?php if (isset($bwifi)) echo "checked='checked' disabled='disabled'";?> value="bwifi">													
													</td>
													<td>	
														<input type="checkbox" name="achecks" id="chkawifi" <?php if (isset($awifi)) echo "checked='checked'"?> value="awifi">													
													</td>
												</tr>
												<tr>
													<td>
														<b>Signals & Calling:</b>
													</td>
													<td>	
														<input type="checkbox" name="checks" id="chkbsignal" <?php if (isset($bsignal)) echo "checked='checked' disabled='disabled'";?> value="bsignal">
													</td>
													<td>		
														<input type="checkbox" name="achecks" id="chkasignal" <?php if (isset($asignal)) echo "checked='checked'"?> value="asignal">
													</td>
												</tr>
												<tr>
													<td>
														<b>Ringer & Music:</b>
													</td>
													<td>
														<input type="checkbox" name="checks" id="chkbringer" <?php if (isset($bringer)) echo "checked='checked' disabled='disabled'";?> value="bringer">													
													</td>
													<td>
														<input type="checkbox" name="achecks" id="chkaringer" <?php if (isset($aringer)) echo "checked='checked'"?> value="aringer">													
													</td>
												</tr>
												<tr>
													<td>
														<b>Touch:</b>
													</td>
													<td>
														<input type="checkbox" name="checks" id="chkbtouch" <?php if (isset($btouch)) echo "checked='checked' disabled='disabled'";?> value="btouch">													
													</td>
													<td>
														<input type="checkbox" name="achecks" id="chkatouch" <?php if (isset($atouch)) echo "checked='checked'"?> value="atouch">													
													</td>
												</tr>
												<tr>
													<td>
														<b>LCD:</b>
													</td>
													<td>
														<input type="checkbox" name="checks" id="chkblcd" <?php if (isset($blcd)) echo "checked='checked' disabled='disabled'";?> value="blcd">													
													</td>
													<td>
														<input type="checkbox" name="achecks" id="chkalcd" <?php if (isset($alcd)) echo "checked='checked'"?> value="alcd">													
													</td>
												</tr>
												<tr>
													<td>
														<b>Sensor:</b>
													</td>
													<td>
														<input type="checkbox" name="checks" id="chkbsensor" <?php if (isset($bsensor)) echo "checked='checked' disabled='disabled'";?> value="bsensor">													
													</td>
													<td>
														<input type="checkbox" name="achecks" id="chkasensor" <?php if (isset($asensor)) echo "checked='checked'"?> value="asensor">
													</td>
												</tr>
												<tr>
													<td>
														<b>HeadPhones:</b>
													</td>
													<td>
														<input type="checkbox" name="checks" id="chkbheadphones" <?php if (isset($bheadphones)) echo "checked='checked' disabled='disabled'";?> value="bheadphones">													
													</td>
													<td>
														<input type="checkbox" name="achecks" id="chkaheadphones" <?php if (isset($aheadphones)) echo "checked='checked'"?> value="aheadphones">
													</td>
												</tr>
												<tr>
													<td>
														<b>Loud Speakers:</b>
													</td>
													<td>
														<input type="checkbox" name="checks" id="chkbloudspeakers" <?php if (isset($bloudspeakers)) echo "checked='checked' disabled='disabled'";?> value="bloudspeakers">												
													</td>
													<td>
														<input type="checkbox" name="achecks" id="chkaloudspeakers" <?php if (isset($aloudspeakers)) echo "checked='checked'"?> value="aloudspeakers">													
													</td>
												</tr>
												<tr>
													<td>
														<b>Repaired Before:</b>
													</td>
													<td>
														<input type="checkbox" name="checks" id="chkbrepairedbefore" <?php if (isset($brepairedbefore)) echo "checked='checked' disabled='disabled'";?> value="brepairedbefore">													
													</td>
													<td>
														<input type="checkbox" name="achecks" id="chkarepairedbefore" <?php if (isset($arepairedbefore)) echo "checked='checked'"?> value="arepairedbefore">													
													</td>
												</tr>
											</tbody>
										</table>
										<input type="hidden" name="txtchecks"	id="txtchecks" />
										<input type="hidden" name="txtachecks"	id="txtachecks" />
									</div>
									<div class="span8" style="font-size:16px;">
										<table class="table table-bordered" id="data-table">										
											<thead>
												<tr>
													<p>
													<b>Dear Customer</b>
													</p>										
												</tr>
											</thead>
										</table>
										<p><b>
										1) All parts used during repair will be replacement parts not from original brand.
										</b></p><p><b>
										2) Please take out any SIM and memory cards. We cannot accept any responsibility or liability for these.
										</b></p><p><b>
										3) We don't do any refund at all for any kind of repairs. If after repairing issue still exist. We will try to re fix it or offer only credit note which will be valid for six months these rules will not affect your statutory rights. 
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
										<div class="span12 page_top_header line-divider" style="margin-bottom:5px;"></div>
										<h4>Customer's Declaration</h4>
										<div class="control-group checkbox">		
											<input type="checkbox" name="chkterms" id="chkterms" 
												<?php //if (isset($repinvid)) echo "checked='checked' disabled='disabled'"; ?>
											value="chkterms"> I confirm that I have read and understood the terms and conditions given above.
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
								</form>
								<input type="hidden"  name="txtid" id="txtid" value="" />	
								<input type="hidden"  name="txtmid" id="txtmid" >
								<input type="hidden"  name="txtshop" id="txtshop" value="<?php echo $shopid; ?>" >					
								<input type="hidden"  name="txtcreatedby" id="txtcreatedby" value="<?php echo $_SESSION['user_name']; ?>" >	
								<input type="hidden"  name="txtrepshid" id="txtrepshid" value="<?php echo $repshid; ?>" />
								<input type="hidden"  name="txtrepinvid" id="txtrepinvid" value="<?php echo $repinvid; ?>" />
								<input type="hidden"  name="txtlab" id="txtlab" value="<?php echo $lbid; ?>" >
								<input type="hidden"  name="txtrepairsid" id="txtrepairsid" value="<?php echo $repairsid; ?>" >
								<div class="row-fluid">
									<div class="control-group">							
										<a href="javascript:validateRepSheet();"  class="button_bar" name="btnsave" id="btnsave" style="margin-top:10px;margin-left:45%;">Save</a>
										
										<a href="javascript:printForm();"  class="button_bar" name="btnprint" id="btnprint" style="visibility:hidden;margin-top:10px;margin-left:5%;" >Print</a>																			
										<!--<a href="javascript:emailForm();"  class="button_bar" name="btnmail" id="btnmail" style="margin-left:5px;visibility:hidden;" >Email</a>-->
										<a data-toggle='modal' href='#modal-semail' class="button_bar" name="btnmail" id="btnmail" onclick="javascript:setId();" style="visibility:hidden;margin-top:10px;margin-left:5%">Email</a>
									</div>
								</div>	
								
							</div>							
						</div>  
					</div>
					
					<div class="tab-pane" id="tab_rlist">
						<?php
							include_once($pathaj."repsearch.php");
						?>	
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
							<input type="hidden"  name="txtrepids" id="txtrepids" value="" >																						
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
  $('#edate').datepicker();
  
});

</script>


<script type="text/javascript">	
	function selectAllBefore(source) 
	{
		checkboxes = document.getElementsByName('checks');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	}
	
	function selectAllAfter(source) 
	{
		acheckboxes = document.getElementsByName('achecks');
		for(var i in acheckboxes)
			acheckboxes[i].checked = source.checked;
	}
	
	function remove_not_digits(imei) {
		return imei.replace(/[^0-9]/, '');
	}
	
	function CalculateBal()
	{
	  var charges = document.getElementById('txtprice').value;
	  var deposit = document.getElementById('txtdeposit').value; 
	  var bal = charges - deposit;
	  document.getElementById('txtbalance').value=bal;
	 
	}
	
	function setrad(val) {
		document.getElementById("txtlabsend").value = val
		document.getElementById('divlab').style.display ='block';
	}
	function setradn(val) {
		document.getElementById("txtlabsend").value = val
		document.getElementById('divlab').style.display ='none';
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
	function setrfix(val) {
		document.getElementById("txtrfix").value = val
		
	} 
	
	function refreshMe()
	{
		//alert($(this).tab);
		//window.location = 'repsheet.php';
		 $('[href="#tab_rlist"]').tab('show');
		//window.location = 'repsheet.php#tab_rlist';
		//$("#represult").load(location.href + "#represult");
	}
	
    function validateRepSheet () {
		var success = 1;			
  
	/*
	if (document.getElementById("txtinvoice").value == "" ) {
            alert("Please enter Invoice#!");
			document.getElementById("txtinvoice").focus();
			success = 0;
            return;
			
    }
	*/	
	
	/*if (validateImei() == false) {
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
	/*
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
			
    }	*/
	if (document.getElementById("txtcsname").value == "" ) {
            alert("Please enter Customer Name#!");
			document.getElementById("txtcsname").focus();
			success = 0;
            return;
			
    }	
	if (document.getElementById("txtcpwd").value == "" ) {
            alert("Please enter Password!");
			document.getElementById("txtcpwd").focus();
			success = 0;
            return;
			
    }		
	
	if (document.getElementById("txtrecby").value == "" ) {
            alert("Please enter Retailer Name!");
			document.getElementById("txtrecby").focus();
			success = 0;
            return;
			
    }	
	var terms = document.getElementById('chkterms');
	
	
	if  (!(terms.checked)) {
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
			//alert (accessVal);
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
			
		// To get all Phone After Verification list
		var acheckVal="";
		$('input[name=achecks]:checked').each(function(i) {
			 acheckVal = acheckVal + "," + this.value; 		 
			while(acheckVal.charAt(0) === ',')
				acheckVal = acheckVal.substr(1);		
			//alert (acheckVal);
			document.getElementById("txtachecks").value = acheckVal;		        
			});
		
		//Showing Message
		waitingDialog.show('Please wait.....');
		var docForm = document.getElementById('RepSheetform');  
		var serializedData = new FormData(docForm);  		
		
		$.ajax({
			type:'POST',
			url: "repsheet_controller.php",
			data:serializedData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(data){
			//alert(data);
			if (data > 0 )	{		
				alert ("Data is saved successfully!");
				document.getElementById("txtid").value = data;
				document.getElementById("txtmid").value = data;
				document.getElementById("btnsave").style.visibility = "hidden";
				waitingDialog.hide();
				document.getElementById("btnprint").style.visibility = "visible";
				//document.getElementById("btnmail").style.visibility = "visible";
				document.getElementById("btnprint").focus();
				document.getElementById('RepSheetform').reset();
				//location.reload(); 				
				window.location = 'repsheet.php';
				 //$('[href="#tab_rlist"]').tab('show');
				//$("#represult").load(location.href + "#repsearch");

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
	
	//var sig = [{lx:20,ly:34,mx:20,my:34},{lx:21,ly:33,mx:20,my:34},�];
			
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
		var repid = document.getElementById("txtmid").value;
		document.getElementById("txtrepids").value = repid;	
}

function  printForm () {
	var docForm = document.getElementById('RepSheetform');  
	var serializedData = new FormData(docForm);
	
	//var id = document.getElementById("txtmid").value; 
	var id = $('#txtmid').val();	
	//alert(id);
	var url = "prepsheet.php?pid="+id;
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
						
			$.post("repsheetmail.php",serializedData,function(data){
			 //  alert(data);
			   if (data > 0 ) {							
					alert ("Email is sent successfully!");
					$('#modal-semail').modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();					
				} else {
					alert ("Email could not be sent!");			
				}		
			  
			});
			
		}	
	}	
</script>
