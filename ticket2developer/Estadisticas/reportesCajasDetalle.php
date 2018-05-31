<?php
	session_start();
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include 'conexion.php';
	$id = $_SESSION['iduser'];
	$hoy = date('Y-m-d');
	
	echo '<input type="hidden" id="data" value="25" />';
	$hoy = date("Y-m-d");
	echo $_SESSION['iduser'];
?>
<script>
		$( document ).ready(function() {
			console.log( "ready!" );
			$("#evento_distri").change(function(e){
				
				var idConcierto = $('#evento_distri').val();
				var tipo_emp = $('#tipo_emp').val();
				var ruta = '';
				if(tipo_emp == 2){
					ruta = 'Estadisticas/ajax/cadenaTF.php';
				}else{
					ruta = 'Estadisticas/ajax/cadenaTF2.php';
				}
				if(idConcierto == ''){
					$('#recibeCadena').html('');
				}else{
					$('#loaderGif').css('display','block');
					$.post(ruta,{ 
						idConcierto : idConcierto 
					}).done(function(data){
						$('#loaderGif').css('display','none');
						$('#recibeCadena').html(data);
					});

				}
			});
		});
		
		function verVentasGlobales(){
			$('#recibeCadena').html('');
			$('#loaderGif').css('display','block');
			$.post("Estadisticas/ajax/ventasGlobales.php",{ 
				
			}).done(function(data){
				$('#loaderGif').css('display','none');
				$('#recibeCadena').html(data);
			});

		
		}
	</script>
	<body onload = '$("#menu25").addClass("allmenuactive");'>
		<input type="hidden" id="data" value="25" />
		<div style="margin:10px -10px;">
			<script type="text/javascript" src="js/jquery.numeric.js"></script>
			<div style="background-color:#171A1B; padding-right:3%;padding-left: 2%">
				<div class = 'row'>
					<div class = 'col-md-12'>
						<h3 style = 'padding-top: 10px;padding-bottom: 10px;padding-left: 10px;padding-right: 10px;background-color: #ED1568;color: #000'>
							REPORTES DISTRIBUIDOR
						</h3>
					</div>
				</div>
				
				<div class = 'row'>
					<div class = 'col-md-1'></div>
					<div class = 'col-md-5' style = 'color:#000;'>
						<select class = 'form-control' id = 'evento_distri' >
							<option value = ''>Seleccione un Evento</option>
							<?php
								
								$sql = 'select c.idConcierto  , u.strObsCreacion , d.conciertoDet , c.strEvento
										from Usuario as u , detalle_distribuidor as d , Concierto as c
										where idUsuario = "'.$_SESSION['iduser'].'" 
										and u.strObsCreacion = d.idDis_Det
										and d.conciertoDet = c.idConcierto 
										
										and idConcierto >= 73
										order by idConcierto DESC 
										';
								$res = mysql_query($sql) or die (mysql_error());
								while($row = mysql_fetch_array($res)){
							?>	
									<option value = '<?php echo $row['idConcierto'];?>' ><?php echo $row['strEvento'];?>  [<?php echo $row['idConcierto'];?>]</option>
							<?php
								}
							?>
						</select>
						
						
						<center>
							<img src="imagenes/load22.gif" id="loaderGif" style="display: none;background-color:#fff;">
						</center>
						
						
					</div>
					<div class = 'col-md-5' style = 'color:#000;'>
						<button type="button" class="btn btn-primary" onclick = 'verVentasGlobales()' >VER VENTAS GLOBALES</button>
					</div>
					<div class = 'col-md-1'></div>
				</div>
				
				<br/>
				<div id = 'recibeCadena' style = 'background-color:#fff;' > 
							
						</div>
			</div>
			
		</div>
		<?php
			echo "<input type = 'hidden' id = 'tipo_emp' value = '".$_SESSION['tipo_emp']."'  />";
		?>

	</body>
	