<?php
	ini_set('memory_limit', '512M');
	include '../../conexion.php';
	$idConcierto = $_REQUEST['idConcierto'];
	
	$sqlImp = 'select * from impuestos where id_con = "'.$idConcierto.'" ';
	$resImp = mysql_query($sqlImp) or die (mysql_error());
	$rowImp = mysql_fetch_array($resImp);
	$valorados = $rowImp['valorados'];
	$iva = $rowImp['iva'];
	$sin_permisos = $rowImp['sin_permisos'];
	$cortesias = $rowImp['cortesias'];
	$sayse = $rowImp['sayse'];
	
	echo $sayse;
	$sri = $rowImp['sri'];
	$municipio = $rowImp['municipio'];
	
	
?>

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
	$sqlLoc = 'select * from Localidad where idConc = "'.$idConcierto.'" order by strDescripcionL ASC';
	$resLoc = mysql_query($sqlLoc) or die (mysql_error());
	$num_bol = 0;
	$i=0;
	while($rowLoc = mysql_fetch_array($resLoc)){
		$i++;
		
		
?>
	<tr>
		<td style="text-align:left;border:1px solid #000;">
			<?php
				echo $i."---".$rowLoc['strDescripcionL'];
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php
				$sqlLoNor = ' 	SELECT count(idBoleto) as idBol
								FROM Boleto 
								WHERE idCon = "'.$idConcierto.'" 
								and idLocB = "'.$rowLoc['idLocalidad'].'"
								and tercera = 0
								ORDER BY idLocB DESC  
							';
				//echo $sqlLoNor."<br/>";
				$resLoNor = mysql_query($sqlLoNor) or die(mysql_error());
				$rowLoNor = mysql_fetch_array($resLoNor);
				
				echo $rowLoNor['idBol'];
				$sumaBoletos += $rowLoNor['idBol'];
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php 
				echo $rowLoc['doublePrecioL'];
				$sumaPrecioPorBoleto += ($rowLoc['doublePrecioL']);
				
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php 
				$impuesto = ($rowLoc['doublePrecioL'] * $sayse);
				echo $impuesto;
				$sumaImpuestos += $impuesto;
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php
				$subtotal = ($impuesto * $rowLoNor['idBol']);
				echo $subtotal;
				$sumaSubTotal += $subtotal;
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php
				$ivaSayse = ($subtotal * $iva);
				echo $ivaSayse;
				$sumaIvaSayse += $ivaSayse;
			?>
		</td>
		<td style = 'border:1px solid #000;'>
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

	<tr>
		<th>Total Localidades Precio Normal </th>
		<th><?php echo $sumaBoletos;?></th>
		<th><?php echo $sumaPrecioPorBoleto;?></th>
		<th><?php echo $sumaImpuestos;?></th>
		<th><?php echo $sumaSubTotal;?></th>
		<th><?php echo $sumaIvaSayse;?></th>
		<th><?php echo $sumaTotalSayse;?></th>
	</tr>
<?php	
	$sqlLoc2 = 'select Localidad.strDescripcionL ,Localidad.idLocalidad , descuentos.*
					from Localidad , descuentos
					where idConc = "'.$idConcierto.'" 
					and descuentos.idloc = Localidad.idLocalidad
					order by strDescripcionL ASC
				';
	
	$resLoc2 = mysql_query($sqlLoc2) or die (mysql_error());
	$j=0;
	while($rowLoc2 = mysql_fetch_array($resLoc2)){
		$j++;
?>
	<tr>
		<td style="text-align: left;border:1px solid #000;" >
			<?php
				echo $j." -- ".$rowLoc2['strDescripcionL']." DESCUENTO : ".$rowLoc2['nom'];
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php
				$sqlLoTer = ' 	SELECT count(idBoleto) as idBol , valor as precio_descuento , sum(valor) as precio_descuento_suma
								FROM Boleto 
								WHERE idCon = "'.$idConcierto.'" 
								and idLocB = "'.$rowLoc2['idLocalidad'].'"
								and tercera = 1
								and id_desc = "'.$rowLoc2['id'].'"
								ORDER BY idLocB DESC  
							';
				//echo $sqlLoTer;
				$resLoTer = mysql_query($sqlLoTer) or die(mysql_error());
				$rowLoTer = mysql_fetch_array($resLoTer);
				
				echo $rowLoTer['idBol'];
				$sumaBoletosTer += $rowLoTer['idBol'];
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php 
				echo number_format(($rowLoTer['precio_descuento']),2);
				$sumaPrecioPorBoletoTer += ($rowLoTer['precio_descuento']);
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php 
				$impuestoTer = ($rowLoTer['precio_descuento'] * $sayse); 
				echo $impuestoTer;
				$sumaImpuestosTer += $impuestoTer;
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php
				$subtotalTer = ($impuestoTer * $rowLoTer['idBol']);
				echo $subtotalTer;
				$sumaSubTotalTer += $subtotalTer;
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php
				$ivaSayseTer = ($subtotalTer *$iva);
				echo $ivaSayseTer;
				$sumaIvaSayseTer += $ivaSayseTer;
			?>
		</td>
		<td style = 'border:1px solid #000;'>
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
		<th>Total Localidades DESCUENTOS </th>
		<th><?php echo $sumaBoletosTer;?></th>
		<th><?php ?></th>
		<th><?php ?></th>
		<th><?php echo $sumaSubTotalTer;?></th>
		<th><?php echo $sumaIvaSayseTer;?></th>
		<th><?php echo $sumaTotalSayseTer;?></th>
	</tr>
	
	<tr>
		<th colspan = '6'></th>
	</tr>
	
	<tr>
		<td style="text-align: left;border:1px solid #000;">
			TOTAL GENERAL (normales + descuentos)
		</td>
		<td style = 'border:1px solid #000;'>
			<?php echo ($sumaBoletosTer + $sumaBoletos);?>
		</td>
		<td style = 'border:1px solid #000;'>
			
		</td>
		<td style = 'border:1px solid #000;'>
			
		</td>
		<td style = 'border:1px solid #000;'>
			<?php
				echo number_format(($sumaSubTotal + $sumaSubTotalTer),2 , "." , ",");
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php
				echo number_format(($sumaIvaSayse + $sumaIvaSayseTer),2);
			?>
		</td>
		<td style = 'border:1px solid #000;'>
			<?php
				echo number_format(($sumaTotalSayse + $sumaTotalSayseTer),2);
			?>
		</td>
	</tr>
</table>