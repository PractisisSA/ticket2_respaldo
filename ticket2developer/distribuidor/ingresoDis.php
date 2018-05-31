<?php 
	echo $_SESSION['perfil']."<br>";
	echo $_SESSION['autentica'];
	// include("controlusuarios/seguridadDis.php");
	$nombre = $_SESSION['useractual'];
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#00ADEF; color:#fff; margin:20px 400px 0px 0px; padding-left:30px; font-size:22px;">
				<p><strong>Tu ingreso a sido correcto...!!</strong></p>
			</div>
			<div style="background-color:#EC1867; text-align:center; margin:20px -42px 50px 400px; font-size:25px; position:relative; color:#fff;">
				<img src="imagenes/facehappy.png" alt="" /><strong>Bienvenid@ <?php echo $nombre;?></strong>
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
		</div>
	</div>
</div>