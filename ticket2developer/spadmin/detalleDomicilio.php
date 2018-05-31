<?php
	date_default_timezone_set('America/Guayaquil');
		
	include 'conexion.php';
	
	$id = $_REQUEST['id'];
	$ident = $_REQUEST['ident'];
	if($ident != 0){
		$display = 'text-align:right;';
		$img = 'http://ticketfacil.ec/ticket2/barcode/';
	}else{
		$display = '';
		$img = 'http://ticketfacil.ec/ticket2/subpages/Compras/barcodeStrype/';
	}
?>
	<style>
		.posiciones{
			text-align:left;
		}
	</style>
	
<div class="table-responsive">
	<?php
		$sqlF = 'select * from factura where id = "'.$id.'" ';
		$resF = mysql_query($sqlF) or die (mysql_error());
		$rowF = mysql_fetch_array($resF);
		
		$ident_deposito = $_REQUEST['ident_deposito'];
		if($ident_deposito == 11){
			$display_1 = '';
		}else{
			$display_1 = '';
		}
		
		if($rowF['fechaE'] != ''){
			$fechaE = $rowF['fechaE'];
		}else{
			$fechaE = $hoy = date("Y-m-d");
		}
		
		if($rowF['foto'] != ''){
			$foto = "".$rowF['foto'];
		}else{
			$foto = 'imagenes/vacio1.jpg';
		}
	?>
	
	<script>
		
		function grabarDomicilio(id){
			var imagen = $('#imagen').val();
			var datepicker = $('#datepicker').val();
			$.post("spadmin/actualiza_envio.php",{ 
				imagen : imagen , id : id , datepicker : datepicker
			}).done(function(data){
				alert(data)			
			});
		}
	</script>
	<table class = "table" id = 'recibeDomicilios' style = 'background-color:#fff;'>
		
		<tr>
			
			
			<td class='posiciones' >Cliente</td>
			
			<td class='posiciones'>Localidad</td>
			
			<td class='posiciones'>Ticket</td>
			<td class='posiciones'>Asiento</td>
			
			<td style = 'text-align:right;'>Valor Tick</td>
			
			<td style = '<?php echo $display;$display_1?>' >Comision</td>
			<td style = 'text-align:right;'>Envio</td>
			<td style = 'text-align:right;'>Total</td>
			<td class='posiciones'>Dirección</td>
			<td class='posiciones'>Convencional</td>
			<td class='posiciones'>Mobil</td>
			<td class='posiciones'>Estado Imp.</td>
			
			
		</tr>
<?php
	$sql = 'select * from detalle_tarjetas where id_fact = "'.$id.'"';
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
		if($rowF['tipo'] == 4){
			$Stripe = $row['tipo'];
			$expStripe = explode("|",$Stripe);
			$expIdStripe = explode(":",$expStripe[2]);
			
			$idStripe = "<br><label style = 'color:#4A4A4A;'> ID stripe : ".$expIdStripe[1]."</label>";
		}else{
			$idStripe = '';
		}
		
		$sql1 = 'select * from Concierto where idConcierto = "'.$row['idcon'].'" ';
		$res1 = mysql_query($sql1) or die(mysql_error());
		$row1 = mysql_fetch_array($res1);
		
		
	if($ident_deposito == 11){
		if($rowT['pventa'] == 1){
			$envio = ($row1['envio'] / $numTick);
			
		}else{
			$envio = 0;
		}
	}else{
		if($rowT['ndepo'] == 1){
			$envio = ($row1['envio'] / $numTick);
			
		}else{
			$envio = 0;
		}
	}	
		
		
		
		
		
		
		
		$sumaEnvio += $envio;
		$sql5 = 'select * from autorizaciones where idAutorizacion = "'.$row1['tiene_permisos'].'" ';
		$res5 = mysql_query($sql5) or die(mysql_error());
		$row5 = mysql_fetch_array($res5);
		
		$sql2 = 'select strDescripcionL , strDateStateL from Localidad where idLocalidad = "'.$row['idloc'].'" ';
		$res2 = mysql_query($sql2) or die(mysql_error());
		$row2 = mysql_fetch_array($res2);
		
		$sql3 = 'select strNombresC , strDocumentoC , intTelefonoMovC , strMailC from Cliente where idCliente = "'.$row['idcli'].'" ';
		$res3 = mysql_query($sql3) or die(mysql_error());
		$row3 = mysql_fetch_array($res3);
		
		
		$sql4 = 'select * from Boleto where idBoleto = "'.$row['idbol'].'" ';
		// echo $sql4."<br><br>";
		$res4 = mysql_query($sql4) or die(mysql_error());
		$row4 = mysql_fetch_array($res4);
		
		
		$sql6 = 'select * from detalle_boleto where idBoleto = "'.$row['idbol'].'" ';
		$res6 = mysql_query($sql6) or die(mysql_error());
		$row6 = mysql_fetch_array($res6);
		
		
		$sql7 = 'select * from domicilio where boletoD = "'.$row['idbol'].'" ';
		$res7 = mysql_query($sql7) or die(mysql_error());
		$row7 = mysql_fetch_array($res7);
		
		
		$sql8 = 'select impresion_local from `transaccion_distribuidor` where numboletos = "'.$row['idbol'].'" ';
		// echo $sql8."<br>";
		$res8 = mysql_query($sql8) or die(mysql_error());
		$row8 = mysql_fetch_array($res8);
		
		if($row8['impresion_local'] == 1){
			$estado = '<i class="fa fa-check-square-o" aria-hidden="true" style = "color:rgb(29,159,117);" ></i>';
			$txt = 'TIKETS YA IMPRESOS';
			$color = 'danger';
			$disabled = 'disabled';
		}else{
			$estado = '<i class="fa fa-times-circle-o" aria-hidden="true" style = "color:red;"></i>';
			$txt = 'IMPRIMIR TICKETS';
			$color = 'warning';
			$disabled = '';
		}
		$idBol .= $row['idbol']."|";
		
		$valor = $row['valor'];
		$valor_boletos = ($valor);
		
		$sumaValorBoleto += $valor_boletos;
		if($ident_deposito == 11){
			$comisionPaypal = $row1['porce_transfer'];
			if($rowT['pventa'] == 1){
				$precioCom = (((($valor_boletos + $envio )* $comisionPaypal)/100) + ($row1['comis_transfer'] / $numTick));
				// echo "((((".$valor_boletos.")* ".$comisionPaypal.")/100) + (".$row1['comis_transfer']." / ".$numTick."))<br>";
			}else{
				$precioCom = (((($valor_boletos)* $comisionPaypal)/100) + ($row1['comis_transfer'] / $numTick));
				
				// echo "((((".$valor_boletos.")* ".$comisionPaypal.")/100) + (".$row1['comis_transfer']." / ".$numTick."))<br>";
			}
			

		}else{
			if($ident == 1){
				$comisionPaypal = $row1['porcpaypal'];
				$precioCom = (((($valor_boletos + $envio)* $comisionPaypal)/100) + ($row1['valpaypal'] / $numTick));
			}else{
				$comisionPaypal = $row1['porcstripe'];
				$precioCom = (((($valor_boletos + $envio)* $comisionPaypal)/100) + ($row1['valstripe'] / $numTick));
			}

		}
		
		$sumaComision += $precioCom;
		
		$precioConComision = ($valor + $precioCom + $envio);
		
		$sumaPrecio += ($precioConComision);
		
		
?>
		<tr>
			
			
			<td class='posiciones'>
				<?php echo utf8_decode($row3['strNombresC']);?><br>
				CI : <?php echo $row3['strDocumentoC'];?><br>
				Cod Bar : <?php echo $row4['strBarcode'];?><br>
				<?php echo $idStripe;?>
			</td>
			
			<td class='posiciones'>
				<?php echo $row2['strDescripcionL'];?><br>
				<?php echo $row5['codestablecimientoAHIS']."-".$row5['serieemisionA']."-".$row4['serie']?>
			</td>
			<td class='posiciones'>
				<?php echo $row2['strDateStateL']."-".$row4['serie_localidad'];?>
			</td>
			<td style = 'text-align:left;'><?php echo $row6['asientos'];?></td>
			<td style = 'text-align:right;'><?php echo number_format(($valor_boletos),2);?></td>
			
			
			<td style = 'text-align:right;<?php echo $display;$display_1?>'><?php echo number_format(($precioCom),2);?></td>
			<td style = 'text-align:right;'><?php echo number_format(($envio),2);?></td>
			<td style = 'text-align:right;'><?php echo number_format(($precioConComision),2);?></td>
			
			
			
			<td style = 'text-align:left;'><?php echo $row7['domicilioHISD'];?></td>
			<td style = 'text-align:left;'><?php echo $row7['nombreHISD'];?></td>
			<td style = 'text-align:left;'>
				<?php echo $row3['intTelefonoMovC'];?><br>
				<?php echo $row3['strMailC'];?>
			</td>
			<td style = 'text-align:center;'><?php echo $estado;?></td>
			
			
			
		</tr>
<?php
		$cliente = $row['idcli'];

		$conc = $row['idcon'];

		$loc = $row['idloc'];

		$idDis = '22';

		$tipotrans = 0;

		$numboletos = $row['idbol'];
		

		if($rowT['tipo'] == 3){
			$pago = 'paypal';
		}else{
			$pago = 'stripe';
		}

		$valor = 0;

		// $fecha = date("Y-m-d H:i:s");

		$impresion = 0;
	}
	echo "<input type = 'hidden' id = 'idBol' value = '".$idBol."'  />";
?>
		<tr>
			<td colspan = '4' style = 'text-align:center;'>
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
		</tr>
		<tr>
			<td colspan = '12' style = 'text-align:right;'>
				<button type="button" class="btn btn-<?php echo $color;?>" id = 'imprimeTickets' <?php echo $disabled;?>
					onclick="imprimirDomicilio(
												<?php echo $cliente;?>,
												<?php echo $conc;?>,
												<?php echo $loc;?>,
												<?php echo $idDis;?>,
												<?php echo $tipotrans;?>,
												'<?php echo $pago;?>',
												<?php echo $valor;?>,
												<?php echo $impresion;?>,
												<?php echo $id;?>
												)"> 
					<i class="fa fa-print" aria-hidden="true"></i><?php echo $txt;?>
				</button>
			</td>
		</tr>
	</table>
	
	<br><br>
	<table class = "table" style = 'background-color:#fff;'>
		<tr>
			<td colspan = '2' style = 'text-align:center;width:33%;' > 
				FECHA ENTREGA : <br><br>
				<input type = 'text' id = 'datepicker' value = '<?php echo $fechaE;?>' placeholder = 'YYYY/MM/DD INGRESE FECHA' class = 'form-control'  />
			</td>
			
			<td colspan = '2'  style = 'text-align:center;width:33%;' >
				COMPROBANTE DE ENTREGA<br><br>
				<center>
					<img src = '<?php echo $foto;?>' class="img-thumbnail" alt="<?php echo $foto;?>"  id = 'upload' />
					<input type = 'hidden' id = 'imagen' value = '<?php echo $foto;?>' placeholder = 'foto' class = 'form-control'  />
				</center>
			</td>
			
			<td colspan = '2' style = 'text-align:center;width:33%;'  >
				<button type="button" class="btn btn-default" onclick="grabarDomicilio(<?php echo $id;?>)"> <i class="fa fa-floppy-o" aria-hidden="true"></i> GRABAR ENTREGA</button><br><br>
			</td>
		</tr>
	</table>
</div>
	<script src="https://www.ticketfacil.ec/ticket2/spadmin/ajaxupload.js"></script>
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/>
	<script src="js/jquery.datetimepicker.js"></script>
	<script language="javascript" src="spadmin/jquery.canvasAreaDraw.js"></script>

	<script>
		function imprimirDomicilio(cliente , conc , loc , idDis , tipotrans , pago , valor , impresion , id_fact){
			alert('se imprimira')
			$('#imprimeTickets').attr('disabled',true);
			$('#imprimeTickets').html('Espere ... <i class="fa fa-spinner" aria-hidden="true"></i>');
			var idBol = $('#idBol').val();
			$.post("spadmin/imprime_tickets_domicilio.php",{ 
				cliente : cliente , conc : conc , loc : loc , idDis : idDis , tipotrans : tipotrans ,
				pago : pago , valor : valor , impresion : impresion , idBol : idBol , id_fact : id_fact
			}).done(function(data){
				alert(data);
				window.location='';
			});
		}
		
	</script>