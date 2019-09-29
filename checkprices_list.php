<!DOCTYPE html>

<?php	
	//session_start();
	error_reporting(0);	
?>   

<?php
	include_once 'include/global.inc.php';
	//$compid  = $_SESSION['company_id'];
	$make = "";
	$model = "";
	$part = "";
	
	$make = $_POST['make'];
	$model = $_POST['model'];
	$part = $_POST['part'];
	$viewed = 1; 
	
	$makesql = "";
	if (!empty($make)) {
		$makesql = " AND make = '$make'";
		$viewed = 0;
	}
	
	$modelsql = "";
	if (!empty($model)) {
		$modelsql = " AND model like '%$model%'";		
		$viewed = 0; 
	}
	$partsql = "";
	if (!empty($part)) {
		$partsql = " AND part like '%$part%'";
		$viewed = 0;
	}
	
	$viewsql = "";
	
	if ($viewed == 1) {
		$viewsql = "AND viewed = 1";
	}		
	
	
	$tablename="prices";
	$orderby = " ORDER BY created_at DESC";
	$where= "1=1 $viewsql $makesql $modelsql $partsql";
	//echo $where;
	
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
	<input type="hidden" name="txtmakes" id="txtmakes" value="<?php echo $make; ?>" />
	<input type="hidden" name="txtmodels" id="txtmodels" value="<?php echo $model; ?>" />
	<input type="hidden" name="txtparts" id="txtparts" value="<?php echo $part; ?>" />	
	
	<!--<div class="pull-right" > 
		<?php echo "Total Pages: " .$totalPages ?>
	</div>-->
	
    <div class="span12">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>						
						<th>Image</th>
						<th>Part Name</th>							
						<th>Manufacturer</th>
						<th>Model </th>
						<th>Price</th>
						<th>Comments</th>	
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
							<td data-title="Part Name"><?php echo $row['part'];?></td>																									
							<td data-title="Manufacturer"><?php echo $row['make'];?></td>							
							<td data-title="Model"><?php echo $row['model'];?></td>							
							<td data-title="Price"><?php echo $row['price'];?></td>	
							<td data-title="Comments"><?php echo $row['comments'];?></td>	
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
		var smake = $('#txtmakes').val();		
		var smodel = $('#txtmodels').val();		
		var spart = $('#txtparts').val();
		
		currentPage++;
							
		$.post("checkprices_list.php",{pageNum:currentPage,model:smodel,part:spart,make:smake},function(data){
			$('#checkpriceslist').html(data);
		});
		
	}
	
	function previousRecords() {
		var smake = $('#txtmakes').val();		
		var smodel = $('#txtmodels').val();
		var spart = $('#txtparts').val();
		var currentPage = $('#currentPage').val();
		currentPage--;
		
		$.post("checkprices_list.php",{pageNum:currentPage,model:smodel,part:spart,make:smake},function(data){
		
			$('#checkpriceslist').html(data);
		});
		
	}
	
	function jumpToRecords(cpage) {
		var smake = $('#txtmakes').val();		
		var smodel = $('#txtmodels').val();
		var spart = $('#txtparts').val();
		
		$.post("checkprices_list.php",{pageNum:cpage,model:smodel,part:spart,make:smake},function(data){
		
			$('#checkpriceslist').html(data);
		});
	}
	
	
</script>

</body>
</html> 

