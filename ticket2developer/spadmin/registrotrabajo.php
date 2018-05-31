<?php 
	include("../controlusuarios/seguridadSA.php");
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$idsocio = $_REQUEST['datosSocio'];
	$idauto = $_REQUEST['datosAuto'];
	
	$select = "SELECT idAutorizacion, idSocio, rucS, razonsocialS, nombresS, fechaautorizacioA, nroautorizacionA, tipodocumentoA, secuencialinicialA, secuencialfinalA 
				FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio WHERE idAutorizacion = ? AND idsocioA = ?";
	$slt = $gbd -> prepare($select);
	$slt -> execute(array($idauto,$idsocio));
	$row = $slt -> fetch(PDO::FETCH_ASSOC);
	
	$trabajook = "SELECT * FROM registrotrabajos WHERE idsocioRT = ? AND idautorizacionRT = ?";
	$tok = $gbd -> prepare($trabajook);
	$tok -> execute(array($idsocio,$idauto));
	$resulttrabajo = $tok -> rowCount();
	echo '<tr>
			<td>
				<p><strong>R.U.C.:</strong></p>
				<input type="text" id="ruc" class="inputopcional" value="'.$row['rucS'].'" readonly="readonly" size="35"/>
			</td>
			<td>
				<p><strong>Raz&oacute;n Social:</strong></p>
				<input type="text" id="razonsocial" class="inputopcional" value="'.$row['razonsocialS'].'" readonly="readonly" size="35" />
			</td>
		</tr>
		<tr>
			<td>
				<p><strong>Nombres y Apellidos:</strong></p>
				<input type="text" id="nom" class="inputopcional" value="'.$row['nombresS'].'" readonly="readonly" size="35" />
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
			</td>
			<td>
				<p><strong>Secuencial Final:</strong></p>
				<input type="text" id="secfin" class="inputopcional" value="'.$row['secuencialfinalA'].'" readonly="readonly" size="35" />
			</td>
		</tr>';
		if($resulttrabajo < 1){
			echo '<tr>
					<td>
						<p><strong>Secuencial Inicial Informada:</strong></p>
						<input type="text" id="seciniinfo" class="inputlogin" size="35" maxlength="9" onkeypress="return validarNumeros(event)"/>
					</td>
					<td>
						<p><strong>Secuencial Final Informada:</strong></p>
						<input type="text" id="secfininfo" class="inputlogin" size="35" maxlength="9" onkeypress="return validarNumeros(event)" />
					</td>
				</tr>';
		}
		echo' <tr>
			<td colspan="2">';
				if($resulttrabajo > 0){
					echo '<center><p style="font-size:24px; color:#B2B200;"><strong>YA SE REGISTRO ESTE TRABAJO</strong></p></center>';
				}else{
					echo '<p><strong>Observaciones:</strong></p>
							<textarea cols="30" rows="5" id="obs" class="inputlogin" placeholder="Escribir una observaci&oacute;n..." maxlength="1000"></textarea>';
				}
			echo'</td>
		</tr>
		<tr style="text-align:center;">
			<td colspan="2">';
				if($resulttrabajo > 0){
					echo '<button type="button" id="acept" class="btndegradate" onclick="acept()">ACEPTAR</button>';
				}else{
					echo '<button type="button" id="guardar" class="btndegradate" onclick="guardarregistro('.$idsocio.','.$idauto.')">GUARDAR</button>&nbsp;&nbsp;&nbsp;
							<button type="button" id="cancelall" class="btndegradate" onclick="cancelall()">CANCELAR</button>';
				}
			echo'</td>
		</tr>';
?>