<input type="hidden" id="data" value="45" />
<div style="margin:10px -10px;">
<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<div style="background-color:#171A1B; padding-right:3%;padding-left: 2%"><br/><br/>
		<div class = 'row'>
			<div class = 'col-md-12'>
				<h3 style = 'padding-top: 10px;padding-bottom: 10px;padding-left: 10px;padding-right: 10px;background-color: #ED1568;color: #fff'>REIMPRESIONES DISTRIBUIDOR</h3>
			</div>
		</div>
		<div class = 'row'>
			<div class = 'col-md-2'></div>
			<div class = 'col-md-6' style = 'color:#fff;'>
				<select class = 'form-control' id = 'evento_distri_reimp' >
					<option value = ''>Seleccione un Evento Reporte Canjes</option>
					<?php
						// and costoenvioC > 0
						session_start();
						include 'conexion.php';
						$sql = 'select c.idConcierto  , u.strObsCreacion , d.conciertoDet , c.strEvento
								from Usuario as u , detalle_distribuidor as d , Concierto as c
								where idUsuario = "'.$_SESSION['iduser'].'" 
								and u.strObsCreacion = d.idDis_Det
								and d.conciertoDet = c.idConcierto 
								
								order by 1 DESC 
								';
						
						$res = mysql_query($sql) or die (mysql_error());
						while($row = mysql_fetch_array($res)){
					?>	
							<option value = '<?php echo $row['idConcierto'];?>' ><?php echo $row['strEvento'];?>  [<?php echo $row['idConcierto'];?>]</option>
					<?php
						}
					?>
				</select><br>
				
			</div>
			<div class = 'col-md-2' style = 'color:#fff;display:;'>
				
				
			</div>
			<div class = 'col-md-2'></div>
		</div>
		<center>
			<img src="imagenes/loading.gif" alt="load" id="imgifDistri" style="width:60px;display:none;" />
		</center>
		<div class = 'row' id='recibeReimpresionesDist'>
			
		</div>
		<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ingresarClaveImpresion_" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;' >
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
							&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;Ingrese la clave de Re-Impresión.
						</div>
						<input type = 'password' id = 'recibeClave' class = 'form-control'/>
						<center>
							<img src="http://ticketfacil.ec/imagenes/loading.gif" style="display:none;" id="loadBoleto_RE2" width="100px">
						</center>
						<input type = 'hidden' id = 'recibeidboleto' class = 'form-control'/>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="aceptarModal_clave()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		
		
		<div data-keyboard="false" data-backdrop="static" class="modal fade" id="ingresarClaveImpresion2_" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;' >
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" role="alert">
							<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
							&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;Ingrese la clave de Re-Impresión en lote.
						</div>
						<input type = 'password' id = 'recibeClave1' class = 'form-control'/>
						<center>
							<img src="http://ticketfacil.ec/imagenes/loading.gif" style="display:none;" id="loadBoleto_RE" width="100px">
						</center>
						<input type = 'hidden' id = 'recibeidboleto' class = 'form-control'/>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id = 'reimp_lote' onclick="reimp_lote()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
		
		
		<div data-keyboard="false" data-backdrop="static" class="modal fade" id="reimpresion_nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style = 'display:none;padding-right:2%;padding-left:2%' >
			<div class="modal-dialog" role="document" style = 'width:100%;' >
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
						<div class="alert alert-info" role="alert">
							<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
							&nbsp;&nbsp;<strong>Alerta !!!</strong>&nbsp;Se reimprimira cambiando si desea las especificaciones del (los) boleto(s).
						</div>
					</div>
					<div class="modal-body">
						<div class = 'row' >
							<div class = 'col-md-3'>
								Seleccione Evento
								<select class = 'form-control' id = 'evento_reimprime' >
									<option>Seleccione Evento</option>
									<?php
										session_start();
										include 'conexion.php';
										$sql = 'select c.idConcierto  , u.strObsCreacion , d.conciertoDet , c.strEvento
												from Usuario as u , detalle_distribuidor as d , Concierto as c
												where idUsuario = "'.$_SESSION['iduser'].'" 
												and u.strObsCreacion = d.idDis_Det
												and d.conciertoDet = c.idConcierto 
												and costoenvioC > 0
												order by 1 DESC 
												';
										
										$res = mysql_query($sql) or die (mysql_error());
										while($row = mysql_fetch_array($res)){
									?>	
											<option value = '<?php echo $row['idConcierto'];?>' ><?php echo $row['strEvento'];?>  [<?php echo $row['idConcierto'];?>]</option>
									<?php
										}
									?>
									
								</select>
							</div>
							<div class = 'col-md-3'>
								Seleccione Localidad a Cambiar
								<select class = 'form-control localidades' id = 'local_desde'>
									<option value = ''>Seleccione</option>
									
								</select>
							</div>
							<div class = 'col-md-2'>
								Seleccione Boleto Desde
								<input type = 'text' class = 'form-control'  placeholder = 'DESDE' id = 'desde' />
							</div>
							<div class = 'col-md-2'>
								Seleccione Boleto Hasta
								<input type = 'text' class = 'form-control'  placeholder = 'HASTA' id = 'hasta' />
							</div>
							<div class = 'col-md-3'>
								Seleccione Localidad Para
								<select class = 'form-control localidades' id = 'local_hasta' >
									<option value = ''>Seleccione</option>
								</select>
							</div>
							<div class = 'col-md-3'>
								Seleccione Descuentos
								<select class = 'form-control descuentos' id = 'descuentos' >
									<option value = ''>Seleccione</option>
								</select>
							</div>
							<div class = 'col-md-2'>
								<button type="button" class="btn btn-danger" onclick = 'cambiaBoleto()'>Grabar</button>
							</div>
						</div>
					</div>
					<div class="modal-footer" id = 'recibePruebas' >
						<!--<button type="button" class="btn btn-primary" onclick="reimp_lote()">Aceptar</button>-->
					</div>
				</div>
			</div>
		</div>
		
		
		
	</div>
</div>
<script type="text/javascript">
	function cambiaBoleto(){
		var local_desde = $('#local_desde').val();
		var desde = $('#desde').val();
		var hasta = $('#hasta').val();
		var local_hasta = $('#local_hasta').val();
		var evento = $('#evento_reimprime').val();
		var descuentos = $('#descuentos').val();
		var nomDesc = $('#descuentos option:selected').attr('nombre');
		var id_desc = $('#descuentos option:selected').attr('id_desc');
		
		
		
		if(local_desde == ''){
			alert('seleccione boleto inicio');
		}
		
		if(desde == ''){
			alert('ingrese localidad inicio');
		}
		
		if(hasta == ''){
			alert('ingrese boleto final');
		}
		
		if(local_hasta == ''){
			alert('seleccione localidad final');
		}
		
		if(descuentos == ''){
			alert('seleccione Descuento');
		}
		
		
		if(local_desde == '' || desde == '' || hasta == '' || local_hasta == '' || descuentos == ''){
			
		}else{
			$.post("subpages/cambiaBoleto.php",{ 
				local_desde : local_desde , desde : desde , hasta : hasta , local_hasta : local_hasta ,
				descuentos : descuentos , nomDesc : nomDesc , id_desc : id_desc , evento : evento
			}).done(function(data){
				$('#recibePruebas').html(data);
				// alert(data);	
				// window.location = '';
			});
		}
		
	}
	function muestra_modal(){
		$('#ingresarClaveImpresion2_').modal('show');
	}
	function selectAll(){
		if($('#chk_all').is(':checked')){
			$('.lotes').prop('checked',true);
		}else{
			$('.lotes').prop('checked',false);
		}
	}
	function reimp_lote(){
		var clave = $('#clave').val();//'1711629186';
		var recibeClave = $('#recibeClave1').val();
		if((clave != recibeClave)){
			alert('la clave es incorrecta');
			$('#recibeClave').val('');
		}
		if(recibeClave == ''){
			alert('ingrese la clave');
		}
		if((clave == recibeClave) && recibeClave != ''){
			var selected = '';    
			$('.lotes').each(function(){
				if (this.checked) {
					selected += $(this).val()+'@';
				}
			}); 
			var servicesFormatted = selected.substring(0, selected.length - 1);
			if (servicesFormatted != ''){
				$('#reimp_lote').attr("disabled", true);
				$('#loadBoleto_RE').css('display','block');
				alert('Has seleccionado: '+servicesFormatted);  
				$.post("subpages/reimprime_lote.php",{ 
					servicesFormatted : servicesFormatted
				}).done(function(data){
					$('#loadBoleto_RE').css('display','none');
					alert(data);	
					window.location = '';
				});
			} 
			
			else{
				alert('Debes seleccionar al menos una opción.');
				return false;
			}
		}else{
			
		}
				
	}
	$( document ).ready(function() {
		$("#local_desde").change(function(e){
			//$('#imgifDistri').fadeIn('slow');
			$('#recibePruebas').html('');
			var local_desde = $('#local_desde').val();
			var evento_reimprime = $('#evento_reimprime').val();
			
			$('#loadBoleto1').css('display','block');
			$.post('subpages/boletosPorLocalidad.php',{ 
				local_desde : local_desde , evento_reimprime : evento_reimprime
			}).done(function(data){
				$('#loadBoleto1').css('display','none');
				$('#recibePruebas').html(data);
				$('#recibePruebas').effect('highlight');
			});
		});
		
		console.log( "ready!" );
		$("#evento_distri_reimp").change(function(e){
			$('#imgifDistri').fadeIn('slow');
			var idconciertotrans = $('#evento_distri_reimp').val();
			
			if(idconciertotrans == ''){
				$('#recibeReimpresionesDist').html('');
			}else{
				$.post('Estadisticas/ajax/detalle_canjes.php',{ 
					idconciertotrans : idconciertotrans 
				}).done(function(data){
					$('#recibeReimpresionesDist').html(data);
					$('#imgifDistri').fadeOut('slow');
				});

			}
		});
		
		
		$("#evento_reimprime").change(function(e){
			//$('#imgifDistri').fadeIn('slow');
			var evento_reimprime = $('#evento_reimprime').val();
			
			if(evento_reimprime == ''){
				$('.localidades').html('');
			}else{
				$.post('subpages/localidadEvento.php',{ 
					evento_reimprime : evento_reimprime 
				}).done(function(data){
					$('.localidades').html(data);
					$('.localidades').effect('highlight');
				});

			}
		});
		
		
		$("#local_hasta").change(function(e){
			//$('#imgifDistri').fadeIn('slow');
			var local_hasta = $('#local_hasta').val();
			
			if(local_hasta == ''){
				$('.descuentos').html('');
			}else{
				$.post('subpages/descuentoLocalidad.php',{ 
					local_hasta : local_hasta 
				}).done(function(data){
					$('.descuentos').html(data);
					$('.descuentos').effect('highlight');
				});

			}
		});
	});
	function reimplrime_distribuidor(id){
		
			$('#ingresarClaveImpresion_').modal('show');
			$('#recibeidboleto').val(id);
			
	}
	
	function aceptarModal_clave(){
		var clave = $('#clave').val();//'1711629186';
		var recibeClave = $('#recibeClave').val();
		if((clave != recibeClave)){
			alert('la clave es incorrecta');
			$('#recibeClave').val('');
		}
		if(recibeClave == ''){
			alert('ingrese la clave');
		}
		if((clave == recibeClave) && recibeClave != ''){
			var id = $('#recibeidboleto').val();
			$.post("subpages/reimplrime_distribuidor.php",{ 
				id : id
			}).done(function(data){
				$('#load_blog_'+id).fadeOut('slow');
				alert(data);
				window.location = '';
			});
		}else{
			
		}
	}
</script>
