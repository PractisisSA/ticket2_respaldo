<?php
	include '../conexion.php';
	
	$idUsu = $_REQUEST['idUsu'];
	$id_modulo = $_REQUEST['id_modulo'];
	$ident = $_REQUEST['ident'];
	
	if($ident == 0){
		$sql = 'delete from modulo_admin where id = "'.$id_modulo.'" ';
		$txt = 'Modulo eliminado con éxito';
	}else{
		$sql = 'insert into modulo_admin (id_usuario , id_modulo) values ("'.$idUsu.'","'.$id_modulo.'")';
		$txt = 'Modulo ingresado con éxito';
	}
	$res = mysql_query($sql) or die (mysql_error());
	
	if($res){
		echo $txt;
	}else{
		echo 'error';
	}
?>