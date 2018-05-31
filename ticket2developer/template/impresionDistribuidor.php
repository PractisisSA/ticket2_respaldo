<?php
	session_start();
	
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	include '../conexion.php';
	
	
	$codigo = $_SESSION['barcode'];
	$idboleto = $_REQUEST['cadaBoleto'];
	$sqlImpBol = 'select * from Boleto where idBoleto = "'.$idboleto.'"';
	$resImpBol = mysql_query($sqlImpBol) or die(mysql_error());
	$rowImp = mysql_fetch_array($resImpBol);
	$strBarcode = trim($rowImp['strBarcode']);
	$idcli = $rowImp['idCli'];
	$idLocB = $rowImp['idLocB'];
	
	
	
	$sqlLoc = 'select * from Localidad where idLocalidad = "'.$idLocB.'"';
	//echo $sqlDetBol;
	$resLoc = mysql_query($sqlLoc) or die (mysql_error());
	$rowLoc = mysql_fetch_array($resLoc);
	$doublePrecioL = $rowLoc['doublePrecioL'];
	
	
	
	$sqlDetBol = 'select * from detalle_boleto where idBoleto = "'.$idboleto.'"';
	//echo $sqlDetBol;
	$resDetBol = mysql_query($sqlDetBol) or die (mysql_error());
	$rowDetBol = mysql_fetch_array($resDetBol);
	$idBoleto = $rowImp['idBoleto'];
	
	$sqlCli = 'SELECT * FROM Cliente WHERE idCliente = "'.$idcli.'"';
	$resCli = mysql_query($sqlCli) or die (mysql_error());
	$rowCli = mysql_fetch_array($resCli);
	$envio = $rowCli['strEnvioC'];
	$dir = $rowCli['strDireccionC'];
	$strDocumentoC = $rowCli['strDocumentoC'];
	$strNombresC = $rowCli['strNombresC'];
	
	
	$sqlCon = 'select * from Concierto where idConcierto = "'.$rowImp['idCon'].'" ';
	//echo $sqlCon;
	$resCon = mysql_query($sqlCon) or die (mysql_error());
	$rowBol = mysql_fetch_array($resCon);
	$strEvento = $rowBol['strEvento'];
	$strLugar = $rowBol['strLugar'];
	$dateFecha = $rowBol['dateFecha'];
	$timeHora = $rowBol['timeHora'];
	$idUser = $rowBol['idUser'];
	$tiene_permisos = $rowBol['tiene_permisos'];
	$autMunCon = $rowBol['autMun'];
	$dircanjeC = $rowBol['dircanjeC'];
	$fechainiciocanjeC = $rowBol['fechainiciocanjeC'];
	$dateFechaPreventa = $rowBol['dateFechaPreventa'];
	
	$hoy = date("Y-m-d");
	if($hoy <= $dateFechaPreventa){
		$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$idLocB.'"';
		$resLocalidad = mysql_query($localidad) or die (mysql_error());
		$rowLocalidad = mysql_fetch_array($resLocalidad);
		$precioVenta = $rowLocalidad['doublePrecioPreventa'];
		
	}else{
		$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$idLocB.'"';
		$resLocalidad = mysql_query($localidad) or die (mysql_error());
		$rowLocalidad = mysql_fetch_array($resLocalidad);
		$precioVenta = $rowLocalidad['doublePrecioL'];
	}
	
	$sqlEmpresa = 'select * from ticktfacil';
	$resEmpresa = mysql_query($sqlEmpresa) or die (mysql_error());
	$rowEmpresa = mysql_fetch_array($resEmpresa);
	
	
	
	
	$fechaExp = explode("-",$dateFecha);
	$anio = $fechaExp[0];
	$mes = $fechaExp[1];
	$diaF = $fechaExp[2];
	
	$fechaMostrar = $diaF."-".$mes."-".$anio;
	
	$fechaConcierto = '2016-03-27';
	$timestamp = strtotime($dateFecha);
	
	
	$day = date('D', $timestamp);
	if($day == 'Mon'){
		$dia = 'Lunes';
	}elseif($day == 'Tue'){
		$dia = 'Martes';
	}elseif($day == 'Wed'){
		$dia = 'Miércoles';
	}elseif($day == 'Thu'){
		$dia = 'Jueves';
	}elseif($day == 'Fri'){
		$dia = 'Viernes';
	}elseif($day == 'Sat'){
		$dia = 'Sábado';
	}elseif($day == 'Sun'){
		$dia = 'Domingo';
	}
	//echo $fechaConcierto." ".$day." ".$dia;
	
	//$img = '<img alt="" src="http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$strBarcode.'" />';
	$fechaImp =  date("Y-m-d");
	$fechaImpExp = explode("-",$fechaImp);
	$anioExp = $fechaImpExp[0];
	$mesExp = $fechaImpExp[1];
	$diaExp = $fechaImpExp[2];
	
	$anioExpiracion = ($anioExp + 1);
	
	$fechaExpiracion = $anioExpiracion." ".$mesExp."-".$diaExp;
	
	
	$nombreFichero = 'http://ticketfacil.ec/ticket2/subpages/Compras/barcode/'.$rowImp['strBarcode'].'.png';
	$nombreFichero2 = 'http://ticketfacil.ec/ticket2/distribuidor/ventas/ajax/barcode/'.$rowImp['strBarcode'].'.png';
	$nombreFichero3 = 'http://ticketfacil.ec/ticket2/distribuidor/cobros/ajax/barcode/'.$rowImp['strBarcode'].'.png';
	//echo $nombreFichero3."<br/>";
	//echo $nombreFichero;
	function image_exists($url){
		if(getimagesize($url)){
			return 1;
		}else{
			return 0;
		}
	}
	
	if(image_exists('http://ticketfacil.ec/ticket2/pagekiosko/subpages/Compras/barcode/'.$rowImp['strBarcode'].'.png') == 1){
		$ruta = 'http://ticketfacil.ec/ticket2/pagekiosko/subpages/Compras/barcode/'.$rowImp['strBarcode'].'.png';
	}else{
		if(image_exists('http://ticketfacil.ec/ticket2/distribuidor/ventas/ajax/barcode/'.$rowImp['strBarcode'].'.png') == 1){
			$ruta = 'http://ticketfacil.ec/ticket2/distribuidor/ventas/ajax/barcode/'.$rowImp['strBarcode'].'.png';
		}else{
			if(image_exists('http://ticketfacil.ec/ticket2/distribuidor/cobros/ajax/barcode/'.$rowImp['strBarcode'].'.png')==1){
				$ruta = 'http://ticketfacil.ec/ticket2/distribuidor/cobros/ajax/barcode/'.$rowImp['strBarcode'].'.png';
			}else{
				if(image_exists('http://ticketfacil.ec/ticket2/subpages/Compras/barcode/'.$rowImp['strBarcode'].'.png')==1){
					$ruta = 'http://ticketfacil.ec/ticket2/subpages/Compras/barcode/'.$rowImp['strBarcode'].'.png';
				}
			}
		}
	}
	if(!isset($_SESSION['tipo_emp'])){
		$_SESSION['tipo_emp']=1;
	}
		$nom = $_SESSION['username'];
		$content = '
			<page>
				<div style="border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;">
					<table align="center" style="width:400px; border-collapse:separate; border-spacing:15px 5px;font-size:11px;" class="table table-hover">
						<tr>
							<td style="text-align:center;">
								<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="200px"/>
							</td>
						</tr>
						<tr>
							<td style="text-align:center;">
								Estimado <h3 style="text-transform:capitalize;">'.$strNombresC.'</h3> <br/>Esto es un comprobante de pago :
							</td>
						</tr>
						<tr>
							<td>
								* Sus asientos estan reservados, <span style="color:#EC1867;">por un valor de <strong>$'.$precioVenta.'</strong></span>,
							</td>
						</tr>
						<tr>
							<td>
								Usted podrá canjear sus tickets en :'.$rowBol['dircanjeC'].' 
								desde el dia : '.$rowBol['fechainiciocanjeC'].' hasta el dia '.$rowBol['fechafinalcanjeC'].'
								el el horario de : '.$rowBol['horariocanjeC'].'<br/>
								* Para el concierto de :<center><h3><strong>'.$strEvento.'</strong><h3></center>
								<br/><br/>
								Para realizar el CANJE, debe acercarce con este recibo y el Documento de Identidad del dueño del boleto <br/>
							</td>
						</tr>
						<tr>
							<td valign="middle" align="center">
								* Su código de compra es el siguiente:<br/>
								<img src="'.$ruta.'" /><br/>
								 <span style="color:#EC1867;"><strong>'.$rowImp['strBarcode'].'</strong></span>
							</tr>
						</tr>
						<tr>
							<td style="text-align:center;">
								<strong>Gracias por Preferirnos</strong>
								<br>
								<strong>TICKETFACIL <I>"La mejor experiencia de compra En Línea"</I></strong>
							</td>
						</tr>
					</table>
				</div>
			</page>';
			echo $content;
	
	
?>