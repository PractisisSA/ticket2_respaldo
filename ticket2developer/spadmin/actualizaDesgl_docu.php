<?php
	include '../conexion.php';
	$id_con = $_REQUEST['id_con'];
	$docu = $_REQUEST['docu'];
	$desg = $_REQUEST['desg'];
	$municip = $_REQUEST['municip'];
	
	$sql1 = 'select count(id) as cuantos from desgl_docu where id_con = "'.$id_con.'" ';
	$res1 = mysql_query($sql1) or die (mysql_error());
	$row1 = mysql_fetch_array($res1);
	if($row1['cuantos'] == 0){
		$sql = 'insert into desgl_docu (id_con , docu , desg , municipio ) values("'.$id_con.'" , "'.$docu.'" , "'.$desg.'" , "'.$municip.'")';
		$res = mysql_query($sql) or die (mysql_error());
	}else{
		$sql = 'update desgl_docu set docu = "'.$docu.'" , desg = "'.$desg.'"  , municipio = "'.$municip.'" where id_con = "'.$id_con.'" ';
		$res = mysql_query($sql) or die (mysql_error());
	}
	
	
	
	echo 'Documentos ingresados con Éxito';
?>