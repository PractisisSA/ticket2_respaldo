

<?php
	session_start();
	include '../conexion.php';
	
	
	
	function ReemplazarTildes($texto){
		$texto=str_replace("á","&aacute;",$texto);
		$texto=str_replace("é","&eacute;",$texto);
		$texto=str_replace("í","&iacute;",$texto);
		$texto=str_replace("ó","&oacute;",$texto);
		$texto=str_replace("ú","&uacute;",$texto);
		$texto=str_replace("ñ","&ntilde;",$texto);
		$texto=str_replace("Á","&Aacute;",$texto);
		$texto=str_replace("É","&Eacute;",$texto);
		$texto=str_replace("Í","&Iacute;",$texto);
		$texto=str_replace("Ó","&Oacute;",$texto);
		$texto=str_replace("Ú","&Uacute;",$texto);
		$texto=str_replace("Ñ","&Ntilde;",$texto);
		return $texto;
	}
	
	
	$idCon = $_REQUEST['evento'];
	$tipo = $_REQUEST['tipo'];
	
	if($idCon == 0){
		$filtro == '';
	}else{
		$filtro = 'and idConc = "'.$idCon.'"';
	}
	
	$tipo_pago = $_REQUEST['tipo_pago'];
	
	if($tipo_pago == ''){
		$queryTipo = '';
	}elseif($tipo_pago == 1){
		$queryTipo = 'and  impresion_local = "1"';
	}elseif($tipo_pago == 0){
		$queryTipo = 'and  impresion_local = "0"';
	}
	
	
	$desde = $_REQUEST['desde'];
	
	if($desde == '' ){
		$squeryDesde = '';
	}else{
		$squeryDesde = 'and fecha >= "'.$desde.' 00:00:00"';
	}
	$hasta = $_REQUEST['hasta'];
	
	if($hasta == ''){
		$queryHasta = '';
	}else{
		$queryHasta = 'and fecha <= "'.$hasta.' 23:59:59"';
	}
	
	
	$sql = '
				SELECT * 
				FROM factura 
				WHERE (tipo = 1 || tipo = 3 || tipo = 4) 
				'.$filtro.' 
				'.$queryTipo.'  
				'.$squeryDesde.'
				'.$queryHasta.'
				order by id DESC
			'; 
	 // echo $sql."hola";
	$res = mysql_query($sql) or die(mysql_error());
	$sumaPrecio = 0;
	?>
	
	<!--<table >
		<tr>
			<td>TIPO</td>
			<td>CLIENTE</td>
			<td>CEDULA</td>
			<td>EVENTO</td>
			<td>FECHA</td>
			<td>HORA</td>
			<td># TICKETS</td>
			<td>VALOR</td>
			
			<td>ENVIO</td>
			<td>TOTAL</td>
			<td>Ver</td>
			<td>Estado</td>
		</tr>-->
	
	<?php
	$idBol = '';
	
	$suma_valor_boletos = 0;
	$suma_precio_comision = 0;
	$suma_envio = 0;
	$suma_precioComiTotal = 0;
	
	while($row = mysql_fetch_array($res)){
		// echo $row['id']."<br>";
		if($row['tipo'] == 1){
			$txtF = 'D';
		}elseif($row['tipo'] == 3){
			$txtF = 'P';
		}elseif($row['tipo'] == 4){
			$txtF = 'S';
		}
		
		
		
		if($row['tipo'] == 1){
			$ident = 0;
			$pago = 'Transferencia';
		}elseif($row['tipo'] == 3){
			$ident = 1;
			$pago = 'paypal';
		}elseif($row['tipo'] == 4){
			$ident = 2;
			$pago = 'stripe';
		}
		
		if($row['tipo'] == 1){
			$filtro1 = 11;
			
		}else{
			$filtro1 = 0;
		}
		
		$sql1 = 'SELECT strEvento , envio ,  porcpaypal , valpaypal , porcstripe , valstripe , porce_transfer , comis_transfer FROM Concierto WHERE idConcierto = "'.$row['idConc'].'" ';
		$res1 = mysql_query($sql1) or die(mysql_error());
		$row1 = mysql_fetch_array($res1);
		
		$sql2 = 'SELECT strDescripcionL FROM Localidad WHERE idLocalidad = "'.$row['localidad'].'" ';
		$res2 = mysql_query($sql2) or die(mysql_error());
		$row2 = mysql_fetch_array($res2);
		
		$sql3 = 'SELECT * FROM Cliente WHERE idCliente = "'.$row['id_cli'].'" ';
		$res3 = mysql_query($sql3) or die(mysql_error());
		$row3 = mysql_fetch_array($res3);
		
		
		$sql4 = 'SELECT count(id) as cuantos , sum(valor) as total FROM detalle_tarjetas WHERE id_fact = "'.$row['id'].'" ';
		// echo $sql4."<br>";
		$res4 = mysql_query($sql4) or die(mysql_error());
		$row4 = mysql_fetch_array($res4);
		
		
		$sqlDeT = '	SELECT l.strDateStateL as puerta , b.serie_localidad as serie , dt.idbol
					FROM detalle_tarjetas as dt , Boleto as b , Localidad as l 
					WHERE id_fact = "'.$row['id'].'" 
					and dt.idbol = b.idBoleto 
					and l.idLocalidad = b.idLocB ';
		// echo $sql4."<br>";
		$resDeT = mysql_query($sqlDeT) or die(mysql_error());
		$idBol = '';
		$asientos = "[ ";
		while($rowDeT = mysql_fetch_array($resDeT)){
		
			$asientos .= $rowDeT['puerta']."  ".$rowDeT['serie']." / ";
			
			$idBol .= $rowDeT['idbol']."|";
		
		}
		$asientos .= " ]";
		
		if($_SESSION['perfil'] != 'Distribuidor_impresiones'){
			if($row['tipo'] == 1){
				$validaEnvio = $row['pventa'];
			}else{
				$validaEnvio = $row['ndepo'];
			}
			if($validaEnvio == 1){
				$envio = $row1['envio'];
				if($row['impresion_local'] == 1){
					$tipoEstilo = "color:green;font-weight:bold;text-decoration:underline;cursor:pointer;";
				}else{
					$tipoEstilo = "color:red;font-weight:bold;text-decoration:underline;cursor:pointer;";
				}
				$btnDomicilio = 'onclick="verDomicilio('.$row['id'].' , \''.$row1['strEvento'].'\' , '.$ident.' , '.$filtro1.')"';
			}else{
				$envio = 0;
				$tipoEstilo = "color:blue;font-weight:bold;text-decoration:underline;cursor:pointer;";
				$btnDomicilio = 'onclick="verDomicilio('.$row['id'].' , \''.$row1['strEvento'].'\' , '.$ident.' , '.$filtro1.')"';
			}
		}else{
			
			if($row['tipo'] == 1){
				$validaEnvio = $row['pventa'];
			}else{
				$validaEnvio = $row['ndepo'];
			}
			
			
			if($validaEnvio == 1){
				if($row['impresion_local'] == 1){
					$tipoEstilo = "color:green;font-weight:bold;text-decoration:underline;cursor:pointer;";
				}else{
					$tipoEstilo = "color:red;font-weight:bold;text-decoration:underline;cursor:pointer;";
				}
				$envio = $row1['envio'];
				
				$btnDomicilio = 'onclick="verDomicilio('.$row['id'].' , \''.$row1['strEvento'].'\' , '.$ident.' , '.$filtro1.')"';
			}else{
				$envio = 0;
				$tipoEstilo = "color:red;font-weight:bold;text-decoration:underline;cursor:pointer;";
				$btnDomicilio = 'onclick="verDomicilio('.$row['id'].' , \''.$row1['strEvento'].'\' , '.$ident.' , '.$filtro1.')"';
			}
		}
		if($row['tipo'] == 4 || $row['tipo'] == 1){
			$valor = $row4['total'];
		}else{
			$valor = $row['valor'];
		}
		
		
		
		if($row['tipo'] == 1){
			$valor_boletos = ($valor);
		
			$comisionPaypal = $row1['porce_transfer'];
		
			
			if($row['pventa'] == 1){
				$precioCom = (((($valor + $envio) * $comisionPaypal)/100) + $row1['comis_transfer']);
				$precioConComision = ($valor + $precioCom + $envio);
			}else{
				$precioCom = ((($valor * $comisionPaypal)/100) + $row1['comis_transfer']);
				$precioConComision = ($valor + $precioCom);
			}
			
			
		}elseif($row['tipo'] == 3){
			
			$valor_boletos = ($valor - $envio);
		
			$comisionPaypal = $row1['porcpaypal'];
		
			$precioCom = ((($valor * $comisionPaypal)/100) + $row1['valpaypal']);
			$precioConComision = ($valor + $precioCom);
		}elseif($row['tipo'] == 4){
			$valor_boletos = ($valor);
			$valor_boletos2 = ($valor + $envio);
		
			$comisionStripe = $row1['porcstripe'];
		
			$precioCom = ((($valor_boletos2 * $comisionStripe)/100) + $row1['valstripe']);
			$precioConComision = ($valor_boletos2 + $precioCom);
		}
		
		
		$sumaPrecio += $precioConComision;
		$hoy = $row['fecha'];
		$expFehc = explode(" ",$hoy);
		$fecha = $expFehc[0];
		$hora = $expFehc[1];

		// $prueba = 'SELECT * FROM factura WHERE id_cli = '.$row3['idCliente'].'';
		// echo $prueba;
		
		if($row['impresion_local'] == 1){
			
			$sqlDT = '	SELECT detalle_tarjetas.* , t.numboletos , t.iddistribuidortrans as idDistri , t.fecha as fecha_impresion
						FROM `detalle_tarjetas` 
						left join transaccion_distribuidor as t 
						on t.numboletos = detalle_tarjetas.idbol 
						WHERE `id_fact` = "'.$row['id'].'" 
						ORDER BY `id_fact` ASC ';
			$resDT = mysql_query($sqlDT) or die (mysql_error());
			$rowDT = mysql_fetch_array($resDT);
			
			
			$hoy = $rowDT['fecha_impresion'];
			$expFehc = explode(" ",$hoy);
			$fecha = $expFehc[0];
			$hora = $expFehc[1];
			
			
			$sqlD = 'select nombreDis from distribuidor where idDistribuidor = "'.$rowDT['idDistri'].'" ';
			$resD = mysql_query($sqlD) or die (mysql_error());
			$rowD = mysql_fetch_array($resD);
			
			
			// $colorCarpeta = '<i class="fa fa-check-square-o fa-2x" aria-hidden="true" style = "color:#1E9F75;" ></i>';
			$colorCarpeta = '<label style = "color:#1E9F75;" >'.$rowD['nombreDis'].'</label>';
			$colorImp = 'font-weight:bold;';
			
			
			$estado = '<i class="fa fa-check-square-o" aria-hidden="true" style = "color:rgb(29,159,117);" ></i>';
			$txt = 'TIKETS YA IMPRESOS';
			$color = 'danger';
			$disabled = 'disabled';
			
			
			
		}else{
			// $colorCarpeta = '<i class="fa fa-times fa-2x" aria-hidden="true" style = "color:red;" ></i>';
			$colorCarpeta = '<label style = "color:red;" >No impresos</label>';
			$colorImp = 'font-weight:;';
			
			$estado = '<i class="fa fa-times-circle-o" aria-hidden="true" style = "color:red;"></i>';
			$txt = 'IMPRIMIR TICKETS';
			$color = 'warning active';
			$disabled = '';
		}
			
?>
		<tr>
			<!--<td><?php echo $validaEnvio." <<>> ".$row['ndepo']."  --x--  ".$_SESSION['perfil']."  --  ".$row['id']."<<>>".$valor.">><<".$envio."<<>>".$comisionStripe."<<>>".$row1['valstripe'].">><<".$precioCom;?></td>-->
			<td>
				<input type = 'hidden' style = 'display:none;' value = '<?php echo $idBol;?>' id = 'idBol_<?php echo $row['id'];?>' />
				<?php //echo $row['id'];?>
				<?php echo $txtF;?>
			</td>
			<td>
				<?php 
					echo ReemplazarTildes($row3['strNombresC'])."<br>";
				?>
			</td>
			<td><?php echo $row3['strDocumentoC'];?></td>
			<td style = 'text-align:right;'><?php echo $row4['cuantos'];?></td>
			<td style = 'text-align:right;'><?php echo $asientos;?></td>
			
			<td style = 'text-align:right;'>
				<?php 
					echo number_format(($valor_boletos),2);
					$suma_valor_boletos += $valor_boletos;
				?>
			</td>
			
			<td>
				<?php 
					echo number_format(($precioCom),2);
					$suma_precio_comision += $precioCom;
				?>
			</td>
			
			
			<td style = 'text-align:right;'>
				<?php 
					echo number_format(($envio),2);
					$suma_envio += $envio;
				?>
			</td>
			<td <?php echo $btnDomicilio;?> style = 'text-align:right;<?php echo $tipoEstilo;?> '>
				<?php 
					echo number_format(($precioConComision),2);
					$suma_precioComiTotal += $precioConComision;
				?>
			</td>
			
			
			<td style = 'text-align:center;'>
				<?php
					echo $colorCarpeta;
				?>
			</td>
			
			
			<td style = 'text-align:right;'>
				<button type="button" class="btn btn-<?php echo $color;?>" id = 'imprimeTickets<?php echo $row['id'];?>' <?php echo $disabled;?>
					onclick="imprimirDomicilio_2(
												<?php echo $row['id_cli'];?>,
												<?php echo $row['idConc'];?>,
												<?php echo $row['localidad'];?>,
												22,
												0,
												'<?php echo $pago;?>',
												0,
												0,
												<?php echo $row['id'];?>
												)"> 
					<i class="fa fa-print" aria-hidden="true"></i><?php echo $txt;?>
				</button>
			</td>
			<td style = '<?php echo $colorImp;?>'><?php echo $fecha;?></td>
			<td style = '<?php echo $colorImp;?>'><?php echo $hora;?></td>
			<td><?php echo $row1['strEvento'];?></td>
		
			
			
			
			<td style = 'text-align:center;' onclick = 'verDetalle(<?php echo $row['id'];?> , "<?php echo $row1['strEvento'];?>" , 1 )' >
				<i class="fa fa-folder-open-o carpeta" aria-hidden="true"></i>
			</td>
			
			<td>
				<?php
					echo $row3['strMailC'];
				?> 
			</td>
			<td>	
				<?php
					echo $row3['intTelefonoMovC'];
				?>
			</td>
			
			
		</tr>
<?php
	}
?>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?php echo number_format(($suma_valor_boletos),2);?></td>
			<td><?php echo number_format(($suma_precio_comision),2);?></td>
			<td><?php echo number_format(($suma_envio),2);?></td>
			<td><?php echo number_format(($suma_precioComiTotal),2);?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			
			<td></td>
			<td></td>
			<td></td>
			
		</tr>
		
	<!--</table>-->