<?php
	session_start();
	include("controlusuarios/seguridadusuario.php");
	// require_once('stripe/lib/Stripe.php');
	// Stripe::setApiKey('sk_test_6GSRONySlv39WktvlN4ZloaH');
	
	
	
	$id_cliente = $_SESSION['id'];
	$idConcierto = $_REQUEST['evento'];
	$preciototal = $_POST['total_pagar'];
	
	
	$dir1 = $_POST['dir1'];
	$tel1 = $_POST['tel1'];
	$cel1 = $_POST['cel1'];
	$ident1 = $_POST['ident1'];
	
	echo '<input type="hidden"  id="dir1" value="'.$dir1.'" />';
	echo '<input type="hidden"  id="tel1" value="'.$tel1.'" />';
	echo '<input type="hidden"  id="cel1" value="'.$cel1.'" />';
	echo '<input type="hidden"  id="ident1" value="'.$ident1.'" />';
	
	
	if($preciototal == ''){
		echo "<script>$('#alerta6').fadeIn(); $('#aviso').modal('show');</script>";
	}
	// echo $_SESSION['valida_ocupadas']."es con numeracion";
	// echo $_SESSION['id_area_mapa']."es el area";
	$nombre_cli = utf8_decode($_SESSION['username']);
	$documento_cli = $_SESSION['userdoc'];
	$cantidadboletos = $_POST['num_boletos'];
	if(isset($_POST['codigo'])){
		echo '<table style = "display:none;" ';
		foreach($_POST['codigo'] as $key=>$cod_loc){
			echo'<tr class="datos_compra">
				<td><input type="text" class="codigo" name="codigo" value="'.$cod_loc.'" /></td>
				<td><input type="text" class="row" name="row" value="'.$_POST['row'][$key].'" /></td>
				<td><input type="text" class="col" name="col" value="'.$_POST['col'][$key].'" /></td>
				<td><input type="text" class="chair" name="chair" value="'.$_POST['chair'][$key].'" /></td>
				<td><input type="text" class="des" value="'.$_POST['des'][$key].'"/></td>
				<td><input type="text" class="num" value="'.$_POST['num'][$key].'" /></td>
				<td><input type="text" class="pre" value="'.$_POST['pre'][$key].'"/></td>
				<td><input type="text" class="tot" value="'.$_POST['tot'][$key].'" /></td>
				<td><input type="text" class="id_desc" value="'.$_POST['id_desc'][$key].'" /></td>
				<td><input type="text" class="val_desc" value="'.$_POST['val_desc'][$key].'" /></td>
				<td><input type="text" class="es_para_membresia" value="'.$_POST['es_para_membresia'][$key].'" /></td>
				<td><input type="text" class="tipo" value="'.$_POST['tipo'][$key].'" /></td>
			</tr>';
			
			$codigo = $cod_loc;
			$row=$_POST['row'][$key];
			$col=$_POST['col'][$key];
			$chair=$_POST['chair'][$key];
			$des=$_POST['des'][$key];
			$num=$_POST['num'][$key];
			$pre=$_POST['pre'][$key];
			$tot=$_POST['tot'][$key];
			
			$id_desc=$_POST['id_desc'][$key];
			$val_desc=$_POST['val_desc'][$key];
			$es_para_membresia=$_POST['es_para_membresia'][$key];
			$tipo=$_POST['tipo'][$key];
			
			$compras[]=array("codigo"=>$codigo,"row"=>$row,"col"=>$col ,"chair"=>$chair,"des"=>$des,"num"=>$num,"pre"=>$pre,"tot"=>$tot,"id_desc"=>$id_desc,"val_desc"=>$val_desc,"es_para_membresia"=>$es_para_membresia,"tipo"=>$tipo);
			$totalpago += $_POST['pre'][$key];
		}
		
		// $totalpago = $preciototal;
		$_SESSION['boletos_asignados'] = ($compras);
		// print_r(json_encode($_SESSION['boletos_asignados']));
		$hash = $_SESSION['boletos_asignados'];
		
		$cantidad = count($_POST['codigo'] );
		echo '</table>';
	}
	
	echo '<input type="hidden" id="data" value="3" />';
	//$emailpaypal = trim('paulacarrion18@outlook.com');
	$emailpaypal = trim('ventas@ticketfacil.ec');
	$concepto = 'Ticket Facil';
	$idconcepto = 1;
	$idtransaccion = 1;
	$pagoSeguro = 'Elije tu forma de reserva';
	$vFinal = 'Valor de Compra : ';
	$realize = 'Realice su pago...';
	//$cantidad = 1;
	$resultDesignRoom = $_REQUEST['resultDesignRoom'];
	$amountKidsForReservation = $_REQUEST['amountKidsForReservation'];
?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
	
</script>
<div style="background-color:#282B2D; margin:10px 20px 0px 20px; text-align:center;">
	<div class="breadcrumb">
		<a id="chooseseat" href="?modulo=des_concierto&con=<?php echo $idConcierto;?>" onclick="chooseasientos()">Escoge tu asiento</a>
		<a id="identification" href="#" onclick="identity()">Identificate</a>
		<a id="buy" href="?modulo=comprar&con=<?php echo $idConcierto;?>" onclick="buy()">Resumen de Compra</a>
		<a class="active" id="pay" href="#" onclick="security()">Pagar</a>
		<a id="confirmation" href="#" onclick="security()">Confirmaci&oacute;n</a>
	</div>
</div>
<input type="hidden" id="concert_id" value="<?php echo $idConcierto;?>"/>
<input type="hidden" id="cant" value="<?php echo $cantidadboletos;?>" />
<input type="hidden" name="total" id="total" value="<?php echo $preciototal;?>" />
<input type="hidden" id="CuentaAtras" style="border:none;background:url(http://subtlepatterns.com/patterns/otis_redding.png);"/>
<div style="border:2px; solid #000; margin:-10px 10px;">
	<div style="background-color:#fff; padding:20px;">
		<div style="margin:0px 20px;">
			<table style="width:100%;">
				<tr>
					<td style="text-align:center; vertical-align:middle; width:50%;">
						<img src="imagenes/ticketfacilnegro.png" alt="" />
					</td>
					<td style="text-align:center;">
						<img src="https://stripe.com/img/about/logos/badge/big.svg" alt="" style = 'width:200px;'/>
					</td>
				</tr>
			</table>
		</div>
		<div style="border: 2px solid #000; margin:20px;">
			<div style="margin:40px; border:2px solid #000; color:#000; font-size:20px;">
				<div class="row">
					<div class="col-lg-4"></div>
					<div class="col-lg-4" style="text-align:center; background-color:#00ADEF; color:#fff; font-size:20px; padding:15px 5px;">
						<strong>Pago por Tarjeta de Cr&eacute;dito</strong>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12" style="color:#000; text-align:center;">
						<strong>Datos de Compra</strong>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 titleleft" style="margin:0px; padding:10px;">
						<p><strong>Empresa: </strong></p>
					</div>
					<div class="col-lg-6 titleright" style="margin:0px; padding:10px;">
						<p><strong>TICKETFACIL VENTAS EN L&Iacute;NEA</strong></p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 titleleft" style="margin:0px; padding:10px;">
						<p><strong>Cliente: </strong></p>
					</div>
					<div class="col-lg-6 titleright" style="margin:0px; padding:10px;">
						<p><?php echo ($nombre_cli);?></p>
					</div>
				</div>
				
				<?php
					if($ident1 == 1){
				?>
					<div class="row">
						<div class="col-lg-6 titleleft" style="margin:0px; padding:10px;">
							<p><strong>DIRECCIÓN ENVIO: </strong></p>
						</div>
						<div class="col-lg-6 titleright" style="margin:0px; padding:10px;">
							<p><?php echo $dir1;?></p>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-6 titleleft" style="margin:0px; padding:10px;">
							<p><strong>TELEFONO CONVENCIONAL: </strong></p>
						</div>
						<div class="col-lg-6 titleright" style="margin:0px; padding:10px;">
							<p><?php echo $tel1;?></p>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-6 titleleft" style="margin:0px; padding:10px;">
							<p><strong>TELEFONO CELULAR: </strong></p>
						</div>
						<div class="col-lg-6 titleright" style="margin:0px; padding:10px;">
							<p><?php echo $cel1;?></p>
						</div>
					</div>
				<?php
					}
				?>
				<div class="row">
					<div class="col-lg-6 titleleft" style="margin:0px; padding:10px;">
						<p><strong>Documento de Identidad: </strong></p>
					</div>
					<div class="col-lg-6 titleright" style="margin:0px; padding:10px;">
						<p><?php echo $documento_cli;?></p>
					</div>
				</div>
				<!--<div class="row">
					<div class="col-lg-6 titleleft" style="margin:0px; padding:10px;">
						<p><strong>Valor de Compra : </strong></p>
					</div>
					<div class="col-lg-6 titleright" style="margin:0px; padding:10px;">
						<p><?php echo $preciototal;?></p>
					</div>
				</div>-->
			</div>
			<?php
            $querypay = "SELECT porcpaypal,valpaypal FROM Concierto WHERE idConcierto = ?";
        	$resultpay = $gbd -> prepare($querypay);
        	$resultpay -> execute(array($idConcierto));
            $rowcpay = $resultpay -> fetch(PDO::FETCH_ASSOC);
        	//echo $rowcpay['porcpaypal'].'**'.$rowcpay['valpaypal'];

				/*$comisionPaypal = 5.4;
                $valorPaypal = 0.30;*/
                $comisionPaypal = $rowcpay['porcpaypal'];
                $valorPaypal = $rowcpay['valpaypal'];
				$precioCom = ((($totalpago * $comisionPaypal)/100) + $valorPaypal);
				$precioConComision = ($totalpago + $precioCom);

			?>
			<div style="margin:0px 40px 40px 40px; border:2px solid #000; color:#000; font-size:20px;">
				<form name="frmu" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_xclick">
					<input type="hidden" name="business" value="<?php echo $emailpaypal;?>">
					<input type="hidden" name="item_name" value="<?php echo $concepto;?>">
					<input type="hidden" name="amount" value="<?php echo $precioConComision;?>">
					<input type="hidden" name="item_number" value="<?php echo $idconcepto;?>">
					<input type="hidden" name="quantity" value="1">
					<input type="hidden" name="no_note" value="1">
					<input type="hidden" name="no_shipping" value="1">
					<input type="hidden" name="first_name" value="">
					<input type="hidden" name="country" value="ES">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="return" value='https://www.ticketfacil.ec/ticket2developer/?modulo=pagoPaypalok&idConcierto=<?php echo $idConcierto;?>&id_cliente=<?php echo $id_cliente;?>&valida_ocupadas=<?php echo $_SESSION['valida_ocupadas'];?>&id_area_mapa=<?php echo $_SESSION['id_area_mapa'];?>&tel1=<?php echo $tel1;?>&dir1=<?php echo $dir1;?>&ident1=<?php echo $ident1;?>&totalpago=<?php echo $totalpago;?>&cel1=<?php echo $cel1;?>'>                      
					<input type="hidden" name="cancel_return" value="https://www.ticketfacil.ec/ticket2developer/?modulo=pagoPaypal&evento=<?php echo $idConcierto;?>">
					<input type="hidden" name="rm" value="2">
					<input type="hidden" name="cpp_header_image" value="LOGOTIPO">

					<table width='500px' height='200px' align='center'>

						<tr>
							<td colspan = '2'>
								<center>
									<h3><?php echo $vFinal; ?><b><?php echo number_format(($totalpago),2);?> USD</b></h3>
								</center><br>
								<center>
									<h3>Comision Paypal (<?php echo $comisionPaypal;?>%) + <?php echo number_format(($valorPaypal),2);?>ctvs : <b><?php echo number_format(($precioCom),2);?> USD</b></h3>
								</center><br>
								<center>
									<h3>Valor Final de Pago : <b><?php echo number_format(($precioConComision),2);?> USD</b></h3>
								</center>
							</td>
						</tr>
						<tr>
							<td>
								<center>
									<button type="submit" class="btn btn-primary" name="submit" >Pagar Paypal</button><!--onclick='verificaPago("<?php echo $idUsuario;?>" , "<?php echo $fecha;?>" , "<?php echo $esp;?>"  , "<?php echo $hora;?>")'-->
								</center>
							</td>
							<td>
								<!--<center>
									<button type="button" class="btn btn-warning" onclick='soloReservar()'>Solo Reserva</button>
								</center>-->
							</td>
						</tr>
						<tr>
							<td colspan='2' style='padding-top:10px;padding-bottom:10px;'>
								<!--
								<div class="alert alert-info alert-dismissable" style='font-size:12px;background-color:rgb(77,211,244,0.5);'>
									<strong>Atención!</strong> Si ud tiene tarifa preferencial solo agende, y cancele el valor de la cita en el consultorio del doctor.
								</div>-->
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div style="margin:0px 40 20px 40px; text-align:center;">
				<img src="imagenes/tarjetas.png" style="max-width:270px;"/>&nbsp;
				<img src="imagenes/dinners.png" style="max-width:70px; margin-left:-15px; margin-top:-7px" />&nbsp;
				<img src="imagenes/Pacificard.gif" style="max-width:180px; margin-left:-13px; margin-top:-1px;" />
			</div>
			<div style="margin:0px 40 40px 40px; text-align:center;">
				<img src="https://stripe.com/img/about/logos/badge/big.svg" alt="" style = 'width:100px;'/><br><br>
			</div>
			<div class="modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
						</div>
						<div class="modal-body">
							<h4 id="alerta1" class="alertas" style="display:none;">
								<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Excelente!</strong>&nbsp;Tu pago se ha completado con exito.
								</div>
							</h4>
							<h4 id="alerta2" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;El tiempo de la transacción ha terminado.
								</div>
							</h4>
							<h4 id="alerta3" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Debes volver a seleccionar tus asientos.
								</div>
							</h4>
							<h4 id="alerta4" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;En este paso ya no puedes modificar tus datos.
								</div>
							</h4>
							<h4 id="alerta5" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Llena el formulario y dale click en "ENVIAR PAGO".
								</div>
							</h4>
							<h4 id="alerta6" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert">
									<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Los asientos seleccionados se han perdido, seleccionalos nuevamente.
								</div>
							</h4>
							<h4 id="alerta7" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert">
									<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;&nbsp;<strong>Aviso!</strong>&nbsp;Uno o mas de tus asientos ya se han reservado.<br>
									Vuelve a escoger tus asientos.
								</div>
							</h4>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarModal()">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>		
<script type="text/javascript">
	$(document).ready(function(){
		// $(document).keydown(function(event){
			// if(event.keyCode==123){
				// return false;
			// }
			// else if (event.ctrlKey && event.shiftKey && event.keyCode==73){        
					 // return false;
			// }
		// });

	// $(document).on("contextmenu",function(e){        
		// e.preventDefault();
	// });
	
	
	
	
	
	// $(document).bind("contextmenu",function(e){
        // return false;
    // });
	$(window).resize(function(){
		var width = $(window).width();
		if(width < 1024){
			$('.titleright').css({'text-align':'center'});
			$('.titleleft').css({'text-align':'center'});
		}else{
			$('.titleleft').css({'text-align':'right'});
			$('.titleright').css({'text-align':'left'});
		}
	});
	var width = $(window).width();
	if(width < 1024){
		$('.titleright').css({'text-align':'center'});
		$('.titleleft').css({'text-align':'center'});
	}else{
		$('.titleleft').css({'text-align':'right'});
		$('.titleright').css({'text-align':'left'});
	}
});

var idcon = $('#concert_id').val();
var preciot = $('#total').val();
// if(preciot === ''){
	// window.location = '?modulo=des_concierto&con='+idcon;
// }

function justInt(e,value){
	if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46)){
		return;
	}
	else{
		e.preventDefault();
	}
}

function chooseasientos(){
	$('#alerta3').fadeIn();
	$('#aviso').modal('show');
}

function identity(){
	$('#alerta4').fadeIn();
	$('#aviso').modal('show');
}

function security(){
	$('#alerta5').fadeIn();
	$('#aviso').modal('show');
}

function aceptarModal(){
	var recibeBoletosVendidos = $('#recibedetalledeBoletosVendidos').html();
	if(!$('#alerta1').is(':hidden')){
		window.location = '?modulo=pagotarjetaok';
	}else if(!$('#alerta2').is(':hidden')){
		window.location = '?modulo=des_concierto&con='+idcon;
	}else if(!$('#alerta3').is(':hidden')){
		window. location = '?modulo=des_concierto&con='+idcon;
	}else if(!$('#alerta6').is(':hidden')){
		window. location = '?modulo=des_concierto&con='+idcon;
	}else if(!$('#alerta7').is(':hidden')){
		window. location = '?modulo=des_concierto&con='+idcon;
	}
	$('.alertas').fadeOut();
	$('#aviso').modal('hide');
}

var totalTiempo=200+200;
var timestampStart = new Date().getTime();
var endTime=timestampStart+(totalTiempo*1000);
var timestampEnd=endTime-new Date().getTime();
var tiempRestante=totalTiempo;

updateReloj();

function updateReloj() {
	var Seconds=tiempRestante;
	
	var Days = Math.floor(Seconds / 86400);
	Seconds -= Days * 86400;

	var Hours = Math.floor(Seconds / 3600);
	Seconds -= Hours * (3600);

	var Minutes = Math.floor(Seconds / 60);
	Seconds -= Minutes * (60);

	var TimeStr = ((Days > 0) ? Days + " dias " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds);
	//var TimeStr = LeadingZero(Hours+(Days*24)) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds);
	document.getElementById('CuentaAtras').innerHTML = TimeStr;
	if(endTime<=new Date().getTime())
	{
		document.getElementById('CuentaAtras').innerHTML = "00:00:00";
	}else{
		tiempRestante-=1;
		setTimeout("updateReloj()",1000);
	}
}

function LeadingZero(Time) {
	return (Time < 10) ? "0" + Time : + Time;
}
setTimeout("$('#alerta2').fadeIn(); $('#aviso').modal('show');",480000);
</script>