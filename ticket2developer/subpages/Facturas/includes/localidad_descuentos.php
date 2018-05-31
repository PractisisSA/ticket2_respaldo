<?php
	session_start();
	include('../../../conexion.php');
	ini_set('display_errors', 'On');
    error_reporting(E_ALL);
	$nom_desc = $_GET['term'];
	$localidad = $_GET['localidad'];
	
	$expLo = explode('-',$localidad);
	
	
	$sql = 'SELECT * FROM `descuentos` WHERE `idloc` = "'.$expLo[0].'" AND `nom` LIKE "%'.$nom_desc.'%" ORDER BY `id` ASC ';
	
	// echo $sql;
	$res = mysql_query($sql);
	
	$sqlLo = 'select * from Localidad where idLocalidad = "'.$expLo[0].'" ';
	$resLo = mysql_query($sqlLo) or die (mysql_error());
	$rowLo = mysql_fetch_array($resLo);
	
	
	$data[] = "0-Ninguno-".$rowLo['doublePrecioL'];
	while($row = mysql_fetch_array($res)){
		
		$data[] .= $row['id']."-".$row['nom']."-".$row['val'];
	}
	echo json_encode($data);
	?>
	
	