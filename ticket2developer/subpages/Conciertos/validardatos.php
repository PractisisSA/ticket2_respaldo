<?php 
	require_once('../../classes/private.db.php');
	session_start();
	$gbd = new DBConn();
	
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	$pass = md5($pass);
	
	$select = "SELECT * FROM Cliente WHERE strMailC = ? AND strContrasenaC = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($login,$pass));
	
	$num_reg = $stmt -> rowCount();
	
	if($num_reg > 0){
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);
		$id = $row['idCliente'];
		$nom = $row['strNombresC'];
		$doc = $row['strDocumentoC'];
		$ciudad = $row['strCiudadC'];
		$pro = $row['strProvinciaC'];
		$fijo = $row['strTelefonoC'];
		$tel = $row['intTelefonoMovC'];
		$mail = $row['strMailC'];
		$dir = $row['strDireccionC'];
		$formP = $row['strFormPagoC'];
		$formEnvio = $row['strEnvioC'];
		$contrasena = $row['strContrasenaC'];
		$fecha_nac = $row['strFechaNanC'];
		$genero_cli = $row['strGeneroC'];
		
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
		echo 'ok';
	}else{
		echo 'error';
	}
?>