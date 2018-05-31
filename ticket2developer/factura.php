<?php
	include 'conexion.php';
	$sql  ='select id , valor from factura where tipo = "5"';
	$res = mysql_query($sql) or die (mysql_error());
	while($row = mysql_fetch_array($res)){
		$sql1 = 'select sum(valor) as suma from detalle_tarjetas where id_fact = "'.$row['id'].'" ';
		$res1 = mysql_query($sql1) or die (mysql_error());
		$row1 = mysql_fetch_array($res1);
		$suma = $row1['suma'];
		if($suma != ''){
			echo $row['id']." << >> ".$suma.">>><<<".$row['valor']."<br>";
			$sql2 = 'update factura set valor = "'.$suma.'" where id = "'.$row['id'].'" ';
			$res2 = mysql_query($sql2) or die (mysql_error());
		}
		
	}
	
	
	// $sql = 'select idBoleto , tercera  , id_desc , valor 
			// from Boleto 
			// where tercera = 1
			// ';
	// $res = mysql_query($sql) or die (mysql_error());
	// $i=1;
	// while($row = mysql_fetch_array($res)){
		// $sql1 = 'select * from descuentos where id = "'.$row['id_desc'].'" ';
		// $res1 = mysql_query($sql1) or die (mysql_error());
		// $row1 = mysql_fetch_array($res1);
		// // echo $i."  [[ ]]  ".$row1['id']." << >> ".$row1['nom']." >><< ".$row1['val']."<br>";
		
		// $sql2 = 'update Boleto set valor = "'.$row1['val'].'" where idBoleto = "'.$row['idBoleto'].'" ';
		// $res2 = mysql_query($sql2) or die (mysql_error());
		
		// $sql3 = 'UPDATE `detalle_tarjetas` SET `valor` = "'.$row1['val'].'" WHERE idbol = "'.$row['idBoleto'].'" ';
		// $res3 = mysql_query($sql3) or die (mysql_error());
		
		// echo $i."  [[ ]]  ".$sql2."<br>";
		// $i++;
	// }
	
?>