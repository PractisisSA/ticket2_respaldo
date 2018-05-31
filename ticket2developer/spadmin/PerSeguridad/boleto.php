<html>
	<head>
	</head>
	<body>
		<div name="barcode" id="barcode" style="display:block">
			<table width="100%">
				<tr align="center">
					<td colspan="2" bgcolor="yellow">
						<p><strong>Control de Ingreso por C&oacute;digo de Barras</strong></p>
					</td>
				</tr>
				<tr align="center">
					<td>
						<br>
						<p>C&oacute;digo: <input type="text" name="boletobar" id="boletobar"/></p>
						<br>
					</td>
					<td>
						<br>
						<p>C&eacute;dula: <input type="text" name="cedulabar" id="cedulabar"/></p>
						<br>
					</td>
				</tr>
				<tr align="center">
					<td valign='middle' align='center'>
						<label id ='correctobar' style='display:none;'>Boleto Correcto</label>
						<label id ='incorrectobar' style='display:none;'>Boleto Incorrecto</label>
						<label id ='entrobar' style='display:none;'>Boleto Ya Usado</label>
						<label id ='sinbar' style='display:none;'>Campo vacio</label>
						<br>
					</td>
				</tr>
				<tr align="center">
					<td colspan="2">
						<!--<input type="button"  value="RevisarCB" />-->
						<button type="button" class="boton black" target="_parent" id="ingresobar" name="ingresobar" onclick='enviabar()'><span>RevisarCB</span></button>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
<script type="text/javascript">
	function enviabar(){
		var boletob = $('#boletobar').val();
		var cedulab = $('#cedulabar').val();
		if ((boletob != '') && (cedulab != '')){
			$.post('compararbar.php',{
				boletob : boletob, cedulab : cedulab
			}).done(function(data){
				if($.trim(data)=='ok'){
					$('#sinbar').css('display','none');
					$('#entrobar').css('display','none');
					$('#incorrectobar').css('display','none');
					$('#correctobar').fadeIn('slow');
				}else{
					if($.trim(data)=='ya'){
						$('#sinbar').css('display','none');
						$('#correctobar').css('display','none');
						$('#incorrectobar').css('display','none');
						$('#entrobar').fadeIn('slow');
					}else{
						$('#sinbar').css('display','none');
						$('#entrobar').css('display','none');
						$('#correctobar').css('display','none');
						$('#incorrectobar').fadeIn('slow');
					}
				}
			});
		}else{
			$('#correctobar').css('display','none');
			$('#incorrectobar').css('display','none');
			$('#entrobar').css('display','none');
			$('#sinbar').fadeIn('slow');
		}
	}
	
</script>