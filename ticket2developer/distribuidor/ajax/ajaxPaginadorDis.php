<?php 
	date_default_timezone_set('America/Guayaquil');
	require_once '../../classes/private.db.php';
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	$gbd = new DBConn();
	$data = $_REQUEST['paginador'];
	include '../../conexion.php';
	//Paginador cobros
	if($data == 1){
		$idBuscador = $_REQUEST['id'];
		if($idBuscador == 1){
			//Aqui recibo los paremtros
			$documento = $_REQUEST['documento'];
			
			//Hago la consulta que me permitira saber si hay registros con esas condiciones
			$select = '	
						select idCliente , strNombresC, strMailC, strDocumentoC, strEvento, strDescripcionL , f.valor , 
						rand , estadoPV , estadopagoPV , f.id as id_fact, f.cobrado , f.idConc
						from factura  f , Cliente  c , Concierto co , Localidad l 
						
						WHERE strDocumentoC LIKE "%'.$documento.'%" 
						and c.idCliente = f.id_cli
						and co.idConcierto = f.idConc
						and l.idLocalidad = f.localidad
						and f.pventa = 1
						ORDER BY id_fact DESC';
			//echo $select;
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
				
				$selectLimit = 'select idCliente ,strNombresC, strMailC, strDocumentoC, strEvento, strDescripcionL , f.valor , 
								rand , estadoPV , estadopagoPV , f.id as id_fact, f.cobrado , f.idConc
								from factura  f , Cliente  c , Concierto co , Localidad l 
								
								WHERE strDocumentoC LIKE "%'.$documento.'%" 
								and c.idCliente = f.id_cli
								and co.idConcierto = f.idConc
								and l.idLocalidad = f.localidad
								and f.pventa = 1
								ORDER BY id_fact DESC
								LIMIT '.$offset.', '.$rowsPerPage.'';
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Nombres</strong>
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
								<strong>Valor $</strong>
							</td>
							<td>
								<strong>Envio $</strong>
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
					
					
					$sqlCDPV = 'SELECT count(cdpv.id) as cuantos , cdpv.* FROM `cli_dom_pventa` as cdpv where id_fact = "'.$row['id_fact'].'" ';
					// echo $sqlCDPV."<br><br>";
					$resCDPV = mysql_query($sqlCDPV) or die (mysql_error());
					$rowCDPV = mysql_fetch_array($resCDPV);
					if($rowCDPV['cuantos'] != 0){
						$sqlC = 'select envio from Concierto where idConcierto = "'.$row['idConc'].'" ';
						
						$resC = mysql_query($sqlC) or die (mysql_error());
						$rowC = mysql_fetch_array($resC);
						$costoEnvio = $rowC['envio'];
						$txtDom = '';
					}else{
						$costoEnvio = 0;
						$txtDom = '';
					}
					
					
					if($row['cobrado'] == 1){
						$title = 'Cobrado';
						$disabled = '';
						$estado = 1;
						$class = 'btndisabled';
					}else{
						$title = 'Cobrar';
						$disabled = '';
						$estado = 2;
						$class = 'btnlink';
					}
					echo '<tr>
							<td>
								'.$row['strNombresC'].'<br>
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
								'.$row['valor'].'
							</td>
							
							<td>
								'.$txtDom.'  '.$costoEnvio.'
							</td>
							
							
							<td>
								'.$row['rand'].'
							</td>
							<td>
								<button type="button" '.$disabled.' class="'.$class.'" onclick="cobrar('.$row['id_fact'].' , '.$estado.')">'.$title.'</button>
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
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Concierto</strong>
							</td>
							<td>
								<strong>Localidad</strong>
							</td>
							<td>
								<strong>Valor $</strong>
							</td>
							<td>
								<strong>Envio $</strong>
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
			$select = '	select strNombresC, strMailC, strDocumentoC, strEvento, strDescripcionL , 
						f.valor , rand , estadoPV , estadopagoPV , f.id as id_fact, f.cobrado, f.idConc
						from factura  f , Cliente  c , Concierto co , Localidad l 
						
						WHERE rand LIKE "%'.$codigo.'%" 
						and c.idCliente = f.id_cli
						and co.idConcierto = f.idConc
						and l.idLocalidad = f.localidad
						and f.pventa = 1
						ORDER BY id_fact DESC';
		//	echo $select;
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
				
				$selectLimit = '
								select strNombresC, strMailC, strDocumentoC, strEvento, strDescripcionL , f.valor , 
								rand , estadoPV , estadopagoPV , f.id as id_fact, f.cobrado, f.idConc
								from factura  f , Cliente  c , Concierto co , Localidad l 
								
								WHERE rand LIKE "%'.$codigo.'%" 
								and c.idCliente = f.id_cli
								and co.idConcierto = f.idConc
								and l.idLocalidad = f.localidad
								and f.pventa = 1
								ORDER BY id_fact DESC
								LIMIT '.$offset.', '.$rowsPerPage.'';
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Nombres</strong>
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
								<strong>Valor $</strong>
							</td>
							<td>
								<strong>Envio $</strong>
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
					
					$sqlCDPV = 'SELECT count(cdpv.id) as cuantos , cdpv.* FROM `cli_dom_pventa` as cdpv where id_fact = "'.$row['id_fact'].'" ';
					$resCDPV = mysql_query($sqlCDPV) or die (mysql_error());
					$rowCDPV = mysql_fetch_array($resCDPV);
					if($rowCDPV['cuantos'] != 0){
						$sqlC = 'select envio from Concierto where idConcierto = "'.$row['idConc'].'" ';
						$resC = mysql_query($sqlC) or die (mysql_error());
						$rowC = mysql_fetch_array($resC);
						$costoEnvio = $rowC['envio'];
						$txtDom = '';
					}else{
						$costoEnvio = 0;
						$txtDom = '';
					}
					
					if($row['cobrado'] == 1){
						$title = 'Cobrado';
						$disabled = '';
						$estado = 1;
						$class = 'btndisabled';
					}else{
						$title = 'Cobrar';
						$disabled = '';
						$estado = 2;
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
								'.$txtDom.'  '.$costoEnvio.'
							</td>
							<td>
								'.$row['valor'].'
							</td>
							<td>
								'.$row['rand'].'
							</td>
							<td>
								<button type="button" '.$disabled.' class="'.$class.'" onclick="cobrar('.$row['id_fact'].' , '.$estado.')">'.$title.'</button>
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
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Concierto</strong>
							</td>
							<td>
								<strong>Localidad</strong>
							</td>
							<td style="color:#fff;">
								Valor $
							</td>
							<td style="color:#fff;">
								Envio $
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