    <!-- Top Bar -->
	<div class="row-fluid ">
		<div class="span12 page_top_header base_color_background"></div>
	</div>
	
	<div class="container">

		<div class="row-fluid header_container">
			<!-- Logo -->
			<div class="span2">
				<a href='accounts.php'>
					<img src=images/logo.jpg alt='' title='FoneWorld'/>  
				</a>
			</div>
			
			<!-- Menu -->
			<div class="span10 menu">
				<ul id="menu-pixel" class="menu">										
					<li <?php if ($mainCat=="Shops") { 
										echo " class=\"current-menu-item current_page_item\""; }?> >
						<a href="shops.php">Shops</a>
					</li>
					<li <?php if ($mainCat=="Users") { 
										echo " class=\"current-menu-item current_page_item\""; }?> >
						<a href="users.php">Users</a>
					</li>					
					<li <?php if ($mainCat=="Labs") { 
										echo " class=\"current-menu-item current_page_item\""; }?> >
						<a href="labs.php">Labs</a>
					</li>
					<li  <?php if ($mainCat=="Prices") { 
										echo " class=\"current-menu-item current_page_item menu-item-home\""; }?> >
						<a href="prices.php">Prices</a>                           
					</li>
					<li <?php if ($mainCat=="Repairs") { 
										echo " class=\"current-menu-item current_page_item\""; }?> >
						<a href="repairsmain.php">Repairs</a>
					</li>
					<li <?php if ($mainCat=="Unlock") { 
										echo " class=\"current-menu-item current_page_item\""; }?> >
						<a href="unlockmain.php">Unlocking</a>
					</li>
					<li <?php if ($mainCat=="Stock") { 
										echo " class=\"current-menu-item current_page_item\""; }?> >
						<a href="inventory.php">Stock</a>
					</li>
					<li <?php if ($mainCat=="Attendance") { 
										echo " class=\"current-menu-item current_page_item\""; }?> >
						<a href="shops_attendance.php">Attendance</a>
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
