<?php
	include '../conexion.php';
	$idloc = $_REQUEST['idloc'];
	
	$sqlL = 'delete from Localidad where idLocalidad = "'.$idloc.'"';
	$resL = mysql_query($sqlL) or die  (mysql_error());
	
	echo $sqlL;
?>