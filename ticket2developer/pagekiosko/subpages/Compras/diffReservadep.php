<?php 
	include("controlusuarios/seguridadusuario.php");
		
	$gbd = new DBConn();
	
	$idt = $_GET['idt'];
	$estadopago = 'No';
	$estadoDep = 'No';

	$selectCli = "SELECT strNombresC, strMailC, strDocumentoC, intTelefonoMovC, strFormPagoC FROM Reserva JOIN Cliente ON Reserva.idClienteR = Cliente.idCliente WHERE intIdentificateR = ? AND strEstadoR = ? AND pagoDepR = ?";
	$resultSelectCli = $gbd -> prepare($selectCli);
	$resultSelectCli -> execute(array($idt,$estadopago,$estadoDep));
	$rowCli = $resultSelectCli -> fetch(PDO::FETCH_ASSOC);
	
	
	
	$selectEvento = "SELECT strEvento, dateFecha, strLugar, timeHora FROM Reserva JOIN Concierto ON Reserva.idConciertoR = Concierto.idConcierto WHERE intIdentificateR = ? AND strEstadoR = ? AND pagoDepR = ?";
	$resultSelectEvento = $gbd -> prepare($selectEvento);
	$resultSelectEvento -> execute(array($idt,$estadopago,$estadoDep));
	$rowEvento = $resultSelectEvento -> fetch(PDO::FETCH_ASSOC);
	
	$selectCompra = "SELECT strDescripcionL, doublePrecioL, doublePrecioReserva, intFilaR, intColumnaR FROM Reserva JOIN Localidad ON Reserva.idLocalidadR = Localidad.idLocalidad WHERE intIdentificateR = ? AND strEstadoR = ? AND pagoDepR = ?";
	$resultSelectCompra = $gbd -> prepare($selectCompra);
	$resultSelectCompra -> execute(array($idt,$estadopago,$estadoDep));
	
	$selectTotales = "SELECT totalPagadoR, DiferenciaR FROM Reserva WHERE intIdentificateR = ? AND strEstadoR = ? AND pagoDepR = ?";
	$resultTotales = $gbd -> prepare($selectTotales);
	$resultTotales -> execute(array($idt,$estadopago,$estadoDep));
	$rowTotales = $resultTotales -> fetch(PDO::FETCH_ASSOC);
	
	$comprobar_pago = $resultSelectCli -> rowCount();
	if($comprobar_pago == 0){
		echo "<script>
				alert('Tu reserva ya fue cancelada');
				window.location='?modulo=start';
			</script>";
	}
?>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/>
<script src="js/jquery.datetimepicker.js"></script>
<script src="js/jquery.ui.draggable.js" type="text/javascript"></script>
<div style="margin:10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<form id="form1" action="" method="post">
			<input type="hidden" id="cod" value="<?php echo $idt;?>" />
			<div style="border: 2px solid #00AEEF; margin:20px;">
				<div style="background-color:#EC1867; margin-right:50%; margin-top:20px; padding-left:30px; font-size:20px; color:#fff;">
					<strong>Informaci&oacute;n de Pago por Reserva</strong>
				</div>
				<div style="background-color:#EC1867; margin:30px -42px 10px 600px; font-size:20px; color:#fff; position:relative; padding:10px; text-align:center;">
					Datos del Cliente
					<div class="tra_comprar_concierto"></div>
					<div class="par_comprar_concierto"></div>
				</div>
				<div style="background-color:#00ADEF; margin-left:40px; margin-top:20px; margin-right:-42px; position:relative; padding: 20px 50px 10px 20px;">
					<table class="table-response" style="width:100%; color:#fff; font-size:18px; border-collapse: separate; border-spacing: 20px 15px;">
						<tr>
							<td colspan="3" style="text-align:center">
								<p>Sr(a). <strong><?php echo $rowCli['strNombresC'];?></strong></p>
								<input type="hidden" id="nameCli" name="nameCli" value="<?php echo $rowCli['strNombresC'];?>"/>
							</td>
						</tr>
							<td style="text-align:center;">
								<p>Documento de Identidad: </p>
								<strong><?php echo $rowCli['strDocumentoC'];?></strong>
								<input type="hidden" id="docCli" name="docCli" value="<?php echo $rowCli['strDocumentoC'];?>"/>
							</td>
							<td style="text-align:center">
								<p>E-mail: </p>
								<strong><?php echo $rowCli['strMailC'];?></strong>
							</td>
							<td style="text-align:center">
								<p>Tel&eacute;fono M&oacute;vil: </p>
								<strong><?php echo $rowCli['intTelefonoMovC'];?></strong>
							</td>
						<tr>
						</tr>
					</table>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div style="background-color:#EC1867; margin:30px 600px 10px -42px; font-size:20px; color:#fff; position:relative; padding:10px; text-align:center;">
					Datos del Evento
					<div class="tra_izq_rojo"></div>
					<div class="par_iz_rojo"></div>
				</div>
				<div style="background-color:#00AEEF; margin:20px 30px 20px -42px; position: relative;">
					<table class="table-response" style="width:100%; color:#fff; font-size:18px; border-collapse: separate; border-spacing: 20px 15px; margin:0 50px; padding-right:50px;">
						<tr>
							<td style="text-align:center">
								<p>Evento: </p>
								<p><font size="5"><strong><?php echo $rowEvento['strEvento'];?></strong></font></p>
							</td>
							<td style="text-align:center;">
								<p>Lugar: </p>
								<p><strong><?php echo $rowEvento['strLugar'];?></strong></p>
							</td>
							<td style="text-align:center">
								<p>Fecha: </p>
								<p><font size="4"><strong><?php echo $rowEvento['dateFecha'];?></strong></font></p>
							</td>
							<td style="text-align:center">
								<p>Hora: </p>
								<p><font size="4"><strong><?php echo $rowEvento['timeHora'];?></strong></font></p> 
							</td>
						</tr>
					</table>
					<div class="tra_video_concierto"></div>
					<div class="par_video_concierto"></div>
				</div>
				<div style="background-color:#EC1867; margin:30px -42px 10px 600px; font-size:20px; color:#fff; position:relative; padding:10px; text-align:center;">
					Informaci&oacute;n de Compra
					<div class="tra_comprar_concierto"></div>
					<div class="par_comprar_concierto"></div>
				</div>
				<div style="background-color:#00ADEF; margin-left:40px; margin-top:20px; margin-right:-42px; position:relative; padding: 20px 50px 10px 20px;">
					<table class="table-response" style="width:100%; color:#fff; font-size:18px; border-collapse: separate; border-spacing: 20px 15px;">
						<tr>
							<td style="text-align:center">
								<strong>Localidad</strong>
							</td>
							<td style="text-align:center">
								<strong>Asientos #</strong>
							</td>
							<td style="text-align:center">
								<strong>Cantidad de Boletos</strong>
							</td>
							<td style="text-align:center">
								<strong>Precio Normal</strong>
							</td>
							<td style="text-align:center">
								<strong>Precio Reserva</strong>
							</td>
						</tr>
						<?php while($rowCompra = $resultSelectCompra -> fetch(PDO::FETCH_ASSOC)){?>
						<tr>
							<td style="text-align:center">
								<?php echo $rowCompra['strDescripcionL'];?>
							</td>
							<td style="text-align:center">
								FILA-<?php echo $rowCompra['intFilaR'];?>_SILLA-<?php echo $rowCompra['intColumnaR'];?>
							</td>
							<td style="text-align:center">
								1
							</td>
							<td style="text-align:center">
								<?php echo $rowCompra['doublePrecioL'];?>
							</td>
							<td style="text-align:center">
								<?php echo $rowCompra['doublePrecioReserva'];?>
							</td>
						</tr>
						<?php }?>
						<tr style="font-size:20px;">
							<td style="text-align:center" colspan="3">
								TOTALES
							</td>
							<td style="text-align:center">
								<strong><?php echo $rowTotales['DiferenciaR'];?></strong>
							</td>
							<td style="text-align:center">
								<strong><?php echo $rowTotales['totalPagadoR'];?></strong>
							</td>
						</tr>
						<tr>
							<td colspan="5" style="text-align:center; font-size:20px;">
								<?php 
									$totalnormal = $rowTotales['DiferenciaR'];
									$totalreserva = $rowTotales['totalPagadoR'];
									$pagar = $totalnormal - $totalreserva;
									$pagar = number_format($pagar, 2,'.','');
								?>
								<strong>El Valor a pagar es: &nbsp;&nbsp;&nbsp;</strong><strong style="font-size:30px">$<?php echo $pagar;?></strong>
								<input type="hidden" id="valReserva" name="valReserva" value="<?php echo $pagar;?>"/>
							</td>
						</tr>
					</table>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div style="margin:20px; border:2px solid #00ADEF; padding:20px;">
					<table class="table-response" style="width:100%; color:#fff; font-size:18px; border-collapse: separate; border-spacing: 20px 15px; font-size:22px;">
						<tr>
							<td style="text-align:right;">
								<strong>FORMA DE PAGO:</strong>
							</td>
							<td>
								<select class="inputlogin" id="formpayreserva">
									<option value="0">Seleccione...</option>
									<?php if($rowCli['strFormPagoC'] == 1){?>
									<option value="<?php echo $rowCli['strFormPagoC'];?>">Tarjeta de Crédito</option>
									<option value="2">Depósito Bancario</option>
									<?php }else if($rowCli['strFormPagoC'] == 2){?>
									<option value="1">Tarjeta de Crédito</option>
									<option value="<?php echo $rowCli['strFormPagoC'];?>">Depósito Bancario</option>
									<?php }else{?>
									<option value="1">Tarjeta de Crédito</option>
									<option value="2">Depósito Bancario</option>
									<?php }?>
								</select>
							</td>
						</tr>
						<tr>
							<td style="text-align:right;">
								<p class="paydep"><strong># de Dep&oacute;sito: </strong></p>
							</td>
							<td>
								<input type="text" class="inputlogin paydep" name="ndeposito" id="ndeposito" onkeydown="justInt(event,this);"/>
							</td>
						</tr>
						<tr>
							<td style="text-align:right;">
								<p class="paydep"><strong>Fecha: </strong></p>
							</td>
							<td>
								<input type="text" class="inputlogin paydep" name="fecha" id="fecha" placeholder="AAAA-MM-DD" />
							</td>
						</tr>
						<tr style="text-align:center;">
							<td colspan="2">
								<button type="" id="paybydep" class="btndegradate paydep">Registrar Dep&oacute;sito</button>
							</td>
						</tr>
						<tr style="text-align:center;">
							<td colspan="2">
								<button type="" class="btndegradate" id="aceptar"><span>PAGAR</span></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	var cod = $('#cod').val();
	$(document).ready(function(){
		$('#fecha').datetimepicker({
			timepicker: false,
			minDate:0,
			mask:true,
			format:'Y/m/d',
			minDate: '-1970/05/02',
			maxDate: '0'
		});
		
		var codigo = $('#cod').val();
		$('.paydep').css('display','none');
		$('#aceptar').css('display','none');
		var payform = $('#formpayreserva').val();
		if(payform == 1){
			$('#aceptar').fadeIn('fast');
			$('#aceptar').attr('type','submit');
			var acciona = '?modulo=pagotarReserva&con='+codigo;
			$('#form1').attr('action',acciona);
		}else if(payform == 2){
			$('.paydep').fadeIn('fast');
			$('#paybydep').attr('type','submit');
			var acciona = 'pagodepositoReserva.php?con='+codigo;
			$('#form1').attr('action',acciona);
		}
	});
	
	$('#formpayreserva').on('change',function(){
		var valuepayform = $('#formpayreserva').val();
		if(valuepayform == 1){
			$('#aceptar').fadeIn('fast');
			$('#aceptar').attr('type','submit');
			var accion = '?modulo=pagotarReserva&con='+cod;
			$('#form1').attr('action',accion);
			$('#paybydep').attr('type','');
			$('.paydep').css('display','none');
		}else if(valuepayform == 2){
			$('.paydep').fadeIn('fast');
			$('#paybydep').attr('type','submit');
			var accion = 'pagodepositoReserva.php?con='+cod;
			$('#form1').attr('action',accion);
			$('#aceptar').attr('type','');
			$('#aceptar').css('display','none');
		}
	});
	
	function justInt(e,value){
		if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46)){
			return;
		}
		else{
			e.preventDefault();
		}
	}
</script>