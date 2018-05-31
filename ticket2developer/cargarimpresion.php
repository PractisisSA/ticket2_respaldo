<?php 
	require_once '../classes/private.db.php';
	include('../html2pdf/html2pdf/html2pdf.class.php');
	
	$datos = $_GET['datos'];
	try{
		$html2pdf = new HTML2PDF('P', 'A4', 'en');    
		//$html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($datos);
		$html2pdf->Output('pdf/hola.pdf','F');
		
		header("Location : documentos/hola.pdf");
		
	}
	catch(HTML2PDF_exception $e){
		echo 'my errors '.$e;
		exit;
	}
?>