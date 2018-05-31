<?php
	include '../conexion.php';
	$forma_pago_otro_ = $_REQUEST['forma_pago_otro_'];
	
	$sql = 'select count(id) as cuantos from socio_membresia where cedula = "'.$forma_pago_otro_.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	
	if($row['cuantos'] == 0){
		echo 0;
	}else{
		echo 1;
	}
?>