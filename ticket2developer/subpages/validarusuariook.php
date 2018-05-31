<?php 
	session_start();
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$id = $_SESSION['userid'];
	$pass = htmlspecialchars($_POST['pass1']);
	$datos = htmlspecialchars($_POST['datos']);
	$modulo = htmlspecialchars($_POST['mod']);
	$pass = md5($pass);
	$beforepass = 'ok';
	
	if($datos == 6){
		$id = $_SESSION['id'];
		$update = "UPDATE Cliente SET strContrasenaC = ?, cambiopassC = ? WHERE idCliente = ?";
		$stmt = $gbd -> prepare($update);
		$stmt -> execute(array($pass,'no',$id));
		$_SESSION['autentica'] = 'uzx153';
	}else{
		$updUser = "UPDATE Usuario SET strContrasenaU = ?, strRandContrasena = ? WHERE idUsuario = ?";
		$upd = $gbd -> prepare($updUser);
		$upd -> execute(array($pass,$beforepass,$id));
		
		if($datos == 1){
			$_SESSION['autentica']='SA456';
			$_SESSION['modulo']=$modulo;
		}else if($datos == 2){
			$_SESSION['autentica']='sec789';
		}else if($datos == 3){
			$_SESSION['autentica']='jag123';
		}else if($datos == 4){
			$_SESSION['autentica']='TfAdT545';
		}else if($datos == 5){
			$_SESSION['autentica']='tFDiS759';
		}
	}
?>