<?php
	echo $_SESSION['idDis']."<br>";
	
	
	echo $_SESSION['iduser'];
?>
<input type="hidden" id="data" value="21" />
<div style="margin:10px -10px;">
<script type="text/javascript" src="js/jquery.numeric.js"></script>
	<body>
		
		<div style="background-color:#171A1B;"  >
			
			<div class = 'row'>
				<div class = 'col-md-12'>
					<h3 style = 'padding-top: 10px;padding-bottom: 10px;padding-left: 10px;padding-right: 10px;background-color: #ED1568;color: #fff'>
						CREAR TIPOS DE SOCIOS
					</h3>
				</div>
			</div>

			<div class = 'row'>
				<div class = 'col-xs-3'></div>
				<div class = 'col-xs-5' style = 'color:#fff;'>
					<div class="content">
						<input type = 'text' id = 'tipo_socio' class = 'form-control entero' placeholder = 'Nombre del Tipo de Socio' />

						<input type='hidden' id='id_distribuidor' value='<?php echo $_SESSION['idDis'];?>'>
						<br>
						<?php 
							include 'conexion.php';
						?>
						<br>
						<center><button type="button" class="btn btn-primary" onclick ='guardarDatos()'>Enviar</button></center>
					</div>
				</div>
				<div class = 'col-xs-3'></div>
			</div>

		</div>

	</body>
</div>

<!-- MODAL TIPO DE SOCIO AGREGADO-->
		<div class="modal fade" id="sociook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="aceptarModal()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Alerta...!</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-info" role="alert">
							<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
							&nbsp;Se ha guardado exitosamente su Tipo de Socio.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="aceptaroksocio()">Aceptar</button>
					</div>
				</div>
			</div>
		</div>
<!-- FIN DE MODAL TIPO DE SOCIO AGREGADO-->


<script type="text/javascript">
	function guardarDatos(){
		var tipo_socio = $("#tipo_socio").val();
		var distribuidor = $("#id_distribuidor").val();
		$.post("TipoSocio/recibeaddtiposocio.php", {
			tipo_socio: tipo_socio , distribuidor: distribuidor
		}).done(function(data){
				if($.trim(data) == 'ok'){
					$('#sociook').modal('show');
				//alert('se inserto');
			}
		});
	}

	function aceptaroksocio(){
	$('#sociook').modal('hidden');
	}
</script>
