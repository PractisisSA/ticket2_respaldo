<?php
	include '../conexion.php';
	$rucAHIS = $_REQUEST['rucCliente'];
	$nombrecomercialAHIS = $_REQUEST['razonsocial'];
	$desestablecimientoAHIS = $_REQUEST['establecimiento'];
	$codestablecimientoAHIS = $_REQUEST['serie'];
	$dirmatrizAHIS = $_REQUEST['matriz'];
	$direstablecimientoAHIS = $_REQUEST['direstab'];
	$tipocontribuyenteAHIS = $_REQUEST['contribuyente'];
	$nroespecialAHIS = $_REQUEST['nrocontribuyente'];
	$fechaautorizacioA = $_REQUEST['fauto'];
	$fechacaducidadA = $_REQUEST['fcadu'];
	$nroautorizacionA = $_REQUEST['nroAuto'];
	$facnegociablesA = $_REQUEST['nego'];
	$observacionA = $_REQUEST['obs'];
	
	$dod_serie = $_REQUEST['dod_serie'];
	$expDoc_serie = explode('-',$dod_serie);
	$serieemisionA = $expDoc_serie[1];
	
	
	$tipodocumentoA = $_REQUEST['tipodocumentoA'];
	$secuencialinicialA = $_REQUEST['inicial'];
	$secuencialfinalA = $_REQUEST['final_'];
	$idAutorizacion = $_REQUEST['id'];
	
	$sql = 'update autorizaciones set 
								rucAHIS = "'.$rucAHIS.'",
								nombrecomercialAHIS = "'.$nombrecomercialAHIS.'" , 
								desestablecimientoAHIS = "'.$desestablecimientoAHIS.'" , 
								codestablecimientoAHIS = "'.$codestablecimientoAHIS.'" , 
								dirmatrizAHIS = "'.$dirmatrizAHIS.'" , 
								direstablecimientoAHIS = "'.$direstablecimientoAHIS.'" , 
								tipocontribuyenteAHIS = "'.$tipocontribuyenteAHIS.'" , 
								nroespecialAHIS = "'.$nroespecialAHIS.'" , 
								fechaautorizacioA = "'.$fechaautorizacioA.'" , 
								fechacaducidadA = "'.$fechacaducidadA.'" , 
								nroautorizacionA = "'.$nroautorizacionA.'" , 
								facnegociablesA = "'.$facnegociablesA.'" , 
								observacionA = "'.$observacionA.'" , 
								serieemisionA = "'.$serieemisionA.'" , 
								tipodocumentoA = "'.$tipodocumentoA.'" , 
								secuencialinicialA = "'.$secuencialinicialA.'" , 
								secuencialfinalA = "'.$secuencialfinalA.'" 

								where idAutorizacion = "'.$idAutorizacion.'" 
			';
	// echo $sql;
	$res = mysql_query($sql) or die(mysql_error());
	
	echo 'Autorizacion Actualizada con Éxito';
?>