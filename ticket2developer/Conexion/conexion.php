<?php
	$mysqli = new mysqli('localhost', 'root', 'zuleta99', 'ticket') or die(mysqli_error());
	if(mysqli_connect_errno()){
		echo 'Conexion fallida: '.mysqli_connect_error();
		exit();
	}
?>