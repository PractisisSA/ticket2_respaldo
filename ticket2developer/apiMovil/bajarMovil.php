<?php 
	header("Access-Control-Allow-Origin: *");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$sql2 = "SELECT * FROM Boleto";
	$stmt2 = $gbd -> prepare($sql2);
	$stmt2 -> execute();
	
	$json = '{"Boletos":[';
	while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
		$idBoleto = $row2['idBoleto'];
		$qr = $row2['strQr'];
		$barcode = $row2['strBarcode'];
		$cliente = $row2['idCli'];
		$concierto = $row2['idCon'];
		$local = $row2['idLocB'];
		$nombre = $row2['nombreHISB'];
		$cedula = $row2['documentoHISB'];
		$estado = $row2['strEstado'];
		$json .= '{ 
			"idBoleto" : "'.$idBoleto.'", 
			"qr" : "'.$qr.'" , 
			"barcode" : "'.$barcode.'", 
			"cliente" : "'.$cliente.'", 
			"concierto" : "'.$concierto.'", 
			"local" : "'.$local.'",
			"nombre" : "'.$nombre.'",
			"cedula" : "'.$cedula.'",
			"estado" : "'.$estado.'" 
		},';
	}
	$json=substr($json,0,-1);
	$json.=' ]}';
	echo $json;
?>