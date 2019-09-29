<!DOCTYPE html>

<?php
	error_reporting(0);	
	$mainCat = "Attendance";	
	include_once 'path.php';	
	Session_start();
?>

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
	<style type="text/css">
	.typeahead {
		z-index: 1000;
	}	
	</style>
</head> 

<body >
<!-- Include Header  -->
<?php
	include_once($path ."attendentheader.php"); 
	if (empty($_SESSION['user_id']))
    {
         /*** redirect ***/
        header("Location: index.php");
        exit;
    }
?>   
<?php
	require_once 'include/conn.php';
	require_once 'classes/MiscFunctions.php';
	
	$usname = $_GET['user'];
	$usid = $_GET['usid'];
	$shid = $_GET['shid'];
	//$usfname= $_SESSION['attendeename'];
	$dt = new DateTime("now", new DateTimeZone('Europe/London'));
	//print_r ($dt);
	$tdate = $dt->format('Y-m-d');
	$last=   date('Y-m-15');
	
	$stdate = $_GET['sdate'];
	$eddate = $_GET['edate'];
		
	if (empty($stdate)) {
		
		if (strtotime($tdate) >= strtotime($last)) {
		$stdate = date('Y-m-16');
		$endTime =  strtotime(date('Y-m-16'));				
		
		} else {
			$stdate = date('Y-m-16', strtotime("$last -1 month"));
			$endTime = strtotime(date('Y-m-16', strtotime("$last -1 month")));
		}	
		
		//$firstDayUTS = mktime (0, 0, 0, date("m"), -15, date("Y"));
		//$endTime = strtotime(date("Y-m-d", $firstDayUTS));
		//$stdate = date("Y-m-d", $firstDayUTS); //date('Y-m-01');
		//$stdate = date('Y-m-d', strtotime('-15 days'));	
		$eddate = date('Y-m-d');	
	}	
	else
		$endTime =	strtotime($stdate); 
		
	$totDuration=0;			
	
	//$endTime = strtotime($stdate); // hard-coded '01' for first day
	$thisTime  = strtotime($eddate); //strtotime(date('Y-m-t'));	
	
	// To get total working days and total time of the month	
	$totdays = $mysqli->query("SELECT count(id) AS Working from attendance where user_name = '$usname' AND DATE(checkin) between '$stdate' AND '$eddate'")->fetch_object()->Working;
	
	// To get total working days and total time of the month	
	$usfname = $mysqli->query("SELECT CONCAT_WS( ' ', lastname , firstname ) AS fullname from users where user_name = '$usname'")->fetch_object()->fullname;
	
?>	
<div class="row-fluid ">				
	<div class="row-fluid divider slide_divider base_color_background">
		<div class="container">                       
		</div>
	</div>
	<div class="row-fluid">
		<form class="form-horizontal" id="searchrform"  name="searchrform" method="post" >	
		<div class="span12 discover">							
			<div class="span5">														
				<div class="control-group">
					<label class="control-label" >Start Date: </label>
					<div class="controls">
						<div class="input-append date" name="sdate" id="sdate" data-date="" data-date-format="yyyy-mm-dd" >
						<input  size="10" type="text" name="txtsdate" id="txtsdate" value="<?php echo $stdate;?>" >
						<span class="add-on"><i class="icon-calendar"></i></span>											
						</div>														
					</div>
				</div>																
			</div>
			<div class="span4">																
				<div class="control-group">
					<label class="control-label" >End Date: </label>
					<div class="controls">
						<div class="input-append date" name="edate" id="edate" data-date="" data-date-format="yyyy-mm-dd" >
						<input  size="10" type="text" name="txtedate" id="txtedate" value="<?php echo $eddate;?>" >
						<span class="add-on"><i class="icon-calendar"></i></span>											
						</div>														
					</div>
				</div>						
				
				<div class="control-group">							
					<!--<a href="attendance_report.php?user=<?php echo $usname;?>&sdate=<?php echo $stdate;?>&edate=<?php echo $eddate;?>"  class="button_bar" style="float:right;">Search</a>-->
					<a href="javascript:search();"  class="button_bar" style="float:right;">Search</a>
				</div>
				<input type="hidden" name="txtusname" id="txtusname" value="<?php echo $usname;?>">	
				<input type="hidden" name="usid" id="usid" value="<?php echo $usid;?>">
				<input type="hidden" name="shid" id="shid" value="<?php echo $shid;?>">
				
			</div>					
		</div>	
		</form>
	</div>
	<div id="printdiv">
		<page>			
		<div class="container">
			<div class="span12">
				<h2 class="text-center">Attendance of  <?php echo $usfname; ?> from  <?php echo $stdate; ?> - <?php echo $eddate; ?>  </h2>			
				<!--<h2 class="text-right"><a data-toggle='modal' href='#modal-prevmonth' style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' >Prev Month - <?php echo $prevMonth; ?></a></h2>-->
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>						
								<th>Date - Day</th>
								<th>Shop Name</th>														
								<th>Check In</th>														
								<th>Check Out</th>
								<th>Status</th>
								<th>Break</th>
								<th>Total Time</th>
								<th>Signatures</th>	
								<th>Verified</th>	
							</tr>
						</thead>
						<tbody>
							<?php							
								
								while($thisTime >= $endTime)
								{
									//echo $thisDate . $day ."<br>";
									
									$thisDate = date('Y-m-d', $thisTime);
									$day = date('D', $thisTime);
									
									$sql = "SELECT id, shop_id, user_name, checkin,checkout, signature_path, verified from attendance where user_name = '$usname' AND DATE(checkin) = '$thisDate'" ;
									//echo $sql;
									$result = $mysqli->query($sql);
									//echo "rows" . $result->num_rows;
									if ($result->num_rows > 0) {
										$nofound = 1; 
										
										echo '<tr class="success">';
										while($row = $result->fetch_assoc()) { 										
											$dt1 = date('Y-m-d H:i',strtotime($row['checkin']));
											$dtt1 = date('H:i',strtotime($row['checkin']));
											$shid = $row['shop_id'];
											if (!empty($shid))
												$shname = $mysqli->query("SELECT name from shops where id = $shid")->fetch_object()->name;
											else
												$shname = "";
											if (isset($row['checkout'])) 
											{
												$dt2 = $row['checkout'];											
												//$dt1 = $row['checkin'];
												$date_a = new DateTime($dt2);
												$date_b = new DateTime($dt1);
												//$interval = date_diff($date_a,$date_b);
												$interval = $date_a->diff($date_b);
												//$duration =  $interval->format('%H:%i');
												$fnduration =  strtotime($interval->format('%H:%i'));											
												$duration = date("H:i", strtotime('-30 minutes', $fnduration));
												// Sum up All Times
												//$dt2 = strtotime($dt2);
												//$dt1 = strtotime($dt1);
												$dt2 = date('Y-m-d H:i', strtotime($dt2));
												$dtt2 = date('H:i', strtotime($dt2));
												$break ='30 Min';
											}	
														
												
										?>
												<td data-title="Date-Day"><a data-toggle='modal' href='#modal-attendance' style="font-size:12px; font-weight:bold; color:#000; text-decoration:underline;" onClick="javascript:EditAttendance('<?=$thisDate;?>','P','<?=date('H:i',strtotime($row['checkin']))?>','<?=date('H:i',strtotime($row['checkout']))?>','<?=$row['id']?>','<?=$row['verified']?>');"><?php echo $thisDate;?> - <?php echo $day;?></a></th>
												<td data-title="Shop"><?php echo $shname;?></td>							
												<td data-title="CheckIn"><?php echo $dtt1;?></td>							
												<td data-title="CheckOut"><?php echo $dtt2;?></td>								
												<td data-title="Status">P</td>	
												<td data-title="Break"><?php echo $break;?></td>
												<td data-title="Duration"><?php echo $duration;?></td>																						
												<td data-title="Signatures">
												<?php if (!empty($row['signature_path'])) { ?>
													<img  src="documents/<?php echo $row['signature_path'];?>" style="width:50px; height:30px;" >
												<?php } else {
													echo "-"; } ?>
												</td>					
												<td data-title="Verified"><?php echo $row['verified'];?></td>		
										<?php 
											$totDuration = SumTime($duration, $totDuration);									
										}			
										echo '</tr>';	
									} else {								
										$nofound = 1; 
										
										echo '<tr class="error">'; ?>
																				
												<td data-title="Date-Day"><a data-toggle='modal' href='#modal-attendance'  style="font-size:12px; font-weight:bold; color:#000; text-decoration:underline;" onClick="javascript:EditAttendance('<?=$thisDate;?>','A',0,0,0,'no');"><?php echo $thisDate;?> - <?php echo $day;?></a></th>
												<td data-title="Shop">-</td>							
												<td data-title="CheckIn">-</td>							
												<td data-title="CheckOut">-</td>							
												<td data-title="Status">A</td>
												<td data-title="Break">0</td>
												<td data-title="Duration">0</td>											
												<td data-title="Signatures">-</td>
												<td data-title="Verified">-</td>
										<?php }			
										echo '</tr>';	
									
									$thisTime = strtotime('-1 day', $thisTime); // increment for loop
								}
							?>
							<tr>						
								<th >Total Working Days</th>	
								<th colspan="4"><?php echo $totdays;?></th>
								<th >Total Duration</th>														
								<th><?php echo $totDuration;?></th>
								<th></th>	
							</tr>
						</tbody>
					</table>					
				</div>
			</div> 
		</div>	
		</page>
	</div>		
	<div class="span4 offset1">
		<h2 class="text-left"><a href="javascript:history.back();" style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;'>	Go To Attendance Main Page	</a></h2>	
	</div>						
	<div class="span4">
		<form name="frmpdf" id="frmpfd" method="post" action="savepdf_controller.php" target="_blank">
			<input type="hidden" name="txtcont" id="txtcont" value="">	
			<!--<h2 class="text-right"><a href="javascript:savePDF('printdiv');"  style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;'>Save as PDF</a>-->
			<h2 class="text-right"><a href="javascript:createpdf();" class="btn btn-link" style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;'>Export to PDF</a>
		</form>	
	</div>		
</div>

<div class='modal hide fade' id='modal-attendance' role='dialog' tabindex='-1' style="width: 700px;">
	<div class='modal-header'>
		<button class='close' data-dismiss='modal' type='button'>&times;</button>
		<h3>Edit Attendance</h3>
	</div>
	<div class='modal-body' >		
		<div class='controls text-center'>			
			<div class='form-wrapper'>
				<form name="att_form" id="att_form" class="form-horizontal" action="" method="post" >										
					<div class="row-fluid" >	
						<div class="span8" >							
							<div class="control-group">							
								<label class="control-label" >Date: </label>
								<div class="controls">												
									<input  type="text"  name="txtdate" id="txtdate" class="input-large" value = "" Readonly />																								
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Start Time: </label>
								<div class="controls">	
									<input class="input-large" id="txtstime" name="txtstime" type="text" value="09:00" />									
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >End Time</label>
								<div class="controls">	
									<input class="input-large" id="txtetime" name="txtetime" type="text" value="18:00" />									
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Status</label>
								<div class="controls">	
									<select name="txtastatus" id="txtastatus">
										<option value="P">P</option>
										<option value="A">A</option>											
									</select>	
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Notes:</label>
								<div class="controls">	
									<textarea style="height:50px;" class="input-large" id="txtnotes" name="txtnotes"></textarea>
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Verified:</label>
								<div class="controls">	
									<select name="txtverified" id="txtverified">																				
										<option value="yes">Yes</option>
										<option value="no" selected>No</option>									
									</select>	
								</div>
							</div>	
							<input type="hidden"  name="txtattid" id="txtattid" value="" >																						
							<input type="hidden" id="attendee"  name="attendee" value="<?php echo $usname;?>">	
							<input type="hidden" name="usid" id="usid" value="<?php echo $usid;?>">
							<input type="hidden" name="shid" id="shid" value="<?php echo $shid;?>">
						</div>						
					</div>	
				</form>
			</div>
		</div>
	</div>
	<div class='modal-footer'>		
		<a href="javascript:validateAtt();" class="button_bar">Save</a>
	</div>
</div>

<script>
	$(document).ready(function(){
		  
		$('#sdate').datepicker({
                    format: 'yyyy-mm-dd'
                }); 
		$('#edate').datepicker({
                    format: 'yyyy-mm-dd'
                });
	  });
	
	function search() {
		var tsdate = document.getElementById("txtsdate").value;
		var tedate = document.getElementById("txtedate").value;
		var tusname = document.getElementById("txtusname").value;
		var tusid = document.getElementById("usid").value;
		var tshid = document.getElementById("shid").value;
		
		var str = "admin_attendance_report.php?user="+tusname+"&usid="+tusid+"&shid="+tshid+"&sdate="+tsdate+"&edate="+tedate;		
		window.location = str;		
	}
	
	function savePDF(printpage)
	{
		//var headstr = "<html><head><title></title></head><body>";
		//var footstr = "</body>";
		var str = document.all.item(printpage).innerHTML;
		//var oldstr = document.body.innerHTML;
		$.post("savepdf_controller.php",{content:str},function(data){
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
	
	function createpdf() {
		//alert(document.getElementById("printdiv").innerHTML);
		document.getElementById("txtcont").value = document.getElementById("printdiv").innerHTML;
		//$("#frmpdf").attr("action", "savepdf_controller.php");		
		document.forms["frmpdf"].submit();
			
	}
	
	function EditAttendance(adate,status,timein,timeout,id,verify) {
		
		document.getElementById('txtdate').value = adate;
		document.getElementById('txtastatus').value = status;			
		if (timeout == '0')
			document.getElementById('txtstime').value = '09:00';
		else	
			document.getElementById('txtstime').value = timein;
			
		if (timeout == '05:00')
			document.getElementById('txtetime').value = '18:00';
		else if (timeout == '0')
			document.getElementById('txtetime').value = '18:00';
		else
			document.getElementById('txtetime').value = timeout;
			
		document.getElementById('txtattid').value = id;
		document.getElementById('txtverified').value = verify;
	}

	function validateAtt()
	{	
		success = 1;
		/*
		if (document.getElementById("txtstime").value == "" ) {
				alert("Please enter CheckIn Time!");
				success = 0;
				return;
				
		}
		if (document.getElementById("txtetime").value == "" ) {
				alert("Please enter CheckOut Time!");
				success = 0;
				return;
				
		}
		*/
		if (success == 1) {
					
			var serializedData = $('#att_form').serialize();		
			
			$.post("updatecheckin_controller.php",serializedData,function(data){
			   //alert(data);
			   if (data != 0 )	{		
					alert ("Record is saved successfully!");
					location.reload(); 
				}
			   else				
					alert ("Record could not be saved!");			
			  
			});
	}	
	
	}	
	
</script>
</body>
</html> 

