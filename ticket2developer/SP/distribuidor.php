<?php
	//include("controlusuarios/seguridadSP.php");
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="7" />';
	
	$gbd = new DBConn();
	
	$hoy = date("y-m-d");
	
	$sql = "SELECT idConcierto, strEvento, strImagen, strLugar, dateFecha, timeHora FROM Concierto WHERE dateFecha >= ?";
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute(array($hoy));
	
	$sql2 = "SELECT idConcierto, strEvento FROM Concierto WHERE dateFecha >= ?";
	$stmt2 = $gbd -> prepare($sql2);
	$stmt2 -> execute(array($hoy));
	$numRows = $stmt2 -> rowCount();

	$content = '';
	$content = '<input type="hidden" value="'.$numRows.'" id="numRows"/><div id="conciertos">';
	$count = 1;
	while($row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
		$content .= '<input type="hidden" value="'.$row2['idConcierto'].'" id="idConc'.$count.'" />
					<input type="hidden" value="'.$row2['strEvento'].'" id="desConc'.$count.'" />';
		$count++;
	}
	$content .= '</div>';
	echo $content;
	
	$sql3 = "SELECT * FROM distribuidor";
	$stmt3 = $gbd -> prepare($sql3);
	$stmt3 -> execute();
	
	$content2 = '';
	$content2 = '<div class="distribuidores">';
	while($row3 = $stmt3 -> fetch(PDO::FETCH_ASSOC)){
		$content2.= '<input type="hidden" class="documentosdb" value="'.$row3['documentoDis'].'" />
					<input type="hidden" class="maildb" value="'.$row3['mailDis'].'" />';
	}
	$content2.= '</div>';
	echo $content2;
?>
<script src="SP/js/nuevodistribuidor.js"></script>
<script src="SP/js/editardistribuidor.js"></script>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
				<p class="cabecera_distribuidores">Distribuidores</p>
				<p class="nuevo_distribuidor" style="display:none;">Nuevo Distribuidor</p>
				<p class="lista_distribudor" style="display:none;">Lista de Distribuidores</p>
			</div>
			<div class="cabecera_distribuidores">
				<div style="background-color:#00ADEF; margin:20px -42px 20px 40px; position:relative; padding:20px 0 10px; text-align:center; color:#fff; font-size:18px;">
					<button class="btndegradate" id="btn_new_distribuidor">Nuevo Distribuidor</button>&nbsp;&nbsp;&nbsp;&nbsp;
					<button class="btndegradate" id="btn_lista_distribuidor">Lista de Distribuidores</button>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
			</div>
			<div class="nuevo_distribuidor" style="display:none;">
				<div style="background-color:#00ADEF; margin:20px -42px -10px 40px; position:relative; padding:20px 0 10px; color:#fff; font-size:18px;">
					<div>
						<div class="alert alert-danger" role="alert" id="alerta1" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
							<strong>Error!</strong>... Existen campos incompletos
						</div>
						<div class="alert alert-danger" role="alert" id="alerta2" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
							<strong>Error!</strong>... Identificación Incorrecta
						</div>
						<div class="alert alert-danger" role="alert" id="alerta3" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
							<strong>Error!</strong>... E-mail Incorrecto
						</div>
						<div class="alert alert-info" role="alert" id="alerta4" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<strong>Excelente!</strong> Distribuidor guardado
						</div>
						<div class="alert alert-success alert-dismissible" id="alerta5" role="alert" style="margin:0 60px 0 20px; display:none;">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							 Esta Identificación ya existe... Revisa la <a class="alert-link" onclick="mostrarLista()" style="cursor:pointer; text-decoration:none;">Lista de Distribuidores</a>
						</div>
						<div class="alert alert-success alert-dismissible" id="alerta6" role="alert" style="margin:0 60px 0 20px; display:none;">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							 Este E-mail ya existe... Revisa la <a class="alert-link" onclick="mostrarLista()" style="cursor:pointer; text-decoration:none;">Lista de Distribuidores</a>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><span><strong>Nombre(Empresa):</strong></span></h4>
							<input type="text" class="form-control inputlogin" placeholder="Obligatorio" id="nombre" onkeydown="justText(event,this.value)" />
						</div>
						<div class="col-lg-5">
							<h4><span><strong>Identificación(RUC/CI):</strong></span></h4>
							<input type="text" class="form-control inputlogin" placeholder="Obligatorio" id="identificador" onkeydown="justInt(event,this.value)"  onkeyup="validarDistribuidor(this.value)"  maxlength="13" onchange="ValidarCedula()" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><span><strong>Teléfono Fijo:</strong></span></h4>
							<input type="text" class="form-control inputlogin" placeholder="022222222" id="telefono" onkeydown="justInt(event,this.value)" maxlength="9" />
						</div>
						<div class="col-lg-5">
							<h4><span><strong>Dirección:</strong></span></h4>
							<input type="text" class="form-control inputlogin" placeholder="Obligatorio" id="dir" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4><span><strong>Contacto:</strong></span></h4>
							<input type="text" class="form-control inputlogin" placeholder="Obligatorio" id="contacto" onkeydown="justText(event,this.value)" />
						</div>
						<div class="col-xs-5">
							<h4><span><strong>Teléfono Móvil:</strong></span></h4>
							<input type="text" class="form-control inputlogin" id="movil" placeholder="0999999999" onkeydown="justInt(event,this.value)" maxlength="10" />
						</div>
					</div>
					<div class="row" style = 'display:none;'>
						<div class="col-lg-5">
							<h4><span><strong>% por Ventas:</strong></span></h4>
							<input type="text" class="form-control inputlogin" value = '0' id="porcentajeventas" placeholder="%" onkeydown="justInt(event,this.value)" />
						</div>
						<div class="col-lg-5">
							<h4><span><strong>% por Cobros:</strong></span></h4>
							<input type="text" class="form-control inputlogin" value = '0' id="porcentajecobros" placeholder="%" onkeydown="justInt(event,this.value)" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<div class="row" style = 'display:none;'>
								<div class="col-xs-12">
									<h4><span><strong>% Tarjeta de Credito:</strong></span></h4>
									<input type="text" value = '0' class="form-control inputlogin" id="tarjeta" placeholder="%" onkeydown="justInt(event,this.value)" maxlength="10" />
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<h4><span><strong>E-mail:</strong></span></h4>
									<input type="text" class="form-control inputlogin" placeholder="example@dominio.com" id="mail" onchange="validarMail()" onkeyup="validarDistribuidor(this.value)" />
								</div>
								
							</div>
							<div class="row" >
								<div class="col-lg-12">
									<h4><span><strong>Password</strong></span></h4>
									<input type="password" class="form-control inputlogin" value = '' name="pass" id="pass" placeholder="Password" onkeydown="justInt(event,this.value)" />
								</div>
							</div>

							<div class="row">
								<div class="col-xs-6">
									<h4><span><strong>Clasificacion de Distribuidor</strong></span></h4>
									<select id = 'tipoEmp' class = 'inputlogin nomostrar form-control'>
										<option value = '0' >Seleccione</option>
										<option value="1">Ventas Ticket-facil</option>
										<option value="2">Cadena Comercial</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<h4><span><strong>Tipo de Distribuidor</strong></span></h4>
									<select id = 'tipoEmp2' class = 'inputlogin nomostrar form-control'>
										<option value = '1' >Seleccione</option>
										<option value="1">Normal</option>
										<option value="2">Especial</option>
										<option value="3">Impresion Domicilios</option>
									</select>
								</div>
							</div>
							<div class="row" style = 'display:none;' id = 'contieneSocio'>
								<div class="col-xs-6">
									<h4><span ><strong style = 'color:#fff;'>Escoja el Socio</strong></span></h4>
									<?php
										include 'conexion.php';
										$sqlS = 'SELECT * FROM Socio order by nombresS ASC';
										$resS = mysql_query($sqlS) or die (mysql_error());
									?>
									<select id = 'socio' class = 'inputlogin nomostrar form-control'>
										<?php
											while($rowS = mysql_fetch_array($resS)){
												echo "<option value = '".$rowS['idSocio']."' >".$rowS['nombresS']."</option>";
											}
										?>
									</select>
								</div>
								
							</div>
						</div>
						
						<div class="col-lg-5">
							<h4><span><strong>Observaciones:</strong></span></h4>
							<textarea id="observaciones" class="form-control inputlogin" placeholder="Obligatorio" rows="5"></textarea> <br><br>
							<div id = 'detalleCadena' style = 'display:none;'>
								
								<h4><span><strong>Seleccione Tipo de Cadena: </strong></span></h4><br>
								<table width = '70%' align = 'center'>
									<tr>
										<td style  = 'vertical-align:niddle;align:center;' >
											Kiosko <span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span> <input type = 'radio' name='tipos' value = '1'/>
										</td>
										<td style  = 'vertical-align:niddle;align:center;' >
											Persona <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <input type = 'radio' name='tipos' value = '2'/>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						
					</div>
					<div class="row" style="font-size:12px;" id = 'contieneEventos' >
						<div class="col-lg-10">
							<h4><strong>Asignar Conciertos</strong></h4>
						</div>
						<?php 
							$count = 1;
							while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
								echo '<div class="col-md-6 col-md-2 filasConciertos">
										<div class="thumbnail" style="height:250px;">
											<img src="https://www.ticketfacil.ec/ticket2/spadmin/'.$row['strImagen'].'" alt="">
											<div class="caption">
												<h4><strong>'.$row['strEvento'].'</strong></h4>
												<p><strong>Lugar: </strong>'.$row['strLugar'].'</p>
												<p><strong>Fecha: </strong>'.$row['dateFecha'].'</p>
												<p><strong>Hora: </strong>'.$row['timeHora'].'</p>
												<div class="btn btn-info btn-xs" style="position:absolute; right:5px; bottom:25px;"><input type="checkbox" class="checkEvento" style="transform: scale(1.2); -webkit-transform: scale(1.2);" id="check'.$count.'" value="'.$row['idConcierto'].'" /></div>
												</button>
											</div>
										</div>
									</div>';
								$count++;
							}
						?>
					</div>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div class="row" style="padding:30px 0;">
					<div class="col-lg-6" style="text-align:right;">
						<button class="btndegradate" onclick="guardarDatos()" id="btnguardar">Guardar</button>
						<img src="imagenes/loading.gif" id="wait" style="max-width:80px; display:none;" />
					</div>
					<div class="col-lg-5">
						<button class="btndegradate" onclick="cancelarNuevo()">Cancelar</button>
					</div>
				</div>
			</div>
			<div class="lista_distribudor" style="display:none;">
				<div style="background-color:#00ADEF; margin:20px -42px 20px 40px; position:relative; padding:20px 0 10px; text-align:center; color:#fff; font-size:18px;">
					<div class="row filtro">
						<div class="col-lg-4" style="text-align:right;">
							<h4><strong>Buscar por:</strong></h4>
						</div>
						<div class="col-lg-4">
							<select id="search" class="inputlogin form-control">
								<option value="0">Seleccione...</option>
								<option value="1">Identificación</option>
								<option value="2">Nombre</option>
							</select>
						</div>
						<div class="col-lg-3"></div>
					</div>
					<div class="row serchFechas" style="display:none; text-align:center;">
						<div class="col-lg-2"></div>
						<div class="col-lg-4">
							<input type="text" id="ruc" placeholder="Identificación..." class="inputlogin form-control">
						</div>
						<div class="col-lg-4">
							<button type="button" class="btnlink" id="buscarCli" onclick="buscar('1')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
							<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
						</div>
					</div>
					<div class="row byUser" style="display:none;">
						<div class="col-lg-2"></div>
						<div class="col-lg-4">
							<input type="text" id="name" placeholder="Nombre..." class="inputlogin form-control">
						</div>
						<div class="col-lg-4">
							<button type="button" class="btnlink" id="buscarCli" onclick="buscar('2')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
							<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
						</div>
					</div>
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div style="border:2px solid #00ADEF; margin:40px; text-align:center; display:none;" class="listaDistribuidores">
					<table id="select_conciertos" style="width:100%; color:#fff; font-size:18px; border-collapse:separate; border-spacing:15px 15px;">
						<tr style="text-align:center;">
							<td>
								<div class="registro"></div>
							</td>
						</tr>
					</table>
				</div>
				<div class="editarDistribuidor" style="border:2px solid #00ADEF; margin:40px; display:none;">
					<div>
						<div class="alert alert-danger" role="alert" id="alertaEdit1" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
							<strong>Error!</strong>... Existen campos incompletos
						</div>
						<div class="alert alert-danger" role="alert" id="alertaEdit2" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
							<strong>Error!</strong>... Identificación Incorrecta
						</div>
						<div class="alert alert-danger" role="alert" id="alertaEdit3" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
							<strong>Error!</strong>... E-mail Incorrecto
						</div>
						<div class="alert alert-info" role="alert" id="alertaEdit4" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<strong>Excelente!</strong> Distribuidor editado.
						</div>
						<div class="alert alert-success alert-dismissible" id="alertaEdit5" role="alert" style="margin:0 60px 0 20px; display:none;">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							 Esta Identificación ya existe... Revisa la <a class="alert-link" onclick="mostrarLista()" style="cursor:pointer; text-decoration:none;">Lista de Distribuidores</a>
						</div>
						<div class="alert alert-success alert-dismissible" id="alertaEdit6" role="alert" style="margin:0 60px 0 20px; display:none;">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
							 Este E-mail ya existe... Revisa la <a class="alert-link" onclick="mostrarLista()" style="cursor:pointer; text-decoration:none;">Lista de Distribuidores</a>
						</div>
						<div class="alert alert-info" role="alert" id="alertaEdit7" style="margin:0 60px 0 20px; display:none;">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<strong>Aviso!</strong> Petición procesada con Exito!
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4 style="color:#fff;"><span><strong>Nombres:</strong></span></h4>
							<input type="text" class="form-control inputlogin" id="nombreEditar" onkeydown="justText(event,this.value)" />
						</div>
						<div class="col-lg-5">
							<h4 style="color:#fff;"><span><strong>Identificación(RUC/CI):</strong></span></h4>
							<input type="text" class="form-control inputlogin" id="identificadorEditar" onkeydown="justInt(event,this.value)"  onkeyup="validarDistribuidor(this.value)"  maxlength="13" onchange="ValidarCedula()" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4 style="color:#fff;"><span><strong>Teléfono Fijo:</strong></span></h4>
							<input type="text" class="form-control inputlogin" placeholder="022222222" id="telefonoEditar" onkeydown="justInt(event,this.value)" maxlength="9" />
						</div>
						<div class="col-lg-5">
							<h4 style="color:#fff;"><span><strong>Dirección:</strong></span></h4>
							<input type="text" class="form-control inputlogin" placeholder="Obligatorio" id="dirEditar" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4 style="color:#fff;"><span><strong>Contacto:</strong></span></h4>
							<input type="text" class="form-control inputlogin" placeholder="Obligatorio" id="contactoEditar" onkeydown="justText(event,this.value)" />
						</div>
						<div class="col-lg-5">
							<h4 style="color:#fff;"><span><strong>E-mail:</strong></span></h4>
							<input type="text" class="form-control inputlogin" placeholder="example@dominio.com" id="mailEditar" onchange="validarMail()" onkeyup="validarDistribuidor(this.value)" />
						</div>
					</div>
					<div class="row" style = 'display:none;' >
						<div class="col-lg-5">
							<h4 style="color:#fff;"><span><strong>% por Ventas:</strong></span></h4>
							<input type="text" class="form-control inputlogin" id="poocentajeventasEditar" placeholder="%" onkeydown="justInt(event,this.value)" />
						</div>
						<div class="col-lg-5">
							<h4 style="color:#fff;"><span><strong>% por Cobros:</strong></span></h4>
							<input type="text" class="form-control inputlogin" id="porcentajecobrosEditar" placeholder="%" onkeydown="justInt(event,this.value)" />
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<h4 style="color:#fff;"><span><strong>Teléfono Móvil:</strong></span></h4>
							<input type="text" class="form-control inputlogin" id="movilEditar" placeholder="0999999999" onkeydown="justInt(event,this.value)" maxlength="10" />
							<h4 style="color:#fff;"><span><strong>Estado:</strong></span></h4>
							<select class="form-control inputlogin" id="estadoEdit">
								
							</select>
							<h4 style="color:#fff;"><span><strong>Clasificacion de Distribuidor:</strong></span></h4>
							<select class="form-control inputlogin" id="tipo_empDistri">
								
							</select>
							
							<h4 style="color:#fff;"><span><strong>Tipo de Distribuidor:</strong></span></h4>
							<select class="form-control inputlogin" id="tipo_empDistri2">
								
							</select>
						</div>
						<div class="col-lg-5">
							<h4 style="color:#fff;"><span><strong>Observaciones:</strong></span></h4>
							<textarea id="observacionesEditar" class="form-control inputlogin" placeholder="Obligatorio" rows="5"></textarea>
						</div>
					</div>
					<div class="row" style = 'display:none;' id = 'contieneSocio2'>
						<div class="col-xs-6">
							<h4><span><strong style = 'color:#fff;'>Escoja el Socio</strong></span></h4>
							<?php
								include 'conexion.php';
								$sqlS = 'select * from Socio order by nombresS ASC';
								$resS = mysql_query($sqlS) or die (mysql_error());
							?>
							<select id = 'socio2' class = 'inputlogin nomostrar form-control'>
								<?php
									
									while($rowS = mysql_fetch_array($resS)){
										echo "<option value = '".$rowS['idSocio']."' >".$rowS['nombresS']."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="row" id="conciertoXdistribuidorEditar" style="font-size:12px;">
					</div>
					<div class="row">
						<div class="col-lg-6" style="text-align:right;">
							<button id="btnguarda" class="btndegradate" onclick="saveEdicion(), prueba();$('#btnguarda').prop('disabled',true);">Guardar</button>
						</div>
						<div class="col-lg-5" style="text-align:left;">
							<button class="btndegradate" onclick="cancelarEdicion()">Cancelar</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Aviso</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-warning" role="alert" id="alertasAviso">
								<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;<strong>Alerta</strong>...Seguro desea modificar registro?
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" onclick="cancelDelete()" data-dismiss="modal">Cancelar</button>
							<button type="button" class="btn btn-primary" onclick="deleteFilas()">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" value="" id="iddelete" />
			<input type="hidden" value="" id="idDis" />
			<div id="eliminados" style="display:none;">
				
			</div>
		</div>
	</div>
</div>
<script>
$('#btn_new_distribuidor').on('click',function(){
	$('.cabecera_distribuidores').fadeOut('slow');
	$('.nuevo_distribuidor').delay(600).fadeIn('slow');
});

$('#btn_lista_distribuidor').on('click',function(){
	$('.cabecera_distribuidores').fadeOut('slow');
	$('.lista_distribudor').delay(600).fadeIn('slow');
});

$(document).ready(function(){
	$('#tipoEmp').change(function(){
		var tipoEmp = $('#tipoEmp').val();
		if(tipoEmp == 2){
			$('#detalleCadena').fadeIn('slow');
		}else{
			$('#detalleCadena').fadeOut('slow');
		}
	});
	$('.paginate').live('click', function(){
		window.scroll(0,0);
		var sector = $('#data').val();
		var nombre = $('#name').val();
		var ruc = $('#ruc').val();
		var dato = $('#search').val();
		$('.registro').html('<div class="loading"><img src="imagenes/loading.gif" width="70px"/></div>');
		var page = $(this).attr('data');
		$('.listaDistribuidores').fadeIn('slow');
		$.ajax({
			type: "GET",
			url: "SP/paginadorSP.php",
			data: {page : page, nombre : nombre, sector : sector, ruc : ruc, dato : dato},
			success: function(response){
				$('.registro').fadeIn(200).html(response);
			}
		});
	});
});

$('#search').on('change',function(){
	var tiposearch = $('#search').val();
	if(tiposearch == 1){
		$('.filtro').fadeOut('slow');
		$('.serchFechas').delay(600).fadeIn('slow');
	}else {
		$('.filtro').fadeOut('slow');
		$('.byUser').delay(600).fadeIn('slow');
	}
});

function cancel(){
	if(!$('.serchFechas').is(':hidden')){
		$('.serchFechas').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search').val(0);
	}else if(!$('.byUser').is(':hidden')){
		$('.byUser').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search').val(0);
	}
	$('.registro').html('');
}

function buscar(dato){
var sector = $('#data').val();
$('.listaDistribuidores').fadeIn('slow');
$('.registro').html('<div class="loading"><img src="imagenes/loading.gif" width="70px"/></div>');
if (dato == 1) {
	var ruc = $('#ruc').val();
	$.post('SP/paginadorSP.php',{
		dato : dato, sector : sector, ruc : ruc
	}).done(function(response){
		$('.registro').html(response);
	});
}else{
	$('.listaDistribuidores').fadeIn('slow');
	var nombre = $('#name').val();
	$.post('SP/paginadorSP.php',{
		dato : dato, sector : sector, ruc : ruc, nombre:nombre
	}).done(function(response){
		console.log(response);
		$('.registro').html(response);
	});
}
/*
		
	$('.listaDistribuidores').fadeIn('slow');
	var sector = $('#data').val();
	$('.registro').html('<div class="loading"><img src="imagenes/loading.gif" width="70px"/></div>');
	if(dato == 1){
		var ruc = $('#ruc').val();
		$.post('SP/paginadorSP.php',{
			dato : dato, sector : sector, ruc : ruc
		}).done(function(response){
			console.log(response);
			$('.registro').html(response);
		});
	}
	else if(dato == 2){
		var nombre = $('#name').val();
		console.log('es 3')
		if(nombre == '')
		$.post('SP/paginadorSP.php',{
			dato : dato, sector : sector, nombre : nombre
		}).done(function(response){
			console.log(response);
			$('.registro').html(response);
		});
	}*/
}

$( document ).ready(function() {
	$( "#tipoEmp2" ).change(function() {
		var tipoEmp2 = $( "#tipoEmp2" ).val();
		if(tipoEmp2 == 2){
			$('#contieneSocio').fadeIn('slow');
			$('#contieneEventos').fadeIn('slow');
		}else if(tipoEmp2 == 1){
			$('#contieneSocio').fadeOut('slow');
			$('#contieneEventos').fadeIn('slow');
		}else if(tipoEmp2 == 3){
			$('#contieneEventos').fadeOut('slow');
			$('#contieneSocio').fadeOut('slow');
		}
	})
	
	
	$( "#tipo_empDistri2" ).change(function() {
		var tipoEmp2 = $( "#tipo_empDistri2" ).val();
		if(tipoEmp2 == 2){
			$('#contieneSocio2').fadeIn('slow');
		}else{
			$('#contieneSocio2').fadeOut('slow');
		}
	})
});

function guardarDatos(){
	var nombre = $('#nombre').val();
	var documento = $('#identificador').val();
	var telefono = $('#telefono').val();
	var mail = $('#mail').val();
	var dir = $('#dir').val();
	var contacto = $('#contacto').val();
	var porcentajeventas = $('#porcentajeventas').val();
	var porcentajecobros = $('#porcentajecobros').val();
	var tarjetas = $('#tarjeta').val();
	var movil = $('#movil').val();
	var observaciones = $('#observaciones').val();
	var tipoEmp = $('#tipoEmp').val();
	var tipoEmp2 = $('#tipoEmp2').val();
	var socio = 0;
	var pass = $('#pass').val();
	if(tipoEmp2 == 2){
		socio = $('#socio').val(); 
	}else{
		socio = 0;
	}
	if(tipoEmp == 2){
		var tipos = $('input:radio[name=tipos]:checked').val();
	}else{
		var tipos = 0;
	}
	if(tipoEmp2 == 3){
		var valoresDis = 0;
	}else{
		var valoresDis = '';
		var countsave = 1;
		$('.filasConciertos').each(function(){
			if($('#check'+countsave).is(':checked')){
				var evento = $('#check'+countsave).val();
				valoresDis += evento +'|'+'@';
			}
			countsave++;
		});
		
		
		var valores_pasa = valoresDis.substring(0,valoresDis.length -1);

	}
	var identificador = 1;
	// alert('nombre : ' + nombre +'  '+ 'documento : ' + documento +'  '+ 'telefono : ' + telefono +'  '+ 'mail : ' + mail +'  '+ 'valoresDis : ' + valoresDis +'  '+ ' direccion : ' + dir +'  '+ ' contacto : ' + contacto +'  '+ ' movil : ' + movil +'  '+ ' observaciones : ' + observaciones +'password:'+pass)
	if(nombre == '' || documento == '' || telefono == '' || mail == '' || dir == '' || contacto == '' || movil == '' || observaciones == '' || pass == ''){
		$('#alerta1').fadeIn('slow');
		$('#alerta1').delay(1500).fadeOut('slow');
	}else{
		if(tipoEmp == 0){
			alert('Debe seleccionar un tipo de Distrubuidor');
		}else{
			$('#btnguardar').fadeOut('slow');
			$('#wait').delay(600).fadeIn('slow');
			$.post('SP/ajax/ajaxNuevoDistribuidor.php',{
				nombre : nombre, documento : documento, telefono : telefono, mail : mail, valoresDis : valores_pasa, identificador : identificador, dir : dir, 
				contacto : contacto, movil : movil, observaciones : observaciones, porcentajeventas : porcentajeventas, porcentajecobros : porcentajecobros, 
				tarjetas : tarjetas , tipoEmp : tipoEmp , tipos : tipos , tipoEmp2 : tipoEmp2 , socio : socio, password: pass
			}).done(function(response){
				if($.trim(response) == 'ok'){
					alert('Distribuidor creado con exito!');
					$('#alerta4').removeClass('alert-danger');
					$('#alerta4').addClass('alert-info');
					$('#alerta4').html('\
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>\
								<strong>Excelente!</strong> Distribuidor guardado\
							');
					$('#alerta4').fadeIn('slow');
					$('html, body').animate({ scrollTop: 0 }, 'slow');
					setTimeout("window.location='';",3000);
				}
				else if($.trim(response) == 'existe'){
					// alert ();
					$('html, body').animate({ scrollTop: 0 }, 'slow');
					$('#alerta4').removeClass('alert-info');
					$('#alerta4').addClass('alert-danger');
					$('#alerta4').html('EL USUARIO : ' + mail + ' YA EXISTE EN EL SISTEMA NO PUEDE CREAR OTRO CON EL MISMO EMAIL , \n POR FAVOR CAMBIELO Y VUELVA A INTENTARLO' );
					$('#alerta4').fadeIn('slow');
					$('#btnguardar').fadeIn('slow');
					$('#wait').delay(600).fadeOut('slow');
				}
			});
		}
	}
}
</script>