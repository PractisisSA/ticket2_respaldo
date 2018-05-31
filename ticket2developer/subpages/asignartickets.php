<?php 
	include("controlusuarios/seguridadusuario.php");
	
	$gbd = new DBConn();
	
	$sql = "SELECT idBoleto, nombreHISB, documentoHISB, strEvento, strDescripcionL, rowB, colB, asignarB FROM Boleto b JOIN Concierto c ON b.idCon = c.idConcierto JOIN Localidad l ON b.idLocB = l.idLocalidad WHERE b.idCli = ? AND b.strEstado = ?";
	$query = $gbd -> prepare($sql);
	$query -> execute(array($_SESSION['id'],'A'));
?>
<div class="divborderexterno" id="contenedor_asiganar" style="margin:-10px -10px 10px; border:none; display:none;">
	<div style="background-color:#171A1B; padding:20px;">
		<div style="border: 2px solid #00AEEF; margin:20px;">
			<div style="background-color:#EC1867; margin-right:60%; margin-top:20px; padding-left:30px; font-size:25px; color:#fff;">
				<strong>Tu Perfil</strong>
			</div>
			<div style="background-color:#00ADEF; margin:20px -42px 40px 40px; position:relative; padding-left:40px;">
				<div class="row">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td>
									<h4>Concierto</h4>
								</td>
								<td>
									<h4>Localidad</h4>
								</td>
								<td>
									<h4>Asiento</h4>
								</td>
								<td>
									<h4>Nombre</h4>
								</td>
								<td>
									<h4>Cédula</h4>
								</td>
								<td>
									<h4>Transferir</h4>
								</td>
							</tr>
							<?php while($row = $query -> fetch(PDO::FETCH_ASSOC)){ ?>
							<tr>
								<td>
									<?php echo $row['strEvento'];?>
									<input type="hidden" id="concierto<?php echo $row['idBoleto'];?>" value="<?php echo $row['strEvento'];?>" />
								</td>
								<td>
									<?php echo $row['strDescripcionL'];?>
									<input type="hidden" id="localidad<?php echo $row['idBoleto'];?>" value="<?php echo $row['strDescripcionL'];?>" />
								</td>
								<td>
									<?php echo 'Fila_'.$row['rowB'].' - Col_'.$row['colB'];?>
									<input type="hidden" id="asiento<?php echo $row['idBoleto'];?>" value="<?php echo 'Fila_'.$row['rowB'].' - Col_'.$row['colB'];?>" />
								</td>
								<td>
									<?php echo $row['nombreHISB'];?>
									<input type="hidden" id="nombre<?php echo $row['idBoleto'];?>" value="<?php echo $row['nombreHISB'];?>" />
								</td>
								<td>
									<?php echo $row['documentoHISB'];?>
									<input type="hidden" id="cedula<?php echo $row['idBoleto'];?>" value="<?php echo $row['documentoHISB'];?>" />
									<input type="hidden" id="idbol<?php echo $row['idBoleto'];?>" value="<?php echo $row['idBoleto'];?>" />
								</td>
								<td>
									<?php if($row['asignarB'] == 'S'){?>
										<button class="btn btn-success" type="button" onclick="asignar('<?php echo $row['idBoleto'];?>')">Asignar</button>
									<?php }else{?>
										<button class="btn btn-default" type="button" disabled="disabled">Asignado</button>
									<?php }?>
								</td>
							</tr>
							<?php } ?>
						</table>
					</div>
				</div>
				<div class="tra_azul"></div>
				<div class="par_azul"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="sec1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Seguridad!</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning" role="alert">
					<p><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> Si asigna un TICKET a otra persana, los nuevos datos ingresados seran utilizados para validar el TICKET. Desea continuar?</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="cancelar()">Cancelar</button>
				<button type="button" class="btn btn-primary" onclick="continuar()">Continuar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="asignar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cancelarmodal()"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Asignar TICKET</h4>
			</div>
			<div class="modal-body">
				<h3 id="lblasiento"></h3>
				<div class="row">
					<div class="col-lg-12">
						<h4>Nuevo Nombre:</h4>
						<input type="text" id="nuevonombre" class="form-control" placeholder="Ingrese nuevo nombre..." onkeyup="validarNombre(this.value)" />
						<input type="hidden" id="idbol" />
						<input type="hidden" id="nomantes" />
						<input type="hidden" id="concert" />
						<input type="hidden" id="local" />
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<h4>Nueva Cédula:</h4>
						<input type="text" id="nuevacedula" class="form-control" placeholder="Ingrese nueva cédula..." onchange="ValidarDocumento(this,this.value)" onkeyup="validarCedula(this.value)" />
						<input type="hidden" id="cedulaantes" />
					</div>
				</div>
				<div style="min-height:70px; padding-top:10px;">
					<div class="alert alert-danger" role="alert" id="alertacedula" style="display:none;">
						<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> 
						El número de documento ingresado es incorrecto.
					</div>
					<div class="alert alert-danger" role="alert" id="alertavacio" style="display:none;">
						<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> 
						Los campos estan vacios, llenelos por favor.
					</div>
					<div class="alert alert-danger" role="alert" id="alertanombre" style="display:none;">
						<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> 
						Para asignar un TICKET el nombre debe ser diferente al actual.
					</div>
					<div class="alert alert-danger" role="alert" id="alertarepetida" style="display:none;">
						<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> 
						Para asignar un TICKET el número de identificación debe ser diferente al actual.
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div id="botones">
					<button type="button" class="btn btn-default" onclick="cancelarmodal()">Cancelar</button>
					<button type="button" class="btn btn-primary" onclick="guardar()">Guardar</button>
				</div>
				<div style="display:none; text-align:center;" id="wait">
					<img src="imagenes/loading.gif" style="max-width:60px;" />
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#sec1').modal('show');
});

function continuar(){
	$('#contenedor_asiganar').fadeIn('slow');
	$('#sec1').modal('hide');
}

function cancelar(){
	window.location = '?modulo=start';
}

function asignar(id){
	var asiento = $('#asiento'+id).val();
	var nombre = $('#nombre'+id).val();
	var cedula = $('#cedula'+id).val();
	var concierto = $('#concierto'+id).val();
	var localidad = $('#localidad'+id).val();
	var idb = $('#idbol'+id).val();
	$('#idbol').val(idb);
	$('#cedulaantes').val(cedula);
	$('#nomantes').val(nombre);
	$('#lblasiento').html('Asiento: '+asiento);
	$('#concert').val(concierto);
	$('#local').val(localidad);
	$('#asignar').modal('show');
}

function validarNombre(value){
	var nombre = $('#nomantes').val();
	value = value.toLowerCase();
	nombre = nombre.toLowerCase();
	if(value == nombre){
		$('#nuevonombre').val('');
		$('#alertanombre').fadeIn();
		setTimeout("$('#alertanombre').fadeOut();",3500);
	}
}

function validarCedula(value){
	var cedula = $('#cedulaantes').val();
	if(value == cedula){
		$('#nuevacedula').val('');
		$('#alertarepetida').fadeIn();
		setTimeout("$('#alertarepetida').fadeOut();",3500);
	}
}

function ValidarDocumento(t,value){
	var valor = value;
	if(valor[0] == 'p'||valor[0] == 'P'){
		pasaporte(t,valor);
	}else{
		ValidarCedula(t,valor);
	}
	// alert(value);
}

function pasaporte(t,value){
	var valor = value;
	if(valor.length<3||valor.length>13){
		console.log('Pasaporte incorrecto');
		$(t).val('');
		$('#alertacedula').fadeIn();
		setTimeout("$('#alertacedula').fadeOut();",3500);
		return false;
	}else{
		if(valor[0]=='p'||valor[0]=='P'){
			buscarCliente();
		}else{
			console.log('Pasaporte incorrecto');
			$(t).val('');
			$('#alertacedula').fadeIn();
			setTimeout("$('#alertacedula').fadeOut();",3500);
			return false;
		}
	}
}

function ValidarCedula(t,value){
	var numero = value;
	var suma = 0;
	var residuo = 0;
	var pri = false;
	var pub = false;
	var nat = false;
	var numeroProvincias = 24;
	var modulo = 11;

	/* Verifico que el campo no contenga letras */
	var ok=1;
	/* Aqui almacenamos los digitos de la cedula en variables. */
	d1 = numero.substr(0,1);
	d2 = numero.substr(1,1);
	d3 = numero.substr(2,1);
	d4 = numero.substr(3,1);
	d5 = numero.substr(4,1);
	d6 = numero.substr(5,1);
	d7 = numero.substr(6,1);
	d8 = numero.substr(7,1);
	d9 = numero.substr(8,1);
	d10 = numero.substr(9,1);

	/* El tercer digito es: */
	/* 9 para sociedades privadas y extranjeros */
	/* 6 para sociedades publicas */
	/* menor que 6 (0,1,2,3,4,5) para personas naturales */

	if (d3==7 || d3==8){
		console.log('El tercer dígito ingresado es inválido');
		$(t).val('');
		$('#alertacedula').fadeIn();
		setTimeout("$('#alertacedula').fadeOut();",3500);
		return false;
	}

	/* Solo para personas naturales (modulo 10) */
	if (d3 < 6){
		nat = true;
		p1 = d1 * 2; if (p1 >= 10) p1 -= 9;
		p2 = d2 * 1; if (p2 >= 10) p2 -= 9;
		p3 = d3 * 2; if (p3 >= 10) p3 -= 9;
		p4 = d4 * 1; if (p4 >= 10) p4 -= 9;
		p5 = d5 * 2; if (p5 >= 10) p5 -= 9;
		p6 = d6 * 1; if (p6 >= 10) p6 -= 9;
		p7 = d7 * 2; if (p7 >= 10) p7 -= 9;
		p8 = d8 * 1; if (p8 >= 10) p8 -= 9;
		p9 = d9 * 2; if (p9 >= 10) p9 -= 9;
		modulo = 10;
	}else if(d3 == 6){
		/* Solo para sociedades publicas (modulo 11) */
		/* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
		pub = true;
		p1 = d1 * 3;
		p2 = d2 * 2;
		p3 = d3 * 7;
		p4 = d4 * 6;
		p5 = d5 * 5;
		p6 = d6 * 4;
		p7 = d7 * 3;
		p8 = d8 * 2;
		p9 = 0;
	}else if(d3 == 9) {
		/* Solo para entidades privadas (modulo 11) */
		pri = true;
		p1 = d1 * 4;
		p2 = d2 * 3;
		p3 = d3 * 2;
		p4 = d4 * 7;
		p5 = d5 * 6;
		p6 = d6 * 5;
		p7 = d7 * 4;
		p8 = d8 * 3;
		p9 = d9 * 2;
	}

	suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;
	residuo = suma % modulo;

	/* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
	digitoVerificador = residuo==0 ? 0: modulo - residuo;

	/* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/
	if (pub==true){
		if (digitoVerificador != d9){
			console.log('El ruc de la empresa del sector público es incorrecto.');
			$(t).val('');
			$('#alertacedula').fadeIn();
			setTimeout("$('#alertacedula').fadeOut();",3500);
			return false;
		}
		/* El ruc de las empresas del sector publico terminan con 0001*/
		if ( numero.substr(9,4) != '0001' ){
			console.log('El ruc de la empresa del sector público debe terminar con 0001');
			$(t).val('');
			$('#alertacedula').fadeIn();
			setTimeout("$('#alertacedula').fadeOut();",3500);
			return false;
		}
	}else if(pri == true){
		if (digitoVerificador != d10){
			console.log('El ruc de la empresa del sector privado es incorrecto.');
			$(t).val('');
			$('#alertacedula').fadeIn();
			setTimeout("$('#alertacedula').fadeOut();",3500);
			return false;
		}
		if ( numero.substr(10,3) != '001' ){
			console.log('El ruc de la empresa del sector privado debe terminar con 001');
			$(t).val('');
			$('#alertacedula').fadeIn();
			setTimeout("$('#alertacedula').fadeOut();",3500);
			return false;
		}
	}else if(nat == true){
		if (digitoVerificador != d10){
			console.log('El número de cédula de la persona natural es incorrecto.');
			$(t).val('');
			$('#alertacedula').fadeIn();
			setTimeout("$('#alertacedula').fadeOut();",3500);
			return false;
		}
		if (numero.length >10 && numero.substr(10,3) != '001' ){
			console.log('El ruc de la persona natural debe terminar con 001');
			$(t).val('');
			$('#alertacedula').fadeIn();
			setTimeout("$('#alertacedula').fadeOut();",3500);
			return false;
		}
	}else{
		return true;
	}
}

function guardar(){
	var nuevonombre = $('#nuevonombre').val();
	var nuevacedula = $('#nuevacedula').val();
	var id = $('#idbol').val();
	var asiento = $('#lblasiento').html();
	var concierto = $('#concert').val();
	var localidad = $('#local').val();
	if((nuevonombre == '') || (nuevacedula == '')){
		$('#alertavacio').fadeIn();
		setTimeout("$('#alertavacio').fadeOut();",3500);
	}else{
		$('#botones').fadeOut('slow');
		$('#wait').delay(600).fadeIn('slow');
		$.post('subpages/ajaxasignar.php',{
			id : id, nuevonombre : nuevonombre, nuevacedula : nuevacedula, asiento : asiento, concierto : concierto, localidad : localidad
		}).done(function(response){
			if($.trim(response) == 'ok'){
				setTimeout("window.location = '';",2500);
			}
		});
	}
}

function cancelarmodal(){
	$('#nuevonombre').val('');
	$('#nuevacedula').val('');
	$('#idbol').val('');
	$('#nomantes').val('');
	$('#cedulaantes').val('');
	$('#lblasiento').html('');
	$('#asignar').modal('hide');
}
</script>