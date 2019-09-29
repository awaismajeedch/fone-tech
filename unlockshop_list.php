<!DOCTYPE html>

<?php
//error_reporting(0);	
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
	$tablename="unlocks";
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
						<th>IMEI</th>						
						<th>Summary</th>																			
						<th>Duration</th>
						<th>Notes</th>
						<th>Name</th>
						<th>Client Email</th>	
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
											<td data-title="Date"><?php echo $dateenter;?></td>							
											<td data-title="Invoice"><?php echo $row['invoice'];?></td>	
											<?php 
												$strinvoice =  $row['invoice'];												
												$strimei =  $row['imei']; 
												$strmodel =  json_encode($row['model']); 
												$strnetwork =  json_encode($row['network']); 
												$strunlockid =  $row['unlocks_id'];
												$strduration =  json_encode($row['duration']);												
												$strnotes =  json_encode($row['notes']);
												$strname =  json_encode($row['name']);
												$strcontact =  json_encode($row['contact']);
												$stremail =  json_encode($row['email']);																																	
												$strchg = json_encode($row['charges']);
												$strsummary =  json_encode($row['summary']);
												echo "<td data-title='IMEI'><a href='#' style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' onclick='setData($rfid,$strinvoice,$strimei,$strunlockid,$strduration,$strnotes,$strchg,$stremail,$strsummary,$strmodel,$strnetwork,$strname,$strcontact);'>$strimei</a></td>";
											?>														
											<td data-title="Summary"><?php echo $row['summary'];?></td>	
											<td data-title="Duration"><?php echo $row['duration'];?></td>
											<td data-title="Notes"><?php echo $row['notes'];?></td>	
											<td data-title="Name"><?php echo $row['name'];?></td>	
											<td data-title="Email"><?php echo $row['email'];?></td>	
											<td data-title="Charges"><?php echo $row['charges'];?></td>	
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
							
		$.post("unlockshop_list.php",{pageNum:currentPage},function(data){
			$('#unlockshoplist').html(data);
		});
		
	}
	
	function previousRecords() {
		
		var currentPage = $('#currentPage').val();
		currentPage--;
		
		$.post("unlockshop_list.php",{pageNum:currentPage},function(data){
		
			$('#unlockshoplist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		
		$.post("unlockshop_list.php",{pageNum:cpage},function(data){
		
			$('#unlockshoplist').html(data);
		});
	}
	
	function setData(rfid,invoice,imei,unlockid,duration,notes,chg,email,summary,model,network,name,contact) 
	{
		document.getElementById('txtid').value = rfid;
		document.getElementById('txtinvoice').value = invoice;
		document.getElementById('txtimei').value = imei;
		document.getElementById('txtmodel').value = model;
		document.getElementById('txtnetwork').value = network;
		document.getElementById('cmbservice').value = unlockid;
		document.getElementById('txtduration').value = duration;
		document.getElementById('txtnotes').value = notes;
		document.getElementById('txtcharges').value = chg;
		document.getElementById('txtemail').value = email;	
		document.getElementById('txtcsname').value = name;	
		document.getElementById('txtcontact').value = contact;	
		document.getElementById('txtsummary').value = summary;	
		document.getElementById("showdiv").style.visibility = 'visible';
		$('#collapseTwo').collapse('hide');	   
		$('#collapseOne').collapse('show');
	}
	
</script>

</body>
</html> 

