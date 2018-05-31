<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<?php 
	session_start();
	echo $_SESSION['codigoCompra'];
	echo "<input type ='hidden' id='smsPago' value='".utf8_encode($_SESSION['smsPago'])."' />";
	echo "<input type ='hidden' id='content3' value='".utf8_encode($_SESSION['content3'])."' />";
	echo "<input type ='hidden' id='content4' value='".utf8_encode($_SESSION['content4'])."' />";
	echo "<input type ='hidden' id='codigoCompra' value='".utf8_encode($_SESSION['codigoCompra'])."' />";
	include("controlusuarios/seguridadusuario.php");
	$error = $_REQUEST['error'];
	if($error != 'ok'){
		echo '<input type="hidden" id="error" value="'.$error.'" />';
	}
?>
<div style="background-color:#282B2D; margin:10px 20px 0px 20px; text-align:center;">
	<div class="breadcrumb">
		<a id="chooseseat" href="#" onclick="security()">Escoge tu asiento</a>
		<a id="identification" href="#" onclick="security()">Identificate</a>
		<a id="buy" href="#" onclick="security()">Resumen de Compra</a>
		<a id="pay" href="#" onclick="security()">Pagar</a>
		<a class="active" id="confirmation" href="#" onclick="security()">Confirmaci&oacute;n</a>
	</div>
</div>
<div style="margin:-10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<?php if($error == 'ok'){?>
			<div style="background-color:#00AEEF; margin-right:60%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Confirmaci&oacute;n</strong>
			</div>
			<div style="background-color:#EC1867; margin:20px -42px 50px 60%; font-size:25px; position:relative; color:#fff;">
				<img src="imagenes/facehappy.png" alt="" />En hora buena!!!
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 40px 40px; position:relative; padding:40px 40px 40px 0px;">
				<table style="width:100%; margin:20px; color:#fff; font-size:25px; border-collapse:separate; border-spacing:0px 20x;">
					<tr>
						<td style="text-align:center;">
							<img src="imagenes/imgmail.png" alt=""/>
						</td>
					</tr>
					<tr align="center">
						<td> 
							<p>Hemos enviado el detalle de tu reserva a tu correo electrónico</p>
							<p>Realiza tu pago lo mas pronto posible</p>
							<p>o perderas tus boletos para el evento...</p>
						</td>
					</tr>
					<tr align="center">
						<td>
							<br>
							<p><span class="btn_login" style="text-decoration:none;"><strong>Gracias por usar nuestros servicios</strong></span></p>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<?php }?>
		</div>
		
	</div>
</div>
<script>


$(document).ready(function(){
	// if($('#error').length){
		// $('#alerta2').fadeIn();
		// $('#aviso').modal('show');
	// }
	setTimeout(function() {
		var smsPago = $('#smsPago').val();
		//alert(smsPago);
		var content3 = $('#content3').val();
		var content4 = $('#content4').val();
		var codigoCompra = $('#codigoCompra').val();
		var codigoCompraExp = codigoCompra.split("|");
		for (var i = 0, length = codigoCompraExp.length; i < length; i++) {
			var cadaBoleto = codigoCompraExp[i];
			if(cadaBoleto != ''){
				// alert('<img src="http://www.ticketfacil.ec/pagekiosko/subpages/Compras/barcode/'+codigoCompraExp[i]+'.png"/>');
				$.post('subpages/Compras/impPV.php',{
					cadaBoleto : cadaBoleto
				}).done(function(data){
					//console.log(data)
					// var mywindow = window.open('', 'Receipt', 'height=900,width=600');
					// mywindow.document.write('<html><head><title></title>');
					// mywindow.document.write('</head><body >');
					// mywindow.document.write(data);
					// mywindow.document.write('</body></html>');
					// mywindow.print();
					// mywindow.close();
				});
			}
		}
	}, 3000);
	//window.location = 'controlusuarios/salir.php';
	
	
	setTimeout(function() {
		window.location.href='controlusuarios/salir.php';
	}, 10000);
	$( "html, body " ).animate({
		scrollTop: '300px',
	}, 3000, function() {
		
	});
});

function security(){
	$('#alerta1').fadeIn();
	$('#aviso').modal('show');
}
function aceptarModal(){
	if(!$('#alerta2').is(':hidden')){
		window.location = '?modulo=des_concierto&con='+<?php echo $error;?>;
	}
	$('.alertas').fadeOut();
	$('#aviso').modal('hide');
}
</script>