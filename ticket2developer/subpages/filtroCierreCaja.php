<?php
	session_start();
	include '../conexion.php';
	
	
	
	$fecha_desde = $_REQUEST['fecha_desde'];
	$fecha_hasta = $_REQUEST['fecha_hasta'];
	$hora_desde = $_REQUEST['hora_desde'];
	$hora_hasta = $_REQUEST['hora_hasta'];
	$tipo_pago = $_REQUEST['tipo_pago'];
	
	$eventos = $_REQUEST['eventos'];
	$pventas = $_REQUEST['pventas'];
	
	if($tipo_pago == ''){
		$filtro1 = '';
	}elseif($tipo_pago == 0){
		$filtro1 = 'and estadoPV = 0';
	}elseif($tipo_pago > 0){
		$filtro1 = 'and estadoPV = "'.$tipo_pago.'" ';
	}
	
	if($hora_desde == '__:__:__' && $hora_hasta = '__:__:__'){
		$filtro = '';
	}else{
		$filtro = 'and estado >= "'.$hora_desde.'" and estado <= "'.$hora_hasta.'" ';
	}
	if($_SESSION['perfil'] != 'SP'){
		$sql = 'select * from factura where tipo = 5 and fecha >= "'.$fecha_desde.'" and fecha <= "'.$fecha_hasta.'" '.$filtro1.' '.$filtro.' and id_dist = "'.$_SESSION['iduser'].'" and estadopagoPV = 1 order by id DESC';
	}else{
		if($pventas == ''){
			$filtroPV = '';
		}else{
			$filtroPV = 'and id_dist = "'.$pventas.'"';
		}
		
		if($eventos == ''){
			$filtroCon = '';
		}else{
			$filtroCon = 'and idConc = "'.$eventos.'"';
		}
			
		$sql = 'select * from factura where tipo = 5 and fecha >= "'.$fecha_desde.'" and fecha <= "'.$fecha_hasta.'" '.$filtro1.' '.$filtro.' '.$filtroPV.' '.$filtroCon.' and estadopagoPV = 1 order by id DESC';
	}
		
	//echo $sql."<br>";
	$res = mysql_query($sql) or die (mysql_error());
	
	
?>

	
	<style>
		html , body{
			overflow-x:hidden;
			font-family:corbel;
		}
		
		.pagados{
			background-color:#EEEEEE;
			font-size:10px;
		}
		.pagados_titulo{
			background-color:#fff;
			font-size:10px;
		}
		.pagados_2{
			background-color:#fff;
			font-size:10px;
		}
		
		.folder:hover{
			cursor:pointer;
			text-decoration:underline;
		}
	</style>
	
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">DETALLE </a></li>
			<li><a href="#tabs-2">REPORTE GENERAL</a></li>
		</ul>
		<div id="tabs-1">
			<table class="table table-border">
				<thead>
					<tr>
						<th class="pagados_titulo">#</th>
						<th class="pagados_titulo">#Transaccion</th>
						<!--<th class="pagados_titulo">Cliente</th>
						<th class="pagados_titulo">Cedula</th>-->
						<th class="pagados_titulo">Evento</th>
						<th class="pagados_titulo">Localidad</th>
						<th class="pagados_titulo">Fecha</th>
						
						<th class="pagados_titulo">Ticket</th>
						<th class="pagados_titulo">Valor</th>
						<th class="pagados_titulo">Desc.</th>
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
			$sumaValor1 = 0;
			$i=1;
			$sumaCuantos1 = 0;
			$sumaCuantos = 0;
			$sumaCostoEnvio=0;
			while($row = mysql_fetch_array($res)){
				
				$sqlCDPV = 'SELECT count(cdpv.id) as cuantos , cdpv.* FROM `cli_dom_pventa` as cdpv where id_fact = "'.$row['id'].'" ';
				$resCDPV = mysql_query($sqlCDPV) or die (mysql_error());
				$rowCDPV = mysql_fetch_array($resCDPV);
				if($rowCDPV['cuantos'] != 0){
					$sqlC = 'select envio from Concierto where idConcierto = "'.$row['idConc'].'" ';
					$resC = mysql_query($sqlC) or die (mysql_error());
					$rowC = mysql_fetch_array($resC);
					$costoEnvio = $rowC['envio'];
					
					$txtDom = '';
				}else{
					$costoEnvio = 0;
					$txtDom = '';
				}
				
				$sumaCostoEnvio += $costoEnvio;
				$_SESSION['sumaCostoEnvio'] = $sumaCostoEnvio;
				
				if($row['estadoPV'] == 0){
					$fpago = 'Efectivo';
				}else{
					$fpago = 'Tarjeta';
				}
				$sqlC = 'select strNombresC , strDocumentoC from Cliente where idCliente = "'.$row['id_cli'].'" ';
				$resC = mysql_query($sqlC) or die (mysql_error());
				$rowC = mysql_fetch_array($resC);
				
				$sqlCo = 'select strEvento , envio from Concierto where idConcierto = "'.$row['idConc'].'" ';
				$resCo = mysql_query($sqlCo) or die(mysql_error());
				$rowCo = mysql_fetch_array($resCo);
				
				$ndepo = $row['ndepo'];
				$expNdepo = explode("|",$ndepo);
				$cuantos = $expNdepo[0];
				$descuento = $expNdepo[1];
				$valor = $expNdepo[2];
				
				$sqlDT = 'SELECT sum(valor) as valor_pagado , idbol FROM `detalle_tarjetas` WHERE `id_fact` = "'.$row['id'].'" ORDER BY `id` DESC ';
				// echo $sqlDT."<br>";
				$resDT = mysql_query($sqlDT) or die (mysql_error());
				$rowDT = mysql_fetch_array($resDT);
				
				
				$sql4 = 'select * from Boleto where idBoleto = "'.$rowDT['idbol'].'" ';
				// echo $sql4."<br><br>";
				$res4 = mysql_query($sql4) or die(mysql_error());
				$row4 = mysql_fetch_array($res4);
				
				
				$sql10 = 'select * from descuentos where id = "'.$row4['id_desc'].'" ';
				// echo $sql10."<br>";
				$res10 = mysql_query($sql10) or die(mysql_error());
				$row10 = mysql_fetch_array($res10);
				
				if($row4['id_desc'] == 0){
					$nomDesc = 'Ninguno <br>  USD$  0';
				}else{
					$nomDesc = $row10['nom']."   <br>  USD$".$row10['val'];
				}
				
				$sqlL = 'select strDescripcionL from Localidad where idLocalidad = "'.$row['localidad'].'" ';
				// echo $sql4."<br><br>";
				$resL = mysql_query($sqlL) or die(mysql_error());
				$rowL = mysql_fetch_array($resL);
		?>
					<tr>
						<td class=" pagados" ><?php echo $i;?></td>
						<td class=" pagados" ><?php echo $row['id'];?></td>
						<!--<td class=" pagados" ><?php echo $rowC['strNombresC'];?></td>
						<td class=" pagados"  ><?php echo $rowC['strDocumentoC'];?></td>-->
						<td class=" pagados"><?php echo $rowCo['strEvento'];?></td>
						<td class=" pagados"><?php echo $rowL['strDescripcionL'];?></td>
						<td class=" pagados"><?php echo $row['fecha']."<br>".$row['estado'];?></td>
						
						<td class=" pagados" style = 'color:blue;text-align:center;font-size:13px;' >
							<?php 
								echo $cuantos;
								$sumaCuantos += $cuantos;
							?>   
							<i onclick = 'verDetalleCompra(<?php echo $row['id'];?> , "<?php echo $rowCo['strEvento'];?>")' class="fa fa-folder-open-o folder" aria-hidden="true"></i>
						</td>
						<td class=" pagados">
							<?php 
								echo number_format(($rowDT['valor_pagado']),2);
								$sumaValor += ($rowDT['valor_pagado'] + $costoEnvio);
							?>
						</td>
						<td class=" pagados" style = 'text-align:center;'><?php echo $nomDesc;?></td>
						<td class=" pagados">
							<?php
								echo $costoEnvio;
							?>
						</td>
						<td class=" pagados"><?php echo $fpago;?></td>
						<!--<td class=" pagados"><?php echo $row['tipo_tarjeta'];?></td>
						<td class=" pagados"><?php echo $row['tipo_evento'];?></td>-->
						<td class=" pagados" style = 'text-align:center;' ><i class="fa fa-check-square" aria-hidden="true" style = 'color:#1D9E74;' ></i></td>
					</tr>
		<?php
				$i++;
			}
			$sumaCostoEnvio1 = 0;
			
			if($_SESSION['perfil'] != 'SP'){
				$sql1 = 'select * from factura where tipo = 5 and fecha >= "'.$fecha_desde.'" and fecha <= "'.$fecha_hasta.'" '.$filtro1.' '.$filtro.' and id_dist = "'.$_SESSION['iduser'].'" and estadopagoPV = 0 order by id DESC';
			}else{
				if($pventas == ''){
					$filtroPV = '';
				}else{
					$filtroPV = 'and id_dist = "'.$pventas.'"';
				}
				
				if($eventos == ''){
					$filtroCon = '';
				}else{
					$filtroCon = 'and idConc = "'.$eventos.'"';
				}
					
				$sql1 = 'select * from factura where tipo = 5 and fecha >= "'.$fecha_desde.'" and fecha <= "'.$fecha_hasta.'" '.$filtro1.' '.$filtro.' '.$filtroPV.' '.$filtroCon.' and estadopagoPV = 0 order by id DESC';
			}
				
			// $sql1 = 'select * from factura where tipo = 5 and fecha >= "'.$fecha_desde.'" and fecha <= "'.$fecha_hasta.'" '.$filtro1.' '.$filtro.' and id_dist = "'.$_SESSION['iduser'].'" and estadopagoPV = 0 order by id desc';
			// echo $sql1."<br>";
			$res1 = mysql_query($sql1) or die (mysql_error());
			$j = ($i);
			while($row1 = mysql_fetch_array($res1)){
				
				
				$sqlCDPV = 'SELECT count(cdpv.id) as cuantos , cdpv.* FROM `cli_dom_pventa` as cdpv where id_fact = "'.$row1['id'].'" ';
				$resCDPV = mysql_query($sqlCDPV) or die (mysql_error());
				$rowCDPV = mysql_fetch_array($resCDPV);
				if($rowCDPV['cuantos'] != 0){
					$sqlC = 'select envio from Concierto where idConcierto = "'.$row1['idConc'].'" ';
					$resC = mysql_query($sqlC) or die (mysql_error());
					$rowC = mysql_fetch_array($resC);
					$costoEnvio1 = $rowC['envio'];
					$txtDom = '';
				}else{
					$costoEnvio1 = 0;
					$txtDom = '';
				}
				
				
				$sumaCostoEnvio1 += $costoEnvio1;
				
				$_SESSION['sumaCostoEnvio1'] = $sumaCostoEnvio1;
				
				
				$sqlDT1 = 'SELECT sum(valor) as valor_pagado , idbol FROM `detalle_tarjetas` WHERE `id_fact` = "'.$row1['id'].'" ORDER BY `id` DESC ';
				$resDT1 = mysql_query($sqlDT1) or die (mysql_error());
				$rowDT1 = mysql_fetch_array($resDT1);
				
				
				
				
				
				$sql41 = 'select * from Boleto where idBoleto = "'.$rowDT1['idbol'].'" ';
				// echo $sql41."<br><br>";
				$res41 = mysql_query($sql41) or die(mysql_error());
				$row41 = mysql_fetch_array($res41);
				
				
				$sql101 = 'select * from descuentos where id = "'.$row41['id_desc'].'" ';
				// echo $sql101."<br>";
				$res101 = mysql_query($sql101) or die(mysql_error());
				$row101 = mysql_fetch_array($res101);
				
				if($row41['id_desc'] == 0){
					$nomDesc1 = 'Ninguno <br>  USD$  0';
				}else{
					$nomDesc1 = $row101['nom']."   <br>  USD$".$row101['val'];
				}
				
				
				if($row1['estadoPV'] == 0){
					$fpago = 'Efectivo';
				}else{
					$fpago = 'Tarjeta';
				}
				
				$sqlCo = 'select strEvento , envio from Concierto where idConcierto = "'.$row1['idConc'].'" ';
				$resCo = mysql_query($sqlCo) or die(mysql_error());
				$rowCo = mysql_fetch_array($resCo);
				
				
				$ndepo1 = $row1['ndepo'];
				$expNdepo1 = explode("|",$ndepo1);
				$cuantos1 = $expNdepo1[0];
				$descuento1 = $expNdepo1[1];
				$valor1 = $expNdepo1[2];
				
				
				$sqlL1 = 'select strDescripcionL from Localidad where idLocalidad = "'.$row1['localidad'].'" ';
				// echo $sql4."<br><br>";
				$resL1 = mysql_query($sqlL1) or die(mysql_error());
				$rowL1 = mysql_fetch_array($resL1);
		?>
					<tr class = 'deposito_pendiente'  >
						<td class="pagados_2" >
							<?php echo $j;?>
							<input type = 'hidden' value = '<?php echo $row1['id']; ?>'  class = 'idBoleto' />
						</td>
						<td class="pagados_2"><?php echo $row1['id'];?></td>
						<!--<td class="pagados_2"><?php echo $row1['idCli'];?></td>
						<td class="pagados_2"><?php echo $row1['documentoHISB'];?></td>-->
						<td class="pagados_2"><?php echo $rowCo['strEvento'];?></td>
						<td class="pagados_2"><?php echo $rowL1['strDescripcionL'];?></td>
						<td class="pagados_2"><?php echo $row1['fecha'].'<br>'.$row1['estado'];?></td>
						
						<td class=" pagados_2" style = 'color:blue;text-align:center;font-size:13px;' >
							<?php 
								echo $cuantos1;
								$sumaCuantos1 += $cuantos1;
							?>  
							<i onclick = 'verDetalleCompra(<?php echo $row1['id'];?> , "<?php echo $rowCo['strEvento'];?>")' class="fa fa-folder-open-o folder" aria-hidden="true"></i>
						</td>
						<td class="pagados_2">
							<?php 
								echo number_format(($rowDT1['valor_pagado']),2);
								$sumaValor1 += ($rowDT1['valor_pagado'] + $costoEnvio1);
							?>
						</td>
						<td class = 'pagados_2' style = 'text-align:center;'><?php echo $nomDesc1;?></td>
						<td class = 'pagados_2'>
							<?php
								echo $costoEnvio1;
							?>
						</td>
						<td class="pagados_2"><?php echo $fpago;?></td>
						<!--<td class="pagados_2"><?php echo $row1['tipo_tarjeta'];?></td>
						<td class="pagados_2"><?php echo $row1['tipo_evento'];?></td>-->
						<td class="pagados_2" style = 'text-align:center;' ><i class="fa fa-times-circle-o" aria-hidden="true" style = "color:red;" ></i></td>
					</tr>
		<?php
				$j++;
			}
			// echo $sumaCostoEnvio."--".$sumaCostoEnvio1;
		?>
					<tr>
						
						
						<td class="" colspan = '7' style = 'background-color: #171A1B;color: #1E9F75;text-align: center; font-size: 20px' >
							<?php echo ($sumaCuantos);?>  TICKETS DEPOSITADOS  :   USD $
						</td>
						<td class="" style = 'background-color: #171A1B;color: #1E9F75;text-align: left; font-size: 20px' >
							<?php echo number_format(($sumaValor),2);?>
						</td>
						<td class="" >
							
						</td>
						<td class=""></td>
						
						
					</tr>
					
					<tr>
						
						<td class="" colspan = '7' style = 'background-color: #171A1B;color: #1E9F75;text-align: center; font-size: 20px'> 
							<?php echo ($sumaCuantos1);  ?> TICKETS PENDIENTES :   USD $
						</td>
						<td class="" style = 'background-color: #171A1B;color: #1E9F75;text-align: left; font-size: 20px' >
							<?php echo number_format(($sumaValor1),2);?>
						</td>
						<td class=""></td>
						<td class=""></td>
						
						
					</tr>
					
					<tr>
						<td class="" colspan = '7' style = 'background-color: #171A1B;color: #1E9F75;text-align: center; font-size: 20px'>
							<?php echo ($sumaCuantos + $sumaCuantos1);  ?>  TICKETS TOTAL RECAUDADO :  USD $
						</td>
						<td class="" style = 'background-color: #171A1B;color: #1E9F75;text-align: left; font-size: 20px' >
							<?php echo number_format(($sumaValor + $sumaValor1),2);?>
						</td>
						<td class=""></td>
						<td class=""></td>
						
						
					</tr>
				</tbody>
			</table>
		</div>
		<div id="tabs-2">
			<center>
				<div style = 'width:300px;' >
					<?php
						$sql3 = 'select f.* , sum(f.valor) as suma
								from factura as f
								where tipo = 5 
								and fecha >= "'.$fecha_desde.'" 
								and fecha <= "'.$fecha_hasta.'" '.$filtro1.' '.$filtro.' 
								and id_dist = "'.$_SESSION['iduser'].'" 
								and estadopagoPV = 0 
								group by estadoPV
								order by id desc';
						// echo $sql3;
						$res3 = mysql_query($sql3) or die (mysql_error());
						$suma1 = 0;
						while($row3 = mysql_fetch_array($res3)){
							if($row3['estadoPV'] == 0){
								$icono  = '<i class="fa fa-money" aria-hidden="true"></i>';
								$texto = 'EFECTIVO';
							}
							
							if($row3['estadoPV'] == 1){
								$icono  = '<i class="fa fa-cc-visa" aria-hidden="true"></i>';
								$texto = 'VISA';
							}
							
							if($row3['estadoPV'] == 2){
								$icono  = '<i class="fa fa-cc-diners-club" aria-hidden="true"></i>';
								$texto = 'DINNERS';
							}
							
							if($row3['estadoPV'] == 3){
								$icono  = '<i class="fa fa-cc-mastercard" aria-hidden="true"></i>';
								$texto = 'MASTERCARD';
							}
							
							if($row3['estadoPV'] == 4){
								$icono  = '<i class="fa fa-cc-discover" aria-hidden="true"></i>';
								$texto = 'DISCOVER';
							}
							
							if($row3['estadoPV'] == 5){
								$icono  = '<i class="fa fa-cc-amex" aria-hidden="true"></i>';
								$texto = 'AMEX';
							}
							$suma1 += $row3['suma'];
					?>
						<div class="input-group">
							<span class="input-group-addon" style = 'width:125px' >
								<?php echo $texto;?>
							</span>
							<input type="text" class="form-control" disabled readonly value = '<?php echo number_format(($row3['suma']),2);?>' style = 'text-align:center;background-color:#fff;' />
							<span class="input-group-addon" style = 'width:44px'>
								<?php
									echo $icono;
								?>
							</span>
						</div>
					<?php
						}
					?>
						<div class="input-group">
							<span class="input-group-addon" style = 'width:125px' >
								Envio
							</span>
							<input type="text" class="form-control" disabled readonly value = '<?php echo number_format(($sumaCostoEnvio1),2);?>' style = 'text-align:center;background-color:#fff;' />
							<span class="input-group-addon" style = 'width:44px'>
								<i class="fa fa-usd" aria-hidden="true"></i>
							</span>
						</div>

						<div class="input-group">
							<span class="input-group-addon" style = 'width:125px;color:red;' >
								PENDIENTE 
							</span>
							<input id = 'sumaValor' type="text" disabled readonly  class="form-control" value = '<?php echo number_format(($suma1 + ( $sumaCostoEnvio1)),2);?>' style = 'background-color: #171A1B;color: #1E9F75;text-align:center; font-size: 20px' />
							<span class="input-group-addon" style = 'width:44px' >
								<i class="fa fa-usd" aria-hidden="true"></i>
							</span>
						</div>
				</div>
			</center>
			<div class = 'row' >
				<div class = 'col-md-2' ></div>
				<div class = 'col-md-7' >
					BANCO : <input type = 'text' class = 'form-control' id = 'bco' placeholder = 'BANCO' /><br>
					FECHA : <input type = 'text' class = 'form-control' id = 'fec'  placeholder = 'FECHA' value = '<?php echo date("Y-m-d");?>' /><br>
					CUENTA : <input type = 'text' class = 'form-control' id = 'cta' placeholder = 'CUENTA' /><br>
					ENCARGADO : <input type = 'text' class = 'form-control' id = 'enc'  placeholder = 'ENCARGADO' /><br>
					Nº DE DEPOSITO : <input type = 'text' class = 'form-control' id = 'num' placeholder = 'Nº DE DEPOSITO' /><br>
				</div>
			</div>
			
			<center>
				<button id = 'enviaCierre' type="button" class="btn btn-default" onclick = 'enviaCierre()' >GRABAR CIERRE</button>
			</center>
			
			
			
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
			$( function() {
				$( "#tabs" ).tabs();
			});	
		</script>
	