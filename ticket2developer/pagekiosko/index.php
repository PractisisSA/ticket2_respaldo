<!--<html>
	<head>
	<title> Ticket Facil 	</title>
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	</head>
	<body style="background-color:#5d5d5d;font-family: 'Roboto', sans-serif;">
		<table width="100%" cellpadding="0" cellspacing="0" height="100%">
			<tr>
				<td valign="center" align="center">
					<img src="gfx/logo.png" />
					<h1 style="color:white;">PRÓXIMAMENTE..</h1>
				</td>
			</tr>
		</table>
	</body>
</html>-->

<?php
date_default_timezone_set('America/Guayaquil');
session_start();
require_once('classes/public.class.php');
require_once('classes/private.db.php');
$init = new InitTicket;
// ini_set('display_startup_errors',1);
// ini_set('display_errors',1);
// error_reporting(-1);
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<title>Ticket-Facil Ec</title>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
	@media print {
    .noprint {display:none !important;}
    a:link:after, a:visited:after {  
      display: none;
      content: "";    
    }
}
</style>
</head>
<body >
	<div class="container">
		<div class="header-space"></div>
		<header>
			<div class="header-structure">
				<img alt="logo" src="gfx/logo.png"/>
			</div>
			<div class="header-structure">
				<div class="header-menu">
					<?php 
						if(isset($_SESSION['autentica']) && ($_SESSION['autentica'] !='') ){
							echo $_SESSION['useractual']."<span style='color:#ED1568;'>hola</span>";
						}else{
					?>
					<a class="loguearse" href="?modulo=login">
						LOG IN
					</a>
					<?php }?>
				</div>
				<div class="header-menu">
					<?php 
						if(isset($_SESSION['autentica']) && ($_SESSION['autentica'] !='')){
					?>
							<a class="logout" href="controlusuarios/salir.php">salir(logout)</a>
							
					<?php 
						}else{
					?>
						<a class="loguearse" href="?modulo=newaccount">
							CREAR UNA CUENTA
						</a>
					<?php
						}
					?>
				</div>
				<div id="trapezoide"></div>
				<div id="paralelogramo"></div>
			</div>
		</header>
		<div class="body">
			<?php if(($_SESSION['autentica'] == 'SA456') && ($_SESSION['modulo'] == 'sri')){?>
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
								<li><a id="menu7" href="?modulo=reimpresion">REIMPRESIÓN</a></li>
								<li><a id="menu5" href="?modulo=transacciones">REGISTRO</a></li>
							</ul>
						</div>
					</div>
				</nav>
			<?php }else if(($_SESSION['autentica'] == 'SA456') && ($_SESSION['modulo'] == 'ticket')){?>
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
								<li><a id="menu1" href="?modulo=Rdepositos">DEP&Oacute;SITOS</a></li>
								<li><a id="menu2" href="?modulo=listaConciertos">CONCIERTOS</a></li>
								<li><a id="menu3" href="?modulo=CreacionConciertos">CREAR CONCIERTO</a></li>
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
								<li><a id="menu1" href="?modulo=eventosRealizados">EVENTOS REALIZADOS</a></li>
								<li><a id="menu2" href="?modulo=estadisticas">ESTAD&Iacute;STICAS</a></li>
								
							</ul>
						</div>
					</div>
				</nav>
				<?php }else if(($_SESSION['autentica'] == 'tFSp777') && ($_SESSION['modulo'] == 'sri')){?>
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
				<?php }else if(($_SESSION['autentica'] == 'tFSp777') && ($_SESSION['modulo'] == 'ticket')){?>
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
									<li><a id="menu1" href="?modulo=listaUsuarios">USUARIOS</a></li>
									<li><a id="menu2" href="?modulo=crearUsuarios">CREAR USUARIO</a></li>
									<li><a id="menu3" href="?modulo=listaEvento">CONCIERTOS</a></li>
									<li><a id="menu7" href="?modulo=distribuidor">DISTRIBUIDOR</a></li>
									<li><a id="menu8" href="?modulo=reportes">REPORTES</a></li>
								</ul>
							</div>
						</div>
					</nav>
				<?php }else if($_SESSION['autentica'] == 'Kios759'){echo $_SESSION["autentica"];?>
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
									<li><a id="menu1" href="?modulo=moduloKiosko">KIOSKO</a></li>
								</ul>
							</div>
						</div>
					</nav>
				<?php }
				else if($_SESSION['autentica'] == 'tFDiS759'){?>
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
									<li><a id="menu1" href="?modulo=distribuidorMod">DISTRIBUIDOR</a></li>
								</ul>
							</div>
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
							<style>
								.disabled {
									cursor: default;
								}
								.disabled:hover{
									color:#00AEEF;
								}
							</style>
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li><a id="menu1" href="?modulo=start">CANJE</a></li>
									<li><a id="menu3" href="?modulo=conciertos">VENTAS</a></li>
									<div id='recibedetalledeBoletosVendidos' ></div>
									<!--<input type='text' id='recibedetalledeBoletosVendidos' />-->
								</ul>
								<script>
									$('.disabled').click(function(e){
										e.preventDefault(); 
									})
								</script>
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
				<div id="fadeKiosko" style="display:none;z-index:900;width:100%;height:100%;position:fixed;left:0px;top:0px;background:rgba(255,255,255,0.8);padding:0px;margin:0px;" >
					<div style="display:relative;width:100%;" align="right"> <label style="font-weight:bold;font-size:16px;color:red;cursor:pointer;" >X</label></div>
					<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6" align="center">
									<input class="form-control" placeHolder="Ingrese codigo" onkeyup="buscaImprime($(this).val())">
									<br>
									<table class="table" id="putPrint" width="100%">

									</table>
							</div>
					</div>

				</div>

				<div id="fadeNew" style="display:none;z-index:900;width:100%;height:100%;position:fixed;left:0px;top:0px;background:rgba(255,255,255,0.8);padding:0px;margin:0px;" >
					<div style="display:relative;width:100%;" align="right"> <label style="font-weight:bold;font-size:16px;color:red;cursor:pointer;" onclick='$("#fadeNew").fadeOut()'>X</label></div>
					<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6" align="center">
									<input class="form-control" placeHolder="Ingrese cédula" onkeyup="buscaCliente($(this).val())">
									<br>
									<table class="table" id="putClient" width="100%">

									</table>
							</div>
					</div>

				</div>

			<div class="row">
				<?php
				include($init -> subpagePath);
				?>
			</div>
		</div>
		<div class="footer">
			<table class="table table-responsive">
				<tr>
					<td style="padding-left:75px;">
						<img alt="logo" src="gfx/logo.png"/>
						<div class="larger">
							1800ticketfacil<br/>
							18004567098
						</div>
						<div class="thinner">
							info@ticketfacil.com
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
							<p><img src="imagenes/flecha.png" id="flecha3" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf3" href="?modulo=CreacionConciertos">Crear Concierto</a></p>
						<?php }else if($_SESSION['autentica'] == 'jag123'){?>
							<p><img src="imagenes/flecha.png" id="flecha1" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf1" href="?modulo=eventosRealizados">Eventos Realizados</a></p>
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
							<p><img src="imagenes/flecha.png" id="flecha3" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf3" href="?modulo=conciertos">CONCIERTOS</a></p>
							<p><img src="imagenes/flecha.png" id="flecha4" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf4" href="?modulo=pventa">PUNTOS DE VENTA</a></p>
							<p><img src="imagenes/flecha.png" id="flecha5" style="display:none;"/>&nbsp;&nbsp;&nbsp;&nbsp;<a class="menu-inferior" id="menuinf5" href="?modulo=contactos">CONTACTOS</a></p>
						<?php }?>
					</td>
					<td style="padding-top:75px; padding-left:75px;">
						<img alt="" src="gfx/redes.png"/>
					</td>
				</tr>
			</table>
			<div style="margin:0 -10px">
				<table style="width:100%; color:#fff;">
					<tr>
						<td style="vertical-align:middle; text-align:left; padding:25px; background-color:#000; font-size:15px;" colspan="3">
							Todos los derechos reservados <span style="color:#00ADEF;" onclick="toggleFullScreen(document.body)">ticketfacil</span>&nbsp;&nbsp;&nbsp;<strong>Versi&oacute;n 1.0</strong>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
<script>
function toggleFullScreen(elem) {
    // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (elem.requestFullScreen) {
            elem.requestFullScreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullScreen) {
            elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}
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
								}
							}
						}
					}
				}
			}
		}
	}
});

function hackKiosko(){
	$("#fadeKiosko").fadeIn("fast");
}

function crearBoleto(){
	$("#fadeNew").fadeIn("fast");
}

function buscaImprime(t){
	
	$.post("ajax/printTicket.php", {  cedula : t  }).done(function(data){
		$("#putPrint").html(data);
	});
}

function buscaCliente(t){
	
	$.post("ajax/searchClient.php", {  cedula : t  }).done(function(data){
		$("#putClient").html(data);
	});
}


</script>
   <script>
       function printIframe(objFrame) {
           objFrame.focus();
           objFrame.print();
           bjFrame.save();
       }
   </script>