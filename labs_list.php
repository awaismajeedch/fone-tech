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
		
	$tablename="labs";
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

	<input type="hidden" id="currentPage" value="<?=$page?>" />
	<!--
	<div class="pull-right" > 
		<?php echo "Total Pages: " .$totalPages ?>
	</div>
	-->
    <div class="span12">
		<div class="table-responsive">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>Name</th>													
							<th>Contact Person</th>						
							<th>Contact#</th>
							<th>Cell#</th>
							<th>Email</th>
							<th>Address</th>
							<th>Lab Type</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($totalRecords > 0) {
								foreach ($datar as $row) {								
								
										?>	
											<tr>
												<?php $rfid = $row['id'];
													$ltype = $row['lab_type'];
												?>																		
												<td data-title="Name"><a href="#"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" onClick="javascript:editRecord('<?=$row['id']?>','<?=$row['name']?>','<?=$row['contact_person']?>','<?=$row['address']?>','<?=$row['city']?>','<?=$row['contact']?>','<?=$row['cellno']?>','<?=$row['email']?>','<?=$row['lab_type']?>');"><?php echo $row['name'] . $row['id'];?></a></td>																														
												<td data-title="Contact Person"><?php echo $row['contact_person'];?></td>							
												<td data-title="Contact#"><?php echo $row['contact'];?></td>
												<td data-title="Cell#"><?php echo $row['cellno'];?></td>	
												<td data-title="Email"><?php echo $row['email'];?></td>	
												<?php $address = $row['address']. ", " . $row['city']; ?> 
												<td data-title="Address"><?php echo $address ?></td>
												<td data-title="Lab Type"><?php echo $row['lab_type']; ?></td>
												<!--<td><a href="javascript:confDelete('<?php echo $rfid; ?>');" ><img  src="images/minus.png" title="Delete Shop" style="width:20px; height:20px;" ></a></td>-->
												<?php 
													$username = "";
													$lusername = "";
													$fusername = "";
													$user_id = "";
													
													$tablenamu="users";	
													$wheru="shop_id=$rfid AND user_type='lab' OR user_type='unlock'";
													$orderbu = " ORDER BY created_at ASC";
														
													$dataurs = $db->totalRecords($tablenamu, $wheru);
													//echo $data;		
													$totalRecordu = $dataurs;
													
													if ($totalRecordu > 0) {
														$dataru = $db->select($tablenamu, $orderbu, $wheru);	
														foreach ($dataru as $rowur) { 
															$lb_id = $rowur['shop_id']; 
															$lusername = $rowur['lastname']; 
															$fusername = $rowur['firstname']; 
															$username = $rowur['user_name']; 																			
															$user_id = $rowur['id']; 
														}
													}		
												?>			
												<td data-title="Action"><a data-toggle='modal' href='#modal-signuser' onclick="setData('<?php echo $rfid; ?>','<?php echo $lusername; ?>','<?php echo $fusername; ?>','<?php echo $username; ?>','<?php echo $user_id; ?>','<?php echo $ltype; ?>');"><img  src="images/usericon.png" title="Add/Edit Username" style="height:20px;width:20px;" ></a><?php echo $user_id; ?></td>											
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
<div class='modal hide fade' id='modal-signuser' role='dialog' tabindex='-1' style="width: 700px;position:fixed;">
	<div class='modal-header'>
		<button class='close' data-dismiss='modal' type='button'>&times;</button>
		<h3>Add/Edit User Profile</h3>
	</div>
	<div class='modal-body' >		
		<div class='controls text-center'>			
			<div class='form-wrapper'>
				<form name="users_form" id="users_form"  class="form-horizontal" action="" method="post" >										
					<div class="row-fluid" >	
						<div class="span8" >							
							<div class="control-group">							
								<label class="control-label" >Last Name: </label>
								<div class="controls">												
									<input  type="text"  name="txtlname" id="txtlname" class="input-large" value = ""/>																								
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >First Name: </label>
								<div class="controls">												
									<input  type="text"  name="txtfname" id="txtfname" class="input-large" value = ""/>																								
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >*Username: </label>
								<div class="controls">												
									<input  type="text"  name="txtuname" id="txtuname" class="input-large" value = ""/>																								
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >*Password: </label>
								<div class="controls">	
									<input class="input-large" id="txtpword" name="txtpword" type="password" value="" />									
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >*Confirm Password: </label>
								<div class="controls">	
									<input class="input-large" id="txtcpword" name="txtcpword" type="password" value="" />									
								</div>
							</div>													
							<input type="hidden"  name="txtuid" id="txtuid" value="" >								
							<input type="hidden"  name="txtipadd" id="txtipadd" value="" >								
							<input type="hidden"  name="cmbshop" id="cmbshop" value="" >								
							<input type="hidden"  name="cmbusertype" id="cmbusertype" value="" >	
						</div>						
					</div>	
				</form>
			</div>
		</div>
	</div>
	<div class='modal-footer'>		
		<a href="javascript:validateUser();" class="button_bar">Save</a>
	</div>
</div>

	
<script type="text/javascript">
	
	function nextRecords() {
		
		var currentPage = $('#currentPage').val();
		currentPage++;
							
		$.post("labs_list.php",{pageNum:currentPage},function(data){
			$('#labslist').html(data);
		});
		
	}
	
	function previousRecords() {
		
		var currentPage = $('#currentPage').val();
		currentPage--;
		
		$.post("labs_list.php",{pageNum:currentPage},function(data){
		
			$('#labslist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		
		$.post("labs_list.php",{pageNum:cpage},function(data){
		
			$('#labslist').html(data);
		});
	}
	
	
	
	function editRecord(id,name,cname,address,city,contact,cell,email,labtype) {
		
		$('#collapseTwo').collapse('hide');	   
		$('#collapseOne').collapse('show');
		
		document.getElementById('txtname').value = name;		
		document.getElementById('txtcname').value = cname;		
		document.getElementById('txtaddress').value = address;
		document.getElementById('txtcity').value = city;												
		document.getElementById('txtcontact').value = contact;
		document.getElementById('txtcell').value = cell;
		document.getElementById('txtemail').value = email;								
		document.getElementById('cmblabtype').value = labtype;								
		document.getElementById("txtid").value = id;	   	   
	}	
	
	
	function setData(lbid,luname,funame,uname,uidi,ltype) {
		
		//alert (lbid);
		document.getElementById('txtlname').value = luname;		
		document.getElementById('txtfname').value = funame;
		document.getElementById('txtuname').value = uname;		
		document.getElementById('txtuid').value = uidi;
		document.getElementById('cmbshop').value = lbid;
		document.getElementById('cmbusertype').value = ltype;
	
	}
	
	function validateUser() {
		var success = 1;			
    	
		if ( document.getElementById("txtuname").value == "" ) {
		
				alert("Please enter User Name!");
				success = 0;
				return;
				
		}
		
		if ( document.getElementById("txtuid").value == "" ) {	
			if ( document.getElementById("txtpword").value == "" ) {
				alert("Please enter Password!");
				success = 0;
				return;
				
			}
		}
			
		if ( document.getElementById('txtpword').value != "" ) {

				if ( document.getElementById('txtcpword').value == "") {
					alert("Please enter Confirm Password!");
					document.getElementById('txtcpword').focus();
					success = 0;
					return;
				}

				if ( document.getElementById('txtcpword').value != document.getElementById('txtpword').value) {
					alert("Incorrect confirm password!");
					document.getElementById('txtcpword').focus();
					success = 0;
					return;
				}
		}    
	
		if (success == 1) {
			
			var serializedData = $('#users_form').serialize();		
						
			$.post("users_controller.php",serializedData,function(data){
			   //alert(data);
			   if (data == 2 )	{		
					alert ("Username already exists!");									
														
				} else if (data == 1) {
					alert ("Data is saved successfully!");
					location.reload(); 	
				} else {
					alert ("Data could not be saved!");			
				}	
			});
			
		}	
	}
	
	
	function confDelete(uId,cid) {
		 bol = confirm("Are you sure to delete this record?");
        if ( bol ) {
			$.post("delete_controller.php",{id:uId,type:'lab'},function(data){
				if (data == 0 )	{		
					alert ("Unable to delete record!");									
				} else {
					window.location.reload();
				}	
				
			});
		}
	}	
	
</script>


