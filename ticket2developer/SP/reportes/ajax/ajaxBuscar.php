<?php 
	require_once('../../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$distribuidor = $_REQUEST['distribuidor'];
	$desde = $_REQUEST['desde'];
	$hasta = $_REQUEST['hasta'];
	if($desde == ''){
		$desde = '0000-00-00 00:00:00';
	}
	
	if($hasta == ''){
		$hasta = '0000-00-00 00:00:00';
	}
	
	$select = '	select * from transaccion_distribuidor where iddistribuidortrans = "'.$distribuidor.'" group by idconciertotrans  order by idconciertotrans ASC ';
	
	//echo $select;
	
	$stmt = $gbd -> prepare($select);
	$stmt -> execute();
	
	
	$content = '
		<table class="table" style="color:#fff;border:1px solid #ccc;">
			<tr>
				<td style="text-align:center;border:1px solid #ccc;">
					<h4 style="color:#00AEEF;">Concierto</h4>
				</td>
				<td style="text-align:center;border:1px solid #ccc;">
					<h4 style="color:#00AEEF;">Total Boletos Vendidos</h4>
				</td>
				<td style="text-align:center;border:1px solid #ccc;">
					<h4 style="color:#00AEEF;">Total Boletos Cobrados</h4>
				</td>
				<td style="text-align:center;border:1px solid #ccc;">
					<h4 style="color:#00AEEF;">$ Total Ventas</h4>
				</td>
				<td style="text-align:center;border:1px solid #ccc;">
					<h4 style="color:#00AEEF;">$ Total Cobros</h4>
				</td>
				<td style="text-align:center;border:1px solid #ccc;">
					<h4 style="color:#00AEEF;">TOTAL</h4>
				</td>
			</tr>
	';
	$totalboletosvendidos = 0;
	$totalboletoscobrados = 0;
	$totalventas = 0;
	$totalcobros = 0;
	$totaltoal = 0;
	include '../../../conexion.php';
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
		
		$sqlC = 'select strEvento from Concierto where idConcierto = "'.$row['idconciertotrans'].'" ';
		$resC = mysql_query($sqlC) or die (mysql_error());
		$rowC = mysql_fetch_array($resC);
		
		$sqlVentasTotal = 'select count(tipotrans) as vendidos_total , sum(valortrans) as valortrans_vendidos from transaccion_distribuidor where idconciertotrans = "'.$row['idconciertotrans'].'"  and tipotrans = "1" and  iddistribuidortrans = "'.$distribuidor.'"';
		//echo $sqlVentasTotal;
		$resVentasTotal = mysql_query($sqlVentasTotal) or die (mysql_error());
		$rowVentasTotal = mysql_fetch_array($resVentasTotal);
		
		
		$sqlVentas = 'select count(tipotrans) as vendidos , sum(valortrans) as valortrans_cobrados from transaccion_distribuidor where idconciertotrans = "'.$row['idconciertotrans'].'" and tipotrans = "2" and  iddistribuidortrans = "'.$distribuidor.'"';
		$resVentas = mysql_query($sqlVentas) or die (mysql_error());
		$rowVentas = mysql_fetch_array($resVentas);
		
		
		$content .= '
			<tr>
				<td style="text-align:left;border:1px solid #ccc;">
					'.$rowC['strEvento'].'
				</td>
				<td style="text-align:center;border:1px solid #ccc;">
					'.$rowVentasTotal['vendidos_total'].'
				</td>
				<td style="text-align:center;border:1px solid #ccc;">
					'.$rowVentas['vendidos'].'
				</td>
				<td style="text-align:center;border:1px solid #ccc;">
					'.$rowVentasTotal['valortrans_vendidos'].'
				</td>
				<td style="text-align:center;border:1px solid #ccc;">
					'.$rowVentas['valortrans_cobrados'].'
				</td>
				<td style="text-align:center;border:1px solid #ccc;">
					'.number_format(($rowVentas['valortrans_cobrados']+$rowVentasTotal['valortrans_vendidos']),2).'
				</td>
				
			</tr>
		';
		$totalboletosvendidos += $rowVentasTotal['vendidos_total'];
		$totalboletoscobrados += $rowVentas['vendidos'];
		$totalventas += $rowVentasTotal['valortrans_vendidos'];
		$totalcobros += $rowVentas['valortrans_cobrados'];
		$totaltoal += ($rowVentas['valortrans_cobrados']+$rowVentasTotal['valortrans_vendidos']);
		
	}
	$content .= '
			<tr>
				<td style="text-align:center;">
					<h4 style="color:#00AEEF;">TOTALES</h4>
				</td>
				<td style="text-align:center;">
					<h4 style="color:#00AEEF;">'.$totalboletosvendidos.'</h4>
				</td>
				<td style="text-align:center;">
					<h4 style="color:#00AEEF;">'.$totalboletoscobrados.'</h4>
				</td>
				<td style="text-align:center;">
					<h4 style="color:#00AEEF;">$'.number_format($totalventas,2).'</h4>
				</td>
				<td style="text-align:center;">
					<h4 style="color:#00AEEF;">$'.number_format($totalcobros,2).'</h4>
				</td>
				<td style="text-align:center;">
					<h4 style="color:#00AEEF;">$'.number_format($totaltoal,2).'</h4>
				</td>
			</tr>
		</table>
	';
	
	echo $content;
?>