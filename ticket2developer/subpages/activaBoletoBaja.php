<?php
	include '../conexion.php';
	
	$local = $_REQUEST['localiact'];
	$desdeact = $_REQUEST['desdeact'];
	$hastaact = $_REQUEST['hastaact'];
	$evento_reimprime = $_REQUEST['evento_reimprime'];
	$distri = $_REQUEST['distri'];

	if ($distri > 0) {
		$sqlU = 'SELECT * FROM `Usuario` WHERE `strObsCreacion` = "'.$distri.'" ORDER BY `strObsCreacion` DESC';
		$resU = mysql_query($sqlU) or die (mysql_error());
		$rowU = mysql_fetch_array($resU);
		$idDist = $rowU['idUsuario'];
		$filtroDist = 'and id_usu_venta = "'.$idDist.'"';
		$nameIt = $rowU['strNombreU'];
	}else{
		$filtroDist = '';
	}

	$consult2 = 'SELECT COUNT(idBoleto) as cuantos , strEstado as estado from Boleto where idCon = "'.$evento_reimprime.'0000" '.$filtroDist.' and idLocB = "'.$local.'" AND `serie_localidad` >= "'.$desdeact.'" AND serie_localidad <= "'.$hastaact.'"';
	$res2 = mysql_query($consult2) or die (mysql_error());
	$row2 = mysql_fetch_array($res2);

	if ($row2['cuantos'] != 0) {
		$sql = 'UPDATE Boleto SET idCon =  "'.$evento_reimprime.'" WHERE idLocB = "'.$local.'" AND `serie_localidad` BETWEEN '.$desdeact.' AND '.$hastaact.'';
		$res = mysql_query($sql) or die (mysql_error());
		if($res){
			echo 2;
		}else{
			echo 3;
		}
	}else{
		echo 1;
	}
?>