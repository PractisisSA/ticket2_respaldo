<?php 
	session_start();
	echo $_SESSION['errorPago'];
	// ini_set('display_startup_errors',1);
	// ini_set('display_errors',1);
	// error_reporting(-1);
	//$ent = $_REQUEST['ent'];
	echo "<input type='hidden' id='ent' value= '".$_SESSION['idboletoVendido']."' />";
	$error = $_REQUEST['error'];
	if($error == 404){
		$display1 = 'display:none;';
		$display2 = 'display:block;';
	}else{
		$display1 = 'display:block;';
		$display2 = 'display:none;';
	}
	
	//include("controlusuarios/seguridadusuario.php");
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
		<div style="border: 2px solid #00AEEF; margin:20px;<?php echo $display1;?>">
			<div style="background-color:#00AEEF; margin-right:60%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Confirmaci&oacute;n</strong>
			</div>
			<div style="background-color:#EC1867; margin:20px -42px 50px 550px; font-size:25px; position:relative; color:#fff;">
				<img src="imagenes/facehappy.png" alt="" />En hora buena!!!
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
			<div style="background-color:#00ADEF; margin: 20px -42px 40px 40px; position:relative; padding:40px 40px 40px 0px;">
				<table style="width:100%; margin:20px; color:#fff; font-size:25px; border-collapse:separate; border-spacing:0px 20x;">
					<tr align="center">
						<td>
							<p>TU PAGO HA SIDO CORRECTO...</p>
							
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<img src="imagenes/facehappy.png" alt=""/>
						</td>
					</tr>
					<tr align="center">
						<td>
							Se ha enviado el detalle de tu compra a tu correo electronico
						</td>
					</tr>
					<tr align="center">
						<td>
							<p>Gracias por preferirnos...</p>
							<p>Disfruta el evento!</p>
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
		</div>
		
		<div style="border: 2px solid #00AEEF; margin:20px;<?php echo $display2;?>">
			<div style="background-color:#00AEEF; margin-right:60%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Confirmaci&oacute;n</strong>
			</div>
			<div style="background-color:#EC1867; margin:20px -42px 50px 550px; font-size:25px; position:relative; color:#fff;">
				<img src="imagenes/facehappy.png" alt="" />Atencion!!!
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
			<div style="background-color:#00ADEF; margin: 20px -42px 40px 40px; position:relative; padding:40px 40px 40px 0px;">
				<table style="width:100%; margin:20px; color:#fff; font-size:25px; border-collapse:separate; border-spacing:0px 20x;">
					<tr align="center">
						<td>
							<p>TU PAGO NO SE HA COMPLETADO</p>
							
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<img src="imagenes/facehappy.png" alt=""/>
						</td>
					</tr>
					<tr align="center">
						<td>
							YA NO TENEMOS EN STOCK BOLETOS PARA EL CONCIERTO QUE ELEGISTE 
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
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

$( document ).ready(function() {
    console.log( "ready!" );
	setTimeout(function() {
		var ent = $('#ent').val();
		var entExp = ent.split("|");
		for (var i = 0, length = entExp.length; i < length; i++) {
			var cadaBoleto = entExp[i];
			if(cadaBoleto != ''){
				//alert(cadaBoleto);
				$.post('subpages/Compras/imprimeBoletoPagoTarjeta.php',{
					cadaBoleto : cadaBoleto
				}).done(function(data){
					//alert(data);
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
			
	}, 4000);
	$( "html, body " ).animate({
		scrollTop: '300px',
	}, 3000, function(){});
	
	setTimeout(function() {
		window.location.href='controlusuarios/salir.php';
	}, 20000);
});


function security(){
	$('#alerta1').fadeIn();
	$('#aviso').modal('show');
}
</script>