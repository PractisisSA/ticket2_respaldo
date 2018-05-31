<?php
	include '../conexion.php';
	$idloc = $_REQUEST['idloc'];
	$id_desc = $_REQUEST['id_desc'];
	$cantidad_solicitada = $_REQUEST['num_personas'];
	
	$sql = 'SELECT COUNT(`idBoleto`) as cuantos_cortesias FROM `Boleto` WHERE `idLocB` = "'.$idloc.'" and `id_desc` = "'.$id_desc.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	
	$cuantos_cortesias = $row['cuantos_cortesias'];
	
	$sqlLC = 'SELECT count(id) as cuantos_autorizados ,`id_loc` , cant FROM `localidad_cortesias` WHERE `id_loc` = "'.$idloc.'" and `id_desc` = "'.$id_desc.'" ORDER BY `id` ASC ';
	$resLC = mysql_query($sqlLC) or die (mysql_error());
	$rowLC = mysql_fetch_array($resLC);
	$cantidad_autorizados = $rowLC['cant'];
	$cuantos_autorizados = $rowLC['cuantos_autorizados'];
	$disponibles_autorizados = ($cantidad_autorizados - $cuantos_cortesias);
	if($cuantos_autorizados != 0){
		
		
		
		if($disponibles_autorizados >= $cantidad_solicitada){
			$ident = 1;
			echo $ident.'|'.$disponibles_autorizados;
		}elseif($disponibles_autorizados == 0){
			$ident = 3;
			echo $ident."|".$disponibles_autorizados;
		}else{
			$ident = 0;
			echo $ident."|".$disponibles_autorizados;
		}

	}else{
		$ident = 2;
		echo $ident;
	}
?>