<?php
	session_start();
	include 'conexion.php';
	$id_face = $_REQUEST['id_face'];
	$email_face = $_REQUEST['email_face'];
	//echo $id_face."<<>>".$email_face;
	$name = $_REQUEST['nombre'];
	$birthday = $_REQUEST['birthday'];
	$gender = $_REQUEST['gender'];
	$fecha = explode("/",$birthday);
	$anio = $fecha[2];
	$mes = $fecha[1];
	$dia = $fecha[0];
	
	if($gender == 'male'){
		$sexo = 'Masculino';
	}elseif($gender == 'female'){
		$sexo = 'Femenino';
	}
	$fnac = $anio."-".$mes."-".$dia;
	
	//$pass = md5($pass);
	$sqlC = 'SELECT * FROM Cliente WHERE strMailC = "'.$email_face.'" AND clave_face = "'.$id_face.'" ';
	//echo $sqlC;
	
	$resC = mysql_query($sqlC) or die (mysql_error());
	if(mysql_num_rows($resC) == 0 || mysql_num_rows($resC) == ''){
		//echo 'no hay';
		$sqlC1 = 'insert into Cliente (strNombresC , strMailC , strContrasenaC , strDocumentoC , strFechaNanC , strGeneroC , clave_face) values ("'.$name.'" , "'.$email_face.'" , "e10adc3949ba59abbe56e057f20f883e" , "1212121212" , "'.$fnac.'" , "'.$sexo.'" , "'.$id_face.'" ) ';
		//echo $sqlC1;
		$resC1 = mysql_query($sqlC1) or die (mysql_error());
		$id_cli = mysql_insert_id();
		$sqlC2 = 'SELECT * FROM Cliente WHERE idCliente = "'.$id_cli.'"';
		$resC2 = mysql_query($sqlC2) or die (mysql_error());
		$rowCliente = mysql_fetch_array($resC2);
		
		$id = htmlspecialchars($rowCliente['idCliente']);
		$nom = htmlspecialchars($rowCliente['strNombresC']);
		$doc = htmlspecialchars($rowCliente['strDocumentoC']);
		$ciudad = htmlspecialchars($rowCliente['strCiudadC']);
		$pro = htmlspecialchars($rowCliente['strProvinciaC']);
		$fijo = htmlspecialchars($rowCliente['strTelefonoC']);
		$tel = htmlspecialchars($rowCliente['intTelefonoMovC']);
		$mail = htmlspecialchars($rowCliente['strMailC']);
		$dir = htmlspecialchars($rowCliente['strDireccionC']);
		$formP = htmlspecialchars($rowCliente['strFormPagoC']);
		$formEnvio = htmlspecialchars($rowCliente['strEnvioC']);
		$contrasena = htmlspecialchars($rowCliente['strContrasenaC']);
		$fecha_nac = htmlspecialchars($rowCliente['strFechaNanC']);
		$genero_cli = htmlspecialchars($rowCliente['strGeneroC']);
		
	}else{
		$rowCliente = mysql_fetch_array($resC);
		$id = htmlspecialchars($rowCliente['idCliente']);
		$nom = htmlspecialchars($rowCliente['strNombresC']);
		$doc = htmlspecialchars($rowCliente['strDocumentoC']);
		$ciudad = htmlspecialchars($rowCliente['strCiudadC']);
		$pro = htmlspecialchars($rowCliente['strProvinciaC']);
		$fijo = htmlspecialchars($rowCliente['strTelefonoC']);
		$tel = htmlspecialchars($rowCliente['intTelefonoMovC']);
		$mail = htmlspecialchars($rowCliente['strMailC']);
		$dir = htmlspecialchars($rowCliente['strDireccionC']);
		$formP = htmlspecialchars($rowCliente['strFormPagoC']);
		$formEnvio = htmlspecialchars($rowCliente['strEnvioC']);
		$contrasena = htmlspecialchars($rowCliente['strContrasenaC']);
		$fecha_nac = htmlspecialchars($rowCliente['strFechaNanC']);
		$genero_cli = htmlspecialchars($rowCliente['strGeneroC']);
	}
	
	
	
	$_SESSION['autentica'] = 'uzx153';
	$_SESSION['id'] = $id;
	$_SESSION['username'] = $nom;
	$_SESSION['userdoc'] = $doc;
	$_SESSION['userciudad'] = $ciudad;
	$_SESSION['userprov'] = $pro;
	$_SESSION['usertel'] = $tel;
	$_SESSION['usertelf'] = $fijo;
	$_SESSION['usermail'] = $mail;
	$_SESSION['userdir'] = $dir;
	$_SESSION['formapago'] = $formP;
	$_SESSION['formenvio'] = $formEnvio;
	$_SESSION['fech_nac'] = $fecha_nac;
	$_SESSION['genero'] = $genero_cli;
	$_SESSION['perfil'] = 'cliente';
	$_SESSION['id'];
	//echo 'Bienvenido '.$name.' , tu usuario de acceso es : '.$email_face.' y el pass es : 123456 , sesion usuario : '.$_SESSION['id'].' sesion email : '.$_SESSION['usermail'].'';
?>