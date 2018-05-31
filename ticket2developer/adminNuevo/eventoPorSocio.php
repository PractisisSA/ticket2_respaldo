<?php 
	//include("../controlusuarios/seguridadSA.php");
	
	include '../conexion.php';
	$idS = $_REQUEST['socio'];
	
	if($idS == 0){
		$filtro = '';
	}else{
		$filtro = 'idUser = "'.$idS.'" AND';
	}
	
	$selecConcierto = 'SELECT * FROM Concierto WHERE  '.$filtro.' strEstado = "Activo" ' ;
	//echo $selecConcierto;
	$resultSelectConcierto = mysql_query($selecConcierto)  or die(mysql_error());


	$i=0;
	echo '	<tr>
				<td colspan = "2" style="width: 60px">
					N°
				</td>
				<td style = "text-align:center;">
					Evento
				</td>
			</tr>';
	while($row = mysql_fetch_array($resultSelectConcierto)){
		$id = $row['idConcierto'];
		$evento = $row['strEvento'];
		if($i == 0){
			echo '<tr>';
		}
			echo"	<td>
						(".$id.")
					</td>
					<td>
						<input type = 'checkbox' class = 'eventos_socio' value = '".$id."' />
					</td>
					<td>
						&nbsp;&nbsp;&nbsp;&nbsp;".$evento."
					</td>";
		if($i == 0){
			echo '</tr>';
			$i=0;
		}else{
			$i++;
		}
   }
    
?>