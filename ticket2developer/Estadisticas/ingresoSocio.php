<?php 
	include("controlusuarios/seguridadbeBoletero.php");	
	$nombre = $_SESSION['useractual'];
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#00ADEF; color:#fff; margin:20px 400px 0px 0px; padding-left:30px; font-size:22px;">
				<p><strong>Tu ingreso ha sido correcto...!!</strong></p>
			</div>
			<div style="background-color:#EC1867; margin:20px -42px 50px 400px; text-align:center; font-size:25px; position:relative; color:#fff;">
				<?php
				include '../conexion.php';
	
	// $seleccion = mysql_query("SELECT *FROM equipo WHERE mail = '$nombre'");
	$seleccion = mysql_query("SELECT *FROM equipo INNER JOIN Usuario WHERE equipo.mail = '$nombre' and Usuario.strMailU = '$nombre'");
	$row = mysql_fetch_array($seleccion);

	// $seleccion = mysql_query("SELECT nombre from `equipo` INNER JOIN `Usuario` ON `id_usuario` = `idUsuario`"); 

	
	?>
				<img src="imagenes/facehappy.png" alt="" /><strong>Bienvenid@ <?php echo $nombre;?></strong>
				<p> Socio <?php echo $row['nombre'];?></p>
				
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
		</div>
	</div>
</div>