<?php
	include '../conexion.php';
	$id_con = $_REQUEST['id_con'];
	$ident = $_REQUEST['ident'];
	
	if($ident == 1){
		$sql = 'insert into banner (id_con) values ("'.$id_con.'")';
		
		$txt = '<i onclick = "adminBanner('.$id_con.' , 2)" class="fa fa-check-circle-o fa-2x" aria-hidden="true" style = "color:rgb(29,158,117);cursor:pointer;" ></i>';
	}else{
		$sql = 'delete from banner where id_con = "'.$id_con.'" ';
		
		$txt = '<i onclick = "adminBanner('.$id_con.' , 1)" class="fa fa-times-circle-o fa-2x" aria-hidden="true" style = "color:red;cursor:pointer;" ></i> ';
	}
	
	$res = mysql_query($sql) or die (mysql_error());
	echo $txt;
?>