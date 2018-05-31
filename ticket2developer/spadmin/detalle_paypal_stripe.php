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
	
	if($_SESSION['perfil'] == 'Distribuidor_impresiones'){
		if($tipo == 1){
			$filtro2 = 'and pventa = 1';
		}else{
			$filtro2 = 'and ndepo = 1';
		}
		
	}else{
		$filtro2 = '';
	}
	
	if($tipo == 1){
		$ident = 0;
		$filtroEstadoPagoTransferencias = 'and estadopagoPV = "pagado" ';
	}elseif($tipo == 3){
		$ident = 1;
		$filtroEstadoPagoTransferencias = '';
	}elseif($tipo == 4){
		$ident = 2;
		$filtroEstadoPagoTransferencias = '';
	}
	
	if($tipo == 1){
		$filtro1 = 11;
		
	}else{
		$filtro1 = 0;
	}
	
	$sql = 'SELECT * FROM factura WHERE tipo = "'.$tipo.'" '.$filtro.' '.$filtroEstadoPagoTransferencias.' '.$filtro2.' order by id DESC'; 
	echo $sql."hola";
	$res = mysql_query($sql) or die(mysql_error());
	$sumaPrecio = 0;
	while($row = mysql_fetch_array($res)){
		
		$sql1 = 'SELECT strEvento , envio ,  porcpaypal , valpaypal , porcstripe , valstripe , comis_transfer , porce_transfer FROM Concierto WHERE idConcierto = "'.$row['idConc'].'" ';
		$res1 = mysql_query($sql1) or die(mysql_error());
		$row1 = mysql_fetch_array($res1);
		
		$sql2 = 'SELECT strDescripcionL FROM Localidad WHERE idLocalidad = "'.$row['localidad'].'" ';
		$res2 = mysql_query($sql2) or die(mysql_error());
		$row2 = mysql_fetch_array($res2);
		
		$sql3 = 'SELECT strNombresC ,strDocumentoC, idCliente FROM Cliente WHERE idCliente = "'.$row['id_cli'].'" ';
		$res3 = mysql_query($sql3) or die(mysql_error());
		$row3 = mysql_fetch_array($res3);
		
		
		$sql4 = 'SELECT count(id) as cuantos , sum(valor) as total FROM detalle_tarjetas WHERE id_fact = "'.$row['id'].'" ';
		$res4 = mysql_query($sql4) or die(mysql_error());
		$row4 = mysql_fetch_array($res4);
		
		if($_SESSION['perfil'] != 'Distribuidor_impresiones'){
			if($tipo == 1){
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
			
			if($tipo == 1){
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
		if($tipo == 4 || $tipo == 1){
			$valor = $row4['total'];
		}else{
			$valor = $row['valor'];
		}
		
		
		
		if($tipo == 1){
			$valor_boletos = ($valor);
		
			$comisionPaypal = $row1['porce_transfer'];
		
			
			if($row['pventa'] == 1){
				$precioCom = (((($valor + $envio) * $comisionPaypal)/100) + $row1['comis_transfer']);
				$precioConComision = ($valor + $precioCom + $envio);
			}else{
				$precioCom = ((($valor * $comisionPaypal)/100) + $row1['comis_transfer']);
				$precioConComision = ($valor + $precioCom);
			}
			
			
		}elseif($tipo == 3){
			
			$valor_boletos = ($valor - $envio);
		
			$comisionPaypal = $row1['porcpaypal'];
		
			$precioCom = ((($valor * $comisionPaypal)/100) + $row1['valpaypal']);
			$precioConComision = ($valor + $precioCom);
		}elseif($tipo == 4){
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
			// $colorCarpeta = '<i class="fa fa-check-square-o fa-2x" aria-hidden="true" style = "color:#1E9F75;" ></i>';
			$colorCarpeta = '<label style = "color:#1E9F75;" >Impresos</label>';
		}else{
			// $colorCarpeta = '<i class="fa fa-times fa-2x" aria-hidden="true" style = "color:red;" ></i>';
			$colorCarpeta = '<label style = "color:red;" >No impresos</label>';
		}
			
?>
		<tr>
			<!--<td><?php echo $validaEnvio." <<>> ".$row['ndepo']."  --x--  ".$_SESSION['perfil']."  --  ".$row['id']."<<>>".$valor.">><<".$envio."<<>>".$comisionStripe."<<>>".$row1['valstripe'].">><<".$precioCom;?></td>-->
			<td><?php echo $row['id'];?></td>
			<td><?php echo ReemplazarTildes($row3['strNombresC']);?></td>
			<td><?php echo $row3['strDocumentoC'];?></td>
			<td><?php echo $row1['strEvento'];?></td>
			<td><?php echo $fecha;?></td>
			<td><?php echo $hora;?></td>
			<td style = 'text-align:right;'><?php echo $row4['cuantos'];?></td>
			<td style = 'text-align:right;'><?php echo number_format(($valor_boletos),2);?></td>
			<?php
				// if($tipo != 1){
			?>
				<td style = 'text-align:right;'><?php echo number_format(($precioCom),2);?></td>
			<?php
				// }
			?>
			
			<td <?php echo $btnDomicilio;?> style = 'text-align:right;<?php echo $tipoEstilo;?>'>
				<?php echo number_format(($envio),2);?>
			</td>
			<td style = 'text-align:right;'><?php echo number_format(($precioConComision),2);?></td>
			
			
				<td style = 'text-align:center;' onclick = 'verDetalle(<?php echo $row['id'];?> , "<?php echo $row1['strEvento'];?>" , 1 )' >
					<i class="fa fa-folder-open-o carpeta" aria-hidden="true"></i>
				</td>
			<td style = 'text-align:center;'>
				<?php
					echo $colorCarpeta;
				?>
			</td>
		</tr>
<?php
	}
?>
		<tr>
			<?php
				if($tipo != 1){
			?>
			<td colspan = '10' style = 'text-align:center;'>
				TOTAL 
			</td>
			<?php
				}else{
			?>
				<td colspan = '9' style = 'text-align:center;'>
					TOTAL 
				</td>
			<?php
				}
			?>
			<td style = 'text-align:right;'><?php echo number_format(($sumaPrecio),2);?></td>
			<td style = 'text-align:right;'></td>
		</tr>