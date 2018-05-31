<?php
	session_start();
	include '../../conexion.php';
	$local = $_REQUEST['local'];
	$concierto = $_REQUEST['concierto'];
	$_SESSION['id_area_mapa'] = 1;
	$_SESSION['localidad'] = $local;
	$sqlC = 'select * from Concierto where idConcierto = "'.$concierto.'" ';
	$resC = mysql_query($sqlC) or die (mysql_error());
	$rowC = mysql_fetch_array($resC);
	$dateFechaPreventa = $rowC['dateFechaPreventa'];
	
	$hoy = date("Y-m-d");
	$sql = 'select * from Localidad where idLocalidad = "'.$local.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	$strCaracteristicaL = $row['strCaracteristicaL'];
	
	if($hoy < $dateFechaPreventa){
		$precio = $row['doublePrecioPreventa'];
	}else{
		$precio = $row['doublePrecioL'];
	}
	
	//echo 'hola';//$strCaracteristicaL;
	if($strCaracteristicaL == 'Asientos no numerados'){
		$valorAsientos = 0;
		$_SESSION['valida_ocupadas'] = 0;
	}elseif($strCaracteristicaL == 'Asientos numerados'){
		$valorAsientos = 1;
		$_SESSION['valida_ocupadas'] = 1;
	}
	
	
	$sql = 'SELECT strCapacidadL as cant_bol FROM `Localidad` WHERE `idConc` = "'.$concierto.'"  and idLocalidad = "'.$local.'"';
	//echo "<span style = 'color:red;'>".$sql."</span><br>";
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	
	$sqlOc = 'SELECT count(id) as ocupados FROM `ocupadas` WHERE `local` = "'.$local.'" and status = "3"';
	$resOc = mysql_query($sqlOc) or die (mysql_error());
	$rowOc = mysql_fetch_array($resOc);
	
	
	$sqlOc1 = 'SELECT count(idBoleto) as vendidos FROM `Boleto` WHERE `idLocB` = "'.$local.'"';
	// echo $sqlOc1."<br>";
	$resOc1 = mysql_query($sqlOc1) or die (mysql_error());
	$rowOc1 = mysql_fetch_array($resOc1);
	
	
	$cant_bol_localidad = $row['cant_bol'];
	$cant_bol_localidad_ocupados = $rowOc['ocupados'];
	$cant_bol_vendidos = $rowOc1['vendidos'];
	
	
	
	$cant_bol = (($cant_bol_localidad - $cant_bol_localidad_ocupados));
	
	$disponibles_venta = ($cant_bol - $cant_bol_vendidos);
	
	
	$option = "<option value = '0' disponibles_venta = '".$disponibles_venta."' >Seleccione...</option>";
	if($disponibles_venta < 100){			
		for($k=0;$k<=$disponibles_venta;$k++){
			if($k==0){
				$txtOp = '';
			}else{
				$txtOp ='(s)';
			}
	
		$option .= "<option value = '".$k."' >".$k." Boleto".$txtOp."</option>";
	
		}
	}
	else if($disponibles_venta >=100 && $disponibles_venta <=200){
		for($k=0;$k<=$disponibles_venta;$k++){
			if($k==0){
				$txtOp = '';
			}else{
				$txtOp ='(s)';
			}
			$option .= "<option value = '".$k."' >".$k." Boleto".$txtOp."</option>";
		}
		
	}elseif($disponibles_venta >=201 && $disponibles_venta <=300){
		for($k=0;$k<=$disponibles_venta;$k++){
			if($k==0){
				$txtOp = '';
			}else{
				$txtOp ='(s)';
			}
	
			$option .= "<option value = '".$k."' >".$k." Boleto".$txtOp."</option>";
		}
		
		
		// $option .= "<option value = '201' >201 Boletos</option>
					// <option value = '300' >300 Boletos</option>";
	}elseif($disponibles_venta >=301 && $disponibles_venta <=400){
		
		for($k=0;$k<=$disponibles_venta;$k++){
			if($k==0){
				$txtOp = '';
			}else{
				$txtOp ='(s)';
			}
			$option .= "<option value = '".$k."' >".$k." Boleto".$txtOp."</option>";
		}
		// $option .= "<option value = '301' >301 Boletos</option>
					// <option value = '400' >400 Boletos</option>";
	}elseif($disponibles_venta >=401 && $disponibles_venta <=500){
		
		for($k=0;$k<=$disponibles_venta;$k++){
			if($k==0){
				$txtOp = '';
			}else{
				$txtOp ='(s)';
			}
			$option .= "<option value = '".$k."' >".$k." Boleto".$txtOp."</option>";
		}
		// $option .= "<option value = '401' >401 Boletos</option>
					// <option value = '500' >500 Boletos</option>";
	}
	elseif($disponibles_venta >=501){
		
		for($k=0;$k<=500;$k++){
			if($k==0){
				$txtOp = '';
			}else{
				$txtOp ='(s)';
			}
			$option .= "<option value = '".$k."' >".$k." Boleto".$txtOp."</option>";
		}
	}
	
	echo $valorAsientos."|".$precio."|".$local."|".$option;
?>