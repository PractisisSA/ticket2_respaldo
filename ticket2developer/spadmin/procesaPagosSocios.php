<?php
	session_start();
	date_default_timezone_set("America/Guayaquil");
	include '../conexion.php';
	
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	try{
		$recibeExcel2 = $_REQUEST['recibeExcel2'];
		require_once '../ClassesE/PHPExcel.php';
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($recibeExcel2."");
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow(); 
		$highestColumn = $objWorksheet->getHighestColumn(); 
		$highestColumnIndex=2;
		$totalerroneas='';
		$i=0;
		$cedulaAcumuladas='';
		$dia = date("d");  
		$cedulas = '';
		$cedulasQ = '';
		
		$hoy = date("Y-m-d");   
		
		
		for($i = 2; $i <= $highestRow; ++$i){
			$id = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
			$cedula = $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
			$valor_pagado = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
			$forma_de_pago = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
		
			$sqlHM1 = 'select count(id) as cuantos from socio_membresia where patrocinador = "'.$cedula.'" ';
			$resHM1 = mysql_query($sqlHM1) or die (mysql_error());
			$rowHM1 = mysql_fetch_array($resHM1);
			$sumaHijos = 0;
			$sumaHijo = 0;
			$sumaPadre = 0;
			$valor_hijo = 0;
			$valor_padre_ = 0;
			$sqlI1 = '';
			$auxPagadoPatrocinio = 0;
			$pagoHijos = 0;
			
			if($rowHM1['cuantos'] > 0){
				// echo $valor_pagado."<br><hr>";
				
				$sql3 = '
							select (m.valor_mensual) as valor_padre , sm.cedula as cedula_padre , sm.id_membresia as idMembresia1
							from socio_membresia as sm , membresia as m 
							where cedula = "'.$cedula.'"
							and sm.id_membresia = m.id
						';
				$res3 = mysql_query($sql3) or die (mysql_error());
				
				while($row3 = mysql_fetch_array($res3)){
					$sumaPadre = $row3['valor_padre'];
					
					
					if($valor_pagado >= $sumaPadre){
						$debePagar1 = $sumaPadre;
						$txt1 = 'Total';
					}else{
						$debePagar1 = $valor_pagado;
						$txt1 = 'Parcial';
					}
					
					$auxPagadoPatrocinio = ($valor_pagado - $sumaPadre);
					
					$sqlI1 = 	'
									INSERT INTO `pagos_membresias` (`id`, `id_membresia`, `cedula`, `valor`, `forma_pago`, `fecha`, `estado`) 
									VALUES (NULL, "'.$row3['idMembresia1'].'", "'.$row3['cedula_padre'].'", "'.$debePagar1.'", "'.$forma_de_pago.'", "'.$hoy.'", "'.$txt1.'" );
								';
					$resI1 = mysql_query($sqlI1) or die (mysql_error());
					// echo "<label style = 'color:blue;' >".$sqlI1."</label><br>";
					
				}
				
				
				
				$sql1 = '
							select sum(m.valor_mensual) as valor_hijos
							from socio_membresia as sm , membresia as m 
							where patrocinador = "'.$cedula.'"
							and sm.id_membresia = m.id
						';
				$res1 = mysql_query($sql1) or die (mysql_error());
				
				while($row1 = mysql_fetch_array($res1)){
					$sumaHijo = $row1['valor_hijos'];
				}
				
				
				$sql4 = '
							select (m.valor_mensual) as valor_hijo ,  sm.cedula as cedula_hijos  , sm.id_membresia as idMembresia2
							from socio_membresia as sm , membresia as m 
							where patrocinador = "'.$cedula.'"
							and sm.id_membresia = m.id
						';
				$res4 = mysql_query($sql4) or die (mysql_error());
				$auxPagadoPatrocinio_hijos = 0;
				$pagoFinal = 0;
				$pagoReal = 0;
				$impresion='';
				$pago1=0;
				$pago2=0;
				$pagoHijos =  $valor_pagado - $sumaPadre;
				while($row4 = mysql_fetch_array($res4)){
					
					if($pagoHijos >= $row4['valor_hijo']){
						$pago1 = $pagoHijos-$row4['valor_hijo'];
						$debePagar = $row4['valor_hijo'];
						$txt2 = 'total';
					}else{
						$pago1 = $pagoHijos-$row4['valor_hijo'];
						$debePagar = ($row4['valor_hijo'] + $pago1);
						$txt2 = 'parcial';
					}
					
					if($debePagar>0){
						// $impresion .= $pagoHijos." - ".$row4['valor_hijo']." == ".$debePagar." >><< ".($pago1)." ><>< <br>";
						
						$sqlI2 = 	'
							INSERT INTO `pagos_membresias` (`id`, `id_membresia`, `cedula`, `valor`, `forma_pago`, `fecha`, `estado`) 
							VALUES (NULL, "'.$row4['idMembresia2'].'", "'.$row4['cedula_hijos'].'", "'.$debePagar.'", "'.$forma_de_pago.'", "'.$hoy.'", "'.$txt2.'" );
						';
			
						// echo "<label style = 'color:red;' >".$sqlI2."</label><br>";
						$resI2 = mysql_query($sqlI2) or die (mysql_error());
					}
						
					$pagoHijos = $pago1;
					
				}
				
			}else{
				
				$sql5 = '
							select (m.valor_mensual) as valor_padre_ , sm.cedula as cedula_padre  , sm.id_membresia as idMembresia3
							from socio_membresia as sm , membresia as m 
							where cedula = "'.$cedula.'"
							and sm.id_membresia = m.id
						';
				$res5 = mysql_query($sql5) or die (mysql_error());
				
				while($row5 = mysql_fetch_array($res5)){
					$valor_padre_ = $row5['valor_padre_'];
					
					
					if($valor_pagado >= $valor_padre_){
						$debePagar3 = $valor_padre_;
						$txt3 = 'Total';
					}else{
						$debePagar3 = $valor_pagado;
						$txt3 = 'Parcial';
					}
					
					
					$sqlI3 = 	'
						INSERT INTO `pagos_membresias` (`id`, `id_membresia`, `cedula`, `valor`, `forma_pago`, `fecha`, `estado`) 
						VALUES (NULL, "'.$row5['idMembresia3'].'", "'.$row5['cedula_padre'].'", "'.$debePagar3.'", "'.$forma_de_pago.'", "'.$hoy.'", "'.$txt3.'" );
					';
		
					// echo "<label style = 'color:#8892BF;' >".$sqlI3."</label><br>";
					$resI3 = mysql_query($sqlI3) or die (mysql_error());
				}
			}
			
		}
		echo 'Los pagos de las membresias se han prosesado con Éxito';
	}catch(PDOException $e){
		print_r($e);
	}
	

?>