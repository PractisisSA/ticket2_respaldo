<?php
	session_start();
	include '../conexion.php';
	
	
	
	$fecha_desde = $_REQUEST['fecha_desde'];
	$fecha_hasta = $_REQUEST['fecha_hasta'];
	
	
	
	$sql = 'select * from cierre where fec >= "'.$fecha_desde.'" and fec <= "'.$fecha_hasta.'" and id_dist = "'.$_SESSION['iduser'].'" order by id DESC';
	// echo $sql."<br>";
	$res = mysql_query($sql) or die (mysql_error());
	
	
?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
  <script>
  $( function() {
    $( "#accordion" ).accordion({
      collapsible: true,
	  active: false
    });
	
	
	$( ".tabs" ).tabs();
	
	
  } );
  </script>

	<div id="accordion">
		<?php
			$sumaDepositos = 0;
			while($row = mysql_fetch_array($res)){
				
				
		?>
			<h1 style = 'padding-left:30px;' ><?php echo "Numero de deposito : ".$row['id']."  USD $".$row['valor']."   fehca : ".$row['fec']?></h1>
			<div>
				<div class="tabs">
					<ul>
						<li><a href="#tabs-1_<?php echo $row['id'];?>">REPORTE GENERAL</a></li>
						<li><a href="#tabs-2_<?php echo $row['id'];?>">DETALLE</a></li>
					</ul>
					<div id="tabs-1_<?php echo $row['id'];?>">
						<div class = 'row' >
							<div class = 'col-md-2' ></div>
							<div class = 'col-md-7' >
								BANCO : <?php echo $row['bco'];?><br>
								FECHA : <?php echo $row['fec'];?><br>
								CUENTA : <?php echo $row['cta'];?><br>
								ENCARGADO : <?php echo $row['enc'];?><br>
								Nº DE DEPOSITO :<input id="num" type="text" name="num" placeholder="<?php echo $row['num'];?>"> <br>
								VALOR : <?php echo $row['valor'];?><br>
								<button onclick="editDeposit(<?php echo $row['id'];?>)">Enviar</button>
							</div>
						</div>
					</div>
					<div id="tabs-2_<?php echo $row['id'];?>">
						<?php
							$sql22 = 'select * from factura where tipo = 5 and fechaE = "'.$row['id'].'" ';
							// echo $sql22."<br>";
							$res22 = mysql_query($sql22) or die (mysql_error());
						?>
						<table class="table table-border">
							<thead>
								<tr>
									<th class="pagados_titulo">#</th>
									<th class="pagados_titulo">#Transaccion</th>
									<!--<th class="pagados_titulo">Cliente</th>
									<th class="pagados_titulo">Cedula</th>-->
									<th class="pagados_titulo">Evento</th>
									<th class="pagados_titulo">Fecha</th>
									<th class="pagados_titulo">Hora</th>
									<th class="pagados_titulo">Ticket</th>
									<th class="pagados_titulo">Valor</th>
									<th class="pagados_titulo">Envio</th>
									<th class="pagados_titulo">F Pago</th>
									<!--<th class="pagados_titulo">Tipo Tarj.</th>
									<th class="pagados_titulo">Tipo Trans.</th>-->
									<th class="pagados_titulo">Estado</th>
								</tr>
							</thead>
							<tbody>
					<?php
						$sumaValor = 0;
						$i=1;
						$sumaCuantos1 = 0;
						$sumaCuantos = 0;
						while($row22 = mysql_fetch_array($res22)){
							
							$sqlCDPV = 'SELECT count(cdpv.id) as cuantos , cdpv.* FROM `cli_dom_pventa` as cdpv where id_fact = "'.$row22['id'].'" ';
								$resCDPV = mysql_query($sqlCDPV) or die (mysql_error());
								$rowCDPV = mysql_fetch_array($resCDPV);
								if($rowCDPV['cuantos'] != 0){
									$sqlC = 'select envio from Concierto where idConcierto = "'.$row22['idConc'].'" ';
									$resC = mysql_query($sqlC) or die (mysql_error());
									$rowC = mysql_fetch_array($resC);
									$costoEnvio1 = $rowC['envio'];
									$txtDom = '';
								}else{
									$costoEnvio1 = 0;
									$txtDom = '';
								}
								
								
							if($row22['estadoPV'] == 0){
								$fpago = 'Efectivo';
							}else{
								$fpago = 'Tarjeta';
							}
							$sqlC = 'select strNombresC , strDocumentoC from Cliente where idCliente = "'.$row22['id_cli'].'" ';
							$resC = mysql_query($sqlC) or die (mysql_error());
							$rowC = mysql_fetch_array($resC);
							
							$sqlCo = 'select strEvento , envio from Concierto where idConcierto = "'.$row22['idConc'].'" ';
							$resCo = mysql_query($sqlCo) or die(mysql_error());
							$rowCo = mysql_fetch_array($resCo);
							
							$ndepo = $row22['ndepo'];
							$expNdepo = explode("|",$ndepo);
							$cuantos = $expNdepo[0];
							$descuento = $expNdepo[1];
							$valor = $expNdepo[2];
							
							
					?>
								<tr>
									<td class=" pagados" ><?php echo $i;?></td>
									<td class=" pagados" ><?php echo $row22['id'];?></td>
									<!--<td class=" pagados" ><?php echo $rowC['strNombresC'];?></td>
									<td class=" pagados"  ><?php echo $rowC['strDocumentoC'];?></td>-->
									<td class=" pagados"><?php echo $rowCo['strEvento'];?></td>
									<td class=" pagados"><?php echo $row22['fecha'];?></td>
									<td class=" pagados"><?php echo $row22['estado'];?></td>
									<td class=" pagados" style = 'color:blue;text-align:center;font-size:13px;' >
										<?php 
											echo $cuantos;
											$sumaCuantos += $cuantos;
											$sumaValor += ($row22['valor'] + $costoEnvio1 );
										?>   
										<!--<i onclick = 'verDetalleCompra(<?php echo $row22['id'];?> , "<?php echo $rowCo['strEvento'];?>")' class="fa fa-folder-open-o folder" aria-hidden="true"></i>-->
									</td>
									<td class=" pagados">
										<?php 
											echo number_format(($row22['valor']),2);
										?>
									</td>
									<td class=" pagados">
										<?php 
											echo number_format(($costoEnvio1),2);
										?>
									</td>
									<td class=" pagados"><?php echo $fpago;?></td>
									<!--<td class=" pagados"><?php echo $row22['tipo_tarjeta'];?></td>
									<td class=" pagados"><?php echo $row22['tipo_evento'];?></td>-->
									<td class=" pagados" style = 'text-align:center;' ><i class="fa fa-check-square" aria-hidden="true" style = 'color:#1D9E74;' ></i></td>
								</tr>
					<?php
							$i++;
						}
					?>
					
								<tr>
									<td class=""></td>
									<td class=""></td>
									<td class=""></td>
									<td class=""></td>
									<td class=""></td>
									
									<td class=""><?php echo ($sumaCuantos);  ?> </td>
									<td colspan = '2' class="" style = 'background-color: #171A1B;color: #1E9F75;text-align: center; font-size: 20px' >
										<?php echo $sumaValor;?>
									</td>
									<td class=""></td>
									<td class=""></td>
									
									
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php
				// echo $row['valor'];
				$sumaDepositos += $sumaValor;
			}
			//
		?>
		<div style = 'background-color: #171A1B;color: #1E9F75;text-align: left; font-size: 20px;padding-left:4vw;padding-rigth:20px;padding-top:5px;padding-bottom:5px;' >
			Total Recaudado : $<?php echo number_format(($sumaDepositos),2);?>
		</div>
	</div>
	
	
	<div class="modal fade" id="modalDetalle" role="dialog" style = 'display:none;' data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog" style = 'width:75%;'>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" >
						<span id = 'titulo' style = 'text-transform:uppercase;'></span>     <button type="button" class="btn btn-default" onclick="tableToExcel('recibeEventos', 'REPORTE PAYPAL / STRIPE')"> <i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> EXCEL</button>
					</h4>
				</div>
				<div class="modal-body" id = 'recibeDetalle'>
					<center><img src = 'imagenes/ajax-loader.gif' /></center>
				</div>
				<div class="modal-footer">
					<!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
				</div>
			</div>
		</div>
	</div>
		
		<script>
			function verDetalleCompra(id , evento){
				var ident = 2;
				$('#titulo').html('Evento : ' + evento +  ' / factura : ' + id );
				$('#modalDetalle').modal('show');
				$('#recibeDetalle').html("<center><img src = 'imagenes/ajax-loader.gif' /></center>");
				$.post("spadmin/detallePagosPV.php",{ 
					id : id , ident : ident
				}).done(function(data){
					$('#recibeDetalle').html(data);
				});
			}
			function editDeposit(id) {
				console.log(id);
				var deposit = $('#num').val();
				console.log(deposit);

				if (deposit == '') {
					alert('Debe insertar un numero de deposito')
				}else{
					$.post("spadmin/editDeposit.php",{ 
					deposit : deposit, id : id
				}).done(function(data){
					if (data == 1) {
						alert('Numero de deposito insertado con exito');
						location.reload();
					}else{
						alert('Hubo un error insertando el deposito');
					}
				});
				}

			}
			
		</script>
 