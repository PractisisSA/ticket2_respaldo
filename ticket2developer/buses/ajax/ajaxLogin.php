<?php
	session_start();
	
	include '../../conexion.php';
	$usuario = mysql_real_escape_string($_REQUEST['usu_bus']);
	$pass = md5($_REQUEST['pass_bus']);
	
	$sql= 'select * from Usuario where strMailU="'.$usuario.'" and strContrasenaU ="'.$pass.'"';
	// echo $sql."<br>";
	$res = mysql_query($sql) or die (mysql_error());
	if(mysql_num_rows ($res)> 0){
		$row=mysql_fetch_array($res);
		$idUsuario = $row['idUsuario'];
		echo base64_encode($idUsuario);
			$_SESSION['strDireccionU'] = $row['strDireccionU'];
			$_SESSION['strTelU'] = $row['strTelU'];
			$_SESSION['intfijoU'] = $row['intfijoU'];
			$_SESSION['strMailU'] = $row['strMailU'];
			$_SESSION['strCedulaU'] = $row['strCedulaU'];
			$_SESSION['strCedulaU'] = $row['strCedulaU'];
			$_SESSION['idUsuario '] = $idUsuario;
			$_SESSION['hora'] = date("H:i:s");
			$_SESSION['nombre'] = $row['strNombreU'];
			//echo $_SESSION['idUsuario ']."<<>>".$row['strNombreU'];
		//echo 'ok';
	}
	else{
		echo 'error';
	}
?>
	