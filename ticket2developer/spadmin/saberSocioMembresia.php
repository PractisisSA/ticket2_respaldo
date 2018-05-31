<?php

	include '../conexion.php';
	$socio_membresia = $_REQUEST['comboMembresiaSocio'];
	
	$sqlM1 = 'select count(id) as cuantos from socio_membresia where id_membresia = "'.$socio_membresia.'" order by id asc';
	$resM1 = mysql_query($sqlM1) or die (mysql_error());
	$rowM1 = mysql_fetch_array($resM1);
	
	
	$sqlM = 'select * from socio_membresia where id_membresia = "'.$socio_membresia.'" order by id asc';
	$resM = mysql_query($sqlM) or die (mysql_error());
	
	$sqlS = 'SELECT * FROM `membresia` WHERE `id` = "'.$socio_membresia.'" ORDER BY `id` DESC ';
	$resS = mysql_query($sqlS) or die (mysql_error());
	$rowS = mysql_fetch_array($resS);
	
	if($rowM1['cuantos']>0){
		
?>
			<tr style = 'background-color: #fff;color: #000'>
				<td >
					#
				</td>
				<td>
					<input type = 'text' value = '<?php echo $rowS['membresia']; ?>' disabled="disabled" readonly="readonly" />
					<input type = 'hidden' id = 'id_membresia<?php echo $socio_membresia; ?>_1_NU' value = '<?php echo $socio_membresia; ?>' />
				</td>
				<td>
					<input type = 'text' id = 'cedula_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'Ingrese cedula'  />
				</td>
				<td>
					<input type = 'text' id = 'nombre_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'Ingrese nombre' />
				</td>
				<td>
					<input type = 'text' id = 'apellido_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'Ingrese apellido' />
				</td>
				<td>
					<input disabled readonly type = 'text' id = 'valor_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'Ingrese Valor' value = '<?php echo $rowS['valor_mensual'];?>' />
				</td>
				<td>
					<select id = 'forma_pago_<?php echo $socio_membresia; ?>_1_NU' class = 'form-control' style = 'width:150px;' onchange = 'saberTipoPago(<?php echo $socio_membresia; ?> , 1 , "NU")'>
						<?php
							$sqlFP = 'select * from forma_pago order by id asc';
							$resFP = mysql_query($sqlFP) or die (mysql_error());
							while($rowFP = mysql_fetch_array($resFP)){
						?>	
								<option value = '<?php echo $rowFP['forma']?>'><?php echo $rowFP['forma']?></option>
						<?php
							}
						?>
					</select>
					<input onblur = 'validarCedula(<?php echo $socio_membresia; ?> , 1 , "NU")' value = '0' class = 'form-control' type = 'text' id = 'forma_pago_otro_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'Ingrese cedula' style = 'display:none;' />
				</td>
				<td>
					<input disabled readonly type = 'text' id = 'meses_mora_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'meses' value = '0'/>
				</td>
				<td>
					<input disabled readonly type = 'text' id = 't_deuda_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'T deuda' value = '0' />
				</td>
				<td style = 'text-align:center;'>
					<button type="button" id = 'boton_membresia_<?php echo $socio_membresia?>_1_NU' class="btn btn-success" onclick = 'configuraMembresiaSocios(<?php echo $socio_membresia?> , 1 , 1)'>
						<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
					</button>
				</td>
			</tr>
<?php
		while($rowM = mysql_fetch_array($resM)){
			$sqlCS = 'select count(id) as meses , sum(valor) as mora  from cartera_socios where cedula = "'.$rowM['cedula'].'" ';
			$resCS = mysql_query($sqlCS) or die (mysql_error());
			$rowCS = mysql_fetch_array($resCS);
			
			if($rowCS['mora'] != null){
				$mora = $rowCS['mora'];
			}else{
				$mora = 0;
			}
			if($rowM['estado'] == 1){
				$color = 'danger';
				$texto = 'glyphicon glyphicon-remove-circle';
				$titulo = 'Desea Desactivar al Socio : '.$rowM['apellido'].' '.$rowM['nombre'].' ? ';
			}else{
				$color = 'info';
				$texto = 'glyphicon glyphicon-ok-circle';
				$titulo = 'Desea Activar al Socio : '.$rowM['apellido'].' '.$rowM['nombre'].' ? ';
			}
			
?>
			<tr>
				<td>
					<input type = 'text' id = 'id_<?php echo $rowM['id']; ?>' value = '<?php echo $rowM['id']; ?>' style="width: 30px;text-align: center;" disabled="disabled" readonly="readonly" />
				</td>
				<td>
					<input type = 'text' value = '<?php echo $rowS['membresia']; ?>' disabled="disabled" readonly="readonly" />
					<input type = 'hidden' id = 'id_membresia<?php echo $rowM['id']; ?>_2_EX' value = '<?php echo $rowM['id_membresia']; ?>' />
				</td>
				<td>
					<input disabled readonly type = 'text' id = 'cedula_<?php echo $rowM['id']; ?>_2_EX' value = '<?php echo $rowM['cedula']; ?>' />
				</td>
				<td>
					<input type = 'text' id = 'nombre_<?php echo $rowM['id']; ?>_2_EX' value = '<?php echo $rowM['nombre']; ?>' />
				</td>
				<td>
					<input type = 'text' id = 'apellido_<?php echo $rowM['id']; ?>_2_EX' value = '<?php echo $rowM['apellido']; ?>' />
				</td>
				<td>
					<input readonly disabled type = 'text' id = 'valor_<?php echo $rowM['id']; ?>_2_EX' value = '<?php echo $rowS['valor_mensual']; ?>' />
				</td>
				
				<td>
					<select id = 'forma_pago_<?php echo $rowM['id']; ?>_2_EX' class = 'form-control' style = 'width:150px;' onchange = 'saberTipoPago(<?php echo $rowM['id']; ?> , 2 , "EX")'>
						<?php
							$sqlFP = 'select * from forma_pago order by id asc';
							$resFP = mysql_query($sqlFP) or die (mysql_error());
							while($rowFP = mysql_fetch_array($resFP)){
								if($rowM['forma_pago'] == $rowFP['forma']){
									$selectedd = 'selected';
									
								}else{
									$selectedd = '';
								}
								
								
						?>	
								<option value = '<?php echo $rowFP['forma']?>' <?php echo $selectedd; ?> ><?php echo $rowFP['forma']?></option>
						<?php
							}
							if($rowM['forma_pago'] == 'otro'){
								$visible = '';
							}else{
								$visible = 'none';
							}
							
						?>
					</select>
					<input onblur = 'validarCedula(<?php echo $rowM['id']; ?> , 2 , "EX")' class = 'form-control' type = 'text' id = 'forma_pago_otro_<?php echo $rowM['id']; ?>_2_EX' placeholder = 'Ingrese cedula' style = 'display:<?php echo $visible;?>;' value = '<?php echo $rowM['patrocinador']; ?>'/>
				</td>
				<td>
					<input disabled readonly type = 'text' id = 'meses_mora_<?php echo $rowM['id']; ?>_2_EX' value = '<?php echo $rowCS['meses']; ?>' />
				</td>
				<td>
					<input disabled readonly type = 'text' id = 't_deuda_<?php echo $rowM['id']; ?>_2_EX' value = '<?php echo $mora; ?>' />
				</td>
				<td>
					<table style = 'width:100%;'>
						<tr>
							<td>
								<button type="button" id = 'boton_membresia_<?php echo $socio_membresia?>_2' class="btn btn-warning" onclick = 'configuraMembresiaSocios(<?php echo $rowM['id']?> , 2 , <?php echo $rowM['estado'];?>)'>
									<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
								</button>
							</td>
							<td>
								<button title = '<?php echo $titulo;?>' type="button" id = 'boton_membresia_<?php echo $socio_membresia?>_3' class="btn btn-<?php echo $color;?>" onclick = 'configuraMembresiaSocios(<?php echo $rowM['id']?> , 3 , <?php echo $rowM['estado'];?>)'>
									<span class="<?php echo $texto?>" aria-hidden="true"></span>
								</button>
							</td>
						</tr>
					</table>
				</td>
			</tr>
<?php
		}
	}else{
?>
			<tr style = 'background-color: #fff;color: #000'>
				<td >
					#
				</td>
				<td>
					<input type = 'text' value = '<?php echo $rowS['membresia']; ?>' disabled="disabled" readonly="readonly" />
					<input type = 'hidden' id = 'id_membresia<?php echo $socio_membresia; ?>_1_NU' value = '<?php echo $socio_membresia; ?>' />
				</td>
				<td>
					<input type = 'text' id = 'cedula_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'Ingrese cedula'  />
				</td>
				<td>
					<input type = 'text' id = 'nombre_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'Ingrese nombre' />
				</td>
				<td>
					<input type = 'text' id = 'apellido_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'Ingrese apellido' />
				</td>
				<td>
					<input readonly disabled type = 'text' id = 'valor_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'Ingrese Valor' value = '<?php echo $rowS['valor_mensual'];?>' />
				</td>
				<td>
					<select id = 'forma_pago_<?php echo $socio_membresia; ?>_1_NU' class = 'form-control' style = 'width:150px;' onchange = 'saberTipoPago(<?php echo $socio_membresia; ?> , 1 , "NU")' >
						<?php
							$sqlFP = 'select * from forma_pago order by id asc';
							$resFP = mysql_query($sqlFP) or die (mysql_error());
							while($rowFP = mysql_fetch_array($resFP)){
						?>	
								<option value = '<?php echo $rowFP['forma']?>'><?php echo $rowFP['forma']?></option>
						<?php
							}
						?>
					</select>
					<input onblur = 'validarCedula(<?php echo $socio_membresia; ?> , 1 , "NU")' value = '0' class = 'form-control' type = 'text' id = 'forma_pago_otro_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'Ingrese cedula' style = 'display:none;' />
				</td>
				<td>
					<input disabled readonly type = 'text' id = 'meses_mora_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'meses' value = '0'/>
				</td>
				<td>
					<input disabled readonly type = 'text' id = 't_deuda_<?php echo $socio_membresia; ?>_1_NU' placeholder = 'T deuda' value = '0'/>
				</td>
				<td style = 'text-align:center;'>
					<button type="button" id = 'boton_membresia_<?php echo $socio_membresia?>_1' class="btn btn-success" onclick = 'configuraMembresiaSocios(<?php echo $socio_membresia?> , 1 , 1)'>
						<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
					</button>
				</td>
			</tr>
<?php
	}
?>