<?php 
	// include("../controlusuarios/seguridadSA.php");
	require('../Conexion/conexion.php');
	
	$id_con = $_REQUEST['id_concierto'];
	$estado = 'Revisar';
	$est_dep = 'Si';
	
	include '../conexion.php';
	// AND factura.estado = '$est_dep' 
	// and estadopagoPV <> 'pagado'
	
	$sql = "SELECT id, strNombresC, strDocumentoC, ndepo, factura.fecha, dateFechaPreventa , localidad , doublePrecioPreventa , valor , estadopagoPV
			FROM factura 
			JOIN Cliente 
			ON factura.id_cli = Cliente.idCliente 
			JOIN Concierto 
			ON factura.idConC = Concierto.idConcierto 
			JOIN Localidad 
			ON factura.localidad = Localidad.idLocalidad 
			WHERE factura.tipo = 1
			AND factura.estado = '$est_dep' 
			and estadopagoPV <> 'pagado'
			
			";
	// echo $sql."<br><br>";
	$res = mysql_query($sql) or die (mysql_error());
	$json =' { "Concierto" : ['    ;
    if(mysql_num_rows($res)){
        while($row = mysql_fetch_array($res))
        {
			
			$sqlDep = 'SELECT COUNT(idDeposito)as num_bol FROM Deposito WHERE idFactura = "'.$row['id'].'" ';
			$resDep = mysql_query($sqlDep) or die (mysql_error());
			$rowDep = mysql_fetch_array($resDep);
			$num_bol = $rowDep['num_bol'];
			$hoy = date("Y-m-d");
			$dateFechaPreventa = $row['dateFechaPreventa'];
			
			if($hoy <= $dateFechaPreventa){
				$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$row['localidad'].'"';
				$resLoc = mysql_query($localidad) or die (mysql_error());
				$rowLoc = mysql_fetch_array($resLoc);
				$precioVenta = $rowLoc['doublePrecioPreventa'];
				$precio = $rowLoc['doublePrecioPreventa'];
			}else{
				$localidad = 'SELECT * FROM Localidad WHERE idLocalidad = "'.$row['localidad'].'"';
				$resLoc = mysql_query($localidad) or die (mysql_error());
				$rowLoc = mysql_fetch_array($resLoc);
				$precioVenta = $rowLoc['doublePrecioPreventa'];
				$precio = $rowLoc['doublePrecioL'];
			}
			$id = trim($row['id']);
            $nombre = trim($row['strNombresC']);
            $documento = trim($row['strDocumentoC']);
			$num_dep = trim($row['ndepo']);
			$fecha = trim($row['fecha']);
			$estadopagoPV = trim($row['estadopagoPV']);
			
			
            $json .= '{ "id" : "'.$id.'", "nombre" : "'.$nombre.'" , "documento" : "'.$documento.'", "num_dep" : "'.$num_dep.'", "fecha" : "'.$fecha.'", "num_bol" : "'.$num_bol.'", "precio" : "'.$row['valor'].'", "estadopagoPV" : "'.$row['estadopagoPV'].'"  },'; 
        }
        $json=substr($json,0,-1);
    }
    $json.=' ]}';
    echo $json;
?>