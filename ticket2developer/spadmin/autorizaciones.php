<?php
	//include("controlusuarios/seguridadSA.php");
	echo '<input type="hidden" id="data" value="4" />';
	
	$gbd = new DBConn();
	
	$select = "SELECT nroautorizacionA FROM autorizaciones";
	$slt = $gbd -> prepare($select);
	$slt -> execute();
	$numresult = $slt -> rowCount();
	echo '<input type="hidden" id="numresult" value="'.$numresult.'" />';
	echo '<table>';
		$contar = 1;
		while($row = $slt -> fetch(PDO::FETCH_ASSOC)){
			echo '<tr class="busnum">
					<td>
						<input type="hidden" id="Nauto'.$contar.'" value="'.$row['nroautorizacionA'].'" />
					</td>
				</tr>';
			$contar++;
		}
	echo '</table>
	<input type="hidden" id="vacios" value="" />';
	
	//validar que las series no se repitan entre facturas negociables y comerciales
	$selectdatos = "SELECT idsocioA, codestablecimientoAHIS, facnegociablesA, tipodocumentoA, serieemisionA, secuencialinicialA, secuencialfinalA, imprimirparaA FROM autorizaciones";
	$sltdatos = $gbd -> prepare($selectdatos);
	$sltdatos -> execute();
	$contentdatos = '';
	while($rowdatos = $sltdatos -> fetch(PDO::FETCH_ASSOC)){
		$contentdatos .= '<div class="databd" style="display:none;">
							<input type="hidden" class="sociodb" value="'.$rowdatos['idsocioA'].'" />
							<input type="hidden" class="codbd" value="'.$rowdatos['codestablecimientoAHIS'].'-'.$rowdatos['serieemisionA'].'" />
							<input type="hidden" class="docnegodb" value="'.$rowdatos['facnegociablesA'].'" />
							<input type="hidden" class="docsdb" value="'.$rowdatos['tipodocumentoA'].'" />
							<input type="hidden" class="inicialdb" value="'.$rowdatos['secuencialinicialA'].'" />
							<input type="hidden" class="finaldb" value="'.$rowdatos['secuencialfinalA'].'" />
							<input type="hidden" class="printfordb" value="'.$rowdatos['imprimirparaA'].'" />
						</div>';
	}
	echo $contentdatos;
	//
	$selectcomparar = "SELECT * FROM Socio";
	$stmt = $gbd -> prepare($selectcomparar);
	$stmt -> execute();
	
	$content = '<table style="display:none;">';
	while($rowcomparar = $stmt -> fetch(PDO::FETCH_ASSOC)){
		$content .= '<tr class="datosbd">
						<td>
							<input type="hidden" class="ruc" value="'.$rowcomparar['rucS'].'" />
						</td>
						<td>
							<input type="hidden" class="comercial" value="'.$rowcomparar['razonsocialS'].'" />
						</td>
					</tr>';
	}
	$content .= '</table>';
	
	echo $content;
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div id="choose">
				<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
					<p id="create">Crear Autorizaci&oacute;n</p>
					<p id="listAuto" style="display:none;">Lista de Autorizaciones</p>
				</div>
				<div style="background-color:#00ADEF; margin:20px -42px -10px 40px; position:relative; padding:20px 0 10px; text-align:center; color:#fff; font-size:18px;">
					<p class="filtro"><strong>Buscar por: &nbsp;&nbsp;</strong>
					<select id="search" class="inputlogin">
						<option value="0">Seleccione...</option>
						<option value="1">R.U.C.</option>
						<option value="2">Nombre Comercial</option>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="lista" class="btnlink">Lista de Autorizaciones</button><button id="canceLista" style="display:none;" class="btnlink">Cancelar</button></p>
					<p class="serchFechas" style="display:none;">
						<strong>R.U.C.:</strong>&nbsp;&nbsp;<input type="text" maxlength="13" id="ruc" class="inputlogin">&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('1')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
						<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</p>
					<p class="byUser" style="display:none;">
						<strong>Nombre Comercial:</strong>&nbsp;&nbsp;<input type="text" id="nameSocio" class="inputlogin">&nbsp;&nbsp;&nbsp;&nbsp;
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
			<div id="cargar" style="display:none;">
				<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
					Crear Autorizaci&oacute;n
				</div>
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
<script>
	function actualizaAutorizacion(id){
		//alert(id)
		var rucCliente = $('#rucCliente').val();
		var razonsocial = $('#razonsocial').val(); 
		var establecimiento = $('#establecimiento').val();
		var serie = $('#serie').val();
		var matriz = $('#matriz').val();
		var direstab = $('#direstab').val();
		var contribuyente = $('#contribuyente').val();
		var nrocontribuyente = $('#nrocontribuyente').val();
		var fauto = $('#fauto').val();
		var fcadu = $('#fcadu').val();
		var nroAuto = $('#nroAuto').val();
		var nego = $('#nego').val();
		var obs = $('#obs').val();
		
		var dod_serie = $('#dod_serie').val();
		var tipodocumentoA = $('#tipodocumentoA').val();
		var inicial = $('#inicial').val();
		var final_ = $('#final').val(); 
		
		$.post('spadmin/actualizaAutorizacion.php',{
			rucCliente : rucCliente , razonsocial : razonsocial , establecimiento : establecimiento , serie : serie , matriz : matriz , direstab : direstab , 
			contribuyente : contribuyente , nrocontribuyente : nrocontribuyente , fauto : fauto , fcadu : fcadu , nroAuto : nroAuto , nego : nego , obs : obs , 
			dod_serie : dod_serie , dod_serie : dod_serie , tipodocumentoA : tipodocumentoA , inicial : inicial , final_ : final_ , id : id
		}).done(function(data){
			alert(data);
			abrirAuto(nroAuto);
		});
		
		
	}
$('#lista').on('click',function(){
	$('#lista').fadeOut('slow');
	$('#create').fadeOut('slow');
	$('#canceLista').delay(600).fadeIn('slow');
	$('#search').delay(600).fadeIn('slow');
	$('#listAuto').delay(600).fadeIn('slow');
	$('#data').val(5);
});

$('#canceLista').on('click',function(){
	$('#canceLista').fadeOut('slow');
	$('#listAuto').fadeOut('slow');
	$('#lista').delay(600).fadeIn('slow');
	$('#search').delay(600).fadeIn('slow');
	$('#create').delay(600).fadeIn('slow');
	$('#data').val(4);
});

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

function buscar(dato){
	$('.registro').html('<div class="loading" style="text-align:center;"><img src="imagenes/loading.gif" width="70px"/></div>');
	var sector = $('#data').val();
	if(dato == 1){
		var ruc = $('#ruc').val();
		$.post('spadmin/paginadorspA.php',{
			dato : dato, sector : sector, ruc : ruc
		}).done(function(data){
			$('.registro').fadeIn(400).html(data);
			// alert(data);
		});
	}
	if(dato == 2){
		var nombre = $('#nameSocio').val();
		$.post('spadmin/paginadorspA.php',{
			dato : dato, sector : sector, nombre : nombre
		}).done(function(data){
			$('.registro').fadeIn(400).html(data);
			// alert(data);
		});
	}
}

function validarLetras(e) {
	tecla = (document.all) ? e.keyCode : e.which; 
	if (tecla==8) return true;
	patron =/[A-Za-zñÑs]/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}	

function date(){
	$('#fcadu').datepicker({
		showOn: 'button',
		buttonImage: 'imagenes/bg-calendario.png',
		buttonImageOnly: true,
		buttonText: 'Select date',
		dateFormat: 'yy-mm-dd',
		maxDate : '+1y',
		minDate : 0
	});
}

function dateantes(){
	$('#fauto').datepicker({
		showOn: 'button',
		buttonImage: 'imagenes/bg-calendario.png',
		buttonImageOnly: true,
		buttonText: 'Select date',
		dateFormat: 'yy-mm-dd',
		maxDate : 0
	});
}

function ValidarCedula(){
		var numero = $('#rucCliente').val();
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
		alert('RUC Incorrecto');
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
		$('#ruc').val('');
		alert('RUC Incorrecto');
		return false;
		}
		/* El ruc de las empresas del sector publico terminan con 0001*/
		if ( numero.substr(9,4) != '0001' ){
		console.log('El ruc de la empresa del sector público debe terminar con 0001');
		$('#ruc').val('');
		alert('RUC Incorrecto');
		return false;
		}
		}
		else if(pri == true){
		if (digitoVerificador != d10){
		console.log('El ruc de la empresa del sector privado es incorrecto.');
		$('#ruc').val('');
		alert('RUC Incorrecto');
		return false;
		}
		if ( numero.substr(10,3) != '001' ){
		console.log('El ruc de la empresa del sector privado debe terminar con 001');
		$('#ruc').val('');
		alert('RUC Incorrecto');
		return false;
		}
		}

		else if(nat == true){
		if (digitoVerificador != d10){
		console.log('El número de cédula de la persona natural es incorrecto.');
		$('#ruc').val('');
		alert('RUC Incorrecto');
		return false;
		}
		if (numero.length >10 && numero.substr(10,3) != '001' ){
		console.log('El ruc de la persona natural debe terminar con 001');
		$('#ruc').val('');
		alert('RUC Incorrecto');
		return false;
		}
		}
		return true;
}

function calcularFecha(){
	var arr = '';
	var mes = $('#mes').val();
	var fecha1 = $('#fauto').val();;
	var res = fecha1.substring(4);
	var a = fecha1.substring(0,4);
	var a = parseInt(a) + parseInt(1);
	var salida = a+res;
	$('#fcadu').val(salida);
	$('#fcadu').focus();
}

function validarNumeros(e) {
	tecla = (document.all) ? e.keyCode : e.which; 
	if (tecla==8) return true;
	if (tecla==32) return false;
	patron =/\d/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function abrirAuto(id){
	$('#choose').fadeOut('slow');
	$('#cargar').delay(600).fadeIn('slow');
	$.post('spadmin/verautorizaciones.php',{
		id : id
	}).done(function(data){
		$('#loaddates').html('<div class="loading" style="text-align:center;"><img src="imagenes/loading.gif" width="70px"/></div>');
		$('#loaddates').fadeIn(600).html(data);
	});
	setTimeout("$('html, body').animate({scrollTop: '0px'});",600);
}

function volver(){
	window.location = '';
}

function crearauto(id){
	$('#choose').fadeOut('slow');
	$('#cargar').delay(600).fadeIn('slow');
	$.post('spadmin/datossocio.php',{
		id : id
	}).done(function(data){
		$('#loaddates').html('<div class="loading" style="text-align:center;"><img src="imagenes/loading.gif" width="70px"/></div>');
		$('#loaddates').fadeIn(600).html(data);
	});
	setTimeout("$('html, body').animate({scrollTop: '0px'});",600);
}

var count = 2;
function addfile(){
	var id = parseInt(count) - parseInt(1);
	var serie = $('#serie').val();
	var emision = $('#pEmision'+id).val();
	var tdoc = $('#tdocumento'+id).val();
	var seci = $('#secuInicial'+id).val();
	var secf = $('#secuFinal'+id).val();
	var contribuyente = $('#contribuyente').val();
	if((emision == '') || (tdoc == 0) || (seci == '') || (secf == '')){
		alert('Hay campos vacios');
	}else{
		if(contribuyente == 'Contribuyente RISE'){
			var documentos = '<p><select class="inputlogin tdocumento" onchange="cambiartdoc('+count+')" id="tdocumento'+count+'">\
			<option value="0">Seleccione...</option>\
			<option value="2">Boleto</option>\
			<option value="3">Nota de Cr&eacute;dito</option>\
			<option value="4">Nota de D&eacute;bito</option>\
			<option value="5">Nota de Venta</option>\
			<option value="6">Lquidaci&oacute;n de Compras</option>\
			<option value="7">Gu&iacute;a de Remisi&oacute;n</option>\
			<option value="9">Tiquete Tax&iacute;metros y M. Regitradoras</option>\
			<option value="10">L. Compra Bienes Muebles usados</option>\
			<option value="11">L. Compra Veh&iacute;culos usados</option>\
			<option value="12">Acta entrega/recepci&oacute;n Veh&iacute;culos usados</option>\
			</select></p>';
		}else{
			var documentos = '<p><select class="inputlogin tdocumento" onchange="cambiartdoc('+count+')" id="tdocumento'+count+'">\
			<option value="0">Seleccione...</option>\
			<option value="1">Factura</option>\
			<option value="2">Boleto</option>\
			<option value="3">Nota de Cr&eacute;dito</option>\
			<option value="4">Nota de D&eacute;bito</option>\
			<option value="5">Nota de Venta</option>\
			<option value="6">Lquidaci&oacute;n de Compras</option>\
			<option value="7">Gu&iacute;a de Remisi&oacute;n</option>\
			<option value="8">Comprobante de Retenci&oacute;n</option>\
			<option value="9">Tiquete Tax&iacute;metros y M. Regitradoras</option>\
			<option value="10">L. Compra Bienes Muebles usados</option>\
			<option value="11">L. Compra Veh&iacute;culos usados</option>\
			<option value="12">Acta entrega/recepci&oacute;n Veh&iacute;culos usados</option>\
			</select></p>';
		}
		// count = parseInt(count) + parseInt(1);
		$('.addfiles').append('<tr style="text-align:center;" class="numDocs" id="minusfile'+count+'">\
								<td style="border:1px solid #fff;">\
									'+serie+'&nbsp;&nbsp;-&nbsp;&nbsp;<input type="text" class="inputlogin pEmision comprobar" id="pEmision'+count+'" onkeypress="return validarNumeros(event)" maxlength="3"  size="3" onchange="comprobarEmision('+count+')" />\
								</td>\
								<td style="border:1px solid #fff; vertical-align:middle;">\
								'+documentos+'\
								<p><input type="text" class="inputlogin otrodoc" id="otrodoc'+count+'" onkeypress="return validarLetras(event)" style="display:none;" size="15" /></p>\
								</td>\
								<td style="border:1px solid #fff;">\
									<input type="text" class="inputlogin secuInicial" id="secuInicial'+count+'" size="8" maxlength="9" onkeypress="return validarNumeros(event)" onchange="comprobarInicial('+count+')" />\
								</td>\
								<td style="border:1px solid #fff;">\
									<input type="text" class="inputlogin secuFinal" id="secuFinal'+count+'"  onkeypress="return validarNumeros(event)" size="8" maxlength="9" onchange="comprobarFinal('+count+')" />\
								</td>\
								<td>\
									<img src="imagenes/minus.png" style="width:35px; cursor:pointer;" onclick="removefile('+count+')" />\
								</td>\
							</tr>');
		count++;
	}
}

function verificarclick(){
	if($('.pEmision').length){
		$('.pEmision').val('');
		$('.tdocumento').val(0);
		$('.secuInicial').val('');
		$('.secuFinal').val('');
		if($('.comprobar').length){
			alert('Vuelve a ingresar los documentos');
		}
	}
}

function nuevocodigo(valor){
	var codigook = $('#codigobd').val();
	$('.codigosval').each(function(){
		var codigosbd = $(this).find('.codigosbd').val();
		if(codigosbd == valor){
			alert('Imposible Modificar, ya hay un ESTABLECIMIENTO con este CODIGO');
			$('#serie').val(codigook);
			return false;
		}else{
			$('#nro').html(valor);
		}
	});
}

function cambiartdoc(count){
	var oksucursal = $('#identificadorSuc').val();
	if(oksucursal == '1s'){
		var imprimirok = $('#imrpresionpara2').val();
	}else if(oksucursal == ''){
		var imprimirok = $('#imrpresionpara').val();
	}
	var serie = $('#serie').val();
	if($('#nego').is(':checked')){ 
		var negociables = 'si';
	}else{
		var negociables = 'no';
	}
	var emision = $('#pEmision'+count).val();
	var docs = $('#tdocumento'+count).val();
	
	var limite = parseInt(count) - parseInt(1);
	if(count > 1){
		for(var k = 1; k <= limite; k++){
			var serietodo = $('#pEmision'+k).val();
			var doctodo = $('#tdocumento'+k).val();
			if((emision == serietodo) && (docs == 2) && ((doctodo == 1) || (doctodo == 2) || (doctodo == 3) || (doctodo == 4) || (doctodo == 5) || (doctodo == 6) || (doctodo == 7) || (doctodo == 8) || (doctodo == 9) || (doctodo == 10) || (doctodo == 11) || doctodo == 12)){
				$('#pEmision'+count).val('');
				$('#tdocumento'+count).val(0);
				alert('Ya existen Documentos con este punto de emision, utiliza otro para este Boletos');
				// alert(emision +'-'+ serietodo+'-docs'+docs+'-'+ doctodo);
				return false;
			}
		}
	
	
		// $('.numDocs').each(function(){
			// var serietodo = $(this).find('.pEmision').val();
			// var doctodo = $(this).find('.tdocumento').val();
			
		// });
	}
	
	if(docs == 1){
		var documento = 'Factura';
	}else if(docs == 2){
		var documento = 'Boleto';
	}else if(docs == 3){
		var documento = 'Nota de Credito';
	}else if(docs == 4){
		var documento = 'Nota de Debito';
	}else if(docs == 5){
		var documento = 'Nota de Venta';
	}else if(docs == 6){
		var documento = 'Liquidacion de Compras';
	}else if(docs == 7){
		var documento = 'Guia de Remision';
	}else if(docs == 8){
		var documento = 'Comprobante Retencion';
	}else if(docs == 9){
		var documento = 'Taximetros y Registradoras';
	}else if(docs == 10){
		var documento = 'LC Bienes Muebles usados';
	}else if(docs == 11){
		var documento = 'LC Vehiculos usados';
	}else if(docs == 12){
		var documento = 'Acta entrega/recepcion';
	}
	var idsoo = $('#idsoo').val();
	
	var countserie = emision.length;
	if(countserie == 1){
		emision = '00'+emision;
	}else{
		if(countserie == 2){
			emision = '0'+emision;
		}else{
			if(countserie == 1){
				emision = emision;
			}
		}
	}
	var serieemision = serie+'-'+emision;
	// alert(oksucursal+' -cambiosuc');
	// alert(imprimirok+' -printpara');
	// alert(serie+' -serie');
	// alert(negociables+ '-negociables');
	// alert(emision+ '-emision');
	// alert(docs+ ' -documento');
	// alert(idsoo+ ' -socio');
	// alert(serieemision+ ' -codigo');
	
	$('.databd').each(function(){
		var idsocio = $(this).find('.sociodb').val();
		var codigo = $(this).find('.codbd').val();
		var tipdoc = $(this).find('.docsdb').val();
		var negos = $(this).find('.docnegodb').val();
		var impreso = $(this).find('.printfordb').val();
		if((serieemision == codigo) && (docs == 1) && (tipdoc == 'Factura') && (negociables == 'si') && (negos == 'no') && (idsoo == idsocio) && (imprimirok == impreso)){
			$('#pEmision'+count).val('');
			$('#tdocumento'+count).val(0);
			alert('Ya existen Facturas Comerciales con este punto de emision, utiliza otro para este Documento');
			return false;
		}
		if((serieemision == codigo) && (docs == 1) && (tipdoc == 'Factura') && (negociables == 'no') && (negos == 'si') && (idsoo == idsocio) && (imprimirok == impreso)){
			$('#pEmision'+count).val('');
			$('#tdocumento'+count).val(0);
			alert('Ya existen Facturas Comerciales Negociables con este punto de emision, utiliza otro para este Documento');
			return false;
		}
		if((serieemision == codigo) && (docs == 2) && (negociables == 'si') && (negos == 'no') && (idsoo == idsocio) && (imprimirok == impreso)){
			$('#pEmision'+count).val('');
			$('#tdocumento'+count).val(0);
			alert('Ya existen Documentos con este punto de emision, utiliza otro para Boletos');
			return false;
		}
		if((serieemision == codigo) && (docs == 2) && (negociables == 'no') && (negos == 'si') && (idsoo == idsocio) && (imprimirok == impreso)){
			$('#pEmision'+count).val('');
			$('#tdocumento'+count).val(0);
			alert('Ya existen Documentos con este punto de emision, utiliza otro para Boletos');
			return false;
		}
		if((serieemision == codigo) && (docs == 2) && (negociables == 'si') && (negos == 'si') && (idsoo == idsocio) && (imprimirok == impreso)){
			$('#pEmision'+count).val('');
			$('#tdocumento'+count).val(0);
			alert('Ya existen Documentos con este punto de emision, utiliza otro para Boletos');
			return false;
		}
		if((serieemision == codigo) && (docs == 2) && (negociables == 'no') && (negos == 'no') && (idsoo == idsocio) && (imprimirok == impreso)){
			$('#pEmision'+count).val('');
			$('#tdocumento'+count).val(0);
			alert('Ya existen Documentos con este punto de emision, utiliza otro para Boletos');
			return false;
		}
		if((serieemision == codigo) && (tipdoc == 'Boleto') && ((docs == 1) || (docs == 2) || (docs == 3) || (docs == 4) || (docs == 5) || (docs == 6) || (docs == 7) || (docs == 8) || (docs == 9) || (docs == 10) || (docs == 11) || (docs == 12)) && (idsoo == idsocio) && (imprimirok == impreso)){
			$('#pEmision'+count).val('');
			$('#tdocumento'+count).val(0);
			alert('Ya existen Boletos con este punto de emision, utiliza otro para este Documento');
			return false;
		}
	});
	
	if(count > 1){
		var menosid = parseInt(count) - parseInt(1);
		for(var i = 1; i <= menosid; i++){
			var pEmision = $('#pEmision'+i).val();
			var tdocumento = $('#tdocumento'+i).val();
			
			if((emision == pEmision) && (tdocumento == 2) && ((docs == 1) || (docs == 2) || (docs == 3) || (docs == 4) || (docs == 5) || (docs == 6) || (docs == 7) || (docs == 8) || (docs == 9) || (docs == 10) || (docs == 11) || (docs == 12))){
				$('#pEmision'+count).val('');
				$('#tdocumento'+count).val(0);
				alert('Ya tienes Boletos con este punto de emision, utiliza otro para este Documento');
			}
		}
	}
}

function cancelarAuto(){
	window.location = '';
}

function validarAuto(){
	var numauto = $('#nroAuto').val().length;
	var num = $('#nroAuto').val();
	if(numauto < 10){
		alert('El Número de Autorización esta incompleto');
		$('#nroAuto').val('');
		$('#nroAuto').focus();
        return false;
	}
	var numresult = $('#numresult').val();
	for(var i = 1; i <= numresult; i++){
		var numok = $('#Nauto'+i).val();
		if(numok == num){
			alert('Número de Autorización repetida');
			$('#nroAuto').val('');
			$('#nroAuto').focus();
			return false;
		}
	}
	if(num == 0){
		alert('El Número de Autorización no puede ser cero');
		$('#nroAuto').val('');
		$('#nroAuto').focus();
        return false;
	}
}

function modificarCampos(id){
	if(id == 1){
		// alert('Estas aqui');
		$('#rucCliente').removeAttr('readonly');
		$('#rucCliente').removeClass('inputopcional');
		$('#rucCliente').addClass('inputlogin');
		$('#rucCliente').focus();
		$('#lapiz'+id).fadeOut('slow');
		$('#x'+id).delay(600).fadeIn('slow');
	}
	if(id == 2){
		// alert('ahora aca');
		$('#razonsocial').removeAttr('readonly');
		$('#razonsocial').removeClass('inputopcional');
		$('#razonsocial').addClass('inputlogin');
		$('#razonsocial').focus();
		$('#lapiz'+id).fadeOut('slow');
		$('#x'+id).delay(600).fadeIn('slow');
	}
	if(id == 3){
		$('#matriz').removeAttr('readonly');
		$('#matriz').removeClass('inputopcional');
		$('#matriz').addClass('inputlogin');
		$('#matriz').focus();
		$('#lapiz'+id).fadeOut('slow');
		$('#x'+id).delay(600).fadeIn('slow');
	}
	if(id == 4){
		$('#direstab').removeAttr('readonly');
		$('#direstab').removeClass('inputopcional');
		$('#direstab').addClass('inputlogin');
		$('#direstab').focus();
		$('#lapiz'+id).fadeOut('slow');
		$('#x'+id).delay(600).fadeIn('slow');
	}
	if(id == 5){
		// $('#contribuyente').removeAttr('readonly');
		// $('#contribuyente').removeClass('inputopcional');
		// $('#contribuyente').addClass('inputlogin');
		$('#contribuyente').fadeOut('slow');
		$('#lapiz'+id).fadeOut('slow');
		$('#newcontribuyente').delay(600).fadeIn('slow');
		$('#x'+id).delay(600).fadeIn('slow');
	}
	if(id == 6){
		var con1 = $('#contribuyente').val();
		var con2 = $('#cambioContribuyente').val();
		if((con1 == 'Contribuyente Especial') || (con2 == 3)){
			$('#nrocontribuyente').removeAttr('readonly');
			$('#nrocontribuyente').removeClass('inputopcional');
			$('#nrocontribuyente').addClass('inputlogin');
			$('#nrocontribuyente').focus();
			$('#lapiz'+id).fadeOut('slow');
			$('#x'+id).delay(600).fadeIn('slow');
		}else{
			alert('No puedes modificar este número, no es Contribuyente Especial')
		}
	}
	if(id == 7){
		$('#establecimiento').removeAttr('readonly');
		$('#establecimiento').removeClass('inputopcional');
		$('#establecimiento').addClass('inputlogin');
		$('#establecimiento').focus();
		$('#lapiz'+id).fadeOut('slow');
		$('#x'+id).delay(600).fadeIn('slow');
	}
	if(id == 8){
		$('#serie').removeAttr('readonly');
		$('#serie').removeClass('inputopcional');
		$('#serie').addClass('inputlogin');
		$('#serie').focus();
		$('#lapiz'+id).fadeOut('slow');
		$('#x'+id).delay(600).fadeIn('slow');
	}
	if(id == 9){
		$('#lapiz'+id).fadeOut('slow');
		$('#actividad').fadeOut('slow');
		$('#newActividad').delay(600).fadeIn('slow');
		$('#x'+id).delay(600).fadeIn('slow');
		$('.tipoRise').delay(600).fadeIn('slow');
	}
	if(id == 10){
		$('#lapiz'+id).fadeOut('slow');
		$('#categoria').fadeOut('slow');
		$('#newCategoria').delay(600).fadeIn('slow');
		$('#x'+id).delay(600).fadeIn('slow');
		$('.tipoRise').delay(600).fadeIn('slow');
	}
}

function validarDato(valor){
	valor = valor.toLowerCase();
	var ruc = $('#rucbd').val();
	var comercial = $('#razonsocialbd').val();
	$('.datosbd').each(function(){
		var rucbd = $(this).find('td .ruc').val();
		rucbd = rucbd.toLowerCase();
		var comercialbd = $(this).find('td .comercial').val();
		comercialbd = comercialbd.toLowerCase();
		
		if(rucbd == valor){
			alert('Imposible modificar, Ya existe un RUC similar');
			$('#rucCliente').val(ruc);
			return false;
		}
		if(comercialbd == valor){
			alert('Imposible modificar, Ya existe un NOMBRE COMERCIAL similar');
			$('#razonsocial').val(comercial);
			return false;
		}
	});
}

function cancelMod(id){
	if(id == 1){
		// alert('Estas aqui');
		$('#rucCliente').attr('readonly','readonly');
		$('#rucCliente').removeClass('inputlogin');
		$('#rucCliente').addClass('inputopcional');
		$('#x'+id).fadeOut('slow');
		$('#lapiz'+id).delay(600).fadeIn('slow');
		var rucbd = $('#rucbd').val();
		$('#rucCliente').val(rucbd);
	}
	if(id == 2){
		// alert('Estas aqui');
		$('#razonsocial').attr('readonly','readonly');
		$('#razonsocial').removeClass('inputlogin');
		$('#razonsocial').addClass('inputopcional');
		$('#x'+id).fadeOut('slow');
		$('#lapiz'+id).delay(600).fadeIn('slow');
		var razonsocialbd = $('#razonsocialbd').val();
		$('#razonsocial').val(razonsocialbd);
	}
	if(id == 3){
		// alert('Estas aqui');
		$('#matriz').attr('readonly','readonly');
		$('#matriz').removeClass('inputlogin');
		$('#matriz').addClass('inputopcional');
		$('#x'+id).fadeOut('slow');
		$('#lapiz'+id).delay(600).fadeIn('slow');
		var matrizbd = $('#matrizbd').val();
		$('#matriz').val(matrizbd);
	}
	if(id == 4){
		// alert('Estas aqui');
		$('#direstab').attr('readonly','readonly');
		$('#direstab').removeClass('inputlogin');
		$('#direstab').addClass('inputopcional');
		$('#x'+id).fadeOut('slow');
		$('#lapiz'+id).delay(600).fadeIn('slow');
		var direstabbd = $('#direstabbd').val();
		$('#direstab').val(direstabbd);
	}
	if(id == 5){
		// alert('Estas aqui');
		// $('#contribuyente').attr('readonly','readonly');
		// $('#contribuyente').removeClass('inputlogin');
		var select = $('#cambioContribuyente').val();
		var conbd = $('#contribuyente').val();
		if(select == 4){
			$('#actividadEconomica').val(0);
			$('#cat').val(0);
			$('.otherActividad').fadeOut('slow');
			$('.otherCategoria').fadeOut('slow');
		}
		$('#newcontribuyente').fadeOut('slow');
		$('#x'+id).fadeOut('slow');
		$('#cambioContribuyente').val(0);
		$('#lapiz'+id).delay(600).fadeIn('slow');
		$('#contribuyente').delay(600).fadeIn('slow');
	}
	if(id == 6){
		// alert('Estas aqui');
		$('#nrocontribuyente').attr('readonly','readonly');
		$('#nrocontribuyente').removeClass('inputlogin');
		$('#nrocontribuyente').addClass('inputopcional');
		$('#x'+id).fadeOut('slow');
		$('#lapiz'+id).delay(600).fadeIn('slow');
	}
	if(id == 7){
		// alert('Estas aqui');
		$('#establecimiento').attr('readonly','readonly');
		$('#establecimiento').removeClass('inputlogin');
		$('#establecimiento').addClass('inputopcional');
		$('#x'+id).fadeOut('slow');
		$('#lapiz'+id).delay(600).fadeIn('slow');
	}
	if(id == 8){
		// alert('Estas aqui');
		$('#serie').attr('readonly','readonly');
		$('#serie').removeClass('inputlogin');
		$('#serie').addClass('inputopcional');
		$('#x'+id).fadeOut('slow');
		$('#lapiz'+id).delay(600).fadeIn('slow');
		var codigobd = $('#codigobd').val();
		$('#nro').html(codigobd);
	}
	if(id == 9){
		$('#newActividad').fadeOut('slow');
		$('#x'+id).fadeOut('slow');
		$('.tipoRise').fadeOut('slow');
		$('#lapiz'+id).delay(600).fadeIn('slow');
		$('#actividad').delay(600).fadeIn('slow');
		$('#actividadEconomica').val(0);
	}
	if(id == 10){
		$('#newCategoria').fadeOut('slow');
		$('#x'+id).fadeOut('slow');
		$('.tipoRise').fadeOut('slow');
		$('#lapiz'+id).delay(600).fadeIn('slow');
		$('#categoria').delay(600).fadeIn('slow');
		$('#cat').val(0);
	}
}

function valoresActividad(){
	var actividad = $('#actividadEconomica').val();
	var categoria1 = $('#cat').val();
	if(categoria1 == 0){
		var cat = $('#categoria').val();
	}else{
		var cat = $('#cat').val();
	}
	if(actividad == 1){
		if(cat == 1){
			$('#inferior1').val(0);
			$('#superior1').val(5000);
			$('#inferior2').val(0);
			$('#superior2').val(417);
		}
		if(cat == 2){
			$('#inferior1').val(5001);
			$('#superior1').val(10000);
			$('#inferior2').val(418);
			$('#superior2').val(833);
		}
		if(cat == 3){
			$('#inferior1').val(10001);
			$('#superior1').val(20000);
			$('#inferior2').val(834);
			$('#superior2').val(1667);
		}
		if(cat == 4){
			$('#inferior1').val(20001);
			$('#superior1').val(30000);
			$('#inferior2').val(1668);
			$('#superior2').val(2500);
		}
		if(cat == 5){
			$('#inferior1').val(30001);
			$('#superior1').val(40000);
			$('#inferior2').val(2501);
			$('#superior2').val(3333);
		}
		if(cat == 6){
			$('#inferior1').val(40001);
			$('#superior1').val(50000);
			$('#inferior2').val(3334);
			$('#superior2').val(4167);
		}
		if(cat == 7){
			$('#inferior1').val(50001);
			$('#superior1').val(60000);
			$('#inferior2').val(4168);
			$('#superior2').val(5000);
		}
		$('#monto').val(150);
	}else if(actividad == 2){
		if(cat == 1){
			$('#inferior1').val(0);
			$('#superior1').val(5000);
			$('#inferior2').val(0);
			$('#superior2').val(417);
		}
		if(cat == 2){
			$('#inferior1').val(5001);
			$('#superior1').val(10000);
			$('#inferior2').val(418);
			$('#superior2').val(833);
		}
		if(cat == 3){
			$('#inferior1').val(10001);
			$('#superior1').val(20000);
			$('#inferior2').val(834);
			$('#superior2').val(1667);
		}
		if(cat == 4){
			$('#inferior1').val(20001);
			$('#superior1').val(30000);
			$('#inferior2').val(1668);
			$('#superior2').val(2500);
		}
		if(cat == 5){
			$('#inferior1').val(30001);
			$('#superior1').val(40000);
			$('#inferior2').val(2501);
			$('#superior2').val(3333);
		}
		if(cat == 6){
			$('#inferior1').val(40001);
			$('#superior1').val(50000);
			$('#inferior2').val(3334);
			$('#superior2').val(4167);
		}
		if(cat == 7){
			$('#inferior1').val(50001);
			$('#superior1').val(60000);
			$('#inferior2').val(4168);
			$('#superior2').val(5000);
		}
		$('#monto').val(250);
	}else if(actividad == 3){
		if(cat == 1){
			$('#inferior1').val(0);
			$('#superior1').val(5000);
			$('#inferior2').val(0);
			$('#superior2').val(417);
		}
		if(cat == 2){
			$('#inferior1').val(5001);
			$('#superior1').val(10000);
			$('#inferior2').val(418);
			$('#superior2').val(833);
		}
		if(cat == 3){
			$('#inferior1').val(10001);
			$('#superior1').val(20000);
			$('#inferior2').val(834);
			$('#superior2').val(1667);
		}
		if(cat == 4){
			$('#inferior1').val(20001);
			$('#superior1').val(30000);
			$('#inferior2').val(1668);
			$('#superior2').val(2500);
		}
		if(cat == 5){
			$('#inferior1').val(30001);
			$('#superior1').val(40000);
			$('#inferior2').val(2501);
			$('#superior2').val(3333);
		}
		if(cat == 6){
			$('#inferior1').val(40001);
			$('#superior1').val(50000);
			$('#inferior2').val(3334);
			$('#superior2').val(4167);
		}
		if(cat == 7){
			$('#inferior1').val(50001);
			$('#superior1').val(60000);
			$('#inferior2').val(4168);
			$('#superior2').val(5000);
		}
		$('#monto').val(250);
	}else if(actividad == 4){
		if(cat == 1){
			$('#inferior1').val(0);
			$('#superior1').val(5000);
			$('#inferior2').val(0);
			$('#superior2').val(417);
		}
		if(cat == 2){
			$('#inferior1').val(5001);
			$('#superior1').val(10000);
			$('#inferior2').val(418);
			$('#superior2').val(833);
		}
		if(cat == 3){
			$('#inferior1').val(10001);
			$('#superior1').val(20000);
			$('#inferior2').val(834);
			$('#superior2').val(1667);
		}
		if(cat == 4){
			$('#inferior1').val(20001);
			$('#superior1').val(30000);
			$('#inferior2').val(1668);
			$('#superior2').val(2500);
		}
		if(cat == 5){
			$('#inferior1').val(30001);
			$('#superior1').val(40000);
			$('#inferior2').val(2501);
			$('#superior2').val(3333);
		}
		if(cat == 6){
			$('#inferior1').val(40001);
			$('#superior1').val(50000);
			$('#inferior2').val(3334);
			$('#superior2').val(4167);
		}
		if(cat == 7){
			$('#inferior1').val(50001);
			$('#superior1').val(60000);
			$('#inferior2').val(4168);
			$('#superior2').val(5000);
		}
		$('#monto').val(400);
	}else if(actividad == 5){
		if(cat == 1){
			$('#inferior1').val(0);
			$('#superior1').val(5000);
			$('#inferior2').val(0);
			$('#superior2').val(417);
		}
		if(cat == 2){
			$('#inferior1').val(5001);
			$('#superior1').val(10000);
			$('#inferior2').val(418);
			$('#superior2').val(833);
		}
		if(cat == 3){
			$('#inferior1').val(10001);
			$('#superior1').val(20000);
			$('#inferior2').val(834);
			$('#superior2').val(1667);
		}
		if(cat == 4){
			$('#inferior1').val(20001);
			$('#superior1').val(30000);
			$('#inferior2').val(1668);
			$('#superior2').val(2500);
		}
		if(cat == 5){
			$('#inferior1').val(30001);
			$('#superior1').val(40000);
			$('#inferior2').val(2501);
			$('#superior2').val(3333);
		}
		if(cat == 6){
			$('#inferior1').val(40001);
			$('#superior1').val(50000);
			$('#inferior2').val(3334);
			$('#superior2').val(4167);
		}
		if(cat == 7){
			$('#inferior1').val(50001);
			$('#superior1').val(60000);
			$('#inferior2').val(4168);
			$('#superior2').val(5000);
		}
		$('#monto').val(150);
	}else if(actividad == 6){
		if(cat == 1){
			$('#inferior1').val(0);
			$('#superior1').val(5000);
			$('#inferior2').val(0);
			$('#superior2').val(417);
		}
		if(cat == 2){
			$('#inferior1').val(5001);
			$('#superior1').val(10000);
			$('#inferior2').val(418);
			$('#superior2').val(833);
		}
		if(cat == 3){
			$('#inferior1').val(10001);
			$('#superior1').val(20000);
			$('#inferior2').val(834);
			$('#superior2').val(1667);
		}
		if(cat == 4){
			$('#inferior1').val(20001);
			$('#superior1').val(30000);
			$('#inferior2').val(1668);
			$('#superior2').val(2500);
		}
		if(cat == 5){
			$('#inferior1').val(30001);
			$('#superior1').val(40000);
			$('#inferior2').val(2501);
			$('#superior2').val(3333);
		}
		if(cat == 6){
			$('#inferior1').val(40001);
			$('#superior1').val(50000);
			$('#inferior2').val(3334);
			$('#superior2').val(4167);
		}
		if(cat == 7){
			$('#inferior1').val(50001);
			$('#superior1').val(60000);
			$('#inferior2').val(4168);
			$('#superior2').val(5000);
		}
		$('#monto').val(250);
	}else if(actividad == 7){
		if(cat == 1){
			$('#inferior1').val(0);
			$('#superior1').val(5000);
			$('#inferior2').val(0);
			$('#superior2').val(417);
		}
		if(cat == 2){
			$('#inferior1').val(5001);
			$('#superior1').val(10000);
			$('#inferior2').val(418);
			$('#superior2').val(833);
		}
		if(cat == 3){
			$('#inferior1').val(10001);
			$('#superior1').val(20000);
			$('#inferior2').val(834);
			$('#superior2').val(1667);
		}
		if(cat == 4){
			$('#inferior1').val(20001);
			$('#superior1').val(30000);
			$('#inferior2').val(1668);
			$('#superior2').val(2500);
		}
		if(cat == 5){
			$('#inferior1').val(30001);
			$('#superior1').val(40000);
			$('#inferior2').val(2501);
			$('#superior2').val(3333);
		}
		if(cat == 6){
			$('#inferior1').val(40001);
			$('#superior1').val(50000);
			$('#inferior2').val(3334);
			$('#superior2').val(4167);
		}
		if(cat == 7){
			$('#inferior1').val(50001);
			$('#superior1').val(60000);
			$('#inferior2').val(4168);
			$('#superior2').val(5000);
		}
		$('#monto').val(400);
	}else if(actividad == 8){
		if(cat == 1){
			$('#inferior1').val(0);
			$('#superior1').val(5000);
			$('#inferior2').val(0);
			$('#superior2').val(417);
		}
		if(cat == 2){
			$('#inferior1').val(5001);
			$('#superior1').val(10000);
			$('#inferior2').val(418);
			$('#superior2').val(833);
		}
		if(cat == 3){
			$('#inferior1').val(10001);
			$('#superior1').val(20000);
			$('#inferior2').val(834);
			$('#superior2').val(1667);
		}
		if(cat == 4){
			$('#inferior1').val(20001);
			$('#superior1').val(30000);
			$('#inferior2').val(1668);
			$('#superior2').val(2500);
		}
		if(cat == 5){
			$('#inferior1').val(30001);
			$('#superior1').val(40000);
			$('#inferior2').val(2501);
			$('#superior2').val(3333);
		}
		if(cat == 6){
			$('#inferior1').val(40001);
			$('#superior1').val(50000);
			$('#inferior2').val(3334);
			$('#superior2').val(4167);
		}
		if(cat == 7){
			$('#inferior1').val(50001);
			$('#superior1').val(60000);
			$('#inferior2').val(4168);
			$('#superior2').val(5000);
		}
		$('#monto').val(400);
	}else if(actividad == 0){
		$('#inferior1').val('');
		$('#superior1').val('');
		$('#inferior2').val('');
		$('#superior2').val('');
		$('#monto').val('');
		alert('Selecciona una Actividad');
	}
}

function valoresCategoria(){
	var cat = $('#cat').val();
	var actividad1 = $('#actividadEconomica').val();
	if(actividad1 == 0){
		var actividad = $('#actividad').val();
		if(actividad == 'Actividades de Comercio'){
			actividad = 1;
		}else if(actividad == 'Actividades de Servicio'){
			actividad = 2;
		}else if(actividad == 'Actividades de Manufactura'){
			actividad = 3;
		}else if(actividad == 'Actividades de Construccion'){
			actividad = 4;
		}else if(actividad == 'Hoteles y Restaurantes'){
			actividad = 5;
		}else if(actividad == 'Actividades de Trasnporte'){
			actividad = 6;
		}else if(actividad == 'Actividades Agrícolas'){
			actividad = 7;
		}else if(actividad == 'Actividades de Minas y Canteras'){
			actividad = 8;
		}
	}else{
		var actividad = $('#actividadEconomica').val();
	}
	if(cat == 1){
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
	if(cat == 2){
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
	if(cat == 3){
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
	if(cat == 4){
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
	if(cat == 5){
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
	if(cat == 6){
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
	if(cat == 7){
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
	if(cat == 0){
		$('#inferior1').val('');
		$('#superior1').val('');
		$('#inferior2').val('');
		$('#superior2').val('');
		$('#monto').val('');
		alert('Selecciona una categoría');
	}
}

function cambioContribuyente(){
	var id = 6;
	var selectClass = $('#cambioContribuyente').val();
	var contribuyenteBD = $('#contribuyente').val();
	if((selectClass != 4) && (contribuyenteBD == 'Contribuyente RISE')){
		$('.outActividad').fadeOut('slow');
		$('.outCategoria').fadeOut('slow');
		$('#actividad').fadeOut('slow');
		$('#categoria').fadeOut('slow');
		$('.ocultarClase').fadeOut('slow');
		$('.cambioClase').delay(600).fadeIn('slow');
		// $('.otherActividad').delay(600).fadeIn('slow');
		// $('.otherCategoria').delay(600).fadeIn('slow');
	}else if((selectClass == 4) && (contribuyenteBD != 'Contribuyente RISE')){
		$('.cambioClase').fadeOut('slow');
		$('.otherActividad').delay(600).fadeIn('slow');
		$('.otherCategoria').delay(600).fadeIn('slow');
		$('.ocultarClase').delay(600).fadeIn('slow');
	}else if((selectClass == 4) && (contribuyenteBD == 'Contribuyente RISE')){
		$('.outActividad').fadeIn('slow');
		$('.outCategoria').fadeIn('slow');
		$('#actividad').fadeIn('slow');
		$('#categoria').fadeIn('slow');
		$('.cambioClase').fadeOut('slow');
		$('.ocultarClase').delay(600).fadeIn('slow');
	}else if((selectClass != 4) && (contribuyenteBD != 'Contribuyente RISE')){
		$('.otherActividad').fadeOut('slow');
		$('.otherCategoria').fadeOut('slow');
		$('.ocultarClase').fadeOut('slow');
		$('.cambioClase').delay(600).fadeIn('slow');
	}
	
	if(selectClass == 3){
		$('#nrocontribuyente').removeAttr('readonly');
		$('#nrocontribuyente').removeClass('inputopcional');
		$('#nrocontribuyente').addClass('inputlogin');
		$('#nrocontribuyente').focus();
		$('#lapiz'+id).fadeOut('slow');
		$('#x'+id).delay(600).fadeIn('slow');
	}else if(selectClass != 3){
		$('#nrocontribuyente').attr('readonly','readonly');
		$('#nrocontribuyente').removeClass('inputlogin');
		$('#nrocontribuyente').addClass('inputopcional');
		$('#x'+id).fadeOut('slow');
		$('#lapiz'+id).delay(600).fadeIn('slow');
	}
}

function comprobarEmision(id){
	var pemision = $('#pEmision'+id).val();
	if(pemision == 0){
		$('#pEmision'+id).val('');
		alert('El punto de emisión no puede ser cero');
		$('#pEmision'+id).focus();
		return false;
	}
}

function comprobarInicial(id){
	var serie = $('#serie').val();
	var emision = $('#pEmision'+id).val();
	var serieemision = serie+'-'+emision;
	var secIni = $('#secuInicial'+id).val();
	var oksucursal = $('#identificadorSuc').val();
	if(oksucursal == '1s'){
		var imprimirok = $('#imrpresionpara2').val();
	}else if(oksucursal == ''){
		var imprimirok = $('#imrpresionpara').val();
	}
	if(secIni == 0){
		$('#secuInicial'+id).val('');
		$('#secuInicial'+id).focus();
		alert('El secuencial Inicial no puede ser cero');
		return false;
	}
	var tdoc = $('#tdocumento'+id).val();
	if(tdoc == 1){
		var documento = 'Factura';
	}else if(tdoc == 2){
		var documento = 'Boleto';
	}else if(tdoc == 3){
		var documento = 'Nota de Credito';
	}else if(tdoc == 4){
		var documento = 'Nota de Debito';
	}else if(tdoc == 5){
		var documento = 'Nota de Venta';
	}else if(tdoc == 6){
		var documento = 'Liquidacion de Compras';
	}else if(tdoc == 7){
		var documento = 'Guia de Remision';
	}else if(tdoc == 8){
		var documento = 'Comprobante Retencion';
	}else if(tdoc == 9){
		var documento = 'Taximetros y Registradoras';
	}else if(tdoc == 10){
		var documento = 'LC Bienes Muebles usados';
	}else if(tdoc == 11){
		var documento = 'LC Vehiculos usados';
	}else if(tdoc == 12){
		var documento = 'Acta entrega/recepcion';
	}
	
	var idsoo = $('#idsoo').val();
	if($('#nego').is(':checked')){ 
		var negociables = 'si';
	}else{
		var negociables = 'no';
	}
	
	$('.databd').each(function(){
		var idsocio = $(this).find('.sociodb').val();
		var codigo = $(this).find('.codbd').val();
		var tipdoc = $(this).find('.docsdb').val();
		var negos = $(this).find('.docnegodb').val();
		var inicial = $(this).find('.inicialdb').val();
		var sfinal = $(this).find('.finaldb').val();
		var impreso = $(this).find('.printfordb').val();
		var recomed = parseInt(sfinal) + parseInt(1);
		
		if((serieemision == codigo) && (documento == tipdoc) && (negociables == negos) && (secIni <= sfinal) && (idsoo == idsocio) && (imprimirok == impreso)){
			$('#secuInicial'+id).val('');
			$('#secuInicial'+id).focus();
			alert('El valor ingresado es menor o igual al final anterior, secuencial Final anterior: '+sfinal+' se recomienda: '+recomed);
			return false;
		}
	});
	
	if(id > 1){
		var menosid = parseInt(id) - parseInt(1);
		for(var i = 1; i <= menosid; i++){
			var pEmision = $('#pEmision'+i).val();
			var tdocumento = $('#tdocumento'+i).val();
			var secuInicial = $('#secuInicial'+i).val();
			
			if((emision == pEmision) && (tdocumento == tdoc) && (secIni <= secuInicial)){
				$('#secuInicial'+id).val('');
				alert('El secuencial incial es menor o igual al de un documento ya ingresado');
			}
		}
	}
}

function comprobarFinal(id){
	var serie = $('#serie').val();
	var emision = $('#pEmision'+id).val();
	var serieemision = serie+'-'+emision;
	var secFin = $('#secuFinal'+id).val();
	var secIni = $('#secuInicial'+id).val();
	var imprimirok = $('#imrpresionpara').val();
	if(secFin == 0){
		$('#secuFinal'+id).val('');
		$('#secuFinal'+id).focus();
		alert('El secuencial Final no puede ser cero');
		return false;
	}
	if(secFin < secIni){
		$('#secuFinal'+id).val('');
		$('#secuFinal'+id).focus();
		alert('El secuencial Final no puede ser menor que el Inicial');
		return false;
	}
	var tdoc = $('#tdocumento'+id).val();
	if(tdoc == 1){
		var documento = 'Factura';
	}else if(tdoc == 2){
		var documento = 'Boleto';
	}else if(tdoc == 3){
		var documento = 'Nota de Credito';
	}else if(tdoc == 4){
		var documento = 'Nota de Debito';
	}else if(tdoc == 5){
		var documento = 'Nota de Venta';
	}else if(tdoc == 6){
		var documento = 'Liquidacion de Compras';
	}else if(tdoc == 7){
		var documento = 'Guia de Remision';
	}else if(tdoc == 8){
		var documento = 'Comprobante Retencion';
	}else if(tdoc == 9){
		var documento = 'Taximetros y Registradoras';
	}else if(tdoc == 10){
		var documento = 'LC Bienes Muebles usados';
	}else if(tdoc == 11){
		var documento = 'LC Vehiculos usados';
	}else if(tdoc == 12){
		var documento = 'Acta entrega/recepcion';
	}
	
	var idsoo = $('#idsoo').val();
	if($('#nego').is(':checked')){ 
		var negociables = 'si';
	}else{
		var negociables = 'no';
	}
	
	if(id > 1){
		var menosid = parseInt(id) - parseInt(1);
		for(var i = 1; i <= menosid; i++){
			var pEmision = $('#pEmision'+i).val();
			var tdocumento = $('#tdocumento'+i).val();
			var secuFinal = $('#secuFinal'+i).val();
			
			if((emision == pEmision) && (tdocumento == tdoc) && (secFin <= secuFinal)){
				$('#secuFinal'+id).val('');
				alert('El secuencial final es menor o igual al de un documento ya ingresado');
			}
		}
		
		var inicial = $('#secuInicial'+id).val();
		var finall = $('#secuFinal'+id).val();
		if(finall < inicial){
			$('#secuFinal'+id).val('');
			$('#secuFinal'+id).focus();
			alert('El secuencial Final no puede ser menor que el Inicial');
		}
	}
}

function removefile(conteo){
	$('#minusfile'+conteo).remove();
	//count = 2;
}

function addSucursal(){
	$('#btnAddsucursal').fadeOut('slow');
	$('.newSucursal').delay(600).fadeIn('slow');
	$('#identificadorSuc').val('1s');
}

function cancelSuc(){
	$('.newSucursal').fadeOut('slow');
	$('#btnAddsucursal').delay(600).fadeIn('slow');
	$('#identificadorSuc').val('');
}

function saveAuto(id){
	var rucCliente = $('#rucCliente').val();
	var razonSocial = $('#razonsocial').val();
	var dirMatriz = $('#matriz').val();
	var contribuyente = $('#contribuyente').val();
	var cambioContribuyente = $('#cambioContribuyente').val();
	var nrocontribuyente = $('#nrocontribuyente').val();
	var desEstablecimiento = $('#establecimiento').val();
	var codEstablecimiento = $('#serie').val();
	
	var oksucursal = $('#identificadorSuc').val();
	if(oksucursal == '1s'){
		var imrpresionpara = $('#imrpresionpara2').val();
		var dirEstablecimiento = $('#sucursal').val();
	}else if(oksucursal == ''){
		var imrpresionpara = $('#imrpresionpara').val();
		var dirEstablecimiento = $('#direstab').val();
	}
	
	var actividad = $('#actividadEconomica').val();
	var act = 'no';
	if(actividad == 0){
		act = $('#actividad').val();
	}else if(actividad != 0){
		act = $('#actividadEconomica').val();
	}
	var categoria = $('#cat').val();
	var cat = 'no';
	if(categoria == 0){
		cat = $('#categoria').val();
	}else if(categoria != 0){
		cat = $('#cat').val();
	}
	var fechaAutorizacion = $('#fauto').val();
	var fechaCaducidad = $('#fcadu').val();
	var numAutorizacion = $('#nroAuto').val();
	var emitidoEn = $('#sucTicket').val();
	if($('#nego').is(':checked')){ 
		var negociables = 'si';
	}else{
		var negociables = 'no';
	}
	var observacion = $('#observacion').val();
	var valores = '';
	
	$('.numDocs').each(function(){
		var puntoEmision = $(this).find('td .pEmision').val();
		var tipoDoc = $(this).find('td .tdocumento').val();
		var secuencialInicial = $(this).find('td .secuInicial').val();
		var secuencialFinal = $(this).find('td .secuFinal').val();
		
		valores += puntoEmision +'|'+ tipoDoc +'|'+ secuencialInicial +'|'+ secuencialFinal +'|'+'@';
	});
	var valores_format = valores.substring(0,valores.length -1);
	
	if((rucCliente == '') || (razonSocial == '') || (dirMatriz == '') || (dirEstablecimiento == '') || (contribuyente == '') || (nrocontribuyente == '') || (fechaAutorizacion == '') || (fechaCaducidad == '') || (numAutorizacion == '') || (emitidoEn == 0) || (observacion == '') || (imrpresionpara == 0)){
		alert('Llena todos los Campos');
	}else{
		var contador = parseInt(count) - parseInt(1);
		for(var j = 1; j <= contador; j++){
			$('#minusfile'+j).each(function(){
				var puntoEmision = $(this).find('td #pEmision'+j).val();
				var tipoDoc = $(this).find('td #tdocumento'+j).val();
				var secuencialInicial = $(this).find('td #secuInicial'+j).val();
				var secuencialFinal = $(this).find('td #secuFinal'+j).val();
				if((puntoEmision == '') || (tipoDoc == 0) || (secuencialInicial == '') || (secuencialFinal == '')){
					$('#vacios').val('si');
				}else{
					$('#vacios').val('no');
				}
			});
		}
		var vacios = $('#vacios').val();
		if(vacios == 'si'){
			alert('Llene todos los Campos');
		}else{
			$.post('spadmin/guardarautorizacion.php',{
				rucCliente : rucCliente, razonSocial : razonSocial, dirMatriz : dirMatriz, desEstablecimiento : desEstablecimiento, codEstablecimiento : codEstablecimiento,
				dirEstablecimiento : dirEstablecimiento, contribuyente : contribuyente, nrocontribuyente : nrocontribuyente, fechaAutorizacion : fechaAutorizacion,
				fechaCaducidad : fechaCaducidad, numAutorizacion : numAutorizacion, emitidoEn : emitidoEn, negociables : negociables, observacion : observacion, valores : valores_format, id : id, act : act, cat : cat, cambioContribuyente : cambioContribuyente, imrpresionpara : imrpresionpara, oksucursal : oksucursal
			}).done(function(data){
				alert('Se guardo con Exito!');
				window.location.href = '';
			});
		}
	}
}
</script>