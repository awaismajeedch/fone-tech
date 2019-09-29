	<!-- Current Month -->
	<div class="container">
		<div class="span12 distance_1">
			<h2 class="text-center">Attendance for <?php echo $monthSt; ?> To <?php echo $monthCur; ?> </h2>			
			<!--<h2 class="text-right"><a data-toggle='modal' href='#modal-prevmonth' style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' >Prev Month - <?php echo $prevMonth; ?></a></h2>-->
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>						
							<th>Date - Day</th>
							<th>Check In</th>														
							<th>Check Out</th>
							<th>Status</th>
							<th>Break</th>
							<th>Total Time</th>
							<th>Signatures</th>	
						</tr>
					</thead>
					<tbody>
						<?php							
							
							while($thisTime >= $endTime)
							{
								//echo $thisDate . $day ."<br>";
								
								$thisDate = date('Y-m-d', $thisTime);
								$day = date('D', $thisTime);
								
								//$sql = "SELECT id, user_name,  DATE_FORMAT( checkin, '%Y-%m-%d %h:%i' ) AS checkin , DATE_FORMAT( checkout, '%Y-%m-%d %h:%i' ) AS checkout, signature_path from attendance where user_name = '$usname' AND DATE(checkin) = '$thisDate'" ;
								$sql = "SELECT id, user_name,  checkin, checkout, signature_path from attendance where user_name = '$usname' AND DATE(checkin) = '$thisDate'" ;
								//echo $sql;
								$result = $mysqli->query($sql);
								//echo "rows" . $result->num_rows;
								if ($result->num_rows > 0) {
									$nofound = 1; 
									
									echo '<tr class="success">';
									while($row = $result->fetch_assoc()) { 										
										
										$dt1 = date('Y-m-d H:i',strtotime($row['checkin']));
										$dtt1 = date('H:i',strtotime($row['checkin']));
										if (isset($row['checkout'])) 
										{
											$dt2 = $row['checkout'];											
											
											$date_a = new DateTime($dt2);
											$date_b = new DateTime($dt1);
											//$interval = date_diff($date_a,$date_b);
											$interval = $date_a->diff($date_b);
											$fnduration =  strtotime($interval->format('%H:%i'));											
											$duration = date("H:i", strtotime('-30 minutes', $fnduration));
											// Sum up All Times											
											
											$dt2 = date('Y-m-d H:i', strtotime($dt2));
											$dtt2 = date('H:i', strtotime($dt2));
											//$dt1 = date('Y-m-d H:i', strtotime($dt1));
											//$duration = ($dt2 - $dt1)/60;
											//$duration =  SubTime($dt1,$dt2);
											$break ='30 Min';
										}	
											
									?>
											<td data-title="Date- Day"><?php echo $thisDate;?> - <?php echo $day;?></th>
											<td data-title="CheckIn"><?php echo $dtt1;?></td>							
											<td data-title="CheckOut"><?php echo $dtt2;?></td>																		
											<td data-title="Status">P</td>
											<td data-title="Break"><?php echo $break;?></td>							
											<td data-title="Duration"><?php echo $duration;?></td>											
											<td data-title="Signatures"><img  src="documents/<?=$row['signature_path'];?>" style="width:50px; height:30px;" ></td>
									<?php 
										$totDuration = SumTime($duration, $totDuration);									
									}			
									echo '</tr>';	
								} else {								
									$nofound = 1; 
									
									echo '<tr class="error">'; ?>
																			
											<td data-title="Date- Day"><?php echo $thisDate;?> - <?php echo $day;?></th>
											<td data-title="CheckIn">-</td>							
											<td data-title="CheckOut">-</td>							
											<td data-title="Status">A</td>
											<td data-title="Break">0</td>
											<td data-title="Duration">0</td>											
											<td data-title="Signatures">-</td>
									<?php }			
									echo '</tr>';	
								
								$thisTime = strtotime('-1 day', $thisTime); // increment for loop
							}
						?>
					</tbody>
					<tfooter>
						<tr>						
							<th >Total Working Days</th>	
							<th colspan="3"><?php echo $totdays;?></th>
							<th >Total Duration</th>														
							<th><?php echo $totDuration;?></th>
							<th></th>	
						</tr>
					</tfooter>
				</table>
					<!--<h2 class="text-center"><a data-toggle='modal' href='#modal-prevmonth' style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' >	Prev Month History	</a></h2>-->
				<form name="attend_form" id="attend_form" action="" method="post" >										
					<input type="hidden" id="attendanceid"  name="attendanceid" value="<?php echo $maxId;?>">
				</form>	
			</div>
		</div> 
	</div>
	<!-- Previous Month -->
	<div class="container">
		<div class="span12 distance_1">
			<?php 
				$preMonthSt = date('Y-m-16',strtotime("$preMonthSt -2 month"));
				$preMonthCur = date('Y-m-15',strtotime("$preMonthCur -1 month"));
				$preTotDuration = 0;
			?>
			<h2 class="text-center">Attendance for <?php echo $preMonthSt; ?> To <?php echo $preMonthCur; ?> </h2>			
			<!--<h2 class="text-right"><a data-toggle='modal' href='#modal-prevmonth' style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' >Prev Month - <?php echo $prevMonth; ?></a></h2>-->
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>						
							<th>Date - Day</th>
							<th>Check In</th>														
							<th>Check Out</th>
							<th>Status</th>
							<th>Break</th>
							<th>Total Time</th>
							<th>Signatures</th>	
						</tr>
					</thead>
					<tbody>
						<?php
							$preThisTime = date('Y-m-d');							
							$preThisTime = date('Y-m-16',strtotime("$preThisTime -1 month"));
							$preEndTime = date('Y-m-15',strtotime("$preThisTime -1 month"));
							while($preThisTime >= $preEndTime)
							{
								//echo $thisDate . $day ."<br>";
								
								$preThisDate = date('Y-m-d', strtotime($preThisTime));
								$preDay = date('D', strtotime($preThisTime));
								
								//$sql = "SELECT id, user_name,  DATE_FORMAT( checkin, '%Y-%m-%d %h:%i' ) AS checkin , DATE_FORMAT( checkout, '%Y-%m-%d %h:%i' ) AS checkout, signature_path from attendance where user_name = '$usname' AND DATE(checkin) = '$thisDate'" ;
								$sql = "SELECT id, user_name,  checkin, checkout, signature_path from attendance where user_name = '$usname' AND DATE(checkin) = '$preThisDate'" ;
								//echo $sql;
								$result = $mysqli->query($sql);
								//echo "rows" . $result->num_rows;
								if ($result->num_rows > 0) {
									$nofound = 1; 
									
									echo '<tr class="success">';
									while($row = $result->fetch_assoc()) { 										
										
										$dt1 = date('Y-m-d H:i',strtotime($row['checkin']));
										$dtt1 = date('H:i',strtotime($row['checkin']));
										if (isset($row['checkout'])) 
										{
											$dt2 = $row['checkout'];											
											
											$date_a = new DateTime($dt2);
											$date_b = new DateTime($dt1);
											//$interval = date_diff($date_a,$date_b);
											$interval = $date_a->diff($date_b);
											$fnduration =  strtotime($interval->format('%H:%i'));											
											$duration = date("H:i", strtotime('-30 minutes', $fnduration));
											// Sum up All Times											
											
											$dt2 = date('Y-m-d H:i', strtotime($dt2));
											$dtt2 = date('H:i', strtotime($dt2));
											//$dt1 = date('Y-m-d H:i', strtotime($dt1));
											//$duration = ($dt2 - $dt1)/60;
											//$duration =  SubTime($dt1,$dt2);
											$break ='30 Min';
										}	
											
									?>
											<td data-title="Date- Day"><?php echo $preThisDate;?> - <?php echo $preDay;?></th>
											<td data-title="CheckIn"><?php echo $dtt1;?></td>							
											<td data-title="CheckOut"><?php echo $dtt2;?></td>																		
											<td data-title="Status">P</td>
											<td data-title="Break"><?php echo $break;?></td>							
											<td data-title="Duration"><?php echo $duration;?></td>											
											<td data-title="Signatures"><img  src="documents/<?=$row['signature_path'];?>" style="width:50px; height:30px;" ></td>
									<?php 
										$preTotDuration = SumTime($duration, $preTotDuration);									
									}			
									echo '</tr>';	
								} else {								
									$nofound = 1; 
									
									echo '<tr class="error">'; ?>
																			
											<td data-title="Date- Day"><?php echo $preThisDate;?> - <?php echo $preDay;?></th>
											<td data-title="CheckIn">-</td>							
											<td data-title="CheckOut">-</td>							
											<td data-title="Status">A</td>
											<td data-title="Break">0</td>
											<td data-title="Duration">0</td>											
											<td data-title="Signatures">-</td>
									<?php }			
									echo '</tr>';	
								
								$preThisTime = date('Y-m-d',strtotime("$preThisTime -1 day")); // increment for loop
							}
						?>
					</tbody>
					<tfooter>
						<tr>
						<?php $preTotdays = $mysqli->query("SELECT count(id) AS Working from attendance where user_name = '$usname' AND DATE(checkin) between '$preMonthSt' AND '$preMonthCur'")->fetch_object()->Working; ?>			
							<th >Total Working Days</th>	
							<th colspan="3"><?php echo $preTotdays;?></th>
							<th >Total Duration</th>														
							<th><?php echo $preTotDuration;?></th>
							<th></th>	
						</tr>
					</tfooter>
				</table>
					<!--<h2 class="text-center"><a data-toggle='modal' href='#modal-prevmonth' style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' >	Prev Month History	</a></h2>-->
				<form name="attend_form" id="attend_form" action="" method="post" >										
					<input type="hidden" id="attendanceid"  name="attendanceid" value="<?php echo $maxId;?>">
				</form>	
			</div>
		</div> 
	</div>