<?php
	session_start();
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	include 'conexion.php';
	$codigo = $_SESSION['barcode'];
	$boleto = mysql_real_escape_string($_REQUEST['boleto']);
	//$idboleto = 398;
	$timeRightNow = time();
	$img = 'qr/'.$timeRightNow.'.png';
	
	$sql1 = 'select b.* , i.*
			from Boleto as b, imp_boleto as i 
			where b.strBarcode = "'.$boleto.'" 
			and i.codbarras = b.strBarcode';
	//echo $sql1;
	$res1 = mysql_query($sql1) or die (mysql_error());
	$row1 = mysql_fetch_array($res1);
	//echo "hay ".mysql_num_rows($row1)."<br>";
	if(mysql_num_rows($res1) > 0 ){
		echo 3;
	}else{
		$sql2 = 'select idbo from imp_boleto where idbo = "'.$row1['idBoleto'].'" ';
		//echo $sql2;
		$res2 = mysql_query($sql2) or die (mysql_error());
		if(mysql_num_rows($res2) > 0){
			echo 1;
		}else{
			$sql3 = 'select strBarcode from Boleto where strBarcode = "'.$boleto.'" ';
			//echo $sql3;
			$res3 = mysql_query($sql3) or die (mysql_error());
			if(mysql_num_rows($res3) > 0){
				$sqlImpBol = '	select b.idBoleto , b.strBarcode , b.idCli , b.idCon , c.tiene_permisos , c.tipo_conc
								from Boleto as b , Concierto as c
								where strBarcode = "'.$boleto.'" 
								and c.idConcierto = b.idCon
								and c.tiene_permisos > 0';
				//echo $sqlImpBol;
				$resImpBol = mysql_query($sqlImpBol) or die(mysql_error());
				
				if(mysql_num_rows($resImpBol)>0){
					$rowImp = mysql_fetch_array($resImpBol);
					$strBarcode = trim($rowImp['strBarcode']);
					$idCli = $rowImp['idCli'];
					$idCon = $rowImp['idCon'];
					$idBoleto = $rowImp['idBoleto'];
					$tipo_conc = $rowImp['tipo_conc'];
					$_SESSION['idConImprime'] = $idCon;
					echo $strBarcode."|".$idCli."|".$idCon."|".$idBoleto."|".$tipo_conc;
				}else{
					echo 0;
				}
			}else {
				echo 2;
			}
		}
	}
?>