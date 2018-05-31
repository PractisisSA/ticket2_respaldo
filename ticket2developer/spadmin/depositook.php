<?php
	// include("../controlusuarios/seguridadSA.php");
	require('../Conexion/conexion.php');
	include '../conexion.php';
	
	$num_dep = $_REQUEST['num_dep'];
	$id = $_REQUEST['id'];
	$selectId = 'SELECT strEvento, dateFecha, timeHora, strDescripcionL, strLugar, idCliente, strDocumentoC , idConcierto, intNumBoleto, idLocalidad, strDocumentoC , 
				idDeposito, strMailC, strNombresC, doublePrecioL , dircanjeC , horariocanjeC , fechainiciocanjeC , fechafinalcanjeC , 
				tiene_permisos , intCodigoRand , dateFechaPreventa , seccion , intColD , intFilaD , pventa , dirPago , Deposito.valor
				FROM Deposito 
				JOIN Concierto ON Deposito.idCon = Concierto.idconcierto 
				JOIN Localidad ON Deposito.idLoc = Localidad.idLocalidad 
				JOIN Cliente ON Deposito.idCli = Cliente.idCliente 
				join factura 
				on Deposito.idFactura = factura.id
				WHERE factura.id = "'.$id.'" ';
	 // echo $selectId."<br><br>";
	// exit;
	
	$updFac = 'UPDATE factura SET estadoPV = "Revisado" , estadopagoPV =  "pagado" WHERE id = "'.$id.'" ';
	$resFac = mysql_query($updFac) or die(mysql_error());
	
	$resSelectId = mysql_query($selectId) or die (mysql_error());
	
	$num_resultado = mysql_num_rows($resSelectId);
	$counter = 1;
	// ini_set('display_startup_errors',1);
	// ini_set('display_errors',1);
	// error_reporting(-1);
	date_default_timezone_set('America/Lima');
	include('../html2pdf/html2pdf/html2pdf.class.php');
	require_once '../PHPM/PHPM/class.phpmailer.php';
	require_once '../PHPM/PHPM/class.smtp.php';
	$quien_vendio_boleto = 1;
	$valorPago = 1;
	while($rowSelectId = mysql_fetch_array($resSelectId)){
	// for($i = 0; $i < $rowSelectId['intNumBoleto']; $i++){
			
			$tiene_permisos = $rowSelectId['tiene_permisos'];
			
			$random = mt_rand();
			$barras = $random;
			$dird = 'codigoBarrasd_img.php?numero=';
			$imagend = $dird.$barras;
			$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
			$rand = md5($s.time()).mt_rand(1,10);
			$est = "A";
			$change_estado = 'Revisado';
			$useractual = $_SESSION['useractual'];
			$mailuser = $_SESSION['mailuser'];
			$ceduser = $_SESSION['username'];
			$desA= 'Se realizo la revision de este deposito';
			$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'';
			
			
			
			
			
			// $sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$rowD['idCon'].'" order by idBoleto DESC limit 1';
			// $resB = mysql_query($sqlB) or die (mysql_error());
			// $rowB = mysql_fetch_array($resB);
			// if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
				// $numeroSerie = 1;
			// }else{
				// $numeroSerie = ($rowB['serieB'] + 1);
			// }
			
			
			// $sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$rowSelectId['idConcierto'].'"  order by idBoleto DESC limit 1';
			// //echo $sqlB."<br/><br>";
			// $resB = mysql_query($sqlB) or die (mysql_error());
			// $rowB = mysql_fetch_array($resB);
			
			// if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
				// $numeroSerie = 1;
			// }else{
				// $numeroSerie = ($rowB['serieB'] + 1);
			// }
			
			
			$sqlControl = 'select identComprador from Boleto where idCon = "'.$rowSelectId['idConcierto'].'" order by idBoleto Desc limit 1';
			$resControl = mysql_query($sqlControl) or die (mysql_error());
			$rowControl = mysql_fetch_array($resControl);
			
			if($rowControl['identComprador'] == $tiene_permisos){
				$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$rowSelectId['idConcierto'].'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
				$resB = mysql_query($sqlB) or die (mysql_error());
				$rowB = mysql_fetch_array($resB);
				
				if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
					$numeroSerie = 1;
				}else{
					$numeroSerie = ($rowB['serieB'] + 1);
				}
				
			}else{
				
				$sqlControl1 = 'select count(1) as cuantos , identComprador from Boleto where identComprador = "'.$tiene_permisos.'" order by idBoleto Desc limit 1';
				$resControl1 = mysql_query($sqlControl1) or die (mysql_error());
				$rowControl1 = mysql_fetch_array($resControl1);
				if($rowControl1['cuantos'] != 0 ){
					$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$rowSelectId['idConcierto'].'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
					$resB = mysql_query($sqlB) or die (mysql_error());
					$rowB = mysql_fetch_array($resB);
					
					if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
						$numeroSerie = 1;
					}else{
						$numeroSerie = ($rowB['serieB'] + 1);
					}
					
					
					
					
				}else{					
					$numeroSerie = 1;
					// $numeroSerie_localidad = 1;
				}
				
			}
			
			$sqlB1 = 'select max(CAST(serie_localidad AS INTEGER)) as serieB from Boleto where idCon = "'.$rowSelectId['idConcierto'].'"  and idLocB = "'.$rowSelectId['idLocalidad'].'" order by idBoleto DESC limit 1';
			//echo $sqlB1."<br/><br>";
			$resB1 = mysql_query($sqlB1) or die (mysql_error());
			$rowB1 = mysql_fetch_array($resB1);
			
			if($rowB1['serieB'] == null || $rowB1['serieB'] == '' ){
				$numeroSerie_localidad = 1;
			}else{
				$numeroSerie_localidad = ($rowB1['serieB'] + 1);
			}
			
			//echo $sqlB;
			
			//echo $rowSelectId['tiene_permisos']."autorizacion <br>";
			if($rowSelectId['tiene_permisos'] == 0){
				$validaIngreso = 1;
			}else{
				$validaIngreso = 2;
			}
			
			$hoy = date("Y-m-d");
			$dateFechaPreventa = $rowSelectId['dateFechaPreventa'];
			//echo $hoy."<=".$dateFechaPreventa;
			if($hoy <= $dateFechaPreventa){
				$espreventa = 1;
			}else{
				$espreventa = 0;
			}
			
			$sqlCod_bar = 'SELECT * FROM `codigo_barras` WHERE id_con = "'.$rowSelectId['idConcierto'].'" and id_loc = "'.$rowSelectId['idLocalidad'].'" and utilizado = 0 order by id ASc ';
			
			// echo $sqlCod_bar."<br><br>";
			$resCod_bar = mysql_query($sqlCod_bar) or die (mysql_error());
			$rowCod_bar = mysql_fetch_array($resCod_bar);
			$code = $rowCod_bar['codigo'];
			
			// echo $code."  : este se insertara : <br><br>";
			
			
			$sqlL = 'select * from Localidad where idLocalidad = "'.$rowSelectId['idLocalidad'].'" ';
			$resL = mysql_query($sqlL) or die (mysql_error());
			$rowL = mysql_fetch_array($resL);
			
			
			$aplica_descuento_socio = 0;
			$sqlSd = 'SELECT count(id) as cuantos FROM `socio_descuento` where cedula_cli = "'.$rowSelectId['strDocumentoC'].'" ';
			$resSd = mysql_query($sqlSd) or die (mysql_error());
			$rowSd = mysql_fetch_array($resSd);
			if($rowSd['cuantos'] == 0){
				$aplica_descuento_socio = 0;
			}else{
				$aplica_descuento_socio = 1;
			}
			
			
			$strDescripcionL = $rowL['strDescripcionL'];
			if($aplica_descuento_socio == 0){
				$doublePrecioL = $rowL['doublePrecioL'];
			}else{
				$sqlD = 'SELECT * FROM `descuentos` WHERE `idloc` = "'.$rowSelectId['idLocalidad'].'" AND `nom` LIKE "%socio%" ORDER BY `idloc` ASC ';
				// echo $sqlD."<br>";
				$resD = mysql_query($sqlD) or die (mysql_error());
				$rowD = mysql_fetch_array($resD);
				$doublePrecioL = $rowD['val'];
			}
			$fecha = date("Y-m-d"); 
			$hora = date("H:i:s"); 
			//$insertDep = "	INSERT INTO Boleto VALUES (NULL, '$rand', '$random', '".$rowSelectId['idCliente']."', '".$rowSelectId['idConcierto']."', '".$rowSelectId['idLocalidad']."', '".$valorPago."' , '".$quien_vendio_boleto."' , '".$rowSelectId['strDocumentoC']."' ,'$est','$numeroSerie','$validaIngreso')";
			$insertDep    = '  INSERT INTO Boleto VALUES (	NULL,
															"'.$rowSelectId['seccion'].'",
															"'.$code.'",
															'.$rowSelectId['idCliente'].',
															'.$rowSelectId['idConcierto'].',
															'.$rowSelectId['idLocalidad'].',
															"'.$valorPago.'",
															"'.$quien_vendio_boleto.'", 
															"0", 
															"'.$espreventa.'", 
															"0" , 
															"",
															"'.$rowSelectId['strDocumentoC'].'"
															,"A",
															"S",
															"'.$numeroSerie.'", 
															"'.$numeroSerie_localidad.'", 
															"'.$tiene_permisos.'" , 
															"0" , 
															"0" , 
															"'.$rowSelectId['valor'].'",
															"'.$fecha.'",
															"'.$hora.'",
															"0",
															"0"
														)
							';
			
			//echo $insertDep;
			$resInsertDep = mysql_query($insertDep) or die (mysql_error());
			$idBoleto = mysql_insert_id();
			
			
			
			$sqlUC = 'update compras_membresias set id_boleto = "deposito" where id_pv_dep = "'.$id.'" ';
			$resUC = mysql_query($sqlUC) or die (mysql_error());
			
			
			$sqlDT = '	INSERT INTO `detalle_tarjetas` (`idcon`, `idloc`, `idbol`, `idcli`, `fecha`, `hora`, `tipo`, `valor`, `id_fact`) 
							VALUES ("'.$rowSelectId['idConcierto'].'", "'.$rowSelectId['idLocalidad'].'", "'.$idBoleto.'", "'.$rowSelectId['idCliente'].'", "'.$fecha.'", "'.$hora.'", "venta PV | transefencia" , "'.$rowSelectId['valor'].'" , "'.$id.'")';
		    // echo $sqlDT."<br><br>";
			$resDT = mysql_query($sqlDT) or die (mysql_error());
			
			
			
			if($rowSelectId['pventa'] == 1){
				$hoy = date("Y-m-d");
				
				
				
				$sqlCl = 'select * from Cliente where idCliente = "'.$rowSelectId['idCliente'].'" ';
				$resCl = mysql_query($sqlCl) or die (mysql_error());
				$rowCl = mysql_fetch_array($resCl);
				
				$dir1 = $rowCl['strDireccionC'];
				$cel1 = $rowCl['intTelefonoMovC'];
				$tel1 = $rowCl['strTelefonoC'];
				
				
				
				$sqlDo = '	insert into domicilio (rowD , colD , statusD , localD , conciertoD , clienteD , boletoD , pagoporD , domicilioHISD , nombreHISD , documentoHISD) 
							values ("'.$rowSelectId['intFilaD'].'" , "'.$rowSelectId['intColD'].'",  "'.$hoy.'" , "'.$rowSelectId['idLocalidad'].'" , "'.$rowSelectId['idConcierto'].'" , "'.$rowSelectId['idCliente'].'" , "'.$idBoleto.'" , "transferencia" , "'.$dir1.'" , "'.$tel1.'" , "'.$id.'")';
				$resDo = mysql_query($sqlDo) or die (mysql_error());
				
				
			}else{
				$dir1 = '';
				$cel1 = '';
				$tel1 = '';
			}
			
			$intFilaD = $rowSelectId['intFilaD'];
			$intColD = $rowSelectId['intColD'];
			$idLoc = $rowSelectId['idLoc'];
			if($rowL['strCaracteristicaL'] == 'Asientos numerados'){
				$asientos = 'Fila-'.$intFilaD.' Columna-'.$intColD;
			}else{
				$asientos = 'Asientos no numerados';
			}
			
			
			
			$sqlDB = '	INSERT INTO `detalle_boleto` (`idBoleto`, `localidad`, `asientos`, `precio`, `estadoCompra`) 
						VALUES ("'.$idBoleto.'", "'.$strDescripcionL.'", "'.$asientos.'", "'.$rowSelectId['valor'].'" , "1")
					';
			
			//echo $sqlDB."<br><br>";
			
			$resDB = mysql_query($sqlDB) or die (mysql_error());
			
			
			
			$sqlUpCodBar = 'update codigo_barras set utilizado = "1" where codigo = "'.$code.'" ';
			
			//echo $sqlUpCodBar."<br><br>";
			
			$resUpCodBar = mysql_query($sqlUpCodBar);
			
			
			// $updComPre = 'UPDATE compras_preventa SET id_bol = "'.$idBoleto.'" WHERE cod_com = "'.$rowSelectId['intCodigoRand'].'"';
			// $resComPre = mysql_query($updComPre) or die (mysql_error());
			
			
			
			$updateDep = "UPDATE Deposito SET strEstadoD = '$change_estado' WHERE idDeposito = '".$rowSelectId['idDeposito']."'  ";
			$resUpdateDep = mysql_query($updateDep) or die (mysql_error());
			
			$urlbar = 'http://ticketfacil.ec/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$code.'';
			$imgbar = 'barcoded/'.$code.'.png';
			file_put_contents($imgbar, file_get_contents($urlbar));
			
			
			$content = '
		<page>
			
			<div style="border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;">
				<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:11px;">
					<tr>
						<td style="text-align:center;">
							<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="200px"/>
						</td>
					</tr>
					<tr>
						<td style="text-align:center; margin-bottom:-5px;">
							Estimado <strong>'.$rowSelectId['strNombresC'].'</strong> 
							<br/>Esto es un comprobante de (deposito o transferencia) :
						</td>
					</tr>
					<tr>
						<td align="left">
							Para el EVENTO :  <font size = "4"><p align="left"><strong>'.$rowSelectId['strEvento'].'</strong></p></font>
						</td>
					</tr>
					<tr>
						<td>
							<p align="left">El mismo que se efectuara en:</p>
							<font size = "4"><p align="left"><strong>'.$rowSelectId['strLugar'].'</strong></p></font>	
							<p align="left">El dia: '.$rowSelectId['dateFecha'].' a las: '.$rowSelectId['timeHora'].'</p>
							<p align="left">Boleto para la localidad:'.$rowSelectId['strDescripcionL'].'</p>
						</td>
					</tr>';
				if($rowSelectId['pventa'] != 1){//'.$rowSelectId['pventa'].'
$content .= '       <tr>
						<td align="left">
							'.$rowSelectId['dircanjeC'].'
						</td>
					</tr>';
				}
				elseif($rowSelectId['pventa'] == 1){
$content .= '       <tr>
						<td align="left">
							Sus tickets seran enviados a la siguente direccion : "'.$dir1.'"<br>
							mediante el sistema de envios de servientrega <br>
							Su numero de contacto ingresado es : "'.$tel1.'"<br>
							nosotros le notificaremos a su numero de celular : '.$cel1.' <br>
							cuando el envio se haya realizado.
						</td>
					</tr>';
				}
			if($rowSelectId['pventa'] != 1){
$content .= '		<tr>
						<td valign="middle" align="center">
							* Su código de compra es el siguiente:<br/>

							<img src="http://www.ticketfacil.ec/ticket2developer/spadmin/barcoded/'.$code.'.png" width="250px" alt ="codigo de barras : '.$code.'.png" /><br/>
							
							 <span style="color:#EC1867;"><strong>'.$code.'</strong></span>
						</tr>
					</tr>';
			}		
$content .= '		<tr>
						<td style="text-align:center;">
							<strong>Gracias por Preferirnos</strong>
							<br>
							<strong>TICKETFACIL <I>"La mejor experiencia de compra En Línea"</I></strong>
						</td>
					</tr>
				</table>
			</page>';
			//echo $rowSelectId['strMailC']."<br>";
			// echo $content; 
			// exit;
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
			$ownerEmail = 'info@ticketfacil.ec';
			$subject = 'Boleto para ('.$rowSelectId['strDescripcionL'].')';
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
			$mail->AddReplyTo('fabricio@practisis.com','TICKETFACIL');
			$mail->From = $ownerEmail;
			$mail->AddAddress($rowSelectId['strMailC'],$rowSelectId['strNombresC']);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content);
			//$mail->AddAttachment('pdfd/'.$timeRightNow.'.pdf'); // attachment
			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else{
				
			}
			$counter++;
	// }
		
	}
	
	
	// $sqlD = 'select * from Deposito WHERE idFactura = "'.$id.'" ';
	// $resD = mysql_query($sqlD) or die (mysql_error());
	
	// // echo $sqlD."<br/>";
	
	// while($rowD = mysql_fetch_array($resD)){
		
		
		
		
	// }
	echo 'Deposito Canjeado con Éxito';
	// echo '<script>alert("deposito canjeado con exito")</script>';
	// header('Location:http://ticketfacil.ec/ticket2/?modulo=Rdepositos');
?>