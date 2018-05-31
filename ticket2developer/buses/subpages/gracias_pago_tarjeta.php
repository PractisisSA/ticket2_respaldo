<div class='row' style = 'background-image:url(images/busFondo.jpg);'>
		
		<div class = 'col-md-8'>
			<table width = '90%' height='90%' align = 'center'>
				<tr>
					<td>
						<div class = 'titulo2' style = 'color:#26A9E0;font-family:corbel;font-size:50px;font-weight:300;text-align: center; '>
							GRACIAS POR SU COMPRA<br/><br/>
							<span style = 'color:yellow;font-size:20px;'>
								Se ha enviado el detalle de su compra a su correo electrónico
							</span>
							
							<span style = 'color:#fff;font-size:20px;'>
								Ticketfacil la mejor experiencia de compra en l&iacute;nea.
							</span>
							<?php
								// $fechaInicio = strtotime("2016-11-17");
								// $fechaFin = strtotime("2017-01-17");

								// Recorro las fechas y con la función strotime obtengo los lunes
								// for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400 * 7){
									// echo date("Y-m-d", strtotime('wednesday this week', $i)).'<br>';
								// }
							?>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class = 'col-md-3' style='margin:0;padding:0;'>
			<div class = 'titulo2'>
				<p style = 'color:#26A9E0;font-family:Helvetica;font-size:23pt;font-weight:300;'>
					SOLO EN 3 PASOS LLEGARÁS A TU DESTINO
				</p>
				<hr/>
				<p style = 'color:#fff;font-family:Helvetica;font-size:13pt;font-weight:300;'>
					AGILITA TU COMPRA
					CON LA TARIFA
					MÁS ECONÓMICA
					DEL MERCADO
				</p>
				<br/>
				<!--<table width = '100%'>
					<tr>
						<td style = 'color:#fff;font-size:15pt;font-family:Helvetica;font-weight:bold;' colspan = '3' >
							SELECCIONA
						</td>
					</tr>
					<tr>
						<td><img src = 'images/triangulo.png' /></td>
						<td><img src = 'images/btnIda.png' /></td>
						<td><img src = 'images/btnRegreso.png' /></td>
					</tr>
				</table>-->
				<img src = 'images/siguiente.png' style = 'margin-left:-35px;cursor:pointer;display:none;' id = 'posSigui'/>
			</div>
		</div>
	</div>
	<script>
		$( document ).ready(function() {
			setTimeout(function(){
				window.location = 'logOut.php';
			}, 5000);
		});
	
	</script>