<?php
	include '../conexion.php';
	
	$id = $_REQUEST['id'];
	$ident = $_REQUEST['ident']; 
	$membresia_ = $_REQUEST['membresia_']; 
	$valor_mensual_ = $_REQUEST['valor_mensual_']; 
	$localidades_ = $_REQUEST['localidades_']; 
	$cantidad_ = $_REQUEST['cantidad_']; 
	$gratis_ = $_REQUEST['gratis_']; 
	$otros_ = $_REQUEST['otros_']; 
	$estado_ = $_REQUEST['estado_']; 
	
	$tipo_pago_  = $_REQUEST['tipo_pago_'];
	$fechad_ = $_REQUEST['fechad_'];
	$periodo_ = $_REQUEST['periodo_'];
	
	if($ident == 1){
		$sql = 'INSERT INTO `membresia` (
											`id`, 
											`id_empresario`, 
											`membresia`, 
											`tipo_pago` ,
											`meses_caduca`,
											`periodo`,
											`valor_mensual`, 
											`cantidad`, 
											`localidades`, 
											`gratis`, 
											`otros`, 
											`estado`
										) 
								VALUES (
											NULL, 
											"'.$id.'",  
											"'.$membresia_.'",  
											"'.$tipo_pago_.'",  
											"'.$fechad_.'",  
											"'.$periodo_.'",  
											"'.$valor_mensual_.'",  
											"'.$cantidad_.'",  
											"'.$localidades_.'",  
											"'.$gratis_.'",  
											"'.$otros_.'",  
											"'.$estado_.'"
										)
				';
	}elseif($ident == 2){
		$sql = '
					update membresia set  
					membresia = "'.$membresia_.'" ,
					
					tipo_pago = "'.$tipo_pago_.'" ,
					meses_caduca = "'.$fechad_.'" ,
					periodo = "'.$periodo_.'" ,
					
					valor_mensual = "'.$valor_mensual_.'" ,
					cantidad = "'.$cantidad_.'" ,
					localidades = "'.$localidades_.'" ,
					gratis = "'.$gratis_.'" ,
					otros = "'.$otros_.'"
					where id = "'.$id.'"
				';
	}elseif($ident == 3){
		$sql1 = 'select estado from membresia where id = "'.$id.'" ';
		$res1 = mysql_query($sql1) or die(mysql_error());
		$row1 = mysql_fetch_array($res1);
		
		if($row1['estado'] == 1){
			$est = 0;
		}else{
			$est = 1;
		}
		
		$sql = 'update membresia set estado = "'.$est.'" where id = "'.$id.'" ';
	}
	
	// echo $sql;
	// exit;
	$res = mysql_query($sql) or die (mysql_error());
	
	if($res){
		echo 'membresia : '.$membresia_.' configurada con exito'; 
	}
?>