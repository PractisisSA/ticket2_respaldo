<?php
	include("controlusuarios/seguridadusuario.php");
	
	$gbd = new DBConn();
	
	$concierto = $_GET['evento'];
	$id_cliente = $_SESSION['id'];
	$nombre_cliente = $_SESSION['username'];
	$documento_cliente = $_SESSION['userdoc'];
	$ciudad_cliente = $_SESSION['userciudad'];
	$prov_cliente = $_SESSION['userprov'];
	$movil_cliente = $_SESSION['usertel'];
	$fijo_cliente = $_SESSION['usertelf'];
	$mail_cliente = $_SESSION['usermail'];
	$direccion_cliente = $_SESSION['userdir'];
	$forma_pago = $_SESSION['formapago'];
	$forma_envio = $_SESSION['formenvio'];
	$fecha_nac = $_SESSION['fech_nac'];
	$genero_cliente = $_SESSION['genero'];
	
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
?>
<div style="background-color:#282B2D; margin:10px 20px 0px 20px; text-align:center;">
	<div class="breadcrumb">
		<a id="chooseseat" href="?modulo=des_concierto&con=<?php echo $idcon;?>">Escoge tu asiento</a>
		<a class="active" id="identification" href="#" onclick="security()">Identificate</a>
		<a id="buy" href="#" onclick="security()">Resumen de Compra</a>
		<a id="pay" href="#" onclick="security()">Pagar</a>
		<a id="confirmation" href="#" onclick="security()">Confirmaci&oacute;n</a>
	</div>
</div>
<input type="hidden" id="CuentaAtras" style="border:none;background:url(http://subtlepatterns.com/patterns/otis_redding.png);"/>
<input type="hidden" id="con" value="<?php echo $concierto;?>" />
<div class="divborderexterno" style="margin:-10px -10px 10px; border:none;">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; margin-right:60%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Tus Datos</strong>
			</div>
			<form id="form_modificar_cliente" method="post">
				<?php 
					if(isset($_POST['codigo'])){
						echo '<table style = "display:none;">';
						foreach($_POST['codigo'] as $key=>$cod_loc){
							echo'<tr class="datos_compra">
								<td><input type="text" class="codigo" name="codigo" value="'.$cod_loc.'" id = "codigo" /></td>
								<td><input type="text" class="row" name="row" value="'.$_POST['row'][$key].'" /></td>
								<td><input type="text" class="col" name="col" value="'.$_POST['col'][$key].'" /></td>
								<td><input type="text" class="chair" name="chair" value="'.$_POST['chair'][$key].'" /></td>
								<td><input type="text" class="des" value="'.$_POST['des'][$key].'"/></td>
								<td><input type="text" class="num" value="'.$_POST['num'][$key].'" /></td>
								<td><input type="text" class="pre" value="'.$_POST['pre'][$key].'"/></td>
								<td><input type="text" class="tot" value="'.$_POST['tot'][$key].'" /></td>
								<td><input type="text" class="id_desc" value="'.$_POST['id_desc'][$key].'" /></td>
								<td><input type="text" class="val_desc" value="'.$_POST['val_desc'][$key].'" /></td>
								<td><input type="text" class="es_para_membresia" value="'.$_POST['es_para_membresia'][$key].'" /></td>
								<td><input type="text" class="tipo" value="'.$_POST['tipo'][$key].'" /></td>
							</tr>';
							
							$codigo = $cod_loc;
							$row=$_POST['row'][$key];
							$col=$_POST['col'][$key];
							$chair=$_POST['chair'][$key];
							$des=$_POST['des'][$key];
							$num=$_POST['num'][$key];
							$pre=$_POST['pre'][$key];
							$tot=$_POST['tot'][$key];
							
							$id_desc=$_POST['id_desc'][$key];
							$val_desc=$_POST['val_desc'][$key];
							$es_para_membresia=$_POST['es_para_membresia'][$key];
							$tipo=$_POST['tipo'][$key];
							
							$compras[]=array("codigo"=>$codigo,"row"=>$row,"col"=>$col ,"chair"=>$chair,"des"=>$des,"num"=>$num,"pre"=>$pre,"tot"=>$tot,"id_desc"=>$id_desc,"val_desc"=>$val_desc,"es_para_membresia"=>$es_para_membresia,"tipo"=>$tipo);
							//$totalpago += $_POST['pre'][$key];
						}
						
						$_SESSION['boletos_asignados'] = ($compras);
						// print_r(json_encode($_SESSION['boletos_asignados']));
						
						echo '</table>';
					}
				?>
				<div style="background-color:#00ADEF; margin:20px -42px 40px 40px; position:relative;">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>*Nombres:</strong></h4>
							<input type="text" id="nombre_cli" name="nombre_cli" onkeydown="justText(event,this)" autocomplete="off" value="<?php echo $nombre_cliente;?>" class="datos_cliente inputlogin form-control" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>*Documento:</strong></h4>
							<input type="text" id="doc_cli" name="doc_cli" value="<?php echo $documento_cliente;?>" class="datos_cliente inputlogin form-control" onchange="ValidarDocumento()" onkeyup="validarValores(this.value);" autocomplete="off" onkeydown="justInt(event,this);" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>*E-mail:</strong></h4>
							<input type="text" id="mail_cli" name="mail_cli" value="<?php echo $mail_cliente;?>" class="datos_cliente inputlogin form-control" onkeyup="validarValores(this.value);" autocomplete="off" />
						</div>
					</div>
					<div class="row" style = 'display:;'>
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>*Fecha de Nacimiento:</strong></h4>
							<input type="text" id="fecha_cli" name="fecha_cli" value="2017-01-01" class="datos_cliente inputlogin form-control" />
						</div>
					</div>
					<div class="row" style = 'display:none;'>
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>*Genero:</strong></h4>
							<select id="genero_cli" name="genero_cli" class="datos_cliente inputlogin form-control">
								<option value="masculino">Masculino</option>
								<option value="Femenino">Femenino</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>Teléfono Fijo:</strong></h4>
							<input type="text" id="fijo" name="fijo" maxlength="9" placeholder="022222222" value="<?php echo $fijo_cliente;?>" class="datos_cliente inputlogin form-control" onkeydown="justInt(event,this)" autocomplete="off" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>Teléfono Móvil:</strong></h4>
							<input type="text" id="movil" name="movil" maxlength="10" placeholder="0999999999" value="<?php echo $movil_cliente;?>" class="datos_cliente inputlogin form-control" onkeydown="justInt(event,this)" autocomplete="off" />
						</div>
					</div>
					<div class="row" style = 'display:none;'>
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>*Forma de Pago:</strong></h4>
							<select id="form_pago" name="form_pago" class="datos_cliente inputlogin form-control">
								<option value="tarjeta" selected>Tarjeta de Crédito</option>
								<option value="2">Depósito Bancario</option>
								<option value="3">Punto de Venta</option>
							</select>
						</div>
					</div>
					<div class="row" style = 'display:none;'>
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>*Forma de Envio:</strong></h4>
							<select id="envio" name="envio" class="datos_cliente inputlogin form-control">
								<option value="domicilio" selected >Al Domicilio</option>
								<option value="correo">Correo Electr&oacute;nico</option>
								<option value="p_venta">Retirar en Punto de Venta</option>
							</select>
						</div>
					</div>
					<div class="row" style = 'display:none;'>
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>*Dirección:</strong></h4>
							<input type="text" id="dir_cli" name="dir_cli" value="la direccion" class="datos_cliente inputlogin form-control" />
						</div>
					</div>
					<div class="row" style = 'display:none;'>
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>Ciudad:</strong></h4>
							<div class="input-group" id="ciubd">
								<input type="text" id="ciudad_cli" name="ciudad_cli" value="<?php echo $ciudad_cliente;?>" class="form-control datos_cliente inputlogin" aria-describedby="basic-addon2" autocomplete="off">
								<span class="input-group-addon" id="basic-addon2" onclick="changeCiudad()" style="cursor:pointer;">Cambiar</span>
							</div>
							<div class="input-group" id="otraciu" style="display:none;">
								<select class="inputlogin form-control datos_cliente" id="ciudad" name="ciudad_cli">
									<option value="quito" selected>Seleccione...</option>
									<option value="Ambato">Ambato</option>
									<option value="Cuenca">Cuenca</option>
									<option value="Esmeraldas">Esmeraldas</option>
									<option value="Guaranda">Guaranda</option>
									<option value="Guayaquil">Guayaquil</option>
									<option value="Ibarra">Ibarra</option>
									<option value="Latacunga">Latacunga</option>
									<option value="Loja">Loja</option>
									<option value="Machala">Machala</option>
									<option value="Portoviejo">Portoviejo</option>
									<option value="Puyo">Puyo</option>
									<option value="Quito">Quito</option>
									<option value="Santo Doming">Santo Domingo</option>
									<option value="Riobamba">Riobamba</option>
									<option value="Tena">Tena</option>
									<option value="Tulcan">Tulc&aacute;n</option>
								</select>
								<span class="input-group-addon" id="basic-addon1" title="Cancelar" onclick="cancelarCiudad()" style="cursor:pointer;">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="row" style = 'display:none;'>
						<div class="col-lg-3"></div>
						<div class="col-lg-8">
							<h4 style="color:#fff;"><strong>Provincia:</strong></h4>
							<div class="input-group" id="provbd">
								<input type="text" id="prov_cli" name="prov_cli" value="<?php echo $prov_cliente;?>" class="datos_cliente inputlogin form-control" aria-describedby="basic-addon2" autocomplete="off">
								<span class="input-group-addon" id="basic-addon2" onclick="changeProvincia()" style="cursor:pointer;">Cambiar</span>
							</div>
							<div class="input-group" id="otraprov" style="display:none;">
								<select class="inputlogin form-control datos_cliente" id="prov" name="prov_cli" aria-describedby="basic-addon2">
									<option value="Pichincha" selected >Seleccione...</option>
									<option value="Azuay">Azuay</option>
									<option value="Bolivar">Bolivar</option>
									<option value="Canar">Ca&ntilde;ar</option>
									<option value="Carchi">Carchi</option>
									<option value="Chimborazo">Chimborazo</option>
									<option value="Cotopaxi">Cotopaxi</option>
									<option value="El Oro">El Oro</option>
									<option value="Esmeraldas">Esmeraldas</option>
									<option value="Guayas">Guayas</option>
									<option value="Imbabura">Imbabura</option>
									<option value="Loja">Loja</option>
									<option value="Los Rios">Los R&iacute;os</option>
									<option value="Manabi">Manab&iacute;</option>
									<option value="Morona Santiago">Morona Santiago</option>
									<option value="Napo">Napo</option>
									<option value="Orellana">Orellana</option>
									<option value="Paztaza">Paztaza</option>
									<option value="Pichincha">Pichincha</option>
									<option value="Santa Elena">Santa Elena</option>
									<option value="Santo Domingo de los Tsachilas">Santo Domingo de los Ts&aacute;chilas</option>
									<option value="Tungurahua">Tungurahua</option>
									<option value="Zamora Chinchipe">Zamora Chinchipe</option>
								</select>
								<span class="input-group-addon" id="basic-addon1" title="Cancelar" onclick="cancelarProvincia()" style="cursor:pointer;">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</span>
							</div>
						</div>
					</div>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div class="row" style="text-align:center; margin:20px 0px;">
					<div class="col-lg-12">
						<a id="modificar_cliente" class="btn_login" onclick="guardar()" style="text-decoration:none; cursor:pointer;"><strong>GUARDAR</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a id="cancelar" class="btn_login" onclick="cancelar()" style="text-decoration:none; cursor:pointer;"><strong>CANCELAR</strong></a>
					</div>
				</div>
			</form>
		</div>
		<div class="modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
					</div>
					<div class="modal-body">
						<h4 id="alerta1" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert">
								<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Los asientos seleccionados se han perdido, seleccionalos nuevamente.
							</div>
						</h4>
						<h4 id="alerta2" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Estas modificando tus datos, Guardalos o Cancela la edición.
							</div>
						</h4>
						<h4 id="alerta3" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;El tiempo de la transacción ha culminado, vuelve a escoger tus asientos.
							</div>
						</h4>
						<h4 id="alerta4" class="alertas" style="display:none;">
							<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;No puedes dejar campos vacios, por favor llenalos.
							</div>
						</h4>
						<h4 id="alerta5" class="alertas" style="display:none;">
							<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Error!</strong>&nbsp;El Documento de Identidad que ingreso es incorrecto.
							</div>
						</h4>
						<h4 id="alerta6" class="alertas" style="display:none;">
							<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;La información ingresada ya existe, es tuya?.
							</div>
						</h4>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" id="no" onclick="NOdocumento()">No</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarModal()">Aceptar</button>						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
// $(document).ready(function(){
	// $('.datos_cliente').prop('disabled',false);
// });
// $('#cancelar').on('click',function(){
	// $('.datos_cliente').prop('disabled',true);
	// $('#cancelar').prop('type','submit');
// });
function guardar(){
	var idConcierto = $('#con').val();
	var nombre = $('#nombre_cli').val();
	var documento = $('#doc_cli').val();
	var mail = $('#mail_cli').val();
	var fecha = $('#fecha_cli').val();
	var genero = $('#genero_cli').val();
	var fijo = $('#fijo').val();
	var movil = $('#movil').val();
	var pago = $('#form_pago').val();
	var envio = $('#envio').val();
	var dir = $('#dir_cli').val();
	if($('#otraciu').is(':visible')){
		var ciudad = $('#ciudad').val();
		$('#ciudad_cli').prop('disabled',true);
		$('#ciudad_cli').removeAttr('name');
	}else{
		var ciudad = $('#ciudad_cli').val();
		$('#ciudad').prop('disabled',true);
		$('#ciudad').removeAttr('name');
	}
	if($('#otraprov').is(':visible')){
		var provincia = $('#provincia').val();
		$('#prov_cli').prop('disabled',true);
		$('#prov_cli').removeAttr('name');
	}else{
		var provincia = $('#prov_cli').val();
		$('#provincia').prop('disabled',true);
		$('#provincia').removeAttr('name');
	}
	if((nombre == '') || (documento == '') || (mail == '') || (fijo == '') || (movil == '')){
		$('#alerta4').fadeIn();
		$('#aviso').modal('show');
	}else{
		
		$.post("subpages/Compras/actualizaCliente.php",{ 
			nombre : nombre , documento : documento , mail : mail , fecha : fecha , fijo : fijo , movil : movil 
		}).done(function(data){
			if(data == 1){
				alert('Perfil Actualizado con Exito')
				accion = '?modulo=comprar&evento='+idConcierto;
				$('#form_modificar_cliente').attr('action',accion);
				$('#form_modificar_cliente').submit();
			}	
		});
		
		
	}
}

function cancelar(){
	$('.datos_cliente').prop('disabled',true);
	$('#form_modificar_cliente').submit();
}

function security(){
	$('#alerta2').fadeIn();
	$('#aviso').modal('show');
}

var con = $('#con').val();
if(!document.getElementById('codigo')){
	$('#alerta1').fadeIn();
	$('#aviso').modal('show');
}

function changeCiudad(){
	$('#ciubd').fadeOut('slow');
	$('#otraciu').delay(600).fadeIn('slow');
}

function changeProvincia(){
	$('#provbd').fadeOut('slow');
	$('#otraprov').delay(600).fadeIn('slow');
}

function cancelarProvincia(){
	$('#prov').val(0);
	$('#otraprov').fadeOut('slow');
	$('#provbd').delay(600).fadeIn('slow');
}

function cancelarCiudad(){
	$('#ciudad').val(0);
	$('#otraciu').fadeOut('slow');
	$('#ciubd').delay(600).fadeIn('slow');
}

function validarValores(valor){
	$('.datosbds').each(function(){
		var documento = $(this).find('.documentobd').val();
		if(valor == documento){
			$('#alerta6').fadeIn();
			$('#no').fadeIn();
			$('#aviso').modal('show');
		}
		var mail = $(this).find('.mailbd').val();
		if(valor == mail){
			$('#alerta6').fadeIn();
			$('#no').fadeIn();
			$('#aviso').modal('show');
		}
	});
}

function aceptarModal(){
	if(!$('#alerta1').is(':hidden')){
		window.location = '?modulo=des_concierto&con='+con;
	}else if(!$('#alerta3').is(':hidden')){
		window.location = '?modulo=des_concierto&con='+con;
	}else if(!$('#alerta4').is(':hidden')){
		$('#ciudad_cli').prop('disabled',false);
		$('#ciudad_cli').attr('name','ciudad_cli');
		$('#ciudad').prop('disabled',false);
		$('#ciudad').attr('name','ciudad_cli');
		$('#prov_cli').prop('disabled',false);
		$('#prov_cli').attr('name','prov_cli');
		$('#provincia').prop('disabled',false);
		$('#prov_cli').attr('name','prov_cli');
	}
	$('.alertas').fadeOut();
	$('#aviso').modal('hide');
}

function NOdocumento(){
	$('#doc_cli').val('');
	$('#doc_cli').prop('placeholder','Ingresa Tu Documento de Identidad correcto...');
	$('#doc_cli').focus();
	$('#aviso').modal('hide');
	$('#alerta6').fadeOut();
	$('#no').fadeOut();
}

function ValidarDocumento(){
	var valor = $('#doc_cli').val();
	if(valor[0] == 'p'||valor[0] == 'P'){
		pasaporte();
	}else{
		ValidarCedula();
	}
}

function pasaporte(){
	var valor = $('#doc_cli').val();
	if(valor.length<3||valor.length>13){
		console.log('Pasaporte incorrecto');
		$('#doc_cli').val('');
		$('#alerta5').fadeIn();
		$('#aviso').modal('show');
		return false;
	}else{
		if(valor[0]=='p'||valor[0]=='P'){
			return true;
		}else{
			console.log('Pasaporte incorrecto');
			$('#doc_cli').val('');
			$('#alerta5').fadeIn();
			$('#aviso').modal('show');
			return false;
		}
	}
}

function ValidarCedula(){
	var numero = $('#doc_cli').val();
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
	$('#doc_cli').val('');
	$('#alerta5').fadeIn();
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
	$('#doc_cli').val('');
	$('#alerta5').fadeIn();
	$('#aviso').modal('show');
	return false;
	}
	/* El ruc de las empresas del sector publico terminan con 0001*/
	if ( numero.substr(9,4) != '0001' ){
	console.log('El ruc de la empresa del sector público debe terminar con 0001');
	$('#doc_cli').val('');
	$('#alerta5').fadeIn();
	$('#aviso').modal('show');
	return false;
	}
	}
	else if(pri == true){
	if (digitoVerificador != d10){
	console.log('El ruc de la empresa del sector privado es incorrecto.');
	$('#doc_cli').val('');
	$('#alerta5').fadeIn();
	$('#aviso').modal('show');
	return false;
	}
	if ( numero.substr(10,3) != '001' ){
	console.log('El ruc de la empresa del sector privado debe terminar con 001');
	$('#doc_cli').val('');
	$('#alerta5').fadeIn();
	$('#aviso').modal('show');
	return false;
	}
	}

	else if(nat == true){
	if (digitoVerificador != d10){
	console.log('El número de cédula de la persona natural es incorrecto.');
	$('#doc_cli').val('');
	$('#alerta5').fadeIn();
	$('#aviso').modal('show');
	return false;
	}
	if (numero.length >10 && numero.substr(10,3) != '001' ){
	console.log('El ruc de la persona natural debe terminar con 001');
	$('#doc_cli').val('');
	$('#alerta5').fadeIn();
	$('#aviso').modal('show');
	return false;
	}
	}
	return true;
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

var totalTiempo=200+200;
var timestampStart = new Date().getTime();
var endTime=timestampStart+(totalTiempo*1000);
var timestampEnd=endTime-new Date().getTime();
var tiempRestante=totalTiempo;

updateReloj();

function updateReloj() {
	var Seconds=tiempRestante;
	
	var Days = Math.floor(Seconds / 86400);
	Seconds -= Days * 86400;

	var Hours = Math.floor(Seconds / 3600);
	Seconds -= Hours * (3600);

	var Minutes = Math.floor(Seconds / 60);
	Seconds -= Minutes * (60);

	var TimeStr = ((Days > 0) ? Days + " dias " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds);
	//var TimeStr = LeadingZero(Hours+(Days*24)) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds);
	document.getElementById('CuentaAtras').innerHTML = TimeStr;
	if(endTime<=new Date().getTime())
	{
		document.getElementById('CuentaAtras').innerHTML = "00:00:00";
	}else{
		tiempRestante-=1;
		setTimeout("updateReloj()",1000);
	}
}

function LeadingZero(Time) {
	return (Time < 10) ? "0" + Time : + Time;
}
setTimeout("$('#alerta3').fadeIn(); $('#aviso').modal('show');",480000);
</script>