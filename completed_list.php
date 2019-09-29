<!DOCTYPE html>

<?php
error_reporting(0);
session_start();
	/*	
	if (empty($_SESSION['user_id']))
    {
      
        header("Location: index.php");
        exit;
    }
	*/
?>   

<?php
	include_once 'include/global.inc.php';
	$cshopid = $_SESSION['shop_id'];	
	$ctablename="repairs";
	$corderby = " ORDER BY created_at DESC";
	$cwhere= "shop_id=$cshopid AND status='Fixed'";
	
	$crfid = 00;
	$crecordsPerPage = 10;
	$cpage = 1;	
	$ctotalPages = 0;	
	if ( isset ($_POST['cpageNum'] ) ) {
		$cpage = $_POST['cpageNum'];
	}
	
	$cdata = $db->totalRecords($ctablename, $cwhere);
	//echo $cdata;		
	$totalRecords = $cdata;
	
	if ($totalRecords != 0) {
		$ctotalPages = ceil( $totalRecords/$crecordsPerPage);
		if ( $cpage >= $ctotalPages ) {
			$cpage = $ctotalPages;
		}
		$cstartPage = ($cpage - 1) * $crecordsPerPage;			
		$cdatar = $db->selectdata($ctablename, $cwhere, $corderby, $cstartPage, $crecordsPerPage);
	}
?>	

<body>
	<input type="hidden" id="ccurrentPage" value="<?=$cpage?>" />
	<!--
	<div class="pull-right" > 
		<?php echo "Total Pages: " .$ctotalPages ?>
	</div>
	-->
    <div class="span12">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Invoice</th>													
						<th>Model</th>													
						<th>Refix</th>						
						<th>IMEI</th>
						<th>Faults</th>
						<th>Charges</th>
						<th>Status</th>
						<th>Lab Notes</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($totalRecords > 0) {
							foreach ($cdatar as $row) {								
								$timestamp = strtotime($row['date_entered']);							
								$dateenter =  date("d/m/Y", $timestamp);
									?>	
										<tr>
											<?php $crfid = $row['id'];?>																																								
											<td data-title="Date"><?php echo $dateenter;?></td>
											<td data-title="Invoice"><?php echo $row['invoice'];?></td>	
											<td data-title="Model"><?php echo $row['model'];?></td>
											<td data-title="Make"><?php echo $row['make'];?></td>	
											<td data-title="IMEI"><?php echo $row['imei'];?></td>	
											<?php
												$ctablename="repair_faults";
												$corderby = " ORDER BY fault ASC";
												$cwhere= " repair_id=$crfid";
												$cdatarc = $db->select($ctablename,$corderby, $cwhere);
												$faults ="";
												foreach ($cdatarc as $rows) {
													$faults = $rows['fault'] . "," . $faults;
												}
												/*
												$sql = "SELECT SUM(charges) AS charges FROM repair_faults cwhere repair_id = $crfid";
	
												$value = $db->selectQuery($sql);	
												foreach ($value as $result) {
													$sum = $result['charges'];
												}
												*/
												
											?>											
											<td data-title="Faults"><?php echo $faults ?></td>
											<td data-title="Charges"><?php echo $row['charges'] ?></td>											
											<td data-title="Status"><?php echo $row['status'];?></td>	
											<td data-title="Lab Notes"><?php echo $row['labnotes'];?></td>	
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
		<div class="pagination pagination-centered">
			<ul>
				<?php
				if ($cpage > 1 ) {
				?>		
				<li>
					<a href="javascript:{}" onclick="javascript:cpreviousRecords();">Prev</a>
				</li>  
				<?php
				}
				?>				
				
				<?php
				for($i=1; $i <= $ctotalPages; $i++) {
					if($cpage==$i){
				?>
					<li class="active">
						<a href="javascript:{}" onclick="javascript:cjumpToRecords(<?php echo $i?>);"><?php echo $i?><span class="sr-only">(current)</span></a>
					</li>
				<?php } 
					else {
					?>
						<li>
							<a href="javascript:{}" onclick="javascript:cjumpToRecords(<?php echo $i?>);"><?php echo $i?></a>
						</li>
					<?php
						}
					?>	
					
					<?php
						if ( $i == 10) {
						break;
							}
				}
				?>
				
				<?php
					if ($cpage < $ctotalPages ) {
					?>		
					<li>
						<a href="javascript:{}" onclick="javascript:cnextRecords();">Next</a>
					</li>	
					<?php
					}
				?>
			</ul> 
		</div>	
	</div> 	
	
<script type="text/javascript">
	
	function cnextRecords() {
		
		var ccurrentPage = $('#ccurrentPage').val();
		ccurrentPage++;
							
		$.post("completed_list.php",{cpageNum:ccurrentPage},function(data){
			$('#completedlist').html(data);
		});
		
	}
	
	function cpreviousRecords() {
		
		var ccurrentPage = $('#ccurrentPage').val();
		ccurrentPage--;
		
		$.post("completed_list.php",{cpageNum:ccurrentPage},function(data){
		
			$('#completedlist').html(data);
		});
		
	}
	
	function cjumpToRecords(cpage) {
		
		$.post("completed_list.php",{cpageNum:cpage},function(data){
		
			$('#completedlist').html(data);
		});
	}
		
	
</script>

</body>
</html> 

