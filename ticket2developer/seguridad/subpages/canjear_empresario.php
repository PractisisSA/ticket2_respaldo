<?php
	include '../../conexion.php';
	$boleto = $_REQUEST['boleto'];
	date_default_timezone_set("America/Guayaquil"); 
	$hora_canje = date("Y-m-d H:i:s"); 
	$sql = 'SELECT count(idBoleto) as boleto_vendido , strEstado 
			FROM `Boleto` 
			WHERE `strBarcode` = "'.$boleto.'" 
			
			ORDER BY `idBoleto` DESC 
			';
	// echo $sql;
	// exit;
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	$boleto_vendido = $row['boleto_vendido'];
	if($boleto_vendido == 0){
		echo 0;
	}else{
		$sql1 = 'SELECT *
				FROM `Boleto` 
				WHERE `strBarcode` = "'.$boleto.'" 
				and nombreHISB = "empresario"
				ORDER BY `idBoleto` DESC 
			';
		//echo $sql1;
		$res1 = mysql_query($sql1) or die (mysql_error());
		$row1 = mysql_fetch_array($res1);
		//echo $row1['nombreHISB'];
		if($row1['nombreHISB'] == 'empresario'){
	$sqlU = 'UPDATE `Boleto` SET rowB = "0"  , colB = "0" , tercera = "0" , preventa = "0" tipo_evento = "0"  WHERE `strBarcode` = "'.$boleto.'"';
			//echo $sqlU;
			$resU = mysql_query($sqlU) or die (mysql_error());
			echo 1;
		}else{
			echo 2;
		}
	}
?>