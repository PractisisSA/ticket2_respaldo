<?php
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadSP.php");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$fecha = date('Y-m-d H:i:s');
	$creador = $_SESSION['iduser'];
	$sector = $_POST['identificador'];
	
	if($sector == 1){
		if($_POST['valoresbd'] != ''){
			foreach(explode('@', $_POST['valoresbd']) as $value){
				$exp = explode('|',$value);
				
				$select = "SELECT * FROM sucursal_empresa WHERE idSE = ?";
				$slt = $gbd -> prepare($select);
				$slt -> execute(array($exp[0]));
				$row = $slt -> fetch(PDO::FETCH_ASSOC);
				$des = 'Direccion '.$row['descripcionSE'];
				$dirbd = $row['direccionSE'];
				$direccionbd = strtolower($dirbd);
				
				$direccionpos = $exp[1];
				$direccionpos = strtolower($direccionpos);
				
				if($direccionpos != $direccionbd){
					$update = "UPDATE sucursal_empresa SET direccionSE = ? WHERE idSE = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($exp[1],$exp[0]));
					
					$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					$ins = $gbd -> prepare($insert);
					$ins -> execute(array('NUL',$fecha,$creador,1,'Modificacion',$des,$dirbd,$exp[1],'Empresa','Activo'));
				}
			}
		}
		
		if($_POST['valores'] != ''){
			foreach(explode('@', $_POST['valores']) as $valor){
				$expo = explode('|',$valor);
				$insert = "INSERT INTO sucursal_empresa VALUES (?, ?, ?, ?, ?, ?)";
				$ins = $gbd -> prepare($insert);
				$ins -> execute(array('NULL',1,$expo[0],$expo[1],$expo[2],'Activo'));
				
				if($expo[2] > 0){
					$des = 'Direccion Sucursal';
				}else{
					$des = 'Direccion Matriz';
				}
				
				$insert1 = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$ins1 = $gbd -> prepare($insert1);
				$ins1 -> execute(array('NUL',$fecha,$creador,1,'Insercion',$des,'Todos',$expo[0],'Empresa','Activo'));
			}
		}
		
		echo 'ok';
	}
	
	if($sector == 2){
		$id = $_POST['id'];
		
		try{
			$sql = "UPDATE sucursal_empresa SET estadoSE = ? WHERE idSE = ?";
			$stmt = $gbd -> prepare($sql);
			$stmt -> execute(array('Inactivo',$id));
			
			$insert = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$ins = $gbd -> prepare($insert);
			$ins -> execute(array('NUL',$fecha,$creador,$id,'Modificacion','Estado Direccion','Activo','Inactivo','Empresa','Activo'));
			echo 'ok';
		}catch(PDOException $e){
			print_r($e);
		}
	}
?>