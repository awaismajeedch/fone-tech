<!DOCTYPE html>

<?php
//session_start();
error_reporting(0);
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
		
	$tablename="users";
	$orderby = " ORDER BY created_at DESC";
	$where= " user_name != 'superadmin' AND user_type != 'lab' AND user_type != 'unlock'";
	$rfid = 00;
	$recordsPerPage = 10;
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
	$shid = 0;
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
						<th>User Name</th>													
						<th>Last Name</th>						
						<th>First Name</th>
						<th>Shop Name</th>	
						<th>Machine IP</th>	
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($totalRecords > 0) {
							foreach ($datar as $row) {								
							
									?>	
										<tr>
											<?php $rfid = $row['id'];											
											$shid = $row['shop_id'];
											$userip = $row['user_ip'];
											$stdate = $row['start_date'];
											$eddate = $row['end_date'];
											
											
											if ($stdate == '0000-00-00')
												$stdate = "";	
												
											if ($eddate == '0000-00-00')
												$eddate = "";	
												
												
											if ((isset($userip)) && ($userip != 0)) {
												$userip = long2ip($row['user_ip']);
											} else {
												$userip = "";
											}	
											//$userip = $row['user_ip'];
											if ((!empty($shid)) && ($shid > 0))  {
												$sql = "SELECT name FROM shops where id = $shid";	
												$datas = $db->selectQuery($sql);	
												foreach ($datas as $rows) {								
													$shopname = $rows['name'];
												}	
											}																						
											?>																		
											<td data-title="User Name"><a href="#"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" onClick="javascript:editRecord('<?=$row['id']?>','<?=$row['shop_id']?>','<?=$row['lastname']?>','<?=$row['firstname']?>','<?=$row['user_name']?>','<?=$row['user_type']?>','<?=$shopname;?>','<?=$userip;?>','<?=$row['role'];?>','<?=$stdate;?>','<?=$eddate;?>');"><?php echo $row['user_name'];?></a></td>																														
											<td data-title="Last Name"><?php echo $row['lastname'];?></td>							
											<td data-title="First Name"><?php echo $row['firstname'];?></td>																						
											<td data-title="Shop Name"><?php echo $shopname;?></td>												
											<td data-title="Machine IP"><?php echo $userip;?></td>																						
											<td data-title="Action"><a href="javascript:confDelete('<?php echo $rfid; ?>');" ><img  src="images/minus.png" title="Delete Shop" style="width:20px; height:20px;" ></a></td>
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
							
		$.post("users_list.php",{pageNum:currentPage},function(data){
			$('#userslist').html(data);
		});
		
	}
	
	function previousRecords() {
		
		var currentPage = $('#currentPage').val();
		currentPage--;
		
		$.post("users_list.php",{pageNum:currentPage},function(data){
		
			$('#userslist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		
		$.post("users_list.php",{pageNum:cpage},function(data){
		
			$('#userslist').html(data);
		});
	}
	
	
	
	function editRecord(id,shid,lname,fname,uname,utype,shname,usip,role,sdate,edate) {
		
		$('#collapseTwo').collapse('hide');	   
		$('#collapseOne').collapse('show');
		
		document.getElementById('cmbshop').value = shid;								
		document.getElementById('cmbshop').text = shname;								
		document.getElementById('txtlname').value = lname;		
		document.getElementById('txtfname').value = fname;				
		document.getElementById('txtuname').value = uname;
		document.getElementById('cmbusertype').value = utype;								
		document.getElementById('txtipadd').value = usip;
		document.getElementById("txtuid").value = id;
		document.getElementById("txtrole").value = role;
		document.getElementById("txtsdate").value = sdate;
		document.getElementById("txtedate").value = edate;
		
	}	
	
	
	function confDelete(uId,cid) {
		 bol = confirm("Are you sure to delete this record?");
        if ( bol ) {
			$.post("delete_controller.php",{id:uId,type:'user'},function(data){
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

