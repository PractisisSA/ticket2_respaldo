<?php 
	date_default_timezone_set('America/Guayaquil');
	require_once '../../classes/private.db.php';
	
	$gbd = new DBConn();
	$data = $_REQUEST['paginador'];
	
	//Paginador cobros
	if($data == 1){
		$idBuscador = $_REQUEST['id'];
		if($idBuscador == 1){
			//Aqui recibo los paremtros
			$documento = $_REQUEST['documento'];
			
			//Hago la consulta que me permitira saber si hay registros con esas condiciones
			$select = "SELECT strNombresC, strMailC, strDocumentoC, strEvento, strDescripcionL, codigoPV, estadoPV, estadopagoPV FROM pventa p JOIN Cliente c ON p.clientePV = c.idCliente JOIN Concierto co ON p.conciertoPV = co.idConcierto JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE strDocumentoC LIKE '%$documento%' GROUP BY codigoPV ORDER BY idPventa DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT strNombresC, strMailC, strDocumentoC, strEvento, strDescripcionL, codigoPV, estadoPV, estadopagoPV FROM pventa p JOIN Cliente c ON p.clientePV = c.idCliente JOIN Concierto co ON p.conciertoPV = co.idConcierto JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE strDocumentoC LIKE '%$documento%' GROUP BY codigoPV ORDER BY idPventa DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Nombres</strong>
							</td>
							<td style="color:#fff;">
								<strong>Documento</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Concierto</strong>
							</td>
							<td>
								<strong>Localidad</strong>
							</td>
							<td>
								<strong>Código de Compra</strong>
							</td>
							<td>
								<strong>Acción</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(($row['estadoPV'] == 'Revisado') && ($row['estadopagoPV'] == 'ok')){
						$title = 'Cobrado';
						$disabled = 'disabled="disabled"';
						$class = 'btndisabled';
					}else if(($row['estadoPV'] == 'Revisado') && ($row['estadopagoPV'] != 'ok')){
						$title = 'Cobrar';
						$disabled = '';
						$class = 'btnlink';
					}else{
						$title = 'Cobrar';
						$disabled = '';
						$class = 'btnlink';
					}
					echo '<tr>
							<td>
								'.$row['strNombresC'].'
							</td>
							<td>
								'.$row['strDocumentoC'].'
							</td>
							<td>
								'.$row['strMailC'] .'
							</td>
							<td>
								'.$row['strEvento'].'
							</td>
							<td>
								'.$row['strDescripcionL'].'
							</td>
							<td>
								'.$row['codigoPV'].'
							</td>
							<td>
								<button type="button" '.$disabled.' class="'.$class.'" onclick="cobrar('.$row['codigoPV'].')">'.$title.'</button>
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
						<tr>
							<td>
								<strong>Nombres</strong>
							</td>
							<td>
								<strong>Documento</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Concierto</strong>
							</td>
							<td>
								<strong>Localidad</strong>
							</td>
							<td>
								<strong>Código de Compra</strong>
							</td>
							<td>
								<strong>Acción</strong>
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
			$codigo = $_REQUEST['codigo'];
			$select = "SELECT strNombresC, strMailC, strDocumentoC, strEvento, strDescripcionL, codigoPV, estadoPV, estadopagoPV FROM pventa p JOIN Cliente c ON p.clientePV = c.idCliente JOIN Concierto co ON p.conciertoPV = co.idConcierto JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE codigoPV LIKE '%$codigo%' GROUP BY codigoPV ORDER BY idPventa DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 25;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT strNombresC, strMailC, strDocumentoC, strEvento, strDescripcionL, codigoPV, estadoPV, estadopagoPV FROM pventa p JOIN Cliente c ON p.clientePV = c.idCliente JOIN Concierto co ON p.conciertoPV = co.idConcierto JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE codigoPV LIKE '%$codigo%' GROUP BY codigoPV ORDER BY idPventa DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Nombres</strong>
							</td>
							<td>
								<strong>Documento</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Concierto</strong>
							</td>
							<td>
								<strong>Localidad</strong>
							</td>
							<td style="color:#fff;">
								<strong>Código de Compra</strong>
							</td>
							<td>
								<strong>Acción</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(($row['estadoPV'] == 'Revisado') && ($row['estadopagoPV'] == 'ok')){
						$title = 'Cobrado';
						$disabled = 'disabled="disabled"';
						$class = 'btndisabled';
					}else if(($row['estadoPV'] == 'Revisado') && ($row['estadopagoPV'] == 'reserva')){
						$title = 'Cobrar';
						$disabled = '';
						$class = 'btnlink';
					}else{
						$title = 'Cobrar';
						$disabled = '';
						$class = 'btnlink';
					}

					echo '<tr>
							<td>
								'.$row['strNombresC'].'
							</td>
							<td>
								'.$row['strDocumentoC'].'
							</td>
							<td>
								'.$row['strMailC'] .'
							</td>
							<td>
								'.$row['strEvento'].'
							</td>
							<td>
								'.$row['strDescripcionL'].'
							</td>
							<td>
								'.$row['codigoPV'].'
							</td>
							<td>
								<button type="button" '.$disabled.' class="'.$class.'" onclick="cobrar('.$row['codigoPV'].')">'.$title.'</button>
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
						<tr>
							<td>
								<strong>Nombres</strong>
							</td>
							<td>
								<strong>Documento</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Concierto</strong>
							</td>
							<td>
								<strong>Localidad</strong>
							</td>
							<td style="color:#fff;">
								<strong>Código de Compra</strong>
							</td>
							<td>
								<strong>Acción</strong>
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