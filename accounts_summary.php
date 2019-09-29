<!DOCTYPE html>


<?php	
	//session_start();
	error_reporting(0);		
?>   

<?php
	include_once 'include/global.inc.php';
	
	$txtshop = $_POST['txtshop'];
	$txtsdate = $_POST['txtsdate'];
	$txtedate = $_POST['txtedate'];
	$txtlab = $_POST['txtlab'];
	$shopname = $_POST['selshop'];
	$labname = $_POST['sellab'];
	
	//echo $txtshop;
	//echo $txtsdate;
	//echo $txtedate;
	//echo $txtlab;
	
	$shopsql = "";
	$shopsqls = "";
	if (!empty($txtshop)) {
		$shopsql = " AND shop_id = '$txtshop'";		
		$shopsqls = " AND sale.shop_id = '$txtshop'";	
		$shopc = "Shop Name: " . $shopname . ",";
	}
	
	$datesql = "";
	$datesqls = "";
	if ((!empty($txtsdate)) && (!empty($txtedate)))  {
	
		$datearray = explode("/",$txtsdate);
		$activefrom = $datearray[2]."-".$datearray[1]."-".$datearray[0];
		$stdate = "$activefrom";
		
		$datearray1 = explode("/",$txtedate);
		$activeto = $datearray1[2]."-".$datearray1[1]."-".$datearray1[0];
		$eddate = "$activeto";	
		
		$datesql = " AND DATE(date_entered) between '$stdate' AND '$eddate'";		
		$datesqls = " AND DATE(sale.date_entered) between '$stdate' AND '$eddate'";		
		$datec = "From $stdate To $eddate";
	}
	$labsql = "";
	if (!empty($txtlab)) {
		$labsql = " AND lab_id = '$txtlab'";
		$labc = "Lab Name: " . $labname . ",";	
	}
	//Repairs Selection	
	$sqlrep = "SELECT SUM(charges) as Repcharges, SUM(labcharges) as Replabcharges , SUM(paid) as Replabpaid  FROM repairs where status='Fixed'  $shopsql $datesql $labsql";
	//echo $sqlrep;
	$Sumreps = $db->selectQuery($sqlrep);	
	
	foreach ($Sumreps as $reps) {
		$sumrepcharges = $reps['Repcharges'];
		$sumreplabcharges = $reps['Replabcharges'];
		$sumreplabpaid = $reps['Replabpaid'];
		$sumrepprofit = $sumrepcharges - $sumreplabcharges;
		$sumrepdue = $sumreplabcharges - $sumreplabpaid;
	}
	
	//Unlocks Selection
	$sqlUnl = "SELECT SUM(charges) as Uncharges, SUM(balance) as Unlabcharges , SUM(paid) as Unlabpaid  FROM unlocks where status='Success'  $shopsql $datesql $labsql";
	
	$Sumunls = $db->selectQuery($sqlUnl);	
	
	foreach ($Sumunls as $unlok) {
		$sumuncharges = $unlok['Uncharges'];
		//$sumunlabcharges = $unlok['Unlabcharges'];
		$sumunlabcharges = $unlok['Unlabpaid'];
		$sumunlabpaid = $unlok['Unlabpaid'];
		$sumunprofit = $sumuncharges - $sumunlabcharges;
		//$sumundue = $sumunlabcharges - $sumunlabpaid;
		$sumundue =  $unlok['Unlabcharges'];
	}
	//Sale/Purchase Selection
	$sqlpur = "SELECT SUM(purchase.price) as pprice from purchase where 1=1 $shopsql $datesql";
	//echo $sqlpur;
	$SumPu = $db->selectQuery($sqlpur);	
	
	foreach ($SumPu as $pers) {
		$sumpurchase = $pers['pprice'];
		//$sumsells = $sels['sprice'];		
		//$sumselprofit = $sumsells - $sumpurchase;
		//$sumundue = $sumunlabcharges - $sumunlabpaid;
	}
	//Sale Selection
	$sqlSel = "SELECT  SUM(sale.price) as sprice from sale where 1=1 $shopsql $datesql";
	//echo $sqlSel;
	$SumSel = $db->selectQuery($sqlSel);	
	
	foreach ($SumSel as $sels) {
		$sumsells = $sels['sprice'];						
	}
	$sumselprofit = $sumpurchase - $sumsells;
	//In stock phones order by Make
	$sqlinv = "SELECT count(make) AS cntMake, make FROM purchase WHERE status='instock'  $shopsql $datesql group by make";
	$Invsel = $db->selectQuery($sqlinv);
	
	//To get Sum of Stock
	$sqlinvt = "SELECT sum(cntMake) AS sumMake FROM (SELECT count(make) AS cntMake FROM purchase WHERE status='instock'  $shopsql $datesql group by make) SM";
	$Invselt = $db->selectQuery($sqlinvt);
	
	foreach ($Invselt as $invt) {
		$sumstock = $invt['sumMake'];		
	}	
	
	$criteria = "Selected Criteria  $shopc $labc $datec";
	
	
?>	
	<div class="row-fluid">
		<div class="span12">
			<h3> <?php echo $criteria; ?> </h3>
			<h4> Repair and Unlocking  </h4>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>						
						<tr>
							<th>&nbsp;</th>
							<th>Shop Charges</th>
							<th>Lab Charges</th>
							<th>Profit</th>
							<th>Lab Due</th>
						</tr>
					</thead	>
					<tbody>						
						<tr>
							<th>Total Repairs</th>
							<th><?php echo "&pound " . $sumrepcharges; ?></th>
							<th><?php echo "&pound " . $sumreplabcharges; ?></th>
							<th><?php echo "&pound " . $sumrepprofit.".00"; ?></th>
							<th><?php echo "&pound " . $sumrepdue.".00"; ?></th>
						</tr>
						<tr>
							<th>Total Unlocks</th>
							<th><?php echo "&pound " . $sumuncharges; ?></th>
							<th><?php echo "&pound " . $sumunlabcharges; ?></th>
							<th><?php echo "&pound " . $sumunprofit.".00"; ?></th>
							<th><?php echo "&pound " . $sumundue.".00"; ?></th>
						</tr>
					</tbody	>						
				</table>
				<h4> Purchase and Selling  </h4>	
				<table class="table table-bordered">
					<thead>						
						<tr>
							<th>&nbsp;</th>
							<th>Purchase Cost</th>
							<th>Selling Cost </th>
							<th>Profit</th>								
						</tr>
					</thead>
					<tbody>						
						<tr>
							<th>Total Purchase/Sale</th>
							<th><?php echo "&pound " . $sumpurchase; ?></th>
							<th><?php echo "&pound " . $sumsells; ?></th>
							<th><?php echo "&pound " . $sumselprofit.".00"; ?></th>								
						</tr>
					</tbody>
				</table>
				<h4> In Stock Phones List - Total Count (<?php echo $sumstock; ?>)</h4>	
				<table class="table table-bordered">
					<thead>						
						<tr>							
							<th>Make</th>
							<th>Count </th>							
						</tr>
					</thead>
					<tbody>	
						<?php foreach ($Invsel as $stock) { ?>		
							<tr>							
								<th><?php echo $stock['make']; ?></th>
								<th><?php echo $stock['cntMake']; ?></th>							
							</tr>
						<?php } ?>	
					</tbody>
				</table>
				
			</div>			
		</div>
	</div>
</body>
</html> 

