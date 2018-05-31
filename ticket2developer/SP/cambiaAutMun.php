<?php
	include '../conexion.php';
	$autMun = $_REQUEST['autMun'];
	$id = $_REQUEST['id'];
	$sql = 'UPDATE ticktfacil SET autMun = "'.$autMun.'" WHERE idticketFacil = "'.$id.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	if($res){
		echo 'Autorización Municipal actualizada con Éxito';
	}
?>