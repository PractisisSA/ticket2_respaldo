<?php
	session_start();
	include '../conexion.php';
	$id = $_REQUEST['id'];
	date_default_timezone_set("America/Guayaquil");
	$sql = 'select * from Concierto where idConcierto = "'.$id.'"';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	$hoy = date("Y-m-d"); 
	$hora = date("H:i:s"); 
	$dateFecha= $hoy; 
	$dateFechaReserva= $row['dateFechaReserva']; 
	$dateFechaPReserva= $row['dateFechaPReserva']; 
	$dateFechaPreventa= $row['dateFechaPreventa']; 
	$strLugar= $row['strLugar']; 
	$timeHora= $hora; 
	$strEvento= $row['strEvento']; 
	$strImagen= $row['strImagen']; 
	$strVideoC= $row['strVideoC']; 
	$strDescripcion= $row['strDescripcion']; 
	$strCaractristica= $row['strCaractristica']; 
	$intCantArtC= $row['intCantArtC']; 
	$tiempopagoC= $row['tiempopagoC']; 
	$dircanjeC= $row['dircanjeC']; 
	$horariocanjeC= $row['horariocanjeC']; 
	$fechainiciocanjeC= $row['fechainiciocanjeC']; 
	$fechafinalcanjeC= $row['fechafinalcanjeC']; 
	$costoenvioC= $row['costoenvioC']; 
	
	if($_SESSION['perfil'] == ' Admin_Socio'){
		$porcentajetarjetaC = $_SESSION['iduser'];
	}else{
		$porcentajetarjetaC= $row['porcentajetarjetaC']; 
	}
	
	
	// $porcentajetarjetaC= $row['porcentajetarjetaC']; 
	$strMapaC= $row['strMapaC']; 
	$strMapaFill= $row['strMapaFill']; 
	$idUser= $row['idUser']; 
	$createbyC= $row['createbyC']; 
	$fechaCreacionC= $row['fechaCreacionC']; 
	$strEstado= $row['strEstado']; 
	$tiene_permisos = 0;//$row['tiene_permisos']; 
	$autMun= $row['autMun']; 
	$locPago= $row['locPago']; 
	$dirPago= $row['dirPago']; 
	$fecha= $row['fecha']; 
	$hora= $row['hora']; 
	$tipo_conc= $row['tipo_conc']; 
	$es_publi= $row['es_publi']; 
	$img_bol_izq= $row['img_bol_izq']; 
	$img_bol_cen= $row['img_bol_cen']; 
	$img_bol_der= $row['img_bol_der']; 
	$img_bol_Acen = $row['img_bol_Acen'];
	
	$envio = $row['envio'];
	
	
	$porcpaypal = $row['porcpaypal'];
	$valpaypal = $row['valpaypal'];
	$porcstripe = $row['porcstripe'];
	$valstripe = $row['valstripe'];
	$comis_transfer = $row['comis_transfer'];
	
	$sql2='	INSERT INTO `Concierto` (
										`idConcierto`, `dateFecha`, `dateFechaReserva`, `dateFechaPReserva`, `dateFechaPreventa`, 
										`strLugar`, `timeHora`, `strEvento`, `strImagen`, `strVideoC`, `strDescripcion`, `strCaractristica`, 
										`intCantArtC`, `tiempopagoC`, `dircanjeC`, `horariocanjeC`, `fechainiciocanjeC`, `fechafinalcanjeC`, 
										`costoenvioC`, `porcentajetarjetaC`, `strMapaC`, `strMapaFill`, `idUser`, `createbyC`, `fechaCreacionC`, 
										`strEstado`, `tiene_permisos`, `autMun`, `locPago`, `dirPago`, `fecha`, `hora`, `tipo_conc`, `es_publi`,
										`img_bol_izq`, `img_bol_cen`, `img_bol_der`, `img_bol_Acen`, `envio`,
										`porcpaypal`,`valpaypal`,`porcstripe`,`valstripe`,`comis_transfer`
										
									) 
			VALUES (
						null , "'.$dateFecha.'", "'.$dateFechaReserva.'", "'.$dateFechaPReserva.'", "'.$dateFechaPreventa.'", "'.$strLugar.'", 
						"'.$timeHora.'", "'.$strEvento.'_clonado", "'.$strImagen.'", "'.$strVideoC.'", "'.addcslashes($strDescripcion).'", 
						"'.$strCaractristica.'", "'.$intCantArtC.'", "'.$tiempopagoC.'", "'.$dircanjeC.'", "'.$horariocanjeC.'", 
						"'.$fechainiciocanjeC.'", "'.$fechafinalcanjeC.'", "0", "'.$porcentajetarjetaC.'", "'.$strMapaC.'", "'.$strMapaFill.'", 
						"'.$idUser.'", "'.$createbyC.'", "'.$fechaCreacionC.'", "'.$strEstado.'", "'.$tiene_permisos.'", "'.$autMun.'", 
						"'.$locPago.'", "'.$dirPago.'", "'.$fecha.'", "'.$hora.'", "'.$tipo_conc.'", "1", "0", "0", "0", "0", "'.$envio.'",
						 "'.$porcpaypal.'" ,  "'.$valpaypal.'" ,  "'.$porcstripe.'" ,  "'.$valstripe.'",  "'.$comis_transfer.'"
					)';
	//echo $sql2;
	$res = mysql_query($sql2) or die (mysql_error());
	$idConc = mysql_insert_id();
	
	$sqlL = 'SELECT * FROM `Localidad` WHERE `idConc` = "'.$id.'" ORDER BY `strDescripcionL` ASC ';
	$resL = mysql_query($sqlL) or die (mysql_error());
	while($rowL = mysql_fetch_array($resL)){
		$id_loc = $rowL['idLocalidad'];
		$idConc_Nuevo = $idConc;
		
		$strDescripcionL= $rowL['strDescripcionL'];
		$strDateStateL= $rowL['strDateStateL']; 
		$doublePrecioL= $rowL['doublePrecioL']; 
		$intPorcentajeReserva= $rowL['intPorcentajeReserva'];
		$doublePrecioReserva= $rowL['doublePrecioReserva']; 
		$intPorcentajePreventa= $rowL['intPorcentajePreventa']; 
		$doublePrecioPreventa= $rowL['doublePrecioPreventa']; 
		$strCapacidadL= $rowL['strCapacidadL']; 
		 
		$strCaracteristicaL= $rowL['strCaracteristicaL']; 
		$createbyL= $rowL['createbyL']; 
		$fechaCreacionL= $rowL['fechaCreacionL']; 
		$strEstadoL= $rowL['strEstadoL']; 
		$strImgL= $rowL['strImgL']; 
		$strEstadoMapaL= $rowL['strEstadoMapaL']; 
		$puerta= $rowL['puerta'];
		$macro_localidad= $rowL['macro_localidad'];
		
		
		$sql2 = '	INSERT INTO `Localidad` (`idLocalidad`, `strDescripcionL`, `strDateStateL`, `doublePrecioL`, `intPorcentajeReserva`, `doublePrecioReserva`, `intPorcentajePreventa`, `doublePrecioPreventa`, `strCapacidadL`, `idConc`, `strCaracteristicaL`, `createbyL`, `fechaCreacionL`, `strEstadoL`, `strImgL`, `strEstadoMapaL`, `puerta` , `macro_localidad`) 
					VALUES(null ,"'.$strDescripcionL.'","'.$strDateStateL.'", "'.$doublePrecioL.'", "'.$intPorcentajeReserva.'","'.$doublePrecioReserva.'", "'.$intPorcentajePreventa.'", "'.$doublePrecioPreventa.'", "'.$strCapacidadL.'", "'.$idConc_Nuevo.'", "'.$strCaracteristicaL.'", "'.$createbyL.'", "'.$fechaCreacionL.'", "'.$strEstadoL.'", "'.$strImgL.'", "'.$strEstadoMapaL.'", "'.$puerta.'" , "'.$macro_localidad.'")';
		echo $sql2."<br><br>";
		$res2 = mysql_query($sql2) or die (mysql_error());
		$id_locNueva = mysql_insert_id();
		
		
		
		$sql3 = 'SELECT * FROM `Butaca` WHERE `intLocalB` = "'.$id_loc.'" ORDER BY `intLocalB` ASC ';
		$res3 = mysql_query($sql3) or die (mysql_error());
		$row3 = mysql_fetch_array($res3);
		
		$intFilasB= $row3['intFilasB']; 
		$intAsientosB= $row3['intAsientosB']; 
		$strCoordenadasB= $row3['strCoordenadasB']; 
		$strSecuencial= $row3['strSecuencial']; 
		$datestateL= $row3['datestateL']; 
		$datafullL= $row3['datafullL']; 
		$intLocalB= $id_locNueva;
		$intConcB= $idConc_Nuevo;
		$createbyB= $row3['createbyB']; 
		$fechaCreacionB= $row3['fechaCreacionB']; 
		$strEstado= $row3['strEstado'];
		
		$sql4 = '	INSERT INTO `Butaca` (`idButaca`, `intFilasB`, `intAsientosB`, `strCoordenadasB`, `strSecuencial`, `datestateL`, `datafullL`, `intLocalB`, `intConcB`, `createbyB`, `fechaCreacionB`, `strEstado`) 
					VALUES(	null , "'.$intFilasB.'", "'.$intAsientosB.'", "'.$strCoordenadasB.'", "'.$strSecuencial.'", "'.$datestateL.'","'.$datafullL.'", "'.$intLocalB.'", "'.$intConcB.'", "'.$createbyB.'", "'.$fechaCreacionB.'", "'.$strEstado.'")';
		$res4 = mysql_query($sql4) or die (mysql_error());
		
		$sqlD = 'select * from descuentos where idloc = "'.$id_loc.'" ';
		$resD = mysql_query($sqlD) or die (mysql_error());
		while($rowD = mysql_fetch_array($resD)){
			$nom = $rowD['nom'];
			$val = $rowD['val'];
			$est = $rowD['est'];
			
			$sqlD1 = 'INSERT INTO `descuentos` (`id`, `idcon`, `idloc`, `nom`, `val`, `est`) VALUES (NULL, "'.$idConc_Nuevo.'", "'.$id_locNueva.'", "'.$nom.'", "'.$val.'", "'.$est.'")';
			$resD1 = mysql_query($sqlD1) or die (mysql_error());
			$id_DescNuevo = mysql_insert_id();
			
			
		
		}
		
		
		// $sqlLc = 'SELECT count(lc.id) as cuantos_l_c, lc.* FROM localidad_cortesias as lc where lc.id_loc = "'.$rowD['idloc'].'" ';
		// $resLc = mysql_query($sqlLc) or die (mysql_error());
		// $rowLc = mysql_fetch_array($resLc);
		// if($rowLc['cuantos_l_c'] == 0){
			// $sqlILC = '	insert into localidad_cortesias (id_loc,id_desc,cant,est) 
						// values ("'.$id_locNueva.'","'.$id_DescNuevo.'",0,0)
						// ';
			// $resILC = mysql_query($sqlILC) or die (mysql_error());
		// }else{
			// $sqlILC = '	insert into localidad_cortesias (id_loc,id_desc,cant,est) 
						// values ("'.$id_locNueva.'","'.$id_DescNuevo.'","'.$rowLc['cant'].'",0)
						// ';
			// $resILC = mysql_query($sqlILC) or die (mysql_error());
		// }
		
		
		$sqlOc = 'SELECT * FROM `ocupadas` WHERE `status` = "3"  AND `local` = "'.$id_loc.'" ORDER BY `id` DESC ';
		$resOc = mysql_query($sqlOc) or die (mysql_error());
		while($rowOc = mysql_fetch_array($resOc)){
			
			
			$row= $rowOc['row']; 
			$col= $rowOc['col']; 
			$status2= $rowOc['status'];
			$local= $id_locNueva;//575;
			$concierto= $idConc_Nuevo;
			$pagopor= $rowOc['pagopor']; 
			$descompra= $rowOc['descompra'];
			
			$sqlCo1 = '	INSERT INTO `ocupadas` (`id`, `row`, `col`, `status`, `local`, `concierto`, `pagopor`, `descompra`) 
						VALUES(null ,"'.$row.'", "'.$col.'", "'.$status2.'","'.$local.'", "'.$concierto.'", "'.$pagopor.'", "'.$descompra.'")';
			$resCo1 = mysql_query($sqlCo1) or die (mysql_error());
		}
	}
	
	$sqlDd = 'select * from desgl_docu where id_con = "'.$id.'" ';
	$resDd = mysql_query($sqlDd) or die (mysql_error());
	while($rowDd = mysql_fetch_array($resDd)){
		
		$sqlDd1 = 'insert into desgl_docu (id_con , docu , desg) values("'.$idConc.'" , "'.$rowDd['docu'].'" , "'.$rowDd['desg'].'" )';
		$resDd1 = mysql_query($sqlDd1) or die (mysql_error());
	}
	
	
	$sqlImp = 'select * from impuestos where id_con = "'.$id.'" ';
	$resImp = mysql_query($sqlImp) or die (mysql_error());
	while($rowImp = mysql_fetch_array($resImp)){
		
		$sqlImp1 = 'INSERT INTO impuestos (id, id_con, valorados, sin_permisos, cortesias, sayse, sri, municipio) 
					VALUES (NULL, "'.$idConc.'", "'.$rowImp['valorados'].'", "", "'.$rowImp['cortesias'].'", "'.$rowImp['sayse'].'", "'.$rowImp['sri'].'", "'.$rowImp['municipio'].'")';
		$resImp1 = mysql_query($sqlImp1) or die (mysql_error());
	}
	
	
	
	$sqlCl = 'select * from claves where id_con = "'.$id.'" ';
	$resCl = mysql_query($sqlCl) or die (mysql_error());
	while($rowCl = mysql_fetch_array($resCl)){
		
		$sqlCl1 = 'insert into claves (id_con , clave , clave2 , clave3)
					VALUES ("'.$idConc.'", "'.$rowCl['clave'].'", "'.$rowCl['clave2'].'", "'.$rowCl['clave3'].'")';
		$resCl1 = mysql_query($sqlCl1) or die (mysql_error());
	}
	
	
	
	
	
	echo $idConc.'|Evento clonado con éxito';
?>