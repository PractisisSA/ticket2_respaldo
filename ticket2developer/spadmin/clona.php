<?php 
	session_start();
	//include("controlusuarios/seguridadSA.php");
	include 'conexion.php';
	echo $_SESSION['iduser'];
	
	$sqlM = 'select socio from modulo_admin where id_usuario = "'.$_SESSION['iduser'].'" ';
	$resM = mysql_query($sqlM) or die (mysql_error());
	$rowM = mysql_fetch_array($resM);
	echo "<input type = 'hidden' id = 'iduser' value = '".$_SESSION['iduser']."'  />";
	
	if($_SESSION['autentica'] == 'tFADMIN_SOCIO'){
		
		$filtro = 'and idUsuario = "'.$rowM['socio'].'" ';
	}else{
		$filtro = '';
	}
	
	
	require('Conexion/conexion.php');
	include 'conexion.php';
	$perfil = 'Socio';
	$selectSocio = 'SELECT idUsuario, strNombreU FROM Usuario WHERE strPerfil = "'.$perfil.'" '.$filtro.' ' or die(mysqli_error());
	$resultSelectSocio = $mysqli->query($selectSocio);
	echo '<input type="hidden" id="data" value="27" />';
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				Conciertos
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:18px;">
				<strong>Concierto por Socio: &nbsp;&nbsp;&nbsp;</strong>
				<select id="search" class="inputlogin">
					<option>Seleccione...</option>
					<?php while($rowSocio = mysqli_fetch_array($resultSelectSocio)){?>
						<option value="<?php echo $rowSocio['idUsuario'];?>"><?php echo $rowSocio['strNombreU'];?></option>
					<?php }?>
				</select>
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
						<td>
							<p><strong>Lugar</strong></p>
						</td>
						<td>
							<p><strong>Fecha</strong></p>
						</td>
						<td>
							<p><strong>Hora</strong></p>
						</td>
						
						<td>
							<p><strong>Acci&oacute;n</strong></p>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
	<div class="modal fade in" id="paso2Localidades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="false" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="background-color:#333333; color:#fff;">
				<div class="modal-header" style="border-bottom:none;">
					<button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
				</div>
				<div class="modal-body" id ='cuerpoLocalidades'>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade in" id="clona_todo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="false" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<img src="imagenes/ticketfacilnegro.png" width="100px">
					<input id="tipo_conc" type="hidden">
				</div>
				<div class="modal-body" style="padding:0px;">
					<div class="row" style="text-align:center;">
						<div class="col-lg-12" style="margin:0px;padding:10px;">
							<center>
								<div id="recibeBoletoAImprimir">
									<img src="https://www.ticketfacil.ec/imagenes/loading.gif" id="loadBoleto">
								</div>
							</center>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<span style = 'float:right;color:blue;'>
						Espere !!! , estamos procesando su información.
					</span>
				</div>
			</div>
		</div>
	</div>
<script>
	$('#search').on('change',function(){
		var id = $('#search').val();
		$.post('spadmin/buscarConciertoClonar.php',{
			id : id
		}).done(function(json){
			var obj = jQuery.parseJSON(json);
			var busqueda = obj.Search;
			var boton = '';
			for(i=0; i <= (obj.Concierto.length -1); i++){
				var id = obj.Concierto[i].id;
				var imagen = obj.Concierto[i].imagen;
				var evento = obj.Concierto[i].evento;
				var lugar = obj.Concierto[i].lugar;
				var fecha = obj.Concierto[i].fecha;
				var hora = obj.Concierto[i].hora;
				var num_resp = obj.Concierto[i].num_resp;
				
				$('#select_conciertos').append('\
				<tr class="filas_con" style="text-align:center">\
					<td style = "border:1px solid #fff;text-align:center;"><img src="https://www.ticketfacil.ec/ticket2/spadmin/'+imagen+'" id="img_con"/></td>\
					<td style = "border:1px solid #fff;text-align:center;">'+evento+'</td>\
					<td style = "border:1px solid #fff;text-align:center;">'+lugar+'</td>\
					<td style = "border:1px solid #fff;text-align:center;">'+fecha+'</td>\
					<td style = "border:1px solid #fff;text-align:center;">'+hora+'</td>\
					<td style = "border:1px solid #fff;text-align:center;">\
						<a href="?modulo=seeConcert&id='+id+'" class="btn btn-warning">Ver Evento&nbsp;['+id+']</a><br/><br/><button type="button" class="btn btn-warning" onclick = "clonarTodo('+id+')"   >Clonar Todo&nbsp;['+id+']</button><br/><br/>\
						<button type="button" class="btn btn-success" onclick = "clonarEvento('+id+')" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clonar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;['+id+']</button><br/><br/>\
						<button type="button" class="btn btn-danger" onclick = "borrarEvento('+id+')" >Borra Evento['+id+']</button><br/><br/>\
					</td>\
				</tr>');
			}
		});
		$('.filas_con').remove();
	});
	function verTodo(id) {
		window.location.href=""
	}
	function clonarTodo(id){
		var retVal = confirm("Seguro que quieres clonar todo?");
		if (retVal == true) {
			$('#clona_todo').modal('show');
			$.post("spadmin/clonaTodo.php",{ 
				id : id 
			}).done(function(data){
				var res = data.split("|");
				alert(res[1] + '  sera dirigido al modulo para crear codigos de barra y cargar el PCX , si no realiza este proceso no podra imprimir sus tickets');
				window.location = '?modulo=listaConciertos';
			});
		}
		
	}
	function borrarEvento(id){
		if(confirm('REALMENTE DESEA ELIMINAR EL EVENTO  : ' + id + '  ESTE PROCESO ES IRREVERSIBLE')){
			$.post("spadmin/borrarEvento.php",{ 
				id : id
			}).done(function(data){
				alert(data);
				window.location='';
			});
		}
	}
	function clonarEvento(id){
		var retVal = confirm("Seguro que quieres clonar este evento? Se clonara el evento:");
		if (retVal == true) {
				$.post("spadmin/clona_paso_1.php",{ 
				id : id 
			}).done(function(data){
				$('#cuerpoLocalidades').html(data);
				$('#paso2Localidades').modal('show');
			});
		}
		
	}
	function clonarLocalidad(id, idConc){
		
			var retVal = confirm("Seguro que quieres clonar esta localidad?");
			if (retVal == true) {
			alert('Clonara la localidad : ' + id);
			$('#btn_local_'+id).attr("disabled", true);
			$.post("spadmin/clona_paso_2.php",{ 
				id : id , idConc : idConc
			}).done(function(data){
				//alert(data);
				var res = data.split("|");
				if($.trim(res[0])=='ok'){
					alert('La localidad # ' + id + 'se ha clonado con éxito!!! continue');
					$('#btn_local_'+id).css('display','none');
					//$('#btn_local_fade_'+id).css('display','block');
					$('.recibeOcupados_'+id).append(res[1]);
				}
				else if($.trim(data)=='error'){
					alert('error no se clono revise ');
				}
			 
		});
			}
		
		
	}
	
	
	function eliminaLocalidadClonada(id_locNueva){
		alert('Elimnara la localidad : ' + id_locNueva);
		$('#btn_local_fade_'+id_locNueva).attr("disabled", true);
		
		$.post("spadmin/eliminaLocalidadClonada.php",{ 
			id_locNueva : id_locNueva 
		}).done(function(data){
			alert(data);			
		});
		
	}
	function clonaOcupadas(id_loc , id_locNueva , status, id_con){
		//alert(id_loc +' << >> '+ status);
		$('#img_local_fade_ocupadas_'+id_loc).css('display','block');
		$('#btn_local_fade_ocupadas_'+id_loc).attr('disabled',true);
		$.post("spadmin/clona_paso_3.php",{ 
			id_loc : id_loc , status : status , id_con : id_con , id_locNueva : id_locNueva
		}).done(function(data){
			alert(data);
			
			if($.trim(data)=='ok'){
				alert('La ocupados # ' + id_loc + 'se ha clonado con éxito!!!');
				$('#img_local_fade_ocupadas_'+id_loc).css('display','none');
				$('#btn_local_fade_ocupadas_'+id_loc).css('display','none');
			}
			else if($.trim(data)=='error'){
				alert('error no se clono revise ');
			}
			
		});
	}
</script>