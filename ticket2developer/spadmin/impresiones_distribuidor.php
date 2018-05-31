		<?php
			session_start();
			$idconciertotrans = $_REQUEST['idconciertotrans'];
			include '../../conexion.php';
			
			$sqlE1 = 'select * from Concierto where idConcierto = "'.$idconciertotrans.'" ';
			$resE1 = mysql_query($sqlE1) or die (mysql_error());
			$rowE1 = mysql_fetch_array($resE1);
		?>
		<table class = 'table' style = 'color:#fff;'>
			<tr>
				<th colspan = '9' style = 'vertical-align:middle;text-align:center;text-transform:uppercase;color:blue;'>
					Impresiones por distribuidor del evento : <?php echo $rowE1['strEvento'];?>
				</th>
			</tr>
			<tr>
				<th>#</th>
				<th>N° Boleto</th>
				<th>Precio</th>
				<th>Descuento</th>
				<th>Serie</th>
				<th>Localidad</th>
				<th>Cliente</th>
				<th>Distribuidor</th>
				<th>Total-Re-Impresos</th>
			</tr>
		<?php
			
			
			$sql = 'select * from transaccion_distribuidor where idconciertotrans = "'.$idconciertotrans.'" order by numboletos ASC';
			//echo $sql;
			$res = mysql_query($sql) or die (mysql_error());
			$i=1;
			while($row = mysql_fetch_array($res)){
				$sqlB = 'select * from Boleto where idBoleto = "'.$row['numboletos'].'" ';
				$resB = mysql_query($sqlB) or die (mysql_error());
				$rowB = mysql_fetch_array($resB);
				
				$sqlL = 'select * from Localidad where idLocalidad = "'.$rowB['idLocB'].'" ';
				$resL = mysql_query($sqlL) or die (mysql_error());
				$rowL = mysql_fetch_array($resL);
				
				$sqlC = 'select * from Cliente where idCliente = "'.$rowB['idCli'].'" ';
				$resC = mysql_query($sqlC) or die (mysql_error());
				$rowC = mysql_fetch_array($resC);
				
				$sqlD = 'select * from descuentos where id = "'.$rowB['id_desc'].'" ';
				$resD = mysql_query($sqlD) or die (mysql_error());
				$rowD = mysql_fetch_array($resD);
				
				
				$sqlE = 'select * from Concierto where idConcierto = "'.$rowB['idCon'].'" ';
				$resE = mysql_query($sqlE) or die (mysql_error());
				$rowE = mysql_fetch_array($resE);
				
				$tiene_permisos = $rowE['tiene_permisos'];
				
				
				$sqlA = 'select * from autorizaciones where idAutorizacion = "'.$tiene_permisos.'" ';
				$resA = mysql_query($sqlA) or die (mysql_error());
				$rowA = mysql_fetch_array($resA);
				
				$codestablecimientoAHIS = $rowA['codestablecimientoAHIS'];
				$serieemisionA = $rowA['serieemisionA'];
				
				if($rowD['id'] == 0){
					$desc = 'Normal';
				}else{
					$desc = $rowD['nom'];
				}
				
				
				$sqlD1 = 'select nombreDis from distribuidor where idDistribuidor = "'.$row['iddistribuidortrans'].'" ';
				$resD1 = mysql_query($sqlD1) or die (mysql_error());
				$rowD1 = mysql_fetch_array($resD1);
		?>
			<tr>
				<td><?php echo $rowB['idBoleto'];?></td>
				<td><?php echo $codestablecimientoAHIS."-".$serieemisionA."-".$rowB['serie'];?></td>
				<td><?php echo $rowB['valor'];?></td>
				<td><?php echo $desc;?></td>
				<td><?php echo $rowL['strDateStateL']." ".$rowB['serie_localidad'];?></td>
				<td><?php echo $rowL['strDescripcionL'];?></td>
				<td><?php echo utf8_decode($rowC['strNombresC']);?></td>
				<td>
					<?php echo utf8_decode($rowD1['nombreDis']);?>
				</td>
				<td>
					<?php 
						$sqlRei = 'select count(id) as numImp from reimpresio_boleto where barcode = "'.$row['numboletos'].'" ';
						$resRei = mysql_query($sqlRei) or die (mysql_error());
						$rowRei = mysql_fetch_array($resRei);
						$numImp = $rowRei['numImp'];
						echo $numImp;
					?>
				</td>
				
			</tr>
		<?php
				$i++;
			}
		?>
		</table>
	