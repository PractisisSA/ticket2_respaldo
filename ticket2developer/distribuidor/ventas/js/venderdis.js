var evento = $('#idConcierto').val();
$( document ).ready(function(){
	if(!document.getElementById('codigo')){
		$('#alerta1').fadeIn();
		$('#aviso').modal('show');
	}
	
	// updateReloj();
});


		   
		   

$(document).keyup(function(e){
	if(e.which == 13){
		ValidarDocumento();
	}
});

// function justInt(e,value){
	// if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46 || e.keyCode == 80 || e.keyCode == 112)){
		// return;
	// }
	// else{
		// e.preventDefault();
	// }
// }

function ValidarDocumento(){
	var valor = $('#buscarcliente').val();
	if(valor[0] == 'p'||valor[0] == 'P'){
		pasaporte();
	}else{
		ValidarCedula();
	}
}

function pasaporte(){
	var valor = $('#buscarcliente').val();
	if(valor.length<3||valor.length>13){
		console.log('Pasaporte incorrecto');
		$('#buscarcliente').val('');
		$('#alerta2').fadeIn();
		$('#aviso').modal('show');
		return false;
	}else{
		if(valor[0]=='p'||valor[0]=='P'){
			buscarCliente();
		}else{
			console.log('Pasaporte incorrecto');
			$('#buscarcliente').val('');
			$('#alerta2').fadeIn();
			$('#aviso').modal('show');
			return false;
		}
	}
}

function ValidarCedula(){
	var numero = $('#buscarcliente').val();
	if(numero == '9999999999'){
		buscarCliente();
	}else{
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
			$('#buscarcliente').val('');
			$('#alerta2').fadeIn();
			$('#aviso').modal('show');
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
		}else if(d3 == 6){
			/* Solo para sociedades publicas (modulo 11) */
			/* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
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
		}else if(d3 == 9) {
			/* Solo para entidades privadas (modulo 11) */
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
				$('#buscarcliente').val('');
				$('#alerta2').fadeIn();
				$('#aviso').modal('show');
				return false;
			}
			/* El ruc de las empresas del sector publico terminan con 0001*/
			if ( numero.substr(9,4) != '0001' ){
				console.log('El ruc de la empresa del sector público debe terminar con 0001');
				$('#buscarcliente').val('');
				$('#alerta2').fadeIn();
				$('#aviso').modal('show');
				return false;
			}
		}else if(pri == true){
			if (digitoVerificador != d10){
				console.log('El ruc de la empresa del sector privado es incorrecto.');
				$('#buscarcliente').val('');
				$('#alerta2').fadeIn();
				$('#aviso').modal('show');
				return false;
			}
			if ( numero.substr(10,3) != '001' ){
				console.log('El ruc de la empresa del sector privado debe terminar con 001');
				$('#buscarcliente').val('');
				$('#alerta2').fadeIn();
				$('#aviso').modal('show');
				return false;
			}
		}else if(nat == true){
			if (digitoVerificador != d10){
				console.log('El número de cédula de la persona natural es incorrecto.');
				$('#buscarcliente').val('');
				$('#alerta2').fadeIn();
				$('#aviso').modal('show');
				return false;
			}
			if (numero.length >10 && numero.substr(10,3) != '001' ){
				console.log('El ruc de la persona natural debe terminar con 001');
				$('#buscarcliente').val('');
				$('#alerta2').fadeIn();
				$('#aviso').modal('show');
				return false;
			}
		}else{
			buscarCliente();
		}

	}
}

function buscarCliente(){
	var valor = $('#buscarcliente').val();
	$('#buscar').fadeOut('slow');
	$('#wait').delay(600).fadeIn('slow');
	var num_personas = $('#num_personas').val();
	if(valor != ''){
		$.post('distribuidor/ventas/ajax/ajaxCargarCliente.php',{
			valor : valor
		}).done(function(response){
			if(($.trim(response) == 'noexiste') || ($.trim(response) == 'nodata')){
				$('#clienteok').val('no');
				var newcedula = $('#buscarcliente').val();
				$('#searchCliente').fadeOut();
				$('#newCliente').delay(600).fadeIn();
				$('#smstitulo').html('No existe ningún cliente con este # de Documento, ingreselo como: <strong>Nuevo Cliente</strong>');
				$('#personas_boletos').append('<div class="row" style="color:#fff;">\
						<div class="col-lg-5">\
							<h4>Nombre y Apellido (Titular Cuenta):</h4>\
							<input type="text" class="inputlogin form-control" id="nombres" name="nombres" placeholder="Nombre del Cliente" onchange="llenarnombres()" />\
						</div>\
						<div class="col-lg-5">\
							<h4>C.I./R.U.C/Pasaporte (Titular Cuenta):</h4>\
							<input type="text" class="inputlogin form-control" id="documento" name="documento" placeholder="Cédula" value="'+newcedula+'" />\
						</div>\
					</div>');
				for(var j = 1; j < num_personas; j++){
					var asiento = $('#chair'+j).val();
					var des = $('#des'+j).val();
					$('#personas_boletos').append('<div class="row datos_cliente_boleto" style="color:#fff;">\
						<div class="col-lg-5">\
							<h4 style="color:#fff;"><strong>TICKET: '+asiento+' ('+des+')</strong></h4>\
							<h4>Nombre y Apellido:</h4>\
							<input type="text" class="inputlogin form-control nombres" onkeyup="ponernombre('+j+',this.value)" placeholder="Nombre del Cliente" onkeypress="validarNombres(this,'+j+')" />\
						</div>\
						<div class="col-lg-5">\
							<h4 style="color:#fff;">&nbsp;</h4>\
							<h4>Documento (C.I./R.U.C/Pasaporte):</h4>\
							<input type="text" class="inputlogin form-control documento" onkeyup="ponerced('+j+',this.value)" placeholder="Cédula" value="'+newcedula+'" />\
							<input type="hidden" id="mailadded" value="no" />\
						</div>\
					</div>');
					$('#name_boletos'+j).append('<input type="hidden" class="nombres" id="nombres'+j+'" />\
												<input type="hidden" class="documento" id="documento'+j+'" />');
				}
				$('#obtenerboletos').html('<option value="0">Seleccione...</option><option value="correo">Correo Electrónico</option><option value="Domicilio">Envio al Domicilio</option><option value="3">Inmediato P. Venta</option>');
				$('.documento').val(newcedula);
				$('#wait').fadeOut();
			}else if(($.trim(response) != 'nodata') && ($.trim(response) != 'noexiste')){
				$('#clienteok').val('ok');
				$('#searchCliente').fadeOut();
				$('#newCliente').delay(600).fadeIn();
				$('#smstitulo').html('Los datos del Cliente ingresado son:');
				var respuesta = $.trim(response);
				var obj = jQuery.parseJSON(respuesta);
				for(var i = 0; i <= (obj.Cliente.length -1); i++){
					var id = obj.Cliente[i].id;
					var nombre = obj.Cliente[i].nombre;
					var mail = obj.Cliente[i].mail;
					var dir = obj.Cliente[i].dir;
					var envio = obj.Cliente[i].envio;
					var fijo = obj.Cliente[i].fijo;
					var movil = obj.Cliente[i].movil;
					var cedula = obj.Cliente[i].cedula;
					
					$('#cliente').val(id);
					$('#cliente_kiosko').val(nombre);
					$('#cliente_kiosko_id').val(id);
					$('#cliente_kiosko_ced').val(cedula);
					$('#personas_boletos').append('<span onclick = "verClientes()" style = "cursor:pointer;color:#fff;" >Ver Clientes</span>');
					for(var j = 0; j < num_personas; j++){
						var asiento = $('#chair'+j).val();
						var des = $('#des'+j).val();
						$('#personas_boletos').append('<div class="row datos_cliente_boleto contieneClientes" style="color:#fff;display:none;">\
							<div class="col-lg-5">\
								<h4 style="color:#fff;"><strong>TICKET: '+asiento+' ('+des+')</strong></h4>\
								<h4>Nombre y Apellido:</h4>\
								<input type="text" class="inputlogin form-control nombres" onkeyup="ponernombre('+j+',this.value)" placeholder="Nombre del Cliente" value="'+nombre+'" onkeypress="validarNombres(this,'+j+')" />\
							</div>\
							<div class="col-lg-5">\
								<h4 style="color:#fff;">&nbsp;</h4>\
								<h4>Documento (C.I./R.U.C/Pasaporte):</h4>\
								<input type="text" class="inputlogin form-control documento cambio'+j+'" onkeyup="ponerced('+j+',this.value)" placeholder="Cédula" value="'+cedula+'" />\
								<input type="hidden" id="mailadded" value="ok" />\
							</div>\
						</div>');
						$('#name_boletos'+j).append('<input type="hidden" class="nombres" id="nombres'+j+'" value="'+nombre+'" />\
												<input type="hidden" class="documento" id="documento'+j+'" value="'+cedula+'" />');
					}
					if(mail != 'h'){
					$('#mail').val(mail);
					$('#mail').prop('readonly','readonly');
					$('#mail').css('color','#000');
					$('#mail').css('cursor','default');
					}
					$('#movil').val(movil);
					$('#nomClienteBusca').val(nombre);
					$('#dir').val(dir);
					$('#fijo').val(fijo);
					if(envio == 'correo'){
						var forma = 'Correo Electrónico';
						$('#obtenerboletos').html('<option value="'+envio+'">'+forma+'</option><option value="Domicilio">Envio al Domicilio</option>');
					}else if(envio == 3){
						var forma = 'Inmediato P. Venta';
						$('#obtenerboletos').html('<option value="'+envio+'">'+forma+'</option><option value="correo">Correo Electrónico</option><option value="Domicilio">Envio al Domicilio</option>');
					}else{
						var forma = 'Envio al Domicilio';
						$('#obtenerboletos').html('<option value="'+envio+'">'+forma+'</option><option value="correo">Correo Electrónico</option>');
						// $('#tituloenvio').fadeIn();
						// $('#costoenvio').fadeIn();
						var costo = $('#costoenvio').html();
						var totalneto = $('#totalneto').val();
						var total = parseFloat(costo) + parseFloat(totalneto);
						total = parseFloat(total).toFixed(2);
						// $('#total').html('<strong>'+total+'</strong>');
						// $('#total_pagar').val(total);
					}
				}
				$('#wait').fadeOut('slow');
				$('#delete').delay(600).fadeIn('slow');
			}
		});
	}
}
function verClientes(){
	$('.contieneClientes').toggle('blind',500);
}
function llenarnombres(){
	var nombre = $('#nombres').val();
	$('.nombres').val(nombre);
}

function validarNombres(t,id){
	var otronom = $(t).val();
	$('.datos_cliente_boleto').each(function(){
		var nombres = $(this).find('.nombres').val();
		if(otronom != nombres){
			$('.cambio'+id).val('');
			$('.cambio'+id).prop('placeholder','Ingrese nuevo Documento de Identidad');
		}
	});
}

function ponernombre(id,dato){
	$('#nombres'+id).val(dato);
}

function ponerced(id,dato){
	$('#documento'+id).val(dato);
}

function quitarCliente(){
	$('#cliente').val('');
	$('#buscarcliente').val('');
	$('#nombres').val('');
	$('#documento').val('');
	$('#mail').val('');
	$('#movil').val('');
	$('#dir').val('');
	$('#fijo').val('');
	$('#delete').fadeOut('slow');
	$('#buscar').delay(600).fadeIn('slow');
}

function validarMails(valor){
	var mailadded = $('#mailadded').val();
	if(mailadded != 'ok'){
		$('.mailsbd').each(function(){
			var mailbd = $(this).find('.emails').val();
			if(valor == mailbd){
				$('#mail').val('');
				$('#alerta5').fadeIn();
				$('#aviso').modal('show');
				return false;
			}
		});
	}
}

function aceptarModal(){
	if(!$('#alerta1').is(':hidden')){
		window.location = '?modulo=conciertoDis&evento='+evento;
	}else if(!$('#alerta6').is(':hidden')){
		window.location = '?modulo=conciertoDis&evento='+evento;
	}
	$('.alertas').fadeOut();
	$('#aviso').modal('hide');
}

function cancelarNuevo(){
	$('#buscarcliente').val('');
	$('#buscarcliente').val('');
	$('#nombres').val('');
	$('#documento').val('');
	$('#mail').val('');
	$('#mail').removeAttr('readonly');
	$('#mail').css('color','#fff');
	$('#mail').css('cursor','text');
	$('#movil').val('');
	$('#dir').val('');
	$('#fijo').val('');
	$('#clienteok').val('');
	$('#personas_boletos').html('');
	$('#newCliente').fadeOut('slow');
	$('#searchCliente').delay(600).fadeIn('slow');
	$('#delete').fadeOut('slow');
	$('#tituloenvio').fadeOut();
	$('#costoenvio').fadeOut();
	var totalneto = $('#totalneto').val();
	$('#total').html('<strong>'+totalneto+'</strong>');
	$('#total_pagar').val(totalneto);
	$('#buscar').delay(600).fadeIn('slow');
}

function formaenvio(){
	var forma = $('#obtenerboletos').val();
	if(forma != 0){
		if(forma == 'Domicilio'){
			$('#tituloenvio').fadeIn();
			$('#costoenvio').fadeIn();
			var costo = $('#costoenvio').html();
			var totalneto = $('#totalneto').val();
			var total = parseFloat(costo) + parseFloat(totalneto);
			total = parseFloat(total).toFixed(2);
			// $('#total').html('<strong>'+total+'</strong>');
			// $('#total_pagar').val(total);
		}else{
			$('#tituloenvio').fadeOut();
			$('#costoenvio').fadeOut();
			var totalneto = $('#totalneto').val();
			// $('#total').html('<strong>'+totalneto+'</strong>');
			// $('#total_pagar').val(totalneto);
		}
	}
}

// var totalTiempo=300+300;
// var timestampStart = new Date().getTime();
// var endTime=timestampStart+(totalTiempo*1000);
// var timestampEnd=endTime-new Date().getTime();
// var tiempRestante=totalTiempo;

// function updateReloj(){
	// var Seconds=tiempRestante;
	
	// var Days = Math.floor(Seconds / 86400);
	// Seconds -= Days * 86400;

	// var Hours = Math.floor(Seconds / 3600);
	// Seconds -= Hours * (3600);

	// var Minutes = Math.floor(Seconds / 60);
	// Seconds -= Minutes * (60);

	// var TimeStr = ((Days > 0) ? Days + " dias " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds);
	
	// $('#CuentaAtras').html(TimeStr);
	// if(endTime<=new Date().getTime())
	// {
		// $('#CuentaAtras').html('00:00:00');
	// }else{
		// tiempRestante-=1;
		// setTimeout("updateReloj()",1000);
	// }
// }

// function LeadingZero(Time) {
	// return (Time < 10) ? "0" + Time : + Time;
// }
// setTimeout("$('#alerta2').fadeIn(); $('#aviso').modal('show');",600000);

function guardarDatos(){
	var clienteok = $('#clienteok').val();
	var idcliente = $('#cliente').val();
	if(clienteok == 'no'){
		var nombres = $('#nombres').val();
		var documento = $('#documento').val();
	}else{
		var nombres = 'no';
		var documento = 'no';
	}
	var mail = $('#mail').val();
	var movil = $('#movil').val();
	var concierto = $('#idConcierto').val();
	var forma = 'correo';
	var dir = $('#dir').val();
	var tipopago = '';
	if($('#tarjeta').is(':checked')){
		tipopago = 'Tarjeta de Credito';
	}else if($('#efectivo').is(':checked')){
		tipopago = 'Efectivo';
	}
	
	if(forma == 3){
		mail = 'h';
	}
	
	var valores = '';
	
	$('.datos_boleto').each(function(){
		var localidad = $(this).find('.localidad').val();
		var descripcion = $(this).find('.des').val();
		var asiento = $(this).find('.asiento').val();
		var precio = $(this).find('.precio').val();
		var fila = $(this).find('.fila').val();
		var col = $(this).find('.col').val();
		var nombre = $(this).find('.nombres').val();
		var cedula = $(this).find('.documento').val();
		
		valores += localidad +'|'+ descripcion +'|'+ asiento +'|'+ precio +'|'+ fila +'|'+ col +'|'+ nombre +'|'+ cedula +'|'+'@';
	});
	var valores_form = valores.substring(0,valores.length -1);
	
	var valores_cliente = '';
	
	$('.datos_cliente_boleto').each(function(){
		var nombre = $(this).find('.nombres').val();
		var cedula = $(this).find('.documento').val();
		if((nombre == '') || (cedula == '')){
			valores_cliente = '';
			return false;
		}
		valores_cliente += nombre +'|'+ cedula +'|'+'@';
	});
	var valores_cliente_form = valores_cliente.substring(0,valores_cliente.length -1);
	
	if((tipopago == '') || (valores_cliente == '') || (mail == '') || (dir == '') || (forma == 0) || (nombres == '') || (documento == '')){
		$('#alerta4').fadeIn();
		$('#aviso').modal('show');
		return false;
	}else{
		if((clienteok == 'ok') && (idcliente != '')){
			if($("input[name='subirCedula']").is(':checked')){
				var recibeCedula = $('#recibeExcel2').val();
				
				if(recibeCedula == ''){
					alert('Debe subir la copia de cedula');
				}else{
					$('#accionContinuar').fadeOut();
					$('#procesando').delay(600).fadeIn();
					$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor.php',{
						clienteok : clienteok, idcliente : idcliente, concierto : concierto, valores : valores_form, tipopago : tipopago, 
						forma : forma, mail : mail, movil : movil, dir : dir,valores_cliente : valores_cliente_form , recibeCedula : recibeCedula
					}).done(function(response){
						if($.trim(response) == 'error'){
							$('#alerta6').fadeIn();
							$('#aviso').modal('show');
						}else if($.trim(response) == 'ok'){
							window.location = '?modulo=pagoexitosoDis';
						}else{
							// var mywindow = window.open('', 'Receipt', 'height=800,width=1200');
							// mywindow.document.write('<html><head><title></title>');
							// mywindow.document.write('</head><body >');
							// mywindow.document.write(response);
							// mywindow.document.write('</body></html>');

							// mywindow.print();
							// mywindow.close();
							window.location = '?modulo=pagoexitosoDis';
						}
					});
				}
			}else{
				var recibeCedula = '';
				$('#accionContinuar').fadeOut();
				$('#procesando').delay(600).fadeIn();
				$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor.php',{
					clienteok : clienteok, idcliente : idcliente, concierto : concierto, valores : valores_form, tipopago : tipopago, 
					forma : forma, mail : mail, movil : movil, dir : dir,valores_cliente : valores_cliente_form , recibeCedula : recibeCedula
				}).done(function(response){
					if($.trim(response) == 'error'){
						$('#alerta6').fadeIn();
						$('#aviso').modal('show');
					}else if($.trim(response) == 'ok'){
						window.location = '?modulo=pagoexitosoDis';
					}else{
						// var mywindow = window.open('', 'Receipt', 'height=800,width=1200');
						// mywindow.document.write('<html><head><title></title>');
						// mywindow.document.write('</head><body >');
						// mywindow.document.write(response);
						// mywindow.document.write('</body></html>');

						// mywindow.print();
						// mywindow.close();
						window.location = '?modulo=pagoexitosoDis';
					}
				});
			}
		}else if((clienteok == 'ok') && (idcliente == '')){
			$('#alerta3').fadeIn();
			$('#aviso').modal('show');
			return false;
		}else if(clienteok == 'no'){
			if($("input[name='subirCedula']").is(':checked')){
				var recibeCedula = $('#recibeExcel2').val();
				
				if(recibeCedula == ''){
					alert('Debe subir la copia de cedula');
				}else{
					$('#accionContinuar').fadeOut();
					$('#procesando').delay(600).fadeIn();
					$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor.php',{
						clienteok : clienteok, mail : mail, movil : movil, dir : dir, concierto : concierto, valores : valores_form, tipopago : tipopago,
						forma : forma, valores_cliente : valores_cliente_form, documento : documento, nombres : nombres , recibeCedula : recibeCedula
					}).done(function(response){
						if($.trim(response) == 'error'){
							$('#alerta6').fadeIn();
							$('#aviso').modal('show');
						}else if($.trim(response) == 'ok'){
							window.location = '?modulo=pagoexitosoDis';
						}else{
							// var mywindow = window.open('', 'Receipt', 'height=400,width=600');
							// mywindow.document.write('<html><head><title></title>');
							// mywindow.document.write('</head><body >');
							// mywindow.document.write(response);
							// mywindow.document.write('</body></html>');

							// mywindow.print();
							// mywindow.close();
							window.location = '?modulo=pagoexitosoDis';
						}
					});
				}
			}else{
				var recibeCedula = '';
				$('#accionContinuar').fadeOut();
				$('#procesando').delay(600).fadeIn();
				$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor.php',{
					clienteok : clienteok, mail : mail, movil : movil, dir : dir, concierto : concierto, valores : valores_form, tipopago : tipopago,
					forma : forma, valores_cliente : valores_cliente_form, documento : documento, nombres : nombres , recibeCedula : recibeCedula
				}).done(function(response){
					if($.trim(response) == 'error'){
						$('#alerta6').fadeIn();
						$('#aviso').modal('show');
					}else if($.trim(response) == 'ok'){
						window.location = '?modulo=pagoexitosoDis';
					}else{
						// var mywindow = window.open('', 'Receipt', 'height=400,width=600');
						// mywindow.document.write('<html><head><title></title>');
						// mywindow.document.write('</head><body >');
						// mywindow.document.write(response);
						// mywindow.document.write('</body></html>');

						// mywindow.print();
						// mywindow.close();
						window.location = '?modulo=pagoexitosoDis';
					}
				});
			}
		}else if(clienteok == ''){
			$('#alerta3').fadeIn();
			$('#aviso').modal('show');
		}
	}
}