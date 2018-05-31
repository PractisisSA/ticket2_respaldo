function cambiarEstadoUserAct(id) {
	var retVal = confirm("Seguro que quieres activar este Usuario?");
		if (retVal == true) {
			$.post("SP/ajax/ajaxActivarUser.php",{ 
				id : id
			}).done(function(data){
				if (data != 1) {
					console.log(data);
				}else{
					console.log('Success')
					alert('User Activado');
					location.reload(); 			
				}
		});
	}

}
function cambiarEstadoUserDes(id) {
	var retVal = confirm("Seguro que quieres Desactivar este Usuario?");
		if (retVal == true) {
			$.post("SP/ajax/ajaxDesactivarUser.php",{ 
				id : id
			}).done(function(data){
				if (data != 1) {
					console.log(data);
				}else{
					console.log('Success')
					alert('User Desactivado');
					location.reload(); 			
				}
		});
	}

}
function cambiarEstadoAct(id) {
	var retVal = confirm("Seguro que quieres activar este distribuidor?");
		if (retVal == true) {
			$.post("SP/ajax/ajaxActivarEstado.php",{ 
				id : id
			}).done(function(data){
				if (data != 1) {
					console.log(data);
				}else{
					console.log('Success')
					alert('Distribuidor Activado');
					location.reload(); 			
				}
		});
	}

}

function cambiarEstado(id) {

	var retVal = confirm("Seguro que quieres desactivar este distribuidor?");
		if (retVal == true) {
			$.post("SP/ajax/ajaxEditarEstado.php",{ 
			id : id
		}).done(function(data){
			if (data != 1) {
				console.log(data);
			}else{
				console.log('Successs');
				alert("Distribuidor desactivado");
				location.reload();
			}
		});
	}
    
}
function edicionDistribuidores(idDis){
	$('#idDis').val(idDis);
	var identificador = 1;
	var content = '';
	var content2 = '';
	$.post('SP/ajax/ajaxEditarDistribuidor.php',{
		idDis : idDis, identificador : identificador
	}).done(function(response){
		$('.listaDistribuidores').fadeOut('slow');
		$('.editarDistribuidor').delay(600).fadeIn('slow');
		var respuesta = response.split('|');
		
		var objDatos = jQuery.parseJSON(respuesta[0]);
		
		for(i=0; i <= (objDatos.Datos.length -1); i++){
			var id = objDatos.Datos[i].id; 
			var nombre = objDatos.Datos[i].nombre;
			var documento = objDatos.Datos[i].documento;
			var telefono = objDatos.Datos[i].telefono;
			var mail = objDatos.Datos[i].mail;
			var dir = objDatos.Datos[i].dir;
			var movil = objDatos.Datos[i].movil;
			var contacto = objDatos.Datos[i].contacto;
			var observaciones = objDatos.Datos[i].observaciones;
			var pventas = objDatos.Datos[i].pventas;
			var pcobros = objDatos.Datos[i].pcobros;
			var estado = objDatos.Datos[i].estado;
			var tipo_emp = objDatos.Datos[i].tipo_emp;
			var tarjetaDis = objDatos.Datos[i].tarjetaDis;
			
			
			$('#nombreEditar').val(nombre);
			$('#identificadorEditar').val(documento);
			$('#mailEditar').val(mail);
			$('#telefonoEditar').val(telefono);
			$('#dirEditar').val(dir);
			$('#movilEditar').val(movil);
			$('#contactoEditar').val(contacto);
			$('#observacionesEditar').val(observaciones);
			$('#poocentajeventasEditar').val(pventas);
			$('#porcentajecobrosEditar').val(pcobros);
			
			if(estado == 'Activo'){
				$('#estadoEdit').append('<option value="'+estado+'">'+estado+'</option><option value="Inactivo">Inactivo</option>');
			}else{
				$('#estadoEdit').append('<option value="'+estado+'">'+estado+'</option><option value="Activo">Activo</option>');
			}
			
			if(tipo_emp == 1){
				$('#tipo_empDistri').append('<option value="'+tipo_emp+'">Ventas Ticket-facil</option><option value="2">Cadena Comercial</option>');
			}else if(tipo_emp == 2){
				$('#tipo_empDistri').append('<option value="'+tipo_emp+'">Cadena Comercial</option><option value="1">Ventas Ticket-facil</option>');
			}
			
			
			if(tarjetaDis == 1){
				$('#tipo_empDistri2').append('<option value="'+tarjetaDis+'">Normal</option><option value="2">Especial</option>');
			}else if(tarjetaDis == 2){
				$('#tipo_empDistri2').append('<option value="'+tarjetaDis+'">Especial</option><option value="1">Normal</option>');
				
				var id_socio = objDatos.Datos[i].id_socio;
				$.post("SP/ajax/saberSocioDistribuidor.php",{ 
					id_socio : id_socio 
				}).done(function(data){
					$('#contieneSocio2').fadeIn('fast')
					$('#socio2').html(data)
				});
			}
			
		}
		
		var objDetalle = jQuery.parseJSON(respuesta[1]);
				
		for(var j = 0; j <= (objDetalle.DatosEvento.length -1); j++){
			var id2 = objDetalle.DatosEvento[j].id; 
			var concierto = objDetalle.DatosEvento[j].concierto;
			var lugar = objDetalle.DatosEvento[j].lugar;
			var fecha = objDetalle.DatosEvento[j].fecha;
			var hora = objDetalle.DatosEvento[j].hora;
			var img = objDetalle.DatosEvento[j].img;
			var estadoDet = objDetalle.DatosEvento[j].estadoDet;
			var idConcierto = objDetalle.DatosEvento[j].idConcierto;
			
			if(estadoDet == 'Activo'){
				var button = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
			}else{
				var button = '<span class="glyphicon glyphicon-plus act" aria-hidden="true"></span>';
			}
			content += '<div class="col-md-6 col-md-2">\
							<div class="thumbnail" style="height:300px;">\
								<img src="spadmin/'+img+'" alt="">\
								<div class="caption">\
									<p>'+concierto+'</p>\
									<p><strong>Lugar: </strong>'+lugar+'</p>\
									<p><strong>Fecha: </strong>'+fecha+'</p>\
									<p><strong>Hora: </strong>'+hora+'</p>\
									<p><strong>#ev.: </strong>'+idConcierto+'</p>\
									<button class="btn btn-success" id="btn'+id2+'" style="position:absolute; right:0px; top:0;" onclick="eliminar('+id2+')" title="Eliminar Evento" role="button">\
										'+button+'\
									</button>\
								</div>\
							</div>\
						</div>';
		}
		
		if(respuesta[2] != ''){
			var objNuevo = jQuery.parseJSON(respuesta[2]);
		
			var count = 1;
			for(var k = 0; k <= (objNuevo.NuevoConcierto.length -1); k++){
				var idcon = objNuevo.NuevoConcierto[k].idcon; 
				var concierto = objNuevo.NuevoConcierto[k].concierto;
				var lugar = objNuevo.NuevoConcierto[k].lugar;
				var fecha = objNuevo.NuevoConcierto[k].fecha;
				var hora = objNuevo.NuevoConcierto[k].hora;
				var img = objNuevo.NuevoConcierto[k].img;
				
				content2 += '<div class="col-md-6 col-md-2 newfilasConciertos">\
								<div class="thumbnail" style="height:300px;">\
									<img src="spadmin/'+img+'" alt="">\
									<div class="caption">\
										<p>'+concierto+'</p\
										<p><strong>Lugar: </strong>'+lugar+'</p>\
										<p><strong>Fecha: </strong>'+fecha+'</p>\
										<p><strong>Hora: </strong>'+hora+'</p>\
										<p><strong>#ev.: </strong>'+idcon+'</p>\
										<div class="btn btn-info btn-xs" style="position:absolute; right:5px; bottom:25px;"><input type="checkbox" class="newcheckEvento" style="transform: scale(1.2); -webkit-transform: scale(1.2);" id="newcheck'+count+'" value="'+idcon+'" /></div>\
										</button>\
									</div>\
								</div>\
							</div>';
				count++;
			}
		}
		
		$('#conciertoXdistribuidorEditar').append(content);
		$('#conciertoXdistribuidorEditar').append(content2);
	});
}

function ValidarCedula(){
	var numero = $('#identificadorEditar').val();
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
	$('#identificadorEditar').val('');
	$('#alertaEdit2').fadeIn('slow');
	$('#alertaEdit2').delay(1500).fadeOut('slow');
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
	$('#identificadorEditar').val('');
	$('#alertaEdit2').fadeIn('slow');
	$('#alertaEdit2').delay(1500).fadeOut('slow');
	return false;
	}
	/* El ruc de las empresas del sector publico terminan con 0001*/
	if ( numero.substr(9,4) != '0001' ){
	console.log('El ruc de la empresa del sector público debe terminar con 0001');
	$('#identificadorEditar').val('');
	$('#alertaEdit2').fadeIn('slow');
	$('#alertaEdit2').delay(1500).fadeOut('slow');
	return false;
	}
	}
	else if(pri == true){
	if (digitoVerificador != d10){
	console.log('El ruc de la empresa del sector privado es incorrecto.');
	$('#identificadorEditar').val('');
	$('#alertaEdit2').fadeIn('slow');
	$('#alertaEdit2').delay(1500).fadeOut('slow');
	return false;
	}
	if ( numero.substr(10,3) != '001' ){
	console.log('El ruc de la empresa del sector privado debe terminar con 001');
	$('#identificadorEditar').val('');
	$('#alertaEdit2').fadeIn('slow');
	$('#alertaEdit2').delay(1500).fadeOut('slow');
	return false;
	}
	}

	else if(nat == true){
	if (digitoVerificador != d10){
	console.log('El número de cédula de la persona natural es incorrecto.');
	$('#identificadorEditar').val('');
	$('#alertaEdit2').fadeIn('slow');
	$('#alertaEdit2').delay(1500).fadeOut('slow');
	return false;
	}
	if (numero.length >10 && numero.substr(10,3) != '001' ){
	console.log('El ruc de la persona natural debe terminar con 001');
	$('#identificadorEditar').val('');
	$('#alertaEdit2').fadeIn('slow');
	$('#alertaEdit2').delay(1500).fadeOut('slow');
	return false;
	}
	}
	return true;
}

function validarMail(){
	var email = $('#mailEditar').val();
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
		$('#mailEditar').val('');
		$('#alertaEdit3').fadeIn();
		$('#alertaEdit3').delay(3000).fadeOut();
	}
}

function eliminar(id){
	$('#iddelete').val(id);
	$('#aviso').modal('show');
}

function deleteFilas(){
	$('#aviso').modal('hide');
	var id = $('#iddelete').val();
	var identificador = 2;
	var boton = $('#btn'+id).html();
	if(id != ''){
		if($.trim(boton) == '<span class="glyphicon glyphicon-plus act" aria-hidden="true"></span>'){
			$('#btn'+id).html('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>');
		}else if($('#eventdelete'+id).length){
			$('#btn'+id).html('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>');
			$('#eventdelete'+id).remove();
		}else{
			$('#btn'+id).html('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>');
			$('#eliminados').append('<input type="hidden" id="eventdelete'+id+'" value="'+id+'" />');
		}
		$.post('SP/ajax/ajaxEditarDistribuidor.php',{
			id : id, identificador : identificador
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#alertaEdit7').fadeIn();
				setTimeout("$('#alertaEdit7').fadeOut();",3000);
			}
		});
	}
}

function cancelDelete(){
	$('#aviso').modal('hide');
	id = $('#iddelete').val();
	$('#iddelete').val('');
}
function prueba() {
	var est = $('#estadoEdit').val();
	console.log(est);
}

function saveEdicion(){
	var nombre = $('#nombreEditar').val();
	var documento = $('#identificadorEditar').val();
	var telefono = $('#telefonoEditar').val();
	var dir = $('#dirEditar').val();
	var contacto = $('#contactoEditar').val();
	var mail = $('#mailEditar').val();
	var poocentajeventas = $('#poocentajeventasEditar').val();
	var porcentajecobros = $('#porcentajecobrosEditar').val();
	var movil = $('#movilEditar').val();
	var observaciones = $('#observacionesEditar').val();
	var estado = $('#estadoEdit').val();
	var identificador = 3;
	var id = $('#idDis').val();
	var valoresEdit = '';
	var tipo_empDistri = $('#tipo_empDistri').val();
	var tipo_empDistri2 = $('#tipo_empDistri2').val();
	var socio = 0;
	
	if(tipo_empDistri2 == 2){
		socio = $('#socio2').val();
	}else{
		socio = $('#socio2').val();
	}
	
	var countsave = 1;
	$('.newfilasConciertos').each(function(){
		if($('#newcheck'+countsave).is(':checked')){
			var evento = $('#newcheck'+countsave).val();
			valoresEdit += evento +'|'+'@';
		}
		countsave++;
	});
	var valores_edit = valoresEdit.substring(0,valoresEdit.length -1);
	
	if((nombre == '') || (documento == '') || (telefono == '') || (dir == '') || (contacto == '') || (mail == '') || (movil == '') || (observaciones == '') || (poocentajeventas == '') || (porcentajecobros == '')){
		$('#alertaEdit1').fadeIn();
		setTimeout("$('#alertaEdit1').fadeOut();",3000);
        $('#btnguarda').prop('disabled',false);
	}else{
		$.post('SP/ajax/ajaxEditarDistribuidor.php',{
			nombre : nombre, documento : documento, telefono : telefono, dir : dir, contacto : contacto, mail : mail, socio : socio ,
			movil : movil, observaciones : observaciones, poocentajeventas : poocentajeventas, porcentajecobros : porcentajecobros, 
			identificador : identificador, id : id, estado : estado, valoresEdit : valores_edit , tipo_empDistri : tipo_empDistri , tipo_empDistri2 : tipo_empDistri2
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#alertaEdit4').fadeIn();
				$('html, body').animate({ scrollTop: 0 }, 'slow');
				setTimeout("window.location = '';",3000);
			}
		});
	}
}

function cancelarEdicion(){
	$('.editarDistribuidor').fadeOut('slow');
	$('.lista_distribudor').fadeOut('slow');
	$('#conciertoXdistribuidorEditar').html('');
	$('.cabecera_distribuidores').delay(600).fadeIn('slow');
}