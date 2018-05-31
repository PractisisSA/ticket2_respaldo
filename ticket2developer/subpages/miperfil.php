<?php 
	include("controlusuarios/seguridadusuario.php");
	
	$gbd = new DBConn();
	
	$sql = "SELECT * FROM Cliente WHERE idCliente = ?";
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute(array($_SESSION['id']));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	$fechanac = $row['strFechaNanC'];
	$expfecha = explode('-',$fechanac);
	
	$anio = date('Y');
	$anio = $anio - 10;
	
	if(isset($_REQUEST['ident'])){
		echo "<input type = 'hidden' id = 'ident' value = '1' />";
		echo "<input type = 'hidden' id = 'con' value = '".$_REQUEST['con']."' />";
	}else{
		echo "<input type = 'hidden' id = 'ident' value = '0' />";
	}
?>
<div style="background-color:#282d2b; margin:10px 20px -10px 20px; text-align:center;">
	<div class="breadcrumb">
		<a  id="chooseseat" onclick = 'verMapaAbajo();' style = 'cursor:pointer;'>Escoge tu asiento</a>
		<a class="active" id="identification" href="#" onclick="security()">Identificate</a>
		<a id="buy" href="#" onclick="security()">Resumen de Compra</a>
		<a id="pay" href="#" onclick="security()">Pagar</a>
		<a id="confirmation" href="#" onclick="security()">Confirmaci&oacute;n</a>
	</div>
</div>
<div class="divborderexterno" style="margin:-10px -10px 10px; border:none;">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; margin-right:60%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Tu Perfil</strong>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 40px 40px; position:relative; padding-left:40px;">
				<div class="row">
					<div class="col-lg-10">
						<div id="confirm" style="display:none;" class="alert alert-info" role="alert">
							<h4>
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;
								Tus datos se están guardando...
							</h4>
						</div>
					</div>
				</div>
				<div style="background-color:#EC1867; margin:0px -42px 0px 30%; padding:10px; font-size:16px; color:#fff; position:relative;z-index:3000;">
					El "Documento de Identidad", Servira para validar todas tus compras.
					<div class="tra_comprar_concierto"></div>
					<div class="par_comprar_concierto"></div>
				</div>	
				<div class="row">
					<div class="col-lg-5">
						<h4 style="color:#fff;">Nombres y Apellidos</h4>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							</span>
							<input id="nombre" type="text" class="form-control inputlogin" aria-describedby="basic-addon1" value="<?php echo $row['strNombresC'];?>" />
						</div>
					</div>
					<div class="col-lg-5">
						<h4 style="color:#fff;">Documento de Identidad</h4>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
							</span>
							<input type="text" class="form-control inputlogin" aria-describedby="basic-addon1" id = 'cedulafb' style="color:#000;" value="<?php echo $row['strDocumentoC'];?>" />
						</div>
					</div>
					<div class="col-lg-5"></div>
					<div class="col-lg-5">
						<span class="label label-info pull-right">Si no cuenta con un "Documento de Identificación" Ecuatoriano<br> porfavor ingrese su número de pasaporte antecedido de la letra "P"</span>
					</div>
				</div>
				
				<div class="row" style = 'display:none;'>
					<div class="col-lg-5">
						<h4 style="color:#fff;">Genero</h4>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							</span>
							<select id="genero" class="form-control inputlogin">
								<?php if($row['strGeneroC'] == 'Agregar Genero'){?>
								<option value="0"><?php echo $row['strGeneroC'];?></option>
								<option value="Masculino">Masculino</option>
								<option value="Femenino">Femenino</option>
								<?php }else if($row['strGeneroC'] == 'Masculino'){?>
								<option value="<?php echo $row['strGeneroC'];?>"><?php echo $row['strGeneroC'];?></option>
								<option value="Femenino">Femenino</option>
								<?php }else{?>
								<option value="<?php echo $row['strGeneroC'];?>"><?php echo $row['strGeneroC'];?></option>
								<option value="Masculino">Masculino</option>
								<?php }?>
							</select>
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-lg-5">
						<h4 style="color:#fff;">Usuario(E-mail)</h4>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
							</span>
							<input type="text" class="form-control inputlogin" aria-describedby="basic-addon1" readonly="readonly" style="color:#000;" value="<?php echo $row['strMailC'];?>" />
						</div>
					</div>
					<div class="col-lg-5">
						<h4 style="color:#fff;">Teléfono Móvil</h4>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
							</span>
							<input id="movil" type="text" class="form-control inputlogin" aria-describedby="basic-addon1" value="<?php echo $row['intTelefonoMovC'];?>" />
						</div>
					</div>
				</div>
				<div style="background-color:#EC1867; margin:0px -42px 0px 30%; padding:10px; font-size:16px; color:#fff; position:relative;z-index:3000;">
					El "E-mail", Servira para que recibas notificaciones de todas tus compras o reservas y para el ingreso a TICKETFACIL.
					<div class="tra_comprar_concierto"></div>
					<div class="par_comprar_concierto"></div>
				</div>
				<div class="row" style = 'display:none;'>
					<div class="col-lg-5">
						<h4 style="color:#fff;">Forma de Pago</h4>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
							</span>
							<select id="form_pago" name="form_pago" class="inputlogin form-control">
								<?php if($row['strFormPagoC'] == 1){?>
								<option value="<?php echo $row['strFormPagoC'];?>">Tarjeta de Crédito</option>
								<option value="2">Depósito Bancario</option>
								<option value="3">Punto de Venta</option>
								<?php }else if($row['strFormPagoC'] == 2){?>
								<option value="<?php echo $row['strFormPagoC'];?>">Depósito Bancario</option>
								<option value="1">Tarjeta de Crédito</option>
								<option value="3">Punto de Venta</option>
								<?php }else if($row['strFormPagoC'] == 3){?>
								<option value="<?php echo $row['strFormPagoC'];?>">Punto de Venta</option>
								<option value="1">Tarjeta de Crédito</option>
								<option value="2">Depósito Bancario</option>
								<?php }elseif($row['strFormPagoC'] == 0){
								?>
									<option value="3">Punto de Venta</option>
									<option value="1">Tarjeta de Crédito</option>
									<option value="2">Depósito Bancario</option>
								<?php
								}?>
							</select>
						</div>
					</div>
					<div class="col-lg-5">
						<h4 style="color:#fff;">Forma de Obtener tus Boletos</h4>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-share" aria-hidden="true"></span>
							</span>
							<select id="envio" name="envio" class="inputlogin form-control">
								<?php if($row['strEnvioC'] == 'correo'){?>
								<option value="<?php echo $row['strEnvioC'];?>">Correo Eletrónico</option>
								<option value="Domicilio">Al Domicilio</option>
								<option value="p_venta">Retirar en Punto de Venta</option>
								<?php }else if($row['strEnvioC'] == 'Domicilio'){?>
								<option value="<?php echo $row['strEnvioC'];?>">Al Domicilio</option>
								<option value="correo">Correo Electr&oacute;nico</option>
								<option value="p_venta">Retirar en Punto de Venta</option>
								<?php }else if($row['strEnvioC'] == 'p_venta'){?>
								<option value="<?php echo $row['strEnvioC'];?>">Retirar en Punto de Venta</option>
								<option value="correo">Correo Electr&oacute;nico</option>
								<option value="Domicilio">Al Domicilio</option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-5" style = 'display:none;'>
						<h4 style="color:#fff;">Dirección</h4>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
							</span>
							<?php if(($row['strDireccionC'] == 'Agregar Direccion') || ($row['strDireccionC'] == '')){?>
							<input id="dir" type="text" class="form-control inputlogin" aria-describedby="basic-addon1" placeholder="<?php echo $row['strDireccionC'];?>" />
							<?php }else{?>
							<input id="dir" type="text" class="form-control inputlogin" aria-describedby="basic-addon1" value="<?php echo $row['strDireccionC'];?>" />
							<?php }?>
						</div>
					</div>
					<div class="col-lg-5">
						<h4 style="color:#fff;">Fecha de Nacimiento</h4>
						<div class="row">
							<div class="col-xs-3" style="margin-top:0px;">
								<select id="anio" name="anio" class="inputlogin form-control">
									<?php 
									for($i = $anio; $i > 1930; $i--){
										if($i == $expfecha[0]){
											$select = 'selected';
										}else{
											$select = '';
										}
									?>
									<option <?php echo $select;?> value="<?php echo $i;?>"><?php echo $i;?></option>
									<?php }?>
								</select>
							</div>
							<div class="col-xs-4" style="margin-top:0px;">
								<select id="mes" name="mes" class="inputlogin form-control">
									<?php 
									for($k = 1; $k<=12; $k++){
										if($k == $expfecha[1]){
											$select2 = 'selected';
										}else{
											$select2 = '';
										}
										if($k == 1){
											echo '<option '.$select2.' value="01">Enero</option>';
										}else if($k == 2){
											echo '<option '.$select2.' value="02">Febrero</option>';
										}else if($k == 3){
											echo '<option '.$select2.' value="03">Marzo</option>';
										}else if($k == 4){
											echo '<option '.$select2.' value="04">Abril</option>';
										}else if($k == 5){
											echo '<option '.$select2.' value="05">Mayo</option>';
										}else if($k == 6){
											echo '<option '.$select2.' value="06">Junio</option>';
										}else if($k == 7){
											echo '<option '.$select2.' value="07">Julio</option>';
										}else if($k == 8){
											echo '<option '.$select2.' value="08">Agosto</option>';
										}else if($k == 9){
											echo '<option '.$select2.' value="09">Septiembre</option>';
										}else if($k == 10){
											echo '<option '.$select2.' value="10">Octubre</option>';
										}else if($k == 11){
											echo '<option '.$select2.' value="11">Noviembre</option>';
										}else if($k == 12){
											echo '<option '.$select2.' value="12">Diciembre</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="col-xs-3" style="margin-top:0px;">
								<select id="dia" name="dia" class="inputlogin form-control">
									<option value="0">Día</option>
									<?php for($j = 1; $j <= 31; $j++){
										if($j == $expfecha[2]){
											$selec3 = 'selected';
										}else{
											$selec3 = '';
										}
										?>
									<option <?php echo $selec3;?> value="<?php echo $j;?>"><?php echo $j;?></option>
									<?php }?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-lg-5">
						<h4 style="color:#fff;">Teléfono Fijo</h4>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
							</span>
							<?php if(($row['strTelefonoC'] == 'Agregar Numero') || ($row['strTelefonoC'] == '')){?>
							<input id="fijo" type="text" class="form-control inputlogin" aria-describedby="basic-addon1" placeholder="<?php echo $row['strTelefonoC'];?>" />
							<?php }else{?>
							<input id="fijo" type="text" class="form-control inputlogin" aria-describedby="basic-addon1" value="<?php echo $row['strTelefonoC'];?>" />
							<?php }?>
						</div>
					</div>
				</div>
				<div class="row" style = 'display:none;'>
					<div class="col-lg-5">
						<h4 style="color:#fff;">Provincia</h4>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
							</span>
							<?php if($row['strProvinciaC'] == 'Agregar Provincia'){?>
							<select class="inputlogin form-control" id="provincia">
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
								<input type="text" class="form-control inputlogin" placeholder="Provincia..." id="otraProvincia" aria-describedby="basic-addon1" autocomplete="off" onkeydown="justText(event,this)">
								<span class="input-group-addon" id="basic-addon1" title="Cancelar" onclick="cancelarProvincia()" style="cursor:pointer;">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</span>
							</div>
							<?php }else{?>
							<select id="provincia" class="inputlogin form-control">
								<?php 
								for($a = 1; $a<=22; $a++){
									if($a == $row['strProvinciaC']){
										$selecta = 'selected';
									}else{
										$selecta = '';
									}
									if($a == 1){
										echo '<option '.$selecta.' value="1">Azuay</option>';
									}else if($a == 2){
										echo '<option '.$selecta.' value="2">Bolivar</option>';
									}else if($a == 3){
										echo '<option '.$selecta.' value="3">Cañar</option>';
									}else if($a == 4){
										echo '<option '.$selecta.' value="4">Carchi</option>';
									}else if($a == 5){
										echo '<option '.$selecta.' value="5">Chimborazo</option>';
									}else if($a == 6){
										echo '<option '.$selecta.' value="6">Cotopaxi</option>';
									}else if($a == 7){
										echo '<option '.$selecta.' value="7">El Oro</option>';
									}else if($a == 8){
										echo '<option '.$selecta.' value="8">Esmeraldas</option>';
									}else if($a == 9){
										echo '<option '.$selecta.' value="9">Guayas</option>';
									}else if($a == 10){
										echo '<option '.$selecta.' value="10">Imbabura</option>';
									}else if($a == 11){
										echo '<option '.$selecta.' value="11">Loja</option>';
									}else if($a == 12){
										echo '<option '.$selecta.' value="12">Los Ríos</option>';
									}else if($a == 13){
										echo '<option '.$selecta.' value="13">Manabí</option>';
									}else if($a == 14){
										echo '<option '.$selecta.' value="14">Morona Santiago</option>';
									}else if($a == 15){
										echo '<option '.$selecta.' value="15">Napo</option>';
									}else if($a == 16){
										echo '<option '.$selecta.' value="16">Orellana</option>';
									}else if($a == 17){
										echo '<option '.$selecta.' value="17">Paztaza</option>';
									}else if($a == 18){
										echo '<option '.$selecta.' value="18">Pichincha</option>';
									}else if($a == 19){
										echo '<option '.$selecta.' value="19">Santa Elena</option>';
									}else if($a == 20){
										echo '<option '.$selecta.' value="20">Santo Domingo de los Ts&aacute;chilas</option>';
									}else if($a == 21){
										echo '<option '.$selecta.' value="21">Tungurahua</option>';
									}else if($a == 22){
										echo '<option '.$selecta.' value="22">Zamora Chinchipe</option>';
									}
								}
								?>
							</select>
							<?php }?>
						</div>
					</div>
					<div class="col-lg-5">
						<h4 style="color:#fff;">Ciudad</h4>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
							</span>
							<?php if($row['strCiudadC'] == 'Agregar Ciudad'){?>
							<select class="inputlogin form-control" id="ciudad">
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
								<input type="text" class="form-control inputlogin" placeholder="Ciudad..." id="otraCiudad" aria-describedby="basic-addon1" autocomplete="off" onkeydown="justText(event,this)">
								<span class="input-group-addon" id="basic-addon1" title="Cancelar" onclick="cancelarCiudad()" style="cursor:pointer;">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</span>
							</div>
							<?php }else{?>
							<select id="ciudad" class="inputlogin form-control">
								<?php 
								for($b = 1; $b<=16; $b++){
									if($b == $row['strCiudadC']){
										$selectb = 'selected';
									}else{
										$selectb = '';
									}
									if($b == 1){
										echo '<option '.$selectb.' value="1">Ambato</option>';
									}else if($b == 2){
										echo '<option '.$selectb.' value="2">Cuenca</option>';
									}else if($b == 3){
										echo '<option '.$selectb.' value="3">Esmeraldas</option>';
									}else if($b == 4){
										echo '<option '.$selectb.' value="4">Guaranda</option>';
									}else if($b == 5){
										echo '<option '.$selectb.' value="5">Guayaquil</option>';
									}else if($b == 6){
										echo '<option '.$selectb.' value="6">Ibarra</option>';
									}else if($b == 7){
										echo '<option '.$selectb.' value="7">Latacunga</option>';
									}else if($b == 8){
										echo '<option '.$selectb.' value="8">Loja</option>';
									}else if($b == 9){
										echo '<option '.$selectb.' value="9">Machala</option>';
									}else if($b == 10){
										echo '<option '.$selectb.' value="10">Portoviejo</option>';
									}else if($b == 11){
										echo '<option '.$selectb.' value="11">Puyo</option>';
									}else if($b == 12){
										echo '<option '.$selectb.' value="12">Quito</option>';
									}else if($b == 13){
										echo '<option '.$selectb.' value="13">Santo Domingo</option>';
									}else if($b == 14){
										echo '<option '.$selectb.' value="14">Riobamba</option>';
									}else if($b == 15){
										echo '<option '.$selectb.' value="15">Tena</option>';
									}else if($b == 16){
										echo '<option '.$selectb.' value="16">Tulcán</option>';
									}
								}
								?>
							</select>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="row" style="text-align:center; padding:40px 20px;">
					<div class="col-lg-11">
						<button id="guardar" class="btndegradate" onclick="guardar()">GUARDAR</button>
						<img src="imagenes/loading.gif" style="max-width:70px; display:none;" id="wait" />
					</div>
				</div>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		</div>
		<div class="modal fade" id="alerta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;
							Tu "NOMBRE" ó tu "TELÉFONO MÓVIL" no puede estar vacio.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
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
<script>
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

function guardar(){
	var ident = $('#ident').val();
	var con = $('#con').val();
	var id = <?php echo $_SESSION['id'];?>;
	var nombre = $('#nombre').val();
	var genero = $('#genero').val();
	if(genero == 0){
		genero = '';
	}
	var cedulafb = $('#cedulafb').val();
	var fechanac = $('#anio').val()+'-'+$('#mes').val()+'-'+$('#dia').val();
	var movil = $('#movil').val();
	var forma = $('#form_pago').val();
	var envio = $('#envio').val();
	var dir = $('#dir').val();
	var fijo = $('#fijo').val();
	var provincia = $('#provincia').val();
	var ciudad = $('#ciudad').val();
	if((nombre == '') || (movil == '')){
		$('#alerta').modal('show');
	}else{
		$('#guardar').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/guardarperfil.php',{
			id : id, nombre : nombre, genero : genero, fechanac : fechanac, movil : movil, forma : forma, envio : envio, 
			dir : dir, fijo : fijo, provincia : provincia, ciudad : ciudad , cedulafb : cedulafb
		}).done(function(response){
			if($.trim(response) == 'ok'){
				$('#confirm').fadeIn();
				$('html,body').animate({scrollTop: 0},'slow');
				if(ident == 0){
					setTimeout("window.location = '';",3000);
				}else{
					accion ='?modulo=comprar&con='+con;
					$('#form').attr('action',accion);
					$('#form').submit();
				}
				
			}
		});
	}
}
</script>