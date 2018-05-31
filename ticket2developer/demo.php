<?php
	session_start();
	$estado = 'Activo';
	$hoy = date('Y-m-d');
	include 'conexion.php';
	
	$sqlU = 'update Concierto set es_publi = 2 where dateFecha < "'.$hoy.'"';
	$resU = mysql_query($sqlU) or die (mysql_error());
	
	$sqlU1 = 'update Concierto set es_publi = 1 where dateFecha >= "'.$hoy.'"';
	$resU1 = mysql_query($sqlU1) or die (mysql_error());
	
	if(array_key_exists('modulo', $_GET)){
    	$subpage = $_GET['modulo'];
    }
	else{
		$subpage = 'start'; 
	}
	   
	$subpages = array(
		'start' => 'demo_cliente/load.php',
		'evento' => 'demo_cliente/evento.php',
		'publicacion' => 'demo_cliente/publicacion.php',
		'localidad' => 'demo_cliente/localidad.php', 
		'asientos' => 'demo_cliente/asientos.php',
		'contacto' => 'demo_cliente/contacto.php',
		'registro' => 'demo_cliente/registro.php',
		'noticias' => 'demo_cliente/noticias.php',
		'terminos_condiciones' => 'demo_cliente/terminosCondiciones.php',
		'login' => 'demo_cliente/login.php',
		'register' => 'demo_cliente/register.php',
		'revisa_compra' => 'demo_cliente/revisa_compra.php',
		'compra' => 'demo_cliente/compra.php'
	);
	 
	if(array_key_exists($subpage, $subpages)) {
		$subpagePath = $subpages[$subpage];
	}
	else{
		$subpagePath = 'subpages/fileNotFound.php';
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Ticket Facil - Inicio</title>
	<meta name="google-site-verification" content="EkfaLa2r9IE15e84u4tmPalg2ghTF_5m-M-ltQQIk0o" />
	<meta name="keywords" content="tickets , entradas partidos , entradas conciertos , tickets partidos , tickets conciertos , conciertos , eventos , partidos de futbol , convenciones , expociciones , tickets para viajes interprovinciales">
	<meta name="description" content="es un sistema creado para que el publico pueda comprar cualquier clase de ticket a cualquier evento ,espectaculo , partido de futbol , concierto , convencion , expocicion o para comprar tickets para viajes interprovinciales">
	<meta name="author" content="fabricio carrion , practisis s.a.">
	<meta name="copyright" content="fabricio carrion">
	<meta name="robots" content="index, follow">
	<link rel="icon" href="https://livedemo00.template-help.com/landing_58100/images/favicon.ico" type="image/x-icon">
	<meta name="description" content="Free Bootstrap Theme by BootstrapMade.com">
	<meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">
	<meta name="google-signin-client_id" content="888800978669-ocjtqig3s763l7erklsp5v58j69b2h0r.apps.googleusercontent.com">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans|Open+Sans|Raleway" rel="stylesheet">
	<link rel="stylesheet" href="css/flexslider.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style_demo.css">
	<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>

	<script>
		(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.8&appId=420099668326698";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
</head>

<body id="top" data-spy="scroll">
	<?php
		include 'head_demo.php';
	?>
	<div id="column1">
	</div>
	<div id="column">
	</div>
    
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">ticketfacil.ec</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form>
			  <div class="form-group">
			    <label for="">Perfil:</label>
			    <select id="userProfile" class="form-control">
			    	<option value="0">Seleccione su perfil</option>
			    	<option value="1">Personal TF</option>
			    	<option value="2">Cliente</option>
			    </select>
			  </div>
			  <div class="form-group">
			    <label for="">Email</label>
			    <input type="text" class="form-control" id="loginEmail" placeholder="Email" readonly>
			  </div>
			  <div class="form-group">
			    <label for="">Password</label>
			    <input type="text" class="form-control" id="loginPassword" placeholder="Password" readonly>
			  </div>
			</form>
	      </div>
	      <div class="modal-footer">
	      	<div class="row">
	      		<div class="col-md-3"><a class="g-signin2" data-onsuccess="onSignIn" class="btn btn-danger social-login-btn social-google" name=""><i class="fa fa-google-plus fa-2x"></i></a></div>
	      		<div class="col-md-3">
	      			<a onclick="ingresar();" class="btn btn-primary social-login-btn social-facebook" name="">
						<i class="fa fa-facebook fa-1x">
							<label class="access-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Acceder&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						</i>
					</a>
				</div>
	      		<div class="col-md-3"><button onclick="enviarLogin()" type="button" class="btn btn-primary">Enviar</button></div>
	      		<div class="col-md-3"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button></div>
	      	</div>
	      	<br>
	      	<div class="row">
	      		<div class="col-md-12">
	      			<a onclick="recuperarContrasena();">¿Olvido su contraseña?</a>
	      		</div>
	      	</div>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal fade" id="myModalError" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">ticketfacil.ec</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      </div>
	      <div class="modal-footer">
	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal fade" id="myModalReset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">ticketfacil.ec</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<input id="resetEmail" type="text" class="form-control" placeholder="Ingrese su correo registrado en ticketfacil"></input>
	      </div>
	      <div class="modal-footer">
	      	<button onclick="resetPassword()" type="button" class="btn btn-primary">Enviar</button>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">ticketfacil.ec</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form>
			  <div class="form-group">
			    <label for="">Email *</label>
			    <input type="text" class="form-control" id="mail" placeholder="Email:">
			  </div>
			  <div class="form-group">
			    <label for="">Nombres y apellidos *</label>
			    <input type="text" class="form-control" id="nombre" placeholder="Nombres y apellidos:">
			  </div>
			  <div class="form-group">
			    <label for="">Documento # *</label>
			    <input type="text" class="form-control" id="documento" placeholder="Documento de identidad:">
			  </div>
			  <div class="form-group">
			    <label for="">Fecha de nacimiento *</label>
			    <input type="date" class="form-control" id="birthday" placeholder="Fecha nacimiento:">
			  </div>
			  <div class="form-group">
			    <label for="">Teléfono *</label>
			    <input type="phone" class="form-control" id="tmov" placeholder="Teléfono:">
			  </div>
			  <div class="form-group">
			    <label for="">Dirección</label>
			    <input type="text" class="form-control" id="direccion" placeholder="Dirección:">
			  </div>
			  <div class="form-group">
			    <label for="">Género</label>
			    <select id="genero" class="form-control">
			    	<option value="0">Seleccione:</option>
			    	<option value="1">Femenino</option>
			    	<option value="2">Masculino</option>
			    </select>	
			  </div>
			  <div class="form-group">
			    <label for="">Password *</label>
			    <input type="text" class="form-control" id="password" placeholder="Password:">
			  </div>
			  <div class="form-group">
			    <label for="Condiciones">Al registrarte estas aceptando los <a target="_blank" href="http://ticketfacil.ec/ticket2developer/demo.php?modulo=terminos_condiciones">Términos y condiciones</a> de ticketfacil.ec</label>
			  </div>
			  
			</form>
	      </div>
	      <div class="modal-footer">
	      	<div class="row">
	      		<div class="col-md-4"><div class="col-md-4"><div class="g-signin2" data-onsuccess="onSignIn">Acceder con google</div></div></div>
	      		<div class="col-md-4"><button onclick="enviar();" type="button" class="btn btn-primary">Enviar</button></div>
	      		<div class="col-md-4"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button></div>
	      	</div>
	      </div>
	    </div>
	  </div>
	</div>
	<!--slider-->
	<?php
		include $subpagePath;
	?>
	<?php
		include 'footer_demo.php';
	?>
	</div>		
</body>
	<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ver_sms_cotizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
						&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;
					</div>
				</div>
				<div class="modal-body" id = 'recibe_cotizar'>
					
				</div>
				<div class="modal-footer"  >
					
				</div>
			</div>
		</div>
	</div>
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
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<script type="text/javascript">
  // initialize Account Kit with CSRF protection
  	$('#userProfile').change(function () {
  		var userProfile = $('#userProfile').val();

  		$('#loginEmail').attr('readonly', false);
  		$('#loginPassword').attr('readonly', false);

  	})
  	function resetPassword(){
  		var mail = $('#resetEmail').val();
  		if (mail == '') {
  			alert('Debe ingresar un correo!');
  		}else{
  			$.post('subpages/Conciertos/recuperarcontrasena.php',{mail : mail}).done(function(response){
				if($.trim(response) == 'ok'){
					alert('Hemos enviado un mail a su cuenta!')
				}else if($.trim(response) == 'error'){
					alert('Asegurese que el email ingresado se encuentre registrado en el sistema!');
				}
			});
  		}
  	}
  	function recuperarContrasena() {
  		$('#myModalReset').modal('show');
  	}

  	function enviarLogin() {
  		var userProfile = $('#userProfile').val();
  		if ($('#loginEmail').val() == '') {
  			alert('Debe ingresar un usuario!');
  		}else if($('#loginPassword').val() == ''){
  			alert('Debe ingresar un password');
  		}else{
  			if (userProfile == 0) {
	  			alert('Debe ingresar un tipo de usuario!');
	  		}else if (userProfile == 1) {
	  			var user = $('#loginEmail').val();
				var pass = $('#loginPassword').val();
				var usercli = '';
				var passcli = '';
	  		}else{
	  			var user = '';
				var pass = '';
				var usercli = $('#loginEmail').val();
				var passcli = $('#loginPassword').val();
	  		}

			$.post('controlusuarios/control.php', {
				user : user, pass : pass, usercli: usercli, passcli : passcli
			}).done(function (data) {
				if($.trim(data) == 'errorchange' || $.trim(data) == 'errorcli' || $.trim(data) == 'inactivo' || $.trim(data) == 'errorcli' || $.trim(data) == 'error') {
					alert('No se pudo iniciar sesion, verifique los datos e intente de nuevo!');
				}else{
					location.reload();
				}
			})
  		}
  		
  	}

  	function ingresar() {  
		FB.login(function(response){  
			validarUsuario();  
		}, {scope: 'email'});  
	}
	function validarUsuario() {
		var con = $('#con').val();
		var pos = $('#pos').val();
		FB.getLoginStatus(function(response) {  
			if(response.status == 'connected') {  
				FB.api(
					'/me',
					'GET',
					{"fields":"id,name,birthday,email,gender,permissions"},
					function(response) {
						var id_face = response.id;
						var email_face = response.email;
						var nombre = response.name;
						var birthday = response.birthday;
						var gender = response.gender;
						$.post("autenticaFb.php",{ 
							id_face : id_face , email_face : email_face , nombre : nombre , birthday : birthday , gender : gender
						}).done(function(data){
							location.reload();
						});
					}
				);
			} else if(response.status == 'not_authorized') {  
				alert('Debes autorizar la app!');  
			} else {  
				alert('Debes ingresar a tu cuenta de Facebook!');  
			}  
		});  
   }
    
	function enviar(){
		var nombres = $('#nombre').val();
		var documento = $('#documento').val();
		var birthday = $('#birthday').val();
		var genero = $('#genero').val();
		var mail = $('#mail').val();
		var pass = $('#password').val();
		var movil = $('#tmov').val();
		var direccion = $('#direccion').val();

		if (nombres == '' || documento == '' || birthday == '' || mail == '' || pass == '' || movil == '') {
			alert('Debe insertar todos los datos obligatorios!');
		}else{
			$.post('subpages/newaccount1.php',{
				nombres : nombres, documento : documento, birthday: birthday, genero : genero, mail : mail, pass : pass, movil : movil
			}).done(function(data){
				if (data == 'error') {
					alert('Este usuario ya existe!')
				}else{
					var user = data.split("-");
					var name = user[0];
					var email = user[1];
					alert('Sesion Iniciada!');
					$('#xx').html(email);
				    $('#xx').attr('onclick','');
				    $('#yy').html(name);
				    $('#yy').attr('onclick','');
				    $('#zz').css('display','block');
				    $('#yeah').css('display','block');
				    $('#myModal1').modal('hide');
				}
				 
			});
		}
	}
	function onSignIn(googleUser) {

      	var profile = googleUser.getBasicProfile();
		var con = $('#con').val();
		var id_gmail = profile.getId();
		var email_gmail =  profile.getEmail();
		var nombre = profile.getName();
		var birthday = '';
		var gender = '';

	    $('#xx').html(email_gmail);
	    $('#xx').attr('onclick','');
	    $('#yy').html(nombre);
	    $('#yy').attr('onclick','');
	    $('#zz').css('display','block');
	    $('#yeah').css('display','block');
	    $('#myModal').modal('hide');

	    var id_gmail = profile.getId();
		var email_gmail =  profile.getEmail();
		var nombre = profile.getName();
		var birthday = '';
		var gender = '';

		$.post("autenticaGmail.php", {id_gmail : id_gmail, email_gmail : email_gmail, nombre : nombre, birthday : birthday, gender : gender}).done(function(data){$('#justp').val('yes');});

    }

    function onFailure(error) {
      alert(error);
    }

    function renderButton() {
      gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 240,
        'height': 50,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
      });
    }

	function signOut() {
	    var auth2 = gapi.auth2.getAuthInstance();
	    auth2.signOut().then(function () {
	      $('#xx').html('Login');
	      $('#xx').attr('onclick','$("#myModal").modal("show");');
	      $('#yy').html('Register');
	      $('#yy').attr('onclick','$("#myModal1").modal("show");');
	      $('#yeah').css('display','none');
	      $.post("closeSession.php", {close:1}).done(function(data){$('#justp').val('no')});
	    });
	}
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
