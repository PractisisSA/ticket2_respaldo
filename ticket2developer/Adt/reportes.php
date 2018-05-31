<?php
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadAdt.php");
	require_once '../classes/private.db.php';
	include('../html2pdf/html2pdf/html2pdf.class.php');
	
	$gbd = new DBConn();
	
	$log = $_REQUEST['log'];
	$idBuscador = $_REQUEST['id'];
	$timeRightNow = time();
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	
	$sql = "SELECT * FROM ticktfacil";
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute();
	$rowemp = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	//LOG TRIBUTARIO
	//Creacion de reportes del log
	if($log == 1){
		//Reporte por fechas
		if($idBuscador == 1){
			$desde = $_REQUEST['desde'];
			$hasta = $_REQUEST['hasta'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por fechas del LOG TRIBUTARIO';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idlogtributario, fechahoraLT, strNombreU, strPerfil, nombresS, accionLT, campoLT, detalleantesLT, detalledespuesLT FROM logtributario
						JOIN Socio ON logtributario.idclienteLT = Socio.idSocio JOIN Usuario ON logtributario.idusuarioLT = Usuario.idUsuario
						WHERE fechahoraLT >= ? AND fechahoraLT <= ? AND tipoLT != 'Empresa'";
			$slt = $gbd -> prepare($select);
			$slt -> execute(array($desde,$hasta));
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE AUDITORIA TRIBUTARIA</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG TRIBUTARIO</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:7px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td style="border:1px solid #000;">
								<strong>Nro. de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fechay Hora de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario que realiz&oacute; el cambio</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Evento realizado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario Afectado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Campo Modificado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio anterior</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio actual</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$content .='<tr><td style="border:1px solid #000;">
									'.$row['idlogtributario'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechahoraLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['strNombreU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['strPerfil'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['accionLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nombresS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['campoLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalleantesLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalledespuesLT'].'
								</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			//Creacion del reporte
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_TRIB'.$timeRightNow.'.pdf','F');
				
				// readfile($ruta);
				
				echo 'Reporte_LOG_TRIB'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		//Reporte por nombre de usuario
		if($idBuscador == 2){
			$nameUser = $_REQUEST['nombreUser'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por nombre de Usuario del LOG TRIBUTARIO';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idlogtributario, fechahoraLT, strNombreU, strPerfil, nombresS, accionLT, campoLT, detalleantesLT, detalledespuesLT FROM logtributario
						JOIN Socio ON logtributario.idclienteLT = Socio.idSocio JOIN Usuario ON logtributario.idusuarioLT = Usuario.idUsuario
						WHERE strNombreU LIKE '%$nameUser%' AND tipoLT != 'Empresa'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:500px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE AUDITORIA TRIBUTARIA</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG TRIBUTARIO</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:7px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td style="border:1px solid #000;">
								<strong>Nro. de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fechay Hora de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario que realiz&oacute; el cambio</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Evento realizado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario Afectado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Campo Modificado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio anterior</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio actual</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$content .='<tr><td style="border:1px solid #000;">
									'.$row['idlogtributario'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechahoraLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['strNombreU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['strPerfil'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['accionLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nombresS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['campoLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalleantesLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalledespuesLT'].'
								</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			//Creacion del reporte
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_TRIB'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_TRIB'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		//Reporte por nombre de cliente o socio
		if($idBuscador == 3){
			$nameCli = $_REQUEST['nameCli'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por nombre de Cliente del LOG TRIBUTARIO';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idlogtributario, fechahoraLT, strNombreU, strPerfil, nombresS, accionLT, campoLT, detalleantesLT, detalledespuesLT FROM logtributario
						JOIN Socio ON logtributario.idclienteLT = Socio.idSocio JOIN Usuario ON logtributario.idusuarioLT = Usuario.idUsuario
						WHERE nombresS LIKE '%$nameCli%' AND tipoLT != 'Empresa'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:500px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE AUDITORIA TRIBUTARIA</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG TRIBUTARIO</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:7px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td style="border:1px solid #000;">
								<strong>Nro. de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fechay Hora de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario que realiz&oacute; el cambio</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Evento realizado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario Afectado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Campo Modificado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio anterior</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio actual</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$content .='<tr><td style="border:1px solid #000;">
									'.$row['idlogtributario'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechahoraLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['strNombreU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['strPerfil'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['accionLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nombresS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['campoLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalleantesLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalledespuesLT'].'
								</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_TRIB'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_TRIB'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		if($idBuscador == 4){
			$Emp = $_REQUEST['Emp'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por Empresa del LOG TRIBUTARIO';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idlogtributario, fechahoraLT, strNombreU, strPerfil, accionLT, campoLT, nombresTF, detalleantesLT, detalledespuesLT, tipoLT FROM logtributario
						JOIN ticktfacil ON logtributario.idclienteLT = ticktfacil.idticketFacil JOIN Usuario ON logtributario.idusuarioLT = Usuario.idUsuario
						WHERE tipoLT LIKE '%$Emp%' AND tipoLT = 'Empresa'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:500px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE AUDITORIA TRIBUTARIA</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG TRIBUTARIO</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:7px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td style="border:1px solid #000;">
								<strong>Nro. de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fechay Hora de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario que realiz&oacute; el cambio</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Evento realizado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario Afectado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Campo Modificado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio anterior</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio actual</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$content .='<tr><td style="border:1px solid #000;">
									'.$row['idlogtributario'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechahoraLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['strNombreU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['strPerfil'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['accionLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nombresTF'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['campoLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalleantesLT'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalledespuesLT'].'
								</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_TRIB'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_TRIB'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
	}
	
	//LOG USUARIOS
	//Creacion de reportes del log
	if($log == 2){
		//Reporte por fecha
		if($idBuscador == 1){
			$desde = $_REQUEST['desde'];
			$hasta = $_REQUEST['hasta'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por fechas del LOG DE USUARIOS';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idlogusuario, fechahoraLU, idusuarioLU, idclienteLU, campoLU, accionLU, detalleantesLU, detalledespuesLU FROM logusuario 
					WHERE fechahoraLU >= ? AND fechahoraLU <= ?";
			$slt = $gbd -> prepare($select);
			$slt -> execute(array($desde,$hasta));
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE AUDITORIA DE USUARIOS</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE USUARIOS</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:7px; width:500px; border-collapse:collapse; border:1px solid #000";">
						<tr>
							<td style="border:1px solid #000;">
								<strong>Nro. de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fechay Hora de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario que realiz&oacute; el cambio</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Evento realizado</strong>
							</td>
							<td style="border:1px solid #000;"> 
								<strong>Usuario Afectado</strong>
							</td>
							<td style="border:1px solid #000;"> 
								<strong>Campo Modificado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio anterior</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio actual</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil del<br> Usuario Afectado</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$idus = $row['idusuarioLU'];
				$selectuser = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = ?";
				$us = $gbd -> prepare($selectuser);
				$us -> execute(array($idus));
				$rowus = $us -> fetch(PDO::FETCH_ASSOC);
				
				$idcli = $row['idclienteLU'];
				$selectcli = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = ?";
				$cli = $gbd -> prepare($selectcli);
				$cli -> execute(array($idcli));
				$rowcli = $cli -> fetch(PDO::FETCH_ASSOC);
				
				$content .='<tr><td style="border:1px solid #000;">
									'.$row['idlogusuario'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechahoraLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowus['strNombreU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowus['strPerfil'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['accionLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowcli['strNombreU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['campoLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalleantesLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalledespuesLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowcli['strPerfil'].'
								</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_USER'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_USER'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		//Reporte por nombre de usuario que modifica
		if($idBuscador == 2){
			$nameUser = $_REQUEST['nombreUser'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por nombre de Usuario del LOG DE USUARIOS';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idlogusuario, fechahoraLU, idusuarioLU, idclienteLU, accionLU, campoLU, detalleantesLU, detalledespuesLU, strNombreU FROM logusuario 
					JOIN Usuario ON logusuario.idusuarioLU = Usuario.idUsuario WHERE strNombreU LIKE '%$nameUser%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:500px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE AUDITORIA DE USUARIOS</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE USUARIOS</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:7px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td style="border:1px solid #000;">
								<strong>Nro. de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fechay Hora de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario que realiz&oacute; el cambio</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Evento realizado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario Afectado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Campo Modificado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio anterior</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio actual</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil del<br> Usuario Afectado</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$idus = $row['idusuarioLU'];
				$selectuser = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = ?";
				$us = $gbd -> prepare($selectuser);
				$us -> execute(array($idus));
				$rowus = $us -> fetch(PDO::FETCH_ASSOC);
				
				$idcli = $row['idclienteLU'];
				$selectcli = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = ?";
				$cli = $gbd -> prepare($selectcli);
				$cli -> execute(array($idcli));
				$rowcli = $cli -> fetch(PDO::FETCH_ASSOC);
				
				$content .='<tr><td style="border:1px solid #000;">
									'.$row['idlogusuario'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechahoraLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowus['strNombreU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowus['strPerfil'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['accionLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowcli['strNombreU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['campoLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalleantesLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalledespuesLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowcli['strPerfil'].'
								</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_USER'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_USER'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		//Reporte por nombre del usuario afectado
		if($idBuscador == 3){
			$nameCli = $_REQUEST['nameCli'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por nombre de Cliente del LOG DE USUARIOS';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idlogusuario, fechahoraLU, idusuarioLU, idclienteLU, accionLU, campoLU, detalleantesLU, detalledespuesLU, strNombreU FROM logusuario 
					JOIN Usuario ON logusuario.idclienteLU = Usuario.idUsuario WHERE strNombreU LIKE '%$nameCli%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:500px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE AUDITORIA DE USUARIOS</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE USUARIOS</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:7px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td style="border:1px solid #000;">
								<strong>Nro. de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fechay Hora de transacci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario que realiz&oacute; el cambio</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Evento realizado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario Afectado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Campo Afectado</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio anterior</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Detalle de cambio actual</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil del<br> Usuario Afectado</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$idus = $row['idusuarioLU'];
				$selectuser = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = ?";
				$us = $gbd -> prepare($selectuser);
				$us -> execute(array($idus));
				$rowus = $us -> fetch(PDO::FETCH_ASSOC);
				
				$idcli = $row['idclienteLU'];
				$selectcli = "SELECT strNombreU, strPerfil FROM Usuario WHERE idUsuario = ?";
				$cli = $gbd -> prepare($selectcli);
				$cli -> execute(array($idcli));
				$rowcli = $cli -> fetch(PDO::FETCH_ASSOC);
				
				$content .='<tr><td style="border:1px solid #000;">
									'.$row['idlogusuario'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechahoraLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowus['strNombreU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowus['strPerfil'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['accionLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowcli['strNombreU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['campoLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalleantesLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['detalledespuesLU'].'
								</td>
								<td style="border:1px solid #000;">
									'.$rowcli['strPerfil'].'
								</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_USER'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_USER'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
	}
	
	//LOG AUTORIZACIONES
	//Creacion de reportes del log
	if($log == 3){
		//Reporte por fechas
		if($idBuscador == 1){
			$desde = $_REQUEST['desde'];
			$hasta = $_REQUEST['hasta'];
			$desdeor = $_REQUEST['desde'];
			$hastaor = $_REQUEST['hasta'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por fechas del LOG DE AUTORIZACIONES';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idAutorizacion, nroautorizacionA, fechaautorizacioA, rucAHIS, nombresS, codestablecimientoAHIS, nombrecomercialAHIS, dirmatrizAHIS, direstablecimientoAHIS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE fechaautorizacioA >= ? AND fechaautorizacioA <= ? OR fechacaducidadA >= ? AND fechacaducidadA <= ?";
			$slt = $gbd -> prepare($select);
			$slt -> execute(array($desde,$hasta,$desdeor,$hastaor));
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE AUTORIZACIONES GENERADAS</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE AUTORIZACIONES GENERADAS</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:8px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td colspan="3" style="text-align:center; border:1px solid #000;">
								<strong>Autorizaci&oacute;n</strong>
							</td>
							<td colspan="2" style="text-align:center; border:1px solid #000;">
								<strong>Cliente</strong>
							</td>
							<td colspan="2" style="text-align:center; border:1px solid #000;">
								<strong>Establecimiento</strong>
							</td>
						</tr>
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>Nro.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>C&oacute;digo</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Nombre Comercial</p>
								<p>Direcci&oacute;n</p></strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				if($row['imprimirparaA'] == 'm'){
					$direccion = $row['dirmatrizAHIS'];
				}else{
					$direccion = $row['direstablecimientoAHIS'];
				}
				
				$content .='<tr style="text-align:center;"><td style="border:1px solid #000;">
									'.$row['idAutorizacion'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nroautorizacionA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechaautorizacioA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['rucAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nombresS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['codestablecimientoAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									<p>'.$row['nombrecomercialAHIS'].'</p>
									<p>'.$direccion.'</p>
								</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_AUTO'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_AUTO'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		//Reporte por razon social
		if($idBuscador == 2){
			$razonsocial = $_REQUEST['razonsocial'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por Razon Social del LOG DE AUTORIZACIONES';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idAutorizacion, nroautorizacionA, fechaautorizacioA, rucAHIS, nombresS, codestablecimientoAHIS, nombrecomercialAHIS, dirmatrizAHIS, direstablecimientoAHIS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE nombrecomercialAHIS LIKE '%$razonsocial%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE AUTORIZACIONES GENERADAS</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE AUTORIZACIONES GENERADAS</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:8px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td colspan="3" style="text-align:center; border:1px solid #000;">
								<strong>Autorizaci&oacute;n</strong>
							</td>
							<td colspan="2" style="text-align:center; border:1px solid #000;">
								<strong>Cliente</strong>
							</td>
							<td colspan="2" style="text-align:center; border:1px solid #000;">
								<strong>Establecimiento</strong>
							</td>
						</tr>
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>Nro.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>C&oacute;digo</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Nombre Comercial</p>
								<p>Direcci&oacute;n</p></strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				if($row['imprimirparaA'] == 'm'){
					$direccion = $row['dirmatrizAHIS'];
				}else{
					$direccion = $row['direstablecimientoAHIS'];
				}
				$content .='<tr style="text-align:center;"><td style="border:1px solid #000;">
									'.$row['idAutorizacion'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nroautorizacionA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechaautorizacioA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['rucAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nombresS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['codestablecimientoAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									<p>'.$row['nombrecomercialAHIS'].'</p>
									<p>'.$direccion.'</p>
								</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_AUTO'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_AUTO'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		//Reporte por nombre del usuario afectado
		if($idBuscador == 3){
			$ruc = $_REQUEST['ruc'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por R.U.C. del LOG DE AUTORIZACIONES';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idAutorizacion, nroautorizacionA, fechaautorizacioA, rucAHIS, nombresS, codestablecimientoAHIS, nombrecomercialAHIS, dirmatrizAHIS, direstablecimientoAHIS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE rucS LIKE '%$ruc%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE AUTORIZACIONES GENERADAS</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE AUTORIZACIONES GENERADAS</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:8px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td colspan="3" style="text-align:center; border:1px solid #000;">
								<strong>Autorizaci&oacute;n</strong>
							</td>
							<td colspan="2" style="text-align:center; border:1px solid #000;">
								<strong>Cliente</strong>
							</td>
							<td colspan="2" style="text-align:center; border:1px solid #000;">
								<strong>Establecimiento</strong>
							</td>
						</tr>
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>Nro.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>C&oacute;digo</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Nombre Comercial</p>
								<p>Direcci&oacute;n</p></strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				if($row['imprimirparaA'] == 'm'){
					$direccion = $row['dirmatrizAHIS'];
				}else{
					$direccion = $row['direstablecimientoAHIS'];
				}
				$content .='<tr style="text-align:center;"><td style="border:1px solid #000;">
									'.$row['idAutorizacion'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nroautorizacionA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechaautorizacioA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['rucAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nombresS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['codestablecimientoAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									<p>'.$row['nombrecomercialAHIS'].'</p>
									<p>'.$direccion.'</p>
								</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_AUTO'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_AUTO'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
	}
	
	//LOG TRANSACIONAL
	//Creacion de reportes del log
	if($log == 4){
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
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por Tipo de Documento del LOG TRANSACCIONAL';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE tipodocumentoA LIKE '%$tipdoc%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG TRANSACCIONAL</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG TRANSACCIONAL</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:6px; width:400px; border-collapse:collapse; border:1px solid #000;">
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>#</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Caducidad</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha/Hora Proceso</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Serie</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Estado</strong>
							</td>
						</tr>';
			
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
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
				$content .='<tr style="text-align:center;"><td style="border:1px solid #000;">
								'.$row['idRegtrabajos'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['rucAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaautorizacioA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechacaducidadA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaprocesoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strNombreU'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strPerfil'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['tipodocumentoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nroautorizacionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="text-align:center; border:1px solid #000;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="text-align:center; border:1px solid #000;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td style="border:1px solid #000;">
								'.$row['descripcionRT'].'
							</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_TRAN'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_TRAN'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		if($idBuscador == 2){
			$desde = $_REQUEST['desde'];
			$hasta = $_REQUEST['hasta'];
			$desdeor = $_REQUEST['desde'];
			$hastaor = $_REQUEST['hasta'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por fechas del LOG TRANSACCIONAL';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE fechaautorizacioA >= ? AND fechaautorizacioA <= ? OR fechacaducidadA >= ? AND fechacaducidadA <= ?";
			$slt = $gbd -> prepare($select);
			$slt -> execute(array($desde,$hasta,$desdeor,$hastaor));
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG TRANSACCIONAL</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG TRANSACCIONAL</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:6px; width:400px; border-collapse:collapse; border:1px solid #000;">
						<tr text-align:center;>
							<td style="border:1px solid #000;">
								<strong>#</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Caducidad</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha/Hora Proceso</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Serie</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Estado</strong>
							</td>
						</tr>';
			
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
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
				$content .='<tr style="text-align:center;"><td style="border:1px solid #000;">
								'.$row['idRegtrabajos'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['rucAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaautorizacioA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechacaducidadA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaprocesoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strNombreU'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strPerfil'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['tipodocumentoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nroautorizacionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="text-align:center; border:1px solid #000;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="text-align:center; border:1px solid #000;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td style="border:1px solid #000;">
								'.$row['descripcionRT'].'
							</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_TRAN'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_TRAN'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		if($idBuscador == 3){
			$numEstab = $_REQUEST['numEstab'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por Codigo de Establecimiento del LOG TRANSACCIONAL';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE codestablecimientoAHIS LIKE '%$numEstab%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG TRANSACCIONAL</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE USUARIOS</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:6px; width:400px; border-collapse:collapse; border:1px solid #000;">
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>#</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Caducidad</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha/Hora Proceso</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Serie</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Estado</strong>
							</td>
						</tr>';
			
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
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
				$content .='<tr style="text-align:center;"><td style="border:1px solid #000;">
								'.$row['idRegtrabajos'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['rucAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaautorizacioA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechacaducidadA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaprocesoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strNombreU'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strPerfil'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['tipodocumentoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nroautorizacionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="text-align:center; border:1px solid #000;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="text-align:center; border:1px solid #000;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td style="border:1px solid #000;">
								'.$row['descripcionRT'].'
							</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_TRAN'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_TRAN'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		if($idBuscador == 4){
			$pEmision = $_REQUEST['pEmision'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por Codigo de Punto de Emision del LOG TRANSACCIONAL';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE serieemisionA LIKE '%$pEmision%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG TRANSACCIONAL</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG TRANSACCIONAL</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:6px; width:400px; border-collapse:collapse; border:1px solid #000;">
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>#</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Caducidad</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha/Hora Proceso</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Serie</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Estado</strong>>
							</td>
						</tr>';
			
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
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
				$content .='<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								'.$row['idRegtrabajos'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['rucAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaautorizacioA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechacaducidadA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaprocesoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strNombreU'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strPerfil'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['tipodocumentoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nroautorizacionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="text-align:center; border:1px solid #000;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="text-align:center; border:1px solid #000;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td style="border:1px solid #000;">
								'.$row['descripcionRT'].'
							</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_TRAN'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_TRAN'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		if($idBuscador == 5){
			$razonsocial = $_REQUEST['razonsocial'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por Razon Social del LOG TRANSACCIONAL';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE nombrecomercialAHIS LIKE '%$razonsocial%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG TRANSACCIONAL</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG TRANSACCIONAL</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:6px; width:400px; border-collapse:collapse; border:1px solid #000;">
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>#</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Caducidad</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha/Hora Proceso</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Serie</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Estado</strong>
							</td>
						</tr>';
			
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
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
				$content .='<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								'.$row['idRegtrabajos'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['rucAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaautorizacioA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechacaducidadA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaprocesoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strNombreU'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strPerfil'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['tipodocumentoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nroautorizacionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="text-align:center; border:1px solid #000;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="text-align:center; border:1px solid #000;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td style="border:1px solid #000;">
								'.$row['descripcionRT'].'
							</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_TRAN'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_TRAN'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		if($idBuscador == 6){
			$ruc = $_REQUEST['ruc'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por R.U.C. del LOG TRANSACCIONAL';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idRegtrabajos, rucAHIS, nombrecomercialAHIS, fechaautorizacioA, fechacaducidadA, fechaprocesoA, strNombreU, strPerfil, tipodocumentoA, nroautorizacionA, codestablecimientoAHIS, serieemisionA, secuencialinicialA, secuencialfinalA, serieinicialinformadaRT, seriefinalinformadaRT, descripcionRT FROM registrotrabajos JOIN autorizaciones ON registrotrabajos.idautorizacionRT = autorizaciones.idAutorizacion JOIN Usuario ON registrotrabajos.idusuarioRT = Usuario.idUsuario WHERE rucAHIS LIKE '%$ruc%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG TRANSACCIONAL</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE USUARIOS</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:6px; width:400px; border-collapse:collapse; border:1px solid #000;">
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>#</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C.</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Caducidad</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha/Hora Proceso</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Serie</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Informada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Estado</strong>
							</td>
						</tr>';
			
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
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
				$content .='<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								'.$row['idRegtrabajos'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['rucAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaautorizacioA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechacaducidadA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaprocesoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strNombreU'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strPerfil'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['tipodocumentoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nroautorizacionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$secuinicial.'-'.$secufinal.'
							</td>
							<td style="border:1px solid #000;">
								'.$secuinicialinfo.'-'.$secufinainfo.'
							</td>
							<td style="border:1px solid #000;">
								'.$row['descripcionRT'].'
							</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_TRAN'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_TRAN'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
	}
	
	//LOG DE ACCESO
	//Creacion de reportes del log
	if($log == 5){
		if($idBuscador == 1){
			$desde = $_REQUEST['desde'].' 00:00:00';
			$hasta = $_REQUEST['hasta'].' 23:59:59';
			
			$select = "SELECT idlogacceso, fechahoraLA, strNombreU, strPerfil, accionLA FROM logaccesoauditoria JOIN Usuario ON logaccesoauditoria.idusuarioLA = Usuario.idUsuario
						WHERE fechahoraLA >= ? AND fechahoraLA <= ?";
			$slt = $gbd -> prepare($select);
			$slt -> execute(array($desde,$hasta));
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE ACCESO Y CONTROL DE AUDITORIA</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE ACCESO Y CONTROL DE AUDITORIA</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:9px; width:400px; border-collapse:collapse; border:1px solid #000;">
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>#</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha y Hora</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Nombre del Usuario</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Evento Realizado</strong>
							</td>
						</tr>';
			
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$content .='<tr style="text-align:center;"><td style="border:1px solid #000;">
								'.$row['idlogacceso'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechahoraLA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strNombreU'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strPerfil'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['accionLA'].'
							</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Registros:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_ACC'.$timeRightNow.'.pdf','F');
				
				$idlog = 'NULL';
				$fechaingreso = date('Y-m-d H:i:s');
				$user = $_SESSION['iduser'];
				$accion = 'Imprimio reporte por fechas del LOG DE ACCESO';
				$estado = 'Activo';
				$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
				$ins = $gbd -> prepare($insert);
				$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
				
				echo 'Reporte_LOG_ACC'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		if($idBuscador == 2){
			$nameUser = $_REQUEST['nameUser'];
			
			$select = "SELECT idlogacceso, fechahoraLA, strNombreU, strPerfil, accionLA FROM logaccesoauditoria JOIN Usuario ON logaccesoauditoria.idusuarioLA = Usuario.idUsuario
						WHERE strNombreU LIKE '%$nameUser%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE ACCESO Y CONTROL DE AUDITORIA</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE ACCESO Y CONTROL DE AUDITORIA</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:9px; width:400px; border-collapse:collapse; border:1px solid #000;">
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>#</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha y Hora</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Nombre del Usuario</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Perfil</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Evento Realizado</strong>
							</td>
						</tr>';
			
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$content .='<tr style="text-align:center;"><td style="border:1px solid #000;">
								'.$row['idlogacceso'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechahoraLA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strNombreU'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strPerfil'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['accionLA'].'
							</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Registros:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_ACC'.$timeRightNow.'.pdf','F');
				
				$idlog = 'NULL';
				$fechaingreso = date('Y-m-d H:i:s');
				$user = $_SESSION['iduser'];
				$accion = 'Imprimio reporte por Nombre de Usuario del LOG DE ACCESO';
				$estado = 'Activo';
				$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
				$ins = $gbd -> prepare($insert);
				$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
				
				echo 'Reporte_LOG_ACC'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
	}
	
	//log de reimpreisones
	if($log == 6){
		//Reporte por fechas
		if($idBuscador == 1){
			$desde = $_REQUEST['desde'];
			$hasta = $_REQUEST['hasta'];
			$hora = date('H:i:s');
			$desde = $desde.' '.$hora;
			$hasta = $hasta.' '.$hora;
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por fechas del LOG DE REIMPRESIONES';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idReimpresiones, fechaprocesoRS, strNombreU, strPerfil, observacionRS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, rucAHIS, nombrecomercialAHIS, secuencialinicialA, secuencialfinalA, secuinicialRS, secufinalRS, codestablecimientoAHIS, serieemisionA FROM reimpresiones JOIN Usuario ON reimpresiones.idusuarioRS = Usuario.idUsuario JOIN autorizaciones ON reimpresiones.idautoRS = autorizaciones.idAutorizacion JOIN Socio ON reimpresiones.idsocioRS = Socio.idSocio WHERE fechaprocesoRS >= ? AND fechaprocesoRS <= ?";
			$slt = $gbd -> prepare($select);
			$slt -> execute(array($desde,$hasta));
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE REIMPRESIONES</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE REIMPRESIONES</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:7px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td style="border:1px solid #000;">
								<strong>#</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha/Hora</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Nombre</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Motivo</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Serie</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Reimpresa</p><p>Inicial - Final</p></strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
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
				$content .='<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								'.$row['idReimpresiones'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaprocesoRS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strPerfil'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strNombreU'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['observacionRS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaautorizacioA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nroautorizacionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['tipodocumentoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['rucAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$secuinicial.' - '.$secufinal.'
							</td>
							<td style="border:1px solid #000;">
								'.$secuinicialreim.' - '.$secufinareim.'
							</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Registros:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_REIMPRE'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_REIMPRE'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		//Reporte por razon social
		if($idBuscador == 2){
			$razonsocial = $_REQUEST['razonsocial'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por Razon Social del LOG DE AUTORIZACIONES';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idReimpresiones, fechaprocesoRS, strNombreU, strPerfil, observacionRS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, rucAHIS, nombrecomercialAHIS, secuencialinicialA, secuencialfinalA, secuinicialRS, secufinalRS, codestablecimientoAHIS, serieemisionA FROM reimpresiones JOIN Usuario ON reimpresiones.idusuarioRS = Usuario.idUsuario JOIN autorizaciones ON reimpresiones.idautoRS = autorizaciones.idAutorizacion JOIN Socio ON reimpresiones.idsocioRS = Socio.idSocio WHERE nombrecomercialAHIS LIKE '%$razonsocial%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE REIMPRESIONES</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE REIMPRESIONES</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:7px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td style="border:1px solid #000;">
								<strong>#</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha/Hora</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Nombre</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Motivo</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Serie</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Reimpresa</p><p>Inicial - Final</p></strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
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
				$content .='<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								'.$row['idReimpresiones'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaprocesoRS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strPerfil'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strNombreU'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['observacionRS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaautorizacioA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nroautorizacionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['tipodocumentoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['rucAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$secuinicial.' - '.$secufinal.'
							</td>
							<td style="border:1px solid #000;">
								'.$secuinicialreim.' - '.$secufinareim.'
							</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Registros:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_REIMPRE'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_REIMPRE'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		//Reporte por nombre del usuario afectado
		if($idBuscador == 3){
			$ruc = $_REQUEST['ruc'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por R.U.C. del LOG DE AUTORIZACIONES';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT idReimpresiones, fechaprocesoRS, strNombreU, strPerfil, observacionRS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, rucAHIS, nombrecomercialAHIS, secuencialinicialA, secuencialfinalA, secuinicialRS, secufinalRS, codestablecimientoAHIS, serieemisionA FROM reimpresiones JOIN Usuario ON reimpresiones.idusuarioRS = Usuario.idUsuario JOIN autorizaciones ON reimpresiones.idautoRS = autorizaciones.idAutorizacion JOIN Socio ON reimpresiones.idsocioRS = Socio.idSocio WHERE rucAHIS LIKE '%$ruc%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE REIMPRESIONES</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE REIMPRESIONES</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:7px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr>
							<td style="border:1px solid #000;">
								<strong>#</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha/Hora</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Usuario</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Nombre</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Motivo</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>R.U.C</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Serie</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Autorizada</p><p>Inicial - Final</p></strong>
							</td>
							<td style="border:1px solid #000;">
								<strong><p>Sec. Reimpresa</p><p>Inicial - Final</p></strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
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
				$content .='<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								'.$row['idReimpresiones'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaprocesoRS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strPerfil'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['strNombreU'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['observacionRS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['fechaautorizacioA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nroautorizacionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['tipodocumentoA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['rucAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['nombrecomercialAHIS'].'
							</td>
							<td style="border:1px solid #000;">
								'.$row['codestablecimientoAHIS'].'-'.$row['serieemisionA'].'
							</td>
							<td style="border:1px solid #000;">
								'.$secuinicial.' - '.$secufinal.'
							</td>
							<td style="border:1px solid #000;">
								'.$secuinicialreim.' - '.$secufinareim.'
							</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Registros:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_REIMPRE'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_REIMPRE'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
	}
	
	//reporte del log de clientes
	if($log == 7){
		//Reporte por fechas
		if($idBuscador == 1){
			$desde = $_REQUEST['desde'];
			$hasta = $_REQUEST['hasta'];
			$desdeor = $_REQUEST['desde'];
			$hastaor = $_REQUEST['hasta'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por fechas del LOG DE CLIENTES';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT nombresS, mailS, telmovilS, rucAHIS, nombrecomercialAHIS, tipocontribuyenteAHIS, dirmatrizAHIS, direstablecimientoAHIS, codestablecimientoAHIS, serieemisionA, nroespecialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, secuencialinicialA, secuencialfinalA, actividadS, montodocS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE fechaautorizacioA >= ? AND fechaautorizacioA <= ? OR fechacaducidadA >= ? AND fechacaducidadA <= ?";
			$slt = $gbd -> prepare($select);
			$slt -> execute(array($desde,$hasta,$desdeor,$hastaor));
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE CLIENTES</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE CLIENTES</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:4px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Nombre Comercial</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>RUC</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de<br>Contribuyente</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Con. Contribuyente</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Actividad<br>Econ&oacute;mica</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Categorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Direcci&oacute;n<br>Matriz</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Direcci&oacute;n<br>Establecimiento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>E-mail</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tel&eacute;fono</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>C&oacute;digo</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha de<br> Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Nro. de<br>Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Secuencia<br>Inicial - Final</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				if($row['imprimirparaA'] == 'm'){
					$sucursal = $row['dirmatrizAHIS'];
				}else{
					$sucursal = $row['direstablecimientoAHIS'];
				}
				$content .='<tr style="text-align:center;">
								<td style="border:1px solid #000;">
									'.$row['nombresS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nombrecomercialAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['rucAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['tipocontribuyenteAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nroespecialAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['actividadS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['montodocS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['dirmatrizAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$sucursal.'
								</td>
								<td style="border:1px solid #000;">
									'.$row['mailS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['telmovilS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['codestablecimientoAHIS'].' - '.$row['serieemisionA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechaautorizacioA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nroautorizacionA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['tipodocumentoA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['secuencialinicialA'].' - '.$row['secuencialfinalA'].'
								</td></tr>';
			}			
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_AUTO'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_AUTO'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		//Reporte por razon social
		if($idBuscador == 2){
			$razonsocial = $_REQUEST['razonsocial'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por Razon Social del LOG DE CLIENTES';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT nombresS, mailS, telmovilS, rucAHIS, nombrecomercialAHIS, tipocontribuyenteAHIS, dirmatrizAHIS, direstablecimientoAHIS, codestablecimientoAHIS, serieemisionA, nroespecialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, secuencialinicialA, secuencialfinalA, actividadS, montodocS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE nombrecomercialAHIS LIKE '%$razonsocial%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			$num_total_registros = $slt -> rowCount();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE CLIENTES</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE CLIENTES</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:4px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Nombre Comercial</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>RUC</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de<br>Contribuyente</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Con. Contribuyente</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Actividad<br>Econ&oacute;mica</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Categorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Direcci&oacute;n<br>Matriz</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Direcci&oacute;n<br>Establecimiento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>E-mail</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tel&eacute;fono</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>C&oacute;digo</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha de<br> Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Nro. de<br>Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Secuencia<br>Inicial - Final</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				if($row['imprimirparaA'] == 'm'){
					$sucursal = $row['dirmatrizAHIS'];
				}else{
					$sucursal = $row['direstablecimientoAHIS'];
				}
				$content .='<tr style="text-align:center;">
								<td style="border:1px solid #000;">
									'.$row['nombresS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nombrecomercialAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['rucAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['tipocontribuyenteAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nroespecialAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['actividadS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['montodocS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['dirmatrizAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$sucursal.'
								</td>
								<td style="border:1px solid #000;">
									'.$row['mailS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['telmovilS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['codestablecimientoAHIS'].' - '.$row['serieemisionA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechaautorizacioA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nroautorizacionA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['tipodocumentoA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['secuencialinicialA'].' - '.$row['secuencialfinalA'].'
								</td></tr>';
			}				
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_AUTO'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_AUTO'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		//Reporte por nombre del usuario afectado
		if($idBuscador == 3){
			$ruc = $_REQUEST['ruc'];
			
			$idlog = 'NULL';
			$fechaingreso = date('Y-m-d H:i:s');
			$user = $_SESSION['iduser'];
			$accion = 'Imprimio reporte por R.U.C. del LOG DE CLIENTES';
			$estado = 'Activo';
			$insert = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array($idlog,$fechaingreso,$user,$accion,$estado));
			
			$select = "SELECT nombresS, mailS, telmovilS, rucAHIS, nombrecomercialAHIS, tipocontribuyenteAHIS, dirmatrizAHIS, direstablecimientoAHIS, codestablecimientoAHIS, serieemisionA, nroespecialAHIS, fechaautorizacioA, fechacaducidadA, nroautorizacionA, tipodocumentoA, secuencialinicialA, secuencialfinalA, actividadS, montodocS, imprimirparaA FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE rucS LIKE '%$ruc%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			
			$content = '<table style="font-size:10px; width:550px;">	
						<tr>
							<td style="font-size:12px;">
								<p><strong>LOG DE CLIENTES</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> '.$rowemp['nombresTF'].'</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE CLIENTES</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:4px; width:500px; border-collapse:collapse; border:1px solid #000;">
						<tr style="text-align:center;">
							<td style="border:1px solid #000;">
								<strong>Raz&oacute;n Social</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Nombre Comercial</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>RUC</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tipo de<br>Contribuyente</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong># Con. Contribuyente</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Actividad<br>Econ&oacute;mica</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Categorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Direcci&oacute;n<br>Matriz</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Direcci&oacute;n<br>Establecimiento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>E-mail</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Tel&eacute;fono</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>C&oacute;digo</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Fecha de<br> Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Nro. de<br>Autorizaci&oacute;n</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Documento</strong>
							</td>
							<td style="border:1px solid #000;">
								<strong>Secuencia<br>Inicial - Final</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				if($row['imprimirparaA'] == 'm'){
					$sucursal = $row['dirmatrizAHIS'];
				}else{
					$sucursal = $row['direstablecimientoAHIS'];
				}
				$content .='<tr style="text-align:center;">
								<td style="border:1px solid #000;">
									'.$row['nombresS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nombrecomercialAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['rucAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['tipocontribuyenteAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nroespecialAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['actividadS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['montodocS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['dirmatrizAHIS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$sucursal.'
								</td>
								<td style="border:1px solid #000;">
									'.$row['mailS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['telmovilS'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['codestablecimientoAHIS'].' - '.$row['serieemisionA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['fechaautorizacioA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['nroautorizacionA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['tipodocumentoA'].'
								</td>
								<td style="border:1px solid #000;">
									'.$row['secuencialinicialA'].' - '.$row['secuencialfinalA'].'
								</td></tr>';
			}		
			$content .='</table><br><br><br><br><div><strong>Total de Transacciones:</strong>&nbsp;&nbsp;'.$num_total_registros.'</div>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/Reporte_LOG_AUTO'.$timeRightNow.'.pdf','F');
				
				echo 'Reporte_LOG_AUTO'.$timeRightNow;
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
	}
?>