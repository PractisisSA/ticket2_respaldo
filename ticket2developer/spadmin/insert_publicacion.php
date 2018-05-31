<?php
	// print_r($_POST);
	include("../controlusuarios/seguridadSA.php");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$id_socio = $_POST['id_socio'];
	$evento = $_POST['evento'];
	$lugar = $_POST['lugar'];
	$pre_img_evento = $_POST['imagen'];
	$imagen_evento = $pre_img_evento;
	$descripcion = $_POST['des'];
	$video = $_POST['video'];
	$fecha = $_POST['f_evento'];
	$hora = $_POST['hora'];
	$genero = $_POST['caracteristica'];
	$cant_artistas = $_POST['num_artistas'];
	$link_compra = $_POST['link_compra'];
	
	$tipoConcierto = '';
	$fecha_reserva = date("Y-m-d");  
	$fecha_preserva = date("Y-m-d");  
	$fecha_preventa = date("Y-m-d");  
	$pre_mapa_evento = $imagen_evento;
	$pre_mapa_evento_opc = $imagen_evento;
	$mapa_evento = 'mapas/'.$$imagen_evento;;
	$mapa_evento_opc = 'mapas/'.$$imagen_evento;;
	$obscreacion = 'pruebas';
	$tiempopago = date("H:i:s");
	$dircanje = 'pruebas';
	$horariocanje = date("H:i:s");;
	$iniciocanje = 'pruebas';
	$finalcanje = date("H:i:s");;
	$costoenvio = 0;
	$porcentajetarjeta = 0;
	$createby = $_SESSION['iduser'];
	$fechaCreate = date('Y-m-d H:i:s');
	$autSri = 0;
	$autMun =0;
	
	$lugPago = 'pruebas';
	$dirPago = 'pruebas';
	$fecPago = 'pruebas';
	$horPago = 'pruebas';
	
	try{
		$insertConcert = "INSERT INTO Concierto VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ? , ? , ?, ? , ? , ? , ? , ?, ? , ? , ? , ? )";
		$resultInsertConcert = $gbd -> prepare($insertConcert);
		$resultInsertConcert -> execute(array('NULL',$fecha,$fecha_reserva,$fecha_preserva,$fecha_preventa,$lugar,$hora,$evento,$imagen_evento,$video,$descripcion,$genero,$cant_artistas,$tiempopago,$link_compra,$horariocanje,$iniciocanje,$finalcanje,$costoenvio,$porcentajetarjeta,$mapa_evento,$mapa_evento_opc ,$id_socio,$createby,$fechaCreate,'Activo',$autSri,$autMun,$lugPago,$dirPago,$fecPago,$horPago,$tipoConcierto , 2 , "" , "" , "" , ""));
		$id_concierto = $gbd -> lastInsertId();
	}catch(PDOException $e){
		print_r($e);
	}
	
	foreach(explode('@', $_POST['valores_artista']) as $valor_artista){
		$explodeArtista = explode('|', $valor_artista);
		try{
			$insertArtista = "INSERT INTO Artista VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$resultInsertArtista = $gbd -> prepare($insertArtista);
			$resultInsertArtista -> execute(array('NULL',$explodeArtista[0],$explodeArtista[1],$explodeArtista[2],$explodeArtista[3],$explodeArtista[4],$id_concierto,$createby,$fechaCreate,'Activo'));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	
	
	echo $id_concierto;
?>