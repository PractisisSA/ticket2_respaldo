<?php
	session_start();
	date_default_timezone_set('America/Guayaquil');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	
	$hoy = date("Y-m-d H:i:s");
	require_once('../../stripe/lib/Stripe.php');
	Stripe::setApiKey('sk_test_6GSRONySlv39WktvlN4ZloaH');
	
	$quien_vendio_boleto = 1;
	$valorPago = 2;
	
	
	$token = $_REQUEST['token'];
	$total = $_REQUEST['total'];
	$id_usu = base64_decode($_SESSION['sesion_usuario']);
	
	
	$preciocents = ($total * 100);
	$cobroExitoso = false;
	$evento = 'Cobro bus';
	try{
		$charge = Stripe_Charge::create(array(
			'amount' => $preciocents,
			'currency' => 'usd',
			'card' => $token,
			'description' => $evento
			));

		$cobroExitoso = true;
		$purchaseID = $charge->id;
		// echo $purchaseID;
		// echo 'ok';
	}
	catch(Exception $e){
		$error = $e->getMessage();
		echo $error;
		
	}
	
	
	include('../../html2pdf/html2pdf/html2pdf.class.php');
	require_once '../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../PHPM/PHPM/class.smtp.php';
	
	include '../../conexion.php';
	$sqlU = 'select * from Usuario where idUsuario = "'.base64_decode($_SESSION['sesion_usuario']).'" ';
	$resU = mysql_query($sqlU) or die (mysql_error());
	$rowU = mysql_fetch_array($resU);		
	$correo = $rowU['strMailU'];
	$nombre = $rowU['strNombreU'];
	
	//echo $correo."<br/>";
	$compras_regreso=$_SESSION['carrito_regreso'];
	$compras=$_SESSION['carrito'];
	
	$array = array_values(array_filter($compras));
	$array2 = array_values(array_filter($compras_regreso));
	
	print_r($array)."<br>";
	print_r($array2)."<br>";
	
	function obtenerFechaEnLetra($fecha){

	$dia= conocerDiaSemanaFecha($fecha);

	$num = date("j", strtotime($fecha));

	$anno = date("Y", strtotime($fecha));

	$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

	$mes = $mes[(date('m', strtotime($fecha))*1)-1];

	return $dia.', '.$num.' de '.$mes.' del '.$anno;

}

 

function conocerDiaSemanaFecha($fecha) {

	$dias = array('Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado');

	$dia = $dias[date('w', strtotime($fecha))];

	return $dia;

}
	if($cobroExitoso === true){
		include '../enoc.php';
		for($i=0;$i<=count($array)-1;$i++){
		
		$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
		$rand = md5($s.time()).mt_rand(1,10);
		$code = rand(1,9999999999).time();
		$verificador = $code."<<|>>".$rand;
		
		$sql = 'update ocupadas set estado = "p" , id_usu = "'.$id_usu.'"  , numbol = "'.$verificador.'" where id = "'.$array[$i]['product_id'].'" ';
		echo $sql."<br>";
		$res = mysql_query($sql) or die (mysql_error());
		
		$sqlO = 'select * from ocupadas where id = "'.$array[$i]['product_id'].'" ';
		$resO = mysql_query($sqlO) or die (mysql_error());
		$rowO = mysql_fetch_array($resO);
		$asiento = $rowO['asiento'];
		$fecha = $rowO['fecha_salida'];
		$id_ruta = $rowO['id_ruta'];
		
		$sqlR = 'select * from ruta where id = "'.$id_ruta.'" ';
		$resR = mysql_query($sqlR) or die (mysql_error());
		$rowR = mysql_fetch_array($resR);
		$origen = $rowR['origen'];
		$destino = $rowR['destino'];
		$coop = $rowR['coop'];
		
		$sale = $rowR['hora'];
		$llega = $rowR['hora_llega'];
		
		$sqlCoo = 'select * from cooperativa where id = "'.$coop.'" ';
		$resCoo = mysql_query($sqlCoo) or die (mysql_error());
		$rowCoo = mysql_fetch_array($resCoo);
		$cooperativa = $rowCoo['nom'];
		
		$sqlC1 = 'select * from ciudades where id = "'.$origen.'" ';
		$resC1 = mysql_query($sqlC1) or die (mysql_error());
		$rowC1 = mysql_fetch_array($resC1);
		$ciuSalida = $rowC1['nom'];
		
		$sqlC2 = 'select * from ciudades where id = "'.$destino.'" ';
		$resC2 = mysql_query($sqlC2) or die (mysql_error());
		$rowC2 = mysql_fetch_array($resC2);
		$ciuLlegada = $rowC2['nom'];
		
        $subject = "Pago en linea";
		date_default_timezone_set("America/Guayaquil");
        
        $content = '
			<page>
				<div style="padding-top:20px;padding-bottom:20px; border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;background-image:url(http://lcodigo.com/sigt/imagenes/busFondo.jpg);background-size: cover;background-repeat: no-repeat;">
				<table align="center" style="width:90%; border-collapse:separate; border-spacing:15px 5px;font-size:11px;color:#000;font-weight:bold;background:rgba(255,255,255,0.7);">
					<tr>
						<td style="text-align:center;">
							Estimado <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$nombre.'</span> 
							<br/>Esto es un comprobante de Pago en l&iacute;nea :
						</td>
					</tr>
					
					<tr>
						<td>
							
						</td>
					</tr>
					<tr>
						<td valign="middle" align="left">
							Nos complace comunicarle que su asiento  <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;font-size:20px;"> # '.$asiento.'</span>
							en la cooperativa <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$cooperativa.'</span><br/>
							para la ruta <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$ciuSalida.' </span>
							<span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$ciuLlegada.'</span><br/>
							para el d&iacute;a : <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.obtenerFechaEnLetra($fecha).'</span>  <br/>
							a las :  <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$sale.'</span>  esta Pagado<br/>
							
						</td>
					</tr>
					
					<tr>
						<td valign="middle" align="center">
							<img src = "http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'"  />
						</td>
					</tr>
					<tr>
						<td valign="middle" align="center">
							<img src = "https://chart.googleapis.com/chart?cht=b&chd=t:60,40&chs=250x100&chl='.$code.'"  style="display:none;"/>
							su codigo de boleto es : 
							<center><span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$code.'</span></center>
						</td>
					</tr>
					
					<tr>
						<td valign="middle" align="center">
							Le recordamos que debe estar 15 minutos antes para el proceso de abordaje<br>
							Debe portar este documento impreso para poder ingresar a la unidad<br/><br/>
							Ha sido un placer atenderle , disfrute su viaje.<br/><br/>
							Ticketfacil la mejor experiencia de compra en l&iacute;nea
						</td>
					</tr>
					
				</table>
				</div>
			</page>';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->Username = "fabricio@practisis.com";
		$mail->Password = "freddylabanda";
		$mail->From = "paulaanahi2014@gmail.com";
		$mail->FromName = "SIGT WebServicios";
		$mail->Subject = "Nueva Pago  : # ".$array[$i]['product_id']." en Pago de boletos onLine";
		$mail->AltBody = "Informaci&oacute;n de Pago...";
		$mail->MsgHTML($content);
		$mail->addBcc("paulaanahi2014@gmail.com"); 
		$mail->AddAddress($correo, "Información de Pago");
		$mail->IsHTML(true);
		if(!$mail->Send()){
			echo "Error de envio: " . $mail->ErrorInfo;
		}
		else{
			echo 'envio1';
		}
	}
	
	
	
	for($j=0;$j<=count($array2)-1;$j++){
		
		$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
		$rand = md5($s.time()).mt_rand(1,10);
		$code = rand(1,9999999999).time();
		
		$verificador = $code."<<|>>".$rand;
		
		$sql = 'update ocupadas set estado = "p" , id_usu = "'.$id_usu.'"  , numbol = "'.$verificador.'" where id = "'.$array2[$j]['product_id'].'" ';
		echo $sql."<br>";
		$res = mysql_query($sql) or die (mysql_error());
		
		$sqlO = 'select * from ocupadas where id = "'.$array2[$j]['product_id'].'" ';
		$resO = mysql_query($sqlO) or die (mysql_error());
		$rowO = mysql_fetch_array($resO);
		$asiento = $rowO['asiento'];
		$fecha = $rowO['fecha_salida'];
		$id_ruta = $rowO['id_ruta'];
		
		$sqlR = 'select * from ruta where id = "'.$id_ruta.'" ';
		$resR = mysql_query($sqlR) or die (mysql_error());
		$rowR = mysql_fetch_array($resR);
		$origen = $rowR['origen'];
		$destino = $rowR['destino'];
		$coop = $rowR['coop'];
		
		$sale = $rowR['hora'];
		$llega = $rowR['hora_llega'];
		
		$sqlCoo = 'select * from cooperativa where id = "'.$coop.'" ';
		$resCoo = mysql_query($sqlCoo) or die (mysql_error());
		$rowCoo = mysql_fetch_array($resCoo);
		$cooperativa = $rowCoo['nom'];
		
		$sqlC1 = 'select * from ciudades where id = "'.$origen.'" ';
		$resC1 = mysql_query($sqlC1) or die (mysql_error());
		$rowC1 = mysql_fetch_array($resC1);
		$ciuSalida = $rowC1['nom'];
		
		$sqlC2 = 'select * from ciudades where id = "'.$destino.'" ';
		$resC2 = mysql_query($sqlC2) or die (mysql_error());
		$rowC2 = mysql_fetch_array($resC2);
		$ciuLlegada = $rowC2['nom'];
		
        $subject = "Pago en linea";
		date_default_timezone_set("America/Guayaquil");
        
        $content2 = '
			<page>
				<div style="padding-top:20px;padding-bottom:20px; border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;background-image:url(http://lcodigo.com/sigt/imagenes/busFondo.jpg);background-size: cover;background-repeat: no-repeat;">
				<table align="center" style="width:90%; border-collapse:separate; border-spacing:15px 5px;font-size:11px;color:#000;font-weight:bold;background:rgba(255,255,255,0.7);">
					<tr>
						<td style="text-align:center;">
							Estimado <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$nombre.'  '.$apellido.'</span> 
							<br/>Esto es un comprobante de Pago en l&iacute;nea :
						</td>
					</tr>
					
					<tr>
						<td>
							
						</td>
					</tr>
					<tr>
						<td valign="middle" align="left">
							Nos complace comunicarle que su asiento  <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;font-size:20px;"> # '.$asiento.'</span>
							en la cooperativa <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$cooperativa.'</span><br/>
							para la ruta <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$ciuSalida.' </span>
							<span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$ciuLlegada.'</span><br/>
							para el d&iacute;a : <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.obtenerFechaEnLetra($fecha).'</span>  <br/>
							a las :  <span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$sale.'</span>  esta Pagado<br/>
							
						</td>
					</tr>
					
					<tr>
						<td valign="middle" align="center">
							<img src = "http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'"  />
						</td>
					</tr>
					<tr>
						<td valign="middle" align="center">
							<img src = "https://chart.googleapis.com/chart?cht=b&chd=t:60,40&chs=250x100&chl='.$code.'"  style="display:none;"/>
							su codigo de boleto es : 
							<center><span style="text-transform:uppercase;font-weight:bold;color:#2A406F;">'.$code.'</span></center>
						</td>
					</tr>
					<tr>
						<td valign="middle" align="center">
							Le recordamos que debe estar 15 minutos antes para el proceso de abordaje<br>
							Debe portar este documento impreso para poder ingresar a la unidad<br/><br/>
							Ha sido un placer atenderle , disfrute su viaje.<br/><br/>
							Ticketfacil la mejor experiencia de compra en l&iacute;nea
						</td>
					</tr>
				</table>
				</div>
			</page>';
		// echo $content2;
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->Username = "fabricio@practisis.com";
		$mail->Password = "freddylabanda";
		$mail->From = "paulaanahi2014@gmail.com";
		$mail->FromName = "SIGT WebServicios";
		$mail->Subject = "Nueva Pago  : # ".$array2[$j]['product_id']." en Pago de boletos onLine";
		$mail->AltBody = "Informaci&oacute;n de Pago...";
		$mail->MsgHTML($content2);
		$mail->addBcc("paulaanahi2014@gmail.com"); 
		$mail->AddAddress($correo, "Información de Pago");
		$mail->IsHTML(true);
		if(!$mail->Send()){
			echo "Error de envio: " . $mail->ErrorInfo;
		}
		else{
			echo 'envio2';
		}
	}
	
	echo 'Pago(s) generada(s) con éxito';
	}else{
		echo 'no valio';
	}
	
?>