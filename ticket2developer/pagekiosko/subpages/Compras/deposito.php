<?php
	require('Conexion/conexion.php');
	$intDeposito = $_GET['cod'];
	$estado = "No";
	$queryCli = "SELECT strNombresC, strDocumentoC, strMailC, strDireccionC, strCiudadC, intTelefonoMovC FROM Deposito JOIN Cliente ON Deposito.idCli = Cliente.idCliente WHERE intCodigoRand = '$intDeposito' AND strDepositoD = '$estado'";
	$resCli = $mysqli->query($queryCli);
	$queryDep = "SELECT idDeposito, intNumBoleto, intFilaD, intColD, strDescripcionL, doublePrecioL FROM Deposito JOIN Localidad ON Deposito.idLoc = Localidad.idLocalidad WHERE intCodigoRand = '$intDeposito' AND strDepositoD = '$estado'";
	echo $queryDep;
	$resDep = $mysqli->query($queryDep);
	$queryCon = "SELECT strEvento, dateFecha, timeHora FROM Deposito JOIN Concierto ON Deposito.idCon = Concierto.idConcierto WHERE intCodigoRand = '$intDeposito' AND strDepositoD = '$estado'";
	$resCon = $mysqli->query($queryCon);
	$registros_dep = mysqli_num_rows($resDep);
	$registros_con = mysqli_num_rows($resCon);
	$registros_cli = mysqli_num_rows($resCli);
	if(($registros_dep == 0) || ($registros_con == 0) || ($registros_cli == 0)){
		echo "<script>alert('Tu deposito ya fue registrado');window.location='?modulo=start';</script>";
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
	
	$selectPrePreventa = "SELECT doublePrecioPreventa FROM Deposito JOIN Localidad ON Deposito.idLoc = Localidad.idLocalidad JOIN Concierto ON Deposito.idCon = Concierto.idConcierto WHERE dateFechaPreventa >= CURRENT_DATE AND intCodigoRand = '$intDeposito' AND strDepositoD = '$estado'";
	$resSelectPreventa = $mysqli->query($selectPrePreventa);
	$resultadoPreventa = mysqli_num_rows($resSelectPreventa);
	$rowPreventa = mysqli_fetch_array($resSelectPreventa);
	echo '<input type="hidden" id="idCliente" value="'.$rowCli['idCliente'].'" />';
	
?>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="js/jquery.datetimepicker.css"/>
<script src="js/jquery.datetimepicker.js"></script>
<script src="js/jquery.ui.draggable.js" type="text/javascript"></script>
<div style="margin:10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; margin-right:50%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Informaci&oacute;n del Dep&oacute;sito</strong>
			</div>
			<div style="background-color:#EC1867; margin:30px -42px 10px 600px; font-size:30px; color:#fff; position:relative; padding:10px;">
				Datos del Cliente
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
			<div style="background-color:#00ADEF; margin-left:40px; margin-top:20px; margin-right:-42px; position:relative; padding: 20px 50px 10px 20px;">
				<table class="table-response" style="width:100%; color:#fff; font-size:20px; border-collapse: separate; border-spacing: 20px 15px;">
					<tr>
						<td colspan="2" style="text-align:center">
							<p>Sr(a). <strong><?php echo $nombre;?></strong></p>
						</td>
					</tr>
					<tr>
						<td style="text-align:right; width:50%;">
							<p>Documento de Identidad: </p>
						</td>
						<td style="text-align:left">
							<strong><?php echo $documento;?></strong>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							<p>E-mail: </p>
						</td>
						<td style="text-align:left">
							<strong><?php echo $mail;?></strong>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							<p>Direcci&oacute;n: </p>
						</td>
						<td style="text-align:left">
							<strong><?php echo $dir;?></strong>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							<p>Tel&eacute;fono M&oacute;vil: </p>
						</td>
						<td style="text-align:left">
							<strong><?php echo $movil;?></strong>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							<p>Ciudad: </p>
						</td>
						<td style="text-align:left">
							<strong><?php echo $ciudad;?></strong>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="background-color:#EC1867; margin:30px 600px 10px -42px; font-size:30px; color:#fff; position:relative; padding:10px;">
				Datos del Evento
				<div class="tra_izq_rojo"></div>
				<div class="par_iz_rojo"></div>
			</div>
			<div style="background-color:#00AEEF; margin:20px 30px 20px -42px; position: relative;">
				<table class="table-response" style="width:100%; color:#fff; font-size:20px; border-collapse: separate; border-spacing: 20px 15px;">
					<tr>
						<td style="text-align:center">
							<p>Evento: </p>
							<p><font size="5"><strong><?php echo $evento;?></strong></font></p>
						</td>
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
				<div class="tra_video_concierto"></div>
				<div class="par_video_concierto"></div>
			</div>
			<div style="background-color:#EC1867; margin:30px -42px 10px 600px; font-size:30px; color:#fff; position:relative; padding:10px;">
				Informaci&oacute;n de Compra
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
			<div style="background-color:#00ADEF; margin-left:40px; margin-top:20px; margin-right:-42px; position:relative; padding: 20px 50px 10px 20px;">
				<table class="table-response" style="width:100%; color:#fff; font-size:20px; border-collapse: separate; border-spacing: 20px 15px;">
					<tr>
						<td style="text-align:center">
							<strong>Localidad</strong>
						</td>
						<td style="text-align:center">
							<strong>Asientos #</strong>
						</td>
						<td style="text-align:center">
							<strong>Cantidad de Boletos</strong>
						</td>
						<td style="text-align:center">
							<strong>Precio Unitario</strong>
						</td>
						<td style="text-align:center">
							<strong>Precio Total</strong>
						</td>
					</tr>
					<?php 
						$suma = 0;
						while($rowDep = mysqli_fetch_array($resDep)){
					?>
					<tr class="pago_dep">
						<td style="text-align:center">
							<input type="hidden" class="codigo" value="<?php echo $rowDep['idDeposito'];?>" />
							<?php echo $rowDep['strDescripcionL'];?>
						</td>
						<td style="text-align:center;">
							Fila-<?php echo $rowDep['intFilaD'];?>_Silla-<?php echo $rowDep['intColD'];?>
						</td>
						<td style="text-align:center">
							<?php echo $rowDep['intNumBoleto'];?>
						</td>
						<td style="text-align:center">
							<?php
								if($resultadoPreventa > 0){
									echo $rowPreventa['doublePrecioPreventa'];
								}else{
									echo $rowDep['doublePrecioL'];
								}
							?>
						</td>
						<?php 
							$num_bol = $rowDep['intNumBoleto'];
							if($resultadoPreventa > 0){
								$precio = $rowPreventa['doublePrecioPreventa'];
							}else{
								$precio = $rowDep['doublePrecioL'];
							}
							$t = ($num_bol * $precio);
							$total = number_format($t,2,'.','');
						?>
						<td style="text-align:center">
							<?php echo $total;?>
						</td>
					</tr>
					<?php
						$suma += $total;
						}
						$precio_total = number_format($suma,2,'.','');
					?>	
					<tr>
						<td colspan="4" style="text-align:center">
							<strong>Precio Total del Dep&oacute;sito</strong>
						</td>
						<td style="text-align:center">
							<strong><?php echo $precio_total;?></strong>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="background-color:#EC1867; margin:30px 600px 10px -42px; font-size:30px; color:#fff; position:relative; padding:10px;">
				Datos del Dep&oacute;sito
				<div class="tra_izq_rojo"></div>
				<div class="par_iz_rojo"></div>
			</div>
			<div style="background-color:#00AEEF; margin:20px 30px 20px -42px; position: relative;">
				<table class="table-response" style="width:100%; color:#fff; font-size:20px; border-collapse: separate; border-spacing: 20px 15px;">
					<tr align="center">
						<td colspan="2">
							<p><h1>Pago por Dep&oacute;sito</h1></p>
						</td>
					</tr>
					<tr>
						<td align="right" style="width:50%;">
							<p><strong># de Dep&oacute;sito: </strong></p>
						</td>
						<td>
							<input type="text" class="inputlogin" name="ndeposito" id="ndeposito" onkeydown="justInt(event,this);"/>
						</td>
					</tr>
					<tr>
						<td align="right">
							<p><strong>Fecha: </strong></p>
						</td>
						<td>
							<input type="text" class="inputlogin" name="fecha" id="fecha" placeholder="AAAA-MM-DD" />
						</td>
					</tr>
					<tr align="center">
						<td colspan="2">
							<button type="submit" class="btndegradate" id="aceptar" name="aceptar" onclick="enviar()"><span>Aceptar</span></button>
						</td>
					</tr>
				</table>
				<div class="tra_video_concierto"></div>
				<div class="par_video_concierto"></div>
			</div>
			<div style="margin:30px; text-align:center;">
				<img alt="logo" src="gfx/logo.png"/>
			</div>
		</div>
	</div>
</div>
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
		
		$.post('subpages/Compras/inserts/add_deposito.php',{
			ndep : ndep, fecha : fecha, dep : dep, valor : variablesF
		}).done(function(data){
			window.location.href = '?modulo=add_depositook';
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
</script>