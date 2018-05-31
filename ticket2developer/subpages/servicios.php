<input type="hidden" id="data" value="9" />
<div style="margin:10px -10px;">
<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<div style="background-color:#171A1B; padding-right:3%;padding-left: 2%"><br/><br/>
		<div class = 'row'>
			<div class = 'col-md-12'>
				<img src = 'imagenes/servicios.png' width = '100%'/>
				
			</div>
		</div>
		<style>
			ul li {
				list-style-type: none
			}
			#btnCotizar:hover{
				-webkit-box-shadow: 10px 10px 5px 0px rgba(255,255,255,0.75);
				-moz-box-shadow: 10px 10px 5px 0px rgba(255,255,255,0.75);
				box-shadow: 10px 10px 5px 0px rgba(255,255,255,0.75);
			}
		</style>
		<div class = 'row'>
			<div class = 'col-md-1'></div>
			<div class = 'col-md-10' style = 'color:#fff;'>
				<div style = 'font-size:20pt;padding-left:20px;' id = 'recibeMensaje'>Por favor complete el siguiente formulario de cotización.</div>
				<ul style = 'font-size:15pt;'>
					<li>
						<input type = 'checkbox' value='Impresión-y-comercialización-de-tickets-térmicos' name ='servicios[]' /> Impresión y comercialización de tickets térmicos
					</li>
					<li>
						<input type = 'checkbox' value='Ticket-electronico-(ingreso-con:-cédula-mail-con-codigo-de-barras)' name ='servicios[]'/> Ticket electronico (ingreso con: cédula , mail con codigo de barras)
					</li>
					<li>
						<input type = 'checkbox' value='Impresión-de-boletos-sin-Comercialización ' name ='servicios[]' /> Impresión de boletos sin Comercialización 
					</li>
					<li>
						<input type = 'checkbox' value='Reservas-y-Preventas' name ='servicios[]'/> Reservas y Preventas
					</li>
					<li>
						<input type = 'checkbox' value='Control-de-acceso-el-día-del-evento-con-lectoras-inalámbricas-TicketFacil' name ='servicios[]'/> Control de acceso el día del evento con lectoras inalámbricas TicketFacil
					</li>
					<li>
						<input type = 'checkbox' value='Promoción-y-Marketing-(web-redes-sociales-buscadores-y-SMS-masivo)' name ='servicios[]' /> Promoción y Marketing (web, redes sociales, buscadores y SMS masivo)
					</li>
					<li>
						<input type = 'checkbox' value='Servicios-adicionales-dia-del-evento' name ='servicios[]'/> Servicios adicionales dia del evento 
					</li>
					<li>
						<input type = 'checkbox' value='Pulseras-Personalizadas' name ='servicios[]'/> Pulseras Personalizadas 	 		
					</li>
					<li>
						<input type = 'checkbox' value='Servicio-de-Gafetes-y-Acreditación' name ='servicios[]' /> Servicio de Gafetes y Acreditación 
					</li>
					
				</ul>
				<br/>
					
				<br/>
				<div id = 'recibeMensaje2'></div>
				<table width = '85%' align = 'left' style = 'font-size:15pt;'>
					<tr>
						<td style ='text-align:left;padding:10px;'>
							<label style = 'color:red;'>*</label>Nombre del Empresario : 
						</td>
						<td> 
							<input type = 'text' style = 'width:100%;color:#000;text-transform:capitalize' id = 'nombre'/>
						</td>
					</tr>
					<tr>
						<td style ='text-align:left;padding:10px;'>
							<label style = 'color:red;'>*</label>Email : 
						</td>
						<td> 
							<input type = 'text' style = 'width:100%;color:#000;' id = 'email'/>
						</td>
					</tr>
					<tr>
						<td style ='text-align:left;padding:10px;'>
							<label style = 'color:red;'>*</label>Numero de telefono : 
						</td>
						<td> 
							<input type = 'text' style = 'width:100%;color:#000;' id = 'telefono'  class = 'entero'/>
						</td>
					</tr>
					<tr>
						<td style ='text-align:left;padding:10px;'>
							<label style = 'color:red;'>*</label>Evento : 
						</td>
						<td> 
							<input type = 'text' style = 'width:100%;color:#000;text-transform:capitalize' id = 'evento'/>
						</td>
					</tr>
					<tr>
						<td style ='text-align:left;padding:10px;'>
							<label style = 'color:red;'>*</label>Ciudad : 
						</td>
						<td> 
							<input type = 'text' style = 'width:100%;color:#000;text-transform:capitalize' id = 'ciudad'/>
						</td>
					</tr>
					<tr>
						<td style ='text-align:left;padding:10px;'>
							<label style = 'color:red;'>*</label>Lugar tentativo : 
						</td>
						<td> 
							<input type = 'text' style = 'width:100%;color:#000;text-transform:capitalize' id = 'lugar'/>
						</td>
					</tr>
					<tr>
						<td style ='text-align:left;padding:10px;'>
							<label style = 'color:red;'>*</label>Fecha tentativa : 
						</td>
						<td> 
							<input type = 'text' style = 'width:100%;color:#000;' id = 'fecha'/>
						</td>
					</tr>
					<tr>
						<td style ='text-align:left;padding:10px;'>
							<label style = 'color:red;'>*</label>Cantidad de tickets : 
						</td>
						<td> 
							<input type = 'text' style = 'width:100%;color:#000;' id = 'cantidad' class = 'entero'/>
						</td>
					</tr>
					<tr>
						<td colspan = '2' valign = 'middle' align = 'center' style = 'padding-top:10px'>
							<div onclick = 'envia();' id = 'btnCotizar' style = 'background-color:#A04493;color:#fff;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px;cursor:pointer;width:200px;'>COTIZAR</div>
							<img src='imagenes/loading.gif' style = 'display:none;width:50px;' id = 'btnLoad'/>
						</td>
					</tr>
				</table>
			</div>
			<div class = 'col-md-1'></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function envia(){
		var nombre = $('#nombre').val();
		var email = $('#email').val();
		var telefono = $('#telefono').val();
		var evento = $('#evento').val();
		var ciudad = $('#ciudad').val();
		var lugar = $('#lugar').val();
		var fecha = $('#fecha').val();
		var cantidad = $('#cantidad').val();
		
		
		var selected = '';    
        $('input[type=checkbox]').each(function(){
            if (this.checked) {
                selected += $(this).val()+'@';
            }
        }); 
		var valores_servicio = selected.substring(0,selected.length -1);
		
		// alert('Has seleccionado: '+valores_servicio);  
        // if (selected != '') 
            // alert('Has seleccionado: '+selected);  
        // else
            // alert('Debes seleccionar al menos una opción.');
		if(nombre == ''){
			alert('Debe ingresar un Nombre de Empresario');
		}
		
		if(email == ''){
			alert('Debe ingresar un Email de Empresario');
		}
		
		if(telefono == ''){
			alert('Debe ingresar un Telefono de Empresario');
		}
		
		if(evento == ''){
			alert('Debe ingresar un Nombre de Evento');
		}
		
		if(ciudad == ''){
			alert('Debe ingresar una Ciudad');
		}
		
		if(lugar == ''){
			alert('Debe ingresar un Lugar');
		}
		
		if(fecha == ''){
			alert('Debe ingresar una Fecha del Evento');
		}
		
		if(cantidad == ''){
			alert('Debe ingresar una Cantidad de tickets');
		}
		
		if(nombre == '' || email == '' || telefono == '' || evento == '' || ciudad == '' || lugar == '' || fecha == '' || cantidad == ''){
			
		}else{
			$('#btnCotizar').css('display','none');
			$('#btnLoad').css('display','block');
			$.post("envioEmailCotizar.php",{ 
				nombre : nombre , email : email , telefono : telefono , evento : evento , ciudad : ciudad ,
				lugar : lugar , fecha : fecha , cantidad : cantidad , valores_servicio : valores_servicio
			}).done(function(data){
				$('#recibeMensaje2').html(data);		
				setTimeout(function(){
					alert("Gracias por su tiempo!!!");
					window.location = '';
				}, 10000);
			});
		}
		
	}
	$( function() {
		$('.entero').numeric();
		
		
		$( "#fecha" ).datepicker();
		$.datepicker.regional['es'] = {
			closeText: 'Cerrar',
			prevText: '<Ant',
			nextText: 'Sig>',
			currentText: 'Hoy',
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			weekHeader: 'Sm',
			dateFormat: 'yy/mm/dd',
			minDate: +1,
		};
		$.datepicker.setDefaults($.datepicker.regional['es']);
	} );
	
</script>
