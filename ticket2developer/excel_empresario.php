<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<?php
	
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
		include 'conexion.php';
		$no_vendidos = 0;
		$_REQUEST['id_concierto'];
		
		$sqlImp = 'select * from impuestos where id_con = "'.$_REQUEST['id_concierto'].'" ';
		$resImp = mysql_query($sqlImp) or die(mysql_error());
		$rowImp = mysql_fetch_array($resImp);
		
		$sqlCo = 'select * from Concierto where idConcierto = "'.$_REQUEST['id_concierto'].'" ';
		$resCo = mysql_query($sqlCo) or die(mysql_error());
		$rowCo = mysql_fetch_array($resCo);
?>
	<style>
		.botonimagen{
			background-image:url(http://siga.rinconacademico.com/excel.jpg);
			background-repeat:no-repeat;
			height:50px;
			width:100px;
			background-position:center;
			cursor:pointer;
		}
	</style>
	<center>
		<input type="button" onclick="tableToExcel('testTable1', 'Reporte General ')" class="botonimagen" title='Descargar Reporte Excel' value=''/>
	</center>
		<table class = 'table' id='testTable1'>
			
			<tr>
				<th colspan = '5' style = 'text-align:center;text-transform:uppercase;background-color:#000;color:#00AEEF;font-size:22px;' >
					Acta Entrega Recepción tickets empresario para el evento de : <?php echo $rowCo['strEvento'];?>
				</th>
			</tr>
			<tr><td colspan = '5' style = 'border:1px dotted #ccc;' ></td></tr>
			<tr><td colspan = '5' style = 'border:1px dotted #ccc;' ></td></tr>
			<tr>
				<th>Localidad</th>
				<th>Serie Loc</th>
				<th>Cantidad</th>
				<th>Precio</th>
				<th>Total</th>
				
			</tr>
	<?php
			$sqlCo1 = 'select * from Localidad where idConc = "'.$_REQUEST['id_concierto'].'" order by idLocalidad DESC';
			$resCo1 = mysql_query($sqlCo1) or die (mysql_error());
			while($rowCo1 = mysql_fetch_array($resCo1)){
				
			$sql = 'select count(idBoleto) as vendidos from Boleto where idCon = "'.$_REQUEST['id_concierto'].'" and idLocB = "'.$rowCo1['idLocalidad'].'" ';
			$res = mysql_query($sql) or die (mysql_error());
			$row = mysql_fetch_array($res);
			
			$sqlB1 = 'select max(CAST(serie_localidad AS INTEGER)) as serieB from Boleto where idCon = "'.$_REQUEST['id_concierto'].'"  and idLocB = "'.$rowCo1['idLocalidad'].'" order by idBoleto DESC limit 1';
			$resB1 = mysql_query($sqlB1) or die (mysql_error());
			$rowB1 = mysql_fetch_array($resB1);
			
			
			$sqlB2 = 'select min(CAST(serie_localidad AS INTEGER)) as serieA from Boleto where idCon = "'.$_REQUEST['id_concierto'].'"  and idLocB = "'.$rowCo1['idLocalidad'].'" order by idBoleto DESC limit 1';
			$resB2 = mysql_query($sqlB2) or die (mysql_error());
			$rowB2 = mysql_fetch_array($resB2);
			
	?>
			<tr>
				<td><?php echo $rowCo1['strDescripcionL'];?></td>
				<td>
					<?php 
						echo $rowCo1['strDateStateL']."_".$rowB2['serieA']."-".$rowB1['serieB'];
					?>
				</td>
				
				<td>
					<?php 
						echo $row['vendidos'];
						$sumVendidos += $row['vendidos'];
					?>
				</td>
				<td>
					<?php
						$precioNo = $rowCo1['doublePrecioL'];
						echo $precioNo;
						$sumPrecioNo += $precioNo; 
					?>
				</td>
				<td>
					<?php
						$montoNo = ($precioNo * $row['vendidos']);
						echo number_format(($montoNo),2);
						$sumMontoNo += $montoNo;
					?>
				</td>
				
			</tr>
	<?php
			}
	?>
	
	<tr><td colspan = '5' style = 'border:1px dotted #ccc;' ></td></tr>
	
	
			<tr>
				<th>Total</th>
				<th></th>
				<th><?php echo ($sumVendidos+$sumVendidosTer+$sumVendidosNi);?></th>
				<th><?php echo ($sumIngresados+$sumIngresadosTer+$sumIngresadosNi);?></th>
				<th><?php echo number_format(($sumMontoNo),2);?></th>
			</tr>
			<tr>
				<td colspan = '2'>
					Entregado Por : <br>
					TICKETfACIL<br>
					Paul Estrella.
				</td>
				<td></td>
				<td colspan = '2' >
					Recibido Por : <br><br>
					___________________
				</td>
			</tr>
			<tr><td colspan = '5' style = 'border:1px dotted #ccc;' ></td></tr>
			<tr><td colspan = '5' style = 'border:1px dotted #ccc;' ></td></tr>
			<tr>
				<th colspan = '1' style = 'text-align:center;text-transform:uppercase;background-color:#000;color:#00AEEF;font-size:22px;height:50px;' >
					
				</th>
				<th colspan = '2' style = 'text-align:center;text-transform:uppercase;background-color:#000;color:#00AEEF;font-size:22px;height:50px;' >
					<center><img src = 'http://ticketfacil.ec/ticket2/gfx/logo_exc.png' /></center>
				</th>
				<th colspan = '2' style = 'text-align:center;text-transform:uppercase;background-color:#000;color:#00AEEF;font-size:22px;height:50px;' >
					
				</th>
			</tr>
			
			
		</table>
	<script>
		var tableToExcel = (function() {
			var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8" ><link href="css/style.css" media="screen" rel="StyleSheet" type="text/css"/><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
			return function(table, name) {
				if (!table.nodeType) table = document.getElementById(table)
				var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
				window.location.href = uri + base64(format(template, ctx))
			}
		})()
	</script>