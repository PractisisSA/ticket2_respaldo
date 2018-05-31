<?php
	session_start();
	include '../conexion.php';
	$cboEvento = 0; //$_REQUEST['cboEvento'];
	$idDistri = $_REQUEST['idDistri'];
	$num_entradas = $_REQUEST['num_entradas'];
	
	$sql = 'INSERT INTO `entrega_boletos` (`id`, `id_usu`, `id_con`, `cantidad`) VALUES (NULL, "'.$idDistri.'", "'.$cboEvento.'", "'.$num_entradas.'")';
	$res = mysql_query($sql) or die (mysql_error());
	echo 'Boletos asignados con Éxito';
?>