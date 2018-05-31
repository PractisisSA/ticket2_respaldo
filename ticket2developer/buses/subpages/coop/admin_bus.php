	<?php
		session_start();
		$limite = $_SESSION['limite'];
		echo $_SESSION['iduser'];
	?>
	<style>
		.asientosBus{
			webkit-transform: rotate(-90deg); 	
			-moz-transform: rotate(-90deg); 	
			rotation: -90deg; 	
			filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=-1);
			-webkit-perspective;
			position: relative; 
			top:-220px;
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
	<input type="hidden" id="data" value="10" />
<div style="margin:10px -10px;"> 
<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<div style="background-color:#171A1B; padding-right:3%;padding-left: 2%"><br/><br/>
		<div style = 'text-align:left;padding-top:10px;padding-bottom:10px;padding-left:20px;background-color:#ed1568;width:90%;' >
			<h3 style = 'margin:0px;padding:0px;color:#fff;'>ESCOJA EL N° DE ASIENTOS PARA EL NUEVO BUS Y PRESIONE GENERAR</h3>
		</div>
		<div class ='row'>
			<div class = 'col-md-1' ></div>
			<div class = 'col-md-9'>
				<table class="table table-border" style="color: white">
					<tr>
						
						<td># Asientos</td>
						<td>Generar</td>
					</tr>
					<tr>
						<!--<td>
							<select class = 'form-control' >
								<option value = ''>Seleccione...</option>
								<option value = '1'>Chofer 1</option>
								<option value = '2'>Chofer 2</option>
								<option value = '3'>Chofer 3</option>
								<option value = '4'>Chofer 4</option>
							</select>
						</td>-->
						<td>
							<select class = 'form-control' id = 'limite'>
							<?php
								for($i=36;$i<=60;$i++){
									if($i == $_SESSION['limite']){
										$selected = 'selected';
									}else{
										$selected = '';
									}
							?>
								<option value = '<?php echo $i;?>' <?php echo $selected;?>><?php echo $i;?> Asientos</option>
							<?php
								}
								if(isset($_SESSION['limite'])){
									$di = 'display:none;';
								}else{
									$di = '';
								}
							?>
							</select>
						</td>
						<td style = '<?php echo $di;?>'>
							<button type="button" class="btn btn-danger" onclick = 'generarAsientos()' >Generar</button>
						</td>
						<?php
							if(isset($_SESSION['limite'])){
						?>
							<td>
								<button type="button" class="btn btn-success" onclick = 'terminaCreacion(<?php echo $_SESSION['limite'];?>)'>Terminar</button>
							</td>
						<?php
							}
						?>
					</tr>
				</table>
			</div>
			<div class = 'col-md-1' ></div>
		</div>
		<div class ='row'>
			<div class = 'col-md-1' ></div>
			<div class = 'col-md-9'>
				<table  align='center' id = 'asientosBus' class = 'asientosBus'>
				<?php
					if(isset($_SESSION['limite'])){
				?>
					<tr>
						<td colspan = '5'>
							<img src = 'images/trompa2.png'/>
						</td>
					</tr>
				<?php
					$sql = 'select * from bus where id = "'.$_SESSION['id_bus'].'" ';
					//echo $sql;
					$res = mysql_query($sql) or die (mysql_error());
					$row = mysql_fetch_array($res);
					$i=0;
					
					for($j=1;$j<=$row['asientos'];$j++){
						
						$sql2 = 'select * from bus_bloqueo where id_bus = "'.$_SESSION['id_bus'].'" and asiento = "'.$j.'" ';
						$res2 = mysql_query($sql2) or die (mysql_error());
						$row2 = mysql_fetch_array($res2);
					//	echo $row2['asiento']."<<>>".$j."<br>";
						if($row2['asiento'] == $j){
							$background = 'background-color:#000;';
							$color = 'color:#fff;';
							$botonEnvio = 'onclick = "enviaBloqueos('.$_SESSION['id_bus'].' , '.$j.' , '.$row2['id'].', 1)" ';
							$border = 'border: 1px solid #fff;';
						}else{
							$background = 'background-color:#fff;';
							$color = 'color:#000;';
							$botonEnvio = 'onclick = "enviaBloqueos('.$_SESSION['id_bus'].' , '.$j.' , 0 , 2)" ';
							$border = 'border: 1px solid #000;';
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
				<?php
					}
				?>
				</table><br><br>
				
			</div>
			<div class = 'col-md-1' ></div>
		</div>
	</div>
</div>
	<script>
		function terminaCreacion(id){
			$.post("subpages/coop/terminaCreacion.php",{ 
			}).done(function(data){
				window.location = '?page=det_bus';
			});
		}
		function enviaBloqueos(id_bus , asiento , id_blo , ident ){
			$.post("ajax/asignaBloqueo.php",{ 
				id_bus : id_bus , asiento : asiento , id_blo : id_blo , ident : ident
			}).done(function(data){
				// alert(data);
				window.location = '';
			});
		}
		function generarAsientos(){
			var limite = $('#limite').val();
			$.post("subpages/coop/asientos_bus.php",{ 
				limite : limite 
			}).done(function(data){
				//alert(data);		
				// $('#asientosBus').html(data);
				window.location = '';
			});
		}
	</script>