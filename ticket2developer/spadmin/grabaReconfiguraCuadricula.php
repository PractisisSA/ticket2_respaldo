<?php
	include '../conexion.php';
	$files = $_REQUEST['files'];
	$seats = $_REQUEST['seats'];
	$totalasientos = $_REQUEST['totalasientos'];
	$idloc = $_REQUEST['idloc'];
	
	$sqlL = 'update Localidad set strCapacidadL = "'.$totalasientos.'" where idLocalidad = "'.$idloc.'" ';
	$resL = mysql_query($sqlL) or die (mysql_error());
	
	$sqlB = 'update Butaca set intFilasB = "'.$files.'" , intAsientosB = "'.$seats.'" where intLocalB = "'.$idloc.'" ';
	$resB = mysql_query($sqlB) or die(mysql_error());
	
	echo 'cuadricula recinfigurada con exito';
	// echo $sqlL."<br><br>".$sqlB;
?>