<?php 
	include("controlusuarios/seguridadSP.php");
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="32" />';
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
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body onload = '$("#boletoCanje").focus();'>
	<div style="margin: 10px -10px">
		<div style="background-color:#171A1B; padding:20px;">
			<div style="border: 2px solid #00AEEF; margin:20px;">
				<div style="background-color:#00ADEF; color:#fff; margin:20px 400px 0px 0px; padding-left:30px; font-size:22px;">
					<p><strong>NUEVO ADMINISTRADOR </strong></p>
				</div>
				<div class="row ">
					<div class = 'col-md-1'></div>
						<div class = 'col-md-9'>
							<div class="panel panel-info panel-dark">
								
								<div class="panel-body">
									<center>
										<input type = 'text' id = 'nom_admin' class = 'form-control' placeholder = 'INGRESE NOMBRE' /><br/>
										<input type = 'text' id = 'usu_admin' class = 'form-control' placeholder = 'INGRESE USUARIO' /><br/>
										<input type = 'password' id = 'pass_admin' class = 'form-control' placeholder = 'INGRESE PASSWORD'/>
										<br><br>
										<table class = 'table' >
											<tr>
												<td colspan = '3' style = 'text-align:center;' >
													SELECCIONE EL(LOS) MODULOS A ASIGNAR
												</td>
											</tr>
										<?php
											$sql = 'select * from modulos where nombre <> ""';
											$res = mysql_query($sql) or die(mysql_error());
											$i=0;
											while($row = mysql_fetch_array($res)){
												if($i == 0){
													echo '<tr>';
												}
										?>
												<td style = 'border:0px;' >
													<input type = 'checkbox' class = 'modulos' value = '<?php echo $row['id'];?>' />
													&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['nombre'];?>
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
										
										<br>
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
											</div>
										</div>
										
										
										<br><br><br>
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
					<div class = 'col-md-1'></div>
				</div>
				<div class='row' id='rescta' style='display:none;'>
					<div class='col-lg-12' >
						
					</div>
				</div>
				<script>

					$( document ).ready(function() {
						
						var socio = 43;
						$.post("adminNuevo/eventoPorSocio.php",{ 
							socio : socio
						}).done(function(data){
							$('#evento').html(data);
						});
							
							
						$( "#socio" ).change(function() {
							var socio = $( "#socio" ).val();
							$.post("adminNuevo/eventoPorSocio.php",{ 
								socio : socio
							}).done(function(data){
								$('#evento').html(data);
							});

						});
						
					});
					function creaAdmin(){
						var nom_admin = $('#nom_admin').val();
						var usu_admin = $('#usu_admin').val();
						var pass_admin = $('#pass_admin').val();
						var socio = $( "#socio" ).val();
						
						var modulosCheck = '';    
						$('.modulos:checked').each(function(){
							if (this.checked) {
								modulosCheck += $(this).val()+'|';
							}
						}); 
						var modulosCheckF = modulosCheck.substring(0, modulosCheck.length - 1);
						
						var eventosCheck = '';    
						$('.eventos_socio:checked').each(function(){
							if (this.checked) {
								eventosCheck += $(this).val()+'@';
							}
						}); 
						var eventosCheckF = eventosCheck.substring(0, eventosCheck.length - 1);
						if(nom_admin == ''){
							alert('Ingrese un nombre de ADMINISTRADOR');
						}
						
						
						if(usu_admin == ''){
							alert('Ingrese un usuario de ADMINISTRADOR');
						}
						
						
						if(pass_admin == ''){
							alert('Ingrese un password de ADMINISTRADOR');
						}
						
						if(modulosCheck == ''){
							alert('debe seleccionar al menos una opcion para el menu');
						}
						
						if(eventosCheck == ''){
							alert('debe seleccionar al menos una opcion de los eventos');
						}
						
						if(modulosCheck == '' || eventosCheck == '' || nom_admin == '' || usu_admin == '' || pass_admin == ''){
							
						}else{
							$.post("adminNuevo/creaAdmin.php",{ 
								nom_admin : nom_admin , usu_admin : usu_admin , pass_admin : pass_admin , 
								modulosCheckF : modulosCheckF , eventosCheckF : eventosCheckF , socio : socio
							}).done(function(data){
								alert(data);		
							});
						}
						
					}
				</script>
			</div>
		</div>
	</div>
</body>