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
	$nshopid = $_SESSION['shop_id'];	
	$ntablename="repairs";
	$norderby = " ORDER BY created_at DESC";
	$nwhere= "shop_id=$nshopid AND status='NotFixed'";
	
	$nrfid = 00;
	$nrecordsPerPage = 10;
	$npage = 1;	
	$ntotalPages = 0;	
	if ( isset ($_POST['npageNum'] ) ) {
		$npage = $_POST['npageNum'];
	}
	
	$ndata = $db->totalRecords($ntablename, $nwhere);
	//echo $ndata;		
	$totalRecords = $ndata;
	
	if ($totalRecords != 0) {
		$ntotalPages = ceil( $totalRecords/$nrecordsPerPage);
		if ( $npage >= $ntotalPages ) {
			$npage = $ntotalPages;
		}
		$nstartPage = ($npage - 1) * $nrecordsPerPage;			
		$ndatar = $db->selectdata($ntablename, $nwhere, $norderby, $nstartPage, $nrecordsPerPage);
	}
?>	

<body>
	<input type="hidden" id="ncurrentPage" value="<?=$npage?>" />
	<!--
	<div class="pull-right" > 
		<?php echo "Total Pages: " .$ntotalPages ?>
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
							foreach ($ndatar as $row) {								
								$timestamp = strtotime($row['date_entered']);							
								$dateenter =  date("d/m/Y", $timestamp);
									?>	
										<tr>
											<?php $nrfid = $row['id'];?>																																								
											<td data-title="Date"><?php echo $dateenter;?></td>																		
											<td data-title="Invoice"><?php echo $row['invoice'];?></td>
											<td data-title="Model"><?php echo $row['model'];?></td>
											<td data-title="Make"><?php echo $row['make'];?></td>	
											<td data-title="IMEI"><?php echo $row['imei'];?></td>	
											<?php
												$ntablename="repair_faults";
												$norderby = " ORDER BY fault ASC";
												$nwhere= " repair_id=$nrfid";
												$ndatarc = $db->select($ntablename,$norderby, $nwhere);
												$faults ="";
												foreach ($ndatarc as $rows) {
													$faults = $rows['fault'] . "," . $faults;
												}
												/*
												$sql = "SELECT SUM(charges) AS charges FROM repair_faults nwhere repair_id = $nrfid";
	
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
				if ($npage > 1 ) {
				?>		
				<li>
					<a href="javascript:{}" onclick="javascript:npreviousRecords();">Prev</a>
				</li>  
				<?php
				}
				?>				
				
				<?php
				for($i=1; $i <= $ntotalPages; $i++) {
					if($npage==$i){
				?>
					<li class="active">
						<a href="javascript:{}" onclick="javascript:njumpToRecords(<?php echo $i?>);"><?php echo $i?><span class="sr-only">(current)</span></a>
					</li>
				<?php } 
					else {
					?>
						<li>
							<a href="javascript:{}" onclick="javascript:njumpToRecords(<?php echo $i?>);"><?php echo $i?></a>
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
					if ($npage < $ntotalPages ) {
					?>		
					<li>
						<a href="javascript:{}" onclick="javascript:nnextRecords();">Next</a>
					</li>	
					<?php
					}
				?>
			</ul> 
		</div>	
	</div> 	
	
<script type="text/javascript">
	
	function nnextRecords() {
		
		var ncurrentPage = $('#ncurrentPage').val();
		ncurrentPage++;
							
		$.post("notfixed_list.php",{npageNum:ncurrentPage},function(data){
			$('#notfixedlist').html(data);
		});
		
	}
	
	function npreviousRecords() {
		
		var ncurrentPage = $('#ncurrentPage').val();
		ncurrentPage--;
		
		$.post("notfixed_list.php",{npageNum:ncurrentPage},function(data){
		
			$('#notfixedlist').html(data);
		});
		
	}
	
	function njumpToRecords(npage) {
		
		$.post("notfixed_list.php",{npageNum:npage},function(data){
		
			$('#notfixedlist').html(data);
		});
	}
		
	
</script>

</body>
</html> 

