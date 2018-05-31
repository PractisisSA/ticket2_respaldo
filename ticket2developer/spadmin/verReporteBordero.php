<?php
	session_start();
	// echo "perfil : ".$_SESSION['autentica'];
	if($_SESSION['autentica'] == 'Municipio'){
		$display = 'display:none;';
	}else{
		$display = '';
	}
	include '../conexion.php';
	$idcon = $_REQUEST['id'];
	
	$sqlI = 'select * from impuestos where id_con = "'.$idcon.'" ';
	$resI = mysql_query($sqlI) or die (mysql_error());
	$rowI = mysql_fetch_array($resI);
	
	
	$sqlCo = 'select strEvento from Concierto where idConcierto = "'.$idcon.'" ';
	$resCo = mysql_query($sqlCo) or die (mysql_error());
	$rowCo = mysql_fetch_array($resCo);
	
	$sql = 'SELECT * FROM `Localidad` WHERE `idConc` = "'.$idcon.'" ORDER BY `Localidad`.`strDescripcionL` ASC ';
	$res = mysql_query($sql) or die (mysql_error());
	
	
	if($_SESSION['perfil'] == 'SP' || $_SESSION['perfil'] == 'Socio'){
		
		if($_REQUEST['pventas'] == ''){
			$query = '';
			// echo $_REQUEST['pventas'];
		}else{
			$sqlU = 'SELECT * FROM `Usuario` WHERE `strObsCreacion` = "'.$_REQUEST['pventas'].'" ORDER BY `strObsCreacion` DESC';
			// echo $sqlU."<br>";
			$resU = mysql_query($sqlU) or die (mysql_error());
			$rowU = mysql_fetch_array($resU);
			$idDist = $rowU['idUsuario'];
			// $filtroDist = 'and id_usu_venta = "'.$idDist.'"';
			
			$query = 'and id_usu_venta = "'.$idDist.'" ';
			// echo $_REQUEST['pventas'];
		}
	}elseif($_SESSION['perfil'] == 'Distribuidor'){
		$query = 'and id_usu_venta = "'.$_SESSION['iduser'].'" ';
	}else{
		$query = '';
	}
?>
	<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>-->
	<style>
		td{
			text-align:left;
		}
	</style>
	<center> 
		<button type="button" class="btn btn-default" onclick="tableToExcel('desglose_sri', 'REPORTE SRI DESGLOSADO')">EXCEL</button>
	</center>
	<table class = 'table' id = "desglose_sri">
		<tr>
			<th colspan = '9' >
				Detalle Ventas Evento : <?php echo $rowCo['strEvento']."   [".$idcon."]";?>
			</th>
		</tr>
		<tr>
			<th>
				Localidades
			</th>
			<th>
				Autorizados
			</th>
			
			<th>
				No Vendidos 
			</th>
			
			<th style = '<?php echo $display;?>'>
				Impresos
			</th>
			
			<th>
				Vendidos
			</th>
			<th>
				Precio
			</th>
			
			<th>
				Total
			</th>
			<th>
				Admision
			</th>
			<th>
				Impuesto
			</th>
			
			
		</tr>
<?php
	$suma_vendidos_normal = 0;
	
	$sumadescuento = 0;
	
	$sumadescuento1 = 0;
	
	
	$suma_precio_normal = 0;
	$suma_precio_descuento = 0;
	$suma_precio_cortesia = 0;
	
	$suma_valor_admision_normales = 0;
	$suma_valor_admision_descuento = 0;
	$suma_valor_admision_cortesias = 0;
	
	
	
	
	
	
	$suma_total_admision_normales = 0;
	$suma_total_admision_descuento = 0;
	$suma_total_admision_cortesia = 0;
	
	$suma_autorizados = 0;
	$suma_autorizados_cortesias = 0;
	
	
	$suma_impresos_normales = 0;
	$suma_impresos_descuento = 0;
	$suma_impresos_cortesia = 0;
	while($row = mysql_fetch_array($res)){
		// $sqlO = 'SELECT count(id) as cuantos_bloquedos FROM `ocupadas` WHERE `status` = 3 AND `local` = "'.$row['idLocalidad'].'" ORDER BY `status` DESC ';
		// $resO = mysql_query($sqlO) or die (mysql_error());
		// $rowO = mysql_fetch_array($resO);
		
		
		$sqlOc = '	SELECT 1 as posicion, `row` , `col` , (`status`) , (`local`) , (`concierto`) 
					FROM `ocupadas`
					WHERE `local` = "'.$row['idLocalidad'].'" 
					and status = "3"
					group by `row` , `col` , `status` , `local` , `concierto` 
					ORDER BY `col` ASC
				';
		// echo $sqlOc."<br><br>";
		$resOc = mysql_query($sqlOc) or die (mysql_error());
		$sumaBloqueos = 0;
		while($rowOc = mysql_fetch_array($resOc)){
			$sumaBloqueos += $rowOc['posicion'];
		}
		
		
		
		$sqlLC1 = 'SELECT * FROM `localidad_cortesias` where id_loc = "'.$row['idLocalidad'].'" ';
		$resLC1 = mysql_query($sqlLC1) or die (mysql_error());
		$rowLC1 = mysql_fetch_array($resLC1);
		
		
		// $autorizados = ($row['strCapacidadL'] - $rowO['cuantos_bloquedos']);
		$autorizados = ($row['strCapacidadL'] - $sumaBloqueos - $rowLC1['cant']);
		
		$sqlB = 'SELECT count(idBoleto) as vendidos_normal FROM `Boleto` WHERE `idCon` = "'.$idcon.'" AND `idLocB` = "'.$row['idLocalidad'].'" AND `tercera` = 0 '.$query.' ORDER BY `idLocB` DESC ';
		$resB = mysql_query($sqlB) or die (mysql_error());
		$rowB = mysql_fetch_array($resB);
		
		
		$sqlDD = 'SELECT * FROM `descuentos` WHERE `idloc` = "'.$row['idLocalidad'].'" and `nom` LIKE "%cortes%" ORDER BY `nom` DESC ';
		$resDD = mysql_query($sqlDD) or die (mysql_error());
		$rowDD = mysql_fetch_array($resDD);
		
		$sqlB2 = 'SELECT count(idBoleto) as vendidos_todos FROM `Boleto` WHERE  `idLocB` = "'.$row['idLocalidad'].'" and tercera = 0 and id_desc != "'.$rowDD['id'].'" '.$query.' ORDER BY `idLocB` DESC ';
		$resB2 = mysql_query($sqlB2) or die (mysql_error());
		$rowB2 = mysql_fetch_array($resB2);
		
		
		
?>
		<tr>
			<th style = 'text-align:left;' >
				<?php echo $row['strDescripcionL'];?>
				
			</th>
			<td>
				<?php 
					// echo $row['strCapacidadL']." - ".$sumaBloqueos."<br>";
					echo $autorizados;
					$suma_autorizados += $autorizados;
				?>
			</td>
			
			<td>
				<div class = 'no_vendido_<?php echo $row['idLocalidad']?> valore_no_vendidos' style = 'color:blue;'></div>
			</td>
			
			<td style = '<?php echo $display;?>'>
				<?php 
					echo $rowB2['vendidos_todos'];
					$suma_impresos_normales += $rowB2['vendidos_todos'];
				?>
			</td>
			
			<td>
				<?php 
					echo $rowB['vendidos_normal'];
					$suma_vendidos_normal += $rowB['vendidos_normal'];
				?>
			</td>
			<td>
				<?php echo $row['doublePrecioL'];?>
			</td>
			<td>
				<?php 
					echo number_format(($row['doublePrecioL'] * $rowB['vendidos_normal']),2 , "," , "");
					$suma_precio_normal += ($row['doublePrecioL'] * $rowB['vendidos_normal']);
				?>
			</td>
			
			<td>
				<?php 
					echo number_format((($row['doublePrecioL'] * $rowB['vendidos_normal']) / (1 + $rowI['municipio'])),2 , "," , "");
					$suma_valor_admision_normales += (($row['doublePrecioL'] * $rowB['vendidos_normal']) / (1 + $rowI['municipio']));
				?>
			</td>
			<td>
				<?php 
					echo number_format(($row['doublePrecioL'] * $rowB['vendidos_normal']) - ((($row['doublePrecioL'] * $rowB['vendidos_normal']) / (1 + $rowI['municipio']))),2 , "," , "");
					$suma_total_admision_normales += (($row['doublePrecioL'] * $rowB['vendidos_normal']) - ((($row['doublePrecioL'] * $rowB['vendidos_normal']) / (1 + $rowI['municipio']))));
				?>
			</td>
		</tr>
<?php
	$sqlD = 'SELECT * FROM `descuentos` WHERE `idloc` = "'.$row['idLocalidad'].'" and `nom` NOT LIKE "%cortes%" ORDER BY `nom` DESC ';
	$resD = mysql_query($sqlD) or die (mysql_error());
	
	$sumadescuentoA = 0;
	while($rowD = mysql_fetch_array($resD)){
		
		$sqlB1 = '	SELECT count(idBoleto) as vendidos_descuento 
					FROM `Boleto`
					WHERE `idCon` = "'.$idcon.'" 
					AND `idLocB` = "'.$row['idLocalidad'].'" 
					AND `tercera` = 1 
					AND `id_desc` = "'.$rowD['id'].'" 
					'.$query.'
					ORDER BY `idLocB` DESC ';
		$resB1 = mysql_query($sqlB1) or die (mysql_error());
		$rowB1 = mysql_fetch_array($resB1);
		
		
		$sqlB1T = '	SELECT count(idBoleto) as vendidos_descuento_total
					FROM `Boleto`
					WHERE `idLocB` = "'.$row['idLocalidad'].'" 
					AND `tercera` = 1 
					AND `id_desc` = "'.$rowD['id'].'" 
					'.$query.'
					ORDER BY `idLocB` DESC ';
		$resB1T = mysql_query($sqlB1T) or die (mysql_error());
		$rowB1T = mysql_fetch_array($resB1T);
?>
		<tr>
			<td style = 'color:#00ADEF;text-transform:lowercase;font-size:12px;'>
				<?php echo $rowD['nom'];?>
			</td>
			
			<td>
				
			</td>
			
			<td>
				
			</td>
			
			<td style = '<?php echo $display;?>'>
				<?php 
					echo $rowB1T['vendidos_descuento_total'];
					$suma_impresos_descuento += $rowB1T['vendidos_descuento_total'];
				?>
			</td>
			
			<td>
				<?php 
					echo $rowB1['vendidos_descuento'];
					$sumadescuento += $rowB1['vendidos_descuento'];
					$sumadescuentoA += $rowB1['vendidos_descuento'];
				?>
			</td>
			<td>
				<?php 
					echo number_format(($rowD['val']),2 , "," , "");
					
				?>
			</td>
			<td>
				<?php 
					echo number_format(($rowD['val'] * $rowB1['vendidos_descuento']),2 , "," , "");
					$suma_precio_descuento += ($rowD['val'] * $rowB1['vendidos_descuento']);
				?>
			</td>
			<td>
				<?php 
					echo number_format((($rowD['val'] * $rowB1['vendidos_descuento'])/(1+$rowI['municipio'])),2 , "," , "");
					$suma_valor_admision_descuento += (($rowD['val'] * $rowB1['vendidos_descuento'])/(1+$rowI['municipio']));
				?>
			</td>
			
			<td>
				<?php 
					echo number_format(($rowD['val'] * $rowB1['vendidos_descuento']) - ((($rowD['val'] * $rowB1['vendidos_descuento'])/(1+$rowI['municipio']))),2 , "," , "");
					$suma_total_admision_descuento += (($rowD['val'] * $rowB1['vendidos_descuento']) - ((($rowD['val'] * $rowB1['vendidos_descuento'])/(1+$rowI['municipio']))));
				?>
			</td>
		</tr>
		
		
<?php
	}
?>



<?php
	$sqlD1 = 'SELECT * FROM `descuentos` WHERE `idloc` = "'.$row['idLocalidad'].'" and `nom` LIKE "%cortes%" ORDER BY `nom` DESC ';
	$resD1 = mysql_query($sqlD1) or die (mysql_error());
	$sumadescuento1A = 0;
	while($rowD1 = mysql_fetch_array($resD1)){
		
		$sqlB11 = '	SELECT count(idBoleto) as vendidos_descuento 
					FROM `Boleto`
					WHERE `idCon` = "'.$idcon.'" 
					AND `idLocB` = "'.$row['idLocalidad'].'" 
					AND `tercera` = 1 
					AND `id_desc` = "'.$rowD1['id'].'" 
					'.$query.'
					ORDER BY `idLocB` DESC ';
		$resB11 = mysql_query($sqlB11) or die (mysql_error());
		$rowB11 = mysql_fetch_array($resB11);
		
		
		
		
		$sqlB11T = '	SELECT count(idBoleto) as vendidos_descuento_todos 
					FROM `Boleto`
					WHERE `idLocB` = "'.$row['idLocalidad'].'" 
					AND `tercera` = 1 
					AND `id_desc` = "'.$rowD1['id'].'" 
					'.$query.'
					ORDER BY `idLocB` DESC ';
		$resB11T = mysql_query($sqlB11T) or die (mysql_error());
		$rowB11T = mysql_fetch_array($resB11T);
		
		
		
		
		
		if($rowB11['vendidos_descuento'] == 0){
			$tipoTexto = '';
		}else{
			$tipoTexto = 'color:red;text-transform:lowercase;font-size:14px;';
		}
		
		$sqlLC = 'SELECT * FROM `localidad_cortesias` where id_loc = "'.$rowD1['idloc'].'" ';
		$resLC = mysql_query($sqlLC) or die (mysql_error());
		$rowLC = mysql_fetch_array($resLC);
?>
		<tr>
			<td style = 'color:red;text-transform:lowercase;font-size:12px;'>
				<?php echo $rowD1['nom'];?>
			</td>
			
			<td style = 'text-transform:lowercase;font-size:12px;'>
				<?php 
					echo $rowLC['cant'];
					$suma_autorizados_cortesias += $rowLC['cant'];
				?>
			</td>
			
			<td style = 'text-transform:lowercase;font-size:12px;'>
				<?php echo "<div class = 'valor_novendidos_cortesias' >".($rowLC['cant'] - $rowB11['vendidos_descuento'])."</div>";?>
			</td>
			
			<td style = 'text-transform:lowercase;font-size:12px;<?php echo $display;?>'>
				<?php 
					echo $rowB11T['vendidos_descuento_todos'];
					$suma_impresos_cortesia += $rowB11T['vendidos_descuento_todos'];
				?>
			</td>
			
			<td style = '<?php echo $tipoTexto;?>'>
				<?php 
					
					echo $rowB11['vendidos_descuento'];
					$sumadescuento1 += $rowB11['vendidos_descuento'];
					$sumadescuento1A += $rowB11['vendidos_descuento'];
				?>
			</td>
			<td >
				<?php 
					
					echo number_format(($rowD1['val']),2 , "," , "");
					
				?>
			</td>
			
			<td >
				<?php 
					
					echo number_format(($rowD1['val'] * $rowB11['vendidos_descuento']),2 , "," , "");
					$suma_precio_cortesia += ($rowD1['val'] * $rowB11['vendidos_descuento']);
				?>
			</td>
			
			<td >
				<?php 
					
					echo number_format((($rowD1['val'] * $rowB11['vendidos_descuento']) /  (1+$rowI['municipio'])),2 , "," , "");
					$suma_valor_admision_cortesias += (($rowD1['val'] * $rowB11['vendidos_descuento']) /  (1+$rowI['municipio']));
				?>
			</td>
			<td >
				<?php 
					
					echo number_format(($rowD1['val'] * $rowB11['vendidos_descuento']) - ((($rowD1['val'] * $rowB11['vendidos_descuento']) /  (1+$rowI['municipio']))),2 , "," , "");
					$suma_total_admision_cortesia += (($rowD1['val'] * $rowB11['vendidos_descuento']) - ((($rowD1['val'] * $rowB11['vendidos_descuento']) /  (1+$rowI['municipio']))));
				?>
			</td>
		</tr>
		
		
<?php
	}
?>
		<tr class = 'suma_total_aut_menos_vendidos' numero_localidad = "<?php echo $row['idLocalidad']?>" style = 'display:none;'>
			<td style = 'border-top:1px solid #000'>
				<div id="suma_aut_menos_vendidos_<?php echo $row['idLocalidad']?>"><?php echo ($autorizados - ($rowB['vendidos_normal'] + $sumadescuentoA))?></div>
				<?php //echo "(".$autorizados."-(".$rowB['vendidos_normal']." + ".$sumadescuentoA."))"?></div>
			</td>
		</tr>
<?php
	}
?>
		<tr >
			<th>
				TOTALES
			</th>
			<td>
				<?php echo ($suma_autorizados + $suma_autorizados_cortesias);?>
			</td>
			
			<td>
				<div id = 'suma_total_no_vendidos'></div>
			</td>
			
			<td style = '<?php echo $display;?>'>
				<?php echo ($suma_impresos_normales + $suma_impresos_descuento + $suma_impresos_cortesia);?>
			</td>
			
			<td>
				<?php echo ($sumadescuento1  +  $sumadescuento +  $suma_vendidos_normal);?>
			</td>
			<td>
				
			</td>
			<td>
				<?php 
					echo ($suma_precio_normal + $suma_precio_descuento + $suma_precio_cortesia)."<br>";
					// echo "(".$suma_precio_normal." + ".$suma_precio_descuento." + ".$suma_precio_cortesia.")";
				?>
			</td>
			<td>
				<?php echo number_format(($suma_valor_admision_normales + $suma_valor_admision_descuento + $suma_valor_admision_cortesias),2 , "," , "");?>
			</td>
			<td>
				<?php echo number_format(($suma_total_admision_normales + $suma_total_admision_descuento + $suma_total_admision_cortesia),2 , "," , "")?>
			</td>
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
		$( document ).ready(function() {
			$( ".suma_total_aut_menos_vendidos" ).each(function( index ) {
				var numero_localidad = $(this).attr('numero_localidad');
				var suma_aut_menos_vendidos_ = $('#suma_aut_menos_vendidos_'+numero_localidad).text();
				// alert(suma_aut_menos_vendidos_)
				$('.no_vendido_'+numero_localidad).html(suma_aut_menos_vendidos_);
			});
			
			var suma_total_no_vendidos = 0;
			
			$( ".valore_no_vendidos" ).each(function( index ) {
				var valore_no_vendidos = $(this).text();
				 // alert(valore_no_vendidos)
				suma_total_no_vendidos += (parseInt(valore_no_vendidos));
			});
			
			
			var suma_valor_novendidos_cortesias = 0;
			
			$( ".valor_novendidos_cortesias" ).each(function( index ) {
				var valor_novendidos_cortesias = $(this).text();
				 // alert(valore_no_vendidos)
				suma_valor_novendidos_cortesias += (parseInt(valor_novendidos_cortesias));
			});
			
			
			$('#suma_total_no_vendidos').html(parseInt(suma_total_no_vendidos) + parseInt(suma_valor_novendidos_cortesias));
		})
	</script>