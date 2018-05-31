<?php
session_start();

	$compras = $_SESSION['carrito'];
	$contiene_pos_ = $_POST['contiene_pos_'];
	for($i=0;$i<=count($compras)-1;$i++){
		unset($compras[$contiene_pos_]);
	}
	$compras = array_values($compras);
	$_SESSION['carrito'] = $compras;
?>