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
	
	
	require('Conexion/conexion.php');
	$perfil = 'Socio';
	$currentUser = $_SESSION['iduser'];
	if($_SESSION['perfil'] == 'SP'){
		$selectSocio = 'SELECT idUsuario, strNombreU FROM Usuario WHERE strPerfil = "'.$perfil.'" '.$filtro.' ' or die(mysqli_error());
	}else{
		$selectSocio = 'SELECT idUsuario, strNombreU FROM Usuario WHERE idUsuario = "'.$_SESSION['iduser'].'" ' or die(mysqli_error());
	}
	$resultSelectSocio = $mysqli->query($selectSocio);
	echo '<input type="hidden" id="data" value="80" />';
	echo '<input type="hidden" id="user" value="'.$currentUser.'"';
?>
	<div class = 'row'>
		<div class = 'col-md-5'>
			<span style = 'color:#fff;'>Seleccione el socio para crear su(s) membresia(s)</span><br><br>
			<select  id = 'socio_membresia' class="form-control">
				<option value = '' >Seleccione...</option>
				<?php while($rowSocio = mysqli_fetch_array($resultSelectSocio)){?>
					<option value="<?php echo $rowSocio['idUsuario'];?>"><?php echo $rowSocio['strNombreU'];?></option>
				<?php }?>
			</select>
		</div>
		<div class = 'col-md-5' id = 'mensajeMembresias'></div>
	</div>
	
	<div class = 'row' style = 'padding-right: 15px'>
		<div class = 'col-md-12'>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead style = 'color:#fff;'>
						<tr>
							<th>
								ID
							</th>
							<th>
								SOCIO
							</th>
							<th>
								MEMBRESIA
							</th>
							<th>
								TIPO PAGO
							</th>
							<th style = 'width:230px'>
								MES / FECHA
							</th>
							<th>
								PERÍODO GRACIA
							</th>
							<th>
								LOCALIDADES
							</th>
							<th>
								VALOR MENSUAL
							</th>
							
							<th>
								# SOCIO
							</th>
							<th>
								# GRATIS 
							</th>
							<th>
								OTROS
							</th>
							<th>
								ESTADO
							</th>
							<th>
								OPCIONES
							</th>
						</tr>
					</thead>
					<tbody id = 'recibeMembresia'>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
<script>
	

	function saberTipoPago(idmembresia){
		var tipo_pago_ = $('#tipo_pago_'+idmembresia).val();
		
		if(tipo_pago_ == 'anual'){
			$('.ui-datepicker-calendar').css('display','none')
			$('#fechad_'+idmembresia).css('display','inline')
			$('#fechad2_'+idmembresia).css('display','none')
		}else{
			$('#fechad_'+idmembresia).css('display','none')
			$('#fechad2_'+idmembresia).css('display','inline')
			$('.ui-datepicker-calendar').css('display','block')
		}
	}
	function configuraMembresia(id , ident){
		var id_empresario_ = $('#id_empresario_'+id).val();
		var membresia_ = $('#membresia_'+id).val();
		var tipo_pago_ = $('#tipo_pago_'+id).val()
		
		if(tipo_pago_ == 'anual'){
			var fechad_ = $('#fechad_'+id).val();
		}else{
			var fechad_ = $('#fechad2_'+id).val();
		}
		
		var periodo_ = $('#periodo_'+id).val();
		
		
		var valor_mensual_ = $('#valor_mensual_'+id).val();
		var localidades_ = $('#localidades_'+id).val();
		var cantidad_ = $('#cantidad_'+id).val();
		var gratis_ = $('#gratis_'+id).val();
		var otros_ = $('#otros_'+id).val();
		var estado_ = $('#estado_'+id).val();
		
		if(membresia_ == ''){
			alert('debe ingresar en nombre de la membresia');
		}
		
		if(valor_mensual_ == ''){
			alert('debe ingresar el valor mensual');
		}
		
		if(localidades_ == ''){
			alert('debe ingresar la(s) localidad(es) para esta membresia');
		}
		
		if(cantidad_ == ''){
			alert('debe ingresar la cantidad de ticket en beneficio de socio');
		}
		
		if(gratis_ == ''){
			alert('debe ingresar la cantidad de tickets en beneficio gratis');
		}
		
		if(otros_ == ''){
			alert('debe ingresar otro beneficio');
		}
		
		if(estado_ == ''){
			alert('debe ingresar el estado');
		}
		
		if(membresia_ == '' || valor_mensual_ == '' || localidades_ == '' || cantidad_ == '' || gratis_ == '' || otros_ == '' || estado_ == ''){
			
		}else{
			$('#boton_membresia_'+id+'_'+ident).attr('disabled' , true);
			$.post("spadmin/configuraMembresia.php",{ 
				id : id , ident : ident , membresia_ : membresia_ , valor_mensual_ : valor_mensual_ , localidades_ : localidades_ , 
				cantidad_ : cantidad_ , gratis_ : gratis_ , otros_ : otros_ , estado_ : estado_ , tipo_pago_ : tipo_pago_ , 
				fechad_ : fechad_ , periodo_ : periodo_
			}).done(function(data){
				alert(data);
				var socio_membresia = $('#socio_membresia').val();
				$.post("spadmin/saberMembresiaSocio.php",{ 
					socio_membresia : socio_membresia 
				}).done(function(data){
					$('#recibeMembresia').html(data);
				});
			});
		}
		
	}
	
	
	
	$(document).ready(function(){
		
		
		
		$('#socio_membresia').change(function(){
			var socio_membresia = $('#socio_membresia').val();
			$('#recibeMembresia').html('');
			if(socio_membresia == ''){
				alert('seleccione un socio');
			}else{
				$('#mensajeMembresias').html('<center><h4 style = "padding:0px;margin:0px;color:#fff;">Espere! generando información</h4></center>');
				$.post("spadmin/saberMembresiaSocio.php",{ 
					socio_membresia : socio_membresia 
				}).done(function(data){
					setTimeout(function(){
						$('#recibeMembresia').html(data);
						$('#mensajeMembresias').html('');
					}, 2000);
				});
			}
		})
	})
</script>