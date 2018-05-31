<?php
	include '../conexion.php';
	$imagen = $_REQUEST['imagen'];
	$id = $_REQUEST['id'];
	$datepicker = $_REQUEST['datepicker'];
	$sql  = 'update factura set foto = "'.$imagen.'" , fechaE = "'.$datepicker.'" where id = "'.$id.'" ';
	// echo $sql;
	$res = mysql_query($sql) or die (mysql_error());
	if($res){
		echo 'Envio Grabado con éxito';
	}else{
		echo 'error';
	}
?>