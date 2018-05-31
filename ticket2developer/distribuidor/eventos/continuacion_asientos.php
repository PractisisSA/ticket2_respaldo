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
			echo '<td style="font-size:10px; color:#fff;"><strong>Fila-'.$i.'</strong></td>';
			$ff = $i;
		}else if($row['secuencial'] == 1){
			if($i == 1){
				$ff = 'A';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-A</strong></td>';
			}
			if($i == 2){
				$ff = 'B';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-B</strong></td>';
			}
			if($i == 3){
				$ff = 'C';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-C</strong></td>';
			}
			if($i == 4){
				$ff = 'D';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-D</strong></td>';
			}
			if($i == 5){
				$ff = 'E';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-E</strong></td>';
			}
			if($i == 6){
				$ff = 'F';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-F</strong></td>';
			}
			if($i == 7){
				$ff = 'G';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-G</strong></td>';
			}
			if($i == 8){
				$ff = 'H';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-H</strong></td>';
			}
			if($i == 9){
				$ff = 'I';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-I</strong></td>';
			}
			if($i == 10){
				$ff = 'J';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-J</strong></td>';
			}
			if($i == 11){
				$ff = 'K';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-K</strong></td>';
			}
			if($i == 12){
				$ff = 'L';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-L</strong></td>';
			}
			if($i == 13){
				$ff = 'M';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-M</strong></td>';
			}
			if($i == 14){
				$ff = 'N';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-N</strong></td>';
			}
			if($i == 15){
				$ff = 'O';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-O</strong></td>';
			}
			if($i == 16){
				$ff = 'P';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-P</strong></td>';
			}
			if($i == 17){
				$ff = 'Q';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-Q</strong></td>';
			}
			if($i == 18){
				$ff = 'R';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-R</strong></td>';
			}
			if($i == 19){
				$ff = 'S';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-S</strong></td>';
			}
			if($i == 20){
				$ff = 'T';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-T</strong></td>';
			}
			if($i == 21){
				$ff = 'U';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-U</strong></td>';
			}
			if($i == 22){
				$ff = 'V';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-V</strong></td>';
			}
			if($i == 23){
				$ff = 'W';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-W</strong></td>';
			}
			if($i == 24){
				$ff = 'X';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-X</strong></td>';
			}
			if($i == 25){
				$ff = 'Y';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-Y</strong></td>';
			}
			
			if($i == 26){
				$ff = 'Z';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-Z</strong></td>';
			}
			
			if($i == 27){
				$ff = 'AA';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AA</strong></td>';
			}
			
			if($i == 28){
				$ff = 'AB';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AB</strong></td>';
			}
			
			if($i == 29){
				$ff = 'AC';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AC</strong></td>';
			}
			
			if($i == 30){
				$ff = 'AD';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AD</strong></td>';
			}
			
			
			
			if($i == 31){
				$ff = 'AE';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AE</strong></td>';
			}
			if($i == 32){
				$ff = 'AF';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AF</strong></td>';
			}
			if($i == 33){
				$ff = 'AG';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AG</strong></td>';
			}
			if($i == 34){
				$ff = 'AH';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AH</strong></td>';
			}
			if($i == 35){
				$ff = 'AI';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AI</strong></td>';
			}
			
			if($i == 36){
				$ff = 'AJ';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AJ</strong></td>';
			}
			
			if($i == 37){
				$ff = 'AK';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AK</strong></td>';
			}
			
			if($i == 38){
				$ff = 'AL';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AL</strong></td>';
			}
			
			if($i == 39){
				$ff = 'AM';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AM</strong></td>';
			}
			
			if($i == 40){
				$ff = 'AN';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AN</strong></td>';
			}
			
			
			if($i == 41){
				$ff = 'AO';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AO</strong></td>';
			}
			if($i == 42){
				$ff = 'AP';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AP</strong></td>';
			}
			if($i == 43){
				$ff = 'AQ';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AQ</strong></td>';
			}
			if($i == 44){
				$ff = 'AR';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AR</strong></td>';
			}
			if($i == 45){
				$ff = 'AS';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AS</strong></td>';
			}
			
			if($i == 46){
				$ff = 'AT';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AT</strong></td>';
			}
			
			if($i == 47){
				$ff = 'AU';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AU</strong></td>';
			}
			
			if($i == 48){
				$ff = 'AV';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AV</strong></td>';
			}
			
			if($i == 49){
				$ff = 'AW';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AW</strong></td>';
			}
			
			if($i == 50){
				$ff = 'AX';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AX</strong></td>';
			}

			if($i == 51){
				$ff = 'AY';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AY</strong></td>';
			}
			if($i == 52){
				$ff = 'AZ';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-AZ</strong></td>';
			}
			if($i == 53){
				$ff = 'BA';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BA</strong></td>';
			}
			if($i == 54){
				$ff = 'BB';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BB</strong></td>';
			}
			if($i == 55){
				$ff = 'BC';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BC</strong></td>';
			}
			
			if($i == 56){
				$ff = 'BD';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BD</strong></td>';
			}
			
			if($i == 57){
				$ff = 'BE';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BE</strong></td>';
			}
			
			if($i == 58){
				$ff = 'BF';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BF</strong></td>';
			}
			
			if($i == 59){
				$ff = 'BG';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BG</strong></td>';
			}
			
			if($i == 60){
				$ff = 'BH';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BH</strong></td>';
			}
			
			if($i == 61){
				$ff = 'BI';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BI</strong></td>';
			}
			if($i == 62){
				$ff = 'BJ';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BJ</strong></td>';
			}
			if($i == 63){
				$ff = 'BK';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BK</strong></td>';
			}
			if($i == 64){
				$ff = 'BL';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BL</strong></td>';
			}
			if($i == 65){
				$ff = 'BM';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BM</strong></td>';
			}
			
			if($i == 66){
				$ff = 'BN';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BN</strong></td>';
			}
			
			if($i == 67){
				$ff = 'BO';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BO</strong></td>';
			}
			
			if($i == 68){
				$ff = 'BP';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BP</strong></td>';
			}
			
			if($i == 69){
				$ff = 'BQ';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BQ</strong></td>';
			}
			
			if($i == 70){
				$ff = 'BR';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BR</strong></td>';
			}
			
			
			if($i == 71){
				$ff = 'BS';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BS</strong></td>';
			}
			if($i == 72){
				$ff = 'BT';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BT</strong></td>';
			}
			if($i == 73){
				$ff = 'BU';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BU</strong></td>';
			}
			if($i == 74){
				$ff = 'BV';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BV</strong></td>';
			}
			if($i == 75){
				$ff = 'BW';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BW</strong></td>';
			}
			
			if($i == 76){
				$ff = 'BX';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BX</strong></td>';
			}
			
			if($i == 77){
				$ff = 'BY';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BY</strong></td>';
			}
			
			if($i == 78){
				$ff = 'BZ';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-BZ</strong></td>';
			}
			
			if($i == 79){
				$ff = 'CA';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-CA</strong></td>';
			}
			
			if($i == 80){
				$ff = 'CB';
				echo '<td style="font-size:10px; color:#fff;"><strong>Fila-CB</strong></td>';
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
						<div style="background-color:#fff; text-align:center; font-size:10px; width:30px; height:30px; color:#000; border:1px solid #000; cursor:pointer;" class="inputchk'.$id_local.'" id="A-'.$id_local.'-'.$ff.'-'.$y.'" onclick="add_asientos('.$id_local.','.$id_concierto.',\''.$ff.'\','.$y.')">'.$y.'</div>
					</td>';
			}
		}
		echo '</tr>';
	}
	echo '</table></div></center><br>';
?>