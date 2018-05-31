<?php
	session_start();
	include '../conexion.php';
	$id_locNueva = $_REQUEST['id_locNueva'];
	$id_loc = $_REQUEST['id_loc'];
	$status = $_REQUEST['status'];
	$id_con = $_REQUEST['id_con'];
	//echo "localidad nueva : ".$id_locNueva." localidad para clonar : ".$id_loc." status : ".$status." concierto clonado : ".$id_con;
	
	$sqlOc = 'SELECT * FROM `ocupadas` WHERE `status` = "'.$status.'"  AND `local` = "'.$id_loc.'" ORDER BY `id` DESC ';
	$resOc = mysql_query($sqlOc) or die (mysql_error());
	while($rowOc = mysql_fetch_array($resOc)){
		
		
		$row= $rowOc['row']; 
		$col= $rowOc['col']; 
		$status2= $rowOc['status'];
		$local= $id_locNueva;//575;
		$concierto= $id_con;
		$pagopor= $rowOc['pagopor']; 
		$descompra= $rowOc['descompra'];
		
		$sqlCo1 = '	INSERT INTO `ocupadas` (`id`, `row`, `col`, `status`, `local`, `concierto`, `pagopor`, `descompra`) 
					VALUES(null ,"'.$row.'", "'.$col.'", "'.$status2.'","'.$local.'", "'.$concierto.'", "'.$pagopor.'", "'.$descompra.'")';
		$resCo1 = mysql_query($sqlCo1) or die (mysql_error());
	}
	echo 'ok';
?>