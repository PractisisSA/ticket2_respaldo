<?php 
	//include("controlusuarios/seguridadSA.php");
	
	$gbd = new DBConn();
	
	$id_concierto = $_GET['con'];
	
	$selectMapa = 'SELECT idLocalidad, strCapacidadL, strMapaC FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto WHERE idConc = "'.$id_concierto.'" AND strEstadoMapaL = "no"';
	echo $selectMapa;
	$resSelectMapa = $gbd -> prepare($selectMapa);
	$resSelectMapa -> execute();
	
	$selectLocalidad = "SELECT * FROM Localidad WHERE idConc = ? AND strEstadoMapaL = ?";
	$resSelectLocalidad = $gbd -> prepare($selectLocalidad);
	$resSelectLocalidad -> execute(array($id_concierto ,'No'));
	
	$selectNom ="SELECT strEvento FROM Concierto WHERE idConcierto = ?";
	$resSelectNom = $gbd -> prepare($selectNom);
	$resSelectNom -> execute(array($id_concierto));
	$rowNom = $resSelectNom -> fetch(PDO::FETCH_ASSOC);
	$nombre_evento = $rowNom['strEvento'];
	echo '<input type="hidden" id="data" value="2" />';
?>
<!--<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />-->
<link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/>
<script src="js/jquery.datetimepicker.js"></script>
<script language="javascript" src="spadmin/jquery.canvasAreaDraw.js"></script>
<style>
	#mapas{
		width:1200px; 
		min-height:500px; 
		position:relative; 
		left:50%; 
		top:50%; 
		margin-left:-610px; 
		margin-top:-220px; 
		z-index:1; 
		border:10px solid #fff; 
		border-radius:5px; 
		-moz-border-radius:5px; 
		-o-border-radius:5px; 
		-webkit-border-radius:5px;
		display:none;
		background-image: url(http://subtlepatterns.com/patterns/debut_light.png);
	}
	#info{
		width:100%; 
		min-height:100%; 
		position:relative; 
		left:0px; 
		top:0px; 
		z-index:0;
	}
	#close{ 
		width:50px; 
		height:50px; 
		position:absolute; 
		top:-18px; 
		right:-22px; 
		color:#FFF; 
		z-index:2;
	}
	.data_map{
		width: 100%;
		max-width: 1160px;
		border: 2px solid #000;
		border-collapse: collapse;
	}
</style>
<div style="margin: 0px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 50% 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
				<strong>Creaci&oacute;n de las áreas del mapa</strong>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:22px;">
				<strong>Paso #2</strong>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="margin:40px; text-align:center; border:2px solid #00ADEF; text-align:center;">
				<div id="info">
					<table class="table_info" style="color:#fff; font-size:18px; border-collapse:separate; border-spacing:15px 10px; width:100%;">
						<tr>
							<td style="text-align:center" colspan="4">
								<strong>Localidades del Concierto: &nbsp;&nbsp;<font size="4"><I>"<?php echo $nombre_evento;?>"</I></font></strong>
							</td>
						</tr>
						<tr>
							<td style="text-align:center">
								<strong>Descripci&oacute;n</strong>
							</td>
							<td style="text-align:center">
								<strong>Cantidad de Boletos</strong>
							</td>
							<td style="text-align:center">
								<strong>Caracter&iacute;stica</strong>
							</td>
							<td style="text-align:center">
								<strong>Crear &Aacute;reas</strong>
							</td>
						</tr>
						<input type="hidden" id="idCon" value="<?php echo $id_concierto;?>" />
						<?php while($rowLocalidad = $resSelectLocalidad -> fetch(PDO::FETCH_ASSOC)){?>
						<tr class="filas_local">
							<td style="text-align:center">
								<?php echo $rowLocalidad['strDescripcionL'];?>
								<input type="hidden" id="datafull<?php echo $rowLocalidad['idLocalidad'];?>" value="<?php echo $rowLocalidad['strDescripcionL'];?>" />
								<input type="hidden" id="datestate<?php echo $rowLocalidad['idLocalidad'];?>" value="<?php echo $rowLocalidad['strDateStateL'];?>" />
							</td>
							<td style="text-align:center">
								<?php echo $rowLocalidad['strCapacidadL'];?>
								<input type="hidden" id="cantidad<?php echo $rowLocalidad['idLocalidad'];?>" value="<?php echo $rowLocalidad['strCapacidadL'];?>" />
							</td>
							<td style="text-align:center">
								<?php echo $rowLocalidad['strCaracteristicaL'];?>
							</td>
							<td align="center">
								<button type="button" class="btnlink" id="crear" onclick="openmap('<?php echo $rowLocalidad['idLocalidad'];?>')" ><strong>Crear</strong></button>
							</td>
						</tr>
						<?php }?>
					</table>
				</div>
				<div id="mapas">
					<?php while($rowMapa = $resSelectMapa -> fetch(PDO::FETCH_ASSOC)){
						$idLoc = $rowMapa['idLocalidad'];	
					?>
					<div id="mapa<?php echo $idLoc;?>" style="display:none">
					<div id="close" onclick="closemap(<?php echo $idLoc;?>)"><img src="imagenes/close.png" alt="DDOX"/></div>
						<table align="center" class="data_map">
							<tr>
								<td colspan="3" style="vertical-align: middle; text-align: center;">
									<font size="5"><strong>Selecciona el &aacute;rea de la Localidad</strong></font>
								</td>
							</tr>
							<tr>
								<td colspan="3" style="text-align:center">
									<div class="container">
										<form>
											<div class="row">
												<div class="span6" style="cursor:pointer; cursor:hand;">
													<textarea rows="2" id="coords<?php echo $idLoc;?>" class="canvas-area input-xxlarge" readonly="readonly" placeholder="Coordenadas" data-image-url="spadmin/<?php echo $rowMapa['strMapaC'];?>" ></textarea>
												</div>
											</div>
										</form>
									</div>
								</td>
							</tr>
						</table>
						<br>
						<table align="center" class="data_map">
							<tr>
								<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
									<strong>Secuencial de las Filas</strong>
								</td>
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
								<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
									<select id="secuencial<?php echo $idLoc?>">
										<option value="0">Num&eacute;rico</option>
										<option value="1">Alfab&eacute;tico</option>
									</select>
								</td>
								<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
									<input type="text" id="totalseats<?php echo $idLoc?>" size="5" onkeydown="justInt(event,this);"  value="<?php echo $rowMapa['strCapacidadL'];?>" />
								</td>
								<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
									<input type="text" id="files<?php echo $idLoc;?>" size="5" onkeydown="justInt(event,this);" maxlength="2" />
								</td>
								<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
									<input type="text" id="seats<?php echo $idLoc;?>" size="5" onkeydown="justInt(event,this);" maxlength="3" />
								</td>
								<td style="text-align:center; border-right:#c0c0c0 solid 2px;" rowspan="2">
									<!--<button type="button" class="btnlink" id="creategrid" onclick="addGrid('<?php echo $idLoc;?>')"><strong>Crear Cuadr&iacute;cula</strong></button>-->
									<button type="button" class="btnlink" id="creategrid" onclick="addGrid_2('<?php echo $idLoc;?>' , '<?php echo $_REQUEST['con'];?>')"><strong>Crear Cuadr&iacute;cula</strong></button>
								</td>
							</tr>
							<tr>
								<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
									<strong>Asientos Disponibles:</strong><center><div style="width:15px; height:15px; background-color: #fff; border: #000 solid 1px;"></div></center>
								</td>
								<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
									<input type="text" id="total_disponibles<?php echo $idLoc;?>" readonly="readonly" size="5" />
								</td>
								<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
									<strong>Asientos No Disponibles:</strong><center><div style="width:15px; height:15px; background-color: #000; border: #000 solid 1px;"></div></center>
								</td>
								<td style="text-align:center; border-right:#c0c0c0 solid 2px;">
									<input type="text" id="total_nodisponibles<?php echo $idLoc;?>" readonly="readonly" size="5" />
								</td>
							</tr>
							<tr>
								<td style="text-align:center" colspan="5">
									<div style="width:1180px; overflow: auto; margin: 0 auto;">
										<table id="createseats<?php echo $idLoc;?>" align="center">
											
										</table>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="5" align="center">
									<!--<button type="button" class="btndegradate" id="saveAll" onclick="saveall('<?php echo $idLoc;?>')" ><strong>GUARDAR GR&Aacute;FICA</strong></button>-->
								</td>
							</tr>
						</table>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>
	<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ver_cuadricula_localidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" >
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()"><span aria-hidden="true">&times;</span></button>
					<div class="alert alert-info" role="alert">
						<div class = 'row'>
							<div class = 'col-md-1' style = 'text-align:left;'>
								<i class="fa fa-chevron-left izquierda fa-2x" aria-hidden="true" title = 'desplazar cuadricula a la izquierda' style = 'cursor:pointer;'></i>
							</div>
							<div class = 'col-lg-9'>
								<h2>contenedor cuadricula</h2>
							</div>
							<div class = 'col-md-1' style = 'text-align:right;'>
								<i class="fa fa-chevron-right derecha fa-2x" aria-hidden="true" title = 'desplazar cuadricula a la derecha' style = 'cursor:pointer;'></i>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-body recibeCuadricula" id = 'recibeCuadricula'>
				</div>
				<div class="modal-footer"  >
					
				</div>
			</div>
		</div>
	</div>
<script>
	function addGrid_2(id_loc,idcon){
		// alert(id_loc + ' << >> ' + idcon);
		var id = id_loc;
		var filas = $('#files'+id).val();
		var asientos = $('#seats'+id).val();
		var total_seats = $('#totalseats'+id_loc).val();
		var total_crear = (parseInt(filas) * parseInt(asientos));
		
		var cordenadas = $('#coords'+id).val();
		
		var secuencial_slt = $('#secuencial'+id).val();
		var data_full = $('#datafull'+id).val();
		var date_state = $('#datestate'+id).val();
		var valores_asientos = '';
		var concierto = idcon;
		
		if(filas == ''){
			alert('debe ingresar el numero de filas');
		}
		
		if(asientos == ''){
			alert('debe ingresar el numero de columnas');
		}
		
		if(filas == '' || asientos == ''){
			
		}else{
			if(total_crear < total_seats){
				alert('no puede crear una cuadricula MENOR a : ' + total_seats + '\n ');
			}else if(total_crear > total_seats){
				alert('no puede crear una cuadricula MAYOR a : ' + total_seats + '\n ');
			}else{
				alert('asientos pre cargados : ' + total_seats + ' asientos a crear : ' + total_crear);
				
				$.post('spadmin/creacionmapaok_2.php',{
					id : id, date_state : date_state, data_full : data_full, concierto : concierto, cordenadas : cordenadas, 
					filas : filas, asientos : asientos, secuencial_slt : secuencial_slt, total_seats : total_seats
				}).done(function(data){
					alert('Se ha guardado con exito');
					ver_cuadricula_localidad(id_loc,idcon);
				});
			}
		}
			
	}
	
	function ver_cuadricula_localidad(id_loc,idcon){
		$('#ver_cuadricula_localidad').modal('show');
		$('#recibeCuadricula').html('<center><h1>Espere, Cargando informacion</h1></center>');
		$.post("spadmin/pruebas_sillas.php",{ 
			id_loc : id_loc , idcon : idcon
		}).done(function(data){
			$('#recibeCuadricula').css('max-height','400px');		
			$('#recibeCuadricula').css('overflow','scroll');		
			$('#recibeCuadricula').html(data);		
		});
		
	}
$(document).ready(function(){
	if($('.filas_local').length){
		var num_filas = $('.filas_local').length;
		alert('Tienes '+num_filas+' areas por crear');
	}else{
		alert('Terminaste de crear las areas de este concierto');
		window.location.href = '?modulo=listaConciertos';
	}
});

function openmap(id){
	$('#info').css({opacity:0.1});
	$('#info').fadeIn(300);
	$('#mapas').fadeIn(1000);
	$('#mapa'+id).css('display','block');
}

function closemap(id){
	$('#mapas').fadeOut(600);
	$('#mapa'+id).css('display','none');
	$('#info').css({opacity:1.0});
}

function justInt(e,value){
	if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46)){
		return;
	}
	else{
		e.preventDefault();
	}
}

function addGrid(id){
	if($('.filas'+id).length){
		$('.filas'+id).remove();
	}
	var total_seats = $('#totalseats'+id).val();
	var file = $('#files'+id).val();
	var seat = $('#seats'+id).val();
	var secuencial = $('#secuencial'+id).val();
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
			// if(file > 25){
				// alert('Solo puedes crear hasta 25 filas');
				// $('#files'+id).val('');
				// $('#seats'+id).val('');
				// $('#files'+id).focus();
			// }else{
				if(cant == total_seats){
					var countfile = 1;
					$('#createseats'+id).append('<tr id="columnas_num'+id+'" class="filas'+id+'"></tr>');
					$('#columnas_num'+id).append('<td colspan="3" style="text-align:center; vertical-align:middle;">Columnas-></td>');
					for(var y = 1; y <= seat; y++){
						$('#columnas_num'+id).append('<td style="text-align:center; vertical-align:middle;">'+y+'</td>');
					}
					for(var i = 0; i < file; i++){
						$('#createseats'+id).append('<tr id="num-'+countfile+'_cod-'+id+'" class="filas'+id+'"></tr>');
						$('#num-'+countfile+'_cod-'+id).append('<td>\
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
							
							if(countfile == 26){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-Z</td>');
							}
							
							if(countfile == 27){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AA</td>');
							}
							
							if(countfile == 28){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AB</td>');
							}
							
							if(countfile == 29){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AC</td>');
							}
							
							if(countfile == 30){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AD</td>');
							}
							
							
							
							if(countfile == 31){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AE</td>');
							}
							if(countfile == 32){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AF</td>');
							}
							if(countfile == 33){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AG</td>');
							}
							if(countfile == 34){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AH</td>');
							}
							if(countfile == 35){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AI</td>');
							}
							
							if(countfile == 36){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AJ</td>');
							}
							
							if(countfile == 37){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AK</td>');
							}
							
							if(countfile == 38){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AL</td>');
							}
							
							if(countfile == 39){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AM</td>');
							}
							
							if(countfile == 40){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AN</td>');
							}
							
							
							if(countfile == 41){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AO</td>');
							}
							if(countfile == 42){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AP</td>');
							}
							if(countfile == 43){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AQ</td>');
							}
							if(countfile == 44){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AR</td>');
							}
							if(countfile == 45){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AS</td>');
							}
							
							if(countfile == 46){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AT</td>');
							}
							
							if(countfile == 47){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AU</td>');
							}
							
							if(countfile == 48){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AV</td>');
							}
							
							if(countfile == 49){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AW</td>');
							}
							
							if(countfile == 50){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AX</td>');
							}
							
							
							
							
							if(countfile == 51){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AY</td>');
							}
							if(countfile == 52){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-AZ</td>');
							}
							if(countfile == 53){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BA</td>');
							}
							if(countfile == 54){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BB</td>');
							}
							if(countfile == 55){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BC</td>');
							}
							
							if(countfile == 56){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BD</td>');
							}
							
							if(countfile == 57){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BE</td>');
							}
							
							if(countfile == 58){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BF</td>');
							}
							
							if(countfile == 59){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BG</td>');
							}
							
							if(countfile == 60){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BH</td>');
							}
							
							
							if(countfile == 61){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BI</td>');
							}
							if(countfile == 62){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BJ</td>');
							}
							if(countfile == 63){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BK</td>');
							}
							if(countfile == 64){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BL</td>');
							}
							if(countfile == 65){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BM</td>');
							}
							
							if(countfile == 66){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BN</td>');
							}
							
							if(countfile == 67){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BO</td>');
							}
							
							if(countfile == 68){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BP</td>');
							}
							
							if(countfile == 69){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BQ</td>');
							}
							
							if(countfile == 70){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BQR</td>');
							}
							
							
							if(countfile == 71){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BS</td>');
							}
							if(countfile == 72){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BT</td>');
							}
							if(countfile == 73){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BU</td>');
							}
							if(countfile == 74){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BV</td>');
							}
							if(countfile == 75){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BW</td>');
							}
							
							if(countfile == 76){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BX</td>');
							}
							
							if(countfile == 77){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BY</td>');
							}
							
							if(countfile == 78){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-BZ</td>');
							}
							
							if(countfile == 79){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-CA</td>');
							}
							
							if(countfile == 80){
								$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">Fila-CB</td>');
							}
						}
						$('#num-'+countfile+'_cod-'+id).append('<td style="text-align:center; vertical-align:middle;">\
																	<input type="text" id="totalAsientos'+countfile+'-'+id+'" class="AsientosXfila'+countfile+'-'+id+'" value="'+seat+'" size="3" onkeyup="ColsXtext('+countfile+','+id+','+seat+')" />\
																</td>');
						var countcolumnas = 1;
						for(var j = 0; j < seat; j++){
							$('#num-'+countfile+'_cod-'+id).append('<td class="grid'+countfile+'_'+id+'" id="fl-'+countfile+'_as-'+countcolumnas+'_cod-'+id+'">\
																		<input type="checkbox" id="F-'+countfile+'_A-'+countcolumnas+'_C-'+id+'" checked="checked" onclick="seatok('+countfile+','+countcolumnas+','+id+')" /> \
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
			//}
			
		}
	}
}

function addseats(filas, id){
	var total_seats = $('#totalseats'+id).val();
	var disponibles = $('#createseats'+id+' input:checked').length;
	var seleccionados = $('#createseats'+id+' input:not:checked').lenght;
	var asientos_nodisponible = total_seats - disponibles;
	$('#total_nodisponibles'+id).val(asientos_nodisponible);
	$('#total_disponibles'+id).val(disponibles);
	var txt_seats = $('#seats'+id).val();
	var num_checks = $('.grid'+filas+'_'+id+' input:checked').length;
	if(num_checks < txt_seats){
		var add_seat = (num_checks + 1);
		$('#fl-'+filas+'_as-'+add_seat+'_cod-'+id).append('<input type="checkbox" id="F-'+filas+'_A-'+add_seat+'_C-'+id+'" checked="checked" onclick="seatok('+filas+','+add_seat+','+id+')" />');
		$('#r'+filas+'_c'+add_seat+'_c'+id).remove();
		$('#file-'+filas+'_A-'+add_seat+'_C-'+id).css('display','none');
	}else if(num_checks == txt_seats){
		alert('No se puede añadir mas sillas, solo tienes '+txt_seats+' columnas');
		$('#add'+id+'_'+filas).css('display','none');
	}
}

function removeseats(filas, id){
	var total_seats = $('#totalseats'+id).val();
	var disponibles = $('#createseats'+id+' input:checked').length;
	var asientos_nodisponible = total_seats - disponibles;
	$('#total_nodisponibles'+id).val(asientos_nodisponible);
	$('#total_disponibles'+id).val(disponibles);
	var secu = $('#secuencial'+id).val();
	var num_seats = $('#seats'+id).val();
	var num_check = $('.grid'+filas+'_'+id+' input:checked').length;
	if(num_seats > num_check){
		$('#add'+id+'_'+filas).css('display','block');
		$('#F-'+filas+'_A-'+num_check+'_C-'+id).remove();
		$('#file-'+filas+'_A-'+num_check+'_C-'+id).css('display','block');
		$('#fl-'+filas+'_as-'+num_check+'_cod-'+id).append('<div style="display:none" class="cuadricula'+id+'" id="r'+filas+'_c'+num_check+'_c'+id+'">\
												<input type="hidden" class="rows'+id+'" id="row'+filas+'_'+num_check+'_'+id+'" value="'+filas+'" />\
												<input type="hidden" class="cols'+id+'" id="col'+filas+'_'+num_check+'_'+id+'" value="'+num_check+'" /></div>');
	}else if(num_seats == num_check){
		$('#add'+id+'_'+filas).css('display','block');
		$('#F-'+filas+'_A-'+num_seats+'_C-'+id).remove();
		$('#file-'+filas+'_A-'+num_seats+'_C-'+id).css('display','block');
		$('#fl-'+filas+'_as-'+num_seats+'_cod-'+id).append('<div style="display:none" class="cuadricula'+id+'" id="r'+filas+'_c'+num_seats+'_c'+id+'">\
												<input type="hidden" class="rows'+id+'" id="row'+filas+'_'+num_seats+'_'+id+'" value="'+filas+'" />\
												<input type="hidden" class="cols'+id+'" id="col'+filas+'_'+num_seats+'_'+id+'" value="'+num_seats+'" /></div>');
	}
}

function seatok(row, col, id){
	var seleccionados = $('#createseats'+id+' input[type=checkbox]:not(:checked)').length;
	var num_cols = $('.grid'+row+'_'+id+' input:checked').length;
	$('#totalAsientos'+row+'-'+id).val(num_cols);
	var total_seats = $('#totalseats'+id).val();
	var disponibles = $('#createseats'+id+' input:checked').length;
	var asientos_nodisponible = (total_seats - disponibles);
	$('#total_nodisponibles'+id).val(asientos_nodisponible);
	$('#total_disponibles'+id).val(disponibles);
	if(($('#F-'+row+'_A-'+col+'_C-'+id).is(':checked'))){
		$('#r'+row+'_c'+col+'_c'+id).remove();
	}else{
		$('#fl-'+row+'_as-'+col+'_cod-'+id).append('<div style="display:none" class="cuadricula'+id+'" id="r'+row+'_c'+col+'_c'+id+'">\
												<input type="hidden" class="rows'+id+'" id="row'+row+'_'+col+'_'+id+'" value="'+row+'" />\
												<input type="hidden" class="cols'+id+'" id="col'+row+'_'+col+'_'+id+'" value="'+col+'" /></div>');
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
														<input type="hidden" class="rows'+id+'" id="row'+fila+'_'+i+'_'+id+'" value="'+fila+'" />\
														<input type="hidden" class="cols'+id+'" id="col'+fila+'_'+i+'_'+id+'" value="'+i+'" /></div>');
				var total_seats = $('#totalseats'+id).val();
				var disponibles = $('#createseats'+id+' input:checked').length;
				var asientos_nodisponible = total_seats - disponibles;
				$('#total_nodisponibles'+id).val(asientos_nodisponible);
				$('#total_disponibles'+id).val(disponibles);
			}
		}else{
			num_cols++;
			for(var i = num_cols; i <= val_text; i++){
				$('#fl-'+fila+'_as-'+i+'_cod-'+id).append('<input type="checkbox" id="F-'+fila+'_A-'+i+'_C-'+id+'" checked="checked" onclick="seatok('+fila+','+i+','+id+')" />');
				$('#r'+fila+'_c'+i+'_c'+id).remove();
				$('#file-'+fila+'_A-'+i+'_C-'+id).css('display','none');
				var total_seats = $('#totalseats'+id).val();
				var disponibles = $('#createseats'+id+' input:checked').length;
				var asientos_nodisponible = total_seats - disponibles;
				$('#total_nodisponibles'+id).val(asientos_nodisponible);
				$('#total_disponibles'+id).val(disponibles);
			}
		}
	}
}

function saveall(id){
	$('#mapas').fadeOut(600);
	$('#mapa'+id).css('display','none');
	$('#info').css({opacity:1.0});
	
	var concierto = $('#idCon').val();
	var cordenadas = $('#coords'+id).val();
	var filas = $('#files'+id).val();
	var asientos = $('#seats'+id).val();
	var secuencial_slt = $('#secuencial'+id).val();
	var data_full = $('#datafull'+id).val();
	var date_state = $('#datestate'+id).val();
	var valores_asientos = '';
	
	var total_seats = $('#totalseats'+id).val();
	
	$('.cuadricula'+id).each(function(){ 
		var fila = $(this).find('.rows'+id).val();
		var columns = $(this).find('.cols'+id).val();
		valores_asientos += fila +'|'+ columns +'|'+'@';
	});
	var valores_asientos_F = valores_asientos.substring(0,valores_asientos.length -1);
	 alert(valores_asientos_F + 'creacion de cuadricula');
	$.post('spadmin/creacionmapaok.php',{
		id : id, date_state : date_state, data_full : data_full, concierto : concierto, cordenadas : cordenadas, 
		filas : filas, asientos : asientos, secuencial_slt : secuencial_slt, valores_asientos : valores_asientos_F , total_seats : total_seats
	}).done(function(data){
		alert('Se ha guardado con exito');
		window.location = '';
	});
}
</script>