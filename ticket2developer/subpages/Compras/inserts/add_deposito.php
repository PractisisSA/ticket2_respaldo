<?php
	// require('../../../Conexion/conexion.php');
	// $ndepo = $_POST['ndep'];
	// $fecha = $_POST['fecha'];
	// 
	// foreach(explode('@',$_POST['valor']) as $val){
		// $exVal = explode('|',$val);
		// $query = "UPDATE Deposito SET intNumero = '$ndepo', dateFechaD = '$fecha', strDepositoD = '$est' WHERE idDeposito = '$val'" or die(mysqli_error());
		// $result = $mysqli->query($query);
	// }
	
	include '../../../conexion.php';
	
	
	$est ="Si";
	$ndep = $_REQUEST['ndep'];
	$fecha = $_REQUEST['fecha'];
	$intDeposito = $_REQUEST['intDeposito'];
	$idDeposito = $_REQUEST['idDeposito'];

	
	$sqlD = 'UPDATE Deposito SET intNumero = "'.$ndep.'", dateFechaD = "'.$fecha.'", strDepositoD = "'.$est.'" WHERE idFactura = "'.$intDeposito.'" ';
	$resD = mysql_query($sqlD) or die (mysql_error());
	
	$sqlSelect = "SELECT * FROM factura WHERE tipo = 1 AND ndepo = '".$ndep."'";
	$resSelect = mysql_query($sqlSelect);
	$rowSelect = mysql_fetch_array($resSelect);

	if (empty($rowSelect)) { 
	    $sqlFa = 'UPDATE factura SET ndepo = "'.$ndep.'" , fecha = "'.$fecha.'" , estado = "'.$est.'" WHERE id = "'.$intDeposito.'"';
		$resFa = mysql_query($sqlFa) or die (mysql_error());
		
		$sql1 = '';
		if ($resFa) {
		 	echo 2;
		}else{
			echo 3;
		}
	}else {
	    echo 1;
	}

?>
