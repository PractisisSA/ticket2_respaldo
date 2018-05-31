<?php
	session_start();
	include '../../conexion.php';
	$idconciertotrans = $_REQUEST['idconciertotrans'];
	$sqlE1 = 'SELECT * FROM Concierto WHERE idConcierto = "'.$idconciertotrans.'"';
	$resE1 = mysql_query($sqlE1) or die (mysql_error());
	$rowE1 = mysql_fetch_array($resE1);
?>
<table class = 'table' id="table" style = 'color:#fff;'>
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
		<th>Hora Impresión</th>
		<th>Distribuidor</th>
		<th>Total-Re-Impresos</th>
	</tr>
<?php
	$sql = 'SELECT * FROM transaccion_distribuidor WHERE idconciertotrans = "'.$idconciertotrans.'" order by numboletos ASC';
	$res = mysql_query($sql) or die (mysql_error());
	$i=1;
	while($row = mysql_fetch_array($res)){
		$sqlB = 'SELECT * FROM Boleto WHERE idBoleto = "'.$row['numboletos'].'" ';
		$resB = mysql_query($sqlB) or die (mysql_error());
		$rowB = mysql_fetch_array($resB);
		
		$sqlL = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$rowB['idLocB'].'" ';
		$resL = mysql_query($sqlL) or die (mysql_error());
		$rowL = mysql_fetch_array($resL);
		
		$sqlC = 'SELECT * FROM Cliente WHERE idCliente = "'.$rowB['idCli'].'" ';
		$resC = mysql_query($sqlC) or die (mysql_error());
		$rowC = mysql_fetch_array($resC);
		
		$sqlD = 'SELECT * FROM descuentos WHERE id = "'.$rowB['id_desc'].'" ';
		$resD = mysql_query($sqlD) or die (mysql_error());
		$rowD = mysql_fetch_array($resD);
		
		
		$sqlE = 'SELECT * FROM Concierto WHERE idConcierto = "'.$rowB['idCon'].'" ';
		$resE = mysql_query($sqlE) or die (mysql_error());
		$rowE = mysql_fetch_array($resE);
		
		$tiene_permisos = $rowE['tiene_permisos'];
		
		$sqlA = 'SELECT * FROM autorizaciones WHERE idAutorizacion = "'.$tiene_permisos.'" ';
		$resA = mysql_query($sqlA) or die (mysql_error());
		$rowA = mysql_fetch_array($resA);
		
		$codestablecimientoAHIS = $rowA['codestablecimientoAHIS'];
		$serieemisionA = $rowA['serieemisionA'];
		
		if($rowD['id'] == 0){
			$desc = 'Normal';
		}else{
			$desc = $rowD['nom'];
		}
		
		$sqlD1 = 'SELECT nombreDis FROM distribuidor WHERE idDistribuidor = "'.$row['iddistribuidortrans'].'" GROUP BY idDistribuidor;';
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
		<td><?php echo $row['fecha'];?></td>
		<td><?php echo utf8_decode($rowD1['nombreDis']);?></td>
		<td>
			<?php 
				$sqlRei = 'SELECT count(id) as numImp FROM reimpresio_boleto WHERE barcode = "'.$row['numboletos'].'" ';
				$resRei = mysql_query($sqlRei) or die (mysql_error());
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
