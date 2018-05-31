<?php 
	date_default_timezone_set('America/Guayaquil');
	include("../../controlusuarios/seguridadSP.php");
	require_once('../../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$cedula = $_POST['valor'];
	
	$select = "SELECT * FROM Cliente WHERE strDocumentoC = ?";
	$slt = $gbd -> prepare($select);
	$slt -> execute(array($cedula));
	$row = $slt -> fetch(PDO::FETCH_ASSOC);
	$numrows = $slt -> rowCount();
	if($numrows > 0){
		$json = '{"Cliente":[{ 
		"id" : "'.$row['idCliente'].'", 
		"nombre" : "'.$row['strNombresC'].'",
		"cedula" : "'.$row['strDocumentoC'].'",
		"mail" : "'.$row['strMailC'].'",
		"dir" : "'.$row['strDireccionC'].'",
		"envio" : "'.$row['strEnvioC'].'",
		"fijo" : "'.$row['strTelefonoC'].'",
		"movil" : "'.$row['intTelefonoMovC'].'"
		}]}';
		
		echo $json;
	}else{
		$cedula = strlen($cedula);
		if($cedula == 10){
			echo 'noexiste';
		}else{
			echo 'nodata';
		}
	}
?>