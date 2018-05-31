<?php 
	include("controlusuarios/seguridadSP.php");
	
	echo '<input type="hidden" id="data" value="8" />';
	
	$gbd = new DBConn();
	
	$query = "SELECT * FROM Usuario WHERE strPerfil = ?";
	$stmt = $gbd -> prepare($query);
	$stmt -> execute(array('Distribuidor'));
?>
<style>
	.circulo{
		width: 150px;
		height: 150px;
		-moz-border-radius: 50%;
		-webkit-border-radius: 50%;
		border-radius: 50%;
		background: #89AC76;
		margin-left:30%;
		padding-top:30px;
		font-size:30px;
		float:left;
	}
	.circulo2{
		width: 150px;
		height: 150px;
		-moz-border-radius: 50%;
		-webkit-border-radius: 50%;
		border-radius: 50%;
		background: #49678D;
		margin-left:55%;
		padding-top:30px;
		font-size:30px;
		color:#fff;
	}
</style>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 50% 0px 0px; padding:5px 0px 5px 40px; font-size:18px;">
				Reporte de Ventas y Cobros de Distribuidores
			</div>
			<div style="background-color:#00ADEF; margin:40px -42px 40px 40px; position:relative; padding:10px 40px 20px; color:#fff;">
				<div class="row" id="filadis">
					<div class="col-md-2"></div>
					<div class="col-md-3">
						<h4 style="color:#fff;">Seleccione un Distribuidor: </h4>
					</div>
					<div class="col-md-4">
						<select id="distribuidor" class="inputlogin form-control" onchange="selectDis()">
							<option value="0">Seleccione...</option>
							<?php while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){?>
							<option value="<?php echo $row['strObsCreacion'];?>"><?php echo $row['strNombreU'];?></option>
							<?php }?>
						</select>
					</div>
				</div>
				<div class="row" id="busqueda" style="display:none;">
					<div class="col-md-1"></div>
					<div class="col-md-3">
						<input type="text" id="desde" class="datepicker inputlogin form-control" size="15" readonly="readonly" placeholder="Desde..." />
					</div>
					<div class="col-md-3">
						<input type="text" id="hasta" class="datepicker inputlogin form-control" size="15" readonly="readonly" placeholder="Hasta..." />
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default form-control" onclick="buscar()">
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>&nbsp;Buscar
						</button>
					</div>
				</div>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div class="row" style="text-align:center; display:none;" id="totales">
				<div class="circulo">
					
				</div>
				<div class="circulo2">
					
				</div>
			</div>
			<div style="margin:40px 10px; height:750px; display:none; overflow:auto;" id="resultreporte">
				
			</div>
		</div>
	</div>
</div>
<script>
$(function() {
	$('.datepicker').datepicker({
		// showOn: 'button',
		// buttonImage: 'imagenes/bg-calendario.png',
		// buttonImageOnly: true,
		// buttonText: 'Select date',
		dateFormat: 'yy-mm-dd'
	});
});

$(document).ready(function(){
	$('.paginate').live('click', function(){
		window.scroll(0,0);
		var distribuidor = $('#distribuidor').val();
		var reporte = $('#reporte').val();
		var concierto = $('#concierto').val();
		$('#resultreporte').html('<div class="loading"><img src="imagenes/loading.gif" width="70px"/></div>');
		var page = $(this).attr('data');
		
		$.ajax({
			type: "GET",
			url: "SP/reportes/ajax/ajaxConstruirReporte.php",
			data: {page : page, distribuidor : distribuidor, reporte : reporte, concierto : concierto},
			success: function(data){
				$('#resultreporte').html(data);
			}
		});
	});
});

function selectDis(){
	var distribuidor = $('#distribuidor').val();
	if(distribuidor != 0){
		$('#filadis').fadeOut('slow');
		$('#busqueda').delay(600).fadeIn('slow');
		// $.post('SP/reportes/ajax/ajaxSelectBoletos.php',{
			// distribuidor : distribuidor
		// }).done(function(response){
			// $('#concierto').append(response);
		// });
	}
}

function selectRepor(){
	var reporte = $('#reporte').val();
	if(reporte != 0){
		$('#tiporepor').fadeOut('slow');
		$('#conciertorepor').delay(600).fadeIn('slow');
	}
}

function selectConcierto(){
	$('#totales').fadeOut();
	var distribuidor = $('#distribuidor').val();
	var reporte = $('#reporte').val();
	var concierto = $('#concierto').val();
	if(concierto != 0){
		$('#resultreporte').fadeIn('slow');
		$('#resultreporte').html('<div class="row" style="text-align:center;"><img src="imagenes/loading.gif" width="70px"/></div>');
		$.post('SP/reportes/ajax/ajaxConstruirReporte.php',{
			distribuidor : distribuidor, reporte : reporte, concierto : concierto
		}).done(function(response){
			var respuesta = response.split('|');
			$('#resultreporte').html(respuesta[0]);
			if(respuesta[1] == ''){
				$('.circulo').html('<h4>Total Efectivo</h4><strong>$0.00</strong>');
			}else{
				$('.circulo').html('<h4>Total Efectivo</h4><strong>$'+respuesta[1]+'</strong>');
			}
			if(respuesta[2] == ''){
				$('.circulo2').html('<h4>Total Tarjeta</h4><strong>$0.00</strong>');
			}else{
				$('.circulo2').html('<h4>Total Tarjeta</h4><strong>$'+respuesta[2]+'</strong>');
			}
			if($('.filasreporte').length){
				$('#printreporte').fadeIn();
				// $('#totales').fadeIn('slow');
			}
		});
	}
}

function cancelarrepor(){
	$('#reporte').val(0);
	$('#distribuidor').val(0);
	$('#tiporepor').fadeOut('slow');
	$('#filadis').delay(600).fadeIn('slow');
}

function cancelarconcert(){
	$('#conciertorepor').fadeOut('slow');
	$('#totales').fadeOut('slow');
	$('#concierto').val(0);
	$('#reporte').val(0);
	$('.circulo').html('');
	$('.circulo2').html('');
	$('#resultreporte').html('');
	$('#tiporepor').delay(600).fadeIn('slow');
}

function imprimirreporte(){
	var distribuidor = $('#distribuidor').val();
	var reporte = $('#reporte').val();
	var concierto = $('#concierto').val();
	if($('.filasreporte').length){
		$.post('SP/reportes/ajax/ajaxImprimirReporte.php',{
			distribuidor : distribuidor, reporte : reporte, concierto : concierto
		}).done(function(response){
			
		});
	}
}

function buscar(){
	$('#resultreporte').fadeOut('fast');
	var desde = $('#desde').val();
	var hasta = $('#hasta').val();
	var distribuidor = $('#distribuidor').val();
	$.post('SP/reportes/ajax/ajaxBuscar.php',{
		desde : desde, hasta : hasta, distribuidor : distribuidor
	}).done(function(response){
		$('#resultreporte').fadeIn('slow');
		$('#resultreporte').html(response);
	});
}
</script>