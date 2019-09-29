<!DOCTYPE html>

<?php
	error_reporting(0);
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
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,300italic' rel='stylesheet' type='text/css' />    
	<!--  Styles --> 
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" type="text/css" media="all"/>    		
	<link rel="stylesheet" type="text/css" media="all" href="assets/css/style.css" />   
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-responsive.css" type="text/css" media="all"/>    		
	
	<style>
    body {
        height: 99%; 
		width: 210mm;
        /* to centre page on screen*/
        margin-left: auto;
        margin-right: auto;
    }
	.borderless td, .borderless th {
    border: none;	
	}
	hr{
    display: block;
    height: 1px;
    background: transparent;
    width: 100%;
    border: none;
    border-top: solid 1px #000;
	margin: 5px 0;
	}	
	p {
		font-size:10px;
	}
    </style>	
</head> 
<?php
	include_once 'include/global.inc.php';
	$sid = $_GET['sid'];

	$tablename="sale";
	$orderby = " ORDER BY created_at DESC";
	$where= "id=$sid";
	
	$datar = $db->select($tablename,$orderby, $where);
	
	foreach ($datar as $row) {
		$shosid = $row['shop_id'];
		$edate  = $row['date_entered'];	
		$invoice  = $row['invoice'];		
		$make  = $row['make'];
		$model  = $row['model'];
		$imei  = $row['imei'];
		$access  = $row['accessories'];
		$customername  = $row['customer_name'];		
		$price  = $row['price'];
		$grade  = $row['grade'];
		$mode  = $row['payment_mode'];
		$sigimage  = $row['signimage'];
		$sellby  = $row['entered_by'];
	}	
	$sql = "SELECT * FROM shops WHERE id = $shosid";	
	$shdata = $db->selectQuery($sql);	
	foreach ($shdata as $shrow) {
		$shopname = $shrow['name'];
		$shaddress = $shrow['address'];
		$shcity = $shrow['city'];
		$shcontact = $shrow['contact'];
		$shemail = $shrow['email'];	
		//$comadd = $shaddress . "," . $shcity . "," ."Tel: ".$shcontact ;
		$comadd = $shaddress . ", " . $shcity;
    }		
	
?>   
<body>
<div id="printdiv">
		<div style="text-align: center;">
			<h1 style="line-height:5px;">SALE AGREEMENT</h1>				
		</div>			
		<div style="text-align: center;">			
			<?php echo $comadd;?>
		</div>	
		<!--<div style="text-align: center;">			
			<?php //echo $shemail;?>
		</div>	-->
		<hr>
		<div style="width: 100%;">
			
			<div style="float: left; width: 30%;font-size:14px;">
				<b>Invoice #: <?php echo $invoice;?></b>				
			</div>	
			<div style="float: left; width: 20%;">&nbsp;</div>
			<div style="float: right; width: 40%;"><b>Selling Date : <?php echo $edate;?></b></div>
			<br style="clear: left;" />
		</div>	
		<div style="width: 100%;">
			<div style="float: left; width: 25%;">
				<b>Make : <?php echo $make;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>Model : <?php echo $model;?></b>
			</div>
			<div style="float: left; width: 45%;">
				<b>IMEI: <?php echo $imei;?></b> -&nbsp;&nbsp;<b>Price : <?php echo "&pound".$price;?></b> -&nbsp;&nbsp;<b>Grade : <?php echo $grade;?></b>
			</div>			
			<br style="clear: left;" />
		</div>	
		<div style="width: 100%;">
			<div style="float: left; width: 30%;">
				<b>Accessories : <?php echo $access;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>Payment Mode : <?php echo $mode;?></b>
			</div>
			<div style="float: left; width: 30%;">
				<b>Customer Name : <?php echo $customername;?></b>
			</div>
			<br style="clear: left;" />
		</div>			
		<hr>
		<div style="font-size:10px;">
			The following Sales Terms and Conditions relate to the sale of Refurbished Phone Products ('Product/s') purchased by the Company ('Us', 'We', 'Our'). These said Terms and Conditions are activated from once the product/s accepted and are paid for in full.<br/>
			<b>1. Understanding your Refurbished Product</b></br>
			Your product has met Company's high quality-control standards. While all our phones are refurbished, they have been thoroughly tested and graded.<br/>									
			<b>2.	Understanding the Grade of your Refurbished Product</b><br/>
			<b>Grade A</b><br/>
			- The phone is used but in excellent condition.<br/>
			- Cosmetically the phone will show no signs of use, there will be no scratches, cracks or scuffs to the screen or casing.<br/>
			- It's been fully tested*, is in full working order and has been restored to the latest operating system.<br/>												
			<b>Grade B</b><br/>
			- The phone is used and in good condition.</br>
			- Cosmetically the phone will show signs of slight use, including two or three minor scratches to the screen and casing. It won't have cracks on the screen or casing.</br>
			- It's been fully tested*, is in full working order and has been restored to the latest operating system.</br>			
			<b>Grade C</b></br>
			- The phone is used and in average condition.</br>
			- Cosmetically the phone will show signs of use, including some scratches and scuffs to the screen and casing. It won't have cracks on the screen or casing.</br>
			- It's been fully tested*, is in full working order and has been restored to the latest operating system.</br>
			<b>3.	Acceptance of Sale</b></br>
			You will be offered the opportunity to inspect your product in-store and you will be made aware of the Grade of your product in accordance with the terms of Conditions (1) and (2). Once you have tested the product and completed the sale by paying for the product, you are deemed to have accepted the product in its current condition and grading.</br>
			<b>4.	Returns, Repairs and Replacements</b></br>
			4.1	We only entertain genuine claims and reserve right to decline any false claims.</br> 
			4.2	All guarantees to replace, repair or return are void if the returned the product is found to be damaged, scratched, modified, physically altered or manipulated in anyway. This includes attempts to repair the product at another outlet.</br>
			4.3	The Company will either choose to repair the product in-house or replace as necessary. </br>
			4.4	Any product returned to us may be charged an additional fee of <?php echo "&pound";?>25 to cover the cost of testing and return if products are found to be fully working.</br>
			4.5	You will be offered the opportunity to inspect and accept the product before purchasing, therefor we will not refund purchases if you:</br>
			4.5.1	Made a mistake when purchasing the product; or</br>
			4.5.2	Have  changed your mind about the product; or</br>
			4.5.3	Are returning the product based on facts which you were aware of at the time of the sale.</br>
			4.6	In addition to condition 7;  any returns, repairs or replacement requests will be rejected unless the following conditions are met:</br>
			4.6.1	The product will only be accepted within 30 days of purchase</br>
			4.6.2	Returns will only be accepted from the person who bought the item</br>
			4.6.3	The original purchase receipt is made available at the time of the request</br>
			The above conditions are part of our commitment to high quality service and do not affect your statutory rights as a consumer. These terms and conditions of sale are governed by the law of England and Wales, and are subject to the jurisdiction of the courts of England and Wales.</br>
			<hr>
			<p><b>By signing this contract you are confirming your acceptance and understanding of the Grade of your product and agree to the terms and conditions herein.</b></br>
			<p>Customer Signatures: <img src="documents/<?php echo $sigimage;?>" style="width:200px;height:55px;"> &nbsp;&nbsp;&nbsp;<b>Sold By : <?php echo $sellby;?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Printed On : <?php echo $edate;?></b></p>						
		</div>	
</div>		
	<a href="javascript:printdiv('printdiv');"  class="button_bar">Print</a>
</body>
</html>
<script type="text/javascript">	
	
	function printdiv(printpage)
	{
		var headstr = "<html><head><title></title></head><body>";
		var footstr = "</body>";
		var newstr = document.all.item(printpage).innerHTML;
		var oldstr = document.body.innerHTML;
		document.body.innerHTML = headstr+newstr+footstr;
		window.print();
		//document.body.innerHTML = oldstr;
		//return false;
	}
</script>	
