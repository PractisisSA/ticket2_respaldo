<?php 
	include("../controlusuarios/seguridadSP.php");
	require('../Conexion/conexion.php');
	
	$perfil = htmlspecialchars($_POST['perfil']);
	if($perfil == 1){
		$perfil = 'Admin';
	}else{
		if($perfil == 2){
			$perfil = 'Auditor';
		}else{
			if($perfil == 3){
				$perfil = 'Socio';
			}else{
				if($perfil == 4){
					$perfil = 'Seguridad';
				}else{
					if($perfil == 5){
						$perfil = 'Todo';
					}
				}
			}
		}
	}
	if($perfil == 'Todo'){
		// echo $perfil;
		$select = "SELECT idUsuario, strNombreU, strMailU, strCedulaU, strPerfil, strEstadoU FROM Usuario" or die(mysqli_error($mysqli));
		$result = $mysqli->query($select);
		$json =' { "Usuario" : ['    ;
		if(mysqli_num_rows($result)){
			while($row = mysqli_fetch_array($result))
			{
				$id = $row['idUsuario'];
				$nombre = $row['strNombreU'];
				$mail = $row['strMailU'];
				$documento = $row['strCedulaU'];
				$per = $row['strPerfil'];
				$estado = $row['strEstadoU'];
				$json .= '{ "id" : "'.$id.'", "nombre" : "'.$nombre.'" , "mail" : "'.$mail.'", "documento" : "'.$documento.'", "per" : "'.$per.'", "estado" : "'.$estado.'" },'; 
			}
			$json=substr($json,0,-1);
		}
		$json.=' ]}';
		echo $json;
	}else{
		// echo $perfil;
		$select = "SELECT idUsuario, strNombreU, strMailU, strCedulaU, strPerfil, strEstadoU FROM Usuario WHERE strPerfil = '$perfil'" or die(mysqli_error($mysqli));
		$result = $mysqli->query($select);
		$json =' { "Usuario" : ['    ;
		if(mysqli_num_rows($result)){
			while($row = mysqli_fetch_array($result))
			{
				$id = $row['idUsuario'];
				$nombre = $row['strNombreU'];
				$mail = $row['strMailU'];
				$documento = $row['strCedulaU'];
				$per = $row['strPerfil'];
				$estado = $row['strEstadoU'];
				$json .= '{ "id" : "'.$id.'", "nombre" : "'.$nombre.'" , "mail" : "'.$mail.'", "documento" : "'.$documento.'", "per" : "'.$per.'", "estado" : "'.$estado.'" },'; 
			}
			$json=substr($json,0,-1);
		}
		$json.=' ]}';
		echo $json;
	}
?>