<?php
	session_start();
	if($_SESSION['admin']!=1){
		header("Location:../index.php");
		exit;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<script src="../js/jquery.js"></script>
		<title>Modulo Accesos TF</title>
		<!--<script src="../js/index.js"></script>-->
		<script src="../js/jquery-ui.min.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.css" />
	</head>
	<body style = 'width:100%;height:100%;background-color:#D5D5D5;'>
		<button type="button" class="btn btn-primary" style = 'float:right;' onclick = 'window.location="salir.php"'>Salir</button>
		<!--
		<div class="row">
			<div class="col-lg-3">
				<img src="../img/ticketfacilnegro.png" style="width:100%; max-width:250px;" />
			</div>
			<div class="col-lg-9" style="text-align:right; vertical-align:middle; padding:20px 0px;">
				<button class="btn btn-success" type="button" onclick="bajardatos()" id="btnbajar">
					<span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span>
					Download
				</button>
				<span id="waitbajar" style="display:none;">Actualizando...<img src="../img/loading.gif" style="max-width:25px;" /></span>
				<button class="btn btn-primary" type="button" onclick="subirdatos()" id="btnsubir">
					<span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span>
					Upload
				</button>
				<span id="waitsubir" style="display:none;">Actualizando...<img src="../img/loading.gif" style="max-width:25px;" /></span>
				<button class="btn btn-danger" type="button" onclick="logout()">
					<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
					Log Out
				</button>
			</div>
		</div>-->
		<!--
		<div class="menu">
			<div class="row" style="margin:15px;">
				<div class="col">
					<div class="col-lg-12">
						<button type="button" class="btn btn-primary form-control" onclick="selectmenu('1')">Sólo Código</button>
					</div>
				</div>
			</div>
			<div class="row" style="margin:15px;">
				<div class="col">
					<div class="col-lg-12">
						<button type="button" class="btn btn-primary form-control" onclick="selectmenu('2')">Código y Cédula</button>
					</div>
				</div>
			</div>
		</div>-->
		<div>
			<div class="row" style="padding-top: 15%">
				<div class="col-lg-4 col-lg-push-4">
					<div class="modal-content" style = '-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);'>
						<div class="modal-header">
							<img src="../../imagenes/ticketfacilnegro.png" width="100px">
							<input id="tipo_conc" type="hidden">
						</div>
						<div class="modal-body" style="padding:0px;">
							<div class="row" style="text-align:center;">
								<div class="col-lg-12" style="margin:0px;padding:10px;">
									<input autofocus="autofocus" class ='form-control numeric' id="boletoCanje" placeholder="Por favor escanee el código de barras de su boleto!" style="width: 100%; height: 50px; text-align: center; background-color: rgb(255, 255, 255);" type="text" onkeyup="this.value = this.value.replace (/[^0-9]/, ''); ">
									<center>
										<div id="recibeBoletoAImprimir">
											<img src="http://ticketfacil.ec/imagenes/loading.gif" style="display:none;" id="loadBoleto" width="100px">
											
										</div>
									</center>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" onclick = 'enviarBoleto();'>Enviar</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="window.location='';">Cancelar</button><br>
							<span id="recibeConsulta1" style="display:none;"></span>
							
						</div>
					</div>
				</div>
			</div>
			<!--<div class="row" style="margin-top:2%;">
				<div class="col-lg-12" style="text-align:center;">
					<button type="button" class="btn btn-primary" onclick="validarIngresocodigo()" id="btnvalidarcodigo">VALIDAR</button><br>
					<img src="../img/loading.gif" style="max-width:25px; display:none;" id="waitvalidarcodigo" />
				</div>
			</div>-->
		</div>
		<div class="cedulacodigo" style="display:none;">
			<div class="row" style="margin-top:10%;">
				<div class="col-lg-4 col-lg-push-4">
					<h4>Código:</h4>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">
							<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
						</span>
						<input type="text" class="form-control" aria-describedby="basic-addon1" id="boletoCanjes" />
					</div>
				</div>
			</div>
			<div class="row" style="margin-top:2%;">
				<div class="col-lg-4 col-lg-push-4">
					<h4>Cédula:</h4>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">
							<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
						</span>
						<input type="text" class="form-control" aria-describedby="basic-addon1" id="cedula">
						<span class="input-group-addon" style="cursor:pointer;" onclick="cedulaManual()">
							Manual
						</span>
					</div>
				</div>
			</div>
			<div class="row" style="margin-top:2%;">
				<div class="col-lg-12" style="text-align:center;">
					<button type="button" class="btn btn-primary" onclick="validarIngreso()" id="btnvalidar">VALIDAR</button><br>
					<img src="../img/loading.gif" style="max-width:25px; display:none;" id="waitvalidar" />
				</div>
			</div>
		</div>
		<div id="boletos" style="display:block;"></div>
		<div class="modal fade" id="smsOK" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#449D44; color:#fff;">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-success" role="alert">
							<span class="glyphicon glyphicon-success-sign" aria-hidden="true"></span>&nbsp;
							<strong>Alerta! </strong>Ticket registrado con éxito, el usuario puede ingresar
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal" onclick = 'window.location="";'>Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="smsError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#C9302C; color:#fff;">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;
							<strong>Alerta! </strong>Este ticket ya esta registrado , el usuario no puede ingresar
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal" onclick = 'window.location="";'>Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="error1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
							<strong>Alerta! </strong>Los campos están vacios.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="noExixte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#EC9B28; color:#fff;">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Alerta!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning" role="alert">
							<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;
							<strong>Alerta! </strong>El código ingresado es incorrecto.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal" onclick = 'window.location="";'>Aceptar</button>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="../jquery.numeric.js"></script>
</html>
	<script>
		$( document ).ready(function() {
			$('.numeric').numeric();
		});
		
		
		function enviarBoleto(){
			var boleto = $("#boletoCanje").val();
			if(boleto == ''){
				alert('Ingresa un boleto');
			}else{
				$("#boletoCanje").blur(); 
				$("#boletoCanje").css('display','none'); 
				$("#loadBoleto").css('display','block'); 
				$.post('canjear.php',{
					boleto : boleto
				}).done(function(data){
					if($.trim(data)==0){
						$('#noExixte').modal('show');
						$('#smsOK').modal('hide');
						$('#smsError').modal('hide');
						setTimeout(function(){
							window.location = '';
						}, 1500);
					}
					else if($.trim(data)==1){
						$('#noExixte').modal('hide');
						$('#smsOK').modal('show');
						$('#smsError').modal('hide');
						setTimeout(function(){
							window.location = '';
						}, 1500);
					}
					else if($.trim(data)==2){
						$('#noExixte').modal('hide');
						$('#smsOK').modal('hide');
						setTimeout(function(){
							window.location = '';
						}, 1500);
						$('#smsError').modal('show');
					}
				});
			}
		}
		$("#boletoCanje").keyup(function(e){
			$("#boletoCanje").css("background-color", "pink");
			var boleto = $("#boletoCanje").val();
			//alert(boleto);
			if(e.keyCode == 13){
				$("#boletoCanje").blur(); 
				$("#boletoCanje").css('display','none'); 
				$("#loadBoleto").css('display','block'); 
				$.post('canjear.php',{
					boleto : boleto
				}).done(function(data){
					if($.trim(data)==0){
						$('#noExixte').modal('show');
						$('#smsOK').modal('hide');
						$('#smsError').modal('hide');
						setTimeout(function(){
							window.location = '';
						}, 1500);
					}
					else if($.trim(data)==1){
						$('#noExixte').modal('hide');
						$('#smsOK').modal('show');
						$('#smsError').modal('hide');
						setTimeout(function(){
							window.location = '';
						}, 1500);
					}
					else if($.trim(data)==2){
						$('#noExixte').modal('hide');
						$('#smsOK').modal('hide');
						$('#smsError').modal('show');
						setTimeout(function(){
							window.location = '';
						}, 1500);
					}
				});
				
			}
		});
		
		$("#boletoCanje").blur(function(){
			$("#boletoCanje").css("background-color", "white");
		});
		
		$(document).ready(function(){
			$('#codigo').focus();
		});

		function selectmenu(data){
			if(data == 1){
				$('.menu').fadeOut('slow');
				$('.solocodigo').delay(600).fadeIn('slow');
			}else{
				$('.menu').fadeOut('slow');
				$('.cedulacodigo').delay(600).fadeIn('slow');
			}
		}

		function saltar(e){
			if(e.which == 13){
				$('#cedula').focus();
			}
		}

		function logout(){
			window.location = '../index.html'; 
		}
	</script>