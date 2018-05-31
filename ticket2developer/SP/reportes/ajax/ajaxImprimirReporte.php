<?php 
	require_once('../../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$distribuidor = $_POST['distribuidor'];
	$reporte = $_POST['reporte'];
	$concierto = $_POST['concierto'];
?>