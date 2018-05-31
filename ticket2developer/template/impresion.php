<?php
	session_start();
	require_once '../PHPM/PHPM/class.phpmailer.php';
	require_once '../PHPM/PHPM/class.smtp.php';
	
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
	$strMailC = $rowCli['strMailC'];
	
	
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
	
	
	if($_SESSION['tipo_emp'] == 1){
			if($tiene_permisos != 0){
				$sqlAut = 'select * from autorizaciones where idAutorizacion = "'.$tiene_permisos.'" order by idAutorizacion ASC limit 1';
				//echo $sqlAut;
				$resAut = mysql_query($sqlAut) or die (mysql_error());
				
				$rowAut = mysql_fetch_array($resAut);
				$idsocioA = $rowAut['idsocioA']; 
				
				$sqlSocio = 'select * from Socio where 	idSocio = "'.$idsocioA.'" ';
				$resSocio = mysql_query($sqlSocio) or die (mysql_error());
				$rowSocio = mysql_fetch_array($resSocio);
				
				$rucAHIS = $rowAut['rucAHIS']; 
				$nombrecomercialAHIS = $rowAut['nombrecomercialAHIS'];  
				//echo $nombrecomercialAHIS;
				$tipocontribuyenteAHIS = $rowAut['tipocontribuyenteAHIS'];    
				$nroautorizacionA = $rowAut['nroautorizacionA'];// $rowAut[''];
				$imprimirparaA = $rowAut['imprimirparaA'];// $rowAut[''];
				//echo $imprimirparaA;
				if($imprimirparaA == "m"){
					$dirmatrizAHIS = "<b>Matriz :</b> ".$rowAut['dirmatrizAHIS'];  
				}else{
					$dirmatrizAHIS = "<b>Matriz : </b> ".$rowAut['dirmatrizAHIS'].", <b>Suc</b> : ".$rowAut['direstablecimientoAHIS']."";  
				}
				
				
				if($imprimirparaA == "m"){
					$dirmatrizAHIS1 = "Matriz : ".$rowAut['dirmatrizAHIS'];  
				}else{
					$dirmatrizAHIS1 = "Matriz : ".$rowAut['dirmatrizAHIS'].", Suc : ".$rowAut['direstablecimientoAHIS']."";  
				}
				
				$autorizaciones = '
					<label>
						<b>AUT-MUN:</b> '.$autMunCon.' <b>RUC</b>: '.$rucAHIS.','.$tipocontribuyenteAHIS.'
						'.$nombrecomercialAHIS.'  '.$rowSocio['nombresS'].'
						'.$dirmatrizAHIS.', <b>AUT-SRI:</b> '.$nroautorizacionA.' <b>,/
						AUT-MUN:</b> '.$rowEmpresa['autMun'].'  <b>TEL:</b>'.$rowEmpresa['telfijoTF'].'  '.$rowEmpresa['nombresTF'].'  '.$rowEmpresa['rucTF'].'
						<b>AUT-SRI:</b> '.$rowEmpresa['nroautorizacionTF'].',
						<b>BOLETO:</b> ('.$rowAut['codestablecimientoAHIS'].'-'.$rowAut['serieemisionA'].'-0000'.$rowImp['serie'].') 
						<b>VALIDEZ:</b> ('.$fechaImp.'/'.$fechaExpiracion.')
					</label>
				';
				
				$autorizaciones2 = ' 
					<div style="font-size:8px;background-color:;width:185px;text-align:left;" id="parteDiminuta">
						<span>
							<b>AUTH MUN:</b> '.$autMunCon.'  
							<b>RUC:</b> '.$rucAHIS.', <br/>'.$tipocontribuyenteAHIS.' <B>AUT SRI</B> '.$nroautorizacionA.'
						</span><br/>
						<span>
							'.$nombrecomercialAHIS.'
							'.$dirmatrizAHIS1.',<BR>
							<b>SEC AUT:</b> '.$rowEmpresa['autMun'].',
						</span>
						 <b>TEL:</b> '.$rowEmpresa['telfijoTF'].'<BR>
						 '.$rowEmpresa['nombresTF'].' '.$rowEmpresa['rucTF'].' <BR>
						<b>BOLETO:<b> ('.$rowAut['secuencialinicialA'].'-'.$rowAut['secuencialfinalA'].'-'.$rowImp['serie'].' <BR>
						<b>VALIDEZ:</b> '.$fechaImp.'/'.$fechaExpiracion.')
					</div>';
					
					
					$autorizaciones3 = ' 
					<div style="font-size:7px;background-color:ext-align:left;padding:5px;line-height:10px;width: 180px;position: relative;left:-20px;" id="parteDiminuta">
						<b>AUT-MUN:</b> '.$autMunCon.',
						<b>RUC:</b> '.$rucAHIS.', <br/>'.$tipocontribuyenteAHIS.' <B> , AUT-SRI</B> '.$nroautorizacionA.',
						'.$nombrecomercialAHIS.', '.$rowSocio['nombresS'].',
						'.$dirmatrizAHIS1.',/
						<b>AUT-MUN:</b> '.$rowEmpresa['autMun'].',
						<b>TEL:</b> '.$rowEmpresa['telfijoTF'].'
						'.$rowEmpresa['nombresTF'].', '.$rowEmpresa['rucTF'].', <b>AUT-SRI:</b> '.$rowEmpresa['nroautorizacionTF'].',<BR>
						<b>BOLETO:<b> ('.$rowAut['codestablecimientoAHIS'].'-'.$rowAut['serieemisionA'].'-0000'.$rowImp['serie'].') <BR>
						<b>VALIDEZ:</b>('.$fechaImp.'/'.$fechaExpiracion.')
					</div>';
				
				
				$textoVenta = '';
				
				
				// if(file_exists($nombreFichero)){
					// echo "si hay";
				// }elseif(file_exists($nombreFichero2)){
					// echo "si hay";
				// }
				//echo $ruta;
				$print = '
					<div >
						<table width="170px" height="" border="0" id="contieneElBoletoImprime" style="border:2px dashed #ccc;max-width:170px;max-height:510px;">
							<tbody>
								<tr>
									<td valign="top" height="130px" align="center" style="border-bottom:2px dashed #ccc;max-height:130px;">							
										<div style="-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(90deg);margin-top:15px;position:absolute;left: 150px;font-size: 6px;font-family: roboto;color:#ccc;z-index: 2000">Organizador</div>
										<img src="'.$ruta.'" width="160px" style="text-align:center;height:30px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);"/><br/>
										<span style="font-size:6px;">'.$rowImp['strBarcode'].'</span>
										<div style="text-align:center;background-color:;height:39px;font-size:6px;font-family:roboto;line-height: 10px">
											'.$strEvento.'<br/>
											'.$strLugar.'<br/>
											'.$rowDetBol['localidad'].'  '.$rowDetBol['asientos'].'
											<span style="font-family:roboto,sans-serif;font-size:6px;">'.$dia.' - '.$fechaMostrar.' '.$timeHora.'</span><br/>
											Valor US $: '.$rowDetBol['precio'].'
										</div>
										<div style="text-align:left;background-color:;height:50px;font-size:5px;font-family:roboto;font-weight:300;padding-left: 5px;padding-right: 5px;">
											'.$autorizaciones.'
										</div>
									</td>
								</tr>
								<tr>
									<td valign="top" height="290px" style="border-bottom:2px dashed #ccc;max-height: 290px" align="center">
										<div style="-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(90deg);position:absolute;left: 145px;font-size: 10px;font-family: roboto;color:#ccc;z-index: 2000;margin-top: 20px;">Espectador</div>
										<table width="100%" height="100%">
											<tr>
												<td valign="top" align="center" height="50px">
													<img src="'.$ruta.'" width="150px" style="text-align:center;height:40px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);"/><br/>
													<span style="font-size:10px;">'.$rowImp['strBarcode'].'</span>
												</td>
											</tr>
											<tr>
												<td height="auto" style="background-color:#fff;">
													<div style="text-align:center;font-family:roboto,sans-serif;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(90deg);width: 150px;height:155px;">
														<div style="line-height:10px;">
															<span style="font-weight:bolder;font-family:roboto,sans-serif;font-size:10px;">'.$strEvento.'</span><br/>
															<span style="font-family:roboto,sans-serif;font-size:10px;">'.$strLugar.'</span><br/>
															<span style="font-family:roboto,sans-serif;font-size:9px;">'.$dia.' - '.$fechaMostrar.' '.$timeHora.'</span><br/>
															<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:10px;"><strong>'.$rowDetBol['localidad'].'</strong> <strong>'.$rowDetBol['asientos'].'</strong></span><br/>
															<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:10px;font-weight:bolder;">Valor US $: <strong>'.$rowDetBol['precio'].'</strong></span>
														</div>
														'.$autorizaciones3.'
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td valign="top" height="95px" style="max-height:95px" align="center">
										<div style="-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(90deg);margin-top:8px;position:absolute;left: 160px;font-size: 5px;font-family: roboto;color:#ccc;">Ánfora</div>
										<div style="text-align:center;background-color:;height:34px;font-size:5px;font-family:roboto;line-height: 8px">
											'.$strEvento.'<br/>
											'.$strLugar.'<br/>
											'.$rowDetBol['localidad'].'  '.$rowDetBol['asientos'].'
											<span style="font-family:roboto,sans-serif;font-size:5px;">'.$dia.' - '.$fechaMostrar.' '.$timeHora.'</span><br/>
											Valor US $: '.$rowDetBol['precio'].'
										</div>
										<div style="text-align:left;background-color:;height:62px;font-size:5px;font-family:roboto;font-weight:300;line-height:8px;padding-left: 5px;padding-right: 5px">
											'.$autorizaciones.'
										</div>
										<center><span style="font-size:5px;">'.$rowImp['strBarcode'].'</span></center>
									</td>
								</tr>
							</tbody>
						</table>
					</div>'; 
			}elseif($tiene_permisos == 0 ){
				$autorizaciones ='
					
					<div style="font-size:6px;" id="parteDiminuta">
						Estimado <b>'.$rowCli['strNombresC'].'</b> confirmamos la compra de un boleto para el concierto de <br/>
						'.$strEvento.' que se llevará a cabo el dia : '.$dia.' - '.$fechaMostrar.' '.$timeHora.' <br/>
						Le recordamos que ud debe canjear su boleto real este punto de servicio hasta el dia : '.$rowBol['fechafinalcanjeC'].' <br/>
						en el horario de : '.$rowBol['horariocanjeC'].' ,<br/>gracia por confiar en nosotros<br/>
						<b>ticketfacil.ec</b><br/>
					</div>
				';
				
				$autorizaciones2 = '
					<div style="font-size:6px;background-color:#fff;padding:5px;margin-right: -20px" id="parteDiminuta">
						<br/>Estimado <b>'.$rowCli['strNombresC'].'</b> confirmamos la compra de un boleto para el concierto de <br/>
						'.$strEvento.' que se llevará a cabo el dia : '.$dia.' - '.$fechaMostrar.' '.$timeHora.' <br/>
						Le recordamos que ud debe canjear su boleto real en : "'.$dircanjeC.'" <br/> Desde el día : '.$fechainiciocanjeC.' hasta el dia: '.$rowBol['fechafinalcanjeC'].'
						en el horario de: '.$rowBol['horariocanjeC'].' ,<br/>gracia por confiar en nosotros!
						ticketfacil.ec
					</div>
				';
				
				$autorizaciones3 ='
					
					<div style="font-size:5px;" id="parteDiminuta">
						Estimado <b>'.$rowCli['strNombresC'].'</b> confirmamos la compra de un boleto para <br/>
						el concierto de '.$strEvento.' que se llevará a cabo el dia : '.$dia.' - '.$fechaMostrar.' '.$timeHora.' <br/>
						Le recordamos que ud debe canjear su boleto real en este punto de servicio hasta el dia '.$rowBol['fechafinalcanjeC'].' <br/>
						en el horario de '.$rowBol['horariocanjeC'].' ,<br/>gracia por confiar en nosotros
						ticketfacil.ec
					</div>
				';
				
				$textoVenta = 'Pre-venta';
				$print='
					<div >
						<table width="170px" height="" border="0" id="contieneElBoletoImprime" style="border:2px dashed #ccc;max-width:170px;max-height:510px;">
							<tbody>
								<tr>
									<td valign="middle" height="130px" align="center" style="border-bottom:2px dashed #ccc;max-height:130px;">							
										<div style="-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(90deg);margin-top:15px;position:absolute;left: 150px;font-size: 8px;font-family: roboto;color:#ccc;z-index: 2000">Organizador</div>
										<img src="'.$ruta.'" width="160px" style="text-align:center;height:30px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);"/><br/>
										<span style="font-size:8px;">'.$rowImp['strBarcode'].'</span>
										<div style="text-align:center;background-color:;height:30px;font-size:8px;font-family:roboto;line-height: 10px">
											'.$strEvento.'<br/>
											'.$strLugar.'<br/>
											'.$rowDetBol['localidad'].'  '.$rowDetBol['asientos'].'
											Valor US $: '.$rowDetBol['precio'].'
										</div>
									</td>
								</tr>
								<tr>
									<td valign="top" height="290px" style="border-bottom:2px dashed #ccc;max-height: 290px" align="center">
										<div style="-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(90deg);position:absolute;left: 145px;font-size: 10px;font-family: roboto;color:#ccc;z-index: 2000;margin-top: 20px;">Espectador</div>
										<table width="100%" height="100%">
											<tr>
												<td valign="top" align="center" height="50px">
													<img src="'.$ruta.'" width="150px" style="text-align:center;height:40px;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(180deg);"/><br/>
													<span style="font-size:10px;">'.$rowImp['strBarcode'].'</span>
												</td>
											</tr>
											<tr>
												<td height="auto" style="background-color:#fff;">
													<div style="text-align:center;font-family:roboto,sans-serif;-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(90deg);width: 150px;height:155px;">
														<div style="line-height:10px;">
															<span style="font-weight:bolder;font-family:roboto,sans-serif;font-size:10px;">'.$strEvento.'</span><br/>
															<span style="font-family:roboto,sans-serif;font-size:10px;">'.$strLugar.'</span><br/>
															<span style="font-family:roboto,sans-serif;font-size:9px;">'.$dia.' - '.$fechaMostrar.' '.$timeHora.'</span><br/>
															<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:10px;"><strong>'.$rowDetBol['localidad'].'</strong> <strong>'.$rowDetBol['asientos'].'</strong></span><br/>
															<span align="left" style="font-family:roboto,sans-serif;text-align:left;font-size:10px;font-weight:bolder;">Valor US $: <strong>'.$rowDetBol['precio'].'</strong></span>
														</div>
														'.$autorizaciones2.'
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td valign="middle" height="95px" style="max-height:95px" align="center">
										<div style="-ms-transform: rotate(0deg);-webkit-transform: rotate(0deg);transform: rotate(90deg);margin-top:8px;position:absolute;left: 160px;font-size: 7px;font-family: roboto;color:#ccc;">Ánfora</div>
										<div style="text-align:center;background-color:;height:25px;font-size:7px;font-family:roboto;line-height: 8px">
											'.$strEvento.'<br/>
											'.$strLugar.'<br/>
											'.$rowDetBol['localidad'].'  '.$rowDetBol['asientos'].'
											Valor US $: '.$rowDetBol['precio'].'
										</div>
										<center><span style="font-size:8px;">'.$rowImp['strBarcode'].'</span></center>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				';
			}
			
			
			
			echo $print;
	}elseif($_SESSION['tipo_emp'] == 2){
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
								Estimado <h3 style="text-transform:capitalize;">'.utf8_decode($rowImp['nombreHISB']).'</h3> <br/>Esto es un comprobante de pago :
							</td>
						</tr>
						<tr>
							<td>
								* Sus asientos estan reservados, <span style="color:#EC1867;">por un valor de <strong>$'.$doublePrecioL.'</strong></span>,
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
			$ownerEmail = 'jonathan@practisis.com';
			$subject = 'Informacion de Pago';
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 465;
			$mail->Username = "jonathan@practisis.com";
			$mail->Password = "nathan42015";
			$mail->AddReplyTo($ownerEmail,'TICKETFACIL');
			$mail->SetFrom($ownerEmail,'TICKETFACIL');
			$mail->From = $ownerEmail;
			$mail->AddAddress($strMailC,$strNombresC);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content);
			//$mail->AddAttachment('pdf/'.$timeRightNow.'.pdf'); // attachment
			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else{
				//echo 'ok';
				//echo $content."|";
				//header('Location: ../../?modulo=preventaok&error=ok');
			}
	}
?>