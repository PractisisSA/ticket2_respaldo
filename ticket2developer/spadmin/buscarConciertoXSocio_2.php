<?php 
	session_start();
	$_SESSION['autentica'];
	
	require('../Conexion/conexion.php');
	include('../conexion.php');
	date_default_timezone_set("America/Guayaquil"); 
	$time = date();
	$id = $_REQUEST['id'];
	$date = date('Y-m-d');

	$time = date('H:i:s');
	
	if($_SESSION['autentica'] == 'tFADMIN_SOCIO'){
		$idSocio = $_SESSION['iduser'];
		$filtro = "and porcentajetarjetaC = '$idSocio' ";
	}else{
		$filtro = "";
	}
	$selectForTime = "SELECT dateFecha, timeHora FROM Concierto WHERE porcentajetarjetaC = '$id' AND strEstado = 'Activo'" or die (mysqli_error());
	
	if ($currentUser == 1) {
		$selecConcierto = "SELECT idConcierto, strImagen, strEvento, strLugar, dateFecha, timeHora 
						FROM Concierto 
						WHERE porcentajetarjetaC = '$id' 
						AND strEstado = 'Activo'
						" or die(mysqli_error());
	}else{
		$selecConcierto = "SELECT idConcierto, strImagen, strEvento, strLugar, dateFecha, timeHora 
						FROM Concierto 
						WHERE porcentajetarjetaC = '$id' 
						AND strEstado = 'Activo' 
						AND dateFecha > DATE_SUB(NOW(), INTERVAL 1 DAY)
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