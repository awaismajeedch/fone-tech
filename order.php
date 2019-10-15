<!DOCTYPE html>

<?php
	$mainCat = "Accessories";
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
		include_once 'include/global.inc.php';
	?>
	<style type="text/css">
	.typeahead {
		z-index: 1000;
	}
	</style>
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
    $tableName='accessories';
    $where='status=1';
    $manufacturerList=$db->select($tableName,"",$where);
?>
<div class="row-fluid ">
	<div class="span12">
		<div class="container">
			<div class="row-fluid distance_1">
				<div class="row-fluid">
					<div class="accordion" id="accordion">
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									<h4>Previous Order</h4>
								</a>
							</div>
							<div id="collapseOne" class="accordion-body collapse in">
								<div class="accordion-inner">
									<div class="span12">
										
									</div>
								</div>
							</div>
						</div>
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									<h4>Current Order</h4>
								</a>
							</div>
							<div id="collapseTwo" class="accordion-body collapse">
								<div class="accordion-inner">
                                   <div class="span12">
										<form id="currentOrder_form" method="post" class="form-horizontal" role="form">
                                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>"/>
                                            <div class="control-group">
                                        <!-- <label  class="col-sm-2 control-label" for="inputEmail3">Model</label> -->
                                                <div class="col-sm-10">
                                                    <select id="ManufacturerList" name="Manufacturer_list" style="width:20%;margin-left:3px">
                                                    <option value=''>-----SELECT-----</option>
                                                    <?php
                                                    foreach ($manufacturerList as $manufacturer) {
                                                        echo "<option value='$manufacturer[id]'>$manufacturer[make]</option>";
                                                    }
                                                    ?>
                                                    </select>
                                                    <select id="ModelList" name="Model_list" style="width:20%;margin-left:3px">
                                                    
                                                    </select>
                                                    <select id="TypeList" name="Type_list" style="width:20%;margin-left:3px">
                                                
                                                    </select>
													<select id="ColorList" name="Color_list" style="width:20%;margin-left:3px">
                                                
                                                    </select>
                                                    <input type="text" style="width:10%;margin-left:3px" class="form-control" id="o_quantity" name="quantity" placeholder="Quantity"/>
                                                </div>
                                                <p class="error" id = "quantity_error" style="color:red;display:none;margin:5px">*INVALID ENTRY</p>
                                            </div>
                                            <div class="control-group">
                                                <div class="col-sm-offset-2 col-sm-10" style="margin-top:5px">
                                                    <a href="javascript:validateCurrentOrederForm();"  class="button_bar" style="margin-left:75%">Save</a>
                                                <!-- //<button type="submit" class="button-bar">Create</button> -->
                                                    <a href=""  class="button_bar" style="margin-left:15px">Submit</a>
                                                <!-- //<button type="submit" class="button-bar">Create</button> -->
                                                </div>
                                            </div>
                                        </form>
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
			//include_once($pathModal."modal_manufacturer.php");
			//include_once($pathModal."modal_model.php");
			//include_once($pathModal."modal_type.php");
//include_once($pathModal."modal_color.php");

			// include_once($path."footer.php");
		?>
</footer>
</body>
</html>
<script>
	 $(document).ready(function() {
    $("#ManufacturerList").change(function() {
        document.getElementById("TypeList").innerHTML="";
		document.getElementById("ColorList").innerHTML="";
        var serializedData = $('#currentOrder_form').serialize();
        $.post("orderHelper.php?check=manufacturer",serializedData,function(data){
        $modelList=document.getElementById("ModelList");
        $modelList.innerHTML="";
        $modelList.innerHTML=data;
      });
    });
  });

  $(document).ready(function() {
    $("#ModelList").change(function() {
		document.getElementById("ColorList").innerHTML="";
        var serializedData = $('#currentOrder_form').serialize();
        $.post("orderHelper.php?check=model",serializedData,function(data){
        $typeList=document.getElementById("TypeList");
        $typeList.innerHTML="";
        $typeList.innerHTML=data;
      });
    });
  });
  $(document).ready(function() {
    $("#TypeList").change(function() {
        var serializedData = $('#currentOrder_form').serialize();
        $.post("orderHelper.php?check=type",serializedData,function(data){
        $colorList=document.getElementById("ColorList");
        $colorList.innerHTML="";
        $colorList.innerHTML=data;
      });
    });
  });

  function validateCurrentOrderForm () {
    var success=1;
    if ( $("#o_quantity").val() == "" ) {
        alert("Please enter color!");
        success = 0;
        return;
    }
    if(success == 1){
      var serializedData = $('#currentOrder_form').serialize();
      $.post("currentOrder_controller.php",serializedData,function(data){
        //console.log(data);
        if(data == 1){
         // $('#colorModal').modal('hide');
          alert("Data Saved");
          //console.log(data);
        }
        else if(data == 2){
          //console.log(data);
          //$('#quantity_error').show();
          //$('#a_color').attr('style','border-color:red');
        }
      });
      return;
    }
  }

</script>