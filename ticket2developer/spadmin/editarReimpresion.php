<?php 
	include("../controlusuarios/seguridadSA.php");
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$autoriza = $_REQUEST['auto'];
	
	$sql = "SELECT * FROM reimpresiones WHERE idautoRS = ? AND reimpresoRS = ?";
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute(array($autoriza,'no'));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	$num_rows = $stmt -> rowCount();
	
	if($num_rows > 0){
		echo '<tr style="text-align:center;">
				<td>
					<h3><strong>Tienes una reimpresión pendiente de esta Autorización</strong></h3><br>
					<strong>No puedes crear otra reimpresión</strong><br><br>
					<button type="button" class="btnlink" id="verReimpresion" onclick="verReimpresion('.$row['idReimpresiones'].')"><strong>Ver</strong></button>&nbsp;&nbsp;<strong>Reimpresión</strong>
				</td>
			</tr>
			<tr style="text-align:center;">
				<td colspan="2">
					<button type="button" id="cancelall" class="btndegradate" onclick="cancelall(1)">Cerrar</button>
				</td>
			</tr>';
	}else{
		$select = "SELECT * FROM autorizaciones WHERE idAutorizacion = ?";
		$slt = $gbd -> prepare($select);
		$slt -> execute(array($autoriza));
		$row2 = $slt -> fetch(PDO::FETCH_ASSOC);
		if($row2['estadoimpresionA'] != 'impreso'){
			echo '<tr style="text-align:center;">
					<td>
						<h3><strong>Aún no imprimes este Documento</strong></h3><br>
						<strong>Puedes imprimirlo aqui : <a href="?modulo=imPrint" style="text-decoration:none;">DOCUMENTOS</a></strong>
					</td>
				</tr>
				<tr style="text-align:center;">
					<td colspan="2">
						<button type="button" id="cancelall" class="btndegradate" onclick="cancelall(1)">Cerrar</button>
					</td>
				</tr>';
		}else{
			echo '<tr>
					<td>
						<p><strong>Nombres Comercial:</strong></p>
						<input type="text" id="nom" class="inputopcional" value="'.$row2['nombrecomercialAHIS'].'" readonly="readonly" size="35" />
					</td>
					<td>
						<p><strong>Fecha de Autorizaci&oacute;n:</strong></p>
						<input type="text" id="fauto" class="inputopcional" value="'.$row2['fechaautorizacioA'].'" readonly="readonly" size="35" />
					</td>
				</tr>
				<tr>
					<td>
						<p><strong>Nro. de Autorizaci&oacute;n:</strong></p>
						<input type="text" id="nroauto" class="inputopcional" value="'.$row2['nroautorizacionA'].'" readonly="readonly" size="35" />
					</td>
					<td>
						<p><strong>Tipo de Documento:</strong></p>
						<input type="text" id="tdoc" class="inputopcional" value="'.$row2['tipodocumentoA'].'" readonly="readonly" size="35" />
					</td>
				</tr>
				<tr>
					<td>
						<p><strong>Secuencial Inicial:</strong></p>
						<input type="text" id="secini" class="inputopcional" value="'.$row2['secuencialinicialA'].'" readonly="readonly" size="35" />
						<input type="hidden" id="inicialbd" value="'.$row2['secuencialinicialA'].'" />
					</td>
					<td>
						<p><strong>Secuencial Final:</strong></p>
						<input type="text" id="secfin" class="inputopcional" value="'.$row2['secuencialfinalA'].'" readonly="readonly" size="35" />
						<input type="hidden" id="finalbd" value="'.$row2['secuencialfinalA'].'" />
					</td>
				</tr>
				<tr>
					<td>
						<p><strong>Secuencial Inicial Reimpresión:</strong></p>
						<input type="text" id="seciniinfo" class="inputlogin" onchange="modificaInicial()" size="35" onkeypress="return validarNumeros(event)" />
					</td>
					<td>
						<p><strong>Secuencial Final Reimpresión:</strong></p>
						<input type="text" id="secfininfo" class="inputlogin" onchange="modificaFinal()" size="35" onkeypress="return validarNumeros(event)" />
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
						<p><strong>Observaciones</strong></p>
						<p><textarea cols="40" rows="3" id="obstrans" class="inputlogin" placeholder="Escribe una observaci&oacute;n"></textarea></p>
					</td>
				</tr>
				<tr style="text-align:center;">
					<td colspan="2">
						<button class="btndegradate" id="editar" onclick="guardarEdicion('.$autoriza.','.$row2['idsocioA'].')">GUARDAR</button>&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" id="cancelall" class="btndegradate" onclick="cancelall(2)">CANCELAR</button>
					</td>
				</tr>';
		}
	}
?>