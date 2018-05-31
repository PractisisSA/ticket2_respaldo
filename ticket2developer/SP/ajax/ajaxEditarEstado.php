<?php  

include('../../conexion.php');
$idDistribuidorEst = $_REQUEST['id'];
$sqlDis = 'SELECT * FROM distribuidor WHERE idDistribuidor = "'.$idDistribuidorEst.'"';
$resultDis = mysql_query($sqlDis) or die (mysql_error());
$row1 = mysql_fetch_array($resultDis);
$sqlSel = 'SELECT * FROM Usuario WHERE strMailU = "'.$row1['mailDis'].'"';
$resultQue = mysql_query($sqlSel) or die (mysql_error());
$row = mysql_fetch_array($resultQue);

$sqlEst = 'UPDATE distribuidor SET estadoDis = "Inactivo" WHERE mailDis = "'.$row['strMailU'].'"';
$sqlEst1 = 'UPDATE Usuario SET strEstadoU = "Inactivo" WHERE strMailU = "'.$row1['mailDis'].'"';
$resultEst = mysql_query($sqlEst) or die(mysql_error());
$resultEst1 = mysql_query($sqlEst1) or die(mysql_error());
if ($resultEst && $resultEst1) {
	echo 1;
}else{
	echo 2;
}
?>