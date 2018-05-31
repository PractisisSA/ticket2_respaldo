<?php

	include '../conexion.php';
	
	$local_desde = $_REQUEST['local_desde'];
	$desde = $_REQUEST['desde'];
	$hasta = $_REQUEST['hasta'];
	$evento_reimprime = $_REQUEST['evento_reimprime'];
	
	$consult = 'SELECT count(idBoleto) as cuantos , strEstado as estado from Boleto where idCon = "'.$evento_reimprime.'" and idLocB = "'.$local_desde.'" AND `serie_localidad` BETWEEN "'.$desde.'" AND "'.$hasta.'"';
	
	$res1 = mysql_query($consult) or die (mysql_error());
	$row1 = mysql_fetch_array($res1);

	echo $row1['cuantos'];

?>