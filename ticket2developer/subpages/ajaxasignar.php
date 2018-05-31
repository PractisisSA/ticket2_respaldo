<?php 
	require_once('../classes/private.db.php');
	require_once '../PHPM/PHPM/class.phpmailer.php';
	require_once '../PHPM/PHPM/class.smtp.php';
	include("../controlusuarios/seguridadusuario.php");
	
	$gbd = new DBConn();
	
	$nuevonombre = $_REQUEST['nuevonombre'];
	$nuevacedula = $_REQUEST['nuevacedula'];
	$id = $_REQUEST['id'];
	$asiento = $_REQUEST['asiento'];
	$concierto = $_REQUEST['concierto'];
	$localidad = $_REQUEST['localidad'];
	
	try{
		$update = "UPDATE Boleto SET nombreHISB = ?, documentoHISB = ?, asignarB = ? WHERE idBoleto = ?";
		$sql = $gbd -> prepare($update);
		$sql -> execute(array($nuevonombre,$nuevacedula,'A',$id));
		
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
						Estimad@ <strong>'.$_SESSION['username'].'</strong> le proporcionamos la siguiente información:
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<br>
						<br>
						* Le informamos que su TICKET ha sido asignado satisfactoriamente.
					</td>
				</tr>
				<tr>
					<td>
						<br>
						* Asiento asignado: <strong>'.$asiento.'</strong><br>
						* Nombre del Beneficiario: <strong>'.$nuevonombre.'</strong><br>
						* Cédula del Beneficiario: <strong>'.$nuevacedula.'</strong><br>
						* Para el Evento: <strong>'.$concierto.'</strong><br>
						* En la Localidad: <strong>'.$localidad.'</strong><br>
					</tr>
				</tr>
				<tr>
					<td>
						<br>
						<br>
						<br>
						* Le recordamos que el ingreso al evento con este TICKET es con la cédula del nuevo beneficiario ingresado.
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
		$subject = 'Informacion TICKETFACIL';
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
		$mail->AddAddress($_SESSION['usermail'],$_SESSION['username']);
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
	}catch(PDOException $e){
		print_r($e);
	}
?>