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
?>
<div class="row-fluid ">
	<div class="span12">
		<!-- LayerSlider Content End -->
		<!-- <div class="row-fluid divider slide_divider base_color_background">
			<div class="container">
			</div>
		</div> -->
		<div class="container">
			<div class="row-fluid distance_1">
				<div class="row-fluid">
					<div class="accordion" id="accordion">
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									<h4>Add Accessories Data</h4>
								</a>
							</div>
							<div id="collapseOne" class="accordion-body collapse in">
								<div class="accordion-inner">
									<div class="span12">
										<div>
											<button type="button" data-toggle="modal" data-target="#manufacturerModal" name="button" class="button_bar" style="margin-left:15%;margin-bottom:1%">Make Manufacturer</button>
										<!-- <a href="javascript:validateForm();"  class="button_bar" style="margin-left:15%;margin-bottom:1%">Make Manufacturer</a> -->
										</div>
										<div>
											<button type="button" data-toggle="modal" data-target="#modelModal" name="button" class="button_bar" style="margin-left:5%;margin-bottom:1%">Make Model</button>
										<!-- <a href="javascript:validateForm();"  class="button_bar" style="margin-left:5%;margin-bottom:1%">Make Model</a> -->
										</div>
										<div>
											<button type="button" data-toggle="modal" data-target="#typeModal" name="button" class="button_bar" style="margin-left:5%;margin-bottom:1%">Make Type</button>
											<!-- <a href="javascript:validateForm();"  class="button_bar" style="margin-left:5%;margin-bottom:1%">Make Type</a> -->
										</div>
										<div>
											<button type="button" data-toggle="modal" data-target="#colorModal" name="button" class="button_bar" style="margin-left:5%;margin-bottom:1%">Make Color</button>
											<!-- <a href="javascript:validateForm();"  class="button_bar" style="margin-left:5%;margin-bottom:1%">Make Type</a> -->
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									<h4>Accessories List</h4>
								</a>
							</div>
							<div id="collapseTwo" class="accordion-body collapse">
								<div class="accordion-inner">
                                    <!-- <form class="form-inline" id="searchform"  name="searchform" method="post">
                                        <div class="span12 discover">
                                            <div class="span4" >
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <input  type="text" name="model" id="model" class="input-medium" placeholder="Model Name" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <input  type="text" name="part" id="part" class="input-medium" placeholder="Part Name" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="span2">
                                                <div class="control-group">
                                                    <a href="javascript:validateSearch();"  class="button_bar" style="float:left; padding:6px 20px; margin-top:0px; margin-left:0px; ">Search</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form> -->
								</div>
                                <div id="priceslist">
                                    <?php
                                        //include_once($pathaj."prices_list.php");
										$tablename = 'accessories';
										$where = 1;
										$orderby = '';
										$accessries_data = $db->select($tablename, $orderby, $where);
                                    ?>
                                    <div class="accordion" id="SavedAccessories">
										<?php foreach ($accessries_data as $key => $accessories) {  ?>
                                      	<div class="card">
                                        	<div class="card-header" id="headingOne" style="margin-left:20px">
                                          		<h5 class="mb-0">
                                            	<button class="btn btn-danger" style="width:150px" type="button" data-toggle="collapse" data-target="#ACard<?php echo $key ?>" aria-expanded="true" aria-controls="ACard<?php echo $key ?>">
                                              	<?php echo $accessories['make'] ?>
                                            </button>
                                          </h5>
                                        </div>

                                        <div id="ACard<?php echo $key ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#SavedAccessories">
                                          <div class="card-body" style="padding-left:50px">
																						<!-- INNER DATA -->
																						<?php
				                                        //include_once($pathaj."prices_list.php");
																								$tablename1 = 'accessories_model';
																								$where1 = 'accessories_id = '.$accessories['id'];
																								$orderby1 = '';
																								$accessries_model_data = $db->select($tablename1, $orderby1, $where1);
				                                    ?>
																						<?php if($accessries_model_data) foreach ($accessries_model_data as $key1 => $a_model) {  ?>
																						<div class="card">
																							<div class="card-header" id="headingOne" style="margin-left:20px">
																								<h5 class="mb-0">
																									<button class="btn btn-warning" style="width:150px" type="button" data-toggle="collapse" data-target="#BCard<?php echo $key1 ?>" aria-expanded="true" aria-controls="BCard<?php echo $key1 ?>">
																										<?php echo $a_model['model'] ?>
																									</button>
																								</h5>
																							</div>

																							<div id="BCard<?php echo $key1 ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#SavedAccessories">
																								<div class="card-body" style="padding-left:50px">
																									<!-- INNER INNER DATA -->
																									<?php
							                                        //include_once($pathaj."prices_list.php");
																											$tablename2 = 'accessories_type';
																											$where2 = 'accessories_model_id = '.$a_model['id'];
																											$orderby2 = '';
																											$accessries_type_data = $db->select($tablename2, $orderby2, $where2);
							                                    ?>
																									<?php if($accessries_type_data) foreach ($accessries_type_data as $key2 => $a_type) {  ?>
																									<div class="card">
																										<div class="card-header" id="headingOne" style="margin-left:20px">
																											<h5 class="mb-0">
																												<button class="btn btn-info" style="width:150px" type="button" data-toggle="collapse" data-target="#CCard<?php echo $key2 ?>" aria-expanded="true" aria-controls="CCard<?php echo $key2 ?>">
																													<?php echo $a_type['name'] ?>
																												</button>
																											</h5>
																										</div>

																										<div id="CCard<?php echo $key2 ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#SavedAccessories">
																											<div class="card-body" style="padding-left:50px">
																												<!-- INNER INNER INNER DATA -->
																												<?php
										                                        //include_once($pathaj."prices_list.php");
																														$tablename3 = 'accessories_color';
																														$where3 = 'accessories_type_id = '.$a_type['id'];
																														$orderby3 = '';
																														$color_string = '';
																														$accessries_color_data = $db->select($tablename3, $orderby3, $where3);
																														if($accessries_color_data) foreach ($accessries_color_data as $key3 => $a_color) {
																															$color_string .= $a_color['color_name'].',';
																														}
										                                    ?>
																												<h5 class="mb-0">
																													<button class="btn btn-success" style="width:150px" type="button" data-toggle="collapse" data-target="#CCard<?php echo $key2 ?>" aria-expanded="true" aria-controls="CCard<?php echo $key2 ?>">
																														<?php echo $color_string ?>
																													</button>
																												</h5>
																												<!-- INNER INNER INNER DATA -->
																											</div>
																										</div>
																									</div>
																								<?php } ?>
																								<!-- INNER INNER DATA END -->
																								</div>
																							</div>
																						</div>
																					<?php } ?>
																					<!-- INNER DATA END -->
                                          </div>
                                        </div>
                                      </div>
																		<?php } ?>
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
		include_once($pathModal."modal_manufacturer.php");
		include_once($pathModal."modal_model.php");
		include_once($pathModal."modal_type.php");
		include_once($pathModal."modal_color.php");

		// include_once($path."footer.php");
	?>
</footer>
</body>
</html>
<script>
	$('#txtmake').typeahead({
        source: function (query, process) {
            return $.getJSON('makelist.php', { query: query }, function (data) {
                return process(data);
            });
        },

        minLength : 2,
        //items : 4,
        property: 'name'
    });


	$("#txtmodel").typeahead({
			source: function (query, process) {
				var make = $("#txtmake").val();
				//alert(course);
				return $.getJSON('modellist.php', { query: query, make: make }, function (data) {
					//alert (data);
					return process(data);
				});
			},

			minLength : 2,
			//items : 4,
			property: 'name'
	});



	$('#txtpart').typeahead({
        source: function (query, process) {
            return $.getJSON('partslist.php', { query: query }, function (data) {
                return process(data);
            });
        },

        minLength : 2,
        //items : 4,
        property: 'name'
    });

</script>


<script type="text/javascript">

	function setVal() {
		if (document.getElementById("chkviewed").checked) {
			document.getElementById("txtviewed").value = 1;
		} else {
			document.getElementById("txtviewed").value = 0;
		}
	}

	function validateForm () {
		var success = 1;

		if (document.getElementById("txtmake").value == "" ) {
				alert("Please enter Manufactured By!");
				success = 0;
				return;

		}
		if (document.getElementById("txtmodel").value == "" ) {
				alert("Please enter Model Name!");
				success = 0;
				return;

		}
		if (document.getElementById("txtpart").value == "" ) {
				alert("Please enter Part Name!");
				success = 0;
				return;

		}

		if (success == 1) {
			var docForm = document.getElementById('pricesform');
			var serializedData = new FormData(docForm);

			$.ajax({
				type:'POST',
				url: "prices_controller.php",
				data:serializedData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(data){
				   if (data > 0 )	{
					alert ("Data is saved successfully!");
					document.getElementById('txtmake').value = '';
					document.getElementById('txtmodel').value = '';
					document.getElementById('txtpart').value = '';
					document.getElementById('txtprice').value = '';
					document.getElementById('chkviewed').value = '';
					document.getElementById('txtcomments').value = '';
					document.getElementById('txtid').value = '';
					$("#priceslist").load("prices_list.php");
					$('#collapseOne').collapse('hide');
					$('#collapseTwo').collapse('show');
				}
			   else
					alert ("Data could not be saved!");
				}
			});

		}
	}
	function validateSearch () {
		var success = 1;
    	/*
		if (document.getElementById("model").value == "" ) {
				alert("Please enter Model Name!");
				success = 0;
				return;

		}
		if (document.getElementById("part").value == "" ) {
				alert("Please enter Part Name!");
				success = 0;
				return;

		}
		*/
		if (success == 1) {
			var serializedData = $('#searchform').serialize();
			$.post("prices_list.php",serializedData,function(data){
				$('#priceslist').html(data);
			});
		}
	}

	/*
	if (success == 1) {

		var serializedData = $('#companiesform').serialize();

		$.post("companies_controller.php",serializedData,function(data){
           //alert(data);
		   if (data > 0 )	{
				alert ("Data is saved successfully!");
				document.getElementById('txtname').value = '';
				document.getElementById('txtcperson').value = '';
				document.getElementById('txtaddress').value = '';
				document.getElementById('txtcity').value = '';
				document.getElementById('txtstate').value = '';
				document.getElementById('txtzip').value = '';
				document.getElementById('txtcountry').value = '';
				document.getElementById('txtcontact').value = '';
				document.getElementById('txtemail').value = '';
				document.getElementById('txtfbadd').value = '';
				document.getElementById('txttwadd').value = '';
				document.getElementById('txtlnadd').value = '';
				document.getElementById('txtbgadd').value = '';
				document.getElementById('txtfile').value = '';
				document.getElementById('txtuname').value = '';
				document.getElementById('txtpword').value = '';
				$("#companieslist").load("ajaxcompanies.php");
			}
		   else
				alert ("Data could not be saved!");

		});
	}
	*/


</script>
