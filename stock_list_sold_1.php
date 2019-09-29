<!DOCTYPE html>

<?php
	error_reporting(0);
	session_start();

?>

<?php
	include_once 'include/global.inc.php';
	include_once 'include/conn.php';
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


    $tablename="sale";
    $current_date = date('Y-m-1 H:i:s');
    $two_months = date('Y-m-1 H:i:s', strtotime("$current_date -1 month"));
    $orderby = " ORDER BY created_at DESC";
	$where= "shop_id = $shid  AND date_entered >= '$two_months' AND date_entered < '$current_date'";
	$data = $db->totalRecords($tablename, $where);
	$totalRecords = $data;

	if ($totalRecords != 0) {
		$datar = $db->select($tablename, $orderby, $where);
	}

	$statusIn = $mysqli->query("SELECT count(id) as stockCount from sale where shop_id = $shid AND date_entered >= '$two_months' AND date_entered < '$current_date' ")->fetch_object()->stockCount;
?>
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
		<div class="span6"  style="font-size:18px; font-weight:bold; color:#000000;margin-left:375px;margin-top:60px;">Previous Month&nbsp;&nbsp; </div>
		<div class="span6"  style="font-size:18px; font-weight:bold; color:#000000;margin-left:380px;">Sold Stock:&nbsp;&nbsp; <?php echo $statusIn;?> </div>
	</div>
    <div class="span12">
		<div class="table-responsive">
			<table class="table table-bordered" id="myTable1">
				<thead>
					<tr>
						<th>Purchase Date</th>
						<th>Manufacturer</th>
						<th>Model </th>
						<th>IMEI </th>
						<th>Customer Name</th>
						<th>Seller Name</th>
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
							$sprice = $row['price'];
							if (!(isset($sprice)))
								$sprice = "";
							else
								$sprice = "&pound".$sprice;
							?>
							<td data-title="Date"><?php echo $dateenter;?></td>
							<td data-title="Manufacturer" ><?php echo $row['make'];?></td>
							<td data-title="Model"><span style="font-size:14px; font-weight:bold; color:#008000; "><?php echo $row['model'];?></span></td>
							<td data-title="IMEI"><a href="#"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;"><?php echo $row['imei'];?></a></td>
							<td data-title="Customer Name"><?php echo $row['customer_name'];?></td>
							<td data-title="Seller Name"><?php echo $row['entered_by'];?></td>
							<td data-title="Selling Price"><?php echo $sprice;?></td>
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
			$('#myTable1').DataTable({
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

</body>
</html>
