<?php
	include '../conexion.php';
	
	
	$idLoc = $_REQUEST['idLoc'];
	$ident = $_REQUEST['ident'];
	$idCon = $_REQUEST['idCon']; 
	$cod_bar = $_REQUEST['cod_bar1'];
	$cuantos = $_REQUEST['cuantos'];
	$estado = $_REQUEST['estado'];
	
	if($estado == 2){
		$sqlB = 'delete from codigo_barras where id_con = "'.$idCon.'" and id_loc = "'.$idLoc.'" ';
		// echo $sqlB;
		$resB = mysql_query($sqlB) or die (mysql_error());
	}
	// exit;
	function hexadecimalAzar($caracteres){

		$caracteresPosibles = "01234567890987654321";
		$azar = '';

		for($i=0; $i<$caracteres; $i++){

			$azar .= $caracteresPosibles[rand(0,strlen($caracteresPosibles)-1)];

		}

		return $azar;

	}
	
	
	$k=1;
	for($j=0;$j<=($cod_bar-1);$j++){
		
		$code = hexadecimalAzar(10);
		
		$sqlC = 'select count(id) as cuantos from codigo_barras where id_con = "'.$idCon.'" and codigo = "'.$code.'" and id_loc = "'.$idLoc.'" ';
		$resC = mysql_query($sqlC) or die (mysql_error());
		$rowC = mysql_fetch_array($resC);
		if($rowC['cuantos'] == 0){
			$cc = '	INSERT INTO codigo_barras (id_con , codigo , estado , utilizado , id_loc ) 
					VALUES ("'.$idCon.'" , "'.$idCon."".$code.'" , "A" , "0" , "'.$idLoc.'" )
				';
			$res = mysql_query($cc) or die (mysql_error());
		}else{
			$m++;
		}
		$k++;
	}
	echo 'Boletos Asignados con Éxito';
?>