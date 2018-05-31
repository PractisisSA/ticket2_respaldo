<?php
	include '../../enoc.php';
	$id_ciu = $_REQUEST['id_ciu'];
	$nuevoTerminal = $_REQUEST['nuevoTerminal'];
	
	$sql1 = 'SELECT count(id) as cuantos FROM `terminales` WHERE `nombre` = "'.$nuevoTerminal.'" and id_ciu = "'.$id_ciu.'" ';
	$res1 = mysql_query($sql1) or die(mysql_error());
	$row1 = mysql_fetch_array($res1);
	if($row1['cuantos'] == 1){
		echo 'el terminal "'.$nuevoTerminal.'" , ya existe por favor cambie el nombre y vuelva a intentarlo';
	}else{
		$sql = 'INSERT INTO `terminales` (`id`, `id_ciu`, `nombre`) VALUES (NULL, "'.$id_ciu.'", "'.$nuevoTerminal.'")';
		$res = mysql_query($sql) or die (mysql_error());
		if($res){
			echo 'Terminal : "'.$nuevoTerminal.'" creado con Éxito';
		}
	}
	
	
	
	
?>