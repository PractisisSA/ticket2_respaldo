<?php
	session_start();
	date_default_timezone_set("America/Guayaquil");
	include '../conexion.php';
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	date_default_timezone_set('America/Guayaquil');

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
		
		
		
		// echo $rowS['valor'];
		
		$dia = date("d");  
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
					$table .='VALOR MEMBRESIA';
				$table .='</td>';
				
				$table .='<td>';
					$table .='VALOR PAGADO';
				$table .='</td>';
				
				
				$table .='<td>';
					$table .='FORMA DE PAGO';
				$table .='</td>';
				
				$table .='<td>';
					$table .='PATROCINADOR ';
				$table .='</td>';
				
				
				$table .='<td>';
					$table .='FECHA DE PAGO ';
				$table .='</td>';
				
				
			$table .='</tr>';
		for($row = 2; $row <= $highestRow; ++$row){
			
			
			$id = $objWorksheet->getCellByColumnAndRow(0,$row)->getValue();
			$id_membre = $objWorksheet->getCellByColumnAndRow(1,$row)->getValue();
			$cedula = $objWorksheet->getCellByColumnAndRow(2,$row)->getValue();
			$valor_membresia = $objWorksheet->getCellByColumnAndRow(3,$row)->getValue();
			$valor_pagado = $objWorksheet->getCellByColumnAndRow(4,$row)->getValue();
			$forma = $objWorksheet->getCellByColumnAndRow(5,$row)->getValue();
			$patrocinador = $objWorksheet->getCellByColumnAndRow(6,$row)->getValue();
			$fecha_pago = $objWorksheet->getCellByColumnAndRow(7,$row)->getValue();
			
			$expPatrocinador = explode("#",$patrocinador);
			$diferenciaPago = ($valor_pagado - $valor_membresia);
			
			$cuantos = count($expPatrocinador);
			$cuantos1 = count($expPatrocinador);
			
			for($i=0;$i<=count($expPatrocinador)-1;$i++){
				
				$exp2 = explode(">><<",$expPatrocinador[$i]);
				
				$cedP = $exp2[0];
				$id_membre = $exp2[1];
				$valor_membre = $exp2[2];
				$pagos = ($diferenciaPago / $cuantos);
				
				if($valor_membre == $pagos){
					$txt = "total";
				}elseif($valor_membre > $pagos){
					$txt = "parcial";
				}
				
				
				
				echo "patrocinador : ".$cedula."  <<>>  ".$cedP." <<>>  ".$id_membre." <<>>  ".$valor_membre."  <<>>  ".$pagos." <<>>  ".$txt."<br>";
				
				$cuantos1--;
			}
			
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
					$table .=''.$valor_membresia.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .=''.$valor_pagado.'';
				$table .='</td>';
				
				
				$table .='<td>';
					$table .=''.$forma.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .=''.$patrocinador.'';
				$table .='</td>';
				
				$table .='<td>';
					$table .=''.$diferenciaPago.'';
				$table .='</td>';

			$table .='</tr>';
		}
		$table .='</table>';
		
		echo $table;
		// echo 'cobros de membresias realizados con exito';
		
	}catch(PDOException $e){
		print_r($e);
	}
	

?>