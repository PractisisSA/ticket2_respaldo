<?php 
	session_start();
	include("controlusuarios/seguridadusuario.php");
	$error = $_GET['error'];
	if($error != 'ok'){
		echo '<input type="hidden" id="error" value="'.$error.'" />';
	}
	
	echo '<input type="hidden" id="codigoCompra" value="'.$_SESSION['codigoCompra'].'" />';
	
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
					<tr align="center">
						<td>
							<p>Te enviamos los datos del dep&oacute;sito a tu Correo Electr&oacute;nico</p>
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<img src="imagenes/imgmail.png" alt=""/>
						</td>
					</tr>
					<tr align="center">
						<td>
							<p>Realiza tu dep&oacute;sito lo mas pronto posible...</p>
							<p>O perderas tus boletos para el concierto...</p>
						</td>
					</tr>
					<tr align="center">
						<td>
							<br>
							<p><a href="?modulo=start" class="btn_login" style="text-decoration:none;"><strong>HOME</strong></a></p>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<?php }?>
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
							<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;El proceso de compra ha concluido, dale click a "HOME".
							</div>
						</h4>
						<h4 id="alerta2" class="alertas" style="display:none;">
							<div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;Uno o mas de tus asientos ya han sido reservados, selecciona otros asientos.
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
<script>
	$(document).ready(function(){
		setTimeout(function() {
			var codigoCompra = $('#codigoCompra').val();
			var codigoCompraExp = codigoCompra.split("|");
			for (var i = 0, length = codigoCompraExp.length; i < length; i++) {
				var cadaBoleto = codigoCompraExp[i];
				if(cadaBoleto != ''){
					// alert('<img src="http://www.ticketfacil.ec/pagekiosko/subpages/Compras/barcode/'+codigoCompraExp[i]+'.png"/>');
					$.post('subpages/Compras/impBolDeposito.php',{
						cadaBoleto : cadaBoleto
					}).done(function(data){
						var mywindow = window.open('', 'Receipt', 'height=900,width=600');
						mywindow.document.write('<html><head><title></title>');
						mywindow.document.write('</head><body >');
						mywindow.document.write(data);
						mywindow.document.write('</body></html>');
						mywindow.print();
						mywindow.close();
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
$(document).ready(function(){
	if($('#error').length){
		$('#alerta2').fadeIn();
		$('#aviso').modal('show');
	}
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