<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="http://ticketfacil.ec/ticket2developer/font-awesome-4.6.3/css/font-awesome.min.css">

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
											VENTAS Y REPORTES <span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li><a id="menu38" href="?modulo=cierre_caja">CIERRE DE CAJA</a></li>
											<li role="separator" class="divider"></li>
											<li><id="menu1" href="?modulo=Rdepositos">CONFIRMACION DE DEPOSITO BANCARIO</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu31" href="?modulo=dar_de_baja">DAR DE BAJA BOLETOS SOBRANTES</a></li>
											<li role="separator" class="divider"></li>
											<li class="dropdown-submenu">
												<a tabindex="-1" href="#">FORMAS DE PAGO</a>
												<ul class="dropdown-menu">
													<li><a id="menu52" href="?modulo=pagos_transferencia">DEPOSITO - TRANSFERENCIA</a></li>
													<li role="separator" class="divider"></li>
													<li><a id="menu37" href="?modulo=pagos_paypal">PAYPAL</a></li>
													<li role="separator" class="divider"></li>
													<li><a id="menu42" href="?modulo=pagos_stripe">TARJETA DE CREDITO</a></li>
													<li role="separator" class="divider"></li>
												</ul>
											</li>
											<li role="separator" class="divider"></li>
											<li><a id="menu54" href="?modulo=reporteSri">REPORTE CONSOLIDADO DE VENTAS</a></li>
											<li role="separator" class="divider"></li>
											<li><a id="menu36" href="?modulo=impresionesDistribuidor">VENTAS POR PUNTO DE VENTA</a></li>
											<li role="separator" class="divider"></li>
										</ul>
									</li>
									
									
									<li class="dropdown">
										<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											ADMINISTRACION DE USUARIOS <span class="caret"></span>
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
											<li><a id="menu7" href="?modulo=distribuidor">ADMINISTRACION PUNTOS DE VENTA</a></li>
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
											
											<li><a id="menu26" href="?modulo=actualiza">MODIFICA CLAVES</a></li>
											<li role="separator" class="divider"></li>
											
											<li><a id="menu35" href="?modulo=crearUsuarios">CREAR USUARIO</a></li>
											<li role="separator" class="divider"></li>
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
											MODULO SRI <span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li><a id="menu50" href="?modulo=Autorizaciones">CREAR AUTORIZACIÓN</a></li>
											<li role="separator" class="divider"></li>
										</ul>
									</li>
									
									<li class="dropdown">
										<a name="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											ADMINISTRACION DE EVENTOS <span class="caret"></span>
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
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</nav>
					