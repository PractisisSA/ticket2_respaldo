<?php 
	header("Access-Control-Allow-Origin: *");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	foreach(explode('@', $_GET['datos']) as $valor){
		$exp = explode('|', $valor);
		try{
			$update = "UPDATE Boleto SET strEstado = ? WHERE idBoleto = ?";
			$stmt = $gbd -> prepare($update);
			$stmt -> execute(array($exp[1],$exp[0]));
			echo 'datos subidos';
		}catch(PDOException $e){
			print_r($e);
		}
	}
?>