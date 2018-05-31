<?php
	session_start();
	include("controlusuarios/seguridadusuario.php");
	require_once('stripe/lib/Stripe.php');
	Stripe::setApiKey('sk_test_6GSRONySlv39WktvlN4ZloaH');
	
	
	
	$id_cliente = $_SESSION['id'];
	$idConcierto = $_GET['evento'];
	$preciototal = $_POST['total_pagar'];
	if($preciototal == ''){
		echo "<script>$('#alerta6').fadeIn(); $('#aviso').modal('show');</script>";
	}
	$nombre_cli = $_SESSION['username'];
	$documento_cli = $_SESSION['userdoc'];
	$cantidadboletos = $_POST['num_boletos'];
	if(isset($_POST['codigo'])){
		echo '<table>';
		foreach($_POST['codigo'] as $key=>$cod_loc){
			echo'<tr class="datos_compra">
				<td><input type="hidden" class="codigo" name="codigo" value="'.$cod_loc.'" /></td>
				<td><input type="hidden" class="row" name="row" value="'.$_POST['row'][$key].'" /></td>
				<td><input type="hidden" class="col" name="col" value="'.$_POST['col'][$key].'" /></td>
				<td><input type="hidden" class="chair" name="chair" value="'.$_POST['chair'][$key].'" /></td>
				<td><input type="hidden" class="des" value="'.$_POST['des'][$key].'"/></td>
				<td><input type="hidden" class="num" value="'.$_POST['num'][$key].'" /></td>
				<td><input type="hidden" class="pre" value="'.$_POST['pre'][$key].'"/></td>
				<td><input type="hidden" class="tot" value="'.$_POST['tot'][$key].'" /></td>
			</tr>';
		}
		echo '</table>';
	}
	
	echo '<input type="hidden" id="data" value="3" />';
?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
	Stripe.setPublishableKey('pk_test_5FTqncYge9eCygTZMlBz2qqk');

	var stripeResponseHandler = function(status, response) {
		var $form = $('#payment-form');
		if(response.error){
			var errorMsg = '';
			if(response.error.message == 'Your card number is incorrect.'){
				errorMsg = 'Su número de tarjeta es incorrecto.';
				}
			else if(response.error.message == 'Your card\'s expiration year is invalid.'){
				errorMsg = 'La fecha de vencimiento de su tarjeta no es válida.';
				}
			else if(response.error.message == 'Your card\'s security code is invalid.'){
				errorMsg = 'Código de seguridad de su tarjeta no es válida.';
				}
			else if(response.error.message == 'This card number looks invalid'){
				errorMsg = 'Su número de tarjeta es incorrecto.';
				}
			else if(response.error.message == 'Your card\'s expiration month is invalid.'){
				errorMsg = 'La fecha de vencimiento de su tarjeta no es válida.';
				}
			else{
				errorMsg = response.error.message;
				}
		
			$form.find('.payment-errors').text(errorMsg);
			$form.find('button').prop('disabled', false);
			$('#imgif').fadeOut('slow');
			$('#submitPayment').delay(600).fadeIn('slow');
			}
		else{
			var token = response.id;
			var concert_id = $('#concert_id').val();
			var total = $('#total').val();
			var cant = $('#cant').val();
			var valores = '';
			$('.datos_compra').each(function(){
				var codigo = $(this).find('td .codigo').val();
				var row = $(this).find('td .row').val();
				var col = $(this).find('td .col').val();
				var chair = $(this).find('td .chair').val();
				var des = $(this).find('td .des').val();
				var num = $(this).find('td .num').val();
				var pre = $(this).find('td .pre').val();
				var tot = $(this).find('td .tot').val();
				valores += codigo +'|'+ chair +'|'+ des +'|'+ num +'|'+ pre +'|'+ tot +'|'+ row +'|'+ col +'|'+'@';
			});
			var valFor = valores.substring(0,valores.length -1);
			$form.append($('<input type="hidden" name="stripeToken" />').val(token));
			$('#loading').show();
			
			// var counter = 0;
			// var dynString = ''; 
				// $('.misids').each(function(){
				// dynString += 'code'+ counter +'='+ $(this).val() +'&';
				// counter++;
				// });
			
			// var stringFormatted = dynString.substring(0,dynString.length -1);
			
			
			$.post('subpages/Compras/ajaxChargeCard.php',{
				token : token , concert_id : concert_id , total : total , cant : cant , valFor : valFor
			}).done(function(data){
				//alert(data);
				$('#alerta1').fadeIn();
				$('#aviso').modal('show');
				$('#recibedetalledeBoletosVendidos').append(data);
			});


			// $.ajax({
				// type: 'POST',
				// url: 'subpages/Compras/ajaxChargeCard.php',
				// data: 'token='+ token +'&concert_id='+ concert_id +'&total='+ total +'&cant='+ cant +'&valores='+ valFor,
				// success: function(response){
					// // if($.trim(response) == 'ok'){
						// $('#alerta1').fadeIn();
						// $('#aviso').modal('show');
					// // }else if($.trim(response) == 'okerror'){
						// // $('#alerta7').fadeIn();
						// // $('#aviso').modal('show');
					// // }
					// $('#recibeBoletosVendidos').val(data);
				// }
			// });
		}
	};

jQuery(function($){
	$('#payment-form').submit(function(e){
		var $form = $(this);
		$form.find('button').prop('disabled', true);
		Stripe.card.createToken($form, stripeResponseHandler);
		$('#submitPayment').fadeOut('slow');
		$('#imgif').delay(600).fadeIn('slow');
		return false;
		});
	});
</script>
<div style="background-color:#282B2D; margin:10px 20px 0px 20px; text-align:center;">
	<div class="breadcrumb">
		<a id="chooseseat" href="?modulo=des_concierto&con=<?php echo $idConcierto;?>" onclick="chooseasientos()">Escoge tu asiento</a>
		<a id="identification" href="#" onclick="identity()">Identificate</a>
		<a id="buy" href="?modulo=comprar&con=<?php echo $idConcierto;?>" onclick="buy()">Resumen de Compra</a>
		<a class="active" id="pay" href="#" onclick="security()">Pagar</a>
		<a id="confirmation" href="#" onclick="security()">Confirmaci&oacute;n</a>
	</div>
</div>
<input type="hidden" id="concert_id" value="<?php echo $idConcierto;?>"/>
<input type="hidden" id="cant" value="<?php echo $cantidadboletos;?>" />
<input type="hidden" name="total" id="total" value="<?php echo $preciototal;?>" />
<input type="hidden" id="CuentaAtras" style="border:none;background:url(http://subtlepatterns.com/patterns/otis_redding.png);"/>
<div style="border:2px; solid #000; margin:-10px 10px;">
	<div style="background-color:#fff; padding:20px;">
		<div style="margin:0px 20px;">
			<table style="width:100%;">
				<tr>
					<td style="text-align:left; vertical-align:middle; width:50%;">
						<img src="imagenes/logopacificard.png" alt="" />
					</td>
					<td style="text-align:right;">
						<img src="imagenes/ticketfacilnegro.png" alt="" />
					</td>
				</tr>
			</table>
		</div>
		<div style="border: 2px solid #000; margin:20px;">
			<div style="margin:40px; border:2px solid #000; color:#000; font-size:20px;">
				<div class="row">
					<div class="col-lg-4"></div>
					<div class="col-lg-4" style="text-align:center; background-color:#00ADEF; color:#fff; font-size:20px; padding:15px 5px;">
						<strong>Pago por Tarjeta de Cr&eacute;dito</strong>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12" style="color:#000; text-align:center;">
						<strong>Datos de Compra</strong>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 titleleft" style="margin:0px; padding:10px;">
						<p><strong>Empresa: </strong></p>
					</div>
					<div class="col-lg-6 titleright" style="margin:0px; padding:10px;">
						<p><strong>TICKETFACIL VENTAS EN L&Iacute;NEA</strong></p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 titleleft" style="margin:0px; padding:10px;">
						<p><strong>Cliente: </strong></p>
					</div>
					<div class="col-lg-6 titleright" style="margin:0px; padding:10px;">
						<p><?php echo $nombre_cli;?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 titleleft" style="margin:0px; padding:10px;">
						<p><strong>Documento de Identidad: </strong></p>
					</div>
					<div class="col-lg-6 titleright" style="margin:0px; padding:10px;">
						<p><?php echo $documento_cli;?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 titleleft" style="margin:0px; padding:10px;">
						<p><strong>Monto total a pagar: </strong></p>
					</div>
					<div class="col-lg-6 titleright" style="margin:0px; padding:10px;">
						<p><?php echo $preciototal;?></p>
					</div>
				</div>
			</div>
			<div style="margin:0px 40px 40px 40px; border:2px solid #000; color:#000; font-size:20px;">
				<form action="" method="POST" id="payment-form">
					<div class="row">
						<div class="col-lg-2"></div>
						<div class="col-lg-7" style="text-align:center; background-color:#00ADEF; color:#fff; font-size:20px; padding:15px 5px;">
							<strong>Datos de la Tarjeta de Cr&eacute;dito</strong>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12" style="margin:0px; text-align:center; padding:40px 0px;">
							<span class="payment-errors" style="color:red;"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6" style="margin:0px; text-align:center; padding:10px;">
							<p><strong>Tipo de Tarjeta</strong></p>
							<select class="form-control">
								<option>Selecc	ionar</option>
								<option value="dinners">Dinners Club</option>
								<option value="master">Master Card</option>
								<option value="visa">Visa</option>
							</select>
						</div>
						<div class="col-lg-6" style="margin:0px; text-align:center; padding:10px;">
							<p><strong>Número de tarjeta:</strong></p>
							<input class="form-control" placeholder="Digita el número de tu tarjeta" onkeydown="justInt(event,this);" type="text" maxlength="20" data-stripe="number"/>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6" style="margin:0px; text-align:center; padding:10px;">
							<p><strong>C&oacute;digo de Seguridad:</strong></p>
							<input class="form-control" placeholder="CVC" type="text" onkeydown="justInt(event,this);" maxlength="4" data-stripe="cvc"/>
						</div>
						<div class="col-lg-6" style="margin:0px; text-align:center; padding:10px;">
							<p><strong>Fecha expiraci&oacute;n (MM/AAAA):</strong></p>
							<div class="row" style="padding-left: 80px;">
								<div class="col-xs-4" style="margin:0px; padding:0px 5px;">
									<input class="form-control" placeholder="Mes(MM)" type="text" maxlength="2" onkeydown="justInt(event,this);" data-stripe="exp-month"/>
								</div>
								<div class="col-xs-1" style="margin:0px; padding:0px 5px;">
									<span><strong>/</strong></span>
								</div>
								<div class="col-xs-5" style="margin:0px; padding:0px 5px;">
									<input class="form-control" placeholder="Año(AAAA)" type="text" maxlength="4" onkeydown="justInt(event,this);" data-stripe="exp-year"/>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12" style="margin:0px; text-align:center; padding:40px 0px;">
							<button id="submitPayment" type="submit" class="btn_login">ENVIAR PAGO</button>
							<img src="imagenes/loading.gif" alt="" id="imgif" style="display:none; max-width:80px;" />
						</div>
					</div>
				</form>
			</div>
			<div style="margin:0px 40 20px 40px; text-align:center;">
				<img src="imagenes/tarjetas.png" style="max-width:270px;"/>&nbsp;
				<img src="imagenes/dinners.png" style="max-width:70px; margin-left:-15px; margin-top:-7px" />&nbsp;
				<img src="imagenes/Pacificard.gif" style="max-width:180px; margin-left:-13px; margin-top:-1px;" />
			</div>
			<div style="margin:0px 40 40px 40px; text-align:center;">
				<img src="imagenes/faceandtiwt.png" style="max-width:70px;" alt="" />
			</div>
			<div class="modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
						</div>
						<div class="modal-body">
							<h4 id="alerta1" class="alertas" style="display:none;">
								<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Excelente!</strong>&nbsp;Tu pago se ha completado con exito.
								</div>
							</h4>
							<h4 id="alerta2" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;El tiempo de la transacción ha terminado.
								</div>
							</h4>
							<h4 id="alerta3" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Debes volver a seleccionar tus asientos.
								</div>
							</h4>
							<h4 id="alerta4" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;En este paso ya no puedes modificar tus datos.
								</div>
							</h4>
							<h4 id="alerta5" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Llena el formulario y dale click en "ENVIAR PAGO".
								</div>
							</h4>
							<h4 id="alerta6" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert">
									<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Los asientos seleccionados se han perdido, seleccionalos nuevamente.
								</div>
							</h4>
							<h4 id="alerta7" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert">
									<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Uno o mas de tus asientos ya se han reservado.<br>
									Vuelve a escoger tus asientos.
								</div>
							</h4>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarModal()">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>		
<script type="text/javascript">
$(document).ready(function(){
	$(window).resize(function(){
		var width = $(window).width();
		if(width < 1024){
			$('.titleright').css({'text-align':'center'});
			$('.titleleft').css({'text-align':'center'});
		}else{
			$('.titleleft').css({'text-align':'right'});
			$('.titleright').css({'text-align':'left'});
		}
	});
	var width = $(window).width();
	if(width < 1024){
		$('.titleright').css({'text-align':'center'});
		$('.titleleft').css({'text-align':'center'});
	}else{
		$('.titleleft').css({'text-align':'right'});
		$('.titleright').css({'text-align':'left'});
	}
});

var idcon = $('#concert_id').val();
var preciot = $('#total').val();
if(preciot === ''){
	window.location = '?modulo=des_concierto&con='+idcon;
}

function justInt(e,value){
	if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46)){
		return;
	}
	else{
		e.preventDefault();
	}
}

function chooseasientos(){
	$('#alerta3').fadeIn();
	$('#aviso').modal('show');
}

function identity(){
	$('#alerta4').fadeIn();
	$('#aviso').modal('show');
}

function security(){
	$('#alerta5').fadeIn();
	$('#aviso').modal('show');
}

function aceptarModal(){
	var recibeBoletosVendidos = $('#recibedetalledeBoletosVendidos').html();
	if(!$('#alerta1').is(':hidden')){
		window.location = '?modulo=pagotarjetaok';
	}else if(!$('#alerta2').is(':hidden')){
		window.location = '?modulo=des_concierto&con='+idcon;
	}else if(!$('#alerta3').is(':hidden')){
		window. location = '?modulo=des_concierto&con='+idcon;
	}else if(!$('#alerta6').is(':hidden')){
		window. location = '?modulo=des_concierto&con='+idcon;
	}else if(!$('#alerta7').is(':hidden')){
		window. location = '?modulo=des_concierto&con='+idcon;
	}
	$('.alertas').fadeOut();
	$('#aviso').modal('hide');
}

var totalTiempo=200+200;
var timestampStart = new Date().getTime();
var endTime=timestampStart+(totalTiempo*1000);
var timestampEnd=endTime-new Date().getTime();
var tiempRestante=totalTiempo;

updateReloj();

function updateReloj() {
	var Seconds=tiempRestante;
	
	var Days = Math.floor(Seconds / 86400);
	Seconds -= Days * 86400;

	var Hours = Math.floor(Seconds / 3600);
	Seconds -= Hours * (3600);

	var Minutes = Math.floor(Seconds / 60);
	Seconds -= Minutes * (60);

	var TimeStr = ((Days > 0) ? Days + " dias " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds);
	//var TimeStr = LeadingZero(Hours+(Days*24)) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds);
	document.getElementById('CuentaAtras').innerHTML = TimeStr;
	if(endTime<=new Date().getTime())
	{
		document.getElementById('CuentaAtras').innerHTML = "00:00:00";
	}else{
		tiempRestante-=1;
		setTimeout("updateReloj()",1000);
	}
}

function LeadingZero(Time) {
	return (Time < 10) ? "0" + Time : + Time;
}
setTimeout("$('#alerta2').fadeIn(); $('#aviso').modal('show');",480000);
</script>