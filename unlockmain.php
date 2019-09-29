<!DOCTYPE html>

<?php
	$mainCat = "Unlock";	
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
			<!-- Tab1 Data -->			
			<div class="row-fluid distance_1" style="margin-top:30px;">	
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_list" data-toggle="tab">
						Unlock List</a>
					</li>					
					<li>
						<a href="#tab_desc" data-toggle="tab">
						Unlock Description </a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_list">	
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
												<!--<option value="Pending">Pending</option>-->
												<option value="Success">Success</option>
												<option value="Rejected">Rejected</option>
											</select>	
										</div>
									</div>	
									<div class="control-group">
										<label class="control-label" >IMEI#: </label>
										<div class="controls">									
											<input  type="text" class="input-large" name="txtimi" id="txtimi" value="" >									
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
										<a href="javascript:validatesForm();"  class="button_bar" style="float:right;">Search</a>											
									</div>	
								</div>		
							
							</div>	
							</form>
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
														include_once($pathaj."unlocksummary_list.php");
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
							<div id="unlockmainlist">
								<?php
									include_once($pathaj."unlockmain_list.php");
								?>	
							</div>												
						</div> 	
					</div>
					<div class="tab-pane" id="tab_desc">
						<?php
							include_once($pathaj."unlockdataform.php");
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
			$.post("unlockmain_list.php",serializedData,function(data){
				$('#unlockmainlist').html(data);
			});
		
	}
	
	
</script>
