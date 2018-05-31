<?php
	include '../conexion.php';
	
	$idUsu = $_REQUEST['idUsu'];
	$id_modulo = $_REQUEST['id_modulo'];
	$ident = $_REQUEST['ident'];
	
	if($ident == 0){
		$sql = 'update Concierto set porcentajetarjetaC = "0" where idConcierto = "'.$id_modulo.'" ';
		$txt = 'Evento Desactivado con éxito';
	}else{
		$sql = 'update Concierto set porcentajetarjetaC = "'.$idUsu.'" where idConcierto = "'.$id_modulo.'" ';
		$txt = 'Evento Activado con éxito';
	}
	
	$res = mysql_query($sql) or die (mysql_error());
	if($res){
		echo $txt;
	}else{
		echo 'Error';
	}
?>