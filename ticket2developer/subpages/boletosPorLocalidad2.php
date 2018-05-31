<?php
	session_start();
	// if($_SESSION['perfil']=='Distribuidor'){
	// 	$filtro = ' and id_usu_venta = "'.$_SESSION['iduser'].'"';
	// }else{
	// 	$filtro = '';
	// }
	include '../conexion.php';
	$local = $_REQUEST['localiact'];
	$evento_reimprime = $_REQUEST['evento_reimprime'];
	$distri = $_REQUEST['distri'];
	
	$sql1 = 'SELECT * FROM Localidad where idLocalidad = "'.$local.'" ';
	$res1 = mysql_query($sql1) or die (mysql_error());
	$row1 = mysql_fetch_array($res1);
	$filtroDist = '';
	$nameIt = '';
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
	$sql = 'SELECT * FROM Boleto where  idCon = "'.$evento_reimprime.'0000" and idLocB = "'.$local.'" '.$filtroDist.' order by serie_localidad ASC';
	$res = mysql_query($sql) or die (mysql_error());
	$i=0;
	$sqlCount = 'SELECT count(idBoleto) as cuantos FROM Boleto where  idCon = "'.$evento_reimprime.'0000" and idLocB = "'.$local.'" '.$filtroDist.' order by serie_localidad ASC';
	$resCount = mysql_query($sqlCount) or die (mysql_error());
	$rowCount = mysql_fetch_array($resCount);
	if ($nameIt != '') {
		echo "<h4>Boletos de baja para ".$nameIt.": ".$rowCount['cuantos']."</h4>";
	}else{
		echo "<h4>Boletos de baja:".$rowCount['cuantos']."</h4>";
	}
	echo '<table class = "table">';
	if(mysql_num_rows($res) == '' || mysql_num_rows($res) == null){
		echo '<tr><td>NO HAY BOLETOS DE BAJA</td></tr>';
	}
	while($row = mysql_fetch_array($res)){
		$sqlD = 'SELECT * FROM descuentos where idloc = "'.$row['idLocB'].'" and id = "'.$row['id_desc'].'" ';
		$resD = mysql_query($sqlD) or die (mysql_error());
		$rowD = mysql_fetch_array($resD);
		if($row['id_desc'] == 0){
			$desc = 'normal';
			$valor = $row1['doublePrecioL'];
		}else{
			$desc = $rowD['nom'];
			$valor = $rowD['val'];
		}
		if($i==0){
			echo '<tr>';
		}
		echo'<td style ="border:1px solid #ccc;" >
				'.$row1['strDateStateL'].' - '.$row['serie_localidad'].'<br>'.$row['strBarcode'].'<br>
				'.$desc.' -- '.$valor.'-- <input id="data-value" type="hidden" value="'.$row['idBoleto'].'"/>
			</td>';
		if($i==7){
			echo '</tr>';
			$i=0;
		}
		
		else{
			$i++;
		}
	}
	echo '</table>';
?>