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
	
	$dir1 = $_POST['dir1'];
	$tel1 = $_POST['tel1'];
	$cel1 = $_POST['cel1'];
	$ident1 = $_POST['ident1'];
	
	
	echo $ident1."<br>";
	if($ident1 == 1){
		$sqlUC = 'update Cliente set strDireccionC = "'.$dir1.'" , strTelefonoC  = "'.$tel1.'", intTelefonoMovC = "'.$cel1.'" where idCliente = "'.$id_cli.'" ';
		// echo $sqlUC;
		$resUC = mysql_query($sqlUC) or die (mysql_error());
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
	$total_pago = $_POST['total_pagar'];
	
	
	
	$cant_boletos = $_POST['num_boletos'];
	$codigoCompra='';
	
	$query1 = "SELECT * FROM Concierto where idConcierto = ?";
	$result = $gbd -> prepare($query1);
	$result -> execute(array($idConcierto));
	$row1 = $result -> fetch(PDO::FETCH_ASSOC);
	$e = $row1['strEvento'];
	$tiene_permisos = $row1['tiene_permisos'];
	
	// echo "(((".$total_pago." - ".$row1['envio']." * ".$row1['porce_transfer'].")/100) + ".$row1['comis_transfer'].") <br>";  
	if($ident1 == 1){
		if($row1['porce_transfer'] != 0 || $row1['comis_transfer'] != 0){
			$comis_transfer = ($total_pago + (((($total_pago) * $row1['porce_transfer'])/100) + $row1['comis_transfer']));
			$totalComision = (((($total_pago) * $row1['porce_transfer'])/100) + $row1['comis_transfer']);
		}else{
			$comis_transfer = $total_pago;
			$totalComision = 0;
		}
	}else{
		if($row1['porce_transfer'] != 0 || $row1['comis_transfer'] != 0){
			$comis_transfer = ($total_pago + (((($total_pago) * $row1['porce_transfer'])/100) + $row1['comis_transfer']));
			$totalComision = (((($total_pago) * $row1['porce_transfer'])/100) + $row1['comis_transfer']);
		}else{
			$comis_transfer = $total_pago;
			$totalComision = 0;
		}
	}
	// echo $comis_transfer."<br>";
	// echo $totalComision;
	
	
	$randomFactura = mt_rand();
	$codigoFactura = $randomFactura;
	$urlbar = 'https://ticketfacil.ec/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$codigoFactura.'';
	$imgbar = 'barcode/'.$codigoFactura.'.png';
	file_put_contents($imgbar, file_get_contents($urlbar));
	foreach($_POST['codigo'] as $key=>$cod_loc){
		
	}
	
	$sqlLo = 'SELECT * FROM Localidad where idLocalidad = "'.$cod_loc.'" ';
	$resLo = mysql_query($sqlLo) or die (mysql_error());
	$rowLo = mysql_fetch_array($resLo);
	
	
	
	$hoy = date("Y-m-d");
	$dateFechaPreventa = $row1['dateFechaPreventa'];
	if($hoy <= $dateFechaPreventa){
		$precioLocalidad = $rowLo['doublePrecioPreventa'];
	}else{
		$precioLocalidad = $rowLo['doublePrecioL'];
	}
		
		
	$sqlFa = '	INSERT INTO factura (id, tipo, rand, id_cli, idConc , localidad , valor , estadoPV , estadopagoPV,pventa) 
				VALUES (NULL, "1", "'.$randomFactura.'", "'.$id_cli.'" , "'.$idConcierto.'" , "'.$cod_loc.'" , "'.$comis_transfer.'" , "Revisado" , "reserva" ,"'.$ident1.'")';
	$resFa = mysql_query($sqlFa) or die (mysql_error());
	
	$idFactura = mysql_insert_id();
	
	function hexadecimalAzar($caracteres){

		$caracteresPosibles = "01234567890987654321";
		$azar = '';

		for($i=0; $i<$caracteres; $i++){

			$azar .= $caracteresPosibles[rand(0,strlen($caracteresPosibles)-1)];

		}

		return $azar;

	}
	
	$random = hexadecimalAzar(13);
	
	if(isset($_POST['codigo'])){
		foreach($_POST['codigo'] as $key=>$cod_loc){
			
			$urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$random.'';
			$imgbar = 'barcode/'.$random.'.png';
			file_put_contents($imgbar, file_get_contents($urlbar));
			
			$sqlNum = 'select strCaracteristicaL from Localidad where idLocalidad = "'.$cod_loc.'" ';
			$resNum = mysql_query($sqlNum) or die (mysql_error());
			$rowNum = mysql_fetch_array($resNum);
			if($rowNum['strCaracteristicaL'] == 'Asientos numerados'){
				$boletosok = 'SELECT * FROM ocupadas WHERE row = "'.$_POST['row'][$key].'" AND col = "'.$_POST['col'][$key].'" AND local = "'.$cod_loc.'" AND concierto = "'.$idConcierto.'" ';
				$bolok = $gbd -> prepare($boletosok);
				$bolok -> execute();
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
			
			$query = "INSERT INTO Deposito VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ? , ? , ?)";
			$res = $gbd -> prepare($query);
			$res -> execute(array('NULL',$numero,$fecha,$_POST['row'][$key],$_POST['col'][$key],$id_cli,$idConcierto,$cod_loc,$random,$_POST['num'][$key],$estado,$est_deposito,'SN','NULL','NULL' , $idFactura , $_SESSION['id_area_mapa'],$_POST['pre'][$key]));
			
			$selectPrecio = "SELECT doublePrecioL FROM Localidad WHERE idLocalidad = ?";
			$resultPrecio = $gbd -> prepare($selectPrecio);
			$resultPrecio -> execute(array($cod_loc));
			$rowPrecio = $resultPrecio -> fetch(PDO::FETCH_ASSOC);
			
			$suma += $rowPrecio['doublePrecioL'];
			$precio_normal = number_format($suma, 2,'.','');
			
		
			$query1 = "SELECT * FROM Concierto where idConcierto = ?";
			$result = $gbd -> prepare($query1);
			$result -> execute(array($idConcierto));
			$row1 = $result -> fetch(PDO::FETCH_ASSOC);
			$e = $row1['strEvento'];
			$totalpreventa = '';
			$totalnormal = '';
			$diferencia = $precio_normal - $comis_transfer;
			
			
			
			if($_POST['es_para_membresia'][$key] == 1){
				$sqlCM = 'INSERT INTO `compras_membresias` (
																`id`, 
																`id_cli`, 
																`id_loc`, 
																`id_con`, 
																`valor`, 
																`id_desc`, 
																`canti`, 
																`fecha` , 
																`tipo` , 
																`id_pv_dep`
															) 
													VALUES (
																NULL, 
																"'.$id_cli.'" , 
																"'.$_POST['codigo'][$key].'" , 
																"'.$idConcierto.'" , 
																"'.$_POST['val_desc'][$key].'" , 
																"'.$_POST['id_desc'][$key].'" , 
																"1" , 
																"'.$hoy.'" , 
																"'.$_POST['tipo'][$key].'" ,
																"'.$idFactura.'" 
															)';
				$resCM = mysql_query($sqlCM) or die(mysql_error());
			}
			
		}
		include '../../conexion.php';

		$sqlCu = 'SELECT * FROM cuenta';
		$resCu = mysql_query($sqlCu) or die (mysql_error());
		$rowCu = mysql_fetch_array($resCu);
		
		$content = '
			<html>
				<head>
					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
				</head>
				<body>
					<page style="font-family:corbel; background-color:#868e96;">
					<div class="jumbotron">
					<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;">
							<tr>
								<td style="text-align:center;">
									<a href="http://www.lcodigo.com/ticket"><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" /></a>
								</td>
							</tr>
							<tr>
								<div class="alert alert-success" role="alert">
								  Gracias por utilizar Ticketfacil.ec!
								</div>
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
										* Para el evento : <strong>'.$e.'</strong>
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
											$sumaAsientos =0;
										foreach($_POST['chair'] as $llave=>$asientos){
											$sumaAsientos += $_POST['pre'][$llave];
										$content.= "<tr>
														<td style ='border :1px solid #ccc;'>".$_POST['chair'][$llave]."</td>
														<td style ='border :1px solid #ccc;'>   Localidad : ".$rowLo['strDescripcionL']."  </td>
														<td style ='border :1px solid #ccc;'> Precio : ".$_POST['pre'][$llave]."</td>
													</tr>";
										}
										
										$envio = $row1['envio'];
											if($ident1 == 1){
					$content.='				<tr>
												<td colspan = "2"></td>
												<th >
													<span style="color:#EC1867;"><strong>SubTotal :  $'.$sumaAsientos.'</strong></span>
												</th>
											</tr>
											
											<tr>
												<td colspan = "2"></td>
												<th >
													<span style="color:#EC1867;"><strong>Costo Envio : $'.$envio.'</strong></span>
												</th>
											</tr>
											<tr>
												<th colspan = "2" align ="right">
													
												</th>
												<td>
													<span style="color:#EC1867;"><strong>Comisión de Transacción :  
													$'.number_format(($totalComision),2).'</strong></span>
												</td>
											</tr>
											<tr>
												<th colspan = "2" align ="right">
													
												</th>
												<td>
													<h3 style="color:#EC1867;"><strong>Total :  
													$'.number_format(($comis_transfer),2).'</strong></h3>
												</td>
											</tr>
											';
											}else{
					$content.='				<tr>
												<td colspan = "2"></td>
												<th >
													<span style="color:#EC1867;"><strong>SubTotal :  $'.$sumaAsientos.'</strong></span>
												</th>
											</tr>
											
											<tr>
												<td colspan = "2"></td>
												<th >
													<span style="color:#EC1867;"><strong>Costo Envio : $ 0 </strong></span>
												</th>
											</tr>
											<tr>
												<th colspan = "2" align ="right">
													
												</th>
												<td>
													<span style="color:#EC1867;"><strong>Comisión de Transacción :  
													$'.number_format(($totalComision),2).'</strong></span>
												</td>
											</tr>
											<tr>
												<th colspan = "2" align ="right">
													
												</th>
												<td>
													<h3 style="color:#EC1867;"><strong>Total :  
													$'.number_format(($comis_transfer),2).'</strong></h3>
												</td>
											</tr>';						
											}
										
					$content.='		</table>
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
										Despues de realizar el depósito ingrese <a href = "https://www.ticketfacil.ec/ticket2/?modulo=deposito&cod='.$idFactura.'" target="_blank" >aqui</a>, para validar su pago.
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
					</div>
					</page>
					<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
					<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
				</body>
			</html>
			';
		
		echo $content;
		// exit; 
		$ownerEmail = 'info@ticketfacil.ec';
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
		$mail->AddCC("fabricio@practisis.com", "copia de boletos x deposito");
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
		$_SESSION['codigoCompra'] = $codigoCompra;
		$_SESSION['content2'] = $content2;
		$_SESSION['content3'] = $content3;
	}
?>
