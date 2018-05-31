<?php
	include '../conexion.php';
	$cboEvento = $_REQUEST['cboEvento'];
	$idDistri = $_REQUEST['idDistri'];
	
	$sql = 'select * from entrega_boletos where id_usu = "'.$idDistri.'" and id_con = "'.$cboEvento.'" ';
	$res = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_array($res);
	$cantidad = $row['cantidad'];
	echo $cantidad;
?>