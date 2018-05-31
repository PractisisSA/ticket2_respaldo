<?php
	session_start();
	$con = $_GET['con'];
	if(isset($_POST['documento'])){
		$nombre = $_POST['nombre'];
		$doc = $_POST['documento'];
			$anio = $_POST['anio'];
			$mes = $_POST['mes'];
			$dia = $_POST['dia'];
		$fecha = $anio.'-'.$mes.'-'.$dia;
		$ciudad = $_POST['ciudad'];
		$prov = $_POST['prov'];
		$telf = $_POST['telfijo'];
		$telm = $_POST['tmov'];
		$dir = $_POST['dir'];
		$fpago = $_POST['pago'];
		$mail = $_POST['mail'];
		$passw = $_POST['password'];
		$genero = $_POST['genero'];
		$envio = $_POST['obtener_boleto'];
		$s = "SELECT strDocumentoC, strMailC FROM Cliente WHERE strDocumentoC = '$doc' AND strMailC = '$mail'" or die(mysqli_error());
		$r = $mysqli->query($s);
		if($r > 0){
			$ins = "INSERT INTO Cliente VALUES(NULL, '$nombre', '$mail', '$passw', '$doc', '$dir', '$fecha', '$genero', '$ciudad', '$prov', '$telf', '$telm', '$fpago', '$envio', NULL)" or die(mysqli_error());
			$result = $mysqli->query($ins);
			$ult_cliente = mysqli_insert_id($mysqli); 
			$select = "SELECT * FROM Cliente WHERE idCliente = '$ult_cliente'" or die(mysqli_error());
			$res = $mysqli->query($select);
			$row = mysqli_fetch_array($res);
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
			if(!$contrasena){
				echo '<script>alert("Tus Datos son erroneos");window.location.href="../Conciertos/des_concierto.php?con='.$con.'";</script>';
			}else{
				$_SESSION['autentica'] = 'SIP';
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
				echo "<script>alert('Bienvenido a TICKETFACIL');</script>";
			}
		}else{
			echo "<script>
					alert('Tu Mail ya existe');
					window.location.href = '../Conciertos/des_concierto.php?con=".$con."';
				</script>";
		}
	}
	if($_SESSION['autentica'] != 'SIP'){
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$sql = "SELECT * FROM Cliente WHERE strMailC = '$user' AND strContrasenaC = '$pass'" or die(mysqli_error());
		$resultLogin = $mysqli->query($sql);
		$num_registro = mysqli_num_rows($resultLogin);
		if($num_registro > 0){
			$row = mysqli_fetch_array($resultLogin);
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
			
			$_SESSION['autentica'] = 'SIP';
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
			echo "<script>alert('Bienvenido a TICKETFACIL');</script>";
		}else{
			echo "<script>
					window.location.href = '../Conciertos/des_concierto.php?con=".$con."';
					alert('Tus Datos son erroneos');
				</script>";
		}
	}
	if(isset($_POST['mail_cli'])){
		$id_cliente = $_SESSION['id'];
		$name_cliente = $_POST['nombre_cli'];
		$doc_cliente = $_POST['doc_cli'];
		$mail_cliente = $_POST['mail_cli'];
		$fecha_cliente = $_POST['fecha_cli'];
		$genero_cliente = $_POST['genero_cli'];
		$fijo_cliente = $_POST['fijo'];
		$movil_cliente = $_POST['movil'];
		$forma_pago = $_POST['form_pago'];
		$forma_envio = $_POST['envio'];
		$direccion_cliente = $_POST['dir_cli'];
		$ciudad_cliente = $_POST['ciudad_cli'];
		$prov_cliente = $_POST['prov_cli'];
		$updateCliente = "UPDATE Cliente SET strNombresC = '$name_cliente', strMailC = '$mail_cliente', strDocumentoC = '$doc_cliente',
		strDireccionC = '$direccion_cliente', strFechaNanC = '$fecha_cliente', strGeneroC = '$genero_cliente', strCiudadC = '$ciudad_cliente',
		strProvinciaC = '$prov_cliente', strTelefonoC = '$fijo_cliente', intTelefonoMovC = '$movil_cliente', strFormPagoC = '$forma_pago'
		strEnvioC = '$forma_envio' WHERE idCliente = '$id_cliente'" or die('Error'.mysqli_error($mysqli));
		$resultUpdateCliente = $mysqli->query($updateCliente);
		$_SESSION['username'] = $name_cliente;
		$_SESSION['userdoc'] = $doc_cliente;
		$_SESSION['userciudad'] = $ciudad_cliente;
		$_SESSION['userprov'] = $prov_cliente;
		$_SESSION['usertel'] = $movil_cliente;
		$_SESSION['usertelf'] = $fijo_cliente;
		$_SESSION['usermail'] = $mail_cliente;
		$_SESSION['userdir'] = $direccion_cliente;
		$_SESSION['formapago'] = $forma_pago;
		$_SESSION['formenvio'] = $forma_envio;
		$_SESSION['fech_nac'] = $fecha_cliente;
		$_SESSION['genero'] = $genero_cliente;
	}
	include("../controlusuarios/seguridadusuario.php");
	$query = "SELECT strImagen, strEvento, dateFecha, timeHora, strLugar FROM Concierto WHERE idConcierto = '$con'" or die(mysqli_error());
	echo '<input type="hidden" value="'.$con.'" id="idConcierto"/>';
	$result = $mysqli->query($query);
?>