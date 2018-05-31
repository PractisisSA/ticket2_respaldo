<?php
	session_start();
	include '../conexion.php';
	$id_locNueva = $_REQUEST['id_locNueva'];
	
	$sql = 'delete from Localidad where idLocalidad = "'.$id_locNueva.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	
	if($res){
		echo 'Localidad Eliminada con Éxito';
	}else{
		echo 'Error';
	}
?>