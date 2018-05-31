<?php
	session_start();
	
	$compras = $_SESSION['carrito'];
	
	
	
	echo '<table>';
	
	
	
	
	for($i=0;$i<=count($compras)-1;$i++){
		$cantidadCarrito += $compras[$i]['cuantos'];
		echo'<tr>';
			echo '<td>';
				echo 'Concierto : '.$compras[$i]['nombre'].'';
			echo '</td>';
			echo '<td>';
				echo 'Localidad : '.$compras[$i]['cantidad'].'';
			echo '</td>';
			echo '<td>';
				echo 'Posicion : '.$compras[$i]['posicion_mapa_inicio'].'';
			echo '</td>';
			echo '<td>';
				echo 'Fila : '.$compras[$i]['product_id'].'';
			echo '</td>';
			echo '<td>';
				echo 'Asiento : '.$compras[$i]['espromo'].'';
			echo '</td>';
			echo '<td>';
				echo 'Estado : '.$compras[$i]['estadoAsiento'].'';
			echo '</td>';
			echo '<td>';
				echo 'id asiento : '.$compras[$i]['id_asiento'].'';
			echo '</td>';
		echo'</tr>';
	}
	echo '</table>';
	
	echo $cantidadCarrito;
?>