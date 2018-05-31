<?php
	include '../conexion.php';
	$id = $_REQUEST['id'];
	$sql = 'update Boleto set nombreHISB = "empresario_vendido" where idCon = "'.$id.'" and nombreHISB = "empresario" ';
	$res = mysql_query($sql) or die (mysql_error());
	if($res){
		echo 'Boletos empresarios registrados con exito';
	}else{
		echo 'Error';
	}
?>