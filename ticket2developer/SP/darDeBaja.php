<?php 
	//include("controlusuarios/seguridadSP.php");
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="31" />';
	echo $_SESSION['perfil'];
?>
<style>
	.label.label-warning.label-tag::before {
		border-color: transparent #f4b04f transparent transparent;
	}
	.label.label-tag::before {
		border-color: transparent #b0b0b0 transparent transparent;
	}
	.label.label-tag::before {
		border-style: solid;
		border-width: 10px 12px 10px 0;
		content: "";
		display: block;
		height: 0;
		margin-left: -17px;
		position: absolute;
		top: -1px;
		transform: rotate(360deg);
		width: 0;
	}
	*, *::after, *::before {
		box-sizing: border-box;
	}
	.label.label-tag::after {
		background: #fff none repeat scroll 0 0;
		border-radius: 99px;
		content: "";
		display: block;
		height: 6px;
		margin: -12px 0 0 -10px;
		position: absolute;
		width: 6px;
	}
	*, *::after, *::before {
		box-sizing: border-box;
	}
	.label.label-warning.label-tag {
		border: 1px solid #f4b04f;
	}
	.panel-heading-controls .badge, .panel-heading-controls > .label {
		margin-bottom: -10px;
		margin-top: 1px;
	}
	.label.label-warning {
		background: #f4b04f none repeat scroll 0 0;
	}
	.label.label-tag {
		border: 1px solid #b0b0b0;
	}
	.label.label-tag {
		border-bottom-left-radius: 0;
		border-top-left-radius: 0;
		display: inline-block;
		font-size: 16px;
		line-height: 18px;
		margin-left: 12px;
		padding: 0 5px;
		position: relative;
	}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body onload = '$("#boletoCanje").focus();'>
	<div data-keyboard="false" data-backdrop="static" class="modal fade" id="reporteMacroBaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
		<div class="modal-dialog" role="document" style = 'width:100%;' >
			<div class="modal-content">
				<div class="modal-header">
					<button onclick="$('#ver_bajaDist').fadeIn('slow');" type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
						&nbsp;&nbsp;<strong>REPORTE DE VENTAS</strong>&nbsp;!!
					</div>
				</div>
				<div class="modal-body" style="height: 550px; overflow-y: auto;">
					<div class="row">
						<div class="col-md-8">
							<div class="container">
								<div id="macroBaja"></div>
							</div>
						</div>
					</div>
					<div class="row"></div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
	<div data-keyboard="false" data-backdrop="static" class="modal fade" id="reporteMacroConBaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
		<div class="modal-dialog" role="document" style = 'width:100%;' >
			<div class="modal-content">
				<div class="modal-header">
					<button onclick="$('#dar_de_baja_lote').modal('show');" type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
						&nbsp;&nbsp;<strong>Reporte macro de ventas</strong>&nbsp;!!
					</div>
				</div>
				<div class="modal-body" style="height: 550px; overflow-y: auto;">
					<div class="row">
						<div class="col-md-8">
							<div class="container">
								<div id="macroBajaReport"></div>
							</div>
						</div>
					</div>
					<div class="row"></div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
	<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ver_bajaDist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
		<div class="modal-dialog" role="document" style = 'width:100%;' >
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
						&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;reporte de boletos que ya se encuentran de baja por distribuidor
					</div>
				</div>
				<div class="modal-body">
					<div class = 'row' >
						<div class="col-md-12">
							<h4>Seleccione el distribuidor:</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<select id="distribuidorBaja">
								
							</select>
						</div>
						<div class="col-md-6">
							<button id="verReporteMacroConBajaButton" class="btn btn-primary">VER REPORTE MACRO</button>
							<button id="reporteVendidosButton" class="btn btn-primary">VER REPORTE VENDIDOS</button>
						</div>
					</div>
				</div>
				<div class="modal-footer12">											
				</div>
			</div>
		</div>
	</div>
	<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ver_bajaDist1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
		<div class="modal-dialog" role="document" style = 'width:100%;' >
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
						&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;reporte de boletos que ya se encuentran de baja por distribuidor
					</div>
				</div>
				<div class="modal-body">
					<div id="probando"></div>
				</div>
				<div class="modal-footer">											
				</div>
			</div>
		</div>
	</div>
	<div style="margin: 10px -10px">
		<div style="background-color:#171A1B; padding:20px;">
			<div style="border: 2px solid #00AEEF; margin:20px;">
				<div style="background-color:#00ADEF; color:#fff; margin:20px 400px 0px 0px; padding-left:30px; font-size:22px;">
					<p><strong>MODULO PARA DAR DE BAJA BOLETOS </strong></p>
				</div>
				<div class="row ">
					<div class = 'col-md-1'></div>
						<div class = 'col-md-9'>
							<div class="panel panel-info panel-dark">
								<div class="panel-heading">
									<span class="panel-title"><span class="label label-tag label-warning">podra dar de baja cualquier ticket</span></span>
									<div class="panel-heading-controls">
										<div class="panel-heading-icon"><i class="fa fa-inbox"></i></div>
									</div>
								</div>
								<div class="panel-body">
								
								<div data-keyboard="false" data-backdrop="static" class="modal fade" id="dar_de_baja_lote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
									<div class="modal-dialog" role="document" style = 'width:100%;' >
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick = '$(".conclave").fadeIn("slow"); $(".sinclave").fadeOut("slow"); $("#ingresaClaveCon").val(""); ' ><span aria-hidden="true">&times;</span></button>
												<div class="alert alert-info" role="alert">
													<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
													&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;Se dara de baja el (los) boleto(s) seleccionados del usuario :  <?php echo $_SESSION['useractual'];?>
												</div>
											</div>
											<div class="modal-body">
												<div class = 'row' >
													<div class = 'col-md-3'>
														<?php
															session_start();
																include 'conexion.php';
																$hoy = date("Y-m-d"); 
																$idSocio = $_SESSION['iduser'];
																//dateFecha >= "'.$hoy.'" and
																if($_SESSION['perfil'] == 'Admin_Socio'){
																	
																	$filtro = 'where porcentajetarjetaC = "'.$idSocio.'"';
																	$sql = 'select * from Concierto 
																		'.$filtro.'
																		and costoenvioC > 0
																		ORDER BY 1 DESC
																		';
																}elseif($_SESSION['perfil'] == 'SP'){
																	$filtro = 'where costoenvioC > 0';
																	$sql = 'select * from Concierto
																		ORDER BY 1 DESC
																		';
																}elseif($_SESSION['perfil'] == 'Distribuidor'){
																	$fecha = date("Y-m-d");
																	$idDis = $_SESSION['idDis'];
																	$sql = '	SELECT idConcierto, dateFecha, strEvento, strImagen, strDescripcion, strLugar, timeHora, dateFecha 
																				FROM detalle_distribuidor 
																				JOIN Concierto 
																				ON detalle_distribuidor.conciertoDet = Concierto.idConcierto 
																				WHERE idDis_Det = "'.$idDis.'"
																				
																				AND estadoDet = "Activo"
																				
																				ORDER BY 1 DESC';
																}elseif($_SESSION['perfil'] == 'Socio'){
																	$sql ='	SELECT * FROM Concierto 
																			WHERE idUser = "'.$_SESSION['iduser'].'" 
																			and costoenvioC > 0
																			ORDER BY idConcierto DESC';
																}
																
																// echo $sql."<br><br>";
														?>
														Seleccione Evento
														<select class = 'form-control' id = 'evento_reimprime' >
															<option>Seleccione Evento</option>
															<?php
																$res = mysql_query($sql) or die (mysql_error());
																while($row = mysql_fetch_array($res)){
															?>	
																	<option value = '<?php echo $row['idConcierto'];?>' ><?php echo $row['strEvento'];?> [<?php echo $row['idConcierto'];?>]</option>
															<?php
																}
															?>
															
														</select>
													</div>
													<div class = 'col-md-6 conclave'><br/>
														<input type ='hidden' id ='recibeClaveCon' />
														<input type ='text' id ='ingresaClaveCon' class = 'form-control' placeholder = 'ingrese clave de dar de baja' />
														<button type="button" class="btn btn-warning" onclick = 'aceptarModal_clave(); verBaja()'>Enviar</button>
													</div>

													<div class = 'col-md-2 sinclave' style = 'display:none;'>
														Distribuidor
														<select class="form-control distribuidores">
														</select>
													</div>
													
													<div class = 'col-md-2 sinclave' style = 'display:none;'>
														Seleccione Localidad
														<select class = 'form-control localidades' id = 'local_desde'>
														</select>
													</div>
													
													<div class = 'col-md-1 sinclave' style = 'display:none;'>
														Boleto Desde
														<input onkeyup="desde();" type = 'text' class = 'form-control'  placeholder = 'DESDE SOLO NUMERO' id = 'desde' />
													</div>
													<div class = 'col-md-1 sinclave' style = 'display:none;'>
														Boleto Hasta
														<input onkeyup="hasta();" type = 'text' class = 'form-control'  placeholder = 'HASTA SOLO NUMERO' id = 'hasta' />
													</div>
													
													<div class = 'col-md-1 sinclave' style = 'display:none;'><br>
														<button type="button" class="btn btn-danger" id = 'cambiaBoleto' onclick = 'downBaja(2);'>Grabar</button>
													</div>
													<div class="col-md-1 sinclave" style="display: none;">
														<button type="button" id="evento_baja" class="btn btn-warning" onclick = '$("#ver_baja_lote1").modal("show")'>VER DADOS DE BAJA</button><h3><div id="bajas"></div><div id="showsum"></div></h3><h3><div id="bajasshow"></div></h3><input id="bajasx" type="hidden" name="" value=""><br><br>
													</div>
												</div>
											</div>
											<div class="modal-footer" >
												<center>
													<img src='https://www.ticketfacil.ec/imagenes/loading.gif' width='100px' style='display:none;' id='loadBoleto1'/>
												</center>
												<div id = 'recibePruebas'></div>
											</div>
										</div>
									</div>
								</div>
								<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ver_baja_lote1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
									<div class="modal-dialog" role="document" style = 'width:100%;' >
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
												<div class="alert alert-info" role="alert">
													<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
													&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;reporte de boletos dados de baja por evento!!
												</div>
											</div>
											<div class="modal-body">
												<div class = 'row' >
													<div class="row">
														<div class="col-md-12">
															<h3>Restablecer boletos dados de baja:</h3>
														</div>		
													</div>
													<div class = 'col-md-2 sinclave'>
														Seleccione Distribuidor
														<select class = 'form-control distri-dist' id = 'distri-dist'>
															<option value = ''>Seleccione</option>
														</select>
													</div>
													<div class = 'col-md-2 sinclave'>
														Seleccione Localidad
														<select class = 'form-control localidades loc' id = 'locali'>
															<option value = ''>Seleccione</option>
														</select>
													</div>
													<div class = 'col-md-1 sinclave' style = 'display:none;'>
														Boleto Desde
														<input type = 'text' class = 'form-control desde'  placeholder = 'DESDE SOLO NUMERO' id = 'desdeact' />
													</div>
													<div class = 'col-md-1 sinclave' style = 'display:none;'>
														Boleto Hasta
														<input type = 'text' class = 'form-control hasta'  placeholder = 'HASTA SOLO NUMERO' id = 'hastaact' />
													</div>
													
													<div class = 'col-md-2 sinclave' style = 'display:none;'><br>
														<button type="button" class="btn btn-danger" onclick = 'downBaja(1)'>Restablecer</button>
													</div>
													<div class = 'col-md-2 sinclave' style = 'display:none; margin-left: -70px !important;'><br>
														<button type="button" class="btn btn-success" onclick = 'bajaDist();'>Baja por distribuidor</button>
													</div>
													<div class = 'col-md-12' id = 'recibeBoletos'>
														
													</div>
													<div id="recibeBaja">
														
													</div>
													
												</div>
											</div>
											<div class="modal-footer"  >
												<img src='https://www.ticketfacil.ec/imagenes/loading.gif' width='100px' style='display:none;' id='loadBoleto1'/>
												<div id = 'recibePruebas'>
													
												</div>
												<div id="recibeBoletosBaja">
													
												</div>
											</div>
										</div>
									</div>
								</div>
								<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ver_baja_lote2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
									<div class="modal-dialog" role="document" style = 'width:100%;' >
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
												<div class="alert alert-info" role="alert">
													<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
													&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;!!
												</div>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-4">
														Boletos reimpresos:
													</div>
													<div class="col-md-8"></div>
												</div>
												<div class="d"></div>
												<div class="row">
													<h4>¿Que desea hacer?</h4>
														<button onclick="activarBoletosDesactivados(1)" class="btn btn-primary">Activar de todas formas</button>
														<button onclick="activarBoletosDesactivados(2)" class="btn btn-primary">Activar solo no reimpresos</button>
														<button data-dismiss="modal" class="btn btn-primary">Cancelar</button>
												</div>
											</div>
											<div class="modal-footer"  >
											</div>
										</div>
									</div>
								</div>
								<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ver_baja_lote3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
									<div class="modal-dialog" role="document" style = 'width:100%;' >
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
												<div class="alert alert-info" role="alert">
													<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
													&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;!!
												</div>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-4">
														Boletos reimpresos:
													</div>
													<div class="col-md-8"></div>
												</div>
												<div class="lote3"></div>
												<div class="row">
													<h4>¿Que desea hacer?</h4>
														<button onclick="activarBoletosDesactivadosNoBaja(1)" class="btn btn-primary">Dar de baja de todas formas</button>
														<button onclick="activarBoletosDesactivadosNoBaja(2)" class="btn btn-primary">Dar solo no reimpresos</button>
														<button data-dismiss="modal" class="btn btn-primary">Cancelar</button>
												</div>
											</div>
											<div class="modal-footer">
											</div>
										</div>
									</div>
								</div>
								<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ver_impresos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
									<div class="modal-dialog" role="document" style = 'width:100%;' >
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
												<div class="alert alert-info" role="alert">
													<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
													&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;reporte de boletos que ya se encuentran impresos!!
												</div>
											</div>
											<div class="modal-body">
												<div class = 'row' >
													<h4>Estos boletos ya se encuentran impresos:</h4>
													<div>
														<h4 id="pru"></h4>
													</div>
													<div>
														<h4>¿Que desea hacer?</h4>
														<button onclick="ok()" class="btn btn-primary">Activar de todas formas</button>
														<button class="btn btn-primary">Activar solo no impresos</button>
														<button class="btn btn-primary">Cancelar</button>
													</div>
												</div>
											</div>
											<div class="modal-footer"  >
													<button id="buttonimpresos" class="btn btn-primary">Aceptar</button>												
											</div>
										</div>
									</div>
								</div>
									<center>
										<button type="button" class="btn btn-danger" onclick = '$("#dar_de_baja_lote").modal("show");  $("#ver_baja_lote").modal("hide");'>DAR DE BAJA EN LOTE</button><br><br>
										
										<div id = 'de_uno' >
											<input class = 'form-control' id="boletoCanje" placeholder="Por favor escanee el código de barras de su boleto!" style="text-align: center" type="number" />
											<br><br>
											<button class="btn btn-labeled btn-primary">
												<i class="fa fa-floppy-o" aria-hidden="true"></i>
												&nbsp;&nbsp;Enviar
											</button>
											<br><br>
											<img src='https://www.ticketfacil.ec/imagenes/loading.gif' width='100px' style='display:none;' id='loadBoleto'/>
										</div>	
									</center>
								</div>
							</div>
						</div>
					<div class = 'col-md-1'></div>
				</div>
				<div class='row' id='rescta' style='display:none;'>
					<div class='col-lg-12' >
						
					</div>
				</div>
				<script>

					var arrText= new Array();
					$("#evento_baja").click(function(e){

						var evento_baja = $('#evento_reimprime').val();
						if(evento_baja == ''){
							$('.localidades').html('');
						}else{
							$.post('subpages/boletosEventoBaja1.php',{ 
								evento_baja : evento_baja,  
							}).done(function(data){
								$('#recibeBoletos').html(data);
								$('#recibeBoletos').effect('highlight');
							});
						}
					});

					function desde() {

						var evento = $('#evento_reimprime').val();
						var l = $('#local_desde').val();
						var d = $('#desde').val();
						var h = $('#hasta').val();
						var bajas = Number($('#bajasx').val().replace(/[^0-9.]/g, ""));
						var px = '';

						$.ajax({
							method:'POST',
							url:'subpages/daDeBajaBoleto1.php',
							data:{local_desde : l, desde: d, hasta: h, evento_reimprime: evento},
							async:false,
							success:function (response) {
								px = response;
							}
						});

						$('#showsum').html('+'+px);
						$('#bajasshow').html((Number(px)+Number(bajas))+'(Luego de dar de baja)');
					}

					function hasta() {
						var evento = $('#evento_reimprime').val();
						var l = $('#local_desde').val();
						var d = $('#desde').val();
						var h = $('#hasta').val();
						var bajas = Number($('#bajasx').val().replace(/[^0-9.]/g, ""));
						var px = '';

						$.ajax({
							method:'POST',
							url:'subpages/daDeBajaBoleto1.php',
							data:{local_desde : l, desde: d, hasta: h, evento_reimprime: evento},
							async:false,
							success:function (response) {
								px = response;
							}
						});
						$('#showsum').html('+'+px);
						$('#bajasshow').html((Number(px)+Number(bajas))+'(Luego de dar de baja)');

					}

					$('#reporteVendidosButton').on('click', function () {

						var eventDistribuidor = $('#distribuidorBaja').val();
						var eventConcert1 = $('#evento_reimprime').val();
						var tipo_reporte = 3;
						var pventas = $('#distribuidorBaja').val();
						var concertBaja = $('#evento_reimprime').val();

						if (eventDistribuidor == '' || eventDistribuidor == 0) {
							alert('Debe ingresar un distribuidor');
						}else{
							$('#probando').html('');
							$.ajax({
								method:'POST',
								url:'Estadisticas/ajax/distBaja.php',
								data:{ pventas:eventDistribuidor, id:eventConcert1, tipo_reporte : 3},
								success: function (response) {
									$('.modal-footer12').css('height', '350px');
									$('.modal-footer12').css('overflow-y', 'auto')
									$('.modal-footer12').html(response);
								}
							})
						}
					});


					$('#verReporteMacroConBajaButton').on('click', function () {
						
						var eventDistribuidor = $('#distribuidorBaja').val();
						var eventConcert1 = $('#evento_reimprime').val();
						var tipo_reporte = 3;
						var pventas = $('#distribuidorBaja').val();
						var concertBaja = $('#evento_reimprime').val();

						$('#probando').html('');

						$.ajax({
							method:'POST',
							url:'Estadisticas/ajax/distBaja.php',
							data:{ pventa:eventDistribuidor, id:eventConcert1, tipo_reporte:tipo_reporte },
							success:function (response) {
								$('#probando').html(response);
								$.ajax({
									method:'POST',
									url:'spadmin/verReporteBorderoMunicipioVentas_baja.php',
									data:{ id:concertBaja, pventas: pventas },
									success: function (response) {
										$('.modal-footer12').css('height', '350px');
										$('.modal-footer12').css('overflow-y', 'auto')
										$('.modal-footer12').html(response);
									}
								})
							}
						})
					})

					function bajaDist() {

						$('#ver_baja_lote1').modal('hide');
						$('#dar_de_baja_lote').modal('hide');
						$('#ver_bajaDist').modal('show');
						var eventConcert = $('#evento_reimprime').val();
						$('#distribuidorBaja').html('espere');

						$.ajax({
							method:'POST',
							url:'spadmin/saberPventaEvento.php',
							data:{evento_distri : eventConcert},
							success:function (response) {
								$('#distribuidorBaja').html(response);
							}
						})
					}

					function activarBoletosDesactivados(option) {
						var evento = $('#evento_reimprime').val();
						var l = $('#locali').val();
						var d = $('#desdeact').val();
						var h = $('#hastaact').val();

						var con = confirm('Seguro que deseas activar estos boletos?');

						if (con == true) {
							var data1 = '';
							if (option == 1) {
								$('#num-boletos').each(function () {
									data1 = $(this).text();
								})
							}
							$('#no-reimpresos').each(function () {
								data1 = data1 + $(this).text();
							})
							var data1 = data1.substring(1, data1.length);
							$.post('subpages/prueba_post.php',{ 
								data : data1, localidad : l, evento: evento, 
							}).done(function(datos){
								if (datos == 1) {
									alert('Boletos activados!');
									var evento_baja = $('#evento_reimprime').val();
									$.post('subpages/boletosEventoBaja.php',{ 
										evento_baja : evento_baja 
									}).done(function(data){
										$('#bajas').html(data);
										$('#bajasx').val(data);
									});
									$.post('subpages/boletosPorLocalidad2.php', {
										localiact : l, evento_reimprime : evento
									}).done(function(dataBoletos){
										$('#recibeBoletos').html(dataBoletos);
										$('#ver_baja_lote2').modal('hide');
									})
								}else{
									alert('Error');
								}
							});
						}
					}
					function activarBoletosDesactivadosNoBaja(option) {
						var evento = $('#evento_reimprime').val();
						var l = $('#local_desde').val();
						var d = $('#desdeact').val();
						var h = $('#hastaact').val();
						var con = confirm('Seguro que deseas dar de baja estos boletos?');
						if (con == true) {
							var data = '';
							if (option == 1) {
								$('#num-boletos-2').each(function () {
									data = $(this).text();
								})
							}
							$('#no-reimpresos-2').each(function () {
								data = data + $(this).text();
							})
							var data = data.substring(1, data.length);
							$.post('subpages/pruebas_post_2.php',{ 
								data : data, localidad : l, evento: evento,  
							}).done(function(data){
								if (data == 1) {
									alert('Boletos dados de baja!');
									var evento_baja = $('#evento_reimprime').val();
									$.post('subpages/boletosEventoBaja.php',{ 
										evento_baja : evento_baja 
									}).done(function(data){
										$('#bajas').html(data);
										$('#bajasx').val(data);
									});
									$.post('subpages/boletosPorLocalidad.php', {
										local_desde : l, evento_reimprime : evento
									}).done(function(dataBoletos){
										$('#recibePruebas').html(dataBoletos);
										$('#ver_baja_lote3').modal('hide');
									})
								}else{
									alert('Error');
								}
							});
						}else{
						}
					}
					function downBaja(option) {
						data = '';
						if (option == 1) {
							var evento = $('#evento_reimprime').val();
							var l = $('#locali').val();
							var d = $('#desdeact').val();
							var h = $('#hastaact').val();
							var distriDown = $('#distri-dist').val();
							$.post('subpages/pruebas.php',{ 
								e : evento, d : d, l : l, h : h, distri:distriDown  
							}).done(function(data){
								if (data != 1) {
									$('.d').html(data);
									$('#ver_baja_lote2').modal();
								}else{
									$.post('subpages/activaBoletoBaja.php', {
										localiact : l, desdeact: d, hastaact: h, evento_reimprime: evento, distri:distriDown
									}).done(function (dataActiva) {
										if (dataActiva == 1) {
											alert('Estos boletos pertenecen a otro distribuidor o se encuentran en otra localidad');
										}else if(dataActiva == 2){
											alert('Boletos activados con exito!');
											setTimeout(function () {
												var evento_baja = $('#evento_reimprime').val();
												$.post('subpages/boletosEventoBaja3.php',{ 
													evento_baja : evento_baja, distri:distriDown 
												}).done(function(data){
													$('#bajas').html(data);
													$('#bajasx').val(data);
												});
												$.post('subpages/boletosPorLocalidad2.php', {
													localiact : l, evento_reimprime : evento, distri:distriDown
												}).done(function(dataBoletos){
													$('#recibeBoletos').html(dataBoletos);
												})
											}, 1000);
										}else{
											alert('Ha ocurrido un error, intente de nuevo');
										}
									});
								}
							});
						}else{
							var evento = $('#evento_reimprime').val();
							var l = $('#local_desde').val();
							var d = $('#desde').val();
							var h = $('#hasta').val();
							var distri = $('.distribuidores').val();
							$.post('subpages/pruebas2.php', {
								e : evento, d : d, l : l, h : h
							}).done(function (data2) {
								if (data2 != 1) {
									$('.lote3').html(data2);
									$('#ver_baja_lote3').modal();
								}else{
									$.post('subpages/daDeBajaBoleto.php', {
										local_desde : l, desde: d, hasta: h, evento_reimprime: evento, distri:distri
									}).done(function (dataActiva) {
										if (dataActiva == 1) {
											alert('Estos boletos pertenecen a otro distribuidor o estan en otra localidad');
										}else if(dataActiva == 2){
											alert('Boletos dados de baja con exito!');
											setTimeout(function () {
												var evento_baja = $('#evento_reimprime').val();
												$.post('subpages/boletosEventoBaja3.php', { 
													evento_baja : evento_baja, distri:distri 
												}).done(function(data){
													$('#bajas').html(data);
													$('#bajasx').val(data);
												});
												$.post('subpages/boletosPorLocalidad4.php', {
													local_desde : l, evento_reimprime : evento, distri:distri
												}).done(function(dataBoletos){
													$('#recibePruebas').html(dataBoletos);
												})
											}, 1000);
										}else{
											alert('Ha ocurrido un error, intente de nuevo');
										}
									});
								}
							})
						}
					}
					function aceptarModal_clave(){
						var clave = $('#recibeClaveCon').val();
						var recibeClave = $('#ingresaClaveCon').val();
						if((clave != recibeClave)){
							alert('la clave es incorrecta');
							$('#recibeClave').val('');
						}
						if(recibeClave == ''){
							alert('ingrese la clave');
						}
						if((clave == recibeClave) && recibeClave != ''){
							$(".conclave").css('display','none');
							$(".sinclave").fadeIn('slow');
						}else{
							
						}
					}
					function cambiaBoleto(){
						var local_desde = $('#local_desde').val();
						var desde = $('#desde').val();
						var hasta = $('#hasta').val();
						var evento_reimprime = $('#evento_reimprime').val();
						
						if(local_desde == ''){
							alert('seleccione boleto inicio');
						}
						if(desde == ''){
							alert('ingrese localidad inicio');
						}
						if(hasta == ''){
							alert('ingrese boleto final');
						}
						if(local_desde == '' || desde == '' || hasta == ''){
							alert('Debe ingresar los campos');
						}else{
							$.post("subpages/daDeBajaBoleto.php",{ 
								local_desde : local_desde , desde : desde , hasta : hasta , evento_reimprime : evento_reimprime
							}).done(function(data){
								if (data == 1) {
									alert("Estos boletos ya se encuentran dados de baja o están en otro punto de venta");
								}else{
									if(data==2){
										$('#recibePruebas').html('Cargando');
										setTimeout(function(){
											alert('Boletos dados de baja con exito');
										}, 1000);
									}
									if(data==3){
										$('#recibePruebas').html('el(los) ticket(s) ya ingresaron, no puede darlos de baja');
											alert('el(los) ticket(s) ya ingresaron, no puede darlos de baja');
									}
									setTimeout(function(){
										$.post('subpages/boletosPorLocalidad.php',{ 
											local_desde : local_desde , evento_reimprime : evento_reimprime
										}).done(function(data){
											
											$('#recibePruebas').html(data);
											$('#recibePruebas').effect('highlight');
											var evento_baja = $('#evento_reimprime').val();
											$.post('subpages/boletosEventoBaja.php',{ 
												evento_baja : evento_baja 
											}).done(function(data){
												$('#bajas').html(data);
												$('#bajasx').val(data);
											});
											
										});

									}, 2000);
								}
								
							});
						}
					}
					function activaBoleto(){
						var localiact = $('#locali').val();
						var desdeact = $('#desdeact').val();
						var hastaact = $('#hastaact').val();
						var evento_reimprime = $('#evento_reimprime').val();
						
						if(locali == ''){
							alert('seleccione boleto inicio');
						}
						if(desdeact == ''){
							alert('ingrese localidad inicio');
						}
						if(hastaact == ''){
							alert('ingrese boleto final');
						}
						if(localiact == '' || desdeact == '' || hastaact == ''){
							alert('Debe ingresar los campos');
						}else{
							var self = this;
							$.post("subpages/activaBoletoBaja.php",{ 
								localiact : localiact, desdeact : desdeact, hastaact:hastaact, evento_reimprime : evento_reimprime
							}).done(function(data){
								if (data == 1) {
									alert("Estos boletos ya se encuentran activos o están en otro punto de venta");
								}else if(data == 2){
									$('#recibePruebas').html('Cargando');
										setTimeout(function(){
											alert('Boletos activados con exito');
											$.post('subpages/boletosPorLocalidad2.php',{ 
												localiact : localiact , evento_reimprime : evento_reimprime
											}).done(function(data){
												$('#recibeBoletos').html('');
												$('#recibeBoletos').html(data);
												$('#recibeBoletos').effect('highlight');
											});
										}, 1000);
								}else if(data==3){
									setTimeout(function(){
										$('#recibePruebas').html('Error modificando');
									}, 2000);
								}
								else{
									var arr = [];
									$('#pru').html(data);
									$('#ver_impresos').modal();
									$(".sss").each(function(index, value){
										var valu = $(value).html();
										arr.push($(value).text());
										$.post('subpages/prueba.php',{ 
											valu : valu 
										}).done(function(data){
										});
							        });
								}
							});
						}
					}
					
					function verBaja() {
						var evento_baja = $('#evento_reimprime').val();
						$.post('subpages/boletosEventoBaja.php',{ 
							evento_baja : evento_baja 
						}).done(function(data){
							$('#bajas').html(data);
							$('#bajasx').val(data);
						});
					}

					$("#boletoCanje").keyup(function(e){
						$("#boletoCanje").css("background-color", "pink");
						var boleto = $("#boletoCanje").val();
						if(e.keyCode == 13){
							$("#boletoCanje").blur(); 
							$("#loadBoleto").css('display','block'); 
							$.post('SP/darDeBajaBoleto.php',{
								boleto : boleto
							}).done(function(data){
								$("#loadBoleto").css('display','none');
								alert(data);
								window.location = '';
							});
						}
					});

					$("#boletoCanje").blur(function(){
						$("#boletoCanje").css("background-color", "white");
					});
					$(document).ready(function() {

						$("#evento_distri_reimp").change(function(e){
							$('#imgifDistri').fadeIn('slow');
							var idconciertotrans = $('#evento_distri_reimp').val();
							
							if(idconciertotrans == ''){
								$('#recibeReimpresionesDist').html('');
							}else{
								$.post('Estadisticas/ajax/reimpresiones_boletos.php',{ 
									idconciertotrans : idconciertotrans 
								}).done(function(data){
									$('#recibeReimpresionesDist').html(data);
									$('#imgifDistri').fadeOut('slow');
								});
							}
						});

						$("#evento_reimprime").change(function(e){
							$(".conclave").css('display','block');
							$(".sinclave").fadeOut('slow');
							$("#ingresaClaveCon").val('');
							$('#recibePruebas').html('');
							var evento_reimprime = $('#evento_reimprime').val();
							if(evento_reimprime == ''){
								$('.localidades').html('');
							}else{
								$.ajax({
									method:'POST',
									url:'spadmin/saberPventaEvento.php',
									data:{evento_distri : evento_reimprime},
									success:function (response) {
										$('.distribuidores').html(response);
										$('.distri-dist').html(response);
									}
								})
								$.post('subpages/localidadEvento.php',{ 
									evento_reimprime : evento_reimprime 
								}).done(function(data){
									var res = data.split("|");
									$('#recibeClaveCon').val(res[1]);
									$('.localidades').html(res[0]);
									$('.localidades').effect('highlight');
								});
							}
						});

						$("#local_desde").change(function(e){
							$('#recibePruebas').html('');
							var local_desde = $('#local_desde').val();
							var evento_reimprime = $('#evento_reimprime').val();
							var distri = $('.distribuidores').val();
							if (distri == '') {
								alert('Debe ingresar un distribuidor');
							}else{
								$('#loadBoleto1').css('display','block');
								$.post('subpages/boletosPorLocalidad3.php',{ 
									local_desde : local_desde , evento_reimprime : evento_reimprime, distri:distri
								}).done(function(data){
									$('#loadBoleto1').css('display','none');
									$('#recibePruebas').html(data);
									$('#recibePruebas').effect('highlight');
								});
							}
						});
						$("#locali").change(function(e){
							$('#recibePruebas').html('');
							var edist = $('.distri-dist').val();
							var localiact = $('#locali').val();
							var evento_reimprime = $('#evento_reimprime').val();
							$('#loadBoleto1').css('display','block');
							$.post('subpages/boletosPorLocalidad2.php',{ 
								localiact : localiact , evento_reimprime : evento_reimprime, distri:edist
							}).done(function(data){
								$('#loadBoleto1').css('display','none');
								$('#recibeBoletos').html(data);
								$('#recibeBoletos').effect('highlight');
								$('input[id=data-value]').each(function(){
								    arrText.push($(this).val());
								});
								$.post('subpages/pruebas.php',{ 
									array : arrText
								}).done(function(data){
								});
							});
						});
					});
				</script>
			</div>
		</div>
	</div>
</body>