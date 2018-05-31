<?php
	session_start();
	include '../conexion.php';
	$selecForm = $_REQUEST['selecForm'];
	
	
	$sumaValor = $_REQUEST['sumaValor'];
	$bco = $_REQUEST['bco'];
	$fec = $_REQUEST['fec'];
	$cta = $_REQUEST['cta'];
	$enc = $_REQUEST['enc'];
	$num = $_REQUEST['num'];
	
	$sql = 'INSERT INTO `cierre` (`id`, `valor`, `bco`, `fec`, `cta`, `enc`, `num` , `id_dist` ) 
			VALUES (NULL, "'.$sumaValor.'", "'.$bco.'", "'.$fec.'", "'.$cta.'", "'.$enc.'", "'.$num.'" , "'.$_SESSION['iduser'].'")';
	
	// echo $sql."<br>";
	$res = mysql_query($sql) or die (mysql_error());
	
	$idCierre = mysql_insert_id();
	
	$expBol = explode("@",$selecForm);
	for($i=0;$i<count($expBol);$i++){
		// echo $expBol[$i]."<br>";
		$sql2 = 'select idbol from detalle_tarjetas where id_fact = "'.$expBol[$i].'" ';
		$res2 = mysql_query($sql2) or die (mysql_error());
		while($row2 = mysql_fetch_array($res2)){
			$sql1 = 'update Boleto set estado_dep = "1" , nombreHISB = "'.$idCierre.'" where idBoleto = "'.$row2['idbol'].'" ';
			//echo $sql1."<br>";
			$res1 = mysql_query($sql1) or die (mysql_error());
			
			
			
		}
		
		$sql3 = 'update factura set estadopagoPV = "1" , fechaE = "'.$idCierre.'"  where id = "'.$expBol[$i].'" ';
			//echo $sql1."<br>";
		$res3 = mysql_query($sql3) or die (mysql_error());
	}
	
	echo 'Cierre grabado con Exito';
	
?>