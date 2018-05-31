			<?php
			
				include '../conexion.php';
				$dist = $_REQUEST['dist'];

				$sql = 'select count(idBoleto) as vendidos from Boleto where id_usu_venta = "'.$dist.'"';
				$res = mysql_query($sql) or die (mysql_error());
				$row = mysql_fetch_array($res);
				
				$sqlE = 'select sum(cantidad) as entregados from entrega_boletos where id_usu = "'.$dist.'"';
				$resE = mysql_query($sqlE) or die (mysql_error());
				$rowE = mysql_fetch_array($resE);
				
				
				$vendidos = $row['vendidos'];
				echo '<input type = "hidden" class = "vendidos" value = "'.$vendidos.'" />';
				
				$sql1 = 'select count(id) as impresos from reimpresio_boleto where iduser = "'.$dist.'" ';
				$res1 = mysql_query($sql1) or die (mysql_error());
				$row1 = mysql_fetch_array($res1);
				
				$impresos = $row1['impresos'];
				
				echo '<input type = "hidden" class = "impresos" value = "'.$impresos.'" />';
				
			?>
			<div class = 'row'>
				<div class = 'col-xs-3'></div>
				<div class = 'col-xs-5' style = 'color:#fff;'>
					<table class = 'table'>
						<tr>
							<td colspan = '2'>
								Detalle boletos
							</td>
						</tr>
						<tr>
							<td>
								Entregados : 
							</td>
							<td>
								<div id = 'entregados'><?php echo $rowE['entregados'];?></div>
							</td>
						</tr>
						<tr>
							<td>
								Vendidos : 
							</td>
							<td>
								<div id = 'vendidos'><?php echo $vendidos;?></div>
							</td>
						</tr>
						<tr>
							<td>
								Reimpresos : 
							</td>
							<td>
								<div id = 'vendidos'><?php echo $impresos;?></div>
							</td>
						</tr>
						<tr>
							<td>
								TOTAL : 
							</td>
							<td>
								<?php
									echo ($rowE['entregados'] - ($vendidos));
								?>
							</td>
						</tr>
					</table>
				</div>
				<div class = 'col-xs-3'></div>
			</div>