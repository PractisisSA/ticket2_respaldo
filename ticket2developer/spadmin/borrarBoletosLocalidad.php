<?php
	include '../conexion.php';
	$idCon = $_REQUEST['idCon'];
	$idLoc = $_REQUEST['idLoc'];
	
	$sql1 = 'delete  FROM `Boleto` WHERE `idCon` = "'.$idCon.'" AND `idLocB` = "'.$idLoc.'" ';
	$sql2 = 'delete  FROM `ocupadas` WHERE status = 2 AND `local` = "'.$idLoc.'" and `concierto` = "'.$idCon.'" ';
	$sql3 = 'delete  FROM `transaccion_distribuidor` WHERE `idconciertotrans` = "'.$idCon.'" AND `idlocalidadtrans` = "'.$idLoc.'"';
	$sql4 = 'update codigo_barras set utilizado = 0  WHERE `id_con` = "'.$idCon.'" AND `id_loc` = "'.$idLoc.'" ';
	
	$res1 = mysql_query($sql1) or die (mysql_error());
	$res2 = mysql_query($sql2) or die (mysql_error());
	$res3 = mysql_query($sql3) or die (mysql_error());
	$res4 = mysql_query($sql4) or die (mysql_error());
	
	if($res4){
		echo 'boletos vaciados con éxito';
	}else{
		echo 'error';
	}
?>