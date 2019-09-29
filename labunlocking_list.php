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
	$txtimi = $_POST['txtimi'];
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
	
	$imisql = "";
	if (!empty($txtimi)) {
		$imisql = " AND imei like '%$txtimi%'";		
	}
	
	$tablename="unlocks";
	$orderby = " ORDER BY created_at DESC";
	$where= "lab_id=$lbid $shopsql $datesql $statussql $imisql";
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
	
	$sql = "SELECT SUM(charges) AS jobs,SUM(paid) AS paid FROM unlocks where lab_id=$lbid";
	
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
	<input type="hidden" name="txtimi" id="txtimi" value="<?php echo $txtimi; ?>" />
	
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
							<!--<th>Invoice</th>-->																															
							<th>IMEI</th>
							<th>Summary</th>
							<th>Duration</th>
							<th>Status</th>
							<th>Shop Comments</th>
							<th>Lab Notes</th>
							<th>Code</th>
							<th>Charges</th>
							<th>Paid</th>
							<!--<th>Action</th>-->
						</tr>
					</thead>
					<tbody>
						<?php if ($totalRecords > 0) {
								foreach ($datar as $row) {								
									$timestamp = strtotime($row['date_entered']);							
									$dateenter =  date("d/m/Y H:i", $timestamp);
																		
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
												<?php $rfid = $row['id'];
													  $unlocks_id = $row['unlocks_id']; 
													$tablename="unlock_data";
													$orderby = " ORDER BY summary ASC";
													$where= " id=$unlocks_id";
													$datar = $db->select($tablename,$orderby, $where);
													$duration="";
													foreach ($datar as $rows) {
														$duration = $rows['duration'];
													}									  
												?>																		
												<!--<td><a href="#"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" onClick="javascript:editRecord('<?=$row['id']?>','<?=$row['name']?>','<?=$row['contact_person']?>','<?=$row['address']?>','<?=$row['city']?>','<?=$row['contact']?>','<?=$row['cellno']?>','<?=$row['email']?>');"><?php echo $row['name'];?></a></td>-->																							
												<td data-title="Shop"><?php echo $shname;?></td>
												<td data-title="Date"><?php echo $dateenter;?></td>							
												<!--<td data-title="Invoice"><?php echo $row['invoice'];?></td>-->																								
												<?php $strid = $row['id'];													  													  
													  $strimei = $row['imei']; 
													  $strmodel =  json_encode($row['model']); 
													  $strnetwork =  json_encode($row['network']); 
													  $strsummary =  json_encode($row['summary']); 
													  $strduration =  $row['duration']; 
													  $strstatus =  json_encode($row['status']);													  
													  $strnotes =  json_encode($row['notes']);													  
													  $strlnotes =  json_encode($row['labnotes']);
													  $strcode =  json_encode($row['code']);													  
													  $strcharges =  json_encode($row['charges']);
													  $strpaid =  json_encode($row['paid']);
													  $strref =  json_encode($row['siteref']);
													  echo "<td data-title='IMEI'><a data-toggle='modal' href='#modal-signin' style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' onclick='setData($strid,$strref,$strimei,$strsummary,$strduration,$strstatus,$strnotes,$strlnotes,$strcode,$strmodel,$strnetwork,$shid,$strcharges,$strpaid);'>$strimei</a></td>";
												?>		
												<!--<td data-title="IMEI"><?php echo $row['imei'];?></td>-->
												<td data-title="Summary"><?php echo $row['summary'];?></td>																						
												<td data-title="Duration"><?php echo $duration ?></td>
												<td data-title="Status"><?php echo $row['status']; ?></td>
												<td data-title="Shop Comments"><?php echo $row['notes']; ?></td>											
												<td data-title="Lab Comments"><?php echo $row['labnotes']; ?></td>
												<td data-title="Code"><?php echo $row['code']; ?></td>
												<td data-title="Charges"><?php echo $row['charges']; ?></td>
												<td data-title="Paid"><?php echo $row['paid']; ?></td>
												
											</tr>
													
										<?php 							
								
								}	
							} else { ?>
							<tr>
								<td colspan="11">No Record Found</td>
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
		<h3>Add/Edit Code</h3>
	</div>
	<div class='modal-body' >		
		<div class='controls text-center'>			
			<div class='form-wrapper'>
				<form name="bal_form" id="bal_form" class="form-horizontal" action="" method="post" >										
					<div class="row-fluid" >	
						<div class="span8" >			
							
							<div class="control-group">							
								<label class="control-label" >IMEI: </label>
								<div class="controls">	
									<input class="input-large" id="txtime" name="txtime" type="text" value="" disabled />									
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Model: </label>
								<div class="controls">	
									<input class="input-large" id="txtmodel" name="txtmodel" type="text" value="" readonly />									
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Network: </label>
								<div class="controls">	
									<input class="input-large" id="txtnetwork" name="txtnetwork" type="text" value="" readonly />									
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Summary: </label>
								<div class="controls">	
									<input class="input-large" id="txtsummary" name="txtsummary" type="text" value=""  disabled />									
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Duration: </label>
								<div class="controls">	
									<input class="input-large" id="txtduration" name="txtduration" type="text" value=""  disabled />									
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label" >Notes: </label>
								<div class="controls">	
									<input class="input-large" id="txtnotes" name="txtnotes" type="text" value="" disabled />									
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Charges: </label>
								<div class="controls">	
									<input class="input-large" id="txtchg" name="txtchg" type="text" value="" readonly />									
								</div>
							</div>	
							<div class="control-group">							
								<label class="control-label">Status: </label>
								<div class="controls">												
									<select name="txtpstatus" id="txtpstatus" class="input-large" >											
										<option value="Inprogress">Inprogress</option>										
										<option value="Success">Success</option>										
										<option value="Rejected">Rejected</option>
									</select>	
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Code: </label>
								<div class="controls">	
									<input class="input-large" id="txtcode" name="txtcode" type="text" value="" />									
								</div>
							</div>		
							<div class="control-group">							
								<label class="control-label" >Ref Site: </label>
								<div class="controls">	
									<input class="input-large" id="txtref" name="txtref" type="text" value="" />									
								</div>
							</div>		
							<div class="control-group">							
								<label class="control-label" >Lab Notes: </label>
								<div class="controls">
									<textarea  name="txtlnotes" id="txtlnotes" class="input-large" ></textarea>
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Paid: </label>
								<div class="controls">	
									<input class="input-large" id="txtpaid" name="txtpaid" type="text" value="" />									
								</div>
							</div>
							<!--
							<label class="checkbox inline">
							  <input type="checkbox" name="chkpaid" id="chkpaid" value="paid" >Paid							 									  								
							</label>-->
							<!--	
							<div class="control-group" id="labcharges" >							
								<label class="control-label" >Lab Charges: </label>
								<div class="controls">	
									<input class="input-large" id="txtlabcharges" name="txtlabcharges" type="text" value="0" readonly />									
								</div>
							</div>
							-->
							<input type="hidden"  name="txtrepid" id="txtrepid" value="" >															
							<input type="hidden"  name="txtshid" id="txtshid" value="" >
							<input type="hidden"  name="txtppaid" id="txtppaid" value="" >	
							<!--<input type="hidden"  name="txtchg" id="txtchg" value="" >-->
							
						</div>						
					</div>	
				</form>
			</div>
		</div>
	</div>
	<div class='modal-footer'>		
		<a href="javascript:validateBal();" name="btnUlsave"  id="btnUlsave" class="button_bar">Save</a>
	</div>
</div>
	
<script type="text/javascript">
	function nextRecords() {
		
		var currentPage = $('#currentPage').val();
		var shop = $('#txtshop').val();		
		var sdate = $('#txtsdate').val();		
		var edate = $('#txtedate').val();		
		var status = $('#txtstatus').val();
		var imi = $('#txtimi').val();
		
		currentPage++;
							
		$.post("labunlocking_list.php",{pageNum:currentPage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status,txtimi:imi},function(data){
			$('#labunlockinglist').html(data);
		});
		
	}
	
	function previousRecords() {
		var shop = $('#txtshop').val();		
		var sdate = $('#txtsdate').val();		
		var edate = $('#txtedate').val();		
		var status = $('#txtstatus').val();
		var imi = $('#txtimi').val();
		
		var currentPage = $('#currentPage').val();
		currentPage--;
		
		$.post("labunlocking_list.php",{pageNum:currentPage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status,txtimi:imi},function(data){
			$('#labunlockinglist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		var shop = $('#txtshop').val();		
		var sdate = $('#txtsdate').val();		
		var edate = $('#txtedate').val();		
		var status = $('#txtstatus').val();
		var imi = $('#txtimi').val();
		
		$.post("labunlocking_list.php",{pageNum:cpage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status,txtimi:imi},function(data){
			$('#labunlockinglist').html(data);
		});
	}
	
	function setData(id,ref,imi,summary,duration,status,notes,lnotes,code,model,network,shid,chg,paid) {
		
		document.getElementById('txtrepid').value = id;
		document.getElementById('txtime').value = imi;				
		document.getElementById('txtmodel').value = model;				
		document.getElementById('txtnetwork').value = network;				
		document.getElementById('txtsummary').value = summary;
		document.getElementById('txtduration').value = duration;
		document.getElementById('txtpstatus').value = status;		
		document.getElementById('txtnotes').value = notes;
		document.getElementById('txtcode').value = code;				
		document.getElementById('txtlnotes').value = lnotes;				
		document.getElementById('txtshid').value = shid;
		document.getElementById('txtchg').value = chg;
		document.getElementById('txtppaid').value = paid;	
		document.getElementById('txtpaid').value = paid;	
		document.getElementById('txtref').value = ref;	
		//alert (paid);
		/*
		if ( paid < 1 ){
			document.getElementById("chkpaid").checked = false;
		} else {
			document.getElementById("chkpaid").checked = true;
		}	
				
		if (lcharges > 0) {
			document.getElementById('txtlabcharges').value = lcharges;
			document.getElementById('txtlabcharges').readOnly  = true;
		} else {
			document.getElementById('txtlabcharges').value = 0;
		}
		*/
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
    	
		if (document.getElementById("txtlnotes").value != "" )	{
			var mystring = document.getElementById("txtlnotes").value;
			//var parsed = mystring.replace(/\'/g,"");
			var parsed = mystring.replace(/["'&$@#%^!()*\\]/g, "");		
			//document.getElementById("txtlnotes").value = parsed;
			var xparsed = parsed.replace(/\//g,'-');				
			document.getElementById("txtlnotes").value = xparsed;
		
		}	
		
		if (success == 1) {
			document.getElementById("btnUlsave").style.visibility = 'hidden';
			var serializedData = $('#bal_form').serialize();		
						
			$.post("labunlocking_controller.php",serializedData,function(data){
			   //alert(data);
			   if (data > 0 ) {							
					alert ("Data is saved successfully!");
					location.reload(); 
				} else {
					alert ("Data could not be saved!");			
				}		
			  
			});
			document.getElementById("btnUlsave").style.visibility = 'visible';
		}	
	}	
	
</script>
 

