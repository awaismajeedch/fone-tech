<!DOCTYPE html>


<?php	
	//session_start();
	$mainCat = "Attendance";	
	include_once 'path.php';	
	error_reporting(0);		
?>   

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
	<style type="text/css">
	.typeahead {
		z-index: 1000;
	}	
	</style>
</head> 
<body >
<?php
	include_once($path ."sadminheader.php");
	include_once 'include/global.inc.php';
	
	$txtshop = $_GET['shid']; //$_POST['txtshop'];
	$txtshopname = $_GET['shname']; //$_POST['txtshop'];
	
	
	$sqlstr = "SELECT id,firstname, lastname,user_name FROM users WHERE users.shop_id = '$txtshop'";	
	//$sqlstr = "SELECT shops.name, attendance.user_id, attendance.user_name, count(attendance.id ) AS Days, ROUND(SUM( (UNIX_TIMESTAMP(checkout) - UNIX_TIMESTAMP(checkin))/60/60),2) AS Hours FROM attendance, users , shops WHERE attendance.user_id = users.id AND users.shop_id = shops.id $datesql $shopsql $usersql  GROUP BY attendance.user_name";
	//echo $sqlrep;
	$result = $db->selectQuery($sqlstr);	
			
	//$criteria = "Selected Criteria  $shopc $labc $datec";
		
?>	
	
	<div class="row-fluid ">
	<div class="span12">		
		<!-- LayerSlider Content End -->
		<div class="row-fluid divider slide_divider base_color_background">
			<div class="container">                       
			</div>
		</div>
		<div class="container">					
			<div class="row-fluid distance_1" style="margin-top:30px;">	
				<div class="row-fluid">
					<div class="span12">			
						<h4> <?php echo $txtshopname;?> Users List  </h4>
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>						
									<tr>
										<th>User Name</th>							
										<th>First Name</th>
										<th>Last Name</th>
									</tr>
								</thead	>
								<tbody>	
									<?php if (!empty($result)) 
									{
									
										foreach ($result as $rows) 
										{ ?>
											<tr>								
												<!--<td><a href="attendance_report.php?user=<?php echo $rows['user_name']; ?>&sdate=<?php echo $stdate;?>&edate=<?php echo $eddate;?>" style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;'><?php echo $rows['user_name']; ?></a></td>-->
												<td><a href="attendance_report.php?user=<?php echo $rows['user_name']; ?>&usid=<?php echo $rows['id']; ?>&shid=<?php echo $txtshop; ?>&sdate=<?php echo $stdate;?>&edate=<?php echo $eddate;?>" style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;'><?php echo $rows['user_name']; ?></a></td>									
												<td><?php echo $rows['firstname']; ?></td>
												<td><?php echo $rows['lastname']; ?></td>
											</tr>
									<?php } 							
									} else {
									?>
										<tr>
											<td colspan="4"> No Record Found</td>								
										</tr>
									<?php } ?>
								</tbody	>						
							</table>
							
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

