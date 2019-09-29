    <!-- Top Bar -->
	<div class="row-fluid ">
		<div class="span12 page_top_header base_color_background"></div>
	</div>
	
	<div class="container">

		<div class="row-fluid header_container">
			<!-- Logo -->
			<div class="">				
				<a href='#'>
					<!--<img src=images/logo.jpg alt='' title='FoneWorld'/>-->
				</a>
			</div>
			
			<!-- Menu -->
			<div class="span12 menu" style="margin-left:170px">
				<ul id="menu-pixel" class="menu" style="float:none">
					<li  <?php if ($mainCat=="Attendance") { 
										echo ' class="current-menu-item current_page_item menu-item-home"'; }?> >
						<a href="attendance.php">Attendance</a>                           
					</li>	
					<!-- <li  
					<?php //if ($mainCat=="Checkprices") { 
										//echo ' class=\"current-menu-item current_page_item menu-item-home\"'; }
										?> >
						<a href="checkprices.php">Price Check</a>                           
					</li>										 -->
					<li <?php if ($mainCat=="Repair") { 
										echo ' class="current-menu-item current_page_item menu-item-home"'; }?> >
						<a href="repairs.php">Labs</a>
					</li>
					<li <?php if ($mainCat=="Repsheet") { 
										echo ' class="current-menu-item current_page_item"'; }?> >
						<a href="repsheet.php">Repair sheet</a>
					</li>
					<li <?php if ($mainCat=="Unlock") { 
										echo ' class="current-menu-item current_page_item"'; }?>
										<?php if(!empty($_SESSION['user_name'])&& ($_SESSION['user_name'] == 'brighton57' || $_SESSION['user_name'] == 'worthing' || $_SESSION['user_name'] == 'Hove'))
										echo 'style="display:none;"';?> >
					    <!--&& ($_SESSION['user_name'] == 'brighton57' || $_SESSION['user_name'] == 'worthing'))-->
						<a href="unlockshop.php">Unlocking
							<span class="badge badge-warning"><div id="fixes">6</div></span>
						</a>
					</li>					
					<li <?php if ($mainCat=="Purchase") { 
										echo ' class="current-menu-item current_page_item"'; }?> >
						<a href="purchase.php">Purchasing</a>
					</li>
					<li <?php if ($mainCat=="Sell") { 
										echo ' class="current-menu-item current_page_item"'; }?> >
						<a href="selling.php">Selling</a>
					</li>
					<li <?php if ($mainCat=="Sold") { 
										echo ' class="current-menu-item current_page_item"'; }?> >
						<a href="sold.php">Sold</a>
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
	
	<script>
	$(document).ready(function () {
		var seconds = 10000; // time in milliseconds
		var reload = function() {
		   $.ajax({
			  url: 'unlock_status.php',
			  cache: false,
			  success: function(data) {
				  $('#fixes').html(data);
				  setTimeout(function() {
					 reload();
				  }, seconds);
			  }
		   });
		 };
		 reload();
	});
	</script>	
	<script type="text/javascript">
	 function logout() {
		
		$.post("logout_controller.php",{},function(data){           
		  window.location = "index.php";
		});
	}	
	</script>	
