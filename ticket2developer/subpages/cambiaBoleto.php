<?php
	include '../conexion.php';
	
	$local_desde = $_REQUEST['local_desde'];
	$desde = $_REQUEST['desde'];
	$hasta = $_REQUEST['hasta'];
	$local_hasta = $_REQUEST['local_hasta'];
	$evento = $_REQUEST['evento'];
	
	$descuentos = $_REQUEST['descuentos'];
	$nomDesc = $_REQUEST['nomDesc'];
	$id_desc = $_REQUEST['id_desc'];
	
	$sqlB = 'select max(CAST(serie_localidad AS INTEGER)) as serieB from Boleto where idCon = "'.$evento.'" and idLocB = "'.$local_hasta.'" order by idBoleto DESC limit 1';
	$resB = mysql_query($sqlB) or die (mysql_error());
	$rowB = mysql_fetch_array($resB);
	
	
	$sqlB1 = 'select max(CAST(serie_localidad AS INTEGER)) as serieA from Boleto where idCon = "'.$evento.'" and idLocB = "'.$local_desde.'" order by idBoleto DESC limit 1';
	$resB1 = mysql_query($sqlB1) or die (mysql_error());
	$rowB1 = mysql_fetch_array($resB1);
	
	
	
	$sql = 'SELECT * FROM `Boleto` WHERE idCon = "'.$evento.'" and `idLocB` = "'.$local_desde.'" AND `serie_localidad` BETWEEN '.$desde.' AND '.$hasta.' ORDER BY `idBoleto` ASC ';
	// echo $sql;
	// exit;
	$res = mysql_query($sql) or die (mysql_error());
	$i=0;
	while($row = mysql_fetch_array($res)){
		$i++;
		
		if($id_desc == 0){
			$tercera = 0;
		}else{
			$tercera = 1;
		}
		if($local_desde == $local_hasta){
			$query = '';
		}else{
			$query = 'serie_localidad = "'.($rowB['serieB'] + $i).'" ,';
		}
		$sqlC = 'update Boleto set idLocB = "'.$local_hasta.'" , tercera = "'.$tercera.'" , '.$query.' id_desc = "'.$id_desc.'" , valor = "'.$descuentos.'" where idBoleto = "'.$row['idBoleto'].'" ';
		// echo $sqlC."<br>";
		$resC = mysql_query($sqlC) or die (mysql_error());
		
		$sqlT = 'update transaccion_distribuidor set idlocalidadtrans = "'.$local_hasta.'" , impresion_local = 3 where numboletos = "'.$row['idBoleto'].'" ';
		$resT = mysql_query($sqlT) or die (mysql_error());
		//echo "valor descuento : ".$descuentos." << >> nombre descuento : ".$nomDesc." << >> id descuento : ".$id_desc." << >> ultima serie localidad desde : ".($rowB1['serieA'] - $hasta)." << >> nueva serie de los boletos".($rowB['serieB'] + $i)." >> << serie antigua de los boletos".$row['serie_localidad']."<br>";
		
		$sql2 = 'INSERT INTO `reimpresio_boleto` (`id`, `id_con` ,`barcode`) VALUES (NULL, "" , "'.$row['idBoleto'].'")';
		$res2 = mysql_query($sql2) or die(mysql_error());
	}
	echo 'Sus Boletos se reimprimiran en un momento , por favor Espere!!!';
?>