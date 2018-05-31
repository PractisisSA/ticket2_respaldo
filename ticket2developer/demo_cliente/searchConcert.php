<?php
	session_start();
	$hoy = date('Y-m-d');
	include '../conexion.php';

	$q = $_POST['q'];

	$sql = 'SELECT idConcierto, strImagen, es_publi, strEvento, dateFecha, timeHora, strLugar FROM Concierto WHERE strEvento LIKE "%'.$q.'%" AND costoEnvioC != 0 AND dateFecha > '.$hoy.'';
	$res = mysql_query($sql);
?>
	<div id="portfolio">
		<div class="container">
			<div class="row">
				<div class="">
					<div class="service-heading">
						<h2>Eventos:</h2>
					</div>
				</div>
			</div>
			<div class="portfolio-thumbnail">
				<div class="container">
					<div class="row">
					<?php
						while ($row = mysql_fetch_array($res)) {
							$es_publi1 = $row['es_publi'];
							if($es_publi1 == 2){
								$envioRuta1 = 'publicacion';
							}else{
								$envioRuta1 = 'evento';
							}
							$imgtriple1 = $row['strImagen'];
							$rutatriple1 = 'spadmin/';
							$rutatriple1 = $rutatriple1.$imgtriple1;
					?>		
						<div class="col-md-3">
							<div class="item" style="padding: 5px !important;">
								<img src="http://ticketfacil.ec/ticket2/<?php echo $rutatriple1;?>" alt="<?php echo $row['strEvento'];?>" style = 'height:100px !important;'/>
								<div class="caption">
									<a href="?modulo=<?php echo $envioRuta1;?>&con=<?php echo $row['idConcierto'];?>">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</a>
									<p><strong><?php echo $row['strEvento'];?></strong></p>
								</div>
							</div>
						</div>
					<?php
						}
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
