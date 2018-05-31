<?php
		date_default_timezone_set('America/Guayaquil');
		
		include 'conexion.php';
		echo '<input type="hidden" id="data" value="36" />';
?>		
		
		<div class = 'row'>
			<div class = 'col-md-1'></div>
			<div class = 'col-md-12'>
				<center>
					<button type="button" class="btn btn-default" onclick="tableToExcel('recibeEventos', 'REPORTE SRI ')">EXCEL</button>
				</center><br><br>
				<center>
					<select class = 'form-control' id = 'comboEventos' style = 'width:350px;'>
						<option value = ''>Seleccione ...</option>
					<?php
						$sql = 'select strEvento , idConcierto from Concierto where idConcierto > 36 and costoenvioC > 0 order by idConcierto DESC';
						$res = mysql_query($sql) or die (mysql_error());
						while($row = mysql_fetch_array($res)){
					?>
						<option value = '<?php echo $row['idConcierto'];?>'><?php echo $row['strEvento'];?>  [<?php echo $row['idConcierto'];?>]</option>
					<?php
						}
					?>
					</select>
				</center>
				<center>
					<select style="display: none; width: 150px;" class="form-control" id="comboEventosDos">
				  	</select>';
				</center>	
					<br><br>
					<center><img src="http://ticketfacil.ec/imagenes/loading.gif" id="loadBoleto" style = 'display:none;width:50px;'></center>
				<div id = 'recibeEventos'></div>
			</div>
			<div class = 'col-md-1'></div>
		</div>
<script>
	$( document ).ready(function() {
		$( "#comboEventos" ).change(function() {
			var idconciertotrans = $( "#comboEventos" ).val();
			if(idconciertotrans == ''){
				alert('Debe seleccionar un evento');
			}else{
				$('#recibeEventos').html('');
				$.post("spadmin/impresiones_distribuidor_combo1.php",{ 
					idconciertotrans : idconciertotrans
				}).done(function(dataCombo){
					$('#loadBoleto').css('display','block');
					$('#comboEventosDos').css('display', 'inline');
					$('#comboEventosDos').html(dataCombo);
					console.log(dataCombo);
					$.post("spadmin/impresiones_distribuidor_combo.php",{ 
					idconciertotrans: idconciertotrans 
					}).done(function(data){
						console.log(data);
						$('#loadBoleto').css('display','none');
						$('#recibeEventos').html(data);
					});
					if (dataCombo == 1) {
						$('#comboEventosDos').css('display', 'none');
						alert('No se registra informacion para este evento');
					}else{
						console.log(dataCombo);
						$('#comboEventosDos').html(dataCombo);
						$('#comboEventosDos').css('display','inline');
					}
				});
			}
		});
		$( "#comboEventosDos" ).change(function() {
			var idDistribuidor = $( "#comboEventosDos" ).val();
			console.log(idDistribuidor);
			var idconciertotrans = $( "#comboEventos" ).val();
			if(idDistribuidor == 0){
				$('#recibeEventos').html('');
				$('#loadBoleto').css('display','block');
				$.post("spadmin/impresiones_distribuidor_combo.php",{ 
					idconciertotrans: idconciertotrans 
				}).done(function(data){
					console.log(data);
					$('#loadBoleto').css('display','none');
					$('#recibeEventos').html(data);
				});
			}else{
				$('#recibeEventos').html('');
				$('#loadBoleto').css('display','inline');
				$.post("spadmin/impresiones_distribuidor_combo2.php",{ 
					idDistribuidor : idDistribuidor, idconciertotrans: idconciertotrans 
				}).done(function(data){
					console.log(data);
					$('#loadBoleto').css('display','none');
					$('#recibeEventos').html(data);
				});
			}
		});
	});
		
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