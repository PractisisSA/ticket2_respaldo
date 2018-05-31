<?php 
	date_default_timezone_set('America/Guayaquil');
	require_once('../classes/private.db.php');
	require_once '../PHPM/PHPM/class.phpmailer.php';
	require_once '../PHPM/PHPM/class.smtp.php';
	$concierto = $_POST['con'];
	$local = $_POST['idlocal'];
	$numticket = $_POST['numticket'];
	$gbd = new DBConn();
	$hoy = date("y-m-d");
	include '../conexion.php';
	$hoy2 = date("Y-m-d H:i:s");
	$ident = 2;
	$tipos_boleto_entregado = $_REQUEST['tipos_boleto_entregado'];
	if($tipos_boleto_entregado == 1){
		$txtTipoBol = 'Normales';
		$tipo_persona = 0;
	}
	elseif($tipos_boleto_entregado == 2){
		$txtTipoBol = 'Tercera Edad';
		$tipo_persona = 1;
	}
	elseif($tipos_boleto_entregado == 3){
		$txtTipoBol = 'Niños';
		$tipo_persona = 2;
	}
	$sqlCortesia = 'INSERT INTO `cortesias` (`id`, `id_con`, `id_loc`, `num_bol` , `tipo` , estado , fecha ) VALUES (NULL, "'.$concierto.'", "'.$local.'", "'.$numticket.'" , "'.$ident.'" , "'.$tipos_boleto_entregado.'" ,"'.$hoy2.'" )';
	// echo $sqlCortesia;
	
	$resCortesia = mysql_query($sqlCortesia) or die (mysql_error());
	
	
	$sqlLo = 'select * from Localidad where idLocalidad = "'.$local.'" ';
	$resLo = mysql_query($sqlLo) or die (mysql_error());
	$rowLo = mysql_fetch_array($resLo);
	$doublePrecioL = $rowLo['doublePrecioL'];
	$strDescripcionL = $rowLo['strDescripcionL'];
	$strCaracteristicaL = $rowLo['strCaracteristicaL'];
	
	$sql = 'select * from Butaca where intLocalB = "'.$local.'" and intConcB = "'.$concierto.'" ';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	$intFilasB = $row['intFilasB'];
	$intAsientosB = $row['intAsientosB'];
	
	$indice = 0;
	$indice2 = 1;
	$sqlCon = 'SELECT * FROM Concierto WHERE idConcierto = "'.$concierto.'" '; 
	$resCon = mysql_query($sqlCon) or die (mysql_error());
	$rowCon = mysql_fetch_array($resCon);
	$tiene_permisos = $rowCon['tiene_permisos'];
	$strEvento = $rowCon['strEvento'];
	
	if($tiene_permisos == 0){
		$identComprador = 1;
	}elseif($tiene_permisos > 0){
		$identComprador = 2;
		
	}
	
	$sql = "SELECT * FROM ocupadas WHERE concierto = ? AND local = ?";
	$result = $gbd -> prepare($sql);
	$result -> execute(array($concierto,$local));
	
	$arr = array();
	while($row = $result -> fetch(PDO::FETCH_ASSOC)){
		$arr[$row['row']][$row['col']] = array('col' => $row['col'],'status' => $row['status']);
	}
		
	$sql = "SELECT b.idButaca AS id, b.intAsientosB AS col, b.intFilasB AS rows, b.strSecuencial AS secuencial FROM Butaca b WHERE b.intConcB = ? AND b.intLocalB = ?";
	$result = $gbd -> prepare($sql);
	$result -> execute(array($concierto,$local));
	$row = $result -> fetch(PDO::FETCH_ASSOC);
	
	$content = '';
	$content2 = '';
	
	
	$contador = 1;
	
	
	$content = '<table width="500px" align="center" style="border:1px solid #ccc;">';
		$content.='<tr>';
			$content.='<td colspan="3">';
				$content.='	Estimado cliente le entregamos un resumen de los : "'.$numticket.'"  TICKETS ('.$txtTipoBol.') <br>
							asignados al empresario el dia : "'.$hoy2.'" ,<br/>
							para el concierto de '.$strEvento.' en la localidad de '.$strDescripcionL.'';
			$content.='</td>';
		$content.='</tr>';
	$m = 0;
	
	
	for($i = 1; $i <= $row['rows']; $i++){
		for($y = 1; $y <= $row['col']; $y++){
			if(in_array($y,$arr[$i][$y])){
				//$content2 = 0;
			}else{
				if($contador > $numticket){
					break;
				}
				$query = "SELECT doublePrecioPreventa FROM Localidad JOIN Concierto ON Localidad.idConc = Concierto.idConcierto WHERE dateFechaPreventa >= ? AND idLocalidad = ? AND idConc = ? ORDER BY dateFecha ASC";
				$stmt = $gbd -> prepare($query);
				$stmt -> execute(array($hoy,$local,$concierto));
				$row1 = $stmt -> fetch(PDO::FETCH_ASSOC);
				$numrows = $stmt -> rowCount();
				
				$query2 = "SELECT idLocalidad, strDescripcionL, doublePrecioL, strSecuencial FROM Localidad JOIN Butaca ON Localidad.idLocalidad = Butaca.intLocalB WHERE idLocalidad = ? AND idConc = ?";
				$stmt2 = $gbd -> prepare($query2);
				$stmt2 -> execute(array($local,$concierto));
				$row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
				
				
				$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
				$rand = md5($s.time()).mt_rand(1,10);
				//$code = rand(1,99).time().$j.$i;
				
				$sqlCod_bar = 'SELECT * FROM `codigo_barras` WHERE id_con = "'.$concierto.'" and utilizado = 0 order by id ASc ';
				$resCod_bar = mysql_query($sqlCod_bar) or die (mysql_error());
				$rowCod_bar = mysql_fetch_array($resCod_bar);
				$code = $rowCod_bar['codigo'];
							
							
				$idCli =3;
				
				if($strCaracteristicaL == 'Asientos numerados'){
					$sql1 = 'insert into ocupadas (row,col,status,local,concierto,pagopor,descompra)
							values("'.$i.'" , "'.$y.'" , "1" , "'.$local.'" , "'.$concierto.'" , "0" , "0" )';
					// echo $sql1."<br>";
					
					$res1 = mysql_query($sql1) or die (mysql_error());
					$ocupadas = 'Fila-'.$i.'_Asiento-'.$y.'';
				}else{
					$ocupadas = '';
				}
				
				
				$numeroSerie=0;
				$sqlB1 = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$concierto.'"  order by idBoleto DESC limit 1';
				$resB1 = mysql_query($sqlB1) or die (mysql_error());
				$rowB1 = mysql_fetch_array($resB1);
				if($rowB1['serieB'] == null || $rowB1['serieB'] == '' ){
					$numeroSerie = 1;
				}else{
					$numeroSerie = ($rowB1['serieB'] + 1);
				}
				
				
				$sqlB2 = 'select max(CAST(serie_localidad AS INTEGER)) as serieBl from Boleto where idCon = "'.$concierto.'"  and idLocB = "'.$local.'" order by idBoleto DESC limit 1';
			//	echo $sqlB1."<br/>";
				$resB2 = mysql_query($sqlB2) or die (mysql_error());
				$rowB2 = mysql_fetch_array($resB2);
				
				if($rowB2['serieBl'] == null || $rowB2['serieBl'] == '' ){
					$numeroSerie_localidad = 1;
				}else{
					$numeroSerie_localidad = ($rowB2['serieBl'] + 1);
				}
				
				if($numrows > 0){
					$precio = $row['doublePrecioPreventa'];
				}else{
					$precio = $row['doublePrecioL'];
				}
					
				$sql2 = 'INSERT INTO Boleto VALUES ("NULL","1","'.$code.'",'.$idCli.','.$concierto.','.$local.',"0","0","'.$tipo_persona.'","0","0","empresario",1212121212,"A","S","'.$numeroSerie.'","'.$numeroSerie_localidad.'", "'.$identComprador.'" , "8")';
				$res2 = mysql_query($sql2) or die (mysql_error());
				$idboleto = mysql_insert_id();
				
				
				
				$sqltrans = 'INSERT INTO transaccion_distribuidor VALUES ("NULL", '.$idCli.', '.$concierto.', "'.$local.'", "8", "1","'.$idboleto.'", "", "'.$precio.'","'.$hoy2.'","")';
				$resReans = mysql_query($sqltrans) or die (mysql_error());
				
				$detalleBoleto = 'INSERT INTO detalle_boleto (idBoleto, localidad, asientos, precio) VALUES ("'.$idboleto.'" , "'.$local.'" , "'.$ocupadas.'" , "'.$precio.'")';
				$resDB = mysql_query($detalleBoleto) or die (mysql_error());
				
				
				
				// $urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$code.'';
				// $imgbar = '../subpages/Compras/barcode/'.$code.'.png';
				// file_put_contents($imgbar, file_get_contents($urlbar));
				if($m == 0){
					$content.='<tr>';
				}	
				$content.='<td align="center" style="border:1px solid #ccc;">';
					// $content.='<img src = "http://ticketfacil.ec/ticket2/subpages/Compras/barcode/'.$code.'.png" /><br/>';
					$content.=''.$code.'<br/>';
					$content.=''.$ocupadas.'';
				$content.='</td>';
				if($m == 2){
					$content.='</tr>';
					$m = 0;
				}
				else{
					$m++;
				}
				
				
				
				
				
				
				$content2 .= '<h4>Fila-'.$i.'_Asiento-'.$y.'</h4>';
				$contador++;
			}
		}
	}
	
	
	$sqlUpCodBar = 'update codigo_barras set utilizado = "1" where codigo = "'.$code.'" ';
	$resUpCodBar = mysql_query($sqlUpCodBar);
	
	
	$content.='</table>';
	
	$email='fabricio@practisis.com';
	$ownerEmail = 'jonathan@practisis.com';
	$subject = 'Informacion de Entrega';
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
	$mail->AddAddress($email,$nom);
	$mail->AddAddress($ownerEmail,'TICKETFACIL');     // Add a recipient
	$mail->FromName = 'TICKETFACIL';
	$mail->Subject = $subject;
	$mail->MsgHTML($content);
	if(!$mail->Send()){
		echo 0;
	}
	else{
		echo 1;
	}
?>