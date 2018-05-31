<?php 
	include("controlusuarios/seguridadSP.php");
	
	$gbd = new DBConn();
	
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="3" />';
	$perfil = 'Admin';
	$select = "SELECT idUsuario, strNombreU FROM Usuario WHERE strPerfil = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($perfil));
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				Lista de Conciertos
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px 0; text-align:center; color:#fff; font-size:18px;">
				<strong>Concierto por Administrador: &nbsp;&nbsp;</strong>
				<select id="conbyAdmin" class="inputlogin">
					<option value="0">Seleccione...</option>
					<?php while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){?>
					<option value="<?php echo $row['idUsuario'];?>"><?php echo $row['strNombreU'];?></option>
					<?php }?>
				</select>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="border:2px solid #00ADEF; margin:40px; text-align:center;">
				<table id="select_conciertos" style="width:100%; color:#fff; font-size:16px; border-collapse:separate; border-spacing:15px 15px;">
					<tr style="text-align:center;">
						<td>
							<strong>Evento</strong>	
						</td>
						<td>
							<strong>Lugar</strong>
						</td>
						<td>
							<strong>Imagen</strong>
						</td>
						<td>
							<strong>Estado</strong>
						</td>
						<td>
							<strong>Localidades</strong>
						</td>
						<td>
							<strong>Artistas</strong>
						</td>
						<td>
							<strong>Acci&oacute;n</strong>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
$('#conbyAdmin').on('change', function(){
	var exist = $('.rowsUser').length;
	var currentUser = $('#user').val();
	if(exist > 0){
		$('.rowsUser').remove();
	}else{
		var nombre = $('#conbyAdmin').val();
		$.post('SP/searchconcerts.php',{
			nombre : nombre
		}).done(function(json){
			var obj = jQuery.parseJSON(json);
			var busqueda = obj.Search;
			for(i=0; i <= (obj.Concierto.length -1); i++){
				var id = obj.Concierto[i].id;
				var fecha = obj.Concierto[i].fecha;
				var lugar = obj.Concierto[i].lugar;
				var evento = obj.Concierto[i].evento;
				var imagen = obj.Concierto[i].imagen;
				var estado = obj.Concierto[i].estado;
				if(estado == 'Activo'){
					$('#select_conciertos').append('<tr class="rowsUser" style="text-align:center;">\
													<td>'+evento+'</td>\
													<td>'+lugar+'</td>\
													<td><img src="spadmin/'+imagen+'" style="width:100px;"/></td>\
													<td id="stade'+id+'">'+estado+'</td>\
													<td><a href="?modulo=eliminarLocal&id='+id+'" class="btnlink">Modificar</a></td>\
													<td><a href="?modulo=eliminarArt&id='+id+'" class="btnlink">Modificar</a></td>\
													<td><a href="?modulo=eliminarConcierto&id='+id+'" class="btnlink">Desactivar</a></td>\
												</tr>');
				}else{
					$('#select_conciertos').append('<tr class="rowsUser" style="text-align:center;">\
													<td>'+evento+'</td>\
													<td>'+lugar+'</td>\
													<td><img src="spadmin/'+imagen+'" style="width:100px;"/></td>\
													<td id="stade'+id+'">'+estado+'</td>\
													<td><a href="?modulo=eliminarLocal&id='+id+'" class="btnlink">Modificar</a></td>\
													<td><a href="?modulo=eliminarArt&id='+id+'" class="btnlink">Modificar</a></td>\
													<td><a href="?modulo=eliminarConcierto&id='+id+'" class="btnlink">Activar</a></td>\
												</tr>');
				}
				if(estado == 'Inactivo'){
					$('#stade'+id).css({'background':'#16F40B',
									'color':'#000'});
				}
			}
			if(jQuery.isEmptyObject(obj.Concierto)){
				$('#conbyAdmin').val(0);
				alert('No hay CONCIERTOS con este Admin');
			}
		});
	}
});
</script>