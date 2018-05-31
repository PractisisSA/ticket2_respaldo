<?php
	session_start();
	if($_SESSION['autentica'] == 'uzx153'){
		echo "<script>alert('Ya tienes iniciada una sesion'); window.location.href='?modulo=start';</script>";
	}
	echo '<input type="hidden" id="data" value="1" />';
	echo '<input type="hidden" id="dataCon" value="'.$_GET['con'].'" />';
	
	$gbd = new DBConn();
	echo '<input type = "hidden" id = "con" value ="'.$_REQUEST['con'].'" />';
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
	$pos = $_REQUEST['pos'];
	echo '<input type="hidden" id="pos" value="'.$pos.'" />';
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="888800978669-ocjtqig3s763l7erklsp5v58j69b2h0r.apps.googleusercontent.com">
<style>
	a:hover{
		text-decoration:none;
	}
</style>
<div style="background-color:#282d2b; margin:10px 20px -10px 20px; text-align:center;">
	<div class="breadcrumb">
		<a  id="chooseseat" onclick = 'verMapaAbajo();' style = 'cursor:pointer;'>Escoge tu asiento</a>
		<a class="active" id="identification" href="#" onclick="security()">Identificate</a>
		<a id="buy" href="#" onclick="security()">Resumen de Compra</a>
		<a id="pay" href="#" onclick="security()">Pagar</a>
		<a id="confirmation" href="#" onclick="security()">Confirmaci&oacute;n</a>
	</div>
</div>
<script>
	function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script>
<div style="margin:10px -10px;">
	
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
		
			<!--<div class="row">
				<div class="col-md-10"></div>
				<div class="col-md-1">
					<button onclick="goBack();" class="btn btn-primary right">Atras</button>
				</div>
			</div>-->
			<div style="background-color:#3B5998; margin-right:50%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<!--<img src = 'imagenes/faceNuevo.png'  style = 'cursor:pointer;' /><br/>-->
			</div>
			
			<div style = 'display:none;'>
					<p id = 'ID'></p>
					<p id = 'Name'></p>
					<img id = 'Image' />
					<p id = 'Email'></p>
				</div>
			<div style="background-color:#EC1867; margin-right:50%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Formulario de Registro</strong>
			</div>
			<br>
			<div> 
				<a onclick="ingresar();" class="btn btn-primary social-login-btn social-facebook" name="">
					<i class="fa fa-facebook fa-1x">
						<label style="font-size:15px;font-family:corbel;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acceder&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
					</i>
				</a><br>
				<a class="g-signin2" data-onsuccess="onSignIn" class="btn btn-danger social-login-btn social-google" name=""><i class="fa fa-google-plus fa-2x"></i></a>
			</div>
			
			
			
			<div style = 'display:none;' >
				<span id = 'nombreUsuFace' >!!!</span>
				<span id = 'nombreUsuEmail' >!!!</span>
				<span id = 'nombreUsuPass' >!!!</span>
				<span id = 'fecha' >!!!</span>
				<span id = 'sexo' >!!!</span>
			</div>
			<div style="background-color:#00ADEF; margin-left:40px; margin-bottom:40px; color:#fff;">
				<div style="background-color:#00ADEF; margin:40px -42px 0 40px; position:relative; padding:10px 40px 10px 10px;">
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
					<div class="alert alert-danger" role="alert" id="alerta6" style="margin:0 60px 0px 20px; display:none;">
						<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
						<strong>Error!</strong>... Tu E-mail esta mal escrito, digitalo nuevamente.
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
							<span class="label label-info pull-right">Si no cuenta con un "Documento de Identificación" Ecuatoriano<br> porfavor ingrese su número de pasaporte antecedido de la letra "P"</span>
						</div>
					</div>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div style="background-color:#EC1867; margin:0px -42px 0px 30%; padding:10px; font-size:16px; color:#fff; position:relative;">
					El "Documento de Identidad", Servira para validar todas tus compras.
					<div class="tra_comprar_concierto"></div>
					<div class="par_comprar_concierto"></div>
				</div>
				<div style="background-color:#00ADEF; margin-left:40px; margin-right:-42px; position:relative; padding:10px 40px 10px 10px;">
					<div class="row" style = 'display:;'>
						<div class="col-lg-5" style="text-align:right;">
							<h4>Fecha de Nacimiento: </h4>
						</div>
						<div class="col-lg-6">
							<div class="row">
								<div class="col-xs-3">
									<select id="anio" name="anio" class="inputlogin form-control">
										<option value="1" selected>Año</option>
										<?php for($i = $anio; $i > 1930; $i--){?>
										<option value="<?php echo $i;?>"><?php echo $i;?></option>
										<?php }?>
									</select>
								</div>
								<div class="col-xs-3">
									<select id="mes" name="mes" class="inputlogin form-control">
										<option value="01" selected>Mes</option>
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
										<option value="1" selected>Día</option>
										<?php for($j = 1; $j <= 31; $j++){?>
										<option value="<?php echo $j;?>"><?php echo $j;?></option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row" style = 'display:none;'>
						<div class="col-lg-5" style="text-align:right;">
							<h4>Género: </h4>
						</div>
						<div class="col-lg-6">
							<select id="genero" name="genero" class="inputlogin form-control">
								<option value="Masculino" selected>Seleccione...</option>
								<option value="Masculino">Masculino</option>
								<option value="Femenino">Femenino</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5" style="text-align:right;">
							<h4>Usuario (E-mail):</h4>
						</div>
						<div class="col-lg-6">
							<input type="text" id="mail" name="mail" class="inputlogin form-control" placeholder="example@dominio.com" onchange="validarMail()" onkeyup="validarValores(this.value);" autocomplete="off" />
						</div>
					</div>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div style="background-color:#EC1867; margin:0px -42px 0px 30%; padding:10px; font-size:16px; color:#fff; position:relative;">
					El "E-mail", Servira para que recibas notificaciones de todas tus compras o reservas y para el ingreso a TICKETFACIL.
					<div class="tra_comprar_concierto"></div>
					<div class="par_comprar_concierto"></div>
				</div>
				<div style="background-color:#00ADEF; margin-left:40px; margin-right:-42px; position:relative; padding:10px 40px 10px 10px;">
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
					<div class="row" style = 'display:none;'>
						<div class="col-lg-5" style="text-align:right;">
							<h4>Forma de Pago:</h4>
						</div>
						<div class="col-lg-6">
							<select name="pago" id="pago" class="inputlogin form-control">
								<option>Seleccione...</option>
								<option value="1">Tarjeta de Crédito</option>
								<option value="2">Déposito</option>
								<option value="3" selected>Punto de Venta</option>
							</select>
						</div>
					</div>
					<div class="row" style = 'display:none;'>
						<div class="col-lg-5" style="text-align:right;">
							<h4>Cómo obtener tus Boletos:</h4>
						</div>
						<div class="col-lg-6">
							<select id="obtener_boleto" name="obtener_boleto" class="inputlogin form-control">
								<option value="correo" selected >Correo Electrónico</option>
								<option value="Domicilio">Envio a Domicilio</option>
							</select>
						</div>
					</div>
					<div class="row" style = 'display:none;'>
						<div class="col-lg-5" style="text-align:right;">
							<h4>Provincia del Domicilio:</h4>
						</div>
						<div class="col-lg-6">
							<select class="inputopcional form-control" id="provincia">
								<option value="18" selected >Seleccione...</option>
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
								<input type="text" class="form-control inputopcional" placeholder="Provincia..." id="otraProvincia" aria-describedby="basic-addon1" autocomplete="off" onkeydown="justText(event,this)">
								<span class="input-group-addon" id="basic-addon1" title="Cancelar" onclick="cancelarProvincia()" style="cursor:pointer;">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="row" style = 'display:none;'>
						<div class="col-lg-5" style="text-align:right;">
							<h4>Ciudad del Domicilio:</h4>
						</div>
						<div class="col-lg-6">
							<select class="inputopcional form-control" id="ciudad">
								<option value="12" selected>Seleccione...</option>
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
								<input type="text" class="form-control inputopcional" placeholder="Ciudad..." id="otraCiudad" aria-describedby="basic-addon1" autocomplete="off" onkeydown="justText(event,this)">
								<span class="input-group-addon" id="basic-addon1" title="Cancelar" onclick="cancelarCiudad()" style="cursor:pointer;">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="row" style = 'display:none;' >
						<div class="col-lg-5" style="text-align:right;">
							<h4>Dirección:</h4>
						</div>
						<div class="col-lg-6">
							<textarea rows="2" col="10" id="dir" name="dir" class="inputopcional form-control" placeholder="OPCIONAL" autocomplete="off" >000</textarea>
						</div>
					</div>
					<div class="row" style = 'display:none;'>
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
								<center><label for="check"><input type="checkbox" name="check" id="check" onchange="mostrar()" checked />&nbsp;&nbsp;&nbsp;&nbsp;<strong>ACEPTO LOS T&Eacute;RMINOS Y CONDICIONES</strong></label></center>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<center>
									<a class="btn_login" id="aceptar" name="aceptar" onclick="enviar()" style="text-decoration:none; display:; cursor:pointer;">
										<span>REGISTRARME</span>
									</a>
									<img src="imagenes/loading.gif" title="Guardando..." style="max-width:80px; display:none;" id="wait" />
								</center>
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
						<style>
							#lista3 {
								counter-reset: li; 
								list-style: none; 
								*list-style: decimal; 
								font: 15px 'trebuchet MS', 'lucida sans';
								padding: 0;
								margin-bottom: 4em;
								text-shadow: 0 1px 0 rgba(255,255,255,.5);
							}

							#lista3 ol {
								margin: 0 0 0 2em; 
							}

							#lista3 li{
								position: relative;
								display: block;
								padding: .4em .4em .4em .8em;
								*padding: .4em;
								margin: .5em 0 .5em 2.5em;
								background: #ddd;
								color: #444;
								text-decoration: none;
								transition: all .3s ease-out;   
								text-align:left;
							}

							#lista3 li:hover{
								background: #eee;
							}   

							#lista3 li:before{
								content: counter(li);
								counter-increment: li;
								position: absolute; 
								left: -2.5em;
								top: 50%;
								margin-top: -1em;
								background: #fa8072;
								height: 2em;
								width: 2em;
								line-height: 2em;
								text-align: center;
								font-weight: bold;
							}

							#lista3 li:after{
								position: absolute; 
								content: '';
								border: .5em solid transparent;
								left: -1em;
								top: 50%;
								margin-top: -.5em;
								transition: all .3s ease-out;               
							}

							#lista3 li:hover:after{
								left: -.5em;
								border-left-color: #fa8072;             
							}
						</style>
						<ol id="lista3">
							<li>Primero: TICKETFACIL, es una marca registrada cuyo objeto social, para efectos de las presentes condiciones, es la impresión y comercialización de entradas para eventos o espectáculos.</li>
							<li>Segunda:No existen cambios, reembolsos ni cancelaciones de compra de tickets.</li>
							<li>Tercera: EL CLIENTE es el usuario, que adquiere los Tickets y está previamente registrado en la página web www.ticketfacil.ec o en el sistema de facturación de los puntos de venta de Ticketfacil quien acepta haber ingresado toda la información real personal requerida, y es él único y exclusivamente responsable por la información registrada. TICKETFACIL no se hace responsable por tiquetes falsos o adulterados o adquiridos en lugares no autorizados. Quien suministre información o use su(s)entrada(s) para falsificaciones o adulteraciones será responsable ante las entidades legales pertinentes, esto puede dar lugar a RESPONSABILIDAD PENAL</li>
							<li>Cuarta: EL CLIENTE acepta que toda la información de las entradas seleccionadas han sido verificadas. El CLIENTE reconoce que la realización de cualquier evento o espectáculo, del que adquiera las entradas mediante los puntos de venta de TICKET FACIAL  o por el sistema de www.ticketfacil.ec no depende de TICKETFACIL,  quien no se responsabiliza por por errores de fechas, horas, valores registrados, nombre de eventos, calidad de los espectáculos, condiciones de seguridad, organizacion, contenido o en general causas ajenas a responsabilidades propias. Este ticket es válido sólo por el día,hora y lugar del evento en el especificado, el ingreso después de la hora señalada está sujeta a las reglas del lugar donde se realiza el evento.Una vez adquirido el tiquete no se aceptan cambios, devoluciones o reintegros, salvo en aquellos casos en que el empresario, promotor del evento o la ley lo establezca y en las condiciones que los mismos lo dispongan. TICKETFACIL  no está obligado hacer devoluciones de dinero, el empresario es la única persona legalmente responsable del evento, información impresa en la parte frontal del presente ticket.</li> 
							<li>Quinta:  TICKET FACIL no se hace responsable por la pérdida o robo del presente ticket, no existe obligación alguna de emitir un nuevo ticket o permitirle el ingreso aunque logre comprobar la adquisición del ticket,  estos son de entera responsabilidad del CLIENTE. El cliente acepta y conoce que los tiquetes que compre tienen un costo adicional por el servicio ofrecido por el sistema TICKETFACIL y que en ningún caso será reembolsable. Para el ingreso al evento el ticket debe ser presentado completo y sin alteraciones. Únicamente serán válidas para entrar al evento los tickets emitidos por TICKETFACIL.</li> 
							<li>Sexta: EL CLIENTE asepta que los organizadores se reservan el derecho de admisión y  el derecho de agregar, modificar o sustituir artistas, así como de variar los programas, precios, ubicaciones, fechas, capacidad del escenario y ubicación de los mismos. En caso de que el evento sea postergado este ticket será válido para el ingreso en la fecha indicada por el empresario.El cliente no tendrá derecho a la devolución de su dinero.</li> 
							<li>Septima: Al ingreso y durante el evento los asistentes estarán sujetos a las medidas de seguridad y políticas establecidas por el escenario, quien no cumpla los controles respectivos, o  desacate los mismos, se le prohibirá  el ingreso o se le solicitará su retiro, sin lugar a devolución del dinero pagado por el ticket. En las localidades numeradas se deberá respetar el número de silla, de lo contrario el personal de logística podrá reubicarlo en el lugar adquirido o solicitarle el retiro del escenario.</li> 
							<li>Octava: No se permite el ingreso de cámaras de vídeo, fotográficas, bebidas alcohólicas u objetos que pongan en peligro la seguridad del público, pudiendo ser retirados del lugar y destruido su contenido.</li> 
							<li>Novena:El poseedor de este ticket asume todos los riesgos que puedan suscitarse durante el evento y exime a los organizadores por cualquier daño que pueda sufrir, de ser el caso EL CLIENTE se obliga a comunicar su situación de discapacidad, embarazo o cualquier situación que pueda poner en riesgo su integridad o la de los asistentes, bajo su responsabilidad el promotor permitirá el ingreso o un trato especial.</li> 
							<li>Decima: Las compras realizadas por el portal www.ticketfacil.ec están sujetas a la verificación y aceptación de la tarjeta débito o crédito por parte del BANCO o entidad financiera en el transcurso de 24 horas después de haber efectuado la compra.</li> 
							<li>Decima primera: El cliente acepta que la información registrada en el sistema de ticketfacil.ec o sus puntos de ventas, así como de las transacciones efectuadas son de propiedad de Ticketfacil; quien está autorizado para dar usos comerciales sin afectar en ningún caso la intimidad y seguridad de los usuarios.</li> 
							<li>Decima segunda: En caso de cancelación definitiva del evento por cualquier causa, TICKET FACIL es en su condición de simple intermediario para la distribución y venta del ticket, no se hacen responsable por la devolución del dinero pagado por este ticket, siendo única y exclusivamente responsable el empresario, promotor o productor  del evento. El presente ticket es emitido por la imprenta autorizada por mandato del empresario quien es la única persona legalmente responsable del evento, información impresa en la parte frontal del presente ticket. TICKETFACIL gestionará la devolución solo en caso de ser contratado por EL EMPRESARIO para esta gestión. En caso que TICKETFACIL  gestione la devolución del dinero, EL CLIENTE deberá seguir las indicaciones publicadas en el sitio web www.ticketfacil.ec.</li> 
							<li>Decima tercera: EL CLIENTE acepta que los tickets comprados o reservados por la web www.ticketfacil.ec deberán ser recogidos por el usuario registrado en el sistema de TICKETFACIL. o por la persona que el usuario haya indicado en el proceso de la compra, mostrando su documento de identidad original.</li> 
							<li>Decima cuarta: Las compras efectuadas en la página web www.tickefacil.ec se entienden efectuadas en los términos de la legislación ecuatoriana, en particular la ley de Comercio Electrónico y su Reglamento, por lo que la contratación y la firma electrónica se reputa válida y obliga al usuario, en el términos legales y contractuales del negocio jurídico realizado.</li> 
							<li>Decima quinta: Cualquier diferencia surgida entre las partes será dirimida en derecho aplicando la legislación ecuatoriana, ante la justicia ordinaria.</li> 
						</ol>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="bienvenida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" onclick="aceptarLogin()">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Bienvenid@</h4>
					</div>
					<div class="modal-body">
						<div class="row" style="text-align:center;">
							<div class="col-lg-12">
								<h4>Bienvenid@ a:</h4>
								<img src="imagenes/ticketfacilnegro.png" />
							</div>
						</div>
						<form id="form" action="" method="post" >
							<table style = 'display:none;'>
							<?php
								if(isset($_POST['codigo'])){
									foreach($_POST['codigo'] as $key=>$cod_loc){
									echo'<tr>
											<td style="text-align:center">
												<input type="hidden" id="codigo" name="codigo[]" value="'.$cod_loc.'" class="added resumen" readonly="readonly" size="2" />
												<input type="hidden" name="row[]" class="added" value="'.$_POST['row'][$key].'" />
												<input type="hidden" name="col[]" class="added" value="'.$_POST['col'][$key].'" />
												<input type="text" id="chair" name="chair[]" value="'.$_POST['chair'][$key].'" class="added resumen" readonly="readonly" size="15" />
											</td>
											<td style="text-align:center"><input type="text" id="des" name="des[]" value="'.$_POST['des'][$key].'" class="added resumen" readonly="readonly" size="15" /></td>
											<td style="text-align:center"><input type="text" id="num" name="num[]" value="'.$_POST['num'][$key].'" class="added resumen" readonly="readonly" size="2" /></td>
											<td style="text-align:center"><input type="text" id="pre" name="pre[]" value="'.$_POST['pre'][$key].'" class="added resumen" readonly="readonly" size="5" /></td>
											<td style="text-align:center" id="filas"><input type="text" id="tot" name="tot[]" value="'.$_POST['tot'][$key].'" class="added resumen" readonly="readonly" size="5" /></td>
										</tr>';
										$suma += $_POST['tot'][$key];
										$totalpagar = number_format($suma, 2,'.','');
										$cant_bol +=  $_POST['num'][$key];
									}
								}
							?>
							</table>
						</form>
					</div>
					<div class="modal-footer">
					<?php
						if(isset($_POST['codigo'])){
					?>
						<button type="button" class="btn btn-primary" onclick="aceptarLogin()">Aceptar</button>
					<?php
					}else{
					?>
						<button type="button" class="btn btn-primary" onclick="aceptarLogin2()">Aceptar</button>
					<?php
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function onSignIn(googleUser) {
		var profile = googleUser.getBasicProfile();
		// alert(profile)
		$('#ID').html('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
		$('#Name').html('Name: ' + profile.getName());
		$('#Image').attr('src',profile.getImageUrl());
		$('#Email').html('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
		
		
		var id_gmail = profile.getId();
		var email_gmail =  profile.getEmail();
		var nombre = profile.getName();
		var birthday = '';
		var gender = '';
		
		
		$.post("autenticaGmail.php",{ 
			id_gmail : id_gmail , email_gmail : email_gmail , nombre : nombre , birthday : birthday , gender : gender
		}).done(function(data){
			if(pos == 1){
				accion ='?modulo=miperfil&ident=1&con='+con;
				$('#form').attr('action',accion);
				$('#form').submit();
			}else{
				accion ='?modulo=miperfil';
				$('#form').attr('action',accion);
				$('#form').submit();
			}
			
		});
	}
	function signOut() {
		var auth2 = gapi.auth2.getAuthInstance();
		auth2.signOut().then(function () {
		  console.log('User signed out.');
		});
	}
	function goBack() {
		var conId = $('#dataCon').val();
		window.location.href = "?modulo=des_concierto&con="+conId;
	}
	var conId = $('#dataCon').val();
	function ingresar() {  
		FB.login(function(response){  
			validarUsuario();  
		}, {scope: 'email'});  
	}  
	function validarUsuario() {
		var con = $('#con').val();
		var pos = $('#pos').val();
		FB.getLoginStatus(function(response) {  
			if(response.status == 'connected') {  
				FB.api(
					'/me',
					'GET',
					{"fields":"id,name,birthday,email,gender,permissions"},
					function(response) {
						var id_face = response.id;
						var email_face = response.email;
						var nombre = response.name;
						var birthday = response.birthday;
						var gender = response.gender;
						$('#nombreUsuFace').html('!!!  ' + nombre);
						$('#nombreUsuEmail').html('!!!  ' + email_face);
						$('#nombreUsuPass').html('!!!  ' + id_face);
						$('#fecha').html('!!!  ' + birthday);
						$('#sexo').html('!!!  ' + gender);
						$.post("autenticaFb.php",{ 
							id_face : id_face , email_face : email_face , nombre : nombre , birthday : birthday , gender : gender
						}).done(function(data){
							if(pos == 1){
								accion ='?modulo=miperfil&ident=1&con='+con;
								$('#form').attr('action',accion);
								$('#form').submit();
							}else{
								accion ='?modulo=miperfil';
								$('#form').attr('action',accion);
								$('#form').submit();
							}
							
						});
					}
				);
			} else if(response.status == 'not_authorized') {  
				alert('Debes autorizar la app!');  
			} else {  
				alert('Debes ingresar a tu cuenta de Facebook!');  
			}  
		});  
   }
	function aceptarLogin(){
		var con = $('#con').val();
		accion ='?modulo=comprar&con='+con;
		$('#form').attr('action',accion);
		$('#form').submit();
	}
	
	function aceptarLogin2(){
		var con = $('#con').val();
		accion ='?modulo=comprar&con='+con;
		$('#form').attr('action',accion);
		$('#form').submit();
	}
$(document).ready(function(){
	$('#obtener_boleto').on('change',function(){
		var envio = $('#obtener_boleto').val();
		if(envio == 'Domicilio'){
			$('#dir').prop('placeholder','Obligatorio');
			$('#dir').removeClass('inputopcional');
			$('#dir').addClass('inputlogin');
			$('#telfijo').prop('placeholder','Obligatorio');
			$('#telfijo').removeClass('inputopcional');
			$('#telfijo').addClass('inputlogin');
			$('#provincia').removeClass('inputopcional');
			$('#provincia').addClass('inputlogin');
			$('#otraProvincia').removeClass('inputopcional');
			$('#otraProvincia').addClass('inputlogin');
			$('#ciudad').removeClass('inputopcional');
			$('#ciudad').addClass('inputlogin');
			$('#otraCiudad').removeClass('inputopcional');
			$('#otraCiudad').addClass('inputlogin');
		}else{
			$('#dir').prop('placeholder','Opcional');
			$('#dir').removeClass('inputlogin');
			$('#dir').addClass('inputopcional');
			$('#telfijo').prop('placeholder','Opcional');
			$('#telfijo').removeClass('inputlogin');
			$('#telfijo').addClass('inputopcional');
			$('#provincia').removeClass('inputlogin');
			$('#provincia').addClass('inputopcional');
			$('#otraProvincia').removeClass('inputlogin');
			$('#otraProvincia').addClass('inputopcional');
			$('#ciudad').removeClass('inputlogin');
			$('#ciudad').addClass('inputopcional');
			$('#otraCiudad').removeClass('inputlogin');
			$('#otraCiudad').addClass('inputopcional');
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

$('#provincia').on('change',function (){
	var otraCiudad = $('#provincia').val();
	if(otraCiudad == 23){
		$('#provincia').fadeOut('slow');
		$('#otraprov').delay(600).fadeIn('slow');
	}else{
		$('#otraprov').fadeOut('slow');
		$('#provincia').delay(600).fadeIn('slow');
	}
});

function cancelarProvincia(){
	$('#provincia').val(0);
	$('#otraprov').fadeOut('slow');
	$('#provincia').delay(600).fadeIn('slow');
	$('#otraProvincia').val('');
}

function cancelarCiudad(){
	$('#ciudad').val(0);
	$('#otraciu').fadeOut('slow');
	$('#ciudad').delay(600).fadeIn('slow');
	$('#otraCiudad').val('');
}
	
function ValidarDocumento(){
	var valor = $('#documento').val();
	if(valor[0] == 'p'||valor[0] == 'P'){
		pasaporte();
	}else{
		ValidarCedula();
	}
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
		$('html, body').animate({ scrollTop: 0 }, 'slow');
		$('#mail').val('');
		$('#alerta6').fadeIn();
		$('#alerta6').delay(3000).fadeOut();
	}
}

function validarValores(valor){
	if(!$('#alerta1').is(':hidden')){
		$('#alerta1').fadeOut();
	}else if(!$('#alerta3').is(':hidden')){
		$('#alerta3').fadeOut();
	}
	$('.datosbd').each(function(){
		// var documento = $(this).find('.documentobd').val();
		// if(valor == documento){
			// $('html, body').animate({ scrollTop: 0 }, 'slow');
			// $('#alerta1').fadeIn();
			// $('#documento').val('');
			// return false;
		// }
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

function enviar(){
	var nombres = $('#nombre').val();
	var documento = $('#documento').val();
	var anio = $('#anio').val();
	var mes = $('#mes').val();
	var dia = $('#dia').val();
	var genero = $('#genero').val();
	var mail = $('#mail').val();
	var pass = $('#password').val();
	var movil = $('#tmov').val();
	var fpago = $('#pago').val();
	var oboleto = $('#obtener_boleto').val();
	var provincia = $('#provincia').val();
	if(provincia == 23){
		provincia = $('#otraProvincia').val();
	}
	var ciudad = $('#ciudad').val();
	if(ciudad == 17){
		ciudad = $('#otraCiudad').val();
	}
	var direccion = $('#dir').val();
	var fijo = $('#telfijo').val();
	if(oboleto == 'Domicilio'){
		if((nombres == '') || (documento == '') || (anio == 0) || (mes == 0) || (dia == 0) || (genero == 0) || (mail == '') || (pass == '') || (movil == '') || (fpago == 0) || (oboleto == 0) || (provincia == 0) || (ciudad == 0) || (direccion == '') || (fijo == '')){
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			$('#alerta5').fadeIn();
			setTimeout("$('#alerta5').fadeOut();",3000);
		}else{
			$('#aceptar').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('subpages/newaccountok.php',{
				nombres : nombres, documento : documento, anio : anio, mes : mes, dia : dia, genero : genero, mail : mail, pass : pass, movil : movil, fpago : fpago,
				oboleto : oboleto, provincia : provincia, ciudad : ciudad, direccion : direccion, fijo : fijo
			}).done(function(data){
				if($.trim(data) == 'ok'){
					$('#bienvenida').modal('show');
					$('#wait').fadeOut();
				}
			});
		}
	}else{
		if((nombres == '') || (documento == '') || (anio == 0) || (mes == 0) || (dia == 0) || (genero == 0) || (mail == '') || (pass == '') || (movil == '') || (fpago == 0) || (oboleto == 0)){
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			$('#alerta5').fadeIn();
			setTimeout("$('#alerta5').fadeOut();",3000);
		}else{
			$('#aceptar').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('subpages/newaccountok.php',{
				nombres : nombres, documento : documento, anio : anio, mes : mes, dia : dia, genero : genero, mail : mail, pass : pass, movil : movil, fpago : fpago,
				oboleto : oboleto
			}).done(function(data){
				if($.trim(data) == 'ok'){
					$('#bienvenida').modal('show');
					$('#wait').fadeOut();
				}
			});
		}
	}
}
</script>