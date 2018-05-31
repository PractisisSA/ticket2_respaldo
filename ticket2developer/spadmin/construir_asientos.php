<?php 
	require('../Conexion/conexion.php');
	
	$id_localidad = $_REQUEST['id'];
	$id_concierto = $_REQUEST['concierto'];

	$sql = "SELECT * FROM ocupadas WHERE concierto = '$id_concierto' AND local = '$id_localidad'";
	$result = $mysqli->query($sql);
	
	
	$arr = array();
	while($row = mysqli_fetch_array($result)){
		$arr[$row['row']][$row['col']] = array('col' => $row['col'],'status' => $row['status']);
	}
	print_r($arr);
	$sql = "SELECT b.idButaca AS id, b.intAsientosB AS col, b.intFilasB AS rows, b.strSecuencial AS secuencial FROM Butaca b WHERE b.intConcB = '$id_concierto' AND b.intLocalB = '$id_localidad'";
	$result = $mysqli -> query($sql);
	$row = mysqli_fetch_array($result);
	
	
	echo '<tr class="table_bd'.$id_localidad.'">';
		echo '<td style="text-align:center; vertical-align:middle;" colspan="3"><strong>Col --> Disp</strong></td>';
		for($j = 1; $j <= $row['col']; $j++){
			echo '<td style="text-align:center; vertical-align:middle;border:1px solid #000;padding-left:3px;padding-right:3px;"><strong>'.$j.'</strong></td>';
		}
	echo '</tr>';
	for($i = 1; $i <= $row['rows']; $i++){
		$select = "SELECT * FROM ocupadas WHERE local = '$id_localidad' AND row = '$i' group by col";
		$resultado = $mysqli->query($select);
		$filas = mysqli_num_rows($resultado);
		$rowselect = mysqli_fetch_array($resultado);
		$numero_cols = $row['col'] - $filas;
		
		echo '<tr class="table_bd'.$id_localidad.'" style="color:#000;">
			<td>
				<img id="add'.$id_localidad.'_'.$i.'" src="imagenes/aumentar.png" style="width:18px; height:18px; display:none; float:left;" onclick="addseats('.$i.','.$id_localidad.')" />
				<img id="remove'.$id_localidad.'_'.$i.'" src="imagenes/quitar.png" style="width:18px; height:18px;" onclick="removeseats('.$i.','.$id_localidad.')" />
			</td>';
		if($row['secuencial'] == 0){
			echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-'.$i.'</strong></td>';
		}else if($row['secuencial'] == 1){
			if($i == 1){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-A</strong></td>';
			}
			if($i == 2){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-B</strong></td>';
			}
			if($i == 3){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-C</strong></td>';
			}
			if($i == 4){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-D</strong></td>';
			}
			if($i == 5){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-E</strong></td>';
			}
			if($i == 6){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-F</strong></td>';
			}
			if($i == 7){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-G</strong></td>';
			}
			if($i == 8){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-H</strong></td>';
			}
			if($i == 9){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-I</strong></td>';
			}
			if($i == 10){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-J</strong></td>';
			}
			if($i == 11){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-K</strong></td>';
			}
			if($i == 12){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-L</strong></td>';
			}
			if($i == 13){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-M</strong></td>';
			}
			if($i == 14){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-N</strong></td>';
			}
			if($i == 15){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-O</strong></td>';
			}
			if($i == 16){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-P</strong></td>';
			}
			if($i == 17){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-Q</strong></td>';
			}
			if($i == 18){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-R</strong></td>';
			}
			if($i == 19){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-S</strong></td>';
			}
			if($i == 20){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-T</strong></td>';
			}
			if($i == 21){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-U</strong></td>';
			}
			if($i == 22){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-V</strong></td>';
			}
			if($i == 23){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-W</strong></td>';
			}
			if($i == 24){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-X</strong></td>';
			}
			if($i == 25){
				echo '<td style="text-align:center; vertical-align:middle;"><strong>FILA-Y</strong></td>';
			}
		}
		echo '<td style="text-align:center; vertical-align:middle;">';
				// echo $select."<br>";
				// echo $row['col']." - ".$filas."<br>";
			if($i == $rowselect['row']){
				echo '<input type="text" id="totalAsientos'.$i.'-'.$id_localidad.'" class="AsientosXfila'.$i.'-'.$id_localidad.'" value="'.$numero_cols.'" size="3" onkeyup="ColsXtext('.$i.','.$id_localidad.','.$row['col'].')" />';
			}else{
				echo '<input type="text" id="totalAsientos'.$i.'-'.$id_localidad.'" class="AsientosXfila'.$i.'-'.$id_localidad.'" value="'.$row['col'].'" size="3" onkeyup="ColsXtext('.$i.','.$id_localidad.','.$row['col'].')" />';
			}
		echo '</td>';
		for($y = 1; $y <=  $row['col']; $y++){
			if(in_array($y,$arr[$i][$y])){
				if($arr[$i][$y]['status'] == 1){
					echo '<td class="vendidos'.$id_localidad.'" style="vertical-align:middle;border:1px solid #000;padding-left:3px;padding-right:3px;"><center><div style="background-color: red; width: 13px; height: 13px; margin-top:5px; display: inline-block; border: 1px solid #000;" ></div></center></td>';
				}else{
					if($arr[$i][$y]['status'] == 2){
						echo '<td class="vendidos'.$id_localidad.'" style="vertical-align:middle;border:1px solid #000;padding-left:3px;padding-right:3px;"><center><div style="background-color: navy; width: 13px; height: 13px; margin-top:5px; display: inline-block; border: 1px solid #000;" ></div></center></td>';
					}else{
						if($arr[$i][$y]['status'] == 3){
							echo '<td style="vertical-align:middle;border:1px solid #000;padding-left:3px;padding-right:3px;"><center><div style="background-color: #000; width: 13px; height: 13px; margin-top:5px; display: inline-block; border: 1px solid #000;" ></div></center></td>';
						}
					}
				}
			}else{
				echo '<td style="text-align:center; vertical-align:middle;border:1px solid #000;padding-left:3px;padding-right:3px;" class="grid'.$i.'_'.$id_localidad.'" id="fl-'.$i.'_as-'.$y.'_cod-'.$id_localidad.'">
						<input type="checkbox" id="F-'.$i.'_A-'.$y.'_C-'.$id_localidad.'" checked="checked" onclick="seatok('.$i.','.$y.','.$id_localidad.')" />
						<center>
							<div id="file-'.$i.'_A-'.$y.'_C-'.$id_localidad.'" style="width:13px; height:13px; background-color:#000; display:none;"></div>
						</center>
					</td>';
			}
		}
		echo '</tr>';
	}
?>