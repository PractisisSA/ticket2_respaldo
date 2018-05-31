<?php
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadSP.php");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$id = $_POST['id'];
	$obs = $_POST['obs'];
	$fechamod = date('Y-m-d H:i:s');
	$moduser = $_SESSION['iduser'];
	$estadoI = 'Inactivo';
	$estadoA = 'Activo';
	$select = "SELECT strEstadoA FROM Artista WHERE idArtista = ?";
	$stmtselect = $gbd -> prepare($select);
	$stmtselect -> execute(array($id));
	$row = $stmtselect -> fetch(PDO::FETCH_ASSOC);
	$estado = htmlspecialchars($row['strEstadoA']);
	
	if($estado == $estadoI){
		try{
			$update = "UPDATE Artista SET modifybyA = ?, obsModifyA = ?, fechaModificacionA = ?, strEstadoA = ? WHERE idArtista = ?";
			$stmtupd = $gbd -> prepare($update);
			$stmtupd -> execute(array($moduser,$obs,$fechamod,$estadoA,$id));
		}catch(PDOException $e){
			print_r($e);
		}
	}else if($estado == $estadoA){
		try{
			$update = "UPDATE Artista SET modifybyA = ?, obsModifyA = ?, fechaModificacionA = ?, strEstadoA = ? WHERE idArtista = ?";
			$stmtupd = $gbd -> prepare($update);
			$stmtupd -> execute(array($moduser,$obs,$fechamod,$estadoI,$id));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	
	echo $estado;
?>