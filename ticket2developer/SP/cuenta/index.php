<?php 
	include("controlusuarios/seguridadSP.php");
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="30" />';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#00ADEF; color:#fff; margin:20px 400px 0px 0px; padding-left:30px; font-size:22px;">
				<p><strong>Aqui va a ver los datos de tu cuenta </strong></p>
			</div>
			<div class="row perfiles" style="text-align: center;" id='clavesCta'>
				<div class="col-lg-3"></div>
				<div class="col-lg-6">
					<h4 style='color:#fff;'>
						Ingresa tu clave y contraseña entregadas para ver los datos de tu cuenta
					</h4>
					<input id="usercuenta" class="inputlogin form-control" type="text" autocomplete="off" placeholder="usuario"><br/>
					<input id="passCuenta" class="inputlogin form-control" type="password" autocomplete="off" placeholder="****************">
					<br/>
					<center>
						<button id="aceptar" class="btndegradate" onclick='ingCta()'>
						<span>Ingresar</span>
						</button>
					</center>
				</div>
				<div class="col-lg-3"></div>
			</div>
			<div class='row' id='rescta' style='display:none;'>
				<div class='col-lg-12' >
					
				</div>
			</div>
			<script>
				function ingCta(){
					var usercuenta = $('#usercuenta').val();
					var passCuenta = $('#passCuenta').val();
					if(usercuenta == ''){
						alert('Por favor ingresa tu usuario');
					}
					if(passCuenta == '' ){
						alert('Por favor ingresa tu contraseña');
					}
					if(usercuenta == '' || passCuenta == '' ){
						
					}else{
						$.post('SP/cuenta/sesiones.php',{
							usercuenta : usercuenta , passCuenta : passCuenta
						}).done(function(data){
							$('#rescta').html(data);
							setTimeout(function() {
								$('#clavesCta').fadeOut('fast');
							}, 1000);
							setTimeout(function() {
								$('#rescta').css('display','block');
							}, 1100);
							
							
						});
					}
				}
			</script>
			<!--<div style="background-color:#EC1867; text-align:center; margin:20px -42px 50px 400px; font-size:25px; position:relative; color:#fff;">
				<img src="imagenes/facehappy.png" alt="" /><strong>Bienvenid@ <?php //echo $nombre;?></strong>
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>-->
		</div>
	</div>
</div>