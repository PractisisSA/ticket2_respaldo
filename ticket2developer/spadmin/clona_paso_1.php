<?php
	session_start();
	
	include '../conexion.php';
	$id = $_REQUEST['id'];
	date_default_timezone_set("America/Guayaquil");
	$sql = 'select * from Concierto where idConcierto = "'.$id.'"';
	$res = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($res);
	$hoy = date("Y-m-d"); 
	$hora = date("H:i:s"); 
	$dateFecha= $hoy; 
	$dateFechaReserva= $row['dateFechaReserva']; 
	$dateFechaPReserva= $row['dateFechaPReserva']; 
	$dateFechaPreventa= $row['dateFechaPreventa']; 
	$strLugar= $row['strLugar']; 
	$timeHora= $hora; 
	$strEvento= $row['strEvento']; 
	$strImagen= $row['strImagen']; 
	$strVideoC= $row['strVideoC']; 
	$strDescripcion= $row['strDescripcion']; 
	$strCaractristica= $row['strCaractristica']; 
	$intCantArtC= $row['intCantArtC']; 
	$tiempopagoC= $row['tiempopagoC']; 
	$dircanjeC= $row['dircanjeC']; 
	$horariocanjeC= $row['horariocanjeC']; 
	$fechainiciocanjeC= $row['fechainiciocanjeC']; 
	$fechafinalcanjeC= $row['fechafinalcanjeC']; 
	$costoenvioC= $row['costoenvioC']; 
	
	if($_SESSION['perfil'] == ' Admin_Socio'){
		$porcentajetarjetaC = $_SESSION['iduser'];
	}else{
		$porcentajetarjetaC= $row['porcentajetarjetaC']; 
	}
	
	$strMapaC= $row['strMapaC']; 
	$strMapaFill= $row['strMapaFill']; 
	$idUser= $row['idUser']; 
	$createbyC= $row['createbyC']; 
	$fechaCreacionC= $row['fechaCreacionC']; 
	$strEstado= $row['strEstado']; 
	$tiene_permisos = 0;//$row['tiene_permisos']; 
	$autMun= $row['autMun']; 
	$locPago= $row['locPago']; 
	$dirPago= $row['dirPago']; 
	$fecha= $row['fecha']; 
	$hora= $row['hora']; 
	$tipo_conc= $row['tipo_conc']; 
	$es_publi= $row['es_publi']; 
	$img_bol_izq= $row['img_bol_izq']; 
	$img_bol_cen= $row['img_bol_cen']; 
	$img_bol_der= $row['img_bol_der']; 
	$img_bol_Acen = $row['img_bol_Acen'];
	$envio = $row['envio'];
	
	$sql2='	INSERT INTO `Concierto` (`idConcierto`, `dateFecha`, `dateFechaReserva`, `dateFechaPReserva`, `dateFechaPreventa`, `strLugar`, `timeHora`, `strEvento`, `strImagen`, `strVideoC`, `strDescripcion`, `strCaractristica`, `intCantArtC`, `tiempopagoC`, `dircanjeC`, `horariocanjeC`, `fechainiciocanjeC`, `fechafinalcanjeC`, `costoenvioC`, `porcentajetarjetaC`, `strMapaC`, `strMapaFill`, `idUser`, `createbyC`, `fechaCreacionC`, `strEstado`, `tiene_permisos`, `autMun`, `locPago`, `dirPago`, `fecha`, `hora`, `tipo_conc`, `es_publi`, `img_bol_izq`, `img_bol_cen`, `img_bol_der`, `img_bol_Acen`, `envio`) 
			VALUES (null , "'.$dateFecha.'", "'.$dateFechaReserva.'", "'.$dateFechaPReserva.'", "'.$dateFechaPreventa.'", "'.$strLugar.'", "'.$timeHora.'", "'.$strEvento.'_clonado", "'.$strImagen.'", "'.$strVideoC.'", "'.$strDescripcion.'", "'.$strCaractristica.'", "'.$intCantArtC.'", "'.$tiempopagoC.'", "'.$dircanjeC.'", "'.$horariocanjeC.'", "'.$fechainiciocanjeC.'", "'.$fechafinalcanjeC.'", "0", "'.$porcentajetarjetaC.'", "'.$strMapaC.'", "'.$strMapaFill.'", "'.$idUser.'", "'.$createbyC.'", "'.$fechaCreacionC.'", "'.$strEstado.'", "'.$tiene_permisos.'", "'.$autMun.'", "'.$locPago.'", "'.$dirPago.'", "'.$fecha.'", "'.$hora.'", "'.$tipo_conc.'", "1", "0", "0", "0", "0", "'.$envio.'")';
	//echo $sql2;
	$res = mysql_query($sql2) or die (mysql_error());
	$idConc = mysql_insert_id();
	if($res){
		$tabla = "<table class = 'table table-condensed'>
			<tr>
				<td colspan = '5' align = 'center' style = 'color:#fff;text-transform:uppercase;background-color:#ED1568;'>
					LOCALIDADES DEL EVENTO <b>".$strEvento."</b> QUE SE ESTA CLONANDO
				</td>
			</tr>
			<tr>
				<td>ID</td>
				<td>NOMBRE</td>
				<td>PRECIO</td>
				<td>CANTIDAD</td>
				<td>CLONAR</td>
			</tr>";
		
		
		$sqlL = 'SELECT * FROM `Localidad` WHERE `idConc` = "'.$id.'" ORDER BY `strDescripcionL` ASC ';
		$resL = mysql_query($sqlL) or die (mysql_error());
		while($rowL = mysql_fetch_array($resL)){
			$sqlOc = 'SELECT count(id) as num_ocupadas FROM `ocupadas` WHERE `status` = 3 AND `local` = "'.$rowL['idLocalidad'].'" ORDER BY `id` DESC ';
			$resOc = mysql_query($sqlOc) or die (mysql_error());
			$rowOc = mysql_fetch_array($resOc);
			if($rowOc['num_ocupadas']>0){
				$btnOc = "<button type='button' onclick = 'clonaOcupadas(".$rowL['idLocalidad']." , 3 , ".$idConc.")' class='btn btn-info' id = 'btn_local_fade_ocupadas".$rowL['idLocalidad']."' style = 'display:none;'>Clonar [".$rowOc['num_ocupadas']."]Asientos Bloqueados!  <img src = 'imagenes/loading.gif' style = 'display:none;width:30px;' id = 'img_local_fade_ocupadas".$rowL['idLocalidad']."'/></button>";
			}else{
				$btnOc = '';
			}
		$tabla.="	
			<tr>
				<td>".$rowL['idLocalidad']."</td>
				<td>".$rowL['strDescripcionL']."</td>
				<td>".$rowL['doublePrecioL']."</td>
				<td>".$rowL['strCapacidadL']."</td>
				<td class = 'recibeOcupados_".$rowL['idLocalidad']."'>
					<button onclick = 'clonarLocalidad(".$rowL['idLocalidad']." , ".$idConc.")' id = 'btn_local_".$rowL['idLocalidad']."' type='button' class='btn btn-warning'>Clonar Localidad [".$rowL['idLocalidad']."]</button>
					<button type='button' class='btn btn-success' id = 'btn_local_fade_".$rowL['idLocalidad']."' style = 'display:none;'>Localidad Clonada!</button>";
					//$tabla.=$btnOc;
		$tabla.="</td>
			</tr>";

		}
		//$tabla.="<tr><td colspan = '5' align = 'center'></td></tr>";
		$tabla.="</table>";
		
		echo $tabla;
	}else{
		echo 'error';
	}
?>









