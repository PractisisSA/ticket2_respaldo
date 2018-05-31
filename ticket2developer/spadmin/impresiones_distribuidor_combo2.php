<?php
session_start();
	$idconciertotrans = $_REQUEST['idconciertotrans'];
	$idDistribuidor = $_REQUEST['idDistribuidor'];
	$ema = $_REQUEST['mail'];
	include '../../conexion.php';
	$countImp;
	if ($ema) {
		$pru = 'SELECT * FROM distribuidor WHERE mailDis = "'.$ema.'"';
		$pruQue = mysql_query($pru);
		$pruRes = mysql_fetch_array($pruQue);
?>
	<?php
		$sqlTrans1 = 'SELECT * FROM transaccion_distribuidor WHERE iddistribuidortrans ='.$pruRes['idDistribuidor'].' AND idconciertotrans = '.$idconciertotrans.'';
		$resTrans1 = mysql_query($sqlTrans1);

		$sqlTrans2 = 'SELECT * FROM transaccion_distribuidor WHERE iddistribuidortrans ='.$pruRes['idDistribuidor'].' AND idconciertotrans = '.$idconciertotrans.'';
		$resTrans2 = mysql_query($sqlTrans1);
		$rowTrans2 = mysql_fetch_array($resTrans2);

		$sqlBol2 = 'SELECT * FROM Boleto WHERE idBoleto = "'.$rowTrans2['numboletos'].'"';
			$resBol2 = mysql_query($sqlBol2);
			$numero_filas = mysql_num_rows($resBol2);
			if ($numero_filas == 0) {
				echo 1;
				exit();
			}else{
	?>
				<table class = 'table' id="table" style = 'color:#fff;'>
			<tr>
				<th colspan = '9' style = 'vertical-align:middle;text-align:center;text-transform:uppercase;color:blue;'>
					Impresiones por distribuidor del evento : 
				</th>
			</tr>
			<tr>
				<th>#</th>
				<th>Nro. Boleto</th>
				<th>Precio</th>
				<th>Descuento</th>
				<th>Serie</th>
				<th>Localidad</th>
				<th>Distribuidor</th>
				<th>Total-Re-Impresos</th>
			</tr>

		<?php
			while ($rowTrans1 = mysql_fetch_array($resTrans1)) {
				$sqlBol1 = 'SELECT * FROM Boleto WHERE idBoleto = "'.$rowTrans1['numboletos'].'"';
				$resBol1 = mysql_query($sqlBol1);
				$rowBol1 = mysql_fetch_array($resBol1);
				$sqlLoc1 = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$rowBol1['idLocB'].'"';
				$resLoc1 = mysql_query($sqlLoc1);
				$rowLoc1 = mysql_fetch_array($resLoc1);

				$sqlCli1 = 'SELECT * FROM Cliente WHERE idCliente = "'.$rowBol1['idCli'].'"';
				$resCli1 = mysql_query($sqlCli1);
				$rowCli1 = mysql_fetch_array($resCli1);

				$sqlDes1 = 'SELECT * FROM descuentos WHERE id = "'.$rowBol1['id_desc'].'"';
				$resDes1 = mysql_query($sqlDes1);
				$rowDes1 = mysql_fetch_array($resDes1);

				$sqlCon1 = 'SELECT * FROM Concierto WHERE idConcierto = "'.$rowBol1['idCon'].'"';
				$resCon1 = mysql_query($sqlCon1);
				$rowCon1 = mysql_fetch_array($resCon1);

				if ($rowDes['id'] == 0) {
					$descuento = 'Normal'; 
				}else{
					$descuento = $rowDes['nom'];
				}
				$sqlDis1 = 'SELECT nombreDis FROM distribuidor WHERE idDistribuidor = "'.$rowTrans1['iddistribuidortrans'].'" GROUP BY idDistribuidor;';
				$resDis1 = mysql_query($sqlDis1) or die (mysql_error());
				$rowDis1 = mysql_fetch_array($resDis1);
		?>
			<tr>
				<td><?php echo $rowBol1['idBoleto']; ?></td>
				<td><?php echo $rowBol1['serie']; ?></td>
				<td><?php echo $rowBol1['valor']; ?></td>
				<td><?php echo $descuento; ?></td>
				<td><?php echo $rowLoc1['strDateStateL']." ".$rowBol1['serie_localidad']; ?></td>
				<td><?php echo $rowLoc1['strDescripcionL']; ?></td>
				<td><?php echo utf8_decode($rowDis1['nombreDis']) ?></td>
				<td><?php $sqlRei1 = 'SELECT count(id) as numImp FROM reimpresio_boleto WHERE barcode = "'.$rowTrans1['numboletos'].'"';
				$resRei = mysql_query($sqlRei1) or die(mysql_error()); $rowRei1 = mysql_fetch_array($resRei1); $numImp1 = $rowRei1['numImp']; echo $numImp1; ?></td>
			</tr>
		<?php
		 	}
		}

	}else{
		$sql = 'SELECT * FROM distribuidor WHERE idDistribuidor = "'.$idDistribuidor.'"';
		$res = mysql_query($sql) or die(mysql_error());
			?>
		<table class = 'table' id="table" style = 'color:#fff;'>
			<tr>
				<th colspan = '9' style = 'vertical-align:middle;text-align:center;text-transform:uppercase;color:blue;'>
					Impresiones por distribuidor del evento : 
				</th>
			</tr>
			<tr>
				<th>#</th>
				<th>Nro. Boleto</th>
				<th>Precio</th>
				<th>Descuento</th>
				<th>Serie</th>
				<th>Localidad</th>
				<th>Cliente</th>
				<th>Hora Impresión</th>
				<th>Total-Re-Impresos</th>
			</tr>
	<?php
		$sqlTrans = 'SELECT * FROM transaccion_distribuidor WHERE iddistribuidortrans ='.$idDistribuidor.' AND idconciertotrans = '.$idconciertotrans.'';
		$resTrans = mysql_query($sqlTrans) or die(mysql_error());

		while ($row = mysql_fetch_array($resTrans)) {
			$fecha = $row['fecha'];
			$expFecha = explode(" ",$fecha);
			$hora = $expFecha[1];
			
			$sqlBol = 'SELECT * FROM Boleto WHERE idBoleto = "'.$row['numboletos'].'"';
			$resBol = mysql_query($sqlBol);
			$rowBol = mysql_fetch_array($resBol);

			$sqlLoc = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$rowBol['idLocB'].'"';
			$resLoc = mysql_query($sqlLoc);
			$rowLoc = mysql_fetch_array($resLoc);

			$sqlCli = 'SELECT * FROM Cliente WHERE idCliente = "'.$rowBol['idCli'].'"';
			$resCli = mysql_query($sqlCli);
			$rowCli = mysql_fetch_array($resCli);

			$sqlDes = 'SELECT * FROM descuentos WHERE id = "'.$rowBol['id_desc'].'"';
			$resDes = mysql_query($sqlDes);
			$rowDes = mysql_fetch_array($resDes);

			$sqlCon = 'SELECT * FROM Concierto WHERE idConcierto = "'.$rowBol['idCon'].'"';
			$resCon = mysql_query($sqlCon);
			$rowCon = mysql_fetch_array($resCon);

			if ($rowDes['id'] == 0) {
				$descuento = 'Normal'; 
			}else{
				$descuento = $rowDes['nom'];
			}	

				$sqlCountRei = 'SELECT count(id) as numImp FROM reimpresio_boleto WHERE barcode = "'.$row['numboletos'].'"';
				$resCountRei = mysql_query($sqlCountRei) or die(mysql_error()); $rowCountRei = mysql_fetch_array($resCountRei); $countImp = $rowCountRei['numImp'];

				echo "<tr>";
				echo "<td>".$rowBol['idBoleto']."</td>";
				echo "<td>".$rowBol['serie']."</td>";
				echo "<td>".$rowBol['valor']."</td>";
				echo "<td>".$descuento."</td>";
				echo "<td>".$rowLoc['strDateStateL']."--".$rowBol['serie_localidad']."</td>";
				echo "<td>".$rowLoc['strDescripcionL']."</td>";
				echo "<td>".$rowCli['strNombresC']."</td>";
				echo "<td>".$fecha."</td>";
				echo "<td>".$countImp."</td>";
	
		}
		?>
			</tr>
		</table>
		<?php
	}
	?>