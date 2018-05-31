<?php
	session_start();
	// ini_set('display_startup_errors',1);
	// ini_set('display_errors',1);
	// error_reporting(-1);
	include '../enoc.php';
	$salida = $_REQUEST['salida'];
	$llegada = $_REQUEST['llegada'];
	$fecha = $_REQUEST['fecha_salida']; 
	$terminal_llega = $_REQUEST['terminal_llega'];
	$terminal = $_REQUEST['terminal'];
	
	$_SESSION['ciudad_salida_regreso'] = $salida;
	$_SESSION['ciudad_llegada_regreso'] = $llegada;
	
	
	$fecha_regreso = $_REQUEST['fecha_regreso'];
	$normales = $_REQUEST['normales'];
	$especiales = $_REQUEST['especiales'];
	$_SESSION['normales'] = $normales;
	$_SESSION['especiales'] = $especiales;
	
	if($_REQUEST['id_coop'] != 0){
		$id_coop = $_REQUEST['id_coop'];
		$filtro = 'and coop = "'.$id_coop.'"';
		$filtro2 = 'and r.coop = "'.$id_coop.'"';
		$filtroEscala = 'and id_cop = "'.$id_coop.'"';
	}else{
		$id_coop = 0;
		$filtro = '';
		$filtro2 = '';
		$filtroEscala = '';
		
	}
	
	$sql = 'select * from ruta where origen = "'.$salida.'" and destino = "'.$llegada.'" and id_ter = "'.$terminal.'" '.$filtro.' and fecha = "'.$fecha.'" ORDER BY `ruta`.`coop` , `ruta`.`hora` ASC';
	echo $sql."<br/>";
	$res = mysql_query($sql) or die (mysql_error());
	
	$sql2 = 'select * from ciudades where id = "'.$salida.'" ';
	$res2 = mysql_query($sql2) or die (mysql_error());
	$row2 = mysql_fetch_array($res2);
	
	$sql3 = 'select * from ciudades where id = "'.$llegada.'" ';
	$res3 = mysql_query($sql3) or die (mysql_error());
	$row3 = mysql_fetch_array($res3);
	
	$sql4 = 'select * from terminales where id = "'.$terminal.'" ';
	//echo $sql4;
	$res4 = mysql_query($sql4) or die (mysql_error());
	$row4 = mysql_fetch_array($res4);
	
	$sql5 = 'select * from terminales where id = "'.$terminal_llega.'" ';
	//echo $sql4;
	$res5 = mysql_query($sql5) or die (mysql_error());
	$row5 = mysql_fetch_array($res5);
	
?>
	<link rel="stylesheet" href="../font-awesome-4.6.3/css/font-awesome.min.css">
	<style>
		.triangulo_top_left {
			width: 0;
			height: 0;
			border-top: 100px solid #000; 
			border-right: 100px solid transparent;			
		}
		.pagare:hover{
			-webkit-box-shadow: 2px 2px 2px 3px rgba(0,0,0,0.75);
			-moz-box-shadow: 2px 2px 2px 3px rgba(0,0,0,0.75);
			box-shadow: 2px 2px 2px 3px rgba(0,0,0,0.75);
		}
	</style>
	<table class = 'table table-hover' style = 'background-color:#fff;color:rgb(82,172,227);min-width:600px;position: relative; z-index: 2000' >
		
<?php
	function RestarHoras($horaini,$horafin){
		$horai=substr($horaini,0,2);
		$mini=substr($horaini,3,2);
		$segi=substr($horaini,6,2);
		$horaf=substr($horafin,0,2);
		$minf=substr($horafin,3,2);
		$segf=substr($horafin,6,2);
		$ini=((($horai*60)*60)+($mini*60)+$segi);
		$fin=((($horaf*60)*60)+($minf*60)+$segf);
		$dif=$fin-$ini;
		$difh=floor($dif/3600);
		$difm=floor(($dif-($difh*3600))/60);
		$difs=$dif-($difm*60)-($difh*3600);
		return date("H-i",mktime($difh,$difm));

	}
	if(mysql_num_rows($res)>0){
		$num_escalas = 0;
		$nom_ciu_escala = '';
		
		while($row = mysql_fetch_array($res)){
			$id_ruta = $row['id'];
			if($especiales == ''){
				$precio_especial = 0;
			}else{
				$precio_especial = (($row['precio']*0.5)*$especiales);
			}
			
			$precio_normal =(($row['precio'])*$normales);
			
			// $sql1 = 'select * from horario where id_ruta  = "'.$row['id'].'" ';
			// //echo $sql1."<br/>";
			// $res1 = mysql_query($sql1) or die (mysql_error());
			// $row1 = mysql_fetch_array($res1);
			
			
			$sqlCo = 'select * from cooperativa where id  = "'.$row['coop'].'" ';
			$resCo = mysql_query($sqlCo) or die (mysql_error());
			$rowCo = mysql_fetch_array($resCo);
			
		//	while(){
			
				$sqlO = 'select * from ocupadas where id_ruta = "'.$row['id'].'" and fecha_salida = "'.$fecha.'" ';
		//		echo $sqlO."<br/>";
				$resO = mysql_query($sqlO) or die (mysql_error());
				$numAsientosOcupados = mysql_num_rows($resO);
				//echo $numreg;
				
				$sqlB = 'select * from bus where codigo = "'.$row['id_bus'].'" ';
				$resB = mysql_query($sqlB) or die (mysql_error());
				$rowB = mysql_fetch_array($resB);
				$numAsientosCreados = $rowB['asientos'];
				if($numAsientosOcupados >= $numAsientosCreados ){
					// echo $numAsientosOcupados.'<< >>'.$numAsientosCreados;
					// echo 'no hay';
				}else{
	?>
					<tr style='text-transform:capitalize;'>
						<td style = 'padding: 0px !important; ' width = '75%' >
							<table width = '100%' height = '100%'>
								<tr>
									<td>
										<img src = 'images/busVuelta.png'/>
									</td>
									<td>
										<span style='text-transform:capitalize;color:#58595B;font-family:helvetica;font-size:16px;'>
											<?php echo $rowCo['nom'];?>
										</span>
									</td>
									<td align = 'right' style = 'padding-right:15px'>
										<span style='text-transform:capitalize;color:#0386A4;font-family:helvetica;font-size:16px;'>
											BUS <?php echo $row['id_bus'];?>
										</span>
									</td>
								</tr>
								
								<tr>
									<td valign = 'top'>
										<table width = '100%' height = '100%'>
											<tr>
												<td valign = 'top' style = 'padding-top: 5px'>
													<span style='color:#fff;font-size:12px;background-color:#0386A4;padding: 5px;position: relative; left: -15px;'><?php echo $row['hora'];?></span>
												</td>
												<td valign = 'top'>
													<span style = 'color:#0386A4;'><?php echo $row2['nom'];?></span><br/>
													<span style='color:#6D6E70;font-size:12px;'><?php echo $row4['nombre'];?></span>
												</td>
											</tr>
										</table>
										
										
									</td>
									<td>
										<table>
											<tr>
												<td valign='top'>
													<?php
														$sqlEs = 'select * from escalas where id_ruta = "'.$row['id'].'"';
														//echo $sqlEs."<br/>";
														$resEs = mysql_query($sqlEs) or die (mysql_error());
														$numero_filas = mysql_num_rows($resEs);
														$escalas = '';
														if($numero_filas == 0){
															echo 'Sin Escalas';
														}else{
															$nomCiuEsc = '';
															while($rowEs = mysql_fetch_array($resEs)){
																$sqlCiuEsc = 'select nom from ciudades where id = "'.$rowEs['id_ciu_sal'].'" ';
																//echo $sqlCiuEsc."<br/>";
																$resCiuEsc = mysql_query($sqlCiuEsc) or die (mysql_error());
																$rowCiuEsc = mysql_fetch_array($resCiuEsc);
																$nomCiuEsc .= "- <span style='font-size:8px;color:rgb(172,170,171);'>".$rowCiuEsc['nom']." -</span><br/>";
															}
															$escalas = $numero_filas." Escalas";
															echo $escalas."<br/>".$nomCiuEsc;
														}
														
														
														?>
												</td>
												<td valign = 'top' style ='padding-left:10px;'>
													<?php echo $row3['nom'];?><br/>
													<span style='color:rgb(172,170,171);font-size:12px;'><?php echo $row5['nombre'];?></span><br/>
													<span style='color:rgb(172,170,171);font-size:12px;'><?php echo $row['hora_llega'];?></span>
												</td>
											</tr>
										</table>
									</td>
									<td align = 'right' style = 'color:#6D6E70;padding-right:15px' valign = 'top'>
										Duración : 	<br/><?php
											$horafin = $row['hora_llega'];
											$horaini = $row['hora'];
											echo RestarHoras($horaini,$horafin)." hrs"; 
											
										?>
									</td>
								</tr>
							</table>
						</td>
						<td style = 'background-color:#929497;;padding:0px;' >
							<table width = '100%' height = '100%' >
								<tr>
									<td style = 'background-image:url(images/tituloSup.png);background-repeat:no-repeat;font-size:12px;color:#fff;padding-top:2px;padding-bottom:2px;padding-left:5px;height:25px;background-size:90% 90%;text-align:left;'>
										Ultimos  
										<?php 
											//echo $numAsientosCreados."<<  >>".$numAsientosOcupados;
											$asiDisp = ($numAsientosCreados - $numAsientosOcupados); 
											echo $asiDisp; 
										?>
										Asientos
									</td>
								</tr>
								<tr>
									<td style = 'color:#fff;font-size:10px;padding-left:10px;text-align:left;'>
										<?php 
											echo 'Precio por Adulto USD '.$row['precio']."<br/>";
											echo '* '.$normales." Adultos USD ".($precio_normal)."<br/>";
											echo '* '.$especiales." Especiales USD ".($precio_especial)."<br/>";
											?>
										<?php echo "Total : USD ".number_format(($precio_especial+$precio_normal),2);?>
									</td>
								</tr>
								<tr>
									<td onclick='enviaBus(<?php echo $row['id'];?> , <?php echo $rowB['id'];?> , "<?php echo $fecha;?>" , "<?php echo $fecha_regreso;?>" , <?php echo $id_coop;?>)' style = 'text-align:left;'>
										<img class = 'pagar' src = 'images/pago.png' style = 'width: 70%;position: relative; left: -5px;cursor:pointer;'/>
										<span style = 'position:relative;color:#fff;top:-24px'>COMPRAR</span>
									</td>
								</tr>
								<tr>
									<td>
										<span class = 'glyphicon glyphicon-credit-card' style = 'color:#000;'></span>  <span style = 'color:#5E5F5E;font-size:10px;' >Hasta 24 meses plazo</span>
									</td>
								</tr>
							</table>
						</td>
					</tr>
	<?php
				}
			//}
	?>
		
	<?php
		}
		
	}else{
		$sqlEsc = 'select * from escalas where id_ter = "'.$terminal.'" and id_ciu_sal = "'.$salida.'" and id_ciu_lleg = "'.$llegada.'" '.$filtroEscala.' ';
	//	echo $sqlEsc."<br/>";
		$resEsc = mysql_query($sqlEsc) or die (mysql_error());
		if(mysql_num_rows($resEsc)>0){
			while($rowEsc = mysql_fetch_array($resEsc)){
				$sql = 'select r.id as id_ruta , 
						r.origen as ciu_salida , 
						r.destino as ciu_destino ,
						r.coop as id_coop , 
						r.precio as precio_ruta , 
						r.id_bus as id_bus , 
						r.hora_llega as hora_llega,
						e.id_ciu_sal as sali_escalas , 
						e.hora as escala_hora_salida ,
						e.precio as precio_escala 
						from ruta as r , escalas as e 
						where r.id = "'.$rowEsc['id_ruta'].'" '.$filtro2.' 
						and e.id_ruta = r.id
						and e.id = "'.$rowEsc['id'].'"
						';
			//	echo $sql."<<>><<>><br/>";
				$res = mysql_query($sql) or die (mysql_error());
				$row = mysql_fetch_array($res);
				
				
				if($especiales == ''){
					$precio_especial = 0;
				}else{
					$precio_especial = (($row['precio_escala']*0.5)*$especiales);
				}
				
				$precio_normal =(($row['precio_escala'])*$normales);
				
				
				// $sql1 = 'select * from horario where id_ruta  = "'.$row['id_ruta'].'" ';
				// //echo $sql1."<br/>";
				// $res1 = mysql_query($sql1) or die (mysql_error());
				// $TEC = mysql_fetch_array($res1);
				
				$sql2 = 'select * from ciudades where id = "'.$row['sali_escalas'].'" ';
			//	echo $sql2;
				$res2 = mysql_query($sql2) or die (mysql_error());
				$row2 = mysql_fetch_array($res2);
				
				$sql3 = 'select * from ciudades where id = "'.$llegada.'" ';
				$res3 = mysql_query($sql3) or die (mysql_error());
				$row3 = mysql_fetch_array($res3);
				
				$sql4 = 'select * from terminales where id = "'.$terminal.'" ';
				//echo $sql4;
				$res4 = mysql_query($sql4) or die (mysql_error());
				$row4 = mysql_fetch_array($res4);
				
				$sql5 = 'select * from terminales where id = "'.$terminal_llega.'" ';
				//echo $sql4;
				$res5 = mysql_query($sql5) or die (mysql_error());
				$row5 = mysql_fetch_array($res5);
				
				$sqlCo = 'select * from cooperativa where id  = "'.$row['id_coop'].'" ';
				$resCo = mysql_query($sqlCo) or die (mysql_error());
				$rowCo = mysql_fetch_array($resCo);
				
				
				$sqlO = 'select * from ocupadas where id_ruta = "'.$row['id_ruta'].'" and fecha_salida = "'.$fecha.'" ';
				//echo $sqlO."<br/>";
				$resO = mysql_query($sqlO) or die (mysql_error());
				$numAsientosOcupados = mysql_num_rows($resO);
				//echo $numreg;
				
				$sqlB = 'select * from bus where codigo = "'.$row['id_bus'].'" ';
				$resB = mysql_query($sqlB) or die (mysql_error());
				$rowB = mysql_fetch_array($resB);
				$numAsientosCreados = $rowB['asientos'];
				if($numAsientosOcupados >= $numAsientosCreados ){
					echo $numAsientosOcupados.'<< >>'.$numAsientosCreados;
					echo 'no hay';
				}else{
		?>
					<tr style='text-transform:capitalize;'>
						<td style = 'padding: 0px !important; ' width = '75%' >
							<table width = '100%' height = '100%'>
								<tr>
									<td>
										<img src = 'images/busVuelta.png'/>
									</td>
									<td>
										<span style='text-transform:capitalize;color:#58595B;font-family:helvetica;font-size:16px;'>
											<?php echo $rowCo['nom'];?>
										</span>
									</td>
									<td align = 'right' style='padding-right:15px'>
										<span style='text-transform:capitalize;color:#0386A4;font-family:helvetica;font-size:16px;'>
											BUS <?php echo $row['id_bus'];?>
										</span>
									</td>
								</tr>
								
								<tr>
									<td>
										<table width = '100%' height = '100%'>
											<tr>
												<td valign = 'top' style = 'padding-top: 5px'>
													<span style='color:#fff;font-size:12px;background-color:#0386A4;padding: 5px;position: relative; left: -15px;'><?php echo $row['escala_hora_salida'];?></span>
												</td>
												<td>
													<span style = 'color:#0386A4;'><?php echo $row2['nom'];?></span><br/>
													<span style='color:#6D6E70;font-size:12px;'><?php echo $row4['nombre'];?></span>
												</td>
											</tr>
										</table>
										
										
									</td>
									<td>
										<table>
											<tr>
												<td valign='top'>
													<?php
														$sqlEs = 'select * from escalas where id_ruta = "'.$row['id_ruta'].'" and id <> "'.$rowEsc['id'].'"';
														//echo $sqlEs."<br/>";
														$resEs = mysql_query($sqlEs) or die (mysql_error());
														$numero_filas = mysql_num_rows($resEs);
														if($numero_filas == 0){
															$escalas = 'Sin Escalas';
														}else{
															$nomCiuEsc = '';
															while($rowEs = mysql_fetch_array($resEs)){
																$sqlCiuEsc = 'select nom from ciudades where id = "'.$rowEs['id_ciu_sal'].'" ';
																//echo $sqlCiuEsc."<br/>";
																$resCiuEsc = mysql_query($sqlCiuEsc) or die (mysql_error());
																$rowCiuEsc = mysql_fetch_array($resCiuEsc);
																$nomCiuEsc .= "<span style='font-size:10px;color:rgb(172,170,171);'>".$rowCiuEsc['nom']."</span><br/>";
															}
															$escalas = $numero_filas." Escalas";
															echo $escalas."<br/>".$nomCiuEsc;
														}
														
														
														?>
												</td>
												<td valign = 'top' style ='padding-left:10px;'>
													<?php echo $row3['nom'];?><br/>
													<span style='color:rgb(172,170,171);font-size:12px;'><?php echo $row5['nombre'];?></span><br/>
													<span style='color:rgb(172,170,171);font-size:12px;'><?php echo $row['hora_llega'];?></span>
												</td>
											</tr>
										</table>
									</td>
									<td align = 'right' style = 'color:#6D6E70;padding-right:15px' valign = 'top'>
										Duración : 	<br/><?php
											$horafin = $row['hora_llega'];
											$horaini = $row['escala_hora_salida'];
											echo RestarHoras($horaini,$horafin)." hrs"; 
											
										?>
									</td>
								</tr>
							</table>
						</td>
						<td style = 'background-color:#929497;;padding:0px;' >
							<table width = '100%' height = '100%' >
								<tr>
									<td style = 'background-image:url(images/tituloSup.png);background-repeat:no-repeat;font-size:12px;color:#fff;padding-top:2px;padding-bottom:2px;padding-left:5px;height:25px;background-size:90% 90%;text-align:left;'>
										Ultimos  
										<?php 
											$asiDisp = ($numAsientosCreados - $numAsientosOcupados); 
											echo $asiDisp; 
										?>
										Asientos
									</td>
								</tr>
								<tr>
									<td style = 'color:#fff;font-size:10px;padding-left:10px;text-align:left;'>
										<?php 
											echo 'Precio por Adulto USD '.$row['precio_escala']."<br/>";
											echo '* '.$normales." Adultos USD ".($precio_normal)."<br/>";
											echo '* '.$especiales." Especiales USD ".($precio_especial)."<br/>";
											?>
										<?php echo "Total : USD ".number_format(($precio_especial+$precio_normal),2);?>
									</td>
								</tr>
								<tr>
									<td onclick='enviaBus(<?php echo $row['id_ruta'];?> , <?php echo $rowB['id'];?> , "<?php echo $fecha;?>" , "<?php echo $fecha_regreso;?>" , <?php echo $id_coop;?>)' style = 'text-align:left;'>
										<img class = 'pagar' src = 'images/pago.png' style = 'width: 70%;position: relative; left: -5px;cursor:pointer;'/>
										<span style = 'position:relative;color:#fff;top:-24px'>COMPRAR</span>
									</td>
								</tr>
								<tr>
									<td>
										<span class = 'glyphicon glyphicon-credit-card' style = 'color:#000;'></span>  <span style = 'color:#5E5F5E;font-size:10px;' >Hasta 24 meses plazo</span>
									</td>
								</tr>
							</table>
						</td>
					</tr>
		<?php
				}
			}
			
			
		}else{
			echo 'no hay disponiilidad';
		}
	}
	?>
	</table>
	<script>
		function enviaBus(id , id_bus , fecha , fecha_regreso , id_coop){
			var regr=0;
			if(fecha_regreso == ''){
				regr = 0;
			}else{
				regr = 1;
				
			}
			var normales = $('#normales').val();
			var especiales = $('#especiales').val();
			
			
			//window.open("?page=bus_paso_1&id="+id+"&id_bus="+id_bus+"&fecha="+fecha+"&fecha_regreso="+fecha_regreso+"&regr="+regr+"&id_coop="+id_coop+"",'','postwindow');
			window.location = "?page=bus_paso_2&id="+id+"&id_bus="+id_bus+"&fecha="+fecha+"&fecha_regreso="+fecha_regreso+"&regr="+regr+"&id_coop="+id_coop+"&n="+normales+"&e="+especiales;
		}
	</script>