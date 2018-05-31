	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		//CheckEndDate(obj,amountDays);
		
		// var initAmountDays = 4;
		// var startDateUnix = new Date($('#fecha_salida').val()+'T14:30:00.0Z').getTime()/1000;
		// CheckEndDate(startDateUnix,initAmountDays);
		
		
		function CheckEndDate(obj,amountDays){
	//alert(obj +'<<>>'+ amountDays );
		return parseInt(parseInt(obj) + (amountDays * 86400));
		}
		function noExcursion(date){
			var day = date.getDay();
			return [(day != 0 && day != 3), ''];
		}
		$(function() {
			
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
				minDate: 0,
			};
			$.datepicker.setDefaults($.datepicker.regional['es']);
			var initAmountDays = 4;
			$('#fecha_salida').on('change',function(){
				
				//var startDateUnix = new Date((fechaEnt+'T14:30:00.0Z').getTime()/1000);
				var startDateUnix = new Date($('#fecha_salida').val()+'T14:30:00.0Z').getTime()/1000;
				//alert('numero entrada : ' + startDateUnix);
				endDateUnix = CheckEndDate(startDateUnix,initAmountDays);
				
				endDateObject = new Date(parseInt(endDateUnix) * 1000);
				console.log('tu dia de salida es ' + endDateObject.getDay());
				
			  if(endDateObject.getDay() == 0 || endDateObject.getDay() == 3){
				 console.log('cayo en domingo o miercoles tu salida ' + endDateObject.getDay());
				 initAmountDays = 4;
				 endDateUnix = CheckEndDate(startDateUnix,initAmountDays);
				 endDateObject = new Date(parseInt(endDateUnix) * 1000);
				 }
			  
				var formatEndDate = endDateObject.getFullYear() +'-'+ ('0'+ (endDateObject.getMonth() + 1)).slice(-2) +'-'+ ('0'+ endDateObject.getDate()).slice(-2);
				//alert('fecha salida : ' + formatEndDate +'noches : '+ initAmountDays + 'dia de salida : ' + endDateObject.getDay());
				//$('#endDate').val(initAmountDays);
				$('#fecha_regreso').val(formatEndDate);
			});
			$( "#ori" ).focus(function() {
				$( "#ori" ).val('');
			});
			$( "#llega" ).focus(function() {
				$( "#llega" ).val('');
			});
			
			var diasCalendario = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
			var mesesCalendario = ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'];
			
			$( ".fechas" ).datepicker({
				showAnim: 'slideDown',
				 buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
				showOtherMonths: true,
				dateFormat: 'yy-mm-dd',
				dayNamesShort: diasCalendario,
				monthNamesShort : mesesCalendario,
				//minDate: +1
				//beforeShowDay: noExcursion
			});
			
			$("#fecha_regreso").attr('disabled', false);  
			
			$("#saber_ida_vuelta").click(function() {  
				//console.log(fecha_regreso_aux);
				if($("#saber_ida_vuelta").is(':checked')){  
					//alert("Está activado");  
					//$("#contine_regreso").css('display','none');  
					$("#fecha_regreso").attr('disabled', true);  
					//$( ".block_fecha" ).animate({width: '90%'});
					
				}else{  
					//alert("No está activado");  
					//$("#fecha_regreso").val(fecha_regreso_aux);  
					$("#fecha_regreso").attr('disabled', false);  
					// $("#contine_regreso").css('display','block');  
					// $( ".block_fecha" ).animate({width: '45%'});
				}  
			});  
			
			$( "#normales" ).change(function() {
				sumarBoletos();
			});
			$( "#especiales" ).change(function() {
				sumarBoletos();
			});
			
		});
		function sumarBoletos(){
			var normales = $('#normales').val();
			var especiales = $('#especiales').val();
			
			var total_boletos = (parseInt(normales)+parseInt(especiales));
			$('#total_boletos').val(total_boletos);
		}
		function buscaCiudadSalida(){
			var term = $('#ori').val();
			if(term == ''){ 
				
			}else{
				$('#recibeCiuSali').html('');
				$.post("ajax/search.php",{ 
					term : term 
				}).done(function(data){
					$('#recibeCiuSali').html(data);
				});
			}
			//alert(term)
			
		}
		function buscaCiudadSalida2(){
			var term = $('#llega').val();
			if(term == ''){ 
				
			}else{
				$('#recibeCiuLlega').html('');
				$.post("ajax/searchSali.php",{ 
					term : term 
				}).done(function(data){
					$('#recibeCiuLlega').html(data);
				});
			}
			//alert(term)
			
		}
		
		
		
		function poneNombreCiudadSalida(id_ciu , nom_ciu , id_ter , nom_ter){
			$('#recibeCiuSali').html('');
			console.log(nom_ciu+'  '+nom_ter);
			$( "#ori" ).val(nom_ciu+'  '+nom_ter);
			$('#id_ciu_sali').val(id_ciu);
			$('#id_ter_sali').val(id_ter);
			
		}
		
		function poneNombreCiudadSalida2(id_ciu , nom_ciu , id_termi , nom_ter){
			$('#recibeCiuLlega').html('');
			console.log(nom_ciu+'  '+nom_ter);
			$( "#llega" ).val(nom_ciu+'  '+nom_ter);
			$('#id_ciu_llega').val(id_ciu);
			$('#id_ter_llega').val(id_termi);
			
		}
		
		function buscarRuta(){
			var salida = $('#id_ciu_sali').val();
			var terminal = $('#id_ter_sali').val();
			var terminal_llega = $('#id_ter_llega').val();
			var llegada = $('#id_ciu_llega').val();
			var id_coop = $('#cooperativa').val();
			var fecha_salida = $('#fecha_salida').val();
			
			var normales = $('#normales').val();
			var especiales = $('#especiales').val();
			
			
			if($("#saber_ida_vuelta").is(':checked')){  
				var fecha_regreso = '';
			}else{  
				var fecha_regreso = $('#fecha_regreso').val();
			}  
			
			
			
			if(salida == ''){
				alert('Debe seleccionar una ciudad de salida');
			}
			if(llegada == ''){
				alert('Debe seleccionar una ciudad de destino');
			}
			
			if(fecha_salida == ''){
				alert('Debe seleccionar una fecha de salida');
			}
			if(salida == '' || llegada == '' || fecha_salida == '' ){
				
			}else{
				$('#recibeRuta').html('');
				$('#loadBusqRuta').css('display','block');
				var posisionForm = (($('.thinner').position().top)/2);
				console.log(posisionForm);
				//alert(posisionForm);
				setTimeout(function(){
					$.post("ajax/buscarRuta.php",{ 
						salida : salida , llegada : llegada , terminal : terminal , id_coop : id_coop , fecha_salida : fecha_salida , terminal_llega , terminal_llega ,
						fecha_regreso : fecha_regreso , normales : normales , especiales : especiales
					}).done(function(data){
						$('#loadBusqRuta').css('display','none');
						$('#recibeRuta').html(data);
						$('#recibeRuta').show('blind');
						$( "html, body " ).animate({
							scrollTop: posisionForm,
						}, 1500, function() {
							
						});
					});
				}, 2000);
				
			}
			
		}
		
		
		
		
		
	</script>

	<?php
		$startDate = date("Y-m-d");
		$endDate = date("Y-m-d",strtotime(date("Y-m-d", strtotime("+4 days"))));
	?>
	<div class='row' style = 'background-image:url(images/busFondo.jpg);background-size: cover;background-position: center center;background-repeat: no-repeat;background-attachment: fixed;background-color: #66999'>
		
		<div class = 'col-md-8'>
			<br/><br/>
			<div class="titulo">
				<div class="row">
					<div class="col-xs-1" style = 'height: 45px'>
						
					</div>
					<div class="col-xs-2" >
						VENTA
					</div>
					<div class="col-xs-7" style = 'text-align:center;'>
						<img src = 'images/ajax-loader.gif' style = 'height:40px;margin:0 auto;display:none;' id = 'loadBusqRuta'/>
					</div>
					<div class="col-xs-1" style = 'height: 45px'>
						
					</div>
				</div>
			</div><br/><br/>
			<div class='row'>
				<div class = 'col-xs-1'></div>
				<div class = 'col-xs-10'>
					<div class="form-group has-success has-feedback">
						<div class="input-group">
							<span class="input-group-addon" style='background: #0386A4;color: #fff;font-weight: 300;padding-right: 50px'>ORIGEN</span>
							<input class="form-control input-md"  style="text-transform: uppercase; ;border:none;" id = 'ori' onkeyup = 'buscaCiudadSalida();' placeholder = 'Escribe tu ciudad de salida' />
							<input type = 'hidden' id = 'id_ciu_sali' placeholder = 'ciu salida' />
							<input type = 'hidden' id = 'id_ter_sali' placeholder = 'term salida' />
						</div>
						<div style='width:100%;position:absolute;z-index:3000;float:right' id = 'recibeCiuSali' ></div>
					</div>
					
					<div class="form-group has-success has-feedback">
						<div class="input-group">
							<span class="input-group-addon" style='background: #0386A4;color: #fff;font-weight: 300;padding-right: 42px'>DESTINO</span>
							<input class="form-control input-md"  style="text-transform: uppercase; ;border:none;" id = 'llega' onkeyup = 'buscaCiudadSalida2();' placeholder = 'Escribe tu ciudad de llegada'/>
							<input type = 'hidden' id = 'id_ciu_llega' />
							<input type = 'hidden' id = 'id_ter_llega'/>
						</div>
						<div style='width:100%;position:absolute;z-index:3000;float:right' id = 'recibeCiuLlega' ></div>
					</div>
					
					
					<div class="form-group has-success has-feedback">
						<div class="input-group">
							<span class="input-group-addon" style='background: #0386A4;color: #fff;font-weight: 300;padding-right: 59px;'>COOP.</span>
							<select class="form-control input-md"  style="text-transform: uppercase; ;" id = 'cooperativa'>
								<option value = ''>TODAS LAS COPERATIVAS...</option>
								<?php
									$sqlTer = 'select * from cooperativa where est = 1 order by nom asc';
									$resTer = mysql_query($sqlTer) or die (mysql_error());
									while($rowTer = mysql_fetch_array($resTer)){
								?>
										<option value = '<?php echo $rowTer['id'];?>'><?php echo $rowTer['nom'];?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
					<table width='100%'>
						<tr>
							<td width='45%' class = 'block_fecha'>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon" style='background: #0386A4;color: #fff;font-weight: 300;padding-right: 29px'>FECHA IDA</span>
										<input class="form-control input-md fechas"  style="text-transform: uppercase;border:none;" id = 'fecha_salida' placeholder = 'Fecha Salida' value = '<?php echo $startDate;?>' />
										
									</div>
								</div>
							</td>
							<td align='center'>
								<span style='font-size:8px;color:#fff;'>solo ida</span><br/>
								<input type='checkbox' id='saber_ida_vuelta'/>
							</td>
							<td width='45%' >
								<div class="form-group" id = 'contine_regreso'>
									<div class="input-group">
										<span class="input-group-addon" style='background: #0386A4;color: #fff;font-weight: 300;padding-right: 10px'>FECHA REGRESO</span>
										<input class="form-control input-md fechas"  style="text-transform: uppercase; ;border:none;" placeholder = 'Fecha Regreso' id = 'fecha_regreso' value = '<?php echo $endDate;?>' />
										
									</div>
								</div>
								
								<!--<div class="form-group">
									<label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
									<div class="input-group">
										<div class="input-group-addon">$</div>
										<input type="text" class="form-control" id="exampleInputAmount" placeholder="Amount" />
										<div class="input-group-addon">.00</div>
									</div>
								</div>-->
							</td>
						</tr>
					</table>
					
					<table width='100%'>
						<tr>
							<td width='48%' style = 'padding-right:2%;'>
								<div class="form-group has-success has-feedback">
									<div class="input-group">
										<span class="input-group-addon" style='background: #0386A4;color: #fff;font-weight: 300;font-size:10px;'>ASIENTOS <br/>NORMALES</span>
										<select class="form-control input-md"  style="text-transform: uppercase;border:none;" id='normales'>
											<option value = '0' >Seleccione</option>
											<option value = '1' >1</option>
											<option value = '2' >2</option>
											<option value = '3' >3</option>
											<option value = '4' >4</option>
											<option value = '5' >5</option>
											<option value = '6' >6</option>
										</select>
									</div>
								</div>
							</td>
							<td width='48%' style = 'paddin-left:2%;'>
								<div class="form-group has-success has-feedback">
									<div class="input-group">
										<span class="input-group-addon" style='background: #0386A4;color: #fff;font-weight: 300;font-size:10px;'>ASIENTOS <br/>PREFERENCIALES</span>
										
										<select class="form-control input-md"  style="text-transform: uppercase;border:none;" id = 'especiales'>
											<option value = '0' >Seleccione</option>
											<option value = '1' >1</option>
											<option value = '2' >2</option>
											<option value = '3' >3</option>
											<option value = '4' >4</option>
											<option value = '5' >5</option>
											<option value = '6' >6</option>
										</select>
									</div>
								</div>
								
							</td>
							
						</tr>
						<tr>
							<td></td>
							<td style = 'padding-bottom:10px;'>
								<div style = 'width:100%;text-align:center;font-size:0.84rem;color:#fff;padding-top:4px;padding-bottom:2px;background:#0386A4'>
									* Los Asientos aplican para adultos mayores y niños menores de 6 años!
								</div>
							</td>
						</tr>
						<tr>
							<td colspan = '2'>
								
									<div class="form-group has-success has-feedback">
										<div class="input-group">
											<span class="input-group-addon" style='background:#0386A4;color:#fff;font-weight:bold;'>TOTAL</span>
											<input class="form-control input-md"  style="text-transform: uppercase;border:none;" disabled readonly id = 'total_boletos' placeholder = 'TOTAL'	/>
										</div>
									</div>
								
							</td>
						</tr>
					</table>
					
					<div class = 'col-xs-1'></div>
					<div class = 'col-xs-10' style='text-align:center;'>
						<button type="button" class="btn btn-warning" onclick = 'buscarRuta()'>BUSCAR DISPONIBILIDAD</button>
					</div>
					<div class = 'col-xs-1'></div>
				</div>
				<div class = 'col-xs-1'></div>
			</div>
			
			
			
		</div>
		<div class = 'col-md-3' style='margin:0;padding:0;'>
			<div class = 'titulo2'>
				<p style = 'color:#26A9E0;font-family:Helvetica;font-size:23pt;font-weight:300;'>
					SOLO EN 3 PASOS LLEGARÁS A TU DESTINO
				</p>
				<hr/>
				<p style = 'color:#fff;font-family:Helvetica;font-size:13pt;font-weight:300;'>
					AGILITA TU COMPRA
					CON LA TARIFA
					MÁS ECONÓMICA
					DEL MERCADO
				</p>
				<br/>
				<!--<table width = '100%'>
					<tr>
						<td style = 'color:#fff;font-size:15pt;font-family:Helvetica;font-weight:bold;' colspan = '3' >
							SELECCIONA
						</td>
					</tr>
					<tr>
						<td><img src = 'images/triangulo.png' /></td>
						<td><img src = 'images/btnIda.png' /></td>
						<td><img src = 'images/btnRegreso.png' /></td>
					</tr>
				</table>-->
				<img src = 'images/siguiente.png' style = 'margin-left:-35px;cursor:pointer;display:none;' id = 'posSigui'/>
			</div>
		</div>
		
		
		
		<div class = 'col-xs-1'></div>
		<div class = 'col-xs-12' style = 'text-align:center;'>
			<div id = 'recibeRuta' style = 'height:300px;overflow-y:scroll;width:100%;display:none;'></div>
		</div>
		<div class = 'col-xs-1'></div>
		
	</div>