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
	$txtuser = $_POST['txtuser'];
	
	
	//echo $txtshop;
	//echo $txtsdate;
	//echo $txtedate;
	//echo $txtuser;
	/* To calculate working days
	SELECT shops.name, attendance.user_name, count(attendance.id ) AS Working
		FROM attendance, users , shops
		WHERE attendance.user_id = users.id
		AND users.shop_id = shops.id
		AND DATE( checkin )
		BETWEEN '2015-07-01'
		AND '2015-07-06'
		GROUP BY attendance.user_name
		LIMIT 0 , 30
	*/	
	
	/* To calculate time
	SELECT SUM( Time_format( TIMEDIFF( checkout, checkin ) , '%H:%m:%s' ) ) AS Working
		FROM attendance, users, shops
		WHERE attendance.user_id = users.id
		AND users.shop_id = shops.id
		AND DATE( checkin )
		BETWEEN '2015-07-01'
		AND '2015-07-06'
		GROUP BY attendance.user_name
		LIMIT 0 , 30
	
	*/
	
	$datesql = "";	
	if ((!empty($txtsdate)) && (!empty($txtedate)))  {
	
		$datearray = explode("/",$txtsdate);
		$activefrom = $datearray[2]."-".$datearray[1]."-".$datearray[0];
		$stdate = "$activefrom";
		
		$datearray1 = explode("/",$txtedate);
		$activeto = $datearray1[2]."-".$datearray1[1]."-".$datearray1[0];
		$eddate = "$activeto";	
		
		$datesql = " AND DATE(checkin) between '$stdate' AND '$eddate'";		
		
	}
	
	$shopsql = "";	
	if (!empty($txtshop)) {
		$shopsql = " AND shops.id = '$txtshop'";				
	}
		
	$usersql = "";
	if (!empty($txtuser)) {
		$usersql = " AND attendance.user_name = '$txtuser'";		
	}
	
	//Repairs Selection	
	$sqlstr = "SELECT shops.name, attendance.user_id, attendance.user_name, count(attendance.id ) AS Days, ROUND(SUM( (UNIX_TIMESTAMP(checkout) - UNIX_TIMESTAMP(checkin))/60/60),2) AS Hours FROM attendance, users , shops WHERE attendance.user_id = users.id AND users.shop_id = shops.id $datesql $shopsql $usersql  GROUP BY attendance.user_name";
	//echo $sqlrep;
	$result = $db->selectQuery($sqlstr);	
			
	//$criteria = "Selected Criteria  $shopc $labc $datec";
		
?>	
	<div class="row-fluid">
		<div class="span12">
			<h3> <?php echo $criteria; ?> </h3>
			<h4> Attendance Sheet </h4>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>						
						<tr>
							<th>Shop name</th>
							<th>User Name</th>
							<th>Working Days</th>
							<th>Total Time</th>							
						</tr>
					</thead	>
					<tbody>	
						<?php if (!empty($result)) 
						{
						
							foreach ($result as $rows) 
							{ ?>
								<tr>								
									<td><?php echo $rows['name']; ?></td>
									<td><a href="admin_attendance_report.php?user=<?php echo $rows['user_name']; ?>&sdate=<?php echo $stdate;?>&edate=<?php echo $eddate;?>" style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;'><?php echo $rows['user_name']; ?></a></td>
									<td><?php echo $rows['Days']; ?></td>
									<td><?php echo $rows['Hours']; ?></td>
								</tr>
						<?php } 							
						} else {
						?>
							<tr>
								<td colspan="4"> No Record Found</td>								
							</tr>
						<?php } ?>
					</tbody	>						
				</table>
				
			</div>			
		</div>
	</div>
</body>
</html> 

