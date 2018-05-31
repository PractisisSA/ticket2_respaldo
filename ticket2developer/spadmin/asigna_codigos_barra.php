<?php
	include '../conexion.php';
	$id = $_REQUEST['id'];
	
	$sqlL = 'select min(idLocalidad) as primero ,max(idLocalidad) as ultimo  from Localidad where idConc = "'.$id.'" order by idLocalidad';
	$resL = mysql_query($sqlL) or die (mysql_error());
	$rowL = mysql_fetch_array($resL);
	
	$primero = $rowL['primero']; 
	$ultimo = $rowL['ultimo']; 
	
	$diferencia = ($ultimo - $primero);
	
	// echo "Inicia :  ".$primero."     Termina :  ".$ultimo."      diferencia para el for :  ".$diferencia."<br><br>";
	//exit;
	
	
	
	function hexadecimalAzar($caracteres){

		$caracteresPosibles = "01234567890987654321";
		$azar = '';

		for($i=0; $i<$caracteres; $i++){

			$azar .= $caracteresPosibles[rand(0,strlen($caracteresPosibles)-1)];

		}

		return $azar;

	}

	// echo hexadecimalAzar(13)."<br><br>";
	
	for($i=0;$i<=$diferencia;$i++){
		// echo $k."<<<    >>>".$ultimo."<br><br>";
		// //echo $i.">> <<".$row['strBarcode']."<br>";
		// $r = mt_rand(5, 15);
		$sql = 'SELECT strCapacidadL as cant_bol FROM `Localidad` WHERE `idConc` = "'.$id.'"  and idLocalidad = "'.$primero.'"';
		//echo "<span style = 'color:red;'>".$sql."</span><br>";
		$res = mysql_query($sql) or die (mysql_error());
		$row = mysql_fetch_array($res);
		
		$sqlOc = 'SELECT count(id) as ocupados FROM `ocupadas` WHERE `local` = "'.$primero.'" and status = "3"';
		$resOc = mysql_query($sqlOc) or die (mysql_error());
		$rowOc = mysql_fetch_array($resOc);
		
		
		$cant_bol_localidad = $row['cant_bol'];
		$cant_bol_localidad_ocupados = $rowOc['ocupados'];
		
		$cant_bol = (($cant_bol_localidad - $cant_bol_localidad_ocupados) - 1);
		//echo $cant_bol."<<>>".$primero."\n\n\n";
		$k=1;
		$m=0;
		for($j=0;$j<=$cant_bol;$j++){
			if ($k%2==0){
				$intermedio = $primero.rand(1,99).$id;
			}else{
				$intermedio = $id.rand(1,99).$primero;
			}
			// $code = rand(1,99).$intermedio.rand(1,99);
			$code = hexadecimalAzar(10);
			//$code = $j.$primero.$k.rand(1,99).$id.$k;
			$sqlC = 'select count(id) as cuantos from codigo_barras where id_con = "'.$id.'" and codigo = "'.$code.'" and id_loc = "'.$primero.'" ';
			$resC = mysql_query($sqlC) or die (mysql_error());
			$rowC = mysql_fetch_array($resC);
			if($rowC['cuantos'] == 0){
				$cc = '	INSERT INTO codigo_barras (id_con , codigo , estado , utilizado , id_loc ) 
						VALUES ("'.$id.'" , "'.$id."".$code.'" , "A" , "0" , "'.$primero.'" )
					';
				// echo $cc."<br><br>";
				$res = mysql_query($cc) or die (mysql_error());
			}else{
				// echo 'el codigo : '.$code.' ya existe no se ingresara';
				// echo $m;
				$m++;
			}
			$k++;
		}
		
		 $primero++;
		
	}
	echo 'Codigos de Barra asignados con Éxito';
	
?>