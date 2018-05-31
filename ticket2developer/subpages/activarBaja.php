<?php  

	include '../conexion.php';
	$cleanId = $_REQUEST['cleanId'];
	$id = $_REQUEST['id'];

	$update = 'UPDATE Boleto SET idCon = "'.$cleanId.'" WHERE idBoleto = "'.$id.'"';
	$resUpdate = mysql_query($update);

	if ($resUpdate) {
		echo 1;
	}else{
		echo 2;
	}
?>