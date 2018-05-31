<?php 
	//include("controlusuarios/seguridadDis.php");
	session_start();
	//echo $_SESSION['losBoletos'];
	echo '<input type="hidden" id="losBoletos" value= "'.$_SESSION['losBoletos'].'" />';
	echo '<input type="hidden" id="data" value="1" />';
?>
<div style="margin:-10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#00AEEF; margin-right:60%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Confirmaci&oacute;n</strong>
			</div>
			<div style="background-color:#EC1867; margin:20px -42px 50px 60%; font-size:25px; position:relative; color:#fff;">
				<img src="imagenes/facehappy.png" alt="" />En hora buena!!!
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
		<?php
			if($_SESSION['losBoletos']!='electronico|'){
		?>
			<div style="background-color:#00ADEF; margin:20px -42px 40px 40px; position:relative; padding:40px 40px 40px 0px;">
				<table style="width:100%; margin:20px; color:#fff; font-size:25px; border-collapse:separate; border-spacing:0px 20x;">
					<tr align="center">
						<td>
							<p>El cobro de sus tickets se realizó con éxito...!</p>
						</td>
					</tr>
					
					<tr>
						<td style="text-align:center;">
							<img src="imagenes/imgmail.png" alt=""/>
						</td>
					</tr>
					<tr align="center">
						<td>
							<p>Gracias por preferirnos</p>
							<p>TICKETFACIL <I>"La mejor experiencia de compra En Línea"</I></p>
						</td>
					</tr>
					<tr align="center">
						<td>
							<br>
							<p><a href="?modulo=reservasDistribuidor" class="btn_login" style="text-decoration:none;"><strong>FINALIZAR</strong></a></p>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		<?php
			}if($_SESSION['losBoletos']=='electronico|'){
		?>
			<div style="background-color:#00ADEF; margin:20px -42px 40px 40px; position:relative; padding:40px 40px 40px 0px;">
				<table style="width:100%; margin:20px; color:#fff; font-size:25px; border-collapse:separate; border-spacing:0px 20x;">
					<tr align="center">
						<td>
							<p>El cobro de sus tickets se realizó con éxito...!</p>
						</td>
					</tr>
					
					<tr align="center">
						<td>
							<p>Se ha enviado el detalle de su pago a su correo electrónico , </p>
						</td>
					</tr>
					
					<tr>
						<td style="text-align:center;">
							<img src="imagenes/imgmail.png" alt=""/>
						</td>
					</tr>
					<tr align="center">
						<td>
							<p>Gracias por preferirnos</p>
							<p>TICKETFACIL <I>"La mejor experiencia de compra En Línea"</I></p>
						</td>
					</tr>
					<tr align="center">
						<td>
							<br>
							<p><a href="?modulo=reservasDistribuidor" class="btn_login" style="text-decoration:none;"><strong>FINALIZAR</strong></a></p>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		<?php
			}
		?>
		</div>
	</div>
</div>
<script>
	$( document ).ready(function() {
		console.log( "ready!" );
		setTimeout(function() {
			var losBoletos = $('#losBoletos').val();
			var entExp = losBoletos.split("|");
			for (var i = 0, length = entExp.length; i < length; i++) {
				var cadaBoleto = entExp[i];
				if(cadaBoleto != ''){
					// $.post('template/impresionDistribuidor.php',{
							// cadaBoleto : cadaBoleto
						// }).done(function(data){
							// //alert(data);
							// var mywindow = window.open('', 'Receipt', 'height=900,width=600');
							// mywindow.document.write('<html><head><title></title>');
							// mywindow.document.write('</head><body >');
							// mywindow.document.write(data);
							// mywindow.document.write('</body></html>');
							// mywindow.print();
							// mywindow.close();
						// });
						// setTimeout(function() {
							// window.location.href='index.php?modulo=distribuidorMod';
						// }, 5000);
					// if(cadaBoleto == 'electronico'){
						// $.post('template/impresionDistribuidor.php',{
							// cadaBoleto : cadaBoleto
						// }).done(function(data){
							// //alert(data);
							// var mywindow = window.open('', 'Receipt', 'height=900,width=600');
							// mywindow.document.write('<html><head><title></title>');
							// mywindow.document.write('</head><body >');
							// mywindow.document.write(data);
							// mywindow.document.write('</body></html>');
							// mywindow.print();
							// mywindow.close();
						// });
						// setTimeout(function() {
							// window.location.href='index.php?modulo=distribuidorMod';
						// }, 5000);
					// }else{
						// // alert(cadaBoleto);
						// $.post('template/impresion.php',{
							// cadaBoleto : cadaBoleto
						// }).done(function(data){
							// //alert(data);
							// var mywindow = window.open('', 'Receipt', 'height=900,width=600');
							// mywindow.document.write('<html><head><title></title>');
							// mywindow.document.write('</head><body >');
							// mywindow.document.write(data);
							// mywindow.document.write('</body></html>');
							// mywindow.print();
							// mywindow.close();
						// });
						// setTimeout(function() {
							// window.location.href='index.php?modulo=distribuidorMod';
						// }, 5000);
					// }
				}
			}
				
		}, 4000);
		$( "html, body " ).animate({
			scrollTop: '300px',
		}, 3000, function(){});
		
		// setTimeout(function() {
			// window.location.href='controlusuarios/salir.php';
		// }, 12000);
	});
</script>