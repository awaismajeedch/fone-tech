<!DOCTYPE html>

<?php	
error_reporting(0);	
session_start();
		
?>   

<?php
	include_once 'include/global.inc.php';
	$lbid  = $_SESSION['shop_id'];	
	$shop = "";
	
	
	$txtshop = $_POST['txtshop'];
	$txtsdate = $_POST['txtsdate'];
	$txtedate = $_POST['txtedate'];
	$txtstatus = $_POST['txtstatus'];
	//echo $txtshop;
	//echo $txtsdate;
	//echo $txtedate;
	//echo $txtstatus;
	
	$shopsql = "";
	if (!empty($txtshop)) {
		$shopsql = " AND shop_id = $txtshop";		
	}
	
	$datesql = "";
	if ((!empty($txtsdate)) && (!empty($txtedate)))  {
	
		$datearray = explode("/",$txtsdate);
		$activefrom = $datearray[2]."-".$datearray[1]."-".$datearray[0];
		$stdate = "$activefrom";
		
		$datearray1 = explode("/",$txtedate);
		$activeto = $datearray1[2]."-".$datearray1[1]."-".$datearray1[0];
		$eddate = "$activeto";	
		
		$datesql = " AND DATE(date_entered) between '$stdate' AND '$eddate'";		
		
	}
	$statussql = "";
	if (!empty($txtstatus)) {
		$statussql = " AND status = '$txtstatus'";		
	}
	
	$tablename="repairs";
	$orderby = " ORDER BY created_at DESC";
	$where= "lab_id=$lbid $shopsql $datesql $statussql";
	//echo $where;
	
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
	
	$sql = "SELECT SUM(labcharges) AS jobs,SUM(paid) AS paid FROM repairs";
	
	$Sumdata = $db->selectQuery($sql);	
	
	foreach ($Sumdata as $cnt) {
		$sumfixed = $cnt['jobs'];
		$sumpaid = $cnt['paid'];
	}
?>	

	
	<input type="hidden" id="currentPage" value="<?php echo $page; ?>" />
	<input type="hidden" name="txtshop" id="txtshop" value="<?php echo $txtshop; ?>" />
	<input type="hidden" name="txtsdate" id="txtsdate" value="<?php echo $txtsdate; ?>" />
	<input type="hidden" name="txtedate" id="txtedate" value="<?php echo $txtedate; ?>" />	
	<input type="hidden" name="txtstatus" id="txtstatus" value="<?php echo $txtstatus; ?>" />	
	
	<!--<div class="pull-right" > 
		<?php echo "Total Pages: " .$totalPages ?>
	</div>-->
	
    <div class="span12">
		<div class="table-responsive">
			<div class="table-responsive">
				<h4> Summary: <?php echo $sumfixed; ?> (Charges) - <?php echo $sumpaid; ?> (Paid) = <?php echo ($sumfixed - $sumpaid); ?> (Balance)  </h4>
				<table class="table">
					<thead>						
						<tr>
							<th>Shop</th>							
							<th>Date</th>
							<th>Invoice</th>
							<th>Model</th>																									
							<th>IMEI</th>
							<th>Faults</th>
							<th>Status</th>
							<th>Shop Comments</th>
							<th>Lab Charges</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($totalRecords > 0) {
								foreach ($datar as $row) {								
									$timestamp = strtotime($row['date_entered']);							
									$dateenter =  date("d/m/Y", $timestamp);
									$shid = $row['shop_id'];
									$tablename="shops";
									$orderby = " ORDER BY name ASC";
									$where= " id=$shid";	
									$datas = $db->select($tablename,$orderby, $where);									
									foreach ($datas as $sh) {
										$shname = $sh['name'];
									}	
										?>	
											<tr>
												<?php $rfid = $row['id'];?>																		
												<!--<td><a href="#"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" onClick="javascript:editRecord('<?=$row['id']?>','<?=$row['name']?>','<?=$row['contact_person']?>','<?=$row['address']?>','<?=$row['city']?>','<?=$row['contact']?>','<?=$row['cellno']?>','<?=$row['email']?>');"><?php echo $row['name'];?></a></td>-->																							
												<td data-title="Shop"><?php echo $shname;?></td>
												<td data-title="Date"><?php echo $dateenter;?></td>							
												<td data-title="Invoice"><?php echo $row['invoice'];?></td>												
												<td data-title="Model"><?php echo $row['model'];?></td>												
												<td data-title="IMEI"><?php echo $row['imei'];?></td>	
												<?php
													$tablename="repair_faults";
													$orderby = " ORDER BY fault ASC";
													$where= " repair_id=$rfid";
													$datar = $db->select($tablename,$orderby, $where);
													$faults="";
													foreach ($datar as $rows) {
														$faults = $rows['fault'] . "," . $faults;
													}
													$faults = rtrim($faults, ",")
													/*
													$sql = "SELECT SUM(charges) AS charges FROM repair_faults where repair_id = $rfid";
		
													$value = $db->selectQuery($sql);	
													foreach ($value as $result) {
														$sum = $result['charges'];
													}
													*/
												?>											
												<td data-title="Faults"><?php echo $faults ?></td>
												<td data-title="Status"><?php echo $row['status']; ?></td>
												<td data-title="Shop Comments"><?php echo $row['notes']; ?></td>
												<td data-title="Lab Charges"><?php echo $row['labcharges']; ?></td>																								
												<td data-title="Action"><a data-toggle='modal' href='#modal-signin' style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" onclick="setData('<?php echo $row['id']; ?>','<?php echo addslashes($row['make']); ?>','<?php echo addslashes($row['model']); ?>','<?php echo addslashes($faults); ?>','<?php echo $row['status']; ?>','<?php echo addslashes(trim($row['notes']));?>','<?php echo addslashes($row['imei']); ?>','<?php echo addslashes($row['labnotes']); ?>','<?php echo $row['labcharges']; ?>');" ><img src="images/add.png"></a></td>
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
		
		<div class="pagination pagination-centered" >
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
<div class='modal hide fade' id='modal-signin' role='dialog' tabindex='-1' style="width: 700px;">
	<div class='modal-header'>
		<button class='close' data-dismiss='modal' type='button'>&times;</button>
		<h3>Add/Edit Balance</h3>
	</div>
	<div class='modal-body' >		
		<div class='controls text-center'>			
			<div class='form-wrapper'>
				<form name="bal_form" id="bal_form" class="form-horizontal" action="" method="post" >										
					<div class="row-fluid" >	
						<div class="span8" >							
							<div class="control-group">							
								<label class="control-label" >Make: </label>
								<div class="controls">												
									<input  type="text"  name="txtmake" id="txtmake" class="input-large" value = "" disabled />																								
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Model: </label>
								<div class="controls">	
									<input class="input-large" id="txtmodel" name="txtmodel" type="text" value="" disabled />									
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >IMEI: </label>
								<div class="controls">	
									<input class="input-large" id="txtime" name="txtime" type="text" value="" disabled />									
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Faults: </label>
								<div class="controls">	
									<input class="input-large" id="txtfaults" name="txtfaults" type="text" value=""  disabled />									
								</div>
							</div>							
							<div class="control-group">							
								<label class="control-label" >Notes: </label>
								<div class="controls">	
									<input class="input-large" id="txtnotes" name="txtnotes" type="text" value="" disabled />									
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label">Status: </label>
								<div class="controls">												
									<select name="txtpstatus" id="txtpstatus" class="input-large" onchange="javascript:showPrice();" >											
										<option value="Inprogress">Inprogress</option>
										<option value="Pending">Pending</option>
										<option value="Fixed">Fixed</option>
										<option value="NotFixed">Not Fixed</option>
									</select>	
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Lab Notes: </label>
								<div class="controls">
									<textarea  name="txtlnotes" id="txtlnotes" class="input-large" ></textarea>
								</div>
							</div>	
							<div class="control-group" id="labcharges" >							
								<label class="control-label" >Lab Charges: </label>
								<div class="controls">	
									<input class="input-large" id="txtlabcharges" name="txtlabcharges" type="text" value="0" readonly />									
								</div>
							</div>
							<input type="hidden"  name="txtrepid" id="txtrepid" value="" >															
							
						</div>						
					</div>	
				</form>
			</div>
		</div>
	</div>
	<div class='modal-footer'>		
		<a href="javascript:validateBal();" class="button_bar">Save</a>
	</div>
</div>
	
<script type="text/javascript">
	function nextRecords() {
		
		var currentPage = $('#currentPage').val();
		var shop = $('#txtshop').val();		
		var sdate = $('#txtsdate').val();		
		var edate = $('#txtedate').val();		
		var status = $('#txtstatus').val();
		
		currentPage++;
							
		$.post("labrepairs_list.php",{pageNum:currentPage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status},function(data){
			$('#labrepairslist').html(data);
		});
		
	}
	
	function previousRecords() {
		var shop = $('#txtshop').val();		
		var sdate = $('#txtsdate').val();		
		var edate = $('#txtedate').val();		
		var status = $('#txtstatus').val();
		var currentPage = $('#currentPage').val();
		currentPage--;
		
		$.post("labrepairs_list.php",{pageNum:currentPage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status},function(data){
			$('#labrepairslist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		var shop = $('#txtshop').val();		
		var sdate = $('#txtsdate').val();		
		var edate = $('#txtedate').val();		
		var status = $('#txtstatus').val();
		
		$.post("labrepairs_list.php",{pageNum:cpage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status},function(data){
			$('#labrepairslist').html(data);
		});
	}
	
	function setData(id,make,model,faults,status,notes,imi,lnotes,lcharges) {
		
		document.getElementById('txtrepid').value = id;
		document.getElementById('txtmake').value = make;
		document.getElementById('txtmodel').value = model;
		document.getElementById('txtfaults').value = faults;
		document.getElementById('txtpstatus').value = status;		
		if (notes != "") {
			document.getElementById('txtnotes').value = notes;
		} else {
			document.getElementById('txtnotes').value = "";
		}	
		
		document.getElementById('txtime').value = imi;				
		document.getElementById('txtlnotes').value = lnotes;
		
		if (lcharges > 0) {
			document.getElementById('txtlabcharges').value = lcharges;
			document.getElementById('txtlabcharges').readOnly  = true;
		} else {
			document.getElementById('txtlabcharges').value = 0;
		}
		//if (!lnotes) {
			
		//} else {
			//document.getElementById('txtlnotes').value = "";
		//}	
		//document.getElementById('txtlabnotes').value = lnotes;	
	}
	
	function showPrice() {
		var labch = document.getElementById('txtlabcharges').value; 
		if (document.getElementById('txtpstatus').value == "Fixed") {
				if ( labch > 0 ) {
					document.getElementById('txtlabcharges').readOnly  = true;
				} else {			
					document.getElementById('txtlabcharges').readOnly  = false;
				}
		} else {			
			document.getElementById('txtlabcharges').readOnly  = true;
		}			
		
	} 
	
	function validateBal() {
		var success = 1;			
    	
		
		if (success == 1) {
			
			var serializedData = $('#bal_form').serialize();		
						
			$.post("labrepairs_controller.php",serializedData,function(data){
			   //alert(data);
			   if (data > 0 ) {							
					alert ("Data is saved successfully!");
					location.reload(); 
				} else {
					alert ("Data could not be saved!");			
				}		
			  
			});
			
		}	
	}	
	
</script>
 

