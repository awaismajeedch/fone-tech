<!DOCTYPE html>

<?php
	$mainCat = "Labs";	
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
									<h4>Add Labs</h4>
								</a>
							</div>
							<div id="collapseOne" class="accordion-body collapse  in">
								<div class="accordion-inner">
									<div class="span12">		
										<form class="form-horizontal" id="labsform"  name="labsform" method="post" >											
										<div class="span5">	
											<div class="control-group">
												<label class="control-label" >*Lab Name: </label>
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
										</div>
										<div class="span5">												
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
												<label class="control-label" >Lab Type: </label>
												<div class="controls">													
													<select name="cmblabtype" id="cmblabtype">
														<option value="lab">Lab</option>
														<option value="unlock">Unlocking</option>
													</select>
												</div>
											</div>		
											<div class="control-group">							
												<a href="javascript:validatelabsForm();"  class="button_bar" style="float:right;">Save</a>											
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
									<h4>Labs List</h4>									
								</a>
							</div>
							<div id="collapseTwo" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="text-block-1">									  
										<div>	
											<div id="labslist">
											<?php
												include_once($pathaj."labs_list.php");
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
		
   function validatelabsForm () {
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
				
		var serializedData = $('#labsform').serialize();		
		
		$.post("labs_controller.php",serializedData,function(data){
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
				$("#labslist").load("labs_list.php");
				$('#collapseOne').collapse('hide');	   
				$('#collapseTwo').collapse('show');
			}
		   else				
				alert ("Data could not be saved!");			
          
		});
	}	
	
	
}	
</script>
