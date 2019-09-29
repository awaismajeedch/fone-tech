<!DOCTYPE html>    

<?php
	
	$mainCat = "Home";	
	include_once 'path.php';
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
			include_once($path ."header.php"); 
			$ip = getenv('REMOTE_ADDR');
			//echo "IP Add:" . $ip;
			//echo phpversion();
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
						<!--
						<div class="span8 box_shadow box_layout">							
							<div class="row-fluid">
								<div class="span12">
									<div class="recent_title">
										<h2>What We Are</h2>
									</div>
									<span class="row-fluid separator_border"></span>
								</div>
								<div class="row-fluid">
									<p>
										We are pioneer in IT solutions and provide cutting edge techonology solution to our clients. We have our Products and we also provide customize solution according to client requirements.
									</p>
									<p>
										Cras mattis cosi sectetut amet fermens etrsaters dimets. Fugiat dapibus, tellus ac cursus commodo, mauesris con,ntum nibh, ut fermentum mas justo sitters amet risus. Cras mattis cosi sectetut amet fermens etrsaters dimets.
									</p>
									<p>
										Fugiat dapibus, tellus ac cursus commodo, mauesris con,ntum nibh, ut fermentum mas justo sitters amet risus. Cras mattis cosi sectetut amet fermens etrsaters dimets. Fugiat dapibus, tellus ac cursus commodo, mauesris con,ntum nibh, ut fermentum mas justo sitters amet risus. Cras mattis cosi sectetut amet fermens etrsaters dimets.Fugiat dapibus, tellus ac cursus commodo, mauesris con,ntum nibh, ut fermentum mas justo sitters amet risus. Cras mattis cosi sectetut amet fermens etrsaters dimets. Fugiat dapibus, tellus ac cursus commodo, mauesris con,ntum nibh, ut fermentum mas justo sitters amet risus.
									</p>
								</div>
							</div>													
						</div>
						-->
						<div class="span4 box_shadow box_layout">
						</div>
						<div class="span4 box_shadow box_layout">
							<div class="row-fluid">
								<div class="span12">
									<div class="recent_title">										 
										<h2>Login</h2>
									</div>
									<span class="row-fluid separator_border"></span>
								</div>
								<div class="row-fluid">
									<form id="loginform"  method="post" action="" onkeypress="javascript:sumbitOnEnter(event);">										
										<div class="control-group">
											<label style="font-weight:bold; font-size:14px;">*User Name</label>					
											<div class="controls">
												<input name="txtusername" id ="txtusername" type="text" class="input-large"  required />						
											</div>	
										</div>	
										<div class="control-group">
											<label style="font-weight:bold; font-size:14px;">*Password</label>
											<div class="controls">
												<input name="txtpassword" id="txtpassword" type="password" class="input-large" required />											   						
											</div>
										</div>	
										<a href="javascript:validateForm();"  class="button_bar" style="float:right; margin-right:65px;" >Login</a>									
										<input name="txtuserip" id ="txtuserip" type="hidden" value="<?php echo $ip; ?>" />
									</form>	
								</div>
							</div>
						</div>
					</div>
				</div>               
				<!-- TextBar -->
                <div class="container">
					<!--
                    <div class="row-fluid distance_1">
                        <div class="row-fluid text_bar_pattern">
                            <span class="right_arrow"></span>
                            <div class="content_bar">
                                <h1 class="banner_font">Give Us a Call for Free Demo</h1>
                                <p class="banner_font">
                                    Lorem ipsum dolor slo Vivamus, curabus iretundus als, please contact us for everything you need.
                                </p>
                            </div>                           
                            <span class="banner_shadow"></span>
                        </div>
                    </div>
					-->
                </div>
            </div>
        </div> 
		<div style="height:100px">
		</div>
		<!-- Footer Begin -->
        <?php
			include_once($path ."footer.php"); 
		?>   
	    <!-- Footer End -->
    
<script type="text/javascript">

	function validateForm () {
		var success = 1;
			
		if ( document.getElementById("txtusername").value == "" ) {
				alert("Please enter Username!");
				success = 0;
				return;
				
		}	
				
			
		if ( document.getElementById("txtpassword").value == "" ) {
				alert("Please enter Password!");
				success = 0;
				return;
				
		}	
		if (success == 1) {
						
			var serializedData = $('#loginform').serialize();
			
			$.post("login_controller.php",serializedData,function(data){
			   //alert(data);

				if (data == 0) {	
					alert ("Invalid username or password");
					return;
				} else if (data == 1) {	
					alert ("Invalid Machine IP to access this site");
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

