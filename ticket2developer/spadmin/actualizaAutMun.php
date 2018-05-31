<?php
	include '../conexion.php';
	$conciertoID = $_REQUEST['id'];
	$autMun = $_REQUEST['autMun'];
	// if($permisos == 1){
		// $cambioPermisos = 0;
		
	// }elseif($permisos == 0){
		// $cambioPermisos = 1;
	// }
	$sql = 'update Concierto set autMun = "'.$autMun.'" where idConcierto = "'.$conciertoID.'" ';
	//echo $sql."<br/>";
	$res = mysql_query($sql) or die(mysql_error());
	if($res){
		echo 'Se ha actualizado la autorización municipal del concierto...';
	}else{
		echo 'error';
	}
?>