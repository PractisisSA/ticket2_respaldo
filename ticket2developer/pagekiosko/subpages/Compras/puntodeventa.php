<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<?php
	session_start();
	include("../../controlusuarios/seguridadusuario.php");
	require_once('../../classes/private.db.php');
	require_once '../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../PHPM/PHPM/class.smtp.php';
	// $rand = md5(time());
	// $code = sha1(time());
	ini_set('display_startup_errors',1);
ini_set('display_errors',1);
date_default_timezone_set("America/Guayaquil");
error_reporting(-1);
	$gbd = new DBConn();
	
	$idConcierto = $_GET['evento'];
	$nom = $_SESSION['username'];
	$email = $_SESSION['usermail'];
	$id_cli = $_SESSION['id'];
	
	$numero = 0;
	$fecha = 0;
	$status = 2;
	$estado = "Revisar";
	$est_deposito = "No";
	$pagopor = 3;
	$fechahoy = date('Y-m-d');
	
	$selectpreventa = "SELECT doublePrecioPreventa FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto WHERE Concierto.dateFechaPreventa >= ? AND Concierto.idConcierto = ?";
	$resSelectpreventa = $gbd -> prepare($selectpreventa);
	$resSelectpreventa -> execute(array($fechahoy,$idConcierto));
	$numpreventa = $resSelectpreventa -> rowCount();
	if($numpreventa > 0){
		$descompra = 1;
	}else{
		$descompra = 2;
	}
	// $cant_bol = 0;
	$total_pago = $_POST['total_pagar'];
	$cant_boletos = $_POST['num_boletos'];
	if(isset($_POST['codigo'])){
		$select1 = "SELECT * FROM Cliente WHERE idCliente = ?";
		$slt1 = $gbd -> prepare($select1);
		$slt1 -> execute(array($id_cli));
		$row = $slt1 -> fetch(PDO::FETCH_ASSOC);
		$envio = $row['strEnvioC'];
		$dir = $row['strDireccionC'];
		if($envio == 'Domicilio'){
			$envio = 'A tu Domicilio';
			$dir = $row['strDireccionC'];
		}else if($envio == 'correo'){
			$envio = 'Correo Electronico';
			$dir = $email;
		}else if($envio == 'p_venta'){
			$envio = 'Punto de Venta';
			$dir = 'Cualquiera de nuestros Puntos de Venta';
		}
		
		
		$query1 = "SELECT * FROM Concierto where idConcierto = ?";
		$result = $gbd -> prepare($query1);
		$result -> execute(array($idConcierto));
		$row1 = $result -> fetch(PDO::FETCH_ASSOC);
		$e = $row1['strEvento'];
		$tiene_permisos = $row1['tiene_permisos'];
		
		
		
		$codigoCompra='';
		foreach($_POST['codigo'] as $key=>$cod_loc){
			include '../../../conexion.php';

			$sqlA = 'select secuencialfinalA from autorizaciones where idAutorizacion = "'.$tiene_permisos.'" ';
			$resA = mysql_query($sqlA) or die (mysql_error());
			if(mysql_num_rows($resA)>0){
				$rowA = mysql_fetch_array($resA);
				$sqlB = 'select serie from Boleto where idCon = "'.$idConcierto.'"  order by idBoleto DESC limit 1';
				$resB = mysql_query($sqlB) or die (mysql_error());
				$rowB = mysql_fetch_array($resB);
				if($rowB['serie'] == null || $rowB['serie'] == '' ){
					$numeroSerie = 1;
				}else{
					$numeroSerie = ($rowB['serie'] + 1);
				}
				if($numeroSerie <= $rowA['secuencialfinalA']){
					echo "numero de serie : ".$numeroSerie." secuencia Final : ".$rowA['secuencialfinalA'];
					//aqui control de tipo de concierto con autorizaciones
					
					$random = mt_rand();
					$codigo = $random;
					$urlbar = 'http://ticketfacil.ec/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$codigo.'';
					$imgbar = 'barcode/'.$codigo.'.png';
					file_put_contents($imgbar, file_get_contents($urlbar));
					
					
					$boletosok = "SELECT * FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
					$bolok = $gbd -> prepare($boletosok);
					$bolok -> execute(array($_POST['row'][$key],$_POST['col'][$key],$cod_loc,$idConcierto));
					$numbolok = $bolok -> rowCount();
					if($numbolok > 0){
						echo 'error';
						header('Location: ../../?modulo=preventaok&error='.$idConcierto.'');
						return false;
					}
					
					
					$hoy = date("Y-m-d");
					$dateFechaPreventa = $row1['dateFechaPreventa'];
					
					if($hoy <= $dateFechaPreventa){
						$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$cod_loc.'"';
						$lokRow= $gbd -> prepare($localidad);
						$lokRow -> execute();
						$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
						$precioVenta = $rowLoc['doublePrecioPreventa'];
						
						$insertCompras_preventa = "INSERT INTO compras_preventa VALUES (?, ?, ?, ?, ? , ? )";
						$resCompras_preventa = $gbd -> prepare($insertCompras_preventa);
						$resCompras_preventa -> execute(array('NULL',$cod_loc , $random , "" , $hoy , $precioVenta));
						
						
					}else{
						$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$cod_loc.'"';
						$lokRow= $gbd -> prepare($localidad);
						$lokRow -> execute();
						$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
						$precioVenta = $rowLoc['doublePrecioL'];
					}
					
					
					$query = "INSERT INTO pventa VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					$res = $gbd -> prepare($query);
					$res -> execute(array('NULL',$numero,$fecha,$_POST['row'][$key],$_POST['col'][$key],$id_cli,$idConcierto,$cod_loc,$random,$_POST['num'][$key],$estado,$est_deposito,'SN','NULL','NULL'));
					
					$insertAsientos = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
					$resulinsertAsientos = $gbd -> prepare($insertAsientos);
					$resulinsertAsientos -> execute(array('NULL',$_POST['row'][$key],$_POST['col'][$key],$status,$_POST['codigo'][$key],$idConcierto,$pagopor,$descompra));
					
					$sql2 = 'SELECT strDescripcionL, doublePrecioL, doublePrecioReserva, doublePrecioPreventa, filaPV, columnaPV, numboletosPV, localidadPV , conciertoPV FROM pventa p JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE codigoPV = "'.$random.'" ';
					$stmt2 = $gbd -> prepare($sql2);
					$stmt2 -> execute();
					$row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
					$costoboleto = $row2['doublePrecioPreventa'];
					
					
					$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$cod_loc.'"';
					$lokRow= $gbd -> prepare($localidad);
					$lokRow -> execute();
					$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
					$doublePrecioL = $rowLoc['doublePrecioL'];
					
					$codigoCompra = $codigoCompra.$codigo."|";
					$content = '
					<page>
						<div style="border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;">
							<table align="center" style="width:400px; border-collapse:separate; border-spacing:15px 5px;font-size:11px;" class="table table-hover">
								<tr>
									<td style="text-align:center;">
										<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="200px"/>
									</td>
								</tr>
								<tr>
									<td style="text-align:center;">
										Estimado <h3 style="text-transform:capitalize;">'.$nom.'</h3> <br/>Esto es un comprobante de reserva en l&iacute;nea :
									</td>
								</tr>
								<tr>
									<td>
										* Sus asientos estan reservados, <span style="color:#EC1867;">por un valor de <strong>$'.$precioVenta.'</strong></span>,
										si el pago se realiza dentro de las siguientes: <strong>'.$row1['tiempopagoC'].'</strong>,
										caso contrario sus asientos seran ELIMINADOS
									</td>
								</tr>
								<tr>
									<td>
										Usted podr&aacute; pagar el valor de sus tickets en '.$row1['locPago'].' que esta ubicado en : '.$row1['dirPago'].'<br/>
										'.$row1['fecha'].' <br/>
										en el horario de : '.$row1['hora'].'
									</td>
								</tr>
								
								<tr>
									<td>
										Una vez pagada la totalidad de sus TICKETS usted podr&aacute; canjearlos en :'.$row1['dircanjeC'].' 
										desde el dia : '.$row1['fechainiciocanjeC'].' hasta el dia '.$row1['fechafinalcanjeC'].'
										el el horario de : '.$row1['horariocanjeC'].'<br/>
										* Para el concierto de :<center><h3><strong>'.$e.'</strong><h3></center>
										<br/><br/>
										Por favor debe portar este documento impreso , el recibo del pago y su documento de identidad al momento del canje<br/>
									</td>
								</tr>
								<tr>
									<td valign="middle" align="center">
										* Su c&oacute;digo de compra es el siguiente:<br/>
										<img src="http://ticketfacil.ec/ticket2/pagekiosko/subpages/Compras/barcode/'.$codigo.'.png" /><br/>
										 <span style="color:#EC1867;"><strong>'.$codigo.'</strong></span>
									</tr>
								</tr>
								<tr>
									<td style="text-align:center;">
										<strong>Gracias por Preferirnos</strong>
										<br>
										<strong>TICKETFACIL <I>"La mejor experiencia de compra En L&iacute;nea"</I></strong>
									</td>
								</tr>
							</table>
						</div>
					</page>';
					
					$content3='
						<page>
						<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:11px;">
							<tr>
								<td style="text-align:center;">
									<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="200px"/>
								</td>
							</tr>
							<tr>
								<td style="text-align:center;">
									Estimado <strong>'.$nom.'</strong> <br/>Esto es un comprobante de reserva en l&iacute;nea :
								</td>
							</tr>
							<tr>
								<td>
									* Sus asientos estan reservados, <span style="color:#EC1867;">por un valor de <strong>$'.$precioVenta.'</strong></span>,
									si el pago se realiza dentro de las siguientes: <strong>'.$row1['tiempopagoC'].'</strong>,
									caso contrario sus asientos seran ELIMINADOS
								</td>
							</tr>
							<tr>
								<td>
									Una vez pagada la totalidad de sus TICKETS usted podr&aacute; canjearlos en :'.$row1['dircanjeC'].' 
									desde el d&iacute;a : '.$row1['fechainiciocanjeC'].' hasta el d&iacute;a '.$row1['fechafinalcanjeC'].'
									el el horario de : '.$row1['horariocanjeC'].'
									* Para el concierto: <strong>'.$e.'</strong>
								</td>
							</tr>
					';
					
					$content4='
						<tr>
							<!--<td style="text-align:center;">
								<br>
								* Puede acercarse a cualquier: <br/><img src="http://www.lcodigo.com/ticket/imagenes/logo_Fybeca.gif"/> </br/>para cancelar el valor adeudado.
							</td>-->
						</tr>
						<tr>
							<td style="text-align:center;">
								<strong>Gracias por Preferirnos</strong>
								<br>
								<strong>TICKETFACIL <I>"La mejor experiencia de compra En L&iacute;nea"</I></strong>
							</td>
						</tr>
					</table>
					</page>
					';
					
					
					$content2='
						<a href="http://www.lcodigo.com/ticket"><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" /></a>
						<br>
						<br>
						Estimado <strong>'.$nom.'</strong><br/>
						Confirmamos la reserva de boletos * Para el concierto: <strong>'.$e.'</strong>
						<br/><br/>
						Gracias por usar nuestros servicios<br/><br/>
						<strong>TICKETFACIL <I>"La mejor experiencia de compra En L&iacute;nea"</I></strong><br/>
					';
				
					$ownerEmail = 'jonathan@practisis.com';
					$subject = 'Informacion de Pago';
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
					$mail->AddAddress($email,$nom);
					$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
					$mail->FromName = 'TICKETFACIL';
					$mail->Subject = $subject;
					$mail->MsgHTML($content);
					//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
					if(!$mail->Send()){
						echo "Mailer Error: " . $mail->ErrorInfo;
					}
					else{
						//echo 'ok';
						//echo $content."|";
						$_SESSION['smsPago'] = $content;
						$_SESSION['content3'] = $content3;
						$_SESSION['content4'] = $content4;
						header('Location: ../../?modulo=preventaok&error=ok');
					}
				}else{
					$error = 'agotados';
					echo 'error';
					header('Location: ../../?modulo=preventaok&error='.$error.'');
					return false;
				}
			}else{
				$random = mt_rand();
				
				
				$codigo = $random;
				$urlbar = 'http://ticketfacil.ec/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$codigo.'';
				$imgbar = 'barcode/'.$codigo.'.png';
				file_put_contents($imgbar, file_get_contents($urlbar));
				
				
				$boletosok = "SELECT * FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
				$bolok = $gbd -> prepare($boletosok);
				$bolok -> execute(array($_POST['row'][$key],$_POST['col'][$key],$cod_loc,$idConcierto));
				$numbolok = $bolok -> rowCount();
				if($numbolok > 0){
					echo 'error';
					header('Location: ../../?modulo=preventaok&error='.$idConcierto.'');
					return false;
				}
				
				
				$hoy = date("Y-m-d");
				$dateFechaPreventa = $row1['dateFechaPreventa'];
				
				if($hoy <= $dateFechaPreventa){
					$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$cod_loc.'"';
					$lokRow= $gbd -> prepare($localidad);
					$lokRow -> execute();
					$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
					$precioVenta = $rowLoc['doublePrecioPreventa'];
					
					$insertCompras_preventa = "INSERT INTO compras_preventa VALUES (?, ?, ?, ?, ? , ? )";
					$resCompras_preventa = $gbd -> prepare($insertCompras_preventa);
					$resCompras_preventa -> execute(array('NULL',$cod_loc , $random , "" , $hoy , $precioVenta));
					
					
				}else{
					$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$cod_loc.'"';
					$lokRow= $gbd -> prepare($localidad);
					$lokRow -> execute();
					$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
					$precioVenta = $rowLoc['doublePrecioL'];
				}
				
				
				$query = "INSERT INTO pventa VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$res = $gbd -> prepare($query);
				$res -> execute(array('NULL',$numero,$fecha,$_POST['row'][$key],$_POST['col'][$key],$id_cli,$idConcierto,$cod_loc,$random,$_POST['num'][$key],$estado,$est_deposito,'SN','NULL','NULL'));
				
				$insertAsientos = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				$resulinsertAsientos = $gbd -> prepare($insertAsientos);
				$resulinsertAsientos -> execute(array('NULL',$_POST['row'][$key],$_POST['col'][$key],$status,$_POST['codigo'][$key],$idConcierto,$pagopor,$descompra));
				
				$sql2 = 'SELECT strDescripcionL, doublePrecioL, doublePrecioReserva, doublePrecioPreventa, filaPV, columnaPV, numboletosPV, localidadPV , conciertoPV FROM pventa p JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE codigoPV = "'.$random.'" ';
				$stmt2 = $gbd -> prepare($sql2);
				$stmt2 -> execute();
				$row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
				$costoboleto = $row2['doublePrecioPreventa'];
				
				
				$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$cod_loc.'"';
				$lokRow= $gbd -> prepare($localidad);
				$lokRow -> execute();
				$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
				$doublePrecioL = $rowLoc['doublePrecioL'];
				
				$codigoCompra = $codigoCompra.$codigo."|";
				//aqui control de tipo de concierto sin autorizaciones
				$content = '
				<page>
					<div style="border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;">
						<table align="center" style="width:400px; border-collapse:separate; border-spacing:15px 5px;font-size:11px;" class="table table-hover">
							<tr>
								<td style="text-align:center;">
									<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="200px"/>
								</td>
							</tr>
							<tr>
								<td style="text-align:center;">
									Estimado <h3 style="text-transform:capitalize;">'.$nom.'</h3> <br/>Esto es un comprobante de reserva en l&iacute;nea :
								</td>
							</tr>
							<tr>
								<td>
									* Sus asientos estan reservados, <span style="color:#EC1867;">por un valor de <strong>$'.$precioVenta.'</strong></span>,
									si el pago se realiza dentro de las siguientes: <strong>'.$row1['tiempopagoC'].'</strong>,
									caso contrario sus asientos seran ELIMINADOS
								</td>
							</tr>
							<tr>
								<td>
									Usted podr&aacute; pagar el valor de sus tickets en '.$row1['locPago'].' que esta ubicado en : '.$row1['dirPago'].'<br/>
									'.$row1['fecha'].' <br/>
									en el horario de : '.$row1['hora'].'
								</td>
							</tr>
							
							<tr>
								<td>
									Una vez pagada la totalidad de sus TICKETS usted podr&aacute; canjearlos en :'.$row1['dircanjeC'].' 
									desde el d&iacute;a : '.$row1['fechainiciocanjeC'].' hasta el d&iacute;a '.$row1['fechafinalcanjeC'].'
									el el horario de : '.$row1['horariocanjeC'].'<br/>
									* Para el concierto de :<center><h3><strong>'.$e.'</strong><h3></center>
									<br/><br/>
									Por favor debe portar este documento impreso , el recibo del pago y su documento de identidad al momento del canje<br/>
								</td>
							</tr>
							<tr>
								<td valign="middle" align="center">
									* Su c&oacute;digo de compra es el siguiente:<br/>
									<img src="http://ticketfacil.ec/ticket2/pagekiosko/subpages/Compras/barcode/'.$codigo.'.png" /><br/>
									 <span style="color:#EC1867;"><strong>'.$codigo.'</strong></span>
								</tr>
							</tr>
							<tr>
								<td style="text-align:center;">
									<strong>Gracias por Preferirnos</strong>
									<br>
									<strong>TICKETFACIL <I>"La mejor experiencia de compra En L&iacute;nea"</I></strong>
								</td>
							</tr>
						</table>
					</div>
				</page>';
				
				$content3='
					<page>
					<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:11px;">
						<tr>
							<td style="text-align:center;">
								<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="200px"/>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								Estimado <strong>'.$nom.'</strong> <br/>Esto es un comprobante de reserva en l&iacute;nea :
							</td>
						</tr>
						<tr>
							<td>
								* Sus asientos estan reservados, <span style="color:#EC1867;">por un valor de <strong>$'.$precioVenta.'</strong></span>,
								si el pago se realiza dentro de las siguientes: <strong>'.$row1['tiempopagoC'].'</strong>,
								caso contrario sus asientos seran ELIMINADOS
							</td>
						</tr>
						<tr>
							<td>
								Una vez pagada la totalidad de sus TICKETS usted podr&aacute; canjearlos en :'.$row1['dircanjeC'].' 
								desde el d&iacute;a : '.$row1['fechainiciocanjeC'].' hasta el d&iacute;a '.$row1['fechafinalcanjeC'].'
								el el horario de : '.$row1['horariocanjeC'].'
								* Para el concierto: <strong>'.$e.'</strong>
							</td>
						</tr>
				';
				
				$content4='
					<tr>
						<!--<td style="text-align:center;">
							<br>
							* Puede acercarse a cualquier: <br/><img src="http://www.lcodigo.com/ticket/imagenes/logo_Fybeca.gif"/> </br/>para cancelar el valor adeudado.
						</td>-->
					</tr>
					<tr>
						<td style="text-align:center;">
							<strong>Gracias por Preferirnos</strong>
							<br>
							<strong>TICKETFACIL <I>"La mejor experiencia de compra En L&iacute;nea"</I></strong>
						</td>
					</tr>
				</table>
			</page>
				';
				
				
				$content2='
					<a href="http://www.lcodigo.com/ticket"><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" /></a>
					<br>
					<br>
					Estimado <strong>'.$nom.'</strong><br/>
					Confirmamos la reserva de boletos * Para el concierto: <strong>'.$e.'</strong>
					<br/><br/>
					Gracias por usar nuestros servicios<br/><br/>
					<strong>TICKETFACIL <I>"La mejor experiencia de compra En L&iacute;nea"</I></strong><br/>
				';
			
				$ownerEmail = 'jonathan@practisis.com';
				$subject = 'Informacion de Pago';
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
				$mail->AddAddress($email,$nom);
				$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
				$mail->FromName = 'TICKETFACIL';
				$mail->Subject = $subject;
				$mail->MsgHTML($content);
				//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
				if(!$mail->Send()){
					echo "Mailer Error: " . $mail->ErrorInfo;
				}
				else{
					//echo 'ok';
					//echo $content."|";
					$_SESSION['smsPago'] = $content;
					$_SESSION['content3'] = $content3;
					$_SESSION['content4'] = $content4;
					header('Location: ../../?modulo=preventaok&error=ok');
				}
			}
		}
		$_SESSION['codigoCompra'] = $codigoCompra;
	}
?>