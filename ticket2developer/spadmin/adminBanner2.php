<?php

	include '../conexion.php';
	$id_con = $_REQUEST['id_con'];
	$action = $_REQUEST['action'];
	if ($action == 1) {
		$sql = 'UPDATE Concierto SET strCaractristica = "home" WHERE idConcierto = '.$id_con.'';
		$res = mysql_query($sql);
	}else{
		$sql = 'UPDATE Concierto SET strCaractristica = "" WHERE idConcierto = '.$id_con.'';
		$res = mysql_query($sql);
	}
	

?>