<?php
	include '../../enoc.php';
	$id_ter = $_REQUEST['id_ter'];
	$ident = $_REQUEST['ident'];
	$nom_ter = $_REQUEST['nom_ter'];
	
	if($ident == 1){
		$sql = 'update terminales set nombre = "'.$nom_ter.'" where id = "'.$id_ter.'" ';
		//echo $sql;
		$res = mysql_query($sql) or die (mysql_error());
		if($res){
			echo 'terminal Actualizado con Éxito';
		}else{
			echo 'Error';
		}
	}
	
	if($ident == 2){
		$sql = 'select count(id) as cuantos_origen from ruta where id_ter = "'.$id_ter.'" ';
		$res = mysql_query($sql) or die (mysql_error());
		$row = mysql_fetch_array($res);
		if($row['cuantos_origen'] == 0){
		
			
				$sql3 = 'select count(id) as cuantos_destino_e from escalas where id_ter = "'.$id_ter.'" ';
				$res3 = mysql_query($sql3) or die (mysql_error());
				$row3 = mysql_fetch_array($res3);
				if($row3['cuantos_destino_e'] == 0){
					//echo 'se eliminara la ciudad : "'.$id_ter.'"';
					$sqlC = 'update terminales set estado = 0 where id = "'.$id_ter.'" ';
					$resC = mysql_query($sqlC) or die (mysql_error());
					echo 'terminal desactivado con exito';
				}else{
					echo 'el terminal : "'.$id_ter.'" esta configurado en escalas como terminal de salida , no lo puede eliminar';
				}
			
			
		}else{
			echo 'el terminal : "'.$id_ter.'" esta configurado en rutas como terminal de salida , no la puede eliminar';
		}
	}
	
	
	if($ident == 3){
		$sqlC = 'update terminales set estado = 1 where id = "'.$id_ter.'" ';
		$resC = mysql_query($sqlC) or die (mysql_error());
		echo 'terminal activado con exito';
	}
?>