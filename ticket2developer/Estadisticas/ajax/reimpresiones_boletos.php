	<div class = 'col-md-12' style = 'color:#fff;'>
		<table class = 'table'>
			<tr>
				<th colspan = '9' style = 'text-align:center;'>
					<button type="button" class="btn btn-success" onclick = 'muestra_modal()'>Reimprimir en lote</button>
				</th>
			</tr>
			<tr>
				<th>Codigo Barras</th>
				<th>Asiento</th>
				
				<th>Descuento</th>
				<th>Serie</th>
				<th>Localidad</th>
				<th>Cliente</th>
				<th>Hora Impresion</th>
				<th>Re-Imprimir</th>
				<th>Total-Re-Impresos</th>
				<th>
					Reimprimir en lote
					<input type = 'checkbox' id = 'chk_all' onclick="selectAll()" />
				</th>
			</tr>
		<?php
			session_start();
			$idconciertotrans = $_REQUEST['idconciertotrans'];
			include '../../conexion.php';
			
			$sqlU = 'select * from Usuario where strObsCreacion = "'.$_SESSION['idDis'].'" ';
			$resU = mysql_query($sqlU) or die (mysql_error());
			$rowU = mysql_fetch_array($resU);
			
			$sql = '
						select b.* , t.* 
						from Boleto as b , transaccion_distribuidor as t
						where idCon = "'.$idconciertotrans.'"
						and b.idBoleto = t.numboletos
						and b.id_usu_venta = "'.$rowU['idUsuario'].'"
						order by b.idBoleto , b.strBarcode ASC
					';
			 // echo "<div style = 'color:black;' >".$sql."</div>";
			 // exit;
			$res = mysql_query($sql) or die (mysql_error());
			$i=1;
			while($row = mysql_fetch_array($res)){
				// $sqlB = 'select * from Boleto where idBoleto = "'.$row['numboletos'].'" and idCon = "'.$idconciertotrans.'"';
				// $resB = mysql_query($sqlB) or die (mysql_error());
				// $rowB = mysql_fetch_array($resB);

				$sqlB1 = 'SELECT * FROM `detalle_boleto` where idBoleto = "'.$row['numboletos'].'" ';
				$resB1 = mysql_query($sqlB1) or die (mysql_error());
				$rowB1 = mysql_fetch_array($resB1);
				
				$sqlL = 'select * from Localidad where idLocalidad = "'.$row['idLocB'].'" ';
				$resL = mysql_query($sqlL) or die (mysql_error());
				$rowL = mysql_fetch_array($resL);
				
				$sqlC = 'select * from Cliente where idCliente = "'.$row['idCli'].'" ';
				$resC = mysql_query($sqlC) or die (mysql_error());
				$rowC = mysql_fetch_array($resC);
				
				$sqlD = 'select * from descuentos where id = "'.$row['id_desc'].'" ';
				$resD = mysql_query($sqlD) or die (mysql_error());
				$rowD = mysql_fetch_array($resD);
				
				
				$sqlE = 'select * from Concierto where idConcierto = "'.$row['idCon'].'" ';
				$resE = mysql_query($sqlE) or die (mysql_error());
				$rowE = mysql_fetch_array($resE);
				
				$tiene_permisos = $rowE['tiene_permisos'];
				
				
				$sqlA = 'select * from autorizaciones where idAutorizacion = "'.$tiene_permisos.'" ';
				$resA = mysql_query($sqlA) or die (mysql_error());
				$rowA = mysql_fetch_array($resA);
				
				$codestablecimientoAHIS = $rowA['codestablecimientoAHIS'];
				$serieemisionA = $rowA['serieemisionA'];
				
				if($rowD['id'] == 0){
					$desc = 'Normal';
				}else{
					$desc = $rowD['nom'];
				}
				
		?>
			<tr>
				<td>
					<?php 
						if($row['strBarcode'] == ''){
							$txtB = '<div style = "width:100%;color:red;text-align:center;font-weight:bold !important;" >SIN CODIGO</div>';
						}else{
							$txtB = $row['strBarcode'];
						}
						echo $txtB;
					?>
				</td>
				<td>
					<?php if ($rowB1['asientos'] == 'Asientos no Numerados') {
						echo "No numerado";
					}else{
						echo $rowB1['asientos'];
					}?>
					<br>
					<?php echo $codestablecimientoAHIS."-".$serieemisionA."-".$row['serie'];?>
				</td>
				
				
				<td>
					<?php 
						echo $desc."<br>";
						echo "USD$  ".$row['valor'];
					?>
				</td>
				<td><?php echo $rowL['strDateStateL']." ".$row['serie_localidad'];?></td>
				<td><?php echo $rowL['strDescripcionL'];?></td>
				<td><?php echo utf8_decode($rowC['strNombresC']);?></td>
				<td><?php echo $row['fecha'];?></td>
				<td><button type="button" class="btn btn-success" onclick='reimplrime_distribuidor(<?php echo $row['numboletos'];?>)'>
					Re-Imprimir [<?php echo $row['numboletos'];?>] <img src="https://www.mongrelpet.com/boot/images/loading_mini.gif" style="width:40px;display:none;" id="load_blog_<?php echo $row['idtrans'];?>">
				</button>
				</td>
				<td>
					<?php 
						$sqlRei = 'select count(id) as numImp from reimpresio_boleto where barcode = "'.$row['numboletos'].'" ';
						$resRei = mysql_query($sqlRei) or die (mysql_error());
						$rowRei = mysql_fetch_array($resRei);
						$numImp = $rowRei['numImp'];
						echo $numImp;
					?>
				</td>
				<td>
					<input type = 'checkbox' value = '<?php echo $row['numboletos'];?>' name2="<?php echo $codestablecimientoAHIS."-".$serieemisionA."-".$row['serie']; ?>" name = 'lote[]' class = 'lotes'/>
				</td>
			</tr>
		<?php
				$i++;
			}
			
			$sqlCl = 'select * from claves where id_con = "'.$idconciertotrans.'"';
			$resCl = mysql_query($sqlCl) or die (mysql_error());
			$rowCl = mysql_fetch_array($resCl);
			
			$clave = $rowCl['clave'];
			//echo $clave;
			echo "<input type = 'hidden' id = 'clave' value = '".$clave."' />";
			
		?>
		</table>
	</div>