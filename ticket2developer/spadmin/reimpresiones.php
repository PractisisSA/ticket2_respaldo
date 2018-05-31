<?php 
	include("controlusuarios/seguridadSA.php");
	echo '<input type="hidden" id="data" value="7" />';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				<p id="create">Reimpresiones</p>
				<p id="listAuto" style="display:none;">Lista de Autorizaciones Generadas</p>
			</div>
			<div id="ocultarTrans">
				<div id="choose">
					<div id="mostrarlista" style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:18px;">
						<p class="filtro"><strong>Buscar por: &nbsp;&nbsp;</strong>
							<select id="search2" class="inputlogin">
								<option value="0">Seleccione...</option>
								<option value="2">R.U.C.</option>
								<option value="3">Nombre Comercial</option>
								<option value="4"># de Autorizaci&oacute;n</option>
							</select>
						</p>
						<p class="serchFechas" style="display:none;">
							<input type="text" maxlength="13" id="ruc" class="inputlogin" placeholder="R.U.C.">&nbsp;&nbsp;&nbsp;&nbsp;
							<button type="button" class="btnlink" id="buscarCli" onclick="buscar('2')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
							<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
						</p>
						<p class="byUser" style="display:none;">
							<input type="text" id="nameSocio" class="inputlogin" placeholder="Nombre Comercial...">&nbsp;&nbsp;&nbsp;&nbsp;
							<button type="button" class="btnlink" id="buscarCli" onclick="buscar('3')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
							<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
						</p>
						<p class="auto" style="display:none;">
							<input type="text" id="numautorizacion" class="inputlogin" placeholder="# de Autorizaci&oacute;n...">&nbsp;&nbsp;&nbsp;&nbsp;
							<button type="button" class="btnlink" id="buscarCli" onclick="buscar('4')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
							<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
						</p>
						<div class="tra_azul"></div>
						<div class="par_azul"></div>
					</div>
					<div style="border:2px solid #00ADEF; margin:40px; text-align:center;">
						<p id="realizados" style="display:;">
							<table id="table_trabajos" style="width:100%; color:#fff; font-size:18px; border-collapse:separate; border-spacing:15px 5px;">
								<tr>
									<td>
										<div class="registro"></div>
									</td>
								</tr>
							</table>
						</p>
					</div>
				</div>
				<div id="cargar" style="display:none;">
					<div style="background-color:#00ADEF; margin:20px -42px 40px 40px; position:relative; padding:10px 40px 20px; color:#fff;">
						<table id="loaddates" style="width:100%; color:#fff; border-collapse:separate; border-spacing:10px 20px; font-size:18px;">
							
						</table>
						<div class="tra_azul"></div>
						<div class="par_azul"></div>
					</div>
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
		var dato = $('#search2').val();
		var numautorizacion = $('#numautorizacion').val();
		$('.registro').html('<div class="loading"><img src="imagenes/loading.gif" width="70px"/></div>');
		var page = $(this).attr('data');
		
		$.ajax({
			type: "GET",
			url: "spadmin/paginadorspA.php",
			data: {page : page, nombre : nombre, sector : sector, ruc : ruc, dato : dato, numautorizacion : numautorizacion},
			success: function(data){
				$('.registro').fadeIn(200).html(data);
			}
		});
	});
});

$('#search2').on('change',function(){
	var search = $('#search2').val();
	if(search == 2){
		$('.filtro').fadeOut('slow');
		$('.serchFechas').delay(600).fadeIn('slow');
	}
	if(search == 3){
		$('.filtro').fadeOut('slow');
		$('.byUser').delay(600).fadeIn('slow');
	}
	if(search == 4){
		$('.filtro').fadeOut('slow');
		$('.auto').delay(600).fadeIn('slow');
	}
});

function cancel(){
	var search = $('#search2').val();
	if(search == 2){
		$('.serchFechas').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search2').val(0);
		$('.registro').html('');
		$('#ruc').val('');
	}
	if(search == 3){
		$('.byUser').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search2').val(0);
		$('.registro').html('');
		$('#nameSocio').val('');
	}
	if(search == 4){
		$('.auto').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search2').val(0);
		$('.registro').html('');
		$('#numautorizacion').val('');
	}
}

function buscar(dato){
	$('.registro').html('<div class="loading" style="text-align:center;"><img src="imagenes/loading.gif" width="70px"/></div>');
	var sector = $('#data').val();
	if(dato == 2){
		var ruc = $('#ruc').val();
		$.post('spadmin/paginadorspA.php',{
			dato : dato, sector : sector, ruc : ruc
		}).done(function(data){
			$('.registro').fadeIn(400).html(data);
			// alert(data);
		});
	}
	if(dato == 3){
		var nombre = $('#nameSocio').val();
		$.post('spadmin/paginadorspA.php',{
			dato : dato, sector : sector, nombre : nombre
		}).done(function(data){
			$('.registro').fadeIn(400).html(data);
			// alert(data);
		});
	}
	if(dato == 4){
		var numautorizacion = $('#numautorizacion').val();
		$.post('spadmin/paginadorspA.php',{
			dato : dato, sector : sector, numautorizacion : numautorizacion
		}).done(function(data){
			$('.registro').fadeIn(400).html(data);
			// alert(data);
		});
	}
}

function reimprimir(auto){
	$('#choose').fadeOut('slow');
	$('#cargar').delay(600).fadeIn('slow');
	$.post('spadmin/editarReimpresion.php',{
		auto : auto
	}).done(function(data){
		$('#loaddates').html('<div class="loading" style="text-align:center;"><img src="imagenes/loading.gif" width="70px"/></div>');
		$('#loaddates').fadeIn(600).html(data);
		$('#regrealizado').fadeIn('slow');
	});
	setTimeout("$('html, body').animate({scrollTop: '0px'});",600);
}

function modificaInicial(){
	var inicialbd = $('#inicialbd').val();
	var seciniinfo = $('#seciniinfo').val();
	var finalbd = $('#finalbd').val();
	var secfininfo = $('#secfininfo').val();
	if(seciniinfo < inicialbd){
		alert('El Secuencial Inicial Reimpresión no puede ser menor al Secuencial Inicial');
		$('#seciniinfo').val(inicialbd);
	}else if((seciniinfo > inicialbd) && (seciniinfo <= finalbd)){
		$('#tipo_trabajo').html('Trabajo Incompleto');
	}else if(seciniinfo > finalbd){
		alert('El Secuencial Inicial Reimpresión no puede ser mayor al Secuencial Final');
		$('#seciniinfo').val(inicialbd);
	}else if((seciniinfo == inicialbd) && (secfininfo == finalbd)){
		$('#tipo_trabajo').html('Trabajo Completo');
	}else if(seciniinfo == 0){
		$('#secfininfo').val(0);
		$('#tipo_trabajo').html('Trabajo en 0');
	}else if(seciniinfo == ''){
		alert('No puedes registrar un trabajo sin Secuencial Inicial');
		$('#seciniinfo').val(inicialbd);
	}
}

function modificaFinal(){
	var finalbd = $('#finalbd').val();
	var secfininfo = $('#secfininfo').val();
	var inicialbd = $('#inicialbd').val();
	var seciniinfo = $('#seciniinfo').val();
	if(secfininfo > finalbd){
		alert('El Secuencial Final Reimpresión no puede ser menor al Secuencial Final');
		$('#secfininfo').val(finalbd);
	}else if((secfininfo < finalbd) && (secfininfo >= inicialbd)){
		$('#tipo_trabajo').html('Trabajo Incompleto');
	}else if(secfininfo < inicialbd){
		alert('El Secuencial Final Reimpresión no puede ser menor al Secuencial Inicial');
		$('#secfininfo').val(finalbd);
	}else if((secfininfo == finalbd) && (inicialbd == seciniinfo)){
		$('#tipo_trabajo').html('Trabajo Completo');
	}else if(secfininfo == 0){
		$('#seciniinfo').val(0);
		$('#tipo_trabajo').html('Trabajo en 0');
	}else if(secfininfo == ''){
		alert('No puedes registrar un trabajo sin Secuencial Final');
		$('#seciniinfo').val(finalbd);
	}
}

function cancelall(id){
	if(id == 1){
		window.location = '';
	}else{
		alert('Ha cancelado el registro de este trabajo sus datos no se guardaran');
		window.location = '';
	}
}

function guardarEdicion(auto,socio){
	var obstrans = $('#obstrans').val();
	var secfininfo = $('#secfininfo').val();
	var seciniinfo = $('#seciniinfo').val();
	if((obstrans == '') || (secfininfo == '') || (seciniinfo == '')){
		alert('Llena todos los campos');
	}else{
		$.post('spadmin/savereimpresiones.php',{
			obstrans : obstrans, socio : socio, auto : auto, secfininfo : secfininfo, seciniinfo : seciniinfo
		}).done(function(data){
			alert('Datos Modificados');
			window.location = '';
		});
	}
}
function validarNumeros(e) {
	tecla = (document.all) ? e.keyCode : e.which; 
	if (tecla==8) return true;
	if (tecla==32) return false;
	patron =/\d/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function verReimpresion(id){
	$.post('spadmin/modificarReimpresion.php',{
		id : id
	}).done(function(response){
		$('#loaddates').html('<div class="loading" style="text-align:center;"><img src="imagenes/loading.gif" width="70px"/></div>');
		$('#loaddates').fadeIn(600).html(response);
		$('#regrealizado').fadeIn('slow');
	});
	setTimeout("$('html, body').animate({scrollTop: '0px'});",600);
}

function guardarModificacion(id){
	var secfininfo = $('#secfininfo').val();
	var seciniinfo = $('#seciniinfo').val();
	if((secfininfo == '') || (seciniinfo == '')){
		alert('Llena todos los campos');
	}else{
		$.post('spadmin/savemodreimpresiones.php',{
			id : id, secfininfo : secfininfo, seciniinfo : seciniinfo
		}).done(function(data){
			alert('Datos Modificados');
			window.location = '';
		});
	}
}
</script>