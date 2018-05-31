<?php
	include '../conexion.php';
	$fila = $_REQUEST['fila'];
	$columna = $_REQUEST['columna'];
	$param = $_REQUEST['param'];
	$id_ocu = $_REQUEST['id_ocu'];
	$id_loc = $_REQUEST['id_loc'];
	$idcon = $_REQUEST['idcon'];
	
	if($param == 1){
		$sql = 'delete from ocupadas where id = "'.$id_ocu.'" ';
		$res = mysql_query($sql) or die (mysql_error());
		$clase = 'sillas_blancas_'.$fila.'';
		$color = '';
		$div = '<div id = "contenedor_numero_asiento_'.$fila.'_'.$columna.'" parametro = "0" id_ocu = "0"  fila = "'.$fila.'" columna = "'.$columna.'"  id_loc = "'.$id_loc.'"  idcon = "'.$idcon.'" onclick = "saberEstado('.$fila.','.$columna.',0,0,'.$id_loc.','.$idcon.')" class = "'.$clase.' libres" style ="'.$color.'font-size:12px;padding-top:7px !important;border:1px solid #ccc;vertical-align:middle;cursor:pointer;width:30px;height:35px;text-align: center">'.$columna.'</div>';
	}else{
		$sql = 	'
					insert into ocupadas (row,col,status,local,concierto,pagopor,descompra)
					values ("'.$fila.'","'.$columna.'","3","'.$id_loc.'","'.$idcon.'","3","0")
				';
		$res = mysql_query($sql) or die (mysql_error());
		$id_ocu = mysql_insert_id();
		$clase = 'sillas_negras_';
		$color = 'background-color:#000;color:#fff;';
		$div = '<div id = "contenedor_numero_asiento_'.$fila.'_'.$columna.'" parametro = "1" id_ocu = "'.$id_ocu.'"  fila = "'.$fila.'" columna = "'.$columna.'"  id_loc = "'.$id_loc.'"  idcon = "'.$idcon.'" onclick = "saberEstado('.$fila.','.$columna.',1,'.$id_ocu.','.$id_loc.','.$idcon.')" class = "'.$clase.' filas_negras_'.$fila.' bloqueadas" style ="'.$color.'font-size:12px;padding-top:7px !important;border:1px solid #ccc;vertical-align:middle;cursor:pointer;width:30px;height:35px;text-align: center">'.$columna.'</div>';
		
		
	}
	
	echo $div;
?>