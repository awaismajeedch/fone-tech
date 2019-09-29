<?php
	
	
	if (empty($_SESSION['user_id']))
    {
         /*** redirect ***/
        header("Location: index.php");
        exit;
    }
	
	
?>   	
	

<div class="row-fluid">
	<!-- <div class="row-fluid">
		<form class="form-horizontal" id="repform"  name="repform" method="post" >	
		<div class="span12 discover">				
			<div class="span7">																		
				<div class="control-group">
					<label class="control-label" >Search: </label>
					<div class="controls">													
						<input  type="text" name="txtcst" id="txtcst"  class="input-xxlarge" tabindex="1" placeholder="Please enter Invoice or Make or Customer name or Contact">
					</div>
				</div>	
				<div class="control-group">							
					<a href="javascript:repForm();"  class="button_bar" style="float:right;">Search</a>											
				</div>	
			</div>			
		</div>	
		</form>
	</div>	 -->
	<div class="row-fluid">												
		<div id="represult">
			<?php
				include_once($pathaj."represult.php");
			?>	
		</div>												
	</div> 	
						
</div>  


<script type="text/javascript">		
		
	function repForm() {
		
		var serializedData = $('#repform').serialize();				
			$.post("represult.php",serializedData,function(data){
				$('#represult').html(data);
			});
		
	}
	
	
</script>