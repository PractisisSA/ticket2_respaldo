<input type="hidden" id="data" value="5" />
<div style="margin:10px -10px;">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; margin-right:50%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Cont&aacute;ctenos</strong>
			</div>
			<div style="background-color:#00ADEF; margin-left:40px; margin-top:75px; margin-right:-42px; position:relative; padding:10px 75px 15px 0px;">
				<table class="table-response" style="width:100%; color:#fff; font-size:22px; border-collapse: separate; border-spacing: 20px 15px;">
					<tr>
						<td style="text-align:right; width:50%;">
							<p>Nombre:(*)</p>
						</td>
						<td style="text-align:left">  
								<input type="text" class="inputlogin" name="txt_nombre" id="txt_nombre" required="required" />
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							<p>E-mail:(*)</p>
						</td>
						<td style="text-align:left">
								<input type="text" class="inputlogin" name="txt_mail" id="txt_mail" required="required" />	
						</td>
					 </tr>
					 <tr>
						<td style="text-align:right">
							<p>Tel&eacute;fono:</p>
						</td>
						<td style="text-align:left">
							<input onblur="validart()" class="inputlogin" onkeydown="justInt(event,this);" type="text" id="tel" name="tel" required="required" placeholder="0900000000" maxlength="10" />
						</td>
					</tr>
					<tr>
						<td style="text-align:right">
							<p>Direcci&oacute;n:</p>
						</td>
						<td style="text-align:left">
							<input type="text" id="dir" class="inputlogin" name="dir" required="required" />
						</td>
					</tr>
					 <tr>
						<td style="text-align:right">
							<p>Asunto:(*)</p>
						</td>
						<td style="text-align:left">
							<select id="txt_asunto" class="inputlogin" name="txt_asunto" required="required">
								<option value="Reclamo"><strong>Reclamo</strong></option>
								<option value="Solicitud de Socio"><strong>Solocitud de Socio</strong></option>
							</select>
						</td>
					 </tr>
					 <tr>
						<td style="text-align:right">
							<p>Mensaje:(*)</p>
						</td>
						<td style="text-align:left">
								<textarea name="txt_mensaje" class="inputlogin" id="txt_mensaje" required="required"></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<p>&nbsp;</p>
						</td>
						<td>
							<button type="submit" class="btndegradate" name="btn_enviar" id="btn_enviar" onclick="envia()">ENVIAR MENSAJE
							<img src="imagenes/ajax-loader.gif" alt="" id="imgif" name="imgif" style="display:none" /></button>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="margin:30px; text-align:center;">
				<img alt="logo" src="gfx/logo.png"/>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function envia(){
		var nombre = $('#txt_nombre').val();
		var mail = $('#txt_mail').val();
		var tel = $('#tel').val();
		var dir = $('#dir').val();
		var asunto = $('#txt_asunto').val();
		var mensaje = $('#txt_mensaje').val();
		if ((nombre === '')&&(mail === '')&&(aunto === '')&&(mesanje === '')){
			alert('Campos vacios');
		}else{
			$('#btn_enviar').css('display','none');
			$('#imgif').css('display','block');
			$.post('contactook.php',{
				nombre : nombre, mail : mail, asunto : asunto, mensaje : mensaje, tel : tel, dir : dir
			}).done(function(data){
				alert(data);
				window.location = 'index.php';
			});
		}
	}
</script>
