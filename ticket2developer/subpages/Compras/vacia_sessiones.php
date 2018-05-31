<?php
	session_start();
	unset($_SESSION['boletos_asignados']);
	$_SESSION['boletos_asignados'] = 0;
	$_SESSION['boletos_asignados'] = null;
	$compras = array_values($_SESSION['boletos_asignados']);
	echo $compras;
?>