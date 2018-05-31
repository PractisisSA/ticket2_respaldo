<?php
	date_default_timezone_set('America/Guayaquil');
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$data = $_REQUEST['sector'];
	//datos lista usuarios
	if($data == 1){
		$idBuscador = $_REQUEST['dato'];
		if($idBuscador == 1){
			$perfil = $_REQUEST['perfil'];
			$select = "SELECT * FROM Usuario WHERE strPerfil = ?";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute(array($perfil));
			$num_total_registros = $stmt -> rowCount();
			if($num_total_registros > 0){
				$rowsPerPage = 200;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT * FROM Usuario WHERE strPerfil = ? LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array($perfil));
				
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;">
				 
						<tr style="color:#00ADEF;">
							<td>
								<strong>Nombre</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Cédula</strong>
							</td>
							<td style="color:#fff;">
								<strong>Direccion</strong>
							</td>
							<td>
								<strong>Telefono</strong>
							</td>
							<td>
								<strong>Editar</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if ($row['strEstadoU'] == 'Inactivo') {
						echo '<tr>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['strMailU'].'
							</td>
							<td>
								'.$row['strCedulaU'].'
							</td>
							<td>
								'.$row['strDireccionU'].'
							</td>
							<td>
								'.$row['strTelU'].'
							</td>
							<td>
								<a href="?modulo=editarUsuario&id='.$row['idUsuario'].'" class="btnlink">Editar</a>
								<a class="btnlink" style="cursor:pointer; margin-top:95px;" onclick="cambiarEstadoUserAct('.$row['idUsuario'].')">Activar</a>
							</td>
						</tr>';
					}else{
						echo '<tr>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['strMailU'].'
							</td>
							<td>
								'.$row['strCedulaU'].'
							</td>
							<td>
								'.$row['strDireccionU'].'
							</td>
							<td>
								'.$row['strTelU'].'
							</td>
							<td>
								<a href="?modulo=editarUsuario&id='.$row['idUsuario'].'" class="btnlink">Editar</a>
								<a class="btnlink" style="cursor:pointer; margin-top:95px;" onclick="cambiarEstadoUserDes('.$row['idUsuario'].')">Desactivar</a>
							</td>
						</tr>';
					}
				}
				echo '</table>
					<br>
					<table  id = "desglose" align="center">
					
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
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;">
				 
						<tr style="color:#00ADEF;">
							<td style="color:#fff;">
								<strong>Nombre</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Cédula</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
							<td>
								<strong>Editar</strong>
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
		if($idBuscador == 2){
			$nombre = $_REQUEST['nombre'];
			$select = "SELECT * FROM Usuario WHERE strPerfil != ? AND strNombreU LIKE '%$nombre%' order by strMailU asc";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute(array('SP'));
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 200;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT * FROM Usuario WHERE strPerfil != ? AND strNombreU LIKE '%$nombre%' order by strMailU asc LIMIT $offset, $rowsPerPage ";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute(array('SP'));
				
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;">
				 
						<tr style="color:#00ADEF;">
							<td style="color:#fff;">
								<strong>Nombre</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Cédula</strong>
							</td>
							<td>
								<strong>Direccion</strong>
							</td>
							<td>
								<strong>Telefono</strong>
							</td>
							<td>
								<strong>Editar</strong>
							</td>
						</tr>';
				$i = 0;
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if ($row['strEstadoU'] == 'Inactivo') {
						echo '<tr>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['strMailU'].'
							</td>
							<td>
								'.$row['strCedulaU'].'
							</td>
							<td>
								'.$row['strDireccionU'].'
							</td>
							<td>
								'.$row['strTelU'].'
							</td>
							<td>
								<a href="?modulo=editarUsuario&id='.$row['idUsuario'].'" class="btnlink">Editar</a>
								<a class="btnlink" style="cursor:pointer; margin-top:95px;" onclick="cambiarEstadoUserAct('.$row['idUsuario'].')">Activar</a>
							</td>
						</tr>';
					}else{
						echo '<tr>
							<td>
								'.$row['strNombreU'].'
							</td>
							<td>
								'.$row['strMailU'].'
							</td>
							<td>
								'.$row['strCedulaU'].'
							</td>
							<td>
								'.$row['strDireccionU'].'
							</td>
							<td>
								'.$row['strTelU'].'
							</td>
							<td>
								<a href="?modulo=editarUsuario&id='.$row['idUsuario'].'" class="btnlink">Editar</a>
								<a class="btnlink" style="cursor:pointer; margin-top:95px;" onclick="cambiarEstadoUserDes('.$row['idUsuario'].')">Desactivar</a>
							</td>
						</tr>';
					}
				}
				echo '</table>
					<br>
					<table id = "desglose" align="center">
					 
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
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;"> 
				 
						<tr style="color:#00ADEF;">
							<td style="color:#fff;">
								<strong>Nombre</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Cédula</strong>
							</td>
							<td>
								<strong>Perfil</strong>
							</td>
							<td>
								<strong>Estado</strong>
							</td>
							<td>
								<strong>Editar</strong>
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
	
	//datos lista socios
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
				$rowsPerPage = 200;
				$pageNum = 1;
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT * FROM Socio WHERE rucS LIKE '%$ruc%' LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;">
				 
						<tr style="color:#00ADEF;">
							<td style="color:#fff;">
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre del Socio</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
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
					}else{
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
								<center><a id="editar'.$row['idSocio'].'" class="btnlink" href="?modulo=editSocio&id='.$row['idSocio'].'">Editar</a></center>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table id = "desglose" align="center">
					
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
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;">
				 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre del Socio</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
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
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		if($idBuscador == 2){
			$nombre = $_REQUEST['nombre'];
			$select = "SELECT * FROM Socio WHERE nombresS LIKE '%$nombre%'";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 200;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT * FROM Socio WHERE nombresS LIKE '%$nombre%' LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;">
				 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td style="color:#fff;">
								<strong>Nombre del Socio</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
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
					}else{
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
								<center><a id="editar'.$row['idSocio'].'" class="btnlink" href="?modulo=editSocio&id='.$row['idSocio'].'">Editar</a></center>
							</td>
						</tr>';
				}
				echo '</table>
					<br>
					<table id = "desglose" align="center">
					
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
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;">
				 
						<tr style="color:#00ADEF;">
							<td>
								<strong>R.U.C.</strong>
							</td>
							<td>
								<strong>Nombre del Socio</strong>
							</td>
							<td>
								<strong>Raz&oacute;n Social</strong>
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
							<td colspan="7" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
	}
	
	//datos distribuidor
	if($data == 7){
		$idBuscador = $_REQUEST['dato'];
		if($idBuscador == 1){
			$ruc = $_REQUEST['ruc'];
			$select = "SELECT * FROM distribuidor WHERE documentoDis LIKE '%$ruc%'";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			// echo $num_total_registros;
			if($num_total_registros > 0){
				$rowsPerPage = 200;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT * FROM distribuidor WHERE documentoDis LIKE '%$ruc%' LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;">
				 
						<tr style="color:#00ADEF;">
							<td>
								<strong>Nombres</strong>
							</td>
							<td style="color:#fff;">
								<strong>Identificación</strong>
							</td>
							<td>
								<strong>Teléfono</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Editar</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if($row['estadoDis'] == 'Inactivo'){
						$textbutton = '<a class="btnlink" style="cursor:pointer; margin-top:95px;" onclick="cambiarEstadoAct('.$row['idDistribuidor'].')">Activar</a><a class="btnlink" style="cursor:pointer; " onclick="edicionDistribuidores('.$row['idDistribuidor'].')">Editar</a>';
						echo '<tr>
							<td>
								'.$row['nombreDis'].'
							</td>
							<td>
								'.$row['documentoDis'].'
							</td>
							<td>
								'.$row['telefonoDis'].'
							</td>
							<td>
								'.$row['mailDis'].'
							</td>
							<td>
								'.$textbutton.'
							</td>
						</tr>';
					}else{
						$textbutton = '<a class="btnlink" style="cursor:pointer; margin-top:95px;" onclick="cambiarEstado('.$row['idDistribuidor'].')">Desactivar</a><a class="btnlink" style="cursor:pointer; " onclick="edicionDistribuidores('.$row['idDistribuidor'].')">Editar</a>';
						echo '<tr>
							<td>
								'.$row['nombreDis'].'
							</td>
							<td>
								'.$row['documentoDis'].'
							</td>
							<td>
								'.$row['telefonoDis'].'
							</td>
							<td>
								'.$row['mailDis'].'
							</td>
							<td>
								'.$textbutton.'
							</td>
						</tr>';
					}
				}
				echo '</table>
					<br>
					<table id = "desglose" align="center">
					
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
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;">
				 
						<tr style="color:#00ADEF;">
							<td>
								<strong>Nombres</strong>
							</td>
							<td>
								<strong>Identificación</strong>
							</td>
							<td>
								<strong>Teléfono</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Editar</strong>
							</td>
						</tr>
						<tr>
							<td colspan="5" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
		if($idBuscador == 2){
			$nombre = $_REQUEST['nombre'];
			$select = "SELECT * FROM distribuidor WHERE nombreDis LIKE '%$nombre%'";
			$stmt = $gbd -> prepare($select);
			$stmt -> execute();
			$num_total_registros = $stmt -> rowCount();
			if($num_total_registros > 0){
				$rowsPerPage = 200;
				
				$pageNum = 1;
				
				if(isset($_GET['page'])) {
					sleep(1);
					$pageNum = $_GET['page'];
				}
				
				$offset = ($pageNum - 1) * $rowsPerPage;
				$total_paginas = ceil($num_total_registros / $rowsPerPage);
				
				$selectLimit = "SELECT * FROM distribuidor WHERE nombreDis LIKE '%$nombre%' LIMIT $offset, $rowsPerPage";
				$query_services = $gbd -> prepare($selectLimit);
				$query_services -> execute();
				
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;">
				 
						<tr style="color:#00ADEF;">
							<td style="color:#fff;">
								<strong>Nombres</strong>
							</td>
							<td>
								<strong>Identificación</strong>
							</td>
							<td>
								<strong>Teléfono</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Editar</strong>
							</td>
						</tr>';
				$i = 0;
				
				while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
					if($row['estadoDis'] == 'Inactivo'){
						$textbutton = '<a class="btnlink" style="cursor:pointer; margin-top:95px;" onclick="cambiarEstadoAct('.$row['idDistribuidor'].')">Activar</a><a class="btnlink" style="cursor:pointer; " onclick="edicionDistribuidores('.$row['idDistribuidor'].')">Editar</a>';
						echo '<tr style="display:none;">
							<td>
								'.$row['nombreDis'].'
							</td>
							<td>
								'.$row['documentoDis'].'
							</td>
							<td>
								'.$row['telefonoDis'].'
							</td>
							<td>
								'.$row['mailDis'].'
							</td>
							<td>
								'.$textbutton.'
							</td>
						</tr>';
					}else{
						$textbutton = '<a class="btnlink" style="cursor:pointer;" onclick="cambiarEstado('.$row['idDistribuidor'].')">Desactivar</a><a class="btnlink" style="cursor:pointer; margin-top:15px;" onclick="edicionDistribuidores('.$row['idDistribuidor'].')">Editar</a>';
						echo '<tr>
							<td>
								'.$row['nombreDis'].'
							</td>
							<td>
								'.$row['documentoDis'].'
							</td>
							<td>
								'.$row['telefonoDis'].'
							</td>
							<td>
								'.$row['mailDis'].'
							</td>
							<td>
								'.$textbutton.'
							</td>
						</tr>';
					}
				}
				echo '</table>
					<br>
					<table id = "desglose" align="center">
					
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
				echo '<table id = "desglose" style="width:100%; color:#fff; font-size:14px; border-collapse:separate; border-spacing:15px 15px;">
						<tr style="color:#00ADEF;">
							<td>
								<strong>Nombres</strong>
							</td>
							<td>
								<strong>Identificación</strong>
							</td>
							<td>
								<strong>Teléfono</strong>
							</td>
							<td>
								<strong>E-mail</strong>
							</td>
							<td>
								<strong>Editar</strong>
							</td>
						</tr>
						<tr>
							<td colspan="5" style="font-size:25px; color:#67E21B;">
								No hay Datos
							</td>
						</tr>
					</table>';
			}
		}
	}
?>