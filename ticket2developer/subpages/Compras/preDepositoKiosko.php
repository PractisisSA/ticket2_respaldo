<?php
	ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
session_start();
include '../../conexion.php';
	//include("../../controlusuarios/seguridadusuario.php");
	require_once('../../classes/private.db.php');
	require_once '../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../PHPM/PHPM/class.smtp.php';
	// $rand = md5(time());
	// $code = sha1(time());
	
	$gbd = new DBConn();
	
	$idConcierto = $_GET['evento'];
	$id_cli = $_GET['cliente_kiosko_id'];
	$nombre_cli = $_POST['cliente_kiosko'];
	$documento_cli = $_POST['cliente_kiosko_ced'];
	$cliente_kiosko_dir = $_POST['cliente_kiosko_dir'];
	$cliente_kiosko_mail = $_POST['cliente_kiosko_mail'];
	$cliente_kiosko_movil = $_POST['cliente_kiosko_movil'];
	$fechatime = date("Y-m-d H:i:s");
	$pass = md5($documento_cli);
	$gbd = new DBConn();
	
	
	
	if($_GET['cliente_kiosko_id'] == 'no'){
		include 'conexion.php';
		$sqlCl = 'select * from Cliente where strDocumentoC = "'.$documento_cli.'" order by idCliente desc limit 1';
		$resCl = mysql_query($sqlCl) or die (mysql_error());
		if(mysql_num_rows($resCl)>0){
			$rowCl = mysql_fetch_array($resCl);
			$id_cli = $rowCl['idCliente'];
		}else{
			$insert = "INSERT INTO Cliente VALUES ('NULL','".$nombre_cli."','".$cliente_kiosko_mail."','".$pass."','".$documento_cli."','".$cliente_kiosko_dir."','2000-01-01','Agregar Genero','Agregar Ciudad','Agregar Provincia','Agregar Numero','".$cliente_kiosko_movil."',0,'0','si','".$fechatime."','0')";
			//echo $insert."<br>";
			$ins = $gbd -> prepare($insert);
			$ins -> execute();
			$id_cli = $gbd -> lastInsertId();
		}
	}
	
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
	
	$mail = $row['strMailC'];
	$nom = $row['strNombresC'];
	
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
	
	$query1 = "SELECT * FROM Concierto where idConcierto = ?";
	$result = $gbd -> prepare($query1);
	$result -> execute(array($idConcierto));
	$row1 = $result -> fetch(PDO::FETCH_ASSOC);
	$e = $row1['strEvento'];
	$tiene_permisos = $row1['tiene_permisos'];
	
	
	
	
	
	
	
	
	$randomFactura = mt_rand();
	$codigoFactura = $randomFactura;
	$urlbar = 'http://ticketfacil.ec/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$codigoFactura.'';
	$imgbar = 'barcode/'.$codigoFactura.'.png';
	file_put_contents($imgbar, file_get_contents($urlbar));
	foreach($_POST['codigo'] as $key=>$cod_loc){
		
	}
	
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
		
		
	$sqlFa = 'INSERT INTO factura (id, tipo, rand, id_cli, idConc , localidad , valor , estadoPV , estadopagoPV , impresion_local , id_dist) VALUES (NULL, "1", "'.$randomFactura.'", "'.$id_cli.'" , "'.$idConcierto.'" , "'.$cod_loc.'" , "'.$total_pago.'" , "Revisado" , "reserva" , "0" , "'.$_SESSION['idDis'].'")';
	// echo $sqlFa;
	// exit;
	$resFa = mysql_query($sqlFa) or die (mysql_error());
	
	$idFactura = mysql_insert_id();
	
	
	if(isset($_POST['codigo'])){
		foreach($_POST['codigo'] as $key=>$cod_loc){
			
			$random = rand(1,9999999999).time();
			
			$codigo = $random;
			
			$codigoCompra = $codigoCompra.$random."|";
			
			$urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$random.'';
			$imgbar = 'barcode/'.$random.'.png';
			file_put_contents($imgbar, file_get_contents($urlbar));
			
			if($_SESSION['valida_ocupadas'] == 1){
				$boletosok = "SELECT * FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
				$bolok = $gbd -> prepare($boletosok);
				$bolok -> execute(array($_POST['row'][$key],$_POST['col'][$key],$cod_loc,$idConcierto));
				$numbolok = $bolok -> rowCount();
				if($numbolok > 0){
					echo 'error';
					header('Location: ../../?modulo=predepositook&error='.$idConcierto.'');
					return false;
				}
				
				$insertAsientos = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				$resulinsertAsientos = $gbd -> prepare($insertAsientos);
				$resulinsertAsientos -> execute(array('NULL',$_POST['row'][$key],$_POST['col'][$key],$status,$_POST['codigo'][$key],$idConcierto,$pagopor,$descompra));
			}
			
			$query = "INSERT INTO Deposito VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ? , ? )";
			$res = $gbd -> prepare($query);
			$res -> execute(array('NULL',$numero,$fecha,$_POST['row'][$key],$_POST['col'][$key],$id_cli,$idConcierto,$cod_loc,$random,$_POST['num'][$key],$estado,$est_deposito,'SN','NULL','NULL' , $idFactura , $_SESSION['id_area_mapa']));
			
			
			
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
			
			
			
			
			
			
		}
		include '../../conexion.php';
		$sqlCu = 'select * from cuenta';
		// echo $sqlCu;
		// exit;
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
							* Sus asientos estan reservados,  si el pago se realiza dentro de las siguientes: <strong>'.$row1['tiempopagoC'].'</strong>, caso contrario sus asientos seran ELIMINADOS
						</td>
					</tr>
					
						<tr>
							<td>
								<br>
								* Para el concierto: <strong>'.$e.'</strong>
							</tr>
						</tr>
					<tr>
						<td>
							El detalle de su compra es el siguiente : 
								<table width = "90%" >
									<tr>
										<th style ="border :1px solid #ccc;">Asientos</th>
										<th style ="border :1px solid #ccc;">Locatidad</th>
										<th style ="border :1px solid #ccc;">Valor Unitario </th>
									</tr>';
								foreach($_POST['chair'] as $llave=>$asientos){
								$content.= "<tr><td style ='border :1px solid #ccc;'>".$_POST['chair'][$llave]."</td><td style ='border :1px solid #ccc;'>   Localidad : ".$rowLo['strDescripcionL']."  </td><td style ='border :1px solid #ccc;'> Precio : ".$precioLocalidad."</td></tr>";
								}
									
			$content.='				<tr>
										<th colspan = "3" align ="right">
											<span style="color:#EC1867;">Total : <strong>$'.$total_pago.'</strong></span>
										</th>
									</tr>
								</table>
						</td>
					</tr>
						<tr>
							<td style="text-align:left;">
								<br>
								* para realizar tu deposito o transferencia bancaria debes hacerlo a la siguiente cuenta : <br/><br/>
								Banco : '.$rowCu['bco'].' <br/>
								Numero de Cta : '.$rowCu['num'].' <br/>
								Tipo de Cta : '.$rowCu['tipo'].' <br/>
								Titular de la Cta : '.$rowCu['nom'].'<br/>
								Cedula del Titular : '.$rowCu['ced'].'<br/>
							</td>
						</tr>
						<tr>
							<td>
								<br>
								Su código de compra es : '.$randomFactura.'<br/>
								Despues de realizar el depósito ingrese <a href = "http://ticketfacil.ec/ticket2/?modulo=deposito&cod='.$idFactura.'" target="_top" >aqui</a>, para validar su pago.
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
		echo $mail;
		echo $content;
		//exit;
		
		
		$ownerEmail = 'fabricio@practisis.com';
		$subject = 'Informacion de Deposito';
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
		$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
		$mail->AddReplyTo('fabricio@practisis.com','TICKETFACIL');
		$mail->AddReplyTo('info@ticketfacil.ec','TICKETFACIL');
		$mail->FromName = 'TICKETFACIL';
		$mail->Subject = $subject;
		$mail->MsgHTML($content);
		//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
		if(!$mail->Send()){
			echo "Mailer Error: " . $mail->ErrorInfo;
			$info = 'no_se_fue';
		}
		else{
			echo 'ok';
			$info = 'se_fue';
		}
		
		//exit;
		header('Location: ../../?modulo=pre_deposito_ok&&error=ok&info='.$info.'');
		$_SESSION['codigoCompra'] = $codigoCompra;
		$_SESSION['content2'] = $content2;
		$_SESSION['content3'] = $content3;
	}
?>
