<?php
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
	$tipo = 'Empresa';
	
	if($num_dato == 1){
		$nombre = $_REQUEST['nombre'];
		$campo = 'Nombre';
		try{
			$updateUser = "UPDATE ticktfacil SET nombresTF = ? WHERE idticketFacil = ?";
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
		$comercial = $_REQUEST['comercial'];
		$campo = 'Nombre Comercial';
		try{
			$updateUser = "UPDATE ticktfacil SET razonsocialTF = ? WHERE idticketFacil = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($comercial,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$comercial,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
	}
	if($num_dato == 3){
		$matriz = $_REQUEST['matriz'];
		$campo = 'Direccion Matriz';
		try{
			$updateUser = "UPDATE ticktfacil SET direccionTF = ? WHERE idticketFacil = ?";
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
	if($num_dato == 4){
		$movil = $_REQUEST['movil'];
		$campo = 'Telefono Movil';
		try{
			$updateUser = "UPDATE ticktfacil SET telmovilTF = ? WHERE idticketFacil = ?";
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
	if($num_dato == 5){
		$fijo = $_REQUEST['fijo'];
		$campo = 'Telefono Fijo';
		try{
			$updateUser = "UPDATE ticktfacil SET telfijoTF = ? WHERE idticketFacil = ?";
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
	if($num_dato == 6){
		$ruc = $_REQUEST['ruc'];
		$campo = 'RUC';
		try{
			$updateUser = "UPDATE ticktfacil SET rucTF = ? WHERE idticketFacil = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($ruc,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$ruc,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $fijo;
	}
	if($num_dato == 7){
		$clase = $_REQUEST['clase'];
		$newactividad = $_REQUEST['actividad'];
		$newcategoria = $_REQUEST['categoria'];
		
		if($clase == 1){
			$tipclas = 'Obligado a Llevar Contabilidad';
		}else{
			if($clase == 2){
				$tipclas = 'No Obligado a Llevar Contabilidad';
			}else{
				if($clase == 3){
					$tipclas = 'Contribuyente Especial';
				}else{
					if($clase == 4){
						$tipclas = 'Contribuyente RISE';
					}else{
						if($clase == 5){
							$tipclas = 'Contribuyente Regimen Simplificado';
						}
					}
				}
			}
		}
		$campo = 'Clase de Contribuyente';
		$nroclase = $_REQUEST['nroclase'];
		try{
			$idtf = 1;
			$campoactividad = 'Actividad Economica';
			$campocategoria = 'Categoria';
			$campo5 = 'Monto';
			if($contribuyente != 'Contribuyente RISE'){
				$select = "SELECT * FROM ticktfacil WHERE idticketFacil = ?";
				$slt = $gbd -> prepare($select);
				$slt -> execute(array($idtf));
				$row = $slt -> fetch(PDO::FETCH_ASSOC);
				$actividadbd = $row['actividadTF'];
				$categoriabd = $row['categoriaTF'];
				$montobd = $row['montoTF'];
				$norise = 'No es RISE';
				
				$updateUser = "UPDATE ticktfacil SET tipocontribuyenteTF = ?, actividadTF = ?, categoriaTF = ?, montoTF = ? WHERE idticketFacil = ?";
				$upd = $gbd -> prepare($updateUser);
				$upd -> execute(array($tipclas,$norise,$norise,$norise,$idUser));
				
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$tipclas,$tipo,$estadolog));
				
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campoactividad,$actividadbd,$norise,$tipo,$estadolog));
				
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campocategoria,$categoriabd,$norise,$tipo,$estadolog));
				
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campocategoria,$montobd,$norise,$tipo,$estadolog));
			
			}else if($tipclas == 'Contribuyente RISE'){
				$select = "SELECT * FROM ticktfacil WHERE idticketFacil = ?";
				$slt = $gbd -> prepare($select);
				$slt -> execute(array($idtf));
				$row = $slt -> fetch(PDO::FETCH_ASSOC);
				$actividadbd = $row['actividadTF'];
				$categoriabd = $row['categoriaTF'];
				$montobd = $row['montoTF'];
			
				
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
				
				$updateUser = "UPDATE ticktfacil SET tipocontribuyenteTF = ?, actividadTF = ?, categoriaTF = ?, montoTF = ? WHERE idticketFacil = ?";
				$upd = $gbd -> prepare($updateUser);
				$upd -> execute(array($tipclas,$activity,$newcategoria,$nuevomonto,$idUser));
				
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$tipclas,$tipo,$estadolog));
				
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campoactividad,$actividadbd,$activity,$tipo,$estadolog));
				
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campocategoria,$categoriabd,$newcategoria,$tipo,$estadolog));
				
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo5,$montobd,$nuevomonto,$tipo,$estadolog));
				
			}
			
			if($nroclase != 'no'){
				$no = 'no';
				$updateUser = "UPDATE ticktfacil SET nrocontribuyenteTF = ? WHERE idticketFacil = ?";
				$upd = $gbd -> prepare($updateUser);
				$upd -> execute(array($nroclase,$idUser));
				
				$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$log = $gbd -> prepare($insertlog);
				$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$no,$nroclase,$tipo,$estadolog));
			}
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $fijo;
	}
	if($num_dato == 8){
		$auto = $_REQUEST['auto'];
		$campo = 'Nro. Autorizacion';
		try{
			$updateUser = "UPDATE ticktfacil SET nroautorizacionTF = ? WHERE idticketFacil = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($auto,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$auto,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $fijo;
	}
	if($num_dato == 9){
		$fechaauto = $_REQUEST['fecha'];
		$campo = 'Fecha Autorizacion';
		try{
			$updateUser = "UPDATE ticktfacil SET fechaautorizacionTF = ? WHERE idticketFacil = ?";
			$upd = $gbd -> prepare($updateUser);
			$upd -> execute(array($fechaauto,$idUser));
			
			$insertlog = "INSERT INTO logtributario VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$log = $gbd -> prepare($insertlog);
			$log -> execute(array($idlog,$fecha,$creador,$idUser,$accion,$campo,$infoanterior,$fechaauto,$tipo,$estadolog));
		}catch(PDOException $e){
			print_r($e);
		}
		// echo $fijo;
	}
	if($num_dato == 'sucursal'){
		$dir = $_REQUEST['dir'];
		$movil = $_REQUEST['movil'];
		$fijo = $_REQUEST['fijo'];
		$razon = $_REQUEST['comercial'];
		$fechaauto = $_REQUEST['fauto'];
		
		$select = "SELECT * FROM ticktfacil WHERE idticketFacil = ?";
		$slt = $gbd -> prepare($select);
		$slt -> execute(array($idUser));
		$row = $slt -> fetch(PDO::FETCH_ASSOC);
		
		$idticket = 'NULL';
		$nombres = $row['nombresTF'];
		$ruc = $row['rucTF'];
		$mail = $row['mailTF'];
		$tipo = $row['tipocontribuyenteTF'];
		$nroclase = $row['nrocontribuyenteTF'];
		$des = 'SUC';
		$numauto = $row['nroautorizacionTF'];
		$estado = 'Activo';
		$estab = $row['nroestablecimientoTF'];
		$nro = $estab + 1;
		$nro = '00'.$nro;
		
		$insert = "INSERT INTO ticktfacil VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array($idticket,$nombres,$ruc,$razon,$mail,$tipo,$nroclase,$nro,$dir,$des,$movil,$fijo,$numauto,$fechaauto,$estado));
		$id_insert = $gbd -> lastInsertId();
		
		$idlog = 'NULL';
		$accion = 'Insert';
		$campo = 'Todos';
		$antes = 'Creacion de nueva sucursal';
		$despues = 'Ninguno';
		$estadolog = 'Activo';
		$tipod = 'Empresa';
		
		$insertlog = "INSERT INTO logtributario VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$log = $gbd -> prepare($insertlog);
		$log -> execute(array($idlog,$fecha,$creador,$id_insert,$accion,$campo,$antes,$despues,$tipod,$estadolog));
	}
?>