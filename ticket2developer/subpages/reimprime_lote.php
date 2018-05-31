<?php
	session_start();
	include '../../conexion.php';
	
	
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	// echo 'hola';
	
	
	$servicesFormatted = $_REQUEST['servicesFormatted'];
	$distribuidor = $_REQUEST['distribuidor'];
	$exp = explode("@",$servicesFormatted);
	// echo $distribuidor;
	
	// echo $_SESSION['perfil'];
	
	
	if($_SESSION['perfil'] == 'SP'){
		$sqlU = ' select idUsuario from Usuario where strObsCreacion = "'.$distribuidor.'" ';
		
		// echo $sqlU."<br>";
		$resU = mysql_query($sqlU) or die (mysql_error());
		$rowU = mysql_fetch_array($resU);
		$usuVenta = $rowU['idUsuario'];
	}else{
		$usuVenta = $_SESSION['iduser'];
	}
	
	// echo $usuVenta;
	
	function hexadecimalAzar($caracteres){

		$caracteresPosibles = "01234567890987654321";
		$azar = '';

		for($i=0; $i<$caracteres; $i++){

			$azar .= $caracteresPosibles[rand(0,strlen($caracteresPosibles)-1)];

		}

		return $azar;

	}
	
	
	
	for ($y=0;$y<count($exp);$y++) {
		
		$nuevoBarcode = hexadecimalAzar(13);
		
		$sqlB = 'select strBarcode , idLocB , idCon from Boleto where idBoleto = "'.$exp[$y].'" ';
		$resB = mysql_query($sqlB) or die (mysql_error());
		$rowB = mysql_fetch_array($resB);
		
		$id_loc = $rowB['idLocB'];
		$idCon = $rowB['idCon'];
		$strBarcode = $rowB['strBarcode'];
		
		$sqlCb = 
			'	insert into codigo_barras (id_con , codigo , estado , utilizado , id_loc ) 
				values ("'.$idCon.'","'.$nuevoBarcode.'","A","1","'.$id_loc.'" ) 
			';
		$resCb = mysql_query($sqlCb) or die(mysql_error());
		
		$sqlB2 = 'update Boleto set strBarcode = "'.$nuevoBarcode.'" where idBoleto = "'.$exp[$y].'" ';
		$resB2 = mysql_query($sqlB2) or die (mysql_error());
	
	// echo $sqlB2."<br>";
		// echo $sqlCb."<br><br>";
		
		
		
		$sql = 'update transaccion_distribuidor set impresion_local = "3" where numboletos = "'.$exp[$y].'" ';
		// echo $sql."<br>";
		$res = mysql_query($sql) or die(mysql_error());
		
		
		
		$sql2 = 'INSERT INTO `reimpresio_boleto` (`id`, `id_con` ,`barcode` , iduser) VALUES (NULL, "" , "'.$exp[$y].'" , "'.$usuVenta.'")';
			// echo $sql2."<br>";
			$res2 = mysql_query($sql2) or die(mysql_error());
			
			/*$sqlB3 = 'update Boleto set strQr = "'.$strBarcode.'" where idBoleto = "'.$exp[$y].'" ';
			$resB3 = mysql_query($sqlB3) or die (mysql_error());*/
			
			
			$sqlB31 = 'update codigo_barras set estado = "ANU" where codigo = "'.$strBarcode.'" ';
			// echo $sqlB31."<br>";
			$resB31 = mysql_query($sqlB31) or die (mysql_error());
		
			// echo $sqlB3."<br>";
		
	}
	echo 'espere en un momento se reimprimiran sus tickets';
?>