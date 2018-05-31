<?php 
	session_start();
	// ini_set('display_startup_errors',1);
	// ini_set('display_errors',1);
	// error_reporting(-1);
	
	date_default_timezone_set('America/Guayaquil');
	require_once('../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$concierto = $_REQUEST['con'];
	$local = $_REQUEST['idlocal'];
	$numticket = $_REQUEST['numticket_2'];
	$_SESSION['localidad'] = $local;
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
	
	$content2 .= '<h4>Asientos: </h4>';
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
				
				$codigo = $row2['idLocalidad'];
				$roww = $i;
				$coll = $y;
				$chair = 'Fila-'.$i.'_Silla-'.$y.'';
				$des = $row2['strDescripcionL'];
				$num = 1;
				if($numrows > 0){
					$pre = $row1['doublePrecioPreventa'];
					$tot = $row1['doublePrecioPreventa'];
				}else{
					$pre = $row2['doublePrecioL'];
					$tot = $row2['doublePrecioL'];
				}
				$compras[]=array("codigo"=>$codigo,"row"=>$roww,"col"=>$coll ,"chair"=>$chair,"des"=>$des,"num"=>$num,"pre"=>$pre,"tot"=>$tot);
				
				
		

				$content .= '
				<tr class="filas_aleatorias asientosok">
					<td>
						'.$contador.'<input type="hidden" name="codigo[]" class="added" value="'.$row2['idLocalidad'].'" />
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
						$pre = $row1['doublePrecioPreventa'];
						$tot = $row1['doublePrecioPreventa'];
						$content .= '
						<input type="hidden" name="pre[]" class="added" value="'.$row1['doublePrecioPreventa'].'" />
						<input type="hidden" name="tot[]" class="added" value="'.$row1['doublePrecioPreventa'].'" />';	
					}else{
						$pre = $row2['doublePrecioL'];
						$tot = $row2['doublePrecioL'];
						$content .= '
						<input type="hidden" name="pre[]" class="added" value="'.$row2['doublePrecioL'].'" />
						<input type="hidden" name="tot[]" class="added" value="'.$row2['doublePrecioL'].'" />';
					}
					$content .= '
					</td>
				</tr>';
				
				$content2 .= '<h4>Fila-'.$i.'_Asiento-'.$y.' [[<<>>]]'.$contador.'</h4>';
				$contador++;
			}
			
			
		}
	}
	$content .= '</table>';
	
	echo $content.'|'.$content2;
	$_SESSION['carrito']=$compras;
	
	
	// $compras = $_SESSION['carrito'];
	// for($i=0;$i<=count($compras);$i++){
		// echo "<br/><br/><br/>".$i.".ID:".$compras[$i]['codigo']."<br/>";
		// echo "Nombre:".$compras[$i]['row']."<br/>";
		// echo "Cantidad:".$compras[$i]['col']."<br/><br/>";
		// echo "Precio:".$compras[$i]['chair']."<br/><br/>";
		// echo "des:".$compras[$i]['des']."<br/><br/>";
		// echo "nunm:".$compras[$i]['num']."<br/><br/>";
		// echo "pre:".$compras[$i]['pre']."<br/><br/>";
		// echo "tot".$compras[$i]['tot']."<br/><br/>";
	// }
?>