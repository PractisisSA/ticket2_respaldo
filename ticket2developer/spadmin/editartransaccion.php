<?php 
	date_default_timezone_set('America/Guayaquil');
	include("../controlusuarios/seguridadSA.php");
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$autoriza = $_REQUEST['auto'];
	
	$select = "SELECT * FROM autorizaciones WHERE idAutorizacion = ?";
	$slt = $gbd -> prepare($select);
	$slt -> execute(array($autoriza));
	$row = $slt -> fetch(PDO::FETCH_ASSOC);
	
	$registro = "SELECT * FROM registrotrabajos WHERE idautorizacionRT = ?";
	$res = $gbd -> prepare($registro);
	$res -> execute(array($autoriza));
	$numreg = $res -> rowCount();
	$rowres = $res -> fetch(PDO::FETCH_ASSOC);
	
	echo '<tr>
			<td>
				<p><strong>Nombres Comercial:</strong></p>
				<input type="text" id="nom" class="inputopcional" value="'.$row['nombrecomercialAHIS'].'" readonly="readonly" size="35" />
			</td>
			<td>
				<p><strong>Fecha de Autorizaci&oacute;n:</strong></p>
				<input type="text" id="fauto" class="inputopcional" value="'.$row['fechaautorizacioA'].'" readonly="readonly" size="35" />
			</td>
		</tr>
		<tr>
			<td>
				<p><strong>Nro. de Autorizaci&oacute;n:</strong></p>
				<input type="text" id="nroauto" class="inputopcional" value="'.$row['nroautorizacionA'].'" readonly="readonly" size="35" />
			</td>
			<td>
				<p><strong>Tipo de Documento:</strong></p>
				<input type="text" id="tdoc" class="inputopcional" value="'.$row['tipodocumentoA'].'" readonly="readonly" size="35" />
			</td>
		</tr>
		<tr>
			<td>
				<p><strong>Secuencial Inicial:</strong></p>
				<input type="text" id="secini" class="inputopcional" value="'.$row['secuencialinicialA'].'" readonly="readonly" size="35" />
				<input type="hidden" id="inicialbd" value="'.$row['secuencialinicialA'].'" />
			</td>
			<td>
				<p><strong>Secuencial Final:</strong></p>
				<input type="text" id="secfin" class="inputopcional" value="'.$row['secuencialfinalA'].'" readonly="readonly" size="35" />
				<input type="hidden" id="finalbd" value="'.$row['secuencialfinalA'].'" />
			</td>
		</tr>
		<tr>
			<td>
				<p><strong>Secuencial Inicial Informado:</strong></p>';
				if($row['estadoimpresionA'] == 'Aun no se Imprime'){
					$inicial = 0;
					$final = 0;
					$edit1 = '';
					$edit2 = '';
				}else{
					$inicial = $row['inicialimpresoA'];
					$final = $row['finalimpresoA'];
					$edit1 = '<img src="imagenes/lapiama.png" style="cursor:pointer;"  id="lapiz1" onclick="modificarCampos(1)"/>';
					$edit2 = '<img src="imagenes/lapiama.png" style="cursor:pointer;"  id="lapiz2" onclick="modificarCampos(2)"/>';
				}
				echo '<input type="text" id="seciniinfo" class="inputopcional" value="'.$inicial.'" onchange="modificaInicial()" readonly="readonly" size="35" />
				'.$edit1.'
				<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x1" onclick="cancelMod(1)"/>
			</td>
			<td>
				<p><strong>Secuencial Final Informado:</strong></p>
				<input type="text" id="secfininfo" class="inputopcional" value="'.$final.'" onchange="modificaFinal()" readonly="readonly" size="35" />
				'.$edit2.'
				<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x2" onclick="cancelMod(2)"/>
			</td>
		</tr>
		<tr>
			<td>';
				if($row['estadoimpresionA'] == 'Aun no se Imprime'){
					$tipo = 'Trabajo en 0';
				}else if(($row['inicialimpresoA'] != $row['secuencialinicialA']) || ($row['finalimpresoA'] != $row['secuencialfinalA'])){
					$tipo = 'Trabajo Incompleto';
				}else{
					$tipo = 'Trabajo Completo';
				}
				echo '<p><strong><span id="tipo_trabajo">'.$tipo.'</span></strong></p>
			</td>
			<td>
				<p><strong>Observaciones</strong></p>
				<p><textarea cols="40" rows="3" id="obstrans" class="inputlogin" placeholder="Escribe una observaci&oacute;n"></textarea></p>
			</td>
		</tr>
		<tr style="text-align:center;">
			<td colspan="2">
				<button class="btndegradate" id="editar" onclick="guardarEdicion('.$autoriza.','.$row['idsocioA'].')">GUARDAR</button>&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" id="cancelall" class="btndegradate" onclick="cancelall()">CANCELAR</button>
			</td>';
			
		echo '</tr>';
?>