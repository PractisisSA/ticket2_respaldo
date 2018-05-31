	<div class='row'>
		<div class='col-md-1'></div>
		<div class='col-md-10'>
			<div class="panel panel-default">
				<input type="button" onclick="tableToExcel_desglose('desglose', 'DESGLOSE DE DESCUENTOS ')" class="botonimagen" title='Descargar Reporte Excel' value=''/>
				<table class="table" style ='color:#000;' id = 'desglose'>
					<thead>
						<tr>
							<th colspan = '10'>
								DESGLOSE DE DESCUENTOS<br>
								
							</th>
						</tr>
						<tr>
							<td>
								
							</td>
							<td colspan = '4' style = 'border:1px solid #ccc;text-align:center;'>
								Tickets sin Descuentos
							</td>
							<td colspan = '4' style = 'border:1px solid #ccc;text-align:center;'>
								Tickets con Descuentos
							</td>
							<td colspan = '2' style = 'border:1px solid #ccc;text-align:center;'>
								Total General
							</td>
						</tr>
						<tr>
							<td  style = 'border:1px solid #ccc;text-align:left;' >Localidad</td>
							
							<td  style = 'border:1px solid #ccc;text-align:left;'>Descuento</td>
							<td  style = 'border:1px solid #ccc;text-align:left;'>Tickets</td>
							<td  style = 'border:1px solid #ccc;text-align:left;'>Valor</td>
							<td  style = 'border:1px solid #ccc;text-align:left;'>Total</td>
							
							<td  style = 'border:1px solid #ccc;text-align:left;width:240px;'>Descuento</td>
							<td  style = 'border:1px solid #ccc;text-align:left;'>Tickets</td>
							<td  style = 'border:1px solid #ccc;text-align:left;'>Valor</td>
							<td  style = 'border:1px solid #ccc;text-align:left;'>Total</td>
							<td  style = 'border:1px solid #ccc;text-align:left;'>Total Tickets Vendidos</td>
							<td  style = 'border:1px solid #ccc;text-align:left;'>Total Recaudado</td>
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
						
						$sql =	'select * from Localidad where idConc = "'.$idCon.'" order by strDescripcionL DESC
								';
						// echo $sql;
						$res = mysql_query($sql) or die (mysql_error());
						$totalTikets = 0;
						$totalRecaudado =0;
						$sumaRecaudadoNormales2 = 0;
						$sumaRecaudadoDescuentos2 = 0;
					while($row = mysql_fetch_array($res)){
							$sqlB = '
										select count(b.idBoleto) as cuantos , 
										IF(max(valor) > 0 ,max(valor) , 0 ) precio ,
										IF(sum(b.valor) > 0 ,sum(b.valor) , 0 ) total
										from Boleto as b 
										where b.idCon = "'.$idCon.'" 
										and b.idLocB = "'.$row['idLocalidad'].'"
										'.$filtro.'
										and b.id_desc = 0
									';
							// echo $sqlB."<br><br>";
							$resB = mysql_query($sqlB) or die (mysql_error());
							$rowB = mysql_fetch_array($resB);
							$sumaNormales = 0;
							$sumaDescuentos = 0;
							
							$sumaRecaudadoNormales = 0;
							$sumaRecaudadoDescuentos = 0;
							
							
					?>
						<tr>
							<td style = 'border:1px solid #ccc;text-align:left;'>
								<?php echo $row['strDescripcionL'];?>
							</td>
							<td style = 'border:1px solid #ccc;text-align:left;'>
								Ninguno
							</td>
							<td style = 'border:1px solid #ccc;text-align:left;'>
								<?php 
									echo $rowB['cuantos'];
									$sumaNormales += $rowB['cuantos'];
								?>
							</td>
							<td style = 'border:1px solid #ccc;text-align:left;'>
								<?php echo $rowB['precio'];?>
							</td>
							<td style = 'border:1px solid #ccc;text-align:left;'>
								<?php 
									echo number_format(($rowB['cuantos'] * $rowB['precio']),2,",",".");
									$sumaRecaudadoNormales += ($rowB['cuantos'] * $rowB['precio']);
									$sumaRecaudadoNormales2 += ($rowB['cuantos'] * $rowB['precio']);
								?>
							</td>
							<td colspan = '4' style = 'border:1px solid #ccc;text-align:left;'>
								<table width = '100%'>
					<?php
						$sqlD= '
									SELECT * FROM descuentos where idloc = "'.$row['idLocalidad'].'" order by nom desc
								'; 
						// echo $sqlD."<br><br>";
						$resD = mysql_query($sqlD) or die(mysql_error());
						
						while($rowD = mysql_fetch_array($resD)){
							$sqlBD = '
								select count(b.idBoleto) as cuantos , 
								IF(max(valor) > 0 ,max(valor) , 0 ) precio ,
								IF(sum(b.valor) > 0 ,sum(b.valor) , 0 ) total
								from Boleto as b 
								where b.id_desc = "'.$rowD['id'].'"
								and b.idCon = "'.$idCon.'" 
								'.$filtro.'
							';
							$resBD = mysql_query($sqlBD) or die (mysql_error());
							$rowBD = mysql_fetch_array($resBD);
					?>
								
									<tr>
										<td style = 'border:1px solid #ccc;text-align:left;width:240px;'>
											<?php echo $rowD['nom'];?>
										</td>
										<td style = 'border:1px solid #ccc;text-align:left;width: 45px'>
											<?php 
												echo $rowBD['cuantos'];
												$sumaDescuentos += $rowBD['cuantos'];
											?>
										</td>
										<td style = 'border:1px solid #ccc;text-align:left;width: 35px'><?php echo $rowBD['precio'];?></td>
										<td style = 'border:1px solid #ccc;text-align:left;'>
											<?php 
												echo ($rowBD['cuantos'] * $rowBD['precio']);
												$sumaRecaudadoDescuentos += ($rowBD['cuantos'] * $rowBD['precio']);
												$sumaRecaudadoDescuentos2 += ($rowBD['cuantos'] * $rowBD['precio']);
											?>
										</td>
									</tr>
								
					<?php
						}
					?>			
								</table>
							</td>
							<td style = 'border:1px solid #ccc;text-align:left;'>
								<input type = 'hidden' value = '<?php echo $sumaNormales;?>' class = 'sumaNormales' />
								<input type = 'hidden' value = '<?php echo $sumaDescuentos;?>' class = 'sumaDescuentos2' />
								
								<?php
									echo ($sumaNormales+$sumaDescuentos);
									$totalTikets +=($sumaNormales+$sumaDescuentos);
								?>
							</td>
							<td style = 'border:1px solid #ccc;text-align:left;'>
								<?php
									echo ($sumaRecaudadoNormales+$sumaRecaudadoDescuentos);
									$totalRecaudado += ($sumaRecaudadoNormales+$sumaRecaudadoDescuentos);
								?>
							</td>
						</tr>
					<?php
						
					}
					?>
					</tbody>
					<tr>
						<td colspan = '2' style = 'text-align:center;'>
							Total Normales
						</td>
						<td  style = 'text-align: right' id = 'recibeNormales'>
							
						</td>
						<td></td>
						<td>
							<?php echo $sumaRecaudadoNormales2;?>
						</td>
						<td style = 'text-align:center;'>
							Total Descuentos
						</td>
						<td  style = 'text-align: right' id = 'recibeDescuentos'>
							
						</td>
						<td></td>
						<td>
							<?php echo $sumaRecaudadoDescuentos2;?>
						</td>
					</tr>
					<tr>
						<td colspan = '9' style = 'text-align:center;'>Total global</td>
						<td>
							<?php
								echo $totalTikets;
							?>
						</td>
						<td>
							<?php
								echo $totalRecaudado;
							?>
						</td>
						
					</tr>
				</table>
			</div>
		</div>
		<div class='col-md-1'></div>
	</div>
	<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>-->
	<script>
		$(document).ready(function(){
			var totalNormales = 0;
			$('.sumaNormales').each(function(){
				var sumaNormales = $(this).val();
				totalNormales += parseInt(sumaNormales);
			})
			$('#recibeNormales').html(totalNormales);
			
			
			var totalDescuentos = 0;
			$('.sumaDescuentos2').each(function(){
				var sumaDescuentos = $(this).val();
				// alert(sumaDescuentos)
				totalDescuentos += parseInt(sumaDescuentos);
			})
			$('#recibeDescuentos').html(totalDescuentos);
		});
	</script>