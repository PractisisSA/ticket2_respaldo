<?php
	session_start();
	include 'conexion.php';
	//include("controlusuarios/seguridadSA.php");
	require('Conexion/conexion.php');
	$id = $_GET['id'];
	$_SESSION['conciertoID'] = $id;

    $porcpaypal = 0;
    $valpaypal = 0;
    $porcstripe = 0;
    $valstripe = 0;
	
	echo "<input type ='hidden' id='conciertoID' value='".$id."' />";
	$sqlcon = "SELECT * FROM Concierto WHERE idConcierto = '$id'" or die(mysqli_error());
	$resc = $mysqli->query($sqlcon);
	$sqlloc = "SELECT * FROM Localidad WHERE idConc = '$id'" or die(mysqli_error());
	$resl = $mysqli->query($sqlloc);
	$sqlart = "SELECT * FROM Artista WHERE intIdConciertoA = '$id'" or die(mysqli_error());
	$resa = $mysqli->query($sqlart);
	$sqlMapa = "SELECT intFilasB, intAsientosB, strCoordenadasB, strSecuencial, strCapacidadL, idLocalidad, strMapaC FROM Butaca 
				JOIN Localidad ON Butaca.intLocalB = Localidad.idLocalidad 
				JOIN Concierto ON Butaca.intConcB = Concierto.idConcierto 
				WHERE intConcB = '$id'" or die(mysqli_error($mysqli));
	$resultMapa = $mysqli->query($sqlMapa);
	echo '<input type="hidden" id="data" value="2" />';
?>
<script type="text/javascript" src="jquery.numeric.js"></script>
<style>
table{
	font-size:15px !important;
}
	input[type="text"] , select , textarea {
		width:auto;
	}
	
	
	input[type="radio"]{ display: none; }

label{
  color:#fff;
  font-family: Arial;
  font-size: 14px;
}

.entero{
	text-align:center;
}

input[type="radio"] + label span{
  display: inline-block;
  width: 19px;
  height: 19px;
  background: url(http://ticketfacil.ec/ticket2/spadmin/img/check_radio_sheet.png) -38px top no-repeat;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor:pointer;
}

input[type="radio"]:checked + label span{
  background: url(http://ticketfacil.ec/ticket2/spadmin/img/check_radio_sheet.png) -57px top no-repeat;
}
.cortesia:hover{
	text-decoration:underline;
}
</style>
<script src="spadmin/ajaxupload.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/>
<script src="js/jquery.datetimepicker.js"></script>
<script language="javascript" src="spadmin/jquery.canvasAreaDraw.js"></script>
<div class="ocultarEdit">
	<div style="margin: 10px -10px">
		<div style="background-color:#171A1B; padding:10px;">
			<div style="border: 2px solid #00AEEF; margin:5px;">
				<div class='row'>
					<div class="col-md-5"></div>
					<div class = 'col-md-5' style="font-size:22px;padding-left:30px;padding-top:7px;padding-bottom:7px;">
						<a href="?modulo=eventPartnerDescount&id=<?php echo $_SESSION['conciertoID']; ?>" class="btn btn-warning">Ver descuentos</a>
					</div>
				</div>
				<div style="margin-top:10px; text-align:center;">
					<div style="background-color:#171A1B;">
						<table class="teditg" style="width:100%; color:#fff; font-size:18px; border-collapse:separate; border-spacing:15px 5px;">
						<?php while($rowc = mysqli_fetch_array($resc)){
							$idUser = $rowc['idUser'];
							$tiene_permisos = $rowc['tiene_permisos'];

                            $porcpaypal =(float) $rowc['porcpaypal'];
                            $valpaypal =(float) $rowc['valpaypal'];
                            $porcstripe =(float) $rowc['porcstripe'];
                            $valstripe =(float) $rowc['valstripe'];

							//echo $tiene_permisos."hola";	
							$tipo_conc = $rowc['tipo_conc'];
							//echo $tipo_conc;
							if($tipo_conc == 1){
								$checked = 'checked';
						?>
						<?php	
							$tdTipoConc = '
							<td width="49%" align="left" style="background:#00709b;border: 1px solid #fff;color: #fff;">
								<p>
									<input disabled type="radio" id="r1" name="tipoConcierto" '.$checked.' value = "'.$tipo_conc.'" />
									<label for="r1"><span></span>Concierto Físico</label>
								</p>
								
							</td>
							<td></td>
							<td width="49%" align="left" style="background:#00709b;border: 1px solid #fff;color: #fff;">
								<p>
									<input disabled type="radio" id="r2" name="tipoConcierto" value = "2"/>
									<label for="r2"><span></span>Concierto Electrónico</label>
								</p>
							</td>';
						
						
							}elseif($tipo_conc == 2){
								$checked = 'checked';
						$tdTipoConc = '
							<td width="49%" align="left" style="background:#00709b;border: 1px solid #fff;color: #fff;">
								<p>
									<input disabled disabled type="radio" id="r1" name="tipoConcierto" value = "1" />
									<label for="r1"><span></span>Concierto Físico</label>
								</p>
								
							</td>
							<td></td>
							<td width="49%" align="left" style="background:#00709b;border: 1px solid #fff;color: #fff;">
								<p>
									<input disabled disabled type="radio" id="r2" name="tipoConcierto" '.$checked.' value = "'.$tipo_conc.'"/>
									<label for="r2"><span></span>Concierto Electrónico</label>
								</p>
							</td>';
						
							}
						?>
								<input disabled type="hidden" name="id" id="id" value="<?php echo $id;?>" />
								<td width="50%" align="left">
									<p><strong>Nombre de Evento:</strong></p><?php $strEvento = $rowc['strEvento'];?>
									<input disabled disabled type="text" name="evento" id="evento" class="inputlogin" value="<?php echo utf8_encode($rowc['strEvento']);?>" />
								</td>
								<td align="left">
									<p><strong>Lugar:</strong></p>
									<input disabled disabled type="text"  name="lugar" id="lugar" class="inputlogin" value="<?php echo utf8_encode($rowc['strLugar']);?>" />
								</td>
							</tr>
							<tr>
								<td style="text-align:left;">
									<p><strong>Imagen del Evento:</strong>
									</p>
									<img src="spadmin/<?php echo $rowc['strImagen'];?>" border="0"  id="foto"  style="width:280px; vertical-align: top; text-align: center;"/>
									<input disabled type="hidden" id="imgok" name="imgok" value="<?php echo $rowc['strImagen'];?>" /><br/>
									
								</td>
								<td align="left">
									<p><strong>Descripci&oacute;n del Evento:</strong></p>
									<textarea disabled name="des" class="inputlogin" id="des" rows="8"  ><?php echo utf8_encode($rowc['strDescripcion']);?></textarea>		
								</td>	
							</tr>
							
							<tr>
								<td style="text-align:center;" colspan='2'>
									<p><strong>Mapa del Evento:</strong>
									<div style="vertical-align: middle; text-align: center;" id="upload1">
									</div></p>
									<img src="spadmin/<?php echo $rowc['strMapaC'];?>" border="0"  id="fotoCon"  style="width:280px; vertical-align: top; text-align: center;"/>
									<br/>
								</td>
							</tr>
							<tr >
								<td align='center' colspan='2' >
									<p><strong>Mapa opaco del Evento:</strong>
									</p>
									<img src="spadmin/<?php echo $rowc['strMapaFill'];?>" border="0"  id="fotoOpC"  style="width:280px; vertical-align: top; text-align: center;"/>
									<br/>
								</td>
								</td>	
							</tr>
							
							
							<tr>
								<td align="left">
									<p><strong>Fecha del Evento:</strong></p>
									<input disabled disabled type="date" name="fecha" id="fecha" class="inputlogin" value="<?php echo $rowc['dateFecha'];?>" placeholder="AAAA-MM-DD"/>
								</td>
								<td align="left">
									<p><strong>Fecha del limite Reservas:</strong></p>
									<input disabled disabled type="date" name="fechareserva" class="inputlogin" id="fechareserva" value="<?php echo $rowc['dateFechaReserva'];?>" placeholder="AAAA-MM-DD"/>
								</td>
							</tr>
							<tr>
								<td align="left">
									<p><strong>Fecha del limite Pago Reservas:</strong></p>
									<input disabled disabled type="date" name="fechapreserva" class="inputlogin" id="fechapreserva" value="<?php echo $rowc['dateFechaPReserva'];?>" placeholder="AAAA-MM-DD"/>
								</td>
								<td align="left">
									<p><strong>Fecha del limite Preventa:</strong></p>
									<input disabled disabled type="date" name="fechapreventa" class="inputlogin" id="fechapreventa" value="<?php echo $rowc['dateFechaPreventa'];?>" placeholder="AAAA-MM-DD"/>
								</td>
							</tr>
							<tr>
								<td align="left">
									<p><strong>Hora del Evento:</strong></p>
									<input disabled disabled type="text" name="hora" id="hora" class="inputlogin" value="<?php echo $rowc['timeHora'];?>" />
								</td>
								<td align="left">
									<p><strong>Video Promocional:</strong></p>
									<input disabled disabled type="text" name="strVideoC" class="inputlogin" id="strVideoC" placeholder="Link de YOUTUBE" required="required" value="<?php echo $rowc['strVideoC'];?>" />
									<a href="javascript:op();" class="btnlink" >Tutorial</a>
								</td>	
							</tr>
							
							<tr>
								<td align="left">
									<p><strong>G&eacute;nero del Evento:</strong></p>
									<select disabled disabled name="car" id="car" class="inputlogin">
										<option value="<?php echo $rowc['strCaractristica'];?>"><?php echo $rowc['strCaractristica'];?></option>
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
									</select>
								</td>
								<td align="left">
									<p><strong>Estado</strong></p>
									<input disabled disabled type="text" name="estadoCon" class="inputlogin" id="estadoCon"  value="<?php echo $rowc['strEstado'];?>" />
								</td>
							</tr>
							<tr>
								<?php 
								$cost = '';
									
								?>
								<td align="left">
									<p><strong>Visualización web y eventos reales:</strong></p>
									<select disabled id="cosEnv" class="form-control">
										<?php
											if ($rowc['costoenvioC'] == 1) {
												$cost = 'Si';
											echo'	
													<option value = "No">No</option>
													<option value = "Si" selected>Si</option>
												';
											}else{
												$cost = 'No';
												echo'	
													<option value = "Si">Si</option>
													<option value = "No" selected>No</option>
												';
											} 
										?>
										
										
									</select>
								</td>
							</tr>
							<tr>
								<td colspan='2' style='border-top: 2px solid #EA1467;'>
									<h3 style='color:#fff;'>INFORMACIÓN RESERVADA PARA LOS CANJES DE RESERVAS</h3>
								</td>
							</tr>
							<tr>
								<td align="left" >
									<p><strong>Tiempo limite para pago por Punto de Venta o Depósito:</strong></p>
									<input disabled disabled type="text" name="tiempoPago" id="tiempoPago" class="inputlogin" value="<?php echo $rowc['tiempopagoC'];?>" />
								</td>
								<td align="left" >
									<p><strong>Direccion de Canje</strong></p>
									<input disabled disabled type="text" name="dirCanje" class="inputlogin" id="dirCanje"  value="<?php echo utf8_encode($rowc['dircanjeC']);?>" />
								</td>	
							</tr>
							
							
							<tr>
								<td align="left">
									<p><strong>Horario de Canje</strong></p>
									<input disabled disabled type="text" name="horCanje" id="horCanje" class="inputlogin" value="<?php echo utf8_encode($rowc['horariocanjeC']);?>" />
								</td>
								<td align="left">
									<p><strong>Fecha Inicio Canje</strong></p>
									<input disabled disabled type="text" name="fIniCanje" class="inputlogin" id="fIniCanje"  value="<?php echo utf8_encode($rowc['fechainiciocanjeC']);?>" />
								</td>	
							</tr>
							
							<tr>
								<td align="left">
									<p><strong>Fecha Fin Canje</strong></p>
									<input disabled disabled type="text" name="fFinCanje" id="fFinCanje" class="inputlogin" value="<?php echo utf8_encode($rowc['fechafinalcanjeC']);?>" />
								</td>
								
							</tr>
							
							<tr style = 'display:none;'>
								<td align="left" >
									<p><strong>Porcentaje compras por Tarjeta de Crédito:</strong></p>
									<input disabled disabled type="text" name="porcTarj" id="porcTarj" class="inputlogin" value="<?php echo $rowc['porcentajetarjetaC'];?>" />
								</td>
								<td align="left" >
									
								</td>	
							</tr>
							
							
							<tr>
								<td colspan='2' style='border-bottom: 2px solid #EA1467;'>
									
								</td>
							</tr>
							
							
							<tr>
								<td colspan='2'>
									<h3 style='color:#fff;'>INFORMACIÓN RESERVADA PARA LOS PAGOS DE RESERVAS</h3>
								</td>
							</tr>
							<tr>
								<td align="left">
									
									<h4 style="color:#fff;"><strong>Lugar de Pago</strong></h4>
									<input disabled disabled type="text" style='' name="lugPago" id="lugPago" class="inputlogin" placeholder="Lugar"  value="<?php echo utf8_encode($rowc['locPago']);?>" />
								</td>
								<td align="left">
									<h4 style="color:#fff;"><strong>Direccion de Pago</strong></h4>
									<input disabled disabled type="text" style='' name="dirPago" class="inputlogin" id="dirPago" placeholder="Direccion de Pago"   value="<?php echo utf8_encode($rowc['dirPago']);?>" />
								</td>	
							</tr>
							<tr>
								<td align="left">
									<h4 style="color:#fff;"><strong>Fecha de Pago</strong></h4>
									<input disabled disabled type="text" style='' name="fecPago" id="fecPago" class="inputlogin" placeholder="Desde yy-mm-dd  Hasta  yy-mm-dd" value="<?php echo utf8_encode($rowc['fecha']);?>" />
								</td>
								<td align="left">
									<h4 style="color:#fff;"><strong>Hora de Pago</strong></h4>
									<input disabled disabled type="text" style='' name="horPago" class="inputlogin" id="horPago"  placeholder="hh:mm -- hh:mm" value="<?php echo utf8_encode($rowc['hora']);?>" />
								</td>	
							</tr>
							<tr>
								<td colspan='2' style='border-bottom: 2px solid #EA1467;'>
									
								</td>
							</tr>
							<tr>
								<td colspan='2' style='border-bottom: 2px solid #EA1467;'>
									
								</td>
							</tr>
							
							
							<tr>
								<td style="vertical-align:middle; text-align:center;" colspan="2">
									<font size="6"><p><strong>Detalle de los Artistas</strong></p></font>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<table id="art" style="width:100%; color:#fff; border-collapse:separate; border-spacing:5px 10px;">
										<tr>
											<td style="text-align:center">
												<p><strong>Nombre del Artista</strong></p>
											</td>
											<td style="text-align:center">
												<p><strong>Facebook</strong></p>
											</td>
											<td style="text-align:center">
												<p><strong>Twitter</strong></p>
											</td>
											<td style="text-align:center">
												<p><strong>Youtube</strong></p>
											</td>
											<td style="text-align:center">
												<p><strong>Instragram</strong></p>
											</td>
										</tr>
										<?php while ($rowa = mysqli_fetch_array($resa)){
											$idArt = $rowa['idArtista'];
										?>
										<tr class="artistas">
											<td style="text-align:center">
												<input disabled disabled type="text" class="nombre_art inputlogin" size="15" name="nombre_art" value="<?php echo $rowa['strNombreA'];?>" />
											</td>
											<td style="text-align:center">
												<input disabled disabled type="text" class="facebook inputlogin" size="15" name="facebook" value="<?php echo $rowa['strFacebookA'];?>" />
											</td>
											<td style="text-align:center">
												<input disabled type="text" class="twitter inputlogin" size="15" name="twitter" value="<?php echo $rowa['strTwitterA'];?>" />
											</td>
											<td style="text-align:center">
												<input disabled type="text" class="youtube inputlogin" size="15" name="youtube" value="<?php echo $rowa['strYoutubeA'];?>" />
											</td>
											<td style="text-align:center">
												<input disabled type="text" class="instagram inputlogin" size="15" name="instagram" value="<?php echo $rowa['strInstagramA'];?>" />
											</td>
											<td class="tdidart">
												<input disabled type="hidden" name="idart" class="idart" value="<?php echo $idArt;?>" size="1"/>
											</td>
										</tr>
										<?php }?>
									</table>
								</td>
							</tr>
							<tr>
								<td style="vertical-align:middle; text-align:center;" colspan="2">
									<font size="6"><p><strong>Localidades</strong></p></font>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<table id="local" style="width:100%; font-size:13px !important; color:#fff; border-collapse:separate; border-spacing:5px 10px;position:relative; z-index: 3000">
										<tr>
											<td style="text-align:center; border: #c0c0c0 solid 1px;width:350px;">
												<p><strong>Descripci&oacute;n</strong></p>
											</td>
											<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
												<p style = 'writing-mode:vertical-lr;'><strong>Precio</strong></p>
											</td>
											<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
												<p style = 'writing-mode:vertical-lr;'><strong>Siglas</strong></p>
											</td>
											<td style="text-align:center; border: #c0c0c0 solid 1px;padding-left: 10px;padding-right: 25px">
												<p style = 'writing-mode:vertical-lr;'><strong>Puerta</strong></p>
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
												<p style = 'writing-mode:vertical-lr;'><strong>Caracteristicas</strong></p>
											</td>
										</tr>
										<?php } 
										while($rowl = mysqli_fetch_array($resl)){
												$sqlOc = '	SELECT 1 as posicion, `row` , `col` , (`status`) , (`local`) , (`concierto`) 
													FROM `ocupadas`
													WHERE `local` = "'.$rowl['idLocalidad'].'" 
													and status = "3"
													group by `row` , `col` , `status` , `local` , `concierto` 
													ORDER BY `col` ASC
												';
													$resOc = mysql_query($sqlOc) or die (mysql_error());
													$sumaBloqueos = 0;
													while($rowOc = mysql_fetch_array($resOc)){
														$sumaBloqueos += $rowOc['posicion'];
													}
											$idloc = $rowl['idLocalidad'];
										?>
										<tr class="localidades">
											<td style="text-align:center; border-right: #c0c0c0 solid 1px;">
												<input disabled type="text" id="loc<?php echo $idloc;?>" name="loc" class="loc inputlogin" value="<?php echo utf8_encode($rowl['strDescripcionL']);?>" size="25" />
											</td>
											<td style="text-align:center; border-right: #c0c0c0 solid 1px;">
												<input disabled type="text" id="precio<?php echo $idloc;?>" name="precio" class="precio inputlogin" value="<?php echo $rowl['doublePrecioL'];?>" size="3" onkeyup="calculoXprecio('<?php echo $idloc;?>')" />
											</td>
											<td style="text-align:center; border-right: #c0c0c0 solid 1px;">
												<input disabled type="text" id="siglas<?php echo $idloc;?>" name="siglas" class="siglas inputlogin" value="<?php echo utf8_encode($rowl['strDateStateL']);?>" size="3" />
											</td>
											<td style="text-align:center; border-right: #c0c0c0 solid 1px;">
												<input disabled type="text" id="puerta<?php echo $idloc;?>" name="puerta" class="puerta inputlogin" value="<?php echo utf8_encode($rowl['puerta']);?>" size="3" />
											</td>
											<td style="text-align:center; border-right: #c0c0c0 solid 1px;">
												<input disabled type="text" id="por_reserva<?php echo $idloc;?>" name="por_reserva" class="por_reserva inputlogin" value="<?php echo $rowl['intPorcentajeReserva'];?>" size="3" onkeyup="calculoReserva('<?php echo $idloc;?>')" />
											</td>
											<td style="text-align:center; border-right: #c0c0c0 solid 1px;">
												<input disabled type="text" id="pre_reserva<?php echo $idloc;?>" name="pre_reserva" class="pre_reserva inputlogin" value="<?php echo $rowl['doublePrecioReserva']?>" size="3" readonly="readonly" />
											</td>
											<td style="text-align:center; border-right: #c0c0c0 solid 1px;">
												<input disabled type="text" id="por_preventa<?php echo $idloc;?>" name="por_preventa" class="por_preventa inputlogin" value="<?php echo $rowl['intPorcentajePreventa']?>" size="3" onkeyup="calculoPreventa('<?php echo $idloc;?>')" />
											</td>
											<td style="text-align:center; border-right: #c0c0c0 solid 1px;">
												<input disabled type="text" id="pre_preventa<?php echo $idloc;?>" name="pre_preventa" class="pre_preventa inputlogin" value="<?php echo $rowl['doublePrecioPreventa']?>" size="3" readonly="readonly" />
											</td>
											<td style="text-align:center; border-right: #c0c0c0 solid 1px;">
												<input disabled type="text" id="cantidad<?php echo $idloc;?>" name="cantidad" class="cantidad  inputlogin" value="<?php echo ($rowl['strCapacidadL'] - $sumaBloqueos);?>"  size="3"  />
											</td>
											<td style="text-align:center; border-right: #c0c0c0 solid 1px;">
												<select disabled id="char<?php echo $idloc;?>" class="char  inputlogin" name="char">
													<?php
														if($rowl['strCaracteristicaL'] == 'Asientos numerados'){
													?>
															<option value="<?php echo $rowl['strCaracteristicaL'];?>" selected ><?php echo $rowl['strCaracteristicaL'];?></option>
															<option value="Asientos no numerados">Asientos no numerados</option>
													<?php
														}else{
													?>
															<option value="<?php echo $rowl['strCaracteristicaL'];?>" selected ><?php echo $rowl['strCaracteristicaL'];?></option>
															<option value="Asientos numerados">Asientos numerados</option>
													<?php
														}
													?>
													<!--<option value="<?php echo $rowl['strCaracteristicaL'];?>"><?php echo $rowl['strCaracteristicaL'];?></option>-->
												</select>
											</td>
											<td class="tdidloc">
												<input disabled type="hidden" name="idloc" class="idloc" value="<?php echo $idloc;?>" size="1"/>
											</td>
											
										</tr>
										<?php }?>
									</table>
								</td>
							</tr>
							
							
							
							<tr>
								<td colspan = '2'>
									<hr style = 'color:#00AEEF;background-color:#00AEEF;' ></hr>
								</td>
							</tr>
							
							<?php
							$sqlDes = 'select * from desgl_docu where id_con = "'.$id.'" ';
							$resDes = mysql_query($sqlDes) or die (mysql_error());
							$rowDes = mysql_fetch_array($resDes);
							$docu = '';
							$impu = '';
							$muni = '';
							if ($rowDes['docu'] == 1) {
								$docu = 'Si';
							}else{
								$docu = 'No';
							}
							if ($rowDes['desg'] == 1) {
								$impu = 'Si';
							}else{
								$impu = 'No';
							}
							if ($rowDes['municipio'] == 1) {
								$muni = 'Si';
							}else{
								$muni = 'No';
							}
						?>
							<tr>
								<td colspan = '2'>
									<table class = 'table'>
										<tr>		
											<td align="left">
												<p><strong>Documento Categorizado <div style="display: none;">1 ò 0:</div> </strong></p>
												<select disabled id="docu" class="inputlogin">
													<option value="<?php echo $rowDes['docu']; ?>"><?php echo $docu; ?></option>
													<option>Si</option>
													<option>No</option>
												</select>
											</td>
											<td align="left">
												<p><strong>Desglosa impuestos <div style="display: none;">1 ò 0:</div></strong></p>
												<select disabled id="desg" class="inputlogin">
													<option value="<?php echo $rowDes['desg']; ?>"><?php echo $impu; ?></option>
													<option>Si</option>
													<option>No</option>
												</select>
											</td>	
											<td align="left">
												<p><strong>Ver Municipio <div style="display: none;">1 ò 0:</div></strong></p>
												<select disabled id="municip" class="inputlogin">
													<option value="<?php echo $rowDes['municipio']; ?>"><?php echo $muni; ?></option>
													<option>Si</option>
													<option>No</option>
												</select>
											</td>	
										</tr>
									</table>

								</td>
							</tr>
							
							<tr>
								<td style="vertical-align:middle; text-align:center;" colspan="2">
									<font size="6"><p><strong>Detalle porcentaje de descuentos y comisiones</strong></p></font>
								</td>
							</tr>
							
							<tr>
								<td style="vertical-align:middle; text-align:center;" colspan="2">
									<table class="table table-border" style='font-size:13px;'>
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
											$sqlComi = 'select * from comi_ret where id_con = "'.$id.'" order by id asc';
											$resComi = mysql_query($sqlComi) or die (mysql_error());
											if(mysql_num_rows($resComi)>0){
												while($rowComi = mysql_fetch_array($resComi)){
										?>
													<tr class='valores_comi_ret'>
														<td>
															<?php echo $rowComi['detalle'];?>
															<input disabled type = 'hidden' value = '<?php echo $rowComi['id'];?>' class = 'id_comi_tar' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value = '<?php echo $rowComi['comi_tar'];?>' class = 'comi_tar entero' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text'  maxlength="4" style='color:#000;width:50px;text-align:center;' value = '<?php echo $rowComi['ret_iva'];?>' class = 'ret_iva entero' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text'  maxlength="4" style='color:#000;width:50px;text-align:center;' value = '<?php echo $rowComi['ret_renta'];?>' class = 'ret_renta entero' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text'  maxlength="4" style='color:#000;width:50px;text-align:center;' value = '<?php echo $rowComi['des_ter_edad'];?>' class = 'des_ter_edad entero' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text'  maxlength="4" style='color:#000;width:50px;text-align:center;' value = '<?php echo $rowComi['comi_venta'];?>' class = 'comi_venta entero' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text'  maxlength="4" style='color:#000;width:50px;text-align:center;' value = '<?php echo $rowComi['comi_cobro'];?>' class = 'comi_cobro entero' />
														</td>
													</tr>
										<?php
												}
												$txtBtnComision = 'Actualizar Comiciones';
												$identificador = 1;
											}else{
												$txtBtnComision = 'Grabar Comiciones';
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
															<input disabled type = 'hidden' value = '<?php echo $m;?>' class = 'id_comi_tar' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'comi_tar entero' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'ret_iva entero' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'ret_renta entero' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'des_ter_edad entero' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'comi_venta entero' />
														</td>
														<td valign='middle' align = 'center' style = 'text-align:center;'>
															<input disabled type = 'text' maxlength="4" style='color:#000;width:50px;text-align:center;' value='0' class = 'comi_cobro entero' />
														</td>
													</tr>
										<?php
												}
											}
										?>
													
									</table>
								</td>
							</tr>

                            <tr>
								<td style="vertical-align:middle; text-align:center;" colspan="2">
									<font size="6"><p><strong>Detalle comisión venta en linea</strong><br><span style = 'font-weight:300;font-size:15px;' >si graba con decimales debe usar el siguiente formato : 0.05(con punto no coma)</span></p></font>
								</td>
							</tr>

							<tr>
								<td style="vertical-align:middle; text-align:center;" colspan="2">
									<table class="table table-border" style='font-size:13px;'>
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
                                                <input disabled class = 'entero' type='text' placeholder='0' id='porccomisionpaypal' name='porccomisionpaypal' value='<?php echo $porcpaypal;?>' style='color:#000;'/>
											</td>
											<td>
                                                <input disabled class = 'entero' type='text' placeholder='0.99' id='valcomisionpaypaypal' name='valcomisionpaypaypal' value='<?php echo $valpaypal;?>' style='color:#000;'/>
											</td>
										</tr>
                                        <tr>
											<td>
                                                STRIPE
											</td>
											<td>
                                                <input disabled class = 'entero' type='text' placeholder='0' id='porccomisionstripe' name='porccomisionstripe' value='<?php echo $porcstripe;?>' style='color:#000;'/>
											</td>
											<td>
                                                <input disabled class = 'entero' type='text' placeholder='0.99' id='valcomisionpaystripe' name='valcomisionpaystripe' value='<?php echo $valstripe;?>' style='color:#000;'/>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							
							<tr>
								<td style="vertical-align:middle; text-align:center;" colspan="2">
									<font size="3"><p><strong>Detalle de Impuestos (Sayse , Sri , Municipio , Tickets(Valorados y Cortesias)) </strong><br><span style = 'font-weight:300;font-size:15px;' >si graba con decimales debe usar el siguiente formato : 0.05(con punto no coma)</span></p></font>
								</td>
							</tr>
							<tr>
								<td style="vertical-align:middle; text-align:center;" colspan="2">
									<?php
										$sqlImp = 'select * from impuestos where id_con = "'.$id.'" ';
										$resImp = mysql_query($sqlImp) or die (mysql_error());
										$numReg = mysql_num_rows($resImp);
										
										$rowImp = mysql_fetch_array($resImp);
										// echo $numReg;
										if($numReg == 0){
											$id_imp = 0;
										}else{
											$id_imp = $rowImp['id'];
										}
										$valorados = $rowImp['valorados'];
										$sin_permisos = $rowImp['sin_permisos'];
										$cortesias = $rowImp['cortesias'];
										$sayse = $rowImp['sayse'];
										$sri = $rowImp['sri'];
										$municipio = $rowImp['municipio'];
									?>
									<table class = 'table' >
										<tr>
											<td>
												Valorados
											</td>
											<td>
												Cortesias
											</td>
											<td>
												Sayse
											</td>
											<td>
												Sri
											</td>
											<td>
												Municipio
											</td>
										</tr>
										
										<tr>
											<td>
												<input disabled class = 'entero' type = 'text' placeholder = '0.99' id = 'valorados' value = '<?php echo $valorados;?>' style = 'color:#000;' />
											</td>
											<td>
												<input disabled class = 'entero' type = 'text' placeholder = '0.99' id = 'cortesias' value = '<?php echo $cortesias;?>' style = 'color:#000;' />
												
											</td>
											<td>
												<input disabled class = 'entero' type = 'text' placeholder = '0.99' id = 'sayse' value = '<?php echo $sayse;?>' style = 'color:#000;' />
												
											</td>
											<td>
												<input disabled class = 'entero' type = 'text' placeholder = '0.99' id = 'sri' value = '<?php echo $sri;?>' style = 'color:#000;' />
												
											</td>
											<td>
												<input disabled class = 'entero' type = 'text' placeholder = '0.99' id = 'municipio' value = '<?php echo $municipio;?>'  style = 'color:#000;'/>
												
											</td>
										</tr>
									</table>
									
								</td>
							</tr>
							
							<?php
								$sqlCl = 'select * from claves where id_con = "'.$id.'" ';
								$resCl = mysql_query($sqlCl) or die (mysql_error());
								
								if(mysql_num_rows($resCl)>0){
									$rowCl = mysql_fetch_array($resCl);
									$cl1 = $rowCl['clave'];
									$cl2 = $rowCl['clave2'];
									$cl3 = $rowCl['clave3'];
									$botonClaves = '<button id = "actualizaClaves" type="button" class="btn btn-warning" onclick = "actualizaClaves('.$rowCl['id'].' , 2 , '.$id.')" >Actualizar Claves</button>';
								}else{
									$cl1 = '';
									$cl2 = '';
									$cl3 = '';
									$botonClaves = '<button id = "actualizaClaves" type="button" class="btn btn-primary" onclick = "actualizaClaves(0 , 1 , '.$id.')" >Grabar Claves</button>';
								}
								
								
								
								
							?>
						</table>
						<!--<div class="tra_azul"></div>
						<div class="par_azul"></div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="mostrarEdit" style="position: absolute;top: 3000px;">
	<?php while($rowMap = mysqli_fetch_array($resultMapa)){
		$sqlOc = '	SELECT 1 as posicion, `row` , `col` , (`status`) , (`local`) , (`concierto`) 
			FROM `ocupadas`
			WHERE `local` = "'.$rowMap['idLocalidad'].'" 
			and status = "3"
			group by `row` , `col` , `status` , `local` , `concierto` 
			ORDER BY `col` ASC
		';
			$resOc = mysql_query($sqlOc) or die (mysql_error());
			$sumaBloqueos_1 = 0;
			while($rowOc = mysql_fetch_array($resOc)){
				$sumaBloqueos_1 += $rowOc['posicion'];
			}
		$idlocalidad = $rowMap['idLocalidad'];
	?>
		<div id="openthismap<?php echo $idlocalidad;?>" style="display:none;">
			<div class="closeEdit" onclick="closemap(<?php echo $idlocalidad;?>)"><img src="imagenes/close.png" alt="DDOX"/></div>
			
			<br>
			<table align="center" class="data_map" style="border-collapse:collapse;">
				<tr>
					<!--<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						<strong>Secuencial de las Filas</strong>
					</td>-->
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						<strong>Total Asientos</strong>
					</td>
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						<strong>N&uacute;mero de FILAS</strong>
					</td>
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						<strong>N&uacute;mero de COLUMNAS</strong>
					</td>
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						<strong>Acci&oacute;n</strong>
					</td>
				</tr>
				<tr>
					<!--<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						<center><select disabled id="secuencial<?php echo $idlocalidad?>">
							<option value="<?php echo $rowMap['strSecuncial']?>">
								<?php if($rowMap['strSecuencial'] == 0){
									echo'Numerico';
								}else{
									echo'Alfabetico';
								}?>
							</option>
						</select>
						<select disabled id="secuencialNew<?php echo $idlocalidad?>" style="display:none;">
							<option value="0">Num&eacute;rico</option>
							<option value="1">Alfab&eacute;tico</option>
						</select></center>
					</td>-->
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						<input disabled type="text" id="totalasientos<?php echo $idlocalidad;?>" size="3" onkeydown="justInt(event,this);" value="<?php echo $rowMap['strCapacidadL'];?>" readonly="readonly" />
						<input disabled type="hidden" id="bdtotalAsientos<?php echo $idlocalidad?>" value="<?php echo $rowMap['strCapacidadL'];?>" />
					</td>
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						<input disabled type="text" id="files<?php echo $idlocalidad;?>" size="3" onkeydown="justInt(event,this);" value="<?php echo $rowMap['intFilasB'];?>" maxlength="2" readonly="readonly" />
						<input disabled type="hidden" id="bdFiles<?php echo $idlocalidad;?>" value="<?php echo $rowMap['intFilasB'];?>" />
					</td>
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						<input disabled type="text" id="seats<?php echo $idlocalidad;?>" size="3" onkeydown="justInt(event,this);" value="<?php echo $rowMap['intAsientosB'];?>" maxlength="3" readonly="readonly" />
						<input disabled type="hidden" id="bdSeats<?php echo $idlocalidad;?>" value="<?php echo $rowMap['intAsientosB'];?>" />
					</td>
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;" >
						<button type="button" class="btnlink" id="creategrid<?php echo $idlocalidad;?>" onclick="addGrid('<?php echo $idlocalidad;?>')" style="display:none;"><strong>Crear Cuadr&iacute;cula</strong></button>
						<!--<button type="button" class="btnlink" id="nuevagrid<?php echo $idlocalidad;?>" onclick="newgrid('<?php echo $idlocalidad;?>')" style="display:block;"><strong>Modificar Cuadr&iacute;cula</strong></button>-->
						<!--<button type="button" class="btnlink" id="nuevagrid<?php echo $idlocalidad;?>" onclick="modificaCuadricula('<?php echo $idlocalidad;?>')" style="display:block;"><strong>Modificar Cuadr&iacute;cula</strong></button>-->
					</td>
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;" >
						<button type="button" class="btn btn-success" onclick = 'ver_cuadricula_localidad(<?php echo $idlocalidad;?>,<?php echo $_REQUEST['id'];?>)' >Ver Cuadricula</button>
					</td>
				</tr>
				<tr>
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						<strong>Asientos Disponibles:</strong> 
						<center>
							<div style="width:15px; height:15px; background-color: #fff; border: #000 solid 1px;"></div>
						</center>
						<input disabled type="text" id="total_disponibles_<?php echo $idlocalidad;?>" value = "<?php echo $rowMap['strCapacidadL'] - $sumaBloqueos_1;?>" readonly="readonly" size="3" />
					</td>
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						
					</td>
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						<strong>Asientos No Disponibles:</strong> 
						<center>
							<div style="width:15px; height:15px; background-color: #000; border: #000 solid 1px;"></div>
						</center>
						<input disabled type="text" id="total_nodisponibles_<?php echo $idlocalidad;?>" value = "<?php echo $sumaBloqueos_1;?>" readonly="readonly" size="3" />
					</td>
					<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
						
					</td>
				</tr>
			</table><br>
		</div>
	<?php }?>
</div>
	<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ver_cuadricula_localidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" >
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
						&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;
					</div>
				</div>
				<div class="modal-body" id = 'recibeCuadricula'>
				</div>
				<div class="modal-footer"  >
					
				</div>
			</div>
		</div>
	</div>
	<style>
		h1 , h2 , h3 , h4 , h5 , h6 {
			padding-top: 0px;
		}
		.modal-dialog-cuadricula {
		  width: 100%;
		  height: 100%;
		  padding: 0;
		}

		.modal-content-cuadricula {
		  height: 100%;
		  border-radius: 0;
		}
	</style>
	<script>
		function ver_cuadricula_localidad(id_loc,idcon){
			$('#ver_cuadricula_localidad').modal('show');
			$('#recibeCuadricula').html('<center><h1>Espere, Cargando informacion</h1></center>');
			$.post("spadmin/pruebas_sillas.php",{ 
				id_loc : id_loc , idcon : idcon
			}).done(function(data){
				$('#recibeCuadricula').html(data);		
			});
			
		}
	</script>
	<div class="modal fade" id="cortesia" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel " aria-hidden="false"  style="display: none; padding-right: 17px;">
		<div class="modal-dialog" role="document" style = 'width:95%;'>
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color:#000;">×</button>
					</h4>
				</div>
				<div class="modal-body">
					<div class="row" style="text-align:center;">
						<div class="col-lg-12">
							<?php
								echo '<input disabled type = "hidden" id = "nombre_concierto" value = "'.$strEvento.'"/> ';
							?>
							<h4 id = 'tituloConfiguracion'></h4>
							<?php
								
								$sqlCo = 'select * from Localidad where idConc = "'.$_REQUEST['id'].'" ';
								$resCo = mysql_query($sqlCo) or die (mysql_error());
							?>
							<table class='table table-border' style='display:none;' id='tblCortesia'>
								<tr>
									<td>
										Localidad
									</td>
									<td>
										N° tickets
									</td>
									<td>
										Opciones
									</td>
								</tr>
							<?php
								while($rowCo = mysql_fetch_array($resCo)){
									$sqlCor = 'select * from cortesias where id_con = "'.$_REQUEST['id'].'" and id_loc = "'.$rowCo['idLocalidad'].'" and tipo = "1" ';
									$resCor = mysql_query($sqlCor) or die (mysql_error());
									if(mysql_num_rows($resCor)>0 || mysql_num_rows($resCor) != null){
										$rowCor = mysql_fetch_array($resCor);
										$num_bol = $rowCor['num_bol'];
										$boton = '<button type="button" class="btn btn-danger">Creado</button>';
										$read = 'readonly';
										$disabled = 'disabled';
									}else{
										$num_bol = '';
										$boton = '<button type="button" class="btn btn-success" onclick="grabarCortesia('.$_REQUEST['id'].' ,'.$rowCo['idLocalidad'].' , 1)" >Grabar  <img src = "loader.gif" style="width:20px;display:none;"  id="loader'.$rowCo['idLocalidad'].'" /></button>';
										$read = '';
										$disabled = '';
									}
							?>
								<tr>
									<td>
										<?php echo $rowCo['strDescripcionL'];?>
									</td>
									<td align='center'>
										<input disabled type = 'text' maxlength = '2' style='width:40px;' id = 'numBoletos<?php echo $rowCo['idLocalidad'];?>' value = '<?php echo $num_bol;?>' <?php echo $read;?> <?php echo $disabled;?> class = 'entero'/>
									</td>
									<td>
										<?php echo $boton;?>
									</td>
								</tr>
							<?php
								}
							?>
							</table>
							
							<div id = 'recibeConsultaCortesias'>
								<table class='table table-border' style='display:none;' id='tblEmpresario'>
									<tr>
										<td colspan = '9' align = 'right' >
											<button type="button" class="btn btn-danger" onclick = 'graba_boletos_empresario(<?php echo $id;?>)' >Grabar Boletos Empresario</button>
										</td>
									</tr>
									<tr>
										<td>
											Localidad
										</td>
										<td>
											Precio
										</td>
										<td>
											N° tickets entregados
										</td>
										<td>
											Valor
										</td>
										<td>
											N° tickets devueltos
										</td>
										<td>
											Valor
										</td>
										<td>
											tickets vendidos
										</td>
										<td>
											total vendido
										</td>
										<td>
											Opciones
										</td>
									</tr>
								<?php
									$sqlCo1 = 'select * from Localidad where idConc = "'.$_REQUEST['id'].'" ';
									$resCo1 = mysql_query($sqlCo1) or die (mysql_error());
									while($rowCo1 = mysql_fetch_array($resCo1)){
										$sqlCor1 = 'select id , sum(num_bol) as num_bol , sum(numbol_devueltos) as numbol_devueltos from cortesias where id_con = "'.$_REQUEST['id'].'" and id_loc = "'.$rowCo1['idLocalidad'].'" and tipo = "2" and estado = "1"';
										//echo $sqlCor1."<br/>";
										
										$resCor1 = mysql_query($sqlCor1) or die (mysql_error());
										//echo mysql_num_rows($resCor1)."kdf";
										$rowCorEmp = mysql_fetch_array($resCor1);
										$num_bolEmp = $rowCorEmp['num_bol'];
										$numbol_devueltosEmp = $rowCorEmp['numbol_devueltos'];
										//echo $num_bolEmp."<<>>".$numbol_devueltosEmp;
										if(($num_bolEmp != '')){
											
											$sqlCor11 = 'select sum(num_bol) as num_bol , sum(numbol_devueltos) as numbol_devueltos from cortesias where id_con = "'.$_REQUEST['id'].'" and id_loc = "'.$rowCo1['idLocalidad'].'" and tipo = "2" and estado = "1"';
											$resCor11 = mysql_query($sqlCor11) or die (mysql_error());
											
											$rowCor1 = mysql_fetch_array($resCor11);
											
											$bolVendidos = ($rowCor1['num_bol'] - $rowCor1['numbol_devueltos']);
											$sumbolVendidos += $bolVendidos;
											$totalVendidoEmp = ($bolVendidos * $rowCo1['doublePrecioL']);
											$sumtotalVendidoEmp += $totalVendidoEmp;
											
											$num_bol1 = $rowCor1['num_bol'];
											$sumnum_bol1 +=$num_bol1;//total tik entregados
											
											$bolXPrecio = ($rowCor1['num_bol'] * $rowCo1['doublePrecioL']);
											$sumbolXPrecio += $bolXPrecio;
											
											$bolXPrecioDevuelto = ($rowCor1['numbol_devueltos'] * $rowCo1['doublePrecioL']);
											$sumbolXPrecioDevuelto += $bolXPrecioDevuelto;
											
											$numbol_devueltos = $rowCor1['numbol_devueltos'];
											$sumnumbol_devueltos += $numbol_devueltos;
											
											$boton1 = '<button type="button" class="btn btn-danger">Creado</button>';
											$read1 = 'readonly';
											$disabled1 = 'disabled';
											$display = 'display:block;';
											$display2 = 'display:none;';
										}else{
											$num_bol1 = '';
											$numbol_devueltos = 0;
											$boton1 = '<button type="button" class="btn btn-success" onclick="grabarCortesia('.$_REQUEST['id'].' ,'.$rowCo1['idLocalidad'].' , 2)" >Grabar  <img src = "loader.gif" style="width:20px;display:none;"  id="loader'.$rowCo1['idLocalidad'].'" /></button>';
											$read1 = '';
											$disabled1 = '';
											$bolXPrecio=0;
											$bolXPrecioDevuelto=0;
											$bolVendidos = 0;
											$totalVendidoEmp=0;
											$display = 'display:none;';
											$display2 = 'display:block;';
										}
								?>
									<tr>
										<td>
											<?php echo $rowCo1['strDescripcionL'];?>
										</td>
										<td>
											<?php echo $rowCo1['doublePrecioL'];?>
										</td>
										<td align='center'>
											<table style = '<?php echo $display;?>'>
												<tr>
													<td>
														<input disabled type = 'text' maxlength = '4' style='width:50px;' id = 'numBoletos<?php echo $rowCo1['idLocalidad'];?>' value = '<?php echo $num_bol1;?>' <?php echo $read1;?> <?php echo $disabled1;?> class = 'entero'/>
													</td>
													<td style = 'padding.left:4px;padding-right:4px;'>
														<button type="button" class="btn btn-warning btn-xs" onclick='agragaMas(<?php echo $_REQUEST['id'];?> , <?php echo $rowCo1['idLocalidad'];?> ,"<?php echo $rowCo1['strDescripcionL'];?>", 2)'>Agregar Más</button><br/><br/>
														<button type="button" class="btn btn-success btn-xs" onclick = 'verDetalleCortesia(<?php echo $_REQUEST['id'];?> , <?php echo $rowCo1['idLocalidad'];?>)'>Ver Detalle</button>
													</td>
												</tr>
											</table>
											<table style = '<?php echo $display2;?>'>
												<tr>
													<td>
														<input disabled type = 'text' maxlength = '4' style='width:50px;' id = 'numBoletos2<?php echo $rowCo1['idLocalidad'];?>' value = '<?php echo $num_bol1;?>' <?php echo $read1;?> <?php echo $disabled1;?> class = 'entero'/>
													</td>
												</tr>
											</table>
										</td>
										<td align='center'>
											<?php echo number_format(($bolXPrecio),2);?>
										</td>
										<td align='center'>
											<input disabled type = 'text' maxlength = '4' style='width:50px;' id = 'numbol_devueltos_<?php echo $rowCo1['idLocalidad'];?>' value = '<?php echo $numbol_devueltos;?>' class = 'entero'/>
											<br/><button type="button" class="btn btn-primary btn-xs" style = '<?php echo $display;?>' onclick = 'grabarDevueltos(<?php echo $rowCorEmp['id'];?> , <?php echo $rowCor1['numbol_devueltos'];?> , <?php echo $rowCo1['idLocalidad'];?>);'>Grabar</button>
										</td>
										<td align='center'>
											<?php echo number_format(($bolXPrecioDevuelto),2);?>
										</td>
										<td align='center'>
											<?php echo $bolVendidos;?>
										</td>
										<td align='center'>
											<?php echo number_format(($totalVendidoEmp),2);?>
										</td>
										<td>
											<?php echo $boton1;?>
										</td>
									</tr>
								<?php
									}
								?>
									<tr>
										<td>
											Total
										</td>
										<td>
											
										</td>
										<td align='center'>
											<?php echo $sumnum_bol1;?>
										</td>
										<td align='center'>
											<?php echo number_format(($sumbolXPrecio),2);?>
										</td>
										<td align='center'>
											<?php echo $sumnumbol_devueltos;?>
										</td>
										<td align='center'>
											<?php echo number_format(($sumbolXPrecioDevuelto),2);?>
										</td>
										<td align='center'>
											<?php echo $sumbolVendidos;?>
										</td>
										<td align='center'>
											<?php echo number_format(($sumtotalVendidoEmp),2);?>
										</td>
										<td>
											
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					
				</div>
			</div>
		</div>
	</div>
	
	
	
	<div class="modal fade" id="cortesia_mas" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel " aria-hidden="false"  style="display: none; padding-right: 17px;padding-top: 10%;background-color:rgba(0,0,0,0.7);">
		<div class="modal-dialog" role="document" style = 'width:55%;'>
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color:#000;">×</button>
					</h4>
				</div>
				<div class="modal-body" >
					<div id = 'contieneMas'>
						<h3>Ingrese Numero de Boletos para la localidad de : <span id = 'localidad_mas' style = 'color:blue;text-transform:uppercase;'></span></h3>
						<input disabled type = 'text' class = 'form-control entero' id = 'numticket_mas' maxlength = '4' placeholder = '0' value = '0'/>
						<input disabled type = 'hidden' id = 'concierto_mas' />
						<input disabled type = 'hidden' id = 'local_mas' />
						<input disabled type = 'hidden' id = 'ident_mas' />
						<button type="button" class="btn btn-success" onclick = 'grabarCortesia2()'>Grabar <img src = 'imagenes/ajax-loader2.gif' id = 'load_mas' style = 'display:none;'/></button>
					</div>
					<div id = 'recibeDetCor' ></div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function actualizaDes(id_con){
			var docu = $('#docu').val();
			var municip = $('#municip').val();
			var desg = $('#desg').val();
			if (docu == 'Si') {
				docu = 1;
			}else{
				docu = 0;
			}

			if (desg == 'Si') {
				desg = 1;
			}else{
				desg = 0;
			}

			if (municip == 'Si') {
				municip = 1;
			}else{
				municip = 0;
			}
			if(docu == ''){
				docu = 0;
			}

			if(desg == ''){
				desg = 0;
			}
			if(municip == ''){
				municip = 0;
			}
				
			$('#actualizaDes').attr('disabled',true);
			$.post("spadmin/actualizaDesgl_docu.php",{ 
				id_con : id_con , docu : docu , desg : desg , municip : municip
			}).done(function(data){
				alert(data);
				location.reload();
			});
		}
		function enviaImpuestos(id , id_con){ 
			//alert(id);
			var valorados = $('#valorados').val();
			var cortesias = $('#cortesias').val();
			var sayse = $('#sayse').val();
			var sri = $('#sri').val();
			var municipio = $('#municipio').val();
			if(valorados == '' ){
				alert('ingrese un valor para los tickets valorados');
			}
			if(cortesias == '' ){
				alert('ingrese un valor para las cortesias');
			}
			if(sayse == '' ){
				alert('ingrese un valor para impuesto de sayse');
			}
			if(sri == '' ){
				alert('ingrese un valor para impuesto de sri');
			}
			if(municipio == '' ){
				alert('ingrese un valor para impuesto de municipio');
			}
			if(valorados == '' || cortesias == '' || sayse == '' || sri == '' || municipio == ''){
				
			}else{
				$('#enviaImpuestos').attr('disabled',true);
				$.post("spadmin/actualizaImpuestos.php",{ 
					id : id , valorados : valorados , cortesias : cortesias , sayse : sayse , sri : sri , municipio : municipio , id_con : id_con
				}).done(function(data){
					alert(data);
					location.reload();
				});

			}
		}
		function envia_det_comi_ret(id){
			var valores_comi = '';
			var conciertoID = $('#conciertoID').val();
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
			//alert(valores_comiFormateado);
			$('#envia_det_comi_ret').attr('disabled',true);
			$.post("spadmin/actualiza_com_ret.php",{ 
				id : id , valores_comi : valores_comi , conciertoID : conciertoID
			}).done(function(data){
				if(id == 1){
					alert('Valores de comisiones y retenciones actualizados con Extito');
				}
				if(id == 2){
					alert('Valores de comisiones y retenciones ingresados con Extito');
				}
				
			});
		}
	
	function actualizaClaves(id_cla , ident , id_con ){
		var clave_reimp = $('#clave_reimp').val();
		var clave_reasig = $('#clave_reasig').val();
		var clave_app = $('#clave_app').val();
		$('#actualizaClaves').attr('disabled',true);
		$.post("spadmin/gravaClaves.php",{ 
			clave_reimp : clave_reimp , clave_reasig : clave_reasig ,
			id_cla : id_cla , ident : ident , id_con : id_con , clave_app : clave_app
		}).done(function(data){
			alert(data);
			location.reload();
		});
		
	}
	function graba_boletos_empresario(id){
		$.post("spadmin/graba_boletos_empresario.php",{ 
			id : id
		}).done(function(data){
			alert(data);
		});
	}
	function grabarDevueltos(id , numbol_devueltos , local){
		var bol_devueltos_ = $('#numbol_devueltos_'+local).val();
		//alert(bol_devueltos_);
		var total_devueltos = bol_devueltos_;
		if(bol_devueltos_ == ''){
			alert('Debe ingresar un valor entero');
		}else{
			$.post("spadmin/grabarDevueltos.php",{ 
				id : id , total_devueltos : total_devueltos
			}).done(function(data){
				alert(data);
				location.reload();
			});
		}
		
	}
	function verDetalleCortesia(concierto , local){
		var tipos_boleto_entregado = $('#tipos_boleto_entregado').val();
		$.post("spadmin/verDetalleCortesia.php",{ 
			concierto : concierto , local : local , tipos_boleto_entregado : tipos_boleto_entregado
		}).done(function(data){
			$('#recibeDetCor').html(data);
			$('#contieneMas').css('display','none');
			$('#recibeDetCor').css('display','block');
			$('#cortesia_mas').modal('show');
		});
	}
	function agragaMas(concierto , local , nom_loc , ident){
		//alert(concierto +'<<>>'+ local);
		$('#cortesia_mas').modal('show');
		$('#recibeDetCor').html('');
		$('#recibeDetCor').css('display','none');
		$('#localidad_mas').html(nom_loc);
		$('#concierto_mas').val(concierto);
		$('#local_mas').val(local);
		$('#ident_mas').val(ident);
	}
	
	
	function grabarCortesia2(){
		var id_con = $('#concierto_mas').val();
		var id_loc = $('#local_mas').val();
		var ident = $('#ident_mas').val();
		var numticket = $('#numticket_mas').val();
		var tipos_boleto_entregado = $('#tipos_boleto_entregado').val();
		if (ident == 2){
			//var numticket = $('#numBoletos2'+id_loc).val();
			if(numticket == ''){
				alert('Debe ingresar un numero de boletos para empresario');
			}else{
				if(numticket == 0){
					alert('No puedes ingresar como numero de boletos para empresario  un CERO');
				}else{
					$('#load_mas').css('display','block');
					$.post("spadmin/creaBoletosEmpresario.php",{ 
						con : id_con , idlocal : id_loc , numticket : numticket , tipos_boleto_entregado : tipos_boleto_entregado
					}).done(function(data){
						$('#load_mas').css('display','none');
						if(data == 1){
							alert('boletos para empresario creado con Éxito');
							location.reload();
						}else{
							alert('error');
							location.reload();
						}
					});
				}
			}
			
		}
	}
	$(function(){
		var btnUpload=$('#uploadIzq');
		new AjaxUpload(btnUpload, {
			action: 'spadmin/procesaImgBoletosIzq.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(PCX|pcx)$/.test(ext))){
					alert('Solo imagenes PCX.');
					return false;
				}
			},
			onComplete: function(file, response){
				var mirsp = response;
				//reload ();
				document.getElementById('fotoIzq').value=mirsp;
				document.getElementById('fotoIzqMostrar').src='../../'+mirsp;
				
			}
		});
	});



	$(function(){
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
	});



	$(function(){
		var btnUpload=$('#uploadDer');
		new AjaxUpload(btnUpload, {
			action: 'spadmin/procesaImgBoletosDer.php',
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
				document.getElementById('fotoDer').value=mirsp;
				document.getElementById('fotoDerMostrar').src='../../'+mirsp;
				
			}
		});
	});
	
	
	
	
	$(function(){
		var btnUpload=$('#uploadACen');
		new AjaxUpload(btnUpload, {
			action: 'spadmin/procesaImgBoletosACen.php',
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
				document.getElementById('fotoACen').value=mirsp;
				//document.getElementById('fotoDerMostrar').src='../../'+mirsp;
				
			}
		});
	});
	
	
	
	function grabarCortesia(id_con , id_loc  , ident){
		var tipos_boleto_entregado = $('#tipos_boleto_entregado').val();
		if(ident == 1){
			var numticket = $('#numBoletos'+id_loc).val();
			if(numticket == ''){
				alert('Debe ingresar un numero de cortesias');
			}else{
				if(numticket == 0){
					alert('No puedes ingresar como numero de cortesias  un CERO');
				}else{
					$('#loader'+id_loc).css('display','block');
					$.post("spadmin/creaCortesia.php",{ 
						con : id_con , idlocal : id_loc , numticket : numticket
					}).done(function(data){
						$('#loader'+id_loc).css('display','none');
						if(data == 1){
							alert('Costesia creada con Éxito');
							location.reload();
						}else{
							alert('error');
							location.reload();
						}
					});
				}
			}
			
		}else if (ident == 2){
			var numticket = $('#numBoletos2'+id_loc).val();
			if(numticket == ''){
				alert('Debe ingresar un numero de cortesias');
			}else{
				if(numticket == 0){
					alert('No puedes ingresar como numero de cortesias  un CERO');
				}else{
					$('#loader'+id_loc).css('display','block');
					$.post("spadmin/creaBoletosEmpresario.php",{ 
						con : id_con , idlocal : id_loc , numticket : numticket , tipos_boleto_entregado : tipos_boleto_entregado
					}).done(function(data){
						$('#loader'+id_loc).css('display','none');
						if(data == 1){
							alert('Costesia creada con Éxito');
							location.reload();
						}else{
							alert('error');
							location.reload();
						}
					});
				}
			}
			
		}
	}
	function verConfCortesias(id){
		var nombre_concierto = $('#nombre_concierto').val();
		if(id == 1){
			
			$('#tituloConfiguracion').html('Cortesias para el concierto de  : ' + nombre_concierto);
			$('#tblCortesia').fadeIn('slow');
			$('#tblEmpresario').fadeOut('fast');
		}else if(id == 2){
			$('#tituloConfiguracion').html('<table width = "90%" align ="center">\
												<tr>\
													<td>Tickets</td>\
													<td>\
														<select disabled class = "form-control" id ="tipos_boleto_entregado" onchange = "consulta_tipo_boleto();"><option value ="1">Normales</option><option value ="2">3Ra Edad</option><option value ="3">Niños</option></select></td>\
													<td>Empresario para el concierto de  : <span style = "color:blue;text-transform:uppercase;">'+nombre_concierto+'</span></td>\
											</table>\
											');
			$('#tblEmpresario').fadeIn('slow');
			$('#tblCortesia').fadeOut('fast');
		}
		$('#cortesia').modal('show');
	}
	
	function consulta_tipo_boleto(){
		var id_tipo_boleto = $('#tipos_boleto_entregado').val();
		var id = $('#conciertoID').val();
		$.post("spadmin/consulta_tipo_boleto.php",{ 
			id_tipo_boleto : id_tipo_boleto , id : id
		}).done(function(data){
			$('#recibeConsultaCortesias').html(data);
		});
	}
	function enviar(){
		var tipoConcierto =  $('input:radio[name=tipoConcierto]:checked').val();
		var idConcierto = $('#id').val();
		var evento = $('#evento').val();
		var lugar = $('#lugar').val();
		var fecha = $('#fecha').val();
		var fechareserva = $('#fechareserva').val();
		var fechapreserva = $('#fechapreserva').val();
		var fechapreventa = $('#fechapreventa').val();
		var hora = $('#hora').val();
		var img1 = $('#imagen').val();
		var img = $('#imgok').val();
		var strVideoC = $('#strVideoC').val();
		var des = $('#des').val();
		var car = $('#car').val();
		var obscambio = $('#obsCambio').val();
		var valores = '';
		var variables = '';
		var newlocal = '';
		var newartista = '';
		var tiempoPago = $('#tiempoPago').val();
		var dirCanje = $('#dirCanje').val();
		var horCanje = $('#horCanje').val();
		var fIniCanje = $('#fIniCanje').val();
		var fFinCanje = $('#fFinCanje').val();
		var cosEnv = $('#cosEnv').val();
		if (cosEnv == 'Si') {
			cosEnv = 1;
		}else{
			cosEnv = 0;
		}
		var porcTarj = $('#porcTarj').val();
		var estadoCon = $('#estadoCon').val();
		var mapaCon = $('#mapaCon').val();
		var mapaOpC = $('#mapaOpC').val();
		var autMun = $('#autMun').val();
		var cosEnv2 = $('#cosEnv2').val();
		
		
		var lugPago = $('#lugPago').val();
		var dirPago = $('#dirPago').val();
		var fecPago = $('#fecPago').val();
		var horPago = $('#horPago').val();
		
		
		$('.artistas').each(function(){
			var nombre = $(this).find('td .nombre_art').val();
			var face = $(this).find('td .facebook').val();
			var twi = $(this).find('td .twitter').val();
			var youtube = $(this).find('td .youtube').val();
			var instagram = $(this).find('td .instagram').val();
			var idart = $(this).find('td .idart').val();
			variables += nombre +'|'+ face +'|'+ twi +'|'+ youtube +'|'+ instagram +'|'+ idart +'|'+'@';
		});
		var variablesF = variables.substring(0,variables.length -1);
		
		$('.artistas_new').each(function(){
			var new_nombre = $(this).find('td .nombre_art_new').val();
			var face_new = $(this).find('td .facebook_new').val();
			var twi_new = $(this).find('td .twitter_new').val();
			var you_new = $(this).find('td .youtube_new').val();
			var instagram_new = $(this).find('td .instagram_new').val();
			newartista += new_nombre +'|'+ face_new +'|'+ twi_new +'|'+ you_new +'|'+ instagram_new +'|'+'@';
 		});
		var valores_newartista = newartista.substring(0,newartista.length -1);
		
		$('.localidades').each(function(){
			var loc = $(this).find('td .loc').val();
			var precio = $(this).find('td .precio').val();
			var siglas = $(this).find('td .siglas').val();
			var puerta = $(this).find('td .puerta').val();
			var porcentaje_reserva = $(this).find('td .por_reserva').val();
			var precio_reserva = $(this).find('td .pre_reserva').val();
			var porcentaje_preventa = $(this).find('td .por_preventa').val();
			var precio_preventa = $(this).find('td .pre_preventa').val();
			var idloc = $(this).find('td .idloc').val();
			var cantidad = $(this).find('td .cantidad').val();
			var caracteristica = $(this).find('td .char').val();
			
			valores += loc +'|'+ precio +'|'+ siglas +'|'+ porcentaje_reserva +'|'+ precio_reserva +'|'+ porcentaje_preventa +'|'+ precio_preventa +'|'+ idloc +'|'+ cantidad +'|'+ caracteristica +'|'+ puerta +'|'+'@';
		});
			
		var valoresFormateado = valores.substring(0,valores.length -1);
		
		$('.localidadesnew').each(function(){
			var locnew = $(this).find('td .loc_new').val();
			var precionew = $(this).find('td .precio_new').val();
			var siglas_new = $(this).find('td .siglas_new').val();
			var puerta_new = $(this).find('td .puerta_new').val();
			var por_reserva_new = $(this).find('td .reservacion_new').val();
			var pre_reserva_new = $(this).find('td .p_reserva_new').val();
			var por_preventa_new = $(this).find('td .p_venta_new').val();
			var pre_preventa_new = $(this).find('td .p_preventa_new').val();
			var cantidadnew = $(this).find('td .cantidad_new').val();
			var caracteristicanew = $(this).find('td .char_new').val();
			
			newlocal += locnew +'|'+ siglas_new +'|'+ precionew +'|'+ por_reserva_new +'|'+ pre_reserva_new +'|'+ por_preventa_new +'|'+ pre_preventa_new +'|'+ cantidadnew +'|'+ caracteristicanew+'|'+ puerta_new +'|'+'@';
		});
		var nuevolocal = newlocal.substring(0,newlocal.length -1);
		
		if((evento == '') || (lugar == '') || (fecha == '') || (fechareserva == '') || (fechapreserva == '') || (fechapreventa == '') || (hora == '') || (img == '') || (des == '') || (car == '') || (obscambio == '')){
			alert('Faltan campos por llenar');
		}else{
			$.post('spadmin/upd_concierto.php',{
				idConcierto : idConcierto, evento : evento, lugar : lugar, fecha : fecha, fechareserva : fechareserva, fechapreserva : fechapreserva, fechapreventa: fechapreventa,
				hora : hora, img1 : img1, img : img, des : des, car : car, obscambio : obscambio, valores : valoresFormateado, newartista : valores_newartista, variables : variablesF, 
				newlocal : nuevolocal , tiempoPago : tiempoPago , dirCanje : dirCanje , horCanje : horCanje , 
				fIniCanje : fIniCanje ,fFinCanje : fFinCanje ,cosEnv : cosEnv , porcTarj : porcTarj , cosEnv2 : cosEnv2 ,
				estadoCon : estadoCon , mapaCon : mapaCon , mapaOpC : mapaOpC , strVideoC : strVideoC , autMun : autMun ,
				lugPago : lugPago , dirPago : dirPago , fecPago : fecPago , horPago : horPago , tipoConcierto : tipoConcierto
			}).done(function(data){
				alert('Concierto Modificado');
				var con = data;
				window.location.href = '?modulo=creacionmapa&con='+con;
			});
		}
	}
	
	
	$(document).ready(function(){
		
		// $('#fecha').datetimepicker({
			// timepicker: false,
			// minDate:0,
			// mask:true,
			// format:'Y/m/d'
		// });
		
		$('.entero').numeric();
		$('#hora').datetimepicker({
			datepicker:false,
			mask: true,
			format:'H:i'
		});
		
		$('#cancel').on('click',function(){
			window.location.href = '?modulo=listaConciertos';
		});
		
		$( "#permisos" ).change(function() {
			var permisos = $( "#permisos" ).val();
			var conciertoID = $( "#conciertoID" ).val();
			if(permisos ==''){
				alert('Debe seleccionar una opcion válida');
			}else{
				$.post('spadmin/actualizaPermisos.php',{
					conciertoID : conciertoID , permisos : permisos
				}).done(function(data){
					alert(data);
					location.reload();
				});
			}
			
			if(permisos == 0){
				$('#contieneImgIzq').css('display','block');
				$('#contieneImgDer').css('display','block');
				$('#contieneImgCen').css('display','block');
			}else{
				$('#contieneImgIzq').css('display','none');
				$('#contieneImgDer').css('display','none');
				$('#contieneImgCen').css('display','none');
			}
		});
	});
	
	var count_artistas = 1;
	$('#add_artistas').on('click',function(){
		$('#art').append('<tr class="artistas_new" style="text-align:center;">\
							<td align="left">\
								<input disabled type="text" class="nombre_art_new inputlogin" size="15" id="nombre_art'+count_artistas+'" placeholder="Nombre Artistico" required="required" />\
							</td>\
							<td align="left">\
								<input disabled type="text" class="facebook_new inputlogin" size="15" id="facebook'+count_artistas+'" placeholder="facebook.com/Artista" required="required" />\
							</td>\
							<td align="left">\
								<input disabled type="text" class="twitter_new inputlogin" size="15" id="twitter'+count_artistas+'" placeholder="twitter.com/Artista" required="required" />\
							</td>\
							<td align="left">\
								<input disabled type="text" class="youtube_new inputlogin" size="15" id="youtube'+count_artistas+'" placeholder="youtube.com/Artista" required="required" />\
							</td>\
							<td align="left">\
								<input disabled type="text" class="instagram_new inputlogin" size="15" id="instagram'+count_artistas+'" placeholder="instagram.com/Artista" required="required" />\
							</td>\
						</tr>');
		count_artistas += 1;
	});
	
	function calculoXprecio(id){
		var precio = $('#precio'+id).val();
		var porcentaje_reserva = $('#por_reserva'+id).val();
		var porcentaje_preventa = $('#por_preventa'+id).val();
		var total_reserva = ((precio * porcentaje_reserva) / 100);
		total_reserva = (Math.ceil(total_reserva)).toFixed(2);
		$('#pre_reserva'+id).val(total_reserva);
		var total_preventa = ((precio * porcentaje_preventa) / 100);
		total_preventa = (Math.ceil(total_preventa)).toFixed(2);
		$('#pre_preventa'+id).val(total_preventa);
	}
	
	function calculoReserva(id){
		var precio = $('#precio'+id).val();
		var porcentaje_reserva = $('#por_reserva'+id).val();
		var total_reserva = ((precio * porcentaje_reserva) / 100);
		total_reserva = (Math.ceil(total_reserva)).toFixed(2);
		$('#pre_reserva'+id).val(total_reserva);
	}
	
	function calculoPreventa(id){
		var precio = $('#precio'+id).val();
		var porcentaje_preventa = $('#por_preventa'+id).val();
		var total_preventa = ((precio * porcentaje_preventa) / 100);
		total_preventa = (Math.ceil(total_preventa)).toFixed(2);
		$('#pre_preventa'+id).val(total_preventa);
	}
	
	function cantidadNo(id){
		alert('Modifica el mapa primero');
	}
	
	var contador=1;
	$( "#nuevo" ).on("click", function() {
	$( "#local" ).append('<tr class="localidadesnew" id="fila_add'+contador+'">\
							<td style="text-align:center; border-right: #c0c0c0 solid 1px;">\
								<input disabled type="text" id="loc_new'+contador+'" class="loc_new inputlogin" placeholder="VIP,Palco,General,etc" required/>\
							</td>\
							<td style="text-align:center; border-right: #c0c0c0 solid 1px;">\
								<input disabled type="text" id="precio_new'+contador+'" class="precio_new inputlogin" placeholder="000.00" size="3" required/>\
							</td>\
							<td style="text-align:center; border-right: #c0c0c0 solid 1px;">\
								<input disabled type="text" id="siglas'+contador+'" class="siglas_new inputlogin" Iniciales" size="3" required />\
							</td>\
							<td style="text-align:center; border-right: #c0c0c0 solid 1px;">\
								<input disabled type="text" id="puerta_new'+contador+'" class="puerta_new inputlogin" puerta_new" size="3" required />\
							</td>\
							<td style="text-align:center; border-right: #c0c0c0 solid 1px;">\
								<input disabled type="text" id="reservacion_new'+contador+'" class="reservacion_new inputlogin" size="3" placeholder="sin %" required="required" onkeyup="calcular_reserva('+contador+')"  />\
							</td>\
							<td style="text-align:center; border-right: #c0c0c0 solid 1px;">\
								<input disabled type="text" id="p_reserva_new'+contador+'" class="p_reserva_new inputlogin" size="3" readonly="readonly" />\
								<input disabled type="text" id="precio_s_redondear_res'+contador+'" size="3" class="inputlogin" readonly="readonly" />\
							</td>\
							<td style="text-align:center; border-right: #c0c0c0 solid 1px;">\
								<input disabled type="text" id="p_venta_new'+contador+'" class="p_venta_new inputlogin" size="3" placeholder="sin %" required="required" onkeyup="calcular_preventa('+contador+')" />\
							</td>\
							<td style="text-align:center; border-right: #c0c0c0 solid 1px;">\
								<input disabled type="text" id="p_preventa_new'+contador+'" class="p_preventa_new inputlogin" size="3" readonly="readonly" />\
								<input disabled type="text" id="precio_s_redondear_pre'+contador+'" size="3" class="inputlogin" readonly="readonly" />\
							</td>\
							<td style="text-align:center; border-right: #c0c0c0 solid 1px;">\
								<input disabled type="text" id="cantidad'+contador+'" class="cantidad_new inputlogin" size="3" required/>\
							</td>\
							<td style="text-align:center; border-right: #c0c0c0 solid 1px;">\
								<select disabled id="char'+contador+'" class="char_new inputlogin" onchange="ocultar('+contador+')">\
									<option value="Asientos numerados">Asientos Numerados</option>\
									<option value="Asientos sin numerar">Asientos sin numerar</option>\
								</select>\
							</td>\
							<td colspan="2" style="border-right: #c0c0c0 solid 1px;">\
								<center><button type="button" class="btnlink" id="delete_fila'+contador+'" onclick="borrar_fila('+contador+')"><strong>Eliminar</strong></button></center>\
							</td>\
						</tr>');
	contador+=1;
	});
	
	function borrar_fila(id){
		$('#fila_add'+id).remove();
	}
	
	function calcular_reserva(id){
		var precio = $('#precio_new'+id).val();
		var porcentaje = $('#reservacion_new'+id).val();
		var calculo = ((precio * porcentaje) / 100);
		var c = calculo.toFixed(2);
		$('#precio_s_redondear_res'+id).val(c);
		calculo = (Math.ceil(calculo)).toFixed(2);
		$('#p_reserva_new'+id).val(calculo);
	}
	
	function calcular_preventa(id){
		var precio = $('#precio_new'+id).val();
		var porcentaje = $('#p_venta_new'+id).val();
		var calculo = ((precio * porcentaje) / 100);
		var c = calculo.toFixed(2);
		$('#precio_s_redondear_pre'+id).val(c);
		calculo = (Math.ceil(calculo)).toFixed(2);
		$('#p_preventa_new'+id).val(calculo);
	}
	
	function openmap(id, concierto){
		$('.ocultarEdit').css({opacity:0.1});
		$('.ocultarEdit').fadeIn(300);
		$('.mostrarEdit').fadeIn(1000);
		$('#openthismap'+id).css('display','block');
		if($('.filas'+id).length){
			$('#createseats'+id).css('display','block');
		}else{
			if($('.table_bd'+id).length){
				$('#createseats'+id).css('display','block');
			}else{
				$.ajax({
					type : 'POST',
					url : 'spadmin/construir_asientos.php',
					data : 'id='+id +'&concierto='+concierto,
					success : function(response){
						// $('#createseats'+id).append(response);
						var total_seats = $('#totalasientos'+id).val();
						var disponibles = $('#createseats'+id+' input:checked').length;
						var asientos_nodisponible = total_seats - disponibles;
						$('#total_nodisponibles'+id).val(asientos_nodisponible);
						$('#total_disponibles'+id).val(disponibles);
					}
				});
			}
		}
	}
	
	function newgrid(id){
		if($('.vendidos'+id).length){
			alert('No puedes modificar esta localidad, ya tienes boletos vendidos');
		}else{
			$('#creategrid'+id).css('display','block');
			$('#nuevagrid'+id).css('display','none');
			$('#totalasientos'+id).removeAttr('readonly');
			$('#files'+id).removeAttr('readonly');
			$('#seats'+id).removeAttr('readonly');
			$('#secuencialNew'+id).css('display','block');
			$('#secuencial'+id).css('display','none');
			$('.table_bd'+id).remove();
		}
	}
	
	function addGrid(id){
		if($('.filas'+id).length){
			$('.filas'+id).remove();
		}
		var total_seats = $('#totalasientos'+id).val();
		var file = $('#files'+id).val();
		var seat = $('#seats'+id).val();
		var secuencial = $('#secuencialNew'+id).val();
		var cant = (file * seat);
		if(cant > total_seats){
			alert('Excediste la cantidad de Boletos: '+total_seats);
			$('#files'+id).val('');
			$('#seats'+id).val('');
			$('#files'+id).focus();
		}else{ 
			if(cant < total_seats){
				alert('Faltan asientos para esta Localidad: '+total_seats);
				$('#files'+id).val('');
				$('#seats'+id).val('');
				$('#files'+id).focus();
			}else{
				if(file > 25){
					alert('Solo puedes crear hasta 25 filas');
					$('#files'+id).val('');
					$('#seats'+id).val('');
					$('#files'+id).focus();
				}else{
					if(cant == total_seats){
						var countfile = 1;
						$('#createseats'+id).append('<tr id="columnas_num'+id+'" class="filas'+id+'"></tr>');
						$('#columnas_num'+id).append('<td colspan="3" style="text-align:center; vertical-align:middle;">Columnas-></td>');
						for(var y = 1; y <= seat; y++){
							$('#columnas_num'+id).append('<td style="text-align:center; vertical-align:middle;">'+y+'</td>');
						}
						for(var i = 0; i < file; i++){
							$('#createseats'+id).append('<tr id="num-'+countfile+'_cod-'+id+'" class="filas'+id+'"></tr>');
							$('#num-'+countfile+'_cod-'+id).append('<td align="left">\
															<img id="add'+id+'_'+countfile+'" src="imagenes/aumentar.png" style="width:18px; height:18px; display:none; float:left;" onclick="addseats('+countfile+','+id+')" />\
															<img id="remove'+id+'" src="imagenes/quitar.png" style="width:18px; height:18px;" onclick="removeseats('+countfile+','+id+')" />\
														</td>');
							if(secuencial == 0){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-'+countfile+'</td>');
							}else if(secuencial == 1){
								if(countfile == 1){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-A</td>');
								}
								if(countfile == 2){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-B</td>');
								}
								if(countfile == 3){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-C</td>');
								}
								if(countfile == 4){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-D</td>');
								}
								if(countfile == 5){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-E</td>');
								}
								if(countfile == 6){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-F</td>');
								}
								if(countfile == 7){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-G</td>');
								}
								if(countfile == 8){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-H</td>');
								}
								if(countfile == 9){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-I</td>');
								}
								if(countfile == 10){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-J</td>');
								}
								if(countfile == 11){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-K</td>');
								}
								if(countfile == 12){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-L</td>');
								}
								if(countfile == 13){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-M</td>');
								}
								if(countfile == 14){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-N</td>');
								}
								if(countfile == 15){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-O</td>');
								}
								if(countfile == 16){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-P</td>');
								}
								if(countfile == 17){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-Q</td>');
								}
								if(countfile == 18){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-R</td>');																	
								}
								if(countfile == 19){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-S</td>');
								}
								if(countfile == 20){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-T</td>');
								}
								if(countfile == 21){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-U</td>');
								}
								if(countfile == 22){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-V</td>');
								}
								if(countfile == 23){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-W</td>');
								}
								if(countfile == 24){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-X</td>');
								}
								if(countfile == 25){
									$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-Y</td>');
								}
							}
							$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">\
																		<input disabled type="text" id="totalAsientos'+countfile+'-'+id+'" class="AsientosXfila'+countfile+'-'+id+'" value="'+seat+'" size="3" onkeyup="ColsXtext('+countfile+','+id+','+seat+')" />\
																	</td>');
							var countcolumnas = 1;
							for(var j = 0; j < seat; j++){
								$('#num-'+countfile+'_cod-'+id).append('<td class="grid'+countfile+'_'+id+'" id="fl-'+countfile+'_as-'+countcolumnas+'_cod-'+id+'">\
																			<input disabled type="checkbox" id="F-'+countfile+'_A-'+countcolumnas+'_C-'+id+'" checked="checked" onclick="seatok('+countfile+','+countcolumnas+','+id+')" /> \
																			<center><div id="file-'+countfile+'_A-'+countcolumnas+'_C-'+id+'" style="width:13px; height:13px; background-color:#000; display:none;">\
																			</div></center>\
																	</td>');
								countcolumnas += 1;
							}
							countfile += 1;
						}
					}
					var disponibles = $('#createseats'+id+' input:checked').length;
					var asientos_nodisponible = total_seats - disponibles;
					$('#total_nodisponibles'+id).val(asientos_nodisponible);
					$('#total_disponibles'+id).val(disponibles);
				}
				
			}
		}
	}
	
	function addseats(filas, id){
		var total_seats = $('#totalasientos'+id).val();
		var disponibles = $('#createseats'+id+' input:checked').length;
		var asientos_nodisponible = total_seats - disponibles;
		$('#total_nodisponibles'+id).val(asientos_nodisponible);
		$('#total_disponibles'+id).val(disponibles);
		var txt_seats = $('#seats'+id).val();
		var num_checks = $('.grid'+filas+'_'+id+' input:checked').length;
		if(num_checks < txt_seats){
			var add_seat = (num_checks + 1);
			$('#fl-'+filas+'_as-'+add_seat+'_cod-'+id).append('<input disabled type="checkbox" id="F-'+filas+'_A-'+add_seat+'_C-'+id+'" checked="checked" onclick="seatok('+filas+','+add_seat+','+id+')" />');
			$('#r'+filas+'_c'+add_seat+'_c'+id).remove();
			$('#file-'+filas+'_A-'+add_seat+'_C-'+id).css('display','none');
		}else if(num_checks == txt_seats){
			alert('No se puede añadir mas sillas, solo tienes '+txt_seats+' columnas');
			$('#add'+id+'_'+filas).css('display','none');
		}
	}
	
	function removeseats(filas, id){
		var total_seats = $('#totalasientos'+id).val();
		var disponibles = $('#createseats'+id+' input:checked').length;
		var asientos_nodisponible = total_seats - disponibles;
		$('#total_nodisponibles'+id).val(asientos_nodisponible);
		$('#total_disponibles'+id).val(disponibles);
		var num_seats = $('#seats'+id).val();
		var num_check = $('.grid'+filas+'_'+id+' input:checked').length;
		if(num_seats > num_check){
			$('#add'+id+'_'+filas).css('display','block');
			$('#F-'+filas+'_A-'+num_check+'_C-'+id).remove();
			$('#file-'+filas+'_A-'+num_check+'_C-'+id).css('display','block');
			$('#fl-'+filas+'_as-'+num_check+'_cod-'+id).append('<div style="display:none" class="cuadricula'+id+'" id="r'+filas+'_c'+num_check+'_c'+id+'">\
													<input disabled type="hidden" class="rows'+id+'" id="row'+filas+'_'+num_check+'_'+id+'" value="'+filas+'" />\
													<input disabled type="hidden" class="cols'+id+'" id="col'+filas+'_'+num_check+'_'+id+'" value="'+num_check+'" /></div>');
		}else if(num_seats == num_check){
			$('#add'+id+'_'+filas).css('display','block');
			$('#F-'+filas+'_A-'+num_seats+'_C-'+id).remove();
			$('#file-'+filas+'_A-'+num_seats+'_C-'+id).css('display','block');
			$('#fl-'+filas+'_as-'+num_seats+'_cod-'+id).append('<div style="display:none" class="cuadricula'+id+'" id="r'+filas+'_c'+num_seats+'_c'+id+'">\
													<input disabled type="hidden" class="rows'+id+'" id="row'+filas+'_'+num_seats+'_'+id+'" value="'+filas+'" />\
													<input disabled type="hidden" class="cols'+id+'" id="col'+filas+'_'+num_seats+'_'+id+'" value="'+num_seats+'" /></div>');
		}
	}
	
	function seatok(row, col, id){
		var num_cols = $('.grid'+row+'_'+id+' input:checked').length;
		$('#totalAsientos'+row+'-'+id).val(num_cols);
		var total_seats = $('#totalasientos'+id).val();
		var disponibles = $('#createseats'+id+' input:checked').length;
		var asientos_nodisponible = total_seats - disponibles;
		$('#total_nodisponibles'+id).val(asientos_nodisponible);
		$('#total_disponibles'+id).val(disponibles);
		if(($('#F-'+row+'_A-'+col+'_C-'+id).is(':checked'))){
			$('#r'+row+'_c'+col+'_c'+id).remove();
		}else{
			$('#fl-'+row+'_as-'+col+'_cod-'+id).append('<div style="display:none" class="cuadricula'+id+'" id="r'+row+'_c'+col+'_c'+id+'">\
													<input disabled type="hidden" class="rows'+id+'" id="row'+row+'_'+col+'_'+id+'" value="'+row+'" />\
													<input disabled type="hidden" class="cols'+id+'" id="col'+row+'_'+col+'_'+id+'" value="'+col+'" /></div>');
		}
	}
	
	function ColsXtext(fila, id, totalCols){
		var val_text = $('#totalAsientos'+fila+'-'+id).val();
		var num_cols = $('.grid'+fila+'_'+id+' input:checked').length;
		if(val_text > totalCols){
			alert('Solo tienes : '+totalCols);
			$('#totalAsientos'+fila+'-'+id).val(num_cols);
		}else{
			if(val_text < num_cols){
				val_text++;
				for(var i = val_text; i <= num_cols; i++){
					$('#F-'+fila+'_A-'+i+'_C-'+id).remove();
					$('#file-'+fila+'_A-'+i+'_C-'+id).css('display','block');
					$('#fl-'+fila+'_as-'+i+'_cod-'+id).append('<div style="display:none" class="cuadricula'+id+'" id="r'+fila+'_c'+i+'_c'+id+'">\
															<input disabled type="hidden" class="rows'+id+'" id="row'+fila+'_'+i+'_'+id+'" value="'+fila+'" />\
															<input disabled type="hidden" class="cols'+id+'" id="col'+fila+'_'+i+'_'+id+'" value="'+i+'" /></div>');
					var total_seats = $('#totalasientos'+id).val();
					var disponibles = $('#createseats'+id+' input:checked').length;
					var asientos_nodisponible = total_seats - disponibles;
					$('#total_nodisponibles'+id).val(asientos_nodisponible);
					$('#total_disponibles'+id).val(disponibles);
				}
			}else{
				num_cols++;
				for(var i = num_cols; i <= val_text; i++){
					$('#fl-'+fila+'_as-'+i+'_cod-'+id).append('<input disabled type="checkbox" id="F-'+fila+'_A-'+i+'_C-'+id+'" checked="checked" onclick="seatok('+fila+','+i+','+id+')" />');
					$('#r'+fila+'_c'+i+'_c'+id).remove();
					$('#file-'+fila+'_A-'+i+'_C-'+id).css('display','none');
					var total_seats = $('#totalasientos'+id).val();
					var disponibles = $('#createseats'+id+' input:checked').length;
					var asientos_nodisponible = total_seats - disponibles;
					$('#total_nodisponibles'+id).val(asientos_nodisponible);
					$('#total_disponibles'+id).val(disponibles);
				}
			}
		}
	}
	
	function saveall(local, concierto){
		var coordenadas = $('#coords'+local).val();
		var totalasientos = $('#totalasientos'+local).val();
		var secuencia = $('#secuencialNew'+local).val();
		var filas_new = $('#files'+local).val();
		var seats_new = $('#seats'+local).val();
		var obsModmapa = $('#obsModmapa').val();
		var valores_asientos = '';
		
		$('.cuadricula'+local).each(function(){
			var fila = $(this).find('.rows'+local).val();
			var columns = $(this).find('.cols'+local).val();
			valores_asientos += fila +'|'+ columns +'|'+'@';
		});
		var valores_asientos_F = valores_asientos.substring(0,valores_asientos.length -1);
		
		$.post('spadmin/actualizar_localidad.php',{
			local : local, concierto : concierto, coordenadas : coordenadas, totalasientos : totalasientos, secuencia : secuencia,
			filas_new : filas_new, seats_new : seats_new, obsModmapa : obsModmapa, valores_asientos : valores_asientos_F
		}).done(function(response){
			alert('Localidad modificada');
		});
		
		$('#createseats'+local).css('display','none');
		$('.mostrarEdit').fadeOut(600);
		$('#openthismap'+local).css('display','none');
		$('.ocultarEdit').css({opacity:1.0});
	}
	
	function cancelall(id){
		var TA = $('#bdtotalAsientos'+id).val();
		var filas = $('#bdFiles'+id).val();
		var asiento = $('#bdSeats'+id).val();
		$('.mostrarEdit').fadeOut(300);
		$('#openthismap'+id).css('display','none');
		$('.ocultarEdit').css({opacity:1.0});
		$('#totalasientos'+id).attr('readonly','readonly');
		$('#totalasientos'+id).val(TA);
		$('#files'+id).attr('readonly','readonly');
		$('#files'+id).val(filas);
		$('#seats'+id).attr('readonly','readonly');
		$('#seats'+id).val(asiento);
		if($('.table_bd'+id).length){
			$('.table_bd'+id).remove();
		}else if($('.filas'+id).length){
			$('.filas'+id).remove();
		}
		$('#secuencialNew'+id).css('display','none');
		$('#secuencial'+id).css('display','block');
	}
	
	function closemap(id){
		$('#createseats'+id).css('display','none');
		$('.mostrarEdit').fadeOut(600);
		$('#openthismap'+id).css('display','none');
		$('.ocultarEdit').css({opacity:1.0});
	}
	
	
	
	$(function(){
		$('.container').css('width','1180px')
		$('.body').css('width','1150px')
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
			}
		});
		
		
		
		var btnUpload=$('#upload1');
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
				document.getElementById('mapaCon').value=mirsp;
				document.getElementById('fotoCon').src='spadmin/'+mirsp;
			}
		});
		
		
		
		var btnUpload=$('#upload2');
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
				document.getElementById('mapaOpC').value=mirsp;
				document.getElementById('fotoOpC').src='spadmin/'+mirsp;
			}
		});
	});
	
	function op(){
		var o = window.open('tutorial.php','ventana1','width=800px, height=600px');
	}
	
	function justInt(e,value){
		if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46)){
			return;
		}
		else{
			e.preventDefault();
		}
	}
function guardarcomisionventalinea(idcon){
    var porcpaypal = $('#porccomisionpaypal').val();
    var valpaypal = $('#valcomisionpaypaypal').val();
    var porcstripe = $('#porccomisionstripe').val();
    var valstripe = $('#valcomisionpaystripe').val();

        console.log(idcon);
		$('#guardarcomisionventalinea').attr('disabled',true);
		
        $.post("spadmin/apinew.php",{
            que: 1 , id : idcon , porcpaypal : porcpaypal , valpaypal : valpaypal , porcstripe : porcstripe , valstripe : valstripe
        }).done(function(data){
            alert(data);
            location.reload();
        });

}
</script>