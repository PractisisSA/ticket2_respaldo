<?php 
	//include("controlusuarios/seguridadusuario.php");
	session_start();
	// if($_SESSION['autentica'] == 'uzx153'){
		// echo '<div class="divlogout">
					// <strong>'.$_SESSION['username'].'</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="logout" href="controlusuarios/salir.php">salir(logout)</a>
					// <div class="tra_comprar_concierto"></div>
					// <div class="par_comprar_concierto"></div>
				// </div>';
	// }
?>
<div style="margin:10px -10px;">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#00AEEF; margin-right:60%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Confirmaci&oacute;n</strong>
			</div>
			<div style="background-color:#EC1867; margin:20px -42px 50px 550px; font-size:25px; position:relative; color:#fff;">
				<img src="imagenes/facehappy.png" alt="" />En hora buena!!!
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
			<div style="background-color:#00ADEF; margin-left:40px; margin-top:20px; margin-right:-42px; position:relative; padding:40px 40px 40px 0px;">
				<table style="width:100%; margin:20px; color:#fff; font-size:25px; border-collapse:separate; border-spacing:0px 20x;">
					<tr align="center">
						<td>
							<p>Se revisara tu dep&oacute;sito...</p>
						</td>
					</tr>
					<tr align="center">
						<td>
							<p>En unas horas recibir&aacute;s más informacion sobre el estado de tu boleto</p>
						</td>
					</tr>
					<tr>
						<td align="center">
							<br>
							<p><a href="?modulo=start" class="btn_login" target="_parent">HOME</a></p>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="margin:30px; text-align:center;">
				<img alt="logo" src="gfx/logo.png"/>
			</div>
		</div>
	</div>
</div>