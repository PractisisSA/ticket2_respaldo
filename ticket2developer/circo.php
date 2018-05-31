<?php
	session_start();
	date_default_timezone_set('America/Guayaquil');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	
	include 'cone.php';
	require_once 'PHPM/PHPM/class.phpmailer.php';
	require_once 'PHPM/PHPM/class.smtp.php';
	
	$sqlB = 'select * from usuarios order by id_usu asc';
	$resB = mysql_query($sqlB) or die (mysql_error());
	while($row = mysql_fetch_array($resB)){
		$co = '
			<page>
				<div style="border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;">
					<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:11px;">
						<tr>
							<td style="text-align:center;">
								<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="120px"/>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								Estimado '.$row['nom1_usu'].'  '.$row['ape1_usu'].' <br><br>
								
								La familia de http://www.ticketfacil.ec <br>
								
								tenemos el agrado de invitarte a la semana de clausura del <strong>GRAN CIRCO DE RUSIA</strong><br>
								No te puedes quedar fuera.<br><br>
								
								Te esperamos en el parqueadero del cci para las ultimas funciones<br><br>
								
								Grandes Descuentos y promociones en compras web.<br><br>
								
								Ticketfacil.ec<br>
								
								La mejor experiencia de compra en L&iacute;nea
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<img src="http://ticketfacil.ec/ticket2/imagenes/circo.jpg" width = "100%"/>
							</td>
						</tr>
					</table>
					<div style ="position:absolute;top:75px;width:205px;height:auto;background-color:rgba(255,255,255,0.6);padding: 20px;color:#000;font-family:corbel;">
						
						
					</div>
				</div>
				
			</page>
		';
		
		// $email = 'fabricio@practisis.com';
		$email = $row['lin_usu'];
	
		$ownerEmail = 'info@ticketfacil.ec';
		$subject = 'Gran Circo de Rusia';
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
		$mail->AddCC("fabricio@practisis.com", "");
		$mail->From = $ownerEmail;
		$mail->AddAddress($email,'Cliente');

		$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
		$mail->FromName = 'TICKETFACIL';
		$mail->Subject = $subject;
		$mail->MsgHTML($co);

		if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else{
			echo 'ok enviado<br><br>';
		}
	}
		// echo $co;
?>