<?php
	// include("../controlusuarios/seguridadSA.php");
	require('../Conexion/conexion.php');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	include '../conexion.php';
	error_reporting(-1);
	// include('../html2pdf/html2pdf/html2pdf.class.php');
	require_once '../PHPM/PHPM/class.phpmailer.php';
	require_once '../PHPM/PHPM/class.smtp.php';
	$num_dep = $_GET['ndep'];
	$selectId = '	select  f.* , c.* 
					from factura as f , Cliente as c
					where id = "'.$num_dep.'" 
					and f.id_cli = c.idCliente
					';
	// echo $selectId."<br><br>";
	
	
	$resSelectId = mysql_query($selectId) or die (mysql_error());
	$rowSelectId = mysql_fetch_array($resSelectId);
	$codigo = $rowSelectId['id'];
	
	$sqlD = 'update Deposito set strDepositoD = "No" where idFactura = "'.$num_dep.'" ';
	$resD = mysql_query($sqlD) or die (mysql_error());
	
	
	$sqlF = 'update factura set estado = "No" where id = "'.$num_dep.'" ';
	$resF = mysql_query($sqlF) or die (mysql_error());
	
	$content = '
		<page>
			<div style="border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;">
				<table align="center" style="width:400px; border-collapse:separate; border-spacing:15px 5px;font-size:11px;" class="table table-hover">
					<tr>
						<td>
							<center><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="200px"/></center>
						</td>
					</tr>
					<tr>
						<td>
							<p align="center">Estimado "'.$rowSelectId['strNombresC'].'" se le informa que su deposito es <strong>INCORRECTO</strong></p>
						</td>
					</tr>
					<tr>
						<td>
							<p align="center">Se le recomienda revisar el <strong>NUMERO DE DEPOSITO: </strong>'.$rowSelectId['ndepo'].'</p>
						</td>
					</tr>
					<tr>
						<td>
							<p align="center">y Volverlo a ingresar al siguiente link:</p>
							<p align="center"><a href="http://ticketfacil.ec/ticket2/?modulo=deposito&cod='.$codigo.'"/>Aquí</a></p>	
						</td>
					</tr>
					<tr>
						<td>
							<br><strong>Gracias por Preferirnos</strong>
							<br>
							<strong>TICKETFACIL <I>"La mejor experiencia de compra En Línea"</I></strong>
						</td>
					</tr>
				</table>
			</div>
		</page>';
	// try{
		// $html2pdf = new HTML2PDF('P', 'A4', 'en');    
		// //$html2pdf->setModeDebug();
		// $html2pdf->setDefaultFont('Arial');
		// $html2pdf->writeHTML($content);
		// $html2pdf->Output('pdfd/'.$timeRightNow.'.pdf','F');
		// }
	// catch(HTML2PDF_exception $e) {
		// echo 'my errors '.$e;
		// exit;
		// }
	// echo $content;
	// exit;
	$ownerEmail = 'info@ticketfacil.ec';
	$subject = 'Error de Deposito';
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
	$mail->AddAddress($rowSelectId['strMailC'],$rowSelectId['strNombresC']);
	$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
	$mail->FromName = 'TICKETFACIL';
	$mail->Subject = $subject;
	$mail->MsgHTML($content);
//	$mail->AddAttachment('pdfd/'.$timeRightNow.'.pdf'); // attachment
	if(!$mail->Send()){
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
	else{
		
		if($resD){
			echo '	<script>
						window.location = "http://ticketfacil.ec/ticket2/?modulo=Rdepositos";
					</script>';
		}
	}
?>