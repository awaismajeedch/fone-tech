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
		
	$tablename="shops";
	$orderby = " ORDER BY created_at DESC";
	$where= "1=1";
	$rfid = 00;
	$recordsPerPage = 20;
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

<body>
	<input type="hidden" id="currentPage" value="<?=$page?>" />
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
						<th>Name</th>													
						<th>Contact Person</th>						
						<th>Cell#</th>
						<th>Email</th>
						<th>Address</th>						
						<th>Lab Name</th>	
						<th>Status</th>
						<!--<th>Action</th>-->
					</tr>
				</thead>
				<tbody>
					<?php if ($totalRecords > 0) {
							foreach ($datar as $row) {								
							
									?>	
										<tr>
											<?php $rfid = $row['id'];											
											$lbid = $row['labid'];
											$ulbid = $row['ulabid'];
											$labname= "";
											if ((!empty($lbid)) && ($lbid > 0))  {
												$sql = "SELECT name FROM labs where id = $lbid";	
												$datas = $db->selectQuery($sql);	
												foreach ($datas as $rows) {								
													$labname = $rows['name'];
												}	
											}						
											?>																		
											<td data-title="Name"><a href="#"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" onClick="javascript:editRecord('<?=$row['id']?>','<?=$row['name']?>','<?=$row['display_name']?>','<?=$row['contact_person']?>','<?=$row['address']?>','<?=$row['city']?>','<?=$row['contact']?>','<?=$row['cellno']?>','<?=$row['email']?>','<?=$row['labid']?>','<?=$labname;?>','<?=$row['status']?>');"><?php echo $row['name'];?></a></td>																														
											<td data-title="Contact Person"><?php echo $row['contact_person'];?></td>							
											<td data-title="Cell#"><?php echo $row['cellno'];?></td>	
											<td data-title="Email"><?php echo $row['email'];?></td>	
											<?php $address = $row['address']. ", " . $row['city']; ?> 
											<td data-title="Address"><?php echo $address ?></td>											
											<td data-title="Lab"><?php echo $labname ?></td>
											<td data-title="Status"><?php echo $row['status'];?></td>
											<!--<td><a href="javascript:confDelete('<?php echo $rfid; ?>');" ><img  src="images/minus.png" title="Delete Shop" style="width:20px; height:20px;" ></a></td>-->
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
							
		$.post("shops_list.php",{pageNum:currentPage},function(data){
			$('#shopslist').html(data);
		});
		
	}
	
	function previousRecords() {
		
		var currentPage = $('#currentPage').val();
		currentPage--;
		
		$.post("shops_list.php",{pageNum:currentPage},function(data){
		
			$('#shopslist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		
		$.post("shops_list.php",{pageNum:cpage},function(data){
		
			$('#shopslist').html(data);
		});
	}
	
	
	
	function editRecord(id,name,dispname,cname,address,city,contact,cell,email,lbid,lbname,status) {
		
		$('#collapseTwo').collapse('hide');	   
		$('#collapseOne').collapse('show');
		
		document.getElementById('txtname').value = name;		
		document.getElementById('txtdispname').value = dispname;		
		document.getElementById('txtcname').value = cname;		
		document.getElementById('txtaddress').value = address;
		document.getElementById('txtcity').value = city;												
		document.getElementById('txtcontact').value = contact;
		document.getElementById('txtcell').value = cell;
		document.getElementById('txtemail').value = email;		
		document.getElementById('cmblab').value = lbid;								
		document.getElementById('cmblab').text = lbname;
		document.getElementById('cmbstatus').text = status;
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

