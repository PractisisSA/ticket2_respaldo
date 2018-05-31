<?php
	session_start();
	include '../../conexion.php';
	
	$concierto = $_REQUEST['con'];
	$local = $_REQUEST['idlocal'];
	$numticket = $_REQUEST['numticket'];
	$_SESSION['localidad'] = $local;
	$hoy = date("y-m-d");
	
	
	$sqlL = 'select * from Localidad where idLocalidad = "'.$local.'" ';
	$resL = mysql_query($sqlL) or die (mysql_error());
	$rowL = mysql_fetch_array($resL);
	$strCaracteristicaL = $rowL['strCaracteristicaL'];
	
	
	if($strCaracteristicaL == 'Asientos no numerados'){
		$valorAsientos = 0;
		$_SESSION['valida_ocupadas'] = 0;
	}elseif($strCaracteristicaL == 'Asientos numerados'){
		$valorAsientos = 1;
		$_SESSION['valida_ocupadas'] = 1;
	}
	// echo $_SESSION['valida_ocupadas']."<br>";
	
	
	$sql = 'SELECT strCapacidadL as cant_bol FROM `Localidad` WHERE `idConc` = "'.$concierto.'"  and idLocalidad = "'.$local.'"';
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
	
	
	
	$sqlOc1 = 'SELECT count(idBoleto) as vendidos FROM `Boleto` WHERE `idLocB` = "'.$local.'"';
	$resOc1 = mysql_query($sqlOc1) or die (mysql_error());
	$rowOc1 = mysql_fetch_array($resOc1);
	
	
	$cant_bol_localidad = $row['cant_bol'];
	
	$cant_bol_vendidos = $rowOc1['vendidos'];
	
	
	
	$cant_bol = (($cant_bol_localidad - $cant_bol_localidad_ocupados));
	
	$disponibles_venta = ($cant_bol - $cant_bol_vendidos);
	//echo "creados : ".$cant_bol_localidad." <<>> bloqueados en negro : ".$cant_bol_localidad_ocupados." >><< disponibles sin bloqueo : ".$cant_bol." <<>> Localidad : ".$local." vendidos : ".$cant_bol_vendidos." disponibles para vender : ".$disponibles_venta."<br><br>";
	echo $disponibles_venta;
?>