<?php
	include 'conexion.php';
	$id_con = $_REQUEST['id_con'];
	
	$sql = 'select * from Boleto where idCon = "'.$id_con.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$i=1;
	//$cc = 'insert into codigo_barras (id , id_con , codigo , estado , utilizado) values';
	for($i=1;$i<=6;$i++){
		//echo $i.">> <<".$row['strBarcode']."<br>";
		$code = rand(1,999999).time().$i;
		$cc = '("null" , "43" , "'.$code.'" , "A" , "1" , "118" ),';
		echo $cc."<br>";
		//$res = mysql_query($sql2) or die (mysql_error());
		//$i++;
	}
	
	
	
	
	
?>