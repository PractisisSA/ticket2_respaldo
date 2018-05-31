<?php
	session_start();
	include 'conexion.php';
	echo $_SESSION['iduser'];
	
	$sqlM = 'select socio from modulo_admin where id_usuario = "'.$_SESSION['iduser'].'" ';
	//echo $sqlM;
	echo "<input type = 'hidden' id = 'iduser' value = '".$_SESSION['iduser']."'  />";
	$resM = mysql_query($sqlM) or die (mysql_error());
	$rowM = mysql_fetch_array($resM);
	
	$currentUser = $_SESSION['iduser'];
	
	if($_SESSION['autentica'] == 'tFADMIN_SOCIO'){
		
		$filtro = 'and idUsuario = "'.$rowM['socio'].'" ';
	}else{
		$filtro = '';
	}
	
	
	require('Conexion/conexion.php');
	$perfil = 'Socio';
	$currentUser = $_SESSION['iduser'];
	$selectSocio = 'SELECT idUsuario, strNombreU FROM Usuario WHERE strPerfil = "'.$perfil.'" '.$filtro.' ' or die(mysqli_error());
	$resultSelectSocio = $mysqli->query($selectSocio);
	echo '<input type="hidden" id="data" value="2" />';
	echo '<input type="hidden" id="currentUser" value="'.$currentUser.'" />';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div class="modal" id="modalAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-keyboard="false" data-backdrop="static">
				<div class="modal-dialog" role="document">
					<div class="modal-content" style="background-color:#333333; color:#fff;">
						<div class="modal-body">
							<button type="button" onclick="closeModal()" class="close" aria-label="Close">
					        	<span aria-hidden="false">&times;</span>
					        </button>
							<div id="content">
								<strong>Ingrese la clave de administrador</strong>
								<strong>Evento: <div id="eventoAdmin"></div></strong>
								<div class="form-group">
								    <label for="password">Password</label>
								    <input type="password" class="form-control" id="adminPassword" placeholder="Password">
							  	</div>
							  	<button onclick="editEvento()" class="btn btn-primary">Enviar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal" id="modalAdmin1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-keyboard="false" data-backdrop="static">
				<div class="modal-dialog" role="document">
					<div class="modal-content" style="background-color:#333333; color:#fff;">
						<div class="modal-body">
							<div id="content">
								<h4>Clave incorrecta! Por favor intente de nuevo</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				Conciertos
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:18px;">
				<strong>Concierto por Socio: &nbsp;&nbsp;&nbsp;</strong>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="border:2px solid #00ADEF; margin:40px; text-align:center;">
				<table id="select_conciertos" style="width:100%; color:#fff; font-size:16px; border-collapse:separate; border-spacing:15px 5px;">
					<tr style="text-align:center">
						<td>
							<p><strong>Imagen</strong></p>
						</td>
						<td>
							<p><strong>Evento</strong></p>
						</td>
						<!--
						<td>
							<p><strong>Lugar</strong></p>
						</td>
						<td>
							<p><strong>Fecha</strong></p>
						</td>
						<td>
							<p><strong>Hora</strong></p>
						</td>-->
						<td>
							<p id="barCode"><strong>Codigo de Barra</strong></p>
						</td>
						<td>
							<p id="partnerAction"><strong>Acci&oacute;n</strong></p>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$( document ).ready(function() {
		$('#editButton').on('click', function () {
			console.log('pressed');
			alert('Ingrese contraseña de superadministrador');
		});
		var id = $('#iduser').val();
		var currentUser = $('#currentUser').val();
		$.post('spadmin/buscarConciertoXSocio_2.php',{
			id : id
		}).done(function(json){
			var obj = jQuery.parseJSON(json);
			var busqueda = obj.Search;
			var boton = '';
			if (currentUser == 1) {
				for(i=0; i <= (obj.Concierto.length -1); i++){
				var id = obj.Concierto[i].id;
				var imagen = obj.Concierto[i].imagen;
				var evento = obj.Concierto[i].evento;
				var lugar = obj.Concierto[i].lugar;
				var fecha = obj.Concierto[i].fecha;
				var hora = obj.Concierto[i].hora;
				var num_resp = obj.Concierto[i].num_resp;
				if(num_resp != 0){
					boton = '<button type="button" id = "conciento_'+id+'" class="btn btn-warning">Asignado <<'+ num_resp +'>></button>';
				}else{
					boton = '<button type="button" id = "conciento_'+id+'" class="btn btn-primary" onclick = "asignar_codigos_barra(' +id+ ')" > Asignar <<&nbsp;&nbsp;>><img src ="http://ticketfacil.ec/ticket2/imagenes/loader.gif" style = "width:25px;display:none;" id = "loadCon_'+id+'"/> </button>';
				}
				// <td>'+lugar+'</td>\
				// <td>'+fecha+'</td>\
				// <td>'+hora+'</td>\
				$('#select_conciertos').append('\
										<tr class="filas_con" style="text-align:center">\
											<td style="border: 1px solid #fff"><img src="spadmin/'+imagen+'" id="img_con"/><br><span style="color: #00ADEF;font-size: 10px;">'+id+'<span></td>\
											<td style="border: 1px solid #fff">\
												'+evento+'<br>\
												'+lugar+'<br>\
												'+fecha+'<br>\
												'+hora+'\
											</td>\
											<td style="border: 1px solid #fff">\
												'+boton+'\
											</td>\
											<td style="border: 1px solid #fff">\
												<a href="?modulo=editConcierto&id='+id+'" target="_top"><button type="button" class="btn btn-primary">Editar Evento</button></a><br>\
												<a href="?modulo=eliminarLocal&id='+id+'" target="_top"><button type="button" class="btn btn-success">Ver Localidad</button></a><br>\
												<a href="?modulo=descuentoEventoDetalle&id='+id+'" target="_top"><button type="button" class="btn btn-info">&nbsp;Descuentos&nbsp;</button></a>\
											</td>\
										</tr>');
				}
			}else{
				var barCode = $('#barCode').css('display', 'none');
				var partnerAction = $('#partnerAction').css('display', 'none');
				for(i=0; i <= (obj.Concierto.length -1); i++){
				var id = obj.Concierto[i].id;
				var imagen = obj.Concierto[i].imagen;
				var evento = obj.Concierto[i].evento;
				var lugar = obj.Concierto[i].lugar;
				var fecha = obj.Concierto[i].fecha;
				var hora = obj.Concierto[i].hora;
				var num_resp = obj.Concierto[i].num_resp;
				if(num_resp != 0){
					boton = '<button type="button" id = "conciento_'+id+'" class="btn btn-warning">Asignado <<'+ num_resp +'>></button>';
				}else{
					boton = '<button type="button" id = "conciento_'+id+'" class="btn btn-primary" onclick = "asignar_codigos_barra(' +id+ ')" > Asignar <<&nbsp;&nbsp;>><img src ="http://ticketfacil.ec/ticket2/imagenes/loader.gif" style = "width:25px;display:none;" id = "loadCon_'+id+'"/> </button>';
				}
				$('#select_conciertos').append('\
										<tr class="filas_con" style="text-align:center">\
											<td style="border: 1px solid #fff"><img src="spadmin/'+imagen+'" id="img_con"/><br><span style="color: #00ADEF;font-size: 10px;">'+id+'<span></td>\
											<td style="border: 1px solid #fff">\
												'+evento+'<br>\
												'+lugar+'<br>\
												'+fecha+'<br>\
												'+hora+'\
											</td>\
											<td style="border: 1px solid #fff">\
												'+boton+'\
											</td>\
											<td style="border: 1px solid #fff">\
												<a href="?modulo=editConcierto&id='+id+'" target="_top"><button type="button" class="btn btn-primary">Editar Evento</button></a><br><a href="?modulo=eliminarLocal&id='+id+'" target="_top"><button type="button" class="btn btn-success">Ver Localidad</button></a><br>\
												<a href="?modulo=descuentoEventoDetalle&id='+id+'" target="_top"><button type="button" class="btn btn-info">&nbsp;Descuentos&nbsp;</button></a>\
											</td>\
										</tr>');
				}
			}
			
		});
		$('.filas_con').remove();

	}); 
	
	function asignar_codigos_barra(id){
		$('#loadCon_'+id).fadeIn('fast');
		$.post("spadmin/asigna_codigos_barra.php",{ 
			id : id 
		}).done(function(data){
			alert(data);
			window.location = '';
		});
	}
	var idEvent;
	var passwordAdmin = "876543";
	function validateUser(id) {
		idEvent = id;
		$('#modalAdmin').modal('show');
		$('#eventoAdmin').html(idEvent);
	}
	function editEvento() {
		var passwordForAdmin = $('#adminPassword').val();
		if (passwordAdmin != passwordForAdmin) {
			$('#modalAdmin').modal('hide');
			$('#modalAdmin1').modal('show'); 
			setTimeout(function(){
				$('#modalAdmin1').modal('hide'); 
				$('#modalAdmin').modal('show'); 
			}, 2000);
				
		}else{
			alert('Clave correcta, ya puede continuar a editar el evento');
			window.location.href='?modulo=editConcierto&id='+idEvent+'';
		}
	}
	function closeModal() {
		$('#modalAdmin').modal('hide');
	}
</script>