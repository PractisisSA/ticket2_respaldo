<?php 
	require_once '../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../PHPM/PHPM/class.smtp.php';
	require_once('../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$email = $_POST['mail'];
	
	$sql = 'SELECT * FROM Cliente WHERE strMailC = "'.$email.'" ';
	//echo $sql;
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute();
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	$cedula = base64_encode($row['strDocumentoC']);
	$numreg = $stmt -> rowCount();
	
	if($numreg > 0){
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
							Estimad@ <strong>'.$row['strNombresC'].'</strong> le proporcionamos la siguiente información:
						</td>
					</tr>
					<tr>
						<td>
							<br>
							<br>
							* Copie el siguiente código para recuperar su contraseña.
						</td>
					</tr>
					<tr>
						<td>
							<br>
							* Código: <strong>'.$cedula.'</strong>
						</tr>
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
			</page>
		';
		$ownerEmail = 'info@ticketfacil.ec';
		$subject = 'Recuperar contrasena TICKETFACIL';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->Username = "info@ticketfacil.ec";
		$mail->Password = "ticketfacil2012";
		$mail->AddReplyTo($ownerEmail,'TICKETFACIL');
		$mail->SetFrom($ownerEmail,'TICKETFACIL');
		$mail->From = $ownerEmail;
		$mail->AddAddress($email,$row['strNombresC']);
		$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
		$mail->FromName = 'TICKETFACIL';
		$mail->Subject = $subject;
		$mail->MsgHTML($content);
		//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
		if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else{
			echo 'ok';
		}
	}else{
		echo 'error';
	}
?>