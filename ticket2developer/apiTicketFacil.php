<?php
	include('Conexion/conexion.php');
	$id = $_REQUEST['id']; 
	$codigo = $_REQUEST['codigo'];
	$documento = $_REQUEST['documento'];
	
	if($id == 10){
		$json ='{ "tabla": { "boletos" : ['	;
	
			$query = "SELECT * FROM Boleto" or die(mysqli_error($mysqli));
			$result = $mysqli->query($query);
			while($row = mysqli_fetch_array($result)){
				
				$id_bol = $row['idBoleto'];
				$strQr = htmlentities($row['strQr']);
				$strBarcode = htmlentities($row['strBarcode']);
				$id_cli = $row['idCli'];
				$id_con = $row['idCon'];
				$id_loc = $row['idLocB'];
				$stado = $row['strEstado'];
				$json .= '{ "idBoleto" : "'.$id_bol.'" ,"QR" : "'.$strQr.'" , "Barras" : "'.$strBarcode.'"  , "idCliente" : "'.$id_cli.'" , "idConcierto" : "'.$id_con.'" , "idLocal" : "'.$id_loc.'", "Estado" : "'.$stado.'"},';
			}
			$json=substr($json,0,-1);
		
		$json.=' ]}}';
		echo $json;
	}
	
	if($id == 20){
		
		$json ='{ "tabla": { "boletos" : ['	;
			$query = "SELECT idBoleto, strQr, strBarcode, idCli, idCon, idLocB, nombreHISB, documentoHISB, strEstado, strDescripcionL FROM Boleto JOIN Localidad ON Boleto.idLocB = Localidad.idLocalidad WHERE (strQR = '$codigo' OR strBarcode = '$codigo') AND documentoHISB = '$documento'" or die(mysqli_error($mysqli));
			$result = $mysqli->query($query);
			while($row = mysqli_fetch_array($result)){
				
				$id_bol = $row['idBoleto'];
				$strQr = htmlentities($row['strQr']);
				$strBarcode = htmlentities($row['strBarcode']);
				$id_cli = $row['idCli'];
				$id_con = $row['idCon'];
				$id_loc = $row['idLocB'];
				$stado = $row['strEstado'];
				$nombre = $row['nombreHISB'];
				$doc = $row['documentoHISB'];
				$localidad = $row['strDescripcionL'];
				$json .= '{ "idBoleto" : "'.$id_bol.'" ,"QR" : "'.$strQr.'" , "Barras" : "'.$strBarcode.'"  , "idCliente" : "'.$id_cli.'" , "idConcierto" : "'.$id_con.'" , "idLocal" : "'.$id_loc.'", "Estado" : "'.$stado.'", "Nombre" : "'.$nombre.'", "Documento" : "'.$doc.'", "Localidad" : "'.$localidad.'"},';
				$update = "UPDATE Boleto SET strEstado = 'I' WHERE idBoleto = '$id_bol'" or die(mysqli_error($mysqli));
				$resultupd = $mysqli->query($update);
			}
			$json=substr($json,0,-1);
		$json.=' ]}}';
		echo $json;
	}
?>