<?php
	session_start();
	date_default_timezone_set('America/Guayaquil');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	include("../../controlusuarios/seguridadusuario.php");
	require_once('../../classes/private.db.php');
	
	$gbd = new DBConn();
	
	require_once('../../stripe/lib/Stripe.php');
	Stripe::setApiKey('sk_test_6GSRONySlv39WktvlN4ZloaH');

	// $totalEntries = $_REQUEST['totalEntries'];

	// for($i = 0; $i <= $totalEntries; $i++){
		// echo str_replace('|','&amp;',$_REQUEST['code'.$i]).' :::: ';
		// }

	// exit;

	$token = $_REQUEST['token'];
	$concert_id = (int)$_REQUEST['concert_id'];
	// $loc_id = (int)$_REQUEST['idLocal'];
	$total = $_REQUEST['total'];
	$cantidad = $_REQUEST['cant'];
	$idcli = $_SESSION['id'];
	$quien_vendio_boleto = 1;
	$valorPago = 2;
	$select1 = "SELECT * FROM Cliente WHERE idCliente = ?";
	$slt1 = $gbd -> prepare($select1);
	$slt1 -> execute(array($idcli));
	$row1 = $slt1 -> fetch(PDO::FETCH_ASSOC);
	$envio = $row1['strEnvioC'];
	$dir = $row1['strDireccionC'];
	$strDocumentoC = $row1['strDocumentoC'];
	
	$sql = "SELECT * FROM Concierto WHERE idConcierto = ?";
	$res = $gbd -> prepare($sql);
	$res -> execute(array($concert_id));
	$row = $res -> fetch(PDO::FETCH_ASSOC);
	$preciocents = ($total * 100);
	$evento = $row['strEvento'];
	$fecha = $row['dateFecha'];
	$lugar = $row['strLugar'];
	$hora = $row['timeHora'];
	$tipo_conc = $row['tipo_conc'];
	$_SESSION['tipo_conc'] = $tipo_conc;
	$pagopor = 1;
	$tiene_permisos = $row['tiene_permisos'];
	
	$cobroExitoso = false;

	try{
		$charge = Stripe_Charge::create(array(
			'amount' => $preciocents,
			'currency' => 'usd',
			'card' => $token,
			'description' => $evento
			));

		$cobroExitoso = true;
		$purchaseID = $charge->id;
		//echo $purchaseID;
		//echo 'ok';
	}
	catch(Exception $e){
		$error = $e->getMessage();
		//echo $error;
		
	}
		
	if($cobroExitoso === true){
		include('../../html2pdf/html2pdf/html2pdf.class.php');
		require_once '../../PHPM/PHPM/class.phpmailer.php';
		require_once '../../PHPM/PHPM/class.smtp.php';
		
		$status_boleto = 1;
		$fechahoy = date('Y-m-d H:i:s');
		$fecha = date('Y-m-d');
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
		foreach(explode('@',$_REQUEST['valFor']) as $valor){	
			$exVal = explode('|',$valor);
			for($i = 0; $i < $exVal[3]; $i++){
				
				$boletosok = "SELECT * FROM ocupadas WHERE row = ? AND col = ? AND local = ? AND concierto = ?";
				$bolok = $gbd -> prepare($boletosok);
				$bolok -> execute(array($exVal[6],$exVal[7],$exVal[0],$concert_id));
				$numbolok = $bolok -> rowCount();
				if($numbolok > 0){
					echo 'error';
					return false;
				}
			
				$s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
				$rand = md5($s.time()).mt_rand(1,10);
				$est ="A";
				$qr = 'http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$rand.'';
				$insertBol = "INSERT INTO ocupadas VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				$resultInsertBol = $gbd -> prepare($insertBol);
				$resultInsertBol -> execute(array('NULL',$exVal[6],$exVal[7],$status_boleto,$exVal[0],$concert_id,$pagopor,$descompra));
				
				$code = rand(1,9999999999).time();
				$_SESSION['barcode'] = $code;
				
				if($tiene_permisos == 0){
					$identComprador = 1;
				}elseif($tiene_permisos > 0){
					$identComprador = 2;
					
				}
				$sqlB1 = 'select max(CAST(serie AS INTEGER)) as serieB from Boleto where idCon = "'.$concert_id.'"  order by idBoleto DESC limit 1';
				include '../../../conexion.php';
				$resB1 = mysql_query($sqlB1) or die (mysql_error());
				$rowB1 = mysql_fetch_array($resB1);
				$numeroSerie = ($rowB1['serieB'] + 1);
				echo $numeroSerie;
				
				$query1 = 'INSERT INTO Boleto VALUES ("NULL","'.$rand.'","'.$code.'",'.$idcli.','.$concert_id.','.$exVal[0].',"'.$valorPago.'","'.$quien_vendio_boleto.'","'.$exVal[6].'",'.$exVal[7].',"A","S","'.$numeroSerie.'","'.$identComprador.'")';
				
				
				//$query1 = "INSERT INTO Boleto VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$result = $gbd -> prepare($query1);
				$result -> execute(array());
				$idboleto = $gbd -> lastInsertId();
				
				
				$hoy = date("Y-m-d");
				$dateFechaPreventa = $row['dateFechaPreventa'];
				if($hoy <= $dateFechaPreventa){
					$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$exVal[0].'"';
					$lokRow= $gbd -> prepare($localidad);
					$lokRow -> execute();
					$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
					$precioVenta = $rowLoc['doublePrecioPreventa'];
					
					$insertCompras_preventa = "INSERT INTO compras_preventa VALUES (?, ?, ?, ?, ? , ? )";
					$resCompras_preventa = $gbd -> prepare($insertCompras_preventa);
					$resCompras_preventa -> execute(array('NULL',$exVal[0] , $code , $idboleto , $hoy , $precioVenta));
					
					
				}else{
					$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$exVal[0].'"';
					$lokRow= $gbd -> prepare($localidad);
					$lokRow -> execute();
					$rowLoc = $lokRow -> fetch(PDO::FETCH_ASSOC);
					$precioVenta = $rowLoc['doublePrecioL'];
				}
				
				
				//$_SESSION['boletoComprado'] = $identComprador;
				if($envio == 'Domicilio'){
					
				$insert3 = 'INSERT INTO domicilio VALUES ("NULL", "'.$exVal[4].'", "'.$exVal[5].'", "1", "'.$exVal[0].'", '.$concert_id.', '.$idcli.', '.$idboleto.', "Tarjeta de Credito", "'.$dir.'", "'.$exVal[6].'", "'.$exVal[7].'", "A")';
				
				
				//$insert3 = "INSERT INTO domicilio VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$ins3 = $gbd -> prepare($insert3);
				$ins3 -> execute(array());
				}

				$timeRightNow = time();
				$url = str_replace(' ','',$qr);
				$img = 'qr/'.$timeRightNow.'.png';
				file_put_contents($img, file_get_contents($url));
				
				
				
				$urlbar = 'http://www.lcodigo.com/ticket/distribuidor/ventas/ajax/codigo_barras.php?barcode='.$code.'';
				$imgbar = 'barcode/'.$code.'.png';
				file_put_contents($imgbar, file_get_contents($urlbar));
				include '../../../conexion.php';
				
				
				if($tiene_permisos == 0){
					$identComprador = 1;
				}elseif($tiene_permisos > 0){
					$identComprador = 2;
					$hoy = date("Y-m-d H:i:s");
					$sqlImp = 'INSERT INTO `imp_boleto` (`id`, `idbo`, `idCli`, `fecha` ,codbarras) VALUES (NULL, "'.$idboleto.'", "'.$idcli.'", "'.$hoy.'" , "'.$code.'")';
					$resImp = mysql_query($sqlImp) or die (mysql_error());
				}
				
				
				$detalleBoleto = 'INSERT INTO detalle_boleto (idBoleto, localidad, asientos, precio) VALUES ("'.$idboleto.'" , "'.$exVal[2].'" , "'.$exVal[1].'" , "'.$exVal[4].'")';
				$res = mysql_query($detalleBoleto) or die (mysql_error());
				
				$idboletoVendido .= $idboleto."|";
				//echo $idboletoVendido;
			}
		}
		//echo $idboletoVendido;
		 $_SESSION['idboletoVendido'] = $idboletoVendido;
		// echo $_SESSION['idboletoVendido'];
	}
?>