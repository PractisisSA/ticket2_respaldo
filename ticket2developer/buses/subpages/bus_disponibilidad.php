<?php
	session_start();
	if($_SESSION['saber_ida_vuelta'] != 0){
		echo "<input type = 'hidden' id = 'salida_vuelta' value = '".$_SESSION['salida_vuelta']."' />";
		echo "<input type = 'hidden' id = 'llegada_vuelta' value = '".$_SESSION['llegada_vuelta']."' />";
		echo "<input type = 'hidden' id = 'terminal_vuelta' value = '".$_SESSION['terminal_vuelta']."' />";
		echo "<input type = 'hidden' id = 'terminal_vuelta_salida' value = '".$_SESSION['terminal_vuelta_salida']."' />";
		echo "<input type = 'hidden' id = 'fecha_vuelta' value = '".$_SESSION['fecha_vuelta']."' />";
		echo "<input type = 'hidden' id = 'cooperativa_vuelta' value = '".$_SESSION['id_coop_vuelta']."' />";
		echo "<input type = 'hidden' id = 'saber_ida_vuelta' value = '".$_SESSION['saber_ida_vuelta']."' />";
		echo "<input type = 'hidden' id = 'normales' value = '".$_SESSION['normales']."' />";
		echo "<input type = 'hidden' id = 'especiales' value = '".$_SESSION['especiales']."' />";
	}
?>
	<script>
		function buscarRuta(){
			var salida = $('#salida_vuelta').val();
			var llegada = $('#llegada_vuelta').val();
			var terminal = $('#terminal_vuelta_salida').val();
			var terminal_llega = $('#terminal_vuelta').val();
			
			var id_coop = $('#cooperativa_vuelta').val();
			var fecha_salida = $('#fecha_vuelta').val();
			
			var normales = $('#normales').val();
			var especiales = $('#especiales').val();
			
			
			if(salida == '' || llegada == '' || fecha_salida == '' ){
				
			}else{
				// $('#loadBusqRuta').css('display','block');
				// var posisionForm = (($('#posSigui').position().top)+100);
				// console.log(posisionForm);
				// alert(posisionForm);
				//setTimeout(function(){
					
					$('#contenedorBus').html('<center><img src = "images/ajax-loader.gif"/></center>');
					$.post("ajax/buscarRuta_Vuelta.php",{ 
						salida : salida , llegada : llegada , terminal : terminal , id_coop : id_coop , fecha_salida : fecha_salida , terminal_llega , terminal_llega ,
						normales : normales , especiales : especiales
					}).done(function(data){
						//$('#loadBusqRuta').css('display','none');
						
						$('#contenedorBus').html(data);
						$('#contenedorBus').css('height','400px');
						$('#contenedorBus').css('overflow-y','scroll');
						$('#contenedorBus').css('padding-left','10px');
						// $( "html, body " ).animate({
							// scrollTop: posisionForm,
						// }, 1500, function() {
							
						// });
					});
				//}, 2000);
				
			}
			
		}
	</script>

<?php
	if($_SESSION['id_coop_vuelta'] != ''){
		$_SESSION['filtro'] = $filtro;
		$_SESSION['filtro2'] = $filtro2;
		$_SESSION['filtroEscala'] = $filtroEscala;
	}


	include 'enoc.php';
	$norm = $_REQUEST['n'];
	$esp = $_REQUEST['e'];
	$_SESSION['norm'] = $norm;
	$_SESSION['esp'] = $esp;
	if ( isset($_SESSION['carrito']) || isset($_POST['nombre'])){
		if(isset ($_SESSION['carrito'])){
			
			$compras=$_SESSION['carrito'];
			if(isset($_POST['nombre'])){
				$nombre=$_POST['nombre'];
				$precio=$_POST['precio'];
				$cantidad=$_POST['cantidad'];
				$product_id=$_POST['product_id'];
				$duplicado=-1;
				for($i=0;$i<=count($compras)-1;$i++){
					if($nombre==$compras[$i]['nombre']){
						$duplicado=$i;
					}
				}

				if($duplicado != -1){
					$cantidad_nueva = $compras[$duplicado]['cantidad'] + $cantidad;
						$compras[$duplicado]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad_nueva,"product_id"=>$product_id);
				}else {
						$compras[]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad,"product_id"=>$product_id);
				}
			}
		}else{
			$nombre=$_POST['nombre'];
			$precio=$_POST['precio'];
			$cantidad=$_POST['cantidad'];
			$product_id=$_POST['product_id'];
			$compras[]=array("nombre"=>$nombre,"precio"=>$precio,"cantidad"=>$cantidad ,"product_id"=>$product_id);

		}
		$cuantoscarrito=$_SESSION['$cuantoscarrito']+$_POST['cantidad'];//contador
		if(isset($_POST['cantidadactualizada'])){
			$id=$_POST['id'];
			$contador_cant=$_POST['cantidadactualizada'];
			if($contador_cant<1){
				$compras[$id]=NULL;
			}else{
				$compras[$id]['cantidad']=$contador_cant;
				}
		}
		if(isset($_POST['id2'])){
			$id=$_POST['id2'];
			$compras[$id]=NULL;
		}
	$_SESSION['carrito']=$compras;
	//print_r($_SESSION['carrito']);
	$_SESSION['$cuantoscarrito']=$cuantoscarrito;//asigna contador
	$carro = count($_SESSION['carrito']);
	}
?>
	<style>
		.asientosBus{
			webkit-transform: rotate(-90deg); 	
			-moz-transform: rotate(-90deg); 	
			rotation: -90deg; 	
			filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=-1);
			-webkit-perspective;
			position: relative; 
			top:-160px;
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
	<div class='row' style = 'background-image:url(images/busFondo.jpg);background-size:100% 100%;background-repeat: no-repeat;'>
		<div class = 'col-md-8'>
			<br/><br/>
			<div class="titulo">
				<div class="row">
					<div class="col-xs-1" style = 'height: 45px'>
						<table width='100%' height='100%' >
							<tr>
								<td valign='middle' align = 'center' class = 'flechas_direccion'>
									<
								</td> 
							</tr>
						</table>
					</div>
					<div class="col-xs-9" >
						ELIJE TUS ASIENTOS
					</div>
					<div class="col-xs-1" style = 'height: 45px'>
						<table width='100%' height='100%' >
							<tr>
								<td valign='middle' align = 'center' class = 'flechas_direccion'>
									&gt;
								</td> 
							</tr>
						</table>
						
					</div>
				</div>
			</div><br/><br/>
			<table width='100%'>
				<tr>
					<td width='48%' style = 'padding-right:2%;'>
						<div class="form-group has-success has-feedback">
							<div class="input-group">
								<span class="input-group-addon" style='background: #0386A4;color: #fff;font-weight: 300;font-size:10px;'>ASIENTOS <br/>NORMALES</span>
								<select class="form-control input-md"  style="text-transform: uppercase;border:none;" id='normales'>
									<option value = '0' >Seleccione</option>
								<?php
									for($i=1;$i<=6;$i++){
										if($i == $norm){
											$selected = 'selected';
										}else{
											$selected = '';
										}
								?>
									<option value = '<?php echo $i;?>' <?php echo $selected;?>><?php echo $i;?></option>
								<?php
									}
								?>
									
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
								<?php
									for($j=1;$j<=6;$j++){
										if($j == $esp){
											$selected1 = 'selected';
										}else{
											$selected1 = '';
										}
								?>
									<option value = '<?php echo $j;?>' <?php echo $selected1;?>><?php echo $j;?></option>
								<?php
									}
								?>
								</select>
							</div>
						</div>
						
					</td>
					<td colspan = '2'>
						<div class="form-group has-success has-feedback">
							<div class="input-group">
								<span class="input-group-addon" style='background:#0386A4;color:#fff;font-weight:bold;'>TOTAL</span>
								<input class="form-control input-md"  style="text-transform: uppercase;border:none;width:150px;text-align:center" disabled readonly id = 'total_boletos' placeholder = 'TOTAL'	value='<?php echo ($norm+$esp);?>'/>
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
					<td></td>
				</tr>
				
			</table>
			<div class='row'>
				<div class = 'col-md-12' id='contenedorBus'>
					<table width='100%' style = 'background-color: rgba(35, 31, 32, 0.7);'>
						<tr>
							<td align="center" style = 'padding:5px'>
								<table width = '100%' height = '100%' align = 'center'>
									<tr>
										<td width="30%" align="center">
											<div style='background-color:#2CABE1;border: 1px solid #2CABE1;color:#2CABE1;border-radius: 5px;height: 40px;padding-left: 10px;padding-right: 10px;text-align: center;width: 40px;'></div>
										</td>
										<td>
											<span style='font-size:1.2em;color:#fff;'>
												Tu Asiento
											</span>
										</td>
									</tr>
								</table>
							</td>
							<td align="center">
								<table width = '100%' height = '100%' align = 'center'>
									<tr>
										<td width="30%" align="center">
											<div style='background-color:#fff;border: 1px solid #000;color:#fff;border-radius: 5px;height: 40px;padding-left: 10px;padding-right: 10px;text-align: center;width: 40px;'></div>
										</td>
										<td>
											<span style='font-size:1.2em;color:#fff;'>
												Libre
											</span>
										</td>
									</tr>
								</table>
							</td>
							<td align="center">
								<table width = '100%' height = '100%' align = 'center'>
									<tr>
										<td width="30%" align="center">
											<div style='background-color:#F5EA14;border: 1px solid #F5EA14;color:#F5EA14;border-radius: 5px;height: 40px;padding-left: 10px;padding-right: 10px;text-align: center;width: 40px;'></div>
										</td>
										<td>
											<span style='font-size:1.2em;color:#fff;'>
												Reservado
											</span>
										</td>
									</tr>
								</table>
								
							</td>
							<td align="center">
								
							</td>
							<td align="center">
								<table width = '100%' height = '100%' align = 'center'>
									<tr>
										<td width="30%" align="center">
											<div style='background-color:#D43F3A;border: 1px solid #D43F3A;color:#D43F3A;border-radius: 5px;height: 40px;padding-left: 10px;padding-right: 10px;text-align: center;width: 40px;'></div>
										</td>
										<td>
											<span style='font-size:1.2em;color:#fff;'>
												Pagado
											</span>
										</td>
									</tr>
								</table>
							</td>
							<td align="center">
								<table width = '100%' height = '100%' align = 'center'>
									<tr>
										<td width="30%" align="center">
											<div style='background-color:#676767;border: 1px solid #676767;color:#676767;border-radius: 5px;height: 40px;padding-left: 10px;padding-right: 10px;text-align: center;width: 40px;'></div>
										</td>
										<td>
											<span style='font-size:1.2em;color:#fff;'>
												No Disponible
											</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					
					<table  align='center' id = 'asientosBus' class = 'asientosBus'>
						<tr>
							<td colspan = '5'>
								<img src = 'images/trompa2.png'/>
							</td>
						</tr>
					<?php
						$id = $_REQUEST['id'];
						$sqlR = 'select * from ruta where id = "'.$id.'"';
						$resR = mysql_query($sqlR) or die (mysql_error());
						$rowR = mysql_fetch_array($resR);
						
						$_SESSION['id_ruta'] = $id;
						//echo $_SESSION['id_ruta'];
						$id_bus = $_REQUEST['id_bus'];
						$fecha = $_REQUEST['fecha'];
						$id_coop = $_REQUEST['id_coop'];
						$sql = 'select * from bus where id = "'.$id_bus.'" ';
						$res = mysql_query($sql) or die (mysql_error());
						$i=0;
						$row = mysql_fetch_array($res);
						for($j=1;$j<=$row['asientos'];$j++){
							$precio = $rowR['precio'];
							$sql2 = 'select * from ocupadas where id_ruta = '.$id.' and asiento = '.$j.' and fecha_salida = "'.$fecha.'"   ';
							//echo $sql2."<br/>";
							//exit;
							$res2 = mysql_query($sql2) or die (mysql_error());
							if(mysql_num_rows($res2)>0){
								$row2 = mysql_fetch_array($res2);
								if($row2['estado'] == 'r'){
									$background = 'background-color:#F5EA14;';
									$color = 'color:#0E8CCC;';
									$botonEnvio = '';
									$border = 'border: 1px solid #0E8CCC;';
								}elseif($row2['estado'] == 'p'){
									$background = 'background-color:#d43f3a;';
									$color = 'color:#000;';
									$botonEnvio = '';
									$border = 'border: 1px solid #d43f3a;';
								}
								elseif($row2['estado'] == 's'){
									$background = 'background-color:#2CABE1;';
									$color = 'color:#000;';
									$botonEnvio = 'onclick="quitaOcupadas('.$row2['id'].' , '.$id.' , '.$id_bus.' , '.$j.' )"';
									$border = 'border: 1px solid #2CABE1;';
								}
								
							}else{
								$background = 'background-color:#F2F2F2;';
								$botonEnvio = 'onclick="enviaOcupadas('.$id.', '.$j.' , '.$id_bus.' , \''.$fecha.'\' , '.$precio.')"';
								$color = 'color:#0E8CCC;';
								$border = 'border: 1px solid #F4F5F5;';
							}
							
							if($i == 0){
								echo '<tr>';
								$borde = 'border-bottom:1px solid #666699;border-right:1px solid #666699;';
							}
							if($i == 2){
								echo '
									<td width="30px" rowspan ="" align="center" posicion = "'.$i.'" > 
										::
										::
									</td>
								';
							}
							echo '
									<td align="center" posicion = "'.$i.'" style="'.$background.'"> ';
						?>
						
										<div  <?php echo $botonEnvio;?> style="cursor:pointer;background-image: url(asi2.png);background-repeat: no-repeat;<?php echo $border;?>border-radius: 5px;height: 40px;padding-left: 10px;padding-right: 10px;text-align: center;width: 40px;border: 1px solid; #000">
											<table width="100%" height="100%">
												<tr>
													<td valign="middle" align="center" style="<?php echo $color;?>font-weight:bold;webkit-transform: rotate(90deg);-moz-transform: rotate(90deg);rotation: 90deg;filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=1);">
														<?php echo $j;?>
													</td>
												</tr>
											</table>
										</div>
						<?php
								echo'</td>
								';
							if($i == 3){
								echo '</tr>';
								$i = 0;
							}
							else{
							$i++;
							}
						}
					?>
						<tr>
							<td colspan = '5'>
								<img src = 'images/atras.png'/>
							</td>
						</tr>
					</table>
					<br>
					<div id = 'recibeRuta_regreso' style = 'position: relative; top: -300px'></div>
				</div>
				
			</div>
		</div>
		<div class = 'col-md-3' style='margin:0;padding:0;'>
			<div class = 'titulo2'>
				<table width = '100%'>
					<tr>
					<td valign = 'top' style = 'padding-right:10px' >
						<img src = 'images/trianguloFuxia.png'/>
					</td>
					<td valign = 'top'>
						<p style = 'color:#fff;font-family:Helvetica;font-size:15pt;font-weight:300;'>
							Selecciona la 
							ubicación
							y cantidad de asientos
							que necesitas
						</p>
					</td>
					</tr>
				</table>
				
				<hr/>
				<div class = 'row'>
					<?php
					//	echo $_SESSION['saber_ida_vuelta'];
						if($_SESSION['saber_ida_vuelta']!=0){
							$colXs = '11';
							$displayXs = 'display:block;';
							$borderXs = 'border-right: 2px solid #000;';
						}else{
							$colXs = '6';
							$displayXs = 'display:none;';
							$borderXs = '';
						}
					?>
					<div class = 'col-xs-<?php echo $colXs;?>'>
						<table width = '100%' height = '120px' style = 'background-color:#F4F5F5;color:#231F20;font-family:helvetica'>
							<tr>
								<td valign = 'middle' align = 'center'>
									<span style = 'color:#28A9E0;font-size:1rem;' >
										Viaje Ida
									</span><br>
								</td>
								<td valign = 'middle' align = 'center' style = '<?php echo $displayXs;?>'>
									<span style = 'color:#28A9E0;font-size:1rem;' >
										Viaje Regreso
									</span><br>
								</td>
							</tr>
							<tr>
								<td valign = 'middle' align = 'center' style = 'font-size:8.5rem;<?php echo $borderXs;?>' width = '50%'>
									<?php 
										$suma_Ida_Vuelta = 0;
										$compras=$_SESSION['carrito'];
										$cantidadCarrito=0;
										for($i=0;$i<=count($compras)-1;$i++){
											$cantidadCarrito += $compras[$i]['cantidad'];
										}
										
										
										$compras_regreso=$_SESSION['carrito_regreso'];
										$cantidadCarrito_regreso=0;
										for($i=0;$i<=count($compras_regreso)-1;$i++){
											$cantidadCarrito_regreso += $compras_regreso[$i]['cantidad'];
										}
										//echo $cantidadCarrito."<<>>".$cantidadCarrito_regreso;
										$suma_Ida_Vuelta = ($cantidadCarrito + $cantidadCarrito_regreso);
										echo $cantidadCarrito;
									?>
								</td>
								<td valign = 'middle' align = 'center' style = 'font-size:8.5rem;<?php echo $displayXs;?>'>
									
									<?php echo $cantidadCarrito_regreso;?>
								</td>
							</tr>
							<tr>
								<td style = 'font-size:1rem;color:#28A9E0;border-right:2px solid #000;padding-right: 5px' valign = 'middle' align = 'center'>
									<?php
										$j=0;
										$numerodefilas = (count($compras));
										for($i=0;$i<=count($compras)-1;$i++){
											$j++;
											if ($j<$numerodefilas){
												$txt = '-';
											}else{
												$txt = "";
											}
											echo "".$compras[$i]['nombre'].$txt."";
										}
										
									?>
								</td>
								<td style = 'paddin-left:5px;font-size:1rem;color:#28A9E0;<?php echo $displayXs;?>' valign = 'middle' align = 'center'>
									<?php
										$k=0;
										$numerodefilas2 = (count($compras_regreso));
										for($i=0;$i<=count($compras_regreso)-1;$i++){
											$k++;
											if ($k<$numerodefilas2){
												$txt = '-';
											}else{
												$txt = "";
											}
											echo "".$compras_regreso[$i]['nombre'].$txt."";
										}
										
									?>
								</td>
							</tr>
						</table>
					</div>
				</div>
				
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
			<?php
				if($_SESSION['saber_ida_vuelta'] != 0){
			?>
				<img src = 'images/siguiente.png' style = 'margin-left:-35px;cursor:pointer;' onclick = 'buscarRuta()'/>
				<span style = 'color:#fff;font-size:12px;'>Por favor seleccione el bus para su viaje de retorno</span>
			<?php
				}else{
			?>
				<img src = 'images/siguiente.png' style = 'margin-left:-35px;cursor:pointer;' onclick = 'paso3()' />
			<?php
				}
			?>
			</div>
		</div>
	</div>


<script> 
	function paso3(){
		window.location = "?page=bus_paso_3";
	}
	$(document).ready(function() {	
		console.log('espartanos');
		$( "#normales" ).change(function() {
			sumarBoletos();
		});
		$( "#especiales" ).change(function() {
			sumarBoletos();
		});
		
		// setTimeout(function(){
			// location.reload();
		// }, 2000);
	});	
	function sumarBoletos(){
		console.log('sumando');
		var normales = $('#normales').val();
		var especiales = $('#especiales').val();
		
		var total_boletos = (parseInt(normales)+parseInt(especiales));
		$('#total_boletos').val(total_boletos);
	}
	function verPagoFinal(){
		var id_coop = <?php echo $id_coop;?>;
		window.location = 'pagar.php?id_coop='+id_coop;
	}
	function quitaOcupadas(id_ocupadas , id , id_bus , asiento){
		$.post("ajax/quitaAsientos.php",{ 
			id_ocupadas : id_ocupadas , id : id , id_bus : id_bus , asiento : asiento
		}).done(function(data){
			window.location = '';
		});
	}
	function enviaOcupadas(id_horario , asiento , id_bus , fecha , precio){
		//var posisionForm = $(this).position().top;
		var cantidad = 1;
		var nombre = asiento;
		var product_id = asiento;
		var tipo_destino = 'Ida';
		$.post("ajax/asignaAsientos.php",{ 
			id_horario : id_horario , asiento : asiento , id_bus : id_bus , fecha : fecha, product_id : product_id , 
			cantidad : cantidad , nombre : nombre , precio : precio , tipo_destino : tipo_destino
		}).done(function(data){
			location.reload();
			
			// $('#contenedorBus').html(data);
			// $("#recibeFactura").load('ajax/creaFactura.php');
			// $.post("ajax/creaFactura.php",{ 
				// product_id : product_id , cantidad : cantidad , nombre : nombre , precio : precio
			// }).done(function(data){
				// $("#recibeFactura").load('ajax/creaFactura.php');
			// });
		});
		
	}
	
	
	function enviaBus(id){
		alert(id);
	}
</script>

</body>
</html>
