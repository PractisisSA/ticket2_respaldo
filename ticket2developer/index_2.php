<?php
	session_start();
	header('Access-Control-Allow-Origin: *');
	$con = $_REQUEST['con'];
	
	if(isset($_REQUEST['link'])){
		$_SESSION['imagen_logo'] = 'https://www.ecutickets.ec/images/ecu-logo.png';
		
	}else{
		$_SESSION['imagen_logo'] = 'gfx/logo.png';
	}
	
	header('Location: http://ticketfacil.ec/ticket2/index_ecu.php');
	exit;
?>