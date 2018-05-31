	<?php 
		session_start();
		include '../conexion.php';
		//require('Conexion/conexion.php');
		$id = $_SESSION['iduser'];
		$hoy = date("Y-m-d");
		$selectConcierto = "SELECT idConcierto , idDet_Dis, strEvento, strImagen, strLugar, timeHora, dateFecha, estadoDet 
							FROM detalle_distribuidor 
							JOIN Concierto 
							ON detalle_distribuidor.conciertoDet = Concierto.idConcierto 
							WHERE idDis_Det = '".$_SESSION['idDis']."'
							and dateFecha >= '".$hoy."'
							";
		//echo $selectConcierto;
		$resultSelectCon = mysql_query($selectConcierto) or die (mysql_error());
		echo '<input type="hidden" id="data" value="1" />';
		
		//echo $_SESSION['iduser'];

	?>
	<style>
		table , tr , td {
			color:#fff;
			vertical-align :middle;
			text-align:center;
		}
		hr{
			-moz-border-bottom-colors: none;
			-moz-border-left-colors: none;
			-moz-border-right-colors: none;
			-moz-border-top-colors: none;
			border-color: #eeeeee -moz-use-text-color -moz-use-text-color;
			border-image: none;
			border-style: solid none none;
			border-width: 1px 0 0;
			margin-bottom: 20px;
			margin-top: 20px;
		}
	</style>
	<table class='table' style='font-size:12px;border: 1px solid #fff;width:100%;'>
		<tr>
			<th colspan = '7' >
				VENTAS CADENA COMERCIAL TODOS LOS CONCIERTOS
			</th>
		</tr>
		<tr>
			<th style='font-size:12px;border: 1px solid #fff'>
				CONCIERTO
			</th>
			<th style='font-size:12px;border: 1px solid #fff'>
				<table width='100%'>
					<tr>
						<td colspan='2' align='center' style = 'border-bottom:1px solid #fff;'>
							VENTAS
						</td>
					</tr>
					<tr>
						<td width='50%' style='font-size:12px;border-right: 1px solid #fff'>
							EFECTIVO
						</td>
						<td width='50%' style='font-size:12px;'>
							TARJETAS
						</td>
					</tr>
				</table>
			</th>
			<th style='font-size:12px;border: 1px solid #fff'>
				TICKETS
			</th>
			<th style='font-size:12px;border: 1px solid #fff'>
				TOTAL
			</th>
			
			<th style='font-size:12px;border: 1px solid #fff'>
				COMISIONES/<br/>RETENCION
			</th>
			<th style='font-size:12px;border: 1px solid #fff'>
				TOTAL A CANCELAR
			</th>
			<!--
			<th style='font-size:12px;border: 1px solid #fff'>
				TICKET CON EMPRESARIO
			</th>-->
		</tr>
	<?php 
		while($rowCon = mysql_fetch_array($resultSelectCon)){
				$sumaNumeroEfectivo = 0;
				$sumaNumeroTar = 0;
				$sumaNumeroEfectivoPrev = 0;
				$sumaNumeroTarPrev = 0;
	?>
		<tr>
			<td align='left' style='font-size:12px;border: 1px solid #fff' class = 'nombreEvento' onclick='enviaConcierto(<?php echo $rowCon['idConcierto']?>)'>
				
				<?php
					echo $rowCon['strEvento'];
				?>
				
			</td>
			<td style='font-size:12px;border: 1px solid #fff'>
				<table width='100%'>
					<tr>
						<td width='50%' style='font-size:12px;border-right: 1px solid #fff'>
							<?php 
								$sqlEf = 'SELECT idLocB
											FROM Boleto 
											WHERE idCon = "'.$rowCon['idConcierto'].'" 
											and rowB = "1"  and colB = "2"
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
											and rowB = "1"  and colB = "2"
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
								
								
								$sqlEfTer = 'SELECT idLocB
											FROM Boleto 
											WHERE idCon = "'.$rowCon['idConcierto'].'" 
											and rowB = "1"  and colB = "2"
											and tercera = 1
											and preventa = 0
											and id_usu_venta = "'.$_SESSION['iduser'].'"
											ORDER BY idLocB DESC 
										';
								//echo $sqlEf;
								$resEfTer = mysql_query($sqlEfTer) or die(mysql_error());
								
								$numEfTer = mysql_num_rows($resEfTer);
								
								$sumValEfTer = number_format((0),2);
								while($rowEfTer = mysql_fetch_array($resEfTer)){
									$idLocBTer = $rowEfTer['idLocB'];
									$sqlLoTer = 'select * from Localidad where idLocalidad = "'.$idLocBTer.'" ';
									//echo $sqlLo1."<br/>";
									$resLoTer = mysql_query($sqlLoTer) or die (mysql_error());
									$rowLoTer = mysql_fetch_array($resLoTer);
									$valorEfectivoTer = ($rowLoTer['doublePrecioL'] * 0.5);
									//echo $valorEfectivo;
									$sumValEfTer += $valorEfectivoTer;
								}
								//echo number_format(($sumValEfTer),2)."<br>";
								
								
								$sqlEfTerPrev = 'SELECT idLocB
											FROM Boleto 
											WHERE idCon = "'.$rowCon['idConcierto'].'" 
											and rowB = "1"  and colB = "2"
											and tercera = 1
											and preventa = 1
											and id_usu_venta = "'.$_SESSION['iduser'].'"
											ORDER BY idLocB DESC 
										';
								//echo $sqlEf;
								$resEfTerPrev = mysql_query($sqlEfTerPrev) or die(mysql_error());
								
								$numEfTerPrev = mysql_num_rows($resEfTerPrev);
								
								$sumValEfTerPrev = number_format((0),2);
								while($rowEfTerPrev = mysql_fetch_array($resEfTerPrev)){
									$idLocBTerPrev = $rowEfTerPrev['idLocB'];
									$sqlLoTerPrev = 'select * from Localidad where idLocalidad = "'.$idLocBTerPrev.'" ';
									//echo $sqlLo1."<br/>";
									$resLoTerPrev = mysql_query($sqlLoTerPrev) or die (mysql_error());
									$rowLoTerPrev = mysql_fetch_array($resLoTerPrev);
									$valorEfectivoTerPrev = ($rowLoTerPrev['doublePrecioPreventa'] * 0.5);
									//echo $valorEfectivo;
									$sumValEfTerPrev += $valorEfectivoTerPrev;
								}
								//echo number_format(($sumValEfTerPrev),2)."<br>";
								
								
								$sumaEfectivo = ($sumValEf + $sumValEfPrev + $sumValEfTer + $sumValEfTerPrev);
								
								echo number_format(($sumaEfectivo),2);
								
								$sumaCantEfectivo = ($numEf + $numEfPrev + $numEfTer + $numEfTerPrev);
							?>
						</td>
						<td width='50%'  style='font-size:12px;'>
							<?php 
								$sqlTar = 'SELECT idLocB
											FROM Boleto 
											WHERE idCon = "'.$rowCon['idConcierto'].'" 
											and rowB = "2"  and colB = "2"
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
								
								
								$sqlTarTer = 'SELECT idLocB
											FROM Boleto 
											WHERE idCon = "'.$rowCon['idConcierto'].'" 
											and rowB = "2"  and colB = "2"
											and tercera = 1
											and preventa = 0
											and id_usu_venta = "'.$_SESSION['iduser'].'"
											ORDER BY idLocB DESC 
										';
								//echo $sqlTarTer."<br><br/>";
								$resTarTer = mysql_query($sqlTarTer) or die(mysql_error());
								
								$numTarTer = mysql_num_rows($resTarTer);
								
								$sumValTarTer = number_format((0),2);
								while($rowTarTer = mysql_fetch_array($resTarTer)){
									$idLocBTarTer = $rowTarTer['idLocB'];
									//echo $idLocBTarTer."<br>";
									$sqlLoTarTer = 'select * from Localidad where idLocalidad = "'.$rowTarTer['idLocB'].'" ';
									//echo $sqlLo1."<br/>";
									$resLoTarTer = mysql_query($sqlLoTarTer) or die (mysql_error());
									$rowLoTarTer = mysql_fetch_array($resLoTarTer);
									$valorTarTer = ($rowLoTarTer['doublePrecioL']*0.5);
									//echo $valorTarTer;
									$sumValTarTer += $valorTarTer;
								}
								//echo number_format(($sumValTarTer),2)."<br>";
								
								
									$sqlTarPrev = 'SELECT idLocB
											FROM Boleto 
											WHERE idCon = "'.$rowCon['idConcierto'].'" 
											and rowB = "2"  and colB = "2"
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
								
								
								$sqlTarPrevTer = 'SELECT idLocB
											FROM Boleto 
											WHERE idCon = "'.$rowCon['idConcierto'].'" 
											and rowB = "2"  and colB = "2"
											and tercera = 1
											and preventa = 1
											and id_usu_venta = "'.$_SESSION['iduser'].'"
											ORDER BY idLocB DESC 
										';
								//echo $sqlTarPrevTer."<br><br/>";
								$resTarPrevTer = mysql_query($sqlTarPrevTer) or die(mysql_error());
								
								$numTarPrevTer = mysql_num_rows($resTarPrevTer);
								
								$sumValTarPrevTer = number_format((0),2);
								while($rowTarPrevTer = mysql_fetch_array($resTarPrevTer)){
									$idLo = $rowTarPrevTer['idLocB'];
									//echo $idLo."<<>><br>";
									$sqlLoTarPrevTer = 'select * from Localidad where idLocalidad = "'.$idLo.'" ';
									//echo $sqlLoTarPrevTer."<br/>";
									$resLo = mysql_query($sqlLoTarPrevTer) or die (mysql_error());
									$rowLo = mysql_fetch_array($resLo);
									$valorTPT = ($rowLo['doublePrecioPreventa']* 0.5);
									//echo $valorTPT.">><<";
									$sumValTarPrevTer += $valorTPT;
								}
								//echo number_format(($sumValTarPrevTer),2)."<br>";
								
								
								$sumaTarjeta = ($sumValTar + $sumValTarTer + $sumValTarPrev + $sumValTarPrevTer);
								echo number_format(($sumaTarjeta),2);
								
								$sumaCantTarjeta = ($numTar + $numTarTer + $numTarPrev + $numTarPrevTer);
							?>
						</td>
					</tr>
				</table>
			</td>
			<td style='font-size:12px;border: 1px solid #fff'>
				<?php 
					$globalNumeroEfectivo = ($sumaCantEfectivo + $sumaCantTarjeta);
					echo $globalNumeroEfectivo;//."ee";
				?>
			</td>
			<td style='font-size:12px;border: 1px solid #fff'>
				<?php 
					$globalValorEfectivo = ($sumaEfectivo + $sumaTarjeta);
					echo number_format(($globalValorEfectivo),2);//."gfg";
				?>
			</td>
			<td style='font-size:12px;border: 1px solid #fff'>
				<?php
					$sqlComWeb ='SELECT * FROM `comi_ret` WHERE `id_con` =  "'.$rowCon['idConcierto'].'" and detalle = "cadena comercial" ';
					$resComWeb = mysql_query($sqlComWeb) or die (mysql_error());
					$rowComWeb = mysql_fetch_array($resComWeb);
					$comi_tar = $rowComWeb['comi_tar'];
					$ret_renta = $rowComWeb['ret_renta'];
					$ret_iva = $rowComWeb['ret_iva'];
					
					$recaudacionTarjetas = ($sumaTarjeta);
					
					$comisionTarjeta = (($recaudacionTarjetas * $comi_tar)/100);
					
					$retencionTarjeta2 = number_format(((($recaudacionTarjetas / 1.14)*($ret_renta/100))+((($recaudacionTarjetas) - (($recaudacionTarjetas) / 1.14))*($ret_iva/100))),2);
					
					
					$comisionesRetencionesTarjeta = ($comisionTarjeta + $retencionTarjeta2);
					//echo "(".$recaudacionTarjetas."*".$ret_renta."/100)+(".$recaudacionTarjetas."-".$recaudacionTarjetas."/ 1.14) * (".$ret_iva." /100)<br/>";
					
					echo number_format(($comisionesRetencionesTarjeta),2);
					echo "<input type = 'hidden' class = 'comisionesRetencionesTarjetaCadena_".$rowCon['idConcierto']."' value = '".number_format(($comisionesRetencionesTarjeta),2)."' />";
				?>
			</td>
			<td style='font-size:12px;border: 1px solid #fff'>
				<?php
					$globalAPagar = number_format(($globalValorEfectivo-$comisionesRetencionesTarjeta),2);
					echo $globalAPagar;
				?>
			</td>
			<!--
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
	</table>