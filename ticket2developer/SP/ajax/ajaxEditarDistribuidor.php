<?php 
	date_default_timezone_set('America/Guayaquil');
	require_once('../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$hoy = date("y-m-d");
	$section = $_POST['identificador'];
	
	if($section == 1){
		$idDis = $_POST['idDis'];
		
		$sql = "SELECT * FROM distribuidor WHERE idDistribuidor = ?";
		$stmt = $gbd -> prepare($sql);
		$stmt -> execute(array($idDis));
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);
		
		include '../../conexion.php';
		$sqlU = 'select * from Usuario where strObsCreacion = "'.$idDis.'" ';
		$resU = mysql_query($sqlU) or die (mysql_error);
		$rowU = mysql_fetch_array($resU);
		
		$json = '{"Datos":[{ 
			"id" : "'.$row['idDistribuidor'].'", 
			"nombre" : "'.$row['nombreDis'].'",
			"documento" : "'.$row['documentoDis'].'",
			"telefono" : "'.$row['telefonoDis'].'",
			"mail" : "'.$row['mailDis'].'",
			"dir" : "'.$row['direccionDis'].'",
			"movil" : "'.$row['movilDis'].'",
			"contacto" : "'.$row['contactoDis'].'",
			"observaciones" : "'.$row['observacionesDis'].'",
			"pventas" : "'.$row['porcentajeventaDis'].'",
			"pcobros" : "'.$row['porcentajecobroDis'].'",
			"estado" : "'.$row['estadoDis'].'",
			"tarjetaDis" : "'.$row['tarjetaDis'].'",
			"id_socio" : "'.$row['porcentajecobroDis'].'",
			"tipo_emp" : "'.$rowU['tipo_emp'].'"
		}]}';
		
		$sql2 = "SELECT idDet_Dis, strEvento, strImagen, strLugar, timeHora, dateFecha, estadoDet , idConcierto FROM detalle_distribuidor JOIN Concierto 
				ON detalle_distribuidor.conciertoDet = Concierto.idConcierto 
				WHERE idDis_Det = ?
				AND strEstado= ?
				AND estadoDet = ?
				";
		$stmt2 = $gbd -> prepare($sql2);
		$stmt2 -> execute(array($idDis,"Activo","Activo"));
		
		$json2 = '{"DatosEvento":[';
		while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
			$json2 .= '{ 
				"id" : "'.$row2['idDet_Dis'].'", 
				"concierto" : "'.$row2['strEvento'].'",
				"lugar" : "'.$row2['strLugar'].'",
				"fecha" : "'.$row2['dateFecha'].'",
				"hora" : "'.$row2['timeHora'].'",
				"img" : "'.$row2['strImagen'].'",
				"estadoDet" : "'.$row2['estadoDet'].'",
				"idConcierto" : "'.$row2['idConcierto'].'"
			},'; 
        }
        $json2=substr($json2,0,-1);
		$json2.=']}';
		
		$sql3 = "SELECT idConcierto, strEvento, strImagen, strLugar, timeHora, dateFecha FROM Concierto c WHERE c.idConcierto NOT IN(SELECT conciertoDet FROM detalle_distribuidor WHERE idDis_Det = ?) AND c.dateFecha >= ? AND strEstado= ?";
		$stmt3 = $gbd -> prepare($sql3);
		$stmt3 -> execute(array($idDis,$hoy,"Activo"));
		$numconcerts = $stmt3 -> rowCount();
		
		if($numconcerts > 0){
			$json3 = '{"NuevoConcierto":[';
			while($row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC)){
				$json3 .= '{ 
					"idcon" : "'.$row3['idConcierto'].'", 
					"concierto" : "'.$row3['strEvento'].'",
					"lugar" : "'.$row3['strLugar'].'",
					"fecha" : "'.$row3['dateFecha'].'",
					"hora" : "'.$row3['timeHora'].'",
					"img" : "'.$row3['strImagen'].'"
				},'; 
			}	
			$json3=substr($json3,0,-1);
			$json3.= ']}';
		}else{
			$json3 = '';
		}
		
		echo $json.'|'.$json2.'|'.$json3;
	}
	
	if($section == 2){
		$id = $_POST['id'];
		try{
			$select = "SELECT estadoDet FROM detalle_distribuidor WHERE idDet_Dis = ?";
			$slt = $gbd -> prepare($select);
			$slt -> execute(array($id));
			$row = $slt -> fetch(PDO::FETCH_ASSOC);
			$estado = $row['estadoDet'];
			
			if($estado == 'Activo'){
				$delete = "UPDATE detalle_distribuidor SET estadoDet = ? WHERE idDet_Dis = ?";
				$stmt = $gbd -> prepare($delete);
				$stmt -> execute(array('Inactivo',$id));
			}else if($estado == 'Inactivo'){
				$delete = "UPDATE detalle_distribuidor SET estadoDet = ? WHERE idDet_Dis = ?";
				$stmt = $gbd -> prepare($delete);
				$stmt -> execute(array('Activo',$id));
			}
			echo 'ok';
		}catch(PDOException $e){
			print_r($e);
		}
	}
	
	if($section == 3){
		$nombre = $_POST['nombre'];
		$documento = $_POST['documento'];
		$telefono = $_POST['telefono'];
		$dir = $_POST['dir'];
		$contacto = $_POST['contacto'];
		$mail = $_POST['mail'];
		$poocentajeventas = $_POST['poocentajeventas'];
		$porcentajecobros = $_POST['porcentajecobros'];
		$movil = $_POST['movil'];
		$observaciones = $_POST['observaciones'];
		$estado = $_POST['estado'];
		$id = $_POST['id'];
		$tipo_empDistri = $_POST['tipo_empDistri'];
		$tipo_empDistri2 = $_POST['tipo_empDistri2'];
		$socio = $_POST['socio'];
		
		$update = "UPDATE distribuidor SET nombreDis = ?, documentoDis = ?, telefonoDis = ?, mailDis = ?, contactoDis = ?, movilDis = ?, direccionDis = ?, observacionesDis = ?, porcentajeventaDis = ?, porcentajecobroDis = ?, tarjetaDis = ? , estadoDis = ? WHERE idDistribuidor = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($nombre,$documento,$telefono,$mail,$contacto,$movil,$dir,$observaciones,$poocentajeventas,$socio,$tipo_empDistri2,$estado,$id));
		
		
		$update = "UPDATE Usuario SET strMailU = ? , tipo_emp = ? WHERE strObsCreacion = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($mail,$tipo_empDistri,$id));
		
		
		
		if($_POST['valoresEdit'] != ''){
			foreach(explode('@', $_POST['valoresEdit']) as $value){
				$exp = explode('|',$value);
				$insert = "INSERT INTO detalle_distribuidor VALUES (?, ?, ?, ?)";
				$ins = $gbd -> prepare($insert);
				$ins -> execute(array('NULL',$id,$exp[0],'Activo'));
			}
		}
		
		echo 'ok';
	}
?>