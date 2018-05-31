<?php
	
	session_start();
	ini_set('display_startup_errors',1); 
	ini_set('display_errors',1);
	error_reporting(-1);
	
	date_default_timezone_set('America/Guayaquil');
	$fechaActual = date("Y-m-d");     
	$HoraActual = date("H:i:s");     
	
	
	
	include '../../../conexion.php';
	
	
	$hoy = date("Y-m-d");
	$serviform = $_REQUEST['serviform'];
	
	$exp1 = explode("|",$serviform);
	$tipo_tarjeta = 0;
	$tipo_tarjeta2 = 'Efectivo';
	$hora = date('H:i:s');
	
	$quien_vendio_boleto = 0;
	if($_SESSION['tipo_emp'] == 1){
		$quien_vendio_boleto = 3;
	}elseif($_SESSION['tipo_emp'] == 2){
		$quien_vendio_boleto = 2;
	}
	
	
	
	
	
	for($m=0;$m<=count($exp1)-1;$m++){
		$exp2 = explode("@",$exp1[$m]);
		$id_loc = $exp2[0];
		$id_desc = $exp2[1];
		$nom_desc = $exp2[2];
		$pre_desc = $exp2[3];
		$cantidad_expres_ingresada = $exp2[4];
		$total_pagar = $exp2[5];
		$idcon = $exp2[6];
		
		
		$select = 'SELECT * FROM Concierto WHERE idConcierto = "'.$idcon.'" ';
		$resSelect = mysql_query($select) or die (mysql_error());
		$rowSelect = mysql_fetch_array($resSelect);
		
		$evento = $rowSelect['strEvento'];
		$lugar = $rowSelect['strLugar'];
		$fecha = $rowSelect['dateFecha'];
		$hora = $rowSelect['timeHora'];
		$dircanje = $rowSelect['dircanjeC'];
		$horario = $rowSelect['horariocanjeC'];
		$iniciocanje = $rowSelect['fechainiciocanjeC'];
		$finalcanje = $rowSelect['fechafinalcanjeC'];
		$costoenvio = $rowSelect['costoenvioC'];
		$costoenvio = number_format($costoenvio,2);
		$tiene_permisos = $rowSelect['tiene_permisos'];
		$dateFechaPreventa = $rowSelect['dateFechaPreventa'];
		$tipo_conc = $rowSelect['tipo_conc'];
		
		if($tiene_permisos == 0){
			$sitiene = 1;
		}else{
			$sitiene = 2;
		}

		
		
		$sqlFa = '	INSERT INTO factura (id, tipo, rand, id_cli, idConc , localidad , valor , estadoPV , estadopagoPV , ndepo , fecha , estado , id_dist) 
					VALUES (NULL, "5", "", "59" , "'.$idcon.'" , "'.$id_loc.'" , "'.$total_pagar.'" , "'.$tipo_tarjeta.'" , "0" , "'.$cantidad_expres_ingresada.'|'.$id_desc.'|'.$pre_desc.'" , "'.$fechaActual.'" , "'.$HoraActual.'" , "'.$_SESSION['iduser'].'")';
		
		// echo $sqlFa."<br><br>";
		$resFa = mysql_query($sqlFa) or die (mysql_error());
		$idFactura = mysql_insert_id();
		
		
		$sqlTPV = '	INSERT INTO `transaccion_pventa` (`id`, `id_dist`, `cuantos`, `est`) 
					VALUES (NULL, "'.$_SESSION['idDis'].'", "'.$cantidad_expres_ingresada.'", "0")';
		
		// echo $sqlTPV."<br><br>";
		
		$resTPV = mysql_query($sqlTPV) or die (mysql_error());
		$idTPV = mysql_insert_id();
		
		
		
		
		$sql = 'SELECT * FROM ocupadas WHERE concierto = "'.$idcon.'" AND local = "'.$id_loc.'" ' ;
		$res = mysql_query($sql) or die (mysql_error());
		$arr = array();
		// echo $sql."<br>";
		while($row2 = mysql_fetch_array($res)){
			$arr[$row2['row']][$row2['col']] = array('col' => $row2['col'],'status' => $row2['status']);
			
		}
		
		$sql1 = '
					SELECT b.idButaca AS id, b.intAsientosB AS col, b.intFilasB AS rows, b.strSecuencial AS secuencial 
					FROM Butaca b 
					WHERE b.intConcB = "'.$idcon.'" 
					AND b.intLocalB = "'.$id_loc.'"
				';
		// echo $sql1."<br><br><br>";
		$res1 = mysql_query($sql1) or die (mysql_error());
		$row = mysql_fetch_array($res1);
		$contador = 1;	
		for($i = 1; $i <= $row['rows']; $i++){
			for($y = 1; $y <= $row['col']; $y++){
				
				if(in_array($y,$arr[$i][$y])){
						// echo 'no';
					}else{
						if($contador > $cantidad_expres_ingresada){
							break;
						}else{
							$sqlNum1 = 'select * from Localidad where idLocalidad = "'.$id_loc.'" ';
							$resNum1 = mysql_query($sqlNum1) or die (mysql_error());
							$rowNum1 = mysql_fetch_array($resNum1);
							
							if($id_desc == 0){
								$descuentos = $rowNum1['doublePrecioL'];
							}else{
								$sqlD = 'SELECT * FROM `descuentos` where id = "'.$id_desc.'"  ';
								$resD = mysql_query($sqlD) or die (mysql_error());
								$rowD = mysql_fetch_array($resD);
								$descuentos = $rowD['val'];
							}
							
							
							if($rowNum1['strCaracteristicaL'] == 'Asientos numerados'){
									
									
								$selectocupadas = 'SELECT * FROM ocupadas WHERE row = "'.$i.'" AND col = "'.$y.'" AND local = "'.$id_loc.'" AND concierto = "'.$idcon.'"';
								$resOcupadas = mysql_query($selectocupadas) or die (mysql_error());
								
								$numocupadas = mysql_num_rows($resOcupadas);
								
								if($numocupadas > 0){
									echo "error asientos : ".$i."--".$y." ya estan ocupados";
									// return false;
								}else{
									$sqlInsert = 'INSERT INTO ocupadas (`id`, `row`, `col`, `status`, `local`, `concierto`, `pagopor`, `descompra`)
												  VALUES (NULL,"'.$i.'","'.$y.'",2,"'.$id_loc.'","'.$idcon.'",1,"2")';
									
									$resInsert = mysql_query($sqlInsert) or die (mysql_error());
								}				
								
								$asientoss = "Fila-".$i."-Silla-".$y;
							}else{
								$asientoss = "Asientos No Numerados";
							}
							$sqlCod_bar = 'SELECT * FROM `codigo_barras` WHERE id_con = "'.$idcon.'" and utilizado = 0 and id_loc = "'.$id_loc.'" order by id ASc ';
							$resCod_bar = mysql_query($sqlCod_bar) or die (mysql_error());
							$rowCod_bar = mysql_fetch_array($resCod_bar);
							$code = $rowCod_bar['codigo'];
							
							// echo $code."<br>";
							
							if($id_desc == 0){
								$tercera = 0;
							}else{
								$tercera = 1;
							}
							
							$espreventa = 0;
							
							
							// $sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$idcon.'"  order by idBoleto DESC';
							// $resB = mysql_query($sqlB) or die (mysql_error());
							// $rowB = mysql_fetch_array($resB);
							
							// if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
								// $numeroSerie = 1;
							// }else{
								// $numeroSerie = ($rowB['serieB'] + 1);
							// }
							
							$sqlControl = 'select identComprador from Boleto where idCon = "'.$idcon.'" order by idBoleto Desc limit 1';
							$resControl = mysql_query($sqlControl) or die (mysql_error());
							$rowControl = mysql_fetch_array($resControl);
							
							if($rowControl['identComprador'] == $tiene_permisos){
								$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$idcon.'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
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
									$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$idcon.'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
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
							
							
							$sqlB1 = 'select max(CAST(serie_localidad AS INTEGER)) as serieB from Boleto where idCon = "'.$idcon.'"  and idLocB = "'.$id_loc.'" order by idBoleto DESC';
							$resB1 = mysql_query($sqlB1) or die (mysql_error());
							$rowB1 = mysql_fetch_array($resB1);
							
							if($rowB1['serieB'] == null || $rowB1['serieB'] == '' ){
								$numeroSerie_localidad = 1;
							}else{
								$numeroSerie_localidad = ($rowB1['serieB'] + 1);
							}
							
							$insert2 = 'INSERT INTO Boleto VALUES (	"NULL",
																	"1",
																	"'.$code.'",
																	59,
																	'.$idcon.',
																	'.$id_loc.',
																	"1",
																	"'.$quien_vendio_boleto.'",
																	"'.$tercera.'", 
																	"'.$espreventa.'" , 
																	"2" , 
																	"" ,  
																	"9999999999",
																	"A",
																	"S",
																	"'.$numeroSerie.'" ,
																	"'.$numeroSerie_localidad.'",
																	"'.$tiene_permisos.'" , 
																	"'.$_SESSION['iduser'].'" , 
																	"'.$id_desc.'" , 
																	"'.$descuentos.'" , 
																	"'.$fechaActual.'" , 
																	"'.$HoraActual.'" , 
																	"'.$tipo_tarjeta.'" , 
																	"0" 
																)';
							$resInsert2 = mysql_query($insert2) or die (mysql_error());
							$idboleto = mysql_insert_id();
							
							$sqlUpCodBar = 'update codigo_barras set utilizado = "1" where codigo = "'.$code.'" ';
							$resUpCodBar = mysql_query($sqlUpCodBar) or die (mysql_error());
							
							if($tipo_conc == 1){
								$trans = 'INSERT INTO transaccion_distribuidor VALUES (
																						"NULL", 
																						59, 
																						'.$idcon.', 
																						"'.$id_loc.'", 
																						"'.$_SESSION['idDis'].'", 
																						"'.$idTPV.'",
																						"'.$idboleto.'", 
																						"Efectivo", 
																						"'.$pre_desc.'",
																						"'.$fechaActual.' '.$HoraActual.'",
																						0
																						)';
								$resTrans = mysql_query($trans) or die (mysql_error()); 
							}
							
							$detalleBoleto = '	INSERT INTO detalle_boleto (idBoleto, localidad, asientos, precio) 
												VALUES ("'.$idboleto.'" , "'.$rowNum1['strDescripcionL'].'" , "'.$asientoss.'" , "'.$pre_desc.'")';
						//	echo $detalleBoleto."<br><br>";
							$res = mysql_query($detalleBoleto) or die (mysql_error());
							
							
							
							$sqlDT = '	INSERT INTO `detalle_tarjetas` (`idcon`, `idloc`, `idbol`, `idcli`, `fecha`, `hora`, `tipo`, `valor`, `id_fact`) 
											VALUES ("'.$idcon.'", "'.$id_loc.'", "'.$idboleto.'", "59", "'.$fechaActual.'", "'.$HoraActual.'", "venta PV | '.$tipo_tarjeta2.'" , "'.$pre_desc.'" , "'.$idFactura.'")';
							// echo $sqlDT."<br><br>";
							$resDT = mysql_query($sqlDT) or die (mysql_error());
						}
						$contador++;
					}
				
			}
		}
		
	}
	
	echo 'Factura generada con exito';
?>