<?php
	include '../conexion.php';
	$serviform = $_REQUEST['serviform'];
	$exp1 = explode("|",$serviform);
	for($i=0;$i<=count($exp1)-1;$i++){
		$exp2 = explode("@",$exp1[$i]);
		$localidades_macros = $exp2[0];
		$numero_localidad = $exp2[1];
		
		$sqlL = 'update Localidad set macro_localidad = "'.$localidades_macros.'" where idLocalidad = "'.$numero_localidad.'"';
		//echo $sqlL."<br><br>";
		$resL = mysql_query($sqlL) or die (mysql_error());
	}
	
	echo 'Localidades Macro Grabadas con Exito';
	
?>