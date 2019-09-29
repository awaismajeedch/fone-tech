<div class="row-fluid">
	<div class="accordion" id="accordion">													
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseuOne">
					<h4>Add Unlock Description</h4>
				</a>
			</div>
			<div id="collapseuOne" class="accordion-body collapse  in">
				<div class="accordion-inner">
					<div class="span12">		
						<form class="form-horizontal" id="unlockform"  name="unlockform" method="post" >											
						<div class="span5">	
							<div class="control-group">
								<label class="control-label" >*Summary: </label>
								<div class="controls">													
									<input  type="text" name="txtsummary" id="txtsummary" class="input-large" >
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label" >Description: </label>
								<div class="controls">													
									<textarea name="txtdescription" id="txtdescription" class="input-large" style="height:70px;"></textarea>
								</div>
							</div>																							
						</div>
						<div class="span1">																							
						</div>
						<div class="span5">	
							<div class="control-group">
								<label class="control-label" >*Network: </label>
								<div class="controls">													
									<input  type="text" name="txtnetwork" id="txtnetwork" class="input-large" >
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" >Price: </label>
								<div class="controls">													
									<input  type="text" name="txtprice" id="txtprice" class="input-large" onkeyup="checkInput(this)" >
								</div>
							</div>												
							<div class="control-group">
								<label class="control-label" >Duration: </label>
								<div class="controls">													
									<input  type="text" name="txtdurations" id="txtdurations" class="input-large" onkeyup="checkInput(this)" placeholder="Enter in Hours only">
								</div>
							</div>							
							<div class="control-group">							
								<a href="javascript:validateuserForm();"  class="button_bar" style="float:right;">Save</a>											
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
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseuTwo">
					<h4>Unlock Data List</h4>									
				</a>
			</div>
			<div id="collapseuTwo" class="accordion-body collapse">
				<div class="accordion-inner">
					<div class="text-block-1">									  
						<div>	
							<div id="unlockdatalist">
							<?php
								include_once($pathaj."unlockdata_list.php");
							?>	
							</div>		
						</div>
					</div> 								
				</div>
			</div>
		</div>		
	</div>						
</div>  

<script type="text/javascript">	
	
	function checkInput(ob) {
		var invalidChars = /[^0-9]/gi
		if(invalidChars.test(ob.value)) {
            ob.value = ob.value.replace(invalidChars,"");
		}
	}	
   
   function validateuserForm () {
		var success = 1;			
    
		if ( document.getElementById("txtsummary").value == "" ) {
		
				alert("Please enter Summary!");
				success = 0;
				return;
				
		}
		
		if ( document.getElementById("txtnetwork").value == "" ) {
		
				alert("Please enter Network!");
				success = 0;
				return;
				
		}
	
	if (success == 1) {
				
		var serializedData = $('#unlockform').serialize();		
		
		$.post("unlockdata_controller.php",serializedData,function(data){
           //alert(data);
		   if (data > 0 )	{		
				alert ("Data is saved successfully!");				
				document.getElementById('unlockform').reset();
				$("#unlockdatalist").load("unlockdata_list.php");
				$('#collapseuOne').collapse('hide');	   
				$('#collapseuTwo').collapse('show');
			}
		   else				
				alert ("Data could not be saved!");			
          
		});
	}	
	
	
}	
</script>
