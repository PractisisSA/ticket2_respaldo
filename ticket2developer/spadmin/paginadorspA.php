<?php
	date_default_timezone_set('America/Guayaquil');
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$data = $_REQUEST['sector'];
	if($data == 4){
		$idBuscador = $_REQUEST['dato'];
		if($idBuscador == 1){
			$ruc = $_REQUEST['ruc'];
			$select = "SELECT * FROM Socio WHERE rucS LIKE '%$ruc%'";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT * FROM Socio WHERE rucS LIKE '%$ruc%' LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td style="color:#fff;">
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre del Socio 2</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n</strong>
							</td>
							<td>
								<strong>Descripci&oacute;n</strong>
							</td>
							<td>
								<strong>C&oacute;digo del Establecimiento</strong>
							</td>
							<td>
								<strong>Acci&oacute;n</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					$cod = $row['nroestablecimientoS'];
					if((strlen($cod) == 1)){
						$codigo = '00'.$cod;
					}else{
						if((strlen($cod) == 2)){
							$codigo = '0'.$cod;
						}else{
							if((strlen($cod) > 2)){
								$codigo = $cod;
							}
						}
					}
					if($row['imprimirparaS'] == 'm'){
						$direccion = $row['direccionesS'];
					}else if($row['imprimirparaS'] == 's'){
						$direccion = $row['direstablecimientoS'];
					}
					echo '<tr>
							<td>
								'.$row['rucS'].'
							</td>
							<td>
								'.$row['nombresS'].'
							</td>
							<td>
								'.$row['razonsocialS'].'
							</td>
							<td>
								'.$direccion.'
							</td>
							<td>
								'.$row['descripciondirS'].'
							</td>
							<td>
								'.$codigo.'
							</td>
							<td>
								<center><button type="button" id="crear'.$row['idSocio'].'" class="btnlink" onclick="crearauto('.$row['idSocio'].')">Crear</button></center>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'">Anterior</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">Siguiente</a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td style="color:#fff;">
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre del Socio 3</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n</strong>
							</td>
							<td>
								<strong>Descripci&oacute;n</strong>
							</td>
							<td>
								<strong>C&oacute;digo del Establecimiento</strong>
							</td>
							<td>
								<strong>Acci&oacute;n</strong>
							</td>
						</tr>
						<trd>
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}else{
			if($idBuscador == 2){
				$nombre = $_REQUEST['nombre'];
				$select = "SELECT * FROM Socio WHERE razonsocialS LIKE '%$nombre%'";
				$stmt = $gbd -> prepare($select);
				$stmt -> execute();
				$num_total_registros = $stmt -> rowCount();
				// echo $num_total_registros;
				if($num_total_registros > 0){
					$rowsPerPage = 20;
					
					$pageNum = 1;
					
					if(isset($_REQUEST['page'])) {
						sleep(1);
						$pageNum = $_REQUEST['page'];
					}
					
					$offset = ($pageNum - 1) * $rowsPerPage;
					$total_paginas = ceil($num_total_registros / $rowsPerPage);
					
					$selectLimit = "SELECT * FROM Socio WHERE razonsocialS LIKE '%$nombre%' LIMIT $offset, $rowsPerPage";
					$query_services = $gbd -> prepare($selectLimit);
					$query_services -> execute();
					
					echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
							<tr style="color:#00ADEF;">
								<td>
								<strong>R.U.C.</strong>
								</td>
								<td style="color:#fff;">
									<strong>Nombre del Socio 4</strong>
								</td>
								<td>
									<strong>Nombre Comercial</strong>
								</td>
								<td>
									<strong>Direcci&oacute;n</strong>
								</td>
								<td>
									<strong>Descripci&oacute;n</strong>
								</td>
								<td>
									<strong>C&oacute;digo del Establecimiento</strong>
								</td>
								<td>
									<strong>Acci&oacute;n</strong>
								</td>
							</tr>';
					$i = 0;
					
					while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
						$cod = $row['nroestablecimientoS'];
						if((strlen($cod) == 1)){
							$codigo = '00'.$cod;
						}else{
							if((strlen($cod) == 2)){
								$codigo = '0'.$cod;
							}else{
								if((strlen($cod) > 2)){
									$codigo = $cod;
								}
							}
						}
						if($row['imprimirparaS'] == 'm'){
							$direccion = $row['direccionesS'];
						}else if($row['imprimirparaS'] == 's'){
							$direccion = $row['direstablecimientoS'];
						}
						echo '<tr>
								<td>
									'.$row['rucS'].'
								</td>
								<td>
									'.$row['nombresS'].'
								</td>
								<td>
									'.$row['razonsocialS'].'
								</td>
								<td>
									'.$direccion.'
								</td>
								<td>
									'.$row['descripciondirS'].'
								</td>
								<td>
									'.$codigo.'
								</td>
								<td>
									<center><button type="button" id="crear'.$row['idSocio'].'" class="btnlink" onclick="crearauto('.$row['idSocio'].')">Crear</button></center>
								</td>
							</tr>';
					}
					echo '</table>
						<br>
						<table align="center">
							<tr style="text-align:center;">
								<td colspan="5">';
									if ($total_paginas > 1) {
										echo '<div class="pagination">';
										echo '<ul>';
											if ($pageNum != 1)
													echo '<li><a class="paginate" data="'.($pageNum - 1).'">Anterior</a></li>';
												for ($i = 1; $i <= $total_paginas; $i++) {
													if ($pageNum == $i)
														echo '<li class="active"><a>'.$i.'</a></li>';
													else
														echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
											}
											if ($pageNum != $total_paginas)
													echo '<li><a class="paginate" data="'.($pageNum + 1).'">Siguiente</a></li>';
									   echo '</ul>';
									   echo '</div>';
									}
					echo'		</td>
							</tr>
							<tr>
								<td colspan="5" height="20px"></td>
							</tr>
						</table>';
				}else{
					echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
							<tr style="color:#00ADEF;">
								<td style="color:#fff;">
									<strong>R.U.C.</strong>
								</td>
								<td>
									<strong>Nombre del Socio 1</strong>
								</td>
								<td>
									<strong>Nombre Comercial</strong>
								</td>
								<td>
									<strong>Direcci&oacute;n</strong>
								</td>
								<td>
									<strong>Descripci&oacute;n</strong>
								</td>
								<td>
									<strong>C&oacute;digo del Establecimiento</strong>
								</td>
								<td>
									<strong>Acci&oacute;n</strong>
								</td>
							</tr>
							<tr>
								<td colspan="6" style="font-size:25px; color:#67E21B;">
									No hay Datos
								</td>
							</tr>
						</table>';
				}
			}
		}
	}
	
	if($data == 5){
		$idBuscador = $_REQUEST['dato'];
		if($idBuscador == 1){
			$ruc = $_REQUEST['ruc'];
			$select = "	SELECT rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, 
						registradoA FROM autorizaciones 
						WHERE rucAHIS LIKE '%$ruc%' order by idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "
									SELECT rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA,
									tipodocumentoA, registradoA FROM autorizaciones 
									WHERE rucAHIS LIKE '%$ruc%' 
									order by idAutorizacion DESC
									LIMIT $offset, $rowsPerPage
									
								";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td style="color:#fff;">
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha de Caducidad</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
							<td>
								<strong>Acci&oacute;n</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					if($row['registradoA'] == 'no'){
						$estado = 'Pendiente';
					}else if($row['registradoA'] == 'ok'){
						$estado = 'Completo';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechacaducidadA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).'
							</td>
							<td>
								'.$estado.'
							</td>
							<td>
								<button type="button" class="btnlink" id="abrirAuto" onclick="abrirAuto('.$row['nroautorizacionA'].')">Abrir</button>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'">Anterior</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">Siguiente</a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha de Caducidad</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>
						<trd>
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}else{
			if($idBuscador == 2){
				$nombre = $_REQUEST['nombre'];
				$select = "SELECT rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, registradoA FROM autorizaciones 
							WHERE nombrecomercialAHIS LIKE '%$nombre%'
							order by idAutorizacion DESC";
				$stmt = $gbd -> prepare($select);
				$stmt -> execute();
				$num_total_registros = $stmt -> rowCount();
				// echo $num_total_registros;
				if($num_total_registros > 0){
					$rowsPerPage = 20;
					
					$pageNum = 1;
					
					if(isset($_REQUEST['page'])) {
						sleep(1);
						$pageNum = $_REQUEST['page'];
					}
					
					$offset = ($pageNum - 1) * $rowsPerPage;
					$total_paginas = ceil($num_total_registros / $rowsPerPage);
					
					$selectLimit = "SELECT rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, registradoA FROM autorizaciones 
							WHERE nombrecomercialAHIS LIKE '%$nombre%' order by idAutorizacion DESC LIMIT $offset, $rowsPerPage";
					$query_services = $gbd -> prepare($selectLimit);
					$query_services -> execute();
					
					echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
							<tr style="color:#00ADEF;">
								<td>
									<strong>R.U.C.</strong>
								</td>
								<td style="color:#fff;">
									<strong>Nombre Comercial</strong>
								</td>
								<td>
									<strong>Fecha de Autorizaci&oacute;n</strong>
								</td>
								<td>
									<strong>Fecha de Caducidad</strong>
								</td>
								<td>
									<strong>Nro. de Autorizaci&oacute;n</strong>
								</td>
								<td>
									<strong>Tipo de Documento</strong>
								</td>
								<td>
									<strong>Estado</strong>
								</td>
								<td>
									<strong>Acci&oacute;n</strong>
								</td>
							</tr>';
					$i = 0;
					
					while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
						
						if($row['registradoA'] == 'no'){
							$estado = 'Pendiente';
						}else if($row['registradoA'] == 'ok'){
							$estado = 'Completo';
						}
						echo '<tr>
								<td>
									'.htmlspecialchars($row['rucAHIS']).'
								</td>
								<td>
									'.htmlspecialchars($row['nombrecomercialAHIS']).'
								</td>
								<td>
									'.htmlspecialchars($row['fechaautorizacioA']).'
								</td>
								<td>
									'.htmlspecialchars($row['fechacaducidadA']).'
								</td>
								<td>
									'.htmlspecialchars($row['nroautorizacionA']).'
								</td>
								<td>
									'.htmlspecialchars($row['tipodocumentoA']).'
								</td>
								<td>
									'.$estado.'
								</td>
								<td>
									<button type="button" class="btnlink" id="abrirAuto" onclick="abrirAuto('.$row['nroautorizacionA'].')">Abrir</button>
								</td>
							</tr>';
					}
					echo '</table>
						<br>
						<table align="center">
							<tr style="text-align:center;">
								<td colspan="5">';
									if ($total_paginas > 1) {
										echo '<div class="pagination">';
										echo '<ul>';
											if ($pageNum != 1)
													echo '<li><a class="paginate" data="'.($pageNum - 1).'">Anterior</a></li>';
												for ($i = 1; $i <= $total_paginas; $i++) {
													if ($pageNum == $i)
														echo '<li class="active"><a>'.$i.'</a></li>';
													else
														echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
											}
											if ($pageNum != $total_paginas)
													echo '<li><a class="paginate" data="'.($pageNum + 1).'">Siguiente</a></li>';
									   echo '</ul>';
									   echo '</div>';
									}
					echo'		</td>
							</tr>
							<tr>
								<td colspan="5" height="20px"></td>
							</tr>
						</table>';
				}else{
					echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
							<tr style="color:#00ADEF;">
								<td>
									<strong>R.U.C.</strong>
								</td>
								<td style="color:#fff;">
									<strong>Nombre Comercial</strong>
								</td>
								<td>
									<strong>Fecha de Autorizaci&oacute;n</strong>
								</td>
								<td>
									<strong>Fecha de Caducidad</strong>
								</td>
								<td>
									<strong>Nro. de Autorizaci&oacute;n</strong>
								</td>
								<td>
									<strong>Tipo de Documento</strong>
								</td>
								<td>
									<strong>Estado</strong>
								</td>
							</tr>
							<trd>
								<td colspan="7" style="font-size:25px; color:#67E21B;">
									No hay Datos
								</td>
							</tr>
						</table>';
				}
			}
		}
	}
	
	//paginador registro
	if($data == 6){
		$idBuscador = $_REQUEST['dato'];
		if($idBuscador == 1){
			$select = "SELECT rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT rucAHIS, idAutorizacion, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones ORDER BY idAutorizacion DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Registrar /<br>Cerrar Trabajo</strong>
							</td>
							<td>
								<strong>Ver</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					if($row['registradoA'] == 'ok'){
						$class = 'btndisabled';
						$prop = 'disabled="disabled"';
						$text = 'Trabajo Cerrado';
					}else{
						$class = 'btnlink';
						$prop = '';
						$text = 'Cerrar Trabajo';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).'
							</td>
							<td>
								<button type="button" class="'.$class.'" '.$prop.' id="editTransaccion" onclick="editTransaccion('.$row['idAutorizacion'].')">'.$text.'</button>
							</td>
							<td>
								<button type="button" class="btnlink" id="openAuto" onclick="openAuto('.$row['idAutorizacion'].')">Abrir</button>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Registrar / <br>Cerrar Trabajo</strong>
							</td>
							<td>
								<strong>Ver</strong>
							</td>
						</tr>
						<trd>
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		if($idBuscador == 2){
			$ruc = $_REQUEST['ruc'];
			$select = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE rucAHIS LIKE '%$ruc%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE rucAHIS LIKE '%$ruc%' ORDER BY idAutorizacion DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td style="color:#fff;">
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Registrar</strong>
							</td>
							<td>
								<strong>Ver</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					if($row['registradoA'] == 'ok'){
						$class = 'btndisabled';
						$prop = 'disabled="disabled"';
						$text = 'Trabajo Cerrado';
					}else{
						$class = 'btnlink';
						$prop = '';
						$text = 'Cerrar Trabajo';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).'
							</td>
							<td>
								<button type="button" class="'.$class.'" '.$prop.' id="editTransaccion" onclick="editTransaccion('.$row['idAutorizacion'].')">'.$text.'</button>
							</td>
							<td>
								<button type="button" class="btnlink" id="openAuto" onclick="openAuto('.$row['idAutorizacion'].')">Abrir</button>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Registrar</strong>
							</td>
							<td>
								<strong>Ver</strong>
							</td>
						</tr>
						<trd>
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		if($idBuscador == 3){
			$nombre = $_REQUEST['nombre'];
			$select = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE nombrecomercialAHIS LIKE '%$nombre%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE nombrecomercialAHIS LIKE '%$nombre%' ORDER BY idAutorizacion DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td style="color:#fff;">
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Registrar</strong>
							</td>
							<td>
								<strong>Ver</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					if($row['registradoA'] == 'ok'){
						$class = 'btndisabled';
						$prop = 'disabled="disabled"';
						$text = 'Trabajo Cerrado';
					}else{
						$class = 'btnlink';
						$prop = '';
						$text = 'Cerrar Trabajo';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).'
							</td>
							<td>
								<button type="button" class="'.$class.'" '.$prop.' id="editTransaccion" onclick="editTransaccion('.$row['idAutorizacion'].')">'.$text.'</button>
							</td>
							<td>
								<button type="button" class="btnlink" id="openAuto" onclick="openAuto('.$row['idAutorizacion'].')">Abrir</button>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Registrar</strong>
							</td>
							<td>
								<strong>Ver</strong>
							</td>
						</tr>
						<trd>
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		if($idBuscador == 4){
			$numautorizacion = $_REQUEST['numautorizacion'];
			$select = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE nroautorizacionA LIKE '%$numautorizacion%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE nroautorizacionA LIKE '%$numautorizacion%' ORDER BY idAutorizacion DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Registrar</strong>
							</td>
							<td>
								<strong>Ver</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					if($row['registradoA'] == 'ok'){
						$class = 'btndisabled';
						$prop = 'disabled="disabled"';
						$text = 'Trabajo Cerrado';
					}else{
						$class = 'btnlink';
						$prop = '';
						$text = 'Cerrar Trabajo';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).'
							</td>
							<td>
								<button type="button" class="'.$class.'" '.$prop.' id="editTransaccion" onclick="editTransaccion('.$row['idAutorizacion'].')">'.$text.'</button>
							</td>
							<td>
								<button type="button" class="btnlink" id="openAuto" onclick="openAuto('.$row['idAutorizacion'].')">Abrir</button>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Registrar</strong>
							</td>
							<td>
								<strong>Ver</strong>
							</td>
						</tr>
						<trd>
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
	}
	
	//paginador reimpresiones
	if($data == 7){
		$idBuscador = $_REQUEST['dato'];
		if($idBuscador == 2){
			$ruc = $_REQUEST['ruc'];
			$select = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE rucAHIS LIKE '%$ruc%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE rucAHIS LIKE '%$ruc%' ORDER BY idAutorizacion DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td style="color:#fff;">
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Reimprimir</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if($row['registradoA'] == 'ok'){
						$class = 'btndisabled';
						$prop = 'disabled="disabled"';
					}else{
						$class = 'btnlink';
						$prop = '';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).'
							</td>
							<td>
								<button type="button" class="'.$class.'" '.$prop.' id="reimprimir" onclick="reimprimir('.$row['idAutorizacion'].')">Reimprimir</button>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Reimprimir</strong>
							</td>
						</tr>
						<trd>
							<td colspan="6" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		if($idBuscador == 3){
			$nombre = $_REQUEST['nombre'];
			$select = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE nombrecomercialAHIS LIKE '%$nombre%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE nombrecomercialAHIS LIKE '%$nombre%' ORDER BY idAutorizacion DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td style="color:#fff;">
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Registrar</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if($row['registradoA'] == 'ok'){
						$class = 'btndisabled';
						$prop = 'disabled="disabled"';
					}else{
						$class = 'btnlink';
						$prop = '';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).'
							</td>
							<td>
								<button type="button" class="'.$class.'" '.$prop.' id="reimprimir" onclick="reimprimir('.$row['idAutorizacion'].')">Reimprimir</button>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Reimprimir</strong>
							</td>
						</tr>
						<trd>
							<td colspan="6" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		if($idBuscador == 4){
			$numautorizacion = $_REQUEST['numautorizacion'];
			$select = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE nroautorizacionA LIKE '%$numautorizacion%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, estadoAuto, registradoA FROM autorizaciones WHERE nroautorizacionA LIKE '%$numautorizacion%' ORDER BY idAutorizacion DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Registrar</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if($row['registradoA'] == 'ok'){
						$class = 'btndisabled';
						$prop = 'disabled="disabled"';
					}else{
						$class = 'btnlink';
						$prop = '';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).'
							</td>
							<td>
								<button type="button" class="'.$class.'" '.$prop.' id="reimprimir" onclick="reimprimir('.$row['idAutorizacion'].')">Reimprimir</button>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Reimprimir</strong>
							</td>
						</tr>
						<trd>
							<td colspan="6" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
	}
	
	//paginador para la impresion de documentos
	if($data == 8){
		$idBuscador = $_REQUEST['dato'];
		if($idBuscador == 1){
		$select = "SELECT rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, facnegociablesA, tipodocumentoA, secuencialinicialA, secuencialfinalA, estadoimpresionA FROM autorizaciones";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					// echo $_REQUEST['page']."<br>";
					sleep(1);
					$ident = $_REQUEST['ident'];
					
					if($_REQUEST['page'] == '333444555'){
						// $pageNum = $_REQUEST['page'];
						$total_paginas = ceil($num_total_registros / $rowsPerPage);
						$filtros = '';
					}else{
						$pageNum = $_REQUEST['page'];
						$offset = ($pageNum - 1) * $rowsPerPage;
						$total_paginas = ceil($num_total_registros / $rowsPerPage);
						$filtros = "LIMIT ".$offset.", ".$rowsPerPage;
					}
					
				}
				
				// echo $filtros."<br>";
				// echo $num_total_registros."  >><< ".$rowsPerPage;
				
				$selectLimit = "SELECT rucAHIS, idAutorizacion, nombrecomercialAHIS, fechaautorizacioA, facnegociablesA, 
								nroautorizacionA, tipodocumentoA, secuencialinicialA, secuencialfinalA, estadoimpresionA ,
								inicialimpresoA  , finalimpresoA 
								FROM autorizaciones 
								ORDER BY idAutorizacion DESC
								$filtros";
				// echo $selectLimit."<br>";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Secuencial<br>Inicial - Final</strong>
							</td>
							<td>
								<strong>Secuencial<br>Inicial - Final Informado</strong>
							</td>
							<td>
								<strong>Imprimir</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					if(($row['tipodocumentoA'] == 'Factura') && ($row['facnegociablesA'] == 'si')){
						$nego = 'Negociable';
					}else{
						$nego = '';
					}
					if($row['estadoimpresionA'] == 'impreso' ){
						$clase='btndisabled';
						$texto = 'Impreso';
					}else{
						$clase='btnlink';
						$texto = 'Imprimir';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).' '.$nego.'
							</td>
							<td>
								'.$row['secuencialinicialA'].' - '.$row['secuencialfinalA'].'
							</td>
							
							<td>
								'.$row['inicialimpresoA'].' - '.$row['finalimpresoA'].'
							</td>
							<td>
								<button id="confirmarPrint" onclick="cargarSecuencia('.$row['idAutorizacion'].')" class="'.$clase.'">'.$texto.'</button>
								<img src="imagenes/loading.gif" width="20px" id="wait" style="display:none;"/>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										
										echo '<li><a class="paginate" data="333444555">Todos</a></li>';
										
										
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Secuencial/strong>
							</td>
							<td>
								<strong>Imprimir</strong>
							</td>
						</tr>
						<tr>
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		if($idBuscador == 2){
			$ruc = $_REQUEST['ruc'];
			$select = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, facnegociablesA, tipodocumentoA, secuencialinicialA, secuencialfinalA, estadoimpresionA FROM autorizaciones WHERE rucAHIS LIKE '%$ruc%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, facnegociablesA, tipodocumentoA, secuencialinicialA, secuencialfinalA, estadoimpresionA FROM autorizaciones WHERE rucAHIS LIKE '%$ruc%' ORDER BY idAutorizacion DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td style="color:#fff;">
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Secuencial<br>Inicial - Final</strong>
							</td>
							<td>
								<strong>Imprimir</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(($row['tipodocumentoA'] == 'Factura') && ($row['facnegociablesA'] == 'si')){
						$nego = 'Negociable';
					}else{
						$nego = '';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).' '.$nego.'
							</td>
							<td>
								'.$row['secuencialinicialA'].' - '.$row['secuencialfinalA'].'
							</td>
							<td>
								<button id="confirmarPrint" onclick="cargarSecuencia('.$row['idAutorizacion'].')" class="btnlink">Imprimir</button>
								<img src="imagenes/loading.gif" width="20px" id="wait" style="display:none;"/>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Secuencial</strong>
							</td>
							<td>
								<strong>Imprimir</strong>
							</td>
						</tr>
						<tr>
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		if($idBuscador == 3){
			$nombre = $_REQUEST['nombre'];
			$select = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, facnegociablesA, tipodocumentoA, secuencialinicialA, secuencialfinalA, estadoimpresionA FROM autorizaciones WHERE nombrecomercialAHIS LIKE '%$nombre%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, facnegociablesA, tipodocumentoA, secuencialinicialA, secuencialfinalA, estadoimpresionA FROM autorizaciones WHERE nombrecomercialAHIS LIKE '%$nombre%' ORDER BY idAutorizacion DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td style="color:#fff;">
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Secuencial<br>Inicial - Final</strong>
							</td>
							<td>
								<strong>Imprimir</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(($row['tipodocumentoA'] == 'Factura') && ($row['facnegociablesA'] == 'si')){
						$nego = 'Negociable';
					}else{
						$nego = '';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).' '.$nego.'
							</td>
							<td>
								'.$row['secuencialinicialA'].' - '.$row['secuencialfinalA'].'
							</td>
							<td>
								<button id="confirmarPrint" onclick="cargarSecuencia('.$row['idAutorizacion'].')" class="btnlink">Imprimir</button>
								<img src="imagenes/loading.gif" width="20px" id="wait" style="display:none;"/>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Secuencial</strong>
							</td>
							<td>
								<strong>Imprimir</strong>
							</td>
						</tr>
						<tr>
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		if($idBuscador == 4){
			$numautorizacion = $_REQUEST['numautorizacion'];
			$select = "SELECT * FROM autorizaciones WHERE nroautorizacionA LIKE '%$numautorizacion%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT * FROM autorizaciones WHERE nroautorizacionA LIKE '%$numautorizacion%' ORDER BY idAutorizacion DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Secuencial<br>Inicial - Final</strong>
							</td>
							
							<td>
								<strong>Secuencial<br>Inicial - Final Informado </strong>
							</td>
							<td>
								<strong>Imprimir</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					if($row['estadoimpresionA'] == 'impreso' ){
						$clase='btndisabled';
						$texto = 'Impreso';
					}else{
						$clase='btnlink';
						$texto = 'Imprimir';
					}
					
					
					if(($row['tipodocumentoA'] == 'Factura') && ($row['facnegociablesA'] == 'si')){
						$nego = 'Negociable';
					}else{
						$nego = '';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).' '.$nego.'
							</td>
							<td>
								'.$row['secuencialinicialA'].' - '.$row['secuencialfinalA'].'
							</td>
							
							<td>
								'.$row['inicialimpresoA'].' - '.$row['finalimpresoA'].'
							</td>
							<td>
								<button id="confirmarPrint" onclick="cargarSecuencia('.$row['idAutorizacion'].')" class="'.$clase.'">'.$texto.'</button>
								<img src="imagenes/loading.gif" width="20px" id="wait" style="display:none;"/>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Secuencial</strong>
							</td>
							<td>
								<strong>Imprimir</strong>
							</td>
						</tr>
						<tr>
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		if($idBuscador == 5){
			$td = $_REQUEST['tipDoc'];
			if($td == 1){
				$tipdoc = 'Factura';
			}else if($td == 2){
				$tipdoc = 'Boleto';
			}else if($td == 3){
				$tipdoc = 'Nota de Credito';
			}else if($td == 4){
				$tipdoc = 'Nota de Debito';
			}else if($td == 5){
				$tipdoc = 'Nota de Venta';
			}else if($td == 6){
				$tipdoc = 'Liquidacion de Compras';
			}else if($td == 7){
				$tipdoc = 'Guia de Remision';
			}else if($td == 8){
				$tipdoc = 'Comprobante Retencion';
			}else if($td == 9){
				$tipdoc = 'Taximetros y Registradoras';
			}else if($td == 10){
				$tipdoc = 'LC Bienes Muebles usados';
			}else if($td == 11){
				$tipdoc = 'LC Vehiculos usados';
			}else if($td == 12){
				$tipdoc = 'Acta entrega/recepcion';
			}
			
			$select = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, facnegociablesA, tipodocumentoA, secuencialinicialA, secuencialfinalA, estadoimpresionA FROM autorizaciones WHERE tipodocumentoA LIKE '%$tipdoc%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_REQUEST['page'])) {
					sleep(1);
					$pageNum = $_REQUEST['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idAutorizacion, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, nroautorizacionA, facnegociablesA, tipodocumentoA, secuencialinicialA, secuencialfinalA, estadoimpresionA FROM autorizaciones WHERE tipodocumentoA LIKE '%$tipdoc%' ORDER BY idAutorizacion DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Secuencial<br>Inicial - Final</strong>
							</td>
							<td>
								<strong>Imprimir</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(($row['tipodocumentoA'] == 'Factura') && ($row['facnegociablesA'] == 'si')){
						$nego = 'Negociable';
					}else{
						$nego = '';
					}
					echo '<tr>
							<td>
								'.htmlspecialchars($row['rucAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['nombrecomercialAHIS']).'
							</td>
							<td>
								'.htmlspecialchars($row['fechaautorizacioA']).'
							</td>
							<td>
								'.htmlspecialchars($row['nroautorizacionA']).'
							</td>
							<td>
								'.htmlspecialchars($row['tipodocumentoA']).' '.$nego.'
							</td>
							<td>
								'.$row['secuencialinicialA'].' - '.$row['secuencialfinalA'].'
							</td>
							<td>
								<button id="confirmarPrint" onclick="cargarSecuencia('.$row['idAutorizacion'].')" class="btnlink">Imprimir</button>
								<img src="imagenes/loading.gif" width="20px" id="wait" style="display:none;"/>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table align="center">
						<tr style="text-align:center;">
							<td colspan="5">';
								if ($total_paginas > 1) {
									echo '<div class="pagination">';
									echo '<ul>';
										if ($pageNum != 1)
												echo '<li><a class="paginate" data="'.($pageNum - 1).'"><<</a></li>';
											for ($i = 1; $i <= $total_paginas; $i++) {
												if ($pageNum == $i)
													echo '<li class="active"><a>'.$i.'</a></li>';
												else
													echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
										}
										if ($pageNum != $total_paginas)
												echo '<li><a class="paginate" data="'.($pageNum + 1).'">>></a></li>';
								   echo '</ul>';
								   echo '</div>';
								}
				echo'		</td>
						</tr>
						<tr>
							<td colspan="5" height="20px"></td>
						</tr>
					</table>';
			}else{
				echo '<table style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Secuencial</strong>
							</td>
							<td>
								<strong>Imprimir</strong>
							</td>
						</tr>
						<tr>
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
	}
?>