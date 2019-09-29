<!DOCTYPE html>

<?php
	
	$mainCat = "Attendance";	
	include_once 'path.php';
	error_reporting(0);	
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
	include_once($path ."adminheader.php"); 
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
	
	$shopid = $_SESSION['shop_id'];	
	$usname = $_SESSION['attendee'];
	$usid = $_SESSION['attendeeid'];
	$dt = new DateTime("now", new DateTimeZone('Europe/London'));
	//print_r ($dt);
	$tdate = $dt->format('Y-m-d');
	$last=   date('Y-m-15');
	
	$checkin =0;
	$chkout = 0;
	$nofound = 0; 		
	$totDuration=0;		
	
	$sqlstr = "SELECT * from attendance where user_name = '$usname' AND DATE(checkin) = '$tdate'" ;
	//echo $sqlstr;
	$results = $mysqli->query($sqlstr) or die($mysqli->error.__LINE__);
		
	if($results->num_rows > 0) {
		while($records = $results->fetch_assoc()) { 
			$maxId = $records['id'];
			if (isset($records['checkout']) ) 
				$checkin=2;
			else	
				$checkin=1;
		}
		
	}
	
	//Check for checout date null	
	$chkout = $mysqli->query("SELECT count(*) AS Missed from attendance where user_name = '$usname' AND checkout IS NULL and checkin IS NOT NULL AND DATE(checkin) <> '$tdate'")->fetch_object()->Missed;
// The Following 2 lines commented to disable auto-checkout, as this was giving error for user which were not manually checked out	
//if ($chkout > 0) 
	//	$checkin=3;
	
	//$firstDayUTS = mktime (0, 0, 0, date("m"), -15, date("Y"));
	//$lastDayUTS = mktime (0, 0, 0, date("m"), 15, date("Y"));
	
	if (strtotime($tdate) >= strtotime($last)) {
		$monthSt = date('Y-m-16');
		$endTime =  strtotime(date('Y-m-16'));				
		
	} else {
		$monthSt = date('Y-m-16', strtotime("$last -1 month"));
		$endTime = strtotime(date('Y-m-16', strtotime("$last -1 month")));
	}	
	
	//$endTime = strtotime(date("Y-m-d", $firstDayUTS)); 
	//$thisTime = strtotime(date("d-m-Y", $lastDayUTS));
	
	//$endTime = strtotime(date('Y-m-01')); // hard-coded '01' for first day
	$thisTime  = strtotime(date('Y-m-d')); //Current Date --strtotime(date('Y-m-t'));	
	$currMonth = date('M Y', $thisTime);
	
	//$monthSt = date("Y-m-d", $firstDayUTS); //date('Y-m-01');
	//$monthSt = date("Y-m-16"); //date('Y-m-01');
	$monthCur = date('Y-m-d');
		
	
	//$first=  date('Y-m-15', strtotime("$last -1 month"));
	
	$prevMonth = date('F Y', mktime(0, 0, 0, date('m')-1, 1, date('Y')));								
	// To get total working days and total time of the month	
	$totdays = $mysqli->query("SELECT count(id) AS Working from attendance where user_name = '$usname' AND DATE(checkin) between '$monthSt' AND '$monthCur'")->fetch_object()->Working;
	// Total time worked
	//$strDiff = "SELECT sum(time_format(timediff(checkout,checkin),'%H:%m'))  AS timediff from attendance where user_name = '$usname' AND DATE(checkin) between '$monthSt' AND '$monthCur'";
	
	//echo $firstDay ."<br>";
	//echo $lastDay ."<br>";
?>	
<div class="row-fluid ">				
		<div class="row-fluid divider slide_divider base_color_background">
				<div class="container">                       
				</div>
		</div>
		<div class="span10 text-left">
			<b>Welcome <?=ucfirst($_SESSION['attendeename'])?></b>			
		</div>	
		<div class="span8">
			<div class="span4 offset1 text-center">
				<?php
					if ($checkin == 1) 
						echo "<th><a href='javascript:checkout();' style='font-size:18px; font-weight:bold; color:#DE5050; text-decoration:underline;' >	CheckOut	</a></th>";
					else if ($checkin == 0) 
						echo "<th><a data-toggle='modal' href='#modal-signin' style='font-size:18px; font-weight:bold; color:#DE5050; text-decoration:underline;' >	CheckIn	</a></th>";
					else if ($checkin == 3) 
						echo "<th><a href='javascript:chkoutMsg();' style='font-size:18px; font-weight:bold; color:#DE5050; text-decoration:underline;' >	CheckIn	</a></th>";
				?>		
			</div>
			<div class="span2">
				<?php
					echo "<th><a href='javascript:closeForm();' style='font-size:18px; font-weight:bold; color:#DE5050; text-decoration:underline;' >	Close Form	</a></th>";
				?>		
			</div>			
		</div>	
		
	<br>
	<?php
	if($checkin == 0)
		echo "
		<div class='container'>
			<div class='span12 distance_1'>
				<h2 class='text-center'><a data-toggle='modal' href='#modal-signin' style='font-size:34px; border:solid 2px; padding:5px; font-weight:bold; color:white;background-color:#DE5050; text-decoration:underline;' >	CheckIn	</a></h2>
			</div>
		</div>";
	else if($checkin == 1)
		include_once($pathaj."markattendancedata.php");
	else
		include_once($pathaj."markattendancedata.php");
	 ?>

</div>

<div class='modal hide fade' id='modal-signin' role='dialog' tabindex='-1' style="width: 700px;">
	<div class='modal-header'>
		<button class='close' data-dismiss='modal' type='button'>&times;</button>
		<h3>Add Signature</h3>
	</div>
	<div class='modal-body' >		
		<div class='controls text-center'>			
			<div class='form-wrapper' >
				<form name="attendance_form" id="attendance_form" class="sigPad" action="" method="post" >										
																	
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
					<input type="hidden" id="attendee"  name="attendee" value="<?php echo $usname;?>">
					<input type="hidden" id="attendeeid"  name="attendeeid" value="<?php echo $usid;?>">
					<input type="hidden" id="txtshpid"  name="txtshpid" value="<?php echo $shopid;?>">
							
				</form>
			</div>
		</div>
	</div>
	<div class='modal-footer'>	
		<a href="javascript:checkIn();" class="button_bar">Save</a>
	</div>
</div>

<footer>
   <?php
		include_once($path."footer.php");                
	?>
	<script type='text/javascript' src='assets/js/spinner.js'></script>
</footer>
	
<script type="text/javascript">
$(document).ready(function () {
	$('.sigPad').signaturePad({drawOnly:true});
});

function chkoutMsg() {
	alert ('Your Previous checkout time is missing, Please contact your Area Manager!');
	return;
}

function checkIn()
{	
	success = 1;
	if (document.getElementById("output").value == "" ) {
            alert("Please Draw Signature!");
			success = 0;
            return;
			
    }
	if (success == 1) {
		//waitingDialog.show('Please wait.....');		
		
		var serializedData = $('#attendance_form').serialize();		
		$('#modal-signin').modal('hide');
		$.post("checkin_controller.php",serializedData,function(data){
           //alert(data);
		   if (data != 0 )	{		
				alert ("You are successfully checked in at "+ data);
				
				window.location.reload();
			}
		   else				
				alert ("Please login to attendace system first!");	
				//waitingDialog.hide();		
          
		});
	}	
	
}

function checkout()
{
	var serializedData = $('#attend_form').serialize();		
	$.post("checkout_controller.php",serializedData,function(data){
           //alert(data);
		  	alert ("You are checked out at "+data);								
			window.location.reload();			
	});
	
}

 function closeForm() {
		
		$.post("closeform_controller.php",{},function(data){           
		  window.location = "attendance.php";
		});
	}	

</script>

</body>
</html> 

