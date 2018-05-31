<?php
	include '../conexion.php';
	$socio_membresia = $_REQUEST['socio_membresia'];
	$sql = 'select * from membresia where id_empresario = "'.$socio_membresia.'" ';
	$res = mysql_query($sql) or die (mysql_error());
?>
		<option value = '' >Seleccione...</option>
<?php
	while($row = mysql_fetch_array($res)){
?>
		<option value = '<?php echo $row['id'];?>' ><?php echo $row['membresia'];?> [<?php echo $row['id'];?>]</option>
<?php
	}
?>