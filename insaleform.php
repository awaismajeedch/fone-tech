<?php
	
	
	if (empty($_SESSION['user_id']))
    {
         /*** redirect ***/
        header("Location: index.php");
        exit;
    }
	
	include_once 'include/global.inc.php';
	$tablenames="shops";
	$orderbys = " ORDER BY name ASC";
	$wheres= " 1=1 AND (status = 'active' OR status IS NULL OR status = ' ')";
	$datas = $db->select($tablenames,$orderbys, $wheres);
	
?>   	
	

<div class="row-fluid">
	<div class="row-fluid">
		<form class="form-horizontal" id="insaleform"  name="insaleform" method="post" >	
		<div class="span12 discover">				
			<div class="span5">	
				<div class="control-group">							
					<label class="control-label" >Shop Name: </label>
					<div class="controls">
						<select name="ishop" id="ishop" class="input-large">	
							<option value="">--Select--</option>
							<?php 
								foreach ($datas as $srow) { ?>
								
								<option value="<?php echo $srow['id'];?>"><?php echo $srow['name'];?></option>
							
							<?php } ?>
						</select>	
					</div>
				</div>															
				<div class="control-group">
					<label class="control-label" >Make: </label>
					<div class="controls">													
						<input  type="text" name="imake" id="imake"  class="input-large" tabindex="1" >
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label" >Received </label>
					<div class="controls">													
						<select name="cmbrec" id="cmbrec" class="input-large">	
							<option value="">--Select--</option>
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
				</div>	
			</div>
			<div class="span5">														
				<div class="control-group">							
					<label class="control-label" >Model: </label>
					<div class="controls">												
						<input  type="text"  name="imodel" id="imodel" class="input-large" tabindex="2" />																								
					</div>
				</div>
				<div class="control-group">							
					<label class="control-label" >IMEI: </label>
					<div class="controls">												
						<input  type="text"  name="inetwork" id="inetwork" class="input-large" tabindex="2" />																								
					</div>
				</div>
				<!-- DateRangePicker -->
				<!-- style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 120%" -->
				<div class="control-group">							
					<label class="control-label" >DateRange </label>
					<div class="controls">												
						<div id="reportrange">
							<!-- <i class="fa fa-calendar"></i>&nbsp; -->
							<!-- <span></span> -->
							<input type="text" name="irange" style="width:130%;"> 
							<!-- <i class="fa fa-caret-down"></i> -->
						</div>	
					</div>
				</div>
				<div class="control-group">							
					<a href="javascript:saleForm();"  class="button_bar" style="float:right;">Search</a>											
				</div>	
			</div>		
		
		</div>	
		</form>
	</div>	
	<div class="row-fluid">												
		<div id="insalelist">
			<?php
				include_once($pathaj."insale_list.php");
			?>	
		</div>												
	</div> 	
						
</div>  


<script type="text/javascript">		
		
	function saleForm() {
		
		var serializedData = $('#insaleform').serialize();				
			$.post("insale_list.php",serializedData,function(data){
				$('#insalelist').html(data);
			});
		
	}
	
	
</script>

<script type="text/javascript">
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'All': [moment().subtract(4,'year'), moment()],
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'Last Year': [moment().subtract(1, 'year'), moment()]
        }
    }, cb);

    cb(start, end);

});
</script>