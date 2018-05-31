<?php 
	//include("controlusuarios/seguridadSA.php");
	include 'conexion.php';
	
	echo '<input type="hidden" id="data" value="2" />';
?>
<link rel="stylesheet" href="font-awesome-4.6.3/css/font-awesome.min.css">
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				DESCUENTOS
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px; text-align:center; color:#fff; font-size:18px;">
				<strong>Descuentos por evento &nbsp;&nbsp;&nbsp; <button type="button" class="btn btn-success" onclick = 'window.location = "?modulo=descuentoEventoDetalle&id=<?php echo $_REQUEST['id'];?>" '>Volver</button></strong>
				<!--<button type="button" class="btn btn-warning" onclick = "$('#modalLimiteCortesias').modal('show');"  >Ver Cortesias</button></strong>-->
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		</div>
		<div class = 'row'>
			<div class = 'col-md-1'></div>
			<div class = 'col-md-9'>
				<table class = 'table' style = 'color:#fff;'>
					
					<tr>
						<td colspan = '2' >
							Nombre Descuento : 
						</td>
						
						<td>
							<input type = 'text' class = 'form-control' id = 'nombre_todos' />
						</td>
						<td>
							Valor
						</td>
						<td>
							<input type = 'text' class = 'form-control' id = 'valor_todos' />
						</td>
						<td style = 'text-align:center;'>
							Aprobado : <input type = 'checkbox' id = 'check_todos' />
						</td>
						<td>
							<button type="button" class="btn btn-warning" onclick = 'grabarTodos(<?php echo $_REQUEST['id']; ?>)' >GRABAR A TODOS</button>
						</td>
						
					</tr>
					
					<tr>
						<td>
							EVENTO
						</td>
						<td>
							LOCALIDAD
						</td>
						<td>
							DESCRIPCION
						</td>
						<td>
							VALOR NORMAL
						</td>
						<td>
							VALOR DESCUENTO
						</td>
						<td width = '170px'>
							VALOR VENTA
						</td>
						<td style = 'text-align:center;'>
							DESCUENTO APROBADO  <i data-toggle="tooltip" data-placement="bottom" class="fa fa-question-circle fa-2x" style = 'cursor:pointer;' title="APLICA EN TRUE CUANDO ES UN DESCUENTO AUTORIZADO POR EL MUNICIPIO EJEMPLO : CORTESIAS , TERCERA EDAD , NIÑOS , PERSONAS CON DISCAPACIDAD !!! ." aria-hidden="true"></i>
						</td>
						<td>
							ACCION
						</td>
						
					</tr>
				<?php
					$sql = 'select * from Localidad where idConc = "'.$_REQUEST['id'].'" ';
					$res = mysql_query($sql) or die (mysql_error());
					
					$sql1 = 'select idConcierto , strEvento from Concierto where idConcierto = "'.$_REQUEST['id'].'" ';
					$res1 = mysql_query($sql1) or die (mysql_error());
					$row1 = mysql_fetch_array($res1);
					
					while($row = mysql_fetch_array($res)){
				?>
					<tr class = 'descuentos_global' numero_descuento = '<?php echo $row['idLocalidad'];?>' >
						<td>
							<?php echo $row1['strEvento'];?>
						</td>
						<td>
							<?php echo $row['strDescripcionL'];?>
						</td>
						<td>
							<input type = 'text' class = 'form-control nom_tod' id = 'nombDesc_<?php echo $row['idLocalidad'];?>' style = 'color:#000;' placeholder = 'Nombre Desc.'/>
							<input type = 'hidden' value = '<?php echo $row['idLocalidad'];?>' id = 'idLoc_<?php echo $param;?>' style = 'color:#000;'/>
						</td>
						<td>
							<?php echo $row['doublePrecioL'];?>
							<input type = "hidden" class = "precioLoc" value = "<?php echo $row['doublePrecioL'];?>" style="color:#000;width:60px;"/>
						</td>
						<td>
							<input type = 'text' class = 'form-control entero val_tod' id = 'valorDesc_<?php echo $row['idLocalidad'];?>' style = 'color:#000;' placeholder = 'Valor Dec.'/>
						</td>
						<td>
							<input type = 'text' value = '0' class = 'form-control entero' id = 'valorVenta_<?php echo $row['idLocalidad'];?>' style = 'color:#000;' placeholder = 'Valor Venta.'/>
						</td>
						<td style = 'text-align:center;'>
							<input type = 'checkbox' id = 'estado_impu_<?php echo $row['idLocalidad'];?>' class = 'check_todos'/>
						</td>
						<td>
							<button type="button" class="btn btn-success" onclick = 'grabarDescuento(<?php echo $row1['idConcierto'];?> ,  <?php echo $row['idLocalidad'];?>)' >GRABAR</button>
						</td>
					</tr>
				<?php
					} 
				?>
				</table>
			</div>
			<div class = 'col-md-1'></div>
		</div>
	</div>
	
	<div data-keyboard="false" data-backdrop="static" class="modal fade" id="modalLimiteCortesias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
						&nbsp;&nbsp;PARA PODER CONTINUAR DEBE INGRESAR LA CANTIDAD <b style = 'color:#000;'><i>LIMITE</i></b> DE CORTESIAS  PARA CADA LOCALIDAD !!!&nbsp;
					</div>
				</div>
				<div class="modal-body">
					<div class = 'row' >
						<div class = 'col-md-1'></div>
						<div class = 'col-md-10' id = 'recibeBoletos'>
							<table class = 'table' >
								<tr>
									<th>#</th>
									<th>Localidad</th>
									<th>Cantidad</th>
								</tr>
							<?php
								$sql2 = '	select l.idLocalidad , strDescripcionL , lc.cant as cantidad , lc.id as id_cantidades
											from Localidad as l
											left join localidad_cortesias as lc
											on lc.id_loc = l.idLocalidad
											where idConc = "'.$_REQUEST['id'].'" 
										';
								$res2 = mysql_query($sql2) or die (mysql_error());
								while($row2 = mysql_fetch_array($res2)){
									if($row2['id_cantidades'] != null){
										$id_cantidades = $row2['id_cantidades'];
									}else{
										$id_cantidades = 0;
									}
							?>
								<tr class = 'cantidades_cortesias' localidad = "<?php echo $row2['idLocalidad'];?>" >
									<td><?php echo $row2['idLocalidad'];?></td>
									<td><?php echo $row2['strDescripcionL'];?></td>
									<td>
										
										<input id = 'cantidad_<?php echo $row2['idLocalidad'];?>' type = "number" class = 'form-control' value = '<?php echo $row2['cantidad'];?>' />
										<input id = 'id_canti_<?php echo $row2['idLocalidad'];?>' type = "hidden" class = 'form-control' value = '<?php echo $id_cantidades;?>' />
										
									</td>
								</tr>
							<?php
								}
							?>
								<tr>
									<td colspan = '3' align = 'center'>
										<button type="button" class="btn btn-warning" onclick="grabarCantidades()">GRABAR</button>
									</td>
								</tr>
							</table>
						</div>
						<div class = 'col-md-1'></div>
					</div>
				</div>
				<div class="modal-footer"  >
					<img src='http://ticketfacil.ec/imagenes/loading.gif' width='100px' style='display:none;' id='loadBoleto1'/>
					<div id = 'recibePruebas'></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery.numeric.js"></script>
<script>
	function grabarCantidades(){
		var servi = '';
		var continua = 1;
		$( ".cantidades_cortesias" ).each(function( index ) {
			var localidad = $(this).attr('localidad');
			var cantidad_ = $(this).find('#cantidad_'+localidad).val();
			var id_canti_ = $(this).find('#id_canti_'+localidad).val();
			if(cantidad_ == ''){
				$('#cantidad_'+localidad).attr('placeholder','no puede dejar la cantidad en blanco');
				continua = 0;
			}else{
				servi += localidad +'@'+ cantidad_ +'@'+ id_canti_ + '|'
				continua = 1;
			}
			
		});
		var serviform = servi.substring(0,servi.length - 1);
		if(continua == 0){
			
		}else{
			// alert(serviform)
			$.post("spadmin/grabaCantidadCortesias.php",{ 
				serviform : serviform 
			}).done(function(data){
				alert(data)			
			});
		}
		
	}
	function grabarTodos(idCon){
		var servi = '';
		$( ".descuentos_global" ).each(function( index ) {
			var idLoc = $(this).attr('numero_descuento');
			var nombDesc = $('#nombDesc_'+idLoc).val();
			var valorDesc = $('#valorDesc_'+idLoc).val();
			var valorVenta_ = $('#valorVenta_'+idLoc).val();
			var estado_impu = '';
			if( $('#estado_impu_'+idLoc).is(':checked') ) {
				//alert('Seleccionado');
				estado_impu = 1;
			}else{
				//alert('no selected');
				estado_impu = 0;
			}
			
			// if(nombDesc == ''){
				// alert('ingrese nombre de descuento');
			// }
			
			// if(valorDesc == ''){
				// alert('ingrese valor de descuento');
			// }
			
			var ident = 0;
			if(nombDesc == '' || valorDesc == ''){
				alert('por favor debe llenar los nombres y valores de todos los descuentos ');
			}else{
				servi += idCon +'@'+ idLoc +'@'+ nombDesc +'@'+ valorDesc+'@'+ estado_impu +'@'+ ident +'@'+ valorVenta_ + '|';
				
			}
			
			
		});
		var serviform = servi.substring(0,servi.length - 1);
		$.post("spadmin/grabarDescuentoNuevo.php",{ 
			serviform : serviform
		}).done(function(data){
			alert(data);
			window.location = '?modulo=descuentoEventoDetalle&id='+idCon;
		});
	}
	$( document ).ready(function() {
		$("#nombre_todos").blur(function(){
			
			var nom_tod = $("#nombre_todos").val();
			var res = nom_tod.substring(0, 6);
				// alert('hola' + res)
			if(res == 'cortes' || res == 'CORTES'){
				$('#modalLimiteCortesias').modal('show');
				$('#valor_todos').val(0);
			}else{
				$('#modalLimiteCortesias').modal('hide');
				$('#valor_todos').val(0);
			}
		}); 
		
		$('.entero').numeric();
		
		$( "#nombre_todos" ).keyup(function() {
			var nom_tod = $(this).val();
			$('.nom_tod').val(nom_tod);
		});
		
		$( "#valor_todos" ).keyup(function() {
			var valor_todos = $(this).val();
			var nombre_todos = $( "#nombre_todos" ).val();
			
			$( ".descuentos_global" ).each(function( index ) {
				var id_loc = $(this).attr('numero_descuento');
				var precioLoc = $(this).find('.precioLoc').val();
				
				
				var res = nombre_todos.substring(0, 6);
				
				if(res == 'especi' || res == 'ESPECI'){
					
					valor_todos = (parseFloat(precioLoc) / 2);
					$('#estado_impu_'+id_loc).attr('checked',true);
				}else{
					valor_todos = $( "#valor_todos" ).val();
					$('#estado_impu_'+id_loc).attr('checked',false);
				}
				 // alert(nombre_todos + ' << hola >>' + valor_todos)
				$('#valorDesc_'+id_loc).val(valor_todos);
				$('#valorVenta_'+id_loc).val(valor_todos);
			});
			
		});
		
		$("#check_todos").change(function () {
			$(".check_todos").prop('checked', $(this).prop("checked"));
		});
	});
	function grabarDescuento(idCon , idLoc){
		var nombDesc = $('#nombDesc_'+idLoc).val();
		var valorDesc = $('#valorDesc_'+idLoc).val();
		var valorVenta = $('#valorVenta_'+idLoc).val();
		var estado_impu = '';
		if( $('#estado_impu_'+idLoc).is(':checked') ) {
			//alert('Seleccionado');
			estado_impu = 1;
		}else{
			//alert('no selected');
			estado_impu = 0;
		}
		
		if(nombDesc == ''){
			alert('ingrese nombre de descuento');
		}
		
		if(valorDesc == ''){
			alert('ingrese valor de descuento');
		}
		
		if(valorVenta == ''){
			alert('ingrese valor de venta');
		}
		
		var ident = 0;
		if(nombDesc == '' || valorDesc == '' || valorVenta == ''){
			
		}else{
			$.post("spadmin/grabarDescuento.php",{ 
				idCon : idCon , idLoc : idLoc , nombDesc : nombDesc , valorDesc : valorDesc , 
				estado_impu : estado_impu , ident : ident , valorVenta : valorVenta
			}).done(function(data){
				alert(data)			
			});
		}
		
	}
</script>