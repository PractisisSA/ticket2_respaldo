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
	$selectSocio = 'SELECT idUsuario, strNombreU FROM Usuario WHERE strPerfil = "'.$perfil.'" '.$filtro.' ' or die(mysqli_error());
	$resultSelectSocio = $mysqli->query($selectSocio);
	echo '<input type="hidden" id="data" value="2" />';
	echo '<input type="hidden" id="user" value="'.$currentUser.'"';
?>
	<div class = 'row'>
		<div class = 'col-md-12' >
			<center>
				<div class="col-md-4">
				</div>
				<div class="col-md-3">
					<div id="producto" haytexto="" product_id="95" ispromotext="0" class="panel panel-default default2 lasotras">
						<div class="panel-heading">
							MODULO PARA PROSESAR LOS PAGOS DE MEMBRESIAS
						</div> 
						<div class="panel-body">
							Suba y procese los pagos de membresias realizados al club mediante este modulo<br>
							<button type="button" class="btn btn-info" onclick = "subirExcel(1)" >
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prosesar Socios&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</button><br/><br/>
							<button type="button" class="btn btn-warning" onclick = "subirExcel(2)" >
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prosesar Pagos &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</button>
							<!--<br/><br/>
							<button type="button" class="btn btn-danger" onclick = "subirExcel(3)" >
								Prosesar Pagos Patrocinios
							</button>-->
						</div>
					</div>
				</div>
			</center>
		</div>
	</div>
	<div class="modal fade" id="subeExcel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static" style = 'padding-right:0px !important;'>
		<div class="modal-dialog modal-lg" role="document" >
			<div class="modal-content">
				<div class="modal-header" >
					<img src="imagenes/ticketfacilnegro.png" width='100px' />
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick = "location.reload()"><span aria-hidden="true">&times;</span></button>
					<div id = 'cargar'></div>
				</div>
				<div class="modal-body" style='text-align:center;' id = 'respu2'>
					<?php
						for($y=1;$y<=3;$y++){
					?>
							<button id='upload<?php echo $y;?>' onclick = 'subirArch(<?php echo $y;?>)' class='btn btn-info botones' type='file' style='font-size:18px;display:none;'>
								&nbsp;1. Importar. &nbsp;
								<span class="fa fa-upload" style='padding:3px; cursor:pointer;' title='Importar'></span>
							</button>
							
							<button id='btnEnvia<?php echo $y;?>' onclick='enviar(<?php echo $y;?>)' class='btn btn-danger botones' type='file' style='font-size:18px;display:none;'>
								&nbsp;2. Enviar. &nbsp;
								<span class="fa fa-floppy-o" style='padding:3px; cursor:pointer;' title='Enviar'></span>
							</button>
							<br>
							<div id = 'fotoSubida2_<?php echo $y;?>'></div>
							<input type='hidden' id='recibeExcel2_<?php echo $y;?>' />
					<?php
						}
					?>
				</div>
				<div class="modal-footer" >
					
					
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
				$('#recibeExcel2_'+id).val(mirsp);
				$('#btnEnvia'+id).fadeIn('fast');
				$('#upload'+id).css('display','none');
				
			}
		});
	}
	
	function enviar(id){
		$('#cargar').html('ESPERE ACTUALIZANDO BASE DE DATOS DE SOCIOS');
		var recibeExcel2 = $('#recibeExcel2_'+id).val()
		var ruta = '';
		if(id == 1){
			ruta = 'procesaSocios.php';
		}else if(id == 2){
			ruta = 'procesaPagosSocios.php';
		}else{
			ruta = 'procesaPagosSociosPatrocinio.php';
		}
		
		$.post('spadmin/'+ruta+'',{
			recibeExcel2 : recibeExcel2
		}).done(function(data){
			
			setTimeout(function(){
				$('#cargar').html('gracias');
				$('#subeExcel').modal('hide');
				alert(data);
				window.location = '';
			}, 2000);
		});

		
	}
	
	function subirExcel(id){
		
		var txt = '';
		if(id == 1){
			txt = '	<table class = "table" >\
						<tr>\
							<td colspan = "12">\
								EL EXCEL DE CLIENTES A SUBIR DEBE TENER EN FORMATO A CONTINUACION\
							</td>\
						</tr>\
						<tr>\
							<td>ID</td>\
							<td>ID MEMBRESIA</td>\
							<td>CEDULA</td>\
							<td>NOMBRE</td>\
							<td>APELLIDO</td>\
							<td>FORMA DE PAGO</td>\
							<td>INICIO</td>\
							<td>NA</td>\
							<td>PAGADO</td>\
							<td>DEBIO HABER PAGADO</td>\
							<td>DEBE</td>\
							<td>PATROCINADOR</td>\
						</tr>\
						<tr>\
							<td>1</td>\
							<td>1</td>\
							<td>1212121212</td>\
							<td>PATITO</td>\
							<td>DE LOS PALOTES</td>\
							<td>EFECTIVO</td>\
							<td>27</td>\
							<td>18</td>\
							<td>7</td>\
							<td>8</td>\
							<td>1</td>\
							<td>1122334455</td>\
						</tr>\
					</table>\
				';
		}else{
			txt = '	<table class = "table" >\
						<tr>\
							<td colspan = "12">\
								EL EXCEL DE PAGOS A SUBIR DEBE TENER EN FORMATO A CONTINUACION\
							</td>\
						</tr>\
						<tr>\
							<td>ID</td>\
							<td>CEDULA</td>\
							<td>PAGAGO</td>\
							<td>FORMA DE PAGO</td>\
						</tr>\
						<tr>\
							<td>1</td>\
							<td>1212121212</td>\
							<td>5</td>\
							<td>EFECTIVO</td>\
						</tr>\
					</table>\
				';
		}
		
		$('.botones').css('display','none');
		$('#upload'+id).fadeIn('slow');
		// $('#btnEnvia'+id).fadeIn('slow');
		$('#cargar').html(txt);
		$('#subeExcel').modal('show');
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