<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	include 'conexion.php';
	$codigo = $_SESSION['barcode'];
	$idboleto = $_REQUEST['boleto'];
	//$idboleto = 424;
	
	$timeRightNow = time();
	$img = 'qr/'.$timeRightNow.'.png';
	$sqlImpBol = 'select * from Boleto where idBoleto = "'.$idboleto.'"';
	$resImpBol = mysql_query($sqlImpBol) or die(mysql_error());
	$rowImp = mysql_fetch_array($resImpBol);
	$strBarcode = trim($rowImp['strBarcode']);
	$idcli = $rowImp['idCli'];
	
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
	
	
	$sqlCon = 'select * from Concierto where idConcierto = "'.$rowImp['idCon'].'" ';
	$resCon = mysql_query($sqlCon) or die (mysql_error());
	$rowBol = mysql_fetch_array($resCon);
	$strEvento = $rowBol['strEvento'];
	$strLugar = $rowBol['strLugar'];
	$dateFecha = $rowBol['dateFecha'];
	$timeHora = $rowBol['timeHora'];
	$idUser = $rowBol['idUser'];
	$tiene_permisos = $rowBol['tiene_permisos'];
	//echo $tiene_permisos."<h1>aqui</h1>";
	
	
	$hoy = date("Y-m-d");
	$dateFechaPreventa = $rowBol['dateFechaPreventa'];
	if($hoy <= $dateFechaPreventa){
		$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$rowImp['idLocB'].'"';
		$resLoc = mysql_query($localidad) or die (mysql_error());
		$rowLoc = mysql_fetch_array($resLoc);
		$precioVenta = $rowLoc['doublePrecioPreventa'];
		
		// $insertCompras_preventa = 'INSERT INTO compras_preventa (id , id_loc , cod_com , id_bol , fecha , valor)
								   // VALUES ("NULL","'.$rowImp['idLocB'].'" , "'.$rowImp['strBarcode'].'" , "'.$idboleto.'" , "'.$hoy.'" , "'.$precioVenta.'")';
		// $resCompras_preventa mysql_query($insertCompras_preventa) or die (mysql_error());
		
	}else{
		$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$rowImp['idLocB'].'"';
		$resLoc = mysql_query($localidad) or die (mysql_error());
		$rowLoc = mysql_fetch_array($resLoc);
		$precioVenta = $rowLoc['doublePrecioL'];
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
	
	
	if($tiene_permisos != 0){
		$sqlAut = 'select * from autorizaciones where idAutorizacion = "'.$tiene_permisos.'" order by idAutorizacion ASC limit 1';
		//echo $sqlAut;
		$resAut = mysql_query($sqlAut) or die (mysql_error());
		$rowAut = mysql_fetch_array($resAut);
		$rucAHIS = $rowAut['rucAHIS']; 
		$nombrecomercialAHIS = $rowAut['nombrecomercialAHIS'];  
		//echo $nombrecomercialAHIS;
		$tipocontribuyenteAHIS = $rowAut['tipocontribuyenteAHIS'];    
		$nroautorizacionA = $rowAut['nroautorizacionA'];// $rowAut[''];
		$imprimirparaA = $rowAut['imprimirparaA'];// $rowAut[''];
		if($imprimirparaA == "m"){
			$dirmatrizAHIS = $rowAut['dirmatrizAHIS'];  
		}else{
			$dirmatrizAHIS = $rowAut['dirmatrizAHIS']."<br/>".$rowAut['direstablecimientoAHIS'];  
		}
		
		$autorizaciones = '
			<label style="font-size:6px;" id="parteDiminuta">
				AUTH MUN: 206-ESP-0043 RUC '.$rucAHIS.', <br/>
				'.$tipocontribuyenteAHIS.'  '.$nombrecomercialAHIS.'
				'.$dirmatrizAHIS.', <br/>
				AUTH '.$nroautorizacionA.' SEC AUT. '.$rowEmpresa['nroautorizacionTF'].'<br/>
				tel '.$rowEmpresa['telmovilTF'].' '.$rowEmpresa['nombresTF'].' <BR>
				BOLETO: ('.$rowAut['secuencialinicialA'].'-'.$rowAut['secuencialfinalA'].'-'.$rowImp['idBoleto'].' VALIDEZ: '.$fechaImp.'-'.$fechaExpiracion.')
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
				SEC AUT. '.$rowEmpresa['nroautorizacionTF'].', tel '.$rowEmpresa['telmovilTF'].' '.$rowEmpresa['nombresTF'].' <BR>
				BOLETO: ('.$rowAut['secuencialinicialA'].'-'.$rowAut['secuencialfinalA'].'-'.$rowImp['idBoleto'].' VALIDEZ: '.$fechaImp.'-'.$fechaExpiracion.')
			</div>';
		
		
		$textoVenta = '';
		
		$print = '
			<div >
				<table height="auto" border="0" style="border:2px dashed #ccc;" id="contieneElBoletoImprime">
					<tr>
						<td valign="middle" align="left" style="border-bottom:2px dashed #ccc;">
							<img src="http://ticketfacil.ec/pagekiosko/subpages/Compras/barcode/'.$rowImp['strBarcode'].'.png" width="250px" style="text-align:center;height:40px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);"/><br/>
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
									<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:12px;font-weight:bolder;">Valor US $: <strong>'.$precioVenta.'</strong></span><br/>
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
										<img src="http://ticketfacil.ec/pagekiosko/subpages/Compras/barcode/'.$rowImp['strBarcode'].'.png" width="250px" style="text-align:center;height:40px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);"/><br/>
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
											<span align="center" style="font-family:roboto,sans-serif;font-size:10px;"><strong> Valor: US $ '.$precioVenta.'</strong></span><br/>
											<span align="center" style="font-family:roboto,sans-serif;font-size:10px;"><strong> '.$textoVenta.'</strong></span><br/>
											<div style="text-align:left;">'.$autorizaciones2.'</div>
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
									<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:12px;font-weight:bolder;">Valor US $: <strong>'.$precioVenta.'</strong></span><br/>
									<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:12px;font-weight:bolder;"><strong>'.$textoVenta.'</strong></span><br/>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>'; 
	}elseif($tiene_permisos == 0 ){
		$autorizaciones ='
			
			<div style="font-size:6px;" id="parteDiminuta">
				Estimado <b>'.$rowCli['strNombresC'].'</b> <br/>
				Aviso! Este es un comprobante de pago, debe canjear su TICKET en:<br/>
				'.$rowBol['dircanjeC'].'desde el dia '.$rowBol['fechainiciocanjeC'].' <br/>
				hasta el dia '.$rowBol['fechafinalcanjeC'].' en el horario de '.$rowBol['horariocanjeC'].' <br/>
				gracia por confiar en nosotros<br/>
				<b>ticketfacil.ec</b><br/>
			</div>
		';
		
		$autorizaciones2 = '
			<div style="font-size:6px;background-color:#fff;padding:5px;right: -20px;width:200px;position: relative;top: 20px" id="parteDiminuta">
				Estimado <b>'.$rowCli['strNombresC'].'</b> <br/>
				Aviso! Este es un comprobante de pago, debe canjear su TICKET en:<br/>
				'.$rowBol['dircanjeC'].'desde el dia '.$rowBol['fechainiciocanjeC'].' <br/>
				hasta el dia '.$rowBol['fechafinalcanjeC'].' en el horario de '.$rowBol['horariocanjeC'].' <br/>
				gracia por confiar en nosotros<br/>
				<b>ticketfacil.ec</b><br/>
			</div>
		';
		
		$autorizaciones3 ='
			
			<div style="font-size:5px;" id="parteDiminuta">
				Estimado <b>'.$rowCli['strNombresC'].'</b> <br/>
				Aviso! Este es un comprobante de pago, debe canjear su TICKET en:<br/>
				'.$rowBol['dircanjeC'].'desde el dia '.$rowBol['fechainiciocanjeC'].' <br/>
				hasta el dia '.$rowBol['fechafinalcanjeC'].' en el horario de '.$rowBol['horariocanjeC'].' <br/>
				gracia por confiar en nosotros<br/>
				<b>ticketfacil.ec</b><br/>
			</div>
		';
		
		$textoVenta = 'Pre-venta';
		$print='
			<div >
				<table height="auto" border="0" style="border:2px dashed #ccc;" id="contieneElBoletoImprime">
					<tr>
						<td valign="middle" align="left" style="border-bottom:2px dashed #ccc;">
							<div style="font-size:10px;padding-left:10px;text-align:left;height:;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);" >
								<img src="http://ticketfacil.ec/pagekiosko/subpages/Compras/barcode/'.$rowImp['strBarcode'].'.png" width="250px" style="text-align:center;height:40px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);"/><br/>
							</div>
							<div style="padding-bottom:10px;text-align:center;height:;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);" >
								<span style="font-weight:bolder;font-family:roboto,sans-serif;font-size:10px;">'.$strEvento.'</span><br/>
								<div style="width:100%;text-align:center;font-size:9px;">
									<span style="font-family:roboto,sans-serif;">'.$strLugar.'</span>
								</div>
								<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:9px;"><strong>'.$rowDetBol['localidad'].'</strong> <strong>'.$rowDetBol['asientos'].'</strong></span><br/>
								<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:12px;font-weight:bolder;">Valor US $: <strong>'.$precioVenta.'</strong></span><br/>
							</div>
						</td>
					</tr>
					<tr>
						<td valign="middle" align="left">
							<table width="100%" height="100%" border="0">
								<tr>
									<td align="center">
										<img src="http://ticketfacil.ec/pagekiosko/subpages/Compras/barcode/'.$rowImp['strBarcode'].'.png" width="250px" style="text-align:center;height:40px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);"/><br/>
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
											<span align="center" style="font-family:roboto,sans-serif;font-size:10px;"><strong> Valor: US $ '.$precioVenta.'</strong></span><br/>
											<span align="center" style="font-family:roboto,sans-serif;font-size:10px;"><strong> '.$textoVenta.'</strong></span><br/>
											<div style="text-align:left;">'.$autorizaciones2.'</div>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="middle" align="left" style="border-top:2px dashed #ccc;">
							
							<div style="padding-bottom:10px;text-align:center;height:;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);" >
								<span style="font-weight:bolder;font-family:roboto,sans-serif;font-size:10px;">'.$strEvento.'</span><br/>
								<div style="width:100%;text-align:center;font-size:9px;">
									<span style="font-family:roboto,sans-serif;">'.$strLugar.'</span>
								</div>
								<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:9px;"><strong>'.$rowDetBol['localidad'].'</strong> <strong>'.$rowDetBol['asientos'].'</strong></span><br/>
								<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:12px;font-weight:bolder;">Valor US $: <strong>'.$precioVenta.'</strong></span><br/>
							</div>
						</td>
					</tr>
				</table>
			</div>
		';
	}
	
	
	
	
	echo $print;
?>