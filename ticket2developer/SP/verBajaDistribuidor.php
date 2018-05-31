<?php
	date_default_timezone_set('America/Guayaquil');
	error_reporting(0);
	$conexion = mysql_connect("localhost", "root", "zuleta99")or die(mysql_error());
	mysql_set_charset('UTF8',$conexion);
	mysql_select_db("ticket", $conexion)or die(mysql_error());

	$concert = $_REQUEST['eventConcert'];
	$sql = 'SELECT `id_usu_venta` FROM `Boleto` WHERE `idCon` = "'.$concert.'0000" and colB != 1 GROUP by `id_usu_venta` ';
	// echo $sql."<br>";
	// $sql = 'SELECT * FROM detalle_distribuidor WHERE conciertoDet = '.$concert.'';
	$res = mysql_query($sql);
	echo "<option value=''>Todos</option>";
	echo "<option value='0'>Web</option>";
	while($row = mysql_fetch_array($res)){
		// echo $row['id_usu_venta']."<br>";
		$sqlU = 'select strObsCreacion from Usuario where idUsuario = "'.$row['id_usu_venta'].'" ';
		
		
		// echo $sqlU."<br><br><br>";
		$resU = mysql_query($sqlU) or die (mysql_error());
		$rowU = mysql_fetch_array($resU);
		
		
		$sqlDistribuidor = 'SELECT * FROM distribuidor WHERE idDistribuidor = '.$rowU['strObsCreacion'].'';
		// echo $sqlDistribuidor."<br><br>";
		$resDistribuidor = mysql_query($sqlDistribuidor);
		$rowDistribuidor = mysql_fetch_array($resDistribuidor);
			echo "<option value=".$row['id_usu_venta'].">".$rowDistribuidor['nombreDis']."</option>";
		
	}

?>