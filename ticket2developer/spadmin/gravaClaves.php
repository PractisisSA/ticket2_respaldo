<?php
	include '../conexion.php';
	$clave_reimp = $_REQUEST['clave_reimp'];
	$clave_reasig = $_REQUEST['clave_reasig'];
	$id_cla = $_REQUEST['id_cla'];
	$ident = $_REQUEST['ident'];
	$id_con = $_REQUEST['id_con'];
	$clave_app = $_REQUEST['clave_app'];
	
	if($ident == 1 ){
		$sql = 'insert into claves (id_con , clave , clave2 , clave3) values ("'.$id_con.'" , "'.$clave_reimp.'" , "'.$clave_reasig.'" , "'.$clave_app.'")';
		$res = mysql_query($sql) or die (mysql_error());
		echo 'claves creadas con Éxito';
	}elseif($ident == 2){
		$sql = 'update claves set clave = "'.$clave_reimp.'" , clave2 = "'.$clave_reasig.'", clave3 = "'.$clave_app.'" where id = "'.$id_cla.'" ';
		$res = mysql_query($sql) or die (mysql_error());
		echo 'claves actualizadas con Éxito';
	}
	
?>