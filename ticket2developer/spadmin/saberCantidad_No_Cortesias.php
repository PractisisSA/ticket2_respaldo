<?php
	session_start();
	include '../../conexion.php';
	
	
	$local = $_REQUEST['idloc'];
	$numticket = $_REQUEST['num_personas'];
	
	
	
	
	$sql = 'SELECT strCapacidadL as cant_bol FROM `Localidad` WHERE idLocalidad = "'.$local.'"';
	//echo "<span style = 'color:red;'>".$sql."</span><br>";
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	
	
	
	// $sqlOc = 'SELECT count(id) as ocupados FROM `ocupadas` WHERE `local` = "'.$local.'" and status = "3"';
	// $resOc = mysql_query($sqlOc) or die (mysql_error());
	// $rowOc = mysql_fetch_array($resOc);
	// $cant_bol_localidad_ocupados = $rowOc['ocupados'];
	
	
	$cant_bol_localidad_ocupados=0;
	$sqlOc = '	SELECT 1 as posicion, `row` , `col` , (`status`) , (`local`) , (`concierto`) 
				FROM `ocupadas`
				WHERE `local` = "'.$local.'" 
				and status = "3"
				group by `row` , `col` , `status` , `local` , `concierto` 
				ORDER BY `col` ASC
			';
	$resOc = mysql_query($sqlOc) or die (mysql_error());
	$sumaBloqueos = 0;
	while($rowOc = mysql_fetch_array($resOc)){
		$cant_bol_localidad_ocupados += $rowOc['posicion'];
	}
	
	
	$sqlLC = 'SELECT count(id) as cuantos_autorizados ,`id_loc` , cant FROM `localidad_cortesias` WHERE `id_loc` = "'.$local.'" ORDER BY `id` ASC ';
	$resLC = mysql_query($sqlLC) or die (mysql_error());
	$rowLC = mysql_fetch_array($resLC);
	$cantidad_autorizados = $rowLC['cant'];
	$cuantos_autorizados = $rowLC['cuantos_autorizados'];
	
	
	$sqlD = 'SELECT * FROM `descuentos` WHERE `idloc` = "'.$local.'" AND `nom` LIKE "%cortes%" ORDER BY `id` ASC ';
	// echo $sqlD;
	$resD = mysql_query($sqlD) or die (mysql_error());
	$rowD = mysql_fetch_array($resD);
	
	
	$sqlOc1 = 'SELECT count(idBoleto) as vendidos FROM `Boleto` WHERE `idLocB` = "'.$local.'"  ';
	$resOc1 = mysql_query($sqlOc1) or die (mysql_error());
	$rowOc1 = mysql_fetch_array($resOc1);
	
	
	$cant_bol_localidad = $row['cant_bol'];
	
	$cant_bol_vendidos = $rowOc1['vendidos'];
	
	
	
	$cant_bol = (($cant_bol_localidad - $cantidad_autorizados - $cant_bol_localidad_ocupados));
	
	$disponibles_autorizados = ($cant_bol - $cant_bol_vendidos);
	
	 // echo "Cortesias autorizadas : ".$cantidad_autorizados."  creados : ".$cant_bol_localidad." <<>> bloqueados en negro : ".$cant_bol_localidad_ocupados." >><< disponibles sin bloqueo : ".$cant_bol." <<>> Localidad : ".$local." vendidos : ".$cant_bol_vendidos." disponibles para vender : ".$disponibles_autorizados."<br><br>";
	// echo $disponibles_venta;
	
	if($disponibles_autorizados >= $numticket){
		$ident = 1;
		echo $ident.'|'.$disponibles_autorizados;
	}
	elseif($disponibles_autorizados <= 0){
		$ident = 2;
		echo $ident.'|'.$disponibles_autorizados;
	}else{
		$ident = 0;
		echo $ident."|".$disponibles_autorizados;
	}
	// if($cuantos_autorizados != 0){
		
	// }else{
		// $ident = 2;
		// echo $ident;
	// }
?>