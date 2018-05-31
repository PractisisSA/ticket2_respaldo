	
	<?php
		include '../../conexion.php';
		
		$sqlCo1 = 'select * from Localidad where idConc = "'.$_REQUEST['id_concierto'].'" order by idLocalidad DESC';
		$resCo1 = mysql_query($sqlCo1) or die (mysql_error());
		$num_bol1 = 0;
		$num_bol = 0;
		$num_bol2 = 0;
		$precioNormal = 0;
		$precioTercera = 0;
		$precioNiños = 0;
		$precioTotal = 0;
		$sum_num_bol1 = 0;
		$sum_num_bol = 0;
		$sum_num_bol2 = 0;
		$sum_bol_emp = 0;
		$sum_precioTotal = 0;
		while($rowCo1 = mysql_fetch_array($resCo1)){
			if($rowCo1['idLocalidad'] == 100){
				$num_bol1 = 59;
				$num_bol = 0;
				$num_bol2 = 31;
			}
			
			
			if($rowCo1['idLocalidad'] == 99){
				$num_bol1 = 87;
				$num_bol = 10;
				$num_bol2 = 54;
			}
			
			
			if($rowCo1['idLocalidad'] == 98){
				$num_bol1 =330;
				$num_bol = 0;
				$num_bol2 = 87;
			}
			$sqlCor11 = 'select count(idBoleto) as num_bol from Boleto where idLocB = "'.$rowCo1['idLocalidad'].'" and tercera = "0" and nombreHISB = "empresario_vendido" ';
			$resCor11 = mysql_query($sqlCor11) or die (mysql_error());
			$rowCor1 = mysql_fetch_array($resCor11);
			//$num_bol1 = ($rowCor1['num_bol'] - $rowCor1['numbol_devueltos']);
			$sum_num_bol1 += $num_bol1;
			
			
			$sqlCor = 'select count(idBoleto) as num_bol from Boleto where idLocB = "'.$rowCo1['idLocalidad'].'" and tercera = "1" and nombreHISB = "empresario_vendido" ';
			$resCor = mysql_query($sqlCor) or die (mysql_error());
			$rowCor = mysql_fetch_array($resCor);
			//$num_bol = ($rowCor['num_bol'] - $rowCor['numbol_devueltos']);
			$sum_num_bol += $num_bol;
			
			$sqlCor2 = 'select count(idBoleto) as num_bol from Boleto where idLocB = "'.$rowCo1['idLocalidad'].'" and tercera = "2" and nombreHISB = "empresario_vendido" ';
			$resCor2 = mysql_query($sqlCor2) or die (mysql_error());
			$rowCor2 = mysql_fetch_array($resCor2);
			//$num_bol2 = ($rowCor2['num_bol'] - $rowCor2['numbol_devueltos']);
			$sum_num_bol2 += $num_bol2;
			
			$precioNormal = ($num_bol1 * $rowCo1['doublePrecioL']);
			$precioTercera = ($num_bol * ($rowCo1['doublePrecioL'] * 0.5));
			$precioNiños = ($num_bol2 * ($rowCo1['doublePrecioL'] * 0));
			
			$precioTotal = ($precioNormal + $precioTercera + $precioNiños);
			$sum_precioTotal += $precioTotal;
			$boletos_emp = ($num_bol1 + $num_bol2 + $num_bol);
			$sum_bol_emp += $boletos_emp;
	?>
		<tr style = 'font-size:12px;' >
			
			<td align='center'>
				<?php echo $rowCo1['strDescripcionL'];?>
			</td>
			<td align='center'>
				<?php echo $rowCo1['doublePrecioL'];?>
			</td>
			<td align='center'>
				<?php echo $num_bol1;?>
			</td>
			
			<td align='center'>
				<?php echo $num_bol;?>
			</td>
			<td align='center'>
				<?php echo $num_bol2;?>
			</td>
			<td align='center'>
				<?php echo $boletos_emp;?>
			</td>
			<td align='center'>
				<?php echo $precioTotal;?>
			</td>
			
		</tr>
	<?php
		}
	?>
	
		<tr style = 'font-size:12px;' >
			
			<td align='center'>
				Total
			</td>
			<td align='center'>
				
			</td>
			<td align='center'>
				<?php echo $sum_num_bol1;?>
			</td>
			
			<td align='center'>
				<?php echo $sum_num_bol;?>
			</td>
			<td align='center'>
				<?php echo $sum_num_bol2;?>
			</td>
			<td align='center'>
				<?php echo $sum_bol_emp;?>
			</td>
			<td align='center'>
				<?php echo $sum_precioTotal;?>
			</td>
			
		</tr>
	