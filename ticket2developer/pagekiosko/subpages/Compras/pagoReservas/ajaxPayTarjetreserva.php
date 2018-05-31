<?php 
	session_start();
	include("../../../controlusuarios/seguridadusuario.php");
	require('../../../Conexion/conexion.php');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	require_once('../../../stripe/lib/Stripe.php');
	Stripe::setApiKey('sk_test_6GSRONySlv39WktvlN4ZloaH');
	
	$token = $_POST['token'];
	$nameCli = $_POST['nameCli'];
	$total = $_POST['precio'];
	$codigo = $_POST['codigo'];
	$preciocents = ($total * 100);
	
	$selectEvento = "SELECT strEvento FROM Reserva JOIN Concierto ON Reserva.idConciertoR = Concierto.idConcierto WHERE intIdentificateR = '$codigo' 
					AND strEstadoR = 'No' AND pagoDepR = 'No'" or die(mysqli_error($mysqli));
	$resultEvento = $mysqli->query($selectEvento);
	$rowEvento = mysqli_fetch_array($resultEvento);
	$evento = $rowEvento['strEvento'];
	
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
		echo 'PAGO EXITOSO..!!';
	}
	catch(Exception $e){
		$error = $e->getMessage();
		echo $error;
		
	}
	
	if($cobroExitoso === true){
		include('../../../html2pdf/html2pdf/html2pdf.class.php');
		require_once '../../../PHPM/PHPM/class.phpmailer.php';
		require_once '../../../PHPM/PHPM/class.smtp.php';
		
		$selectIds = "SELECT strEvento, strLugar, dateFecha, timeHora, strDescripcionL, doublePrecioL, idClienteR, idConciertoR, idLocalidadR, intFilaR, 
						intColumnaR, strNombresC, strMailC 
						FROM Reserva 
						JOIN Concierto ON Reserva.idConciertoR = Concierto.idConcierto
						JOIN Localidad ON Reserva.idLocalidadR = Localidad.idLocalidad
						JOIN Cliente ON Reserva.idClienteR = Cliente.idCliente
						WHERE intIdentificateR = '$codigo' AND strEstadoR = 'No' AND pagoDepR = 'No'" or die(mysqli_error($mysqli));
		$resultSelectIds = $mysqli->query($selectIds);
		$counter = 1;
		while($rowIds = mysqli_fetch_array($resultSelectIds)){
	
			$status_boleto = 1;
			$updateOcupadas = "UPDATE ocupadas SET status = '$status_boleto' WHERE row = '".$rowIds['intFilaR']."' AND col = '".$rowIds['intColumnaR']."' 
							AND local = '".$rowIds['idLocalidadR']."' AND concierto = '".$rowIds['idConciertoR']."'" or die(mysqli_error($mysqli));
			$resultUpdOcupadas = $mysqli->query($updateOcupadas);
			
			$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
			$rand = md5($s.time()).mt_rand(1,10);
			$est ="A";
			$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'';
			$code = rand(1,9999999999).time();
			$_SESSION['barcode'] = $code;
			$query1 = "INSERT INTO Boleto VALUES (NULL, '$rand', '".$_SESSION['barcode']."', '".$rowIds['idClienteR']."', '".$rowIds['idConciertoR']."', 
						'".$rowIds['idLocalidadR']."', '$est')" or die(mysqli_error($mysqli));
			$result = $mysqli->query($query1);
			
			$timeRightNow = time();
			$url = str_replace(' ','',$qr);
			$img = 'qr/'.$timeRightNow.'.png';
			file_put_contents($img, file_get_contents($url));
			
			$content = '
			<page>
				<br>
				<br>
				<p align="center">Estimado cliente adjuntamos su boleto para:</p>
				<br>
				<font size = "5"><p align="center"><strong>'.$rowIds['strEvento'].'</strong></p></font>
				<br>
				<p align="center">El mismo que se efctuara en:</p>
				<br>
				<font size = "5"><p align="center"><strong>'.$rowIds['strLugar'].'</strong></p></font>	
				<br>
				<p align="center">El dia: '.$rowIds['dateFecha'].' a las: '.$rowIds['timeHora'].'</p>
				<br>
				<p align="center">En la localidad: <strong>'.$rowIds['strDescripcionL'].'</strong> costo: <strong>'.$rowIds['doublePrecioL'].'</strong></p>
				<br>
				<p align="center"><strong>Tu asiento es : Fila-'.$rowIds['intFilaR'].'_Silla-'.$rowIds['intColumnaR'].'</strong></p>
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
				<p align="center"><img alt="" src="http://www.lcodigo.com/ticket/subpages/Compras/codigo_barras.php?barcode='.$_SESSION['barcode'].'" /></p>
				<p align="center">'.$_SESSION['barcode'].'</p>
				<br>
			</page>';
			
			try{
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($content);
				$html2pdf->Output('pdf/'.$timeRightNow.'.pdf','F');
			}
			catch(HTML2PDF_exception $e) {
				echo 'my errors '.$e;
				exit;
			}
			$ownerEmail = 'jonathan@practisis.com';
			$subject = 'Boleto # '.$counter.' para ('.$rowIds['strDescripcionL'].')';
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 465;
			$mail->Username = "jonathan@practisis.com";
			$mail->Password = "dios3s4mor";
			$mail->AddReplyTo($ownerEmail,'TICKETFACIL');
			$mail->SetFrom($ownerEmail,'TICKETFACIL');
			$mail->From = $ownerEmail;
			$mail->AddAddress($rowIds['strMailC'],$rowIds['strNombresC']);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML('Saludos!, Disfrute el evento...!!!');
			$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
		
			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else{
				//echo 'ok';
			}
			$counter++;
		}
		$pagotarjeta = 'Tarjeta';
		$estadoReserva = 'ok';
		$updateReserva = "UPDATE Reserva SET strEstadoR = '$estadoReserva', pagoDepR = '$pagotarjeta' WHERE intIdentificateR = '$codigo'" or die(mysqli_error($mysqli));
		$resultUpdReserva = $mysqli->query($updateReserva);
		
	}
?>