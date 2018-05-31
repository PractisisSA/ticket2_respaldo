<?php 
	include("controlusuarios/seguridadSA.php");
	echo '<input type="hidden" id="data" value="5" />';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div id="choose">
				<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
					Lista de Autorizaciones
				</div>
				<div style="background-color:#00ADEF; margin:20px -42px -10px 40px; position:relative; padding:20px 0 10px; text-align:center; color:#fff; font-size:18px;">
					<p class="filtro"><strong>Buscar por: &nbsp;&nbsp;</strong>
					<select id="search" class="inputlogin">
						<option value="0">Seleccione...</option>
						<option value="1">R.U.C.</option>
						<option value="2">Nombre Comercial</option>
					</select></p>
					<p class="serchFechas" style="display:none;">
						<strong>R.U.C.:</strong>&nbsp;&nbsp;<input type="text" id="ruc" class="inputlogin" onkeypress="return validarNumeros(event)">&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('1')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
						<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<p class="byUser" style="display:none;">
						<strong>Nombre Comercial:</strong>&nbsp;&nbsp;<input type="text" id="nameSocio" class="inputlogin" onkeypress="return validarLetras(event)">&nbsp;&nbsp;&nbsp;&nbsp;
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
			url: "spadmin/paginadorspA.php",
			data: {page : page, nombre : nombre, sector : sector, ruc : ruc, dato : dato},
			success: function(data){
				$('.registro').fadeIn(200).html(data);
			}
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

function validarLetras(e) {
	tecla = (document.all) ? e.keyCode : e.which; 
	if (tecla==8) return true;
	patron =/[A-Za-zñÑ\s]/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function validarNumeros(e) {
	tecla = (document.all) ? e.keyCode : e.which; 
	if (tecla==8) return true;
	if (tecla==32) return false;
	patron =/\d/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function buscar(dato){
	$('.registro').html('<div class="loading" style="text-align:center;"><img src="imagenes/loading.gif" width="70px"/></div>');
	var sector = $('#data').val();
	if(dato == 1){
		var ruc = $('#ruc').val();
		if(ruc == ''){
			alert('Debe llenar el campo');
		}else{
			$.post('spadmin/paginadorspA.php',{
				dato : dato, sector : sector, ruc : ruc
			}).done(function(data){
				$('.registro').fadeIn(400).html(data);
				// alert(data);
			});
		}
	}else{
		if(dato == 2){
			var nombre = $('#nameSocio').val();
			if(nombre == ''){
				alert('Debe llenar el campo');
			}else{
				$.post('spadmin/paginadorspA.php',{
					dato : dato, sector : sector, nombre : nombre
				}).done(function(data){
					$('.registro').fadeIn(400).html(data);
					// alert(data);
				});
			}
		}
	}
}
</script>