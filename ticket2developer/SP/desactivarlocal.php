<?php
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadSP.php");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$id = $_POST['id'];
	$obs = $_POST['obs'];
	$fechamod = date('Y-m-d H:i:s');
	$moduser = $_SESSION['iduser'];
	$estadoI = 'I';
	$estadoA = 'A';
	$select = "SELECT strEstadoL FROM Localidad WHERE idLocalidad = ?";
	$stmtselect = $gbd -> prepare($select);
	$stmtselect -> execute(array($id));
	$row = $stmtselect -> fetch(PDO::FETCH_ASSOC);
	$estado = htmlspecialchars($row['strEstadoL']);
	
	$selectOcupadas = "SELECT * FROM ocupadas WHERE local = ?";
	$stmtocupadas = $gbd -> prepare($selectOcupadas);
	$stmtocupadas -> execute(array($id));
	$numRows = $stmtocupadas -> rowCount();
	if($numRows == 0){
		if($estado == $estadoI){
			try{
				$updLocal = "UPDATE Localidad SET modifybyL = ?, obsModifyL = ?, fechaModificacionL = ?, strEstadoL = ? WHERE idLocalidad = ?";
				$stmtlocal = $gbd -> prepare($updLocal);
				$stmtlocal -> execute(array($moduser,$obs,$fechamod,$estadoA,$id));
				
				$updButaca = "UPDATE Butaca SET modifybyB = ?, obsModifyB = ?, fechaModificacionB = ?, strEstado = ? WHERE intLocalB = ?";
				$stmtbutaca = $gbd -> prepare($updButaca);
				$stmtbutaca -> execute(array($moduser,$obs,$fechamod,$estadoA,$id));
				
			}catch(PDOException $e){
				print_r($e);
			}
		}else if($estado == $estadoA){
			try{
				$updLocal = "UPDATE Localidad SET modifybyL = ?, obsModifyL = ?, fechaModificacionL = ?, strEstadoL = ? WHERE idLocalidad = ?";
				$stmtlocal = $gbd -> prepare($updLocal);
				$stmtlocal -> execute(array($moduser,$obs,$fechamod,$estadoI,$id));
				
				$updButaca = "UPDATE Butaca SET modifybyB = ?, obsModifyB = ?, fechaModificacionB = ?, strEstado = ? WHERE intLocalB = ?";
				$stmtbutaca = $gbd -> prepare($updButaca);
				$stmtbutaca -> execute(array($moduser,$obs,$fechamod,$estadoI,$id));
				
			}catch(PDOException $e){
				print_r($e);
			}
		}
		echo $estado;
	}else{
		echo 'no';
	}
?>