<?php
	include '../enoc.php';
	
	$id_coop = $_REQUEST['id_coop'];
	$id_usu = $_REQUEST['id_usu'];
	$nombre_emp = $_REQUEST['nombre_emp'];
	$ruc = $_REQUEST['ruc'];
	$telefono = $_REQUEST['telefono'];
	$email = $_REQUEST['email'];
	$web = $_REQUEST['web'];
	$nom_cont = $_REQUEST['nom_cont'];
	$cel_cont = $_REQUEST['cel_cont'];
	$usuario = $_REQUEST['usuario'];
	$pass = $_REQUEST['pass'];
	$desT = $_REQUEST['desT'];
	$desE = $_REQUEST['desE'];
	$pass_n = md5($pass);
	$inicial = $_REQUEST['inicial'];
	
	if($id_coop != 0 && $id_usu != 0){
		
		$sql = 'update cooperativa set  nom = "'.$nombre_emp.'" ,
										ruc = "'.$ruc.'" ,
										tel = "'.$telefono.'" ,
										email = "'.$email.'" ,
										pag = "'.$web.'" ,
										cont = "'.$nom_cont.'" ,
										cel_cont = "'.$cel_cont.'" ,
										dcto_tra = "'.$desT.'" ,
										dcto_e = "'.$desE.'",
										inicial = "'.$inicial.'"
										
										where id = "'.$id_coop.'"
										';
		$res = mysql_query($sql) or die (mysql_error());
		include '../../conexion.php';
		$sql2 = 'update Usuario set strMailU = "'.$usuario.'" , strContrasenaU = "'.$pass_n.'" where idUsuario = "'.$id_usu.'" ';
		$res2 = mysql_query($sql2) or die (mysql_error());
		echo 'cooperativa actualizada con Éxito';
	}else{
		include '../../conexion.php';
		$sql1 = "INSERT INTO `Usuario` (`idUsuario`, `strNombreU`, `strMailU`, `strContrasenaU`, `strRandContrasena`, `strCedulaU`, `strDireccionU`, `strCiudadU`, `strProvinciaU`, `strTelU`, `intfijoU`, `strPerfil`, `strObsCreacion`, `strObsCambio`, `strEstadoU`, `creationbyU`, `modifybyU`, `fechaCreacionU`, `fechaModificacionU`, `idsocio`, `tipo_emp`) VALUES
				(null ,'".$nombre_emp."', '".$usuario."', '".$pass_n."', 'ok', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'Socio_coo', 'n/a', 'n/a', 'Activo', 1, 'n/a', 'n/a', 'n/a', 0, 1)";
		$res1 = mysql_query($sql1) or die (mysql_error());
		
		$id_usuario = mysql_insert_id();
		include '../enoc.php';
		$sql = 'INSERT INTO `cooperativa` (`id`, `nom`, `ruc`, `tel`, `email`, `pag`, `cont`, `cel_cont`, `dcto_tra`, `dcto_e`, `id_usu`, `est` , `inicial`) 
				VALUES (NULL, "'.$nombre_emp.'", "'.$ruc.'", "'.$telefono.'", "'.$email.'", "'.$web.'", "'.$nom_cont.'", "'.$cel_cont.'", "'.$desT.'", "'.$desE.'", "'.$id_usuario.'", "1" , "'.$inicial.'")';
		//echo $sql;
		$res = mysql_query($sql) or die (mysql_error());
		
		if($res1 && $res){
			echo 'Cooperativa creada con Éxito';
		}else{
			echo 'error usted es un imbecil!!!';
		}
	}
	
?>