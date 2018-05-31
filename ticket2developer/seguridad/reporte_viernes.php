<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<script src="js/jquery.js"></script>
		<title>Modulo Accesos TF</title>
		<!--<script src="js/index.js"></script>-->
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" />
	</head>
	<body>
		<div class = 'row' style = 'background-color: rgb(40,43,45)'>
			<div class = 'col-md-1'></div>
			<div class = 'col-md-10' style = 'border: 2px solid rgb(0,174,239);color: #fff;font-family:corbel;'>
				<center><img src="../../gfx/logo.png" width=""></center>
				<table class = 'table table-border' style = 'width:90%;' align = 'center'>
					<thead>
						<tr>
							<th colspan = '5'>
								<h2>Resumen Ingresos Centralaso 2016</h2>
							</th>
						</tr>
						<tr>
							<th>
								Localidad
							</th>
							<th>
								Tickets Ingresados
							</th>
							<th>
								Precio
							</th> 
							<th>
								TOTAL
							</th> 
						</tr>
					</thead>
					<tbody id = 'recibeResumenBoletos'>
						
					</tbody>
				</table>
				
				<table class = 'table table-border' style = 'width:90%;' align = 'center'>
					<thead>
						<tr>
							<th colspan = '5'>
								<h2>Centralaso 2016</h2>
							</th>
						</tr>
						<tr>
							<th>
								ID
							</th>
							<th>
								Localidad
							</th>
							<th>
								Precio
							</th>
							<th>
								Fecha y Hora ingreso
							</th>
							<th>
								Cod Barras
							</th>
						</tr>
					</thead>
					<tbody id = 'recibeConsultaBoletos'>
						
					</tbody>
				</table>
				
				
				
			</div>
			<div class = 'col-md-1'></div>
		</div>
	</body>
	<script>
		$(document).ready(function() { 
			function ver(){
				var desde = $('.fecha').val();
				$.post('reporte_ingreso_viernes.php' , {
					
				}).done(function(data){
					$('#recibeConsultaBoletos').html(data);
				});
			}
			function changeColor(){
				ver();
			}
			setInterval(changeColor, 1500);
			
			
			function ver2(){
				var desde = $('.fecha').val();
				$.post('reporte_ingreso_valores_viernes.php' , {
					
				}).done(function(data){
					$('#recibeResumenBoletos').html(data);
				});
			}
			function changeColor2(){
				ver2();
			}
			setInterval(changeColor2, 1500);
		});
	</script>
</html>