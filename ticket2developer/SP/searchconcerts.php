<?php
	include("../controlusuarios/seguridadSP.php");
	require_once('../classes/private.db.php');
	
	$gbd = new DBConn();
	
	$id = $_POST['nombre'];
	$select = "SELECT idConcierto, dateFecha, strLugar, strEvento, strImagen, strEstado FROM Concierto WHERE createbyC = ?";
	$stmt = $gbd -> prepare($select);
	$stmt -> execute(array($id));
	$json =' { "Concierto" : ['    ;
    if($stmt -> rowCount()){
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC))
        {
			$id = $row['idConcierto'];
            $fecha = $row['dateFecha'];
			$lugar = $row['strLugar'];
            $evento = $row['strEvento'];
			$imagen = $row['strImagen'];
			$estado = $row['strEstado'];
            $json .= '{ "id" : "'.$id.'", "fecha" : "'.$fecha.'" , "lugar" : "'.$lugar.'", "evento" : "'.$evento.'", "imagen" : "'.$imagen.'", "estado" : "'.$estado.'" },'; 
        }
        $json=substr($json,0,-1);
    }
    $json.=' ]}';
    echo $json;
?>