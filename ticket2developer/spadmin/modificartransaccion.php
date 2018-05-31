<?php 
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadSA.php");
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$idreg = 'NULL';
	$idsocio = $_POST['socio'];
	$idautorizacion = $_POST['auto'];
	$idusuario = $_SESSION['iduser'];
	$tipotrans = $_POST['estado'];
	$inicialinfo = $_POST['seciniinfo'];
	$finalinfo = $_POST['secfininfo'];
	$observacion = $_POST['obstrans'];
	$fechaproceso = date('Y-m-d H:i:s');
	$estado = 'Activo';
	
	if((strlen($inicialinfo) == 1)){
		$inicial = '00000000'.$inicialinfo;
	}else if((strlen($inicialinfo) == 2)){
		$inicial = '0000000'.$inicialinfo;
	}else if((strlen($inicialinfo) == 3)){
		$inicial = '000000'.$inicialinfo;
	}else if((strlen($inicialinfo) == 4)){
		$inicial = '00000'.$inicialinfo;
	}else if((strlen($inicialinfo) == 5)){
		$inicial = '0000'.$inicialinfo;
	}else if((strlen($inicialinfo) == 6)){
		$inicial = '000'.$inicialinfo;
	}else if((strlen($inicialinfo) == 7)){
		$inicial = '00'.$inicialinfo;
	}else if((strlen($inicialinfo) == 8)){
		$inicial = '0'.$inicialinfo;
	}else if((strlen($inicialinfo) >= 9)){
		$inicial = $inicialinfo;
	}
	
	if((strlen($finalinfo) == 1)){
		$fin = '00000000'.$finalinfo;
	}else if((strlen($finalinfo) == 2)){
		$fin = '0000000'.$finalinfo;
	}else if((strlen($finalinfo) == 3)){
		$fin = '000000'.$finalinfo;
	}else if((strlen($finalinfo) == 4)){
		$fin = '00000'.$finalinfo;
	}else if((strlen($finalinfo) == 5)){
		$fin = '0000'.$finalinfo;
	}else if((strlen($finalinfo) == 6)){
		$fin = '000'.$finalinfo;
	}else if((strlen($finalinfo) == 7)){
		$fin = '00'.$finalinfo;
	}else if((strlen($finalinfo) == 8)){
		$fin = '0'.$finalinfo;
	}else if((strlen($finalinfo) >= 9)){
		$fin = $finalinfo;
	}
	$registrado = 'ok';
	
	try{
		$sql = "INSERT INTO registrotrabajos VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $gbd -> prepare($sql);
		$stmt -> execute(array($idreg,$idsocio,$idautorizacion,$idusuario,$tipotrans,$inicial,$fin,$observacion,$fechaproceso,$estado));
		
		$update = "UPDATE autorizaciones SET registradoA = ? WHERE idAutorizacion = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($registrado,$idautorizacion));
		
	}catch(PDOException $e){
		print_r($e);
	}
?>