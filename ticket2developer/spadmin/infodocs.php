<?php
	date_default_timezone_set('America/Guayaquil');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	ini_set("memory_limit","1G");
	set_time_limit (300);
	include("../controlusuarios/seguridadSA.php");
	require_once('../classes/private.db.php');
	include('../html2pdf/html2pdf/html2pdf.class.php');
	
	$gbd = new DBConn();
	
	$info = $_REQUEST['info'];
	$combo = $_REQUEST['combo'];
	$timeRightNow = time();
	$estadotrans = 'sin estado';
	$impresion = 'impreso';
	$idusuario = $_SESSION['iduser'];
	$estadoauto = 'Reimpresion';
	
	//Cargar informacion de las seceuncias para imprimir dependiendo de la autorizaciones
	if($combo == 3){
		$idAuto = $_REQUEST['autorizados'];
		$select = "SELECT secuencialinicialA, secuencialfinalA, estadoimpresionA, tipodocumentoA, facnegociablesA FROM autorizaciones WHERE idAutorizacion = ?";
		$slt = $gbd -> prepare($select);
		$slt -> execute(array($idAuto));
		
		$row = $slt -> fetch(PDO::FETCH_ASSOC);
		$tip_doc = $row['tipodocumentoA'];
		$fac_nego = $row['facnegociablesA'];
		if(($tip_doc == 'Factura') && ($fac_nego == 'no')){
			$info_doc = 1;
			$num_copias = '<tr style="text-align:center;"><td colspan="2"><p><strong>N&uacute;mero de Copias sin Derecho a Cr&eacute;dito Tributario</strong></p>
						<select class="inputlogin" id="numcopias">
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select></td></tr>';
		}else if($tip_doc == 'Nota de Venta'){
			$info_doc = 2;
			$num_copias = '<tr style="text-align:center;"><td colspan="2"><p><strong>N&uacute;mero de Copias sin Derecho a Cr&eacute;dito Tributario</strong></p>
						<select class="inputlogin" id="numcopias">
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select></td></tr>';
		}else if($tip_doc == 'Nota de Debito'){
			$info_doc = 3;
			$num_copias = '<tr style="text-align:center;"><td colspan="2"><p><strong>N&uacute;mero de Copias sin Derecho a Cr&eacute;dito Tributario</strong></p>
						<select class="inputlogin" id="numcopias">
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select></td></tr>';
		}else if($tip_doc == 'Nota de Credito'){
			$info_doc = 4;
			$num_copias = '<tr style="text-align:center;"><td colspan="2"><p><strong>N&uacute;mero de Copias sin Derecho a Cr&eacute;dito Tributario</strong></p>
						<select class="inputlogin" id="numcopias">
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select></td></tr>';
		}else if($tip_doc == 'Boleto'){
			$info_doc = 5;
			$num_copias = '';
		}else if($tip_doc == 'Liquidacion de Compras'){
			$info_doc = 6;
			$num_copias = '<tr style="text-align:center;"><td colspan="2"><p><strong>N&uacute;mero de Copias sin Derecho a Cr&eacute;dito Tributario</strong></p>
						<select class="inputlogin" id="numcopias">
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select></td></tr>';
		}else if($tip_doc == 'Guia de Remision'){
			$info_doc = 7;
			$num_copias = '';
		}else if($tip_doc == 'Comprobante Retencion'){
			$info_doc = 8;
			$num_copias = '';
		}else if($tip_doc == 'Taximetros y Registradoras'){
			$info_doc = 9;
			$num_copias = '';
		}else if($tip_doc == 'LC Bienes Muebles usados'){
			$info_doc = 10;
			$num_copias = '';
		}else if($tip_doc == 'LC Vehiculos usados'){
			$info_doc = 11;
			$num_copias = '';
		}else if($tip_doc == 'Acta entrega/recepcion'){
			$info_doc = 12;
			$num_copias = '';
		}else if(($tip_doc == 'Factura') && ($fac_nego == 'si')){
			$info_doc = 13;
			$num_copias = '<tr style="text-align:center;"><td colspan="2"><p><strong>N&uacute;mero de Copias sin Derecho a Cr&eacute;dito Tributario</strong></p>
						<select class="inputlogin" id="numcopias">
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select></td></tr>';
		}
		
		if($row['estadoimpresionA'] == 'Aun no se Imprime'){
			echo '<tr>
					<td colspan="2" style="text-align:center;">
						<p><strong>¿Confirme la secuencia a imprimir?</strong></p>
					</td>
				</tr>
				<tr>
					<td style="text-align:right;">
						<p><strong>Inicial:</strong><input type="text" id="inicialPrint" class="inputlogin" value="'.$row['secuencialinicialA'].'" /></p>
						<input type="hidden" id="inicialbase" value="'.$row['secuencialinicialA'].'" />
					</td>
					<td>
						<p><strong>Final:</strong><input type="text" id="finalPrint" class="inputlogin" value="'.$row['secuencialfinalA'].'" /></p>
						<input type="hidden" id="finalbase" value="'.$row['secuencialfinalA'].'" />
						<input type="hidden" id="formaimpresion" value="normal" />
					</td>
				</tr>
				'.$num_copias.'
				<tr style="text-align:center;">
					<td colspan="2">
						<button id="createFac" class="btnlink" onclick="crearFacs('.$info_doc.','.$idAuto.')" >Aceptar</button>&nbsp;&nbsp;&nbsp;&nbsp;
						<button id="cancelarCreacion" class="btnlink" onclick="cancelarCreacion()" >Cancelar</button>
					</td>
				</tr>';
		}else{
			$select = "SELECT secuinicialRS, secufinalRS, reimpresoRS FROM reimpresiones WHERE idautoRS = ? AND reimpresoRS = ?";
			$slt = $gbd -> prepare($select);
			$slt -> execute(array($idAuto,'no'));
			$row = $slt -> fetch(PDO::FETCH_ASSOC);
			$numregs = $slt -> rowCount();
			if($numregs > 0){
				echo '<tr>
						<td colspan="2" style="text-align:center;">
							<p><strong>¿Confirme la secuencia a imprimir?</strong></p>
						</td>
					</tr>
					<tr><td style="text-align:right;">
							<p><strong>Inicial:</strong><input type="text" id="inicialPrint" class="inputlogin" value="'.$row['secuinicialRS'].'" /></p>
							<input type="hidden" id="inicialbase" class="inputlogin" value="'.$row['secuinicialRS'].'" />
						</td>
						<td>
							<p><strong>Final:</strong><input type="text" id="finalPrint" class="inputlogin" value="'.$row['secufinalRS'].'" /></p>
							<input type="hidden" id="finalbase" class="inputlogin" value="'.$row['secufinalRS'].'" />
							<input type="hidden" id="formaimpresion" value="reimpresion" />
						</td>
					</tr>
					'.$num_copias.'
					<tr style="text-align:center;">
						<td colspan="2">
							<button id="createFac" class="btnlink" onclick="crearFacs('.$info_doc.','.$idAuto.')" >Aceptar</button>&nbsp;&nbsp;&nbsp;&nbsp;
							<button id="cancelarCreacion" class="btnlink" onclick="cancelarCreacion()" >Cancelar</button>
						</td>
					</tr>';
			}else{
				echo '<tr style="text-align:center;">
						<td colspan="2">
							<h3><strong>Ya se imprimio este DOCUMENTO</strong></h3><br>
							<strong>Si deseas reimprimir, dirigete a este módulo <a href="?modulo=reimpresion" style="text-decoration:none; color:#00ADEF;">REIMPRESIÓN</a></strong>
						</td>
					</tr>
					<tr style="text-align:center;">
						<td colspan="2">
							<button id="cancelarCreacion" class="btnlink" onclick="cancelarCreacion()" >Cerrar</button>
						</td>
					</tr>';
			}
		}
	}
	
	$sum = '';
	$sumanexo = '';
	//combo 2 para crear los documentos y mostrarlos en pantalla
	if($combo == 2){
		// $transincompleta = 'Transaccion Incompleta';
		//INFO = 1--IMPRESION DE FACTURAS
		$inicial = $_REQUEST['inicial'];
		$fin = $_REQUEST['fin'];
		$formaimpresion = $_REQUEST['formaimpresion'];
		$estadoimpresion = 'impreso';
		
		//Crear facturas(facturas normales)
		if($info == 1){
			$cliente = $_REQUEST['cliente'];
			$ncopias = $_REQUEST['ncopias'];
			$ncopias = $ncopias + 2;
			$Fac = 'Factura';
			$no = 'no';
			$selectFAC = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, facnegociablesA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ? AND facnegociablesA = ?";
			$sltf = $gbd -> prepare($selectFAC);
			$sltf -> execute(array($cliente,$Fac,$no));
			$rowfac = $sltf -> fetch(PDO::FETCH_ASSOC);
			
			$facnegociable = $rowfac['facnegociablesA'];
			if($inicial < $rowfac['secuencialinicialA']){
				echo 'error1';
				return false;
			}else if($fin > $rowfac['secuencialfinalA']){
				echo 'error2';
				return false;
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= $ncopias; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p><strong>'.$rowfac['nombrecomercialAHIS'].'</strong></p>
												<p>'.$rowfac['nombresS'].'</p>';
												if($rowfac['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowfac['dirmatrizAHIS'].'</p>';
												}else if($rowfac['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowfac['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowfac['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowfac['telfijoS'].' - '.$rowfac['telmovilS'].'</p>';
												if($rowfac['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowfac['actividadS'].'</p>';
												}
								$content .= '</td>
											<td>
												<p>R.U.C.: '.$rowfac['rucS'].'</p>
												<p>FACTURA</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>Nro. '.$rowfac['nroestablecimientoS'].' - '.$rowfac['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. SRI.: '.$rowfac['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Cliente:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cant.</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Unitario</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Total</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$content .= '<tr>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																	</tr>';
													}
												$content .= '<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL 0%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>DESCUENTO</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada</p>
																</td>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Recib&iacute; Conforme</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowfac['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowfac['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowfac['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowfac['telfijoTF'].' - '.$rowfac['telmovilTF'].'</p>
												<p>'.$rowfac['descripcionSE'].' - '.$rowfac['direccionSE'].'</p>
												<p>Bloque del: '.$rowfac['secuencialinicialA'].' al '.$rowfac['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowfac['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowfac['fechacaducidadA'].'</p>
												<p>'.$rowfac['tipocontribuyenteAHIS'].''; 
													if($rowfac['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowfac['nroespecialAHIS'];
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL-ADQUIERIENTE</p>';
												}else{
													if($j == 2){
														$copias = $j - 1;
														$content .= '<p>COPIA-'.$copias.'-EMISOR</p>';
													}else{
														if($j >= 3){
															$copias = $j - 1;
															$content .= '<p>COPIA-'.$copias.' "Copia sin derecho a Credito Tributario"</p>';
														}
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				$resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p><strong>'.$rowfac['nombrecomercialAHIS'].'</strong></p>
												<p>'.$rowfac['nombresS'].'</p>';
												if($rowfac['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowfac['dirmatrizAHIS'].'</p>';
												}else if($rowfac['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowfac['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowfac['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowfac['telfijoS'].' - '.$rowfac['telmovilS'].'</p>';
												if($rowfac['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowfac['actividadS'].'</p>';
												}
								$resultado .= '</td>
											<td>
												<p>R.U.C.: '.$rowfac['rucS'].'</p>
												<p>FACTURA</p>
												<p>Nro. '.$rowfac['nroestablecimientoS'].' - '.$rowfac['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. SRI.: '.$rowfac['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Cliente:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cant.</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Unitario</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Total</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$resultado .= '<tr>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																	</tr>';
													}
												$resultado .= '<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL 0%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>DESCUENTO</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada</p>
																</td>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Recib&iacute; Conforme</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowfac['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowfac['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowfac['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowfac['telfijoTF'].' - '.$rowfac['telmovilTF'].'</p>
												<p>'.$rowfac['descripcionSE'].' - '.$rowfac['direccionSE'].'</p>
												<p>Bloque del: '.$rowfac['secuencialinicialA'].' al '.$rowfac['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowfac['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowfac['fechacaducidadA'].'</p>
												<p>'.$rowfac['tipocontribuyenteAHIS'].''; 
													if($rowfac['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowfac['nroespecialAHIS'];
													}
												$resultado .= '</p><p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p></td>
										</tr>
									</table></page>';
				$sum .= $resultado;
			}
			
			// echo $sum;
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/FACTURA'.$timeRightNow.'.pdf','F');
				
				echo $timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		//crear factruras negociables
		if($info == 13){
			$cliente = $_REQUEST['cliente'];
			$ncopias = $_REQUEST['ncopias'];
			$ncopias = $ncopias + 2;
			$Fac = 'Factura';
			$si = 'si';
			$selectFAC = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, facnegociablesA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ? AND facnegociablesA = ?";
			$sltf = $gbd -> prepare($selectFAC);
			$sltf -> execute(array($cliente,$Fac,$si));
			$rowfac = $sltf -> fetch(PDO::FETCH_ASSOC);
			
			$facnegociable = $rowfac['facnegociablesA'];
			if($inicial < $rowfac['secuencialinicialA']){
				echo 'error1';
			}else if($fin > $rowfac['secuencialfinalA']){
				echo 'error2';
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= 3; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p><strong>'.$rowfac['nombrecomercialAHIS'].'</strong></p>
												<p>'.$rowfac['nombresS'].'</p>';
												if($rowfac['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowfac['dirmatrizAHIS'].'</p>';
												}else if($rowfac['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowfac['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowfac['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowfac['telfijoS'].' - '.$rowfac['telmovilS'].'</p>';
												if($rowfac['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowfac['actividadS'].'</p>';
												}
								$content .= '</td>
											<td>
												<p>R.U.C.: '.$rowfac['rucS'].'</p>
												<p>FACTURA COMERCIAL NEGOCIABLE</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>Nro. '.$rowfac['nroestablecimientoS'].' - '.$rowfac['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. SRI.: '.$rowfac['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Sr(es).:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cant.</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Unitario</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Total</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$content .= '<tr>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																	</tr>';
													}
												$content .= '<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL 0%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>DESCUENTO</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Emisor</p>
																</td>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Recib&iacute; Conforme</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	Nos obligamos al saneamiento
																</td>
																<td style="border-right:1px solid #000;">
																	<strong>Valor a Negociarse</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:8px;">
												Declaro que he(mos) recibido los bienes descritos en esta factura comercial negociable  a entera satisfacci&oacute;n.<br>
												Debo(emos) y pagare(mos) a ........ d&iacute;s vista, en el lugar que se me reconvenga, a la orden del emisor de esta factura, la suma de ................................. (n&uacute;meros)<br>
												............................................................................................................................ (letras), en ....... cuota(s) sucesiva(s), cuyo(s) monto(s) y vencimiento(s) est&aacute;(n)<br> especificado(s) en el cuadro que consta en este documento y que desde ya lo acepto(amos) como parte integrante de la presente obligaci&oacute;n. Si se dejare de pagar uno o<br> m&aacute;s cuotoas se dar&aacute;n por vencidas todas las cuotas pendientes y se deber&aacute; adem&aacute;s pagar el inter&eacute;s del ......... % anual, calculado desde la fecha de vencimiento<br> hasta el pago total de la obligaci&oacute;n, as&iacute; como todos los gastos judiciales, extrajudiciales, y honorarios profesionales que demande el cobro de la factura comercial negociable.<br>
												Sin protesto. Ex&iacute;mese de su presentaci&oacute;n para el pago y avisos por falta de pago.<br>
												<br>
												<br>
												En ............................. hoy, ........................ de ......... de ......... de 20.....<br>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:8px;">
												1.- Nombre o Raz&oacute;n Social aceptante:.............................................................................................................................<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.1.- N&uacute;mero de RUC:.............................................................................................................................<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.2.- Ciudad, direcci&oacute;n y tel&eacute;fono aceptante:.............................................................................................................................<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.3.- Lugar de pago (ciudad, direcci&oacute;n):.............................................................................................................................<br>
												2.- Nombres o Apellidos representante legal / delegado:.............................................................................................................................<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.1.- f.)aceptante / deudor (o delegado):.............................................................................................................................<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.2.- C.I aceptante:.............................................................................................................................
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												'.$rowfac['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowfac['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowfac['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowfac['telfijoTF'].' - '.$rowfac['telmovilTF'].'<br>
												<p>'.$rowfac['descripcionSE'].' - '.$rowfac['direccionSE'].'</p>
												Bloque del: '.$rowfac['secuencialinicialA'].' al '.$rowfac['secuencialfinalA'].'<br>
												Fecha Autorizaci&oacute;n: '.$rowfac['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowfac['fechacaducidadA'].'<br>
												<p>'.$rowfac['tipocontribuyenteAHIS'].''; 
													if($rowfac['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowfac['nroespecialAHIS'];
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL NO NEGOCIABLE</p>';
												}else{
													if($j == 2){
														$content .= '<p>2da copia NO NEGOCIABLE</p>';
													}else{
														if($j == 3){
															$content .= '<p>1era copia NEGOCIABLE</p><p>Copia sin derecho a Cr&eacute;dito Tributario</p>';
														}
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				$resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p><strong>'.$rowfac['nombrecomercialAHIS'].'</strong></p>
												<p>'.$rowfac['nombresS'].'</p>';
												if($rowfac['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowfac['dirmatrizAHIS'].'</p>';
												}else if($rowfac['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowfac['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowfac['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowfac['telfijoS'].' - '.$rowfac['telmovilS'].'</p>';
												if($rowfac['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowfac['actividadS'].'</p>';
												}
								$resultado .= '</td>
											<td>
												<p>R.U.C.: '.$rowfac['rucS'].'</p>
												<p>FACTURA COMERCIAL NEGOCIABLE</p>
												<p>Nro. '.$rowfac['nroestablecimientoS'].' - '.$rowfac['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. SRI.: '.$rowfac['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Sr(es).:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cant.</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Unitario</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Total</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$resultado .= '<tr>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																	</tr>';
													}
												$resultado .= '<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL 0%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>DESCUENTO</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>SUBTOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Emisor</p>
																</td>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Recib&iacute; Conforme</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	Nos obligamos al saneamiento
																</td>
																<td style="border-right:1px solid #000;">
																	<strong>Valor a Negociarse</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:8px;">
												Declaro que he(mos) recibido los bienes descritos en esta factura comercial negociable  a entera satisfacci&oacute;n.<br>
												Debo(emos) y pagare(mos) a ........ d&iacute;s vista, en el lugar que se me reconvenga, a la orden del emisor de esta factura, la suma de ................................. (n&uacute;meros)<br>
												............................................................................................................................ (letras), en ....... cuota(s) sucesiva(s), cuyo(s) monto(s) y vencimiento(s) est&aacute;(n)<br> especificado(s) en el cuadro que consta en este documento y que desde ya lo acepto(amos) como parte integrante de la presente obligaci&oacute;n. Si se dejare de pagar uno o<br> m&aacute;s cuotoas se dar&aacute;n por vencidas todas las cuotas pendientes y se deber&aacute; adem&aacute;s pagar el inter&eacute;s del ......... % anual, calculado desde la fecha de vencimiento<br> hasta el pago total de la obligaci&oacute;n, as&iacute; como todos los gastos judiciales, extrajudiciales, y honorarios profesionales que demande el cobro de la factura comercial negociable.<br>
												Sin protesto. Ex&iacute;mese de su presentaci&oacute;n para el pago y avisos por falta de pago.<br>
												<br>
												<br>
												En ............................. hoy, ........................ de ......... de ......... de 20.....<br>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:8px;">
												1.- Nombre o Raz&oacute;n Social aceptante:.............................................................................................................................<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.1.- N&uacute;mero de RUC:.............................................................................................................................<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.2.- Ciudad, direcci&oacute;n y tel&eacute;fono aceptante:.............................................................................................................................<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.3.- Lugar de pago (ciudad, direcci&oacute;n):.............................................................................................................................<br>
												2.- Nombres o Apellidos representante legal / delegado:.............................................................................................................................<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.1.- f.)aceptante / deudor (o delegado):.............................................................................................................................<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.2.- C.I aceptante:.............................................................................................................................
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												'.$rowfac['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowfac['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowfac['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowfac['telfijoTF'].' - '.$rowfac['telmovilTF'].'<br>
												<p>'.$rowfac['descripcionSE'].' - '.$rowfac['direccionSE'].'</p>
												Bloque del: '.$rowfac['secuencialinicialA'].' al '.$rowfac['secuencialfinalA'].'<br>
												Fecha Autorizaci&oacute;n: '.$rowfac['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowfac['fechacaducidadA'].'<br>
												<p>'.$rowfac['tipocontribuyenteAHIS'].''; 
													if($rowfac['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowfac['nroespecialAHIS'];
													}
												$resultado .= '</p><p>DOCUMENTO  DE RESPALDO PARA LA IMPRENTA(Archivo)</p></td>
										</tr>
									</table></page>';
				$sum .= $resultado;
				
				for($i = $inicial; $i <= $fin; $i++){
					$anexo = '<page>
								<table style="border:1px solid #000; border-radius:7px; border-collapse:collapse;">
									<tr style="text-align:center;">
										<td style="border:1px solid #000;">
											<strong>No.</strong>
										</td>
										<td style="border:1px solid #000;">
											<strong>Fecha de Pago<br>dd/mm//aaaa</strong>
										</td>
										<td style="border:1px solid #000;">
											<strong>Vencimiento<br>dd/mm/aaaa</strong>
										</td>
										<td style="border:1px solid #000;">
											<strong>Monto</strong>
										</td>
										<td style="border:1px solid #000;">
											<strong>Saldo Insoluto</strong>
										</td>
									</tr>';
									for($h = 1; $h <= 10; $h++){
										$anexo .= '<tr>
														<td style="border:1px solid #000;">
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														</td>
														<td style="border:1px solid #000;">
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														</td>
														<td style="border:1px solid #000;">
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														</td>
														<td style="border:1px solid #000;">
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														</td>
														<td style="border:1px solid #000;">
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														</td>
													</tr>';
									}
									$anexo .= '<br><br><br><br>';
										for($f = 1; $f <= 5; $f++){
											$anexo .= '<tr>
												<td colspan="5" style="border:1px solid #000;">
														<table style="border:1px solid #000; border-radius:7px; border-collapse:collapse;">
															<tr>
																<td>
																	<strong>Endoso a la orden de: </strong>
																</td>
																<td>
																	........................................
																</td>
																<td>
																	........................................
																</td>
																<td>
																	........................................
																</td>
															</tr>
															<tr>
																<td>
																	<strong>Valor Recibido: </strong>
																</td>
																<td>
																	........................................
																</td>
																<td>
																	........................................
																</td>
																<td>
																	........................................
																</td>
															</tr>
															<tr>
																<td>
																	<strong>F. endosante: </strong>
																</td>
																<td>
																	........................................
																</td>
																<td>
																	<strong>CI/RUC</strong>
																</td>
																<td>
																	........................................
																</td>
															</tr>
															<tr>
																<td>
																	<strong>Nombre o raz&oacute;n social endosante: </strong>
																</td>
																<td>
																	........................................
																</td>
																<td>
																	........................................
																</td>
																<td>
																	........................................
																</td>
															</tr>
															<tr>
																<td>
																	<strong>F. endosatario: </strong>
																</td>
																<td>
																	........................................
																</td>
																<td>
																	<strong>CI/RUC</strong>
																</td>
																<td>
																	........................................
																</td>
															</tr>
															<tr>
																<td>
																	<strong>Nombre o raz&oacute;n social endosatario: </strong>
																</td>
																<td>
																	........................................
																</td>
																<td>
																	........................................
																</td>
																<td>
																	........................................
																</td>
															</tr>
														</table>
												</td>
											</tr>';
										}
								$anexo .= '</table>
							</page>';
					$sumanexo .= $anexo;
				}
			}
			
			// echo $sum;
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/FACTURA'.$timeRightNow.'.pdf','F');
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sumanexo);
				$html2pdf->Output('documentos/ANEXOFACTURANEGO'.$timeRightNow.'.pdf','F');
				
				echo $timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		//Crear notas de venta
		if($info == 2){
			$cliente = $_REQUEST['cliente'];
			$ncopias = $_REQUEST['ncopias'];
			$ncopias = $ncopias + 2;
			$Fac = 'Nota de Venta';
			$selectNven = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
			$sltNven = $gbd -> prepare($selectNven);
			$sltNven -> execute(array($cliente,$Fac));
			$rowNven = $sltNven -> fetch(PDO::FETCH_ASSOC);
			
			if($inicial < $rowNven['secuencialinicialA']){
				echo 'error1';
				return false;
			}else if($fin > $rowNven['secuencialfinalA']){
				echo 'error2';
				return false;
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= $ncopias; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowNven['nombrecomercialAHIS'].'</p>
												<p>'.$rowNven['nombresS'].'</p>';
												if($rowNven['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNven['dirmatrizAHIS'].'</p>';
												}else if($rowNven['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNven['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowNven['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowNven['telfijoS'].' - '.$rowNven['telmovilS'].'</p>';
												if($rowNven['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowNven['actividadS'].'</p>';
												}
								$content .= '</td>
											<td>
												<p>R.U.C.: '.$rowNven['rucS'].'</p>
												<p>NOTA DE VENTA - RISE</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>'.$rowNven['nroestablecimientoS'].' - '.$rowNven['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. SRI.: '.$rowNven['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Cliente:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cant.</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Unitario</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Total</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$content .= '<tr>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																	</tr>';
													}
												$content .= '<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada</p>
																</td>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Recib&iacute; Conforme</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowNven['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowNven['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowNven['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowNven['telfijoTF'].' - '.$rowNven['telmovilTF'].'</p>
												<p>'.$rowNven['descripcionSE'].' - '.$rowNven['direccionSE'].'</p>
												<p>Bloque del: '.$rowNven['secuencialinicialA'].' al '.$rowNven['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowNven['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowNven['fechacaducidadA'].'</p>
												<p>'.$rowNven['tipocontribuyenteAHIS'].''; 
													if($rowNven['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowNven['nroespecialAHIS'].'';
													}else if($rowNven['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$content .= '- Monto m&aacute;ximo: $'.$rowNven['montodocS'].'';
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL-ADQUIERIENTE</p>';
												}else{
													if($j == 2){
														$copias = $j - 1;
														$content .= '<p>COPIA-'.$copias.'-EMISOR</p>';
													}else{
														if($j >= 3){
															$copias = $j - 1;
															$content .= '<p>COPIA-'.$copias.' "Copia sin derecho a Credito Tributario"</p>';
														}
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				$resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowNven['nombrecomercialAHIS'].'</p>
												<p>'.$rowNven['nombresS'].'</p>';
												if($rowNven['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNven['dirmatrizAHIS'].'</p>';
												}else if($rowNven['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNven['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowNven['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowNven['telfijoS'].' - '.$rowNven['telmovilS'].'</p>';
												if($rowNven['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowNven['actividadS'].'</p>';
												}
								$resultado .= '</td>
											<td>
												<p>R.U.C.: '.$rowNven['rucS'].'</p>
												<p>NOTA DE VENTA - RISE</p>
												<p>'.$rowNven['nroestablecimientoS'].' - '.$rowNven['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. SRI.: '.$rowNven['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Cliente:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cant.</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Unitario</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Total</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$resultado .= '<tr>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																	</tr>';
													}
												$resultado .= '<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada</p>
																</td>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Recib&iacute; Conforme</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowNven['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowNven['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowNven['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowNven['telfijoTF'].' - '.$rowNven['telmovilTF'].'</p>
												<p>'.$rowNven['descripcionSE'].' - '.$rowNven['direccionSE'].'</p>
												<p>Bloque del: '.$rowNven['secuencialinicialA'].' al '.$rowNven['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowNven['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowNven['fechacaducidadA'].'</p>
												<p>'.$rowNven['tipocontribuyenteAHIS'].''; 
													if($rowNven['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowNven['nroespecialAHIS'].'';
													}else if($rowNven['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$resultado .= '- Monto m&aacute;ximo: $'.$rowNven['montodocS'].'';
													}
												$resultado .= '</p>
												<p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p>
											</td>
										</tr>
									</table></page>';
				
				$sum .= $resultado;
			}
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/NotaVenta'.$timeRightNow.'.pdf','F');
				
				echo 'NotaVenta'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		//crear nota de debito info = 3
		if($info == 3){
			$cliente = $_REQUEST['cliente'];
			$ncopias = $_REQUEST['ncopias'];
			$ncopias = $ncopias + 2;
			$Fac = 'Nota de Debito';
			$selectNdeb = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
			$sltNdeb = $gbd -> prepare($selectNdeb);
			$sltNdeb -> execute(array($cliente,$Fac));
			$rowNdeb = $sltNdeb -> fetch(PDO::FETCH_ASSOC);
			
			if($inicial < $rowNdeb['secuencialinicialA']){
				echo 'error1';
				return false;
			}else if($fin > $rowNdeb['secuencialfinalA']){
				echo 'error2';
				return false;
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= $ncopias; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowNdeb['nombrecomercialAHIS'].'</p>
												<p>'.$rowNdeb['nombresS'].'</p>';
												if($rowNdeb['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNdeb['dirmatrizAHIS'].'</p>';
												}else if($rowNdeb['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNdeb['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowNdeb['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowNdeb['telfijoS'].' - '.$rowNdeb['telmovilS'].'</p>';
												if($rowNdeb['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowNdeb['actividadS'].'</p>';
												}
								$content .= '</td>
											<td>
												<p>R.U.C.: '.$rowNdeb['rucS'].'</p>
												<p>NOTA DE D&Eacute;BITO</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>Nro. '.$rowNdeb['nroestablecimientoS'].' - '.$rowNdeb['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. SRI.: '.$rowNdeb['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Cliente:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Comprobante de venta modificado: </p>
												<p><strong>Tipo: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<strong>Nro: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Raz&oacute;n de la modificaci&oacute;n</strong>
														</td>
														<td colspan="2" style="border:1px solid #000;">
															<strong>Valor de la modificaci&oacute;n</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$content .= '<tr>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td colspan="2" style="border:1px solid #000;"></td>
																	</tr>';
													}
												$content .= '<tr>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 12%</strong>
																</td>
																<td style="border:1px solid #000;">
																	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																</td>
															</tr>
															<tr>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 0%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowNdeb['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowNdeb['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowNdeb['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowNdeb['telfijoTF'].' - '.$rowNdeb['telmovilTF'].'</p>
												<p>'.$rowNdeb['descripcionSE'].' - '.$rowNdeb['direccionSE'].'</p>
												<p>Bloque del: '.$rowNdeb['secuencialinicialA'].' al '.$rowNdeb['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowNdeb['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowNdeb['fechacaducidadA'].'</p>
												<p>'.$rowNdeb['tipocontribuyenteAHIS'].''; 
													if($rowNdeb['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowNdeb['nroespecialAHIS'].'';
													}else if($rowNdeb['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$content .= '- Monto m&aacute;ximo: $'.$rowNdeb['montodocS'].'';
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL-ADQUIERIENTE</p>';
												}else{
													if($j == 2){
														$copias = $j - 1;
														$content .= '<p>COPIA-'.$copias.'-EMISOR</p>';
													}else{
														if($j >= 3){
															$copias = $j - 1;
															$content .= '<p>COPIA-'.$copias.' "Copia sin derecho a Credito Tributario"</p>';
														}
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				
				$resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowNdeb['nombrecomercialAHIS'].'</p>
												<p>'.$rowNdeb['nombresS'].'</p>';
												if($rowNdeb['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNdeb['dirmatrizAHIS'].'</p>';
												}else if($rowNdeb['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNdeb['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowNdeb['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowNdeb['telfijoS'].' - '.$rowNdeb['telmovilS'].'</p>';
												if($rowNdeb['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowNdeb['actividadS'].'</p>';
												}
								$resultado .= '</td>
											<td>
												<p>R.U.C.: '.$rowNdeb['rucS'].'</p>
												<p>NOTA DE DEBITO</p>
												<p>Nro. '.$rowNdeb['nroestablecimientoS'].' - '.$rowNdeb['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. SRI.: '.$rowNdeb['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Cliente:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Comprobante de venta modificado: </p>
												<p><strong>Tipo: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<strong>Nro: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Raz&oacute;n de la modificaci&oacute;n</strong>
														</td>
														<td colspan="2" style="border:1px solid #000;">
															<strong>Valor de la modificaci&oacute;n</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$resultado .= '<tr>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td colspan="2" style="border:1px solid #000;"></td>
																	</tr>';
													}
												$resultado .= '<tr>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 12%</strong>
																</td>
																<td style="border:1px solid #000;">
																	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																</td>
															</tr>
															<tr>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 0%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowNdeb['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowNdeb['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowNdeb['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowNdeb['telfijoTF'].' - '.$rowNdeb['telmovilTF'].'</p>
												<p>'.$rowNdeb['descripcionSE'].' - '.$rowNdeb['direccionSE'].'</p>
												<p>Bloque del: '.$rowNdeb['secuencialinicialA'].' al '.$rowNdeb['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowNdeb['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowNdeb['fechacaducidadA'].'</p>
												<p>'.$rowNdeb['tipocontribuyenteAHIS'].''; 
													if($rowNdeb['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowNdeb['nroespecialAHIS'].'';
													}else if($rowNdeb['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$resultado .= '- Monto m&aacute;ximo: $'.$rowNdeb['montodocS'].'';
													}
												$resultado .= '</p>
												<p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p></td>
										</tr>
									</table></page>';
				$sum .= $resultado;
			}
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/NotaDebito'.$timeRightNow.'.pdf','F');
				
				echo 'NotaDebito'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		//Crear notas de credito
		if($info == 4){
			$cliente = $_REQUEST['cliente'];
			$ncopias = $_REQUEST['ncopias'];
			$ncopias = $ncopias + 2;
			$Fac = 'Nota de Credito';
			$selectNcre = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
			$sltNcre = $gbd -> prepare($selectNcre);
			$sltNcre -> execute(array($cliente,$Fac));
			$rowNcre = $sltNcre -> fetch(PDO::FETCH_ASSOC);
			
			if($inicial < $rowNcre['secuencialinicialA']){
				echo 'error1';
				return false;
			}else if($fin > $rowNcre['secuencialfinalA']){
				echo 'error2';
				return false;
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= $ncopias; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowNcre['nombrecomercialAHIS'].'</p>
												<p>'.$rowNcre['nombresS'].'</p>';
												if($rowNcre['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNcre['dirmatrizAHIS'].'</p>';
												}else if($rowNcre['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNcre['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowNcre['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowNcre['telfijoS'].' - '.$rowNcre['telmovilS'].'</p>';
												if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowNcre['actividadS'].'</p>';
												}
								$content .= '</td>
											<td>
												<p>R.U.C.: '.$rowNcre['rucS'].'</p>
												<p>NOTA DE CR&Eacute;DITO</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>Nro. '.$rowNcre['nroestablecimientoS'].' - '.$rowNcre['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. SRI.: '.$rowNcre['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Cliente:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Comprobante de venta modificado: </p>
												<p><strong>Tipo: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<strong>Nro: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Raz&oacute;n de la modificaci&oacute;n</strong>
														</td>
														<td colspan="2" style="border:1px solid #000;">
															<strong>Valor de la modificaci&oacute;n</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$content .= '<tr>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td colspan="2" style="border:1px solid #000;"></td>
																	</tr>';
													}
												$content .= '<tr>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 12%</strong>
																</td>
																<td style="border:1px solid #000;">
																	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																</td>
															</tr>
															<tr>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 0%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowNcre['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowNcre['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowNcre['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowNcre['telfijoTF'].' - '.$rowNcre['telmovilTF'].'</p>
												<p>'.$rowNcre['descripcionSE'].' - '.$rowNcre['direccionSE'].'</p>
												<p>Bloque del: '.$rowNcre['secuencialinicialA'].' al '.$rowNcre['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowNcre['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowNcre['fechacaducidadA'].'</p>
												<p>'.$rowNcre['tipocontribuyenteAHIS'].''; 
													if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowNcre['nroespecialAHIS'].'';
													}else if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$content .= '- Monto m&aacute;ximo: $'.$rowNcre['montodocS'].'';
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL-ADQUIERIENTE</p>';
												}else{
													if($j == 2){
														$copias = $j - 1;
														$content .= '<p>COPIA-'.$copias.'-EMISOR</p>';
													}else{
														if($j >= 3){
															$copias = $j - 1;
															$content .= '<p>COPIA-'.$copias.' "Copia sin derecho a Credito Tributario"</p>';
														}
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				
				$resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowNcre['nombrecomercialAHIS'].'</p>
												<p>'.$rowNcre['nombresS'].'</p>';
												if($rowNcre['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNcre['dirmatrizAHIS'].'</p>';
												}else if($rowNcre['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNcre['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowNcre['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowNcre['telfijoS'].' - '.$rowNcre['telmovilS'].'</p>';
												if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowNcre['actividadS'].'</p>';
												}
								$resultado .= '</td>
											<td>
												<p>R.U.C.: '.$rowNcre['rucS'].'</p>
												<p>NOTA DE CREDITO</p>
												<p>Nro. '.$rowNcre['nroestablecimientoS'].' - '.$rowNcre['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. SRI.: '.$rowNcre['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Cliente:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Comprobante de venta modificado: </p>
												<p><strong>Tipo: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<strong>Nro: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Raz&oacute;n de la modificaci&oacute;n</strong>
														</td>
														<td colspan="2" style="border:1px solid #000;">
															<strong>Valor de la modificaci&oacute;n</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$resultado .= '<tr>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td colspan="2" style="border:1px solid #000;"></td>
																	</tr>';
													}
												$resultado .= '<tr>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 12%</strong>
																</td>
																<td style="border:1px solid #000;">
																	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																</td>
															</tr>
															<tr>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 0%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowNcre['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowNcre['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowNcre['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowNcre['telfijoTF'].' - '.$rowNcre['telmovilTF'].'</p>
												<p>'.$rowNcre['descripcionSE'].' - '.$rowNcre['direccionSE'].'</p>
												<p>Bloque del: '.$rowNcre['secuencialinicialA'].' al '.$rowNcre['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowNcre['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowNcre['fechacaducidadA'].'</p>
												<p>'.$rowNcre['tipocontribuyenteAHIS'].''; 
													if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowNcre['nroespecialAHIS'].'';
													}else if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$resultado .= '- Monto m&aacute;ximo: $'.$rowNcre['montodocS'].'';
													}
												$resultado .= '</p>
												<p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p></td>
										</tr>
									</table></page>';
				$sum .= $resultado;
			}
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/NotaCredito'.$timeRightNow.'.pdf','F');
				
				echo 'NotaCredito'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		//crear boletos
		if($info == 5){
			$cliente = $_REQUEST['cliente'];
			$Fac = 'Boleto';
			
			$selectNcre = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
			$sltNcre = $gbd -> prepare($selectNcre);
			$sltNcre -> execute(array($cliente,$Fac));
			$rowNcre = $sltNcre -> fetch(PDO::FETCH_ASSOC);
			
			
			
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				// $html2pdf = new HTML2PDF('P', 'A4', 'en');    
				// //$html2pdf->setModeDebug();
				// $html2pdf->setDefaultFont('Arial');
				// $html2pdf->writeHTML($sum);
				// $html2pdf->Output('documentos/Boleto'.$timeRightNow.'.pdf','F');
				
				// echo 'Boleto'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
			
			
			// if($inicial < $rowNcre['secuencialinicialA']){
				// echo 'error1';
				// return false;
			// }else if($fin > $rowNcre['secuencialfinalA']){
				// echo 'error2';
				// return false;
			// }else{
				// for($i = $inicial; $i <= $fin; $i++){
					// for($j = 1; $j <= 2; $j++){
						 // $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										// <tr style="text-align:center;">
											// <td>
												// <p>'.$rowNcre['nombrecomercialAHIS'].'</p>
												// <p>'.$rowNcre['nombresS'].'</p>';
												// if($rowNcre['imprimirparaA'] == 'm'){
													// $content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNcre['dirmatrizAHIS'].'</p>';
												// }else if($rowNcre['imprimirparaA'] == 's'){
													// $content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNcre['dirmatrizAHIS'].'</p>
													// <p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowNcre['direstablecimientoAHIS'].'</p>';
												// }
											// $content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowNcre['telfijoS'].' - '.$rowNcre['telmovilS'].'</p>';
												// if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													// $content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowNcre['actividadS'].'</p>';
												// }
								// $content .= '</td>
											// <td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												// <p>FECHA EVENTO: </p>
												// <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												// <p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
												// <p>HORA: </p>
												// <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												// <p>Hora&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;Minuto</p>
											// </td>
										// </tr>
										// <tr>
											// <td style="text-align:center; border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												// <p>R.U.C.: '.$rowNcre['rucS'].'</p>
												// <p>AUT. SRI.: '.$rowNcre['nroautorizacionA'].'</p>
												// <p>FECHA DE EMISI&Oacute;N: </p>
											// </td>
											// <td style="text-align:center;">
												// <p>BOLETO</p>';
												// if((strlen($i) == 1)){
													// $serie = '00000000'.$i;
												// }else{
													// if((strlen($i) == 2)){
														// $serie = '0000000'.$i;
													// }else{
														// if((strlen($i) == 3)){
															// $serie = '000000'.$i;
														// }else{
															// if((strlen($i) == 4)){
																// $serie = '00000'.$i;
															// }else{
																// if((strlen($i) == 5)){
																	// $serie = '0000'.$i;
																// }else{
																	// if((strlen($i) == 6)){
																		// $serie = '000'.$i;
																	// }else{
																		// if((strlen($i) == 7)){
																			// $serie = '00'.$i;
																		// }else{
																			// if((strlen($i) == 8)){
																				// $serie = '0'.$i;
																			// }else{
																				// if((strlen($i) == 9)){
																					// $serie = $i;
																				// }
																			// }
																		// }
																	// }
																// }
															// }
														// }
													// }
												// }
												// $content .= '<p>Nro.: '.$rowNcre['nroestablecimientoS'].' - '.$rowNcre['serieemisionA'].' - '.$serie.'</p>
											// </td>
										// </tr>
										// <tr>
											// <td colspan="2">
												// <table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													// <tr>
														// <td style="width:50px; heigth:10px; border:1px solid #000;">
															// <strong>Descripci&oacute;n</strong>
														// </td>
														// <td style="border:1px solid #000;">
															// <strong>Valor Total</strong>
														// </td>
													// </tr>
													// <tr>
														// <td style="border:1px solid #000;">
															// &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														// </td>
														// <td style="border:1px solid #000;"></td>
													// </tr>
												// </table>
											// </td>
										// </tr>
										// <tr>
											// <td>
												// <strong>SON:</strong>
											// </td>
											// <td style="text-align:right;">
												// <strong>DOLARES.</strong>
											// </td>
										// </tr>
										// <tr>
											// <td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												// <p>'.$rowNcre['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowNcre['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowNcre['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowNcre['telfijoTF'].' - '.$rowNcre['telmovilTF'].'</p>
												// <p>'.$rowNcre['descripcionSE'].' - '.$rowNcre['direccionSE'].'</p>
												// <p>Bloque del: '.$rowNcre['secuencialinicialA'].' al '.$rowNcre['secuencialfinalA'].'</p>
												// <p>Fecha Autorizaci&oacute;n: '.$rowNcre['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowNcre['fechacaducidadA'].'</p>
												// <p>'.$rowNcre['tipocontribuyenteAHIS'].''; 
													// if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														// $content .= '- '.$rowNcre['nroespecialAHIS'].'';
													// }else if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														// $content .= '- Monto m&aacute;ximo: $'.$rowNcre['montodocS'].'';
													// }
												// $content .= '</p>';
												// if($j == 1){
													// $content .= '<p>ORIGINAL - ADQUIRIENTE</p>';
												// }else{
													// if($j == 2){
														// $content .= '<p>COPIA - EMISOR</p>';
													// }
												// }
											// $content .= '</td>
										// </tr>
									// </table></page>';
						
						// $sum .= $content;
					// }
				// }
				// $resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										// <tr style="text-align:center;">
											// <td>
												// <p>'.$rowNcre['nombrecomercialAHIS'].'</p>
												// <p>'.$rowNcre['nombresS'].'</p>';
												// if($rowNcre['imprimirparaA'] == 'm'){
													// $resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNcre['dirmatrizAHIS'].'</p>';
												// }else if($rowNcre['imprimirparaA'] == 's'){
													// $resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowNcre['dirmatrizAHIS'].'</p>
													// <p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowNcre['direstablecimientoAHIS'].'</p>';
												// }
											// $resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowNcre['telfijoS'].' - '.$rowNcre['telmovilS'].'</p>';
												// if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													// $resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowNcre['actividadS'].'</p>';
												// }
								// $resultado .= '</td>
											// <td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												// <p>FECHA EVENTO: </p>
												// <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												// <p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
												// <p>HORA: </p>
												// <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												// <p>Hora&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;Minuto</p>
											// </td>
										// </tr>
										// <tr>
											// <td style="text-align:center; border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												// <p>R.U.C.: '.$rowNcre['rucS'].'</p>
												// <p>AUT. SRI.: '.$rowNcre['nroautorizacionA'].'</p>
												// <p>FECHA DE EMISI&Oacute;N: </p>
											// </td>
											// <td style="text-align:center;">
												// <p>BOLETO</p>
												// <p>Nro.: '.$rowNcre['nroestablecimientoS'].' - '.$rowNcre['serieemisionA'].' - '.$inicial.'</p>
											// </td>
										// </tr>
										// <tr>
											// <td colspan="2">
												// <table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													// <tr>
														// <td style="width:50px; heigth:10px; border:1px solid #000;">
															// <strong>Descripci&oacute;n</strong>
														// </td>
														// <td style="border:1px solid #000;">
															// <strong>Valor Total</strong>
														// </td>
													// </tr>
													// <tr>
														// <td style="border:1px solid #000;">
															// &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														// </td>
														// <td style="border:1px solid #000;"></td>
													// </tr>
												// </table>
											// </td>
										// </tr>
										// <tr>
											// <td>
												// <strong>SON:</strong>
											// </td>
											// <td style="text-align:right;">
												// <strong>DOLARES.</strong>
											// </td>
										// </tr>
										// <tr>
											// <td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												// <p>'.$rowNcre['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowNcre['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowNcre['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowNcre['telfijoTF'].' - '.$rowNcre['telmovilTF'].'</p>
												// <p>'.$rowNcre['descripcionSE'].' - '.$rowNcre['direccionSE'].'</p>
												// <p>Bloque del: '.$rowNcre['secuencialinicialA'].' al '.$rowNcre['secuencialfinalA'].'</p>
												// <p>Fecha Autorizaci&oacute;n: '.$rowNcre['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowNcre['fechacaducidadA'].'</p>
												// <p>'.$rowNcre['tipocontribuyenteAHIS'].''; 
													// if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														// $resultado .= '- '.$rowNcre['nroespecialAHIS'].'';
													// }else if($rowNcre['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														// $resultado .= '- Monto m&aacute;ximo: $'.$rowNcre['montodocS'].'';
													// }
												// $resultado .= '</p>
												// <p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p>
											// </td>
										// </tr>
									// </table></page>';
				// $sum .= $resultado;
			// }
			
			// echo $sum;
			
		}
		
		//crear liquidaciones de compra
		if($info == 6){
			$cliente = $_REQUEST['cliente'];
			$ncopias = $_REQUEST['ncopias'];
			$ncopias = $ncopias + 2;
			$Fac = 'Liquidacion de Compras';
			$selectLiq = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
			$sltLiq = $gbd -> prepare($selectLiq);
			$sltLiq -> execute(array($cliente,$Fac));
			$rowLiq = $sltLiq -> fetch(PDO::FETCH_ASSOC);
			
			if($inicial < $rowLiq['secuencialinicialA']){
				echo 'error1';
				return false;
			}else if($fin > $rowLiq['secuencialfinalA']){
				echo 'error2';
				return false;
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= $ncopias; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$content .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>LIQUIDACI&Oacute;N DE COMPRAS DE BIENES</p>
												<p>Y PRESTACI&Oacute;N DE SERVICIOS</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. SRI.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Sr.(es):<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Lugar de la Transacci&oacute;n: <input type="text" size="25" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cant.</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Unitario</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Total</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$content .= '<tr>
																		<td style="border:1px solid #000;">
																		</td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																	</tr>';
													}
												$content .= '<tr>
																<td></td>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>Subtotal 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>Subtotal 0%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>Subtotal</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$content .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL-ADQUIERIENTE</p>';
												}else{
													if($j == 2){
														$copias = $j - 1;
														$content .= '<p>COPIA-'.$copias.'-VENDEDOR</p>';
													}else{
														if($j >= 3){
															$copias = $j - 1;
															$content .= '<p>COPIA-'.$copias.' "Copia sin derecho a Credito Tributario"</p>';
														}
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				
				$resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$resultado .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>LIQUIDACI&Oacute;N DE COMPRAS DE BIENES</p>
												<p>Y PRESTACI&Oacute;N DE SERVICIOS</p>
												<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. SRI.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Sr.(es):<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Lugar de la Transacci&oacute;n: <input type="text" size="25" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cant.</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Unitario</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor Total</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 10; $x++){
														$resultado .= '<tr>
																		<td style="border:1px solid #000;">
																		</td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																	</tr>';
													}
												$resultado .= '<tr>
																<td></td>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>Subtotal 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>Subtotal 0%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>Subtotal</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td style="text-align:center;"></td>
																<td style="border-right:1px solid #000;">
																<strong>IVA 12%</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
															<tr>
																<td></td>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada</p>
																</td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$resultado .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$resultado .= '</p>
												<p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p></td>
										</tr>
									</table></page>';
				$sum .= $resultado;
			}
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/Liquidacion'.$timeRightNow.'.pdf','F');
				
				echo 'Liquidacion'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		//creacion de las guias de remision
		if($info == 7){
			$cliente = $_REQUEST['cliente'];
			$Fac = 'Guia de Remision';
			$selectLiq = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
			$sltLiq = $gbd -> prepare($selectLiq);
			$sltLiq -> execute(array($cliente,$Fac));
			$rowLiq = $sltLiq -> fetch(PDO::FETCH_ASSOC);
			
			if($inicial < $rowLiq['secuencialinicialA']){
				echo 'error1';
				return false;
			}else if($fin > $rowLiq['secuencialfinalA']){
				echo 'error2';
				return false;
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= 3; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$content .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>GUIA DE REMISI&Oacute;N</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. SRI.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Fecha Inicio de Traslado:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>Fecha Fin de Traslado:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<p><strong>DATOS DE COMPROBANTE DE VENTA</strong></p>
											</td>
										</tr>
										<tr>
											<td>
												<p>Tipo:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>No. Autorizaci&oacute;n:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td>
												<p>Fecha Emisi&oacute;n:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>No. del Comprobante:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td>
												<p>N&uacute;mero de declaraci&oacute;n aduanera:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Motivo de Traslado:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td>
												<p>Punto de Partida:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Destino:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td>
												<p><strong>Identificaci&oacute;n del Destinario</strong></p>
												<p>R.U.C/C.I.:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Raz&oacute;n Social:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td>
												<p><strong>Identificaci&oacute;n del Chofer</strong></p>
												<p>R.U.C/C.I.:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Raz&oacute;n Social:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Placa:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cant.</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 5; $x++){
														$content .= '<tr>
																		<td style="border:1px solid #000;">
																		</td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																	</tr>';
													}
												$content .= '</table>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$content .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL-ADQUIERIENTE</p>';
												}else{
													if($j == 2){
														$copias = $j - 1;
														$content .= '<p>COPIA-'.$copias.'-EMISOR</p>';
													}else{
														if($j == 3){
															$copias = $j - 1;
															$content .= '<p>COPIA-'.$copias.'-SRI</p>';
														}
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				$resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$resultado .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>GUIA DE REMISI&Oacute;N</p>
												<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. SRI.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Fecha Inicio de Traslado:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>Fecha Fin de Traslado:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<p><strong>DATOS DE COMPROBANTE DE VENTA</strong></p>
											</td>
										</tr>
										<tr>
											<td>
												<p>Tipo:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>No. Autorizaci&oacute;n:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td>
												<p>Fecha Emisi&oacute;n:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>No. del Comprobante:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td>
												<p>N&uacute;mero de declaraci&oacute;n aduanera:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Motivo de Traslado:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td>
												<p>Punto de Partida:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Destino:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td>
												<p><strong>Identificaci&oacute;n del Destinario</strong></p>
												<p>R.U.C/C.I.:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Raz&oacute;n Social:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td>
												<p><strong>Identificaci&oacute;n del Chofer</strong></p>
												<p>R.U.C/C.I.:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Raz&oacute;n Social:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Placa:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cant.</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 5; $x++){
														$resultado .= '<tr>
																		<td style="border:1px solid #000;">
																		</td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																	</tr>';
													}
												$resultado .= '</table>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$resultado .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$resultado .= '</p>
												<p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p>
											</td>
										</tr>
									</table></page>';
				$sum .= $resultado;
			}
			// echo $sum;
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/remision'.$timeRightNow.'.pdf','F');
				
				echo 'remision'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		//crear comprobantes de retencion
		if($info == 8){
			$cliente = $_REQUEST['cliente'];
			$Fac = 'Comprobante Retencion';
			$selectLiq = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
			$sltLiq = $gbd -> prepare($selectLiq);
			$sltLiq -> execute(array($cliente,$Fac));
			$rowLiq = $sltLiq -> fetch(PDO::FETCH_ASSOC);
			
			if($inicial < $rowLiq['secuencialinicialA']){
				echo 'error1';
				return false;
			}else if($fin > $rowLiq['secuencialfinalA']){
				echo 'error2';
				return false;
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= 2; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$content .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>COMPROBANTE DE RETENCI&Oacute;N</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. NRO.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td>
												<p>Sr(es).:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>R.U.C/C.I.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
											</td>
											<td>
												<p>Fecha Emisi&oacute;n:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>Tipo Comprobante de Venta:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>Nro. de Comprobante de Venta:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Ejercicio Fiscal</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Base imponible para la retenci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Impuesto</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>% de Retenci&oacute;n</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Valor Retenido</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 5; $x++){
														$content .= '<tr>
																		<td style="border:1px solid #000;">
																		</td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;">
																		</td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																	</tr>';
													}
												$content .= '<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma del Agente de Retenci&oacute;n</p>
																</td>
																<td>
																</td>
																<td>
																</td>
																<td>
																</td>
																<td>
																</td>
															</tr>
														</table>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$content .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL-SUJETO PASIVO RETENIDO</p>';
												}else{
													if($j == 2){
														$copias = $j - 1;
														$content .= '<p>COPIA-'.$copias.'-AGENTE DE RETENCI&Oacute;N</p>';
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				 $resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$resultado .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>COMPROBANTE DE RETENCI&Oacute;N</p>
												<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. NRO.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td>
												<p>Sr(es).:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>R.U.C/C.I.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
											</td>
											<td>
												<p>Fecha Emisi&oacute;n:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>Tipo Comprobante de Venta:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>Nro. de Comprobante de Venta:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Ejercicio Fiscal</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Base imponible para la retenci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Impuesto</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>% de Retenci&oacute;n</strong>
														</td>
														<td style="width:50px; heigth:10px; border:1px solid #000;">
															<strong>Valor Retenido</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 5; $x++){
														$resultado .= '<tr>
																		<td style="border:1px solid #000;">
																		</td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;">
																		</td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																	</tr>';
													}
												$resultado .= '<tr>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma del Agente de Retenci&oacute;n</p>
																</td>
																<td>
																</td>
																<td>
																</td>
																<td>
																</td>
																<td>
																</td>
															</tr>
														</table>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$resultado .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$resultado .= '</p>
												<p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p>
											</td>
										</tr>
									</table></page>';
				$sum .= $resultado;
			}
			
			// echo $sum;
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/retencion'.$timeRightNow.'.pdf','F');
				
				echo 'retencion'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		//crear tiquetes
		if($info == 9){
			$cliente = $_REQUEST['cliente'];
			$Fac = 'Taximetros y Registradoras';
			$selectLiq = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
			$sltLiq = $gbd -> prepare($selectLiq);
			$sltLiq -> execute(array($cliente,$Fac));
			$rowLiq = $sltLiq -> fetch(PDO::FETCH_ASSOC);
			
			if($inicial < $rowLiq['secuencialinicialA']){
				echo 'error1';
				return false;
			}else if($fin > $rowLiq['secuencialfinalA']){
				echo 'error2';
				return false;
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= 2; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
									$content .= '<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>TIQUETE</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. SRI.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td>
												<p>Sr(es).:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C/C.I.:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Fecha Emisi&oacute;n:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td>
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 5; $x++){
														$content .= '<tr>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;">
																		</td>
																	</tr>';
													}
												$content .= '</table>
											</td>
										</tr>
										<tr>
											<td style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$content .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL-ADQUIERIENTE</p>';
												}else{
													if($j == 2){
														$copias = $j - 1;
														$content .= '<p>COPIA-'.$copias.'-EMISOR</p>';
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				$resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
									$resultado .= '<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>TIQUETE</p>
												<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. SRI.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td>
												<p>Sr(es).:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C/C.I.:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Fecha Emisi&oacute;n:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td>
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Descripci&oacute;n</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 5; $x++){
														$resultado .= '<tr>
																		<td style="border:1px solid #000;">
																		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</td>
																		<td style="border:1px solid #000;">
																		</td>
																	</tr>';
													}
												$resultado .= '</table>
											</td>
										</tr>
										<tr>
											<td style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$resultado .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$resultado .= '</p>
												<p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p>
											</td>
										</tr>
									</table></page>';
				$sum .= $resultado;
			}
			
			// echo $sum;
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/tiquete'.$timeRightNow.'.pdf','F');
				
				echo 'tiquete'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		//crear liquidaciones de compra de muebles usados
		if($info == 10){
			$cliente = $_REQUEST['cliente'];
			$Fac = 'LC Bienes Muebles usados';
			$selectLiq = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
			$sltLiq = $gbd -> prepare($selectLiq);
			$sltLiq -> execute(array($cliente,$Fac));
			$rowLiq = $sltLiq -> fetch(PDO::FETCH_ASSOC);
			
			if($inicial < $rowLiq['secuencialinicialA']){
				echo 'error1';
				return false;
			}else if($fin > $rowLiq['secuencialfinalA']){
				echo 'error2';
				return false;
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= 2; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$content .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>LIQUIDACI&Oacute;N DE COMPRAS DE BIENES</p>
												<p>MUEBLES USADOS</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. SRI.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center;">
												<strong>DATOS DEL VENDEDOR</strong>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Sr.(es):<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Bien</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Marca</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Modelo</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Nro. de serie / IMEI</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Color</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Estado</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Accesorios Extras</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 5; $x++){
														$content .= '<tr>
																		<td style="border:1px solid #000;">&nbsp;</td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																	</tr>';
													}
												$content .= '
															<tr>
																<td></td>
																<td></td>
																<td></td>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recib&iacute; Conforme</p>
																</td>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$content .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL-VENDEDOR</p>';
												}else{
													if($j == 2){
														$copias = $j - 1;
														$content .= '<p>COPIA-'.$copias.'-EMISOR</p>';
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				$resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$resultado .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>LIQUIDACI&Oacute;N DE COMPRAS DE BIENES</p>
												<p>MUEBLES USADOS</p>
												<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. SRI.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center;">
												<strong>DATOS DEL VENDEDOR</strong>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Sr.(es):<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>Bien</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Marca</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Modelo</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Nro. de serie / IMEI</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Color</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Estado</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Accesorios Extras</strong>
														</td>
														<td style="border:1px solid #000;">
															<strong>Valor</strong>
														</td>
													</tr>';
													for($x = 1; $x <= 5; $x++){
														$resultado .= '<tr>
																		<td style="border:1px solid #000;">&nbsp;</td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																		<td style="border:1px solid #000;"></td>
																	</tr>';
													}
												$resultado .= '
															<tr>
																<td></td>
																<td></td>
																<td></td>
																<td style="text-align:center;">
																	<p><input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
																	<p>Firma Autorizada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recib&iacute; Conforme</p>
																</td>
																<td></td>
																<td></td>
																<td style="border-right:1px solid #000;">
																<strong>VALOR TOTAL</strong>
																</td>
																<td style="border:1px solid #000;"></td>
															</tr>
													</table>
											</td>
										</tr>
										<tr>
											<td>
												<strong>SON:</strong>
											</td>
											<td style="text-align:right;">
												<strong>DOLARES.</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$resultado .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$resultado .= '</p>
												<p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p>
											</td>
										</tr>
									</table></page>';
				$sum .= $resultado;
			}
			
			// echo $sum;
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/Liquidacion'.$timeRightNow.'.pdf','F');
				
				echo 'Liquidacion'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		//liquidacion de compras de vehiculos usados
		if($info == 11){
			$cliente = $_REQUEST['cliente'];
			$Fac = 'LC Vehiculos usados';
			$selectLiq = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
			$sltLiq = $gbd -> prepare($selectLiq);
			$sltLiq -> execute(array($cliente,$Fac));
			$rowLiq = $sltLiq -> fetch(PDO::FETCH_ASSOC);
			
			if($inicial < $rowLiq['secuencialinicialA']){
				echo 'error1';
				return false;
			}else if($fin > $rowLiq['secuencialfinalA']){
				echo 'error2';
				return false;
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= 2; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$content .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>LIQUIDACI&Oacute;N DE COMPRA</p>
												<p>DE VEH&Iacute;CULOS USADOS</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. SRI.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center;">
												<strong>DATOS DEL VENDEDOR</strong>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Sr.(es):<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Profesi&oacute;n o Actividad Economica.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
												<p>Tel&eacute;fono: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Correo: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de Placa o RAMV/CPN</strong>
														</td>
														<td style="border:1px solid #000;">
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Marca:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Modelo:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Tipo:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>A&ntilde;o de fabricaci&oacute;n:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Pa&iacute;s de origen:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Color:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cilindraje:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>tipo de combustibe:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de motor:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de chasis:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Estado y Condiciones:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Precio de venta:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Forma de Pago:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Lugar y Fecha:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td style="text-align:center;">
												<br>
												<br>
												<br>
												<br>
												<strong>Firma Adquiriente</strong>
											</td>
											<td style="text-align:center;">
												<br>
												<br>
												<br>
												<br>
												<strong>Firma Vendedor</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$content .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL-ADQUIERIENTE</p>';
												}else{
													if($j == 2){
														$copias = $j - 1;
														$content .= '<p>COPIA-'.$copias.'-VENDEDOR</p>';
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				 $resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$resultado .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>LIQUIDACI&Oacute;N DE COMPRA</p>
												<p>DE VEH&Iacute;CULOS USADOS</p>
												<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. SRI.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center;">
												<strong>DATOS DEL VENDEDOR</strong>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Sr.(es):<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Profesi&oacute;n o Actividad Economica.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
												<p>Tel&eacute;fono: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Correo: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de Placa o RAMV/CPN</strong>
														</td>
														<td style="border:1px solid #000;">
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Marca:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Modelo:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Tipo:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>A&ntilde;o de fabricaci&oacute;n:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Pa&iacute;s de origen:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Color:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cilindraje:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>tipo de combustibe:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de motor:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de chasis:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Estado y Condiciones:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Precio de venta:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Forma de Pago:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Lugar y Fecha:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td style="text-align:center;">
												<br>
												<br>
												<br>
												<br>
												<strong>Firma Adquiriente</strong>
											</td>
											<td style="text-align:center;">
												<br>
												<br>
												<br>
												<br>
												<strong>Firma Vendedor</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$resultado .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$resultado .= '</p>
												<p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p>
											</td>
										</tr>
									</table></page>';
				$sum .= $resultado;
			}
			// echo $sum;
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/vehiculos'.$timeRightNow.'.pdf','F');
				
				echo 'vehiculos'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
		
		//creacion acta recepcion de vahiculos usados
		if($info == 12){
			$cliente = $_REQUEST['cliente'];
			$Fac = 'Acta entrega/recepcion';
			$selectLiq = "SELECT nombrecomercialAHIS, nombresS, dirmatrizAHIS, direstablecimientoAHIS, telfijoS, telmovilS, rucS, nroautorizacionA, nombresTF, rucTF, nroautorizacionTF, telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA, montodocS, actividadS, tipocontribuyenteAHIS,nroespecialAHIS, imprimirparaA, direccionSE, descripcionSE FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio JOIN sucursal_empresa ON autorizaciones.sucticketfacilS = sucursal_empresa.idSE JOIN ticktfacil ON sucursal_empresa.idempresaSE = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
			$sltLiq = $gbd -> prepare($selectLiq);
			$sltLiq -> execute(array($cliente,$Fac));
			$rowLiq = $sltLiq -> fetch(PDO::FETCH_ASSOC);
			
			if($inicial < $rowLiq['secuencialinicialA']){
				echo 'error1';
				return false;
			}else if($fin > $rowLiq['secuencialfinalA']){
				echo 'error2';
				return false;
			}else{
				for($i = $inicial; $i <= $fin; $i++){
					for($j = 1; $j <= 2; $j++){
						 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$content.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$content.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$content .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$content .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>ACTA ENTREGA RECEPCI&Oacute;N DE</p>
												<p>VEH&Iacute;CULOS USADOS</p>';
												if((strlen($i) == 1)){
													$serie = '00000000'.$i;
												}else{
													if((strlen($i) == 2)){
														$serie = '0000000'.$i;
													}else{
														if((strlen($i) == 3)){
															$serie = '000000'.$i;
														}else{
															if((strlen($i) == 4)){
																$serie = '00000'.$i;
															}else{
																if((strlen($i) == 5)){
																	$serie = '0000'.$i;
																}else{
																	if((strlen($i) == 6)){
																		$serie = '000'.$i;
																	}else{
																		if((strlen($i) == 7)){
																			$serie = '00'.$i;
																		}else{
																			if((strlen($i) == 8)){
																				$serie = '0'.$i;
																			}else{
																				if((strlen($i) == 9)){
																					$serie = $i;
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
												$content .= '<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$serie.'</p>
												<p>AUT. NRO.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Sr.(es):<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Profesi&oacute;n o Actividad Economica.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
												<p>Tel&eacute;fono: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Correo: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr style="text-align:center;">
											<td colspan="2">
												<strong>Descripci&oacute;n del bien usado</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de Placa o RAMV/CPN</strong>
														</td>
														<td style="border:1px solid #000;">
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Marca:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Modelo:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Tipo:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>A&ntilde;o de fabricaci&oacute;n:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Pa&iacute;s de origen:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Color:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cilindraje:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>tipo de combustibe:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de motor:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de chasis:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Estado y Condiciones:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Precio de venta:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Forma de Pago:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Lugar y Fecha:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Observaciones:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td style="text-align:center;">
												<br>
												<br>
												<br>
												<br>
												<strong>Firma Comitente</strong>
											</td>
											<td style="text-align:center;">
												<br>
												<br>
												<br>
												<br>
												<strong>Firma Comisionista</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$content .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$content .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$content .= '</p>';
												if($j == 1){
													$content .= '<p>ORIGINAL-COMITENTE</p>';
												}else{
													if($j == 2){
														$copias = $j - 1;
														$content .= '<p>COPIA-'.$copias.'-COMISIONISTA</p>';
													}
												}
											$content .= '</td>
										</tr>
									</table></page>';
						$sum .= $content;
					}
				}
				$resultado = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
										<tr style="text-align:center;">
											<td>
												<p>'.$rowLiq['nombrecomercialAHIS'].'</p>
												<p>'.$rowLiq['nombresS'].'</p>';
												if($rowLiq['imprimirparaA'] == 'm'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>';
												}else if($rowLiq['imprimirparaA'] == 's'){
													$resultado.= '<p><strong>Direcci&oacute;n Matriz: </strong>'.$rowLiq['dirmatrizAHIS'].'</p>
													<p><strong>Direcci&oacute;n Sucursal: </strong>'.$rowLiq['direstablecimientoAHIS'].'</p>';
												}
											$resultado.= '<p><strong>Tel&eacute;fonos: </strong>'.$rowLiq['telfijoS'].' - '.$rowLiq['telmovilS'].'</p>';
												if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
													$resultado .= '<p><strong>Actividad Econ&oacute;mica: </strong>'.$rowLiq['actividadS'].'</p>';
												}
								$resultado .= '</td>
											<td>
												<p>R.U.C.: '.$rowLiq['rucS'].'</p>
												<p>ACTA ENTREGA RECEPCI&Oacute;N DE</p>
												<p>VEH&Iacute;CULOS USADOS</p>
												<p>Nro. '.$rowLiq['nroestablecimientoS'].' - '.$rowLiq['serieemisionA'].' - '.$inicial.'</p>
												<p>AUT. NRO.: '.$rowLiq['nroautorizacionA'].'</p>
											</td>
										</tr>
										<tr>
											<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
												<p>Sr.(es):<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Profesi&oacute;n o Actividad Economica.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
											<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
												<p>FECHA DE EMISI&Oacute;N: </p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
												<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
												<p>Tel&eacute;fono: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
												<p>Correo: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											</td>
										</tr>
										<tr style="text-align:center;">
											<td colspan="2">
												<strong>Descripci&oacute;n del bien usado</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de Placa o RAMV/CPN</strong>
														</td>
														<td style="border:1px solid #000;">
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Marca:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Modelo:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Tipo:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>A&ntilde;o de fabricaci&oacute;n:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Pa&iacute;s de origen:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Color:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Cilindraje:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>tipo de combustibe:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de motor:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>N&uacute;mero de chasis:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Estado y Condiciones:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Precio de venta:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Forma de Pago:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Lugar y Fecha:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
													<tr>
														<td style="border:1px solid #000;">
															<strong>Observaciones:</strong>
														</td>
														<td style="border:1px solid #000;">
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td style="text-align:center;">
												<br>
												<br>
												<br>
												<br>
												<strong>Firma Comitente</strong>
											</td>
											<td style="text-align:center;">
												<br>
												<br>
												<br>
												<br>
												<strong>Firma Comisionista</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="font-size:7px; text-align:center; border:1px solid #000; border-radius:7px;">
												<p>'.$rowLiq['nombresTF'].'&nbsp;&nbsp;R.U.C.: '.$rowLiq['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowLiq['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowLiq['telfijoTF'].' - '.$rowLiq['telmovilTF'].'</p>
												<p>'.$rowLiq['descripcionSE'].' - '.$rowLiq['direccionSE'].'</p>
												<p>Bloque del: '.$rowLiq['secuencialinicialA'].' al '.$rowLiq['secuencialfinalA'].'</p>
												<p>Fecha Autorizaci&oacute;n: '.$rowLiq['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowLiq['fechacaducidadA'].'</p>
												<p>'.$rowLiq['tipocontribuyenteAHIS'].''; 
													if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente Especial'){
														$resultado .= '- '.$rowLiq['nroespecialAHIS'].'';
													}else if($rowLiq['tipocontribuyenteAHIS'] == 'Contribuyente RISE'){
														$resultado .= '- Monto m&aacute;ximo: $'.$rowLiq['montodocS'].'';
													}
												$resultado .= '</p>
												<p>DOCUMENTO DE RESPALDO PARA LA IMPRENTA(Archivo)</p>
											</td>
										</tr>
									</table></page>';
				$sum .= $resultado;
			}
			
			// echo $sum;
			try{
				if($formaimpresion == 'normal'){
					$update = "UPDATE autorizaciones SET inicialimpresoA = ?, finalimpresoA = ?, estadoimpresionA = ? WHERE idAutorizacion = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array($inicial,$fin,$estadoimpresion,$cliente));
				}else if($formaimpresion == 'reimpresion'){
					$update = "UPDATE reimpresiones SET reimpresoRS = ? WHERE idautoRS = ?";
					$upd = $gbd -> prepare($update);
					$upd -> execute(array('ok',$cliente));
				}
				
				$html2pdf = new HTML2PDF('P', 'A4', 'en');    
				//$html2pdf->setModeDebug();
				$html2pdf->setDefaultFont('Arial');
				$html2pdf->writeHTML($sum);
				$html2pdf->Output('documentos/vehiculos'.$timeRightNow.'.pdf','F');
				
				echo 'vehiculos'.$timeRightNow;
				
			}
			catch(HTML2PDF_exception $e){
				echo 'my errors '.$e;
				exit;
			}
		}
	}
?>