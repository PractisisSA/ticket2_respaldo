<?php
	session_start();
	include '../../conexion.php';
	$selectConcierto = "SELECT idConcierto , idDet_Dis, strEvento, strImagen, strLugar, timeHora, dateFecha, estadoDet 
						FROM detalle_distribuidor 
						JOIN Concierto 
						ON detalle_distribuidor.conciertoDet = Concierto.idConcierto 
						WHERE idDis_Det = '".$_SESSION['idDis']."'
						
						and idConcierto >= 73
						order by Concierto.idConcierto DESC					
						";
	// echo $selectConcierto;
	$resultSelectCon = mysql_query($selectConcierto) or die (mysql_error());
?>

	<table  style='font-size:12px;border: 1px solid #fff;width:100%;color:#000 !important;background-color:#fff;' id = 'contieneLosConciertos' class = 'table'>
			<tr>
				<th colspan = '7' >
					VENTAS TODOS LOS CONCIERTO
				</th>
			</tr>
			<tr>
				<th style='font-size:12px;border: 1px solid #fff'>
					CONCIERTO
				</th>
				<th style='font-size:12px;border: 1px solid #fff'>
					<table width='100%'>
						<tr>
							<td colspan='2' align='left' style = 'border-bottom:1px solid #fff;'>
								VENTAS
							</td>
						</tr>
						<tr>
							<td width='30%' style='font-size:12px;border-right: 1px solid #fff'>
								EFECTIVO
							</td>
							<td width='30%' style='font-size:12px;'>
								TARJETAS
							</td>
							<td width='20%' style='font-size:12px;'>
								TICKETS
							</td>
						</tr>
					</table>
				</th>
				<th style='font-size:12px;border: 1px solid #fff;display:none;'>
					TICKETS
				</th>
				<th style='font-size:12px;border: 1px solid #fff'>
					TOTAL
				</th>
			</tr>
		<?php 
			$sumaCuantos = 0;

			$TickEmp = 0;
			while($rowCon = mysql_fetch_array($resultSelectCon)){

					$contar = 'SELECT count(idBoleto) as cuantos FROM Boleto WHERE idCon="'.$rowCon['idConcierto'].'"'; 
					$result = mysql_query($contar) or die (mysql_error());
					$rowResult = mysql_fetch_array($result);
					$cuantos = $rowResult['cuantos'];
					$sumaCuantos += $cuantos;
					$sumaNumeroEfectivo = 0;
					$sumaNumeroTar = 0;
					$sumaNumeroEfectivoPrev = 0;
					$sumaNumeroTarPrev = 0;
		?>
			<tr>
				<td align='left' style='font-size:12px;border: 1px solid #fff;text-align:left;' class = 'nombreEvento' onclick='enviaConcierto(<?php echo $rowCon['idConcierto']?>)'>
					<span class = 'numeroConcierto' numeroConc = '<?php echo $rowCon['idConcierto'];?>' >
					<?php
						echo $rowCon['strEvento']."   [".$rowCon['idConcierto']."]"; 
					?>
					</span>
				</td>
				<td style='font-size:12px;border: 1px solid #fff'>
					<table width='100%'>
						<tr>
							<td width='30%' style='font-size:12px;border-right: 1px solid #fff'>
								<?php 
									$sqlEf = 'SELECT idLocB
												FROM Boleto 
												WHERE idCon = "'.$rowCon['idConcierto'].'" 
												and rowB = "1"
												and tercera = 0
												and preventa = 0
												and id_usu_venta = "'.$_SESSION['iduser'].'"
												ORDER BY idLocB DESC 
											';
									//echo $sqlEf;
									$resEf = mysql_query($sqlEf) or die(mysql_error());

									$numEf = mysql_num_rows($resEf);

									$sumValEf = number_format((0),2);
									while($rowEf = mysql_fetch_array($resEf)){
										$idLocB = $rowEf['idLocB'];
										$sqlLo1 = 'select * from Localidad where idLocalidad = "'.$idLocB.'" ';
										//echo $sqlLo1."<br/>";
										$resLo1 = mysql_query($sqlLo1) or die (mysql_error());
										$rowLo1 = mysql_fetch_array($resLo1);
										$valorEfectivo = $rowLo1['doublePrecioL'];
										//echo $valorEfectivo;
										$sumValEf += $valorEfectivo;
									}
									//echo number_format(($sumValEf),2)."<br>";
									
									$sqlEfPrev = 'SELECT idLocB
												FROM Boleto 
												WHERE idCon = "'.$rowCon['idConcierto'].'" 
												and rowB = "1"
												and tercera = 0
												and preventa = 1
												and id_usu_venta = "'.$_SESSION['iduser'].'"
												ORDER BY idLocB DESC 
											';
									//echo $sqlEf;
									$resEfPrev = mysql_query($sqlEfPrev) or die(mysql_error());
									
									$numEfPrev = mysql_num_rows($resEfPrev);
									
									
									$sumValEfPrev = number_format((0),2);
									while($rowEfPrev = mysql_fetch_array($resEfPrev)){
										$idLocBPrev = $rowEfPrev['idLocB'];
										$sqlLoPrev = 'select * from Localidad where idLocalidad = "'.$idLocBPrev.'" ';
										//echo $sqlLo1."<br/>";
										$resLoPrev = mysql_query($sqlLoPrev) or die (mysql_error());
										$rowLoPrev = mysql_fetch_array($resLoPrev);
										$valorEfectivoPrev = $rowLoPrev['doublePrecioPreventa'];
										//echo $valorEfectivo;
										$sumValEfPrev += $valorEfectivoPrev;
									}
									//echo number_format(($sumValEfPrev),2)."<br>";
									
									
									$sqlEfTer = 'SELECT idLocB , sum(valor) as precio_desc_efectivo
												FROM Boleto 
												WHERE idCon = "'.$rowCon['idConcierto'].'" 
												and rowB = "1"
												and tercera = 1
												and preventa = 0
												and id_usu_venta = "'.$_SESSION['iduser'].'"
												ORDER BY idLocB DESC 
											';
									//echo $sqlEf;
									$resEfTer = mysql_query($sqlEfTer) or die(mysql_error());
									$rowEfTer = mysql_fetch_array($resEfTer);
									$numEfTer = mysql_num_rows($resEfTer);
									
									$sumValEfTer = number_format((0),2);
									$valorEfectivoTer = $rowEfTer['precio_desc_efectivo'];
										
									$sumValEfTer += $valorEfectivoTer;
									
									
									
									
									$sqlEfTerPrev = 'SELECT idLocB , sum(valor) as precio_desc_efectivo
												FROM Boleto 
												WHERE idCon = "'.$rowCon['idConcierto'].'" 
												and rowB = "1"
												and tercera = 1
												and preventa = 1
												and id_usu_venta = "'.$_SESSION['iduser'].'"
												ORDER BY idLocB DESC 
											';
									//echo $sqlEf;
									$resEfTerPrev = mysql_query($sqlEfTerPrev) or die(mysql_error());
									
									$numEfTerPrev = mysql_num_rows($resEfTerPrev);
									
									$sumValEfTerPrev = number_format((0),2);
									
									$rowEfTerPrev = mysql_fetch_array($resEfTerPrev);
									
									$valorEfectivoTerPrev = $rowEfTerPrev['precio_desc_efectivo'];
									
									$sumValEfTerPrev += $valorEfectivoTerPrev;
									
									
									$sumaEfectivo = ($sumValEf + $sumValEfPrev + $sumValEfTer + $sumValEfTerPrev);
									
									echo number_format(($sumaEfectivo),2);//."ee";
									
									$sumaCantEfectivo = ($numEf + $numEfPrev + $numEfTer + $numEfTerPrev);
								?>
							</td>
							<td width='30%'  style='font-size:12px;'>
								
								<?php 
									$sqlTar = 'SELECT idLocB
												FROM Boleto 
												WHERE idCon = "'.$rowCon['idConcierto'].'" 
												and rowB = "2"
												and tercera = 0
												and preventa = 0
												and id_usu_venta = "'.$_SESSION['iduser'].'"
												ORDER BY idLocB DESC 
											';
									//echo $sqlTar."<br><br/>";
									$resTar = mysql_query($sqlTar) or die(mysql_error());
									
									$numTar = mysql_num_rows($resTar);
									
									
									$sumValTar = number_format((0),2);
									while($rowTar = mysql_fetch_array($resTar)){
										$idLocBTar = $rowTar['idLocB'];
										//echo $idLocBTar."<br>";
										$sqlLoTar = 'select * from Localidad where idLocalidad = "'.$rowTar['idLocB'].'" ';
										//echo $sqlLo1."<br/>";
										$resLoTar = mysql_query($sqlLoTar) or die (mysql_error());
										$rowLoTar = mysql_fetch_array($resLoTar);
										$valorTar = $rowLoTar['doublePrecioL'];
										//echo $valorTar;
										$sumValTar += $valorTar;
									}
									//echo number_format(($sumValTar),2)."<br>";
									
									
									$sqlTarTer = 'SELECT idLocB , sum(valor) as precio_desc_efectivo
												FROM Boleto 
												WHERE idCon = "'.$rowCon['idConcierto'].'" 
												and rowB = "2"
												and tercera = 1
												and preventa = 0
												and id_usu_venta = "'.$_SESSION['iduser'].'"
												ORDER BY idLocB DESC 
											';
									//echo $sqlTarTer."<br><br/>";
									$resTarTer = mysql_query($sqlTarTer) or die(mysql_error());
									
									$numTarTer = mysql_num_rows($resTarTer);
									
									$sumValTarTer = number_format((0),2);
									
									$rowTarTer = mysql_fetch_array($resTarTer);
									$valorTarTer = $rowTarTer['precio_desc_efectivo'];
										//echo $valorTarTer;
									$sumValTarTer += $valorTarTer;
									
									//echo number_format(($sumValTarTer),2)."<br>";
									
									
									$sqlTarPrev = 'SELECT idLocB
											FROM Boleto 
											WHERE idCon = "'.$rowCon['idConcierto'].'" 
											and rowB = "2"
											and tercera = 0
											and preventa = 1
											and id_usu_venta = "'.$_SESSION['iduser'].'"
											ORDER BY idLocB DESC 
										';
									//echo $sqlTarPrev."<br><br/>";
									$resTarPrev = mysql_query($sqlTarPrev) or die(mysql_error());
									
									$numTarPrev = mysql_num_rows($resTarPrev);
									
									
									$sumValTarPrev = number_format((0),2);
									while($rowTarPrev = mysql_fetch_array($resTarPrev)){
										$idLocBTarPrev = $rowTarPrev['idLocB'];
										//echo $idLocBTarPrev."<br>";
										$sqlLoTarPrev = 'select * from Localidad where idLocalidad = "'.$rowTarPrev['idLocB'].'" ';
										//echo $sqlLo1."<br/>";
										$resLoTarPrev = mysql_query($sqlLoTarPrev) or die (mysql_error());
										$rowLoTarPrev = mysql_fetch_array($resLoTarPrev);
										$valorTarPrev = ($rowLoTarPrev['doublePrecioPreventa']);
										//echo $valorTarPrev;
										$sumValTarPrev += $valorTarPrev;
									}
									//echo number_format(($sumValTarPrev),2)."<br>";
									
									
									$sqlTarPrevTer = 'SELECT idLocB , sum(valor) as precio_desc_efectivo
												FROM Boleto 
												WHERE idCon = "'.$rowCon['idConcierto'].'" 
												and rowB = "2"
												and tercera = 1
												and preventa = 1
												and id_usu_venta = "'.$_SESSION['iduser'].'"
												ORDER BY idLocB DESC 
											';
									//echo $sqlTarPrevTer."<br><br/>";
									$resTarPrevTer = mysql_query($sqlTarPrevTer) or die(mysql_error());
									
									$numTarPrevTer = mysql_num_rows($resTarPrevTer);
									
									$sumValTarPrevTer = number_format((0),2);
									
									$rowTarPrevTer = mysql_fetch_array($resTarPrevTer);
									
									$valorTPT = $rowTarPrevTer['precio_desc_efectivo'];
										//echo $valorTPT.">><<";
									$sumValTarPrevTer += $valorTPT;
										
									
									//echo number_format(($sumValTarPrevTer),2)."<br>";
									
									
									$sumaTarjeta = ($sumValTar + $sumValTarTer + $sumValTarPrev + $sumValTarPrevTer);
									echo number_format(($sumaTarjeta),2);//."tt";
									$globalTarjeta += $sumaTarjeta;
									$globalEfectivo += $sumaEfectivo;
									
									$sumaCantTarjeta = ($numTar + $numTarTer + $numTarPrev + $numTarPrevTer);
								?>
							</td>
							<td width="20%"><?php echo $cuantos;?></td>
						</tr>
					</table>
				</td>
				<td style='font-size:12px;border: 1px solid #fff;display:none;'>
					<?php 
						$globalNumeroEfectivo = ($sumaCantEfectivo + $sumaCantTarjeta);
						echo $globalNumeroEfectivo;//."eef";
						$globalNumeroTick += $globalNumeroEfectivo;
					?>
				</td>
				<td style='font-size:12px;border: 1px solid #fff'>
					<?php 
						$globalValorEfectivo = ($sumaEfectivo + $sumaTarjeta);
						$globalValorRecibido += $globalValorEfectivo;
						echo number_format(($globalValorEfectivo),2)."<br/>";
						echo "<input type = 'hidden'  class = 'sumaValorConcierto_".$rowCon['idConcierto']."' value = '".$globalValorEfectivo."' />";
					?>
				</td>
				<!--
				<td style='font-size:12px;border: 1px solid #fff'>
					<?php
						echo "<label class = 'sumaComisiones_".$rowCon['idConcierto']."'></label>";
					?>
				</td>
				<td style='font-size:12px;border: 1px solid #fff'>
					<label class = 'totalPagar_<?php echo $rowCon['idConcierto'];?>' ></label>
				</td>
				
				<td style='font-size:12px;border: 1px solid #fff'>
					<?php
						
						$sqlTickEmp = '	SELECT sum(num_bol) as bol_empresario
										FROM cortesias
										where id_con = "'.$rowCon['idConcierto'].'"  
										and tipo = 2
										ORDER BY tipo ASC 
									';
						//echo $sqlTickEmp;
						$resTickEmp = mysql_query($sqlTickEmp) or die (mysql_error());
						$rowTickEmp = mysql_fetch_array($resTickEmp);
						$TickEmp = $rowTickEmp['bol_empresario'];
						if($TickEmp == null){
							echo 0;
						}else{
							echo $TickEmp;
						}
					?>
				</td>-->
			</tr>
		<?php 
			}
		?>
			<tr style = "">
				<td>
					
					
				</td>
				<td>
					<table width = "100%">
						<tr>
							<td width="30%" style = "border-right:1px solid #fff;width:50%; " >
								<?php echo number_format(($globalEfectivo),2);?>
							</td>
							<td width="30%">
								<?php echo number_format(($globalTarjeta),2);?>
							</td>
							<td width="20%">
								<?php echo $sumaCuantos;?>
							</td>
						</tr>
					</table>
					
				</td>
				
				
				<td>
					<?php echo number_format(($globalValorRecibido),2); ?>
				</td>
				<!--<td>
					<span id = "sumaComRet">
						
					</span>
				</td>
				<td>
					
				</td>
				<td>
					
				</td>-->
				
			</tr>
		</table>