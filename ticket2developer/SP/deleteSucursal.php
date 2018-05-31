<?php
include("../../conexion.php");
	$address = $_REQUEST['address'];
	
	$select = "UPDATE Socio SET direstablecimientoS = 'Sin Direccion Sucursal' WHERE direstablecimientoS = '".$address."'" ;
	$res = mysql_query($select);
	if ($res) {
		echo 1;
	}else{
		echo 2;	
	}
?>