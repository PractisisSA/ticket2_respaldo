<?php
	include '../conexion.php';
	$evento_reimprime = $_REQUEST['evento_reimprime'];
	
	$sql = 'SELECT * FROM Localidad WHERE idConc = "'.$evento_reimprime.'" and fechaCreacionL > 0 order by idLocalidad ASC';
	$res = mysql_query($sql) or die (mysql_error());
	
	$sql1 = 'SELECT * FROM claves WHERE id_con = "'.$evento_reimprime.'" ';
	$res1 = mysql_query($sql1) or die (mysql_error());
	$row1 = mysql_fetch_array($res1);
?>
	<option value = '' >Seleccione...</option>
<?php
	while($row = mysql_fetch_array($res)){
?>
		<option value = '<?php echo $row['idLocalidad'];?>' ><?php echo $row['strDescripcionL'];?></option>
<?php
	}
	echo '|'.$row1['clave'];
?>