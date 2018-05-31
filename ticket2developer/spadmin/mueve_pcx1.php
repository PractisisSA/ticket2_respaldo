<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
			tbody{
				color:white;
			}
			thead{
				color:white;
			}
		</style>
				<div class = 'row'>
					<div class="row" style="text-align: center;">
						<div class="col-md-4"></div>
						<div class="col-md-8">
							<button onclick="verTodos(1)" class="btn btn-primary">Mover de activos a inactivos</button>
							<button onclick="verTodos(2)" class="btn btn-primary">Mover de activos a inactivos</button>
						</div>			
					</div>
					<div class="col-md-1"></div>
					<div class = 'col-md-5'>
						<i class="fa fa-folder-open-o fa-3x" style = 'color:#fff;' aria-hidden="true"></i> <span style = 'color:#fff;font-size:20px;'>PCX</span>
						<table class="table-bordered">
							<thead>
								<tr>
									<td>PCX</td>
									<td>Accion</td>
								</tr>
							</thead>
					<?php 
						$dir = scandir('../img/pcx');
						foreach ($dir as $key) {
							if ($key != '.' && $key != '..' && $key != '.htaccess') {
							?>
								<tbody>
									<tr>
										<td><?php echo $key ?></td>
										<td><button onclick="ver('<?php echo $key ?>', 1)" class="btn btn-primary">Mover</button></td>
									</tr>
								</tbody>
							<?php
							}
						} 
					?>
						</table>
					</div>
					<div class = 'col-md-5'>
						<i class="fa fa-folder-open fa-3x" style = 'color:#fff;' aria-hidden="true"></i><span style = 'color:#fff;font-size:20px;'>PCX MOVIDOS</span>
						<table class="table-bordered">
							<thead>
								<tr>
									<td>PCX VIEJO</td>
									<td>Accion</td>
								</tr>
							</thead>
					<?php
						$dir2 = scandir('../img/pcx_viejos');
						foreach ($dir2 as $key) {
							if ($key != '.' && $key != '..' && $key != '.htaccess') {
							?>
								<tbody>
									<tr>
										<td><?php echo $key; ?></td>
										<td><button onclick="ver('<?php echo $key ?>', 2)" class="btn btn-primary">Mover</button></td>
									</tr>
								</tbody>
							<?php
							}
						}
					?>
						</table>
					</div>
				</div>
<script>
	$(document).ready(function () {
	});
	function ver(pcx, option) {
		console.log(pcx, option);
		var nums = pcx.replace(/\D/g,"");
		var letrs = pcx.replace(/\d/g,"");
		if (option == 1) {
			$.ajax({
				method: 'POST',
				url: '../../moverPcxPrueba.php',
				data: {nums:nums, letrs:letrs},
				success: function (data) {
					alert('PCX '+pcx+' movido con exito');
					console.log(data);
					location.reload();
				}
			})
		}else{
			console.log(nums+"--"+letrs+"--"+option);
			var value = 1;
			$.ajax({
				method: 'POST',
				url: '../../moverPcxPrueba.php',
				data: {nums:nums, letrs:letrs, value:value},
				success: function (data) {
					alert('PCX '+pcx+' movido con exito');
					console.log(data);
					location.reload();
				}
			})
		}
	}
	function verTodos(option) {
		var sourceDir = '';
		var targetDir = '';
		if (option == 1) {
			sourceDir = 'img/pcx/';
			targetDir = 'img/pcx_viejos/';
		}else{
			sourceDir = 'img/pcx_viejos/';
			targetDir = 'img/pcx/';
		}
		$.ajax({
			method: 'POST',
			url: '../../moverPcxTodos.php',
			data: {pcx:sourceDir, pcx_viejos:targetDir},
			success: function (data) {
				alert('Movidos con exito');
				location.reload();
			}
		})
	}
	function cambiarPcx(){
		$('#boton_cambia').html("Espere... <i class='fa fa-spinner' aria-hidden='true'></i>")
		$.post("../moverPcx.php",{ }).done(function(data){
			alert(data);
			location.reload();
		});
	}
</script>