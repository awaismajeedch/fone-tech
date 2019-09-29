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
	$shopid = $_SESSION['shop_id'];	
	$tablename="repairs";
	$orderby = " ORDER BY created_at DESC";
	$where= "shop_id=$shopid AND status='Inprogress'";
	
	$rfid = 00;
	$recordsPerPage = 10;
	$page = 1;	
	$recCnt = 1;	
	
	$totalPages = 0;	
	if ( isset ($_POST['pageNum'] ) ) {
		$page = $_POST['pageNum'];
	}
	
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

<body>
	<input type="hidden" id="currentPage" value="<?=$page?>" />
	<input type="hidden" id="recCnt" value="<?=$cnt?>" />
	<!--
	<div class="pull-right" > 
		<?php echo "Total Pages: " .$totalPages ?>
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
						<th>Password</th>
						<th>Faults</th>						
						<th>Notes</th>						
						<th>Charges</th>												
					</tr>
				</thead>
				<tbody>
					<?php if ($totalRecords > 0) {
							foreach ($datar as $row) {								
								$timestamp = strtotime($row['date_entered']);							
								$dateenter =  date("d/m/Y", $timestamp);
									?>	
										<tr>											
											<?php $rfid = $row['id'];?>																		
											<!--<td><a href="#"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" onClick="javascript:editRecord('<?=$row['id']?>','<?=$row['name']?>','<?=$row['contact_person']?>','<?=$row['address']?>','<?=$row['city']?>','<?=$row['contact']?>','<?=$row['cellno']?>','<?=$row['email']?>');"><?php echo $row['name'];?></a></td>-->											
											<td data-title="Date"><?php echo $dateenter;?></td>							
											<td data-title="Invoice"><?php echo $row['invoice'];?></td>							
											<td data-title="Model"><a href="updaterepairs.php?repid=<?php echo $rfid;?>"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;"><?php echo $row['model'];?></a></td>
											<td data-title="Make"><?php echo $row['make'];?></td>	
											<td data-title="IMEI"><?php echo $row['imei'];?></td>	
											<td data-title="Password"><?php echo $row['password'];?></td>	
											<?php
												$tablename="repair_faults";
												$orderby = " ORDER BY fault ASC";
												$where= " repair_id=$rfid";
												$datar = $db->select($tablename,$orderby, $where);
												$faults ="";
												foreach ($datar as $rows) {
													$faults = $rows['fault'] . "," . $faults;
												}
												/*
												$sql = "SELECT SUM(charges) AS charges FROM repair_faults where repair_id = $rfid";
	
												$value = $db->selectQuery($sql);	
												foreach ($value as $result) {
													$sum = $result['charges'];
												}
												*/
												
											?>											
											<td data-title="Faults"><?php echo $faults ?></td>			
											<td data-title="Notes"><?php echo $row['notes'] ?></td>	
											<td data-title="Charges"><?php echo $row['charges'] ?></td>
											<!--<td><a href="javascript:confDelete('<?php echo $rfid; ?>');" ><img  src="images/minus.png" title="Delete Shop" style="width:20px; height:20px;" ></a></td>-->
										</tr>
												
									<?php 																
							}	
						} else { ?>
						<tr>
							<td colspan="8">No Record Found</td>
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
				if ($page > 1 ) {
				?>		
				<li>
					<a href="javascript:{}" onclick="javascript:previousRecords();">Prev</a>
				</li>  
				<?php
				}
				?>				
				
				<?php
				for($i=1; $i <= $totalPages; $i++) {
					if($page==$i){
				?>
					<li class="active">
						<a href="javascript:{}" onclick="javascript:jumpToRecords(<?php echo $i?>);"><?php echo $i?><span class="sr-only">(current)</span></a>
					</li>
				<?php } 
					else {
					?>
						<li>
							<a href="javascript:{}" onclick="javascript:jumpToRecords(<?php echo $i?>);"><?php echo $i?></a>
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
					if ($page < $totalPages ) {
					?>		
					<li>
						<a href="javascript:{}" onclick="javascript:nextRecords();">Next</a>
					</li>	
					<?php
					}
				?>
			</ul> 
		</div>	
	</div> 	
	
<script type="text/javascript">
	
	function nextRecords() {
		
		var currentPage = $('#currentPage').val();
		currentPage++;
							
		$.post("repairs_list.php",{pageNum:currentPage},function(data){
			$('#repairslist').html(data);
		});
		
	}
	
	function previousRecords() {
		
		var currentPage = $('#currentPage').val();
		currentPage--;
		
		$.post("repairs_list.php",{pageNum:currentPage},function(data){
		
			$('#repairslist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		
		$.post("repairs_list.php",{pageNum:cpage},function(data){
		
			$('#repairslist').html(data);
		});
	}
	
	
	
	function editRecord(id,name,cname,address,city,contact,cell,email) {
		
		$('#collapseTwo').collapse('hide');	   
		$('#collapseOne').collapse('show');
		
		document.getElementById('txtname').value = name;		
		document.getElementById('txtcname').value = cname;		
		document.getElementById('txtaddress').value = address;
		document.getElementById('txtcity').value = city;												
		document.getElementById('txtcontact').value = contact;
		document.getElementById('txtcell').value = cell;
		document.getElementById('txtemail').value = email;								
		document.getElementById("txtid").value = id;	   	   
	}	
	
	
	function confDelete(uId,cid) {
		 bol = confirm("Are you sure to delete this record?");
        if ( bol ) {
			$.post("delete_controller.php",{id:uId,type:'shop'},function(data){
				if (data == 0 )	{		
					alert ("Unable to delete record!");									
				} else {
					window.location.reload();
				}	
				
			});
		}
	}	
	
</script>

</body>
</html> 

