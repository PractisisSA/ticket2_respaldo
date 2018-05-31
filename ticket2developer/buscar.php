<?php
	require('Conexion/conexion.php');
	$buscar = $_POST['b'];
	if(!empty($buscar)){
		$sqlsearch = "SELECT * FROM Concierto WHERE strEvento LIKE '%".$buscar."%' AND dateFecha >= CURRENT_DATE ORDER BY idConcierto ASC" or die(mysqli_error());
		$ressearch = $mysqli->query($sqlsearch);
		if($ressearch == 0){
			echo 'No se encontraron resultados para'.$b.'siga buscando';
		}else{
			while($rowsearch = mysqli_fetch_array($ressearch)){
				$img = $rowsearch['strImagen'];
				$ruta = 'beBoletero/ingreso/';
				$ruta = $ruta.$img;
				if ($limite == 0){
					echo '<tr>';
				}
				if($limite <= 3){ 
					echo '<td align="center"><a href="Conciertos/des_concierto.php?con='.$rowsearch['idConcierto'].'"><img src="'.$ruta.'" width="100%" id="imgsearch"/></a></td>';
				$limite++;
				}
				if($limite > 3){
					echo '<tr>';
					$limite=0;
				}
			}
		}
	}
?>