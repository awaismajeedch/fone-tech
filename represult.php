<!DOCTYPE html>

<?php	
	
	error_reporting(0);
	session_start();
	//9bb779c12578b514a415193870a23a47 	
?>   

<?php
	include_once 'include/global.inc.php';
	require_once 'include/conn.php';
	//$compid  = $_SESSION['company_id'];
	$shopid = $_SESSION['shop_id'];		
	$txtcst = "";
	$txtcon = "";
		
	$txtcst = $_POST['txtcst'];
	//$txtcon = $_POST['txtcon'];
		
	$txtcstsql = "";
	$txtcstsql = " AND shop_id = '$shopid'";		
	
	
		
	$imodelsql = "";
	if (!empty($txtcst)) {
		$imodelsql = " AND (invoice like '$txtcst%' OR make like '$txtcst%' OR customer_name like '%$txtcst%' OR contact_number like '$txtcst%' OR IMEI like '%$txtcst%') ";		
		$viewed = 0; 
	}
	
		
	$inetworksql = "";
	
	if (!empty($txtcon)) {
		$inetworksql = " AND contact_number like '%$txtcon%'";
		$viewed = 0;
	}
	
	
	$stablename="repsheet";
	$sorderby = " ORDER BY created_at DESC";
	$swhere= "1=1 $txtcstsql $imodelsql $inetworksql";
	//echo $swhere;
	
	$srfid = 00;
	$srecordsPerPage = 25;
	$spage = 1;	
	$stotalPages = 0;	
	if ( isset ($_POST['spageNum'] ) ) {
		$spage = $_POST['spageNum'];
	}
	
	$sdata = $db->totalRecords($stablename, $swhere);
	//echo $data;		
	$stotalRecords = $sdata;
	
	if ($stotalRecords != 0) {
		$stotalPages = ceil( $stotalRecords/$srecordsPerPage);
		if ( $spage >= $stotalPages ) {
			$spage = $stotalPages;
		}
		$sstartPage = ($spage - 1) * $srecordsPerPage;			
		// $sdata = $db->selectData($stablename, $swhere, $sorderby, $sstartPage, $srecordsPerPage);
		$sdata = $db->select($stablename, $sorderby, $swhere);
	}
?>	

	
	<input type="hidden" id="scurrentPage" value="<?php echo $spage; ?>" />
	<input type="hidden" name="txtcon" id="txtcon" value="<?php echo $txtcon; ?>" />
	<input type="hidden" name="txtcst" id="txtcst" value="<?php echo $txtcst; ?>" />	
	
	<!--<div class="pull-right" > 
		<?php echo "Total Pages: " .$stotalPages ?>
	</div>-->
	<style media="screen">
	div.dataTables_wrapper  div.dataTables_filter{
		width: 90%;
		margin-left: 5%;
		float: none;
		text-align: center;
	}
	div.dataTables_filter input{
		width: 80%;
	}

	table.dataTable tbody th, table.dataTable tbody td{
		text-align:center;
		font-weight:bold;
	}
	.dataTables_wrapper{
		width:95%;
	}
	.tab-content{
		overflow-x:hidden;
	}
	#myTable > tbody > tr > td{
		word-break:break-all;
	}
	</style>
	
    <div class="span12">
		<div class="table-responsive">
			<table class="table table-bordered" id="myTable">
				<thead>
					<tr>
						<th>Date</th>
						<th>Invoice</th>
						<th>Make & Model </th>
						<th>Customer Name </th>						
						<th>Contact</th>	
						<th>Password</th>
						<th>IMEI</th>
						<th>Faults</th>
						<th>Notes</th>
						<th>Action</th>	
					</tr>
				</thead>
				<tbody>
					<?php if ($stotalRecords > 0) {
							foreach ($sdata as $srow) { 
								echo "<tr>";
					?>	
						
							<?php $rid = $srow['id'];
							$timestamp = strtotime($srow['date_entered']);							
							$dateenter =  date("d/m/Y h:i", $timestamp);
							$invno = $srow['invoice'];
							$shid = $srow['shop_id'];							
							$shname = $mysqli->query("SELECT name from shops where id = $shid")->fetch_object()->name;
							
							/*
							$tablename="purchase";
							$orderby = " ORDER BY id ASC";
							$where= " id=$puid";
							$udata = $db->select($tablename,$orderby, $where);							
							foreach ($udata as $urow) {
								$pprice = $urow['price'];
							}
							*/	
							
							$pdfpath = "pdfs/".$invno."_R.pdf";
							
							if (file_exists($pdfpath)) { ?>
								<td data-title="Date"><a href="<?php echo $pdfpath;?>" target="_blank" style="font-size:14px; font-weight:bold; color:#483D8B; text-decoration:underline;"><?php echo $dateenter;?></a></td>							
							<?php } else { ?>
								<td data-title="Date"><?php echo $dateenter;?></td>						
							<?php }	
							?>			
							
							<td data-title="Invoice"><a href="repsheet.php?invno=<?php echo $invno;?>" style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;"><?php echo $invno;?></a></td>
							<td data-title="Make & model"><?php echo $srow['make']. " - " . $srow['model'] ;?></td>							
							<td data-title="Customer"><?php echo $srow['customer_name'];?></td>							
							<td data-title="contact_no"><?php echo $srow['contact_number'];?></td>
							<!--<td data-title="Exp. Return"><?php echo $srow['exreturn'];?></td>-->
							<td data-title="Password"><?php echo $srow['password'];?></td>
							<td data-title="IMEI"><?php echo $srow['imei'];?></td>
							<td data-title="Faults"><?php echo $srow['defects'];?></td>	
							<td data-title="Notes"><?php echo $srow['notes'];?></td>	
							<td data-title="Action">
								<a href="prepsheet.php?pid=<?php echo $rid;?>" target="_blank" ><img style="width:20px; height:20px;" title="Print Repair Sheet" src="images/print.png"></a>
								<!--<a href="<?php echo $pdfpath;?>" target="_blank" ><img style="width:20px; height:20px;" title="Print Repair Sheet" src="images/print.png"></a>-->
								<!--<a href="javascript:confsDelete('<?php echo $rid; ?>');"><img style="width:20px; height:20px;" title="Delete Record" src="images/minus.png"></a>-->
								<!--<a href="javascript:confsDelete('<?php echo $rid; ?>');"><img style="width:20px; height:20px;" title="Send Email" src="images/email.png"></a>-->
								<a data-toggle='modal' href='#modal-semail' onclick="javascript:setrId('<?php echo $rid; ?>');"><img style="width:20px; height:20px;" title="Send Email" src="images/email1.png"></a>
							</td>		
						</tr>
					<?php 							
							
						}	
					} else { ?>
						<tr>
							<td colspan="9">No Record Found</td>
						</tr>	
					<?php
					}		
					?>  
				</tbody>
			</table>
		</div>
		
		<!-- <div class="pagination pagination-centered" >
			<ul>
				<?php
				if ($spage > 1 ) {
				?>		
				<li>
					<a href="javascript:{}" onclick="javascript:spreviousRecords();">Prev</a>
				</li>  
				<?php
				}
				?>				
				
				<?php
				for($i=1; $i <= $stotalPages; $i++) {
					if($spage==$i){
				?>
					<li class="active">
						<a href="javascript:{}" onclick="javascript:sjumpToRecords(<?php echo $i?>);"><?php echo $i?><span class="sr-only">(current)</span></a>
					</li>
				<?php } 
					else {
					?>
						<li>
							<a href="javascript:{}" onclick="javascript:sjumpToRecords(<?php echo $i?>);"><?php echo $i?></a>
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
					if ($spage < $stotalPages ) {
					?>		
					<li>
						<a href="javascript:{}" onclick="javascript:snextRecords();">Next</a>
					</li>	
					<?php
					}
				?>
			</ul> 
		</div>	 -->
	</div> 
<div class='modal hide fade' id='modal-semail' role='dialog' tabindex='-1' style="width: 700px;">
	<div class='modal-header'>
		<button class='close' data-dismiss='modal' type='button'>&times;</button>
		<h3>Enter Email</h3>
	</div>
	<div class='modal-body' >		
		<div class='controls text-center'>			
			<div class='form-wrapper'>
				<form name="mail_form" id="mail_form" class="form-horizontal" action="" method="post" >										
					<div class="row-fluid" >	
						<div class="span8" >										
							<div class="control-group">							
								<label class="control-label" >Email Address: </label>
								<div class="controls">
									<input type="text"  name="txtsemail" id="txtsemail" class="input-large" />
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
		<a href="javascript:sendMail();" class="button_bar">Send Email</a>
	</div>
</div>
	
<!-- <script src=""></script> -->
<script type="text/javascript">

			$(document).ready( function () {
			$('#myTable').DataTable({
				// searching:false,
				// ordering:false,
				// bPaginate:false,
				bLengthChange:false,
				ordering : false,
				language: {
					// search: "_INPUT_",
	        searchPlaceholder: "Please enter Invoice or Make or Customer name or Contact",
				},
			});
			});
	
	function snextRecords() {
		
		var currentPage = $('#scurrentPage').val();
		var stxtcon = $('#txtcon').val();		
		var stxtcst = $('#txtcst').val();
		
		currentPage++;
							
		$.post("represult.php",{spageNum:currentPage,txtcon:stxtcon,txtcst:stxtcst},function(data){
			$('#represult').html(data);
		});
		
	}
	
	function spreviousRecords() {
		var stxtcon = $('#txtcon').val();		
		var stxtcst = $('#txtcst').val();
		var currentPage = $('#scurrentPage').val();
		currentPage--;
		
		$.post("represult.php",{spageNum:currentPage,txtcon:stxtcon,txtcst:stxtcst},function(data){
		
			$('#represult').html(data);
		});
		
	}
	
	function sjumpToRecords(cpage) {
		var stxtcon = $('#txtcon').val();		
		var stxtcst = $('#txtcst').val();
		
		$.post("represult.php",{spageNum:cpage,txtcon:stxtcon,txtcst:stxtcst},function(data){
			//alert(data);
			$('#represult').html(data);
		});
	}
	
	function confsDelete(uId) {
		 bol = confirm("Are you sure to delete this record?");
        if ( bol ) {
			$.post("delete_controller.php",{id:uId,type:'sale'},function(data){
				if (data == 0 )	{		
					alert ("Unable to delete record!");									
				} else {
					window.location.reload();
				}	
				
			});
		}
	}	
	function Setid(rjid) {
		document.getElementById('txtrejid').value = rjid;
	}
	
	function updateRInform() {
		
			//var informed = document.getElementById('txtrec').checked;
			var e = document.getElementById('txtrec');
			var informed = e.options[e.selectedIndex].value;
			
			var repid = document.getElementById('txtrejid').value;	
			
			$.post("updatereceived_controller.php",{chkrejinformed:informed, txtrejid:repid},function(data){
			   //alert(data);
			   if (data > 0 ) {							
					alert ("Data is saved Successfully!");
					$('#recmodal').modal('hide');
					DivRefreshrj();
					//location.reload(); 
				} else {
					alert ("Data could not be saved! Please try again later");			
					//location.reload(); 
				}		
			  
			});
		
	}

	function DivRefreshrj() {
		var pcurrentPage = $('#scurrentPage').val();
		
		$.post("represult.php",{cpageNum:pcurrentPage},function(data){
			$('#represult').html(data);
		});
    }
	function setrId(repid) {
		document.getElementById("txtrepid").value = repid;	
	}
	function sendMail() {
		var success = 1;			
    	
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var address = document.getElementById('txtsemail').value;
		if(reg.test(address) == false) {
		  alert("Please enter valid Email!");		  
		  success = 0;
		  return;
		}
		
		if (success == 1) {
			
			var serializedData = $('#mail_form').serialize();		
						
			$.post("repsheetmail.php",serializedData,function(data){
			   //alert(data);
			   if (data > 0 ) {							
					alert ("Email is sent successfully!");
					$('#modal-semail').modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();				
				} else {
					alert ("Email could not be sent!");			
				}		
			  
			});
			
		}	
	}	
</script>

</body>
</html> 

