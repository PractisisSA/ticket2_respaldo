<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<?php
		$idConcierto = $_REQUEST['idConcierto'];
		include '../../conexion.php';

		$sqlImp = 'select * from impuestos where id_con = "'.$idConcierto.'" ';
		$resImp = mysql_query($sqlImp) or die (mysql_error());
		$rowImp = mysql_fetch_array($resImp);
		$valorados = $rowImp['valorados'];
		$sin_permisos = $rowImp['sin_permisos'];
		$cortesias = $rowImp['cortesias'];
		$sayse = $rowImp['sayse'];
		$sri = $rowImp['sri'];
		$municipio = $rowImp['municipio'];
		
	?>
	<style>
		html , body {
			background-color:#00ADEF;
		}
		table , tr , td {
			color :#fff;
			
		}
	</style>
	<table class = 'table' style = 'background-color: #00ADEF;margin-bottom: 0;' id='tableSri'>
		<tr>
			<th colspan = '5' style = 'background-color: #171A1B;text-align:center;'>
				SRI
			</th>
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
				Total
			</td>
		</tr>
	<?php
		$sqlLoc = 'select * from Localidad where idConc = "'.$idConcierto.'" order by idLocalidad DESC ';
		$resLoc = mysql_query($sqlLoc) or die (mysql_error());
		$num_bol = 0;
		while($rowLoc = mysql_fetch_array($resLoc)){
			if($idConcierto == 37){
				if($rowLoc['idLocalidad'] == 100){
					$rowLoNor = 260;
				}elseif($rowLoc['idLocalidad'] == 99){
					$rowLoNor = 466;
				}else{
					$rowLoNor = 931;
				}
			}else{
				
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
									and (nombreHISB <> "empresario" and nombreHISB <> "cortesia")  
									ORDER BY idLocB DESC  
								';
					//echo $sqlLoNor;
					$resLoNor = mysql_query($sqlLoNor) or die(mysql_error());
					if($idConcierto > 37){
						$rowLoNorArray = mysql_fetch_array($resLoNor);
						$rowLoNor = $rowLoNorArray['idBol'];
					}
					
					echo $rowLoNor;//['idBol'];
					$sumaBoletos += $rowLoNor;
				?>
			</td>
			<td>
				<?php 
					echo $rowLoc['doublePrecioL'];
					$sumaPrecioPorBoleto += ($rowLoNor * $rowLoc['doublePrecioL']);//['idBol']
					
				?>
			</td>
			<td>
				<?php 
					$impuesto = ($rowLoc['doublePrecioL'] * $sri); 
					echo $impuesto;
					$sumaImpuestos += $impuesto;
				?>
			</td>
			
			<td>
				<?php
					$totalSayse = ($impuesto * $rowLoNor);//['idBol']
					echo number_format(($totalSayse),2);
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
			if($idConcierto == 37){
				if($rowLoc2['idLocalidad'] == 100){
					$rowLoTer = 14;
				}elseif($rowLoc2['idLocalidad'] == 99){
					$rowLoTer = 58;
				}else{
					$rowLoTer = 14;
				}
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
									and (nombreHISB <> "empresario" and nombreHISB <> "cortesia")  
									ORDER BY idLocB DESC  
								';
					//echo $sqlLoNor;
					$resLoTer = mysql_query($sqlLoTer) or die(mysql_error());
					//$rowLoTer = mysql_fetch_array($resLoTer);
					if($idConcierto > 37){
						$rowLoTerArray = mysql_fetch_array($resLoTer);
						$rowLoTer = $rowLoTerArray['idBol'];
					}
					echo $rowLoTer;//['idBol'];
					$sumaBoletosTer += $rowLoTer;
				?>
			</td>
			<td>
				<?php 
					echo ($rowLoc2['doublePrecioL'] * 0.5);
					$sumaPrecioPorBoletoTer += ($rowLoTer * ($rowLoc2['doublePrecioL'] * 0.5));//['idBol']
				?>
			</td>
			<td>
				<?php 
					$impuestoTer = (($rowLoc2['doublePrecioL'] * 0.5) * $sri); 
					echo $impuestoTer;
					$sumaImpuestosTer += $impuestoTer;
				?>
			</td>
			
			<td>
				<?php
					$totalSayseYTer = ($impuestoTer * $rowLoTer);//['idBol']
					echo number_format(($totalSayseYTer),2);
					$sumaTotalSayseTer += $totalSayseYTer;
				?>
			</td>
		</tr>
	<?php
		}
	?>
	
	
	
		<tr>
			<td style="text-align: left">
				Total  (+ 172 niños) 
			</td>
			<td>
				<?php 
					if($idConcierto == 37){
						
					}else{
						echo ($sumaBoletos+$sumaBoletosPre+$sumaBoletosTer+$sumaBoletosTerPre);
					}
					
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
					echo number_format(($sumaTotalSayse+$sumaTotalSaysePre+$sumaTotalSayseTer+$sumaTotalSayseTerPre),2);
					echo "<input type = 'hidden' id = 'totalImpuestoSri'  value = '".number_format(($sumaTotalSayse+$sumaTotalSaysePre+$sumaTotalSayseTer+$sumaTotalSayseTerPre),2)."' />";
				?>
			</td>
		</tr>
	</table>



