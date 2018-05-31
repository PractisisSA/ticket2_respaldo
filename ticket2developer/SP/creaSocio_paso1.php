<?php 
	include 'conexion.php';
	$socio = $_REQUEST['socio'];
	echo '<input type = "text" id = "socio" value = "'.$socio.'"  />';
	
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 50px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				<strong>Datos de Pie de Ticket , menus , Pagos Web</strong>
			</div>
			
			<div class="row">
				<br><br>
				<center><span style = 'color:#fff;font-size:20px;font-weight:bold;border-bottom:2px solid #ec1867;padding:15px;' >DATOS DE PIE DE IMPRENTA</span></center>
				<br><br>
				<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">NOMBRE</button>
						</span>
						<input type="text" class="form-control" placeholder="NOMBRE" id= 'nombre'/>
					</div>
				</div>
				
				<div class="col-md-5">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">RUC!</button>
						</span>
						<input type="text" class="form-control" placeholder="RUC" id = 'ruc' />
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">AUT MUNICIPAL</button>
						</span>
						<input type="text" class="form-control" placeholder="AUT MUNICIPAL" id = 'aut_mun' />
					</div>
				</div>
				
				<div class="col-md-5">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">AUT SRI</button>
						</span>
						<input type="text" class="form-control" placeholder="AUT SRI" id = 'aut_sri' />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">TIPO</button>
						</span>
						<input type="text" class="form-control" placeholder="NO OBLIGADO A LLEVAR CONTABILIDAD" id = 'tipo' />
					</div>
				</div>
				
			</div>
			<br><br>
				<center><span style = 'color:#fff;font-size:20px;font-weight:bold;border-bottom:2px solid #ec1867;padding:15px;' >DATOS MENU / PAYPAL , STRIPE</span></center>
			<br><br>
			
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
						<h4 style="color:#fff;"><strong>LOGO:</strong></h4>
						<div class="input-group">
							<input class="inputDescripciones inputlogin form-control" placeholder="logo" id="imagen" readonly="readonly" aria-describedby="basic-addon2" style="color:#000;" type="text">
							<span class="input-group-addon" id="basic-addon2">
								<div style="" id="upload" class="  ">
									<img src="spadmin/examina.png" style="border:0; margin:-2px;" alt="">
								</div>
							</span>
						</div>
					</div>
					
					<div class = 'col-md-5'>
						<div style="position:relative; display:none;" id="btnborrarimg">
							<img id="foto" style="width:100%;">
							<div style="position:absolute; top:0px; right:0;">
								<button type="button" class="btn btn-success" onclick="borrarimg()" title="Eliminar">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
							</div>
							<div class="imgeliminadas">
								
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">EMAIL</button>
						</span>
						<input type="text" class="form-control" placeholder="EMAIL EMPRESA" id = 'email' />
					</div>
				</div>
				
				<div class="col-md-5">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">TELEFONO</button>
						</span>
						<input type="text" class="form-control" placeholder="TELEFONO" id = 'telefono' />
					</div>
				</div>
			</div>
			<div class = 'row'>
				<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">PAYPAL</button>
						</span>
						<input type="text" class="form-control" placeholder="PAYPAL" id = 'paypal' />
					</div>
				</div>
				
				<div class="col-md-5">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">STRIPE LLAVE 1</button>
						</span>
						<input type="text" class="form-control" placeholder="STRIPE LLAVE 1" id = 'str1' />
					</div>
				</div>
			</div>
			
			<div class = 'row'>
				<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">STRIPE LLAVE 2</button>
						</span>
						<input type="text" class="form-control" placeholder="STRIPE LLAVE 2" id = 'str2'/>
					</div>
				</div>
				
				<div class="col-md-5">
					<div class="input-group">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="button">STRIPE LLAVE 3</button>
						</span>
						<input type="text" class="form-control" placeholder="STRIPE LLAVE 3" id = 'str3'/>
					</div>
				</div>
			</div>
			
			
			<div class = 'row' >
				<span style = 'margin-left:20px;color:#fff;'>MENU <label id = "numeroMenu">1</label></span>
				<button class="btn btn-secondary" type="button" style = 'position:relative;float:right;' onclick = 'aumentaMenu();' >+</button>
				<div id = "contieneCreacionMEnus" class = 'contieneInputsMenu'>	
					<div class="col-md-6 ">
						<div class="input-group ">
							<span class="input-group-btn">
								<button class="btn btn-secondary" type="button">TEXTO</button>
							</span>
							<input type="text" class="form-control textoMenu" placeholder="TEXTO ENLACE EJEMPLO : HOME" />
						</div>
					</div>
					<div class="col-md-5">
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn btn-secondary" type="button">LINK</button>
							</span>
							<input type="text" class="form-control linkMenu" placeholder="LINK PARA LA PAGINA" />
						</div>
					</div>
				</div><br><br>
				<center><button class="btn btn-secondary" type="button" onclick = 'grabarDatos();'>GRABAR</button></center>
			</div>
			<div style = 'display:none;'>
				<div style="background-color:#00ADEF; margin:20px -42px 0px 40px; position:relative; padding:10px 40px 20px; color:#fff;">
				
				
					<div class="tra_azul"></div>
					<div class="par_azul"></div>
				</div>
				<div style="text-align:center; margin:20px; padding:20px 0;">
					<button type="submit" class="btndegradate" id="cancelar" >CANCELAR</button>&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="submit" class="btndegradate" id="enviar" onclick="enviarDatos()">GUARDAR</button>
					<img src="imagenes/loading.gif" style="width:50px; display:none;" id="wait"/>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="spadmin/ajaxupload.js"></script>
<script>
	function grabarDatos(){
		var socio = $('#socio').val();
		var nombre = $('#nombre').val();
		var ruc = $('#ruc').val();
		var aut_mun = $('#aut_mun').val();
		var aut_sri = $('#aut_sri').val();
		var tipo = $('#tipo').val();
		var imagen = $('#imagen').val();
		var email = $('#email').val();
		var telefono = $('#telefono').val();
		var paypal = $('#paypal').val();
		
		var str1 = $('#str1').val();
		var str2 = $('#str2').val();
		var str3 = $('#str3').val();
		
		
		var select = '';
		$( ".contieneInputsMenu" ).each(function() {
			var textoMenu = $( this ).find('.textoMenu').val();
			var linkMenu = $( this ).find('.linkMenu').val();
			//alert(textoMenu  + '  >><< ' +  linkMenu);
			select += textoMenu +'@'+ linkMenu +'|';
		});
			var serviform = select.substring(0,select.length - 1);
			//alert(serviform);			
			
		$.post("SP/guardaDatosEmpresario.php",{ 
			socio : socio , nombre : nombre , ruc : ruc , aut_mun : aut_mun , aut_sri : aut_sri
		}).done(function(data){
			alert(data)			
		});
	}
	$(function(){
		var btnUpload=$('#upload');
		new AjaxUpload(btnUpload, {
			action: 'spadmin/procesa3.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|gif|bmp)$/.test(ext))){
					alert('Solo imagenes JPG,GIF,PNG,BMP.');
					return false;
				}
			},
			onComplete: function(file, response){
				var mirsp = response;
				//reload ();
				document.getElementById('imagen').value=mirsp;
				document.getElementById('foto').src='spadmin/'+mirsp;
				$('#btnborrarimg').fadeIn();
			}
		});
	});
	function aumentaMenu(){
		$('#contieneCreacionMEnus').append('\
					<div class = "contieneInputsMenu"><div class="col-md-6">\
						<div class="input-group">\
							<span class="input-group-btn">\
								<button class="btn btn-secondary" type="button">TEXTO</button>\
							</span>\
							<input type="text" class="form-control textoMenu" placeholder="TEXTO ENLACE EJEMPLO : HOME" />\
						</div>\
					</div>\
					<div class="col-md-5">\
						<div class="input-group">\
							<span class="input-group-btn">\
								<button class="btn btn-secondary" type="button">LINK</button>\
							</span>\
							<input type="text" class="form-control linkMenu" placeholder="LINK PARA LA PAGINA" />\
						</div>\
					</div></div>');
	}
</script>