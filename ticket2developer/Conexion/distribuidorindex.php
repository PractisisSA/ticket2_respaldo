<?php 
	session_start();
	include("controlusuarios/seguridadDis.php");
	
	echo '<input type="hidden" id="data" value="1" />';
	
	
	include 'conexion.php';
	if(isset($_SESSION['idConImprime'])){
		$idConImprime =  $_SESSION['idConImprime'];
		$sqlC = 'select * from Concierto where idConcierto = "'.$idConImprime.'" ';
		$resC = mysql_query($sqlC) or die(mysql_error());
		$rowC = mysql_fetch_array($resC);
		echo '<input type="hidden" id="idConImprime" value="'.$rowC['tipo_conc'].'" />';
	}else{
		echo '<input type="hidden" id="idConImprime" value="0" />';
	}
	
		
	
	
	unset($_SESSION['losBoletos']);
	$_SESSION['losBoletos']='';
	echo $_SESSION['losBoletos']."hola";
	$nombre = $_SESSION['useractual'];
	// $nombre = 'Punto de Venta Ticket Facil';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
				<p class="cabecera_distribuidores">
					<?php
						//echo $_SESSION['tipo_emp'];
						if($_SESSION['tipo_emp'] == 1){
							$txt = 'Ventas Ticket Facil';
						}else{
							$txt = 'Cadena Comercial';
						}
						echo $txt;
					?>
					<?php //echo $nombre." ".$_SESSION['tipo_emp'];?>
				</p>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 20px 40px; position:relative; padding:20px 0 10px; text-align:center; color:#fff; font-size:18px;">
				<button class="btndegradate" id="btn_ventas">Ventas</button>&nbsp;&nbsp;&nbsp;&nbsp;
				<button class="btndegradate" id="btn_reservas">Cobros</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php
				if($_SESSION['tipo_emp'] == 1){
			?>
				<button class="btndegradate" id="btn_canjes">Canje</button>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php
				}
			?>
				<!--<button class="btndegradate" id="elKiosco" onclick="hackKiosko()">Kiosco</button>-->
				<!--<button class="btndegradate" id="elKiosco" onclick="crearBoleto()">Crear Boleto</button>-->
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		</div>
	</div>
</div>

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
				<div class="modal fade" id="canjesBoletos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" onclick="aceptarModalbienvenida()">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<img src="imagenes/ticketfacilnegro.png" width='100px' />
							</div>
							<div class="modal-body" style='padding:0px;'>
								<div class="row" style="text-align:center;">
									<div class="col-lg-12" style='margin:0px;padding:10px;'>
										<input type='text'   autofocus='autofocus' id='boletoCanje' placeholder='Por favor escanee el código de barras de su boleto!' style='width: 90%;height: 50px;text-align: center' />
										<table  style='display:none;' id='contenedorCedula' width='100%' >
											<tr>
												<td valign='middle' align='center' width='70%'>
													<input type='text' maxlength="10" onkeyup="this.value = this.value.replace (/[^0-9]/, ''); " autofocus='autofocus' id='cedulaCanje' placeholder='Por favor ingrese su numero de cedula' style='width:80%;height:50px;text-align:center' />
												</td>
												<td valign='middle' align='center' width='30%'>
													<button type="button" class="btn btn-default" onclick='consultaBoleto2()'> 
														<i class="fa fa-paper-plane-o" aria-hidden="true"></i> Enviar
													</button>
												</td>
											</tr>
										</table>
										
										<center>
											<div id='recibeBoletoAImprimir'>
												<img src='http://ticketfacil.ec/ticket2/imagenes/loading.gif' width='100px' style='display:none;' id='loadBoleto'/>
												
											</div>
										</center>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='cancelaCanje()'>Cancelar</button><br/>
								<span id='recibeConsulta1' style='display:none;'></span>
								
							</div>
						</div>
					</div>
				</div>
<script>
$('#btn_ventas').on('click',function(){
	window.location = '?modulo=ventasDistribuidor';
});

$('#btn_reservas').on('click',function(){
	window.location = '?modulo=reservasDistribuidor';
});
	function consultaBoleto2(){
		var cedula = $('#cedulaCanje').val();
		var datosBoletoValido = $('#recibeConsulta1').html();
		var idConImprime = $('#idConImprime').val();
		var splDatosBV = datosBoletoValido.split('|');
		var boleto = splDatosBV[0];
		var idCli = splDatosBV[1];
		var idCon = splDatosBV[2];
		var idBoleto = splDatosBV[3];
		var tipo_conc = splDatosBV[4];
		
		if(cedula == ''){
			alert('Debe ingresar su numero de cedula');
		}else{
			var cedula = $('#cedulaCanje').val();
			array = cedula.split( "" );
			num = array.length;
			if ( num == 10 ){
				total = 0;
				digito = (array[9]*1);
				for( i=0; i < (num-1); i++ ){
					mult = 0;
					if ( ( i%2 ) != 0 ) {
						total = total + ( array[i] * 1 );
					}
					else{
						mult = array[i] * 2;
						if ( mult > 9 )
							total = total + ( mult - 9 );
						else
						  total = total + mult;
					}
				}
				decena = total / 10;
				decena = Math.floor( decena );
				decena = ( decena + 1 ) * 10;
				valorfinal = ( decena - total );
				if ( ( valorfinal == 10 && digito == 0 ) || ( valorfinal == digito ) ) {
					if(tipo_conc == 2){
						$("#loadBoleto").css('display','block'); 
						$.post('distribuidor/emailConciertoElectronico.php',{
							idBoleto : idBoleto , idCon : idCon
						}).done(function(data){
							alert(data);
							window.location = '';
						});
					}else{
						$('#cedulaCanje').css('border','1px solid #000');
						$("#loadBoleto").css('display','block'); 
						$.post('template/imprimeBoleto.php',{
							boleto : boleto , idCli : idCli , cedula : cedula , idBoleto : idBoleto
						}).done(function(data){
							if(data != 0){
								var mywindow = window.open('', 'Receipt', 'height=800,width=600');
								mywindow.document.write('<html><head><title></title>');
								mywindow.document.write('</head><body >');
								mywindow.document.write(data);
								mywindow.document.write('</body></html>');

								mywindow.print();
								mywindow.close();
								window.location = '';
								$('#contenedorCedula').css('display','none');
							}else{
								$('#recibeBoletoAImprimir').html('<h1 style="color:red;">Error numero de cedula invalido !!!</h1><br/>por favor vuelva a ingresarlo <br/>www.ticketfacil.ec/');
							}
						});
					}
				}else{
					alert( "La c\xe9dula ingresada es incorrecta" );
					$('#cedulaCanje').css('border','1px solid red');
					return false;
				}
			}
			else
			{
				alert("La c\xe9dula no puede tener menos de 10 d\xedgitos");
				return false;
			}
		}
	}
	$(function() {
		console.log('ready');
		$("#boletoCanje").focus();
	});
	function cancelaCanje(){
		window.location='';
	}
	$("#boletoCanje").keyup(function(e){
        $("#boletoCanje").css("background-color", "pink");
		var boleto = $("#boletoCanje").val();
		//alert(boleto);
		if(e.keyCode == 13){
			$("#boletoCanje").blur(); 
			$("#boletoCanje").css('display','none'); 
			$("#loadBoleto").css('display','block'); 
			$.post('http://ticketfacil.ec/distribuidor/ventas/ajax/consultaBoleto1.php',{
				boleto : boleto
			}).done(function(data){
				$("#contenedorCedula").css('display','none'); 
				if($.trim(data) == 3){
					//alert(data);
					$('#contenedorCedula').css('display','none');
					$('#recibeBoletoAImprimir').html('<div style="width:380px;">\
														<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:12px;">\
															<tr>\
																<td style="text-align:center;">\
																	<img src="http://ticketfacil.ec/ticket2/imagenes/ticketfacilnegro.png" style="width:100%;"/>\
																</td>\
															</tr>\
															<tr>\
																<td style="text-align:left;font-size:12px;">\
																	<h2 style="padding-top: 0px;"><strong style="color:red;"><center>Atención !!!</center></strong></h2><br/>\
																	Error ! no puede canjear otro boleto porque ud ya tiene el real.  </b>\
																</td>\
															</tr>\
														</table>\
													</div>');
				}
				
				
				else if($.trim(data) == 1){
					$('#contenedorCedula').css('display','none');
					$('#recibeBoletoAImprimir').html('<div style="width:380px;">\
														<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:12px;">\
															<tr>\
																<td style="text-align:center;">\
																	<img src="http://ticketfacil.ec/ticket2/imagenes/ticketfacilnegro.png" style="width:100%;"/>\
																</td>\
															</tr>\
															<tr>\
																<td style="text-align:left;font-size:12px;">\
																	<h2 style="padding-top: 0px;"><strong style="color:red;"><center>Atención !!!</center></strong></h2><br/>\
																	Su boleto ya ha sido impreso por favor comuniquese con nosotros  </b>\
																</td>\
															</tr>\
														</table>\
													</div>');
				}
				
				else if($.trim(data) == 2){
					$('#contenedorCedula').css('display','none');
					$('#recibeBoletoAImprimir').html('<div style="width:380px;">\
														<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:12px;">\
															<tr>\
																<td style="text-align:center;">\
																	<img src="http://ticketfacil.ec/ticket2/imagenes/ticketfacilnegro.png" style="width:100%;"/>\
																</td>\
															</tr>\
															<tr>\
																<td style="text-align:left;font-size:12px;">\
																	<h2 style="padding-top: 0px;"><strong style="color:red;"><center>Atención !!!</center></strong></h2><br/>\
																	Codigo incorrecto, por favor verifique y vuelva a ingresar.  </b>\
																</td>\
															</tr>\
														</table>\
													</div>');
				}
				
				
				else if($.trim(data) == 0){
					
					$('#contenedorCedula').css('display','none');
					$('#recibeBoletoAImprimir').html('<div style="width:380px;">\
														<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:12px;">\
															<tr>\
																<td style="text-align:center;">\
																	<img src="http://ticketfacil.ec/ticket2/imagenes/ticketfacilnegro.png" style="width:100%;"/>\
																</td>\
															</tr>\
															<tr>\
																<td style="text-align:left;font-size:12px;">\
																	<h2 style="padding-top: 0px;"><strong style="color:red;"><center>Atención !!!</center></strong></h2><br/>\
																	Todavia no se recibe la información de los permisos para <br/>este concierto <b>no se puede imprimir su boleto</b>\
																</td>\
															</tr>\
														</table>\
													</div>');
				}else{
					$("#loadBoleto").css('display','none'); 
					$("#contenedorCedula").fadeIn('slow'); 
					$('#recibeConsulta1').html(data);
				}
				
			});
			
		}
    });
	$("#boletoCanje").blur(function(){
        $("#boletoCanje").css("background-color", "white");
    });
function aceptarModalbienvenida(){}
$('#btn_canjes').on('click',function(){
	//window.location = '?modulo=ventasKiosko';
	//alert('aqui');
	$('#canjesBoletos').modal('show');
	$('#boletoCanje').focus();
});

// $('#btn_reservas').on('click',function(){
	// window.location = '?modulo=conciertos'; 
// });

function imprimirBoleto(){
	var boletoImprime = $('#contieneElBoletoImprime').html();
	var mywindow = window.open('', 'Receipt', 'height=800,width=600');
	mywindow.document.write('<html><head><title></title>');
	mywindow.document.write('</head><body >');
	mywindow.document.write(boletoImprime);
	mywindow.document.write('</body></html>');

	mywindow.print();
	mywindow.close();
	window.location = '';
}
</script>