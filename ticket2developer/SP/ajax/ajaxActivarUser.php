<?php
include('../../conexion.php');
$idUserEst = $_REQUEST['id'];

$sql = 'UPDATE Usuario SET strEstadoU = "Activo" WHERE idUsuario = "'.$idUserEst.'"';
$result = mysql_query($sql) or die (mysql_error());

if ($result) {
	echo 1;
}else{
	echo 2;
}
?>