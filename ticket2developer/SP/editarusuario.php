<?php 
	include("controlusuarios/seguridadSP.php");
	echo '<input type="hidden" id="data" value="1" />';
	$id = $_GET['id'];
	echo '<input type="hidden" id="idU" value="'.$id.'" />';
	$gbd = new DBConn();
	
	$selectDatos = "SELECT * FROM Usuario WHERE idUsuario = ?";
	$stmt = $gbd -> prepare($selectDatos);
	$stmt -> execute(array($id));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	$nombre = htmlspecialchars($row['strNombreU']);
	$mail = htmlspecialchars($row['strMailU']);
	$cedula = htmlspecialchars($row['strCedulaU']);
	$direccion = htmlspecialchars($row['strDireccionU']);
	$ciudad = htmlspecialchars($row['strCiudadU']);
		if($ciudad == 1){
			$ciu = 'Ambato';
		}else{
			if($ciudad == 2){
				$ciu = 'Cuenca';
			}else{
				if($ciudad == 3){
					$ciu = 'Esmeraldas';
				}else{
					if($ciudad == 4){
						$ciu = 'Guaranda';
					}else{
						if($ciudad == 5){
							$ciu = 'Guayaquil';
						}else{
							if($ciudad == 6){
								$ciu = 'Ibarra';
							}else{
								if($ciudad == 7){
									$ciu = 'Latacunga';
								}else{
									if($ciudad == 8){
										$ciu = 'Loja';
									}else{
										if($ciudad == 9){
											$ciu = 'Machala';
										}else{
											if($ciudad == 10){
												$ciu = 'Portoviejo';
											}else{
												if($ciudad == 11){
													$ciu = 'Puyo';
												}else{
													if($ciudad == 12){
														$ciu = 'Quito';
													}else{
														if($ciudad == 13){
															$ciu = 'Santo Domingo';
														}else{
															if($ciudad == 14){
																$ciu = 'Riobamba';
															}else{
																if($ciudad == 15){
																	$ciu = 'Tena';
																}else{
																	if($ciudad == 16){
																		$ciu = 'Tulc&aacute;n';
																	}else{
																		$ciu = $ciudad;
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	$provincia = htmlspecialchars($row['strProvinciaU']);
		if($provincia == 1){
			$pro = 'Azuay';
		}else{
			if($provincia == 2){
				$pro = 'Bolivar';
			}else{
				if($provincia == 3){
					$pro = 'Ca&ntilde;ar';
				}else{
					if($provincia == 4){
						$pro = 'Carchi';
					}else{
						if($provincia == 5){
							$pro = 'Chimborazo';
						}else{
							if($provincia == 6){
								$pro = 'Cotopaxi';
							}else{
								if($provincia == 7){
									$pro = 'El Oro';
								}else{
									if($provincia == 8){
										$pro = 'Esmeraldas';
									}else{
										if($provincia == 9){
											$pro = 'Guayas';
										}else{
											if($provincia == 10){
												$pro = 'Imbabura';
											}else{
												if($provincia == 11){
													$pro = 'Loja';
												}else{
													if($provincia == 12){
														$pro = 'Los R&iacute;os';
													}else{
														if($provincia == 13){
															$pro = 'Manab&iacute;';
														}else{
															if($provincia == 14){
																$pro = 'Morona Santiago';
															}else{
																if($provincia == 15){
																	$pro = 'Napo';
																}else{
																	if($provincia == 16){
																		$pro = 'Orellana';
																	}else{
																		if($provincia == 17){
																			$pro = 'Pastaza';
																		}else{
																			if($provincia == 18){
																				$pro = 'Pichincha';
																			}else{
																				if($provincia == 19){
																					$pro = 'Santa Elena';
																				}else{
																					if($provincia == 20){
																						$pro = 'Santo Domingo de los Ts&aacute;chilas';
																					}else{
																						if($provincia == 21){
																							$pro = 'Tungurahua';
																						}else{
																							if($provincia == 2){
																								$pro = 'Zamora Chinchipe';
																							}else{
																								$pro = $provincia;
																							}
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	$movil = htmlspecialchars($row['strTelU']);
	$fijo = htmlspecialchars($row['intfijoU']);
	$perfil = htmlspecialchars($row['strPerfil']);
	$obsCreacion = htmlspecialchars($row['strObsCreacion']);
	$obsCambio = htmlspecialchars($row['strObsCambio']);
	$stado = htmlspecialchars($row['strEstadoU']);
	
	$sql1 = "SELECT strMailU, strCedulaU FROM Usuario";
	$stmt1 = $gbd -> prepare($sql1);
	$stmt1 -> execute();
	$content = '';
	while($row1 = $stmt1 -> fetch(PDO::FETCH_ASSOC)){
		$content .= '<div class="usersok"><input type="hidden" class="mailbd" value="'.$row1['strMailU'].'" />
					<input type="hidden" class="cedulabd" value="'.$row1['strCedulaU'].'" /></div>';
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
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
				Edici&oacute;n de Usuario
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; padding:10px 40px 20px; color:#fff;">
				<div class="infoUser">
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>Nombres: </strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="nombres" value="<?php echo $nombre;?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','1')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>C&eacute;dula: </strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="cedula" value="<?php echo $cedula;?>" />
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
							<h4><strong>Password: </strong></h4>
							<input type="password" class="form-control inputlogin readonly" readonly="readonly" id="pass" value="<?php echo $row['strContrasenaU']?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','11')"/>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-10">
							<h4><strong>Direcci&oacute;n: </strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="direccion" value="<?php echo $direccion;?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','4')"/>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<h4><strong>Ciudad: </strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="ciu" value="<?php echo $ciu;?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','5')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>Provincia: </strong></h4>
							<input type="text" class="form-control inputlogin readonly" readonly="readonly" id="pro" value="<?php echo $pro;?>" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','6')"/>
						</div>
					</div>
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
						<div class="col-lg-4">
							<h4><strong>Estado: </strong></h4>
							<input type="text" value="<?php echo $stado;?>" id="sto" readonly="readonly" class="form-control inputlogin readonly" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','9')"/>
						</div>
						<div class="col-lg-4">
							<h4><strong>Perfil: </strong></h4>
							<input type="text" value="<?php echo $perfil;?>" readonly="readonly" class="form-control inputlogin readonly" id="per" />
						</div>
						<div class="col-lg-1">
							<h4>&nbsp;</h4>
							<img src="imagenes/lapiama.png" style="cursor:pointer;" onclick="modify('<?php echo $id;?>','10')"/>
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
	window.location.href = '?modulo=listaUsuarios';
}

function modify(id,dato){
	$('.infoUser').fadeOut('slow');
	$('#modifyInfo').delay(600).fadeIn('slow');
	if(dato == 1){
		$('.modifyInfo').html('<td>\
									<p><strong>Cambiar Nombre de Usuario:</strong></p>\
									<p><input type="text" class="inputlogin" id="newNombre" onkeydown="justText(event,this.value)" size="30" /></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
								</td>');
	}
	if(dato == 2){
		$('.modifyInfo').html('<td>\
									<p><strong>Cambiar C&eacute;dula de Usuario:</strong></p>\
									<p><input type="text" class="inputlogin" id="newCedula" onkeydown="justInt(event,this.value)" onkeyup="validarRepeticion(this.value)" size="30" /></p>\
									<div id="errorcedmod" class="smserrorTel"><I>C&eacute;dula Incorrecta</I></div>\
									<div id="alerta3" class="smserrorTel"><I>Esta C&eacute;dula ya existe...!</I></div>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
								</td>');
	}
	if(dato == 3){
		$('.modifyInfo').html('<td>\
									<p><strong>Cambiar E-mail de Usuario:</strong></p>\
									<p><input type="text" class="inputlogin" id="newMail" onchange="return validarMail()" onkeyup="validarRepeticion(this.value)" size="30" /></p>\
									<div id="errormail" class="smserrorTel"><I>E-mail Incorrecto</I></div>\
									<div id="alerta2" class="smserrorTel"><I>Este E-mail ya existe...!</I></div>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
								</td>');
	}
	if(dato == 4){
		$('.modifyInfo').html('<td>\
									<p><strong>Cambiar Direcci&oacute;n de Usuario:</strong></p>\
									<p><input type="text" class="inputlogin" id="newDireccion" size="30" /></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
								</td>');
	}
	if(dato == 5){
		$('.modifyInfo').html('<td>\
								<p><strong>Cambiar Ciudad de Usuario:</strong></p>\
								<p><select id="newCiudad" class="inputlogin" onchange="cambio()">\
									<option value="0">Seleccione...</option>\
									<option value="1">Ambato</option>\
									<option value="2">Cuenca</option>\
									<option value="3">Esmeraldas</option>\
									<option value="4">Guaranda</option>\
									<option value="5">Guayaquil</option>\
									<option value="6">Ibarra</option>\
									<option value="7">Latacunga</option>\
									<option value="8">Loja</option>\
									<option value="9">Machala</option>\
									<option value="10">Portoviejo</option>\
									<option value="11">Puyo</option>\
									<option value="12">Quito</option>\
									<option value="13">Santo Domingo</option>\
									<option value="14">Riobamba</option>\
									<option value="15">Tena</option>\
									<option value="16">Tulc&aacute;n</option>\
									<option value="17">Otra...</option>\
								</select></p>\
								<p><input type="text" class="inputlogin" id="otraCiudad" style="display:none;" size="30" onkeydown="justText(event,this.value)" /></p>\
								<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
								<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
							</td>');
	}
	if(dato == 6){
		$('.modifyInfo').html('<td>\
								<p><strong>Cambiar Provincia de Usuario:</strong></p>\
								<p><select class="inputlogin" id="newProvincia" onchange="cambio()">\
									<option value="0">Seleccione...</option>\
									<option value="1">Azuay</option>\
									<option value="2">Bolivar</option>\
									<option value="3">Ca&ntilde;ar</option>\
									<option value="4">Carchi</option>\
									<option value="5">Chimborazo</option>\
									<option value="6">Cotopaxi</option>\
									<option value="7">El Oro</option>\
									<option value="8">Esmeraldas</option>\
									<option value="9">Guayas</option>\
									<option value="10">Imbabura</option>\
									<option value="11">Loja</option>\
									<option value="12">Los R&iacute;os</option>\
									<option value="13">Manab&iacute;</option>\
									<option value="14">Morona Santiago</option>\
									<option value="15">Napo</option>\
									<option value="16">Orellana</option>\
									<option value="17">Paztaza</option>\
									<option value="18">Pichincha</option>\
									<option value="19">Santa Elena</option>\
									<option value="20">Santo Domingo de los Ts&aacute;chilas</option>\
									<option value="21">Tungurahua</option>\
									<option value="22">Zamora Chinchipe</option>\
									<option value="23">Otra...</option>\
								</select></p>\
								<p><input type="text" class="inputlogin" id="otraProvincia" style="display:none;" size="30" onkeydown="justText(event,this.value)" /></p>\
								<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
								<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
							</td>');
	}
	if(dato == 7){
		$('.modifyInfo').html('<td>\
									<p><strong>Cambiar Tel&eacute;fono M&oacute;vil de Usuario:</strong></p>\
									<p><input type="text" class="inputlogin" id="newMovil" size="30" onkeydown="justInt(event,this.value)" maxlength="9" /></p>\
									<p><div id="errorMovil" class="smserrorTel"><I>N&uacute;mero M&oacute;vil Incorrecto</I></div></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
								</td>');
	}
	if(dato == 8){
		$('.modifyInfo').html('<td>\
									<p><strong>Cambiar Tel&eacute;fono Fijo de Usuario:</strong></p>\
									<p><input type="text" class="inputlogin" id="newFijo" size="30" onkeydown="justInt(event,this.value)" maxlength="10" /></p>\
									<p><div id="errorFijo" class="smserrorTel"><I>N&uacute;mero Fijo Incorrecto</I></div></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
								</td>');
	}
	if(dato == 9){
		$('.modifyInfo').html('<td>\
									<p><strong>Cambiar Estado de Usuario:</strong></p>\
									<p><select id="newEstado" class="inputlogin">\
										<option value="0">Seleccione...</option>\
										<option value="Activo">Activo</option>\
										<option value="Inactivo">Inactivo</option>\
									</select></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
								</td>');
	}
	if(dato == 10){
		$('.modifyInfo').html('<td>\
									<p><strong>Cambiar Perfil de Usuario:</strong></p>\
									<p><select id="newPerfil" class="inputlogin">\
										<option value="0">Seleccione...</option>\
										<option value="Admin">Admin</option>\
										<option value="Socio">Socio</option>\
										<option value="Seguridad">Seguridad</option>\
										<option value="Auditor">Auditor</option>\
									</select></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
								</td>');
	}
	
	if(dato == 11){
		$('.modifyInfo').html('<td>\
									<p><strong>Cambiar Contraseña de Usuario:</strong></p>\
									<p><input type="text" class="inputlogin" id="newpass"  /></p>\
									<p><button type="button" class="btnlink" id="ok" onclick="save('+id+','+dato+')">Aceptar</button>&nbsp;&nbsp;\
									<button type="button" class="btnlink" id="no" onclick="cancelmodify()">Cancelar</button></p>\
								</td>');
	}
	$('html, body').animate({scrollTop: '0px'});
}

function cambio(){
	var ciudad = $('#newCiudad').val();
	var prov = $('#newProvincia').val();
	if(ciudad == 17){
		$('#otraCiudad').fadeIn('slow');
	}else{
		$('#otraCiudad').fadeOut('fast');
	}
	if(prov == 23){
		$('#otraProvincia').fadeIn('slow');
	}else{
		$('#otraProvincia').fadeOut('fast');
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

function validarRepeticion(valor){
	if(!$('#alerta2').is(':hidden')){
		$('#alerta2').fadeOut();
	}
	if(!$('#alerta3').is(':hidden')){
		$('#alerta3').fadeOut();
	}
	$('.usersok').each(function(){
		var mail = $(this).find('.mailbd').val();
		if(valor == mail){
			$('#alerta2').fadeIn();
			$('#newMail').val('');
			return false;
		}
		var cedula = $(this).find('.cedulabd').val();
		if(valor == cedula){
			$('#alerta3').fadeIn();
			$('#newCedula').val('');
			return false;
		}
	});
}

function save(id,dato){
	if(dato == 1){
		var nombre = $('#newNombre').val();
		var info = $('#nombres').val();
		if(nombre == ''){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificarusuario.php',{
				nombre : nombre, id : id, info : info, dato : dato
			}).done(function(data){
				alert('Campo Modificado');
				window.location = '';
			});
		}
	}
	if(dato == 2){
		var cedula = $('#newCedula').val();
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
			$('#errorcedmod').fadeIn('slow');
			$('#errorcedmod').delay(600).fadeOut('slow');
			$('#newCedula').val('');
		}
		if(digito_validador != ultimo_digito){
			$('#errorcedmod').fadeIn('slow');
			$('#errorcedmod').delay(600).fadeOut('slow');
			$('#newCedula').val('');
		}else{
			var cedula = $('#newCedula').val();
			var info = $('#cedula').val();
			if(cedula == ''){
				alert('Llene el Campo');
			}else{
				$.post('SP/modificarusuario.php',{
					cedula : cedula, id : id, info : info, dato : dato
				}).done(function(data){
					alert('Campo Modificado');
					window.location = '';
				});
			}
		}
	}
	if(dato == 3){
		var mail = $('#newMail').val();
		var info = $('#mail').val();
		if(mail == ''){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificarusuario.php',{
				mail : mail, id : id, info : info, dato : dato
			}).done(function(data){
				alert('Campo Modificado');
				window.location = '';
			});
		}
	}
	if(dato == 4){
		var dir = $('#newDireccion').val();
		var info = $('#direccion').val();
		if(dir == ''){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificarusuario.php',{
				dir : dir, id : id, info : info, dato : dato
			}).done(function(data){
				alert('Campo Modificado');
				window.location = '';
			});
		}
	}
	if(dato == 5){
		var ciudad = $('#newCiudad').val();
		if(ciudad == 17){
			ciudad = $('#otraCiudad').val();
		}else{
			ciudad = $('#newCiudad').val();
		}
		var info = $('#ciu').val();
		if(ciudad == 0){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificarusuario.php',{
				ciudad :ciudad, id : id, info : info, dato : dato
			}).done(function(data){
				alert('Campo Modificado');
				window.location = '';
			});
		}
	}
	if(dato == 6){
		var prov = $('#newProvincia').val();
		if(prov == 23){
			prov = $('#otraProvincia').val();
		}else{
			prov = $('#newProvincia').val();
		}
		var info = $('#pro').val();
		if(prov == 0){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificarusuario.php',{
				prov : prov, id : id, info : info, dato : dato
			}).done(function(data){
				alert('Campo Modificado');
				window.location = '';
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
				$.post('SP/modificarusuario.php',{
					movil : movil, id : id, info : info, dato : dato
				}).done(function(data){
					alert('Campo Modificado');
					window.location = '';
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
				$.post('SP/modificarusuario.php',{
					fijo : fijo, id : id, info : info, dato : dato
				}).done(function(data){
					alert('Campo Modificado');
					window.location = '';
				});
			}
		}
	}
	if(dato == 9){
		var estado = $('#newEstado').val();
		var info = $('#sto').val();
		if(estado == ''){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificarusuario.php',{
				estado : estado, id : id, info : info, dato : dato
			}).done(function(data){
				alert('Campo Modificado');
				window.location = '';
			});
		}
	}
	if(dato == 10){
		var perfil = $('#newPerfil').val();
		var info = $('#per').val();
		if(perfil == ''){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificarusuario.php',{
				perfil : perfil, id : id, info : info, dato : dato
			}).done(function(data){
				alert('Campo Modificado');
				window.location = '';
			});
		}
	}
	
	if(dato == 11){
		var newpass = $('#newpass').val();
		var pass = $('#pass').val();
		if(newpass == ''){
			alert('Llene el Campo');
		}else{
			$.post('SP/modificarusuario.php',{
				newpass : newpass, id : id, dato : dato
			}).done(function(data){
				alert('Campo Modificado');
				window.location = '';
			});
		}
	}
}
</script>