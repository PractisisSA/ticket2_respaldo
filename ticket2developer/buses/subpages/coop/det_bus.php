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
	<input type="hidden" id="data" value="11" />
<div style="margin:10px -10px;"> 
<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<div style="background-color:#171A1B; padding-right:3%;padding-left: 2%"><br/><br/>
		<div style = 'text-align:left;padding-top:10px;padding-bottom:10px;padding-left:20px;background-color:#ed1568;width:50%;' >
			<h3 style = 'margin:0px;padding:0px;color:#fff;'>Ver Buses de la Coop. : <?php echo $row['nom'];?> </h3>
		</div>
		<div class ='row'>
			<div class = 'col-md-1' ></div>
			<div class = 'col-md-9'>
		<?php
			if(!isset($_REQUEST['id_bus'])){
		?>
				<table  align='center' class = 'table' style = 'color:#fff;'>
					<tr>
						<td>
							ID
						</td>
						<td>
							N°
						</td>
						<td>
							ASIENTOS DISPONIBLES
						</td>
						<td>
							ASIENTOS BLOQUEADOS
						</td>
						<td>
							OPCIONES
						</td>
					</tr>
				<?php
					$i=1;
					while($rowB = mysql_fetch_array($resB)){
						$i++;
						$sql2 = 'select count(id) as cuantos from bus_bloqueo where id_bus = "'.$rowB['id'].'"';
						$res2 = mysql_query($sql2) or die (mysql_error());
						$row2 = mysql_fetch_array($res2);
				?>
					<tr>
						<td>
							<?php echo $i;?>
						</td>
						<td>
							<?php echo $rowB['codigo'];?>
						</td>
						<td style ='text-align:center;' >
							<?php echo ($rowB['asientos'] - $row2['cuantos']);?>
						</td>
						<td style ='text-align:center;'>
							<?php echo ($row2['cuantos']);?>
						</td>
						<td>
							<button type="button" class="btn btn-default" onclick = 'verDetBus(<?php echo $rowB['id']?>)'>Ver Detalle  <span class= "glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>
						</td>
					</tr>
				<?php
					}
				?>
				</table>
		<?php
			}
		?>
			<?php
				if(isset($_REQUEST['id_bus'])){
					$sql = 'select * from bus where id = "'.$_REQUEST['id_bus'].'" ';
					//echo $sql;
					$res = mysql_query($sql) or die (mysql_error());
					$row = mysql_fetch_array($res);
					
					
			?>
				<center><button type="button" class="btn btn-info" onclick = 'window.location = "?page=det_bus"'>volver</button></center>
				<h3 style = 'padding:0px;margin:0px;color:#fff;'>Bus : <?php echo $row['codigo'];?></h3>
				<table  align='center' id = 'asientosBus' class = 'asientosBus'>
				
					<tr>
						<td colspan = '5'>
							<img src = 'images/trompa2.png'/>
						</td>
					</tr>
				<?php
					
					$i=0;
					
					for($j=1;$j<=$row['asientos'];$j++){
						
						$sql2 = 'select * from bus_bloqueo where id_bus = "'.$_REQUEST['id_bus'].'" and asiento = "'.$j.'" ';
						$res2 = mysql_query($sql2) or die (mysql_error());
						$row2 = mysql_fetch_array($res2);
					//	echo $row2['asiento']."<<>>".$j."<br>";
						if($row2['asiento'] == $j){
							$background = 'background-color:#000;';
							$color = 'color:#fff;';
							$botonEnvio = 'onclick = "enviaBloqueos('.$_REQUEST['id_bus'].' , '.$j.' , '.$row2['id'].', 1)" ';
							$border = 'border: 1px solid #fff;';
						}else{
							$background = 'background-color:#fff;';
							$color = 'color:#000;';
							$botonEnvio = 'onclick = "enviaBloqueos('.$_REQUEST['id_bus'].' , '.$j.' , 0 , 2)" ';
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
				
				</table>
			<?php
				}
			?>
			</div>
			<div class = 'col-md-1' ></div>
		</div>
	</div>
</div>
	<script>
		function enviaBloqueos(id_bus , asiento , id_blo , ident ){
			$.post("ajax/asignaBloqueo.php",{ 
				id_bus : id_bus , asiento : asiento , id_blo : id_blo , ident : ident
			}).done(function(data){
				// alert(data);
				window.location = '';
			});
		}
		function verDetBus(id_bus){
			window.location = '?page=det_bus&id_bus='+id_bus;
		}
	</script>