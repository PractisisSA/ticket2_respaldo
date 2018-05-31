<?php
	date_default_timezone_set('America/Guayaquil');
	include("controlusuarios/seguridadAdt.php");
	echo '<input type="hidden" id="data" value="6" />';
	
	$gbd = new DBConn();
	
	$idlog = 'NULL';
	$fecha = date('Y-m-d H:i:s');
	$user = $_SESSION['iduser'];
	$accion = 'Ingreso al Log de Reimpresiones';
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
				Log de Reimpresiones
			</div>
			<div id="invalido" style="display:none;">
				<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; padding:10px 40px 20px; color:#fff;">
					<table style="width:100%; text-align:center;">
						<tr>
							<td>
								<h3><strong>No se encontro la Parametrizaci√≥n de la Empresa para acceder a este Modulo</strong></h3><br>
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
						<option value="2">Fecha</option>
						<option value="5">Nombre Comercial</option>
						<option value="6">R.U.C.</option>
					</select></p>
					<p class="serchFechas" style="display:none;">
						<input type="text" id="desde" class="datepicker inputlogin" size="15" readonly="readonly" placeholder="Desde..." />&nbsp;
						<input type="text" id="hasta" class="datepicker inputlogin" size="15" readonly="readonly" placeholder="Hasta..." />&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('2')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;
						<button type="button" class="btnlink" id="printCli1" onclick="print('1')">Reporte&nbsp;<img src="imagenes/pdficon.gif"/></button>&nbsp;
						<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<p class="byRs" style="display:none;">
						<strong>Nombre Comercial:</strong>&nbsp;&nbsp;<input type="text" id="razonsocial" class="inputlogin" onkeypress="return validarLetras(event)" />&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('5')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;
						<button type="button" class="btnlink" id="printCli2" onclick="print('2')">Reporte&nbsp;<img src="imagenes/pdficon.gif"/></button>&nbsp;
						<button type="button" class="btnlink" id="cancel2" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<p class="byRuc" style="display:none;">
						<strong>R.U.C.:</strong>&nbsp;&nbsp;<input type="text" id="ruc" class="inputlogin" onkeypress="return validarNumeros(event)" />&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('6')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;
						<button type="button" class="btnlink" id="printCli3" onclick="print('3')">Reporte&nbsp;<img src="imagenes/pdficon.gif"/></button>&nbsp;
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
		var log = $('#data').val();
		var razonsocial = $('#razonsocial').val();
		var ruc = $('#ruc').val();
		$('.registro').html('<div class="loading"><img src="imagenes/loading.gif" width="70px"/></div>');
		var page = $(this).attr('data');
		
		$.ajax({
			type: "GET",
			url: "Adt/paginador.php",
			data: {page : page, desde : desde, hasta : hasta, razonsocial : razonsocial, ruc : ruc, id : id, log : log},
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
		if(search == 2){
			$('.filtro').fadeOut('slow');
			$('.serchFechas').delay(600).fadeIn('slow');
		}else{
			if(search == 5){
				$('.filtro').fadeOut('slow');
				$('.byRs').delay(600).fadeIn('slow');
			}else{
				if(search == 6){
					$('.filtro').fadeOut('slow');
					$('.byRuc').delay(600).fadeIn('slow');
				}
			}
		}
	}
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

function validarLetras(e) {
	tecla = (document.all) ? e.keyCode : e.which; 
	if (tecla==8) return true;
	patron =/[A-Za-zÒ—\s]/;
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

function cancel(){
	var search = $('#search').val();
		if(search == 2){
		$('.serchFechas').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search').val(0);
		$('.registro').html('');
		$('#desde').val('');
		$('#hasta').val('');
		$('#printCli1').prop('disabled',true);
	}else{
		if(search == 5){
			$('.byRs').fadeOut('slow');
			$('.filtro').delay(600).fadeIn('slow');
			$('#search').val(0);
			$('.registro').html('');
			$('#razonsocial').val('');
			$('#printCli2').prop('disabled',true);
		}else{
			if(search == 6){
				$('.byRuc').fadeOut('slow');
				$('.filtro').delay(600).fadeIn('slow');
				$('#search').val(0);
				$('.registro').html('');
				$('#ruc').val('');
				$('#printCli3').prop('disabled',true);
			}
		}
	}
}

function buscar(id){
	var log = $('#data').val();
	if(id == 2){
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
	if(id == 5){
		var razonsocial = $('#razonsocial').val();
		$.post('Adt/paginador.php',{
			razonsocial : razonsocial, id : id, log : log
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
	if(id == 6){
		var ruc = $('#ruc').val();
		$.post('Adt/paginador.php',{
			ruc : ruc, id : id, log : log
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
			var razonsocial = $('#razonsocial').val();
			$.post('Adt/reportes.php',{
				razonsocial : razonsocial, id : id, log : log
			}).done(function(data){
				window.open('Adt/pdf/'+data+'.pdf','nuevo','scrollbars=yes');
			});
		}else{
			if(id == 3){
				var ruc = $('#ruc').val();
				$.post('Adt/reportes.php',{
					ruc : ruc, id : id, log : log
				}).done(function(data){
					window.open('Adt/pdf/'+data+'.pdf','nuevo','scrollbars=yes');
				});
			}
		}
	}
}
</script>