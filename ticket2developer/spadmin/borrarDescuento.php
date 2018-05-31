<?php
	include '../conexion.php';
	$idCon = $_REQUEST['id'];
	$nombDesc = $_REQUEST['nombDesc'];

		$sql = "delete from descuentos  where idcon = $idCon and nom = '$nombDesc'";
        //echo $sql;
		$res = mysql_query($sql) or die (mysql_error());
		if($res){
			echo 'Descuento borrado con Éxito';
		}else{
			echo 'Error , comuniquese con el administrador del sistema';
		}

?>