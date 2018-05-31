<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	date_default_timezone_set("America/Guayaquil");
	$hoy = date("Y-m-d H:i:s");
	include 'conexion.php';
	$boleto = $_REQUEST['boleto'];
	$idCli = $_REQUEST['idCli'];
	$cedula = mysql_real_escape_string($_REQUEST['cedula']);
	$idBoleto = $_REQUEST['idBoleto'];
	//$idboleto = 398;
	$timeRightNow = time();
	$img = 'qr/'.$timeRightNow.'.png';
	$sqlImpBol = 'select b.*, c.idCliente , c.strDocumentoC
					from Boleto as b , Cliente as c
					where b.idBoleto = "'.trim($idBoleto).'"
					and b.idCli = c.idCliente
					and c.idCliente = "'.trim($idCli).'"
					and c.strDocumentoC = "'.trim($cedula).'" ';
	//echo $sqlImpBol; 
	$resImpBol = mysql_query($sqlImpBol) or die(mysql_error());
	
	$ruta = 'http://ticketfacil.ec/pagekiosko/subpages/Compras/barcode/';
	if (file_exists($nombre_fichero)) {
		$rutaImp = 'http://ticketfacil.ec/pagekiosko/subpages/Compras/barcode/';
	} else {
		$rutaImp = 'http://ticketfacil.ec/subpages/Compras/barcode/';
	}


	if(mysql_num_rows($resImpBol)>0){
		$rowImp = mysql_fetch_array($resImpBol);
		$strBarcode = trim($rowImp['strBarcode']);
		$idcli = $rowImp['idCli'];
		$idBoleto = $rowImp['idBoleto'];
		
		
		$sqlDetBol = 'select * from detalle_boleto where idBoleto = "'.$idBoleto.'"';
		$resDetBol = mysql_query($sqlDetBol) or die (mysql_error());
		$rowDetBol = mysql_fetch_array($resDetBol);
		
		
		$sqlCli = 'SELECT * FROM Cliente WHERE idCliente = "'.$idcli.'"';
		$resCli = mysql_query($sqlCli) or die (mysql_error());
		$row1 = mysql_fetch_array($resCli);
		$envio = $row1['strEnvioC'];
		$dir = $row1['strDireccionC'];
		$strDocumentoC = $row1['strDocumentoC'];
		
		
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
		
		$sqlAut = 'select * from autorizaciones where idsocioA = "'.$idUser.'" order by idAutorizacion ASC limit 1';
		$resAut = mysql_query($sqlAut) or die (mysql_error());
		$rowAut = mysql_fetch_array($resAut);
		$rucAHIS = $rowAut['rucAHIS']; 
		$nombrecomercialAHIS = $rowAut['nombrecomercialAHIS'];  
		$dirmatrizAHIS = $rowAut['dirmatrizAHIS'];  
		$tipocontribuyenteAHIS = $rowAut['tipocontribuyenteAHIS'];    
		$nroautorizacionA = $rowAut['nroautorizacionA'];// $rowAut[''];
		
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
		
		// echo $tiene_permisos."hola";
		// exit;
		if($tiene_permisos != 0){
			$autorizaciones = '
				<label style="font-size:6px;" id="parteDiminuta">
					AUTH MUN: 206-ESP-0043<BR>
					RUC '.$rucAHIS.', '.$tipocontribuyenteAHIS.' <BR>
					'.$nombrecomercialAHIS.'<BR>
					'.$dirmatrizAHIS.', AUTH '.$nroautorizacionA.'<BR>
					SEC AUT. '.$rowEmpresa['nroautorizacionTF'].', PIE 099254749001 '.$rowEmpresa['razonsocialTF'].' <BR>
					BOLETO: ('.$rowImp['idCon'].'-'.$rowImp['idBoleto'].' VALIDEZ: '.$fechaImp.'-'.$fechaExpiracion.')
				</label>
			';
			
			$autorizaciones2 = ' 
				<div style="font-size:6px;background-color:;width:200px;" id="parteDiminuta">
					<span>
						AUTH MUN: 206-ESP-0043  
						RUC '.$rucAHIS.', '.$tipocontribuyenteAHIS.' 
					</span><br/>
					<span>
						'.$nombrecomercialAHIS.'
						'.$dirmatrizAHIS.', AUTH '.$nroautorizacionA.'
					</span>
					SEC AUT. '.$rowEmpresa['nroautorizacionTF'].', PIE 099254749001 '.$rowEmpresa['razonsocialTF'].' <BR>
					BOLETO: ('.$rowImp['idCon'].'-'.$rowImp['idBoleto'].' VALIDEZ: '.$fechaImp.'-'.$fechaExpiracion.')
				</div>';
			
			
			$textoVenta = '';
			
			$print = '
				<div id="contieneElBoletoImprime" style="width:auto;">
					<table height="auto" border="0" style="border:2px dashed #ccc;" >
						
						<tr>
							<td valign="middle" align="left" style="border-bottom:2px dashed #ccc;">
								<img src="'.$rutaImp.''.$rowImp['strBarcode'].'.png" width="200px" style="text-align:center;height:40px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);"/><br/>
								<center>
									<span style="text-align:center;height:40px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);font-size:10px;">'.$rowImp['strBarcode'].'</span>
								</center>
								<div style="-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(-180deg);">
									<div style="font-size:10px;padding-left:10px;text-align:left;height:;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);" >
										'.$autorizaciones.'
									</div>
									<div style="padding-bottom:10px;text-align:center;height:50px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);" >
										<span style="font-weight:bolder;font-family:roboto,sans-serif;font-size:10px;">'.$strEvento.'</span><br/>
										<div style="width:100%;text-align:center;font-size:9px;">
											<span style="font-family:roboto,sans-serif;">'.$strLugar.'</span>
										</div>
										<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:9px;"><strong>'.$rowDetBol['localidad'].'</strong> <strong>'.$rowDetBol['asientos'].'</strong></span><br/>
										<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:12px;font-weight:bolder;">Valor US $: <strong>'.$rowDetBol['precio'].'</strong></span><br/>
										<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:12px;font-weight:bolder;"><strong>'.$textoVenta.'</strong></span><br/>
									</div>
								</div>
							</td>
						</tr>
						
						<tr>
							<td valign="middle" align="left">
								<table width="100%" height="100%" border="0">
									<tr>
										<td align="center">
											<img src="'.$rutaImp.''.$rowImp['strBarcode'].'.png" width="200px" style="text-align:center;height:40px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);"/><br/>
											<span style="text-align:center;height:40px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);font-size:10px;">'.$rowImp['strBarcode'].'</span>
										</td>
									</tr>
									<tr>
										<td>
											<div style="padding:5px;text-align:center;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(90deg);">
												<span style="font-weight:bolder;font-family:roboto,sans-serif;font-size:14px;">'.$strEvento.'</span>
												<div style="width:100%;text-align:center;">
													<span style="font-family:roboto,sans-serif;font-size:12px;">'.$strLugar.'</span>
												</div>
												<br/>
												<span style="font-family:roboto,sans-serif;font-size:11px;">'.$dia.' - '.$fechaMostrar.' <br/> '.$timeHora.'</span><br/>
												<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:10px;"><strong>'.$rowDetBol['localidad'].'</strong> <strong>'.$rowDetBol['asientos'].'</strong></span><br/>
												<span align="center" style="font-family:roboto,sans-serif;font-size:10px;"><strong> Valor: US $ '.$rowDetBol['precio'].'</strong></span><br/>
												<span align="center" style="font-family:roboto,sans-serif;font-size:10px;"><strong> '.$textoVenta.'</strong></span><br/>
												<div style="text-align:left;padding-top: 10px;padding-bottom: 10px">'.$autorizaciones2.'</div>
											</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td valign="middle" align="left" style="border-top:2px dashed #ccc;" height="auto">
								<div style="-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(-180deg);">
									<div style="font-size:10px;padding-left:10px;text-align:left;height:;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);" >
										'.$autorizaciones.'
									</div>
									<div style="padding-bottom:10px;text-align:center;height:50px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);" >
										<span style="font-weight:bolder;font-family:roboto,sans-serif;font-size:10px;">'.$strEvento.'</span><br/>
										<div style="width:100%;text-align:center;font-size:9px;">
											<span style="font-family:roboto,sans-serif;">'.$strLugar.'</span>
										</div>
										<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:9px;"><strong>'.$rowDetBol['localidad'].'</strong> <strong>'.$rowDetBol['asientos'].'</strong></span><br/>
										<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:12px;font-weight:bolder;">Valor US $: <strong>'.$rowDetBol['precio'].'</strong></span><br/>
										<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:12px;font-weight:bolder;"><strong>'.$textoVenta.'</strong></span><br/>
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>'; 
			$sqlImp = 'INSERT INTO `imp_boleto` (`id`, `idbo`, `idCli`, `fecha` , `codbarras` ) VALUES (NULL, "'.$idBoleto.'", "'.$idCli.'", "'.$hoy.'","'.$rowImp['strBarcode'].'")';
			$resImp = mysql_query($sqlImp) or die (mysql_error());
			
			$sqlBo = 'update Boleto set identComprador = 3 where idBoleto = "'.$idBoleto.'" ';
			$resBo = mysql_query($sqlBo) or die (mysql_error());
			
		}else{
			$autorizaciones ='
				<label style="font-size:6px;" id="parteDiminuta">
					AUTH MUN: 206-ESP-0043<BR>
					RUC '.$rucAHIS.', '.$tipocontribuyenteAHIS.' <BR>
					'.$nombrecomercialAHIS.'<BR>
					'.$dirmatrizAHIS.', AUTH ----- -----<BR>
					SEC AUT. '.$rowEmpresa['nroautorizacionTF'].', PIE 099254749001 '.$rowEmpresa['razonsocialTF'].' <BR>
					BOLETO: ('.$rowImp['idCon'].'-'.$rowImp['idBoleto'].' VALIDEZ: '.$fechaImp.'-'.$fechaExpiracion.')
				</label>
			';
			
			$autorizaciones2 = '
				<label style="font-size:6px;" id="parteDiminuta">
					<span>
						AUTH MUN: 206-ESP-0043  <br/>
						RUC '.$rucAHIS.', '.$tipocontribuyenteAHIS.' 
					</span><br/>
					<span>
						'.$nombrecomercialAHIS.'<br/>
						'.$dirmatrizAHIS.', <br/>AUTH '.$nroautorizacionA.'
					</span>
					SEC AUT. '.$rowEmpresa['nroautorizacionTF'].', PIE 099254749001 '.$rowEmpresa['razonsocialTF'].' <BR>
					BOLETO: ('.$rowImp['idCon'].'-'.$rowImp['idBoleto'].' VALIDEZ: '.$fechaImp.'-'.$fechaExpiracion.')
				</label>
			';
			$textoVenta = 'Pre-venta';
			$print='
				<div style="width:380px;">
							<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:12px;">
								<tr>
									<td style="text-align:center;">
										<img src="http://ticketfacil.ec/imagenes/ticketfacilnegro.png" style="width:100%;"/>
									</td>
								</tr>
								<tr>
									<td style="text-align:left;font-size:12px;">
										<h2 style="padding-top: 0px;"><strong style="color:red;"><center>Atención !!!</center></strong></h2><br/>
										Todavia no se recibe la información de los permisos para el concierto de : <span style="color:blue;">'.$strEvento.'</span>
									</td>
								</tr>
								<tr>
									<td style="text-align:left;text-transform:uppercase;">
										no se puede imprimir su boleto
									</td>
								</tr>
							</table>
						</div>
			';
		}
	}else{
		$print = 0;
	}
	
	
	
	
	echo $print;
?>