<?php

	include '../conexion.php';
	$socio_membresia = $_REQUEST['socio_membresia'];
	
	$sqlM1 = 'select count(id) as cuantos from membresia where id_empresario = "'.$socio_membresia.'" order by membresia asc';
	$resM1 = mysql_query($sqlM1) or die (mysql_error());
	$rowM1 = mysql_fetch_array($resM1);
	
	
	$sqlM = 'select * from membresia where id_empresario = "'.$socio_membresia.'" order by membresia asc';
	$resM = mysql_query($sqlM) or die (mysql_error());
	
	$sqlS = 'SELECT * FROM `Usuario` WHERE `idUsuario` = "'.$socio_membresia.'" ORDER BY `idUsuario` DESC ';
	$resS = mysql_query($sqlS) or die (mysql_error());
	$rowS = mysql_fetch_array($resS);
	
	if($rowM1['cuantos']>0){
		
?>
			<tr style = 'background-color: #fff;color: #000'>
				<td >
					#
				</td>
				<td>
					<input type = 'text' value = '<?php echo $rowS['strNombreU']; ?>' disabled="disabled" readonly="readonly" />
					<input type = 'hidden' id = 'id_empresario_<?php echo $socio_membresia; ?>' value = '<?php echo $socio_membresia; ?>' />
				</td>
				<td>
					<input type = 'text' id = 'membresia_<?php echo $socio_membresia; ?>' placeholder = 'Ingrese Membresia'  />
				</td>
				
				<td>
					<select style = 'width:100px;' class = 'form-control' onchange = 'saberTipoPago(<?php echo $socio_membresia; ?>)' id = 'tipo_pago_<?php echo $socio_membresia; ?>' >
						<option value = ''>Seleccione...</option>
						<option value = 'anual'>Anual</option>
						<option value = 'mensual'>Mensual</option>
					</select>
					
				</td>
				
				<td>
					<input type = 'text' onchange='ColocarAnio(<?php echo $socio_membresia; ?>);' class = 'form-control fechad' id = 'fechad_<?php echo $socio_membresia; ?>' placeholder = '' style = 'display:none;width:100px' />
					<input type = 'text'  id = 'fechad2_<?php echo $socio_membresia; ?>' placeholder = '' class = 'form-control fechad2' style = 'display:none;width:100px' />
				</td>
				
				<td>
					<input type = 'text' id = 'periodo_<?php echo $socio_membresia; ?>' placeholder = 'Peridodo de gracia'  />
				</td>
				
				
				<td>
					<input type = 'text' id = 'localidades_<?php echo $socio_membresia; ?>' placeholder = 'Ingrese Localidades' />
				</td>
				<td>
					<input type = 'text' id = 'valor_mensual_<?php echo $socio_membresia; ?>' placeholder = 'Ingrese Valor Mensual' />
				</td>
				<td>
					<input type = 'text' id = 'cantidad_<?php echo $socio_membresia; ?>' placeholder = '# Tickets Socio' />
				</td>
				<td>
					<input type = 'text' id = 'gratis_<?php echo $socio_membresia; ?>' placeholder = '# Tickets Gratis' />
				</td>
				<td>
					<input type = 'text' id = 'otros_<?php echo $socio_membresia; ?>' placeholder = 'Otros' value = '-'/>
				</td>
				<td>
					<input type = 'text' id = 'estado_<?php echo $socio_membresia; ?>' placeholder = '1'  style="width: 30px;text-align: center;" value = '1' disabled="disabled" readonly="readonly"/>
				</td>
				<td style = 'text-align:center;'>
					<button type="button" id = 'boton_membresia_<?php echo $socio_membresia?>_1' class="btn btn-success" onclick = 'configuraMembresia(<?php echo $socio_membresia?> , 1)'>
						<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
					</button>
				</td>
			</tr>
<?php
		while($rowM = mysql_fetch_array($resM)){
			if($rowM['estado'] == 1){
				$color = 'danger';
				$texto = 'glyphicon glyphicon-remove-circle';
			}else{
				$color = 'info';
				$texto = 'glyphicon glyphicon-ok-circle';
			}
			
?>
			<tr>
				<td>
					<input type = 'text' id = 'id_<?php echo $rowM['id']; ?>' value = '<?php echo $rowM['id']; ?>' style="width: 30px;text-align: center;" disabled="disabled" readonly="readonly" />
				</td>
				<td>
					<input type = 'text' value = '<?php echo $rowS['strNombreU']; ?>' disabled="disabled" readonly="readonly" />
					<input type = 'hidden' id = 'id_empresario_<?php echo $rowM['id']; ?>' value = '<?php echo $rowM['id_empresario']; ?>' />
				</td>
				<td>
					<input type = 'text' id = 'membresia_<?php echo $rowM['id']; ?>' value = '<?php echo $rowM['membresia']; ?>' />
				</td>
				
				
				<td>
					<select class = 'form-control' onchange = 'saberTipoPago(<?php echo $rowM['id']; ?>)' id = 'tipo_pago_<?php echo $rowM['id']; ?>' >
						<option value = ''>Seleccione...</option>
					<?php
						if($rowM['tipo_pago'] == 'anual' ){
							$displ1 = '';
							$displ2 = 'display:none;';
					?>
						<option value = 'anual' selected >Anual</option>
						<option value = 'mensual'>Mensual</option>
					<?php
						}elseif($rowM['tipo_pago'] == 'mensual' ){
							$displ1 = 'display:none;';
							$displ2 = '';
					?>
						<option value = 'anual'  >Anual</option>
						<option value = 'mensual' selected>Mensual</option>
					<?php
						}
					?>
					</select>
					
				</td>
				
				<td style = 'width:230px'>
					<input value = '<?php echo $rowM['meses_caduca'];?>' type = 'text' onchange='ColocarAnio(<?php echo $rowM['id']; ?>);' class = 'form-control fechad' id = 'fechad_<?php echo $rowM['id']; ?>' placeholder = '' style = '<?php echo $displ1;?>width:230px' />
					<input value = '<?php echo $rowM['meses_caduca'];?>' type = 'text'  id = 'fechad2_<?php echo $rowM['id']; ?>' placeholder = '' class = 'form-control fechad2' style = '<?php echo $displ2;?>width:230px' />
				</td>
				
				<td>
					<input value = '<?php echo $rowM['periodo'];?>' type = 'text' id = 'periodo_<?php echo $rowM['id']; ?>' placeholder = 'Peridodo de gracia'  />
				</td>
				
				
				
				<td>
					<input type = 'text' id = 'localidades_<?php echo $rowM['id']; ?>' value = '<?php echo $rowM['localidades']; ?>' />
				</td>
				<td>
					<input type = 'text' id = 'valor_mensual_<?php echo $rowM['id']; ?>' value = '<?php echo $rowM['valor_mensual']; ?>' />
				</td>
				<td>
					<input type = 'text' id = 'cantidad_<?php echo $rowM['id']; ?>' value = '<?php echo $rowM['cantidad']; ?>' />
				</td>
				
				<td>
					<input type = 'text' id = 'gratis_<?php echo $rowM['id']; ?>' value = '<?php echo $rowM['gratis']; ?>' />
				</td>
				<td>
					<input type = 'text' id = 'otros_<?php echo $rowM['id']; ?>' value = '<?php echo $rowM['otros']; ?>' />
				</td>
				<td>
					<input type = 'text' id = 'estado_<?php echo $rowM['id']; ?>' value = '<?php echo $rowM['estado']; ?>' style="width: 30px;text-align: center;"/>
				</td>
				<td>
					<table style = 'width:100%;'>
						<tr>
							<td>
								<button type="button" id = 'boton_membresia_<?php echo $socio_membresia?>_2' class="btn btn-warning" onclick = 'configuraMembresia(<?php echo $rowM['id']?> , 2 )'>
									<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
								</button>
							</td>
							<td>
								<button type="button" id = 'boton_membresia_<?php echo $socio_membresia?>_3' class="btn btn-<?php echo $color;?>" onclick = 'configuraMembresia(<?php echo $rowM['id']?> , 3)'>
									<span class="<?php echo $texto?>" aria-hidden="true"></span>
								</button>
							</td>
						</tr>
					</table>
				</td>
			</tr>
<?php
		}
	}else{
?>
			<tr style = 'background-color: #fff;color: #000'>
				<td >
					#
				</td>
				<td>
					<input type = 'text' value = '<?php echo $rowS['strNombreU']; ?>' disabled="disabled" readonly="readonly" />
					<input type = 'hidden' id = 'id_empresario_<?php echo $socio_membresia; ?>' value = '<?php echo $socio_membresia; ?>' />
				</td>
				<td>
					<input type = 'text' id = 'membresia_<?php echo $socio_membresia; ?>' placeholder = 'Ingrese Membresia'  />
				</td>
				
				<td>
					<select class = 'form-control' onchange = 'saberTipoPago(<?php echo $socio_membresia; ?>)' id = 'tipo_pago_<?php echo $socio_membresia; ?>' >
						<option value = ''>Seleccione...</option>
						<option value = 'anual'>Anual</option>
						<option value = 'mensual'>Mensual</option>
					</select>
					
				</td>
				
				<td>
					<input type = 'text' id = 'fechad_<?php echo $socio_membresia; ?>' placeholder = '' style = 'display:none;width:100px' />
					<input type = 'text' id = 'fechad2_<?php echo $socio_membresia; ?>' placeholder = '' style = 'display:none;width:100px' />
				</td>
				
				<td>
					<input type = 'text' id = 'periodo_<?php echo $socio_membresia; ?>' placeholder = 'Peridodo de gracia'  />
				</td>
				
				
				<td>
					<input type = 'text' id = 'localidades_<?php echo $socio_membresia; ?>' placeholder = 'Ingrese Localidades' />
				</td>
				<td>
					<input type = 'text' id = 'valor_mensual_<?php echo $socio_membresia; ?>' placeholder = 'Ingrese Valor Mensual' />
				</td>
				<td>
					<input type = 'text' id = 'cantidad_<?php echo $socio_membresia; ?>' placeholder = '# Tickets Socio' />
				</td>
				<td>
					<input type = 'text' id = 'gratis_<?php echo $socio_membresia; ?>' placeholder = '# Tickets Gratis' />
				</td>
				<td>
					<input type = 'text' id = 'otros_<?php echo $socio_membresia; ?>' placeholder = 'Otros' value = '-' />
				</td>
				<td>
					<input type = 'text' id = 'estado_<?php echo $socio_membresia; ?>' style="width: 30px;text-align: center;" placeholder = '1'  value = '1' disabled="disabled" readonly="readonly"/>
				</td>
				<td style = 'text-align:center;'>
					<button type="button" id = 'boton_membresia_<?php echo $socio_membresia?>_1' class="btn btn-success" onclick = 'configuraMembresia(<?php echo $socio_membresia?> , 1)'>
						<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
					</button>
				</td>
			</tr>
<?php
	}
?>
	<style>
		
		.ui-datepicker-month,.ui-datepicker-year{
			color: #000000;
		}
		.ui-widget-content{
			text-align: center;
		}
		.ui-datepicker-current,.ui-datepicker-close{
			color: #000000;
		}
	</style>
	<script>
		
		$('.fechad').datepicker( {
			changeMonth: true,
			changeYear: true,
			showButtonPanel: false,
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			dateFormat: 'yy MM',
			onClose: function(dateText, inst) {
				console.log("entra al close");
				
				var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				$(this).datepicker('setDate', new Date(year, month, 1));
			}
		});
		// $('input').addClass('form-control')
		
		
		$('.fechad2').datepicker( {
			dateFormat: 'yy-mm-dd'
		});
		
		$('.fechad').on('focus',function(){
			$('.ui-datepicker-calendar').css('display','none')
		})
		
		$('.fechad2').on('focus',function(){
			$('.ui-datepicker-calendar').css('display','inline')
		})
		
		function ColocarAnio(id){
			
			
			
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			
			var mesi=parseInt(month)+1;
			mesi=mesi.toString();
			if(mesi.length==1)
				mesi='0'+mesi;
			$('#fechad_'+id).val(year+' - '+mesi);
			
		}
		
		// function ColocarAnio2(id){
			// var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			// var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			
			// var mesi=parseInt(month)+1;
			// mesi=mesi.toString();
			// if(mesi.length==1)
				// mesi='0'+mesi;
			// $('#fechad_'+id).val(year+' - '+mesi);
			
		// }
	</script>