<?php
	date_default_timezone_set('America/Guayaquil');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	//include("../controlusuarios/seguridadSA.php");
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$idsocio = $_POST['id'];
	
	$select = "SELECT * FROM Socio WHERE idSocio = ?";
	$slt = $gbd -> prepare($select);
	$slt -> execute(array($idsocio));
	$row = $slt -> fetch(PDO::FETCH_ASSOC);
	
	$rucbd = htmlspecialchars($row['rucS']);
	$razonsocialbd = htmlspecialchars($row['razonsocialS']);
	$matrizbd = htmlspecialchars($row['direccionesS']);
	$dirstabbd = htmlspecialchars($row['direstablecimientoS']);
	$seriedb = htmlspecialchars($row['nroestablecimientoS']);
	$contribuyentebd = htmlspecialchars($row['tipocontribuyenteS']);
	if($contribuyentebd == 'Contribuyente Especial'){
		$nrocontribuyentebd = htmlspecialchars($row['nroespecialS']);
	}else{
		$nrocontribuyentebd = 'No es Contribuyente Especial';
	}
	$actdb = htmlspecialchars($row['actividadS']);
	$categoriadb = htmlspecialchars($row['categoria']);
	$antinferioranual = $row['inferioranualS'];
	$antsuperioranual = $row['superioranualS'];
	$antinferiormensual = $row['inferiormensualS'];
	$antsuperiormensual = $row['superiormensualS'];
	$antmonto = $row['montodocS'];
	
	$idauto = 'NULL';
	$idusuario = 3;
	
	$desEstablecimiento = $_POST['desEstablecimiento'];
	$codEstablecimiento = $_POST['codEstablecimiento'];
	$rucCliente = $_POST['rucCliente'];
	$razonSocial = $_POST['razonSocial'];
	$dirMatriz = $_POST['dirMatriz'];
	$dirEstablecimiento = $_POST['dirEstablecimiento'];
	$con = $_POST['cambioContribuyente'];
	if($con == 1){
		$con = 'Obligado a llevar Contabilidad';
	}else if($con == 2){
		$con = 'No Obligado a llevar Contabilidad';
	}else if($con == 3){
		$con = 'Contribuyente Especial';
	}else if($con == 4){
		$con = 'Contribuyente RISE';
	}else if($con == 0){
		$con = $_POST['contribuyente'];
	}
	$nrocontribuyente = $_POST['nrocontribuyente'];
	$cat = $_POST['cat'];
	$act = $_POST['act'];
	if($act == 1){
		$act = 'Actividades de Comercio';
		if($cat == 1){
			$nuevomonto = 150;
		}else if($cat == 2){
			$nuevomonto = 150;
		}else if($cat == 3){
			$nuevomonto = 200;
		}else if($cat == 4){
			$nuevomonto = 200;
		}else if($cat == 5){
			$nuevomonto = 200;
		}else if($cat == 6){
			$nuevomonto = 250;
		}else if($cat == 7){
			$nuevomonto = 250;
		}
	}else if($act == 2){
		$act = 'Actividades de Servicio';
		if($cat == 1){
			$nuevomonto = 250;
		}else if($cat == 2){
			$nuevomonto = 250;
		}else if($cat == 3){
			$nuevomonto = 350;
		}else if($cat == 4){
			$nuevomonto = 350;
		}else if($cat == 5){
			$nuevomonto = 350;
		}else if($cat == 6){
			$nuevomonto = 450;
		}else if($cat == 7){
			$nuevomonto = 450;
		}
	}else if($act == 3){
		$act = 'Actividades de Manufactura';
		if($cat == 1){
			$nuevomonto = 250;
		}else if($cat == 2){
			$nuevomonto = 250;
		}else if($cat == 3){
			$nuevomonto = 350;
		}else if($cat == 4){
			$nuevomonto = 350;
		}else if($cat == 5){
			$nuevomonto = 350;
		}else if($cat == 6){
			$nuevomonto = 450;
		}else if($cat == 7){
			$nuevomonto = 450;
		}
	}else if($act == 4){
		$act = 'Actividades de Construccion';
		if($cat == 1){
			$nuevomonto = 400;
		}else if($cat == 2){
			$nuevomonto = 400;
		}else if($cat == 3){
			$nuevomonto = 600;
		}else if($cat == 4){
			$nuevomonto = 600;
		}else if($cat == 5){
			$nuevomonto = 600;
		}else if($cat == 6){
			$nuevomonto = 1000;
		}else if($cat == 7){
			$nuevomonto = 1000;
		}
	}else if($act == 5){
		$act = 'Hoteles y Restaurantes';
		if($cat == 1){
			$nuevomonto = 150;
		}else if($cat == 2){
			$nuevomonto = 150;
		}else if($cat == 3){
			$nuevomonto = 200;
		}else if($cat == 4){
			$nuevomonto = 200;
		}else if($cat == 5){
			$nuevomonto = 200;
		}else if($cat == 6){
			$nuevomonto = 250;
		}else if($cat == 7){
			$nuevomonto = 250;
		}
	}else if($act == 6){
		$act = 'Actividades de Trasnporte';
		if($cat == 1){
			$nuevomonto = 250;
		}else if($cat == 2){
			$nuevomonto = 250;
		}else if($cat == 3){
			$nuevomonto = 350;
		}else if($cat == 4){
			$nuevomonto = 350;
		}else if($cat == 5){
			$nuevomonto = 350;
		}else if($cat == 6){
			$nuevomonto = 450;
		}else if($cat == 7){
			$nuevomonto = 450;
		}
	}else if($act == 7){
		$act = 'Actividades Agricolas';
		if($cat == 1){
			$nuevomonto = 400;
		}else if($cat == 2){
			$nuevomonto = 400;
		}else if($cat == 3){
			$nuevomonto = 600;
		}else if($cat == 4){
			$nuevomonto = 300;
		}else if($cat == 5){
			$nuevomonto = 600;
		}else if($cat == 6){
			$nuevomonto = 1000;
		}else if($cat == 7){
			$nuevomonto = 1000;
		}
	}else if($act == 8){
		$act = 'Actividades de Minas y Canteras';
		if($cat == 1){
			$nuevomonto = 400;
		}else if($cat == 2){
			$nuevomonto = 400;
		}else if($cat == 3){
			$nuevomonto = 600;
		}else if($cat == 4){
			$nuevomonto = 600;
		}else if($cat == 5){
			$nuevomonto = 600;
		}else if($cat == 6){
			$nuevomonto = 1000;
		}else if($cat == 7){
			$nuevomonto = 1000;
		}
	}else if($act == 0){
		$act = $_POST['act'];
	}
	
	$negociables = $_POST['negociables'];
	$fechaAutorizacion = $_POST['fechaAutorizacion'];
	$fechaCaducidad = $_POST['fechaCaducidad'];
	$numAutorizacion = $_POST['numAutorizacion'];
	$emitidoEn = $_POST['emitidoEn'];
	$observacion = $_POST['observacion'];
	$imrpresionpara = $_POST['imrpresionpara'];
	$fechaproceso = date('Y-m-d H:i:s');
	$estadoAuto = 'Activo';
	$estadoimpresion = 'Aun no se Imprime';
	$seriesreimpresion = 'no reimpreso';
	$estadoreimpresion = 'no';
	$registrado = 'no';
	
	$idlog = 'NULL';
	$accion = 'Modificacion';
	$tipo = 'Cliente';
	$estadolog = 'Activo';
	
	if($rucCliente != $rucbd){
		
		$campo = 'RUC';
		
		$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo,$rucbd,$rucCliente,$tipo,$estadolog));
		
		$update = "UPDATE Socio SET rucS = ? WHERE idSocio = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($rucCliente,$idsocio));
	}
	if($razonSocial != $razonsocialbd){
		$campo = 'Nombre Comercial';
		
		$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo,$razonsocialbd,$razonSocial,$tipo,$estadolog));
		
		$update = "UPDATE Socio SET razonsocialS = ? WHERE idSocio = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($razonSocial,$idsocio));
	}
	if($dirMatriz != $matrizbd){
		$campo = 'Direccion Matriz';
		
		$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo,$matrizbd,$dirMatriz,$tipo,$estadolog));
		
		$update = "UPDATE Socio SET direccionesS = ? WHERE idSocio = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($dirMatriz,$idsocio));
	}
	if($dirEstablecimiento != $dirstabbd){
		$campo = 'Direccion Establecimeinto';
		
		$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo,$dirstabbd,$dirEstablecimiento,$tipo,$estadolog));
		
		$update = "UPDATE Socio SET direstablecimientoS = ?, imprimirparaS = ? WHERE idSocio = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($dirEstablecimiento,'s',$idsocio));
	}
	if($codEstablecimiento != $seriedb){
		$campo = 'Codigo Establecimeinto';
		
		$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo,$dirstabbd,$codEstablecimiento,$tipo,$estadolog));
		
		$update = "UPDATE Socio SET nroestablecimientoS = ? WHERE idSocio = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($codEstablecimiento,$idsocio));
	}
	if($con != $contribuyentebd){
		$campo = 'Clase de Contribuyente';
		$norise = 'No es RISE';
		$campoS1 = 'Actividad';
		$campoS2 = 'Categoria';
		$campoS3 = 'Valor inferior anual';
		$campoS4 = 'Valor superior anual';
		$campoS5 = 'Valor inferior mensual';
		$campoS6 = 'Valor superior mensual';
		$campoS7 = 'Monto';
		
		if(($con != 'Contribuyente RISE') && ($contribuyentebd == 'Contribuyente RISE')){
			$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo,$contribuyentebd,$con,$tipo,$estadolog));
			
			$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campoS1,$actdb,$norise,$tipo,$estadolog));
			
			$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campoS2,$categoriadb,$norise,$tipo,$estadolog));
			
			$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campoS3,$antinferioranual,$norise,$tipo,$estadolog));
			
			$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campoS4,$antsuperioranual,$norise,$tipo,$estadolog));
			
			$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campoS5,$antinferiormensual,$norise,$tipo,$estadolog));
			
			$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campoS6,$antsuperiormensual,$norise,$tipo,$estadolog));
			
			$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campoS7,$antmonto,$norise,$tipo,$estadolog));
			
			$update = "UPDATE Socio SET tipocontribuyenteS = ?, actividadS = ?, categoria = ?, inferioranualS = ?, superioranualS = ?, inferiormensualS = ?, superiormensualS = ?, montodocS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($update);
			$upd -> execute(array($con,$norise,$norise,$norise,$norise,$norise,$norise,$norise,$idsocio));
		}else{
			$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo,$contribuyentebd,$con,$tipo,$estadolog));
			
			$update = "UPDATE Socio SET tipocontribuyenteS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($update);
			$upd -> execute(array($con,$idsocio));
		}
	}
	if($nrocontribuyente != $nrocontribuyentebd){
		$campo = 'Numero Contribuyente';
		
		$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo,$nrocontribuyentebd,$nrocontribuyente,$tipo,$estadolog));
		
		$update = "UPDATE Socio SET nroespecialS = ? WHERE idSocio = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($nrocontribuyente,$idsocio));
	}
	if(($act != $actdb) && ($act != 'no')){
		$campo = 'Actividad Economica';
		
		$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo,$actdb,$act,$tipo,$estadolog));
		
		$update = "UPDATE Socio SET actividadS = ? WHERE idSocio = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($act,$idsocio));
	}
	if(($cat != $categoriadb) && ($cat != 'no')){
		$campo = 'Categoria';
		if($cat == 1){
			$inferioranual = 0;
			$superioranual = 5000;
			$inferiormensual = 0;
			$superiormensual = 417;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 150;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 400;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 150;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 250;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 400;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 400;
			}
		}else if($cat == 2){
			$inferioranual = 5001;
			$superioranual = 10000;
			$inferiormensual = 418;
			$superiormensual = 833;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 150;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 400;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 150;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 250;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 400;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 400;
			}
		}else if($cat == 3){
			$inferioranual = 10001;
			$superioranual = 20000;
			$inferiormensual = 834;
			$superiormensual = 1667;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 600;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 350;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 600;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 600;
			}
		}else if($cat == 4){
			$inferioranual = 20001;
			$superioranual = 30000;
			$inferiormensual = 1668;
			$superiormensual = 2500;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 600;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 350;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 300;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 600;
			}
		}else if($cat == 5){
			$inferioranual = 30001;
			$superioranual = 40000;
			$inferiormensual = 2501;
			$superiormensual = 3333;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 600;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 350;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 600;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 600;
			}
		}else if($cat == 6){
			$inferioranual = 40001;
			$superioranual = 50000;
			$inferiormensual = 3334;
			$superiormensual = 4167;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 450;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 450;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 1000;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 450;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 1000;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 1000;
			}
		}else if($cat == 7){
			$inferioranual = 50001;
			$superioranual = 60000;
			$inferiormensual = 4168;
			$superiormensual = 5000;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 450;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 450;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 1000;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 450;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 1000;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 1000;
			}
		}
		$campo1 = 'Valor Inferior Anual';
		$campo2 = 'Valor Superior Anual';
		$campo3 = 'Valor Inferior Mensual';
		$campo4 = 'Valor Superior Mensual';
		$campo5 = 'Monto';
		
		$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo,$categoriadb,$cat,$tipo,$estadolog));
		
		//insertcion del cambio inferioranual
		$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$log = $gbd -> prepare($insertlog);
		$log -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo1,$antinferioranual,$inferioranual,$tipo,$estadolog));
		
		//insercion del cambio superioranual
		$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$log = $gbd -> prepare($insertlog);
		$log -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo2,$antsuperioranual,$superioranual,$tipo,$estadolog));
		
		//insercion del cambio inferiormensual
		$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$log = $gbd -> prepare($insertlog);
		$log -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo3,$antinferiormensual,$inferiormensual,$tipo,$estadolog));
		
		//insercion del cambio superiormensual
		$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$log = $gbd -> prepare($insertlog);
		$log -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo4,$antsuperiormensual,$superiormensual,$tipo,$estadolog));
		
		//insercion del cambio monto
		$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$log = $gbd -> prepare($insertlog);
		$log -> execute(array($idlog,$fechaproceso,$idusuario,$idsocio,$accion,$campo5,$antmonto,$nuevomonto,$tipo,$estadolog));
		
		$update = "UPDATE Socio SET categoria = ?, inferioranualS = ?, superioranualS = ?, inferiormensualS = ?, superiormensualS = ?, montodocS = ? WHERE idSocio = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($cat,$inferioranual,$superioranual,$inferiormensual,$superiormensual,$nuevomonto,$idsocio));
	}
	
	foreach(explode('@', $_POST['valores']) as $valor){
		$expAuto = explode('|', $valor);
		if((strlen($expAuto[0]) == 1)){
			$pemision = '00'.$expAuto[0];
		}else if((strlen($expAuto[0]) == 2)){
			$pemision = '0'.$expAuto[0];
		}else if((strlen($expAuto[0]) == 3)){
			$pemision = $expAuto[0];
		}
		if($expAuto[1] == 1){
			$tdoc = 'Factura';
		}else if($expAuto[1] == 2){
			$tdoc = 'Boleto';
		}else if($expAuto[1] == 3){
			$tdoc = 'Nota de Credito';
		}else if($expAuto[1] == 4){
			$tdoc = 'Nota de Debito';
		}else if($expAuto[1] == 5){
			$tdoc = 'Nota de Venta';
		}else if($expAuto[1] == 6){
			$tdoc = 'Liquidacion de Compras';
		}else if($expAuto[1] == 7){
			$tdoc = 'Guia de Remision';
		}else if($expAuto[1] == 8){
			$tdoc = 'Comprobante Retencion';
		}else if($expAuto[1] == 9){
			$tdoc = 'Taximetros y Registradoras';
		}else if($expAuto[1] == 10){
			$tdoc = 'LC Bienes Muebles usados';
		}else if($expAuto[1] == 11){
			$tdoc = 'LC Vehiculos usados';
		}else if($expAuto[1] == 12){
			$tdoc = 'Acta entrega/recepcion';
		}
		try{
			$insert = "INSERT INTO autorizaciones VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idauto,$idsocio,$idusuario,$rucCliente,$razonSocial,$desEstablecimiento,$codEstablecimiento,$dirMatriz,$dirEstablecimiento,$con,$nrocontribuyente,$negociables,$fechaAutorizacion,$fechaCaducidad,$numAutorizacion,$tdoc,$pemision,$expAuto[2],$expAuto[3],$imrpresionpara,$estadoimpresion,$estadoimpresion,$estadoimpresion,$emitidoEn,$fechaproceso,$observacion,$estadoAuto,$registrado));
		}catch(PDOException $e){
			print_r($e);
		}
	}
?>