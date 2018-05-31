<?php
	include '../conexion.php';
	$evento = $_REQUEST['evento'];
	$localidades = $_REQUEST['localidades'];
	$cantidades = $_REQUEST['cantidades'];
	$cantidad_gratis = $_REQUEST['cantidad_gratis'];
	$nombre = $_REQUEST['nombre'];
	$reloj = $_REQUEST['reloj'];
	$estado_ = $_REQUEST['estado_'];
	$localidad_ = $_REQUEST['localidad_'];
	$id = $_REQUEST['id'];
	
	$ident = $_REQUEST['ident'];
	if($ident == 1){
		$sqlP = "	INSERT INTO `promociones` (`id`, `id_con`, `id_loc`, `cantidad` , `cortesias`, `nombre`, `reloj`, `estado`) 
					VALUES (NULL, '".$evento."', '".$localidades."', '".$cantidades."' , '".$cantidad_gratis."', '".$nombre."', '".$reloj."', '1')
				";
		$resP = mysql_query($sqlP) or die (mysql_error());
		echo 'Promocion configurada con éxito';
	}elseif($ident == 2){
		$sqlP = "		
					update promociones set `id_loc` = '".$localidad_."',
											`cantidad` = '".$cantidades."',
										    `cortesias` = '".$cantidad_gratis."',
											`nombre` = '".$nombre."',
											`reloj` = '".$reloj."',
											`estado` = '".$estado_."'
											where id = '".$id."'
				";
		// echo $sqlP;
		$resP = mysql_query($sqlP) or die (mysql_error());
		echo 'Promocion actualizada con éxito';
	}
	
	
?>