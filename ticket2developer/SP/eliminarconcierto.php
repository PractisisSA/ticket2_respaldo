<?php
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadSP.php");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn(); 
	
	$estado = $_POST['estado'];
	$obs = $_POST['obs'];
	$id = $_POST['ids'];
	$fechamod = date('Y-m-d H:i:s');
	$creador = $_SESSION['iduser'];
	$idlog = 'NULL';
	$accion = 'Update';
	$campo = 'Estado';
	$estlog = 'Activo';
	
	$selectantes = "SELECT strEstado FROM Concierto WHERE idConcierto = ?";
	$ant = $gbd -> prepare($selectantes);
	$ant -> execute(array($id));
	$rowant = $ant -> fetch(PDO::FETCH_ASSOC);
	$antes = $rowant['strEstado'];
	
	try{
		$update = "UPDATE Concierto SET modifybyC = ?, obsModifyC = ?, fechaModificacionC = ?, strEstado = ? WHERE idConcierto = ?";
		$stmt = $gbd -> prepare($update);
		$stmt -> execute(array($creador,$obs,$fechamod,$estado,$id));
		
		$select = "SELECT idUser FROM Concierto WHERE idConcierto = ?";
		$slt = $gbd -> prepare($select);
		$slt -> execute(array($id));
		$row = $slt -> fetch(PDO::FETCH_ASSOC);
		$idcli = $row['idUser'];
		
		// $insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		// $ins = $gbd -> prepare($insert);
		// $ins -> execute(array($idlog,$fechamod,$creador,$idcli,$accion,$campo,$antes,$estado,$estlog));
		
	}catch(PDOException $e){
		print_r($e);
	}
	
	echo $estado;
?>