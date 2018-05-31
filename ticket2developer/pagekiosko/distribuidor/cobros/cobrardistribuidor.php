<?php 
	include("controlusuarios/seguridadDis.php");
	
	echo '<input type="hidden" id="data" value="1" />';
	
	$gbd = new DBConn();
	
	$codigocompra = $_REQUEST['cod'];
	
	$sql = "SELECT strNombresC, strMailC, strDocumentoC, strEnvioC, intTelefonoMovC, costoenvioC, strDireccionC, strEvento, strImagen, estadoPV, estadopagoPV FROM pventa p JOIN Cliente c ON p.clientePV = c.idCliente JOIN Concierto co ON p.conciertoPV = co.idConcierto WHERE codigoPV = ? GROUP BY codigoPV";
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute(array($codigocompra));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	$sql2 = "SELECT strDescripcionL, doublePrecioL, doublePrecioReserva, doublePrecioPreventa, filaPV, columnaPV, numboletosPV, localidadPV , conciertoPV FROM pventa p JOIN Localidad l ON p.localidadPV = l.idLocalidad WHERE codigoPV = ?";
	$stmt2 = $gbd -> prepare($sql2);
	$stmt2 -> execute(array($codigocompra));
	
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
					<div class="col-lg-5">
						<h4>Como obtener su(s) TICKET(S):</h4>
						<select id="formaenvio" class="form-control inputlogin">
							<?php if($row['strEnvioC'] == 'Domicilio'){?>
							<option value="<?php echo $row['strEnvioC'];?>">Envio a Domicilio</option>
							<option value="correo">Correo Electrónico</option>
							<?php }else{?>
							<option value="<?php echo $row['strEnvioC'];?>">Correo Electrónico</option>
							<option value="Domicilio">Envio a Domicilio</option>
							<?php }?>
						</select>
					</div>
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
				<?php $num_boletos = 0; while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
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
						<div class="col-xs-2" style="border:1px solid #fff;">'.$costoboleto.'</div>
						<div class="col-xs-2" style="border:1px solid #fff;">'.$costoboleto.'</div>
					</div>
					';
					$num_boletos += $row2['numboletosPV'];
					$totalventa = $totalventa + $costoboleto;
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
				<?php $num_boletos = 0; while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
					$sql3 = "SELECT descompra FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
					$stmt3 = $gbd -> prepare($sql3);
					$stmt3 -> execute(array($row2['filaPV'],$row2['columnaPV'],$row2['localidadPV'],$row2['conciertoPV']));
					$row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC);
					$tipocompra = $row3['descompra'];
					if($tipocompra == 1){
						$costoboleto = $row2['doublePrecioPreventa'];
						$identificador = 1;
						$titletotal = 'Total Precio TICKET(S)';
					}else if($tipocompra == 2){
						$costoboleto = $row2['doublePrecioL'];
						$identificador = 1;
						$titletotal = 'Total Precio TICKET(S)';
					}else if($tipocompra == 3){
						$costoboleto = $row2['doublePrecioReserva'];
						$identificador = 2;
						$titletotal = 'Total Pago Reserva';
					}
					echo '
					<div class="row" style="color:#fff; text-align:center; padding-left:40px;">
						<div class="col-xs-2" style="border:1px solid #fff;">Fila-'.$row2['filaPV'].'_Asiento-'.$row2['columnaPV'].'</div>
						<div class="col-xs-2" style="border:1px solid #fff;">'.$row2['strDescripcionL'].'</div>
						<div class="col-xs-2" style="border:1px solid #fff;">'.$row2['numboletosPV'].'</div>
						<div class="col-xs-2" style="border:1px solid #fff;">'.$costoboleto.'</div>
						<div class="col-xs-2" style="border:1px solid #fff;">'.$costoboleto.'</div>
					</div>
					';
					$num_boletos += $row2['numboletosPV'];
					$totalventa = $totalventa + $costoboleto;
					$totalventa = number_format($totalventa,2);
				}?>
				<div class="row" style="color:#fff; text-align:center; padding-left:40px; font-size:20px;">
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2"></div>
					<div class="col-xs-2">
						<strong><?php echo $titletotal;?>:</strong>
					</div>
					<div class="col-xs-2" style="border-top:1px solid #fff;">
						<?php echo $totalventa;?>
						<input type="hidden" id="total" value="<?php echo $totalventa;?>" />
					</div>
				</div>
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
					<h4><label for="tarjeta" style="cursor:pointer;"><input type="radio" id="tarjeta" name="fpago" style="cursor:pointer;" />&nbsp;Tarjeta de Crédito</label></h4>
				</div>
			</div>
			<input type="hidden" id="num_boletos" value="<?php echo $num_boletos;?>" />
			<div class="row" style="color:#fff;">
				<div class="col-lg-5"></div>
				<div class="col-lg-4">
					<h4><label for="efectivo" style="cursor:pointer;"><input type="radio" id="efectivo" name="fpago" style="cursor:pointer;" />&nbsp;Efectivo</label></h4>
				</div>
			</div>
			<div class="row" style="padding:30px 0px; text-align:center;">
				<div class="col-lg-12">
					<button type="button" class="btndegradate" onclick="confirmar()">REGITRAR PAGO</button>&nbsp;&nbsp;
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
	var total = $('#total').val();
	var num_boletos = $('#num_boletos').val();
	var formapago = '';
	if($('#tarjeta').is(':checked')){
		formapago = 'Tarjeta de Credito';
	}else if($('#efectivo').is(':checked')){
		formapago = 'Efectivo';
	}
	$.post('distribuidor/cobros/ajax/ajaxRegistrarCobros.php',{
		codigo : codigo, identificador : identificador, total : total, formapago : formapago, num_boletos : num_boletos
	}).done(function(response){
		if($.trim(response) == 'ok'){
			window.location = '?modulo=cobrook';
		}else if($.trim(response) == 'okreserva'){
			window.location = '?modulo=cobroreservaok';
		}else{
			var mywindow = window.open('', 'Receipt', 'height=400,width=600');
			mywindow.document.write('<html><head><title></title>');
			mywindow.document.write('</head><body >');
			mywindow.document.write(response);
			mywindow.document.write('</body></html>');

			mywindow.print();
			mywindow.close();
			window.location = '?modulo=cobrook';
		}
	});
}
</script>