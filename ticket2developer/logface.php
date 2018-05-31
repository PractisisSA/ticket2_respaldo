    <?php
		session_start();
		if(isset($_SESSION['usermail'])){
			echo $_SESSION['usermail']."<<>>";
		}else{
			echo 'no';
		}
	?>
	<!DOCTYPE html>  
        <head>  
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
			<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			<!-- Latest compiled and minified CSS -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

			<!-- Optional theme -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

			<!-- Latest compiled and minified JavaScript -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
			<title>Ticketfacil.ec|inicio</title>
            <script>  
				window.fbAsyncInit = function() {
					FB.init({
					  appId      : '420099668326698',
					  xfbml      : true,
					  version    : 'v2.8'
					});
					FB.AppEvents.logPageView();
				  };

				  (function(d, s, id){
					 var js, fjs = d.getElementsByTagName(s)[0];
					 if (d.getElementById(id)) {return;}
					 js = d.createElement(s); js.id = id;
					 js.src = "//connect.facebook.net/en_US/sdk.js";
					 fjs.parentNode.insertBefore(js, fjs);
				   }(document, 'script', 'facebook-jssdk'));
				   
				   
                
					
               
      

                function ingresar() { 
						
                    FB.login(function(response){  
                        validarUsuario();  
                    }, {scope: 'email'});  
                }  
                function validarUsuario() {  
                    FB.getLoginStatus(function(response) {  
                        if(response.status == 'connected') {
							FB.api(
								'/me',
								'GET',
								{"fields":"id,name,birthday,email,gender,permissions"},
								function(response) {
									alert(JSON.stringify(response));
									var id_face = response.id;
									var email_face = response.email;
									var nombre = response.name;
									var birthday = response.birthday;
									var gender = response.gender;
									$('#nombreUsuFace').html('!!!  ' + nombre);
									$('#nombreUsuEmail').html('!!!  ' + email_face);
									$('#nombreUsuPass').html('!!!  ' + id_face);
									$('#fecha').html('!!!  ' + birthday);
									$('#sexo').html('!!!  ' + gender);
									$.post("autenticaFb.php",{ 
									id_face : id_face , email_face : email_face , nombre : nombre , birthday : birthday , gender : gender
									}).done(function(data){
									// alert(data);
									// window.location = '';
									});
								}
							);
                            // FB.api('/me?fields=id,name,email,permissions', function(response) {
								// //alert(JSON.stringify(response));
                               // // alert('Hola ' + response.name);  
							   
                            // });  
                        } else if(response.status == 'not_authorized') {  
                            alert('Debes autorizar la app!');  
                        } else {  
                            alert('Debes ingresar a tu cuenta de Facebook!');  
                        }  
                    });  
               }  
      
            </script>  
        </head>  
        <body>
            <button onclick="ingresar();" type="button" class="btn btn-primary">Ingresar con Facebook</button>
			<div style = 'display:;' >
				<span id = 'nombreUsuFace' >!!!</span>
				<span id = 'nombreUsuEmail' >!!!</span>
				<span id = 'nombreUsuPass' >!!!</span>
				<span id = 'fecha' >!!!</span>
				<span id = 'sexo' >!!!</span>
			</div>
        </body>  
    </html>  