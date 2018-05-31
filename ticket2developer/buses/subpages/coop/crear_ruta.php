	<?php
		session_start();
		$limite = $_SESSION['limite'];
		echo $_SESSION['iduser'];
		include 'enoc.php';
		$sql = 'select * from cooperativa where id_usu = "'.$_SESSION['iduser'].'" ';
		$res = mysql_query($sql) or die (mysql_error());
		$row = mysql_fetch_array($res);
		
		$sqlB = 'select * from bus where id_coop = "'.$row['id'].'" ';
		$resB = mysql_query($sqlB) or die (mysql_error());
		
		
	?>
	
	<style>
		.asientosBus{
			webkit-transform: rotate(-90deg); 	
			-moz-transform: rotate(-90deg); 	
			rotation: -90deg; 	
			filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=-1);
			-webkit-perspective;
			position: relative; 
			top:-150px;
			background-color: #F2F2F2;
			border-radius: 20px
		}
		
		@media only screen and (orientation:portrait){
            .asientosBus {  
                  -webkit-transform: rotate(-90deg);
                  -moz-transform: rotate(-90deg);
                  -o-transform: rotate(-90deg);
                  -ms-transform: rotate(-90deg);
                  transform: rotate(-90deg);
				  
                 }
 
         }
         @media only screen and (orientation:landscape){
            .asientosBus {  
                   -webkit-transform: rotate(-90deg);
                  -moz-transform: rotate(-90deg);
                  -o-transform: rotate(-90deg);
                  -ms-transform: rotate(-90deg);
                  transform: rotate(-90deg);
				  
                 }
         }
	</style>
	<input type="hidden" id="data" value="12" />
<div style="margin:10px -10px;"> 
<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<div style="background-color:#171A1B; padding-right:3%;padding-left: 2%"><br/><br/>
		<div style = 'text-align:left;padding-top:10px;padding-bottom:10px;padding-left:20px;background-color:#ed1568;width:90%;' >
			<h3 style = 'margin:0px;padding:0px;color:#fff;'>Crear Rutas de Buses Coop. : <?php echo $row['nom'];?> </h3>
		</div>
		<div class ='row'>
			<div class = 'col-md-1' ></div>
			<div class = 'col-md-12'>
				<table  align='center' class = 'table' style = 'color:#fff;'>
					<tr>
						<td>
							BUS
							<select class = 'form-control' id = 'bus_cooperativa'>
								<option value = '' >Seleccione ...</option>
						<?php
							while($rowB = mysql_fetch_array($resB)){
						?>
								<option value = '<?php echo $rowB['codigo'];?>'><?php echo $rowB['codigo'];?></option>
						<?php
							}
						?>
							</select>
						</td>
						<td>
							SALIDA
							<select class = 'form-control' id = 'ciudadSalida'>
								<option value = '' >Seleccione ...</option>
						<?php
							$sqlC = 'select * from ciudades order by nom asc';
							$resC = mysql_query($sqlC) or die (mysql_error());
							while($rowC = mysql_fetch_array($resC)){
						?>
								<option value = '<?php echo $rowC['id']."|".$rowC['nom'];?>'><?php echo $rowC['nom'];?></option>
						<?php
							}
						?>
							</select>
						</td>
						<td>
							DESTINO F
							<select class = 'form-control' id = 'ciudadDestino'>
								<option value = '' >Seleccione ...</option>
						<?php
							$sqlC1 = 'select * from ciudades order by nom asc';
							$resC1 = mysql_query($sqlC1) or die (mysql_error());
							while($rowC1 = mysql_fetch_array($resC1)){
						?>
								<option value = '<?php echo $rowC1['id']."|".$rowC1['nom'];?>'><?php echo $rowC1['nom'];?></option>
						<?php
							}
						?>
							</select>
						</td>
						<td>
							ESCALAS
							<select class = 'form-control' id = 'escalas'>
								<option value = '' >Seleccione ...</option>
						<?php
							$sqlC2 = 'select * from ciudades order by nom asc';
							$resC2 = mysql_query($sqlC2) or die (mysql_error());
							while($rowC2 = mysql_fetch_array($resC2)){
						?>
								<option value = '<?php echo $rowC2['id'];?>'><?php echo $rowC2['nom'];?></option>
						<?php
							}
						?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan = '4' style = 'text-align:center;vertical-align:middle !important;'>
							OPCIONES<br>
							<button type="button" class="btn btn-danger" onclick = 'generar()'>GENERAR</button>
						</td>
					</tr>
					<tr>
						<td id = 'asignaEscalas' colspan = '4'></td>
					</tr>
				</table>
			</div>
			<div class = 'col-md-1' ></div>
			<div class = 'col-md-12' id = 'recibeRutas'></div>
		</div>
	</div>
</div>
	<script>
		
		function generar(){
			var ciudadSalida = $('#ciudadSalida').val();
			var ciudadDestino = $('#ciudadDestino').val();
			var acumulaCiudades = '';
			
			var nombres_escalas = '';

			$('.ciudadEScala').each(function() {
				nombres_escalas += $(this).val() + '@';
			});
			//alert(nombres_escalas);
			var esc = ciudadSalida+'@'+nombres_escalas+ciudadDestino;
			
			$.post("subpages/coop/asigna_ruta.php",{ 
				esc : esc , ciudadSalida : ciudadSalida , ciudadDestino : ciudadDestino
			}).done(function(data){
				$('#recibeRutas').html(data)
			});
			
		}
		$( document ).ready(function() {
			console.log( "ready!" );
			$( "#escalas" ).change(function() {	
				var escalas_id = $('#escalas').val();
				if(escalas_id != ''){
					var escalas = $('#escalas option:selected').text();
					$('#asignaEscalas').append('\
												<div id = "contieneEscala_'+escalas_id+'" style = "border:1px solid #fff;border-collapse: separate;border-spacing: 2px 1px;padding-left: 5px;padding-right: 5px;width: 150px;float:left;">\
													'+escalas+' \
													<span id = "elimina" onclick = "eliminaEscala('+escalas_id+')" style = "float:right;color:red;font-size:12px;cursor:pointer;margin-top:-8px;position: relative; z-index: 200;border-radius: 100%;background-color: #fff;padding-left:5px;padding-right: 5px;margin-right: -8px">\
														X\
													</span>\
													<input type = "text" id = "'+escalas_id+'" style = "width:100px;color:#000;" class = "ciudadEScala" value = "'+escalas_id+'|'+escalas+'" />\
												</div>\
												');
					$("#escalas option:selected").index();
				}
			});
		});
		function eliminaEscala(id){
			$('#contieneEscala_'+id).remove();
		}
	</script>