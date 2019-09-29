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
	$pshopid = $_SESSION['shop_id'];	
	$ptablename="repairs";
	$porderby = " ORDER BY created_at DESC";
	$pwhere= "shop_id=$pshopid AND status='Pending'";
	
	$prfid = 00;
	$precordsPerPage = 10;
	$ppage = 1;	
	$ptotalPages = 0;	
	if ( isset ($_POST['ppageNum'] ) ) {
		$ppage = $_POST['ppageNum'];
	}
	
	$pdata = $db->totalRecords($ptablename, $pwhere);
	//echo $pdata;		
	$totalRecords = $pdata;
	
	if ($totalRecords != 0) {
		$ptotalPages = ceil( $totalRecords/$precordsPerPage);
		if ( $ppage >= $ptotalPages ) {
			$ppage = $ptotalPages;
		}
		$pstartPage = ($ppage - 1) * $precordsPerPage;			
		$pdatar = $db->selectdata($ptablename, $pwhere, $porderby, $pstartPage, $precordsPerPage);
	}
?>	

<body>
	<input type="hidden" id="pcurrentPage" value="<?=$ppage?>" />
	<!--
	<div class="pull-right" > 
		<?php echo "Total Pages: " .$ptotalPages ?>
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
							foreach ($pdatar as $row) {								
								$timestamp = strtotime($row['date_entered']);							
								$dateenter =  date("d/m/Y", $timestamp);
									?>	
										<tr>
											<?php $prfid = $row['id'];?>																																								
											<td data-title="Date"><?php echo $dateenter;?></td>																		
											<td data-title="Invoice"><?php echo $row['invoice'];?></td>
											<td data-title="Model"><?php echo $row['model'];?></td>
											<td data-title="Make"><?php echo $row['make'];?></td>	
											<td data-title="IMEI"><?php echo $row['imei'];?></td>	
											<?php
												$ptablename="repair_faults";
												$porderby = " ORDER BY fault ASC";
												$pwhere= " repair_id=$prfid";
												$pdatarc = $db->select($ptablename,$porderby, $pwhere);
												$faults ="";
												foreach ($pdatarc as $rows) {
													$faults = $rows['fault'] . "," . $faults;
												}
												/*
												$sql = "SELECT SUM(charges) AS charges FROM repair_faults pwhere repair_id = $prfid";
	
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
				if ($ppage > 1 ) {
				?>		
				<li>
					<a href="javascript:{}" onclick="javascript:ppreviousRecords();">Prev</a>
				</li>  
				<?php
				}
				?>				
				
				<?php
				for($i=1; $i <= $ptotalPages; $i++) {
					if($ppage==$i){
				?>
					<li class="active">
						<a href="javascript:{}" onclick="javascript:pjumpToRecords(<?php echo $i?>);"><?php echo $i?><span class="sr-only">(current)</span></a>
					</li>
				<?php } 
					else {
					?>
						<li>
							<a href="javascript:{}" onclick="javascript:pjumpToRecords(<?php echo $i?>);"><?php echo $i?></a>
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
					if ($ppage < $ptotalPages ) {
					?>		
					<li>
						<a href="javascript:{}" onclick="javascript:pnextRecords();">Next</a>
					</li>	
					<?php
					}
				?>
			</ul> 
		</div>	
	</div> 	
	
<script type="text/javascript">
	
	function pnextRecords() {
		
		var pcurrentPage = $('#pcurrentPage').val();
		pcurrentPage++;
							
		$.post("pending_list.php",{ppageNum:pcurrentPage},function(data){
			$('#pendinglist').html(data);
		});
		
	}
	
	function ppreviousRecords() {
		
		var pcurrentPage = $('#pcurrentPage').val();
		pcurrentPage--;
		
		$.post("pending_list.php",{ppageNum:pcurrentPage},function(data){
		
			$('#pendinglist').html(data);
		});
		
	}
	
	function pjumpToRecords(ppage) {
		
		$.post("pending_list.php",{ppageNum:ppage},function(data){
		
			$('#pendinglist').html(data);
		});
	}
		
	
</script>

</body>
</html> 

