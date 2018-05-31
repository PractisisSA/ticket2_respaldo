<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
		date_default_timezone_set('America/Guayaquil');
		
		include 'conexion.php';
		echo '<input type="hidden" id="data" value="40" />';
?>		
		<style>
			.carpeta:hover{
				cursor:pointer;
				color:blue;
				text-decoration:underline;
			}
		</style>
		<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 50px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				<strong>ADMINITRAR BANNER HOME</strong>
			</div><br>
			<!-- <div style="background-color:#EC1867; color:#fff; margin:20px 50px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				<strong>ASIGNAR IMG HOME</strong>
				<div class="row">
					<div class="col-md-10">
						<select id="concerts1" class="form-control">
							<option value="0">Seleccione un evento</option>
						<?php
							$fecha = date("Y-m-d");
							$sqlT = 'select * from Concierto where costoenvioC > 0 and strCaractristica <> "home" order by dateFecha DESC';
							$resT = mysql_query($sqlT) or die (mysql_error());
							while ($rowT = mysql_fetch_array($resT)) {
								echo "<option value='".$rowT['idConcierto']."'>".$rowT['idConcierto']."-".$rowT['strEvento']."</option>";
							}							

						?>
						</select>
					</div>
				</div>
			</div><br>
			<div style="background-color:#EC1867; color:#fff; margin:20px 50px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				<strong>QUITAR IMG HOME</strong>
				<div class="row">
					<div class="col-md-10">
						<select id="concerts2" class="form-control">
							<option value="0">Seleccione un evento</option>
						<?php
							$fecha = date("Y-m-d");
							$sqlT = 'select * from Concierto where costoenvioC > 0 and strCaractristica = "home" order by dateFecha DESC';
							$resT = mysql_query($sqlT) or die (mysql_error());
							while ($rowT = mysql_fetch_array($resT)) {
								echo "<option value='".$rowT['idConcierto']."'>".$rowT['idConcierto']."-".$rowT['strEvento']."</option>";
							}							

						?>
						</select>
					</div>
				</div>
			</div><br> -->
			
			<table class = "table" style = 'background-color:#fff;'>
				<tr>
					<th colspan = '12' >
						<div class="row">
							<div class="col-md-7">
								ADMINITRAR BANNER HOME
							</div>
							<div class="col-md-1">
								<a href="?modulo=admin_home_tf"><button class="btn btn-primary">Administrar banners secundarios</button></a>
							</div>
							<div class="col-md-1"></div>
						</div>
					</th>
				</tr>
			<?php
				$fecha = date("Y-m-d");
				$sqlC = 'select * from Concierto where dateFecha >= "'.$fecha.'" and costoenvioC > 0 order by 1 DESC';
				$resC = mysql_query($sqlC) or die (mysql_error());
				$i=0;
				while($rowC = mysql_fetch_array($resC)){
					$sqlB = 'select * from banner where id_con = "'.$rowC['idConcierto'].'" ';
					$resB = mysql_query($sqlB) or die (mysql_error());
					$rowB = mysql_fetch_array($resB);
					
					if($rowB['id_con'] == $rowC['idConcierto']){
						$txt = '<i onclick = "adminBanner('.$rowC[idConcierto].' , 2)" class="fa fa-check-circle-o fa-2x" aria-hidden="true" style = "color:rgb(29,158,117);cursor:pointer;" ></i>';
					}else{
						$txt = '<i onclick = "adminBanner('.$rowC[idConcierto].' , 1)" class="fa fa-times-circle-o fa-2x" aria-hidden="true" style = "color:red;cursor:pointer;" ></i> ';
					}
					if($i==0){
						echo '	<tr>';
					}
			?>
									<td width = '33%' >
										<div id="producto" class="panel panel-default default2 lasotras">
											<div class="panel-heading heading2">
												<center><img src="https://www.ticketfacil.ec/ticket2/spadmin/<?php echo $rowC['strImagen'];?>" style = 'width:100px;' border="0"></center>
											</div>
											<div class="panel-body body2">
												<div class="name2"><?php echo $rowC['strEvento'];?></div><br/>
												<div class="name2"><?php echo $rowC['dateFecha'];?></div><br/>
												<div class="name2"><?php echo $rowC['strLugar'];?></div><br/>
												<center><div id = 'recibeRespuesta_<?php echo $rowC['idConcierto'];?>' ><?php echo $txt;?></div></center>
											</div>
										</div>
									</td>
				<?php
					if($i==2){
						echo '</tr>';
						$i=0;
					}else{
						$i++;
					}
				}
				?>
				
				<tr>
					<td colspan ='3'>
						EVENTOS NO VIGENTES
					</td>
				</tr>
				
				<?php
				$fecha = date("Y-m-d");
				$sqlC = 'select * from Concierto where dateFecha <= "'.$fecha.'"order by 1 DESC';
				$resC = mysql_query($sqlC) or die (mysql_error());
				$i=0;
				while($rowC = mysql_fetch_array($resC)){
					$sqlB = 'select * from banner where id_con = "'.$rowC['idConcierto'].'" ';
					$resB = mysql_query($sqlB) or die (mysql_error());
					$rowB = mysql_fetch_array($resB);
					
					if($rowB['id_con'] == $rowC['idConcierto']){
						$txt = '<i onclick = "adminBanner('.$rowC[idConcierto].' , 2)" class="fa fa-check-circle-o fa-2x" aria-hidden="true" style = "color:rgb(29,158,117);cursor:pointer;" ></i>';
					}else{
						$txt = '<i onclick = "adminBanner('.$rowC[idConcierto].' , 1)" class="fa fa-times-circle-o fa-2x" aria-hidden="true" style = "color:red;cursor:pointer;" ></i> ';
					}
					if($i==0){
						echo '	<tr>';
					}
			?>
									<td width = '25%' >
										<div id="producto" class="panel panel-default default2 lasotras">
											<div class="panel-heading heading2">
												<center><img src="https://www.ticketfacil.ec/ticket2/spadmin/<?php echo $rowC['strImagen'];?>" style = 'width:100px;' border="0"></center>
											</div>
											<div class="panel-body body2">
												<div class="name2"><?php echo $rowC['strEvento'];?></div><br/>
												<div class="name2"><?php echo $rowC['dateFecha'];?></div><br/>
												<div class="name2"><?php echo $rowC['strLugar'];?></div><br/>
												<center><div id = 'recibeRespuesta_<?php echo $rowC['idConcierto'];?>' ><?php echo $txt;?></div></center>
											</div>
										</div>
									</td>
				<?php
					if($i==2){
						echo '</tr>';
						$i=0;
					}else{
						$i++;
					}
				}
				?>
			</table>
			
		</div>
	</div>
<script>
	$('#concerts1').change(function () {
		var confirma = confirm('¿Seguro que desea colocar este evento?');
		var concert = $('#concerts1').val();
		if (confirma == true) {
			if (concert == '' || concert == 0) {
				alert('Debe seleccionar un evento!');
			}else{
				$.ajax({
					method:'POST',
					url:'spadmin/adminBanner2.php',
					data:{id_con:concert, action:1},
					success:function (response) {
						alert('Evento actualizado!');
					}
				})
			}
		}
	})
	$('#concerts2').change(function () {
		var confirma = confirm('¿Seguro que desea quitar este evento?');
		var concert = $('#concerts1').val();
		if (confirma == true) {
			if (concert == '' || concert == 0) {
				alert('Debe seleccionar un evento!');
			}else{
				$.ajax({
					method:'POST',
					url:'spadmin/adminBanner2.php',
					data:{id_con:concert, action:2},
					success:function (response) {
						alert('Evento actualizado!');
					}
				})
			}
		}
	})
	function adminBanner(id_con , ident){
		var txt = '';
		if(ident == 1){
			txt = 'Ingresara';
		}else{
			txt = 'Borrara';
		}
		alert('se ' +  txt  + ' el evento : '  + id_con);
		$.post("spadmin/adminBanner.php",{ 
			id_con : id_con , ident : ident
		}).done(function(data){
			$('#recibeRespuesta_'+id_con).html(data);
		});
	}
	function verDomicilio(id , evento , ident){
		$('#titulo2').html('Evento : ' + evento +  ' / factura : ' + id );
		$('#modalDetalleDomicilio').modal('show');
		$('#recibeDetalle2').html("<center><img src = 'imagenes/ajax-loader.gif' /></center>");
		$.post("spadmin/detalleDomicilio.php",{ 
			id : id , ident : ident
		}).done(function(data){
			$('#recibeDetalle2').html(data);
		});
	}
	
</script>