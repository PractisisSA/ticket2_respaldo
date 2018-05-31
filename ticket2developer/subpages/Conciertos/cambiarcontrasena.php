<?php 
	require_once('../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$codigo = $_POST['codigo'];
	$codigo = base64_decode($codigo);
	$pass = $_POST['pass'];
	$pass = md5($pass);
	
	// print_r($pass.' - '.$codigo);
	try{
		$update = "UPDATE Cliente SET strContrasenaC = ? WHERE strDocumentoC = ?";
		$stmt = $gbd -> prepare($update);
		$stmt -> execute(array($pass,$codigo));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
?>