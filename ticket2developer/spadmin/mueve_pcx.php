<?php
		date_default_timezone_set('America/Guayaquil');
		
		include 'conexion.php';
		echo '<input type="hidden" id="data" value="46" />';
?>		
		<style>
			.carpeta:hover{
				cursor:pointer;
				color:blue;
				text-decoration:underline;
			}
		</style>
		<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 50px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				<strong>ADMINITRAR PCX</strong>
			</div><br>
			<div class = 'row'>
				<div class = 'col-md-6'>
					<i class="fa fa-folder-open-o fa-3x" style = 'color:#fff;' aria-hidden="true"></i> <span style = 'color:#fff;font-size:20px;'>PCX</span>
					<?php
						function listar_archivos($carpeta){
							if(is_dir($carpeta)){
								if($dir = opendir($carpeta)){
								echo '<table class = "table">';
									$i=0;
									while(($archivo = readdir($dir)) !== false){
										if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
											if($i==0){
												echo '<tr>';
											}

											echo '<td style = "border: 1px solid #fff;padding:5px;text-align: center; color: #fff">'.$archivo.'</td>';
											
											if($i==2){
												echo '</tr>';
												$i=0;
											}else{
												$i++;
											}
										}
									}
								echo '</table>';
									closedir($dir);
								}
							}
						}
						 
						echo listar_archivos('../img/pcx');
					?>
				</div>
				<div class = 'col-md-5'>
					<i class="fa fa-folder-open fa-3x" style = 'color:#fff;' aria-hidden="true"></i><span style = 'color:#fff;font-size:20px;'>PCX MOVIDOS</span>
					<?php
						function listar_archivos_viejos($carpeta){
							if(is_dir($carpeta)){
								if($dir = opendir($carpeta)){
								echo '<table class = "table">';
									$i=0;
									while(($archivo = readdir($dir)) !== false){
										if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
											if($i==0){
												echo '<tr>';
											}
													echo '<td style = "border: 1px solid #fff;padding:5px;text-align: center; color: #fff">'.$archivo.'</td>';
											if($i==2){
												echo '</tr>';
												$i=0;
											}else{
												$i++;
											}
										}
									}
								echo '</table>';
									closedir($dir);
								}
							}
						}
						 
						echo listar_archivos_viejos('../img/pcx_viejos');
					?>
				</div>
				<div class = 'col-md-12'>
					<center>
						<button type="button" class="btn btn-warning" id = 'boton_cambia' onclick = 'cambiarPcx()'>CAMBIAR</button>
					</center>
				</div>
			</div>
		</div>
	</div>
<script>
	$(document).ready(function () {
		$('#click').on('click', function () {
			console.log($('#val').val());
		})
	});
	function cambiarPcx(){
		$('#boton_cambia').html("Espere... <i class='fa fa-spinner' aria-hidden='true'></i>")
		$.post("../moverPcx.php",{ }).done(function(data){
			alert(data);
			location.reload();
		});
	}
</script>