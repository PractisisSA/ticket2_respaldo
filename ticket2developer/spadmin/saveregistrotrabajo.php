<?php
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadSA.php");
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$idreg = 'NULL';
	$tr = $_REQUEST['ttrabajo'];
	if($tr == 1){
		$tiporegistro = 'Transaccion Realizada';
	}else{
		if($tr == 2){
			$tiporegistro = 'Transaccion Incompleta';
		}else{
			if($tr == 3){
				$tiporegistro = 'Transaccion No Realizada';
			}else{
				if($tr == 4){
					$tiporegistro = 'Reimpresiones';
				}
			}
		}
	}
	$idsocio = $_REQUEST['socio'];
	$idauto = $_REQUEST['auto'];
	$obs = $_REQUEST['obs'];
	$usuario = $_SESSION['iduser'];
	$fecha = date('Y-m-d H:i:s');
	$estado = 'Activo';
	$serieInicialinformada = $_REQUEST['serieInicialinformada'];
	if((strlen($serieInicialinformada) == 1)){
		$inicial = '00000000'.$serieInicialinformada;
	}else{
		if((strlen($serieInicialinformada) == 2)){
			$inicial = '0000000'.$serieInicialinformada;
		}else{
			if((strlen($serieInicialinformada) == 3)){
				$inicial = '000000'.$serieInicialinformada;
			}else{
				if((strlen($serieInicialinformada) == 4)){
					$inicial = '00000'.$serieInicialinformada;
				}else{
					if((strlen($serieInicialinformada) == 5)){
						$inicial = '0000'.$serieInicialinformada;
					}else{
						if((strlen($serieInicialinformada) == 6)){
							$inicial = '000'.$serieInicialinformada;
						}else{
							if((strlen($serieInicialinformada) == 7)){
								$inicial = '00'.$serieInicialinformada;
							}else{
								if((strlen($serieInicialinformada) == 8)){
									$inicial = '0'.$serieInicialinformada;
								}else{
									if((strlen($serieInicialinformada) >= 9)){
										$inicial = $serieInicialinformada;
									}
								}
							}
						}
					}
				}
			}
		}
	}
	$serieFinalinformada = $_REQUEST['serieFinalinformada'];
	if((strlen($serieFinalinformada) == 1)){
		$final = '00000000'.$serieFinalinformada;
	}else{
		if((strlen($serieFinalinformada) == 2)){
			$final = '0000000'.$serieFinalinformada;
		}else{
			if((strlen($serieFinalinformada) == 3)){
				$final = '000000'.$serieFinalinformada;
			}else{
				if((strlen($serieFinalinformada) == 4)){
					$final = '00000'.$serieFinalinformada;
				}else{
					if((strlen($serieFinalinformada) == 5)){
						$final = '0000'.$serieFinalinformada;
					}else{
						if((strlen($serieFinalinformada) == 6)){
							$final = '000'.$serieFinalinformada;
						}else{
							if((strlen($serieFinalinformada) == 7)){
								$final = '00'.$serieFinalinformada;
							}else{
								if((strlen($serieFinalinformada) == 8)){
									$final = '0'.$serieFinalinformada;
								}else{
									if((strlen($serieFinalinformada) >= 9)){
										$final = $serieFinalinformada;
									}
								}
							}
						}
					}
				}
			}
		}
	}
	
	try{
		$insert = "INSERT INTO registrotrabajos VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$ins = $gbd -> prepare($insert);
		$ins -> execute(array($idreg,$idsocio,$idauto,$usuario,$tiporegistro,$inicial,$final,$obs,$fecha,$estado));
		
		$update = "UPDATE autorizaciones SET estadoAuto = ? WHERE idAutorizacion = ?";
		$upd = $gbd -> prepare($update);
		$upd -> execute(array($tiporegistro,$idauto));
		
		return true;
	}catch(PDOException $e){
		print_r($e);
	}
?>