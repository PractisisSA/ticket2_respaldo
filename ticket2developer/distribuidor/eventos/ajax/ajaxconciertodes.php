<?php 
	date_default_timezone_set('America/Guayaquil');
	// include("../../controlusuarios/seguridadSP.php");
	
	$idcon = $_GET['evento'];
	$estadoCon = 'Activo';
	$estadoLoc = 'A';
	//Consulta para obtener todos los datos del concierto
	$sqlcon = "SELECT * FROM Concierto WHERE idConcierto = ? AND strEstado = ?";
	$sqlc = $gbd -> prepare($sqlcon);
	$sqlc -> execute(array($idcon,$estadoCon));
	$row = $sqlc -> fetch(PDO::FETCH_ASSOC);
	echo '<input type="hidden" id="mapa_opacity" value="'.$row['strMapaFill'].'" />';
	
	//consulta para obtener el precio normal de los tickets comparando con la fecha
	$selectPrecio = "SELECT strDescripcionL, doublePrecioL, idLocalidad FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto 
			WHERE dateFecha >= CURRENT_DATE AND idConc = ? AND strEstadoL = ? ORDER BY dateFecha ASC";
	$sltprecio = $gbd -> prepare($selectPrecio);
	$sltprecio -> execute(array($idcon,$estadoLoc));
	$resultadoPrecio = $sltprecio -> rowCount(); 
	
	//consulta para obtener el precio de reserva de los tickets comparando con la fecha
	$selectReserva = "SELECT strDescripcionL, doublePrecioReserva, idLocalidad FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto 
				WHERE dateFechaReserva >= CURRENT_DATE AND idConc = ? AND strEstadoL = ? ORDER BY dateFecha ASC";
	$sltreserva = $gbd -> prepare($selectReserva);
	$sltreserva -> execute(array($idcon,$estadoLoc));
	$resultadoReserva = $sltreserva -> rowCount();
	echo '<input type="hidden" id="num_rows_reserva" value="'.$resultadoReserva.'" />';
	
	//consulta para obtener el precio de preventa de los tickets comparando con la fecha
	$selectPreventa = "SELECT strDescripcionL, doublePrecioPreventa, idLocalidad FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto 
			WHERE dateFechaPreventa >= CURRENT_DATE AND idConc = ? AND strEstadoL = ? ORDER BY dateFecha ASC";
	$sltpreventa = $gbd -> prepare($selectPreventa);
	$sltpreventa -> execute(array($idcon,$estadoLoc));
	$resultadoPreventa = $sltpreventa -> rowCount();
	echo '<input type="hidden" id="num_rows_preventa" value="'.$resultadoPreventa.'" />';
	
	if($resultadoPreventa == 0){
		$colst = 'col-xs-5';
		$colsn = 'col-xs-5';
		$colsp = 'col-xs-0';
		$colsm = 'col-xs-2';
	}else{
		$colst = 'col-xs-3';
		$colsn = 'col-xs-3';
		$colsp = 'col-xs-3';
		$colsm = 'col-xs-3';
	}
	
	//obtengo el id de todas las localidades
	$selectIdLocal = "SELECT idLocalidad FROM Localidad WHERE idConc = ? AND strEstadoL = ?";
	$sltidlocal = $gbd -> prepare($selectIdLocal);
	$sltidlocal -> execute(array($idcon,$estadoLoc));
	
	//datos para los elementos del mapa
	$query6 = "SELECT idLocalidad FROM Localidad WHERE idConc = ? AND strEstadoL = ?";
	$stmt6 = $gbd -> prepare($query6);
	$stmt6 -> execute(array($idcon,$estadoLoc));
	
	//datos para botones
	$query7 = "SELECT idLocalidad FROM Localidad WHERE idConc = ? AND strEstadoL = ?";
	$stmt7= $gbd -> prepare($query7);
	$stmt7 -> execute(array($idcon,$estadoLoc));
	
	//selecciono las descripciones de las localidades
	$selectDesLocal = "SELECT idLocalidad, strDescripcionL FROM Localidad WHERE idConc = ? AND strEstadoL = ? and fechaCreacionL > 0";
	$sltdeslocal = $gbd -> prepare($selectDesLocal);
	$sltdeslocal -> execute(array($idcon,$estadoLoc));
	
	//concateno el path de la carpeta de origen para mostrar la imagen
	$img = $row['strImagen'];
	$ruta = 'spadmin/';
	$r = $ruta.$img;
	
	//Selecciono los artistas dependiendo el concierto
	$estadoArt = 'Activo';
	$sqlart = "SELECT * FROM Artista WHERE intIdConciertoA = ? AND strEstadoA = ?";
	$resart = $gbd -> prepare($sqlart);
	$resart -> execute(array($idcon,$estadoArt));
	
	//Selecciono las butacas dependiendo del concierto
	$estadoBut = 'A';
	$selectButaca = "SELECT * FROM Butaca WHERE intConcB = ? AND strEstado = ?" or die(mysqli_error($mysqli));
	$resultSelectButaca = $gbd -> prepare($selectButaca);
	$resultSelectButaca -> execute(array($idcon,$estadoBut));
	
	//Select para obtener las areas de cada localidad
	$selectAreas = 'SELECT strCoordenadasB, datestateL, datafullL, intLocalB, intConcB, idButaca FROM Butaca WHERE intConcB = "'.$idcon.'" AND strEstado = "'.$estadoBut.'" and fechaCreacionB > 0';
	
	
	$resultSelectAreas = $gbd -> prepare($selectAreas);
	$resultSelectAreas -> execute();
	
	//select id por localidades de las areas 
	$selectId = "SELECT intAsientosB, idLocalidad, strImgL, strSecuencial FROM Butaca JOIN Localidad ON Butaca.intLocalB = Localidad.idLocalidad WHERE intConcB = ? AND strEstado = ?";
	$resultId = $gbd -> prepare($selectId);
	$resultId -> execute(array($idcon,$estadoBut));
	
	
	$selectCronReserva = "SELECT dateFechaReserva, dateFechaPreventa, timeHora FROM Concierto WHERE idConcierto = ? AND strEstado = ?";
	$resultCronReserva = $gbd -> prepare($selectCronReserva);
	$resultCronReserva -> execute(array($idcon,$estadoCon));
	$rowCronReserva = $resultCronReserva -> fetch(PDO::FETCH_ASSOC);
	$fechareserva = $rowCronReserva['dateFechaReserva'];
	$hora = $rowCronReserva['timeHora'];
	$fechapreventa = $rowCronReserva['dateFechaPreventa'];
	
	$time = time();
	$fecha1 = new DateTime(date("Y-m-d H:i:s",$time));
	$fecha2 = new DateTime($fechareserva.' '.$hora);
	$fecha = $fecha1->diff($fecha2);
	
	echo '<input type="hidden" id="segundos" value="'.$fecha->s.'" />';
	echo '<input type="hidden" id="minutos" value="'.$fecha->i.'" />';
	echo '<input type="hidden" id="horas" value="'.$fecha->h.'" />';
	echo '<input type="hidden" id="dias" value="'.$fecha->d.'" />';
	
	$fecha3 = new DateTime(date("Y-m-d H:i:s",$time));
	$fecha4 = new DateTime($fechapreventa.' '.$hora);
	$fechap = $fecha3->diff($fecha4);
	
	echo '<input type="hidden" id="segundosventa" value="'.$fechap->s.'" />';
	echo '<input type="hidden" id="minutosventa" value="'.$fechap->i.'" />';
	echo '<input type="hidden" id="horasventa" value="'.$fechap->h.'" />';
	echo '<input type="hidden" id="diasventa" value="'.$fechap->d.'" />';
	
	echo '<input type="hidden" id="data" value="3" />';
	
	//consulta para seleccion aleatoria de asientos
	$aleatorio = "SELECT * FROM Localidad WHERE idConc = ? AND strEstadoL = ? and fechaCreacionL > 0";
	$ale = $gbd -> prepare($aleatorio);
	$ale -> execute(array($idcon,$estadoLoc));
?>