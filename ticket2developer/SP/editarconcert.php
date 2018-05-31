<?php 
	include("controlusuarios/seguridadSP.php");
	
	$gbd = new DBConn();
	
	echo '<input type="hidden" id="data" value="3" />';
	$id = $_GET['id'];
	echo '<input type="hidden" id="ids" value="'.$id.'" />';
	$select = "SELECT strEstado FROM Concierto WHERE idConcierto = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($id));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	$selectError = "SELECT * FROM ocupadas WHERE concierto = ?";
	$stmterror = $gbd -> prepare($selectError);
	$stmterror -> execute(array($id));
	$numrow = $stmterror -> rowCount();
	echo '<input type="hidden" id="numrows" value="'.$numrow.'" />';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
				Desactivar Concierto
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px 0; text-align:center; color:#fff; font-size:22px;">
				<table id="select_conciertos" style="width:100%; color:#fff; font-size:18px; border-collapse:separate; border-spacing:15px 15px;">
					<tr style="text-align:center;">
						<td>
							<p><strong>Estado del Concierto:</strong></p>
							<select id="est_con" class="inputlogin">
								<option value="0">Seleccione...</option>
								<?php if($row['strEstado'] == 'Activo'){?>
								<option value="Inactivo">Inactivo</option>
								<?php }else{?>
								<option value="Activo">Activo</option>
								<?php }?>
							</select>
						</td>
					</tr>
					<tr style="text-align:center;">
						<td>
							<p><strong>Observaciones: </strong></p>
							<textarea rows="5" cols="50" id="obsCambio" placeholder="Motivos de desactivaci&oacute;n del Concierto" class="inputlogin"></textarea>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="text-align:center; margin:20px; padding:20px 0;">
				<button type="submit" class="btndegradate" id="enviar" onclick="enviarDatos()">GUARDAR</button>&nbsp;&nbsp;&nbsp;
				<button type="button" class="btndegradate" id="cancel" onclick="cancel()">CANCELAR</button>
				<img src="imagenes/loading.gif" id="wait" alt="please wait" style="display:none;"/>
			</div>
		</div>
	</div>
</div>
<script>
function enviarDatos(){
	var rowok = $('#numrows').val();
	if(rowok == 0){
		$('#enviar').fadeOut('fast');
		$('#wait').fadeIn('slow');
		var estado = $('#est_con').val();
		var obs = $('#obsCambio').val();
		var ids = $('#ids').val();
		$.post('SP/eliminarconcierto.php',{
			estado : estado, obs : obs, ids : ids
		}).done(function(data){
			if($.trim(data) == 'Activo'){
				alert('El Concierto a sido Habilitado');
				window.location.href = '?modulo=listaEvento';
			}else if($.trim(data) == 'Inactivo'){
				alert('El Concierto a sido Inhabilitado');
				window.location.href = '?modulo=listaEvento';
			}
		});
	}else{
		alert('Imposible desactivar, ya tienes boletos vendidos');
		window.location.href = '?modulo=listaEvento';
	}
}

function cancel(){
	window.location.href = '?modulo=listaEvento';
}
</script>