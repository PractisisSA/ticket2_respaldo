<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Validacion de TICKETS</title>
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div id="ocultar" style="background-color:#282B2C; text-align:center; padding-bottom:40px;">
			<div style="padding-top:30px;">
				<img src="img/ticketblanco.png" style="width:100%; max-width:300px;"/>
			</div>
			<br>
			<div style="margin:30px 60px; border:2px solid #00ADEF; padding:40px;">
				<div style="background-color:#00ADEF; padding:20px; color:#fff; margin: 0 -42px 0 20px; position:relative;">
					<input type="text" id="codigo" name="codigo" style="background:#00709B; border:1px solid #fff;"/>
					<input type="submit" value="ENVIAR" id="enviar" class=".btndegradate" onclick="enviarDatos()" />
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
			</div>
		</div>
		<div id="ok" style="margin:30px; color:#fff; font-size:50px; text-align:center; display:none;">
			<strong>BOLETO CORRECTO</strong>
		</div>
		<div id="ya" style="margin:30px; color:#fff; font-size:50px; text-align:center; display:none;">
			<strong>BOLETO YA USADO</strong>
		</div>
		<div id="error" style="margin:30px; color:#fff; font-size:50px; text-align:center; display:none;">
			<strong>BOLETO INCORRECTO</strong>
		</div>
	</body>
</html>
<script>
$(document).ready(function(){
	$('#codigo').focus();
});
function enviarDatos(){
	var codigo = $("#codigo").val();
	$.post('http://www.lcodigo.com/ticket/validacionmovil.php',{
		codigo : codigo
	}).done(function(data){
		if($.trim(data)=='Boleto Incorrecto'){
			// alert(data);
			$('#error').fadeIn('slow');
			$('#error').delay(1000).fadeOut('slow');
			$('#codigo').val('');
			$('#codigo').focus();
		}else{
			if($.trim(data)=='Boleto Valido'){
				// alert(data);
				$('#ok').fadeIn('slow');
				$('#ok').delay(1000).fadeOut('slow');
				$('#codigo').val('');
				$('#codigo').focus();
			}else{
				if($.trim(data)=='Boleto Ya Usado'){
					// alert(data);
					$('#ya').fadeIn('slow');
					$('#ya').delay(1000).fadeOut('slow');
					$('#codigo').val('');
					$('#codigo').focus();
				}
			}
		}
	});
}
</script>