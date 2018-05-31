<?php
	header("Access-Control-Allow-Origin: *");
	require('Conexion/conexion.php');
	$codigo = $_REQUEST['codigo'];
	$estado = 'A';
	$selectQr = "SELECT idBoleto, strQr, strBarcode FROM Boleto WHERE strQr = '$codigo' OR strBarcode = '$codigo'" or die(mysqli_error());
	$resultSelectQr = $mysqli->query($selectQr);
	$rowQr = mysqli_fetch_array($resultSelectQr);
	$resultado = mysqli_num_rows($resultSelectQr);
	$qr = $rowQr['strQr'];
	$bar = $rowQr['strBarcode'];
	$id = $rowQr['idBoleto'];
	if($resultado == 0){
		echo'Boleto Incorrecto';
	}else{
		$selectCod = "SELECT strEstado FROM Boleto WHERE strQr = '$codigo' OR strBarcode = '$codigo' " or die(mysqli_error());
		$resultSelectCod = $mysqli->query($selectCod);
		$rowCod = mysqli_fetch_array($resultSelectCod);
		$estBase = $rowCod['strEstado'];
		if($estBase === $estado){
			$updateCodigo = "UPDATE Boleto SET strEstado = 'I' WHERE idBoleto = '$id' OR strBarcode = '$codigo'" or die(mysqli_error());
			$resultUpdateCod = $mysqli->query($updateCodigo);
			echo'Boleto Valido';
		}else if($estBase == 'I'){
			echo 'Boleto Ya Usado';
		}
	}
	
?>