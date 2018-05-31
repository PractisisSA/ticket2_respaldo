<?php
	session_start();
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	include '../../conexion.php';
	$cadaBoleto = $_REQUEST['cadaBoleto'];
	include('../../html2pdf/html2pdf/html2pdf.class.php');
	require_once '../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../PHPM/PHPM/class.smtp.php';
	
	
	$sqlB = 'select * from Boleto where idBoleto = "'.$cadaBoleto.'"  order by idBoleto DESC limit 1';
	//echo $sqlB;
	$resB = mysql_query($sqlB) or die (mysql_error());
	$rowB = mysql_fetch_array($resB);
	if($rowB['serie'] == null || $rowB['serie'] == '' ){
		$numeroSerie = 1;
	}else{
		$numeroSerie = ($rowB['serie'] + 1);
	}
	$_SESSION['barcode'] = $rowB['strBarcode'];
	
	
	
	$sqlTC = 'select * from Concierto where idConcierto = "'.$rowB['idCon'].'" ';
	$resTC = mysql_query($sqlTC) or die (mysql_error());
	$rowTC = mysql_fetch_array($resTC);
	//echo $rowTC['tipo_conc'];
	if($rowTC['tipo_conc']==2){
		
		
		
		$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rowB['strQr'].'';
		//echo $qr;
		$sqlDB = 'select * from detalle_boleto where idBoleto = "'.$rowB['idBoleto'].'" ';
		$resDB = mysql_query($sqlDB) or die(mysql_error());
		$rowDB = mysql_fetch_array($resDB);
		
		$sqlCl = 'select * from Cliente where idCliente = "'.$rowB['idCli'].'" '; 
		$resCl = mysql_query($sqlCl) or die (mysql_error());
		$rowCl = mysql_fetch_array($resCl) ;
		
		
		$sql2 = 'select * from Localidad where idLocalidad = "'.$rowB['idLocB'].'" ';
		$res2 = mysql_query($sql2) or die (mysql_error());
		$row2 = mysql_fetch_array($res2);
		
		$sqlAut = 'select * from autorizaciones where idAutorizacion = "'.$rowTC['tiene_permisos'].'" order by idAutorizacion ASC limit 1';
			//echo $sqlAut;
		$resAut = mysql_query($sqlAut) or die (mysql_error());
		if(mysql_num_rows($resAut)>0){
			$rowAut = mysql_fetch_array($resAut);
			$numBoletoVendido = '<b>BOLETO:</b> ('.$rowAut['codestablecimientoAHIS'].'-'.$rowAut['serieemisionA'].'-0000'.$numeroSerie.') ';
		}else{
			$numBoletoVendido = '<b>BOLETO:</b> (0000'.$numeroSerie.') ';
		}
		function image_exists($url){
			if(getimagesize($url)){
				return 1;
			}else{
				return 0;
			}
		}
		
		if(image_exists('http://ticketfacil.ec/ticket2/pagekiosko/subpages/Compras/barcode/'.$rowB['strBarcode'].'.png') == 1){
			$ruta = 'http://ticketfacil.ec/ticket2/pagekiosko/subpages/Compras/barcode/'.$rowB['strBarcode'].'.png';
		}else{
			if(image_exists('http://ticketfacil.ec/ticket2/distribuidor/ventas/ajax/barcode/'.$rowB['strBarcode'].'.png') == 1){
				$ruta = 'http://ticketfacil.ec/ticket2/distribuidor/ventas/ajax/barcode/'.$rowB['strBarcode'].'.png';
			}else{
				if(image_exists('http://ticketfacil.ec/ticket2/distribuidor/cobros/ajax/barcode/'.$rowB['strBarcode'].'.png')==1){
					$ruta = 'http://ticketfacil.ec/ticket2/distribuidor/cobros/ajax/barcode/'.$rowB['strBarcode'].'.png';
				}else{
					if(image_exists('http://ticketfacil.ec/ticket2/subpages/Compras/barcode/'.$rowB['strBarcode'].'.png')==1){
						$ruta = 'http://ticketfacil.ec/ticket2/subpages/Compras/barcode/'.$rowB['strBarcode'].'.png';
					}else{
						if(image_exists('http://ticketfacil.ec/ticket2/spadmin/barcoded/'.$rowB['strBarcode'].'.png')==1){
							$ruta = 'http://ticketfacil.ec/ticket2/spadmin/barcoded/'.$rowB['strBarcode'].'.png';
						}
					}
				}
			}
		}
			$urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$rowB['strBarcode'].'';
			$imgbar = 'barcode3/'.$rowB['strBarcode'].'.png';
			file_put_contents($imgbar, file_get_contents($urlbar));
			// $timeRightNow = time();
			// $url = str_replace(' ','',$qr);
			// $img = 'qrd/'.$timeRightNow.'.png';
			// file_put_contents($img, file_get_contents($url));
			$content = '
			<page>
				<div style="padding-bottom:30px;border:1px solid #ccc;border-radius:10px;background-color:#ccc;width:100%;heigth:100%;">
					<br/><br/>
					<div style="padding-left:10px;padding-rigth:10px;background-color:#fff;color:#000;width:position:relative;margin-left:150px;">
						
						<p align="center">Estimado <span style="color:blue;text-transform:uppercase;">'.$rowCl['strNombresC'].'</span> </p>
						<font size = "5"><p align="center">Adjuntamos su boleto para el concierto de :<br/><strong>'.$rowTC['strEvento'].'</strong></p></font>
						<p align="center">El mismo que se efctuara en:</p>
						
						<font size = "5"><p align="center"><strong>'.$rowTC['strLugar'].'</strong></p></font>	
						
						<p align="center">El dia: '.$rowTC['dateFecha'].' a las: '.$rowTC['timeHora'].'</p>
						
						<p align="center">En la localidad: <strong>'.$row2['strDescripcionL'].'</strong> costo: <strong>'.$row2['doublePrecioL'].'</strong></p>
						
						<p align="center"><strong>Tu asiento es : '.$rowDB['asientos'].'</strong></p>
						
						<p align="center"><img alt="" src="'.$qr.'" /></p>
						
						<p align="center">Disfrute el evento</p>
						
						<p align="center">
							<span style="font-size:12px;">Nota: El ingreso al evento se permitirá solo con la cedula y el boleto impreso</span>
						</p>
						
						
						<p align="center">
							<img alt="" src="http://ticketfacil.ec/ticket2/subpages/Compras/barcode3/'.$rowB['strBarcode'].'.png" /><br/>
							<span style="font-size:10px;">'.$rowB['strBarcode'].'</span>
						</p>
					</div>
				</div>
			</page>';
			 echo $content;
			sexit;
			$content2 = '
				<page>
					<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;">
						
						<tr>
							<td style="text-align:center;">
								<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" />
							</td>
						</tr>
						
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
							<p align="center">Estimado <span style="color:blue;text-transform:uppercase;">'.$rowCl['strNombresC'].'</span> </p>
							</td>
						</tr>
						
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								<span style="font-size:20px;"><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU TICKET ($'.$row2['doublePrecioL'].') CON EXITO</strong></span>
							</td>
						</tr>
						
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								 Le recordamos que debe imprimir su TICKET adjunto a este email y portar el documento de identidad del due&ntilde;o del boleto para poder ingresar al evento
							</td>
						</tr>
						
						
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								<br>
								Gracias por Preferirnos...!
								<br>
								<br>
								<strong>TICKETFACIL <I>La mejor experiencia de compra En Línea</I></strong>
							</td>
						</tr>
					</table>
				</page>';
				
				// echo $content."<br/><br/><br/><br/><br/>";
				// echo $content2;
				
			// try{
				// $html2pdf = new HTML2PDF('P', 'Letter', 'en');    
				// //$html2pdf->setModeDebug();
				// $html2pdf->setDefaultFont('Arial');
				// $html2pdf->writeHTML($content);
				// $html2pdf->Output('pdf/'.$rowB['strBarcode'].'.pdf','F');
			// }catch(HTML2PDF_exception $e){
				// echo 'my errors '.$e;
				// exit;
			// }
			// exit;
			$ownerEmail = 'jonathan@practisis.com';
			$subject = 'Boleto para '.$row2['strDescripcionL'].'  '.$rowDB['asientos'].'';
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
			$mail->AddAddress($rowCl['strMailC'],$rowCl['strNombresC']);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content);
			//$mail->AddAttachment('pdf/'.$rowB['strBarcode'].'.pdf'); // attachment
		
			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else{
				
				echo '<p align="center">Estimado <span style="color:blue;text-transform:uppercase;">'.$rowCl['strNombresC'].'</span> </p>, se ha enviado un email con su boleto!!!';
			}
			//unlink('pdf/'.$timeRightNow.'.pdf');
			//$counter++;
			//
	}
?>