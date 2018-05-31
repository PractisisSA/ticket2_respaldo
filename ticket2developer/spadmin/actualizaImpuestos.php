<?php
	include '../conexion.php';
	$id = $_REQUEST['id'];
	$valorados = $_REQUEST['valorados'];
	$cortesias = $_REQUEST['cortesias'];
	$sayse = $_REQUEST['sayse'];
	$sri = $_REQUEST['sri'];
	$municipio = $_REQUEST['municipio'];
	$id_con = $_REQUEST['id_con'];
	
	if($id == 0){
		$sql = 'INSERT INTO impuestos (id, id_con, valorados, sin_permisos, cortesias, sayse, sri, municipio) 
				VALUES (NULL, "'.$id_con.'", "'.$valorados.'", "", "'.$cortesias.'", "'.$sayse.'", "'.$sri.'", "'.$municipio.'")';
				$txt = 'Ingresados';
	}else{
		$sql = 'update impuestos set valorados = "'.$valorados.'" ,
									 cortesias = "'.$cortesias.'" , 
									 sayse = "'.$sayse.'" , 
									 sri = "'.$sri.'" , 
									 municipio = "'.$municipio.'"
									 where id = "'.$id.'"
				';
				$txt = 'Actualizados';
	}
	$res = mysql_query($sql) or die (mysql_error());
	if($res){
		echo 'Impuestos '.$txt.' con Éxito';
	}else{
		echo 'error!!!';
	}
	
	
?>