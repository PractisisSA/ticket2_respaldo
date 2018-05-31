<?php
	// print_r($_REQUEST);
	//include("../controlusuarios/seguridadSA.php");
	
	
	ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$id_socio = $_REQUEST['id_socio'];
	$tipoConcierto = $_REQUEST['tipoConcierto'];
	$disenio_ticket = $_REQUEST['disenio_ticket'];
	// echo 'hola'.$disenio_ticket;

	// exit;

	$evento = htmlspecialchars($_REQUEST['nombre_evento'], ENT_QUOTES, 'UTF-8');
	$lugar = htmlspecialchars($_REQUEST['lugar_evento'], ENT_QUOTES, 'UTF-8');
	$fecha = $_REQUEST['fecha_evento'];
	$fecha_reserva = $_REQUEST['fecha_reserva'];
	$fecha_preserva = $_REQUEST['fecha_preserva'];
	$fecha_preventa = $_REQUEST['fecha_preventa'];
	$hora = $_REQUEST['hora_evento'];
	$pre_img_evento = $_REQUEST['imagen_evento'];
	$imagen_evento = $pre_img_evento;
	$video = $_REQUEST['video_evento'];
	$descripcion = htmlspecialchars($_REQUEST['descripcion_evento'], ENT_QUOTES, 'UTF-8');
	$genero = htmlspecialchars($_REQUEST['genero_evento'], ENT_QUOTES, 'UTF-8');
	$cant_artistas = $_REQUEST['cant_artistas'];
	$pre_mapa_evento = $_REQUEST['img_map_con'];
	$pre_mapa_evento_opc = $_REQUEST['img_map_con_opc'];
	$docu = $_REQUEST['docu'];
	$desg = $_REQUEST['desg'];
	$mapa_evento = 'mapas/'.$pre_mapa_evento;
	$mapa_evento_opc = 'mapas/'.$pre_mapa_evento_opc;
	
	$obscreacion = htmlspecialchars($_REQUEST['obscreacion'], ENT_QUOTES, 'UTF-8');
	$tiempopago = $_REQUEST['tiempopago'];
	$dircanje = htmlspecialchars($_REQUEST['dircanje'], ENT_QUOTES, 'UTF-8');
	$horariocanje = htmlspecialchars($_REQUEST['horariocanje'], ENT_QUOTES, 'UTF-8');
	$iniciocanje = htmlspecialchars($_REQUEST['iniciocanje'], ENT_QUOTES, 'UTF-8');
	$finalcanje = htmlspecialchars($_REQUEST['finalcanje'], ENT_QUOTES, 'UTF-8');
	$costoenvio = $_REQUEST['costoenvio'];
	$porcentajetarjeta = $_REQUEST['porcentajetarjeta'];
	$createby = 3;//$_SESSION['iduser'];
	$fechaCreate = '00:00:00';//date('Y-m-d H:i:s');
	$autSri = $_REQUEST['autSri'];
	$autMun = $_REQUEST['autMun'];
	
	$lugPago = htmlspecialchars($_REQUEST['lugPago'], ENT_QUOTES, 'UTF-8');
	$dirPago = htmlspecialchars($_REQUEST['dirPago'], ENT_QUOTES, 'UTF-8');
	$fecPago = htmlspecialchars($_REQUEST['fecPago'], ENT_QUOTES, 'UTF-8');
	$horPago = htmlspecialchars($_REQUEST['horPago'], ENT_QUOTES, 'UTF-8');
	$cosEnv2 = $_REQUEST['cosEnv2'];
	
	
	$valores_comi = $_REQUEST['valores_comiFormateado'];

    $porcpaypal =(float) $_REQUEST['porcpaypal'];
	$valpaypal =(float) $_REQUEST['valpaypal'];
	$porcstripe =(float) $_REQUEST['porcstripe'];
	$valstripe =(float) $_REQUEST['valstripe'];

	
	try{
		$insertConcert = "INSERT INTO Concierto VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ? , ? , ? , ? , ? , ? , ? , ? , ? )";
		$resultInsertConcert = $gbd -> prepare($insertConcert);
		$resultInsertConcert -> execute(array('NULL',$fecha,$fecha_reserva,$fecha_preserva,$fecha_preventa,$lugar,$hora,$evento,$imagen_evento,$video,$descripcion,$genero,$cant_artistas,$tiempopago,$dircanje,$horariocanje,$iniciocanje,$finalcanje,$costoenvio,$porcentajetarjeta,$mapa_evento,$mapa_evento_opc ,$id_socio,$createby,$fechaCreate,'Activo',$autSri,$autMun,$lugPago,$dirPago,$fecPago,$horPago,$tipoConcierto,'1','','','','',$cosEnv2,$porcpaypal,$valpaypal,$porcstripe,$valstripe,'0','0'));
		$id_concierto = $gbd -> lastInsertId();
	}catch(PDOException $e){
		print_r($e);
	}
	echo $id_concierto;
	
	include '../conexion.php';
	$sqlId = 'insert into diseno_concierto (id_disenoticket , id_concierto) values ("'.$disenio_ticket.'" , "'.$id_concierto.'" )';
	
	// echo $sqlId; 
	$resId = mysql_query($sqlId) or die (mysql_error());
	
	foreach(explode('@', $_REQUEST['valores_artista']) as $valor_artista){
		$explodeArtista = explode('|', $valor_artista);
		try{
			$insertArtista = "INSERT INTO Artista VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$resultInsertArtista = $gbd -> prepare($insertArtista);
			$resultInsertArtista -> execute(array('NULL',$explodeArtista[0],$explodeArtista[1],$explodeArtista[2],$explodeArtista[3],$explodeArtista[4],$id_concierto,$createby,$fechaCreate,'Activo'));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	
	foreach(explode('@', $_REQUEST['valores_localidad']) as $valor_localidad){
		try{
			$explodeLocal = explode('|', $valor_localidad);
			if($explodeLocal[8] == 'Asientos numerados'){
				$estadoLoc = 'no';
			}elseif($explodeLocal[8] == 'Asientos no numerados'){
				$estadoLoc = 'no';
			}
			$insertLocalidad = "INSERT INTO Localidad VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?, ?, ? )";
			$resultInsertLocalidad = $gbd -> prepare($insertLocalidad);
			$resultInsertLocalidad -> execute(array('NULL',$explodeLocal[0],$explodeLocal[1],$explodeLocal[2],$explodeLocal[3],$explodeLocal[4],$explodeLocal[5],$explodeLocal[6],$explodeLocal[7],$id_concierto,$explodeLocal[8],$createby,$fechaCreate,'A','por hacer',$estadoLoc , $explodeLocal[9] , 0 , ''));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	
	include '../conexion.php';
	foreach(explode('|',$valores_comi) as $valores){
		if($valores!=''){
			$cadaValor = explode('@',$valores);
			$id_comi_tar = $cadaValor[0];
			if($id_comi_tar == 0){
				$txtComTar = 'cadena comercial';
			}
			if($id_comi_tar == 1){
				$txtComTar = 'PUNTOS TICKET FACIL';
			}
			if($id_comi_tar == 2){
				$txtComTar = 'PAGINA WEB';
			}
			$comi_tar = $cadaValor[1];
			$ret_iva = $cadaValor[2];
			$ret_renta = $cadaValor[3];
			$des_ter_edad = $cadaValor[4];
			$comi_venta = $cadaValor[5];
			$comi_cobro = $cadaValor[6];
			$sql = 'INSERT INTO `comi_ret` (`id`, `id_con`, `detalle`, `comi_tar`, `ret_iva`, `ret_renta`, `des_ter_edad`, `comi_venta`, `comi_cobro`) 
					VALUES (NULL, "'.$id_concierto.'", "'.$txtComTar.'", "'.$comi_tar.'", "'.$ret_iva.'", "'.$ret_renta.'", "'.$des_ter_edad.'", "'.$comi_venta.'", "'.$comi_cobro.'")';
			//echo $sql."<br/>";
			$res = mysql_query($sql) or die (mysql_error());
			
		}
		
	}
	$sqlDe = 'INSERT INTO `desgl_docu` (`id`, `id_con`, `docu`, `desg`) VALUES (NULL, "'.$id_concierto.'", "'.$docu.'", "'.$desg.'")';
	$res = mysql_fetch_array($sqlDe) or die (mysql_error());
	
	
	
?>