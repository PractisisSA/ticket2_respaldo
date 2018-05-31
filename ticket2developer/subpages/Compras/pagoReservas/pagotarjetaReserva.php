<?php
	$Cliname = $_POST['nameCli'];
	$Clidoc = $_POST['docCli'];
	$precio = $_POST['valReserva'];
	$codigo = $_GET['con'];
	echo '<input type="hidden" id="name" value="'.$Cliname.'" />
		<input type="hidden" id="doc" value="'.$Clidoc.'" />
		<input type="hidden" id="precio" value="'.$precio.'" />
		<input type="hidden" id="codigo" value="'.$codigo.'" />
	';
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
			$('#submitPayment').css('display','block');
			$('#imgif').css('display','none');
			}
		else{
			var token = response.id;
			var nameCli= $('#name').val();
			var docCli = $('#doc').val();
			var precio = $('#precio').val();
			var codigo = $('#codigo').val();
			
			$form.append($('<input type="hidden" name="stripeToken" />').val(token));
			$('#loading').show();
			
			// var counter = 0;
			// var dynString = '';
				// $('.misids').each(function(){
				// dynString += 'code'+ counter +'='+ $(this).val() +'&';
				// counter++;
				// });
			
			// var stringFormatted = dynString.substring(0,dynString.length -1);
			
			$.ajax({
				type: 'POST',
				url: 'subpages/Compras/pagoReservas/ajaxPayTarjetreserva.php',
				data: 'token='+ token +'&nameCli='+ nameCli +'&docCli='+ docCli +'&precio='+ precio +'&codigo='+ codigo,
				success: function(response){
					alert(response);
					document.location = '?modulo=pagotarjetaok';
					}
				});
			}
		};

jQuery(function($){
	$('#payment-form').submit(function(e){
		var $form = $(this);
		$form.find('button').prop('disabled', true);
		Stripe.card.createToken($form, stripeResponseHandler);
		$('#submitPayment').css('display','none');
		$('#imgif').css('display','block');
		return false;
		});
	});
</script>
<div style="border:2px; solid #000; margin:10px 0px;">
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
			<div style="margin:40px; border:2px solid #000;">
				<div style="text-align:center; margin:20px 200px 0px 200px; padding:5px; background-color:#00ADEF; color:#fff; font-size:20px;">
					<strong>Pago por Tarjeta de Cr&eacute;dito</strong>
				</div>
				<table style="width:100%; margin:0px 20px 20px 20px;; border-collapse:separate; border-spacing:20px 20px; color:#00ADEF; font-size:20px;">
					<tr>
						<td colspan="2" style="text-align:center">
							<strong>Datos de Compra</strong>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							<p><strong>Empresa: </strong></p>
						</td>
						<td>
							<p><strong>TICKETFACIL VENTAS EN L&Iacute;NEA</strong></p>
						</td>
					</tr>
					<tr>
						<td style="text-align:right; width:350px;">
							<p><strong>Cliente: </strong></p>
						</td>
						<td style="text-align:left">
							<p><?php echo $Cliname;?></p>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							<p><strong>Documento de Identidad: </strong></p>
						</td>
						<td style="text-align:left">
							<p><?php echo $Clidoc;?></p>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							<p><strong>Monto total a pagar: </strong></p>
						</td>
						<td style="text-align:left">
							<p><?php echo $precio;?></p>
						</td>
					</tr>
				</table>
			</div>
			<div style="margin:0px 40px 40px 40px; border:2px solid #000;">
				<form action="" method="POST" id="payment-form">
					<div style="text-align:center; margin:20px 200px 0px 200px; padding:5px; background-color:#00ADEF; color:#fff; font-size:20px;">
						<strong>Datos de la Tarjeta de Cr&eacute;dito</strong>
					</div>
					 <table style="width:100%; margin:0px 20px 20px 20px;; border-collapse:separate; border-spacing:20px 20px; color:#00ADEF; font-size:20px;">
						<tr style="text-align:center;">
							<td colspan="2">
								<span class="payment-errors" style="color: red;"></span>
							</td>
						</tr>
						<tr style="text-align:center;">
							<td>
								<strong>Tipo de Tarjeta</strong>
							</td>
							<td style="text-align:center;">
								<div class="form-row">
									<label>
										<span id="cardNumber"><strong>N&uacute;mero de tarjeta:</strong></span>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<select style="background:#00ADEF; color:#fff;">
									<option>Seleccionar</option>
									<option value="dinners">Dinners Club</option>
									<option value="master">Master Card</option>
									<option value="visa">Visa</option>
								</select>
							</td>
							<td style="text-align:center;">
								<input class="payFormData"  onkeydown="justInt(event,this);" type="text" size="20" data-stripe="number"/>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<div class="form-row" style="margin-top: 2px;">
									<label>
										<span id="cardSecurityCode"><strong>C&oacute;digo de Seguridad:</strong></span>
									</label>
								</div>
							</td>
							<td style="text-align:center;">
								<div class="form-row" style="margin-top: 2px;">
									<label>
										<span id="cardExpirationDate"><strong>Fecha expiraci&oacute;n (MM/AAAA):<strong></span>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								<input class="payFormData" type="text" onkeydown="justInt(event,this);" size="4" data-stripe="cvc"/>
							</td>
							<td style="text-align:center;">
								<input class="payFormData" type="text" onkeydown="justInt(event,this);" size="2" data-stripe="exp-month"/>
								<span> / </span>
								<input class="payFormData" type="text" onkeydown="justInt(event,this);" class="numbersOnly" size="4" data-stripe="exp-year"/>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<center><button id="submitPayment" type="submit" class="btn_login">ENVIAR PAGO</button><img src="imagenes/ajax-loader.gif" alt="" id="imgif" style="display:none" /></center>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div style="margin:0px 40 20px 40px; text-align:center;">
				<img src="imagenes/logostarjeta.png" alt=""/>
			</div>
			<div style="margin:0px 40 40px 40px; text-align:center;">
				<img src="imagenes/faceandtiwt.png" alt="" />
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var codigo = $('#codigo').val();
		var nombre = $('#name').val();
		if(nombre == ''){
			window.location.href = '?modulo=pagoReservadep&idt='+codigo;
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