<?php
	session_start();
	include '../conexion.php';
	$id_loc = $_REQUEST['id'];
	$idConc_Nuevo = $_REQUEST['idConc'];
	
	
	$sql = 'select * from Localidad where idLocalidad = "'.$id_loc.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	
	$strDescripcionL= $row['strDescripcionL'];
	$strDateStateL= $row['strDateStateL']; 
	$doublePrecioL= $row['doublePrecioL']; 
	$intPorcentajeReserva= $row['intPorcentajeReserva'];
	$doublePrecioReserva= $row['doublePrecioReserva']; 
	$intPorcentajePreventa= $row['intPorcentajePreventa']; 
	$doublePrecioPreventa= $row['doublePrecioPreventa']; 
	$strCapacidadL= $row['strCapacidadL']; 
	 
	$strCaracteristicaL= $row['strCaracteristicaL']; 
	$createbyL= $row['createbyL']; 
	$fechaCreacionL= $row['fechaCreacionL']; 
	$strEstadoL= $row['strEstadoL']; 
	$strImgL= $row['strImgL']; 
	$strEstadoMapaL= $row['strEstadoMapaL']; 
	$puerta= $row['puerta'];
	$macro_localidad= $rowL['macro_localidad'];
	
	$sql2 = '	INSERT INTO `Localidad` (`idLocalidad`, `strDescripcionL`, `strDateStateL`, `doublePrecioL`, `intPorcentajeReserva`, `doublePrecioReserva`, `intPorcentajePreventa`, `doublePrecioPreventa`, `strCapacidadL`, `idConc`, `strCaracteristicaL`, `createbyL`, `fechaCreacionL`, `strEstadoL`, `strImgL`, `strEstadoMapaL`, `puerta` , `macro_localidad`) 
				VALUES(null ,"'.$strDescripcionL.'","'.$strDateStateL.'", "'.$doublePrecioL.'", "'.$intPorcentajeReserva.'","'.$doublePrecioReserva.'", "'.$intPorcentajePreventa.'", "'.$doublePrecioPreventa.'", "'.$strCapacidadL.'", "'.$idConc_Nuevo.'", "'.$strCaracteristicaL.'", "'.$createbyL.'", "'.$fechaCreacionL.'", "'.$strEstadoL.'", "'.$strImgL.'", "'.$strEstadoMapaL.'", "'.$puerta.'" , "'.$macro_localidad.'")';
	
	$res2 = mysql_query($sql2) or die (mysql_error());
	$id_locNueva = mysql_insert_id();
	$_SESSION['id_locNueva'] = $id_locNueva;
	$sql3 = 'SELECT * FROM `Butaca` WHERE `intLocalB` = "'.$id_loc.'" ORDER BY `intLocalB` ASC ';
	$res3 = mysql_query($sql3) or die (mysql_error());
	$row3 = mysql_fetch_array($res3);
	
	$sqlD = 'select * from descuentos where idloc = "'.$id_loc.'" ';
	$resD = mysql_query($sqlD) or die (mysql_error());
	while($rowD = mysql_fetch_array($resD)){
		$nom = $rowD['nom'];
		$val = $rowD['val'];
		$est = $rowD['est'];
		
		$sqlD1 = 'INSERT INTO `descuentos` (`id`, `idcon`, `idloc`, `nom`, `val`, `est`) VALUES (NULL, "'.$idConc_Nuevo.'", "'.$id_locNueva.'", "'.$nom.'", "'.$val.'", "'.$est.'")';
		$resD1 = mysql_query($sqlD1) or die (mysql_error());
		$id_DescNuevo = mysql_insert_id();
			
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
	}
	
	
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


	$sqlOc = 'SELECT count(id) as num_ocupadas FROM `ocupadas` WHERE `status` = 3 AND `local` = "'.$id_loc.'" ORDER BY `id` DESC ';
	$resOc = mysql_query($sqlOc) or die (mysql_error());
	$rowOc = mysql_fetch_array($resOc);
	if($rowOc['num_ocupadas']>0){
		$btnOc = 	"
						<button type='button' onclick = 'clonaOcupadas(".$id_loc." , ".$id_locNueva." , 3 , ".$idConc_Nuevo.")' class='btn btn-info' id = 'btn_local_fade_ocupadas_".$id_loc."'>Clonar [".$rowOc['num_ocupadas']."]Asientos Bloqueados!  <img src = 'imagenes/loading.gif' style = 'width:30px;display:none;' id = 'img_local_fade_ocupadas_".$id_loc."'/></button><br>
						<button type='button' class='btn btn-danger' onclick = 'eliminaLocalidadClonada(".$id_locNueva.")' id = 'btn_local_fade_".$id_locNueva."'>Elimina Localidad Clonada!!!</button>
					";
	}else{
		$btnOc = "
					<button type='button' class='btn btn-info'> No hay Asientos Bloqueados!  <img src = 'imagenes/loading.gif' style = 'width:30px;display:none;' id = 'img_local_fade_ocupadas".$id_loc."'/></button><br>
					<button type='button' class='btn btn-danger' onclick = 'eliminaLocalidadClonada(".$id_locNueva.")' id = 'btn_local_fade_".$id_locNueva."'>Elimina Localidad Clonada!!!</button>
				";
	}
			
			
	if($res2 && $res4){
		echo 'ok|'.$btnOc;
	}else{
		echo 'error';
	}
	
	
?>