<?php
	include '../conexion.php';
	
	$nuevaC = $_REQUEST['nuevaC'];
	$id = $_REQUEST['id'];
	$claveCodificada = md5($nuevaC);
	$sql = 'update Usuario set strContrasenaU = "'.$claveCodificada.'" where idUsuario = "'.$id.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	if($res){
		echo 'Clave actualizada con Éxito!!!';
	}else{
		echo 'Error, \n Comuniquese con el administrador del sistema!!!';
	}
?>