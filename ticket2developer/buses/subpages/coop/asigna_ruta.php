<link rel="stylesheet" type="text/css" href="http://ticketfacil.ec/ticket2/js/jquery.datetimepicker.css"/>
<script src="http://ticketfacil.ec/ticket2/js/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$('.fecha').datetimepicker({
		timepicker: false,
		minDate:0,
		// mask:true,
		format:'Y/m/d'
	});
	$('.hora').datetimepicker({
		datepicker:false,
		mask: true,
		format:'H:i'
	});
</script>
<?php
	include '../../enoc.php';
	$esc = $_REQUEST['esc'];
	
	$input  = array($esc);
	$reversed = array_reverse($esc);
	

	print_r($input);
	
	print_r($reversed);
	
	
	
	$expParadas = count(explode("@",$esc));
	$exp = explode("@",$esc);
	
	$ciudadSalida = $_REQUEST['ciudadSalida'];
	$ciudadDestino = $_REQUEST['ciudadDestino'];
	
	$ciuExp = explode("|",$ciudadSalida);
	$id_CiudadSalida = $ciuExp[0];
	
	$ciuExp1 = explode("|",$ciudadDestino);
	$id_CiudadDestino = $ciuExp1[0];
	
	
	$m=0;
	$ruta = "<table class = 'table' style = 'color:#fff;'>";
	$hoy = date("Y-m-d");
	for($i=0;$i<=count($exp);$i++){
		
		for($j=1;$j<=count($exp)+1;$j++){
			//echo $i."<<>>".$j."<br>";
			$m++;
			if(($j>$i) && $exp[$j]!=''){
				
				$nomCiu = explode("|",$exp[$i]);
				$nomCiu1 = explode("|",$exp[$j]);
				$nombre_ciudad = $nomCiu[1];
				$nombre_ciudad1 = $nomCiu1[1];
				
				
				if(($nomCiu[0] == $id_CiudadSalida) && ($nomCiu1[0] == $id_CiudadDestino) ){
					$color = 'background-color:#ccc;';
					$verificador = '<input type = "text" class = "verificador" value = "1" style = "color:#000;width:50px;" />';
				}else{
					$color = '';
					$verificador = '<input type = "text" class = "verificador" value = "0" style = "color:#000;width:50px;"  />';
				}
				
				
				$ruta.= "
					<tr class = 'cada_ruta' style = '".$color."'>
						<td>
							<table width = '100%' style = 'color:#fff;height: 110px;'>
								<tr>
									<td>
										Salida.<br>
									</td>
								</tr>
								
								<tr>
									<td>
										Llegada
									</td>
								</tr>
								
								<tr>
									<td>
										".$verificador."
									</td>
								</tr>
							</table>
						</td>
						<td>
							<table width = '100%' style = 'color:#fff;height: 110px;text-transform:uppercase;'>
								<tr>
									<td>
										".$nombre_ciudad."<br>
										<input type='text' class = 'ciudad_salida' value = '".$nomCiu[0]."' style = 'color:#000;width:50px;'/>
									</td>
								</tr>
								
								<tr>
									<td>
										".$nombre_ciudad1."<br>
										<input type='text' class = 'ciudad_destino' value = '".$nomCiu1[0]."' style = 'color:#000;width:50px;'/>
									</td>
								</tr>
							</table>
						</td>
						<td>
							<table width = '100%' style = 'color:#fff;'>
								<tr>
									<td style = 'width: 150px'>
										Terminal Salida
										<select class = 'form-control terminal_salida' style = 'width: 150px'>";
											$idCiu1 = explode("|",$exp[$i]);
											$id_ciu1 = $idCiu1[0];
											$sqlT1 = 'select * from terminales where id_ciu = "'.$id_ciu1.'" order by nombre asc';
											
											$resT1 = mysql_query($sqlT1) or die (mysql_error());
											while($rowT1 = mysql_fetch_array($resT1)){
												$ruta.= "<option value = '".$rowT1['id']."'>".$rowT1['nombre']."</option>";
											}
							$ruta.= "   </select>
									</td>
								</tr>
								
								<tr>
									<td style = 'width: 150px'>
										Terminal Llegada
										<select class = 'form-control terminal_destino' style = 'width: 150px'>";
											$idCiu = explode("|",$exp[$j]);
											$id_ciu = $idCiu[0];
											$sqlT = 'select * from terminales where id_ciu = "'.$id_ciu.'" order by nombre asc';
											$resT = mysql_query($sqlT) or die (mysql_error());
											while($rowT = mysql_fetch_array($resT)){
												$ruta.= "<option value = '".$rowT['id']."'>".$rowT['nombre']."</option>";
											}
							$ruta.= "   </select>
									</td>
								</tr>
							</table>
						</td>
						<td>
							<table width = '100%' style = 'color:#fff;height: 110px;'>
								<tr>
									<td style = 'width:100px;'>
										Hora S.<br>
										<input type='text' value = '08:00' class='hora hora_salida inputlogin form-control' placeholder='00:00' style = 'width:100px;'/>
									</td>
								</tr>
								
								<tr>
									<td style = 'width:100px;'>
										Hora Ll.<br>
										<input type='text' value = '18:00' class='hora hora_destino inputlogin form-control' placeholder='00:00' style = 'width:100px;'/>
									</td>
								</tr>
							</table>
						</td>
						<td>
							<table width = '100%' style = 'color:#fff;height: 110px;'>
								<tr>
									<td style = 'width:100px;'>
										fecha S.<br>
										<input type='text' class='fecha fecha_salida inputlogin form-control' placeholder='YYYY/MM/DD' style = 'width:100px;' value = '".$hoy."'/>
									</td>
								</tr>
								
								<tr>
									<td style = 'width:100px;'>
										fecha Ll.<br>
										<input type='text' class='fecha fecha_destino inputlogin form-control' placeholder='YYYY/MM/DD' style = 'width:100px;' value = '".$hoy."' />
									</td>
								</tr>
							</table>
						</td>
						<td style = 'text-align:center;vertical-align:middle;'>
							<input type='text' class='inputlogin form-control precios' placeholder='Precio : 10 USD$'/>
						</td>
					</tr>";
			}else{
				//$ruta.= $sali."<<>>".$exp[$j]."<br><br>";
			}
		}
		
	}
	$ruta .= "	<tr>
					<td colspan = '6'>
						<button type='button' class='btn btn-primary' onclick = 'grabaRutas()' >Grabar</button>
					</td>
				</tr>
			</table>";
	// $ruta.= $sali."<<>>".$dest."<br><br>";
	
	echo $ruta;
?>
<script>
	function grabaRutas(){
		var verificador = '';
		var ciudad_salida = '';
		var services = '';
		var ciudad_destino = '';
		var terminal_salida = '';
		var terminal_destino = '';
		var hora_salida = '';
		var hora_destino = '';
		var fecha_salida = '';
		var fecha_destino = '';
		var precios = '';
		var permite_pasar = 0;
		$('.cada_ruta').each(function(){
			verificador = $(this).find('.verificador').val(); 
			ciudad_salida = $(this).find('.ciudad_salida').val(); 
			ciudad_destino = $(this).find('.ciudad_destino').val(); 
			terminal_salida = $(this).find('.terminal_salida').val(); 
			terminal_destino = $(this).find('.terminal_destino').val(); 
			hora_salida = $(this).find('.hora_salida').val(); 
			hora_destino = $(this).find('.hora_destino').val(); 
			fecha_salida = $(this).find('.fecha_salida').val(); 
			fecha_destino = $(this).find('.fecha_destino').val(); 
			precios = $(this).find('.precios').val(); 
			
			if(hora_salida == ''){
				alert('Ingrese una hora de salida');
			}
			
			if(hora_destino == ''){
				alert('Ingrese una hora de llegada');
			}
			
			if(precios == ''){
				alert('Ingrese una precio ');
			}
			
			if(hora_salida == '' || hora_destino == '' || precios == ''){
				permite_pasar = 0;
			}else{
				services += verificador +'@'+ ciudad_salida +'@'+ ciudad_destino +'@'+ terminal_salida +'@'+ terminal_destino
				+'@'+ hora_salida +'@'+ hora_destino +'@'+ fecha_salida +'@'+ fecha_destino +'@'+ precios +'|' ;
				permite_pasar = 1;
			}
			
		});
		var servicesFormatted = services.substring(0, services.length - 1);
		var bus_cooperativa = $('#bus_cooperativa').val();
		//alert(servicesFormatted);
		if(permite_pasar == 1){
			$.post("subpages/coop/grabaRuta.php",{ 
				servicesFormatted : servicesFormatted , bus_cooperativa : bus_cooperativa
			}).done(function(data){
				alert(data)			
			});
		}
	}
</script>