<?php 
	session_start();
	date_default_timezone_set('America/Guayaquil');
	include('../../../controlusuarios/seguridadDis.php');
	require_once('../../../classes/private.db.php');
	include('../../../html2pdf/html2pdf/html2pdf.class.php');
	require_once '../../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../../PHPM/PHPM/class.smtp.php';
	// require_once 'ex.php';
	
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	
	$gbd = new DBConn();
	
	// print_r($_POST);
	$hoy = date("Y-m-d");
	$fechatime = date("Y-m-d H:i:s");
	$num_boletos = $_POST['num_boletos'];
	
	if($_POST['clienteok'] == 'ok'){
		$email = $_POST['mail'];
		$movil = $_POST['movil'];
		$dir = $_POST['dir'];
		$idcliente = $_POST['idcliente'];
		$formapago = $_POST['tipopago'];
		$envio = $_POST['forma'];
		
		$query1 = "SELECT strNombresC FROM Cliente WHERE idCliente = ?";
		$qry1 = $gbd -> prepare($query1);
		$qry1 -> execute(array($idcliente));
		$rowquery1 = $qry1 -> fetch(PDO::FETCH_ASSOC);
		$nombre = $rowquery1['strNombresC'];
		
		$idconcierto = $_POST['concierto'];
		
		$select = "SELECT strEvento, strLugar, dateFecha, timeHora, dircanjeC, horariocanjeC, fechainiciocanjeC, fechafinalcanjeC, costoenvioC FROM Concierto WHERE idConcierto = ?";
		$stmt = $gbd -> prepare($select);
		$stmt -> execute(array($idconcierto));
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);
		$evento = $row['strEvento'];
		$lugar = $row['strLugar'];
		$fecha = $row['dateFecha'];
		$hora = $row['timeHora'];
		$dircanje = $row['dircanjeC'];
		$horario = $row['horariocanjeC'];
		$iniciocanje = $row['fechainiciocanjeC'];
		$finalcanje = $row['fechafinalcanjeC'];
		$costoenvio = $row['costoenvioC'];
		$costoenvio = number_format($costoenvio,2);
		
		$select2 = "SELECT * FROM Concierto WHERE dateFechaPreventa >= ? AND idConcierto = ?";
		$stmt2 = $gbd -> prepare($select2);
		$stmt2 -> execute(array($hoy,$idconcierto));
		$numrows = $stmt2 -> rowCount();
		if($numrows > 0){
			$descompra = 1;
		}else{
			$descompra = 2;
		}
		
		$total = '';
		$print = '';
		$counter = 1;
		foreach(explode('@', $_POST['valores']) as $value){
			$exp = explode('|',$value);
			
			try{
				$selectocupadas = "SELECT * FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
				$stmtocupadas = $gbd -> prepare($selectocupadas);
				$stmtocupadas -> execute(array($exp[4],$exp[5],$exp[0],$idconcierto));
				$numocupadas = $stmtocupadas -> rowCount();
				if($numocupadas > 0){
					echo 'error';
				}
				
				$insert = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				$ins = $gbd -> prepare($insert);
				$ins -> execute(array('NULL',$exp[4],$exp[5],1,$exp[0],$idconcierto,1,$descompra));
				
				$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
				$rand = md5($s.time()).mt_rand(1,10);
				$code = rand(1,9999999999).time();
				
				$insert2 = "INSERT INTO Boleto VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$ins2 = $gbd -> prepare($insert2);
				$ins2 -> execute(array('NULL',$rand,$code,$idcliente,$idconcierto,$exp[0],$exp[4],$exp[5],$exp[6],$exp[7],'A','S'));
				$idboleto = $gbd -> lastInsertId();
				
				if($envio == 'Domicilio'){
				$insert3 = "INSERT INTO domicilio VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$ins3 = $gbd -> prepare($insert3);
				$ins3 -> execute(array('NULL',$exp[4],$exp[5],1,$exp[0],$idconcierto,$idcliente,$idboleto,$formapago,$dir,$exp[6],$exp[7],'A'));
				}
				
				$trans = "INSERT INTO transaccion_distribuidor VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$stmttrans = $gbd -> prepare($trans);
				$stmttrans -> execute(array('NULL',$idcliente,$idconcierto,$exp[0],$_SESSION['idDis'],1,1,$formapago,$exp[3],$fechatime));
				
				$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'';
				$timeRightNow = time();
				$url = str_replace(' ','',$qr);
				$img = 'qr/'.$timeRightNow.'.png';
				file_put_contents($img, file_get_contents($url));
				
				$_SESSION['barcode'] = $code;
			}catch(PDOException $e){
				print_r($e);
			}
			
			$total = $total + $exp[3];
			$total = number_format($total,2);
			
			if($envio != 'Domicilio'){
			$content = '
			<page>
				<br>
				<br>
				<p align="center">Estimado cliente adjuntamos su boleto para:</p>
				<br>
				<font size = "5"><p align="center"><strong>'.$evento.'</strong></p></font>
				<br>
				<p align="center">El mismo que se efctuara en:</p>
				<br>
				<font size = "5"><p align="center"><strong>'.$lugar.'</strong></p></font>	
				<br>
				<p align="center">El dia: '.$fecha.' a las: '.$hora.'</p>
				<br>
				<p align="center">En la localidad: <strong>'.$exp[1].'</strong> costo: <strong>'.$exp[3].'</strong></p>
				<br>
				<p align="center"><strong>Tu asiento es : '.$exp[2].'</strong></p>
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
				<p align="center"><img alt="" src="http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$_SESSION['barcode'].'" /></p>
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
							Estimad@: '.$exp[6].'
						</td>
					</tr>
					<tr>
						<td>
							Su ticket para: '.$evento.'
						</td>
					</tr>
					<tr>
						<td>
							El dia: '.$fecha.' a las: '.$hora.'
						</td>
					</tr>
					<tr>
						<td>
							<img src="http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/qr/'.$timeRightNow.'.png" />
						</td>
					</tr>
					<tr>
						<td>
							Localidad: <strong>'.$exp[1].'</strong>
						</td>
					</tr>
					<tr>
						<td>
							Tu asiento es : <strong>'.$exp[2].'</strong>
						</td>
					</tr>
					<tr>
						<td>
							Costo del Ticket: $'.$exp[3].' 
						</td>
					</tr>
					<tr>
						<td>
							<img src="http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/barcode/'.$codigo.'.png" /><br>
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
								<span style="font-size:30px;"><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU(S) TICKET(S) ($'.$exp[3].') CON EXITO</strong></span>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								Estimado(a) <strong>'.$exp[6].'</strong>:
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
							<td>
								<br>
								<br>
								<strong>Aviso!</strong> Este es un comprobante de pago, debe canjear su TICKET en: <strong>'.$dircanje.'</strong> Desde: <strong>'.$iniciocanje.'</strong> Hasta: <strong>'.$finalcanje.'</strong>.
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
								Los Horarios de Atencion son de: <strong>Lunes a Domingo '.$horario.'</strong>
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
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/'.$timeRightNow.'.pdf','F');
			}
			catch(HTML2PDF_exception $e) {
				echo 'my errors '.$e;
				exit;
			}
			if($envio != 3){
			$ownerEmail = 'jonathan@practisis.com';
			$subject = 'Boleto para '.$exp[1].' - '.$exp[2].'';
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
			$mail->AddAddress($email,$exp[6]);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content2);
			$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
		
			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else{
			}
			}
			unlink('pdf/'.$timeRightNow.'.pdf');
			// unlink('qr/'.$timeRightNow.'.png');
			$counter++;
			}
		}
		if($envio == 'Domicilio'){
			$total = $total + $costoenvio;
			$total = number_format($total,2);
			$totales = '';
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
							<span style="font-size:30px;"><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU(S) TICKET(S) ($'.$total.') CON EXITO</strong></span>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<br>
							Estimado(a) <strong>'.$nombre.'</strong>:
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
							Su(s) TICKET(S) lo(s) recibira por: <img src="http://www.lcodigo.com/ticket/imagenes/servientrega.png" style="max-width:250px;"/> A la siguiente dirección: <strong>'.$dir.'</strong>
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
								foreach(explode('@', $_POST['valores']) as $value1){
								$exp1 = explode('|',$value1);
								$content3 .= '
								<tr>
									<td>'.$exp1[2].'</td>
									<td>'.$exp1[1].'</td>
									<td>1</td>
									<td>'.$exp1[3].'</td>
									<td>'.$exp1[3].'</td>
								</tr>
								';
								$totales += $exp1[3];
								}
								$totales = number_format($totales,2);
							$content3 .= '
								<tr>
									<td colspan="4" style="text-align:right;"><strong>SUBTOTAL</strong></td>
									<td style="text-align:right;"><strong>'.$totales.'</strong></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:right;"><strong>COSTO DE ENVIO</strong></td>
									<td style="text-align:right;"><strong>'.$costoenvio.'</strong></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:right;"><strong>TOTAL</strong></td>
									<td style="text-align:right;"><strong>'.$total.'</strong></td>
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
		if($envio == 'Domicilio'){
			echo 'ok';
		}else{
			echo $print;
		}
		
	}else if($_POST['clienteok'] == 'no'){
		$nombre = $_POST['nombres'];
		$cedula = $_POST['documento'];
		$email = $_POST['mail'];
		$movil = $_POST['movil'];
		$dir = $_POST['dir'];
		$pass = md5($cedula);
		$formapago = $_POST['tipopago'];
		$envio = $_POST['forma'];
		
		$insert = "INSERT INTO Cliente VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array('NULL',$nombre,$email,$pass,$cedula,$dir,'2000-01-01','Agregar Genero','Agregar Ciudad','Agregar Provincia','Agregar Numero',$movil,0,$envio,'si',$fechatime));
		$idcliente = $gbd -> lastInsertId();
		
		$idconcierto = $_POST['concierto'];
		
		$select = "SELECT strEvento, strLugar, dateFecha, timeHora, dircanjeC, horariocanjeC, fechainiciocanjeC, fechafinalcanjeC, costoenvioC FROM Concierto WHERE idConcierto = ?";
		$stmt = $gbd -> prepare($select);
		$stmt -> execute(array($idconcierto));
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);
		$evento = $row['strEvento'];
		$lugar = $row['strLugar'];
		$fecha = $row['dateFecha'];
		$hora = $row['timeHora'];
		$dircanje = $row['dircanjeC'];
		$horario = $row['horariocanjeC'];
		$iniciocanje = $row['fechainiciocanjeC'];
		$finalcanje = $row['fechafinalcanjeC'];
		$costoenvio = $row['costoenvioC'];
		$costoenvio = number_format($costoenvio,2);
		
		$select2 = "SELECT * FROM Concierto WHERE dateFechaPreventa >= ? AND idConcierto = ?";
		$stmt2 = $gbd -> prepare($select2);
		$stmt2 -> execute(array($hoy,$idconcierto));
		$numrows = $stmt2 -> rowCount();
		if($numrows > 0){
			$descompra = 1;
		}else{
			$descompra = 2;
		}
		$total = '';
		$print = '';
		$counter = 1;
		foreach(explode('@', $_POST['valores']) as $value){
			$exp = explode('|',$value);
			
			try{
				$selectocupadas = "SELECT * FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
				$stmtocupadas = $gbd -> prepare($selectocupadas);
				$stmtocupadas -> execute(array($exp[4],$exp[5],$exp[0],$idconcierto));
				$numocupadas = $stmtocupadas -> rowCount();
				if($numocupadas > 0){
					echo 'error';
				}
				
				$insert = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				$ins = $gbd -> prepare($insert);
				$ins -> execute(array('NULL',$exp[4],$exp[5],1,$exp[0],$idconcierto,1,$descompra));
				
				$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
				$rand = md5($s.time()).mt_rand(1,10);
				$code = rand(1,9999999999).time();
				
				$insert2 = "INSERT INTO Boleto VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$ins2 = $gbd -> prepare($insert2);
				$ins2 -> execute(array('NULL',$rand,$code,$idcliente,$idconcierto,$exp[0],$exp[6],$exp[7],'A'));
				$idboleto = $gbd -> lastInsertId();
				
				if($envio == 'Domicilio'){
				$insert3 = "INSERT INTO domicilio VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$ins3 = $gbd -> prepare($insert3);
				$ins3 -> execute(array('NULL',$exp[4],$exp[5],1,$exp[0],$idconcierto,$idcliente,$idboleto,$formapago,$dir,$exp[6],$exp[7],'A'));
				}
				
				$trans = "INSERT INTO transaccion_distribuidor VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$stmttrans = $gbd -> prepare($trans);
				$stmttrans -> execute(array('NULL',$idcliente,$idconcierto,$exp[0],$_SESSION['idDis'],1,1,$formapago,$exp[3],$fechatime));
				
				$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'';
				$timeRightNow = time();
				$url = str_replace(' ','',$qr);
				$img = 'qr/'.$timeRightNow.'.png';
				file_put_contents($img, file_get_contents($url));
				
				$_SESSION['barcode'] = $code;
			}catch(PDOException $e){
				print_r($e);
			}
			$total = $total + $exp[3];
			$total = number_format($total,2);
			if($envio != 'Domicilio'){
			$content = '
			<page>
				<br>
				<br>
				<p align="center">Estimado cliente adjuntamos su boleto para:</p>
				<br>
				<font size = "5"><p align="center"><strong>'.$evento.'</strong></p></font>
				<br>
				<p align="center">El mismo que se efctuara en:</p>
				<br>
				<font size = "5"><p align="center"><strong>'.$lugar.'</strong></p></font>	
				<br>
				<p align="center">El dia: '.$fecha.' a las: '.$hora.'</p>
				<br>
				<p align="center">En la localidad: <strong>'.$exp[1].'</strong> costo: <strong>'.$exp[3].'</strong></p>
				<br>
				<p align="center"><strong>Tu asiento es : '.$exp[2].'</strong></p>
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
				<p align="center"><img alt="" src="http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$_SESSION['barcode'].'" /></p>
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
							Estimad@: '.$exp[6].'
						</td>
					</tr>
					<tr>
						<td>
							Su ticket para: '.$evento.'
						</td>
					</tr>
					<tr>
						<td>
							El dia: '.$fecha.' a las: '.$hora.'
						</td>
					</tr>
					<tr>
						<td>
							<img src="http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/qr/'.$timeRightNow.'.png" />
						</td>
					</tr>
					<tr>
						<td>
							Localidad: <strong>'.$exp[1].'</strong>
						</td>
					</tr>
					<tr>
						<td>
							Tu asiento es : <strong>'.$exp[2].'</strong>
						</td>
					</tr>
					<tr>
						<td>
							Costo del Ticket: $'.$exp[3].' 
						</td>
					</tr>
					<tr>
						<td>
							<img src="http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/barcode/'.$codigo.'.png" /><br>
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
								<span style="font-size:30px;"><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU(S) TICKET(S) ($'.$exp[3].') CON EXITO</strong></span>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								Estimado(a) <strong>'.$exp[6].'</strong> el sistema a generado su boleto:
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
							<td>
								<br>
								<br>
								<strong>Aviso!</strong> Este no es el BOLETO al concierto, es un comprobante de pago.
							</td>
						</tr>
						<tr>
							<td>
								<br>
								Debe canjear su boletos en: <strong>'.$dircanje.'</strong> Desde: <strong>'.$iniciocanje.'</strong> Hasta: <strong>'.$finalcanje.'</strong>
							</td>
						</tr>
						<tr>
							<td>
								<br>
								Para canjear su BOLETO, debe acercarce con el <strong>PDF</strong> adjunto a este mail impreso y el <strong>Documento de Identidad</strong> de la persona que realizo la compra.
							</td>
						</tr>
						<tr>
							<td>
								<br>
								Los Horarios de Atencion son de: <strong>Lunes a Domingo '.$horario.'</strong>
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
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/'.$timeRightNow.'.pdf','F');
			}
			catch(HTML2PDF_exception $e) {
				echo 'my errors '.$e;
				exit;
			}
			if($envio != 3){
			$ownerEmail = 'jonathan@practisis.com';
			$subject = 'Boleto para '.$exp[1].' - '.$exp[2].'';
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
			$mail->AddAddress($email,$exp[6]);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content2);
			$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
		
			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else{
			}
			}
			unlink('pdf/'.$timeRightNow.'.pdf');
			//unlink('qr/'.$timeRightNow.'.png');
			$counter++;
			}
		}
		if($envio == 'Domicilio'){
			$total = $total + $costoenvio;
			$total = number_format($total,2);
			$totales = '';
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
							<span style="font-size:30px;"><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU(S) TICKET(S) ($'.$total.') CON EXITO</strong></span>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<br>
							Estimado(a) <strong>'.$nombre.'</strong>:
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
							Su(s) TICKET(S) lo(s) recibira por: <img src="http://www.lcodigo.com/ticket/imagenes/servientrega.png" style="max-width:250px;"/> A la siguiente dirección: <strong>'.$dir.'</strong>
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
								foreach(explode('@', $_POST['valores']) as $value1){
								$exp1 = explode('|',$value1);
								$content3 .= '
								<tr>
									<td>'.$exp1[2].'</td>
									<td>'.$exp1[1].'</td>
									<td>1</td>
									<td>'.$exp1[3].'</td>
									<td>'.$exp1[3].'</td>
								</tr>
								';
								$totales += $exp1[3];
								}
								$totales = number_format($totales,2);
							$content3 .= '
								<tr>
									<td colspan="4" style="text-align:right;"><strong>SUBTOTAL</strong></td>
									<td style="text-align:right;"><strong>'.$totales.'</strong></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:right;"><strong>COSTO DE ENVIO</strong></td>
									<td style="text-align:right;"><strong>'.$costoenvio.'</strong></td>
								</tr>
								<tr>
									<td colspan="4" style="text-align:right;"><strong>TOTAL</strong></td>
									<td style="text-align:right;"><strong>'.$total.'</strong></td>
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
		//info de nueva cuenta
		
		if($envio != 3){
		$content2 = '
			<page>
				<br>
				<br>
				<p align="center"><a href="http://www.lcodigo.com/ticket"><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" /></a></p>
				<br>
				<p align="center">Estimado(a): <font size = "5"><strong>'.$nombre.'</strong></font> le proporcionamos la siguiente informacion:</p>
				<br>
				<p>*Su nombre de usuario es: <strong>'.$email.'</strong></p>
				<br>
				<p><strong>En su primer ingreso debe modificar su CONTRASEÑA para activar su cuenta en TICKETFACIL.</strong></p>
				<br>
				<p>*Contraseña provisional: <strong>'.$pass.'</strong></p>
				<br>
				<p align="center"><strong>Para ingresar a nuestro sistema ingrese a:</strong></p>
				<br>
				<p align="center">www.lcodigo.com/ticket?modulo=login</p>
				<br>
				<br>
				<br>
				<p align="center"><strong>Gracias por Preferirnos</strong></p>
				<br>
				<br>
				<p align="center"><strong>TICKETFACIL <I>La mejor experiencia de compra En Línea</I></strong></p>
			</page>';
		
		$ownerEmail = 'jonathan@practisis.com';
		$subject = 'Bienvenido a TICKETFACIL';
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
		$mail->MsgHTML($content2);
		// $mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
	
		if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else{
		}
		}
		if($envio == 'Domicilio'){
			echo 'ok';
		}else{
			echo $print;
		}
	}
?>