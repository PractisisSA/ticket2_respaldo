<?php
	include '../conexion.php';
	
	$sql = 'SELECT * FROM `Butaca` WHERE `intConcB` = 274 ORDER BY `Butaca`.`intLocalB` ASC';
	$res = mysql_query($sql) or die (mysql_error());
	$capacidad = 0;
	while($row = mysql_fetch_array($res)){
		$capacidad = ($row['intFilasB'] * $row['intAsientosB']);
		$sql1 = 'UPDATE `Localidad` SET `strCapacidadL` = "'.$capacidad.'" WHERE `Localidad`.`idLocalidad` = "'.$row['intLocalB'].'" ';
		
		echo $sql1."<br>";
		$res1 = mysql_query($sql1) or die (mysql_error());
	}
?>