<?php 
	include("../controlusuarios/seguridadAdt.php");
	require_once '../classes/private.db.php';
	include('../html2pdf/html2pdf/html2pdf.class.php');
	
	$gbd = new DBConn();
	
	$log = $_REQUEST['log'];
	$idBuscador = $_REQUEST['id'];
	$timeRightNow = time();
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	
	if($log == 1){
		
	}
	
	if($log == 2){
		if($idBuscador == 1){
			$desde = $_REQUEST['desde'];
			$hasta = $_REQUEST['hasta'];
			
			$select = "SELECT idlogusuario, fechahoraLU, idusuarioLU, idclienteLU, accionLU, detalleantesLU, detalledespuesLU FROM logusuario 
					WHERE fechahoraLU >= ? AND fechahoraLU <= ?";
			$slt = $gbd -> prepare($select);
			$slt -> execute(array($desde,$hasta));
			
			$content = '<table style="font-size:9px; width:550px;">	
						<tr>
							<td style="font-size:10px;">
								<p><strong>LOG DE AUDITORIA DE USUARIOS</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> TICKETFACIL.EC</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE USUARIOS</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:9px; width:500px; border-collapse:separate; border-spacing:2px;">
						<tr>
							<td>
								<strong>Nro. de transacci&oacute;n</strong>
							</td>
							<td>
								<strong>Fechay Hora de transacci&oacute;n</strong>
							</td>
							<td>
								<strong>Usuario que realiz&oacute; el cambio</strong>
							</td>
							<td>
								<strong>Evento realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Detalle de cambio anterior</strong>
							</td>
							<td>
								<strong>Detalle de cambio actual</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$idus = $row['idusuarioLU'];
				$selectuser = "SELECT strNombreU FROM Usuario WHERE idUsuario = ?";
				$us = $gbd -> prepare($selectuser);
				$us -> execute(array($idus));
				$rowus = $us -> fetch(PDO::FETCH_ASSOC);
				
				$idcli = $row['idclienteLU'];
				$selectcli = "SELECT strNombreU FROM Usuario WHERE idUsuario = ?";
				$cli = $gbd -> prepare($selectcli);
				$cli -> execute(array($idcli));
				$rowcli = $cli -> fetch(PDO::FETCH_ASSOC);
				
				$content .='<tr><td>
									'.$row['idlogusuario'].'
								</td>
								<td>
									'.$row['fechahoraLU'].'
								</td>
								<td>
									'.$rowus['strNombreU'].'
								</td>
								<td>
									'.$row['accionLU'].'
								</td>
								<td>
									'.$rowcli['strNombreU'].'
								</td>
								<td>
									'.$row['detalleantesLU'].'
								</td>
								<td>
									'.$row['detalledespuesLU'].'
								</td></tr>';
			}			
			$content .='</table>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				// $html2pdf->Output('pdf/Reporte_LOG_USER'.$timeRightNow.'.pdf','F');
				
				// echo 'Reporte_LOG_USER'.$timeRightNow;
				header('Content-type: application/octet-stream');
				header('Content-Disposition: attachment; filename=Reporte_LOG_USER'.$timeRightNow.'.pdf');
				// header('Pragma: no-cache');
				// header('expires:0');
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		if($idBuscador == 2){
			$nameUser = $_REQUEST['nameUser'];
			
			$select = "SELECT idlogusuario, fechahoraLU, idusuarioLU, idclienteLU, accionLU, detalleantesLU, detalledespuesLU, strNombreU FROM logusuario 
					JOIN Usuario ON logusuario.idusuarioLU = Usuario.idUsuario WHERE strNombreU LIKE '%$nameUser%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			
			$content = '<table style="font-size:9px; width:500px;">	
						<tr>
							<td style="font-size:10px;">
								<p><strong>LOG DE AUDITORIA DE USUARIOS</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> TICKETFACIL.EC</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE USUARIOS</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:9px; width:550px; border-collapse:separate; border-spacing:2px;">
						<tr>
							<td>
								<strong>Nro. de transacci&oacute;n</strong>
							</td>
							<td>
								<strong>Fechay Hora de transacci&oacute;n</strong>
							</td>
							<td>
								<strong>Usuario que realiz&oacute; el cambio</strong>
							</td>
							<td>
								<strong>Evento realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Detalle de cambio anterior</strong>
							</td>
							<td>
								<strong>Detalle de cambio actual</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$idus = $row['idusuarioLU'];
				$selectuser = "SELECT strNombreU FROM Usuario WHERE idUsuario = ?";
				$us = $gbd -> prepare($selectuser);
				$us -> execute(array($idus));
				$rowus = $us -> fetch(PDO::FETCH_ASSOC);
				
				$idcli = $row['idclienteLU'];
				$selectcli = "SELECT strNombreU FROM Usuario WHERE idUsuario = ?";
				$cli = $gbd -> prepare($selectcli);
				$cli -> execute(array($idcli));
				$rowcli = $cli -> fetch(PDO::FETCH_ASSOC);
				
				$content .='<tr><td>
									'.$row['idlogusuario'].'
								</td>
								<td>
									'.$row['fechahoraLU'].'
								</td>
								<td>
									'.$rowus['strNombreU'].'
								</td>
								<td>
									'.$row['accionLU'].'
								</td>
								<td>
									'.$rowcli['strNombreU'].'
								</td>
								<td>
									'.$row['detalleantesLU'].'
								</td>
								<td>
									'.$row['detalledespuesLU'].'
								</td></tr>';
			}			
			$content .='</table>';
			
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
		
		if($idBuscador == 3){
			$nameCli = $_REQUEST['nameCli'];
			
			$select = "SELECT idlogusuario, fechahoraLU, idusuarioLU, idclienteLU, accionLU, detalleantesLU, detalledespuesLU, strNombreU FROM logusuario 
					JOIN Usuario ON logusuario.idclienteLU = Usuario.idUsuario WHERE strNombreU LIKE '%$nameCli%'";
			$slt = $gbd -> prepare($select);
			$slt -> execute();
			
			$content = '<table style="font-size:9px; width:500px;">	
						<tr>
							<td style="font-size:10px;">
								<p><strong>LOG DE AUDITORIA DE USUARIOS</strong></p>
							</td>
						</tr>
						<tr>
							<td>
								<p><strong>Nombre del Contribuyente:</strong> TICKETFACIL.EC</p>
								<p><strong>Usuario que genero LOG: </strong>'.$_SESSION['useractual'].'('.$_SESSION['perfil'].')</p>
								<p><strong>Titulo del LOG: </strong>LOG DE USUARIOS</p>
								<p><strong>Fecha y Hora de Emision: </strong>'.$fecha.' - '.$hora.'</p>
							</td>
						</tr>
						</table>
						<br>
						<br>
						<table style="font-size:9px; width:550px; border-collapse:separate; border-spacing:2px;">
						<tr>
							<td>
								<strong>Nro. de transacci&oacute;n</strong>
							</td>
							<td>
								<strong>Fechay Hora de transacci&oacute;n</strong>
							</td>
							<td>
								<strong>Usuario que realiz&oacute; el cambio</strong>
							</td>
							<td>
								<strong>Evento realizado</strong>
							</td>
							<td>
								<strong>Usuario Afectado</strong>
							</td>
							<td>
								<strong>Detalle de cambio anterior</strong>
							</td>
							<td>
								<strong>Detalle de cambio actual</strong>
							</td>
						</tr>';
			while ($row = $slt -> fetch(PDO::FETCH_ASSOC)){
				
				$idus = $row['idusuarioLU'];
				$selectuser = "SELECT strNombreU FROM Usuario WHERE idUsuario = ?";
				$us = $gbd -> prepare($selectuser);
				$us -> execute(array($idus));
				$rowus = $us -> fetch(PDO::FETCH_ASSOC);
				
				$idcli = $row['idclienteLU'];
				$selectcli = "SELECT strNombreU FROM Usuario WHERE idUsuario = ?";
				$cli = $gbd -> prepare($selectcli);
				$cli -> execute(array($idcli));
				$rowcli = $cli -> fetch(PDO::FETCH_ASSOC);
				
				$content .='<tr><td>
									'.$row['idlogusuario'].'
								</td>
								<td>
									'.$row['fechahoraLU'].'
								</td>
								<td>
									'.$rowus['strNombreU'].'
								</td>
								<td>
									'.$row['accionLU'].'
								</td>
								<td>
									'.$rowcli['strNombreU'].'
								</td>
								<td>
									'.$row['detalleantesLU'].'
								</td>
								<td>
									'.$row['detalledespuesLU'].'
								</td></tr>';
			}			
			$content .='</table>';
			
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
	
	if($log == 3){
		
	}
?>