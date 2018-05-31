	<div class = 'col-md-12' style = 'color:#fff;'>
		<table class = 'table'>
			<tr>
				<th colspan = '9' style = 'text-align:center;'>
				</th>
			</tr>
			<tr>
				<th>#</th>
				<th>N° Boleto</th>
				<th>Precio</th>
				<th>Descuento</th>
				<th>Serie</th>
				<th>Localidad</th>
				<th>Asiento</th>
				<th>Cliente</th>
				<th>Cedula</th>
				
				
			</tr>
		<?php
			session_start();
			$idconciertotrans = $_REQUEST['idconciertotrans'];
			include '../../conexion.php';
			$sql = 'select td.* 
					from transaccion_distribuidor as td , Boleto as b
					where idconciertotrans = "'.$idconciertotrans.'" 
					and iddistribuidortrans = "'.$_SESSION['idDis'].'" 
					and b.idBoleto = td.numboletos
					and b.tipo_evento = 3
					order by idlocalidadtrans , idtrans ASC';
			// echo $sql;
			$res = mysql_query($sql) or die (mysql_error());
			$i=1;
			while($row = mysql_fetch_array($res)){
				$sqlB = 'select * from Boleto where idBoleto = "'.$row['numboletos'].'" ';
				$resB = mysql_query($sqlB) or die (mysql_error());
				$rowB = mysql_fetch_array($resB);
				
				$sqlB1 = 'SELECT * FROM `detalle_boleto` where idBoleto = "'.$row['numboletos'].'" ';
				$resB1 = mysql_query($sqlB1) or die (mysql_error());
				$rowB1 = mysql_fetch_array($resB1);
				
				$sqlL = 'select * from Localidad where idLocalidad = "'.$rowB['idLocB'].'" ';
				$resL = mysql_query($sqlL) or die (mysql_error());
				$rowL = mysql_fetch_array($resL);
				
				$sqlC = 'select * from Cliente where idCliente = "'.$rowB['idCli'].'" ';
				$resC = mysql_query($sqlC) or die (mysql_error());
				$rowC = mysql_fetch_array($resC);
				
				$sqlD = 'select * from descuentos where id = "'.$rowB['id_desc'].'" ';
				$resD = mysql_query($sqlD) or die (mysql_error());
				$rowD = mysql_fetch_array($resD);
				
				
				$sqlE = 'select * from Concierto where idConcierto = "'.$rowB['idCon'].'" ';
				$resE = mysql_query($sqlE) or die (mysql_error());
				$rowE = mysql_fetch_array($resE);
				
				$tiene_permisos = $rowE['tiene_permisos'];
				
				
				$sqlA = 'select * from autorizaciones where idAutorizacion = "'.$tiene_permisos.'" ';
				$resA = mysql_query($sqlA) or die (mysql_error());
				$rowA = mysql_fetch_array($resA);
				
				
				$sqlCd = 'select * from copias_cedula where id_bol = "'.$row['numboletos'].'" ';
				$resCd = mysql_query($sqlCd) or die (mysql_error());
				$rowCd = mysql_fetch_array($resCd);
				
				$codestablecimientoAHIS = $rowA['codestablecimientoAHIS'];
				$serieemisionA = $rowA['serieemisionA'];
				
				if($rowD['id'] == 0){
					$desc = 'Normal';
				}else{
					$desc = $rowD['nom'];
				}
				
		?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $codestablecimientoAHIS."-".$serieemisionA."-".$rowB['serie'];?></td>
				<td><?php echo "USD$  ".$rowB['valor'];?></td>
				<td><?php echo $desc;?></td>
				<td><?php echo $rowL['strDateStateL']." ".$rowB['serie_localidad'];?></td>
				<td><?php echo $rowL['strDescripcionL'];?></td>
				<td><?php echo $rowB1['asientos'];?></td>
				<td><?php echo utf8_decode($rowC['strNombresC']);?></td>
				<td><?php echo ($rowCd['cedula']);?></td>
				
			</tr>
		<?php
				$i++;
			}
			
			$sqlCl = 'select * from claves where id_con = "'.$idconciertotrans.'"';
			//echo $sqlCl;
			$resCl = mysql_query($sqlCl) or die (mysql_error());
			$rowCl = mysql_fetch_array($resCl);
			
			$clave = $rowCl['clave'];
			//echo $clave;
			echo "<input type = 'hidden' id = 'clave' value = '".$clave."' />";
			
		?>
		</table>
	</div>