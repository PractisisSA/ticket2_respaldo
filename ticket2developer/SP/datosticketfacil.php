<?php 
	include("controlusuarios/seguridadSP.php");
	echo '<input type="hidden" id="data" value="6" />';
	
	$gbd = new DBConn();
	
	$select = "SELECT * FROM ticktfacil WHERE idticketFacil = ?";
	$slt = $gbd -> prepare($select);
	$slt -> execute(array(1));
	$row = $slt -> fetch(PDO::FETCH_ASSOC);
	
	$sucursales = "SELECT * FROM sucursal_empresa WHERE idempresaSE = ? AND estadoSE = ?";
	$suc = $gbd -> prepare($sucursales);
	$suc -> execute(array(1,'Activo'));
	$numsuc = $suc -> rowCount();
	echo '<input type="hidden" id="numsucursales" value="'.$numsuc.'" />';
?>
<style>
.readonly{
	color:#000;
}
</style>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 500px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				<strong>Datos Tributarios de la Empresa</strong>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 40px 40px; position:relative; padding:10px 40px 20px; color:#fff;">
				<div id="datosSin">
					<div class="alert alert-success" role="alert" id="alerta1" style="margin:0 60px 0 20px; display:none;">
						<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
						<strong>Error...!</strong> Las direcciones no pueden estar vacias.
					</div>
					<div class="alert alert-info" role="alert" id="alerta2" style="margin:0 60px 0 20px; display:none;">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<strong>Excelente!</strong> Empresa parametrizada, tus datos se estan guardando...
					</div>
					<div class="alert alert-success" role="alert" id="alerta3" style="margin:0 60px 0 20px; display:none;">
						<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
						<strong>Aviso!</strong> Direccion Eliminada.
					</div>
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>Raz&oacute;n Social:</strong></h4>
							<input type="text" readonly="readonly" class="form-control inputlogin readonly" id="nom" value="<?php echo $row['nombresTF'];?>" size="35" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $row['idticketFacil'];?>','1')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>Nombre Comercial:</strong></h4>
							<input type="text" readonly="readonly" class="form-control inputlogin readonly" id="rsocial" value="<?php echo $row['razonsocialTF'];?>" size="35" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $row['idticketFacil'];?>','2')"/>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>R.U.C.:</strong></h4>
							<input type="text" readonly="readonly" class="form-control inputlogin readonly" id="ruc" value="<?php echo $row['rucTF'];?>" size="35" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $row['idticketFacil'];?>','6')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>Clase de Contribuyente:</strong></h4>
							<input type="text" readonly="readonly" class="form-control inputlogin readonly" id="tipCon" value="<?php echo $row['tipocontribuyenteTF'];?>" size="35" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $row['idticketFacil'];?>','7')"/>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>Nro. de Autorizaci&oacute;n: SRI</strong></h4>
							<input type="text" readonly="readonly" class="form-control inputlogin readonly" id="nro" value="<?php echo $row['nroautorizacionTF']?>" size="35" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $row['idticketFacil'];?>','8')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>Nro. de Autorizaci&oacute;n Municipal</strong></h4>
							<input type="text" style='background-color:#EEEEEE;' class="form-control inputlogin readonly" id="autMun" value="<?php echo $row['autMun'];?>" size="35" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/save.png" style="cursor:pointer;" onclick="cambiaAutMun('<?php echo $row['idticketFacil'];?>')"/>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>Tel&eacute;fono M&oacute;vil <?php echo $row['nroestablecimientoTF'];?>:</strong></h4>
							<input type="text" readonly="readonly" class="form-control inputlogin readonly" id="movil" value="<?php echo $row['telmovilTF'];?>" size="35" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $row['idticketFacil'];?>','4')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>Tel&eacute;fono Fijo <?php echo $row['nroestablecimientoTF'];?>:</strong></h4>
							<input type="text" readonly="readonly" class="form-control inputlogin readonly" id="fijo" value="<?php echo $row['telfijoTF'];?>" size="35" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $row['idticketFacil'];?>','5')"/>
						</div>
					</div>
					<div id="sucursales">
						<?php 
						if($numsuc > 0){
						echo '<div class="row">
								<div class="col-lg-4">
									<h4><strong>Direcci&oacute;n:</strong></h4>
								</div>
								<div class="col-lg-1">
									<h4>&nbsp;</h4>
								</div>
								<div class="col-lg-4">
									<h4><strong>Descripci&oacute;n:</strong></h4>
								</div>
								<div class="col-lg-1">
									<button class="btnlink" title="Añadir Sucursales" onclick="aumentarSucursales()">+</button>
								</div>
							</div>';
							while($rowsuc = $suc -> fetch(PDO::FETCH_ASSOC)){
								$direccion = htmlspecialchars($rowsuc['direccionSE']);
						?>
						<div class="row sucursalesbd">
							<div class="col-lg-4">
								<input type="text" class="form-control inputlogin dirbd" value="<?php echo $direccion;?>" />
								<input type="hidden" class="idbd" value="<?php echo $rowsuc['idSE'];?>" />
							</div>
							<div class="col-lg-1">
								<h4>&nbsp;</h4>
							</div>
							<div class="col-lg-4">
								<input type="text" readonly="readonly" class="form-control inputopcional readonly desbd" value="<?php echo $rowsuc['descripcionSE'];?>" size="35" />
							</div>
							<div class="col-lg-1">
								<button class="btn btn-danger" title="Eliminar Sucursal" onclick="deleteSucursales('<?php echo $rowsuc['idSE'];?>')">-</button>
							</div>
						</div>
						<?php
							}
						}else{
						?>
						<div class="row sucursales">
							<div class="col-lg-4">
								<h4><strong>Direcci&oacute;n:</strong></h4>
								<input type="text" placeholder="Ingresa Direcci&oacute;n" class="form-control inputlogin dir" />
								<input type="hidden" class="numero" value="0" />
							</div>
							<div class="col-lg-1">
								<h4>&nbsp;</h4>
							</div>
							<div class="col-lg-4">
								<h4><strong>Descripci&oacute;n:</strong></h4>
								<input type="text" readonly="readonly" class="form-control inputopcional readonly des" value="Matriz" size="35" />
							</div>
							<div class="col-lg-1">
								<button class="btnlink" title="Añadir Sucursales" onclick="aumentarSucursales()">+</button>
								<h4>&nbsp;</h4>
							</div>
						</div>
						<?php 
						}
						?>
					</div>
				</div>
				<input type="hidden" id="iddelete" value="" />
				<div class="modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" onclick="cancelardelete()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel" style="color:#000;">Alerta!</h4>
							</div>
							<div class="modal-body">
								<div class="alert alert-warning" role="alert">
									<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;<strong>Alerta</strong>...Seguro desea eliminar esta sucursal?
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancelardelete()">Canelar</button>
								<button type="button" class="btn btn-primary" onclick="desactivarsucursal()">Aceptar</button>
							</div>
						</div>
					</div>
				</div>
				<div id="modifyInfo" style="border:2px solid #fff;">
					<table class="det" style="width:100%; color:#fff; border-collapse:separate; border-spacing:10px 20px; font-size:20px;">
						<tr class="modifyInfo" style="text-align:center;">
							
						</tr>
					</table>
				</div>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div class="row">
				<div class="col-lg-12" style="text-align:center;">
					<button class="btndegradate" onclick="guardarDatossuc()">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function cambiaAutMun(id){
		var autMun = $('#autMun').val();
		//alert(autMun)
		if(autMun == ''){
			alert('Campo de Autorización Municipal no puede ser Vacio');
			$('#autMun').val(0);
		}else{
			$.post('SP/cambiaAutMun.php',{
				autMun : autMun , id : id 
			}).done(function(data){
				alert(data);
				window.location='';
			});
		}
	}
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
	var email = $('#newMail').val();
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
		$('#newMail').val('');
		$('#errormail').fadeIn();
		$('#errormail').delay(2000).fadeOut();
	}
}

function modify(id, numdato){
	$('#datosSin').fadeOut('slow');
	$('#modifyInfo').delay(600).fadeIn('slow');
	if(numdato == 1){
		$('.modifyInfo').html('<td class="addinput">\
									<p><strong>Cambiar Raz&oacute;n Social:</strong></p>\
									<p><input type="text" class="inputlogin" id="newNombre" onkeydown="justText(event,this.value)" size="35" /></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+numdato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
									<img src="imagenes/loading.gif" style="width:50px; display:none;" id="newwait"/>\
								</td>');
	}
	
	if(numdato == 2){
		$('.modifyInfo').html('<td class="addinput">\
									<p><strong>Cambiar Nombre Comercial:</strong></p>\
									<p><input type="text" class="inputlogin" id="newComercial" onkeydown="justText(event,this.value)" size="35" /></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+numdato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
									<img src="imagenes/loading.gif" style="width:50px; display:none;" id="newwait"/>\
								</td>');
	}
	
	if(numdato == 3){
		$('.modifyInfo').html('<td class="addinput">\
								<p><strong>Cambiar Direcci&oacute;n Matriz:</strong></p>\
								<p><input type="text" class="inputlogin" id="newMatriz" size="35" /></p>\
								<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+numdato+')">Aceptar</button>&nbsp;&nbsp;\
								<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
								<img src="imagenes/loading.gif" style="width:50px; display:none;" id="newwait"/>\
							</td>');
	}
	
	if(numdato == 4){
		$('.modifyInfo').html('<td class="addinput">\
									<p><strong>Cambiar Tel&eacute;fono M&oacute;vil:</strong></p>\
									<p><input type="text" class="inputlogin" id="newMovil" size="35" onkeydown="justInt(event,this.value)" maxlength="10" /></p>\
									<p><div id="errorMovil" class="smserrorTel"><I>N&uacute;mero M&oacute;vil Incorrecto</I></div></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+numdato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
									<img src="imagenes/loading.gif" style="width:50px; display:none;" id="newwait"/>\
								</td>');
	}
	
	if(numdato == 5){
		$('.modifyInfo').html('<td class="addinput">\
									<p><strong>Cambiar Tel&eacute;fono Fijo:</strong></p>\
									<p><input type="text" class="inputlogin" id="newFijo" size="35" onkeydown="justInt(event,this.value)" maxlength="9" /></p>\
									<p><div id="errorFijo" class="smserrorTel"><I>N&uacute;mero Fijo Incorrecto</I></div></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+numdato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
									<img src="imagenes/loading.gif" style="width:50px; display:none;" id="newwait"/>\
								</td>');
	}
	
	if(numdato == 6){
		$('.modifyInfo').html('<td class="addinput">\
									<p><strong>Cambiar R.U.C.:</strong></p>\
									<p><input type="text" class="inputlogin" id="newRuc" size="35" onkeydown="justInt(event,this.value)" onchange="ValidarCedula()" maxlength="13" /></p>\
									<p><div id="errorruc" class="smserrorTel" style="text-align:center;"><I>RUC Incorrecto</I></div>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+numdato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
									<img src="imagenes/loading.gif" style="width:50px; display:none;" id="newwait"/>\
								</td>');
	}
	
	if(numdato == 7){
		$('.modifyInfo').html('<td>\
								<p><strong>Cambiar Clase de Contribuyente</strong></p>\
								<p>\
									<select class="inputlogin" id="newClase" onchange="cambiar()">\
										<option value="0">Seleccione...</option>\
										<option value="1">Obligado a LLevar Contabilidad</option>\
										<option value="2">No Obligado a LLevar Contabilidad</option>\
										<option value="3">Contribuyente Especial</option>\
										<option value="4">Contribuyente RISE</option>\
									</select>\
								</p>\
								<p class="rise" style="display:none;"><strong>Actividad Económica: </strong></p>\
									<p class="rise" style="display:none;"><select class="inputlogin" id="newactividad" >\
											<option value="0">Seleccione...</option>\
											<option value="1">Actividades de Comercio</option>\
											<option value="2">Actividades de Servicio</option>\
											<option value="3">Actividades de Manufactura</option>\
											<option value="4">Actividades de Construcción</option>\
											<option value="5">Hoteles y Restaurantes</option>\
											<option value="6">Actividades de Trasnporte</option>\
											<option value="7">Actividades Agrícolas</option>\
											<option value="8">Actividades de Minas y Canteras</option>\
										</select>\
									</p>\
									<p class="rise" style="display:none;"><strong>Categoria: </strong></p>\
									<p class="rise" style="display:none;"><select class="inputlogin" id="newCate" >\
											<option value="0">Seleccione...</option>\
											<option value="1">Categoría 1</option>\
											<option value="2">Categoría 2</option>\
											<option value="3">Categoría 3</option>\
											<option value="4">Categoría 4</option>\
											<option value="5">Categoría 5</option>\
											<option value="6">Categoría 6</option>\
											<option value="7">Categoría 7</option>\
										</select>\
									</p>\
								<p><input type="text" style="display:none;" class="inputlogin" id="conEspecial" size="35" placeholder="# de Contribuyente Especial" onkeydown="justInt(event,this.value)" /></p>\
								<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+numdato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
									<img src="imagenes/loading.gif" style="width:50px; display:none;" id="newwait"/>\
							</td>');
	}
	
	if(numdato == 8){
		$('.modifyInfo').html('<td class="addinput">\
									<p><strong>Cambiar Nro. de Autorizaci&oacute;n:</strong></p>\
									<p><input type="text" class="inputlogin" id="newAuto" size="35" onkeydown="justInt(event,this.value)" maxlength="5" onchange="validarAuto()" /></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+numdato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
									<img src="imagenes/loading.gif" style="width:50px; display:none;" id="newwait"/>\
								</td>');
	}
	
	if(numdato == 9){
		$('.modifyInfo').html('<td class="addinput">\
									<p><strong>Cambiar Fecha de Autorizaci&oacute;n:</strong></p>\
									<p><input type="text" class="inputlogin datepicker" id="newFecha" onfocus="adddate()" placeholder="AAAA/MM/DD" readonly="readonly" size="35" /></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+numdato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
									<img src="imagenes/loading.gif" style="width:50px; display:none;" id="newwait"/>\
								</td>');
		$('#newFecha').focus();
	}
	$('html, body').animate({scrollTop: '0px'});
}

function adddate(){
	$('.datepicker').datepicker({
		showOn: 'button',
		buttonImage: 'imagenes/bg-calendario.png',
		buttonImageOnly: true,
		buttonText: 'Select date',
		dateFormat: 'yy-mm-dd'
	});
}

function validarAuto(){
	var nroauto = $('#newAuto').val();
	if(nroauto.length < 5){
		alert('Completa el número de autorización');
		$('#newAuto').val('');
		return false;
	}else if(nroauto == 0){
		alert('El número de autorización no puede ser cero');
		$('#newAuto').val('');
		return false;
	}
}

function ValidarCedula(){
		var numero = $('#newRuc').val();
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
		$('#newRuc').val('');
		$('#errorruc').fadeIn();
		$('#errorruc').delay(3000).fadeOut();
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
		$('#newRuc').val('');
		$('#errorruc').fadeIn();
		$('#errorruc').delay(3000).fadeOut();
		return false;
		}
		/* El ruc de las empresas del sector publico terminan con 0001*/
		if ( numero.substr(9,4) != '0001' ){
		console.log('El ruc de la empresa del sector público debe terminar con 0001');
		$('#newRuc').val('');
		$('#errorruc').fadeIn();
		$('#errorruc').delay(3000).fadeOut();
		return false;
		}
		}
		else if(pri == true){
		if (digitoVerificador != d10){
		console.log('El ruc de la empresa del sector privado es incorrecto.');
		$('#newRuc').val('');
		$('#errorruc').fadeIn();
		$('#errorruc').delay(3000).fadeOut();
		return false;
		}
		if ( numero.substr(10,3) != '001' ){
		console.log('El ruc de la empresa del sector privado debe terminar con 001');
		$('#newRuc').val('');
		$('#errorruc').fadeIn();
		$('#errorruc').delay(3000).fadeOut();
		return false;
		}
		}

		else if(nat == true){
		if (digitoVerificador != d10){
		console.log('El número de cédula de la persona natural es incorrecto.');
		$('#newRuc').val('');
		$('#errorruc').fadeIn();
		$('#errorruc').delay(3000).fadeOut();
		return false;
		}
		if (numero.length >10 && numero.substr(10,3) != '001' ){
		console.log('El ruc de la persona natural debe terminar con 001');
		$('#newRuc').val('');
		$('#errorruc').fadeIn();
		$('#errorruc').delay(3000).fadeOut();
		return false;
		}
		}
		return true;
}

function cambiar(){
	var select = $('#newClase').val();
	var tipoanterior = $('#tipCon').val();
	if(select == 3){
		$('#conEspecial').fadeIn('slow');
	}else{
		$('#conEspecial').fadeOut('slow');
	}
	if((select == 4) && (tipoanterior != 'Contribuyente RISE')){
		$('.rise').fadeIn('slow');
	}else{
		$('.rise').fadeOut('slow');
	}
}

function cancelmodify(){
	$('#modifyInfo').fadeOut('slow');
	$('#datosSin').delay(600).fadeIn('slow');
}

var numregs = $('#numsucursales').val();
if(numregs <= 1){
	var countsuc = 1;
}else{
	var countsuc = numregs;
}

function aumentarSucursales(){
	var content = '';
	content = '<div class="row sucursales" id="newSucursal'+countsuc+'">\
					<div class="col-lg-4">\
						<input type="text" class="form-control inputlogin dir" placeholder="Ingresa Direcci&oacute;n" />\
						<input type="hidden" class="numero" value="'+countsuc+'" />\
					</div>\
					<div class="col-lg-1">\
						<h4>&nbsp;</h4>\
					</div>\
					<div class="col-lg-4">\
						<input type="text" readonly="readonly" class="form-control inputopcional readonly des" value="Sucursal-'+countsuc+'" />\
					</div>\
					<div class="col-lg-1">\
						<button class="btnlink" title="Quitar Sucursales" onclick="quitartarSucursales('+countsuc+')">-</button>\
					</div>\
				</div>';
	$('#sucursales').append(content);
	countsuc++;
}

function quitartarSucursales(id){
	$('#newSucursal'+id).remove();
}

function save(id,dato){
	if(dato == 1){
		var nombre = $('#newNombre').val();
		var info = $('#nom').val();
		if(nombre == ''){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificartf.php',{
				nombre : nombre, id : id, info : info, dato : dato
			}).done(function(data){
				$('#ok').fadeOut('slow');
				$('#no').fadeOut('slow');
				$('#newwait').delay(600).fadeIn('slow');
				setTimeout("alert('Campo Modificado'); window.location = '';",3000);
			});
		}
	}
	if(dato == 2){
		var comercial = $('#newComercial').val();
		var info = $('#rsocial').val();
		if(comercial == ''){
			alert('Llene el campo');
		}else{
			$.post('SP/modificartf.php',{
				comercial : comercial, id : id ,info : info, dato : dato
			}).done(function(data){
				$('#ok').fadeOut('slow');
				$('#no').fadeOut('slow');
				$('#newwait').delay(600).fadeIn('slow');
				setTimeout("alert('Campo Modificado'); window.location = '';",3000);
			});
		}
	}
	if(dato == 3){
		var matriz = $('#newMatriz').val();
		var info = $('#dir').val();
		if(matriz == 0){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificartf.php',{
				matriz : matriz, id : id, info : info, dato : dato
			}).done(function(data){
				$('#ok').fadeOut('slow');
				$('#no').fadeOut('slow');
				$('#newwait').delay(600).fadeIn('slow');
				setTimeout("alert('Campo Modificado'); window.location = '';",3000);
			});
		}
	}
	if(dato == 4){
		var numMovil = $('#newMovil').val().length;
		if(numMovil < 10){
			$('#newMovil').val('');
			$('#newMovil').focus();
			$('#errorMovil').fadeIn('slow');
			$('#errorMovil').delay(600).fadeOut('slow');
		}else{
			var movil = $('#newMovil').val();
			var info = $('#movil').val();
			if(movil == ''){
				alert('Llene el Campo');
			}else{
				$.post('SP/modificartf.php',{
					movil : movil, id : id, info : info, dato : dato
				}).done(function(data){
					$('#ok').fadeOut('slow');
					$('#no').fadeOut('slow');
					$('#newwait').delay(600).fadeIn('slow');
					setTimeout("alert('Campo Modificado'); window.location = '';",3000);
				});
			}
		}
	}
	if(dato == 5){
		var numFijo = $('#newFijo').val().length;
		if(numFijo < 9){
			$('#newFijo').val('');
			$('#newFijo').focus();
			$('#errorFijo').fadeIn('slow');
			$('#errorFijo').delay(600).fadeOut('slow');
		}else{
			var fijo = $('#newFijo').val();
			var info = $('#fijo').val();
			if(fijo == ''){
				alert('Llene el Campo');
			}else{
				$.post('SP/modificartf.php',{
					fijo : fijo, id : id, info : info, dato : dato
				}).done(function(data){
					$('#ok').fadeOut('slow');
					$('#no').fadeOut('slow');
					$('#newwait').delay(600).fadeIn('slow');
					setTimeout("alert('Campo Modificado'); window.location = '';",3000);
				});
			}
		}
	}
	if(dato == 6){
		var ruc = $('#newRuc').val();
		var info = $('#ruc').val();
		if(ruc == ''){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificartf.php',{
				ruc : ruc, id : id, info : info, dato : dato
			}).done(function(data){
				$('#ok').fadeOut('slow');
				$('#no').fadeOut('slow');
				$('#newwait').delay(600).fadeIn('slow');
				setTimeout("alert('Campo Modificado'); window.location = '';",3000);
			});
		}
	}
	if(dato == 7){
		var clase = $('#newClase').val();
		var info = $('#tipCon').val();
		var actividad = $('#newactividad').val();
		var categoria = $('#newCate').val();
		if(clase == 3){
			var nroclase = $('#conEspecial').val();
		}else{
			var nroclase = 'no';
		}
		if(clase == 0){
			alert('Llene el Campo');
		}else{
			if((clase == 4) && ((actividad == 0) || (categoria == 0))){
				alert('Llene los Campos');
			}else{
				$.post('SP/modificartf.php',{
					clase : clase, nroclase : nroclase, id : id, info : info, dato : dato, actividad : actividad, categoria : categoria
				}).done(function(data){
					$('#ok').fadeOut('slow');
					$('#no').fadeOut('slow');
					$('#newwait').delay(600).fadeIn('slow');
					setTimeout("alert('Campo Modificado'); window.location = '';",3000);
				});
			}
		}
	}
	if(dato == 8){
		var auto = $('#newAuto').val();
		var info = $('#nro').val();
		if(auto == ''){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificartf.php',{
				auto : auto, id : id, info : info, dato : dato
			}).done(function(data){
				$('#ok').fadeOut('slow');
				$('#no').fadeOut('slow');
				$('#newwait').delay(600).fadeIn('slow');
				setTimeout("alert('Campo Modificado'); window.location = '';",3000);
			});
		}
	}
	if(dato == 9){
		var fecha = $('#newFecha').val();
		var info = $('#fechaauto').val();
		if(fecha == ''){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificartf.php',{
				fecha : fecha, id : id, info : info, dato : dato
			}).done(function(data){
				$('#ok').fadeOut('slow');
				$('#no').fadeOut('slow');
				$('#newwait').delay(600).fadeIn('slow');
				setTimeout("alert('Campo Modificado'); window.location = '';",3000);
			});
		}
	}
}

function guardarDatossuc(){
	var identificador = 1;
	if(numregs > 0){
		var valoresbd = '';
		$('.sucursalesbd').each(function(){
			var idbd = $(this).find('.idbd').val();
			var direccionbd = $(this).find('.dirbd').val();
			
			if(direccionbd == ''){
				valoresbd = '';
				return false;
			}else{
				valoresbd += idbd +'|'+ direccionbd +'|'+'@';
			}
		});
		var valoresbd_form = valoresbd.substring(0,valoresbd.length -1);
	}else{
		var valoresbd = '';
		var valoresbd_form = '';
	}
	
	if($('.sucursales').length){
		var valores = '';
		$('.sucursales').each(function(){
			var direccion = $(this).find('.dir').val();
			var descripcion = $(this).find('.des').val();
			var numero = $(this).find('.numero').val();
			
			if(direccion == ''){
				valores = '';
				return false;
			}else{
				valores += direccion +'|'+ descripcion +'|'+ numero +'|'+'@';
			}
		});
		var valores_form = valores.substring(0,valores.length -1);
	}else{
		var valores = '';
		var valores_form = '';
	}
	
	if((numregs > 0) && (valoresbd == '')){
		$('#alerta1').fadeIn();
		$('#alerta1').delay(2500).fadeOut();
		return false;
	}else if(($('.sucursales').length) && (valores == '')){
		$('#alerta1').fadeIn();
		$('#alerta1').delay(2500).fadeOut();
		return false;
	}else{
		$.post('SP/modifysucursal.php',{
			valoresbd : valoresbd_form, valores : valores_form, identificador : identificador
		}).done(function(response){
			$('#alerta2').fadeIn();
			setTimeout("window.location = '';",3000);
		});
	}
}

function deleteSucursales(id){
	$('#iddelete').val(id);
	$('#aviso').modal('show');
}

function desactivarsucursal(){
	$('#aviso').modal('hide');
	var identificador = 2;
	var id = $('#iddelete').val();
	$.post('SP/modifysucursal.php',{
		id : id, identificador : identificador
	}).done(function(response){
		if($.trim(response) == 'ok'){
			$('#alerta3').fadeIn();
			setTimeout("window.location = '';",3000);
		}
	});
}

function cancelardelete(){
	$('#iddelete').val('');
	$('#aviso').modal('hide');
}

$('#cancelar').on('click',function(){
	window.location = '';
});
</script>