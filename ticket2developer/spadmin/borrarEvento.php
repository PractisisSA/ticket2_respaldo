<?php
	include '../conexion.php';
	$id = $_REQUEST['id'];
	//echo $id;
	$sql = 'delete from Concierto where idConcierto = "'.$id.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	if($res){
		echo 'Evento N° '.$id.' a sido eliminado con éxito';
	}else{
		echo 'error no se borró';
	}
?>