<?php 	

	date_default_timezone_set('America/Guayaquil');	
	include 'conexion.php';
	$id = $_REQUEST['id'];

	$sql = 'UPDATE detalle_boleto SET estadoCompra = 0 WHERE idBoleto = '.$id.'';
	$res = mysql_query($sql);
	if ($res) {
		echo "Boleto desactivado";
	}else{
		echo "Ha ocurrido un error";
	}
?>