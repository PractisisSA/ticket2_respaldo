<?php
session_start();
	//include("../controlusuarios/seguridadSA.php");
	require('../Conexion/conexion.php');
	include '../conexion.php';
	// print_r($_REQUEST);_REQUEST
	// die();
	$id_localidad = $_REQUEST['local'];
	$id_concierto = $_REQUEST['concierto'];
	$coordenadas = $_REQUEST['coordenadas'];
	$secuencia = $_REQUEST['secuencia'];
	$asientos = $_REQUEST['totalasientos'];
	$filas = $_REQUEST['filas_new'];
	$columnas = $_REQUEST['seats_new'];
	$obsCambio = $_REQUEST['obsModmapa'];
	$modifyby = $_SESSION['iduser'];
	$fechamod = date('Y-m-d H:i:s');	
	$status = 3;
	
	// $updateButaca = "UPDATE Butaca SET intFilasB = '$filas', intAsientosB = '$columnas', strCoordenadasB = '$coordenadas', strSecuencial = '$secuencia', 
					// modifybyB = '$modifyby', obsModifyB = '$obsCambio', fechaModificacionB = '$fechamod' WHERE intLocalB = '$id_localidad' AND intConcB = '$id_concierto'" or die(mysqli_error($mysqli));
	
	
	$sqlB = 'UPDATE Butaca SET 	`intFilasB` = "'.$filas.'", 
								`intAsientosB` = "'.$columnas.'", 
								`strCoordenadasB` = "'.$coordenadas.'"
								
								WHERE `intLocalB` = "'.$id_localidad.'"  
								AND `intConcB` = "'.$id_concierto.'"
			';
	echo $sqlB;
	$resB = mysql_query($sqlB) or die (mysql_error());
	// $resultUpdateButaca = $mysqli->query($updateButaca);
	
	$updateLocalidad = "UPDATE Localidad SET strCapacidadL = '$asientos' WHERE idLocalidad = '$id_localidad'" or die(mysqli_error($mysqli));
	$resultUpdateLocalidad = $mysqli->query($updateLocalidad);
	
	foreach(explode('@', $_REQUEST['valores_asientos']) as $val_asiento){
		$ex_asiento = explode('|', $val_asiento);
		if($ex_asiento[0] != ''){
			$insertAsiento = "INSERT INTO ocupadas VALUES ('NULL', '".$ex_asiento[0]."', '".$ex_asiento[1]."', '$status', '$id_localidad', '$id_concierto','','')" or die(mysqli_error($mysqli));
			$resInsertAsiento = $mysqli->query($insertAsiento);
            //echo $insertAsiento.'<br>';
		}
	}
?>