<?php
	session_start();
	date_default_timezone_set("America/Guayaquil");
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	include '../../../conexion.php';
	//$codigo = $_SESSION['barcode'];
	$boleto = $_REQUEST['boleto'];
	$cedulaCanje = $_REQUEST['cedulaCanje'];
	$sqlF = '	select count(id) as cuantos , id_cli , idConc , localidad , valor , id as id_f
				from factura 
				where rand = "'.$boleto.'" 
				and estadopagoPV = "ok"
				and estado <> "ok" 
			';
	$resF = mysql_query($sqlF) or die (mysql_error());
	$rowF = mysql_fetch_array($resF);
	
	$cuantos1 = $rowF['cuantos'];
	$id_cli = $rowF['id_cli'];
	$idConc = $rowF['idConc'];
	$localidad = $rowF['localidad'];
	$valor = $rowF['valor'];
	
	$bolet = 'SELECT * FROM Boleto WHERE strBarcode = '.$boleto.'';
	$resu = mysql_query($bolet);
	$rowu = mysql_fetch_array($resu);
	
	$consult = 'SELECT * FROM detalle_boleto WHERE idBoleto = '.$rowu['idBoleto'].'';
	$resCons = mysql_query($consult);
	$rowCons = mysql_fetch_array($resCons);

	if ($rowCons['estadoCompra'] == 0) {
		echo 5;
	}else{
		if($cuantos1 != 0){
		
		$sqlFB = 'select * from factura_boleto where id_fac = "'.$rowF['id_f'].'"';
		$resFB = mysql_query($sqlFB) or die (mysql_error());
		while($rowFB = mysql_fetch_array($resFB)){
			$idboleto = $rowFB['id_bol'];
			$sqlTra = 'INSERT INTO transaccion_distribuidor VALUES ("NULL", '.$id_cli.', '.$idConc.', "'.$localidad.'", "'.$_SESSION['idDis'].'", "" ,"'.$idboleto.'", "", "'.$valor.'","'.date("Y-m-d H:i:s").'","0")';
			$resTra = mysql_query($sqlTra) or die (mysql_error());
			//echo 3;
		}
		$sqlF1 = 'update factura set estado = "ok" where rand = "'.$boleto.'" ';
		$resF1 = mysql_query($sqlF1) or die (mysql_error());
		exit;
	}else{
		$sqlT = '	select count(idBoleto) as no_impreso
					from transaccion_distribuidor as t , Boleto as b
					where b.strBarcode = "'.$boleto.'"
					and b.idBoleto = t.numboletos
					and t.impresion_local = 1
					';
		$resT = mysql_query($sqlT) or die (mysql_error());
		$rowT = mysql_fetch_array($resT);
		if($rowT['no_impreso'] == 0){
			$sqlB = '	select count(idBoleto) as cuantos , idCli , idCon , idLocB , idBoleto
						from Boleto where strBarcode = "'.$boleto.'" ';
			$resB = mysql_query($sqlB) or die(mysql_error());
			$rowB = mysql_fetch_array($resB);
			
			$cuantos = $rowB['cuantos'];
			$id_cli = $rowB['idCli'];
			$idConc = $rowB['idCon'];
			$localidad = $rowB['idLocB'];
			$idboleto = $rowB['idBoleto'];
			
			if($cuantos != 0){
				$sqlTra = 'INSERT INTO transaccion_distribuidor VALUES ("NULL", '.$id_cli.', '.$idConc.', "'.$localidad.'", "'.$_SESSION['idDis'].'", "" ,"'.$idboleto.'", "", "0","'.date("Y-m-d H:i:s").'","0")';
				$resTra = mysql_query($sqlTra) or die (mysql_error());
				
				$sqlBb = 'update Boleto set tipo_evento = 3 where strBarcode = "'.$boleto.'" ';
				$resBb = mysql_query($sqlBb) or die (mysql_error());
				
				$sqlCc = '	INSERT INTO `copias_cedula` (`id`, `id_cli`, `id_bol`, `id_usuario`, `cedula`) VALUES (NULL, "'.$id_cli.'", "'.$idboleto.'", "'.$_SESSION['idDis'].'", "'.$cedulaCanje.'")';
				$resCc = mysql_query($sqlCc) or die (mysql_error());
				
				$sqlDT = 'select id_fact from detalle_tarjetas where idbol = "'.$idboleto.'" ';
				$resDT = mysql_query($sqlDT) or die (mysql_error());
				$rowDT = mysql_fetch_array($resDT);
				
				$sqlUf = 'update factura set impresion_local = "1" where id = "'.$rowDT['id_fact'].'" ';
				$resUf = mysql_query($sqlUf) or die (mysql_error());
				echo 3;
			}else{
				echo 2;
			}
		}else{
			echo 1;
		}
	}
	}

	
?>