<?php 
	session_start();
	$modulo = $_REQUEST['id'];
	$modulo = base64_decode($modulo);
	if($_SESSION['autentica'] == 'tFSp777'){
		if($modulo == 1){
			$_SESSION['modulo'] = 'sri';
			header("Location: ../?modulo=ingresoSP");
		}else if($modulo == 2){
			$_SESSION['modulo'] = 'ticket';
			header("Location: ../?modulo=ingresoSP");
		}
	}else if($_SESSION['autentica'] == 'SA456'){
		if($modulo == 1){
			$_SESSION['modulo'] = 'sri';
			header("Location: ../?modulo=ingresoAdmin");
		}else if($modulo == 2){
			$_SESSION['modulo'] = 'ticket';
			header("Location: ../?modulo=ingresoAdmin");
		}
	}
?>