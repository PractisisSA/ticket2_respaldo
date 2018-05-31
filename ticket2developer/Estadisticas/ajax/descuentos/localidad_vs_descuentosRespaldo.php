	<div class='row'>
		<div class='col-md-1'></div>
		<div class='col-md-10'>
			<div class="panel panel-default">
				<center>
					<input type="button" onclick="tableToExcel_desglose_vs_desc('toc_vs_desc', 'TICKETS LOCALIDAD VS DESCUENTOS')" class="botonimagen" title='Descargar Reporte Excel' value=''/><br><br>
				</center>
				<table class="table" style ='color:#000;' id = 'toc_vs_desc' >
					<thead>
						<tr>
							<th colspan = '7'>
								TICKETS LOCALIDAD VS DESCUENTOS
							</th>
						</tr>
						<tr>
							<td  style = 'border:1px solid #ccc;text-align:left;'>Localidad</td>
							<td  style = 'border:1px solid #ccc;text-align:left;'>Especial</td>
							<td  style = 'border:1px solid #ccc;text-align:left;'>Cortesia</td>
							<td  style = 'border:1px solid #ccc;text-align:left'>Socio</td>
							<td  style = 'border:1px solid #ccc;text-align:left'>Normal</td>
							<td  style = 'border:1px solid #ccc;text-align:left'>Total Tickets</td>
							<td  style = 'border:1px solid #ccc;text-align:left'>Recaudado x Localidad</td>
						</tr>
					</thead>
					<tbody>
					<?php
						session_start();
						include '../../../conexion.php';
						$idCon = $_REQUEST['idCon'];
						
						$posicion = $_REQUEST['tipo_reporte'];
						
						if($posicion == 2){
							$filtro = 'and id_usu_venta = "'.$_SESSION['iduser'].'"';
						}else{
							$filtro = '';
						}
						
						$sqlLoTer= "
									select l.strDescripcionL ,
									sum(IF(d.nom = 'ESPECIAL(50%)' ,1 , 0 )) as especial ,
									sum(IF(d.nom = 'CORTESIA PROHIBIDA SU VENTA' ,1 , 0 )) as cortesia ,
									sum(IF(d.nom = 'SOCIO' ,1 , 0 )) as socio ,
									sum(IF(d.nom = '' ,1 , 0 )) as normal,
									sum(1) as total ,
									sum(b.valor) as valor
									
									from Boleto as b 
									left join Localidad as l
									on b.idLocB = l.idLocalidad
									left join descuentos as d 
									on d.id = b.id_desc
									where b.idCon = '".$idCon."'
									".$filtro."
									group by l.strDescripcionL
								";
						//echo $sqlLoTer;
						// exit;
						$resLoTer = mysql_query($sqlLoTer) or die (mysql_error());
						while($rowLoTer = mysql_fetch_array($resLoTer)){
							$sumaEs += $rowLoTer['especial'];
							$sumaCo += $rowLoTer['cortesia'];
							$sumaSo += $rowLoTer['socio'];
							$sumaNo += $rowLoTer['normal'];
							$sumaTo += $rowLoTer['total'];
							$sumaVa += $rowLoTer['valor'];
							
							
					?>
						<tr>
							<td  style = 'border:1px solid #ccc;text-align:left;'><?php echo $rowLoTer['strDescripcionL'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $rowLoTer['especial'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $rowLoTer['cortesia'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo $rowLoTer['socio'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo $rowLoTer['normal'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo $rowLoTer['total'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo $rowLoTer['valor'];?></td>
						</tr>
					<?php

						}
					?>
						<tr>
							<td  style = 'border:1px solid #ccc;text-align:left;'>TOTAL : </td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $sumaEs;?></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $sumaCo;?></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $sumaSo;?></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $sumaNo;?></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $sumaTo;?></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $sumaVa;?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class='col-md-1'></div>
		</div>
	</div>