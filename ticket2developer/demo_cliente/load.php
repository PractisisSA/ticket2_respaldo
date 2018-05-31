<div id="slider" class="flexslider">
	<div class="container">
		<div class="row">
			<div class="before-slider col-md-9 col-sm-12 col-12">
				<ul class="slides">
					<?php
						$sql = 'SELECT c.idConcierto, c.strImagen , c.es_publi 
								FROM Concierto as c , banner as b
								WHERE c.idConcierto = b.id_con
								ORDER BY RAND()
								';
						$res = mysql_query($sql) or die (mysql_error());
						while($row = mysql_fetch_array($res)){
							$es_publi2 = $row['es_publi'];
							if($es_publi2 == 2){
								$envioRuta2 = 'publicacion';
							}else{
								$envioRuta2 = 'evento';
							}
							$img = $row['strImagen'];
					?>
					<li>
						<a href="?modulo=<?php echo $envioRuta2;?>&con=<?php echo $row['idConcierto'];?>">
							<img class="img-fluid" src="http://ticketfacil.ec/ticket2/spadmin/<?php echo $img;?>" alt = "<?php echo $row['strEvento'];?>">
						</a>
					</li>
					<?php
						}
					?>
				</ul>
			</div>
			<div class="col-md-3 col-sm-12 col-12">
				<?php
					$sqlT = 'SELECT idConcierto, strImagen , es_publi , strEvento , dateFecha , timeHora , strLugar FROM Concierto WHERE costoenvioC = 1 and strCaractristica = "home" ORDER BY dateFecha DESC limit 3';
					$resT = mysql_query($sqlT) or die (mysql_error());
					while($rowT = mysql_fetch_array($resT)){
						$es_publi = $rowT['es_publi'];
						if($es_publi == 2){
							$envioRuta = 'publicacion';
							$txt = 'Ver Mas';
						}else{
							$envioRuta = 'evento';
							$txt = 'Comprar';
						}
						$imgtriple = $rowT['strImagen'];
						$rutatriple = 'spadmin/';
						$rutatriple = $rutatriple.$imgtriple;
				?>		
						<div id="item-css" class="item">
							<a href="?modulo=<?php echo $envioRuta;?>&con=<?php echo $rowT['idConcierto'];?>"><img src="http://ticketfacil.ec/ticket2/<?php echo $rutatriple;?>" alt="<?php echo $rowT['strEvento'];?>" /></a>
							<div class="caption">
								<p><strong><?php echo $rowT1['strEvento'];?></strong></p>
							</div>
						</div>
				<?php
					}
				?>
			</div>
		</div>
	</div>
</div>
<br>
<br>
<br>
<div id="about">
	<div class="container">
		<div class="row">
			<div class="">
				<div class="service-heading">
					<h3>Proximos Eventos</h3>
				</div>
			</div>
		</div>
		<div class="row">
			<?php
				$today = date("Y-m-d");    
				$sqlT = 'SELECT * 
						FROM Concierto 
						WHERE dateFecha >= "'.$today.'"
						and costoenvioC != 0
						ORDER BY dateFecha DESC limit 4
				';
				$resT = mysql_query($sqlT) or die (mysql_error());
				while($rowT = mysql_fetch_array($resT)){
					$es_publi = $rowT['es_publi'];
					if($es_publi == 2){
						$envioRuta = 'publicacion';
						$txt = 'Ver Mas';
					}else{
						$envioRuta = 'evento';
						$txt = 'Comprar';
					}
					$imgtriple = $rowT['strImagen'];
					$rutatriple = 'spadmin/';
					$rutatriple = $rutatriple.$imgtriple;
			?>
					<div class="col-md-3 col-sm-4">
						<div class="card mb-30 tarjeta_new" >
							<a class="card-img-tiles" href="?modulo=<?php echo $envioRuta;?>&con=<?php echo $rowT['idConcierto'];?>">
								<div class="inner">
									<div class="main-img">
										<img src="http://ticketfacil.ec/ticket2/<?php echo $rutatriple;?>" alt="<?php echo $rowT['strEvento'];?>"/>
									</div>
								</div>
							</a>
							<div class="card-body text-center"><br>
								<h4 class="card-title"><?php echo $rowT['strEvento'];?></h4>
								<p class="text-muted"><i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowT['strLugar'];?></p>
								<p class="text-muted">
									<i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $rowT['dateFecha'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $rowT['timeHora'];?>
								</p>
								<a class="btn btn-outline-primary btn-sm a_boton" href="?modulo=<?php echo $envioRuta;?>&con=<?php echo $rowT['idConcierto'];?>"><?php echo $txt;?> <i class="fa fa-shopping-basket" aria-hidden="true"></i></a>
							</div><br>
						</div>
					</div>
			<?php
				}
			?>
		</div>
	</div>
</div>
<div id="prue"></div>
<div id="portfolio">
	<div class="container">
		<div class="row">
			<div id="port">
				<div class="service-heading">
					<h3>Eventos Realizados</h3>
				</div>
			</div>
		</div>
		<div class="portfolio-thumbnail">
			<div class="container-fluid">
				<div class="row">
			<?php
				$sqlT1 = 'SELECT idConcierto, strImagen , es_publi , strEvento , dateFecha , timeHora , strLugar 
						  FROM Concierto 
						  WHERE costoenvioC = 1 
						  ORDER BY RAND()
						  DESC';
				$resT1 = mysql_query($sqlT1) or die (mysql_error());
				while($rowT1 = mysql_fetch_array($resT1)){
					$es_publi1 = $rowT1['es_publi'];
					if($es_publi1 == 2){
						$envioRuta1 = 'publicacion';
					}else{
						$envioRuta1 = 'evento';
					}
					$imgtriple1 = $rowT1['strImagen'];
					$rutatriple1 = 'spadmin/';
					$rutatriple1 = $rutatriple1.$imgtriple1;
			?>
					<div class="col-md-3">
						<div class="item">
							<img src="http://ticketfacil.ec/ticket2/<?php echo $rutatriple1;?>" alt="<?php echo $rowT1['strEvento'];?>"/>
							<div class="caption">
								<a href="?modulo=<?php echo $envioRuta1;?>&con=<?php echo $rowT1['idConcierto'];?>">
									<i class="fa fa-plus" aria-hidden="true"></i>
								</a>
								<p><strong><?php echo $rowT1['strEvento'];?></strong></p>
							</div>
						</div>
					</div>
			<?php
				}
			?>		
				</div>
				<br>
				<center>
					<a class="btn btn-outline-primary btn-sm a_boton" href="eventos.php">VER MAS</a>
				</center>
			</div>
		</div>
	</div>
</div>

<div id="about-bg">

	<div class="container">
		<div class="row">

			<div class="about-bg-heading">
				<h1>ESTADÍSTICAS EXITOSAS SOBRE NOSOTROS</h1>
				<p>LO QUE HEMOS LOGRADO HASTA AHORA</p>
			</div>

			<div class=" col-xs-12 col-md-3">
				<div class="about-bg-wrapper">
				<?php
					$sqlC = 'SELECT count(idCliente) as cuantos_clientes FROM `Cliente` ORDER BY `Cliente`.`idCliente` ASC ';
					$resC = mysql_query($sqlC) or die (mysql_error());
					$rowC = mysql_fetch_array($resC);
					
					
					$sqlC1 = 'SELECT count(idConcierto) as cuantos_eventos FROM `Concierto` ORDER BY idConcierto ASC ';
					$resC1 = mysql_query($sqlC1) or die (mysql_error());
					$rowC1 = mysql_fetch_array($resC1);
					
					
					$sqlC2 = 'SELECT count(idDistribuidor) as cuantos_distri FROM `distribuidor` ORDER BY idDistribuidor ASC ';
					$resC2 = mysql_query($sqlC2) or die (mysql_error());
					$rowC2 = mysql_fetch_array($resC2);
					
					
					$sqlC3 = 'SELECT count(idSocio) as cuantos_socios FROM `Socio` ORDER BY idSocio ASC ';
					$resC3 = mysql_query($sqlC3) or die (mysql_error());
					$rowC3 = mysql_fetch_array($resC3);
				?>
					<span class="count"><h1><?php echo $rowC['cuantos_clientes'];?></h1>
					</span>
					<p>clientes</p>
				</div>
			</div>

			<div class="col-xs-12 col-md-3">
				<div class="about-bg-wrapper">
					<span class="count"><h1><?php echo $rowC1['cuantos_eventos'];?></h1></span>
					<p>eventos</p>
				</div>
			</div>

			<div class="col-xs-12 col-md-3">
				<div class="about-bg-wrapper">
					<span class="count"><h1><?php echo $rowC2['cuantos_distri'];?></h1></span>
					<p>distribuidores</p>
				</div>
			</div>

			<div class="col-xs-12 col-md-3">
				<div class="about-bg-wrapper">
					<span class="count"><h1><?php echo $rowC3['cuantos_socios'];?></h1></span>
					<p>socios</p>
				</div>
			</div>

		</div>
	</div>

	<div class="cover"></div>

</div>