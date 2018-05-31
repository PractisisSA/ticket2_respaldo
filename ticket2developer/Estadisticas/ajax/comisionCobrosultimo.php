	
	<?php
		session_start();
		include '../../conexion.php';
		$idConcierto = $_REQUEST['idConcierto'];
		
		$sqlC = 'select * from Concierto where idConcierto = "'.$idConcierto.'" ';
		$resC = mysql_query($sqlC) or die (mysql_error());
		$rowC = mysql_fetch_array($resC);
		
		$sql = 'SELECT * 
				FROM Boleto 
				WHERE idCon = "'.$idConcierto.'" 
				and colB = "3"
				group by idLocB
				ORDER BY idLocB DESC ';
		//echo $sql;class='table table-border'
	?>
		<style>
			th , td {
				text-align:center;
				color:#fff;
			}
			table , tr , th  , td{
				border:1px solid #fff ;
			}
		</style>
	
	<table width = '100%' border = '1' style = 'font-size:12px;' id = '' >
		<tr>
			<td colspan = '9' valign = 'middle' align = 'center' style = 'background-color:#171A1B;color:#fff;' >
				DETALLE DE COMISIÓN POR VENTAS Y COBROS DE CADENA TICKET PARA EL CONCIERTO DE <?php echo $rowC['strEvento'];?>
			</td>
		</tr>
		<tr>
			<td valign = 'middle' align = 'center'>
				LOCALIDAD
			</td>
			<td colspan = '3' valign = 'middle' align = 'center'>
				VENTAS
			</td>
			<td colspan = '3' valign = 'middle' align = 'center'>
				COBROS
			</td>
			<td valign = 'middle' align = 'center'>
				COMISIÓN TOTAL
			</td>
			<td valign = 'middle' align = 'center'>
				TOTAL A PAGAR
			</td>
		</tr>
		<tr>
			<td rowspan = '1' valign = 'middle' align = 'center'>
				
			</td>
			<td valign = 'middle' align = 'center'>
				TICKET
			</td>
			<td valign = 'middle' align = 'center'>
				TOTAL
			</td>
			<td valign = 'middle' align = 'center'>
				COMISIÓN
			</td>
			<td valign = 'middle' align = 'center'>
				TICKET
			</td>
			<td valign = 'middle' align = 'center'>
				TOTAL
			</td>
			<td valign = 'middle' align = 'center'>
				COMISIÓN
			</td>
			<td rowspan = '1' valign = 'middle' align = 'center'>
				
			</td>
			<td rowspan = '1' valign = 'middle' align = 'center'>
				
			</td>
		</tr>
		<?php
			$sqlConCC = 'SELECT * FROM `Localidad` WHERE `idConc` = "'.$idConcierto.'"  ORDER BY `idLocalidad` DESC ';
			//echo $sqlComCiC;
			$resConCC = mysql_query($sqlConCC) or die (mysql_error());
			while($rowConCC = mysql_fetch_array($resConCC)){
				$sqlLoCC = 'select * from Localidad where idLocalidad = "'.$rowConCC['idLocalidad'].'" ';
				$resLoCC = mysql_query($sqlLoCC) or die (mysql_error());
				$rowLoCC = mysql_fetch_array($resLoCC);
				$doublePrecioPreventa = $rowLoCC['doublePrecioPreventa'];
				$doublePrecioL = $rowLoCC['doublePrecioL'];
				
		?>
			<tr>
				<td valign = 'middle' align = 'center'>
					<?php echo $rowLoCC['strDescripcionL'];?>
					<?php //echo $rowLoCC['idLocalidad'];?>
				</td>
				<td valign = 'middle' align = 'center'>
					<?php
						$sqlCcadCom = '	select count(idBoleto) as bol 
										from Boleto 
										where idLocB = "'.$rowLoCC['idLocalidad'].'" 
										and colB = "3"
										and tercera = 0
										and preventa = 0
										and tipo_evento = 2
										and id_usu_venta = "'.$_SESSION['iduser'].'"
									 ';
						//echo $sqlCcadCom."<br/>";
						$resCcadCom = mysql_query($sqlCcadCom) or die (mysql_error());
						$rowCcadCom = mysql_fetch_array($resCcadCom);
						//echo $rowCcadCom['bol']."<<>>".$doublePrecioL."<br/><br/>";
						
						$sqlCRPREVECadena = '
							select count(idBoleto) as bol 
										from Boleto 
										where idLocB = "'.$rowLoCC['idLocalidad'].'" 
										and colB = "3"
										and tercera = 0
										and preventa = 1
										and tipo_evento = 2
										and id_usu_venta = "'.$_SESSION['iduser'].'"
						';
						//echo $sqlCRPREVECadena."<br/>";
						$resCRPREVECadena = mysql_query($sqlCRPREVECadena) or die (mysql_error());
						$rowCRPREVECadena = mysql_fetch_array($resCRPREVECadena);
						//echo $rowCRPREVECadena['bol']."<<>>".$doublePrecioPreventa."<br/><br/>";
						
						$sqlCRPREVECadenaTercera = '
							select count(idBoleto) as bol 
										from Boleto 
										where idLocB = "'.$rowLoCC['idLocalidad'].'" 
										and colB = "3"
										and tercera = 1
										and preventa = 0
										and tipo_evento = 2
										and id_usu_venta = "'.$_SESSION['iduser'].'"
						';
						//echo $sqlCRPREVECadenaTercera."<br/>";
						$resCRPREVECadenaTercera = mysql_query($sqlCRPREVECadenaTercera) or die (mysql_error());
						$rowCRPREVECadenaTercera = mysql_fetch_array($resCRPREVECadenaTercera);
						//echo $rowCRPREVECadenaTercera['bol']."<<>>".$doublePrecioL."<br/><br/>";
						
						
						
						$sqlCRPREVECadenaTercera1 = '
							select count(idBoleto) as bol 
										from Boleto 
										where idLocB = "'.$rowLoCC['idLocalidad'].'" 
										and colB = "3"
										and tercera = 1
										and preventa = 1
										and tipo_evento = 2
										and id_usu_venta = "'.$_SESSION['iduser'].'"
						';
						//echo $sqlCRPREVECadenaTercera1."<br>";
						$resCRPREVECadenaTercera1 = mysql_query($sqlCRPREVECadenaTercera1) or die (mysql_error());
						$rowCRPREVECadenaTercera1 = mysql_fetch_array($resCRPREVECadenaTercera1);
						//echo $rowCRPREVECadenaTercera1['bol']."<<>>".$doublePrecioPreventa."<br/><br/>";
						
						
						
						//echo "normal : ".$rowCcadCom['bol']."<br/>normal preventa : ".$rowCRPREVECadena['bol']."<br/>tercera sin preventa: ".$rowCRPREVECadenaTercera['bol']."<br/>tercera preventa:".$rowCRPREVECadenaTercera1['bol']."<br>";
						$sumaVentasComRet = ($rowCcadCom['bol'] + $rowCRPREVECadena['bol'] + $rowCRPREVECadenaTercera['bol'] + $rowCRPREVECadenaTercera1['bol']);
						echo $sumaVentasComRet;
						$sumRowCcadComGeneral += $sumaVentasComRet;//suma total boletos
					?>
				</td>
				<td valign = 'middle' align = 'center'>
					<?php
						$totalEfecCC = ($rowLoCC['doublePrecioL']*$rowCcadCom['bol']);
						$totalEfecCRPREV1 = ($doublePrecioPreventa*$rowCRPREVECadena['bol']);
						$totalEfecCRPREV2 = (($rowCRPREVECadenaTercera['bol']*$rowLoCC['doublePrecioL'])*0.5);
						$totalEfecCRPREV12 = (($doublePrecioPreventa*$rowCRPREVECadenaTercera1['bol'])*0.5);
						
						
						$sumaTotVentasComRet = ($totalEfecCC + $totalEfecCRPREV1 + $totalEfecCRPREV2 + $totalEfecCRPREV12);
						
						
						
						echo $sumaTotVentasComRet;//.">><<";
						$sumaTotalEfecCC += $sumaTotVentasComRet;
					?>
				</td>
				<td valign = 'middle' align = 'center'>
					<?php
						$sqlComRetCC = 'select * from comi_ret where id_con = "'.$idConcierto.'" and detalle = "PUNTOS TICKET FACIL" ';

						$resComRetCC = mysql_query($sqlComRetCC) or die (mysql_error());
						$rowComRetCC = mysql_fetch_array($resComRetCC);
						$comi_venta =  $rowComRetCC['comi_venta'];
						$comVenEfeCC = (($comi_venta * $sumaTotVentasComRet)/100);
						echo $comVenEfeCC;//."hh";
						$sumComVenEfeCC += $comVenEfeCC;
					?>
				</td>
				<td valign = 'middle' align = 'center'>
					<?php
						$sqlCcadComT = 'select count(idBoleto) as bol 
										from Boleto 
										where idLocB = "'.$rowLoCC['idLocalidad'].'" 
										and colB = "3"
										and tercera = 0
										and preventa = 0
										and tipo_evento = 1
										and id_usu_venta = "'.$_SESSION['iduser'].'"
										';
						//echo $sqlCcadComT."<br>";
						$resCcadComT = mysql_query($sqlCcadComT) or die (mysql_error());
						$rowCcadComT = mysql_fetch_array($resCcadComT);
						
						
						$sqlCRPREVECadena1 = '
							select count(idBoleto) as bol 
										from Boleto 
										where idLocB = "'.$rowLoCC['idLocalidad'].'" 
										and colB = "3"
										and tercera = 0
										and preventa = 1
										and tipo_evento = 1
										and id_usu_venta = "'.$_SESSION['iduser'].'"
						';
						//echo $sqlCRPREVECadena1."<br>";
						$resCRPREVECadena1 = mysql_query($sqlCRPREVECadena1) or die (mysql_error());
						$rowCRPREVECadena1 = mysql_fetch_array($resCRPREVECadena1);
						
						$sqlCRPREVECadenaTercera1 = '
							select count(idBoleto) as bol 
										from Boleto 
										where idLocB = "'.$rowLoCC['idLocalidad'].'" 
										and colB = "3"
										and tercera = 1
										and preventa = 0
										and tipo_evento = 1
										and id_usu_venta = "'.$_SESSION['iduser'].'"
						';
						//echo $sqlCRPREVECadenaTercera1."<br>";
						$resCRPREVECadenaTercera1 = mysql_query($sqlCRPREVECadenaTercera1) or die (mysql_error());
						$rowCRPREVECadenaTercera1 = mysql_fetch_array($resCRPREVECadenaTercera1);
						
						
						
						$sqlCRPREVECadenaTercera11 = '
							select count(idBoleto) as bol 
										from Boleto 
										where idLocB = "'.$rowLoCC['idLocalidad'].'" 
										and colB = "3"
										and tercera = 1
										and preventa = 1
										and tipo_evento = 1
										and id_usu_venta = "'.$_SESSION['iduser'].'"
						';
						
						$resCRPREVECadenaTercera11 = mysql_query($sqlCRPREVECadenaTercera11) or die (mysql_error());
						$rowCRPREVECadenaTercera11= mysql_fetch_array($resCRPREVECadenaTercera11);
						//echo $sqlCRPREVECadenaTercera11."<br>";
						
						
						//echo "normal : ".$rowCcadCom['bol']."preventa : ".$rowCRPREVECadena['idBol1']."preventa tercera : ".$rowCRPREVECadenaTercera['idBol2'];
						$sumaVentasComRet1 = ($rowCcadComT['bol'] + $rowCRPREVECadena1['bol'] + $rowCRPREVECadenaTercera1['bol'] + $rowCRPREVECadenaTercera11['bol']);
						//echo $sumaVentasComRet1;
						$sumRowCcadCom += $sumaVentasComRet1;//suma total boletos
						
						
						echo $sumaVentasComRet1;
						$sumRowCcadComT += $sumaVentasComRet1;
					?>
				</td>
				<td valign = 'middle' align = 'center'>
					<?php
						$totalTarCC = ($rowLoCC['doublePrecioL']*$rowCcadComT['bol']);
						$totalTarCC1 = ($doublePrecioPreventa*$rowCRPREVECadena1['bol']);
						$totalTarCC2 = (($rowLoCC['doublePrecioL']*$rowCRPREVECadenaTercera1['bol'])*0.5);
						$totalTarCC12 = (($doublePrecioPreventa*$rowCRPREVECadenaTercera11['bol'])*0.5);
						
						
						$totalTarCCGlobal = ($totalTarCC + $totalTarCC1 + $totalTarCC2 + $totalTarCC12);
						echo $totalTarCCGlobal;//."<<>>";
						$sumaTotalEfecCC111 += $totalTarCCGlobal;
					?>
				</td>
				<td valign = 'middle' align = 'center'>
					<?php
						$sqlComRetCC1 = 'select * from comi_ret where id_con = "'.$idConcierto.'" and detalle = "PUNTOS TICKET FACIL" ';
						$resComRetCC1 = mysql_query($sqlComRetCC1) or die (mysql_error());
						$rowComRetCC1 = mysql_fetch_array($resComRetCC1);
						$comi_cobro =  $rowComRetCC1['comi_cobro'];
						$comVenEfeCC1 = (($comi_cobro * $totalTarCCGlobal)/100);
						echo $comVenEfeCC1;//."aa";
						$sumComVenEfeCC1 += $comVenEfeCC1;
					?>
				</td>
				<td rowspan = '1' valign = 'middle' align = 'center'>
					<?php
						$sumGComision = ($comVenEfeCC + $comVenEfeCC1);
						echo $sumGComision;
						$sumGlobalComision += $sumGComision;
					?>
				</td>
				<td>
					<?php
						
						$totAPagarFinalComi = (($sumaTotVentasComRet + $totalTarCCGlobal)-$sumGComision);
						//echo $totAPagar;
						//echo "ventas : ".$sumaTotVentasComRet." cobros : ".$totalTarCCGlobal." comision : ".$sumGComision." total a pagar : ".$totAPagarFinalComi;
						echo $totAPagarFinalComi;
						$sumTotAPagar += $totAPagarFinalComi;
					?>
				</td>
			</tr>
		<?php
			}
		?>
		<tr>
			<td rowspan = '1' valign = 'middle' align = 'center'>
				TOTAL
			</td>
			<td valign = 'middle' align = 'center'>
				<?php echo $sumRowCcadComGeneral?>
			</td>
			<td valign = 'middle' align = 'center'>
				<?php echo $sumaTotalEfecCC;?>
			</td>
			<td valign = 'middle' align = 'center'>
				<?php echo $sumComVenEfeCC;?>
			</td>
			<td valign = 'middle' align = 'center'>
				<?php echo $sumRowCcadComT;?>
			</td>
			<td valign = 'middle' align = 'center'>
				<?php echo $sumaTotalEfecCC111;?>
			</td>
			<td valign = 'middle' align = 'center'>
				<?php echo $sumComVenEfeCC1;?>
			</td>
			<td rowspan = '1' valign = 'middle' align = 'center'>
				<?php echo $sumGlobalComision;?>
			</td>
			<td>
				<?php
					echo $sumTotAPagar;
				?>
			</td>
		</tr>
		<tr>
			<td colspan = '3'>
				Total Tickets : <?php echo ($sumRowCcadComGeneral + $sumRowCcadComT);?>
			</td>
			<td colspan = '4' valign = 'middle' align = 'center'>
				Total Cobrado : <?php echo ($sumaTotalEfecCC + $sumaTotalEfecCC111);?>
			</td>
			<td colspan = '2'></td>
		</tr>
	</table>