<!DOCTYPE html>

<?php
error_reporting(0);	
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
	$pshopid = $_SESSION['shop_id'];	
	$ptablename="unlocks";
	$porderby = " ORDER BY created_at DESC";
	$pwhere= "shop_id=$pshopid AND status='Success'";
	
	$prfid = 00;
	$precordsPerPage = 10;
	$ppage = 1;	
	$ptotalPages = 0;	
	if ( isset ($_POST['ppageNum'] ) ) {
		$ppage = $_POST['ppageNum'];
	}
	
	$pdata = $db->totalRecords($ptablename, $pwhere);
	//echo $pdata;		
	$totalRecords = $pdata;
	
	if ($totalRecords != 0) {
		$ptotalPages = ceil( $totalRecords/$precordsPerPage);
		if ( $ppage >= $ptotalPages ) {
			$ppage = $ptotalPages;
		}
		$pstartPage = ($ppage - 1) * $precordsPerPage;			
		$pdatar = $db->selectdata($ptablename, $pwhere, $porderby, $pstartPage, $precordsPerPage);
	}
?>	

<body>
	<input type="hidden" id="pcurrentPage" value="<?=$ppage?>" />
	<!--
	<div class="pull-right" > 
		<?php echo "Total Pages: " .$ptotalPages ?>
	</div>
	-->
    
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
						<!--<th>Email</th>	-->
						<th>Notes</th>
						<th>Lab Notes</th>
						<th>Status</th>
						<!--<th>Charges</th>-->
						<th>Code</th>						
						
					</tr>
				</thead>
				<tbody>
					<?php if ($totalRecords > 0) {
							foreach ($pdatar as $row) {								
								$timestamp = strtotime($row['date_entered']);							
								$dateenter =  date("d/m/Y", $timestamp);
									if ($row['checked'] == 'no') 
										echo '<tr class="success">';
									else
										echo '<tr>';
									?>	
										
											<td data-title="Date"><?php echo $dateenter;?></td>																		
											<td data-title="Invoice"><?php echo $row['invoice'];?></td>											
											<td data-title="Informed"><?php echo $row['informed'];?></td>
											<?php $prfid = $row['id'];												  													  
													  $strinvoice = $row['invoice']; 
													  $strimei = $row['imei']; 
													  $strsummary =  json_encode($row['summary']); 
													  $strcode =  json_encode($row['code']);													  
													  $strnotes =  json_encode($row['notes']);													  
													  $strlnotes =  json_encode($row['labnotes']);													  
													  $stremail =  trim(json_encode($row['email']));
													  $strname =  trim(json_encode($row['name']));
													  $strcontact =  trim(json_encode($row['contact']));
													  
													  echo "<td data-title='IMEI'><a data-toggle='modal' href='#modal-signin' style='font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;' onclick='setDataf($prfid,$strinvoice,$strimei,$strsummary,$strcode,$strnotes,$strlnotes,$stremail,$strname,$strcontact);'>$strimei</a></td>";
												?>																			
											
											<td data-title="Summary" style="word-break:break-all;width:100px"><?php echo $row['summary'];?></td>
											<td data-title="Duration"><?php echo $row['duration'];?></td>
											<!--<td data-title="Email"><?php echo $row['email'];?></td>	-->
											<td data-title="Notes"><?php echo $row['notes'];?></td>											
											<td data-title="Lab Notes"><?php echo $row['labnotes'];?></td>	
											<td data-title="Status"><?php echo $row['status'];?></td>	
											<!--<td data-title="Charges"><?php echo $row['charges'] ?></td>	-->
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
				if ($ppage > 1 ) {
				?>		
				<li>
					<a href="javascript:{}" onclick="javascript:ppreviousRecords();">Prev</a>
				</li>  
				<?php
				}
				?>				
				
				<?php
				for($i=1; $i <= $ptotalPages; $i++) {
					if($ppage==$i){
				?>
					<li class="active">
						<a href="javascript:{}" onclick="javascript:pjumpToRecords(<?php echo $i?>);"><?php echo $i?><span class="sr-only">(current)</span></a>
					</li>
				<?php } 
					else {
					?>
						<li>
							<a href="javascript:{}" onclick="javascript:pjumpToRecords(<?php echo $i?>);"><?php echo $i?></a>
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
					if ($ppage < $ptotalPages ) {
					?>		
					<li>
						<a href="javascript:{}" onclick="javascript:pnextRecords();">Next</a>
					</li>	
					<?php
					}
				?>
			</ul> 
		</div>	
	
	
<div class='modal hide fade' id='modal-signin' role='dialog' tabindex='-1' style="width: 700px;position:fixed;">
	<div class='modal-header'>
		<button class='close' data-dismiss='modal' type='button' onclick="javascript:DivRefresh();">&times;</button>
		<h3>Add/Edit Balance</h3>
	</div>
	<div class='modal-body' >		
		<div class='controls text-center'>			
			<div class='form-wrapper'>
				<form name="bal_form" id="bal_form" class="form-horizontal" action="" method="post" >										
					<div class="row-fluid" >	
						<div class="span10" >
							<div class="row-fluid" >	
								<div class="span5" >
									<div class="control-group">							
										<label class="control-label" >Invoice No: </label>
										<div class="controls">												
											<input  type="text"  name="txtfinvoice" id="txtfinvoice" class="input-small" value = "" disabled />																								
										</div>
									</div>
								</div>
								<div class="span5" >
									<div class="control-group" >							
									<label class="control-label" >Code: </label>
									<div class="controls">	
										<input class="input-small" id="txtfcode" name="txtfcode" type="text"  disabled />									
									</div>
								</div>	
							</div>	
							<div class="control-group">							
								<label class="control-label" >IMEI: </label>
								<div class="controls">	
									<input class="input-large" id="txtfime" name="txtfime" type="text" value="" disabled />									
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label" >Summary: </label>
								<div class="controls">	
									<input class="input-large" id="txtfsummary" name="txtfsummary" type="text" value="" disabled />									
								</div>
							</div>	
							
							<div class="control-group">							
								<label class="control-label" >Lab Notes: </label>
								<div class="controls">
									<textarea  name="txtflbnotes" id="txtflbnotes" class="input-large" readonly></textarea>
								</div>
							</div>		
							<div class="control-group">							
								<label class="control-label" >Shop Notes: </label>
								<div class="controls">
									<textarea  name="txtfnotes" id="txtfnotes" class="input-large" readonly></textarea>
								</div>
							</div>
							
							<div class="control-group">							
								<label class="control-label" >Client Email: </label>
								<div class="controls">
									<input type="text"  name="txtcmail" id="txtcmail" class="input-large" readonly />
								</div>
							</div>	
							<div class="row-fluid" >	
								<div class="span5" >
									<div class="control-group">							
										<label class="control-label" >Client Name: </label>
										<div class="controls">
											<input type="text"  name="txtcname" id="txtcname" class="input-small" readonly />
										</div>
									</div>
								</div>
								<div class="span5" >
									<div class="control-group">							
										<label class="control-label" >Contact#: </label>
										<div class="controls">
											<input type="text"  name="txtccontact" id="txtccontact" class="input-small" readonly />
										</div>
									</div>
								</div>
							</div>
							<div class="control-group">							
								<label class="control-label">Customer Informed: </label>
								<div class="controls">							
									<input id="chkinformed" type="checkbox"  name="chkinformed">	
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
		<a href="javascript:validateBal();" name="btnmail" id="btnmail" class="button_bar" style="visibility:hidden;margin-left:15%;">Send Email to Client</a>
		<a href="javascript:updateInform();" style="margin-left:5%;" class="button_bar" >Save</a>		
	</div>
</div>	
	
<script type="text/javascript">
	
	function pnextRecords() {
		
		var pcurrentPage = $('#pcurrentPage').val();
		pcurrentPage++;
							
		$.post("unlockfixed_list.php",{ppageNum:pcurrentPage},function(data){
			$('#unlockfixedlist').html(data);
		});
		
	}
	
	function ppreviousRecords() {
		
		var pcurrentPage = $('#pcurrentPage').val();
		pcurrentPage--;
		
		$.post("unlockfixed_list.php",{ppageNum:pcurrentPage},function(data){
		
			$('#unlockfixedlist').html(data);
		});
		
	}
	
	function pjumpToRecords(ppage) {
		
		$.post("unlockfixed_list.php",{ppageNum:ppage},function(data){
		
			$('#unlockfixedlist').html(data);
		});
	}
				
function setDataf(id,invoice,imei,summary,code,notes,lnotes,mail,name,contact) {
		
		document.getElementById('txtrepid').value = id;
		document.getElementById('txtfinvoice').value = invoice;	
		document.getElementById('txtfime').value = imei;				
		document.getElementById('txtfsummary').value = summary;				
		document.getElementById('txtfnotes').value = notes;
		document.getElementById('txtfcode').value = code;				
		document.getElementById('txtflbnotes').value = lnotes;	
		document.getElementById('txtcname').value = name;
		document.getElementById('txtccontact').value = contact;
		document.getElementById('txtcmail').value = mail;				
		if (mail !== "" && mail !== null) {
			//alert(mail);
			//document.getElementById("btnmail").enabled = true;			
			//document.getElementById("btnmail").setAttribute("visibility", "true");
			document.getElementById("btnmail").style.visibility = "visible";
		}
		
		/*
		
		if (lcharges > 0) {
			document.getElementById('txtlabcharges').value = lcharges;
			document.getElementById('txtlabcharges').readOnly  = true;
		} else {
			document.getElementById('txtlabcharges').value = 0;
		}
		*/
		
		$.post("unlockstatus_controller.php",{rid:id},function(data){
			   //alert(data);
			   //$('#unlockfixedlist').html(data);
			
			});
		
	}
	function DivRefresh() {
		var pcurrentPage = $('#pcurrentPage').val();
		
		$.post("unlockfixed_list.php",{ppageNum:pcurrentPage},function(data){
			$('#unlockfixedlist').html(data);
		});
    }
		
	function validateBal() {
		var success = 1;			
    	
		
		if (success == 1) {
			
			var serializedData = $('#bal_form').serialize();		
						
			$.post("unlockingfixed_controller.php",serializedData,function(data){
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
	function updateInform() {
		
			var serializedData = $('#bal_form').serialize();		
			$.post("updateinform_controller.php",serializedData,function(data){
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

