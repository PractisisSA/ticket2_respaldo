	<?php
		session_start();
		include '../../../conexion.php';
		$idCon = $_REQUEST['idCon'];
		$tipo_reporte = $_REQUEST['tipo_reporte'];
		
		if($tipo_reporte == 2){
			$filtro = 'and id_usu_venta = "'.$_SESSION['iduser'].'"';
		}else{
			$filtro = '';
		}
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
							<th colspan = '7' style = 'border:1px solid #000;'>
								TICKETS LOCALIDAD VS DESCUENTOS
							</th>
						</tr>
						
						<tr>
							<td style = 'border:1px solid #000;'></td>
							<?php 
								$sqlD = 'select * from descuentos where idcon = "'.$idCon.'" group by nom order by nom ASC';
								$resD = mysql_query($sqlD) or die (mysql_error());
								$numero = mysql_num_rows($resD);
								while($rowD = mysql_fetch_array($resD)){
							?>
									<td style = 'border:1px solid #000;'><?php echo $rowD['nom']?></td>
							<?php
								}
							?>
									<td style = 'border:1px solid #000;'>Total Desc.</td>
									<td style = 'border:1px solid #000;'>Normales</td>
									<td style = 'border:1px solid #000;'>Total Tickets</td>
									<td style = 'border:1px solid #000;'>Total Recaudado</td>
						</tr>
						
						<?php
							$sql = 'select * from Localidad where idConc = "'.$idCon.'" order by idLocalidad DESC';
							$res = mysql_query($sql) or die (mysql_error());
							$sumaGlobal = 0;
								$sumTotal = 0;
							while($row = mysql_fetch_array($res)){
						?>
						<tr>
							<td style = 'border:1px solid #000;'>
								<?php echo $row['strDescripcionL']?> [<?php echo $row['idLocalidad'];?>]
							</td>
							<?php
								$sumCuantos = 0;
								$cuantos = 0;
								
								$sumDesc = 0;
								$sumNormal = 0;
								
								$sqlD = 'select * from descuentos where idcon = "'.$idCon.'" and idloc = "'.$row['idLocalidad'].'" order by nom ASC ';
								$resD = mysql_query($sqlD) or die (mysql_error());
								while($rowD = mysql_fetch_array($resD)){
									$sqlB = '	select count(idBoleto) as cuantos , sum(valor) as valor_desc 
												from Boleto 
												where idCon = "'.$idCon.'" 
												'.$filtro.'
												and idLocB = "'.$row['idLocalidad'].'" 
												and tercera = 1 
												and id_desc = "'.$rowD['id'].'" 
											';
									$resB = mysql_query($sqlB) or die (mysql_error());
									$rowB = mysql_fetch_array($resB);
									if($rowB['cuantos'] == 0){
										$cuantos = 0;
										$valor_desc = 0;
										$nomDesc = $rowD['nom'];
									}else{
										$valor_desc = $rowB['valor_desc'];
										$cuantos = $rowB['cuantos'];
										$nomDesc = $rowD['nom'];
									}
							?>
								<td style = 'text-align:center;border:1px solid #000;'>
									<!--<span style = 'font-size:10px;'><?php echo $nomDesc."<>".$rowD['id'];?></span><br>-->
									<?php 
										//echo $sqlB."<br>";
										$sumDesc += $valor_desc;
										$sumCuantos += $cuantos;
										echo $cuantos;
									?>
								</td>
							<?php
								}
							
								$sqlB1 = '	select count(idBoleto) as cuantos2 , sum(valor) as valor_normal 
											from Boleto 
											where idCon = "'.$idCon.'" 
											'.$filtro.'
											and idLocB = "'.$row['idLocalidad'].'" 
											and tercera = 0
											and id_desc = "0" 
										';
								$resB1 = mysql_query($sqlB1) or die (mysql_error());
								$rowB1 = mysql_fetch_array($resB1);
							?>
								<td style = 'text-align:center;border:1px solid #000;'>
									<!--<span style = 'font-size:10px;'>normales</span><br>-->
									<?php echo $sumCuantos;?>
								</td>
								<td style = 'text-align:center;border:1px solid #000;'>
									<!--<span style = 'font-size:10px;'>normales</span><br>-->
									<?php echo $rowB1['cuantos2'];?>
								</td>
								<td style = 'text-align:center;border:1px solid #000;'>
									<?php 
										$valor_normal = $rowB1['valor_normal'];
										$sumNormal += $valor_normal;
										$sumTotal += ($sumCuantos + $rowB1['cuantos2']);
										echo ($sumCuantos + $rowB1['cuantos2']);
									?>
								</td>
								<td style = 'text-align:center;border:1px solid #000;'>
									<?php 
										$sumaGlobal += ($sumNormal + $sumDesc);
										echo number_format(($sumNormal + $sumDesc),2);
									?>
								</td>
						</tr>
						<?php
							}
							$colspan = ($numero +2);
						?>
						<tr>
							<td colspan = '<?php echo $colspan?>' style = 'text-align:center;border:1px solid #000;'>
								
							</td>
							<td style = 'text-align:center;border:1px solid #000;'>
								<?php echo $sumTotal;?>
							</td>
							<td style = 'text-align:center;border:1px solid #000;'>
								<?php echo number_format(($sumaGlobal),2);?>
							</td>
						</tr>
					</thead>
					
					
				</table>
			</div>
			<div class='col-md-1'></div>
		</div>
	</div>