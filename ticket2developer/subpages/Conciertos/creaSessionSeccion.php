<?php
	session_start();
	$id_area_mapa = $_REQUEST['id_area_mapa'];
	$_SESSION['id_area_mapa'] = $id_area_mapa;
	echo $_SESSION['id_area_mapa'];
?>