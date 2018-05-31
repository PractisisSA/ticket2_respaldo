<?php 
	//require_once('../../classes/private.db.php');
	include '../../conexion.php';
	
	
	//$gbd = new DBConn();
	
	$cedula = $_REQUEST['cedula'];
	$anio = $_REQUEST['anio'];
	$mes = $_REQUEST['mes'];
	$dia = $_REQUEST['dia'];
	$celular = $_REQUEST['celular'];
	if($dia <= 9){
		$dia2 = "0".$dia;
	}else{
		$dia2 = $dia;
	}
	$fecha = $anio.'-'.$mes.'-'.$dia2;
	
	$sql = 'SELECT count(idCliente) as cuantos , strMailC FROM Cliente WHERE strDocumentoC = "'.$cedula.'" AND strFechaNanC = "'.$fecha.'" AND intTelefonoMovC = "'.$celular.'" order by idCliente DESC limit 1';
	//echo $sql;
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	if($row['cuantos'] == 0){
		echo 'error';
	}else{
		$mail = $row['strMailC'];
		echo $mail;
	}
	
		
	
?>