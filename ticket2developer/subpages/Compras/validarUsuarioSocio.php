<?php
	include '../../conexion.php';
	$cedulaValidar = $_REQUEST['cedulaValidar'];
	$forma_pago_validar = $_REQUEST['forma_pago_validar'];
	$sql = 'select count(id) as cuantos from socio_membresia where cedula = "'.$cedulaValidar.'" and forma_pago = "'.$forma_pago_validar.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	if($row['cuantos']>0){
		echo 1;
	}else{
		echo 0;
	}
?>