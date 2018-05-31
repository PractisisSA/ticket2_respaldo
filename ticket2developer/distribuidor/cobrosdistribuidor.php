<?php 
	include("controlusuarios/seguridadDis.php");
	
	echo '<input type="hidden" id="data" value="1" />';
	$nombre = $_SESSION['useractual'];
	$idDis = $_SESSION['idDis'];
	
	$gbd = new DBConn();
	$fecha = date("Y-m-d");
	
?>
<div style="margin: 10px -10px">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; color:#fff; margin:20px 70% 0px 0px; padding:5px 0px 5px 40px; font-size:22px;">
				<strong>Cobros</strong>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px -10px 40px; position:relative; padding:20px 0 10px; text-align:center; color:#fff; font-size:18px;">
					COBROS DE EVENTOS ASIGNADOS 
				<div class="row filtro" style = 'display:none;'>
					<div class="col-lg-2"></div>
					<div class="col-lg-2" style="text-align:right;">
						<strong>Buscar por:</strong>
					</div>
					<div class="col-lg-4">
						<select id="search" class="inputlogin form-control">
							<option value="0">Seleccione...</option>
							<option value="1">Documento de Identidad</option>
							<option value="2">Código de Compra</option>
						</select>
					</div>
				</div>
				<div class="row documento" style="display:none;">
					<div class="col-lg-2"></div>
					<div class="col-lg-4">
						<input type="text" id="documento" class="inputlogin form-control" maxlength="13" placeholder="Documento de Identidad" onkeydown="justInt(event,this.value)" />
					</div>
					<div class="col-lg-3">
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('1')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;
						<button type="button" class="btnlink" id="cancel1" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</div>
				</div>
				<div class="row codigo" style="display:none;">
					<div class="col-lg-2"></div>
					<div class="col-lg-4">
						<input type="text" id="codigo" class="inputlogin form-control" placeholder="Código de Compra" onkeydown="justInt(event,this.value)">
					</div>
					<div class="col-lg-3">
						<button type="button" class="btnlink" id="buscarCli" onclick="buscar('2')">Buscar&nbsp;<img src="imagenes/lupe.png"/></button>&nbsp;
						<button type="button" class="btnlink" id="cancel2" onclick="cancel()">Cancelar&nbsp;<img src="imagenes/clouse.png"/></button>
					</div>
				</div>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
			<div style="border:2px solid #00ADEF; margin:40px; text-align:center;">
				<table id="select_conciertos" style="width:100%;">
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
	buscar(1);
	$('.paginate').live('click', function(){
		window.scroll(0,0);
		var documento = $('#documento').val();
		var id = $('#search').val();
		var paginador = $('#data').val();
		var codigo = $('#codigo').val();
		$('.registro').html('<div class="loading"><img src="imagenes/loading.gif" width="70px"/></div>');
		var page = $(this).attr('data');
		
		$.ajax({
			type: "GET",
			url: "distribuidor/ajax/ajaxPaginadorDis.php",
			data: {page : page, documento : documento, codigo : codigo, id : id, paginador : paginador},
			success: function(data){
				$('.registro').fadeIn(200).html(data);
			}
		});
	});
});

$('#search').on('change',function(){
	var search = $('#search').val();
	if(search == 0){
		alert('Selecciona un filtro');
	}else if(search == 1){
		$('.filtro').fadeOut('slow');
		$('.documento').delay(600).fadeIn('slow');
	}else if(search == 2){
		$('.filtro').fadeOut('slow');
		$('.codigo').delay(600).fadeIn('slow');
	}
});

function cancel(){
	var search = $('#search').val();
	if(search == 1){
		$('.documento').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search').val(0);
		$('.registro').html('');
		$('#documento').val('');
	}else if(search == 2){
		$('.codigo').fadeOut('slow');
		$('.filtro').delay(600).fadeIn('slow');
		$('#search').val(0);
		$('.registro').html('');
		$('#codigo').val('');
	}
}

function buscar(id){
	var paginador = $('#data').val();
	$('.registro').html('<center><h1 style = "color:#fff;">ESPERE!!! CONSULTANDO INFORMACION</h1></center>');
	setTimeout(function(){
		if(id == 1){
			
			var documento = $('#documento').val();
			$.post('distribuidor/ajax/ajaxPaginadorDis.php',{
				documento : documento, id : id, paginador : paginador
			}).done(function(data){
				$('.registro').html(data);
			});
		}
		if(id == 2){
			var codigo = $('#codigo').val();
			$.post('distribuidor/ajax/ajaxPaginadorDis.php',{
				codigo : codigo, id : id, paginador : paginador
			}).done(function(data){
				$('.registro').html(data);
			});
		}

	}, 2000);
}

function justInt(e,value){
    if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 13)){
        return;
	}else{
        e.preventDefault();
	}
}	

function cobrar(codigo , est){
	window.location = '?modulo=cobrarDis&cod='+codigo+'&estado='+est;
}
</script>