<?php 
	session_start();
	echo $_SESSION['perfil'];
	include("controlusuarios/seguridadSP.php");
	include 'conexion.php';
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="33" />';
	echo '<input type="hidden" id="idUsu" value="'.$_REQUEST['idUsu'].'" />';
	include 'conexion.php';
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
	.hover:hover{
		background-color:#00ADEF;
		color:#fff;
		cursor:pointer;
	}
	
	.seleccionado{
		background-color:#00ADEF;
		color:#fff;
		cursor:pointer;
	}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body onload = '$("#boletoCanje").focus();'>
	<div style="">
		<div style="background-color:#171A1B; padding:20px;">
			<div style="border: 2px solid #00AEEF;padding-right: 20px">
				<div style="background-color:#00ADEF; color:#fff;font-size:22px;width: 65%;padding:15px">
					<p><strong>LISTADO DE ADMINISTRADORES </strong></p>
				</div>
				<div class="row ">
					<div class = 'col-md-1'></div>
						<div class = 'col-md-12'>
							<div class="panel panel-info panel-dark">
								<div class="panel-body">
									<div class = 'row'>
										<div class = 'col-xs-3'>
											<div class="list-group">
											<?php
												$sqlU = 'select * from Usuario where strPerfil = "Admin_Socio"';
												$resU = mysql_query($sqlU) or die (mysql_error());
												$i=0;
												while($rowU = mysql_fetch_array($resU)){
											?>
												<label id = 'idUsu_<?php echo $rowU['idUsuario'];?>' style = 'text-transform:uppercase;font-size:13px;font-weight:300;' onclick = 'verDetalleAdmin(<?php echo $rowU['idUsuario'];?>)'  class="list-group-item hover">
													<?php echo $rowU['strNombreU'].'--'.$rowU['idUsuario'];?><br>
													<label style = 'font-size:12px;font-weight:0;text-transform:lowercase;'><?php echo $rowU['strMailU'];?></label>
												</label>
											<?php
													$i++;
												}
											?>
											</div>
										</div>
										<div class = 'col-xs-8'>
											<table class = 'table' >
											<tr>
												<td colspan = '3' style = 'text-align:center;' >
													SELECCIONE EL(LOS) MODULOS A ASIGNAR
												</td>
											</tr>
											<?php
												$sqlM = '	
															select * from modulos where nombre <> ""
														';
												$resM = mysql_query($sqlM) or die (mysql_error());
												$i=0;
												while($rowM = mysql_fetch_array($resM)){
													$sqlMa = 	'
																	SELECT * 
																	FROM modulo_admin as ma 
																	where id_usuario = "'.$_REQUEST['idUsu'].'" 
																	and id_modulo = "'.$rowM['id'].'"
																';
													$resMa = mysql_query($sqlMa) or die (mysql_error());
													$rowMa = mysql_fetch_array($resMa);
													//echo $rowM['id']."<<>>".$rowMa['id_modulo']."<br>";
													if($rowM['id'] == $rowMa['id_modulo']){
														$seleccionado = 'checked';
														$txt = '<span style = "color:#fff;" >seleccionado</span>';
														$class = 'danger';
														$funcion = 'poneMenu('.$_REQUEST['idUsu'].' , '.$rowMa['id'].' , 0)';
														$title = 'Quitar Modulo : '.$rowM['nombre'].' !!!';
													}else{
														$seleccionado = '';
														$txt = '<span style = "color:#fff;" >seleccionar</span>';
														$class = 'primary';
														$funcion = 'poneMenu('.$_REQUEST['idUsu'].' , '.$rowM['id'].' , 1 )';
														$title = 'Asignar Modulo : '.$rowM['nombre'].' !!!';
													}
													if($i == 0){
														echo '<tr>';
													}
											?>
													<td style = 'border:0px;width:33.33%;'>
														<button title = '<?php echo $title;?>' onclick = '<?php echo $funcion;?>' style = 'width:100%;' type="button" class="btn btn-<?php echo $class;?> btn-xs"><?php echo $rowM['nombre'];?><br><center><?php echo $txt;?></center></button>
													</td>
											<?php
													if($i == 2){
														echo '</tr>';
														$i=0;
													}else{
														$i++;
													}
												}
											?>
												
											</table>
											
											
											<table class = 'table' >
											<tr>
												<td colspan = '3' style = 'text-align:center;' >
													SELECCIONE EL(LOS) EVENTOS A ASIGNAR
												</td>
											</tr>
											<?php
												$hoy = date("Y-m");  
												//echo $hoy
												$sqlM = '	
															select * from Concierto where porcentajetarjetaC = "'.$_REQUEST['idUsu'].'" order by idConcierto DESC
														';
												//echo $sqlM;
												$resM = mysql_query($sqlM) or die (mysql_error());
												$i=0;
												while($rowM = mysql_fetch_array($resM)){
													$sqlMa = 	'
																	SELECT * 
																	FROM Concierto 
																	where porcentajetarjetaC = "'.$_REQUEST['idUsu'].'"
																	and idConcierto = "'.$rowM['idConcierto'].'" 
																';
													$resMa = mysql_query($sqlMa) or die (mysql_error());
													$rowMa = mysql_fetch_array($resMa);
													//echo $rowM['id']."<<>>".$rowMa['id_modulo']."<br>";
													if($rowM['idConcierto'] == $rowMa['idConcierto']){
														$seleccionado = 'checked';
														$txt = '<span style = "color:#fff;" >seleccionado</span>';
														$class = 'danger';
														$funcion = 'poneConcierto('.$_REQUEST['idUsu'].' , '.$rowMa['idConcierto'].' , 0)';
														$title = 'Quitar Evento : '.$rowM['strEvento'].' !!!';
													}else{
														$seleccionado = '';
														$txt = '<span style = "color:#fff;" >seleccionar</span>';
														$class = 'primary';
														$funcion = 'poneConcierto('.$_REQUEST['idUsu'].' , '.$rowM['idConcierto'].' , 1 )';
														$title = 'Asignar Evento : '.$rowM['strEvento'].' !!!';
													}
													if($i == 0){
														echo '<tr>';
													}
											?>
													<td style = 'border:0px;width:50%;'>
														<button title = '<?php echo $title;?>' onclick = '<?php echo $funcion;?>' style = 'width:100%;' type="button" class="btn btn-<?php echo $class;?> btn-xs"><?php echo $rowM['strEvento'].'-'.$rowM['idConcierto'];?><br><center><?php echo $txt;?></center></button>
													</td>
											<?php
													if($i == 1){
														echo '</tr>';
														$i=0;
													}else{
														$i++;
													}
												}
											?>
												
											</table>
											
											<br>
											<center>Asignar mas Eventos</center>
											<?php
												$perfil = 'Socio';
												$selectClientes = 'SELECT idUsuario, strNombreU FROM Usuario WHERE strPerfil = "'.$perfil.'" ';
												$resSelectClientes = mysql_query($selectClientes) or die(mysql_error());
											?>
											<div class = 'row' >
												<div class="col-lg-3">
													Seleccione Socio 
													<select id="socio" class="inputlogin form-control">
														<option value="0">TODOS...</option>
														<?php 
															while($rowSelectClientes = mysql_fetch_array($resSelectClientes)){
																if($rowSelectClientes['idUsuario'] == 43){
																	$selected = 'selected';
																}else{
																	$selected = '';
																}
														?>
														<option value="<?php echo $rowSelectClientes['idUsuario'];?>" <?php echo $selected;?>><?php echo $rowSelectClientes['strNombreU'];?></option>
														<?php }?>
													</select>
												</div>

												<div class="col-lg-8">
													Seleccione Evento(s)
													<table id="evento" class="table">
													
													</table>
													<br><br><br>
													<center>
														<button class="btn btn-labeled btn-primary" onclick = 'creaAdmin()' >
															<i class="fa fa-floppy-o" aria-hidden="true"></i>
															&nbsp;&nbsp;Enviar
														</button>
														<br><br>
														<img src='https://www.ticketfacil.ec/imagenes/loading.gif' width='100px' style='display:none;' id='loadBoleto'/>
													</center>
												</div>
												
											</div>
										</div>
									</div>
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
				
					$( document ).ready(function() {
						var idUsu = $('#idUsu').val();
						var socio = 43;
						$.post("adminNuevo/eventoPorSocio2.php",{ 
							socio : socio , idUsu : idUsu
						}).done(function(data){
							$('#evento').html(data);
						});
							
							
						$( "#socio" ).change(function() {
							var idUsu = $('#idUsu').val();
							var socio = $( "#socio" ).val();
							$.post("adminNuevo/eventoPorSocio2.php",{ 
								socio : socio , idUsu : idUsu
							}).done(function(data){
								$('#evento').html(data);
							});

						});
						
					});
					function creaAdmin(){
						
						var idUsu = $('#idUsu').val();
						var eventosCheck = '';    
						$('.eventos_socio:checked').each(function(){
							if (this.checked) {
								eventosCheck += $(this).val()+'@';
							}
						}); 
						var eventosCheckF = eventosCheck.substring(0, eventosCheck.length - 1);
						
						
						if(eventosCheck == ''){
							alert('debe seleccionar al menos una opcion de los eventos');
						}
						
						if(eventosCheck == ''){
							
						}else{
							$('#loadBoleto').css('display','block');
							$.post("adminNuevo/creaAdmin2.php",{ 
								idUsu : idUsu , eventosCheckF : eventosCheckF 
							}).done(function(data){
								alert(data);
								window.location = '';							
							});
						}
						
					}
					function poneConcierto(idUsu , id_modulo , ident){
						$.post("adminNuevo/editaAdminEventos.php",{ 
							idUsu : idUsu , id_modulo : id_modulo , ident : ident
						}).done(function(data){
							alert(data);
							window.location = '';
						});
					}
					function poneMenu(idUsu , id_modulo , ident){
						$.post("adminNuevo/editaAdmin.php",{ 
							idUsu : idUsu , id_modulo : id_modulo , ident : ident
						}).done(function(data){
							alert(data);
							window.location = '';
						});
					}
					$( document ).ready(function() {
						console.log( "ready!" );
						var idUsu = $('#idUsu').val();
						$('#idUsu_'+idUsu).addClass('seleccionado');
					});
					function verDetalleAdmin(idUsu){
						window.location = '?modulo=ver_admin&idUsu='+idUsu;
					}
				</script>
			</div>
		</div>
	</div>
</body>