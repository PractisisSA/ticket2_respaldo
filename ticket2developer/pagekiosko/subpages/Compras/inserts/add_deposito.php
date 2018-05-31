<?php
	require('../../../Conexion/conexion.php');
	$ndepo = $_POST['ndep'];
	$fecha = $_POST['fecha'];
	$est ="Si";
	foreach(explode('@',$_POST['valor']) as $val){
		$exVal = explode('|',$val);
		$query = "UPDATE Deposito SET intNumero = '$ndepo', dateFechaD = '$fecha', strDepositoD = '$est' WHERE idDeposito = '$val'" or die(mysqli_error());
		$result = $mysqli->query($query);
	}
?>
