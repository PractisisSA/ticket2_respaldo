<?php
	session_start();
	if($_SESSION['autentica'] == 'uzx153'){
		echo '<input type="hidden" id="session" value="ok"/>';
	}else{
		echo '<input type="hidden" id="session" value="error"/>';
	}
	if(isset($_SESSION['carrito'])){
		echo "<input type = 'hidden' id = 'sesion_compra' value = '".json_encode($_SESSION['carrito'])."' />";
	}else{
		echo "<input type = 'hidden' id = 'sesion_compra' value = '0' />";
	}

	$idLoc = $_REQUEST['idLoc'];
	$idCon = $_REQUEST['idCon'];
	
	$sqlB = '
					SELECT *
					FROM Butaca 
					WHERE intLocalB = "'.$idLoc.'" 
				';
	$resB = mysql_query($sqlB) or die (mysql_error());
	$rowB = mysql_fetch_array($resB);
	
	$numcolumnas = $rowB['intAsientosB'];
	$divisiones = ceil($numcolumnas / 30);


	$totdivisiones = (500 / $divisiones);
	
	
	
	function obtenerFechaEnLetra($fecha){

		$dia= conocerDiaSemanaFecha($fecha);

		$num = date("j", strtotime($fecha));

		$anno = date("Y", strtotime($fecha));

		$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

		$mes = $mes[(date('m', strtotime($fecha))*1)-1];

		return $dia.', '.$num.' de '.$mes.' del '.$anno;

	}

	 

	function conocerDiaSemanaFecha($fecha) {

		$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');

		$dia = $dias[date('w', strtotime($fecha))];

		return $dia;

	}
	
	$modulo = $_REQUEST['modulo'];
	echo "<input type = 'hidden' id ='modulos' value = '".$modulo."' />";
?>
	<style>
		.asiento_vasio{
			border: 1px solid #000 !important;
			padding-top:7px !important;
		}
		.secciones:hover{
			background-color:#67cdf5 !important;
			color:#fff !important;
		}
		strong{
			color:#000 !important;
		}
		
		.pasos{
			cursor:pointer;
		}
		
		.btn {
		  font-size: 11px !important;
		  color:white !important;
		  background-color: #18B8EB !important;
		}
	</style>

	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div id="order-localidad" class="col-md-2"><button type="button" class="btn btn-info btn-arrow-right">LOCALIDAD</button></div>
			<div id="order-asiento" class="col-md-2"><button type="button" style="background-color:white!important; color:#46b8da !important; padding-left: 0px !important; padding-right: 0px !important;" class="btn btn-info btn-arrow-right">ASIENTO</button></div>
			<div id="order-identificacion" class="col-md-2"><button style="" type="button" class="btn btn-info btn-arrow-right">IDENTIFICATE</button></div>
			<div id="order-resumen" class="col-md-2"><button type="button" class="btn btn-info btn-arrow-right">RESUMEN</button></div>
			<div id="order-pago" class="col-md-2"><button type="button" class="btn btn-info btn-arrow-right">PAGO</button></div>
			<div id="order-confirmacion" class="col-md-2"><button type="button" class="btn btn-info btn-arrow-right">CONFIRMACIÓN</button></div>
		</div>
		<div class="col-md-1"></div>
	</div>
	<?php 

	echo '<input id="justp" type="hidden" name="" value="">';
	
	?>
	<div class = 'row' style="padding-right: 165px !important; padding-left: 140px !important;">

		<br><br>

		<?php 
			$sqlL = 'SELECT * FROM `Localidad` WHERE `idLocalidad` = "'.$idLoc.'" ORDER BY `doublePrecioL` DESC ';
			$resL = mysql_query($sqlL) or die (mysql_error());
			$rowL = mysql_fetch_array($resL);

			$sqlCon = 'SELECT * FROM `Concierto` WHERE `idConcierto` = "'.$idCon.'"';
			$resCon = mysql_query($sqlCon) or die (mysql_error());
			$rowCon = mysql_fetch_array($resCon);

			$counter = 0;

			for($i=1;$i<=$divisiones;$i++){
				$counter++;
			}

			if($rowL['strCaracteristicaL'] == 'Asientos numerados'){
				/*for($i=1;$i<=$divisiones;$i++){
					$counter++;
				}*/
			}

		?>
			<h4 class="padding-top-1x text-normal" style = 'text-transform:capitalize;'>ESTAS EN:<strong>"<?php echo $rowL['strDescripcionL'];?>"</strong> / <?php echo $rowCon['strEvento']; ?></h4>
			<h4 class="padding-top-1x text-normal" style = 'text-transform:capitalize;'><strong><?php echo $rowL['strDescripcionL'];?></strong> CUENTA CON <?php echo $counter; ?> ZONAS SELECCIONA UNA DE ELLAS Y ELIJE TUS ASIENTOS A CONTINUACIÓN.</h4>
		<br>	
		<div class="row" id = 'paso2' style = ''>
			<div class="col-xs-2">
				<div style="width:20px; height:20px; background-color:#67cdf5;"></div>
				<span style="">Tu Asiento</span>
			</div>
			<div class="col-xs-3">
				<div style="width:20px; height:20px; background-color:#ffffff;border: 1px solid #000"></div>
				<span style="">Asientos Disponibles</span>
			</div>
			<div class="col-xs-2">
				<div style="width:20px; height:20px; background-color:#fbed2c;"></div>
				<span style="">Asientos Reservados</span>
			</div>
			<div class="col-xs-3">
				<div style="width:20px; height:20px; background-color:red;"></div>
				<span style="">Asientos Ocupados</span>
			</div>
			<div class="col-xs-2">
				<div style="width:20px; height:20px; background-color:#000;"></div>
				<span style="">Asientos no Disponibles</span>
			</div>
		
			<?php 
				$query6 = 'SELECT idLocalidad FROM Localidad WHERE idLocalidad = "'.$idLoc.'"';
				$res6 = mysql_query($query6) or die (mysql_error());
				while($row6 = mysql_fetch_array($res6)){

			?>
				<!--<div id="detallesillas<?php echo $row6['idLocalidad'];?>" style="display:;" class = 'detalles_selecciones'>
					<div class="row">
						<div class="col-lg-6" style="text-align:center;">
							<h4 style="color:#67cdf5;"><strong><span id="numboletos<?php echo $row6['idLocalidad'];?>">0</span></strong> Boleto(s) seleccionados</h4>
						</div>
						<div class="col-lg-5" style="text-align:center;">
							<h4 style="color:#67cdf5;" id="descripcionsilla<?php echo $row6['idLocalidad'];?>">!</h4>
						</div>
					</div>
					<div class="row">
						<div class="alert alert-info" role="alert" style="text-align: center !important; background-color: white !important;">
							ESCENARIO
						</div>
					</div>
				</div>-->
			<?php 
				}
			?>
		</div>
		<br>	
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-info" role="alert" style="font-size:24px !important; text-align: center !important; background-color: white !important;">
					<div class="row">
						<div class="col-md-5"><hr /></div>
						<div class="col-md-2">
							<div>ESCENARIO</div>
						</div>
						<div class="col-md-5"><hr /></div>
					</div>
				</div>
			</div>
		</div>
		<nav aria-label="Page navigation">
			<center>
				<div class="row">
					<div class="col-md-1" style="margin-right: -10px !important;">
						<i onclick="PreviousZone()" class="arrow left"></i>
					</div>
					<div class="col-md-10">
						<ul class="pagination">
						<?php

							for($i=1;$i<=$divisiones;$i++) {

								$current = '';

								if ($i == 1) {
									$current = 'current';
								}

								echo '<li><a id = "seccion_'.$i.'" class = "secciones" onclick="open_rest_map('.$i.','.$idLoc.','.$idCon.')" name="'.$current.'" style = "cursor:pointer;padding-left:0px;padding-right:5px;width:'.$totdivisiones.'px;font-size: 16px !important;">Zona '.$i.'</a></li>';
							}
							
						?>
						</ul>
					</div>
					<div class="col-md-1" style="margin-left: -10px !important;">
						<i onclick="nextZone();" class="arrow right"></i>
					</div>
				</div>
				
			</center>
		</nav>
		<input type="hidden" id="secuencial<?php echo $idLoc;?>" value="<?php echo $rowB['strSecuencial'];?>" />
		<input type="hidden" id="posicion_mapa_inicio" value="" />
		<center>
			<h2 class="padding-top-1x text-normal" style = 'text-transform:capitalize;' id = 'nombreSeccion'></h2>
		</center>
		<div class="row">
			<div id = 'localidad_butaca'></div>
		</div>
		<div id="dataTable" class="row" style="display: none;">
			<div class="container">
				<table align="center" class="table-responsive" style="width:100%; color:#fff; border: solid 1px #00ADEF !important;">
					<thead>	
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
					</thead>
					<tbody id="seleccion"></tbody>
					<tfoot>
						<tr>
							<td colspan = '7' align = 'right' >
								<button id="sendBill" onclick="sendBill();" style="margin-right:13.7px !important; margin-top: 5px !important; margin-bottom: 10px !important;" type="button" class="btn btn-info" disabled>facturar</button>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<br>
	</div>
	
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script language="Javascript"  type="text/javascript" src="js/clockCountdown.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/jquery.imagemapster.js"></script>
		<link rel="stylesheet" href="css/bootstrap.css">
		<script src="js/jquery.easing-1.3.js"></script>
		<script src="js/jquery.mousewheel-3.1.12.js"></script>
		<script src="js/jquery.jcarousellite.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script>
		$( document ).ready(function() {
			$('#seccion_1').click();
			var pasos = $('#sesion_compra').val();

			if(pasos != 0){
				var obj=jQuery.parseJSON(pasos);
				for (var i=0; i< obj.length; i++){
					var posicion_mapa_inicio = obj[i][5];
				}
			}
			$('.btn_eliminar').addClass('btn btn-info');

			var modulo = $('#modulos').val();
			$('.pasos').removeClass('pasos_activa');
			$('#'+modulo).addClass('pasos_activa');

		});
		
		function nextZone() {

			$('a[name="current"]').each(function () {

				var zone = $(this).text();
				zone = zone.replace(/\s/g, '');
				zone = zone.substring(4, 5);

				if (zone == 1) {

					$('#seccion_1').css('width', '85px');
					$('#seccion_2').html('Zona 2');
					$('#seccion_2').append(' - Selecciona tu asiento');
					$('#seccion_1').html('Zona 1');
					$('#seccion_2').css('width', '480px');
					$('#seccion_3').css('width', '85px');
					$('#seccion_4').css('width', '85px');
					$('#seccion_5').css('width', '85px');
					$('#seccion_6').css('width', '85px');
					$('#seccion_7').css('width', '85px');

					$('#seccion_1').attr('name', '');
					$('#seccion_2').attr('name', 'current');
					$('#seccion_2').click();

				}else if(zone == 2){

					$('#seccion_1').css('width', '85px');
					$('#seccion_3').html('Zona 3');
					$('#seccion_3').append(' - Selecciona tu asiento');
					$('#seccion_2').html('Zona 2');
					$('#seccion_2').css('width', '85px');
					$('#seccion_3').css('width', '480px');
					$('#seccion_4').css('width', '85px');
					$('#seccion_5').css('width', '85px');
					$('#seccion_6').css('width', '85px');
					$('#seccion_7').css('width', '85px');

					$('#seccion_2').attr('name', '');
					$('#seccion_3').attr('name', 'current');
					$('#seccion_3').click();

				}else if(zone == 3){

					$('#seccion_1').css('width', '85px');
					$('#seccion_3').html('Zona 3');
					$('#seccion_4').append(' - Selecciona tu asiento');
					$('#seccion_3').html('Zona 3');
					$('#seccion_2').css('width', '85px');
					$('#seccion_3').css('width', '85px');
					$('#seccion_4').css('width', '480px');
					$('#seccion_5').css('width', '85px');
					$('#seccion_6').css('width', '85px');
					$('#seccion_7').css('width', '85px');

					$('#seccion_3').attr('name', '');
					$('#seccion_4').attr('name', 'current');
					$('#seccion_4').click();

				}else if(zone == 4){

					$('#seccion_1').css('width', '85px');
					$('#seccion_4').html('Zona 4');
					$('#seccion_5').append(' - Selecciona tu asiento');
					$('#seccion_4').html('Zona 4');
					$('#seccion_2').css('width', '85px');
					$('#seccion_4').css('width', '85px');
					$('#seccion_5').css('width', '480px');
					$('#seccion_3').css('width', '85px');
					$('#seccion_6').css('width', '85px');
					$('#seccion_7').css('width', '85px');

					$('#seccion_4').attr('name', '');
					$('#seccion_5').attr('name', 'current');
					$('#seccion_5').click();

				}else if(zone == 5){

					$('#seccion_1').css('width', '85px');
					$('#seccion_5').html('Zona 5');
					$('#seccion_6').append(' - Selecciona tu asiento');
					$('#seccion_5').html('Zona 5');
					$('#seccion_2').css('width', '85px');
					$('#seccion_4').css('width', '85px');
					$('#seccion_5').css('width', '85px');
					$('#seccion_6').css('width', '480px');
					$('#seccion_3').css('width', '85px');
					$('#seccion_7').css('width', '85px');

					$('#seccion_5').attr('name', '');
					$('#seccion_6').attr('name', 'current');
					$('#seccion_6').click();

				}else if(zone == 6){

					$('#seccion_1').css('width', '85px');
					$('#seccion_6').html('Zona 6');
					$('#seccion_7').append(' - Selecciona tu asiento');
					$('#seccion_6').html('Zona 6');
					$('#seccion_2').css('width', '85px');
					$('#seccion_4').css('width', '85px');
					$('#seccion_5').css('width', '85px');
					$('#seccion_6').css('width', '85px');
					$('#seccion_7').css('width', '480px');
					$('#seccion_3').css('width', '85px');

					$('#seccion_6').attr('name', '');
					$('#seccion_7').attr('name', 'current');
					$('#seccion_7').click();

				}else if(zone == 7){

					$('#seccion_1').css('width', '85px');
					$('#seccion_7').html('Zona 7');
					$('#seccion_8').append(' - Selecciona tu asiento');
					$('#seccion_7').html('Zona 7');
					$('#seccion_2').css('width', '85px');
					$('#seccion_4').css('width', '85px');
					$('#seccion_5').css('width', '85px');
					$('#seccion_6').css('width', '85px');
					$('#seccion_8').css('width', '480px');
					$('#seccion_3').css('width', '85px');
					
					$('#seccion_7').attr('name', '');
					$('#seccion_8').attr('name', 'current');
					$('#seccion_8').click();

				}

			})

		}
		function PreviousZone() {

			$('a[name="current"]').each(function () {

				var zone = $(this).text();
				zone = zone.replace(/\s/g, '');
				zone = zone.substring(4, 5);

				if (zone == 7) {

					$('#seccion_1').css('width', '85px');
					$('#seccion_6').html('Zona 6');
					$('#seccion_6').append(' - Selecciona tu asiento');
					$('#seccion_7').html('Zona 7');
					$('#seccion_6').css('width', '480px');
					$('#seccion_2').css('width', '85px');
					$('#seccion_4').css('width', '85px');
					$('#seccion_5').css('width', '85px');
					$('#seccion_3').css('width', '85px');
					$('#seccion_7').css('width', '85px');

					$('#seccion_7').attr('name', '');
					$('#seccion_6').attr('name', 'current');
					$('#seccion_6').click();

				}else if(zone == 6){

					$('#seccion_1').css('width', '85px');
					$('#seccion_5').html('Zona 5');
					$('#seccion_5').append(' - Selecciona tu asiento');
					$('#seccion_6').html('Zona 6');
					$('#seccion_2').css('width', '85px');
					$('#seccion_4').css('width', '85px');
					$('#seccion_3').css('width', '85px');
					$('#seccion_6').css('width', '85px');
					$('#seccion_7').css('width', '85px');
					$('#seccion_5').css('width', '480px');

					$('#seccion_6').attr('name', '');
					$('#seccion_5').attr('name', 'current');
					$('#seccion_5').click();

				}else if(zone == 5){

					$('#seccion_1').css('width', '85px');
					$('#seccion_4').html('Zona 4');
					$('#seccion_4').append(' - Selecciona tu asiento');
					$('#seccion_5').html('Zona 5');
					$('#seccion_2').css('width', '85px');
					$('#seccion_3').css('width', '85px');
					$('#seccion_5').css('width', '85px');
					$('#seccion_6').css('width', '85px');
					$('#seccion_7').css('width', '85px');
					$('#seccion_4').css('width', '480px');

					$('#seccion_5').attr('name', '');
					$('#seccion_4').attr('name', 'current');
					$('#seccion_4').click();

				}else if(zone == 4){

					$('#seccion_1').css('width', '85px');
					$('#seccion_3').html('Zona 3');
					$('#seccion_3').append(' - Selecciona tu asiento');
					$('#seccion_4').html('Zona 4');
					$('#seccion_2').css('width', '85px');
					$('#seccion_4').css('width', '85px');
					$('#seccion_5').css('width', '85px');
					$('#seccion_6').css('width', '85px');
					$('#seccion_7').css('width', '85px');
					$('#seccion_3').css('width', '480px');

					$('#seccion_4').attr('name', '');
					$('#seccion_3').attr('name', 'current');
					$('#seccion_3').click();

				}else if(zone == 3){

					$('#seccion_1').css('width', '85px');
					$('#seccion_2').html('Zona 2');
					$('#seccion_2').append(' - Selecciona tu asiento');
					$('#seccion_3').html('Zona 3');
					$('#seccion_3').css('width', '85px');
					$('#seccion_4').css('width', '85px');
					$('#seccion_5').css('width', '85px');
					$('#seccion_6').css('width', '85px');
					$('#seccion_7').css('width', '85px');
					$('#seccion_2').css('width', '480px');

					$('#seccion_3').attr('name', '');
					$('#seccion_2').attr('name', 'current');
					$('#seccion_2').click();

				}else if(zone == 2){
					
					$('#seccion_3').css('width', '85px');
					$('#seccion_1').html('Zona 1');
					$('#seccion_1').append(' - Selecciona tu asiento');
					$('#seccion_2').html('Zona 2');
					$('#seccion_2').css('width', '85px');
					$('#seccion_4').css('width', '85px');
					$('#seccion_5').css('width', '85px');
					$('#seccion_6').css('width', '85px');
					$('#seccion_7').css('width', '85px');
					$('#seccion_1').css('width', '480px');
					$('#seccion_2').attr('name', '');
					$('#seccion_1').attr('name', 'current');
					$('#seccion_1').click();
				}
			})
		}


		function sendBill() {
			var currentUser = $('#session').val();
			var currentSession = $('#justp').val();
			if (currentUser == 'ok' || currentSession == 'yes') {
				location.href = '?modulo=compra'
			}else{
				alert('Fuck my life');
			}

		}
		function add_asientos(local, concierto, row, col){
			$('#sendBill').attr('disabled', false);
			var posicion_mapa_inicio = $('#posicion_mapa_inicio').val();
			var numboletos = $('#numboletos'+local).html();
			var estadoAsiento = 0;
			var color = $('#A-'+local+'-'+row+'-'+col).css('background-color');
			if(color == 'rgb(255, 255, 255)'){
				$('#A-'+local+'-'+row+'-'+col).css('background-color','rgb(103, 205, 245)');
				numboletos = parseInt(numboletos) + parseInt(1);
				$('#numboletos'+local).html(numboletos);
				estadoAsiento = 1;
			}else{
				$('#A-'+local+'-'+row+'-'+col).css('background-color','#fff');
				$('#new_selection_'+row+'_'+col+'_'+local).remove();
				numboletos = parseInt(numboletos) - parseInt(1);
				$('#numboletos'+local).html(numboletos);
				$('#descripcionsilla'+local).html('');
				estadoAsiento = 0;
				var contiene_pos_ = $('.contiene_pos_'+local+'_'+row+'_'+col).val();
				
				$.post("subpages/Facturas/quitaPosicion.php",{ 
					contiene_pos_ : contiene_pos_
				}).done(function(data){
					$('.contiene_pos_'+local+'_'+row+'_'+col).val('');
				});
				return false;
			}
			var secuencial = $('#secuencial'+local).val();
			if($('#new_selection_'+row+'_'+col+'_'+local).length){
				$('#descripcionsilla'+local).html('');
			}else{
				if(secuencial == 0){
					$('#descripcionsilla'+local).html('<p align="center">FILA-'+row+'_SILLA-'+col+'</p>');
				}else if(secuencial == 1){
					if(row == 1){
						$('#descripcionsilla'+local).html('<p align="center">FILA-A_SILLA-'+col+'</p>');
					}
					if(row == 2){
						$('#descripcionsilla'+local).html('<p align="center">FILA-B_SILLA-'+col+'</p>');
					}
					if(row == 3){
						$('#descripcionsilla'+local).html('<p align="center">FILA-C_SILLA-'+col+'</p>');
					}
					if(row == 4){
						$('#descripcionsilla'+local).html('<p align="center">FILA-D_SILLA-'+col+'</p>');
					}
					if(row == 5){
						$('#descripcionsilla'+local).html('<p align="center">FILA-E_SILLA-'+col+'</p>');
					}
					if(row == 6){
						$('#descripcionsilla'+local).html('<p align="center">FILA-F_SILLA-'+col+'</p>');
					}
					if(row == 7){
						$('#descripcionsilla'+local).html('<p align="center">FILA-G_SILLA-'+col+'</p>');
					}
					if(row == 8){
						$('#descripcionsilla'+local).html('<p align="center">FILA-H_SILLA-'+col+'</p>');
					}
					if(row == 9){
						$('#descripcionsilla'+local).html('<p align="center">FILA-I_SILLA-'+col+'</p>');
					}
					if(row == 10){
						$('#descripcionsilla'+local).html('<p align="center">FILA-J_SILLA-'+col+'</p>');
					}
					if(row == 11){
						$('#descripcionsilla'+local).html('<p align="center">FILA-K_SILLA-'+col+'</p>');
					}
					if(row == 12){
						$('#descripcionsilla'+local).html('<p align="center">FILA-L_SILLA-'+col+'</p>');
					}
					if(row == 13){
						$('#descripcionsilla'+local).html('<p align="center">FILA-M_SILLA-'+col+'</p>');
					}
					if(row == 14){
						$('#descripcionsilla'+local).html('<p align="center">FILA-N_SILLA-'+col+'</p>');
					}
					if(row == 15){
						$('#descripcionsilla'+local).html('<p align="center">FILA-O_SILLA-'+col+'</p>');
					}
					if(row == 16){
						$('#descripcionsilla'+local).html('<p align="center">FILA-P_SILLA-'+col+'</p>');
					}
					if(row == 17){
						$('#descripcionsilla'+local).html('<p align="center">FILA-Q_SILLA-'+col+'</p>');
					}
					if(row == 18){
						$('#descripcionsilla'+local).html('<p align="center">FILA-R_SILLA-'+col+'</p>');
					}
					if(row == 19){
						$('#descripcionsilla'+local).html('<p align="center">FILA-S_SILLA-'+col+'</p>');
					}
					if(row == 20){
						$('#descripcionsilla'+local).html('<p align="center">FILA-T_SILLA-'+col+'</p>');
					}
					if(row == 21){
						$('#descripcionsilla'+local).html('<p align="center">FILA-U_SILLA-'+col+'</p>');
					}
					if(row == 22){
						$('#descripcionsilla'+local).html('<p align="center">FILA-V_SILLA-'+col+'</p>');
					}
					if(row == 23){
						$('#descripcionsilla'+local).html('<p align="center">FILA-W_SILLA-'+col+'</p>');
					}
					if(row == 24){
						$('#descripcionsilla'+local).html('<p align="center">FILA-X_SILLA-'+col+'</p>');
					}
					if(row == 25){
						$('#descripcionsilla'+local).html('<p align="center">FILA-Y_SILLA-'+col+'</p>');
					}
				}
				$.ajax({
					type : 'POST',
					url : 'subpages/Conciertos/seleccionarasientos.php',
					data : 'local='+local +'&concierto='+concierto +'&row='+row +'&col='+col,
					success : function(response){
						$('#seleccion').append(response);
						$('.added').attr('disabled',true);
						$('.added').css('border','none !important');
						$('.added').css('background-color','#fff !important');
					}
				});
				alert(local+'LOCAL');
				$.post("subpages/Facturas/creaSesionOnline.php",{ 
					local : local , concierto : concierto , row : row , col : col , posicion_mapa_inicio : posicion_mapa_inicio , estadoAsiento : estadoAsiento
				}).done(function(data){
					console.log(data+'LOCAL1');
					$('.contiene_pos_'+local+'_'+row+'_'+col).val(data);
				});
			}
			
		}
		function open_rest_map(id, local, concierto){
			$('#posicion_mapa_inicio').val(id);
			$('#paso2').fadeIn('slow');
			$('.secciones').css('background-color','#fff');
			$('.secciones').css('color','#337ab7');
			$('#seccion_'+id).css('background-color','#00AEEF');
			$('#seccion_'+id).css('color','#fff');

			$('#seccion_'+id).css('width', '480px');
			if (id == 1) {
				$('#seccion_3').css('width', '85px');
				$('#seccion_2').css('width', '85px');
				$('#seccion_4').css('width', '85px');
				$('#seccion_5').css('width', '85px');
				$('#seccion_6').css('width', '85px');
				$('#seccion_7').css('width', '85px');
				$('#seccion_1').attr('name', 'current');
				$('#seccion_1').html('Zona 1');
				$('#seccion_1').append(' - Selecciona tu asiento');
				$('#seccion_2').html('Zona 2');
				$('#seccion_3').html('Zona 3');
				$('#seccion_4').html('Zona 4');
				$('#seccion_5').html('Zona 5');
				$('#seccion_6').html('Zona 6');
				$('#seccion_7').html('Zona 7'); 
				$('#seccion_2').attr('name', '');
				$('#seccion_3').attr('name', '');
				$('#seccion_4').attr('name', '');
				$('#seccion_5').attr('name', '');
				$('#seccion_6').attr('name', '');
				$('#seccion_7').attr('name', '');
			}else if(id == 2){
				$('#seccion_3').css('width', '85px');
				$('#seccion_1').css('width', '85px');
				$('#seccion_4').css('width', '85px');
				$('#seccion_5').css('width', '85px');
				$('#seccion_6').css('width', '85px');
				$('#seccion_7').css('width', '85px');
				$('#seccion_2').attr('name', 'current');
				$('#seccion_2').html('Zona 2');
				$('#seccion_2').append(' - Selecciona tu asiento');
				$('#seccion_1').html('Zona 1');
				$('#seccion_3').html('Zona 3');
				$('#seccion_4').html('Zona 4');
				$('#seccion_5').html('Zona 5');
				$('#seccion_6').html('Zona 6');
				$('#seccion_7').html('Zona 7'); 
				$('#seccion_1').attr('name', '');
				$('#seccion_3').attr('name', '');
				$('#seccion_4').attr('name', '');
				$('#seccion_5').attr('name', '');
				$('#seccion_6').attr('name', '');
				$('#seccion_7').attr('name', '');
			}else if (id == 3) {
				$('#seccion_1').css('width', '85px');
				$('#seccion_2').css('width', '85px');
				$('#seccion_4').css('width', '85px');
				$('#seccion_5').css('width', '85px');
				$('#seccion_6').css('width', '85px');
				$('#seccion_7').css('width', '85px');
				$('#seccion_3').attr('name', 'current');
				$('#seccion_3').html('Zona 3');
				$('#seccion_3').append(' - Selecciona tu asiento');
				$('#seccion_2').html('Zona 2');
				$('#seccion_1').html('Zona 1');
				$('#seccion_4').html('Zona 4');
				$('#seccion_5').html('Zona 5');
				$('#seccion_6').html('Zona 6');
				$('#seccion_7').html('Zona 7'); 
				$('#seccion_2').attr('name', '');
				$('#seccion_1').attr('name', '');
				$('#seccion_4').attr('name', '');
				$('#seccion_5').attr('name', '');
				$('#seccion_6').attr('name', '');
				$('#seccion_7').attr('name', '');
			}else if (id == 4) {
				$('#seccion_1').css('width', '85px');
				$('#seccion_2').css('width', '85px');
				$('#seccion_3').css('width', '85px');
				$('#seccion_5').css('width', '85px');
				$('#seccion_6').css('width', '85px');
				$('#seccion_7').css('width', '85px');
				$('#seccion_4').attr('name', 'current');
				$('#seccion_4').html('Zona 4');
				$('#seccion_4').append(' - Selecciona tu asiento');
				$('#seccion_2').html('Zona 2');
				$('#seccion_3').html('Zona 3');
				$('#seccion_1').html('Zona 1');
				$('#seccion_5').html('Zona 5');
				$('#seccion_6').html('Zona 6');
				$('#seccion_7').html('Zona 7'); 
				$('#seccion_2').attr('name', '');
				$('#seccion_1').attr('name', '');
				$('#seccion_3').attr('name', '');
				$('#seccion_5').attr('name', '');
				$('#seccion_6').attr('name', '');
				$('#seccion_7').attr('name', '');
			}else if (id == 5) {
				$('#seccion_1').css('width', '85px');
				$('#seccion_2').css('width', '85px');
				$('#seccion_4').css('width', '85px');
				$('#seccion_3').css('width', '85px');
				$('#seccion_6').css('width', '85px');
				$('#seccion_7').css('width', '85px');
				$('#seccion_5').attr('name', 'current');
				$('#seccion_5').html('Zona 5');
				$('#seccion_5').append(' - Selecciona tu asiento');
				$('#seccion_2').html('Zona 2');
				$('#seccion_3').html('Zona 3');
				$('#seccion_4').html('Zona 4');
				$('#seccion_1').html('Zona 1');
				$('#seccion_6').html('Zona 6');
				$('#seccion_7').html('Zona 7'); 
				$('#seccion_2').attr('name', '');
				$('#seccion_1').attr('name', '');
				$('#seccion_4').attr('name', '');
				$('#seccion_3').attr('name', '');
				$('#seccion_6').attr('name', '');
				$('#seccion_7').attr('name', '');
			}else if (id == 6) {
				$('#seccion_1').css('width', '85px');
				$('#seccion_2').css('width', '85px');
				$('#seccion_4').css('width', '85px');
				$('#seccion_5').css('width', '85px');
				$('#seccion_3').css('width', '85px');
				$('#seccion_7').css('width', '85px');
				$('#seccion_6').attr('name', 'current');
				$('#seccion_6').html('Zona 6');
				$('#seccion_6').append(' - Selecciona tu asiento');
				$('#seccion_2').html('Zona 2');
				$('#seccion_3').html('Zona 3');
				$('#seccion_4').html('Zona 4');
				$('#seccion_5').html('Zona 5');
				$('#seccion_1').html('Zona 1');
				$('#seccion_7').html('Zona 7'); 
				$('#seccion_2').attr('name', '');
				$('#seccion_1').attr('name', '');
				$('#seccion_4').attr('name', '');
				$('#seccion_5').attr('name', '');
				$('#seccion_3').attr('name', '');
				$('#seccion_7').attr('name', '');
			}else if (id == 7) {
				$('#seccion_1').css('width', '85px');
				$('#seccion_2').css('width', '85px');
				$('#seccion_4').css('width', '85px');
				$('#seccion_5').css('width', '85px');
				$('#seccion_3').css('width', '85px');
				$('#seccion_6').css('width', '85px');
				$('#seccion_7').attr('name', 'current');
				$('#seccion_7').html('Zona 7');
				$('#seccion_7').append(' - Selecciona tu asiento');
				$('#seccion_2').html('Zona 2');
				$('#seccion_3').html('Zona 3');
				$('#seccion_4').html('Zona 4');
				$('#seccion_5').html('Zona 5');
				$('#seccion_1').html('Zona 1');
				$('#seccion_6').html('Zona 7'); 
				$('#seccion_2').attr('name', '');
				$('#seccion_1').attr('name', '');
				$('#seccion_4').attr('name', '');
				$('#seccion_5').attr('name', '');
				$('#seccion_3').attr('name', '');
				$('#seccion_6').attr('name', '');
			}

			$('#dataTable').fadeIn('slow');
			
			$('#localidad_butaca').html('<center><img src ="imagenes/load22.gif" /></center>');
			if(id == 1){
				var ruta = 'subpages/Conciertos/construir_mapa_w.php';
			}else{
				var ruta = 'subpages/Conciertos/continuacion_asientos_w.php';
			}
			//$('#seccion_'+id).css('width', '300px');
			//$('#seccion_'+id).html('Zona'+id);
			$.ajax({
				type : 'POST',
				url : ruta,
				data : 'id='+id +'&local='+local +'&concierto='+concierto,
				success : function(response){
					$('html, body').animate({ scrollTop: 650 }, 2500);
					$('#localidad_butaca').html(response);
				}
			});
		}

		function irLocalidad(idLoc , idCon){
			window.location = '?modulo=localidad&idLoc='+idLoc+'&idCon='+idCon;
		}
		
		$( window ).scroll(function() {
			if($(window).scrollTop() > 140){
				$('#main-nav').removeClass('affix');
			}
		});
		
		function elimanarsillas(local, concierto, row, col){
			$('#A-'+local+'-'+row+'-'+col).css('background-color','#fff');
			$('#new_selection_'+row+'_'+col+'_'+local).remove();
			
			var numboletos = $('#numboletos'+local).html();
			numboletos = parseInt(numboletos) - parseInt(1);
			$('#numboletos'+local).html(numboletos);
			$('#descripcionsilla'+local).html('');
			
			var contiene_pos_ = $('.contiene_pos_'+local+'_'+row+'_'+col).val();
				
			$.post("subpages/Facturas/quitaPosicion.php",{ 
				contiene_pos_ : contiene_pos_
			}).done(function(data){
				$('.contiene_pos_'+local+'_'+row+'_'+col).val('');
			});
		}
	</script>