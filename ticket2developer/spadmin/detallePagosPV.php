<?php
	date_default_timezone_set('America/Guayaquil');
		
	include 'conexion.php';
	
	$id = $_REQUEST['id'];
	$ident = $_REQUEST['ident'];
	if($ident == 1){
		$display = '';
	}else{
		$display = 'display:none;';
	}
?>
	<table class = "table" id = 'recibeEventos' style = 'background-color:#fff;'>
		<tr>
			
			<td width = '10%' >Nº</td>
			<td width = '10%'>Cliente</td>
			<td width = '10%'>Cedula</td>
			<td>Localidad</td>
			<td width = '15%'>Asiento</td>
			
			
			<!--<td>Factura</td>
			<td>Ticket</td>-->
			
			<td width = '4%'>Serie</td>
			<td width = '4%'>Valor Tick</td>
			<td width = '4%'>Envio</td>
			
			<td width = '15%'>Descuento</td>
			
			
			<td width = '10%'>Forma Pago</td>
			<td width = '5%'>Tipo Tarjeta</td>
			<td width = '10%'>Tipo Transaccion</td>
			<td width = '5%'>Estado Deposito</td>
			
		</tr>
<?php
	$sql = 'select * from detalle_tarjetas where id_fact = "'.$id.'"';
	// echo $sql."<br><br>";
	$res = mysql_query($sql) or die(mysql_error());
	
	$sqlT = 'select * from factura where id = "'.$id.'"';
	$resT = mysql_query($sqlT) or die(mysql_error());
	$rowT = mysql_fetch_array($resT);
	
	
	$numTick = mysql_num_rows($res);
	
	
	$sumaPrecio = 0;
	$sumaEnvio = 0;
	$sumaValorBoleto = 0;
	$sumaComision = 0;
	while($row = mysql_fetch_array($res)){
		
		
		$sql1 = 'select strEvento , envio , tiene_permisos from Concierto where idConcierto = "'.$row['idcon'].'" ';
		$res1 = mysql_query($sql1) or die(mysql_error());
		$row1 = mysql_fetch_array($res1);
		
		
		
		$sqlCDPV = 'SELECT count(cdpv.id) as cuantos , cdpv.* FROM `cli_dom_pventa` as cdpv where id_fact = "'.$id.'" ';
		$resCDPV = mysql_query($sqlCDPV) or die (mysql_error());
		$rowCDPV = mysql_fetch_array($resCDPV);
		if($rowCDPV['cuantos'] != 0){
			$sqlC = 'select envio from Concierto where idConcierto = "'.$rowT['idConc'].'" ';
			$resC = mysql_query($sqlC) or die (mysql_error());
			$rowC = mysql_fetch_array($resC);
			$envio = ($rowC['envio']/ $numTick);
			$txtDom = '';
		}else{
			$envio = 0;
			$txtDom = '';
		}
		
		
		
		
		
		// if($rowT['ndepo'] == 1){
			// $envio = 0;//($row1['envio'] / $numTick);
			
		// }else{
			// $envio = 0;
		// }
		
		
		
		
		
		
		$sumaEnvio += $envio;
		$sql5 = 'select * from autorizaciones where idAutorizacion = "'.$row1['tiene_permisos'].'" ';
		$res5 = mysql_query($sql5) or die(mysql_error());
		$row5 = mysql_fetch_array($res5);
		
		$sql2 = 'select strDescripcionL , strDateStateL from Localidad where idLocalidad = "'.$row['idloc'].'" ';
		$res2 = mysql_query($sql2) or die(mysql_error());
		$row2 = mysql_fetch_array($res2);
		
		$sql3 = 'select strNombresC , strDocumentoC from Cliente where idCliente = "'.$row['idcli'].'" ';
		$res3 = mysql_query($sql3) or die(mysql_error());
		$row3 = mysql_fetch_array($res3);
		
		
		$sql4 = 'select * from Boleto where idBoleto = "'.$row['idbol'].'" ';
		$res4 = mysql_query($sql4) or die(mysql_error());
		$row4 = mysql_fetch_array($res4);
		
		
		$sql6 = 'select * from detalle_boleto where idBoleto = "'.$row['idbol'].'" ';
		$res6 = mysql_query($sql6) or die(mysql_error());
		$row6 = mysql_fetch_array($res6);
		
		$sql10 = 'select * from descuentos where id = "'.$row4['id_desc'].'" ';
		// echo $sql10."<br>";
		$res10 = mysql_query($sql10) or die(mysql_error());
		$row10 = mysql_fetch_array($res10);
		
		if($row4['id_desc'] == 0){
			$nomDesc = 'Ninguno <br>  USD$  0';
		}else{
			$nomDesc = $row10['nom']."   <br>  USD$".$row10['val'];
		}
		
		$valor = $row['valor'];
		$valor_boletos = ($valor);
		
		$sumaValorBoleto += $valor_boletos;
		if($ident == 1){
			$comisionPaypal = 5.4;
			$precioCom = (((($valor_boletos + $envio)* $comisionPaypal)/100) + (0.30 / $numTick));
		}else{
			$comisionPaypal = 0;
			$precioCom = 0;
		}
		
		
		$sumaComision += $precioCom;
		
		$precioConComision = ($valor + $precioCom + $envio);
		
		$sumaPrecio += ($precioConComision);
		
		$sqlDb = 'select * from detalle_boleto where idBoleto = "'.$row['idbol'].'" ';
		$resDb = mysql_query($sqlDb) or die (mysql_error());
		$rowDb = mysql_fetch_array($resDb);
?>
		<tr>
			
			
			<td><?php echo utf8_decode($row4['idBoleto']);?></td>
			<td><?php echo utf8_decode($row3['strNombresC']);?></td>
			<td><?php echo $row3['strDocumentoC'];?></td>
			<td><?php echo $row2['strDescripcionL'];?></td>
			<td><?php echo $rowDb['asientos'];?></td>
			
			
			<!--<td style = 'text-align:right;'><?php echo $row5['codestablecimientoAHIS']."-".$row5['serieemisionA']."-".$row4['serie']?></td>
			<td style = 'text-align:right;'><?php echo $row2['strDateStateL']."-".$row4['serie_localidad'];?></td>-->
			<td style = 'text-align:right;'><?php echo $row2['strDateStateL']."-".$row4['serie_localidad'];?></td>
			<td style = 'text-align:right;'><?php echo number_format(($valor_boletos),2);?></td>
			<td style = 'text-align:right;'><?php echo number_format(($envio),2);?></td>
			<td style = 'text-align:center;'><?php echo $nomDesc;?></td>
			
			<td style = 'text-align:right;'>
				<?php 
					if($row4['tipo_tarjeta'] == 0){
						$tipo = 'Efectivo';
					}else{
						$tipo = 'Tarjeta';
					}
					echo $tipo;
				?>
			</td>
			<td style = 'text-align:right;'>
				<?php 
					if($row4['tipo_tarjeta'] == 0){
						$tipo_t = 'Ef.';
					}elseif($row4['tipo_tarjeta'] == 1){
						$tipo_t = 'Visa';
					}
					elseif($row4['tipo_tarjeta'] == 2){
						$tipo_t = 'Dinners';
					}
					elseif($row4['tipo_tarjeta'] == 3){
						$tipo_t = 'Mastercard';
					}
					elseif($row4['tipo_tarjeta'] == 4){
						$tipo_t = 'Discover';
					}
					elseif($row4['tipo_tarjeta'] == 5){
						$tipo_t = 'Amex';
					}
					
					
					echo $tipo_t;
				?>
			</td>
			<td style = 'text-align:right;'>
				<?php 
					if($row4['tipo_evento'] == 1){
						$tipoE = 'Cobro';
					}else{
						$tipoE = 'Venta';
					}
					echo $tipoE;
				?> 
			</td>
			<td style = 'text-align:right;'>
				<?php 
					
					if($row4['estado_dep'] == 0){
						$estDep = '<i class="fa fa-times-circle-o" aria-hidden="true" style = "color:red;" ></i>';
					}else{
						$estDep = '<i class="fa fa-check-square" aria-hidden="true" style = "color:#1D9E74;" ></i>';
					}
					echo $estDep;
				?>
			</td>
			
			
			<!--<td style = 'text-align:right;'><?php echo number_format(($precioConComision),2);?></td>-->
			
		</tr>
<?php
	}
?>
		<tr>
			<td colspan = '6' style = 'text-align:center;'>
				TOTAL 
			</td>
			<td style = 'text-align:right;'>
				<?php //echo number_format(($sumaValorBoleto),2);?>
			</td>
			
			
			
			<td style = 'text-align:right;'>
				<?php echo number_format(($sumaPrecio),2);?>
			</td>
		</tr>
	</table>