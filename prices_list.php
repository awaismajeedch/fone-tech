<!DOCTYPE html>

<?php	
	//session_start();
	error_reporting(0);
	//if (empty($_SESSION['user_id']))
    //{
         /*** redirect ***/
      //  header("Location: index.php");
       // exit;
    //}
?>   

<?php
	include_once 'include/global.inc.php';
	//$compid  = $_SESSION['company_id'];
	$model = "";
	$part = "";
	$model = $_POST['model'];
	$part = $_POST['part'];
	
	$modelsql = "";
	if (!empty($model)) {
		$modelsql = " AND model like '%$model%'";		
	}
	$partsql = "";
	if (!empty($part)) {
		$partsql = " AND part like '%$part%'";
	}
	
	$tablename="prices";
	$orderby = " ORDER BY created_at DESC";
	$where= "1=1 $modelsql $partsql";
	
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
	<input type="hidden" name="txtmodels" id="txtmodels" value="<?php echo $model; ?>" />
	<input type="hidden" name="txtparts" id="txtparts" value="<?php echo $part; ?>" />
	<!--<div class="pull-right" > 
		<?php echo "Total Pages: " .$totalPages ?>
	</div>-->
	
    <div class="span12">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>						
						<th>Image</th>
						<th>Part Name</th>							
						<th>Manufacturer</th>
						<th>Model </th>
						<th>Price</th>												
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($totalRecords > 0) {
							foreach ($datar as $row) { 
					?>	
						<tr>
							<?php $rid = $row['id'];?>	
							<?php if (!empty($row['image_name'])) { ?>
								<td data-title="Image"><img  src="documents/<?=$row['image_name'];?>" style="width:50px; height:50px;" ></td>
							<?php } else { ?>	
								<td data-title="Image"><img alt="" src="images/noimage.jpg" style="width:50px; height:50px;" /></td>															
							<?php } ?>								
							<td data-title="Part Name"><a href="#"  style="font-size:14px; font-weight:bold; color:#DE5050; text-decoration:underline;" onClick="javascript:editRecord('<?=$row['id']?>','<?=$row['make']?>','<?=htmlentities($row['model'])?>','<?=$row['part']?>','<?=$row['price']?>','<?=$row['image_name']?>','<?=$row['viewed']?>','<?=$row['comments']?>');"><?php echo $row['part'];?></a></td>																									
							<td data-title="Manufacturer"><?php echo $row['make'];?></td>							
							<td data-title="Model"><?php echo $row['model'];?></td>							
							<td data-title="Price"><?php echo $row['price'];?></td>							
							<td data-title="Action"><a href="javascript:confDelete('<?php echo $rid; ?>');" ><img  src="images/minus.png" title="Delete Part" style="width:20px; height:20px;" ></a></td>								
						</tr>
					<?php 							
							
						}	
					} else { ?>
						<tr>
							<td colspan="5">No Record Found</td>
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
		var smodel = $('#txtmodels').val();		
		var spart = $('#txtparts').val();
		
		currentPage++;
							
		$.post("prices_list.php",{pageNum:currentPage,model:smodel,part:spart},function(data){
			$('#priceslist').html(data);
		});
		
	}
	
	function previousRecords() {
		
		var smodel = $('#txtmodels').val();
		var spart = $('#txtparts').val();
		var currentPage = $('#currentPage').val();
		currentPage--;
		
		$.post("prices_list.php",{pageNum:currentPage,model:smodel,part:spart},function(data){
		
			$('#priceslist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		var smodel = $('#txtmodels').val();
		var spart = $('#txtparts').val();
		
		$.post("prices_list.php",{pageNum:cpage,model:smodel,part:spart},function(data){
		
			$('#priceslist').html(data);
		});
	}
		
	
	function editRecord(id,make,model,part,price,imagename,view,comment) {
		
		$('#collapseTwo').collapse('hide');	   
		$('#collapseOne').collapse('show');
		
		document.getElementById('txtmake').value = make;
		document.getElementById('txtmodel').value = model;
		document.getElementById('txtpart').value = part;
		document.getElementById('txtprice').value = price;
		if (view == 1) {			 
			document.getElementById("chkviewed").checked = true;
			document.getElementById("txtviewed").value = 1;	   	   	
		} else {
			document.getElementById("chkviewed").checked = false;
			document.getElementById("txtviewed").value = 0;	   	   
		}	
			
		document.getElementById('userdbimage').value = imagename;
		document.getElementById('txtcomments').value = comment;		
		document.getElementById("txtid").value = id;	   	   
	}		
	
	
	function confDelete(uId) {
		 bol = confirm("Are you sure to delete this record?");
        if ( bol ) {
			$.post("delete_controller.php",{id:uId,type:'price'},function(data){
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

