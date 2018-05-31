<?php
	include '../conexion.php';
	$id_con = $_REQUEST['id_con']; 
	echo "<input type = 'hidden' id = 'id_con' value = '".$id_con."' />";
	$sql = 'select strEvento from Concierto where idConcierto = "'.$id_con.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
?>
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
		<style>
			table , tbody , thead , tfooter , tr , th , td {
				color:#fff;
			}
		</style>
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
								<h2 style = 'color:#00AEEF;'>RESUMEN INGRESOS EVENTO :  <?php echo $row['strEvento'];?></h2>
							</th>
						</tr>
						<tr>
							<th>
								Localidad
							</th>
							<th>
								Tickets Sin Descuento
							</th>
							<th>
								Precio
							</th>
							<th>
								Tickets Con Descuento
							</th>
							<th>
								Precio
							</th>
							<th>
								Total Tickets
							</th> 
							<th>
								Total Recaudado
							</th> 
							
						</tr>
					</thead>
					<tbody id = 'recibeResumenBoletos'>
						<center><img src="../imagenes/load22.gif" id="loaderGif" style="display:none;background-color:#fff"/></center>
					</tbody>
				</table>
				
				<table class = 'table table-border' style = 'width:90%;' align = 'center'>
					<thead>
						<tr>
							<th colspan = '5'>
								<h3 style = 'color:#00AEEF;'>DETALLE DE INGRESOS EVENTO: <?php echo $row['strEvento'];?></h3>
							</th>
						</tr>
						<tr>
							<th>
								Nº
							</th>
							<th>
								Localidad
							</th>
							<th>
								Estado
							</th>
							<th>
								Nombre Descuento:
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
						<center><img src="../imagenes/load22.gif" id="loaderGif1" style="display:none;background-color: #fff"/></center>
					</tbody>
				</table>
				
				
				
			</div>
			<div class = 'col-md-1'></div>
		</div>
	</body>
	<script>
		$(document).ready(function() { 
			var id_con = $('#id_con').val();
			
			$('#loaderGif').css('display','block');
			$('#loaderGif1').css('display','block');
			$.post('reporte_ingreso.php' , {
				id_con : id_con
			}).done(function(data){
				$('#recibeConsultaBoletos').html(data);
				$('#loaderGif1').css('display','none');
			});
			
			$.post('reporte_ingreso_valores.php' , {
				id_con : id_con
			}).done(function(data){
				$('#recibeResumenBoletos').html(data);
				$('#loaderGif').css('display','none');
			});
		});
		
			
	</script>
</html>