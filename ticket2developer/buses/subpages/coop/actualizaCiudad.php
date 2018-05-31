<?php
	include '../../enoc.php';
	$id_ciu = $_REQUEST['id_ciu'];
	$ident = $_REQUEST['ident'];
	$nom_ciu = $_REQUEST['nom_ciu'];
	$nuevaCiudad = $_REQUEST['nuevaCiudad'];
	if($ident == 1){
		$sql = 'update ciudades set nom = "'.$nom_ciu.'" where id = "'.$id_ciu.'" ';
		//echo $sql;
		$res = mysql_query($sql) or die (mysql_error());
		if($res){
			echo 'Ciudad Actualizada con Éxito';
		}else{
			echo 'Error';
		}
	}
	
	if($ident == 2){
		$sql = 'select count(id) as cuantos_origen from ruta where origen = "'.$id_ciu.'" ';
		$res = mysql_query($sql) or die (mysql_error());
		$row = mysql_fetch_array($res);
		if($row['cuantos_origen'] == 0){
			$sql1 = 'select count(id) as cuantos_destino from ruta where destino = "'.$id_ciu.'" ';
			$res1 = mysql_query($sql1) or die (mysql_error());
			$row1 = mysql_fetch_array($res1);
			if($row1['cuantos_destino'] == 0){
				$sql2 = 'select count(id) as cuantos_origen_e from escalas where id_ciu_sal = "'.$id_ciu.'" ';
				$res2 = mysql_query($sql2) or die (mysql_error());
				$row2 = mysql_fetch_array($res2);
				if($row2['cuantos_origen_e'] == 0){
					$sql3 = 'select count(id) as cuantos_destino_e from escalas where id_ciu_lleg = "'.$id_ciu.'" ';
					$res3 = mysql_query($sql3) or die (mysql_error());
					$row3 = mysql_fetch_array($res3);
					if($row3['cuantos_destino_e'] == 0){
						//echo 'se eliminara la ciudad : "'.$id_ciu.'"';
						$sqlC = 'update ciudades set estado = 0 where id = "'.$id_ciu.'" ';
						$resC = mysql_query($sqlC) or die (mysql_error());
						echo 'ciudad desactivada con exito';
					}else{
						echo 'la ciudad : "'.$id_ciu.'" esta configurada en escalas como ciudad de destino , no la puede eliminar';
					}
				}else{
					echo 'la ciudad : "'.$id_ciu.'" esta configurada en escalas como ciudad de salida , no la puede eliminar';
				}
			}else{
				echo 'la ciudad : "'.$id_ciu.'" esta configurada en rutas como ciudad de destino , no la puede eliminar';
			}
		}else{
			echo 'la ciudad : "'.$id_ciu.'" esta configurada en rutas como ciudad de salida , no la puede eliminar';
		}
	}if($ident == 3){
		$sqlC = 'update ciudades set estado = 1 where id = "'.$id_ciu.'" ';
		$resC = mysql_query($sqlC) or die (mysql_error());
		echo 'ciudad activada con exito';
	}if($ident == 4){
		
		$sqlCi = 'insert into ciudades (nom , estado) values("'.$nuevaCiudad.'" , "1")';
		$resCi = mysql_query($sqlCi) or die (mysql_error());
		if($resCi){
			echo 'Ciudad Creada con Éxito';
		}else{
			echo 'error';
		}
	}
?>