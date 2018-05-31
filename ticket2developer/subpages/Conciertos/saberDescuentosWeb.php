<?php
	include '../../conexion.php';
	$local = $_REQUEST['local'];
	$sql = 'select count(id) as cuantos from descuentos where idloc = "'.$local.'" and web = 1';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	
	
	$sql2 = 'select doublePrecioL from Localidad where idLocalidad = "'.$local.'"';
	$res2 = mysql_query($sql2) or die (mysql_error());
	$row2 = mysql_fetch_array($res2);
	
	
	
	if($row['cuantos'] == 0){
		echo 0;
	}else{
		$sql1 = 'select * from descuentos where idloc = "'.$local.'" and web = 1 ';
		$res1 = mysql_query($sql1) or die (mysql_error());
?>
	<select id = 'descuentos_web' class = 'form-control' onchange = 'descuentos_web_limitados()' >
		<option value = '0' nombre = 'Ninguno' valor = '<?php echo number_format(($row2['doublePrecioL']),2);?>' id_desc = '0' >Precio Normal : <?php echo $row2['doublePrecioL'];?></option>
<?php
	while($row1 = mysql_fetch_array($res1)){
?>
		<option value = '<?php echo $row1['id'];?>' nombre = '<?php echo $row1['nom'];?>' valor = '<?php echo number_format(($row1['val']),2);?>' id_desc = '<?php echo $row1['id'];?>' ><?php echo $row1['nom'];?>  --  USD$  [<?php echo number_format(($row1['val']),2);?>]</option>
<?php
	}
?>
	</select>
<?php
	}
?>
	