<?php 
	include("../../controlusuarios/seguridadusuario.php");
	require_once('../../classes/private.db.php');
	require_once '../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../PHPM/PHPM/class.smtp.php';
	
	$gbd = new DBConn();
	
	$idConcierto = $_GET['evento'];
	$nom = $_SESSION['username'];
	$email = $_SESSION['usermail'];
	$id_cli = $_SESSION['id'];
	$random = mt_rand();
	$numero = 0;
	$fecha = 0;
	$status = 2;
	$estado = "Revisar";
	$est_deposito = "No";
	$total_pago = $_POST['total_pagar'];
	$pagopor = 3;
	$descompra = 3;
	$suma = 0;
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
		
		foreach($_POST['codigo'] as $key=>$cod_loc){
			
			$boletosok = "SELECT * FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
			$bolok = $gbd -> prepare($boletosok);
			$bolok -> execute(array($_POST['row'][$key],$_POST['col'][$key],$cod_loc,$idConcierto));
			$numbolok = $bolok -> rowCount();
			if($numbolok > 0){
				echo 'error';
				header('Location: ../../?modulo=preventaok&error='.$idConcierto.'');
				return false;
			}
			
			$query = "INSERT INTO pventa VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$res = $gbd -> prepare($query);
			$res -> execute(array('NULL',$numero,$fecha,$_POST['row'][$key],$_POST['col'][$key],$id_cli,$idConcierto,$cod_loc,$random,$_POST['num'][$key],$estado,$est_deposito,'SN','NULL','NULL'));
			
			$insertAsientos = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$resulinsertAsientos = $gbd -> prepare($insertAsientos);
			$resulinsertAsientos -> execute(array('NULL',$_POST['row'][$key],$_POST['col'][$key],$status,$_POST['codigo'][$key],$idConcierto,$pagopor,$descompra));
			
			$selectPrecio = "SELECT doublePrecioL FROM Localidad WHERE idLocalidad = ?";
			$resultPrecio = $gbd -> prepare($selectPrecio);
			$resultPrecio -> execute(array($cod_loc));
			$rowPrecio = $resultPrecio -> fetch(PDO::FETCH_ASSOC);
			
			$suma += $rowPrecio['doublePrecioL'];
			$precio_normal = number_format($suma, 2,'.','');
		}
		$query1 = "SELECT * FROM Concierto WHERE idConcierto = ?";
		$result = $gbd -> prepare($query1);
		$result -> execute(array($idConcierto));
		$row1 = $result -> fetch(PDO::FETCH_ASSOC);
		$e = $row1['strEvento'];
		$fecha_pago = $row1['dateFechaPReserva'];
		$diferencia = $precio_normal - $total_pago;
		$diferencia = number_format($diferencia,2);
		$totalreserva = '';
		$totalnormal = '';
		
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
							Estimado(a) <strong>'.$nom.'</strong> le proporcionamos la siguiente información:
						</td>
					</tr>
					<tr>
						<td>
							<br>
							<br>
							<br>
							* Sus asientos estan reservados, <span style="background-color:#EC1867;">por un valor de <strong>$'.$total_pago.'</strong></span>, si el pago se realiza dentro de las siguientes: <strong>'.$row1['tiempopagoC'].'</strong>, caso contrario su reserva sera ELIMINADA
						</td>
					</tr>
					<tr>
						<td>
							<br>
							Una vez pagada la reserva tiene hasta <strong>'.$row1['dateFechaPReserva'].'</strong>, para pagar el SALDO de: <strong>$'.$diferencia.'</strong>, caso contrario pierde su RESERVA y el valor de su ABONO RESERVA, tal como se detallo en los <strong>TERMINOS Y CONDICIONES DE USO DE TICKETFACIL</strong>
						</td>
					</tr>
					<tr>
						<td>
							<br>
							Una vez pagada la totalidad de sus TICKETS los recibira por: <strong>'.$envio.'</strong>, a la siguiente dirección: <strong>'.$dir.'</strong>
						</td>
					</tr>
					<tr>
						<td>
							<br>
							* Su código de compra es el siguiente: <strong>'.$random.'</strong>
						</tr>
					</tr>
					<tr>
						<td>
							<br>
							* Para el concierto: <strong>'.$e.'</strong>
						</tr>
					</tr>
					<tr>
						<td>
							<br>
							* Su(s) asientos reservados son: 
						</tr>
					</tr>
					<tr>
						<td>
							<br>
							<br>
							<table width="100%" align="center" border="1">
								<tr>
									<td style="text-align:center"><strong>Localidad</strong></td>
									<td style="text-align:center"><strong>Asientos #</strong></td>
									<td style="text-align:center"><strong>Cantidad de Boletos</strong></td>
									<td style="text-align:center"><strong>Precio Unitario</strong></td>
									<td style="text-align:center"><strong>Precio Reserva</strong></td>
									<td style="text-align:center"><strong>Precio Normal</strong></td>
								</tr>';
								foreach($_POST['codigo'] as $key=>$cod_loc){
									$sql = "SELECT doublePrecioL FROM Localidad WHERE idLocalidad = ?";
									$stmt = $gbd -> prepare($sql);
									$stmt -> execute(array($cod_loc));
									$rownorm = $stmt -> fetch(PDO::FETCH_ASSOC);
								$content .= '<tr>
									<td style="text-align:center">'.$_POST['des'][$key].'</td>
									<td style="text-align:center">'.$_POST['chair'][$key].'</td>
									<td style="text-align:center">'.$_POST['num'][$key].'</td>
									<td style="text-align:center">'.$_POST['pre'][$key].'</td>
									<td style="text-align:center">'.$_POST['tot'][$key].'</td>
									<td style="text-align:center">'.$rownorm['doublePrecioL'].'</td>
								</tr>';
								$totalreserva = $totalreserva + $_POST['pre'][$key];
								$totalnormal = $totalnormal + $rownorm['doublePrecioL'];
								}
								$debe = $totalnormal - $totalreserva;
								$totalnormal = number_format($totalnormal,2);
								$totalreserva = number_format($totalreserva,2);
								$debe = number_format($debe,2);
							$content .= '
								<tr>
									<td colspan="5" style="text-align:right;">
										<strong>TOTAL</strong>
									</td>
									<td>
										'.$totalnormal.'
									</td>
								</tr>
								<tr>
									<td colspan="5" style="text-align:right;">
										<span style="background-color:#EC1867;"><strong>ABONO RESERVA</strong></span>
									</td>
									<td  style="background-color:#EC1867;">
										'.$totalreserva.'
									</td>
								</tr>
								<tr>
									<td colspan="5" style="text-align:right;">
										<strong>SALDO</strong>
									</td>
									<td>
										'.$debe.'
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							* Puede acercarse a cualquier: <img src="http://www.lcodigo.com/ticket/imagenes/logo_Fybeca.gif"/> para cancelar el valor adeudado.
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<br>
							<strong>Gracias por Preferirnos</strong>
							<br>
							<strong>TICKETFACIL <I>"La mejor experiencia de compra En Línea"</I></strong>
						</td>
					</tr>
				</table>
			</page>';
		$ownerEmail = 'jonathan@practisis.com';
		$subject = 'Informacion de Pago por Reserva';
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
		}
		header('Location: ../../?modulo=preventaok&error=ok');
	}
?>