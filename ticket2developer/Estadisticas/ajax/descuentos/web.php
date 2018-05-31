<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<?php
	ini_set('memory_limit', '512M');
	include '../../../conexion.php';
	$idConcierto = $_REQUEST['idCon'];
	echo '<input type = "hidden" id = "id_concierto" value = "'.$idConcierto.'" />';
	$sqlImp = 'select * from impuestos where id_con = "'.$idConcierto.'" ';
	$resImp = mysql_query($sqlImp) or die (mysql_error());
	$rowImp = mysql_fetch_array($resImp);
	$valorados = $rowImp['valorados'];
	$iva = $rowImp['iva'];
	$sin_permisos = $rowImp['sin_permisos'];
	$cortesias = $rowImp['cortesias'];
	$sayse = $rowImp['sayse'];
	$sri = $rowImp['sri'];
	$municipio = $rowImp['municipio'];
	
	
	$sqlC = 'select * from Concierto where idConcierto = "'.$idConcierto.'" ';
	$resC = mysql_query($sqlC) or die (mysql_error());
	$rowC = mysql_fetch_array($resC);
	
	$sql = 'SELECT * 
			FROM Boleto 
			WHERE idCon = "'.$idConcierto.'" 
			and colB = 1
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
	
	//echo $comi_tar.' '.$comi_tar1.' '.$comi_tar2;
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
			color:#fff;
		}
		
		.botonimagen{
			background-image:url(http://siga.rinconacademico.com/excel.jpg);
			background-repeat:no-repeat;
			height:50px;
			width:100px;
			background-position:center;
			cursor:pointer;
		}
	</style>
	
	
	<table  style='font-size:12px;position:relative:color:#fff;' width ='100%' border ='1'>
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
							Tickets <br/><span style = 'font-size:12px;'>DESC.</span>
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
							Tickets <br/><span style = 'font-size:12px;'>DESC.</span>
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
							Tickets <br/><span style = 'font-size:12px;'>DESC.</span>
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
							Tickets <br/><span style = 'font-size:12px;'>DESC.</span>
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
		$sqlL = 'select * from Localidad where idLocalidad = "'.$row['idLocB'].'" order by strDescripcionL ASC';
		$resL = mysql_query($sqlL) or die (mysql_error());
		$rowL = mysql_fetch_array($resL);
?>
	<tr class = 'tr_cadalocalidad'>
			<td style = 'text-align:left;border:1px solid #fff;padding-rigth:10px;'>
				<?php echo $rowL['strDescripcionL'];?>
			</td>
			<td style = 'text-align:right;border:1px solid #fff;'>
				<?php echo number_format(($rowL['doublePrecioL']),2);?>
			</td>
			<td style = 'text-align:right;'>
				<table width='100%' border ="1">
					<tr>
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php 
								$sqlEf = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and colB = 1
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
								echo $numeroEfectivo;//."ef";
								$sumaNumeroEfectivo += $numeroEfectivo;
							?>
						</td>
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php 
								$sqlEfT = 'SELECT count(idBoleto) as idBol , sum(valor) as precio_desc_efectivo
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and colB = 1
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
								echo $numeroEfectivoTer;//."ef ter";
								$totaltotalnumeroEfectivoTer += $numeroEfectivoTer;
							?>
						</td>
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php 
								$totalEfectivo = (($numeroEfectivo * $rowL['doublePrecioL']) + $rowEFT['precio_desc_efectivo']);
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
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php
								$sqlTar = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "1"
										and tercera = 0
										and preventa = 0
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEf;
								$resTar = mysql_query($sqlTar) or die (mysql_error());
								$rowTar = mysql_fetch_array($resTar);
								$numeroTar = $rowTar['idBol'];
								//echo $numeroTar."tar web <br/><br/>";
								
								
								$tajetasNormales = ($numeroTar);
								echo $tajetasNormales;//."tar nor";//."<br><br>";
								$sumaNumeroTar += $tajetasNormales;
							?>
						</td>
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php 
								
								$sqlEfT1 = 'SELECT count(idBoleto) as idBol , sum(valor) as precio_desc_tarjeta_web
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "1"
										and tercera = 1
										and preventa = 0
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								$resEFT1 = mysql_query($sqlEfT1) or die (mysql_error());
								$rowEFT1 = mysql_fetch_array($resEFT1);
								$numeroEfectivoTer1 = $rowEFT1['idBol'];
								//echo $numeroEfectivoTer1."Tar web Ter <br/><br/>";
								
							
								
								$tajetasNormalesTercera = ($numeroEfectivoTer1);
								
								
								echo $tajetasNormalesTercera;//."tar ter";//."<br><br>";
								$totalnumeroEfectivoTer1 += $tajetasNormalesTercera;
							?>
						</td>
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php 
								
								$totalTar = (($tajetasNormales * $rowL['doublePrecioL']) + ($rowEFT1['precio_desc_tarjeta_web'] +  $rowEFT1Cad['precio_desc_tarjeta_cad'] +  $rowEFT1CadTf['precio_desc_tarjeta_tf']) ) ;
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
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php 
								$sqlEfPREV = '
										SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and colB = 1
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
								echo $numeroEfectivoPREV;//."ef prev";
								$sumaNumeroEfectivoPREV += $numeroEfectivoPREV;
								
								
							?>
						</td>
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php 
								$sqlEfTPREV = 'SELECT count(idBoleto) as idBol , sum(valor) as precio_desc_efectivo_preventa
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and colB = 1 
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
								echo $numeroEfectivoTerPREV;//."ef prev ter";
								$totaltotalnumeroEfectivoTerPREV += $numeroEfectivoTerPREV;
							?>
						</td>
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php 
								$totalEfectivoPREV = (($numeroEfectivoPREV *$rowL['doublePrecioPreventa']) + $rowEFTPREV['precio_desc_efectivo_preventa']);
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
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php 
								$sqlEfPREVT = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "1"
										and tercera = 0
										and preventa = 1
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfPREVT;
								$resEFPREVT = mysql_query($sqlEfPREVT) or die (mysql_error());
								$rowEFPREVT = mysql_fetch_array($resEFPREVT);
								$numeroEfectivoPREVT = $rowEFPREVT['idBol'];
								//echo $numeroEfectivoPREVT."tar prev Web <br/><br/>";
								
								
								
								$tarjetasNormalesPrev = ($numeroEfectivoPREVT);
								echo $tarjetasNormalesPrev;//."tar prev";//."<br/><br/>";
								$sumaNumeroEfectivoPREVT += $tarjetasNormalesPrev;
							?>
						</td>
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php 
								$sqlEfTPREV = 'SELECT count(idBoleto) as idBol , sum(valor) as precio_boleto_tar__prev_web
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "1"
										and tercera = 1
										and preventa = 1
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfTPREV;
								$resEFTPREV = mysql_query($sqlEfTPREV) or die (mysql_error());
								$rowEFTPREV = mysql_fetch_array($resEFTPREV);
								$numeroEfectivoTerPREV22 = $rowEFTPREV['idBol'];
								//echo $numeroEfectivoTerPREV22."tar prev ter web <br/><br/>";
								
								
								
								$tarjetasNormalesPrevTer = ($numeroEfectivoTerPREV22);
								echo $tarjetasNormalesPrevTer;//."tar prev ter";//."<br/><br/>";
								$totaltotalnumeroEfectivoTerPREVTERCERA += $tarjetasNormalesPrevTer;
							?>
						</td>
						<td width = '33.33%' style = 'text-align:right;border:1px solid #fff;font-size:12px;'>
							<?php 
								$totalEfectivoPREV2 = (($tarjetasNormalesPrev * $rowL['doublePrecioPreventa']) + ($rowEFTPREV['precio_boleto_tar__prev_web'] + $rowEFTPREVCad['precio_boleto_tar__prev_cad'] + $rowEFTPREVCadTf['precio_boleto_tar__prev_tf']));
								echo $totalEfectivoPREV2;//."aa";
								$sumaTotalEfectivoTAREFEPREV += $totalEfectivoPREV2;
							?>
						</td>
					</tr>
				</table>
			</td>
			<td  style = 'text-align:right;border:1px solid #fff;'>
				<?php
					
					$globalTickets = ($numeroEfectivo + $numeroEfectivoTer + $tajetasNormales + $tajetasNormalesTercera + $numeroEfectivoPREV + $numeroEfectivoTerPREV + $tarjetasNormalesPrev + $tarjetasNormalesPrevTer);
					echo $globalTickets;//."hhh";
					$sumaGlobalTickets += $globalTickets;
					
				?>
			</td>
			<td style = 'text-align:right;border:1px solid #fff;'>
				<?php
					if($rowL['gratuidad'] == 1){
						$globalCobrado = 0;
					}else{
						$globalCobrado = ($totalEfectivo + $totalTar + $totalEfectivoPREV + $totalEfectivoPREV2);
					}
					
					echo $globalCobrado;//."gc";
					$sumaGlobalCogrado += $globalCobrado;
					
				?>
			</td>
			<td nom_loc = '<?php echo $rowL['strDescripcionL'];?>' global_tickets ='<?php echo $globalTickets;?>' global_cobrado = '<?php echo $globalCobrado;?>' style = 'text-align:right;border:1px solid #fff;'>
				<?php
					echo '<input type = "hidden" class = "nom_loc" value = "'.$rowL['strDescripcionL'].'" />';
					echo '<input type = "hidden" class = "global_tickets" value = "'.$globalTickets.'" />';
					echo '<input type = "hidden" class = "global_cobrado" value = "'.number_format(($globalCobrado),2).'" />';
					echo '<input type = "hidden" class = "precio_loc" value = "'.number_format(($rowL['doublePrecioL']),2).'" />';
					
					
					$tajetasWeb = (($numeroTar + ($numeroEfectivoTer1 * 0.5)) * $rowL['doublePrecioL']);
					//echo $tajetasWeb."tw<br/><br/>";
					$tarjetasWebPreventa = (($numeroEfectivoPREVT + ($numeroEfectivoTerPREV22 * 0.5)) * $rowL['doublePrecioPreventa']);
					//echo $tarjetasWebPreventa."twp <br/><br/>";
					
					$tajetasCad = (($numeroTarCad + ($numeroEfectivoTer1Cad * 0.5)) * $rowL['doublePrecioL']);
					//echo $tajetasCad."tc<br/><br/>";
					$tarjetasCadPreventa = (($numeroEfectivoPREVTCad + ($numeroEfectivoTerPREV22Cad * 0.5)) * $rowL['doublePrecioPreventa']);
					//echo $tarjetasCadPreventa."tcp <br/><br/>";
					
					$tajetasCadTf = (($numeroTarCadTf + ($numeroEfectivoTer1CadTf * 0.5)) * $rowL['doublePrecioL']);
					//echo $tajetasCadTf."TF<br/><br/>";
					$tarjetasCadPreventaTf = (($numeroEfectivoPREVTCadTf + ($numeroEfectivoTerPREV22CadTf * 0.5)) * $rowL['doublePrecioPreventa']);
					//echo $tarjetasCadPreventaTf."TFP <br/><br/>";
					
					
					
					$tarjetasWebTotal = ($tajetasWeb + $tarjetasWebPreventa);
					$tarjetasCadenaTotal = ($tajetasCad + $tarjetasCadPreventa);
					$tarjetasTfTotal = ($tajetasCadTf + $tarjetasCadPreventaTf);
					
					
					$comisionTarjeta = (($comi_tar * ($tarjetasWebTotal))/100);
					$retencionTarjeta = number_format((((($tarjetasWebTotal)/ 1.14)*($ret_renta/100))+((($tarjetasWebTotal) - (($tarjetasWebTotal) / 1.14))*($ret_iva/100))),2);

					$comisionTarjeta1 = (($comi_tar1 * ($tarjetasTfTotal))/100);
					$retencionTarjeta1 = number_format((((($tarjetasTfTotal)/ 1.14)*($ret_renta1/100))+((($tarjetasTfTotal) - (($tarjetasTfTotal) / 1.14))*($ret_iva1/100))),2);
				
					$comisionTarjeta2 = (($comi_tar2 * ($tarjetasCadenaTotal))/100);
					$retencionTarjeta2 = number_format((((($tarjetasCadenaTotal)/ 1.14)*($ret_renta2/100))+((($tarjetasCadenaTotal) - (($tarjetasCadenaTotal) / 1.14))*($ret_iva2/100))),2);
				
				
				// echo '('.$comi_tar.'*('.$totalTar.' + '.$totalEfectivoPREV2.')/100) = '.$comisionTarjeta.' <br>';
				// echo '('.$comi_tar1.'*('.$totalTar.' + '.$totalEfectivoPREV2.')/100) = '.$comisionTarjeta1.' <br>';
				// echo '('.$comi_tar2.'*('.$totalTar.' + '.$totalEfectivoPREV2.')/100) = '.$comisionTarjeta2.' <br>';
				
				
				
				//echo $comisionTarjeta.'<<>>'.$comisionTarjeta1.'<<>>'.$comisionTarjeta2.'<br>';
				$suma1ComisionTarjeta = ($comisionTarjeta + $comisionTarjeta1 + $comisionTarjeta2);
				$sumacomisionTarjeta += $suma1ComisionTarjeta;
				$suma1RetencionTarjeta = ($retencionTarjeta + $retencionTarjeta1 + $retencionTarjeta2);

				$sumaretencionTarjeta += $suma1RetencionTarjeta;
					
					echo number_format(($suma1ComisionTarjeta),2);
				?>
			</td>
			<td style = 'text-align:right;border:1px solid #fff;'>
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
			<td style = 'text-align:right;border:1px solid #fff;'>
				<?php
					$totalAPagar = ($globalCobrado - $suma1ComisionTarjeta - $suma1RetencionTarjeta);
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
					echo $totalBoletos;//."<<>>";
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
					echo $sumaGlobalTickets;//."kkk";
					echo '<input type = "hidden" id = "totalTicketsVendidos" value = "'.$sumaGlobalTickets.'" />';
				?>
			</td>
			<td>
				<?php
					echo $sumaGlobalCogrado;
					echo '<input type = "hidden" id = "sumaGlobalCogrado_reporte" value = "'.$sumaGlobalCogrado.'" /> ';
				?>
			</td>
			<td>
				<?php
					echo $sumacomisionTarjeta;
					echo "<input type = 'hidden' id = 'sumacomisionTarjeta' value = '".$sumacomisionTarjeta."' />";
				?>
			</td>
			<td>
				<?php
					echo $sumaretencionTarjeta;
					echo "<input type = 'hidden' id = 'sumaretencionTarjeta' value = '".$sumaretencionTarjeta."' />";
				?>
			</td>
			
			<td>
				<?php
					echo number_format(($sumatotalAPagar),2);
				?>
			</td>
			
			
	</tr>
		
	</table>