<?php
	include '../conexion.php';

    $que =(int) $_REQUEST['que'];

    if($que == 1){

	$idCon =(int) $_REQUEST['id'];
	$porcpaypal =(float) $_REQUEST['porcpaypal'];
    $valpaypal =(float) $_REQUEST['valpaypal'];
    $porcstripe =(float) $_REQUEST['porcstripe'];
    $valstripe =(float) $_REQUEST['valstripe'];
    $comis_transfer =(float) $_REQUEST['comis_transfer'];
    $porce_transfer =(float) $_REQUEST['porce_transfer'];

		$sql = "update Concierto set porcpaypal=$porcpaypal,valpaypal=$valpaypal,porcstripe=$porcstripe,valstripe=$valstripe,comis_transfer=$comis_transfer,porce_transfer=$porce_transfer  where idConcierto = $idCon";
		$res = mysql_query($sql) or die (mysql_error());
		if($res){
			echo 'Guardado con Éxito';
		}else{
			echo 'Error , comuniquese con el administrador del sistema';
		}

    }

?>