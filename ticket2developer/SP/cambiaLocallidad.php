<?php
	include '../conexion.php';
	$web = $_REQUEST['web'];
	$pv = $_REQUEST['pv']; 
	$id = $_REQUEST['id'];
	$estadoLocGrat_ = $_REQUEST['estadoLocGrat_'];
	
	
	
	if($web == 1){
		$web1 = 0;
	}else{
		$web1 = 1;
	}
	
	if($pv == 1){
		$pv1 = 0;
	}else{
		$pv1 = 1;
	}
	
	$sql = 'update Localidad set createbyL = "'.$web.'" , fechaCreacionL = "'.$pv.'" , gratuidad = "'.$estadoLocGrat_.'" where idLocalidad = "'.$id.'" ';
	//echo $sql;
	$res = mysql_query($sql) or die (mysql_error());
	
	
	$sql1 = 'update Butaca set createbyB = "'.$web.'" , fechaCreacionB = "'.$pv.'" where intLocalB = "'.$id.'" ';
	//echo $sql;
	$res1 = mysql_query($sql1) or die (mysql_error());
	
	
	//echo $web."<<>>".$pv.">><<".$id;
	echo 'Localidad Modificada con Éxito';
?>