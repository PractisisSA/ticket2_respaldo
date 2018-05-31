<?php
	session_start();

	if($_SESSION['perfil'] == 'Distribuidor'){
		$filtro = ' and id_usu_venta = "'.$_SESSION['iduser'].'"';
	}else{
		$filtro = '';
	}

	include '../conexion.php';
	$local_desde = $_REQUEST['local_desde'];
	$evento_reimprime = $_REQUEST['evento_reimprime'];
	$distri = $_REQUEST['distri'];

	$sql1 = 'SELECT * FROM Localidad where idLocalidad = "'.$local_desde.'" ';
	$res1 = mysql_query($sql1) or die (mysql_error());
	$row1 = mysql_fetch_array($res1);
	
	$idDist = '';

	$filtroDist = '';

	$nameIt = '';

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

	$sql = 'SELECT * FROM Boleto where  idCon = "'.$evento_reimprime.'" and idLocB = "'.$local_desde.'" '.$filtroDist.' order by serie_localidad ASC';
	$res = mysql_query($sql) or die (mysql_error());
	$i=0;

	$sqlCount = 'SELECT count(idBoleto) as cuantos FROM Boleto where  idCon = "'.$evento_reimprime.'" and idLocB = "'.$local_desde.'" '.$filtroDist.' order by serie_localidad ASC';
	$resCount = mysql_query($sqlCount) or die (mysql_error());
	$rowCount = mysql_fetch_array($resCount);

	if ($nameIt != '') {
		echo "<h4>Boletos activos para ".$nameIt.": ".$rowCount['cuantos']."</h4>";
	}else{
		echo "<h4>Boletos activos:".$rowCount['cuantos']."</h4>";
	}
	

	echo '<table class = "table">';
	
	if(mysql_num_rows($res) == '' || mysql_num_rows($res) == null){
		echo '<tr><td>NO HAY BOLETOS VENDIDOS DE ESTA LOCALIDAD</td></tr>';
	}
	while($row = mysql_fetch_array($res)){
		
		$sqlR = 'select count(id) as cuantos from reimpresio_boleto where barcode = "'.$row['idBoleto'].'" ';
		$resR = mysql_query($sqlR) or die (mysql_error());
		$rowR = mysql_fetch_array($resR);
		
		
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
		
		if($rowR['cuantos'] > 0 ){
			$color = 'color:red;';
		}else{
			$color = '';
		}
		
		if($i==0){
			echo '<tr>';
		}
		echo'<td style ="border:1px solid #ccc;" >
				'.$row1['strDateStateL'].' - '.$row['serie_localidad'].'<br>'.$row['strBarcode'].'<br>
				'.$desc.' -- '.$valor.'<br>
				<label style = "'.$color.'" >Reimpresos : '.$rowR['cuantos'].'</label>
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