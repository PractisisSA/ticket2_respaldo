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
	<input type="hidden" id="data" value="13" />
<div style="margin:10px -10px;"> 
<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<div style="background-color:#171A1B; padding-right:3%;padding-left: 2%"><br/><br/>
		<div style = 'text-align:left;padding-top:10px;padding-bottom:10px;padding-left:20px;background-color:#ed1568;width:90%;' >
			<h3 style = 'margin:0px;padding:0px;color:#fff;'>LISTADO DE CIUDADES Y TERMINALES </h3>
		</div>
		<div class ='row'>
			<div class = 'col-md-1' ></div>
			<div class = 'col-md-12'>
				<table class = 'table' style = 'color:#fff;'>
					<tr>
						<td>
							<table class = 'table'>
								<tr>
									<td>
										<input type = 'text' class = 'form-control' id = 'nuevaCiudad' placeholder = 'ingrese nueva ciudad' />
									</td>
									<td>
										<button type="button" class="btn btn-primary" onclick = 'grabaNuevaCiudad()' >GRABAR CIUDAD</button>
									</td>
								</tr>
							</table>
						</td>
						<td></td>
					</tr>
				<?php
					$sql = 'select * from ciudades order by nom asc';
					$res = mysql_query($sql) or die (mysql_error());
					while($row = mysql_fetch_array($res)){
						if($row['estado'] == 1){
							$etiq = 'times';
							$ident = 2;
							$txt = 'desactivar';
							$color = 'color:red;';
						}else{
							
							$etiq = 'check';
							$ident = 3;
							$txt = 'activar';
							$color = 'color:#1EA076;';
						}
				?>
					<tr>
						<td style = 'text-transform:uppercase;'>
							<table width = '100%'>
								<tr>
									<td>
										<input type = 'text' id = 'nom_ciu_<?php echo $row['id'];?>' value = '<?php echo $row['nom'];?>'/>
									</td>
									<td>
										<button type="button" class="btn btn-primary" id = 'actualizaCiudad_<?php echo $row['id'];?>' onclick = 'actualizaCiudad(<?php echo $row['id'];?> , 1)' >Actualizar Ciudad</button>
										<i class="fa fa-<?php echo $etiq;?>" aria-hidden="true" style = '<?php echo $color;?>cursor:pointer;' onclick = 'actualizaCiudad(<?php echo $row['id'];?> , <?php echo $ident;?>)' title = '<?php echo $txt;?> ciudad : <?php echo $row['nom'];?>' ></i>
									</td>
								</tr>
							</table>
						</td>
						<td>
					<?php
						$sql1 = 'select * from terminales where id_ciu = "'.$row['id'].'" ';
						$res1 = mysql_query($sql1) or die (mysql_error());
					?>
							<table width = '100%' style = 'color:#fff;'>
								<tr>
									<td>
										<i class="fa fa-floppy-o" aria-hidden="true" title = 'grabar nuevo terminal para : <?php echo $row['nom'];?>' style = 'cursor:pointer;' ></i> 
										-*- 
										<input id = 'nuevoTerminal_<?php echo $row['id'];?>' type = 'text' placeholder = 'nuevo terminal para:<?php echo $row['nom'];?>' style = 'color:#000;font-size:13px;width: 175px' />
									</td>
									<td>
										<button type="button" class="btn btn-warning" onclick = 'nuevoTerminal(<?php echo $row['id'];?>)'>GRABA TERMINAL</button>
									</td>
								</tr>
					<?php
						while($row1 = mysql_fetch_array($res1)){
							if($row1['estado'] == 1){
								$etiq1 = 'times';
								$ident1 = 2;
								$txt1 = 'desactivar';
								$color1 = 'color:red;';
							}else{
								
								$etiq1 = 'check';
								$ident1 = 3;
								$txt1 = 'activar';
								$color1 = 'color:#1EA076;';
							}
					?>
							<tr>
								<td style = 'text-align:left;' >
									<i onclick = 'actualizaTerminal(<?php echo $row1['id'];?> , <?php echo $ident1;?>)'  class="fa fa-<?php echo $etiq1;?>" aria-hidden="true" title = '<?php echo $txt1;?> terminal : <?php echo $row1['nombre'];?>' style = 'cursor:pointer;<?php echo $color1;?>' ></i> 
									-*- 
									<input style = 'color:#000;' type = 'text' id = 'nom_ter_<?php echo $row1['id'];?>' value = '<?php echo $row1['nombre'];?>' />
								</td>
								<td style = 'text-align:left;' >
									  <button type="button" class="btn btn-primary btn-sm" id = 'actualizaTerminal_<?php echo $row1['id'];?>' onclick = 'actualizaTerminal(<?php echo $row1['id'];?> , 1)'>ACTUALIZA TERMINAL</button>
								</td>
							</tr>
					<?php
						}
					?>
							</table>
						</td>
					</tr>
				<?php
					}
				?>
				</table>
			</div>
			<div class = 'col-md-1' ></div>
			<div class = 'col-md-12' id = 'recibeRutas'></div>
		</div>
	</div>
</div>
	<script>
		function grabaNuevaCiudad(){
			var ident = 4;
			var nuevaCiudad = $('#nuevaCiudad').val();
			if(nuevaCiudad == ''){
				alert('ingrese una ciudad');
			}else{
				$.post("subpages/coop/actualizaCiudad.php",{ 
					nuevaCiudad : nuevaCiudad , ident : ident
				}).done(function(data){
					alert(data);
					window.location = '';
				});
			}			
		}
		
		function nuevoTerminal(id_ciu){
			var nuevoTerminal = $('#nuevoTerminal_'+id_ciu).val();
			if(nuevoTerminal == ''){
				alert('ingrese un nombre de terminal');
			}else{
				$.post("subpages/coop/nuevoTerminal.php",{ 
					nuevoTerminal : nuevoTerminal , id_ciu : id_ciu
				}).done(function(data){
					alert(data);
					window.location = '';
				});
			}
		}
		function actualizaCiudad(id_ciu , ident){
			
			var nom_ciu = $('#nom_ciu_'+id_ciu).val();
			if(nom_ciu == ''){
				alert('no puede dejar este campo vacio');
			}else{
				if(ident == 1){
					$('#actualizaCiudad_'+id_ciu).attr('disabled' , true);
				}
				$.post("subpages/coop/actualizaCiudad.php",{ 
					id_ciu : id_ciu , ident : ident , nom_ciu : nom_ciu
				}).done(function(data){
					alert(data);
					window.location = '';
				});
			}
				
		}
		
		function actualizaTerminal(id_ter , ident){
			var nom_ter = $('#nom_ter_'+id_ter).val();
			if(nom_ter == ''){
				alert('no puede dejar este campo vacio');
			}else{
				if(ident == 1){
					$('#actualizaTerminal_'+id_ter).attr('disabled' , true);
				}
				$.post("subpages/coop/actualizaTerminal.php",{ 
					id_ter : id_ter , ident : ident , nom_ter : nom_ter
				}).done(function(data){
					alert(data);
					window.location = '';
				});
			}
		}
	</script>