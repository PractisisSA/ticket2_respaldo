<?php
	session_start();
	include 'conexion.php';
	$id_gmail = $_REQUEST['id_gmail'];
	$email_gmail = $_REQUEST['email_gmail'];
	//echo $id_gmail."<<>>".$email_gmail;
	$name = $_REQUEST['nombre'];
	$birthday = $_REQUEST['birthday'];
	$gender = $_REQUEST['gender'];
	$today = date("Y-m-d"); 
	$fecha = explode("-",$today);
	$anio = $fecha[2];
	$mes = $fecha[1];
	$dia = $fecha[0];
	$gender = 'Male';
	if($gender == 'male'){
		$sexo = 'Masculino';
	}elseif($gender == 'female'){
		$sexo = 'Femenino';
	}
	$fnac = $anio."-".$mes."-".$dia;
	
	//$pass = md5($pass);
	$sqlC = 'SELECT * FROM Cliente WHERE strMailC = "'.$email_gmail.'" AND clave_face = "'.$id_gmail.'" ';
	//echo $sqlC;
	
	$resC = mysql_query($sqlC) or die (mysql_error());
	if(mysql_num_rows($resC) == 0 || mysql_num_rows($resC) == ''){
		//echo 'no hay';
		$sqlC1 = 'insert into Cliente (strNombresC , strMailC , strContrasenaC , strDocumentoC , strFechaNanC , strGeneroC , clave_face) 
		values ("'.$name.'" , "'.$email_gmail.'" , "e10adc3949ba59abbe56e057f20f883e" , "" , "'.$fnac.'" , "'.$sexo.'" , "'.$id_gmail.'" ) ';
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
	//echo 'Bienvenido '.$name.' , tu usuario de acceso es : '.$email_gmail.' y el pass es : 123456 , sesion usuario : '.$_SESSION['id'].' sesion email : '.$_SESSION['usermail'].'';
?>