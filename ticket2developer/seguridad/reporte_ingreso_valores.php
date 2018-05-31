<?php
	$id_con = $_REQUEST['id_con'];
	include '../conexion.php';
	$sql = 'select * from Localidad where idConc = "'.$id_con.'"';
	$res = mysql_query($sql) or die (mysql_error());
	
	// echo $sql;
	$res = mysql_query($sql) or die (mysql_error());
	$pre=0;
	$cuantos_normal = 0;
	$cuantos_desc = 0;
	$precio_desc=0;
	
	$sumaTotalT =0;
	$sumaTotalP =0;
		
	while($row = mysql_fetch_array($res)){
		$pre = $row['doublePrecioL'];
		
		$sql1 = '
				select count(idBoleto) as cuantos_normal
				from Boleto 
				where idLocB = "'.$row['idLocalidad'].'" 
				and strEstado != "A"
				AND `id_desc` = 0
		';
		
		$res1 = mysql_query($sql1) or die (mysql_error());
		$row1 = mysql_fetch_array($res1);
		$cuantos_normal = $row1['cuantos_normal'];
		
		$precio_normal = ($pre * $cuantos_normal);
		$sql2 = '
				select count(idBoleto) as cuantos_desc , sum(valor) as precio_desc
				from Boleto 
				where idLocB = "'.$row['idLocalidad'].'" 
				and strEstado != "A"
				AND `id_desc` != 0
		';
		
		$res2 = mysql_query($sql2) or die (mysql_error());
		$row2 = mysql_fetch_array($res2);
		$cuantos_desc = $row2['cuantos_desc'];
		$precio_desc = $row2['precio_desc'];
		
		$sumaTotalT += ($cuantos_normal + $cuantos_desc);
		$sumaTotalP += ($precio_normal+$precio_desc);
		
		$totalNoDes = ($cuantos_normal + $cuantos_desc);
		if($totalNoDes == 0){
			$txtND='color:#fff;';
		}else{
			$txtND='color:#fff;';
		}
?>
	<tr>
		
		<td><?php echo $row['strDescripcionL'];?></td>
		<td>
			<?php 
				echo $cuantos_normal."&nbsp;&nbsp;";
				echo "(".$pre."*".$cuantos_normal.")";
			?>
		</td>
		<td><?php echo number_format(($precio_normal),2);?></td>
		<td><?php echo $cuantos_desc;?></td>
		<td><?php echo number_format(($precio_desc),2);?></td>
		<td>
			<label style = '<?php echo $txtND;?>'><?php echo $totalNoDes;?></label>
		</td>
		<td>USD$ <?php echo number_format(($precio_normal+$precio_desc),2);?></td>
		
	</tr>
<?php
		$sumaTickets += $row['total'];
		$sumaPlata += ($row['total'] * $row['precio']);
	}
?>
	<tr>
		
		<td colspan = '5'>TOTAL</td>
		<td><?php echo $sumaTotalT;?></td>
		<td>USD$ <?php echo number_format(($sumaTotalP),2);?></td>
		
	</tr>