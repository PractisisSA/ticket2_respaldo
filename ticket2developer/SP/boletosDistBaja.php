<?php
	date_default_timezone_set('America/Guayaquil');
	error_reporting(0);
	$conexion = mysql_connect("localhost", "root", "zuleta99")or die(mysql_error());
	mysql_set_charset('UTF8',$conexion);
	mysql_select_db("ticket", $conexion)or die(mysql_error());

	$distribuidor = $_REQUEST['eventDistribuidor'];
	$sql = 'SELECT * FROM Usuario WHERE strObsCreacion = '.$distribuidor.'';
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);
	$idUsuario = $row['idUsuario'];
	$sqlBoletos = 'SELECT * FROM Boleto WHERE id_usu_venta = '.$idUsuario.'';
	$resBoletos = mysql_query($sqlBoletos);
	echo $sqlBoletos;
	while ($row = mysql_fetch_array($resBoletos)) {
		echo $row['idCon'];
	}

?>