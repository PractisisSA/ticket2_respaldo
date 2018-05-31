	<?php
		session_start();
		include '../../../conexion.php';
		$idCon = $_REQUEST['idCon'];
	?>
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
							
							
							
							<td>
								<table width = '400px'>
									<tr>
								<?php
									$sqlD1 = 'select * from descuentos where idcon = "'.$idCon.'" GROUP by nom order by id ASC';
									//echo $sqlD1;
									$resD1 = mysql_query($sqlD1) or die (mysql_error());
									$cu = mysql_num_rows($resD1);
									$porc1 = (100 / mysql_num_rows($resD1));
									//echo $cu;
									while($rowD1 = mysql_fetch_array($resD1)){
								?>
										<td style = 'border:1px solid #ccc;width:<?php echo $porc1;?>%;text-align:center;'>
											<?php echo $rowD1['nom'];?>
										</td>
								<?php
									}
								?> 
									</tr>
								</table>
							</td>
							<td style = 'border:1px solid #ccc;text-align:center'>
								Normales
							</td>
							
							<td  style = 'border:1px solid #ccc;text-align:left'>Total Tickets</td>
							
							
							<td  style = 'border:1px solid #ccc;text-align:left'>Recaudado x Localidad</td>
						</tr>
					</thead>
					<tbody>
					<?php
						
						
						$posicion = $_REQUEST['tipo_reporte'];
						
						if($posicion == 2){
							$filtro = 'and id_usu_venta = "'.$_SESSION['iduser'].'"';
						}else{
							$filtro = '';
						}
						
						$sqlLoTer= "
									select l.strDescripcionL ,
									b.idLocB as local,
									count(b.idBoleto) as total ,
									sum(b.valor) as valor
									
									from Boleto as b 
									left join Localidad as l
									on b.idLocB = l.idLocalidad
									
									where b.idCon = '".$idCon."'
									".$filtro."
									group by l.strDescripcionL
									ORDER BY b.id_desc ASC
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
							
							<td>
								<table width = '400px'>
									<tr>
								<?php
									$sqlD = 'select * from descuentos where idloc = "'.$rowLoTer['local'].'" order by idloc asc';
									//echo $sqlD;
									$resD = mysql_query($sqlD) or die (mysql_error());
									while($rowD = mysql_fetch_array($resD)){
										$sqlC = 'select count(idBoleto) as cuantos from Boleto where idLocB = "'.$rowLoTer['local'].'" and id_desc = "'.$rowD['id'].'" ';
										$resC = mysql_query($sqlC) or die (mysql_error());
										//echo mysql_num_rows($resD);
										$rowC = mysql_fetch_array($resC);
										$porc = (100 / mysql_num_rows($resD));
								?>
										<td style = 'border:1px solid #ccc;width:<?php echo $porc;?>%;text-align:center;'>
											<?php echo $rowC['cuantos'];?>
										</td>
								<?php
									}
								?> 
									</tr>
								</table>
							</td>
							<?php
								$sql = 'select count(idBoleto) as normales from Boleto where idLocB = "'.$rowLoTer['local'].'" and tercera = 0';
								$res = mysql_query($sql) or die (mysql_error());
								$row = mysql_fetch_array($res);
							?>
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo $row['normales'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo $rowLoTer['total'];?></td>
							<td  style = 'border:1px solid #ccc;text-align:right'><?php echo $rowLoTer['valor'];?></td>
						</tr>
					<?php

						}
					?>
						<tr>
							<td  style = 'border:1px solid #ccc;text-align:left;'>TOTAL : </td>
							<td  style = 'border:1px solid #ccc;text-align:left;'></td>
							<td  style = 'border:1px solid #ccc;text-align:left;'></td>
							
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo $sumaTo;?></td>
							<td  style = 'border:1px solid #ccc;text-align:right;'><?php echo number_format(($sumaVa),2 , "," , ".");?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class='col-md-1'></div>
		</div>
	</div>