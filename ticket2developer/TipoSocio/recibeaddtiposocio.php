<?php
	//incluir el archivo de conexion a la base de datos//
	include '../conexion.php';

	//recibir las variables //
	$tipo_socio = $_REQUEST['tipo_socio'];
	$distribuidor = $_REQUEST['distribuidor'];

	//INSERTAR LOS DATOS EN LA BD
	$insertar = mysql_query("INSERT INTO `tipoSocio`(`nombre`, `id_distribuidor`) VALUES  ('$tipo_socio', '$distribuidor')");

		if (!$insertar){
			echo 'error';
		}
		else {
	echo 'ok';	
	}
?>

