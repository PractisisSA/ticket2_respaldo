<?php 
	include("controlusuarios/seguridadDis.php");
	
	echo '<input type="hidden" id="data" value="1" />';
	$nombre = $_SESSION['useractual'];
	$idDis = $_SESSION['idDis'];
	
	$gbd = new DBConn();
	
	require_once('distribuidor/eventos/ajax/ajaxconciertodes.php');
?>
<style>
	.secciones{
		background-color:#f8e316; 
		color:#000; 
		font-size:45px; 
		display:inline-block; 
		height:100px;
		opacity:0.9; 
		border:1px solid #000; 
		cursor:pointer;
	}
	.secciones:hover{
		background-color:#67cdf5;
	}
</style>
<script src="distribuidor/eventos/js/ajaxconciertodes.js"></script>
<div style="background-color:#171A1B; border: 2px solid #00AEEF; margin:20px 20px 10px;">
	<div id="ocultar">
		<h3 style="color:#fff; text-align:center;" id="titulo1">Escoge tu localidad en el "MAPA" o en la "Tabla de PRECIOS"</h3>
		<div style="background-color:#00AEEF; margin:0px -32px 50px 0px; position:relative;">
			<?php if($resultadoPreventa > 0){?>
			<div class="row">
				<div class="col-lg-7" style="margin:0px;">
					<?php
						$dir = 'spadmin/';
						$imagen = $row['strMapaC'];
						$ruta_mapa = $dir.$imagen;
					?>
					<img id="localmapa" src="<?php echo $ruta_mapa?>" alt="localmapa" usemap="#localmapa" style="width: 550px; height: 415px; position: absolute; left: 0px; top:0px; padding: 0; opacity: 0.0;" />
					<map name="localmapa">
						<?php while($rowArea = $resultSelectAreas -> fetch(PDO::FETCH_ASSOC)){?>
							<area href="#" data-state="<?php echo $rowArea['datestateL'];?>" data-full="<?php echo $rowArea['datafullL'];?>" shape="poly" coords="<?php echo $rowArea['strCoordenadasB'];?>" onclick="asientos_mapa('<?php echo $rowArea['intLocalB'];?>','<?php echo $rowArea['intConcB'];?>')" alt />
						<?php }?>
					</map>
				</div>
				<div class="col-lg-5" style="color:#fff; margin:10% 0px 0px;">
					<div class="row">
						<?php if($resultadoPreventa > 0){?>
						<h4><strong>Tiempo limite de compra por PREVENTA:</strong></h4>
						<div id="clock2"></div>
						<?php }?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-7" style="margin:0px; padding:20px 5px 40px 10px;">
					<input type="hidden" id="concierto" name="concierto" value="<?php echo $idcon;?>" />
					<div class="row">
						<div class="col-xs-12" style="margin:0px; text-align:center; border:1px solid #fff">
							<font size="5"><p style="margin-top:15px; color:#fff;"><strong>LOCALIDADES</strong></p></font>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12" style="margin:0px; text-align:center; border:1px solid #fff; color:#fff;">
							<span><strong>PRECIOS</strong></span>
						</div>
					</div>
					<div class="row" style="color:#fff;">
						<div class="<?php echo $colst;?>" style="margin:0px; border:1px solid #fff">
							<div class="row">
								<div class="col-xs-11">
									<strong>Tipo</strong>
								</div>
							</div>
							<?php while($row5 = $sltdeslocal -> fetch(PDO::FETCH_ASSOC)){?>
							<div class="row">
								<div class="col-xs-11">
									<?php echo $row5['strDescripcionL'];?>
									<input type="hidden" id="local<?php echo $row5['idLocalidad'];?>" value="<?php  echo $row5['strDescripcionL'];?>" />
								</div>
							</div>
							<?php }?>
						</div>
						<div class="<?php echo $colsn;?>" style="margin:0px; border:1px solid #fff">
							<div class="row">
								<div class="col-xs-11">
									<strong>$Normal</strong>
								</div>
							</div>
							<?php while($row1 = $sltprecio -> fetch(PDO::FETCH_ASSOC)){?>
							<div class="row">
								<div class="col-xs-11">
									<?php echo $row1['doublePrecioL'];?>
								</div>
							</div>
							<?php }?>
						</div>
						<?php if($resultadoPreventa > 1){?>
						<div class="<?php echo $colsp;?>" style="margin:0px; border:1px solid #fff">
							<div class="row">
								<div class="col-xs-11">
									<strong>$Preventa</strong>
								</div>
							</div>
							<?php while($row3 = $sltpreventa -> fetch(PDO::FETCH_ASSOC)){?>
							<div class="row">
								<div class="col-xs-11">
									<?php echo $row3['doublePrecioPreventa'];?>
								</div>
							</div>
							<?php }?>
						</div>
						<?php }?>
						<div class="<?php echo $colsm;?>" style="margin:0px; border:1px solid #fff; text-align:center;">
							<div class="row">
								<div class="col-xs-11" style="margin-left:2px;">
									<strong>Mapa</strong>
								</div>
							</div>
							<?php while($row4 = $sltidlocal -> fetch(PDO::FETCH_ASSOC)){?>
							<div class="row">
								<div class="col-xs-11" style="margin-left:2px;">
									<span class="label label-success" style="cursor:pointer;" onclick="asientos_mapa('<?php echo $row4['idLocalidad'];?>','<?php echo $idcon;?>');">Mapa</span>
								</div>
							</div>
							<?php }?>
						</div>
					</div>
				</div>
				<div class="col-lg-5" style="margin:0px;">
					<p>
						<div style="border: 1px solid #fff; margin:20px 100px 20px 10px; padding:15px 0px 2px 8px;">
							<font color="#fff" size="6"><p style="vertical-align:middle"><strong><?php echo $row["strEvento"];?></strong></p></font>
						</div>
					</p>
					<p>
						<div style="background-color:#171A1B; margin:0px 100px 20px 10px; padding:10px 0px 10px 10px; color:#fff; font-weight:700;">
							<span>Fecha: <?php echo $row["dateFecha"];?></span><br>
							<span>Hora: <?php echo $row["timeHora"];?></span><br>
							<span>Lugar: <?php echo $row["strLugar"];?></span>
						</div>
					</p>
					<p>
						<div style="padding-left:15px; padding-right:100px; color:#fff; margin-bottom:20px; letter-spacing:0.5px;">
							<?php echo $row["strDescripcion"];?>
						</div>
					</p>
				</div>
			</div>
			<?php }else{?>
			<div class="row">
				<div class="col-lg-7" style="margin:0px;">
					<?php
						$dir = 'spadmin/';
						$imagen = $row['strMapaC'];
						$ruta_mapa = $dir.$imagen;
					?>
					<img id="localmapa" src="<?php echo $ruta_mapa?>" alt="localmapa" usemap="#localmapa" style="width: 550px; height: 415px; position: absolute; left: 0px; top:0px; padding: 0; opacity: 0.0;" />
					<map name="localmapa">
						<?php while($rowArea = $resultSelectAreas -> fetch(PDO::FETCH_ASSOC)){?>
							<area href="#" data-state="<?php echo $rowArea['datestateL'];?>" data-full="<?php echo $rowArea['datafullL'];?>" shape="poly" coords="<?php echo $rowArea['strCoordenadasB'];?>" onclick="asientos_mapa('<?php echo $rowArea['intLocalB'];?>','<?php echo $rowArea['intConcB'];?>')" alt />
						<?php }?>
					</map>
				</div>
				<div class="col-lg-5" style="margin:0px;">
					<p>
						<div style="border: 1px solid #fff; margin:20px 100px 20px 10px; padding:15px 0px 2px 8px;">
							<font color="#fff" size="6"><p style="vertical-align:middle"><strong><?php echo $row["strEvento"];?></strong></p></font>
						</div>
					</p>
					<p>
						<div style="background-color:#171A1B; margin:0px 100px 20px 10px; padding:10px 0px 10px 10px; color:#fff; font-weight:700;">
							<span>Fecha: <?php echo $row["dateFecha"];?></span><br>
							<span>Hora: <?php echo $row["timeHora"];?></span><br>
							<span>Lugar: <?php echo $row["strLugar"];?></span>
						</div>
					</p>
					<p>
						<div style="padding-left:15px; padding-right:100px; color:#fff; margin-bottom:20px; letter-spacing:0.5px;">
							<?php echo $row["strDescripcion"];?>
						</div>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12" style="margin:0px; padding:20px 150px 40px;">
					<input type="hidden" id="concierto" name="concierto" value="<?php echo $idcon;?>" />
					<div class="row">
						<div class="col-xs-12" style="margin:0px; text-align:center; border:1px solid #fff">
							<font size="5"><p style="margin-top:15px; color:#fff;"><strong>LOCALIDADES</strong></p></font>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12" style="margin:0px; text-align:center; border:1px solid #fff; color:#fff;">
							<span><strong>PRECIOS</strong></span>
						</div>
					</div>
					<div class="row" style="color:#fff;">
						<div class="<?php echo $colst;?>" style="margin:0px; border:1px solid #fff">
							<div class="row">
								<div class="col-xs-11" style="text-align:center;">
									<strong>Tipo</strong>
								</div>
							</div>
							<?php while($row5 = $sltdeslocal -> fetch(PDO::FETCH_ASSOC)){?>
							<div class="row">
								<div class="col-xs-11">
									<?php echo $row5['strDescripcionL'];?>
									<input type="hidden" id="local<?php echo $row5['idLocalidad'];?>" value="<?php  echo $row5['strDescripcionL'];?>" />
								</div>
							</div>
							<?php }?>
						</div>
						<div class="<?php echo $colsn;?>" style="margin:0px; border:1px solid #fff">
							<div class="row">
								<div class="col-xs-11" style="text-align:center;">
									<strong>$Normal</strong>
								</div>
							</div>
							<?php while($row1 = $sltprecio -> fetch(PDO::FETCH_ASSOC)){?>
							<div class="row">
								<div class="col-xs-11">
									<?php echo $row1['doublePrecioL'];?>
								</div>
							</div>
							<?php }?>
						</div>
						<?php if($resultadoPreventa > 1){?>
						<div class="<?php echo $colsp;?>" style="margin:0px; border:1px solid #fff">
							<div class="row">
								<div class="col-xs-11" style="text-align:center;">
									<strong>$Preventa</strong>
								</div>
							</div>
							<?php while($row3 = $sltpreventa -> fetch(PDO::FETCH_ASSOC)){?>
							<div class="row">
								<div class="col-xs-11">
									<?php echo $row3['doublePrecioPreventa'];?>
								</div>
							</div>
							<?php }?>
						</div>
						<?php }?>
						<div class="<?php echo $colsm;?>" style="margin:0px; border:1px solid #fff; text-align:center;">
							<div class="row">
								<div class="col-xs-11" style="margin-left:2px;">
									<strong>Mapa</strong>
								</div>
							</div>
							<?php while($row4 = $sltidlocal -> fetch(PDO::FETCH_ASSOC)){?>
							<div class="row">
								<div class="col-xs-11" style="margin-left:2px;">
									<span class="label label-success" style="cursor:pointer;" onclick="asientos_mapa('<?php echo $row4['idLocalidad'];?>','<?php echo $idcon;?>');">Mapa</span>
								</div>
							</div>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<?php }?>
			<div class="tra_info_concierto"></div>
			<div class="par_info_concierto"></div>
		</div>
		<div style="background-color:#00AEEF; margin:20px 30px 20px -32px; position: relative;">
			<div class="row">
				<div class="col-lg-6">
					<div style="margin:10px 10px 10px 60px;">
						<iframe class="video" style="max-height:250px; height:250px; min-height:75px;" width="100%" src="<?php echo $row["strVideoC"];?>"></iframe>
					</div>
				</div>
				<div class="col-lg-5" style="margin-top:5%;">
					<img src="<?php echo $r; ?>" style="width:100%; overflow:hidden;"/>
				</div>
			</div>
			<div class="tra_video_concierto"></div>
			<div class="par_video_concierto"></div>
		</div>
		<div style="background-color:#515557; margin:20px; height:3px;"></div>
		<div class="row">
			<div class="col-lg-6" style="background-color:#00AEEF; padding-left:20px; color:#fff; font-size:22px;">
				<span><strong>Redes Sociales de los Artistas</strong></font></span>
			</div>
		</div>
		<div class="row">
			<?php while($rowart = $resart -> fetch(PDO::FETCH_ASSOC)){?>
				<div class="col-xs-3" style="margin:-10px 0 0 40px;">
					<h3 style="color:#fff;"><strong><?php echo $rowart['strNombreA'];?></strong></h3>
				</div>
				<div class="col-xs-1">
					<a href="<?php echo $rowart['strFacebookA'];?>"><img src="imagenes/face.jpg" style="width:100%; max-width:50px;" /></a>
				</div>
				<div class="col-xs-1">
					<a href="<?php echo $rowart['strTwitterA'];?>"><img src="imagenes/twitter.jpg" style="width:100%; max-width:50px;" /></a>
				</div>
				<div class="col-xs-1">
					<a href="<?php echo $rowart['strYoutubeA'];?>"><img src="imagenes/youtube.jpg" style="width:100%; max-width:50px;" /></a>
				</div>
				<div class="col-xs-1">
					<a href="<?php echo $rowart['strInstagramA'];?>"><img src="imagenes/instagram.jpg" style="width:100%; max-width:50px;" /></a>
				</div>
			<?php }?>
		</div>
		<div style="background-color:#515557; margin:20px; height:3px;"></div>
	</div>
	<div id="mostrar_mapa">
		<div class="row">
			<div class="col-lg-3" style="text-align:center;">
				<img src="<?php echo $ruta_mapa;?>" style="max-width:250px;" />
			</div>
			<div class="col-lg-7" style="text-align:center;">
				<h2 id="nombrelocaldiad" style="color:#fff;"></h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12" style="padding-right:30px;">
				<h4 class="pull-right"><strong>PRIMER PASO: </strong>Escoge la sección que deseas</h4>
			</div>
		</div>
		<div style="background-color:#272b2a; border:1px solid #00aeef; margin:0 125px; padding:60px 0; position:relative;">
			<h4 style="text-align:center; color:#fff; margin-top:-20px; margin-bottom:40px;"><span style="border:1px solid #00aeef; padding:10px;"><strong>ESCENARIO</strong></span></h4>
			<?php while($rowId = $resultId -> fetch(PDO::FETCH_ASSOC)){
				$idbtnloc = $rowId['idLocalidad'];
				$img = $rowId['strImgL'];
				$dir = 'spadmin/';
				$ruta_img_local = $dir.$img; 
			?>
			<div id="img_localidad<?php echo $idbtnloc;?>" style="margin: 0 auto; width: 100%; display: none;">
				<center>
					<div id="divisiones_mapa<?php echo $idbtnloc;?>" style="width:500px; height:100px; background-image:url(<?php echo $ruta_img_local;?>); background-repeat:no-repeat; background-size:500px 100px;"></div>
				</center>
				<input type="hidden" id="limite_columnas<?php echo $idbtnloc;?>" value="<?php echo $rowId['intAsientosB'];?>" />
				<input type="hidden" id="secuencial<?php echo $idbtnloc?>" value="<?php echo $rowId['strSecuencial'];?>" />
			</div>
			<?php }?>
			<h4 style="text-align:center; color:#fff; font-size:14px;">SECCION(ES)</h4>
			<div style="position:absolute; right:-100px; top:40%;">
				<img src="imagenes/arrowcontinuo.png" id="arrow1" style="display:none;" class="arrow"/>
				<img src="imagenes/arrowcontinuo.png" id="arrow2" style="display:none;" class="arrow"/>
				<img src="imagenes/arrowcontinuo.png" id="arrow3" style="display:none;" class="arrow"/>
				<img src="imagenes/arrowcontinuo.png" id="arrow4" style="display:none;" class="arrow"/>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12" style="text-align:center;">
				<h4 id="nombreseccion"></h4>
			</div>
		</div>
		<div id="segundopaso" style="display:none;">
			<div class="row">
				<div class="col-lg-12">
					<h4><strong>SEGUNDO PASO: </strong>Escoge tu(s) asiento(s)</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2">
					<div style="width:30px; height:30px; background-color:#67cdf5;"></div>
					<span style="margin-left:40px;">Tu Asiento</span>
				</div>
				<div class="col-xs-2">
					<div style="width:30px; height:30px; background-color:#ffffff;"></div>
					<span style="margin-left:40px;">Asientos Disponibles</span>
				</div>
				<div class="col-xs-2">
					<div style="width:30px; height:30px; background-color:#fbed2c;"></div>
					<span style="margin-left:40px;">Asientos Reservados</span>
				</div>
				<div class="col-xs-2">
					<div style="width:30px; height:30px; background-color:red;"></div>
					<span style="margin-left:40px;">Asientos Ocupados</span>
				</div>
				<div class="col-xs-2">
					<div style="width:30px; height:30px; background-color:#000;"></div>
					<span style="margin-left:40px;">Asientos no Disponibles</span>
				</div>
			</div>
			<?php while($row6 = $stmt6 -> fetch(PDO::FETCH_ASSOC)){?>
			<div class="row" id="detallesillas<?php echo $row6['idLocalidad'];?>" style="display:none;">
				<div class="col-lg-6" style="text-align:center;">
					<h4 style="color:#67cdf5;"><strong><span id="numboletos<?php echo $row6['idLocalidad'];?>">0</span></strong> Boleto(s) seleccionados</h4>
				</div>
				<div class="col-lg-5" style="text-align:center;">
					<h4 style="color:#67cdf5;" id="descripcionsilla<?php echo $row6['idLocalidad'];?>"></h4>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<h4 style="color:#fff; text-align:center;"><span style="border:1px solid #00aeef; padding:10px;"><strong>ESCENARIO</strong></span></h4>
					</div>
				</div>
			</div>
			<?php }?>
			<div class="row">
				<div class="col-lg-12" style="text-align:center;">
					<img src="imagenes/loading.gif" id="wait" style="display:none; max-width:80px;" />
				</div>
			</div>
			<div class="row" style="overflow:auto; text-align:center;">
				<div id="localidad_butaca">
					
				</div>
			</div>
		</div>
		<?php while($row7 = $stmt7 -> fetch(PDO::FETCH_ASSOC)){?>
		<div class="row" id="botones<?php echo $row7['idLocalidad'];?>" style="display:none;">
			<div class="col-lg-6" style="text-align:right;">
				<button class="btnceleste" onclick="save_local('<?php echo $row7['idLocalidad'];?>','<?php echo $idcon;?>')">Guardar Selección</button>
			</div>
			<div class="col-lg-5">
				<button class="btnceleste" onclick="cancel_local('<?php echo $row7['idLocalidad'];?>','<?php echo $idcon;?>')">Cancelar Selección</button>
			</div>
		</div>
		<?php }?>
	</div>
	<form id="form" action="" method="post">
		<div id="ocultar_mapa">
			<div style="margin:20px">
				<table id="seleccion" align="center" class="table-responsive" style="width:100%; color:#fff; border-collapse: separate; border-spacing:0 10px;">
					<tr style="background-color:#00ADEF">
						<td style="text-align:center; border-right:1px solid #fff; padding:5px;">
							<strong>C&oacute;digo de Compra</strong>
						</td>
						<td style="text-align:center; border-right:1px solid #fff;">
							<strong>Asiento #</strong>
						</td>
						<td style="text-align:center; border-right:1px solid #fff;">
							<strong>Descripci&oacute;n</strong>
						</td>
						<td style="text-align:center; border-right:1px solid #fff;">
							<strong># de Boletos</strong>
						</td>
						<td style="text-align:center; border-right:1px solid #fff;">
							<strong>Valor Unitario</strong>
						</td>
						<td style="text-align:center; border-right:1px solid #fff;">
							<strong>Valor Total</strong>
						</td>
						<td style="text-align:center">
							<strong>Eliminar</strong>
						</td>
					</tr>
				</table>
			</div>
			<div style="height:auto; background-color:#EC1867; margin:50px -32px 10px 40%; padding-right:30px; color:#fff; font-size:18px; position:relative;">
				<div class="row">
					<div class="col-lg-5">
						<button type="button" id="aleatorio" class="btn_compra_online" style="margin-left:50px;" onclick="$('#asientosaleatorio').modal('show');"><img src="imagenes/mano_comprar.png" style="margin-left:-20px;"/><strong>+ Aleatorio</strong></button>
					</div>
					<div class="col-lg-5">
						<button type="button" id="ok" class="btn_compra_online" style="margin-left:50px;"><img src="imagenes/mano_comprar.png" style="margin-left:-20px;"/><strong>+ Continuar</strong></button>
					</div>
				</div>
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
		</div>
		<div id="tabla_aleatorios" style="display:none;"></div>
	</form>
	<div class="modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
				</div>
				<div class="modal-body">
					<h4><div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;&nbsp;<strong>Error...!</strong>&nbsp;Debe seleccionar asientos primero.</div></h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="asientosaleatorio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cancelar_ale()"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Selección de Asientos!</h4>
				</div>
				<div class="modal-body">
					<div id="choose_local">
						<div class="row">
							<div class="col-md-12" style="text-align:center;">
								<h3>Escoge la Localidad</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-5">
								<?php while($rowaleatorias = $ale -> fetch(PDO::FETCH_ASSOC)){?>
								<h3><span class="label label-info form-control">
										<label for="loc_ale<?php echo $rowaleatorias['idLocalidad'];?>" onclick="selectlocalale('<?php echo $rowaleatorias['idLocalidad'];?>')">
											<input type="radio" class="loc_ale" name="locales_ale" id="loc_ale<?php echo $rowaleatorias['idLocalidad'];?>" onclick="selectlocalale('<?php echo $rowaleatorias['idLocalidad'];?>')" value="<?php echo $rowaleatorias['idLocalidad'];?>" />
											&nbsp;<?php echo $rowaleatorias['strDescripcionL'];?>
										</label>
									</span>
								</h3>
								<?php }?>
								<input type="hidden" id="idLocalale" value="" />
							</div>
						</div>
					</div>
					<div id="choose_num_bol" style="display:none;">
						<div class="row">
							<div class="col-md-12" style="text-align:center; position:relative;">
								<h3>Número de Ticket's</h3>
								<div style="position:absolute; right:0px; top:-15px;">
									<button type="button" class="btn btn-warning" onclick="$('#choose_num_bol').fadeOut('slow'); $('#choose_local').delay(600).fadeIn('slow');">Regresar</button>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<select class="form-control" id="num_boletos_ale" onchange="select_boletos_ale()">
									<option value="0">Seleccione...</option>
									<?php for($i = 1; $i <= 10; $i++){?>
									<option value="<?php echo $i;?>"><?php echo $i;?></option>
									<?php }?>
									<option value="mas">Más...</option>
								</select>
								<div class="input-group"  style="display:none;" id="mas_bol_num_div">
									<input type="text" class="form-control" id="mas_bol_num" aria-describedby="basic-addon2">
									<span class="input-group-addon" id="basic-addon2" onclick="cancelar_mas_num()" style="cursor:pointer;">
										<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12" style="text-align:center;">
								<button type="button" class="btn btn-info btn-lg" onclick="select_asientos_ale()" id="buscarale">
									<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
									&nbsp;Buscar
								</button>
								<img src="imagenes/loading.gif" style="max-width:80px; display:none;" id="waitale" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-12" id="asientos_ale" style="text-align:center;">
								
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="cancelar_ale()">Cancelar</button>
					<button type="button" class="btn btn-primary" style="display:none;" id="aceptaraleatorios">Aceptar</button>
				</div>
			</div>
		</div>
	</div>
</div>