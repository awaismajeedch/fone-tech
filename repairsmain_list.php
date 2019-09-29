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
	$txtinv = $_POST['txtinv'];
	$txtrefix = $_POST['txtrefix'];
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
	
	$invsql = "";
	if (!empty($txtinv)) {
		$invsql = " AND invoice = '$txtinv'";		
	}
	
	$refixsql = "";
	if (!empty($txtrefix)) {
		$refixsql = " AND make = '$txtrefix'";		
	}
	
	$tablename="repairs";
	$orderby = " ORDER BY created_at DESC";
	$where= "1=1 $shopsql $datesql $statussql $invsql $refixsql";
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
	$sql = "SELECT SUM(labcharges) AS jobs,SUM(paid) AS paid FROM repairs";
	
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
	<input type="hidden" name="txtrefix" id="txtrefix" value="<?php echo $txtrefix; ?>" />
	<input type="hidden" name="txtinv" id="txtinv" value="<?php echo $txtinv; ?>" />	
	
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
							<th>Model</th>																									
							<th>IMEI</th>
							<th>Refix</th>
							<th>Faults</th>
							<th>Status</th>
							<th>Sh Notes</th>
							<th>Lab Notes</th>
							<th>Sh Charges</th>
							<th>Lab Charges</th>
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
										$sql = "SELECT name AS Name, sum(charges) AS shcharges,  sum(labcharges) AS lcharges FROM repairs, shops where repairs.shop_id = shops.id AND  repairs.shop_id = $shid group by shop_id";	
										$shdata = $db->selectQuery($sql);										
										foreach ($shdata as $sh) {
											$shname = $sh['Name'];
											$scharges = $sh['shcharges'];
											$lcharges = $sh['lcharges'];											
										}	
											$profit = $scharges -  $lcharges;
										echo "<tr><td colspan='13'><b>Shop: $shname, Summary: $scharges (Shop Charges) - $lcharges (Lab Charges) = $profit (Profit) </b></td></tr>";
									}		
											
									?>	
											<tr>
												<?php $rfid = $row['id'];?>																		
												<!--<td><a href="#"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" onClick="javascript:editRecord('<?=$row['id']?>','<?=$row['name']?>','<?=$row['contact_person']?>','<?=$row['address']?>','<?=$row['city']?>','<?=$row['contact']?>','<?=$row['cellno']?>','<?=$row['email']?>');"><?php echo $row['name'];?></a></td>-->											
												<!--<td data-title="Shop"><?php echo $shname;?></td>-->
												<td data-title="Date"><?php echo $dateenter;?></td>	
												<?php 
													$pinv = $row['invoice'];
													$pdfpath = "pdfs/".$pinv.".pdf"; 												
												
												if (file_exists($pdfpath)) { ?>
													<td data-title="Invoice"><a href="<?php echo $pdfpath;?>" target="_blank" style="font-size:14px; font-weight:bold; color:#483D8B; text-decoration:underline;"><?php echo $pinv;?></a></td>							
												<?php } else { ?>
													<td data-title="Invoice"><?php echo $pinv;?></td>						
												<?php }	
												?>		
												<!--<td data-title="Invoice"><?php echo $row['invoice'];?></td>	-->											
												<td data-title="Model"><?php echo $row['model'];?></td>												
												<td data-title="IMEI"><a href="javascript:confDelete('<?php echo $rfid; ?>');" style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" ><?php echo $row['imei'];?></a></td>	
												<td data-title="Refix"><?php echo $row['make'];?></td>												
												<?php
													$tablename="repair_faults";
													$orderby = " ORDER BY fault ASC";
													$where= " repair_id=$rfid";
													$datar = $db->select($tablename,$orderby, $where);
													$faults="";
													foreach ($datar as $rows) {
														$faults = $rows['fault'] . "," . $faults;
													}													
												?>											
												<td data-title="Faults"><?php echo $faults ?></td>
												<td data-title="Status"><?php echo $row['status']; ?></td>
												<td data-title="Sh Notes"><?php echo $row['notes'] ?></td>
												<td data-title="Lab Notes"><?php echo $row['labnotes'] ?></td>
												<td data-title="Sh Charges"><?php echo $row['charges']; ?></td>
												<td data-title="Lab Charges"><?php echo $row['labcharges']; ?></td>
												<?php  $bal = ($row['labcharges'] - $row['paid']); ?>
												<td data-title="Paid"><a data-toggle='modal' href='#modal-signin' style="font-size:14px; font-weight:bold; color:#483D8B; text-decoration:underline;" onclick="setData('<?php echo $row['id']; ?>','<?php echo $row['password']; ?>','<?php echo $row['model']; ?>','<?php echo $faults; ?>','<?php echo $row['status']; ?>','<?php echo $row['charges']; ?>','<?php echo $bal . ".00"; ?>','<?php echo $row['notes']; ?>','<?php echo $row['paid']; ?>','<?php echo $row['labcharges']; ?>');" ><?php echo $row['paid'] > 0 ? $row['paid'] :  "0.00"; ?></a></td>
												<?php  $bal = ($row['labcharges'] - $row['paid']); ?>
												<td data-title="Balance"><?php echo $bal . ".00"; ?></td>
												<!--<td><a href="javascript:confDelete('<?php echo $rfid; ?>');" ><img  src="images/minus.png" title="Delete Shop" style="width:20px; height:20px;" ></a></td>-->
											</tr>
													
										<?php 							
										$prevshid = $row['shop_id'];
								}	
							} else { ?>
							<tr>
								<td colspan="13">No Record Found</td>
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
								<label class="control-label" >Password: </label>
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
								<label class="control-label" >Faults: </label>
								<div class="controls">	
									<input class="input-large" id="txtfaults" name="txtfaults" type="text" value=""  disabled />									
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
								<label class="control-label" >Shop Charges: </label>
								<div class="controls">	
									<input class="input-large" id="txtcharges" name="txtcharges" type="text" value="" disabled />									
								</div>
							</div>							
							<div class="control-group">							
								<label class="control-label" >Lab Charges: </label>
								<div class="controls">	
									<input class="input-large" id="txtlabcharges" name="txtlabcharges" type="text" value="" />									
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
		var inv = $('#txtinv').val();
		var refix = $('#txtrefix').val();
		
		currentPage++;
							
		$.post("repairsmain_list.php",{pageNum:currentPage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status,txtinv:inv,txtrefix:refix},function(data){
			$('#repairsmainlist').html(data);
		});
		
	}
	
	function previousRecords() {
		var shop = $('#txtshop').val();		
		var sdate = $('#txtsdate').val();		
		var edate = $('#txtedate').val();		
		var status = $('#txtstatus').val();
		var inv = $('#txtinv').val();
		var refix = $('#txtrefix').val();
		
		var currentPage = $('#currentPage').val();
		currentPage--;
		
		$.post("repairsmain_list.php",{pageNum:currentPage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status,txtinv:inv,txtrefix:refix},function(data){
			$('#repairsmainlist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		var shop = $('#txtshop').val();		
		var sdate = $('#txtsdate').val();		
		var edate = $('#txtedate').val();		
		var status = $('#txtstatus').val();
		var inv = $('#txtinv').val();
		var refix = $('#txtrefix').val();
		
		$.post("repairsmain_list.php",{pageNum:cpage,txtshop:shop,txtsdate:sdate,txtedate:edate,txtstatus:status,txtinv:inv,txtrefix:refix},function(data){
			$('#repairsmainlist').html(data);
		});
	}
	
	function setData(id,make,model,faults,status,chg,bal,notes,paid,lcharges) {
				
		document.getElementById('txtrepid').value = id;
		document.getElementById('txtmake').value = make;
		document.getElementById('txtmodel').value = model;
		document.getElementById('txtfaults').value = faults;
		document.getElementById('txtpstatus').value = status;
		document.getElementById('txtcharges').value = chg;		
		document.getElementById('txtbalance').value = bal;	
		document.getElementById('txtnotes').value = notes;	
		document.getElementById('txtlabcharges').value = lcharges;		
		document.getElementById('txtppaid').value = paid;	
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
						
			$.post("updatebal_controller.php",serializedData,function(data){
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
	function confDelete(uId,cid) {
		 bol = confirm("Are you sure to delete this record?");
        if ( bol ) {
			$.post("delete_controller.php",{id:uId,type:'repair'},function(data){
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

