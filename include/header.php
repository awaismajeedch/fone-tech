    <!-- Top Bar -->
	<div class="row-fluid ">
		<div class="span12 page_top_header base_color_background"></div>
	</div>
	
	<div class="container">

		<div class="row-fluid header_container">
			<!-- Logo -->
			<div class="span3">
				<a href='index.php'>
					<!--<img src=images/logo.jpg alt='' title='FoneWorld'/>-->
				</a>
			</div>
			
			<!-- Menu -->
			<div class="span7 menu">
				<ul id="menu-pixel" class="menu">
					<li  <?php if ($mainCat=="Home") { 
										echo " class=\"current-menu-item current_page_item menu-item-home\""; }?> >
						<a href="index.php">Home</a>                           
					</li>					
					<!--
					<li <?php //if ($mainCat=="Contact") { 
								//		echo " class=\"current-menu-item current_page_item\""; }?> >
						<a href="contactus.php">Contact Us</a>
					</li>
					-->
				</ul>
			</div>
		</div>
		<div class="span12 offset9">	
			<?php
				if (!empty($_SESSION['user_name'])) {
			?>							
				<li><b>Welcome <?=ucfirst($_SESSION['user_name'])?></b> | <a href="javascript:void(0);" onclick="javascript:logout();">Logout</a></li>															
			<?php }  ?>						
		</div>
	</div>
	<!-- Line Divider -->
	<div class="row-fluid ">
		<div class="span12 page_top_header line-divider"></div>
	</div>
	<script type="text/javascript">
	 function logout() {
		
		$.post("logoutcontroller.php",{},function(data){           
		  window.location = "index.php";
		});
	}	
	</script>	
