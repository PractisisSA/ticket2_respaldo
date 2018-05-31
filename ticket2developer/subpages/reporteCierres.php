<?php 
	//include("controlusuarios/seguridadSP.php");
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="39" />';
	$current_time = date ("Y-m-d");
?>
<style>
	.label.label-warning.label-tag::before {
		border-color: transparent #f4b04f transparent transparent;
	}
	.label.label-tag::before {
		border-color: transparent #b0b0b0 transparent transparent;
	}
	.label.label-tag::before {
		border-style: solid;
		border-width: 10px 12px 10px 0;
		content: "";
		display: block;
		height: 0;
		margin-left: -17px;
		position: absolute;
		top: -1px;
		transform: rotate(360deg);
		width: 0;
	}
	*, *::after, *::before {
		box-sizing: border-box;
	}
	.label.label-tag::after {
		background: #fff none repeat scroll 0 0;
		border-radius: 99px;
		content: "";
		display: block;
		height: 6px;
		margin: -12px 0 0 -10px;
		position: absolute;
		width: 6px;
	}
	*, *::after, *::before {
		box-sizing: border-box;
	}
	.label.label-warning.label-tag {
		border: 1px solid #f4b04f;
	}
	.panel-heading-controls .badge, .panel-heading-controls > .label {
		margin-bottom: -10px;
		margin-top: 1px;
	}
	.label.label-warning {
		background: #f4b04f none repeat scroll 0 0;
	}
	.label.label-tag {
		border: 1px solid #b0b0b0;
	}
	.label.label-tag {
		border-bottom-left-radius: 0;
		border-top-left-radius: 0;
		display: inline-block;
		font-size: 16px;
		line-height: 18px;
		margin-left: 12px;
		padding: 0 5px;
		position: relative;
	}
	.colores{
		color:#fff;
	}
</style>

<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />

<link rel="stylesheet" href="http://ticketfacil.ec/ticket2/font-awesome-4.6.3/css/font-awesome.min.css">
<body onload = '$("#boletoCanje").focus();'>
	<div style="margin: 10px -10px">
		<div style="background-color:#171A1B; padding:2px;">
			<div style="border: 2px solid #00AEEF; margin:2px;">
				<div style="background-color:#00ADEF; color:#fff; margin:20px 400px 0px 0px; padding-left:30px; font-size:22px;">
					<p><strong>LISTADO CIERRES DE CAJA </strong></p>
				</div>
				<div class="row ">
					<div class = 'col-md-1'></div>
						<div class = 'col-md-12'>
							<span class="label label-tag label-warning">reporte cierres de caja del usuario <?php echo $_SESSION['mailuser'];?></span></span>
						</div>
					<div class = 'col-md-1'></div>
				</div>
				<div class='row'>
					<div class='col-md-3' >
						<span class = 'colores' >DESDE</span>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
							<input type="text" readonly="readonly" class="fecha form-control" id="fecha_desde" placeholder="AAAA-MM-DD" value="<?php echo $current_time;?>" />
						</div>
						<div class="input-group" style = 'display:none;'>
							<span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
							<input type="text" readonly="readonly" class="hora form-control" id="hora_desde" placeholder="10:00"/>
						</div>
						<br/><br/>
					</div>
					<div class='col-md-3' >
						<span class = 'colores' >HASTA</span>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
							<input type="text" readonly="readonly" class="fecha form-control" id="fecha_hasta" placeholder="AAAA-MM-DD" value="<?php echo $current_time;?>" />
						</div>
						<div class="input-group" style = 'display:none;' >
							<span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
							<input type="text" readonly="readonly" class="hora form-control" id="hora_hasta" placeholder="10:00"/>
						</div>
						<br/><br/>
					</div>
					<div class='col-md-3' >
						<span style = 'color:#171A1B;' >FILTRAR</span><br>
						<button type="button" class="btn btn-default" onclick = 'enviaFiltro()' >FILTRAR</button>
						<br/><br/>
						<span class = 'colores' style = 'display:none;'>TIPO PAGO</span><br>
						
						<div class="input-group" style = 'display:none;' >
							<span class="input-group-addon"><i class="fa fa-money" aria-hidden="true" ></i></span>
							<select class = 'form-control' id = 'tipo_pago' >
								<option value = '' >Todos</option>
								<option value = '0' >Efectivo</option>
								<option value = '1' >Visa</option>
								<option value = '2' >Dinners</option>
								<option value = '3' >Mastercard</option>
								<option value = '4' >Discover</option>
								<option value = '5' >Amex</option>
							</select>
						</div>
						<br/><br/>
					</div>
					<div class='col-md-2' >
						
					</div>
					
					
				</div><br><br/>
				<div id = 'recibeResp' style = 'background-color:#fff;padding-top:20px;padding-bottom:20px;'></div>
		
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	
	<script>
		function enviaCierre(){
			if ( $(".deposito_pendiente").length > 0 ) { 
				var seleccionados = '';
				$(".deposito_pendiente").each(function(){
					var idBoleto = $(this).find('.idBoleto').val();
					seleccionados += idBoleto+'@';
				}); 
				var sumaValor = $('#sumaValor').val();
				var bco = $('#bco').val();
				var fec = $('#fec').val();
				var cta = $('#cta').val();
				var enc = $('#enc').val();
				var num = $('#num').val();
				
				var selecForm = seleccionados.substring(0,seleccionados.length - 1)
				//alert(selecForm);
				if(bco == '' ){
					alert('Debe ingresar un bco');
				}
				
				if(fec == '' ){
					alert('Debe ingresar una fecha');
				}
				
				if(cta == '' ){
					alert('Debe ingresar una cta');
				}
				
				if(enc == '' ){
					alert('Debe ingresar un encargado');
				}
				
				if(num == '' ){
					alert('Debe ingresar un num');
				}
				
				if(bco == '' || fec == '' || cta == '' || enc == '' || num == ''){
					
				}else{
					$('#enviaCierre').append("<br><center><img src = 'imagenes/ajax-loader.gif' /></center>");
					$.post("subpages/grabaCierreCaja.php",{ 
						selecForm : selecForm , sumaValor : sumaValor , bco : bco , fec : fec , cta : cta , enc : enc , num : num
					}).done(function(data){
						alert(data);
						window.location = '';
					});

				}
			}else{
				alert('no tiene facturas pendientes');
			}

		}
		function enviaFiltro(){
			var fecha_desde = $('#fecha_desde').val();
			var fecha_hasta = $('#fecha_hasta').val();
			
			var hora_desde = $('#hora_desde').val();
			var hora_hasta = $('#hora_hasta').val();
			
			var tipo_pago = $('#tipo_pago').val();
			
			if(fecha_desde == ''){
				alert('Debe ingresar una fecha de inicio');
			}
			
			
			if(fecha_hasta == ''){
				alert('Debe ingresar una fecha de fin');
			}
			
			if(fecha_desde == '' || fecha_hasta == '' ){
				
			}else{
				$('#recibeResp').css('height','60px');
				$('#recibeResp').html("<center><img src = 'imagenes/ajax-loader.gif' /></center>");
				$.post("subpages/filtroCierreCaja2.php",{ 
					fecha_desde : fecha_desde , fecha_hasta : fecha_hasta , hora_desde : hora_desde , 
					hora_hasta : hora_hasta , tipo_pago : tipo_pago
				}).done(function(data){
					// alert(data);
					$('#recibeResp').css('height','600px');
					$('#recibeResp').css('overflow-y','scroll');
					$('#recibeResp').css('overflow-x','none');
					$('#enviaCierre').fadeIn('fast');
					$('#recibeResp').html(data);
				});
			}
		}
		$(document).ready(function(){
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
				dateFormat: 'yy-mm-dd'
			};
			$.datepicker.setDefaults($.datepicker.regional['es']);
			
			$('.fecha').datepicker({
				showAnim: 'slideDown',
				buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
				showOtherMonths: true,
				changeMonth: true,
				changeYear: true
			});
			
			
			enviaFiltro();
		});
	</script>
			</div>
		</div>
	</div>
</body>