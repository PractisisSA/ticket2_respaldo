<?php
	include '../../conexion.php';
	
	$bco = $_REQUEST['bco'];
	$tipo = $_REQUEST['tipo']; 
	$cta = $_REQUEST['cta'];
	$tit = $_REQUEST['tit'];
	$ced = $_REQUEST['ced'];
	
	$sql = 'update cuenta set tipo = "'.$tipo.'" , 
							  bco = "'.$bco.'" ,
							  num = "'.$cta.'" ,
							  nom = "'.$tit.'" ,
							  ced = "'.$ced.'" 
			';
	$res = mysql_query($sql) or die(mysql_error());
	if($res){
		echo 'Datos Actualizados con Éxito';
	}else{
		echo 'error!!!';
	}
	
?>