<?php
	//include("../controlusuarios/seguridadSA.php");
	//require('../Conexion/conexion.php');
	include '../conexion.php';
	// ini_set('display_startup_errors',1);
	// ini_set('display_errors',1);
	// error_reporting(-1);
	$tipoConcierto = $_REQUEST['tipoConcierto'];
	$idcon = $_REQUEST['idConcierto'];
	$evento = htmlspecialchars($_REQUEST['evento'], ENT_QUOTES, 'UTF-8');
	$lugar = htmlspecialchars($_REQUEST['lugar'], ENT_QUOTES, 'UTF-8');
	$fecha = $_REQUEST['fecha'];
	$fechareserva = $_REQUEST['fechareserva'];
	$fechapreserva = $_REQUEST['fechapreserva'];
	$fechapreventa = $_REQUEST['fechapreventa'];
	$hora = $_REQUEST['hora'];
	$img1 = $_REQUEST['img1'];
	$des = htmlspecialchars($_REQUEST['des'], ENT_QUOTES, 'UTF-8');
	$car = $_REQUEST['car'];
	$img = $_REQUEST['img'];
	$createby = $_SESSION['iduser'];
	$modifyby = $_SESSION['iduser'];
	$obsCambio = $_REQUEST['obscambio'];
	date_default_timezone_set("America/Guayaquil");
	$fechacreate = date('Y-m-d H:i:s');
	$fechamod = date('Y-m-d H:i:s');
	$modinsert = 'No modificado';
	$obsinsert = 'No modificado';
	$fechamodinsert = 'No modificado';
	$estado = 'A';
	$cosEnv2 = $_REQUEST['cosEnv2'];
	$tiempoPago = $_REQUEST['tiempoPago'];
	$dirCanje = htmlspecialchars($_REQUEST['dirCanje'], ENT_QUOTES, 'UTF-8');
	$horCanje = htmlspecialchars($_REQUEST['horCanje'], ENT_QUOTES, 'UTF-8');
	$fIniCanje = htmlspecialchars($_REQUEST['fIniCanje'], ENT_QUOTES, 'UTF-8');
	$fFinCanje = htmlspecialchars($_REQUEST['fFinCanje'], ENT_QUOTES, 'UTF-8');
	$cosEnv = $_REQUEST['cosEnv'];
	$porcTarj = htmlspecialchars($_REQUEST['porcTarj'], ENT_QUOTES, 'UTF-8');
	$estadoCon = $_REQUEST['estadoCon'];
	$mapaCon = $_REQUEST['mapaCon'];
	$mapaOpC = $_REQUEST['mapaOpC'];
	$strVideoC = $_REQUEST['strVideoC'];
	$autMun = $_REQUEST['autMun'];
	$disenio_ticket = $_REQUEST['disenio_ticket'];
	
	
	$lugPago = htmlspecialchars($_REQUEST['lugPago'], ENT_QUOTES, 'UTF-8');
	$dirPago = htmlspecialchars($_REQUEST['dirPago'], ENT_QUOTES, 'UTF-8');
	$fecPago = htmlspecialchars($_REQUEST['fecPago'], ENT_QUOTES, 'UTF-8');
	$horPago = htmlspecialchars($_REQUEST['horPago'], ENT_QUOTES, 'UTF-8');

	$docu = $_REQUEST['docu'];
	$desg = $_REQUEST['desg'];
	$municip = $_REQUEST['municip'];

	$sqlForCount = 'select count(id) as cuantos from desgl_docu where id_con = "'.$idcon.'" ';
	$resForCount = mysql_query($sqlForCount);
	$rowForCount = mysql_fetch_array($resForCount);
	$sqlForUpdate = '';

	if($rowForCount['cuantos'] == 0){
		$sqlForUpdate = 'INSERT INTO desgl_docu (id_con , docu , desg , municipio ) VALUES("'.$idcon.'" , "'.$docu.'" , "'.$desg.'" , "'.$municip.'")';
		$resForUpdate = mysql_query($sqlForUpdate) or die (mysql_error());
	}else{
		$sqlForUpdate = 'UPDATE desgl_docu SET docu = "'.$docu.'" , desg = "'.$desg.'"  , municipio = "'.$municip.'" where id_con = "'.$idcon.'" ';
		$resForUpdate = mysql_query($sqlForUpdate) or die (mysql_error());
	}
	
	$selectSocio = "SELECT idUser FROM Concierto WHERE idConcierto = '$idcon'";
	$resultSocio = mysql_query($selectSocio) or die (mysql_error());
	
	
	$row = mysql_fetch_array($resultSocio);
	$id_socio = $row['idUser'];
	$obscreacion = $_REQUEST['obscambio'];
	
	$insertloguser ='INSERT INTO logtributario VALUES (NULL, 
														"'.$fechaCreate.'", 
														"'.$createby.'", 
														"'.$id_socio.'", 
														"Update",
														"HHH",
														"'.$obscreacion.'", 
														"'.$obsCambio.'", 
														"KKK" ,
														"Activo")
					';
	$resultloguser = mysql_query($insertloguser) or die (mysql_error());
	
	if($img1 === 'img_conciertos/'){
		$sql = 'UPDATE Concierto SET 
				
				dateFecha = "'.$fecha.'" ,
				dateFechaReserva = "'.$fechareserva.'" ,
				dateFechaPReserva = "'.$fechapreserva.'" , 
				dateFechaPreventa = "'.$fechapreventa.'" ,
				strLugar = "'.$lugar.'" ,
				timeHora = "'.$hora.'" ,
				strEvento = "'.$evento.'" ,
				strImagen = "'.$img.'" ,
				strVideoC = "'.$strVideoC.'" ,
				strDescripcion = "'.$des.'" ,
				strCaractristica = "'.$car.'" ,
				tiempopagoC = "'.$tiempoPago.'" ,
				dircanjeC = "'.$dirCanje.'" ,
				horariocanjeC = "'.$horCanje.'" ,
				fechainiciocanjeC = "'.$fIniCanje.'" ,
				fechafinalcanjeC = "'.$fFinCanje.'" ,
				costoenvioC = "'.$cosEnv.'" ,
				porcentajetarjetaC = "'.$porcTarj.'" , 
				strMapaC = "'.$mapaCon.'" ,
				strMapaFill = "'.$mapaOpC.'" ,
				strEstado = "'.$estadoCon.'" ,
				autMun = "'.$autMun.'" ,
				locPago = "'.$lugPago.'" ,
				dirPago = "'.$dirPago.'" ,
				fecha = "'.$fecPago.'" ,
				hora = "'.$horPago.'" ,
				tipo_conc = "'.$tipoConcierto.'",
				envio = "'.$cosEnv2.'"
				
				WHERE idConcierto = "'.$idcon.'"';
				
				
				
				
		$res = mysql_query($sql)or die(mysql_error());
	}else{
		$sql = 'UPDATE Concierto SET dateFecha = "'.$fecha.'" ,
				dateFecha = "'.$fecha.'" ,
				dateFechaReserva = "'.$fechareserva.'" ,
				dateFechaPReserva = "'.$fechapreserva.'" , 
				dateFechaPreventa = "'.$fechapreventa.'" , 
				strLugar = "'.$lugar.'" , 
				timeHora = "'.$hora.'" , 
				strEvento = "'.$evento.'" ,
				strImagen = "'.$img1.'" , 
				strVideoC = "'.$strVideoC.'" ,
				strDescripcion = "'.$des.'" , 
				strCaractristica = "'.$car.'" ,
				tiempopagoC = "'.$tiempoPago.'" ,
				dircanjeC = "'.$dirCanje.'" ,
				horariocanjeC = "'.$horCanje.'" ,
				fechainiciocanjeC = "'.$fIniCanje.'" ,
				fechafinalcanjeC = "'.$fFinCanje.'" ,
				costoenvioC = "'.$cosEnv.'" ,
				porcentajetarjetaC = "'.$porcTarj.'" , 
				strMapaC = "'.$mapaCon.'" ,
				strMapaFill = "'.$mapaOpC.'" ,
				strEstado = "'.$estadoCon.'" ,
				autMun = "'.$autMun.'" ,
				locPago = "'.$lugPago.'" ,
				dirPago = "'.$dirPago.'" ,
				fecha = "'.$fecPago.'" ,
				hora = "'.$horPago.'" , 
				tipo_conc = "'.$tipoConcierto.'",
				envio = "'.$cosEnv2.'"
				
				WHERE idConcierto = "'.$idcon.'"';
		$res = mysql_query($sql)or die(mysql_error());
	}
	
	foreach(explode('@',$_POST['variables']) as $valor){
		$exVal = explode('|',$valor);
		$sqlart = '	
					UPDATE Artista SET strNombreA = "'.$exVal[0].'", 
					strFacebookA = "'.$exVal[1].'", 
					strTwitterA = "'.$exVal[2].'" , 
					strYoutubeA = "'.$exVal[3].'", 
					strInstagramA = "'.$exVal[4].'"
					WHERE idArtista = "'.$exVal[5].'" 
					';
		$resart = mysql_query($sqlart) or die (mysql_error());
	}
	if($_POST['newartista']!=''){
		foreach(explode('@',$_POST['newartista']) as $newart){
			$exArt = explode('|',$newart);
			if($exArt[0] != ''){
				$insertArt ='	INSERT INTO Artista VALUES (NULL,
															"'.$exArt[0].'", 
															"'.$exArt[1].'", 
															"'.$exArt[2].'", 
															"'.$exArt[3].'", 
															"'.$exArt[4].'", 
															"'.$idcon.'",
															"'.$createby.'", 
															"'.$fechacreate.'",
															"A")
							';
				
				$resultInsertArt = mysql_query($insertArt) or die (mysql_error());
			}
		}
	}
	//strCapacidadL = "'.$explodeValues[8].'",  linea 205
	foreach(explode('@',$_POST['valores']) as $value){
		$explodeValues = explode('|',$value);
		$sqlloc = '	UPDATE Localidad SET 
					strDescripcionL = "'.htmlspecialchars($explodeValues[0], ENT_QUOTES, 'UTF-8').'", 
					doublePrecioL  = "'.$explodeValues[1].'", 
					strDateStateL = "'.htmlspecialchars($explodeValues[2], ENT_QUOTES, 'UTF-8').'", 
					intPorcentajeReserva = "'.$explodeValues[3].'", 
					doublePrecioReserva = "'.$explodeValues[4].'", 
					intPorcentajePreventa = "'.$explodeValues[5].'", 
					doublePrecioPreventa = "'.$explodeValues[6].'", 
					
					strCaracteristicaL = "'.$explodeValues[9].'",
					puerta = "'.htmlspecialchars($explodeValues[10], ENT_QUOTES, 'UTF-8').'"
					
					WHERE idLocalidad = "'.$explodeValues[7].'" ';
		$resloc = mysql_query($sqlloc) or die(mysql_error());
	}
	// print_r($sqlloc);
	foreach(explode('@',$_POST['newlocal']) as $new){
		$exNew = explode('|',$new);
		if($exNew[0] != ''){
			$insertLoc = 'INSERT INTO Localidad VALUES (NULL, 
														"'.htmlspecialchars($exNew[0], ENT_QUOTES, 'UTF-8').'", 
														"'.$exNew[1].'", 
														"'.htmlspecialchars($exNew[2], ENT_QUOTES, 'UTF-8').'", 
														"'.$exNew[3].'" , 
														"'.$exNew[4].'",
														"'.$exNew[5].'",
														"'.$exNew[6].'", 
														"'.$exNew[7].'", 
														"'.$idcon.'", 
														"'.$exNew[8].'",
														"1", 
														"1",
														"'.$estado.'",
														"por hacer", 
														"No",
														"'.htmlspecialchars($exNew[9], ENT_QUOTES, 'UTF-8').'",
														"0",
														""
														)
							';
			$resultInsertLoc = mysql_query($insertLoc) or die (mysql_error());
		}
	}
	if($disenio_ticket != 0){
		$sqlDd = 'delete from diseno_concierto where id_concierto = "'.$idcon.'" ';
		$resDd = mysql_query($sqlDd) or die (mysql_error());
		
		
		$sqlId = 'insert into diseno_concierto (id_disenoticket , id_concierto) values ("'.$disenio_ticket.'" , "'.$idcon.'" )';
		$resId = mysql_query($sqlId) or die (mysql_error());
			
	}else{
		$sqlDd = 'delete from diseno_concierto where id_concierto = "'.$idcon.'" ';
		$resDd = mysql_query($sqlDd) or die (mysql_error());
	}
	echo $idcon;
?>