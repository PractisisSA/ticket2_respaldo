<?php
	session_start();
	$id_usu = $_REQUEST['idUsuario'];
	include '../enoc.php';
	$compras_regreso=$_SESSION['carrito_regreso'];
	$compras=$_SESSION['carrito'];
	
	$array = array_values(array_filter($compras));
	$array2 = array_values(array_filter($compras_regreso));
	
	require_once '../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../PHPM/PHPM/class.smtp.php';
	
	
	$subject = "Reserva en linea";
	date_default_timezone_set("America/Guayaquil");
		
	for($i=0;$i<=count($array)-1;$i++){
		
		$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
		$rand = md5($s.time()).mt_rand(1,10);
		$code = rand(1,9999999999).time();
		$verificador = $code."<<|>>".$rand;
		
		$sql = 'update ocupadas set estado = "p" , id_usu = "'.$id_usu.'"  , numbol = "'.$verificador.'" where id = "'.$array[$i]['product_id'].'" ';
		$res = mysql_query($sql) or die (mysql_error());
		
	}
	
	
	
	for($j=0;$j<=count($array2)-1;$j++){
		
		$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
		$rand = md5($s.time()).mt_rand(1,10);
		$code = rand(1,9999999999).time();
		
		$verificador = $code."<<|>>".$rand;
		
		$sql = 'update ocupadas set estado = "p" , id_usu = "'.$id_usu.'"  , numbol = "'.$verificador.'" where id = "'.$array2[$j]['product_id'].'" ';
		$res = mysql_query($sql) or die (mysql_error());
		
	}
	
		include '../../conexion.php';
		$sqlU = 'select * from Cliente where idCliente = "'.$id_usu.'" ';
		//echo $sqlU;
		$resU = mysql_query($sqlU) or die (mysql_error());
		$rowU = mysql_fetch_array($resU);		
		
		if($id_usu = 59){
			$correo = 'fabricio@practisis.com';
		}else{
			$correo = $rowU['strMailU'];
		}
		
		
		$nombre = $rowU['strNombreU'];
		$cont4 = "<table width = '100%' style = 'color:#58595B;font-size:12px;background-color: rgba(244 , 245 , 245 , 0.9);border-bottom:1px solid #0386A4;'>";
			$cont4.="<tr>";
				$cont4.="<td >";
					$cont4.="<div style ='padding:10px;'>NOMBRES Y APELLIDOS </div>";
					$cont4.="<div class = 'contieneAsientosSeleccionados'>";
						$cont4.="".$rowU['strNombresC']."";
					$cont4.="</div>";
				$cont4.="</td>";
				$cont4.="<td>";
					$cont4.="<div style ='padding:10px;'>N° CEDULA  /  PASAPORTE </div>";
					$cont4.="<div class = 'contieneAsientosSeleccionados'>";
						$cont4.="".$rowU['strDocumentoC']."";
					$cont4.="</div>";
				$cont4.="</td>";
			$cont4.="</tr>";
			$cont4.="<tr>";
				$cont4.="<td>";
					$cont4.="<div style ='padding:10px;'>CORREO </div>";
					$cont4.="<div class = 'contieneAsientosSeleccionados'>";
						$cont4.="".$rowU['strMailC']."";
					$cont4.="</div>";
				$cont4.="</td>";
				$cont4.="<td>";
					$cont4.="<div style ='padding:10px;'>DIRECCIÓN </div>";
					$cont4.="<div class = 'contieneAsientosSeleccionados'>";
						$cont4.="".$rowU['strDireccionC']."";
					$cont4.="</div>";
				$cont4.="</td>";
			$cont4.="</tr>";
			$cont4.="<tr>";
				$cont4.="<td>";
					$cont4.="<div style ='padding:10px;'>MOBIL </div>";
					$cont4.="<div class = 'contieneAsientosSeleccionados'>";
						$cont4.="".$rowU['intTelefonoMovC']."";
					$cont4.="</div>";
				$cont4.="</td>";
				$cont4.="<td>";
					$cont4.="<div style ='padding:10px;'>CONVENCIONAL </div>";
					$cont4.="<div class = 'contieneAsientosSeleccionados'>";
						$cont4.="".$rowU['strTelefonoC']."";
					$cont4.="</div>";
				$cont4.="</td>";
			$cont4.="</tr>";
		$cont4.="</table>";
		
		$_SESSION['cont4'] = $cont4;
		
		//echo $rowU['strTelefonoC'];
		$contenido = $_SESSION['cont4']."<br>".$_SESSION['cont']."<br>".$_SESSION['cont2']."<br>".$_SESSION['cont3'];
		
		// echo $contenido;
		// exit;
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->Username = "info@ticketfacil.ec";
		$mail->Password = "ticketfacil2012";
		$mail->From = "paulaanahi2014@gmail.com";
		$mail->FromName = "SIGT WebServicios";
		$mail->Subject = "Nueva Reserva  : # ".$array[$i]['product_id']." en Reserva de boletos onLine";
		$mail->AltBody = "Informaci&oacute;n de Reserva...";
		$mail->MsgHTML($contenido);
		$mail->addBcc("paulaanahi2014@gmail.com"); 
		$mail->AddAddress($correo, "Información de Reserva");
		$mail->IsHTML(true);
		if(!$mail->Send()){
			echo "Error de envio: " . $mail->ErrorInfo;
		}
		else{
			
		}
	
		echo 'reserva(s) generada(s) con éxito';
?>