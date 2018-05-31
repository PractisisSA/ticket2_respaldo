<?php
	include '../../conexion.php';
	$idConcierto = $_REQUEST['idConcierto'];
	
	$sqlC = 'select * from Concierto where idConcierto = "'.$idConcierto.'" ';
	$resC = mysql_query($sqlC) or die (mysql_error());
	$rowC = mysql_fetch_array($resC);
	
	$sql = 'SELECT * 
			FROM Boleto 
			WHERE idCon = "'.$idConcierto.'" 
			
			group by idLocB
			ORDER BY idLocB DESC ';
			
			
	$sqlComWeb ='SELECT * FROM `comi_ret` WHERE `id_con` =  "'.$idConcierto.'" and detalle = "PAGINA WEB" ';
	//echo $sqlComWeb;
	$resComWeb = mysql_query($sqlComWeb) or die (mysql_error());
	$rowComWeb = mysql_fetch_array($resComWeb);
	//echo $totalTar.'--'.$totalEfectivoPREV2 suma tarjetas;
	$comi_tar = $rowComWeb['comi_tar'];
	$ret_renta = $rowComWeb['ret_renta'];
	$ret_iva = $rowComWeb['ret_iva'];
	
	
	
	
	$sqlComWeb1 ='SELECT * FROM `comi_ret` WHERE `id_con` =  "'.$idConcierto.'" and detalle = "PUNTOS TICKET FACIL" ';
	//echo $sqlComWeb1;
	$resComWeb1 = mysql_query($sqlComWeb1) or die (mysql_error());
	$rowComWeb1 = mysql_fetch_array($resComWeb1);
	//echo $totalTar.'--'.$totalEfectivoPREV2 suma tarjetas;
	$comi_tar1 = $rowComWeb1['comi_tar'];
	$ret_renta1 = $rowComWeb1['ret_renta'];
	$ret_iva1 = $rowComWeb1['ret_iva'];
	
	
	
	
	
	$sqlComWeb2 ='SELECT * FROM `comi_ret` WHERE `id_con` =  "'.$idConcierto.'" and detalle = "cadena comercial" ';
	//echo $sqlComWeb2;
	$resComWeb2 = mysql_query($sqlComWeb2) or die (mysql_error());
	$rowComWeb2 = mysql_fetch_array($resComWeb2);
	//echo $totalTar.'--'.$totalEfectivoPREV2 suma tarjetas;
	$comi_tar2 = $rowComWeb2['comi_tar'];
	$ret_renta2 = $rowComWeb2['ret_renta'];
	$ret_iva2 = $rowComWeb2['ret_iva'];
	
	echo $comi_tar.' '.$comi_tar1.' '.$comi_tar2;
?>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<style>
		th , td {
			text-align:center;
			
		}
		table , tr , th  , td{
			border:1px solid #fff ;
			vertical-align:top;
		}
	</style>
	<table  style='font-size:12px;position:relative' width ='100%' border ='1'>
		<tr>
			<th colspan = '11' style='background-color:#171A1B;color:#fff;'>
				VENTAS : <?php echo $rowC['strEvento'];?>
			</th>
		</tr>
		<tr>
			<th>
				<table>
					<tr>
						<td>
							
						</td>
					</tr>
					<tr>
						<td>
							LOCALIDAD
						</td>
					</tr>
				</table>
			</th>
			<th>
				<table>
					<tr>
						<td>
							
						</td>
					</tr>
					<tr>
						<td>
							PRECIO
						</td>
					</tr>
				</table>
			</th>
			<th>
				<table width = '100%' border = '1' >
					<tr>
						<td colspan='3' style='text-align:center;'>
							EFECTIVO
						</td>
					</tr>
					<tr>
						<td  width = '33.33%'>
							Tickets
						</td>
						<td  width = '33.33%'>
							Tickets <br/>50%
						</td>
						<td  width = '33.33%'>
							Total
						</td>
					</tr>
				</table>
			</th>
			<th>
				<table width ='100%' border ='1'>
					<tr>
						<td colspan='3' style='text-align:center;'>
							TARJETA
						</td>
					</tr>
					<tr>
						<td  width = '33.33%'>
							Tickets
						</td>
						<td  width = '33.33%'>
							Tickets <br/>50%
						</td>
						<td  width = '33.33%'>
							Total
						</td>
					</tr>
				</table>
			</th>
			
			<th>
				<table width ='100%' border ='1'>
					<tr>
						<td colspan='3' style='text-align:center;font-size:12px;'>
							EF PREV
						</td>
					</tr>
					<tr>
						<td  width = '33.33%'>
							Tickets
						</td>
						<td  width = '33.33%'>
							Tickets <br/>50%
						</td>
						<td  width = '33.33%'>
							Total
						</td>
					</tr>
				</table>
			</th>
			
			<th>
				<table width ='100%' border ='1'>
					<tr>
						<td colspan='3' style='text-align:center;font-size:12px;'>
							TAR PREV
						</td>
					</tr>
					<tr>
						<td  width = '33.33%'>
							Tickets
						</td>
						<td  width = '33.33%'>
							Tickets <br/>50%
						</td>
						<td  width = '33.33%'>
							Total
						</td>
					</tr>
				</table>
			</th>
			
			
			<th>
				TOTAL TICKETS
			</th>
			<th>
				TOTAL COBRADO
			</th>
			<th>
				COMISIÓN TARJETA
			</th>
			<th>
				RETENCIÓN
			</th>
			<!--<th>
				COMISIÓN VENTAS
			</th>-->
			<th>
				TOTAL A CANCELAR
			</th>
		</tr>
<?php
	$res = mysql_query($sql) or die (mysql_error());
	while($row = mysql_fetch_array($res)){
		$sqlL = 'select * from Localidad where idLocalidad = "'.$row['idLocB'].'" ';
		$resL = mysql_query($sqlL) or die (mysql_error());
		$rowL = mysql_fetch_array($resL);
?>
	<tr>
			<td>
				<?php echo $rowL['strDescripcionL'];?>
			</td>
			<td>
				<?php echo number_format(($rowL['doublePrecioL']),2);?>
			</td>
			<td>
				<table width='100%' border ="1">
					<tr>
						<td width = '33.33%'>
							<?php 
								$sqlEf = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										 
										and rowB = "1"
										and tercera = 0
										and preventa = 0
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEf;
								$resEF = mysql_query($sqlEf) or die (mysql_error());
								$rowEF = mysql_fetch_array($resEF);
								$numeroEfectivo = $rowEF['idBol'];
								echo $numeroEfectivo;
								$sumaNumeroEfectivo += $numeroEfectivo;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								$sqlEfT = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										 
										and rowB = "1"
										and tercera = 1
										and preventa = 0
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfT;
								$resEFT = mysql_query($sqlEfT) or die (mysql_error());
								$rowEFT = mysql_fetch_array($resEFT);
								$numeroEfectivoTer = $rowEFT['idBol'];
								
								
								//$numeroEfectivoTer = 1;
								echo $numeroEfectivoTer;
								$totaltotalnumeroEfectivoTer += $numeroEfectivoTer;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								$totalEfectivo = (($numeroEfectivo + ($numeroEfectivoTer * 0.5))*$rowL['doublePrecioL']);
								echo $totalEfectivo;
								$sumaTotalEfectivo += $totalEfectivo;
							?>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<table width='100%' width = '100%' border ='1' >
					<tr>
						<td width = '33.33%'>
							<?php
								$sqlTar = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										 
										and rowB = "2"
										and tercera = 0
										and preventa = 0
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEf;
								$resTar = mysql_query($sqlTar) or die (mysql_error());
								$rowTar = mysql_fetch_array($resTar);
								$numeroTar = $rowTar['idBol'];
								echo $numeroTar;
								$sumaNumeroTar += $numeroTar;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								// $terceraEdadTar = 0;
								// echo $terceraEdadTar;
								$sqlEfT1 = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										 
										and rowB = "2"
										and tercera = 1
										and preventa = 0
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfT;
								$resEFT1 = mysql_query($sqlEfT1) or die (mysql_error());
								$rowEFT1 = mysql_fetch_array($resEFT1);
								$numeroEfectivoTer1 = $rowEFT1['idBol'];
								$totalnumeroEfectivoTer1 += $numeroEfectivoTer1;
								
								//$numeroEfectivoTer = 1;
								echo $numeroEfectivoTer1;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								$totalTar = (($numeroTar + ($numeroEfectivoTer1 * 0.5))*$rowL['doublePrecioL']);
								echo $totalTar;//."dd";
								$sumaTotalTar += $totalTar;
							?>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<table width='100%' border ="1">
					<tr>
						<td width = '33.33%'>
							<?php 
								$sqlEfPREV = '
										SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										 
										and rowB = "1"
										and tercera = 0
										and preventa = 1
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfPREV;
								$resEFPREV = mysql_query($sqlEfPREV) or die (mysql_error());
								$rowEFPREV = mysql_fetch_array($resEFPREV);
								$numeroEfectivoPREV = $rowEFPREV['idBol'];
								echo $numeroEfectivoPREV;
								$sumaNumeroEfectivoPREV += $numeroEfectivoPREV;
								
								
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								$sqlEfTPREV = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										 
										and rowB = "1"
										and tercera = 1
										and preventa = 1
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfTPREV;
								$resEFTPREV = mysql_query($sqlEfTPREV) or die (mysql_error());
								$rowEFTPREV = mysql_fetch_array($resEFTPREV);
								$numeroEfectivoTerPREV = $rowEFTPREV['idBol'];
								
								
								//$numeroEfectivoTerPREV = 1;
								echo $numeroEfectivoTerPREV;
								$totaltotalnumeroEfectivoTerPREV += $numeroEfectivoTerPREV;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								$totalEfectivoPREV = (($numeroEfectivoPREV + ($numeroEfectivoTerPREV * 0.5))*$rowL['doublePrecioPreventa']);
								echo $totalEfectivoPREV;
								$sumaTotalEfectivoPREVTAR += $totalEfectivoPREV;
							?>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<table width='100%' border ="1">
					<tr>
						<td width = '33.33%'>
							<?php 
								$sqlEfPREVT = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										 
										and rowB = "2"
										and tercera = 0
										and preventa = 1
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfPREVT;
								$resEFPREVT = mysql_query($sqlEfPREVT) or die (mysql_error());
								$rowEFPREVT = mysql_fetch_array($resEFPREVT);
								$numeroEfectivoPREVT = $rowEFPREVT['idBol'];
								echo $numeroEfectivoPREVT;//."rr";
								$sumaNumeroEfectivoPREVT += $numeroEfectivoPREVT;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								$sqlEfTPREV = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										 
										and rowB = "2"
										and tercera = 1
										and preventa = 1
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfTPREV;
								$resEFTPREV = mysql_query($sqlEfTPREV) or die (mysql_error());
								$rowEFTPREV = mysql_fetch_array($resEFTPREV);
								$numeroEfectivoTerPREV22 = $rowEFTPREV['idBol'];
								
								
								//$numeroEfectivoTerPREV = 1;
								echo $numeroEfectivoTerPREV22;//."tt";
								$totaltotalnumeroEfectivoTerPREVTERCERA += $numeroEfectivoTerPREV22;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								$totalEfectivoPREV2 = (($numeroEfectivoPREVT + ($numeroEfectivoTerPREV22 * 0.5))*$rowL['doublePrecioPreventa']);
								echo $totalEfectivoPREV2;//."aa";
								$sumaTotalEfectivoTAREFEPREV += $totalEfectivoPREV2;
							?>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<?php
					$globalTickets = (($numeroEfectivo + $numeroEfectivoTer)+($numeroTar + $numeroEfectivoTer1) + ($numeroEfectivoPREV+$numeroEfectivoTerPREV) + ($numeroEfectivoTerPREV22 + $numeroEfectivoPREVT));
					echo $globalTickets;
					$sumaGlobalTickets += $globalTickets;
					
				?>
			</td>
			<td>
				<?php
					$globalCobrado = ($totalEfectivo + $totalTar + $totalEfectivoPREV + $totalEfectivoPREV2);
					echo $globalCobrado;
					$sumaGlobalCogrado += $globalCobrado;
					
				?>
			</td>
			<td>
				<?php
				$comisionTarjeta = (($comi_tar * ($totalTar + $totalEfectivoPREV2))/100);
				$retencionTarjeta = number_format((((($totalTar + $totalEfectivoPREV2)/ 1.14)*($ret_renta/100))+((($totalTar + $totalEfectivoPREV2) - (($totalTar + $totalEfectivoPREV2) / 1.14))*($ret_iva/100))),2);

				$comisionTarjeta1 = (($comi_tar1 * ($totalTar + $totalEfectivoPREV2))/100);
				$retencionTarjeta1 = number_format((((($totalTar + $totalEfectivoPREV2)/ 1.14)*($ret_renta1/100))+((($totalTar + $totalEfectivoPREV2) - (($totalTar + $totalEfectivoPREV2) / 1.14))*($ret_iva1/100))),2);

				
				
				
				
				$comisionTarjeta2 = (($comi_tar2 * ($totalTar + $totalEfectivoPREV2))/100);
				$retencionTarjeta2 = number_format((((($totalTar + $totalEfectivoPREV2)/ 1.14)*($ret_renta2/100))+((($totalTar + $totalEfectivoPREV2) - (($totalTar + $totalEfectivoPREV2) / 1.14))*($ret_iva2/100))),2);
				
				
				// echo '('.$comi_tar.'*('.$totalTar.' + '.$totalEfectivoPREV2.')/100) = '.$comisionTarjeta.' <br>';
				// echo '('.$comi_tar1.'*('.$totalTar.' + '.$totalEfectivoPREV2.')/100) = '.$comisionTarjeta1.' <br>';
				// echo '('.$comi_tar2.'*('.$totalTar.' + '.$totalEfectivoPREV2.')/100) = '.$comisionTarjeta2.' <br>';
				
				
				
				//echo $comisionTarjeta.'<<>>'.$comisionTarjeta1.'<<>>'.$comisionTarjeta2.'<br>';
				$suma1ComisionTarjeta = ($comisionTarjeta);
				$sumacomisionTarjeta += $suma1ComisionTarjeta;
				$suma1RetencionTarjeta = ($retencionTarjeta);

				$sumaretencionTarjeta += $suma1RetencionTarjeta;
					
					echo number_format(($suma1ComisionTarjeta),2);
				?>
			</td>
			<td>
				<?php
					//$retencionTarjeta = (($totalTar * $retencionTarjeta)/100);
				//	echo "(".($totalTar + $totalEfectivoPREV2)."*".$ret_renta."/100)+(".($totalTar + $totalEfectivoPREV2)."-".($totalTar + $totalEfectivoPREV2)."/ 1.14) * (".$ret_iva." /100)<br>";
					echo $suma1RetencionTarjeta//."fff";
					
				?>
			</td>
			<!--<td>
				<?php
					$comisionVentas = ($totalTar * 0.00);
					echo $comisionVentas;
					$sumacomisionVentas += $comisionVentas;
				?>
			</td>-->
			<td>
				<?php
					$totalAPagar = ($globalCobrado - $comisionTarjeta - $retencionTarjeta - $comisionVentas);
					echo number_format(($totalAPagar),2);
					$sumatotalAPagar += $totalAPagar;
				?>
			</td>
			
	</tr>
<?php
	}
?>
	<tr>
			<td>
				TOTAL
			</td>
			<td>
				<?php 
					echo $totalBoletos."";
				?>
			</td>
			<td>
				<table width='100%'>
					<tr>
						<td width = '33.33%'>
							<?php
								
								echo $sumaNumeroEfectivo;
								
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								$terceraEdadEf = 0;
								echo $totaltotalnumeroEfectivoTer;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								
								echo $sumaTotalEfectivo;
							?>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<table width='100%'>
					<tr>
						<td width = '33.33%'>
							<?php
								echo $sumaNumeroTar;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								$terceraEdadTar = 0;
								echo $totalnumeroEfectivoTer1;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								echo $sumaTotalTar;
							?>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<table width='100%'>
					<tr>
						<td width = '33.33%'>
							<?php echo $sumaNumeroEfectivoPREV;?>
						</td>
						<td width = '33.33%'>
							<?php 
								$terceraEdadTar = 0;
								echo $totaltotalnumeroEfectivoTerPREV;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								echo $sumaTotalEfectivoPREVTAR;
							?>
						</td>
					</tr>
				</table>
				
			</td>
			<td>
				<table width='100%'>
					<tr>
						<td width = '33.33%'>
							<?php echo $sumaNumeroEfectivoPREVT;?>
						</td>
						<td width = '33.33%'>
							<?php 
								$terceraEdadTar = 0;
								echo $totaltotalnumeroEfectivoTerPREVTERCERA;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								echo $sumaTotalEfectivoTAREFEPREV;
							?>
						</td>
					</tr>
				</table>
			</td>
			<td>
				<?php
					echo $sumaGlobalTickets;
				?>
			</td>
			<td>
				<?php
					echo $sumaGlobalCogrado;
				?>
			</td>
			<td>
				<?php
					echo $sumacomisionTarjeta;
				?>
			</td>
			<td>
				<?php
					echo $sumaretencionTarjeta;
				?>
			</td>
			<!--<td>
				<?php
					echo $sumacomisionVentas;
				?>
			</td>-->
			<td>
				<?php
					echo number_format(($sumatotalAPagar),2);
				?>
			</td>
			
			
		</tr>
	</table>