<?php
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadAdt.php");
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	$data = $_REQUEST['log'];
	
	//Paginador del log tributario
	if($data == 1){
		$idBuscador = $_REQUEST['id'];
		if($idBuscador == 1){
			//Aqui recibo los paremtros
			$fechadesde = $_REQUEST['desde'];
			$fechahasta = $_REQUEST['hasta'];
			$hora = date('H:i:s');
			$fechadesde = $fechadesde.' '.$hora;
			$fechahasta = $fechahasta.' '.$hora;
			
			//Hago la consulta que me permitira saber si hay registros con esas condiciones
			$select = "SELECT idlogtributario, fechahoraLT, idusuarioLT, accionLT, campoLT, idclienteLT, detalleantesLT, detalledespuesLT FROM logtributario 
						WHERE fechahoraLT >= '$fechadesde' AND fechahoraLT <= '$fechahasta' AND tipoLT != 'Empresa' ORDER BY idlogtributario DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT * FROM logtributario WHERE fechahoraLT >= '$fechadesde' AND fechahoraLT <= '$fechahasta' AND tipoLT != 'Empresa' ORDER BY idlogtributario DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>#</strong>
							</td>
							<td style="color:#fff;">
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					$iduser = $row['idusuarioLT'];
					$idCliente = $row['idclienteLT'];
					$selectNomuser = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = '$iduser'";
					$user = $gbd -> prepare($selectNomuser);
					$user -> execute();
					$rowuser = $user -> fetch(PDO::FETCH_ASSOC);
					$nameuser = $rowuser['strNombreU'];
					// $seleccliente = "SELECT strNombreU FROM Usuario WHERE idUsuario = '$idCliente'";
					// $cliente = $gbd -> prepare($seleccliente);
					// $cliente -> execute();
					// $rowcli = $cliente -> fetch(PDO::FETCH_ASSOC);
					// $namecli = $rowcli['strNombreU'];
					$selecsocio = "SELECT nombresS FROM Socio WHERE idSocio = '$idCliente'";
					$socio = $gbd -> prepare($selecsocio);
					$socio -> execute();
					$rowsocio = $socio -> fetch(PDO::FETCH_ASSOC);
					$namecli = $rowsocio['nombresS'];
					echo '<tr>
							<td>
								'.$row['idlogtributario'].'
							</td>
							<td>
								'.$row['fechahoraLT'].'
							</td>
							<td>
								'.$nameuser .'
							</td>
							<td>
								'.$rowuser['strPerfil'].'
							</td>
							<td>
								'.$row['accionLT'].'
							</td>
							<td>
								'.$namecli .'
							</td>
							<td>
								'.$row['campoLT'].'
							</td>
							<td>
								'.$row['detalleantesLT'].'
							</td>
							<td>
								'.$row['detalledespuesLT'].'
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
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
						</tr>
						<trd>
							<td colspan="8" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 2){
			$nombreUser = $_REQUEST['nombreUser'];
			$select = "SELECT idlogtributario, fechahoraLT, idusuarioLT, accionLT, campoLT, idclienteLT, detalleantesLT, detalledespuesLT, strNombreU FROM logtributario
						JOIN Usuario ON logtributario.idusuarioLT = Usuario.idUsuario WHERE strNombreU LIKE '%$nombreUser%' AND tipoLT != 'Empresa' ORDER BY idlogtributario DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idlogtributario, fechahoraLT, idusuarioLT, accionLT, campoLT, idclienteLT, detalleantesLT, detalledespuesLT, strNombreU FROM logtributario
								JOIN Usuario ON logtributario.idusuarioLT = Usuario.idUsuario WHERE strNombreU LIKE '%$nombreUser%' AND tipoLT != 'Empresa' ORDER BY idlogtributario DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td style="color:#fff;">
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
			
					$iduser = $row['idusuarioLT'];
					$idCliente = $row['idclienteLT'];
					$selectNomuser = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = '$iduser'";
					$user = $gbd -> prepare($selectNomuser);
					$user -> execute();
					$rowuser = $user -> fetch(PDO::FETCH_ASSOC);
					$nameuser = $rowuser['strNombreU'];
					// $seleccliente = "SELECT strNombreU FROM Usuario WHERE idUsuario = '$idCliente'";
					// $cliente = $gbd -> prepare($seleccliente);
					// $cliente -> execute();
					// $rowcli = $cliente -> fetch(PDO::FETCH_ASSOC);
					// $namecli = $rowcli['strNombreU'];
					$selecsocio = "SELECT nombresS FROM Socio WHERE idSocio = '$idCliente'";
					$socio = $gbd -> prepare($selecsocio);
					$socio -> execute();
					$rowsocio = $socio -> fetch(PDO::FETCH_ASSOC);
					$namecli = $rowsocio['nombresS'];
					echo '<tr>
							<td>
								'.$row['idlogtributario'].'
							</td>
							<td>
								'.$row['fechahoraLT'].'
							</td>
							<td>
								'.$nameuser .'
							</td>
							<td>
								'.$rowuser['strPerfil'].'
							</td>
							<td>
								'.$row['accionLT'].'
							</td>
							<td>
								'.$namecli .'
							</td>
							<td>
								'.$row['campoLT'].'
							</td>
							<td>
								'.$row['detalleantesLT'].'
							</td>
							<td>
								'.$row['detalledespuesLT'].'
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
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
						</tr>
						<trd>
							<td colspan="9" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 3){
			$nombreCli = $_REQUEST['nombreCli'];
			$select = "SELECT idlogtributario, fechahoraLT, idusuarioLT, accionLT, campoLT, idclienteLT, detalleantesLT, detalledespuesLT, nombresS FROM logtributario
					JOIN Socio ON logtributario.idclienteLT = Socio.idSocio WHERE nombresS LIKE '%$nombreCli%' AND tipoLT != 'Empresa' ORDER BY idlogtributario DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idlogtributario, fechahoraLT, idusuarioLT, accionLT, campoLT, idclienteLT, detalleantesLT, detalledespuesLT, nombresS FROM logtributario
								JOIN Socio ON logtributario.idclienteLT = Socio.idSocio WHERE nombresS LIKE '%$nombreCli%' AND tipoLT != 'Empresa' ORDER BY idlogtributario DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td style="color:#fff;">
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					$iduser = $row['idusuarioLT'];
					$idCliente = $row['idclienteLT'];
					$selectNomuser = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = '$iduser'";
					$user = $gbd -> prepare($selectNomuser);
					$user -> execute();
					$rowuser = $user -> fetch(PDO::FETCH_ASSOC);
					$nameuser = $rowuser['strNombreU'];
					// $seleccliente = "SELECT strNombreU FROM Usuario WHERE idUsuario = '$idCliente'";
					// $cliente = $gbd -> prepare($seleccliente);
					// $cliente -> execute();
					// $rowcli = $cliente -> fetch(PDO::FETCH_ASSOC);
					// $namecli = $rowcli['strNombreU'];
					$selecsocio = "SELECT nombresS FROM Socio WHERE idSocio = '$idCliente'";
					$socio = $gbd -> prepare($selecsocio);
					$socio -> execute();
					$rowsocio = $socio -> fetch(PDO::FETCH_ASSOC);
					$namecli = $rowsocio['nombresS'];
					echo '<tr>
							<td>
								'.$row['idlogtributario'].'
							</td>
							<td>
								'.$row['fechahoraLT'].'
							</td>
							<td>
								'.$nameuser .'
							</td>
							<td>
								'.$rowuser['strPerfil'].'
							</td>
							<td>
								'.$row['accionLT'].'
							</td>
							<td>
								'.$namecli .'
							</td>
							<td>
								'.$row['campoLT'].'
							</td>
							<td>
								'.$row['detalleantesLT'].'
							</td>
							<td>
								'.$row['detalledespuesLT'].'
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
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
						</tr>
						<tr>
							<td colspan="8" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 4){
			$Emp = $_REQUEST['Emp'];
			$select = "SELECT idlogtributario, fechahoraLT, strNombreU, accionLT, campoLT, nombresTF, detalleantesLT, detalledespuesLT, tipoLT FROM logtributario
						JOIN ticktfacil ON logtributario.idclienteLT = ticktfacil.idticketFacil JOIN Usuario ON logtributario.idusuarioLT = Usuario.idUsuario
						WHERE tipoLT LIKE '%$Emp%' ORDER BY idlogtributario DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idlogtributario, fechahoraLT, strNombreU, strPerfil, accionLT, campoLT, nombresTF, detalleantesLT, detalledespuesLT, tipoLT FROM logtributario
								JOIN ticktfacil ON logtributario.idclienteLT = ticktfacil.idticketFacil JOIN Usuario ON logtributario.idusuarioLT = Usuario.idUsuario
								WHERE tipoLT LIKE '%$Emp%' ORDER BY idlogtributario DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					echo '<tr>
							<td>
								'.$row['idlogtributario'].'
							</td>
							<td>
								'.$row['fechahoraLT'].'
							</td>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['strPerfil'].'
							</td>
							<td>
								'.$row['accionLT'].'
							</td>
							<td>
								'.$row['nombresTF'].'
							</td>
							<td>
								'.$row['campoLT'].'
							</td>
							<td>
								'.$row['detalleantesLT'].'
							</td>
							<td>
								'.$row['detalledespuesLT'].'
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
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
						</tr>
						<trd>
							<td colspan="8" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
	}
	
	//Paginador del log de usuarios
	if($data == 2){
		$idBuscador = $_REQUEST['id'];
		if($idBuscador == 1){
			$fechadesde = $_REQUEST['desde'];
			$fechahasta = $_REQUEST['hasta'];
			$hora = date('H:i:s');
			$fechadesde = $fechadesde.' '.$hora;
			$fechahasta = $fechahasta.' '.$hora;
			
			$select = "SELECT idlogusuario, fechahoraLU, idusuarioLU, accionLU, campoLU, idclienteLU, detalleantesLU, detalledespuesLU FROM logusuario 
						WHERE fechahoraLU >= '$fechadesde' AND fechahoraLU <= '$fechahasta' ORDER BY idlogusuario DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT * FROM logusuario WHERE fechahoraLU >= '$fechadesde' AND fechahoraLU <= '$fechahasta' ORDER BY idlogusuario DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>#</strong>
							</td>
							<td style="color:#fff;">
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
							<td>
								<strong>Perfil del Usuario Afectado</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					$iduser = $row['idusuarioLU'];
					$idCliente = $row['idclienteLU'];
					$selectNomuser = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = '$iduser'";
					$user = $gbd -> prepare($selectNomuser);
					$user -> execute();
					$rowuser = $user -> fetch(PDO::FETCH_ASSOC);
					$nameuser = $rowuser['strNombreU'];
					$seleccliente = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = '$idCliente'";
					$cliente = $gbd -> prepare($seleccliente);
					$cliente -> execute();
					$rowcli = $cliente -> fetch(PDO::FETCH_ASSOC);
					$namecli = $rowcli['strNombreU'];
					$perfil = $rowcli['strPerfil'];
					$campo = $row['campoLU'];
					if($campo == 'Ciudad'){
						if($row['detalledespuesLU'] == 1){ $despues = 'Ambato';
						}else{
							if($row['detalledespuesLU'] == 2){ $despues = 'Cuenca';
							}else{
								if($row['detalledespuesLU'] == 3){ $despues = 'Esmeraldas';
								}else{
									if($row['detalledespuesLU'] == 4){ $despues = 'Guaranda';
									}else{
										if($row['detalledespuesLU'] == 5){ $despues = 'Guayaquil';
										}else{
											if($row['detalledespuesLU'] == 6){ $despues = 'Ibarra';
											}else{
												if($row['detalledespuesLU'] == 7){ $despues = 'Latacunga';
												}else{
													if($row['detalledespuesLU'] == 8){ $despues = 'Loja';
													}else{
														if($row['detalledespuesLU'] == 9){ $despues = 'Machala';
														}else{
															if($row['detalledespuesLU'] == 10){ $despues = 'Portoviejo';
															}else{
																if($row['detalledespuesLU'] == 11){ $despues = 'Puyo';
																}else{
																	if($row['detalledespuesLU'] == 12){ $despues = 'Quito';
																	}else{
																		if($row['detalledespuesLU'] == 13){ $despues = 'Santo Domingo';
																		}else{
																			if($row['detalledespuesLU'] == 14){ $despues = 'Riobamba';
																			}else{
																				if($row['detalledespuesLU'] == 15){ $despues = 'Tena';
																				}else{
																					if($row['detalledespuesLU'] == 16){ $despues = 'Tulcan';
																					}else{
																						$despues = $row['detalledespuesLU'];
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}else{
						if($campo == 'Provincia'){
							if($row['detalledespuesLU'] == 1){ $despues = 'Azuay';
							}else{
								if($row['detalledespuesLU'] == 2){ $despues = 'Bolivar';
								}else{
									if($row['detalledespuesLU'] == 3){ $despues = 'Ca&ntilde;ar';
									}else{
										if($row['detalledespuesLU'] == 4){ $despues = 'Carchi';
										}else{
											if($row['detalledespuesLU'] == 5){ $despues = 'Chimborazo';
											}else{
												if($row['detalledespuesLU'] == 6){ $despues = 'Cotopaxi';
												}else{
													if($row['detalledespuesLU'] == 7){ $despues = 'El Oro';
													}else{
														if($row['detalledespuesLU'] == 8){ $despues = 'Esmeraldas';
														}else{
															if($row['detalledespuesLU'] == 9){ $despues = 'Guayas';
															}else{
																if($row['detalledespuesLU'] == 10){ $despues = 'Imbabura';
																}else{
																	if($row['detalledespuesLU'] == 11){ $despues = 'Loja';
																	}else{
																		if($row['detalledespuesLU'] == 12){ $despues = 'Los R&iacute;os';
																		}else{
																			if($row['detalledespuesLU'] == 13){ $despues = 'Manab&iacute;';
																			}else{
																				if($row['detalledespuesLU'] == 14){ $despues = 'Morona Santiago';
																				}else{
																					if($row['detalledespuesLU'] == 15){ $despues = 'Napo';
																					}else{
																						if($row['detalledespuesLU'] == 16){ $despues = 'Orellana';
																						}else{
																							if($row['detalledespuesLU'] == 17){ $despues = 'Pastaza';
																							}else{
																								if($row['detalledespuesLU'] == 18){ $despues = 'Pichincha';
																								}else{
																									if($row['detalledespuesLU'] == 19){ $despues = 'Santa Elena';
																									}else{
																										if($row['detalledespuesLU'] == 20){ $despues = 'Santo Domingo de los Ts&aacute;chilas';
																										}else{
																											if($row['detalledespuesLU'] == 21){ $despues = 'Tungurahua';
																											}else{
																												if($row['detalledespuesLU'] == 22){ $despues = 'Zamora Chinchipe';
																												}else{
																													$despues = $row['detalledespuesLU'];
																												}
																											}
																										}
																									}
																								}
																							}
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}else{
							$despues = $row['detalledespuesLU'];
						}
					}
					
					echo '<tr>
							<td>
								'.$row['idlogusuario'].'
							</td>
							<td>
								'.$row['fechahoraLU'].'
							</td>
							<td>
								'.$nameuser .'
							</td>
							<td>
								'.$rowuser['strPerfil'].'
							</td>
							<td>
								'.$row['accionLU'].'
							</td>
							<td>
								'.$namecli .'
							</td>
							<td>
								'.$campo.'
							</td>
							<td>
								'.$row['detalleantesLU'].'
							</td>
							<td>
								'.$despues.'
							</td>
							<td>
								'.$perfil.'
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
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
							<td>
								<strong>Perfil del Usuario Afectado</strong>
							</td>
						</tr>
						<trd>
							<td colspan="9" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 2){
			$nombreUser = $_REQUEST['nombreUser'];
			$select = "SELECT idlogusuario, fechahoraLU, idusuarioLU, accionLU, campoLU, idclienteLU, detalleantesLU, detalledespuesLU, strNombreU FROM logusuario
						JOIN Usuario ON logusuario.idusuarioLU = Usuario.idUsuario WHERE strNombreU LIKE '%$nombreUser%' ORDER BY idlogusuario DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idlogusuario, fechahoraLU, idusuarioLU, accionLU, campoLU, idclienteLU, detalleantesLU, detalledespuesLU, strNombreU FROM logusuario
								JOIN Usuario ON logusuario.idusuarioLU = Usuario.idUsuario WHERE strNombreU LIKE '%$nombreUser%' ORDER BY idlogusuario DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:left; color:#00ADEF;">
							<td>
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td style="color:#fff;">
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
							<td>
								<strong>Perfil del Usuario Afectado</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
			
					$iduser = $row['idusuarioLU'];
					$idCliente = $row['idclienteLU'];
					$selectNomuser = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = '$iduser'";
					$user = $gbd -> prepare($selectNomuser);
					$user -> execute();
					$rowuser = $user -> fetch(PDO::FETCH_ASSOC);
					$nameuser = $rowuser['strNombreU'];
					$seleccliente = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = '$idCliente'";
					$cliente = $gbd -> prepare($seleccliente);
					$cliente -> execute();
					$rowcli = $cliente -> fetch(PDO::FETCH_ASSOC);
					$namecli = $rowcli['strNombreU'];
					$perfil = $rowcli['strPerfil'];
					$campo = $row['campoLU'];
					if($campo == 'Ciudad'){
						if($row['detalledespuesLU'] == 1){ $despues = 'Ambato';
						}else{
							if($row['detalledespuesLU'] == 2){ $despues = 'Cuenca';
							}else{
								if($row['detalledespuesLU'] == 3){ $despues = 'Esmeraldas';
								}else{
									if($row['detalledespuesLU'] == 4){ $despues = 'Guaranda';
									}else{
										if($row['detalledespuesLU'] == 5){ $despues = 'Guayaquil';
										}else{
											if($row['detalledespuesLU'] == 6){ $despues = 'Ibarra';
											}else{
												if($row['detalledespuesLU'] == 7){ $despues = 'Latacunga';
												}else{
													if($row['detalledespuesLU'] == 8){ $despues = 'Loja';
													}else{
														if($row['detalledespuesLU'] == 9){ $despues = 'Machala';
														}else{
															if($row['detalledespuesLU'] == 10){ $despues = 'Portoviejo';
															}else{
																if($row['detalledespuesLU'] == 11){ $despues = 'Puyo';
																}else{
																	if($row['detalledespuesLU'] == 12){ $despues = 'Quito';
																	}else{
																		if($row['detalledespuesLU'] == 13){ $despues = 'Santo Domingo';
																		}else{
																			if($row['detalledespuesLU'] == 14){ $despues = 'Riobamba';
																			}else{
																				if($row['detalledespuesLU'] == 15){ $despues = 'Tena';
																				}else{
																					if($row['detalledespuesLU'] == 16){ $despues = 'Tulcan';
																					}else{
																						$despues = $row['detalledespuesLU'];
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}else{
						if($campo == 'Provincia'){
							if($row['detalledespuesLU'] == 1){ $despues = 'Azuay';
							}else{
								if($row['detalledespuesLU'] == 2){ $despues = 'Bolivar';
								}else{
									if($row['detalledespuesLU'] == 3){ $despues = 'Ca&ntilde;ar';
									}else{
										if($row['detalledespuesLU'] == 4){ $despues = 'Carchi';
										}else{
											if($row['detalledespuesLU'] == 5){ $despues = 'Chimborazo';
											}else{
												if($row['detalledespuesLU'] == 6){ $despues = 'Cotopaxi';
												}else{
													if($row['detalledespuesLU'] == 7){ $despues = 'El Oro';
													}else{
														if($row['detalledespuesLU'] == 8){ $despues = 'Esmeraldas';
														}else{
															if($row['detalledespuesLU'] == 9){ $despues = 'Guayas';
															}else{
																if($row['detalledespuesLU'] == 10){ $despues = 'Imbabura';
																}else{
																	if($row['detalledespuesLU'] == 11){ $despues = 'Loja';
																	}else{
																		if($row['detalledespuesLU'] == 12){ $despues = 'Los R&iacute;os';
																		}else{
																			if($row['detalledespuesLU'] == 13){ $despues = 'Manab&iacute;';
																			}else{
																				if($row['detalledespuesLU'] == 14){ $despues = 'Morona Santiago';
																				}else{
																					if($row['detalledespuesLU'] == 15){ $despues = 'Napo';
																					}else{
																						if($row['detalledespuesLU'] == 16){ $despues = 'Orellana';
																						}else{
																							if($row['detalledespuesLU'] == 17){ $despues = 'Pastaza';
																							}else{
																								if($row['detalledespuesLU'] == 18){ $despues = 'Pichincha';
																								}else{
																									if($row['detalledespuesLU'] == 19){ $despues = 'Santa Elena';
																									}else{
																										if($row['detalledespuesLU'] == 20){ $despues = 'Santo Domingo de los Ts&aacute;chilas';
																										}else{
																											if($row['detalledespuesLU'] == 21){ $despues = 'Tungurahua';
																											}else{
																												if($row['detalledespuesLU'] == 22){ $despues = 'Zamora Chinchipe';
																												}else{
																													$despues = $row['detalledespuesLU'];
																												}
																											}
																										}
																									}
																								}
																							}
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}else{
							$despues = $row['detalledespuesLU'];
						}
					}
					echo '<tr>
							<td>
								'.$row['idlogusuario'].'
							</td>
							<td>
								'.$row['fechahoraLU'].'
							</td>
							<td>
								'.$nameuser .'
							</td>
							<td>
								'.$rowuser['strPerfil'].'
							</td>
							<td>
								'.$row['accionLU'].'
							</td>
							<td>
								'.$namecli .'
							</td>
							<td>
								'.$campo.'
							</td>
							<td>
								'.$row['detalleantesLU'].'
							</td>
							<td>
								'.$despues.'
							</td>
							<td>
								'.$perfil.'
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
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
							<td>
								<strong>Perfil del Usuario Afectado</strong>
							</td>
						</tr>
						<tr>
							<td colspan="9" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 3){
			$nombreCli = $_REQUEST['nombreCli'];
			$select = "SELECT idlogusuario, fechahoraLU, idusuarioLU, accionLU, campoLU, idclienteLU, detalleantesLU, detalledespuesLU, strNombreU FROM logusuario
					JOIN Usuario ON logusuario.idclienteLU = Usuario.idUsuario WHERE strNombreU LIKE '%$nombreCli%' ORDER BY idlogusuario DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idlogusuario, fechahoraLU, idusuarioLU, accionLU, campoLU, idclienteLU, detalleantesLU, detalledespuesLU, strNombreU FROM logusuario
								JOIN Usuario ON logusuario.idclienteLU = Usuario.idUsuario WHERE strNombreU LIKE '%$nombreCli%' ORDER BY idlogusuario DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="color:#00ADEF;">
							<td>
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td style="color:#fff;">
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
							<td>
								<strong>Perfil del Usuario Afectado</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					$iduser = $row['idusuarioLU'];
					$idCliente = $row['idclienteLU'];
					$selectNomuser = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = '$iduser'";
					$user = $gbd -> prepare($selectNomuser);
					$user -> execute();
					$rowuser = $user -> fetch(PDO::FETCH_ASSOC);
					$nameuser = $rowuser['strNombreU'];
					$seleccliente = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = '$idCliente'";
					$cliente = $gbd -> prepare($seleccliente);
					$cliente -> execute();
					$rowcli = $cliente -> fetch(PDO::FETCH_ASSOC);
					$namecli = $rowcli['strNombreU'];
					$perfil = $rowcli['strPerfil'];
					$campo = $row['campoLU'];
					if($campo == 'Ciudad'){
						if($row['detalledespuesLU'] == 1){ $despues = 'Ambato';
						}else{
							if($row['detalledespuesLU'] == 2){ $despues = 'Cuenca';
							}else{
								if($row['detalledespuesLU'] == 3){ $despues = 'Esmeraldas';
								}else{
									if($row['detalledespuesLU'] == 4){ $despues = 'Guaranda';
									}else{
										if($row['detalledespuesLU'] == 5){ $despues = 'Guayaquil';
										}else{
											if($row['detalledespuesLU'] == 6){ $despues = 'Ibarra';
											}else{
												if($row['detalledespuesLU'] == 7){ $despues = 'Latacunga';
												}else{
													if($row['detalledespuesLU'] == 8){ $despues = 'Loja';
													}else{
														if($row['detalledespuesLU'] == 9){ $despues = 'Machala';
														}else{
															if($row['detalledespuesLU'] == 10){ $despues = 'Portoviejo';
															}else{
																if($row['detalledespuesLU'] == 11){ $despues = 'Puyo';
																}else{
																	if($row['detalledespuesLU'] == 12){ $despues = 'Quito';
																	}else{
																		if($row['detalledespuesLU'] == 13){ $despues = 'Santo Domingo';
																		}else{
																			if($row['detalledespuesLU'] == 14){ $despues = 'Riobamba';
																			}else{
																				if($row['detalledespuesLU'] == 15){ $despues = 'Tena';
																				}else{
																					if($row['detalledespuesLU'] == 16){ $despues = 'Tulcan';
																					}else{
																						$despues = $row['detalledespuesLU'];
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}else{
						if($campo == 'Provincia'){
							if($row['detalledespuesLU'] == 1){ $despues = 'Azuay';
							}else{
								if($row['detalledespuesLU'] == 2){ $despues = 'Bolivar';
								}else{
									if($row['detalledespuesLU'] == 3){ $despues = 'Ca&ntilde;ar';
									}else{
										if($row['detalledespuesLU'] == 4){ $despues = 'Carchi';
										}else{
											if($row['detalledespuesLU'] == 5){ $despues = 'Chimborazo';
											}else{
												if($row['detalledespuesLU'] == 6){ $despues = 'Cotopaxi';
												}else{
													if($row['detalledespuesLU'] == 7){ $despues = 'El Oro';
													}else{
														if($row['detalledespuesLU'] == 8){ $despues = 'Esmeraldas';
														}else{
															if($row['detalledespuesLU'] == 9){ $despues = 'Guayas';
															}else{
																if($row['detalledespuesLU'] == 10){ $despues = 'Imbabura';
																}else{
																	if($row['detalledespuesLU'] == 11){ $despues = 'Loja';
																	}else{
																		if($row['detalledespuesLU'] == 12){ $despues = 'Los R&iacute;os';
																		}else{
																			if($row['detalledespuesLU'] == 13){ $despues = 'Manab&iacute;';
																			}else{
																				if($row['detalledespuesLU'] == 14){ $despues = 'Morona Santiago';
																				}else{
																					if($row['detalledespuesLU'] == 15){ $despues = 'Napo';
																					}else{
																						if($row['detalledespuesLU'] == 16){ $despues = 'Orellana';
																						}else{
																							if($row['detalledespuesLU'] == 17){ $despues = 'Pastaza';
																							}else{
																								if($row['detalledespuesLU'] == 18){ $despues = 'Pichincha';
																								}else{
																									if($row['detalledespuesLU'] == 19){ $despues = 'Santa Elena';
																									}else{
																										if($row['detalledespuesLU'] == 20){ $despues = 'Santo Domingo de los Ts&aacute;chilas';
																										}else{
																											if($row['detalledespuesLU'] == 21){ $despues = 'Tungurahua';
																											}else{
																												if($row['detalledespuesLU'] == 22){ $despues = 'Zamora Chinchipe';
																												}else{
																													$despues = $row['detalledespuesLU'];
																												}
																											}
																										}
																									}
																								}
																							}
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}else{
							$despues = $row['detalledespuesLU'];
						}
					}
					echo '<tr>
							<td>
								'.$row['idlogusuario'].'
							</td>
							<td>
								'.$row['fechahoraLU'].'
							</td>
							<td>
								'.$nameuser .'
							</td>
							<td>
								'.$rowuser['strPerfil'].'
							</td>
							<td>
								'.$row['accionLU'].'
							</td>
							<td>
								'.$namecli .'
							</td>
							<td>
								'.$campo.'
							</td>
							<td>
								'.$row['detalleantesLU'].'
							</td>
							<td>
								'.$despues.'
							</td>
							<td>
								'.$perfil.'
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
								<strong>#</strong>
							</td>
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario que<br>realiz&oacute; el<br>cambio</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Campo Modificado</strong>
							</td>
							<td>
								<strong>Detalle de Cambios (antes)</strong>
							</td>
							<td>
								<strong>Detalle de Cambios(desp&uacute;es)</strong>
							</td>
							<td>
								<strong>Perfil del Usuario Afectado</strong>
							</td>
						</tr>
						<trd>
							<td colspan="9" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
	}
	
	//paginador del log de acceso
	if($data == 5){
		$idBuscador = $_REQUEST['id'];
		if($idBuscador == 1){
			$fechadesde = $_REQUEST['desde'];
			$fechahasta = $_REQUEST['hasta'];
			$hora = date('H:i:s');
			$fechadesde = $fechadesde.' '.$hora;
			$fechahasta = $fechahasta.' '.$hora;
			
			$select = "SELECT fechahoraLA, idusuarioLA, accionLA FROM logaccesoauditoria WHERE fechahoraLA >= '$fechadesde' AND fechahoraLA <= '$fechahasta' ORDER BY idlogacceso DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT * FROM logaccesoauditoria WHERE fechahoraLA >= '$fechadesde' AND fechahoraLA <= '$fechahasta' ORDER BY idlogacceso DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:left; color:#00ADEF;">
							<td style="color:#fff;">
								<strong>Fecha y Hora</strong>
							</td>
							<td>
								<strong>Usuario accede al M&oacute;dulo</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					$iduser = $row['idusuarioLA'];
					$selectNomuser = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = '$iduser'";
					$user = $gbd -> prepare($selectNomuser);
					$user -> execute();
					$rowuser = $user -> fetch(PDO::FETCH_ASSOC);
					$nameuser = $rowuser['strNombreU'];
					echo '<tr style="text-align:left;">
							<td>
								'.$row['fechahoraLA'].'
							</td>
							<td>
								'.$nameuser .'
							</td>
							<td>
								'.$rowuser['strPerfil'].'
							</td>
							<td>
								'.$row['accionLA'].'
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
						<tr>
							<td>
								Fecha y Hora
							</td>
							<td>
								Usuario
							</td>
							<td>
								Perfil
							</td>
							<td>
								Evento Realizado
							</td>
						</tr>
						<tr>
							<td colspan="4" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 2){
			$nombreUser = $_REQUEST['nombreUser'];
			$select = "SELECT fechahoraLA, idusuarioLA, accionLA, strNombreU FROM logaccesoauditoria JOIN Usuario ON logaccesoauditoria.idusuarioLA = Usuario.idUsuario WHERE strNombreU LIKE '%$nombreUser%' ORDER BY idlogacceso DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT fechahoraLA, idusuarioLA, accionLA, strNombreU FROM logaccesoauditoria
								JOIN Usuario ON logaccesoauditoria.idusuarioLA = Usuario.idUsuario WHERE strNombreU LIKE '%$nombreUser%' ORDER BY idlogacceso DESC LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:left; color:#00ADEF;">
							<td>
								<strong>Fecha y Hora</strong>
							</td>
							<td style="color:#fff;">
								<strong>Usuario Creador</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Evento Realizado</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
			
					$iduser = $row['idusuarioLA'];
					$selectNomuser = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = '$iduser'";
					$user = $gbd -> prepare($selectNomuser);
					$user -> execute();
					$rowuser = $user -> fetch(PDO::FETCH_ASSOC);
					$nameuser = $rowuser['strNombreU'];
					echo '<tr style="text-align:left;">
							<td>
								'.$row['fechahoraLA'].'
							</td>
							<td>
								'.$nameuser .'
							</td>
							<td>
								'.$rowuser['strPerfil'].'
							</td>
							<td>
								'.$row['accionLA'].'
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
						<tr>
							<td>
								Fecha y Hora
							</td>
							<td>
								Usuario
							</td>
							<td>
								Perfil
							</td>
							<td>
								Evento Realizado
							</td>
						</tr>
						<trd>
							<td colspan="3" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
	}
	
	//Paginador del log de autorizaciones
	if($data == 3){
		$idBuscador = $_REQUEST['id'];
		if($idBuscador == 2){
			$desde = $_REQUEST['desde'];
			$hasta = $_REQUEST['hasta'];
			$select = "SELECT nroautorizacionA, fechaautorizacioA, rucAHIS, nombresS, codestablecimientoAHIS, nombrecomercialAHIS, dirmatrizAHIS, direstablecimientoAHIS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE fechaautorizacioA >= ? AND fechaautorizacioA <= ? ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute(array($desde,$hasta));
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT nroautorizacionA, fechaautorizacioA, rucAHIS, nombresS, codestablecimientoAHIS, nombrecomercialAHIS, dirmatrizAHIS, direstablecimientoAHIS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE fechaautorizacioA >= ? AND fechaautorizacioA <= ? ORDER BY idAutorizacion DESC LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($desde,$hasta,$offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td colspan="2">
								<strong>Autorizaci&oacute;n</strong>
							</td>
							<td colspan="2">
								<strong>Coontribuyente</strong>
							</td>
							<td colspan="2">
								<strong>Establecimiento</strong>
							</td>
						</tr>
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td>
								<strong><p>Nombre Comercial</p><p>Direcci&oacute;n</p></strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					$nest = $row['codestablecimientoAHIS'];
					if((strlen($nest) == 1)){
						$numesta = '00'.$nest; 
					}else{
						if((strlen($nest) == 2)){
							$numesta = '0'.$nest; 
						}else{
							if((strlen($nest) > 2)){
								$numesta = $row['codestablecimientoAHIS']; 
							}
						}
					}
					
					if($row['imprimirparaA'] == 'm'){
						$direccion = $row['dirmatrizAHIS'];
					}else if($row['imprimirparaA'] == 's'){
						$direccion = $row['direstablecimientoAHIS'];
					}
					echo '<tr>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombresS'].'
							</td>
							<td>
								'.$numesta.'
							</td>
							<td>
								<p>'.$row['nombrecomercialAHIS'].'</p>
								<p>'.$direccion.'</p>
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
				echo '<table style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td colspan="2">
								<strong>Autorizaci&oacute;n</strong>
							</td>
							<td colspan="2">
								<strong>Coontribuyente</strong>
							</td>
							<td colspan="2">
								<strong>Establecimiento</strong>
							</td>
						</tr>
						<tr style="text-align:left; color:#00ADEF;">
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td>
								<strong><p>Nombre Comercial</p><p>Direcci&oacute;n</p></strong>
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
			$razonsocial = $_REQUEST['razonsocial'];
			$select = "SELECT nroautorizacionA, fechaautorizacioA, rucAHIS, nombresS, codestablecimientoAHIS, nombrecomercialAHIS, dirmatrizAHIS, direstablecimientoAHIS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE nombrecomercialAHIS LIKE '%$razonsocial%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT nroautorizacionA, fechaautorizacioA, rucAHIS, nombresS, codestablecimientoAHIS, nombrecomercialAHIS, dirmatrizAHIS, direstablecimientoAHIS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE nombrecomercialAHIS LIKE '%$razonsocial%' ORDER BY idAutorizacion DESC LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td colspan="2">
								<strong>Autorizaci&oacute;n</strong>
							</td>
							<td colspan="2">
								<strong>Coontribuyente</strong>
							</td>
							<td colspan="2">
								<strong>Establecimiento</strong>
							</td>
						</tr>
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td style="color:#fff;">
								<strong><p>Nombre Comercial</p><p>Direcci&oacute;n</p></strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					$nest = $row['codestablecimientoAHIS'];
					if((strlen($nest) == 1)){
						$numesta = '00'.$nest; 
					}else{
						if((strlen($nest) == 2)){
							$numesta = '0'.$nest; 
						}else{
							if((strlen($nest) > 2)){
								$numesta = $row['codestablecimientoAHIS']; 
							}
						}
					}
					
					if($row['imprimirparaA'] == 'm'){
						$direccion = $row['dirmatrizAHIS'];
					}else if($row['imprimirparaA'] == 's'){
						$direccion = $row['direstablecimientoAHIS'];
					}
					echo '<tr>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombresS'].'
							</td>
							<td>
								'.$numesta.'
							</td>
							<td>
								<p>'.$row['nombrecomercialAHIS'].'</p>
								<p>'.$direccion.'</p>
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
						<tr style="text-align:center; color:#00ADEF;">
							<td colspan="2">
								<strong>Autorizaci&oacute;n</strong>
							</td>
							<td colspan="2">
								<strong>Coontribuyente</strong>
							</td>
							<td colspan="2">
								<strong>Establecimiento</strong>
							</td>
						</tr>
						<tr style="text-align:left; color:#00ADEF;">
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td>
								<strong><p>Nombre Comercial</p><p>Direcci&oacute;n</p></strong>
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
		
		if($idBuscador == 6){
			$ruc = $_REQUEST['ruc'];
			$select = "SELECT nroautorizacionA, fechaautorizacioA, rucAHIS, nombresS, codestablecimientoAHIS, nombrecomercialAHIS, dirmatrizAHIS, direstablecimientoAHIS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE rucAHIS LIKE '%$ruc%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT nroautorizacionA, fechaautorizacioA, rucAHIS, nombresS, codestablecimientoAHIS, nombrecomercialAHIS, dirmatrizAHIS, direstablecimientoAHIS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE rucAHIS LIKE '%$ruc%' ORDER BY idAutorizacion DESC LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:12px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td colspan="2">
								<strong>Autorizaci&oacute;n</strong>
							</td>
							<td colspan="2">
								<strong>Coontribuyente</strong>
							</td>
							<td colspan="2">
								<strong>Establecimiento</strong>
							</td>
						</tr>
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre del Cliente</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td>
								<strong><p>Nombre Comercial</p><p>Direcci&oacute;n</p></strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					$nest = $row['codestablecimientoAHIS'];
					if((strlen($nest) == 1)){
						$numesta = '00'.$nest; 
					}else{
						if((strlen($nest) == 2)){
							$numesta = '0'.$nest; 
						}else{
							if((strlen($nest) > 2)){
								$numesta = $row['codestablecimientoAHIS']; 
							}
						}
					}
					
					if($row['imprimirparaAi'] == 'm'){
						$direccion = $row['dirmatrizAHIS'];
					}else if($row['imprimirparaA'] == 's'){
						$direccion = $row['direstablecimientoAHIS'];
					}
					echo '<tr>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombresS'].'
							</td>
							<td>
								'.$numesta.'
							</td>
							<td>
								<p>'.$row['nombrecomercialAHIS'].'</p>
								<p>'.$direccion.'</p>
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
						<tr style="text-align:center; color:#00ADEF;">
							<td colspan="2">
								<strong>Autorizaci&oacute;n</strong>
							</td>
							<td colspan="2">
								<strong>Coontribuyente</strong>
							</td>
							<td colspan="2">
								<strong>Establecimiento</strong>
							</td>
						</tr>
						<tr style="text-align:left; color:#00ADEF;">
							<td>
								<strong>Nro. de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha de Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td>
								<strong><p>Nombre Comercial</p><p>Direcci&oacute;n</p></strong>
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
	
	//Paginador del log transaccional
	if($data == 4){
		$idBuscador = $_REQUEST['id'];
		if($idBuscador == 1){
			$td = $_REQUEST['tipdoc'];
			if($td == 1){
				$tipdoc = 'Factura';
			}else{
				if($td == 2){
					$tipdoc = 'Boleto';
				}else{
					if($td == 3){
						$tipdoc = 'Nota de Credito';
					}else{
						if($td == 4){
							$tipdoc = 'Nota de Debito';
						}else{
							if($td == 5){
								$tipdoc = 'Nota de Venta';
							}else{
								if($td == 6){
									$tipdoc = 'Liquidacion de Compras';
								}else{
									if($td == 7){
										$tipdoc = 'Guia de Remision';
									}else{
										if($td == 8){
											$tipdoc = 'Comprobante Retencion';
										}else{
											if($td == 9){
												$tipdoc = 'Taximetros y Registradoras';
											}else{
												if($td == 10){
													$tipdoc = 'LC Bienes Muebles usados';
												}else{
													if($td == 11){
														$tipdoc = 'LC Vehiculos usados';
													}else{
														if($td == 12){
															$tipdoc = 'Acta entrega/recepcion';
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE tipodocumentoA LIKE '%$tipdoc%'";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE tipodocumentoA LIKE '%$tipdoc%' LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:8px; border-collapse:separate; border-spacing:5px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td style="color:#fff;">
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(strlen($row['secuencialinicialA']) == 1){
						$secuinicial = '00000000'.$row['secuencialinicialA'];
					}else{
						if(strlen($row['secuencialinicialA']) == 2){
							$secuinicial = '0000000'.$row['secuencialinicialA'];
						}else{
							if(strlen($row['secuencialinicialA']) == 3){
								$secuinicial = '000000'.$row['secuencialinicialA'];
							}else{
								if(strlen($row['secuencialinicialA']) == 4){
									$secuinicial = '00000'.$row['secuencialinicialA'];
								}else{
									if(strlen($row['secuencialinicialA']) == 5){
										$secuinicial = '0000'.$row['secuencialinicialA'];
									}else{
										if(strlen($row['secuencialinicialA']) == 6){
											$secuinicial = '000'.$row['secuencialinicialA'];
										}else{
											if(strlen($row['secuencialinicialA']) == 7){
												$secuinicial = '00'.$row['secuencialinicialA'];
											}else{
												if(strlen($row['secuencialinicialA']) == 1){
													$secuinicial = '0'.$row['secuencialinicialA'];
												}else{
													if(strlen($row['secuencialinicialA']) == 9){
														$secuinicial = $row['secuencialinicialA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuencialfinalA']) == 1){
						$secufinal = '00000000'.$row['secuencialfinalA'];
					}else{
						if(strlen($row['secuencialfinalA']) == 2){
							$secufinal = '0000000'.$row['secuencialfinalA'];
						}else{
							if(strlen($row['secuencialfinalA']) == 3){
								$secufinal = '000000'.$row['secuencialfinalA'];
							}else{
								if(strlen($row['secuencialfinalA']) == 4){
									$secufinal = '00000'.$row['secuencialfinalA'];
								}else{
									if(strlen($row['secuencialfinalA']) == 5){
										$secufinal = '0000'.$row['secuencialfinalA'];
									}else{
										if(strlen($row['secuencialfinalA']) == 6){
											$secufinal = '000'.$row['secuencialfinalA'];
										}else{
											if(strlen($row['secuencialfinalA']) == 7){
												$secufinal = '00'.$row['secuencialfinalA'];
											}else{
												if(strlen($row['secuencialfinalA']) == 1){
													$secufinal = '0'.$row['secuencialfinalA'];
												}else{
													if(strlen($row['secuencialfinalA']) == 9){
														$secufinal = $row['secuencialfinalA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['serieinicialinformadaRT']) == 1){
						$secuinicialinfo = '00000000'.$row['serieinicialinformadaRT'];
					}else{
						if(strlen($row['serieinicialinformadaRT']) == 2){
							$secuinicialinfo = '0000000'.$row['serieinicialinformadaRT'];
						}else{
							if(strlen($row['serieinicialinformadaRT']) == 3){
								$secuinicialinfo = '000000'.$row['serieinicialinformadaRT'];
							}else{
								if(strlen($row['serieinicialinformadaRT']) == 4){
									$secuinicialinfo = '00000'.$row['serieinicialinformadaRT'];
								}else{
									if(strlen($row['serieinicialinformadaRT']) == 5){
										$secuinicialinfo = '0000'.$row['serieinicialinformadaRT'];
									}else{
										if(strlen($row['serieinicialinformadaRT']) == 6){
											$secuinicialinfo = '000'.$row['serieinicialinformadaRT'];
										}else{
											if(strlen($row['serieinicialinformadaRT']) == 7){
												$secuinicialinfo = '00'.$row['serieinicialinformadaRT'];
											}else{
												if(strlen($row['serieinicialinformadaRT']) == 8){
													$secuinicialinfo = '0'.$row['serieinicialinformadaRT'];
												}else{
													if(strlen($row['serieinicialinformadaRT']) == 9){
														$secuinicialinfo = $row['serieinicialinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['seriefinalinformadaRT']) == 1){
						$secufinainfo = '00000000'.$row['seriefinalinformadaRT'];
					}else{
						if(strlen($row['seriefinalinformadaRT']) == 2){
							$secufinainfo = '0000000'.$row['seriefinalinformadaRT'];
						}else{
							if(strlen($row['seriefinalinformadaRT']) == 3){
								$secufinainfo = '000000'.$row['seriefinalinformadaRT'];
							}else{
								if(strlen($row['seriefinalinformadaRT']) == 4){
									$secufinainfo = '00000'.$row['seriefinalinformadaRT'];
								}else{
									if(strlen($row['seriefinalinformadaRT']) == 5){
										$secufinainfo = '0000'.$row['seriefinalinformadaRT'];
									}else{
										if(strlen($row['seriefinalinformadaRT']) == 6){
											$secufinainfo = '000'.$row['seriefinalinformadaRT'];
										}else{
											if(strlen($row['seriefinalinformadaRT']) == 7){
												$secufinainfo = '00'.$row['seriefinalinformadaRT'];
											}else{
												if(strlen($row['seriefinalinformadaRT']) == 8){
													$secufinainfo = '0'.$row['seriefinalinformadaRT'];
												}else{
													if(strlen($row['seriefinalinformadaRT']) == 9){
														$secufinainfo = $row['seriefinalinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					echo '<tr>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['fechacaducidadA'].'
							</td>
							<td>
								'.$row['fechaprocesoA'].'
							</td>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['strPerfil'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="text-align:center;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="text-align:center;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td>
								'.$row['descripcionRT'].'
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
				echo '<table style="width:100%; color:#fff; font-size:10px; border-collapse:separate; border-spacing:15px 15px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td style="color:#fff;">
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>
						<tr>
							<td colspan="13" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 2){
			$desde = $_REQUEST['desde'];
			$hasta = $_REQUEST['hasta'];
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE fechaautorizacioA >= '$desde' AND fechaautorizacioA <= '$hasta' OR fechacaducidadA >= '$desde' AND fechacaducidadA <= '$hasta'";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE fechaautorizacioA >= '$desde' AND fechaautorizacioA <= '$hasta' OR fechacaducidadA >= '$desde' AND fechacaducidadA <= '$hasta' LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:8px; border-collapse:separate; border-spacing:5px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="color:#fff;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(strlen($row['secuencialinicialA']) == 1){
						$secuinicial = '00000000'.$row['secuencialinicialA'];
					}else{
						if(strlen($row['secuencialinicialA']) == 2){
							$secuinicial = '0000000'.$row['secuencialinicialA'];
						}else{
							if(strlen($row['secuencialinicialA']) == 3){
								$secuinicial = '000000'.$row['secuencialinicialA'];
							}else{
								if(strlen($row['secuencialinicialA']) == 4){
									$secuinicial = '00000'.$row['secuencialinicialA'];
								}else{
									if(strlen($row['secuencialinicialA']) == 5){
										$secuinicial = '0000'.$row['secuencialinicialA'];
									}else{
										if(strlen($row['secuencialinicialA']) == 6){
											$secuinicial = '000'.$row['secuencialinicialA'];
										}else{
											if(strlen($row['secuencialinicialA']) == 7){
												$secuinicial = '00'.$row['secuencialinicialA'];
											}else{
												if(strlen($row['secuencialinicialA']) == 1){
													$secuinicial = '0'.$row['secuencialinicialA'];
												}else{
													if(strlen($row['secuencialinicialA']) == 9){
														$secuinicial = $row['secuencialinicialA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuencialfinalA']) == 1){
						$secufinal = '00000000'.$row['secuencialfinalA'];
					}else{
						if(strlen($row['secuencialfinalA']) == 2){
							$secufinal = '0000000'.$row['secuencialfinalA'];
						}else{
							if(strlen($row['secuencialfinalA']) == 3){
								$secufinal = '000000'.$row['secuencialfinalA'];
							}else{
								if(strlen($row['secuencialfinalA']) == 4){
									$secufinal = '00000'.$row['secuencialfinalA'];
								}else{
									if(strlen($row['secuencialfinalA']) == 5){
										$secufinal = '0000'.$row['secuencialfinalA'];
									}else{
										if(strlen($row['secuencialfinalA']) == 6){
											$secufinal = '000'.$row['secuencialfinalA'];
										}else{
											if(strlen($row['secuencialfinalA']) == 7){
												$secufinal = '00'.$row['secuencialfinalA'];
											}else{
												if(strlen($row['secuencialfinalA']) == 1){
													$secufinal = '0'.$row['secuencialfinalA'];
												}else{
													if(strlen($row['secuencialfinalA']) == 9){
														$secufinal = $row['secuencialfinalA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['serieinicialinformadaRT']) == 1){
						$secuinicialinfo = '00000000'.$row['serieinicialinformadaRT'];
					}else{
						if(strlen($row['serieinicialinformadaRT']) == 2){
							$secuinicialinfo = '0000000'.$row['serieinicialinformadaRT'];
						}else{
							if(strlen($row['serieinicialinformadaRT']) == 3){
								$secuinicialinfo = '000000'.$row['serieinicialinformadaRT'];
							}else{
								if(strlen($row['serieinicialinformadaRT']) == 4){
									$secuinicialinfo = '00000'.$row['serieinicialinformadaRT'];
								}else{
									if(strlen($row['serieinicialinformadaRT']) == 5){
										$secuinicialinfo = '0000'.$row['serieinicialinformadaRT'];
									}else{
										if(strlen($row['serieinicialinformadaRT']) == 6){
											$secuinicialinfo = '000'.$row['serieinicialinformadaRT'];
										}else{
											if(strlen($row['serieinicialinformadaRT']) == 7){
												$secuinicialinfo = '00'.$row['serieinicialinformadaRT'];
											}else{
												if(strlen($row['serieinicialinformadaRT']) == 8){
													$secuinicialinfo = '0'.$row['serieinicialinformadaRT'];
												}else{
													if(strlen($row['serieinicialinformadaRT']) == 9){
														$secuinicialinfo = $row['serieinicialinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['seriefinalinformadaRT']) == 1){
						$secufinainfo = '00000000'.$row['seriefinalinformadaRT'];
					}else{
						if(strlen($row['seriefinalinformadaRT']) == 2){
							$secufinainfo = '0000000'.$row['seriefinalinformadaRT'];
						}else{
							if(strlen($row['seriefinalinformadaRT']) == 3){
								$secufinainfo = '000000'.$row['seriefinalinformadaRT'];
							}else{
								if(strlen($row['seriefinalinformadaRT']) == 4){
									$secufinainfo = '00000'.$row['seriefinalinformadaRT'];
								}else{
									if(strlen($row['seriefinalinformadaRT']) == 5){
										$secufinainfo = '0000'.$row['seriefinalinformadaRT'];
									}else{
										if(strlen($row['seriefinalinformadaRT']) == 6){
											$secufinainfo = '000'.$row['seriefinalinformadaRT'];
										}else{
											if(strlen($row['seriefinalinformadaRT']) == 7){
												$secufinainfo = '00'.$row['seriefinalinformadaRT'];
											}else{
												if(strlen($row['seriefinalinformadaRT']) == 8){
													$secufinainfo = '0'.$row['seriefinalinformadaRT'];
												}else{
													if(strlen($row['seriefinalinformadaRT']) == 9){
														$secufinainfo = $row['seriefinalinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					echo '<tr>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['fechacaducidadA'].'
							</td>
							<td>
								'.$row['fechaprocesoA'].'
							</td>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['strPerfil'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="text-align:center;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="text-align:center;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td>
								'.$row['descripcionRT'].'
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
				echo '<table style="width:100%; color:#fff; font-size:10px; border-collapse:separate; border-spacing:5px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="color:#fff;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>
						<tr>
							<td colspan="13" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 3){
			$numEstab = $_REQUEST['numEstab'];
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE codestablecimientoAHIS LIKE '%$numEstab%'";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE codestablecimientoAHIS LIKE '%$numEstab%' LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:8px; border-collapse:separate; border-spacing:5px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(strlen($row['secuencialinicialA']) == 1){
						$secuinicial = '00000000'.$row['secuencialinicialA'];
					}else{
						if(strlen($row['secuencialinicialA']) == 2){
							$secuinicial = '0000000'.$row['secuencialinicialA'];
						}else{
							if(strlen($row['secuencialinicialA']) == 3){
								$secuinicial = '000000'.$row['secuencialinicialA'];
							}else{
								if(strlen($row['secuencialinicialA']) == 4){
									$secuinicial = '00000'.$row['secuencialinicialA'];
								}else{
									if(strlen($row['secuencialinicialA']) == 5){
										$secuinicial = '0000'.$row['secuencialinicialA'];
									}else{
										if(strlen($row['secuencialinicialA']) == 6){
											$secuinicial = '000'.$row['secuencialinicialA'];
										}else{
											if(strlen($row['secuencialinicialA']) == 7){
												$secuinicial = '00'.$row['secuencialinicialA'];
											}else{
												if(strlen($row['secuencialinicialA']) == 1){
													$secuinicial = '0'.$row['secuencialinicialA'];
												}else{
													if(strlen($row['secuencialinicialA']) == 9){
														$secuinicial = $row['secuencialinicialA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuencialfinalA']) == 1){
						$secufinal = '00000000'.$row['secuencialfinalA'];
					}else{
						if(strlen($row['secuencialfinalA']) == 2){
							$secufinal = '0000000'.$row['secuencialfinalA'];
						}else{
							if(strlen($row['secuencialfinalA']) == 3){
								$secufinal = '000000'.$row['secuencialfinalA'];
							}else{
								if(strlen($row['secuencialfinalA']) == 4){
									$secufinal = '00000'.$row['secuencialfinalA'];
								}else{
									if(strlen($row['secuencialfinalA']) == 5){
										$secufinal = '0000'.$row['secuencialfinalA'];
									}else{
										if(strlen($row['secuencialfinalA']) == 6){
											$secufinal = '000'.$row['secuencialfinalA'];
										}else{
											if(strlen($row['secuencialfinalA']) == 7){
												$secufinal = '00'.$row['secuencialfinalA'];
											}else{
												if(strlen($row['secuencialfinalA']) == 1){
													$secufinal = '0'.$row['secuencialfinalA'];
												}else{
													if(strlen($row['secuencialfinalA']) == 9){
														$secufinal = $row['secuencialfinalA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['serieinicialinformadaRT']) == 1){
						$secuinicialinfo = '00000000'.$row['serieinicialinformadaRT'];
					}else{
						if(strlen($row['serieinicialinformadaRT']) == 2){
							$secuinicialinfo = '0000000'.$row['serieinicialinformadaRT'];
						}else{
							if(strlen($row['serieinicialinformadaRT']) == 3){
								$secuinicialinfo = '000000'.$row['serieinicialinformadaRT'];
							}else{
								if(strlen($row['serieinicialinformadaRT']) == 4){
									$secuinicialinfo = '00000'.$row['serieinicialinformadaRT'];
								}else{
									if(strlen($row['serieinicialinformadaRT']) == 5){
										$secuinicialinfo = '0000'.$row['serieinicialinformadaRT'];
									}else{
										if(strlen($row['serieinicialinformadaRT']) == 6){
											$secuinicialinfo = '000'.$row['serieinicialinformadaRT'];
										}else{
											if(strlen($row['serieinicialinformadaRT']) == 7){
												$secuinicialinfo = '00'.$row['serieinicialinformadaRT'];
											}else{
												if(strlen($row['serieinicialinformadaRT']) == 8){
													$secuinicialinfo = '0'.$row['serieinicialinformadaRT'];
												}else{
													if(strlen($row['serieinicialinformadaRT']) == 9){
														$secuinicialinfo = $row['serieinicialinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['seriefinalinformadaRT']) == 1){
						$secufinainfo = '00000000'.$row['seriefinalinformadaRT'];
					}else{
						if(strlen($row['seriefinalinformadaRT']) == 2){
							$secufinainfo = '0000000'.$row['seriefinalinformadaRT'];
						}else{
							if(strlen($row['seriefinalinformadaRT']) == 3){
								$secufinainfo = '000000'.$row['seriefinalinformadaRT'];
							}else{
								if(strlen($row['seriefinalinformadaRT']) == 4){
									$secufinainfo = '00000'.$row['seriefinalinformadaRT'];
								}else{
									if(strlen($row['seriefinalinformadaRT']) == 5){
										$secufinainfo = '0000'.$row['seriefinalinformadaRT'];
									}else{
										if(strlen($row['seriefinalinformadaRT']) == 6){
											$secufinainfo = '000'.$row['seriefinalinformadaRT'];
										}else{
											if(strlen($row['seriefinalinformadaRT']) == 7){
												$secufinainfo = '00'.$row['seriefinalinformadaRT'];
											}else{
												if(strlen($row['seriefinalinformadaRT']) == 8){
													$secufinainfo = '0'.$row['seriefinalinformadaRT'];
												}else{
													if(strlen($row['seriefinalinformadaRT']) == 9){
														$secufinainfo = $row['seriefinalinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					echo '<tr>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['fechacaducidadA'].'
							</td>
							<td>
								'.$row['fechaprocesoA'].'
							</td>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['strPerfil'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="text-align:center;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="text-align:center;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td>
								'.$row['descripcionRT'].'
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
				echo '<table style="width:100%; color:#fff; font-size:10px; border-collapse:separate; border-spacing:5px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>
						<tr>
							<td colspan="13" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 4){
			$pEmision = $_REQUEST['pEmision'];
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE serieemisionA LIKE '%$pEmision%'";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE serieemisionA LIKE '%$pEmision%' LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:8px; border-collapse:separate; border-spacing:5px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(strlen($row['secuencialinicialA']) == 1){
						$secuinicial = '00000000'.$row['secuencialinicialA'];
					}else{
						if(strlen($row['secuencialinicialA']) == 2){
							$secuinicial = '0000000'.$row['secuencialinicialA'];
						}else{
							if(strlen($row['secuencialinicialA']) == 3){
								$secuinicial = '000000'.$row['secuencialinicialA'];
							}else{
								if(strlen($row['secuencialinicialA']) == 4){
									$secuinicial = '00000'.$row['secuencialinicialA'];
								}else{
									if(strlen($row['secuencialinicialA']) == 5){
										$secuinicial = '0000'.$row['secuencialinicialA'];
									}else{
										if(strlen($row['secuencialinicialA']) == 6){
											$secuinicial = '000'.$row['secuencialinicialA'];
										}else{
											if(strlen($row['secuencialinicialA']) == 7){
												$secuinicial = '00'.$row['secuencialinicialA'];
											}else{
												if(strlen($row['secuencialinicialA']) == 1){
													$secuinicial = '0'.$row['secuencialinicialA'];
												}else{
													if(strlen($row['secuencialinicialA']) == 9){
														$secuinicial = $row['secuencialinicialA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuencialfinalA']) == 1){
						$secufinal = '00000000'.$row['secuencialfinalA'];
					}else{
						if(strlen($row['secuencialfinalA']) == 2){
							$secufinal = '0000000'.$row['secuencialfinalA'];
						}else{
							if(strlen($row['secuencialfinalA']) == 3){
								$secufinal = '000000'.$row['secuencialfinalA'];
							}else{
								if(strlen($row['secuencialfinalA']) == 4){
									$secufinal = '00000'.$row['secuencialfinalA'];
								}else{
									if(strlen($row['secuencialfinalA']) == 5){
										$secufinal = '0000'.$row['secuencialfinalA'];
									}else{
										if(strlen($row['secuencialfinalA']) == 6){
											$secufinal = '000'.$row['secuencialfinalA'];
										}else{
											if(strlen($row['secuencialfinalA']) == 7){
												$secufinal = '00'.$row['secuencialfinalA'];
											}else{
												if(strlen($row['secuencialfinalA']) == 1){
													$secufinal = '0'.$row['secuencialfinalA'];
												}else{
													if(strlen($row['secuencialfinalA']) == 9){
														$secufinal = $row['secuencialfinalA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['serieinicialinformadaRT']) == 1){
						$secuinicialinfo = '00000000'.$row['serieinicialinformadaRT'];
					}else{
						if(strlen($row['serieinicialinformadaRT']) == 2){
							$secuinicialinfo = '0000000'.$row['serieinicialinformadaRT'];
						}else{
							if(strlen($row['serieinicialinformadaRT']) == 3){
								$secuinicialinfo = '000000'.$row['serieinicialinformadaRT'];
							}else{
								if(strlen($row['serieinicialinformadaRT']) == 4){
									$secuinicialinfo = '00000'.$row['serieinicialinformadaRT'];
								}else{
									if(strlen($row['serieinicialinformadaRT']) == 5){
										$secuinicialinfo = '0000'.$row['serieinicialinformadaRT'];
									}else{
										if(strlen($row['serieinicialinformadaRT']) == 6){
											$secuinicialinfo = '000'.$row['serieinicialinformadaRT'];
										}else{
											if(strlen($row['serieinicialinformadaRT']) == 7){
												$secuinicialinfo = '00'.$row['serieinicialinformadaRT'];
											}else{
												if(strlen($row['serieinicialinformadaRT']) == 8){
													$secuinicialinfo = '0'.$row['serieinicialinformadaRT'];
												}else{
													if(strlen($row['serieinicialinformadaRT']) == 9){
														$secuinicialinfo = $row['serieinicialinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['seriefinalinformadaRT']) == 1){
						$secufinainfo = '00000000'.$row['seriefinalinformadaRT'];
					}else{
						if(strlen($row['seriefinalinformadaRT']) == 2){
							$secufinainfo = '0000000'.$row['seriefinalinformadaRT'];
						}else{
							if(strlen($row['seriefinalinformadaRT']) == 3){
								$secufinainfo = '000000'.$row['seriefinalinformadaRT'];
							}else{
								if(strlen($row['seriefinalinformadaRT']) == 4){
									$secufinainfo = '00000'.$row['seriefinalinformadaRT'];
								}else{
									if(strlen($row['seriefinalinformadaRT']) == 5){
										$secufinainfo = '0000'.$row['seriefinalinformadaRT'];
									}else{
										if(strlen($row['seriefinalinformadaRT']) == 6){
											$secufinainfo = '000'.$row['seriefinalinformadaRT'];
										}else{
											if(strlen($row['seriefinalinformadaRT']) == 7){
												$secufinainfo = '00'.$row['seriefinalinformadaRT'];
											}else{
												if(strlen($row['seriefinalinformadaRT']) == 8){
													$secufinainfo = '0'.$row['seriefinalinformadaRT'];
												}else{
													if(strlen($row['seriefinalinformadaRT']) == 9){
														$secufinainfo = $row['seriefinalinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					echo '<tr>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['fechacaducidadA'].'
							</td>
							<td>
								'.$row['fechaprocesoA'].'
							</td>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['strPerfil'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="text-align:center;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="text-align:center;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td>
								'.$row['descripcionRT'].'
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
				echo '<table style="width:100%; color:#fff; font-size:10px; border-collapse:separate; border-spacing:5px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>
						<tr>
							<td colspan="13" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 5){
			$razonsocial = $_REQUEST['razonsocial'];
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE nombrecomercialAHIS LIKE '%$razonsocial%'";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE nombrecomercialAHIS LIKE '%$razonsocial%' LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:8px; border-collapse:separate; border-spacing:5px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td style="color:#fff;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(strlen($row['secuencialinicialA']) == 1){
						$secuinicial = '00000000'.$row['secuencialinicialA'];
					}else{
						if(strlen($row['secuencialinicialA']) == 2){
							$secuinicial = '0000000'.$row['secuencialinicialA'];
						}else{
							if(strlen($row['secuencialinicialA']) == 3){
								$secuinicial = '000000'.$row['secuencialinicialA'];
							}else{
								if(strlen($row['secuencialinicialA']) == 4){
									$secuinicial = '00000'.$row['secuencialinicialA'];
								}else{
									if(strlen($row['secuencialinicialA']) == 5){
										$secuinicial = '0000'.$row['secuencialinicialA'];
									}else{
										if(strlen($row['secuencialinicialA']) == 6){
											$secuinicial = '000'.$row['secuencialinicialA'];
										}else{
											if(strlen($row['secuencialinicialA']) == 7){
												$secuinicial = '00'.$row['secuencialinicialA'];
											}else{
												if(strlen($row['secuencialinicialA']) == 1){
													$secuinicial = '0'.$row['secuencialinicialA'];
												}else{
													if(strlen($row['secuencialinicialA']) == 9){
														$secuinicial = $row['secuencialinicialA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuencialfinalA']) == 1){
						$secufinal = '00000000'.$row['secuencialfinalA'];
					}else{
						if(strlen($row['secuencialfinalA']) == 2){
							$secufinal = '0000000'.$row['secuencialfinalA'];
						}else{
							if(strlen($row['secuencialfinalA']) == 3){
								$secufinal = '000000'.$row['secuencialfinalA'];
							}else{
								if(strlen($row['secuencialfinalA']) == 4){
									$secufinal = '00000'.$row['secuencialfinalA'];
								}else{
									if(strlen($row['secuencialfinalA']) == 5){
										$secufinal = '0000'.$row['secuencialfinalA'];
									}else{
										if(strlen($row['secuencialfinalA']) == 6){
											$secufinal = '000'.$row['secuencialfinalA'];
										}else{
											if(strlen($row['secuencialfinalA']) == 7){
												$secufinal = '00'.$row['secuencialfinalA'];
											}else{
												if(strlen($row['secuencialfinalA']) == 1){
													$secufinal = '0'.$row['secuencialfinalA'];
												}else{
													if(strlen($row['secuencialfinalA']) == 9){
														$secufinal = $row['secuencialfinalA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['serieinicialinformadaRT']) == 1){
						$secuinicialinfo = '00000000'.$row['serieinicialinformadaRT'];
					}else{
						if(strlen($row['serieinicialinformadaRT']) == 2){
							$secuinicialinfo = '0000000'.$row['serieinicialinformadaRT'];
						}else{
							if(strlen($row['serieinicialinformadaRT']) == 3){
								$secuinicialinfo = '000000'.$row['serieinicialinformadaRT'];
							}else{
								if(strlen($row['serieinicialinformadaRT']) == 4){
									$secuinicialinfo = '00000'.$row['serieinicialinformadaRT'];
								}else{
									if(strlen($row['serieinicialinformadaRT']) == 5){
										$secuinicialinfo = '0000'.$row['serieinicialinformadaRT'];
									}else{
										if(strlen($row['serieinicialinformadaRT']) == 6){
											$secuinicialinfo = '000'.$row['serieinicialinformadaRT'];
										}else{
											if(strlen($row['serieinicialinformadaRT']) == 7){
												$secuinicialinfo = '00'.$row['serieinicialinformadaRT'];
											}else{
												if(strlen($row['serieinicialinformadaRT']) == 8){
													$secuinicialinfo = '0'.$row['serieinicialinformadaRT'];
												}else{
													if(strlen($row['serieinicialinformadaRT']) == 9){
														$secuinicialinfo = $row['serieinicialinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['seriefinalinformadaRT']) == 1){
						$secufinainfo = '00000000'.$row['seriefinalinformadaRT'];
					}else{
						if(strlen($row['seriefinalinformadaRT']) == 2){
							$secufinainfo = '0000000'.$row['seriefinalinformadaRT'];
						}else{
							if(strlen($row['seriefinalinformadaRT']) == 3){
								$secufinainfo = '000000'.$row['seriefinalinformadaRT'];
							}else{
								if(strlen($row['seriefinalinformadaRT']) == 4){
									$secufinainfo = '00000'.$row['seriefinalinformadaRT'];
								}else{
									if(strlen($row['seriefinalinformadaRT']) == 5){
										$secufinainfo = '0000'.$row['seriefinalinformadaRT'];
									}else{
										if(strlen($row['seriefinalinformadaRT']) == 6){
											$secufinainfo = '000'.$row['seriefinalinformadaRT'];
										}else{
											if(strlen($row['seriefinalinformadaRT']) == 7){
												$secufinainfo = '00'.$row['seriefinalinformadaRT'];
											}else{
												if(strlen($row['seriefinalinformadaRT']) == 8){
													$secufinainfo = '0'.$row['seriefinalinformadaRT'];
												}else{
													if(strlen($row['seriefinalinformadaRT']) == 9){
														$secufinainfo = $row['seriefinalinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					echo '<tr>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['fechacaducidadA'].'
							</td>
							<td>
								'.$row['fechaprocesoA'].'
							</td>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['strPerfil'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="text-align:center;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="text-align:center;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td>
								'.$row['descripcionRT'].'
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
				echo '<table style="width:100%; color:#fff; font-size:10px; border-collapse:separate; border-spacing:5px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>
						<tr>
							<td colspan="13" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 6){
			$ruc = $_REQUEST['ruc'];
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE rucAHIS LIKE '%$ruc%'";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE rucAHIS LIKE '%$ruc%' LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:8px; border-collapse:separate; border-spacing:5px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td style="color:#fff;">
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(strlen($row['secuencialinicialA']) == 1){
						$secuinicial = '00000000'.$row['secuencialinicialA'];
					}else{
						if(strlen($row['secuencialinicialA']) == 2){
							$secuinicial = '0000000'.$row['secuencialinicialA'];
						}else{
							if(strlen($row['secuencialinicialA']) == 3){
								$secuinicial = '000000'.$row['secuencialinicialA'];
							}else{
								if(strlen($row['secuencialinicialA']) == 4){
									$secuinicial = '00000'.$row['secuencialinicialA'];
								}else{
									if(strlen($row['secuencialinicialA']) == 5){
										$secuinicial = '0000'.$row['secuencialinicialA'];
									}else{
										if(strlen($row['secuencialinicialA']) == 6){
											$secuinicial = '000'.$row['secuencialinicialA'];
										}else{
											if(strlen($row['secuencialinicialA']) == 7){
												$secuinicial = '00'.$row['secuencialinicialA'];
											}else{
												if(strlen($row['secuencialinicialA']) == 1){
													$secuinicial = '0'.$row['secuencialinicialA'];
												}else{
													if(strlen($row['secuencialinicialA']) == 9){
														$secuinicial = $row['secuencialinicialA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuencialfinalA']) == 1){
						$secufinal = '00000000'.$row['secuencialfinalA'];
					}else{
						if(strlen($row['secuencialfinalA']) == 2){
							$secufinal = '0000000'.$row['secuencialfinalA'];
						}else{
							if(strlen($row['secuencialfinalA']) == 3){
								$secufinal = '000000'.$row['secuencialfinalA'];
							}else{
								if(strlen($row['secuencialfinalA']) == 4){
									$secufinal = '00000'.$row['secuencialfinalA'];
								}else{
									if(strlen($row['secuencialfinalA']) == 5){
										$secufinal = '0000'.$row['secuencialfinalA'];
									}else{
										if(strlen($row['secuencialfinalA']) == 6){
											$secufinal = '000'.$row['secuencialfinalA'];
										}else{
											if(strlen($row['secuencialfinalA']) == 7){
												$secufinal = '00'.$row['secuencialfinalA'];
											}else{
												if(strlen($row['secuencialfinalA']) == 1){
													$secufinal = '0'.$row['secuencialfinalA'];
												}else{
													if(strlen($row['secuencialfinalA']) == 9){
														$secufinal = $row['secuencialfinalA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['serieinicialinformadaRT']) == 1){
						$secuinicialinfo = '00000000'.$row['serieinicialinformadaRT'];
					}else{
						if(strlen($row['serieinicialinformadaRT']) == 2){
							$secuinicialinfo = '0000000'.$row['serieinicialinformadaRT'];
						}else{
							if(strlen($row['serieinicialinformadaRT']) == 3){
								$secuinicialinfo = '000000'.$row['serieinicialinformadaRT'];
							}else{
								if(strlen($row['serieinicialinformadaRT']) == 4){
									$secuinicialinfo = '00000'.$row['serieinicialinformadaRT'];
								}else{
									if(strlen($row['serieinicialinformadaRT']) == 5){
										$secuinicialinfo = '0000'.$row['serieinicialinformadaRT'];
									}else{
										if(strlen($row['serieinicialinformadaRT']) == 6){
											$secuinicialinfo = '000'.$row['serieinicialinformadaRT'];
										}else{
											if(strlen($row['serieinicialinformadaRT']) == 7){
												$secuinicialinfo = '00'.$row['serieinicialinformadaRT'];
											}else{
												if(strlen($row['serieinicialinformadaRT']) == 8){
													$secuinicialinfo = '0'.$row['serieinicialinformadaRT'];
												}else{
													if(strlen($row['serieinicialinformadaRT']) == 9){
														$secuinicialinfo = $row['serieinicialinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['seriefinalinformadaRT']) == 1){
						$secufinainfo = '00000000'.$row['seriefinalinformadaRT'];
					}else{
						if(strlen($row['seriefinalinformadaRT']) == 2){
							$secufinainfo = '0000000'.$row['seriefinalinformadaRT'];
						}else{
							if(strlen($row['seriefinalinformadaRT']) == 3){
								$secufinainfo = '000000'.$row['seriefinalinformadaRT'];
							}else{
								if(strlen($row['seriefinalinformadaRT']) == 4){
									$secufinainfo = '00000'.$row['seriefinalinformadaRT'];
								}else{
									if(strlen($row['seriefinalinformadaRT']) == 5){
										$secufinainfo = '0000'.$row['seriefinalinformadaRT'];
									}else{
										if(strlen($row['seriefinalinformadaRT']) == 6){
											$secufinainfo = '000'.$row['seriefinalinformadaRT'];
										}else{
											if(strlen($row['seriefinalinformadaRT']) == 7){
												$secufinainfo = '00'.$row['seriefinalinformadaRT'];
											}else{
												if(strlen($row['seriefinalinformadaRT']) == 8){
													$secufinainfo = '0'.$row['seriefinalinformadaRT'];
												}else{
													if(strlen($row['seriefinalinformadaRT']) == 9){
														$secufinainfo = $row['seriefinalinformadaRT'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					echo '<tr>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['fechacaducidadA'].'
							</td>
							<td>
								'.$row['fechaprocesoA'].'
							</td>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['strPerfil'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="text-align:center;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="text-align:center;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td>
								'.$row['descripcionRT'].'
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
				echo '<table style="width:100%; color:#fff; font-size:10px; border-collapse:separate; border-spacing:5px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Fecha Caducidad</strong>
							</td>
							<td>
								<strong>Fecha y Hora del Proceso</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>Nro. Autorizaci&oacute;n</strong>
							</td>
							<td style="color:#fff;">
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Secuencial Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Secuencial Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
						</tr>
						<tr>
							<td colspan="13" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
	}
	
	//Reimpresiones
	if($data == 6){
		$idBuscador = $_REQUEST['id'];
		if($idBuscador == 2){
			$desde = $_REQUEST['desde'];
			$hasta = $_REQUEST['hasta'];
			$hora = date('H:i:s');
			$desde = $desde.' '.$hora;
			$hasta = $hasta.' '.$hora;
			$select = "SELECT fechaprocesoRS, strNombreU, strPerfil, observacionRS, nroautorizacionA, fechaautorizacioA, tipodocumentoA, rucAHIS, nombrecomercialAHIS, secuencialinicialA, secuencialfinalA, secuinicialRS, secufinalRS, codestablecimientoAHIS, serieemisionA FROM reimpresiones JOIN Usuario ON reimpresiones.idusuarioRS = Usuario.idUsuario JOIN autorizaciones ON reimpresiones.idautoRS = autorizaciones.idAutorizacion JOIN Socio ON reimpresiones.idsocioRS = Socio.idSocio WHERE fechaprocesoRS >= ? AND fechaprocesoRS <= ? ORDER BY idReimpresiones DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute(array($desde,$hasta));
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT fechaprocesoRS, strNombreU, strPerfil, observacionRS, nroautorizacionA, fechaautorizacioA, tipodocumentoA, rucAHIS, nombrecomercialAHIS, secuencialinicialA, secuencialfinalA, secuinicialRS, secufinalRS, codestablecimientoAHIS, serieemisionA FROM reimpresiones JOIN Usuario ON reimpresiones.idusuarioRS = Usuario.idUsuario JOIN autorizaciones ON reimpresiones.idautoRS = autorizaciones.idAutorizacion JOIN Socio ON reimpresiones.idsocioRS = Socio.idSocio WHERE fechaprocesoRS >= ? AND fechaprocesoRS <= ? ORDER BY idReimpresiones DESC LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($desde,$hasta,$offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:9px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td style="color:#fff;">
								<strong>Fecha/Hora</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Nombre<strong>
							</td>
							<td>
								<strong>Motivo</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>R.U.C</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Sec. Reimpresa</p><p>Inicial - Final</p></strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					if(strlen($row['secuencialinicialA']) == 1){
						$secuinicial = '00000000'.$row['secuencialinicialA'];
					}else{
						if(strlen($row['secuencialinicialA']) == 2){
							$secuinicial = '0000000'.$row['secuencialinicialA'];
						}else{
							if(strlen($row['secuencialinicialA']) == 3){
								$secuinicial = '000000'.$row['secuencialinicialA'];
							}else{
								if(strlen($row['secuencialinicialA']) == 4){
									$secuinicial = '00000'.$row['secuencialinicialA'];
								}else{
									if(strlen($row['secuencialinicialA']) == 5){
										$secuinicial = '0000'.$row['secuencialinicialA'];
									}else{
										if(strlen($row['secuencialinicialA']) == 6){
											$secuinicial = '000'.$row['secuencialinicialA'];
										}else{
											if(strlen($row['secuencialinicialA']) == 7){
												$secuinicial = '00'.$row['secuencialinicialA'];
											}else{
												if(strlen($row['secuencialinicialA']) == 1){
													$secuinicial = '0'.$row['secuencialinicialA'];
												}else{
													if(strlen($row['secuencialinicialA']) == 9){
														$secuinicial = $row['secuencialinicialA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuencialfinalA']) == 1){
						$secufinal = '00000000'.$row['secuencialfinalA'];
					}else{
						if(strlen($row['secuencialfinalA']) == 2){
							$secufinal = '0000000'.$row['secuencialfinalA'];
						}else{
							if(strlen($row['secuencialfinalA']) == 3){
								$secufinal = '000000'.$row['secuencialfinalA'];
							}else{
								if(strlen($row['secuencialfinalA']) == 4){
									$secufinal = '00000'.$row['secuencialfinalA'];
								}else{
									if(strlen($row['secuencialfinalA']) == 5){
										$secufinal = '0000'.$row['secuencialfinalA'];
									}else{
										if(strlen($row['secuencialfinalA']) == 6){
											$secufinal = '000'.$row['secuencialfinalA'];
										}else{
											if(strlen($row['secuencialfinalA']) == 7){
												$secufinal = '00'.$row['secuencialfinalA'];
											}else{
												if(strlen($row['secuencialfinalA']) == 1){
													$secufinal = '0'.$row['secuencialfinalA'];
												}else{
													if(strlen($row['secuencialfinalA']) == 9){
														$secufinal = $row['secuencialfinalA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuinicialRS']) == 1){
						$secuinicialreim = '00000000'.$row['secuinicialRS'];
					}else{
						if(strlen($row['secuinicialRS']) == 2){
							$secuinicialreim = '0000000'.$row['secuinicialRS'];
						}else{
							if(strlen($row['secuinicialRS']) == 3){
								$secuinicialreim = '000000'.$row['secuinicialRS'];
							}else{
								if(strlen($row['secuinicialRS']) == 4){
									$secuinicialreim = '00000'.$row['secuinicialRS'];
								}else{
									if(strlen($row['secuinicialRS']) == 5){
										$secuinicialreim = '0000'.$row['secuinicialRS'];
									}else{
										if(strlen($row['secuinicialRS']) == 6){
											$secuinicialreim = '000'.$row['secuinicialRS'];
										}else{
											if(strlen($row['secuinicialRS']) == 7){
												$secuinicialreim = '00'.$row['secuinicialRS'];
											}else{
												if(strlen($row['secuinicialRS']) == 8){
													$secuinicialreim = '0'.$row['secuinicialRS'];
												}else{
													if(strlen($row['secuinicialRS']) == 9){
														$secuinicialreim = $row['secuinicialRS'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secufinalRS']) == 1){
						$secufinareim = '00000000'.$row['secufinalRS'];
					}else{
						if(strlen($row['secufinalRS']) == 2){
							$secufinareim = '0000000'.$row['secufinalRS'];
						}else{
							if(strlen($row['secufinalRS']) == 3){
								$secufinareim = '000000'.$row['secufinalRS'];
							}else{
								if(strlen($row['secufinalRS']) == 4){
									$secufinareim = '00000'.$row['secufinalRS'];
								}else{
									if(strlen($row['secufinalRS']) == 5){
										$secufinareim = '0000'.$row['secufinalRS'];
									}else{
										if(strlen($row['secufinalRS']) == 6){
											$secufinareim = '000'.$row['secufinalRS'];
										}else{
											if(strlen($row['secufinalRS']) == 7){
												$secufinareim = '00'.$row['secufinalRS'];
											}else{
												if(strlen($row['secufinalRS']) == 8){
													$secufinareim = '0'.$row['secufinalRS'];
												}else{
													if(strlen($row['secufinalRS']) == 9){
														$secufinareim = $row['secufinalRS'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					echo '<tr>
							<td>
								'.$row['fechaprocesoRS'].'
							</td>
							<td>
								'.$row['strPerfil'].'
							</td>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['observacionRS'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td>
								'.$secuinicial.' - '.$secufinal.'
							</td>
							<td>
								'.$secuinicialreim.' - '.$secufinareim.'
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
				echo '<table style="width:100%; color:#fff; font-size:10px; border-collapse:separate; border-spacing:15px 15px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td style="color:#fff;">
								<strong>Fecha/Hora</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Nombre</strong>
							</td>
							<td>
								<strong>Motivo</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>R.U.C</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Sec. Reimpresa</p><p>Inicial - Final</p></strong>
							</td>
						</tr>
						<tr>
							<td colspan="10" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 5){
			$razonsocial = $_REQUEST['razonsocial'];
			$select = "SELECT fechaprocesoRS, strNombreU, strPerfil, observacionRS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, rucAHIS, nombrecomercialAHIS, secuencialinicialA, secuencialfinalA, secuinicialRS, secufinalRS, codestablecimientoAHIS, serieemisionA FROM reimpresiones JOIN Usuario ON reimpresiones.idusuarioRS = Usuario.idUsuario JOIN autorizaciones ON reimpresiones.idautoRS = autorizaciones.idAutorizacion JOIN Socio ON reimpresiones.idsocioRS = Socio.idSocio WHERE nombrecomercialAHIS LIKE '%$razonsocial%' ORDER BY idReimpresiones DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT fechaprocesoRS, strNombreU, strPerfil, observacionRS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, rucAHIS, nombrecomercialAHIS, secuencialinicialA, secuencialfinalA, secuinicialRS, secufinalRS, codestablecimientoAHIS, serieemisionA FROM reimpresiones JOIN Usuario ON reimpresiones.idusuarioRS = Usuario.idUsuario JOIN autorizaciones ON reimpresiones.idautoRS = autorizaciones.idAutorizacion JOIN Socio ON reimpresiones.idsocioRS = Socio.idSocio WHERE nombrecomercialAHIS LIKE '%$razonsocial%' ORDER BY idReimpresiones DESC LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:9px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Fecha/Hora</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Nombre</strong>
							</td>
							<td>
								<strong>Motivo</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>R.U.C</strong>
							</td>
							<td style="color:#fff;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Sec. Reimpresa</p><p>Inicial - Final</p></strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					
					if(strlen($row['secuencialinicialA']) == 1){
						$secuinicial = '00000000'.$row['secuencialinicialA'];
					}else{
						if(strlen($row['secuencialinicialA']) == 2){
							$secuinicial = '0000000'.$row['secuencialinicialA'];
						}else{
							if(strlen($row['secuencialinicialA']) == 3){
								$secuinicial = '000000'.$row['secuencialinicialA'];
							}else{
								if(strlen($row['secuencialinicialA']) == 4){
									$secuinicial = '00000'.$row['secuencialinicialA'];
								}else{
									if(strlen($row['secuencialinicialA']) == 5){
										$secuinicial = '0000'.$row['secuencialinicialA'];
									}else{
										if(strlen($row['secuencialinicialA']) == 6){
											$secuinicial = '000'.$row['secuencialinicialA'];
										}else{
											if(strlen($row['secuencialinicialA']) == 7){
												$secuinicial = '00'.$row['secuencialinicialA'];
											}else{
												if(strlen($row['secuencialinicialA']) == 1){
													$secuinicial = '0'.$row['secuencialinicialA'];
												}else{
													if(strlen($row['secuencialinicialA']) == 9){
														$secuinicial = $row['secuencialinicialA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuencialfinalA']) == 1){
						$secufinal = '00000000'.$row['secuencialfinalA'];
					}else{
						if(strlen($row['secuencialfinalA']) == 2){
							$secufinal = '0000000'.$row['secuencialfinalA'];
						}else{
							if(strlen($row['secuencialfinalA']) == 3){
								$secufinal = '000000'.$row['secuencialfinalA'];
							}else{
								if(strlen($row['secuencialfinalA']) == 4){
									$secufinal = '00000'.$row['secuencialfinalA'];
								}else{
									if(strlen($row['secuencialfinalA']) == 5){
										$secufinal = '0000'.$row['secuencialfinalA'];
									}else{
										if(strlen($row['secuencialfinalA']) == 6){
											$secufinal = '000'.$row['secuencialfinalA'];
										}else{
											if(strlen($row['secuencialfinalA']) == 7){
												$secufinal = '00'.$row['secuencialfinalA'];
											}else{
												if(strlen($row['secuencialfinalA']) == 1){
													$secufinal = '0'.$row['secuencialfinalA'];
												}else{
													if(strlen($row['secuencialfinalA']) == 9){
														$secufinal = $row['secuencialfinalA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuinicialRS']) == 1){
						$secuinicialreim = '00000000'.$row['secuinicialRS'];
					}else{
						if(strlen($row['secuinicialRS']) == 2){
							$secuinicialreim = '0000000'.$row['secuinicialRS'];
						}else{
							if(strlen($row['secuinicialRS']) == 3){
								$secuinicialreim = '000000'.$row['secuinicialRS'];
							}else{
								if(strlen($row['secuinicialRS']) == 4){
									$secuinicialreim = '00000'.$row['secuinicialRS'];
								}else{
									if(strlen($row['secuinicialRS']) == 5){
										$secuinicialreim = '0000'.$row['secuinicialRS'];
									}else{
										if(strlen($row['secuinicialRS']) == 6){
											$secuinicialreim = '000'.$row['secuinicialRS'];
										}else{
											if(strlen($row['secuinicialRS']) == 7){
												$secuinicialreim = '00'.$row['secuinicialRS'];
											}else{
												if(strlen($row['secuinicialRS']) == 8){
													$secuinicialreim = '0'.$row['secuinicialRS'];
												}else{
													if(strlen($row['secuinicialRS']) == 9){
														$secuinicialreim = $row['secuinicialRS'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secufinalRS']) == 1){
						$secufinareim = '00000000'.$row['secufinalRS'];
					}else{
						if(strlen($row['secufinalRS']) == 2){
							$secufinareim = '0000000'.$row['secufinalRS'];
						}else{
							if(strlen($row['secufinalRS']) == 3){
								$secufinareim = '000000'.$row['secufinalRS'];
							}else{
								if(strlen($row['secufinalRS']) == 4){
									$secufinareim = '00000'.$row['secufinalRS'];
								}else{
									if(strlen($row['secufinalRS']) == 5){
										$secufinareim = '0000'.$row['secufinalRS'];
									}else{
										if(strlen($row['secufinalRS']) == 6){
											$secufinareim = '000'.$row['secufinalRS'];
										}else{
											if(strlen($row['secufinalRS']) == 7){
												$secufinareim = '00'.$row['secufinalRS'];
											}else{
												if(strlen($row['secufinalRS']) == 8){
													$secufinareim = '0'.$row['secufinalRS'];
												}else{
													if(strlen($row['secufinalRS']) == 9){
														$secufinareim = $row['secufinalRS'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					echo '<tr>
							<td>
								'.$row['fechaprocesoRS'].'
							</td>
							<td>
								'.$row['strPerfil'].'
							</td>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['observacionRS'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td>
								'.$secuinicial.' - '.$secufinal.'
							</td>
							<td>
								'.$secuinicialreim.' - '.$secufinareim.'
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
				echo '<table style="width:100%; color:#fff; font-size:10px; border-collapse:separate; border-spacing:15px 15px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Fecha/Hora</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Nombre</strong>
							</td>
							<td>
								<strong>Motivo</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>R.U.C</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Sec. Reimpresa</p><p>Inicial - Final</p></strong>
							</td>
						</tr>
						<tr>
							<td colspan="10" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 6){
			$ruc = $_REQUEST['ruc'];
			$select = "SELECT fechaprocesoRS, strNombreU, strPerfil, observacionRS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, rucAHIS, nombrecomercialAHIS, secuencialinicialA, secuencialfinalA, secuinicialRS, secufinalRS, codestablecimientoAHIS, serieemisionA FROM reimpresiones JOIN Usuario ON reimpresiones.idusuarioRS = Usuario.idUsuario JOIN autorizaciones ON reimpresiones.idautoRS = autorizaciones.idAutorizacion JOIN Socio ON reimpresiones.idsocioRS = Socio.idSocio WHERE rucAHIS LIKE '%$ruc%' ORDER BY idReimpresiones DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT fechaprocesoRS, strNombreU, strPerfil, observacionRS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, rucAHIS, nombrecomercialAHIS, secuencialinicialA, secuencialfinalA, secuinicialRS, secufinalRS, codestablecimientoAHIS, serieemisionA FROM reimpresiones JOIN Usuario ON reimpresiones.idusuarioRS = Usuario.idUsuario JOIN autorizaciones ON reimpresiones.idautoRS = autorizaciones.idAutorizacion JOIN Socio ON reimpresiones.idsocioRS = Socio.idSocio WHERE rucAHIS LIKE '%$ruc%' ORDER BY idReimpresiones DESC LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:9px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Fecha/Hora</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Nombre</strong>
							</td>
							<td>
								<strong>Motivo</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td style="color:#fff;">
								<strong>R.U.C</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Sec. Reimpresa</p><p>Inicial - Final</p></strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if(strlen($row['secuencialinicialA']) == 1){
						$secuinicial = '00000000'.$row['secuencialinicialA'];
					}else{
						if(strlen($row['secuencialinicialA']) == 2){
							$secuinicial = '0000000'.$row['secuencialinicialA'];
						}else{
							if(strlen($row['secuencialinicialA']) == 3){
								$secuinicial = '000000'.$row['secuencialinicialA'];
							}else{
								if(strlen($row['secuencialinicialA']) == 4){
									$secuinicial = '00000'.$row['secuencialinicialA'];
								}else{
									if(strlen($row['secuencialinicialA']) == 5){
										$secuinicial = '0000'.$row['secuencialinicialA'];
									}else{
										if(strlen($row['secuencialinicialA']) == 6){
											$secuinicial = '000'.$row['secuencialinicialA'];
										}else{
											if(strlen($row['secuencialinicialA']) == 7){
												$secuinicial = '00'.$row['secuencialinicialA'];
											}else{
												if(strlen($row['secuencialinicialA']) == 1){
													$secuinicial = '0'.$row['secuencialinicialA'];
												}else{
													if(strlen($row['secuencialinicialA']) == 9){
														$secuinicial = $row['secuencialinicialA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuencialfinalA']) == 1){
						$secufinal = '00000000'.$row['secuencialfinalA'];
					}else{
						if(strlen($row['secuencialfinalA']) == 2){
							$secufinal = '0000000'.$row['secuencialfinalA'];
						}else{
							if(strlen($row['secuencialfinalA']) == 3){
								$secufinal = '000000'.$row['secuencialfinalA'];
							}else{
								if(strlen($row['secuencialfinalA']) == 4){
									$secufinal = '00000'.$row['secuencialfinalA'];
								}else{
									if(strlen($row['secuencialfinalA']) == 5){
										$secufinal = '0000'.$row['secuencialfinalA'];
									}else{
										if(strlen($row['secuencialfinalA']) == 6){
											$secufinal = '000'.$row['secuencialfinalA'];
										}else{
											if(strlen($row['secuencialfinalA']) == 7){
												$secufinal = '00'.$row['secuencialfinalA'];
											}else{
												if(strlen($row['secuencialfinalA']) == 1){
													$secufinal = '0'.$row['secuencialfinalA'];
												}else{
													if(strlen($row['secuencialfinalA']) == 9){
														$secufinal = $row['secuencialfinalA'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secuinicialRS']) == 1){
						$secuinicialreim = '00000000'.$row['secuinicialRS'];
					}else{
						if(strlen($row['secuinicialRS']) == 2){
							$secuinicialreim = '0000000'.$row['secuinicialRS'];
						}else{
							if(strlen($row['secuinicialRS']) == 3){
								$secuinicialreim = '000000'.$row['secuinicialRS'];
							}else{
								if(strlen($row['secuinicialRS']) == 4){
									$secuinicialreim = '00000'.$row['secuinicialRS'];
								}else{
									if(strlen($row['secuinicialRS']) == 5){
										$secuinicialreim = '0000'.$row['secuinicialRS'];
									}else{
										if(strlen($row['secuinicialRS']) == 6){
											$secuinicialreim = '000'.$row['secuinicialRS'];
										}else{
											if(strlen($row['secuinicialRS']) == 7){
												$secuinicialreim = '00'.$row['secuinicialRS'];
											}else{
												if(strlen($row['secuinicialRS']) == 8){
													$secuinicialreim = '0'.$row['secuinicialRS'];
												}else{
													if(strlen($row['secuinicialRS']) == 9){
														$secuinicialreim = $row['secuinicialRS'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					if(strlen($row['secufinalRS']) == 1){
						$secufinareim = '00000000'.$row['secufinalRS'];
					}else{
						if(strlen($row['secufinalRS']) == 2){
							$secufinareim = '0000000'.$row['secufinalRS'];
						}else{
							if(strlen($row['secufinalRS']) == 3){
								$secufinareim = '000000'.$row['secufinalRS'];
							}else{
								if(strlen($row['secufinalRS']) == 4){
									$secufinareim = '00000'.$row['secufinalRS'];
								}else{
									if(strlen($row['secufinalRS']) == 5){
										$secufinareim = '0000'.$row['secufinalRS'];
									}else{
										if(strlen($row['secufinalRS']) == 6){
											$secufinareim = '000'.$row['secufinalRS'];
										}else{
											if(strlen($row['secufinalRS']) == 7){
												$secufinareim = '00'.$row['secufinalRS'];
											}else{
												if(strlen($row['secufinalRS']) == 8){
													$secufinareim = '0'.$row['secufinalRS'];
												}else{
													if(strlen($row['secufinalRS']) == 9){
														$secufinareim = $row['secufinalRS'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
					echo '<tr>
							<td>
								'.$row['fechaprocesoRS'].'
							</td>
							<td>
								'.$row['strPerfil'].'
							</td>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['observacionRS'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td>
								'.$secuinicial.' - '.$secufinal.'
							</td>
							<td>
								'.$secuinicialreim.' - '.$secufinareim.'
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
				echo '<table style="width:100%; color:#fff; font-size:10px; border-collapse:separate; border-spacing:15px 15px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Fecha/Hora</strong>
							</td>
							<td>
								<strong>Usuario</strong>
							</td>
							<td>
								<strong>Nombre</strong>
							</td>
							<td>
								<strong>Motivo</strong>
							</td>
							<td>
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Tipo de Documento</strong>
							</td>
							<td>
								<strong>R.U.C</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Serie</strong>
							</td>
							<td>
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td>
								<strong><p>Sec. Reimpresa</p><p>Inicial - Final</p></strong>
							</td>
						</tr>
						<tr>
							<td colspan="10" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
	}
	
	//Paginador del log de clientes
	if($data == 7){
		$idBuscador = $_REQUEST['id'];
		if($idBuscador == 2){
			$desde = $_REQUEST['desde'];
			$hasta = $_REQUEST['hasta'];
			$select = "SELECT nombresS, mailS, telmovilS, rucAHIS, nombrecomercialAHIS, tipocontribuyenteAHIS, dirmatrizAHIS, direstablecimientoAHIS, codestablecimientoAHIS, serieemisionA, nroespecialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, secuencialinicialA, secuencialfinalA, actividadS, montodocS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE fechaautorizacioA >= ? AND fechaautorizacioA <= ? ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute(array($desde,$hasta));
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT nombresS, mailS, telmovilS, rucAHIS, nombrecomercialAHIS, tipocontribuyenteAHIS, dirmatrizAHIS, direstablecimientoAHIS, codestablecimientoAHIS, serieemisionA, nroespecialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, secuencialinicialA, secuencialfinalA, actividadS, montodocS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE fechaautorizacioA >= ? AND fechaautorizacioA <= ? ORDER BY idAutorizacion DESC LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($desde,$hasta,$offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:6px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>RUC</strong>
							</td>
							<td>
								<strong>Tipo de<br>Contribuyente</strong>
							</td>
							<td>
								<strong># Con. Especial</strong>
							</td>
							<td>
								<strong>Actividad<br>Econ&oacute;mica</strong>
							</td>
							<td>
								<strong>Categorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Matriz</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Establecimiento</strong>
							</td>
							<td>
								<strong>Correo<br>Electr&oacute;nico</strong>
							</td>
							<td>
								<strong>Tel&eacute;fono</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td>
								<strong>Fecha de<br> Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de<br>Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Documento</strong>
							</td>
							<td>
								<strong>Secuencia<br>Inicial - Final</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					$nest = $row['codestablecimientoAHIS'];
					if((strlen($nest) == 1)){
						$numesta = '00'.$nest; 
					}else{
						if((strlen($nest) == 2)){
							$numesta = '0'.$nest; 
						}else{
							if((strlen($nest) > 2)){
								$numesta = $row['codestablecimientoAHIS']; 
							}
						}
					}
					
					if($row['imprimirparaA'] == 'm'){
						$sucursal = $row['dirmatrizAHIS'];
					}else if($row['imprimirparaA'] == 's'){
						$sucursal = $row['direstablecimientoAHIS'];
					}
					echo '<tr>
							<td>
								'.$row['nombresS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['tipocontribuyenteAHIS'].'
							</td>
							<td>
								'.$row['nroespecialAHIS'].'
							</td>
							<td>
								'.$row['actividadS'].'
							</td>
							<td>
								'.$row['montodocS'].'
							</td>
							<td>
								'.$row['dirmatrizAHIS'].'
							</td>
							<td>
								'.$sucursal.'
							</td>
							<td>
								'.$row['mailS'].'
							</td>
							<td>
								'.$row['telmovilS'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].' - '.$row['serieemisionA'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['secuencialinicialA'].' - '.$row['secuencialfinalA'].'
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
				echo '<table style="width:100%; color:#fff; font-size:8px; border-collapse:separate; border-spacing:15px 15px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>RUC</strong>
							</td>
							<td>
								<strong>Tipo de<br>Contribuyente</strong>
							</td>
							<td>
								<strong># Con. Especial</strong>
							</td>
							<td>
								<strong>Actividad<br>Econ&oacute;mica</strong>
							</td>
							<td>
								<strong>Categorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Matriz</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Establecimiento</strong>
							</td>
							<td>
								<strong>Correo<br>Electr&oacute;nico</strong>
							</td>
							<td>
								<strong>Tel&eacute;fono</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td>
								<strong>Fecha de<br> Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de<br>Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Documento</strong>
							</td>
							<td>
								<strong>Secuencia<br>Inicial - Final</strong>
							</td>
						</tr>
						<tr>
							<td colspan="13" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 5){
			$razonsocial = $_REQUEST['razonsocial'];
			$select = "SELECT nombresS, mailS, telmovilS, rucAHIS, nombrecomercialAHIS, tipocontribuyenteAHIS, dirmatrizAHIS, direstablecimientoAHIS, codestablecimientoAHIS, serieemisionA, nroespecialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, secuencialinicialA, secuencialfinalA, actividadS, montodocS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE nombrecomercialAHIS LIKE '%$razonsocial%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT nombresS, mailS, telmovilS, rucAHIS, nombrecomercialAHIS, tipocontribuyenteAHIS, dirmatrizAHIS, direstablecimientoAHIS, codestablecimientoAHIS, serieemisionA, nroespecialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, secuencialinicialA, secuencialfinalA, actividadS, montodocS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE nombrecomercialAHIS LIKE '%$razonsocial%' ORDER BY idAutorizacion DESC LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:6px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>RUC</strong>
							</td>
							<td>
								<strong>Tipo de<br>Contribuyente</strong>
							</td>
							<td>
								<strong># Con. Especial</strong>
							</td>
							<td>
								<strong>Actividad<br>Econ&oacute;mica</strong>
							</td>
							<td>
								<strong>Categorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Matriz</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Establecimiento</strong>
							</td>
							<td>
								<strong>Correo<br>Electr&oacute;nico</strong>
							</td>
							<td>
								<strong>Tel&eacute;fono</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td>
								<strong>Fecha de<br> Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de<br>Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Documento</strong>
							</td>
							<td>
								<strong>Secuencia<br>Inicial - Final</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					$nest = $row['codestablecimientoAHIS'];
					if((strlen($nest) == 1)){
						$numesta = '00'.$nest; 
					}else{
						if((strlen($nest) == 2)){
							$numesta = '0'.$nest; 
						}else{
							if((strlen($nest) > 2)){
								$numesta = $row['codestablecimientoAHIS']; 
							}
						}
					}
					
					if($row['imprimirparaA'] == 'm'){
						$sucursal = $row['dirmatrizAHIS'];
					}else if($row['imprimirparaA'] == 's'){
						$sucursal = $row['direstablecimientoAHIS'];
					}
					echo '<tr>
							<td>
								'.$row['nombresS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['tipocontribuyenteAHIS'].'
							</td>
							<td>
								'.$row['nroespecialAHIS'].'
							</td>
							<td>
								'.$row['actividadS'].'
							</td>
							<td>
								'.$row['montodocS'].'
							</td>
							<td>
								'.$row['dirmatrizAHIS'].'
							</td>
							<td>
								'.$sucursal.'
							</td>
							<td>
								'.$row['mailS'].'
							</td>
							<td>
								'.$row['telmovilS'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].' - '.$row['serieemisionA'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['secuencialinicialA'].' - '.$row['secuencialfinalA'].'
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
				echo '<table style="width:100%; color:#fff; font-size:8px; border-collapse:separate; border-spacing:15px 15px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>RUC</strong>
							</td>
							<td>
								<strong>Tipo de<br>Contribuyente</strong>
							</td>
							<td>
								<strong># Con. Especial</strong>
							</td>
							<td>
								<strong>Actividad<br>Econ&oacute;mica</strong>
							</td>
							<td>
								<strong>Categorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Matriz</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Establecimiento</strong>
							</td>
							<td>
								<strong>Correo<br>Electr&oacute;nico</strong>
							</td>
							<td>
								<strong>Tel&eacute;fono</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td>
								<strong>Fecha de<br> Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de<br>Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Documento</strong>
							</td>
							<td>
								<strong>Secuencia<br>Inicial - Final</strong>
							</td>
						</tr>
						<tr>
							<td colspan="13" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		
		if($idBuscador == 6){
			$ruc = $_REQUEST['ruc'];
			$select = "SELECT nombresS, mailS, telmovilS, rucAHIS, nombrecomercialAHIS, tipocontribuyenteAHIS, dirmatrizAHIS, direstablecimientoAHIS, codestablecimientoAHIS, serieemisionA, nroespecialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, secuencialinicialA, secuencialfinalA, actividadS, montodocS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE rucAHIS LIKE '%$ruc%' ORDER BY idAutorizacion DESC";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			
			if($num_total_registros > 0){
				$rowsPerPage = 20;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT nombresS, mailS, telmovilS, rucAHIS, nombrecomercialAHIS, tipocontribuyenteAHIS, dirmatrizAHIS, direstablecimientoAHIS, codestablecimientoAHIS, serieemisionA, nroespecialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, secuencialinicialA, secuencialfinalA, actividadS, montodocS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE rucAHIS LIKE '%$ruc%' ORDER BY idAutorizacion DESC LIMIT ?, ?";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($offset,$rowsPerPage));
				
				echo '<table class="sidatos" style="width:100%; color:#fff; font-size:6px; border-collapse:separate; border-spacing:15px 15px;"> 
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>RUC</strong>
							</td>
							<td>
								<strong>Tipo de<br>Contribuyente</strong>
							</td>
							<td>
								<strong># Con. Especial</strong>
							</td>
							<td>
								<strong>Actividad<br>Econ&oacute;mica</strong>
							</td>
							<td>
								<strong>Categorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Matriz</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Establecimiento</strong>
							</td>
							<td>
								<strong>Correo<br>Electr&oacute;nico</strong>
							</td>
							<td>
								<strong>Tel&eacute;fono</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td>
								<strong>Fecha de<br> Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de<br>Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Documento</strong>
							</td>
							<td>
								<strong>Secuencia<br>Inicial - Final</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					$nest = $row['codestablecimientoAHIS'];
					if((strlen($nest) == 1)){
						$numesta = '00'.$nest; 
					}else{
						if((strlen($nest) == 2)){
							$numesta = '0'.$nest; 
						}else{
							if((strlen($nest) > 2)){
								$numesta = $row['codestablecimientoAHIS']; 
							}
						}
					}
					
					if($row['imprimirparaA'] == 'm'){
						$sucursal = $row['dirmatrizAHIS'];
					}else if($row['imprimirparaA'] == 's'){
						$sucursal = $row['direstablecimientoAHIS'];
					}
					echo '<tr>
							<td>
								'.$row['nombresS'].'
							</td>
							<td>
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td>
								'.$row['rucAHIS'].'
							</td>
							<td>
								'.$row['tipocontribuyenteAHIS'].'
							</td>
							<td>
								'.$row['nroespecialAHIS'].'
							</td>
							<td>
								'.$row['actividadS'].'
							</td>
							<td>
								'.$row['montodocS'].'
							</td>
							<td>
								'.$row['dirmatrizAHIS'].'
							</td>
							<td>
								'.$sucursal.'
							</td>
							<td>
								'.$row['mailS'].'
							</td>
							<td>
								'.$row['telmovilS'].'
							</td>
							<td>
								'.$row['codestablecimientoAHIS'].' - '.$row['serieemisionA'].'
							</td>
							<td>
								'.$row['fechaautorizacioA'].'
							</td>
							<td>
								'.$row['nroautorizacionA'].'
							</td>
							<td>
								'.$row['tipodocumentoA'].'
							</td>
							<td>
								'.$row['secuencialinicialA'].' - '.$row['secuencialfinalA'].'
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
				echo '<table style="width:100%; color:#fff; font-size:8px; border-collapse:separate; border-spacing:15px 15px;">
						<tr style="text-align:center; color:#00ADEF;">
							<td>
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td>
								<strong>Nombre Comercial</strong>
							</td>
							<td>
								<strong>RUC</strong>
							</td>
							<td>
								<strong>Tipo de<br>Contribuyente</strong>
							</td>
							<td>
								<strong># Con. Especial</strong>
							</td>
							<td>
								<strong>Actividad<br>Econ&oacute;mica</strong>
							</td>
							<td>
								<strong>Categorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Matriz</strong>
							</td>
							<td>
								<strong>Direcci&oacute;n<br>Establecimiento</strong>
							</td>
							<td>
								<strong>Correo<br>Electr&oacute;nico</strong>
							</td>
							<td>
								<strong>Tel&eacute;fono</strong>
							</td>
							<td>
								<strong>C&oacute;digo</strong>
							</td>
							<td>
								<strong>Fecha de<br> Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Nro. de<br>Autorizaci&oacute;n</strong>
							</td>
							<td>
								<strong>Documento</strong>
							</td>
							<td>
								<strong>Secuencia<br>Inicial - Final</strong>
							</td>
						</tr>
						<tr>
							<td colspan="13" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
	}
?>