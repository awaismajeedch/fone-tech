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
	$where= " 1=1";
	$datar = $db->select($tablename,$orderby, $where);
	
	$tablenamel="labs";		
	$datal = $db->select($tablenamel,$orderby, $where);
	
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
				<div class="row-fluid">
					<form class="form-horizontal" id="searchrform"  name="searchrform" method="post" >	
					<div class="span12 discover">				
						<div class="span5">	
							<div class="control-group">							
								<label class="control-label" >Shop Name: </label>
								<div class="controls">
									<select name="txtshop" id="txtshop" class="input-large" onchange="javascript:setShop();">	
										<option value="">--Select--</option>
										<?php 
											foreach ($datar as $row) { ?>
										 	
											<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
										
										<?php } ?>
									</select>	
								</div>
							</div>															
							<div class="control-group">							
								<label class="control-label" >Labs Name: </label>
								<div class="controls">
									<select name="txtlab" id="txtlab" class="input-large" onchange="javascript:setLab();">	
										<option value="">--Select--</option>
										<?php 
											foreach ($datal as $lrow) { ?>
										 	
											<option value="<?php echo $lrow['id'];?>"><?php echo $lrow['name'];?></option>
										
										<?php } ?>
									</select>	
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
						<input type="hidden" name="selshop" id="selshop">
						<input type="hidden" name="sellab" id="sellab">
					</div>	
					</form>
				</div>		
				<div class="row-fluid">	
					<div class="text-block-1">									  
						<div>	
							<div id="accountsummary">
							<?php
								include_once($pathaj."accounts_summary.php");
							?>	
							</div>		
						</div>
					</div> 	
				</div>
				<!--	
				<div class="row-fluid">	
					<div>
						<div id="repairsmainlist">
							<?php
							//	include_once($pathaj."repairsmain_list.php");
							?>	
						</div>												
					</div> 			
				</div>  
				-->
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
		
</script>


<script type="text/javascript">		
		
	function setShop() 
	{
		var terminal = document.getElementById("txtshop");
		var selectedText = terminal.options[terminal.selectedIndex].text;
		document.getElementById("selshop").value = selectedText;
	}
	
	function setLab() 
	{
		var terminal = document.getElementById("txtlab");
		var selectedText = terminal.options[terminal.selectedIndex].text;
		document.getElementById("sellab").value = selectedText;	
	}
	
	function validatesForm() {
		
		var serializedData = $('#searchrform').serialize();				
			$.post("accounts_summary.php",serializedData,function(data){
				$('#accountsummary').html(data);
			});
		
	}
	
	
</script>
