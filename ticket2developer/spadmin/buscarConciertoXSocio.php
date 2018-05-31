<?php 
	session_start();
	$_SESSION['autentica'];
	
	
	//include("../controlusuarios/seguridadSA.php");
	require('../Conexion/conexion.php');
	include '../conexion.php';
	
	$date = date('Y-m-d');
	
	$id = $_REQUEST['id'];
	$currentUser = $_SESSION['iduser'];
	
	if($_SESSION['autentica'] == 'tFADMIN_SOCIO'){
		$idSocio = $_SESSION['iduser'];
		$filtro = "and porcentajetarjetaC = '$idSocio' ";
	}else{
		$filtro = "";
	}
	$selecConcierto = '';
	
	if ($currentUser == 1) {
		$selecConcierto = "	SELECT idConcierto, strImagen, strEvento, strLugar, dateFecha, timeHora 
						FROM Concierto WHERE idUser = '$id' 
						AND strEstado = 'Activo'
						".$filtro." ORDER BY idConcierto DESC
						" or die(mysqli_error());
	}else{
		$selecConcierto = "	SELECT idConcierto, strImagen, strEvento, strLugar, dateFecha, timeHora 
						FROM Concierto WHERE idUser = '$id' 
						AND strEstado = 'Activo' AND dateFecha > '".$date."'
						".$filtro." ORDER BY idConcierto DESC
						" or die(mysqli_error());
	}

	$resultSelectConcierto = $mysqli->query($selecConcierto);
	$json =' { "Concierto" : ['    ;
    if(mysqli_num_rows($resultSelectConcierto)){
        while($row = mysqli_fetch_array($resultSelectConcierto))
        {
			$sql = 'select count(id) as num_resp from codigo_barras where id_con = "'.$row['idConcierto'].'" order by id ASC limit 1';
			$res = mysql_query($sql) or die (mysql_error());
			$rowC = mysql_fetch_array($res);
			$num_resp = $rowC['num_resp'];
			
			//echo $num_resp;
			
			$id = $row['idConcierto'];
            $imagen = $row['strImagen'];
            $evento = $row['strEvento'];
			$lugar = $row['strLugar'];
			$fecha = $row['dateFecha'];
			$hora = $row['timeHora'];
            $json .= '{ "id" : "'.$id.'", "imagen" : "'.$imagen.'" , "evento" : "'.$evento.'", "lugar" : "'.$lugar.'", "fecha" : "'.$fecha.'", "hora" : "'.$hora.'" , "num_resp" : "'.$num_resp.'" },'; 
        }
        $json=substr($json,0,-1);
    }
    $json.=' ]}';
    echo $json;
?>