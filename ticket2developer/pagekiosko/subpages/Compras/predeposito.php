<?php
	ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
session_start();
	include("../../controlusuarios/seguridadusuario.php");
	require_once('../../classes/private.db.php');
	require_once '../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../PHPM/PHPM/class.smtp.php';
	// $rand = md5(time());
	// $code = sha1(time());
	
	$gbd = new DBConn();
	
	$idConcierto = $_GET['evento'];
	$nom = $_SESSION['username'];
	$email = $_SESSION['usermail'];
	$id_cli = $_SESSION['id'];
	
	$numero = 0;
	$fecha = 0;
	$status = 2;
	$estado = "Revisar";
	$est_deposito = "No";
	$pagopor = 2;
	$fechahoy = date('Y-m-d');
	
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
	
	
	
	$selectpreventa = "SELECT doublePrecioPreventa FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto WHERE Concierto.dateFechaPreventa >= ? AND Concierto.idConcierto = ?";
	$resSelectpreventa = $gbd -> prepare($selectpreventa);
	$resSelectpreventa -> execute(array($fechahoy,$idConcierto));
	$rowpre = $resSelectpreventa -> fetch(PDO::FETCH_ASSOC);
	$numpreventa = $resSelectpreventa -> rowCount();
	if($numpreventa > 0){
		$descompra = 1;
	}else{
		$descompra = 2;
	}
	// $cant_bol = 0;
	$total_pago = $_POST['total_pagar'];
	$cant_boletos = $_POST['num_boletos'];
	$codigoCompra='';
	if(isset($_POST['codigo'])){
		foreach($_POST['codigo'] as $key=>$cod_loc){
			
			$random = rand(1,9999999999).time();
			
			$codigo = $random;
			
			$codigoCompra = $codigoCompra.$random."|";
			
			$urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$random.'';
			$imgbar = 'barcode/'.$random.'.png';
			file_put_contents($imgbar, file_get_contents($urlbar));
			
			
			$boletosok = "SELECT * FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
			$bolok = $gbd -> prepare($boletosok);
			$bolok -> execute(array($_POST['row'][$key],$_POST['col'][$key],$cod_loc,$idConcierto));
			$numbolok = $bolok -> rowCount();
			if($numbolok > 0){
				echo 'error';
				header('Location: ../../?modulo=predepositook&error='.$idConcierto.'');
				return false;
			}
			
			$query = "INSERT INTO Deposito VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$res = $gbd -> prepare($query);
			$res -> execute(array('NULL',$numero,$fecha,$_POST['row'][$key],$_POST['col'][$key],$id_cli,$idConcierto,$cod_loc,$random,$_POST['num'][$key],$estado,$est_deposito,'SN','NULL','NULL'));
			
			$insertAsientos = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$resulinsertAsientos = $gbd -> prepare($insertAsientos);
			$resulinsertAsientos -> execute(array('NULL',$_POST['row'][$key],$_POST['col'][$key],$status,$_POST['codigo'][$key],$idConcierto,$pagopor,$descompra));
			
			$selectPrecio = "SELECT doublePrecioL FROM Localidad WHERE idLocalidad = ?";
			$resultPrecio = $gbd -> prepare($selectPrecio);
			$resultPrecio -> execute(array($cod_loc));
			$rowPrecio = $resultPrecio -> fetch(PDO::FETCH_ASSOC);
			
			$suma += $rowPrecio['doublePrecioL'];
			$precio_normal = number_format($suma, 2,'.','');
			
		
			// $cant_bol += $cantidad;
			$query1 = "SELECT * FROM Concierto where idConcierto = ?";
			$result = $gbd -> prepare($query1);
			$result -> execute(array($idConcierto));
			$row1 = $result -> fetch(PDO::FETCH_ASSOC);
			$e = $row1['strEvento'];
			$totalpreventa = '';
			$totalnormal = '';
			$diferencia = $precio_normal - $total_pago;
			
			$hoy = date("Y-m-d");
			$dateFechaPreventa = $row1['dateFechaPreventa'];
			
			if($hoy <= $dateFechaPreventa){
				$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$cod_loc.'"';
				$lokRow= $gbd -> prepare($localidad);
				$lokRow -> execute();
				$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
				$precioVenta = $rowLoc['doublePrecioPreventa'];
				
				$insertCompras_preventa = "INSERT INTO compras_preventa VALUES (?, ?, ?, ?, ? , ? )";
				$resCompras_preventa = $gbd -> prepare($insertCompras_preventa);
				$resCompras_preventa -> execute(array('NULL',$cod_loc , $random , "" , $hoy , $precioVenta));
				
				
			}else{
				$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$cod_loc.'"';
				$lokRow= $gbd -> prepare($localidad);
				$lokRow -> execute();
				$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
				$precioVenta = $rowLoc['doublePrecioL'];
			}
			
			include '../../../conexion.php';
			$sqlCu = 'select * from cuenta';
			$resCu = mysql_query($sqlCu) or die (mysql_error());
			$rowCu = mysql_fetch_array($resCu);
			
			$content = '
				<page style="font-family:corbel;">
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
								Estimado(a) <strong>'.$nom.'</strong> le proporcionamos la siguiente información:
							</td>
						</tr>
						<tr>
							<td>
								<br>
								<br>
								<br>
								* Sus asientos estan reservados, <span style="background-color:#EC1867;">por un valor de <strong>$'.$precioVenta.'</strong></span>, si el pago se realiza dentro de las siguientes: <strong>'.$row1['tiempopagoC'].'</strong>, caso contrario sus asientos seran ELIMINADOS
							</td>
						</tr>
						
							<tr>
								<td>
									<br>
									* Para el concierto: <strong>'.$e.'</strong>
								</tr>
							</tr>
						
							<tr>
								<td style="text-align:left;">
									<br>
									* Para realizar su deposito puede acercarse a : <br/><br/>
									Banco : '.$rowCu['bco'].' <br/>
									Numero de Cta : '.$rowCu['num'].' <br/>
									Tipo de Cta : '.$rowCu['tipo'].' <br/>
									En caso de realizar transferencia bancaria : <br/><br/>
									Titular de la Cta : '.$rowCu['nom'].'<br/>
									Cedula del Titular : '.$rowCu['ced'].'<br/>
								</td>
							</tr>
							<tr>
								<td>
									<br>
									Su código de compra es : '.$random.'<br/>
									Despues de realizar el depósito ingrese <a href = "http://ticketfacil.ec/ticket2/?modulo=deposito&cod='.$random.'" target="_blank" >aqui</a>, para validar su pago.
								</td>
							</tr>
							<tr>
								<td style="text-align:center;">
									<br>
									<strong>Gracias por Preferirnos</strong>
									<br>
									<strong>TICKETFACIL <I>"La mejor experiencia de compra En Línea"</I></strong>
								</td>
							</tr>
					</table>
				</page>';
				
				
				
				$content2 = '
				<page style="font-family:corbel;">
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
								Estimado(a) <strong>'.$nom.'</strong> le proporcionamos la siguiente información:
							</td>
						</tr>
						<tr>
							<td>
								<br>
								<br>
								<br>
								* Sus asientos estan reservados, <span style="background-color:#EC1867;">por un valor de <strong>$'.$precioVenta.'</strong></span>, si el pago se realiza dentro de las siguientes: <strong>'.$row1['tiempopagoC'].'</strong>, caso contrario sus asientos seran ELIMINADOS
							</td>
						</tr>
						
							<tr>
								<td>
									<br>
									* Para el concierto: <strong>'.$e.'</strong>
								</tr>
							</tr>
						
							<tr>
								<td style="text-align:left;">
									<br>
									* Para realizar su deposito puede acercarse a : <br/><br/>
									Banco : '.$rowCu['bco'].' <br/>
									Numero de Cta : '.$rowCu['num'].' <br/>
									Tipo de Cta : '.$rowCu['tipo'].' <br/>
									En caso de realizar transferencia bancaria : <br/><br/>
									Titular de la Cta : '.$rowCu['nom'].'<br/>
									Cedula del Titular : '.$rowCu['ced'].'<br/>
								</td>
							</tr>
							<tr>
								<td>
									<br>
									Despues de realizar el depósito dirijase al link que fue enviado a su correo electronico, para validar su pago.
								</td>
							</tr>
						';
						
						$content3='
							<tr style="font-family:corbel;">
								<td style="text-align:center;">
									<br>
									<strong>Gracias por Preferirnos</strong>
									<br>
									<strong>TICKETFACIL <I>"La mejor experiencia de compra En Línea"</I></strong>
								</td>
							</tr>
					</table>
				</page>';
			$ownerEmail = 'jonathan@practisis.com';
			$subject = 'Informacion de Deposito';
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
			$mail->AddAddress($email,$nom);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content);
			//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else{
				//echo 'ok';
			}
			header('Location: ../../?modulo=predepositook&error=ok');
		}
		
		$_SESSION['codigoCompra'] = $codigoCompra;
		$_SESSION['content2'] = $content2;
		$_SESSION['content3'] = $content3;
	}
?>
