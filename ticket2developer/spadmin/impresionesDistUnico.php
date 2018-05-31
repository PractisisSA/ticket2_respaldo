<?php
		date_default_timezone_set('America/Guayaquil');
		
		include 'conexion.php';
		echo '<input type="hidden" id="data" value="36" />';
		$cont = 'SELECT * FROM Concierto WHERE idUser = '.$_SESSION['iduser'].' order by idConcierto DESC ';
		$contRes = mysql_query($cont);
?>	
	
	<div class="message" style="display: none;">
		<h4 style="color:white;">Cargando...</h4>
	</div>
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-12">
			<button type="button" class="btn btn-default" onclick="tableToExcel('table', 'VENTAS DISTRIBUIDOR')">EXCEL</button>
			<center>
				<h3 style="color: white !important;">Seleccione evento:</h3>
			<select id='concert-sel' class='form-control center' style='width:350px;'>
				<option value='0'>Seleccione un Evento...</option>
<?php		
		while ($contDone = mysql_fetch_array($contRes)) {
			echo "<option value='".$contDone['idConcierto']."'>".$contDone['strEvento']." [".$contDone['idConcierto']."]</option>";
		}

?>			</select>
		</center>
		<center>
			<select style="display: none; width: 150px;" class="form-control" id="comboEventosSocios">
			</select>
		</center>
		</div>
	</div>
	<div class="res">
	</div>
<script type="text/javascript">
$('#concert-sel').change(function () {
		var co = $('#concert-sel').val();
		$('.res').html('<center><h2 style = "padding:0px;margin:0px;color:#fff;">Espere, cargando información</h2></center>');
		$.post("spadmin/impresionesDistribuidorSocio.php",{ 
			idconciertotrans: co 
		}).done(function(data){
			if (data == 1) {
				alert('No hay boletos vendidos para este evento');
			}else{
				$('#comboEventosSocios').css('display', 'inline');
				$('#comboEventosSocios').html(data);
				$.post("spadmin/impresiones_distribuidor_combo.php",{ 
					idconciertotrans: co 
				}).done(function(data){
					console.log(data);
					$('.res').html(data);
				});
			}
			
		}); 
})
$('#comboEventosSocios').change(function () {
	$('.res').html('<center><h2 style = "padding:0px;margin:0px;color:#fff;">Espere, cargando información</h2></center>');
	var idconciertotrans = $('#concert-sel').val();
	var di = $('#comboEventosSocios').val();
	if (di == 0) {
		$.post("spadmin/impresiones_distribuidor_combo.php",{ 
			idconciertotrans: idconciertotrans 
		}).done(function(data){
			console.log(data);
			$('.res').html(data);
		});
	}else{
		$.post("spadmin/impresiones_distribuidor_socio.php",{ 
			idDistribuidor : di, idconciertotrans: idconciertotrans 
		}).done(function(data){
			console.log(data);
			$('.res').html(data);
		});
	}
});
var tableToExcel = (function() {
          var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
          return function(table, name) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
          }
        })()
</script>
