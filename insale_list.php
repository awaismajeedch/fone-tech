<!DOCTYPE html>

<?php	
	//session_start();
	error_reporting(0);
	//9bb779c12578b514a415193870a23a47 	
?>   

<?php
	include_once 'include/global.inc.php';
	require_once 'include/conn.php';
	//$compid  = $_SESSION['company_id'];
	//$shid  = $_SESSION['ishop_id'];	
	$ishop = "";
	$imake = "";
	$imodel = "";
	$inetwork = "";
	$irec = "";
	$irange = "";
	
	$ishop = $_POST['ishop'];
	$imake = $_POST['imake'];
	$imodel = $_POST['imodel'];
	$inetwork = $_POST['inetwork'];
	$irec = $_POST['cmbrec'];
	$irange = $_POST['irange'];
	$range_start = date('Y-m-1');
	$range_end = date('Y-m-d');

	$irangesql = "";
	if(!empty($irange)){
		$total_range = explode('-',$irange);
		$range_start = date('Y-m-d',strtotime($total_range[0]));
		$range_end = date('Y-m-d',strtotime($total_range[1]));
		$irangesql = " AND date_entered >= '$range_start:00:00:00' AND date_entered <= '$range_end:23:59:59' ";
		}
		else{
			$irangesql = " AND date_entered >= '$range_start:00:00:00' AND date_entered <= '$range_end:23:59:59' ";
		}
	
	$ishopsql = "";
	if (!empty($ishop)) {
		$ishopsql = " AND shop_id = '$ishop'";		
	}
	
	$imakesql = "";
	if (!empty($imake)) {
		$imakesql = " AND make like '%$imake%'";
		$viewed = 0;
	}
	
	$imodelsql = "";
	if (!empty($imodel)) {
		$imodelsql = " AND model like '%$imodel%'";		
		$viewed = 0; 
	}
	$inetworksql = "";
	
	if (!empty($inetwork)) {
		$inetworksql = " AND imei = '$inetwork'";
		$viewed = 0;
	}
	
	$irecsql = "";
	
	if (!empty($irec)) {
		$irecsql = " AND payment_received = '$irec'";
		$viewed = 0;
	}
	
	$stablename="sale";
	$sorderby = " ORDER BY created_at DESC";
	$swhere= "1=1 $ishopsql $imakesql $imodelsql $inetworksql $irecsql $irangesql";
	//echo $where;
	
	$srfid = 00;
	$srecordsPerPage = 10;
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
		$sdata = $db->selectData($stablename, $swhere, $sorderby, $sstartPage, $srecordsPerPage);
		$sum_only = $mysqli->query("SELECT sum(price) as sum_only from sale where ".$swhere)->fetch_object()->sum_only;
		echo "<p style='font-weight:bold;font-size:20px;margin:15px;color:black;'>Total Selling Price = &pound".$sum_only."</p>";
	}
?>	

	
	<input type="hidden" id="scurrentPage" value="<?php echo $spage; ?>" />
	<input type="hidden" name="txtimakes" id="txtimakes" value="<?php echo $imake; ?>" />
	<input type="hidden" name="txtimodels" id="txtimodels" value="<?php echo $imodel; ?>" />
	<input type="hidden" name="txtinetworks" id="txtinetworks" value="<?php echo $inetwork; ?>" />	
	<input type="hidden" name="txtishop" id="txtishop" value="<?php echo $ishop; ?>" />	
	<input type="hidden" name="txtirange" id="txtirange" value="<?php echo $irange; ?>" />	
	
	<!--<div class="pull-right" > 
		<?php echo "Total Pages: " .$stotalPages ?>
	</div>-->
	
    <div class="span11">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Date</th>
						<th>Shop</th>
						<th>Manufacturer</th>
						<th>Model </th>
						<th>IMEI </th>						
						<th>Reference</th>	
						<th>Purchase Price</th>
						<th>Selling Price</th>																	
						<th>Pay Mode</th>																	
						<th>Sold By</th>	
						<th>Action</th>	
					</tr>
				</thead>
				<tbody>
					<?php if ($stotalRecords > 0) {
							foreach ($sdata as $srow) { 
							$payrec = $srow['payment_received'];
							if ($payrec == 'yes')
								echo "<tr style='background-color:#CDEB8B'>";
							else
								echo "<tr style='background-color:#C3D9FF'>";
					?>	
						
							<?php $rid = $srow['id'];
							$timestamp = strtotime($srow['date_entered']);							
							$dateenter =  date("d/m/Y h:i", $timestamp);
							$invno = $srow['invoice'];
							$shid = $srow['shop_id'];							
							$shname = $mysqli->query("SELECT name from shops where id = $shid")->fetch_object()->name;
							$puid = $srow['purchaseid'];
							$pprice = $mysqli->query("SELECT price from purchase where id = $puid")->fetch_object()->price;
							$identity = $mysqli->query("SELECT identification from purchase where id = $puid")->fetch_object()->identification;							
							$identity = "documents/".$identity;
							$pinv = $mysqli->query("SELECT invoice from purchase where id = $puid")->fetch_object()->invoice;
							/*
							$tablename="purchase";
							$orderby = " ORDER BY id ASC";
							$where= " id=$puid";
							$udata = $db->select($tablename,$orderby, $where);							
							foreach ($udata as $urow) {
								$pprice = $urow['price'];
							}
							*/	
							
							$pdfpath = "pdfs/".$invno."_S.pdf";
							$ppdfpath = "pdfs/".$pinv.".pdf";
							if (file_exists($pdfpath)) { ?>
								<td data-title="Date"><a href="<?php echo $pdfpath;?>" target="_blank" style="font-size:14px; font-weight:bold; color:#483D8B; text-decoration:underline;"><?php echo $dateenter;?></a></td>							
							<?php } else { ?>
								<td data-title="Date"><?php echo $dateenter;?></td>						
							<?php }	
							?>			
							<!--<td data-title="Date"><?php echo $dateenter;?></td>-->		
							<?php if (file_exists($ppdfpath)) { ?>
								<td data-title="Shop"><a href="<?php echo $ppdfpath;?>" target="_blank" style="font-size:14px; font-weight:bold; color:#483D8B; text-decoration:underline;"><?php echo $shname;?></a></td>							
							<?php } else { ?>
								<td data-title="Shop"><?php echo $shname;?></td>						
							<?php }	
							?>			
							
							
							<td data-title="Manufacturer"><?php echo $srow['make'];?></td>							
							<td data-title="Model"><a href="#recmodal" data-toggle='modal' style='font-size:14px; font-weight:bold; color:#0000FF; text-decoration:underline;' onclick="javascript:Setid('<?php echo $rid;?>');" ><?php echo $srow['model'];?></a></td>							
							<td data-title="IMEI"><a href="#" id="pop" style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' onclick="javascript:Showimage('<?php echo $identity;?>');" ><?php echo $srow['imei'];?></a></td>
							
							<!--<img id="imageresource" src="http://patyshibuya.com.br/wp-content/uploads/2014/04/04.jpg" style="width: 400px; height: 264px;">-->
    
							<?php $saccessories = "";?>								
							<!--<td data-title="Accessories"><?php echo $srow['accessories'];?></td>-->	
							<td data-title="Reference"><?php echo $srow['referrence'];?></td>
							<td data-title="Purchase Price"><?php echo "&pound" . $pprice;?></td>								
							<td data-title="Selling Price"><?php echo "&pound" . $srow['price'];?></td>								
							<td data-title="Pay Mode"><?php echo $srow['payment_mode'];?></td>	
							<td data-title="Sold By"><?php echo $srow['entered_by'];?></td>	
							<td data-title="Action"><a href="javascript:confsDelete('<?php echo $rid; ?>');"><img style="width:20px; height:20px;" title="Delete Record" src="images/minus.png"></a></td>		
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
		
		<div class="pagination pagination-centered" >
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
		</div>	
	</div> 
<!-- Creates the bootstrap modal where the image will appear -->
	<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Identification Preview</h4>
				</div>
				<div class="modal-body">
					<img src="" id="imagepreview" style="width: 100%; height: 100%;" >
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class='modal hide fade' id='recmodal' role='dialog' tabindex='-1' aria-labelledby="myModalLabel" aria-hidden="true" style="width: 700px;position:fixed;">
		<div class='modal-header'>
			<button class='close' data-dismiss='modal' type='button' onclick="javascript:DivRefreshrj();">&times;</button>
			<h3>Update Receive Status</h3>
		</div>
		<div class='modal-body' >		
			<div class='controls text-center'>			
				<div class='form-wrapper'>
					<form name="rej_form" id="rej_form" class="form-horizontal" action="" method="post" >										
						<div class="row-fluid" >																							
							<div class="control-group">							
								<label class="control-label">Received: </label>	
								<select name="txtrec" id="txtrec" class="input-large">	
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
								<!--<input id="chkrejinformed" type="checkbox"  name="chkrejinformed">-->									
							</div>							
							<input type="hidden"  name="txtrejid" id="txtrejid" value="" >										
						</div>	
					</form>
				</div>
			</div>
		</div>
		<div class='modal-footer'>					
			<a href="javascript:updateRInform();"  class="button_bar" >Save</a>		
		</div>
	</div>	

<script type="text/javascript">
	function Showimage(imagesrc) {
	
	$('#imagepreview').attr('src', imagesrc); // here asign the image to the modal when the user click the enlarge link
	$('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function

	}	
	
	function snextRecords() {
		
		var currentPage = $('#scurrentPage').val();
		var simake = $('#txtimakes').val();		
		var simodel = $('#txtimodels').val();		
		var sinetwork = $('#txtinetworks').val();
		var sishop = $('#txtishop').val();
		var sirange = $('#txtirange').val();
		
		currentPage++;
							
		$.post("insale_list.php",{spageNum:currentPage,imodel:simodel,inetwork:sinetwork,imake:simake,ishop:sishop,irange:sirange},function(data){
			$('#insalelist').html(data);
		});
		
	}
	
	function spreviousRecords() {
		var simake = $('#txtimakes').val();		
		var simodel = $('#txtimodels').val();
		var sinetwork = $('#txtinetworks').val();
		var sishop = $('#txtishop').val();
		var sirange = $('#txtirange').val();
		var currentPage = $('#scurrentPage').val();
		currentPage--;
		
		$.post("insale_list.php",{spageNum:currentPage,imodel:simodel,inetwork:sinetwork,imake:simake,ishop:sishop,irange:sirange},function(data){
		
			$('#insalelist').html(data);
		});
		
	}
	
	function sjumpToRecords(cpage) {
		var simake = $('#txtimakes').val();		
		var simodel = $('#txtimodels').val();		
		var sinetwork = $('#txtinetworks').val();
		var sishop = $('#txtishop').val();
		var sirange = $('#txtirange').val();
		
		$.post("insale_list.php",{spageNum:cpage,imodel:simodel,inetwork:sinetwork,imake:simake,ishop:sishop,irange:sirange},function(data){
		
			$('#insalelist').html(data);
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
		
		$.post("insale_list.php",{cpageNum:pcurrentPage},function(data){
			$('#insalelist').html(data);
		});
    }
	
</script>

</body>
</html> 

