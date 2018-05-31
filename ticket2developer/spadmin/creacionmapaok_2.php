<?php
	session_start();
	//include("../controlusuarios/seguridadSA.php");
	require('../classes/private.db.php');
	// print_r($_REQUEST);
	// die();
	
	$gbd = new DBConn();
	
	$id_localidad = $_REQUEST['id'];
	$id_concierto = $_REQUEST['concierto'];
	$num_filas = $_REQUEST['filas'];
	$num_columnas = $_REQUEST['asientos'];
	$coordenadas = $_REQUEST['cordenadas'];
	$secuencial = $_REQUEST['secuencial_slt'];
	$date_state = $_REQUEST['date_state'];
	$data_full = $_REQUEST['data_full'];
	$estado_mapa = "ok";
	$estado_butaca = "A";
	// $estado_asiento_activo = "Activo";
	// $estado_asiento_inactivo = "I";
	$status = 3;
	$createby = 3;//$_SESSION['iduser'];
	$modifyby = 'No modificado';
	$fechaCreate = date('Y-m-d H:i:s');
	$obsmodify = 'No modificado';
	$fechamod = 'No modificado';
	$total_seats = $_REQUEST['total_seats'];
	//no pago son asientos no disponibles
	$pagopor = 3;
	
	try{
		$updateLocalidad = "UPDATE Localidad SET strEstadoMapaL = ?  , strCapacidadL = ? WHERE idLocalidad = ?";
		$resUpdateLocalidad = $gbd -> prepare($updateLocalidad);
		$resUpdateLocalidad -> execute(array($estado_mapa, $total_seats ,$id_localidad));
		
		$insertButaca = "INSERT INTO Butaca VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$resInsertButaca = $gbd -> prepare($insertButaca);
		$resInsertButaca -> execute(array('NULL',$num_filas,$num_columnas,$coordenadas,$secuencial,$date_state,$data_full,$id_localidad,$id_concierto,$createby,$fechaCreate,'A'));
		$id_butaca = $gbd -> lastInsertId();
	}catch(PDOException $e){
		print_r($e);
	}
	// echo $_REQUEST['valores_asientos'];
	// if($_REQUEST['valores_asientos'] != ''){
		// foreach(explode('@', $_REQUEST['valores_asientos']) as $val_asiento){
			// $ex_asiento = explode('|', $val_asiento);
			// try{
				// $insertAsiento = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				// $resInsertAsiento = $gbd -> prepare($insertAsiento);
				// $resInsertAsiento -> execute(array('NULL',$ex_asiento[0],$ex_asiento[1],$status,$id_localidad,$id_concierto,$pagopor,0));
			// }catch(PDOException $e){
				// print_r($e);
			// }
		// }
	// }
?>