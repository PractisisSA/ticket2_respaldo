<?php
	//include("controlusuarios/seguridadSA.php");
	
	session_start();
	//include("controlusuarios/seguridadSA.php");
	include 'conexion.php'; 
	//echo $_SESSION['iduser'];
	
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
	echo '<input type="hidden" id="data" value="83" />';
	echo '<input type="hidden" id="user" value="'.$currentUser.'"';
?>
	<div class = 'row'>
		<div class = 'col-md-5'>
			<span style = 'color:#fff;'>Seleccione el socio</span><br><br>
			<select  id = 'socio_membresia' class="form-control">
				<option value = '' >Seleccione...</option>
				<?php while($rowSocio = mysqli_fetch_array($resultSelectSocio)){?>
					<option value="<?php echo $rowSocio['idUsuario'];?>"><?php echo $rowSocio['strNombreU'];?></option>
				<?php }?>
			</select>
		</div>
		
		<div class = 'col-md-4'>
			<span style = 'color:#fff;'>Seleccione la Membresia</span><br><br>
			<select  id = 'comboMembresiaSocio' class="form-control">
				
			</select>
		</div>
		<div class = 'col-md-2'>
			<span style = 'color:#282B2D;'>e</span><br><br>
			<button type="button" class="btn btn-default" onclick = 'saberSocioMembresia()' >Ejecutar</button>
			<!--<button type="button" class="btn btn-default" onclick = 'subirExcel()' >Excel</button>-->
		</div>
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
								MEMBRESIA
							</th>
							<th>
								CEDULA
							</th>
							<th>
								NOMBRE
							</th>
							<th>
								APELLIDO
							</th>
							
							<th>
								VALOR UD$
							</th>
							<th>
								FORMA DE PAGO
							</th>
							<th>
								MESES MORA	
							</th>
							<th>
								T DEUDA
							</th>
							<th>
								OPCIONES
							</th>
						</tr>
					</thead>
					<tbody id = 'recibeMembresiaSocio'>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="subeExcel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static" style = 'padding-right:0px !important;'>
		<div class="modal-dialog modal-md" role="document" >
			<div class="modal-content">
				<div class="modal-header" >
					<img src="imagenes/ticketfacilnegro.png" width='100px' />
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick = "$('#subeExcel').modal('hide')"><span aria-hidden="true">&times;</span></button>
					<div id = 'cargar'></div>
				</div>
				<div class="modal-body" style='text-align:center;' id = 'respu2'>
					<button id='upload1' onclick = 'subirArch(1)' class='btn btn-info' type='file' style='font-size:18px;'>
						&nbsp;1. Importar. &nbsp;
						<span class="fa fa-upload" style='padding:3px; cursor:pointer;' title='Importar'></span>
					</button>
					<br>
					<button id='btnEnvia' onclick='enviar()' class='btn btn-info' type='file' style='font-size:18px;display:none;'>
						&nbsp;2. Enviar. &nbsp;
						<span class="fa fa-upload" style='padding:3px; cursor:pointer;' title='Enviar'></span>
					</button>
				</div>
				<div class="modal-footer" >
					<div id = 'fotoSubida2_1'></div>
					<input type='hidden' id='recibeExcel2' />
					
				</div>
			</div>
		</div>
	</div>
	<script src="js/upload.js"></script>
<script>
	function validarCedula(id , id1 , id2){
		var forma_pago_otro_ = $('#forma_pago_otro_'+id+'_'+id1+'_'+id2).val();
		if(forma_pago_otro_ == ''){
			
		}else{
			$.post("spadmin/validarCedulaSocio.php",{ 
				forma_pago_otro_ : forma_pago_otro_
			}).done(function(data){
				if(data == 0){
					alert('La cedula ingresada no consta como socio');
					$('#forma_pago_otro_'+id+'_'+id1+'_'+id2).val('');
				}else{
					alert('Cedula Verificada con Exito');
				}			
			});
		}
	}
	function saberTipoPago(id , id1 , id2){
		var saberTipoPago = $('#forma_pago_'+id+'_'+id1+'_'+id2).val();
		// alert(saberTipoPago);
		if(saberTipoPago == 'otro'){
			$('#forma_pago_otro_'+id+'_'+id1+'_'+id2).css('display','block');
		}else{
			$('#forma_pago_otro_'+id+'_'+id1+'_'+id2).val('');
			$('#forma_pago_otro_'+id+'_'+id1+'_'+id2).css('display','none');
		}
		
	}
	
	function subirArch(id){
		// alert(id)
		var btnUpload=$('#upload'+id);
		new AjaxUpload(btnUpload, {
			action: 'spadmin/procesaArch.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(xls|xlsx)$/.test(ext))){
					alert('Solo archivos de excel');
					return false;
				}
			},
			onComplete: function(file, response){
				var mirsp = response;
				//reload ();
				
				$('#fotoSubida2_'+id).html('spadmin/'+mirsp);
				$('#recibeExcel2').val(mirsp);
				$('#btnEnvia').fadeIn('fast');
				
			}
		});
	}
	
	function enviar(){
		$('#cargar').html('ESPERE ACTUALIZANDO BASE DE SOCIOS');
		var recibeExcel2 = $('#recibeExcel2').val()
		var id_membresia = $('#comboMembresiaSocio').val();
		if(id_membresia == null || id_membresia == ''){
			alert('Seleccione la membresia');
		}else{
			$.post('spadmin/procesaSocios.php',{
				recibeExcel2 : recibeExcel2 , id_membresia : id_membresia
			}).done(function(data){
				$('#cargar').html('gracias');
				$('#subeExcel').modal('hide');
				setTimeout(function(){
					$('#recibeMembresiaSocio').html('<center>load!!!</center>');
					$.post("spadmin/saberSocioMembresia.php",{ 
						comboMembresiaSocio : id_membresia 
					}).done(function(data){
						$('#recibeMembresiaSocio').html(data);
					});
				}, 2000);
			});
		}
	}
	
	function subirExcel(){
		var id_membresia = $('#comboMembresiaSocio').val();
		// alert(id_membresia)
		if(id_membresia == null || id_membresia == ''){
			alert('Seleccione la membresia');
		}else{
			$('#subeExcel').modal('show');
		}
	}
	function configuraMembresiaSocios(id , ident , estado){
		if(ident == 1){
			var letraNuevo = '_NU';
		}else{
			var letraNuevo = '_EX';
		}
		
		if(ident == 3){
			var ident2 = 2;
		}else{
			var ident2 = ident;
		}
		
		var id_membresia = $('#id_membresia'+id+'_'+ident2+''+letraNuevo).val();
		var cedula_ = $('#cedula_'+id+'_'+ident2+''+letraNuevo).val();
		var nombre_ = $('#nombre_'+id+'_'+ident2+''+letraNuevo).val();
		var apellido_ = $('#apellido_'+id+'_'+ident2+''+letraNuevo).val();
		var valor_ = $('#valor_'+id+'_'+ident2+''+letraNuevo).val();
		var forma_pago_ = $('#forma_pago_'+id+'_'+ident2+''+letraNuevo).val();
		var forma_pago_otro_ = $('#forma_pago_otro_'+id+'_'+ident2+''+letraNuevo).val();
		var meses_ = $('#meses_mora_'+id+'_'+ident2+''+letraNuevo).val();
		var t_deuda_ = $('#t_deuda_'+id+'_'+ident2+''+letraNuevo).val();
		
		if(cedula_ == ''){
			alert('debe ingresar la cedula del socio');
		}
		
		if(nombre_ == ''){
			alert('debe ingresar el nombre del socio');
		}
		
		if(apellido_ == ''){
			alert('debe ingresar el apellido del socio');
		}
		
		if(valor_ == ''){
			alert('debe ingresar el valor de pago');
		}
		
		if(forma_pago_ == ''){
			alert('debe ingresar la forma de pago ');
		}
		
		
		// alert(cedula_ +' < > '+ nombre_ +' < > '+ apellido_ +' < > '+ valor_ +' < > '+ forma_pago_);
		if(cedula_ == '' || nombre_ == '' || apellido_ == '' || valor_ == '' || forma_pago_ == ''){
			
		}else{
			if(forma_pago_ == 'otro'){
				if(forma_pago_otro_ == ''){
					alert('Ingrese la cedula')
				}else{
					$('#boton_cedula_'+id+'_'+ident).attr('disabled' , true);
					$.post("spadmin/configuraMembresiaSocios.php",{ 
						id : id , ident : ident , cedula_ : cedula_ , nombre_ : nombre_ , apellido_ : apellido_ , id_membresia : id_membresia ,
						valor_ : valor_ , forma_pago_ : forma_pago_ , meses_ : meses_ , t_deuda_ : t_deuda_ , estado : estado , forma_pago_otro_ : forma_pago_otro_
					}).done(function(data){
						alert(data);
						var comboMembresiaSocio = $('#comboMembresiaSocio').val();
						if(comboMembresiaSocio == ''){
							alert('debe seleccionar una membresia')
						}else{
							$('#recibeMembresiaSocio').html('<center>load!!!</center>');
							$.post("spadmin/saberSocioMembresia.php",{ 
								comboMembresiaSocio : comboMembresiaSocio 
							}).done(function(data){
								$('#recibeMembresiaSocio').html(data);
							});
						}
					});
				}
			}else{
				$('#boton_cedula_'+id+'_'+ident).attr('disabled' , true);
				$.post("spadmin/configuraMembresiaSocios.php",{ 
					id : id , ident : ident , cedula_ : cedula_ , nombre_ : nombre_ , apellido_ : apellido_ , id_membresia : id_membresia ,
					valor_ : valor_ , forma_pago_ : forma_pago_ , meses_ : meses_ , t_deuda_ : t_deuda_ , estado : estado , forma_pago_otro_ : forma_pago_otro_
				}).done(function(data){
					alert(data);
					var comboMembresiaSocio = $('#comboMembresiaSocio').val();
					if(comboMembresiaSocio == ''){
						alert('debe seleccionar una membresia')
					}else{
						$('#recibeMembresiaSocio').html('<center>load!!!</center>');
						$.post("spadmin/saberSocioMembresia.php",{ 
							comboMembresiaSocio : comboMembresiaSocio 
						}).done(function(data){
							$('#recibeMembresiaSocio').html(data);
						});
					}
				});
			}
		}
		
	}
	
	function saberSocioMembresia(){
		var comboMembresiaSocio = $('#comboMembresiaSocio').val();
		if(comboMembresiaSocio == ''){
			alert('debe seleccionar una membresia')
		}else{
			$('#recibeMembresiaSocio').html('<center>load!!!</center>');
			$.post("spadmin/saberSocioMembresia.php",{ 
				comboMembresiaSocio : comboMembresiaSocio 
			}).done(function(data){
				$('#recibeMembresiaSocio').html(data);
			});
		}
	}
	$(document).ready(function(){
		$('#socio_membresia').change(function(){
			var socio_membresia = $('#socio_membresia').val();
			if(socio_membresia == ''){
				alert('seleccione un socio');
			}else{
				$('#comboMembresiaSocio').html('');
				$.post("spadmin/comboMembresiaSocio.php",{ 
					socio_membresia : socio_membresia 
				}).done(function(data){
					$('#comboMembresiaSocio').html(data);
				});
			}
		})
	})
</script>