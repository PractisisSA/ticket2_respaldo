<?php
	session_start();
	require_once('../classes/private.db.php');
	require_once '../PHPM/PHPM/class.phpmailer.php';
	require_once '../PHPM/PHPM/class.smtp.php';
	$gbd = new DBConn();
	
	$nombres = $_REQUEST['nombres'];
	$email = $_REQUEST['mail'];
	$pass = $_REQUEST['pass'];
	$pass = md5($pass);
	$documento = $_REQUEST['documento'];
	$direccion = $_REQUEST['direccion'];

	if ($direccion == 0 || $direccion == '') {
		$direccion = '';
	}

	$fecha = $_REQUEST['birthday'];
	if ($fecha == '' || $fecha == 0) {
		$fecha = '';
	}

	$genero = $_REQUEST['genero'];
	if ($genero == '' || $genero == 0) {
		$genero = '';
	}else{
		$genero = '';
	}

	$movil = $_REQUEST['movil'];
	if ($movil == '' || $movil == 0) {
		$movil = '';
	}

	$s = "SELECT strDocumentoC, strMailC FROM Cliente WHERE strDocumentoC = ? AND strMailC = ?";
	$stmt = $gbd -> prepare($s);
	$stmt -> execute(array($documento,$email));
	$cli_ok = $stmt -> rowCount();

	if($cli_ok == 0){
	$ins = "INSERT INTO Cliente (strNombresC, strMailC, strContrasenaC, strDocumentoC, strDireccionC, strFechaNanC, strGeneroC, strCiudadC, strProvinciaC, strTelefonoC, intTelefonoMovC, strFormPagoC, strEnvioC, cambiopassC, fechaCreacionC, clave_face) VALUES('".$nombres."', '".$email."', '".$pass."', '".$documento."', '".$direccion."', '".$fecha."', '".$genero."', '', '', '".$movil."', '', 1, '', 'no', '".$fecha."', '')";
	$stmtins = $gbd -> prepare($ins);
	$stmtins -> execute();
	$ult_cliente = $gbd -> lastInsertId();
	$select = "SELECT * FROM Cliente WHERE idCliente = ?";
	$res = $gbd -> prepare($select);
	$res -> execute(array($ult_cliente));

	$row = $res -> fetch(PDO::FETCH_ASSOC);
	$id = htmlspecialchars($row['idCliente']);
	$nom = htmlspecialchars($row['strNombresC']);
	$doc = htmlspecialchars($row['strDocumentoC']);
	$ciu = htmlspecialchars($row['strCiudadC']);
	$pro = htmlspecialchars($row['strProvinciaC']);
	$tfijo = htmlspecialchars($row['strTelefonoC']);
	$tel = htmlspecialchars($row['intTelefonoMovC']);
	$email = htmlspecialchars($row['strMailC']);
	$dir = htmlspecialchars($row['strDireccionC']);
	$formP = htmlspecialchars($row['strFormPagoC']);
	$formEnvio = htmlspecialchars($row['strEnvioC']);
	$contrasena = htmlspecialchars($row['strContrasenaC']);
	$fecha_nac = htmlspecialchars($row['strFechaNanC']);
	$genero_cli = htmlspecialchars($row['strGeneroC']);

	$_SESSION['autentica'] = 'uzx153';
	$_SESSION['autentica_nuevo'] = 'uzx153-321';
	$_SESSION['id'] = $id;
	$_SESSION['username'] = $nom;
	$_SESSION['userdoc'] = $doc;
	$_SESSION['usertelf'] = $tfijo;
	$_SESSION['usermail'] = $email;
	$_SESSION['fech_nac'] = $fecha_nac;
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
						Estimad@ <strong>'.$nom.'</strong>
					</td>
				</tr>
				<tr>
					<td style="text-align:center;">
						<br>
						<br>
						<br>
						* Su cuenta ha sido activada satisfactoriamente.
					</td>
				</tr>
				<tr>
					<td style="text-align:center;">
						<br>
						* Desde este momento puede hacer uso de todos los beneficios que ofrece TICKETFACIL
					</tr>
				</tr>
				<tr>
					<td style="text-align:center;">
						<br>
						<strong>Gracias por Preferirnos</strong>
						<br>
						<strong>TICKETFACIL <I>"La mejor experiencia de compra En L&iacute;nea"</I></strong>
					</td>
				</tr>
			</table>
		</page>';
	$ownerEmail = 'info@ticketfacil.ec';
	$subject = 'Bienvenid@ a TICKETFACIL';
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
	$mail->AddAddress($email,$nom);
	$mail->AddAddress($ownerEmail,'TICKETFACIL');
	$mail->AddCC("info@ticketfacil.ec", "copia de nuevo usuario");
	$mail->AddCC("fabricio@practisis.com", "copia de nuevo usuario");
	$mail->FromName = 'TICKETFACIL';
	$mail->Subject = $subject;
	$mail->MsgHTML($content);
	//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); attachment
		if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}else{
			echo $nom.'-'.$email;
		}
	}else if($cli_ok > 0){
		echo "error";
	}
?>