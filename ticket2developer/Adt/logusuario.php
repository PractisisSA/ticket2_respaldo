<?php
	date_default_timezone_set('America/Guayaquil');
	include("controlusuarios/seguridadAdt.php");
	echo '<input type="hidden" id="data" value="2" />';
	
	$gbd = new DBConn();
	
	$idlog = 'NULL';
	$fecha = date('Y-m-d H:i:s');
	$user = $_SESSION['iduser'];
	$accion = 'Ingreso al Log de Usuarios';
	$estado = 'Activo';
	
	$insertlog = "INSERT INTO logaccesoauditoria VALUES (?, ?, ?, ?, ?)";
	$log = $gbd -> prepare($insertlog);
	$log -> execute(array($idlog,$fecha,$user,$accion,$estado));
	
	$sql = "SELECT * FROM ticktfacil";
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute();
	$rowemp = $stmt -> fetch(PDO::FETCH_ASSOC);
	echo '<input type="hidden" id="rucEmp" value="'.$rowemp['rucTF'].'" />
			<input type="hidden" id="razonEmp" value="'.$rowemp['nombresTF'].'" />
			<input type="hidden" id="nombreEmp" value="'.$rowemp['razonsocialTF'].'" />';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:18px;">
				Log de Usuarios
			</div>
			<div id="invalido" style="display:none;">
				<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; padding:10px 40px 20px; color:#fff;">
					<table style="width:100%; text-align:center;">
						<tr>
							<td>
								<h3><strong>No se encontro la Parametrización de la Empresa para acceder a este Modulo</strong></h3><br>
							</td>
						</tr>
					</table>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
			</div>
			<div id="validado" style="display:none;">
				<div style="background-color:#00ADEF; margin:20px -42px -10px 40px; position:relative; padding:20px 0 10px; text-align:center; color:#fff; font-size:18px;">
					<p class="filtro"><strong>Buscar por: &nbsp;&nbsp;</strong>
					<select id="search" class="inputlogin">
						<option value="0">Seleccione...</option>
						<option value="1">Fecha de proceso</option>
						<option value="2">Usuario</option>
						<option value="3">Cliente</option>
					</select></p>
					<p class="serchFechas" style="display:none;">
						<input type="text" id="desde" class="datepicker inputlogin" size="15" readonly="readonly" placeholder="Desde...">&nbsp;&nbsp;
						<input type="text" id="hasta" class="datepicker inputlogin" size="15" readonly="readonly" placeholder="Hasta...">&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('1')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;
						<button type="button" class="btnlink" id="printCli1" onclick="print('1')">Reporte&nbsp;<img src="imagenes/pdficon.gif"/></button>&nbsp;
						<!--<button type="button" class="btnlink" id="descargarCli" onclick="descargar('1')">Descargar&nbsp;<img src="imagenes/save.png"/></button>&nbsp;-->
						<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<p class="byUser" style="display:none;">
						<strong>Usuario:</strong>&nbsp;&nbsp;<input type="text" id="nameUser" class="inputlogin" onkeypress="return validarLetras(event)" placeholder="Nombre...">&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('2')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;
						<button type="button" class="btnlink" id="printCli2" onclick="print('2')">Reporte&nbsp;<img src="imagenes/pdficon.gif"/></button>&nbsp;
						<!--<button type="button" class="btnlink" id="descargarCli" onclick="descargar('2')">Guardar&nbsp;<img src="imagenes/save.png"/></button>&nbsp;-->
						<button type="button" class="btnlink" id="cancel2" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<p class="byCli" style="display:none;">
						<strong>Cliente:</strong>&nbsp;&nbsp;<input type="text" id="nameCli" class="inputlogin" onkeypress="return validarLetras(event)" placeholder="Nombre...">&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('3')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;
						<button type="button" class="btnlink" id="printCli3" onclick="print('3')">Reporte&nbsp;<img src="imagenes/pdficon.gif"/></button>&nbsp;
						<!--<button type="button" class="btnlink" id="descargarCli" onclick="descargar('3')">Guardar&nbsp;<img src="imagenes/save.png"/></button>&nbsp;-->
						<button type="button" class="btnlink" id="cancel3" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
			</div>
			<div style="border:2px solid #00ADEF; margin:40px; text-align:center;">
				<table id="select_conciertos" style="width:100%;">
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
	var rucEmp = $('#rucEmp').val();
	var razonEmp = $('#razonEmp').val();
	var nombreEmp = $('#nombreEmp').val();
	if((rucEmp == 'Ingresa RUC') && (razonEmp == 'Ingresa Razon Social') && (nombreEmp == 'Ingresa Nombre Comercial')){
		$('#invalido').fadeIn();
	}else{
		$('#validado').fadeIn();
	}
	
	$('#printCli1').prop('disabled',true);
	$('#printCli2').prop('disabled',true);
	$('#printCli3').prop('disabled',true);
	
	$('.paginate').live('click', function(){
		window.scroll(0,0);
		var desde = $('#desde').val();
		var hasta = $('#hasta').val();
		var id = $('#search').val();
		var nombreUser = $('#nameUser').val();
		var nombreCli = $('#nameCli').val();
		var log = $('#data').val();
		$('.registro').html('<div class="loading"><img src="imagenes/loading.gif" width="70px"/></div>');
		var page = $(this).attr('data');
		
		$.ajax({
			type: "GET",
			url: "Adt/paginador.php",
			data: {page : page, desde : desde, hasta : hasta, id : id, nombreUser : nombreUser, nombreCli : nombreCli, log : log},
			success: function(data){
				$('.registro').fadeIn(200).html(data);
			}
		});
	});
});

$(function() {
	$('.datepicker').datepicker({
		showOn: 'button',
		buttonImage: 'imagenes/bg-calendario.png',
		buttonImageOnly: true,
		buttonText: 'Select date',
		dateFormat: 'yy-mm-dd'
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
			if(search == 3){
				$('.filtro').fadeOut('slow');
				$('.byCli').delay(600).fadeIn('slow');
			}
		}
	}
});

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

function buscar(id){
	var log = $('#data').val();
	if(id == 1){
		var desde = $('#desde').val();
		var hasta = $('#hasta').val();
		if((desde == '') || (hasta == '')){
			alert('Debes seleccionar dos fechas');
		}else{
			$.post('Adt/paginador.php',{
				desde : desde, hasta : hasta, id : id, log : log
			}).done(function(data){
				$('.registro').html(data);
				// alert(data);
				if($('.sidatos').length){
					$('#printCli1').prop('disabled',false);
				}else{
					$('#printCli1').prop('disabled',true);
				}
			});
		}
	}
	if(id == 2){
		var nombreUser = $('#nameUser').val();
		
		$.post('Adt/paginador.php',{
			nombreUser : nombreUser, id : id, log : log
		}).done(function(data){
			$('.registro').html(data);
			// alert(data);
			if($('.sidatos').length){
				$('#printCli2').prop('disabled',false);
			}else{
				$('#printCli2').prop('disabled',true);
			}
		});
	}
	if(id == 3){
		var nombreCli = $('#nameCli').val();
		
		$.post('Adt/paginador.php',{
			nombreCli : nombreCli, id : id, log : log
		}).done(function(data){
			$('.registro').html(data);
			// alert(data);
			if($('.sidatos').length){
				$('#printCli3').prop('disabled',false);
			}else{
				$('#printCli3').prop('disabled',true);
			}
		});
	}
}

function cancel(){
	var search = $('#search').val();
	if(search == 1){
		$('.serchFechas').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search').val(0);
		$('.registro').html('');
		$('#desde').val('');
		$('#hasta').val('');
		$('#printCli1').prop('disabled',true);
	}else{
		if(search == 2){
			$('.byUser').fadeOut('slow');
			$('.filtro').delay(600).fadeIn('slow');
			$('#search').val(0);
			$('.registro').html('');
			$('#nameUser').val('');
			$('#printCli1').prop('disabled',true);
		}
		if(search == 3){
			$('.byCli').fadeOut('slow');
			$('.filtro').delay(600).fadeIn('slow');
			$('#search').val(0);
			$('.registro').html('');
			$('#nameCli').val('');
			$('#printCli1').prop('disabled',true);
		}
	}
}

function print(id){
	var log = $('#data').val();
	if(id == 1){
		var desde = $('#desde').val();
		var hasta = $('#hasta').val(); 
		$.post('Adt/reportes.php',{
			desde : desde, hasta : hasta, id : id, log : log
		}).done(function(data){
			window.open('Adt/pdf/'+data+'.pdf','nuevo','scrollbars=yes');
			// window.location = '';
		});
	}else{
		if(id == 2){
			var nombreUser = $('#nameUser').val();
			$.post('Adt/reportes.php',{
				nombreUser : nombreUser, id : id, log : log
			}).done(function(data){
				window.open('Adt/pdf/'+data+'.pdf','nuevo','scrollbars=yes');
			});
		}else{
			if(id == 3){
				var nameCli = $('#nameCli').val();
				$.post('Adt/reportes.php',{
					nameCli : nameCli, id : id, log : log
				}).done(function(data){
					window.open('Adt/pdf/'+data+'.pdf','nuevo','scrollbars=yes');
				});
			}
		}
	}
}
</script>