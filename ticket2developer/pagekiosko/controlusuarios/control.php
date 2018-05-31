<?php
    session_start();
    require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	if($_REQUEST['usercli'] != ''){
		$usuario = htmlspecialchars($_REQUEST['usercli']);
		$pass = htmlspecialchars($_REQUEST['passcli']);
		
		$query = "SELECT * FROM Cliente WHERE strMailC = ? AND strContrasenaC = ? AND cambiopassC = ?";
		$qry = $gbd -> prepare($query);
		$qry -> execute(array($usuario,$pass,'si'));
		$rowqry = $qry -> fetch(PDO::FETCH_ASSOC);
		$id = htmlspecialchars($rowqry['idCliente']);
		$nom = htmlspecialchars($rowqry['strNombresC']);
		$doc = htmlspecialchars($rowqry['strDocumentoC']);
		$ciudad = htmlspecialchars($rowqry['strCiudadC']);
		$pro = htmlspecialchars($rowqry['strProvinciaC']);
		$fijo = htmlspecialchars($rowqry['strTelefonoC']);
		$tel = htmlspecialchars($rowqry['intTelefonoMovC']);
		$mail = htmlspecialchars($rowqry['strMailC']);
		$dir = htmlspecialchars($rowqry['strDireccionC']);
		$formP = htmlspecialchars($rowqry['strFormPagoC']);
		$formEnvio = htmlspecialchars($rowqry['strEnvioC']);
		$contrasena = htmlspecialchars($rowqry['strContrasenaC']);
		$fecha_nac = htmlspecialchars($rowqry['strFechaNanC']);
		$genero_cli = htmlspecialchars($rowqry['strGeneroC']);
		$resultok = $qry -> rowCount();
		if($resultok > 0){
			if($contrasena != $pass){
				echo 'errorchange';
			}else{
				$_SESSION['id'] = $id;
				$_SESSION['username'] = $nom;
				$_SESSION['userdoc'] = $doc;
				$_SESSION['userciudad'] = $ciudad;
				$_SESSION['userprov'] = $pro;
				$_SESSION['usertel'] = $tel;
				$_SESSION['usertelf'] = $fijo;
				$_SESSION['usermail'] = $mail;
				$_SESSION['userdir'] = $dir;
				$_SESSION['formapago'] = $formP;
				$_SESSION['formenvio'] = $formEnvio;
				$_SESSION['fech_nac'] = $fecha_nac;
				$_SESSION['genero'] = $genero_cli;
				$_SESSION['perfil'] = 'cliente';
				echo 'changeok';
			}
		}else{
			$pass = md5($pass);
			$selectCliente = "SELECT * FROM Cliente WHERE strMailC = ? AND strContrasenaC = ?";
			$stmt = $gbd -> prepare($selectCliente);
			$stmt -> execute(array($usuario,$pass));
			$rowCliente = $stmt -> fetch(PDO::FETCH_ASSOC);
			$id = htmlspecialchars($rowCliente['idCliente']);
			$nom = htmlspecialchars($rowCliente['strNombresC']);
			$doc = htmlspecialchars($rowCliente['strDocumentoC']);
			$ciudad = htmlspecialchars($rowCliente['strCiudadC']);
			$pro = htmlspecialchars($rowCliente['strProvinciaC']);
			$fijo = htmlspecialchars($rowCliente['strTelefonoC']);
			$tel = htmlspecialchars($rowCliente['intTelefonoMovC']);
			$mail = htmlspecialchars($rowCliente['strMailC']);
			$dir = htmlspecialchars($rowCliente['strDireccionC']);
			$formP = htmlspecialchars($rowCliente['strFormPagoC']);
			$formEnvio = htmlspecialchars($rowCliente['strEnvioC']);
			$contrasena = htmlspecialchars($rowCliente['strContrasenaC']);
			$fecha_nac = htmlspecialchars($rowCliente['strFechaNanC']);
			$genero_cli = htmlspecialchars($rowCliente['strGeneroC']);
			
			if($contrasena != $pass){
				echo 'errorcli';
			}else{
				$_SESSION['autentica'] = 'uzx153';
				$_SESSION['id'] = $id;
				$_SESSION['username'] = $nom;
				$_SESSION['userdoc'] = $doc;
				$_SESSION['userciudad'] = $ciudad;
				$_SESSION['userprov'] = $pro;
				$_SESSION['usertel'] = $tel;
				$_SESSION['usertelf'] = $fijo;
				$_SESSION['usermail'] = $mail;
				$_SESSION['userdir'] = $dir;
				$_SESSION['formapago'] = $formP;
				$_SESSION['formenvio'] = $formEnvio;
				$_SESSION['fech_nac'] = $fecha_nac;
				$_SESSION['genero'] = $genero_cli;
				$_SESSION['perfil'] = 'cliente';
				$_SESSION['useractual'] = $rowCliente['strNombresC'];
				echo 'okcli';
			}
		}
	}else if($_REQUEST['user'] != ''){
		$usuario = htmlspecialchars($_REQUEST['user']);
		$pass = htmlspecialchars($_REQUEST['pass']);
		$contrasenaActual = 'No';
		$estado = 'Activo';
		$selectNewUser = "SELECT * FROM Usuario WHERE strMailU = ? AND strContrasenaU = ? AND strRandContrasena = ? AND strEstadoU = ?";
		$user = $gbd -> prepare($selectNewUser);
		$user -> execute(array($usuario,$contrasenaActual,$pass,$estado));
		$resultUser = $user -> rowCount();
		$rowUser = $user -> fetch(PDO::FETCH_ASSOC);
		if($resultUser > 0){
			$idrowUser = htmlspecialchars($rowUser['idUsuario']);
			$cedula = htmlspecialchars($rowUser['strCedulaU']);
			$useractual = htmlspecialchars($rowUser['strNombreU']);
			$mailuser = htmlspecialchars($rowUser['strMailU']);
			$idDis = htmlspecialchars($rowUser['strObsCreacion']);
			$per = htmlspecialchars($rowUser['strPerfil']);
			if(!$idrowUser){
				echo 'errorchange';
			}else{
				if($per == 'Admin'){
					// $_SESSION['autentica']='SA456';
					$_SESSION['userced'] = $cedula;
					$_SESSION['userid']= $idrowUser;
					$_SESSION['useractual'] = $useractual;
					$_SESSION['mailuser'] = $mailuser;
					$_SESSION['perfil'] = $per;
					echo 'changeok';
				}else{
					if($per == 'Seguridad'){
						// $_SESSION['autentica']='sec789';
						$_SESSION['username'] = $cedula;
						$_SESSION['userid']= $idrowUser;
						$_SESSION['useractual'] = $useractual;
						$_SESSION['mailuser'] = $mailuser;
						$_SESSION['perfil'] = $per;
						echo 'changeok';
					}else{
						if($per == 'Socio'){
							// $_SESSION['autentica']='jag123';
							$_SESSION['username'] = $cedula;
							$_SESSION['userid']= $idrowUser;
							$_SESSION['useractual'] = $useractual;
							$_SESSION['mailuser'] = $mailuser;
							$_SESSION['perfil'] = $per;
							echo 'changeok';
						}else{
							if($per == 'Auditor'){
								$_SESSION['username'] = $cedula;
								$_SESSION['userid']= $idrowUser;
								$_SESSION['useractual'] = $useractual;
								$_SESSION['mailuser'] = $mailuser;
								$_SESSION['perfil'] = $per;
								echo 'changeok';
							}else{
								if($per == 'Distribuidor'){
									$_SESSION['username'] = $cedula;
									$_SESSION['userid']= $idrowUser;
									$_SESSION['useractual'] = $useractual;
									$_SESSION['mailuser'] = $mailuser;
									$_SESSION['idDis'] = $idDis;
									$_SESSION['perfil'] = $per;
									echo 'changeok';
								}
							}
						}
					}
				}
			}
		}else{
			$pass = md5($pass);
			$ok = 'ok';
			$estado = 'Activo';
			// echo $pass.' '.$usuario;
			$consultauser = "SELECT idUsuario, strCedulaU, strMailU, strContrasenaU, strNombreU, strPerfil, strEstadoU, strObsCreacion FROM Usuario WHERE strMailU = ? AND strContrasenaU = ? AND strRandContrasena = ?";
			$stmt = $gbd -> prepare($consultauser);
			$stmt -> execute(array($usuario,$pass,$ok));
			$row = $stmt -> fetch(PDO::FETCH_ASSOC);
			$id = htmlspecialchars($row['strContrasenaU']);
			$usuario2 = htmlspecialchars($row['strCedulaU']);
			$useractual = htmlspecialchars($row['strNombreU']);
			$mailuser = htmlspecialchars($row['strMailU']);
			$idUsuario = htmlspecialchars($row['idUsuario']);
			$idDis = htmlspecialchars($row['strObsCreacion']);
			$per = htmlspecialchars($row['strPerfil']);
			$estUsuario = htmlspecialchars($row['strEstadoU']);
			
			if(!$id){
				echo 'error';
			}else{
				if($per == 'Admin'){
					if($estUsuario == $estado){
						$_SESSION['autentica']='SA456';
						$_SESSION['username'] = $usuario2;
						$_SESSION['userid']= $id;
						$_SESSION['useractual'] = $useractual;
						$_SESSION['mailuser'] = $mailuser;
						$_SESSION['iduser'] = $idUsuario;
						$_SESSION['perfil'] = $per;
						echo 'ok1';
					}else{
						echo 'inactivo';
					}
				}else{
					if($per == 'Seguridad'){
						if($estUsuario == $estado){
							$_SESSION['autentica']='sec789';
							$_SESSION['username'] = $usuario2;
							$_SESSION['userid']= $id;
							$_SESSION['useractual'] = $useractual;
							$_SESSION['mailuser'] = $mailuser;
							$_SESSION['iduser'] = $idUsuario;
							$_SESSION['perfil'] = $per;
							echo 'ok2';
						}else{
							echo 'inactivo';
						}
					}else{
						if($per == 'Socio'){
							if($estUsuario == $estado){
								$_SESSION['autentica']='jag123';
								$_SESSION['username'] = $usuario2;
								$_SESSION['userid']= $id;
								$_SESSION['useractual'] = $useractual;
								$_SESSION['mailuser'] = $mailuser;
								$_SESSION['iduser'] = $idUsuario;
								$_SESSION['perfil'] = $per;
								echo 'ok3';
							}else{
								echo 'inactivo';
							}
						}else{
							if($per == 'Auditor'){
								if($estUsuario == $estado){
									$_SESSION['autentica']='TfAdT545';
									$_SESSION['username'] = $usuario2;
									$_SESSION['userid']= $id;
									$_SESSION['useractual'] = $useractual;
									$_SESSION['mailuser'] = $mailuser;
									$_SESSION['iduser'] = $idUsuario;
									$_SESSION['perfil'] = $per;
									echo 'ok5';
								}else{
									echo 'inactivo';
								}
							}else{
								if($per == 'SP'){
									if($estUsuario == $estado){
										$_SESSION['autentica']='tFSp777';
										$_SESSION['username'] = $usuario2;
										$_SESSION['userid']= $id;
										$_SESSION['useractual'] = $useractual;
										$_SESSION['mailuser'] = $mailuser;
										$_SESSION['iduser'] = $idUsuario;
										$_SESSION['perfil'] = $per;
										echo 'ok4';
									}	
								}else{
									if($per == 'Distribuidor'){
										if($estUsuario == $estado){
											$_SESSION['autentica']='tFDiS759';
											$_SESSION['username'] = $usuario2;
											$_SESSION['userid']= $id;
											$_SESSION['useractual'] = $useractual;
											$_SESSION['mailuser'] = $mailuser;
											$_SESSION['iduser'] = $idUsuario;
											$_SESSION['idDis'] = $idDis;
											$_SESSION['perfil'] = $per;
											echo 'ok6';
										}	
									}
									if($per == 'kiosko'){
										if($estUsuario == $estado){
											$_SESSION['autentica']='Kios759';
											$_SESSION['username'] = $usuario2;
											$_SESSION['userid']= $id;
											$_SESSION['useractual'] = $useractual;
											$_SESSION['mailuser'] = $mailuser;
											$_SESSION['iduser'] = $idUsuario;
											$_SESSION['idDis'] = $idDis;
											$_SESSION['perfil'] = $per;
											echo 'ok7';
										}	
									}
								}
							}
						}
					}
				}
			}
		}
	}
?>