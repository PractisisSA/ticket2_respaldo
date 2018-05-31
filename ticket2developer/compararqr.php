<?php
	require('Conexion/conexion.php');
	$valboleto = $_REQUEST['boleto'];
	$valcedula = $_REQUEST['cedula'];
	$sql = "SELECT strCedula, strEstado, strQr FROM Boleto JOIN Cliente ON Boleto.idCli = Cliente.idCliente and strCedula = '$valcedula'";
	$res = $mysqli->query($sql) or die(mysqli_error());
	while ($row = mysqli_fetch_array($res)){
		$est= $row['strEstado'];
		$ced = $row['strCedula'];
		if ($est == 'A'){
			$sql2 = "SELECT strCedula, strEstado, strQr FROM Boleto JOIN Cliente ON Boleto.idCli = Cliente.idCliente AND strQr = '$valboleto' AND strCedula = '$valcedula'" or die(mysqli_error());
			$res2 = $mysqli->query($sql2);
			while($row2 = mysqli_fetch_array($res2)){
                $id = $row2['strQr'];
				$idc = $row2['strCedula'];
                if((!$id) && ($idc != $valcedula)){
                    echo 'error';
                }else{
                    echo 'ok';
					$sql1 = "UPDATE Boleto SET strEstado = 'I' WHERE strQr = '$valboleto'";
					$res1 = $mysqli->query($sql1) or die (mysqli_error());
                }
            }
		}elseif($est == 'I'){
			echo 'ya';
		}
	}
?>