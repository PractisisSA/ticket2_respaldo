<?php
	include '../conexion.php';
	$sql = 'select b.* ,  l.strDescripcionL , l.doublePrecioL , strDateStateL
			from Boleto as b , Localidad as l 
			where idCon = 28 
			and strEstado = "I"
			and b.idLocB = l.idLocalidad 
			order by b.strQr DESC 
			
			';
	$res = mysql_query($sql) or die (mysql_error());
	while($row = mysql_fetch_array($res)){
?>
	<tr>
		<td><?php echo $row['strDateStateL'].$row['serie'];?></td>
		<td><?php echo $row['strDescripcionL']?></td>
		<td><?php echo $row['doublePrecioL']?></td>
		<td><?php echo $row['strQr']?></td>
		<td><?php echo $row['strBarcode']?></td>
	</tr>
<?php
		$sumaTickets += $row['doublePrecioL'];
	}
?>
	<tr>
		<td>TOTAL</td>
		<td></td>
		<td><?php echo $sumaTickets;?></td>
		<td></td>
		<td></td>
	</tr>