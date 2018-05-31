<?php
	session_start();
	$quien_vendio_boleto = 0;
	if($_SESSION['tipo_emp'] == 1){
		$quien_vendio_boleto = 3;
	}elseif($_SESSION['tipo_emp'] == 2){
		$quien_vendio_boleto = 2;
	}
	
	
	include '../conexion.php';
	$boleto = $_REQUEST['boleto'];
	$ident = $_REQUEST['ident'];
	if($ident == 1){
		$sql = 'update Boleto set idCon = "3000" where strBarcode = "'.$boleto.'" ';
		$res = mysql_query($sql) or die(mysql_error());
		echo 'El boleto : '.$boleto.' , a sido dado de baja con Éxito!!!';
	}
	elseif($ident == 2){
		$sql1 = 'select strEstado from Boleto where strBarcode = "'.$boleto.'" and strEstado = "A" ';
		$res1 = mysql_query($sql1) or die (mysql_error());
		$row1 = mysql_fetch_array($res1);
		$strEstado = $row1['strEstado'];
		if($strEstado == 'A'){
			//echo 'si podra reasignar';
			$sql = 'update Boleto set id_usu_venta = "'.$_SESSION['iduser'].'" , colB = "'.$quien_vendio_boleto.'" where strBarcode = "'.$boleto.'" ';
			$res = mysql_query($sql) or die(mysql_error());
			
			$sqlB = 'select idBoleto from Boleto where strBarcode = "'.$boleto.'" ';
			$resB = mysql_query($sqlB) or die (mysql_error());
			$rowB = mysql_fetch_array($resB);
			$idBoleto = $rowB['idBoleto'];
			
			$sqlUt = 'update transaccion_distribuidor set iddistribuidortrans = "'.$_SESSION['idDis'].'" where numboletos = "'.$idBoleto.'" ';
			$resUt = mysql_query($sqlUt) or die (mysql_error());
			
			echo 'El boleto : '.$boleto.' , a sido reasignado al PUNTO DE VENTA actual con Éxito!!!';
		}else{
			echo 'este boleto ya a sido ingresado no puede cambiarlo de usuario';
		}
	}
?>