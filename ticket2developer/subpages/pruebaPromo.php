<?php
	session_start();
	
	$idcli = $_SESSION['id'];
	include '../conexion.php';
	
	$ident1 = $_REQUEST['ident1'];
	
	// ini_set('display_startup_errors',1);
	// ini_set('display_errors',1);
	// error_reporting(-1);


	$idCon = $_REQUEST['idCon'];
	
	$sqlConteo = 'select count(1) as cuantos from factura where tipo != 5 and idConc = "'.$idCon.'" ';
	// echo $sqlConteo."<br>";
	$resConteo = mysql_query($sqlConteo) or die (mysql_error());
	$rowConteo = mysql_fetch_array($resConteo);
	
	$sqlPro = 'select count(1) as cuantos , p.* from promociones as p where id_con = "'.$idCon.'"';
	$resPro = mysql_query($sqlPro) or die (mysql_error());
	$rowPro = mysql_fetch_array($resPro);
	
	// echo $rowConteo['cuantos']." promo : ".$rowPro['cuantos']."<br>";
	
	$multiplo = $rowPro['cantidad'];
	
	if($rowConteo['cuantos'] % $multiplo == 0){
		echo ' '.$rowConteo['cuantos'].' si es multiplo de '.$multiplo.' <br><br>';
		
		$sqlOc = 'SELECT * FROM ocupadas WHERE concierto = "'.$rowPro['id_con'].'" AND local = "'.$rowPro['id_loc'].'"';
		$resOc = mysql_query($sqlOc) or die (mysql_error());
		
		
		$arr = array();
		while($rowOc = mysql_fetch_array($resOc)){
			$arr[$rowOc['row']][$rowOc['col']] = array('col' => $rowOc['col'],'status' => $rowOc['status']);
			// print_r(json_encode($arr[$rowOc['row']][$rowOc['col']]));
		}
		
		$sql = '
					SELECT b.idButaca AS id, b.intAsientosB AS col, b.intFilasB AS rows, b.strSecuencial AS secuencial 
					FROM Butaca b WHERE b.intConcB = "'.$rowPro['id_con'].'" AND b.intLocalB = "'.$rowPro['id_loc'].'"
				';
		// echo $sql."<br>";
		$res = mysql_query($sql) or die (mysql_error());
		$row = mysql_fetch_array($res);
		
		
		
		$contador = 1;
		$asientos = '';
		for($i = 1; $i <= $row['rows']; $i++){
			for($y = 1; $y <= $row['col']; $y++){
				if(in_array($y,$arr[$i][$y])){
					
				}else{
					if($contador > $rowPro['cortesias']){
						break;
					}
					// echo $contador." > ".$rowPro['cortesias'];
					$sqlCon = 'select * from Concierto where idConcierto = "'.$rowPro['id_con'].'" ';
					$resCon = mysql_query($sqlCon) or die (mysql_error());
					$rowCon = mysql_fetch_array($resCon);
					
					$tiene_permisos = $rowCon['tiene_permisos'];
					
					$query2 = '	
								SELECT idLocalidad, strDescripcionL, doublePrecioL, strSecuencial , strCaracteristicaL 
								FROM Localidad 
								JOIN Butaca 
								ON Localidad.idLocalidad = Butaca.intLocalB 
								WHERE idLocalidad = "'.$rowPro['id_loc'].'" 
								AND idConc = "'.$rowPro['id_con'].'"
							';
					
					$res2 = mysql_query($query2) or die (mysql_error());
					$row2 = mysql_fetch_array($res2);
					
					if($row2['strCaracteristicaL'] == 'Asientos numerados'){
						$asientos = 'Fila-'.$i.'_Asiento-'.$y.'';
					}else{
						$asientos ='Asientos No Numerados';
					}
					if($contador == 1){
						$sqlFa = '	INSERT INTO factura (id, tipo, rand, id_cli, idConc , localidad , valor , estadoPV , estadopagoPV , ndepo , fecha ) 
									VALUES (NULL, "8", "", "'.$idcli.'" , "'.$rowPro['id_con'].'" , "'.$rowPro['id_loc'].'" , "0" , "cortesia_promo" , "pagado" , "'.$envio.'" , "'.$hoy.'")';
						
						// echo $sqlFa."<br>";
						// $resFa = mysql_query($sqlFa) or die (mysql_error());
						// $idFactura = mysql_insert_id();
					}
					$sqlControl = 'select identComprador from Boleto where idCon = "'.$rowPro['id_con'].'" order by idBoleto Desc limit 1';
					$resControl = mysql_query($sqlControl) or die (mysql_error());
					$rowControl = mysql_fetch_array($resControl);
					
					if($rowControl['identComprador'] == $tiene_permisos){
						$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$rowPro['id_con'].'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
						$resB = mysql_query($sqlB) or die (mysql_error());
						$rowB = mysql_fetch_array($resB);
						
						if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
							$numeroSerie = 1;
						}else{
							$numeroSerie = ($rowB['serieB'] + 1);
						}
						
					}else{
						
						$sqlControl1 = 'select count(1) as cuantos , identComprador from Boleto where identComprador = "'.$tiene_permisos.'" order by idBoleto Desc limit 1';
						$resControl1 = mysql_query($sqlControl1) or die (mysql_error());
						$rowControl1 = mysql_fetch_array($resControl1);
						if($rowControl1['cuantos'] != 0 ){
							$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$rowPro['id_con'].'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
							$resB = mysql_query($sqlB) or die (mysql_error());
							$rowB = mysql_fetch_array($resB);
							
							if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
								$numeroSerie = 1;
							}else{
								$numeroSerie = ($rowB['serieB'] + 1);
							}
						}else{					
							$numeroSerie = 1;
							// $numeroSerie_localidad = 1;
						}
						
					}
					$sqlB1 = 'select max(CAST(serie_localidad AS INTEGER)) as serieB from Boleto where idCon = "'.$rowPro['id_con'].'"  and idLocB = "'.$rowPro['id_loc'].'" order by idBoleto DESC limit 1';
					//echo "serie localidad".$sqlB1."<br/><br/>";
					$resB1 = mysql_query($sqlB1) or die (mysql_error());
					$rowB1 = mysql_fetch_array($resB1);
					
					if($rowB1['serieB'] == null || $rowB1['serieB'] == '' ){
						$numeroSerie_localidad = 1;
					}else{
						$numeroSerie_localidad = ($rowB1['serieB'] + 1);
					}
					// echo "serie : ".$numeroSerie."<<  >> serie localidad : ".$numeroSerie_localidad."<br/><br/>";
					
					// echo $row2['strCaracteristicaL']."  hola <br>";
					if($row2['strCaracteristicaL'] == 'Asientos numerados'){
						$boletosok = '	
										SELECT count(1) as cuantos ,  o.* 
										FROM ocupadas as o 
										WHERE row = "'.$i.'" 
										AND col = "'.$y.'" 
										AND local = "'.$rowPro['id_loc'].'" 
										AND concierto = "'.$rowPro['id_con'].'"
									';
						// echo $boletosok."<br/><br/>";
						
						$resBok = mysql_query($boletosok) or die (mysql_error());
						$rowBok = mysql_fetch_array($resBok);
						
						
						if($rowBok['cuantos'] > 0){
							echo 'error';
							return false;
						}
					
						$insertBol = 'INSERT INTO ocupadas VALUES ("NULL","'.$i.'","'.$y.'","1","'.$rowPro['id_loc'].'","'.$rowPro['id_con'].'","1","1")';
						// echo $insertBol."<br>";
						// $resInsertBol = mysql_query($insertBol) or die (mysql_error());
						
					}else{
						
					}
					
					
					$sqlCod_bar = 'SELECT * FROM `codigo_barras` WHERE id_con = "'.$rowPro['id_con'].'" and utilizado = 0 and id_loc = "'.$rowPro['id_loc'].'" order by id ASc ';
					$resCod_bar = mysql_query($sqlCod_bar) or die (mysql_error());
					$rowCod_bar = mysql_fetch_array($resCod_bar);
					$code = $rowCod_bar['codigo'];
					// echo $code."  este es el codigo q se insertara .<br><br>";
					
					
					$hoy = date("Y-m-d");
					$dateFechaPreventa = $rowCon['dateFechaPreventa'];
					if($hoy <= $dateFechaPreventa){
						$espreventa = 1;
					}else{
						$espreventa = 0;
					}
					
					$seccion = 1;
					
					$sqlDe = 'SELECT * FROM `descuentos` WHERE `idloc` = "'.$rowPro['id_loc'].'" AND `nom` LIKE "%cortes%" ORDER BY `idloc` ASC ';
					$resDe = mysql_query($sqlDe) or die (mysql_error());
					$rowDe = mysql_fetch_array($resDe);
					$fecha = date('Y-m-d');
					$hora = date('H:i:s');
					$query1 = 'INSERT INTO Boleto VALUES ("NULL","'.$seccion.'","'.$code.'","'.$idcli.'","'.$rowPro['id_con'].'","'.$rowPro['id_loc'].'","2","1", "0", "'.$espreventa.'", "0" , "" ,"'.$_SESSION['userdoc'].'","A","S","'.$numeroSerie.'", "'.$numeroSerie_localidad.'", "'.$tiene_permisos.'" , "0" , "'.$rowDe['id'].'" , "'.$rowDe['val'].'" , "'.$hoy.'" , "'.$hora.'" , "10" , "1" )';
					// $resQ = mysql_query($query1) or die (mysql_error());
					// $idboleto = mysql_insert_id();
					 // echo $query1."<br/><br/>";
					 
					 
					 
					if($ident1 == 1){
						$sqlDo = '	insert into domicilio (rowD , colD , statusD , localD , conciertoD , clienteD , boletoD , pagoporD , domicilioHISD , nombreHISD , documentoHISD) 
									values ("'.$i.'" , "'.$y.'" , "'.$hoy.'" ,"'.$rowPro['id_loc'].'" , "'.$rowPro['id_con'].'" , "'.$idcli.'" , "'.$idboleto.'" , "cortesia_promo" , "'.$dir1.'" , "'.$tel1.'" , "'.$idFactura.'")';
						// $resDo = mysql_query($sqlDo) or die (mysql_error());
					}
					// echo $sqlDo."<br>";
					
					
					$urlbar = 'http://ticketfacil.ec/ticket2/codigo_de_barras.php?barcode='.$code.'';
					$imgbar = 'barcode/'.$code.'.png';
					file_put_contents($imgbar, file_get_contents($urlbar));
					
					
					
					
					// echo 'hola'.$strCaracteristicaL;
					if($row2['strCaracteristicaL'] == 'Asientos numerados'){
						
						$valorAsientos = 1;
						$asientoss = " Fila-".$i."-Silla-".$y;
						$asientoss2 = $row2['strDescripcionL']."  Fila-".$i."-Silla-".$y;
						
						
					}elseif($strCaracteristicaL == 'Asientos numerados'){
						$valorAsientos = 0;
						$asientoss = "Asientos no Numerados";
						$asientoss2 = $row2['strDescripcionL']."Asientos no Numerados";
						
						
					}
					
					
					$detalleBoleto = '	
										INSERT INTO detalle_boleto (idBoleto, localidad, asientos, precio) 
										VALUES ("'.$idboleto.'" , "'.$rowPro['id_loc'].'" , "'.$asientoss.'" , "'.$rowDe['val'].'")
									';
					// echo $detalleBoleto."<br>";
					
					// $res = mysql_query($detalleBoleto) or die (mysql_error());
					
					$sqlUpCodBar = 'update codigo_barras set utilizado = "1" where codigo = "'.$code.'" ';
					// echo $sqlUpCodBar."<br>";
					// $resUpCodBar = mysql_query($sqlUpCodBar);
					
					
					$sqlDT = '	INSERT INTO `detalle_tarjetas` (`idcon`, `idloc`, `idbol`, `idcli`, `fecha`, `hora`, `tipo`, `valor`, `id_fact`) 
								VALUES ("'.$rowPro['id_con'].'", "'.$rowPro['id_loc'].'", "'.$idboleto.'", "'.$idcli.'", "'.$fecha.'", "'.$hora.'", "cortesia_promo" , "'.$rowDe['val'].'" , "'.$idFactura.'")';
					// echo $sqlDT."<br><br>";
					// $resDT = mysql_query($sqlDT) or die (mysql_error());
					
					
					
					
					
					$content = '
						<page>
							<div style="border:1px solid #ccc;border-radius:10px;width:500px;margin:0 auto;">
							<table align="center" style="width:100%; border-collapse:separate; border-spacing:15px 5px;font-size:11px;">
								<tr>
									<td style="text-align:center;">
										<img src="http://www.lcodigo.com/ticket/imagenes/ticketfacilnegro.png" width="120px"/>
									</td>
								</tr>
								<tr>
									<td style="text-align:center;">
										<h1 style ="color:blue;text-transform:capitalize;" >Estimado <strong>'.utf8_decode($_SESSION['username']).'</strong> </h1>
										<h2>!!!Muchas felicidades usted acaba de ganar este ticket!!! sorteado de la promoción :  '.$rowPro['nombre'].'</h2>
									</td>
								</tr>
								
							';	
							if($ident1 != 1){
							$content .= '	
								<tr>
									<td>
										
										
										<center><h3><strong>* Para el evento de : '.$rowCon['strEvento'].'</strong><h3></center><br>
										<center><h4><strong>* En la localidad de : '.$asientoss2.' <br></strong><h4></center><br>
										
										
										<br/><br/>
										
										'.$rowCon['dircanjeC'].' 
										
										<br><br>
										Por favor debe portar este documento impreso , y su documento de identidad al momento del canje<br/>
									</td>
								</tr>
							
								<tr>
									<td valign="middle" align="center"> 
										* Su c&oacute;digo de compra es el siguiente:<br/>
										<img src="http://ticketfacil.ec/ticket2/barcode/'.$code.'.png" /><br/>
										 <span style="color:##ED1568;font-size:18px;"><strong>'.$code.'</strong></span>
									</tr>
								</tr>';
							
							}else{
								$content .= '	
								<tr>
									<td>
										<center><h3><strong>* Para el evento de : '.$rowCon['strEvento'].'</strong><h3></center><br>
										<center><h4><strong>* En la localidad de : '.$asientoss2.' <br></strong><h4></center><br>
										
										<br><br>
										Sus tickets seran enviados a la siguente direccion : "'.$dir1.'"<br>
										mediante el sistema de envios de servientrega <br>
										Su numero de contacto ingresado es : "'.$tel1.'"<br>
										nosotros le notificaremos a su numero de celular : '.$intTelefonoMovC.' <br>
										cuando el envio se haya realizado.
									</td>
								</tr>
							
								<tr>
									<td valign="middle" align="center"> 
										* Su c&oacute;digo de cada ticket es el siguiente:<br/>
										<img src="http://ticketfacil.ec/ticket2/barcode/'.$code.'.png" /><br/>
										 <span style="color:##ED1568;font-size:18px;"><strong>'.$code.'</strong></span>
									</tr>
								</tr>';
							}
							$content .= '	
								<tr>
									<td style="text-align:center;">
										<strong>Gracias por Preferirnos</strong>
										<br>
										<strong>TICKETFACIL <I>"La mejor experiencia de compra En L&iacute;nea"</I></strong>
									</td>
								</tr>
							</table>
							</div>
						</page>';
					 // echo $content;
					echo $asientoss." <<>>> ".$asientoss2."<br> <hr>";
					$contador++;
				}
			}
		}
		// echo $asientos;
	}else{
		echo ' '.$rowConteo['cuantos'].' no es multiplo de '.$multiplo.'';
	}
	
	// echo $resto;
?>