<?php 
	$idcon = $_GET['con'];
	$estadoCon = 'Activo';
	$estadoLoc = 'A';
	$sqlcon = "SELECT * FROM Concierto WHERE idConcierto = '$idcon' AND strEstado = '$estadoCon'" or die(mysqli_error());
	$rescon = $mysqli->query($sqlcon);
	$row = mysqli_fetch_array($rescon);
	echo '<input type="hidden" id="mapa_opacity" value="'.$row['strMapaFill'].'" />';
	$selectPrecio = "SELECT strDescripcionL, doublePrecioL, idLocalidad FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto 
			WHERE dateFecha >= CURRENT_DATE AND idConc = '$idcon' AND strEstadoL = '$estadoLoc' ORDER BY dateFecha ASC" or die(mysqli_error($mysqli));
	$resPrecio = $mysqli->query($selectPrecio);
	$resultadoPrecio = mysqli_num_rows($resPrecio); 
	
	$selectReserva = "SELECT strDescripcionL, doublePrecioReserva, idLocalidad FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto 
				WHERE dateFechaReserva >= CURRENT_DATE AND idConc = '$idcon' AND strEstadoL = '$estadoLoc' ORDER BY dateFecha ASC"or die(mysqli_error());
	$resReserva = $mysqli->query($selectReserva);
	$resultadoReserva = mysqli_num_rows($resReserva);
	echo '<input type="hidden" id="num_rows_reserva" value="'.$resultadoReserva.'" />';
	
	$selectPreventa = "SELECT strDescripcionL, doublePrecioPreventa, idLocalidad FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto 
			WHERE dateFechaPreventa >= CURRENT_DATE AND idConc = '$idcon' AND strEstadoL = '$estadoLoc' ORDER BY dateFecha ASC" or die(mysqli_error($mysqli));
	$resPreventa = $mysqli->query($selectPreventa);
	$resultadoPreventa = mysqli_num_rows($resPreventa);
	echo '<input type="hidden" id="num_rows_preventa" value="'.$resultadoPreventa.'" />';

	$selectIdLocal = "SELECT idLocalidad FROM Localidad WHERE idConc = '$idcon' AND strEstadoL = '$estadoLoc'";
	$resultIdLocal = $mysqli->query($selectIdLocal);
	
	$selectDesLocal = "SELECT strDescripcionL FROM Localidad WHERE idConc = '$idcon' AND strEstadoL = '$estadoLoc'";
	$resultDes = $mysqli->query($selectDesLocal);
	$img = $row['strImagen'];
	$ruta = 'spadmin/';
	$r = $ruta.$img;
	$estadoArt = 'Activo';
	$sqlart = "SELECT * FROM Artista WHERE intIdConciertoA = '$idcon' AND strEstadoA = '$estadoArt'" or die(mysqli_error());
	$resart = $mysqli->query($sqlart);
	$estadoBut = 'A';
	$selectButaca = "SELECT * FROM Butaca WHERE intConcB = '$idcon' AND strEstado = '$estadoBut'" or die(mysqli_error($mysqli));
	$resultSelectButaca = $mysqli->query($selectButaca);
	$selectAreas = "SELECT strCoordenadasB, datestateL, datafullL, intLocalB, intConcB, idButaca FROM Butaca WHERE intConcB = '$idcon' AND strEstado = '$estadoBut'" or die(mysqli_error($mysqli));
	$resultSelectAreas = $mysqli->query($selectAreas);
	$selectId = "SELECT intAsientosB, idLocalidad, strImgL, strSecuencial FROM Butaca JOIN Localidad ON Butaca.intLocalB = Localidad.idLocalidad WHERE intConcB = '$idcon' AND strEstado = '$estadoBut'" or die(mysqli_error($mysqli));
	$resultId = $mysqli->query($selectId);
	
	
	$selectCronReserva = "SELECT dateFechaReserva, dateFechaPreventa, timeHora FROM Concierto WHERE idConcierto = '$idcon' AND strEstado = '$estadoCon'" or die(mysqli_error($mysqli));
	$resultCronReserva = $mysqli->query($selectCronReserva);
	$rowCronReserva = mysqli_fetch_array($resultCronReserva);
	$fechareserva = $rowCronReserva['dateFechaReserva'];
	$hora = $rowCronReserva['timeHora'];
	$fechapreventa = $rowCronReserva['dateFechaPreventa'];
?>