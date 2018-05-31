<?php
	session_start();
	date_default_timezone_set("America/Guayaquil");
	include '../conexion.php';
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	date_default_timezone_set('America/Guayaquil');

	try{
		$recibeExcel2 = $_REQUEST['recibeExcel2'];
		// $id_membresia = $_REQUEST['id_membresia'];
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
		
		
		
		// echo $rowS['valor'];
		
		$today = date("Y-m-d H:i:s");  
		$table = '<table border = "1">';
			$table .='<tr>';
				$table .='<td>';
					$table .='ID';
				$table .='</td>';
				
				$table .='<td>';
					$table .='MEMBRESIA';
				$table .='</td>';
				
				$table .='<td>';
					$table .='CEDULA';
				$table .='</td>';
				
				$table .='<td>';
					$table .='NOMBRE';
				$table .='</td>';
				
				$table .='<td>';
					$table .='APELLIDO';
				$table .='</td>';
				
				$table .='<td>';
					$table .='FORMA DE PAGO';
				$table .='</td>';
				
				$table .='<td>';
					$table .='INICIO TODOS';
				$table .='</td>';
				
				
				
				$table .='<td>';
					$table .='INICIA DESDE';
				$table .='</td>';
				
				
				$table .='<td>';
					$table .='PRIMER PAGO';
				$table .='</td>';
				
				
				$table .='<td>';
					$table .='MESES PAGADOS';
				$table .='</td>';
				
				$table .='<td>';
					$table .='DEBIO PAGAR';
				$table .='</td>';
				
				$table .='<td>';
					$table .='DEUDA';
				$table .='</td>';
				
				$table .='<td>';
					$table .='PATROCINADOR';
				$table .='</td>';
			$table .='</tr>';
		for($row = 2; $row <= $highestRow; ++$row){
			
			
			$id = $objWorksheet->getCellByColumnAndRow(0,$row)->getValue();
			$id_membre = $objWorksheet->getCellByColumnAndRow(1,$row)->getValue();
			$cedula = $objWorksheet->getCellByColumnAndRow(2,$row)->getValue();
			$nombre = $objWorksheet->getCellByColumnAndRow(3,$row)->getValue();
			$apellido = $objWorksheet->getCellByColumnAndRow(4,$row)->getValue();
			$forma = $objWorksheet->getCellByColumnAndRow(5,$row)->getValue();
			$inicio = $objWorksheet->getCellByColumnAndRow(6,$row)->getValue();
			$no_aplica = $objWorksheet->getCellByColumnAndRow(7,$row)->getValue();
			$pagado = $objWorksheet->getCellByColumnAndRow(8,$row)->getValue();
			$haber = $objWorksheet->getCellByColumnAndRow(9,$row)->getValue();
			$debe = $objWorksheet->getCellByColumnAndRow(10,$row)->getValue();
			$patrocinio = $objWorksheet->getCellByColumnAndRow(11,$row)->getValue();
			
			if($no_aplica == 0){
				$sumaMeses = $no_aplica;
			}else{
				$sumaMeses = ($no_aplica-1);
			}
			$fecha = date('2016-01-01');
			$nuevafecha = strtotime ( '+'.$sumaMeses.' month' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
			
			
			$table .='<tr>';
				$table .='<td>';
					$table .=''.$id.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .=''.$id_membre.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .=''.$cedula.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .=''.$nombre.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .=''.$apellido.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .=''.$forma.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .='('.$inicio.') 2016-01-01';
				$table .='</td>';
				
				
				
				$table .='<td>';
					$table .=''.$no_aplica.'';
				$table .='</td>';
				
				
				$table .='<td>';
					$table .=''.$nuevafecha.'';
				$table .='</td>';
				
				
				$table .='<td>';
					$table .=''.$pagado.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .=''.$haber.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .=''.$debe.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .=''.$patrocinio.'';
				$table .='</td>';
			$table .='</tr>';
			
			
			$sqlS = 'SELECT * FROM `membresia` WHERE `id` = "'.$id_membre.'" ORDER BY `id` DESC ';
			$resS = mysql_query($sqlS) or die (mysql_error());
			$rowS = mysql_fetch_array($resS);
			
			$sqlC  ='select count(idCliente) as cuantos , idCliente from Cliente where strDocumentoC = "'.$cedula.'" ';
			$resC = mysql_query($sqlC) or die (mysql_error());
			$rowC = mysql_fetch_array($resC);
			
			if($rowC['cuantos'] > 0){
				$idCliente = $rowC['idCliente'];
			}else{
				$idCliente = 0;
			}
			
			
			$sqlSM = 'select count(id) as cuantos from socio_membresia where cedula = "'.$cedula.'" ';
			$resSM = mysql_query($sqlSM) or die (mysql_error());
			$rowSM = mysql_fetch_array($resSM);
			
			$today = date("Y-m-d");
			
			
			if($rowSM['cuantos'] == 0){
				$sqlISM = '
							INSERT INTO `socio_membresia` (`id`, `id_membresia`, `cedula`, `id_cliente`, `nombre`, `apellido`, `tipo`, `valor`, `forma_pago`, `estado`, `meses_mora`, `t_deuda`, `fecha_compra`, `patrocinador`) 
							VALUES (NULL, "'.$id_membre.'" , "'.$cedula.'" , "'.$idCliente.'" , "'.$nombre.'" , "'.$apellido.'" , "1" , "'.$rowS['valor_mensual'].'" , "'.$forma.'" , "1" , "0" , "0" , "'.$today.'" , "'.$patrocinio.'" )
						';
				$resISM = mysql_query($sqlISM) or die (mysql_error());
				// echo "<label style = 'color:red;'>".$sqlISM."</label><br>";
			}
			
			
			
			for($j=0;$j<=$pagado-1;$j++){
				if($j==0){
					$fpago = 'inicial';
					
					$fecha2= date(''.$nuevafecha.'');
					$fechapago = strtotime ( '+1 month' , strtotime ( $fecha2 ) ) ;
					$fechapago = date ( 'Y-m-j' , $fechapago );
					
					
					// $fechapago = $nuevafecha;
					$color = 'blue';
				}else{
					$fpago = $forma;
					
					$fecha2= date(''.$nuevafecha.'');
					$fechapago = strtotime ( '+'.($j+1).' month' , strtotime ( $fecha2 ) ) ;
					$fechapago = date ( 'Y-m-j' , $fechapago );
					$color = 'red';
				}
				$sqlP = '
							insert into pagos_membresias (id_membresia , cedula , valor , forma_pago , fecha , estado )
							values ("'.$id_membre.'" , "'.$cedula.'" , "'.$rowS['valor_mensual'].'" , "'.$fpago.'" , "'.$fechapago.'" , "total")
						';
				$resP = mysql_query($sqlP) or die (mysql_error());
				// echo "<label style = 'color:".$color.";' >".$sqlP."</label><br><br>";
			}
		}
		$table .='</table>';
		
		// echo $table;
		echo 'socios procesados con exito';
		// echo $cedulaAcumuladas;
		// $sql = 'SELECT * FROM `socio_membresia` WHERE `cedula` NOT IN ('.$cedulaAcumuladas.') and id_membresia = "'.$id_membresia.'" ORDER BY `id_membresia` ASC ';
		// $res = mysql_query($sql) or die (mysql_error());
		// while($row = mysql_fetch_array($res)){
			// $sql1 = 'update socio_membresia set estado = 0 where id = "'.$row['id'].'" ';
			// // echo $sql1."<br>";
			// $res1 = mysql_query($sql1) or die (mysql_error());
			
			// $sql2 = '	INSERT INTO `cartera_socios` (`id`, `cedula`, `valor`, `fecha`, `estado`) 
						// VALUES (NULL, "'.$row['cedula'].'",  "'.$rowS['valor_mensual'].'",  "'.$today.'",  "1"  )';
			// $res2 = mysql_query($sql2) or die (mysql_error());
		// }
		
	}catch(PDOException $e){
		print_r($e);
	}
	

?>