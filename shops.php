<!DOCTYPE html>

<?php
	$mainCat = "Shops";	
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
?>  

<?php
	include_once 'include/global.inc.php';
	
	$sql = "SELECT id,name FROM labs where lab_type='lab' order by created_at asc";
	
	$data = $db->selectQuery($sql);	
	
	$usql = "SELECT id,name FROM labs where lab_type='unlock' order by created_at asc";
	
	$udata = $db->selectQuery($usql);	
?>    
<div class="row-fluid ">
	<div class="span12">		
		<!-- LayerSlider Content End -->
		<div class="row-fluid divider slide_divider base_color_background">
			<div class="container">                       
			</div>
		</div>
		<div class="container">					
			<div class="row-fluid distance_1">								
				<div class="row-fluid">
					<div class="accordion" id="accordion">													
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									<h4>Add Shops</h4>
								</a>
							</div>
							<div id="collapseOne" class="accordion-body collapse  in">
								<div class="accordion-inner">
									<div class="span12">		
										<form class="form-horizontal" id="shopsform"  name="shopsform" method="post" >											
										<div class="span5">	
											<div class="control-group">
												<label class="control-label" >*Shop Name: </label>
												<div class="controls">													
													<input  type="text" name="txtname" id="txtname" class="input-large" >
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label" >*Contact Person: </label>
												<div class="controls">													
													<input  type="text" name="txtcname" id="txtcname" class="input-large" >
												</div>
											</div>		
											<div class="control-group">							
												<label class="control-label" >Address: </label>
												<div class="controls">
													<input  type="text" name="txtaddress" id="txtaddress" class="input-large" >
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label" >City: </label>
												<div class="controls">													
													<input  type="text" name="txtcity" id="txtcity" class="input-large" >
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" >Unlock Lab: </label>
												<div class="controls">													
													<select name="cmbulab" id="cmbulab">
														<?php foreach ($udata as $urow) {	?>
															<option value="<?php echo $urow['id'];?>"><?php echo $urow['name'];?></option>
														<?php } ?>	
													</select>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" >Status: </label>
												<div class="controls">													
													<select name="cmbstatus" id="cmbstatus">
														<option value="active">Active</option>
														<option value="inactive">Inactive</option>															
													</select>
												</div>
											</div>
										</div>
										<div class="span5 offset1">												
											<div class="control-group">							
												<label class="control-label" >Display Name: </label>
												<div class="controls">												
													<input  type="text"  name="txtdispname" id="txtdispname" class="input-large"/>																								
												</div>
											</div>	
											<div class="control-group">							
												<label class="control-label" >Contact #: </label>
												<div class="controls">												
													<input  type="text"  name="txtcontact" id="txtcontact" class="input-large"/>																								
												</div>
											</div>	
											<div class="control-group">							
												<label class="control-label" >Cell #: </label>
												<div class="controls">												
													<input  type="text"  name="txtcell" id="txtcell" class="input-large"/>																								
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label" >*Email: </label>
												<div class="controls">													
													<input  type="text" name="txtemail" id="txtemail" class="input-large" >
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label" >Repair Lab: </label>
												<div class="controls">													
													<select name="cmblab" id="cmblab">
														<?php foreach ($data as $row) {	?>
															<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
														<?php } ?>	
													</select>
												</div>
											</div>		
											<div class="control-group">							
												<a href="javascript:validateshopsForm();"  class="button_bar" style="float:right;">Save</a>											
											</div>	
											<input type="hidden"  name="txtid" id="txtid" value="" >
										</div>		
										</form>
									</div>	
									
								</div>
							</div>
						</div>
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									<h4>Shop List</h4>									
								</a>
							</div>
							<div id="collapseTwo" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="text-block-1">									  
										<div>	
											<div id="shopslist">
											<?php
												include_once($pathaj."shops_list.php");
											?>	
											</div>		
										</div>
									</div> 								
								</div>
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
<script type="text/javascript">	
		
   function validateshopsForm () {
		var success = 1;			
    
	if (document.getElementById("txtname").value == "" ) {
            alert("Please enter Name!");
			success = 0;
            return;
			
    }		
	
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var address = document.getElementById('txtemail').value;
	if(reg.test(address) == false) {
	  alert("Please enter valid Email!");		  
	  success = 0;
	  return;
	}
	
	/*	
	if (success == 1) {
		var docForm = document.getElementById('clientsform');  
		var serializedData = new FormData(docForm);  		
		
		$.ajax({
            type:'POST',
            url: "clients_controller.php",
            data:serializedData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
               if (data > 0 )	{		
				alert ("Data is saved successfully!");				
				document.getElementById('txtname').value = '';				
				document.getElementById('txtaddress').value = '';
				document.getElementById('txtcity').value = '';												
				document.getElementById('txtstate').value = '';
				document.getElementById('txtzip').value = '';				
				document.getElementById('txtcontact').value = '';
				document.getElementById('txtemail').value = '';				
				$("#clientslist").load("clients_list.php");
			}
		   else				
				alert ("Data could not be saved!");	
            }
        });
		
	}
	*/
	if (success == 1) {
				
		var serializedData = $('#shopsform').serialize();		
		
		$.post("shops_controller.php",serializedData,function(data){
           //alert(data);
		   if (data > 0 )	{		
				alert ("Data is saved successfully!");				
				document.getElementById('txtname').value = '';	
				document.getElementById('txtcname').value = '';					
				document.getElementById('txtaddress').value = '';
				document.getElementById('txtcity').value = '';																							
				document.getElementById('txtcontact').value = '';				
				document.getElementById('txtcell').value = '';				
				document.getElementById('txtemail').value = '';							
				document.getElementById('txtid').value = '';
				$("#shopslist").load("shops_list.php");
				$('#collapseOne').collapse('hide');	   
				$('#collapseTwo').collapse('show');
			}
		   else				
				alert ("Data could not be saved!");			
          
		});
	}	
	
	
}	
</script>
