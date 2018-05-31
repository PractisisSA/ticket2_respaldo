<?php 
	require_once('../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$id_local = $_REQUEST['local'];
	$id_concierto = $_REQUEST['concierto'];
	$id_area_mapa = $_REQUEST['id'];
	
	$sql = "SELECT * FROM ocupadas WHERE concierto = ? AND local = ?";
	$result = $gbd -> prepare($sql);
	$result -> execute(array($id_concierto,$id_local));
	
	$arr = array();
	while($row = $result -> fetch(PDO::FETCH_ASSOC)){
		$arr[$row['row']][$row['col']] = array('col' => $row['col'],'status' => $row['status']);
		}
		
	$sql = "SELECT b.idButaca AS id, b.intAsientosB AS col, b.intFilasB AS rows, b.strSecuencial AS secuencial FROM Butaca b WHERE b.intConcB = ? AND b.intLocalB = ?";
	$result = $gbd -> prepare($sql);
	$result -> execute(array($id_concierto,$id_local));
	$row = $result -> fetch(PDO::FETCH_ASSOC);
	
	// if($id_area_mapa < 1){
		// $continue_seat = (($id_area_mapa * 30) + 1);
		// $a = ($id_area_mapa + 1);
		// $limit = ($a * 30);
	// }else 
	
	if($id_area_mapa > 1){
		$area = $id_area_mapa - 1;
		$continue_seat = (($area * 30) + 1);
		$limit = ($id_area_mapa * 30);
	}
	
	echo '<center>';
	echo '<div id="contar_boletos'.$id_local.'_'.$id_area_mapa.'" class="contar_boletos'.$id_local.' ocultar'.$id_local.' mostrartable'.$id_area_mapa.'"><table id="num_cols'.$id_local.'_'.$id_area_mapa.'" class="columnas_num'.$id_local.'" style="width:auto;" align="center"><tr>';
		echo '<td style="text-align:center; vertical-align:middle; font-size:12px; color:#fff;"><strong>Cols-></strong></td>';
		for($j = $continue_seat; $j <= $limit; $j++){
			if($j > $row['col']){
				break;
			}
			echo '<td style="font-size:10px; color:#fff;"><strong>'.$j.'</strong></td>';
		}
	echo '</tr>';
	echo '<tr id="asientos_local-'.$id_local.'_'.$id_area_mapa.'" class="asiento_local-'.$id_local.'">';
	for($i = 1; $i <= $row['rows']; $i++){
		if($row['secuencial'] == 0){
			echo '<td style="font-size:10px; color:#fff;"><strong>FILA-'.$i.'</strong></td>';
		}else if($row['secuencial'] == 1){
			if($i == 1){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-A</strong></td>';
			}
			if($i == 2){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-B</strong></td>';
			}
			if($i == 3){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-C</strong></td>';
			}
			if($i == 4){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-D</strong></td>';
			}
			if($i == 5){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-E</strong></td>';
			}
			if($i == 6){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-F</strong></td>';
			}
			if($i == 7){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-G</strong></td>';
			}
			if($i == 8){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-H</strong></td>';
			}
			if($i == 9){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-I</strong></td>';
			}
			if($i == 10){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-J</strong></td>';
			}
			if($i == 11){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-K</strong></td>';
			}
			if($i == 12){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-L</strong></td>';
			}
			if($i == 13){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-M</strong></td>';
			}
			if($i == 14){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-N</strong></td>';
			}
			if($i == 15){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-O</strong></td>';
			}
			if($i == 16){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-P</strong></td>';
			}
			if($i == 17){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-Q</strong></td>';
			}
			if($i == 18){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-R</strong></td>';
			}
			if($i == 19){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-S</strong></td>';
			}
			if($i == 20){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-T</strong></td>';
			}
			if($i == 21){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-U</strong></td>';
			}
			if($i == 22){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-V</strong></td>';
			}
			if($i == 23){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-W</strong></td>';
			}
			if($i == 24){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-X</strong></td>';
			}
			if($i == 25){
				echo '<td style="font-size:10px; color:#fff;"><strong>FILA-Y</strong></td>';
			}
		}
		for($y = $continue_seat; $y <= $limit; $y++){
			if($y > $row['col']){
				break;
			}
			if(in_array($y,$arr[$i][$y])){ 
				if($arr[$i][$y]['status'] == 1){
					echo '<td style="vertical-align:middle;"><div style="background-color:red; width:30px; height:30px; border:1px solid #000;"></div></td>';
				}else if($arr[$i][$y]['status'] == 2){
					echo '<td style="vertical-align:middle;"><div style="background-color:#fbed2c; width:30px; height:30px; border: 1px solid #000;"></div></td>';
				}else if($arr[$i][$y]['status'] == 3){
					echo '<td style="vertical-align:middle;"><div style="background-color:#000; width:30px; height:30px; border: 1px solid #fff;"></div></td>';
				}
			}else{
				echo '<td style="vertical-align:middle;">
						<div style="background-color:#fff; text-align:center; font-size:10px; width:30px; height:30px; color:#000; border:1px solid #000; cursor:pointer;" class="inputchk'.$id_local.'" id="A-'.$id_local.'-'.$i.'-'.$y.'" onclick="add_asientos('.$id_local.','.$id_concierto.','.$i.','.$y.')">'.$y.'</div>
					</td>';
			}
		}
		echo '</tr>';
	}
	echo '</table></div></center><br>';
?>