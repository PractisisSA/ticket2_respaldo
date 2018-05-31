<?php
	session_start();
	//include("controlusuarios/seguridadSA.php");
	include 'conexion.php';
	echo $_SESSION['iduser'];
	
	$sqlM = 'select socio from modulo_admin where id_usuario = "'.$_SESSION['iduser'].'" ';
	$resM = mysql_query($sqlM) or die (mysql_error());
	$rowM = mysql_fetch_array($resM);
	
	
	if($_SESSION['autentica'] == 'tFADMIN_SOCIO'){
		
		$filtro = '';//and idUsuario = "'.$rowM['socio'].'" 
	}else{
		$filtro = '';
	}
	
	
	require('Conexion/conexion.php');
	include 'conexion.php';
	$perfil = 'Socio';
	$selectSocio = 'SELECT idUsuario, strNombreU FROM Usuario WHERE strPerfil = "'.$perfil.'" '.$filtro.' ' or die(mysqli_error());
	
	//echo $selectSocio;
	
	$resSelectClientes = $mysqli->query($selectSocio);
	echo '<input type="hidden" id="data" value="12" />';
	$current_time = date ("Y-m-d");
	
?>
	<script>
		$('#flecha12').fadeIn('fast');
		$('#menu12').addClass('allmenuactive');
		$('#menuinf12').addClass('allmenuactive');
	</script>
<style>
	.fecha{
		color:#000;
	}
	.artistas{
		border:1px solid #fff; 
		margin:0;
		text-align:center;
	}
	.detalleart{
		border:1px solid #fff; 
		margin:0;
	}
input[type="text"] , select , textarea {
		width:100%;
	}
	
	
	input[type="radio"]{ display: none; }

label{
  color:#fff;
  font-family: Arial;
  font-size: 14px;
}



input[type="radio"] + label span{
  display: inline-block;
  width: 19px;
  height: 19px;
  background: url(https://www.ticketfacil.ec/ticket2/spadmin/img/check_radio_sheet.png) -38px top no-repeat;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor:pointer;
}

input[type="radio"]:checked + label span{
  background: url(https://www.ticketfacil.ec/ticket2/spadmin/img/check_radio_sheet.png) -57px top no-repeat;
}
</style>
<script src="spadmin/ajaxupload.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/>
<script src="js/jquery.datetimepicker.js"></script>
<script language="javascript" src="spadmin/jquery.canvasAreaDraw.js"></script>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 500px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
				<strong>Datos Generales del Concierto</strong>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:22px;">
				<strong>Paso #1</strong>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Empresario(Dueño del evento): </strong></h4>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<select id="user" class="inputlogin form-control">
						<option value="0">Seleccione...</option>
						<?php while($rowSelectClientes = mysqli_fetch_array($resSelectClientes)){?>
						<option value="<?php echo $rowSelectClientes['idUsuario'];?>"><?php echo $rowSelectClientes['strNombreU'];?></option>
						<?php }?>
					</select>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Escoja el Diseño del Ticket</strong></h4>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<select id="disenio_ticket" class="inputlogin form-control">
						<option value="0">Seleccione Diseño...</option>
						<?php
							$sqlDT = 'SELECT * FROM disenoticket order by id asc';
							$resDT = mysql_query($sqlDT) or die (mysql_error());
							$options = '';
							while($rowDT = mysql_fetch_array($resDT)){
								$options.='<option value = "'.$rowDT['id'].'">'.$rowDT['ticket'].'</option>';
							}
							echo $options;
						?>
					</select>
				</div>
			</div>
			
			<div class="row">
			
				<div class="col-lg-12">
					<h4 style="color:#fff;"><p><strong>Escoja el tipo de Concierto</strong></p></h4>
				</div>
				<div class="col-lg-5" style='background-color: #00709B;padding-top: 15px;padding-left:15px;padding-bottom: 2px'>
					<p>
						<input type="radio" id="r1" checked name="tipoConcierto" value = "1" />
						<label for="r1"><span></span>Concierto Físico</label>
					</p>
					
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5" style='background-color: #00709B;padding-top: 15px;padding-left:15px;padding-bottom: 2px'>
					<p>
						<input type="radio" id="r2" name="tipoConcierto"  value = "2"/>
						<label for="r2"><span></span>Concierto Electrónico</label>
					</p>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Nombre del Evento:</strong></h4>
					<input type="text" class="inputlogin form-control" id="evento" />
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Lugar del Evento:</strong></h4>
					<input type="text" class="inputlogin form-control" id="lugar" />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Seleccione Autorización SRI</strong></h4>
					<?php
						include '../conexion.php';
						$sqlAut = '	select a.idAutorizacion , a.nroautorizacionA , s.razonsocialS , a.secuencialfinalA , serieemisionA
									from autorizaciones as a , Socio as s 
									where registradoA <> "ok" 
									and a.idsocioA = s.idSocio 
									and idAutorizacion not in(select tiene_permisos from Concierto) 
									order by idAutorizacion DESC ';
						$resAut = mysql_query($sqlAut) or die (mysql_error());
						$txt = 'Sin Permisos';
						echo "	<select style='color:#fff;' id = 'autSri' class='inputlogin form-control'>
									<option value='0'>Seleccione...</option>
									<option value='0' secuencialfinalA = '0'>".$txt."</option>";
						while($rowAut = mysql_fetch_array($resAut)){
							echo '<option value="'.$rowAut['idAutorizacion'].'" secuencialfinalA ="'.$rowAut['secuencialfinalA'].'" >'.$rowAut['razonsocialS'].' Aut Num :  '.$rowAut['nroautorizacionA'].' -- ['.$rowAut['serieemisionA'].']  Num Bol : '.$rowAut['secuencialfinalA'].'</option>';
						}
						echo "</select>";
					?>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Ingrese Autorización Municipal</strong></h4>
					<input type="text" class="inputlogin form-control" id="autMun" placeholder="sin permisos (000-000-000)" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-5" id = 'contieneImgCen' style = '<?php echo $display;?>' >
					<h4 style="color:#fff;"><strong>Imagen Centro  SOLO PCX:</strong></h4>
					<h5 style="color:#fff;"><strong>EL PCX QUE VA A SUBIR DEBE NOMBRARSE ASI:</strong></h5>
					<h5 style="color:#fff;"><strong>#_ACE.pcx</strong></h5>
					<div class="input-group">
						<input value = "<?php echo $rowc['img_bol_cen'];?>" class="inputlogin form-control" placeholder="Centro" type="text" id="fotoCen" readonly="readonly" aria-describedby="basic-addon2" style="color:#000;">
						<span class="input-group-addon" id="basic-addon2">
							<div style="" id="uploadCen">
								<img src="spadmin/examina.png"  style="border:0; margin:-2px;" alt="">
							</div>
						</span>
					</div>
					<img id="fotoCenMostrar" style="width:100%;" alt = 'cen'/>
				</div>
				
				<div class="col-lg-6"></div>
			</div>
			<div class = 'row' >
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Imagen del Evento:</strong></h4>
					<div class="input-group">
						<input class="inputDescripciones inputlogin form-control" placeholder="Nombre de la Imagen" type="text" id="imagen" readonly="readonly" aria-describedby="basic-addon2" style="color:#000;">
						<span class="input-group-addon" id="basic-addon2">
							<div style="" id="upload">
								<img src="spadmin/examina.png"  style="border:0; margin:-2px;" alt="">
							</div>
						</span>
					</div>
					<div style="position:relative; display:none;" id="btnborrarimg">
						<img id="foto" style="width:100%;" />
						<div style="position:absolute; top:0px; right:0;">
							<button type="button" class="btn btn-success" onclick="borrarimg()" title="Eliminar">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
						</div>
						<div class="imgeliminadas">
							
						</div>
					</div>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Descripción del Evento</strong></h4>
					<textarea rows="5" cols="30" id="des" class="inputlogin form-control" placeholder="Motivos de Creación"></textarea>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Subir imagen del mapa del concierto</strong></h4>
					<div class="input-group">
						<input class="inputDescripciones inputlogin form-control" placeholder="Nombre de la Imagen" type="text" id="imagenmapa" readonly="readonly" aria-describedby="basic-addon2" style="color:#000;">
						<span class="input-group-addon" id="basic-addon2">
							<div style="" id="uploadmapa">
								<img src="spadmin/examina.png"  style="border:0; margin:-2px;" alt="">
							</div>
						</span>
					</div>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<div style="position:relative; display:none;" id="btnborrarimgmapa">
						<img id="mapa_completo" style="width:100%;" class="mapa" />
						<div style="position:absolute; top:0px; right:0;">
							<button type="button" class="btn btn-success" onclick="borrarimgmapa()" title="Eliminar">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
						</div>
						<div class="imgeliminadasmapa">
							
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Subir imagen OPACA del mapa del concierto</strong></h4>
					<div class="input-group">
						<input class="inputDescripciones inputlogin form-control" placeholder="Nombre de la Imagen" type="text" id="imagenmapa1" readonly="readonly" aria-describedby="basic-addon2" style="color:#000;">
						<span class="input-group-addon" id="basic-addon2">
							<div style="" id="uploadmapa1">
								<img src="spadmin/examina.png"  style="border:0; margin:-2px;" alt="">
							</div>
						</span>
					</div>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<div style="position:relative; display:none;" id="btnborrarimgmapa1">
						<img id="mapa_completo1" style="width:100%;" class="mapa" />
						<div style="position:absolute; top:0px; right:0;">
							<button type="button" class="btn btn-success" onclick="borrarimgmapa()" title="Eliminar">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
						</div>
						<div class="imgeliminadasmapa">
							
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Video Promocional:</strong></h4>
					<div class="input-group">
						<input type="text" id="video" placeholder="Link de YOUTUBE" class="inputlogin form-control" aria-describedby="basic-addon2" >
						<span class="input-group-addon" id="basic-addon2" onclick="$('#tuto').modal('show');" style="cursor:pointer;" title="Tutorial">
							Tutorial
						</span>
					</div>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Fecha del Evento:</strong></h4>
					<input type="text" readonly="readonly" class="fecha inputlogin form-control" id="f_evento" placeholder="AAAA-MM-DD" min="<?php echo $current_time;?>" />
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Hora del Evento:</strong></h4>
					<input type="text" id="hora" class="hora inputlogin form-control" placeholder="00:00" />
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Fecha Limite Pre-Venta:</strong></h4>
					<input type="text" readonly="readonly" id="pre_venta" class="fecha inputlogin form-control" placeholder="AAAA-MM-DD" min="<?php echo $current_time;?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Fecha Limite de Reservaciones:</strong></h4>
					<input type="text" readonly="readonly" class="fecha inputlogin form-control" id="reserva" placeholder="AAAA-MM-DD" min="<?php echo $current_time; ?>" />
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Fecha Limite Pago Reservaciones:</strong></h4>
					<input type="text" readonly="readonly" id="pago_reserva" class="fecha inputlogin form-control" placeholder="AAAA-MM-DD" min="<?php echo $current_time;?>" />
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Género del Evento:</strong></h4>
					<select id="caracteristica" class="inputlogin form-control" onchange="chooseGenero()">
						<option value="0">Seleccione...</option>
						<option value="Alternativo">Alternativo</option>
						<option value="Bachata">Bachata</option>
						<option value="Balada">Balada</option>
						<option value="Bolero">Bolero</option>
						<option value="Chicha">Chicha</option>
						<option value="Clasica">Cl&aacute;sica-Instrumental</option>
						<option value="Country">Country</option>
						<option value="Cristiana">Cristiana</option>
						<option value="Cumbia">Cumbia</option>
						<option value="Electronica">Electr&oacute;nica</option>
						<option value="Flamenco">Flamenco</option>
						<option value="Folk">Folk</option>
						<option value="Gospel">Gospel</option>
						<option value="Gothic">Gothic</option>
						<option value="HipHop">HIP-HOP</option>
						<option value="Instrumental">Instrumental</option>
						<option value="Jazz">Jazz</option>
						<option value="Lambadas">Lambadas</option>
						<option value="Merengue">Merengue</option>
						<option value="Metal">Metal</option>
						<option value="Pop">Pop</option>
						<option value="Punk">Punk</option>
						<option value="Ranchera">Ranchera</option>
						<option value="Rap">Rap</option>
						<option value="Reggae">Reggae</option>
						<option value="Regaeton">Regaeton</option>
						<option value="Rock">Rock</option>
						<option value="Salsa">Salsa</option>
						<option value="Samba">Samba</option>
						<option value="Tango">Tango</option>
						<option value="Tecno">Tecno</option>
						<option value="Vallenatos">Vallenatos</option>
						<option value="1">Otro...</option>
					</select>
					<div class="input-group" id="otrogen" style="display:none;">
						<input type="text" class="inputlogin form-control" id="otrogenero" placeholder="Escribe el género..." aria-describedby="basic-addon2">
						<span class="input-group-addon" id="basic-addon2" onclick="cancelargenero()" style="cursor:pointer;" title="Cancelar">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</span>
					</div>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Número de Artistas: </strong></h4>
					<select id="num_artistas" class="inputlogin form-control" onchange="cantidadArtistas()">
						<option value="0">Seleccione...</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">Más...</option>
					</select>
					<div class="input-group" id="numeroart" style="display:none;">
						<input type="text" class="inputlogin form-control" id="masartistas" placeholder="Número de Artistas..." maxlength="2" onkeyup="masartistas()" aria-describedby="basic-addon2">
						<span class="input-group-addon" id="basic-addon2" onclick="cancelarmasartistas()" style="cursor:pointer;" title="Cancelar">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</span>
					</div>
				</div>
			</div>
			<div id="numartistas" style="color:#fff; padding-left:55px;">
				
			</div>
			
			<div class="row">
				<div class="col-lg-3">
					<h4 style="color:#fff;"><strong>Documento Categorizado : </strong></h4>
					<select class="form-control" id="docu">
						<option>Si</option>
						<option>No</option>
					</select>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-3">
					<h4 style="color:#fff;"><strong>Desglosa impuestos : </strong></h4>
					<select class="form-control" id="desg">
						<option>Si</option>
						<option>No</option>
					</select>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-2">
					<h4 style="color:#fff;"><strong>Visualizacion web y eventos reales</strong></h4>
					<select class="form-control" id="costoenvio">
						<option selected>Si</option>
						<option>No</option>
					</select>
				</div>
			</div>
			
			<div class="row"  style='border-top: 2px solid #EA1467;'>
				<div class="col-lg-12">
					<h3 style='color:#fff;'>INFORMACIÓN RESERVADA PARA LOS CANJES DE RESERVAS</h3>
				</div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Tiempo limite para pago por Punto de Venta o Depósito:</strong></h4>
					<select id="tiempolimete" class="inputlogin form-control" onchange="choosetiempolimete()">
						<option value="0">Seleccione...</option>
						<option value="24 Horas">24 Horas</option>
						<option value="48 Horas">48 Horas</option>
						<option value="72 Horas">72 Horas</option>
						<option value="96 Horas">96 Horas</option>
						<option value="1 Semena">1 Semana</option>
						<option value="1">Otro...</option>
					</select>
					<div class="input-group" id="otrotiempo" style="display:none;">
						<input type="text" class="inputlogin form-control" id="otrotiempolimite" placeholder="Otro tiempo limite..." aria-describedby="basic-addon2">
						<span class="input-group-addon" id="basic-addon2" onclick="cancelarotro()" style="cursor:pointer;" title="Cancelar">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</span>
					</div>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Dirección de canje de TICKET's:</strong></h4>
					<input type="text" class="inputlogin form-control" id="dircanje" />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Fecha Inicio de canje de TICKET's:</strong></h4>
					<input type="text" readonly="readonly" class="fecha inputlogin form-control" id="iniciocanje" placeholder="AAAA-MM-DD" min="<?php echo $current_time; ?>" />
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Fecha Limite de canje de TICKET's:</strong></h4>
					<input type="text" readonly="readonly" id="finalcanje" class="fecha inputlogin form-control" placeholder="AAAA-MM-DD" min="<?php echo $current_time;?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-1"></div>
				<div class="col-lg-11">
					<h4 style="color:#fff;"><strong>Envio de TICKET's a domicilio:</strong></h4>
					<input type="text" id="cosEnv2" placeholder="Ej : 1" class="inputlogin form-control"/>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-5">
					<h4 style="color:#fff;"><strong>Horario de canje de Boletos:</strong></h4>
					<span style="color:#fff;">*Hora de Apertura:</span>
					<input type="text" class="hora inputlogin form-control" id="horarioinicial"/>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-5">
					<span style="color:#fff;">*Hora de Cierre:</span>
					<input type="text" class="hora inputlogin form-control" id="horariofinal"/>
				</div>
			</div>
			
			
			
			<div style='border-top: 2px solid #EA1467;border-bottom: 2px solid #EA1467;'>
				<h3 style='color:#fff;'>INFORMACIÓN RESERVADA PARA LOS PAGOS DE RESERVAS</h3>
				<div class="row">
					<div class="col-lg-5">
						<h4 style="color:#fff;"><strong>Lugar de Pago</strong></h4>
						<input type="text" class="inputlogin form-control" id="lugPago" placeholder="Lugar" />
					</div>
					<div class="col-lg-1"></div>
					<div class="col-lg-5">
						<h4 style="color:#fff;"><strong>Direccion de Pago</strong></h4>
						<input type="text" id="dirPago" placeholder="Direccion de Pago" class="inputlogin form-control"/>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-5">
						<h4 style="color:#fff;"><strong>Fecha Pago</strong></h4>
						<input type="text" class="inputlogin form-control" id="fecPago" placeholder="Desde yy-mm-dd  Hasta  yy-mm-dd" />
					</div>
					<div class="col-lg-1"></div>
					<div class="col-lg-5">
						<h4 style="color:#fff;"><strong>Hora de Pago</strong></h4>
						<input type="text" id="horPago" placeholder="hh:mm -- hh:mm" class="inputlogin form-control"/>
					</div>
				</div>
			</div>
			
			<div style='border-top: 2px solid #EA1467;border-bottom: 1px solid #EA1467;'>
				<table class="table table-border" style='font-size:13px;color:#fff;'>
					<tr>
						<td style="vertical-align:middle; text-align:center;" colspan="7">
							<font size="6"><p><strong>Detalle porcentaje de descuentos y comisiones</strong></p></font>
						</td>
					</tr>
					<tr>
						<td>

						</td>
						<td>
							COMISIÓN TARJETA
						</td>
						<td>
							RETENCIÓN IVA
						</td>
						<td>
							RETENCIÓN RENTA
						</td>
						<td>
							% DESCUENTO 3ra EDAD
						</td>
						<td>
							COMISIÓN POR VENTAS
						</td>
						<td>
							COMISIÓN POR COBROS
						</td>
					</tr>
					<?php
						$txtBtnComision = 'Grabar';
						$identificador = 2;
						for($m=0;$m<=2;$m++){
							if($m==0){
								$txtComision = 'cadena comercial';
							}
							if($m==1){
								$txtComision = 'PUNTOS TICKET FACIL';
							}
							if($m==2){
								$txtComision = 'PAGINA WEB';
							}
					?>
							<tr class='valores_comi_ret'>
								<td>
									<?php echo $txtComision;?>
									<input type = 'hidden' value = '<?php echo $m;?>' class = 'id_comi_tar' />
								</td>
								<td valign='middle' align = 'center' style = 'text-align:center;'>
									<input type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'comi_tar entero' />
								</td>
								<td valign='middle' align = 'center' style = 'text-align:center;'>
									<input type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'ret_iva entero' />
								</td>
								<td valign='middle' align = 'center' style = 'text-align:center;'>
									<input type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'ret_renta entero' />
								</td>
								<td valign='middle' align = 'center' style = 'text-align:center;'>
									<input type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'des_ter_edad entero' />
								</td>
								<td valign='middle' align = 'center' style = 'text-align:center;'>
									<input type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'comi_venta entero' />
								</td>
								<td valign='middle' align = 'center' style = 'text-align:center;'>
									<input type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'comi_cobro entero' />
								</td>
							</tr>
					<?php
						}
					?>
						<!--
						<tr>
							<td valign='middle' align = 'center' style='text-align:center;' colspan = '9'>
								<button type="button" class="btnlink" id="add_artistas" onclick = 'envia_det_comi_ret(<?php echo $identificador;?>)'>
									<strong><?php echo $txtBtnComision;?></strong>
								</button>
							</td>
						</tr>-->
				</table>
			</div>
			
			<div style='border-top: 1px solid #EA1467;border-bottom: 1px solid #EA1467;'>
				<table class="table table-border" style='font-size:13px;color:#fff;'>
					<tr>
						<td style="vertical-align:middle; text-align:center;" colspan="7">
							<font size="6"><p><strong>Detalle comisión venta en linea</strong></p></font>
						</td>
					</tr>
            		<tr>
            			<td>

            			</td>
            			<td>
            				% DE COMISIÓN
            			</td>
            			<td>
            				VALOR COMISIÓN
            			</td>
            		</tr>
            		<tr>
            			<td>
                            PAYPAL
            			</td>
            			<td>
                            <input type='text' placeholder='0' id='porccomisionpaypal' name='porccomisionpaypal' value='0' style='color:#000;'/>
            			</td>
            			<td>
                            <input type='text' placeholder='0.99' id='valcomisionpaypaypal' name='valcomisionpaypaypal' value='0' style='color:#000;'/>
            			</td>
            		</tr>
                    <tr>
            			<td>
                            STRIPE
            			</td>
            			<td>
                            <input type='text' placeholder='0' id='porccomisionstripe' name='porccomisionstripe' value='0' style='color:#000;'/>
            			</td>
            			<td>
                            <input type='text' placeholder='0.99' id='valcomisionpaystripe' name='valcomisionpaystripe' value='0' style='color:#000;'/>
            			</td>
            		</tr>
				</table>
			</div>
			
			<br>
			<center>
				<p style="color:#fff; font-size:30px;">Agregar las localidades del evento</p>
				<h3 style='color:#EA1467;' id='txtBolAut'></h3>
				<h3 id='txtBolAutVendidos'></h3>
			</center>
			
			<input type='hidden' id='numeroDeBoletosAutorizados' />
			<input type='hidden' id='numeroDeBoletosConfigurados' />
			<table id="localidad" class="loc" align="center" style="color:#fff; width:100%;">
				<tr align="center">
					<td style="border: #c0c0c0 solid 1px;width:280px;">
						<p><strong>Descripci&oacute;n</strong></p>
					</td>
					<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
						<p style = 'writing-mode:vertical-lr;'><strong>Precio</strong></p>
					</td>
					<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
						<p style = 'writing-mode:vertical-lr;'><strong>% Reserva</strong></p>
					</td>
					<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
						<p style = 'writing-mode:vertical-lr;'><strong>Precio Reserva</strong></p>
					</td>
					<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
						<p style = 'writing-mode:vertical-lr;'><strong>% Pre-Venta</strong></p>
					</td>
					<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
						<p style = 'writing-mode:vertical-lr;'><strong>Precio Pre-Venta</strong></p>
					</td>
					<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
						<p style = 'writing-mode:vertical-lr;'><strong>Cantidad de Boletos</strong></p>
					</td>
					<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
						<p style = 'writing-mode:vertical-lr;'><strong>Iniciales Loc</strong></p>
					</td>
					<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
						<p style = 'writing-mode:vertical-lr;'><strong>Puerta (Acceso)</strong></p>
					</td>
					<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
						<p style = 'writing-mode:vertical-lr;'><strong>Caracter&iacute;stica</strong></p>
					</td>
				</tr>
				<tr align="center" class="tabla_localidad">
					<td style="border:#c0c0c0 solid 1px;">
						<input type="text" id="loc1" class="loc inputlogin form-control" placeholder="VIP,Palco,General,etc"/>
					</td>
					<td style="border:#c0c0c0 solid 1px;">
						<input type="text" id="precio1" class="precio inputlogin form-control" placeholder="000.00" />
					</td>
					<td style="border:#c0c0c0 solid 1px;">
						<input type="text" id="reservacion1" class="reservacion inputlogin form-control" placeholder="sin %" onkeyup="calcular_reserva('1')" />
					</td>
					<td style="border:#c0c0c0 solid 1px;padding-top: 10px;padding-bottom: 10px">
						<input type="text" id="p_reserva1" class="p_reserva inputlogin form-control" readonly="readonly" placeholder="0.00" style="color:#000;" />
						<input type="text" id="p_reserva_s1" readonly="readonly" placeholder="0.00" style="color:#000;" class="inputlogin form-control" />
					</td>
					<td style="border:#c0c0c0 solid 1px;">
						<input type="text" id="p_venta1" class="p_venta inputlogin form-control" placeholder="sin %" onkeyup="calcular_preventa('1')" />
					</td>
					<td style="border:#c0c0c0 solid 1px;">
						<input type="text" id="p_preventa1" class="p_preventa inputlogin form-control" readonly="readonly" placeholder="0.00" style="color:#000;" /> 
						<input type="text" id="p_preventa_s1" readonly="readonly" placeholder="0.00" style="color:#000;" class="inputlogin form-control" /> 
					</td>
					<td style="border:#c0c0c0 solid 1px;">
						<input type="text" id="cantidad1" class="cantidad inputlogin form-control" onblur='calculaCantidad()' value='0' onkeyup="this.value = this.value.replace (/[^0-9]/, ''); " />
					</td>
					<td style="border:#c0c0c0 solid 1px;">
						<input type="text" id="siglas1" class="siglas inputlogin form-control" placeholder="Iniciales Loc" />
					</td>
					<td style="border:#c0c0c0 solid 1px;">
						<input type="text" id="puertas1" class="puertas inputlogin form-control" placeholder="Iniciales Loc" />
					</td>
					<td style="border:#c0c0c0 solid 1px;">
						<select id="char1" class="char inputlogin form-control">
							<option value="Asientos numerados">Asientos Numerados</option>
							<option value="Asientos no numerados">Asientos sin numerar</option>
						</select>
					</td>
				</tr>
				
				<tr style="text-align:center;">
					<td colspan="9">
						
					</td>
				</tr>
			</table><br/>
			<center style="padding:10px 0px; border:1px solid #c0c0c0;"><button type="button" class="btnlink" target="_parent" name="nuevo" id="nuevo"><strong>AGREGAR LOCALIDAD</strong></button></center>
			<div class="row" style="padding:20px 0px;">
				<center><strong><input type="submit" class="btndegradate" value="GUARDAR Y SEGUIR" onclick="guardar()" /></strong></center>
			</div>
		</div>
		<div class="modal fade" id="tuto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Tutorial para copiar url del video</h4>
					</div>
					<div class="modal-body">
						<!--<iframe width="100%" height="350px" class="video" src="https://www.youtube.com/embed/k8khZHnCQhA"></iframe>-->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" onclick="aceptarModal()">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Aviso!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger alertas" role="alert" id="alerta1" style="display:none;">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;
							Existen campos vacios, por favor llenelos para continuar.
						</div>
						<div class="alert alert-info alertas" role="alert" id="alerta2" style="display:none;">
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>&nbsp;
							Paso 1 Guardado con Éxito.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarModal()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" id="ultcon" value="" />
	</div>
</div>
<script>
	
$(document).ready(function(){
	var btnUpload=$('#uploadCen');
	new AjaxUpload(btnUpload, {
		action: 'spadmin/procesaImgBoletosCen.php',
		name: 'uploadfile',
		onSubmit: function(file, ext){
			 if (! (ext && /^(PCX|pcx)$/.test(ext))){
				alert('Solo imagenes PCX|pcx.');
				return false;
			}
		},
		onComplete: function(file, response){
			var mirsp = response;
			//reload ();
			document.getElementById('fotoCen').value=mirsp;
			document.getElementById('fotoCenMostrar').src='../../'+mirsp;
			
		}
	});
	$( "#autSri" ).change(function() {
		var autSri = $( "#autSri" ).val();
		if(autSri == 0){
			
		}else{
			calculaCantidad();
			var autSri = $( "#autSri option:selected" ).attr('secuencialfinalA');
			$('#numeroDeBoletosAutorizados').val(autSri);
			$('#txtBolAut').html('Atención ud podra crear un total de : <span id="cantidadAutorizados">'+autSri +'</span>  boletos. Por favor no exceda esta cantidad!!!');
		}
	});
	
	
	
	$('.fecha').datetimepicker({
		timepicker: false,
		minDate:0,
		mask:true,
		format:'Y/m/d'
	});
	$('.hora').datetimepicker({
		datepicker:false,
		mask: true,
		format:'H:i'
	});
});


	function calculaCantidad(id){
		var txtBolAut = $( "#autSri option:selected" ).attr('secuencialfinalA');
		var identificador = $( "#autSri" ).val();
		console.log('el identificador de los permisos es : ' + identificador);
		if(identificador == 0){
			
		}else{
			var elementos = $('.tabla_localidad');
			var size = elementos.size();
			//alert(size);
			var sumaBol = 0;
			for (var i=1; i<=size; i++) {
				var cantidad = parseInt($('#cantidad'+i).val());
				//alert(cantidad +' <<  >>'+ i)
				if(cantidad == 0){
					sumaBol = 0;
				}else{
					sumaBol += cantidad;
				}
			}
			//alert(sumaBol);
			$('#numeroDeBoletosConfigurados').val(sumaBol);
			//alert(txtBolAut+'<<>>'+sumaBol);
			var resBoletos = (parseInt(txtBolAut)-parseInt(sumaBol));
			if(sumaBol>txtBolAut){
				
				$('#txtBolAutVendidos').html('<span style="color:red;">Ud a configurado un total de ' + sumaBol + ' boletos , no puede pasarse de esta cantidad</span>');
			}else{
				$('#txtBolAutVendidos').html('<span style="color:#fff;">Ud a configurado : ' + sumaBol + ' boletos le quedan : ' + resBoletos + ' boletos por configurar .</span>' );
			}
		}
		
	}
	function soloNumeros(){
		this.value = this.value.replace (/[^0-9]/, '');
	}
	
var contador = 2;
$('#nuevo').on('click', function(){
$('#localidad').append('<tr class="tabla_localidad" style="padding-top:10px;padding-bottom:10px;">\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="loc'+contador+'" class="loc inputlogin form-control" placeholder="VIP,Palco,General,etc" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="precio'+contador+'" class="precio inputlogin form-control" placeholder="000.00" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="reservacion'+contador+'" class="reservacion inputlogin form-control" placeholder="sin %" onkeyup="calcular_reserva('+contador+')" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;padding-top: 10px;padding-bottom: 10px">\
								<input type="text" id="p_reserva'+contador+'" class="p_reserva inputlogin form-control" readonly="readonly" placeholder="0.00" style="color:#000;" />\
								<input type="text" id="p_reserva_s'+contador+'" class="inputlogin form-control" readonly="readonly" placeholder="0.00" style="color:#000;" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="p_venta'+contador+'" class="p_venta inputlogin form-control" placeholder="sin %" onkeyup="calcular_preventa('+contador+')" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="p_preventa'+contador+'" class="p_preventa inputlogin form-control" readonly="readonly" placeholder="0.00" style="color:#000;" />\
								<input type="text" id="p_preventa_s'+contador+'" readonly="readonly" placeholder="0.00" style="color:#000;" class="inputlogin form-control" /> \
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="cantidad'+contador+'" class="cantidad inputlogin form-control" onblur="calculaCantidad()" onkeyup="this.value = this.value.replace (/[^0-9]/, \'\'); " value="0"/>\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="siglas'+contador+'" class="siglas inputlogin form-control" placeholder="Iniciales Loc" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<input type="text" id="puertas'+contador+'" class="puertas inputlogin form-control" placeholder="Puerta (Acceso)" />\
							</td>\
							<td style="text-align:center; border:#c0c0c0 solid 1px;">\
								<select id="char'+contador+'" class="char inputlogin form-control" onchange="ocultar('+contador+')">\
									<option value="Asientos numerados">Asientos Numerados</option>\
									<option value="Asientos no numerados">Asientos no numerados</option>\
								</select>\
							</td>\
						</tr>');
contador += 1;
});

function calcular_reserva(id){
	var precio = $('#precio'+id).val();
	var porcentaje = $('#reservacion'+id).val();
	var calculo = ((precio * porcentaje) / 100);
	var c = calculo.toFixed(2);
	$('#p_reserva_s'+id).val(c);
	calculo = (Math.ceil(calculo)).toFixed(2);
	$('#p_reserva'+id).val(calculo);
}

function ocultar(id){
	//alert(id)
}
function calcular_preventa(id){
	var pre = $('#precio'+id).val();
	var porciento = $('#p_venta'+id).val();
	var total = ((pre * porciento) / 100);
	var c = total.toFixed(2);
	$('#p_preventa_s'+id).val(c);
	total = (Math.ceil(total)).toFixed(2);
	$('#p_preventa'+id).val(total);
}

function cantidadArtistas(){
	var numart = $('#num_artistas').val();
	if(numart == 11){
		$('#num_artistas').fadeOut('slow');
		$('#numeroart').delay(600).fadeIn('slow');
		return false;
	}
	var cant = $('#num_artistas').val();
	if(cant == 0){
		$('.tabla_artistas').remove();
		$('.titulosartistas').remove();
	}else{
		$('.tabla_artistas').remove();
		$('.titulosartistas').remove();
		var content = '';
		content = '<div class="row titulosartistas" style="text-align:center;"><div class="col-lg-11">\
						<h3>Detalle de Artistas</h3>\
					</div></div>\
					<div class="row titulosartistas">\
						<div class="col-xs-3 artistas">\
							<span><strong>Nombre del Artista</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Facebook</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Twitter</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Youtube</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Instagram</strong></span>\
						</div>\
					</div>';
		for(var i = 0; i < cant; i++){
			content += '<div class="row tabla_artistas">\
						<div class="col-xs-3 detalleart">\
							<input type="text" class="nombre_art inputlogin form-control" placeholder="Nombre Artistico" />\
						</div>\
						<div class="col-xs-2 detalleart">\
							<input type="text" class="facebook inputlogin form-control" placeholder="www.facebook.com/nombre_artistas" />\
						</div>\
						<div class="col-xs-2 detalleart">\
							<input type="text" class="twitter inputlogin form-control" placeholder="www.twitter.com/nombre_artista" />\
						</div>\
						<div class="col-xs-2 detalleart">\
							<input type="text" class="youtube inputlogin form-control" placeholder="www.youtube.com/user/nombre_artista" />\
						</div>\
						<div class="col-xs-2 detalleart">\
							<input type="text" class="instagram inputlogin form-control" placeholder="www.instagram.com/nombre_artista" />\
						</div>\
					</div>';
		}
		$('#numartistas').append(content);
	}
}

function masartistas(){
	var valor = $('#masartistas').val();
	if(valor == 0){
		$('.tabla_artistas').remove();
		$('.titulosartistas').remove();
	}else{
		$('.tabla_artistas').remove();
		$('.titulosartistas').remove();
		var content = '';
		content = '<div class="row titulosartistas" style="text-align:center;"><div class="col-lg-11">\
						<h3>Detalle de Artistas</h3>\
					</div></div>\
					<div class="row titulosartistas">\
						<div class="col-xs-3 artistas">\
							<span><strong>Nombre del Artista</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Facebook</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Twitter</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Youtube</strong></span>\
						</div>\
						<div class="col-xs-2 artistas">\
							<span><strong>Instagram</strong></span>\
						</div>\
					</div>';
		for(var j = 0; j < valor; j++){
			content += '<div class="row tabla_artistas">\
							<div class="col-xs-3 detalleart">\
								<input type="text" class="nombre_art inputlogin form-control" placeholder="Nombre Artistico" />\
							</div>\
							<div class="col-xs-2 detalleart">\
								<input type="text" class="facebook inputlogin form-control" placeholder="www.facebook.com/nombre_artistas" />\
							</div>\
							<div class="col-xs-2 detalleart">\
								<input type="text" class="twitter inputlogin form-control" placeholder="www.twitter.com/nombre_artista" />\
							</div>\
							<div class="col-xs-2 detalleart">\
								<input type="text" class="youtube inputlogin form-control" placeholder="www.youtube.com/user/nombre_artista" />\
							</div>\
							<div class="col-xs-2 detalleart">\
								<input type="text" class="instagram inputlogin form-control" placeholder="www.instagram.com/nombre_artista" />\
							</div>\
						</div>';
		}
		$('#numartistas').append(content);
	}
}

function cancelarmasartistas(){
	$('#numeroart').fadeOut('slow');
	$('#num_artistas').delay(600).fadeIn('slow');
	$('#masartistas').val('');
	$('#num_artistas').val(0);
	$('.tabla_artistas').remove();
	$('.titulosartistas').remove();
}

function chooseGenero(){
	var genero = $('#caracteristica').val();
	if(genero == 1){
		$('#caracteristica').fadeOut('slow');
		$('#otrogen').delay(600).fadeIn('slow');
	}
}

function cancelargenero(){
	$('#otrogen').fadeOut('slow');
	$('#caracteristica').delay(600).fadeIn('slow');
	$('#otrogenero').val('');
	$('#caracteristica').val(0);
}

function choosetiempolimete(){
	var tiempo = $('#tiempolimete').val();
	if(tiempo == 1){
		$('#tiempolimete').fadeOut('slow');
		$('#otrotiempo').delay(600).fadeIn('slow');
	}
}

function cancelarotro(){
	$('#otrotiempo').fadeOut('slow');
	$('#tiempolimete').delay(600).fadeIn('slow');
	$('#otrotiempolimite').val('');
	$('#tiempolimete').val(0);
}

function guardar(){
	var costoenvio;
	var docu;
	var desg;
	var tipoConcierto =  $('input:radio[name=tipoConcierto]:checked').val();
	var id_socio = $('#user').val();
	var nombre_evento = $('#evento').val();
	var lugar_evento = $('#lugar').val();
	var fecha_evento = $('#f_evento').val();
	var fecha_reserva = $('#reserva').val();
	var fecha_preserva = $('#pago_reserva').val();
	var fecha_preventa = $('#pre_venta').val();
	var hora_evento = $('#hora').val();
	var tiempopago = $('#tiempolimete').val();
	var autSri = $('#autSri').val();
	var autMun = $('#autMun').val();

	var lugPago = $('#lugPago').val();
	var dirPago = $('#dirPago').val();
	var fecPago = $('#fecPago').val();
	var horPago = $('#horPago').val();
	var cosEnv2 = $('#cosEnv2').val();
	var disenio_ticket = $('#disenio_ticket').val();

    var porcpaypal = $('#porccomisionpaypal').val();
	var valpaypal = $('#valcomisionpaypaypal').val();
	var porcstripe = $('#porccomisionstripe').val();
	var valstripe = $('#valcomisionpaystripe').val();
	
	if(tiempopago == 1){
		tiempopago = $('#otrotiempolimite').val();
	}else{
		tiempopago = $('#tiempolimete').val();
	}
	var dircanje = $('#dircanje').val();
	var iniciocanje = $('#iniciocanje').val();
	var finalcanje = $('#finalcanje').val();
	var horarioinicial = $('#horarioinicial').val();
	var horariofinal = $('#horariofinal').val();
	var horariocanje = horarioinicial+' - '+horariofinal;
	var descripcion_evento = $('#des').val();
	var imagen_evento = $('#imagen').val();
	var video_evento = $('#video').val();
	var genero_evento = $('#caracteristica').val();
	if(genero_evento == 1){
		genero_evento = $('#otrogenero').val();
	}else{
		genero_evento = $('#caracteristica').val();
	}
	var cant_artistas = $('#num_artistas').val();
	if(cant_artistas == 11){
		cant_artistas = $('#masartistas').val();
	}else{
		cant_artistas = $('#num_artistas').val();
	}
	var obscreacion = '';
	var costoenvio = $('#costoenvio').val();
	if (costoenvio == 'Si') {
		costoenvio = 1;
	}else{
		costoenvio = 0;
	}
	var porcentajetarjeta = 0;
	var valores_artista = '';
	$('.tabla_artistas').each(function(){
		var nombre_artista = $(this).find('.nombre_art').val();
		var face_artista = $(this).find('.facebook').val();
		var twitter_artista = $(this).find('.twitter').val();
		var youtube_artista = $(this).find('.youtube').val();
		var instagram_artista = $(this).find('.instagram').val();
		valores_artista += nombre_artista +'|'+ face_artista +'|'+ twitter_artista +'|'+ youtube_artista +'|'+ instagram_artista +'|'+'@';
	});
	var valores_artista_F = valores_artista.substring(0,valores_artista.length -1);
	
	var img_map_con = $('#imagenmapa').val();
	var img_map_con_opc = $('#imagenmapa1').val();
	var valores_localidad = '';
	var valores_comi = 0;
	$('.valores_comi_ret').each(function(){
		var id_comi_tar = $(this).find('td .id_comi_tar').val(); 
		var comi_tar = $(this).find('td .comi_tar').val(); 
		var ret_iva = $(this).find('td .ret_iva').val(); 
		var ret_renta = $(this).find('td .ret_renta').val(); 
		var des_ter_edad = $(this).find('td .des_ter_edad').val(); 
		var comi_venta = $(this).find('td .comi_venta').val(); 
		var comi_cobro = $(this).find('td .comi_cobro').val(); 
		
		valores_comi += id_comi_tar +'@'+ comi_tar+'@'+ret_iva+'@'+ret_renta+'@'+des_ter_edad+'@'+comi_venta+'@'+comi_cobro+'|';
	});
	var valores_comiFormateado = valores_comi.substring(0, valores_comi.length - 1);
	
	
	$('.tabla_localidad').each(function(){
		var localidad = $(this).find('td .loc').val();
		var precio_localidad = $(this).find('td .precio').val();
		var porcentaje_reserva = $(this).find('td .reservacion').val();
		var precio_reserva = $(this).find('td .p_reserva').val();
		var porcentaje_preventa = $(this).find('td .p_venta').val();
		var precio_preventa = $(this).find('td .p_preventa').val();
		var cantidad_localidad = $(this).find('td .cantidad').val();
		var char_localidad = $(this).find('td .char').val();
		var siglas_localidad = $(this).find('td .siglas').val();
		var puertas_localidad = $(this).find('td .puertas').val();
		valores_localidad += localidad +'|'+ siglas_localidad +'|'+ precio_localidad +'|'+ porcentaje_reserva +'|'+ precio_reserva +'|'+ porcentaje_preventa +'|'+ precio_preventa +'|'+ cantidad_localidad +'|'+  char_localidad +'|'+ puertas_localidad +'|'+'@';
	});
	var valores_localidad_F = valores_localidad.substring(0,valores_localidad.length -1);
	
	var docu = $('#docu').val();
	if (docu == 'Si') {
		docu = 1;
	}else{
		docu = 0;
	}

	var desg = $('#desg').val();
	if (desg == 'Si') {
		desg = 1;
	}else{
		desg = 0;
	}
	if((id_socio == 0) || (nombre_evento == '') || (lugar_evento == '') || (fecha_evento == '') || (fecha_reserva == '') || (fecha_preserva == '') || (fecha_preventa == '') || (hora_evento == '') || (imagen_evento == '') || (video_evento == '') || (descripcion_evento == '') || (genero_evento == '') || (genero_evento == 0) || (img_map_con == '') || (tiempopago == '') || (tiempopago == 0) || (dircanje == '') || (iniciocanje == '') || (finalcanje == '') || (horarioinicial == '') || (horariofinal == '') || (cant_artistas == '') || (cant_artistas == 0)){
		$('#alerta1').fadeIn();
		$('#aviso').modal('show');
	}else{
		if(autSri == 0){
			$.post('spadmin/insert_concierto.php',{
				id_socio : id_socio, nombre_evento : nombre_evento, lugar_evento : lugar_evento, fecha_evento : fecha_evento, fecha_reserva : fecha_reserva,
				fecha_preserva : fecha_preserva, fecha_preventa : fecha_preventa , hora_evento : hora_evento, imagen_evento : imagen_evento, video_evento : video_evento, 
				cant_artistas : cant_artistas,obscreacion : obscreacion, valores_artista : valores_artista_F, descripcion_evento : descripcion_evento, 
				genero_evento : genero_evento,valores_localidad : valores_localidad_F, img_map_con : img_map_con, img_map_con_opc : img_map_con_opc ,
				tiempopago : tiempopago, dircanje : dircanje, horariocanje : horariocanje, iniciocanje : iniciocanje, finalcanje : finalcanje, costoenvio : costoenvio, 
				porcentajetarjeta : porcentajetarjeta , autSri : autSri , autMun : autMun , lugPago : lugPago , dirPago : dirPago , 
				fecPago : fecPago , horPago : horPago , tipoConcierto : tipoConcierto , disenio_ticket : disenio_ticket ,
				valores_comiFormateado : valores_comiFormateado , docu : docu , desg : desg , cosEnv2 : cosEnv2,
                porcpaypal : porcpaypal , valpaypal : valpaypal , porcstripe : porcstripe , valstripe : valstripe
			}).done(function(data){
				$('#alerta2').fadeIn();
				$('#aviso').modal('show');  
				$('#ultcon').val(data);
			});
		}else if(autSri != 0){
			var numeroDeBoletosAutorizados = $('#numeroDeBoletosAutorizados').val();
			var numeroDeBoletosConfigurados = $('#numeroDeBoletosConfigurados').val();
			if(numeroDeBoletosConfigurados>numeroDeBoletosAutorizados){
				alert('no puedes exeder el numero de boletos autorizados que es de :  '  + numeroDeBoletosAutorizados);
			}else if(numeroDeBoletosConfigurados <= numeroDeBoletosAutorizados){
				$.post('spadmin/insert_concierto.php',{
					id_socio : id_socio, nombre_evento : nombre_evento, lugar_evento : lugar_evento, fecha_evento : fecha_evento, fecha_reserva : fecha_reserva,
					fecha_preserva : fecha_preserva, fecha_preventa : fecha_preventa , hora_evento : hora_evento, imagen_evento : imagen_evento, video_evento : video_evento,
					cant_artistas : cant_artistas , obscreacion : obscreacion, valores_artista : valores_artista_F, descripcion_evento : descripcion_evento, 
					genero_evento : genero_evento, valores_localidad : valores_localidad_F, img_map_con : img_map_con, img_map_con_opc : img_map_con_opc ,
					tiempopago : tiempopago, dircanje : dircanje, horariocanje : horariocanje, iniciocanje : iniciocanje, finalcanje : finalcanje,
					costoenvio : costoenvio , porcentajetarjeta : porcentajetarjeta , autSri : autSri , autMun : autMun , lugPago : lugPago , dirPago : dirPago , 
					fecPago : fecPago , horPago : horPago , tipoConcierto : tipoConcierto , disenio_ticket : disenio_ticket ,
					valores_comiFormateado : valores_comiFormateado , docu : docu , desg : desg , cosEnv2 : cosEnv2,
                    porcpaypal : porcpaypal , valpaypal : valpaypal , porcstripe : porcstripe , valstripe : valstripe
				}).done(function(data){
					$('#alerta2').fadeIn();
					$('#aviso').modal('show');  
					$('#ultcon').val(data);
				});
			}
		}
	}
}

$(function(){
	var btnUpload=$('#upload');
	new AjaxUpload(btnUpload, {
		action: 'spadmin/procesa3.php',
		name: 'uploadfile',
		onSubmit: function(file, ext){
			 if (! (ext && /^(jpg|png|gif|bmp)$/.test(ext))){
				alert('Solo imagenes JPG,GIF,PNG,BMP.');
				return false;
			}
		},
		onComplete: function(file, response){
			var mirsp = response;
			//reload ();
			document.getElementById('imagen').value=mirsp;
			document.getElementById('foto').src='spadmin/'+mirsp;
			$('#btnborrarimg').fadeIn();
		}
	});
});




$(function(){
	var btnUpload=$('#uploadmapa');
	new AjaxUpload(btnUpload, {
		action: 'spadmin/procesamapa.php',
		name: 'uploadfile',
		onSubmit: function(file, ext){
			 if (! (ext && /^(jpg|png|gif|bmp)$/.test(ext))){
				alert('Solo imagenes JPG,GIF,PNG,BMP.');
				return false;
			}
		},
		onComplete: function(file, response){
			var mirsp = response;
			//reload ();
			document.getElementById('imagenmapa').value = mirsp;
			document.getElementById('mapa_completo').src='spadmin/mapas/'+mirsp;
			$('#btnborrarimgmapa').fadeIn();
		}
	});
});



$(function(){
	var btnUpload=$('#uploadmapa1');
	new AjaxUpload(btnUpload, {
		action: 'spadmin/procesamapa.php',
		name: 'uploadfile',
		onSubmit: function(file, ext){
			 if (! (ext && /^(jpg|png|gif|bmp)$/.test(ext))){
				alert('Solo imagenes JPG,GIF,PNG,BMP.');
				return false;
			}
		},
		onComplete: function(file, response){
			var mirsp = response;
			//reload ();
			document.getElementById('imagenmapa1').value = mirsp;
			document.getElementById('mapa_completo1').src='spadmin/mapas/'+mirsp;
			$('#btnborrarimgmapa1').fadeIn();
		}
	});
});

function borrarimg(){
	$('#btnborrarimg').fadeOut();
	var imgname = $('#imagen').val();
	$('.imgeliminadas').append('<input type="hidden" class="eliminadas" value="'+imgname+'" />');
	$('#foto').prop('src','');
	$('#imagen').val('');
}

function borrarimgmapa(){
	$('#btnborrarimgmapa').fadeOut();
	var imgname = $('#imagenmapa').val();
	$('.imgeliminadasmapa').append('<input type="hidden" class="eliminadasmapa" value="'+imgname+'" />');
	$('#mapa_completo').prop('src','');
	$('#imagenmapa').val('');
}

function aceptarModal(){
	var con = $('#ultcon').val();
	if($('#alerta2').is(':visible')){
		window.location.href = '?modulo=creacionmapa&con='+con;
	}
	$('.alertas').fadeOut();
	$('#aviso').modal('hide');
}
</script>