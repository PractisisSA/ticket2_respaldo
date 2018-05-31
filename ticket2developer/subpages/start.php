<?php
	session_start();
	$estado = 'Activo';
	$hoy = date('Y-m-d');
	include 'conexion.php';
	
	$sqlU = 'update Concierto set es_publi = 0 where dateFecha < "'.$hoy.'"';
	$resU = mysql_query($sqlU) or die (mysql_error());
	
	
	
	$sqlU1 = 'update Concierto set es_publi = 1 where dateFecha > "'.$hoy.'"';
	$resU1 = mysql_query($sqlU1) or die (mysql_error());
	
	
	
	
	echo '<input type="hidden" id="data" value="1" />';
	if($_SESSION['autentica']== 'tFDiS759'){
		include 'distribuidor/distribuidorindex.php';
	}else{

	$selectSliderStart1 = "SELECT c.idConcierto, c.strImagen , c.es_publi , c.strEvento
				FROM Concierto as c , banner as b
				WHERE c.idConcierto = b.id_con
				ORDER BY dateFecha DESC";
	$resultSlideStar1 = $gbd -> prepare($selectSliderStart1);
	$resultSlideStar1 -> execute();
	$num_imagenes1 = $resultSlideStar1 -> rowCount();
?>
		<style>
			.titulos_promos{
				font-size:16px;
				font-weight:bold;
				color:#4a4s4d;
			}
		</style>
		<?php
		
			
			include 'conexion.php';
			
			
			$sqlConteo = '	
							SELECT count(1) as cuantos
							FROM ganadores_promos
						';
			// echo $sqlConteo."<br>";
			$resConteo = mysql_query($sqlConteo) or die (mysql_error());
			$rowConteo = mysql_fetch_array($resConteo);
			if($rowConteo['cuantos'] > 0){
				$md1 = '7';
				$md2 = '4';
				$md2_ = '';
			}else{
				$md1 = '12';
				$md2 = '4';
				$md2_ = 'display:none;';
			}
	
			$sql1 = 'select count(id) as cuantos from promociones where estado > 0';
			$res1 = mysql_query($sql1) or die (mysql_error());
			$row1 = mysql_fetch_array($res1);
			if($row1['cuantos'] == 0){
				$estilo = '';
				$estilo_ = 'display:none;';
			}else{
				$estilo = 'background-color:#fff;border:1px solid #000;padding:0px;margin:0px;';
			}
			if($row1['cuantos'] > 1){
		?>
			<script type="text/javascript">
				$(function(){
					$('#slider div:gt(0)').hide();
					setInterval(function(){
					  $('#slider div:first-child').fadeOut(0)
						 .next('div').fadeIn(2500)
						 .end().appendTo('#slider');
					}, 10000);
				});
			</script>
		<?php
			}
		?>
				
		
		
		<div class = 'row' style = '<?php echo $estilo_;?>'>
			<div class = 'col-xs-<?php echo $md1;?>' style = '<?php echo $estilo;?>' >
				<div id="slider">
				<?php
					// ini_set('display_startup_errors',1);
					// ini_set('display_errors',1);
					// error_reporting(-1);
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
					
					$sql = '
								select p.* , c.strEvento , l.strDescripcionL , l.idLocalidad , c.idConcierto , c.dateFecha , c.timeHora
								from promociones as p , Concierto as c , Localidad as l
								where p.id_con = c.idConcierto
								and p.id_loc = l.idLocalidad
								and p.estado > 0
							';
					$res = mysql_query($sql) or die (mysql_error());
					
					while($row = mysql_fetch_array($res)){
				?>
				
					<div style = 'padding:15px'>
						<center><label style = 'font-size:2vw;font-weight:bold;color:red;' id = 'titulo_Principal_<?php echo $row['id'];?>' ><?php echo $row['nombre'];?></label></center>
						Por cada <label class = 'titulos_promos' ><?php echo $row['cantidad'];?></label> personas que compren en línea se regalará : 
						<label class = 'titulos_promos' ><?php echo $row['cortesias'];?></label>  entrada (s), 
						para la localidad : <label class = 'titulos_promos' ><?php echo $row['strDescripcionL'];?></label>
						En el evento : <label class = 'titulos_promos' ><?php echo $row['strEvento'];?></label><br>
						Que se realizará el día : <label class = 'titulos_promos' ><?php echo obtenerFechaEnLetra($row['dateFecha']);?></label>
						a las <?php echo $row['timeHora'];?> . Recuerda que esta promoción termina en : <br><br>
							<table style = 'width:100%;'>
								<tr>
									<td width = '33.33%' ></td>
									<td width = '33.33%' class = 'foto_promo color_foto_<?php echo $row['id'];?>' numero_promo = '<?php echo $row['id'];?>'>
										<?php echo $row['reloj'];?>
									</td>
									<td width = '33.33%' ></td>
								</tr>
							</table>
							<br>
						
						Compra tus tickets <label class = 'titulos_promos' onclick = "window.location='?modulo=des_concierto&con=<?php echo $row['idConcierto'];?>'" style = 'cursor:pointer;' >aqui</label>
						y participa en el sorteo <label class = 'titulos_promos' style = 'font-size:11px;color:red;' >(*Aplica a pagos con tarjeta de crédito y paypal)</label>
					</div>
				<?php
					}
				?>
				</div>
			</div>
			<div class = 'col-xs-<?php echo $md2;?>' style = '<?php echo $md2_;?>'>
				<div class = 'contiene_ganadores'>
					<div class="list-group">
						<a name="" class="list-group-item active">
							Ganadores de la promoción
						</a>
							<?php
								$sqlG = 'select * from ganadores_promos GROUP by id_factura order by id_cli DESC';
								$resG = mysql_query($sqlG) or die (mysql_error());
								$pp=1;
								while($rowG = mysql_fetch_array($resG)){
									$sqlCl = 'SELECT * FROM `Cliente` where idCliente = "'.$rowG['id_cli'].'"';
									$resCl = mysql_query($sqlCl) or die (mysql_error());
									$rowCl = mysql_fetch_array($resCl);
									
									if($pp == 1){
										$active = 'active';
									}else{
										$active = '';
									}
							?>	
								<a name="" class="list-group-item" style = "font-size:14px;">
									<span style = 'text-transform:capitalize;' >
										&laquo;<?php echo $rowCl['strNombresC'];?> / 
										<?php echo "Factura : ".$rowG['id_factura'];?>
										&raquo;
									</span>
								</a>
							<?php
									$pp++;
								}
							?>
					</div>
				</div>
			</div>
		</div>
		
		<script>
			$('.foto_promo > img').css('width','350px');
			var altoBanner = $('.contiene_ganadores').height();
			if(altoBanner >= parseInt(306)){
				$('.contiene_ganadores').css('height','306px');
				$('.contiene_ganadores').css('overflow-y','scroll');
			}else{
				$('.contiene_ganadores').css('height','auto');
				$('.contiene_ganadores').css('overflow-y','none');
			}
			
		</script>
<div class="bs-example">
    <div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
    	<!-- Carousel indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			
			<?php for($i = 1; $i < $num_imagenes1; $i++){?>
            <li data-target="#myCarousel" data-slide-to="<?php echo $i;?>"></li>
			<?php }?>
        </ol>   
		
        <div class="carousel-inner" style = 'height: 350px' >
			<?php 
				$counter = 1; 
				while($rowSlide = $resultSlideStar1 -> fetch(PDO::FETCH_ASSOC)){
				$img = $rowSlide['strImagen'];
				$ruta = 'https://www.ticketfacil.ec/ticket2/spadmin/';
				$ruta = $ruta.$img;
				$es_publi = $rowSlide['es_publi'];
				
				if($es_publi == 2){
					$envioRuta = 'des_pub';
				}else{
					$envioRuta = 'des_concierto';
				}
				if($counter == 1){
					echo '<div class="active item">
							<a href="?modulo='.$envioRuta.'&con='.$rowSlide['idConcierto'].'">
								<img src="'.$ruta.'" style="width:100%; overflow:hidden;" alt = "'.$rowSlide['strEvento'].'" title = "asiste al evento : '.$rowSlide['strEvento'].',  que hemos preparado para ti!"/>
							</a>
						</div>';
				}else{
					echo '<div class="item">
							<a href="?modulo='.$envioRuta.'&con='.$rowSlide['idConcierto'].'">
								<img src="'.$ruta.'" style="width:100%; overflow:hidden;" alt = "'.$rowSlide['strEvento'].'"/>
							</a>
						</div>';
				}
				$counter++;
			}?>
        </div>
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>
<div style="width:100%; position:relative; margin-top:-5px;">
	<div id="jcl">
		<div class="custom-container default" style="margin:0px 0px 20px;">
			<a href="#" class="prev" style="text-decoration:none; cursor:pointer;">&lsaquo;</a>
			<div style="width:100%; overflow:hidden;">
				<div class="carousel" style="margin-left:20px;">
					<ul>
						<?php 
							while($rowtriple = $resulttriple -> fetch(PDO::FETCH_ASSOC)){
								$es_publi = $rowtriple['es_publi'];
								if($es_publi == 2){
									$envioRuta = 'des_pub';
								}else{
									$envioRuta = 'des_concierto';
								}
								$imgtriple = $rowtriple['strImagen'];
								$rutatriple = 'https://www.ticketfacil.ec/ticket2/spadmin/';
								$rutatriple = $rutatriple.$imgtriple;	
						?>
								<li>
									<a href="?modulo=<?php echo $envioRuta;?>&con=<?php echo $rowtriple['idConcierto'];?>">
										<img src="<?php echo $rutatriple;?>" alt = '<?php echo "Evento : ".$rowtriple['strEvento'];?>' title = 'asiste al evento : <?php echo $rowtriple['strEvento'];?> , que hemos creado para ti' >
									</a>
								</li>
						<?php 
							}
						?>
					</ul>
				</div>
			</div>
			<a href="#" class="next">&rsaquo;</a>
			<div class="clear" style="text-decoration:none; cursor:pointer;"></div>
		</div>
	</div>
</div>
<div class="proximosConciertos">
	<p>Pr&oacute;ximos Conciertos</p>
</div>    
<?php
	
	while($rowConcierto = $resultDatosConciertoStart1 -> fetch(PDO::FETCH_ASSOC)){
		$es_publi = $rowConcierto['es_publi'];
		//echo $es_publi."hola";
		if($es_publi == 2){
			$envioRuta = 'des_pub';
		}else{
			$envioRuta = 'des_concierto';
		}
		$imgCon = $rowConcierto['strImagen'];
		$rutaCon = 'https://www.ticketfacil.ec/ticket2/spadmin/';
		$rutaCon = $rutaCon.$imgCon;
		echo '<div class="col-sm-3" style ="height:260px">
				<div style="background-color:#fff">
					<div style="height:150px; overflow:hidden; background-color:#000; text-align:center; position:relative;">
						<a style="text-decoration:none;" href="?modulo='.$envioRuta.'&con='.$rowConcierto['idConcierto'].'">
							<img src="'.$rutaCon.'" style="height:100%; overflow:hidden;" alt = "'.$rowConcierto['strEvento'].'"  title = "Asiste al evento :  '.$rowConcierto['strEvento'].' , que hemos creado para ti!" />
						</a>
						<div style="position:absolute; background-color:#050808; margin-top:-60px; margin-left:10px; color:#fff; padding:10px 15px;">
							<strong>'.$rowConcierto['strEvento'].'</strong>
						</div>
					</div>
					<div style="font-size:12px; padding:10px 15px; color:#808284;">
						<p>
							'.$rowConcierto['dateFecha'].'<br>
							'.$rowConcierto['strLugar'].'
						</p>
					</div>
					<div style="margin-top:-20px; padding:10px;">
						<table style="width:100%; color:#808284;">
							<tr>
								<td>
									<a style="text-decoration:none;" href="?modulo='.$envioRuta.'&con='.$rowConcierto['idConcierto'].'">
										<img src="imagenes/masinfo.png" style="max-width:25px;" />&nbsp;m&aacute;s info
									</a>
								</td> 
								<td style="text-align:right;">
									<img src="imagenes/carrito.png" style="max-width:30px;" />
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>';
	}
	echo '</div>';
?>
	<div style = 'background-color:#282b2d;' class = 'row'>
		<br/><br/>
		<div class='proximosConciertos'>
			<p>Eventos Realizados</p>
		</div>    
		
		<br/>
		
		<?php
			
			$sql = 'SELECT * FROM Concierto WHERE dateFecha < "'.$hoy.'" AND strEstado = "'.$estado.'" and costoenvioC > 0 ORDER BY dateFecha DESC';
			//echo $sql;
			$res = mysql_query($sql) or die (mysql_error());
			while($row = mysql_fetch_array($res)){
				$es_publi = $row['es_publi'];
				if($es_publi == 2){
					$envioRuta = 'des_pub';
				}else{
					$envioRuta = 'des_concierto';
				}
				$imgCon = $row['strImagen'];
				$rutaCon = 'https://www.ticketfacil.ec/ticket2/spadmin/';
				$rutaCon = $rutaCon.$imgCon;
				echo'
					<div class="col-sm-3" style ="height:260px">
					<div style="background-color:#fff">
						<div style="height:150px; overflow:hidden; background-color:#000; text-align:center; position:relative;">
							<a style="text-decoration:none;" href="?modulo='.$envioRuta.'&con='.$row['idConcierto'].'">
								<img src="'.$rutaCon.'" style="height:100%; overflow:hidden;" alt = "'.$row['strEvento'].'"/>
							</a>
							<div style="position:absolute; background-color:#050808; margin-top:-60px; margin-left:10px; color:#fff; padding:10px 15px;">
								<strong>'.$row['strEvento'].'</strong>
							</div>
						</div>
						<div style="font-size:12px; padding:10px 15px; color:#808284;">
							<p>
								'.$row['dateFecha'].'<br>
								'.$row['strLugar'].'
							</p>
						</div>
						<div style="margin-top:-20px; padding:10px;">
							<table style="width:100%; color:#808284;">
								<tr>
									<td>
										<a style="text-decoration:none;" href="?modulo='.$envioRuta.'&con='.$row['idConcierto'].'">
											<img src="imagenes/masinfo.png" style="max-width:25px;" />&nbsp;m&aacute;s info
										</a>
									</td> 
									<td style="text-align:right;">
										<img src="imagenes/carrito.png" style="max-width:30px;" />
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				';
			}
		?>
	</div>
<script type="text/javascript">
	$(function() {
		$(".default .carousel").jCarouselLite({
			btnNext: ".default .next",
			btnPrev: ".default .prev"
		});
	});
</script>	               
<?php
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		setTimeout(function(){ 
			$('.next').click();
			setTimeout(function(){ 
				$('.next').click();
				setTimeout(function(){ 
					$('.next').click();
					setTimeout(function(){ 
						$('.next').click();
						setTimeout(function(){ 
							$('.next').click();
							setTimeout(function(){ 
								$('.next').click();
								setTimeout(function(){ 
									$('.next').click();
									setTimeout(function(){ 
										$('.next').click();
										setTimeout(function(){ 
											$('.next').click(); 
										}, 3000); 
									}, 3000); 
								}, 3000); 
							}, 3000); 
						}, 3000); 
					}, 3000); 
				}, 3000); 
			}, 3000); 
		}, 3000);
	});
</script>