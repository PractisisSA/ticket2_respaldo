<?php
	session_start();
	date_default_timezone_set('America/Guayaquil');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	
	//$id = $_REQUEST['id'];
	$concert_id = $_REQUEST['idConcierto'];
	$idcli = $_SESSION['id'];//echo $idcli;
	$valida_ocupadas = $_REQUEST['valida_ocupadas'];
	$id_area_mapa = $_REQUEST['id_area_mapa'];
	$_SESSION['valida_ocupadas'] = $valida_ocupadas;
	$_SESSION['id_area_mapa'] = $id_area_mapa;
	//print_r(unserialize($id));
	$compras = ($_SESSION['boletos_asignados']);//unserialize($id);
	$_SESSION['compras'] = $compras;
	// print_r($_SESSION['compras']);
	// echo "<br>".$concert_id.">><<".$idcli;
	require_once('classes/private.db.php');
	$hoy = date("Y-m-d H:i:s");
	$gbd = new DBConn();
	
	$quien_vendio_boleto = 1;
	$valorPago = 2;
	
	$select1 = 'SELECT * FROM Cliente WHERE idCliente = "'.$idcli.'" ';
	//echo $select1."<br/>";
	$slt1 = $gbd -> prepare($select1);
	$slt1 -> execute();
	$row1 = $slt1 -> fetch(PDO::FETCH_ASSOC);
	$envio = $row1['strEnvioC'];
	$dir = $row1['strDireccionC'];
	$strDocumentoC = $row1['strDocumentoC'];
	$strNombresC = $row1['strNombresC'];
	$strMailC = $row1['strMailC'];
	$intTelefonoMovC = $row1['intTelefonoMovC'];
	
	$sql = 'SELECT * FROM Concierto WHERE idConcierto = "'.$concert_id.'"';
	//echo $sql."<br/>";
	$res = $gbd -> prepare($sql);
	$res -> execute();
	$row = $res -> fetch(PDO::FETCH_ASSOC);
	
	$evento = $row['strEvento'];
	$fecha = $row['dateFecha'];
	$lugar = $row['strLugar'];
	$hora = $row['timeHora'];
	$pagopor = 1;
	$tiene_permisos = $row['tiene_permisos'];
	
	$dir1 = $_REQUEST['dir1'];
	$tel1 = $_REQUEST['tel1'];
	$cel1 = $_REQUEST['cel1'];
	$ident1 = $_REQUEST['ident1'];
	include 'conexion.php';
	
	
	if($ident1 == 1){
		$sqlUC = 'update Cliente set strDireccionC = "'.$dir1.'" , strTelefonoC  = "'.$tel1.'", intTelefonoMovC = "'.$cel1.'" where idCliente = "'.$idcli.'" ';
		// echo $sqlUC;
		$resUC = mysql_query($sqlUC) or die (mysql_error());
	}
	
	
	$cobroExitoso = false;
	
	
	
	include('html2pdf/html2pdf/html2pdf.class.php');
	require_once 'PHPM/PHPM/class.phpmailer.php';
	require_once 'PHPM/PHPM/class.smtp.php';
	
	$status_boleto = 1;
	$fechahoy = date('Y-m-d H:i:s');
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	
	
	
	function obtenerFechaEnLetra($fecha){

		$dia= conocerDiaSemanaFecha($fecha);

		$num = date("j", strtotime($fecha));

		$anno = date("Y", strtotime($fecha));

		$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

		$mes = $mes[(date('m', strtotime($fecha))*1)-1];

		return $dia.', '.$num.' de '.$mes.' del '.$anno;

	}

	 

	function conocerDiaSemanaFecha($fecha) {

		$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');

		$dia = $dias[date('w', strtotime($fecha))];

		return $dia;

	}
	$selectpreventa = "SELECT * FROM Concierto WHERE dateFechaPreventa >= ? AND idConcierto = ?";
	$resSelectpreventa = $gbd -> prepare($selectpreventa);
	$resSelectpreventa -> execute(array($fechahoy,$concert_id));
	$numpreventa = $resSelectpreventa -> rowCount();
	if($numpreventa > 0){
		$descompra = 1;
	}else{
		$descompra = 2;
	}
	$counter = 1;
	$idboletoVendido = '';
	
	$totalpago = $_REQUEST['totalpago'];
	
	// $sqlC = 'select * from Concierto where idConcierto = "'.$concert_id.'" ';
	// $resC = mysql_query($sqlC) or die (mysql_error());
	// $rowC = mysql_fetch_array($resC);
	
	
	
	$valorBoleto = ($totalpago / count($compras));
	if($ident1 == 1){
		$envio = 1;
	}else{
		$envio = 0;
	}
	
	
	
		for($i=0;$i<=count($compras)-1;$i++){	
			$local = $compras[$i]['codigo'];
		}
	
	$sqlFa = '	INSERT INTO factura (id, tipo, rand, id_cli, idConc , localidad , valor , estadoPV , estadopagoPV , ndepo , fecha ) 
				VALUES (NULL, "3", "", "'.$idcli.'" , "'.$concert_id.'" , "'.$local.'" , "'.$totalpago.'" , "paypal" , "pagado" , "'.$envio.'" , "'.$hoy.'")';
	
	$resFa = mysql_query($sqlFa) or die (mysql_error());
	$idFactura = mysql_insert_id();
	
	//echo '<table class = "table" style = "color:#fff;">';
	for($i=0;$i<=count($compras)-1;$i++){	
		// echo'<tr class="datos_compra">
				// <td>'.$compras[$i]['codigo'].'</td>
				// <td>'.$compras[$i]['row'].'</td>
				// <td>'.$compras[$i]['col'].'</td>
				// <td>'.$compras[$i]['chair'].'</td>
				// <td>'.$compras[$i]['des'].'</td>
				// <td>'.$compras[$i]['num'].'</td>
				// <td>'.$compras[$i]['pre'].'</td>
				// <td>'.$compras[$i]['tot'].'</td>
			// </tr>';	
		// $sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$concert_id.'"  order by idBoleto DESC limit 1';
		// //echo "serie : ".$sqlB."<br><br>";
		// $resB = mysql_query($sqlB) or die (mysql_error());
		// $rowB = mysql_fetch_array($resB);
		
		// if($rowB['serieB'] == null || $rowB['serieB'] == '' ){
			// $numeroSerie = 1;
		// }else{
			// $numeroSerie = ($rowB['serieB'] + 1);
		// }
		
		
		
		$sqlControl = 'select identComprador from Boleto where idCon = "'.$concert_id.'" order by idBoleto Desc limit 1';
		$resControl = mysql_query($sqlControl) or die (mysql_error());
		$rowControl = mysql_fetch_array($resControl);
		
		if($rowControl['identComprador'] == $tiene_permisos){
			$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$concert_id.'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
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
				$sqlB = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$concert_id.'"  and identComprador = "'.$tiene_permisos.'" order by idBoleto DESC';
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
		$sqlB1 = 'select max(CAST(serie_localidad AS INTEGER)) as serieB from Boleto where idCon = "'.$concert_id.'"  and idLocB = "'.$compras[$i]['codigo'].'" order by idBoleto DESC limit 1';
		//echo "serie localidad".$sqlB1."<br/><br/>";
		$resB1 = mysql_query($sqlB1) or die (mysql_error());
		$rowB1 = mysql_fetch_array($resB1);
		
		if($rowB1['serieB'] == null || $rowB1['serieB'] == '' ){
			$numeroSerie_localidad = 1;
		}else{
			$numeroSerie_localidad = ($rowB1['serieB'] + 1);
		}
		//echo "serie : ".$numeroSerie."<<  >> serie localidad : ".$numeroSerie_localidad."<br/><br/>";
		
		
		$sqlLo = 'select * from Localidad where idLocalidad = "'.$compras[$i]['codigo'].'" ';
		$resLo = mysql_query($sqlLo) or die (mysql_error());
		$rowLo = mysql_fetch_array($resLo);
		$strCaracteristicaL = $rowLo['strCaracteristicaL'];
		
		
		if($strCaracteristicaL == 'Asientos no numerados'){
			
		}else{
			$boletosok = 'SELECT * FROM ocupadas WHERE row = "'.$compras[$i]['row'].'" AND col = "'.$compras[$i]['col'].'" AND local = "'.$compras[$i]['codigo'].'" AND concierto = "'.$concert_id.'"';
			//echo $boletosok."<br/><br/>";
			$bolok = $gbd -> prepare($boletosok);
			$bolok -> execute();
			$numbolok = $bolok -> rowCount();
			if($numbolok > 0){
				echo 'error';
				return false;
			}
		
			$insertBol = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$resultInsertBol = $gbd -> prepare($insertBol);
			$resultInsertBol -> execute(array('NULL',$compras[$i]['row'],$compras[$i]['col'],$status_boleto,$compras[$i]['codigo'],$concert_id,$pagopor,$descompra));
		}
		
		$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
		$rand = md5($s.time()).mt_rand(1,10);
		$est ="A";
		$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'';
		
		
		//$code = rand(1,9999999999).time();
		$sqlCod_bar = 'SELECT * FROM `codigo_barras` WHERE id_con = "'.$concert_id.'" and utilizado = 0 and id_loc = "'.$compras[$i]['codigo'].'" order by id ASc ';
		$resCod_bar = mysql_query($sqlCod_bar) or die (mysql_error());
		$rowCod_bar = mysql_fetch_array($resCod_bar);
		$code = $rowCod_bar['codigo'];
		// echo $code."  este es el codigo q se insertara .<br><br>";
		
		
		$_SESSION['barcode'] = $code;
		
		if($tiene_permisos == 0){
			$identComprador = 1;
		}elseif($tiene_permisos > 0){
			$identComprador = 2;
			
		}
		
		
		
		$hoy = date("Y-m-d");
		$dateFechaPreventa = $row['dateFechaPreventa'];
		if($hoy <= $dateFechaPreventa){
			$espreventa = 1;
		}else{
			$espreventa = 0;
		}
		
		if(isset($_SESSION['id_area_mapa'])){
			$seccion = $_SESSION['id_area_mapa'];
		}else{
			$seccion = 1;
		}
		$query1 = 'INSERT INTO Boleto VALUES ("NULL","'.$seccion.'","'.$code.'","'.$idcli.'","'.$concert_id.'","'.$compras[$i]['codigo'].'","'.$valorPago.'","'.$quien_vendio_boleto.'", "0", "'.$espreventa.'", "0" , "" ,"'.$strDocumentoC.'","A","S","'.$numeroSerie.'", "'.$numeroSerie_localidad.'", "'.$tiene_permisos.'" , "0" , "'.$compras[$i]['id_desc'].'" , "'.$compras[$i]['val_desc'].'" , "'.$fecha.'" , "'.$hora.'" , "10" , "1" )';
		$resQ = mysql_query($query1) or die (mysql_error().$query1);
		$idboleto = mysql_insert_id();
		// // echo $query1."<br/><br/>";
		
		// $result = $gbd -> prepare($query1);
		// $result -> execute(array());
		// $idboleto = $gbd -> lastInsertId();
		
		// $totalpago
		if($compras[$i]['es_para_membresia'] == 1){
			$sqlCM = 'INSERT INTO `compras_membresias` (`id`, `id_cli`, `id_loc`, `id_con`, `valor`, `id_desc`, `canti`, `fecha` , `id_boleto` , `tipo` ) 
				  VALUES (NULL, "'.$idcli.'" , "'.$compras[$i]['codigo'].'" , "'.$concert_id.'" , "'.$compras[$i]['val_desc'].'" , "'.$compras[$i]['id_desc'].'" , "1" , "'.$hoy.'" , "'.$idboleto.'" , "'.$compras[$i]['tipo'].'")';
			$resCM = mysql_query($sqlCM) or die(mysql_error());
		}
		
		
		
		if($ident1 == 1){
			$sqlDo = '	insert into domicilio (rowD , colD , statusD , localD , conciertoD , clienteD , boletoD , pagoporD , domicilioHISD , nombreHISD , documentoHISD) 
						values ("'.$compras[$i]['row'].'" , "'.$compras[$i]['col'].'" , "'.$hoy.'" ,"'.$compras[$i]['codigo'].'" , "'.$concert_id.'" , "'.$idcli.'" , "'.$idboleto.'" , "paypal" , "'.$dir1.'" , "'.$tel1.'" , "'.$idFactura.'")';
			$resDo = mysql_query($sqlDo) or die (mysql_error());
		}
		$timeRightNow = time();
		$url = str_replace(' ','',$qr);
		$img = 'qr/'.$timeRightNow.'.png';
		file_put_contents($img, file_get_contents($url));
		
		
		
		$urlbar = 'http://ticketfacil.ec/ticket2/codigo_de_barras.php?barcode='.$code.'';
		$imgbar = 'barcode/'.$code.'.png';
		file_put_contents($imgbar, file_get_contents($urlbar));
		
		$sqlLo = 'select * from Localidad where idLocalidad = "'.$compras[$i]['codigo'].'" ';
		$resLo = mysql_query($sqlLo) or die (mysql_error());
		$rowLo = mysql_fetch_array($resLo);
		$strCaracteristicaL = $rowLo['strCaracteristicaL'];
		
		
		// echo 'hola'.$strCaracteristicaL;
		if($strCaracteristicaL == 'Asientos no numerados'){
			$valorAsientos = 0;
			$asientoss = "Asientos no Numerados";
			$asientoss2 = $rowLo['strDescripcionL']."Asientos no Numerados";
		}elseif($strCaracteristicaL == 'Asientos numerados'){
			$valorAsientos = 1;
			$asientoss = " Fila-".$compras[$i]['row']."-Silla-".$compras[$i]['col'];
			$asientoss2 = $rowLo['strDescripcionL']."  Fila-".$compras[$i]['row']."-Silla-".$compras[$i]['col'];
		}
		
		$detalleBoleto = 'INSERT INTO detalle_boleto (idBoleto, localidad, asientos, precio) VALUES ("'.$idboleto.'" , "'.$compras[$i]['codigo'].'" , "'.$asientoss.'" , "'.$compras[$i]['val_desc'].'")';
		$res = mysql_query($detalleBoleto) or die (mysql_error());
		
		$sqlUpCodBar = 'update codigo_barras set utilizado = "1" where codigo = "'.$code.'" ';
		$resUpCodBar = mysql_query($sqlUpCodBar);
		
		
		
		$sqlDT = '	INSERT INTO `detalle_tarjetas` (`idcon`, `idloc`, `idbol`, `idcli`, `fecha`, `hora`, `tipo`, `valor`, `id_fact`) 
					VALUES ("'.$concert_id.'", "'.$compras[$i]['codigo'].'", "'.$idboleto.'", "'.$idcli.'", "'.$fecha.'", "'.$hora.'", "paypal" , "'.$compras[$i]['val_desc'].'" , "'.$idFactura.'")';
		// echo $sqlDT;
		$resDT = mysql_query($sqlDT) or die (mysql_error());
		
		echo "<input type='hidden' id='ent' value= '".$idboleto."' />";
		
		$sqlL = 'select * from Localidad where idLocalidad = "'.$compras[$i]['codigo'].'"';
		$resL = mysql_query($sqlL) or die (mysql_error());
		$rowL = mysql_fetch_array($resL);
		
		if($rowL['strCaracteristicaL'] == 'Asientos sin numerar'){
			$asiento = '';
		}else{
			$asiento = $compras[$i]['chair'];
		}
		
		if($row['tipo_conc'] == 1){
			
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
								Estimado <strong>'.utf8_decode($strNombresC).'</strong> 
								<br/>Esto es un comprobante de compra en l&iacute;nea :
							</td>
						</tr>
						<tr>
							<td>
								* Sus asientos estan Pagados<br>
								Ud pago mediante <strong>Paypal</strong>, <br>
								el dia : '.obtenerFechaEnLetra($fecha).', a las : '.$hora.'
							</td>
						</tr>
					';	
					if($ident1 != 1){
					$content .= '	
						<tr>
							<td>
								
								
								* Para el evento de :<center><h3><strong>'.$evento.'</strong><h3></center><br>
								En la localidad de : '.$asientoss2.' <br>
								
								<br/><br/>
								
								'.$row['dircanjeC'].' 
								
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
								* Para el evento de :<center><h3><strong>'.$evento.'</strong><h3></center>
                                En la localidad de : '.$asientoss2.'<br><br>
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
			$ownerEmail = 'info@ticketfacil.ec';
			$subject = 'Informacion de Pago';
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 465;
			$mail->Username = "info@ticketfacil.ec";
			$mail->Password = "ticketfacil2012";
			$mail->AddReplyTo($ownerEmail,'TICKETFACIL');
			// $mail->AddReplyTo('fabricio@practisis.com','TICKETFACIL');
			$mail->AddBCC("fabricio@practisis.com", "TICKETFACIL VENTAS EN LINEA POR PAYPAL");
			$mail->SetFrom($ownerEmail,'TICKETFACIL');
			$mail->From = $ownerEmail;
			$mail->AddAddress($strMailC,$strNombresC);
			$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
			$mail->FromName = 'TICKETFACIL';
			$mail->Subject = $subject;
			$mail->MsgHTML($content);
			
			if(!$mail->Send()){
				// echo "Error de envio " . $mail->ErrorInfo;
			}
			else{
				// echo 'ok enviado';
				
			}
			
			
		}else{
		?>
			<script>
				// var cadaBoleto = <?php echo $idboleto?>;
				// $.post('subpages/Compras/imprimeBoletoPagoTarjeta.php',{
					// cadaBoleto : cadaBoleto
				// }).done(function(data){
					// console.log(data);
				// });
			</script>
		<?php
			$sqlImp = 'INSERT INTO `imp_boleto` (`id`, `idbo`, `idCli`, `fecha` ,codbarras) VALUES (NULL, "'.$idboleto.'", "'.$idcli.'", "'.$hoy.'" , "'.$code.'")';
			$resImp = mysql_query($sqlImp) or die (mysql_error());
			
		}
		
		
	}
	
	
	
	
	
	
	
	
	
	session_start();
	
	$idcli = $_SESSION['id'];
	include 'conexion.php';
	
	// $ident1 = $_REQUEST['ident1'];
	
	// ini_set('display_startup_errors',1);
	// ini_set('display_errors',1);
	// error_reporting(-1);


	$idCon = $_REQUEST['idConcierto'];
	
	$sqlConteo = 'select count(1) as cuantos from factura where (tipo = 3 or tipo = 4 ) and idConc = "'.$idCon.'" ';
	// echo $sqlConteo."<br>";
	$resConteo = mysql_query($sqlConteo) or die (mysql_error());
	$rowConteo = mysql_fetch_array($resConteo);
	
	$sqlPro = 'select count(1) as cuantos , p.* from promociones as p where id_con = "'.$idCon.'" and estado = 1 ';
	$resPro = mysql_query($sqlPro) or die (mysql_error());
	$rowPro = mysql_fetch_array($resPro);
	
	// echo $rowConteo['cuantos']." promo : ".$rowPro['cuantos']."<br>";
	if($rowPro['cuantos'] > 0){
		$multiplo = $rowPro['cantidad'];
		
		if($rowConteo['cuantos'] % $multiplo == 0){
			// echo ' '.$rowConteo['cuantos'].' si es multiplo de '.$multiplo.' <br><br>';
			
			$sqlOc = 'SELECT * FROM ocupadas WHERE concierto = "'.$rowPro['id_con'].'" AND local = "'.$rowPro['id_loc'].'"';
			$resOc = mysql_query($sqlOc) or die (mysql_error());
			
			
			$arr = array();
			while($rowOc = mysql_fetch_array($resOc)){
				$arr[$rowOc['row']][$rowOc['col']] = array('col' => $rowOc['col'],'status' => $rowOc['status']);
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
			
			
			$sqlFa = '	INSERT INTO factura (id, tipo, rand, id_cli, idConc , localidad , valor , estadoPV , estadopagoPV , ndepo , fecha ) 
						VALUES (NULL, "8", "", "'.$idcli.'" , "'.$rowPro['id_con'].'" , "'.$rowPro['id_loc'].'" , "0" , "cortesia_promo" , "pagado" , "'.$envio.'" , "'.$hoy.'")';
			
			// echo $sqlFa."<br>";
			$resFa = mysql_query($sqlFa) or die (mysql_error());
			$idFactura = mysql_insert_id();
			
			$txt = '!!!Muchas felicidades usted acaba de ganar este ticket!!! sorteado de la promoción :  '.$rowPro['nombre'].'';
			
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
							$resInsertBol = mysql_query($insertBol) or die (mysql_error());
							
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
						$resQ = mysql_query($query1) or die (mysql_error());
						$idboleto = mysql_insert_id();
						 // echo $query1."<br/><br/>";
						 
						 
						 
						if($ident1 == 1){
							$sqlDo = '	insert into domicilio (rowD , colD , statusD , localD , conciertoD , clienteD , boletoD , pagoporD , domicilioHISD , nombreHISD , documentoHISD) 
										values ("'.$i.'" , "'.$y.'" , "'.$hoy.'" ,"'.$rowPro['id_loc'].'" , "'.$rowPro['id_con'].'" , "'.$idcli.'" , "'.$idboleto.'" , "cortesia_promo" , "'.$dir1.'" , "'.$tel1.'" , "'.$idFactura.'")';
							$resDo = mysql_query($sqlDo) or die (mysql_error());
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
						
						$res = mysql_query($detalleBoleto) or die (mysql_error());
						
						$sqlUpCodBar = 'update codigo_barras set utilizado = "1" where codigo = "'.$code.'" ';
						// echo $sqlUpCodBar."<br>";
						$resUpCodBar = mysql_query($sqlUpCodBar);
						
						
						$sqlDT = '	INSERT INTO `detalle_tarjetas` (`idcon`, `idloc`, `idbol`, `idcli`, `fecha`, `hora`, `tipo`, `valor`, `id_fact`) 
									VALUES ("'.$rowPro['id_con'].'", "'.$rowPro['id_loc'].'", "'.$idboleto.'", "'.$idcli.'", "'.$fecha.'", "'.$hora.'", "cortesia_promo" , "'.$rowDe['val'].'" , "'.$idFactura.'")';
						// echo $sqlDT."<br><br>";
						$resDT = mysql_query($sqlDT) or die (mysql_error());
						
						
						
						$sqlGP = '	INSERT INTO `ganadores_promos` (`id`, `id_promo`, `id_boleto`, `id_cli`, `fecha` , `id_factura`) 
									VALUES (NULL, "'.$rowPro['id'].'", "'.$idboleto.'", "'.$idcli.'", "'.$fecha.'"  , "'.$idFactura.'" )';
						$resGP = mysql_query($sqlGP) or die (mysql_error());
						
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
						 
						 
						 $ownerEmail = 'info@ticketfacil.ec';
						$subject = 'Informacion de Pago';
						$mail = new PHPMailer();
						$mail->IsSMTP();
						$mail->SMTPAuth = true;
						$mail->SMTPSecure = "ssl";
						$mail->Host = "smtp.gmail.com";
						$mail->Port = 465;
						$mail->Username = "info@ticketfacil.ec";
						$mail->Password = "ticketfacil2012";
						$mail->AddReplyTo($ownerEmail,'TICKETFACIL');
						// $mail->AddReplyTo('fabricio@practisis.com','TICKETFACIL');
						$mail->AddBCC("fabricio@practisis.com", "TICKETFACIL VENTAS EN LINEA POR PAYPAL");
						$mail->SetFrom($ownerEmail,'TICKETFACIL');
						$mail->From = $ownerEmail;
						$mail->AddAddress($strMailC,$strNombresC);
						$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
						$mail->FromName = 'TICKETFACIL';
						$mail->Subject = $subject;
						$mail->MsgHTML($content);
						// echo $asientoss." <<>>> ".$asientoss2."<br> <hr>";
						
						
						if(!$mail->Send()){
							// echo "Error de envio " . $mail->ErrorInfo;
						}
						else{
							 echo '.';
							
						}
						$contador++;
					}
				}
			}
			
			// echo $asientos;
		}else{
			// echo ' '.$rowConteo['cuantos'].' no es multiplo de '.$multiplo.'';
			'no gano siga participando';
			$txt = 'ud no a ganado siga participando';
		}
	}else{
		$txt = '';
	}
	//echo '</table>';
	
	
?>
<style>
	html , body {
		overflow-x :hidden;
	}
</style>

<div style="background-color:#282B2D; margin:10px 20px 0px 20px; text-align:center;">
	<!--<div class="breadcrumb">
		<a id="chooseseat" href="#" onclick="security()">Escoge tu asiento</a>
		<a id="identification" href="#" onclick="security()">Identificate</a>
		<a id="buy" href="#" onclick="security()">Resumen de Compra</a>
		<a id="pay" href="#" onclick="security()">Pagar</a>
		<a class="active" id="confirmation" href="#" onclick="security()">Confirmaci&oacute;n</a>
	</div>-->
</div>
<div style="margin:-10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;<?php echo $display1;?>">
			<div style="background-color:#00AEEF; margin-right:60%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Confirmaci&oacute;n</strong>
			</div>
			<div style="background-color:#EC1867; margin:20px -42px 50px 550px; font-size:25px; position:relative; color:#fff;">
				<img src="imagenes/facehappy.png" alt="En hora buena!!!
				<div class="tra_comprar_concierto"></div>
				<div class="par_comprar_concierto"></div>
			</div>
			<div style="background-color:#00ADEF; margin: 20px -42px 40px 40px; position:relative; padding:40px 40px 40px 0px;">
				<table style="width:100%; margin:20px; color:#fff; font-size:25px; border-collapse:separate; border-spacing:0px 20x;">
					<tr align="center">
						<td>
							<label style = 'color:#fff;font-size:17px;'><?php echo $txt." su numero de compra es : ".$idFactura;?></label>
							
						</td>
					</tr>
					
					<tr align="center">
						<td>
							<p>TU PAGO HA SIDO CORRECTO...</p>
							
						</td>
					</tr>
					<tr>
						<td style="text-align:center;">
							<img src="imagenes/facehappy.png" alt=""/>
						</td>
					</tr>
					<tr align="center">
						<td>
							Se ha enviado el detalle de tu compra a tu correo electronico
						</td>
					</tr>
					<tr align="center">
						<td>
							<p>Gracias por preferirnos...</p>
							<p>Disfruta el evento!</p>
						</td>
					</tr>
					<tr align="center">
						<td>
							<br>
							<p><a href="?modulo=start" class="btn_login" style="text-decoration:none;"><strong>HOME</strong></a></p>
						</td>
					</tr>
				</table>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		</div>
		
	</div>
</div>
<script>

$( document ).ready(function() {
    console.log( "ready!" );
	$( "html, body " ).animate({
		scrollTop: '300px',
	}, 3000, function(){});
	
	
	// setTimeout(function() {
		// window.location.href='controlusuarios/salir.php';
	// }, 15000);
});

</script>