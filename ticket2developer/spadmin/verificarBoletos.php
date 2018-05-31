<?php
	include '../conexion.php';
	
	$desde = $_REQUEST['desde'];
	$hasta = $_REQUEST['hasta'];
	$distribuidor = $_REQUEST['distribuidor'];
	$localidad = $_REQUEST['localidad'];
	$evento = $_REQUEST['evento'];
	
	// echo $desde." <<>> ".$hasta." <<>> ".$distribuidor." <<>> ".$localidad." <<>> ".$evento."<br>";
	
	$sqlU = 'select idUsuario from Usuario where strObsCreacion = "'.$distribuidor.'" ';
	$resU = mysql_query($sqlU) or die (mysql_error());
	$rowU = mysql_fetch_array($resU);
	$k=0;
	$pp='';
	for($i=$desde;$i<=$hasta;$i++){
			$pp .= $i.",";
		
	}
	$myString = substr($pp, 0, -1);
	// echo $myString."<br>";
	
	$sqlB2 = 'SELECT count(idBoleto) as cuantos from Boleto where idCon = "'.$evento.'" and idLocB = "'.$localidad.'" and serie_localidad in ('.$myString.') and id_usu_venta = "'.$rowU['idUsuario'].'" ';
	$resB2 = mysql_query($sqlB2) or die (mysql_error());
	$rowB2 = mysql_fetch_array($resB2);
	
	
	$sqlL = 'select strDateStateL from Localidad where idLocalidad = "'.$localidad.'" ';
	$resL = mysql_query($sqlL) or die (mysql_error());
	$rowL = mysql_fetch_array($resL);
	
	
	
	$sqlB = 'SELECT * from Boleto where idCon = "'.$evento.'" and idLocB = "'.$localidad.'" and serie_localidad in ('.$myString.') and id_usu_venta = "'.$rowU['idUsuario'].'" ';
	// echo $sqlB;
	$resB = mysql_query($sqlB) or die (mysql_error());
	$tick = '';
	$series = '';
	$kk=0;
	while($rowB = mysql_fetch_array($resB)){
		$tick .= $rowB['idBoleto']."@";
		if($kk == 0){
			$series.='<tr>';
		}
			$series .= "<td style = 'padding-top: 20px;padding-bottom: 20px;text-align: center' >".$rowL['strDateStateL']." - ".$rowB['serie_localidad']."</td>";
		if($kk == 5){
			$series.='</tr>';
			$kk=0;
		}else{
			$kk++;
		}
	}
	
	$myString2 = substr($tick, 0, -1);
	$myString3 = substr($series, 0, -1);
	echo $rowB2['cuantos']."|".$series."|".$myString2;
?>