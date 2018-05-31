<?php
	session_start();
	$codigoCompraExp = utf8_encode($_REQUEST['cadaBoleto']);
	echo $_SESSION['content3'];
	echo '<tr><td align="center"><img src="http://www.ticketfacil.ec/ticket2/subpages/Compras/barcode/'.$codigoCompraExp.'.png"/><br><span style="color:#EC1867;"><strong>'.$codigoCompraExp.'</strong></span></td></tr>';
	echo utf8_encode($_SESSION['content4']);
?>	