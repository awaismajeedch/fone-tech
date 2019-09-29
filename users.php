<!DOCTYPE html>

<?php
	$mainCat = "Users";	
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
	
	$sql = "SELECT id,name FROM shops order by created_at desc";
	
	$data = $db->selectQuery($sql);	
	//$ip =$_SERVER['REMOTE_ADDR']; 
	//$ip = getenv('HTTP_CLIENT_IP');
	//$ip = getenv('REMOTE_ADDR');
	//echo "IP Add:" . $ip;
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
									<h4>Add Users</h4>
								</a>
							</div>
							<div id="collapseOne" class="accordion-body collapse  in">
								<div class="accordion-inner">
									<div class="span12">		
										<form class="form-horizontal" id="userform"  name="userform" method="post" >											
										<div class="span5">	
											<div class="control-group">
												<label class="control-label" >*Shop Name: </label>
												<div class="controls">													
													<select name="cmbshop" id="cmbshop">
														<?php foreach ($data as $row) {	?>
															<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
														<?php } ?>	
													</select>
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label" >Last Name: </label>
												<div class="controls">													
													<input  type="text" name="txtlname" id="txtlname" class="input-large" >
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" >First Name: </label>
												<div class="controls">													
													<input  type="text" name="txtfname" id="txtfname" class="input-large" >
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label" >*User Name: </label>
												<div class="controls">													
													<input  type="text" name="txtuname" id="txtuname" class="input-large" >
												</div>
											</div>						
											<div class="control-group">							
												<label class="control-label">Password: </label>
												<div class="controls">	
													<input class="input-large" id="txtpword" name="txtpword" type="password" value="" />									
												</div>
											</div>	
											<div class="control-group">							
												<label class="control-label">Confirm Password: </label>
												<div class="controls">	
													<input class="input-large" id="txtcpword" name="txtcpword" type="password" value="" />									
												</div>
											</div>																							
											<!--
											<div class="control-group">
												<label class="control-label" >Employee Photo: </label>
												<div class="controls">
													<input type="file"  name="txtfile" id="txtfile" class="input-large" />	
													<input type="hidden" name="userdbimage" id="userdbimage" value="" >													
												</div>
											</div>		
											-->
										</div>
										<div class="span5 offset1">	
											<div class="control-group">
												<label class="control-label" >User Type: </label>
												<div class="controls">													
													<select name="cmbusertype" id="cmbusertype" >
														<option value="admin">Admin</option>
														<option value="employee" selected>Employee</option>
														<option value="attendent" >Attendent</option>
													</select>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" >IP Address: </label>
												<div class="controls">													
													<input  type="text" name="txtipadd" id="txtipadd" class="input-large" readonly>
												</div>
											</div>												
											<div class="control-group">
												<label class="control-label" >User Role: </label>
												<div class="controls">													
													<input  type="text" name="txtrole" id="txtrole" class="input-large" >
												</div>
											</div>		
											<div class="control-group">
												<label class="control-label" >Joining Date: </label>
												<div class="controls">
													<div class="input-append date" name="sdate" id="sdate" data-date="" data-date-format="yyyy-mm-dd" >
													<input type="text" name="txtsdate" id="txtsdate" class="input-medium" value="" >
													<span class="add-on"><i class="icon-calendar"></i></span>											
													</div>														
												</div>
											</div>											
											<div class="control-group">
												<label class="control-label" >Leaving Date: </label>
												<div class="controls">
													<div class="input-append date" name="edate" id="edate" data-date="" data-date-format="yyyy-mm-dd" >
													<input  type="text" name="txtedate" class="input-medium" id="txtedate" value="" >
													<span class="add-on"><i class="icon-calendar"></i></span>											
													</div>														
												</div>
											</div>					
											<div class="control-group">							
												<a href="javascript:validateuserForm();"  class="button_bar" style="float:right;">Save</a>											
											</div>	
											<input type="hidden"  name="txtuid" id="txtuid" value="" >
										</div>		
										</form>
									</div>	
									
								</div>
							</div>
						</div>
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									<h4>User List</h4>									
								</a>
							</div>
							<div id="collapseTwo" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="text-block-1">									  
										<div>	
											<div id="userslist">
											<?php
												include_once($pathaj."users_list.php");
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
	$(document).ready(function(){
						
		$('#sdate').datepicker();				
		$('#edate').datepicker();				
	  });
	
	$("#cmbusertype").change(function() {
	  if (($(this).val() == "employee")) {
		$("#txtipadd").attr("readonly", "readonly");
	  }
	  else {    
		$("#txtipadd").removeAttr("readonly");
	  }
	});

	
	function validateuserForm () {
		var success = 1;			
    
		if ( document.getElementById("txtuname").value == "" ) {
		
				alert("Please enter User Name!");
				success = 0;
				return;
				
		}
		
		if ( document.getElementById("txtuid").value == "" ) {	
			if ( document.getElementById("txtpword").value == "" ) {
				alert("Please enter Password!");
				success = 0;
				return;
				
			}
		}
			
		if ( document.getElementById('txtpword').value != "" ) {

				if ( document.getElementById('txtcpword').value == "") {
					alert("Please enter Confirm Password!");
					document.getElementById('txtcpword').focus();
					success = 0;
					return;
				}

				if ( document.getElementById('txtcpword').value != document.getElementById('txtpword').value) {
					alert("Incorrect confirm password!");
					document.getElementById('txtcpword').focus();
					success = 0;
					return;
				}
		}    		
	
	if (success == 1) {
				
		var serializedData = $('#userform').serialize();		
		
		$.post("users_controller.php",serializedData,function(data){
           //alert(data);
			if (data == 1 )	{		
				alert ("Data is saved successfully!");				
				document.getElementById('txtuname').value = '';	
				document.getElementById('txtlname').value = '';	
				document.getElementById('txtfname').value = '';	
				document.getElementById('txtpword').value = '';					
				document.getElementById('txtcpword').value = '';				
				document.getElementById('txtipadd').value = '';
				document.getElementById('txtuid').value = '';
				document.getElementById('txtrole').value = '';
				document.getElementById('txtsdate').value = '';
				document.getElementById('txtedate').value = '';
				
				$("#userslist").load("users_list.php");
				$('#collapseOne').collapse('hide');	   
				$('#collapseTwo').collapse('show');
			}
			else if (data == 2 )	{					
				alert ("User Name already exists!");			
			}	
			else if (data == 0 )	{					
				alert ("Record could not be saved!");			
			}	
          
		});
	}	
	
	
}	
</script>
