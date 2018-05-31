<?php
	session_start();
	// echo "perfil : ".$_SESSION['autentica'];
	if($_SESSION['autentica'] == 'Municipio'){
		$display = 'display:none;';
	}else{
		$display = '';
	}
	include '../conexion.php';
	$idcon = $_REQUEST['id'];
	$pventa = $_REQUEST['pventas'];
	
	$sqlI = 'select * from impuestos where id_con = "'.$idcon.'" ';
	$resI = mysql_query($sqlI) or die (mysql_error());
	$rowI = mysql_fetch_array($resI);
	
	echo "<input type = 'hidden' id = 'imp_mun' value = '".$rowI['municipio']."' />";
	
	$sqlCo = 'select strEvento from Concierto where idConcierto = "'.$idcon.'" ';
	// echo $sqlCo;
	
	$resCo = mysql_query($sqlCo) or die (mysql_error()." error de conciertos");
	$rowCo = mysql_fetch_array($resCo);
	
	$sql = 'SELECT * FROM `Localidad` WHERE `idConc` = "'.$idcon.'" group by macro_localidad ORDER BY `Localidad`.`strDescripcionL` ASC ';
	
	$res = mysql_query($sql) or die (mysql_error()." error de localidades");
	
	if($_SESSION['perfil'] == 'Distribuidor'){
		$query = 'and id_usu_venta = "'.$_SESSION['iduser'].'" ';
	}else{
		if($_REQUEST['pventas'] == '' ){
			$query = '';
		}else{
			echo $_REQUEST['pventas'];
			if($_REQUEST['pventas'] == 0 ){
				$query = 'and id_usu_venta = "0"';
			}else{
				$sqlp = 'SELECT * FROM Usuario WHERE strObsCreacion = '.$_REQUEST['pventas'].'';
				$resp = mysql_query($sqlp) or die (mysql_error()." error de pventas");
				$rowp = mysql_fetch_array($resp);
				$query = 'and id_usu_venta = "'.$rowp['idUsuario'].'"';
			}

		}
	}
	
?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<style>
		td{
			text-align:left;
		}
	</style>
	<center> 
		<button type="button" class="btn btn-default" onclick="tableToExcel('desglose_sri', 'REPORTE SRI DESGLOSADO')">EXCEL</button>
	</center>
	<table  id = "desglose_sri" class = 'table'>
		<tr>
			<td style = 'border-right:1px solid #000;'>
				<table class = 'table'>
					<tr>
						<th colspan = '9' >
							Detalle Ventas Evento : <?php echo $rowCo['strEvento']."   [".$idcon."]";?>
						</th>
					</tr>
					<tr>
						<th>
							Localidades
						</th>
						<th>
							Autorizados
						</th>
						
						<th>
							No Vendidos 
						</th>
						
						<th style = '<?php echo $display;?>'>
							Impresos
						</th>
						
						<th>
							Vendidos
						</th>
						<th>
							Precio
						</th>
						
						<th>
							Total
						</th>
						<th>
							Admision
						</th>
						<th>
							Impuesto
						</th>
						
						
					</tr>
			<?php
				$suma_vendidos_normal = 0;
				
				$sumadescuento = 0;
				
				$sumadescuento1 = 0;
				
				
				$suma_precio_normal = 0;
				$suma_precio_descuento = 0;
				$suma_precio_cortesia = 0;
				
				$suma_valor_admision_normales = 0;
				$suma_valor_admision_descuento = 0;
				$suma_valor_admision_cortesias = 0;
				
				
				
				
				$sumadescuento1A = 0;
				
				$suma_total_admision_normales = 0;
				$suma_total_admision_descuento = 0;
				$suma_total_admision_cortesia = 0;
				
				$suma_autorizados = 0;
				$suma_autorizados_cortesias = 0;
				
				
				$suma_impresos_normales = 0;
				$suma_impresos_descuento = 0;
				$suma_impresos_cortesia = 0;
				
				
				while($row = mysql_fetch_array($res)){
					
					
					$sumAutorizados=0;
					$sumaBloqueos = 0;
					$sumaCortesias = 0;
					$precioBloeto = 0;
					
					
					
					
					$sqlL1='SELECT * FROM `Localidad` WHERE `idConc` = "'.$idcon.'" and macro_localidad = "'.$row['macro_localidad'].'"  ORDER BY `Localidad`.`strDescripcionL` ASC ';
					$resL1 = mysql_query($sqlL1) or die (mysql_error()." error de macros");
					$sumavendidos_todos=0;
					$sumavendidos_normal = 0;
					$sumavendidos_descuento = 0;
					while($rowL1 = mysql_fetch_array($resL1)){
						
						$sumAutorizados += $rowL1['strCapacidadL'];
						
						
						
						$sqlOc = '	SELECT 1 as posicion, `row` , `col` , (`status`) , (`local`) , (`concierto`) 
									FROM `ocupadas`
									WHERE `local` = "'.$rowL1['idLocalidad'].'" 
									and status = "3"
									group by `row` , `col` , `status` , `local` , `concierto` 
									ORDER BY `col` ASC
								';
						// echo $sqlOc."<br>";
						
						$resOc = mysql_query($sqlOc) or die (mysql_error());
						
						while($rowOc = mysql_fetch_array($resOc)){
							$sumaBloqueos += $rowOc['posicion'];
						}
						
						
						$sqlLc1 = '	SELECT (cant) as aut_cortesias 
									FROM `localidad_cortesias`
									WHERE `id_loc` =  '.$rowL1['idLocalidad'].'
									ORDER BY `id_loc` DESC 
								';
						$resLc1 = mysql_query($sqlLc1) or die (mysql_error());
						while($rowLc1 = mysql_fetch_array($resLc1)){
							$sumaCortesias += $rowLc1['aut_cortesias'];
						}
						
						$sqlDD = 'SELECT * FROM `descuentos` WHERE `idloc` = "'.$rowL1['idLocalidad'].'" and `nom` LIKE "%cortes%" ORDER BY `nom` DESC ';
						$resDD = mysql_query($sqlDD) or die (mysql_error());
						$rowDD = mysql_fetch_array($resDD);
						
						
						$sqlB2 = 'SELECT count(idBoleto) as vendidos_todos FROM `Boleto` WHERE `idLocB` = "'.$rowL1['idLocalidad'].'" and tercera = 0 and id_desc != "'.$rowDD['id'].'" '.$query.' ORDER BY `idLocB` DESC ';
						
						//echo $sqlB2."<br>";
						$resB2 = mysql_query($sqlB2) or die (mysql_error());
						while($rowB2 = mysql_fetch_array($resB2)){
							$sumavendidos_todos += $rowB2['vendidos_todos'];
						}
						
						$sqlB = 'SELECT count(idBoleto) as vendidos_normal FROM `Boleto` WHERE `idCon` = "'.$idcon.'" AND `idLocB` = "'.$rowL1['idLocalidad'].'" and tercera = 0 and id_desc != "'.$rowDD['id'].'" '.$query.' ORDER BY `idLocB` DESC ';
						$resB = mysql_query($sqlB) or die (mysql_error());
						while($rowB = mysql_fetch_array($resB)){
							$sumavendidos_normal += $rowB['vendidos_normal'];
						}
						
						$precioBloeto = $rowL1['doublePrecioL'];
					}
					
					$autorizados = ($sumAutorizados - $sumaBloqueos - $sumaCortesias);
					
					
					
					
					
			?>
					<tr class = 'valores_macros' >
						<th style = 'text-align:left;' >
							<?php echo $row['macro_localidad'];?>
							
						</th>
						<td >
							
							<?php 
								// echo $sumAutorizados."-".$sumaBloqueos."-".$sumaCortesias."<br>";
								echo "<div class = 'autorizados_macro'>".$autorizados."</div>";
								$suma_autorizados += $autorizados;
							?>
						</td>
						
						<td class = 'no_vendidos_macro'>
							<div class = 'no_vendido_<?php echo $row['idLocalidad']?> valore_no_vendidos' style = 'color:blue;'></div>
						</td>
						
						<td style = '<?php echo $display;?>'>
							<?php 
								echo "<div class = 'suma_vendidos_todos_macro'>".$sumavendidos_todos."</div>";
								$suma_impresos_normales += $sumavendidos_todos;
							?>
						</td>
						
						<td>
							<?php 
								echo "<div class = 'vendidos_macro' >".$sumavendidos_normal."</div>";
								$suma_vendidos_normal += $sumavendidos_normal;
							?>
						</td>
						<td >
							<?php echo $precioBloeto;?>
						</td>
						<td >
							<?php 
								echo "<div class = 'total_macro2'>".number_format(($precioBloeto * $sumavendidos_normal),2 , "," , "")."</div>";
								echo "<input type = 'hidden' style = 'display:none;' class = 'total_macro' value = '".$precioBloeto * $sumavendidos_normal."'/>";
								$suma_precio_normal += ($precioBloeto * $sumavendidos_normal);
							?>
						</td>
						
						<td >
							<?php 
								echo "<div class = 'admision_macro'>".number_format((($precioBloeto * $sumavendidos_normal) / (1 + $rowI['municipio'])),2 , "," , "")."</div>";
								$suma_valor_admision_normales += (($precioBloeto * $sumavendidos_normal) / (1 + $rowI['municipio']));
							?>
						</td>
						<td >
							<?php 
								echo "<div class = 'impuesto_macro'>".number_format(($precioBloeto * $sumavendidos_normal) - ((($precioBloeto * $sumavendidos_normal) / (1 + $rowI['municipio']))),2 , "," , "")."</div>";
								$suma_total_admision_normales += (($precioBloeto * $sumavendidos_normal) - ((($precioBloeto * $sumavendidos_normal) / (1 + $rowI['municipio']))));
							?>
						</td>
					</tr>
			<?php
				// // $sqlLo='SELECT * FROM `Localidad` WHERE macro_localidad = "'.$row['macro_localidad'].'"  and idConc = 246 ORDER BY `Localidad`.`strDescripcionL` ASC ';
				// echo $sqlLo."<br>";
				// // $resLo = mysql_query($sqlLo) or die (mysql_error());
				
				// // $i=1;
				
				// // while($rowLo = mysql_fetch_array($resLo)){
					$sqlD1 = '	SELECT GROUP_CONCAT(id) as id,GROUP_CONCAT(idloc) as idloc, nom 
								FROM `descuentos` 
								WHERE `idloc` in( 
													SELECT idLocalidad 
													FROM `Localidad` 
													WHERE macro_localidad = "'.$row['macro_localidad'].'"  
													and idConc = '.$idcon.' 
													ORDER BY `Localidad`.`strDescripcionL` ASC 
												) 
								and `nom` NOT LIKE "%cortes%" 
								group by nom ORDER BY `nom` DESC 
							';
					// echo $sqlD1."<br>";
					$resD1 = mysql_query($sqlD1) or die (mysql_error());
					
					while($rowD1 = mysql_fetch_array($resD1)){
						
						$sqlB1 = '	SELECT count(idBoleto) as vendidos_descuento 
									FROM `Boleto`
									WHERE `idCon` = '.$idcon.' 
									AND `idLocB` in ('.$rowD1['idloc'].')
									AND `tercera` = 1 
									AND `id_desc` in('.$rowD1['id'].')
									'.$query.'
									ORDER BY `idLocB` DESC ';
						$resB1 = mysql_query($sqlB1) or die (mysql_error());
						$rowB1 = mysql_fetch_array($resB1);
						
						
						$sqlBT = '	SELECT count(idBoleto) as vendidos_descuento_todos , Boleto.valor as precio_vendido
									FROM `Boleto`
									WHERE `idLocB` in ('.$rowD1['idloc'].')
									AND `tercera` = 1 
									AND `id_desc` in('.$rowD1['id'].')
									'.$query.'
									ORDER BY `idLocB` DESC ';
						
						$resBT = mysql_query($sqlBT) or die (mysql_error());
						$rowBT = mysql_fetch_array($resBT);
						
						
						
					  // echo $sqlBT."<br><br>";
					  
					  $sqlVl = '
									SELECT  vl.valor as precio_vendido , b.valor
									FROM  valor_localidad_ventas as vl , Boleto as b

									WHERE vl.id_loc in ('.$rowD1['idloc'].') 

									AND vl.id_desc in('.$rowD1['id'].') 
									and b.tercera = 1
									and b.idLocB in('.$rowD1['idloc'].')
									and b.id_desc in ('.$rowD1['id'].')
									ORDER BY `idLocB` DESC
								';
					$resVl = mysql_query($sqlVl) or die (mysql_error());
					$rowVl = mysql_fetch_array($resVl);
						
					
					$precio_vendido = $rowVl['precio_vendido'] ? $rowVl['precio_vendido'] : 0;
					
			?>
						<tr>
							<td>
								<?php echo $rowD1['nom'];?>
							</td>
							<td></td>
							<td></td>
							
							<td style = '<?php echo $display;?>'><?php echo "<div class = 'vendidos_descuento_todos' >".$rowBT['vendidos_descuento_todos']."</div>";?></td>
							<td>
								<?php 
									echo "<div class = 'vendidos_descuento' >".$rowB1['vendidos_descuento']."</div>";
									$sumavendidos_descuento += $rowB1['vendidos_descuento'];
								?>
								</td>
							<td><?php echo $precio_vendido;?></td>
							<td>
								<?php 
									echo "<div class = 'total_descuento2'>".number_format(($rowB1['vendidos_descuento'] * $precio_vendido),2 , "," , "")."</div>";
									echo "<input type = 'hidden' style = 'display:none;' class = 'total_descuento' value ='".$rowB1['vendidos_descuento'] * $precio_vendido."' />";
								?>
							</td>
							<td>
								<?php 
									echo "<div class = 'admision_descuento'>".number_format((($rowB1['vendidos_descuento'] * $precio_vendido) / (1 + $rowI['municipio'])),2 , "," , "")."</div>";
								?>
							</td>
							<td>
								<?php 
									echo "<div class = 'impuesto_descuento'>".number_format((($rowB1['vendidos_descuento'] * $precio_vendido) - (($rowB1['vendidos_descuento'] * $precio_vendido) / (1 + $rowI['municipio']))),2 , "," , "")."</div>";
								?>
							</td>
						</tr>
					
					
			<?php
					$i++;
					}
				// }
			?>




					<tr class = 'suma_total_aut_menos_vendidos' numero_localidad = "<?php echo $row['idLocalidad']?>" >
						
						<td style = 'border-top:1px solid #000;padding-top:5px;'>
							<div style = 'display:none;color:#fff;'id="suma_aut_menos_vendidos_<?php echo $row['idLocalidad']?>"><?php echo ($autorizados - ($sumavendidos_normal + $sumavendidos_descuento))?></div>
							<?php //echo "(".$autorizados."-(".$sumavendidos_normal." + ".$sumavendidos_descuento."))"?></div>
						</td>
						<td style = 'border-top:1px solid #000;padding-top:5px;'></td>
						<td style = 'border-top:1px solid #000;padding-top:5px;'></td>
						<td style = 'border-top:1px solid #000;padding-top:5px;<?php echo $display;?>'></td>
						<td style = 'border-top:1px solid #000;padding-top:5px;'></td>
						<td style = 'border-top:1px solid #000;padding-top:5px;'></td>
						<td style = 'border-top:1px solid #000;padding-top:5px;'></td>
						<td style = 'border-top:1px solid #000;padding-top:5px;'></td>
						<td style = 'border-top:1px solid #000;padding-top:5px;'></td>
					</tr>
			<?php
					
				}
			?>
					<tr>
						<td>Totales</td>
						<td id = 'suma_Total_Autorizados'></td>
						<td id = 'suma_total_no_vendidos'></td>
						<td id = 'suma_impresos' style = '<?php echo $display;?>'></td>
						<td id = 'suma_vendidoss'></td>
						<td></td>
						<td id = 'suma_totales'></td>
						<td id = 'suma_admiciones'></td>
						<td id = 'suma_impuestos'></td>
					</tr>
				</table>
			</td>
			<td style = 'vertical-align:top;'>
				<table class = 'table' id = "desglose_sri">
					<tr>
						<th colspan = '9' >
							CORTESIAS
						</th>
					</tr>
					<tr>
						<th>
							Localidades
						</th>
						<th>
							Aut
						</th>
						
						<th>
							No Vendidos 
						</th>
						
						<th style = '<?php echo $display;?>'>
							Impresos
						</th>
						
						<th>
							Vendidos
						</th>
						
						
						
					</tr>
			<?php
				$suma_vendidos_normal = 0;
				
				$sumadescuento = 0;
				
				$sumadescuento1 = 0;
				
				
				$suma_precio_normal = 0;
				$suma_precio_descuento = 0;
				$suma_precio_cortesia = 0;
				
				$suma_valor_admision_normales = 0;
				$suma_valor_admision_descuento = 0;
				$suma_valor_admision_cortesias = 0;
				
				
				
				
				$sumadescuento1A = 0;
				
				$suma_total_admision_normales = 0;
				$suma_total_admision_descuento = 0;
				$suma_total_admision_cortesia = 0;
				
				$suma_autorizados = 0;
				$suma_autorizados_cortesias = 0;
				
				
				$suma_impresos_normales = 0;
				$suma_impresos_descuento = 0;
				$suma_impresos_cortesia = 0;
				
				$sql1 = 'SELECT * FROM `Localidad` WHERE `idConc` = "'.$idcon.'" group by macro_localidad ORDER BY `Localidad`.`strDescripcionL` ASC ';
				$res1 = mysql_query($sql1) or die (mysql_error());
				while($row = mysql_fetch_array($res1)){
					
					
					$sumAutorizados=0;
					$sumaBloqueos = 0;
					
					$precioBloeto = 0;
					
					
					
					
					$sqlL1='SELECT * FROM `Localidad` WHERE `idConc` = "'.$idcon.'" and macro_localidad = "'.$row['macro_localidad'].'"  ORDER BY `Localidad`.`strDescripcionL` ASC ';
					$resL1 = mysql_query($sqlL1) or die (mysql_error());
					$sumavendidos_todos=0;
					$sumavendidos_normal = 0;
					$sumavendidos_descuento = 0;
					while($rowL1 = mysql_fetch_array($resL1)){
						
						$sumAutorizados += $rowL1['strCapacidadL'];
						
						
						
						$sqlOc = '	SELECT 1 as posicion, `row` , `col` , (`status`) , (`local`) , (`concierto`) 
									FROM `ocupadas`
									WHERE `local` = "'.$rowL1['idLocalidad'].'" 
									and status = "3"
									group by `row` , `col` , `status` , `local` , `concierto` 
									ORDER BY `col` ASC
								';
						// echo $sqlOc."<br>";
						
						$resOc = mysql_query($sqlOc) or die (mysql_error());
						
						while($rowOc = mysql_fetch_array($resOc)){
							$sumaBloqueos += $rowOc['posicion'];
						}
						
						
						$sqlB2 = 'SELECT count(idBoleto) as vendidos_todos FROM `Boleto` WHERE `idLocB` = "'.$rowL1['idLocalidad'].'" '.$query.' ORDER BY `idLocB` DESC ';
						
						// echo $sqlB2."<br>";
						$resB2 = mysql_query($sqlB2) or die (mysql_error());
						while($rowB2 = mysql_fetch_array($resB2)){
							$sumavendidos_todos += $rowB2['vendidos_todos'];
						}
						
						$sqlB = 'SELECT count(idBoleto) as vendidos_normal FROM `Boleto` WHERE `idCon` = "'.$idcon.'" AND `idLocB` = "'.$rowL1['idLocalidad'].'" AND `tercera` = 0 '.$query.' ORDER BY `idLocB` DESC ';
						$resB = mysql_query($sqlB) or die (mysql_error());
						while($rowB = mysql_fetch_array($resB)){
							$sumavendidos_normal += $rowB['vendidos_normal'];
						}
						
						$precioBloeto = $rowL1['doublePrecioL'];
					}
					
					$autorizados = ($sumAutorizados - $sumaBloqueos);
					
					
					
					
					
			?>
					<tr class = 'valores_macros' >
						<th style = 'text-align:left;' >
							<?php echo $row['macro_localidad'];?>
							<br>
							<br>
						</th>
						<td >
							
						</td>
						
						<td>
							
						</td>
						
						<td style = '<?php echo $display;?>'>
							
						</td>
						
						<td>
							
						</td>
						
					</tr>
			<?php
				// // $sqlLo='SELECT * FROM `Localidad` WHERE macro_localidad = "'.$row['macro_localidad'].'"  and idConc = 246 ORDER BY `Localidad`.`strDescripcionL` ASC ';
				// echo $sqlLo."<br>";
				// // $resLo = mysql_query($sqlLo) or die (mysql_error());
				
				// // $i=1;
				
				// // while($rowLo = mysql_fetch_array($resLo)){
					$sqlD1 = '	SELECT GROUP_CONCAT(id) as id,GROUP_CONCAT(idloc) as idloc, nom 
								FROM `descuentos` 
								WHERE `idloc` in( 
													SELECT idLocalidad 
													FROM `Localidad` 
													WHERE macro_localidad = "'.$row['macro_localidad'].'"  
													and idConc = '.$idcon.' 
													ORDER BY `Localidad`.`strDescripcionL` ASC 
												) 
								and `nom` LIKE "%cortes%" 
								group by nom ORDER BY `nom` DESC 
							';
					// echo $sqlD1."<br>";
					$resD1 = mysql_query($sqlD1) or die (mysql_error());
					
					while($rowD1 = mysql_fetch_array($resD1)){
						
						$sqlB1 = '	SELECT count(idBoleto) as vendidos_descuento 
									FROM `Boleto`
									WHERE `idCon` = '.$idcon.' 
									AND `idLocB` in ('.$rowD1['idloc'].')
									AND `tercera` = 1 
									AND `id_desc` in('.$rowD1['id'].')
									'.$query.'
									ORDER BY `idLocB` DESC ';
						$resB1 = mysql_query($sqlB1) or die (mysql_error());
						$rowB1 = mysql_fetch_array($resB1);
						
						
						$sqlBT = '	SELECT count(idBoleto) as vendidos_descuento_todos , Boleto.valor as precio_vendido
									FROM `Boleto`
									WHERE `idLocB` in ('.$rowD1['idloc'].')
									AND `tercera` = 1 
									AND `id_desc` in('.$rowD1['id'].')
									'.$query.'
									ORDER BY `idLocB` DESC ';
						$resBT = mysql_query($sqlBT) or die (mysql_error());
						$rowBT = mysql_fetch_array($resBT);
						
						
						
						$sqlLc = '	SELECT sum(cant) as aut_cortesias 
									FROM `localidad_cortesias`
									WHERE `id_loc` in ('.$rowD1['idloc'].')
									ORDER BY `id_loc` DESC 
								';
						$resLc = mysql_query($sqlLc) or die (mysql_error());
						$rowLc = mysql_fetch_array($resLc);
						
						$precio_vendido = $rowBT['precio_vendido'] ? $rowBT['precio_vendido'] : 0;
						$aut_cortesias = $rowLc['aut_cortesias'] ? $rowLc['aut_cortesias'] : 0;
						
					 // echo $sqlBT."<br>";
			?>
						<tr>
							<td>
								<?php echo $rowD1['nom'];?>
							</td>
							<td style = 'text-align:center;'>
								<?php echo "<div class = 'aut_cortesias' >".$aut_cortesias."</div>";?>
							</td>
							<td style = 'text-align:center;'>
								<?php echo "<div class = 'no_vendidos_cortesias' >".($rowLc['aut_cortesias'] - $rowB1['vendidos_descuento'])."</div>";?>
							</td>
							
							<td style = 'text-align:center;<?php echo $display;?>' >
								<?php echo "<div class = 'vendidos_cortesias_todos' >".$rowBT['vendidos_descuento_todos']."</div>";?>
							</td>
							<td style = 'text-align:center;'>
								<?php 
									echo "<div class = 'vendidos_cortesias' >".$rowB1['vendidos_descuento']."</div>";
									$sumavendidos_descuento += $rowB1['vendidos_descuento'];
								?>
							</td>
							
						</tr>
					
					
			<?php
					$i++;
					}
				// }
			?>




					<tr class = 'suma_total_aut_menos_vendidos_ooooo' numero_localidad = "<?php echo $row['idLocalidad']?>" >
						
						<td  style = 'border-top:1px solid #000;padding-top:5px;'>
							<div style = 'display:none;color:#fff;'id="suma_aut_menos_vendidos_<?php echo $row['idLocalidad']?>">
								<?php echo ($autorizados - ($sumavendidos_normal + $sumavendidos_descuento))?>
							</div>
							<?php //echo "(".$autorizados."-(".$sumavendidos_normal." + ".$sumavendidos_descuento."))"?></div>
						</td>
						<td style = 'border-top:1px solid #000;padding-top:5px;'></td>
						<td style = 'border-top:1px solid #000;padding-top:5px;'></td>
						<td style = 'border-top:1px solid #000;padding-top:5px;<?php echo $display;?>'></td>
						<td style = 'border-top:1px solid #000;padding-top:5px;'></td>
					</tr>
			<?php
					
				}
			?>
					<tr>
						<td>Totales</td>
						<td id = 'suma_aut_cortesias' style = 'text-align:center;'></td>
						<td id = 'suma_no_vendidos_cortesias' style = 'text-align:center;'></td>
						<td id = 'suma_vendidos_cortesias_todos' style = 'text-align:center;<?php echo $display;?>'></td>
						<td id = 'suma_vendidos_cortesias' style = 'text-align:center;'></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table class = 'table'>
					<tr>
						<th colspan = '3'>
							Totales Globales
						</th>
					</tr>
					
					
					
					<tr>
						<th>
							Autorizados : 
						</th>
						<td style = 'text-align:left;'>
							<div id = 'conjunto_autorizados'></div>
						</td>
					</tr>
					
					<tr>
						<th>
						No Vendidos : 
						</th>
						<td style = 'text-align:left;'>
							<div id = 'conjunto_no_vendidos'></div>
						</td>
					</tr>
					
					
					<tr style = '<?php echo $display;?>'>
						<th>
							Impresos : 
						</th>
						<td style = 'text-align:left;'>
							<div id = 'conjunto_impresos'></div>
						</td>
					</tr>
					
					<tr>
						<th>
							Vendidos : 
						</th>
						<td style = 'text-align:left;'>
							<div id = 'conjunto_vendidos'></div>
						</td>
					</tr>
					
					
				</table>

			</td>
		</tr>
	</table>
	
	
	<script>
		var tableToExcel = (function() {
			var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8" ><link href="css/style.css" media="screen" rel="StyleSheet" type="text/css"/><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
			return function(table, name) {
				if (!table.nodeType) table = document.getElementById(table)
				var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
				window.location.href = uri + base64(format(template, ctx))
			}
		})()
		$( document ).ready(function() {
			$( ".suma_total_aut_menos_vendidos" ).each(function( index ) {
				var numero_localidad = $(this).attr('numero_localidad');
				var suma_aut_menos_vendidos_ = $('#suma_aut_menos_vendidos_'+numero_localidad).text();
				// alert(suma_aut_menos_vendidos_)
				$('.no_vendido_'+numero_localidad).html(suma_aut_menos_vendidos_);
			});
			
			var suma_total_no_vendidos = 0;
			
			$( ".valore_no_vendidos" ).each(function( index ) {
				var valore_no_vendidos = $(this).text();
				 // alert(valore_no_vendidos)
				suma_total_no_vendidos += (parseFloat(valore_no_vendidos));
			});
			$('#suma_total_no_vendidos').html(suma_total_no_vendidos);
			
			
			
			var suma_Total_Autorizados = 0;
			
			$( ".autorizados_macro" ).each(function( index ) {
				var autorizados_macro = $(this).text();
				suma_Total_Autorizados += (parseFloat(autorizados_macro));
			});
			$('#suma_Total_Autorizados').html(suma_Total_Autorizados);
			
			var suma_impresos = 0;
			
			var impresos_macro = 0;
			$( ".suma_vendidos_todos_macro" ).each(function( index ) {
				var suma_vendidos_todos_macro = $(this).text();
				impresos_macro += (parseFloat(suma_vendidos_todos_macro));
			});
			
			
			var impresos_descuentos = 0;
			$( ".vendidos_descuento_todos" ).each(function( index ) {
				var vendidos_descuento_todos = $(this).text();
				impresos_descuentos += (parseFloat(vendidos_descuento_todos));
			});
			
			$('#suma_impresos').html(parseFloat(impresos_macro) + parseFloat(impresos_descuentos));
			
			
			var suma_vendidos_macro = 0;
			$( ".vendidos_macro" ).each(function( index ) {
				var vendidos_macro = $(this).text();
				suma_vendidos_macro += (parseFloat(vendidos_macro));
			});
			
			
			var suma_vendidos_descuento = 0;
			$( ".vendidos_descuento" ).each(function( index ) {
				var vendidos_descuento = $(this).text();
				suma_vendidos_descuento += (parseFloat(vendidos_descuento));
			});
			
			$('#suma_vendidoss').html(parseFloat(suma_vendidos_macro) + parseFloat(suma_vendidos_descuento));
			
			
			var suma_total_macro = 0;
			$( ".total_macro" ).each(function( index ) {
				var total_macro = $(this).val();
				// alert("total macro : " + total_macro);
				suma_total_macro += (parseFloat(total_macro));
			});
			
			var suma_total_descuento = 0;
			$( ".total_descuento" ).each(function( index ) {
				var total_descuento = $(this).val();
				  // alert("total descuento : " + total_descuento);
				suma_total_descuento += (parseFloat(total_descuento));
			});
			// alert('macros : ' + (parseFloat(suma_total_macro)).toFixed(2) + ' descuentos : ' + (parseFloat(suma_total_descuento)).toFixed(2));
			$('#suma_totales').html((parseFloat(suma_total_macro) + parseFloat(suma_total_descuento)).toFixed(2));
			
			var imp_mun = $('#imp_mun').val();
			
			$('#suma_admiciones').html(((parseFloat(suma_total_macro) + parseFloat(suma_total_descuento)) / (parseFloat(1) + parseFloat(imp_mun))).toFixed(2));
			
			$('#suma_impuestos').html((((parseFloat(suma_total_macro) + parseFloat(suma_total_descuento))) - (((parseFloat(suma_total_macro) + parseFloat(suma_total_descuento)) / (parseFloat(1) + parseFloat(imp_mun))))).toFixed(2));
			
			
			
			
			var suma_aut_cortesias = 0;
			$( ".aut_cortesias" ).each(function( index ) {
				var aut_cortesias = $(this).text();
				// alert(aut_cortesias)
				suma_aut_cortesias += (parseFloat(aut_cortesias));
			});
			
			$('#suma_aut_cortesias').html(suma_aut_cortesias);
			
			
			var suma_no_vendidos_cortesias = 0;
			$( ".no_vendidos_cortesias" ).each(function( index ) {
				var no_vendidos_cortesias = $(this).text();
				suma_no_vendidos_cortesias += (parseFloat(no_vendidos_cortesias));
			});
			
			$('#suma_no_vendidos_cortesias').html(suma_no_vendidos_cortesias);
			
			
			
			var suma_vendidos_cortesias_todos = 0;
			$( ".vendidos_cortesias_todos" ).each(function( index ) {
				var vendidos_cortesias_todos = $(this).text();
				suma_vendidos_cortesias_todos += (parseFloat(vendidos_cortesias_todos));
			});
			
			$('#suma_vendidos_cortesias_todos').html(suma_vendidos_cortesias_todos);
			
			
			var suma_vendidos_cortesias = 0;
			$( ".vendidos_cortesias" ).each(function( index ) {
				var vendidos_cortesias = $(this).text();
				suma_vendidos_cortesias += (parseFloat(vendidos_cortesias));
			});
			
			$('#suma_vendidos_cortesias').html(suma_vendidos_cortesias);
			
			
			
			
			$('#conjunto_autorizados').html(parseFloat(suma_Total_Autorizados) + parseFloat(suma_aut_cortesias));
			
			
			
			$('#conjunto_impresos').html(parseFloat(suma_vendidos_cortesias_todos) + parseFloat(parseFloat(impresos_macro) + parseFloat(impresos_descuentos)));
			
			
			
			
			$('#conjunto_vendidos').html(parseFloat(suma_vendidos_cortesias) + parseFloat(parseFloat(suma_vendidos_macro) + parseFloat(suma_vendidos_descuento)));
			$('#conjunto_no_vendidos').html(parseFloat(suma_total_no_vendidos) + parseFloat(suma_no_vendidos_cortesias));
		})
	</script>