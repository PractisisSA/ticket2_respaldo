<?php
	include '../../enoc.php';
	$id = $_REQUEST['id'];
	$ident = $_REQUEST['ident'];
	
	if($ident == 2){
		$est = 0;
		$txt = 'Coopetativa Desactivada con exito';
	}else{
		$est = 1;
		$txt = 'Coopetativa Activada con exito';
	}
	$sql = 'update cooperativa set est = "'.$est.'" where id = "'.$id.'" ';
//	echo $sql;
	$res = mysql_query($sql) or die (mysql_error());
	if($res){
		echo $txt;
	}
?>