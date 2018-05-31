<?php 
	session_start();
	session_destroy();
	header("Location: http://ticketfacil.ec/ticket2/index_ecu.php");
?>