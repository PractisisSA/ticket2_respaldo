<?php 
	// include("controlusuarios/seguridadSP.php");
	if(isset($_REQUEST['ident'])){
		$mail = $_REQUEST['mail'];
		$movil = $_REQUEST['movil'];
		$fijo = $_REQUEST['fijo'];
		$dirmatriz = $_REQUEST['dirmatriz'];
		$selected = 'selected';
	}else{
		$mail = '';
		$movil = '';
		$fijo = '';
		$selected = '';
		$dirmatriz = '';
	}
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="35" />';
	
	$gbd = new DBConn();
	$perfil = 'SP';
	
	$sql = "SELECT strMailU, strCedulaU FROM Usuario";
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute();
	$numreg = $stmt -> rowCount();
	$contar = 1;
	$content = '';
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
		$content .= '<div class="usersok"><input type="hidden" class="mailbd" value="'.$row['strMailU'].'" />
					<input type="hidden" class="cedulabd" value="'.$row['strCedulaU'].'" /></div>';
		$contar++;
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
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 500px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				<strong>Datos Personales del Usuario</strong>
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
							<strong>Error...!</strong> Revisa tu correo electrónico, esta mal escrito.
						</div>
						<div class="alert alert-success alert-dismissible" id="alerta2" role="alert" style="margin:0 60px 0 20px; display:none;">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							<strong>Error...!</strong> Este Nombre de Usuario (E-mail) ya existe.
						</div>
						<div class="alert alert-success alert-dismissible" id="alerta3" role="alert" style="margin:0 60px 0 20px; display:none;">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							<strong>Error...!</strong> Esta Cédula ya existe.
						</div>
						<div class="alert alert-success" role="alert" id="alerta4" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							<strong>Error...!</strong> Tu Cédula es incorrecta.
						</div>
						<div class="alert alert-info" role="alert" id="alerta5" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<strong>Excelente!</strong> Nuevo usuario ingresado.
						</div>
						<div class="alert alert-success" role="alert" id="alerta6" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							<strong>Error...!</strong> Teléfono móvil incorrecto.
						</div>
						<div class="alert alert-success" role="alert" id="alerta7" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							<strong>Error...!</strong> Teléfono fijo incorrecto.
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Nombres:</strong></h4>
							<input type="text" class="form-control inputlogin" id="nombre" name="nombre" onkeydown="justText(event,this.value)" />
						</div>
						<div class="col-lg-5">
							<h4><strong>Apellidos: </strong></h4>
							<input type="text" class="form-control inputlogin" id="apellidos" name="apellidos" required="required" onkeydown="justText(event,this.value)" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Nombre de Usuario(E-mail):</strong></h4>
							<input type="text" class="form-control inputlogin" id="mail" name="mail" placeholder="alguien@example.com" value = '<?php echo $mail?>' />
						</div>
						<div class="col-lg-5">
							<h4><strong>Clave de Acceso : </strong></h4>
							<input type="password" class="form-control inputlogin" id="cedula" name="cedula" placeholder = '********************' />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Ciudad: </strong></h4>
							<select class="form-control inputlogin" name="provincia" id="ciudad" required="required">
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
							<input type="text" class="inputlogin" id="otraCiudad" name="otraCiudad"  required="required" placeholder="Digita tu Ciudad" style="display:none;" onkeydown="justText(event,this.value)" />
						</div>
						<div class="col-lg-5">
							<h4><strong>Provincia:</strong></h4>
							<select class="form-control inputlogin" name="provincia" id="provincia" required="required">
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
							<input type="text" class="inputlogin" id="otraProvincia" name="otraProvincia" required="required" placeholder="Digita tu Provincia" style="display:none;" onkeydown="justText(event,this.value)" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-10">
							<h4><strong>Direcci&oacute;n del Domicilio:</strong></h4>
							<input type="text" class="form-control inputlogin" id="direccion" name="direccion" required="required" placeholder="Av. Principal y Transversal" value = '<?php echo $dirmatriz;?>' />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Tel&eacute;fono M&oacute;vil:</strong></h4>
							<input type="text" class="form-control inputlogin" id="telmovil" name="telmovil" required="required" placeholder="0999999999" value = '<?php echo $movil?>'  />
						</div>
						<div class="col-lg-5">
							<h4><strong>Tel&eacutefono Fijo *</strong></h4>
							<input type="text" class="form-control inputlogin" id="telfijo" name="telfijo" required="required" placeholder="022222222" value = '<?php echo $fijo?>'  />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Perfil *</strong></h4>
							<select class="form-control inputlogin" id="perfil" name="perfil" required="required">
								<option value="0">Seleccione...</option>
								<option value="Admin">Administrador</option>
								<option value="Socio" <?php echo $selected;?>>Socio</option>
								<option value="Seguridad">Seguridad</option>
								<option value="Auditor">Auditor</option>
								<option value="Municipio">Municipio</option>
								<!--<option value="ventas-ticket-facil">Ventas Ticket-facil</option>
								<option value="cadena-comercial">Cadena Comercial</option>-->
							</select>
							
							<div id = 'contieneTipoSocio' style = 'display:none;'  >
								<h4><strong>TIPO DE SOCIO *</strong></h4>
								<select class="form-control inputlogin" id="tipo_socio" name="tipo_socio" required="required">
									<option value="1">Normal</option>
									<option value="2">Especial</option>
								</select>
							</div>
						</div>
						<div class="col-lg-5">
							<h4><strong>Observaciones *</strong></h4>
							<textarea rows="5" cols="34" id="observacion" name="observacion" class="form-control inputlogin" style="resize:none;" required="required" placeholder="Motivo de creaci&oacute;n del usuario"></textarea>
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
	
	$( "#perfil" ).change(function() {
		var perfil = $( "#perfil" ).val();
		if(perfil == 'Socio'){
			$('#contieneTipoSocio').fadeIn('slow');
		}else{
			$('#contieneTipoSocio').css('display','none');
		}
	});
	var rucEmp = $('#rucEmp').val();
	var razonEmp = $('#razonEmp').val();
	var nombreEmp = $('#nombreEmp').val();
	if((rucEmp == 'Ingresa RUC') && (razonEmp == 'Ingresa Razon Social') && (nombreEmp == 'Ingresa Nombre Comercial')){
		$('#invalido').fadeIn();
	}else{
		$('#validado').fadeIn();
	}
});

$('#ciudad').on('change',function (){
	var otraCiudad = $('#ciudad').val();
	if(otraCiudad == 17){
		$('#otraCiudad').fadeIn('slow');
	}else{
		$('#otraCiudad').fadeOut('fast');
	}
});

$('#provincia').on('change',function (){
	var otraCiudad = $('#provincia').val();
	if(otraCiudad == 23){
		$('#otraProvincia').fadeIn('slow');
	}else{
		$('#otraProvincia').fadeOut('fast');
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
		$('#alerta1').fadeIn();
		$('#alerta1').delay(2000).fadeOut();
	}
}

function validarMailrepetido(valor){
	if(!$('#alerta2').is(':hidden')){
		$('#alerta2').fadeOut();
	}
	if(!$('#alerta3').is(':hidden')){
		$('#alerta3').fadeOut();
	}
	var content = 1;
	$('.usersok').each(function(){
		var mail = $(this).find('.mailbd').val();
		if(valor == mail){
			$('#alerta2').fadeIn();
			$('#mail').val('');
			return false;
		}
		var cedula = $(this).find('.cedulabd').val();
		if(valor == cedula){
			$('#alerta3').fadeIn();
			$('#cedula').val('');
			return false;
		}
	});
}

$('#telmovil').on('change', function(){
	var numMovil = $('#telmovil').val().length;
	if(numMovil < 10){
		$('#alerta6').fadeIn();
		$('#telmovil').val('');
		$('#telmovil').focus();
		$('#alerta6').delay(2000).fadeOut();
	}
});

$('#telfijo').on('change', function(){
	var numFijo = $('#telfijo').val().length;
	if(numFijo < 9){
		$('#alerta7').fadeIn();
		$('#telfijo').val('');
		$('#telfijo').focus();
		$('#alerta7').delay('2000').fadeOut();
	}
});

$('#cedulass').on('change',function(){
	var cedula = $('#cedula').val();
	var digito_region = cedula.substring(0,2);
	var ultimo_digito   = cedula.substring(9,10);
	var pares = parseInt(cedula.substring(1,2)) + parseInt(cedula.substring(3,4)) + parseInt(cedula.substring(5,6)) + parseInt(cedula.substring(7,8));
	var numero1 = cedula.substring(0,1);
	var numero1 = (numero1 * 2);
	if( numero1 > 9 ){ var numero1 = (numero1 - 9); }
	var numero3 = cedula.substring(2,3);
	var numero3 = (numero3 * 2);
	if( numero3 > 9 ){ var numero3 = (numero3 - 9); }
	var numero5 = cedula.substring(4,5);
	var numero5 = (numero5 * 2);
	if( numero5 > 9 ){ var numero5 = (numero5 - 9); }
	var numero7 = cedula.substring(6,7);
	var numero7 = (numero7 * 2);
	if( numero7 > 9 ){ var numero7 = (numero7 - 9); }
	var numero9 = cedula.substring(8,9);
	var numero9 = (numero9 * 2);
	if( numero9 > 9 ){ var numero9 = (numero9 - 9); }
	var impares = numero1 + numero3 + numero5 + numero7 + numero9;
	var suma_total = (pares + impares);
	var primer_digito_suma = String(suma_total).substring(0,1);
	var decena = (parseInt(primer_digito_suma) + 1)  * 10;
	var digito_validador = decena - suma_total;
	if(digito_validador == 10)
	var digito_validador = 0;
	if(cedula.length < 10){
		$('#alerta4').fadeIn();
		$('#alerta4').delay(1500).fadeOut();
		$('#cedula').val('');
		return false;
	}
	if(digito_validador != ultimo_digito){
		$('#alerta4').fadeIn();
		$('#alerta4').delay(1500).fadeOut();
		$('#cedula').val('');
		return false;
	}
});

function enviarDatos(){
	$('#enviar').fadeOut('fast');
	$('#wait').fadeIn('slow');
	var nombre = $('#nombre').val();
	var apellido = $('#apellidos').val();
	var usuario = $('#mail').val();
	var cedula = $('#cedula').val();
	var cmbciudad = $('#ciudad').val();
	if(cmbciudad == 17){
		var ciudad = $('#otraCiudad').val();
	}else{
		var ciudad = $('#ciudad').val();
	}
	var cmbprovincia = $('#provincia').val();
	if(cmbprovincia == 23){
		var provincia = $('#otraProvincia').val();
	}else{
		var provincia = $('#provincia').val();
	}
	var direccion = $('#direccion').val();
	var movil = $('#telmovil').val();
	var fijo = $('#telfijo').val();
	var perfil = $('#perfil').val();
	var tipo_socio = $('#tipo_socio').val();
	var obs = $('#observacion').val();
	if((nombre == '') || (apellido == '') || (usuario == '') || (cedula == '') || (ciudad == 0) || (provincia == 0) || (direccion == '') || (movil == '') || (fijo == '') || (perfil == 0) || (obs == '')){
		alert('Faltan campos por llenar');
	}else{
		$.post('SP/guardarusuario.php',{
			nombre : nombre, apellido : apellido, usuario : usuario, cedula : cedula, ciudad : ciudad, provincia : provincia, direccion : direccion,
			movil : movil, fijo : fijo, perfil : perfil, obs : obs , tipo_socio : tipo_socio
		}).done(function(data){
			if($.trim(data)!='error'){
				if(tipo_socio == 2){
					$('#alerta5').fadeIn();
					$('html, body').animate({ scrollTop: 0 }, 'slow');
					setTimeout("window.location.href = '?modulo=creaSocio_paso1&socio="+data+"';",2500);
				}else{
					$('#alerta5').fadeIn();
					$('html, body').animate({ scrollTop: 0 }, 'slow');
					setTimeout("window.location.href = '?modulo=crearUsuarios';",2500);
				}
			}
		});
	}
}

$('#cancelar').on('click',function(){
	window.location = '';
});
</script>