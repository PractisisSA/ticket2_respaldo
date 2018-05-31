<?php
	session_start();
	include('conexion.php');
	ini_set('display_errors', 'On');
    error_reporting(E_ALL);

	$sql = 'SELECT c.idConcierto  , u.strObsCreacion , d.conciertoDet , c.strEvento
			FROM Usuario AS u , detalle_distribuidor AS d , Concierto AS c
			WHERE idUsuario = '.$_SESSION['iduser'].' 
			AND u.strObsCreacion = d.idDis_Det
			AND d.conciertoDet = c.idConcierto 
			AND idConcierto >= 73
			AND dateFecha > now()
			order by idConcierto DESC';
	$res = mysql_query($sql);
?>
	<style>
		.boletos_express_rojo{
			background-color: #ED1568;color:#fff;
		}
	</style>
	<div class="alert alert-success" role="alert" style="background-color: white !important; color: black !important;">
	  	<h4 class="alert-heading">Facturación</h4>
	  	<p>Modulo para impresion masiva de facturas.</p>
	  	<hr>
	  	
		<div class="row">
			<div class="col-md-2">
				<select id="eventos_expres" class="form-control" >
					<option id="firstOptionValue0" value="0">Seleccione...</option>
					<?php
						while ($row = mysql_fetch_array($res)) {
							$concertsIds = $row['idConcierto'];
							$concertsNames = $row['strEvento'];
							$concertsDates = $row['dateFecha'];
							$concertsTimes = $row['timeHora'];
							echo "<option value=".$concertsIds.">".$concertsIds."--".$concertsNames."</option>";
						}
					?>
				</select>
			</div>
			<div class="col-md-3">
				<input type = 'text' class = 'form-control limpiar letras' placeholder = 'Localidad' id = 'localidad_expres' disabled />
			</div>
			<div class="col-md-2">
				<input type = 'text' class = 'form-control limpiar letras' placeholder = 'Descuentos' id = 'descuentos_expres' />
			</div>
			<div class="col-md-2">
				<input type = 'text' class = 'form-control limpiar' placeholder = 'Cantidad' id = 'cantidad_expres' onblur = 'saberCantidad()' onkeyup="this.value = this.value.replace (/[^0-9]/, ''); " />
			</div>
			<div class="col-md-1" style = 'text-align:center;'>
				<button type="button" class="btn btn-info" id = 'enviaFactura_' onclick = 'enviaFactura()' >Enviar</button>
			</div>
		</div>
		
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<table class = 'table' style = 'background-color:#fff;'>
				<thead>
					<tr>
						<th>Evento</th>
						<th>Localidad</th>
						<th>Descuentos</th>
						<th style = 'text-align:center;'>Cantidad</th>
						<th style = 'text-align:center;'>Precio</th>
						<th style = 'text-align:center;'>Total</th>
						<th style = 'text-align:center;'>Eliminar</th>
					</tr>
				</thead>
				<tbody id = 'recibeFactura'>
					
				</tbody>
				<tfoot>
					<tr>
						<th colspan = '3' style = 'text-align:right;padding-right:20px;'></th>
							
						<th id = 'cantidadTotal' style = 'text-align:center;'></th>
						<th></th>
						<th id = 'totalGlobal' style = 'background-color: #171A1B;color: #1E9F75;text-align: center; font-size: 20px'>0.00</th>
						<th style = 'text-align:center;'>
							<button type="button" class="btn btn-info" onclick = 'generaFactura()' id = 'generaFactura' >Facturar</button>
						</th>
					</tr>
					<tr>
						<th colspan = '5'  style="text-align: right" >
							
						</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	
	<script type="text/javascript">
		
		$(document).ready(function () {
			
			$('#eventos_expres').change(function(){
				var eventos_expres = $('#eventos_expres').val();
				if(eventos_expres > 0){
					$("#localidad_expres").attr('disabled',false);
					$('#localidad_expres').focus();
				}else{
					$("#localidad_expres").attr('disabled',true);
				}
			});
			
			src = 'subpages/Facturas/includes/localidad_expres.php';

			// Load the cities straight from the server, passing the country as an extra param
			$("#localidad_expres").autocomplete({
				source: function(request, response) {
					$.ajax({
						url: src,
						dataType: "json",
						data: {
							term : request.term,
							concert : $("#eventos_expres").val()
						},
						success: function(data) {
							response(data);
						}
					});
				},
				min_length: 1,
				delay: 100
			});	



			src2 = 'subpages/Facturas/includes/localidad_descuentos.php';

			// Load the cities straight from the server, passing the country as an extra param
			$("#descuentos_expres").autocomplete({
				source: function(request, response) {
					$.ajax({
						url: src2,
						dataType: "json",
						data: {
							term : request.term,
							localidad : $("#localidad_expres").val()
						},
						success: function(data) {
							response(data);
						}
					});
				},
				min_length: 1,
				delay: 100
			});	
			
			
			$(".letras").keypress(function (key) {
				console.log(key.charCode)
				if ((key.charCode < 97 || key.charCode > 122)//letras mayusculas
					&& (key.charCode < 65 || key.charCode > 90) //letras minusculas
					&& (key.charCode != 45) //retroceso
					&& (key.charCode != 0) //tab
					&& (key.charCode != 241) //ñ
					 && (key.charCode != 209) //Ñ
					 && (key.charCode != 32) //espacio
					 && (key.charCode != 225) //á
					 && (key.charCode != 233) //é
					 && (key.charCode != 237) //í
					 && (key.charCode != 243) //ó
					 && (key.charCode != 250) //ú
					 && (key.charCode != 193) //Á
					 && (key.charCode != 201) //É
					 && (key.charCode != 205) //Í
					 && (key.charCode != 211) //Ó
					 && (key.charCode != 218) //Ú
	 
					)
					return false;
			});
			
			
			$("#cantidad_expres").keypress(function (key) {
				console.log(key.charCode)
				//solo numeros
				if ((key.charCode < 48 || key.charCode > 57) && (key.charCode != 0) )
					return false;
			});
		})
		
		function saberCantidad(){
			var idloc_ = $("#localidad_expres").val();
			var nomDesc_ = $("#descuentos_expres").val();
			
			var idloc2 = idloc_.split("-");
			var nomDesc = nomDesc_.split("-");
			var idloc = idloc2[0];
			
			var num_personas = $('#cantidad_expres').val();
			var id_desc = nomDesc[0];
			var res_Nom_Desc = nomDesc[1].substring(0, 7);
			if(res_Nom_Desc == 'CORTESI' || res_Nom_Desc == 'cortesi'){
				$('#enviaFactura_').attr('disabled',true);
				$('#enviaFactura_').removeClass('btn btn-info');
				$('#enviaFactura_').addClass('btn btn-warning');
				$.post("spadmin/saberCantidadCortesias.php",{ 
					idloc : idloc ,id_desc : id_desc , num_personas : num_personas
				}).done(function(data){
					// alert(data)	
					var res = data.split("|"); 
					var ident = res[0];
					var cantidad_aut = res[1];
					if(ident == 0){
						alert('Atencion!! , no puede comprar : ' + num_personas + ' tickets , por que solo disponemos de : ' + cantidad_aut + ' tickets autorizados para cortesias , cambie la cantidad');
						// $("#descuentos_expres").val('');
						$('#cantidad_expres').val(cantidad_aut);
						$('#cantidad_expres').focus();
						
						$('#enviaFactura_').attr('disabled',false);
						$('#enviaFactura_').removeClass('btn btn-warning');
						$('#enviaFactura_').addClass('btn btn-info');
					}else if(ident == 3){
						alert('Atencion!! , no puede comprar : ' + num_personas + ' tickets , por que ya no hay disponibilidad de tickets');
						
						$("#localidad_expres").val('');
						$("#descuentos_expres").val('');
						$('#cantidad_expres').val('');
						$('#enviaFactura_').attr('disabled',false);
						$('#enviaFactura_').removeClass('btn btn-warning');
						$('#enviaFactura_').addClass('btn btn-info');
					}else if(ident == 2){
						alert('no se a configurado la cantidad de las cortesias , debe pedir al administrador del sistema configurar dicha cantidad');
						$('#cantidad_expres').val('');
						$('#enviaFactura_').attr('disabled',false);
						$('#enviaFactura_').removeClass('btn btn-warning');
						$('#enviaFactura_').addClass('btn btn-info');
					}else{
						$('#enviaFactura_').attr('disabled',false);
						$('#enviaFactura_').removeClass('btn btn-warning');
						$('#enviaFactura_').addClass('btn btn-info');
						enviaFactura();
					}
				});
			}else if ((res_Nom_Desc != 'CORTESI' || res_Nom_Desc != 'cortesi') && res_Nom_Desc != 'selecci'){
				
				$('#enviaFactura_').attr('disabled',true);
				$('#enviaFactura_').removeClass('btn btn-info');
				$('#enviaFactura_').addClass('btn btn-warning');
				
				$.post("spadmin/saberCantidad_No_Cortesias.php",{ 
					idloc : idloc , num_personas : num_personas
				}).done(function(data){
					// alert(data)	
					var res = data.split("|"); 
					var ident = res[0];
					var cantidad_aut = res[1];
					if(ident == 0){
						alert('Atencion!! , no puede comprar : ' + num_personas + ' tickets , por que solo disponemos de : ' + cantidad_aut + ' tickets autorizados , se reconfigurara la compra');
						$('#cantidad_expres').val(cantidad_aut);
						$('#cantidad_expres').focus();
						
						$('#enviaFactura_').attr('disabled',false);
						$('#enviaFactura_').removeClass('btn btn-warning');
						$('#enviaFactura_').addClass('btn btn-info');
						
					}else if(ident == 1){
						
						$('#enviaFactura_').attr('disabled',false);
						$('#enviaFactura_').removeClass('btn btn-warning');
						$('#enviaFactura_').addClass('btn btn-info');
						enviaFactura()
						
					}else if(ident == 2){
						alert('Atencion!! , no puede comprar : ' + num_personas + ' tickets , por que ya no hay disponibilidad de tickets !!');
						
						$("#localidad_expres").val('');
						$('#descuentos_expres').val('');
						$('#cantidad_expres').val('');
						$('#enviaFactura_').attr('disabled',false);
						$('#enviaFactura_').removeClass('btn btn-warning');
						$('#enviaFactura_').addClass('btn btn-info');
					}
				});
			}
		}
		
		
		function enviaFactura(){
			var localidad_expres = $('#localidad_expres').val();
			var descuentos_expres = $('#descuentos_expres').val();
			var cantidad_expres = $('#cantidad_expres').val();
			
			if(localidad_expres == ''){
				alert('debe ingresar una localidad');
			}
			
			if(descuentos_expres == ''){
				alert('debe ingresar un descuento');
			}
			
			if(cantidad_expres == ''){
				alert('debe ingresar una cantidad de tickets');
			}
			
			if(localidad_expres == '' || descuentos_expres == '' || cantidad_expres == ''){
				
			}else{
				if(cantidad_expres ==0){
					alert('no puede enviar en cantidad 0 , \n ingrese cantidad valida')
				}else{
					var expLoc = localidad_expres.split("-");
					var expDesc = descuentos_expres.split("-");
					
					var nomLoc = expLoc[1];
					var evento = expLoc[2];
					var nomDescu = expDesc[1];
					var precioDescu = expDesc[2];
					
					var identi = $('.boletos_express').length;
					identi = (parseInt(identi) + 1);
					var tr = '	<tr class = "boletos_express" id = "fila_boleto_'+identi+'">\
									<td style ="text-align:center;">\
										'+evento+'\
										<input type = "hidden" value = "'+expLoc[2]+'" class = "idcon"/> \
									</td>\
									<td>\
										'+nomLoc+'\
										<input type = "hidden" value = "'+expLoc[0]+'" class = "id_loc"/> \
									</td>\
									<td>\
										'+nomDescu+'\
										<input type = "hidden" value = "'+expDesc[0]+'" class = "id_desc"/> \
										<input type = "hidden" value = "'+expDesc[1]+'" class = "nom_desc"/> \
										<input type = "hidden" value = "'+expDesc[2]+'" class = "pre_desc"/> \
									</td>\
									<td style = "text-align:center;">\
										'+cantidad_expres+'\
										<input type = "hidden" value = "'+cantidad_expres+'" class = "cantidad_expres_ingresada" id = "cantidad_parcial_'+identi+'" /> \
									</td>\
									<td style = "text-align:center;">'+precioDescu+'</td>\
									<td class = "" style = "text-align:center;">\
										'+(parseFloat(cantidad_expres) * parseFloat(precioDescu))+'\
										<input type = "hidden" value = "'+(parseFloat(cantidad_expres) * parseFloat(precioDescu))+'" id = "total_parcial_'+identi+'" class = "total_parcial_ingresado"/> \
									</td>\
									<td style = "text-align:center !important;">\
										<span id = "quilaFila_'+identi+'" onclick = "quilaFila('+identi+')" class="glyphicon glyphicon-remove" aria-hidden="true" style = "color:red;cursor:pointer;" ></span>\
										<span id = "ponerFila_'+identi+'" onclick = "ponerFila('+identi+')" class="glyphicon glyphicon-ok" aria-hidden="true" style = "color:#fff;cursor:pointer;display:none;" ></span>\
									</td>\
								</tr>';
					$('#recibeFactura').append(tr);
					$('.limpiar').val('');
					$('#localidad_expres').focus();
					
					sumaGlobal();
				}
			}
		}
		function quilaFila(id){
			$('#fila_boleto_'+id).removeClass('boletos_express');
			$('#fila_boleto_'+id).addClass('boletos_express_rojo');
			
			$('#cantidad_parcial_'+id).removeClass('cantidad_expres_ingresada')
			$('#total_parcial_'+id).removeClass('total_parcial_ingresado')
			
			
			$('#quilaFila_'+id).css('display','none');
			$('#ponerFila_'+id).css('display','block');
			sumaGlobal();
		}
		
		function ponerFila(id){
			
			$('#cantidad_parcial_'+id).addClass('cantidad_expres_ingresada')
			$('#total_parcial_'+id).addClass('total_parcial_ingresado')
			
			
			$('#fila_boleto_'+id).removeClass('boletos_express_rojo');
			$('#fila_boleto_'+id).addClass('boletos_express');
			$('#ponerFila_'+id).css('display','none');
			$('#quilaFila_'+id).css('display','block');
			sumaGlobal();
		}
		function sumaGlobal(){
			
			var suma_cantidad_expres_ingresada = 0;
			$( ".cantidad_expres_ingresada" ).each(function( index ) {
				var cantidad_expres_ingresada = $(this).val();
				suma_cantidad_expres_ingresada += (parseInt(cantidad_expres_ingresada));
			});
			
			$('#cantidadTotal').html(suma_cantidad_expres_ingresada);
			
			
			var suma_total_parcial_ingresado = 0;
			$( ".total_parcial_ingresado" ).each(function( index ) {
				var total_parcial_ingresado = $(this).val();
				suma_total_parcial_ingresado += (parseFloat(total_parcial_ingresado));
			});
			
			$('#totalGlobal').html(suma_total_parcial_ingresado);
			
		}
		
		function generaFactura(){

			if($('.boletos_express').length == 0){
				alert('primero debe cargar la factura');
			}else{
				// var idcon = $("#eventos_expres").val()
				var servi = ''
				$('.boletos_express').each(function(){
					var idcon = $(this).find('td .idcon').val();
					var id_loc = $(this).find('td .id_loc').val();
					var id_desc = $(this).find('td .id_desc').val();
					var nom_desc = $(this).find('td .nom_desc').val();
					var pre_desc = $(this).find('td .pre_desc').val();
					var cantidad_expres_ingresada = $(this).find('td .cantidad_expres_ingresada').val();
					var total_parcial_ingresado = $(this).find('td .total_parcial_ingresado').val();
					servi += id_loc +'@'+ id_desc +'@'+ nom_desc +'@'+ pre_desc  +'@'+ cantidad_expres_ingresada +'@'+ total_parcial_ingresado +'@'+ idcon + '|'
				});
				
				var serviform = servi.substring(0,servi.length - 1)
				// alert(serviform + ' << >> ' + idcon);
				$('#generaFactura').html('Espere , generando facturas');
				$('#generaFactura').attr('disabled',true);
				$.post("subpages/Facturas/includes/generaFactura.php",{ 
					serviform : serviform
				}).done(function(data){
					$('#generaFactura').html('Facturar');
					$('#generaFactura').attr('disabled',false);
					alert(data);
					window.location = '';
				});
			}
			
		}
	</script>
	
	
	
	
	
	
	
	
	
	
	