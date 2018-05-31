<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<script src="js/jquery.js"></script>
		<title>Modulo Accesos TF</title>
		<!--<script src="js/index.js"></script>-->
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" />
	</head>
	<body>
		<div id="login">
			<div style="border:2px solid #1B5583; padding-bottom:20px;">
				<div class="row" style="background-color:#1B5583;">
					<div class="col-lg-12" style="text-align:center; vertical-align:middle;">
						<img src="img/logo.png" style="width:100%; max-width:300px;" />
					</div>
				</div>
				<div class="row" style="margin-top:50px;">
					<div class="col-lg-12">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							</span>
							<input type="text" class="form-control" placeholder="Nombre de Usuario" aria-describedby="basic-addon1" id="username">
						</div>
					</div>
				</div>
				<div class="row" style="margin-top:25px;">
					<div class="col-lg-12">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
							</span>
							<input type="password" class="form-control" placeholder="**********" aria-describedby="basic-addon1" id="pass">
							<span class="input-group-addon">
								<span style="cursor:pointer;" onclick="mostrarpass()" id="mostrar" class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
								<span style="cursor:pointer; display:none;" onclick="mostrarpass()" id="ocultar" class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
							</span>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top:25px; text-align:center;" id="botones">
					<div class="col-lg-12" style="vertical-align:middle;">
						<button class="btn btn-default" type="button">Cancelar</button>
						<button class="btn btn-primary" type="button" onclick="login()">Ingresar</button>
					</div>
				</div>
				<div class="row" style="margin-top:25px; display:none;" id="loading">
					<div class="col-lg-12" style="text-align:center; vertical-align:middle;">
						<img src="img/loading.gif" style="max-width:70px;" />
						<h4>Ingresando al Sistema...</h4>
					</div>
				</div>
			</div>
			<div class="modal fade" id="alerta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header" style="background-color:#C51D34; color:#fff;">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-warning" role="alert">
								<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;
								<strong>Alerta! </strong>Los datos ingresados son incorrectos.
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal" onclick='window.location="";'>Aceptar</button>
						</div>
					</div>
				</div>
			</div>
			<div id="boletos"></div>
		</div>
		<script>
			$( document ).ready(function() {
				console.log( "ready!" );
				$('#username').val(''); 
				$('#pass').val('');
			});
			
			function mostrarpass(){
				if($('#mostrar').is(':visible')){
					$('#pass').prop('type','text');
					$('#mostrar').fadeOut('slow');
					$('#ocultar').delay(600).fadeIn('slow');
				}else{
					$('#pass').prop('type','password');
					$('#ocultar').fadeOut('slow');
					$('#mostrar').delay(600).fadeIn('slow');
				}
			}
			
			function login(){
				var username = $('#username').val();
				var pass = $('#pass').val();
				if(username == '' || pass == ''){
					$('#alerta').modal('show');
					$('#username').val('');
					$('#pass').val('');
				}else{
					$('#botones').fadeOut('slow');
					$('#loading').css('display','block');
					
					$.post("ajaxLogin.php",{ 
						username : username , pass : pass
					}).done(function(data){
						//alert(data)	
						if($.trim(data)=='ok'){
							window.location='subpages/ingreso_sabado.php';
						}
						else if($.trim(data)=='error'){
							$('#alerta').modal('show');
							//window.location = '';
						}
					});
				}
			}
		</script>
	</body>
</html>