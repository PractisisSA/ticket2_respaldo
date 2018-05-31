<?php
	date_default_timezone_set('America/Guayaquil');
	//session_start();
include 'enoc.php';
	/*ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);*/

	require_once('../classes/public.class.php');
	require_once('../classes/private.db.php');
	$init = new InitTicket;

date_default_timezone_set('America/Guayaquil');
	if(array_key_exists('page', $_GET)){
		$subpage = $_GET['page'];
    }
	else{
		$subpage = 'start';
	}
	   
	$subpages = array(
		'start' => 'subpages/inicio.php',
		'somos' => 'subpages/quienes_somos.php',
		'transporte' => 'subpages/transporte.php',
		'bus_paso_1' => 'subpages/bus_disponibilidad.php',
		'bus_paso_2' => 'subpages/bus_disponibilidad_regreso.php',
		'bus_paso_3' => 'subpages/bus_revisar_total_asientos.php',
		'pago_tarjeta' => 'subpages/pagotarjeta.php',
		'gracias_tr' => 'subpages/gracias_pago_tarjeta.php',
		'login' => 'subpages/login_buses.php',
		'cooperativa' => 'subpages/admin/cooperativas.php',
		'coop_det' => 'subpages/admin/ingresoAdmin.php',
		'admin_bus' => 'subpages/coop/admin_bus.php',
		'det_bus' => 'subpages/coop/det_bus.php',
		'crear_ruta' => 'subpages/coop/crear_ruta.php',
		
		'listaCiudades' => 'subpages/coop/listaCiudades.php',
		'verificaDepositos' => 'subpages/coop/verificaDepositos.php',
		'usuariosClaves' => 'subpages/coop/usuariosClaves.php',
		'reportesCoop' => 'subpages/coop/reportesCoop.php',
	
		'viajes' => 'subpages/coop/viajes.php',
		'reportes' => 'subpages/coop/reportes.php',
		'perfil' => 'subpages/coop/perfil.php',
		
	);
	
	if(array_key_exists($subpage, $subpages)) {
		$subpagePath = $subpages[$subpage];
	}
	else{
		$subpagePath = 'fileNotFound.php';
	}
?>

<!DOCTYPE html>
<html>
<head>

<meta name="google-site-verification" content="EkfaLa2r9IE15e84u4tmPalg2ghTF_5m-M-ltQQIk0o" />

<meta name="keywords" content="tickets , entradas partidos , entradas conciertos , tickets partidos , tickets conciertos , conciertos , eventos , partidos de futbol , convenciones , expociciones , tickets para viajes interprovinciales">
<meta name="description" content="es un sistema creado para que el publico pueda comprar cualquier clase de ticket a cualquier evento ,espectaculo , partido de futbol , concierto , convencion , expocicion o para comprar tickets para viajes interprovinciales">
<meta name="author" content="fabricio carrion , practisis s.a.">
<meta name="copyright" content="fabricio carrion">
<meta name="robots" content="index, follow">
<meta http-equiv="content-type" content="text/html;UTF-8">
<meta http-equiv="cache-control" content="cache">
<meta http-equiv="content-language" content="es">
<link rel="icon" href="https://livedemo00.template-help.com/landing_58100/images/favicon.ico" type="image/x-icon">



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<title>Transportes || Ticketfacil.ec</title>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script language="Javascript"  type="text/javascript" src="../js/clockCountdown.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/jquery.imagemapster.js"></script>
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="http://ticketfacil.ec/ticket2/font-awesome-4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" href="css/transporte.css">
<link rel="stylesheet" href="../css/ticketfacilStyles.css">
<script src="../js/jquery.easing-1.3.js"></script>
<script src="../js/jquery.mousewheel-3.1.12.js"></script>
<script src="../js/jquery.jcarousellite.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<style>
	input,textarea{
		font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	}
</style>
</head>

<body style = 'font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;'>
	<div class="container"><!--style = 'width:100%;overflow-x:hidden;padding:0;'-->
		<div class="header-space"></div>
		<header>
			<div class="header-structure">
				<img alt="../logo" src="../gfx/logo.png"/>
			</div>
			<div class="header-structure">
				<div class="header-menu">
					<?php if($_SESSION['autentica'] == 'uzx153'){
							echo utf8_decode($_SESSION['username']);
						}else{
							if($_SESSION['autentica'] == 'SA456'){
								echo utf8_decode($_SESSION['useractual']);
							}else{
								if($_SESSION['autentica'] == 'jag123'){
									echo utf8_decode($_SESSION['useractual']);
								}else{
									if($_SESSION['autentica'] == 'tFSp777'){
										echo utf8_decode($_SESSION['useractual']);
									}else{
										if($_SESSION['autentica'] == 'TfAdT545'){
											echo utf8_decode($_SESSION['useractual']);
										}else{
											if($_SESSION['autentica'] == 'tFDiS759'){
												echo utf8_decode($_SESSION['useractual']);
											}else{
					?>
					<a class="loguearse" href="?page=login">
						LOG IN
					</a>
					<?php } } } } } }?>
				</div>
				<div class="header-menu">
					<?php if($_SESSION['autentica'] == 'uzx153'){?>
						<a class="logout" href="logOut.php">salir(logout)</a>
					<?php 
						}else{
							if($_SESSION['autentica'] == 'SA456'){?>
							<a class="logout" href="logOut.php">salir(logout)</a>
						<?php }else{
							if($_SESSION['autentica'] == 'jag123'){?>
								<a class="logout" href="logOut.php">salir(logout)</a>
							<?php }else{
								if($_SESSION['autentica'] == 'tFSp777'){?>
									<a class="logout" href="logOut.php">salir(logout)</a>
								<?php }else{
									if($_SESSION['autentica'] == 'TfAdT545'){?>
										<a class="logout" href="logOut.php">salir(logout)</a>
									<?php }else{
										if($_SESSION['autentica'] == 'tFDiS759'){?>
											<a class="logout" href="logOut.php">salir(logout)</a>
										<?php }else{?>
					<a class="loguearse" href="?page=newaccount">
						CREAR UNA CUENTA
					</a>
					<?php } } } } } }?>
				</div>
				<div id="trapezoide"></div>
				<div id="paralelogramo"></div>
			</div>
		</header>
		<div class="body">
			<?php if(($_SESSION['autentica'] == 'SA456') && ($_SESSION['page'] == 'sri')){?>
				<nav class="navbar navbar-default">
					<div class="container-fluid">
			
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>

						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a id="menu4" href="?page=Autorizaciones">CREAR AUTORIZACI&Oacute;N</a></li>
								<li><a id="menu6" href="?page=imPrint">DOCUMENTOS</a></li>
								<li><a id="menu23" href="?page=reimpresion">REIMPRESIÓN</a></li>
								<li><a id="menu5" href="?page=transacciones">REGISTRO</a></li>
							</ul>
						</div>
					</div>
				</nav>
			<?php }else if(($_SESSION['autentica'] == 'SA456')){?>
				<nav class="navbar navbar-default">
					<div class="container-fluid">
			
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>

						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a id="menu9" href="?page=cooperativa">REGISTRO COOPERATIVA</a></li>
								<li><a id="menu13" href="?page=listaCiudades">CIUDADES Y TERMINALES</a></li>
								<li><a id="menu14" href="?page=verificaDepositos">VERIFICACION DE DEPOSITOS</a></li>
								<li><a id="menu15" href="?page=usuariosClaves">USUARIOS Y CLAVES</a></li>
								<li><a id="menu16" href="?page=reportesCoop">REPORTES</a></li>
							</ul>
						</div>
					</div>
				</nav>
			<?php }else if($_SESSION['autentica'] == 'jag123'){?>
				<nav class="navbar navbar-default">
					<div class="container-fluid">
			
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>

						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<!--<li><a id="menu1" href="?page=eventosRealizados">EVENTOS REALIZADOS</a></li>-->
								<li><a id="menu10" href="?page=admin_bus">NUEVO BUS</a></li>
								<li><a id="menu11" href="?page=det_bus">BUSES CREADOS</a></li>
								<li><a id="menu12" href="?page=crear_ruta">CREACI&Oacute;N DE RUTAS</a></li>
								<li><a id="menu21" href="?page=viajes">VIAJES CREADOS</a></li>
								<li><a id="menu22" href="?page=reportes">REPORTES</a></li>
								<li><a id="menu23" href="?page=perfil">PERFIL</a></li>
								
								<!--<li><a id="menu2" href="?page=estadisticas">ESTAD&Iacute;STICAS</a></li>-->
							</ul>
						</div>
					</div>
				</nav>
				<?php }else if(($_SESSION['autentica'] == 'tFSp777') && ($_SESSION['page'] == 'sri')){?>
					<nav class="navbar navbar-default">
						<div class="container-fluid">
				
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>

							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li><a id="menu4" href="?page=listaSocio">EMPRESARIO</a></li>
									<li><a id="menu5" href="?page=crearSocio">CREAR EMPRESARIO</a></li>
									<li><a id="menu6" href="?page=ticketFacil">EMPRESA</a></li>
								</ul>
							</div>
						</div>
					</nav>
				<?php }else if(($_SESSION['autentica'] == 'tFSp777') && ($_SESSION['page'] == 'ticket')){?>
					<nav class="navbar navbar-default">
						<div class="container-fluid">
				
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>

							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li><a id="menu1" href="?page=listaUsuarios">USUARIOS</a></li>
									<li><a id="menu2" href="?page=crearUsuarios">CREAR USUARIO</a></li>
									<li><a id="menu3" href="?page=listaEvento">EVENTOS</a></li>
									<li><a id="menu7" href="?page=distribuidor">DISTRIBUIDOR</a></li>
									<li><a id="menu27" href="?page=clona">CLONAR EVENTO</a></li>
									<li><a id="menu8" href="?page=cuenta">CUENTA</a></li>
								</ul>
							</div>
						</div>
					</nav>
				<?php }else if($_SESSION['autentica'] == 'tFDiS759'){?>
					<nav class="navbar navbar-default">
						<div class="container-fluid">
				
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
						<?php
							if($_SESSION['mailuser'] == 'municipio@gmail.com'){
						?>
								<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
									<ul class="nav navbar-nav">
										<li><a id="menu1" href="?page=reportesMun">REPORTES</a></li>
									</ul>
									
								</div>
						<?php
							}else{
								
							
						?>
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li><a id="menu1" href="?page=distribuidorMod">DISTRIBUIDOR</a></li>
								<?php
									if($_SESSION['tipocadena'] == 1){
								?>
									<li><a id="menu25" href="javascript:void(0);" onclick = 'verAyuda()'>AYUDA-SOPORTE</a></li>
									
									<li style = 'display:none;'  class = 'occc'><a id="menu25" href="?page=reportesDistDet" >REPORTES DISTRIBUIDOR</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu23" href="?page=reimprime_dist" >REIMPRESIONES</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu21" href="?page=anula_boletos" >DAR DE BAJA BOLETOS</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu22" href="?page=cambia_usu_boleto" >CAMBIA USURIO BOLETO</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu24" href="?page=ingresa_boletos_distribuidor" >INGRESA BOLETOS</a></li>
									
									
								<?php
									}elseif($_SESSION['tipocadena'] == 2){
								?>
									<li><a id="menu25" href="?page=reportesDistDet">REPORTES DISTRIBUIDOR</a></li>
									<li><a id="menu25" href="javascript:void(0);" onclick = 'verAyuda()'>AYUDA-SOPORTE</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu25" href="?page=reportesDistDet" >REPORTES DISTRIBUIDOR</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu23" href="?page=reimprime_dist" >REIMPRESIONES</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu21" href="?page=anula_boletos" >DAR DE BAJA BOLETOS</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu22" href="?page=cambia_usu_boleto" >CAMBIA USURIO BOLETO</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu24" href="?page=ingresa_boletos_distribuidor" >INGRESA BOLETOS</a></li>
								<?php
									}else{
								?>
									<li><a id="menu25" href="?page=reportesDistDet">REPORTES DISTRIBUIDOR</a></li>
									<li><a id="menu23" href="?page=reimprime_dist">REIMPRESIONES</a></li>
									<li><a id="menu21" href="?page=anula_boletos">DAR DE BAJA BOLETOS</a></li>
									<li><a id="menu22" href="?page=cambia_usu_boleto">CAMBIA USURIO BOLETO</a></li>
									<li><a id="menu24" href="?page=ingresa_boletos_distribuidor">INGRESA BOLETOS</a></li>
								<?php
									}
								?>
								</ul>
								
							</div>
						<?php
							}
						?>
						</div>
					</nav>
				<?php }else if($_SESSION['autentica'] == 'TfAdT545'){?>
					<nav class="navbar navbar-default">
						<div class="container-fluid">
				
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>

							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li><a id="menu1" href="?page=logTributario">L. TRIBUTARIO</a></li>
									<li><a id="menu2" href="?page=logUsuario">L. USUARIOS</a></li>
									<li><a id="menu7" href="?page=logClientes">L. CLIENTES</a></li>
									<li><a id="menu3" href="?page=logAutorizaciones">L. AUTORIZACIONES</a></li>
									<li><a id="menu4" href="?page=logTransaccional">L. TRANSACCIONAL</a></li>
									<li><a id="menu5" href="?page=logAcceso">L. ACCESO</a></li>
									<li><a id="menu6" href="?page=logReimpresiones">L. REIMPRESIONES</a></li>
								</ul>
							</div>
						</div>
					</nav>
				<?php }else{?>
					<nav class="navbar navbar-default">
						<div class="container-fluid">
				
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>

							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li><a id="menu4" href="?page=start">HOME</a></li>
									<li><a id="menu6" href="?page=somos">QUIENES SOMOS</a></li>
									<li><a id="menu7" href="?page=transporte">BUSES</a></li>
									<li><a id="menu5" href="?page=transacciones">PUNTOS DE VENTA</a></li>
									<li><a id="menu5" href="?page=transacciones">CONTACTOS</a></li>
								</ul>
								<!--<form class="navbar-form navbar-left pull-right" role="search">
									<div class="form-group">
										<span class="search-label">BUSCAR:</span> 
										<input type="text" class="form-control search" id="buscar" placeholder="Search">
									</div>
								</form>-->
							</div>
						</div>
					</nav>
				<?php }?>
			<div class="row">
				<input type = 'hidden' value = 'http://ticketfacil.ec/ticket2/pruebas.php?sa=uio&de=gye&esc=uiop@sto_domingo@babahoyo@milagro@pinas@daule@machala'/>
				<?php
				include $subpagePath;
				?>
			</div>
		</div>
		<div class="footer">
			<?php include 'footer.php';?>
		</div>
	</div>
</body>
</html>
<script>
$(document).ready(function (){
	var dato = $('#data').val();
	if(dato == 1){
		$('#flecha1').fadeIn('fast');
		$('#menu1').addClass('allmenuactive');
		$('#menuinf1').addClass('allmenuactive');
	}else{
		if(dato == 2){
			$('#flecha2').fadeIn('fast');
			$('#menu2').addClass('allmenuactive');
			$('#menuinf2').addClass('allmenuactive');
		}else{
			if(dato == 3){
				$('#flecha3').fadeIn('fast');
				$('#menu3').addClass('allmenuactive');
				$('#menuinf3').addClass('allmenuactive');
			}else{
				if(dato == 4){
					$('#flecha4').fadeIn('fast');
					$('#menu4').addClass('allmenuactive');
					$('#menuinf4').addClass('allmenuactive');
				}else{
					if(dato == 5){
						$('#flecha5').fadeIn('fast');
						$('#menu5').addClass('allmenuactive');
						$('#menuinf5').addClass('allmenuactive');
					}else{
						if(dato == 6){
							$('#flecha6').fadeIn('fast');
							$('#menu6').addClass('allmenuactive');
							$('#menuinf6').addClass('allmenuactive');
						}else{
							if(dato == 7){
								$('#flecha7').fadeIn('fast');
								$('#menu7').addClass('allmenuactive');
								$('#menuinf7').addClass('allmenuactive');
							}else{
								if(dato == 8){
									$('#flecha8').fadeIn('fast');
									$('#menu8').addClass('allmenuactive');
									$('#menuinf8').addClass('allmenuactive');
								}else{
									if(dato == 9){
										$('#flecha9').fadeIn('fast');
										$('#menu9').addClass('allmenuactive');
										$('#menuinf9').addClass('allmenuactive');
									}else{
										if(dato == 10){
											$('#flecha10').fadeIn('fast');
											$('#menu10').addClass('allmenuactive');
											$('#menuinf10').addClass('allmenuactive');
										}else{
											if(dato == 11){
												$('#flecha11').fadeIn('fast');
												$('#menu11').addClass('allmenuactive');
												$('#menuinf11').addClass('allmenuactive');
											}else{
												if(dato == 12){
													$('#flecha12').fadeIn('fast');
													$('#menu12').addClass('allmenuactive');
													$('#menuinf12').addClass('allmenuactive');
												}else{
													if(dato == 13){
														$('#flecha13').fadeIn('fast');
														$('#menu13').addClass('allmenuactive');
														$('#menuinf13').addClass('allmenuactive');
													}else{
														if(dato == 14){
															$('#flecha14').fadeIn('fast');
															$('#menu14').addClass('allmenuactive');
															$('#menuinf14').addClass('allmenuactive');
														}else{
															if(dato == 15){
																$('#flecha15').fadeIn('fast');
																$('#menu15').addClass('allmenuactive');
																$('#menuinf15').addClass('allmenuactive');
															}else{
																if(dato == 16){
																	$('#flecha16').fadeIn('fast');
																	$('#menu16').addClass('allmenuactive');
																	$('#menuinf16').addClass('allmenuactive');
																}else{
																	if(dato == 17){
																		$('#flecha17').fadeIn('fast');
																		$('#menu17').addClass('allmenuactive');
																		$('#menuinf17').addClass('allmenuactive');
																	}else{
																		if(dato == 18){
																			$('#flecha18').fadeIn('fast');
																			$('#menu18').addClass('allmenuactive');
																			$('#menuinf18').addClass('allmenuactive');
																		}else{
																			if(dato == 19){
																				$('#flecha19').fadeIn('fast');
																				$('#menu19').addClass('allmenuactive');
																				$('#menuinf19').addClass('allmenuactive');
																			}else{
																				if(dato == 20){
																					$('#flecha20').fadeIn('fast');
																					$('#menu20').addClass('allmenuactive');
																					$('#menuinf20').addClass('allmenuactive');
																				}else{
																					if(dato == 21){
																						$('#flecha21').fadeIn('fast');
																						$('#menu21').addClass('allmenuactive');
																						$('#menuinf21').addClass('allmenuactive');
																					}else{
																						if(dato == 22){
																							$('#flecha22').fadeIn('fast');
																							$('#menu22').addClass('allmenuactive');
																							$('#menuinf22').addClass('allmenuactive');
																						}else{
																							if(dato == 23){
																								$('#flecha23').fadeIn('fast');
																								$('#menu23').addClass('allmenuactive');
																								$('#menuinf23').addClass('allmenuactive');
																							}
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										} 
									}
								}
							}
						}
					}
				}
			}
		}
	}
});
</script>