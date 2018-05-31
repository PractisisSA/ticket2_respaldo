<?php
		date_default_timezone_set('America/Guayaquil');
		
		include 'conexion.php';
		echo '<input type="hidden" id="data" value="56" />';
		
		$today = date("Y-m-d");  
		$nuevafecha = strtotime ( '-7 day' , strtotime ( $today ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
?>		
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		
		<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
		<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
		<script>
			$( function() {
				 $.datepicker.regional['es'] = {
				 closeText: 'Cerrar',
				 prevText: '<Ant',
				 nextText: 'Sig>',
				 currentText: 'Hoy',
				 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
				 weekHeader: 'Sm',
				 firstDay: 1,
				 isRTL: false,
				 showMonthAfterYear: false,
				 yearSuffix: ''
				 };
				 
				 
				 $.datepicker.setDefaults($.datepicker.regional['es']);
				$( ".datepicker" ).datepicker({ 
					dateFormat: 'yy-mm-dd' 
				});
			} );
		</script>
		<style>
			.carpeta:hover{
				cursor:pointer;
				color:blue;
				text-decoration:underline;
			}
			.color{
				color :#fff; 
			}
		</style>
		<div style="background-color:#171A1B;">
		<div style="border: 2px solid #00AEEF;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 50px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				<strong>REPORTE DE PAGOS WEB (TRANSFERENCIAS,PAYPAL,STRIPE)</strong>
			</div><br>
			<?php
				$sqlC = '	SELECT c.*
							FROM Concierto AS c , factura AS f
							WHERE c.idConcierto = f.idConc
							AND f.tipo != 5
							GROUP BY f.idConc
							ORDER BY idConcierto DESC 
						';
				// echo $sqlC."<br>";
			?>
			
			
				<div class = 'col-md-3' >
					<label class = 'color' >Evento : </label>
					<select class = 'form-control' id = 'eventosReportes' style = 'width:300px;'>
						<option value = '' >Seleccione ... </option>
						<option value = '0' >Todos los Eventos ... </option>
					<?php
						
						$resC = mysql_query($sqlC) or die ($sqlC);
						while($rowC = mysql_fetch_array($resC)){
					?>
						<option value = '<?php echo $rowC['idConcierto'];?>' ><?php echo $rowC['strEvento'];?>  [<?php echo $rowC['idConcierto'];?>]</option>
					<?php
						}
					?>
					</select>
				</div>
				<div class = 'col-md-2' >
					<label class = 'color' >Tipo : </label>
					<select class = 'form-control' id = 'tipo_pago' >
						<option value = '' >Todos</option>
						<option value = '1' >Impresos</option>
						<option value = '0' >No Impresos</option>
					</select>
				</div>
				
				<div class = 'col-md-2' >
					<label class = 'color' >Desde : </label>
					<input type = 'text' value = '' id = 'desde'  class = 'form-control datepicker' placeholder = 'desde' />
				</div>
				
				<div class = 'col-md-2' >
					<label class = 'color' >Hasta :</label> 
					<input type = 'text' value = '' id = 'hasta'  class = 'form-control datepicker' placeholder = 'hasta' />
				</div>
				<div class = 'col-md-1' >
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" class="btn btn-default" onclick = "filtroEventos()">Consultar</button>
				</div>
			
			
			<br><br>
			<!--<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>-->
			<i onclick="tableToExcel3('recibeTransferencias', 'REPORTE PAGOS TRANSFERENCIA BANCARIA ')" class="fa fa-file-excel-o fa-2x" style = 'float:right;color:#fff;cursor:pointer;' title = 'descarga a excel el reporte de compras por transferencia bancaria!!!' ></i>
			<br>
			<br>
			<div id = 'mensajeEspera'></div>
			<div class="table-responsive" style = 'max-height: 400px'>
				<table class = "table" style = 'background-color:#fff;' id = 'recibeTransferencias'>
					<thead>
						<tr>
							<th colspan = '12' >
								REPORTE DE PAGOS WEB (TRANSFERENCIAS,PAYPAL,STRIPE)
							</th>
						</tr>
						<tr>
							<td>TIPO</td>
							<td>CLIENTE</td>
							<td>CEDULA</td>
							<td>#</td>
							<td>ASIENTOS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td>VALOR</td>
							<td>COMISIÒN</td>
							<td>ENVIO</td>
							<td>TOTAL</td>
							<td>Estado</td>
							<td>Boton</td>
							<td>FECHA</td>
							<td>HORA</td>
							<td>EVENTO</td>
							
							<td>Ver</td>
							<td>EMAIL</td>
							<td>TELEFONO</td>
							
						</tr>
					</thead>
					<tbody id = 'recibeConsulta'>
						
					</tbody>
				</table>
			</div>
			
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
	function filtroEventos(){
		var evento = $('#eventosReportes').val();
		var tipo_pago = $('#tipo_pago').val();
		var desde = $('#desde').val();
		var hasta = $('#hasta').val();
		
		if(evento == ''){
			alert('seleccione un evento o a su vez todos');
		}
		
		
		if(evento == ''){
			
		}else{
			$('#recibeConsulta').html('');
			$('#mensajeEspera').html('<center><h1 style = "color:#fff;margin:0px;padding:0px;" >ESPERE, CARGANDO INFORMACIÓN!!!</h1></center>');
			$.post("spadmin/detalle_paypal_stripe_todos.php",{ 
				evento : evento , tipo_pago : tipo_pago , desde : desde , hasta : hasta
			}).done(function(data){
				console.log(data);
				$('#mensajeEspera').html('');
				$('#recibeConsulta').html(data);
			});
		}
	}
	function imprimirDomicilio_2(cliente , conc , loc , idDis , tipotrans , pago , valor , impresion , id_fact){
		$('#imprimeTickets'+id_fact).attr('disabled',true);
		$('#imprimeTickets'+id_fact).html('Espere ... <i class="fa fa-spinner" aria-hidden="true"></i>');
		var idBol = $('#idBol_'+id_fact).val();
		// alert(idBol)
		$.post("spadmin/imprime_tickets_domicilio.php",{ 
			cliente : cliente , conc : conc , loc : loc , idDis : idDis , tipotrans : tipotrans ,
			pago : pago , valor : valor , impresion : impresion , idBol : idBol , id_fact : id_fact
		}).done(function(data){
			alert(data);
			// window.location='';
		});
	}

	$( document ).ready(function() {
		$( "#eventosReportes__" ).change(function() {
			var evento = $('#eventosReportes').val();
			var tipo = 1;
			if(evento == ''){
				alert('debe seleccionar un evento , o todos los eventos');
			}else{
				$('#mensajeEspera').html('<center><h1 style = "color:#fff;margin:0px;padding:0px;" >ESPERE, CARGANDO INFORMACIÓN!!!</h1></center>');
				$.post("spadmin/detalle_paypal_stripe_todos.php",{ 
					evento : evento 
				}).done(function(data){
					console.log(data);
					$('#mensajeEspera').html('');
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
	function verDomicilio(id , evento , ident , ident_deposito){
		$('#titulo2').html('Evento : ' + evento +  ' / factura : ' + id );
		$('#modalDetalleDomicilio').modal('show');
		$('#recibeDetalle2').html("<center><img src = 'imagenes/ajax-loader.gif' /></center>");
		$.post("spadmin/detalleDomicilio.php",{ 
			id : id , ident : ident , ident_deposito : ident_deposito
		}).done(function(data){
			$('#recibeDetalle2').html(data);
		});
	}
	function verDetalle(id , evento , ident){
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