<!DOCTYPE html>

<?php
	$mainCat = "Repairs";	
	include_once 'path.php';	
?>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  

<head>
    <html dir="ltr" lang="en-US">
	<meta charset="UTF-8" /> 
	<title>fone-tech</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">    
    <link rel="shortcut icon" href="favicon.ico">  
    <?php
		include_once($path ."head.php"); 
	?> 
	<style type="text/css">
	.typeahead {
		z-index: 1000;
	}	
	</style>
</head> 

<body >
<!-- Include Header  -->
<?php
	include_once($path ."sadminheader.php"); 
	if (empty($_SESSION['user_id']))
    {
         /*** redirect ***/
        header("Location: index.php");
        exit;
    }
	
	include_once 'include/global.inc.php';
	$tablename="shops";
	$orderby = " ORDER BY name ASC";
	$where= " 1=1 AND (status = 'active' OR status IS NULL OR status = ' ')";
	$datar = $db->select($tablename,$orderby, $where);
	
?>   
<div class="row-fluid ">
	<div class="span12">		
		<!-- LayerSlider Content End -->
		<div class="row-fluid divider slide_divider base_color_background">
			<div class="container">                       
			</div>
		</div>
		<div class="container">					
			<div class="row-fluid distance_1" style="margin-top:30px;">	
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_rlist" onclick="javascript:refreshMe();" data-toggle="tab">
						Repairs Listing</a>
					</li>					
					<li>
						<a href="#tab_rslist" data-toggle="tab">
						Repair Sheet </a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_rlist">		
						<div class="row-fluid">
							<form class="form-horizontal" id="searchrform"  name="searchrform" method="post" >	
							<div class="span12 discover">				
								<div class="span5">	
									<div class="control-group">							
										<label class="control-label" >Shop Name: </label>
										<div class="controls">
											<select name="txtshop" id="txtshop" class="input-large"/>	
												<option value="">--Select--</option>
												<?php 
													foreach ($datar as $row) { ?>
													
													<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
												
												<?php } ?>
											</select>	
										</div>
									</div>															
									<div class="control-group">							
										<label class="control-label" >Status: </label>
										<div class="controls">												
											<select name="txtstatus" id="txtstatus" class="input-large">	
												<option value="">--Select--</option>
												<option value="Inprogress">Inprogress</option>
												<option value="Pending">Pending</option>
												<option value="Fixed">Fixed</option>
												<option value="NotFixed">Not Fixed</option>
											</select>	
										</div>
									</div>	
									<div class="control-group">
											<label class="control-label" >Invoice#: </label>
											<div class="controls">									
												<input  type="text" class="input-large" name="txtinv" id="txtinv" value="" >									
											</div>
									</div>	
								</div>
								<div class="span5">														
									<div class="control-group">
										<label class="control-label" >Start Date: </label>
										<div class="controls">
											<div class="input-append date" name="sdate" id="sdate" data-date="" data-date-format="dd/mm/yyyy" >
											<input  size="10" type="text" name="txtsdate" id="txtsdate" value="" >
											<span class="add-on"><i class="icon-calendar"></i></span>											
											</div>														
										</div>
									</div>																							
									<div class="control-group">
										<label class="control-label" >End Date: </label>
										<div class="controls">
											<div class="input-append date" name="edate" id="edate" data-date="" data-date-format="dd/mm/yyyy" >
											<input  size="10" type="text" name="txtedate" id="txtedate" value="" >
											<span class="add-on"><i class="icon-calendar"></i></span>											
											</div>														
										</div>
									</div>						
									<div class="control-group">							
										<label class="control-label" >Refix: </label>
										<div class="controls">												
											<select name="txtrefix" id="txtrefix" class="input-large">	
												<option value="">--Select--</option>
												<option value="yes">Yes</option>
												<option value="no">No</option>										
											</select>	
										</div>
									</div>
									<div class="control-group">							
										<a href="javascript:validatesForm();"  class="button_bar" style="float:right;">Search</a>											
									</div>	
								</div>		
							
							</div>	
							</form>
						</div>	
						<div class="row-fluid">	
							<div>
								<div id="statuscount">
									<?php
										include_once($pathaj."status_count.php");
									?>	
								</div>	
							</div>
						</div>
						<div class="row-fluid">	
							<div class="accordion" id="accordion">													
								<div class="accordion-group">
									<div class="accordion-heading">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
											<h4>Account Summary</h4>									
										</a>
									</div>
									<div id="collapseOne" class="accordion-body collapse">
										<div class="accordion-inner">
											<div class="text-block-1">									  
												<div>	
													<div id="summarylist">
													<?php
														include_once($pathaj."summary_list.php");
													?>	
													</div>		
												</div>
											</div> 								
										</div>
									</div>
								</div>		
							</div>
						</div>		
						<div class="row-fluid">	
							<div>
								<div id="repairsmainlist">
									<?php
										include_once($pathaj."repairsmain_list.php");
									?>	
								</div>												
							</div> 			
						</div>
					</div>
					<div class="tab-pane" id="tab_rslist">
						<?php
							include_once($pathaj."adminrepsearch.php");
						?>	
					</div>
				</div>
						
			</div>    				
		</div>
	</div>
</div>		

<footer>
   <?php
		include_once($path."footer.php");                
	?>
</footer>
</body>
</html>
<script>
	$(document).ready(function(){
						
		$('#sdate').datepicker();				
		$('#edate').datepicker();				
	  });

	$('#txtshop').typeahead({
        source: function (query, process) {
            return $.getJSON('shoplist.php', { query: query }, function (data) {
                return process(data);
            });
        },

        minLength : 2,
        //items : 4,
        property: 'name'
    });
	
		
</script>


<script type="text/javascript">		
		
	function validatesForm() {
		
		var serializedData = $('#searchrform').serialize();				
			$.post("repairsmain_list.php",serializedData,function(data){
				$('#repairsmainlist').html(data);
			});
			$.post("status_count.php",serializedData,function(data){
				$('#statuscount').html(data);
			});
	}
	
	
</script>
