<!DOCTYPE html>

<?php
error_reporting(0);	
//session_start();
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
		
	$tablename="unlock_data";
	$orderby = " ORDER BY network";
	$where= "1=1";
	$rfid = 00;
	$recordsPerPaged = 50;
	$paged = 1;	
	$totalPages = 0;	
	if ( isset ($_POST['pageNum'] ) ) {
		$paged = $_POST['pageNum'];
	}
	
	$data = $db->totalRecords($tablename, $where);
	//echo $data;		
	$totalRecords = $data;
	
	if ($totalRecords != 0) {
		$totalPages = ceil( $totalRecords/$recordsPerPaged);
		if ( $paged >= $totalPages ) {
			$paged = $totalPages;
		}
		$startPage = ($paged - 1) * $recordsPerPaged;			
		$datar = $db->selectData($tablename, $where, $orderby, $startPage, $recordsPerPaged);
	}
?>	

<body>
	<input type="hidden" id="currentPaged" value="<?=$paged?>" />
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
						<th>Summary</th>													
						<th>Description</th>						
						<th>Charges</th>
						<th>Duration</th>						
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($totalRecords > 0) {
							foreach ($datar as $row) {								
									$rfid = $row['id'];
									$strsummary = json_encode($row['summary']);
									$strdescription = json_encode($row['description']);
									$strprice = $row['price'];
									$strduration = $row['duration'];
									$strnetwork = json_encode($row['network']);
									if ($oldstrnetwork !== $strnetwork) {
										$str = trim($strnetwork, '"');
										echo "<tr style='font-size:14px; font-weight:bold; color:#003366;'><th colspan='5'>$str</th></tr>"; 
									}	
									?>	
										<tr>
										<?php echo "<td data-title='Smmary'><a href='#'  style='font-size:12px; font-weight:bold; color:#DE5050; text-decoration:underline;' onClick='javascript:editRecord($rfid,$strsummary,$strdescription,$strprice,$strduration,$strnetwork);'>".$row['summary']."</a></td>";?>																														
											<td data-title="Description"><?php echo $row['description'];?></td>							
											<td data-title="Charges"><?php echo $row['price'];?></td>
											<td data-title="Duration"><?php echo $row['duration'];?></td>												
											<td><a href="javascript:confDelete('<?php echo $rfid; ?>');" ><img  src="images/minus.png" title="Delete Record" style="width:20px; height:20px;" ></a></td>
										</tr>
												
									<?php 							
									$oldstrnetwork = json_encode($row['network']);
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
				if ($paged > 1 ) {
				?>		
				<li>
					<a href="javascript:{}" onclick="javascript:previousRecords();">Prev</a>
				</li>  
				<?php
				}
				?>				
				
				<?php
				for($i=1; $i <= $totalPages; $i++) {
					if($paged==$i){
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
					if ($paged < $totalPages ) {
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
		
		var currentPaged = $('#currentPaged').val();
		currentPaged++;
							
		$.post("unlockdata_list.php",{pageNum:currentPaged},function(data){
			$('#unlockdatalist').html(data);
		});
		
	}
	
	function previousRecords() {
		
		var currentPaged = $('#currentPaged').val();
		currentPaged--;
		
		$.post("unlockdata_list.php",{pageNum:currentPaged},function(data){
		
			$('#unlockdatalist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		
		$.post("unlockdata_list.php",{pageNum:cpage},function(data){
		
			$('#unlockdatalist').html(data);
		});
	}
	
	
	
	function editRecord(id,summ,desc,price,chg,nwork) {
		//alert (chg);
		document.getElementById('txtsummary').value = summ;				
		document.getElementById('txtprice').value = price;
		document.getElementById('txtdurations').value = chg;																				
		document.getElementById("txtid").value = id;	   	   	
		document.getElementById('txtdescription').value = desc;	
		document.getElementById('txtnetwork').value = nwork;	
		$('#collapseuTwo').collapse('hide');	   
		//$('#collapseuOne').collapse('show');
	}	
	
	
	function confDelete(uId) {
		 bol = confirm("Are you sure to delete this record?");
        if ( bol ) {
			$.post("delete_controller.php",{id:uId,type:'unlockdata'},function(data){
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

