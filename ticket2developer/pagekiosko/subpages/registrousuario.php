<?php 
	$concert = $_GET['con'];
	
	$gbd = new DBConn();
	
	$selectUser = "SELECT * FROM Cliente";
	$resultSelectUser = $gbd -> prepare($selectUser);
	$resultSelectUser -> execute();
	$content = '';
	while ($rowUser = $resultSelectUser -> fetch(PDO::FETCH_ASSOC)){
		$content .= '
		<div class="datosbd">
			<input type="hidden" class="mailbd" value="'.$rowUser['strMailC'].'" />
			<input type="hidden" class="documentobd" value="'.$rowUser['strDocumentoC'].'" />
		</div>';
	}
	echo $content;
	$anio = date('Y');
	$anio = $anio - 10;
?>
<input type="hidden" id="cn" name="cn" value="<?php echo $concert;?>" />
<div style="background-color:#282B2D; margin:10px 20px 0px 20px; text-align:center;">
	<div class="breadcrumb">
		<a id="chooseseat" href="?modulo=des_concierto&con=<?php echo $idcon;?>" onclick="chooseasientos()">Escoge tu asiento</a>
		<a class="active" id="identification" href="#" onclick="identity()">Identificate</a>
		<a id="buy" href="#" onclick="security()">Resumen de Compra</a>
		<a id="pay" href="#" onclick="security()">Pagar</a>
		<a id="confirmation" href="#" onclick="security()">Confirmaci&oacute;n</a>
	</div>
</div>
<form id="form" method="post" action="?modulo=comprar&con=<?php echo $concert;?>" >
	<?php
	if(isset($_POST['codigo'])){
		foreach($_POST['codigo'] as $key=>$cod_loc){
			echo'
			<input type="hidden" id="codigo" name="codigo[]" value="'.$cod_loc.'" />
			<input type="hidden" id="row" name="row[]" value="'.$_POST['row'][$key].'" />
			<input type="hidden" id="col" name="col[]" value="'.$_POST['col'][$key].'" />
			<input type="hidden" id="chair" name="chair[]" value="'.$_POST['chair'][$key].'" />
			<input type="hidden" id="des" name="des[]" value="'.$_POST['des'][$key].'" />
			<input type="hidden" id="num" name="num[]" value="'.$_POST['num'][$key].'" />
			<input type="hidden" id="pre" name="pre[]" value="'.$_POST['pre'][$key].'" />
			<input type="hidden" id="tot" name="tot[]" value="'.$_POST['tot'][$key].'" />
			';
		}
	}
	?>
	<div style="background-color:#171A1B; padding:20px; margin:-10px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; margin:30px 50% 20px 0px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Formulario de Registro</strong>
			</div>
			<div style="background-color:#00ADEF; margin-left:50px;">
				<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; color:#fff; padding-top:20px;">
					<div class="alert alert-success alert-dismissible" id="alerta1" role="alert" style="margin:0 60px 0px 20px; display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
						 Esta Identificación ya existe...!
					</div>
					<div class="alert alert-success alert-dismissible" id="alerta3" role="alert" style="margin:0 60px 0px 20px; display:none;">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
						 Este E-mail ya existe...!
					</div>
					<div class="alert alert-danger" role="alert" id="alerta2" style="margin:0 60px 0px 20px; display:none;">
						<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
						<strong>Error!</strong>... Identificación Incorrecta
					</div>
					<div class="alert alert-danger" role="alert" id="alerta4" style="margin:0 60px 0px 20px; display:none;">
						<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
						<strong>Error!</strong>... Las contraseñas no coinciden.
					</div>
					<div class="alert alert-danger" role="alert" id="alerta5" style="margin:0 60px 0px 20px; display:none;">
						<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
						<strong>Error!</strong>... Campos obligatorios vacios, por favor llenelos.
					</div>
					<div class="alert alert-danger" role="alert" id="alerta6" style="margin:0 60px 0 20px; display:none;">
						<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
						<strong>Error!</strong>... El número de teléfono es incorrecto.
					</div>
					<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Nombres y Apellidos: </h4>
						</div>
						<div class="col-lg-6">
							<input type="text" id="nombre" name="nombre" class="inputlogin form-control" placeholder="Obligatorio" onkeydown="justText(event,this)" autocomplete="off" />
						</div>
					</div>
					<!--<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Documento de Identidad: </h4>
						</div>
						<div class="col-lg-6">
							<input type="radio" name="cop" id="ci" value="cedula" />C&eacute;dula de Identidad(Ecuador)<br>
							<input type="radio" name="cop" id="pasaporte" value="pasaporte" />Pasaporte
						</div>
					</div>-->
					<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Documento de Identidad: </h4>
						</div>
						<div class="col-lg-6">
							<input type="text" id="documento" name="documento" class="inputlogin form-control" placeholder="Obligatorio" onchange="ValidarDocumento()" onkeyup="validarValores(this.value);" autocomplete="off" onkeydown="justInt(event,this);" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-10" style="margin-top:-10px;">
							<span class="label label-info pull-right">Si no cuenta con un "Documento de Identificación" Ecuatoriano porfavor<br> ingrese su número de pasaporte antecedido de la letra "P"</span>
						</div>
					</div>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div style="background-color:#EC1867; margin:0px -42px 0px 30%; padding:10px; font-size:14px; color:#fff; position:relative;">
					El "Documento de Identidad", Servira para validar todas tus compras
					<div class="tra_comprar_concierto"></div>
					<div class="par_comprar_concierto"></div>
				</div>
				<div style="background-color:#00ADEF; margin-left:40px; margin-right:-42px; position:relative; color:#fff;">
					<!--<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Fecha de Nacimiento: </h4>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<div class="col-xs-3">
									<select id="anio" name="anio" class="inputlogin form-control">
										<option value="1">Año</option>
										<?php //for($i = $anio; $i > 1930; $i--){?>
										<option value="<?php //echo $i;?>"><?php //echo $i;?></option>
										<?php //}?>
									</select>
								</div>
								<div class="col-xs-3">
									<select id="mes" name="mes" class="inputlogin form-control">
										<option value="0">Mes</option>
										<option value="01">Enero</option>
										<option value="02">Febrero</option>
										<option value="03">Marzo</option>
										<option value="04">Abril</option>
										<option value="05">Mayo</option>
										<option value="06">Junio</option>
										<option value="07">Julio</option>
										<option value="08">Agosto</option>
										<option value="09">Septiembre</option>
										<option value="10">Octubre</option>
										<option value="11">Noviembre</option>
										<option value="12">Diciembre</option>
									</select>
								</div>
								<div class="col-xs-3">
									<select id="dia" name="dia" class="inputlogin form-control">
										<option value="0">Día</option>
										<?php //for($j = 1; $j <= 31; $j++){?>
										<option value="<?php //echo $j;?>"><?php //echo $j;?></option>
										<?php //}?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Género: </h4>
						</div>
						<div class="col-lg-6">
							<select id="genero" name="genero" class="inputlogin form-control">
								<option value="0">Seleccione...</option>
								<option value="Masculino">Masculino</option>
								<option value="Femenino">Femenino</option>
							</select>
						</div>
					</div>-->
					<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Usuario (E-mail):</h4>
						</div>
						<div class="col-lg-6">
							<input type="text" id="mail" name="mail" class="inputlogin form-control" placeholder="example@dominio.com" onkeyup="validarValores(this.value);" autocomplete="off" />
						</div>
					</div>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div style="background-color:#EC1867; margin:0px -42px 0px 30%; padding:10px; font-size:14px; color:#fff; position:relative;">
					El "E-mail", Servira para que recibas notificaciones de todas tus compras o reservas y para el ingreso a TICKETFACIL.
					<div class="tra_comprar_concierto"></div>
					<div class="par_comprar_concierto"></div>
				</div>
				<div style="background-color:#00ADEF; margin-left:40px; margin-right:-42px; position:relative; color:#fff;">
					<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Contraseña: </h4>
						</div>
						<div class="col-lg-6">
							<input type="password" id="password" name="password" placeholder="Obligatorio" class="inputlogin form-control" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Repita la Contraseña:</h4>
						</div>
						<div class="col-lg-6">
							<input type="password" id="password1" name="password1" placeholder="Obligatorio" class="inputlogin form-control" onchange="validarPassword()" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Teléfono Móvil:</h4>
						</div>
						<div class="col-lg-6">
							<input type="text" id="tmov" name="tmov" onchange="validartelefono(1,this.value)" class="inputlogin form-control" placeholder="0999999999" onkeydown="justInt(event,this);" maxlength="10" autocomplete="off" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Forma de Pago:</h4>
						</div>
						<div class="col-lg-6">
							<select name="pago" id="pago" class="inputlogin form-control">
								<option>Seleccione...</option>
								<option value="1">Tarjeta de Crédito</option>
								<option value="2">Déposito</option>
								<option value="3">Punto de Venta</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Cómo obtener tus Boletos:</h4>
						</div>
						<div class="col-lg-6">
							<select id="obtener_boleto" name="obtener_boleto" class="inputlogin form-control">
								<option value="correo">Correo Electrónico</option>
								<option value="Domicilio">Envio a Domicilio</option>
							</select>
						</div>
					</div>
					<div class="row domicilio" style="display:none;">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Provincia del Domicilio:</h4>
						</div>
						<div class="col-lg-6">
							<select class="inputopcional form-control" id="prov" name="prov">
								<option value="0">Seleccione...</option>
								<option value="1">Azuay</option>
								<option value="2">Bolivar</option>
								<option value="3">Ca&ntilde;ar</option>
								<option value="4">Carchi</option>
								<option value="5">Chimborazo</option>
								<option value="6">Cotopaxi</option>
								<option value="7">El Oro</option>
								<option value="8">Esmeraldas</option>
								<option value="9">Guayas</option>
								<option value="10">Imbabura</option>
								<option value="11">Loja</option>
								<option value="12">Los R&iacute;os</option>
								<option value="13">Manab&iacute;</option>
								<option value="14">Morona Santiago</option>
								<option value="15">Napo</option>
								<option value="16">Orellana</option>
								<option value="17">Paztaza</option>
								<option value="18">Pichincha</option>
								<option value="19">Santa Elena</option>
								<option value="20">Santo Domingo de los Ts&aacute;chilas</option>
								<option value="21">Tungurahua</option>
								<option value="22">Zamora Chinchipe</option>
								<option value="23">Otra...</option>
							</select>
							<div class="input-group" style="display:none;" id="otraprov">
								<input type="text" class="form-control inputopcional" placeholder="Provincia..." id="otraProvincia" name="otraProvincia" aria-describedby="basic-addon1" autocomplete="off" onkeydown="justText(event,this)">
								<span class="input-group-addon" id="basic-addon1" title="Cancelar" onclick="cancelarProvincia()" style="cursor:pointer;">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="row domicilio" style="display:none;">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Ciudad del Domicilio:</h4>
						</div>
						<div class="col-lg-6">
							<select class="inputopcional form-control" id="ciudad" name="ciudad">
								<option value="0">Seleccione...</option>
								<option value="1">Ambato</option>
								<option value="2">Cuenca</option>
								<option value="3">Esmeraldas</option>
								<option value="4">Guaranda</option>
								<option value="5">Guayaquil</option>
								<option value="6">Ibarra</option>
								<option value="7">Latacunga</option>
								<option value="8">Loja</option>
								<option value="9">Machala</option>
								<option value="10">Portoviejo</option>
								<option value="11">Puyo</option>
								<option value="12">Quito</option>
								<option value="13">Santo Domingo</option>
								<option value="14">Riobamba</option>
								<option value="15">Tena</option>
								<option value="16">Tulc&aacute;n</option>
								<option value="17">Otra...</option>
							</select>
							<div class="input-group" style="display:none;" id="otraciu">
								<input type="text" class="form-control inputopcional" placeholder="Ciudad..." id="otraCiudad" name="otraCiudad" aria-describedby="basic-addon1" autocomplete="off" onkeydown="justText(event,this)">
								<span class="input-group-addon" id="basic-addon1" title="Cancelar" onclick="cancelarCiudad()" style="cursor:pointer;">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="row domicilio" style="display:none;">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Dirección:</h4>
						</div>
						<div class="col-lg-6">
							<textarea rows="2" col="10" id="dir" name="dir" class="inputopcional form-control" placeholder="OPCIONAL" autocomplete="off" ></textarea>
						</div>
					</div>
					<div class="row domicilio" style="display:none;">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Teléfono Fijo:</h4>
						</div>
						<div class="col-lg-6">
							<input type="text" id="telfijo" name="telfijo" class="inputopcional form-control" placeholder="022222222/OPCIONAL" onkeydown="justInt(event,this);" maxlength="9" autocomplete="off" onchange="validartelefono(2,this.value)" />
						</div>
					</div>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>	
				</div>
				<div style="background-color:#EC1867; margin-right:-42px; font-size:14px; color:#fff; position:relative;">
					<center><span>Completa tu registro leyendo los <a onclick="$('#terminosdeuso').modal('show');" style="text-decoration:none; cursor:pointer; color:#000;">T&eacute;rminos y Condiciones</a> de TICKETFACIL.</span><br>
					<span>Por cada ticket ingresara la primera persona en presentarlo.</span><br>
					<span>El mail y la informaci&oacute;n de tu ticket es personal e intransferible.</span></center>
					<div class="tra_comprar_concierto"></div>
					<div class="par_comprar_concierto"></div>
				</div>
				<div style="background-color:#00ADEF; margin-left:40px; margin-right:-42px; position:relative;">
					<table class="table-response" style="width:100%; color:#000; font-size:20px; border-collapse: separate; border-spacing: 20px 15px;">
						<tr>
							<td>
								<center><label for="check"><input type="checkbox" name="check" id="check" onchange="mostrar()" />&nbsp;&nbsp;&nbsp;&nbsp;<strong>ACEPTO LOS T&Eacute;RMINOS Y CONDICIONES</strong></label></center>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<center><img src="imagenes/loading.gif" style="max-width:70px; display:none;" id="wait" /><a class="btn_login" id="aceptar" name="aceptar" onclick="aceptar()" style="text-decoration:none; display:none; cursor:pointer;"><span>REGISTRARME</span></a></center>
							</td>
						</tr>
					</table>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="terminosdeuso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Terminos de Uso</h4>
					</div>
					<div class="modal-body" style="text-align:center;">
						<h3>TERMINOS DE USO DE TICKETFACIL</h3>
						<p style="text-align:justify;">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus velit nulla, rutrum sit amet aliquet et, blandit ac odio. 
							Maecenas vitae nibh non nisl mollis vestibulum at a dui. Nullam congue ultrices arcu eget convallis. Morbi erat ipsum, fringilla 
							in ultricies mollis, commodo sed neque. Maecenas semper nibh vitae risus suscipit convallis. Etiam non felis imperdiet lorem 
							consectetur feugiat ut ut quam. Praesent et nibh eleifend diam tincidunt eleifend. Quisque euismod, erat et vestibulum blandit, 
							risus diam rhoncus augue, a finibus erat ex a enim. Phasellus convallis est libero, vel blandit dui iaculis eu. Sed eu nisi arcu.
						</p>
						<p style="text-align:justify;">
							Curabitur id orci nec metus facilisis placerat. Sed ornare, lacus malesuada rhoncus malesuada, diam tellus tristique justo, et 
							gravida nisi elit vel mauris. Cras convallis dignissim eros, vitae pellentesque orci aliquam vel. Aenean condimentum mi in 
							lectus dignissim tristique a et orci. In eget aliquet diam, nec mattis sem. Proin eget nibh semper, aliquet felis ut, tempus nibh. 
							Aenean viverra aliquam tellus, at dapibus dui. Suspendisse et enim efficitur, placerat sapien vitae, hendrerit nulla. Donec 
							sed ex ligula. Pellentesque consequat mattis euismod. Integer accumsan sapien massa, ut ullamcorper lorem imperdiet vitae. 
							Integer ut porttitor justo.
						</p>
						<p style="text-align:justify;">
							Curabitur urna velit, gravida sed sapien mollis, elementum porttitor enim. In lobortis dignissim sem laoreet pulvinar. Quisque 
							mi nisi, semper eu varius vel, aliquet a sapien. In aliquet nunc ac tortor dictum varius. Fusce tempus dui nisi, non luctus 
							augue sollicitudin ut. Duis ornare massa quis mauris hendrerit, eu volutpat libero placerat. Praesent tristique nisl vulputate 
							viverra imperdiet.
						</p>
						<p style="text-align:justify;">
							Aenean facilisis tincidunt lacus, molestie lacinia nisl eleifend vel. Pellentesque urna est, interdum sit amet velit sit amet,
							maximus viverra enim. Praesent tempus lacus quis semper malesuada. Fusce finibus et quam vitae vehicula. Vivamus eu 
							felis purus. Suspendisse elit dui, imperdiet sed nibh vel, tincidunt sodales lacus. Sed pharetra ante magna, ut pulvinar nibh 
							finibus ut. Sed gravida dolor condimentum purus faucibus, eget rhoncus leo tristique. Nam blandit auctor diam quis porta. Ut
							malesuada nisl eros, quis elementum elit placerat nec. Proin varius, metus in semper ullamcorper, risus urna posuere felis, 
							vel scelerisque mi urna vel velit. Phasellus leo felis, venenatis in lacus a, vestibulum vulputate elit. Morbi nec felis enim.
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
$(document).ready(function(){
	$('#obtener_boleto').on('change',function(){
		var envio = $('#obtener_boleto').val();
		if(envio == 'Domicilio'){
			$('.domicilio').fadeIn('slow');
			$('#prov').removeClass('inputopcional');
			$('#prov').prop('placeholder','Obligatorio');
			$('#prov').addClass('inputlogin');
			$('#otraProvincia').removeClass('inputopcional');
			$('#otraProvincia').prop('placeholder','Obligatorio');
			$('#otraProvincia').addClass('inputlogin');
			$('#ciudad').removeClass('inputopcional');
			$('#ciudad').prop('placeholder','Obligatorio');
			$('#ciudad').addClass('inputlogin');
			$('#otraCiudad').removeClass('inputopcional');
			$('#otraCiudad').prop('placeholder','Obligatorio');
			$('#otraCiudad').addClass('inputlogin');
			$('#dir').removeClass('inputopcional');
			$('#dir').prop('placeholder','Obligatorio');
			$('#dir').addClass('inputlogin');
			$('#telfijo').removeClass('inputopcional');
			$('#telfijo').prop('placeholder','Obligatorio');
			$('#telfijo').addClass('inputlogin');
		}else{
			$('.domicilio').fadeOut();
			$('#prov').removeClass('inputlogin');
			$('#prov').prop('placeholder','Opcional');
			$('#prov').addClass('inputopcional');
			$('#otraProvincia').removeClass('inputlogin');
			$('#otraProvincia').prop('placeholder','Opcional');
			$('#otraProvincia').addClass('inputopcional');
			$('#ciudad').removeClass('inputlogin');
			$('#ciudad').prop('placeholder','Opcional');
			$('#ciudad').addClass('inputopcional');
			$('#otraCiudad').removeClass('inputlogin');
			$('#otraCiudad').prop('placeholder','Opcional');
			$('#otraCiudad').addClass('inputopcional');
			$('#dir').removeClass('inputlogin');
			$('#dir').prop('placeholder','Opcional');
			$('#dir').addClass('inputopcional');
			$('#telfijo').removeClass('inputlogin');
			$('#telfijo').prop('placeholder','Opcional');
			$('#telfijo').addClass('inputopcional');
		}
	});
	
	$('#mail_ok').each(function(){
		var mail_exist = $(this).find('.mail').val();
		var mail_new = $('#mail').val();
		if(mail_new == mail_exist){
			alert('Este correo electronico ya existe');
			$('#mail').val('');
			$('#mail').focus();
		}
	});
});

function chooseasientos(){
	alert('Deberas escoger nuevamente tus asientos');
}

function identity(){
	alert('Estas creando tu cuenta');
}

function security(){
	alert('Debes primero crear tu cuenta');
}

function ValidarDocumento(){
	var valor = $('#documento').val();
	if(valor[0] == 'p'||valor[0] == 'P'){
		pasaporte();
	}else{
		ValidarCedula();
	}
}

$('#ciudad').on('change',function (){
	var otraCiudad = $('#ciudad').val();
	if(otraCiudad == 17){
		$('#ciudad').fadeOut('slow');
		$('#otraciu').delay(600).fadeIn('slow');
	}else{
		$('#otraciu').fadeOut('slow');
		$('#ciudad').delay(600).fadeIn('slow');
	}
});

$('#prov').on('change',function (){
	var otraCiudad = $('#prov').val();
	if(otraCiudad == 23){
		$('#prov').fadeOut('slow');
		$('#otraprov').delay(600).fadeIn('slow');
	}else{
		$('#otraprov').fadeOut('slow');
		$('#prov').delay(600).fadeIn('slow');
	}
});

function cancelarProvincia(){
	$('#prov').val(0);
	$('#otraprov').fadeOut('slow');
	$('#prov').delay(600).fadeIn('slow');
	$('#otraProvincia').val('');
}

function cancelarCiudad(){
	$('#ciudad').val(0);
	$('#otraciu').fadeOut('slow');
	$('#ciudad').delay(600).fadeIn('slow');
	$('#otraCiudad').val('');
}

function pasaporte(){
	var valor = $('#documento').val();
	if(valor.length<3||valor.length>13){
		console.log('Pasaporte incorrecto');
		$('#documento').val('');
		$('#alerta2').fadeIn('slow');
		$('#alerta2').delay(2500).fadeOut('slow');
		return false;
	}else{
		if(valor[0]=='p'||valor[0]=='P'){
			return true;
		}else{
			console.log('Pasaporte incorrecto');
			$('#documento').val('');
			$('#alerta2').fadeIn('slow');
			$('#alerta2').delay(2500).fadeOut('slow');
			return false;
		}
	}
}

function ValidarCedula(){
	var numero = $('#documento').val();
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
	$('#documento').val('');
	$('#alerta2').fadeIn('slow');
	$('#alerta2').delay(1500).fadeOut('slow');
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
	$('#documento').val('');
	$('#alerta2').fadeIn('slow');
	$('#alerta2').delay(1500).fadeOut('slow');
	return false;
	}
	/* El ruc de las empresas del sector publico terminan con 0001*/
	if ( numero.substr(9,4) != '0001' ){
	console.log('El ruc de la empresa del sector público debe terminar con 0001');
	$('#documento').val('');
	$('#alerta2').fadeIn('slow');
	$('#alerta2').delay(1500).fadeOut('slow');
	return false;
	}
	}
	else if(pri == true){
	if (digitoVerificador != d10){
	console.log('El ruc de la empresa del sector privado es incorrecto.');
	$('#documento').val('');
	$('#alerta2').fadeIn('slow');
	$('#alerta2').delay(1500).fadeOut('slow');
	return false;
	}
	if ( numero.substr(10,3) != '001' ){
	console.log('El ruc de la empresa del sector privado debe terminar con 001');
	$('#documento').val('');
	$('#alerta2').fadeIn('slow');
	$('#alerta2').delay(1500).fadeOut('slow');
	return false;
	}
	}

	else if(nat == true){
	if (digitoVerificador != d10){
	console.log('El número de cédula de la persona natural es incorrecto.');
	$('#documento').val('');
	$('#alerta2').fadeIn('slow');
	$('#alerta2').delay(1500).fadeOut('slow');
	return false;
	}
	if (numero.length >10 && numero.substr(10,3) != '001' ){
	console.log('El ruc de la persona natural debe terminar con 001');
	$('#documento').val('');
	$('#alerta2').fadeIn('slow');
	$('#alerta2').delay(1500).fadeOut('slow');
	return false;
	}
	}
	return true;
}

$('#pasaporte').on('click',function(){
	$('#pass').css('display','block');
	$('#cedi').css('display','none');
	$('#ced').css('display','none');
});

function mostrar(){
	if($('#check').is(':checked')){
		$('#aceptar').fadeIn();
	}else{
		$('#aceptar').fadeOut();
	}
}

function justInt(e,value){
	if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46 || e.keyCode == 80 || e.keyCode == 112)){
		return;
	}
	else{
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

// function soloLetras(e) {
	// key = e.keyCode || e.which;
	// tecla = String.fromCharCode(key).toLowerCase();
	// letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
	// especiales = [8, 37, 39, 46];

	// tecla_especial = false
	// for(var i in especiales) {
		// if(key == especiales[i]) {
			// tecla_especial = true;
			// break;
		// }
	// }

	// if(letras.indexOf(tecla) == -1 && !tecla_especial){
		// return false;
	// }	
// }
		
function validartelefono(id,valor){
	var largo = valor.length;
	if(id == 1){
		if((largo < 10) || (valor == '')){
			$('#alerta6').fadeIn();
			$('#alerta6').delay(2500).fadeOut();
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			$('#tmov').val('');
			return false;
		}
	}else if(id == 2){
		if((largo < 9) || (valor == '')){
			$('#alerta6').fadeIn();
			$('#alerta6').delay(2500).fadeOut();
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			$('#telfijo').val('');
			return false;
		}
	}
}

function validarValores(valor){
	if(!$('#alerta1').is(':hidden')){
		$('#alerta1').fadeOut();
	}else if(!$('#alerta3').is(':hidden')){
		$('#alerta3').fadeOut();
	}
	$('.datosbd').each(function(){
		var documento = $(this).find('.documentobd').val();
		if(valor == documento){
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			$('#alerta1').fadeIn();
			$('#documento').val('');
			return false;
		}
		var mail = $(this).find('.mailbd').val();
		if(valor == mail){
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			$('#alerta3').fadeIn();
			$('#mail').val('');
			return false;
		}
	});
}

function validarPassword(){
	var pass1 = $('#password').val();
	var pass2 = $('#password1').val();
	if(pass2 != pass1){
		$('html, body').animate({ scrollTop: 0 }, 'slow');
		$('#alerta4').fadeIn();
		$('#password').val('');
		$('#password1').val('');
		setTimeout("$('#alerta4').fadeOut();",3000);
		return false;
	}
}

function aceptar(){
	var nombre = $('#nombre').val();
	var documento = $('#documento').val();
	var genero = $('#genero').val();
	var mail = $('#mail').val();
	var pass1 = $('#password').val();
	var pass2 = $('#password1').val();
	var tmov = $('#tmov').val();
	var pago = $('#pago').val();
	var obtener_boleto = $('#obtener_boleto').val();
	var prov = $('#prov').val();
	if(prov == 23){
		prov = $('#otraProvincia').val();
	}
	var ciudad = $('#ciudad').val();
	if(ciudad == 17){
		ciudad = $('#otraCiudad').val();
	}
	var dir = $('#dir').val();
	var telfijo = $('#telfijo').val();
	
	if(obtener_boleto == 'Domicilio'){
		if((nombre == '') || (documento == '') || (mail == '') || (pass1 == '') || (pass2 == '') || (tmov == '') || (pago == 0) || (obtener_boleto == 0)){
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			$('#alerta5').fadeIn();
			setTimeout("$('#alerta5').fadeOut();",3000);
		}else{
			$('#aceptar').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$('#form').submit();
		}
	}else{
		if((nombre == '') || (documento == '') || (mail == '') || (pass1 == '') || (pass2 == '') || (tmov == '') || (pago == 0) || (obtener_boleto == 0)){
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			$('#alerta5').fadeIn();
			setTimeout("$('#alerta5').fadeOut();",3000);
		}else{
			$('#aceptar').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$('#form').submit();
		}
	}
}
</script>