<?php 
	include("controlusuarios/seguridadDis.php");
	
	echo '<input type="hidden" id="data" value="1" />';
	
	$nombre = $_SESSION['useractual'];
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
				<p class="cabecera_distribuidores"><?php echo $nombre;?></p>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 20px 40px; position:relative; padding:20px 0 10px; text-align:center; color:#fff; font-size:18px;">
				<button class="btndegradate" id="btn_ventas">Ventas</button>&nbsp;&nbsp;&nbsp;&nbsp;
				<button class="btndegradate" id="btn_reservas">Cobros</button>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		</div>
	</div>
</div>
<script>
$('#btn_ventas').on('click',function(){
	window.location = '?modulo=ventasDistribuidor';
});

$('#btn_reservas').on('click',function(){
	window.location = '?modulo=reservasDistribuidor';
});
</script>