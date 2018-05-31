<?php
	date_default_timezone_set('America/Guayaquil');
		
	include 'conexion.php';
	
	$id = $_REQUEST['id'];
	$ident = $_REQUEST['ident'];
	if($ident == 1){
		$display = '';
	}else{
		$display = '';
	}
?>
	<table class = "table" id = 'recibeEventos' style = 'background-color:#fff;'>
		<tr>
			<td>Cliente</td>
			<td>Cedula</td>
			<td>Localidad</td>
			<td>Factura</td>
			<td>Ticket</td>
			<td>Asiento</td>
			<td>Valor Tick</td>
			<td style = '<?php echo $display;?>' >Comision Paypal</td>
			<td>Envio</td>
			<td>Total</td>
			<td>Estado</td>
			<td>Accion</td>
		</tr>
<?php
	$sql = 'SELECT * FROM detalle_tarjetas WHERE id_fact = "'.$id.'"';
	$res = mysql_query($sql) or die(mysql_error());
	
	$sqlT = 'SELECT * FROM factura WHERE id = "'.$id.'"';
	$resT = mysql_query($sqlT) or die(mysql_error());
	$rowT = mysql_fetch_array($resT);
	
	
	$numTick = mysql_num_rows($res);
	
	
	$sumaPrecio = 0;
	$sumaEnvio = 0;
	$sumaValorBoleto = 0;
	$sumaComision = 0;
	$contador = 0;
	while($row = mysql_fetch_array($res)){
		
		$sqlImp = 'SELECT * FROM transaccion_distribuidor WHERE numboletos ="'.$row['idbol'].'"';
		$resImp = mysql_query($sqlImp);

		$rowImp = mysql_fetch_array($resImp);

		
		$sql1 = 'select strEvento , envio , tiene_permisos , porcpaypal , valpaypal , porcstripe , valstripe from Concierto WHERE idConcierto = "'.$row['idcon'].'" ';
		$res1 = mysql_query($sql1) or die(mysql_error());
		$row1 = mysql_fetch_array($res1);
		
		if($rowT['ndepo'] == 1){
			$envio = ($row1['envio'] / $numTick);
			
		}else{
			$envio = 0;
		}
		
		$sumaEnvio += $envio;
		$sql5 = 'SELECT * FROM autorizaciones WHERE idAutorizacion = "'.$row1['tiene_permisos'].'" ';
		$res5 = mysql_query($sql5) or die(mysql_error());
		$row5 = mysql_fetch_array($res5);
		
		$sql2 = 'select strDescripcionL , strDateStateL from Localidad WHERE idLocalidad = "'.$row['idloc'].'" ';
		$res2 = mysql_query($sql2) or die(mysql_error());
		$row2 = mysql_fetch_array($res2);
		
		$sql3 = 'select strNombresC , strDocumentoC from Cliente WHERE idCliente = "'.$row['idcli'].'" ';
		$res3 = mysql_query($sql3) or die(mysql_error());
		$row3 = mysql_fetch_array($res3);
		
		$sql4 = 'SELECT * FROM Boleto WHERE idBoleto = "'.$row['idbol'].'" ';
		$res4 = mysql_query($sql4) or die(mysql_error());
		$row4 = mysql_fetch_array($res4);
		
		$sql6 = 'SELECT * FROM detalle_boleto WHERE idBoleto = "'.$row['idbol'].'" ';
		$res6 = mysql_query($sql6) or die(mysql_error());
		$row6 = mysql_fetch_array($res6);

		$sqlForDes = 'SELECT * FROM detalle_boleto WHERE idBoleto = "'.$row['idbol'].'" ';
		$resForDes = mysql_query($sqlForDes) or die(mysql_error());

		while ($rowForDes = mysql_fetch_array($resForDes)) {
			if ($rowForDes['estadoCompra'] == 0) {
				$contador += 1;
			}
		}
		
		
		$valor = $row['valor'];
		$valor_boletos = ($valor);
		
		$sumaValorBoleto += $valor_boletos;
		if($ident == 1){
			$comisionPaypal = $row1['porcpaypal'];
			$precioCom = (((($valor_boletos + $envio)* $comisionPaypal)/100) + ($row1['valpaypal'] / $numTick));
		}else{
			$comisionPaypal = $row1['porcstripe'];
			$precioCom = (((($valor_boletos + $envio)* $comisionPaypal)/100) + ($row1['valstripe'] / $numTick));
		}
		
		$sumaComision += $precioCom;
		
		$precioConComision = ($valor + $precioCom + $envio);
		
		$sumaPrecio += ($precioConComision);
		
		
?>
		<tr>
			
			
			<td><?php echo utf8_decode($row3['strNombresC']);?></td>
			<td><?php echo $row3['strDocumentoC'];?></td>
			<td><?php echo $row2['strDescripcionL'];?></td>
			
			<td style = 'text-align:right;'><?php echo $row5['codestablecimientoAHIS']."-".$row5['serieemisionA']."-".$row4['serie']?></td>
			<td style = 'text-align:right;'><?php echo $row2['strDateStateL']."-".$row4['serie_localidad'];?></td>
			<td style = 'text-align:right;'><?php echo $row6['asientos'];?></td>
			<td style = 'text-align:right;'><?php echo number_format(($valor_boletos),2);?></td>
			
			<td style = 'text-align:right;<?php echo $display;?>'><?php echo number_format(($precioCom),3);?></td>
			<td style = 'text-align:right;'><?php echo number_format(($envio),2);?></td>
			<td style = 'text-align:right;'><?php echo number_format(($precioConComision),2);?></td>
			<td><?php if ($rowImp['impresion_local'] == 0) {
				echo 'No impreso';
			}else{
				echo 'Impreso';
			} ?>
			</td>
			<?php if ($rowImp['impresion_local'] == 0) { ?>
					<td><?php if ($row6['estadoCompra'] == 0) {
							echo '<button onclick="activarBoletos('.$row6['idBoleto'].')" class="btn btn-primary">Activar</button>';
						}else{
							echo '<button onclick="desactivarBoletos('.$row6['idBoleto'].')" class="btn btn-primary">Desactivar</button>';
						} ?>
					</td>
			<?php }else{ ?>
					<td>
						<button class="btn btn-primary">Boleto impreso</button>
					</td>
				<?php } ?>
			
		</tr>
<?php
	}
?>
		<tr>
			<td colspan = '6' style = 'text-align:center;'>
				TOTAL 
			</td>
			<td style = 'text-align:right;'>
				<?php echo number_format(($sumaValorBoleto),2);?>
			</td>
			<td style = 'text-align:right;<?php echo $display;?>'>
				<?php echo number_format(($sumaComision),2);?>
			</td>
			<td style = 'text-align:right;'>
				<?php echo number_format(($sumaEnvio),2);?>
			</td>
			
			<td style = 'text-align:right;'>
				<?php echo number_format(($sumaPrecio),2);?>
			</td>
			<td style="text-align: right;">
				<?php echo "Desactivados: ".$contador; ?>
			</td>
		</tr>
	</table>