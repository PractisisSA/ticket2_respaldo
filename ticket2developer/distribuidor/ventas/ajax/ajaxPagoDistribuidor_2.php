<?php 
	ini_set('memory_limit', '500M');
	session_start();
	$quien_vendio_boleto = 0;
	include '../../../conexion.php';
	
	if($_SESSION['tipo_emp'] == 1){
		$quien_vendio_boleto = 3;
	}elseif($_SESSION['tipo_emp'] == 2){
		$quien_vendio_boleto = 2;
	}
	
	if(isset($_SESSION['id_area_mapa'])){
		$seccion = $_SESSION['id_area_mapa'];
	}else{
		$seccion = 1;
	}
	
	$descuentos = $_REQUEST['descuentos'];
	$nomDesc = $_REQUEST['nomDesc'];
	$id_desc = $_REQUEST['id_desc'];
	$HoraActual = date("H:i:s");   
	date_default_timezone_set('America/Guayaquil');
	include('../../../controlusuarios/seguridadDis.php');
	require_once('../../../classes/private.db.php');
	include('../../../html2pdf/html2pdf/html2pdf.class.php');
	require_once '../../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../../PHPM/PHPM/class.smtp.php';
	// require_once 'ex.php';
	$timeRightNow = time();
	// ini_set('display_startup_errors',1);
	// ini_set('display_errors',1);
	// error_reporting(-1);
	
	$gbd = new DBConn();
	
	// print_r($_REQUEST);
	$hoy = date("Y-m-d");
	$fechatime = date("Y-m-d H:i:s");
	$clienteokFa = $_REQUEST['clienteok'];
	// echo $clienteokFa;
	// exit;Tarjeta de Credito
	
	
	// $recibeCedula = $_REQUEST['recibeCedula'];
	// $nombre = $_REQUEST['nombres'];
	// $cedula = $_REQUEST['documento'];
	$email = $_REQUEST['mail'];
	$movil = $_REQUEST['movil'];
	$dir = $_REQUEST['dir'];
	$pass = md5($cedula);
	$formapago = $_REQUEST['tipopago'];
	
	if($formapago == 'Tarjeta de Credito'){
		$valorPago = 2;
	}elseif($formapago == 'Efectivo'){
		$valorPago = 1;
	}
	
	$envio = $_REQUEST['forma'];
	
	if($_REQUEST['clienteok'] == 'ok'){
		$idcliente = $_REQUEST['idcliente'];
	}else if($_REQUEST['clienteok'] == 'no'){
		$insert = "INSERT INTO Cliente VALUES ('NULL','".$nombre."','".$email."','".$pass."','".$cedula."','".$dir."','2000-01-01','Agregar Genero','Agregar Ciudad','Agregar Provincia','Agregar Numero','".$movil."',0,'0','si','".$fechatime."','0')";
		//echo $insert."<br>";
		$ins = $gbd -> prepare($insert);
		$ins -> execute();
		$idcliente = $gbd -> lastInsertId();
	}
	
	
	// $recibeCedula = $_REQUEST['recibeCedula'];
		
		$email = $_REQUEST['mail'];
		$movil = $_REQUEST['movil'];
		$dir = $_REQUEST['dir'];
		$formapago = $_REQUEST['tipopago'];
		if($formapago == 'Tarjeta de Credito'){
			$valorPago = 2;
		}elseif($formapago == 'Efectivo'){
			$valorPago = 1;
		}
		$envio = $_REQUEST['forma'];
		
		$query1 = "SELECT strNombresC FROM Cliente WHERE idCliente = ?";
		$qry1 = $gbd -> prepare($query1);
		$qry1 -> execute(array($idcliente));
		$rowquery1 = $qry1 -> fetch(PDO::FETCH_ASSOC);
		$nombre = $rowquery1['strNombresC'];
		
		$idconcierto = $_REQUEST['concierto'];
		
			
	    //if ($idconcierto==185){
		//	echo 'vali: '.$_REQUEST['valores'];
		//	exit;
		//}
		
		$select = "SELECT * FROM Concierto WHERE idConcierto = ?";
		$stmt = $gbd -> prepare($select);
		$stmt -> execute(array($idconcierto));
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);
		$evento = $row['strEvento'];
		$lugar = $row['strLugar'];
		$fecha = $row['dateFecha'];
		$hora = $row['timeHora'];
		$dircanje = $row['dircanjeC'];
		$horario = $row['horariocanjeC'];
		$iniciocanje = $row['fechainiciocanjeC'];
		$finalcanje = $row['fechafinalcanjeC'];
		$costoenvio = $row['costoenvioC'];
		$costoenvio = number_format($costoenvio,2);
		$tiene_permisos = $row['tiene_permisos'];
		$dateFechaPreventa = $row['dateFechaPreventa'];
		$tipo_conc = $row['tipo_conc'];
		
		if($tiene_permisos == 0){
			$sitiene = 1;
		}else{
			$sitiene = 2;
		}
		
		$select2 = "SELECT * FROM Concierto WHERE dateFechaPreventa >= ? AND idConcierto = ?";
		$stmt2 = $gbd -> prepare($select2);
		$stmt2 -> execute(array($hoy,$idconcierto));
		$numrows = $stmt2 -> rowCount();
		if($numrows > 0){
			$descompra = 1;
		}else{
			$descompra = 2;
		}
		
		$total = '';
		$print = '';
		$counter = 1;
		$boletos = '';
		$asientoss = 0;
		$mm=0;
		
		
		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		$tipo_tarjeta = $_REQUEST['tipo_tarjeta'];
		
		if($tipo_tarjeta == 0){
			$tipo_tarjeta2 = 'Efectivo';
		}

		if($tipo_tarjeta == 1){
			$tipo_tarjeta2 = 'Visa';
		}
		
		if($tipo_tarjeta == 2){
			$tipo_tarjeta2 = 'Dinners';
		}
		
		if($tipo_tarjeta == 3){
			$tipo_tarjeta2 = 'Mastercard';
		}
		
		if($tipo_tarjeta == 4){
			$tipo_tarjeta2 = 'Discover';
		}
		
		if($tipo_tarjeta == 5){
			$tipo_tarjeta2 = 'Amex';
		}
		
		$total_pagar = $_REQUEST['total_pagar'];
		
		$cuantos=0;
		foreach(explode('@',$_REQUEST['valores']) as $valor){	
			$exVal = explode('|',$valor);
			
			$total = $total + $exVal[3];
			$total = number_format($total,2);
			
			
			// if($_SESSION['valida_ocupadas'] == 1){
				$sqlNum = 'select strCaracteristicaL from Localidad where idLocalidad = "'.$exVal[0].'" ';
				$resNum = mysql_query($sqlNum) or die (mysql_error());
				$rowNum = mysql_fetch_array($resNum);
				if($rowNum['strCaracteristicaL'] == 'Asientos numerados'){
					$selectocupadas = 'SELECT * FROM ocupadas WHERE row = "'.$exVal[4].'" AND col = "'.$exVal[5].'" AND local = "'.$exVal[0].'" AND concierto = "'.$idconcierto.'"';
					$stmtocupadas = $gbd -> prepare($selectocupadas);
					$stmtocupadas -> execute();
					$numocupadas = $stmtocupadas -> rowCount();
					if($numocupadas > 0){
						echo 'error';
						return false;
					}else{
						
					}				

				}
			// }
	
	
			$cuantos++;
		}
		
		$sqlFa = '	INSERT INTO factura (id, tipo, rand, id_cli, idConc , localidad , valor , estadoPV , estadopagoPV , ndepo , fecha , estado , id_dist) 
					VALUES (NULL, "5", "", "'.$idcliente.'" , "'.$idconcierto.'" , "'.$exVal[0].'" , "'.$total_pagar.'" , "'.$tipo_tarjeta.'" , "0" , "'.$cuantos.'|'.$id_desc.'|'.$descuentos.'" , "'.$hoy.'" , "'.$HoraActual.'" , "'.$_SESSION['iduser'].'")';
		
		$resFa = mysql_query($sqlFa) or die (mysql_error());
		$idFactura = mysql_insert_id();
		
		$sqlTPV = '	INSERT INTO `transaccion_pventa` (`id`, `id_dist`, `cuantos`, `est`) 
					VALUES (NULL, "'.$_SESSION['idDis'].'", "'.$cuantos.'", "0")';
		$resTPV = mysql_query($sqlTPV) or die (mysql_error());
		$idTPV = mysql_insert_id();
		
		$sqlL = 'select * from Localidad where idLocalidad = "'.$exVal[0].'" ';
		$resL = mysql_query($sqlL) or die (mysql_error());
		$rowL = mysql_fetch_array($resL);
		
		
		
	foreach(explode('@', $_REQUEST['valores']) as $value){
		$mm++;
			$exp = explode('|',$value);
			
			$sqlNum1 = 'select strCaracteristicaL from Localidad where idLocalidad = "'.$exVal[0].'" ';
			$resNum1 = mysql_query($sqlNum1) or die (mysql_error());
			$rowNum1 = mysql_fetch_array($resNum1);
			if($rowNum1['strCaracteristicaL'] == 'Asientos numerados'){
					
					
				$selectocupadas = 'SELECT * FROM ocupadas WHERE row = "'.$exp[4].'" AND col = "'.$exp[5].'" AND local = "'.$exp[0].'" AND concierto = "'.$idconcierto.'"';
				
				$stmtocupadas = $gbd -> prepare($selectocupadas);
				$stmtocupadas -> execute();
				$numocupadas = $stmtocupadas -> rowCount();
				if($numocupadas > 0){
					echo 'error';
					return false;
				}else{
					$insert = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
					$ins = $gbd -> prepare($insert);
					$ins -> execute(array('NULL',$exp[4],$exp[5],2,$exp[0],$idconcierto,1,$descompra));
				}				
		
			}
		
			$sqlCod_bar = 'SELECT * FROM `codigo_barras` WHERE id_con = "'.$idconcierto.'" and utilizado = 0 and id_loc = "'.$exp[0].'" order by id ASc ';
			$resCod_bar = mysql_query($sqlCod_bar) or die (mysql_error());
			$rowCod_bar = mysql_fetch_array($resCod_bar);
			$code = $rowCod_bar['codigo'];
			//echo $code."  este es el codigo q se insertara .<br><br>";
			
			
			if($id_desc == 0){
				$tercera = 0;
			}else{
				$tercera = 1;
			}
			
			$hoy = date("Y-m-d");
			$dateFechaPreventa = $row['dateFechaPreventa'];
			if($hoy < $dateFechaPreventa){
				$espreventa = 1;
			}else{
				$espreventa = 0;
			}
			
			
			// $sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$idconcierto.'"  order by idBoleto DESC';
			// $resB = mysql_query($sqlB) or die (mysql_error());
			// $rowB = mysql_fetch_array($resB);
			
			// if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
				// $numeroSerie = 1;
			// }else{
				// $numeroSerie = ($rowB['serieB'] + 1);
			// }
			
			$sqlControl = 'select identComprador from Boleto where idCon = "'.$idconcierto.'" order by idBoleto Desc limit 1';
			$resControl = mysql_query($sqlControl) or die (mysql_error());
			$rowControl = mysql_fetch_array($resControl);
			
			if($rowControl['identComprador'] == $tiene_permisos){
				$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$idconcierto.'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
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
					$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$idconcierto.'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
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
			
			$sqlB1 = 'select max(CAST(serie_localidad AS INTEGER)) as serieB from Boleto where idCon = "'.$idconcierto.'"  and idLocB = "'.$exp[0].'"  order by idBoleto DESC';
			$resB1 = mysql_query($sqlB1) or die (mysql_error());
			$rowB1 = mysql_fetch_array($resB1);
			
			if($rowB1['serieB'] == null || $rowB1['serieB'] == '' ){
				$numeroSerie_localidad = 1;
			}else{
				$numeroSerie_localidad = ($rowB1['serieB'] + 1);
			}
			
			$insert2 = 'INSERT INTO Boleto VALUES ("NULL","'.$seccion.'","'.$code.'",'.$idcliente.','.$idconcierto.','.$exp[0].',"'.$valorPago.'","'.$quien_vendio_boleto.'","'.$tercera.'", "'.$espreventa.'" , "2" , "" ,  "'.$exp[7].'","A","S","'.$numeroSerie.'" ,"'.$numeroSerie_localidad.'","'.$tiene_permisos.'" , "'.$_SESSION['iduser'].'" , "'.$id_desc.'" , "'.$descuentos.'" , "'.$hoy.'" , "'.$HoraActual.'" , "'.$tipo_tarjeta.'" , "0" )';
			// echo $insert2."<br>";
			
			$ins2 = $gbd -> prepare($insert2);
			$ins2 -> execute();
			
			 $idboleto = $gbd -> lastInsertId();
			
			$hoy = date("Y-m-d");
			
			$sqlUpCodBar = 'update codigo_barras set utilizado = "1" where codigo = "'.$code.'" ';
			$resUpCodBar = mysql_query($sqlUpCodBar) or die (mysql_error());
	// }	
	// echo 'hola_2';
	// exit;
	// exit;
		
			$boletos .= $idboleto."|";
			
			
			if($tipo_conc == 1){
				$trans = 'INSERT INTO transaccion_distribuidor VALUES ("NULL", '.$idcliente.', '.$idconcierto.', "'.$exp[0].'", "'.$_SESSION['idDis'].'", "'.$idTPV.'","'.$idboleto.'", "'.$formapago.'", "'.$exp[3].'","'.$fechatime.'",0)';
				//echo $trans;
				// exit;
				$stmttrans = $gbd -> prepare($trans);
				$stmttrans -> execute();
			}
			// $qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'';
			
			// $url = str_replace(' ','',$qr);
			// $img = 'qr/'.$timeRightNow.'.png';
			// file_put_contents($img, file_get_contents($url));
			
			// $_SESSION['barcode'] = $code;
		
		
			
			$hoy = date("Y-m-d H:i:s");
			// if($_SESSION['tipo_emp'] == 2){
				
			// }else{
				// $sqlImp = 'INSERT INTO `imp_boleto` (`id`, `idbo`, `idCli`, `fecha` ,codbarras) VALUES (NULL, "'.$idboleto.'", "'.$idcliente.'", "'.$hoy.'" , "'.$code.'")';
				// $resImp = mysql_query($sqlImp) or die (mysql_error());
			// }
			
			
			
			
			// $asientoss = "Fila-".$exp[4]."-Silla-".$exp[5];
			$asientoss = $exp[2];//"Fila-".$exp[4]."-Silla-".$exp[5];
			
			$detalleBoleto = 'INSERT INTO detalle_boleto (idBoleto, localidad, asientos, precio) VALUES ("'.$idboleto.'" , "'.$rowL['strDescripcionL'].'" , "'.$asientoss.'" , "'.$exp[3].'")';
		//	echo $detalleBoleto."<br><br>";
			$res = mysql_query($detalleBoleto) or die (mysql_error());
			
			
			
			$sqlDT = '	INSERT INTO `detalle_tarjetas` (`idcon`, `idloc`, `idbol`, `idcli`, `fecha`, `hora`, `tipo`, `valor`, `id_fact`) 
							VALUES ("'.$idconcierto.'", "'.$exp[0].'", "'.$idboleto.'", "'.$idcliente.'", "'.$hoy.'", "'.$HoraActual.'", "venta PV | '.$tipo_tarjeta2.'" , "'.$exp[3].'" , "'.$idFactura.'")';
		    // echo $sqlDT."<br><br>";
			$resDT = mysql_query($sqlDT) or die (mysql_error());
				
		//if($envio != 'Domicilio'){
			$content = '
				<page>
					<br>
					<br>
					<p align="center">Estimado cliente adjuntamos su boleto para:</p>
					<br>
					<font size = "5"><p align="center"><strong>'.$evento.'</strong></p></font>
					<br>
					<p align="center">El mismo que se efctuara en:</p>
					<br>
					<font size = "5"><p align="center"><strong>'.$lugar.'</strong></p></font>	
					<br>
					<p align="center">El dia: '.$hoy.' a las: '.$HoraActual.'</p>
					<br>
					<p align="center">En la localidad: <strong>'.$exp[1].'</strong> costo: <strong>'.$exp[3].'</strong></p>
					<br>
					<p align="center"><strong>Tu asiento es : '.$exp[2].'</strong></p>
					<br>
					
					<br>
					<br>
					<p align="center">Disfrute el evento</p>
					<br>
					<p align="center"><strong>Imprimir el boleto para el ingreso al evento</strong></p>
					<br>
					<p align="center">Nota: El ingreso al evento se permitide solo con la cedula y el boleto impreso</p>
					<br>
					<br>
					
					
					<br>
				</page>
			';
			// $codigo = $_SESSION['barcode'];
			// $urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$codigo.'';
			// $imgbar = 'barcode/'.$codigo.'.png';
			// file_put_contents($imgbar, file_get_contents($urlbar));
			
			
			
			// $detalleBoleto = 'INSERT INTO detalle_boleto (idBoleto, localidad, asientos, precio) VALUES ("'.$idboleto.'" , "'.$exp[1].'" , "'.$exp[2].'" , "'.$exp[3].'")';
			// $res = mysql_query($detalleBoleto) or die (mysql_error());
			$content2 = '
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
								<span style="font-size:30px;"><strong>GRACIAS, SE HA COMPLETADO EL PAGO DE SU(S) TICKET(S) ($'.$exp[3].') CON EXITO</strong></span>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								Estimado(a) <strong>'.utf8_decode($exp[6]).'</strong>:
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								El pago de su(s) ticket(s) se cancelo con: <strong>'.$formapago.'</strong>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<br>
								<br>
								<font size = "5"><p align="center">Para el concierto de : <strong>'.$evento.'</strong></p></font>
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
				// $html2pdf->setDefaultFont('Arial');
				// $html2pdf->writeHTML($content);
				// $html2pdf->Output('pdf/'.$timeRightNow.'.pdf','F');
			// }
			// catch(HTML2PDF_exception $e) {
				// echo 'my errors '.$e;
				// exit;
			// }
		//echo $content2;
		if($idcliente != 59){
			$ownerEmail = 'info@ticketfacil.ec';
			$subject = 'TICKET para '.$evento.'';
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
			$mail->AddCC("fabricio@practisis.com", "copia de compra desde punto de venta");
			$mail->From = $ownerEmail;
			$mail->AddAddress($email,$exp[6]);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content2);
			//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
		
			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else{
				echo 'ok enviado <br>';
			}
		}
	}
		unset($_SESSION['carrito']);
		echo 'gracias';
?>