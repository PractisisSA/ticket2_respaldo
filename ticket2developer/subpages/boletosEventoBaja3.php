<?php

	session_start();
	include '../conexion.php';
	$evento_baja = $_REQUEST['evento_baja'];
	$sessionNumber = $_SESSION['iduser'];
	$checkUserSql = 'SELECT strPerfil FROM Usuario WHERE idUsuario = '.$sessionNumber.'';
	$checkUserRes = mysql_query($checkUserSql);
	$checkUserRow = mysql_fetch_array($checkUserRes);
	$profile = $checkUserRow['strPerfil'];
	$distri = $_REQUEST['distri'];
	$sql = '';
	$sum = '';

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

	if ($profile == 'Distribuidor') {
		$sql = 'SELECT count(b.serie_localidad) as cuantos, l.strDescripcionL FROM `Boleto` as b, Localidad as l WHERE b.idCon = "'.$evento_baja.'0000" AND b.id_usu_venta = '.$sessionNumber.' AND b.`idLocB` = l.idLocalidad GROUP by l.idLocalidad';
	}else{
		$sql = 'SELECT count(b.serie_localidad) as cuantos, l.strDescripcionL FROM `Boleto` as b, Localidad as l WHERE b.idCon = "'.$evento_baja.'0000" AND b.`idLocB` = l.idLocalidad GROUP by l.idLocalidad';
	}

	$res = mysql_query($sql) or die (mysql_error());
	$res1 = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);

	if($row['cuantos']>0){
		while($row1 = mysql_fetch_array($res1)){
			$sum += $row1['cuantos'];
		}
		echo "Dados de baja: ".$sum."";

	}else{
		echo 'No hay datos';
	}
		
?>