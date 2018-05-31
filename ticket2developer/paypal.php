<!DOCTYPE html>

<html>

<head>
  <title>Pago PayPal</title>
</head>

<body>
<?php
$emailpaypal = trim('ventas@ecuadorcitasmedicas.com');
$concepto = 'ecuadorcitasmedicas.com';
$idconcepto = 1;
$idtransaccion = 1;
$pagoSeguro = 'Elije tu forma de reserva';
$vFinal = 'Su pago final es de : ';
$realize = 'Realice su pago...';
$cantidad = 1;
$resultDesignRoom = $_REQUEST['resultDesignRoom'];
$amountKidsForReservation = $_REQUEST['amountKidsForReservation'];
?>
<style>
	#soloReservar:hover{
		cursor:pointer;
		-webkit-box-shadow: 3px 3px 3px 0px rgba(50, 50, 50, 0.9);
		-moz-box-shadow:    3px 3px 3px 0px rgba(50, 50, 50, 0.9);
		box-shadow:         3px 3px 3px 0px rgba(50, 50, 50, 0.9);
	}
</style>
<div style="position: relative;margin: 0px auto;width: 450px;" id='contienePagoFinalPaypal'>
<form name="frmu" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_blank">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="<?php echo $emailpaypal;?>">
    <input type="hidden" name="item_name" value="<?php echo $concepto;?>">
    <input type="hidden" name="amount" value="<?php echo $monto;?>">
    <input type="hidden" name="item_number" value="<?php echo $idconcepto;?>">
    <input type="hidden" name="quantity" value="<?php echo $cantidad;?>">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="first_name" value="">
    <input type="hidden" name="country" value="ES">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="return" value="http://www.ecuadorcitasmedicas.com/dashboard/ajax/confirma.php?id=<?php echo $hash;?>">
    <input type="hidden" name="cancel_return" value="http://www.ecuadorcitasmedicas.com/dashboard/ajax/cancela.php">
    <input type="hidden" name="rm" value="2">
    <input type="hidden" name="cpp_header_image" value="LOGOTIPO">
	<table width='400px' height='200px' align='center'>
		<tr>
			<td valign='middle' align='center' colspan='2'>
				<h3><?php echo $pagoSeguro;?></h3>
			</td>
		</tr>
		<tr>
			<td colspan = '2'>
				<center>
					<h3><?php echo $vFinal; ?><b><?php echo $monto;?> USD</b></h3>
				</center>
			</td>
		</tr>
		<tr>
			<td>
				<center>
					<button type="submit" class="btn btn-primary" name="submit" onclick='verificaPago("<?php echo $idUsuario;?>" , "<?php echo $fecha;?>" , "<?php echo $esp;?>"  , "<?php echo $hora;?>")'>Pagar Paypal</button>
				</center>
			</td>
			<td>
				<center>
					<button type="button" class="btn btn-warning" onclick='soloReservar()'>Solo Reserva</button>
				</center>
			</td>
		</tr>
		<tr>
			<td colspan='2' style='padding-top:10px;padding-bottom:10px;'>
				<div class="alert alert-info alert-dismissable" style='font-size:12px;background-color:rgb(77,211,244,0.5);'>
					<strong>Atención!</strong> Si ud tiene tarifa preferencial solo agende, y cancele el valor de la cita en el consultorio del doctor.
				</div>
			</td>
		</tr>
	</table>
</form>
</div>
<div id="msjpago" style="display:none;width: 100%;text-align: center;color: #D6960B;font-size: 25px;"><?php echo $realize;?></div>
<?php
// }else{
  // echo '<div style="width: 100%;text-align: center;color: #CC0000;">No hay disponibilidad.<br>Por favor vuelva a verificar la disponibilidad en el paso 1.</div>';
// }
?>
	<script>
		
		// function verificaPago(idUsuario,fecha,esp,hora){
			// var sincroniza =  setInterval(function(){
				// alert(fecha);
				// $('#msjpago').fadeIn(300);
				// $.ajax({
					// type: 'POST',
					// url: 'ajax/verificaPago.php',
					// data: 'fecha='+ fecha +'&idUsuario='+ idUsuario+'&esp='+esp+'&hora='+hora,
					// success: function(response){
						// if(response==1){
							// document.getElementById('msjpago').style.color='#1FB30F';
							// document.getElementById('msjpago').innerHTML='Pago realizado exitosamente.';
							// clearInterval(sincroniza);
							// setTimeout(function() {
							// window.location='';
							// }, 5000);
						// }
					// }
				// });
			// }, 5000);
		// }
	</script>
</body>
</html>