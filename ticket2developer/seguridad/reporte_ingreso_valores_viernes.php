<?php
	include '../conexion.php';
	$sql = 'select count(idBoleto) as total ,  l.strDescripcionL , l.doublePrecioL
			from Boleto as b , Localidad as l 
			where idCon = 26 
			and strEstado = "I"
			and b.idLocB = l.idLocalidad 
			group by b.idLocB
			
			
			';
	$res = mysql_query($sql) or die (mysql_error());
	while($row = mysql_fetch_array($res)){
?>
	<tr>
		
		<td><?php echo $row['strDescripcionL'];?></td>
		<td><?php echo $row['total'];?></td>
		<td><?php echo $row['doublePrecioL'];?></td>
		<td><?php echo ($row['total'] * $row['doublePrecioL']);?></td>
	</tr>
<?php
		$sumaTickets += $row['total'];
		$sumaPlata += ($row['total'] * $row['doublePrecioL']);
	}
?>
	<tr>
		
		<td>TOTAL</td>
		<td><?php echo $sumaTickets;?></td>
		<td><?php echo $row['doublePrecioL']?></td>
		<td><?php echo $sumaPlata;?></td>
	</tr>