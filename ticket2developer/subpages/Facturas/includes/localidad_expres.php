<?php
	session_start();
	include('../../../conexion.php');
	ini_set('display_errors', 'On');
    error_reporting(E_ALL);
	$localidad = $_GET['term'];
	$concert = $_GET['concert'];
	$sql = 'SELECT * FROM `Localidad` WHERE `strDescripcionL` LIKE "%'.$localidad.'%" AND `idConc` = '.$concert.' ORDER BY `idLocalidad` ASC ';
	// echo $sql;
	$res = mysql_query($sql);
	
	$data = array();
	while($row = mysql_fetch_array($res)){
		
		$data[] = $row['idLocalidad']."-".$row['strDescripcionL']."-".$concert;
	}
	echo json_encode($data);
	?>
	
	