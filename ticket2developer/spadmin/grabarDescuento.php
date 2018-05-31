<?php
	include '../conexion.php';
	$idCon = $_REQUEST['idCon'];
	$idLoc = $_REQUEST['idLoc']; 
	$nombDesc = $_REQUEST['nombDesc'];
	$valorDesc = $_REQUEST['valorDesc'];
	$ident = $_REQUEST['ident'];
	$estado_impu = $_REQUEST['estado_impu'];
	$estDesc = $_REQUEST['estDesc'];
	$estDescWeb = $_REQUEST['estDescWeb'];
	
	
	$id = $_REQUEST['id'];
	$valorVenta = $_REQUEST['valorVenta'];
	
	if($ident == 0){
		$sql = 'INSERT INTO `descuentos` (`id`, `idcon`, `idloc`, `nom`, `val` , `est` , `web`) 
				VALUES (NULL, "'.$idCon.'", "'.$idLoc.'", "'.$nombDesc.'", "'.$valorDesc.'" , "'.$estado_impu.'" , "'.$estDescWeb.'")';
		$res = mysql_query($sql) or die (mysql_error());
		
		$id_desc = mysql_insert_id();
		
		
		$sqlV1 = 'insert into valor_localidad_ventas (id_loc , id_desc , valor) values ("'.$idLoc.'" ,"'.$id_desc.'" , "'.$valorVenta.'" ) ';
		$resV1 = mysql_query($sqlV1) or die (mysql_error());
			
		if($res){
			echo 'Descuento Grabado con Éxito';
		}else{
			echo 'Error , comuniquese con el administrador del sistema';
		}
	}elseif($ident == 1){
		$sql = 'update descuentos set `nom` = "'.$nombDesc.'" , `val` = "'.$valorDesc.'" , `est` = "'.$estDesc.'" , `web` = "'.$estDescWeb.'" where id = "'.$id.'"  ';
		// echo $sql;
		$res = mysql_query($sql) or die (mysql_error());
		if($res){
			echo 'Descuento Actualizado con Éxito';
		}else{
			echo 'Error , comuniquese con el administrador del sistema';
		}
		
		$sqlV = 'SELECT count(id) as cuantos FROM valor_localidad_ventas where id_loc = "'.$idLoc.'" and id_desc = "'.$id.'" ';
		$resV = mysql_query($sqlV) or die (mysql_error());
		$rowV = mysql_fetch_array($resV);
						
		if($rowV['cuantos'] == 0){
			$sqlV1 = 'insert into valor_localidad_ventas (id_loc , id_desc , valor) values ("'.$idLoc.'" ,"'.$id.'" , "'.$valorVenta.'" ) ';
			$resV1 = mysql_query($sqlV1) or die (mysql_error());
		}else{
			$sqlV1 = 'update valor_localidad_ventas set valor = "'.$valorVenta.'" where id_desc = "'.$id.'" ';
			$resV1 = mysql_query($sqlV1) or die (mysql_error());
		}
	}elseif($ident == 2){
		$sql = 'delete from descuentos  where id = "'.$id.'"  ';
		// echo $sql;
		$res = mysql_query($sql) or die (mysql_error());
		if($res){
			echo 'Descuento borrado con Éxito';
		}else{
			echo 'Error , comuniquese con el administrador del sistema';
		}
	}
?>