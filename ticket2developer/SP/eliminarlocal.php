<?php 
	//include("controlusuarios/seguridadSA.php");
	
	$gbd = new DBConn();
	
	echo '<input type="hidden" id="data" value="3" />';
	$id = $_GET['id'];
	echo '<input type="hidden" id="ids" value="'.$id.'" />';
	$selectevento = "SELECT strEvento FROM Concierto WHERE idConcierto = ?";
	$stmtevento = $gbd -> prepare($selectevento);
	$stmtevento -> execute(array($id));
	$rowevento = $stmtevento -> fetch(PDO::FETCH_ASSOC);
	$select = "SELECT * FROM Localidad WHERE idConc = ?";
	$stmtselect = $gbd -> prepare($select);
	$stmtselect -> execute(array($id));
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; font-size:22px;width: 100%;padding-top: 20px;padding-bottom: 20px;padding-left: 10px">
				Localidades de <strong><?php echo $rowevento['strEvento'];?></strong>
				<button type="button" class="btn btn-warning" onclick = "$('#ver_asigna_macro').modal('show')" >Asignar Macro Localidad</button>
			</div>
			<div style="">
				<table class = 'table' style = 'color:#fff;' >
					<tr >
						<td style = 'text-align:center;'>
							<strong>Localidad</strong>	
						</td>
						<td style = 'text-align:center;'>
							<strong>Precio</strong>
						</td>
						<td style = 'text-align:center;'>
							<strong>Capacidad</strong>
						</td>
						<td style = 'text-align:center;'>
							<strong>Estado</strong>
						</td>
						<td style = 'text-align:center;'>
							<strong>Web / Pventa</strong>
						</td>
						<td style = 'text-align:center;'>
							<strong>Gratuidad</strong>
						</td>
						<td style = 'text-align:center;'>
							<strong>codigos de barra</strong>
						</td>
					</tr>
					<?php 
						include 'conexion.php';
						
						while($row = $stmtselect -> fetch(PDO::FETCH_ASSOC)){?>
					<tr style="text-align:center;" class = 'descuentos_global' numero_descuento = '<?php echo $row['idLocalidad'];?>'>
						<td>
							<?php echo $row['strDescripcionL'];?>
						</td>
						<td>
							<?php echo $row['doublePrecioL'];?>
						</td>
						<td>
							<?php echo $row['strCapacidadL'];?>
						</td>
						<td <?php if($row['strEstadoL'] == 'I'){echo 'style="background:#16F40B; color:#000;"';}?>>
							<?php
								if ($row['strEstadoL'] == 'A'){
									echo 'Activo';
								}else{
									echo 'Inactivo';
								}
								
								$vistaWeb = $row['createbyL'];
								$vistaPV = $row['fechaCreacionL'];
								
								if($vistaWeb == 1){
									$checked = 'checked';
								}else{
									$checked = '';
								}
								
								if($vistaPV == 1){
									$checked2 = 'checked';
								}else{
									$checked2 = '';
								}
								
								
								if($row['gratuidad'] == 1){
									$checked3 = 'checked';
								}else{
									$checked3 = '';
								}
								
								$sql1 = 'select count(id) as cuantos from codigo_barras WHERE `id_loc` = "'.$row['idLocalidad'].'" ';
								$res1 = mysql_query($sql1) or die (mysql_error());
								$row1 = mysql_fetch_array($res1);
								
								
								$sqlB = 'select count(1) as cuantosB from Boleto WHERE `idLocB` = "'.$row['idLocalidad'].'" ';
								$resB = mysql_query($sqlB) or die (mysql_error());
								$rowB = mysql_fetch_array($resB);
								
								if($row1['cuantos']>0){
									$txt='Actualizar<br>Codigos de Barra';
									$btn = 'warning';
									$ident = 1;
									$cuantos = $row1['cuantos'];
								}else{
									$txt='&nbsp;&nbsp;Grabar&nbsp;&nbsp;<br>Codigos de Barra';
									$btn = 'primary';
									$ident = 0;
									$cuantos = 0;
								}
							?>
						</td>
						<td>
							<table width = '100%'>
								<tr>
									<td>
										<input type = 'checkbox' id = 'web_<?php echo $row['idLocalidad'];?>' <?php echo $checked;?>/>
									</td>
									<td>
										<input type = 'checkbox' id = 'pv_<?php echo $row['idLocalidad'];?>' <?php echo $checked2;?>/>
									</td>
								</tr>
							</table>
						</td>
						<td>
							<input type = 'checkbox' id = 'estadoLocGrat_<?php echo $row['idLocalidad'];?>' <?php echo $checked3;?>/>
						</td>
						<td >
							<center>
								Asignados    : <?php echo $cuantos;?><br>
								Vendidos     : <?php echo $rowB['cuantosB'];?><br>
								Disponibles  : <?php echo ($cuantos - $rowB['cuantosB']);?><br>
								<input class = 'form-control' type = 'text' id = 'cod_bar_<?php echo $row['idLocalidad'];?>' value = '<?php echo $cuantos;?>' style = 'width:138px;color:#000;text-align:center;' />
								<input class = 'form-control' type = 'hidden' id = 'vendidos_<?php echo $row['idLocalidad'];?>' value = '<?php echo $rowB['cuantosB'];?>' style = 'width:138px;color:#000;text-align:center;' />
								<button id = 'boton_local_<?php echo $row['idLocalidad'];?>' type="button" class="btn btn-<?php echo $btn;?>" onclick="enviar_cod_barras('<?php echo $row['idLocalidad']?>' , <?php echo $ident;?> , <?php echo $id;?> , <?php echo $row['strCapacidadL'];?> , <?php echo $cuantos;?>)"><?php echo $txt;?></button>
							</center>
						</td>
					</tr>
					<?php }?>
					<tr>
						<td colspan = '8'>
							<center><button type="button" class="btn btn-warning" id = 'grabarTodos' onclick = 'grabarTodos()'>GRABAR VISUALIZACIONES PV/WEB</button></center>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="text-align:center; margin:20px; padding:20px 0;">
				<!--<button type="button" class="btndegradate" id="cancel" onclick="cancel()">CANCELAR</button>-->
			</div>
		</div>
	</div>
</div>
	
	<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ver_asigna_macro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
		<div class="modal-dialog modal-lg" role="document" >
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
					<div class="alert alert-info" role="alert">
						<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
						&nbsp;&nbsp;<strong>ASIGNACION DE MACRO LOCALIDAD EJ:(GENERAL NORTE)</strong>&nbsp;
					</div>
				</div>
				<div class="modal-body">
					<table class = 'table'>
						<tr>
							<td>
								Localidad
							</td>
							<td>
								Nombre Macro
							</td>
						</tr>
					<?php
						include 'conexion.php';
						$sqlL = 'select * from Localidad where idConc = "'.$id.'" ';
						$resL = mysql_query($sqlL) or die (mysql_error());
						while($rowL = mysql_fetch_array($resL)){
							if($rowL['macro_localidad'] == ''){
								$txt = '';
							}else{
								$txt = $rowL['macro_localidad'];
							}
							
					?>
						<tr>
							<td>
								<?php echo $rowL['strDescripcionL'];?>
							</td>
							<td>
								<input value = '<?php echo $txt;?>' style = 'text-transform:uppercase;' numero_localidad = '<?php echo $rowL['idLocalidad'];?>' class = 'form-control localidades_macros' type = 'text'  placeholder = 'Ingrese Macro Localidad para : <?php echo $rowL['strDescripcionL']; ?>'/>
							</td>
						</tr>
					<?php
						}
					?>
						<tr>
							<td colspan = '2' align = 'center' >
								<button type="button" id = 'grabarMacros_' class="btn btn-success" onclick = 'grabarMacros();'>Grabar</button>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer" id = 'data' >
					<div id = 'recibe_respuesta'></div>
				</div>
			</div>
		</div>
	</div>
<script>
	function grabarMacros(){
		var servi = ''
		$('#grabarMacros_').html('Espere!!!');
		$('#grabarMacros_').attr('disabled',true);
		
		$('.localidades_macros').each(function(){
			var localidades_macros = $(this).val();
			var numero_localidad = $(this).attr('numero_localidad');
			if(localidades_macros == ''){
				alert('debe poner el nombre ');
			}else{
				servi += localidades_macros +'@'+ numero_localidad + '|';
			}
		});
		var serviform = servi.substring(0,servi.length - 1);
		// alert(serviform);
		$.post("spadmin/grabaMacro.php",{ 
			serviform : serviform
		}).done(function(data){
			alert(data);
			$('#grabarMacros_').html('Grabar');
			$('#grabarMacros_').attr('disabled',false);
		});
	}
	function enviar_cod_barras(idLoc , ident , idCon , capac , cuantos){
		var cod_bar = $('#cod_bar_'+idLoc).val();
		var vendidos = $('#vendidos_'+idLoc).val();
		
		if(cod_bar == '' || cod_bar == 0){
			alert('Debe ingresar la cantidad de codigos se recomeienda : ' + capac);
			//$('#cod_bar_'+idLoc).val(capac);
		}else{
			if(cod_bar < cuantos){
				// alert (cod_bar +'<'+ cuantos)
				if(vendidos > 0){
					alert('Tiene ' + vendidos  +  '  tickets vendidos , no puede borrar solo aumentar' );
					var cod_bar1 = cod_bar;
					var estado = 1;
				}else{
					var cod_bar1 = cod_bar;
					var estado = 2;
				}
			}else{
				var cod_bar1 = (parseInt(cod_bar) - parseInt(cuantos));
				var estado = 1;
			}
			
			// alert('se enviara : '  + cod_bar1 + 'tickets' + estado);
			$('#boton_local_'+idLoc).html('espere!!!');
			$('#boton_local_'+idLoc).attr('disabled',true);
			$.post("spadmin/asignaCodigosLocalidad.php",{ 
				idLoc : idLoc , ident : ident , idCon : idCon , cod_bar1 : cod_bar1 , cuantos : cuantos , estado : estado
			}).done(function(data){
				alert(data);
				location.reload();
			});
		}
	}
	function grabarTodos(){
		var cuantos = $( ".descuentos_global" ).length;
		//alert(cuantos)
		var cc = 0;
		$('#grabarTodos').html('Espere Grabando !!!');
		$('#grabarTodos').attr('disabled',true);
		$( ".descuentos_global" ).each(function( index ) {
			cc++;
			// alert(cc + ' <<  >> ' + cuantos)
			var id = $(this).attr('numero_descuento');
			if($("#web_"+id).is(':checked')) {  
			var web = 1;
			} else {  
				var web = 0;
			}  
			
			if($("#pv_"+id).is(':checked')) {  
				var pv = 1;
			} else {  
				var pv = 0;
			} 
			
			if($("#estadoLocGrat_"+id).is(':checked')) {  
				var estadoLocGrat_ = 1;
			} else {  
				var estadoLocGrat_ = 0;
			}  
			
			$.post("SP/cambiaLocallidad.php",{ 
				web : web , pv : pv , id : id , estadoLocGrat_ : estadoLocGrat_
			}).done(function(data){
				//alert(data);
				//window.location = '';
			});
			if(cc == cuantos){
				setTimeout(function(){
					
					$('#grabarTodos').html('GRABAR VISUALIZACIONES PV/WEB');
					$('#grabarTodos').attr('disabled',false);
					alert('Localidades Modificadas con Éxito');
					location.reload();
				}, 2000);

			}else{
				
			}
		});
	}
	function enviar(id){
		if($("#web_"+id).is(':checked')) {  
			var web = 1;
		} else {  
			var web = 0;
		}  
		
		if($("#pv_"+id).is(':checked')) {  
			var pv = 1;
		} else {  
			var pv = 0;
		}  
		
		$.post("SP/cambiaLocallidad.php",{ 
			web : web , pv : pv , id : id
		}).done(function(data){
			alert(data);
			window.location = '';
		});
		//alert(web)
	}

	function cancel(){
		window.location.href = '?modulo=listaEvento';
	}
</script>