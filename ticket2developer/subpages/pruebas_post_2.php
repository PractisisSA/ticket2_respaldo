<?php
include '../conexion.php';

$data = $_REQUEST['data'];
$localidad = $_REQUEST['localidad'];
$evento = $_REQUEST['evento'];
$boletos = explode(",", $data);
$arrlength = count($boletos);

$sqlText = "";

for($x = 0; $x < $arrlength; $x++) {
	if ($x > 0) {
		$sqlText = $sqlText.' OR ';
	}
	$sqlText = $sqlText." idBoleto =".$boletos[$x]." ";
}
$consult = "UPDATE Boleto SET idCon =  CONCAT(idCon, '0000') WHERE ".$sqlText." ";

$res = mysql_query($consult);
if ($res) {
	echo 1;
}else{
	echo 2;
}
?>