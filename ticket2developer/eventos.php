<?php
	session_start();
	$estado = 'Activo';
	$hoy = date('Y-m-d');
	include 'conexion.php';
	
	$sqlU = 'update Concierto set es_publi = 2 where dateFecha < "'.$hoy.'"';
	 // echo $sqlU."<br><br>";
	$resU = mysql_query($sqlU) or die (mysql_error());
	
	
	
	$sqlU1 = 'update Concierto set es_publi = 1 where dateFecha >= "'.$hoy.'"';
	 // echo $sqlU1."<br><br>";
	$resU1 = mysql_query($sqlU1) or die (mysql_error());
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>ticketfacil.ec 3.0</title>
	<meta name="google-site-verification" content="EkfaLa2r9IE15e84u4tmPalg2ghTF_5m-M-ltQQIk0o" />
	<meta name="keywords" content="tickets , entradas partidos , entradas conciertos , tickets partidos , tickets conciertos , conciertos , eventos , partidos de futbol , convenciones , expociciones , tickets para viajes interprovinciales">
	<meta name="description" content="es un sistema creado para que el publico pueda comprar cualquier clase de ticket a cualquier evento ,espectaculo , partido de futbol , concierto , convencion , expocicion o para comprar tickets para viajes interprovinciales">
	<meta name="author" content="fabricio carrion , practisis s.a.">
	<meta name="copyright" content="fabricio carrion">
	<meta name="robots" content="index, follow">
	<link rel="icon" href="https://livedemo00.template-help.com/landing_58100/images/favicon.ico" type="image/x-icon">
	<meta name="description" content="Free Bootstrap Theme by BootstrapMade.com">
	<meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">
	
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Open+Sans|Raleway" rel="stylesheet">
	<link rel="stylesheet" href="css/flexslider.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style_demo.css">
	<style>
		.a_boton:hover{
			background-color:#00AEEF;
			color:#fff;
		}
		
		.tarjeta_new{
			position: relative;
			display: -ms-flexbox;
			display: flex;
			-ms-flex-direction: column;
			flex-direction: column;
			min-width: 0;
			word-wrap: break-word;
			background-color: #fff;
			background-clip: border-box;border: 1px solid rgba(0,0,0,0.125);
			border-radius: .25rem;
			padding-bottom:15px;
		}
		
		input[type="checkbox"]{ display: none; }
		
		label{
			color:#8e8e8e;
			font-weight:300;
		}

		.entero{
			text-align:center;
		}

		input[type="checkbox"] + label span{
			display: inline-block;
			width: 19px;
			height: 19px;
			background: url(http://ticketfacil.ec/ticket2/spadmin/img/check_radio_sheet.png) 0px top no-repeat;
			margin: -1px 4px 0 0;
			vertical-align: middle;
			cursor:pointer;
		}

		input[type="checkbox"]:checked + label span{
			background: url(http://ticketfacil.ec/ticket2/spadmin/img/check_radio_sheet.png) -19px top no-repeat;
		}
		.cortesia:hover{
			text-decoration:underline;
		}
		
		td{
			border-top: none !important;
		}
	</style>
	
</head>

<body id="top" data-spy="scroll" style = 'overflow-x:hidden;'>
	<!--top header-->

	<?php
		include 'head_demo.php';
	?>

	<div id="portfolio">
		<div class="container">
			<div class="row">

				<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
					<div class="portfolio-heading">
						<h2>eventos</h2>
					</div>
				</div>

			</div>
		</div>

		<div class="portfolio-thumbnail">
			<div class="container-fluid">
				<div class = 'row'>
					<div class = 'col-md-1' ></div>
					<div class = 'col-md-10' >
						<div class="row">
							<?php
								$sqlT1 = '	SELECT idConcierto, strImagen , es_publi , strEvento , dateFecha , timeHora , strLugar 
											FROM Concierto 
											WHERE costoenvioC = 1 
											ORDER BY dateFecha
											DESC';
								$resT1 = mysql_query($sqlT1) or die (mysql_error());
								while($rowT1 = mysql_fetch_array($resT1)){
									$es_publi1 = $rowT1['es_publi'];
									// echo $es_publi."hola";
									if($es_publi1 == 2){
										$envioRuta1 = 'des_pub';
									}else{
										$envioRuta1 = 'des_concierto';
									}
									$imgtriple1 = $rowT1['strImagen'];
									$rutatriple1 = 'spadmin/';
									$rutatriple1 = $rutatriple1.$imgtriple1;
							?>
										<div class="col-md-4" style="border:1px solid #ccc;padding-top:10px;padding-bottom:10px;">
											<div class="item">
												<img src="http://ticketfacil.ec/ticket2/<?php echo $rutatriple1;?>" alt="<?php echo $rowT1['strEvento'];?>" style = 'height:200px !important;'/>
												<div class="caption">
													<a href="?modulo=<?php echo $envioRuta1;?>&con=<?php echo $rowT1['idConcierto'];?>">
														<i class="fa fa-search" aria-hidden="true"></i>
													</a>
												</div>
												
												<div class="card-body text-center"><br>
													<p class="text-muted" style = 'text-transform:uppercase;font-weight:bold;'><i class="fa fa-users" aria-hidden="true"></i> <?php echo $rowT1['strEvento'];?></p>
													<p class="text-muted"><i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowT1['strLugar'];?></p>
													<p class="text-muted">
														<i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $rowT1['dateFecha'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $rowT1['timeHora'];?>
													</p>
												</div>
											</div>
										</div>
							<?php
								}
							?>		
						</div>
					</div>
					<div class = 'col-md-1' ></div>
				</div>
			</div>
		</div>
	</div>
	


	<?php
		include 'footer_demo.php';
	?>


	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.flexslider.js"></script>
	<script src="js/jquery.inview.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8HeI8o-c1NppZA-92oYlXakhDPYR7XMY"></script>
	<script src="js/script.js"></script>
	<script src="contactform/contactform.js"></script>
	<script type="text/javascript" src="js/jquery.numeric.js"></script>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	


</body>

</html>
