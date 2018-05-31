<?php
	include 'conexion.php';
	$conciertoID = $_REQUEST['conciertoID'];
	$permisos = $_REQUEST['permisos'];
	
	$sql = 'update Concierto set tiene_permisos = "'.$permisos.'" where idConcierto = "'.$conciertoID.'" ';
	$res = mysql_query($sql) or die(mysql_error());
	
	if($permisos == 0){
		$docu = 0;
	}else{
		$docu = 1;
	}
	
	$sql3 = 'select count(id) as cuantos from desgl_docu where id_con = "'.$conciertoID.'" ';
	$res3 = mysql_query($sql3) or die (mysql_error());
	$row3 = mysql_fetch_array($res3);
	
	if($row3['cuantos'] == 0){
		$sql4 = 'insert into desgl_docu (id_con , docu) values ("'.$conciertoID.'" , "'.$docu.'") ';
		$res4 = mysql_query($sql4) or die (mysql_error());
	}else{
		$sql2 = 'update desgl_docu set docu = "'.$docu.'" where id_con = "'.$conciertoID.'" ';
		$res2 = mysql_query($sql2) or die (mysql_error());
		
		if($res){
			echo 'Se ha actualizado los permisos del concierto...';
		}else{
			echo 'error';
		}

	}
	
?>