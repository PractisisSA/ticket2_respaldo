<?php
	include '../conexion.php';
	$serviform = $_REQUEST['serviform'];
	$exp1 = explode("|",$serviform);
	for($i=0;$i<=count($exp1)-1;$i++){
		$exp2 = explode("@",$exp1[$i]);
		$localidad = $exp2[0];
		$cantidad_ = $exp2[1];
		$id_canti_ = $exp2[2];
		$id_canti_desc_ = $exp2[3];
		if($id_canti_ == 0){
			$sql = 'insert into localidad_cortesias (id_loc , id_desc , cant , est) values ("'.$localidad.'" , "'.$id_canti_desc_.'" , "'.$cantidad_.'" , "0")';
			$res = mysql_query($sql) or die (mysql_error());
		}else{
			$sql = 'update localidad_cortesias set id_desc = "'.$id_canti_desc_.'" , cant = "'.$cantidad_.'" where id = "'.$id_canti_.'" ';
			$res = mysql_query($sql) or die (mysql_error());
		}
		// echo $localidad." <<>> ".$cantidad_." >><< ".$id_canti_."<br><br>";
	}
	
	echo 'Cantidades de Cortesias grabadas con exito';
?>