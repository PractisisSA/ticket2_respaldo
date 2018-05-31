<?php
	$code = $_REQUEST['code'];
	
	$urlbar = 'http://ticketfacil.ec/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$code.'';
	$imgbar = 'barcoded/'.$code.'.png';
	file_put_contents($imgbar, file_get_contents($urlbar));
	
	
?>

<img src = 'http://www.ticketfacil.ec/ticket2developer/spadmin/barcoded/<?php echo $code;?>.png'/>