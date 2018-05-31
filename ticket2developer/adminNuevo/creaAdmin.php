<?php
	include '../conexion.php';
	$nom_admin = $_REQUEST['nom_admin'];
	$usu_admin = $_REQUEST['usu_admin'];
	$pass_admin = md5($_REQUEST['pass_admin']);
	$modulosCheckF = $_REQUEST['modulosCheckF'];
	$eventosCheckF = $_REQUEST['eventosCheckF'];
	$socio = $_REQUEST['socio'];
	
	$sql = 'select count(idUsuario) as cuantos from Usuario where strMailU = "'.$usu_admin.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	if($row['cuantos'] == 0){
		$sqlU = 'INSERT INTO `Usuario` (`idUsuario`, `strNombreU`, `strMailU`, `strContrasenaU`, `strRandContrasena`, `strCedulaU`, `strDireccionU`, `strCiudadU`, `strProvinciaU`, `strTelU`, `intfijoU`, `strPerfil`, `strObsCreacion`, `strObsCambio`, `strEstadoU`, `creationbyU`, `modifybyU`, `fechaCreacionU`, `fechaModificacionU`, `idsocio`, `tipo_emp`) VALUES
				(null, "'.$nom_admin.'", "'.$usu_admin.'", "'.$pass_admin.'", "ok", "1716620818", "Carcelen Bajo", "6", "10", "0998553416", "022804555", "Admin_Socio", "Crear y modificar conciertos del socio", "Ninguno", "Activo", 1, "1", "2015-04-27 11:38:26", "No modificado", 0, 1)';
		$resU = mysql_query($sqlU) or die (mysql_error());
		
		// $idUsuario = 56;
		$idUsuario = mysql_insert_id(); //56;
		
		$expMod = explode("|",$modulosCheckF);
		$expEve = explode("@",$eventosCheckF);
		
		for($i=0;$i<=(count($expMod)-1);$i++){
			//echo $expMod[$i]."<br>";
			$sqlM = '	INSERT INTO `modulo_admin` (`id`, `id_usuario`, `id_modulo`, `socio`) 
						VALUES (NULL, "'.$idUsuario.'", "'.$expMod[$i].'", "'.$socio.'")';
			//echo $sqlM."<br>";
			$resM = mysql_query($sqlM) or die (mysql_error());
		}
		
		//echo '<br><hr><br>';
		
		for($j=0;$j<=(count($expEve)-1);$j++){
			//echo $expEve[$j]."<br>";
			$sqlC = 'UPDATE `Concierto` SET `porcentajetarjetaC` = "'.$idUsuario.'" WHERE `Concierto`.`idConcierto` = "'.$expEve[$j].'"; ';
			 
			//echo $sqlC."<br>";
			$resC = mysql_query($sqlC) or die (mysql_error());
		}
		
		if($resU){
			echo 'Nuevo Admin Creado Con Exito';
		}
	}else{
		echo 'El usuario : '.$usu_admin.' ya existe , cree otro!!!';
	}
			
?>