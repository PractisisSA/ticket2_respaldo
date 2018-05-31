<?php 
	header("Access-Control-Allow-Origin: *");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	foreach(explode('@', $_GET['datos']) as $valor){
		$exp = explode('|', $valor);
		try{
			$select = "SELECT * FROM auditoria_movil WHERE idabajoAM = ?";
			$slt = $gbd -> prepare($select);
			$slt -> execute(array($exp[0]));
			$numregs = $slt -> rowCount();
			if($numregs == 0){
				$update = "INSERT INTO auditoria_movil VALUES (?, ?, ?, ?, ?)";
				$stmt = $gbd -> prepare($update);
				$stmt -> execute(array('NULL',$exp[0],$exp[2],$exp[1],$exp[3]));
			}
			echo 'datos subidos';
		}catch(PDOException $e){
			print_r($e);
		}
	}
?>