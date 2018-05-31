	
<div class='row'>
		<div class='col-md-1'></div>
		<div class='col-md-10'>
			<div class="panel panel-default">
				<input type="button" onclick="tableToExcel_desglose('desglose', 'DESGLOSE DE DESCUENTOS ')" class="botonimagen" title='Descargar Reporte Excel' value=''/>
				<table class="table" style ='color:#000;' id = 'desglose'>
					<thead>
						<tr>
							<th colspan = '5'>
								DESGLOSE DE DESCUENTOS<br>
								
							</th>
						</tr>
						<tr>
							<th  style = 'border:1px solid #ccc;text-align:left;' >Localidad</td>
							<th  style = 'border:1px solid #ccc;text-align:left;'>Descuento</td>
							<th  style = 'border:1px solid #ccc;text-align:left;'>Tickets</td>
							<th  style = 'border:1px solid #ccc;text-align:left;'>Valor</td>
							<th  style = 'border:1px solid #ccc;text-align:left;'>Total</td>
						</tr>
					</thead>
					<tbody>
					<?php
						session_start();
						include '../../../conexion.php';
						$idCon = $_REQUEST['idCon'];
						$posicion = $_REQUEST['tipo_reporte'];
						$pventa = $_REQUEST['pventa'];
						
						if($posicion == 3){
							if($pventa == '100000'){
								$filtro = '';
							}else{
								$filtro = 'and b.id_usu_venta = "'.$pventa.'"';
							}
						}elseif($posicion == 2){
							$filtro = 'and b.id_usu_venta = "'.$_SESSION['iduser'].'"';
						}else{
							$filtro = '';
						}
						
						
						$sqlLoTer= 'select l.strDescripcionL , d.nom , count(b.idBoleto) as cuantos , 
									IF(max(valor) > 0 ,max(valor) , 0 ) precio ,
									IF(sum(b.valor) > 0 ,sum(b.valor) , 0 ) total , l.idLocalidad as locali
									from Localidad as l 
									left join descuentos as d 
									on d.idloc = l.idLocalidad
									left join Boleto as b 
									on b.id_desc = d.id
									where b.idCon = "'.$idCon.'" 
									and b.idLocB = l.idLocalidad
									'.$filtro.'
									group by l.idLocalidad , d.nom 
									order by l.strDescripcionL ASC , d.nom ASC 
									';
						 // echo $sqlLoTer;
						$resLoTer = mysql_query($sqlLoTer) or die (mysql_error());
						while($rowLoTer = mysql_fetch_array($resLoTer)){
							
							
							$sqlL = 'select * from Localidad where idLocalidad = "'.$rowLoTer['locali'].'" order by 1 ASC';
							$resL = mysql_query($sqlL) or die (mysql_error());
							$rowL = mysql_fetch_array($resL);
							if($rowL['gratuidad'] == 1){
								$variableC = 0;
								$txtG = '<span style = "color:red;">-- Gr</span>';
							}else{
								$variableC = 1;
								$txtG = '';
							}
							
							$sumaCuantos += $rowLoTer['cuantos'];
							$sumaTotal += ($rowLoTer['total'] * $variableC);
							
					?>
						<tr>
							<td  style = 'border:1px solid #ccc;text-align:left;'><?php echo $rowLoTer['strDescripcionL']."".$txtG;?></td>
							<td  style = 'border:1px solid #ccc;text-align:left;'><?php echo $rowLoTer['nom'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $rowLoTer['cuantos'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo $rowLoTer['precio'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right'>
								<?php 
									echo ($rowLoTer['total'] * $variableC)."<br>";
									$variableC;
								?>
							</td>
						</tr>
					<?php

						}
					?>
						<tr>
							<td  style = 'border:1px solid #ccc;text-align:left;'>TOTAL : </td>
							<td  style = 'border:1px solid #ccc;text-align:left;'></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $sumaCuantos;?></td>
							<td  style = 'border:1px solid #ccc;text-align:right'></td>
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo $sumaTotal;?></td>
						</tr>
					</tbody>
				</table>
				
				<br><br>
				
				<input type="button" onclick="tableToExcel_desglose_loc('tot_loc', 'TOTALES LOCALIDADES ')" class="botonimagen" title='Descargar Reporte Excel' value=''/><br>
				
				<table class="table" style ='color:#000;' id = 'tot_loc'>
					<thead>
						<tr>
							<th colspan = '5'>
								TOTALES LOCALIDADES
							</th>
						</tr>
						<tr>
							<th  style = 'border:1px solid #ccc;text-align:left;' >Localidad</td>
							<th  style = 'border:1px solid #ccc;text-align:left;'>Tickets</td>
							<th  style = 'border:1px solid #ccc;text-align:left;'>Valor</td>
						</tr>
					</thead>
					<tbody>
					<?php
						
						$sqlLoTer1= '
									select l.strDescripcionL , count(b.idBoleto) as cuantos , 
									IF(sum(b.valor) > 0 ,sum(b.valor) , 0 ) total , l.idLocalidad as locali
									from Localidad as l 
									left join descuentos as d 
									on d.idloc = l.idLocalidad
									left join Boleto as b 
									on b.id_desc = d.id
									where b.idCon = "'.$idCon.'" 
									and b.idLocB = l.idLocalidad
									'.$filtro.'
									group by l.idLocalidad 
									order by l.strDescripcionL ASC
									';
						$resLoTer1 = mysql_query($sqlLoTer1) or die (mysql_error());
						while($rowLoTer1 = mysql_fetch_array($resLoTer1)){
							
							$sqlL1 = 'select * from Localidad where idLocalidad = "'.$rowLoTer1['locali'].'" order by 1 ASC';
							$resL1 = mysql_query($sqlL1) or die (mysql_error());
							$rowL1 = mysql_fetch_array($resL1);
							if($rowL1['gratuidad'] == 1){
								$variableC1 = 0;
								$txtG1 = '<span style = "color:red;">-- Gr</span>';
							}else{
								$variableC1 = 1;
								$txtG1 = '';
							}
							
							
							$sumaCuantos1 += $rowLoTer1['cuantos'];
							$sumaTotal1 += ($rowLoTer1['total'] * $variableC1);
							
					?>
						<tr>
							<td  style = 'border:1px solid #ccc;text-align:left;'><?php echo $rowLoTer1['strDescripcionL']."".$txtG1;?></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $rowLoTer1['cuantos'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo ($rowLoTer1['total'] * $variableC1);?></td>
						</tr>
					<?php

						}
					?>
						<tr>
							<td  style = 'border:1px solid #ccc;text-align:left;'>TOTAL : </td>
							
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $sumaCuantos1;?></td>
							
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo $sumaTotal1;?></td>
						</tr>
					</tbody>
				</table>
				
				<br><br>
				
				
				<input type="button" onclick="tableToExcel_desglose_desc('tot_desc', 'TOTALES DESCUENTOS ')" class="botonimagen" title='Descargar Reporte Excel' value=''/><br><br>
				
				<table class="table" style ='color:#000;' id = 'tot_desc' >
					<thead>
						<tr>
							<th colspan = '5'>
								TOTALES DESCUENTOS
							</th>
						</tr>
						<tr>
							<th  style = 'border:1px solid #ccc;text-align:left;' >Descuento</td>
							<th  style = 'border:1px solid #ccc;text-align:left;'>Tickets</td>
							<th  style = 'border:1px solid #ccc;text-align:left;'>Valor</td>
						</tr>
					</thead>
					<tbody>
					<?php
						
						$sqlLoTer2= '
									select d.nom , count(b.idBoleto) as cuantos , 
									IF(sum(b.valor) > 0 ,sum(b.valor) , 0 ) total , l.idLocalidad as locali
									from Localidad as l 
									left join descuentos as d 
									on d.idloc = l.idLocalidad
									left join Boleto as b 
									on b.id_desc = d.id
									where b.idCon = "'.$idCon.'" 
									and b.idLocB = l.idLocalidad
									'.$filtro.'
									group by d.nom 
									order by l.strDescripcionL ASC
									';
						$resLoTer2 = mysql_query($sqlLoTer2) or die (mysql_error());
						while($rowLoTer2 = mysql_fetch_array($resLoTer2)){
							
							$sqlL2 = 'select * from Localidad where idLocalidad = "'.$rowLoTer2['locali'].'" order by 1 ASC';
							$resL2 = mysql_query($sqlL2) or die (mysql_error());
							$rowL2 = mysql_fetch_array($resL2);
							if($rowL2['gratuidad'] == 1){
								$variableC2 = 0;
								$txtG2 = '<span style = "color:red;">-- Gr</span>';
							}else{
								$variableC2 = 1;
								$txtG2 = '';
							}
							
							
							$sumaCuantos2 += $rowLoTer2['cuantos'];
							$sumaTotal2 += ($rowLoTer2['total'] * $variableC2);
							
					?>
						<tr>
							<td  style = 'border:1px solid #ccc;text-align:left;'><?php echo $rowLoTer2['nom'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $rowLoTer2['cuantos'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo ($rowLoTer2['total'] * $variableC2);?></td>
						</tr>
					<?php

						}
					?>
						<tr>
							<td  style = 'border:1px solid #ccc;text-align:left;'>TOTAL : </td>
							
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $sumaCuantos2;?></td>
							
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo $sumaTotal2;?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class='col-md-1'></div>
		</div>
	</div>