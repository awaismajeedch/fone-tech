<!DOCTYPE html>

<?php
	$mainCat = "Repair";	
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

<style type="text/css">
.txt_div{
	float:left;
	width:auto;
	margin-bottom:5px;
}
.left{
	float:left;
	width:auto;
}
.right{
	float:right;
	width:80px;
	margin-left:20px;
	padding-top: 8px;
}

</style>		
</head> 

<body >
<!-- Include Header  -->
<?php
	include_once($path ."adminheader.php"); 
	if (empty($_SESSION['user_id']))
    {
         /*** redirect ***/
        header("Location: index.php");
        exit;
    }
	
	include_once 'include/global.inc.php';
	$shopid = $_SESSION['shop_id'];
	$tablename="shops";
	$orderby = " ORDER BY created_at ASC";
	$where= " id=$shopid";
	$datar = $db->select($tablename,$orderby, $where);
	
	foreach ($datar as $row) {
		$shopname = $row['name'];
		$lbid = $row['labid'];
	}

	if (!empty($lbid)) {
		$tablename="labs";
		$orderby = " ORDER BY created_at ASC";
		$where= " id=$lbid";
		$datal = $db->select($tablename,$orderby, $where);
		
		foreach ($datal as $rowl) {
			$labname = $rowl['name'];			
		}
	
	}
	
	
	$table="repairs";
	$wherein = " shop_id=$shopid AND status='Inprogress'";
	$inTot = $db->totalRecords($table, $wherein);	
	$wherepe = " shop_id=$shopid AND status='Pending'";
	$peTot = $db->totalRecords($table, $wherepe);
	//echo "pe" . $peTot;
	$wherecom = " shop_id=$shopid AND status='Fixed'";
	$coTot = $db->totalRecords($table, $wherecom);
	//echo "Fi" . $coTot;
	$wherenf = " shop_id=$shopid AND status='NotFixed'";
	$nfTot = $db->totalRecords($table, $wherenf);

	$dt = new DateTime("now", new DateTimeZone('Europe/London'));
	//print_r ($dt);
	$edate = $dt->format('d/m/Y H:i');	
	
	
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
									<h4>Add Phone Specifications</h4>
								</a>
							</div>
							<div id="collapseOne" class="accordion-body collapse  in">
								<div class="accordion-inner">
									<div class="span12">		
										<form class="form-horizontal" id="repairsform"  name="repairsform" method="post" >											
										<div class="span5">	
											<div class="control-group">
												<label class="control-label" >Shop Name: </label>
												<div class="controls">													
													<input  type="text" name="txtshopname" id="txtshopname" class="input-large" value="<?php echo $shopname; ?>" disabled />
												</div>
											</div>
											<div class="control-group">							
												<label class="control-label" >Date: </label>
												<div class="controls">												
													<input  type="text"  name="txtdate" id="txtdate" class="input-large" value="<?php echo $edate;?>" disabled />																								
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label" >Invoice: </label>
												<div class="controls">													
													<input  type="text" name="txtinvoice" id="txtinvoice" class="input-large" onkeyup="checkInput(this)" placeholder="Please use Numerics only">
												</div>
											</div>		
											<div class="control-group">							
												<label class="control-label" >*Model: </label>
												<div class="controls">
													<input  type="text" name="txtmodel" id="txtmodel" class="input-large" >
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label" >*IMEI#: </label>
												<div class="controls">													
													<input  type="text" name="txtimei" id="txtimei" class="input-large" onkeyup="checkInput(this)" placeholder="Please use Numerics only">
												</div>
											</div>	
																						
										</div>
										<div class="span5">												
											<div class="control-group">
												<label class="control-label" >Lab Name: </label>
												<div class="controls">													
													<input  type="text" name="txtlabname" id="txtlabname" class="input-large" value="<?php echo $labname; ?>" disabled />
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label" >Status: </label>
												<div class="controls">													
													<input  type="text" name="txtstatus" id="txtstatus" class="input-large" value="Inprogress" disabled >
												</div>
											</div>												
											<div class="control-group">
												<label class="control-label" >*Refix: </label>
												<div class="controls" style="margin-top:3px; font-size:20px;">													
													<input type="radio" value="yes" id="radmake" name="radmake" onclick ="javascript:setrad('yes');"> Yes
													<!--<input  type="text" name="txtmake" id="txtmake" class="input-large" >-->
													&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="no" id="radmake" name="radmake" onclick ="javascript:setrad('no');"> No
													<input type="hidden" id="txtmake" name="txtmake" value="">
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label" >*Password: </label>
												<div class="controls">													
													<input  type="text" name="txtpass" id="txtpass" class="input-large" >
												</div>
											</div>														
											<div class="control-group">							
												<label class="control-label" >Notes: </label>
												<div class="controls">
													<textarea  name="txtnotes" id="txtnotes" class="input-large" style="height:37px;" placeholder="Please dont use slashes or quotes while entring notes"></textarea>
												</div>
											</div>												
										</div>											
										<div>
											<div id="text_boxes" class="controls">												
												<div id="txt_1" class="txt_div">
													<div class="left">
														<input  class="input-large" name="txtfault[]" id="txtfault_1" type="text" placeholder="Fault" />																												
														<input  class="input-large" name="txtprice[]" id="txtprice_1" type="text" onkeyup="checkInput(this)" placeholder="Price" />																										
													</div>													
													<div class="right">
														<img src="images/add.png"  class="add" />													
													</div>
													<input type="hidden"  name="txtcount" id="txtcount" value="1" >													
												</div>	
											</div>	
										</div>											
										<input type="hidden"  name="txtid" id="txtid" value="" >
										<input type="hidden"  name="txtshop" id="txtshop" value="<?php echo $shopid; ?>" >
										<input type="hidden"  name="txtlab" id="txtlab" value="<?php echo $lbid; ?>" >
										<input type="hidden"  name="txtcreatedby" id="txtcreatedby" value="<?php echo $_SESSION['user_name']; ?>" >
										<div class="control-group">							
											<a href="javascript:validateshopsForm();"  class="button_bar" style="margin-top:15px;">Save</a>											
										</div>	
										</form>
									</div>
									
								</div>
							</div>
						</div>
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									<h4>Inprogress List<span> ( Total Count = <?php echo $inTot; ?> )</span></h4> 									
								</a>
							</div>
							<div id="collapseTwo" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="text-block-1">									  
										<div>	
											<div id="repairslist">
											<?php
												include_once($pathaj."repairs_list.php");
											?>	
											</div>		
										</div>
									</div> 								
								</div>
							</div>
						</div>	
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
									<h4>Pending List <span> ( Total Count = <?php echo $peTot; ?> )</span> </h4>									
								</a>
							</div>
							<div id="collapseThree" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="text-block-1">									  
										<div>	
											<div id="pendinglist">
											<?php
												include_once($pathaj."pending_list.php");
											?>	
											</div>		
										</div>
									</div> 								
								</div>
							</div>
						</div>		
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
									<h4>Fixed List <span> ( Total Count = <?php echo $coTot; ?> )</span></h4>									
								</a>
							</div>
							<div id="collapseFour" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="text-block-1">									  
										<div>	
											<div id="completedlist">
											<?php
												include_once($pathaj."completed_list.php");
											?>	
											</div>		
										</div>
									</div> 								
								</div>
							</div>
						</div>	
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
									<h4>Not Fixed List <span> ( Total Count = <?php echo $nfTot; ?> )</span></h4>									
								</a>
							</div>
							<div id="collapseFive" class="accordion-body collapse">
								<div class="accordion-inner">
									<div class="text-block-1">									  
										<div>	
											<div id="notfixedlist">
											<?php
												include_once($pathaj."notfixed_list.php");
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
	var id = 2,max = 8,append_data;
	var id = document.getElementById('txtcount').value;
	id++;
	/*If the add icon was clicked*/
	$(".add").live('click',function(){
		//alert(id);
		//if($("div[id^='txt_']").length <8){ //Don't add new textbox if max limit exceed
		$(this).remove(); //remove the add icon from current text box
		//var append_data = '<div id="txt_'+id+'" class="txt_div" style="display:none;"><div class="left"><input type="text" id="input_'+id+'" name="txtval[]"/></div><div class="right"><img src="add.png" class="add"/> <img src="remove.png" class="remove"/></div></div>';
		var append_data = '<div id="txt_'+id+'" class="txt_div"><div class="left"><input  class="input-large" name="txtfault[]" id="txtfault_'+id+'" type="text" placeholder="Fault" />&nbsp;<input  class="input-large" name="txtprice[]" id="txtprice_'+id+'" type="text" onkeyup="checkInput(this)" placeholder="Price" /></div><div class="right"><img src="images/add.png" class="add" /><img src="images/remove.png" class="remove"/></div></div>';
		//alert (append_data);
		$("#text_boxes").append(append_data); //append new text box in main div
		//$("#txt_"+id).effect("bounce", { times:3 }, 300); //display block appended text box with silde down
		id++;
		document.getElementById('txtcount').value = id;
		//} else {
		//	alert("Maximum 8 textboxes are allowed");
		//}
	})
	
	/*If remove icon was clicked*/
	$(".remove").live('click',function(){
		
		var prev_obj = $(this).parents().eq(1).prev().attr('id');  //previous div id of this text box
		//alert (prev_obj);
		$(this).parents().eq(1).slideUp('medium',function() { $(this).remove(); //remove this text box with slide up
		if($("div[id^='txt_']").length > 1){
			append_data = '<img src="images/remove.png" class="remove"/>'; //Add remove icon if number of text boxes are greater than 1
		}else{
			append_data = '';
		}
		if($(".add").length < 1){			
			$("#"+prev_obj+" .right").html('<img src="images/add.png" class="add" /> '+append_data);
		}
		});
		
	})	
});
</script>


<script type="text/javascript">	
	
	function checkInput(ob) {
		var invalidChars = /[^0-9]/gi
		if(invalidChars.test(ob.value)) {
            ob.value = ob.value.replace(invalidChars,"");
		}
	}
	
	function setrad(val) {
		document.getElementById("txtmake").value = val
		
	}		
	
   function validateshopsForm () {
		var success = 1;			
  	
		//alert (document.getElementById("txtmake").value);
	
	if (document.getElementById("txtmake").value == "" ) {
            alert("Please select Refix!");
			success = 0;
            return;
			
    }
	
	
	if (document.getElementById("txtmodel").value == "" ) {
            alert("Please enter Model!");
			success = 0;
            return;
			
    }		
	

	if (document.getElementById("txtimei").value == "" ) {
            alert("Please enter IMEI#!");
			success = 0;
            return;
			
    }	
	if (document.getElementById("txtpass").value == "" ) {
            alert("Please enter Password!");
			success = 0;
            return;
			
    }	
	
	/*
	$('input[name="txtfault[]"]').each(function() {
		if ($(this).val() == "" )
			alert("Please enter Fault!");
			success = 0;
            return;
	}); 
	*/
	$('input[name="txtprice[]"]').each(function() {
		if ($(this).val() == "" ) {
			alert("Please enter Price!");
			success = 0;
            return;
		}	
	}); 
		
	if (document.getElementById("txtnotes").value != "" )	{
		var mystring = document.getElementById("txtnotes").value;
		//var parsed = mystring.replace(/\'/g,"");
		var parsed = mystring.replace(/["'&$@#%^!()*\\]/g, "");		
		//document.getElementById("txtnotes").value = parsed;
		var xparsed = parsed.replace(/\//g,'-');				
		document.getElementById("txtnotes").value = xparsed;
	}	
	/*
	if ((document.getElementById("txtimei").value != "" ) && (isNaN(document.getElementById('txtimei').value))) {
		alert("Please enter numeric only in IMEI#!");
		success = 0;
        return;
	
	}
	*/
	
	if (success == 1) {
				
		var serializedData = $('#repairsform').serialize();		
		
		$.post("repairs_controller.php",serializedData,function(data){
           //alert(data);
		   if (data > 0 )	{		
				alert ("Data is saved successfully!");
				document.getElementById('repairsform').reset();
				location.reload(); 
			}
		   else				
				alert ("Data could not be saved!");			
          
		});
	}	
	
	
}	
</script>
