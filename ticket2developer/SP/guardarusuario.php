<?php
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadSP.php");
	require_once('../classes/private.db.php');
	require_once '../PHPM/PHPM/class.phpmailer.php';
	require_once '../PHPM/PHPM/class.smtp.php';
	
	$gbd = new DBConn();
	
	$creador = $_SESSION['iduser'];
	$id = 'NULL';
	$nom = $_POST['nombre'];
	$ape = $_POST['apellido'];
	$nombre = $nom.' '.$ape;
	$mailUser = $_POST['usuario'];
	$cedula = $_POST['cedula'];
	$contrasena = 'ok';
	$randContrasena = md5($cedula);
	$ciudad = $_POST['ciudad'];
	$provincia = $_POST['provincia'];
	$direccion = $_POST['direccion'];
	$movil = $_POST['movil'];
	$fijo = $_POST['fijo'];
	$perfil = $_POST['perfil'];
	
	if($perfil == 'cadena-comercial'){
		$tipo_emp = 2;
		$perfil = 'Distribuidor';
	}elseif($perfil == 'ventas-ticket-facil'){
		$tipo_emp = 1;
		$perfil = 'Distribuidor';
	}
	else{
		$tipo_emp = 1;
		$perfil = $perfil;
	}
	$obs = $_POST['obs'];
	$obsCambio = 'Ninguno';
	$estado = 'Activo';
	$modificado = 'No Modificado';
	$fecha = date('Y-m-d H:i:s');
	$fechamod = 'No modificado';
	$selectUsuario = "SELECT * FROM Usuario WHERE strMailU = ?";
	$slt = $gbd -> prepare($selectUsuario);
	$slt -> execute(array($mailUser));
	$resultok = $slt -> rowCount();
	$campo = 'Todos';
	$idlog = 'NULL';
	$acccion = 'Insercion';
	$antes = 'Todos';
	$despues = 'Todos';
	
	$selectEmp = "SELECT razonsocialTF FROM ticktfacil";
	$sltemp = $gbd -> prepare($selectEmp);
	$sltemp -> execute();
	$rowemp = $sltemp -> fetch(PDO::FETCH_ASSOC);
	$nombreEmpresa = $rowemp['razonsocialTF'];
	
	if($resultok > 0){
		echo 'error';
	}else{
		try{
			$insertUsuario = "INSERT INTO Usuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ? , ?)";
			$stmt = $gbd -> prepare($insertUsuario);
			$stmt -> execute(array($id,$nombre,$mailUser,$randContrasena,$contrasena,$cedula,$direccion,$ciudad,$provincia,$movil,$fijo,$perfil,$obs,$obsCambio,$estado,$creador,$modificado,$fecha,$fechamod , 0 , $tipo_emp));
			$userafect = $gbd -> lastInsertId();
			
			$insertlog = "INSERT INTO logusuario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$userafect,$acccion,$campo,$antes,$despues,$estado));
			
			$content = '
			<page>
				<br>
				<p align="center">'.$nombreEmpresa.'</p>
				<br>
				<br>
				<p align="center">Estimado <strong>'.$nombre.'</strong> le proporcionamos la siguiente información:</p>
				<br>
				<br>
				<p align="left">* Su nombre de usuario es: <strong>'.$mailUser.'</strong></p>
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
			$mail->AddAddress($mailUser,$nombre);
			$mail->AddCC('fabricio@practisis.com', 'nuevo usuario');
			$mail->AddAddress($ownerEmail,'TICKETFACIL');
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content);
			// $mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
			if(!$mail->Send()){
				
			}
			else{
				
			}
			echo $userafect;
		}
		catch(PDOException $e){
			print_r($e);
		}
	}
?>