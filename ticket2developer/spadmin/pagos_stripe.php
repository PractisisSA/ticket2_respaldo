<?php
	echo $_SESSION['idDis'];
		date_default_timezone_set('America/Guayaquil');
		include 'conexion.php';
		echo '<input type="hidden" id="data" value="42" />';
?>		
		<style>
			.carpeta:hover{
				cursor:pointer;
				color:blue;
				text-decoration:underline;
			}
		</style>
		<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 50px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				<strong>REPORTES PAGOS STRIPE</strong>
			</div><br>
			
			<select class = 'form-control' id = 'eventosReportes' style = 'width:300px;'>
				<option value = '' >Seleccione ... </option>
				<option value = '0' >Todos los Eventos ... </option>
			<?php
				$sqlC = '	select c.*
							from Concierto as c , factura as f
							where c.idConcierto = f.idConc
							and f.tipo = 4
							group by f.idConc
							order by idConcierto DESC 
						';
				$resC = mysql_query($sqlC) or die ($sqlC);
				while($rowC = mysql_fetch_array($resC)){
			?>
				<option value = '<?php echo $rowC['idConcierto'];?>' ><?php echo $rowC['strEvento'];?>  [<?php echo $rowC['idConcierto'];?>]</option>
			<?php
				}
			?>
			</select><br><br>
			
			
			<!--<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>-->
			<i onclick="tableToExcel3('recibeTransferencias', 'REPORTE PAGOS POR STRIPE,TARJETA DE CREDITO ')" class="fa fa-file-excel-o fa-2x" style = 'float:right;color:#fff;cursor:pointer;' title = 'descarga a excel el reporte de compras por transferencia bancaria!!!' ></i>
			<br>
			<br>
			
			
			<table class = "table" style = 'background-color:#fff;' id = 'recibeTransferencias'>
				<thead>
					<tr>
						<th colspan = '12' >
							REPORTE DE PAGOS PAYPAL
						</th>
					</tr>
					<tr>
						<td>ID</td>
						<td>CLIENTE</td>
						<td>CEDULA</td>
						<td>EVENTO</td>
						<td>FECHA</td>
						<td>HORA</td>
						<td># TICKETS</td>
						<td>VALOR</td>
						<td>COMISIÒN</td>
						<td>ENVIO</td>
						<td>TOTAL</td>
						<td></td>
						<td>Estado</td>
					</tr>
				</thead>
				<tbody id = 'recibeConsulta'>
					
				</tbody>
			</table>
			
			
			<br><br>
			
			
			
			<div class="modal fade" id="modalDetalle" role="dialog" style = 'display:none;' data-keyboard="false" data-backdrop="static">
				<div class="modal-dialog" style = 'width:75%;'>
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" >
								<span id = 'titulo' style = 'text-transform:uppercase;'></span>     <button type="button" class="btn btn-default" onclick="tableToExcel('recibeEventos', 'REPORTE PAYPAL / STRIPE')"> <i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> EXCEL</button>
							</h4>
						</div>
						<div class="modal-body" id = 'recibeDetalle'>
							<center><img src = 'imagenes/ajax-loader.gif' /></center>
						</div>
						<div class="modal-footer">
							<!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="modal fade" id="modalDetalleDomicilio" role="dialog" style = 'display:none;' data-keyboard="false" data-backdrop="static">
				<div class="modal-dialog" style = 'width:90%;'>
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title" >
								<span id = 'titulo2' style = 'text-transform:uppercase;'></span>     <button type="button" class="btn btn-default" onclick="tableToExcel2('recibeDomicilios', 'REPORTE DOMICILIOS ')"> <i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> EXCEL</button>
							</h4>
						</div>
						<div class="modal-body" id = 'recibeDetalle2'>
							<center><img src = 'imagenes/ajax-loader.gif' /></center>
						</div>
						<div class="modal-footer">
							<!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
<script>
	$( document ).ready(function() {
		$( "#eventosReportes" ).change(function() {
			var evento = $('#eventosReportes').val();
			var tipo = 4;
			if(evento == ''){
				alert('debe seleccionar un evento , o todos los eventos');
			}else{
				$.post("spadmin/detalle_paypal_stripe.php",{ 
					evento : evento , tipo : tipo
				}).done(function(data){
					$('#recibeConsulta').html(data);
				});
			}
		});
	});
	function desactivarBoletos(id) {
		var id = id;
		console.log(id);
		var confirmar = confirm("Seguro que quiere desactivar este boleto?");
		if (confirmar == true) {
			$.post("spadmin/desactivarBoleto.php",{ 
					 id : id
				}).done(function(data){
					console.log(data);
					$('#recibeConsulta').html(data);
					alert(data);
					location.reload();
				});
		}
	}
	function activarBoletos(id) {
		var confirmar = confirm("Seguro que quiere activar este boleto?");
		console.log(id);
		if (confirmar == true) {
			$.post("spadmin/activarBoleto.php",{ 
					 id : id
				}).done(function(data){
					console.log(data);
					$('#recibeConsulta').html(data);
					alert(data);
					location.reload();
				});
		}
	}
	function verDomicilio(id , evento , ident){
		$('#titulo2').html('Evento : ' + evento +  ' / factura : ' + id );
		$('#modalDetalleDomicilio').modal('show');
		$('#recibeDetalle2').html("<center><img src = 'imagenes/ajax-loader.gif' /></center>");
		$.post("spadmin/detalleDomicilio.php",{ 
			id : id , ident : ident
		}).done(function(data){
			console.log
			$('#recibeDetalle2').html(data);
		});
	}
	function verDetalle(id , evento , ident){
		console.log(id);
		$('#titulo').html('Evento : ' + evento +  ' / factura : ' + id );
		$('#modalDetalle').modal('show');
		$('#recibeDetalle').html("<center><img src = 'imagenes/ajax-loader.gif' /></center>");
		$.post("spadmin/detallePagosWeb.php",{ 
			id : id , ident : ident
		}).done(function(data){
			$('#recibeDetalle').html(data);
		});
	}

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
	
	
	var tableToExcel2 = (function() {
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
	
	var tableToExcel3 = (function() {
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