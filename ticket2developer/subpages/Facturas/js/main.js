var divForSelect = $('#firstOptionValue0');
var divForLocalidad = $('#divForLocalidadData');
var selectForConcerts = $('#selectForConcerts');
var idConcert;
divForLocalidad.css('display', 'none'); 
$.ajax({
	method: 'GET',
	url:'subpages/Facturas/includes/facturacion_concerts.php',
	success: function (response) {
		if (response == '' || response == 0 || response == null || response == false) {alert('No hay conciertos para este distribuidor');}
		else { divForSelect.after(response); }
	}
})
$(selectForConcerts).change(function(){
	var idConcert = $('#selectForConcerts').val();
	if (idConcert == '' || idConcert == 0) {
		divForLocalidad.fadeOut('slow');
	}else{
		$.ajax({
			method:'POST',
			url:'subpages/Facturas/includes/prueba.php',
			data: {idConcert:idConcert},
			success: function (response) {
				divForLocalidad.fadeIn('slow');divForLocalidad.html(response);
				/*
				if (response == 1) { alert('No hay datos'); }
				else { divForLocalidad.fadeIn('slow');divForLocalidad.html(response); }
				*/
			}
		})
	}
})

/*
$(divForLocalidad).change(function () {
	var idLoc = $('#localidadSelect').val();
	if (idLoc == '' || idLoc == 0) {
		alert('Debe ingresar una localidad');
	}else{
		$.ajax({
			method: 'POST',
			url: 'subpages/Facturas/includes/facturacion_descuentos.php',
			data: {idLoc:idLoc},
			success: function (response) {
				$('#divForDescounts').html(response);
				if (response == 1) { alert('No hay descuentos para esta localidad'); }
				else{ $('#divForDescounts').html(response); }
			}
		})
	}
})*/
function nuevaFactura() {
	var idConcert = $('#selectForConcerts').val();
	if (idConcert == '' || idConcert == 0) {
		alert('No hay concierto');
	}else{
		$.ajax({
			method: 'POST',
			url: 'subpages/Facturas/includes/facturacion_localidad.php',
			data: {idConcert:idConcert},
			success: function (response) {
				divForLocalidad.append(response);
			}
		})
	}
	
}
