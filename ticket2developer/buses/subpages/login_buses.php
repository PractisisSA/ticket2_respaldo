<?php
	session_start();
	if($_SESSION['autentica'] == 'uzx153'){
		echo "<script>alert('Cierra sesion para acceder a otra cuenta'); window.location.href='?page=start';</script>";
	}
	echo '<input type="hidden" id="data" value="1" />';
	$anio = date('Y');
	$anio = $anio - 10;
?>
<div style="margin:10px -10px;">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#00ADEF; color:#fff; margin:20px 60% 0px 0px; padding-left:30px; font-size:22px;">
				<strong>Login</strong>
			</div>
			<div style="background-color:#EC1867; color:#fff; text-align:center; margin:5px -42px 0px 50%; font-size:18px; position:relative; padding:5px 20px;">
				Ingresa tu <strong>Usuario</strong> y <strong>Contraseña</strong>
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
			<div style="background-color:#00ADEF; margin: 30px -42px 10px 40px; position:relative; padding:20px 100px 10px 0; color:#fff;">
				<div class="row perfiles" style="display:none;">
					<div class="col-lg-12">
						<h4 style="color:#fff; font-size:30px; margin:10px 0 20px; padding:5px 0 10px 70px; text-align:center;"><strong>Personal TICKETFACIL</strong></h4>
					</div>
				</div>
				<div class="row cliente" style="display:none;">
					<div class="col-lg-12">
						<h4 style="color:#fff; font-size:30px; margin:10px 0 20px; padding:5px 0 10px 70px; text-align:center;"><strong>Cliente</strong></h4>
					</div>
				</div>
				<div class="row cliente" style="text-align:center; display:none;">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<h4><strong>Usuario (e-mail):</strong></h4>
						<input type="text" class="inputlogin form-control" placeholder="example@dominio.com" id="usercli" autocomplete="off"/>
					</div>
				</div>
				<div class="row cliente" style="text-align:center; display:none;">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<h4><strong>Contrase&ntilde;a:</strong></h4>
						<input type="password" class="inputlogin form-control" placeholder="************" id="passcli" autocomplete="off"/>
					</div>
				</div>
				<div class="row perfiles" style="text-align:center; display:none;">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<h4><strong>Usuario (e-mail):</strong></h4>
						<input type="text" class="inputlogin form-control" placeholder="example@dominio.com" id="user" autocomplete="off" />
					</div>
				</div>
				<div class="row perfiles" style="text-align:center; display:none;">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<h4><strong>Contrase&ntilde;a:</strong></h4>
						<input type="password" class="inputlogin form-control" placeholder="************" id="pass" autocomplete="off" />
						<h4 style="cursor:pointer;" onclick="recuperarcontrasena2()"><I>Recuperar Contraseña</I></h4>
					</div>
				</div>
				<div class="row" style="text-align:center;">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<h4 class="nomostrar"><strong>P&eacute;rfil:</strong></h4>
						<select id="perfil" class="inputlogin nomostrar form-control">
							<option value="0">Seleccione...</option>
							<option value="Cliente">Cliente</option>
							<option value="Admin">Personal TF</option>
						</select>
					</div>
				</div>
				<div class="row" style="text-align:center;">
					<div class="col-lg-12">
						<button type="submit" class="btndegradate" id="aceptar" onclick="enviar()"><span>Ingresar</span></button>
						<img src="../imagenes/loading.gif" alt="" id="imgif" name="imgif" style="display:none; width:60px;" />
						<button type="button" class="btndegradate" id="cancelar" onclick="cancel()" style="display:none;"><span>Cancelar</span></button>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-11" style="text-align:right;">
						<h4 style="cursor:pointer;" onclick="recuperarcontrasena()"><I>Olvido su contraseña?</I></h4>
						<h4 style="cursor:pointer;" onclick="recuperarnombre()"><I>Olvido su nombre de usuario?</I></h4>
					</div>
				</div>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		</div>
		<div class="modal fade" id="recuperarcontrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Envio de email</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12">
								<h4>Ingrese su correo electrónico</h4>
								<input type="text" id="mailrecuperar" class="form-control" placeholder="Ingrese su correo electrónico" />
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="aceptarcontrasena()" id="enviarcambio">Enviar</button>
						<img src="../imagenes/loading.gif" style="display:none; max-width:50px;" id="waitcambio">
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="nuevacontrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Cambio de contraseña</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12">
								<h4>Ingrese su código</h4>
								<input type="text" id="codigorecuperar" class="form-control" placeholder="Ingrese el código enviado a su correo electrónico" />
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<h4>Nueva contraseña</h4>
								<input type="password" id="passrecuperar" class="form-control" placeholder="**********" />
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<h4>Repita la contraseña</h4>
								<input type="password" id="passrecuperar1" class="form-control" placeholder="**********" />
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="confirmarcambio()" id="btnokcambio">Guardar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="recuperarnombre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Recuperar Nombre de Usuario (E-mail)</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12">
								<h4>Ingrese su número de documento</h4>
								<input type="text" id="cedularecuperar" class="form-control" placeholder="Ingrese su número de identificación..." />
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<h4>Ingrese su fecha de nacimiento</h4>
								<div class="row">
									<div class="col-lg-3">
										<strong>Año</strong>
										<select id="aniorecuperar" class="inputlogin form-control">
											<option value="1">Año</option>
											<?php for($i = $anio; $i > 1930; $i--){?>
											<option value="<?php echo $i;?>"><?php echo $i;?></option>
											<?php }?>
										</select>
									</div>
									<div class="col-lg-3">
										<strong>Mes</strong>
										<select id="mesrecuperar" class="inputlogin form-control">
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
									<div class="col-lg-3">
										<strong>Día</strong>
										<select id="diarecuperar" class="inputlogin form-control">
											<option value="0">Día</option>
											<?php for($j = 1; $j <= 31; $j++){?>
											<option value="<?php echo $j;?>"><?php echo $j;?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<h4>Ingrese su número de celular</h4>
								<input type="text" id="celularrecuperar" class="form-control" placeholder="Ingrese el número de celular ingresado al crear la cuenta..." />
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="aceptarnombre()" id="enviarnombre">Enviar</button>
						<img src="../imagenes/loading.gif" style="display:none; max-width:50px;" id="waitnombre">
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="errorcontrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
							&nbsp;&nbsp;<strong>Error...!</strong>&nbsp;El correo electrónico ingresado es incorrecto.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarModal()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="errorvalidacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
							&nbsp;&nbsp;<strong>Error...!</strong>&nbsp;Los datos ingresados son incorrectos.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarModal()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="nombreok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-info" role="alert">
							<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
							&nbsp;Se ha recuperado exitosamente tu nombre de usuario.
							<h4>Su nombre de usuario es:</h4>
							<h3 style="text-align:center;"><span id="userrecuperado"></span></h3>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptaroknombre()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="mensajeenviado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-info" role="alert">
							<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
							&nbsp;Se ha enviado un código a tu correo electrónico, revisalo y sigue los pasos.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarmensaje()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="cambiook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-info" role="alert">
							<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
							&nbsp;Tu contraseña se ha modificado con éxito.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarcambiook()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="bienvenida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" onclick="aceptarModalbienvenida()">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Bienvenid@</h4>
					</div>
					<div class="modal-body">
						<div class="row" style="text-align:center;">
							<div class="col-lg-12">
								<h4>Bienvenid@ a:</h4>
								<img src="../imagenes/ticketfacilnegro.png" />
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" id="btn1" style="display:none;" class="btn btn-primary" onclick="aceptarModalbienvenida()">Aceptar</button>
						<button type="button" id="btn2" style="display:none;" class="btn btn-primary" onclick="aceptarModalbienvenida()">Aceptar</button>
						<button type="button" id="btn3" style="display:none;" class="btn btn-primary" onclick="aceptarModalbienvenida()">Aceptar</button>
						<button type="button" id="btn4" style="display:none;" class="btn btn-primary" onclick="aceptarModalbienvenida()">Aceptar</button>
						<button type="button" id="btn5" style="display:none;" class="btn btn-primary" onclick="aceptarModalbienvenida()">Aceptar</button>
						<button type="button" id="btn6" style="display:none;" class="btn btn-primary" onclick="aceptarModalbienvenida()">Aceptar</button>
						<button type="button" id="btn7" style="display:none;" class="btn btn-primary" onclick="aceptarModalbienvenida()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" onclick="aceptarModalerror()">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Aviso</h4>
					</div>
					<div class="modal-body">
						<div class="row" style="display:none;" id="alerta1">
							<div class="col-lg-12">
								<div class="alert alert-danger" role="alert"><strong>Error...! </strong>Tus datos son incorrectos</div>
							</div>
						</div>
						<div class="row" style="display:none;" id="alerta2">
							<div class="col-lg-12">
								<div class="alert alert-info" role="alert"><strong>Aviso...! </strong>Tu cuenta ha sido desactivada</div>
							</div>
						</div>
						<div class="row" style="display:none;" id="alerta3">
							<div class="col-lg-12">
								<div class="alert alert-info" role="alert"><strong>Debes cambiar tu contraseña.</strong></div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="aceptarModalerror()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="page" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Escoge el Módulo al que quieres ingresar</h4>
					</div>
					<div class="modal-body">
						<div class="row" style="text-align:center;">
							<div class="col-lg-12">
								<a onclick="esocgermodulo('<?php echo base64_encode(1);?>')" style="text-decoration:none; cursor:pointer;"><div class="alert alert-info" role="alert"><strong>S.R.I.</strong></div></a>
							</div>
						</div>
						<div class="row" style="text-align:center;">
							<div class="col-lg-12">
								<a onclick="esocgermodulo('<?php echo base64_encode(2);?>')" style="text-decoration:none; cursor:pointer;"><div class="alert alert-info" role="alert"><strong>TICKETFACIL</strong></div></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).keypress(function(e){
	if(e.which == 13){
		enviar();
	}
});

function recuperarcontrasena(){
	$('#recuperarcontrasena').modal('show');
}

function recuperarnombre(){
	$('#recuperarnombre').modal('show');
}

function aceptarcontrasena(){
	var mail = $('#mailrecuperar').val();
	$('#enviarcambio').fadeOut('slow');
	$('#waitcambio').delay(600).fadeIn('slow');
	$.post('subpages/Conciertos/recuperarcontrasena.php',{
		mail : mail
	}).done(function(response){
		if($.trim(response) == 'ok'){
			$('#recuperarcontrasena').modal('hide');
			$('#waitcambio').fadeOut('fast');
			$('#enviarcambio').fadeIn('slow');
			$('#mensajeenviado').modal('show');
			$('#mailrecuperar').val('');
		}else if($.trim(response) == 'error'){
			$('#mailrecuperar').val('');
			$('#waitcambio').fadeOut('fast');
			$('#enviarcambio').delay(600).fadeIn('slow');
			$('#errorvalidacion').modal('show');
		}
	});
}

function aceptarmensaje(){
	$('#nuevacontrasena').modal('show');
}

function aceptarnombre(){
	var cedula = $('#cedularecuperar').val();
	var anio = $('#aniorecuperar').val();
	var mes = $('#mesrecuperar').val();
	var dia = $('#diarecuperar').val();
	var celular = $('#celularrecuperar').val();
	$.post('subpages/Conciertos/cambiarnombre.php',{
		cedula : cedula, anio : anio, mes : mes, dia : dia, celular : celular
	}).done(function(response){
		if($.trim(response) != 'error'){
			$('#nombreok').modal('show');
			$('#userrecuperado').html(response);
			$('#recuperarnombre').modal('hide');
		}else{
			$('#errorvalidacion').modal('show');
		}
	});
}

function aceptaroknombre(){
	$('#nombreok').modal('hide');
}

function confirmarcambio(){
	var codigo = $('#codigorecuperar').val();
	var pass = $('#passrecuperar').val();
	$.post('subpages/Conciertos/cambiarcontrasena.php',{
		codigo : codigo, pass : pass
	}).done(function(response){
		$('#nuevacontrasena').modal('hide');
		if($.trim(response) == 'ok'){
			$('#btnokcambio').fadeOut('slow');
			$('#cambiook').modal('show');
		}else{
			$('#errorvalidacion').modal('show');
		}
	});
}

function aceptarcambiook(){
	$('#cambiook').modal('hide');
}

$('#perfil').on('change',function(){
	var p = $('#perfil').val();
	if(p == 'Admin'){
		$('.nomostrar').fadeOut('slow');
		$('.perfiles').delay(600).fadeIn('slow');
		$('#cancelar').delay(600).fadeIn('slow');
		$('#aceptar').prop('disabled',false);
	}else if(p == 'Cliente'){
		$('.nomostrar').fadeOut('slow');
		$('.cliente').delay(600).fadeIn('slow');
		$('#cancelar').delay(600).fadeIn('slow');
		$('#aceptar').prop('disabled',false);
	}
});

function enviar(){
	if($('.perfiles').is(':visible')){
		var user = $('#user').val();
		var pass = $('#pass').val();
		var usercli = '';
		var passcli = '';
	}else if($('.cliente').is(':visible')){
		var user = '';
		var pass = '';
		var usercli = $('#usercli').val();
		var passcli = $('#passcli').val();
	}
	$('#aceptar').fadeOut('slow');
	$('#cancelar').fadeOut('slow');
	$('#imgif').delay(600).fadeIn('slow');
	$.post('controlusuarios/control.php',{
		user : user, pass : pass, usercli: usercli, passcli : passcli
	}).done(function(data){
		if($.trim(data) == 'okcli'){
			setTimeout("$('#btn1').fadeIn(); $('#bienvenida').modal('show');",3000);
		}else if($.trim(data) == 'errorcli'){
			setTimeout("$('#alerta1').fadeIn(); $('#error').modal('show');",1000);
		}else if($.trim(data)=='ok1'){
			setTimeout("$('#page').modal('show');",3000);
		}else if($.trim(data)=='ok2'){
			setTimeout("$('#btn3').fadeIn(); $('#bienvenida').modal('show');",3000);
		}else if($.trim(data)=='ok3'){
			setTimeout("$('#btn4').fadeIn(); $('#bienvenida').modal('show');",3000);
		}else if($.trim(data)=='ok4'){
			setTimeout("$('#page').modal('show');",3000);
		}else if($.trim(data) == 'error'){
			setTimeout("$('#alerta1').fadeIn(); $('#error').modal('show');",1000);
		}else if($.trim(data) == 'errorchange'){
			setTimeout("$('#alerta1').fadeIn(); $('#error').modal('show');",1000);
		}else if($.trim(data) == 'inactivo'){
			setTimeout("$('#alerta2').fadeIn(); $('#error').modal('show');",3000);
		}else if($.trim(data) == 'changeok'){
			setTimeout("$('#alerta3').fadeIn(); $('#error').modal('show');",3000);
		}else if($.trim(data) == 'ok5'){
			setTimeout("$('#btn6').fadeIn(); $('#bienvenida').modal('show');",3000);
			// alert(data);
		}else if($.trim(data) == 'ok6'){
			setTimeout("$('#btn7').fadeIn(); $('#bienvenida').modal('show');",3000);
			// alert(data);
		}
	});
}

function cancel(){
	if($('.perfiles').is(':visible')){
		$('#user').val('');
		$('#pass').val('');
		$('.perfiles').fadeOut();
		$('#perfil').val(0);
		$('.nomostrar').delay(600).fadeIn();
		$('#aceptar').fadeOut('slow');
	}else if($('.cliente').is(':visible')){
		$('#usercli').val('');
		$('#passcli').val('');
		$('.cliente').fadeOut();
		$('#perfil').val(0);
		$('#aceptar').fadeOut('slow');
		$('.nomostrar').delay(600).fadeIn();
	}
}

function aceptarModalbienvenida(){
	if($('#btn1').is(':visible')){
		window.location = '?page=start';
	}else if($('#btn2').is(':visible')){
		// window.location = '';
	}else if($('#btn3').is(':visible')){
		window.location = 'spadmin/PerSeguridad/ingresoseguridad.php';
	}else if($('#btn4').is(':visible')){
		window.location = '?page=admin_bus';
	}else if($('#btn5').is(':visible')){
		// window.location = '';
	}else if($('#btn6').is(':visible')){
		window.location = '?page=transporte';
	}else if($('#btn7').is(':visible')){
		window.location = '?page=transporte';
	}
}

function aceptarModalerror(){
	if($('#alerta3').is(':visible')){
		 window.location = '?page=validarUsuarioA';
	}else{
		window.location = '';
	}
}

function esocgermodulo(id){
	window.location = 'subpages/validarmodulo.php?id='+id;
}
</script>