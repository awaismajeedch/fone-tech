<?php

include_once 'classes/html2pdf/html2pdf.class.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') { 
	try
    {	
	//retrieve the $_POST variables	
	$content = $_REQUEST['txtcont'];			
	//$invoice = $_REQUEST['invoice'];			
	$sigdate = new DateTime();
	$sigtime = $sigdate->getTimestamp(); 
	$invoice = preg_replace('/\s+/', '', $sigtime);
	 
	$content= stripslashes($content);

    $html2pdf = new HTML2PDF('P','A4','en');
    $html2pdf->WriteHTML($content);
    //$path = "pdfs/".$invoice.".pdf";
	$path = $invoice.".pdf";
	//$html2pdf->Output($path,'F');
	$html2pdf->Output($path);
	
	//echo 0;
	exit;
	}
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
		
}	
?>
