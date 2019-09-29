<!DOCTYPE html>

<?php
//error_reporting(0);
session_start();
	/*	
	if (empty($_SESSION['user_id']))
    {
      
        header("Location: index.php");
        exit;
    }
	*/
?>   

<?php
	include_once 'include/global.inc.php';
	$cshopid = $_SESSION['shop_id'];	
	$ctablename="unlocks";
	$corderby = " ORDER BY created_at DESC";
	$cwhere= "shop_id=$cshopid AND status='Rejected'";
	
	$crfid = 00;
	$crecordsPerPage = 10;
	$cpage = 1;	
	$ctotalPages = 0;	
	if ( isset ($_POST['cpageNum'] ) ) {
		$cpage = $_POST['cpageNum'];
	}
	
	$cdata = $db->totalRecords($ctablename, $cwhere);
	//echo $cdata;		
	$totalRecords = $cdata;
	
	if ($totalRecords != 0) {
		$ctotalPages = ceil( $totalRecords/$crecordsPerPage);
		if ( $cpage >= $ctotalPages ) {
			$cpage = $ctotalPages;
		}
		$cstartPage = ($cpage - 1) * $crecordsPerPage;			
		$cdatar = $db->selectdata($ctablename, $cwhere, $corderby, $cstartPage, $crecordsPerPage);
	}
?>	

<body>
	<input type="hidden" id="ccurrentPage" value="<?=$cpage?>" />
	<!--
	<div class="pull-right" > 
		<?php echo "Total Pages: " .$ctotalPages ?>
	</div>
	-->
    <div class="span12">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Invoice</th>
						<th>Informed</th>						
						<th>IMEI</th>						
						<th>Summary</th>																			
						<th>Duration</th>
						<th>Notes</th>							
						<th>Status</th>
						<!--<th>Charges</th>-->
						<th>Lab Notes</th>
						<th>Code</th>						
					</tr>
				</thead>
				<tbody>
					<?php if ($totalRecords > 0) {
							foreach ($cdatar as $row) {								
								$timestamp = strtotime($row['date_entered']);							
								$dateenter =  date("d/m/Y", $timestamp);
									?>	
										<tr>
											<?php $prfid = $row['id'];?>																																								
											<td data-title="Date"><?php echo $dateenter;?></td>																		
											<td data-title="Invoice"><?php echo $row['invoice'];?></td>	
											<td data-title="Informed"><?php echo $row['informed'];?></td>
											<?php $rjid = $row['id'];												  													  													  
													  $strjmail =  trim(json_encode($row['email']));
													   $strjmei = $row['imei']; 
													  echo "<td data-title='IMEI'><a data-toggle='modal' href='#modal-reject' style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' onclick='setRDataf($rjid,$strjmail);'>$strjmei</a></td>";
												?>																																	
											<td data-title="Summary"><?php echo $row['summary'];?></td>
											<td data-title="Duration"><?php echo $row['duration'];?></td>
											<td data-title="Notes"><?php echo $row['notes'];?></td>
											<!--<td data-title="Email"><?php echo $row['email'];?></td>	-->
											<td data-title="Status"><?php echo $row['status'];?></td>	
											<!--<td data-title="Charges"><?php echo $row['charges'] ?></td>-->
											<td data-title="Lab Notes"><?php echo $row['labnotes'];?></td>	
											<td data-title="Code"><?php echo $row['code'];?></td>											
										</tr>
												
									<?php 							
							
							}	
						} else { ?>
						<tr>
							<td colspan="12">No Record Found</td>
						</tr>	
						<?php
						}		
						?>  
				</tbody>
			</table>
		</div>
		<div class="pagination pagination-centered">
			<ul>
				<?php
				if ($cpage > 1 ) {
				?>		
				<li>
					<a href="javascript:{}" onclick="javascript:cpreviousRecords();">Prev</a>
				</li>  
				<?php
				}
				?>				
				
				<?php
				for($i=1; $i <= $ctotalPages; $i++) {
					if($cpage==$i){
				?>
					<li class="active">
						<a href="javascript:{}" onclick="javascript:cjumpToRecords(<?php echo $i?>);"><?php echo $i?><span class="sr-only">(current)</span></a>
					</li>
				<?php } 
					else {
					?>
						<li>
							<a href="javascript:{}" onclick="javascript:cjumpToRecords(<?php echo $i?>);"><?php echo $i?></a>
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
					if ($cpage < $ctotalPages ) {
					?>		
					<li>
						<a href="javascript:{}" onclick="javascript:cnextRecords();">Next</a>
					</li>	
					<?php
					}
				?>
			</ul> 
		</div>	
	</div> 	
	
<div class='modal hide fade' id='modal-reject' role='dialog' tabindex='-1' style="width: 700px;position:fixed;">
	<div class='modal-header'>
		<button class='close' data-dismiss='modal' type='button' onclick="javascript:DivRefreshrj();">&times;</button>
		<h3>Send Email to Client</h3>
	</div>
	<div class='modal-body' >		
		<div class='controls text-center'>			
			<div class='form-wrapper'>
				<form name="rej_form" id="rej_form" class="form-horizontal" action="" method="post" >										
					<div class="row-fluid" >							
							<div class="control-group">							
								<label class="control-label" >Client Email: </label>
								<div class="controls">
									<input type="text"  name="txtrejmail" id="txtrejmail" class="input-large" />
								</div>
							</div>														
							<div class="control-group">							
								<label class="control-label">Customer Informed: </label>
								<div class="controls">							
									<input id="chkrejinformed" type="checkbox"  name="chkrejinformed">	
								</div>
							</div>							
							<input type="hidden"  name="txtrejid" id="txtrejid" value="" >	
										
					</div>	
				</form>
			</div>
		</div>
	</div>
	<div class='modal-footer'>		
		<a href="javascript:sendRejEmail();" name="btnrmail" id="btnrmail" class="button_bar" >Send Email to Client</a>
		<a href="javascript:updateRInform();" style="margin-left:5%;" class="button_bar" >Save</a>		
	</div>
</div>	
	
<script type="text/javascript">
	
	function cnextRecords() {
		
		var ccurrentPage = $('#ccurrentPage').val();
		ccurrentPage++;
							
		$.post("unlockcompleted_list.php",{cpageNum:ccurrentPage},function(data){
			$('#unlockcompletedlist').html(data);
		});
		
	}
	
	function cpreviousRecords() {
		
		var ccurrentPage = $('#ccurrentPage').val();
		ccurrentPage--;
		
		$.post("unlockcompleted_list.php",{cpageNum:ccurrentPage},function(data){
		
			$('#unlockcompletedlist').html(data);
		});
		
	}
	
	function cjumpToRecords(cpage) {
		
		$.post("unlockcompleted_list.php",{cpageNum:cpage},function(data){
		
			$('#unlockcompletedlist').html(data);
		});
	}
		
	function setRDataf(id,mail) {
		
		document.getElementById('txtrejid').value = id;		
		document.getElementById('txtrejmail').value = mail;
		
	}	
	
	function DivRefreshrj() {
		var pcurrentPage = $('#ccurrentPage').val();
		
		$.post("unlockcompleted_list.php",{cpageNum:ccurrentPage},function(data){
			$('#unlockcompletedlist').html(data);
		});
    }
	
	function sendRejEmail() {
			var success = 1;			
			
			if (document.getElementById("txtrejmail").value == "" ) {
            alert("Please enter Email!");
			success = 0;
            return;
			
			}
			
			if (document.getElementById('txtrejmail').value != "" ) {
				var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				var address = document.getElementById('txtrejmail').value;
				if(reg.test(address) == false) {
				  alert("Please enter valid Email!");		  
				  success = 0;
				  return;
				}
			}
			
			if (success == 1) {
				
				var serializedData = $('#rej_form').serialize();		
							
				$.post("unlockingcompleted_controller.php",serializedData,function(data){
				   //alert(data);
				   if (data > 0 ) {							
						alert ("Email is sent Successfully!");
						//location.reload(); 
					} else {
						alert ("Email could not be sent! Please try again later");			
						//location.reload(); 
					}		
				  
				});
				
			}	
	}
	function updateRInform() {
		
			var informed = document.getElementById('chkrejinformed').checked;
			var repid = document.getElementById('txtrejid').value;	
			
			$.post("updateinform_controller.php",{chkinformed:informed, txtrepid:repid},function(data){
			   //alert(data);
			   if (data > 0 ) {							
					alert ("Data is saved Successfully!");
					//location.reload(); 
				} else {
					alert ("Data could not be saved! Please try again later");			
					//location.reload(); 
				}		
			  
			});
		
	}				
	
</script>

</body>
</html> 

