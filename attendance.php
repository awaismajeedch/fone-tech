<!DOCTYPE html>    

<?php
	error_reporting(0);
	Session_Start();
	$mainCat = "Attendance";	
	include_once 'path.php';	
	$shopid = $_SESSION['shop_id'];	
?>
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
    <body>
        <!-- Include Header  -->
		<?php
			include_once($path ."adminheader.php"); 			
		?>   
        <div class="row-fluid ">
            <div class="span12">                
                <!-- LayerSlider Content End -->
                <div class="row-fluid divider slide_divider base_color_background">
                    <div class="container">                       
                    </div>
                </div>
                 <!-- Services with icon section begin -->				 
                <div class="container">				 
					<div class="row-fluid distance_1">
						
						<div class="span4 box_shadow box_layout">
						</div>
						<div class="span4 box_shadow box_layout">
							<div class="row-fluid">
								<div class="span12">
									<div class="recent_title">										 
										<h2>Mark Attendance</h2>
									</div>
									<span class="row-fluid separator_border"></span>
								</div>
								<div class="row-fluid">
									<form id="attendance"  method="post" action="" onkeypress="javascript:sumbitOnEnter(event);">										
										<div class="control-group">
											<label style="font-weight:bold; font-size:14px;">*Employee Name</label>					
											<div class="controls">
												<input name="txtempname" id ="txtempname" type="text" autocomplete="off" data-provide="typeahead" class="input-large"  required />						
											</div>	
										</div>	
										<div class="control-group">
											<label style="font-weight:bold; font-size:14px;">*Password</label>
											<div class="controls">
												<input name="txtemppass" id="txtemppass" type="password" class="input-large" required />											   						
											</div>
										</div>	
										<input type="hidden" name="txtshpid" id ="txtshpid" value="<?php echo $shopid;?>" />						
										<a href="javascript:validateForm();"  class="button_bar" style="float:right; margin-right:65px;" >CheckIn</a>																			
									</form>	
								</div>
							</div>
						</div>
					</div>
				</div>               				
            </div>
        </div> 
		<div style="height:120px">
		</div>
		<!-- Footer Begin -->
        <?php
			include_once($path ."footer.php"); 
		?>   
	    <!-- Footer End -->
    
<script type="text/javascript">
	
	$("#txtempname").typeahead({		
			source: function (make, process) {            
				var query = '<?php echo $shopid;?>';
				//alert(query);
				return $.getJSON('userslist.php', { query: query, make: make }, function (data) {
					//alert (data);
					return process(data);
				});
			},

			minLength : 2,
			//items : 4,
			property: 'name'
		});
	
	
	function validateForm () {
		var success = 1;
			
		if ( document.getElementById("txtempname").value == "" ) {
				alert("Please enter Username!");
				success = 0;
				return;
				
		}	
				
			
		if ( document.getElementById("txtemppass").value == "" ) {
				alert("Please enter Password!");
				success = 0;
				return;
				
		}	
		if (success == 1) {
						
			var serializedData = $('#attendance').serialize();
			
			$.post("attendance_controller.php",serializedData,function(data){
			   //alert(data);
				if (data == 0) {	
					alert ("Invalid username or password");
					return;				
				} else 	{
					window.location = data;
				}
			  
			});
		}	
		
	}	

    function sumbitOnEnter (e) {

        if ( e.keyCode == 13 ) {
            validateForm();
            return;
        }

    }

</script>

