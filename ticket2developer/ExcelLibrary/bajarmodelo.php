<?php
		/** Se agrega la libreria PHPExcel */
		require_once 'Classes/PHPExcel.php';
		// Se crea el objeto PHPExcel
		$objPHPExcel = new PHPExcel();
		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("Practisis 3.0") // Nombre del autor
		->setLastModifiedBy("Practisis 3.0") //Ultimo usuario que lo modificó
		->setTitle("ModeloCompra") // Titulo
		->setSubject("ModeloCompra") //Asunto
		->setDescription("Modelo para subir compras") //Descripción
		->setKeywords("Modelo Compras".time()) //Etiquetas
		->setCategory("Modelo Excel"); //Categorias
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells("A1:C1");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',"MODELO DE COMPRAS"); // Titulo del reporte
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',"CODIGO BARRAS");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2',"CANTIDAD");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2',"TOTAL");
		$estiloTitulo=array(
			'font'=>array(
				'name'=>'Myriad Pro',
				'bold'=>true,
				'color'=>array('rgb'=>'077877'),
				'size'=>'16'
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);
		$estiloTituloColumnas = array(
			'font' => array(
				'name'  => 'Myriad Pro',
				'bold'  => false,
				'color' => array(
				'rgb' => 'FFFFFF'
				),
				'size'=>'10'
			),
			'fill' => array(
				'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
			'rotation'   => 90,
				'startcolor' => array(
					'rgb' => '00a5aa'
				),
				'endcolor' => array(
					'argb' => 'FF077877'
				)
			),
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
					'color' => array(
						'rgb' => '00a5aa'
					)
				),
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
					'color' => array(
						'rgb' => '077877'
					)
				)
			),
			'alignment' =>  array(
				'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'      => false
			)
		);
		$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($estiloTituloColumnas);
		//$objPHPExcel->getActiveSheet()->getStyle('A4:F4')->applyFromArray($estilotexto);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($estiloTitulo);
		// Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="ModeloCompra'.time().'.xlsx"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
		$objWriter->save('php://output');
		exit;
?>