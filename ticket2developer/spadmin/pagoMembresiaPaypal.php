<?php
	session_start();
	include '../conexion.php';
	$cedula = $_SESSION['userdoc'];
	
	$valor_pagado = $_REQUEST['valor'];
	$periodo = $_REQUEST['periodo'];
	$ident_pago_membresia = $_REQUEST['ident_pago_membresia'];
	
	
	$myString = substr($periodo, 0, -1);
	// echo $myString; 

	$forma_de_pago = 'paypal';
	
	$hoy = date("Y-m-d");    
	
	
	$sqlHM1 = 'select * from socio_membresia where cedula = "'.$cedula.'" ';
	$resHM1 = mysql_query($sqlHM1) or die (mysql_error());
	$rowHM1 = mysql_fetch_array($resHM1);
	
	
	if($ident_pago_membresia == 1 || $ident_pago_membresia == 2){
		$txt3 = 'total';
			$sqlI3 = 	'
				INSERT INTO `pagos_membresias` (`id`, `id_membresia`, `cedula`, `valor`, `forma_pago`, `fecha`, `estado`) 
				VALUES (NULL, "'.$rowHM1['id_membresia'].'", "'.$cedula.'", "'.$valor_pagado.'", "'.$forma_de_pago.'", "'.$hoy.'", "'.$txt3.'" );
			';
			
			// echo $sqlI3."<br>";
			
			$resI3 = mysql_query($sqlI3) or die (mysql_error());
			echo 'pago completado con exito';
	}elseif($ident_pago_membresia == 3){
		$expPeriodo = explode("|",$myString);
		
		for($i=0;$i<=count($expPeriodo)-1;$i++){
			$exp2 = explode("@",$expPeriodo[$i]);
			$quien_ = $exp2[0];
			$cedula_ = $exp2[1];
			$valor_ = $exp2[2];
			$periodo_ = $exp2[3];
			
			$valor_pagado = ($valor_ * $periodo_);
			
			$sqlHM = 'select * from socio_membresia where cedula = "'.$cedula_.'" ';
			$resHM = mysql_query($sqlHM) or die (mysql_error());
			$rowHM = mysql_fetch_array($resHM);
			$txt3 = 'total';
			$sqlI3 = 	'
				INSERT INTO `pagos_membresias` (`id`, `id_membresia`, `cedula`, `valor`, `forma_pago`, `fecha`, `estado`) 
				VALUES (NULL, "'.$rowHM['id_membresia'].'", "'.$cedula_.'", "'.$valor_pagado.'", "'.$forma_de_pago.'", "'.$hoy.'", "'.$txt3.'" );
			';
			
			// echo $sqlI3."<br><br>";
			$resI3 = mysql_query($sqlI3) or die (mysql_error());
		}
		
		echo 'pago completado con exito';
	}
?>