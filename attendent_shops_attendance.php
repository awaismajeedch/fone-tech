<!DOCTYPE html>

<?php
	$mainCat = "Attendance";	
	include_once 'path.php';	
	error_reporting(0);	
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
	<style type="text/css">
	.typeahead {
		z-index: 1000;
	}	
	</style>
</head> 
<body >
<?php
	include_once($path ."attendentheader.php");
	include_once 'include/global.inc.php';
		
	$tablename="shops";
	$orderby = " ORDER BY created_at ASC";
	$where= "1=1";
	$rfid = 00;
	$recordsPerPage = 100;
	$page = 1;	
	$totalPages = 0;	
	if ( isset ($_POST['pageNum'] ) ) {
		$page = $_POST['pageNum'];
	}
	
	$data = $db->totalRecords($tablename, $where);
	//echo $data;		
	$totalRecords = $data;
	
	if ($totalRecords != 0) {
		$totalPages = ceil( $totalRecords/$recordsPerPage);
		if ( $page >= $totalPages ) {
			$page = $totalPages;
		}
		$startPage = ($page - 1) * $recordsPerPage;			
		$datar = $db->selectData($tablename, $where, $orderby, $startPage, $recordsPerPage);
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
			<div class="row-fluid distance_1" style="margin-top:30px;">	
				<div class="row-fluid">	
					<div class="span12">
						<h2> Shop Lists </h2>
						<div class="table-responsive table-bordered">
							<table class="table">
								<thead>
									<tr>										
										<th>Shop Name</th>													
										<th>Display Name</th>													
										<th>Contact Person</th>												
										<th>Cell#</th>
										<th>Email</th>
										<th>Address</th>												
										<!--<th>Action</th>-->
									</tr>
								</thead>
								<tbody>
									<?php if ($totalRecords > 0) {
											foreach ($datar as $row) {								
											
													?>	
														<tr>
															<?php $rfid = $row['id'];											
															?>
															<td data-title="Shop Name"><a href="attendent_shopuser_attendance.php?shid=<?php echo $row['id'];?>&shname=<?php echo $row['name'];?>"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" ><?php echo $row['name'];?></a></td>																																									
															<td data-title="Display Name"><?php echo $row['display_name'];?></td>																		
															<td data-title="Contact Person"><?php echo $row['contact_person'];?></td>																		
															<td data-title="Cell#"><?php echo $row['cellno'];?></td>	
															<td data-title="Email"><?php echo $row['email'];?></td>	
															<?php $address = $row['address']. ", " . $row['city']; ?> 
															<td data-title="Address"><?php echo $address ?></td>											
														</tr>
																
													<?php 							
											
											}	
										} else { ?>
										<tr>
											<td colspan="5">No Record Found</td>
										</tr>	
										<?php
										}		
										?>  
								</tbody>
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

