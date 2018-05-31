<?php
	//include("controlusuarios/seguridadSA.php");
	
	session_start();
	//include("controlusuarios/seguridadSA.php");
	include 'conexion.php'; 
	//echo $_SESSION['iduser'];
	// echo "<h1>".$_SESSION['perfil']."   ".$_SESSION['iduser']."    --> hola</h1>";
	$sqlM = 'select socio from modulo_admin where id_usuario = "'.$_SESSION['iduser'].'" ';
	//echo $sqlM;
	$resM = mysql_query($sqlM) or die (mysql_error());
	$rowM = mysql_fetch_array($resM);
	// echo $_SESSION['autentica'];
	
	if($_SESSION['autentica'] == 'tFADMIN_SOCIO'){
?>
		<script>
			window.location = 'https://www.ticketfacil.ec/ticket2/?modulo=listaEventos';
		</script>
<?php
		$filtro = 'and idUsuario = "'.$rowM['socio'].'" ';
	}else{
		$filtro = '';
	}
	
	$hoy = date("Y-m-d");   
?>
	<div class = 'row'>
		<div class = 'col-md-3'>
			<span style = 'color:#fff;'>Seleccione el evento</span><br><br>
			<select  id = 'evento' class="form-control" onchange = 'saberLocalidad()' >
				<option value = '' > Seleccione...</option>
				<?php
					$sqlC = 'select * from Concierto where dateFecha >= "'.$hoy.'" order by dateFecha DESC';
					$resC = mysql_query($sqlC) or die (mysql_error());
					while($rowC = mysql_fetch_array($resC)){
						echo '<option value = "'.$rowC['idConcierto'].'" >'.$rowC['strEvento'].' [ '.$rowC['idConcierto'].' ]</option>';
					}
				?>
			</select>
		</div>
		<div class = 'col-md-3' >
			<span style = 'color:#fff;'>Seleccione Localidad</span><br><br>
			<select  id = 'localidades' class="form-control">
				
			</select>
		</div>
		
		<div class = 'col-md-2' >
			<span style = 'color:#fff;'>Multiplos</span><br><br>
			<select  id = 'cantidades' class="form-control">
				<option value = '' > Seleccione...</option>
				<?php
					for($i=1;$i<=10;$i++){
						echo '<option value = "'.$i.'" >'.$i.'</option>';
					}
				?>
			</select>
		</div>
		<div class = 'col-md-3'>
			<span style = 'color:#fff;'>Cantidad Cortesia</span><br><br>
			<select id = 'cantidad_gratis' class = 'form-control' >
				<option value = '' > Seleccione...</option>
				<?php
					for($i=1;$i<=10;$i++){
						echo '<option value = "'.$i.'" >'.$i.'</option>';
					}
				?>
			</select>
		</div>
		
	</div>
	
	<div class = 'row' style = 'padding-right: 15px'>
		
		
		<div class = 'col-md-5'>
			<span style = 'color:#fff;'>Nombre de la Promocion</span><br><br>
			<textarea class = 'form-control' id = 'nombre' placeholder = 'ingrese promo'></textarea>
		</div>
		
		
		<div class = 'col-md-5'>
			<span style = 'color:#fff;'>Conteo Regresivo</span><br><br>
			<input type = 'text' class = 'form-control' id = 'reloj' placeholder = 'ingrese el conteo regresivo' />
		</div>
		
		<div class = 'col-md-1' >
			<span style = 'color:#282B2D;'>S</span><br><br>
			<button type="button" class="btn btn-success" onclick = 'grabaPromo()' >Grabar</button>
		</div>
	</div>
	
	
	
	<div class = 'row' style = 'padding-right: 15px'>
		<div class = 'col-md-12'>
			<div class="table-responsive">
				<table class = 'table table-bordered' style = 'color:#fff;' id = 'contieneDatos' >
					<tr>
						<th style = 'width:150px'>Nombre</th>
						<th>Evento</th>
						<th>Localidad</th>
						<th style = 'width:60px;'>Multiplos</th>
						<th style = 'width:60px;'>Cortesias</th>
						<th>Reloj</th>
						<th>Estado</th>
						<th>Opciones</th>
					</tr>
				<?php
					$sqlP = '
							select p.* , c.strEvento , l.strDescripcionL , l.idLocalidad , c.idConcierto as id_conc
							from promociones as p , Concierto as c , Localidad as l
							where p.id_con = c.idConcierto
							and p.id_loc = l.idLocalidad
							
							';
					$resP = mysql_query($sqlP) or die (mysql_error());
					$op='';
					while($rowP = mysql_fetch_array($resP)){
				?>
					<tr>
						<td>
							<textarea class = 'form-control' id = 'nombre_<?php echo $rowP['id'];?>'><?php echo $rowP['nombre'];?></textarea>
						</td>
						<td>
							<?php echo $rowP['strEvento'];?>
						</td>
						<td>
							<select class = 'form-control' id = 'localidad_<?php echo $rowP['id']?>' >
							<?php 
								$sqlLo = 'select * from Localidad where idConc = "'.$rowP['id_conc'].'" ';
								$resLo = mysql_query($sqlLo) or die (mysql_error());
								while($rowLo = mysql_fetch_array($resLo)){
									if($rowLo['idLocalidad'] == $rowP['idLocalidad']){
										$selected2 = 'selected';
									}else{
										$selected2 = '';
									}
									echo '<option value = "'.$rowLo['idLocalidad'].'" '.$selected2.'>'.$rowLo['strDescripcionL'].'</option>';
								}
								// echo $rowP[''];
							?>
							</select>
						</td>
						<td>
							<input style = 'color: #000;width: 60px' type = 'text' id = 'cantidad_<?php echo $rowP['id'];?>' value = '<?php echo $rowP['cantidad'];?>' />
						</td>
						<td>
							<input style = 'color: #000;width: 60px' type = 'text' id = 'cortesias_<?php echo $rowP['id'];?>' value = '<?php echo $rowP['cortesias'];?>' />
						</td>
						<td class = 'relojes'>
							<?php echo $rowP['reloj'];?>
							<input type = 'text' id = 'reloj_<?php echo $rowP['id'];?>' value = '<?php echo $rowP['reloj'];?>' class ='form-control' />
						</td>
						<td>
							<select class = 'form-control' id = 'estado_<?php echo $rowP['id'];?>' >
								<?php 
									if($rowP['estado'] == 1){
										echo '	
												<option value = "'.$rowP['estado'].'" selected >Activo</option>
												<option value = "0">Desactivo</option>
											';
									}else{
										echo '	
												<option value = "1">Activo</option>
												<option value = "'.$rowP['estado'].'" selected>Desactivo</option>
											';
									}
								?>
							</select>
						</td>
						
						<td><button type="button" class="btn btn-warning btn-xs" onclick = 'editaPromocion(<?php echo $rowP['id'];?>)'><i class="fa fa-floppy-o" aria-hidden="true"></i> Editar</button></td>
					</tr>
				<?php
					}
				?>
				</table>
			</div>
		</div>
	</div>
	
<script>
	function editaPromocion(id){
		var cantidades = $('#cantidad_'+id).val();
		var cantidad_gratis = $('#cortesias_'+id).val();
		var nombre = $('#nombre_'+id).val();
		var reloj = $('#reloj_'+id).val();
		var estado_ = $('#estado_'+id).val();
		var localidad_ = $('#localidad_'+id).val();
		var ident = 2;
		
		if(cantidades == ''){
			alert('seleccione una Cantidad');
		}
		
		
		if(cantidad_gratis == ''){
			alert('seleccione una Cantidad de Cortesias');
		}
		
		if(nombre == ''){
			alert('Ingrese un nombre');
		}
		
		if(reloj == ''){
			alert('ingrese la cuenta regresiva');
		}
		
		
		if(cantidades == '' || nombre == '' || reloj == '' || cantidad_gratis == ''){
			
		}else{
			$.post("spadmin/grabaPromocionesEventos.php",{ 
				cantidades : cantidades ,nombre : nombre , reloj : reloj , ident : ident , 
				cantidad_gratis : cantidad_gratis , estado_ : estado_ , id : id , localidad_ : localidad_
			}).done(function(data){
				alert(data)
				location.reload();
			});
		}
	}
	function grabaPromo(){
		var evento = $('#evento').val();
		var localidades = $('#localidades').val();
		var cantidades = $('#cantidades').val();
		var cantidad_gratis = $('#cantidad_gratis').val();
		var nombre = $('#nombre').val();
		var reloj = $('#reloj').val();
		var estado_ = 0;
		var ident = 1;
		var id = 0;
		if(evento == ''){
			alert('seleccione un evento');
		}
		
		if(localidades == ''){
			alert('seleccione una Localidad');
		}
		
		if(cantidades == ''){
			alert('seleccione una Cantidad');
		}
		
		
		if(cantidad_gratis == ''){
			alert('seleccione una Cantidad de Cortesias');
		}
		
		if(nombre == ''){
			alert('Ingrese un nombre');
		}
		
		if(reloj == ''){
			alert('ingrese la cuenta regresiva');
		}
		
		
		
		if(evento == '' || localidades == '' || cantidades == '' || nombre == '' || reloj == '' || cantidad_gratis == ''){
			
		}else{
			$.post("spadmin/grabaPromocionesEventos.php",{ 
				evento :evento , localidades : localidades ,  cantidades : cantidades , estado_ : estado_ ,
				nombre : nombre , reloj : reloj , ident : ident , cantidad_gratis : cantidad_gratis , id : id
			}).done(function(data){
				alert(data)
				location.reload();
			});
		}
	}
	$(document).ready(function(){
		$('.relojes > img').css('width','200px')
	})
	function saberLocalidad(){
		var evento_reimprime = $('#evento').val();
		$.post("subpages/localidadEvento.php",{ 
			evento_reimprime : evento_reimprime 
		}).done(function(data){
			$('#localidades').html(data);
			$( "#localidades" ).effect('highlight');
		});
	}
</script>