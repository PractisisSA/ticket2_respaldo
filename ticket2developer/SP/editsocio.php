<?php 
	include("controlusuarios/seguridadSP.php");
	echo '<input type="hidden" id="data" value="4" />';
	$id = $_GET['id'];
	echo '<input type="hidden" id="idU" value="'.$id.'" />';
	
	$gbd = new DBConn();
	
	$select = "SELECT * FROM Socio WHERE idSocio = ?";
	$slt = $gbd -> prepare($select);
	$slt -> execute(array($id));
	$row = $slt -> fetch(PDO::FETCH_ASSOC);
	
	$nombre = htmlspecialchars($row['nombresS']);
	$ruc = htmlspecialchars($row['rucS']);
	$razonsocial = htmlspecialchars($row['razonsocialS']);
	$dirmatriz = htmlspecialchars($row['direccionesS']);
	$diresta = htmlspecialchars($row['direstablecimientoS']);
	$printpara = htmlspecialchars($row['imprimirparaS']);
	$des = htmlspecialchars($row['descripciondirS']);
	$mail = htmlspecialchars($row['mailS']);
	$movil = htmlspecialchars($row['telmovilS']);
	$fijo = htmlspecialchars($row['telfijoS']);
	$contribuyente = htmlspecialchars($row['tipocontribuyenteS']);
	$act = htmlspecialchars($row['actividadS']);
	$categoria = htmlspecialchars($row['categoria']);
	$inferioranual = htmlspecialchars($row['inferioranualS']);
	$superioranual = htmlspecialchars($row['superioranualS']);
	$inferiormensual = htmlspecialchars($row['inferiormensualS']);
	$superiormensual = htmlspecialchars($row['superiormensualS']);
	$monto = htmlspecialchars($row['montodocS']);
	$actividad = htmlspecialchars($row['fechaactividadS']);
	$inscripcion = htmlspecialchars($row['fechainscripcionS']);
	$nro = htmlspecialchars($row['nroestablecimientoS']);
	if((strlen($nro) == 1)){
		$nroestablecimiento = '00'.$nro;
	}else{
		if((strlen($nro) == 2)){
			$nroestablecimiento = '0'.$nro;
		}else{
			if((strlen($nro) > 2)){
				$nroestablecimiento = $nro;
			}
		}
	}
	$estado = htmlspecialchars($row['estadoS']);
	
	$select1 = "SELECT * FROM Socio";
	$slt1 = $gbd -> prepare($select1);
	$slt1 -> execute();
	$content = '';
	while($row1 = $slt1 -> fetch(PDO::FETCH_ASSOC)){
		$content .= '<div class="sociook"><input type="hidden" class="razonbd" value="'.$row1['nombresS'].'" />
					<input type="hidden" class="rucs" value="'.$row1['rucS'].'" /></div>';
	}
	echo $content;
?>
<style>
	.readonly{
		color:#000;
	}
</style>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				Edici&oacute;n de Socio
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; padding:10px 80px 20px; color:#fff;">
				<div class="infoUser">
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>Razón Social: </strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="nombres" value="<?php echo $nombre;?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','1')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>R.U.C.: </strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="ruc" value="<?php echo $ruc;?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','2')"/>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>E-mail: </strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="mail" value="<?php echo $mail?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','3')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>Nombre Comercial: </strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="razonsocial" value="<?php echo $razonsocial?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','4')"/>
						</div>
					</div>
					<?php 
					if($printpara == 's'){
					?>
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>Direcci&oacute;n Matriz:</strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="matriz" value="<?php echo $dirmatriz;?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','5')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>Direcci&oacute;n Sucursal:</strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="sucursal" value="<?php echo $diresta;?>" />
						</div>
					<?php if($diresta == 'Sin Direccion Sucursal'){ ?>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','17')"/>
						</div>
					</div>
					<?php }else{ ?>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','17')"/>
							<img src="imagenes/clouse.png" style="cursor:pointer;" onclick="modifyDelete('<?php echo $row1['idSocio'];?>')"/>
						</div>
					</div>
					<?php } ?>
					<?php }else if($printpara == 'm'){?>
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>Direcci&oacute;n Matriz:</strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="matriz" value="<?php echo $dirmatriz;?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','5')"/>
						</div>
						<div class="col-lg-4">
							<h4 class="addsucursal">&nbsp;</h4>
							<button type="button" class="btnlink addsucursal" onclick="addsucursal()">Añadir Dirección Sucursal</button>
							<span class="nuevasucursal" style="display:none;"><h4><strong>Direcci&oacute;n Sucursal:</strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="sucursal" value="<?php echo $diresta;?>" /></span>
						</div>
						<div class="col-lg-1">
							<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" onclick="cancelsucursal()" class="nuevasucursal" />
							<img src="imagenes/lapiama.png" style="cursor:pointer; display:none;" class="nuevasucursal" onclick="modify('<?php echo $id;?>','17')"/>
						</div>
					</div>
					<?php }?>
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>Tel&eacute;fono M&oacute;vil: </strong></h4>
							<input type="text" id="movil" readonly="readonly" class="form-control inputlogin readonly" value="<?php echo $movil;?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','7')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>Tel&eacute;fono Fijo</strong></h4>
							<input type="text" id="fijo" readonly="readonly" class="form-control inputlogin readonly" value="<?php echo $fijo?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','8')"/>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><strong>Descripci&oacute;n: </strong></h4>
							<input type="text" class="form-control inputopcional readonly" readonly="readonly" id="establecimiento" value="<?php echo $des;?>" />
						</div>
						<div class="col-lg-5">
							<h4><strong>Nro. de Establecimiento: </strong></h4>
							<input type="text" value="<?php echo $nroestablecimiento;?>" readonly="readonly" class="form-control inputopcional readonly" id="nroestablecimiento" />
						</div>
					</div>
					<?php if($contribuyente == 'Contribuyente RISE'){?>
					<div class="row tipoRise">
						<div class="col-lg-4">
							<h4><strong>Actividad Económica:</strong></h4>
							<input type="text" value="<?php echo $act;?>" readonly="readonly" class="form-control inputlogin readonly" id="act" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','15')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>Categoría:</strong></h4>
							<input type="text" value="<?php echo $categoria;?>" readonly="readonly" class="form-control inputlogin readonly" id="categoria" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','16')"/>
						</div>
					</div>
					<div class="row tipoRise" style="text-align:center;">
						<div class="col-lg-10">
							<h4><strong>Intervalos de Ingresos</strong></h4>
						</div>
					</div>
					<div class="row tipoRise" style="text-align:center;">
						<div class="col-lg-5">
							<h4><strong>Anuales</strong></h4>
							Desde&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta<br>
							$<input type="text" id="inferior1" value="<?php echo $inferioranual;?>" class="form-control inputopcional readonly" readonly="readonly" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							$<input type="text" id="superior1" class="form-control inputopcional readonly" value="<?php echo $superioranual;?>" readonly="readonly" size="10" />
						</div>
						<div class="col-lg-5">
							<h4><strong>Mensuales Promedio</strong></h4>
							Desde&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta<br>
							$<input type="text" id="inferior2" class="form-control inputopcional readonly" value="<?php echo $inferiormensual;?>" readonly="readonly" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							$<input type="text" id="superior2" class="form-control inputopcional readonly" value="<?php echo $superiormensual;?>" readonly="readonly" size="10" />
						</div>
					</div>
					<div class="row tipoRise" style="text-align:center;">
						<div class="col-lg-10">
							<h4><strong>Monto M&aacute;ximo para cada Documento</strong></h4>
							<h4>$<input type="text" id="monto" class="form-control inputopcional readonly" readonly="readonly" value="<?php echo $monto;?>" />,00 Dólares.</h4>
						</div>
					</div>
					<?php }?>
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>Clase Contribuyente: </strong></h4>
							<input type="text" value="<?php echo $contribuyente;?>" id="contribuyente" readonly="readonly" class="form-control inputlogin readonly" />
							<?php 
								if($contribuyente == 'Contribuyente Especial'){
									echo '<h4><strong>Nro. Con. Especial:</strong></h4>
									<input type="text" class="form-control inputlogin readonly" id="nroCon" readonly="readonly" size="30" value="'.$row['nroespecialS'].'" />';
								}
							?>
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','9')"/>
							<?php 
								if($contribuyente == 'Contribuyente Especial'){
									echo '<h4>&nbsp;</h4>
									<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('.$id.',14)"/>';
								}
							?>
						</div>
						<div class="col-lg-4">
							<h4><strong>Fecha Inicio Actividades: </strong></h4>
							<input type="text" value="<?php echo $actividad;?>" id="actividad" readonly="readonly" class="form-control inputlogin readonly" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','11')"/>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>Fecha Inscripci&oacute;n: </strong></h4>
							<input type="text" value="<?php echo $inscripcion;?>" id="inscripcion" readonly="readonly" class="form-control inputlogin readonly" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','12')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>Estado: </strong></h4>
							<input type="text" value="<?php echo $estado;?>" id="estado" readonly="readonly" class="form-control inputlogin readonly" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','13')"/>
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
			<div class="infoUser" style="text-align:center; margin:20px; padding:20px 0;">
				<input type="button" value="SALIR" class="btndegradate" id="cancelar" onclick="cancelar()" />
			</div>
		</div>
	</div>
</div>
<script>
function cancelar(){
	window.location.href = '?modulo=listaSocio';
}
function modifyDelete(){
	var address = $('#sucursal').val();
	console.log(address);
	var resp = confirm('Seguro que desea eliminar la sucursal?')
	if (resp == true) {
		$.post('SP/deleteSucursal.php',{
		address : address
	}).done(function(data){
		if (data == 1) {
			alert
			console.log('done!')
			location.reload();
		}else{
			console.log(data);
		}
	});
	}else{
		alert('Ha cancelado la modificacion');
	}
}
function modify(id,dato){
	$('.infoUser').fadeOut('slow');
	$('#modifyInfo').delay(600).fadeIn('slow');
	if(dato == 1){
		$('.modifyInfo').html(
		'<td class="addinput">\
			<p><strong>Cambiar Razón Social:</strong></p>\
			<p><input type="text" class="inputlogin" id="newNombre" onkeydown="justText(event,this.value)" onkeyup="validarRepetidos(this.value)" size="35" /></p>\
			<p><div id="alerta1" class="smserrorTel" style="text-align:center;"><I>Razón Social Repetida...</I></div>\
			<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
			<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
			<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
		</td>');
	}
	if(dato == 2){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar R.U.C. de Socio:</strong></p>\
				<p><input type="text" class="inputlogin" id="newRuc" onkeydown="justInt(event,this.value)" onkeyup="validarRepetidos(this.value)" onchange="ValidarCedula()" size="35" /></p>\
				<p><div id="errorruc" class="smserrorTel" style="text-align:center;"><I>RUC Incorrecto</I></div>\
				<p><div id="alerta2" class="smserrorTel" style="text-align:center;"><I>RUC Repetido...</I></div>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
}
	if(dato == 3){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar E-mail de Socio:</strong></p>\
				<p><input type="text" class="inputlogin" id="newMail" onchange="return validarMail()" size="35" /></p>\
				<div id="errormail" class="smserrorTel"><I>E-mail Incorrecto</I></div>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
	}
	if(dato == 4){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar Nombre Comercial del Socio:</strong></p>\
				<p><input type="text" class="inputlogin" id="newRazonsocial" size="35" onkeydown="justText(event,this.value)" /></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
	}
	if(dato == 5){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar Direcci&oacute;n Matriz de Socio:</strong></p>\
				<p><input type="text" class="inputlogin" id="newMatriz" size="35" /></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
	}
	if(dato == 7){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar Tel&eacute;fono M&oacute;vil de Socio:</strong></p>\
				<p><input type="text" class="inputlogin" id="newMovil" size="35" onkeydown="justInt(event,this.value)" maxlength="10" /></p>\
				<p><div id="errorMovil" class="smserrorTel"><I>N&uacute;mero M&oacute;vil Incorrecto</I></div></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
	}
	if(dato == 8){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar Tel&eacute;fono Fijo de Socio:</strong></p>\
				<p><input type="text" class="inputlogin" id="newFijo" size="35" onkeydown="justInt(event,this.value)" maxlength="9" /></p>\
				<p><div id="errorFijo" class="smserrorTel"><I>N&uacute;mero Fijo Incorrecto</I></div></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
	}
	if(dato == 9){
		$('.modifyInfo').html(
			'<td class="addinput">\
			<p><strong>Cambiar Clase de Contribuyente de Socio:</strong></p>\
			<p><select id="newContribuyente" class="inputlogin" onchange="cambiar()">\
				<option value="0">Seleccione...</option>\
				<option value="1">Obligado a llevar Contabilidad</option>\
				<option value="2">No Obligado a llevar Contabilidad</option>\
				<option value="3">Contribuyente Especial</option>\
				<option value="4">Contribuyente RISE</option>\
			</select></p>\
			<p><input type="text" id="conEspecial" class="inputlogin" style="display:none;" onkeydown="justInt(event,this.value)" placeholder="Nro. Contribuyente Especial" size="35" /></p>\
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
			<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
			<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
			<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
		</td>');
	}
	if(dato == 10){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar Nro. de Establecimientos de Socio:</strong></p>\
				<p><input type="text" class="inputlogin" id="newNroEstablecimiento" size="35" onkeydown="justInt(event,this.value)" /></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
	}
	if(dato == 11){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar Fecha Inicio Actividades de Socio:</strong></p>\
				<p><input type="text" class="inputlogin datepicker" id="newactividades" onfocus="adddate()" placeholder="AAAA/MM/DD" readonly="readonly" size="35" /></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
		$('#newactividades').focus();
	}
	if(dato == 12){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar Fecha Inscripci&oacute;n de Socio:</strong></p>\
				<p><input type="text" class="inputlogin datepicker" id="newinscripcion" placeholder="AAAA/MM/DD" readonly="readonly" onfocus="adddate()" size="35" /></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
		$('#newinscripcion').focus();
	}
	if(dato == 13){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar Estado de Socio:</strong></p>\
				<p><select id="newEstado" class="inputlogin">\
					<option value="0">Seleccione...</option>\
					<option value="Activo">Activo</option>\
					<option value="Inactivo">Inactivo</option>\
				</select></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
	}
	if(dato == 14){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar Nro. Contribuyente Especial de Socio:</strong></p>\
				<p><input type="text" class="inputlogin" id="newnroespecial" onkeydown="justInt(event,this.value)" size="35" /></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
	}
	if(dato == 15){
		$('.modifyInfo').html(
			'<td>\
				<p><strong>Nueva Actividad Económica</strong></p>\
				<p><select class="inputlogin" id="newactividadEconomica">\
					<option value="0">Seleccione...</option>\
					<option value="1">Actividades de Comercio</option>\
					<option value="2">Actividades de Servicio</option>\
					<option value="3">Actividades de Manufactura</option>\
					<option value="4">Actividades de Construcción</option>\
					<option value="5">Hoteles y Restaurantes</option>\
					<option value="6">Actividades de Trasnporte</option>\
					<option value="7">Actividades Agrícolas</option>\
					<option value="8">Actividades de Minas y Canteras</option>\
				</select></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
	}
	if(dato == 16){
		$('.modifyInfo').html(
			'<td>\
				<p><strong>Nueva Categoría</strong></p>\
				<p><select class="inputlogin" id="newcategoria">\
					<option value="0">Seleccione...</option>\
					<option value="1">Categoría 1</option>\
					<option value="2">Categoría 2</option>\
					<option value="3">Categoría 3</option>\
					<option value="4">Categoría 4</option>\
					<option value="5">Categoría 5</option>\
					<option value="6">Categoría 6</option>\
					<option value="7">Categoría 7</option>\
				</select></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
	}
	if(dato == 17){
		$('.modifyInfo').html(
			'<td class="addinput">\
				<p><strong>Cambiar Direcci&oacute;n Sucursal de Socio:</strong></p>\
				<p><input type="text" class="inputlogin" id="newSucursal" size="35" /></p>\
				<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
				<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
				<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>\
			</td>');
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

function cambiar(){
	var select = $('#newContribuyente').val();
	var tipoanterior = $('#contribuyente').val();
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
	$('.infoUser').delay(600).fadeIn('slow');
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

function validarRepetidos(valor){
	if(!$('#alerta1').is(':hidden')){
		$('#alerta1').fadeOut();
	}
	if(!$('#alerta2').is(':hidden')){
		$('#alerta2').fadeOut();
	}
	$('.sociook').each(function(){
		var rucok = $(this).find('.rucs').val();
		if(valor == rucok){
			$('#alerta2').fadeIn();
			$('#newRuc').val('');
			return false;
		}
		var razonok = $(this).find('.razonbd').val();
		razonok = razonok.toLowerCase();
		valor = valor.toLowerCase();
		if(valor == razonok){
			$('#alerta1').fadeIn();
			$('#newNombre').val('');
			return false;
		}
	});
}

function addsucursal(){
	$('.addsucursal').fadeOut();
	$('.nuevasucursal').delay(600).fadeIn();
}

function cancelsucursal(){
	$('.nuevasucursal').fadeOut();
	$('.addsucursal').delay(600).fadeIn();
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

function save(id,dato){
	if(dato == 1){
		var nombre = $('#newNombre').val();
		var info = $('#nombres').val();
		if(nombre == ''){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				nombre : nombre, id : id, info : info, dato : dato
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
	if(dato == 2){
		var ruc = $('#newRuc').val();
		var info = $('#ruc').val();
		if(ruc == ''){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				ruc : ruc, id : id, info : info, dato : dato
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
	if(dato == 3){
		var mail = $('#newMail').val();
		var info = $('#mail').val();
		if(mail == ''){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				mail : mail, id : id, info : info, dato : dato
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
	if(dato == 4){
		var razonsocial = $('#newRazonsocial').val();
		var info = $('#razonsocial').val();
		if(razonsocial == ''){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				razonsocial : razonsocial, id : id, info : info, dato : dato
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
	if(dato == 5){
		var matriz = $('#newMatriz').val();
		var info = $('#matriz').val();
		if(matriz == 0){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				matriz : matriz, id : id, info : info, dato : dato
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
	if(dato == 7){
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
				$('#ok').fadeOut('slow');
				$('#no').fadeOut('slow');
				$('#wait').delay(600).fadeIn('slow');
				$.post('SP/modificarsocio.php',{
					movil : movil, id : id, info : info, dato : dato
				}).done(function(data){
					setTimeout("alert('Campo Modificado'); window.location = '';",500);
					$('#wait').fadeOut('slow');
				});
			}
		}
	}
	if(dato == 8){
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
				$('#ok').fadeOut('slow');
				$('#no').fadeOut('slow');
				$('#wait').delay(600).fadeIn('slow');
				$.post('SP/modificarsocio.php',{
					fijo : fijo, id : id, info : info, dato : dato
				}).done(function(data){
					setTimeout("alert('Campo Modificado'); window.location = '';",500);
					$('#wait').fadeOut('slow');
				});
			}
		}
	}
	if(dato == 9){
		var contribuyente = $('#newContribuyente').val();
		var nrocontribuyente = $('#conEspecial').val();
		var info = $('#contribuyente').val();
		var actividad = $('#newactividad').val();
		var categoria = $('#newCate').val();
		if(contribuyente == 0){
			alert('Llene el Campo');
		}else{
			if((contribuyente == 3) && (nrocontribuyente == '')){
				alert('Llene los Campos');
			}else{
				if((contribuyente == 4) && ((actividad == 0) || (categoria == 0))){
					alert('Llene los Campos');
				}else{
					$('#ok').fadeOut('slow');
					$('#no').fadeOut('slow');
					$('#wait').delay(600).fadeIn('slow');
					$.post('SP/modificarsocio.php',{
						contribuyente : contribuyente, nrocontribuyente : nrocontribuyente, id : id, info : info, dato : dato, actividad : actividad, categoria : categoria
					}).done(function(data){
						setTimeout("alert('Campo Modificado'); window.location = '';",500);
						$('#wait').fadeOut('slow');
					});
				}
			}
		}
	}
	if(dato == 10){
		var nroestablecimiento = $('#newNroEstablecimiento').val();
		var info = $('#nroestablecimiento').val();
		if(nroestablecimiento == ''){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				nroestablecimiento : nroestablecimiento, id : id, info : info, dato : dato
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
	
	if(dato == 11){
		var actividad = $('#newactividades').val();
		var info = $('#actividad').val();
		if(actividad == ''){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				actividad : actividad, id : id, info : info, dato : dato
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
	
	if(dato == 12){
		var inscripcion = $('#newinscripcion').val();
		var info = $('#inscripcion').val();
		if(inscripcion == ''){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				inscripcion : inscripcion, id : id, info : info, dato : dato
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
	if(dato == 13){
		var estado = $('#newEstado').val();
		var info = $('#estado').val();
		if(estado == ''){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				estado : estado, id : id, info : info, dato : dato
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
	if(dato == 14){
		var nroespecial = $('#newnroespecial').val();
		var info = $('#nroCon').val();
		if(nroespecial == ''){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				nroespecial : nroespecial, id : id, info : info, dato : dato
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeIn('slow');
			});
		}
	}
	if(dato == 15){
		var newactividad = $('#newactividadEconomica').val();
		var info = $('#act').val();
		var monto = $('#monto').val();
		var categoria = $('#categoria').val();
		if(newactividad == ''){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				newactividad : newactividad, id : id, info : info, dato : dato, monto : monto, categoria : categoria
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
	if(dato == 16){
		var newcategoria = $('#newcategoria').val();
		var info = $('#categoria').val();
		var monto = $('#monto').val();
		var actividad = $('#act').val();
		if(newcategoria == ''){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				newcategoria : newcategoria, id : id, info : info, dato : dato, monto : monto, actividad : actividad
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
	if(dato == 17){
		var matriz = $('#newSucursal').val();
		var info = $('#sucursal').val();
		if(matriz == 0){
			alert('Llene el Campo');
		}else{
			$('#ok').fadeOut('slow');
			$('#no').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/modificarsocio.php',{
				matriz : matriz, id : id, info : info, dato : dato
			}).done(function(data){
				setTimeout("alert('Campo Modificado'); window.location = '';",500);
				$('#wait').fadeOut('slow');
			});
		}
	}
}
</script>