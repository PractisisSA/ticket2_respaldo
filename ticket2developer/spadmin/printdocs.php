<?php 
	include("controlusuarios/seguridadSA.php");
	echo '<input type="hidden" id="data" value="6" />';
?>
<style>
	#mostrarDocs{
		position:absolute;
		top:35%;
		left:25%;
		display:none;
		background-color:#282b2d;
		border:#00ADEF 2px solid;
		color:#fff;
		width:50%;
		padding:25px;
	}
</style>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				Impresi&oacute;n de Documentos
			</div>
			<div id="ocultarDocs">
				<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:18px;">
					<p class="filtro"><strong>Buscar por: &nbsp;&nbsp;</strong>
						<select id="search2" class="inputlogin">
							<option value="0">Seleccione...</option>
							<option value="1">Todo</option>
							<option value="2">R.U.C.</option>
							<option value="3">Nombre Comercial</option>
							<option value="4"># de Autorizaci&oacute;n</option>
							<option value="5">Tipo de Documento</option>
						</select>
					</p>
					<p class="allreg" style="display:none;">
						<strong>TODO</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('1')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
						<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<p class="serchFechas" style="display:none;">
						<input type="text" maxlength="13" id="ruc" class="inputlogin" placeholder="R.U.C." onkeypress="return validarNumeros(event)">&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('2')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
						<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<p class="byUser" style="display:none;">
						<input type="text" id="nameSocio" class="inputlogin" placeholder="Nombre Comercial...">&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('3')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
						<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<p class="auto" style="display:none;">
						<input type="text" id="numautorizacion" class="inputlogin" maxlength="10" onkeypress="return validarNumeros(event)" placeholder="# de Autorizaci&oacute;n...">&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('4')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
						<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<p class="byDoc" style="display:none;">
						<strong>Tipo:</strong>&nbsp;
						<select id="tipDoc" class="inputlogin">
							<option value="0">Seleccione...</option>
							<option value="1">Factura</option>
							<option value="2">Boleto</option>
							<option value="3">Nota de Cr&eacute;dito</option>
							<option value="4">Nota de D&eacute;bito</option>
							<option value="5">Nota de Venta</option>
							<option value="6">Liquidaci&oacute;n de Compras</option>
							<option value="7">Gu&iacute;a de Remisi&oacute;n</option>
							<option value="8">Comprobante de Retenci&oacute;n</option>
							<option value="9">Tiquete Tax&iacute;metros y M. Registradoras</option>
							<option value="10">L. Compra Bienes Muebles usados</option>
							<option value="11">L. Compra Veh&iacute;culos usados</option>
							<option value="12">Acta entrega/recepci&oacute;n Veh&iacute;culos usuados</option>
						</select>&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('5')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;
						<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div style="border:2px solid #00ADEF; margin:40px; text-align:center;">
					<p id="realizados" style="">
						<table id="table_trabajos" style="width:100%; color:#fff; font-size:18px; border-collapse:separate; border-spacing:15px 5px;">
							<tr>
								<td>
									<div class="registro"></div>
								</td>
							</tr>
						</table>
					</p>
				</div>
				<div style="border:2px solid #00ADEF; margin:40px; text-align:center;">
					<table id="table_fac" style="width:100%; color:#fff; font-size:18px; border-collapse:separate; border-spacing:15px 5px; display:none;">
						
					</table>
				</div>
			</div>
			<div id="mostrarDocs">
				<table style="width:100%; color:#fff; font-size:18px; border-collapse:separate; border-spacing:5px 20px;" id="addSecuenciales">
				
				</table>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.paginate').live('click', function(){
		window.scroll(0,0);
		var sector = 8;
		var nombre = $('#nameSocio').val();
		var ruc = $('#ruc').val();
		var dato = $('#search2').val();
		var numautorizacion = $('#numautorizacion').val();
		var tipDoc = $('#tipDoc').val();
		$('.registro').html('<div class="loading"><center><img src="imagenes/loading.gif" width="70px"/></center></div>');
		var page = 1
		if(page == '333444555'){
			page = 1;
		}else{
			page = $(this).attr('data');
		}
		$.ajax({
			type: "GET",
			url: "spadmin/paginadorspA.php",
			data: {page : page, nombre : nombre, sector : sector, ruc : ruc, dato : dato, numautorizacion : numautorizacion, tipDoc : tipDoc},
			success: function(data){
				$('.registro').fadeIn(200).html(data);
			}
		});
	});
});

function validarNumeros(e) {
	tecla = (document.all) ? e.keyCode : e.which; 
	if (tecla==8) return true;
	if (tecla==32) return false;
	patron =/\d/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

$('#search2').on('change',function(){
	var search = $('#search2').val();
	if(search == 1){
		$('.filtro').fadeOut('slow');
		$('.allreg').delay(600).fadeIn('slow');
	}
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
	if(search == 5){
		$('.filtro').fadeOut('slow');
		$('.byDoc').delay(600).fadeIn('slow');
	}
});

function cancel(){
	var search = $('#search2').val();
	if(search == 1){
		$('.allreg').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search2').val(0);
		$('.registro').html('');
	}
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
	if(search == 5){
		$('.byDoc').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search2').val(0);
		$('.registro').html('');
		$('#tipDoc').val(0);
	}
}

function buscar(dato){
	$('.registro').html('<div class="loading" style="text-align:center;"><center><img src="imagenes/loading.gif" width="70px"/></center></div>');
	var sector = 8;
	if(dato == 1){
		var page = 1;
		$.post('spadmin/paginadorspA.php',{
			dato : dato, sector : sector , page : page
		}).done(function(data){
			$('.registro').fadeIn(400).html(data);
			// alert(data);
		});
	}
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
	if(dato == 5){
		var tipDoc = $('#tipDoc').val();
		$.post('spadmin/paginadorspA.php',{
			dato : dato, sector : sector, tipDoc : tipDoc
		}).done(function(data){
			$('.registro').fadeIn(400).html(data);
			// alert(data);
		});
	}
}

function cargarSecuencia(autorizados){
	var combo = 3;
	var info = 'sin info';
	$.post('spadmin/infodocs.php',{
		autorizados : autorizados, combo : combo, info : info
	}).done(function(data){
		$('#addSecuenciales').html(data);
		$('#mostrarDocs').fadeIn('slow');
		$('#ocultarDocs').css({opacity:0.2});
		$('#ocultarDocs').fadeIn('slow');
	});
}

function cancelarCreacion(){
	$('#autoriza').val(0);
	$('#numcopias').val(0);
	$('#mostrarDocs').fadeOut('slow');
	$('#ocultarDocs').delay(600).css({opacity:1.0});
	$('#ocultarDocs').delay(600).fadeIn('slow');
}

function crearFacs(info,cliente){
	var combo = 2;
	var inicial = $('#inicialPrint').val();
	var fin = $('#finalPrint').val();
	var inicialbd = $('#inicialbase').val();
	var finbd = $('#finalbase').val();
	var formaimpresion = $('#formaimpresion').val();
	if(info == 1){
		var ncopias = $('#numcopias').val();
		if((cliente == 0) || (inicial == '') || (fin == '')){
			alert('Completa toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/FACTURA'+data+'.pdf','_blank','scrollbars=yes');
							// window.setTimeout("window.open('spadmin/documentos/ANEXOFACTURANEGO"+data+".pdf','_blank','scrollbars=yes');", 1000);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Facturas con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/FACTURA'+data+'.pdf','_blanck','scrollbars=yes');
						// window.setTimeout("window.open('spadmin/documentos/ANEXOFACTURANEGO"+data+".pdf','_blank','scrollbars=yes');", 1000);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Facturas con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 13){
		var ncopias = $('#numcopias').val();
		if((cliente == 0) || (inicial == '') || (fin == '')){
			alert('Completa toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/FACTURA'+data+'.pdf','scrollbars=yes');
							window.setTimeout("window.open('spadmin/documentos/ANEXOFACTURANEGO"+data+".pdf','_blank','scrollbars=yes');", 1000);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Facturas con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/FACTURA'+data+'.pdf','scrollbars=yes');
						window.setTimeout("window.open('spadmin/documentos/ANEXOFACTURANEGO"+data+".pdf','_blank','scrollbars=yes');", 1000);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Facturas con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 2){
		var ncopias = $('#numcopias').val();
		if(cliente == 0){
			alert('Selecciona toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Notas de Venta con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Notas de Venta con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 3){
		var ncopias = $('#numcopias').val();
		if(cliente == 0){
			alert('Selecciona toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Notas de Débito con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Notas de Débito con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 4){
		var ncopias = $('#numcopias').val();
		if(cliente == 0){
			alert('Selecciona toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Notas de Crédito con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Notas de Crédito con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 5){
		if(cliente == 0){
			alert('Selecciona toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							// window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Boletos con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Boletos con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 6){
		var ncopias = $('#numcopias').val();
		if(cliente == 0){
			alert('Selecciona toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Lquidaciones con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, ncopias : ncopias, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Lquidaciones con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 7){
		if(cliente == 0){
			alert('Selecciona toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Guías con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Guías con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 8){
		if(cliente == 0){
			alert('Selecciona toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Comprobantes con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Comprobantes con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 9){
		if(cliente == 0){
			alert('Selecciona toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Tiquetes con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Tiquetes con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 10){
		if(cliente == 0){
			alert('Selecciona toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Lquidaciones con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Lquidaciones con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 11){
		if(cliente == 0){
			alert('Selecciona toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Lquidaciones con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Lquidaciones con exito!');
						window.location = '';
					}
				});
			}
		}
	}
	if(info == 12){
		if(cliente == 0){
			alert('Selecciona toda la información');
		}else{
			if((inicial >= inicialbd) && (fin < finbd)){
				var r = confirm("¿Deseas imprimir incompleto este documento?");
				if(r == true){
					$('#wait').fadeIn('slow');
					$('#createFac').delay(600).fadeOut('slow');
					$('#confirmarPrint').delay(600).fadeOut('slow');
					$('#mostrarDocs').delay(600).fadeOut('slow');
					$.post('spadmin/infodocs.php',{
						cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
					}).done(function(data){
						if($.trim(data) == 'error1'){
							alert('ERROR: Secuencial Inicial menor al ingresado...');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else if($.trim(data) == 'error2'){
							alert('ERROR: Secuencial Final mayor al ingresado');
							$('#autoriza').val(0);
							$('#numcopias').val(0);
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							$('#confirmarPrint').delay(600).fadeIn('slow');
						}else{
							window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
							$('#mostrarDocs').fadeOut('slow');
							$('#wait').fadeOut('slow');
							$('#ocultarDocs').delay(600).css({opacity:1.0});
							$('#ocultarDocs').delay(600).fadeIn('slow');
							$('#createFac').delay(600).fadeIn('slow');
							alert('Impresión de Actas con exito!');
							window.location = '';
						}
					});
				}else{
					$('#inicialPrint').val(inicialbd);
					$('#finalPrint').val(finbd);
				}
			}else{
				$('#wait').fadeIn('slow');
				$('#createFac').delay(600).fadeOut('slow');
				$('#confirmarPrint').delay(600).fadeOut('slow');
				$('#mostrarDocs').delay(600).fadeOut('slow');
				$.post('spadmin/infodocs.php',{
					cliente : cliente, combo : combo, info : info, inicial : inicial, fin : fin, formaimpresion : formaimpresion
				}).done(function(data){
					if($.trim(data) == 'error1'){
						alert('ERROR: Secuencial Inicial menor al ingresado...');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else if($.trim(data) == 'error2'){
						alert('ERROR: Secuencial Final mayor al ingresado');
						$('#autoriza').val(0);
						$('#numcopias').val(0);
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						$('#confirmarPrint').delay(600).fadeIn('slow');
					}else{
						window.open('spadmin/documentos/'+data+'.pdf','nuevo','scrollbars=yes');
						$('#mostrarDocs').fadeOut('slow');
						$('#wait').fadeOut('slow');
						$('#ocultarDocs').delay(600).css({opacity:1.0});
						$('#ocultarDocs').delay(600).fadeIn('slow');
						$('#createFac').delay(600).fadeIn('slow');
						alert('Impresión de Actas con exito!');
						window.location = '';
					}
				});
			}
		}
	}
}
</script>