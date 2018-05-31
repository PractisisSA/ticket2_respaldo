<?php
	include '../conexion.php';
	$cuantos_vendidos_ = $_REQUEST['cuantos_vendidos_'];
	$fotoSubida_ = $_REQUEST['fotoSubida_'];
	$id = $_REQUEST['id'];
	$ident = $_REQUEST['ident'];
	
	if($ident == 1){
		$sql = 'INSERT INTO `vendidos_x_evento` (`id`, `idcon`, `cuantos`, `foto`) 
				VALUES (NULL, "'.$id.'", "'.$cuantos_vendidos_.'", "'.$fotoSubida_.'")';
		$res = mysql_query($sql) or die (mysql_error());
		
		if($res){
			echo 'Documento grabado con exito';
		}else{
			echo 'error';
		}
	}
	elseif($ident == 2){
		$sql = 'update vendidos_x_evento set cuantos = "'.$cuantos_vendidos_.'" , foto = "'.$fotoSubida_.'" where idcon = "'.$id.'" ';
		$res = mysql_query($sql) or die (mysql_error());
		if($res){
			echo 'Documento actualizado con exito';
		}else{
			echo 'error';
		}
	}
?>