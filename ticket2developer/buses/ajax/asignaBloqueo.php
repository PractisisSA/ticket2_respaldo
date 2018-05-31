<?php
	include '../enoc.php';
	$id_bus = $_REQUEST['id_bus'];
	$asiento = $_REQUEST['asiento'];
	$id_blo = $_REQUEST['id_blo'];
	$ident = $_REQUEST['ident'];
	
	if($ident == 2){
		$sql = 'insert into bus_bloqueo (id_bus , asiento) values ("'.$id_bus.'" , "'.$asiento.'")';
		//echo $sql;
		$res = mysql_query($sql) or die (mysql_error());
	}else{
		$sql = 'delete from bus_bloqueo where id = "'.$id_blo.'"';
		$res = mysql_query($sql) or die(mysql_error());
	}
?>