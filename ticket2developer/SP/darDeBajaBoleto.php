<?php
	include '../conexion.php';
	$boleto = $_REQUEST['boleto'];
	
	$sql = 'select idCon from Boleto where strBarcode = "'.$boleto.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	
	//echo $row['idCon'];
	$sql2 = 'update Boleto set idCon = "'.$row['idCon'].'0" where strBarcode = "'.$boleto.'" ';
	//echo $sql2;
	$res2 = mysql_query($sql2) or die (mysql_error());
	if($res2){
		echo 'ok';
	}else{
		echo 'error';
	}
?>