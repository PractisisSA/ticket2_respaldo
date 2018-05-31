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
	
	$sql1 = 'SELECT * FROM Localidad where idLocalidad = "'.$local_desde.'" ';
	$res1 = mysql_query($sql1) or die (mysql_error());
	$row1 = mysql_fetch_array($res1);
	$sql = 'SELECT * FROM Boleto where  idCon = "'.$evento_reimprime.'" and idLocB = "'.$local_desde.'" '.$filtro.' order by serie_localidad ASC';
	$res = mysql_query($sql) or die (mysql_error());
	$i=0;
	echo '<table class = "table">';
	
	if(mysql_num_rows($res) == '' || mysql_num_rows($res) == null){
		echo '<tr><td>NO HAY BOLETOS VENDIDOS DE ESTA LOCALIDAD</td></tr>';
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
				'.$desc.' -- '.$valor.'
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

	// session_start();
	// $distri = $_REQUEST['distri'];
	// if($_SESSION['perfil'] == 'Distribuidor'){
	// 	if ($distri) {
	// 		$filtro = ' and id_usu_venta = "'.$_SESSION['iduser'].'"';
	// 	}
	// }else{
	// 	$filtro = '';
	// }
	// include '../conexion.php';
	// $local_desde = $_REQUEST['local_desde'];
	// $evento_reimprime = $_REQUEST['evento_reimprime'];
	

	// $sql1 = 'SELECT idUsuario FROM Usuario WHERE strObsCreacion = '.$distri.'';
	// $res1 = mysql_query($sql1) or die (mysql_error());
	// $row1 = mysql_fetch_array($res1);


	// $sql = 'SELECT * FROM Boleto where  idCon = "'.$evento_reimprime.'" and idLocB = "'.$local_desde.'" and id_usu_venta = '.$row1['idUsuario'].' order by serie_localidad ASC';
	// $res = mysql_query($sql) or die (mysql_error());

	// echo $sql;
	
	// $sql1 = 'SELECT * FROM Localidad where idLocalidad = "'.$local_desde.'" ';
	// $res1 = mysql_query($sql1) or die (mysql_error());
	// $row1 = mysql_fetch_array($res1);
	// $sql = 'SELECT * FROM Boleto where  idCon = "'.$evento_reimprime.'" and idLocB = "'.$local_desde.'" '.$filtro.' order by serie_localidad ASC';
	// $res = mysql_query($sql) or die (mysql_error());
	// $i=0;
	// echo '<table class = "table">';
	// if(mysql_num_rows($res) == '' || mysql_num_rows($res) == null){
	// 	echo '<tr><td>NO HAY BOLETOS VENDIDOS DE ESTA LOCALIDAD</td></tr>';
	// }
	// while($row = mysql_fetch_array($res)){
	// 	$sqlD = 'SELECT * FROM descuentos where idloc = "'.$row['idLocB'].'" and id = "'.$row['id_desc'].'" ';
	// 	$resD = mysql_query($sqlD) or die (mysql_error());
	// 	$rowD = mysql_fetch_array($resD);
	// 	if($row['id_desc'] == 0){
	// 		$desc = 'normal';
	// 		$valor = $row1['doublePrecioL'];
	// 	}else{
	// 		$desc = $rowD['nom'];
	// 		$valor = $rowD['val'];
	// 	}
	// 	if($i==0){
	// 		echo '<tr>';
	// 	}
	// 	echo'<td style ="border:1px solid #ccc;" >
	// 			'.$row1['strDateStateL'].' - '.$row['serie_localidad'].'<br>'.$row['strBarcode'].'<br>
	// 			'.$desc.' -- '.$valor.'
	// 		</td>';
	// 	if($i==7){
	// 		echo '</tr>';
	// 		$i=0;
	// 	}
		
	// 	else{
	// 		$i++;
	// 	}
	// }
	// echo '</table>';
?>