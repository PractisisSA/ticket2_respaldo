<?php 
	include("controlusuarios/seguridadSP.php");
	$nombre = $_SESSION['useractual'];
	echo '<input type="hidden" id="data" value="1" />';
?>
<script src="SP/js/nuevodistribuidor.js"></script>
<script src="SP/js/editardistribuidor.js"></script>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 600px 0px 0px; padding:5px 0px 5px 40px; font-size:20px;">
				Lista de Usuarios
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 10px 40px; position:relative; padding:10px 0; text-align:center; color:#fff; font-size:18px;">
				<p class="filtro"><strong>Buscar por: &nbsp;&nbsp;</strong>
				<select id="search" class="inputlogin">
					<option value="0">Seleccione...</option>
					<option value="1">Nombre</option>
					<option value="2">Perfil</option>
				</select></p>
				<p class="serchNombre" style="display:none;">
					<input type="text" id="nombre" placeholder="Nombres..." class="inputlogin">&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" class="btnlink" id="buscarCli" onclick="buscar('2')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
					<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					<button type="button" class="btnlink" id="descargar" style="display: none;" onclick="descargarExcel('desglose', 'REPORTE USUARIOS')">Excel<img src="imagenes/arrow_left.png"/></button>
				</p>
				<p class="serchPerfil" style="display:none;">
					<strong>Perfil:</strong>&nbsp;&nbsp;
					<select class="inputlogin" id="perfil">
						<option value="0">Seleccione...</option>
						<option value="Admin">Administrador</option>
						<option value="Socio">Socio</option>
						<option value="Seguridad">Seguridad</option>
						<option value="Auditor">Auditor</option>
					</select>
					<button type="button" class="btnlink" id="buscarCli" onclick="buscar('1')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;&nbsp;
					<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					<button type="button" style="display: none;" class="btnlink" id="descargar1" onclick="descargarExcel1('desglose', 'REPORTE USUARIOS')">Excel<img src="imagenes/arrow_left.png"/></button>
				</p>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="border:2px solid #00ADEF; margin:40px; text-align:center;">
				<table id="select_conciertos" style="width:100%; color:#fff; font-size:16px; border-collapse:separate; border-spacing:15px 15px;">
					<tr style="text-align:center;">
						<td>
							<div class="registro"></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.paginate').live('click', function(){
		window.scroll(0,0);
		var sector = $('#data').val();
		var nombre = $('#nombre').val();
		var perfil = $('#perfil').val();
		var dato = $('#search').val();
		$('.registro').html('<div class="loading"><img src="imagenes/loading.gif" width="70px"/></div>');
		var page = $(this).attr('data');
		
		$.ajax({
			type: "GET",
			url: "SP/paginadorSP.php",
			data: {page : page, nombre : nombre, sector : sector, perfil : perfil, dato : dato},
			success: function(data){
				$('.registro').fadeIn(200).html(data);
			}
		});
	});
});


$('#search').on('change',function(){
	var search = $('#search').val();
	if(search == 1){
		$('.filtro').fadeOut('slow');
		$('.serchNombre').delay(600).fadeIn('slow');
	}else if(search == 2){
		$('.filtro').fadeOut('slow');
		$('.serchPerfil').delay(600).fadeIn('slow');
	}
});

function cancel(){
	var search = $('#search').val();
	if(search == 1){
		$('.serchNombre').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search').val(0);
		$('#nombre').val('');
		$('.registro').html('');
	}else if(search == 2){
		$('.serchPerfil').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search').val(0);
		$('#perfil').val(0);
		$('.registro').html('');
	}
}

function buscar(dato){
	var sector = $('#data').val();
	if(dato == 1){
		var perfil = $('#perfil').val();
		if(perfil == 0){
			alert('Selecciona un Perfil');
		}else{
			$.post('SP/paginadorSP.php',{
				dato : dato, sector : sector, perfil : perfil
			}).done(function(data){
				$('#descargar1').css('display', 'inline');
				$('.registro').html(data);
			});
		}
	}
	if(dato == 2){
		var nombre = $('#nombre').val();
		$.post('SP/paginadorSP.php',{
			dato : dato, sector : sector, nombre : nombre
		}).done(function(data){
		$('#descargar').css('display', 'inline');
			console.log(data);
			$('.registro').html(data);
		});
	}
}
var descargarExcel = (function () {
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
var descargarExcel1 = (function () {
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