<?php	
	session_start();
	
	$contenido = $_SESSION['cont']."<br>".$_SESSION['cont2']."<br>".$_SESSION['cont3'];
	
	echo $contenido;
?>