<?php 
	session_start();
	include 'conexion.php';
	echo $_SESSION['losBoletos'];
	echo '<input type="hidden" id="losBoletos" value= "'.$_SESSION['losBoletos'].'" />';
	include("controlusuarios/seguridadDis.php");
	echo '<input type="hidden" id="data" value="1" />';
	$idCon = $_SESSION['idConcVendido'];
	$sqlC = 'select * from Concierto where idConcierto = "'.$idCon.'" ';
	$resC = mysql_query($sqlC) or die (mysql_error());
	$rowC = mysql_fetch_array($resC);
	$tipo_conc = $rowC['tipo_conc'];
	echo '<input type="hidden" id="tipo_conc" value= "'.$tipo_conc.'" />';
	
?>
<div style="margin:0px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; margin:20px -42px 50px 60%; font-size:25px; position:relative; color:#fff;">
				<img src="imagenes/facehappy.png" alt="" />En hora buena!!!
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
			<div style="background-color:#00ADEF; margin: 20px -42px 30px 40px; position:relative; padding:40px 40px 40px 0px;">
				<table style="width:100%; margin:20px; color:#fff; font-size:25px; border-collapse:separate; border-spacing:0px 20x;">
					<tr align="center">
						<td>
							<p>TRANSACCIÓN EXITOSA...</p>
						</td>
					</tr>
				<?php
					if($tipo_conc == 2){
				?>
					<tr align="center">
						<td>
							<p>El ticket del cliente ha sido enviado a su dirección de correo electrónico</p>
						</td>
					</tr>
				<?php
					}if($tipo_conc == 1){
				?>
					<tr align="center">
						<td>
							<p>Espere un momento estamos imprimiendo su ticket!!!</p>
						</td>
					</tr>
				<?php
					}
				?>
					<tr>
						<td style="text-align:center;">
							<img src="imagenes/imgmail.png" alt=""/>
						</td>
					</tr>
					<tr align="center">
						<td>
							<p>Gracias por preferirnos...</p>
						</td>
					</tr>
					<tr align="center">
						<td>
							<br>
							<p><a href="?modulo=ventasDistribuidor" class="btn_login" style="text-decoration:none;"><strong>VENTAS</strong></a></p>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		</div>
	</div>
</div>
<script>
	$( document ).ready(function() {
		console.log( "ready!" );
		setTimeout(function() {
			var tipo_conc = $('#tipo_conc').val();
			var losBoletos = $('#losBoletos').val();
			var entExp = losBoletos.split("|");
			for (var i = 0, length = entExp.length; i < length; i++) {
				var cadaBoleto = entExp[i];
				if(cadaBoleto != ''){
					if(tipo_conc == 1){
						// alert(cadaBoleto);
						$.post('template/impresion.php',{
							cadaBoleto : cadaBoleto
						}).done(function(data){
							//alert(data);
							var mywindow = window.open('', 'Receipt', 'height=900,width=600');
							mywindow.document.write('<html><head><title></title>');
							mywindow.document.write('</head><body >');
							mywindow.document.write(data);
							mywindow.document.write('</body></html>');
							mywindow.print();
							mywindow.close();
						});
						setTimeout(function() {
							window.location.href='index.php?modulo=distribuidorMod';
						}, 5000);
					}else{
						$.post('subpages/Compras/imprimeBoletoPagoTarjeta.php',{
							cadaBoleto : cadaBoleto
						}).done(function(data){
						});
						setTimeout(function() {
							window.location.href='index.php?modulo=distribuidorMod';
						}, 10000);
					}
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