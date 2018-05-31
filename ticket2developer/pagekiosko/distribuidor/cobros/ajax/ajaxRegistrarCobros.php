<?php 
	session_start();
	date_default_timezone_set('America/Guayaquil');
	include('../../../controlusuarios/seguridadDis.php');
	require_once('../../../classes/private.db.php');
	include('../../../html2pdf/html2pdf/html2pdf.class.php');
	require_once '../../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../../PHPM/PHPM/class.smtp.php';
	
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	
	$gbd = new DBConn();
	
	$hoy = date("Y-m-d");
	$fechatime = date("Y-m-d H:i:s");
	
	$codigocompra = $_REQUEST['codigo'];
	
	$identificador = $_REQUEST['identificador'];//identificador 1 = preventa o precio normal, identificador 2 = reservacion.
	
	$totalpago = $_REQUEST['total'];
	$num_boletos = $_REQUEST['num_boletos'];
	$formapago = $_REQUEST['formapago'];
	
	if($identificador == 1){
		
		$update = "UPDATE pventa SET estadoPV = ?, estadopagoPV = ? WHERE codigoPV = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array('Revisado','ok',$codigocompra));
		
		$sql = "SELECT strNombresC, strMailC, strDocumentoC, strEnvioC, costoenvioC, strDireccionC, strEvento, strLugar, timeHora, dateFecha, dircanjeC, horariocanjeC, fechainiciocanjeC, fechafinalcanjeC, estadopagoPV FROM pventa p JOIN Cliente c ON p.clientePV = c.idCliente JOIN Concierto co ON p.conciertoPV = co.idConcierto WHERE codigoPV = ? GROUP BY codigoPV";
		$stmt = $gbd -> prepare($sql);
		$stmt -> execute(array($codigocompra));
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);
		
		$sql2 = "SELECT strDescripcionL, doublePrecioL, doublePrecioPreventa, filaPV, columnaPV, numboletosPV, localidadPV, conciertoPV, clientePV, strNombresC, strDocumentoC FROM pventa p JOIN Localidad l ON p.localidadPV = l.idLocalidad JOIN Cliente c ON p.clientePV = c.idCliente WHERE codigoPV = ?";
		$stmt2 = $gbd -> prepare($sql2);
		$stmt2 -> execute(array($codigocompra));
		$numboletos = $stmt2 -> rowCount();
		
		$print = '';
		$counter = 1;
		while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
			$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
			$rand = md5($s.time()).mt_rand(1,10);
			$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'';
			$code = rand(1,9999999999).time();
			$_SESSION['barcode'] = $code;
			
			$update2 = "UPDATE ocupadas SET status = ? WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
			$upd2 = $gbd -> prepare($update2);
			$upd2 -> execute(array(1,$row2['filaPV'],$row2['columnaPV'],$row2['localidadPV'],$row2['conciertoPV']));
			
			$query1 = "INSERT INTO Boleto VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$result = $gbd -> prepare($query1);
			$result -> execute(array('NULL',$rand,$code,$row2['clientePV'],$row2['conciertoPV'],$row2['localidadPV'],$row2['filaPV'],$row2['columnaPV'],$row2['strNombresC'],$row2['strDocumentoC'],'A','S'));
			$idboleto = $gbd -> lastInsertId();
			
			if($row['strEnvioC'] == 'Domicilio'){
			$insert3 = "INSERT INTO domicilio VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins3 = $gbd -> prepare($insert3);
			$ins3 -> execute(array('NULL',$row2['filaPV'],$row2['columnaPV'],1,$row2['localidadPV'],$row2['conciertoPV'],$row2['clientePV'],0,$formapago,'N/A','N/A','N/A','A'));
			}
			
			$sql3 = "SELECT descompra FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
			$stmt3 = $gbd -> prepare($sql3);
			$stmt3 -> execute(array($row2['filaPV'],$row2['columnaPV'],$row2['localidadPV'],$row2['conciertoPV']));
			$row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC);
			$tipocompra = $row3['descompra'];
			if($tipocompra == 1){
				$costoboleto = $row2['doublePrecioPreventa'];
			}else if($tipocompra == 2){
				$costoboleto = $row2['doublePrecioL'];
			}else if($tipocompra == 3){
				$costoboleto = $row2['doublePrecioL'];
			}
			
			$trans = "INSERT INTO transaccion_distribuidor VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$stmttrans = $gbd -> prepare($trans);
			$stmttrans -> execute(array('NULL',$row2['clientePV'],$row2['conciertoPV'],$row2['localidadPV'],$_SESSION['idDis'],2,1,$formapago,$costoboleto,$fechatime));
			
			$timeRightNow = time();
			$url = str_replace(' ','',$qr);
			$img = 'qr/'.$timeRightNow.'.png';
			file_put_contents($img, file_get_contents($url));
			
			if($row['strEnvioC'] != 'Domicilio'){
			$content = '
			<page>
				<br>
				<br>
				<p align="center">Estimado cliente adjuntamos su boleto para:</p>
				<br>
				<font size = "5"><p align="center"><strong>'.$row['strEvento'].'</strong></p></font>
				<br>
				<p align="center">El mismo que se efctuara en:</p>
				<br>
				<font size = "5"><p align="center"><strong>'.$row['strLugar'].'</strong></p></font>	
				<br>
				<p align="center">El dia: '.$row['dateFecha'].' a las: '.$row['timeHora'].'</p>
				<br>
				<p align="center">En la localidad: <strong>'.$row2['strDescripcionL'].'</strong> costo: <strong>'.$costoboleto.'</strong></p>
				<br>
				<p align="center"><strong>Tu asiento es : Fila-'.$row2['filaPV'].'_Asiento-'.$row2['columnaPV'].'</strong></p>
				<br>
				<p align="center"><img alt="" src="'.$img.'" /></p>
				<br>
				<br>
				<p align="center">Disfrute el evento</p>
				<br>
				<p align="center"><strong>Imprimir el boleto para el ingreso al evento</strong></p>
				<br>
				<p align="center">Nota: El ingreso al evento se permitide solo con la cedula y el boleto impreso</p>
				<br>
				<br>
				<p align="center"><img alt="" src="http://www.lcodigo.com/ticket/distribuidor/cobros/ajax/codigo_barras.php?barcode='.$_SESSION['barcode'].'" /></p>
				<p align="center">'.$_SESSION['barcode'].'</p>
				<br>
			</page>';
			$codigo = $_SESSION['barcode'];
			$urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$codigo.'';
			$imgbar = 'barcode/'.$codigo.'.png';
			file_put_contents($imgbar, file_get_contents($urlbar));
			$print .= '
			<div>
				<table>
					<tr>
						<td>
							Estimad@: '.$row['strNombresC'].'
						</td>
					</tr>
					<tr>
						<td>
							Su ticket para: '.$row['strEvento'].'
						</td>
					</tr>
					<tr>
						<td>
							El dia: '.$row['dateFecha'].' a las: '.$row['timeHora'].'
						</td>
					</tr>
					<tr>
						<td>
							<img src="http://www.lcodigo.com/ticket/distribuidor/cobros/ajax/qr/'.$timeRightNow.'.png" />
						</td>
					</tr>
					<tr>
						<td>
							Localidad: <strong>'.$row2['strDescripcionL'].'</strong>
						</td>
					</tr>
					<tr>
						<td>
							Tu asiento es : <strong> Fila-'.$row2['filaPV'].'_Asiento-'.$row2['columnaPV'].'</strong>
						</td>
					</tr>
					<tr>
						<td>
							Costo del Ticket: $'.$costoboleto.' 
						</td>
					</tr>
					<tr>
						<td>
							<img src="http://www.lcodigo.com/ticket/distribuidor/cobros/ajax/barcode/'.$codigo.'.png" /><br>
							'.$codigo.'<br>
						</td>
					</tr>
					<tr>
						<td style="border-top:3px solid #000;"></td>
					</tr>
				</table>
			</div>'; 
			$content2 = '
				<page>
					<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;">
						<tr>
							<td style="text-align:center;">
								<a href="http://www.lcodigo.com/ticket"><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" /></a>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								<span style="font-size:30px;"><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU TICKET ($'.$costoboleto.') CON EXITO</strong></span>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								El pago de tu boleto se cancelo con: <strong>'.$formapago.'</strong>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								Estimado(a) <strong>'.$row['strNombresC'].'</strong>
							</td>
						</tr>
						<tr>
							<td>
								<br>
								<br>
								<strong>Aviso!</strong> Este es un comprobante de pago, debe canjear su TICKET en: <strong>'.$row['dircanjeC'].'</strong> Desde: <strong>'.$row['fechainiciocanjeC'].'</strong> Hasta: <strong>'.$row['fechafinalcanjeC'].'</strong>.
							</td>
						</tr>
						<tr>
							<td>
								<br>
								Para realizar el CANJE, debe acercarce con el <strong>PDF</strong> adjunto a este mail impreso y el <strong>Documento de Identidad</strong> de la persona que realizo la compra.
							</td>
						</tr>
						<tr>
							<td>
								<br>
								Los Horarios de Atencion son de: <strong>Lunes a Domingo '.$row['horariocanjeC'].'</strong>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								<br>
								Gracias por Preferirnos...!
								<br>
								<br>
								<strong>TICKETFACIL <I>La mejor experiencia de compra En Línea</I></strong>
							</td>
						</tr>
					</table>
				</page>';
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/'.$timeRightNow.'.pdf','F');
			}catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
			$ownerEmail = 'jonathan@practisis.com';
			$subject = 'Boleto para '.$row2['strDescripcionL'].' - Fila-'.$row2['filaPV'].'_Asiento-'.$row2['columnaPV'].'';
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 465;
			$mail->Username = "jonathan@practisis.com";
			$mail->Password = "nathan42015";
			$mail->AddReplyTo($ownerEmail,'TICKETFACIL');
			$mail->SetFrom($ownerEmail,'TICKETFACIL');
			$mail->From = $ownerEmail;
			$mail->AddAddress($row['strMailC'],$row['strNombresC']);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content2);
			$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
		
			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else{
				//echo 'ok';
			}
			unlink('pdf/'.$timeRightNow.'.pdf');
			// unlink('qr/'.$timeRightNow.'.png');
			$counter++;
			}
		}
		if($row['strEnvioC'] == 'Domicilio'){
		$totales = '';
		$costoenvio = $row['costoenvioC'];
		$costoenvio = number_format($costoenvio,2);
		$content3 = '
			<page>
				<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;">
					<tr>
						<td style="text-align:center;">
							<a href="http://www.lcodigo.com/ticket"><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" /></a>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<br>
							Estimado(a) <strong>'.$row['strNombresC'].'</strong>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<br>
							<span style="font-size:30px;"><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU(S) TICKET(S) ($'.$totalpago.') CON EXITO</strong></span>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<br>
							El pago de su(s) ticket(s) se cancelo con: <strong>'.$formapago.'</strong>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<br>
							La configuracion de su cuenta para ENVIO DE TICKET(S) esta para: <strong>ENVIO A DOMICILIO</strong>
						</td>
					</tr>
					
					<tr>
						<td>
							<br>
							<br>
							Su(s) TICKET(S) lo(s) recibira por: <img src="http://www.lcodigo.com/ticket/imagenes/servientrega.png" style="max-width:250px;"/> A la siguiente dirección: <strong>'.$row['strDireccionC'].'</strong>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<br>
							El costo del envio es: <strong>$'.$costoenvio.'</strong>, y su(s) TICKET(S) le enviaremos Desde: <strong>'.$row['fechainiciocanjeC'].'</strong> Hasta: <strong>'.$row['fechafinalcanjeC'].'</strong>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<br>
							<strong>DETALLE DE COMPRA</strong>
						</td>
					</tr>
					<tr>
						<td>
							<br>
							<br>
							<table width="100%" border="1" align="center">
								<tr style="text-align:center;">
									<td><strong>Descripcion de Asientos</strong></td>
									<td><strong>Localidad</strong></td>
									<td><strong>Cantidad de Boletos</strong></td>
									<td><strong>Precio Unitario</strong></td>
									<td><strong>Precio Total</strong></td>
								</tr>';
								$sql4 = "SELECT strDescripcionL, doublePrecioL, doublePrecioPreventa, filaPV, columnaPV, numboletosPV, localidadPV, conciertoPV, clientePV FROM pventa p JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE codigoPV = ?";
								$stmt4 = $gbd -> prepare($sql4);
								$stmt4 -> execute(array($codigocompra));
								while($row4 = $stmt4 -> fetch(PDO::FETCH_ASSOC)){
								$sql5 = "SELECT descompra FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
								$stmt5 = $gbd -> prepare($sql5);
								$stmt5 -> execute(array($row4['filaPV'],$row4['columnaPV'],$row4['localidadPV'],$row4['conciertoPV']));
								$row5 = $stmt5 -> fetch(PDO::FETCH_ASSOC);
								$tipocompra = $row5['descompra'];
								if($tipocompra == 1){
									$costoboleto = $row4['doublePrecioPreventa'];
								}else if($tipocompra == 2){
									$costoboleto = $row4['doublePrecioL'];
								}else if($tipocompra == 3){
									$costoboleto = $row4['doublePrecioL'];
								}
								$content3 .= '
								<tr>
									<td>Fila-'.$row4['filaPV'].'_Asiento-'.$row4['columnaPV'].'</td>
									<td>'.$row4['strDescripcionL'].'</td>
									<td>1</td>
									<td>'.$costoboleto.'</td>
									<td style="text-align:right;">'.$costoboleto.'</td>
								</tr>
								';
								$totales += $costoboleto;
								}
								$totales = number_format($totales,2);
								$totalcompra = $totales + $row['costoenvioC'];
								$totalcompra = number_format($totalcompra,2);
					$content3 .= '
								<tr>
									<td colspan="4" style="text-align:right;"><strong>SUBTOTAL</strong></td>
									<td style="text-align:right;"><strong>'.$totales.'</strong></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:right;"><strong>ABONO RESERVA</strong></td>
									<td style="text-align:right;"><strong>'.$row['estadopagoPV'].'</strong></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:right;"><strong>COSTO DE ENVIO</strong></td>
									<td style="text-align:right;"><strong>'.$costoenvio.'</strong></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:right;"><strong>TOTAL</strong></td>
									<td style="text-align:right;"><strong>'.$totalcompra.'</strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<br>
							<br>
							Gracias por Preferirnos...!
							<br>
							<br>
							<strong>TICKETFACIL <I>La mejor experiencia de compra En Línea</I></strong>
						</td>
					</tr>
				</table>
			</page>';
		$ownerEmail = 'jonathan@practisis.com';
		$subject = 'Compra Exitosa - TICKETFACIL';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->Username = "jonathan@practisis.com";
		$mail->Password = "nathan42015";
		$mail->AddReplyTo($ownerEmail,'TICKETFACIL');
		$mail->SetFrom($ownerEmail,'TICKETFACIL');
		$mail->From = $ownerEmail;
		$mail->AddAddress($email,$nombre);
		$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
		$mail->FromName = 'TICKETFACIL';
		$mail->Subject = $subject;
		$mail->MsgHTML($content3);
		//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
	
		if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else{
		}
		unlink('qr/'.$timeRightNow.'.png');
		}
		if($row['strEnvioC'] == 'Domicilio'){
			echo 'ok';
		}else{
			echo $print;
		}
		// header('Location: ../../../?modulo=cobrook');
	}
	
	if($identificador == 2){
		
		$update = "UPDATE pventa SET estadoPV = ?, estadopagoPV = ? WHERE codigoPV = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array('Revisado',$totalpago,$codigocompra));
		
		$sql = "SELECT strNombresC, strMailC, strDocumentoC, strEnvioC, strDireccionC, strEvento, strLugar, timeHora, dateFecha, dateFechaReserva, dateFechaPReserva FROM pventa p JOIN Cliente c ON p.clientePV = c.idCliente JOIN Concierto co ON p.conciertoPV = co.idConcierto WHERE codigoPV = ? GROUP BY codigoPV";
		$stmt = $gbd -> prepare($sql);
		$stmt -> execute(array($codigocompra));
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);
		$envio = $row['strEnvioC'];
		if($envio == 'Domicilio'){
			$envio = 'Servientrega';
			$dir = $row['strDireccionC'];
		}else if($envio == 'correo'){
			$envio = 'Correo Electronico';
			$dir = $row['strMailC'];
		}else if($envio == 'p_venta'){
			$envio = 'Punto de Venta';
			$dir = 'Cualquiera de los Puntos de Venta';
		}
		
		$sql2 = "SELECT strDescripcionL, doublePrecioL, doublePrecioReserva, filaPV, columnaPV, numboletosPV, localidadPV , conciertoPV, clientePV FROM pventa p JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE codigoPV = ?";
		$stmt2 = $gbd -> prepare($sql2);
		$stmt2 -> execute(array($codigocompra));
		$numboletos = $stmt2 -> rowCount();
		$totalreserva = '';
		$totalnormal = '';
		
		
		$sql3 = "SELECT strDescripcionL, doublePrecioL, doublePrecioReserva, filaPV, columnaPV, numboletosPV, localidadPV , conciertoPV, clientePV FROM pventa p JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE codigoPV = ?";
		$stmt3 = $gbd -> prepare($sql3);
		$stmt3 -> execute(array($codigocompra));
		
		$totalreal = '';
		while($row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC)){
			$totalreal += $row3['doublePrecioL'];
		}
		$diferencia = $totalreal - $totalpago;
		$diferencia = number_format($diferencia,2);
		
		$content = '
		<page>
			<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;">
				<tr>
					<td style="text-align:center;">
						<a href="http://www.lcodigo.com/ticket"><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" /></a>
					</td>
				</tr>
				<tr>
					<td style="text-align:center;">
						<br>
						<br>
						<span style="font-size:30px;"><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU ABONO RESERVA ($'.$totalpago.') CON EXITO</strong></span>
					</td>
				</tr>
				<tr>
					<td style="text-align:center;">
						<br>
						<br>
						Estimado(a) <strong>'.$row['strNombresC'].'</strong> el sistema a generado la siguiente información:
					</td>
				</tr>
				<tr>
					<td style="text-align:center;">
						<br>
						<br>
						La reserva de su(s) ticket(s) se cancelo con: <strong>'.$formapago.'</strong>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						Sus asientos estan reservados, Tiene hasta: <strong>'.$row['dateFechaPReserva'].'</strong>, para pagar el <span style="background-color:#EC1867;">SALDO de: <strong>$'.$diferencia.'</strong></span>,para completar el valor TOTAL de su(s) TICKET(S) caso contrario pierde su RESERVA y el valor de su ABONO RESERVA, tal como se detallo en los <strong>TERMINOS Y CONDICIONES DE USO DE TICKETFACIL</strong>
					</td>
				</tr>
				<tr>
					<td style="text-align:center;">
						<br>
						Para el concierto de: <strong>'.$row['strEvento'].'</strong>
					</td>
				</tr>
				<tr>
					<td style="text-align:center;">
						<br>
						Una vez pagada la totalidad de sus BOLETOS los recibirá por: <strong>'.$envio.'</strong>, a la siguiente dirección: <strong>'.$dir.'</strong>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<br>
						* Su código de compra es: <strong>'.$codigocompra.'</strong>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<br>
						<strong>Descripción de Compra</strong>
					</td>
				</tr>
				<tr>
					<td style="text-align:center;">
						<table width="100%" border="2px">
							<tr>
								<td style="text-align:center"><strong>Localidad</strong></td>
								<td style="text-align:center"><strong>Asientos #</strong></td>
								<td style="text-align:center"><strong>Cantidad de Boletos</strong></td>
								<td style="text-align:center"><strong>Precio Reserva</strong></td>
								<td style="text-align:center"><strong>Precio Normal</strong></td>
							</tr>';
							while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
							$content.= '
							<tr>
								<td style="text-align:center">'.$row2['strDescripcionL'].'</td>
								<td style="text-align:center">Fila-'.$row2['filaPV'].'_Asiento-'.$row2['columnaPV'].'</td>
								<td style="text-align:center">1</td>
								<td style="text-align:center">'.$row2['doublePrecioReserva'].'</td>
								<td style="text-align:center">'.$row2['doublePrecioL'].'</td>
							</tr>
							';
							$totalreserva = $totalreserva + $row2['doublePrecioReserva'];
							$totalnormal = $totalnormal + $row2['doublePrecioL'];
							}
							$debe = $totalnormal - $totalreserva;
							$totalnormal = number_format($totalnormal,2);
							$totalreserva = number_format($totalreserva,2);
							$debe = number_format($debe,2);
						$content.= '
							<tr>
								<td colspan="4" style="text-align:right;">
									<strong>Subtotal</strong>
								</td>
								<td style="text-align:center; border-top:1px solid #000;">
									'.$totalnormal.'
								</td>
							</tr>
							<tr>
								<td colspan="4" style="text-align:right;">
									<strong>Abono Reserva</strong>
								</td>
								<td style="text-align:center;">
									'.$totalpago.'
								</td>
							</tr>
							<tr>
								<td colspan="4" style="text-align:right;">
									<span style="background-color:#EC1867;"><strong>Saldo</strong></span>
								</td>
								<td style="text-align:center; background-color:#EC1867;">
									'.$debe.'
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						* Te informamos que tu saldo pendiente es: <strong>$'.$debe.'</strong>, cancelalo hasta: <strong>'.$row['dateFechaReserva'].'</strong>.
					</td>
				</tr>
				<tr>
					<td style="text-align:center;">
						<br>
						<br>
						<br>
						Gracias por Preferirnos...!
						<br>
						<br>
						<strong>TICKETFACIL <I>La mejor experiencia de compra En Línea</I></strong>
					</td>
				</tr>
			</table>
		</page>
		';
		$ownerEmail = 'jonathan@practisis.com';
		$subject = 'Pago de Reservacion Exitoso';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->Username = "jonathan@practisis.com";
		$mail->Password = "nathan42015";
		$mail->AddReplyTo($ownerEmail,'TICKETFACIL');
		$mail->SetFrom($ownerEmail,'TICKETFACIL');
		$mail->From = $ownerEmail;
		$mail->AddAddress($row['strMailC'],$row['strNombresC']);
		$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
		$mail->FromName = 'TICKETFACIL';
		$mail->Subject = $subject;
		$mail->MsgHTML($content);
		// $mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
	
		if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else{
			//echo 'ok';
		}
		// header('Location: ../../../?modulo=cobroreservaok');
		echo 'okreserva';
	}
	
?>