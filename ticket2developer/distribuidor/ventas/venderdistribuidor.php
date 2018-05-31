<?php 
	session_start();
	// echo "hola <<<>>> ".$_SESSION['valida_ocupadas']." [[[]]]  q hace <br><br>";
	//unset($_SESSION['carrito']);
	ini_set('memory_limit', '1024M');
	session_start();
	// echo $_SESSION['localidad']."<<>>";
	include("controlusuarios/seguridadDis.php");
	// echo $_SESSION['tipo_emp'];
	$gbd = new DBConn();
	
	$con = $_REQUEST['con'];
	$_SESSION['idConcVendido'] = $con;
	$query = "SELECT * FROM Concierto WHERE idConcierto = ?";
	$result = $gbd -> prepare($query);
	$result -> execute(array($con));
	echo '<input type="hidden" value="'.$con.'" id="idConcierto"/>';
	echo '<input type="hidden" id="data" value="1" />';
	
	$query1 = "SELECT strMailC FROM Cliente";
	$stmt1 = $gbd -> prepare($query1);
	$stmt1 -> execute();
	$tabla = '';
	while($row1 = $stmt1 -> fetch(PDO::FETCH_ASSOC)){
		$tabla .= '
		<div class="mailsbd">
			<input type="hidden" value="'.$row1['strMailC'].'" class="emails" />
		</div>';
	}
	echo $tabla;
?>
<script src="distribuidor/ventas/js/venderdis.js"></script>
<!--<script src="distribuidor/ventas/ajaxupload.js"></script>-->
<script>
	
</script>
<div style="margin:0px -10px;">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<!--<div style="background-color:#00ADEF; margin-right:40px; margin-top:20px; margin-left:-42px; position:relative;">
				<div class="row">
					<?php //$row = $result -> fetch(PDO::FETCH_ASSOC);
						//$img = $row['strImagen'];
						//$ruta = 'spadmin/';
						//$r = $ruta.$img;
					?>
					<div class="col-lg-5" style="color:#fff;">
						<p>
							<div style="margin:0px 60px 20px 80px; border:1px solid #fff; font-size:30px; padding: 20px">
								<strong><?php //echo $row['strEvento'];?></strong>
							</div>
						</p>
						<p>
							<div style="margin: 20px 80px; font-size:20px">
								<strong>Fecha: </strong><?php //echo $row['dateFecha'];?><br>
								<strong>Hora: </strong><?php //echo $row['timeHora'];?><br>
								<strong>Lugar: </strong><?php //echo $row['strLugar'];?>
							</div>
						</p>
					</div>
					<div class="col-lg-6">
						<img src="<?php //echo $r;?>" id="image" style="width:100%; overflow:hidden;"/>
					</div>
				</div>
				<div class="tra_video_concierto"></div>
				<div class="par_video_concierto"></div>
			</div>-->
			<div style="font-size:30px; color:#00ADEF; margin:15px;">
				<strong>Confirmar venta</strong><?php echo $_SESSION['iduser']; ?>
				<input type="text" id="clienteok" value="" style = 'background-color: #171A1B;border: none' readonly disabled />
			</div>
			<div style="background-color:#00ADEF; margin-left:40px; margin-top:20px; margin-right:-42px; position:relative;">
				<div id="searchCliente">
					<div class="row">
						<div class="col-lg-5">
							<h4 style="color:#fff;"><strong>Buscar Cliente:</strong></h4>
							<div class="input-group">
								<input value = '9999999999' type="text" class="inputlogin form-control cedula_cliente_venta_pv" placeholder="Documento de Identidad del Cliente" id="buscarcliente" aria-describedby="basic-addon2" autocomplete="off" onchange="ValidarDocumento()" maxlength="13" />
								<span class="input-group-addon" id="wait" style="display:none;" title="Buscando">
									<img src="imagenes/loading.gif" style="width:20px;" />
								</span>
								<span class="input-group-addon" id="buscar" style="cursor:pointer;" onclick="buscarCliente()" title="Buscar Cliente">
									<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								</span>
								<span class="input-group-addon quitarcliente" id="delete" style="display:none; cursor:pointer;" onclick="quitarCliente()" title="Eliminar Cliente">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</span>
							</div>
							<input type="hidden" id="cliente" name="cliente" value="" />
							
						</div>
						<div class="col-lg-6" style="text-align:right;">
							<button type="button" class="btn btn-default" onclick = 'cancelarCompra();'>Cancelar Compra</button>
							
						</div>
					</div>
				</div>
				<div id="newCliente" style="margin-left:50px; display:none;">
					<div class="row" style="color:#fff;">
						<div class="col-lg-12">
							<h4 id="smstitulo"></h4>
						</div>
					</div>
					
					<div class="row" style="color:#fff;">
						<div class="col-lg-5">
							<h4>Nombre:</h4>
							<input type="text" class="inputlogin form-control" id="nomClienteBusca" placeholder="nombre" />
						</div>
						<div class="col-lg-5">
							<h4>E-mail (Titular Cuenta):</h4>
							<input type="text" class="inputlogin form-control" id="mail" name="mail" placeholder="example@dominio.com" />
						</div>
					</div>
					<div class="row" style="color:#fff;">
						<div class="col-lg-5">
							<h4>Dirección del Domicilio (Titular Cuenta):</h4>
							<input type="text" class="inputlogin form-control" id="dir" name="dir" placeholder="" />
						</div>
						<div class="col-lg-5">
							<h4>Teléfono:</h4>
							<input type="text" class="inputlogin form-control" id="movil" maxlength="10" name="movil" placeholder="0999999999" />
						</div>
						<!--<div class="col-lg-5">
							<h4>Como Obtener su(s) TICKET(S):</h4>
							<select id="obtenerboletos" class="inputlogin form-control" onchange="formaenvio()">
								
							</select>
						</div>-->
					</div>
					<div id="personas_boletos">
						
					</div>
					<div class="row">
						<div class="col-lg-11">
							<a class="btnlink pull-right" style="cursor:pointer;" onclick="cancelarNuevo()">Cancelar</a>
						</div>
					</div>
				</div>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<link rel="stylesheet" href="font-awesome-4.6.3/css/font-awesome.min.css">
			<div style="border: 2px solid #00ADEF;color:#fff;">
				<table class = 'table'>
					<tr>
						<td>
							<h4><strong>Asientos #</strong></h4>
						</td>
						<td>
							<h4><strong>Descripci&oacute;n</strong></h4>
						</td>
						<td>
							<h4><strong>Localidad</strong></h4>
						</td>
						<td>
							<h4><strong>Cantidad</strong></h4>
						</td>
						<td>
							<h4><strong>Precio</strong></h4>
						</td>
						<td>
							<h4><strong>Total</strong></h4>
						</td>
						<td>
							<h4><strong>Eliminar</strong></h4>
						</td>
					</tr>
				</table>
				<table class="table">
				<?php
				$suma = 0;
				$cant_bol = 0;
				$jj=0;
				//print_r($_POST['codigo']);
				// if(isset($_POST['codigo'])){
					$count = 0;
					$compras = $_SESSION['carrito'];
					for($i=0;$i<=count($compras)-1;$i++){
						$jj ++;
						$precio = $compras[$i]['precio'];
					?>
						<tr class="row datos_boleto tr_boleto_<?php echo $count;?>" id="name_boletos<?php echo $count;?>">
							<td>
								<?php echo $jj;?>
							</td>
							<td>
								<?php
									echo 	'
												<input type="hidden" id="codigo" name="codigo[]" value="'.$compras[$i]['local'].'" class="added resumen localidad" readonly="readonly" size="2" />
												<input type="hidden" name="row[]" class="added fila" value="'.$compras[$i]['roww'].'" />
												<input type="hidden" name="col[]" class="added col" value="'.$compras[$i]['coll'].'" />
												<input type="text" id="chair'.$count.'" name="chair[]" value="'.$compras[$i]['chair'].'" class="added resumen asiento" readonly="readonly" size="15" />
											';
								?>
							</td>
							<td>
								<?php
									echo '<input type="text" id="des'.$count.'" name="des[]" value="'.$compras[$i]['des'].'" class="added resumen des" readonly="readonly" size="15" />';
								?>
							</td>
							<td>
								<?php
									echo '<input type="text" id="num" name="num[]" value="1" class="added resumen cantidad" readonly="readonly" size="2" />';
								?>
							</td>
							<td>
								<?php
									echo '<input type="text" id="pre" name="pre[]" value="'.$compras[$i]['precio'].'" class="added resumen precio" readonly="readonly" size="5" />';
								?>
							</td>
							<td>
								<?php
									echo '<input type="text" id="tot" name="tot[]" value="'.$compras[$i]['total'].'" class="added resumen tot" readonly="readonly" size="5" />';
								?>
							</td>
							<td>
								<?php
									echo '<i class="fa fa-trash-o" title = "Eliminar : '.$compras[$i]['chair'].'" style = "cursor:pointer;" aria-hidden="true" onclick="elimanarsillas('.$count.')"></i>';
								?>
							</td>
						</tr>
					<?php
						
						$suma += $compras[$i]['total'];
						$totalpagar = number_format($suma, 2,'.','');
						$cant_bol +=  $compras[$i]['cantidad'];
						
						$localidad = $compras[$i]['local'];
						$precio = $compras[$i]['precio'];
						
						$count++;
					}
				echo $precio." aaaq";
					
					// foreach($_POST['codigo'] as $key=>$cod_loc){
						// $jj ++;
						// echo '<div class="row datos_boleto" id="name_boletos'.$count.'">
								// <div class="col-xs-2" style="text-align:center;">
									// <input type="hidden" id="codigo" name="codigo[]" value="'.$cod_loc.'" class="added resumen localidad" readonly="readonly" size="2" />
									// <input type="hidden" name="row[]" class="added fila" value="'.$_POST['row'][$key].'" />
									// <input type="hidden" name="col[]" class="added col" value="'.$_POST['col'][$key].'" />
									// '.$jj.'<input type="text" id="chair'.$count.'" name="chair[]" value="'.$_POST['chair'][$key].'" class="added resumen asiento" readonly="readonly" size="15" />
								// </div>
								// <div class="col-xs-2" style="text-align:center">
									// <input type="text" id="des'.$count.'" name="des[]" value="'.$_POST['des'][$key].'" class="added resumen des" readonly="readonly" size="15" />
								// </div>
								// <div class="col-xs-2" style="text-align:center;">
									// <input type="text" id="num" name="num[]" value="'.$_POST['num'][$key].'" class="added resumen" readonly="readonly" size="2" />
								// </div>
								// <div class="col-xs-2" style="text-align:center;">
									// <input type="text" id="pre" name="pre[]" value="'.$_POST['pre'][$key].'" class="added resumen precio" readonly="readonly" size="5" />
								// </div>
								// <div class="col-xs-2" style="text-align:right;">
									// <input type="text" id="tot" name="tot[]" value="'.$_POST['tot'][$key].'" class="added resumen" readonly="readonly" size="5" />
								// </div>
							// </div>';
						// $suma += $_POST['tot'][$key];
						// $totalpagar = number_format($suma, 2,'.','');
						// $cant_bol +=  $_POST['num'][$key];
						// $count++;
					// }
					echo '<input type="hidden" id="num_personas" value="'.$count.'" />';
				// }
				?>
				</table>
			</div>
		
		<?php
		//echo $_SESSION['tipo_emp']."hola";
		
		if($_SESSION['tipo_emp'] == 1){
			// // $compras = $_SESSION['carrito'];
			// // for($i=0;$i<=count($compras);$i++){
				// echo "<br/><br/><br/>".$i.".ID:".$compras[$i]['codigo']."<br/>";
				// echo "Nombre:".$compras[$i]['row']."<br/>";
				// echo "Cantidad:".$compras[$i]['col']."<br/><br/>";
				// echo "Precio:".$compras[$i]['chair']."<br/><br/>";
				// echo "des:".$compras[$i]['des']."<br/><br/>";
				// echo "nunm:".$compras[$i]['num']."<br/><br/>";
				
				// echo "tot".$compras[$i]['tot']."<br/><br/>";
			// // }
			// echo $precio."  qui";
				// foreach($_POST['codigo'] as $key=>$cod_loc){
					// $precio = $_POST['pre'][$key];
				// }
		?>
			<div class="row" style="color:#fff;">
				<div class="col-lg-3"></div>
				<div class="col-lg-5">
					<?php
						include 'conexion.php';
						$sqlD = 'select * from descuentos where idloc = "'.$localidad.'" ';
						$resD = mysql_query($sqlD) or die (mysql_error());
					?>
					<center><strong style = 'color:#fff;'>ASIGNAR DESCUENTO</strong></center>
					<select class = 'form-control' id = 'descuentos' style = 'text-transform:uppercase;'>
						<option value = '<?php echo $precio;?>' nombre ='seleccione' id_desc = '0' idloc = '0'>Seleccione Descuento...</option>
						<option value = '<?php echo $precio;?>' nombre ='normal' id_desc = '0' idloc = '<?php echo $localidad;?>' >Ninguno...</option>
					<?php
						if(mysql_num_rows($resD)>0 || mysql_num_rows($resD) != ''){
							while($rowD = mysql_fetch_array($resD)){
					?>
						<option value = '<?php echo $rowD['val'];?>' idloc = '<?php echo $rowD['idloc'];?>' nombre = '<?php echo $rowD['nom'];?>' id_desc = '<?php echo $rowD['id'];?>'>Descuento :  <?php echo $rowD['nom']."     $USD ".$rowD['val'];?></option>
					<?php
							}
					?>
					</select>
					<?php
						}
					?>
					<input type='hidden' id='recibeExcel2' value = '1'/>
					<input type="checkbox" id='ckTerceraEdad' onclick = 'muestraSubir();' name = 'subirCedula' style = 'display:none;' />
					
				
				</div>
				<div class="col-lg-3"></div>
			</div>
		<?php
		}
		?>
			<div style="margin:10px 20px;">
				<div class="row" style="color:#fff; ">
					<div class="col-xs-6">
					</div>
					<div class="col-xs-3" style="font-size:18px; padding-top:30px; text-align:right;">
						<p><strong>SUBTOTAL</strong></p>
						<p id="tituloenvio" style="display:none;"><strong>COSTO DE ENVIO</strong></p>
						<p><strong>TOTAL</strong></p>
					</div>
					<div class="col-xs-2" style="font-size:18px; padding-top:30px; text-align:right; padding-right:30px;">
						<p class = 'subtotal_variable'><?php echo $totalpagar;?></p>
						<input type="hidden" id="totalneto" value="<?php echo $totalpagar;?>" />
						<?php 
						$costoenvio = $row['costoenvioC'];
						$costoenvio = number_format($costoenvio,2);
						?>
						<p id="costoenvio" style="display:none;"><?php echo $costoenvio;?></p>
						<p id="total" class = 'total_variable' ><strong><?php echo $totalpagar;?></strong></p>
						<input type="hidden" id="total_pagar" name="total_pagar" value="<?php echo $totalpagar;?>" class="added resumen" readonly="readonly" size="7"/>
						<input type="hidden" id="num_boletos" name="num_boletos" value="<?php echo $cant_bol;?>" class="added cantidad_boletos" readonly="readonly" />
					</div>
				</div>
			</div>
			
			<div class="row" style="text-align:center; color:#fff;">
				<div class="col-lg-12">
					<h3><strong>Forma de Pago</strong></h3>
				</div>
			</div>
		<?php
		echo $_SESSION['tipocadena']."hola";
		if($_SESSION['tipo_emp'] == 2){
		?>
		<form id="datos" method="post" action="">
			<?php
				if(isset($_POST['codigo'])){
					echo '<table>';
					foreach($_POST['codigo'] as $key=>$cod_loc){
						echo'<tr class="datos_compra">
							<td><input type="hidden" class="codigo" name="codigo[]" value="'.$cod_loc.'" /></td>
							<td><input type="hidden" class="row" name="row[]" value="'.$_POST['row'][$key].'" /></td>
							<td><input type="hidden" class="col" name="col[]" value="'.$_POST['col'][$key].'" /></td>
							<td><input type="hidden" class="chair" name="chair[]" value="'.$_POST['chair'][$key].'" /></td>
							<td><input type="hidden" class="des" name = "des[]" value="'.$_POST['des'][$key].'"/></td>
							<td><input type="hidden" class="num" name = "num[]" value="'.$_POST['num'][$key].'" /></td>
							<td><input type="hidden" class="pre" name = "pre[]" value="'.$_POST['pre'][$key].'"/></td>
							<td><input type="hidden" class="tot" name = "tot[]" value="'.$_POST['tot'][$key].'" /></td>
						</tr>';
						$total_pagar += ($_POST['num'][$key] * $_POST['pre'][$key]);
					}
					//echo $total_pagar;
					echo '</table>';
					echo '<input type="hidden" class="total_pagar" name = "total_pagar" value="'.$total_pagar.'" />';
					
				}
			?>
				<input type="hidden" id="num_boletos" name="num_boletos" value="<?php echo $cant_bol;?>" class="added" readonly="readonly" />
				<input type="hidden" id="cliente_kiosko"  name = "cliente_kiosko" />
				<input type="hidden" id="cliente_kiosko_id"  name = "cliente_kiosko_id" />
				<input type="hidden" id="cliente_kiosko_ced"  name = "cliente_kiosko_ced" />
				
				<input type="hidden" id="cliente_kiosko_mail"  name = "cliente_kiosko_mail" />
				<input type="hidden" id="cliente_kiosko_dir"  name = "cliente_kiosko_dir" />
				<input type="hidden" id="cliente_kiosko_movil"  name = "cliente_kiosko_movil" />
			<center>
				<select id="pagoKioskoNew" class="inputlogin form-control" name="cmbpago" style="width: 30%">
					<option value="0">Seleccione</option>
					<option value="1">Tarjeta de Crédito(Latin Paiments)</option>
					
				<?php
						if($_SESSION['tipocadena'] == 1){
				?>
					<option value="3">Punto de Venta</option>
					<option value="4">Paypal</option>
					<option value="2">Depósito Bancario</option>
				<?php
						}else{
				?>
					<option value="5">Tarjeta de Crédito(POS)</option>
					<option value="6">Efectivo</option>
				<?php
						}
				?>
					
				</select>
			</center>
			
			<div id="accionContinuar" style="height:auto; background-color:#EC1867; margin:50px -32px 10px 70%; padding-right:30px; color:#fff; font-size:18px; position:relative;">
				<div class="table-responsive" style="width:100%">
					<a id="aceptar" onclick="verOpcionesPago()" class="btn_compra_online pull-right" style="text-decoration:none; cursor:pointer;">
						<img src="imagenes/mano_comprar.png" style="margin:0 10px 0 -20px;"/>
						<strong>+ Continuar</strong>
					</a>
				</div>
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
		</form>
		
		
		<?php
		}
			//echo $_SESSION['tipo_emp']."hola";
			if($_SESSION['tipo_emp'] == 1){
		?>
				
			
			<div class="row" style="color:#fff;">
				<div class="col-lg-5"></div>
				<div class="col-lg-4">
					<h4>
						<label for="efectivo" style="cursor:pointer;">
							<input onclick = 'saberTipoPago(1);' type="radio" id="efectivo" name="fpago" style="cursor:pointer;" checked />&nbsp;Efectivo
						</label>
					</h4>
				</div>
			</div>
			
			
			<div class="row" style="color:#fff;">
				<div class="col-lg-5"></div>
				<div class="col-lg-4">
					<h4>
						<label for="tarjeta" style="cursor:pointer;">
							<input onclick = 'saberTipoPago(2);' type="radio" id="tarjeta" name="fpago" style="cursor:pointer;" />&nbsp;Tarjeta de Crédito
						</label>
					</h4>
					<select class = 'form-control' id = 'tipo_tarjeta' style = 'display:none;' >
						<option value = '0' >Seleccione</option>
						<option value = '1' >Visa</option>
						<option value = '2' >Dinners</option>
						<option value = '3' >Mastercard</option>
						<option value = '4' >Discover</option>
						<option value = '5' >Amex</option>
					</select>
				</div>
			</div>
			
			<script>
				function saberTipoPago(id){
					if(id == 1){
						$('#tipo_tarjeta').fadeOut('slow');
					}else{
						$('#tipo_tarjeta').fadeIn('slow');
					}
				}
			</script>
			
			
			<div id="accionContinuar" style="height:auto; background-color:#EC1867; margin:50px -32px 10px 70%; padding-right:30px; color:#fff; font-size:18px; position:relative;">
				<div class="table-responsive" style="width:100%"  onclick="guardarDatosPV();" >
					<a id="aceptar"class="btn_compra_online pull-right" style="text-decoration:none; cursor:pointer;">
						<img src="imagenes/mano_comprar.png" style="margin:0 10px 0 -20px;"/>
						<strong>+ Continuar</strong>
					</a>
				</div>
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
			<script>
				function cancelarCompra(){
					$.post("distribuidor/ventas/cancelaCompra.php",{ 
					}).done(function(data){
						alert(data);
						window.location = '';
					});
				}
				$( document ).ready(function() {
					console.log( "ready!" );
					$("#descuentos").change(function(){
						var descuentos = $('#descuentos').val();
						var idloc = $('#descuentos option:selected').attr('idloc');
						var id_desc = $('#descuentos option:selected').attr('id_desc');
						var nomDesc = $('#descuentos option:selected').attr('nombre');
						var num_personas = $('#num_personas').val();
						var idConcierto = $('#idConcierto').val();
						
						
						
						var res_Nom_Desc = nomDesc.substring(0, 7);
						alert(res_Nom_Desc);
						// alert('localidad : ' + idloc + ' descuento : ' + id_desc + 'cantidad : ' + num_personas);
						if(res_Nom_Desc == 'CORTESI' || res_Nom_Desc == 'cortesi'){
							$.post("spadmin/saberCantidadCortesias.php",{ 
								idloc : idloc ,id_desc : id_desc , num_personas : num_personas
							}).done(function(data){
								// alert(data)	
								var res = data.split("|"); 
								var ident = res[0];
								var cantidad_aut = res[1];
								if(ident == 0){
									alert('Atencion!! , no puede comprar : ' + num_personas + ' tickets , por que solo disponemos de : ' + cantidad_aut + ' tickets autorizados para cortesias , se reconfigurara la compra');
									window.location = '?modulo=conciertoDis&evento='+idConcierto+'&idloc='+idloc+'&cantidad_aut='+cantidad_aut;
								}else if(ident == 3){
									alert('Atencion!! , no puede comprar : ' + num_personas + ' tickets , por que ya no hay disponibilidad de tickets');
								}else if(ident == 2){
									alert('no se a configurado la cantidad de las corresias siga nomas');
								}
							});
							
							$('.precio').val(descuentos);
							$('.tot').val(descuentos);
							saberPrecio();
						}else if ((res_Nom_Desc != 'CORTESI' || res_Nom_Desc != 'cortesi') && res_Nom_Desc != 'selecci'){
							$.post("spadmin/saberCantidad_No_Cortesias.php",{ 
								idloc : idloc , num_personas : num_personas
							}).done(function(data){
								// alert(data)	
								var res = data.split("|"); 
								var ident = res[0];
								var cantidad_aut = res[1];
								if(ident == 0){
									alert('Atencion!! , no puede comprar : ' + num_personas + ' tickets , por que solo disponemos de : ' + cantidad_aut + ' tickets autorizados , se reconfigurara la compra');
									window.location = '?modulo=conciertoDis&evento='+idConcierto+'&idloc='+idloc+'&cantidad_aut='+cantidad_aut;
								}else if(ident == 2){
									alert('no se a configurado la cantidad de las corresias siga nomas');
								}
							});
							$('.precio').val(descuentos);
							$('.tot').val(descuentos);
							saberPrecio();
						}else{
							
						}
						
						
					}); 
					saberPrecio();
				});
				function saberPrecio(idloc,id_desc,num_personas){
					var precio = 0;
					var num_boletos = 0;
					$('.datos_boleto').each(function(){
						precio += parseFloat($(this).find('.precio').val());
						num_boletos += parseInt($(this).find('.cantidad').val());
					});
					//alert(num_boletos)
					$('.subtotal_variable').html((precio).toFixed(2));
					$('.total_variable').html((precio).toFixed(2));
					$('#total_pagar').val((precio).toFixed(2));
					$('.cantidad_boletos').val(num_boletos);
					
				}
				function elimanarsillas(cont){
					$('.tr_boleto_'+cont).remove();
					saberPrecio();
				}
				
				
				function guardarDatosPV(){
					var descuentos = $('#descuentos').val();
					var descuentos_nombre = $('#descuentos option:selected').attr('nombre');
					// alert(descuentos_nombre);
					if(descuentos_nombre == 'seleccione'){
						alert('debe seleccionar un tipo de descuento o a su vez la opcion de ninguno');
					}else{
												//alert('hola q hace');
						var clienteok = $('#clienteok').val();
						var total_pagar = $('#total_pagar').val();
						var idcliente = $('#cliente').val();
						if(clienteok == 'no'){
							var nombres = $('#nombres').val();
							var documento = $('#documento').val();
						}else{
							var nombres = 'no';
							var documento = 'no';
						}
						var mail = $('#mail').val();
						var movil = $('#movil').val();
						var concierto = $('#idConcierto').val();
						var forma = 'correo';
						var dir = $('#dir').val();
						var tipopago = '';
						if($('#tarjeta').is(':checked')){
							tipopago = 'Tarjeta de Credito';
						}else if($('#efectivo').is(':checked')){
							tipopago = 'Efectivo';
						}
						
						if(forma == 3){
							mail = 'h';
						}
						
						var valores = '';
						
						$('.datos_boleto').each(function(){
							var localidad = $(this).find('.localidad').val();
							var descripcion = $(this).find('.des').val();
							var asiento = $(this).find('.asiento').val();
							var precio = $(this).find('.precio').val();
							var fila = $(this).find('.fila').val();
							var col = $(this).find('.col').val();
							var nombre = $(this).find('.nombres').val();
							var cedula = $(this).find('.documento').val();
							
							valores += localidad +'|'+ descripcion +'|'+ asiento +'|'+ precio +'|'+ fila +'|'+ col +'|'+ nombre +'|'+ cedula +'|'+'@';
						});
						var valores_form = valores.substring(0,valores.length -1);
						
						//alert(valores_form)
						
						
						var nomDesc = $('#descuentos option:selected').attr('nombre');
						var id_desc = $('#descuentos option:selected').attr('id_desc');
						
						//alert(descuentos +'>><<'+ nomDesc +'<<>>'+ id_desc);
						
						var tipo_tarjeta = $('#tipo_tarjeta').val();
						
						if((tipopago == '') || (mail == '') || (dir == '') || (forma == 0) || (nombres == '') || (documento == '')){
							$('#alerta4').fadeIn();
							$('#aviso').modal('show');
							return false;
						}else{
							alert('Se enviara la compra');
							if((clienteok == 'ok') && (idcliente != '')){
								
								
								$('#accionContinuar').fadeOut();
								$('#procesando').delay(600).fadeIn();
								$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor_2.php',{
									clienteok : clienteok, idcliente : idcliente, concierto : concierto, valores : valores_form, 
									tipopago : tipopago, forma : forma, mail : mail, movil : movil, dir : dir, total_pagar : total_pagar ,
									descuentos : descuentos , nomDesc : nomDesc , id_desc : id_desc , tipo_tarjeta : tipo_tarjeta
								}).done(function(response){
									if($.trim(response) == 'error'){
										$('#alerta6').fadeIn();
										$('#aceptarModal').fadeOut();
										$('#aviso').modal('show');
										setTimeout(function(){
											console.log('fuck!!!!');
											window.location = '?modulo=pagoexitosoDis&error=error';
										}, 2000);
									}else{
										alert(response);
										window.location = '?modulo=pagoexitosoDis';
									}
									// alert(response);
									// window.location = '?modulo=pagoexitosoDis';
								});
							}else if((clienteok == 'ok') && (idcliente == '')){
								$('#alerta3').fadeIn();
								$('#aviso').modal('show');
								return false;
							}else if(clienteok == 'no'){
								
								$('#accionContinuar').fadeOut();
								$('#procesando').delay(600).fadeIn();
								$.post('distribuidor/ventas/ajax/ajaxPagoDistribuidor_2.php',{
									clienteok : clienteok, mail : mail, movil : movil, dir : dir, concierto : concierto, valores : valores_form, tipopago : tipopago,
									forma : forma, documento : documento, nombres : nombres , total_pagar : total_pagar ,
									descuentos : descuentos , nomDesc : nomDesc , id_desc : id_desc , tipo_tarjeta : tipo_tarjeta
								}).done(function(response){
									if($.trim(response) == 'error'){
										$('#alerta6').fadeIn();
										$('#aceptarModal').fadeOut();
										$('#aviso').modal('show');
										setTimeout(function(){
											console.log('fuck!!!!');
											window.location = '?modulo=pagoexitosoDis&error=error';
										}, 2000);
									}else{
										alert(response);
										window.location = '?modulo=pagoexitosoDis';
									}
									// alert(response);
									// window.location = '?modulo=pagoexitosoDis';
								});
							}else if(clienteok == ''){
								$('#alerta3').fadeIn();
								$('#aviso').modal('show');
							}
						}
					}
				}
			</script>
		<?php
			}
		?>
			
			<div id="procesando" class="row" style="text-align:center; padding-bottom:20px; display:none;">
				<img src="imagenes/loading.gif" style="max-width:70px;"></img>
			</div>
			<div class="modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
						</div>
						<div class="modal-body">
							<h4 id="alerta1" class="alertas" style="display:none;">
								<div class="alert alert-info" role="alert">
									<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
										&nbsp;<strong>Aviso!</strong>&nbsp;Los asientos seleccionados se han perdido, seleccionelos nuevamente.
								</div>
							</h4>
							<h4 id="alerta2" class="alertas" style="display:none;">
								<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;<strong>Error!</strong>&nbsp;El Documento de Identificación ingresado es incorrecto.
								</div>
							</h4>
							<h4 id="alerta3" class="alertas" style="display:none;">
								<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;<strong>Error!</strong>&nbsp;No ha seleccionado a ningun cliente, por favor hagalo.
								</div>
							</h4>
							<h4 id="alerta4" class="alertas" style="display:none;">
								<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;<strong>Error!</strong>&nbsp;Existen campos vacios, por favor llenelos.
								</div>
							</h4>
							<h4 id="alerta5" class="alertas" style="display:none;">
								<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;<strong>Error!</strong>&nbsp;Este E-mail ya existe, ingreselo de nuevo.
								</div>
							</h4>
							<h4 id="alerta6" class="alertas" style="display:none;">
								<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
									&nbsp;<strong>Aviso!</strong>&nbsp;Uno o más de sus asientos ya se han comprado, imposible continuar.
								</div>
							</h4>
						</div>
						<div class="modal-footer">
							<button id = 'aceptarModal' type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptarModal()">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>