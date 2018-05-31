  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
<?php
	ini_set('memory_limit', '512M');
	include '../../conexion.php';
	$idConcierto = $_REQUEST['idConcierto'];
	echo '<input type = "hidden" id = "id_concierto" value = "'.$idConcierto.'" />';
	$sqlImp = 'select * from impuestos where id_con = "'.$idConcierto.'" ';
	$resImp = mysql_query($sqlImp) or die (mysql_error());
	$rowImp = mysql_fetch_array($resImp);
	$valorados = $rowImp['valorados'];
	$sin_permisos = $rowImp['sin_permisos'];
	$cortesias = $rowImp['cortesias'];
	$sayse = $rowImp['sayse'];
	$sri = $rowImp['sri'];
	$municipio = $rowImp['municipio'];
	
	
	$sqlC = 'SELECT * FROM Concierto where idConcierto = "'.$idConcierto.'" ';
	$resC = mysql_query($sqlC) or die (mysql_error());
	$rowC = mysql_fetch_array($resC);
	
	$sql = 'SELECT * FROM Boleto WHERE idCon = "'.$idConcierto.'" group by idLocB ORDER BY idLocB DESC ';
			
			
	$sqlComWeb ='SELECT * FROM `comi_ret` WHERE `id_con` =  "'.$idConcierto.'" and detalle = "PAGINA WEB" ';
	$resComWeb = mysql_query($sqlComWeb) or die (mysql_error());
	$rowComWeb = mysql_fetch_array($resComWeb);
	$comi_tar = $rowComWeb['comi_tar'];
	$ret_renta = $rowComWeb['ret_renta'];
	$ret_iva = $rowComWeb['ret_iva'];
	
	
	
	
	$sqlComWeb1 ='SELECT * FROM `comi_ret` WHERE `id_con` =  "'.$idConcierto.'" and detalle = "PUNTOS TICKET FACIL" ';
	$resComWeb1 = mysql_query($sqlComWeb1) or die (mysql_error());
	$rowComWeb1 = mysql_fetch_array($resComWeb1);
	$comi_tar1 = $rowComWeb1['comi_tar'];
	$ret_renta1 = $rowComWeb1['ret_renta'];
	$ret_iva1 = $rowComWeb1['ret_iva'];
	
	
	
	
	
	$sqlComWeb2 ='SELECT * FROM `comi_ret` WHERE `id_con` =  "'.$idConcierto.'" and detalle = "cadena comercial" ';
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
	<center><img src = 'imagenes/load22.gif' id = 'loaderGif'/></center>
	<center>
		<input type="button" onclick="tableToExcel('contieneConciertosSocio', 'Reporte General ')" class="botonimagen" title='Descargar Reporte Excel' value=''/>
	</center>
	<div id = 'contieneConciertosSocio' >
	<div id = 'taquilla_emp1'></div>
	<table class = 'table' >
		<tr>
			<td colspan = '2' style = 'background-color: #171A1B'>
				VENTAS TICKET FACIL VS EMPREARIO
			</td>
		</tr>
		<tr>
			<td>
				<table class = 'table' id = 'ventas_brutas' style = 'background-color: #00ADEF' >
					<tr style = 'font-size:10px;color:#fff;' >
						<td>LOCALIDAD</td>
						<td>PRECIO</td>
						<td>TICKETS TF TOTAL</td>
						<td>VENTAS TF</td>
					</tr>
				</table>
			</td>
			<td>
				<table class = 'table' style ='background-color: #00ADEF;' id = 'tabla_empresario' >
					<tr style = 'font-size:10px;color:#fff;' >
						<td>LOCALIDAD</td>
						<td>PRECIO</td>
						<td>TICKETS EMP NOR</td>
						<td>TICKETS EMP 3era</td>
						<td>TICKETS EMP NIÑOS</td>
						<td>TIICKETS EMPRESARIO TOTAL</td>
						<td>TICKETAS TOTALES</td>
						
					</tr>
				</table>
			</td>
		</tr>
	</table>
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
	<tr class = 'tr_cadalocalidad'>
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
								echo $numeroEfectivo;//."ef";
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
								echo $numeroEfectivoTer;//."ef ter";
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
								
								
								
								$sqlTarCad = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "2"
										and tercera = 0
										and preventa = 0
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								$resTarCad = mysql_query($sqlTarCad) or die (mysql_error());
								$rowTarCad = mysql_fetch_array($resTarCad);
								$numeroTarCad = $rowTarCad['idBol'];
								
								
								$sqlTarCadTf = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "3"
										and tercera = 0
										and preventa = 0
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEf;
								$resTarCadTf = mysql_query($sqlTarCadTf) or die (mysql_error());
								$rowTarCadTf = mysql_fetch_array($resTarCadTf);
								$numeroTarCadTf = $rowTarCadTf['idBol'];
								//echo $numeroTarCadTf."tar TF <br><br>";
								
								
								$tajetasNormales = ($numeroTar + $numeroTarCad + $numeroTarCadTf);
								echo $tajetasNormales;//."tar nor";//."<br><br>";
								$sumaNumeroTar += $tajetasNormales;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								
								$sqlEfT1 = 'SELECT count(idBoleto) as idBol
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
								
								$sqlEfT1Cad = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "2"
										and tercera = 1
										and preventa = 0
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								$resEFT1Cad = mysql_query($sqlEfT1Cad) or die (mysql_error());
								$rowEFT1Cad = mysql_fetch_array($resEFT1Cad);
								$numeroEfectivoTer1Cad = $rowEFT1Cad['idBol'];
								
								$sqlEfT1CadTf = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "3"
										and tercera = 1
										and preventa = 0
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								$resEFT1CadTf = mysql_query($sqlEfT1CadTf) or die (mysql_error());
								$rowEFT1CadTf = mysql_fetch_array($resEFT1CadTf);
								$numeroEfectivoTer1CadTf = $rowEFT1CadTf['idBol'];
								$tajetasNormalesTercera = ($numeroEfectivoTer1 + $numeroEfectivoTer1Cad + $numeroEfectivoTer1CadTf);
								echo $tajetasNormalesTercera;//."tar ter";//."<br><br>";
								$totalnumeroEfectivoTer1 += $tajetasNormalesTercera;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								
								$totalTar = (($tajetasNormales + ($tajetasNormalesTercera * 0.5))*$rowL['doublePrecioL']);
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
								$resEFTPREV = mysql_query($sqlEfTPREV) or die (mysql_error());
								$rowEFTPREV = mysql_fetch_array($resEFTPREV);
								$numeroEfectivoTerPREV = $rowEFTPREV['idBol'];
								echo $numeroEfectivoTerPREV;
								$totaltotalnumeroEfectivoTerPREV += $numeroEfectivoTerPREV;
							?>
						</td>
						<td width='33.33%'>
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
								
								
								$sqlEfPREVTCad = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "2"
										and tercera = 0
										and preventa = 1
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfPREVT;
								$resEFPREVTCad = mysql_query($sqlEfPREVTCad) or die (mysql_error());
								$rowEFPREVTCad = mysql_fetch_array($resEFPREVTCad);
								$numeroEfectivoPREVTCad = $rowEFPREVTCad['idBol'];
								//echo $numeroEfectivoPREVTCad."tar prev Cad <br/><br/>";
								
								
								$sqlEfPREVTCadTf = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "3"
										and tercera = 0
										and preventa = 1
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfPREVT;
								$resEFPREVTCadTf = mysql_query($sqlEfPREVTCadTf) or die (mysql_error());
								$rowEFPREVTCadTf = mysql_fetch_array($resEFPREVTCadTf);
								$numeroEfectivoPREVTCadTf = $rowEFPREVTCadTf['idBol'];
								//echo $numeroEfectivoPREVTCadTf."tar prev TF <br/><br/>";
								
								$tarjetasNormalesPrev = ($numeroEfectivoPREVT + $numeroEfectivoPREVTCad + $numeroEfectivoPREVTCadTf);
								echo $tarjetasNormalesPrev;//."tar prev";//."<br/><br/>";
								$sumaNumeroEfectivoPREVT += $tarjetasNormalesPrev;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								$sqlEfTPREV = 'SELECT count(idBoleto) as idBol
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
								
								
								$sqlEfTPREVCad = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "2"
										and tercera = 1
										and preventa = 1
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfTPREV;
								$resEFTPREVCad = mysql_query($sqlEfTPREVCad) or die (mysql_error());
								$rowEFTPREVCad = mysql_fetch_array($resEFTPREVCad);
								$numeroEfectivoTerPREV22Cad = $rowEFTPREVCad['idBol'];
								//echo $numeroEfectivoTerPREV22Cad."tar prev ter Cad <br/><br/>";
								
								
								$sqlEfTPREVCadTf = 'SELECT count(idBoleto) as idBol
										FROM Boleto 
										WHERE idCon = "'.$idConcierto.'" 
										and rowB = "2"
										and colB = "3"
										and tercera = 1
										and preventa = 1
										and idLocB = "'.$row['idLocB'].'"
										ORDER BY idLocB DESC 
										';
								//echo $sqlEfTPREV;
								$resEFTPREVCadTf = mysql_query($sqlEfTPREVCadTf) or die (mysql_error());
								$rowEFTPREVCadTf = mysql_fetch_array($resEFTPREVCadTf);
								$numeroEfectivoTerPREV22CadTf = $rowEFTPREVCadTf['idBol'];
								//echo $numeroEfectivoTerPREV22CadTf."tar prev ter TF <br/><br/>";
								
								
								$tarjetasNormalesPrevTer = ($numeroEfectivoTerPREV22 + $numeroEfectivoTerPREV22Cad + $numeroEfectivoTerPREV22CadTf);
								echo $tarjetasNormalesPrevTer;//."tar prev ter";//."<br/><br/>";
								$totaltotalnumeroEfectivoTerPREVTERCERA += $tarjetasNormalesPrevTer;
							?>
						</td>
						<td width = '33.33%'>
							<?php 
								$totalEfectivoPREV2 = (($tarjetasNormalesPrev + ($tarjetasNormalesPrevTer * 0.5))*$rowL['doublePrecioPreventa']);
								echo $totalEfectivoPREV2;//."aa";
								$sumaTotalEfectivoTAREFEPREV += $totalEfectivoPREV2;
							?>
						</td>
					</tr>
				</table>
			</td>
			<td  >
				<?php
					
					$globalTickets = ($numeroEfectivo + $numeroEfectivoTer + $tajetasNormales + $tajetasNormalesTercera + $numeroEfectivoPREV + $numeroEfectivoTerPREV + $tarjetasNormalesPrev + $tarjetasNormalesPrevTer);
					echo $globalTickets;//."hhh";
					$sumaGlobalTickets += $globalTickets;
					
				?>
			</td>
			<td >
				<?php
					$globalCobrado = ($totalEfectivo + $totalTar + $totalEfectivoPREV + $totalEfectivoPREV2);
					echo $globalCobrado;//."gc";
					$sumaGlobalCogrado += $globalCobrado;
					
				?>
			</td>
			<td nom_loc = '<?php echo $rowL['strDescripcionL'];?>' global_tickets ='<?php echo $globalTickets;?>' global_cobrado = '<?php echo $globalCobrado;?>' >
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
		<tr>
			<td colspan = '9' align = 'right' >
				
			</td>
			<td colspan = '2'>
				<div style = 'padding:5px 10px;' id = 'verDet' onclick = 'verDetalleVentas()' >Ver Detalle Ventas</div>
			</td>
		</tr>
	</table>
	<style>
		#verDet:hover{
			text-decoration:underline;
		}
	</style>
	<script>
		function verDetalleVentas(){
			$( "#contieneIframes" ).toggle("blind");
		}
	</script>
	<div id = 'contieneIframes' style = 'display:none;' >
		<iframe id = 'iframe1' src = 'http://ticketfacil.ec/ticket2/Estadisticas/ajax/localidadConciertoSocio.php?idConcierto=<?php echo $idConcierto?>' class ='ifr1' style = 'position:relative;left: -30px;width:995px;height: 470px' frameborder = '0' ></iframe>
		<iframe id = 'iframe2' src = 'http://ticketfacil.ec/ticket2/Estadisticas/ajax/cadenaTFSocio.php?idConcierto=<?php echo $idConcierto?>' class ='ifr2' style = 'position:relative;left: -25px;width:985px;height: 200px' frameborder = '0'></iframe>
	</div>
	<br/><br/>
	<table class = 'table' >
		<tr>
			<td colspan = '2' align = 'center' style = 'background-color: #171A1B'>
				DESGLOSE DE VENTAS
			</td>
		</tr>
		<tr>
			<td>
				Forma de Pago
			</td>
			<td>
				Venta
			</td>
		</tr>
		<tr>
			<td>
				Efectivo
			</td>
			<td>
				<div id = 'sumaEfectivos' >0</div>
			</td>
		</tr>
		<tr>
			<td>
				Tarjeta Web
			</td>
			<td>
				<div id = 'sumaTarjetasWeb' >0</div>
			</td>
		</tr>
		<tr>
			<td>
				Tarjeta Cadena Comercial
			</td>
			<td>
				<div id = 'sumaTarjetasCadCom' >0</div>
			</td>
		</tr>
		<tr>
			<td>
				Tarjeta Cadena Ticket Facil
			</td>
			<td>
				<div id = 'sumaTarjetasCadTick' ></div>
			</td>
		</tr>
		
		<tr>
			<td>
				Ventas Globales
			</td>
			<td>
				<div class = 'ventasGlobales' ></div>
			</td>
		</tr>
		<tr>
			<td>
				Comisiones Retenciones
			</td>
			<td>
				<div class = 'sumaComiRet' ></div>
			</td>
		</tr>
		
		<tr>
			<td>
				Total Ventas
			</td>
			<td>
				<div id = 'ventasMenosRet' ></div>
			</td>
		</tr>
	</table>
	
	<br/><br/>
	<table class = 'table' >
		<tr>
			<td colspan = '2' align = 'center' style = 'background-color: #171A1B'>
				CORTESIAS
			</td>
		</tr>
		<tr>
			<td>
				Localidad
			</td>
			<td>
				Tickets
			</td>
		</tr>
		<?php
			$sqlLo = 'select * from Localidad where idConc = "'.$idConcierto.'" ';
			$resLo = mysql_query($sqlLo) or die (mysql_error());
			$num_bol = 0;
			while($rowLo = mysql_fetch_array($resLo)){
				$sqlCo = 'select * from cortesias where id_loc = "'.$rowLo['idLocalidad'].'" and id_con = "'.$idConcierto.'" and tipo = 1';
				//echo $sqlCo;
				$resCo = mysql_query($sqlCo) or die (mysql_error());
				if(mysql_num_rows($resCo) == '' || mysql_num_rows($resCo) == null){
					$num_bol = 0;
				}else{
					$rowCo = mysql_fetch_array($resCo);
					$num_bol = $rowCo['num_bol'];
				}
				
		?>
			<tr>
				<td>
					<?php echo $rowLo['strDescripcionL'];?>
				</td>
				<td>
					<?php echo $num_bol;?>
				</td>
			</tr>
		<?php
				$sumaCortesias += $num_bol;
			}
		?>
		<tr>
			<td>
				Total
			</td>
			<td>
				<?php echo $sumaCortesias;?>
			</td>
		</tr>
	</table>
	
	<table class = 'table' >
		<tr>
			<td colspan = '4' style = 'background-color: #171A1B'>
				COSTO POR SERVICIO			
			</td>
		</tr>
		<tr>
			<td>
				Descripción 
			</td>
			<td>
				Cantidad
			</td>
			<td>
				Precio
			</td>
			<td>
				Total
			</td>
		</tr>
		<tr>
			<td>
				Tickets Impresos 
			</td>
			<td>
				3207
			</td>
			<td>
				0.35
			</td>
			<td>
				1122.45
			</td>
		</tr>
		<tr>
			<td>
				Tickets Valorados 
			</td>
			<td>
				<?php 
					
					$sqlCor11 = 'select count(idBoleto) as num_bol from Boleto where idCon = "'.$idConcierto.'" and nombreHISB = "empresario_vendido" ';
					$resCor11 = mysql_query($sqlCor11) or die (mysql_error());
					$rowCor1 = mysql_fetch_array($resCor11);
					$num_bol1 = 658;//($rowCor1['num_bol']);
					
					echo ($sumaGlobalTickets + $num_bol1);
				?>
			</td>
			<td>
				<?php echo $valorados;?>
			</td>
			<td>
				<?php echo (($sumaGlobalTickets + $num_bol1) * $valorados);?>
			</td>
		</tr>
		<tr>
			<td>
				Tickets Impresos No Vendidos
			</td>
			<td>
				1292
			</td>
			<td>
				0,35
			</td>
			<td>
				452.2
			</td>
		</tr>
		<tr>
			<td>
				Cortesias
			</td>
			<td>
				<?php echo $sumaCortesias;?>
			</td>
			<td>
				<?php echo $cortesias;?>
			</td>
			<td>
				<?php echo ($sumaCortesias * $cortesias);?>
			</td>
		</tr>
		
		
		<tr>
			<td>
				Total
			</td>
			<td>
				<?php echo ($sumaCortesias + ($sumaGlobalTickets + $num_bol1)) + 1292;?>
			</td>
			<td>
				
			</td>
			<td>
				<?php echo ((($sumaGlobalTickets + $num_bol1) * $valorados) + ($sumaCortesias * $cortesias)) + 452.2;?>
			</td>
		</tr>
	</table>
	
	<table class = 'table' >
		<tr>
			<td colspan = '2' style = 'background-color: #171A1B'>
				FACTURA TICKET FACIL
			</td>
		</tr>
		<tr>
			<td>
				Costo por Servicio
			</td>
			<td>
				<?php 
					$costoServicio =  ((($sumaGlobalTickets + $num_bol1) * $valorados) + ($sumaCortesias * $cortesias)) + 452.2;
					echo $costoServicio;
				?>
			</td>
		</tr>
		<tr>
			<td>
				Iva
			</td>
			<td>
				<?php 
					$ivaServicio =  ((((($sumaGlobalTickets + $num_bol1) * $valorados) + ($sumaCortesias * $cortesias)) + 452.2) * 0.14);
					echo number_format(($ivaServicio),2);
				?>
			</td>
		</tr>
		<tr>
			<td>
				Total
			</td>
			<td>
				<?php
					$costoMenosIva = ($costoServicio + $ivaServicio);
					echo number_format(($costoMenosIva),2);
				?>
			</td>
		</tr>
	</table>
	
	
	<table class = 'table' >
		<tr>
			<td colspan = '7' style = 'background-color: #171A1B'>
				AFNA
			</td>
		</tr>
		<tr>
			<td style="text-align: left">
				Localidad
			</td>
			<td>
				Tickets
			</td>
			<td>
				Precio
			</td>
			<td>
				Impuesto
			</td>
			<td>
				Subtotal
			</td>
			<td>
				Iva
			</td>
			<td>
				Total
			</td>
		</tr>
	<?php
		$sqlLoc = 'select * from Localidad where idConc = "'.$idConcierto.'" order by idLocalidad DESC';
		$resLoc = mysql_query($sqlLoc) or die (mysql_error());
		$num_bol = 0;
		while($rowLoc = mysql_fetch_array($resLoc)){
			if($rowLoc['idLocalidad'] == 100){
				$rowLoNor = 260;
			}elseif($rowLoc['idLocalidad'] == 99){
				$rowLoNor = 466;
			}else{
				$rowLoNor = 931;
			}
			
	?>
		<tr>
			<td style="text-align: left">
				<?php
					echo $rowLoc['strDescripcionL'];
				?>
			</td>
			<td>
				<?php
					$sqlLoNor = ' 	SELECT count(idBoleto) as idBol
									FROM Boleto 
									WHERE idCon = "'.$idConcierto.'" 
									and idLocB = "'.$rowLoc['idLocalidad'].'"
									and tercera = 0
									and nombreHISB <> "empresario" and nombreHISB <> "cortesia" 
									ORDER BY idLocB DESC  
								';
					//echo $sqlLoNor."<br/>";
					$resLoNor = mysql_query($sqlLoNor) or die(mysql_error());
					//$rowLoNor = mysql_fetch_array($resLoNor);
					
					echo $rowLoNor;
					$sumaBoletos += $rowLoNor;
				?>
			</td>
			<td>
				<?php 
					echo $rowLoc['doublePrecioL'];
					$sumaPrecioPorBoleto += ($rowLoNor * $rowLoc['doublePrecioL']);
					
				?>
			</td>
			<td>
				<?php 
					$impuesto = ($rowLoc['doublePrecioL'] * $sayse);
					echo $impuesto;
					$sumaImpuestos += $impuesto;
				?>
			</td>
			<td>
				<?php
					$subtotal = ($impuesto * $rowLoNor);
					echo $subtotal;
					$sumaSubTotal += $subtotal;
				?>
			</td>
			<td>
				<?php
					$ivaSayse = ($subtotal * 0.14);
					echo $ivaSayse;
					$sumaIvaSayse += $ivaSayse;
				?>
			</td>
			<td>
				<?php
					$totalSayse = ($subtotal + $ivaSayse);
					echo $totalSayse;
					$sumaTotalSayse += $totalSayse;
				?>
			</td>
		</tr>
	<?php
		}
	?>
	
	<?php
		$sqlLoc2 = 'select * from Localidad where idConc = "'.$idConcierto.'" order by idLocalidad DESC';
		$resLoc2 = mysql_query($sqlLoc2) or die (mysql_error());
		while($rowLoc2 = mysql_fetch_array($resLoc2)){
			
			if($rowLoc2['idLocalidad'] == 100){
				$rowLoTer = 14;
			}elseif($rowLoc2['idLocalidad'] == 99){
				$rowLoTer = 58;
			}else{
				$rowLoTer = 14;
			}
			
	?>
		<tr>
			<td style="text-align: left" >
				<?php
					echo $rowLoc2['strDescripcionL']."  [3ERA EDAD / DESC ]";
				?>
			</td>
			<td>
				<?php
					$sqlLoTer = ' 	SELECT count(idBoleto) as idBol
									FROM Boleto 
									WHERE idCon = "'.$idConcierto.'" 
									and idLocB = "'.$rowLoc2['idLocalidad'].'"
									and tercera = 1
									and nombreHISB <> "empresario" and nombreHISB <> "cortesia"
									ORDER BY idLocB DESC  
								';
					//echo $sqlLoTer;
					$resLoTer = mysql_query($sqlLoTer) or die(mysql_error());
					//$rowLoTer = mysql_fetch_array($resLoTer);
					
					echo $rowLoTer;
					$sumaBoletosTer += $rowLoTer['idBol'];
				?>
			</td>
			<td>
				<?php 
					echo ($rowLoc2['doublePrecioL'] * 0.5);
					$sumaPrecioPorBoletoTer += ($rowLoTer * ($rowLoc2['doublePrecioL'] * 0.5));
				?>
			</td>
			<td>
				<?php 
					$impuestoTer = (($rowLoc2['doublePrecioL'] * 0.5) * $sayse); 
					echo $impuestoTer;
					$sumaImpuestosTer += $impuestoTer;
				?>
			</td>
			<td>
				<?php
					$subtotalTer = ($impuestoTer * $rowLoTer);
					echo $subtotalTer;
					$sumaSubTotalTer += $subtotalTer;
				?>
			</td>
			<td>
				<?php
					$ivaSayseTer = ($subtotalTer * 0.14);
					echo $ivaSayseTer;
					$sumaIvaSayseTer += $ivaSayseTer;
				?>
			</td>
			<td>
				<?php
					$totalSayseYTer = ($subtotalTer + $ivaSayseTer);
					echo $totalSayseYTer;
					$sumaTotalSayseTer += $totalSayseYTer;
				?>
			</td>
		</tr>
	<?php
		}
	?>
	
	
		<tr>
			<td style="text-align: left">
				Total (+ 172 niños) + 524 cortesias
			</td>
			<td>
				<?php 
					echo 2439;
				?>
			</td>
			<td>
				<?php
					//echo number_format(($sumaPrecioPorBoleto+$sumaPrecioPorBoletoPre+$sumaPrecioPorBoletoTer+$sumaPrecioPorBoletoTerPre),2);
				?>
			</td>
			<td>
				<?php
					echo number_format(($sumaImpuestos+$sumaImpuestosPre+$sumaImpuestosTer+$sumaImpuestosTerPre),2);
				?>
			</td>
			<td>
				<?php
					echo number_format(($sumaSubTotal+$sumaSubTotalPre+$sumaSubTotalTer+$sumaSubTotalTerPre),2);
				?>
			</td>
			<td>
				<?php
					echo number_format(($sumaIvaSayse+$sumaIvaSaysePre+$sumaIvaSayseTer+$sumaIvaSayseTerPre),2);
				?>
			</td>
			<td>
				<?php
					echo number_format(($sumaTotalSayse+$sumaTotalSaysePre+$sumaTotalSayseTer+$sumaTotalSayseTerPre),2);
				?>
			</td>
		</tr>
	</table>
	
	<iframe  id = 'iframeSri' src = 'http://ticketfacil.ec/ticket2/Estadisticas/ajax/sri.php?idConcierto=<?php echo $idConcierto?>' style="position: relative; left: -10px;width:955px;height:400px;background-color:#00ADEF;" frameborder="0" ></iframe>
	<br/><br/>
	<iframe  id = 'iframeMuni' src = 'http://ticketfacil.ec/ticket2/Estadisticas/ajax/minicipio.php?idConcierto=<?php echo $idConcierto?>' style="position: relative; left: -10px;width:955px;height:400px;background-color:#00ADEF;display:none;" frameborder="0" ></iframe>
	
	<table class = 'table' style = 'color:#fff;'  >
		<tr>
			<th colspan = '9' style = 'background-color:#171A1B;color:#fff;' >
				MUNICIPIO
			</th>
		</tr>
		<tr>
			<th>Localidad</th>
			<th>Autorizados</th>
			<th>No Vendidos</th>
			<th>Vendidos</th>
			<th>Ingresados</th>
			<th>Valor</th>
			<th>Total</th>
			<th>Impuesto</th>
			<th>Total</th>
			
		</tr>
		<tr>
			<td>
				Palco
			</td>
			<td>
				400
			</td>
			<td>
				140
			</td>
			<td>
				260
			</td>
			<td>
				260
			</td>
			<td>
				15
			</td>
			<td>
				3900
			</td>
			<td>
				0.75
			</td>
			<td>
				195
			</td>
		</tr>
		<tr>
			<td>
				Tribuna Oriental						
			</td>
			<td>
				2400
			</td>
			<td>
				1934
			</td>
			<td>
				466
			</td>
			<td>
				466
			</td>
			<td>
				12
			</td>
			<td>
				5592
			</td>
			<td>
				0.6
			</td>
			<td>
				279,6
			</td>
		</tr>
		<tr>
			<td>
				Tribuna Occidental										
			</td>
			<td>
				3500
			</td>
			<td>
				2569
			</td>
			<td>
				931
			</td>
			<td>
				931
			</td>
			<td>
				12
			</td>
			<td>
				11172
			</td>
			<td>
				0,6
			</td>
			<td>
				558,6
			</td>
		</tr>
		<tr>
			<td>
				Palco Tercera													
			</td>
			<td>
				80
			</td>
			<td>
				66
			</td>
			<td>
				14
			</td>
			<td>
				14
			</td>
			<td>
				7,5
			</td>
			<td>
				105
			</td>
			<td>
				0.375
			</td>
			<td>
				5,25
			</td>
		</tr>
		<tr>
			<td>
				Tribuna Oriental Tercera									
			</td>
			<td>
				50
			</td>
			<td>
				-8
			</td>
			<td>
				58
			</td>
			<td>
				58
			</td>
			<td>
				6
			</td>
			<td>
				348
			</td>
			<td>
				0,3
			</td>
			<td>
				17,4
			</td>
		</tr>
		<tr>
			<td>
				Tribuna Occidental Tercera			
			</td>
			<td>
				50
			</td>
			<td>
				36
			</td>
			<td>
				14
			</td>
			<td>
				14
			</td>
			<td>
				6
			</td>
			<td>
				84
			</td>
			<td>
				0,3
			</td>
			<td>
				4,2
			</td>
		</tr>
		<tr>
			<td>
				Cortesias
			</td>
			<td>
				524
			</td>
			<td>
				0
			</td>
			<td>
				524
			</td>
			<td>
				524
			</td>
			<td>
				0
			</td>
			<td>
				0
			</td>
			<td>
				0
			</td>
			<td>
				0
			</td>
		</tr>
		<tr>
			<td>
				Total (+ 172 niños) 
			</td>
			<td>
				7304
			</td>
			<td>
				4865
			</td>
			<td>
				2439
			</td>
			<td>
				2439
			</td>
			<td>
				0
			</td>
			<td>
				21201
			</td>
			<td>
				
			</td>
			<td>
				1060,05
			</td>
		</tr>
	</table>
	<table class = 'table' >
		<tr>
			<td colspan = '7' style = 'background-color: #171A1B'>
				RESUMEN
			</td>
		</tr>
		<!--
		<tr>
			<td style="text-align: left">
				VALOR TICKETS ENTREGADOS EMPRESARIO
			</td>
			<td>
				<?php
					$sqlCor = '	SELECT c.*  , l.doublePrecioL as precio_boleto
								FROM cortesias as c , Localidad as l
								WHERE c.id_con = "'.$idConcierto.'" 
								and c.id_loc = idLocalidad
								and c.tipo = 2
								ORDER BY `id` DESC ';
					//echo $sqlCor;
					$resCor = mysql_query($sqlCor) or die (mysql_error());
					while($rowCor = mysql_fetch_array($resCor)){
						$numbol_devueltos += $rowCor['numbol_devueltos'];
						$numBolEmp += $rowCor['num_bol'];
						$boletoXPrecio = (($rowCor['num_bol'])  * $rowCor['precio_boleto']);//- $rowCor['numbol_devueltos']
						//echo $rowCor['num_bol']."<<>>".$rowCor['precio_boleto'].">> = <<".$boletoXPrecio."<br/>";
						$sumaBoletoXPrecio += $boletoXPrecio;
					}
					echo number_format(($sumaBoletoXPrecio),2);
					echo "<input type = 'hidden' id = 'valorTicketEmpresarioEntregado'  value = '".number_format(($sumaBoletoXPrecio),2)."' />";
				?>
			</td>
		</tr>
		<tr>
			<td style="text-align: left">
				TICKET EMPREARIO VENDIDO
			</td>
			<td>
				<?php
					$sumaPrecioBEV = number_format ((0),2);
					$sqlBEV = '	SELECT (b.idBoleto) as idBol , l.doublePrecioL
								FROM Boleto as b, Localidad as l
								WHERE idCon = "'.$idConcierto.'" 
								and nombreHISB = "empresario_vendido" 	
								and b.idLocB = l.idLocalidad
							';
					$resBEV = mysql_query($sqlBEV) or die (mysql_error());
					while($rowBEV = mysql_fetch_array($resBEV)){
						$numBEV = $rowBEV['idBol'];
						$doublePrecioL = $rowBEV['doublePrecioL'];
						//echo $numBEV."<<>>".$doublePrecioL."<br/>";
						$sumaPrecioBEV += $doublePrecioL;
					}
					echo $sumaPrecioBEV;
					echo "<input type = 'hidden' id = 'valorTicketEmpresarioVendido'  value = '".$sumaPrecioBEV."' />";
				?>
			</td>
		</tr>-->
		
		<tr>
			<td style="text-align: left">
				VENTAS TICKET FACIL
			</td>
			<td>
				<div class = 'ventasGlobales'  ></div>
				<input type = 'hidden' id = 'ventasGlobalesResumen' />
			</td>
		</tr>
		<tr>
			<td style="text-align: left">
				COMICIONES Y RETENCIONES TARJETA
			</td>
			<td>
				<div class = 'sumaComiRet' id = 'sumaComiRetResumen' ></div>
			</td>
		</tr>
		<tr>
			<td style="text-align: left">
				FACTURA
			</td>
			<td>
				<?php 
					echo number_format(($costoMenosIva),2);
					echo "<input type = 'hidden' id = 'valorFacturaResumen'  value = '".(($costoMenosIva))."' />";
				?>
			</td>
		</tr>
		<tr>
			<td style="text-align: left">
				AFNA
			</td>
			<td>
				<?php 
					echo number_format(($sumaTotalSayse+$sumaTotalSaysePre+$sumaTotalSayseTer+$sumaTotalSayseTerPre),2);
					echo "<input type = 'hidden' id = 'valorSayseResumen'  value = '".number_format(($sumaTotalSayse+$sumaTotalSaysePre+$sumaTotalSayseTer+$sumaTotalSayseTerPre),2)."' />";
				?>
			</td>
		</tr>
		<tr>
			<td style="text-align: left">
				SRI
			</td>
			<td>
				<div id = 'totalImpuestoSri_pagar'></div>
			</td>
		</tr>
		<tr>
			<td style="text-align: left">
				MUNICIPIO
			</td>
			<td>
				<div id = 'totalImpuestoMunicipio_pagar'>1060.05</div>
			</td>
		</tr>
		
		<tr>
			<td style="text-align: left">
				TOTAL
			</td>
			<td>
				<div id = 'dineroResumen'></div>
			</td>
		</tr>
	</table>
	
	
</div>

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
		function resizeIframe(obj) {
			obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
			obj.style.width = obj.contentWindow.document.body.scrollWidth + 'px';
		}
		$('#contieneConciertosSocio').fadeOut('fast');
		setTimeout(function(){
			
			var efec_web = $("#iframe1").contents().find('#efec_web').val();
			
			var totalImpuestoSri = $("#iframeSri").contents().find('#totalImpuestoSri').val();
			$('#totalImpuestoSri_pagar').html(totalImpuestoSri);
			
			var totalImpuestoMunicipio = $("#iframeMuni").contents().find('#totalImpuestoMunicipio').val();
			
			var efec_web_prev = $("#iframe1").contents().find('#efec_web_prev').val();
			
			var efec_cad_com = $("#iframe1").contents().find('#efec_cad_com').val();
			var efec_cad_com_pre = $("#iframe1").contents().find('#efec_cad_com_pre').val();
			
			var efec_cad_tic = $("#iframe2").contents().find('#efec_cad_tic').val();
			var efec_cad_tic_prev = $("#iframe2").contents().find('#efec_cad_tic_prev').val();
			
			
			var sumaEfectivos = (parseFloat(efec_web) + parseFloat(efec_web_prev) + parseFloat(efec_cad_com) + parseFloat(efec_cad_com_pre) + parseFloat(efec_cad_tic) + parseFloat(efec_cad_tic_prev) ).toFixed(2);
	
			var tar_web = $("#iframe1").contents().find('#tar_web').val();
			var tar_web_prev = $("#iframe1").contents().find('#tar_web_prev').val();
			
			
			var tar_cad_com = $("#iframe1").contents().find('#tar_cad_com').val();
			var tar_cad_com_prev = $("#iframe1").contents().find('#tar_cad_com_prev').val();
			
			
			var tar_cad_tick = $("#iframe2").contents().find('#tar_cad_tick').val();
			var tar_cad_tick_prev = $("#iframe2").contents().find('#tar_cad_tick_prev').val();
			
			var sumaTarjetasWeb = (parseFloat(tar_web) + parseFloat(tar_web_prev)).toFixed(2);
			
			
			var sumaTarjetasCadCom = (parseFloat(tar_cad_com) + parseFloat(tar_cad_com_prev)).toFixed(2);
			
			
			var sumaTarjetasCadTick = (parseFloat(tar_cad_tick) + parseFloat(tar_cad_tick_prev)).toFixed(2);
			
			var sumacomisionTarjeta = $('#sumacomisionTarjeta').val();
			var sumaretencionTarjeta = $('#sumaretencionTarjeta').val();
			//alert(efec_web);
			
			var sumaComiRet = (parseFloat(sumacomisionTarjeta) + parseFloat(sumaretencionTarjeta));
			
			var ventasGlobales = (parseFloat(sumaEfectivos) + parseFloat(sumaTarjetasWeb) +  parseFloat(sumaTarjetasCadCom) +  parseFloat(sumaTarjetasCadTick)).toFixed(2);
			
			
			var ventasMenosRet = (parseFloat(ventasGlobales) - parseFloat(sumaComiRet));
			
			
			
			$('#sumaEfectivos').html(sumaEfectivos);
			$('#sumaTarjetasWeb').html(sumaTarjetasWeb);
			$('#sumaTarjetasCadCom').html(sumaTarjetasCadCom);
			$('#sumaTarjetasCadTick').html(sumaTarjetasCadTick);
			$('.ventasGlobales').html(ventasGlobales);
			$('#ventasGlobalesResumen').val(ventasGlobales);
			$('.sumaComiRet').html(sumaComiRet);
			$('#ventasMenosRet').html(ventasMenosRet);
			
			
			$('#contieneConciertosSocio').css('display','block');
			$('#loaderGif').css('display','none');
			
			
			var valorTicketEmpresarioEntregado = $('#valorTicketEmpresarioEntregado').val();
			var valorTicketEmpresarioVendido = $('#valorTicketEmpresarioVendido').val();
			
			var ventasGlobalesResumen = $('#ventasGlobalesResumen').val();
			
			var sumaComiRetResumen = $('#sumaComiRetResumen').html();
			var valorFacturaResumen = $('#valorFacturaResumen').val();
			var valorSayseResumen = $('#valorSayseResumen').val();
			var totalImpuestoSri_pagar = $('#totalImpuestoSri_pagar').html();
			var totalImpuestoMunicipio_pagar = $('#totalImpuestoMunicipio_pagar').html(); 
			
			
			var dineroEmpresarioResumen = (parseFloat(valorTicketEmpresarioEntregado) - parseFloat(valorTicketEmpresarioVendido));
			var dineroImpuestosResumen = (parseFloat(sumaComiRetResumen) + parseFloat(valorFacturaResumen) + parseFloat(valorSayseResumen) + parseFloat(totalImpuestoSri_pagar) + parseFloat(totalImpuestoMunicipio_pagar));
			var dineroResumen = (parseFloat(ventasGlobalesResumen) - parseFloat(dineroImpuestosResumen)).toFixed(2);
			//alert(ventasGlobalesResumen +'<< >>'+ dineroImpuestosResumen);
			$('#dineroResumen').html(dineroResumen);
			
			var suma_tickets = 0;
			var suma_dinero = 0;
			var sumaGlobalCogrado_reporte = $('#sumaGlobalCogrado_reporte').val();
			$('.tr_cadalocalidad').each(function(){
				var nom_loc = $(this).find('td .nom_loc').val(); 
				var global_tickets = $(this).find('td .global_tickets').val(); 
				var global_cobrado = $(this).find('td .global_cobrado').val(); 
				var precio_loc = $(this).find('td .precio_loc').val();  
				suma_tickets += parseFloat(global_tickets);
				suma_dinero += parseFloat(global_cobrado);
				$('#ventas_brutas').append('<tr style = "font-size:10px;color:#fff;" >\
												<td>' +nom_loc+ '</td>\
												<td>' + precio_loc + '</td>\
												<td>' + global_tickets + '</td>\
												<td>' + global_cobrado + '</td>\
											</tr>');
			});
			
			$('#ventas_brutas').append('<tr style = "font-size:10px;color:#fff;" >\
											<td>Total</td>\
											<td></td>\
											<td>' + suma_tickets + '</td>\
											<td>' +sumaGlobalCogrado_reporte+ '</td>\
										</tr>');
										
										
			var id_concierto = $('#id_concierto').val();
			
			$.post("Estadisticas/ajax/boletos_empresario.php",{ 
				id_concierto : id_concierto 
			}).done(function(data){
				$('#tabla_empresario').append(data);
				var ventas_brutas_height = $('#ventas_brutas').height();
				$('#tabla_empresario').css('height',ventas_brutas_height);
			});
			
			
			$.post("Estadisticas/ajax/taquilla_ventas_emp.php",{ 
				id_concierto : id_concierto 
			}).done(function(data){
				$('#taquilla_emp').append(data);
				// var ventas_brutas_height = $('#ventas_brutas').height();
				// $('#tabla_empresario').css('height',ventas_brutas_height);
			});


		}, 15000);
		// var heightSri = $("#iframeSri").contents().find('#tableSri').height();
		// alert(heightSri);
	</script>