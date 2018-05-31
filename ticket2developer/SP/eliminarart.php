<?php 
	include("controlusuarios/seguridadSP.php");
	echo '<input type="hidden" id="data" value="3" />';
	$id = $_GET['id'];
	echo '<input type="hidden" id="ids" value="'.$id.'" />';
	
	$gbd = new DBConn();
	
	$selectevento = "SELECT strEvento FROM Concierto WHERE idConcierto = ?";
	$stmtevento = $gbd -> prepare($selectevento);
	$stmtevento -> execute(array($id));
	$rowevento = $stmtevento -> fetch(PDO::FETCH_ASSOC);
	$select = "SELECT * FROM Artista WHERE intIdConciertoA = ?";
	$stmtselect = $gbd -> prepare($select);
	$stmtselect -> execute(array($id));
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
				Artitas de <strong><?php echo $rowevento['strEvento'];?></strong>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px 0; text-align:center; color:#fff; font-size:22px;">
				<table id="select_conciertos" style="width:100%; color:#fff; font-size:18px; border-collapse:separate; border-spacing:15px 15px;">
					<tr style="text-align:center; color:#000;">
						<td>
							<strong>Nombre</strong>	
						</td>
						<td>
							<strong>Estado</strong>
						</td>
						<td>
							<strong>Observaciones</strong>
						</td>
						<td>
							<strong>Desactivar</strong>
						</td>
					</tr>
					<?php while($row = $stmtselect -> fetch(PDO::FETCH_ASSOC)){?>
					<tr style="text-align:center;">
						<td>
							<?php echo $row['strNombreA'];?>
						</td>
						<td <?php if($row['strEstadoA'] == 'Inactivo'){echo 'style="background:#16F40B; color:#000;"';}?>>
							<?php echo $row['strEstadoA'];?>
						</td>
						<td>
							<textarea rows="2" cols="10" id="obs<?php echo $row['idArtista'];?>" class="inputlogin" placeholder="Motivos de cambio"></textarea>
						</td>
						<td>
							<?php if($row['strEstadoA'] == 'Activo'){?>
							<a onclick="enviar('<?php echo $row['idArtista']?>')" class="btnlink">Desactivar</a>
							<?php }else if($row['strEstadoA'] == 'Inactivo'){?>
							<a onclick="enviar('<?php echo $row['idArtista']?>')" class="btnlink">Activar</a>
							<?php }?>
						</td>
					</tr>
					<?php }?>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="text-align:center; margin:20px; padding:20px 0;">
				<button type="button" class="btndegradate" id="cancel" onclick="cancel()">CANCELAR</button>
			</div>
		</div>
	</div>
</div>
<script>
function enviar(id){
	var obs = $('#obs'+id).val();
	if (obs == ''){
		alert('Para continuar debe llenar una observacion');
	}else{
		$.post('SP/desactivarart.php',{
			id : id, obs : obs
		}).done(function(data){
			if($.trim(data) == 'Activo'){
				alert('Artista Desactivado');
				window.location = '';
			}else if($.trim(data) == 'Inactivo'){
				alert('Artista Activado');
				window.location = '';
			}
		});
	}
}

function cancel(){
	window.location.href = '?modulo=listaEvento';
}
</script>