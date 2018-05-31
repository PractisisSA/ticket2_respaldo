<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include 'conexion.php';
	$concert_id = $_REQUEST['concert_id'];
	
	$sql = 'SELECT * FROM Concierto WHERE idConcierto = "'.$concert_id.'" ';
	//echo $sql;
	
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	$tiene_permisos = $row['tiene_permisos'];
	
	$sqlSerie = 'SELECT count(serie) as num_serie FROM Boleto WHERE idCon = "'.$concert_id.'" ';
	//echo $sqlSerie;
	
	$resSerie = mysql_query($sqlSerie) or die (mysql_error());
	$rowSerie = mysql_fetch_array($resSerie);
	if($rowSerie['num_serie'] == 0){
		//echo 'no hay ';
		$sqlAut = 'select secuencialinicialA from autorizaciones where idAutorizacion = "'.$tiene_permisos.'" ';
		//echo $sqlAut;
		
		$resAut = mysql_query($sqlAut) or die (mysql_error());
		$rowAut = mysql_fetch_array($resAut);
		$serie = $rowAut['secuencialinicialA'];
	}else{
		// echo 'si hay';
		
		
		$sqlAut2 = 'select secuencialfinalA from autorizaciones where idAutorizacion = "'.$tiene_permisos.'" ';
		$resAut2 = mysql_query($sqlAut2) or die (mysql_error());
		$rowAut2 = mysql_fetch_array($resAut2);
		
		
		if($rowAut2['secuencialfinalA']<= $rowSerie['num_serie']){
			$sqlSerie1 = 'SELECT max(serie) as max_serie FROM Boleto WHERE idCon = "'.$concert_id.'" ';
			$resSerie1 = mysql_query($sqlSerie1) or die (mysql_error());
			$rowSerie1 = mysql_fetch_array($resSerie1);
			$serie = ($rowSerie1['max_serie']+1);
		}
		
	}
	echo $serie;
?>