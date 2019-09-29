<!DOCTYPE html>

<?php
	$mainCat = "Attendance";	
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
	
	$tablenamel="users";
	$orderbyl = " ORDER BY user_name ASC";
	$wherel= " 1=1";	
	$datal = $db->select($tablenamel,$orderbyl, $wherel);
	
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
								<label class="control-label" >Users: </label>
								<div class="controls">
									<select name="txtuser" id="txtuser" class="input-large" onchange="javascript:setUser();">	
										<option value="">--Select--</option>
										<?php 
											foreach ($datal as $lrow) { ?>
										 	
											<option value="<?php echo $lrow['user_name'];?>"><?php echo $lrow['user_name'];?></option>
										
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
									<input  size="10" type="text" name="txtsdate" id="txtsdate" value="<?php echo date('d/m/Y', strtotime('-15 days'));?>" >
									<span class="add-on"><i class="icon-calendar"></i></span>											
									</div>														
								</div>
							</div>																							
							<div class="control-group">
								<label class="control-label" >End Date: </label>
								<div class="controls">
									<div class="input-append date" name="edate" id="edate" data-date="" data-date-format="dd/mm/yyyy" >
									<input  size="10" type="text" name="txtedate" id="txtedate" value="<?php echo date('d/m/Y');?>" >
									<span class="add-on"><i class="icon-calendar"></i></span>											
									</div>														
								</div>
							</div>						
							
							<div class="control-group">							
								<a href="javascript:validatesForm();"  class="button_bar" style="float:right;">Search</a>											
							</div>	
						</div>		
						<input type="hidden" name="selshop" id="selshop">
						<input type="hidden" name="seluser" id="seluser">
					</div>	
					</form>
				</div>		
				<div class="row-fluid">	
					<div class="text-block-1">									  
						<div>
							
							<div id="superattendance">
							<?php
								include_once($pathaj."super_attendancedet.php");
							?>	
							</div>		
						</div>
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
		
</script>


<script type="text/javascript">		
		
	
		
	$("#txtshop").change(function(){
	//$q = terminal = document.getElementById("txtshop").value;
	//alert('test');
	return $.getJSON('userslist.php',{query: $(this).val(), ajax: 'true'}, function (j) {
	  var options = '';
	  //alert (j);
	  options = '<option value="">--Select--</option>';
	  for (var i = 0; i < j.length; i++) {
		options += '<option value="' + j[i] + '">' + j[i] + '</option>';
		}	  
	  
	  $("#txtuser").html(options);
	  //$(options).appendTo('#txtuser');
	  
	})
  })
	
	
	function setShop() 
	{
		var terminal = document.getElementById("txtshop");
		var selectedText = terminal.options[terminal.selectedIndex].text;
		document.getElementById("selshop").value = selectedText;
		
		
		
	}
	
	function setUser() 
	{
		var terminal = document.getElementById("txtuser");
		var selectedText = terminal.options[terminal.selectedIndex].text;
		document.getElementById("seluser").value = selectedText;	
	}
	
	function validatesForm() {
		
		var serializedData = $('#searchrform').serialize();				
			$.post("super_attendancedet.php",serializedData,function(data){
				$('#superattendance').html(data);
			});
		
	}
	
	
</script>
