<?php
	date_default_timezone_set('America/Guayaquil');
	//include("../controlusuarios/seguridadSA.php");
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$id = $_REQUEST['id'];
	
	$select = "SELECT * FROM Socio WHERE idSocio = ?";
	$slt = $gbd -> prepare($select);
	$slt -> execute(array($id));
	$row = $slt -> fetch(PDO::FETCH_ASSOC);
	$dateok = $slt -> rowCount();
	if($dateok > 0){
		$idS = htmlspecialchars($row['idSocio']);
		$ruc = htmlspecialchars($row['rucS']);
		$nombre = htmlspecialchars($row['nombresS']);//razon social
		$razonsocial = htmlspecialchars($row['razonsocialS']);//nombre comercial
		$matriz = htmlspecialchars($row['direccionesS']);
		$dirstab = htmlspecialchars($row['direstablecimientoS']);
		$printpara = htmlspecialchars($row['imprimirparaS']);
		$establecimiento = htmlspecialchars($row['descripciondirS']);
		$nroestablecimiento = htmlspecialchars($row['nroestablecimientoS']);
		$contribuyente = htmlspecialchars($row['tipocontribuyenteS']);
		$act = htmlspecialchars($row['actividadS']);
		$categoria = htmlspecialchars($row['categoria']);
		if($contribuyente == 'Contribuyente Especial'){
			$nrocontribuyente = htmlspecialchars($row['nroespecialS']);
		}else{
			$nrocontribuyente = 'No es Contribuyente Especial';
		}
		$limite = 1;
		$auto = "SELECT secuencialfinalA FROM autorizaciones WHERE idsocioA = ? ORDER BY idAutorizacion DESC LIMIT ?";
		$secu = $gbd -> prepare($auto);
		$secu -> execute(array($id,$limite));
		$rowSec = $secu -> fetch(PDO::FETCH_ASSOC);
		$secuOk = $secu -> rowCount();
		
		$selectemision = "SELECT * FROM sucursal_empresa WHERE idempresaSE = ?";
		$emi = $gbd -> prepare($selectemision);
		$emi -> execute(array(1));
		$idmodify = 1;
		echo '<tr style="text-align:right; color:#000; font-size:22px;">
				<td colspan = "2">
					<p><strong>'.$nombre.'</strong></p>
					<input type="hidden" id="idsoo" value="'.$idS.'" />
				</td>
			</tr>
			<tr>
				<td>
					<p><strong>R.U.C.:</strong></p>
					<p><input type="text" class="inputopcional" id="rucCliente" onchange="ValidarCedula()" onkeyup="validarDato(this.value)" onkeypress="return validarNumeros(event)" value="'.$ruc.'" readonly="readonly" size="35" />
					<input type="hidden" id="rucbd" value="'.$ruc.'" />
					<img src="imagenes/lapiama.png" style="cursor:pointer;" id="lapiz1" onclick="modificarCampos(1)"/>
					<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x1" onclick="cancelMod(1)"/></p>
				</td>
				<td>
					<p><strong>Nombre Comercial:</strong></p>
					<p><input type="text" class="inputopcional" id="razonsocial" value="'.$razonsocial.'" onkeyup="validarDato(this.value)" readonly="readonly" size="35" />
					<input type="hidden" id="razonsocialbd" value="'.$razonsocial.'" />
					<img src="imagenes/lapiama.png" style="cursor:pointer;"  id="lapiz2" onclick="modificarCampos(2)"/>
					<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x2" onclick="cancelMod(2)"/></p>
				</td>
			</tr>
			<tr>
				<td>
					<p><strong>Descripci&oacute;n del Establecimiento:</strong></p>
					<p><input type="text" class="inputopcional" id="establecimiento" value="'.$establecimiento.'" readonly="readonly" size="35" />
					<!--<img src="imagenes/lapiama.png" style="cursor:pointer;"  id="lapiz7" onclick="modificarCampos(7)"/>-->
					<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x7" onclick="cancelMod(7)"/></p>
				</td>
				<td>
					<p><strong>Serie del Establecimiento:</strong></p>';
					if((strlen($nroestablecimiento) == 1)){
						$nroestablecimiento = '00'.$nroestablecimiento;
					}else{
						if((strlen($nroestablecimiento) == 2)){
							$nroestablecimiento = '0'.$nroestablecimiento;
						}else{
							if((strlen($nroestablecimiento) > 2)){
								$nroestablecimiento = $nroestablecimiento;
							}
						}
					}
				echo '<p><input type="text" class="inputopcional" id="serie" value="'.$nroestablecimiento.'" readonly="readonly" onkeypress="return validarNumeros(event)" maxlength="3" size="35" onkeyup="nuevocodigo(this.value)" />
				<input type="hidden" id="codigobd" value="'.$nroestablecimiento.'" />
					<img src="imagenes/lapiama.png" style="cursor:pointer;"  id="lapiz8" onclick="modificarCampos(8)"/>
					<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x8" onclick="cancelMod(8)"/></p>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p><strong>Direcci&oacute;n Matriz:</strong></p>
					<p><input type="text" class="inputopcional" id="matriz" value="'.$matriz.'" readonly="readonly" size="87" />
					<input type="hidden" id="matrizbd" value="'.$matriz.'" />
					<img src="imagenes/lapiama.png" style="cursor:pointer;"  id="lapiz3" onclick="modificarCampos(3)"/>
					<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x3" onclick="cancelMod(3)"/></p>
				</td>
			</tr>';
			if($printpara == 's'){
				$mostrar = '';
				$button = '<input type="hidden" id="identificadorSuc" value="" />';
			}else{
				$mostrar = 'style="display:none;"';
				$button = '<tr id="btnAddsucursal" style="text-align:center;">
							<td colspan="2">
								<button class="btnlink" onclick="addSucursal()">Añadir Sucursal</button>
							</td>
						</tr>
						<tr class="newSucursal" style="display:none;">
							<td colspan="2">
								<p><input type="text" class="inputlogin" id="sucursal" placeholder="Añade tu direccion sucursal" size="87" />
								<img src="imagenes/clouse.png" style="cursor:pointer;" onclick="cancelSuc()"/></p>
								<input type="hidden" id="identificadorSuc" value="" />
							</td>
						</tr>';
			}
			echo $button;
		echo '<tr '.$mostrar.'>
				<td colspan="2">
					<p><strong>Direcci&oacute;n Sucursal:</strong></p>
					<p><input type="text" class="inputopcional" id="direstab" value="'.$dirstab.'" readonly="readonly" size="87" />
					<input type="hidden" id="direstabbd" value="'.$dirstab.'" />
					<img src="imagenes/lapiama.png" style="cursor:pointer;"  id="lapiz4" onclick="modificarCampos(4)"/>
					<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x4" onclick="cancelMod(4)"/></p>
				</td>
			</tr>';
		echo'<tr>
				<td>
					<p><strong>Clase del Contribyente:</strong></p>
					<p><input type="text" class="inputopcional" id="contribuyente" readonly="readonly" value="'.$contribuyente.'" size="35" />
					<!--<img src="imagenes/lapiama.png" style="cursor:pointer;"  id="lapiz5" onclick="modificarCampos(5)"/></p>-->
					<p id="newcontribuyente" style="display:none;"><select onchange="cambioContribuyente()" id="cambioContribuyente" class="inputlogin">
						<option value="0">Seleccione...</option>
						<option value="1">Obligado a llevar Contabilidad</option>
						<option value="2">No Obligado a llevar Contabilidad</option>
						<option value="3">Contribuyente Especial</option>
						<option value="4">Contribuyente RISE</option>
					</select>
					<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x5" onclick="cancelMod(5)"/></p>
				</td>
				<td>
					<p><strong>Nro. Contribuyente Especial:</strong></p>
					<p><input type="text" class="inputopcional" id="nrocontribuyente" readonly="readonly" value="'.$nrocontribuyente.'" size="35" />
					<!--<img src="imagenes/lapiama.png" style="cursor:pointer;"  id="lapiz6" onclick="modificarCampos(6)"/>-->
					<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x6" onclick="cancelMod(6)"/></p>
				</td>
			</tr>
			<tr>
				<td>';
				if($contribuyente == 'Contribuyente RISE'){
				echo '<p class="outActividad"><strong>Actividad Econ&oacute;mica:</strong></p>
					<p><input type="text" class="inputopcional" id="actividad" readonly="readonly" value="'.$act.'" size="35" />
					<img src="imagenes/lapiama.png" class="outActividad" style="cursor:pointer;"  id="lapiz9" onclick="modificarCampos(9)"/></p>';
				}else{
					echo '<input type="hidden" class="inputopcional" id="actividad" readonly="readonly" value="'.$act.'" size="35" />';
				}
				echo '<p class="otherActividad" style="display:none;"><strong>Actividad Econ&oacute;mica:</strong></p>
						<p id="newActividad" class="otherActividad" style="display:none;"><select class="inputlogin" id="actividadEconomica" onchange="valoresActividad()">
							<option value="0">Seleccione...</option>
							<option value="1">Actividades de Comercio</option>
							<option value="2">Actividades de Servicio</option>
							<option value="3">Actividades de Manufactura</option>
							<option value="4">Actividades de Construcción</option>
							<option value="5">Hoteles y Restaurantes</option>
							<option value="6">Actividades de Trasnporte</option>
							<option value="7">Actividades Agrícolas</option>
							<option value="8">Actividades de Minas y Canteras</option>
						</select>
						<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x9" onclick="cancelMod(9)"/></p>
				</td>
				<td>';
				if($contribuyente == 'Contribuyente RISE'){
				echo '<p class="outCategoria"><strong>Categor&iacute;a:</strong></p>
					<p><input type="text" class="inputopcional" id="categoria" readonly="readonly" value="'.$categoria.'" size="35" />
					<img src="imagenes/lapiama.png" class="outCategoria" style="cursor:pointer;"  id="lapiz10" onclick="modificarCampos(10)"/></p>';
					}else{
						echo '<input type="hidden" class="inputopcional" id="categoria" readonly="readonly" value="'.$categoria.'" size="35" />';
					}
				echo '<p class="otherCategoria" style="display:none;"><strong>Categor&iacute;a:</strong></p>
					<p id="newCategoria" class="otherCategoria" style="display:none;"><select class="inputlogin" id="cat" onchange="valoresCategoria()">
							<option value="0">Seleccione...</option>
							<option value="1">Categoría 1</option>
							<option value="2">Categoría 2</option>
							<option value="3">Categoría 3</option>
							<option value="4">Categoría 4</option>
							<option value="5">Categoría 5</option>
							<option value="6">Categoría 6</option>
							<option value="7">Categoría 7</option>
						</select>
						<img src="imagenes/clouse.png" style="cursor:pointer; display:none;" id="x10" onclick="cancelMod(10)"/></p>
				</td>
			</tr>';
			if($contribuyente == 'Contribuyente RISE'){
		echo '<tr class="tipoRise" style="text-align:center; display:none;">
				<td>
					<p><strong>Anuales</strong></p>
					Desde&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta<br>
					$<input type="text" id="inferior1" class="inputopcional" readonly="readonly" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					$<input type="text" id="superior1" class="inputopcional" readonly="readonly" size="10" />
				</td>
				<td>
					<p><strong>Mensuales Promedio</strong></p>
					Desde&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta<br>
					$<input type="text" id="inferior2" class="inputopcional" readonly="readonly" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					$<input type="text" id="superior2" class="inputopcional" readonly="readonly" size="10" />
				</td>
			</tr>
			<tr class="tipoRise" style="text-align:center; display:none;">
				<td colspan="2">
					<p><strong>Monto M&aacute;ximo para cada Documento</strong></p>
					<p>$<input type="text" id="monto" class="inputopcional" readonly="readonly" />,00 Dólares.</p>
				</td>
			</tr>';
			}
		echo '<tr>
				<td>
					<p><strong>Fecha de Autorizaci&oacute;n:</strong></p>
					<p><input type="text" class="inputlogin datepicker" id="fauto" readonly="readonly" placeholder="AAAA-MM-DD" size="35" onchange="calcularFecha()" onfocus="dateantes()" /></p>
				</td>
				<td>
					<p><strong>Fecha de Caducidad:</strong></p>
					<p><input type="text" class="inputlogin datepicker" id="fcadu" readonly="readonly" placeholder="AAAA-MM-DD" size="35" onfocus="date()" /></p>
				</td>
			</tr>';
			echo '<tr class="newSucursal" style="display:none;">
					<td colspan="2">
						<p><strong>Documentos Para:</strong></p>
						<select id="imrpresionpara2" class="inputlogin">
							<option value="0">Seleccione...</option>
							<option value="m">Matriz</option>
							<option value="s">Sucursal</option>
						</select>
					</td>
				</tr>';
			if($printpara == 's'){
				echo '<tr>
						<td colspan="2">
							<p><strong>Documentos Para:</strong></p>
							<select id="imrpresionpara" class="inputlogin">
								<option value="0">Seleccione...</option>
								<option value="m">Matriz</option>
								<option value="s">Sucursal</option>
							</select>
						</td>
					</tr>';
			}else{
				echo '<tr style="display:none;">
						<td colspan="2">
							<input type="hidden" id="imrpresionpara" value="m" />
						</td>
					</tr>';
			}
		echo '<tr>
				<td>
					<p><strong>Nro. de Autorizaci&oacute;n:</strong></p>
					<p><input type="text" class="inputlogin" id="nroAuto" onkeypress="return validarNumeros(event)" onchange="validarAuto()" maxlength="10" size="35" /></p>
				</td>
				<td>
					<p><strong>Emitido en:</strong></p>
					<p><select id="sucTicket" class="inputlogin">
						<option value="0">Seleccione...</option>';
						while($rowemi = $emi -> fetch(PDO::FETCH_ASSOC)){
							echo '<option value="'.$rowemi['idSE'].'">'.$rowemi['descripcionSE'].' - '.$rowemi['direccionSE'].'</option>';
						}
					echo' </select>
					</p>
				</td>
			</tr>
			<tr>
				<td>
				<p><strong>Observaciones</strong></p>
					<textarea cols="35" rows="3" id="observacion" class="inputlogin" placeholder="Escribe una observaci&oacute;n" maxlength="1000"></textarea>
				</td>
				<td>
					<p><strong>¿Desea que sus Facturas sean Negociables?</strong></p>
					<strong>Si</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="nego" onclick="verificarclick()" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table class="addfiles" style="width:100%; border:1px solid #fff; border-collapse:collapse; font-size:16px;">
						<tr style="text-align:center;">
							<td rowspan="2" style="border:1px solid #fff;">
								<strong>Serie</strong>
							</td>
							<td rowspan="2" style="border:1px solid #fff;">
								<strong>Tipo de Documento</strong>
							</td>
							<td colspan="2" style="border:1px solid #fff;">
								<strong>Secuencia Autorizada</strong>
							</td>
							<td rowspan="2">
								<strong>Docs.</strong>
							</td>
						</tr>
						<tr style="text-align:center;">
							<td style="border:1px solid #fff;">
								<strong>Inicial</strong>
							</td>
							<td style="border:1px solid #fff;">
								<strong>Final</strong>
							</td>
						</tr>
						<tr style="text-align:center;" class="numDocs" id="minusfile1">
							<td style="border:1px solid #fff;">
								<span id="nro">'.$nroestablecimiento.'</span>&nbsp;&nbsp;-&nbsp;&nbsp;<input type="text" class="inputlogin pEmision" id="pEmision1" onkeypress="return validarNumeros(event)" maxlength="3" size="3" onchange="comprobarEmision(1)" />
							</td>
							<td style="border:1px solid #fff; vertical-align:middle;">';
								if($contribuyente == 'Contribuyente RISE'){
									echo '<p><select class="inputlogin tdocumento" onchange="cambiartdoc(1)" id="tdocumento1">
									<option value="0">Seleccione...</option>
									<option value="2">Boleto</option>
									<option value="3">Nota de Cr&eacute;dito</option>
									<option value="4">Nota de D&eacute;bito</option>
									<option value="5">Nota de Venta</option>
									<option value="6">Lquidaci&oacute;n de Compras</option>
									<option value="7">Gu&iacute;a de Remisi&oacute;n</option>
									<option value="9">Tiquete Tax&iacute;metros y M. Regitradoras</option>
									<option value="10">L. Compra Bienes Muebles usados</option>
									<option value="11">L. Compra Veh&iacute;culos usados</option>
									<option value="12">Acta entrega/recepci&oacute;n Veh&iacute;culos usados</option>
								</select></p>';
								}else{
									echo '<p><select class="inputlogin tdocumento" onchange="cambiartdoc(1)" id="tdocumento1">
									<option value="0">Seleccione...</option>
									<option value="1">Factura</option>
									<option value="2">Boleto</option>
									<option value="3">Nota de Cr&eacute;dito</option>
									<option value="4">Nota de D&eacute;bito</option>
									<option value="5">Nota de Venta</option>
									<option value="6">Lquidaci&oacute;n de Compras</option>
									<option value="7">Gu&iacute;a de Remisi&oacute;n</option>
									<option value="8">Comprobante de Retenci&oacute;n</option>
									<option value="9">Tiquete Tax&iacute;metros y M. Regitradoras</option>
									<option value="10">L. Compra Bienes Muebles usados</option>
									<option value="11">L. Compra Veh&iacute;culos usados</option>
									<option value="12">Acta entrega/recepci&oacute;n Veh&iacute;culos usados</option>
								</select></p>';
								}
							echo '<p><input type="text" class="inputlogin otrodoc" id="otrodoc1" onkeypress="return validarLetras(event)" style="display:none;" size="15" /></p>
							</td>
							<td style="border:1px solid #fff;">
								<input type="text" class="inputlogin secuInicial" id="secuInicial1" size="8" maxlength="9" onkeypress="return validarNumeros(event)" onchange="comprobarInicial(1)" />
							</td>
							<td style="border:1px solid #fff;">
								<input type="text" class="inputlogin secuFinal" id="secuFinal1" onkeypress="return validarNumeros(event)" size="8" maxlength="9" onchange="comprobarFinal(1)" />
							</td>
							<td>
								<img src="imagenes/add.png" style="width:35px; cursor:pointer;" onclick="addfile()" />
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr style="text-align:center;">
				<td colspan="2">
					<button type="button" class="btndegradate" id="saveAuto" onclick="saveAuto('.$idS.')">GUARDAR</button>&nbsp;&nbsp;&nbsp;
					<button type="button" class="btndegradate" id="cancelAuto" onclick="cancelarAuto()">CANCELAR</button>
				</td>
			</tr>';
			
		$validarcod = "SELECT * FROM Socio WHERE rucS = ?";
		$valcod = $gbd -> prepare($validarcod);
		$valcod -> execute(array($ruc));
		
		$content1 = '<tr class="codigosval" style="display:none;">';
		while($rowval = $valcod ->fetch(PDO::FETCH_ASSOC)){
			$content1.= '<input type="hidden" class="codigosbd" value="'.$rowval['nroestablecimientoS'].'" />'; 
		}
		$content1.= '</tr>';
		
		echo $content1;
	}
?>