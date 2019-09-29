<!DOCTYPE html>

<?php
	error_reporting(0);
	session_start();

?>

<?php
	include_once 'include/global.inc.php';
	include_once 'include/conn.php';
	//$compid  = $_SESSION['company_id'];
	//echo "User:" .$_SESSION['user_name'];
	$shid  = $_SESSION['shop_id'];
	$usname = $_SESSION['user_name'];
	$make = "";
	$model = "";
	$network = "";
	$imei = "";

	$make = $_POST['make'];
	$model = $_POST['model'];
	$network = $_POST['network'];
	$imei = $_POST['imei'];
	$viewed = 1;

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
		$networksql = " AND network like '%$network%'";
		$viewed = 0;
	}

	$imeisql = "";
	if (!empty($imei)) {
		$imeisql = " AND imei like '%$imei%'";
		$viewed = 0;
	}
	$tablename="purchase";
	$orderby = " ORDER BY created_at DESC";
	$where= "shop_id = $shid AND status='instock'  $makesql $modelsql $networksql $imeisql";
	//echo $where;

	$rfid = 00;
	$recordsPerPage = 10;
	$page = 1;
	$totalPages = 0;
	if ( isset ($_POST['pageNum'] ) ) {
		$page = $_POST['pageNum'];
	}

	$data = $db->totalRecords($tablename, $where);
	// echo $data;
	$totalRecords = $data;

	if ($totalRecords != 0) {
		$totalPages = ceil( $totalRecords/$recordsPerPage);
		if ( $page >= $totalPages ) {
			$page = $totalPages;
		}
		$startPage = ($page - 1) * $recordsPerPage;
		// $datar = $db->selectData($tablename, $where, $orderby, $startPage, $recordsPerPage);
		$datar = $db->select($tablename, $orderby, $where);
	}

	$statusIn = $mysqli->query("SELECT count(id) as stockCount from purchase where shop_id = $shid AND status = 'instock' ")->fetch_object()->stockCount;
?>


	<input type="hidden" id="currentPage" value="<?php echo $page; ?>" />
	<input type="hidden" name="txtmakes" id="txtmakes" value="<?php echo $make; ?>" />
	<input type="hidden" name="txtmodels" id="txtmodels" value="<?php echo $model; ?>" />
	<input type="hidden" name="txtnetworks" id="txtnetworks" value="<?php echo $network; ?>" />
	<input type="hidden" name="txtimeis" id="txtimeis" value="<?php echo $imei; ?>" />

	<!--<div class="pull-right" >
		<?php echo "Total Pages: " .$totalPages ?>
	</div>-->
	<?php
		$bit = 0;
		$ussql = "SELECT user_name FROM `users` where shop_id in (2,3,5,9,12,13,14,15,20,27)";
		$usdata = $db->selectQuery($ussql);
		foreach ($usdata as $usrow) {
			$alusers = $usrow['user_name'];
			if ($usname == $alusers) {
					$bit = 1;
					//echo "bit" . $bit;
					break;

			}
		}
	?>
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
	.dt-buttons{
		margin-left: 40%;
		margin-bottom: 15px;
	}
	</style>
	<div class="span12">
		<div class="span4"></div>
		<div class="span6"  style="font-size:18px; font-weight:bold; color:#000000;margin-left:60px;">Available Stock:&nbsp;&nbsp; <?php echo $statusIn;?> </div>

	</div>
    <div class="span12">
		<div class="table-responsive">
			<table class="table table-bordered" id="myTable">
				<thead>
					<tr>
						<th>Purchase Date</th>
						<th>Manufacturer</th>
						<th>Model </th>
						<th>IMEI </th>
						<th>Network</th>
						<th>Defects</th>
						<!-- <th>Accessories</th> -->
						<?php if ($bit == 1 || $usname == 'chichester') {
							echo "<th>Purchase Price</th>";
						} ?>
						<th>Selling Price</th>
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
							$sprice = $row['sprice'];
							if (!(isset($sprice)))
								$sprice = "";
							else
								$sprice = "&pound".$sprice;
							?>
							<td data-title="Date"><?php echo $dateenter;?></td>
							<td data-title="Manufacturer" ><?php echo $row['make'];?></td>
							<td data-title="Model"><span style="font-size:14px; font-weight:bold; color:#008000; "><?php echo $row['model'];?></span></td>
							<td data-title="IMEI"><a href="sale.php?pid=<?php echo $rid;?>"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;"><?php echo $row['imei'];?></a></td>
							<td data-title="Network"><?php echo $row['network'];?></td>
							<td data-title="Defects"><?php echo $row['defects'];?></td>
							<!-- php $accessories = "";
							$accessories ="";
							$missql = "SELECT * FROM misc WHERE itemid = $rid AND (type='accessories' OR type='other')";
							$misdata = $db->selectQuery($missql);
							foreach ($misdata as $msrow) {
								$accessories = $msrow['value'] . "," . $accessories;
							}
							$accessories = trim ($accessories,","); -->
							<!-- <td data-title="Accessories"><?php echo $accessories;?></td> -->
							<?php if ($bit == 1 || $usname == 'chichester' )  {
								echo "<td data-title='Purchase Price'>"."&pound". $row['price']."</td>";
							} ?>
							<!--<td data-title="Purchase Price"><?php //echo "&pound". $row['price'];?></td>-->
							<td data-title="Selling Price"><?php echo $sprice;?></td>

							<?php
							/*
							$strid = $row['id'];
								  $strmake =  json_encode($row['make']);
								  $strmodel =  json_encode($row['model']);
								  $strimei =  json_encode($row['imei']);
								  $strnetwork =  json_encode($row['network']);
								  $straccess = json_encode($accessories);
								  $strprice = $row['sprice'];
								  echo "<td data-title='Action'><a data-toggle='modal' href='#modal-stock' style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' onclick='setData($strid,$strmake,$strmodel,$strimei,$strnetwork,$straccess,$strprice);'><img src='images/add.png'></a></td>";
							*/
							?>
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
		</div> -->
	</div>
<div class='modal hide fade' id='modal-stock' role='dialog' tabindex='-1' style="width: 700px;">
	<div class='modal-header'>
		<button class='close' data-dismiss='modal' type='button'>&times;</button>
		<h3>Update Stock</h3>
	</div>
	<div class='modal-body' >
		<div class='controls text-center'>
			<div class='form-wrapper'>
				<form name="sell_form" id="sell_form" class="form-horizontal" action="" method="post" >
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
								<label class="control-label" >Network: </label>
								<div class="controls">
									<input class="input-large" id="txtnetwork" name="txtnetwork" type="text" value="" disabled />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" >Accessories: </label>
								<div class="controls">
									<input class="input-large" id="txtaccessories" name="txtaccessories" type="text" value=""  disabled />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" >Purchased Price <?php echo "(&pound)" ; ?>: </label>
								<div class="controls">
									<input class="input-large" id="txtpprice" name="txtpprice" type="text" value="" disabled />
								</div>
							</div>
							<div class="control-group" id="labcharges" >
								<label class="control-label" >Selling Price <?php echo "(&pound)" ; ?>: </label>
								<div class="controls">
									<input class="input-large" id="txtsprice" name="txtsprice" type="text" />
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
		<a href="javascript:validateStock();" class="button_bar">Save</a>
	</div>
</div>
<script src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.print.min.js"></script>
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
	        searchPlaceholder: "Please enter Model or IMEI or Price or Manufacturer",
				},
				dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
			});
			});
	</script>
<script type="text/javascript">
	function nextRecords() {

		var currentPage = $('#currentPage').val();
		var smake = $('#txtmakes').val();
		var smodel = $('#txtmodels').val();
		var snetwork = $('#txtnetworks').val();
		var simei = $('#txtimeis').val();

		currentPage++;

		$.post("stock_list.php",{pageNum:currentPage,model:smodel,network:snetwork,make:smake,imei:simei},function(data){
			$('#stocklist').html(data);
		});

	}

	function previousRecords() {
		var smake = $('#txtmakes').val();
		var smodel = $('#txtmodels').val();
		var snetwork = $('#txtnetworks').val();
		var currentPage = $('#currentPage').val();
		var simei = $('#txtimeis').val();
		currentPage--;

		$.post("stock_list.php",{pageNum:currentPage,model:smodel,network:snetwork,make:smake,imei:simei},function(data){

			$('#stocklist').html(data);
		});

	}

	function jumpToRecords(cpage) {
		var smake = $('#txtmakes').val();
		var smodel = $('#txtmodels').val();
		var snetwork = $('#txtnetworks').val();
		var simei = $('#txtimeis').val();

		$.post("stock_list.php",{pageNum:cpage,model:smodel,network:snetwork,make:smake,imei:simei},function(data){

			$('#stocklist').html(data);
		});
	}


	function setData(id,make,model,imei,network,access,price) {

		document.getElementById('txtrepid').value = id;
		document.getElementById('txtmake').value = make;
		document.getElementById('txtmodel').value = model;
		document.getElementById('txtime').value = imei;
		document.getElementById('txtnetwork').value = network;
		document.getElementById('txtaccessories').value = access;
		document.getElementById('txtpprice').value = price;

	}

	function validateStock() {
		var success = 1;

		if (document.getElementById("txtsprice").value == "" ) {
            alert("Please enter Selling Price!");
			document.getElementById("txtsprice").focus();
			success = 0;
            return;

		}

		if (success == 1) {

			var serializedData = $('#sell_form').serialize();

			$.post("selling_controller.php",serializedData,function(data){
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

</body>
</html>
