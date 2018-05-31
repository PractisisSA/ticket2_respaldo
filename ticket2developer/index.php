<?php
date_default_timezone_set('America/Guayaquil');
//session_start();

/*ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);*/

require_once('classes/public.class.php');
require_once('classes/private.db.php');
$init = new InitTicket;

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="google-site-verification" content="EkfaLa2r9IE15e84u4tmPalg2ghTF_5m-M-ltQQIk0o" />

<meta name="keywords" content="tickets , entradas partidos , entradas conciertos , tickets partidos , tickets conciertos , conciertos , eventos , partidos de futbol , convenciones , expociciones , tickets para viajes interprovinciales">
<meta name="description" content="es un sistema creado para que el publico pueda comprar cualquier clase de ticket a cualquier evento ,espectaculo , partido de futbol , concierto , convencion , expocicion o para comprar tickets para viajes interprovinciales">
<meta name="author" content="fabricio carrion , practisis s.a.">
<meta name="copyright" content="fabricio carrion">
<meta name="robots" content="index, follow">
<meta https-equiv="content-type" content="text/html;UTF-8">
<meta https-equiv="cache-control" content="cache">
<meta https-equiv="content-language" content="es">
<link rel="icon" href="https://livedemo00.template-help.com/landing_58100/images/favicon.ico" type="image/x-icon">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>



<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<title>Ticketfacil.ec|inicio</title>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script language="Javascript"  type="text/javascript" src="js/clockCountdown.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/jquery.imagemapster.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/ticketfacilStyles.css">
<script src="js/jquery.easing-1.3.js"></script>
<script src="js/jquery.mousewheel-3.1.12.js"></script>
<script src="js/jquery.jcarousellite.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<style>
	.oc{
		display:none;
	}
</style>

<!-- script google analytic-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-98480554-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- FIN DEL GOOGLE ANALYTICS-->

<!--<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/ef39518edebfc8a9b1f206e3f/3936bbb4f8904a59f63a25793.js");</script>-->
</head>

<body>

	<!--CONTENEDOR DESCUENTO-->
<div style="background-color: rgba(0, 0, 0, 0.8); position: absolute; z-index: 2000;display:none;width:100%;" id="contenedorDescuentos"> <!-- tiene un fondo negro-->
	<span style = 'float:right;color:#fff;font-size:16px;cursor:pointer;padding:5px;' onclick = '$("#contenedorDescuentos").fadeOut("slow")'>X</span>
	<br><div id = 'cuerpoDescuentos' style = 'width:100%;'></div>
</div>
<!--FIN CONTENEDOR DESCUENTO-->

	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.8&appId=420099668326698";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<div class="container">
		<div class="header-space"></div>
		<header>
			<!--LOGO-->
			<div class="header-structure">
				<img alt="logo" src="gfx/logo.png"/>
			</div>
			<!--FIN LOGO-->

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
											if($_SESSION['autentica'] == 'tFDiS759' || $_SESSION['autentica'] == 'tFADMIN_SOCIO' || $_SESSION['autentica'] == 'dist_domi' || $_SESSION['autentica'] == 'Municipio'){
												echo utf8_decode($_SESSION['useractual']);
											}else{
											?>
												<a class="loguearse" href="?modulo=login">
													LOG IN
												</a>
											<?php 
											} 
										} 
									} 
								} 
							} 
						}?>
				</div>

				<div class="header-menu">
					<?php if($_SESSION['autentica'] == 'uzx153'){?>
						<a class="logout" href="controlusuarios/salir.php">salir(logout)</a>
					<?php 
						}else{
							if($_SESSION['autentica'] == 'SA456'){?>
							<a class="logout" href="controlusuarios/salir.php">salir(logout)</a>
						<?php }else{
							if($_SESSION['autentica'] == 'jag123'){?>
								<a class="logout" href="controlusuarios/salir.php">salir(logout)</a>
							<?php }else{
								if($_SESSION['autentica'] == 'tFSp777'){?>
									<a class="logout" href="controlusuarios/salir.php">salir(logout)</a>
								<?php }else{
									if($_SESSION['autentica'] == 'TfAdT545'){?>
										<a class="logout" href="controlusuarios/salir.php">salir(logout)</a>
									<?php }else{
										if($_SESSION['autentica'] == 'tFDiS759' || $_SESSION['autentica'] == 'tFADMIN_SOCIO' || $_SESSION['autentica'] == 'dist_domi' || $_SESSION['autentica'] == 'Municipio'){?>
											<a class="logout" href="controlusuarios/salir.php">salir(logout)</a>
										<?php }else{?>
					<a class="loguearse" href="?modulo=newaccount">CREAR UNA CUENTA</a>
											<?php 
											} 
										} 
									} 
								} 
							} 
						}?>
				</div>
				<div id="trapezoide"></div>
				<div id="paralelogramo"></div>
			</div>
		</header>

		<div class="body">
			<?php if(($_SESSION['autentica'] == 'SA456') && ($_SESSION['modulo'] == 'sri')){?>
				
				<!-- MENU SISTEMA-->
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
								<li><a id="menu4" href="?modulo=Autorizaciones">CREAR AUTORIZACI&Oacute;N</a></li>
								<li><a id="menu6" href="?modulo=imPrint">DOCUMENTOS</a></li>
								<li><a id="menu23" href="?modulo=reimpresion">REIMPRESIÓN</a></li>
								<li><a id="menu5" href="?modulo=transacciones">REGISTRO</a></li>
							</ul>
						</div>
					</div>
				</nav>
				<!-- FIN MENU SISTEMA-->

			<?php }else if(($_SESSION['autentica'] == 'SA456') && ($_SESSION['modulo'] == 'ticket')){?>
				
				<!-- MENU SISTEMA-->
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
							<!--  MENU SI ES ADMINISTRADOR-->
							<ul class="nav navbar-nav">
								
								<li><a id="menu2" href="?modulo=listaConciertos">EVENTOS</a></li>
								<li><a id="menu12" href="?modulo=CreacionConciertos">CREAR CONCIERTO</a></li>
								<li><a id="menu11" href="?modulo=CreacionPublicaciones">CREAR PUBLICACI&Oacute;N</a></li>
								<li><a id="menu11" href="?modulo=equipos">EQUIPOS</a></li>
								<li class="dropdown">
										<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											MEMBRESÍAS/SOCIOS <span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li><a id="menu46" href="#">REGISTRAR</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu46" href="?modulo=valores">VALORES</a></li>
										</ul>
									</li>
							</ul>
							<!-- FIN DE MENU SI ES ADMINISTRADOR-->
						</div>
					</div>
				</nav>
				<!-- FIN MENU SISTEMA-->
			<?php }else if($_SESSION['autentica'] == 'jag123'){?>
				
				<!-- MENU SISTEMA-->
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

						<!-- MENU SI ES SOCIO-->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a id="menu81" href="?modulo=impresionesDistUnico">IMPRESIONES POR DISTRIBUIDOR</a></li>
								<li><a id="menu80" href="?modulo=membresias">MEMBRESÍAS</a></li>
								<li><a id="menu83" href="?modulo=membresia_socio">MEMBRESÍAS - SOCIOS </a></li>
								<li class="dropdown">
									<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										REPORTES<span class="caret"></span>
									</a>
									<ul class="dropdown-menu">
										<li><a id="menu46" href="?modulo=impresionesDistUnico">REPORTES SOCIOS</a></li>
										<li role="separator" class="divider"></li>
										<li><a id="menu46" href="?modulo=impresionesSelfDistribuidor">REPORTES PUNTO DE VENTA</a></li>
									</ul>
								</li>
								<li><a id="menu31" href="?modulo=dar_de_baja">DAR DE BAJA</a></li>
								<li><a id="menu31" href="?modulo=equipos">EQUIPOS</a></li>
								<li class="dropdown">
									<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										MEMBRESÍAS/SOCIOS <span class="caret"></span>
									</a>
									<ul class="dropdown-menu">
										<li><a id="menu46" href="#">REGISTRAR</a></li>
										<li role="separator" class="divider"></li>
										<li><a id="menu46" href="?modulo=valores">VALORES</a></li>
									</ul>
								</li>
								<li class="dropdown">
									<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										VENTAS <span class="caret"></span>
									</a>
									<ul class="dropdown-menu">
										<li><a id="menu46" href="?modulo=impresionesDistribuidorEmpresario">REPORTE DE VENTAS POR PUNTO DE VENTA</a></li>
										<li role="separator" class="divider"></li>
										<li><a id="menu46" href="#">REPORTE DE VENTAS CONSOLIDADAS</a></li>
									</ul>
								</li>
							</ul>
						</div>
						<!-- FIN DE MENU SI ES SOCIO-->
					</div>
				</nav>
				<!-- FIN MENU SISTEMA-->

				<?php }else if(($_SESSION['autentica'] == 'tFSp777') && ($_SESSION['modulo'] == 'sri')){?>
					
				<!-- MENU SISTEMA-->
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
									<li><a id="menu4" href="?modulo=listaSocio">EMPRESARIO</a></li>
									<li><a id="menu5" href="?modulo=crearSocio">CREAR EMPRESARIO</a></li>
									<li><a id="menu6" href="?modulo=ticketFacil">EMPRESA</a></li>
								</ul>
							</div>
						</div>
					</nav>
				<!-- FIN MENU SISTEMA-->
				<?php }
				
				else if($_SESSION['autentica'] == 'dist_domi'){?>

				<!-- MENU SISTEMA-->
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
									<li><a id="menu42" href="?modulo=pagos_stripe">IMPRESIONES PAGOS POR DEPOSITO</a></li>
									<li><a id="menu42" href="?modulo=pagos_stripe">IMPRESIONES DOMICILIO TARJETAS</a></li>
									<li><a id="menu37" href="?modulo=pagos_paypal">IMPRESIONES DOMICILIO PAYPAL</a></li>
									<li><a id="menu52" href="?modulo=pagos_transferencia">IMPRESIONES DOMICILIO TRANSFERENCIA</a></li>
								</ul>
							</div>
						</div>
					</nav>
				<!-- FIN MENU SISTEMA-->
				<?php }
				
				
				
				else if($_SESSION['autentica'] == 'Municipio'){?>
					
					<!-- MENU SISTEMA-->
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
									<li><a id="menu50" href="?modulo=reportesMunicipio">REPORTES MUNICIPIO</a></li>
								</ul>
							</div>
						</div>
					</nav>
					<!-- FIN MENU SISTEMA-->
				<?php }
				
				else if(($_SESSION['autentica'] == 'tFSp777') && ($_SESSION['modulo'] == 'ticket')){?>
					<style>
						.dropdown-submenu {
					position: relative;
					}

					.dropdown-submenu>.dropdown-menu {
					top: 0;
					left: 100%;
					margin-top: -6px;
					margin-left: -1px;
					-webkit-border-radius: 0 6px 6px 6px;
					-moz-border-radius: 0 6px 6px;
					border-radius: 0 6px 6px 6px;
					}

					.dropdown-submenu:hover>.dropdown-menu {
					display: block;
					}

					.dropdown-submenu>a:after {
					display: block;
					content: " ";
					float: right;
					width: 0;
					height: 0;
					border-color: transparent;
					border-style: solid;
					border-width: 5px 0 5px 5px;
					border-left-color: #ccc;
					margin-top: 5px;
					margin-right: -10px;
					}

					.dropdown-submenu:hover>a:after {
					border-left-color: #fff;
					}

					.dropdown-submenu.pull-left {
					float: none;
					}

					.dropdown-submenu.pull-left>.dropdown-menu {
					left: -100%;
					margin-left: 10px;
					-webkit-border-radius: 6px 0 6px 6px;
					-moz-border-radius: 6px 0 6px 6px;
					border-radius: 6px 0 6px 6px;
					}


					</style>
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
									
									<li class="dropdown">
										<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											ADMIN EVENTOS <span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li><a id="menu46" href="?modulo=mueve_pcx">QUITAR INACTIVOS E INFORMACION BASURA</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu40" href="?modulo=admin_banner">DISENO Y ADMINISTRACION DE BANER PRINCIPAL</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu27" href="?modulo=clona">DUPLICAR EVENTO</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu12" href="?modulo=CreacionConciertos">CREAR EVENTO</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu11" href="?modulo=CreacionPublicaciones">CREAR PUBLICACIÓN</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu34" href="?modulo=listaConciertos">EDITAR EVENTO</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu64" href="?modulo=promociones">PROMOCIONES</a></li>
											
											<li role="separator" class="divider"></li>
											<li><a id="menu64" href="?modulo=membresias">MEMBRESÍAS</a></li>
											
											<li role="separator" class="divider"></li>
											<li><a id="menu64" href="?modulo=pagar_membresias">PAGOS MEMBRESÍAS(EXCEL)</a></li>
											
											<li role="separator" class="divider"></li>
											<li><a id="menu64" href="?modulo=membresia_socio">MEMBRESÍAS - SOCIOS</a></li>
										</ul>
									</li>
									
									
									
									<li class="dropdown">
										<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											ADMIN USUARIOS <span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li class="dropdown-submenu">
												<a tabindex="-1" href="#">ADMINISTRACION EMPRESARIOS</a>
												<ul class="dropdown-menu">
													<li><a id="menu5" href="?modulo=crearSocio">CREAR EMPRESRIO</a></li>
													<li role="separator" class="divider"></li>
													<li><a id="menu4" href="?modulo=listaSocio">EDITAR EMPRESARIO</a></li>
													<li role="separator" class="divider"></li>
													
												</ul>
											</li>
											<li role="separator" class="divider"></li>
											<li class="dropdown-submenu">
												<a tabindex="-1" href="#">GESTION DISTRIBUIDORES</a>
												<ul class="dropdown-menu">
													<li><a id="menu33" href="?modulo=distribuidor">DISTRIBUIDORES</a></li>
													<li role="separator" class="divider"></li>
													<li><a id="menu32" href="?modulo=ingresa_boletos_distribuidor_tf">INGRESA BOLETOS</a></li>
													<li role="separator" class="divider"></li>
												</ul>
											</li>
											<li role="separator" class="divider"></li>
											<li class="dropdown-submenu">
												<a tabindex="-1" href="#">GESTION ADMINSITRADORES</a>
												<ul class="dropdown-menu">
													<li><a id="menu33" href="?modulo=ver_admin">EDITAR ADMINISTRADORES</a></li>
													<li role="separator" class="divider"></li>
													<li><a id="menu32" href="?modulo=nuevo_admin">CREAR ADMINISTRADOR</a></li>
													<li role="separator" class="divider"></li>
												</ul>
											</li>
											<li role="separator" class="divider"></li>
											<li><a id="menu1" href="?modulo=listaUsuarios">GESTION USUARIOS</a></li>
											<li role="separator" class="divider"></li>
											
											<!--<li><a id="menu26" href="?modulo=actualiza">MODIFICA CLAVES</a></li>
											<li role="separator" class="divider"></li>-->
											
											<li><a id="menu35" href="?modulo=crearUsuarios">CREAR USUARIO</a></li>
											<li role="separator" class="divider"></li>

											<li class="dropdown-submenu">
												<a tabindex="-1" href="#">GESTION TIPOS DE SOCIOS</a>
												<ul class="dropdown-menu">
													<li><a id="menu33" href="#">EDITAR TIPOS DE SOCIOS</a></li>
													<li role="separator" class="divider"></li>
													<li><a id="menu32" href="?modulo=add_tipo_socio">CREAR TIPOS DE SOCIOS</a></li>
													<li role="separator" class="divider"></li>
												</ul>
											</li>
										</ul>
									</li>

									<li class="dropdown">
										<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											CREACION DE SISTEMA <span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li><a id="menu30" href="?modulo=cuenta">CONFIGURACION CUENTA BANCARIA</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu6" href="?modulo=ticketFacil" >EMPRESA</a></li>
											<li role="separator" class="divider"></li>
										</ul>
									</li>
									
									
									<li class="dropdown">
										<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											VENTAS Y REPORTES <span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li><a id="menu38" href="?modulo=cierre_caja">CIERRE DE CAJA</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu1" href="?modulo=Rdepositos">CONFIRMACION DE DEPOSITO BANCARIO</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu31" href="?modulo=dar_de_baja">DAR DE BAJA BOLETOS SOBRANTES</a></li>
											<li role="separator" class="divider"></li>
											
											<li><a id="menu97" href="?modulo=reimpresionLote">REIMPRESIONES LOTE</a></li>
											<li role="separator" class="divider"></li>
											
											<li class="dropdown-submenu">
												<a tabindex="-1" href="#">REPORTES FORMAS DE PAGO</a>
												<ul class="dropdown-menu">
													<li><a id="menu52" href="?modulo=pagos_transferencia">DEPOSITO - TRANSFERENCIA</a></li>
													<li role="separator" class="divider"></li>
													<li><a id="menu37" href="?modulo=pagos_paypal">PAYPAL</a></li>
													<li role="separator" class="divider"></li>
													<li><a id="menu42" href="?modulo=pagos_stripe">TARJETA DE CREDITO</a></li>
													<li role="separator" class="divider"></li>
													
													<li><a id="menu62" href="?modulo=pagos_web_">VENTAS WEB(TODAS)</a></li>
													<li role="separator" class="divider"></li>
												</ul>
											</li>
											<li role="separator" class="divider"></li>
											<li class="dropdown-submenu">
												<a tabindex="-1" href="#">VENTAS</a>
												<ul class="dropdown-menu">
													<li><a id="menu52" href="?modulo=reporteSri">REPORTE CONSOLIDADO DE VENTAS</a></li>
													<li role="separator" class="divider"></li>
													<li><a id="menu42" href="?modulo=impresionesDistribuidor">IMPRESIONES PUNTOS DE VENTA</a></li>
													<li role="separator" class="divider"></li>
													<li><a id="menu38" href="?modulo=ventasPorDistribuidor">REPORTES PUNTOS DE VENTA</a></li>
													<li role="separator" class="divider"></li>
													
													<li><a id="menu38" href="?modulo=resumenPuntosVenta">RESUMEN DE PUNTOS DE VENTA</a></li>
													<li role="separator" class="divider"></li>
												</ul>
											</li>
											<li role="separator" class="divider"></li>
										</ul>
									</li>
									
									<li class="dropdown">
										<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											MODULO SRI <span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li><a id="menu50" href="?modulo=Autorizaciones">CREAR AUTORIZACIÓN</a></li>
											<li role="separator" class="divider"></li>
										</ul>
									</li>
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
										<li><a id="menu1" href="?modulo=reportesMun">REPORTES</a></li>
									</ul>
									
								</div>
						<?php
							}else{
								
							
						?>
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li><a id="menu1" href="?modulo=distribuidorMod">DISTRIBUIDOR</a></li>
								<?php
									if($_SESSION['tipocadena'] == 1){
								?>
									<li><a id="menu25" href="javascript:void(0);" onclick = 'verAyuda()'>AYUDA-SOPORTE</a></li>
									
									<li style = 'display:none;'  class = 'occc'><a id="menu25" href="?modulo=reportesDistDet" >REPORTES DISTRIBUIDOR</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu23" href="?modulo=reimprime_dist" >REIMPRESIONES</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu21" href="?modulo=anula_boletos" >DAR DE BAJA BOLETOS</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu22" href="?modulo=cambia_usu_boleto" >CAMBIA USURIO BOLETO</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu24" href="?modulo=ingresa_boletos_distribuidor" >INGRESA BOLETOS</a></li>
									
									
								<?php
									}elseif($_SESSION['tipocadena'] == 2){
								?>
									<li><a id="menu25" href="?modulo=reportesDistDet">REPORTES DISTRIBUIDOR</a></li>
									<li><a id="menu25" href="javascript:void(0);" onclick = 'verAyuda()'>AYUDA-SOPORTE</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu25" href="?modulo=reportesDistDet" >REPORTES DISTRIBUIDOR</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu23" href="?modulo=reimprime_dist" >REIMPRESIONES</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu21" href="?modulo=anula_boletos" >DAR DE BAJA BOLETOS</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu22" href="?modulo=cambia_usu_boleto" >CAMBIA USURIO BOLETO</a></li>
									<li style = 'display:none;'  class = 'occc'><a id="menu24" href="?modulo=ingresa_boletos_distribuidor" >INGRESA BOLETOS</a></li>
								<?php
									}else{
								?>
									<li><a id="menu25" href="?modulo=reportesDistDet">REPORTES DISTRIBUIDOR</a></li>
									
									
									<li class="dropdown">
										<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											REIMPRESIONES <span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li role="separator" class="divider"></li>
											<li><a id="menu23" href="?modulo=reimprime_dist">REIMPRESIONES NORMAL</a></li>
											<li role="separator" class="divider"></li>
											
											<li><a id="menu97" href="?modulo=reimpresionLote">REIMPRESIONES LOTE</a></li>
											<li role="separator" class="divider"></li>
										</ul>
									</li>
									
									
									
									
									<!--<li><a id="menu21" href="?modulo=anula_boletos">DAR DE BAJA BOLETOS</a></li>-->
									<li><a id="menu31" href="?modulo=dar_de_baja">DAR DE BAJA BOLETOS</a></li>
									<li><a id="menu22" href="?modulo=cambia_usu_boleto">CAMBIA USURIO BOLETO</a></li>
									<li><a id="menu24" href="?modulo=ingresa_boletos_distribuidor">INGRESA BOLETOS</a></li>
									<li><a id="menu38" href="?modulo=cierre_caja">CIERRE DE CAJA</a></li> 
									<li><a id="menu39" href="?modulo=reporte_cierre_caja">REPORTE CIERRES DE CAJA</a></li> 
									<li><a id="menu45" href="?modulo=reporte_canjes">REPORTE CANJES</a></li>
									<li><a id="menu36" href="?modulo=impresionesSelfDistribuidor">IMPRESIONES POR DISTRIBUIDOR</a></li> 
									
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
									<li><a id="menu1" href="?modulo=logTributario">L. TRIBUTARIO</a></li>
									<li><a id="menu2" href="?modulo=logUsuario">L. USUARIOS</a></li>
									<li><a id="menu7" href="?modulo=logClientes">L. CLIENTES</a></li>
									<li><a id="menu3" href="?modulo=logAutorizaciones">L. AUTORIZACIONES</a></li>
									<li><a id="menu4" href="?modulo=logTransaccional">L. TRANSACCIONAL</a></li>
									<li><a id="menu5" href="?modulo=logAcceso">L. ACCESO</a></li>
									<li><a id="menu6" href="?modulo=logReimpresiones">L. REIMPRESIONES</a></li>
								</ul>
							</div>
						</div>
					</nav>
				<?php }elseif($_SESSION['autentica'] == 'tFADMIN_SOCIO'){
				?>
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
							<?php
								session_start();
								include 'conexion.php';
								$sqlM = 'select * from modulo_admin where id_usuario = "'.$_SESSION['iduser'].'" ';
								$resM = mysql_query($sqlM) or die (mysql_error());
								while($rowM = mysql_fetch_array($resM)){
									$sqlM1 = 'select * from modulos where id = "'.$rowM['id_modulo'].'" order by nombre ASC';
									$resM1 = mysql_query($sqlM1) or die (mysql_error());
									$rowM1 = mysql_fetch_array($resM1);
									if($rowM1['id'] == 2){
										$menu = 27;
									}
									if($rowM1['id'] == 3){
										$menu = 31;
									}
									
									if($rowM1['id'] == 4){
										$menu = 2;
									}
									
									if($rowM1['id'] == 5){
										$menu = 12;
									}
									
									if($rowM1['id'] == 6){
										$menu = 4;
									}
							?>
									<li><a id="menu<?php echo $menu;?>" href="<?php echo $rowM1['ruta'];?>"><?php echo $rowM1['nombre'];?></a></li>
							<?php
								}
							?>
								</ul>
							</div>
						</div>
					</nav>
				<?php
				}else{?>
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

							<!--Aqui esta el menu principal del sitio-->
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li><a id="menu1" href="?modulo=start">HOME</a></li>
									<li><a id="menu2" href="?modulo=somos">QUIENES SOMOS</a></li>
									<li><a id="menu3" href="?modulo=conciertos">EVENTOS</a></li>
									<li style = "display:none;"><a id="menu4" href="?modulo=pventa">PUNTOS DE VENTA</a></li>
									<li><a id="menu9" href="?modulo=servicios">SERVICIOS</a></li>
									<li><a id="menu5" href="?modulo=contactos">CONTACTOS</a></li>
									<li><a id="menu19" href="https://www.ticketfacil.ec/terminosycondiciones/">TERMINOS Y CONDICIONES</a></li>
									
									<?php if($_SESSION['autentica'] == 'uzx153'){?>
									<!--<li><a id="menu6" href="?modulo=miperfil">MI PERFIL</a></li>
									<li><a id="menu7" href="?modulo=asignartickets">TICKETS</a></li>-->
									<?php }?>
								</ul>
								<!--<form class="navbar-form navbar-left pull-right" role="search">
									<div class="form-group">
										<span class="search-label">BUSCAR:</span> 
										<input type="text" class="form-control search" id="buscar" placeholder="Search">
									</div>
								</form>-->
							</div>
							<!--fin del menu principal del sitio-->



						</div>
					</nav>
				<?php }?>
			<div class="row">
				<?php
				include($init -> subpagePath);
				?>
			</div>
		</div>
		<div class="modal fade" id="ayuda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<img src="imagenes/ticketfacilnegro.png" width='100px' />
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body" style='padding:0px;'>
						<div style="font-size: 20px;text-align:center;padding-top: 20px;padding-bottom: 20px">Si tuvo algun inconveniente o quejas por el servicio favor comicarse con nosotros al 026009890 que gustosos le atenderemos.</div>
					</div>
					<div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		
		
		
		<div class="modal fade" id="menuActiva" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<img src="imagenes/ticketfacilnegro.png" width='100px' />
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body" style="padding-top: 30px; text-align: center;padding-bottom: 30px">
						<input autofocus="autofocus" id="btnAyudaMenu" placeholder="Por favor ingrese la clave" style="width: 90%;height: 50px;text-align: center; border: 1px solid #ccc" type="password" />
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" onclick = 'muestraMenu()'>Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		
	<!--comienzo del footer-->	
		<div class="footer">
			<table class="table table-responsive">
				<tr>
					<td style="padding-left:75px;">
						<img alt="logo" src="gfx/logo.png"/>
						<div class="larger">
							026009889<br/>
						</div>
						<div class="thinner">
							info@ticketfacil.ec
						</div>
					</td>
					<td style="padding-top:75px;">
						<?php if(($_SESSION['autentica'] == 'SA456') && ($_SESSION['modulo'] == 'sri')){?>
							<p><img src="imagenes/flecha.png" id="flecha4" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf4" href="?modulo=Autorizaciones">Crear Autorizaci&oacute;n</a></p>
							<p><img src="imagenes/flecha.png" id="flecha6" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf6" href="?modulo=imPrint">Documentos</a></p>
							<p><img src="imagenes/flecha.png" id="flecha7" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf7" href="?modulo=imPrint">Reimpresi&oacute;n</a></p>
							<p><img src="imagenes/flecha.png" id="flecha5" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf5" href="?modulo=transacciones">Transacciones</a></p>
						<?php }else if(($_SESSION['autentica'] == 'SA456') && ($_SESSION['modulo'] == 'ticket')){?>
							<p><img src="imagenes/flecha.png" id="flecha1" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf1" href="?modulo=Rdepositos">Dep&oacute;sitos</a></p>
							<p><img src="imagenes/flecha.png" id="flecha2" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf2" href="?modulo=listaConciertos">Conciertos</a></p>
							<p><img src="imagenes/flecha.png" id="flecha12" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf12" href="?modulo=CreacionConciertos">Crear Concierto</a></p>
							<p><img src="imagenes/flecha.png" id="flecha11" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf11" href="?modulo=CreacionPublicaciones">Crear Publicaci&oacute;n</a></p>
						<?php }else if($_SESSION['autentica'] == 'jag123'){?>
							<!--<p><img src="imagenes/flecha.png" id="flecha1" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf1" href="?modulo=eventosRealizados">Eventos Realizados</a></p>-->
							<p><img src="imagenes/flecha.png" id="flecha2" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf2" href="?modulo=estadisticas">Estad&iacute;sticas</a></p>
						<?php }else if(($_SESSION['autentica'] == 'tFSp777') && ($_SESSION['modulo'] == 'sri')){?>
							<p><img src="imagenes/flecha.png" id="flecha4" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf4" href="?modulo=listaSocio">Empresario</a></p>
							<p><img src="imagenes/flecha.png" id="flecha5" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf5" href="?modulo=crearSocio">Crear Empresario</a></p>
							<p><img src="imagenes/flecha.png" id="flecha6" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf6" href="?modulo=ticketFacil">Empresa</a></p>
						<?php }else if(($_SESSION['autentica'] == 'tFSp777') && ($_SESSION['modulo'] == 'ticket')){?>
							<p><img src="imagenes/flecha.png" id="flecha1" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf1" href="?modulo=listaUsuarios">Usuarios</a></p>
							<p><img src="imagenes/flecha.png" id="flecha2" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf2" href="?modulo=crearUsuarios">Crear Usuario</a></p>
							<p><img src="imagenes/flecha.png" id="flecha3" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf3" href="?modulo=listaEvento">Conciertos</a></p>
							<p><img src="imagenes/flecha.png" id="flecha7" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf7" href="?modulo=distribuidor">Distribuidor</a></p>
							<p><img src="imagenes/flecha.png" id="flecha8" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf8" href="?modulo=reportes">Reportes</a></p>
						<?php }else if($_SESSION['autentica'] == 'tFDiS759'){?>
							<p><img src="imagenes/flecha.png" id="flecha1" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf1" href="?modulo=listaUsuarios">Distribuidor</a></p>
						<?php }else if($_SESSION['autentica'] == 'TfAdT545'){?>
							<p><img src="imagenes/flecha.png" id="flecha1" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf1" href="?modulo=logTributario">Log Tributario</a></p>
							<p><img src="imagenes/flecha.png" id="flecha2" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf2" href="?modulo=logUsuario">Log de Usuarios</a></p>
							<p><img src="imagenes/flecha.png" id="flecha7" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf7" href="?modulo=logClientes">Log de Clientes</a></p>
							<p><img src="imagenes/flecha.png" id="flecha3" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf3" href="?modulo=logAutorizaciones">Log de Autorizaciones</a></p>
							<p><img src="imagenes/flecha.png" id="flecha4" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf4" href="?modulo=logTransaccional">Log Transaccional</a></p>
							<p><img src="imagenes/flecha.png" id="flecha5" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf5" href="?modulo=logAcceso">Log de Acceso</a></p>
							<p><img src="imagenes/flecha.png" id="flecha6" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf6" href="?modulo=logReimpresiones">Reimpresiones</a></p>
						<?php }else{?>
							<p><img src="imagenes/flecha.png" id="flecha1" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf1" href="?modulo=start">HOME</a></p>
							<p><img src="imagenes/flecha.png" id="flecha2" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf2" href="?modulo=somos">QUIENES SOMOS</a></p>
							<p><img src="imagenes/flecha.png" id="flecha3" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf3" href="?modulo=conciertos">EVENTOS</a></p>
							<p style = "display:none;"><img src="imagenes/flecha.png" id="flecha4" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf4" href="?modulo=pventa">PUNTOS DE VENTA</a></p>
							<p><img src="imagenes/flecha.png" id="flecha5" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf5" href="?modulo=contactos">CONTACTOS</a></p>
							<p><img src="imagenes/flecha.png" id="flecha19" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf19" href="https://www.ticketfacil.ec/terminosycondiciones/">TERMINOS Y CONDICIONES</a></p>
						<?php }?>
					</td>
					<td style="padding-top:75px; padding-left:75px;">
						<i onclick="window.open('https://www.facebook.com/TicketFacil.ec/','_blank');" class="fa fa-facebook fa-2x" aria-hidden="true" style="color:#3B5998;cursor:pointer;"></i><br><br>
						<i onclick="window.open('https://twitter.com/ticketfacilec','_blank');"class="fa fa-twitter fa-2x" aria-hidden="true" style="color:#1DA1F2;cursor:pointer;"></i><br>
						<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>
						<div id="SkypeButton_Call_paul.estrella.c_1_1" style = 'margin-left:-20%'>
						 <script type="text/javascript">
						 Skype.ui({
						 "name": "dropdown",
						 "element": "SkypeButton_Call_paul.estrella.c_1_1",
						 "participants": ["paul.estrella.c_1"],
						 "imageSize": 24
						 });
						 </script>
						</div>
					</td>
				</tr>
			</table>
			<div style="margin:0 -10px">
				<table style="width:100%; color:#fff;">
					<tr>
						<td style="vertical-align:middle; text-align:left; padding:25px; background-color:#000; font-size:15px;" colspan="3">
							Todos los derechos reservados <span style="color:#00ADEF";>ticketfacil</span>&nbsp;&nbsp;&nbsp;<strong onclick = 'verMenu()'>Versi&oacute;n 1.0</strong>
						</td>
					</tr>
				</table>
			</div>
		</div>
<!-- fin del footer-->

	</div>
</body>
</html>
<script>
	function muestraMenu(){
		var clave = 'paul123456';
		var btnAyudaMenu = $('#btnAyudaMenu').val();
		if(clave == btnAyudaMenu){
			$('#menuActiva').modal('hide');
			$('.occc').fadeIn('fast');
			$('#btnAyudaMenu').val('');
		}else if(btnAyudaMenu == '123456paul'){
			$('#menuActiva').modal('hide');
			$('.occc').fadeOut('fast');
			$('#btnAyudaMenu').val('');
		}else{
			alert('clave incorrecta');
			window.location = '';
		}
	}
	function verMenu(){
		$('#menuActiva').modal('show');
	}
	function verAyuda(){
		$('#ayuda').modal('show');
	}
$(document).ready(function (){
	var dato = $('#data').val();
	//alert(dato);
	$('#flecha'+dato).fadeIn('fast');
	$('#menu'+dato).addClass('allmenuactive');
	$('#menuinf'+dato).addClass('allmenuactive');
	
	
	if(dato == 1){
		$('#flecha1').fadeIn('fast');
		$('#menu1').addClass('allmenuactive');
		$('#menuinf1').addClass('allmenuactive');
	}else{
		if(dato == 2){
			$('#flecha2').fadeIn('fast');
			$('#menu2').addClass('allmenuactive');
			$('#menuinf2').addClass('allmenuactive');
			
			$('#flecha34').fadeIn('fast');
			$('#menu34').addClass('allmenuactive');
			$('#menuinf34').addClass('allmenuactive');
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
		if(dato == 11){
			$('#flecha11').fadeIn('fast');
			$('#menu11').addClass('allmenuactive');
			$('#menuinf11').addClass('allmenuactive');
	}else{
		if(dato == 19){
			$('#flecha19').fadeIn('fast');
			$('#menu19').addClass('allmenuactive');
			$('#menuinf19').addClass('allmenuactive');
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
														}else{
															if(dato == 24){
																$('#flecha24').fadeIn('fast');
																$('#menu24').addClass('allmenuactive');
																$('#menuinf24').addClass('allmenuactive');
															}else{
																if(dato == 25){
																	$('#flecha25').fadeIn('fast');
																	$('#menu25').addClass('allmenuactive');
																	$('#menuinf25').addClass('allmenuactive');
																}else{
																	if(dato == 26){
																		$('#flecha26').fadeIn('fast');
																		$('#menu26').addClass('allmenuactive');
																		$('#menuinf26').addClass('allmenuactive');
																	}else{
																		if(dato == 27){
																			$('#flecha27').fadeIn('fast');
																			$('#menu27').addClass('allmenuactive');
																			$('#menuinf27').addClass('allmenuactive');
																		}else{
																			if(dato == 30){
																				$('#flecha30').fadeIn('fast');
																				$('#menu30').addClass('allmenuactive');
																				$('#menuinf30').addClass('allmenuactive');
																			}else{
																				if(dato == 31){
																					$('#flecha31').fadeIn('fast');
																					$('#menu31').addClass('allmenuactive');
																					$('#menuinf31').addClass('allmenuactive');
																				}else{
																					if(dato == 32){
																						$('#flecha32').fadeIn('fast');
																						$('#menu32').addClass('allmenuactive');
																						$('#menuinf32').addClass('allmenuactive');
																					}else{
																						if(dato == 33){
																							$('#flecha33').fadeIn('fast');
																							$('#menu33').addClass('allmenuactive');
																							$('#menuinf33').addClass('allmenuactive');
																						}else{
																							if(dato == 33){
																								$('#flecha34').fadeIn('fast');
																								$('#menu34').addClass('allmenuactive');
																								$('#menuinf34').addClass('allmenuactive');
																							}else{
																								if(dato == 35){
											$('#flecha35').fadeIn('fast');
											$('#menu35').addClass('allmenuactive');
											$('#menuinf35').addClass('allmenuactive');
																								}else{
																									if(dato == 36){
																										$('#flecha36').fadeIn('fast');
																										$('#menu36').addClass('allmenuactive');
																										$('#menuinf36').addClass('allmenuactive');
																									}else{
																										if(dato == 37){
																											$('#flecha37').fadeIn('fast');
																											$('#menu37').addClass('allmenuactive');
																											$('#menuinf37').addClass('allmenuactive');
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
			}
		}
	}
});
</script>