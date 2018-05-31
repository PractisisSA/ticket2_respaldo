<?php

$cedulaCli = $_REQUEST['cedulaCli'];
include '../../conexion.php';
function ReemplazarTildes($texto){
	$texto=str_replace("á","&aacute;",$texto);
	$texto=str_replace("é","&eacute;",$texto);
	$texto=str_replace("í","&iacute;",$texto);
	$texto=str_replace("ó","&oacute;",$texto);
	$texto=str_replace("ú","&uacute;",$texto);
	$texto=str_replace("ñ","&ntilde;",$texto);
	$texto=str_replace("Á","&Aacute;",$texto);
	$texto=str_replace("É","&Eacute;",$texto);
	$texto=str_replace("Í","&Iacute;",$texto);
	$texto=str_replace("Ó","&Oacute;",$texto);
	$texto=str_replace("Ú","&Uacute;",$texto);
	$texto=str_replace("Ñ","&Ntilde;",$texto);
	return $texto;
}
	$sql = 'select count(idCliente) as cuantos from Cliente where strDocumentoC = "'.$cedulaCli.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);

	if($row['cuantos'] > 0){
		$queryLocales=mysql_query("SELECT * FROM Cliente where strDocumentoC = '$cedulaCli'") or die(mysql_error());
		
		$json =' { "cliente" : ['	;
		
			while($row=mysql_fetch_array($queryLocales))
			{
				
				$idCliente=$row['idCliente'];
				$strNombresC= htmlentities(utf8_decode($row['strNombresC']));
				$strDocumentoC=$row['strDocumentoC'];
				$strMailC=$row['strMailC'];
				$strDireccionC = ReemplazarTildes($row['strDireccionC']);
				$intTelefonoMovC=$row['intTelefonoMovC'];
				$strTelefonoC=$row['strTelefonoC'];
				
				$json .= '{ 
							"idCliente" : "'.$idCliente.'" ,
							"strNombresC" : "'.$strNombresC.'" ,
							"strDocumentoC" : "'.$strDocumentoC.'" ,
							"strMailC" : "'.$strMailC.'" ,
							"strDireccionC" : "'.$strDireccionC.'" ,
							"intTelefonoMovC" : "'.$intTelefonoMovC.'" ,
							"strTelefonoC" : "'.$strTelefonoC.'" 
						},';
			}
			$json=substr($json,0,-1);
		
		$json.=' ]}';
		echo $json;
	}else{
		echo 0;
	}
?>
