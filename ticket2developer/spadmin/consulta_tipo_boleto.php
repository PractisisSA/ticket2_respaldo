	<?php
		include '../conexion.php';
		$id_tipo_boleto = $_REQUEST['id_tipo_boleto'];
	?>
	<table class='table table-border' id='tblEmpresario'>
		<tr>
			<td>
				Localidad
			</td>
			<td>
				Precio
			</td>
			<td>
				N° tickets entregados
			</td>
			<td>
				Valor
			</td>
			<td>
				N° tickets devueltos
			</td>
			<td>
				Valor
			</td>
			<td>
				tickets vendidos
			</td>
			<td>
				total vendido
			</td>
			<td>
				Opciones
			</td>
		</tr>
	<?php
		
		$sqlCo1 = 'select * from Localidad where idConc = "'.$_REQUEST['id'].'" ';
		$resCo1 = mysql_query($sqlCo1) or die (mysql_error());
		while($rowCo1 = mysql_fetch_array($resCo1)){
			
			if($id_tipo_boleto == 1){
					$precioBol = $rowCo1['doublePrecioL'];
				}
				if($id_tipo_boleto == 2){
					$precioBol = ($rowCo1['doublePrecioL'] * 0.5);
				}
				if($id_tipo_boleto == 3){
					$precioBol = 0;
				}
			
			//echo $precioBol."QUI";
			$sqlCor1 = 'select id , sum(num_bol) as num_bol , sum(numbol_devueltos) as numbol_devueltos from cortesias where id_con = "'.$_REQUEST['id'].'" and id_loc = "'.$rowCo1['idLocalidad'].'" and tipo = "2" and estado = "'.$id_tipo_boleto.'" ';
			//echo $sqlCor1."<br/>";
			
			$resCor1 = mysql_query($sqlCor1) or die (mysql_error());
			//echo mysql_num_rows($resCor1)."kdf";
			$rowCorEmp = mysql_fetch_array($resCor1);
			$num_bolEmp = $rowCorEmp['num_bol'];
			$numbol_devueltosEmp = $rowCorEmp['numbol_devueltos'];
			//echo $num_bolEmp."<<>>".$numbol_devueltosEmp;
			if(($num_bolEmp != '')){
				
				$sqlCor11 = 'select sum(num_bol) as num_bol , sum(numbol_devueltos) as numbol_devueltos from cortesias where id_con = "'.$_REQUEST['id'].'" and id_loc = "'.$rowCo1['idLocalidad'].'" and tipo = "2" and estado = "'.$id_tipo_boleto.'"';
				$resCor11 = mysql_query($sqlCor11) or die (mysql_error());
				
				$rowCor1 = mysql_fetch_array($resCor11);
				
				$bolVendidos = ($rowCor1['num_bol'] - $rowCor1['numbol_devueltos']);
				$sumbolVendidos += $bolVendidos;
				$totalVendidoEmp = ($bolVendidos * $precioBol);
				$sumtotalVendidoEmp += $totalVendidoEmp;
				
				$num_bol1 = $rowCor1['num_bol'];
				$sumnum_bol1 +=$num_bol1;//total tik entregados
				
				$bolXPrecio = ($rowCor1['num_bol'] * $precioBol);
				$sumbolXPrecio += $bolXPrecio;
				
				$bolXPrecioDevuelto = ($rowCor1['numbol_devueltos'] * $precioBol);
				$sumbolXPrecioDevuelto += $bolXPrecioDevuelto;
				
				$numbol_devueltos = $rowCor1['numbol_devueltos'];
				$sumnumbol_devueltos += $numbol_devueltos;
				
				$boton1 = '<button type="button" class="btn btn-danger">Creado</button>';
				$read1 = 'readonly';
				$disabled1 = 'disabled';
				$display = 'display:block;';
				$display2 = 'display:none;';
			}else{
				$num_bol1 = '';
				$numbol_devueltos = 0;
				$boton1 = '<button type="button" class="btn btn-success" onclick="grabarCortesia('.$_REQUEST['id'].' ,'.$rowCo1['idLocalidad'].' , 2)" >Grabar  <img src = "loader.gif" style="width:20px;display:none;"  id="loader'.$rowCo1['idLocalidad'].'" /></button>';
				$read1 = '';
				$disabled1 = '';
				$bolXPrecio=0;
				$bolXPrecioDevuelto=0;
				$bolVendidos = 0;
				$totalVendidoEmp=0;
				$display = 'display:none;';
				$display2 = 'display:block;';
			}
	?>
		<tr>
			<td>
				<?php echo $rowCo1['strDescripcionL'];?>
			</td>
			<td>
				<?php echo $rowCo1['doublePrecioL'];?>
			</td>
			<td align='center'>
				<table style = '<?php echo $display;?>'>
					<tr>
						<td>
							<input type = 'text' maxlength = '4' style='width:50px;' id = 'numBoletos<?php echo $rowCo1['idLocalidad'];?>' value = '<?php echo $num_bol1;?>' <?php echo $read1;?> <?php echo $disabled1;?> class = 'entero'/>
						</td>
						<td style = 'padding.left:4px;padding-right:4px;'>
							<button type="button" class="btn btn-warning btn-xs" onclick='agragaMas(<?php echo $_REQUEST['id'];?> , <?php echo $rowCo1['idLocalidad'];?> ,"<?php echo $rowCo1['strDescripcionL'];?>", 2)'>Agregar Más</button><br/><br/>
							<button type="button" class="btn btn-success btn-xs" onclick = 'verDetalleCortesia(<?php echo $_REQUEST['id'];?> , <?php echo $rowCo1['idLocalidad'];?>)'>Ver Detalle</button>
						</td>
					</tr>
				</table>
				<table style = '<?php echo $display2;?>'>
					<tr>
						<td>
							<input type = 'text' maxlength = '4' style='width:50px;' id = 'numBoletos2<?php echo $rowCo1['idLocalidad'];?>' value = '<?php echo $num_bol1;?>' <?php echo $read1;?> <?php echo $disabled1;?> class = 'entero'/>
						</td>
					</tr>
				</table>
			</td>
			<td align='center'>
				<?php echo number_format(($bolXPrecio),2);?>
			</td>
			<td align='center'>
				<input type = 'text' maxlength = '4' style='width:50px;' id = 'numbol_devueltos_<?php echo $rowCo1['idLocalidad'];?>' value = '<?php echo $numbol_devueltos;?>' class = 'entero'/>
				<br/><button type="button" class="btn btn-primary btn-xs" style = '<?php echo $display;?>' onclick = 'grabarDevueltos(<?php echo $rowCorEmp['id'];?> , <?php echo $rowCor1['numbol_devueltos'];?> , <?php echo $rowCo1['idLocalidad'];?>);'>Grabar</button>
			</td>
			<td align='center'>
				<?php echo number_format(($bolXPrecioDevuelto),2);?>
			</td>
			<td align='center'>
				<?php echo $bolVendidos;?>
			</td>
			<td align='center'>
				<?php echo number_format(($totalVendidoEmp),2);?>
			</td>
			<td>
				<?php echo $boton1;?>
			</td>
		</tr>
	<?php
		}
	?>
		<tr>
			<td>
				Total
			</td>
			<td>
				
			</td>
			<td align='center'>
				<?php echo $sumnum_bol1;?>
			</td>
			<td align='center'>
				<?php echo number_format(($sumbolXPrecio),2);?>
			</td>
			<td align='center'>
				<?php echo $sumnumbol_devueltos;?>
			</td>
			<td align='center'>
				<?php echo number_format(($sumbolXPrecioDevuelto),2);?>
			</td>
			<td align='center'>
				<?php echo $sumbolVendidos;?>
			</td>
			<td align='center'>
				<?php echo number_format(($sumtotalVendidoEmp),2);?>
			</td>
			<td>
				
			</td>
		</tr>
	</table>