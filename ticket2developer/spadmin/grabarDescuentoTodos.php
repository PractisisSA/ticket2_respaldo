<?php
	include '../conexion.php';
	$serviform = $_REQUEST['serviform'];
	$exp1 = explode("|",$serviform);
	for($i=0;$i<=count($exp1)-1;$i++){
		$exp2 = explode("@",$exp1[$i]);
		$id = $exp2[0];
		$nombDesc = $exp2[1];
		$valorDesc = $exp2[2];
		$ident = $exp2[3];
		$estDesc = $exp2[4];
		$estDescWeb = $exp2[5];
		$valorVenta = $exp2[6];
		$idLoc_ = $exp2[7];
		
		$sql = 'update descuentos set `nom` = "'.$nombDesc.'" , `val` = "'.$valorDesc.'" , `est` = "'.$estDesc.'" , `web` = "'.$estDescWeb.'" where id = "'.$id.'"  ';
		// echo $sql."<br><br>";
		$res = mysql_query($sql) or die (mysql_error());
		
		
		$sqlV = 'SELECT count(id) as cuantos FROM valor_localidad_ventas where id_loc = "'.$idLoc_.'" and id_desc = "'.$id.'" ';
		
		// echo $sqlV."<br><br>";
		$resV = mysql_query($sqlV) or die (mysql_error());
		$rowV = mysql_fetch_array($resV);
						
		if($rowV['cuantos'] == 0){
			$sqlV1 = 'insert into valor_localidad_ventas (id_loc , id_desc , valor) values ("'.$idLoc_.'" ,"'.$id.'" , "'.$valorVenta.'" ) ';
			$resV1 = mysql_query($sqlV1) or die (mysql_error());
		}else{
			$sqlV1 = 'update valor_localidad_ventas set id_loc = "'.$idLoc_.'" , id_desc = "'.$id.'"  , valor = "'.$valorVenta.'" where id_desc = "'.$id.'" ';
			$resV1 = mysql_query($sqlV1) or die (mysql_error());
		}
		
		// echo $sqlV1."<br><br><hr>";
		// if($res){
			// echo 'Descuento Actualizado con Éxito';
		// }else{
			// echo 'Error , comuniquese con el administrador del sistema';
		// }
	}
	echo 'Informacion Actualizada con Éxito';
?>