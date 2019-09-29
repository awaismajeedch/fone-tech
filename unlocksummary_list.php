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
	
	$sql = "SELECT SUM(charges) AS jobs,SUM(paid) AS paid FROM unlocks";
	
	$Sumdata = $db->selectQuery($sql);	
	
	foreach ($Sumdata as $cnt) {
		$sumfixed = $cnt['jobs'];
		$sumpaid = $cnt['paid'];
	}
	
	$sql = "SELECT labs.name AS Name, sum(charges) AS Labch,  sum(paid) AS Paid FROM unlocks, labs where unlocks.lab_id = labs.id group by lab_id";
	
	$Labdata = $db->selectQuery($sql);
?>	
	
    <div class="span12">
		<div class="table-responsive">
			<div class="table-responsive">
				<h2> Overall Summary: <?php echo $sumfixed; ?> (Charges) - <?php echo $sumpaid; ?> (Paid) = <?php echo ($sumfixed - $sumpaid); ?> (Balance)  </h2>
				<hr>
				<h4> Labs Summary</h4>
				<?php foreach ($Labdata as $lrow) { 
				
					$lname = $lrow['Name'];
					$sumch = $lrow['Labch'];
					$sumlp = $lrow['Paid'];
					$bal = $sumch - $sumlp; 
					echo "<h5> $lname: $sumch (Total Charges) - $sumlp (Total Paid) =  $bal (Balance)  </h5>";
				}								
				?>
			</div>	
		</div>
	</div>	
		

