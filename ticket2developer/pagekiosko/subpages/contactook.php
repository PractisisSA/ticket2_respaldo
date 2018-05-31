<?php 
	require('Conexion/conexion.php');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	$nombre = $_REQUEST['nombre'];
	$mail = $_REQUEST['mail'];
	$asunto = $_REQUEST['asunto'];
	$sms = $_REQUEST['mensaje'];
	$tel = $_REQUEST['tel'];
	$dir = $_REQUEST['dir'];
	$sql = "INSERT INTO Contacto VALUES (NULL, '$nombre', '$mail', '$asunto', '$sms')" or die(mysqli_error());
	$res = $mysqli->query($sql);
	if ($res > 0){
		require_once 'PHPM/PHPM/class.phpmailer.php';
		require_once 'PHPM/PHPM/class.smtp.php';
		$content = '
			<page>
				<br>
				<br>
				<p align="center">Estimado <strong>'.$nombre.'</strong> tu petición es la siguiente:</p>
				<br>
				<br>
				<p align="center">("'.$sms.'")</p>
				<br>
				<br>
				<p align="center">En breve nos comunicaremos para dar solución a su problema...</p>
				<br>
				<br>
				<p align="center">Gracias por comunicarte con TODOTICKET</p>
			</page>';
		$ownerEmail = 'jonathan@practisis.com';
		$subject = $asunto;
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->Username = "jonathan@practisis.com";
		$mail->Password = "dios3s4mor";
		$mail->AddReplyTo($ownerEmail,'TODOTICKET');
		$mail->SetFrom($ownerEmail,'TODOTICKET');
		$mail->From = $ownerEmail;
		$mail->AddAddress($mailU,$nombre);
		$mail->AddAddress($ownerEmail,'TODOTICKET');     // Add a recipient
		$mail->FromName = 'TODOTICKET';
		$mail->Subject = $subject;
		$mail->MsgHTML($content);
		//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
		if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else{
			//echo 'ok';
		}
		echo'Tu mensaje a sido enviado';
	}else{
		echo'Error';
	}
?>