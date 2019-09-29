<!DOCTYPE html>

<?php
	$mainCat = "Sell";
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
	.typeahead {
		z-index: 1000;
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
?>
<div class="row-fluid ">
	<div class="span12">
		<!-- LayerSlider Content End -->
		<div class="row-fluid divider slide_divider base_color_background">
			<div class="container">
			</div>
		</div>
		<div class="container">
			<div class="row-fluid distance_1" style="margin-top:30px;">
				<!-- <div class="row-fluid">
					<div class="span12 discover"> -->
						<!-- <form class="form-horizontal" id="searchcform"  name="searchcform" method="post" >
						<div class="span5">
							<div class="control-group">
								<label class="control-label" >Manufactured By: </label>
								<div class="controls">
									<input  type="text" name="make" id="make"  class="input-large" tabindex="1" >
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" >Model Name: </label>
								<div class="controls">
									<input  type="text"  name="model" id="model" class="input-large" tabindex="2" />
								</div>
							</div>
						</div>
						<div class="span5">
							<div class="control-group">
								<label class="control-label" >Network: </label>
								<div class="controls">
									<input  type="text"  name="network" id="network" class="input-large" tabindex="3" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" >IMEI: </label>
								<div class="controls">
									<input  type="text"  name="imei" id="imei" class="input-large" tabindex="4" />
								</div>
							</div>
							<div class="control-group">
								<a href="javascript:validatesForm();"  class="button_bar" style="float:right;">Search</a>
							</div>
						</div>
						</form> -->
					<!-- </div>
					<div> -->
						<div id="stocklist">
							<?php
								include_once($pathaj."stock_list.php");
							?>
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
<script>
/*
	$('#make').typeahead({
        source: function (query, process) {
            return $.getJSON('makelist.php', { query: query }, function (data) {
                return process(data);
            });
        },

        minLength : 2,
        //items : 4,
        property: 'name'
    });


	$("#model").typeahead({
			source: function (query, process) {
				var make = $("#make").val();
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



	$('#part').typeahead({
        source: function (query, process) {
            return $.getJSON('partslist.php', { query: query }, function (data) {
                return process(data);
            });
        },

        minLength : 2,
        //items : 4,
        property: 'name'
    });
	*/
</script>


<script type="text/javascript">

	function validatesForm() {

		var serializedData = $('#searchcform').serialize();
			$.post("stock_list.php",serializedData,function(data){
				$('#stocklist').html(data);
			});

	}


</script>
