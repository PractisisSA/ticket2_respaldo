<?php
	include '../conexion.php';
	$local_hasta = $_REQUEST['local_hasta'];
	
	$sql = 'select * from descuentos where idloc = "'.$local_hasta.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	
	$sqlL = 'select doublePrecioL from Localidad where idLocalidad = "'.$local_hasta.'" ';
	$resL = mysql_query($sqlL) or die (mysql_error());
	$rowL = mysql_fetch_array($resL);
	
?>
	<option value = ''>Seleccione...</option>
	<option value = '<?php echo $rowL['doublePrecioL'];?>' nombre ='normal' id_desc = '0' >Precio Normal <?php echo $rowL['doublePrecioL'];?></option>
<?php
	while($rowD = mysql_fetch_array($res)){
?>
		<option value = '<?php echo $rowD['val'];?>' nombre = '<?php echo $rowD['nom'];?>' id_desc = '<?php echo $rowD['id'];?>'>Descuento :  <?php echo $rowD['nom']."     $USD ".$rowD['val'];?></option>
<?php
	}
?>