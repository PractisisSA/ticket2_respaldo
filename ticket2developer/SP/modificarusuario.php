<?php
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadSP.php");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$num_dato = $_REQUEST['dato'];
	$idUser = $_REQUEST['id'];
	$infoanterior = $_REQUEST['info'];
	$fecha = date('Y-m-d H:i:s');
	$idlog = 'NULL';
	$creador = $_SESSION['iduser'];
	$accion = 'Modificacion';
	$estadolog = 'Activo';
	
	if($num_dato == 1){
		$nombre = $_REQUEST['nombre'];
		$campo = 'Nombre';
		try{
			$updateUser = "UPDATE Usuario SET strNombreU = ? WHERE idUsuario = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($nombre,$idUser));
			
			$insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$nombre,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 2){
		$cedula = $_REQUEST['cedula'];
		$campo = 'Cedula';
		try{
			$updateUser = "UPDATE Usuario SET strCedulaU = ? WHERE idUsuario = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($cedula,$idUser));
			
			$insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$cedula,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 3){
		$mail = $_REQUEST['mail'];
		$campo = 'E-mail';
		try{
			$updateUser = "UPDATE Usuario SET strMailU = ? WHERE idUsuario = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($mail,$idUser));
			
			$insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$mail,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 4){
		$dir = $_REQUEST['dir'];
		$campo = 'Direccion';
		try{
			$updateUser = "UPDATE Usuario SET strDireccionU = ? WHERE idUsuario = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($dir,$idUser));
			
			$insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$dir,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 5){
		$ciudad = $_REQUEST['ciudad'];
		$campo = 'Ciudad';
		try{
			$updateUser = "UPDATE Usuario SET strCiudadU = ? WHERE idUsuario = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($ciudad,$idUser));
			
			$insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$ciudad,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 6){
		$prov = $_REQUEST['prov'];
		$campo = 'Provincia';
		try{
			$updateUser = "UPDATE Usuario SET strProvinciaU = ? WHERE idUsuario = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($prov,$idUser));
			
			$insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$prov,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 7){
		$movil = $_REQUEST['movil'];
		$campo = 'Telefono Movil';
		try{
			$updateUser = "UPDATE Usuario SET strTelU = ? WHERE idUsuario = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($movil,$idUser));
			
			$insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$movil,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 8){
		$fijo = $_REQUEST['fijo'];
		$campo = 'Telefono Fijo';
		try{
			$updateUser = "UPDATE Usuario SET intfijoU = ? WHERE idUsuario = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($fijo,$idUser));
			
			$insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$fijo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 9){
		$estado = $_REQUEST['estado'];
		$campo = 'Estado';
		try{
			$updateUser = "UPDATE Usuario SET strEstadoU = ? WHERE idUsuario = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($estado,$idUser));
			
			$insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$estado,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 10){
		$perfil = $_REQUEST['perfil'];
		$campo = 'Perfil';
		try{
			$updateUser = "UPDATE Usuario SET strPerfil = ? WHERE idUsuario = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($perfil,$idUser));
			
			$insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$perfil,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 11){
		$newpass = md5($_REQUEST['newpass']);
		$campo = 'password';
		try{
			$updateUser = "UPDATE Usuario SET strContrasenaU = ? WHERE idUsuario = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($newpass,$idUser));
			
			// $insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			// $log = $gbd -> prepare($insertlog);
			// $log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$perfil,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
?>