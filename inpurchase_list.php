<!DOCTYPE html>

<?php	
	//session_start();
	error_reporting(0);	
?>   

<?php
	include_once 'include/global.inc.php';
	require_once 'include/conn.php';
	//$compid  = $_SESSION['company_id'];
	//$shid  = $_SESSION['shop_id'];	
	$shop = "";
	$make = "";
	$model = "";
	$network = "";
	
	$shop = $_POST['shop'];
	$make = $_POST['make'];
	$model = $_POST['model'];
	$network = $_POST['network'];
	$viewed = 1; 
	
	$shopsql = "";
	if (!empty($shop)) {
		$shopsql = " AND shop_id = '$shop'";		
	}
	
	$makesql = "";
	if (!empty($make)) {
		$makesql = " AND make like '%$make%'";
		$viewed = 0;
	}
	
	$modelsql = "";
	if (!empty($model)) {
		$modelsql = " AND model like '%$model%'";		
		$viewed = 0; 
	}
	$networksql = "";
	if (!empty($network)) {
		$networksql = " AND imei = '$network'";
		$viewed = 0;
	}
	
	
	$tablename="purchase";
	$orderby = " ORDER BY created_at DESC";
	$where= "status='instock' $shopsql $makesql $modelsql $networksql";
	//echo $where;
	
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
?>	

	
	<input type="hidden" id="currentPage" value="<?php echo $page; ?>" />
	<input type="hidden" name="txtmakes" id="txtmakes" value="<?php echo $make; ?>" />
	<input type="hidden" name="txtmodels" id="txtmodels" value="<?php echo $model; ?>" />
	<input type="hidden" name="txtnetworks" id="txtnetworks" value="<?php echo $network; ?>" />	
	<input type="hidden" name="txtshop" id="txtshop" value="<?php echo $shop; ?>" />	
	
	<!--<div class="pull-right" > 
		<?php echo "Total Pages: " .$totalPages ?>
	</div>-->
	
    <div class="span12">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Date</th>
						<th>Shop</th>
						<th>Manufacturer</th>
						<th>Model </th>
						<th>IMEI </th>
						<th>Network</th>																			
						<th>Defects</th>	
						<th>Accessories</th>	
						<th>Price</th>	
						<th>Sell Price</th>	
						<th>Action</th>	
					</tr>
				</thead>
				<tbody>
					<?php if ($totalRecords > 0) {
							foreach ($datar as $row) { 
							
					?>	
						<tr>
							<?php $rid = $row['id'];
							$timestamp = strtotime($row['date_entered']);							
							$dateenter =  date("d/m/Y h:i", $timestamp);
							$shid = $row['shop_id'];							
							$invno = $row['invoice'];
							$shname = $mysqli->query("SELECT name from shops where id = $shid")->fetch_object()->name;
							$pdfpath = "pdfs/".$invno.".pdf";
							
							if (file_exists($pdfpath)) { ?>
								<td data-title="Date"><a href="<?php echo $pdfpath;?>" target="_blank" style="font-size:14px; font-weight:bold; color:#483D8B; text-decoration:underline;"><?php echo $dateenter;?></a></td>							
							<?php } else { ?>
								<td data-title="Date"><?php echo $dateenter;?></td>						
							<?php }	
							?>								
							
							<td data-title="Shop"><?php echo $shname;?></td>							
							<td data-title="Manufacturer"><?php echo $row['make'];?></td>							
							<td data-title="Model"><?php echo $row['model'];?></td>							
							<td data-title="IMEI"><a href="updatepurchase.php?pid=<?php echo $rid;?>"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;"><?php echo $row['imei'];?></a></td>							
							<td data-title="Network"><?php echo $row['network'];?></td>																									
							<td data-title="Defects"><?php echo $row['defects'];?></td>														
							<?php $accessories = "";
							$accessories ="";
							$missql = "SELECT * FROM misc WHERE itemid = $rid AND (type='accessories' OR type='other')";	
							$misdata = $db->selectQuery($missql);	
							foreach ($misdata as $msrow) {
								$accessories = $msrow['value'] . "," . $accessories;		
							}
							$accessories = trim ($accessories,",");
							
							?>		
							<td data-title="Accessories"><?php echo $accessories;?></td>	
							<td data-title="Price"><?php echo "&pound" . $row['price'];?></td>	
							<?php if (!isset($row['sprice'])) {
									$sprice = '0.00';
								 } else {
									$sprice = $row['sprice'];
								}	
							?>	
							
							<td data-title="Sell Price"><?php echo "&pound" . $sprice;?></td>	
							<td data-title="Action"><a href="javascript:confDelete('<?php echo $rid; ?>');"><img style="width:20px; height:20px;" title="Delete Record" src="images/minus.png"></a></td>	
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
		var smake = $('#txtmakes').val();		
		var smodel = $('#txtmodels').val();		
		var snetwork = $('#txtnetworks').val();
		var sshop = $('#txtshop').val();
		
		currentPage++;
							
		$.post("inpurchase_list.php",{pageNum:currentPage,model:smodel,network:snetwork,make:smake,shop:sshop},function(data){
			$('#inpurchaselist').html(data);
		});
		
	}
	
	function previousRecords() {
		var smake = $('#txtmakes').val();		
		var smodel = $('#txtmodels').val();
		var snetwork = $('#txtnetworks').val();
		var sshop = $('#txtshop').val();
		var currentPage = $('#currentPage').val();
		currentPage--;
		
		$.post("inpurchase_list.php",{pageNum:currentPage,model:smodel,network:snetwork,make:smake,shop:sshop},function(data){
		
			$('#inpurchaselist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		var smake = $('#txtmakes').val();		
		var smodel = $('#txtmodels').val();		
		var snetwork = $('#txtnetworks').val();
		var sshop = $('#txtshop').val();
		
		$.post("inpurchase_list.php",{pageNum:cpage,model:smodel,network:snetwork,make:smake,shop:sshop},function(data){
		
			$('#inpurchaselist').html(data);
		});
	}
	
	function confDelete(uId) {
		 bol = confirm("Are you sure to delete this record?");
        if ( bol ) {
			$.post("delete_controller.php",{id:uId,type:'purchase'},function(data){
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

