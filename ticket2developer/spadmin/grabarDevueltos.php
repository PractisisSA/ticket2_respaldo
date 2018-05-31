<?php
	include '../conexion.php';
	$id = $_REQUEST['id'];
	$total_devueltos = $_REQUEST['total_devueltos'];
	
	$sql = 'update cortesias set numbol_devueltos = "'.$total_devueltos.'" where id = "'.$id.'" ';
	//echo $sql;
	$res = mysql_query($sql) or die (mysql_error());
	if($res){
		echo 'Boleto(s) devuelto(s) ingresado(s) con Éxito';
	}else{
		echo 'error!!!';
	}
	
?>