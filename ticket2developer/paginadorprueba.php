<?php
	require_once 'classes/private.db.php';
	
	$gbd = new DBConn();
	
	$select = "SELECT * FROM Concierto";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute();
	$num_total_registros = $stmt -> rowCount();
	// echo $num_total_registros;
	if($num_total_registros > 0){
		$rowsPerPage = 5;
		
		$pageNum = 1;
		
		if(isset($_GET['page'])) {
			sleep(1);
			$pageNum = $_GET['page'];
		}
		
		$offset = ($pageNum - 1) * $rowsPerPage;
		$total_paginas = ceil($num_total_registros / $rowsPerPage);
		
		$selectLimit = "SELECT * FROM Concierto LIMIT $offset, $rowsPerPage";
		$query_services = $gbd -> prepare($selectLimit);
		$query_services -> execute();
		
		echo '<table style="width:100%;"> 
				<tr>
					<td>
						Fecha y Hora
					</td>
					<td>
						Usuario
					</td>
					<td>
						Evento Realizado
					</td>
					<td>
						Usuario Afectado
					</td>
					<td>
						Detalle de Cambios
					</td>
				</tr>';
		$i = 0;
		
		while($row = $query_services -> fetch(PDO::FETCH_ASSOC)){
			echo '<tr>
					<td>
						'.$row['fechaCreacionC'].'
					</td>
					<td>
						'.$row['createbyC'].'
					</td>
					<td>
						'.$row['strEvento'].'
					</td>
					<td>
						'.$row['idUser'].'
					</td>
					<td>
						'.$row['obsModifyC'].'
					</td>
				</tr>';
		}
		echo '</table>
			<br>
			<table align="center">
				<tr style="text-align:center;">
					<td colspan="5">';
						if ($total_paginas > 1) {
							echo '<div class="pagination">';
							echo '<ul>';
								if ($pageNum != 1)
										echo '<li><a class="paginate" data="'.($pageNum - 1).'">Anterior</a></li>';
									for ($i = 1; $i <= $total_paginas; $i++) {
										if ($pageNum == $i)
											echo '<li class="active"><a>'.$i.'</a></li>';
										else
											echo '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
								}
								if ($pageNum != $total_paginas)
										echo '<li><a class="paginate" data="'.($pageNum + 1).'">Siguiente</a></li>';
						   echo '</ul>';
						   echo '</div>';
						}
		echo'		</td>
				</tr>
				<tr>
					<td colspan="5" height="20px"></td>
				</tr>
			</table>';
	}else{
		echo '<table>
				<tr>
					<td>
						Fecha y Hora
					</td>
					<td>
						Usuario
					</td>
					<td>
						Evento Realizado
					</td>
					<td>
						Usuario Afectado
					</td>
					<td>
						Detalle de Cambios
					</td>
				</tr>
				<trd>
					<td colspan="6">
						No hay Datos
					</td>
				</tr>
			</table>';
	}
?>