<?php
	include("controlusuarios/seguridadDis.php");
	include 'conexion.php';
	
	
	$codigocompra = $_REQUEST['cod'];
	$sqlF = 'select * from factura where id = "'.$codigocompra.'" ';
	// echo $sqlF."hola <br>";
	$resF = mysql_query($sqlF) or die (mysql_error());
	$rowF = mysql_fetch_array($resF);
	
	$precioF = $rowF['ndepo'];
	
	$preExp = explode("|",$precioF);
	$pre1 = $preExp[2];
	$id_desc = $preExp[1];
	
	
	
	echo '<input type="hidden" id="data" value="1" />';
	
	$gbd = new DBConn();
	
	
	$estado = $_REQUEST['estado'];
	
	$sql = 'SELECT strNombresC, strMailC, strDocumentoC, strEnvioC, intTelefonoMovC, costoenvioC, strDireccionC, 
			strEvento, strImagen, estadoPV, estadopagoPV , dateFechaPreventa , co.envio
			FROM pventa p 
			JOIN Cliente c 
			ON p.clientePV = c.idCliente 
			JOIN Concierto co 
			ON p.conciertoPV = co.idConcierto 
			WHERE idFactura = "'.$codigocompra.'"
			';
	//echo $sql;
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute();
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	
	$dateFechaPreventa = $row['dateFechaPreventa'];
	// echo $dateFechaPreventa;
	
	$sql2 = '	SELECT strDescripcionL, doublePrecioL, doublePrecioReserva, doublePrecioPreventa, filaPV, 
				columnaPV, numboletosPV, localidadPV , conciertoPV , co.envio , p.valor_f
				FROM pventa p 
				JOIN Localidad l 
				ON p.localidadPV = l.idLocalidad 
				JOIN Concierto co 
				ON p.conciertoPV = co.idConcierto 
				WHERE idFactura = "'.$codigocompra.'" ';
	echo $sql2;
	$stmt2 = $gbd -> prepare($sql2);
	$stmt2 -> execute();
	
	
	
	
	$totalventa = '';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#00AEEF; margin:20px -42px 10px 30px; position:relative; color:#fff; padding:20px 0 30px 75px;">
				<div class="row">
					<div class="col-lg-12">
						<h3>Datos del Cliente</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-5">
						<h4>Nombre y Apellido:</h4>
						<input type="text" id="nombre" class="form-control inputlogin" value="<?php echo $row['strNombresC'];?>" />
					</div>
					<div class="col-lg-5">
						<h4>Documento de Identidad:</h4>
						<input type="text" id="documento" class="form-control inputlogin" value="<?php echo $row['strDocumentoC'];?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-lg-5">
						<h4>E.mail:</h4>
						<input type="text" id="mail" class="form-control inputlogin" value="<?php echo $row['strMailC'];?>" />
					</div>
					<div class="col-lg-5">
						<h4>Teléfono:</h4>
						<input type="text" id="telefono" class="form-control inputlogin" value="<?php echo $row['intTelefonoMovC'];?>" />
					</div>
				</div>
				<div class="row">
					<div class="col-lg-5">
						<h4>Dirección:</h4>
						<input type="text" id="dir" class="form-control inputlogin" value="<?php echo $row['strDireccionC'];?>" />
					</div>
					
						<?php
							$sqlCDPV = 'SELECT count(cdpv.id) as cuantos , cdpv.* FROM `cli_dom_pventa` as cdpv where id_fact = "'.$codigocompra.'" ';
							$resCDPV = mysql_query($sqlCDPV) or die (mysql_error());
							$rowCDPV = mysql_fetch_array($resCDPV);
							if($rowCDPV['cuantos'] != 0){
								$sqlC = 'select envio from Concierto where idConcierto = "'.$rowF['idConc'].'" ';
								$resC = mysql_query($sqlC) or die (mysql_error());
								$rowC = mysql_fetch_array($resC);
								$costoEnvio = $rowC['envio'];
								$verDetalleEnvio = '';
						?>
							<div class="col-lg-11">
								<marquee behavior="alternate" width="90%" loop="infinite">
									<h4><strong>Atención!!!</strong> Los tickets del cliente seran enviados a la siguiente dirección: </h4>
								</marquee>
								<input style = 'background-color:#00709B;' type="text" id="direc" readonly disabled class="form-control inputlogin" value="<?php echo $row['strDireccionC'];?>" />
								<input type = 'hidden' id = 'ident1' value = '1' style = 'color:#000;'>
							</div>
						<?php
							}else{
								$costoEnvio = 0;
								$verDetalleEnvio = 'display:none;';
						?>
								<input type = 'hidden' id = 'ident1' value = '0' style = 'color:#000;'>
						<?php
							}
							
						?>
						
						
					
				</div>
				<div class="tra_info_concierto"></div>
				<div class="par_info_concierto"></div>
			</div>
			<div class="row">
				<div class="col-lg-6" style="background-color:#EC1867; padding-left:20px; color:#fff; font-size:22px; margin-left:0;">
					<span><strong>Descripcion de Compra</strong></font></span>
				</div>
			</div>
			<div style="margin:20px 30px; border:2px solid #00AEEF;">
				<?php if(($row['estadoPV'] == 'Revisado') && ($row['estadopagoPV'] != 'ok')){ ?>
				<div class="row" style="color:#fff; text-align:center; padding-left:40px; font-size:18px;">
					<div class="col-xs-2">
						<strong>Asiento</strong>
					</div>
					<div class="col-xs-2">
						<strong>Localidad</strong>
					</div>
					<div class="col-xs-2">
						<strong># Boletos</strong>
					</div>
					<div class="col-xs-2">
						<strong>P/Unitario</strong>
					</div>
					<div class="col-xs-2">
						<strong>P/Total</strong>
					</div>
				</div>
				<?php 
					
					
				while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
						$hoy = date("Y-m-d");
						if($hoy < $dateFechaPreventa){
							$precio = $row2['doublePrecioPreventa'];
						}else{
							$precio = $row2['doublePrecioL'];
						}
					$sql3 = "SELECT descompra FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
					$stmt3 = $gbd -> prepare($sql3);
					$stmt3 -> execute(array($row2['filaPV'],$row2['columnaPV'],$row2['localidadPV'],$row2['conciertoPV']));
					$row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC);
					$tipocompra = $row3['descompra'];
					$costoboleto = $row2['doublePrecioL'];
					echo '
					<div class="row" style="color:#fff; text-align:center; padding-left:40px;">
						<div class="col-xs-2" style="border:1px solid #fff;">Fila-'.$row2['filaPV'].'_Asiento-'.$row2['columnaPV'].'</div>
						<div class="col-xs-2" style="border:1px solid #fff;">'.$row2['strDescripcionL'].'</div>
						<div class="col-xs-2" style="border:1px solid #fff;">'.$row2['numboletosPV'].'</div>
						<div class="col-xs-2" style="border:1px solid #fff;">'.$row2['valor_f'].'</div>
						<div class="col-xs-2" style="border:1px solid #fff;">'.$row2['valor_f'].'</div>
					</div>
					';
					$totalventa += $row2['valor_f'];
					$totalventa = number_format($totalventa,2);
				}?>
				<div class="row" style="color:#fff; text-align:center; padding-left:40px;">
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2">
						<strong>Subtotal:</strong>
					</div>
					<div class="col-xs-2" style="border-top:1px solid #fff;">
						<?php echo $totalventa;?>
						<input type="hidden" id="total" value="<?php echo $totalventa;?>" />
					</div>
				</div>
				<div class="row" style="color:#fff; text-align:center; padding-left:40px;">
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2">
						<strong>Abono Reserva:</strong>
					</div>
					<div class="col-xs-2">
						<?php echo $row['estadopagoPV'];?>
					</div>
				</div>
				<div class="row" style="color:#fff; text-align:center; padding-left:40px;">
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2">
						<strong>Saldo Pendiente:</strong>
					</div>
					<div class="col-xs-2" style="border-top:1px solid #fff;">
						<?php
						$saldo = $totalventa - $row['estadopagoPV'];
						$saldo = number_format($saldo,2);
						echo $saldo;
						if($row['strEnvioC'] == 'Domicilio'){
							$saldo = $totalventa - $row['estadopagoPV'];
							$saldo = $saldo + $row['costoenvioC'];
							$saldo = number_format($saldo,2);
						}else{
							$saldo = $totalventa - $row['estadopagoPV'];
							$saldo = number_format($saldo,2);
						}
						?>
					</div>
				</div>
				<?php if($row['strEnvioC'] == 'Domicilio'){?>
				<div class="row" style="color:#fff; text-align:center; padding-left:40px;">
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2">
						<strong>Costo de Envio:</strong>
					</div>
					<div class="col-xs-2">
						<?php echo number_format($row['costoenvioC'],2);?>
					</div>
				</div>
				<?php }?>
				<div class="row" style="color:#fff; text-align:center; padding-left:40px; font-size:20px;">
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2">
						<strong>Total a Pagar:</strong>
					</div>
					<div class="col-xs-2" style="border-top:1px solid #fff;">
						<?php echo $saldo; ?>
					</div>
				</div>
				<input type="hidden" id="identificador" value="1" />	
				<?php }else{ ?>
				<table class = 'table' style="color:#fff; text-align:center; padding-left:40px; font-size:18px;">
					<tr >
						<td >
							<strong>Asiento</strong>
						</td>
						<td >
							<strong>Localidad</strong>
						</td>
						<td >
							<strong>Cantidad</strong>
						</td>
						<td >
							<strong>P/Unitario</strong>
						</td>
						<td >
							<strong>P/Total</strong>
						</td>
					</tr>
				<?php while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
						$hoy = date("Y-m-d");
						if($hoy < $dateFechaPreventa){
							$precio = $row2['doublePrecioPreventa'];
						}else{
							$precio = $row2['doublePrecioL'];
						}
					$sql3 = "SELECT descompra FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
					$stmt3 = $gbd -> prepare($sql3);
					$stmt3 -> execute(array($row2['filaPV'],$row2['columnaPV'],$row2['localidadPV'],$row2['conciertoPV']));
					$row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC);
					$tipocompra = $row3['descompra'];
					if($tipocompra == 1){
						$costoboleto = $row2['doublePrecioPreventa'];
						$identificador = 1;
						$titletotal = 'Total';
					}else if($tipocompra == 2){
						$costoboleto = $row2['doublePrecioL'];
						$identificador = 1;
						$titletotal = 'Total';
					}else if($tipocompra == 3){
						$costoboleto = $row2['doublePrecioReserva'];
						$identificador = 2;
						$titletotal = 'Total';
					}
					echo '
					
						<tr>
							<td class="col-xs-2" style="border:1px solid #fff;">
								Fila-'.$row2['filaPV'].'_Asiento-'.$row2['columnaPV'].'
							</td>
							<td class="col-xs-2" style="border:1px solid #fff;">
								'.$row2['strDescripcionL'].'
							</td>
							<td class="col-xs-2" style="border:1px solid #fff;">
								'.$row2['numboletosPV'].'
							</td>
							<td class="col-xs-2" style="border:1px solid #fff;">
								'.$row2['valor_f'].'
							</td>
							<td class="col-xs-2" style="border:1px solid #fff;">
								'.$row2['valor_f'].'
							</td>
						</tr>
					
					';
					$totalventa += $row2['valor_f'];
					//$totalventa = number_format($totalventa,2);
				}?>
					<tr  style="color:#fff; text-align:center; padding-left:40px; font-size:20px;<?php echo $verDetalleEnvio?>">
						<td ></td>
						<td ></td>
						<td ></td>
						<td >
							<strong>Costo Envio:</strong>
						</td>
						<td style="border-top:1px solid #fff;">
							<?php echo number_format(($costoEnvio),2);?>
						</td>
					</tr>
					
					<tr style="color:#fff; text-align:center; padding-left:40px; font-size:20px;">
						<td ></td>
						<td ></td>
						<td ></td>
						<td >
							<strong><?php echo $titletotal;?>:</strong>
						</td>
						<td  style="border-top:1px solid #fff;">
							<?php echo number_format(($totalventa + $costoEnvio),2);?>
							<input type="hidden" id="total" value="<?php echo ($totalventa + $costoEnvio);?>" />
						</td>
					</tr>
				</table>
					<input type="hidden" id="identificador" value="<?php echo $identificador;?>" />
				<?php }?>
			</div>
			<div class="row" style="text-align:center; color:#fff;">
				<div class="col-lg-12">
					<h3><strong>Forma de Pago</strong></h3>
				</div>
			</div>
			<div class="row" style="color:#fff;">
				<div class="col-lg-5"></div>
				<div class="col-lg-4">
					<h4><label for="efectivo" style="cursor:pointer;"><input type="radio" id="efectivo" onclick = 'saberTipoPago(1);' name="fpago" checked="checked" style="cursor:pointer;" />&nbsp;Efectivo</label></h4>
				</div>
			</div>
            <div class="row" style="color:#fff;">
				<div class="col-lg-5"></div>
				<div class="col-lg-4">
					<h4><label for="tarjeta" style="cursor:pointer;"><input type="radio" id="tarjeta" onclick = 'saberTipoPago(2);' name="fpago" style="cursor:pointer;" />&nbsp;Tarjeta de Crédito</label></h4>
                    <select class = 'form-control' id = 'tipo_tarjeta' style = 'display:none;' >
						<option value = '0' >Seleccione</option>
						<option value = '1' >Visa</option>
						<option value = '2' >Dinners</option>
						<option value = '3' >Mastercard</option>
						<option value = '4' >Discover</option>
						<option value = '5' >Amex</option>
					</select>
                    <script>
        				function saberTipoPago(id){
        					if(id == 1){
        						$('#tipo_tarjeta').fadeOut('slow');
        					}else{
        						$('#tipo_tarjeta').fadeIn('slow');
        					}
        				}
        			</script>
				</div>
			</div>
			<div class="row" style="padding:30px 0px; text-align:center;">
				<div class="col-lg-12">
				<?php
					if($estado == 1){
						$txtBoton = 'BOLETO YA COBRADO';
						$disabled = 'disabled';
						$cursor = 'wait';
					}else{
						$txtBoton = 'REGISTRAR PAGO';
						$disabled = '';
						$cursor = 'pointer';
					}
				?>
					<button type="button" style = 'cursor:<?php echo $cursor;?>;' class="btndegradate" <?php echo $disabled;?> onclick="confirmar()"><?php echo $txtBoton;?></button>&nbsp;&nbsp;
					<button type="button" class="btndegradate" id="btncancelar">CANCELAR</button>
				</div>
			</div>
			<div class="modal fade" id="confirmacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Confirmación</h4>
						</div>
						<div class="modal-body">
							<h4 id="alerta1" class="alertas">
								<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Continuar con el proceso de Cobro?
								</div>
							</h4>
							<div style="text-align:center; display:none;" id="wait">
								<img src="imagenes/loading.gif" style="max-width:70px;" />
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="button" class="btn btn-primary" onclick="registarPago('<?php echo $codigocompra;?>');">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="cancelar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Cancelar</h4>
						</div>
						<div class="modal-body">
							<h4 id="alerta1" class="alertas">
								<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Desea cancelar el proceso de pago?
								</div>
							</h4>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="button" class="btn btn-primary" onclick="cancelar()">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Aviso</h4>
						</div>
						<div class="modal-body">
							<h4 id="alerta1" class="alertas">
								<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Error!</strong>&nbsp;No has seleccionado una Forma de Pago, por favor hazlo.
								</div>
							</h4>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function confirmar(){
	var formapago = '';
	if($('#tarjeta').is(':checked')){
		formapago = 'Tarjeta de Credito';
	}else if($('#efectivo').is(':checked')){
		formapago = 'Efectivo';
	}
	if(formapago != ''){
		$('#confirmacion').modal('show');
	}else{
		$('#aviso').modal('show');
	}
}

$('#btncancelar').on('click',function(){
	$('#cancelar').modal('show');
});

function cancelar(){
	window.location = '?modulo=reservasDistribuidor';
}

function registarPago(codigo){
	$('#alerta1').fadeOut('slow');
	$('#wait').delay(600).fadeIn('slow');
	var identificador = $('#identificador').val();
	var ident1 = $('#ident1').val();
	var total = $('#total').val();
	var formapago = '';
	if($('#tarjeta').is(':checked')){
		formapago = 'Tarjeta de Credito';
	}else if($('#efectivo').is(':checked')){
		formapago = 'Efectivo';
	}
    var tipo_tarjeta = $('#tipo_tarjeta').val();
	$.post('distribuidor/cobros/ajax/ajaxRegistrarCobros.php',{
		codigo : codigo, identificador : identificador, total : total, formapago : formapago , ident1 : ident1,tipo_tarjeta:tipo_tarjeta
	}).done(function(response){
		window.location = '?modulo=cobrook';
	});
}
</script>