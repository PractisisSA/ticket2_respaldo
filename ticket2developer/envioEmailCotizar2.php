<?php
	
	date_default_timezone_set('America/Guayaquil');
	require_once 'PHPM/PHPM/class.phpmailer.php';
	require_once 'PHPM/PHPM/class.smtp.php';
	$nombre = $_REQUEST['nombre'];
	$email = $_REQUEST['email'];
	$telefono = $_REQUEST['telefono'];
	$evento = $_REQUEST['evento'];
	$ciudad = $_REQUEST['ciudad'];
	$lugar = $_REQUEST['lugar'];
	$fecha = $_REQUEST['fecha'];
	$mensaje = $_REQUEST['mensaje'];
	
	// $valores_servicio = $_REQUEST['valores_servicio'];
	// //echo $valores_servicio;
	// $tipos=explode('@', $valores_servicio);
	
	$content = '
				<page>
					<div style="border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;">
					<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:11px;">
						<tr>
							<td style="text-align:center;" colspan = "2">
								<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="120px"/>
							</td>
						</tr>
						
						<tr>
							<td style = "text-align:right;padding:10px;">
								Nombre del Empresario : 
							</td>
							<td>
								'.$nombre.'
							</td>
						</tr>
						<tr>
							<td style = "text-align:right;padding:10px;">
								Email : 
							</td>
							<td>
								'.$email.'
							</td>
						</tr>
						<tr>
							<td style = "text-align:right;padding:10px;">
								Numero de telefono : 
							</td>
							<td>
								'.$telefono.'
							</td>
						</tr>
						
						<tr>
							<td style = "text-align:right;padding:10px;">
								Ciudad : 
							</td>
							<td>
								'.$ciudad.' 
							</td>
						</tr>
						<tr>
							<td style = "text-align:right;padding:10px;">
								Ciudad : 
							</td>
							<td>
								'.$mensaje.'
							</td>
						</tr>
						
					</table>
				</page>
	';
	// echo $content;
	// exit;
	include 'conexion.php';
	$sql = 'INSERT INTO `contacto` (`id`, `nombre`, `email`, `telefono`, `ciudad`, `mensaje`) VALUES (NULL, "'.$nombre.'" , "'.$email.'" , "'.$telefono.'" , "'.$ciudad.'" , "'.$mensaje.'");';
	$res = mysql_query($sql) or die (mysql_error());
	
	$subject = 'Solicitud de Contacto';
	$email = 'fabricio@practisis.com';
	$ownerEmail = 'info@ticketfacil';
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465;
	$mail->Username = "info@ticketfacil.ec";
	$mail->Password = "ticketfacil2012";
	$mail->SetFrom($ownerEmail,'TICKETFACIL');
	$mail->AddBCC("info@ticketfacil.ec", "copia contacto");
	$mail->AddBCC("fabricio@practisis.com", "copia contacto");
	$mail->From = $ownerEmail;
	$mail->AddAddress($email,$nom);
	$mail->FromName = 'TICKETFACIL';
	$mail->Subject = $subject;
	$mail->MsgHTML($content);
	if(!$mail->Send()){
		echo "Error de Envío: " . $mail->ErrorInfo;
	}
	else{
		echo '	Estimado : <label style = "color:#00ADEF;text-transform:uppercase;font-size:20px;" >'.$nombre.'</label> , 
				su solicitud de contacto a sido enviada con éxito ,
				en unos minutos un agente de ventas se comunicará con usted , <br><br>
				Ticketfacil la mejor experiencia de compra en línea <br><br>';
		//echo $content."|";
		//header('Location: ../../?modulo=preventaok&error=ok');
	}
	
?>