
<?php
	date_default_timezone_set("America/Guayaquil");
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
		include '../../conexion.php';
		$no_vendidos = 0;
		$_REQUEST['id_concierto'];
		$sqlImp = 'select * from impuestos where id_con = "'.$_REQUEST['id_concierto'].'" ';
		$resImp = mysql_query($sqlImp) or die(mysql_error());
		$rowImp = mysql_fetch_array($resImp);
		
		
		
		$sqlCon = 'select * from Concierto where idConcierto = "'.$_REQUEST['id_concierto'].'" ';
		$resCon = mysql_query($sqlCon) or die(mysql_error());
		$rowCon = mysql_fetch_array($resCon);
?>
	<style>
		.botonimagen{
			background-image:url(http://siga.rinconacademico.com/excel.jpg);
			background-repeat:no-repeat;
			height:50px;
			width:100px;
			background-position:center;
			cursor:pointer;
		}
	</style>
	<center>
		<input type="button" onclick="tableToExcel('contieneConciertosSocio', 'Reporte General ')" class="botonimagen" title='Descargar Reporte Excel' value=''/>
	</center>
		<table class = '' id='testTable1' style = 'background-color:#00ADEF;color:#fff;width:100%;' >
			<tr>
				<td colspan = "9" >
					REPORTE INGRESOS <?php echo $rowCon['strEvento'];?> <?php $hoy = date("Y-m-d H:i:s");  echo $hoy;?>
				<td/>
			<tr/>
			<tr>
				<th>Localidad</th>
				<th>Autorizados</th>
				<th>No Vendidos</th>
				<th>Impresos</th>
				<th>Ingresados</th>
				<th>Valor</th>
				<th>Monto</th>
				<th>Impuesto</th>
				<th>Total</th>
			</tr>
	<?php
			$sqlCo1 = 'select * from Localidad where idConc = "'.$_REQUEST['id_concierto'].'" order by idLocalidad DESC';
			$resCo1 = mysql_query($sqlCo1) or die (mysql_error());
			while($rowCo1 = mysql_fetch_array($resCo1)){
				// if($rowCo1['idLocalidad'] == 103){
					// $autorizadosN = 1700;
					// $menos = 0;
					
				// }
				
				// if($rowCo1['idLocalidad'] == 102){
					// $autorizadosN = 1700;
					// $menos = 0;
					
				// }
				
				// if($rowCo1['idLocalidad'] == 101){
					// $autorizadosN = 400;
					// $menos = 0;
					
				// }
				
			$autoriza = $rowCo1['fechaCreacionL'];
			$autorizaEx = explode("@",$autoriza);
			$autorizadosN = $autorizaEx[0];
		//	echo $autoriza;
			$sql = 'select count(idBoleto) as vendidos from Boleto where idCon = "'.$_REQUEST['id_concierto'].'" and idLocB = "'.$rowCo1['idLocalidad'].'" and tercera = "0" ';
			$res = mysql_query($sql) or die (mysql_error());
			$row = mysql_fetch_array($res);
			
			$sqlIn = 'select count(idBoleto) as ingresados from Boleto where idCon = "'.$_REQUEST['id_concierto'].'" and idLocB = "'.$rowCo1['idLocalidad'].'" and tercera = "0" and strEstado = "I"';
			$resIn = mysql_query($sqlIn) or die (mysql_error());
			$rowIn = mysql_fetch_array($resIn);
	?>
			<tr>
				<td style='text-align:left;' valign = 'middle' ><?php echo $rowCo1['strDescripcionL'];?></td>
				<td>
					<?php 
						echo $autorizadosN;
						$sumAutorizadosN += $autorizadosN;
					?>
				</td>
				
				<td>
					<?php
						$no_vendidos = ($autorizadosN - $row['vendidos']);
						echo ($no_vendidos);
						$sumNoVendidos += $no_vendidos;
					?>
				</td>
				<td>
					<?php 
						echo ($row['vendidos']-$menos);
						$sumVendidos += ($row['vendidos'] -$menos );
					?>
				</td>
				<td>
					<?php 
						echo ($rowIn['ingresados'] -$menos );
						$sumIngresados += ($rowIn['ingresados']-$menos);
					?>
				</td>
				<td>
					<?php 
						$precioNo = $rowCo1['doublePrecioL'];
						echo $precioNo;
						$sumPrecioNo += $precioNo; 
					?>
				</td>
				<td>
					<?php
						$montoNo = ($precioNo * ($row['vendidos']-$menos));
						echo number_format(($montoNo),2, "," , "");
						$sumMontoNo += $montoNo;
					?>
				</td>
				<td>
					<?php
						$impuestoNo = ($precioNo * $rowImp['municipio']);
						echo $impuestoNo;
						$sumImpuestoNo += $impuestoNo;
					?>
				</td>
				<td>
					<?php
						$totalImp = ($impuestoNo * ($row['vendidos'] -$menos));
						echo $totalImp;
						$sumTotalImp += $totalImp;
					?>
				</td>
			</tr>
	<?php
			}
	?>
	
	
	
	<?php
			$sqlLoTer= 'select * from Localidad where idConc = "'.$_REQUEST['id_concierto'].'" order by idLocalidad DESC';
			$resLoTer = mysql_query($sqlLoTer) or die (mysql_error());
			while($rowLoTer = mysql_fetch_array($resLoTer)){
				
				// if($rowLoTer['idLocalidad'] == 103){
					
					// $autorizadosT1 = 300;
					
				// }
				
				// if($rowLoTer['idLocalidad'] == 102){
					
					// $autorizadosT1 = 300;
					
				// }
				
				// if($rowLoTer['idLocalidad'] == 101){
					
					// $autorizadosT1 = 100;
					
				// }
				
			$autoriza = $rowLoTer['fechaCreacionL'];
			$autorizaEx = explode("@",$autoriza);
			$autorizadosT1 = $autorizaEx[1];
			
				
			$sqlBoTer = 'select count(idBoleto) as vendidos from Boleto where idCon = "'.$_REQUEST['id_concierto'].'" and idLocB = "'.$rowLoTer['idLocalidad'].'" and tercera = "1" ';
			$resBoTer = mysql_query($sqlBoTer) or die (mysql_error());
			$rowBoTer = mysql_fetch_array($resBoTer);
			
			
			$sqlIn1 = 'select count(idBoleto) as ingresados from Boleto where idCon = "'.$_REQUEST['id_concierto'].'" and idLocB = "'.$rowLoTer['idLocalidad'].'" and tercera = "1" and strEstado = "I"';
			//echo $sqlIn1."<br>";
			$resIn1 = mysql_query($sqlIn1) or die (mysql_error());
			$rowIn1 = mysql_fetch_array($resIn1);
	?>
			<tr>
				<td style='text-align:left;' valign = 'middle' ><?php echo $rowLoTer['strDescripcionL'];?> Tercera </td>
				<td>
					<?php 
						echo $autorizadosT1;
						$sumAutorizadosT1 += $autorizadosT1;
					?>
				</td>
				
				<td>
					<?php
						$no_vendidosTer = ($autorizadosT1 - $rowBoTer['vendidos']);
						echo $no_vendidosTer;
						$sumNo_vendidosTer += $no_vendidosTer;
					?>
				</td>
				<td>
					<?php 
						echo $rowBoTer['vendidos'];
						$sumVendidosTer += $rowBoTer['vendidos'];
					?>
				</td>
				<td>
					<?php
						echo $rowIn1['ingresados'];
						$sumIngresadosTer += $rowIn1['ingresados'];
					?>
				</td>
				<td>
					<?php
						$precioTer = ($rowLoTer['doublePrecioL'] * 0.5);
						echo $precioTer;
						$sumPrecioTer += $precioTer;
					?>
				</td>
				<td>
					<?php
						$montoTe = ($precioTer * $rowBoTer['vendidos']);
						echo number_format(($montoTe),2, "," , "");
						$sumMontoTer += $montoTe;
					?>
				</td>
				
				<td>
					<?php
						$impuestoTer = ($precioTer * $rowImp['municipio']);
						echo $impuestoTer;
						$sumImpuestoTer += $impuestoTer;
					?>
				</td>
				<td>
					<?php
						$totalImpTer = ($impuestoTer * $rowBoTer['vendidos']);
						echo $totalImpTer;
						$sumTotalImpTer += $totalImpTer;
					?>
				</td>
			</tr>
	<?php
			}
	?>
	
	
	
	<?php
			$sqlLoNi= 'select * from Localidad where idConc = "'.$_REQUEST['id_concierto'].'" order by idLocalidad DESC';
			$resLoNi = mysql_query($sqlLoNi) or die (mysql_error());
			while($rowLoNi = mysql_fetch_array($resLoNi)){
				
				// if($rowLoNi['idLocalidad'] == 103){

					// $autorizadosNi = 150;
				// }
				
				// if($rowLoNi['idLocalidad'] == 102){
					
					// $autorizadosNi = 150;
				// }
				
				// if($rowLoNi['idLocalidad'] == 101){
					
					// $autorizadosNi = 100;
				// }
				
			$autoriza = $rowLoNi['fechaCreacionL'];
			$autorizaEx = explode("@",$autoriza);
			$autorizadosNi = $autorizaEx[2];
				
			$sqlBoNi = 'select count(idBoleto) as vendidos from Boleto where idCon = "'.$_REQUEST['id_concierto'].'" and idLocB = "'.$rowLoNi['idLocalidad'].'" and tercera = "2" ';
			$resBoNi = mysql_query($sqlBoNi) or die (mysql_error());
			$rowBoNi = mysql_fetch_array($resBoNi);
			
			$sqlIn2 = 'select count(idBoleto) as ingresados from Boleto where idCon = "'.$_REQUEST['id_concierto'].'" and idLocB = "'.$rowLoNi['idLocalidad'].'" and tercera = "2" and strEstado = "I"';
			$resIn2 = mysql_query($sqlIn2) or die (mysql_error());
			$rowIn2 = mysql_fetch_array($resIn2);
	?>
			<tr>
				<td style='text-align:left;' valign = 'middle' ><?php echo $rowLoNi['strDescripcionL'];?> Niños </td>
				<td>
					<?php 
						echo $autorizadosNi;
						$sumAutorizadosNi += $autorizadosNi;
					?>
				</td>
				
				<td>
					<?php
						$no_vendidosNi = ($autorizadosNi - $rowBoNi['vendidos']);
						echo $no_vendidosNi;
						$sumNo_vendidosNi += $no_vendidosNi;
					?>
				</td>
				<td>
					<?php 
						echo $rowBoNi['vendidos'];
						$sumVendidosNi += $rowBoNi['vendidos'];
					?>
				</td>
				<td>
					<?php 
						echo $rowIn2['ingresados'];
						$sumIngresadosNi += $rowIn2['ingresados'];
					?>
				</td>
				<td>
					<?php 
						$precioNi = ($rowLoNi['doublePrecioL'] * 0);
						echo $precioNi; 
						$sumPrecioNi += $precioNi;
					?>
				</td>
				<td>
					<?php
						$montoNi = ($precioNi * $rowBoNi['vendidos']);
						echo number_format(($montoNi),2, "," , "");
						$sumMontoNi += $montoNi;
					?>
				</td>
				
				
				<td>
					<?php
						$impuestoNi = ($precioNi * $rowImp['municipio']);
						echo $impuestoNi;
						$sumImpuestoTer += $impuestoNi;
					?>
				</td>
				<td>
					<?php
						$totalImpNi = ($impuestoNi * $rowBoNi['vendidos']);
						echo $totalImpNi;
						$sumTotalImpNi += $totalImpNi;
					?>
				</td>
				
				
			</tr>
	<?php
			}
	?>
			<tr>
				<th style='text-align:left;' valign = 'middle' >Total</th>
				<th>
					<?php echo ($sumAutorizadosN+$sumAutorizadosT1+$sumAutorizadosNi);?>
				</th>
				<th><?php echo ($sumNoVendidos+$sumNo_vendidosTer+$sumNo_vendidosNi);?></th>
				<th><?php echo ($sumVendidos+$sumVendidosTer+$sumVendidosNi);?></th>
				<th><?php echo ($sumIngresados+$sumIngresadosTer+$sumIngresadosNi);?></th>
				<th><?php echo number_format(($sumPrecioNo+$sumPrecioTer+$sumPrecioNi),2, "," , "");?></th>
				<th><?php echo number_format(($sumMontoNo+$sumMontoTer+$sumMontoNi),2, "," , "");?></th>
				
				<th><?php echo number_format(($sumImpuestoNo+$sumImpuestoTer+$sumImpuestoTer),2, "," , "");?></th>
				<th><?php echo number_format(($sumTotalImp+$sumTotalImpTer+$totalImpNi),2, "," , "");?></th>
			</tr>
		</table>
	<script>
		
	</script>