<?php
	include '../conexion.php';
	
	$local_desde = $_REQUEST['local_desde'];
	$desde = $_REQUEST['desde'];
	$hasta = $_REQUEST['hasta'];
	$evento_reimprime = $_REQUEST['evento_reimprime'];
	$distri = $_REQUEST['distri'];

	if($distri > 0){
		$sqlU = 'SELECT * FROM `Usuario` WHERE `strObsCreacion` = "'.$distri.'" ORDER BY `strObsCreacion` DESC';
		$resU = mysql_query($sqlU) or die (mysql_error());
		$rowU = mysql_fetch_array($resU);
		$idDist = $rowU['idUsuario'];
		$filtroDist = 'and id_usu_venta = "'.$idDist.'"';
		$nameIt = $rowU['strNombreU'];
	}else if($distri = 0){
		$filtroDist = '';
	}
	
	$consult = 'SELECT count(idBoleto) as cuantos , strEstado as estado from Boleto where idCon = "'.$evento_reimprime.'" '.$filtroDist.' and idLocB = "'.$local_desde.'" AND `serie_localidad` BETWEEN "'.$desde.'" AND "'.$hasta.'"';

	$res1 = mysql_query($consult) or die (mysql_error());
	$row1 = mysql_fetch_array($res1);
	if ($row1['cuantos'] != 0) {
		if($row1['estado'] == 'A'){
			$sql = 'update Boleto set idCon =  "'.$evento_reimprime.'0000" WHERE idLocB = "'.$local_desde.'" AND `serie_localidad` BETWEEN '.$desde.' AND '.$hasta.'';
			$res = mysql_query($sql) or die (mysql_error());
			if($res){
				echo 2;
			}else{
				echo 'Error';
			}
		}else{
			echo 3;
		}
	}
	else{
		echo 1;
	}
	
?>