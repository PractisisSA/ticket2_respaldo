<?php 
	require_once('classes/private.db.php');
	include('../html2pdf/html2pdf/html2pdf.class.php');
	
	$gbd = new DBConn();

	$cliente = 4;
	$ncopias = 3;
	$info = 'Factura';
	$selectFAC = "SELECT razonsocialS, nombresS, direccionesS, telfijoS, telmovilS, rucS, nroautorizacionA, razonsocialTF, rucTF, nroautorizacionTF,
				telmovilTF, telfijoTF, secuencialinicialA, secuencialfinalA, nroestablecimientoS, fechaautorizacioA, fechacaducidadA, serieemisionA
				FROM autorizaciones JOIN Socio ON autorizaciones.idsocioA = Socio.idSocio
				JOIN ticktfacil ON autorizaciones.sucticketfacilS = ticktfacil.idticketFacil WHERE idAutorizacion = ? AND tipodocumentoA = ?";
	$sltf = $gbd -> prepare($selectFAC);
	$sltf -> execute(array($cliente,$info));
	$rowfac = $sltf -> fetch(PDO::FETCH_ASSOC);
	for($i = 1; $i <= 1; $i++){
				 for($j = 1; $j <= 2; $j++){
					 $content = '<page><table style="border:1px solid #000; border-radius:7px; border-collapse:separate;">
									<tr style="text-align:center;">
										<td>
											<p>'.$rowfac['razonsocialS'].'</p>
											<p>'.$rowfac['nombresS'].'</p>
											<p>'.$rowfac['direccionesS'].'</p>
											<p>'.$rowfac['telfijoS'].' - '.$rowfac['telmovilS'].'</p>
										</td>
										<td>
											<p>R.U.C.: '.$rowfac['rucS'].'</p>
											<p>NOTA DE DEBITO</p>
											<p>'.$rowfac['nroestablecimientoS'].' - 00'.$rowfac['serieemisionA'].'</p>';
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
											$content .= '<p>'.$serie.'</p>
											<p>Autorizaci&oacute;n Nro.: '.$rowfac['nroautorizacionA'].'</p>
										</td>
									</tr>
									<tr>
										<td style="border:1px solid #000; border-radius:7px; text-align:left; vertical-align:middle;">
											<p>Cliente:<input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											<p>Direcci&oacute;n: <input type="text" style="border:none; border-bottom:1px solid #000;" /></p>
											<p>R.U.C./C.I.: <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											<p>Tel&eacute;fono(m&oacute;vil/fijo): <input type="text" size="35" style="border:none; border-bottom:1px solid #000;" /></p>
											<p>Comprobante de venta modificado: </p>
											<p><strong>Tipo: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<strong>Nro: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
										</td>
										<td style="border:1px solid #000; border-radius:7px; text-align:center; vertical-align:middle;">
											<p>FECHA: </p>
											<p><input type="text" style="border:1px solid #000;"/>
												<input type="text" style="border:1px solid #000;"/>
												<input type="text" style="border:1px solid #000;"/></p>
											<p>DIA&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;MES&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;AÑO</p>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<table style="width:100%; border:1px solid #000; border-radius:7px; border-collapse:collapse;">
												<tr>
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
																	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	</td>
																	<td style="border:1px solid #000;"></td>
																	<td style="border:1px solid #000;"></td>
																</tr>';
												}
											$content .= '<tr>
															<td style="text-align:center;"></td>
															<td style="border-right:1px solid #000;">
															<strong>IVA 12%</strong>
															</td>
															<td style="border:1px solid #000;"></td>
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
											<p>'.$rowfac['razonsocialTF'].'&nbsp;&nbsp;R.U.C.: '.$rowfac['rucTF'].'&nbsp;&nbsp;Aut.: '.$rowfac['nroautorizacionTF'].'&nbsp;&nbsp;Telfs.: '.$rowfac['telfijoTF'].' - '.$rowfac['telmovilTF'].'</p>
											<p>Bloque del: '.$rowfac['secuencialinicialA'].' al '.$rowfac['secuencialfinalA'].'</p>
											<p>Fecha Autorizaci&oacute;n: '.$rowfac['fechaautorizacioA'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha Caducidad: '.$rowfac['fechacaducidadA'].'</p>';
											if($j == 1){
												$content .= '<p>ORIGINAL-ADQUIERIENTE</p>';
											}else{
												$copias = $j - 1;
												$content .= '<p>COPIA-'.$copias.'-EMISOR</p>';
											}
										$content .= '</td>
									</tr>
								</table></page>';
					$sum .= $content;
				}
			}
	echo $sum;
	
?>