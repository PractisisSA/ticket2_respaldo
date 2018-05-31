<?php
	$cadena_de_texto = '5';
	$expC = explode(",",$cadena_de_texto);
	for($i=0;$i<=count($expC)-1;$i++){
		echo $expC[$i]." hay <br>";
	}
?>