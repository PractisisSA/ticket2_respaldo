<?php
// ini_set('display_startup_errors',1);
			// ini_set('display_errors',1);
			// error_reporting(-1);
			
date_default_timezone_set('America/Guayaquil');
//session_start();

/*ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);*/

require_once('classes/public.class_2.php');
require_once('classes/private.db.php');
$init = new InitTicket;


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Ticketfacil.ec|inicio</title>
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
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">

  <!-- =======================================================
    Theme Name: Regna
    Theme URL: https://bootstrapmade.com/regna-bootstrap-onepage-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body>

  <!--==========================
  Header
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
       <img alt="logo" src="gfx/logo.png" style = 'width:150px;' />
        <!-- Uncomment below if you prefer to use a text logo -->
        <!--<h1><a href="#hero">Regna</a></h1>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="#hero">Home</a></li>
          <li><a href="#about">Quienes Somos</a></li>
          <li><a href="#services">Servicios</a></li>
          <li><a href="#portfolio">Eventos</a></li>
          <li><a href="#contact">Contacto</a></li>
          <li><a href="#contact">Terminos y Condiciones</a></li>
		  
			<li>
				<a href="#contact">
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
											<a href="?modulo=login">
												LOG IN
											</a>
										<?php 
										} 
									} 
								} 
							} 
						} 
					}?>
				</a>
			</li>
			
			<li>
				<a href="#contact">
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
											<a class="loguearse" href="?modulo=newaccount&pos=0">CREAR UNA CUENTA</a>
											<?php 
											} 
										} 
									} 
								} 
							} 
						}?>
				</a>
			</li>
			
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Hero Section
  ============================-->
  <section id="hero">
    <div class="hero-container">
      <h1>Welcome to Regna</h1>
      <h2>We are team of talanted designers making websites with Bootstrap</h2>
      <a href="#about" class="btn-get-started">Get Started</a>
    </div>
  </section><!-- #hero -->

	<?php
		include($init -> subpagePath);
	?>

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">

      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Regna</strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!--
          All the links in the footer should remain intact.
          You can delete the links only if you purchased the pro version.
          Licensing information: https://bootstrapmade.com/license/
          Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Regna
        -->
        Bootstrap Templates by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8HeI8o-c1NppZA-92oYlXakhDPYR7XMY"></script>

  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/counterup/counterup.min.js"></script>
  <script src="lib/superfish/hoverIntent.js"></script>
  <script src="lib/superfish/superfish.min.js"></script>

  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

</body>
</html>
