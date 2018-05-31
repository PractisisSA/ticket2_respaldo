<?php
	include '../conexion.php';
	$boleto = $_REQUEST['boleto'];
	$sql = 'select * from Boleto where strBarcode = "'.$boleto.'" ';
	$res = mysql_query ($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	$idCon = $row['idCon'];
	
	$sql2 = 'select * from Concierto where idConcierto = "'.$idCon.'" ';
	$res2 = mysql_query ($sql2) or die (mysql_error());
	$row2 = mysql_fetch_array($res2);
	$tipo_conc = $row2['tipo_conc'];
	echo $tipo_conc; 
?>