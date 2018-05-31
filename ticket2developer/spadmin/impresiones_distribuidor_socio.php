<?php
	
	session_start();
	$idconciertotrans = $_REQUEST['idconciertotrans'];
	$idDistribuidor = $_REQUEST['idDistribuidor'];
	include '../../conexion.php';

	$sql = 'SELECT * FROM distribuidor WHERE idDistribuidor = "'.$idDistribuidor.'"';
	$res = mysql_query($sql) or die(mysql_error());

?>
	
<?php
	$sqlTrans = 'SELECT * FROM transaccion_distribuidor WHERE iddistribuidortrans ='.$idDistribuidor.' AND idconciertotrans = '.$idconciertotrans.'';
	$resTrans = mysql_query($sqlTrans) or die(mysql_error());

	$sqlTrans1 = 'SELECT * FROM transaccion_distribuidor WHERE iddistribuidortrans ='.$idDistribuidor.' AND idconciertotrans = '.$idconciertotrans.'';
	$resTrans1 = mysql_query($sqlTrans1) or die(mysql_error());
	$rowTrans1 = mysql_fetch_array($resTrans1);

	$sqlBol1 = 'SELECT * FROM Boleto WHERE idBoleto = "'.$rowTrans1['numboletos'].'"';
	$resBol1 = mysql_query($sqlBol1);
	$rowBol1 = mysql_fetch_array($resBol1);

	$numero_filas = mysql_num_rows($resBol1);
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
				<th>Cliente</th>
				<th>Hora Impresion</th>
				<th>Total-Re-Impresos</th>
			</tr>
	<?php
while ($row = mysql_fetch_array($resTrans)) {
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
?>	
	<tr>
		<td><?php echo $rowBol['idBoleto']; ?></td>
		<td><?php echo $rowBol['serie']; ?></td>
		<td><?php echo $rowBol['valor']; ?></td>
		<td><?php echo $descuento; ?></td>
		<td><?php echo $rowLoc['strDateStateL']." ".$rowBol['serie_localidad']; ?></td>
		<td><?php echo $rowLoc['strDescripcionL']; ?></td>
		<td><?php echo utf8_decode($rowCli['strNombresC']) ?></td>
		<td><?php echo $row['fecha']; ?></td>
		<td><?php $sqlRei = 'SELECT count(id) as numImp FROM reimpresio_boleto WHERE barcode = "'.$row['numboletos'].'"';
		$resRei = mysql_query($sqlRei) or die(mysql_error()); $rowRei = mysql_fetch_array($resRei); $numImp = $rowRei['numImp']; echo $numImp; ?></td>
	</tr>
	<?php }
	}
?>	
	
