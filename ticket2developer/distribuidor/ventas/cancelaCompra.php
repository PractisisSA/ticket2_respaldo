<?php
	session_start();
	unset($_SESSION['carrito']);
	echo 'Compra cancelada con éxito \n Deberá volver a seleccionar los asientos!!!';
?>