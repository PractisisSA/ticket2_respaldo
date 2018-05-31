<?php
	require('../Conexion/conexion.php');
	$intDeposito = $_GET['cod'];
	$estado = "No";
	$queryCli = "SELECT strNombresC, strDocumentoC, strMailC, strDireccionC, strCiudadC, intTelefonoMovC FROM Deposito JOIN Cliente ON Deposito.idCli = Cliente.idCliente WHERE intCodigoRand = '$intDeposito' AND strDepositoD = '$estado'";
	$resCli = $mysqli->query($queryCli);
	$queryDep = "SELECT idDeposito, intNumBoleto, strDescripcionL, doublePrecioReserva, doublePrecioL FROM Deposito JOIN Localidad ON Deposito.idLoc = Localidad.idLocalidad WHERE intCodigoRand = '$intDeposito' AND strDepositoD = '$estado'";
	$resDep = $mysqli->query($queryDep);
	$queryCon = "SELECT strEvento, dateFecha, timeHora, dateFechaPReserva FROM Deposito JOIN Concierto ON Deposito.idCon = Concierto.idConcierto WHERE intCodigoRand = '$intDeposito' AND strDepositoD = '$estado'";
	$resCon = $mysqli->query($queryCon);
	$registros_dep = mysqli_num_rows($resDep);
	$registros_con = mysqli_num_rows($resCon);
	$registros_cli = mysqli_num_rows($resCli);
	if(($registros_dep == 0) || ($registros_con == 0) || ($registros_cli == 0)){
		echo "<script>alert('Tu deposito ya fue registrado');window.location='../index.php';</script>";
	}
	$rowCli = mysqli_fetch_array($resCli);
	$nombre = $rowCli['strNombresC'];
	$documento = $rowCli['strDocumentoC'];
	$mail = $rowCli['strMailC'];
	$dir = $rowCli['strDireccionC'];
	$ciudad = $rowCli['strCiudadC'];
	$movil = $rowCli['intTelefonoMovC'];
	$rowCon = mysqli_fetch_array($resCon);
	$evento = $rowCon['strEvento'];
	$fecha = $rowCon['dateFecha'];
	$hora = $rowCon['timeHora'];
	
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>TICKETFACIL</title>
		<link href="../Plantilla/responsive.css" rel="stylesheet" type="text/css" media="all" >
		<link href="../Plantilla/plantilla_ticket_facil.css" rel="stylesheet" type="text/css">
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="../responsive/respond.min.js"></script>
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="../js/jquery.datetimepicker.css"/>
		<script src="../js/jquery.datetimepicker.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Roboto:300,700,400' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="../imagenes/3334img_logotodoticket.ico">
		<link href="../js/jquery.alerts.css" rel="StyleSheet" type="text/css" />
		<script src="../js/jquery.ui.draggable.js" type="text/javascript"></script>
		<script src="../js/jquery.alerts.mod.js" type="text/javascript"></script>
		<style>
			.boton {
				display: inline-block;
				zoom: 1; /* zoom and *display = ie7 hack for display:inline-block */
				*display: inline;
				vertical-align: baseline;
				margin: 2px;
				outline: none;          /* remove dotted border in FF */
				cursor: pointer;
				text-align: center;
				text-decoration: none;
				font: 14px/100% Roboto, sans-serif;
				padding: .5em 1.75em .55em;
				text-shadow: 0 1px 1px rgba(0,0,0,.3);
				-webkit-border-radius: .5em;
				-moz-border-radius: .5em;
				border-radius: .5em;
				-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
				-moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
				box-shadow: 0 1px 2px rgba(0,0,0,.2);
				}
			.boton:hover {
				text-decoration: none;
				}
			.boton:active {
				position: relative;
				top: 1px;
				}
			.boton.black {
				color: #d7d7d7;
				border: solid 1px #333;
				background: #333;
				background: -webkit-gradient(linear, left top, left bottom, from(#666), to(#000));
				background: -moz-linear-gradient(top,  #666,  #000);
				filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#666666', endColorstr='#000000');
			}
			.boton.black:hover {
				background: #000;
				background: -webkit-gradient(linear, left top, left bottom, from(#444), to(#000));
				background: -moz-linear-gradient(top,  #444,  #000);
				filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#444444', endColorstr='#000000');
			}
			.boton.black:active {
				color: #666;
				background: -webkit-gradient(linear, left top, left bottom, from(#000), to(#666666));
				background: -moz-linear-gradient(top,  #000,  #666666);
				filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#000000', endColorstr='#666666');
			}
			#datos{
				width: 100%;
				max-width: 1100px;
				border: 2px solid #c0c0c0;
			}
			#datos td{
				border: none;
			}
			#clint{
				width: 100%;
				max-width: 580px;
				border: none;
				float: left;
			}
			#clint td{
				border: none;
			}
			#event{
				width: 100%;
				max-width: 580px;
				border: none;
				float: right;
			}
			#event td{
				border: none;
			}
			table.deposito{
				width: 100%;
				max-width: 1100px;
				border: 2px solid #c0c0c0;
			}
			table.deposito td{
				border: none;
			}
			.boletos{
				width: 100%;
				max-width: 1100px;
				border: 2px solid #c0c0c0;
			}
			.boletos td{
				border: none;
			}
		</style>
	</head>
	<body>
		<div id="container">
			<div class="cabecera" id="cabecera">
			</div>
			<div id="header" class="logo">
				<div id="logo">
					<a href="../index.php"><img src="../imagenes/LogoB_N.png" style="width: 100%; max-width: 350px; padding-left: 20px;" /></a>
				</div>
				<div id="account">
					<img src="../imagenes/acount.png" style="width: 100%; max-width: 328px;" />
				</div>
			</div>
			<div id="menu" class="menu">
				<?php include("../includes/menuadmin.php");?>
			</div>
			<div id="contenido" class="contenido">		
				<div style="background-image: url(http://subtlepatterns.com/patterns/debut_light.png);">
					<br>
					<table id="datos" align="center">
						<tr>
							<td>
								<table id="clint">
									<tr>
										<td colspan="2" style="text-align:center">
											<p><strong><h2>Datos del Cliente</h2></strong></p>
										</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align:center">
											<p>Sr(a). <strong><?php echo $nombre;?></strong></p>
										</td>
									</tr>
									<tr>
										<td style="text-align:left">
											<p>Documento de Identidad: </p>
											<p><strong><?php echo $documento;?></strong></p>
										</td>
										<td style="text-align:left">
											<p>E-mail: </p>
											<p><strong><?php echo $mail;?></strong></p>
										</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align:center">
											<p>Direcci&oacute;n: </p>
											<p><strong><?php echo $dir;?></strong></p>
										</td>
									</tr>
									<tr>
										<td style="text-align:left">
											<p>Tel&eacute;fono M&oacute;vil: </p>
											<p><strong><?php echo $movil;?>
										</td>
										<td style="text-align:left">
											<p>Ciudad: </p>
											<p><strong><?php echo $ciudad;?></strong></p>
										</td>
									</tr>
								</table>
							</td>
							<td>
								<table id="event">
									<tr style="text-align:center">
										<td colspan="2" style="text-align:center">
											<p><strong><h2>Datos del Evento</h2></strong></p>
										</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align:center">
											<p>Evento: </p>
											<p><font size="5"><strong><?php echo $evento;?></strong></font></p>
										</td>
									</tr>
									<tr>
										<td style="text-align:center">
											<p>Fecha: </p>
											<p><font size="4"><strong><?php echo $fecha;?></strong></font></p>
										</td>
										<td style="text-align:center">
											<p>Hora: </p>
											<p><font size="4"><strong><?php echo $hora;?></strong></font></p> 
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table class="boletos" align="center">
						<tr>
							<td style="text-align:center">
								<strong>Localidad</strong>
							</td>
							<td style="text-align:center">
								<strong>Precio Normal</strong>
							</td>
							<td style="text-align:center">
								<strong>Precio Reserva</strong>
							</td>
							<td style="text-align:center">
								<strong>Precio Total</strong>
							</td>
						</tr>
						<?php 
							$suma = 0;
							$suma_normal = 0;
							while($rowDep = mysqli_fetch_array($resDep)){
						?>
						<tr class="pago_dep">
							<td style="text-align:center">
								<input type="hidden" class="codigo" value="<?php echo $rowDep['idDeposito'];?>" />
								<?php echo $rowDep['strDescripcionL'];?>
							</td>
							<td style="text-align:center">
								<?php echo $rowDep['doublePrecioL'];?>
							</td>
							<td style="text-align:center">
								<?php echo $rowDep['doublePrecioReserva'];?>
							</td>
							<?php 
								$num_bol = $rowDep['intNumBoleto'];
								$precio = $rowDep['doublePrecioReserva'];
								$t = ($num_bol * $precio);
								$total = number_format($t,2,'.','');
							?>
							<td style="text-align:center">
								<?php echo $total;?>
							</td>
						</tr>
						<?php
							$suma += $total;
							$suma_normal += $rowDep['doublePrecioL'];
							}
							$precio_total = number_format($suma,2,'.','');
							$precio_normal = number_format($suma_normal,2,'.','');
							$diferencia = $precio_normal - $precio_total;
						?>	
						<tr>
							<td colspan="3" style="text-align:center">
								<strong>Precio Total del Dep&oacute;sito</strong>
							</td>
							<td style="text-align:center; border-top:2px solid #000;">
								<strong><?php echo $precio_total;?></strong>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="text-align:center;">
								Te recordamos que la diferencia adeudada es de: <font size="4"><strong>$<?php echo $diferencia;?></strong></font> y la puedes pagar hasta el: <font size="4"><strong><?php echo $rowCon['dateFechaPReserva'];?></strong></font>
							</td>
						</tr>
					</table>
					<br>
					<table align="center" border="1" class="deposito">
						<tr align="center">
							<td colspan="2">
								<p><h1>Pago por Dep&oacute;sito</h1></p>
							</td>
						</tr>
						<tr>
							<td align="right">
								<p><strong># de Dep&oacute;sito: </strong></p>
							</td>
							<td>
								<input type="text" name="ndeposito" id="ndeposito" required onkeydown="justInt(event,this);"/>
							</td>
						</tr>
						<tr>
							<td align="right">
								<p><strong>Fecha: </strong></p>
							</td>
							<td>
								<input type="text" name="fecha" id="fecha" placeholder="AAAA-MM-DD" />
							</td>
						</tr>
						<tr align="center">
							<td colspan="2">
								<button type="submit" class="boton black" target="_parent" id="aceptar" name="aceptar" onclick="enviar()"><span>Aceptar</span></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div id="footer" class="footer">
				<div id="content_info">
					<table width="100%">
						<tr>
							<td rowspan="2">
								<img src="../imagenes/LogoB_N.png" alt="" />
							</td>
							<td style="vertical-align: bottom" class="main_bootom">
								<a href="../index.php" style="text-decoration: none"><img src="../imagenes/indicador_main_bottom.png" />&nbsp;&nbsp;&nbsp;HOME</a>
							</td>
							<td style="vertical-align: bottom">
								<img src="../imagenes/img_facebook.png" style="width: 100%; max-width: 40px;" />
							</td>
						</tr>
						<tr>
							<td style="vertical-align: middle"  class="main_bootom">
								<a href="../somos.php" style="text-decoration: none"><img src="../imagenes/indicador_main_bottom.png" class="img_bottom" style="display:none" />&nbsp;&nbsp;&nbsp;QUIENES SOMOS</a>
							</td>
							<td style="vertical-align: bottom">
								<img src="../imagenes/icono-twitter-2.png" style="width: 100%; max-width: 40px;" />
							</td>
						</tr>
						<tr>
							<td>
								<font size="6" color="#fff">&nbsp;&nbsp;&nbsp;1-800-ticketfacil</font>
							</td>
							<td  class="main_bootom">
								<a href="../conciertos.php" style="text-decoration:none"><img src="../imagenes/indicador_main_bottom.png" class="img_bottom" style="display:none" />&nbsp;&nbsp;&nbsp;CONCIERTOS</a>
							</td>
						</tr>
						<tr>
							<td>
								<font size="6" color="#fff">&nbsp;&nbsp;&nbsp;1-800-4567098</font>
							</td>
							<td class="main_bootom">
								<a href="../p_venta.php" style="text-decoration: none"><img src="../imagenes/indicador_main_bottom.png" class="img_bottom" style="display:none" />&nbsp;&nbsp;&nbsp;PUNTOS DE VENTA</a>
							</td>
						</tr>
						<tr>
							<td>
								<font size="4" color="#fff">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;info@ticketfacil.com</font>
							</td>
							<td class="main_bootom">
								<a href="../contacto.php" style="text-decoration: none"><img src="../imagenes/indicador_main_bottom.png" class="img_bottom" style="display:none" />&nbsp;&nbsp;&nbsp;CONTACTOS</a>
							</td>
						</tr>
					</table>
				</div>
				<div id="info">
					<font color="white">Todos los derechos reservados</font> <font color="blue">ticketfacil</font>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		$('#fecha').datetimepicker({
			timepicker: false,
			minDate:0,
			mask:true,
			format:'Y/m/d',
			minDate: '-1970/05/02',
			maxDate: '0'
		});
	});
	
	function enviar(){
		var ndep = $('#ndeposito').val();
		var fecha = $('#fecha').val();
		var dep = $('#id_dep').val();
		var valor = '';
		
		$('.pago_dep').each(function(){
			var cod = $(this).find('td .codigo').val();
			valor += cod +'|'+'@';
		});
		var variablesF = valor.substring(0,valor.length -1);
		
		$.post('inserts/add_deposito.php',{
			ndep : ndep, fecha : fecha, dep : dep, valor : variablesF
		}).done(function(data){
			window.location.href = 'inserts/add_depositook.php';
		});
	}
	
	function justInt(e,value){
		if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46)){
			return;
		}
		else{
			e.preventDefault();
		}
	}
	
	function justInt(e,value){
		if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46)){
			return;
		}
		else{
			e.preventDefault();
		}
	}
</script>