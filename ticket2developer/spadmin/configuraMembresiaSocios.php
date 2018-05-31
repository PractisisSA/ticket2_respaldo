<?php
	session_start();
	include '../conexion.php';
	
	$id = $_REQUEST['id'];
	$id_membresia = $_REQUEST['id_membresia'];
	$ident = $_REQUEST['ident']; 
	$cedula_ = $_REQUEST['cedula_']; 
	$nombre_ = $_REQUEST['nombre_']; 
	$apellido_ = $_REQUEST['apellido_']; 
	$valor_ = $_REQUEST['valor_']; 
	$forma_pago_ = $_REQUEST['forma_pago_']; 
	$forma_pago_otro_ = $_REQUEST['forma_pago_otro_']; 
	$meses_ = $_REQUEST['meses_']; 
	$t_deuda_ = $_REQUEST['t_deuda_']; 
	$estado = $_REQUEST['estado']; 
	date_default_timezone_set("America/Guayaquil");
	$hoy = date("Y-m-d H:i:s");  
	$fecha = date("Y-m-d");  
	if($ident == 1){
		// echo 'insertar';
		$sqlM1 = 'select count(id) as cuantos from socio_membresia where cedula = "'.$cedula_.'" ';
		$resM1 = mysql_query($sqlM1) or die (mysql_error());
		$rowM1 = mysql_fetch_array($resM1);
		if($rowM1['cuantos'] == 0){
			$sql1 = 'select count(1) as cuantos ,  strDocumentoC , idCliente from Cliente WHERE `strDocumentoC` = "'.$cedula_.'" order by 1 desc limit 1';
			$res1 = mysql_query($sql1) or die (mysql_error());
			$row1 = mysql_fetch_array($res1);
			if($row1['cuantos'] == 0){
				$id_cliente = 0;
			}else{
				$id_cliente = $row1['idCliente'];
			}
			
			$sql = 'INSERT INTO `socio_membresia` (`id`, `id_membresia`, `cedula`, `id_cliente`, `nombre`, `apellido`, `tipo`, `forma_pago`, `estado`, `meses_mora`, `t_deuda` , `fecha_compra` , `patrocinador`) 
					VALUES (NULL, "'.$id.'",  "'.$cedula_.'",  "'.$id_cliente.'",  "'.$nombre_.'",  "'.$apellido_.'",  "1",  "'.$forma_pago_.'",  "'.$estado.'",  "'.$meses_.'",  "'.$t_deuda_.'" ,  "'.$fecha.'" ,  "'.$forma_pago_otro_.'" )';
			
			$res = mysql_query($sql) or die (mysql_error());
			
			$sqlPM = '	
						INSERT INTO `pagos_membresias` (`id`, `id_membresia`, `cedula`, `valor`, `forma_pago`, `fecha`) 
						VALUES (NULL, "'.$id.'" ,  "'.$cedula_.'" ,  "'.$valor_.'" ,  "inicial" ,  "'.$hoy.'" )
					';
			
			$resPM = mysql_query($sqlPM) or die (mysql_error());
			
			if($res){
				echo 'Socio-Membresia configurado con éxito';
			}else{
				echo 'error, comuniquese con el administrador del sistema';
			}
		}else{
			echo 'El socio : "'.$nombre_.' '.$apellido_.'" ya a comprado una membresia , no puede comprar otra';
		}
	}elseif($ident == 2){
		// echo 'actualizar';
		$sql = '
					update socio_membresia set 
											   nombre = "'.$nombre_.'" ,
											   apellido = "'.$apellido_.'" ,
											   
											   forma_pago = "'.$forma_pago_.'" ,
											   meses_mora = "'.$meses_.'" ,
											   t_deuda = "'.$t_deuda_.'" , 
											   patrocinador = "'.$forma_pago_otro_.'"
							where id = "'.$id.'" 
		
				';
		// echo $sql."<br>";
		$res = mysql_query($sql) or die (mysql_error());
		if($res){
			echo 'Socio-Membresia configurado con éxito';
		}else{
			echo 'error, comuniquese con el administrador del sistema';
		}
	}elseif($ident == 3){
		if($estado == 1){
			$est = 0;
		}else{
			$est = 1;
		}
		
		$sql = 'update socio_membresia set estado = "'.$est.'" where id = "'.$id.'" ';
		$res = mysql_query($sql) or die (mysql_error());
		if($res){
			echo 'Socio-Membresia configurado con éxito';
		}else{
			echo 'error, comuniquese con el administrador del sistema';
		}
	}
	
	// echo $sql;
	
	
?>