<?php
	session_start();
	include '../conexion.php';
	$id = $_REQUEST['id'];
	
	
	$sqlB = 'select strBarcode, serie, idLocB , idCon from Boleto where idBoleto = "'.$id.'" ';
	$resB = mysql_query($sqlB) or die (mysql_error());
	$rowB = mysql_fetch_array($resB);
	
	$id_loc = $rowB['idLocB'];
	$idCon = $rowB['idCon'];
	$strBarcode = $rowB['strBarcode'];
	
	$sqlConc = 'SELECT * FROM Concierto WHERE idConcierto = '.$idCon.'';
	$resConc = mysql_query($sqlConc);
	$aut = '';
	$codestablecimientoAHIS = '';
	$serieemisionA = '';
	while ($rowConc = mysql_fetch_array($resConc)) {
		$tiene_permisos = $rowConc['tiene_permisos'];
		$sqlAut = 'select * from autorizaciones where idAutorizacion = "'.$tiene_permisos.'" ';
		$resAut = mysql_query($sqlAut) or die (mysql_error());
		$rowAut = mysql_fetch_array($resAut);
		$codestablecimientoAHIS = $rowAut['codestablecimientoAHIS'];
		$serieemisionA = $rowAut['serieemisionA'];
	}

	function hexadecimalAzar($caracteres){

		$caracteresPosibles = "01234567890987654321";
		$azar = '';

		for($i=0; $i<$caracteres; $i++){

			$azar .= $caracteresPosibles[rand(0,strlen($caracteresPosibles)-1)];

		}

		return $azar;

	}
	
	
	$nuevoBarcode = hexadecimalAzar(13);
	
	
	
	$sqlCb = 
			'	insert into codigo_barras (id_con , codigo , estado , utilizado , id_loc ) 
				values ("'.$idCon.'","'.$nuevoBarcode.'","A","1","'.$id_loc.'" ) 
			';
	$resCb = mysql_query($sqlCb) or die(mysql_error());
	
	$sqlB2 = 'update Boleto set strBarcode = "'.$nuevoBarcode.'" where idBoleto = "'.$id.'" ';
	$resB2 = mysql_query($sqlB2) or die (mysql_error());
	
	 // echo $sqlCb."<br><br>".$sqlB2;
	
	$sql = 'select count(idtrans) as id from transaccion_distribuidor where numboletos = "'.$id.'"';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	
	//echo $row['id'];
	if($row['id'] > 0){
		
		$sqlT = 'UPDATE transaccion_distribuidor SET impresion_local = "3" WHERE numboletos = "'.$id.'" ';
		//echo $sqlT;
		$res = mysql_query($sqlT) or die (mysql_error());
		
		
		
		$sql3 = 'select * from transaccion_distribuidor where numboletos = "'.$id.'"';
		$res3 = mysql_query($sql3) or die (mysql_error());
		$row3 = mysql_fetch_array($res3);
		
		date_default_timezone_set('America/Guayaquil');
		$fechaActual = date("Y-m-d");     
		$HoraActual = date("H:i:s");   
	
		$sql2 = '	INSERT INTO `reimpresio_boleto` (`id`, `id_con` ,`barcode` , iduser , fecha , hora) 
					VALUES (NULL, "'.$row3['idconciertotrans'].'" , "'.$id.'" , "'.$_SESSION['iduser'].'", "'.$fechaActual.'", "'.$HoraActual.'" )';
		$res2 = mysql_query($sql2) or die(mysql_error());
		
		/*$sqlB3 = 'update Boleto set strQr = "'.$strBarcode.'" where idBoleto = "'.$id.'" ';
		$resB3 = mysql_query($sqlB3) or die (mysql_error());*/
		
		$sqlB31 = 'update codigo_barras set estado = "ANU" where codigo = "'.$strBarcode.'" ';
		$resB31 = mysql_query($sqlB31) or die (mysql_error());
		
		
		// echo $sqlB3."<br>";
		
		
		echo 'El boleto : '.$codestablecimientoAHIS.'--'.$serieemisionA.'--'.$rowB['serie'].' esta listo para ser re-impreso , por favor espere unos segundos !!!';
	}
?>