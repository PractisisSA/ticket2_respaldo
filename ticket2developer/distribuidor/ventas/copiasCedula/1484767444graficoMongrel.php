<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
						<script type="text/javascript">
						  google.charts.load('current', {'packages':['corechart']});
						  google.charts.setOnLoadCallback(drawChart);
						  function drawChart() {
							var data = google.visualization.arrayToDataTable([
								['Mes', 'Ventas', 'Porcentaje'],
								<?php
									$sql1 = 'SELECT * FROM `Petsitter` where id = "'.$_SESSION['id_login'].'" ';
									$res1 = mysql_query($sql1) or die (mysql_error());
									$row1 = mysql_fetch_array($res1);
									
									$sql = 'select date(date_added) as fecha from `order` where id_petsitter = "'.$_SESSION['id_login'].'" group by YEAR(date_added) , MONTH(date_added)';
									
									$res = mysql_query($sql) or die (mysql_error());
									$numerodefilas=mysql_num_rows($res);
									$i=0;

									while ($fila = mysql_fetch_array($res)){
										
										
										
										$i++;
										$fecha = $fila['fecha'];
										$fechaExp = explode("-",$fecha);
										
										$mesActual = $fechaExp[1];
										
										if($mesActual == 1){
											$nomMes = 'Enero';
											$limDias = 31;
											$mesConsulta = 0;
										}
										
										if($mesActual == 2){
											$nomMes = 'Febrero';
											$limDias = 28;
											$mesConsulta = 0;
										}
										
										if($mesActual == 3){
											$nomMes = 'Marzo';
											$limDias = 31;
											$mesConsulta = 0;
										}
										
										if($mesActual == 4){
											$nomMes = 'Abril';
											$limDias = 30;
											$mesConsulta = 0;
										}
										
										if($mesActual == 5){
											$nomMes = 'Mayo';
											$limDias = 31;
											$mesConsulta = 0;
										}
										
										if($mesActual == 6){
											$nomMes = 'Junio';
											$limDias = 30;
											$mesConsulta = 0;
										}
										
										if($mesActual == 7){
											$nomMes = 'Julio';
											$limDias = 31;
											$mesConsulta = 0;
										}
										
										if($mesActual == 8){
											$nomMes = 'Agosto';
											$limDias = 31;
											$mesConsulta = 0;
										}
										
										if($mesActual == 9){
											$nomMes = 'Septiembre';
											$limDias = 30;
											$mesConsulta = 0;
										}
										
										if($mesActual == 10){
											$nomMes = 'Octubre';
											$limDias = 31;
											$mesConsulta = '';
										}
										
										if($mesActual == 11){
											$nomMes = 'Noviembre';
											$limDias = 30;
											$mesConsulta = '';
										}
										
										if($mesActual == 12){
											$nomMes = 'Diciembre';
											$limDias = 31;
											$mesConsulta = '';
										}
										
										$sql2 = 'select sum(value) as suma from `order` where id_petsitter = "'.$_SESSION['id_login'].'" and date_added >= "2016-'.$mesActual.'-01 00:00:00" and date_added <= "2016-'.$mesActual.'-'.$limDias.' 23:59:59" ';
									//	echo $sql2."<br/>";
										$res2 = mysql_query($sql2) or die (mysql_error());
										$row2 = mysql_fetch_array($res2);
										
										$sql3 = 'SELECT sum(total) as sumatoria FROM `order_product` WHERE `order_id` = "'.$row2['order_id'].'" ';
										$res3 = mysql_query($sql3) or die (mysql_error());
										$row3 = mysql_fetch_array($res3);
										$venta = $row2['suma'];
										$porcentaje = ($venta * $row1['descuento']);
										
										
										if ($i<$numerodefilas){ // No es la última fila
											echo "['".$nomMes."', ".$venta." , ".$porcentaje."],\n";
										}else{ // Sí es la última fila
											echo "['".$nomMes."', ".$venta." , ".$porcentaje."]\n";
										}
									}
								?>
							]);

							var options = {
							  title: 'Ventas Mensuales Petsitter',
							  hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
							  vAxis: {minValue: 0},
							  'width':1200,
							'height':400

							  
							};

							var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
							chart.draw(data, options);
						  }
						</script>
						 <div id="chart_div" style="width: 900px; height: 500px;"></div>