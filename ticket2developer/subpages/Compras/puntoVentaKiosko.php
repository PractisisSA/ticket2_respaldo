<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<?php
	session_start();
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
	
	$idConcierto = $_GET['evento'];
	
	
	//require_once('classes/private.db.php');id_cliente
	$id_cliente = $_POST['cliente_kiosko_id'];
	$nombre_cli = $_POST['cliente_kiosko'];
	$documento_cli = $_POST['cliente_kiosko_ced'];
	$cliente_kiosko_dir = $_POST['cliente_kiosko_dir'];
	$cliente_kiosko_mail = $_POST['cliente_kiosko_mail'];
	$cliente_kiosko_movil = $_POST['cliente_kiosko_movil'];
	$fechatime = date("Y-m-d H:i:s");
	$pass = md5($documento_cli);
	$gbd = new DBConn();
	
	
	
	if($_POST['cliente_kiosko_id'] == 'no'){
		include 'conexion.php';
		$sqlCl = 'select * from Cliente where strDocumentoC = "'.$documento_cli.'" order by idCliente desc limit 1';
		$resCl = mysql_query($sqlCl) or die (mysql_error());
		if(mysql_num_rows($resCl)>0){
			$rowCl = mysql_fetch_array($resCl);
			$id_cliente = $rowCl['idCliente'];
		}else{
			$insert = "INSERT INTO Cliente VALUES ('NULL','".$nombre_cli."','".$cliente_kiosko_mail."','".$pass."','".$documento_cli."','".$cliente_kiosko_dir."','2000-01-01','Agregar Genero','Agregar Ciudad','Agregar Provincia','Agregar Numero','".$cliente_kiosko_movil."',0,'0','si','".$fechatime."','0')";
			//echo $insert."<br>";
			$ins = $gbd -> prepare($insert);
			$ins -> execute();
			$id_cliente = $gbd -> lastInsertId();
		}
	}
	
	$numero = 0;
	$fecha = 0;
	$status = 2;
	$estado = "Revisar";
	$est_deposito = "No";
	$pagopor = 3;
	$fechahoy = date('Y-m-d');
	
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
	$total_pago = $_POST['total_pagar'];
	$cant_boletos = $_POST['num_boletos'];
	if(isset($_POST['codigo'])){
		$select1 = "SELECT * FROM Cliente WHERE idCliente = ?";
		$slt1 = $gbd -> prepare($select1);
		$slt1 -> execute(array($id_cliente));
		$row = $slt1 -> fetch(PDO::FETCH_ASSOC);
		$envio = $row['strEnvioC'];
		$dir = $row['strDireccionC'];
		$email = $row['strMailC'];
		$nom = $row['strNombresC'];
		// if($envio == 'Domicilio'){
			// $envio = 'A tu Domicilio';
			// $dir = $row['strDireccionC'];
		// }else if($envio == 'correo'){
			// $envio = 'Correo Electronico';
			// $dir = $email;
		// }else if($envio == 'p_venta'){
			// $envio = 'Punto de Venta';
			// $dir = 'Cualquiera de nuestros Puntos de Venta';
		// }
		
		
		$query1 = "SELECT * FROM Concierto where idConcierto = ?";
		$result = $gbd -> prepare($query1);
		$result -> execute(array($idConcierto));
		$row1 = $result -> fetch(PDO::FETCH_ASSOC);
		$e = $row1['strEvento'];
		$tiene_permisos = $row1['tiene_permisos'];
		
		
		
		
		include '../../conexion.php';
		
		
		
		
		
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
		
		$sqlCod_bar = 'SELECT * FROM `codigo_barras` WHERE id_con = "'.$idConcierto.'" and utilizado = 0 order by id ASc ';
			
		// $resCod_bar = mysql_query($sqlCod_bar) or die (mysql_error());
		// $rowCod_bar = mysql_fetch_array($resCod_bar);
		// $randomFactura = $rowCod_bar['codigo'];
		// echo $randomFactura."<br>";
		
		$randomFactura = mt_rand();
		$codigoFactura = $randomFactura;
		$urlbar = 'http://ticketfacil.ec/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$codigoFactura.'';
		$imgbar = 'barcode/'.$codigoFactura.'.png';
		file_put_contents($imgbar, file_get_contents($urlbar));
		
		
		$sqlFa = 'INSERT INTO factura (id, tipo, rand, id_cli, idConc , localidad , valor , estadoPV , estadopagoPV , impresion_local , id_dist) VALUES (NULL, "2", "'.$randomFactura.'", "'.$id_cliente.'" , "'.$idConcierto.'" , "'.$cod_loc.'" , "'.$total_pago.'" , "Revisado" , "reserva" , "0" , "'.$_SESSION['idDis'].'")';
		echo $sqlFa."<br>";
		$resFa = mysql_query($sqlFa) or die (mysql_error());
		
		$idFactura = mysql_insert_id();
		
		
		$sqlUpCodBar = 'update codigo_barras set utilizado = "1" where codigo = "'.$randomFactura.'" ';
		$resUpCodBar = mysql_query($sqlUpCodBar);
		
		
		foreach($_POST['codigo'] as $key=>$cod_loc){
			
			$random = mt_rand();
			
			
			 
			if($_SESSION['valida_ocupadas'] == 1){
				$boletosok = "SELECT * FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
				$bolok = $gbd -> prepare($boletosok);
				$bolok -> execute(array($_POST['row'][$key],$_POST['col'][$key],$cod_loc,$idConcierto));
				$numbolok = $bolok -> rowCount();
				if($numbolok > 0){
					echo 'error';
					header('Location: ../../?modulo=preventaok&error='.$idConcierto.'');
					return false;
				}
				
				
				$insertAsientos = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				$resulinsertAsientos = $gbd -> prepare($insertAsientos);
				$resulinsertAsientos -> execute(array('NULL',$_POST['row'][$key],$_POST['col'][$key],$status,$_POST['codigo'][$key],$idConcierto,$pagopor,$descompra));
			}
			
			
			
			
		//	echo $sqlCod_bar."<<>>".$random."<br>";
			
			
			$query = "INSERT INTO pventa VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ? , ? )";
			$res = $gbd -> prepare($query);
			$res -> execute(array('NULL',$numero,$fecha,$_POST['row'][$key],$_POST['col'][$key],$id_cliente,$idConcierto,$cod_loc,$random,$_POST['num'][$key],$estado,$est_deposito,'SN','NULL','NULL' , $idFactura , $_SESSION['id_area_mapa']));
			
			
			
			
			$sql2 = 'SELECT strDescripcionL, doublePrecioL, doublePrecioReserva, doublePrecioPreventa, filaPV, columnaPV, numboletosPV, localidadPV , conciertoPV FROM pventa p JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE codigoPV = "'.$random.'" ';
			$stmt2 = $gbd -> prepare($sql2);
			$stmt2 -> execute();
			$row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
			$costoboleto = $row2['doublePrecioPreventa'];
			
			
			$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$cod_loc.'"';
			$lokRow= $gbd -> prepare($localidad);
			$lokRow -> execute();
			$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
			$doublePrecioL = $rowLoc['doublePrecioL'];
			
			
			
		}
		
		$content = '
		<page>
			<div style="border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;">
				<table align="center" style="width:400px; border-collapse:separate; border-spacing:15px 5px;font-size:11px;" class="table table-hover">
					<tr>
						<td style="text-align:center;" colspan = "3">
							<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="200px"/>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;" colspan = "3">
							Estimado (a) <h3 style="text-transform:capitalize;">'.$nom.'</h3> <br/>Esto es un comprobante de reserva en l&iacute;nea :
						</td>
					</tr>
					<tr>
						<td colspan = "3">
							* Sus asientos estan reservados,
							si el pago se realiza dentro de las siguientes: <strong>'.$row1['tiempopagoC'].'</strong>,
							caso contrario sus asientos seran ELIMINADOS
						</td>
					</tr>
					<tr>
						<td colspan = "3">
							El detalle de su compra es el siguiente : 
								<table width = "90%" >
									<tr>
										<th style ="border :1px solid #ccc;">Asientos</th>
										<th style ="border :1px solid #ccc;">Localidad</th>
										<th style ="border :1px solid #ccc;">Valor Unitario </th>
									</tr>';
								foreach($_POST['chair'] as $llave=>$asientos){
								$content.= "<tr><td style ='border :1px solid #ccc;'>".$_POST['chair'][$llave]."</td><td style ='border :1px solid #ccc;'>   Localidad : ".$rowLo['strDescripcionL']."  </td><td style ='border :1px solid #ccc;'> Precio : ".$precioLocalidad."</td></tr>";
									//$total_pago += ($_POST['num'][$llave] * $_POST['pre'][$llave]);
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
						<td colspan = "3">
							Usted podr&aacute; pagar el valor de sus tickets en '.$row1['locPago'].' que esta ubicado en : '.$row1['dirPago'].'<br/>
							'.$row1['fecha'].' <br/>
							en el horario de : '.$row1['hora'].'<br/><br/>
							Por Favor utilize el siguiente codigo para pagar sus tickets :<br/>
							<center>
								<img src="http://ticketfacil.ec/ticket2/subpages/Compras/barcode/'.$codigoFactura.'.png" /><br/>
								<span style="color:#EC1867;"><strong>'.$codigoFactura.'</strong></span>
							</center>
						</td>
					</tr>
					
					<tr>
						<td colspan = "3">
							Una vez pagada la totalidad de sus TICKETS usted podr&aacute; canjearlos en :'.$row1['dircanjeC'].' 
							desde el dia : '.$row1['fechainiciocanjeC'].' hasta el dia '.$row1['fechafinalcanjeC'].'
							el el horario de : '.$row1['horariocanjeC'].'<br/>
							* Para el concierto de :<center><h3><strong>'.$e.'</strong><h3></center>
							<br/><br/>
						</td>
					</tr>
					<!--
					<tr>
						<td colspan = "3">
							Por favor utilize los codigos escritos a continuacion para canjear sus ticket (Estos códigos solo funcionan si ud a realizado el pago!!!)
						</td>
					</tr>-->';
				// $sqlPv = 'select * from pventa where idFactura = "'.$idFactura.'" ';
				// $resPv = mysql_query($sqlPv) or die (mysql_error());
				// while($rowPv = mysql_fetch_array($resPv)){
		$content.= "<!--
					<tr>
						<td style ='border :1px solid #ccc;'>
							Ticket : ".$rowPv['idPventa']."
						</td>
						<td style ='border :1px solid #ccc;'>   
							Localidad : ".$rowLo['strDescripcionL']."  
						</td>
						<td style ='border :1px solid #ccc;'> 
							".$rowPv['codigoPV']."
						</td>
					</tr>-->";
						//$total_pago += ($_POST['num'][$llave] * $_POST['pre'][$llave]);
				// }
					$content.='
					<tr>
						<td style="text-align:center;" colspan = "3">
							<strong>Gracias por Preferirnos</strong>
							<br>
							<strong>TICKETFACIL <I>"La mejor experiencia de compra En L&iacute;nea"</I></strong>
						</td>
					</tr>
				</table>
			</div>
		</page>';
		
		// echo $content."<br>";
		// echo $randomFactura;
		// //exit;
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
		$mail->AddReplyTo('fabricio@practisis.com','TICKETFACIL');
		$mail->AddReplyTo('info@ticketfacil.ec','TICKETFACIL');
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
			echo 'ok';
			//echo $content."|";
			// $_SESSION['smsPago'] = $content;
			// $_SESSION['content3'] = $content3;
			// $_SESSION['content4'] = $content4;
			header('Location: ../../?modulo=pre_Ventaok&error=ok');
		}
		
	}
?>