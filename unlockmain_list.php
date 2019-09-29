<!DOCTYPE html>


<?php	
	//session_start();
	error_reporting(0);	
	
	//http://elvery.net/demo/responsive-tables/#no-more-tables
?>   

<?php
	include_once 'include/global.inc.php';
	//$compid  = $_SESSION['company_id'];
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
		$shopsql = " AND shop_id = '$txtshop'";		
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
	$where= "1=1 $shopsql $datesql $statussql $imisql";
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
	/*
	$sql = "SELECT SUM(labcharges) AS jobs,SUM(paid) AS paid FROM unlocks";
	
	$Sumdata = $db->selectQuery($sql);	
	
	foreach ($Sumdata as $cnt) {
		$sumfixed = $cnt['jobs'];
		$sumpaid = $cnt['paid'];
	}
	*/
	
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
				<!--<h4> Summary: <?php echo $sumfixed; ?> (Lab Charges) - <?php echo $sumpaid; ?> (Paid) = <?php echo ($sumfixed - $sumpaid); ?> (Balance)  </h4>-->
				<table class="table">
					<thead>
						<tr>							
							<th>Date</th>
							<th>Invoice</th>																															
							<th>Description</th>
							<th>IMEI</th>							
							<th>Status</th>
							<th>Duration</th>
							<th>Charges</th>							
							<th>Code</th>
							<th>Paid</th>
							<th>Balance</th>							
						</tr>
					</thead>
					<tbody>
						<?php if ($totalRecords > 0) {
								foreach ($datar as $row) {								
									$timestamp = strtotime($row['date_entered']);							
									$dateenter =  date("d/m/Y H:i", $timestamp);
									$shid = $row['shop_id'];
									if ($prevshid != $shid) {
										//$tablename="shops";
										//$orderby = " ORDER BY name ASC";
										//$where= " id=$shid";										
										//$datas = $db->select($tablename,$orderby, $where);									
										$sql = "SELECT shops.name AS Name, sum(charges) AS shcharges, sum(paid) as lpaid FROM unlocks, shops where unlocks.shop_id = shops.id AND  unlocks.shop_id = $shid group by shop_id";	
										$shdata = $db->selectQuery($sql);										
										foreach ($shdata as $sh) {
											$shname = $sh['Name'];
											$scharges = $sh['shcharges'];
											$lcharges = $sh['lpaid'];
										}	
											$profit = $scharges -  $lcharges;
										echo "<tr><td colspan='10'><b>Shop: $shname, Summary: $scharges (Charges) - $lcharges (Lab Paid) = $profit (Profit) </b></td></tr>";
									}		
											
									?>	
											<tr>
												<?php $rfid = $row['id'];?>																		
												<!--<td><a href="#"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" onClick="javascript:editRecord('<?=$row['id']?>','<?=$row['name']?>','<?=$row['contact_person']?>','<?=$row['address']?>','<?=$row['city']?>','<?=$row['contact']?>','<?=$row['cellno']?>','<?=$row['email']?>');"><?php echo $row['name'];?></a></td>-->											
												<!--<td data-title="Shop"><?php echo $shname;?></td>-->
												<td data-title="Date"><?php echo $dateenter;?></td>							
												<td data-title="Invoice"><?php echo $row['invoice'];?></td>																								
												<td data-title="Description"><?php echo $row['summary'];?></td>																								
												<td data-title="IMEI"><a href="javascript:confDeleteU('<?php echo $rfid; ?>');" style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" ><?php echo $row['imei'];?></a></td>													
												<td data-title="Status"><?php echo $row['status']; ?></td>
												<td data-title="Duration"><?php echo $row['duration']; ?></td>
												<td data-title="Charges"><?php echo $row['charges']; ?></td>												
												<td data-title="Code"><?php echo $row['code']; ?></td>	
												<?php  $bal = ($row['labcharges'] - $row['paid']); ?>																																																				
												<td data-title="Paid"><a data-toggle='modal' href='#modal-signin' style="font-size:14px; font-weight:bold; color:#483D8B; text-decoration:underline;" onclick="setData('<?php echo $row['id']; ?>','<?php echo $row['status']; ?>','<?php echo $row['charges']; ?>','<?php echo $bal . ".00"; ?>','<?php echo $row['notes']; ?>','<?php echo $row['paid']; ?>','<?php echo $row['duration']; ?>','<?php echo $row['imei']; ?>','<?php echo $row['siteref']; ?>');" ><?php echo $row['paid'] > 0 ? $row['paid'] :  "0.00"; ?></a></td>
												<?php  $bal = ($row['charges'] - $row['paid']); ?>
												<td data-title="Balance"><?php echo $bal . ".00"; ?></td>
												<!--<td><a href="javascript:confDelete('<?php echo $rfid; ?>');" ><img  src="images/minus.png" title="Delete Shop" style="width:20px; height:20px;" ></a></td>-->
											</tr>
													
										<?php 							
										$prevshid = $row['shop_id'];
								}	
							} else { ?>
							<tr>
								<td colspan="10">No Record Found</td>
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
								<label class="control-label" >IMEI: </label>
								<div class="controls">												
									<input  type="text"  name="txtuimei" id="txtuimei" class="input-large" value = "" disabled />																								
								</div>
							</div>								
							<div class="control-group">							
								<label class="control-label" >Status: </label>
								<div class="controls">	
									<input class="input-large" id="txtpstatus" name="txtpstatus" type="text" value="" disabled />									
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Notes: </label>
								<div class="controls">	
									<input class="input-large" id="txtnotes" name="txtnotes" type="text" value="" disabled />									
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Duration: </label>
								<div class="controls">	
									<input class="input-large" id="txtduration" name="txtduration" type="text" value=""  />									
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Site Ref: </label>
								<div class="controls">	
									<input class="input-large" id="txtref" name="txtref" type="text" value=""  readonly />									
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Charges: </label>
								<div class="controls">	
									<input class="input-large" id="txtcharges" name="txtcharges" type="text" value=""  />									
								</div>
							</div>														
							<div class="control-group">							
								<label class="control-label" >Balance: </label>
								<div class="controls">	
									<input class="input-large" id="txtbalance" name="txtbalance" type="text" value="" disabled />									
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Paid: </label>
								<div class="controls">	
									<input class="input-large" id="txtpaid" name="txtpaid" type="text" value="" />									
								</div>
							</div>
							<input type="hidden"  name="txtrepid" id="txtrepid" value="" >															
							<input type="hidden"  name="txtppaid" id="txtppaid" value="" >	
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
		var imi = $('#txtimi').val();
		
		currentPage++;
							
		$.post("unlockmain_list.php",{pageNum:currentPage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status,txtimi:imi},function(data){
			$('#unlockmainlist').html(data);
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
		
		$.post("unlockmain_list.php",{pageNum:currentPage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status,txtimi:imi},function(data){
			$('#unlockmainlist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		var shop = $('#txtshop').val();		
		var sdate = $('#txtsdate').val();		
		var edate = $('#txtedate').val();		
		var status = $('#txtstatus').val();
		var imi = $('#txtimi').val();
		
		$.post("unlockmain_list.php",{pageNum:cpage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status,txtimi:imi},function(data){
			$('#unlockmainlist').html(data);
		});
	}
	
	function setData(id,status,chg,bal,notes,paid,dur,imei,ref) {
				
		document.getElementById('txtrepid').value = id;		
		document.getElementById('txtuimei').value = imei;
		document.getElementById('txtpstatus').value = status;
		document.getElementById('txtduration').value = dur;		
		document.getElementById('txtcharges').value = chg;		
		document.getElementById('txtbalance').value = bal;	
		document.getElementById('txtnotes').value = notes;			
		document.getElementById('txtppaid').value = paid;	
		document.getElementById('txtref').value = ref;	
	}
	
	function validateBal() {
		var success = 1;			
    	
		if ( document.getElementById("txtbalance").value == "" ) {
		
				alert("Please enter Balance!");
				success = 0;
				return;
				
		}
		if (success == 1) {
			
			var serializedData = $('#bal_form').serialize();		
						
			$.post("updateunlockbal_controller.php",serializedData,function(data){
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
	function confDeleteU(uId) {
		 bol = confirm("Are you sure to delete this record?");
        if ( bol ) {
			$.post("delete_controller.php",{id:uId,type:'unlock'},function(data){				
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

