<?php 
	date_default_timezone_set('America/Guayaquil');
	require_once('../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$concierto = $_POST['con'];
	$local = $_POST['idlocal'];
	$numticket = $_POST['numticket'];
	
	$hoy = date("y-m-d");
	
	$sql = "SELECT * FROM ocupadas WHERE concierto = ? AND local = ?";
	$result = $gbd -> prepare($sql);
	$result -> execute(array($concierto,$local));
	
	$arr = array();
	while($row = $result -> fetch(PDO::FETCH_ASSOC)){
		$arr[$row['row']][$row['col']] = array('col' => $row['col'],'status' => $row['status']);
	}
		
	$sql = "SELECT b.idButaca AS id, b.intAsientosB AS col, b.intFilasB AS rows, b.strSecuencial AS secuencial FROM Butaca b WHERE b.intConcB = ? AND b.intLocalB = ?";
	$result = $gbd -> prepare($sql);
	$result -> execute(array($concierto,$local));
	$row = $result -> fetch(PDO::FETCH_ASSOC);
	
	$content = '';
	$content2 = '';
	
	$$content2 .= '<h4>Asientos: </h4>';
	$content = '<table style="display:none;">';
	
	$contador = 1;
	for($i = 1; $i <= $row['rows']; $i++){
		for($y = 1; $y <= $row['col']; $y++){
			if(in_array($y,$arr[$i][$y])){
				
			}else{
				if($contador > $numticket){
					break;
				}
				$query = "SELECT doublePrecioPreventa FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto WHERE dateFechaPreventa >= ? AND idLocalidad = ? AND idConc = ? ORDER BY dateFecha ASC";
				$stmt = $gbd -> prepare($query);
				$stmt -> execute(array($hoy,$local,$concierto));
				$row1 = $stmt -> fetch(PDO::FETCH_ASSOC);
				$numrows = $stmt -> rowCount();
				
				$query2 = "SELECT idLocalidad, strDescripcionL, doublePrecioL, strSecuencial FROM Localidad JOIN Butaca ON Localidad.idLocalidad = Butaca.intLocalB WHERE idLocalidad = ? AND idConc = ?";
				$stmt2 = $gbd -> prepare($query2);
				$stmt2 -> execute(array($local,$concierto));
				$row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
				
				$content .= '
				<tr class="filas_aleatorias asientosok">
					<td>
						<input type="hidden" name="codigo[]" class="added" value="'.$row2['idLocalidad'].'" />
						<input type="hidden" name="row[]" class="added" value="'.$i.'" />
						<input type="hidden" name="col[]" class="added" value="'.$y.'" />
					</td>
					<td>
						<input type="hidden" name="chair[]" class="added" value="Fila-'.$i.'_Silla-'.$y.'" />
					</td>
					<td>
						<input type="hidden" name="des[]" class="added" value="'.$row2['strDescripcionL'].'" />
					</td>
					<td>
						<input type="hidden" name="num[]" class="added" value="1" />
					</td>
					<td>';
					if($numrows > 0){
						$content .= '
						<input type="hidden" name="pre[]" class="added" value="'.$row1['doublePrecioPreventa'].'" />
						<input type="hidden" name="tot[]" class="added" value="'.$row1['doublePrecioPreventa'].'" />';	
					}else{
						$content .= '
						<input type="hidden" name="pre[]" class="added" value="'.$row2['doublePrecioL'].'" />
						<input type="hidden" name="tot[]" class="added" value="'.$row2['doublePrecioL'].'" />';
					}
					$content .= '
					</td>
				</tr>';
				
				$content2 .= '<h4>Fila-'.$i.'_Asiento-'.$y.'</h4>';
				$contador++;
			}
		}
	}
	$content .= '</table>';
	
	echo $content.'|'.$content2;
?>