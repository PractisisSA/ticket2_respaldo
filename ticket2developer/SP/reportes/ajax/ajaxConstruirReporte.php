<?php 
	require_once('../../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$distribuidor = $_POST['distribuidor'];
	$reporte = $_POST['reporte'];
	$concierto = $_POST['concierto'];
	
	if($reporte == 1){
		$filtro = 'porcentajeventaDis';
		$title = '% Venta';
	}else{
		$filtro = 'porcentajecobroDis';
		$title = '% Cobro';
	}
	
	$content = '';
	
	$query = "SELECT * FROM transaccion_distribuidor WHERE iddistribuidortrans = ? AND tipotrans = ? AND idconciertotrans = ?";
	$stmt = $gbd -> prepare($query);
	$stmt -> execute(array($distribuidor,$reporte,$concierto));
	$num_total_registros = $stmt -> rowCount();
	
	if($num_total_registros > 0){
		$rowsPerPage = 30;
		
		$pageNum = 1;
		
		if(isset($_GET['page'])) {
			sleep(1);
			$pageNum = $_GET['page'];
		}
		
		$offset = ($pageNum - 1) * $rowsPerPage;
		$total_paginas = ceil($num_total_registros / $rowsPerPage);
		
		$query1 = "SELECT sum(valortrans) as valor, count(idclientetrans) as tickets, strNombresC, strEvento, pagotrans, valortrans, ((valortrans * ".$filtro.")/100) as ventas, tarjetaDis FROM transaccion_distribuidor JOIN Concierto ON transaccion_distribuidor.idconciertotrans = Concierto.idConcierto JOIN Cliente ON transaccion_distribuidor.idclientetrans = Cliente.idCliente JOIN distribuidor ON transaccion_distribuidor.iddistribuidortrans = distribuidor.idDistribuidor WHERE iddistribuidortrans = ? AND tipotrans = ? AND idconciertotrans = ? GROUP BY idclientetrans LIMIT $offset, $rowsPerPage";
		$stmt1 = $gbd -> prepare($query1);
		$stmt1 -> execute(array($distribuidor,$reporte,$concierto));
		
			$content .= '
			<table style="width:100%;">
				<tr> 
					<td style="text-align:center;">
						<h4 style="color:#00AEEF;">Cliente</h4>
					</td>
					<td style="text-align:center;">
						<h4 style="color:#00AEEF;">Concierto</h4>
					</td>
					<td style="text-align:center;">
						<h4 style="color:#00AEEF;">Forma de Pago</h4>
					</td>
					<td style="text-align:center;">
						<h4 style="color:#00AEEF;"># Tickets</h4>
					</td>
					<td style="text-align:center;">
						<h4 style="color:#00AEEF;">Valor Total</h4>
					</td>
					<!--<td style="text-align:center;">
						<h4 style="color:#00AEEF;">'.$title.'</h4>
					</td>-->
					<td style="text-align:center;">
						<h4 style="color:#00AEEF;">% Tarjeta</h4>
					</td>
				</tr>';
		
		while($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)){
			$porvalor = $row['ventas'] * $row['tickets'];
			$porvalor = number_format($porvalor,2);
			$content .= '
				<tr class="filasreporte" style="color:#fff;">
					<td style="text-align:center;">
						'.$row['strNombresC'].'
					</td>
					<td style="text-align:center;">
						'.$row['strEvento'].'
					</td>
					<td style="text-align:center;">
						'.$row['pagotrans'].'
					</td>
					<td style="text-align:center;">
						'.$row['tickets'].'
					</td>
					<td style="text-align:center;">
						'.$row['valor'].'
					</td>
					<!--<td style="text-align:center;">
						'.$porvalor.'
					</td>-->
					<td style="text-align:center;">';
						if($row['pagotrans'] == 'Tarjeta de Credito'){
							$portarjeta = (($row['valor'] * $row['tarjetaDis']) / 100 );
							$portarjeta = number_format($portarjeta,2);
							$content .= ''.$portarjeta.'';
						}else{
							$content .= '0.00';
						}
				$content .= '
					</td>
				</tr>';
		}
		$content .= '
			</table>
			<br>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-5">';
					if ($total_paginas > 1) {
						$content .= '
						<div class="pagination">
							<ul>';
							if ($pageNum != 1)
									$content .= '<li><a class="paginate" data="'.($pageNum - 1).'">Anterior</a></li>';
								for ($i = 1; $i <= $total_paginas; $i++) {
									if ($pageNum == $i)
										$content .= '<li class="active"><a>'.$i.'</a></li>';
									else
										$content .= '<li><a class="paginate" data="'.$i.'">'.$i.'</a></li>';
							}
							if ($pageNum != $total_paginas)
									$content .= '<li><a class="paginate" data="'.($pageNum + 1).'">Siguiente</a></li>';
					   $content .= '
							</ul>
					   </div>';
					}
		$content .= '	
				</div>
			</div>
			<div class="row">
			</div>';
	}else{
		$content .=  '
			<div class="row"> 
				<div class="col-xs-2" style="text-align:center; margin-left:50px;">
					<h4 style="color:#00AEEF;">Cliente</h4>
				</div>
				<div class="col-xs-2" style="text-align:center;">
					<h4 style="color:#00AEEF;">Concierto</h4>
				</div>
				<div class="col-xs-2" style="text-align:center;">
					<h4 style="color:#00AEEF;">Forma de Pago</h4>
				</div>
				<div class="col-xs-2" style="text-align:center;">
					<h4 style="color:#00AEEF;"># Tickets</h4>
				</div>
				<div class="col-xs-2" style="text-align:center;">
					<h4 style="color:#00AEEF;">Valor Total</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12" style="color:#67E21B; text-align:center;">
					<h3>No hay datos...</h3>
				</div>
			</div>';
	}
	
	$query2 = "SELECT sum(valortrans) as efectivo FROM transaccion_distribuidor WHERE iddistribuidortrans = ? AND tipotrans = ? AND idconciertotrans = ? AND pagotrans = ?";
	$stmt2 = $gbd -> prepare($query2);
	$stmt2 -> execute(array($distribuidor,$reporte,$concierto,'Efectivo'));
	$row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
	$efectivo = $row2['efectivo'];
	
	$query3 = "SELECT sum(valortrans) as tarjeta FROM transaccion_distribuidor WHERE iddistribuidortrans = ? AND tipotrans = ? AND idconciertotrans = ? AND pagotrans = ?";
	$stmt3 = $gbd -> prepare($query3);
	$stmt3 -> execute(array($distribuidor,$reporte,$concierto,'Tarjeta de Credito'));
	$row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC);
	$tarjeta = $row3['tarjeta'];
	
	echo $content.'|'.$efectivo.'|'.$tarjeta;
?>