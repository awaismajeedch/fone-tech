<!DOCTYPE html>

<?php
	$mainCat = "Sold";
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
						<div id="stocklist">
							<?php
								include_once($pathaj."stock_list_sold.php");
								include_once($pathaj."stock_list_sold_1.php");
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
</script>


<script type="text/javascript">

	function validatesForm() {

		// var serializedData = $('#searchcform').serialize();
		// 	$.post("stock_list.php",serializedData,function(data){
		// 		$('#stocklist').html(data);
		// 	});

	}


</script>
