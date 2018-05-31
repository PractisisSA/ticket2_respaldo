<?php
	session_start();
	
	require_once('../../stripeconDora/lib/Stripe.php');
	Stripe::setApiKey('sk_live_LhXwe4EcfHj0hVSnN5WiWhbt');//anterior
	// Stripe::setApiKey('sk_live_gCWu5c8j5joFo3UGzONi7aTt');
	// Stripe::setApiKey('sk_test_6GSRONySlv39WktvlN4ZloaH');
	
	
	date_default_timezone_set('America/Guayaquil');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	
	
	include '../conexion.php';
	$cedula = $_SESSION['userdoc'];
	
	$valor_pagado = $_REQUEST['valor'];
	$periodo = $_REQUEST['periodo'];
	$ident_pago_membresia = $_REQUEST['ident_pago_membresia'];
	$preciocents = ($valor_pagado * 100);
	$token = $_REQUEST['token'];
	$myString = substr($periodo, 0, -1);
	$forma_de_pago = 'stripe';
	
	
	$evento = 'pago membresia';
	
	$cobroExitoso = 0;
	
	try{
		$charge = Stripe_Charge::create(array(
			'amount' => $preciocents,
			'currency' => 'usd',
			'card' => $token,
			'description' => $evento
			));

		$cobroExitoso = 1;
		$purchaseID = $charge->id;
		// echo 'purchase id token : '.$purchaseID;
		
	}
	catch(Exception $e){
		$error = $e->getMessage();
		
		$cobroExitoso = 0;
		// exit;
	}
	
	if($cobroExitoso === 1){
		// echo $token." <<>> ".$valor_pagado." >><< ".$forma_de_pago." >><< ".$cobroExitoso."<br>";
		
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
	
	}else{
		 echo $error;
	}
	
	
	
?>