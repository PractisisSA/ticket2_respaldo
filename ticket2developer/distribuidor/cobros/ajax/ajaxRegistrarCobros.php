<?php
	session_start();
	date_default_timezone_set('America/Guayaquil');
	include('../../../controlusuarios/seguridadDis.php');
	require_once('../../../classes/private.db.php');
	include('../../../html2pdf/html2pdf/html2pdf.class.php');
	require_once '../../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../../PHPM/PHPM/class.smtp.php';
	include '../../../conexion.php';
	
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	
	$gbd = new DBConn();
	
	$hoy = date("Y-m-d");
	$fechatime = date("Y-m-d H:i:s");
	
	$codigocompra = $_REQUEST['codigo'];
	
	$identificador = $_REQUEST['identificador'];//identificador 1 = preventa o precio normal, identificador 2 = reservacion.
	
	$totalpago = $_REQUEST['total'];
	
	$formapago = $_REQUEST['formapago'];

    $tipo_tarjeta = $_REQUEST['tipo_tarjeta'];
    if($tipo_tarjeta == 0){
        $tipo_tarjeta2 = 'Efectivo';
    }else if($tipo_tarjeta == 1){
        $tipo_tarjeta2 = 'Visa';
    }else if($tipo_tarjeta == 2){
        $tipo_tarjeta2 = 'Dinners';
    }else if($tipo_tarjeta == 3){
        $tipo_tarjeta2 = 'Mastercard';
    }else if($tipo_tarjeta == 4){
        $tipo_tarjeta2 = 'Discover';
    }else if($tipo_tarjeta == 5){
        $tipo_tarjeta2 = 'Amex';
    }

    if($formapago == 'Tarjeta de Credito'){
		$valorPago = 2;
		$formaPago = 1;
		//$tipo_tarjeta2 = 'Visa';
	}elseif($formapago == 'Efectivo'){
		$valorPago = 1;
		$formaPago = 0;
		//$tipo_tarjeta2 = 'Efectivo';
	}
	$quien_vendio_boleto = 0;
	if($_SESSION['tipo_emp'] == 1){
		$quien_vendio_boleto = 3;
	}elseif($_SESSION['tipo_emp'] == 2){
		$quien_vendio_boleto = 2;
	}
	//if($identificador == 1){
		
		$update = "UPDATE pventa SET estadoPV = ?, estadopagoPV = ? WHERE idFactura = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array('Revisado','ok',$codigocompra));
		
		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		
		$updateFac = "UPDATE factura SET estadoPV = ?, estadopagoPV = ? , fecha = ? , estado = ? , id_dist = ? , cobrado = ? WHERE id = ?";
		$updFac = $gbd -> prepare($updateFac);
		$updFac -> execute(array($formaPago,'0',$fecha , $hora , $_SESSION['iduser'],1,$codigocompra));
		
		
		
		$sql = 'SELECT strNombresC, strMailC, strDocumentoC, strEnvioC, costoenvioC, strDireccionC, strEvento, strLugar, intTelefonoMovC ,
				timeHora, dateFecha, dircanjeC, horariocanjeC, fechainiciocanjeC, fechafinalcanjeC, estadopagoPV , seccion , p.valor_f , p.id_desc
				FROM pventa p 
				JOIN Cliente c 
				ON p.clientePV = c.idCliente 
				JOIN Concierto co 
				ON p.conciertoPV = co.idConcierto 
				WHERE idFactura = "'.$codigocompra.'"
				';
	//	echo $sql;
		//exit;
		$stmt = $gbd -> prepare($sql);
		$stmt -> execute();
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);
		
		$sql2 = "SELECT strDescripcionL, doublePrecioL, doublePrecioPreventa, filaPV, columnaPV, numboletosPV, 
				localidadPV, conciertoPV, clientePV , seccion , p.valor_f , p.id_desc
				FROM pventa p 
				JOIN Localidad l 
				ON p.localidadPV = l.idLocalidad 
				WHERE idFactura = ?";
		$stmt2 = $gbd -> prepare($sql2);
		$stmt2 -> execute(array($codigocompra));
		$numboletos = $stmt2 -> rowCount();
		
		
			
		
		$counter = 1;
		$losBoletos='';
		
		
		$sqlC = 'select conciertoPV from pventa where idFactura = "'.$codigocompra.'" ';
			//echo $sqlC;
		$resC = mysql_query($sqlC) or die (mysql_error());
		$rowC = mysql_fetch_array($resC);
		
		
		$sqlTC = 'select * from Concierto where idConcierto = "'.$rowC['conciertoPV'].'" ';
		echo $sqlTC;
		$resTC = mysql_query($sqlTC) or die (mysql_error());
		$rowTC = mysql_fetch_array($resTC);
		
		
		
		while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
			$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
			$rand = md5($s.time()).mt_rand(1,10);
			$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'';
			//$code = rand(1,9999999999).time();
			$sqlCod_bar = 'SELECT * FROM `codigo_barras` WHERE id_con = "'.$row2['conciertoPV'].'" and utilizado = 0 order by id ASc ';
			$resCod_bar = mysql_query($sqlCod_bar) or die (mysql_error());
			$rowCod_bar = mysql_fetch_array($resCod_bar);
			$code = $rowCod_bar['codigo'];
			echo $code."  este es el codigo q se insertara .<br><br>";
			
			$_SESSION['barcode'] = $code;
			
			$urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$code.'';
			$imgbar = 'barcode/'.$code.'.png';
			file_put_contents($imgbar, file_get_contents($urlbar));
			
			// $sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$row2['conciertoPV'].'"  order by idBoleto DESC limit 1';
			// $resB = mysql_query($sqlB) or die (mysql_error());
			// $rowB = mysql_fetch_array($resB);
			
			// if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
				// $numeroSerie = 1;
			// }else{
				// $numeroSerie = ($rowB['serieB'] + 1);
			// }
			$sqlControl = 'select identComprador from Boleto where idCon = "'.$row2['conciertoPV'].'" order by idBoleto Desc limit 1';
			$resControl = mysql_query($sqlControl) or die (mysql_error());
			$rowControl = mysql_fetch_array($resControl);
			
			if($rowControl['identComprador'] == $rowTC['tiene_permisos']){
				$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$row2['conciertoPV'].'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
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
					$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$row2['conciertoPV'].'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
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
			$sqlB1 = 'select max(CAST(serie_localidad AS INTEGER)) as serieB from Boleto where idCon = "'.$row2['conciertoPV'].'"  and idLocB = "'.$row2['localidadPV'].'" order by idBoleto DESC limit 1';
			$resB1 = mysql_query($sqlB1) or die (mysql_error());
			$rowB1 = mysql_fetch_array($resB1);
			
			if($rowB1['serieB'] == null || $rowB1['serieB'] == '' ){
				$numeroSerie_localidad = 1;
			}else{
				$numeroSerie_localidad = ($rowB1['serieB'] + 1);
			}
			
			$sqlAut = 'select * from autorizaciones where idAutorizacion = "'.$rowTC['tiene_permisos'].'" order by idAutorizacion ASC limit 1';
				//echo $sqlAut;
			$resAut = mysql_query($sqlAut) or die (mysql_error());
			if(mysql_num_rows($resAut)>0){
				$rowAut = mysql_fetch_array($resAut);
				$numBoletoVendido = '<b>BOLETO:</b> ('.$rowAut['codestablecimientoAHIS'].'-'.$rowAut['serieemisionA'].'-0000'.$numeroSerie.') ';
			}else{
				$numBoletoVendido = '<b>BOLETO:</b> (0000'.$numeroSerie.') ';
			}
			// si tiene_permisos == 0 el cliente no podra ingresar al concierto sin imprimir su boleto real
			echo $rowTC['tiene_permisos']."autorizaciones <br/>";
			if($rowTC['tiene_permisos'] == 0){
				$accesoCon = 1;
			}else{
				$accesoCon = 2;
			}
			
			$hoy = date("Y-m-d");
			$dateFechaPreventa = $rowTC['dateFechaPreventa'];
			if($hoy <= $dateFechaPreventa){
				$espreventa = 1;
			}else{
				$espreventa = 0;
			}
			
			
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$costoboleto = 0;
			
			$sql3 = "SELECT descompra FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
			$stmt3 = $gbd -> prepare($sql3);
			$stmt3 -> execute(array($row2['filaPV'],$row2['columnaPV'],$row2['localidadPV'],$row2['conciertoPV']));
			$row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC);
			$tipocompra = $row3['descompra'];
			if($tipocompra == 1){
				$costoboleto = $row2['doublePrecioPreventa'];
			}else if($tipocompra == 2){
				$costoboleto = $row2['doublePrecioL'];
			}else if($tipocompra == 3){
				$costoboleto = $row2['doublePrecioL'];
			}
			
			$sqlF = 'select * from factura where id = "'.$codigocompra.'" ';
			$resF = mysql_query($sqlF) or die (mysql_error());
			$rowF = mysql_fetch_array($resF);
			
			$ndepo = $rowF['ndepo'];
			$ndepoExp = explode("|",$ndepo);
			$id_desc = $ndepoExp[1];
			$valDesc = $ndepoExp[2];
			if($id_desc == 0){
				$tercera = 0;
			}else{
				$tercera = 1;
			}
			$query1 = "INSERT INTO Boleto VALUES (?, ?, ?, ?, ?, ?, ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)";
			$result = $gbd -> prepare($query1);//$code ese estava antes
			$result -> execute(array('NULL',$row2['seccion'],$code,$row2['clientePV'],$row2['conciertoPV'],$row2['localidadPV'],$valorPago,$quien_vendio_boleto, $tercera , $espreventa , 1 , '' , $row['strDocumentoC'],'A','S' , $numeroSerie,$numeroSerie_localidad,$rowTC['tiene_permisos'], $_SESSION['iduser'] , $row2['id_desc'] , $row2['valor_f'], $fecha , $hora , $formaPago , 0 ));
			$idboleto = $gbd -> lastInsertId();
			
			$losBoletos .=$idboleto."|";
			
			
			
			$hoy = date("Y-m-d");
			$ident1 = $_REQUEST['ident1'];
			if($ident1 == 1){
				$sqlDo = '	insert into domicilio 	(	
														rowD , 
														colD , 
														statusD , 
														localD , 
														conciertoD , 
														clienteD , 
														boletoD , 
														pagoporD , 
														domicilioHISD , 
														nombreHISD , 
														documentoHISD
													) 
											values (
														"'.$row2['filaPV'].'" , 
														"'.$row2['columnaPV'].'",  
														"'.$hoy.'" , 
														"'.$row2['localidadPV'].'" , 
														"'.$row2['conciertoPV'].'" , 
														"'.$row2['clientePV'].'" , 
														"'.$idboleto.'" , 
														"cobro pventa" , 
														"'.$row['strDireccionC'].'" , 
														"'.$row['intTelefonoMovC'].'" , 
														"'.$codigocompra.'"
													)';
				$resDo = mysql_query($sqlDo) or die (mysql_error());
			}
			
			$sqlUC = 'update compras_membresias set id_boleto = "'.$_SESSION['idDis'].'" where id_pv_dep = "'.$codigocompra.'" ';
			$resUC = mysql_query($sqlUC) or die (mysql_error());
			
			// $updComPre = "UPDATE compras_preventa SET id_bol = ? WHERE cod_com = ?";
			// $updCoP = $gbd -> prepare($updComPre);
			// $updCoP -> execute(array($idboleto,$codigocompra));
			
		
			
			$update2 = "UPDATE ocupadas SET status = ? WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
			$upd2 = $gbd -> prepare($update2);
			$upd2 -> execute(array(1,$row2['filaPV'],$row2['columnaPV'],$row2['localidadPV'],$row2['conciertoPV']));
			
			// if($row['strEnvioC'] == 'Domicilio'){
			// $insert3 = "INSERT INTO domicilio VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			// $ins3 = $gbd -> prepare($insert3);
			// $ins3 -> execute(array('NULL',$row2['filaPV'],$row2['columnaPV'],1,$row2['localidadPV'],$row2['conciertoPV'],$row2['clientePV'],0,$formapago,'N/A','N/A','N/A','A'));
			// }
			
			
			if($rowTC['tipo_conc'] == 1){
				$trans = "INSERT INTO transaccion_distribuidor VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
				$stmttrans = $gbd -> prepare($trans);
				$stmttrans -> execute(array('NULL',$row2['clientePV'],$row2['conciertoPV'],$row2['localidadPV'],$_SESSION['idDis'],2,$idboleto,$formapago,$row2['valor_f'],"",""));
			}
			$timeRightNow = time();
			$url = str_replace(' ','',$qr);
			$img = 'qr/'.$timeRightNow.'.png';
			file_put_contents($img, file_get_contents($url));
			
			
			$asientosVendidos = 'Fila-'.$row2['filaPV'].'_Silla-'.$row2['columnaPV'].'';
			
			$detalleBoleto = 'INSERT INTO detalle_boleto (idBoleto, localidad, asientos, precio) VALUES ("'.$idboleto.'" , "'.$row2['strDescripcionL'].'" , "'.$asientosVendidos.'" , "'.$row2['valor_f'].'")';
			$res = mysql_query($detalleBoleto) or die (mysql_error());
			
			$factura_boleto = 'INSERT INTO `factura_boleto` (`id`, `id_fac`, `id_bol`) VALUES (NULL, "'.$codigocompra.'", "'.$idboleto.'");';
			$resfacbol = mysql_query($factura_boleto) or die (mysql_error());
			
			
			$sqlUpCodBar = 'update codigo_barras set utilizado = "1" where codigo = "'.$code.'" ';
			$resUpCodBar = mysql_query($sqlUpCodBar);
			
			
			$sqlDT = '	INSERT INTO `detalle_tarjetas` (`idcon`, `idloc`, `idbol`, `idcli`, `fecha`, `hora`, `tipo`, `valor`, `id_fact`) 
							VALUES ("'.$row2['conciertoPV'].'", "'.$row2['localidadPV'].'", "'.$idboleto.'", "'.$row2['clientePV'].'", "'.$fecha.'", "'.$hora.'", "cobro PV | '.$tipo_tarjeta2.'" , "'.$row2['valor_f'].'" , "'.$codigocompra.'")';
		    // echo $sqlDT."<br><br>";
			$resDT = mysql_query($sqlDT) or die (mysql_error());
			
			 
		}	
			
			
			//echo $rowTC['tipo_conc']."hola";
			
			if($rowTC['tipo_conc'] == 2){
				$content = '
				<page>
					<div style="padding-bottom:30px;border:1px solid #ccc;border-radius:10px;background-color:#282B2D;width:100%;heigth:100%;background-image:url(http://ticketfacil.ec/ticket2/spadmin/'.$rowTC['strImagen'].');background-position: 50 50;">
						<br>
						<br>
						<div style="padding-left:10px;padding-rigth:10px;background-color:#fff;color:#000;width:position:relative;margin-left:150px;">
							<p align="center">Estimado cliente adjuntamos su boleto para:</p>
							<br>
							<font size = "5"><p align="center"><strong>'.$row['strEvento'].'</strong></p></font>
							<br>
							<p align="center">El mismo que se efctuara en:</p>
							<br>
							<font size = "5"><p align="center"><strong>'.$row['strLugar'].'</strong></p></font>	
							<br>
							<p align="center">El dia: '.$row['dateFecha'].' a las: '.$row['timeHora'].'</p>
							<br>
							<p align="center">En la localidad: <strong>'.$row2['strDescripcionL'].'</strong> costo: <strong>'.$valDesc.'</strong></p>
							<br>
							<p align="center"><strong>Tu asiento es : Fila-'.$row2['filaPV'].'_Asiento-'.$row2['columnaPV'].'</strong></p>
							<br>
							<p align="center"><img alt="" src="'.$img.'" /></p>
							<br>
							<br>
							<p style="text-align:center;">'.$numBoletoVendido.'</p>
							<p align="center">Disfrute el evento</p>
							<br>
							<p align="center"><strong>Imprimir el boleto para el ingreso al evento</strong></p>
							<br>
							<p align="center">Nota: El ingreso al evento se permitide solo con la cedula y el boleto impreso</p>
							<br>
							<br>
							<p align="center"><img alt="" src="http://www.lcodigo.com/ticket/distribuidor/cobros/ajax/codigo_barras.php?barcode='.$code.'" /></p>
							<p align="center">'.$code.'</p>
							<br>
						</div>
					</div>
				</page>';
				$codigo = $_SESSION['barcode'];
				$urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$codigo.'';
				$imgbar = 'barcode/'.$codigo.'.png';
				file_put_contents($imgbar, file_get_contents($urlbar));
				
				$content2 = '
					<page>
						<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;border:2px solid #ccc;">
							<tr>
								<td style="text-align:center;">
									<a href="http://www.lcodigo.com/ticket"><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" /></a>
								</td>
							</tr>
							
							<tr>
								<td style="text-align:center;">
									<br>
									<br>
									<h1>Estimado(a) <strong>'.$row['strNombresC'].'</strong></h1>
								</td>
							</tr>
							
							<tr>
								<td style="text-align:center;">
									<br>
									<br>
									<h1><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU(S) TICKET(S) CON EXITO</strong></h1>
								</td>
							</tr>
							<tr>
								<td style="text-align:center;">
									Su(s) ticket(s) original(es) unicos para el ingreso , ya han sido entregados.
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
									<strong>TICKETFACIL <I>La mejor experiencia de compra En L&iacute;nea</I></strong>
								</td>
							</tr>
						</table>
					</page>';
				// try{
					// $html2pdf = new HTML2PDF('P', 'A4', 'en');    
					// //$html2pdf->setModeDebug();
					// $html2pdf->setDefaultFont('Arial');
					// $html2pdf->writeHTML($content);
					// $html2pdf->Output('pdf/'.$timeRightNow.'.pdf','F');
				// }catch(HTML2PDF_exception $e){
					// echo 'my errors '.$e;
					// exit;
				// }
				$ownerEmail = 'jonathan@practisis.com';
				$subject = 'Boleto para '.$row2['strDescripcionL'].' - Fila-'.$row2['filaPV'].'_Asiento-'.$row2['columnaPV'].'';
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
				$mail->AddAddress($row['strMailC'],$row['strNombresC']);
				$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
				$mailer->AddBCC("fabricio@practisis.com", "TICKETFACIL");
				$mailer->AddBCC("ventas@ticketfacil.ec", "TICKETFACIL");
				$mail->FromName = 'TICKETFACIL';
				$mail->Subject = $subject;
				$mail->MsgHTML($content2);
				//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
			
				if(!$mail->Send()){
					echo "Mailer Error: " . $mail->ErrorInfo;
				}
				else{
					
					echo 'ok'.$row['strMailC'];
				}
				//unlink('pdf/'.$timeRightNow.'.pdf');
				// unlink('qr/'.$timeRightNow.'.png');
				$counter++;
				$_SESSION['losBoletos'] = $losBoletos;
				//echo $_SESSION['losBoletos'];
			}else{
				echo $_SESSION['tipocadena']."<br><br>  ...aqui";
				if($_SESSION['tipocadena'] == 2){
					$sqlFac= 'select * from factura where id = "'.$codigocompra.'" ';
					$resFac = mysql_query($sqlFac) or die (mysql_error());
					$rowFac = mysql_fetch_array($resFac);
					$code = $rowFac['rand'];
				}
				$codigo = $code;
				$urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$codigo.'';
				$imgbar = 'barcode/'.$codigo.'.png';
				file_put_contents($imgbar, file_get_contents($urlbar));
				
				$content2 = '
					<page>
						<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;border:2px solid #ccc;">
							<tr>
								<td style="text-align:center;">
									<a href="http://www.lcodigo.com/ticket"><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" /></a>
								</td>
							</tr>
							
							<tr>
								<td style="text-align:center;">
									<br>
									<br>
									<h1>Estimado(a) <strong>'.$row['strNombresC'].'</strong></h1>
								</td>
							</tr>
							
							<tr>
								<td style="text-align:center;">
									<br>
									<br>
									<h1><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU(S) TICKET(S) CON EXITO</strong></h1>
								</td>
							</tr>
							<tr>
								<td style="text-align:center;">
									Su(s) ticket(s) original(es) unicos para el ingreso , ya han sido entregados.
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
									<strong>TICKETFACIL <I>La mejor experiencia de compra En L&iacute;nea</I></strong>
								</td>
							</tr>
						</table>
					</page>';
				// echo $content2;
				// try{
					// $html2pdf = new HTML2PDF('P', 'A4', 'en');    
					// //$html2pdf->setModeDebug();
					// $html2pdf->setDefaultFont('Arial');
					// $html2pdf->writeHTML($content);
					// $html2pdf->Output('pdf/'.$timeRightNow.'.pdf','F');
				// }catch(HTML2PDF_exception $e){
					// echo 'my errors '.$e;
					// exit;
				// }
				$ownerEmail = 'jonathan@practisis.com';
				$subject = 'Boleto para '.$row2['strDescripcionL'].' - Fila-'.$row2['filaPV'].'_Asiento-'.$row2['columnaPV'].'';
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
				$mail->AddAddress($row['strMailC'],$row['strNombresC']);
				$mail->AddBCC("fabriciocarrion18@outlook.com", "copia cobros");
				$mail->AddBCC("fabricio@practisis.com", "copia cobros");
				$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
				$mail->FromName = 'TICKETFACIL';
				$mail->Subject = $subject;
				$mail->MsgHTML($content2);
				//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
			
				if(!$mail->Send()){
					echo "Mailer Error: " . $mail->ErrorInfo;
				}
				else{
					
					echo 'ok'.$row['strMailC'];
				}
				//unlink('pdf/'.$timeRightNow.'.pdf');
				// unlink('qr/'.$timeRightNow.'.png');
				$counter++;
				$_SESSION['losBoletos'] = $losBoletos;
				//echo $_SESSION['losBoletos'];
			}
		//}
	//}
	
?>