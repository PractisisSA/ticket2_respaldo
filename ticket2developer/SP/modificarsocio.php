<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadSP.php");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$num_dato = $_REQUEST['dato'];
	$idUser = $_REQUEST['id'];
	$infoanterior = $_REQUEST['info'];
	$fecha = date('Y-m-d H:i:s');
	$idlog = 'NULL';
	$creador = $_SESSION['iduser'];
	$accion = 'Modificacion';
	$estadolog = 'Activo';
	$tipo = 'Cliente';
	
	if($num_dato == 1){
		$nombre = $_REQUEST['nombre'];
		$campo = 'Nombre';
		try{
			$updateUser = "UPDATE Socio SET nombresS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($nombre,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$nombre,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $nombre;
	}
	if($num_dato == 2){
		$ruc = $_REQUEST['ruc'];
		$campo = 'Ruc';
		try{
			$updateUser = "UPDATE Socio SET rucS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($ruc,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$ruc,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $ruc;
	}
	if($num_dato == 3){
		$mail = $_REQUEST['mail'];
		$campo = 'E-mail';
		try{
			$updateUser = "UPDATE Socio SET mailS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($mail,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$mail,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $mail;
	}
	if($num_dato == 4){
		$razonsocial = $_REQUEST['razonsocial'];
		$campo = 'Razon Social';
		try{
			$updateUser = "UPDATE Socio SET razonsocialS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($razonsocial,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$razonsocial,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $razonsocial;
	}
	if($num_dato == 5){
		$matriz = $_REQUEST['matriz'];
		$campo = 'Direccion';
		try{
			$updateUser = "UPDATE Socio SET direccionesS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($matriz,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$matriz,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $matriz;
	}
	if($num_dato == 17){
		$matriz = $_REQUEST['matriz'];
		$campo = 'Direccion Sucursal';
		$printpara = 's';
		try{
			$updateUser = "UPDATE Socio SET direstablecimientoS = ?, imprimirparaS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($matriz,$printpara,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$matriz,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $matriz;
	}
	if($num_dato == 7){
		$movil = $_REQUEST['movil'];
		$campo = 'Telefono Movil';
		try{
			$updateUser = "UPDATE Socio SET telmovilS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($movil,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$movil,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $movil;
	}
	if($num_dato == 8){
		$fijo = $_REQUEST['fijo'];
		$campo = 'Telefono Fijo';
		try{
			$updateUser = "UPDATE Socio SET telfijoS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($fijo,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$fijo,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $fijo;
	}
	if($num_dato == 9){
		$contribuyente = $_REQUEST['contribuyente'];
		if($contribuyente == 1){
			$contribuyente = 'Obligado a llevar Contabilidad';
		}else{
			if($contribuyente == 2){
				$contribuyente = 'No Obligado a llevar Contabilidad';
			}else{
				if($contribuyente == 3){
					$contribuyente = 'Contribuyente Especial';
				}else{
					if($contribuyente == 4){
						$contribuyente = 'Contribuyente RISE';
					}else{
						if($contribuyente == 5){
							$contribuyente = 'Contribuyente Regimen Simplificado';
						}
					}
				}
			}
		}
		$nrocontribuyente = $_REQUEST['nrocontribuyente'];
		if($nrocontribuyente == ''){
			$nrocontribuyente = 'No';
			$campo2 = 'Nro. Con. Especial';
		}else{
			$nrocontribuyente = $_REQUEST['nrocontribuyente'];
			$campo2 = 'Nro. Con. Especial';
		}
		
		$newactividad = $_REQUEST['actividad'];
		$newcategoria = $_REQUEST['categoria'];
		
		$campo = 'Clase Contribuyente';
		try{
			if(($infoanterior == 'Contribuyente RISE') && ($contribuyente != 'Contribuyente RISE')){
				$select = "SELECT * FROM Socio WHERE idSocio = ?";
				$slt = $gbd -> prepare($select);
				$slt -> execute(array($idUser));
				$row = $slt -> fetch(PDO::FETCH_ASSOC);
				$actividad = $row['actividadS'];
				$categoria = $row['categoria'];
				$inferioranual = $row['inferioranualS'];
				$superioranual = $row['superioranualS'];
				$inferiormensual = $row['inferiormensualS'];
				$superiormensual = $row['superiormensualS'];
				$monto = $row['montodocS'];
				$norise = 'No es RISE';
				
				$campoactividad = 'Actividad Economica';
				$campocategoria = 'Categoria';
				$campo1 = 'Valor Inferior Anual';
				$campo2 = 'Valor Superior Anual';
				$campo3 = 'Valor Inferior Mensual';
				$campo4 = 'Valor Superior Mensual';
				$campo5 = 'Monto';
				
				$updateUser = "UPDATE Socio SET tipocontribuyenteS = ?, actividadS = ?, categoria = ?, inferioranualS = ?, superioranualS = ?, inferiormensualS = ?, superiormensualS = ?, montodocS = ? WHERE idSocio = ?";
				$upd = $gbd -> prepare($updateUser);
				$upd -> execute(array($contribuyente,$norise,$norise,$norise,$norise,$norise,$norise,$norise,$idUser));
				
				//cambio de clase de contribuyente
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$contribuyente,$tipo,$estadolog));
				
				//cambio de actividad
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campoactividad,$actividad,$norise,$tipo,$estadolog));
				
				//cambio de categoria
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campocategoria,$categoria,$norise,$tipo,$estadolog));
				
				//cambio inferior anual
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo1,$inferioranual,$norise,$tipo,$estadolog));
				
				//cambio superior anual
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo2,$superioranual,$norise,$tipo,$estadolog));
				
				//cambio inferior mensual
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo2,$inferiormensual,$norise,$tipo,$estadolog));
				
				//cambio supoerior mensual
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo2,$superiormensual,$norise,$tipo,$estadolog));
				
				//cambio monto
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo2,$monto,$norise,$tipo,$estadolog));
			}else if(($infoanterior != 'Contribuyente RISE') && ($newactividad != 0) && ($newcategoria != 0) && ($contribuyente == 'Contribuyente RISE')){
				$select = "SELECT * FROM Socio WHERE idSocio = ?";
				$slt = $gbd -> prepare($select);
				$slt -> execute(array($idUser));
				$row = $slt -> fetch(PDO::FETCH_ASSOC);
				$actividadbd = $row['actividadS'];
				$categoriabd = $row['categoria'];
				$inferioranualbd = $row['inferioranualS'];
				$superioranualbd = $row['superioranualS'];
				$inferiormensualbd = $row['inferiormensualS'];
				$superiormensualbd = $row['superiormensualS'];
				$montobd = $row['montodocS'];
				// $norise = 'No es RISE';
				
				if($newactividad == 1){
					$activity = 'Actividades de Comercio';
					if($newcategoria == 1){
						$nuevomonto = 150;
					}else if($newcategoria == 2){
						$nuevomonto = 150;
					}else if($newcategoria == 3){
						$nuevomonto = 200;
					}else if($newcategoria == 4){
						$nuevomonto = 200;
					}else if($newcategoria == 5){
						$nuevomonto = 200;
					}else if($newcategoria == 6){
						$nuevomonto = 250;
					}else if($newcategoria == 7){
						$nuevomonto = 250;
					}
				}else if($newactividad == 2){
					$activity = 'Actividades de Servicio';
					if($newcategoria == 1){
						$nuevomonto = 250;
					}else if($newcategoria == 2){
						$nuevomonto = 250;
					}else if($newcategoria == 3){
						$nuevomonto = 350;
					}else if($newcategoria == 4){
						$nuevomonto = 350;
					}else if($newcategoria == 5){
						$nuevomonto = 350;
					}else if($newcategoria == 6){
						$nuevomonto = 450;
					}else if($newcategoria == 7){
						$nuevomonto = 450;
					}
				}else if($newactividad == 3){
					$activity = 'Actividades de Manufactura';
					if($newcategoria == 1){
						$nuevomonto = 250;
					}else if($newcategoria == 2){
						$nuevomonto = 250;
					}else if($newcategoria == 3){
						$nuevomonto = 350;
					}else if($newcategoria == 4){
						$nuevomonto = 350;
					}else if($newcategoria == 5){
						$nuevomonto = 350;
					}else if($newcategoria == 6){
						$nuevomonto = 450;
					}else if($newcategoria == 7){
						$nuevomonto = 450;
					}
				}else if($newactividad == 4){
					$activity = 'Actividades de Construccion';
					if($newcategoria == 1){
						$nuevomonto = 400;
					}else if($newcategoria == 2){
						$nuevomonto = 400;
					}else if($newcategoria == 3){
						$nuevomonto = 600;
					}else if($newcategoria == 4){
						$nuevomonto = 600;
					}else if($newcategoria == 5){
						$nuevomonto = 600;
					}else if($newcategoria == 6){
						$nuevomonto = 1000;
					}else if($newcategoria == 7){
						$nuevomonto = 1000;
					}
				}else if($newactividad == 5){
					$activity = 'Hoteles y Restaurantes';
					if($newcategoria == 1){
						$nuevomonto = 150;
					}else if($newcategoria == 2){
						$nuevomonto = 150;
					}else if($newcategoria == 3){
						$nuevomonto = 200;
					}else if($newcategoria == 4){
						$nuevomonto = 200;
					}else if($newcategoria == 5){
						$nuevomonto = 200;
					}else if($newcategoria == 6){
						$nuevomonto = 250;
					}else if($newcategoria == 7){
						$nuevomonto = 250;
					}
				}else if($newactividad == 6){
					$activity = 'Actividades de Trasnporte';
					if($newcategoria == 1){
						$nuevomonto = 250;
					}else if($newcategoria == 2){
						$nuevomonto = 250;
					}else if($newcategoria == 3){
						$nuevomonto = 350;
					}else if($newcategoria == 4){
						$nuevomonto = 350;
					}else if($newcategoria == 5){
						$nuevomonto = 350;
					}else if($newcategoria == 6){
						$nuevomonto = 450;
					}else if($newcategoria == 7){
						$nuevomonto = 450;
					}
				}else if($newactividad == 7){
					$activity = 'Actividades Agricolas';
					if($newcategoria == 1){
						$nuevomonto = 400;
					}else if($newcategoria == 2){
						$nuevomonto = 400;
					}else if($newcategoria == 3){
						$nuevomonto = 600;
					}else if($newcategoria == 4){
						$nuevomonto = 300;
					}else if($newcategoria == 5){
						$nuevomonto = 600;
					}else if($newcategoria == 6){
						$nuevomonto = 1000;
					}else if($newcategoria == 7){
						$nuevomonto = 1000;
					}
				}else if($newactividad == 8){
					$activity = 'Actividades de Minas y Canteras';
					if($newcategoria == 1){
						$nuevomonto = 400;
					}else if($newcategoria == 2){
						$nuevomonto = 400;
					}else if($newcategoria == 3){
						$nuevomonto = 600;
					}else if($newcategoria == 4){
						$nuevomonto = 600;
					}else if($newcategoria == 5){
						$nuevomonto = 600;
					}else if($newcategoria == 6){
						$nuevomonto = 1000;
					}else if($newcategoria == 7){
						$nuevomonto = 1000;
					}
				}
				
				if($newcategoria == 1){
					$inferioranual = 0;
					$superioranual = 5000;
					$inferiormensual = 0;
					$superiormensual = 417;
				}else if($newcategoria == 2){
					$inferioranual = 5000;
					$superioranual = 1000;
					$inferiormensual = 417;
					$superiormensual = 833;
				}else if($newcategoria == 3){
					$inferioranual = 10000;
					$superioranual = 20000;
					$inferiormensual = 833;
					$superiormensual = 1667;
				}else if($newcategoria == 4){
					$inferioranual = 20000;
					$superioranual = 30000;
					$inferiormensual = 1667;
					$superiormensual = 2500;
				}else if($newcategoria == 5){
					$inferioranual = 30000;
					$superioranual = 40000;
					$inferiormensual = 2500;
					$superiormensual = 3333;
				}else if($newcategoria == 6){
					$inferioranual = 40000;
					$superioranual = 50000;
					$inferiormensual = 3333;
					$superiormensual = 4167;
				}else if($newcategoria == 7){
					$inferioranual = 50000;
					$superioranual = 60000;
					$inferiormensual = 4167;
					$superiormensual = 5000;
				}
				
				$campoactividad = 'Actividad Economica';
				$campocategoria = 'Categoria';
				$campo1 = 'Valor Inferior Anual';
				$campo2 = 'Valor Superior Anual';
				$campo3 = 'Valor Inferior Mensual';
				$campo4 = 'Valor Superior Mensual';
				$campo5 = 'Monto';
				
				$updateUser = "UPDATE Socio SET tipocontribuyenteS = ?, actividadS = ?, categoria = ?, inferioranualS = ?, superioranualS = ?, inferiormensualS = ?, superiormensualS = ?, montodocS = ? WHERE idSocio = ?";
				$upd = $gbd -> prepare($updateUser);
				$upd -> execute(array($contribuyente,$activity,$newcategoria,$inferioranual,$superioranual,$inferiormensual,$superiormensual,$nuevomonto,$idUser));
				
				//cambio de clase de contribuyente
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$contribuyente,$tipo,$estadolog));
				
				//cambio de actividad
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campoactividad,$actividadbd,$activity,$tipo,$estadolog));
				
				//cambio de categoria
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campocategoria,$categoriabd,$newcategoria,$tipo,$estadolog));
				
				//cambio inferior anual
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo1,$inferioranualbd,$inferioranual,$tipo,$estadolog));
				
				//cambio superior anual
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo2,$superioranualbd,$superioranual,$tipo,$estadolog));
				
				//cambio inferior mensual
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo2,$inferiormensualbd,$inferiormensual,$tipo,$estadolog));
				
				//cambio supoerior mensual
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo2,$superiormensualbd,$superiormensual,$tipo,$estadolog));
				
				//cambio monto
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo2,$montobd,$nuevomonto,$tipo,$estadolog));
			}else{
				$updateUser = "UPDATE Socio SET tipocontribuyenteS = ? WHERE idSocio = ?";
				$upd = $gbd -> prepare($updateUser);
				$upd -> execute(array($contribuyente,$idUser));
				
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$contribuyente,$tipo,$estadolog));
			}
			
			if($nrocontribuyente != 'No'){
				$selectnro = "SELECT nroespecialS FROM Socio WHERE idSocio = ?";
				$sltn = $gbd -> prepare($selectnro);
				$sltn -> execute(array($idUser));
				$rownro = $sltn -> fetch(PDO::FETCH_ASSOC);
				$infoanterior = $rownro['nroespecialS'];
				
				$update = "UPDATE Socio SET nroespecialS = ? WHERE idSocio = ?";
				$nro = $gbd -> prepare($update);
				$nro -> execute(array($nrocontribuyente,$idUser));
				
				$ins = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$inslog = $gbd -> prepare($ins);
				$inslog -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo2,$infoanterior,$nrocontribuyente,$tipo,$estadolog));
			}
				
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $contribuyente.' '.$nrocontribuyente;
	}
	if($num_dato == 10){
		$nroestablecimiento = $_REQUEST['nroestablecimiento'];
		$campo = 'Nro. de Establecimientos';
		try{
			$updateUser = "UPDATE Socio SET nroestablecimientoS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($nroestablecimiento,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$nroestablecimiento,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $nroestablecimiento;
	}
	if($num_dato == 11){
		$actividad = $_REQUEST['actividad'];
		$campo = 'Fecha inicio Actividad';
		try{
			$updateUser = "UPDATE Socio SET fechaactividadS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($actividad,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$actividad,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $actividad;
	}
	if($num_dato == 12){
		$inscripcion = $_REQUEST['inscripcion'];
		$campo = 'Fecha inscripcion';
		try{
			$updateUser = "UPDATE Socio SET fechainscripcionS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($inscripcion,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$inscripcion,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $inscripcion;
	}
	if($num_dato == 13){
		$estado = $_REQUEST['estado'];
		$campo = 'Estado';
		try{
			$updateUser = "UPDATE Socio SET estadoS = ? WHERE idSocio = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($estado,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$estado,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $estado;
	}
	if($num_dato == 14){
		$nroespecial = $_REQUEST['nroespecial'];
		$campo = 'Nro. Con. Especial';
		
		try{
			$update = "UPDATE Socio SET nroespecialS = ? WHERE idSocio = ?";
			$nro = $gbd -> prepare($update);
			$nro -> execute(array($nroespecial,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$nroespecial,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 15){
		$act = $_POST['newactividad'];
		$montoantes = $_POST['monto'];
		$categoria = $_POST['categoria'];
		$nuevomonto = '';
		
		if($act == 1){
			$activity = 'Actividades de Comercio';
			if($categoria == 1){
				$nuevomonto = 150;
			}else if($categoria == 2){
				$nuevomonto = 150;
			}else if($categoria == 3){
				$nuevomonto = 200;
			}else if($categoria == 4){
				$nuevomonto = 200;
			}else if($categoria == 5){
				$nuevomonto = 200;
			}else if($categoria == 6){
				$nuevomonto = 250;
			}else if($categoria == 7){
				$nuevomonto = 250;
			}
		}else if($act == 2){
			$activity = 'Actividades de Servicio';
			if($categoria == 1){
				$nuevomonto = 250;
			}else if($categoria == 2){
				$nuevomonto = 250;
			}else if($categoria == 3){
				$nuevomonto = 350;
			}else if($categoria == 4){
				$nuevomonto = 350;
			}else if($categoria == 5){
				$nuevomonto = 350;
			}else if($categoria == 6){
				$nuevomonto = 450;
			}else if($categoria == 7){
				$nuevomonto = 450;
			}
		}else if($act == 3){
			$activity = 'Actividades de Manufactura';
			if($categoria == 1){
				$nuevomonto = 250;
			}else if($categoria == 2){
				$nuevomonto = 250;
			}else if($categoria == 3){
				$nuevomonto = 350;
			}else if($categoria == 4){
				$nuevomonto = 350;
			}else if($categoria == 5){
				$nuevomonto = 350;
			}else if($categoria == 6){
				$nuevomonto = 450;
			}else if($categoria == 7){
				$nuevomonto = 450;
			}
		}else if($act == 4){
			$activity = 'Actividades de Construccion';
			if($categoria == 1){
				$nuevomonto = 400;
			}else if($categoria == 2){
				$nuevomonto = 400;
			}else if($categoria == 3){
				$nuevomonto = 600;
			}else if($categoria == 4){
				$nuevomonto = 600;
			}else if($categoria == 5){
				$nuevomonto = 600;
			}else if($categoria == 6){
				$nuevomonto = 1000;
			}else if($categoria == 7){
				$nuevomonto = 1000;
			}
		}else if($act == 5){
			$activity = 'Hoteles y Restaurantes';
			if($categoria == 1){
				$nuevomonto = 150;
			}else if($categoria == 2){
				$nuevomonto = 150;
			}else if($categoria == 3){
				$nuevomonto = 200;
			}else if($categoria == 4){
				$nuevomonto = 200;
			}else if($categoria == 5){
				$nuevomonto = 200;
			}else if($categoria == 6){
				$nuevomonto = 250;
			}else if($categoria == 7){
				$nuevomonto = 250;
			}
		}else if($act == 6){
			$activity = 'Actividades de Trasnporte';
			if($categoria == 1){
				$nuevomonto = 250;
			}else if($categoria == 2){
				$nuevomonto = 250;
			}else if($categoria == 3){
				$nuevomonto = 350;
			}else if($categoria == 4){
				$nuevomonto = 350;
			}else if($categoria == 5){
				$nuevomonto = 350;
			}else if($categoria == 6){
				$nuevomonto = 450;
			}else if($categoria == 7){
				$nuevomonto = 450;
			}
		}else if($act == 7){
			$activity = 'Actividades Agricolas';
			if($categoria == 1){
				$nuevomonto = 400;
			}else if($categoria == 2){
				$nuevomonto = 400;
			}else if($categoria == 3){
				$nuevomonto = 600;
			}else if($categoria == 4){
				$nuevomonto = 300;
			}else if($categoria == 5){
				$nuevomonto = 600;
			}else if($categoria == 6){
				$nuevomonto = 1000;
			}else if($categoria == 7){
				$nuevomonto = 1000;
			}
		}else if($act == 8){
			$activity = 'Actividades de Minas y Canteras';
			if($categoria == 1){
				$nuevomonto = 400;
			}else if($categoria == 2){
				$nuevomonto = 400;
			}else if($categoria == 3){
				$nuevomonto = 600;
			}else if($categoria == 4){
				$nuevomonto = 600;
			}else if($categoria == 5){
				$nuevomonto = 600;
			}else if($categoria == 6){
				$nuevomonto = 1000;
			}else if($categoria == 7){
				$nuevomonto = 1000;
			}
		}
		$campo = 'Actividad Economica';
		$campo1 = 'Monto';
		
		try{
			$update = "UPDATE Socio SET actividadS = ?, montodocS = ? WHERE idSocio = ?";
			$nro = $gbd -> prepare($update);
			$nro -> execute(array($activity,$nuevomonto,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$activity,$tipo,$estadolog));
			
			$insertlog1 = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log1 = $gbd -> prepare($insertlog1);
			$log1 -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo1,$montoantes,$nuevomonto,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 16){
		$newcategoria = $_REQUEST['newcategoria'];
		$montoantes = $_REQUEST['monto'];
		$act = $_REQUEST['actividad'];
		if($newcategoria == 1){
			$inferioranual = 0;
			$superioranual = 5000;
			$inferiormensual = 0;
			$superiormensual = 417;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 150;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 400;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 150;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 250;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 400;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 400;
			}
		}else if($newcategoria == 2){
			$inferioranual = 5001;
			$superioranual = 1000;
			$inferiormensual = 418;
			$superiormensual = 833;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 150;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 400;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 150;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 250;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 400;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 400;
			}
		}else if($newcategoria == 3){
			$inferioranual = 10001;
			$superioranual = 20000;
			$inferiormensual = 834;
			$superiormensual = 1667;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 600;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 350;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 600;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 600;
			}
		}else if($newcategoria == 4){
			$inferioranual = 20001;
			$superioranual = 30000;
			$inferiormensual = 1668;
			$superiormensual = 2500;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 600;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 350;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 300;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 600;
			}
		}else if($newcategoria == 5){
			$inferioranual = 30001;
			$superioranual = 40000;
			$inferiormensual = 2501;
			$superiormensual = 3333;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 350;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 600;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 200;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 350;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 600;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 600;
			}
		}else if($newcategoria == 6){
			$inferioranual = 40001;
			$superioranual = 50000;
			$inferiormensual = 3334;
			$superiormensual = 4167;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 450;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 450;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 1000;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 450;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 1000;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 1000;
			}
		}else if($newcategoria == 7){
			$inferioranual = 50001;
			$superioranual = 60000;
			$inferiormensual = 4168;
			$superiormensual = 5000;
			if($act == 'Actividades de Comercio'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Servicio'){
				$nuevomonto = 450;
			}else if($act == 'Actividades de Manufactura'){
				$nuevomonto = 450;
			}else if($act == 'Actividades de Construccion'){
				$nuevomonto = 1000;
			}else if($act == 'Hoteles y Restaurantes'){
				$nuevomonto = 250;
			}else if($act == 'Actividades de Trasnporte'){
				$nuevomonto = 450;
			}else if($act == 'Actividades Agricolas'){
				$nuevomonto = 1000;
			}else if($act == 'Actividades de Minas y Canteras'){
				$nuevomonto = 1000;
			}
		}
		$campo = 'Categoria';
		
		$select = "SELECT * FROM Socio WHERE idSocio = ?";
		$slt = $gbd -> prepare($select);
		$slt -> execute(array($idUser));
		$row = $slt -> fetch(PDO::FETCH_ASSOC);
		$antinferioranual = $row['inferioranualS'];
		$antsuperioranual = $row['superioranualS'];
		$antinferiormensual = $row['inferiormensualS'];
		$antsuperiormensual = $row['superiormensualS'];
		$campo1 = 'Valor Inferior Anual';
		$campo2 = 'Valor Superior Anual';
		$campo3 = 'Valor Inferior Mensual';
		$campo4 = 'Valor Superior Mensual';
		$campo5 = 'Monto';
		
		try{
			$update = "UPDATE Socio SET categoria = ?, inferioranualS = ?, superioranualS = ?, inferiormensualS = ?, superiormensualS = ?, montodocS = ? WHERE idSocio = ?";
			$nro = $gbd -> prepare($update);
			$nro -> execute(array($newcategoria,$inferioranual,$superioranual,$inferiormensual,$superiormensual,$nuevomonto,$idUser));
			
			//insercion del campo normar de categoria
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$newcategoria,$tipo,$estadolog));
			
			//insertcion del cambio inferioranual
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo1,$antinferioranual,$inferioranual,$tipo,$estadolog));
			
			//insercion del cambio superioranual
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo2,$antsuperioranual,$superioranual,$tipo,$estadolog));
			
			//insercion del cambio inferiormensual
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo3,$antinferiormensual,$inferiormensual,$tipo,$estadolog));
			
			//insercion del cambio superiormensual
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo4,$antsuperiormensual,$superiormensual,$tipo,$estadolog));
			
			//insercion del cambio de monto
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo5,$montoantes,$nuevomonto,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
?>