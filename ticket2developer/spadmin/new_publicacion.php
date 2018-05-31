<?php 
	// include("controlusuarios/seguridadSA.php");
	require('Conexion/conexion.php');
	$perfil = 'Socio';
	$selectClientes = "SELECT idUsuario, strNombreU FROM Usuario WHERE strPerfil = '$perfil'" or die(mysqli_error());
	$resSelectClientes = $mysqli->query($selectClientes);
	echo '<input type="hidden" id="data" value="11" />';
	$current_time = date ("Y-m-d");
?>
<style>
	.fecha{
		color:#000;
	}
	.artistas{
		border:1px solid #fff; 
		margin:0;
		text-align:center;
	}
	.detalleart{
		border:1px solid #fff; 
		margin:0;
	}
input[type="text"] , select , textarea {
		width:100%;
	}
	
	
	input[type="radio"]{ display: none; }

label{
  color:#fff;
  font-family: Arial;
  font-size: 14px;
}



input[type="radio"] + label span{
  display: inline-block;
  width: 19px;
  height: 19px;
  background: url(http://ticketfacil.ec/ticket2/spadmin/img/check_radio_sheet.png) -38px top no-repeat;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor:pointer;
}

input[type="radio"]:checked + label span{
  background: url(http://ticketfacil.ec/ticket2/spadmin/img/check_radio_sheet.png) -57px top no-repeat;
}
</style>
<script src="spadmin/ajaxupload.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/>
<script src="js/jquery.datetimepicker.js"></script>
<script language="javascript" src="spadmin/jquery.canvasAreaDraw.js"></script>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 500px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
				<strong>Datos Generales del Concierto</strong>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:22px;">
				<strong>Paso #1</strong>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Empresario(Dueño del evento): </strong></h4>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<select id="user" class="inputlogin form-control">
						<option value="0">Seleccione...</option>
						<?php while($rowSelectClientes = mysqli_fetch_array($resSelectClientes)){?>
						<option value="<?php echo $rowSelectClientes['idUsuario'];?>"><?php echo $rowSelectClientes['strNombreU'];?></option>
						<?php }?>
					</select>
				</div>
			</div>
			
			
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Nombre del Evento:</strong></h4>
					<input type="text" class="inputlogin form-control" id="evento" />
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Lugar del Evento:</strong></h4>
					<input type="text" class="inputlogin form-control" id="lugar" />
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Imagen del Evento:</strong></h4>
					<div class="input-group">
						<input class="inputDescripciones inputlogin form-control" placeholder="Nombre de la Imagen" type="text" id="imagen" readonly="readonly" aria-describedby="basic-addon2" style="color:#000;">
						<span class="input-group-addon" id="basic-addon2">
							<div style="" id="upload">
								<img src="spadmin/examina.png"  style="border:0; margin:-2px;" alt="">
							</div>
						</span>
					</div>
					<div style="position:relative; display:none;" id="btnborrarimg">
						<img id="foto" style="width:100%;" />
						<div style="position:absolute; top:0px; right:0;">
							<button type="button" class="btn btn-success" onclick="borrarimg()" title="Eliminar">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
						</div>
						<div class="imgeliminadas">
							
						</div>
					</div>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Descripción del Evento</strong></h4>
					<textarea rows="5" cols="30" id="des" class="inputlogin form-control" placeholder="Motivos de Creación"></textarea>
				</div>
			</div>
			
			
			
			
			
			<div class="row">
				<div class="col-lg-1"></div>
				<div class="col-lg-10">
					<h4 style="color:#fff;"><strong>Video Promocional:</strong></h4>
					<div class="input-group">
						<input type="text" id="video" placeholder="Link de YOUTUBE" class="inputlogin form-control" aria-describedby="basic-addon2" >
						<span class="input-group-addon" id="basic-addon2" onclick="$('#tuto').modal('show');" style="cursor:pointer;" title="Tutorial">
							Tutorial
						</span>
					</div>
				</div>
				<div class="col-lg-1"></div>
				
			</div>
			
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Fecha del Evento:</strong></h4>
					<input type="text" readonly="readonly" class="fecha inputlogin form-control" id="f_evento" placeholder="AAAA-MM-DD" min="<?php echo $current_time;?>" />
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Hora del Evento:</strong></h4>
					<input type="text" id="hora" class="hora inputlogin form-control" placeholder="00:00" />
					
					
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Género del Evento:</strong></h4>
					<select id="caracteristica" class="inputlogin form-control" onchange="chooseGenero()">
						<option value="0">Seleccione...</option>
						<option value="Alternativo">Alternativo</option>
						<option value="Bachata">Bachata</option>
						<option value="Balada">Balada</option>
						<option value="Bolero">Bolero</option>
						<option value="Chicha">Chicha</option>
						<option value="Clasica">Cl&aacute;sica-Instrumental</option>
						<option value="Country">Country</option>
						<option value="Cristiana">Cristiana</option>
						<option value="Cumbia">Cumbia</option>
						<option value="Electronica">Electr&oacute;nica</option>
						<option value="Flamenco">Flamenco</option>
						<option value="Folk">Folk</option>
						<option value="Gospel">Gospel</option>
						<option value="Gothic">Gothic</option>
						<option value="HipHop">HIP-HOP</option>
						<option value="Instrumental">Instrumental</option>
						<option value="Jazz">Jazz</option>
						<option value="Lambadas">Lambadas</option>
						<option value="Merengue">Merengue</option>
						<option value="Metal">Metal</option>
						<option value="Pop">Pop</option>
						<option value="Punk">Punk</option>
						<option value="Ranchera">Ranchera</option>
						<option value="Rap">Rap</option>
						<option value="Reggae">Reggae</option>
						<option value="Regaeton">Regaeton</option>
						<option value="Rock">Rock</option>
						<option value="Salsa">Salsa</option>
						<option value="Samba">Samba</option>
						<option value="Tango">Tango</option>
						<option value="Tecno">Tecno</option>
						<option value="Vallenatos">Vallenatos</option>
						<option value="1">Otro...</option>
					</select>
					<div class="input-group" id="otrogen" style="display:none;">
						<input type="text" class="inputlogin form-control" id="otrogenero" placeholder="Escribe el género..." aria-describedby="basic-addon2">
						<span class="input-group-addon" id="basic-addon2" onclick="cancelargenero()" style="cursor:pointer;" title="Cancelar">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</span>
					</div>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Número de Artistas: </strong></h4>
					<select id="num_artistas" class="inputlogin form-control" onchange="cantidadArtistas()">
						<option value="0">Seleccione...</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">Más...</option>
					</select>
					<div class="input-group" id="numeroart" style="display:none;">
						<input type="text" class="inputlogin form-control" id="masartistas" placeholder="Número de Artistas..." maxlength="2" onkeyup="masartistas()" aria-describedby="basic-addon2">
						<span class="input-group-addon" id="basic-addon2" onclick="cancelarmasartistas()" style="cursor:pointer;" title="Cancelar">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</span>
					</div>
				</div>
			</div>
			<div id="numartistas" style="color:#fff; padding-left:55px;">
				
			</div>

			<div class="row">
				<div class="col-lg-1"></div>
				<div class="col-lg-10">
					<h4 style="color:#fff;"><strong>Link para la venta de boletos</strong></h4>
					<input type="text" class="inputlogin form-control" id="link_compra" placeholder="www.google.com" />
				</div>
				<div class="col-lg-1"></div>
				
			</div>
			
			
			<div class="row" style="padding:20px 0px;">
				<center><strong><input type="submit" class="btndegradate" value="GUARDAR" onclick="guardar()" /></strong></center>
			</div>
		</div>
		
		<input type="hidden" id="ultcon" value="" />
	</div>
</div>
<script>
	
$(document).ready(function(){
	$( "#autSri" ).change(function() {
		calculaCantidad();
		var autSri = $( "#autSri option:selected" ).attr('secuencialfinalA');
		$('#numeroDeBoletosAutorizados').val(autSri);
		$('#txtBolAut').html('Atención ud podra crear un total de : <span id="cantidadAutorizados">'+autSri +'</span>  boletos. Por favor no exceda esta cantidad!!!');
	});
	
	
	
	$('.fecha').datetimepicker({
		timepicker: false,
		minDate:0,
		mask:true,
		format:'Y/m/d'
	});
	$('.hora').datetimepicker({
		datepicker:false,
		mask: true,
		format:'H:i'
	});
});


	function calculaCantidad(id){
		var txtBolAut = $( "#autSri option:selected" ).attr('secuencialfinalA');
		var identificador = $( "#autSri" ).val();
		console.log('el identificador de los permisos es : ' + identificador);
		if(identificador == 0){
			
		}else{
			var elementos = $('.tabla_localidad');
			var size = elementos.size();
			//alert(size);
			var sumaBol = 0;
			for (var i=1; i<=size; i++) {
				var cantidad = parseInt($('#cantidad'+i).val());
				//alert(cantidad +' <<  >>'+ i)
				if(cantidad == 0){
					sumaBol = 0;
				}else{
					sumaBol += cantidad;
				}
			}
			//alert(sumaBol);
			$('#numeroDeBoletosConfigurados').val(sumaBol);
			//alert(txtBolAut+'<<>>'+sumaBol);
			var resBoletos = (parseInt(txtBolAut)-parseInt(sumaBol));
			if(sumaBol>txtBolAut){
				
				$('#txtBolAutVendidos').html('<span style="color:red;">Ud a configurado un total de ' + sumaBol + ' boletos , no puede pasarse de esta cantidad</span>');
			}else{
				$('#txtBolAutVendidos').html('<span style="color:#fff;">Ud a configurado : ' + sumaBol + ' boletos le quedan : ' + resBoletos + ' boletos por configurar .</span>' );
			}
		}
		
	}
	function soloNumeros(){
		this.value = this.value.replace (/[^0-9]/, '');
	}
	
var contador = 2;
$('#nuevo').on('click', function(){
$('#localidad').append('<tr class="tabla_localidad" style="padding-top:10px;padding-bottom:10px;">\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="loc'+contador+'" class="loc inputlogin form-control" placeholder="VIP,Palco,General,etc" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="precio'+contador+'" class="precio inputlogin form-control" placeholder="000.00" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="reservacion'+contador+'" class="reservacion inputlogin form-control" placeholder="sin %" onkeyup="calcular_reserva('+contador+')" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;padding-top: 10px;padding-bottom: 10px">\
								<input type="text" id="p_reserva'+contador+'" class="p_reserva inputlogin form-control" readonly="readonly" placeholder="0.00" style="color:#000;" />\
								<input type="text" id="p_reserva_s'+contador+'" class="inputlogin form-control" readonly="readonly" placeholder="0.00" style="color:#000;" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="p_venta'+contador+'" class="p_venta inputlogin form-control" placeholder="sin %" onkeyup="calcular_preventa('+contador+')" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="p_preventa'+contador+'" class="p_preventa inputlogin form-control" readonly="readonly" placeholder="0.00" style="color:#000;" />\
								<input type="text" id="p_preventa_s'+contador+'" readonly="readonly" placeholder="0.00" style="color:#000;" class="inputlogin form-control" /> \
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="cantidad'+contador+'" class="cantidad inputlogin form-control" onblur="calculaCantidad()" onkeyup="this.value = this.value.replace (/[^0-9]/, \'\'); " value="0"/>\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="siglas'+contador+'" class="siglas inputlogin form-control" placeholder="Iniciales" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<select id="char'+contador+'" class="char inputlogin form-control" onchange="ocultar('+contador+')">\
									<option value="Asientos numerados">Asientos Numerados</option>\
									<option value="Asientos sin numerar">Asientos sin numerar</option>\
								</select>\
							</td>\
						</tr>');
contador += 1;
});

function calcular_reserva(id){
	var precio = $('#precio'+id).val();
	var porcentaje = $('#reservacion'+id).val();
	var calculo = ((precio * porcentaje) / 100);
	var c = calculo.toFixed(2);
	$('#p_reserva_s'+id).val(c);
	calculo = (Math.ceil(calculo)).toFixed(2);
	$('#p_reserva'+id).val(calculo);
}

function calcular_preventa(id){
	var pre = $('#precio'+id).val();
	var porciento = $('#p_venta'+id).val();
	var total = ((pre * porciento) / 100);
	var c = total.toFixed(2);
	$('#p_preventa_s'+id).val(c);
	total = (Math.ceil(total)).toFixed(2);
	$('#p_preventa'+id).val(total);
}

function cantidadArtistas(){
	var numart = $('#num_artistas').val();
	if(numart == 11){
		$('#num_artistas').fadeOut('slow');
		$('#numeroart').delay(600).fadeIn('slow');
		return false;
	}
	var cant = $('#num_artistas').val();
	if(cant == 0){
		$('.tabla_artistas').remove();
		$('.titulosartistas').remove();
	}else{
		$('.tabla_artistas').remove();
		$('.titulosartistas').remove();
		var content = '';
		content = '<div class="row titulosartistas" style="text-align:center;"><div class="col-lg-11">\
						<h3>Detalle de Artistas</h3>\
					</div></div>\
					<div class="row titulosartistas">\
						<div class="col-xs-3 artistas">\
							<span><strong>Nombre del Artista</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Facebook</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Twitter</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Youtube</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Instagram</strong></span>\
						</div>\
					</div>';
		for(var i = 0; i < cant; i++){
			content += '<div class="row tabla_artistas">\
						<div class="col-xs-3 detalleart">\
							<input type="text" class="nombre_art inputlogin form-control" placeholder="Nombre Artistico" />\
						</div>\
						<div class="col-xs-2 detalleart">\
							<input type="text" class="facebook inputlogin form-control" placeholder="www.facebook.com/nombre_artistas" />\
						</div>\
						<div class="col-xs-2 detalleart">\
							<input type="text" class="twitter inputlogin form-control" placeholder="www.twitter.com/nombre_artista" />\
						</div>\
						<div class="col-xs-2 detalleart">\
							<input type="text" class="youtube inputlogin form-control" placeholder="www.youtube.com/user/nombre_artista" />\
						</div>\
						<div class="col-xs-2 detalleart">\
							<input type="text" class="instagram inputlogin form-control" placeholder="www.instagram.com/nombre_artista" />\
						</div>\
					</div>';
		}
		$('#numartistas').append(content);
	}
}

function masartistas(){
	var valor = $('#masartistas').val();
	if(valor == 0){
		$('.tabla_artistas').remove();
		$('.titulosartistas').remove();
	}else{
		$('.tabla_artistas').remove();
		$('.titulosartistas').remove();
		var content = '';
		content = '<div class="row titulosartistas" style="text-align:center;"><div class="col-lg-11">\
						<h3>Detalle de Artistas</h3>\
					</div></div>\
					<div class="row titulosartistas">\
						<div class="col-xs-3 artistas">\
							<span><strong>Nombre del Artista</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Facebook</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Twitter</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Youtube</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Instagram</strong></span>\
						</div>\
					</div>';
		for(var j = 0; j < valor; j++){
			content += '<div class="row tabla_artistas">\
							<div class="col-xs-3 detalleart">\
								<input type="text" class="nombre_art inputlogin form-control" placeholder="Nombre Artistico" />\
							</div>\
							<div class="col-xs-2 detalleart">\
								<input type="text" class="facebook inputlogin form-control" placeholder="www.facebook.com/nombre_artistas" />\
							</div>\
							<div class="col-xs-2 detalleart">\
								<input type="text" class="twitter inputlogin form-control" placeholder="www.twitter.com/nombre_artista" />\
							</div>\
							<div class="col-xs-2 detalleart">\
								<input type="text" class="youtube inputlogin form-control" placeholder="www.youtube.com/user/nombre_artista" />\
							</div>\
							<div class="col-xs-2 detalleart">\
								<input type="text" class="instagram inputlogin form-control" placeholder="www.instagram.com/nombre_artista" />\
							</div>\
						</div>';
		}
		$('#numartistas').append(content);
	}
}

function cancelarmasartistas(){
	$('#numeroart').fadeOut('slow');
	$('#num_artistas').delay(600).fadeIn('slow');
	$('#masartistas').val('');
	$('#num_artistas').val(0);
	$('.tabla_artistas').remove();
	$('.titulosartistas').remove();
}

function chooseGenero(){
	var genero = $('#caracteristica').val();
	if(genero == 1){
		$('#caracteristica').fadeOut('slow');
		$('#otrogen').delay(600).fadeIn('slow');
	}
}

function cancelargenero(){
	$('#otrogen').fadeOut('slow');
	$('#caracteristica').delay(600).fadeIn('slow');
	$('#otrogenero').val('');
	$('#caracteristica').val(0);
}

function choosetiempolimete(){
	var tiempo = $('#tiempolimete').val();
	if(tiempo == 1){
		$('#tiempolimete').fadeOut('slow');
		$('#otrotiempo').delay(600).fadeIn('slow');
	}
}

function cancelarotro(){
	$('#otrotiempo').fadeOut('slow');
	$('#tiempolimete').delay(600).fadeIn('slow');
	$('#otrotiempolimite').val('');
	$('#tiempolimete').val(0);
}

function guardar(){
	
	var id_socio = $('#user').val();
	var evento = $('#evento').val();
	var lugar = $('#lugar').val();
	var imagen = $('#imagen').val();
	var des = $('#des').val();
	var video = $('#video').val();
	var f_evento = $('#f_evento').val();
	var hora = $('#hora').val();
	var caracteristica = $('#caracteristica').val();
	var num_artistas = $('#num_artistas').val();
	var valores_artista = '';
	$('.tabla_artistas').each(function(){
		var nombre_artista = $(this).find('.nombre_art').val();
		var face_artista = $(this).find('.facebook').val();
		var twitter_artista = $(this).find('.twitter').val();
		var youtube_artista = $(this).find('.youtube').val();
		var instagram_artista = $(this).find('.instagram').val();
		valores_artista += nombre_artista +'|'+ face_artista +'|'+ twitter_artista +'|'+ youtube_artista +'|'+ instagram_artista +'|'+'@';
	});
	var valores_artista = valores_artista.substring(0,valores_artista.length -1);
	var link_compra = $('#link_compra').val();
	
	
	if(id_socio == 0 || evento == '' || lugar == '' || imagen == '' || des == '' || video == '' || f_evento == '' || hora == '' || caracteristica == '' || num_artistas == '' || link_compra == ''){
		$('#alerta1').fadeIn();
		$('#aviso').modal('show');
	}else{
		$.post('spadmin/insert_publicacion.php',{
			id_socio : id_socio , evento : evento , lugar : lugar , imagen : imagen , des : des , video : video , f_evento : f_evento , hora : hora ,
			caracteristica : caracteristica , num_artistas : num_artistas , link_compra : link_compra , valores_artista : valores_artista
		}).done(function(data){
			$('#alerta2').fadeIn();
			$('#aviso').modal('show');  
			$('#ultcon').val(data);
		});
	}
}

$(function(){
	var btnUpload=$('#upload');
	new AjaxUpload(btnUpload, {
		action: 'spadmin/procesa3.php',
		name: 'uploadfile',
		onSubmit: function(file, ext){
			 if (! (ext && /^(jpg|png|gif|bmp)$/.test(ext))){
				alert('Solo imagenes JPG,GIF,PNG,BMP.');
				return false;
			}
		},
		onComplete: function(file, response){
			var mirsp = response;
			//reload ();
			document.getElementById('imagen').value=mirsp;
			document.getElementById('foto').src='spadmin/'+mirsp;
			$('#btnborrarimg').fadeIn();
		}
	});
});
;




function borrarimg(){
	$('#btnborrarimg').fadeOut();
	var imgname = $('#imagen').val();
	$('.imgeliminadas').append('<input type="hidden" class="eliminadas" value="'+imgname+'" />');
	$('#foto').prop('src','');
	$('#imagen').val('');
}

function borrarimgmapa(){
	$('#btnborrarimgmapa').fadeOut();
	var imgname = $('#imagenmapa').val();
	$('.imgeliminadasmapa').append('<input type="hidden" class="eliminadasmapa" value="'+imgname+'" />');
	$('#mapa_completo').prop('src','');
	$('#imagenmapa').val('');
}

function aceptarModal(){
	var con = $('#ultcon').val();
	if($('#alerta2').is(':visible')){
		window.location = '';
	}
	$('.alertas').fadeOut();
	$('#aviso').modal('hide');
}
</script>