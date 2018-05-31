<?php
	session_start();
	if($_SESSION['perfil'] == 'Admin'){
		echo '<input type="hidden" id="datos" value="1" />';
	}else if($_SESSION['perfil'] == 'Seguridad'){
		echo '<input type="hidden" id="datos" value="2" />';
	}else if($_SESSION['perfil'] == 'Socio'){
		echo '<input type="hidden" id="datos" value="3" />';
	}else if($_SESSION['perfil'] == 'Auditor'){
		echo '<input type="hidden" id="datos" value="4" />';
	}else if($_SESSION['perfil'] == 'Distribuidor'){
		echo '<input type="hidden" id="datos" value="5" />';
	}else if($_SESSION['perfil'] == 'cliente'){
		echo '<input type="hidden" id="datos" value="6" />';
	}
?>
<div style="margin:10px -10px;">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#00ADEF; color:#fff; margin:20px 700px 0px 0px; padding-left:30px; font-size:22px;">
				<strong>Login</strong>
			</div>
			<div style="background-color:#EC1867; color:#fff; text-align:center; margin:5px -42px 0px 50%; font-size:20px; position:relative; padding:5px 20px;">
				<strong>Ingresa tu nueva contraseña</strong>
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
			<div style="background-color:#00ADEF; margin: 30px -42px 10px 40px; position:relative; padding:20px 100px 10px 0;">
				<div class="row">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<h4 style="color:#fff;"><strong>Digita tu nueva contraseña:</strong></h4>
						<input type="password" class="inputlogin form-control" id="pass1" placeholder="**********" onkeypress="return validar(event)" />
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<h4 style="color:#fff;"><strong>Repite tu nueva contraseña:</strong></h4>
						<input type="password" class="inputlogin form-control" id="pass2" placeholder="**********" onkeypress="return validar(event)" onchange="validarContrasenas()" />
					</div>
				</div>
				<div class="row" style="text-align:center;">
					<div class="col-lg-12">
						<button type="submit" class="btndegradate" id="aceptar" onclick="enviar()"><span>ACEPTAR</span></button>
						<img src="imagenes/ajax-loader.gif" alt="" id="imgif" name="imgif" style="display:none" />
					</div>
				</div>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" onclick="aceptarModalerror()">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel1">Aviso</h4>
							<h4 class="modal-title" id="myModalLabel2" style="display:none;">Escoge el Módulo al que quieres ingresar</h4>
						</div>
						<div class="modal-body">
							<div class="row alertas" style="display:none;" id="alerta1">
								<div class="col-lg-12">
									<div class="alert alert-danger" role="alert"><strong>Error...! </strong>Las Contraseñas no coinciden.</div>
								</div>
							</div>
							<div class="row alertas" style="display:none;" id="alerta2">
								<div class="col-lg-12">
									<div class="alert alert-danger" role="alert"><strong>Error...! </strong>Las Contraseñas no pueden estar vacias, por favor llenalas.</div>
								</div>
							</div>
							<div class="alertas" id="alerta3" style="display:none;">
								<div class="row" style="text-align:center;">
									<div class="col-lg-12">
										<a style="text-decoration:none; cursor:pointer;" id="modsri"><div class="alert alert-info" role="alert"><strong>S.R.I.</strong></div></a>
									</div>
								</div>
								<div class="row" style="text-align:center;">
									<div class="col-lg-12">
										<a style="text-decoration:none; cursor:pointer;" id="modticket"><div class="alert alert-info" role="alert"><strong>TICKETFACIL</strong></div></a>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" onclick="aceptarModalerror()" id="btnaceptar">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

var datos = $('#datos').val();

function validar(e) {
	tecla = (document.all) ? e.keyCode : e.which; 
	if (tecla==8) return true;
	if(tecla==32) return false;
	if(tecla==64) return true;
	if(tecla==46) return true;
	if(tecla==45) return true;
	if(tecla==95) return true;
	patron =/[A-Za-zñÑ\w]/;
	te = String.fromCharCode(tecla);
	return patron.test(te);
}

function validarContrasenas(){
	var p1 = $('#pass1').val();
	var p2 = $('#pass2').val();
	if(p1 != p2){
		$('#alerta1').fadeIn();
		$('#error').modal('show');
	}
}

function aceptarModalerror(){
	$('#pass1').val('');
	$('#pass2').val('');
	$('.alertas').fadeOut();
	$('#error').modal('hide');
	return false;
}

function enviar(){
	var pass1 = $('#pass1').val();
	var pass2 = $('#pass2').val();
	if((pass1 != '') && (pass2 != '')){
		if(datos == 1){
			$('#btnaceptar').fadeOut();
			$('#myModalLabel1').fadeOut();
			$('#myModalLabel2').fadeIn();
			$('#alerta3').fadeIn();
			$('#error').modal('show');
			$('#modsri').on('click',function(){
				var mod = 'sri';
				modificar(mod);
			});
			$('#modticket').on('click',function(){
				var mod = 'ticket';
				modificar(mod);
			});
		}else{
			var mod = '';
			modificar(mod);
		}
	}else{
		$('#alerta2').fadeIn();
		$('#error').modal('show');
	}
}

function modificar(mod){
	var pass1 = $('#pass1').val();
	var pass2 = $('#pass2').val();
	$.post('subpages/validarusuariook.php',{
		pass1 : pass1, datos : datos, mod : mod
	}).done(function(data){
		if(datos == 1){
			window.location = '?modulo=ingresoAdmin';
		}else if(datos == 2){
			window.location.href = 'spadmin/PerSeguridad/ingresoseguridad.php';
		}else if(datos == 3){
			window.location.href = '?modulo=ingresoSocio';
		}else if(datos == 4){
			window.location.href = '?modulo=ingresoAdt';
		}else if(datos == 5){
			window.location.href = '?modulo=ingresoDis';
		}else if(datos == 6){
			window.location.href = '?modulo=start';
		}
	});
}

// function esocgermodulo(id){
	// window.location = 'subpages/validarmodulo.php?id='+id;
	// if(id == 1){
		// $('#tipom').val('sri');
	// }else if(id == 2){
		// $('#tipom').val('ticket');
	// }
	// $('#error').modal('hide');
// }
</script>