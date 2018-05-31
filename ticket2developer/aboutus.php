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
	<title>Ticket Facil - Quienes Somos</title>
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
		#flipkart-navbar {
	    background-color: #01b1d7;
	    color: #FFFFFF;
		}
		.row1{
		    padding-top: 10px;
		}
		.row2 {
		    padding-bottom: 10px;
		}
		.flipkart-navbar-input {
		    padding: 11px 16px;
		    border-radius: 2px 0 0 2px;
		    border: 0 none;
		    outline: 0 none;
		    font-size: 15px;
		    color:black !important;
		}
		.flipkart-navbar-button {
		    background-color: #2874f0;
		    border: 1px solid #2874f0;
		    border-radius: 0 2px 2px 0;
		    color: #565656;
		    padding: 10px 0;
		    height: 43px;
		    cursor: pointer;
		}
		.cart-button {
		    background-color: #2469d9;
		    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .23), inset 1px 1px 0 0 hsla(0, 0%, 100%, .2);
		    padding: 10px 0;
		    text-align: center;
		    height: 41px;
		    border-radius: 2px;
		    font-weight: 500;
		    width: 120px;
		    display: inline-block;
		    color: #FFFFFF;
		    text-decoration: none;
		    color: inherit;
		    border: none;
		    outline: none;
		}
		.cart-button:hover{
		    text-decoration: none;
		    color: #fff;
		    cursor: pointer;
		}
		.cart-svg {
		    display: inline-block;
		    width: 16px;
		    height: 16px;
		    vertical-align: middle;
		    margin-right: 8px;
		}
		.item-number {
		    border-radius: 3px;
		    background-color: rgba(0, 0, 0, .1);
		    height: 20px;
		    padding: 3px 6px;
		    font-weight: 500;
		    display: inline-block;
		    color: #fff;
		    line-height: 12px;
		    margin-left: 10px;
		}
		.upper-links {
		    display: inline-block;
		    padding: 0 11px;
		    line-height: 23px;
		    font-family: 'Roboto', sans-serif;
		    letter-spacing: 0;
		    color: inherit;
		    border: none;
		    outline: none;
		    font-size: 12px;
		}
		.dropdown {
		    position: relative;
		    display: inline-block;
		    margin-bottom: 0px;
		}
		.dropdown:hover {
		    background-color: #fff;
		}
		.dropdown:hover .links {
		    color: #000;
		}
		.dropdown:hover .dropdown-menu {
		    display: block;
		}
		.dropdown .dropdown-menu {
		    position: absolute;
		    top: 100%;
		    display: none;
		    background-color: #fff;
		    color: #333;
		    left: 0px;
		    border: 0;
		    border-radius: 0;
		    box-shadow: 0 4px 8px -3px #555454;
		    margin: 0;
		    padding: 0px;
		}

		.links {
		    color: #fff;
		    text-decoration: none;
		}

		.links:hover {
		    color: #fff;
		    text-decoration: none;
		}

		.profile-links {
		    font-size: 12px;
		    font-family: 'Roboto', sans-serif;
		    border-bottom: 1px solid #e9e9e9;
		    box-sizing: border-box;
		    display: block;
		    padding: 0 11px;
		    line-height: 23px;
		}

		.profile-li{
		    padding-top: 2px;
		}

		.largenav {
		    display: none;
		}

		.smallnav{
		    display: block;
		}

		.smallsearch{
		    margin-left: 15px;
		    margin-top: 15px;
		}

		.menu{
		    cursor: pointer;
		}

		@media screen and (min-width: 768px) {
		    .largenav {
		        display: block;
		    }
		    .smallnav{
		        display: none;
		    }
		    .smallsearch{
		        margin: 0px;
		    }
		}

		/*Sidenav*/
		.sidenav {
		    height: 100%;
		    width: 0;
		    position: fixed;
		    z-index: 1;
		    top: 0;
		    left: 0;
		    background-color: #fff;
		    overflow-x: hidden;
		    transition: 0.5s;
		    box-shadow: 0 4px 8px -3px #555454;
		    padding-top: 0px;
		}

		.sidenav a {
		    padding: 8px 8px 8px 32px;
		    text-decoration: none;
		    font-size: 25px;
		    color: #818181;
		    display: block;
		    transition: 0.3s
		}

		.sidenav .closebtn {
		    position: absolute;
		    top: 0;
		    right: 25px;
		    font-size: 36px;
		    margin-left: 50px;
		    color: #fff;        
		}

		@media screen and (max-height: 450px) {
		  .sidenav a {font-size: 18px;}
		}

		.sidenav-heading{
		    font-size: 36px;
		    color: #fff;
		}
	</style>
</head>

<body id="top" data-spy="scroll" style = 'overflow-x:hidden;'>
	<!--top header-->

	<?php
		include 'head_demo.php';
	?>
	<div id = 'about2'>
		<div class="container">
			<div class="row">
				<div class="">
					<div class="service-heading">
						<h2>QUIENES SOMOS</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<img src="imagenes/quienes.png" width="100%" alt="quienes somos">
				</div>
				<div class="col-md-6">
					<p style="text-align:justify;color:#8e8e8e;">
						<span style="color:#009FE3;">TICKETFACIL</span> es el sistema on line más seguro, confiable, eficiente y fácil que permite al usuario, 
						reservar, escoger y comprar tickets para conciertos, festivales de música, teatro, deportes, atracciones, cine, eventos corporativos, 
						culturales y sociales.
					</p><br>
					<p style="text-align:justify;color:#8e8e8e;">
						Somos un grupo empresarial que invierte constantemente en innovación tecnológica y se compromete a ofrecer un servicio de primera 
						clase en todo el sector del entretenimiento. Líderes en implementaciones de sistemas que incluyen punto de venta con más de 1000 
						terminales de facturación operando actualmente a nivel nacional. Somos parte de la Asociación Ecuatoriana de Software AESOFT.
					</p>
					<p style="text-align:justify;color:#8e8e8e;">
						<span style="color:#009FE3;">TICKETFACIL</span> ofrece a sus clientes un acceso privilegiado a los mejores servicios de ticketing y gestión de taquillas para el control 
						de accesos en venta de entradas fisicas y electronicas más completas y avanzadas de nuestro país, disponemos varias formas de pago 
						instantáneas y una cobertura con más de 100 puntos de venta a nivel nacional. Nuestra plataforma refleja reportes en tiempo real de la 
						impresión y  venta de tickets así como un detallado control de ingreso de sus asistentes.
					</p>
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
	
<script type="text/javascript">
	function openNav() {
	    document.getElementById("mySidenav").style.width = "70%";
	    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
	}

	function closeNav() {
	    document.getElementById("mySidenav").style.width = "0";
	    document.body.style.backgroundColor = "rgba(0,0,0,0)";
	}
	function envia_contacto(){
		var nombre = $('#nombre_contacto').val();
		var email = $('#email_contacto').val();
		var telefono = $('#asunto_contacto').val();
		//var evento = $('#evento').val();
		var ciudad = '';
		var mensaje = $('#mensaje_contacto').val();
		
		// var lugar = $('#lugar').val();
		// var fecha = $('#fecha').val();
		// var cantidad = $('#cantidad').val();
		
		
		// var selected = '';    
        // $('input[type=checkbox]').each(function(){
            // if (this.checked) {
                // selected += $(this).val()+'@';
            // }
        // }); 
		// var valores_servicio = selected.substring(0,selected.length -1);
		
		// alert('Has seleccionado: '+valores_servicio);  
        // if (selected != '') 
            // alert('Has seleccionado: '+selected);  
        // else
            // alert('Debes seleccionar al menos una opción.');
		if(nombre == ''){
			alert('Debe ingresar un Nombre');
		}
		
		if(email == ''){
			alert('Debe ingresar un Email');
		}
		
		
		
		if(telefono == ''){
			alert('Debe ingresar un asunto');
		}
		
		if(mensaje == ''){
			alert('Debe ingresar un mensaje');
		}
		
		// if(lugar == ''){
			// alert('Debe ingresar un Lugar');
		// }
		
		// if(fecha == ''){
			// alert('Debe ingresar una Fecha del Evento');
		// }
		
		// if(cantidad == ''){
			// alert('Debe ingresar una Cantidad de tickets');
		// }
		
		if(nombre == '' || email == '' || telefono == '' || mensaje == '' ){
			
		}else{
			$('#btn_contacto').html('Espere, enviando informacion');
			$('#btnCotizar').css('display','none');
			$('#btnLoad').css('display','block');
			$.post("envioEmailCotizar2.php",{ 
				nombre : nombre , email : email , telefono : telefono ,  mensaje : mensaje
			}).done(function(data){
				$('#btn_contacto').html('cotizar');
				$('#ver_sms_cotizar').modal('show');
				$('#recibe_cotizar').html(data);
				
				setTimeout(function(){
					location.reload();
				}, 8000);
			});
		}
		
	}
	function envia(){
		var nombre = $('#nombre').val();
		var email = $('#email').val();
		var telefono = $('#telefono').val();
		var evento = $('#evento').val();
		var ciudad = $('#ciudad').val();
		var lugar = $('#lugar').val();
		var fecha = $('#fecha').val();
		var cantidad = $('#cantidad').val();
		
		
		var selected = '';    
        $('input[type=checkbox]').each(function(){
            if (this.checked) {
                selected += $(this).val()+'@';
            }
        }); 
		var valores_servicio = selected.substring(0,selected.length -1);
		
		// alert('Has seleccionado: '+valores_servicio);  
        // if (selected != '') 
            // alert('Has seleccionado: '+selected);  
        // else
            // alert('Debes seleccionar al menos una opción.');
		if(nombre == ''){
			alert('Debe ingresar un Nombre de Empresario');
		}
		
		if(email == ''){
			alert('Debe ingresar un Email de Empresario');
		}
		
		if(telefono == ''){
			alert('Debe ingresar un Telefono de Empresario');
		}
		
		if(evento == ''){
			alert('Debe ingresar un Nombre de Evento');
		}
		
		if(ciudad == ''){
			alert('Debe ingresar una Ciudad');
		}
		
		if(lugar == ''){
			alert('Debe ingresar un Lugar');
		}
		
		if(fecha == ''){
			alert('Debe ingresar una Fecha del Evento');
		}
		
		if(cantidad == ''){
			alert('Debe ingresar una Cantidad de tickets');
		}
		
		if(nombre == '' || email == '' || telefono == '' || evento == '' || ciudad == '' || lugar == '' || fecha == '' || cantidad == ''){
			
		}else{
			$('#btn_cotiza').html('Espere, enviando informacion');
			$('#btnCotizar').css('display','none');
			$('#btnLoad').css('display','block');
			$.post("envioEmailCotizar.php",{ 
				nombre : nombre , email : email , telefono : telefono , evento : evento , ciudad : ciudad ,
				lugar : lugar , fecha : fecha , cantidad : cantidad , valores_servicio : valores_servicio
			}).done(function(data){
				$('#btn_cotiza').html('cotizar');
				$('#ver_sms_cotizar').modal('show');
				$('#recibe_cotizar').html(data);
				
				setTimeout(function(){
					location.reload();
				}, 8000);
				
			});
		}
		
	}
	$( function() {
		
		var height = $(window).height();
		var height_2 = (parseInt(height) - 200);
		// alert(height_2);
		$('.imagenes_banner').css('max-height',height_2);
		
		$('.entero').numeric();
		
		
		$( "#fecha" ).datepicker();
		$.datepicker.regional['es'] = {
			closeText: 'Cerrar',
			prevText: '<Ant',
			nextText: 'Sig>',
			currentText: 'Hoy',
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			weekHeader: 'Sm',
			dateFormat: 'yy/mm/dd',
			minDate: +1,
		};
		$.datepicker.setDefaults($.datepicker.regional['es']);
	} );
	
</script>

</body>

</html>
