<?php 
	// include("controlusuarios/seguridadSP.php");
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="5" />';
	
	$gbd = new DBConn();
	
	$select = "SELECT nombresS, nroestablecimientoS, rucS FROM Socio";
	$slt = $gbd -> prepare($select);
	$slt -> execute();
	$content = '';
	while($row = $slt -> fetch(PDO::FETCH_ASSOC)){
		$content .= '<div class="sociook"><input type="hidden" class="razonbd" value="'.$row['nombresS'].'" />
					<input type="hidden" class="rucs" value="'.$row['rucS'].'" /></div>';
	}
	echo $content;
	
	$sql = "SELECT * FROM ticktfacil";
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute();
	$rowemp = $stmt -> fetch(PDO::FETCH_ASSOC);
	echo '<input type="hidden" id="rucEmp" value="'.$rowemp['rucTF'].'" />
			<input type="hidden" id="razonEmp" value="'.$rowemp['nombresTF'].'" />
			<input type="hidden" id="nombreEmp" value="'.$rowemp['razonsocialTF'].'" />';
?>
<style>
.tipoRise{
	display:none;
}
</style>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 500px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				<strong>Datos Personales del Empresario</strong>
			</div>
			<div id="invalido" style="display:none;">
				<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; padding:10px 40px 20px; color:#fff;">
					<table style="width:100%; text-align:center;">
						<tr>
							<td>
								<h2><strong>Debes Parametrizar la Empresa para acceder a este Modulo</strong></h2><br>
								<h3><strong>Configura tu Empresa <a href="?modulo=ticketFacil" style="text-decoration:none; color:#333333;">AQUI</a></strong></h3>
							</td>
						</tr>
					</table>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
			</div>
			<div id="validado" style="display:none;">
				<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; padding:10px 40px 20px; color:#fff;">
					<div>
						<div class="alert alert-success" role="alert" id="alerta1" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							<strong>Error...!</strong> Esta Razón Social ya existe.
						</div>
						<div class="alert alert-success alert-dismissible" id="alerta2" role="alert" style="margin:0 60px 0 20px; display:none;">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							<strong>Error...!</strong> Este RUC ya existe.
						</div>
						<div class="alert alert-success" role="alert" id="alerta3" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							<strong>Error...!</strong> RUC Incorrecto, digitelo otra vez.
						</div>
						<div class="alert alert-success" role="alert" id="alerta4" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							<strong>Error...!</strong> Teléfono móvil incorrecto.
						</div>
						<div class="alert alert-success" role="alert" id="alerta5" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							<strong>Error...!</strong> Teléfono fijo incorrecto.
						</div>
						<div class="alert alert-success" role="alert" id="alerta6" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							<strong>Error...!</strong> E-mail Incorrecto, digitelo otra vez.
						</div>
						<div class="alert alert-info" role="alert" id="alerta7" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<strong>Excelente!</strong> Nuevo Empresario ingresado.
						</div>
					</div>
					<div class="row">
						<div class="col-lg-10">
							<h4><strong>Raz&oacute;n Social (*):</strong></h4>
							<input type="text" id="nombres" class="form-control inputlogin" onkeyup="validarRepetidos(this.value)" onkeydown="justText(event,this.value)" placeholder="Obligatorio" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>R.U.C. (*):</strong></h4>
							<input type="text" id="ruc" class="form-control inputlogin" onkeyup="validarRepetidos(this.value)" onkeydown="justInt(event,this.value)" onchange="ValidarCedula()" placeholder="Obligatorio" maxlength="13" />
						</div>
						<div class="col-lg-5">
							<h4><strong>Nombre Comercial (*):</strong></h4>
							<input type="text" id="razonsocial" class="form-control inputlogin" onkeydown="justText(event,this.value)" placeholder="Obligatorio" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Tel&eacute;fono M&oacute;vil (*):</strong></h4>
							<input type="text" id="movil" class="form-control inputlogin" placeholder="0999999999" maxlength="10" onkeydown="justInt(event,this.value)" />
							<div id="errorMovil" class="smserrorTel" style="text-align:left;"><I>N&uacute;mero M&oacute;vil Incorrecto</I></div>
						</div>
						<div class="col-lg-5">
							<h4><strong>Tel&eacute;fono Fijo (*):</strong></h4>
							<input type="text" id="fijo" class="form-control inputlogin" placeholder="022222222" maxlength="9" onkeydown="justInt(event,this.value)" />
							<div id="errorFijo" class="smserrorTel" style="text-align:left;"><I>N&uacute;mero Fijo Incorrecto</I></div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>E-mail (*):</strong></h4>
							<input type="text" id="mail" class="form-control inputlogin" placeholder="ejemplo@dominio.com" onchange="return validarMail()" />
						</div>
						<div class="col-lg-5">
							<h4><strong>Clase del Contribuyente (*):</strong></h4>
							<select id="contribuyente" class="form-control inputlogin">
								<option value="0">Seleccione...</option>
								<option value="1">Obligado a llevar Contabilidad</option>
								<option value="2">No Obligado a llevar Contabilidad</option>
								<option value="3">Contribuyente Especial</option>
								<option value="4">Contribuyente RISE</option>
							</select>
							<h4><input type="text" id="conEspecial" class="form-control inputlogin" style="display:none;" onkeydown="justInt(event,this.value)" placeholder="Nro. Contribuyente Especial" /></h4>
						</div>
					</div>
					<div class="row tipoRise">
						<div class="col-lg-5">
							<h4><strong>Actividad Económica</strong></h4>
							<select class="form-control inputlogin" id="actividadEconomica">
								<option value="0">Seleccione...</option>
								<option value="1">Actividades de Comercio</option>
								<option value="2">Actividades de Servicio</option>
								<option value="3">Actividades de Manufactura</option>
								<option value="4">Actividades de Construcción</option>
								<option value="5">Hoteles y Restaurantes</option>
								<option value="6">Actividades de Trasnporte</option>
								<option value="7">Actividades Agrícolas</option>
								<option value="8">Actividades de Minas y Canteras</option>
							</select>
						</div>
						<div class="col-lg-5">
							<h4><strong>Categoría</strong></h4>
							<select class="form-control inputlogin" id="categoria">
								<option value="0">Seleccione...</option>
								<option value="1">Categoría 1</option>
								<option value="2">Categoría 2</option>
								<option value="3">Categoría 3</option>
								<option value="4">Categoría 4</option>
								<option value="5">Categoría 5</option>
								<option value="6">Categoría 6</option>
								<option value="7">Categoría 7</option>
							</select>
						</div>
					</div>
					<div class="row tipoRise" style="text-align:center;">
						<div class="col-lg-10">
							<h4><strong>Intervalos de Ingresos</strong></h4>
						</div>
					</div>
					<div class="row tipoRise" style="text-align:center;">
						<div class="col-lg-5">
							<h4><strong>Anuales</strong></h4>
							Desde&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta<br>
							$<input type="text" id="inferior1" class="inputopcional" readonly="readonly" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							$<input type="text" id="superior1" class="inputopcional" readonly="readonly" size="10" />
						</div>
						<div class="col-lg-5">
							<h4><strong>Mensuales Promedio</strong></h4>
							Desde&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta<br>
							$<input type="text" id="inferior2" class="inputopcional" readonly="readonly" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							$<input type="text" id="superior2" class="inputopcional" readonly="readonly" size="10" />
						</div>
					</div>
					<div class="row tipoRise" style="text-align:center;">
						<div class="col-lg-10">
							<h4><strong>Monto M&aacute;ximo para cada Documento</strong></h4>
							$<input type="text" id="monto" class="inputopcional" readonly="readonly" />,00 Dólares.
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Los Documentos son para tu:</strong></h4>
						</div>
						<div class="col-lg-5">
							<h4><input type="radio" name="dirs" id="matriz" />&nbsp;&nbsp;<strong>Matriz</strong>&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="dirs" id="sucursal" />&nbsp;&nbsp;<strong>Sucursal</strong></h4>
						</div>
					</div>
					<div class="row" id="matrizcheck" style="display:none;">
						<div class="col-lg-10">
							<h4><strong>Direcci&oacute;n Matriz (*):</strong></h4>
							<input type="text" class="form-control inputlogin" id="dirmatriz" placeholder="Av. Principal y Transversal..." />
						</div>
					</div>
					<div class="row" id="sucursalcheck" style="display:none;">
						<div class="col-lg-10">
							<h4><strong>Direcci&oacute;n del Establecimiento (*):</strong></h4>
							<input type="text" class="form-control inputlogin" id="dir" placeholder="Av. Principal y Transversal...(Puede ser la misma direcci&oacute;n matriz)" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Fecha Inicio Actividades (*):</strong></h4>
							<input type="text" class="form-control inputlogin datepicker" style="color:#000;" id="actividades" placeholder="AAAA/MM/DD" readonly="readonly" />
						</div>
						<div class="col-lg-5">
							<h4><strong>Fecha Inscripci&oacute;n (*):</strong></h4>
							<input type="text" class="form-control inputlogin datepicker" style="color:#000;" id="inscripcion" placeholder="AAAA/MM/DD" readonly="readonly" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Serie del Establecimiento (*):</strong></h4>
							<input type="text" id="serieEstab" class="form-control inputlogin" placeholder="ejemplo: 001 / 002 / 00..." onkeydown="justInt(event,this.value)" maxlength="3" />
						</div>
						<div class="col-lg-5">
							<h4><strong>Observaciones (*):</strong></h4>
							<textarea cols="30" rows="5" id="obs" class="form-control inputlogin" placeholder="Observaciones de Creaci&oacute;n" maxlength="1000" onkeydown="justText(event,this.value)"></textarea>
						</div>
					</div>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div style="text-align:center; margin:20px; padding:20px 0;">
					<button type="submit" class="btndegradate" id="cancelar" >CANCELAR</button>&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="submit" class="btndegradate" id="enviar" onclick="enviarDatos()">GUARDAR</button>
					<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>
				</div>
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
});

$(function() {
	$('.datepicker').datepicker({
		showOn: 'focus',
		buttonText: '.',
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
        changeYear: true
	});
});

$('#movil').on('change', function(){
	var numMovil = $('#movil').val().length;
	if(numMovil < 10){
		$('#movil').val('');
		$('#movil').focus();
		$('#alerta4').fadeIn();
		$('#alerta4').delay(2500).fadeOut();
	}
});

$('#fijo').on('change', function(){
	var numFijo = $('#fijo').val().length;
	if(numFijo < 9){
		$('#fijo').val('');
		$('#fijo').focus();
		$('#alerta5').fadeIn();
		$('#alerta5').delay(2500).fadeOut();
	}
});

$('#contribuyente').on('change',function(){
	var select = $('#contribuyente').val();
	if(select == 3){
		$('#conEspecial').fadeIn('slow');
	}else{
		$('#conEspecial').fadeOut('slow');
	}
	if(select == 4){
		$('.tipoRise').fadeIn('slow');
	}else{
		$('.tipoRise').fadeOut('slow');
	}
});

$('#categoria').on('change',function(){
	var actividad = $('#actividadEconomica').val();
	var categoria = $('#categoria').val();
	if(actividad == 0){
		$('#categoria').val(0);
		alert('Selecciona una Actividad Económica');
	}else{
		if(categoria == 1){
			$('#inferior1').val(0);
			$('#superior1').val(5000);
			$('#inferior2').val(0);
			$('#superior2').val(417);
			if(actividad == 1){
				$('#monto').val(150);
			}else if(actividad == 2){
				$('#monto').val(250);
			}else if(actividad == 3){
				$('#monto').val(250);
			}else if(actividad == 4){
				$('#monto').val(400);
			}else if(actividad == 5){
				$('#monto').val(150);
			}else if(actividad == 6){
				$('#monto').val(250);
			}else if(actividad == 7){
				$('#monto').val(400);
			}else if(actividad == 8){
				$('#monto').val(400);
			}
		}
		if(categoria == 2){
			$('#inferior1').val(5001);
			$('#superior1').val(10000);
			$('#inferior2').val(418);
			$('#superior2').val(833);
			if(actividad == 1){
				$('#monto').val(150);
			}else if(actividad == 2){
				$('#monto').val(250);
			}else if(actividad == 3){
				$('#monto').val(250);
			}else if(actividad == 4){
				$('#monto').val(400);
			}else if(actividad == 5){
				$('#monto').val(150);
			}else if(actividad == 6){
				$('#monto').val(250);
			}else if(actividad == 7){
				$('#monto').val(400);
			}else if(actividad == 8){
				$('#monto').val(400);
			}
		}
		if(categoria == 3){
			$('#inferior1').val(10001);
			$('#superior1').val(20000);
			$('#inferior2').val(834);
			$('#superior2').val(1667);
			if(actividad == 1){
				$('#monto').val(200);
			}else if(actividad == 2){
				$('#monto').val(350);
			}else if(actividad == 3){
				$('#monto').val(350);
			}else if(actividad == 4){
				$('#monto').val(600);
			}else if(actividad == 5){
				$('#monto').val(200);
			}else if(actividad == 6){
				$('#monto').val(350);
			}else if(actividad == 7){
				$('#monto').val(600);
			}else if(actividad == 8){
				$('#monto').val(600);
			}
		}
		if(categoria == 4){
			$('#inferior1').val(20001);
			$('#superior1').val(30000);
			$('#inferior2').val(1668);
			$('#superior2').val(2500);
			if(actividad == 1){
				$('#monto').val(200);
			}else if(actividad == 2){
				$('#monto').val(350);
			}else if(actividad == 3){
				$('#monto').val(350);
			}else if(actividad == 4){
				$('#monto').val(600);
			}else if(actividad == 5){
				$('#monto').val(200);
			}else if(actividad == 6){
				$('#monto').val(350);
			}else if(actividad == 7){
				$('#monto').val(300);
			}else if(actividad == 8){
				$('#monto').val(600);
			}
		}
		if(categoria == 5){
			$('#inferior1').val(30001);
			$('#superior1').val(40000);
			$('#inferior2').val(2501);
			$('#superior2').val(3333);
			if(actividad == 1){
				$('#monto').val(200);
			}else if(actividad == 2){
				$('#monto').val(350);
			}else if(actividad == 3){
				$('#monto').val(350);
			}else if(actividad == 4){
				$('#monto').val(600);
			}else if(actividad == 5){
				$('#monto').val(200);
			}else if(actividad == 6){
				$('#monto').val(350);
			}else if(actividad == 7){
				$('#monto').val(600);
			}else if(actividad == 8){
				$('#monto').val(600);
			}
		}
		if(categoria == 6){
			$('#inferior1').val(40001);
			$('#superior1').val(50000);
			$('#inferior2').val(3334);
			$('#superior2').val(4167);
			if(actividad == 1){
				$('#monto').val(250);
			}else if(actividad == 2){
				$('#monto').val(450);
			}else if(actividad == 3){
				$('#monto').val(450);
			}else if(actividad == 4){
				$('#monto').val(1000);
			}else if(actividad == 5){
				$('#monto').val(250);
			}else if(actividad == 6){
				$('#monto').val(450);
			}else if(actividad == 7){
				$('#monto').val(1000);
			}else if(actividad == 8){
				$('#monto').val(1000);
			}
		}
		if(categoria == 7){
			$('#inferior1').val(50001);
			$('#superior1').val(60000);
			$('#inferior2').val(4168);
			$('#superior2').val(5000);
			if(actividad == 1){
				$('#monto').val(250);
			}else if(actividad == 2){
				$('#monto').val(450);
			}else if(actividad == 3){
				$('#monto').val(450);
			}else if(actividad == 4){
				$('#monto').val(1000);
			}else if(actividad == 5){
				$('#monto').val(250);
			}else if(actividad == 6){
				$('#monto').val(450);
			}else if(actividad == 7){
				$('#monto').val(1000);
			}else if(actividad == 8){
				$('#monto').val(1000);
			}
		}
		if(categoria == 0){
			$('#inferior1').val('');
			$('#superior1').val('');
			$('#inferior2').val('');
			$('#superior2').val('');
			$('#monto').val('');
			alert('Selecciona una categoría');
		}
	}
});

$('#actividadEconomica').on('change',function(){
	var actividad = $('#actividadEconomica').val();
	if(actividad == 0){
		alert('Debes escojer una Actividad');
		$('#categoria').val(0);
		$('#inferior1').val('');
		$('#superior1').val('');
		$('#inferior2').val('');
		$('#superior2').val('');
		$('#monto').val('');
	}else{
		$('#categoria').val(0);
		$('#inferior1').val('');
		$('#superior1').val('');
		$('#inferior2').val('');
		$('#superior2').val('');
		$('#monto').val('');
	}
});

function justInt(e,value){
    if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 13)){
        return;
	}else{
        e.preventDefault();
	}
}
	
function justText(e,value){
	if(e.keyCode >= 65 && e.keyCode <= 90 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 8 || e.keyCode == 46 || e.keyCode == 9 || e.which == 0 || e.keyCode == 32){
		return;
	}else{
		e.preventDefault();
	}
}	

function validarMail(){
	var email = $('#mail').val();
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
		$('#mail').val('');
		$('#alerta6').fadeIn();
		$('#alerta6').delay(3000).fadeOut();
	}
}

function validarRepetidos(valor){
	if(!$('#alerta1').is(':hidden')){
		$('#alerta1').fadeOut();
	}
	if(!$('#alerta2').is(':hidden')){
		$('#alerta2').fadeOut();
	}
	$('.sociook').each(function(){
		var rucok = $(this).find('.rucs').val();
		if(valor == rucok){
			$('#alerta2').fadeIn();
			$('#ruc').val('');
			return false;
		}
		var razonok = $(this).find('.razonbd').val();
		razonok = razonok.toLowerCase();
		valor = valor.toLowerCase();
		if(valor == razonok){
			$('#alerta1').fadeIn();
			$('#nombres').val('');
			return false;
		}
	});
}

function ValidarCedula(){
		var numero = $('#ruc').val();
		var suma = 0;
		var residuo = 0;
		var pri = false;
		var pub = false;
		var nat = false;
		var numeroProvincias = 24;
		var modulo = 11;

		/* Verifico que el campo no contenga letras */
		var ok=1;
		/* Aqui almacenamos los digitos de la cedula en variables. */
		d1 = numero.substr(0,1);
		d2 = numero.substr(1,1);
		d3 = numero.substr(2,1);
		d4 = numero.substr(3,1);
		d5 = numero.substr(4,1);
		d6 = numero.substr(5,1);
		d7 = numero.substr(6,1);
		d8 = numero.substr(7,1);
		d9 = numero.substr(8,1);
		d10 = numero.substr(9,1);

		/* El tercer digito es: */
		/* 9 para sociedades privadas y extranjeros */
		/* 6 para sociedades publicas */
		/* menor que 6 (0,1,2,3,4,5) para personas naturales */

		if (d3==7 || d3==8){
		console.log('El tercer dígito ingresado es inválido');
		$('#ruc').val('');
		$('#alerta3').fadeIn();
		$('#alerta3').delay(3000).fadeOut();
		return false;
		}

		/* Solo para personas naturales (modulo 10) */
		if (d3 < 6){
		nat = true;
		p1 = d1 * 2; if (p1 >= 10) p1 -= 9;
		p2 = d2 * 1; if (p2 >= 10) p2 -= 9;
		p3 = d3 * 2; if (p3 >= 10) p3 -= 9;
		p4 = d4 * 1; if (p4 >= 10) p4 -= 9;
		p5 = d5 * 2; if (p5 >= 10) p5 -= 9;
		p6 = d6 * 1; if (p6 >= 10) p6 -= 9;
		p7 = d7 * 2; if (p7 >= 10) p7 -= 9;
		p8 = d8 * 1; if (p8 >= 10) p8 -= 9;
		p9 = d9 * 2; if (p9 >= 10) p9 -= 9;
		modulo = 10;
		}

		/* Solo para sociedades publicas (modulo 11) */
		/* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
		else if(d3 == 6){
		pub = true;
		p1 = d1 * 3;
		p2 = d2 * 2;
		p3 = d3 * 7;
		p4 = d4 * 6;
		p5 = d5 * 5;
		p6 = d6 * 4;
		p7 = d7 * 3;
		p8 = d8 * 2;
		p9 = 0;
		}

		/* Solo para entidades privadas (modulo 11) */
		else if(d3 == 9) {
		pri = true;
		p1 = d1 * 4;
		p2 = d2 * 3;
		p3 = d3 * 2;
		p4 = d4 * 7;
		p5 = d5 * 6;
		p6 = d6 * 5;
		p7 = d7 * 4;
		p8 = d8 * 3;
		p9 = d9 * 2;
		}

		suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;
		residuo = suma % modulo;

		/* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
		digitoVerificador = residuo==0 ? 0: modulo - residuo;

		/* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/
		if (pub==true){
		if (digitoVerificador != d9){
		console.log('El ruc de la empresa del sector público es incorrecto.');
		$('#alerta3').fadeIn();
		$('#alerta3').delay(3000).fadeOut();
		return false;
		}
		/* El ruc de las empresas del sector publico terminan con 0001*/
		if ( numero.substr(9,4) != '0001' ){
		console.log('El ruc de la empresa del sector público debe terminar con 0001');
		$('#ruc').val('');
		$('#alerta3').fadeIn();
		$('#alerta3').delay(3000).fadeOut();
		return false;
		}
		}
		else if(pri == true){
		if (digitoVerificador != d10){
		console.log('El ruc de la empresa del sector privado es incorrecto.');
		$('#ruc').val('');
		$('#alerta3').fadeIn();
		$('#alerta3').delay(3000).fadeOut();
		return false;
		}
		if ( numero.substr(10,3) != '001' ){
		console.log('El ruc de la empresa del sector privado debe terminar con 001');
		$('#ruc').val('');
		$('#alerta3').fadeIn();
		$('#alerta3').delay(3000).fadeOut();
		return false;
		}
		}

		else if(nat == true){
		if (digitoVerificador != d10){
		console.log('El número de cédula de la persona natural es incorrecto.');
		$('#ruc').val('');
		$('#alerta3').fadeIn();
		$('#alerta3').delay(3000).fadeOut();
		return false;
		}
		if (numero.length >10 && numero.substr(10,3) != '001' ){
		console.log('El ruc de la persona natural debe terminar con 001');
		$('#ruc').val('');
		$('#alerta3').fadeIn();
		$('#alerta3').delay(3000).fadeOut();
		return false;
		}
		}
		return true;
}

$('#serieEstab').on('change',function(){
	var serie = $('#serieEstab').val();
	var ruc = $('#ruc').val();
	var count = 1;
	$('.verificarserie').each(function(){
		var seriebd = $('#series'+count).val();
		var rucbd = $('#rucs'+count).val();
		if((serie == seriebd) && (ruc == rucbd)){
			$('#serieEstab').val('');
			alert('Ya tienes un establecimiento con este código');
			return false;
		}
	});
});

$('#conEspecial').on('change',function(){
	var numero = $('#conEspecial').val();
	if(numero == 0){
		alert('Numero Contribuyente Especial no puede ser 0');
		$('#conEspecial').val('');
	}
});

$('#matriz').on('click',function(){
	if(!$('#sucursalcheck').is(':hidden')){
		$('#sucursalcheck').fadeOut();
	}
	if($('#matriz').is(':checked')){
		$('#matrizcheck').fadeIn();
	}
});

$('#sucursal').on('click',function(){
	if($('#sucursal').is(':checked')){
		$('#matrizcheck').fadeIn();
		$('#sucursalcheck').fadeIn();
	}
});

function enviarDatos(){
	$('#enviar').fadeOut('slow');
	$('#cancelar').fadeOut('slow');
	$('#wait').delay(600).fadeIn('slow');
	var nombres = $('#nombres').val();
	var ruc = $('#ruc').val();
	var razonsocial = $('#razonsocial').val();
	var dirmatriz = '';
	var dir = '';
	var printpara = '';
	if($('#matriz').is(':checked')){
		dirmatriz = $('#dirmatriz').val();
		dir = 'Sin Direccion Sucursal';
		printpara = 'm';
	}else if($('#sucursal').is(':checked')){
		dirmatriz = $('#dirmatriz').val();
		dir = $('#dir').val();
		printpara = 's';
	}
	var establecimiento = $('#establecimiento').val();
	var mail = $('#mail').val();
	var contribuyente = $('#contribuyente').val();
	if(contribuyente == 3){
		var nrocontribuyente = $('#conEspecial').val();
	}else{
		var nrocontribuyente = 'No es contribuyente Especial';
	}
	var actividades = $('#actividades').val();
	var inscripcion = $('#inscripcion').val();
	var serieEstab = $('#serieEstab').val();
	var obs = $('#obs').val();
	var movil = $('#movil').val();
	var fijo = $('#fijo').val();
	var actividad = $('#actividadEconomica').val();
	var categoria = $('#categoria').val();
	var inferior1 = $('#inferior1').val();
	var superior1 = $('#superior1').val();
	var inferior2 = $('#inferior2').val();
	var superior2 = $('#superior2').val();
	var monto = $('#monto').val();
	
	if((nombres == '') || (ruc == '') || (razonsocial == '') || (establecimiento == '') || (mail == '') || (contribuyente == 0) || (actividades == '') || (inscripcion == '') || (obs == '') || (serieEstab == 0) || (dirmatriz == '') || (dir == '') || (printpara == '')){
		alert('Campos Vacios');
	}else if((contribuyente == 3) && (nrocontribuyente == '')){
		alert('Campos Vacios');
	}else if((contribuyente == 4) && ((actividad == 0) || (categoria == 0))){
		alert('Campos Vacios');
	}else{
		$.post('SP/guardarsocio.php',{
			nombres : nombres, ruc : ruc, razonsocial : razonsocial, establecimiento : establecimiento, mail : mail,
			contribuyente : contribuyente, actividades : actividades, inscripcion : inscripcion, obs : obs, dirmatriz : dirmatriz, dir : dir,
			movil : movil, fijo : fijo, nrocontribuyente : nrocontribuyente, serieEstab : serieEstab, actividad : actividad, categoria : categoria,
			inferior1 : inferior1, superior1 : superior1, inferior2 : inferior2, superior2 : superior2, monto : monto, printpara : printpara
		}).done(function(data){
			if($.trim(data) == 'ok'){
				alert('El empresario : '+ nombres + ' a sido creado con exito , a continuacion creara el socio con los datos faltante')
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				setTimeout("window.location.href = '?modulo=crearUsuarios&mail="+mail+"&movil="+movil+"&fijo="+fijo+"&ident=usu_emp&dirmatriz="+dirmatriz+"';",2500);
			}
		});
	}
}

$('#cancelar').on('click',function(){
	window.location = '';
});
</script>