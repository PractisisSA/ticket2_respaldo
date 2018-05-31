<?php
	require('../../../Conexion/conexion.php');
	$ndepo = $_POST['ndep'];
	$fecha = $_POST['fecha'];
	$estRevision = "Revisar";
	$estDeposito ="No";
	$numbol = 1;
	$precio = $_POST['valReserva'];
	$codigo = $_GET['con'];
	
	$selectDatos = "SELECT idClienteR, idConciertoR, idLocalidadR, intFilaR, intColumnaR FROM Reserva 
					WHERE intIdentificateR = '$codigo' AND strEstadoR = 'No' AND pagoDepR = 'No'" or die(mysqli_error($mysqli));
	$resultDatos = $mysqli->query($selectDatos);
	
	while($rowDatos = mysqli_fetch_array($resultDatos)){
		$insertDepReserva = "INSERT INTO DepositoReserva VALUES (NULL, '$ndepo', '$fecha', '".$rowDatos['intFilaR']."', '".$rowDatos['intColumnaR']."', 
							'".$rowDatos['idClienteR']."', '".$rowDatos['idConciertoR']."', '".$rowDatos['idLocalidadR']."', '$precio', '$codigo', 
							'$numbol', '$estRevision', '$estDeposito', NULL)" or die(mysqli_error($mysqli));
		$resultInsertDep = $mysqli->query($mysqli);
	}
	
	$updateReserva = "UPDATE Reserva SET strEstadoR = 'Deposito', pagoDepR = 'ok' WHERE intIdentificateR = '$codigo'" or die(mysqli_error($mysqli));
	$resultUpdReserva = $mysqli->query($updateReserva);
	
	header("Location: ../../../?modulo=PayDepok");
?>