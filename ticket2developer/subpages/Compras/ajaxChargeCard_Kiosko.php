<?php
	session_start();
	date_default_timezone_set('America/Guayaquil');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	include("../../controlusuarios/seguridadusuario.php");
	require_once('../../classes/private.db.php');
	$hoy = date("Y-m-d H:i:s");
	$gbd = new DBConn();
	
	require_once('../../stripe/lib/Stripe.php');
	Stripe::setApiKey('pk_test_JpAR7fN2JKdbryUzX1z81lUo');

	// $totalEntries = $_REQUEST['totalEntries'];

	// for($i = 0; $i <= $totalEntries; $i++){
		// echo str_replace('|','&amp;',$_REQUEST['code'.$i]).' :::: ';
		// }

	// exit;
	
	$quien_vendio_boleto = 1;
	$valorPago = 2;
	
	
	$token = $_REQUEST['token'];
	$concert_id = (int)$_REQUEST['concert_id'];
	// $loc_id = (int)$_REQUEST['idLocal'];
	$total = $_REQUEST['total'];
	$cantidad = $_REQUEST['cant'];
	$idcli = $_REQUEST['idcli'];
	
	$select1 = 'SELECT * FROM Cliente WHERE idCliente = "'.$idcli.'" ';
	//echo $select1;
	$slt1 = $gbd -> prepare($select1);
	$slt1 -> execute();
	$row1 = $slt1 -> fetch(PDO::FETCH_ASSOC);
	$envio = $row1['strEnvioC'];
	$dir = $row1['strDireccionC'];
	$strDocumentoC = $row1['strDocumentoC'];
	
	$sql = "SELECT * FROM Concierto WHERE idConcierto = ?";
	$res = $gbd -> prepare($sql);
	$res -> execute(array($concert_id));
	$row = $res -> fetch(PDO::FETCH_ASSOC);
	$preciocents = ($total * 100);
	$evento = $row['strEvento'];
	$fecha = $row['dateFecha'];
	$lugar = $row['strLugar'];
	$hora = $row['timeHora'];
	$pagopor = 1;
	$tiene_permisos = $row['tiene_permisos'];
	
	$cobroExitoso = false;

	try{
		$charge = Stripe_Charge::create(array(
			'amount' => $preciocents,
			'currency' => 'usd',
			'card' => $token,
			'description' => $evento
			));

		$cobroExitoso = true;
		$purchaseID = $charge->id;
		echo $purchaseID;
		echo 'ok';
	}
	catch(Exception $e){
		$error = $e->getMessage();
		echo $error;
		exit;
	}
	include '../../conexion.php';
	
	if($cobroExitoso === true){
		include('../../html2pdf/html2pdf/html2pdf.class.php');
		require_once '../../PHPM/PHPM/class.phpmailer.php';
		require_once '../../PHPM/PHPM/class.smtp.php';
		
		$status_boleto = 1;
		$fechahoy = date('Y-m-d H:i:s');
		$fecha = date('Y-m-d');
		$selectpreventa = "SELECT * FROM Concierto WHERE dateFechaPreventa >= ? AND idConcierto = ?";
		$resSelectpreventa = $gbd -> prepare($selectpreventa);
		$resSelectpreventa -> execute(array($fechahoy,$concert_id));
		$numpreventa = $resSelectpreventa -> rowCount();
		if($numpreventa > 0){
			$descompra = 1;
		}else{
			$descompra = 2;
		}
		$counter = 1;
		$idboletoVendido = '';
		foreach(explode('@',$_REQUEST['valFor']) as $valor){	
			$exVal = explode('|',$valor);
			for($i = 0; $i < $exVal[3]; $i++){
				
				$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$concert_id.'"  order by idBoleto DESC limit 1';
				echo $sqlB."<br>";
				$resB = mysql_query($sqlB) or die (mysql_error());
				$rowB = mysql_fetch_array($resB);
				
				if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
					$numeroSerie = 1;
				}else{
					$numeroSerie = ($rowB['serieB'] + 1);
				}
				
				$sqlB1 = 'select max(CAST(serie_localidad AS INTEGER)) as serieB from Boleto where idCon = "'.$concert_id.'"  and idLocB = "'.$exVal[0].'" order by idBoleto DESC limit 1';
				echo $sqlB1."<br/>";
				$resB1 = mysql_query($sqlB1) or die (mysql_error());
				$rowB1 = mysql_fetch_array($resB1);
				
				if($rowB1['serieB'] == null || $rowB1['serieB'] == '' ){
					$numeroSerie_localidad = 1;
				}else{
					$numeroSerie_localidad = ($rowB1['serieB'] + 1);
				}
				
				if($_SESSION['valida_ocupadas'] == 1){
					$boletosok = 'SELECT * FROM ocupadas WHERE row = "'.$exVal[6].'" AND col = "'.$exVal[7].'" AND local = "'.$exVal[0].'" AND concierto = "'.$concert_id.'"';
					echo $boletosok;
					$bolok = $gbd -> prepare($boletosok);
					$bolok -> execute();
					$numbolok = $bolok -> rowCount();
					if($numbolok > 0){
						echo 'error';
						return false;
					}
				
					
					$insertBol = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
					$resultInsertBol = $gbd -> prepare($insertBol);
					$resultInsertBol -> execute(array('NULL',$exVal[6],$exVal[7],$status_boleto,$exVal[0],$concert_id,$pagopor,$descompra));
				}
				
				$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
					$rand = md5($s.time()).mt_rand(1,10);
					$est ="A";
					$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'';
					
					
				//$code = rand(1,9999999999).time();
				
				$sqlCod_bar = 'SELECT * FROM `codigo_barras` WHERE id_con = "'.$concert_id.'" and utilizado = 0 and id_loc = "'.$exVal[0].'" order by id ASc ';
				$resCod_bar = mysql_query($sqlCod_bar) or die (mysql_error());
				$rowCod_bar = mysql_fetch_array($resCod_bar);
				$code = $rowCod_bar['codigo'];
				echo $code."  este es el codigo q se insertara .<br><br>";
				$_SESSION['barcode'] = $code;
				
				if($tiene_permisos == 0){
					$identComprador = 1;
				}elseif($tiene_permisos > 0){
					$identComprador = 2;
					
				}
				
				
				
				$hoy = date("Y-m-d");
				$dateFechaPreventa = $row['dateFechaPreventa'];
				if($hoy <= $dateFechaPreventa){
					$espreventa = 1;
				}else{
					$espreventa = 0;
				}
				
				if(isset($_SESSION['id_area_mapa'])){
					$seccion = $_SESSION['id_area_mapa'];
				}else{
					$seccion = 1;
				}
				$query1 = 'INSERT INTO Boleto VALUES ("NULL","'.$seccion.'","'.$code.'",'.$idcli.','.$concert_id.','.$exVal[0].',"'.$valorPago.'","'.$quien_vendio_boleto.'", "0", "'.$espreventa.'", "2" , "","'.$strDocumentoC.'","A","S","'.$numeroSerie.'", "'.$numeroSerie_localidad.'", "'.$identComprador.'" , "'.$_SESSION['iduser'].'")';
				echo $query1;
				
				$result = $gbd -> prepare($query1);
				$result -> execute(array());
				$idboleto = $gbd -> lastInsertId();
				
				
				$trans = 'INSERT INTO transaccion_distribuidor VALUES ("NULL", '.$idcli.', '.$concert_id.', "'.$exVal[0].'", "'.$_SESSION['idDis'].'", "1","'.$idboleto.'", "tarjeta", "'.$exVal[3].'","","")';
				//echo $trans;
				// exit;
				$stmttrans = $gbd -> prepare($trans);
				$stmttrans -> execute();
				
				
				$hoy = date("Y-m-d");
				$dateFechaPreventa = $row['dateFechaPreventa'];
				if($hoy <= $dateFechaPreventa){
					$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$exVal[0].'"';
					$lokRow= $gbd -> prepare($localidad);
					$lokRow -> execute();
					$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
					$precioVenta = $rowLoc['doublePrecioPreventa'];
					
				}else{
					$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$exVal[0].'"';
					$lokRow= $gbd -> prepare($localidad);
					$lokRow -> execute();
					$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
					$precioVenta = $rowLoc['doublePrecioL'];
				}
				
				
				
				
				
				$timeRightNow = time();
				$url = str_replace(' ','',$qr);
				$img = 'qr/'.$timeRightNow.'.png';
				file_put_contents($img, file_get_contents($url));
				
				
				
				$urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$code.'';
				$imgbar = 'barcode/'.$code.'.png';
				file_put_contents($imgbar, file_get_contents($urlbar));
				include '../../conexion.php';
				
				
				if($tiene_permisos == 0){
					$identComprador = 1;
				}elseif($tiene_permisos > 0){
					$identComprador = 2;
					$hoy = date("Y-m-d H:i:s");
					
				}
				
				
				$asientoss = "Fila-".$exp[6]."-Columna-".$exp[7];
				$sqlL = 'select * from Localidad where idLocalidad = "'.$exp[0].'" ';
				$resL = mysql_query($sqlL) or die (mysql_error());
				$rowL = mysql_fetch_array($resL);
				
				
				$detalleBoleto = 'INSERT INTO detalle_boleto (idBoleto, localidad, asientos, precio) VALUES ("'.$idboleto.'" , "'.$rowL['strDescripcionL'].'" , "'.$asientoss.'" , "'.$exp[3].'")';
				echo $detalleBoleto."<br><br>";
				$res = mysql_query($detalleBoleto) or die (mysql_error());
				
				$idboletoVendido .= $idboleto."|";
				//echo $idboletoVendido;
				$sqlUpCodBar = 'update codigo_barras set utilizado = "1" where codigo = "'.$code.'" ';
				$resUpCodBar = mysql_query($sqlUpCodBar);
		
				//echo $idboletoVendido;
				//$nom = $_SESSION['username'];
				if($row['tipo_conc'] == 1){
			
					$content = '
						<page>
							<div style="border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;">
							<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:11px;text-transform:uppercase;">
								<tr>
									<td style="text-align:center;">
										<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="120px"/>
									</td>
								</tr>
								<tr>
									<td style="text-align:center;">
										Estimado (a) <strong><h3>'.htmlspecialchars($row1['strNombresC']).'</h3></strong> <br/>
										Esto es un comprobante de pago en l&iacute;nea mediante su TARJETA DE CRÉDITO:
									</td>
								</tr>
								
								<tr>
									<td style = "text-align:center;">
											* Para el evento de :<center><h3><strong>'.$evento.'</strong><h3></center>
											<p align="center">El mismo que se efctuara en:</p>
											<br>
											<font size = "5"><p align="center"><strong>'.$row['strLugar'].'</strong></p></font>	
											<br>
											<p align="center">El dia: '.$row['dateFecha'].' a las: '.$row['timeHora'].'</p>
											<br>
											<p align="center">En la localidad: <strong>'.$rowLoc['strDescripcionL'].'</strong></p>
										<br/><br/>
									</td>
								</tr>
								<tr>
									<td valign="middle" align="center">
										* Su c&oacute;digo de compra es el siguiente:<br/>
										<img src="http://ticketfacil.ec/ticket2/subpages/Compras/barcode/'.$code.'.png" /><br/>
										 <span style="color:#EC1867;"><strong>'.$code.'</strong></span>
									</tr>
								</tr>
								
								
								<tr>
									<td valign="middle" align="center" style = "background-color:#DE1161;color:#fff;text-transform:lowercase;">
										* Sus claves de acceso al sistema son : <br>
										Usuario : '.$row1['strMailC'].'<br>
										Password : **********************<br/>
										(Cuidar las claves de acceso son responsabilidad del cliente).<br>
									</tr>
								</tr>
								
								
								<tr>
									<td style="text-align:center;">
										<strong>Gracias por Preferirnos</strong>
										<br>
										<strong>TICKETFACIL <I>"La mejor experiencia de compra En L&iacute;nea"</I></strong>
									</td>
								</tr>
							</table>
							</div>
						</page>';
					$email = $_SESSION['usermail'];
					$ownerEmail = 'info@ticketfacil.ec';
					$subject = 'Informacion de Pago';
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->SMTPAuth = true;
					$mail->SMTPSecure = "ssl";
					$mail->Host = "smtp.gmail.com";
					$mail->Port = 465;
					$mail->Username = "info@ticketfacil.ec";
					$mail->Password = "ticketfacil2012";
					$mail->AddReplyTo($ownerEmail,'TICKETFACIL');
					$mail->AddReplyTo('fabricio@practisis.com','TICKETFACIL');
					$mail->SetFrom($ownerEmail,'TICKETFACIL');
					$mail->From = $ownerEmail;
					$mail->AddAddress($email,$nom);
					$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
					$mail->FromName = 'TICKETFACIL';
					$mail->Subject = $subject;
					$mail->MsgHTML($content);
					//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
					if(!$mail->Send()){
						echo "Error de envio " . $mail->ErrorInfo;
					}
					else{
						echo 'ok enviado';
						//echo $content."|";
						//header('Location: ../../?modulo=preventaok&error=ok');
					}
					 $_SESSION['idboletoVendido'] = $idboletoVendido;
					// echo $_SESSION['idboletoVendido'];
				}else{
					
					$_SESSION['idboletoVendido'] = $idboletoVendido;
					//header('Location: ../../?modulo=preventaok&error=ok');
					$sqlImp = 'INSERT INTO `imp_boleto` (`id`, `idbo`, `idCli`, `fecha` ,codbarras) VALUES (NULL, "'.$idboleto.'", "'.$idcli.'", "'.$hoy.'" , "'.$code.'")';
					$resImp = mysql_query($sqlImp) or die (mysql_error());
					
				}
			}
		}
	}
?>