<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Ticket Facil - Servicios</title>
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
	<?php
		include 'head_demo.php';
	?>
<div id="service">
	<div class="row">
		<div class="container">
			<img src="imagenes/servicios.png">
		</div>
	</div>	
		<!--<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="service-heading">
						<h2>servicios</h2>
						<p>
							Estaremos gustosos de atender a todos sus requerimientos e inquietudes que tenga con nuestros productos y servicios en el menor tiempo posible<br>
							Por favor seleccione las opciones que se ajusten a sus necesidades, llene el formulario y presione el boton de cotizar<br>
							Uno de nuestros asesores se comunicara con usted!<br>
						</p>
					</div>
				</div>
			</div>
		</div>-->

		<!--services wrapper-->
		<section class="services-style-one">
			<div class="outer-box clearfix">
				<div class="services-column">
					<div class="content-outer">
						<div class="row clearfix">
							<div class="service-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="inner-box">
									<div class="icon-box"><i class="fa fa-ticket" aria-hidden="true"></i></div>
									<div class="text"> 
										<input id = 'comercializa' checked type = 'checkbox' value='Impresión-y-comercialización-de-tickets-térmicos' name ='servicios[]' /> 
										<label for="comercializa"><span></span>Impresión y comercialización de tickets térmicos</label>
									</div>
								</div>
							</div>
							<div class="service-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="inner-box">
									<div class="icon-box"><i class="fa fa-bar-chart" aria-hidden="true"></i></div>
									
									<div class="text"> 
										<input id = 'electronico' checked type = 'checkbox' value='Ticket-electronico-(ingreso-con:-cédula-mail-con-codigo-de-barras)' name ='servicios[]'/>
										<label for="electronico"><span></span>Ticket electronico (ingreso con: cédula , mail con codigo de barras)</label>
									</div>
								</div>
							</div>
							<div class="service-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="inner-box">
									<div class="icon-box"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
									
									<div class="text"> 
										<input id = 'boletos_sin' checked type = 'checkbox' value='Impresión-de-boletos-sin-Comercialización ' name ='servicios[]' /> 
										<label for="boletos_sin"><span></span>Impresión de boletos sin Comercialización </label>
									</div>
								</div>
							</div>
							<div class="service-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="inner-box">
									<div class="icon-box"><i class="fa fa-eye" aria-hidden="true"></i></div>
									
									<div class="text"> 
										<input id = 'control_acceso' checked type = 'checkbox' value='Control-de-acceso-el-día-del-evento-con-lectoras-inalámbricas-TicketFacil' name ='servicios[]'/>
										<label for="control_acceso"><span></span>Control de acceso el día del evento con lectoras inalámbricas TicketFacil</label>
									</div>
								</div>
							</div>
							<div class="service-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="inner-box">
									<div class="icon-box"><i class="fa fa-lightbulb-o" aria-hidden="true"></i></div>
									
									<div class="text"> 
										<input id = 'promocion_marqueting' checked type = 'checkbox' value='Promoción-y-Marketing-(web-redes-sociales-buscadores-y-SMS-masivo)' name ='servicios[]' /> 
										<label for="promocion_marqueting"><span></span>Promoción y Marketing (web, redes sociales, buscadores y SMS masivo)</label>
									</div>
								</div>
							</div>
							<div class="service-block col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="inner-box">
									<div class="icon-box"><i class="fa fa-money" aria-hidden="true"></i></div>
									<div class="text"> 
										<input id = 'adicionales' checked type = 'checkbox' value='Servicios-adicionales-dia-del-evento' name ='servicios[]'/> 
										<label for="adicionales"><span></span>Servicios adicionales dia del evento </label>
										<input id = 'pulseras' checked type = 'checkbox' value='Pulseras-Personalizadas' name ='servicios[]'/> 	 		
										<label for="pulseras"><span></span>Pulseras Personalizadas </label>
										<input id = 'gafetes' checked type = 'checkbox' value='Servicio-de-Gafetes-y-Acreditación' name ='servicios[]' />
										<label for="gafetes"><span></span> Servicio de Gafetes y Acreditación </label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--Content Column-->
				<div class="content-column clearfix" style = 'padding-top:70px;'>
					<table style="" class="table">
					<tbody><tr>
						<td style="text-align:left;padding:10px;">
							<label style="color:#00AEEF;">*</label>Nombre del Empresario : 
						</td>
						<td> 
							<input type="text" name="name" id = 'nombre' class="form-control" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
						</td>
					</tr>
					<tr>
						<td style="text-align:left;padding:10px;">
							<label style="color:#00AEEF;">*</label>Email : 
						</td>
						<td> 
							<input  id="email" type="text" class="form-control" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
						</td>
					</tr>
					<tr>
						<td style="text-align:left;padding:10px;">
							<label style="color:#00AEEF;">*</label>Numero de telefono : 
						</td>
						<td> 
							<input  id="telefono" type="text" class="form-control entero" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
						</td>
					</tr>
					<tr>
						<td style="text-align:left;padding:10px;">
							<label style="color:#00AEEF;">*</label>Evento : 
						</td>
						<td> 
							<input id="evento" type="text" class="form-control" data-rule="minlen:4" data-msg="Please enter at least 4 chars"/>
						</td>
					</tr>
					<tr>
						<td style="text-align:left;padding:10px;">
							<label style="color:#00AEEF;">*</label>Ciudad : 
						</td>
						<td> 
							<input id="ciudad" type="text" class="form-control" data-rule="minlen:4" data-msg="Please enter at least 4 chars"/>
						</td>
					</tr>
					<tr>
						<td style="text-align:left;padding:10px;">
							<label style="color:#00AEEF;">*</label>Lugar tentativo : 
						</td>
						<td> 
							<input id="lugar" type="text" class="form-control" data-rule="minlen:4" data-msg="Please enter at least 4 chars"/>
						</td>
					</tr>
					<tr>
						<td style="text-align:left;padding:10px;">
							<label style="color:#00AEEF;">*</label>Fecha tentativa : 
						</td>
						<td> 
							<input  id="fecha" type="text" class="form-control" data-rule="minlen:4" data-msg="Please enter at least 4 chars"/>
						</td>
					</tr>
					<tr>
						<td style="text-align:left;padding:10px;">
							<label style="color:#00AEEF;">*</label>Cantidad de tickets : 
						</td>
						<td> 
							<input  id="cantidad" type="text" class="form-control entero" data-rule="minlen:4" data-msg="Please enter at least 4 chars"/>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="padding-top:10px" valign="middle" align="center">
							
							<div onclick="envia();" class="service-footer-right">
								<button class="btn" id = 'btn_cotiza' >Cotizar</button>
							</div>
						</td>
					</tr>
				</tbody></table><br>
				</div>


			</div>
		</section>
		<!--service gapping
		<div class="service-footer hidden-xs">
			<div class="container">
				<div class="row">
					<div class="col-md-7">
						<div class="service-footer-left">
							<h3>Need to <span>Consult with us</span> ? Book an appointment</h3>
							<p>The Brady Bunch the Brady Bunch that's the way we all became the Brady Bunch</p>
						</div>
					</div>

					<div class="col-md-5">
						<div class="service-footer-right">
							<button class="btn">book now</button>
						</div>
					</div>
				</div>
			</div>
		</div>-->
	</div>
	<?php
		include 'footer_demo.php';
	?>
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