<?php 
	session_start();
	$quien_vendio_boleto = 2;
	include '../../../conexion.php';
	// if($_SESSION['tipo_emp'] == 1){
		// $quien_vendio_boleto = 3;
	// }elseif($_SESSION['tipo_emp'] == 2){
		// $quien_vendio_boleto = 2;
	// }
	
	if(isset($_SESSION['id_area_mapa'])){
		$seccion = $_SESSION['id_area_mapa'];
	}else{
		$seccion = 1;
	}
	
	date_default_timezone_set('America/Guayaquil');
	include('../../../controlusuarios/seguridadDis.php');
	require_once('../../../classes/private.db.php');
	include('../../../html2pdf/html2pdf/html2pdf.class.php');
	require_once '../../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../../PHPM/PHPM/class.smtp.php';
	// require_once 'ex.php';
	$timeRightNow = time();
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	
	$gbd = new DBConn();
	
	// print_r($_REQUEST);
	$hoy = date("Y-m-d");
	$fechatime = date("Y-m-d H:i:s");
	$clienteokFa = $_REQUEST['clienteok'];
	$forma_pago = $_REQUEST['forma_pago'];
	// echo $clienteokFa;
	// exit;Tarjeta de Credito
	
	
	$recibeCedula = $_REQUEST['recibeCedula'];
	$nombre = $_REQUEST['nombres'];
	$cedula = $_REQUEST['documento'];
	$email = $_REQUEST['mail'];
	$movil = $_REQUEST['movil'];
	$dir = $_REQUEST['dir'];
	$pass = md5($cedula);
	$formapago = $_REQUEST['tipopago'];
	$valorPago = 2;
	// if($formapago == 'Tarjeta de Credito'){
		// $valorPago = 2;
	// }elseif($formapago == 'Efectivo'){
		// $valorPago = 1;
	// }
	
	
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
	
	
	$recibeCedula = $_REQUEST['recibeCedula'];
		
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
		foreach(explode('@', $_REQUEST['valores']) as $value){
			$exp = explode('|',$value);
			if($_SESSION['valida_ocupadas'] == 1){
				$selectocupadas = "SELECT * FROM ocupadas WHERE row = ".$exp[4]." AND col = ".$exp[5]." AND local = ".$exp[0]." AND concierto = ".$idconcierto."";
				//echo $selectocupadas;
				//exit;
				$stmtocupadas = $gbd -> prepare($selectocupadas);
				$stmtocupadas -> execute();
				$numocupadas = $stmtocupadas -> rowCount();
				if($numocupadas > 0){
					echo 'error';
				}
				
				$insert = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				$ins = $gbd -> prepare($insert);
				$ins -> execute(array('NULL',$exp[4],$exp[5],1,$exp[0],$idconcierto,1,$descompra));
			}
			
			$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
			$rand = md5($s.time()).mt_rand(1,10);
			//$code = rand(1,9999999999).time();
			$sqlCod_bar = 'SELECT * FROM `codigo_barras` WHERE id_con = "'.$idconcierto.'" and utilizado = 0 and id_loc = "'.$exp[0].'" order by id ASc ';
			$resCod_bar = mysql_query($sqlCod_bar) or die (mysql_error());
			$rowCod_bar = mysql_fetch_array($resCod_bar);
			$code = $rowCod_bar['codigo'];
			echo $code."  este es el codigo q se insertara .<br><br>";
			
			
			if($recibeCedula != ''){
				$tercera = 1;
			}else{
				$tercera = 0;
			}
			
			$hoy = date("Y-m-d");
			$dateFechaPreventa = $row['dateFechaPreventa'];
			if($hoy < $dateFechaPreventa){
				$espreventa = 1;
			}else{
				$espreventa = 0;
			}
			
			$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$idconcierto.'"  order by idBoleto DESC limit 1';
			$resB = mysql_query($sqlB) or die (mysql_error());
			$rowB = mysql_fetch_array($resB);
			
			if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
				$numeroSerie = 1;
			}else{
				$numeroSerie = ($rowB['serieB'] + 1);
			}
			
			$sqlB1 = 'select max(CAST(serie_localidad AS INTEGER)) as serieB from Boleto where idCon = "'.$idconcierto.'"  and idLocB = "'.$exp[0].'" order by idBoleto DESC limit 1';
			$resB1 = mysql_query($sqlB1) or die (mysql_error());
			$rowB1 = mysql_fetch_array($resB1);
			
			if($rowB1['serieB'] == null || $rowB1['serieB'] == '' ){
				$numeroSerie_localidad = 1;
			}else{
				$numeroSerie_localidad = ($rowB1['serieB'] + 1);
			}
			
			$insert2 = 'INSERT INTO Boleto VALUES ("NULL","'.$seccion.'","'.$code.'",'.$idcliente.','.$idconcierto.','.$exp[0].',"'.$forma_pago.'","'.$quien_vendio_boleto.'","'.$tercera.'", "'.$espreventa.'" , "2" , "" ,  '.$exp[7].',"A","S","'.$numeroSerie.'" ,"'.$numeroSerie_localidad.'","'.$sitiene.'" , "'.$_SESSION['iduser'].'" )';
			//echo $insert2."<br>";
			// exit;
			$ins2 = $gbd -> prepare($insert2);
			$ins2 -> execute();
			
			$idboleto = $gbd -> lastInsertId();
			
			$hoy = date("Y-m-d");
			
			$sqlUpCodBar = 'update codigo_barras set utilizado = "1" where codigo = "'.$code.'" ';
			$resUpCodBar = mysql_query($sqlUpCodBar);
			
			
			$boletos .= $idboleto."|";
			
			
			if($tipo_conc == 1){
				$trans = 'INSERT INTO transaccion_distribuidor VALUES ("NULL", '.$idcliente.', '.$idconcierto.', "'.$exp[0].'", "'.$_SESSION['idDis'].'", "1","'.$idboleto.'", "'.$formapago.'", "'.$exp[3].'","","")';
				//echo $trans;
				// exit;
				$stmttrans = $gbd -> prepare($trans);
				$stmttrans -> execute();
			}
			$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'';
			
			$url = str_replace(' ','',$qr);
			$img = 'qr/'.$timeRightNow.'.png';
			file_put_contents($img, file_get_contents($url));
			
			$_SESSION['barcode'] = $code;
		
		
			$total = $total + $exp[3];
			$total = number_format($total,2);
			$hoy = date("Y-m-d H:i:s");
			if($_SESSION['tipo_emp'] == 2){
				
			}else{
				$sqlImp = 'INSERT INTO `imp_boleto` (`id`, `idbo`, `idCli`, `fecha` ,codbarras) VALUES (NULL, "'.$idboleto.'", "'.$idcliente.'", "'.$hoy.'" , "'.$code.'")';
				$resImp = mysql_query($sqlImp) or die (mysql_error());
			}
			
			
			if($recibeCedula != ''){
				$sqlCed = 'INSERT INTO `copias_cedula` (`id`, `id_cli`, `id_bol` , `id_usuario`, `cedula`) VALUES (NULL, "'.$idcliente.'", "'.$idboleto.'", "'.$_SESSION['iduser'].'" ,"'.$recibeCedula.'")';
				$resCed = mysql_query($sqlCed) or die (mysql_error());
			}
			
			
			$detalleBoleto = 'INSERT INTO detalle_boleto (idBoleto, localidad, asientos, precio) VALUES ("'.$idboleto.'" , "'.$exp[1].'" , "'.$exp[2].'" , "'.$exp[3].'")';
			$res = mysql_query($detalleBoleto) or die (mysql_error());
			
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
					<p align="center">El dia: '.$fecha.' a las: '.$hora.'</p>
					<br>
					<p align="center">En la localidad: <strong>'.$exp[1].'</strong> costo: <strong>'.$exp[3].'</strong></p>
					<br>
					<p align="center"><strong>Tu asiento es : '.$exp[2].'</strong></p>
					<br>
					<p align="center"><img alt="" src="'.$img.'" /></p>
					<br>
					<br>
					<p align="center">Disfrute el evento</p>
					<br>
					<p align="center"><strong>Imprimir el boleto para el ingreso al evento</strong></p>
					<br>
					<p align="center">Nota: El ingreso al evento se permitide solo con la cedula y el boleto impreso</p>
					<br>
					<br>
					<p align="center"><img alt="" src="http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$_SESSION['barcode'].'" /></p>
					<p align="center">'.$_SESSION['barcode'].'</p>
					<br>
				</page>
			';
			$codigo = $_SESSION['barcode'];
			$urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$codigo.'';
			$imgbar = 'barcode/'.$codigo.'.png';
			file_put_contents($imgbar, file_get_contents($urlbar));
			
			
			
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
		//if($envio != 3){
			$ownerEmail = 'fabricio@practisis.com';
			$subject = 'TICKET para '.$evento.'';
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
				echo 'ok';
			}
		}
		
?>