<?php
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadSP.php");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$id = 'NULL';
	$nombre = $_REQUEST['nombres'];
	$ruc = $_REQUEST['ruc'];
	$razonsocial = $_REQUEST['razonsocial'];
	$printpara = $_REQUEST['printpara'];
	$establecimiento = $_REQUEST['establecimiento'];
	$mail = $_REQUEST['mail'];
	
	$contribuyente = $_REQUEST['contribuyente'];
	if($contribuyente == 1){
		$contribuyente = 'Obligado a llevar Contabilidad';
	}else if($contribuyente == 2){
		$contribuyente = 'No Obligado a llevar Contabilidad';
	}else if($contribuyente == 3){
		$contribuyente = 'Contribuyente Especial';
	}else if($contribuyente == 4){
		$contribuyente = 'Contribuyente RISE';
	}else if($contribuyente == 5){
		$contribuyente = 'Contribuyente Regimen Simplificado';
	}
	
	if($contribuyente == 'Contribuyente RISE'){
		$act = $_REQUEST['actividad'];
		if($act == 1){
			$act = 'Actividades de Comercio';
		}else if($act == 2){
			$act = 'Actividades de Servicio';
		}else if($act == 3){
			$act = 'Actividades de Manufactura';
		}else if($act == 4){
			$act = 'Actividades de Construccion';
		}else if($act == 5){
			$act = 'Hoteles y Restaurantes';
		}else if($act == 6){
			$act = 'Actividades de Trasnporte';
		}else if($act == 7){
			$act = 'Actividades Agricolas';
		}else if($act == 8){
			$act = 'Actividades de Minas y Canteras';
		}
		$categoria = $_REQUEST['categoria'];
		$inferior1 = $_REQUEST['inferior1'];
		$superior1 = $_REQUEST['superior1'];
		$inferior2 = $_REQUEST['inferior2'];
		$superior2 = $_REQUEST['superior2'];
		$monto = $_REQUEST['monto'];
	}else{
		$act = 'No es RISE';
		$categoria = 'No es RISE';
		$inferior1 = 'No es RISE';
		$superior1 = 'No es RISE';
		$inferior2 = 'No es RISE';
		$superior2 ='No es RISE';
		$monto = 'No es RISE';
	}
	
	$nrocontribuyente = $_REQUEST['nrocontribuyente'];
	if($nrocontribuyente == ''){
		$nrocontribuyente = 'No';
	}else{
		$nrocontribuyente = $_REQUEST['nrocontribuyente'];
	}
	$actividades = $_REQUEST['actividades'];
	$inscripcion = $_REQUEST['inscripcion'];
	$obs = $_REQUEST['obs'];
	$movil = $_REQUEST['movil'];
	$fijo = $_REQUEST['fijo'];
	$dir = $_REQUEST['dir'];
	$fecha = date('Y-m-d H:i:s');
	$creador = $_SESSION['iduser'];
	$fechamod = 'No modificado';
	$estado = 'Activo';
	$idlog = 'NULL';
	$accion = 'Insercion';
	$campo = 'Todos';
	$antes = 'Todos';
	$despues = 'Todos';
	$estadolog = 'Activo';
	$tipo = 'Cliente';
	$sEstab = $_REQUEST['serieEstab'];
	if((strlen($sEstab) == 1)){
		$serieEstab = '00'.$sEstab;
		$des = 'Matriz';
	}else{
		if((strlen($sEstab) == 2)){
			$serieEstab = '0'.$sEstab;
		}else{
			if((strlen($sEstab) >= 3)){
				$serieEstab = $sEstab;
			}
		}
		$des = 'SUC'.$sEstab;
	}
	$direstablecimiento = $_REQUEST['dirmatriz'];
	
	try{
		$insert = "INSERT INTO Socio VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $gbd -> prepare($insert);
		$stmt -> execute(array($id,$nombre,$ruc,$razonsocial,$direstablecimiento,$des,$dir,$printpara,$mail,$movil,$fijo,$contribuyente,$nrocontribuyente,$act,$categoria,$inferior1,$superior1,$inferior2,$superior2,$monto,$actividades,$inscripcion,$serieEstab,$obs,$creador,$fecha,$fechamod,$estado));
		$id_insert = $gbd -> lastInsertId();
			
		$insertlog = "INSERT INTO logtributario VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$log = $gbd -> prepare($insertlog);
		$log -> execute(array($idlog,$fecha,$creador,$id_insert,$accion,$campo,$antes,$despues,$tipo,$estadolog));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>