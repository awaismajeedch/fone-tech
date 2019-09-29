<?php
		include_once 'path.php';
		include_once($path ."company_logo.php"); 
		
	?>  
    <!-- Top Bar -->
	<div class="row-fluid ">
		<div class="span12 page_top_header base_color_background"></div>
	</div>
	
	<div class="container">

		<div class="row-fluid header_container">
			<!-- Logo -->
			<div class="span3">
				<a href='#'>
					<!--<img src=images/logo.png alt='' title='SecureView'/>--> 
					<img src="documents/<?php echo $logo;?>"  style="width:380px; height:88px;" alt='' title='SecureView'/>
				</a>
			</div>
			
			<!-- Menu -->
			<div class="span7 menu">
				<ul id="menu-pixel" class="menu">														
					<li <?php if ($mainCat=="Profile") { 
										echo " class=\"current-menu-item current_page_item\""; }?> >
						<a href="clientprofile.php">My Profile</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="span12 offset9">	
			<?php
				if (!empty($_SESSION['user_name'])) {
			?>							
				<b>Welcome <?=ucfirst($_SESSION['user_name'])?></b> | <a href="javascript:void(0);" onclick="javascript:logout();">Logout</a>															
			<?php }  ?>						
		</div>
	</div>
	<!-- Line Divider -->
	<div class="row-fluid ">
		<div class="span12 page_top_header line-divider"></div>
	</div>
	<script type="text/javascript">
	 function logout() {
		
		$.post("logout_controller.php",{},function(data){           
		  window.location = "index.php";
		});
	}	
	</script>	
