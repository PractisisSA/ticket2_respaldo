<?php
	session_start();
	require_once('../classes/private.db.php');
	require_once '../PHPM/PHPM/class.phpmailer.php';
	require_once '../PHPM/PHPM/class.smtp.php';
	$gbd = new DBConn();
	
	// print_r($_POST);
	$nombres = $_POST['nombres'];
	$documento = $_POST['documento'];
		$anio = $_POST['anio'];
		$mes = $_POST['mes'];
		$dia = $_POST['dia'];
	$fecha = $anio.'-'.$mes.'-'.$dia;
	$genero = $_POST['genero'];
	$email = $_POST['mail'];
	$pass = $_POST['pass'];
	$pass = md5($pass);
	$movil = $_POST['movil'];
	$fpago = $_POST['fpago'];
	$oboleto = $_POST['oboleto'];
	if($oboleto == 'Domicilio'){
		$provincia = $_POST['provincia'];
		$ciudad = $_POST['ciudad'];
		$direccion = $_POST['direccion'];
		$fijo = $_POST['fijo'];
	}else{
		$provincia = 'Ninguno';
		$ciudad = 'Ninguno';
		$direccion = 'Ninguno';
		$fijo = 'Ninguno';
	}
	
	$s = "SELECT strDocumentoC, strMailC FROM Cliente WHERE strDocumentoC = ? AND strMailC = ?";
	$stmt = $gbd -> prepare($s);
	$stmt -> execute(array($documento,$email));
	$cli_ok = $stmt -> rowCount();
	if($cli_ok == 0){
		$autoid = 'NULL';
		$autotime = 'NULL';
		$ins = "INSERT INTO Cliente VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmtins = $gbd -> prepare($ins);
		$stmtins -> execute(array($autoid,$nombres,$email,$pass,$documento,$direccion,$fecha,$genero,$ciudad,$provincia,$fijo,$movil,$fpago,$oboleto,'no',$autotime));
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
		$_SESSION['id'] = $id;
		$_SESSION['username'] = $nom;
		$_SESSION['userdoc'] = $doc;
		$_SESSION['userciudad'] = $ciu;
		$_SESSION['userprov'] = $pro;
		$_SESSION['usertel'] = $tel;
		$_SESSION['usertelf'] = $tfijo;
		$_SESSION['usermail'] = $email;
		$_SESSION['userdir'] = $dir;
		$_SESSION['formapago'] = $formP;
		$_SESSION['formenvio'] = $formEnvio;
		$_SESSION['fech_nac'] = $fecha_nac;
		$_SESSION['genero'] = $genero_cli;
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
							Estimad@ <strong>'.$nom.'</strong> le proporcionamos la siguiente información:
						</td>
					</tr>
					<tr>
						<td>
							<br>
							<br>
							<br>
							* Le informamos que su cuenta ha sido activada satisfactoriamente.
						</td>
					</tr>
					<tr>
						<td>
							<br>
							* Desde este momento puede hacer uso de todos los beneficios que ofrece TICKETFACIL
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
			</page>';
		$ownerEmail = 'jonathan@practisis.com';
		$subject = 'Bienvenid@ a TICKETFACIL';
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
			echo 'ok';
		}
	}else if($cli_ok > 0){
		echo "error";
	}
?>