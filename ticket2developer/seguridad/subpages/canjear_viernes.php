<?php
	include '../../conexion.php';
	$boleto = $_REQUEST['boleto'];
	date_default_timezone_set("America/Guayaquil"); 
	$hora_canje = date("Y-m-d H:i:s"); 
	$sql = 'SELECT count(idBoleto) as boleto_vendido , strEstado FROM `Boleto` WHERE `strBarcode` = "'.$boleto.'" and idCon = "26" ORDER BY `idBoleto` DESC ';
	//echo $sql;
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	$boleto_vendido = $row['boleto_vendido'];
	if($boleto_vendido == 0){
		echo 0;
	}else{
		if($row['strEstado'] == 'A'){
			$sqlU = 'UPDATE `Boleto` SET `strQr` = "'.$hora_canje.'" , `strEstado` = "I" WHERE `strBarcode` = "'.$boleto.'"';
			//echo $sqlU;
			$resU = mysql_query($sqlU) or die (mysql_error());
			echo 1;
		}else{
			echo 2;
		}
	}
?>