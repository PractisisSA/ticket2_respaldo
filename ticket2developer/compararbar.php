<?php
	require('Conexion/conexion.php');
	$boletobar = $_REQUEST['boletob'];
	$cedulabar = $_REQUEST['cedulab'];
	$sql = "SELECT strDocumentoC, strEstado, strBarcode FROM Boleto JOIN Cliente ON Boleto.idCli = Cliente.idCliente AND strDocumentoC = '$cedulabar'";
	//echo $sql;
	$res = $mysqli->query($sql) or die(mysqli_error());
	while ($row = mysqli_fetch_array($res)){
		$est= $row['strEstado'];
		$ced = $row['strDocumentoC'];
		if ($est == 'A'){
			$sql2 = ("SELECT strDocumentoC, strEstado, strBarcode FROM Boleto JOIN Cliente ON Boleto.idCli = Cliente.idCliente AND strBarcode = '$boletobar' AND strDocumentoC = '$cedulabar'")or die(mysqli_error());
			$res2 = $mysqli->query($sql2);
			while($row2 = mysqli_fetch_array($res2)){
                $id = $row2['strBarcode'];
				$idc = $row2['strDocumentoC'];
                if((!$id) && ($idc != $cedulabar)){
                    echo 'error';
                }else{
                    echo 'ok';
					$sql1 = "UPDATE Boleto SET strEstado = 'I' WHERE strBarcode = '$boletobar'";
					$res1 = $mysqli->query($sql1) or die (mysqli_error());
                }
            }
		}elseif($est == 'I'){
			echo 'ya';
		}
	}
?>