<?php
	session_start();
	date_default_timezone_set("America/Guayaquil");
	include '../conexion.php';
	$id_fact = $_REQUEST['id_fact'];
	$cliente = $_REQUEST['cliente'];
	$conc = $_REQUEST['conc'];
	$loc = $_REQUEST['loc'];
	$idDis = $_REQUEST['idDis'];
	$tipotrans = $_REQUEST['tipotrans'];
	$pago = $_REQUEST['pago'];
	$valor = $_REQUEST['valor'];
	$impresion = $_REQUEST['impresion'];
	$idBol = $_REQUEST['idBol'];
	$fecha = date("Y-m-d H:i:s");
	
	$sqlF = 'update factura set impresion_local = 1 where id = "'.$id_fact.'" ';
	$resF = mysql_query($sqlF) or die (mysql_error());
	$boletos = explode("|",$idBol);
	for($i=0;$i<count($boletos)-1;$i++){
		$numboletos = $boletos[$i];
		
		$sqlC = 'select count(idtrans) as cuantos from transaccion_distribuidor where numboletos = "'.$numboletos.'" ';
		$resC = mysql_query($sqlC) or die (mysql_error());
		$rowC = mysql_fetch_array($resC);
		if($rowC['cuantos'] == 0){
			$sql = 'INSERT INTO `transaccion_distribuidor` (`idtrans`, `idclientetrans`, `idconciertotrans`, 
					`idlocalidadtrans`, `iddistribuidortrans`, `tipotrans`, `numboletos`, `pagotrans`, `valortrans`, 
					`fecha`, `impresion_local`) 
					VALUES (NULL, "'.$cliente.'" , "'.$conc.'" , "'.$loc.'" , "22" , "'.$tipotrans.'" , 
							"'.$numboletos.'" , "'.$pago.'" , "'.$valor.'" , "'.$fecha.'" , "'.$impresion.'")';
			// echo $sql." hola <br><br>";
			$res = mysql_query($sql) or die (mysql_error());

		}
		
	}
	echo 'Sus tickets seran impresos en un momento , por favor espere';
?>