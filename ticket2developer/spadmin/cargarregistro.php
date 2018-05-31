<?php 
	include("../controlusuarios/seguridadSA.php");
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$idsocio = $_REQUEST['datos'];
	
	$estadotrans = 'Transaccion Incompleta';
	$selectAuto = "SELECT * FROM autorizaciones WHERE idsocioA = ? AND estadoAuto = ?";
	$sltAuto = $gbd -> prepare($selectAuto);
	$sltAuto -> execute(array($idsocio,$estadotrans));
	$resultadook = $sltAuto -> rowCount();
	if($resultadook > 0){
		echo '<tr style="text-align:center;">
				<td>
					<strong>Seleccione Autorizaci&oacute;n</strong>
					<select id="datos_auto" class="inputlogin" onchange="cargarRegistro()">
						<option value="0">Seleccione...</option>';
						while($row = $sltAuto -> fetch(PDO::FETCH_ASSOC)){
							echo '<option value="'.$row['idAutorizacion'].'">'.$row['nroautorizacionA'].' - '.$row['tipodocumentoA'].'</option>';
						}
					echo' </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" class="btnlink" id="cancelar" onclick="cancelar()">Cencelar</button>
				<td>
			</tr>';
	}else{
		echo '<tr style="text-align:center;">
				<td style="font-size:20px; color:#B2B200;">
					<strong>No hay AUTORIZACIONES de este CLIENTE</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" class="btnlink" id="cancelar" onclick="cancelar()">Cencelar</button>
				</td>
			</tr>';
	}
?>