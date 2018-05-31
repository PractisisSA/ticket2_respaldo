<?php
	include 'conexion.php';
	echo '<input type="hidden" id="data" value="46" />';
	$data = $_REQUEST['pcx'];
	$r = scandir('../../img/pcx_pruebas');
	$d = scandir('../../img/pcx_viejos_pruebas');

	foreach ($r as $key) {
		echo $key;
	}
	foreach ($d as $key1) {
		echo $key1;
	}
	$re = unlink('../../img/pcx_pruebas/'.$data.'');
	if ($re) {
		echo 1;
	}
?>