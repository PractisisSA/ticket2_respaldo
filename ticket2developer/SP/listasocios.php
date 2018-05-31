<?php 
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="4" />';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
				Lista de Empresarios
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px -10px 40px; position:relative; padding:20px 0 10px; text-align:center; color:#fff; font-size:18px;">
				<p class="filtro"><strong>Buscar por: &nbsp;&nbsp;</strong>
				<select id="search" class="inputlogin">
					<option value="0">Seleccione...</option>
					<option value="1">R.U.C.</option>
					<option value="2">Nombre del Socio</option>
				</select></p>
				<p class="serchFechas" style="display:none;">
					<strong>R.U.C.:</strong>&nbsp;&nbsp;<input type="text" id="ruc" class="inputlogin">&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" class="btnlink" id="buscarCli" onclick="buscar('1')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
					<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
				</p>
				<p class="byUser" style="display:none;">
					<strong>Nombre del Socio:</strong>&nbsp;&nbsp;<input type="text" id="nameSocio" class="inputlogin">&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" class="btnlink" id="buscarCli" onclick="buscar('2')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
					<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
				</p>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="border:2px solid #00ADEF; margin:40px; text-align:center;">
				<table id="select_conciertos" style="width:100%; color:#fff; font-size:18px; border-collapse:separate; border-spacing:15px 15px;">
					<tr style="text-align:center;">
						<td>
							<div class="registro"></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.paginate').live('click', function(){
		window.scroll(0,0);
		var sector = $('#data').val();
		var nombre = $('#nameSocio').val();
		var ruc = $('#ruc').val();
		var dato = $('#search').val();
		$('.registro').html('<div class="loading"><img src="imagenes/loading.gif" width="70px"/></div>');
		var page = $(this).attr('data');
		$.ajax({
			type: "GET",
			url: "SP/paginadorSP.php",
			data: {page : page, nombre : nombre, sector : sector, ruc : ruc, dato : dato},
			success: function(data){$('.registro').fadeIn(200).html(data);}
		});
	});
});

$('#search').on('change',function(){
	var search = $('#search').val();
	if(search == 0){
		alert('Selecciona un filtro');
	}else{
		if(search == 1){
			$('.filtro').fadeOut('slow');
			$('.serchFechas').delay(600).fadeIn('slow');
		}else{
			if(search == 2){
				$('.filtro').fadeOut('slow');
				$('.byUser').delay(600).fadeIn('slow');
			}
		}
	}
});

function cancel(){
	var search = $('#search').val();
	if(search == 1){
		$('.serchFechas').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search').val(0);
		$('.registro').html('');
		$('#ruc').val('');
	}else{
		if(search == 2){
			$('.byUser').fadeOut('slow');
			$('.filtro').delay(600).fadeIn('slow');
			$('#search').val(0);
			$('.registro').html('');
			$('#nameSocio').val('');
		}
	}
}

function buscar(dato){
	var sector = $('#data').val();
	if(dato == 1){
		var ruc = $('#ruc').val();
		$.post('SP/paginadorSP.php',{
			dato : dato, sector : sector, ruc : ruc
		}).done(function(data){
			$('.registro').html(data);
		});
	}
	if(dato == 2){
		var nombre = $('#nameSocio').val();
		if(nombre == '')
		$.post('SP/paginadorSP.php',{
			dato : dato, sector : sector, nombre : nombre
		}).done(function(data){
			$('.registro').html(data);
		});
	}
}
</script>