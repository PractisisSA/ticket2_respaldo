<?php
	include '../conexion.php';
	
	$idloc = $_REQUEST['idloc'];
	$idcon = $_REQUEST['idcon'];
	$tipoButacas = $_REQUEST['tipoButacas'];
	
	$sqlB = 'update Butaca set strSecuencial = "'.$tipoButacas.'" where intLocalB = "'.$idloc.'" and intConcB = "'.$idcon.'" ';
	// echo $sqlB;
	$resB = mysql_query($sqlB) or die (mysql_error());
	
	// $sqlBu = 'select strSecuencial from Butaca where intLocalB = "'.$idloc.'" and intConcB = "'.$idcon.'"  ';
	// // echo $sqlBu;					
	// $resBu = mysql_query($sqlBu) or die (mysql_error());
	// $rowBu = mysql_fetch_array($resBu);
	// // echo $rowBu['strSecuencial'];
	// if($rowBu['strSecuencial'] == 0){
		// $optionBu = '
						// <option value = "0" selected = "selected" >Numerico</option>
						// <option value = "1">Alfanumerico</option>
					// ';
	// }else{
		// $optionBu = '
						// <option value = "0">Numerico</option>
						// <option value = "1" selected = "selected" >Alfanumerico</option>
					// ';
	// }
	
	// echo $optionBu;
?>