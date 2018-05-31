	<?php
		$idConcierto = $_REQUEST['idConcierto'];
		include '../../conexion.php';
	?>
	<table class = 'table' >
		<tr>
			<td colspan = '7' style = 'background-color: #171A1B'>
				SRI
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
		$sqlLoc = 'select * from Localidad where idConc = "'.$idConcierto.'" ';
		$resLoc = mysql_query($sqlLoc) or die (mysql_error());
		$num_bol = 0;
		while($rowLoc = mysql_fetch_array($resLoc)){
			
	?>
		<tr>
			<td style="text-align: left">
				<?php
					echo $rowLoc['strDescripcionL']."  [Normal]";
				?>
			</td>
			<td>
				<?php
					$sqlLoNor = ' 	SELECT count(idBoleto) as idBol
									FROM Boleto 
									WHERE idCon = "'.$idConcierto.'" 
									and idLocB = "'.$rowLoc['idLocalidad'].'"
									and tercera = 0
									and preventa = 0
									ORDER BY idLocB DESC  
								';
					//echo $sqlLoNor;
					$resLoNor = mysql_query($sqlLoNor) or die(mysql_error());
					$rowLoNor = mysql_fetch_array($resLoNor);
					
					echo $rowLoNor['idBol'];
					$sumaBoletos += $rowLoNor['idBol'];
				?>
			</td>
			<td>
				<?php 
					echo $rowLoc['doublePrecioL'];
					$sumaPrecioPorBoleto += ($rowLoNor['idBol'] * $rowLoc['doublePrecioL']);
					
				?>
			</td>
			<td>
				<?php 
					$impuesto = ($rowLoc['doublePrecioL'] * 0.05); 
					echo $impuesto;
					$sumaImpuestos += $impuesto;
				?>
			</td>
			<td>
				<?php
					$subtotal = ($impuesto * $rowLoNor['idBol']);
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
		$sqlLoc1 = 'select * from Localidad where idConc = "'.$idConcierto.'" ';
		$resLoc1 = mysql_query($sqlLoc1) or die (mysql_error());
		while($rowLoc1 = mysql_fetch_array($resLoc1)){
			
	?>
		<tr>
			<td style="text-align: left">
				<?php
					echo $rowLoc1['strDescripcionL']."  [Pre-Venta]";
				?>
			</td>
			<td>
				<?php
					$sqlLoPrev = ' 	SELECT count(idBoleto) as idBol
									FROM Boleto 
									WHERE idCon = "'.$idConcierto.'" 
									and idLocB = "'.$rowLoc1['idLocalidad'].'"
									and tercera = 0
									and preventa = 1
									ORDER BY idLocB DESC  
								';
					//echo $sqlLoNor;
					$resLoPre = mysql_query($sqlLoPrev) or die(mysql_error());
					$rowLoPre = mysql_fetch_array($resLoPre);
					
					echo $rowLoPre['idBol'];
					$sumaBoletosPre += $rowLoPre['idBol'];
				?>
			</td>
			<td>
				<?php 
					echo $rowLoc1['doublePrecioPreventa'];
					$sumaPrecioPorBoletoPre += ($rowLoPre['idBol'] * $rowLoc1['doublePrecioPreventa']);
				?>
			</td>
			<td>
				<?php 
					$impuestoPre = ($rowLoc1['doublePrecioPreventa'] * 0.05); 
					echo $impuestoPre;
					$sumaImpuestosPre += $impuestoPre;
				?>
			</td>
			<td>
				<?php
					$subtotalPre = ($impuestoPre * $rowLoPre['idBol']);
					echo $subtotalPre;
					$sumaSubTotalPre += $subtotalPre;
				?>
			</td>
			<td>
				<?php
					$ivaSaysePre = ($subtotalPre * 0.14);
					echo $ivaSaysePre;
					$sumaIvaSaysePre += $ivaSaysePre;
				?>
			</td>
			<td>
				<?php
					$totalSaysePre = ($subtotalPre + $ivaSaysePre);
					echo $totalSaysePre;
					$sumaTotalSaysePre += $totalSaysePre;
				?>
			</td>
		</tr>
	<?php
		}
	?>
	
	
	
	<?php
		$sqlLoc2 = 'select * from Localidad where idConc = "'.$idConcierto.'" ';
		$resLoc2 = mysql_query($sqlLoc2) or die (mysql_error());
		while($rowLoc2 = mysql_fetch_array($resLoc2)){
			
	?>
		<tr>
			<td style="text-align: left" >
				<?php
					echo $rowLoc2['strDescripcionL']."  [3ERA EDAD / DESC  Normal]";
				?>
			</td>
			<td>
				<?php
					$sqlLoTer = ' 	SELECT count(idBoleto) as idBol
									FROM Boleto 
									WHERE idCon = "'.$idConcierto.'" 
									and idLocB = "'.$rowLoc2['idLocalidad'].'"
									and tercera = 1
									and preventa = 0
									ORDER BY idLocB DESC  
								';
					//echo $sqlLoNor;
					$resLoTer = mysql_query($sqlLoTer) or die(mysql_error());
					$rowLoTer = mysql_fetch_array($resLoTer);
					
					echo $rowLoTer['idBol'];
					$sumaBoletosTer += $rowLoTer['idBol'];
				?>
			</td>
			<td>
				<?php 
					echo ($rowLoc2['doublePrecioL'] * 0.5);
					$sumaPrecioPorBoletoTer += ($rowLoTer['idBol'] * ($rowLoc2['doublePrecioL'] * 0.5));
				?>
			</td>
			<td>
				<?php 
					$impuestoTer = (($rowLoc2['doublePrecioL'] * 0.5) * 0.05); 
					echo $impuestoTer;
					$sumaImpuestosTer += $impuestoTer;
				?>
			</td>
			<td>
				<?php
					$subtotalTer = ($impuestoTer * $rowLoTer['idBol']);
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
	
	
	
	<?php
		$sqlLoc3 = 'select * from Localidad where idConc = "'.$idConcierto.'" ';
		$resLoc3 = mysql_query($sqlLoc3) or die (mysql_error());
		while($rowLoc3 = mysql_fetch_array($resLoc3)){
			
	?>
		<tr>
			<td style="text-align: left" >
				<?php
					echo $rowLoc3['strDescripcionL']."  [3ERA EDAD / DESC  Preventa]";
				?>
			</td>
			<td>
				<?php
					$sqlLoTerPre = ' 	SELECT count(idBoleto) as idBol
									FROM Boleto 
									WHERE idCon = "'.$idConcierto.'" 
									and idLocB = "'.$rowLoc3['idLocalidad'].'"
									and tercera = 1
									and preventa = 1
									ORDER BY idLocB DESC  
								';
					//echo $sqlLoNor;
					$resLoTerPre = mysql_query($sqlLoTerPre) or die(mysql_error());
					$rowLoTerPre = mysql_fetch_array($resLoTerPre);
					
					echo $rowLoTerPre['idBol'];
					$sumaBoletosTerPre += $rowLoTerPre['idBol'];
				?>
			</td>
			<td>
				<?php 
					echo ($rowLoc3['doublePrecioPreventa'] * 0.5);
					$sumaPrecioPorBoletoTerPre += ($rowLoTerPre['idBol'] * ($rowLoc3['doublePrecioPreventa'] * 0.5));
				?>
			</td>
			<td>
				<?php 
					$impuestoTerPre = (($rowLoc3['doublePrecioPreventa'] * 0.5) * 0.05); 
					echo $impuestoTerPre;
					$sumaImpuestosTerPre += $impuestoTerPre;
				?>
			</td>
			<td>
				<?php
					$subtotalTerPre = ($impuestoTerPre * $rowLoTerPre['idBol']);
					echo $subtotalTerPre;
					$sumaSubTotalTerPre += $subtotalTerPre;
				?>
			</td>
			<td>
				<?php
					$ivaSayseTerPre = ($subtotalTerPre * 0.14);
					echo $ivaSayseTerPre;
					$sumaIvaSayseTerPre += $ivaSayseTerPre;
				?>
			</td>
			<td>
				<?php
					$totalSayseYTerPre = ($subtotalTerPre + $ivaSayseTerPre);
					echo $totalSayseYTerPre;
					$sumaTotalSayseTerPre += $totalSayseYTerPre;
				?>
			</td>
		</tr>
	<?php
		}
	?>
		<tr>
			<td style="text-align: left">
				Total
			</td>
			<td>
				<?php 
					echo ($sumaBoletos+$sumaBoletosPre+$sumaBoletosTer+$sumaBoletosTerPre);
				?>
			</td>
			<td>
				<?php
					echo number_format(($sumaPrecioPorBoleto+$sumaPrecioPorBoletoPre+$sumaPrecioPorBoletoTer+$sumaPrecioPorBoletoTerPre),2);
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



