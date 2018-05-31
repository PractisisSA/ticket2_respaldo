<?php
	include 'conexion.php';
	date_default_timezone_set("America/Guayaquil");
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	
	
	$nuevafecha = strtotime ( '+13 hour' , strtotime ( $hora ) ) ;
	$nuevafecha = date ( 'H:i:s' , $nuevafecha );
	 
	echo $nuevafecha."<br>";
	
	$sql = 'select * from Concierto where dateFecha >= "'.$fecha.'" and timeHora<= "'.$nuevafecha.'" ';
	echo $sql;
?>