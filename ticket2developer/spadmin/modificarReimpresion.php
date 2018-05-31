<?php 
	include("../controlusuarios/seguridadSA.php");
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$id = $_REQUEST['id'];
	
	$sql = "SELECT nombresS, rucS, secuinicialRS, secufinalRS, secuencialinicialA, secuencialfinalA FROM reimpresiones JOIN Socio ON reimpresiones.idsocioRS = Socio.idSocio JOIN autorizaciones ON reimpresiones.idautoRS = autorizaciones.idAutorizacion AND idReimpresiones = ?";
	$stmt = $gbd -> prepare($sql);
	$stmt -> execute(array($id));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	
	echo '<tr>
			<td>
				<p><strong>Razon Social:</strong></p>
				<input type="text" id="nom" class="inputopcional" value="'.$row['nombresS'].'" readonly="readonly" size="35" />
			</td>
			<td>
				<p><strong>R.U.C.:</strong></p>
				<input type="text" id="fauto" class="inputopcional" value="'.$row['rucS'].'" readonly="readonly" size="35" />
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" id="inicialbd" value="'.$row['secuencialinicialA'].'" />
			</td>
			<td>
				<input type="hidden" id="finalbd" value="'.$row['secuencialfinalA'].'" />
			</td>
		</tr>
		<tr>
			<td>
				<p><strong>Secuencial Inicial Reimpresión:</strong></p>
				<input type="text" id="seciniinfo" class="inputlogin" onchange="modificaInicial()" value="'.$row['secuinicialRS'].'" size="35" onkeypress="return validarNumeros(event)" />
			</td>
			<td>
				<p><strong>Secuencial Final Reimpresión:</strong></p>
				<input type="text" id="secfininfo" class="inputlogin" onchange="modificaFinal()" value="'.$row['secufinalRS'].'" size="35" onkeypress="return validarNumeros(event)" />
			</td>
		</tr>
		<tr style="text-align:center;">
			<td colspan="2">
				<button class="btndegradate" id="editar" onclick="guardarModificacion('.$id.')">GUARDAR</button>&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" id="cancelall" class="btndegradate" onclick="cancelall(2)">CANCELAR</button>
			</td>
		</tr>';
?>