<?php
	session_start();
	$idconciertotrans = $_REQUEST['evento_distri'];
	include '../../conexion.php';
	
	if($_SESSION['perfil'] == 'Distribuidor' ){
		$filtro = 'and iddistribuidortrans = "'.$_SESSION['idDis'].'" ';
		$option = '<option value="">Seleccione</option>';
	}else{
		$option  = "<option value=''>Seleccione</option>";
		$filtro = 'and iddistribuidortrans != 0';
	}
	
	
	$sql = 'SELECT * FROM transaccion_distribuidor WHERE idconciertotrans = "'.$idconciertotrans.'" '.$filtro.' GROUP BY iddistribuidortrans;';
	
	echo $sql;
	$res = mysql_query($sql) or die (mysql_error());

	$sql1 = 'SELECT count(iddistribuidortrans) as cuantos FROM transaccion_distribuidor WHERE idconciertotrans = "'.$idconciertotrans.'"';
	$res1 = mysql_query($sql1) or die (mysql_error());
	$row1 = mysql_fetch_array($res1);

	if ($row1['cuantos'] != 0 ) {
		
		echo $option;		
		while ($row = mysql_fetch_array($res)) {
			$sqlD1 = 'SELECT * FROM distribuidor WHERE idDistribuidor = "'.$row['iddistribuidortrans'].'"';

			// echo $sqlD1."<br>";
			$resD1 = mysql_query($sqlD1) or die (mysql_error());
			$rowD1 = mysql_fetch_array($resD1);
			echo '<option value="'.$rowD1['idDistribuidor'].'">'.$rowD1['mailDis'].'</option>';
		}
	}else{
		echo 1;
	}
	
?>