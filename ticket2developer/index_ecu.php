<?php
date_default_timezone_set('America/Guayaquil');
session_start();

/*ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);*/

require_once('classes/public.class_Ecu.php');
require_once('classes/private.db.php');
$init = new InitTicket;


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
<link rel="icon" href="https://www.ecutickets.ec//images/favicon.ico" type="image/x-icon">
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>



<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<title>Ecutickets - Venta de boletos para conciertos y eventos en Ecuador</title>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script language="Javascript"  type="text/javascript" src="js/clockCountdown.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/jquery.imagemapster.js"></script>
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/ecuticket.css">
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

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-98480554-1', 'auto');
  ga('send', 'pageview');

</script>


</head>
<body>
<div style="background-color: rgba(0, 0, 0, 0.8); position: absolute; z-index: 2000;display:none;width:100%;" id="contenedorDescuentos">
	<span style = 'float:right;color:#fff;font-size:16px;cursor:pointer;padding:5px;' onclick = '$("#contenedorDescuentos").fadeOut("slow")'>X</span>
	<br><div id = 'cuerpoDescuentos' style = 'width:100%;'></div>
</div>
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
	<?php
		if(isset($_SESSION['imagen_logo']) && $_SESSION['imagen_logo'] != ''){
			$clase_full = '';
			$displayEcu = 'display:none;'; 
		}else{
			$clase_full = '';
			$displayEcu = 'display:block;'; 
		}
	?>
	<link rel="stylesheet" href="font-awesome-4.6.3/css/font-awesome.min.css">
	<div class="container" style = 'padding:0 !important ;width: 100% !important;overflow: hidden'>
		<div id="sp-header-sticky-wrapper" class="sticky-wrapper" style="height:100px;background-color:#0083C2;">
			<header id="sp-header" style = 'background-color:#0083C2;height:100px;'>
				<div class="container" style = 'width:100%;'>
					<div class="row" style="position: relative;">
						<div id="sp-logo" class="col-xs-8 col-sm-2 col-md-2">
							<div class="sp-column ">
								<a class="logo" href="javascript:void(0);" onclick="window.open('https://www.ecutickets.ec/','_top');">
									<h1>
										<img class="sp-default-logo hidden-xs" src="https://www.ecutickets.ec/images/ecu-logo.png" alt="Ecuticket">
										<img class="sp-default-logo visible-xs" src="https://www.ecutickets.ec/images/logo-ecutix.png" alt="Ecuticket">
									</h1>
								</a>
							</div>
						</div>
						<div id="sp-menu" class="col-xs-4 col-sm-9 col-md-9" style="position: static;">
							<div class="sp-column ">			
								<div class="sp-megamenu-wrapper">
									<a id="offcanvas-toggler" class="visible-xs" href="#">
										<i class="fa fa-bars"></i>
									</a>
									<ul class="sp-megamenu-parent menu-fade hidden-xs">
										<li class="sp-menu-item current-item active" onclick="window.open('https://www.ecutickets.ec/','_top');">
											<a href="javascript:void(0);">Inicio</a>
										</li>
										<li class="sp-menu-item" onclick="window.open('?modulo=eventos','_top');">
											<a href="javascript:void(0);">Eventos</a>
										</li>
										<li class="sp-menu-item sp-has-child">
											<a href="javascript:void(0);" onclick="window.open('https://www.ecutickets.ec/','_top');">
												Ecuticket
											</a>
											<div class="sp-dropdown sp-dropdown-main sp-menu-right" style="width: 240px;">
												<div class="sp-dropdown-inner">
													<ul class="sp-dropdown-items">
														<li class="sp-menu-item" onclick="window.open('https://www.ecutickets.ec/index.php/ecuticket/historia-de-la-empresa','_top');">
															<a href="javascript:void(0);">Historia de la Empresa</a>
														</li>
														<li class="sp-menu-item" onclick="window.open('https://www.ecutickets.ec/index.php/ecuticket/mision-vision-y-valores','_top');">
															<a href="javascript:void(0);">Misión, Visión y Valores</a>
														</li>
													</ul>
												</div>
											</div>
										</li>
										<li class="sp-menu-item">
											<a href="javascript:void(0);" onclick="window.open('https://www.ecutickets.ec/index.php/pedidos-web','_top');">Pedidos Web</a>
										</li>
										<li class="sp-menu-item" onclick="window.open('https://www.ecutickets.ec/index.php/contacto','_top');">
											<a href="javascript:void(0);">Puntos de Venta</a>
										</li>
										<li class="sp-menu-item">
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
																if($_SESSION['autentica'] == 'tFDiS759' || $_SESSION['autentica'] == 'tFADMIN_SOCIO'){
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
										</li>
										<li class="sp-menu-item" onclick="window.open('controlusuarios/salir_ecu.php');">
											<?php if($_SESSION['autentica'] == 'uzx153'){?>
												<a class="logout" href="javascript:void(0);">salir</a>
											<?php 
												}else{
													if($_SESSION['autentica'] == 'SA456'){?>
													<a class="logout" href="javascript:void(0);">salir</a>
												<?php }else{
													if($_SESSION['autentica'] == 'jag123'){?>
														<a class="logout" href="javascript:void(0);">salir</a>
													<?php }else{
														if($_SESSION['autentica'] == 'tFSp777'){?>
															<a class="logout" href="javascript:void(0);">salir</a>
														<?php }else{
															if($_SESSION['autentica'] == 'TfAdT545'){?>
																<a class="logout" href="javascript:void(0);">salir</a>
															<?php }else{
																if($_SESSION['autentica'] == 'tFDiS759' || $_SESSION['autentica'] == 'tFADMIN_SOCIO'){?>
																	<a class="logout" href="javascript:void(0);">salir</a>
																<?php }else{?>
											<a class="loguearse" href="?modulo=newaccount">
												CREAR UNA CUENTA
											</a>
											<?php } } } } } }?>
										</li>
									</ul>			
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
		</div>
		<div class="body">
			<div class="content">
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
		<footer id="sp-footer" style = 'background:#0083c2 none repeat scroll 0 0;height: '>
			<div class="container">
				<div class="row">
					<div id="sp-footer1" class="col-sm-6 col-md-6">
						<div class="sp-column left-aligned-text">
							<ul class="sp-contact-info">
								<li class="sp-contact-phone">
									<i class="fa fa-phone"></i> 
									<a href="tel:1800-328-842 / 02-2-292-1388 / 09-9-271-7671">1800-328-842 / 02-2-292-1388 / 09-9-271-7671</a>
								</li>
								<li class="sp-contact-email">
									<i class="fa fa-envelope"></i>
									<a href="mailto:ventas@ecutickets.ec">ventas@ecutickets.ec</a>
								</li>
							</ul>
						</div>
					</div>
					<div id="sp-footer2" class="col-sm-5 col-md-5">
						<div class="sp-column right-aligned-text">
							<ul class="social-icons">
								<li><a target="_blank" href="http://facebook.com/ecutickets"><i class="fa fa-facebook"></i></a></li>
								<li><a target="_blank" href="http://twitter.com/ecutickets"><i class="fa fa-twitter"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<section id="sp-footer-end" class="centered-text" style = 'background-color: #048dd1;color: #fbd600;'><div class="container"><div class="row"><div id="sp-footer3" class="col-sm-12 col-md-12"><div class="sp-column "><span class="sp-copyright"> &copy; 2015 Ecutickets. All Rights Reserved. Designed By Luca Marketing.</span></div></div></div></div></section>
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