
<?php
	session_start();
	$compras=$_SESSION['boletos_asignados'];
	include("../../controlusuarios/seguridadusuario.php");
	require_once('../../classes/private.db.php');
	require_once '../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../PHPM/PHPM/class.smtp.php';
	// $rand = md5(time());
	// $code = sha1(time());
	// ini_set('display_startup_errors',1);
	// ini_set('display_errors',1);
	// error_reporting(-1);
	$gbd = new DBConn();
	
	$idConcierto = $_REQUEST['evento'];
	
	
	$nom = $_SESSION['username'];
	$email = $_SESSION['usermail'];
	$id_cli = $_SESSION['id'];
	
	$numero = 0;
	$fecha = 0;
	$status = 2;
	$estado = "Revisar";
	$est_deposito = "No";
	$pagopor = 3;
	$fechahoy = date('Y-m-d');
	
	
	if($_SESSION['valida_ocupadas'] == 1){
		$boletosok1 = 'SELECT * FROM ocupadas WHERE row = "'.$compras[$i]['row'].'" AND col = "'.$compras[$i]['col'].'" AND local = "'.$compras[$i]['codigo'].'" AND concierto = "'.$idConcierto.'"';
		//echo $boletosok."<br><br>";
		$bolok1 = $gbd -> prepare($boletosok1);
		$bolok1 -> execute();
		$numbolok1 = $bolok1 -> rowCount();
		if($numbolok1 > 0){
			echo 0;
			return false;
		}else{
				
		}
	}
	
	
	$selectpreventa = "SELECT doublePrecioPreventa FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto WHERE Concierto.dateFechaPreventa >= ? AND Concierto.idConcierto = ?";
	$resSelectpreventa = $gbd -> prepare($selectpreventa);
	$resSelectpreventa -> execute(array($fechahoy,$idConcierto));
	$numpreventa = $resSelectpreventa -> rowCount();
	if($numpreventa > 0){
		$descompra = 1;
	}else{
		$descompra = 2;
	}
	
	
	
	// $cant_bol = 0;
	// $total_pago = $_POST['total_pagar'];
	// $cant_boletos = $_POST['num_boletos'];
	//if(isset($_POST['codigo'])){
		$select1 = "SELECT * FROM Cliente WHERE idCliente = ?";
		$slt1 = $gbd -> prepare($select1);
		$slt1 -> execute(array($id_cli));
		$row = $slt1 -> fetch(PDO::FETCH_ASSOC);
		$envio = $row['strEnvioC'];
		$dir = $row['strDireccionC'];
		if($envio == 'Domicilio'){
			$envio = 'A tu Domicilio';
			$dir = $row['strDireccionC'];
		}else if($envio == 'correo'){
			$envio = 'Correo Electronico';
			$dir = $email;
		}else if($envio == 'p_venta'){
			$envio = 'Punto de Venta';
			$dir = 'Cualquiera de nuestros Puntos de Venta';
		}
		
		
		$query1 = "SELECT * FROM Concierto where idConcierto = ?";
		$result = $gbd -> prepare($query1);
		$result -> execute(array($idConcierto));
		$row1 = $result -> fetch(PDO::FETCH_ASSOC);
		$e = $row1['strEvento'];
		$tiene_permisos = $row1['tiene_permisos'];
		
		
		
		
		include '../../conexion.php';
		
		
		
		$randomFactura = mt_rand();
		$codigoFactura = $randomFactura;
		$urlbar = 'http://ticketfacil.ec/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$codigoFactura.'';
		$imgbar = 'barcode/'.$codigoFactura.'.png';
		file_put_contents($imgbar, file_get_contents($urlbar));
		
		
		
		
		$m=1;
		
		$n=1;
		for($i=1;$i<=count($compras)-1;$i++){
		$n++;
		}
									
									
		for($i=0;$i<=count($compras)-1;$i++){
			$cod_loc = $compras[$i]['codigo'];
			$precio = $compras[$i]['pre'];
			$val_desc = $compras[$i]['val_desc'];
			$id_desc = $compras[$i]['id_desc'];
			//$total_pago += ($compras[$i]['pre']);
			$m++;
			$total_pago += $compras[$i]['pre'];
		}
		$datosDescuentos = $n."|".$id_desc."|".$val_desc;
		$sqlLo = 'select * from Localidad where idLocalidad = "'.$cod_loc.'" ';
		$resLo = mysql_query($sqlLo) or die (mysql_error());
		$rowLo = mysql_fetch_array($resLo);
		
		
		
		$hoy = date("Y-m-d");
		$dateFechaPreventa = $row1['dateFechaPreventa'];
		if($hoy <= $dateFechaPreventa){
			$precioLocalidad = $rowLo['doublePrecioPreventa'];
		}else{
			$precioLocalidad = $rowLo['doublePrecioL'];
		}
		
		
			
		$sqlFa = '	INSERT INTO factura (id, tipo, rand, id_cli, idConc , localidad , valor , estadoPV , estadopagoPV,ndepo,pventa) 
					VALUES (NULL, "5", "'.$randomFactura.'", "'.$id_cli.'" , "'.$idConcierto.'" , "'.$cod_loc.'" , "'.$total_pago.'" , "0" , "0" , "'.$datosDescuentos.'","1")';
	
		$resFa = mysql_query($sqlFa) or die (mysql_error());
	
		$idFactura = mysql_insert_id();
		
		
		$ident1 = $_REQUEST['ident1'];
		$dir1 = $_REQUEST['dir1'];
		$tel1 = $_REQUEST['tel1'];
		$cel1 = $_REQUEST['cel1'];
		
		
		if($ident1 == 1){
			$sqlUC = 'update Cliente set strDireccionC = "'.$dir1.'" , strTelefonoC  = "'.$tel1.'", intTelefonoMovC = "'.$cel1.'" where idCliente = "'.$id_cli.'" ';
			$resUC = mysql_query($sqlUC) or die (mysql_error());
			
			$sqlCDPV = 'INSERT INTO `cli_dom_pventa` (`id`, `forma_pago`, `estado`, `paga_dom`, `id_fact`) 
						VALUES (NULL, "pventa" , "0" , "1" , "'.$idFactura.'")';
			$resCDPV = mysql_query($sqlCDPV) or die (mysql_error());
			
			$sqlC = 'select envio from Concierto where idConcierto = "'.$idConcierto.'" ';
			$resC = mysql_query($sqlC) or die (mysql_error());
			$rowC = mysql_fetch_array($resC);
			$costoEnvio = $rowC['envio'];
			$verDetalleEnvio = '';
			$total_pago = ($total_pago + $costoEnvio);
		}else{
			$costoEnvio = 0;
			$verDetalleEnvio = 'style ="display:none"';
			$total_pago = $total_pago;
		}
		
		for($i=0;$i<=count($compras)-1;$i++){
			
			$random = mt_rand();
			
			if($_SESSION['valida_ocupadas'] == 1){
				$boletosok = 'SELECT * FROM ocupadas WHERE row = "'.$compras[$i]['row'].'" AND col = "'.$compras[$i]['col'].'" AND local = "'.$compras[$i]['codigo'].'" AND concierto = "'.$idConcierto.'"';
				//echo $boletosok."<br><br>";
				$bolok = $gbd -> prepare($boletosok);
				$bolok -> execute();
				$numbolok = $bolok -> rowCount();
				if($numbolok > 0){
					echo 0;
					//header('Location: ../../?modulo=preventaok&error=ok');
					return false;
				}else{
					$insertAsientos = 'INSERT INTO ocupadas VALUES ("NULL" , "'.$compras[$i]['row'].'" , "'.$compras[$i]['col'].'" , "'.$status.'" , "'.$compras[$i]['codigo'].'" , "'.$idConcierto.'" , "'.$pagopor.'" , "'.$descompra.'")';
					$resulinsertAsientos = $gbd -> prepare($insertAsientos);
					$resulinsertAsientos -> execute();
				}
				
				
				
			}
			
			$query = 'INSERT INTO pventa VALUES("NULL" , "'.$numero.'" , "'.$fechahoy.'" , "'.$compras[$i]['row'].'" , "'.$compras[$i]['col'].'" , "'.$id_cli.'" , "'.$idConcierto.'" , "'.$compras[$i]['codigo'].'" , "'.$random.'" , "'.$compras[$i]['num'].'" , "'.$estado.'" , "'.$est_deposito.'" , "SN" , "NULL" , "NULL" , "'.$idFactura.'" , "'.$_SESSION['id_area_mapa'].'" , "'.$compras[$i]['pre'].'" , "'.$compras[$i]['id_desc'].'" )';
			//echo $query."<br><br>";
			$res = $gbd -> prepare($query);
			$res -> execute();
			
			
			if($compras[$i]['es_para_membresia'] == 1){
				$sqlCM = 'INSERT INTO `compras_membresias` (`id`, `id_cli`, `id_loc`, `id_con`, `valor`, `id_desc`, `canti`, `fecha` , `tipo` , `id_pv_dep` ) 
					  VALUES (NULL, "'.$id_cli.'" , "'.$compras[$i]['codigo'].'" , "'.$idConcierto.'" , "'.$compras[$i]['val_desc'].'" , "'.$compras[$i]['id_desc'].'" , "1" , "'.$hoy.'" , "'.$compras[$i]['tipo'].'" , "'.$idFactura.'" )';
				$resCM = mysql_query($sqlCM) or die(mysql_error());
			}
			
			
			$sql2 = 'SELECT strDescripcionL, doublePrecioL, doublePrecioReserva, doublePrecioPreventa, filaPV, columnaPV, numboletosPV, localidadPV , conciertoPV FROM pventa p JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE codigoPV = "'.$random.'" ';
			$stmt2 = $gbd -> prepare($sql2);
			$stmt2 -> execute();
			$row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
			$costoboleto = $row2['doublePrecioPreventa'];
			
			
			$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$compras[$i]['codigo'].'"';
			$lokRow= $gbd -> prepare($localidad);
			$lokRow -> execute();
			$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
			$doublePrecioL = $rowLoc['doublePrecioL'];
		}
		
		$content = '
		<html>
			<head>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
			</head>
			<body>
				<div style="border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;">
					<table align="center" style="width:400px; border-collapse:separate; border-spacing:15px 5px;font-size:11px;" class="table table-hover">
						<tr>
							<td style="text-align:center;">
								<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="200px"/>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								Estimado <h3 style="text-transform:capitalize;">'.utf8_decode($nom).'</h3> 
								<br/>Esto es un comprobante de reserva en l&iacute;nea :
							</td>
						</tr>
						<tr>
							<td>
								* Sus asientos estan reservados,
								si el pago se realiza dentro de las siguientes: <strong>'.$row1['tiempopagoC'].'</strong>,
								caso contrario sus asientos seran ELIMINADOS
							</td>
						</tr>
						<tr>
							<td>
								El detalle de su compra es el siguiente : 
									<table width = "100%" >
										<tr>
											<th style ="border :1px solid #ccc;width33.33%">Asientos</th>
											<th style ="border :1px solid #ccc;width33.33%">Localidad</th>
											<th style ="border :1px solid #ccc;width33.33%">Valor Unitario </th>
										</tr>';
									// $total_pago =0;
									
									for($i=0;$i<=count($compras)-1;$i++){
										if($rowLo['strCaracteristicaL'] == 'Asientos numerados'){
											$asientos = $compras[$i]['chair'];
										}else{
											$asientos = 'No Numerados';
										}
									$content.= "
										<tr>
											<td style ='border :1px solid #ccc;'>".$asientos."</td>
											<td style ='border :1px solid #ccc;'>   Localidad : ".$rowLo['strDescripcionL']."  </td>
											<td style ='border :1px solid #ccc;'> Precio : ".$compras[$i]['pre']."</td></tr>";
											// $total_pago += $compras[$i]['pre'];
											
									}
										
				$content.='				<tr '.$verDetalleEnvio.'>
											<th colspan = "3" align ="right">
												<span style="color:#EC1867;">Costo Envio : <strong>$'.($costoEnvio).'</strong></span>
											</th>
										</tr>
										
										<tr>
											<th colspan = "3" align ="right">
												<span style="color:#EC1867;">Total : <strong>$'.($total_pago).'</strong></span>
											</th>
										</tr>
									</table>
							</td>
						</tr>
						<tr>
							<td>
								'.$row1['dirPago'].' 
							</td>
						</tr>';
					if($ident1 == 1){
						$content .= '	
								<tr>
									<td>
										Sus tickets seran enviados a la siguente direccion : "'.$dir1.'"<br>
										mediante el sistema de envios de servientrega <br>
										Su numero de contacto ingresado es : "'.$tel1.'"<br>
										nosotros le notificaremos a su numero de celular : '.$cel1.' <br>
										cuando el envio se haya realizado.
									</td>
								</tr>';
					}	
						// <!--
						// <tr>
							// <td>
								// Una vez pagada la totalidad de sus TICKETS usted podr&aacute; canjearlos en :'.$row1['dircanjeC'].' 
								// desde el dia : '.$row1['fechainiciocanjeC'].' hasta el dia '.$row1['fechafinalcanjeC'].'
								// el el horario de : '.$row1['horariocanjeC'].'<br/>
								// * Para el evento de :<center><h3><strong>'.$e.'</strong><h3></center>
								// <br/><br/>
								// Por favor debe portar este documento impreso , el recibo del pago y su documento de identidad al momento del canje<br/>
							// </td>
						// </tr>-->
					$content .= '	
						<tr>
							<td valign="middle" align="center">
								* Su c&oacute;digo de compra es el siguiente:<br/>
								<img src="http://www.ticketfacil.ec/ticket2/subpages/Compras/barcode/'.$codigoFactura.'.png" /><br/>
								 <span style="color:#EC1867;"><strong>'.$codigoFactura.'</strong></span>
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
			</body>
		</html>';
		// echo $content;
		// exit;
		$ownerEmail = 'fabricio@practisis.com';
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
		$mail->SetFrom($ownerEmail,'TICKETFACIL');
		$mail->From = $ownerEmail;
		$mail->AddAddress($email,$nom);
		$mail->AddBCC("fabricio@practisis.com", "TICKETFACIL");
		$mail->AddBCC("info@ticketfacil.ec", "TICKETFACIL");
		$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
		$mail->FromName = 'TICKETFACIL';
		$mail->Subject = $subject;
		$mail->MsgHTML($content);
		//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
		if(!$mail->Send()){
			echo 2;
		}
		else{
			echo 1;
			// $_SESSION['smsPago'] = $content;
			// $_SESSION['content3'] = $content3;
			// $_SESSION['content4'] = $content4;
			 //header('Location: ../../?modulo=preventaok&error=ok');
			 
		}
		unset($_SESSION['boletos_asignados']);
		$_SESSION['boletos_asignados'] = 0;
		$_SESSION['boletos_asignados'] = null;
		array_values($_SESSION['boletos_asignados']);
	//}
?>