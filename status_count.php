<!DOCTYPE html>
<?php	
	//session_start();
	error_reporting(0);	
	
	//http://elvery.net/demo/responsive-tables/#no-more-tables

	require_once 'include/conn.php';
	//include_once 'include/global.inc.php';
	//$compid  = $_SESSION['company_id'];
	$txtsdate = $_POST['txtsdate'];
	$txtedate = $_POST['txtedate'];
	$txtshop = $_POST['txtshop'];
	
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
	
	$statusIn = $mysqli->query("SELECT count(status) as inprogressCount from repairs where status = 'Inprogress' $shopsql $datesql")->fetch_object()->inprogressCount;
	$statusPen = $mysqli->query("SELECT count(status) as pendingCount from repairs where status = 'Pending' $shopsql $datesql")->fetch_object()->pendingCount;
	$statusFix = $mysqli->query("SELECT count(status) as fixCount from repairs where status = 'Fixed' $shopsql $datesql")->fetch_object()->fixCount;
	$statusNfix = $mysqli->query("SELECT count(status) as notfixedCount from repairs where status = 'NotFixed' $shopsql $datesql")->fetch_object()->notfixedCount;
		
?>	
	
    <div class="span12">
		
		<div class="span3" style="font-weight:bold; color:#0000FF;">Inprogress: <?php echo $statusIn;?></div>
		<div class="span3" style="font-weight:bold; color:#0000FF;">Pending: <?php echo $statusPen;?></div>
		<div class="span3" style="font-weight:bold; color:#0000FF;">Fixed: <?php echo $statusFix;?></div>
		<div class="span3" style="font-weight:bold; color:#0000FF;">Not Fixed: <?php echo $statusNfix;?></div>
	
	</div>	
		

