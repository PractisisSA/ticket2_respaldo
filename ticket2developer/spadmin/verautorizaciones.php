<?php 
	// include("../controlusuarios/seguridadSA.php");
	require_once '../classes/private.db.php';
	
	$gbd = new DBConn();
	
	$idauto = $_REQUEST['id'];
	
	$select = "SELECT * FROM autorizaciones WHERE nroautorizacionA = ?";
	$slt = $gbd -> prepare($select);
	$slt -> execute(array($idauto));
	$row = $slt -> fetch(PDO::FETCH_ASSOC);
	
	$idAutorizacion = $row['idAutorizacion'];
	$ruc = $row['rucAHIS'];
	$razonsocial = $row['nombrecomercialAHIS'];
	$establecimiento = $row['desestablecimientoAHIS'];
	$nroestablecimiento = $row['codestablecimientoAHIS'];
	$matriz = $row['dirmatrizAHIS'];
	$dirstab = $row['direstablecimientoAHIS'];
	$contribuyente = $row['tipocontribuyenteAHIS'];
	$nrocontribuyente = $row['nroespecialAHIS'];
	$fechaauto = $row['fechaautorizacioA'];
	$fechacadu = $row['fechacaducidadA'];
	$nroauto = $row['nroautorizacionA'];
	$negociables = $row['facnegociablesA'];
	$obs = $row['observacionA'];
	
	$docs = "SELECT * FROM autorizaciones WHERE nroautorizacionA = ?";
	$doc = $gbd -> prepare($select);
	$doc -> execute(array($idauto));
	
	echo '<tr>
				<td>
					<p><strong>R.U.C.:</strong></p>
					<p><input type="text" class="inputopcional" id="rucCliente" value="'.$ruc.'"  size="35" />
				</td>
				<td>
					<p><strong>Nombre Comercial:</strong></p>
					<p><input type="text" class="inputopcional" id="razonsocial" value="'.$razonsocial.'"  size="35" />
				</td>
			</tr>
			<tr>
				<td>
					<p><strong>Descripci&oacute;n del Establecimiento:</strong></p>
					<p><input type="text" class="inputopcional" id="establecimiento" value="'.$establecimiento.'"  size="35" />
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
				echo '<p><input type="text" class="inputopcional" id="serie" value="'.$nroestablecimiento.'"  maxlength="3" size="35" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p><strong>Direcci&oacute;n Matriz:</strong></p>
					<p><input type="text" class="inputopcional" id="matriz" value="'.$matriz.'"  size="87" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p><strong>Direcci&oacute;n del Establecimiento:</strong></p>
					<p><input type="text" class="inputopcional" id="direstab" value="'.$dirstab.'"  size="87" />
				</td>
			</tr>
			<tr>
				<td>
					<p><strong>Clase del Contribyente:</strong></p>
					<p><input type="text" class="inputopcional" id="contribuyente"  value="'.$contribuyente.'" size="35" />
				</td>
				<td>
					<p><strong>Nro. Contribuyente Especial:</strong></p>
					<p><input type="text" class="inputopcional" id="nrocontribuyente"  value="'.$nrocontribuyente.'" size="35" />
				</td>
			</tr>
			<tr>
				<td>
					<p><strong>Fecha de Autorizaci&oacute;n:</strong></p>
					<p><input type="text" class="inputopcional" id="fauto"  value="'.$fechaauto.'" size="35" /></p>
				</td>
				<td>
					<p><strong>Fecha de Caducidad:</strong></p>
					<p><input type="text" class="inputopcional" id="fcadu"  value="'.$fechacadu.'" size="35" /></p>
				</td>
			</tr>
			<tr>
				<td>
					<p><strong>Nro. de Autorizaci&oacute;n:</strong></p>
					<p><input type="text" class="inputopcional" id="nroAuto"  value="'.$nroauto.'" size="35" /></p>
				</td>
				<td>
					<p><strong>Facturas Negociables:</strong></p>
					<p><input type="text" class="inputopcional" id="nego"  value="'.$negociables.'" size="35" /></p>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p><strong>Observaciones</strong></p>
					<p><textarea cols="35" rows="3" id="obs" class="inputopcional" >'.$obs.'</textarea></p>
				</td>
			</td>
			<tr>
				<td colspan="2">
					<table style="width:100%;">';
						while($rowdoc = $doc -> fetch(PDO::FETCH_ASSOC)){
							$inicial = '';
							if(strlen($rowdoc['secuencialinicialA']) == 1){
								$inicial = '00000000'.$rowdoc['secuencialinicialA'];
							}else{
								if(strlen($rowdoc['secuencialinicialA']) == 2){
									$inicial = '0000000'.$rowdoc['secuencialinicialA'];
								}else{
									if(strlen($rowdoc['secuencialinicialA']) == 3){
										$inicial = '000000'.$rowdoc['secuencialinicialA'];
									}else{
										if(strlen($rowdoc['secuencialinicialA']) == 4){
											$inicial = '00000'.$rowdoc['secuencialinicialA'];
										}else{
											if(strlen($rowdoc['secuencialinicialA']) == 5){
												$inicial = '0000'.$rowdoc['secuencialinicialA'];
											}else{
												if(strlen($rowdoc['secuencialinicialA']) == 6){
													$inicial = '000'.$rowdoc['secuencialinicialA'];
												}else{
													if(strlen($rowdoc['secuencialinicialA']) == 7){
														$inicial = '00'.$rowdoc['secuencialinicialA'];
													}else{
														if(strlen($rowdoc['secuencialinicialA']) == 8){
															$inicial = '0'.$rowdoc['secuencialinicialA'];
														}else{
															if(strlen($rowdoc['secuencialinicialA']) == 9){
																$inicial = $rowdoc['secuencialinicialA'];
															}
														}
													}
												}
											}
										}
									}
								}
							}
							$final = '';
							if(strlen($rowdoc['secuencialfinalA']) == 1){
								$final = '00000000'.$rowdoc['secuencialfinalA'];
							}else{
								if(strlen($rowdoc['secuencialfinalA']) == 2){
									$final = '0000000'.$rowdoc['secuencialfinalA'];
								}else{
									if(strlen($rowdoc['secuencialfinalA']) == 3){
										$final = '000000'.$rowdoc['secuencialfinalA'];
									}else{
										if(strlen($rowdoc['secuencialfinalA']) == 4){
											$final = '00000'.$rowdoc['secuencialfinalA'];
										}else{
											if(strlen($rowdoc['secuencialfinalA']) == 5){
												$final = '0000'.$rowdoc['secuencialfinalA'];
											}else{
												if(strlen($rowdoc['secuencialfinalA']) == 6){
													$final = '000'.$rowdoc['secuencialfinalA'];
												}else{
													if(strlen($rowdoc['secuencialfinalA']) == 7){
														$final = '00'.$rowdoc['secuencialfinalA'];
													}else{
														if(strlen($rowdoc['secuencialfinalA']) == 8){
															$final = '0'.$rowdoc['secuencialfinalA'];
														}else{
															if(strlen($rowdoc['secuencialfinalA']) == 9){
																$final = $rowdoc['secuencialfinalA'];
															}
														}
													}
												}
											}
										}
									}
								}
							}
							echo '
							<tr>
								<td>
									<p><strong>Serie</strong></p>
									<p><input type="text"  class="inputopcional" value="'.$rowdoc['codestablecimientoAHIS'].'-'.$rowdoc['serieemisionA'].'" size="10" id = "dod_serie"/></p>
								</td>
								<td>
									<p><strong>Tipo de Documento</strong></p>
									<p><input type="text"  class="inputopcional" value="'.$rowdoc['tipodocumentoA'].'" size="35" id = "tipodocumentoA"/></p>
								</td>
								<td>
									<p><strong>Secuencia Inicial</strong></p>
									<p><input type="text"  class="inputopcional" value="'.$inicial.'" size="10" id = "inicial"/></p>
								</td>
								<td>
									<p><strong>Secuencia Final</strong></p>
									<p><input type="text"  class="inputopcional" value="'.$final.'" size="10" id = "final"/></p>
								</td>
							</tr>';
						}
						echo '</table>
					</td>
				</tr>
			<tr style="text-align:center;">
				<td colspan="2">
					<!--<button type="button" class="btndegradate" id="volver" onclick="volver()">VOLVER</button>-->
					<button type="button" class="btndegradate" id="volver" onclick="actualizaAutorizacion('.$idAutorizacion.')">ACTUALIZAR</button>
				</td>
			</tr>';
?>