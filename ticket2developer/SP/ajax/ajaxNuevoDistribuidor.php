<?php 
	date_default_timezone_set('America/Guayaquil');
	//include("../../controlusuarios/seguridadSP.php");
	require_once('../../classes/private.db.php');
	require_once '../../PHPM/PHPM/class.phpmailer.php';
	require_once '../../PHPM/PHPM/class.smtp.php';
	include '../../conexion.php';
	
	$gbd = new DBConn();
	
	$section = $_POST['identificador'];
	
		
	$id = 'NULL';
	$nombre = $_POST['nombre'];
	$documento = $_POST['documento'];
	$telefono = $_POST['telefono'];
	$email = $_POST['mail'];
	$estado = 'Activo';
	$dir = $_POST['dir'];
	$contacto = $_POST['contacto'];
	$porcentajeventas = $_POST['porcentajeventas'];
	$socio = $_POST['socio'];
	$tarjetas = $_POST['tarjetas'];
	$movil = $_POST['movil'];
	$observaciones = $_POST['observaciones'];
	$tipoEmp = $_POST['tipoEmp'];
	$tipoEmp2 = $_POST['tipoEmp2'];
	$randContrasena = md5($documento);
	$fecha = date("Y/m/d H:i:s");
	$content = '';
	$tipos = $_POST['tipos'];
	$pass = $_POST['password'];
	
	if($tipoEmp2 == 1 || $tipoEmp2 == 2){
		$tipo_dist = 'Distribuidor';
	}else{
		$tipo_dist = 'Distribuidor_impresiones';
	}
	$sqlU = 'select count(idUsuario) as cuantos from Usuario where strMailU = "'.$email.'" ';
	$resU = mysql_query($sqlU) or die (mysql_error());
	$rowU = mysql_fetch_array($resU);
	if($rowU['cuantos'] == 0){
		try{
			$contra = md5($pass);
			$insert = "INSERT INTO distribuidor VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array('NULL',$nombre,$documento,$telefono,$email,$contacto,$movil,$dir,$observaciones,$porcentajeventas,$socio,$tipoEmp2,$estado));
			$idDis = $gbd -> lastInsertId();
		if($tipoEmp2 != 3){
			foreach(explode('@', $_POST['valoresDis']) as $value){
				$exp = explode('|',$value);
				$insert2 = "INSERT INTO detalle_distribuidor VALUES (?, ?, ?, ?)";
				$ins2 = $gbd -> prepare($insert2);
				$ins2 -> execute(array('NULL',$idDis,$exp[0],$estado));
			}
		}	
			$insert3 = "INSERT INTO Usuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
			$ins3 = $gbd -> prepare($insert3);
			$ins3 -> execute(array('NULL',$nombre,$email,$contra,'ok',$documento,$dir,12,18,$movil,$telefono,$tipo_dist,$idDis,'Ninguno','Activo',1,'No Modificado',$fecha,$tipos,0,$tipoEmp));
			
			$content = '
			<page>
				<p align="center"><a href="http://www.lcodigo.com/ticket"><img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" /></a></p>
				<br>
				<br>
				<p align="center"><strong>Bienvenido(a) a TICKETFACIL</strong></p>
				<br>
				<br>
				<p align="center">Estimado <strong>'.$contacto.'</strong> de la empresa <strong>'.$nombre.'<br>Su usuario es: '.$email.'<br> Su clave es: '.$pass.'</strong></p>
				<br>
				<br>
				<p align="left"><strong>Estos son tus datos para ingresar a TICKETFACIL</strong></p>
				<br>
				<br>
				<p align="left">* Su nombre de usuario es: <strong>'.$email.'</strong></p>
				<br>
				<br>
				<p align="left">* Su contraseña es: <strong>123456</strong></p>
				<br>
				<br>
				<p align="left">* Debera cambiar su contraseña en el transcurso de los dias</p>
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
			
			$ownerEmail = 'info@ticketfacil.ec';
			$subject = 'Bienvenido a TICKETFACIL';
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
			$mail->AddAddress($email,$nombre);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content);
			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else{
				echo 'ok';
			}
			
		}catch(PDOException $e){
			// echo 'error';
			// print_r($e);
		}
	}else{
		echo 'existe';
	}
	
?>