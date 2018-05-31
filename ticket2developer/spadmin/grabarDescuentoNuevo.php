<?php
	include '../conexion.php';
	$serviform = $_REQUEST['serviform'];
	$exp1 = explode("|",$serviform);
	for($i=0;$i<=count($exp1)-1;$i++){
		$exp2 = explode("@",$exp1[$i]);
		$idCon = $exp2[0];
		$idLoc = $exp2[1];
		$nombDesc = $exp2[2];
		$valorDesc = $exp2[3];
		$estado_impu = $exp2[4];
		$ident = $exp2[5];
		$valorVenta = $exp2[6];
		
		
		$sql = 'INSERT INTO `descuentos` (`id`, `idcon`, `idloc`, `nom`, `val` , `est` , `web`) 
				VALUES (NULL, "'.$idCon.'", "'.$idLoc.'", "'.$nombDesc.'", "'.$valorDesc.'" , "'.$estado_impu.'" , 0)';
		$res = mysql_query($sql) or die (mysql_error());
		
		$id_desc = mysql_insert_id();
		
		$sqlV = 'SELECT count(id) as cuantos FROM valor_localidad_ventas where id_loc = "'.$idLoc.'" and id_desc = "'.$id_desc.'" ';
		$resV = mysql_query($sqlV) or die (mysql_error());
		$rowV = mysql_fetch_array($resV);
						
		if($rowV['cuantos'] == 0){
			$sqlV1 = 'insert into valor_localidad_ventas (id_loc , id_desc , valor) values ("'.$idLoc.'" ,"'.$id_desc.'" , "'.$valorVenta.'" ) ';
			$resV1 = mysql_query($sqlV1) or die (mysql_error());
		}else{
			$sqlV1 = 'update valor_localidad_ventas set valor = "'.$valorVenta.'" where id_desc = "'.$id_desc.'" ';
			$resV1 = mysql_query($sqlV1) or die (mysql_error());
		}
		
		
	}
	echo 'Descuento Grabado con Éxito';
	
?>