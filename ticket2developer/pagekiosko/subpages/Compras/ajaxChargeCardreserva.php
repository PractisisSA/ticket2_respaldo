<?php
	session_start();
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	
	include("../../controlusuarios/seguridadusuario.php");
	require_once('../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	require_once('../../stripe/lib/Stripe.php');
	Stripe::setApiKey('sk_test_6GSRONySlv39WktvlN4ZloaH');

	// $totalEntries = $_POST['totalEntries'];

	// for($i = 0; $i <= $totalEntries; $i++){
		// echo str_replace('|','&amp;',$_POST['code'.$i]).' :::: ';
		// }

	// exit;

	$token = $_POST['token'];
	$concert_id = (int)$_POST['concert_id'];
	// $loc_id = (int)$_POST['idLocal'];
	$total = $_POST['total'];
	$cantidad = $_POST['cant'];
	$nom = $_SESSION['username'];
	$email = $_SESSION['usermail'];
	$idcli = $_SESSION['id'];
	
	$select1 = "SELECT * FROM Cliente WHERE idCliente = ?";
	$slt1 = $gbd -> prepare($select1);
	$slt1 -> execute(array($idcli));
	$row1 = $slt1 -> fetch(PDO::FETCH_ASSOC);
	$envio = $row1['strEnvioC'];
	$dir = $row1['strDireccionC'];
	if($envio == 'Domicilio'){
		$envio = 'A tu Domicilio';
		$dir = $row1['strDireccionC'];
	}else if($envio == 'correo'){
		$envio = 'Correo Electronico';
		$dir = $email;
	}else if($envio == 'p_venta'){
		$envio = 'Punto de Venta';
		$dir = 'Cualquiera de nuestros Puntos de Venta';
	}
	
	$sql = "SELECT * FROM Concierto WHERE idConcierto = ?";
	$res = $gbd -> prepare($sql);
	$res -> execute(array($concert_id));
	$row = $res -> fetch(PDO::FETCH_ASSOC);
	
	$preciocents = ($total * 100);
	$evento = $row['strEvento'];
	$fecha = $row['dateFecha'];
	$lugar = $row['strLugar'];
	$hora = $row['timeHora'];
	$fecha_pago = $row['dateFechaPReserva'];
	$pagopor = 1;
	
	$cobroExitoso = false;

	try{
		$charge = Stripe_Charge::create(array(
			'amount' => $preciocents,
			'currency' => 'usd',
			'card' => $token,
			'description' => $evento
			));

		$cobroExitoso = true;
		$purchaseID = $charge->id;
		//echo $purchaseID;
		echo 'ok';
	}
	catch(Exception $e){
		$error = $e->getMessage();
		echo $error;
		
	}
	if($cobroExitoso === true){
		include('../../html2pdf/html2pdf/html2pdf.class.php');
		require_once '../../PHPM/PHPM/class.phpmailer.php';
		require_once '../../PHPM/PHPM/class.smtp.php';
		$status_boleto = 2;
		$estadoReserva = 'No';
		$pagoDep = 'No';
		$descompra = 3;
		$suma = 0;
		$cant_bol = 0;
		$valor_real = 0;
		$random = rand(1,99999999999999);
		foreach(explode('@',$_POST['valores']) as $valor){	
			$exVal = explode('|',$valor);
			
			$boletosok = "SELECT * FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
			$bolok = $gbd -> prepare($boletosok);
			$bolok -> execute(array($exVal[6],$exVal[7],$exVal[0],$concert_id));
			$numbolok = $bolok -> rowCount();
			if($numbolok > 0){
				echo 'error';
				return false;
			}
			
			$insertBol = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$resultInsertBol = $gbd -> prepare($insertBol);
			$resultInsertBol -> execute(array('NULL',$exVal[6],$exVal[7],$status_boleto,$exVal[0],$concert_id,$pagopor,$descompra));
			
			$suma += $exVal[5];
			$totalpagar = number_format($suma, 2,'.','');
			
			$selectLocal = "SELECT doublePrecioL FROM Localidad WHERE idLocalidad = ?";
			$resultLocal = $gbd -> prepare($selectLocal);
			$resultLocal -> execute(array($exVal[0]));
			$rowLocal = $resultLocal -> fetch(PDO::FETCH_ASSOC);
			
			$valor_real += $rowLocal['doublePrecioL'];
			$total_real = number_format($valor_real, 2,'.','');
			
			$porpagar = $cantidad * $rowLocal['doublePrecioL'];
			$porpagar = number_format($porpagar, 2,'.','');
			
			$insertReserva = "INSERT INTO Reserva VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$resultInsertReserva = $gbd -> prepare($insertReserva);
			$resultInsertReserva -> execute(array('NULL',$idcli,$concert_id,$exVal[0],$exVal[6],$exVal[7],$total,$porpagar,$estadoReserva,$pagoDep,$random,'NULL'));
		}
		$diferencia = $total_real - $totalpagar;
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
						<span style="font-size:30px;"><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU ABONO RESERVA ($'.$totalpagar.') CON EXITO</strong></span>
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
						Sus asientos estan reservados, Tiene hasta: <strong>'.$row['dateFechaPReserva'].'</strong>, para pagar el <span style="background-color:#EC1867;">SALDO de: <strong>$'.$diferencia.'</strong></span>,para completar el valor TOTAL de su(s) TICKET(S) caso contrario pierde su RESERVA y el valor de su ABONO RESERVA, tal como se detallo en los <strong>TERMINOS Y CONDICIONES DE USO DE TICKETFACIL</strong>
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
						* Para el concierto: <strong>'.$evento.'</strong>
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
						<table width="100%" align="center" border="1">
							<tr>
								<td style="text-align:center"><strong>Codigo</strong></td>
								<td style="text-align:center"><storng>Asientos #</strong></td>
								<td style="text-align:center"><strong>Descripcion</strong></td>
								<td style="text-align:center"><strong>Cantidad de Boletos</strong></td>
								<td style="text-align:center"><strong>Precio Reserva</strong></td>
								<td style="text-align:center"><strong>Precio Normal</strong></td>
							</tr>';
							$sumatotalrserva = 0;
							$sumatotalnormal = 0;
							foreach(explode('@',$_POST['valores']) as $val){	
								$exValor = explode('|',$val);
								$selectPrecio = "SELECT doublePrecioL FROM Localidad WHERE idLocalidad = ?";
								$resultPrecio = $gbd -> prepare($selectPrecio);
								$resultPrecio -> execute(array($exValor[0]));
								$rowPrecio = $resultPrecio -> fetch(PDO::FETCH_ASSOC);
								$content .= '<tr>
									<td style="text-align:center">'.$exValor[0].'</td>
									<td style="text-align:center">'.$exValor[1].'</td>
									<td style="text-align:center">'.$exValor[2].'</td>
									<td style="text-align:center">'.$exValor[3].'</td>
									<td style="text-align:center">'.$exValor[5].'</td>
									<td style="text-align:center">'.$rowPrecio['doublePrecioL'].'</td>
								</tr>';
								$sumatotalrserva += $exValor[5];
								$totalprereserva = number_format($sumatotalrserva, 2,'.','');
								$sumatotalnormal += $rowPrecio['doublePrecioL'];
								$totalprenormal = number_format($sumatotalnormal, 2,'.','');
							}
						$content .= '
							<tr>
								<td colspan="5" style="text-align:right;">
									<strong>TOTAL</strong>
								</td>
								<td style="text-align:center;">
									'.$totalprenormal.'
								</td>
							</tr>
							<tr>
								<td colspan="5" style="text-align:right;">
									<strong>ABONO RESERVA</strong>
								</td>
								<td  style="text-align:center;">
									'.$totalprereserva.'
								</td>
							</tr>
							<tr>
								<td colspan="5" style="text-align:right;">
									<span style="background-color:#EC1867;"><strong>SALDO</strong></span>
								</td>
								<td style="background-color:#EC1867; text-align:center;">
									'.$diferencia.'
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<strong>El SALDO lo puede pagar visitando este link:</strong>http://www.lcodigo.com/ticket/?modulo=pagoReservadep&idt='.$random.'
					</td>
				</tr>
				<tr>
					<td style="text-align:center;">
						<br>
						<strong>O</strong>
					</td>
				</tr>
				<tr>
					<td style="text-align:center;">
						<br>
						* Puede acercase a cualquier: <strong>SERVIPAGOS</strong> para cancelar el valor adeudado, realizar <strong>TRANSFERENCIA BANCARIA o DEPOSITO EN EFECTIVO</strong> en la cuenta #<strong>0000000000</strong>.
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
		}
	}
?>