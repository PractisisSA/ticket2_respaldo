<?php
	$con = $_REQUEST['con'];
	$sqlC = 'select * from Concierto where idConcierto = "'.$con.'" ';
	$resC = mysql_query($sqlC) or die(mysql_error());
	$rowC = mysql_fetch_array($resC);
	$img = $rowC['strImagen'];
	$ruta = 'http://ticketfacil.ec/ticket2/spadmin/';
	$r = $ruta.$img;
	
	
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
?>
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-10">
			<div id="order-localidad" class="col-md-2"><button type="button" class="btn btn-info btn-arrow-right">LOCALIDAD</button></div>
			<div id="order-asiento" class="col-md-2"><button type="button" class="btn btn-info btn-arrow-right">ASIENTO</button></div>
			<div id="order-identificacion" class="col-md-2"><button type="button" class="btn btn-info btn-arrow-right">IDENTIFICATE</button></div>
			<div id="order-resumen" class="col-md-2"><button type="button" class="btn btn-info btn-arrow-right">RESUMEN</button></div>
			<div id="order-pago" class="col-md-2"><button type="button" class="btn btn-info btn-arrow-right">PAGO</button></div>
			<div id="order-confirmacion" class="col-md-2"><button type="button" class="btn btn-info btn-arrow-right">CONFIRMACIÓN</button></div>
		</div>
		<div class="col-md-1"></div>
	</div>
	<div class="row">
		<div class="col-md-1"></div>
			<div class="col-md-10">
				<div class="row">
				<div class="col-md-5">
					<h1 id="buyOnlineTitle">COMPRA EN LÍNEA:</h1>
				</div>
				<div class="col-md-7">
					<p id="pSelectLoc">Selecciona tu localidad, elije tu asiento favorito y paga con tarjeta de credito, PayPal, transferencia, deposito bancario o acércate a nuestros puntos de venta. Entregamos tus <span>TICKETS A DOMICILIO</span> en todo el pais y tambien los puedes retirar el dia del evento o en nuestros puntos de venta.
					</p>
				</div>
				</div>
				<div class = 'row'>
					<div class = 'col-md-6'>
						<img src="<?php echo $r; ?>" alt="<?php echo $rowC['strEvento'];?>" class="img-rounded">
					</div>
					<div class = 'col-md-6'>
						<h2 id="h2TitleEvent" class="padding-top-1x text-normal"><?php echo $rowC['strEvento'];?></h2>
						<span class="spanAfterTitle"><i class="fa fa-calendar" aria-hidden="true"></i></span> <?php echo obtenerFechaEnLetra($rowC["dateFecha"]);?><br>
						<span class="spanAfterTitle"><i class="fa fa-clock-o" aria-hidden="true"></i></span> <?php echo $rowC["timeHora"];?><br>
						<span class="spanAfterTitle"><i class="fa fa-globe" aria-hidden="true"></i></span> <?php echo $rowC["strLugar"];?><br>
							
						<br>
						<?php 
							echo $rowC['strDescripcion'];
						?>
					</div>
				</div>
			</div>
		<div class="col-md-1"></div>
	</div>
	<br>
	<div class="breadcrumb" id="breadcrumb">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<div class="row">
					<div class="col-md-12">
						<div id="locMap" class="panel panel-primary">SELECCIONA TU LOCALIDAD EN EL MAPA O EN LA TABLA DE PRECIOS</div>
					</div>
				</div>
		<div class="row">
			<div class="col-md-5" style="margin-right: -42px !important;">
				<?php
					$dir = 'spadmin/';
					$imagen = $rowC['strMapaC'];
					$ruta_mapa = $dir.$imagen;
				?>
				<div class="row">
					<div class="col-md-12">
						<div id="mapT" class="panel panel-primary">MAPA DE LOCALIDADES</div>
					</div>
				</div>
				<div id="mapster_wrap_0">
					<img class="mapster_el" src="http://ticketfacil.ec/ticket2/<?php echo $ruta_mapa;?>">
					<img class="mapster_el" style="display: none;" src="spadmin/undefined">
					<canvas width="550" height="415" class="mapster_el" style="position: absolute; left: 0px; top: 0px; padding: 0px; border: 0px none;"></canvas>
					<canvas width="550" height="415" class="mapster_el" style="position: absolute; left: 0px; top: 0px; padding: 0px; border: 0px none;"></canvas>
					<img id="localmapa" src="<?php echo $ruta_mapa;?>" alt="localmapa" usemap="#localmapa">
				</div>
				<map name="localmapa" width='300px'>
					<?php 
						$selectAreas = '
											SELECT strCoordenadasB, datestateL, datafullL, intLocalB, intConcB, idButaca 
											FROM Butaca 
											WHERE intConcB = "'.$con.'"
											AND strEstado = "A" 
											and createbyB > 0 
										';
						$resultSelectAreas = mysql_query($selectAreas) or die (mysql_error());
						while($rowArea = mysql_fetch_array($resultSelectAreas)){
					?>
						<area 
							name="" 
							data-state="<?php echo $rowArea['datestateL'];?>" 
							data-full="<?php echo $rowArea['datafullL'];?>" 
							shape="poly" 
							coords="<?php echo $rowArea['strCoordenadasB'];?>" 
							onclick="irLocalidad('<?php echo $rowArea['intLocalB'];?>','<?php echo $rowArea['intConcB'];?>')" 
							alt = "<?php echo $rowArea['datafullL'];?>"
						/>
					<?php 
						}
					?>
				</map>
			</div>
			<div class="col-md-2"></div>
			<div class="col-md-5" style="color:#fff; ">
				<div class="row">
					<div class="col-md-12">
						<div id="tablePriceTitle" class="panel panel-primary">TABLA DE PRECIOS</div>
					</div>
				</div>
				<input id="concierto" name="concierto" value="<?php echo $con;?>" type="hidden">
				<table id="tablePrice">
					<tr>
						<td class="tdToLeft">
							<span><strong>LOCALIDADES</strong></span>
						</td>
						<td class="tdToLeft">
							<span><strong>DETALLE</strong></span>
						</td>
						<td class="tdToCenter">
							<span><strong>VALOR</strong></span>
						</td>
						<td class="finalTd">
							
						</td>
					</tr>
					<?php
						
						$sqlLo = 'select * from Localidad where idConc = "'.$con.'"';
						$resLo = mysql_query($sqlLo) or die (mysql_error());
						while($rowLo = mysql_fetch_array($resLo)){
					?>
						<tr>
							<td style = 'padding-left: 5px;border: 1px solid #000;'>
								<?php echo $rowLo['strDescripcionL'];?>
								<input type="hidden" id="local<?php echo $rowLo['idLocalidad'];?>" value="<?php  echo $rowLo['strDescripcionL'];?>" />
							</td>
							<td id="tdLoCar">
								<span id="spanLoCar"><?php echo $rowLo['strCaracteristicaL'];?></span>
							</td>
							<td id="datePrev">
								<?php 
									$hoy = date("Y-m-d");
									$dateFechaPreventa = $row['dateFechaPreventa'];
									if($hoy <= $dateFechaPreventa){
										echo $rowLo['doublePrecioPreventa'];
									}else{
										echo $rowLo['doublePrecioL'];
									}
									
								?>
							</td>
							<td id="tdOpenLabel">
								<span class="label label-success span-open-label" onclick="irLocalidad('<?php echo $rowLo['idLocalidad'];?>','<?php echo $con;?>');">Abrir</span>
							</td>
						</tr>
					<?php
						}
						
					?>
				</table>
			</div>
		</div>
			</div>
			<div class="col-md-1"></div>
		</div>
		
	</div>
		</div>
	<div class = 'container'>
		<br><br>
		<br>
	</div>
	<hr />
				<div class = 'row'>
				<?php
					$sqlart = 'SELECT * FROM Artista WHERE intIdConciertoA = "'.$con.'"';
					$resArt = mysql_query($sqlart) or die (mysql_error());
					while($rowart = mysql_fetch_array($resArt)){
				?>
					<div class="col-md-4">
						<div class="row">
							<div class="container">
								<div class="col-md-1 span-social-div" onclick="window.open('<?php echo $rowart['strFacebookA']; ?>','_blank');">
									<br>
									<span class="span-social">
										<i class="fa fa-facebook" aria-hidden="true"></i>
									</span>
								</div>
								<div class="col-md-1 span-social-div" onclick="window.open('<?php echo $rowart['strTwitterA']; ?>','_blank');">
									<br>
									<span class="span-social">
										<i class="fa fa-twitter" aria-hidden="true"></i>
									</span>
								</div>
								<div class="col-md-1 span-social-div" onclick="window.open('<?php echo $rowart['strYoutubeA']; ?>','_blank');">
									<br>
									<span class="span-social">
										<i class="fa fa-youtube" aria-hidden="true"></i>
									</span>
								</div>
								<div class="col-md-1 span-social-div" onclick="window.open('<?php echo $rowart['strInstagramA']; ?>','_blank');">
									<br>
									<span class="span-social">
										<i class="fa fa-instagram" aria-hidden="true"></i>
									</span>
								</div>
								<div class="col-md-2" class="end-social">
									<h2><?php echo $rowart['strNombreA'];?></h2>
								</div>
							</div>
						</div>
					</div>
				<?php
					}
				?>
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
		
		function irLocalidad(idLoc , idCon){
			window.location = '?modulo=localidad&idLoc='+idLoc+'&idCon='+idCon;
		}
		
		$(document).ready(function(){
			var url = window.location.href;
			var last = url.lastIndexOf('?');
			var actualUrl = url.substring(47, 65);
			if (actualUrl == '?modulo=evento&con') {
				$('#order-localidad').html('<button type="button" style="background-color:white!important; color:#46b8da !important;" class="btn btn-info btn-arrow-right">LOCALIDAD</button>');
			}else{
				alert('No');
			}
			$('#localmapa').mapster({
				singleSelect: true,
				render_highlight: {altImage: ruta},
				render_select: false,
				mapkey: 'data-state',
				fill: true,
			});
			
		});
	</script>