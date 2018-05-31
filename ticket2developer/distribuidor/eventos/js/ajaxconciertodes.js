var dias = $('#dias').val();
var horas = $('#horas').val();
var minutos = $('#minutos').val();
var segundos = $('#segundos').val();
var diasventa = $('#diasventa').val();
var horasventa = $('#horasventa').val();
var minutosventa = $('#minutosventa').val();
var segundosventa = $('#segundosventa').val();
var valor_session = $('#session').val();
var con = $('#concierto').val();
var variables = '';
var dir_map = 'spadmin/'; 
var mapa_opaco = $('#mapa_opacity').val();
var ruta = dir_map+mapa_opaco;
var num_preventa = $('#num_rows_preventa').val();
var num_reserva = $('#num_rows_reserva').val();

window.onload = function (){
	if(num_preventa > 0){
		s = new clockCountdown('clock2',{'days':diasventa,'hours':horasventa,'minutes':minutosventa,'seconds':segundosventa});
	}
}

var timer2 = 0;
function animaciontitle(){
	var tiempo = 0;
	timer2 = setInterval(function(){
		tiempo = parseInt(tiempo) + parseInt(1);
		if(tiempo <= 1){
			$('#titulo1').css('color','#f8e316');
		}else{
			$('#titulo1').css('color','#fff');
			tiempo = 0;
		}
	},400);
}

$(document).ready(function(){
	clearInterval(timer2);
	animaciontitle();
	
	$('#localmapa').mapster({
		singleSelect: true,
		render_highlight: {altImage: ruta},
		render_select: false,
		mapkey: 'data-state',
		fill: true,
		// fillColor: '282B2D',
		//fillOpacity: 1,
	});
	
	$('#ok').on('click',function(){
		var con = $('#concierto').val();
		if($('.asientosok').length){
			$('#form').attr('action','');
			$('#ok').prop('type','submit');
			accion ='?modulo=vederDis&con='+con;
			$('#form').attr('action',accion);
			$('#identification').addClass('active');
			$('#chooseseat').removeClass('active');
		}else{
			$('#aviso').modal('show');
		}
	});
	
	$('#aceptaraleatorios').on('click',function(){
		var con = $('#concierto').val();
		if($('.asientosok').length){
			$('#form').attr('action','');
			accion ='?modulo=vederDis&con='+con;
			$('#form').attr('action',accion);
			$('#form').submit();
		}else{
			$('#aviso').modal('show');
		}
	});
});

var timer = 0;
function animaringreso(){
	var mostrar = 0;
	timer = setInterval(function(){
		mostrar = parseInt(mostrar) + parseInt(1);
		if(mostrar <= 4){
			$('#arrow'+mostrar).fadeIn();
		}else{
			$('.arrow').fadeOut();
			mostrar = 0;
		}
	},400);
}

function asientos_mapa(local, concierto){
	$('#boton_localidad_'+local).attr('disabled',true);
	$('#load_localidad_'+local).css('display','block');
	$.post("subpages/Conciertos/saber_asientos_numerados.php",{ 
		local : local , concierto : concierto
	}).done(function(data){
		var respuesta = data.split('|');
		var valorAsientos = respuesta[0];
		var precio = respuesta[1];
		var local = respuesta[2];
		var options = respuesta[3];
		$('.comboSinNumeracion').html(options);
		$('#precioLocalidadSinNum').val(precio);
		$('#localidadSinNum').val(local);
		if(valorAsientos == 0){
			//alert('es asientos no numerados');
			animaringreso();
			var nombrelocal = $('#local'+local).val();
			$('#nombrelocaldiadNoNumerados').html('Estas en <strong id = "nomLoc">'+nombrelocal+'<strong>');
			$('#ocultar').fadeOut('slow');
			$('#contieneNoNumerados').fadeIn('slow');
			$('#ok').fadeIn('slow');
			$('#ok_2').fadeOut('slow');
			$('html, body').animate({ scrollTop: 0 }, 'slow');
		}else{
			animaringreso();
			$('#ok').fadeOut('slow');
			$('#ok_2').fadeIn('slow');
			var nombrelocal = $('#local'+local).val();
			$('#nombrelocaldiad').html('Estas en <strong>'+nombrelocal+'<strong>');
			var numcolumnas = $('#limite_columnas'+local).val();
			var divisiones = parseInt(numcolumnas) / parseInt(30);
			divisiones = Math.ceil(divisiones); 
			var totdivisiones = parseInt(500) / parseInt(divisiones);
			for(var i = 1; i <= divisiones; i++){
				// if(i == 1){
					// $('#divisiones_mapa'+local).append('<div onclick="open_rest_map('+i+','+local+','+concierto+')" id="img_hover'+local+'_'+i+'" class="img_over'+local+'" style="background-color:#67cdf5; color:#000; font-size:20px; display:inline-block; height:100px; width:'+totdivisiones+'px; opacity:0.9; border:1px solid #000; cursor:pointer;">'+i+'</div>');
				// }else{
					//$('#divisiones_mapa'+local).append('<div onclick="open_rest_map('+i+','+local+','+concierto+')" id="img_hover'+local+'_'+i+'" style="width:'+totdivisiones+'px;" class="img_over'+local+' secciones">'+i+'</div>');
					$('#divisiones_mapa'+local).append('<button type="button" id = "contiene_seccion_local_'+i+'"  onclick="open_rest_map('+i+','+local+','+concierto+')" id="img_hover'+local+'_'+i+'" style="width:'+totdivisiones+'px;" class="img_over'+local+' secciones botones_secciones" >'+i+'</button>');
				// }
			}
			
			if($('#mostrar'+local).length){
				$('#ocultar').fadeOut('slow');
				$('#mostrar_mapa').delay(600).fadeIn();
				$('#img_localidad'+local).fadeIn();
				$('.ocultar'+local).fadeOut();
				$('#detallesillas'+local).fadeIn();
				$('#botones'+local).fadeIn();
				// $('#mostrar'+local).fadeIn();
				// $('#nombreseccion').html('Estas en la sección <strong>1</strong>');
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}else{
				$('#detallesillas'+local).fadeIn();
				$('#botones'+local).fadeIn();
				// $('#nombreseccion').html('Estas en la sección <strong>1</strong>');
				$('#ocultar').fadeOut('slow');
				$('#mostrar_mapa').delay(600).fadeIn();
				$('#wait').fadeIn();
				$('#img_localidad'+local).fadeIn();
				
				$.ajax({
					type : 'POST',
					url : 'subpages/Conciertos/construir_mapa.php',
					data : 'local='+local +'&concierto='+concierto,
					success : function(response){
						$('#localidad_butaca').append(response);
						$('#wait').fadeOut();
					}
				});
			}
			$('html, body').animate({ scrollTop: 0 }, 'slow');
		}	
	});
}

function open_rest_map(id, local, concierto){
	$('.botones_secciones').attr('disabled',false);
	$('.botones_secciones').removeClass('colores');
	$('#contiene_seccion_local_'+id).attr('disabled',true);
	$('#contiene_seccion_local_'+id).addClass('colores');
	$('html, body').animate({ scrollTop: 800 }, 'slow');
	var nombrelocal = $('#local'+local).val();
	$('#nombrelocaldiad').html('Estas en <strong>'+nombrelocal+'<strong>');
	$('#nombreseccion').html('Estas en la sección <strong>'+id+'</strong>');
	$('.img_over'+local).css('background-color','#f8e316');
	$('#img_hover'+local+'_'+id).css('background-color','#67cdf5');
	$('#segundopaso').fadeIn();
	clearInterval(timer);
	if(id == 1){
		$('#mostrar'+local).fadeIn();
		$('.ocultar'+local).fadeOut();
		$('#localidadAcientos').css('display','block');
	}else{
		$('#mostrar'+local).fadeOut();
		$('.mostrartable'+id).css('display','none');
		$('.ocultar'+local).css('display','none');
		if($('#asientos_local-'+local+'_'+id).length){
			$('#contar_boletos'+local+'_'+id).fadeIn();
		}else{
			$('#wait').fadeIn();
			$.ajax({
				type : 'POST',
				url : 'distribuidor/eventos/continuacion_asientos.php',
				data : 'id='+id +'&local='+local +'&concierto='+concierto,
				success : function(response){
					$('#localidad_butaca').append(response);
					$('#localidadAcientos').css('display','block');
					$('#wait').fadeOut();
				}
			});
		}
	}
}

function add_asientos(local, concierto, row, col){
	var numboletos = $('#numboletos'+local).html();
	var color = $('#A-'+local+'-'+row+'-'+col).css('background-color');
	if(color == 'rgb(255, 255, 255)'){
		$('#A-'+local+'-'+row+'-'+col).css('background-color','#67cdf5');
		numboletos = parseInt(numboletos) + parseInt(1);
		$('#numboletos'+local).html(numboletos);
	}else{
		$('#A-'+local+'-'+row+'-'+col).css('background-color','#fff');
		$('#new_selection_'+row+'_'+col+'_'+local).remove();
		numboletos = parseInt(numboletos) - parseInt(1);
		$('#numboletos'+local).html(numboletos);
		$('#descripcionsilla'+local).html('');
		return false;
	}
	
	var secuencial = $('#secuencial'+local).val();
	if($('#new_selection_'+row+'_'+col+'_'+local).length){
		$('#descripcionsilla'+local).html('');
	}else{
		if(secuencial == 0){
			$('#descripcionsilla'+local).html('<p align="center">FILA-'+row+'_SILLA-'+col+'</p>');
		}else if(secuencial == 1){
			if(row == 1){
				$('#descripcionsilla'+local).html('<p align="center">FILA-A_SILLA-'+col+'</p>');
			}
			if(row == 2){
				$('#descripcionsilla'+local).html('<p align="center">FILA-B_SILLA-'+col+'</p>');
			}
			if(row == 3){
				$('#descripcionsilla'+local).html('<p align="center">FILA-C_SILLA-'+col+'</p>');
			}
			if(row == 4){
				$('#descripcionsilla'+local).html('<p align="center">FILA-D_SILLA-'+col+'</p>');
			}
			if(row == 5){
				$('#descripcionsilla'+local).html('<p align="center">FILA-E_SILLA-'+col+'</p>');
			}
			if(row == 6){
				$('#descripcionsilla'+local).html('<p align="center">FILA-F_SILLA-'+col+'</p>');
			}
			if(row == 7){
				$('#descripcionsilla'+local).html('<p align="center">FILA-G_SILLA-'+col+'</p>');
			}
			if(row == 8){
				$('#descripcionsilla'+local).html('<p align="center">FILA-H_SILLA-'+col+'</p>');
			}
			if(row == 9){
				$('#descripcionsilla'+local).html('<p align="center">FILA-I_SILLA-'+col+'</p>');
			}
			if(row == 10){
				$('#descripcionsilla'+local).html('<p align="center">FILA-J_SILLA-'+col+'</p>');
			}
			if(row == 11){
				$('#descripcionsilla'+local).html('<p align="center">FILA-K_SILLA-'+col+'</p>');
			}
			if(row == 12){
				$('#descripcionsilla'+local).html('<p align="center">FILA-L_SILLA-'+col+'</p>');
			}
			if(row == 13){
				$('#descripcionsilla'+local).html('<p align="center">FILA-M_SILLA-'+col+'</p>');
			}
			if(row == 14){
				$('#descripcionsilla'+local).html('<p align="center">FILA-N_SILLA-'+col+'</p>');
			}
			if(row == 15){
				$('#descripcionsilla'+local).html('<p align="center">FILA-O_SILLA-'+col+'</p>');
			}
			if(row == 16){
				$('#descripcionsilla'+local).html('<p align="center">FILA-P_SILLA-'+col+'</p>');
			}
			if(row == 17){
				$('#descripcionsilla'+local).html('<p align="center">FILA-Q_SILLA-'+col+'</p>');
			}
			if(row == 18){
				$('#descripcionsilla'+local).html('<p align="center">FILA-R_SILLA-'+col+'</p>');
			}
			if(row == 19){
				$('#descripcionsilla'+local).html('<p align="center">FILA-S_SILLA-'+col+'</p>');
			}
			if(row == 20){
				$('#descripcionsilla'+local).html('<p align="center">FILA-T_SILLA-'+col+'</p>');
			}
			if(row == 21){
				$('#descripcionsilla'+local).html('<p align="center">FILA-U_SILLA-'+col+'</p>');
			}
			if(row == 22){
				$('#descripcionsilla'+local).html('<p align="center">FILA-V_SILLA-'+col+'</p>');
			}
			if(row == 23){
				$('#descripcionsilla'+local).html('<p align="center">FILA-W_SILLA-'+col+'</p>');
			}
			if(row == 24){
				$('#descripcionsilla'+local).html('<p align="center">FILA-X_SILLA-'+col+'</p>');
			}
			if(row == 25){
				$('#descripcionsilla'+local).html('<p align="center">FILA-Y_SILLA-'+col+'</p>');
			}
		}
		$.ajax({
			type : 'POST',
			url : 'distribuidor/eventos/seleccionarasientos.php',
			data : 'local='+local +'&concierto='+concierto +'&row='+row +'&col='+col,
			success : function(response){
				$('#seleccion').append(response);
			}
		});
	}
}

function elimanarsillas(local, concierto, row, col){
	$('#A-'+local+'-'+row+'-'+col).css('background-color','#fff');
	$('#new_selection_'+row+'_'+col+'_'+local).remove();
}

function save_local(local, concierto){
	$('#img_localidad'+local).css('display','none');
	$('#descripcionsilla'+local).html('');
	$('.img_over'+local).remove();
	$('#detallesillas'+local).fadeOut();
	$('#botones'+local).fadeOut();
	$('.contar_boletos'+local).css('display','none');
	$('#mostrar_mapa').fadeOut('slow');
	$('#segundopaso').fadeOut();
	$('#nombreseccion').html('');
	clearInterval(timer);
	$('#ocultar').delay(600).fadeIn('slow');
}

function cancel_local(local, concierto){
	$('.file_checked-'+local).remove();
	$('.inputchk'+local).css('background-color','#fff');
	$('#img_localidad'+local).css('display','none');
	$('.contar_boletos'+local).css('display','none');
	$('.img_over'+local).remove();
	$('#numboletos'+local).html(0);
	$('#descripcionsilla'+local).html('');
	$('#detallesillas'+local).fadeOut();
	$('#botones'+local).fadeOut();
	$('#mostrar_mapa').fadeOut('slow');
	$('#segundopaso').fadeOut();
	$('#nombreseccion').html('');
	clearInterval(timer);
	$('#ocultar').delay(600).fadeIn('slow');
}

function selectlocalale(idlocal){
	$('#choose_local').fadeOut('slow');
	$('#choose_num_bol').delay(600).fadeIn('slow');
	$('#idLocalale').val(idlocal);
}

function select_boletos_ale(){
	var select = $('#num_boletos_ale').val();
	if(select == 'mas'){
		$('#num_boletos_ale').fadeOut('slow');
		$('#mas_bol_num_div').delay(600).fadeIn('slow');
	}
}

function cancelar_mas_num(){
	$('#mas_bol_num_div').fadeOut('slow');
	$('#num_boletos_ale').delay(600).fadeIn('slow');
}

function select_asientos_ale(){
	var con = $('#concierto').val();
	var idlocal = $('#idLocalale').val();
	var numticket = $('#num_boletos_ale').val();
	if(numticket == 'mas'){
		numticket = $('#mas_bol_num').val();
	}
	$('#buscarale').fadeOut('slow');
	$('#waitale').delay(600).fadeIn('slow');
	$.post('distribuidor/eventos/aleatorio.php',{
		con : con, idlocal : idlocal, numticket : numticket
	}).done(function(response){
		$('#waitale').fadeOut();
		var respuesta = response.split('|');
		$('#tabla_aleatorios').html(respuesta[0]);
		$('#asientos_ale').html(respuesta[1]);
		$('#aceptaraleatorios').fadeIn();
	});
}

function cancelar_ale(){
	$('.loc_ale').prop('checked',false);
	$('#choose_local').fadeIn();
	$('#choose_num_bol').fadeOut();
	$('#asientosaleatorio').modal('hide');
	$('#idLocalale').val('');
	$('#tabla_aleatorios').html('');
	$('#asientos_ale').html('');
}