<?php
	$id_con = $_REQUEST['id_con'];
	include '../conexion.php';
	$sql = 'select b.* ,  l.strDescripcionL , l.doublePrecioL , d.nom as nom_desc , strDateStateL
			from Boleto as b , Localidad as l , descuentos as d
			where b.idCon = "'.$id_con.'" 
			and b.strEstado != "A"
			and b.idLocB = l.idLocalidad 
            and b.id_desc = d.id
			order by b.serie_localidad DESC 
			
			';
	$res = mysql_query($sql) or die (mysql_error());
	$kk=0;
	while($row = mysql_fetch_array($res)){
		$kk++;
		if($row['nom_desc'] == ''){
			$nombre = 'PRECIO NORMAL';
		}else{
			$nombre = $row['nom_desc'];
		}
		if($row['id_desc'] == 0){
			$valor = $row['doublePrecioL'];
		}else{
			$valor = $row['valor'];
		}
		
		
		if($row['strEstado'] == "I"){
			$txtBoleto = 'Normal';
		}else{
			$txtBoleto = 'Re-Impreso';
		}
?>
	<tr>
		<td><?php echo $kk;?></td>
		<td><?php echo $row['strDescripcionL']."   <label style = 'float:right;'>".$row['strDateStateL']."-".$row['serie_localidad']."</label>";?></td>
		<td><?php echo $txtBoleto;?></td>
		<td><?php echo $nombre;?></td>
		<td>USD$ <?php echo $valor;?></td>
		<td><?php echo $row['strQr'];?></td>
		<td><?php echo $row['strBarcode'];?></td>
	</tr>
<?php
		$sumaTickets += $valor;
	}
?>
	<tr>
		<td>TOTAL</td>
		<td></td>
		<td></td>
		<td>USD$ <?php echo number_format(($sumaTickets),2);?></td>
		<td></td>
		<td></td>
	</tr>