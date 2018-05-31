<?php 
include '../conexion.php';
//LIBRERIA PARA EL ENVIO DE CORREO ELECTRONICO//
require_once('../classes/private.db.php');
require_once '../PHPM/PHPM/class.phpmailer.php';
require_once '../PHPM/PHPM/class.smtp.php';

//DECLARACION DE LAS VARIABLES//
$nombre = $_REQUEST['nombre'];
$ruc = $_REQUEST['ruc']; 
$telefono = $_REQUEST['telefono']; 
$mail = $_REQUEST['mail']; 
$direccion = $_REQUEST['direccion']; 
$clave = $_REQUEST['clave']; 
$clave2 = $_REQUEST['clave2']; 

// SI LA CLAVE COINCIDEN//

if ($clave == $clave2){

	//CONVERTIR EN MD5 CONTRASEÑA//
	$contrasena = md5($clave);

	//SELECCIONAR LOS DATOS DE LA EMPRESA 
	$seleccion = mysql_query("SELECT * FROM `ticktfacil`");
	
	$nombreEmpresa = $seleccion;

	//INSERTAR LOS DATOS EN LA TABLA USUARIO// 
	$inseru = mysql_query("INSERT INTO `Usuario` (`strNombreU`, `strMailU`, `strContrasenaU`, `strCedulaU`, `strTelU`, `strDireccionU`) VALUES ('$nombre', '$mail', '$contrasena', '$clave', '$telefono', '$direccion')");

	//SELECCION DE PRUEBA// 
	$sel = mysql_query("SELECT *FROM `Usuario` WHERE `strMailU` = '$mail'");
	$row = mysql_fetch_array($sel);
	$id = $row['idUsuario'];

	//INSERTAR LOS DATOS EN LA TABLA EQUIPO//
	$insertar = mysql_query("INSERT INTO `equipo` (`nombre`, `ruc`, `telefono`, `mail`, `direccion`, `id_usuario` ) VALUES  ('$nombre', '$ruc', '$telefono', '$mail', '$direccion', '$id')");

	

	//SI SE INSERTA EN LA BASE DE DATOS// 
	if ($insertar and $inseru){

		//ENVIAR CORREO ELECTRONICO//

		// CONTENIDO DEL CORREO 
		$content = '
			<page>
				<br>
				<p align="center">'.$nombreEmpresa.'</p>
				<br>
				<br>
				<p align="center">Estimado <strong>'.$nombre.'</strong> le proporcionamos la siguiente información:</p>
				<br>
				<br>
				<p align="left">* Su nombre de usuario es: <strong>'.$mail.'</strong></p>
				<br>
				<br>
				<p align="left">* Su contraseña es: <strong>'.$cedula.'</strong></p>
				<br>
				<br>
				
				<br>
				<br>
				<p align="left">* Ingresa <a href="http://ticketfacil.ec/ticket2/?modulo=login"> aqui </a>  selecciona personal ticket facil para ingresar a tu cuenta y cambiar tu contrase&ntilde;a</p>
				<br>
				<br>
				<p align="center"><I>No entregue sus datos a otras personas, estos datos son de su pleno uso</I></p>
				<br>
				<br>
				<p align="center"><strong>GRACIAS POR PREFERIRNOS</strong></p>
				<br>
			</page>';

			$ownerEmail = 'jonathan@practisis.com';
			$subject = 'Informacion de Cuenta';
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
			$mail->AddAddress($mail,$nombre);
			$mail->AddCC('fabricio@practisis.com', 'nuevo usuario');
			$mail->AddAddress($ownerEmail,'TICKETFACIL');
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content);

		//ENVIAR RESPUESTA OK//
		echo 'ok';
	}

	//SI NO ENVIAR ERROR//
	else {
		echo 'error';
	}

}
?>