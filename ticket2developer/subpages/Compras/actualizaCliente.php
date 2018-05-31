<?php
	session_start();
	$id_cliente = $_SESSION['id'];
	include '../../conexion.php';
	
	$nombre = $_REQUEST['nombre'];
	$documento = $_REQUEST['documento'];
	$mail = $_REQUEST['mail'];
	$fecha = $_REQUEST['fecha'];
	$fijo = $_REQUEST['fijo'];
	$movil = $_REQUEST['movil'];
	
	
	
	
	$sql = 'update Cliente set 
							strNombresC = "'.$nombre.'" ,
							strDocumentoC  = "'.$documento.'" ,
							strMailC  = "'.$mail.'" ,
							strFechaNanC  = "'.$fecha.'" ,
							strTelefonoC  = "'.$fijo.'" ,
							intTelefonoMovC  = "'.$movil.'"
			where idCliente  = "'.$id_cliente.'" 
			';
	$res = mysql_query($sql) or die(mysql_error());
	if($res){
		echo 1;
		$_SESSION['username'] = $nombre;
		$_SESSION['userdoc'] = $documento;
		$_SESSION['usermail'] = $mail;
		$_SESSION['fech_nac'] = $fech_nac;
		$_SESSION['usertelf'] = $fijo;
		$_SESSION['usertel'] = $movil;
	}else{
		echo 0;
	}
?>