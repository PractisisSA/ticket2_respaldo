<?php 
	include("controlusuarios/seguridadusuario.php");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	// print_r($_POST);
	
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$genero = $_POST['genero'];
	$fechanac = $_POST['fechanac'];
	$movil = $_POST['movil'];
	$forma = $_POST['forma'];
	$envio = $_POST['envio'];
	$dir = $_POST['dir'];
	$fijo = $_POST['fijo'];
	$provincia = $_POST['provincia'];
	$ciudad = $_POST['ciudad'];
	
	if($genero == ''){
		$genero = 'Agregar Genero';
	}
	if($dir == ''){
		$dir = 'Agregar Direccion';
	}
	if($fijo == ''){
		$fijo = 'Agregar Numero';
	}
	if(($provincia == 0) || ($provincia == '')){
		$provincia = 'Agregar Provincia';
	}
	if(($ciudad == 0) || ($ciudad == '')){
		$ciudad = 'Agregar Ciudad';
	}
	
	try{
		$sql = "UPDATE Cliente SET strNombresC = ?, strGeneroC = ?, strFechaNanC = ?, intTelefonoMovC = ?, strFormPagoC = ?, strEnvioC = ?, strDireccionC = ?, strTelefonoC = ?, strProvinciaC = ?, strCiudadC = ? WHERE idCliente = ?";
		$stmt = $gbd -> prepare($sql);
		$stmt -> execute(array($nombre,$genero,$fechanac,$movil,$forma,$envio,$dir,$fijo,$provincia,$ciudad,$id));
		
		echo 'ok';
	}catch(PDOException $e){
		print_r($e);
	}
	
?>